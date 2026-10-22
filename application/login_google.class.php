<?php
/**
 * Google OAuth 2.0 Client.
 * Cấu hình lấy từ hicrm_configs: google_client_id, google_client_secret, google_redirect_uri.
 */
class LoginGoogleException extends RuntimeException {}

class LoginGoogle
{
    private $clientId;
    private $clientSecret;
    private $redirectUri;

    public function __construct()
    {
        $config = general::getInstance();
        $this->clientId = trim($config->get_config('google_client_id'));
        $this->clientSecret = trim($config->get_config('google_client_secret'));
        $redirect = trim($config->get_config('google_redirect_uri'));
        if ($redirect === '') {
            $redirect = XC_URL . '/loginApi/google_callback';
        }
        $this->redirectUri = $redirect;
    }

    public function isConfigured()
    {
        return ($this->clientId !== '' && $this->clientSecret !== '');
    }

    public function begin($page = '/login')
    {
        if (!$this->isConfigured()) {
            throw new LoginGoogleException('Đăng nhập Google chưa được cấu hình Client ID / Secret trong hệ thống.');
        }
        if (!function_exists('curl_init')) {
            throw new LoginGoogleException('Máy chủ chưa bật tiện ích cURL.');
        }

        $state = bin2hex(random_bytes(32));
        $_SESSION['google_oauth'] = array(
            'state'   => $state,
            'created' => time(),
            'page'    => $page
        );

        $params = array(
            'client_id'     => $this->clientId,
            'redirect_uri'  => $this->redirectUri,
            'response_type' => 'code',
            'scope'         => 'openid profile email',
            'state'         => $state,
            'access_type'   => 'online',
            'prompt'        => 'select_account'
        );

        return 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query($params, '', '&', PHP_QUERY_RFC3986);
    }

    public function complete($code, $state)
    {
        $flow = isset($_SESSION['google_oauth']) ? $_SESSION['google_oauth'] : null;
        unset($_SESSION['google_oauth']);

        if (!$flow || !is_string($state) || empty($flow['state']) || !hash_equals($flow['state'], $state) || (time() - $flow['created'] > 600)) {
            throw new LoginGoogleException('Phiên đăng nhập Google đã hết hạn hoặc không hợp lệ. Vui lòng thử lại.');
        }

        if (empty($code) || !is_string($code)) {
            throw new LoginGoogleException('Chưa nhận được mã xác thực từ Google. Vui lòng thử lại.');
        }

        // Đổi code lấy Access Token
        $tokenData = $this->request('https://oauth2.googleapis.com/token', array(
            'Content-Type: application/x-www-form-urlencoded'
        ), array(
            'code'          => $code,
            'client_id'     => $this->clientId,
            'client_secret' => $this->clientSecret,
            'redirect_uri'  => $this->redirectUri,
            'grant_type'    => 'authorization_code'
        ), true);

        if (empty($tokenData['access_token']) || !is_string($tokenData['access_token'])) {
            $msg = isset($tokenData['error_description']) ? $tokenData['error_description'] : 'Không thể lấy mã truy cập từ Google.';
            throw new LoginGoogleException($msg);
        }

        // Lấy thông tin hồ sơ người dùng
        $profile = $this->request('https://www.googleapis.com/oauth2/v3/userinfo', array(
            'Authorization: Bearer ' . $tokenData['access_token']
        ));

        if (empty($profile['sub']) || !is_scalar($profile['sub'])) {
            throw new LoginGoogleException('Không lấy được ID tài khoản từ Google.');
        }

        $id = (string)$profile['sub'];
        $name = isset($profile['name']) && is_string($profile['name']) ? trim($profile['name']) : 'Khách hàng Google';
        $email = isset($profile['email']) && is_string($profile['email']) ? trim($profile['email']) : '';
        $avatar = isset($profile['picture']) && is_string($profile['picture']) ? trim($profile['picture']) : '';

        if (!filter_var($avatar, FILTER_VALIDATE_URL)) {
            $avatar = '';
        }

        return array(
            'id'     => mb_substr($id, 0, 64),
            'name'   => mb_substr($name, 0, 255),
            'email'  => mb_substr($email, 0, 255),
            'avatar' => $avatar
        );
    }

    private function request($url, $headers, $body = null, $isPost = false)
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_TIMEOUT        => 15,
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2
        ));

        if ($isPost) {
            curl_setopt($ch, CURLOPT_POST, true);
            if ($body !== null) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, is_array($body) ? http_build_query($body) : $body);
            }
        }

        $raw = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $result = is_string($raw) ? json_decode($raw, true) : null;
        if ($status !== 200 || !is_array($result)) {
            throw new LoginGoogleException('Lỗi kết nối dịch vụ Google (Mã phản hồi: ' . $status . ').');
        }

        return $result;
    }
}
