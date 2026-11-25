<?php require "header_new.php"; ?>
<?php
$order = isset($order) ? $order : null;
$medicines = is_array($medicines ?? null) ? $medicines : array();
$isOnlinePayment = !empty($isOnlinePayment);
$userPoints = isset($userPoints) ? (int)$userPoints : 0;
$orderIdFormatted = $order ? '#DH' . str_pad($order->id, 5, '0', STR_PAD_LEFT) : '';
$totalAmountFormatted = $order ? number_format((float)$order->total_amount, 0, ',', '.') . 'đ' : '0đ';
$subtotalFormatted = $order ? number_format((float)$order->subtotal, 0, ',', '.') . 'đ' : '0đ';
$shippingFeeFormatted = ($order && (float)$order->shipping_fee > 0) ? number_format((float)$order->shipping_fee, 0, ',', '.') . 'đ' : 'Miễn phí';
$pointsEarned = $order ? (int)$order->points_earned : 0;
$siteAddress = $this->helper->get_config('site_address');
$sitePhone = $this->helper->get_config('site_phone');
$siteHotline = $this->helper->get_config('site_hotline');
$sitePhoneZalo = $this->helper->get_config('site_phonezalo');
?>

</section>
<div id="breadcrumbs">
    <div class="ctn">
        <div id="crumbs">
            <a href="<?php echo XC_URL; ?>">Trang chủ</a> <span>/</span>
            <a href="<?php echo XC_URL; ?>/nha-thuoc.html">Nhà thuốc</a> <span>/</span>
            <a class="current">Xác nhận đơn hàng</a>
        </div>
    </div>
</div>

<div class="ty-page">
    <div class="ctn">
        <div class="ty-wrap">
            <!-- 1. Thẻ xác nhận đặt hàng thành công & Tích điểm thành viên -->
            <div class="ty-status-card">
                <div class="ty-status-main">
                    <div class="ty-status-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                    <div class="ty-status-body">
                        <div class="ty-status-head">
                            <h1 class="ty-status-title">Đặt hàng thành công</h1>
                            <span class="ty-order-code">Mã đơn: <strong><?php echo htmlspecialchars($orderIdFormatted, ENT_QUOTES, 'UTF-8'); ?></strong></span>
                        </div>
                        <p class="ty-status-desc">
                            Cảm ơn Quý khách đã đặt thuốc tại <strong>Nhà thuốc Trường Cao Đẳng Kon Tum</strong>. Dược sĩ sẽ kiểm tra đơn và liên hệ số điện thoại của Quý khách để xác nhận trong thời gian sớm nhất.
                        </p>
                    </div>
                </div>

                <?php if ($isOnlinePayment || $pointsEarned > 0) { ?>
                <div class="ty-status-loyalty">
                    <i class="fa-solid fa-coins ty-loyalty-ico" aria-hidden="true"></i>
                    <div class="ty-loyalty-msg">
                        <strong><?php echo $isOnlinePayment ? 'Thanh toán online thành công' : 'Tích lũy điểm thành viên'; ?>:</strong>
                        <span>Đơn hàng được tích lũy <strong>+<?php echo number_format($pointsEarned, 0, ',', '.'); ?> điểm</strong>. Tổng điểm tích lũy hiện có: <strong><?php echo number_format($userPoints, 0, ',', '.'); ?> điểm</strong> (tương đương giảm giá <strong><?php echo number_format($userPoints * 1000, 0, ',', '.'); ?>đ</strong> cho lần mua sau).</span>
                    </div>
                </div>
                <?php } ?>
            </div>

            <!-- 2. Bố cục 2 cột: Phiếu đơn hàng (Trái) & Thông tin Nhà thuốc (Phải) -->
            <div class="ty-layout">
                <!-- Cột trái: Chi tiết đơn hàng -->
                <div class="ty-col-main">
                    <!-- Khối thông tin người nhận -->
                    <div class="ty-section-card">
                        <h2 class="ty-card-heading">Thông tin nhận thuốc</h2>
                        <dl class="ty-detail-grid">
                            <div class="ty-detail-item">
                                <dt>Người nhận:</dt>
                                <dd><strong><?php echo htmlspecialchars($order->fullname ?? '', ENT_QUOTES, 'UTF-8'); ?></strong></dd>
                            </div>
                            <div class="ty-detail-item">
                                <dt>Số điện thoại:</dt>
                                <dd><strong><?php echo htmlspecialchars($order->phone ?? '', ENT_QUOTES, 'UTF-8'); ?></strong></dd>
                            </div>
                            <div class="ty-detail-item">
                                <dt>Thời gian đặt:</dt>
                                <dd><?php echo !empty($order->created_at) ? date('H:i - d/m/Y', strtotime($order->created_at)) : date('H:i - d/m/Y'); ?></dd>
                            </div>
                            <div class="ty-detail-item">
                                <dt>Hình thức nhận:</dt>
                                <dd class="ty-method-badge"><?php echo htmlspecialchars($order->ship_method ?? 'Giao hàng tận nơi', ENT_QUOTES, 'UTF-8'); ?></dd>
                            </div>
                            <?php if (!empty($order->address) && ($order->ship_method ?? '') === 'Giao hàng tận nơi') { ?>
                            <div class="ty-detail-item ty-detail-full">
                                <dt>Địa chỉ giao:</dt>
                                <dd><?php echo htmlspecialchars($order->address, ENT_QUOTES, 'UTF-8'); ?></dd>
                            </div>
                            <?php } ?>
                            <div class="ty-detail-item ty-detail-full">
                                <dt>Thanh toán:</dt>
                                <dd><?php echo htmlspecialchars($order->payment_method ?? 'Thanh toán khi nhận hàng', ENT_QUOTES, 'UTF-8'); ?></dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Khối danh sách thuốc đã đặt -->
                    <div class="ty-section-card">
                        <div class="ty-card-heading-row">
                            <h2 class="ty-card-heading">Danh sách thuốc đã đặt</h2>
                            <span class="ty-count-badge"><?php echo count($medicines); ?> sản phẩm</span>
                        </div>

                        <?php if (!empty($medicines)) { ?>
                        <div class="ty-table-wrap">
                            <table class="ty-table">
                                <thead>
                                    <tr>
                                        <th style="width: 50%;">Tên thuốc / Sản phẩm</th>
                                        <th style="width: 25%; text-align: center;">Số lượng</th>
                                        <th style="width: 25%; text-align: right;">Ghi chú</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($medicines as $med) { ?>
                                    <tr>
                                        <td>
                                            <div class="ty-med-title"><?php echo htmlspecialchars($med['name'] ?? '', ENT_QUOTES, 'UTF-8'); ?></div>
                                            <?php if (!empty($med['spec'])) { ?>
                                            <div class="ty-med-sub"><?php echo htmlspecialchars($med['spec'], ENT_QUOTES, 'UTF-8'); ?></div>
                                            <?php } ?>
                                        </td>
                                        <td style="text-align: center;">
                                            <span class="ty-qty">x<?php echo htmlspecialchars($med['qty'] ?? '1', ENT_QUOTES, 'UTF-8'); ?></span>
                                        </td>
                                        <td style="text-align: right; color: #64748b; font-size: 13px;">
                                            <?php echo !empty($med['note']) ? htmlspecialchars($med['note'], ENT_QUOTES, 'UTF-8') : '-'; ?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <?php } else { ?>
                        <p style="color: #64748b; font-size: 14px; margin: 0;">Đơn thuốc được nhân viên nhà thuốc ghi nhận theo tư vấn.</p>
                        <?php } ?>

                        <!-- Bảng tính tiền & tổng thanh toán -->
                        <div class="ty-cost-summary">
                            <div class="ty-cost-line">
                                <span>Tạm tính tiền thuốc:</span>
                                <strong><?php echo $subtotalFormatted; ?></strong>
                            </div>
                            <div class="ty-cost-line">
                                <span>Phí giao hàng:</span>
                                <span><?php echo $shippingFeeFormatted; ?></span>
                            </div>
                            <?php if ($order && (float)$order->voucher_discount > 0) { ?>
                            <div class="ty-cost-line ty-cost-discount">
                                <span>Mã giảm giá (<?php echo htmlspecialchars($order->voucher_code, ENT_QUOTES, 'UTF-8'); ?>):</span>
                                <strong>-<?php echo number_format((float)$order->voucher_discount, 0, ',', '.'); ?>đ</strong>
                            </div>
                            <?php } ?>
                            <?php if ($order && (float)$order->points_discount > 0) { ?>
                            <div class="ty-cost-line ty-cost-discount">
                                <span>Giảm trừ điểm (<?php echo (int)$order->points_used; ?> điểm):</span>
                                <strong>-<?php echo number_format((float)$order->points_discount, 0, ',', '.'); ?>đ</strong>
                            </div>
                            <?php } ?>
                            <div class="ty-cost-line ty-cost-total">
                                <span>Tổng thanh toán:</span>
                                <strong class="ty-total-val"><?php echo $totalAmountFormatted; ?></strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cột phải: Thông tin Quầy thuốc & Hỗ trợ -->
                <aside class="ty-col-side">
                    <div class="ty-section-card ty-pharmacy-card">
                        <h2 class="ty-card-heading">Nhà thuốc phục vụ</h2>
                        
                        <div class="ty-pharmacy-unit">
                            <div class="ty-unit-name">Phòng khám Đa khoa &amp; Nhà thuốc</div>
                            <div class="ty-unit-sub">Trường Cao đẳng Kon Tum</div>
                        </div>

                        <ul class="ty-unit-info-list">
                            <li>
                                <span class="ty-info-k">Địa chỉ quầy thuốc:</span>
                                <span class="ty-info-v"><?php echo htmlspecialchars($siteAddress, ENT_QUOTES, 'UTF-8'); ?></span>
                            </li>
                            <li>
                                <span class="ty-info-k">Giờ hoạt động:</span>
                                <span class="ty-info-v">07:00 – 19:00 (Thứ 2 đến Chủ nhật)</span>
                            </li>
                            <li>
                                <span class="ty-info-k">Hotline tư vấn:</span>
                                <span class="ty-info-v">
                                    <a href="tel:<?php echo htmlspecialchars($siteHotline ?: $sitePhone, ENT_QUOTES, 'UTF-8'); ?>" class="ty-link-phone">
                                        <?php echo htmlspecialchars($siteHotline ?: $sitePhone, ENT_QUOTES, 'UTF-8'); ?>
                                    </a>
                                </span>
                            </li>
                        </ul>

                        <div class="ty-unit-actions">
                            <a href="tel:<?php echo htmlspecialchars($siteHotline ?: $sitePhone, ENT_QUOTES, 'UTF-8'); ?>" class="ty-action-btn ty-btn-call">
                                <i class="fa-solid fa-phone"></i>
                                <span>Gọi Dược sĩ tư vấn</span>
                            </a>
                            <?php if (!empty($sitePhoneZalo)) { ?>
                            <a href="https://zalo.me/<?php echo htmlspecialchars($sitePhoneZalo, ENT_QUOTES, 'UTF-8'); ?>" target="_blank" rel="noopener noreferrer" class="ty-action-btn ty-btn-zalo">
                                <i class="fa-solid fa-comment-dots"></i>
                                <span>Nhắn tin Zalo Dược sĩ</span>
                            </a>
                            <?php } ?>
                        </div>

                        <div class="ty-unit-note">
                            <i class="fa-solid fa-circle-info"></i>
                            <span>Dược sĩ sẽ kiểm tra tương tác thuốc và tư vấn liều dùng trước khi đơn hàng xuất kho.</span>
                        </div>
                    </div>
                </aside>
            </div>

            <!-- 3. Điều hướng quay lại -->
            <div class="ty-footer-nav">
                <a href="<?php echo XC_URL; ?>/nha-thuoc.html" class="ty-nav-btn ty-nav-primary">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Tiếp tục mua thuốc</span>
                </a>
                <a href="<?php echo XC_URL; ?>" class="ty-nav-btn ty-nav-secondary">
                    <span>Về trang chủ</span>
                </a>
                <?php if (!empty($_SESSION['customer']['id'])) { ?>
                <a href="<?php echo XC_URL; ?>/page/customerprofile" class="ty-nav-link">
                    <span>Xem lịch sử đơn &amp; Điểm thưởng</span>
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
</main>

<style>
/* GIAO DIỆN XÁC NHẬN ĐƠN HÀNG THUỐC (THIẾT KẾ THỰC TẾ, GỌN GÀNG, CHUYÊN NGHIỆP) */
.ty-page {
    background: #f4f6f8;
    padding: 24px 0 48px 0;
    min-height: 70vh;
    font-family: inherit;
    color: #1e293b;
    box-sizing: border-box;
}

.ty-page .ctn {
    max-width: 1270px !important;
    width: 100%;
}

.ty-wrap {
    max-width: 1270px;
    width: 100%;
    margin: 0 auto;
}

/* 1. THẺ XÁC NHẬN ĐƠN HÀNG & TÍCH ĐIỂM */
.ty-status-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 20px 24px;
    margin-bottom: 20px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    box-sizing: border-box;
}

.ty-status-main {
    display: flex;
    align-items: flex-start;
    gap: 16px;
}

.ty-status-icon {
    width: 42px;
    height: 42px;
    flex-shrink: 0;
    border-radius: 50%;
    background: #ecfdf5;
    color: #16a34a;
    display: flex;
    align-items: center;
    justify-content: center;
}

.ty-status-body {
    flex: 1;
    min-width: 0;
}

.ty-status-head {
    display: flex;
    align-items: baseline;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 6px;
}

.ty-status-title {
    font-size: 20px;
    font-weight: 700;
    color: #0f172a;
    margin: 0;
    line-height: 1.3;
}

.ty-order-code {
    font-size: 13.5px;
    color: #475569;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    padding: 4px 10px;
    border-radius: 6px;
}

.ty-order-code strong {
    color: #155191;
    font-size: 15px;
    font-weight: 700;
}

.ty-status-desc {
    margin: 0;
    font-size: 14px;
    color: #475569;
    line-height: 1.5;
}

/* KHỐI TÍCH ĐIỂM TÍCH HỢP TRONG THẺ */
.ty-status-loyalty {
    margin-top: 14px;
    padding: 10px 14px;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 6px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13.5px;
    color: #166534;
    line-height: 1.45;
}

.ty-loyalty-ico {
    color: #d97706;
    font-size: 16px;
    flex-shrink: 0;
}

.ty-loyalty-msg {
    flex: 1;
}

.ty-loyalty-msg strong {
    color: #15803d;
}

/* 2. BỐ CỤC 2 CỘT */
.ty-layout {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

@media (min-width: 992px) {
    .ty-layout {
        flex-direction: row;
        align-items: flex-start;
        gap: 20px;
    }
    .ty-col-main {
        flex: 1 1 auto;
        min-width: 0;
    }
    .ty-col-side {
        flex: 0 0 380px;
        min-width: 380px;
    }
}

.ty-section-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
    box-sizing: border-box;
}

.ty-card-heading {
    font-size: 15px;
    font-weight: 700;
    color: #0f172a;
    margin: 0 0 16px 0;
    padding-bottom: 10px;
    border-bottom: 1px solid #f1f5f9;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.ty-card-heading-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 14px;
    padding-bottom: 10px;
    border-bottom: 1px solid #f1f5f9;
}

.ty-card-heading-row .ty-card-heading {
    margin: 0;
    padding: 0;
    border-bottom: none;
}

.ty-count-badge {
    font-size: 12px;
    background: #f1f5f9;
    color: #475569;
    padding: 3px 8px;
    border-radius: 4px;
    font-weight: 600;
}

/* LƯỚI THÔNG TIN NGƯỜI NHẬN */
.ty-detail-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 12px 24px;
    margin: 0;
}

@media (min-width: 600px) {
    .ty-detail-grid {
        grid-template-columns: 1fr 1fr;
    }
}

.ty-detail-item {
    display: flex;
    flex-direction: row;
    align-items: baseline;
    gap: 8px;
    font-size: 14px;
    line-height: 1.5;
}

.ty-detail-item dt {
    color: #64748b;
    font-weight: 500;
    font-size: 14px;
    white-space: nowrap;
    flex-shrink: 0;
}

.ty-detail-item dd {
    margin: 0;
    color: #0f172a;
    font-size: 14px;
    line-height: 1.5;
    word-break: break-word;
    flex: 1;
    min-width: 0;
}

.ty-detail-full {
    grid-column: 1 / -1;
}

.ty-method-badge {
    display: inline-block;
    color: #155191;
    font-weight: 600;
}

/* BẢNG THUỐC */
.ty-table-wrap {
    overflow-x: auto;
    margin-bottom: 16px;
}

.ty-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13.5px;
}

.ty-table th {
    background: #f8fafc;
    color: #475569;
    font-weight: 600;
    font-size: 12.5px;
    padding: 9px 12px;
    border-top: 1px solid #e2e8f0;
    border-bottom: 1px solid #e2e8f0;
    text-align: left;
}

.ty-table td {
    padding: 12px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
}

.ty-med-title {
    font-weight: 600;
    color: #1e293b;
    line-height: 1.35;
}

.ty-med-sub {
    font-size: 12px;
    color: #64748b;
    margin-top: 2px;
}

.ty-qty {
    display: inline-block;
    font-weight: 700;
    color: #155191;
    background: #f0f7ff;
    padding: 2px 8px;
    border-radius: 4px;
    font-size: 13px;
}

/* TỔNG KẾT TIỀN */
.ty-cost-summary {
    background: #f8fafc;
    border-radius: 6px;
    padding: 14px 16px;
    display: flex;
    flex-direction: column;
    gap: 8px;
    font-size: 13.5px;
}

.ty-cost-line {
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: #475569;
}

.ty-cost-discount {
    color: #16a34a;
}

.ty-cost-total {
    padding-top: 10px;
    margin-top: 4px;
    border-top: 1px dashed #cbd5e1;
    color: #0f172a;
    font-size: 14.5px;
}

.ty-total-val {
    font-size: 19px;
    font-weight: 800;
    color: #e36928;
}

/* CỘT PHẢI: THÔNG TIN NHÀ THUỐC */
.ty-pharmacy-card {
    background: #ffffff;
}

.ty-unit-name {
    font-size: 14px;
    font-weight: 700;
    color: #155191;
    line-height: 1.35;
}

.ty-unit-sub {
    font-size: 13px;
    font-weight: 600;
    color: #e36928;
    margin-bottom: 14px;
}

.ty-unit-info-list {
    list-style: none;
    margin: 0 0 16px 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    gap: 10px;
    font-size: 13px;
}

.ty-unit-info-list li {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.ty-info-k {
    color: #64748b;
    font-size: 12px;
    font-weight: 500;
}

.ty-info-v {
    color: #1e293b;
    font-weight: 600;
    line-height: 1.4;
}

.ty-link-phone {
    color: #155191;
    text-decoration: none;
    font-size: 14px;
    font-weight: 700;
}

.ty-link-phone:hover {
    text-decoration: underline;
}

.ty-unit-actions {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-bottom: 14px;
}

.ty-action-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 10px 14px;
    border-radius: 6px;
    font-size: 13.5px;
    font-weight: 600;
    text-decoration: none;
    transition: background 0.15s ease;
}

.ty-btn-call {
    background: #155191;
    color: #ffffff;
}

.ty-btn-call:hover {
    background: #0f3e70;
    color: #ffffff;
}

.ty-btn-zalo {
    background: #e0f2fe;
    color: #0369a1;
    border: 1px solid #bae6fd;
}

.ty-btn-zalo:hover {
    background: #bae6fd;
    color: #0284c7;
}

.ty-unit-note {
    background: #f8fafc;
    border-radius: 6px;
    padding: 10px 12px;
    font-size: 12px;
    color: #64748b;
    line-height: 1.4;
    display: flex;
    gap: 8px;
    align-items: flex-start;
}

.ty-unit-note i {
    color: #0b63f6;
    margin-top: 2px;
    flex-shrink: 0;
}

/* 3. NÚT ĐIỀU HƯỚNG CUỐI TRANG */
.ty-footer-nav {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
    margin-top: 8px;
    padding: 14px 0;
}

.ty-nav-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 10px 20px;
    border-radius: 6px;
    font-size: 13.5px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.15s ease;
}

.ty-nav-primary {
    background: #155191;
    color: #ffffff;
}

.ty-nav-primary:hover {
    background: #0f3e70;
    color: #ffffff;
}

.ty-nav-secondary {
    background: #ffffff;
    color: #334155;
    border: 1px solid #cbd5e1;
}

.ty-nav-secondary:hover {
    background: #f1f5f9;
    color: #0f172a;
}

.ty-nav-link {
    margin-left: auto;
    color: #155191;
    font-size: 13.5px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.ty-nav-link:hover {
    text-decoration: underline;
}

/* RESPONSIVE TRÊN MOBILE */
@media (max-width: 767px) {
    .ty-page {
        padding: 16px 0 32px 0;
    }
    .ty-status-card {
        padding: 16px;
        margin-bottom: 14px;
    }
    .ty-status-main {
        flex-direction: column;
        gap: 12px;
    }
    .ty-status-icon {
        width: 36px;
        height: 36px;
    }
    .ty-status-head {
        flex-direction: column;
        align-items: flex-start;
        gap: 6px;
    }
    .ty-status-title {
        font-size: 18px;
    }
    .ty-status-loyalty {
        align-items: flex-start;
        padding: 10px 12px;
        font-size: 13px;
    }
    .ty-section-card {
        padding: 16px;
    }
    .ty-table th, .ty-table td {
        padding: 8px 6px;
        font-size: 12.5px;
    }
    .ty-footer-nav {
        flex-direction: column;
        align-items: stretch;
        gap: 8px;
    }
    .ty-nav-btn {
        width: 100%;
        box-sizing: border-box;
    }
    .ty-nav-link {
        margin: 6px auto 0 auto;
    }
}
</style>

<?php require "footer_new.php"; ?>
