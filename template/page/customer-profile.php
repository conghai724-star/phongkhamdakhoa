<?php include 'header_new.php'; ?>
</section>

<div id="breadcrumbs">
   <div class="ctn">
      <div id="crumbs">
         <a href="<?php echo XC_URL; ?>"><i class="fa-solid fa-house"></i> Trang chủ</a> 
         <span>/</span> 
         <a class="current">Thông tin tài khoản</a>
      </div>
   </div>
</div>

<div class="ctn" style="margin-top: 24px; margin-bottom: 50px;">
   <div style="max-width: 580px; margin: 0 auto; background: #ffffff; border-radius: 16px; box-shadow: 0 10px 30px rgba(19, 70, 125, 0.08); border: 1px solid #e2e8f0; overflow: hidden;">
      
      <!-- Card Header -->
      <div style="background: linear-gradient(135deg, #13467d 0%, #1e5ba0 100%); padding: 28px 24px; text-align: center; color: #ffffff;">
         <div style="width: 76px; height: 76px; border-radius: 50%; background: #ffffff; margin: 0 auto 14px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.15); overflow: hidden; border: 3px solid rgba(255,255,255,0.85);">
            <?php if (!empty($_SESSION['customer']['avatar'])): ?>
               <img src="<?php echo htmlspecialchars($_SESSION['customer']['avatar'], ENT_QUOTES, 'UTF-8'); ?>" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
            <?php else: ?>
               <i class="fa-solid fa-user" style="font-size: 34px; color: #13467d;"></i>
            <?php endif; ?>
         </div>
         <h1 style="font-size: 20px; font-weight: 700; margin: 0 0 6px 0; color: #ffffff;">
            <?php echo htmlspecialchars($customer->user_fullname ?: ($_SESSION['customer']['fullname'] ?? 'Khách hàng'), ENT_QUOTES, 'UTF-8'); ?>
         </h1>
         <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.18); padding: 4px 12px; border-radius: 20px; font-size: 13px; font-weight: 500;">
            <?php 
               $provider = !empty($_SESSION['customer']['provider']) ? $_SESSION['customer']['provider'] : 'zalo';
               if ($provider === 'zalo'): ?>
                  <i class="fa-solid fa-comment-dots"></i> Đăng nhập qua Zalo
               <?php elseif ($provider === 'google'): ?>
                  <i class="fa-brands fa-google"></i> Đăng nhập qua Google
               <?php elseif ($provider === 'facebook'): ?>
                  <i class="fa-brands fa-facebook"></i> Đăng nhập qua Facebook
               <?php else: ?>
                  <i class="fa-solid fa-shield-check"></i> Tài khoản đã xác thực
               <?php endif; ?>
         </div>
      </div>

      <!-- Card Body -->
      <div style="padding: 28px 24px;">
         <div style="background: #f8fafc; border-left: 4px solid #13467d; padding: 12px 16px; border-radius: 6px; margin-bottom: 22px;">
            <p style="margin: 0; font-size: 13.5px; line-height: 1.5; color: #475569;">
               Quý khách vui lòng kiểm tra và bổ sung <strong>số điện thoại di động</strong> để phòng khám liên hệ tư vấn kết quả khám và xác nhận đơn hàng khi cần.
            </p>
         </div>

         <form id="customer-phone-form" style="display: flex; flex-direction: column; gap: 16px;">
            <div>
               <label for="customer-phone" style="display: block; font-weight: 600; font-size: 14px; margin-bottom: 6px; color: #1e293b;">
                  Số điện thoại di động <span style="color: #ef4444;">*</span>
               </label>
               <div style="position: relative;">
                  <span style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 15px;">
                     <i class="fa-solid fa-phone"></i>
                  </span>
                  <input id="customer-phone" name="phone" type="tel" required maxlength="20" autocomplete="tel" inputmode="tel" 
                     value="<?php echo htmlspecialchars((string)($customer->user_phone ?: ($_SESSION['customer']['phone'] ?? '')), ENT_QUOTES, 'UTF-8'); ?>" 
                     placeholder="Ví dụ: 0912345678"
                     style="width: 100%; box-sizing: border-box; padding: 11px 14px 11px 40px; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 15px; font-weight: 600; color: #0f172a; outline: none; transition: all 0.2s ease;">
               </div>
               <span style="display: block; font-size: 12.5px; color: #64748b; margin-top: 5px;">
                  Nhập số điện thoại 10 chữ số (đầu số 03, 05, 07, 08, 09).
               </span>
            </div>

            <button id="save-customer-phone" type="submit" 
               style="background: #13467d; color: #ffffff; border: none; border-radius: 10px; padding: 12px 18px; font-size: 15px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 12px rgba(19,70,125,0.25); transition: all 0.2s ease;">
               <i class="fa-solid fa-floppy-disk"></i>
               <span>Lưu thông tin</span>
            </button>
         </form>

         <!-- Action Links -->
         <div style="margin-top: 24px; padding-top: 20px; border-top: 1px solid #f1f5f9; display: flex; flex-wrap: wrap; gap: 10px; justify-content: space-between; align-items: center;">
            <a href="<?php echo XC_URL; ?>" 
               style="color: #13467d; text-decoration: none; font-size: 14px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;">
               <i class="fa-solid fa-arrow-left"></i> Quay lại trang chủ
            </a>

            <div style="display: flex; gap: 12px; align-items: center;">
               <a href="<?php echo XC_URL; ?>/gio-hang.html" 
                  style="color: #475569; text-decoration: none; font-size: 14px; font-weight: 500; display: inline-flex; align-items: center; gap: 6px;">
                  <i class="fa-solid fa-cart-shopping"></i> Giỏ hàng
               </a>

               <button id="customer-logout" type="button" 
                  style="background: none; border: none; color: #ef4444; font-size: 14px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; padding: 0;">
                  <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
               </button>
            </div>
         </div>
      </div>
   </div>
</div>

</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(function () {
    var busy = false;
    function toast(message, ok) { 
        Swal.fire({
            toast: true, 
            position: 'bottom-end', 
            icon: ok ? 'success' : 'error', 
            title: message, 
            showConfirmButton: false, 
            timer: 3500,
            timerProgressBar: true
        }); 
    }

    $('#customer-phone-form').on('submit', function (event) {
        event.preventDefault();
        var phone = $.trim($('#customer-phone').val()).replace(/[\s.\-]/g, '').replace(/^(?:\+84|84)/, '0');
        if (!/^0[35789][0-9]{8}$/.test(phone)) { 
            toast('Vui lòng nhập số điện thoại di động Việt Nam hợp lệ (10 số).', false); 
            return; 
        }
        if (busy) return;
        busy = true; 
        $('#save-customer-phone').prop('disabled', true).css('opacity', '0.7');
        $.ajax({
            url: <?php echo json_encode(XC_URL . '/api/customerphone'); ?>, 
            type: 'POST', 
            dataType: 'json',
            data: {
                phone: phone, 
                csrf: <?php echo json_encode($_SESSION['customer_csrf']); ?>
            },
            success: function (data) { 
                toast(data.message, data.success); 
                if (data.success) {
                    setTimeout(function () { 
                        window.location.assign(data.data && data.data.url ? data.data.url : <?php echo json_encode(XC_URL); ?>); 
                    }, 800); 
                }
            },
            error: function () { 
                toast('Không kết nối được máy chủ. Vui lòng thử lại.', false); 
            },
            complete: function () { 
                busy = false; 
                $('#save-customer-phone').prop('disabled', false).css('opacity', '1'); 
            }
        });
    });

    $('#customer-logout').on('click', function () {
        if (busy) return;
        busy = true;
        $.ajax({
            url: <?php echo json_encode(XC_URL . '/api/customerlogout'); ?>, 
            type: 'POST', 
            dataType: 'json', 
            data: {
                csrf: <?php echo json_encode($_SESSION['customer_csrf']); ?>
            },
            success: function (data) { 
                toast(data.message || 'Đã đăng xuất.', data.success); 
                setTimeout(function () { 
                    window.location.assign(data.data && data.data.url ? data.data.url : <?php echo json_encode(XC_URL); ?>); 
                }, 600); 
            },
            error: function () { 
                toast('Không thể đăng xuất. Vui lòng thử lại.', false); 
                busy = false;
            }
        });
    });
});
</script>

<?php include 'footer_new.php'; ?>
