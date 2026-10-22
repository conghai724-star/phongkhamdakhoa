<?php
/** Zalo Social OAuth v4. Configuration is loaded from hicrm_configs; profiles are persisted by apiController. */
class LoginZaloException extends RuntimeException {}

class LoginZalo
{
    private $appId;
    private $appSecret;
    private $callback;

    public function __construct()
    {
        $config = general::getInstance();
        $this->appId = trim($config->get_config('zalo_app_id'));
        $this->appSecret = trim($config->get_config('zalo_app_secret'));
        $this->callback = trim($config->get_config('zalo_callback_url'));
    }

    public function begin($loginPage)
    {
        if (!$this->appId || !$this->appSecret || !function_exists('curl_init')) {
            throw new LoginZaloException('Đăng nhập Zalo chưa được cấu hình. Vui lòng dùng tài khoản và mật khẩu.');
        }
        $callback = $this->callback;
        if (!$callback || !filter_var($callback, FILTER_VALIDATE_URL) || parse_url($callback, PHP_URL_SCHEME) !== 'https') {
            throw new LoginZaloException('Đăng nhập Zalo chưa có địa chỉ xác thực HTTPS hợp lệ.');
        }
        $verifier = rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
        $state = bin2hex(random_bytes(32));
        $_SESSION['zalo_oauth'] = array('state' => $state, 'verifier' => $verifier, 'created' => time(), 'page' => $loginPage);
        unset($_SESSION['zalo_callback']);
        return 'https://oauth.zaloapp.com/v4/permission?' . http_build_query(array(
            'app_id' => $this->appId, 'redirect_uri' => $callback,
            'state' => $state, 'code_challenge' => rtrim(strtr(base64_encode(hash('sha256', $verifier, true)), '+/', '-_'), '=')
        ), '', '&', PHP_QUERY_RFC3986);
    }

    public function complete()
    {
        $flow = isset($_SESSION['zalo_oauth']) ? $_SESSION['zalo_oauth'] : null;
        $callback = isset($_SESSION['zalo_callback']) ? $_SESSION['zalo_callback'] : null;
        unset($_SESSION['zalo_oauth'], $_SESSION['zalo_callback']);
        if (!$flow || !$callback || time() - $flow['created'] > 600 || !is_string($callback['state']) || !hash_equals($flow['state'], $callback['state'])) {
            throw new LoginZaloException('Phiên đăng nhập Zalo đã hết hạn hoặc không hợp lệ. Vui lòng thử lại.');
        }
        if (!empty($callback['error']) || !is_string($callback['code']) || $callback['code'] === '') {
            throw new LoginZaloException('Bạn chưa cấp quyền đăng nhập Zalo. Vui lòng thử lại hoặc dùng mật khẩu.');
        }
        $token = $this->request('https://oauth.zaloapp.com/v4/access_token', array('secret_key: ' . $this->appSecret, 'Content-Type: application/x-www-form-urlencoded'), array(
            'app_id' => $this->appId, 'code' => $callback['code'], 'grant_type' => 'authorization_code', 'code_verifier' => $flow['verifier']
        ));
        if (empty($token['access_token']) || !is_string($token['access_token'])) {
            throw new LoginZaloException('Không thể xác thực với Zalo. Vui lòng đăng nhập lại.');
        }
        $profile = $this->request('https://graph.zalo.me/v2.0/me?fields=id,name,picture', array('access_token: ' . $token['access_token']));
        if (empty($profile['id']) || !is_scalar($profile['id']) || !empty($profile['error'])) {
            throw new LoginZaloException('Không lấy được thông tin tài khoản Zalo. Vui lòng thử lại.');
        }
        $id = (string)$profile['id'];
        if (!preg_match('/^[0-9]{1,64}$/D', $id) || empty($profile['name']) || !is_string($profile['name'])) {
            throw new LoginZaloException('Hồ sơ Zalo thiếu thông tin hợp lệ. Vui lòng cấp quyền và thử lại.');
        }
        $avatar = isset($profile['picture']['data']['url']) ? $profile['picture']['data']['url'] : '';
        if (!is_string($avatar) || !filter_var($avatar, FILTER_VALIDATE_URL) || parse_url($avatar, PHP_URL_SCHEME) !== 'https') $avatar = '';
        return array('id' => $id, 'name' => mb_substr(trim($profile['name']), 0, 255), 'avatar' => $avatar);
    }

    private function request($url, $headers, $body = null)
    {
        if (!function_exists('curl_init')) {
            throw new LoginZaloException('Đăng nhập Zalo chưa sẵn sàng. Vui lòng dùng mật khẩu.');
        }
        $curl = curl_init($url);
        curl_setopt_array($curl, array(CURLOPT_RETURNTRANSFER => true, CURLOPT_CONNECTTIMEOUT => 5, CURLOPT_TIMEOUT => 15,
            CURLOPT_HTTPHEADER => $headers, CURLOPT_SSL_VERIFYPEER => true, CURLOPT_SSL_VERIFYHOST => 2));
        if ($body !== null) {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($body));
        }
        $raw = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $result = is_string($raw) ? json_decode($raw, true) : null;
        if ($status !== 200 || !is_array($result)) {
            throw new LoginZaloException('Không kết nối được Zalo. Vui lòng thử lại sau hoặc dùng mật khẩu.');
        }
        return $result;
    }
}
