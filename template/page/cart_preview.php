<?php if(empty($cartEnabled)) return; ?>
<style>
/* Typography & Reset for Cart Elements */
.site-cart-link, .site-cart-floating {
    font-family: inherit;
    font-size: 13.5px !important;
    line-height: 1.4 !important;
    font-weight: 600 !important;
    letter-spacing: 0.2px;
}
#mainMenu .site-cart-menu-item {
    display: inline-flex;
    align-items: center;
}
#mainMenu .site-cart-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    height: 40px;
    min-height: 40px;
    max-height: 40px;
    padding: 0 16px;
    border-radius: 10px;
    background: #1760a5;
    color: #ffffff !important;
    text-transform: none;
    box-shadow: 0 2px 6px rgba(23, 96, 165, 0.15);
    box-sizing: border-box !important;
    transform: none !important;
    transition: background-color 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease, color 0.2s ease;
}
#mainMenu .site-cart-link:hover {
    background: #124f88;
    color: #ffffff !important;
    box-shadow: 0 3px 10px rgba(23, 96, 165, 0.22);
    transform: none !important;
}
@media (max-width: 991px) {
    #mainMenu .site-cart-menu-item { display: none !important; }
}

/* Badges */
.site-cart-link .cart-badge, .site-cart-floating .cart-badge {
    background: #ff7700 !important;
    color: #ffffff !important;
    font-size: 11px !important;
    font-weight: 700 !important;
    min-width: 20px;
    height: 20px;
    line-height: 20px;
    padding: 0 5px;
    border-radius: 999px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 6px rgba(255, 119, 0, 0.4);
    transition: transform 0.2s ease;
}

/* Floating Cart on Mobile / Scroll */
.site-cart-floating {
    position: fixed;
    right: 18px;
    bottom: 22px;
    z-index: 10010;
    display: none;
    align-items: center;
    gap: 8px;
    padding: 10px 18px;
    border-radius: 999px;
    background: linear-gradient(135deg, #0b63f6 0%, #0284c7 100%);
    color: #ffffff !important;
    font-weight: 700;
    box-shadow: 0 10px 25px rgba(11, 99, 246, 0.35);
    transition: all 0.25s ease;
    text-decoration: none;
}
.site-cart-floating:hover {
    background: linear-gradient(135deg, #094fc3 0%, #0369a1 100%);
    transform: translateY(-2px);
    box-shadow: 0 14px 30px rgba(11, 99, 246, 0.45);
}
@media (max-width: 991px) {
    .site-cart-floating { display: inline-flex; }
}

/* Buttons in Product Cards & Details */
.pm-btn-add-cart {
    font-size: 13px !important;
    font-weight: 600 !important;
    line-height: 1.4 !important;
    padding: 7px 14px !important;
    border-radius: 20px !important;
    border: none !important;
    background: linear-gradient(135deg, #0b63f6 0%, #0284c7 100%) !important;
    color: #ffffff !important;
    display: inline-flex !important;
    align-items: center;
    justify-content: center;
    gap: 6px;
    cursor: pointer;
    box-shadow: 0 3px 10px rgba(11, 99, 246, 0.22);
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
}
.pm-btn-add-cart:hover {
    background: linear-gradient(135deg, #094fc3 0%, #0369a1 100%) !important;
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(11, 99, 246, 0.32);
}
.pm-btn-add-cart:disabled {
    opacity: 0.75;
    cursor: not-allowed;
    transform: none !important;
}
.pm-link-cart {
    font-size: 12.5px !important;
    font-weight: 600 !important;
    color: #0284c7 !important;
    background: #f0f7ff !important;
    padding: 6px 12px !important;
    border-radius: 18px !important;
    border: 1px solid #bae0fd !important;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    transition: all 0.2s ease;
}
.pm-link-cart:hover {
    background: #e0f2fe !important;
    color: #0369a1 !important;
    border-color: #7dd3fc !important;
}
.pd-btn-primary.js-detail-add-cart {
    font-size: 14.5px !important;
    font-weight: 600 !important;
    padding: 10px 22px !important;
    border-radius: 24px !important;
    border: none !important;
    background: linear-gradient(135deg, #0b63f6 0%, #0284c7 100%) !important;
    color: #ffffff !important;
    display: inline-flex !important;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 14px rgba(11, 99, 246, 0.24);
    transition: all 0.25s ease;
    cursor: pointer;
}
.pd-btn-primary.js-detail-add-cart:hover {
    background: linear-gradient(135deg, #094fc3 0%, #0369a1 100%) !important;
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(11, 99, 246, 0.35);
}
.pd-btn-soft {
    font-size: 14px !important;
    font-weight: 600 !important;
    padding: 10px 20px !important;
    border-radius: 24px !important;
    background: #eef5ff !important;
    color: #0369a1 !important;
    border: 1px solid #cbdff7 !important;
    display: inline-flex !important;
    align-items: center;
    gap: 7px;
    text-decoration: none !important;
    transition: all 0.2s ease;
}
.pd-btn-soft:hover {
    background: #e0eeff !important;
    color: #0284c7 !important;
}

/* Animations: Parabolic Fly & Bounce */
.cart-flying-thumb {
    position: fixed;
    z-index: 100050;
    pointer-events: none;
    width: 54px;
    height: 54px;
    border-radius: 50%;
    border: 2.5px solid #ffffff;
    box-shadow: 0 10px 26px rgba(11, 99, 246, 0.4), 0 0 12px rgba(2, 132, 199, 0.25);
    overflow: hidden;
    background: #ffffff;
    will-change: transform, opacity;
}
.cart-flying-thumb img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    display: block;
}

@keyframes cartBounce {
    0% { transform: scale(1); }
    25% { transform: scale(1.18) rotate(-4deg); }
    50% { transform: scale(0.94) rotate(3deg); }
    75% { transform: scale(1.06) rotate(0deg); }
    100% { transform: scale(1); }
}
.cart-bounce {
    animation: cartBounce 0.5s cubic-bezier(0.16, 1, 0.3, 1) !important;
}

@keyframes badgePulse {
    0% { transform: scale(1); }
    40% { transform: scale(1.4); background: #ef4444 !important; }
    100% { transform: scale(1); }
}
.badge-pulse {
    animation: badgePulse 0.5s ease-out !important;
}

/* Cart Preview Dropdown Panel - Compact on PC, hidden on mobile */
.cart-preview {
    position: fixed;
    z-index: 100020;
    width: 290px;
    max-width: calc(100vw - 24px);
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 14px 34px rgba(15, 23, 42, 0.16), 0 2px 6px rgba(0, 0, 0, 0.05);
    border: 1px solid #e2e8f0;
    padding: 10px 12px;
    color: #1e293b;
    font-family: inherit;
    font-size: 12px;
    line-height: 1.4;
    box-sizing: border-box;
    opacity: 0;
    visibility: hidden;
    transform: translateY(14px);
    transition: opacity 0.3s cubic-bezier(0.16, 1, 0.3, 1), transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), visibility 0.3s;
    pointer-events: none;
}
.cart-preview.is-active {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
    pointer-events: auto;
}
.cart-preview:before {
    content: '';
    position: absolute;
    top: -6px;
    right: 22px;
    width: 12px;
    height: 12px;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-bottom: none;
    border-right: none;
    transform: rotate(45deg);
    z-index: 1;
}
.cart-preview.is-bottom:before {
    top: auto;
    bottom: -6px;
    border-top: none;
    border-left: none;
    border-bottom: 1px solid #e2e8f0;
    border-right: 1px solid #e2e8f0;
}
.cart-preview.is-mobile:before {
    display: none;
}

/* Head */
.cart-preview-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-bottom: 7px;
    border-bottom: 1px solid #f1f5f9;
    margin-bottom: 8px;
}
.cart-preview-title {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-weight: 700;
    font-size: 13px;
    color: #0f172a;
}
.cart-preview-title i {
    color: #0b63f6;
    font-size: 13px;
}
.cart-preview-count-pill {
    font-size: 10px;
    font-weight: 700;
    background: #eff6ff;
    color: #0b63f6;
    padding: 1px 6px;
    border-radius: 999px;
}
.cart-preview-close {
    background: transparent;
    border: none;
    color: #94a3b8;
    width: 22px;
    height: 22px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    cursor: pointer;
    line-height: 1;
    transition: all 0.2s;
    padding: 0;
}
.cart-preview-close:hover {
    background: #f1f5f9;
    color: #0f172a;
}

/* Items List */
.cart-preview-items {
    max-height: 190px;
    overflow-y: auto;
    overscroll-behavior: contain;
    padding-right: 2px;
}
.cart-preview-items::-webkit-scrollbar {
    width: 3px;
}
.cart-preview-items::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 3px;
}
.cart-preview-item {
    display: grid;
    grid-template-columns: 38px minmax(0, 1fr) 20px;
    gap: 8px;
    align-items: center;
    padding: 6px 0;
    border-bottom: 1px solid #f8fafc;
    transition: background 0.15s ease;
}
.cart-preview-item:last-child {
    border-bottom: none;
}
.cart-preview-item img {
    width: 38px;
    height: 38px;
    object-fit: contain;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    padding: 2px;
    box-sizing: border-box;
    background: #fafafa;
}
.cart-preview-info {
    min-width: 0;
}
.cart-preview-name {
    font-size: 11.5px;
    font-weight: 600;
    color: #1e293b;
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
    margin-bottom: 2px;
    text-decoration: none;
}
.cart-preview-name:hover {
    color: #0b63f6;
}
.cart-preview-values {
    display: flex;
    align-items: center;
    gap: 5px;
    flex-wrap: wrap;
    font-size: 11px;
}
.cart-preview-price {
    color: #0b63f6;
    font-weight: 700;
    font-size: 11.5px;
}
.cart-preview-old {
    color: #94a3b8;
    font-size: 10px;
    text-decoration: line-through;
}
.cart-preview-qty {
    color: #475569;
    font-size: 10px;
    background: #f1f5f9;
    padding: 0 4px;
    border-radius: 4px;
    font-weight: 600;
    margin-left: auto;
}
.cart-preview-remove {
    background: transparent;
    border: none;
    color: #94a3b8;
    width: 20px;
    height: 20px;
    border-radius: 4px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 11px;
    transition: all 0.2s;
    padding: 0;
}
.cart-preview-remove:hover {
    color: #ef4444;
    background: #fee2e2;
}

/* Empty State */
.cart-preview-empty {
    padding: 16px 8px;
    text-align: center;
    color: #64748b;
}
.cart-preview-empty i {
    font-size: 24px;
    color: #cbd5e1;
    margin-bottom: 6px;
}
.cart-preview-empty p {
    margin: 0;
    font-size: 12px;
    font-weight: 600;
    color: #475569;
}
.cart-preview-empty span {
    font-size: 11px;
    color: #94a3b8;
}

/* Footer */
.cart-preview-footer {
    margin-top: 8px;
    padding-top: 8px;
    border-top: 1px solid #f1f5f9;
}
.cart-preview-subtotal {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 8px;
    font-size: 11.5px;
}
.cart-preview-subtotal .label {
    color: #64748b;
    font-weight: 500;
}
.cart-preview-subtotal .value {
    color: #0f172a;
    font-weight: 700;
    font-size: 13px;
}
.cart-preview-actions {
    display: flex;
    gap: 6px;
}
.cart-preview-actions a {
    flex: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    background: linear-gradient(135deg, #0b63f6 0%, #0284c7 100%);
    color: #ffffff !important;
    font-size: 11.5px;
    font-weight: 600;
    padding: 7px 10px;
    border-radius: 16px;
    text-decoration: none;
    box-shadow: 0 2px 8px rgba(11, 99, 246, 0.22);
    transition: all 0.2s ease;
}
.cart-preview-actions a:hover {
    background: linear-gradient(135deg, #094fc3 0%, #0369a1 100%);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(11, 99, 246, 0.32);
}

/* Mobile: remove cartPreview completely */
@media (max-width: 991px) {
    #cartPreview, .cart-preview {
        display: none !important;
        visibility: hidden !important;
        opacity: 0 !important;
        pointer-events: none !important;
    }
}

/* =========================================================
   PREMIUM MEDICAL TOAST NOTIFICATION
   - PC: Ẩn hoàn toàn theo yêu cầu
   - Mobile: Nhỏ gọn ở góc trên bên phải, tự động ẩn 1-2s,
             dấu tích chuyển động hiệu ứng đẹp mắt nằm bên phải
   ========================================================= */

/* PC: Hoàn toàn ẩn thông báo toast */
@media (min-width: 992px) {
    .pk-toast-container,
    .swal2-container.pk-toast-container,
    .pk-toast-card,
    .pk-toast-card .swal2-html-container {
        display: none !important;
        visibility: hidden !important;
        opacity: 0 !important;
        pointer-events: none !important;
    }
}

/* Mobile Toast Container */
.pk-toast-container,
.swal2-container.swal2-top-end.pk-toast-container {
    position: fixed !important;
    z-index: 100070 !important;
    padding: 0 !important;
    pointer-events: none !important;
    background: transparent !important;
    box-shadow: none !important;
    border: none !important;
    display: flex !important;
    flex-direction: column !important;
    align-items: flex-end !important;
    gap: 8px !important;
}

/* Card Toast nhỏ gọn, nằm gọn bên phải */
.pk-toast-card {
    pointer-events: auto !important;
    background: rgba(255, 255, 255, 0.98) !important;
    backdrop-filter: blur(14px) !important;
    -webkit-backdrop-filter: blur(14px) !important;
    border-radius: 28px !important;
    border: 1px solid rgba(16, 185, 129, 0.35) !important;
    box-shadow: 0 10px 26px -4px rgba(16, 185, 129, 0.24), 0 4px 10px rgba(15, 23, 42, 0.08) !important;
    padding: 7px 12px 7px 15px !important;
    width: auto !important;
    max-width: 275px !important;
    margin: 0 !important;
    display: flex !important;
    align-items: center !important;
    position: relative !important;
    overflow: hidden !important;
    font-family: inherit !important;
    box-sizing: border-box !important;
    animation: pkToastSlideRight 0.34s cubic-bezier(0.16, 1, 0.3, 1) forwards !important;
}

@keyframes pkToastSlideRight {
    0% {
        opacity: 0;
        transform: translate3d(24px, -6px, 0) scale(0.92);
    }
    100% {
        opacity: 1;
        transform: translate3d(0, 0, 0) scale(1);
    }
}

.pk-toast-card.swal2-hide {
    animation: pkToastHideRight 0.18s ease-in forwards !important;
}

@keyframes pkToastHideRight {
    0% {
        opacity: 1;
        transform: translate3d(0, 0, 0) scale(1);
    }
    100% {
        opacity: 0;
        transform: translate3d(18px, -3px, 0) scale(0.96);
    }
}

.pk-toast-card .swal2-icon,
.pk-toast-card .swal2-title {
    display: none !important;
}

.pk-toast-card .swal2-html-container {
    margin: 0 0 0 auto !important;
    padding: 0 !important;
    overflow: visible !important;
    color: inherit !important;
    font-size: inherit !important;
    text-align: right !important;
    width: 100% !important;
    box-sizing: border-box !important;
    display: flex !important;
    justify-content: flex-end !important;
}

/* Toast Body: Chữ bên trái, dấu tích bên phải */
.pk-toast-body {
    display: flex !important;
    align-items: center !important;
    justify-content: flex-end !important;
    gap: 10px !important;
    width: 100% !important;
    padding: 0 !important;
    box-sizing: border-box !important;
}

.pk-toast-text-wrap {
    flex: 1 1 auto !important;
    min-width: 0 !important;
    text-align: right !important;
    display: flex !important;
    flex-direction: column !important;
    align-items: flex-end !important;
    gap: 3px !important;
}

.pk-toast-message {
    font-size: 12.5px !important;
    font-weight: 600 !important;
    color: #0f172a !important;
    line-height: 1.35 !important;
    white-space: nowrap !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
    display: block !important;
}

.pk-toast-cart-link {
    color: #0369a1 !important;
    font-size: 11.5px !important;
    font-weight: 700 !important;
    line-height: 1.25 !important;
    text-decoration: none !important;
    white-space: nowrap !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: flex-end !important;
    gap: 4px !important;
}

.pk-toast-cart-link:hover,
.pk-toast-cart-link:focus {
    color: #075985 !important;
    text-decoration: underline !important;
}

/* Icon Wrap: Dấu tích nằm gọn hơn về phía bên phải */
.pk-toast-icon-wrap {
    width: 26px !important;
    height: 26px !important;
    min-width: 26px !important;
    border-radius: 50% !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    flex-shrink: 0 !important;
    position: relative !important;
}

/* Dấu tích SVG chuyển động hiệu ứng đẹp mắt */
.pk-toast-check-svg {
    width: 26px;
    height: 26px;
    display: block;
    overflow: visible;
}

.pk-check-circle {
    fill: #10b981;
    transform-origin: center;
    animation: pkCheckCirclePop 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
}

.pk-check-stroke {
    stroke-dasharray: 24;
    stroke-dashoffset: 24;
    animation: pkCheckStrokeDraw 0.34s 0.16s cubic-bezier(0.65, 0, 0.45, 1) forwards;
}

/* Hiệu ứng gợn sóng (ripple) phát ra từ dấu tích */
.pk-toast-icon-wrap.pk-check-animated::after {
    content: '';
    position: absolute;
    inset: -3px;
    border-radius: 50%;
    background: rgba(16, 185, 129, 0.45);
    opacity: 0;
    transform: scale(0.85);
    pointer-events: none;
    animation: pkCheckRipple 0.65s 0.2s ease-out forwards;
}

@keyframes pkCheckCirclePop {
    0% {
        transform: scale(0);
        opacity: 0;
    }
    65% {
        transform: scale(1.18);
        opacity: 1;
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

@keyframes pkCheckStrokeDraw {
    0% {
        stroke-dashoffset: 24;
    }
    100% {
        stroke-dashoffset: 0;
    }
}

@keyframes pkCheckRipple {
    0% {
        opacity: 0.8;
        transform: scale(0.85);
    }
    100% {
        opacity: 0;
        transform: scale(1.6);
    }
}

/* Error theme */
.pk-toast-card.pk-toast-error {
    border-color: rgba(244, 63, 94, 0.35) !important;
    box-shadow: 0 10px 25px -4px rgba(244, 63, 94, 0.22) !important;
}

/* Warning theme */
.pk-toast-card.pk-toast-warning {
    border-color: rgba(245, 158, 11, 0.35) !important;
    box-shadow: 0 10px 25px -4px rgba(245, 158, 11, 0.22) !important;
}

/* Info theme */
.pk-toast-card.pk-toast-info {
    border-color: rgba(2, 132, 199, 0.35) !important;
    box-shadow: 0 10px 25px -4px rgba(2, 132, 199, 0.22) !important;
}

/* Close button - ẩn trên mobile để giữ độ gọn gàng */
.pk-toast-card .pk-toast-close-btn {
    display: none !important;
}

/* Progress bar siêu mảnh tinh tế */
.pk-toast-card .pk-toast-progress-bar {
    height: 2px !important;
    position: absolute !important;
    bottom: 0 !important;
    left: 0 !important;
    width: 100% !important;
    background: linear-gradient(90deg, #10b981, #059669) !important;
    border-radius: 0 0 28px 28px !important;
    opacity: 0.85;
}
.pk-toast-error .pk-toast-progress-bar {
    background: linear-gradient(90deg, #f43f5e, #e11d48) !important;
}
.pk-toast-warning .pk-toast-progress-bar {
    background: linear-gradient(90deg, #f59e0b, #d97706) !important;
}
.pk-toast-info .pk-toast-progress-bar {
    background: linear-gradient(90deg, #0284c7, #0369a1) !important;
}
</style>

<aside id="cartPreview" class="cart-preview" aria-label="Giỏ hàng xem nhanh" hidden>
    <div class="cart-preview-head">
        <div class="cart-preview-title">
            <i class="fa-solid fa-basket-shopping"></i>
            <span>Giỏ hàng</span>
            <span class="cart-preview-count-pill js-cart-preview-count">0</span>
        </div>
        <button type="button" class="cart-preview-close" aria-label="Đóng giỏ hàng">&times;</button>
    </div>
    <div class="cart-preview-items"></div>
    <div class="cart-preview-footer">
        <div class="cart-preview-subtotal">
            <span class="label">Tạm tính:</span>
            <span class="value js-cart-preview-subtotal">0đ</span>
        </div>
        <div class="cart-preview-actions">
            <a href="<?php echo XC_URL; ?>/gio-hang.html">
                <i class="fa-solid fa-cart-shopping"></i> Xem giỏ & Đặt thuốc
            </a>
        </div>
    </div>
</aside>

<script>
document.addEventListener('DOMContentLoaded', function(){
    var $ = window.jQuery, panel = document.getElementById('cartPreview');
    if (!panel) return;
    var base = <?php echo json_encode(XC_URL, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
    var revision = 0;
    var cartHeaders = {'X-Cart-CSRF': <?php echo json_encode($_SESSION['cart_csrf']); ?>};

    function calcToastPosition(){
        var targets = document.querySelectorAll('.site-cart-link, .mobile-cart-circle, .site-cart-floating');
        var target = null;
        for (var i = 0; i < targets.length; i++) {
            var el = targets[i];
            var style = window.getComputedStyle(el);
            if (style.display !== 'none' && style.visibility !== 'hidden') {
                var rect = el.getBoundingClientRect();
                if (rect.width > 0 && rect.height > 0) {
                    target = el;
                    break;
                }
            }
        }

        var isMobile = window.innerWidth <= 991;
        var top = isMobile ? 62 : 24;
        var right = isMobile ? 10 : 24;

        if (target) {
            var r = target.getBoundingClientRect();
            if (r.bottom > 0 && r.bottom < (window.innerHeight - 80)) {
                top = Math.round(r.bottom + 8);
                right = Math.max(isMobile ? 10 : 16, Math.round(window.innerWidth - r.right));
            } else {
                top = isMobile ? 62 : 24;
                right = isMobile ? 10 : 24;
            }
        }

        // Trên mobile luôn đảm bảo nằm dưới header và căn phải chuẩn
        if (isMobile) {
            top = Math.max(62, top);
            right = 10;
        }

        // Trên PC nếu panel cartPreview đang mở, đặt toast bên trái của panel để không bị che
        var panelEl = document.getElementById('cartPreview');
        if (!isMobile && panelEl && !panelEl.hidden && panelEl.classList.contains('is-active')) {
            var pr = panelEl.getBoundingClientRect();
            if (pr.left > 0) {
                right = Math.max(16, Math.round(window.innerWidth - pr.left + 12));
            }
        }

        return { top: top, right: right };
    }

    function toast(message, type, customTitle){
        // Trên PC: ẩn đi không cần thông báo theo yêu cầu
        if (window.innerWidth > 991) {
            return;
        }

        var iconType = (type === 'error' || type === 'danger') ? 'error' : (type === 'warning' ? 'warning' : (type === 'info' ? 'info' : 'success'));
        
        var iconHtml = '';
        if (iconType === 'success') {
            iconHtml = '<div class="pk-toast-icon-wrap pk-check-animated">' +
                '<svg class="pk-toast-check-svg" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">' +
                    '<defs>' +
                        '<linearGradient id="pkCheckGrad" x1="0%" y1="0%" x2="100%" y2="100%">' +
                            '<stop offset="0%" stop-color="#10b981"/>' +
                            '<stop offset="100%" stop-color="#059669"/>' +
                        '</linearGradient>' +
                    '</defs>' +
                    '<circle class="pk-check-circle" cx="14" cy="14" r="13" fill="url(#pkCheckGrad)"/>' +
                    '<path class="pk-check-stroke" d="M8.5 14.2l3.6 3.6 7.4-7.4" fill="none" stroke="#ffffff" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/>' +
                '</svg>' +
            '</div>';
        } else if (iconType === 'error') {
            iconHtml = '<div class="pk-toast-icon-wrap pk-error-wrap">' +
                '<svg class="pk-toast-check-svg" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">' +
                    '<circle class="pk-error-circle" cx="14" cy="14" r="13" fill="#f43f5e"/>' +
                    '<path d="M9.5 9.5l9 9M18.5 9.5l-9 9" fill="none" stroke="#ffffff" stroke-width="2.4" stroke-linecap="round"/>' +
                '</svg>' +
            '</div>';
        } else if (iconType === 'warning') {
            iconHtml = '<div class="pk-toast-icon-wrap pk-warning-wrap">' +
                '<svg class="pk-toast-check-svg" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">' +
                    '<circle class="pk-error-circle" cx="14" cy="14" r="13" fill="#f59e0b"/>' +
                    '<path d="M14 8v7M14 18v1" fill="none" stroke="#ffffff" stroke-width="2.4" stroke-linecap="round"/>' +
                '</svg>' +
            '</div>';
        } else {
            iconHtml = '<div class="pk-toast-icon-wrap pk-info-wrap">' +
                '<svg class="pk-toast-check-svg" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">' +
                    '<circle class="pk-error-circle" cx="14" cy="14" r="13" fill="#0284c7"/>' +
                    '<path d="M14 9v1M14 13v6" fill="none" stroke="#ffffff" stroke-width="2.4" stroke-linecap="round"/>' +
                '</svg>' +
            '</div>';
        }

        var pos = calcToastPosition();

        if (typeof Swal !== 'undefined' && Swal.fire) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                showCloseButton: false,
                timer: 2000,
                timerProgressBar: true,
                customClass: {
                    container: 'pk-toast-container',
                    popup: 'pk-toast-card pk-toast-' + iconType,
                    timerProgressBar: 'pk-toast-progress-bar'
                },
                didOpen: function(popup){
                    var container = popup.closest('.swal2-container');
                    if (container) {
                        container.style.setProperty('top', pos.top + 'px', 'important');
                        container.style.setProperty('right', pos.right + 'px', 'important');
                        container.style.setProperty('bottom', 'auto', 'important');
                        container.style.setProperty('left', 'auto', 'important');
                    }
                },
                html: '<div class="pk-toast-body">' +
                        '<div class="pk-toast-text-wrap">' +
                            '<span class="pk-toast-message">' + message + '</span>' +
                            '<a class="pk-toast-cart-link" href="' + base + '/gio-hang.html">' +
                                '<i class="fa-solid fa-cart-shopping"></i> Xem giỏ hàng' +
                            '</a>' +
                        '</div>' +
                        iconHtml +
                      '</div>'
            });
        }
    }
    window.pkToast = toast;

    function getVisibleCartTarget(){
        var targets = document.querySelectorAll('.site-cart-link, .site-cart-floating');
        for (var i = 0; i < targets.length; i++) {
            var el = targets[i];
            var style = window.getComputedStyle(el);
            if (style.display !== 'none' && style.visibility !== 'hidden') {
                var rect = el.getBoundingClientRect();
                if (rect.width > 0 && rect.height > 0) {
                    if (rect.top >= -20 && rect.bottom <= (window.innerHeight + 20)) {
                        return el;
                    }
                }
            }
        }
        for (var j = 0; j < targets.length; j++) {
            if (targets[j].getBoundingClientRect().width > 0) return targets[j];
        }
        return null;
    }

    var autoHideTimer = null;

    function clearAutoHide(){
        if (autoHideTimer) {
            clearTimeout(autoHideTimer);
            autoHideTimer = null;
        }
    }

    function scheduleAutoHide(){
        clearAutoHide();
        autoHideTimer = setTimeout(function(){
            hidePanel();
        }, 4000);
    }

    function positionPanel(){
        if (window.innerWidth <= 991) return;
        var target = getVisibleCartTarget();
        if(!target) return;
        var r = target.getBoundingClientRect();
        var isFloating = target.classList.contains('site-cart-floating');
        var panelWidth = 290;

        panel.classList.remove('is-mobile');
        var isBottom = isFloating || r.bottom > (window.innerHeight - 260);
        panel.classList.toggle('is-bottom', isBottom);

        var rightPos = Math.max(16, window.innerWidth - r.right);
        if (window.innerWidth - rightPos - panelWidth < 16) {
            rightPos = Math.max(12, window.innerWidth - panelWidth - 16);
        }
        panel.style.right = rightPos + 'px';
        panel.style.left = 'auto';

        if (isBottom) {
            panel.style.top = 'auto';
            panel.style.bottom = Math.max(16, window.innerHeight - r.top + 10) + 'px';
        } else {
            panel.style.top = (r.bottom + 10) + 'px';
            panel.style.bottom = 'auto';
        }
    }

    function showPanel(){
        if (window.innerWidth <= 991) {
            hidePanel();
            return;
        }
        panel.hidden = false;
        positionPanel();
        requestAnimationFrame(function(){
            panel.classList.add('is-active');
        });
        scheduleAutoHide();
    }

    function hidePanel(){
        clearAutoHide();
        panel.classList.remove('is-active');
        setTimeout(function(){
            if (!panel.classList.contains('is-active')) {
                panel.hidden = true;
            }
        }, 300);
    }

    function triggerBounce(target){
        if (!target) return;
        target.classList.remove('cart-bounce');
        void target.offsetWidth;
        target.classList.add('cart-bounce');

        var badge = target.querySelector('.cart-badge');
        if (badge) {
            badge.classList.remove('badge-pulse');
            void badge.offsetWidth;
            badge.classList.add('badge-pulse');
        }
    }

    function render(data, open){
        if(!data || !data.data || !Array.isArray(data.data.items)) return;
        var count = data.cart_count || 0;
        $('.js-cart-count').text(count);
        $('.js-cart-preview-count').text(count);

        var subtotalText = data.data.formatted_subtotal || '0đ';
        $('.js-cart-preview-subtotal').text(subtotalText);

        var list = $(panel).find('.cart-preview-items').empty();
        var money = function(val){ return Number(val).toLocaleString('vi-VN') + 'đ'; };

        if (!data.data.items.length) {
            list.append(
                '<div class="cart-preview-empty">' +
                '<i class="fa-solid fa-cart-shopping"></i>' +
                '<p>Giỏ hàng đang trống</p>' +
                '<span>Chọn sản phẩm để thêm vào giỏ</span>' +
                '</div>'
            );
            $('.js-cart-preview-subtotal').text('0đ');
        } else {
            data.data.items.forEach(function(item){
                var priceStr = item.price > 0 ? money(item.price) : 'Liên hệ';
                var oldPriceStr = (item.original_price > item.price && item.price > 0)
                    ? '<del class="cart-preview-old">' + money(item.original_price) + '</del>'
                    : '';
                var qtyStr = 'x' + item.quantity + (item.unit ? ' ' + item.unit : '');

                var itemHtml = $(
                    '<div class="cart-preview-item">' +
                        '<img src="' + item.image + '" alt="' + item.name + '">' +
                        '<div class="cart-preview-info">' +
                            '<a href="' + (item.url || '#') + '" class="cart-preview-name" title="' + item.name + '">' + item.name + '</a>' +
                            '<div class="cart-preview-values">' +
                                '<span class="cart-preview-price">' + priceStr + '</span>' +
                                oldPriceStr +
                                '<span class="cart-preview-qty">' + qtyStr + '</span>' +
                            '</div>' +
                        '</div>' +
                        '<button type="button" class="cart-preview-remove" data-id="' + item.id + '" aria-label="Xóa ' + item.name + '" title="Xóa">' +
                            '<i class="fa-regular fa-trash-can" aria-hidden="true"></i>' +
                        '</button>' +
                    '</div>'
                );
                itemHtml.find('img').on('error', function(){
                    this.onerror = null;
                    this.src = base + '/template/page/assets/images/logo.png';
                });
                list.append(itemHtml);
            });
        }

        if (open && window.innerWidth > 991) {
            showPanel();
        }
    }

    // Pause auto-hide timer when mouse hovers over panel, resume when mouse leaves
    $(panel).on('mouseenter', function(){
        clearAutoHide();
    }).on('mouseleave', function(){
        if (panel.classList.contains('is-active') && window.innerWidth > 991) {
            scheduleAutoHide();
        }
    });

    function flyToCart(button, done){
        var target = getVisibleCartTarget();
        if(!target || matchMedia('(prefers-reduced-motion: reduce)').matches){
            if (typeof done === 'function') done();
            return;
        }

        var card = $(button).closest('.pm-product-card, .pd-hero, .pd-main, article');
        var sourceImg = card.find('.pm-img-container img, .pd-image-wrap img, img').filter(':visible')[0];

        var fromRect = sourceImg ? sourceImg.getBoundingClientRect() : button.getBoundingClientRect();
        var toRect = target.getBoundingClientRect();

        var startX = fromRect.left + fromRect.width / 2 - 27;
        var startY = fromRect.top + fromRect.height / 2 - 27;
        var endX = toRect.left + toRect.width / 2 - 27;
        var endY = toRect.top + toRect.height / 2 - 27;

        var flyer = document.createElement('div');
        flyer.className = 'cart-flying-thumb';
        var imgClone = document.createElement('img');
        imgClone.src = (sourceImg && sourceImg.src) ? sourceImg.src : (base + '/template/page/assets/images/logo.png');
        imgClone.alt = '';
        flyer.appendChild(imgClone);

        flyer.style.left = startX + 'px';
        flyer.style.top = startY + 'px';
        document.body.appendChild(flyer);

        var diffX = endX - startX;
        var diffY = endY - startY;

        var keyframes = [
            { transform: 'translate3d(0, 0, 0) scale(1)', opacity: 1 },
            { transform: 'translate3d(' + (diffX * 0.12) + 'px, -30px, 0) scale(1.15)', opacity: 1, offset: 0.2 },
            { transform: 'translate3d(' + (diffX * 0.6) + 'px, ' + (diffY * 0.45 - 35) + 'px, 0) scale(0.8)', opacity: 0.95, offset: 0.65 },
            { transform: 'translate3d(' + (diffX * 0.92) + 'px, ' + (diffY * 0.92) + 'px, 0) scale(0.35)', opacity: 0.6, offset: 0.92 },
            { transform: 'translate3d(' + diffX + 'px, ' + diffY + 'px, 0) scale(0.1)', opacity: 0, offset: 1 }
        ];

        var anim = flyer.animate(keyframes, {
            duration: 720,
            easing: 'cubic-bezier(0.2, 0.75, 0.25, 1)'
        });

        var finished = false;
        function finishFly(){
            if(finished) return;
            finished = true;
            flyer.remove();
            triggerBounce(target);
            if (typeof done === 'function') done();
        }

        anim.onfinish = finishFly;
        anim.oncancel = finishFly;
    }

    // Add to cart click
    $(document).on('click', '.js-add-to-cart, .js-detail-add-cart', function(){
        var button = this;
        var originalHtml = button.innerHTML;
        button.disabled = true;
        button.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Đang thêm...';
        revision++;

        var flyDone = false, ajaxDone = false, responseData = null;

        function checkComplete(){
            if (flyDone && ajaxDone) {
                button.disabled = false;
                button.innerHTML = originalHtml;
                if (responseData && responseData.success) {
                    render(responseData, false);
                    if (window.innerWidth > 991) {
                        showPanel();
                    } else {
                        toast(responseData.message || 'Đã thêm sản phẩm vào giỏ hàng.', 'success');
                    }
                }
            }
        }

        flyToCart(button, function(){
            flyDone = true;
            checkComplete();
        });

        $.ajax({
            url: base + '/api/cartAdd',
            type: 'POST',
            dataType: 'json',
            headers: cartHeaders,
            data: {
                product_id: button.dataset.productId,
                quantity: 1
            }
        })
        .done(function(data){
            ajaxDone = true;
            responseData = data;
            if (!data.success) {
                button.disabled = false;
                button.innerHTML = originalHtml;
                toast(data.message || 'Không thể thêm sản phẩm.', 'error');
                return;
            }
            checkComplete();
        })
        .fail(function(){
            ajaxDone = true;
            button.disabled = false;
            button.innerHTML = originalHtml;
            toast('Không thể kết nối đến máy chủ. Vui lòng thử lại.', 'error');
        });
    });

    // Remove item
    $(panel).on('click', '.cart-preview-remove', function(){
        var button = this;
        button.disabled = true;
        revision++;
        $.ajax({
            url: base + '/api/cartRemove',
            type: 'POST',
            dataType: 'json',
            headers: cartHeaders,
            data: { product_id: button.dataset.id }
        })
        .done(function(data){
            if(data.success){
                render(data, true);
                toast('Đã xóa sản phẩm khỏi giỏ hàng.', 'success');
                if (document.getElementById('cartCheckoutForm')) {
                    location.reload();
                }
            } else {
                toast(data.message || 'Không thể xóa sản phẩm.', 'error');
            }
        })
        .fail(function(){
            toast('Không thể xóa sản phẩm. Vui lòng thử lại.', 'error');
        })
        .always(function(){
            button.disabled = false;
        });
    });

    // Toggle panel on cart button click
    $(document).on('click', '.site-cart-link, .site-cart-floating', function(event){
        // Trên mobile: Bỏ popup cartPreview, chuyển thẳng sang trang giỏ hàng
        if (window.innerWidth <= 991) {
            return;
        }
        event.preventDefault();
        if (panel.classList.contains('is-active')) {
            hidePanel();
            return;
        }
        var curRev = revision;
        $.getJSON(base + '/api/cartSummary')
        .done(function(data){
            if (curRev !== revision) return;
            if (data.success) {
                render(data, true);
            } else {
                toast(data.message || 'Không thể tải giỏ hàng.', 'error');
            }
        })
        .fail(function(){
            toast('Không thể tải giỏ hàng. Vui lòng thử lại.', 'error');
        });
    });

    // Close on button click
    $(panel).find('.cart-preview-close').on('click', function(){
        hidePanel();
    });

    // Close on outside click
    document.addEventListener('click', function(event){
        if (!panel.contains(event.target) && !event.target.closest('.site-cart-link, .site-cart-floating, .js-add-to-cart, .js-detail-add-cart')) {
            hidePanel();
        }
    });

    // Close on Escape key
    document.addEventListener('keydown', function(event){
        if (event.key === 'Escape') {
            hidePanel();
        }
    });

    // Window resize / scroll
    window.addEventListener('resize', function(){
        if (panel.classList.contains('is-active')) positionPanel();
    });
    window.addEventListener('scroll', function(){
        if (panel.classList.contains('is-active')) positionPanel();
    }, { passive: true });
});
</script>
