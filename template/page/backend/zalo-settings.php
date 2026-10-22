<?php include 'header.php'; ?>
<div class="content container-fluid">
  <h1 class="h3 mb-4">Cấu hình đăng nhập Zalo</h1>
  <div class="card"><div class="card-body">
    <form id="zalo-config-form" style="max-width:720px">
      <div class="mb-3"><label for="zalo-app-id">App ID *</label>
        <input class="form-control" id="zalo-app-id" name="app_id" required pattern="[0-9]{1,30}" maxlength="30" value="<?php echo htmlspecialchars($zalo_app_id, ENT_QUOTES, 'UTF-8'); ?>">
      </div>
      <div class="mb-3"><label for="zalo-app-secret">App Secret</label>
        <input class="form-control" id="zalo-app-secret" name="app_secret" type="password" maxlength="255" autocomplete="new-password" <?php echo $zalo_secret_exists ? '' : 'required'; ?>>
        <small id="secret-note" class="text-muted"><?php echo $zalo_secret_exists ? 'Đã có App Secret. Để trống để giữ nguyên; thay App ID cần nhập Secret mới.' : 'Nhập App Secret của ứng dụng Zalo.'; ?></small>
      </div>
      <div class="mb-3"><label for="zalo-callback-url">Callback URL *</label>
        <input class="form-control" id="zalo-callback-url" name="callback_url" type="url" required maxlength="2048" value="<?php echo htmlspecialchars($zalo_callback_url ?: XC_URL.'/page/zalocallback', ENT_QUOTES, 'UTF-8'); ?>">
        <small class="text-muted">Dùng HTTPS và khai báo đúng địa chỉ này trong mục Đăng nhập → Web trên Zalo Developers.</small>
      </div>
      <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($_SESSION['zalo_config_csrf'], ENT_QUOTES, 'UTF-8'); ?>">
      <button class="btn btn-primary" id="save-zalo-config" type="submit">Lưu cấu hình</button>
    </form>
  </div></div>
</div>
<script>
$(function () {
    var busy = false;
    function toast(message, ok) { Swal.fire({toast:true, position:'bottom-end', icon:ok ? 'success':'error', title:message, showConfirmButton:false, timer:4000}); }
    $('#zalo-config-form').on('submit', function (event) {
        event.preventDefault();
        if (busy || !this.reportValidity()) return;
        var secret = $('#zalo-app-secret').val().trim();
        try {
            var url = new URL($('#zalo-callback-url').val().trim());
            if (url.protocol !== 'https:' || url.username || url.password || url.hash || /[\x00-\x20\x7f]/.test(secret)) throw new Error();
        } catch (e) { toast('Callback phải là URL HTTPS hợp lệ; App Secret không chứa khoảng trắng.', false); return; }
        busy = true; $('#save-zalo-config').prop('disabled', true);
        $.ajax({url:<?php echo json_encode(XC_URL.'/api/savezalosettings'); ?>, type:'POST', dataType:'json', data:$(this).serialize(),
            success:function (data) { toast(data.message, data.success); if (data.success) { $('#zalo-app-secret').val('').prop('required', false); $('#secret-note').text('Đã có App Secret. Để trống để giữ nguyên; thay App ID cần nhập Secret mới.'); } },
            error:function () { toast('Không kết nối được máy chủ. Vui lòng thử lại.', false); },
            complete:function () { busy=false; $('#save-zalo-config').prop('disabled', false); }
        });
    });
});
</script>
<?php include 'footer.php'; ?>
