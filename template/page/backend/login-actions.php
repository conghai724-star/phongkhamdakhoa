<?php
$loginError = isset($_SESSION['zalo_login_error']) ? $_SESSION['zalo_login_error'] : (isset($_SESSION['social_login_error']) ? $_SESSION['social_login_error'] : '');
$loginSuccess = isset($_SESSION['social_login_success']) ? $_SESSION['social_login_success'] : '';
unset($_SESSION['zalo_login_error'], $_SESSION['social_login_error'], $_SESSION['social_login_success']);
?>
<script>
$(function () {
    var csrf = <?php echo json_encode($_SESSION['login_csrf']); ?>;
    var busy = false;
    function notify(message, success) {
        Swal.fire({toast: true, position: 'bottom-end', icon: success ? 'success' : 'error', title: message, showConfirmButton: false, timer: 4500, timerProgressBar: true});
    }
    function submitLogin(zalo, complete) {
        if (busy) return;
        var account = $.trim($('#email, #phone').first().val() || '');
        var password = $('#password').val() || '';
        if (!zalo && (!account || account.length > 255 || !password || password.length > 1024)) {
            notify('Vui lòng nhập tài khoản và mật khẩu hợp lệ.', false);
            return;
        }
        busy = true;
        $('#btlogin, #btn-login-post, #btn-zalo-login, .js-social-login').prop('disabled', true);
        $.ajax({type: 'POST', url: <?php echo json_encode(XC_URL); ?> + (zalo ? '/loginApi/zalo' : '/api/login'), dataType: 'json',
            data: {csrf: csrf, email: account, password: zalo ? '' : password, action: complete ? 'complete' : 'begin', page: <?php echo json_encode(isset($zaloPublicPage) ? 'public' : 'admin'); ?>},
            success: function (data) {
                notify(data.message || 'Không thể đăng nhập. Vui lòng thử lại.', !!data.success);
                if (data.success) {
                    var url = zalo ? (data.data && data.data.url ? data.data.url : data.url) : data.return_url;
                    setTimeout(function () { window.location.assign(url); }, 600);
                }
            },
            error: function () { notify('Không kết nối được máy chủ. Vui lòng thử lại.', false); },
            complete: function () { busy = false; $('#btlogin, #btn-login-post, #btn-zalo-login, .js-social-login').prop('disabled', false); }
        });
    }
    function startSocial(provider) {
        if (busy) return;
        busy = true;
        $('.js-social-login').prop('disabled', true);
        var targetUrl = <?php echo json_encode(XC_URL); ?> + '/loginApi/' + encodeURIComponent(provider);
        $.ajax({
            type: 'POST',
            url: targetUrl,
            data: {action: 'begin'},
            dataType: 'json',
            success: function (data) {
                if (data.success && data.data && data.data.url) {
                    window.location.assign(data.data.url);
                    return;
                }
                notify(data.message || 'Không thể khởi tạo đăng nhập ' + provider + '.', false);
                busy = false;
                $('.js-social-login').prop('disabled', false);
            },
            error: function () {
                // Fallback to direct navigation so user is never stuck
                window.location.assign(targetUrl);
            }
        });
    }

    $('#btlogin, #btn-login-post').on('click', function (e) { e.preventDefault(); submitLogin(false, false); });
    $('#password').closest('form').on('submit', function (e) { e.preventDefault(); submitLogin(false, false); });
    $('#btn-zalo-login').on('click', function () { startSocial('zalo'); });
    $(document).on('click', '.js-social-login', function (e) {
        e.preventDefault();
        var prov = $(this).data('provider') || 'google';
        startSocial(prov);
    });

    <?php if ($loginError !== ''): ?>
    notify(<?php echo json_encode($loginError, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>, false);
    <?php elseif ($loginSuccess !== ''): ?>
    notify(<?php echo json_encode($loginSuccess, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>, true);
    <?php elseif (isset($_SESSION['zalo_callback'])): ?>
    submitLogin(true, true);
    <?php endif; ?>
});
</script>
