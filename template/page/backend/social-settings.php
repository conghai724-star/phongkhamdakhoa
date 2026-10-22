<?php include 'header.php'; ?>
<div class="content container-fluid">
  <div class="page-header">
    <div class="row">
      <div class="col-sm-6">
        <h3 class="page-title">Cấu hình Đăng nhập Mạng xã hội</h3>
        <ul class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo XC_URL; ?>/admin">Trang chủ</a></li>
          <li class="breadcrumb-item"><a href="<?php echo XC_URL; ?>/admin/setting">Cài đặt</a></li>
          <li class="breadcrumb-item active">Đăng nhập MXH</li>
        </ul>
      </div>
    </div>
  </div>

  <div class="card bg-white mb-4">
    <div class="card-body py-2">
      <ul class="nav nav-tabs nav-tabs-solid nav-justified">
        <li class="nav-item">
          <a class="nav-link active" href="<?php echo XC_URL; ?>/admin/socialsettings"><i data-feather="share-2" class="me-1"></i> Đăng nhập MXH (Google / FB / Zalo)</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo XC_URL; ?>/admin/setting"><i data-feather="settings" class="me-1"></i> Phòng khám và Nhà thuốc</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo XC_URL; ?>/admin/setting?type=change-password"><i data-feather="lock" class="me-1"></i> Đổi mật khẩu</a>
        </li>
      </ul>
    </div>
  </div>

  <div class="card shadow-sm border-0">
    <div class="card-header bg-white border-bottom">
      <ul class="nav nav-tabs card-header-tabs" id="socialTab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active fw-bold" id="google-tab" href="#google-pane" role="tab" aria-controls="google-pane" aria-selected="true">
            <i class="fa-brands fa-google text-danger me-2"></i>Google OAuth
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link fw-bold" id="facebook-tab" href="#facebook-pane" role="tab" aria-controls="facebook-pane" aria-selected="false">
            <i class="fa-brands fa-facebook text-primary me-2"></i>Facebook Login
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link fw-bold" id="zalo-tab" href="#zalo-pane" role="tab" aria-controls="zalo-pane" aria-selected="false">
            <i class="fa-solid fa-comment-dots text-info me-2"></i>Zalo Social
          </a>
        </li>
      </ul>
    </div>

    <div class="card-body p-4">
      <div class="tab-content" id="socialTabContent">

        <!-- 1. GOOGLE CONFIG PANE -->
        <div class="tab-pane show active" id="google-pane" role="tabpanel" aria-labelledby="google-tab">
          <form class="social-config-form" data-provider="google" style="max-width: 720px;">
            <div class="alert alert-info border-0 mb-4" style="background:#f0f7ff; color:#0c4a6e;">
              <i class="fa-solid fa-circle-info me-2"></i>
              Khai báo <strong>Authorized redirect URIs</strong> trên Google Cloud Console (APIs &amp; Services &rarr; Credentials):<br>
              <code><?php echo htmlspecialchars($google_redirect_uri, ENT_QUOTES, 'UTF-8'); ?></code>
            </div>

            <div class="mb-3">
              <label for="google-client-id" class="form-label fw-bold">Client ID *</label>
              <input class="form-control" id="google-client-id" name="client_id" required maxlength="255" value="<?php echo htmlspecialchars($google_client_id, ENT_QUOTES, 'UTF-8'); ?>" placeholder="ví dụ: 1234567890-xxx.apps.googleusercontent.com">
            </div>

            <div class="mb-3">
              <label for="google-client-secret" class="form-label fw-bold">Client Secret <?php echo $google_secret_exists ? '' : '*'; ?></label>
              <input class="form-control" id="google-client-secret" name="client_secret" type="password" maxlength="255" autocomplete="new-password" placeholder="<?php echo $google_secret_exists ? '•••••••••••••••• (Để trống nếu giữ nguyên)' : 'Nhập Client Secret'; ?>" <?php echo $google_secret_exists ? '' : 'required'; ?>>
              <small class="text-muted d-block mt-1"><?php echo $google_secret_exists ? 'Đã có Client Secret trong hệ thống. Để trống nếu giữ nguyên.' : 'Nhập Client Secret do Google Cloud Console cấp.'; ?></small>
            </div>

            <div class="mb-3">
              <label for="google-redirect-uri" class="form-label fw-bold">Redirect URI *</label>
              <input class="form-control" id="google-redirect-uri" name="redirect_uri" required maxlength="2048" value="<?php echo htmlspecialchars($google_redirect_uri, ENT_QUOTES, 'UTF-8'); ?>">
            </div>

            <input type="hidden" name="provider" value="google">
            <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($_SESSION['social_config_csrf'], ENT_QUOTES, 'UTF-8'); ?>">
            <button class="btn btn-primary px-4" type="submit"><i class="fa-solid fa-floppy-disk me-2"></i>Lưu cấu hình Google</button>
          </form>
        </div>

        <!-- 2. FACEBOOK CONFIG PANE -->
        <div class="tab-pane" id="facebook-pane" role="tabpanel" aria-labelledby="facebook-tab" style="display:none;">
          <form class="social-config-form" data-provider="facebook" style="max-width: 720px;">
            <div class="alert alert-info border-0 mb-4" style="background:#f0f7ff; color:#0c4a6e;">
              <i class="fa-solid fa-circle-info me-2"></i>
              Khai báo <strong>Valid OAuth Redirect URIs</strong> trên Meta for Developers (Facebook Login &rarr; Cài đặt):<br>
              <code><?php echo htmlspecialchars($facebook_redirect_uri, ENT_QUOTES, 'UTF-8'); ?></code>
            </div>

            <div class="mb-3">
              <label for="fb-app-id" class="form-label fw-bold">App ID *</label>
              <input class="form-control" id="fb-app-id" name="app_id" required maxlength="50" value="<?php echo htmlspecialchars($facebook_app_id, ENT_QUOTES, 'UTF-8'); ?>" placeholder="ví dụ: 123456789012345">
            </div>

            <div class="mb-3">
              <label for="fb-app-secret" class="form-label fw-bold">App Secret <?php echo $facebook_secret_exists ? '' : '*'; ?></label>
              <input class="form-control" id="fb-app-secret" name="app_secret" type="password" maxlength="255" autocomplete="new-password" placeholder="<?php echo $facebook_secret_exists ? '•••••••••••••••• (Để trống nếu giữ nguyên)' : 'Nhập App Secret'; ?>" <?php echo $facebook_secret_exists ? '' : 'required'; ?>>
              <small class="text-muted d-block mt-1"><?php echo $facebook_secret_exists ? 'Đã có App Secret trong hệ thống. Để trống nếu giữ nguyên.' : 'Nhập App Secret do Meta Developers cấp.'; ?></small>
            </div>

            <div class="mb-3">
              <label for="fb-redirect-uri" class="form-label fw-bold">Redirect URI *</label>
              <input class="form-control" id="fb-redirect-uri" name="redirect_uri" required maxlength="2048" value="<?php echo htmlspecialchars($facebook_redirect_uri, ENT_QUOTES, 'UTF-8'); ?>">
            </div>

            <input type="hidden" name="provider" value="facebook">
            <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($_SESSION['social_config_csrf'], ENT_QUOTES, 'UTF-8'); ?>">
            <button class="btn btn-primary px-4" type="submit"><i class="fa-solid fa-floppy-disk me-2"></i>Lưu cấu hình Facebook</button>
          </form>
        </div>

        <!-- 3. ZALO CONFIG PANE -->
        <div class="tab-pane" id="zalo-pane" role="tabpanel" aria-labelledby="zalo-tab" style="display:none;">
          <form class="social-config-form" data-provider="zalo" style="max-width: 720px;">
            <div class="alert alert-info border-0 mb-4" style="background:#f0f7ff; color:#0c4a6e;">
              <i class="fa-solid fa-circle-info me-2"></i>
              Khai báo <strong>Callback URL</strong> trên Zalo Developers (Đăng nhập &rarr; Web):<br>
              <code><?php echo htmlspecialchars($zalo_callback_url, ENT_QUOTES, 'UTF-8'); ?></code>
            </div>

            <div class="mb-3">
              <label for="zalo-app-id" class="form-label fw-bold">App ID *</label>
              <input class="form-control" id="zalo-app-id" name="app_id" required maxlength="50" value="<?php echo htmlspecialchars($zalo_app_id, ENT_QUOTES, 'UTF-8'); ?>">
            </div>

            <div class="mb-3">
              <label for="zalo-app-secret" class="form-label fw-bold">App Secret <?php echo $zalo_secret_exists ? '' : '*'; ?></label>
              <input class="form-control" id="zalo-app-secret" name="app_secret" type="password" maxlength="255" autocomplete="new-password" placeholder="<?php echo $zalo_secret_exists ? '•••••••••••••••• (Để trống nếu giữ nguyên)' : 'Nhập App Secret'; ?>" <?php echo $zalo_secret_exists ? '' : 'required'; ?>>
              <small class="text-muted d-block mt-1"><?php echo $zalo_secret_exists ? 'Đã có App Secret trong hệ thống. Để trống nếu giữ nguyên.' : 'Nhập App Secret do Zalo cấp.'; ?></small>
            </div>

            <div class="mb-3">
              <label for="zalo-callback-url" class="form-label fw-bold">Callback URL *</label>
              <input class="form-control" id="zalo-callback-url" name="callback_url" required maxlength="2048" value="<?php echo htmlspecialchars($zalo_callback_url, ENT_QUOTES, 'UTF-8'); ?>">
            </div>

            <input type="hidden" name="provider" value="zalo">
            <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($_SESSION['social_config_csrf'], ENT_QUOTES, 'UTF-8'); ?>">
            <button class="btn btn-primary px-4" type="submit"><i class="fa-solid fa-floppy-disk me-2"></i>Lưu cấu hình Zalo</button>
          </form>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
$(function () {
    var busy = false;

    // Chuyển tab độc lập, không phụ thuộc phiên bản Bootstrap JS
    $('#socialTab a').on('click', function (e) {
        e.preventDefault();
        var targetPaneId = $(this).attr('href');
        $('#socialTab .nav-link').removeClass('active').attr('aria-selected', 'false');
        $(this).addClass('active').attr('aria-selected', 'true');
        $('#socialTabContent .tab-pane').removeClass('show active').hide();
        $(targetPaneId).addClass('show active').show();

        if (window.history && window.history.replaceState) {
            window.history.replaceState(null, null, targetPaneId);
        }
    });

    // Mở đúng tab nếu có hash hoặc param ?tab=
    var currentHash = window.location.hash;
    var urlParams = new URLSearchParams(window.location.search);
    var tabParam = urlParams.get('tab');
    if (tabParam) {
        currentHash = '#' + tabParam + '-pane';
    }
    if (currentHash && $('#socialTab a[href="' + currentHash + '"]').length) {
        $('#socialTab a[href="' + currentHash + '"]').trigger('click');
    }

    function toast(message, ok) {
        Swal.fire({
            toast: true,
            position: 'bottom-end',
            icon: ok ? 'success' : 'error',
            title: message,
            showConfirmButton: false,
            timer: 4500,
            timerProgressBar: true
        });
    }

    $('.social-config-form').on('submit', function (event) {
        event.preventDefault();
        var form = $(this);
        if (busy) return;

        var submitBtn = form.find('button[type="submit"]');
        var originalBtnHtml = submitBtn.html();

        busy = true;
        submitBtn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin me-2"></i>Đang lưu...');

        $.ajax({
            url: <?php echo json_encode(XC_URL . '/api/savesocialsettings'); ?>,
            type: 'POST',
            dataType: 'json',
            data: form.serialize(),
            success: function (data) {
                toast(data.message, data.success);
                if (data.success) {
                    var passInput = form.find('input[type="password"]');
                    passInput.val('');
                    passInput.prop('required', false);
                    passInput.attr('placeholder', '•••••••••••••••• (Để trống nếu giữ nguyên)');
                    form.find('small.text-muted').text('Đã có secret trong hệ thống. Để trống nếu giữ nguyên.');
                    form.find('label[for$="-secret"]').html('App Secret');
                }
            },
            error: function (xhr) {
                var msg = 'Không thể kết nối đến máy chủ. Vui lòng thử lại.';
                try {
                    var resp = JSON.parse(xhr.responseText);
                    if (resp && resp.message) msg = resp.message;
                } catch (e) {}
                toast(msg, false);
            },
            complete: function () {
                busy = false;
                submitBtn.prop('disabled', false).html(originalBtnHtml);
            }
        });
    });
});
</script>
<?php include 'footer.php'; ?>

