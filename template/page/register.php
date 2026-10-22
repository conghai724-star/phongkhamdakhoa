<?php 
if (empty($_SESSION['register_csrf'])) { 
    $_SESSION['register_csrf'] = bin2hex(random_bytes(32)); 
} 
?>
<?php include_once "header_new.php"; ?>
</section>

<div id="breadcrumbs">
   <div class="ctn">
      <div id="crumbs">
         <a href="<?php echo XC_URL; ?>"><i class="fa-solid fa-house"></i> Trang chủ</a> 
         <span>/</span> 
         <a class="current">Đăng ký</a>
      </div>
   </div>
</div>

<div class="ctn" style="margin-top: 24px; margin-bottom: 50px;">
   <div style="max-width: 520px; margin: 0 auto; background: #ffffff; border-radius: 16px; box-shadow: 0 10px 30px rgba(19, 70, 125, 0.08); border: 1px solid #e2e8f0; overflow: hidden;">
      
      <!-- Card Header -->
      <div style="background: linear-gradient(135deg, #13467d 0%, #1e5ba0 100%); padding: 26px 24px; text-align: center; color: #ffffff;">
         <h1 style="font-size: 21px; font-weight: 700; margin: 0 0 6px 0; color: #ffffff;">
            Đăng ký tài khoản
         </h1>
         <p style="margin: 0; font-size: 13.5px; opacity: 0.92; color: #ffffff;">
            Tạo tài khoản để theo dõi lịch khám, đơn thuốc và hồ sơ cá nhân
         </p>
      </div>

      <!-- Card Body -->
      <div style="padding: 26px 24px;">
         
         <!-- Nút Đăng nhập Nhanh Mạng xã hội -->
         <div style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 20px;">
            <a href="<?php echo XC_URL;?>/loginApi/zalo" class="btn w-100 js-social-login" data-provider="zalo" 
               style="background: #0068ff; color: #ffffff; border-radius: 10px; font-weight: 600; padding: 11px 16px; display: flex; align-items: center; justify-content: center; gap: 10px; text-decoration: none; font-size: 14.5px; box-shadow: 0 2px 6px rgba(0,104,255,0.25);">
               <i class="fa-solid fa-comment-dots" style="font-size: 17px;"></i>
               <span>Đăng ký nhanh bằng Zalo</span>
            </a>

            <a href="<?php echo XC_URL;?>/loginApi/google" class="btn w-100 js-social-login" data-provider="google" 
               style="background: #ffffff; color: #374151; border: 1.5px solid #d1d5db; border-radius: 10px; font-weight: 600; padding: 11px 16px; display: flex; align-items: center; justify-content: center; gap: 10px; text-decoration: none; font-size: 14.5px; box-shadow: 0 2px 4px rgba(0,0,0,0.04);">
               <svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true">
                  <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                  <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                  <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                  <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
               </svg>
               <span>Đăng ký nhanh bằng Google</span>
            </a>

            <a href="<?php echo XC_URL;?>/loginApi/facebook" class="btn w-100 js-social-login" data-provider="facebook" 
               style="background: #1877f2; color: #ffffff; border-radius: 10px; font-weight: 600; padding: 11px 16px; display: flex; align-items: center; justify-content: center; gap: 10px; text-decoration: none; font-size: 14.5px; box-shadow: 0 2px 6px rgba(24,119,242,0.25);">
               <i class="fa-brands fa-facebook" style="font-size: 17px;"></i>
               <span>Đăng ký nhanh bằng Facebook</span>
            </a>
         </div>

         <!-- Đường kẻ ngăn cách -->
         <div style="display: flex; align-items: center; text-align: center; margin: 20px 0; color: #94a3b8; font-size: 13px;">
            <div style="flex: 1; border-bottom: 1px solid #e2e8f0;"></div>
            <span style="padding: 0 12px; font-weight: 500;">hoặc điền thông tin</span>
            <div style="flex: 1; border-bottom: 1px solid #e2e8f0;"></div>
         </div>

         <!-- Form đăng ký -->
         <form id="register-form" style="display: flex; flex-direction: column; gap: 14px;">
            <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($_SESSION['register_csrf'], ENT_QUOTES, 'UTF-8'); ?>">

            <div>
               <label for="reg-fullname" style="display: block; font-weight: 600; font-size: 13.5px; margin-bottom: 6px; color: #1e293b;">
                  Họ và tên <span style="color: #ef4444;">*</span>
               </label>
               <input type="text" name="fullname" id="reg-fullname" required maxlength="100" autocomplete="name" 
                  placeholder="Ví dụ: Nguyễn Văn An"
                  style="width: 100%; box-sizing: border-box; padding: 11px 14px; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 14.5px; color: #0f172a; outline: none;">
            </div>

            <div>
               <label for="reg-phone" style="display: block; font-weight: 600; font-size: 13.5px; margin-bottom: 6px; color: #1e293b;">
                  Số điện thoại <span style="color: #ef4444;">*</span>
               </label>
               <input type="tel" name="phone" id="reg-phone" required maxlength="15" autocomplete="tel" 
                  placeholder="Ví dụ: 0912345678"
                  style="width: 100%; box-sizing: border-box; padding: 11px 14px; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 14.5px; color: #0f172a; outline: none;">
            </div>

            <div>
               <label for="reg-email" style="display: block; font-weight: 600; font-size: 13.5px; margin-bottom: 6px; color: #1e293b;">
                  Địa chỉ Email <span style="font-weight: 400; color: #64748b; font-size: 12.5px;">(Không bắt buộc)</span>
               </label>
               <input type="email" name="email" id="reg-email" maxlength="255" autocomplete="email" 
                  placeholder="Ví dụ: email@gmail.com"
                  style="width: 100%; box-sizing: border-box; padding: 11px 14px; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 14.5px; color: #0f172a; outline: none;">
            </div>

            <div>
               <label for="reg-password" style="display: block; font-weight: 600; font-size: 13.5px; margin-bottom: 6px; color: #1e293b;">
                  Mật khẩu <span style="color: #ef4444;">*</span>
               </label>
               <input type="password" name="password" id="reg-password" required minlength="6" maxlength="1000" autocomplete="new-password" 
                  placeholder="Tối thiểu 6 ký tự"
                  style="width: 100%; box-sizing: border-box; padding: 11px 14px; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 14.5px; color: #0f172a; outline: none;">
            </div>

            <div>
               <label for="reg-repassword" style="display: block; font-weight: 600; font-size: 13.5px; margin-bottom: 6px; color: #1e293b;">
                  Xác nhận mật khẩu <span style="color: #ef4444;">*</span>
               </label>
               <input type="password" name="repassword" id="reg-repassword" required minlength="6" maxlength="1000" autocomplete="new-password" 
                  placeholder="Nhập lại mật khẩu"
                  style="width: 100%; box-sizing: border-box; padding: 11px 14px; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 14.5px; color: #0f172a; outline: none;">
            </div>

            <div style="font-size: 12.5px; color: #64748b; line-height: 1.5; margin-top: 2px;">
               Bằng việc bấm Đăng ký, bạn đồng ý với Quy định bảo mật &amp; Điều khoản dịch vụ của Phòng khám Trường Cao đẳng Kon Tum.
            </div>

            <button class="btn w-100" id="btn-register-submit" type="submit" 
               style="background: #13467d; color: #ffffff; border: none; border-radius: 10px; padding: 12px; font-size: 15px; font-weight: 600; cursor: pointer; margin-top: 6px; box-shadow: 0 4px 12px rgba(19,70,125,0.25);">
               Đăng ký tài khoản
            </button>

            <div style="text-align: center; margin-top: 10px; font-size: 13.5px; color: #64748b;">
               Đã có tài khoản? <a href="<?php echo XC_URL;?>/login" style="color: #13467d; font-weight: 600; text-decoration: none;">Đăng nhập ngay</a>
            </div>
         </form>

      </div>
   </div>
</div>

</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(function () {
    var isSubmitting = false;

    function notify(msg, isSuccess) {
        if (typeof Swal !== 'undefined' && Swal.fire) {
            Swal.fire({
                toast: true,
                position: 'bottom-end',
                icon: isSuccess ? 'success' : 'error',
                title: msg,
                showConfirmButton: false,
                timer: 4500,
                timerProgressBar: true
            });
        } else {
            alert(msg);
        }
    }

    $('#register-form').on('submit', function (e) {
        e.preventDefault();
        if (isSubmitting) return;

        var fullname   = $.trim($('#reg-fullname').val());
        var phone      = $.trim($('#reg-phone').val()).replace(/[\s.\-]/g, '').replace(/^(?:\+84|84)/, '0');
        var email      = $.trim($('#reg-email').val());
        var password   = $('#reg-password').val();
        var repassword = $('#reg-repassword').val();
        var csrf       = $('input[name="csrf"]').val();

        if (fullname.length < 2) {
            notify('Vui lòng nhập họ và tên (tối thiểu 2 ký tự).', false);
            $('#reg-fullname').focus();
            return;
        }

        var phoneRegex = /^0[35789][0-9]{8}$/;
        if (!phoneRegex.test(phone)) {
            notify('Vui lòng nhập số điện thoại di động Việt Nam hợp lệ (10 số, bắt đầu bằng 03, 05, 07, 08, 09).', false);
            $('#reg-phone').focus();
            return;
        }

        if (password.length < 6) {
            notify('Mật khẩu phải có tối thiểu 6 ký tự.', false);
            $('#reg-password').focus();
            return;
        }

        if (password !== repassword) {
            notify('Mật khẩu xác nhận không khớp. Vui lòng kiểm tra lại.', false);
            $('#reg-repassword').focus();
            return;
        }

        isSubmitting = true;
        var $btn = $('#btn-register-submit');
        var originalBtnText = $btn.html();
        $btn.prop('disabled', true).text('Đang xử lý đăng ký...');

        $.ajax({
            type: 'POST',
            url: <?php echo json_encode(XC_URL . '/api/register'); ?>,
            data: {
                csrf: csrf,
                fullname: fullname,
                phone: phone,
                email: email,
                password: password,
                repassword: repassword
            },
            dataType: 'json',
            success: function (res) {
                if (res && res.success) {
                    notify(res.message || 'Đăng ký tài khoản thành công!', true);
                    setTimeout(function () {
                        window.location.assign(res.return_url || <?php echo json_encode(XC_URL); ?>);
                    }, 1200);
                } else {
                    notify((res && res.message) ? res.message : 'Đăng ký không thành công. Vui lòng kiểm tra lại thông tin.', false);
                    isSubmitting = false;
                    $btn.prop('disabled', false).html(originalBtnText);
                }
            },
            error: function () {
                notify('Không thể kết nối đến máy chủ. Vui lòng thử lại sau.', false);
                isSubmitting = false;
                $btn.prop('disabled', false).html(originalBtnText);
            }
        });
    });

    // Social login click handler
    $(document).on('click', '.js-social-login', function (e) {
        e.preventDefault();
        var prov = $(this).data('provider') || 'google';
        var targetUrl = <?php echo json_encode(XC_URL); ?> + '/loginApi/' + encodeURIComponent(prov);
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
                window.location.assign(targetUrl);
            },
            error: function () {
                window.location.assign(targetUrl);
            }
        });
    });
});
</script>

<?php include "footer_new.php"; ?>