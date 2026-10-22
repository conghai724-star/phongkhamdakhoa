<?php
/**
 * Controller chuyên trách xử lý Social Login (Google, Facebook, Zalo) cho Khách hàng.
 * Tách riêng khỏi apiController và pageController.
 */
class loginApiController extends baseController
{
    public function index()
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Cache-Control: no-store');
        echo json_encode(array(
            'success' => true,
            'message' => 'Login API Service sẵn sàng.',
            'providers' => array('google', 'facebook', 'zalo')
        ), JSON_UNESCAPED_UNICODE);
    }

    private function isAjaxRequest()
    {
        return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
            || (isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'], 'application/x-www-form-urlencoded') !== false && !empty($_POST['action']))
            || (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false && strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false);
    }

    /**
     * Khởi tạo hoặc chuyển hướng đăng nhập Google
     */
    public function google()
    {
        header('Cache-Control: no-store');
        require_once __SITE_PATH . '/application/login_google.class.php';

        try {
            $google = new LoginGoogle();
            $authUrl = $google->begin('/login');
            if (!$this->isAjaxRequest()) {
                header('Location: ' . $authUrl);
                exit;
            }
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array(
                'success' => true,
                'message' => 'Đang chuyển đến Google...',
                'data'    => array('url' => $authUrl)
            ), JSON_UNESCAPED_UNICODE);
        } catch (Throwable $e) {
            if (!$this->isAjaxRequest()) {
                $_SESSION['social_login_error'] = $e->getMessage();
                header('Location: ' . XC_URL . '/login');
                exit;
            }
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array(
                'success' => false,
                'message' => $e->getMessage()
            ), JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * Callback tiếp nhận xác thực từ Google
     */
    public function google_callback()
    {
        header('Cache-Control: no-store');
        require_once __SITE_PATH . '/application/login_google.class.php';

        $code  = isset($_GET['code']) && is_string($_GET['code']) ? $_GET['code'] : '';
        $state = isset($_GET['state']) && is_string($_GET['state']) ? $_GET['state'] : '';
        $error = isset($_GET['error']) ? $_GET['error'] : '';

        if ($error !== '' || $code === '') {
            $_SESSION['social_login_error'] = 'Bạn đã hủy đăng nhập bằng Google hoặc xảy ra lỗi xác thực.';
            header('Location: ' . XC_URL . '/login');
            exit;
        }

        try {
            $google = new LoginGoogle();
            $profile = $google->complete($code, $state);
            $redirectUrl = $this->syncCustomer('google', $profile);
            $_SESSION['social_login_success'] = 'Đăng nhập Google thành công!';
            header('Location: ' . $redirectUrl);
            exit;
        } catch (Throwable $e) {
            $_SESSION['social_login_error'] = $e->getMessage();
            header('Location: ' . XC_URL . '/login');
            exit;
        }
    }

    /**
     * Khởi tạo hoặc chuyển hướng đăng nhập Facebook
     */
    public function facebook()
    {
        header('Cache-Control: no-store');
        require_once __SITE_PATH . '/application/login_facebook.class.php';

        try {
            $facebook = new LoginFacebook();
            $authUrl = $facebook->begin('/login');
            if (!$this->isAjaxRequest()) {
                header('Location: ' . $authUrl);
                exit;
            }
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array(
                'success' => true,
                'message' => 'Đang chuyển đến Facebook...',
                'data'    => array('url' => $authUrl)
            ), JSON_UNESCAPED_UNICODE);
        } catch (Throwable $e) {
            if (!$this->isAjaxRequest()) {
                $_SESSION['social_login_error'] = $e->getMessage();
                header('Location: ' . XC_URL . '/login');
                exit;
            }
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array(
                'success' => false,
                'message' => $e->getMessage()
            ), JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * Callback tiếp nhận xác thực từ Facebook
     */
    public function facebook_callback()
    {
        header('Cache-Control: no-store');
        require_once __SITE_PATH . '/application/login_facebook.class.php';

        $code  = isset($_GET['code']) && is_string($_GET['code']) ? $_GET['code'] : '';
        $state = isset($_GET['state']) && is_string($_GET['state']) ? $_GET['state'] : '';
        $error = isset($_GET['error']) ? $_GET['error'] : '';

        if ($error !== '' || $code === '') {
            $_SESSION['social_login_error'] = 'Bạn đã hủy đăng nhập bằng Facebook hoặc xảy ra lỗi xác thực.';
            header('Location: ' . XC_URL . '/login');
            exit;
        }

        try {
            $facebook = new LoginFacebook();
            $profile = $facebook->complete($code, $state);
            $redirectUrl = $this->syncCustomer('facebook', $profile);
            $_SESSION['social_login_success'] = 'Đăng nhập Facebook thành công!';
            header('Location: ' . $redirectUrl);
            exit;
        } catch (Throwable $e) {
            $_SESSION['social_login_error'] = $e->getMessage();
            header('Location: ' . XC_URL . '/login');
            exit;
        }
    }

    /**
     * Khởi tạo đăng nhập Zalo
     */
    public function zalo()
    {
        header('Cache-Control: no-store');
        require_once __SITE_PATH . '/application/login_zalo.class.php';

        try {
            $zalo = new LoginZalo();
            $authUrl = $zalo->begin('/login');
            if (!$this->isAjaxRequest()) {
                header('Location: ' . $authUrl);
                exit;
            }
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array(
                'success' => true,
                'message' => 'Đang chuyển đến Zalo...',
                'data'    => array('url' => $authUrl)
            ), JSON_UNESCAPED_UNICODE);
        } catch (Throwable $e) {
            if (!$this->isAjaxRequest()) {
                $_SESSION['social_login_error'] = $e->getMessage();
                header('Location: ' . XC_URL . '/login');
                exit;
            }
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array(
                'success' => false,
                'message' => $e->getMessage()
            ), JSON_UNESCAPED_UNICODE);
        }
    }

    public function zalologin()
    {
        $this->zalo();
    }

    /**
     * Callback tiếp nhận xác thực từ Zalo
     */
    public function zalo_callback()
    {
        header('Cache-Control: no-store');
        $state = isset($_GET['state']) && is_string($_GET['state']) ? $_GET['state'] : '';
        $code  = isset($_GET['code']) && is_string($_GET['code']) ? $_GET['code'] : '';
        $error = !empty($_GET['error']);

        $flow = isset($_SESSION['zalo_oauth']) ? $_SESSION['zalo_oauth'] : null;
        if (!$flow || $state === '' || !hash_equals($flow['state'], $state) || (time() - $flow['created'] > 600) || $error || $code === '') {
            unset($_SESSION['zalo_oauth'], $_SESSION['zalo_callback']);
            $_SESSION['social_login_error'] = 'Phiên đăng nhập Zalo không hợp lệ hoặc đã bị hủy. Vui lòng thử lại.';
            header('Location: ' . XC_URL . '/login');
            exit;
        }

        $_SESSION['zalo_callback'] = array('state' => $state, 'code' => $code, 'error' => false);

        require_once __SITE_PATH . '/application/login_zalo.class.php';
        try {
            $zalo = new LoginZalo();
            $profile = $zalo->complete();
            $redirectUrl = $this->syncCustomer('zalo', $profile);
            $_SESSION['social_login_success'] = 'Đăng nhập Zalo thành công!';
            header('Location: ' . $redirectUrl);
            exit;
        } catch (Throwable $e) {
            $_SESSION['social_login_error'] = $e->getMessage();
            header('Location: ' . XC_URL . '/login');
            exit;
        }
    }

    /**
     * Đăng xuất phiên khách hàng an toàn
     */
    public function logout()
    {
        unset($_SESSION['customer'], $_SESSION['customer_csrf'], $_SESSION['zalo_oauth'], $_SESSION['google_oauth'], $_SESSION['facebook_oauth']);
        if (!$this->isAjaxRequest()) {
            header('Location: ' . XC_URL . '/login');
            exit;
        }
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(array(
            'success' => true,
            'message' => 'Đã đăng xuất tài khoản thành công.',
            'data'    => array('url' => XC_URL)
        ), JSON_UNESCAPED_UNICODE);
    }

    /**
     * Đồng bộ thông tin hồ sơ và khởi tạo phiên customer
     */
    private function syncCustomer($provider, $profile)
    {
        $columnMap = array(
            'google'   => 'user_google_id',
            'facebook' => 'user_facebook_id',
            'zalo'     => 'user_zalo_id'
        );

        if (!isset($columnMap[$provider])) {
            throw new RuntimeException('Nhà cung cấp đăng nhập không hợp lệ.');
        }

        $col = $columnMap[$provider];
        $socialId = (string)$profile['id'];
        $fullName = mb_substr(trim($profile['name']), 0, 255);
        $email    = isset($profile['email']) ? mb_substr(trim($profile['email']), 0, 255) : '';
        $avatar   = isset($profile['avatar']) ? trim($profile['avatar']) : '';

        // Kết nối cơ sở dữ liệu chuyên biệt
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($conn->connect_errno) {
            throw new RuntimeException('Không thể kết nối đến cơ sở dữ liệu phòng khám.');
        }
        $conn->set_charset('utf8mb4');

        // 1. Kiểm tra tài khoản đã tồn tại theo social id chưa
        $stmt = $conn->prepare("SELECT id, user_status, user_phone, user_fullname FROM hicrm_users WHERE {$col} = ? LIMIT 1");
        $stmt->bind_param('s', $socialId);
        $stmt->execute();
        $existing = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if ($existing && (int)$existing['user_status'] !== 1) {
            $conn->close();
            throw new RuntimeException('Tài khoản đã bị tạm dừng hoạt động. Vui lòng liên hệ phòng khám.');
        }

        if (!$existing) {
            // Tạo tài khoản khách hàng mới (user_group = 0)
            $username = $provider . '_' . $socialId;
            $randomPass = password_hash(bin2hex(random_bytes(32)), PASSWORD_DEFAULT);

            $insertSql = "INSERT INTO hicrm_users ({$col}, user_username, user_password, user_email, user_fullname, user_avatar, user_phone, user_group, user_status) 
                          VALUES (?, ?, ?, ?, ?, ?, NULL, 0, 1) 
                          ON DUPLICATE KEY UPDATE id = id";
            $stmt = $conn->prepare($insertSql);
            $stmt->bind_param('ssssss', $socialId, $username, $randomPass, $email, $fullName, $avatar);
            $stmt->execute();
            $stmt->close();

            // Lấy lại thông tin sau khi insert
            $stmt = $conn->prepare("SELECT id, user_status, user_phone, user_fullname FROM hicrm_users WHERE {$col} = ? LIMIT 1");
            $stmt->bind_param('s', $socialId);
            $stmt->execute();
            $existing = $stmt->get_result()->fetch_assoc();
            $stmt->close();
        } else {
            // Cập nhật họ tên và ảnh đại diện nếu có
            if ($avatar !== '' || $fullName !== '') {
                $updateSql = "UPDATE hicrm_users SET user_fullname = ?, user_avatar = IF(? != '', ?, user_avatar) WHERE id = ? AND user_status = 1";
                $stmt = $conn->prepare($updateSql);
                $stmt->bind_param('sssi', $fullName, $avatar, $avatar, $existing['id']);
                $stmt->execute();
                $stmt->close();
            }
        }

        $conn->close();

        if (!$existing || (int)$existing['user_status'] !== 1) {
            throw new RuntimeException('Không thể hoàn tất xác thực tài khoản. Vui lòng thử lại.');
        }

        // Thiết lập phiên khách hàng an toàn (KHÔNG cấp session user/staff/LoggedIn)
        session_regenerate_id(true);
        unset($_SESSION['user'], $_SESSION['staff'], $_SESSION['LoggedIn']);

        $_SESSION['customer'] = array(
            'id'       => (int)$existing['id'],
            'fullname' => $fullName,
            'phone'    => $existing['user_phone'],
            'email'    => $email,
            'avatar'   => $avatar,
            'provider' => $provider,
            'zalo'     => ($provider === 'zalo')
        );
        $_SESSION['customer_csrf'] = bin2hex(random_bytes(32));

        // Sau khi đăng nhập thành công, chuyển hướng về trang chủ giao diện mới
        $returnUrl = XC_URL;
        if (!empty($_SESSION['login_redirect_url'])) {
            $returnUrl = $_SESSION['login_redirect_url'];
            unset($_SESSION['login_redirect_url']);
        }
        return $returnUrl;
    }
}
