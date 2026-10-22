<style>
/* ========================================================
   HEADER BUTTONS: ĐĂNG NHẬP & GIỎ HÀNG (CÙNG DÒNG, KHÔNG ĐỔI KÍCH THƯỚC)
   Thứ tự từ trái qua phải: Đăng nhập -> Giỏ hàng
   Hover: Làm đậm background 1 chút, transform: none
   ======================================================== */
/* Cải thiện container navbar desktop: Mở rộng chiều rộng, loại bỏ tràn menu */
#headerMid > .ctn {
    max-width: 1400px !important;
    width: 100% !important;
    padding-left: 12px !important;
    padding-right: 12px !important;
}

#headerMid-wrp {
    display: flex !important;
    align-items: center !important;
    width: 100% !important;
    margin: 0 !important;
}

#mainMenu {
    width: 100% !important;
    margin-left: 0 !important;
}

#mainMenu ul#mainmenu {
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    flex-wrap: nowrap !important;
    gap: clamp(4px, 0.75vw, 14px) !important;
    width: 100% !important;
    margin: 0 !important;
    padding: 0 !important;
}

/* TẤT CẢ MENU ITEMS: TUYỆT ĐỐI KHÔNG XUỐNG DÒNG (NO-WRAP) */
#mainMenu ul#mainmenu > li {
    padding-left: 0 !important;
    padding-right: 0 !important;
    margin: 0 !important;
    position: relative !important;
    white-space: nowrap !important;
    flex-shrink: 0 !important;
}

#mainMenu ul#mainmenu > li > a {
    white-space: nowrap !important;
    font-size: clamp(12.5px, 0.95vw, 14.5px) !important;
    font-weight: 700 !important;
    padding: 0 clamp(4px, 0.55vw, 10px) !important;
    line-height: 100px !important;
    height: 100px !important;
    display: inline-flex !important;
    align-items: center !important;
}

#mainMenu ul#mainmenu > .header-user-actions-item {
    margin-left: auto !important;
    list-style: none !important;
    display: inline-flex !important;
    align-items: center !important;
    flex-shrink: 0 !important;
    padding: 0 !important;
    white-space: nowrap !important;
}

/* Cụm 2 nút Đăng nhập & Giỏ hàng luôn cùng 1 hàng duy nhất */
.header-user-actions-group {
    display: inline-flex !important;
    flex-direction: row !important;
    align-items: center !important;
    gap: 8px !important;
    flex-wrap: nowrap !important;
    white-space: nowrap !important;
    flex-shrink: 0 !important;
}

.header-account-wrap {
    position: relative !important;
    display: inline-flex !important;
    align-items: center !important;
    flex-shrink: 0 !important;
}

.header-action-icon {
    width: 18px !important;
    height: 18px !important;
    flex: 0 0 18px !important;
    fill: none;
    stroke: currentColor;
    stroke-width: 1.8;
    stroke-linecap: round;
    stroke-linejoin: round;
}

.swal2-container {
    z-index: 100200 !important;
}

/* Nút Đăng nhập & Giỏ hàng Desktop: Chuẩn 38px, box-sizing border-box, KHÔNG nhảy kích thước */
#mainMenu .site-account-link,
#mainMenu .site-cart-link {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 7px !important;
    height: 38px !important;
    min-height: 38px !important;
    max-height: 38px !important;
    padding: 0 13px !important;
    border-radius: 9px !important;
    border-width: 1px !important;
    border-style: solid !important;
    font-family: inherit !important;
    font-size: 13px !important;
    line-height: 36px !important;
    font-weight: 600 !important;
    letter-spacing: 0 !important;
    text-transform: none !important;
    text-decoration: none !important;
    white-space: nowrap !important;
    box-sizing: border-box !important;
    transform: none !important;
    animation: none !important;
    cursor: pointer !important;
    flex-shrink: 0 !important;
    transition: background-color 0.2s ease, border-color 0.2s ease, color 0.2s ease, box-shadow 0.2s ease !important;
}

/* Nút 1: Đăng nhập Desktop (Nền sáng nhẹ, hover làm đậm background 1 chút) */
#mainMenu .site-account-link {
    background: #f0f6fa !important;
    border-color: #d0e0ed !important;
    color: #1760a5 !important;
    box-shadow: 0 1px 3px rgba(23, 96, 165, 0.08) !important;
}
#mainMenu .site-account-link:hover {
    background: #cfe2f5 !important; /* Đậm background rõ rệt */
    border-color: #8ebde4 !important;
    color: #0d4377 !important;
    box-shadow: 0 2px 6px rgba(23, 96, 165, 0.16) !important;
    transform: none !important; /* Giữ nguyên kích thước */
}
#mainMenu .site-account-link:active {
    background: #bed8ef !important;
    border-color: #79aed8 !important;
    color: #0b3762 !important;
    transform: none !important;
}

/* Nút 2: Giỏ hàng Desktop (Nền xanh thương hiệu, hover làm đậm background 1 chút) */
#mainMenu .site-cart-link {
    background: #1760a5 !important;
    border-color: #145593 !important;
    color: #ffffff !important;
    box-shadow: 0 2px 6px rgba(23, 96, 165, 0.18) !important;
}
#mainMenu .site-cart-link:hover {
    background: #0f4477 !important; /* Đậm background rõ rệt */
    border-color: #0b3259 !important;
    color: #ffffff !important;
    box-shadow: 0 3px 10px rgba(23, 96, 165, 0.28) !important;
    transform: none !important; /* Giữ nguyên kích thước */
}
#mainMenu .site-cart-link:active {
    background: #092c4e !important;
    border-color: #061e35 !important;
    color: #ffffff !important;
    transform: none !important;
}

.header-account-label {
    max-width: 110px !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
    white-space: nowrap !important;
    display: inline-block !important;
}

/* Hiệu ứng gạch chân thanh lịch cho menu chính */
#mainMenu ul#mainmenu > li > a {
    position: relative !important;
}
#mainMenu ul#mainmenu > li:hover > a:after,
#mainMenu ul#mainmenu > li.current-menu-item > a:after,
#mainMenu ul#mainmenu > li.current_page_item > a:after {
    content: '' !important;
    position: absolute !important;
    bottom: 0 !important;
    left: 0 !important;
    width: 100% !important;
    height: 4px !important;
    background: #1760a5 !important;
    border-radius: 4px 4px 0 0 !important;
    top: auto !important;
}
#mainMenu ul#mainmenu > .header-user-actions-item:hover > a:after {
    display: none !important;
}

/* Breakpoint màn hình laptop vừa / tablet ngang (992px - 1200px) */
@media (min-width: 992px) and (max-width: 1240px) {
    #mainMenu ul#mainmenu > li > a {
        font-size: 11.5px !important;
        padding: 0 4px !important;
    }
    #mainMenu .site-account-link,
    #mainMenu .site-cart-link {
        padding: 0 8px !important;
        font-size: 12px !important;
        gap: 5px !important;
    }
    .header-account-label {
        max-width: 75px !important;
    }
}

/* Cart Badge trên Desktop & Mobile */
.site-cart-link .cart-badge,
.lc-cart-btn .cart-badge,
.menuM-btn-cart .cart-badge {
    background: #e36928 !important;
    color: #ffffff !important;
    font-size: 11px !important;
    font-weight: 700 !important;
    line-height: 20px !important;
    min-width: 20px !important;
    height: 20px !important;
    border-radius: 999px !important;
    padding: 0 5px !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    border: none !important;
    box-shadow: none !important;
    box-sizing: border-box !important;
    transform: none !important;
}

/* Dropdown menu tài khoản khi khách hàng đã đăng nhập */
.header-account-dropdown[hidden] {
    display: none !important;
}
.header-account-dropdown {
    position: absolute;
    right: 0;
    top: calc(100% + 8px);
    width: 210px;
    padding: 8px;
    border: 1px solid #e2eaf1;
    border-radius: 12px;
    background: #ffffff;
    box-shadow: 0 12px 35px rgba(24, 50, 75, 0.16);
    z-index: 100030;
}
.header-account-dropdown a,
.header-account-dropdown button {
    display: block;
    width: 100%;
    padding: 10px 12px;
    border: 0;
    border-radius: 8px;
    background: #ffffff;
    color: #1e293b;
    text-align: left;
    font-family: inherit;
    font-size: 13.5px;
    font-weight: 500;
    cursor: pointer;
    text-decoration: none;
    box-sizing: border-box;
    transition: background-color 0.18s ease;
}
.header-account-dropdown a:hover,
.header-account-dropdown button:hover {
    background: #f0f6fb;
    color: #1760a5;
}
.header-account-dropdown button {
    color: #dc2626;
}
.header-account-dropdown button:hover {
    background: #fef2f2;
    color: #b91c1c;
}

/* ========================================================
   GIAO DIỆN MOBILE (max-width: 991px):
   1. Banner Top: Cùng 1 hàng duy nhất với Logo, không rớt dòng
   2. Menu Drawer: Đưa Đăng nhập & Giỏ hàng vào menu cùng hàng với logo
   ======================================================== */
@media (max-width: 991px) {
    /* Banner Top: Luôn cùng 1 hàng (nowrap) với Logo */
    #bannerTop .lc-banner-top-mobile {
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        flex-wrap: nowrap !important;
        height: 56px !important;
        min-height: 56px !important;
        padding: 0 10px !important;
        gap: 8px !important;
    }
    .lc-brand-center {
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
        flex: 1 1 auto !important;
        min-width: 0 !important;
        overflow: hidden !important;
    }
    .lc-mobile-actions {
        display: inline-flex !important;
        flex-direction: row !important;
        align-items: center !important;
        gap: 6px !important;
        flex-shrink: 0 !important;
        flex-wrap: nowrap !important;
    }
    #bannerTop .lc-account-btn,
    #bannerTop .lc-cart-btn {
        width: 36px !important;
        height: 36px !important;
        min-width: 36px !important;
        max-width: 36px !important;
        min-height: 36px !important;
        max-height: 36px !important;
        border-radius: 50% !important;
        padding: 0 !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        box-sizing: border-box !important;
        text-decoration: none !important;
        position: relative !important;
        transform: none !important;
        transition: background-color 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease !important;
    }
    /* Nút Đăng nhập trên Banner Mobile */
    #bannerTop .lc-account-btn {
        background: #ffffff !important;
        border: 1.5px solid #d0e0ed !important;
        color: #1760a5 !important;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.12) !important;
    }
    #bannerTop .lc-account-btn:hover {
        background: #cfe2f5 !important; /* Làm đậm background khi hover */
        border-color: #8ebde4 !important;
        color: #0d4377 !important;
        transform: none !important;
    }
    #bannerTop .lc-account-btn:active {
        background: #bed8ef !important;
        transform: none !important;
    }
    #bannerTop .lc-account-btn svg {
        width: 17px !important;
        height: 17px !important;
    }

    /* Nút Giỏ hàng trên Banner Mobile */
    #bannerTop .lc-cart-btn {
        background: #1760a5 !important;
        border: 1.5px solid #145593 !important;
        color: #ffffff !important;
        box-shadow: 0 2px 6px rgba(23, 96, 165, 0.2) !important;
    }
    #bannerTop .lc-cart-btn:hover {
        background: #0f4477 !important; /* Làm đậm background khi hover */
        border-color: #0b3259 !important;
        color: #ffffff !important;
        transform: none !important;
    }
    #bannerTop .lc-cart-btn:active {
        background: #092c4e !important;
        transform: none !important;
    }
    #bannerTop .lc-cart-btn svg {
        width: 16px !important;
        height: 16px !important;
    }
    #bannerTop .lc-cart-badge {
        position: absolute !important;
        top: -4px !important;
        right: -4px !important;
        background: #e36928 !important;
        color: #ffffff !important;
        font-size: 10px !important;
        font-weight: 700 !important;
        min-width: 17px !important;
        height: 17px !important;
        line-height: 17px !important;
        border-radius: 999px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        padding: 0 3px !important;
        border: 1.5px solid #ffffff !important;
        box-sizing: border-box !important;
    }

    /* ========================================================
       DRAWER MENU MOBILE: Đưa Đăng nhập & Giỏ hàng cùng hàng với logo
       ======================================================== */
    #menuM-head {
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        padding: 10px 12px !important;
        gap: 8px !important;
        border-bottom: 1px solid #e2e8f0 !important;
        background: #ffffff !important;
        box-sizing: border-box !important;
        min-height: 56px !important;
    }

    .menuM-left-brand {
        display: flex !important;
        align-items: center !important;
        flex-shrink: 0 !important;
    }

    .menuM-drawer-logo {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        width: 36px !important;
        height: 36px !important;
        border-radius: 50% !important;
        border: 1px solid #e2e8f0 !important;
        background: #ffffff !important;
        padding: 2px !important;
        box-sizing: border-box !important;
    }

    .menuM-drawer-logo img {
        width: 100% !important;
        height: 100% !important;
        object-fit: contain !important;
        border-radius: 50% !important;
    }

    /* Cụm Đăng nhập & Giỏ hàng trong Drawer Menu: cùng hàng với logo */
    .menuM-auth-group {
        display: inline-flex !important;
        flex-direction: row !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 6px !important;
        flex: 1 1 auto !important;
        min-width: 0 !important;
    }

    .menuM-btn-auth {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 5px !important;
        height: 34px !important;
        min-height: 34px !important;
        max-height: 34px !important;
        padding: 0 10px !important;
        border-radius: 8px !important;
        border-width: 1px !important;
        border-style: solid !important;
        font-family: inherit !important;
        font-size: 12px !important;
        font-weight: 600 !important;
        line-height: 32px !important;
        text-decoration: none !important;
        white-space: nowrap !important;
        box-sizing: border-box !important;
        transform: none !important;
        transition: background-color 0.2s ease, border-color 0.2s ease, color 0.2s ease, box-shadow 0.2s ease !important;
    }

    /* Nút Đăng nhập trong Drawer Menu */
    .menuM-btn-login {
        background: #f0f6fa !important;
        border-color: #d0e0ed !important;
        color: #1760a5 !important;
        box-shadow: 0 1px 3px rgba(23, 96, 165, 0.08) !important;
    }
    .menuM-btn-login:hover {
        background: #cfe2f5 !important; /* Làm đậm background khi hover */
        border-color: #8ebde4 !important;
        color: #0d4377 !important;
        transform: none !important;
    }
    .menuM-btn-login:active {
        background: #bed8ef !important;
        border-color: #79aed8 !important;
        color: #0b3762 !important;
        transform: none !important;
    }

    /* Nút Giỏ hàng trong Drawer Menu */
    .menuM-btn-cart {
        background: #1760a5 !important;
        border-color: #145593 !important;
        color: #ffffff !important;
        box-shadow: 0 1px 4px rgba(23, 96, 165, 0.16) !important;
    }
    .menuM-btn-cart:hover {
        background: #0f4477 !important; /* Làm đậm background khi hover */
        border-color: #0b3259 !important;
        color: #ffffff !important;
        transform: none !important;
    }
    .menuM-btn-cart:active {
        background: #092c4e !important;
        border-color: #061e35 !important;
        color: #ffffff !important;
        transform: none !important;
    }

    .menuM-btn-cart .cart-badge {
        background: #e36928 !important;
        color: #ffffff !important;
        font-size: 10.5px !important;
        font-weight: 700 !important;
        line-height: 18px !important;
        min-width: 18px !important;
        height: 18px !important;
        border-radius: 999px !important;
        padding: 0 4px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        border: none !important;
        margin-left: 2px !important;
    }

    #menuM-cls {
        width: 32px !important;
        height: 32px !important;
        min-width: 32px !important;
        flex-shrink: 0 !important;
        border-radius: 50% !important;
        background: #f1f5f9 !important;
        border: 1px solid #e2e8f0 !important;
        color: #64748b !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        cursor: pointer !important;
        transform: none !important;
        transition: background-color 0.2s ease, color 0.2s ease !important;
    }
    #menuM-cls:hover {
        background: #fee2e2 !important;
        color: #ef4444 !important;
        transform: none !important;
    }

    .header-account-dropdown {
        left: 0;
        right: auto;
        max-width: calc(100vw - 32px);
    }
}

/* ========================================================
   POPUP MODAL ĐĂNG NHẬP / ĐĂNG KÝ (CHUẨN ĐẸP, GỌN, RESPONSIVE)
   ======================================================== */
.customer-login-overlay[hidden] {
    display: none !important;
}
.customer-login-overlay {
    position: fixed !important;
    inset: 0 !important;
    z-index: 100100 !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    padding: 16px !important;
    box-sizing: border-box !important;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.22s ease, visibility 0.22s ease !important;
}
.customer-login-overlay.is-open {
    opacity: 1 !important;
    visibility: visible !important;
}
.customer-login-backdrop {
    position: absolute !important;
    inset: 0 !important;
    background: rgba(15, 23, 42, 0.65) !important;
    backdrop-filter: blur(6px) !important;
    -webkit-backdrop-filter: blur(6px) !important;
}
body.customer-login-open {
    overflow: hidden !important;
}

/* Hộp thoại Modal: Thiết kế căn giữa, bo tròn cao cấp, bóng mềm */
.customer-login-dialog {
    position: relative !important;
    width: 100% !important;
    max-width: 400px !important;
    max-height: calc(100dvh - 32px) !important;
    overflow-y: auto !important;
    -webkit-overflow-scrolling: touch !important;
    background: #ffffff !important;
    border-radius: 20px !important;
    border: 1px solid rgba(226, 232, 240, 0.95) !important;
    box-shadow: 0 20px 50px -10px rgba(15, 35, 60, 0.3), 0 0 0 1px rgba(255, 255, 255, 0.7) inset !important;
    padding: 26px 24px 20px !important;
    box-sizing: border-box !important;
    text-align: center !important;
    transform: scale(0.96) translateY(6px) !important;
    opacity: 0 !important;
    transition: transform 0.24s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.24s ease !important;
    z-index: 2 !important;
}
.customer-login-overlay.is-open .customer-login-dialog {
    transform: scale(1) translateY(0) !important;
    opacity: 1 !important;
}

/* Nút đóng (X) */
.customer-login-close {
    position: absolute !important;
    top: 14px !important;
    right: 14px !important;
    width: 34px !important;
    height: 34px !important;
    min-width: 34px !important;
    max-width: 34px !important;
    border-radius: 50% !important;
    border: none !important;
    background: #f1f5f9 !important;
    color: #64748b !important;
    font-size: 15px !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    cursor: pointer !important;
    box-sizing: border-box !important;
    transform: none !important;
    transition: background-color 0.2s ease, color 0.2s ease !important;
    padding: 0 !important;
    margin: 0 !important;
    z-index: 5 !important;
}
.customer-login-close:hover {
    background: #e2e8f0 !important;
    color: #0f172a !important;
    transform: none !important;
}

/* Header Modal: Logo & Tiêu đề */
.customer-modal-logo-wrap {
    width: 48px;
    height: 48px;
    margin: 0 auto 10px;
    border-radius: 50%;
    background: #ffffff;
    border: 1.5px solid #dbeafe;
    box-shadow: 0 4px 12px rgba(23, 96, 165, 0.12);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 3px;
    box-sizing: border-box;
}
.customer-modal-logo {
    width: 100%;
    height: 100%;
    object-fit: contain;
    border-radius: 50%;
    display: block;
}
.customer-modal-title {
    font-size: 19px !important;
    font-weight: 700 !important;
    color: #0f2c4d !important;
    margin: 0 0 5px !important;
    line-height: 1.3 !important;
}
.customer-modal-desc {
    font-size: 13px !important;
    color: #64748b !important;
    margin: 0 0 18px !important;
    line-height: 1.4 !important;
}

/* 3 Dòng Button Đăng nhập Mạng xã hội: Zalo, Facebook, Google */
.customer-social-group {
    display: flex;
    flex-direction: column;
    gap: 10px;
    width: 100%;
    box-sizing: border-box;
}
.customer-auth-btn {
    display: flex !important;
    align-items: center !important;
    width: 100% !important;
    height: 48px !important;
    min-height: 48px !important;
    max-height: 48px !important;
    padding: 0 16px !important;
    border-radius: 12px !important;
    border: 1px solid #e2e8f0 !important;
    background: #ffffff !important;
    color: #1e293b !important;
    font-family: inherit !important;
    font-size: 14px !important;
    font-weight: 600 !important;
    cursor: pointer !important;
    box-sizing: border-box !important;
    text-align: left !important;
    transform: none !important;
    transition: background-color 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease, color 0.2s ease !important;
}
.customer-auth-btn:hover {
    background: #f8fafc !important;
    border-color: #cbd5e1 !important;
    color: #0f172a !important;
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.04) !important;
    transform: none !important;
}
.customer-auth-btn:active {
    background: #f1f5f9 !important;
    transform: none !important;
}
.auth-btn-icon {
    width: 28px;
    height: 28px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    margin-right: 12px;
}
.auth-btn-icon svg {
    display: block;
}
.auth-btn-text {
    flex: 1;
    font-size: 14px;
    font-weight: 600;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    text-align: left;
}
.auth-btn-arrow {
    color: #94a3b8;
    font-size: 12px;
    flex-shrink: 0;
    transition: color 0.2s ease;
}
.customer-auth-btn:hover .auth-btn-arrow {
    color: #475569;
}

/* Footer Modal: Divider, Nút Đăng nhập tài khoản & Dòng đăng ký */
.customer-modal-divider {
    display: flex;
    align-items: center;
    margin: 16px 0 13px;
}
.customer-modal-divider::before,
.customer-modal-divider::after {
    content: "";
    flex: 1;
    border-bottom: 1px solid #e2e8f0;
}
.customer-modal-divider span {
    padding: 0 12px;
    font-size: 12px;
    color: #94a3b8;
    text-transform: lowercase;
    font-weight: 500;
}
.customer-modal-account-btn {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 8px !important;
    width: 100% !important;
    height: 44px !important;
    min-height: 44px !important;
    max-height: 44px !important;
    padding: 0 14px !important;
    border-radius: 12px !important;
    background: #f0f6fb !important;
    border: 1px solid #d4e3f0 !important;
    color: #1760a5 !important;
    font-size: 13.5px !important;
    font-weight: 600 !important;
    text-decoration: none !important;
    box-sizing: border-box !important;
    transform: none !important;
    transition: background-color 0.2s ease, border-color 0.2s ease, color 0.2s ease, box-shadow 0.2s ease !important;
}
.customer-modal-account-btn:hover {
    background: #e2eef8 !important;
    border-color: #b8d4ee !important;
    color: #104878 !important;
    box-shadow: 0 2px 8px rgba(23, 96, 165, 0.08);
    transform: none !important;
}
.customer-modal-account-btn:active {
    background: #d8e8f5 !important;
    transform: none !important;
}
.customer-modal-register-row {
    margin-top: 14px;
    font-size: 13px;
    color: #64748b;
    text-align: center;
}
.customer-modal-register-link {
    color: #e36928 !important;
    font-weight: 700 !important;
    text-decoration: none !important;
    margin-left: 5px;
    transition: color 0.2s ease;
}
.customer-modal-register-link:hover {
    color: #c75618 !important;
    text-decoration: underline !important;
}

/* Tối ưu hiển thị cho Mobile */
@media (max-width: 480px) {
    .customer-login-dialog {
        padding: 22px 18px 18px !important;
        border-radius: 18px !important;
    }
    .customer-modal-title {
        font-size: 18px !important;
    }
    .customer-modal-desc {
        font-size: 12.5px !important;
        margin-bottom: 15px !important;
    }
    .customer-auth-btn {
        height: 46px !important;
        min-height: 46px !important;
        max-height: 46px !important;
        font-size: 13.5px !important;
        padding: 0 14px !important;
    }
    .customer-modal-account-btn {
        height: 42px !important;
        min-height: 42px !important;
        max-height: 42px !important;
        font-size: 13px !important;
    }
}
@media (prefers-reduced-motion: reduce) {
    .customer-login-overlay,
    .customer-login-dialog,
    .customer-auth-btn,
    .customer-login-close,
    .customer-modal-account-btn {
        transition: none !important;
    }
}
</style>

<!-- MODAL ĐĂNG NHẬP / ĐĂNG KÝ (POPUP Ở GIỮA MÀN HÌNH) -->
<div id="customer-login-modal" class="customer-login-overlay" hidden>
  <div class="customer-login-backdrop"></div>
  <div class="customer-login-dialog" role="dialog" aria-modal="true" aria-labelledby="customer-login-title" aria-describedby="customer-login-description" tabindex="-1">
    
    <!-- Nút đóng (X) -->
    <button type="button" class="customer-login-close" aria-label="Đóng cửa sổ">
      <i class="fa-solid fa-xmark" aria-hidden="true"></i>
    </button>

    <!-- Header của Modal -->
    <div class="customer-modal-header">
      <div class="customer-modal-logo-wrap">
        <img src="<?php echo $template_path; ?>/assets/images/logo.png" alt="Logo Phòng khám" class="customer-modal-logo" width="46" height="46">
      </div>
      <h2 id="customer-login-title" class="customer-modal-title">Đăng nhập / Đăng ký</h2>
      <p id="customer-login-description" class="customer-modal-desc">Chào mừng quý khách đến với Phòng khám CĐ Kon Tum</p>
    </div>

    <!-- 3 Dòng Button Đăng nhập Mạng xã hội: Zalo, Facebook, Google -->
    <div class="customer-social-group">
      <!-- 1. Đăng nhập Zalo -->
      <button type="button" class="customer-auth-btn customer-btn-zalo js-social-login" data-provider="zalo" title="Đăng nhập qua Zalo">
        <span class="auth-btn-icon auth-icon-zalo">
          <svg viewBox="0 0 32 32" width="22" height="22" fill="none">
            <rect width="32" height="32" rx="8" fill="#0068FF"/>
            <path d="M7 11h6.6l-4.5 7.2h4.7v2.4H6.5l4.6-7.2H7V11zm7.4 0h2.6v9.6h-2.6V11zm7.4 2.5c-.8 0-1.4.3-1.8.8v-3.3h-2.6v9.6h2.6v-4.4c0-1.2.7-1.8 1.6-1.8.9 0 1.5.6 1.5 1.7v4.5h2.6v-4.8c0-1.9-1.2-3.3-2.9-3.3zm6.3 0c-2.3 0-4 1.8-4 4.8 0 3 1.7 4.8 4 4.8 2.3 0 4-1.8 4-4.8 0-3-1.7-4.8-4-4.8zm0 2.2c1 0 1.6 1 1.6 2.6s-.6 2.6-1.6 2.6-1.6-1-1.6-2.6.6-2.6 1.6-2.6z" fill="#FFFFFF"/>
          </svg>
        </span>
        <span class="auth-btn-text">Đăng nhập bằng Zalo</span>
        <i class="fa-solid fa-chevron-right auth-btn-arrow" aria-hidden="true"></i>
      </button>

      <!-- 2. Đăng nhập Facebook -->
      <button type="button" class="customer-auth-btn customer-btn-fb js-social-login" data-provider="facebook" title="Đăng nhập qua Facebook">
        <span class="auth-btn-icon auth-icon-fb">
          <svg viewBox="0 0 32 32" width="22" height="22" fill="none">
            <rect width="32" height="32" rx="8" fill="#1877F2"/>
            <path d="M21.5 16h-3.5v11h-4.5V16h-2.2v-3.8h2.2v-2.5c0-3 1.8-4.7 4.5-4.7 1.3 0 2.7.2 2.7.2v3h-1.5c-1.5 0-2 .9-2 1.9v2.1h3.4l-.6 3.8z" fill="#FFFFFF"/>
          </svg>
        </span>
        <span class="auth-btn-text">Đăng nhập bằng Facebook</span>
        <i class="fa-solid fa-chevron-right auth-btn-arrow" aria-hidden="true"></i>
      </button>

      <!-- 3. Đăng nhập Google -->
      <button type="button" class="customer-auth-btn customer-btn-gg js-social-login" data-provider="google" title="Đăng nhập qua Google">
        <span class="auth-btn-icon auth-icon-gg">
          <svg viewBox="0 0 24 24" width="20" height="20">
            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
          </svg>
        </span>
        <span class="auth-btn-text">Đăng nhập bằng Google</span>
        <i class="fa-solid fa-chevron-right auth-btn-arrow" aria-hidden="true"></i>
      </button>
    </div>

    <!-- Footer Modal: Dòng đăng nhập tài khoản và dòng đăng ký -->
    <div class="customer-modal-footer">
      <div class="customer-modal-divider">
        <span>hoặc</span>
      </div>

      <a href="<?php echo XC_URL; ?>/login" class="customer-modal-account-btn">
        <i class="fa-solid fa-shield-halved" aria-hidden="true"></i>
        <span>Đăng nhập bằng tài khoản &amp; mật khẩu</span>
      </a>

      <div class="customer-modal-register-row">
        <span>Chưa có tài khoản?</span>
        <a href="<?php echo XC_URL; ?>/dang-ky.html" class="customer-modal-register-link">Đăng ký tài khoản</a>
      </div>
    </div>

  </div>
</div>

<script>
(function() {
    function initCustomerLoginModal() {
        var modal = document.getElementById('customer-login-modal');
        if (!modal) return;
        var trigger = null;
        var closeTimer = null;

        function openLogin(sourceEl) {
            trigger = sourceEl || null;

            // Đóng Drawer menu mobile nếu đang mở
            var menuM = document.getElementById('menuM');
            var ovl = document.getElementById('ovl-menuM');
            if (menuM) menuM.classList.remove('in');
            if (ovl) ovl.classList.remove('show');
            document.body.classList.remove('menu-open');

            clearTimeout(closeTimer);
            modal.hidden = false;
            document.body.classList.add('customer-login-open');
            requestAnimationFrame(function () {
                modal.classList.add('is-open');
                var closeBtn = modal.querySelector('.customer-login-close');
                if (closeBtn) closeBtn.focus();
            });
        }

        function closeLogin() {
            if (!modal || modal.hidden) return;
            modal.classList.remove('is-open');
            document.body.classList.remove('customer-login-open');
            clearTimeout(closeTimer);
            closeTimer = setTimeout(function () {
                if (!modal.classList.contains('is-open')) {
                    modal.hidden = true;
                }
            }, 240);
            if (trigger && typeof trigger.focus === 'function') {
                trigger.focus();
            }
        }

        // Bắt sự kiện click mở modal ngay lập tức
        document.addEventListener('click', function(e) {
            var btn = e.target.closest('.js-account-login');
            if (btn) {
                e.preventDefault();
                e.stopPropagation();
                openLogin(btn);
                return;
            }

            // Đóng modal khi bấm nút X
            var closeBtn = e.target.closest('#customer-login-modal .customer-login-close');
            if (closeBtn) {
                e.preventDefault();
                closeLogin();
                return;
            }

            // Đóng modal khi bấm vào backdrop
            if (e.target.classList.contains('customer-login-backdrop')) {
                e.preventDefault();
                closeLogin();
                return;
            }

            // Bấm vào Social Login: Google / Facebook / Zalo
            var socialBtn = e.target.closest('.js-social-login');
            if (socialBtn) {
                e.preventDefault();
                var provider = socialBtn.getAttribute('data-provider') || 'google';
                var textEl = socialBtn.querySelector('.auth-btn-text');
                var originalText = textEl ? textEl.textContent : '';

                if (socialBtn.getAttribute('aria-disabled') === 'true') return;
                socialBtn.setAttribute('aria-disabled', 'true');
                if (textEl) textEl.textContent = 'Đang chuyển hướng...';

                var xhr = new XMLHttpRequest();
                xhr.open('POST', '<?php echo XC_URL; ?>/loginApi/' + encodeURIComponent(provider), true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4) {
                        socialBtn.removeAttribute('aria-disabled');
                        if (textEl) textEl.textContent = originalText;
                        try {
                            var resp = JSON.parse(xhr.responseText);
                            if (resp.success && resp.data && resp.data.url) {
                                window.location.assign(resp.data.url);
                                return;
                            }
                            var msg = resp.message || 'Không thể khởi tạo đăng nhập. Vui lòng thử lại sau.';
                            if (typeof Swal !== 'undefined' && Swal.fire) {
                                Swal.fire({toast: true, position: 'bottom-end', icon: 'error', title: msg, showConfirmButton: false, timer: 5000});
                            } else {
                                alert(msg);
                            }
                        } catch (err) {
                            // Fallback direct navigation
                            window.location.assign('<?php echo XC_URL; ?>/loginApi/' + encodeURIComponent(provider));
                        }
                    }
                };
                xhr.onerror = function () {
                    window.location.assign('<?php echo XC_URL; ?>/loginApi/' + encodeURIComponent(provider));
                };
                xhr.send('action=begin');
                return;
            }
        }, true);

        // Đóng khi bấm Escape hoặc bẫy phím Tab
        document.addEventListener('keydown', function (event) {
            if (!modal || modal.hidden || !modal.classList.contains('is-open')) return;
            if (event.key === 'Escape') {
                event.preventDefault();
                closeLogin();
                return;
            }
            if (event.key === 'Tab') {
                var focusables = modal.querySelectorAll('button:not([disabled]), a[href]:not([disabled]), [tabindex]:not([tabindex="-1"])');
                if (!focusables.length) return;
                var first = focusables[0];
                var last = focusables[focusables.length - 1];
                if (event.shiftKey && document.activeElement === first) {
                    event.preventDefault();
                    last.focus();
                } else if (!event.shiftKey && document.activeElement === last) {
                    event.preventDefault();
                    first.focus();
                }
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCustomerLoginModal);
    } else {
        initCustomerLoginModal();
    }
})();
</script>

<?php if (!empty($_SESSION['social_login_error'])): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var err = <?php echo json_encode($_SESSION['social_login_error'], JSON_UNESCAPED_UNICODE); ?>;
    if (typeof Swal !== 'undefined' && Swal.fire) {
        Swal.fire({toast: true, position: 'bottom-end', icon: 'error', title: err, showConfirmButton: false, timer: 5000});
    }
});
</script>
<?php unset($_SESSION['social_login_error']); endif; ?>

<?php if (!empty($_SESSION['social_login_success'])): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var msg = <?php echo json_encode($_SESSION['social_login_success'], JSON_UNESCAPED_UNICODE); ?>;
    if (typeof Swal !== 'undefined' && Swal.fire) {
        Swal.fire({toast: true, position: 'bottom-end', icon: 'success', title: msg, showConfirmButton: false, timer: 4000});
    }
});
</script>
<?php unset($_SESSION['social_login_success']); endif; ?>
