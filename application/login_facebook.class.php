<?php
/**
 * Facebook Graph API OAuth Client.
 * Cấu hình lấy từ hicrm_configs: facebook_app_id, facebook_app_secret, facebook_redirect_uri.
 */
class LoginFacebookException extends RuntimeException {}

class LoginFacebook
{
    private $appId;
    private $appSecret;
    private $redirectUri;
    private $graphVersion = 'v19.0';

    public function __construct()
    {
        $config = general::getInstance();
        $this->appId = trim($config->get_config('facebook_app_id'));
        $this->appSecret = trim($config->get_config('facebook_app_secret'));
        $redirect = trim($config->get_config('facebook_redirect_uri'));
        if ($redirect === '') {
            $redirect = XC_URL . '/loginApi/facebook_callback';
        }
        $this->redirectUri = $redirect;
    }

    public function isConfigured()
    {
        return ($this->appId !== '' && $this->appSecret !== '');
    }

    public function begin($page = '/login')
    {
        if (!$this->isConfigured()) {
            throw new LoginFacebookException('Đăng nhập Facebook chưa được cấu hình App ID / Secret trong hệ thống.');
        }
        if (!function_exists('curl_init')) {
            throw new LoginFacebookException('Máy chủ chưa bật tiện ích cURL.');
        }

        $state = bin2hex(random_bytes(32));
        $_SESSION['facebook_oauth'] = array(
            'state'   => $state,
            'created' => time(),
            'page'    => $page
        );

        $params = array(
            'client_id'     => $this->appId,
            'redirect_uri'  => $this->redirectUri,
            'state'         => $state,
            'scope'         => 'public_profile,email',
            'response_type' => 'code'
        );

        return 'https://www.facebook.com/' . $this->graphVersion . '/dialog/oauth?' . http_build_query($params, '', '&', PHP_QUERY_RFC3986);
    }

    public function complete($code, $state)
    {
        $flow = isset($_SESSION['facebook_oauth']) ? $_SESSION['facebook_oauth'] : null;
        unset($_SESSION['facebook_oauth']);

        if (!$flow || !is_string($state) || empty($flow['state']) || !hash_equals($flow['state'], $state) || (time() - $flow['created'] > 600)) {
            throw new LoginFacebookException('Phiên đăng nhập Facebook đã hết hạn hoặc không hợp lệ. Vui lòng thử lại.');
        }

        if (empty($code) || !is_string($code)) {
            throw new LoginFacebookException('Bạn chưa cấp quyền đăng nhập từ Facebook.');
        }

        // Đổi code lấy Access Token
        $tokenUrl = 'https://graph.facebook.com/' . $this->graphVersion . '/oauth/access_token?' . http_build_query(array(
            'client_id'     => $this->appId,
            'client_secret' => $this->appSecret,
            'redirect_uri'  => $this->redirectUri,
            'code'          => $code
        ));

        $tokenData = $this->request($tokenUrl, array());
        if (empty($tokenData['access_token']) || !is_string($tokenData['access_token'])) {
            $msg = isset($tokenData['error']['message']) ? $tokenData['error']['message'] : 'Không lấy được mã truy cập Facebook.';
            throw new LoginFacebookException($msg);
        }

        // Lấy thông tin tài khoản Facebook
        $profileUrl = 'https://graph.facebook.com/' . $this->graphVersion . '/me?' . http_build_query(array(
            'fields'       => 'id,name,email,picture.type(large)',
            'access_token' => $tokenData['access_token']
        ));

        $profile = $this->request($profileUrl, array());
        if (empty($profile['id']) || !is_scalar($profile['id'])) {
            throw new LoginFacebookException('Không lấy được ID người dùng từ Facebook.');
        }

        $id = (string)$profile['id'];
        $name = isset($profile['name']) && is_string($profile['name']) ? trim($profile['name']) : 'Khách hàng Facebook';
        $email = isset($profile['email']) && is_string($profile['email']) ? trim($profile['email']) : '';
        $avatar = isset($profile['picture']['data']['url']) && is_string($profile['picture']['data']['url']) ? $profile['picture']['data']['url'] : '';

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

    private function request($url, $headers)
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

        $raw = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $result = is_string($raw) ? json_decode($raw, true) : null;
        if ($status !== 200 || !is_array($result)) {
            $msg = isset($result['error']['message']) ? $result['error']['message'] : ('Lỗi kết nối Facebook (HTTP ' . $status . ')');
            throw new LoginFacebookException($msg);
        }

        return $result;
    }
}
