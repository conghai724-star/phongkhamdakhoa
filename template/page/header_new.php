<?php include "config.php";
$cartEnabled = $this->helper->is_cart_enabled();
if($cartEnabled && empty($_SESSION['cart_csrf'])) $_SESSION['cart_csrf'] = bin2hex(random_bytes(32));
$cartCount = $cartEnabled ? $this->helper->get_cart_count() : 0;
$customerLoggedIn = !empty($_SESSION['customer']['id']);
$customerAccountUrl = XC_URL.($customerLoggedIn ? '/page/customerprofile' : '/login');
$customerAccountLabel = $customerLoggedIn ? 'Tài khoản' : 'Đăng nhập';
if (empty($_SESSION['login_csrf'])) $_SESSION['login_csrf'] = bin2hex(random_bytes(32));
// Icon SVG nội tuyến và trạng thái tài khoản dùng chung cho desktop/mobile.
$headerUserIcon = '<svg class="header-action-icon" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 21v-2a8 8 0 0 1 16 0v2"/></svg>';
$headerCartIcon = '<svg class="header-action-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M2 3h3l2.3 12h12l2-8H6"/><circle cx="9" cy="20" r="1"/><circle cx="18" cy="20" r="1"/></svg>';
if ($customerLoggedIn) {
    $customerAccountLabel = !empty($_SESSION['customer']['fullname']) ? trim($_SESSION['customer']['fullname']) : (!empty($_SESSION['customer']['phone']) ? trim($_SESSION['customer']['phone']) : 'Tài khoản');
    if (empty($_SESSION['customer_csrf'])) $_SESSION['customer_csrf'] = bin2hex(random_bytes(32));
}
$customerAccountLabel = htmlspecialchars($customerAccountLabel, ENT_QUOTES, 'UTF-8');
$headerAccountDropdown = $customerLoggedIn ? '<div class="header-account-dropdown" hidden><a href="'.htmlspecialchars($customerAccountUrl, ENT_QUOTES, 'UTF-8').'">Tài khoản của tôi</a><button type="button" class="js-header-logout">Đăng xuất</button></div>' : '';
?>
<!doctype html>
<html lang="vi" prefix="og: http://ogp.me/ns#" class="no-js">
   <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
   <head>
      <meta charset="UTF-8">
      <link href="<?php echo $template_path; ?>/assets/images/logo.png" type="image/x-icon" rel="shortcut icon">
      <link href="<?php echo $template_path; ?>/assets/images/logo.png" rel="apple-touch-icon-precomposed">
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
      <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
      <meta property="zalo-platform-site-verification" content="IFICTv_H5dL4eSDQajDiRL7Dwcgzkp4tDp8s" />
      <meta name="zalo-platform-site-verification" content="IFICTv_H5dL4eSDQajDiRL7Dwcgzkp4tDp8s" />
      <link rel="stylesheet" href="<?php echo $template_path; ?>/assets/themes/dkcd/style3447.css?v=1790304724">
      <title>Phòng khám Đa khoa và Nhà thuốc Trường Cao đẳng Kon Tum</title>
      <link rel="canonical" href="index.html" />
      <meta property="og:locale" content="vi_VN" />
      <meta property="og:type" content="website" />
      <meta property="og:title" content="Phòng khám Đa khoa và Nhà thuốc Trường Cao đẳng Kon Tum" />
      <meta property="og:url" content="index.html" />
      <meta property="og:site_name" content="Phòng khám Đa khoa và Nhà thuốc Trường Cao đẳng Kon Tum" />
      <meta name="twitter:card" content="summary_large_image" />
      <meta name="twitter:title" content="Phòng khám Đa khoa và Nhà thuốc Trường Cao đẳng Kon Tum" />
      <!-- / Yoast SEO plugin. -->
      <link rel='dns-prefetch' href='http://s.w.org/' />
      <style type="text/css">
         img.wp-smiley,
         img.emoji {
         display: inline !important;
         border: none !important;
         box-shadow: none !important;
         height: 1em !important;
         width: 1em !important;
         margin: 0 .07em !important;
         vertical-align: -0.1em !important;
         background: none !important;
         padding: 0 !important;
         }
      </style>
      <link rel='stylesheet' href="<?php echo $template_path; ?>/assets/cwp_toc/assets/css/cwp-toc.css" media='all' />
      <link rel='stylesheet' href="<?php echo $template_path; ?>/assets/pkvs-hide-category/assets/css/style.css" media='all' />
      <link rel='stylesheet' href="<?php echo $template_path; ?>/assets/sc_boai/assets/style8a54.css?ver=1.0.0" media='all' />
      <link rel='stylesheet' href="<?php echo $template_path; ?>/assets/themes/dkcd/normalize20b9.css?ver=1.0.2" media='all' />
      <link rel='stylesheet' href="<?php echo $template_path; ?>/assets/wpcomp-quiz/assets/css/style.css" media='all' />
      <link rel='stylesheet' href="<?php echo $template_path; ?>/assets/wpmini-script-injector/assets/css/style.css" media='all' />
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
      <style>
         #headerTop > .ctn{display:flex;align-items:center;justify-content:space-between;gap:12px}
         .site-cart-floating{position:fixed;right:16px;bottom:18px;z-index:999;display:none;align-items:center;gap:10px;padding:14px 16px;border-radius:999px;background:linear-gradient(135deg,#155191,#1e426f);color:#fff!important;font-weight:800;box-shadow:0 18px 35px rgba(21,81,145,.3)}
         .site-cart-floating .cart-badge{min-width:24px;height:24px;padding:0 7px;border-radius:999px;background:#fff;color:#155191;font-size:12px;display:inline-flex;align-items:center;justify-content:center}
         
         /* Desktop Header & Menu Custom Styles */
         #mainMenu ul#mainmenu > li > a {
            transition: color 0.2s ease;
         }
         #mainMenu ul#mainmenu > li:hover > a,
         #mainMenu ul#mainmenu > li.current-menu-item > a,
         #mainMenu ul#mainmenu > li.current_page_item > a {
            color: #1760a5 !important;
         }
         #mainMenu ul.sub-menu {
            border-top: 3px solid #1760a5 !important;
         }
         #mainMenu ul.sub-menu li a:hover {
            background-color: #f0f6fc !important;
            color: #1760a5 !important;
         }

         /* =========================================================
            BANNER TOP CHUẨN MÀU THEO BANNER GỐC (MOBILE <= 991px)
            ========================================================= */
         .lc-banner-top-mobile {
            display: none;
         }

         @media (max-width: 991px){
            .site-cart-menu-item{display:none !important;}
            .site-cart-floating{display:none !important;}
            body.menu-open {
               overflow: hidden !important;
            }

            #bannerTop .banner-pc-view,
            #header {
               display: none !important;
            }

            #bannerTop {
               position: sticky !important;
               top: 0 !important;
               z-index: 10000 !important;
               width: 100% !important;
            }

            .lc-banner-top-mobile {
               display: flex !important;
               align-items: center !important;
               justify-content: space-between !important;
               width: 100% !important;
               min-height: 58px !important;
               padding: 6px 10px !important;
               box-sizing: border-box !important;
               background: linear-gradient(90deg, #13467d 0%, #1a426e 55%, #463b46 85%, #594144 100%) !important;
               box-shadow: 0 3px 12px rgba(19, 70, 125, 0.35) !important;
               gap: 8px !important;
            }

            .lc-hamburger-btn {
               background: rgba(255, 255, 255, 0.16) !important;
               border: 1px solid rgba(255, 255, 255, 0.3) !important;
               padding: 0 !important;
               margin: 0 !important;
               width: 38px !important;
               height: 38px !important;
               min-width: 38px !important;
               flex: 0 0 38px !important;
               border-radius: 50% !important;
               display: flex !important;
               align-items: center !important;
               justify-content: center !important;
               color: #ffffff !important;
               font-size: 18px !important;
               cursor: pointer !important;
               outline: none !important;
               box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15) !important;
               transition: all 0.2s ease !important;
            }
            .lc-hamburger-btn:active {
               transform: none !important;
               background: rgba(255, 255, 255, 0.28) !important;
            }

            .lc-brand-center {
               display: flex !important;
               align-items: center !important;
               justify-content: center !important;
               gap: 8px !important;
               flex: 1 1 auto !important;
               min-width: 0 !important;
               text-decoration: none !important;
               overflow: hidden !important;
            }
            .lc-brand-logo {
               width: 38px !important;
               height: 38px !important;
               min-width: 38px !important;
               flex: 0 0 38px !important;
               border-radius: 50% !important;
               background: #ffffff !important;
               padding: 2px !important;
               box-sizing: border-box !important;
               border: 1.5px solid rgba(255, 255, 255, 0.95) !important;
               box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2) !important;
               display: flex !important;
               align-items: center !important;
               justify-content: center !important;
            }
            .lc-brand-logo img {
               width: 100% !important;
               height: 100% !important;
               object-fit: contain !important;
               border-radius: 50% !important;
               display: block !important;
            }
            .lc-brand-text {
               display: flex !important;
               flex-direction: column !important;
               justify-content: center !important;
               text-align: left !important;
               min-width: 0 !important;
               line-height: 1.18 !important;
            }
            .lc-brand-title {
               color: #ffffff !important;
               font-size: 11.5px !important;
               font-weight: 700 !important;
               white-space: nowrap !important;
               overflow: hidden !important;
               text-overflow: ellipsis !important;
               letter-spacing: 0.15px !important;
               text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3) !important;
            }
            .lc-brand-college {
               color: #ffffff !important;
               font-size: 13.5px !important;
               font-weight: 800 !important;
               white-space: nowrap !important;
               overflow: hidden !important;
               text-overflow: ellipsis !important;
               text-transform: uppercase !important;
               letter-spacing: 0.3px !important;
               text-shadow: 0 1px 3px rgba(0, 0, 0, 0.35) !important;
            }
            .lc-brand-address {
               color: #dbeafe !important;
               font-size: 9.5px !important;
               font-weight: 500 !important;
               white-space: nowrap !important;
               overflow: hidden !important;
               text-overflow: ellipsis !important;
               display: flex !important;
               align-items: center !important;
               gap: 3px !important;
               opacity: 0.95 !important;
               margin-top: 1px !important;
            }
            .lc-brand-address i {
               font-size: 8.5px !important;
               color: #ff9800 !important;
            }

            .lc-cart-btn {
               width: 38px !important;
               height: 38px !important;
               min-width: 38px !important;
               flex: 0 0 38px !important;
               border-radius: 50% !important;
               background: rgba(255, 255, 255, 0.16) !important;
               border: 1px solid rgba(255, 255, 255, 0.3) !important;
               display: flex !important;
               align-items: center !important;
               justify-content: center !important;
               position: relative !important;
               color: #ffffff !important;
               font-size: 16px !important;
               text-decoration: none !important;
               box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15) !important;
               transition: all 0.2s ease !important;
            }
            .lc-cart-btn:active {
               transform: none !important;
               background: rgba(255, 255, 255, 0.28) !important;
            }
            .lc-cart-btn i {
               color: #ffffff !important;
            }
            .lc-cart-badge {
               position: absolute !important;
               top: -3px !important;
               right: -3px !important;
               min-width: 17px !important;
               height: 17px !important;
               line-height: 15px !important;
               border-radius: 999px !important;
               background: #e36928 !important;
               color: #ffffff !important;
               font-size: 10px !important;
               font-weight: 700 !important;
               text-align: center !important;
               padding: 0 4px !important;
               box-sizing: border-box !important;
               border: 2px solid #ffffff !important;
               box-shadow: 0 2px 5px rgba(0, 0, 0, 0.25) !important;
            }

            /* =========================================================
               DRAWER MENU MOBILE ACCORDION (HEADER CÓ LOGO + AUTH)
               ========================================================= */
            #menuM {
               position: fixed !important;
               top: 0 !important;
               left: 0 !important;
               width: 315px !important;
               max-width: 86vw !important;
               height: 100vh !important;
               height: 100dvh !important;
               background: #ffffff !important;
               z-index: 20000 !important;
               transform: translateX(-100%) !important;
               transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1) !important;
               box-shadow: 8px 0 30px rgba(0, 0, 0, 0.15) !important;
               display: flex !important;
               flex-direction: column !important;
               overflow: hidden !important;
            }
            #menuM.in {
               transform: translateX(0) !important;
            }
            #ovl-menuM {
               position: fixed !important;
               inset: 0 !important;
               z-index: 19999 !important;
               background: rgba(15, 23, 42, 0.5) !important;
               backdrop-filter: blur(4px) !important;
               -webkit-backdrop-filter: blur(4px) !important;
               opacity: 0;
               visibility: hidden;
               transition: opacity 0.3s ease, visibility 0.3s ease !important;
            }
            #ovl-menuM.show {
               opacity: 1 !important;
               visibility: visible !important;
            }

            /* Header bên trong Drawer Menu: Logo + Auth + Nút Đóng */
            #menuM-head {
               display: flex !important;
               align-items: center !important;
               justify-content: space-between !important;
               padding: 10px 12px !important;
               background: #ffffff !important;
               border-bottom: 1px solid #f1f5f9 !important;
               flex-shrink: 0 !important;
               gap: 8px !important;
            }
            .menuM-left-brand {
               display: flex !important;
               align-items: center !important;
               flex-shrink: 0 !important;
            }
            .menuM-drawer-logo {
               width: 36px !important;
               height: 36px !important;
               min-width: 36px !important;
               border-radius: 50% !important;
               background: #ffffff !important;
               border: 1.5px solid #dbeafe !important;
               box-shadow: 0 2px 6px rgba(21, 81, 145, 0.12) !important;
               display: flex !important;
               align-items: center !important;
               justify-content: center !important;
               padding: 2px !important;
               box-sizing: border-box !important;
            }
            .menuM-drawer-logo img {
               width: 100% !important;
               height: 100% !important;
               object-fit: contain !important;
               border-radius: 50% !important;
               display: block !important;
            }

            .menuM-auth-group {
               display: flex !important;
               align-items: center !important;
               justify-content: center !important;
               gap: 5px !important;
               flex: 1 !important;
               overflow: hidden !important;
            }
            .menuM-btn-auth {
               display: inline-flex !important;
               align-items: center !important;
               justify-content: center !important;
               gap: 4px !important;
               font-size: 11.5px !important;
               font-weight: 700 !important;
               padding: 6px 9px !important;
               border-radius: 999px !important;
               text-decoration: none !important;
               white-space: nowrap !important;
               transition: all 0.2s ease !important;
            }
            /* Khi chưa đăng nhập */
            .menuM-btn-login {
               background: linear-gradient(135deg, #155191 0%, #1e426f 100%) !important;
               color: #ffffff !important;
               box-shadow: 0 2px 6px rgba(21, 81, 145, 0.25) !important;
            }
            .menuM-btn-login:active {
               transform: translateY(1px) !important;
               opacity: 0.9 !important;
            }
            .menuM-btn-register {
               background: #eff6ff !important;
               color: #155191 !important;
               border: 1px solid #bfdbfe !important;
            }
            .menuM-btn-register:active {
               background: #dbeafe !important;
            }
            /* Khi đã đăng nhập */
            .menuM-btn-user {
               background: #f0f7ff !important;
               color: #155191 !important;
               border: 1px solid #cfe2fe !important;
               max-width: 115px !important;
               overflow: hidden !important;
               text-overflow: ellipsis !important;
            }
            .menuM-btn-logout {
               background: #fff1f2 !important;
               color: #e11d48 !important;
               border: 1px solid #fecdd3 !important;
               padding: 6px 8px !important;
            }

            #menuM-cls {
               width: 32px !important;
               height: 32px !important;
               min-width: 32px !important;
               border-radius: 50% !important;
               background: #f8fafc !important;
               border: 1px solid #e2e8f0 !important;
               color: #64748b !important;
               display: flex !important;
               align-items: center !important;
               justify-content: center !important;
               font-size: 14px !important;
               cursor: pointer !important;
               transition: all 0.2s ease !important;
               padding: 0 !important;
            }
            #menuM-cls:active {
               background: #fee2e2 !important;
               color: #ef4444 !important;
               transform: scale(0.92) !important;
            }

            /* Thân Menu cuộn mượt mà */
            .menuCustom {
               flex: 1 !important;
               overflow-y: auto !important;
               -webkit-overflow-scrolling: touch !important;
               padding: 8px 0 !important;
            }
            .m-nav-list {
               list-style: none !important;
               padding: 0 !important;
               margin: 0 !important;
            }
            .m-nav-item {
               border-bottom: 1px solid #f8fafc !important;
            }
            .m-nav-link {
               display: flex !important;
               align-items: center !important;
               justify-content: space-between !important;
               padding: 13px 18px !important;
               color: #334155 !important;
               font-size: 13.5px !important;
               font-weight: 600 !important;
               text-decoration: none !important;
               transition: background 0.2s ease, color 0.2s ease !important;
            }
            .m-nav-link .m-link-text {
               display: flex !important;
               align-items: center !important;
               gap: 12px !important;
            }
            .m-nav-link .m-link-text i {
               font-size: 16px !important;
               color: #94a3b8 !important;
               width: 20px !important;
               text-align: center !important;
               transition: color 0.2s ease !important;
            }
            .m-nav-item.active > .m-nav-link,
            .m-nav-link:active {
               background: #f0f7ff !important;
               color: #155191 !important;
            }
            .m-nav-item.active > .m-nav-link .m-link-text i,
            .m-nav-link:active .m-link-text i {
               color: #155191 !important;
            }

            /* Mũi tên Accordion */
            .m-toggle-arrow {
               font-size: 12px !important;
               color: #94a3b8 !important;
               transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), color 0.2s ease !important;
            }
            .m-nav-item.open > .m-nav-link .m-toggle-arrow {
               transform: rotate(180deg) !important;
               color: #155191 !important;
            }

            /* Danh sách Menu con trượt mở mượt mà */
            .m-sub-list {
               list-style: none !important;
               padding: 0 !important;
               margin: 0 !important;
               background: #f8fafc !important;
               max-height: 0 !important;
               overflow: hidden !important;
               transition: max-height 0.35s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.25s ease !important;
               opacity: 0 !important;
            }
            .m-nav-item.open > .m-sub-list {
               max-height: 350px !important;
               opacity: 1 !important;
            }
            .m-sub-link {
               display: flex !important;
               align-items: center !important;
               gap: 8px !important;
               padding: 11px 18px 11px 50px !important;
               color: #475569 !important;
               font-size: 13px !important;
               font-weight: 500 !important;
               text-decoration: none !important;
               border-left: 2px solid transparent !important;
               transition: all 0.2s ease !important;
            }
            .m-sub-link:before {
               content: '•';
               color: #cbd5e1;
               font-size: 14px;
            }
            .m-sub-link:active,
            .m-sub-link.active {
               color: #155191 !important;
               background: #eef5fc !important;
               border-left-color: #155191 !important;
               font-weight: 600 !important;
            }
            .m-sub-link:active:before,
            .m-sub-link.active:before {
               color: #155191 !important;
            }
         }

         @media (max-width: 380px) {
            .lc-brand-title {
               font-size: 10.5px !important;
            }
            .lc-brand-college {
               font-size: 12px !important;
            }
            .lc-brand-address {
               font-size: 8.5px !important;
            }
            .lc-brand-logo {
               width: 32px !important;
               height: 32px !important;
               min-width: 32px !important;
               flex: 0 0 32px !important;
            }
            .menuM-btn-auth {
               font-size: 10.5px !important;
               padding: 5px 7px !important;
            }
         }
      </style>

      <!-- Banner Top: Hiển thị ảnh trên PC, hiển thị thanh thương hiệu chuẩn màu banner trên Mobile -->
      <div id="bannerTop">
         <!-- Giao diện PC: Banner ảnh gốc -->
         <a href="#" class="banner-pc-view is_pc">
            <picture>
               <source media="(min-width: 768px)" srcset="<?php echo $template_path; ?>/assets/themes/dkcd/img/banner/banner_top.png" loading="lazy">
               <img src="<?php echo $template_path; ?>/assets/themes/dkcd/img/banner_top.png" alt="Phòng khám chất lượng cao &#8211; Phòng khám đa khoa cao đẳng Kon Tum" width="1920" height="120" loading="lazy" style="width: 100%; height: auto;" />
            </picture>
         </a>

         <!-- Giao diện Mobile: Thanh thương hiệu chuẩn phong cách Long Châu (Menu + Logo & Tên đầy đủ + Giỏ hàng) -->
         <div class="lc-banner-top-mobile is_mobi">
            <button type="button" id="mainMenu-btn" class="lc-hamburger-btn" aria-label="Mở menu">
               <i class="fa-solid fa-bars"></i>
            </button>

            <a href="<?php echo XC_URL; ?>" class="lc-brand-center" title="Phòng khám Đa khoa và Nhà thuốc Trường Cao đẳng Kon Tum">
               <div class="lc-brand-logo">
                  <img src="<?php echo $template_path; ?>/assets/images/logo.png" alt="Logo Phòng khám CĐ Kon Tum">
               </div>
               <div class="lc-brand-text">
                  <span class="lc-brand-title">PHÒNG KHÁM ĐA KHOA VÀ NHÀ THUỐC</span>
                  <span class="lc-brand-college">TRƯỜNG CAO ĐẲNG KON TUM</span>
                  <span class="lc-brand-address">
                     <i class="fa-solid fa-location-dot"></i>
                     <?php echo $this->helper->get_config('site_address'); ?>
                  </span>
               </div>
            </a>

            <div class="lc-mobile-actions">
               <div class="header-account-wrap">
                  <a href="<?php echo $customerLoggedIn ? htmlspecialchars($customerAccountUrl, ENT_QUOTES, 'UTF-8') : 'javascript:void(0);'; ?>" class="lc-account-btn <?php echo $customerLoggedIn ? 'js-header-account' : 'js-account-login'; ?>" aria-label="<?php echo $customerAccountLabel; ?>" title="<?php echo $customerAccountLabel; ?>" aria-haspopup="<?php echo $customerLoggedIn ? 'true' : 'dialog'; ?>" aria-expanded="false">
                     <?php echo $headerUserIcon; ?>
                  </a>
                  <?php echo $headerAccountDropdown; ?>
               </div>
               <?php if($cartEnabled){ ?>
               <a href="<?php echo XC_URL; ?>/gio-hang.html" class="lc-cart-btn site-cart-link" aria-label="Giỏ hàng" title="Giỏ hàng">
                  <?php echo $headerCartIcon; ?>
                  <span class="lc-cart-badge cart-badge js-cart-count"><?php echo $cartCount; ?></span>
               </a>
               <?php } ?>
            </div>
         </div>
      </div>

      <!-- Header Desktop (Chỉ hiển thị trên PC) -->
      <header id="header" class="is_pc">
         <div id="headerTop">
            <div class="ctn">
               <div id="headerTop-hotline">
                  <span>
                  <i id="ftIc-1" class="allicon"></i>
                  <strong><?php echo $this->helper->get_config('site_address'); ?></strong> </span>
                  <span> <i class="fas fa-phone-alt"></i>
                  Hotline tư vấn: <b><a href="tel:<?php echo $this->helper->get_config('site_phone'); ?>"><?php echo $this->helper->get_config('site_phone'); ?></a></b></span>
               </div>

            </div>
         </div>
         <div id="headerMid">
            <div class="ctn">
               <div id="headerMid-wrp" class="row">
                  <nav id="mainMenu">
                     <ul id="mainmenu">
                        <li class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-13"><a href="<?php echo XC_URL;?>"><i class="fa fa-home"></i></a></li>
                        <li class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-has-children menu-item-4511">
                           <a href="#">Giới thiệu</a>
                           <ul class="sub-menu">
                              <li class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-5121"><a href="<?php echo XC_URL; ?>/gioi-thieu/1-ve-chung-toi.html">Về chúng tôi</a></li>
                              <li class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-5122"><a href="<?php echo XC_URL; ?>/gioi-thieu/3-co-cau-to-chuc.html">Cơ cấu tổ chức</a></li>
                              <li class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-5124"><a href="<?php echo XC_URL; ?>/gioi-thieu/2-co-so-ha-tang.html">Cơ sở hạ tầng</a></li>
                           </ul>
                        </li>
                        <li class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-has-children menu-item-4511">
                           <a href="#">Dịch vụ phòng khám</a>
                           <ul class="sub-menu">
                              <li class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-5121"><a href="<?php echo $this->helper->permalink('6','services'); ?>">Khám chữa bệnh dịch vụ</a></li>
                              <li class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-5122"><a href="<?php echo $this->helper->permalink('7','services'); ?>">Khám chữa bệnh BHYT</a></li>
                           </ul>
                        </li>
                       
                        <li class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-has-children menu-item-4511">
                           <a href="#">Nhà thuốc</a>
                           <ul class="sub-menu">
                              <li class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-5121"><a href="<?php echo XC_URL; ?>/gioi-thieu/5-gioi-thieu-nha-thuoc.html">Giới thiệu nhà thuốc</a></li>
                              <li class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-5122"><a href="<?php echo XC_URL; ?>/nha-thuoc.html">Danh mục sản phẩm</a></li>
                              <li class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-5122"><a href="<?php echo XC_URL; ?>/gioi-thieu/6-chinh-sach-ban-hang.html">Chính sách bán hàng</a></li>
                           </ul>
                        </li>
                        
                        <li class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-38039"><a href="<?php echo XC_URL; ?>/doi-ngu-bac-si.html">Bác sĩ</a></li>
                        <li class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-38039"><a href="<?php echo XC_URL; ?>/lich-cong-tac.html">Lịch công tác</a></li>
                        <li class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-38039"><a href="<?php echo XC_URL; ?>/tin-tuc-su-kien.html">Tin tức & Sự kiện</a></li>
                        <li class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-38039"><a href="<?php echo XC_URL; ?>/lien-he.html">Liên hệ</a></li>
                        <li class="menu-item header-user-actions-item">
                           <div class="header-user-actions-group">
                              <div class="header-account-wrap">
                                 <a class="site-account-link <?php echo $customerLoggedIn ? 'js-header-account' : 'js-account-login'; ?>" href="<?php echo $customerLoggedIn ? htmlspecialchars($customerAccountUrl, ENT_QUOTES, 'UTF-8') : 'javascript:void(0);'; ?>" title="<?php echo $customerAccountLabel; ?>" aria-haspopup="<?php echo $customerLoggedIn ? 'true' : 'dialog'; ?>" aria-expanded="false">
                                    <?php echo $headerUserIcon; ?>
                                    <span class="header-account-label"><?php echo $customerAccountLabel; ?></span>
                                 </a>
                                 <?php echo $headerAccountDropdown; ?>
                              </div>
                              <?php if($cartEnabled){ ?>
                              <a href="<?php echo XC_URL; ?>/gio-hang.html" class="site-cart-link" aria-label="Giỏ hàng">
                                 <?php echo $headerCartIcon; ?> <span>Giỏ hàng</span> <span class="cart-badge js-cart-count"><?php echo $cartCount; ?></span>
                              </a>
                              <?php } ?>
                           </div>
                        </li>
                     </ul>
                  </nav>
               </div>
            </div>
         </div>
      </header>

      <!-- Drawer Menu Mobile (Có Logo + Đăng nhập/Giỏ hàng ở đầu trang + Accordion mượt mà) -->
      <div id="ovl-menuM"></div>
      <aside id="menuM" class="is_mobi" aria-label="Menu di động">
         <div id="menuM-wrp">
            <div id="menuM-head">
               <!-- Logo bên trái header drawer -->
               <div class="menuM-left-brand">
                  <a href="<?php echo XC_URL; ?>" class="menuM-drawer-logo" title="Trang chủ">
                     <img src="<?php echo $template_path; ?>/assets/images/logo.png" alt="Logo">
                  </a>
               </div>

               <!-- Cụm Đăng nhập & Giỏ hàng cùng hàng với logo -->
               <div class="menuM-auth-group">
                  <a href="<?php echo $customerLoggedIn ? htmlspecialchars($customerAccountUrl, ENT_QUOTES, 'UTF-8') : 'javascript:void(0);'; ?>" class="menuM-btn-auth menuM-btn-login <?php echo $customerLoggedIn ? '' : 'js-account-login'; ?>" title="<?php echo $customerAccountLabel; ?>">
                     <i class="fa-solid fa-circle-user" aria-hidden="true"></i>
                     <span><?php echo $customerLoggedIn ? 'Tài khoản' : 'Đăng nhập'; ?></span>
                  </a>
                  <?php if($cartEnabled){ ?>
                  <a href="<?php echo XC_URL; ?>/gio-hang.html" class="menuM-btn-auth menuM-btn-cart site-cart-link" title="Giỏ hàng">
                     <i class="fa-solid fa-cart-shopping" aria-hidden="true"></i>
                     <span>Giỏ hàng</span>
                     <span class="cart-badge js-cart-count"><?php echo $cartCount; ?></span>
                  </a>
                  <?php } ?>
               </div>

               <!-- Nút đóng bên phải -->
               <button type="button" id="menuM-cls" aria-label="Đóng menu">
                  <i class="fa-solid fa-xmark"></i>
               </button>
            </div>

            <div class="menuCustom">
               <ul class="m-nav-list">
                  <li class="m-nav-item active">
                     <a href="<?php echo XC_URL; ?>" class="m-nav-link">
                        <span class="m-link-text"><i class="fa-solid fa-house"></i> Trang chủ</span>
                     </a>
                  </li>

                  <!-- Mục Giới thiệu (Accordion) -->
                  <li class="m-nav-item has-sub">
                     <a href="javascript:void(0)" class="m-nav-link js-toggle-sub">
                        <span class="m-link-text"><i class="fa-solid fa-circle-info"></i> Giới thiệu</span>
                        <i class="fa-solid fa-chevron-down m-toggle-arrow"></i>
                     </a>
                     <ul class="m-sub-list">
                        <li><a href="<?php echo XC_URL; ?>/gioi-thieu/1-ve-chung-toi.html" class="m-sub-link">Về chúng tôi</a></li>
                        <li><a href="<?php echo XC_URL; ?>/gioi-thieu/3-co-cau-to-chuc.html" class="m-sub-link">Cơ cấu tổ chức</a></li>
                        <li><a href="<?php echo XC_URL; ?>/gioi-thieu/2-co-so-ha-tang.html" class="m-sub-link">Cơ sở hạ tầng</a></li>
                     </ul>
                  </li>

                  <!-- Mục Dịch vụ (Accordion) -->
                  <li class="m-nav-item has-sub">
                     <a href="javascript:void(0)" class="m-nav-link js-toggle-sub">
                        <span class="m-link-text"><i class="fa-solid fa-stethoscope"></i> Dịch vụ phòng khám</span>
                        <i class="fa-solid fa-chevron-down m-toggle-arrow"></i>
                     </a>
                     <ul class="m-sub-list">
                        <li><a href="<?php echo $this->helper->permalink('6','services'); ?>" class="m-sub-link">Khám chữa bệnh dịch vụ</a></li>
                        <li><a href="<?php echo $this->helper->permalink('7','services'); ?>" class="m-sub-link">Khám chữa bệnh BHYT</a></li>
                     </ul>
                  </li>

                  <!-- Mục Nhà thuốc (Accordion) -->
                  <li class="m-nav-item has-sub">
                     <a href="javascript:void(0)" class="m-nav-link js-toggle-sub">
                        <span class="m-link-text"><i class="fa-solid fa-capsules"></i> Nhà thuốc</span>
                        <i class="fa-solid fa-chevron-down m-toggle-arrow"></i>
                     </a>
                     <ul class="m-sub-list">
                        <li><a href="<?php echo XC_URL; ?>/gioi-thieu/5-gioi-thieu-nha-thuoc.html" class="m-sub-link">Giới thiệu nhà thuốc</a></li>
                        <li><a href="<?php echo XC_URL; ?>/nha-thuoc.html" class="m-sub-link">Danh mục sản phẩm</a></li>
                        <li><a href="<?php echo XC_URL; ?>/gioi-thieu/6-chinh-sach-ban-hang.html" class="m-sub-link">Chính sách bán hàng</a></li>
                     </ul>
                  </li>

                  <li class="m-nav-item">
                     <a href="<?php echo XC_URL; ?>/doi-ngu-bac-si.html" class="m-nav-link">
                        <span class="m-link-text"><i class="fa-solid fa-user-doctor"></i> Đội ngũ bác sĩ</span>
                     </a>
                  </li>

                  <li class="m-nav-item">
                     <a href="<?php echo XC_URL; ?>/lich-cong-tac.html" class="m-nav-link">
                        <span class="m-link-text"><i class="fa-solid fa-calendar-days"></i> Lịch công tác</span>
                     </a>
                  </li>

                  <li class="m-nav-item">
                     <a href="<?php echo XC_URL; ?>/tin-tuc-su-kien.html" class="m-nav-link">
                        <span class="m-link-text"><i class="fa-solid fa-newspaper"></i> Tin tức &amp; Sự kiện</span>
                     </a>
                  </li>

                  <li class="m-nav-item">
                     <a href="<?php echo XC_URL; ?>/lien-he.html" class="m-nav-link">
                        <span class="m-link-text"><i class="fa-solid fa-phone-volume"></i> Liên hệ</span>
                     </a>
                  </li>
               </ul>
            </div>
         </div>
      </aside>

      <!-- Script điều khiển mở/đóng Drawer Menu & Accordion -->
      <script>
      document.addEventListener('DOMContentLoaded', function(){
         var mbBtn = document.getElementById('mainMenu-btn');
         var menuM = document.getElementById('menuM');
         var ovl = document.getElementById('ovl-menuM');
         var closeBtn = document.getElementById('menuM-cls');

         function toggleDrawer(isOpen) {
            if (!menuM || !ovl) return;
            if (isOpen) {
               menuM.classList.add('in');
               ovl.classList.add('show');
               document.body.classList.add('menu-open');
            } else {
               menuM.classList.remove('in');
               ovl.classList.remove('show');
               document.body.classList.remove('menu-open');
            }
         }

         if (mbBtn) {
            mbBtn.addEventListener('click', function(e){
               e.preventDefault();
               e.stopPropagation();
               toggleDrawer(true);
            });
         }

         if (closeBtn) {
            closeBtn.addEventListener('click', function(e){
               e.preventDefault();
               toggleDrawer(false);
            });
         }

         if (ovl) {
            ovl.addEventListener('click', function(e){
               e.preventDefault();
               toggleDrawer(false);
            });
         }

         document.addEventListener('keydown', function(e){
            if (e.key === 'Escape' && menuM && menuM.classList.contains('in')) {
               toggleDrawer(false);
            }
         });

         window.addEventListener('resize', function(){
            if (window.innerWidth > 991 && menuM && menuM.classList.contains('in')) {
               toggleDrawer(false);
            }
         });

         // Accordion Menu con trượt mở mượt mà
         var subToggles = document.querySelectorAll('.js-toggle-sub');
         subToggles.forEach(function(btn){
            btn.addEventListener('click', function(e){
               e.preventDefault();
               var parentItem = this.closest('.m-nav-item');
               if (!parentItem) return;

               var isOpen = parentItem.classList.contains('open');

               document.querySelectorAll('.m-nav-item.has-sub').forEach(function(item){
                  if (item !== parentItem) {
                     item.classList.remove('open');
                  }
               });

               parentItem.classList.toggle('open', !isOpen);
            });
         });
      });
      </script>

      <?php if($cartEnabled){ ?>
      <a href="<?php echo XC_URL; ?>/gio-hang.html" class="site-cart-floating"><i class="fa-solid fa-cart-shopping"></i> <span>Giỏ hàng</span> <span class="cart-badge js-cart-count"><?php echo $cartCount; ?></span></a>
      <?php } ?>
      <?php if($cartEnabled) include __DIR__."/cart_preview.php"; ?>

      <?php include __DIR__.'/customer_login_modal.php'; ?>
      <style>
      .header-badge-bounce{animation:headerBadgeBounce .4s ease!important}
      @keyframes headerBadgeBounce{0%,100%{transform:translateY(0)}40%{transform:translateY(-5px)}70%{transform:translateY(1px)}}
      @media(prefers-reduced-motion:reduce){.header-badge-bounce{animation:none!important}}
      </style>
      <script>
      document.addEventListener('DOMContentLoaded', function () {
          // Menu tài khoản dùng phiên đăng nhập thật, đăng xuất qua API có CSRF.
          jQuery(document).on('click', '.js-header-account', function (event) {
              event.preventDefault();
              var menu = this.parentElement ? this.parentElement.querySelector('.header-account-dropdown') : null;
              if (!menu) return;
              var opening = menu.hidden;
              document.querySelectorAll('.header-account-dropdown').forEach(function (item) { item.hidden = true; });
              document.querySelectorAll('.js-header-account').forEach(function (item) { item.setAttribute('aria-expanded', 'false'); });
              menu.hidden = !opening;
              this.setAttribute('aria-expanded', opening ? 'true' : 'false');
          });
          document.addEventListener('click', function (event) {
              if (event.target.closest('.header-account-wrap')) return;
              document.querySelectorAll('.header-account-dropdown').forEach(function (item) { item.hidden = true; });
              document.querySelectorAll('.js-header-account').forEach(function (item) { item.setAttribute('aria-expanded', 'false'); });
          });
          document.addEventListener('keydown', function (event) {
              if (event.key !== 'Escape') return;
              document.querySelectorAll('.header-account-dropdown:not([hidden])').forEach(function (menu) {
                  menu.hidden = true;
                  var link = menu.parentElement ? menu.parentElement.querySelector('.js-header-account') : null;
                  if (link) { link.setAttribute('aria-expanded', 'false'); link.focus(); }
              });
          });
          jQuery(document).on('click', '.js-header-logout', function () {
              var button = this;
              if (button.disabled) return;
              button.disabled = true;
              jQuery.ajax({url:<?php echo json_encode(XC_URL.'/api/customerlogout'); ?>, type:'POST', dataType:'json', data:{csrf:<?php echo json_encode(isset($_SESSION['customer_csrf']) ? $_SESSION['customer_csrf'] : ''); ?>},
                  success:function (data) { Swal.fire({toast:true,position:'bottom-end',icon:data.success ? 'success' : 'error',title:data.message || 'Vui lòng thử lại.',showConfirmButton:false,timer:3500}); if (data.success) setTimeout(function () { window.location.reload(); }, 600); },
                  error:function () { Swal.fire({toast:true,position:'bottom-end',icon:'error',title:'Không thể đăng xuất. Vui lòng kiểm tra kết nối và thử lại.',showConfirmButton:false,timer:4000}); },
                  complete:function () { button.disabled = false; }
              });
          });
          // Theo dõi badge do AJAX giỏ hàng hiện có cập nhật, chỉ tạo bounce cho số lượng.
          document.querySelectorAll('.js-cart-count').forEach(function (badge) {
              var count = badge.textContent;
              new MutationObserver(function () {
                  if (badge.textContent === count) return;
                  count = badge.textContent;
                  badge.classList.remove('header-badge-bounce');
                  void badge.offsetWidth;
                  badge.classList.add('header-badge-bounce');
              }).observe(badge, {childList:true, characterData:true, subtree:true});
          });
      });
      </script>
      <script>
      document.addEventListener('DOMContentLoaded', function () {
          var busy = false;
          jQuery(document).on('click', '.js-zalo-login', function (event) {
              event.preventDefault();
              if (busy) return;
              busy = true;
              jQuery('.js-zalo-login').attr('aria-disabled', 'true');
              jQuery.ajax({
                  url: <?php echo json_encode(XC_URL.'/api/zalologin'); ?>,
                  type: 'POST', dataType: 'json',
                  data: {action: 'begin', page: 'public', csrf: <?php echo json_encode($_SESSION['login_csrf']); ?>},
                  success: function (data) {
                      if (data.success && data.data && data.data.url) {
                          window.location.assign(data.data.url);
                          return;
                      }
                      Swal.fire({toast:true, position:'bottom-end', icon:'error', title:data.message || 'Không thể đăng nhập Zalo. Vui lòng thử lại.', showConfirmButton:false, timer:5000});
                      busy = false;
                      jQuery('.js-zalo-login').removeAttr('aria-disabled');
                  },
                  error: function () {
                      Swal.fire({toast:true, position:'bottom-end', icon:'error', title:'Không kết nối được máy chủ. Vui lòng thử lại.', showConfirmButton:false, timer:5000});
                      busy = false;
                      jQuery('.js-zalo-login').removeAttr('aria-disabled');
                  }
              });
          });
      });
      </script>
      <main role="main">
      <section id="slider">
      <div class="is_mobi">
         <div class="slider">
            <?php 
            $slider_mb = $this->helper->get_banners("1");
            foreach($slider_mb as $item){ ?>
            <a href="#" title="<?php echo $item->image_name; ?>"><img data-lazy="<?php echo XC_URL; ?>/uploads/images/<?php echo $item->image_url; ?>" alt="<?php echo $item->image_name; ?>"></a>
            <?php } ?>
         </div>
      </div>
      <div class="is_pc">
         <div class="slider">
            <?php
            $slider_pc = $this->helper->get_banners("0");
            foreach($slider_pc as $item){ ?>
            <a href="#" title="<?php echo $item->image_name; ?>"><img data-lazy="<?php echo XC_URL; ?>/uploads/images/<?php echo $item->image_url; ?>" alt="<?php echo $item->image_name; ?>"></a>
            <?php } ?>
         </div>
      </div>
