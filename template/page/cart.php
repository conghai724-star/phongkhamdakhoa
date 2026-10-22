<?php
$cart_items = is_array($cart_items ?? null) ? $cart_items : array();
$cart_vouchers = is_array($cart_vouchers ?? null) ? $cart_vouchers : array();
$cart_count = isset($cart_count) ? (int)$cart_count : 0;
$cart_user_points = isset($cart_user_points) ? max(0, (int)$cart_user_points) : 0;
$cart_user = isset($cart_user) && is_object($cart_user) ? $cart_user : null;
$cartCustomerName = $cart_user ? (string)$cart_user->user_fullname : '';
$cartCustomerPhone = $cart_user ? (string)$cart_user->user_phone : '';
$cartCustomerEmail = $cart_user ? (string)$cart_user->user_email : '';
$cartCustomerAddress = $cart_user ? (string)$cart_user->user_address : '';
// Nạp Header hệ thống (từ header_new.php)
require "header_new.php";
?>

<!-- ĐÓNG DỨT ĐIỂM CÁC THẺ SLIDER ĐANG MỞ DỞ TỪ HEADER_NEW.PHP -->
    </div>
  </div>
</section>

<style>
/* CSS RIÊNG CÔ LẬP CHO TRANG ĐẶT HÀNG (TRÁNH XUNG ĐỘT CSS TOÀN CỤC) */
.checkout-page-wrapper {
  box-sizing: border-box;
  background-color: #f4f6f9;
  padding: 20px 12px 140px 12px;
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
  color: #2c3e50;
}
.checkout-page-wrapper *, .checkout-page-wrapper *::before, .checkout-page-wrapper *::after {
  box-sizing: border-box;
}

.checkout-container {
  max-width: 1140px;
  margin: 0 auto;
}

.checkout-nav-back {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 16px;
  font-size: 13px;
}
.checkout-nav-back a {
  color: #1760a5;
  font-weight: 700;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 6px;
}

/* BỐ CỤC 2 CỘT */
.checkout-layout {
  display: flex;
  flex-direction: column;
  gap: 20px;
}
@media (min-width: 992px) {
  .checkout-layout {
    flex-direction: row;
    align-items: flex-start;
  }
  .checkout-col-main {
    flex: 0 0 calc(66.666% - 14px);
    max-width: calc(66.666% - 14px);
  }
  .checkout-col-side {
    flex: 0 0 calc(33.333% - 6px);
    max-width: calc(33.333% - 6px);
    position: sticky;
    top: 75px;
  }
}

/* THẺ CARD TRẮNG */
.lc-card {
  background: #ffffff;
  border-radius: 16px;
  border: 1px solid #e5e9f2;
  box-shadow: 0 2px 8px rgba(0,0,0,0.04);
  padding: 18px;
  margin-bottom: 18px;
}

/* TAB GIAO HÀNG */
.delivery-tab-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 14px;
}
.delivery-tab-box {
  background: #e2e8f0;
  border-radius: 12px;
  padding: 4px;
  display: inline-flex;
}
.delivery-tab-btn {
  border: none;
  background: transparent;
  padding: 8px 16px;
  font-size: 13px;
  font-weight: 600;
  border-radius: 8px;
  cursor: pointer;
  color: #4a5568;
  transition: 0.2s;
}
.delivery-tab-btn.active {
  background: #1760a5;
  color: #ffffff;
  box-shadow: 0 2px 6px rgba(23,96,165,0.25);
}

/* FORM FIELDS */
.lc-form-row {
  display: flex;
  gap: 12px;
  margin-bottom: 12px;
}
.lc-form-col {
  flex: 1;
}
.lc-input {
  width: 100% !important;
  height: 44px;
  border: 1px solid #cbd5e1;
  border-radius: 10px;
  padding: 0 14px;
  font-size: 13px;
  color: #1e293b;
  outline: none;
  background: #fff;
}
.lc-input:focus {
  border-color: #1760a5;
  box-shadow: 0 0 0 2px rgba(23,96,165,0.15);
}

/* NÚT CHỌN ĐỊA CHỈ & GPS */
.addr-select-btn {
  width: 100%;
  height: 44px;
  border: 1px solid #cbd5e1;
  background: #f8fafc;
  border-radius: 10px;
  padding: 0 14px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  cursor: pointer;
  font-size: 13px;
  color: #334155;
  margin-bottom: 12px;
}
.gps-quick-btn {
  height: 44px;
  border: 1px solid #bfdbfe;
  background: #eff6ff;
  color: #1760a5;
  border-radius: 10px;
  padding: 0 14px;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-size: 12px;
  font-weight: 700;
  cursor: pointer;
  white-space: nowrap;
}

/* DANH SÁCH SẢN PHẨM */
.product-item-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 12px 0;
  border-bottom: 1px solid #f1f5f9;
  gap: 12px;
}
.product-item-row:last-child {
  border-bottom: none;
}
.prod-img {
  width: 54px;
  height: 54px;
  border-radius: 8px;
  object-fit: cover;
  border: 1px solid #e2e8f0;
}
.prod-info {
  flex: 1;
  min-width: 0;
}
.prod-title {
  font-size: 13px;
  font-weight: 700;
  margin: 0 0 3px 0;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.prod-spec {
  font-size: 11px;
  color: #64748b;
  margin: 0;
}
.prod-price {
  font-size: 13px;
  font-weight: 800;
  color: #e36928;
}

/* BỘ TĂNG GIẢM SỐ LƯỢNG */
.qty-stepper {
  display: inline-flex;
  align-items: center;
  border: 1px solid #cbd5e1;
  border-radius: 8px;
  overflow: hidden;
}
.qty-stepper button {
  width: 28px;
  height: 28px;
  border: none;
  background: #f1f5f9;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 10px;
}
.qty-stepper button:disabled {
  opacity: 0.3;
  cursor: not-allowed;
}
.qty-stepper span {
  width: 32px;
  text-align: center;
  font-size: 12px;
  font-weight: 700;
}
.btn-del-prod {
  border: none;
  background: transparent;
  color: #94a3b8;
  cursor: pointer;
  padding: 6px;
  font-size: 13px;
}
.btn-del-prod:hover { color: #ef4444; }

/* CỘT PHẢI CHI TIẾT THANH TOÁN */
.bill-summary-row {
  display: flex;
  justify-content: space-between;
  font-size: 13px;
  color: #475569;
  margin-bottom: 10px;
}
.savings-box {
  background: #ecfdf5;
  border: 1px solid #a7f3d0;
  border-radius: 10px;
  padding: 10px 12px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  color: #065f46;
  font-size: 13px;
  margin: 14px 0;
}
.btn-order-submit {
  width: 100%;
  background: #1760a5;
  color: #fff;
  border: none;
  height: 48px;
  border-radius: 12px;
  font-size: 14px;
  font-weight: 800;
  cursor: pointer;
  box-shadow: 0 4px 12px rgba(23,96,165,0.25);
  transition: 0.3s;
}
.btn-order-submit:hover {
  background: #0f4b85;
}

/* THANH CỐ ĐỊNH MOBILE */
.mobile-fixed-bottom-bar {
  display: none;
}
@media (max-width: 991px) {
  .checkout-col-side { display: none !important; }
  .mobile-fixed-bottom-bar {
    display: block;
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: #ffffff;
    box-shadow: 0 -4px 16px rgba(0,0,0,0.08);
    border-top: 1px solid #e2e8f0;
    z-index: 99999;
  }
  .mob-bar-top {
    padding: 8px 12px;
    background: #f8fbff;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 12px;
  }
  .mob-bar-main {
    padding: 10px 14px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .mob-btn-submit {
    background: #1760a5;
    color: #fff;
    border: none;
    padding: 10px 22px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 800;
  }
}

/* MODAL TIỆN ÍCH */
.lc-modal {
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.5);
  backdrop-filter: blur(2px);
  z-index: 100000;
  display: none;
  align-items: center;
  justify-content: center;
  padding: 14px;
}
.lc-modal.active { display: flex; }
.lc-modal-content {
  background: #fff;
  border-radius: 16px;
  width: 100%;
  max-width: 480px;
  max-height: 85vh;
  display: flex;
  flex-direction: column;
  overflow: hidden;
  box-shadow: 0 10px 25px rgba(0,0,0,0.2);
}

/* CARD VOUCHER TRONG MODAL */
.voucher-card-item {
  border: 1px solid #e2e8f0;
  border-radius: 12px;
  padding: 14px;
  margin-bottom: 12px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 12px;
  transition: all 0.2s;
  background: #fff;
}
.voucher-card-item.selected {
  border-color: #1760a5;
  background: #f0f7ff;
  box-shadow: 0 0 0 1px #1760a5;
}
.voucher-card-item.disabled {
  opacity: 0.6;
  background: #f8fafc;
}
.voucher-apply-btn {
  background: #1760a5;
  color: #fff;
  border: none;
  padding: 7px 14px;
  border-radius: 8px;
  font-size: 12px;
  font-weight: 700;
  cursor: pointer;
  white-space: nowrap;
}
.voucher-remove-btn {
  background: #fee2e2;
  color: #dc2626;
  border: 1px solid #fca5a5;
  padding: 7px 14px;
  border-radius: 8px;
  font-size: 12px;
  font-weight: 700;
  cursor: pointer;
  white-space: nowrap;
}
</style>

<div class="checkout-page-wrapper">
  <div class="checkout-container">
<?php if (!empty($_SESSION['customer']['id'])): ?>
<div class="mb-3">Xin chào <?php echo htmlspecialchars($_SESSION['customer']['fullname'], ENT_QUOTES, 'UTF-8'); ?> · <a href="<?php echo XC_URL; ?>/page/customerprofile">Thông tin tài khoản</a> · Điểm thành viên: <?php echo number_format($cart_user_points); ?></div>
<?php else: ?>
<div class="mb-3"><a href="<?php echo XC_URL; ?>/login">Đăng nhập bằng Zalo để mua hàng và tích điểm</a></div>
<?php endif; ?>

    
    <!-- Top Nav -->
    <div class="checkout-nav-back">
      <a href="<?php echo XC_URL; ?>/nha-thuoc.html">
        <i class="fa-solid fa-arrow-left"></i> Quay lại danh mục thuốc
      </a>
      <span><i class="fa-solid fa-shield-halved"></i> Đảm bảo thuốc chính hãng 100%</span>
    </div>

    <div class="checkout-layout">
      
      <!-- ================= CỘT CHÍNH ================= -->
      <div class="checkout-col-main">

        <!-- Banner Freeship (Hiển thị khi chuyển sang giao tận nơi) -->
        <div id="shippingBanner" class="lc-card" style="background: #eef6ff; border-color: #bfdbfe; margin-bottom: 14px; display: none;">
          <div style="display: flex; gap: 12px; align-items: flex-start;">
            <div style="width: 32px; height: 32px; border-radius: 50%; background: #1760a5; color: #fff; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
              <i class="fa-solid fa-truck-fast"></i>
            </div>
            <div>
              <strong style="color: #1760a5; font-size: 13px;">Chính sách giao nhận tận nơi</strong>
              <p style="font-size: 12px; margin: 2px 0 0 0; color: #1e3a8a;">
                Miễn phí giao hàng cho đơn từ <strong>300.000đ trở lên</strong> trong nội thị & bán kính ≤ <strong>3 km</strong>.
              </p>
              <div id="shippingStatusNotice" style="font-size: 11px; font-weight: 700; color: #15803d; margin-top: 4px;"></div>
            </div>
          </div>
        </div>

        <!-- Khung Nhận Hàng -->
        <div class="lc-card">
          <div class="delivery-tab-header">
            <strong style="font-size: 14px;">Hình thức nhận hàng</strong>
            <div class="delivery-tab-box">
              <button id="tabPickup" class="delivery-tab-btn active" onclick="switchDeliveryMode('pickup')">Tại quầy</button>
              <button id="tabDelivery" class="delivery-tab-btn" onclick="switchDeliveryMode('delivery')">Giao tận nơi</button>
            </div>
          </div>

          <!-- 1. Thông tin người đặt -->
          <div style="margin-bottom: 16px;">
            <strong style="font-size: 13px; display: block; margin-bottom: 8px;">Thông tin khách hàng</strong>
            <div class="lc-form-row">
              <div class="lc-form-col">
                <input type="text" id="orderName" class="lc-input" placeholder="Họ và tên khách hàng" 
                  value="<?php echo htmlspecialchars($cartCustomerName, ENT_QUOTES, 'UTF-8'); ?>" maxlength="255" required>
              </div>
              <div class="lc-form-col">
                <input type="tel" id="orderPhone" class="lc-input" placeholder="Số điện thoại" 
                  value="<?php echo htmlspecialchars($cartCustomerPhone, ENT_QUOTES, 'UTF-8'); ?>" maxlength="20" required>
              </div>
            </div>
            <input type="email" id="orderEmail" class="lc-input" placeholder="Email nhận thông báo (không bắt buộc)" value="<?php echo htmlspecialchars($cartCustomerEmail, ENT_QUOTES, 'UTF-8'); ?>" maxlength="255">
          </div>

          <hr style="border: 0; border-top: 1px solid #f1f5f9; margin: 16px 0;">

          <!-- 2.A: Nhận tại quầy (Mặc định hiển thị) -->
          <div id="sectionPickup" style="display: block;">
            <div style="padding: 16px; background: #f0fdf4; border: 1.5px solid #86efac; border-radius: 14px;">
              <div style="display: flex; gap: 10px; align-items: center; margin-bottom: 6px;">
                <span style="width: 24px; height: 24px; border-radius: 50%; background: #16a34a; color: #fff; display: inline-flex; align-items: center; justify-content: center; font-size: 11px;">
                  <i class="fa-solid fa-check"></i>
                </span>
                <strong style="font-size: 14px; color: #166534;">Nhận tại Nhà thuốc Trường Cao đẳng Kon Tum</strong>
              </div>
              <p style="font-size: 12.5px; color: #374151; margin: 4px 0 6px 34px; line-height: 1.5;">
                <i class="fa-solid fa-location-dot" style="color: #dc2626; margin-right: 4px;"></i>
                <strong>Địa chỉ:</strong> <?php echo $this->helper->get_config('site_address'); ?>[cite: 13]
              </p>
              <div style="margin-left: 34px; display: flex; flex-wrap: wrap; gap: 8px; font-size: 11.5px; margin-top: 6px;">
                <span style="background: #dcfce7; color: #15803d; padding: 3px 8px; border-radius: 6px; font-weight: 700;">
                  <i class="fa-solid fa-box-check"></i> Miễn phí nhận tại quầy
                </span>
                <span style="background: #e0f2fe; color: #0369a1; padding: 3px 8px; border-radius: 6px; font-weight: 600;">
                  <i class="fa-regular fa-clock"></i> Mở cửa: 07:00 - 21:00 (hằng ngày)[cite: 13]
                </span>
              </div>
            </div>
          </div>

          <!-- 2.B: Giao tận nơi (Mặc định ẩn) -->
          <div id="sectionDelivery" style="display: none;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
              <strong style="font-size: 13px;">Địa chỉ nhận thuốc tận nơi</strong>
              <label style="font-size: 12px; color: #64748b; cursor: pointer;">
                <input type="checkbox" id="sameReceiver" onchange="toggleSameReceiver(this)" checked> Người nhận là người đặt
              </label>
            </div>

            <div class="lc-form-row">
              <div class="lc-form-col">
                <input type="text" id="recvName" class="lc-input" placeholder="Họ tên người nhận" value="<?php echo htmlspecialchars($cartCustomerName, ENT_QUOTES, 'UTF-8'); ?>" maxlength="255">
              </div>
              <div class="lc-form-col">
                <input type="tel" id="recvPhone" class="lc-input" placeholder="SĐT người nhận" value="<?php echo htmlspecialchars($cartCustomerPhone, ENT_QUOTES, 'UTF-8'); ?>" maxlength="20">
              </div>
            </div>

            <div style="display: flex; gap: 8px;">
              <div class="addr-select-btn" onclick="openAddressModal()">
                <span id="selectedAddressText">Chọn Tỉnh/Thành phố, Xã/Phường</span>
                <span style="color: #1760a5; font-weight: 700; font-size: 12px;">Đổi</span>
              </div>
              <button type="button" class="gps-quick-btn" onclick="getCurrentLocationGPS()">
                <i id="gpsIcon" class="fa-solid fa-crosshairs"></i>
                <span id="gpsBtnText">GPS</span>
              </button>
            </div>

            <input type="text" id="specificAddress" class="lc-input" style="margin-bottom: 12px;" 
              placeholder="Số nhà, ngõ, tên đường..." value="<?php echo htmlspecialchars($cartCustomerAddress, ENT_QUOTES, 'UTF-8'); ?>" maxlength="500">

            <div style="display: flex; justify-content: space-between; align-items: center; background: #f8fafc; padding: 10px 14px; border-radius: 10px; font-size: 12px; margin-bottom: 12px; border: 1px solid #e2e8f0;">
              <span>Phục vụ bởi: <strong id="nearestBranchName">Nhà thuốc CĐ Kon Tum</strong></span>
              <span id="autoDistanceTag" style="background: #dbeafe; color: #1e40af; padding: 2px 8px; border-radius: 6px; font-weight: 700;">~1.8 km</span>
            </div>

            <input type="text" id="deliveryNote" class="lc-input" placeholder="Ghi chú giao hàng (ví dụ: giao giờ hành chính)..." maxlength="1000">
          </div>

        </div>

        <!-- Khung Sản Phẩm Đã Chọn -->
        <div class="lc-card">
          <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; border-bottom: 1px solid #f1f5f9; padding-bottom: 10px;">
            <strong style="font-size: 14px;">Sản phẩm đã chọn (<span id="cartCount" style="color: #e36928;"><?php echo $cart_count; ?></span>)</strong>
            <span style="font-size: 11px; color: #94a3b8;">Số lượng tối thiểu: 1</span>
          </div>
          <div id="orderItemsContainer"></div>
        </div>

      </div>

      <!-- ================= CỘT PHẢI (DESKTOP) ================= -->
      <div class="checkout-col-side">
        
        <!-- Khung Ưu Đãi & Điểm Thưởng -->
        <div class="lc-card" style="padding: 0; overflow: hidden;">
          <div style="padding: 12px 16px; background: #f8fbff; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
            <strong style="font-size: 13px; color: #1760a5;"><i class="fa-solid fa-gift" style="color: #e36928;"></i> Ưu đãi & Giảm giá</strong>
            <span id="discountBadgeDesktop" style="font-size: 11px; font-weight: 700; color: #e36928; background: #fff; padding: 2px 8px; border-radius: 20px; border: 1px solid #fed7aa;"><?php echo count($cart_vouchers); ?> mã khả dụng</span>
          </div>

          <div style="padding: 16px;">
            <!-- Box Voucher -->
            <div id="voucherDisplayBox" onclick="openVoucherModal()" style="border: 1.5px dashed #93c5fd; background: #f0f7ff; padding: 12px; border-radius: 12px; cursor: pointer; display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; transition: 0.2s;">
              <div style="display: flex; gap: 10px; align-items: center; overflow: hidden;">
                <div style="width: 32px; height: 32px; border-radius: 8px; background: #1760a5; color: #fff; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 13px;">
                  <i class="fa-solid fa-ticket"></i>
                </div>
                <div style="overflow: hidden;">
                  <span id="appliedVoucherTitleDesktop" style="font-size: 12.5px; font-weight: 700; color: #1e293b; display: block; white-space: nowrap; text-overflow: ellipsis;">Chọn mã ưu đãi</span>
                  <span id="appliedVoucherSubDesktop" style="font-size: 11px; color: #64748b; display: block;">Giảm thêm tiền cho đơn hàng</span>
                </div>
              </div>
              <span id="voucherActionBtnText" style="font-size: 12px; color: #1760a5; font-weight: 800; white-space: nowrap; margin-left: 6px;">Chọn</span>
            </div>

            <!-- Box Điểm Thưởng -->
            <label style="display: flex; justify-content: space-between; align-items: center; cursor: pointer; padding: 10px 12px; background: #fffbeb; border: 1px solid #fde68a; border-radius: 12px;">
              <div style="display: flex; gap: 10px; align-items: center;">
                <div style="width: 32px; height: 32px; border-radius: 8px; background: #d97706; color: #fff; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 13px;">
                  <i class="fa-solid fa-coins"></i>
                </div>
                <div>
                  <span style="font-size: 12.5px; font-weight: 700; color: #92400e; display: block;">Dùng điểm tích luỹ</span>
                  <span style="font-size: 11px; color: #b45309; display: block;">Hiện có: <strong id="pointBalanceDesktop"><?php echo $cart_user_points; ?> điểm</strong> (quy đổi <span id="pointValueDesktop"><?php echo number_format($cart_user_points * 1000, 0, ',', '.'); ?>đ</span>)</span>
                </div>
              </div>
              <input type="checkbox" id="pointCheckboxDesktop" onchange="syncPoints(this.checked)" style="width: 20px; height: 20px; cursor: pointer; accent-color: #1760a5;" <?php echo (!$cart_user || $cart_user_points < 1) ? 'disabled' : ''; ?>>
            </label>
          </div>
        </div>

        <!-- Chi tiết hoá đơn -->
        <div class="lc-card">
          <strong style="font-size: 14px; display: block; margin-bottom: 14px; border-bottom: 1px solid #f1f5f9; padding-bottom: 8px;">Chi tiết thanh toán</strong>
          
          <div class="bill-summary-row">
            <span>Tiền hàng</span>
            <strong id="subTotalTextDesktop">0đ</strong>
          </div>
          <div class="bill-summary-row">
            <span>Phí giao hàng</span>
            <strong id="shippingFeeTextDesktop" style="color: #16a34a;">Miễn phí (Tại quầy)</strong>
          </div>
          <div id="voucherRowDesktop" class="bill-summary-row" style="display: none; color: #15803d; font-weight: 600;">
            <span>Ưu đãi voucher</span>
            <strong id="voucherDiscountTextDesktop">-0đ</strong>
          </div>
          <div id="pointsRowDesktop" class="bill-summary-row" style="display: none; color: #15803d; font-weight: 600;">
            <span>Điểm tích luỹ (<span id="pointsUsedLabelDesktop">0</span> điểm)</span>
            <strong id="pointsDiscountTextDesktop">-0đ</strong>
          </div>

          <div class="savings-box">
            <span style="font-weight: 700;"><i class="fa-solid fa-piggy-bank"></i> Tiết kiệm được:</span>
            <strong id="savedAmountTextDesktop" style="font-size: 14px;">0đ</strong>
          </div>

          <div style="display: flex; justify-content: space-between; align-items: baseline; border-top: 1px solid #f1f5f9; padding-top: 12px; margin-bottom: 14px;">
            <span style="font-weight: 700; font-size: 14px;">Tổng thanh toán:</span>
            <strong id="totalAmountTextDesktop" style="font-size: 22px; color: #e36928; font-weight: 900;">0đ</strong>
          </div>

          <button id="desktopSubmitBtn" class="btn-order-submit">TIẾN HÀNH ĐẶT HÀNG</button>
        </div>

      </div>

    </div>
  </div>
</div>

<!-- ================= MOBILE ONLY: BOTTOM BAR ================= -->
<div class="mobile-fixed-bottom-bar">
  <div class="mob-bar-top">
    <span onclick="openVoucherModal()" style="cursor: pointer; color: #1760a5; font-weight: 700;">
      <i class="fa-solid fa-ticket" style="color: #e36928;"></i> Voucher: <span id="mobileVoucherSnippet">Chọn mã</span>
    </span>
    <label style="cursor: pointer; display: flex; align-items: center; gap: 5px; font-weight: 600; color: #92400e;">
      <input type="checkbox" id="pointCheckboxMobile" onchange="syncPoints(this.checked)" style="accent-color: #1760a5;" <?php echo (!$cart_user || $cart_user_points < 1) ? 'disabled' : ''; ?>> <span id="mobilePointLabel">Dùng <?php echo $cart_user_points; ?> điểm (-<?php echo number_format($cart_user_points, 0, ',', '.'); ?>k)</span>
    </label>
  </div>
  <div class="mob-bar-main">
    <div>
      <span style="font-size: 11px; color: #64748b;">Tổng: </span>
      <strong id="totalAmountTextMobile" style="font-size: 18px; color: #e36928; font-weight: 900;">0đ</strong>
      <div style="font-size: 10.5px; color: #64748b;">
        Tiền hàng: <span id="subTotalTextMobile">0đ</span> · Phí giao hàng: <span id="shippingFeeTextMobile">0đ</span>
      </div>
      <div style="font-size: 11px; color: #15803d; font-weight: 700;">Tiết kiệm: <span id="savedAmountTextMobile">0đ</span></div>
    </div>
    <button id="mobileSubmitBtn" class="mob-btn-submit">ĐẶT HÀNG</button>
  </div>
</div>

<!-- ================= MODAL CHỌN ĐỊA CHỈ (HÀNH CHÍNH 2 CẤP) ================= -->
<div id="addressModal" class="lc-modal">
  <div class="lc-modal-content">
    <div style="padding: 14px 18px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
      <strong style="font-size: 14px; color: #1760a5;">Chọn địa chỉ nhận hàng</strong>
      <button onclick="closeAddressModal()" style="border: none; background: transparent; font-size: 20px; cursor: pointer; color: #64748b;">&times;</button>
    </div>

    <div style="display: flex; border-bottom: 1px solid #e2e8f0; font-size: 12px; font-weight: 700;">
      <button id="stepTabProvince" onclick="switchAddressStep('province')" style="flex: 1; padding: 10px; border: none; background: transparent; border-bottom: 2px solid #1760a5; color: #1760a5; cursor: pointer;">1. Tỉnh / Thành phố</button>
      <button id="stepTabWard" onclick="switchAddressStep('ward')" style="flex: 1; padding: 10px; border: none; background: transparent; color: #94a3b8; cursor: not-allowed;" disabled>2. Xã / Phường</button>
    </div>

    <div style="padding: 10px 14px; border-bottom: 1px solid #f1f5f9;">
      <input type="text" id="addressSearchInput" oninput="filterAddressList(this.value)" placeholder="Tìm kiếm nhanh..." class="lc-input" style="height: 38px;">
    </div>

    <div id="addressItemsContainer" style="flex: 1; overflow-y: auto; padding: 10px 14px;"></div>
  </div>
</div>

<!-- ================= MODAL VOUCHER ƯU ĐÃI (ĐÃ SỬA LỖI HIỂN THỊ) ================= -->
<div id="voucherModal" class="lc-modal">
  <div class="lc-modal-content" style="max-height: 85vh; display: flex; flex-direction: column;">
    <div style="padding: 14px 18px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; background: #f8fafc;">
      <div>
        <strong style="font-size: 14px; color: #1760a5;"><i class="fa-solid fa-ticket" style="color: #e36928;"></i> Mã giảm giá & Ưu đãi</strong>
        <p style="font-size: 11px; color: #64748b; margin: 2px 0 0 0;">Chọn 1 mã giảm giá áp dụng cho đơn hàng</p>
      </div>
      <button type="button" onclick="closeVoucherModal()" style="border: none; background: transparent; font-size: 22px; cursor: pointer; color: #64748b; line-height: 1;">&times;</button>
    </div>

    <!-- Ô nhập mã tay -->
    <div style="padding: 12px 16px; border-bottom: 1px solid #e2e8f0; background: #fff;">
      <div style="display: flex; gap: 8px;">
        <input type="text" id="manualVoucherInput" placeholder="Nhập mã voucher khác..." class="lc-input" style="height: 38px; text-transform: uppercase;">
        <button type="button" onclick="applyManualVoucher()" style="background: #1760a5; color: #fff; border: none; padding: 0 16px; border-radius: 10px; font-size: 12px; font-weight: 700; cursor: pointer; white-space: nowrap;">Áp dụng</button>
      </div>
      <p id="voucherErrorMsg" style="font-size: 11px; color: #dc2626; margin: 6px 0 0 0; display: none;"></p>
    </div>

    <!-- Danh sách Voucher -->
    <div id="voucherListContainer" style="flex: 1 1 auto; overflow-y: auto; padding: 14px; min-height: 240px; max-height: 50vh; background: #f8fafc;"></div>

    <div style="padding: 12px 16px; border-top: 1px solid #e2e8f0; background: #fff;">
      <button type="button" onclick="closeVoucherModal()" style="width: 100%; background: #1760a5; color: #fff; border: none; padding: 10px; border-radius: 10px; font-size: 13px; font-weight: 700; cursor: pointer;">Đóng & Cập nhật</button>
    </div>
  </div>
</div>

<!-- ================= SCRIPT LOGIC HOÀN CHỈNH ================= -->
<script>
  const pharmacyBranches = [
    { id: 1, name: "Nhà thuốc CĐ Kon Tum (105 Phan Chu Trinh)", lat: 14.3512, lng: 108.0021 },
    { id: 2, name: "Chi nhánh Đăk Hà", lat: 14.5028, lng: 107.9255 }
  ];

  let orderedProducts = <?php
    $productsForJs = array();
    foreach($cart_items as $item){
      $productsForJs[] = array(
        'id' => (int)$item->pid,
        'title' => (string)$item->product_name,
        'packing' => trim((string)$item->product_spec) !== '' ? (string)$item->product_spec : (string)$item->product_unit_name,
        'price' => (float)$item->final_price,
        'qty' => (int)$item->quantity,
        'img' => !empty($item->product_image) ? XC_URL.'/uploads/products/'.rawurlencode($item->product_image) : $template_path.'/assets/images/logo.png'
      );
    }
    echo json_encode($productsForJs, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
  ?>;

  let availableVouchers = <?php
    $vouchersForJs = array();
    foreach($cart_vouchers as $voucher){
      $vouchersForJs[] = array(
        'code' => (string)$voucher->code,
        'title' => (string)$voucher->name,
        'desc' => (string)$voucher->description,
        'minOrder' => (float)$voucher->min_order_value,
        'discountType' => (string)$voucher->discount_type,
        'discountValue' => (float)$voucher->discount_value,
        'maxDiscount' => $voucher->max_discount === null ? null : (float)$voucher->max_discount
      );
    }
    echo json_encode($vouchersForJs, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
  ?>;

  // Trạng thái đơn hàng: Mặc định 'pickup' (Nhận tại quầy)
  const orderState = {
    userPoints: <?php echo $cart_user_points; ?>,
    isLoggedIn: <?php echo $cart_user ? 'true' : 'false'; ?>,
    isUsePoints: false,
    selectedVoucher: null,
    distanceKm: 1.8,
    deliveryMode: 'pickup',
    standardShippingFee: 20000,
    addressSelection: { provinceCode: '', provinceName: '', wardCode: '', wardName: '' },
    currentStep: 'province'
  };
  let administrativeItems = [];

  function formatVND(amt) {
    return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amt);
  }

  const cartApiBase = <?php echo json_encode(XC_URL, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
  const cartApiHeaders = { 'X-Cart-CSRF': <?php echo json_encode($_SESSION['cart_csrf']); ?> };
  const updatingProductIds = {};

  function escapeHtml(value) {
    return String(value == null ? '' : value).replace(/[&<>'"]/g, function(char) {
      return { '&': '&amp;', '<': '&lt;', '>': '&gt;', "'": '&#039;', '"': '&quot;' }[char];
    });
  }

  function showCartToast(message, type) {
    if (typeof Swal === 'undefined' || !Swal.fire) return;
    Swal.fire({
      toast: true,
      position: 'bottom-end',
      icon: type === 'error' ? 'error' : 'success',
      text: message,
      showConfirmButton: false,
      timer: 2000,
      timerProgressBar: true
    });
  }

  function calculateVoucherDiscount(voucher, goodsTotal) {
    if (!voucher || goodsTotal < voucher.minOrder) return 0;
    var discount = voucher.discountType === 'percent'
      ? goodsTotal * Math.min(100, Math.max(0, voucher.discountValue)) / 100
      : Math.max(0, voucher.discountValue);
    if (voucher.maxDiscount !== null) discount = Math.min(discount, voucher.maxDiscount);
    return Math.min(goodsTotal, Math.round(discount));
  }

  function applyCartResponse(response) {
    if (!response || !response.data || !Array.isArray(response.data.items)) return;
    orderedProducts = response.data.items.map(function(item) {
      return {
        id: Number(item.id),
        title: item.name,
        packing: item.spec || item.unit || '',
        price: Number(item.price),
        qty: Number(item.quantity),
        img: item.image
      };
    });
    document.querySelectorAll('.js-cart-count').forEach(function(el) {
      el.textContent = response.cart_count || 0;
    });
    renderOrderedProducts();
  }

  // 1. RENDER SẢN PHẨM
  function renderOrderedProducts() {
    const container = document.getElementById('orderItemsContainer');
    document.getElementById('cartCount').innerText = orderedProducts.reduce(function(total, item) { return total + item.qty; }, 0);

    if (orderedProducts.length === 0) {
      container.innerHTML = '<p style="text-align: center; color: #94a3b8; font-size: 13px; padding: 20px 0;">Giỏ hàng trống.</p>';
      recalcSummary();
      return;
    }

    container.innerHTML = orderedProducts.map(p => `
      <div class="product-item-row">
        <img src="${escapeHtml(p.img)}" class="prod-img" alt="${escapeHtml(p.title)}">
        <div class="prod-info">
          <p class="prod-title">${escapeHtml(p.title)}</p>
          <p class="prod-spec">${escapeHtml(p.packing)}</p>
          <span class="prod-price">${formatVND(p.price)}</span>
        </div>
        <div style="display: flex; align-items: center; gap: 8px;">
          <div class="qty-stepper">
            <button data-product-id="${p.id}" onclick="updateQty(${p.id}, -1)" ${p.qty <= 1 ? 'disabled' : ''}>-</button>
            <span>${p.qty}</span>
            <button data-product-id="${p.id}" onclick="updateQty(${p.id}, 1)">+</button>
          </div>
          <button class="btn-del-prod" onclick="removeProduct(${p.id})" title="Xoá"><i class="fa-regular fa-trash-can"></i></button>
        </div>
      </div>
    `).join('');
    recalcSummary();
  }

  function updateQty(id, delta) {
    const item = orderedProducts.find(p => p.id === id);
    if (!item || updatingProductIds[id] || item.qty + delta < 1 || item.qty + delta > 99) return;
    updatingProductIds[id] = true;
    document.querySelectorAll('.qty-stepper button[data-product-id="' + id + '"]').forEach(function(button) {
      button.disabled = true;
    });
    $.ajax({
      url: cartApiBase + '/api/cartUpdate',
      type: 'POST',
      dataType: 'json',
      headers: cartApiHeaders,
      data: { product_id: id, quantity: item.qty + delta }
    }).done(function(response) {
      if (!response.success) {
        showCartToast(response.message || 'Không thể cập nhật số lượng.', 'error');
        return;
      }
      applyCartResponse(response);
      showCartToast(response.message || 'Đã cập nhật giỏ hàng.', 'success');
    }).fail(function() {
      showCartToast('Không thể kết nối máy chủ. Vui lòng thử lại.', 'error');
    }).always(function() {
      delete updatingProductIds[id];
      document.querySelectorAll('.qty-stepper button[data-product-id="' + id + '"]').forEach(function(button) {
        const currentItem = orderedProducts.find(function(product) { return product.id === id; });
        button.disabled = button.innerText.trim() === '-' && currentItem && currentItem.qty <= 1;
      });
    });
  }

  function removeProduct(id) {
    $.ajax({
      url: cartApiBase + '/api/cartRemove',
      type: 'POST',
      dataType: 'json',
      headers: cartApiHeaders,
      data: { product_id: id }
    }).done(function(response) {
      if (!response.success) {
        showCartToast(response.message || 'Không thể xóa sản phẩm.', 'error');
        return;
      }
      applyCartResponse(response);
      showCartToast(response.message || 'Đã xóa sản phẩm khỏi giỏ hàng.', 'success');
    }).fail(function() {
      showCartToast('Không thể kết nối máy chủ. Vui lòng thử lại.', 'error');
    });
  }

  // 2. CHUYỂN HÌNH THỨC NHẬN HÀNG (QUẦY <-> GIAO TẬN NƠI)
  function switchDeliveryMode(mode) {
    orderState.deliveryMode = mode;
    document.getElementById('tabPickup').className = mode === 'pickup' ? 'delivery-tab-btn active' : 'delivery-tab-btn';
    document.getElementById('tabDelivery').className = mode === 'delivery' ? 'delivery-tab-btn active' : 'delivery-tab-btn';
    document.getElementById('sectionPickup').style.display = mode === 'pickup' ? 'block' : 'none';
    document.getElementById('sectionDelivery').style.display = mode === 'delivery' ? 'block' : 'none';
    document.getElementById('shippingBanner').style.display = mode === 'delivery' ? 'block' : 'none';
    recalcSummary();
  }

  // 3. TÍNH TOÁN THANH TOÁN & ĐỒNG BỘ ƯU ĐÃI
  function recalcSummary() {
    const goodsTotal = orderedProducts.reduce((sum, item) => sum + (item.price * item.qty), 0);
    document.getElementById('subTotalTextDesktop').innerText = formatVND(goodsTotal);
    document.getElementById('subTotalTextMobile').innerText = formatVND(goodsTotal);

    let shippingFee = 0;
    let shippingSaved = 0;
    const statusNotice = document.getElementById('shippingStatusNotice');

    if (orderedProducts.length === 0) {
      shippingFee = 0;
      document.getElementById('shippingFeeTextDesktop').innerText = "0đ";
      document.getElementById('shippingFeeTextMobile').innerText = "0đ";
      if (statusNotice) statusNotice.innerText = "";
    } else if (orderState.deliveryMode === 'pickup') {
      shippingFee = 0;
      document.getElementById('shippingFeeTextDesktop').innerHTML = `<span style="color: #16a34a; font-weight: 700;">Miễn phí (Tại quầy)</span>`;
      document.getElementById('shippingFeeTextMobile').innerText = "Miễn phí";
      if (statusNotice) statusNotice.innerText = "";
    } else {
      const isEligiblePrice = goodsTotal >= 300000;
      const isEligibleDistance = orderState.distanceKm <= 3.0;

      if (isEligiblePrice && isEligibleDistance) {
        shippingFee = 0;
        shippingSaved = orderState.standardShippingFee;
        document.getElementById('shippingFeeTextDesktop').innerHTML = `<span style="color: #16a34a; font-weight: 700;">Miễn phí</span>`;
        document.getElementById('shippingFeeTextMobile').innerText = "Miễn phí";
        if (statusNotice) statusNotice.innerText = `✓ Đủ điều kiện miễn phí giao hàng (${orderState.distanceKm}km ≤ 3km)`;
      } else {
        shippingFee = orderState.standardShippingFee;
        document.getElementById('shippingFeeTextDesktop').innerText = formatVND(shippingFee);
        document.getElementById('shippingFeeTextMobile').innerText = formatVND(shippingFee);
        if (statusNotice) statusNotice.innerText = `⚠ Chưa đủ điều kiện freeship (Cước: ${formatVND(shippingFee)})`;
      }
    }

    // Tự động huỷ voucher nếu tiền hàng không còn đủ minOrder
    if (orderState.selectedVoucher) {
      if (goodsTotal < orderState.selectedVoucher.minOrder) {
        orderState.selectedVoucher = null;
        updateVoucherDisplay();
      }
    }

    const voucherDiscount = calculateVoucherDiscount(orderState.selectedVoucher, goodsTotal);
    const maximumPointDiscount = Math.max(0, goodsTotal + shippingFee - voucherDiscount);
    const usedPoints = (orderState.isUsePoints && goodsTotal > 0)
      ? Math.min(orderState.userPoints, Math.floor(maximumPointDiscount / 1000))
      : 0;
    const pointDiscount = usedPoints * 1000;
    const totalSaved = voucherDiscount + pointDiscount + shippingSaved;

    document.getElementById('voucherRowDesktop').style.display = voucherDiscount > 0 ? 'flex' : 'none';
    document.getElementById('voucherDiscountTextDesktop').innerText = `-${formatVND(voucherDiscount)}`;

    document.getElementById('pointsRowDesktop').style.display = pointDiscount > 0 ? 'flex' : 'none';
    document.getElementById('pointsDiscountTextDesktop').innerText = `-${formatVND(pointDiscount)}`;
    document.getElementById('pointsUsedLabelDesktop').innerText = usedPoints;

    document.getElementById('savedAmountTextDesktop').innerText = formatVND(totalSaved);
    document.getElementById('savedAmountTextMobile').innerText = formatVND(totalSaved);

    const finalPayment = goodsTotal === 0 ? 0 : Math.max(0, goodsTotal + shippingFee - voucherDiscount - pointDiscount);
    document.getElementById('totalAmountTextDesktop').innerText = formatVND(finalPayment);
    document.getElementById('totalAmountTextMobile').innerText = formatVND(finalPayment);
    document.getElementById('desktopSubmitBtn').disabled = orderedProducts.length === 0;
    document.getElementById('mobileSubmitBtn').disabled = orderedProducts.length === 0;
  }

  // 4. QUẢN LÝ VOUCHER & RENDER DANH SÁCH (ĐÃ SỬA TRIỆT ĐỂ)
  function openVoucherModal() {
    var modal = document.getElementById('voucherModal');
    if (modal) {
      modal.classList.add('active');
      modal.style.display = 'flex';
    }
    var err = document.getElementById('voucherErrorMsg');
    if (err) err.style.display = 'none';

    renderVouchers();
  }

  function closeVoucherModal() {
    var modal = document.getElementById('voucherModal');
    if (modal) {
      modal.classList.remove('active');
      modal.style.display = 'none';
    }
  }

  function renderVouchers() {
    var container = document.getElementById('voucherListContainer');
    if (!container) return;

    var goodsTotal = 0;
    if (typeof orderedProducts !== 'undefined' && Array.isArray(orderedProducts)) {
      goodsTotal = orderedProducts.reduce(function(sum, item) {
        return sum + (item.price * item.qty);
      }, 0);
    }

    if (!availableVouchers || availableVouchers.length === 0) {
      container.innerHTML = '<p style="text-align: center; color: #94a3b8; font-size: 13px; padding: 30px 0;">Hiện chưa có mã ưu đãi khả dụng.</p>';
      return;
    }

    var html = '';
    for (var i = 0; i < availableVouchers.length; i++) {
      var v = availableVouchers[i];
      var isEligible = goodsTotal >= v.minOrder;
      var isSelected = (orderState.selectedVoucher && orderState.selectedVoucher.code === v.code);

      var itemClass = 'voucher-card-item' + (isSelected ? ' selected' : '') + (!isEligible ? ' disabled' : '');
      var borderStyle = isSelected ? 'border: 1.5px solid #1760a5; background: #eff6ff;' : 'border: 1px solid #e2e8f0; background: #fff;';

      html += '<div class="' + itemClass + '" style="' + borderStyle + ' border-radius: 12px; padding: 12px 14px; margin-bottom: 10px; display: flex; justify-content: space-between; align-items: center; gap: 10px;">';
      html += '  <div style="flex: 1; min-width: 0;">';
      html += '    <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 3px;">';
      html += '      <span style="background: #dbeafe; color: #1e40af; font-size: 11px; font-weight: 800; padding: 2px 7px; border-radius: 4px; letter-spacing: 0.5px;">' + escapeHtml(v.code) + '</span>';
      html += '      <strong style="font-size: 13px; color: #e36928;">-' + formatVND(calculateVoucherDiscount(v, goodsTotal)) + '</strong>';
      html += '    </div>';
      html += '    <strong style="font-size: 13px; color: #1e293b; display: block;">' + escapeHtml(v.title) + '</strong>';
      html += '    <p style="font-size: 11px; color: #64748b; margin: 2px 0 0 0;">' + escapeHtml(v.desc) + '</p>';
      
      if (!isEligible) {
        var needed = v.minOrder - goodsTotal;
        html += '    <span style="font-size: 11px; color: #dc2626; font-weight: 600; display: block; margin-top: 3px;">• Cần mua thêm ' + formatVND(needed) + ' để sử dụng</span>';
      }
      html += '  </div>';

      html += '  <div style="flex-shrink: 0;">';
      if (isSelected) {
        html += '    <button type="button" class="voucher-remove-btn" onclick="removeVoucher()">Bỏ chọn</button>';
      } else if (isEligible) {
        html += '    <button type="button" class="voucher-apply-btn" onclick="selectVoucher(decodeURIComponent(\'' + encodeURIComponent(v.code) + '\'))">Áp dụng</button>';
      } else {
        html += '    <button type="button" class="voucher-apply-btn" style="background: #cbd5e1; cursor: not-allowed; opacity: 0.8;" disabled>Chưa đủ</button>';
      }
      html += '  </div>';
      html += '</div>';
    }

    container.innerHTML = html;
  }

  function selectVoucher(code) {
    var v = availableVouchers.find(function(i) { return i.code === code; });
    if (v) {
      orderState.selectedVoucher = v;
      updateVoucherDisplay();
      closeVoucherModal();
      recalcSummary();
    }
  }

  function removeVoucher() {
    orderState.selectedVoucher = null;
    updateVoucherDisplay();
    renderVouchers();
    recalcSummary();
  }

  function applyManualVoucher() {
    var input = document.getElementById('manualVoucherInput');
    var code = input.value.trim().toUpperCase();
    var err = document.getElementById('voucherErrorMsg');
    
    var goodsTotal = orderedProducts.reduce(function(sum, item) {
      return sum + (item.price * item.qty);
    }, 0);

    var found = availableVouchers.find(function(i) { return i.code === code; });
    if (!found) {
      err.innerText = "Mã ưu đãi không tồn tại hoặc đã hết hạn!";
      err.style.display = 'block';
      return;
    }
    if (goodsTotal < found.minOrder) {
      err.innerText = "Đơn hàng tối thiểu " + formatVND(found.minOrder) + " để dùng mã này!";
      err.style.display = 'block';
      return;
    }

    err.style.display = 'none';
    selectVoucher(found.code);
    input.value = '';
  }

  function updateVoucherDisplay() {
    var titleDesktop = document.getElementById('appliedVoucherTitleDesktop');
    var subDesktop = document.getElementById('appliedVoucherSubDesktop');
    var actionBtn = document.getElementById('voucherActionBtnText');
    var mobileSnippet = document.getElementById('mobileVoucherSnippet');

    if (orderState.selectedVoucher) {
      var v = orderState.selectedVoucher;
      var goodsTotal = orderedProducts.reduce(function(sum, item) { return sum + (item.price * item.qty); }, 0);
      if (titleDesktop) titleDesktop.innerHTML = '<span style="color: #1760a5;">' + escapeHtml(v.code) + '</span> (Giảm ' + formatVND(calculateVoucherDiscount(v, goodsTotal)) + ')';
      if (subDesktop) subDesktop.innerText = "Đã áp dụng thành công";
      if (actionBtn) actionBtn.innerText = "Đổi mã";
      if (mobileSnippet) mobileSnippet.innerHTML = '<strong style="color: #e36928;">' + escapeHtml(v.code) + '</strong> (-' + formatVND(calculateVoucherDiscount(v, goodsTotal)) + ')';
    } else {
      if (titleDesktop) titleDesktop.innerText = "Chọn mã ưu đãi";
      if (subDesktop) subDesktop.innerText = "Giảm thêm tiền cho đơn hàng";
      if (actionBtn) actionBtn.innerText = "Chọn";
      if (mobileSnippet) mobileSnippet.innerText = "Chọn mã";
    }
  }

  // 5. ĐIỂM THƯỞNG
  function syncPoints(checked) {
    if (!orderState.isLoggedIn || orderState.userPoints < 1) {
      checked = false;
      showCartToast('Vui lòng đăng nhập và có điểm tích lũy để sử dụng.', 'error');
    }
    orderState.isUsePoints = checked;
    document.getElementById('pointCheckboxDesktop').checked = checked;
    document.getElementById('pointCheckboxMobile').checked = checked;
    recalcSummary();
  }

  // 6. ĐỊA CHỈ HÀNH CHÍNH 2 CẤP
  function openAddressModal() {
    document.getElementById('addressModal').classList.add('active');
    document.getElementById('addressSearchInput').value = '';
    switchAddressStep('province');
  }
  function closeAddressModal() {
    document.getElementById('addressModal').classList.remove('active');
  }

  function switchAddressStep(step) {
    if (step === 'ward' && !orderState.addressSelection.provinceCode) {
      showCartToast('Vui lòng chọn tỉnh/thành phố trước.', 'error');
      return;
    }
    orderState.currentStep = step;
    const tabP = document.getElementById('stepTabProvince');
    const tabW = document.getElementById('stepTabWard');

    if (step === 'province') {
      tabP.style.borderBottom = "2px solid #1760a5";
      tabP.style.color = "#1760a5";
      tabW.style.borderBottom = "none";
      tabW.style.color = "#94a3b8";
    } else {
      tabW.style.borderBottom = "2px solid #1760a5";
      tabW.style.color = "#1760a5";
      tabP.style.borderBottom = "none";
      tabP.style.color = "#64748b";
    }
    document.getElementById('addressSearchInput').value = '';
    loadAdministrativeItems(step);
  }

  function loadAdministrativeItems(step) {
    const container = document.getElementById('addressItemsContainer');
    container.innerHTML = '<p style="text-align: center; color: #64748b; font-size: 12px; padding: 24px 0;"><i class="fa-solid fa-spinner fa-spin"></i> Đang tải dữ liệu...</p>';
    $.ajax({
      url: cartApiBase + '/api/administrativeUnits',
      type: 'GET',
      dataType: 'json',
      data: {
        level: step,
        province_code: step === 'ward' ? orderState.addressSelection.provinceCode : ''
      }
    }).done(function(response) {
      if (!response.success || !Array.isArray(response.data)) {
        administrativeItems = [];
        container.innerHTML = '<p style="text-align: center; color: #dc2626; font-size: 12px; padding: 24px 0;">' + escapeHtml(response.message || 'Không thể tải danh mục hành chính.') + '</p>';
        return;
      }
      if (orderState.currentStep !== step) return;
      administrativeItems = response.data;
      renderAddressItems('');
    }).fail(function() {
      administrativeItems = [];
      container.innerHTML = '<p style="text-align: center; color: #dc2626; font-size: 12px; padding: 24px 0;">Không thể kết nối máy chủ. Vui lòng thử lại.</p>';
      showCartToast('Không thể tải danh mục tỉnh, xã/phường.', 'error');
    });
  }

  function renderAddressItems(searchText) {
    const container = document.getElementById('addressItemsContainer');
    let list = administrativeItems;

    var keyword = String(searchText || '').trim().toLocaleLowerCase('vi');
    if (keyword) {
      list = list.filter(function(item) { return item.name.toLocaleLowerCase('vi').indexOf(keyword) !== -1; });
    }

    container.innerHTML = list.length ? list.map(item => `
      <div onclick="selectAddress('${encodeURIComponent(item.code)}')" style="padding: 10px; border-bottom: 1px solid #f1f5f9; cursor: pointer; font-size: 13px;">
        ${escapeHtml(item.name)}
      </div>
    `).join('') : '<p style="text-align: center; color: #94a3b8; font-size: 12px; padding: 24px 0;">Không tìm thấy dữ liệu phù hợp.</p>';
  }

  function filterAddressList(value) {
    renderAddressItems(value);
  }

  function selectAddress(encodedCode) {
    var code = decodeURIComponent(encodedCode);
    var selected = administrativeItems.find(function(item) { return item.code === code; });
    if (!selected) return;
    if (orderState.currentStep === 'province') {
      orderState.addressSelection.provinceCode = selected.code;
      orderState.addressSelection.provinceName = selected.name;
      orderState.addressSelection.wardCode = '';
      orderState.addressSelection.wardName = '';
      document.getElementById('selectedAddressText').innerText = selected.name + ', chọn Xã/Phường';
      document.getElementById('stepTabWard').disabled = false;
      document.getElementById('stepTabWard').style.cursor = 'pointer';
      switchAddressStep('ward');
    } else {
      orderState.addressSelection.wardCode = selected.code;
      orderState.addressSelection.wardName = selected.name;
      document.getElementById('selectedAddressText').innerText = orderState.addressSelection.provinceName + ', ' + selected.name;
      closeAddressModal();
    }
  }

  function toggleSameReceiver(el) {
    if (el.checked) {
      document.getElementById('recvName').value = document.getElementById('orderName').value;
      document.getElementById('recvPhone').value = document.getElementById('orderPhone').value;
    }
  }

  function getCurrentLocationGPS() {
    if (!navigator.geolocation) {
      showCartToast('Thiết bị không hỗ trợ xác định vị trí.', 'error');
      return;
    }
    var icon = document.getElementById('gpsIcon');
    var text = document.getElementById('gpsBtnText');
    icon.className = 'fa-solid fa-spinner fa-spin';
    text.innerText = 'Đang lấy...';
    navigator.geolocation.getCurrentPosition(function(position) {
      document.getElementById('specificAddress').value = 'Vị trí GPS: ' + position.coords.latitude.toFixed(6) + ', ' + position.coords.longitude.toFixed(6);
      icon.className = 'fa-solid fa-location-crosshairs';
      text.innerText = 'Đã lấy';
      showCartToast('Đã cập nhật vị trí giao thuốc.', 'success');
    }, function() {
      icon.className = 'fa-solid fa-crosshairs';
      text.innerText = 'GPS';
      showCartToast('Không thể lấy vị trí. Vui lòng kiểm tra quyền vị trí hoặc nhập địa chỉ.', 'error');
    }, { enableHighAccuracy: true, timeout: 10000, maximumAge: 60000 });
  }

  function submitMedicineOrder() {
    if (orderedProducts.length === 0) {
      showCartToast('Giỏ hàng đang trống.', 'error');
      return;
    }
    var fullname = document.getElementById('orderName').value.trim();
    var phone = document.getElementById('orderPhone').value.replace(/[\s.\-]/g, '');
    var email = document.getElementById('orderEmail').value.trim();
    if (fullname.length < 2) {
      document.getElementById('orderName').focus();
      showCartToast('Vui lòng nhập họ tên hợp lệ.', 'error');
      return;
    }
    if (!/^(0|\+84)[0-9]{9,10}$/.test(phone)) {
      document.getElementById('orderPhone').focus();
      showCartToast('Số điện thoại không đúng định dạng.', 'error');
      return;
    }
    if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
      document.getElementById('orderEmail').focus();
      showCartToast('Email nhận thông báo không đúng định dạng.', 'error');
      return;
    }

    var isDelivery = orderState.deliveryMode === 'delivery';
    var address = '';
    var noteParts = [];
    if (isDelivery) {
      var specificAddress = document.getElementById('specificAddress').value.trim();
      if (specificAddress.length < 5) {
        document.getElementById('specificAddress').focus();
        showCartToast('Vui lòng nhập địa chỉ giao thuốc đầy đủ.', 'error');
        return;
      }
      if (!orderState.addressSelection.provinceCode || !orderState.addressSelection.wardCode) {
        openAddressModal();
        showCartToast('Vui lòng chọn đầy đủ tỉnh/thành phố và xã/phường.', 'error');
        return;
      }
      address = specificAddress + ', ' + document.getElementById('selectedAddressText').innerText.trim();
      var receiverName = document.getElementById('recvName').value.trim();
      var receiverPhone = document.getElementById('recvPhone').value.trim();
      if (receiverName) noteParts.push('Người nhận: ' + receiverName);
      if (receiverPhone) noteParts.push('SĐT người nhận: ' + receiverPhone);
    }
    var deliveryNote = document.getElementById('deliveryNote').value.trim();
    if (deliveryNote) noteParts.push(deliveryNote);

    var desktopButton = document.getElementById('desktopSubmitBtn');
    var mobileButton = document.getElementById('mobileSubmitBtn');
    desktopButton.disabled = true;
    mobileButton.disabled = true;
    desktopButton.innerText = 'ĐANG GỬI ĐƠN...';
    mobileButton.innerText = 'ĐANG GỬI...';

    $.ajax({
      url: cartApiBase + '/api/cartCheckout',
      type: 'POST',
      dataType: 'json',
      headers: cartApiHeaders,
      data: {
        fullname: fullname,
        phone: phone,
        email: email,
        ship_method: isDelivery ? 'Giao hàng tận nơi' : 'Nhận tại Nhà thuốc',
        address: address,
        extra_note: noteParts.join(' | '),
        voucher_code: orderState.selectedVoucher ? orderState.selectedVoucher.code : '',
        use_points: orderState.isUsePoints ? 1 : 0
      }
    }).done(function(response) {
      if (!response.success) {
        showCartToast(response.message || 'Không thể gửi đơn đặt thuốc.', 'error');
        return;
      }
      applyCartResponse(response);
      orderState.selectedVoucher = null;
      orderState.isUsePoints = false;
      if (response.order) orderState.userPoints = Number(response.order.point_balance || 0);
      document.getElementById('pointCheckboxDesktop').checked = false;
      document.getElementById('pointCheckboxMobile').checked = false;
      document.getElementById('pointBalanceDesktop').innerText = orderState.userPoints + ' điểm';
      document.getElementById('pointValueDesktop').innerText = new Intl.NumberFormat('vi-VN').format(orderState.userPoints * 1000) + 'đ';
      document.getElementById('mobilePointLabel').innerText = 'Dùng ' + orderState.userPoints + ' điểm (-' + orderState.userPoints + 'k)';
      document.getElementById('pointCheckboxDesktop').disabled = !orderState.isLoggedIn || orderState.userPoints < 1;
      document.getElementById('pointCheckboxMobile').disabled = !orderState.isLoggedIn || orderState.userPoints < 1;
      updateVoucherDisplay();
      recalcSummary();
      showCartToast(response.message || 'Đặt thuốc thành công.', 'success');
    }).fail(function(xhr) {
      var message = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Không thể kết nối máy chủ. Vui lòng thử lại.';
      showCartToast(message, 'error');
    }).always(function() {
      desktopButton.innerText = 'TIẾN HÀNH ĐẶT HÀNG';
      mobileButton.innerText = 'ĐẶT HÀNG';
      if (orderedProducts.length > 0) {
        desktopButton.disabled = false;
        mobileButton.disabled = false;
      }
    });
  }

  // Khởi tạo ban đầu
  document.getElementById('desktopSubmitBtn').addEventListener('click', submitMedicineOrder);
  document.getElementById('mobileSubmitBtn').addEventListener('click', submitMedicineOrder);
  renderOrderedProducts();
</script>

</main> <!-- Đóng thẻ main từ header_new.php -->

<?php
// Nạp Footer hệ thống (từ footer_new.php)
require "footer_new.php";
?>
