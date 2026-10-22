<?php if (empty($_SESSION['login_csrf'])) { $_SESSION['login_csrf'] = bin2hex(random_bytes(32)); } ?>
<?php include_once "header_new.php"; ?>
</section>

<div id="breadcrumbs">
   <div class="ctn">
      <div id="crumbs">
         <a href="<?php echo XC_URL; ?>"><i class="fa-solid fa-house"></i> Trang chủ</a> 
         <span>/</span> 
         <a class="current">Đăng nhập</a>
      </div>
   </div>
</div>

<div class="ctn" style="margin-top: 24px; margin-bottom: 50px;">
   <div style="max-width: 480px; margin: 0 auto; background: #ffffff; border-radius: 16px; box-shadow: 0 10px 30px rgba(19, 70, 125, 0.08); border: 1px solid #e2e8f0; overflow: hidden;">
      
      <!-- Card Header -->
      <div style="background: linear-gradient(135deg, #13467d 0%, #1e5ba0 100%); padding: 24px; text-align: center; color: #ffffff;">
         <h1 style="font-size: 20px; font-weight: 700; margin: 0 0 6px 0; color: #ffffff;">
            Đăng nhập tài khoản
         </h1>
         <p style="margin: 0; font-size: 13.5px; opacity: 0.9; color: #ffffff;">
            Chào mừng bạn đến với Phòng khám Trường Cao đẳng Kon Tum
         </p>
      </div>

      <!-- Card Body -->
      <div style="padding: 24px;">
         
         <!-- Nút Đăng nhập Nhanh Mạng xã hội -->
         <div style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 20px;">
            <a href="<?php echo XC_URL;?>/loginApi/zalo" class="btn w-100 js-social-login" data-provider="zalo" 
               style="background: #0068ff; color: #ffffff; border-radius: 10px; font-weight: 600; padding: 11px 16px; display: flex; align-items: center; justify-content: center; gap: 10px; text-decoration: none; font-size: 14.5px; box-shadow: 0 2px 6px rgba(0,104,255,0.25);">
               <i class="fa-solid fa-comment-dots" style="font-size: 17px;"></i>
               <span>Đăng nhập bằng Zalo</span>
            </a>

            <a href="<?php echo XC_URL;?>/loginApi/google" class="btn w-100 js-social-login" data-provider="google" 
               style="background: #ffffff; color: #374151; border: 1.5px solid #d1d5db; border-radius: 10px; font-weight: 600; padding: 11px 16px; display: flex; align-items: center; justify-content: center; gap: 10px; text-decoration: none; font-size: 14.5px; box-shadow: 0 2px 4px rgba(0,0,0,0.04);">
               <svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true">
                  <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                  <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                  <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                  <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
               </svg>
               <span>Đăng nhập bằng Google</span>
            </a>

            <a href="<?php echo XC_URL;?>/loginApi/facebook" class="btn w-100 js-social-login" data-provider="facebook" 
               style="background: #1877f2; color: #ffffff; border-radius: 10px; font-weight: 600; padding: 11px 16px; display: flex; align-items: center; justify-content: center; gap: 10px; text-decoration: none; font-size: 14.5px; box-shadow: 0 2px 6px rgba(24,119,242,0.25);">
               <i class="fa-brands fa-facebook" style="font-size: 17px;"></i>
               <span>Đăng nhập bằng Facebook</span>
            </a>
         </div>

         <!-- Đường kẻ ngăn cách -->
         <div style="display: flex; align-items: center; text-align: center; margin: 18px 0; color: #94a3b8; font-size: 13px;">
            <div style="flex: 1; border-bottom: 1px solid #e2e8f0;"></div>
            <span style="padding: 0 12px; font-weight: 500;">hoặc dùng tài khoản</span>
            <div style="flex: 1; border-bottom: 1px solid #e2e8f0;"></div>
         </div>

         <!-- Form đăng nhập thông thường -->
         <form action="#" id="login-form" style="display: flex; flex-direction: column; gap: 14px;">
            <div>
               <label for="phone" style="display: block; font-weight: 600; font-size: 13.5px; margin-bottom: 6px; color: #1e293b;">
                  Tài khoản / Email / Số điện thoại
               </label>
               <input type="text" name="phone" id="phone" required maxlength="255" autocomplete="username" 
                  placeholder="Nhập email hoặc số điện thoại"
                  style="width: 100%; box-sizing: border-box; padding: 11px 14px; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 14.5px; color: #0f172a; outline: none;">
            </div>

            <div>
               <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                  <label for="password" style="font-weight: 600; font-size: 13.5px; color: #1e293b; margin: 0;">
                     Mật khẩu
                  </label>
                  <a href="<?php echo XC_URL;?>/quen-mat-khau.html" style="font-size: 12.5px; color: #13467d; text-decoration: none; font-weight: 500;">
                     Quên mật khẩu?
                  </a>
               </div>
               <input type="password" name="password" id="password" required maxlength="1024" autocomplete="current-password" 
                  placeholder="Nhập mật khẩu"
                  style="width: 100%; box-sizing: border-box; padding: 11px 14px; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 14.5px; color: #0f172a; outline: none;">
            </div>

            <button class="btn w-100" id="btn-login-post" type="submit" 
               style="background: #13467d; color: #ffffff; border: none; border-radius: 10px; padding: 12px; font-size: 15px; font-weight: 600; cursor: pointer; margin-top: 6px; box-shadow: 0 4px 12px rgba(19,70,125,0.25);">
               Đăng nhập
            </button>

            <div style="text-align: center; margin-top: 8px; font-size: 13.5px; color: #64748b;">
               Chưa có tài khoản? <a href="<?php echo XC_URL;?>/dang-ky.html" style="color: #13467d; font-weight: 600; text-decoration: none;">Đăng ký ngay</a>
            </div>
         </form>

      </div>
   </div>
</div>

</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php $zaloPublicPage = true; include __DIR__.'/backend/login-actions.php'; ?>
<?php include "footer_new.php"; ?>