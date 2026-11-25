<?php include_once "header.php"; ?>
<?php function dtHtml($val){ return htmlspecialchars((string)$val, ENT_QUOTES, 'UTF-8'); } ?>
<style>
/* CSS NÂNG CẤP GIAO DIỆN HỒ SƠ KHÁCH HÀNG (CLEAN & MODERN UI) */
.cust-hero-card {
   border-radius: 16px;
   border: 1px solid #e2e8f0;
   background: #ffffff;
   box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
   padding: 24px;
   margin-bottom: 20px;
}
.cust-hero-avatar {
   width: 76px;
   height: 76px;
   border-radius: 50%;
   background: linear-gradient(135deg, #1760a5, #1e40af);
   color: #ffffff;
   font-size: 28px;
   font-weight: 700;
   display: flex;
   align-items: center;
   justify-content: center;
   box-shadow: 0 4px 12px rgba(23, 96, 165, 0.25);
   flex-shrink: 0;
}
.cust-kpi-card {
   border-radius: 14px;
   border: 1px solid #e2e8f0;
   background: #ffffff;
   padding: 18px 20px;
   box-shadow: 0 2px 10px rgba(15, 23, 42, 0.03);
   display: flex;
   align-items: center;
   gap: 16px;
   height: 100%;
   transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.cust-kpi-card:hover {
   transform: translateY(-2px);
   box-shadow: 0 6px 18px rgba(15, 23, 42, 0.06);
}
.cust-kpi-icon {
   width: 48px;
   height: 48px;
   border-radius: 12px;
   display: flex;
   align-items: center;
   justify-content: center;
   font-size: 20px;
   flex-shrink: 0;
}
.cust-kpi-val {
   font-size: 22px;
   font-weight: 800;
   color: #0f172a;
   line-height: 1.2;
}
.cust-kpi-lbl {
   font-size: 12.5px;
   color: #64748b;
   margin-top: 3px;
   font-weight: 600;
}
.cust-kpi-sub {
   font-size: 11.5px;
   color: #94a3b8;
   margin-top: 2px;
}
.cust-panel-card {
   border-radius: 16px;
   border: 1px solid #e2e8f0;
   background: #ffffff;
   box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
   margin-bottom: 20px;
   overflow: hidden;
}
.cust-panel-header {
   background: #ffffff;
   padding: 16px 20px;
   border-bottom: 1px solid #f1f5f9;
   display: flex;
   align-items: center;
   justify-content: space-between;
}
.cust-panel-title {
   font-size: 15.5px;
   font-weight: 700;
   color: #0f172a;
   margin: 0;
   display: flex;
   align-items: center;
   gap: 8px;
}

/* SỔ ĐỊA CHỈ */
.cust-addr-item {
   background: #f8fafc;
   border: 1px solid #e2e8f0;
   border-radius: 12px;
   padding: 12px 14px;
   margin-bottom: 10px;
   display: flex;
   align-items: flex-start;
   gap: 12px;
   font-size: 13.5px;
   line-height: 1.45;
}
.cust-addr-item:last-child {
   margin-bottom: 0;
}

/* BẢNG ĐƠN HÀNG - SỬA TRIỆT ĐỂ LỖI OVERFLOW VÀ CHÈN CHỮ */
.cust-order-table {
   table-layout: fixed !important;
   width: 100% !important;
   margin-bottom: 0 !important;
   border-collapse: collapse !important;
}
.cust-order-table thead th {
   background: #f8fafc !important;
   color: #475569 !important;
   font-size: 12px !important;
   font-weight: 700 !important;
   text-transform: uppercase !important;
   letter-spacing: 0.5px !important;
   border-bottom: 1px solid #e2e8f0 !important;
   padding: 12px 14px !important;
   white-space: nowrap !important;
   vertical-align: middle !important;
}
.cust-order-table tbody td {
   padding: 14px !important;
   vertical-align: middle !important;
   white-space: normal !important;
   word-break: break-word !important;
   border-bottom: 1px solid #f1f5f9 !important;
   font-size: 13px !important;
   color: #334155 !important;
}
.cust-order-table tbody tr:hover td {
   background-color: #f8fafc !important;
}
.cust-med-list {
   display: flex;
   flex-direction: column;
   gap: 6px;
   max-width: 100%;
}
.cust-med-row {
   display: flex;
   align-items: baseline;
   gap: 6px;
   font-size: 13px;
   line-height: 1.4;
}
.cust-med-name {
   font-weight: 600;
   color: #1e293b;
   overflow: hidden;
   text-overflow: ellipsis;
   white-space: nowrap;
   max-width: calc(100% - 46px);
}
.cust-med-qty {
   display: inline-block;
   background: #eff6ff;
   color: #1d4ed8;
   border: 1px solid #bfdbfe;
   border-radius: 4px;
   padding: 1px 6px;
   font-size: 11px;
   font-weight: 700;
   flex-shrink: 0;
}
</style>

<div class="content container-fluid">
   <!-- Breadcrumb & Top bar -->
   <div class="page-header mb-3">
      <div class="row align-items-center">
         <div class="col">
            <h3 class="page-title" style="font-weight:800; color:#0f172a;">Hồ sơ khách hàng</h3>
            <ul class="breadcrumb" style="font-size:13px;">
               <li class="breadcrumb-item"><a href="<?php echo XC_URL; ?>/admin">Trang quản trị</a></li>
               <li class="breadcrumb-item"><a href="<?php echo XC_URL; ?>/admin/customers">Quản lý Khách hàng</a></li>
               <li class="breadcrumb-item active"><?php echo dtHtml($customer->user_fullname !== '' ? $customer->user_fullname : $customer->user_username); ?></li>
            </ul>
         </div>
         <div class="col-auto">
            <a href="<?php echo XC_URL; ?>/admin/customers" class="btn btn-outline-secondary" style="border-radius:10px; font-weight:600; font-size:13px;">
               <i class="fas fa-arrow-left me-1"></i> Quay lại danh sách
            </a>
         </div>
      </div>
   </div>

   <!-- 1. THẺ HERO TỔNG QUAN KHÁCH HÀNG (FULL WIDTH) -->
   <div class="cust-hero-card">
      <div class="row align-items-center g-3">
         <!-- Cột Trái: Avatar + Tên + Badge -->
         <div class="col-xl-6 col-lg-6 col-md-12">
            <div class="d-flex align-items-center gap-3">
               <?php 
                  $initial = mb_substr(trim($customer->user_fullname !== '' ? $customer->user_fullname : ($customer->user_username ?: 'K')), 0, 1, 'UTF-8');
                  if(!empty($customer->user_avatar)){ 
               ?>
                  <img src="<?php echo dtHtml($customer->user_avatar); ?>" class="rounded-circle shadow-sm" style="width:76px; height:76px; object-fit:cover; border:3px solid #1760a5;" alt="Avatar">
               <?php } else { ?>
                  <div class="cust-hero-avatar">
                     <?php echo dtHtml(mb_strtoupper($initial, 'UTF-8')); ?>
                  </div>
               <?php } ?>

               <div style="min-width:0;">
                  <div class="d-flex align-items-center flex-wrap gap-2 mb-1">
                     <h4 class="mb-0" style="font-weight:800; color:#0f172a; font-size:21px;">
                        <?php echo dtHtml($customer->user_fullname !== '' ? $customer->user_fullname : $customer->user_username); ?>
                     </h4>
                     <span class="badge bg-light text-dark border font-monospace" style="font-size:12px; font-weight:700;">#KH<?php echo str_pad($customer->id, 4, '0', STR_PAD_LEFT); ?></span>
                     
                     <!-- Hạng thành viên -->
                     <?php 
                        if($total_spent >= 2000000){
                           echo '<span class="badge" style="background:linear-gradient(135deg, #f59e0b, #d97706); color:#fff; font-size:11.5px; padding:4px 9px;"><i class="fas fa-crown me-1"></i> VIP</span>';
                        } elseif($total_spent >= 500000){
                           echo '<span class="badge" style="background:linear-gradient(135deg, #0ea5e9, #0284c7); color:#fff; font-size:11.5px; padding:4px 9px;"><i class="fas fa-medal me-1"></i> Thân thiết</span>';
                        } else {
                           echo '<span class="badge bg-light text-secondary border" style="font-size:11.5px; padding:4px 9px;"><i class="fas fa-user me-1"></i> Mới</span>';
                        }
                     ?>

                     <!-- Trạng thái -->
                     <?php 
                        if($customer->user_status == 1){
                           echo '<span class="badge" style="background:#ecfdf5; color:#059669; border:1px solid #a7f3d0; font-size:11.5px; padding:4px 9px;"><i class="fas fa-check-circle me-1"></i> Hoạt động</span>';
                        } else {
                           echo '<span class="badge" style="background:#fef2f2; color:#dc2626; border:1px solid #fecaca; font-size:11.5px; padding:4px 9px;"><i class="fas fa-lock me-1"></i> Tạm khóa</span>';
                        }
                     ?>
                  </div>

                  <!-- Thông tin liên hệ nhanh -->
                  <div class="d-flex align-items-center flex-wrap gap-3 text-muted" style="font-size:13px; margin-top:6px;">
                     <div>
                        <i class="fas fa-phone-alt text-primary me-1"></i>
                        <strong class="text-primary font-monospace"><?php echo dtHtml($customer->user_phone ?: 'Chưa cập nhật'); ?></strong>
                     </div>
                     <div>
                        <i class="fas fa-envelope text-secondary me-1"></i>
                        <span><?php echo dtHtml($customer->user_email ?: 'Chưa có email'); ?></span>
                     </div>
                     <div>
                        <i class="fas fa-calendar-alt text-secondary me-1"></i>
                        <span>Tham gia: <?php echo !empty($customer->user_register_time) ? date('d/m/Y', strtotime($customer->user_register_time)) : 'N/A'; ?></span>
                     </div>
                  </div>
               </div>
            </div>
         </div>

         <!-- Cột Phải: Các nút Thao tác quản trị nhanh -->
         <div class="col-xl-6 col-lg-6 col-md-12 text-lg-end">
            <div class="d-flex align-items-center justify-content-lg-end flex-wrap gap-2">
               <button type="button" class="btn btn-outline-primary btn-edit-customer"
                       data-id="<?php echo intval($customer->id); ?>"
                       data-fullname="<?php echo dtHtml($customer->user_fullname); ?>"
                       data-phone="<?php echo dtHtml($customer->user_phone); ?>"
                       data-email="<?php echo dtHtml($customer->user_email); ?>"
                       data-address="<?php echo dtHtml($customer->user_address); ?>"
                       style="border-radius:10px; font-weight:600; font-size:13px; padding:8px 16px;">
                  <i class="fas fa-user-edit me-1"></i> Sửa hồ sơ
               </button>

               <button type="button" class="btn btn-outline-success btn-adjust-points"
                       data-id="<?php echo intval($customer->id); ?>" 
                       data-name="<?php echo dtHtml($customer->user_fullname !== '' ? $customer->user_fullname : $customer->user_username); ?>" 
                       data-points="<?php echo intval($customer->loyalty_points); ?>" 
                       style="border-radius:10px; font-weight:600; font-size:13px; padding:8px 16px;">
                  <i class="fas fa-coins me-1"></i> Điều chỉnh điểm
               </button>

               <?php if($customer->user_status == 1){ ?>
                  <button type="button" class="btn btn-outline-danger btn-toggle-status"
                          data-id="<?php echo intval($customer->id); ?>"
                          data-status="2"
                          style="border-radius:10px; font-weight:600; font-size:13px; padding:8px 16px;">
                     <i class="fas fa-lock me-1"></i> Khóa tài khoản
                  </button>
               <?php } else { ?>
                  <button type="button" class="btn btn-outline-success btn-toggle-status"
                          data-id="<?php echo intval($customer->id); ?>"
                          data-status="1"
                          style="border-radius:10px; font-weight:600; font-size:13px; padding:8px 16px;">
                     <i class="fas fa-unlock me-1"></i> Mở khóa
                  </button>
               <?php } ?>
            </div>
         </div>
      </div>
   </div>

   <!-- 2. HÀNG 4 THẺ THỐNG KÊ TÀI CHÍNH & ĐIỂM THƯỞNG -->
   <div class="row g-3 mb-4">
      <!-- Thẻ 1: Điểm tích lũy -->
      <div class="col-xl-3 col-md-6 col-12">
         <div class="cust-kpi-card">
            <div class="cust-kpi-icon" style="background:#fef3c7; color:#d97706;">
               <i class="fas fa-coins"></i>
            </div>
            <div style="flex:1;">
               <div class="cust-kpi-val" style="color:#d97706;">
                  <?php echo number_format($customer->loyalty_points, 0, ',', '.'); ?> <span style="font-size:14px; font-weight:600;">điểm</span>
               </div>
               <div class="cust-kpi-lbl">Điểm thưởng hiện có</div>
               <div class="cust-kpi-sub">
                  = <strong><?php echo number_format($customer->loyalty_points * 1000, 0, ',', '.'); ?>đ</strong> giảm mua thuốc
               </div>
            </div>
         </div>
      </div>

      <!-- Thẻ 2: Tổng chi tiêu -->
      <div class="col-xl-3 col-md-6 col-12">
         <div class="cust-kpi-card">
            <div class="cust-kpi-icon" style="background:#ecfdf5; color:#059669;">
               <i class="fas fa-wallet"></i>
            </div>
            <div style="flex:1;">
               <div class="cust-kpi-val" style="color:#059669;">
                  <?php echo number_format($total_spent, 0, ',', '.'); ?>đ
               </div>
               <div class="cust-kpi-lbl">Tổng chi tiêu mua thuốc</div>
               <div class="cust-kpi-sub">Toàn bộ đơn thuốc thành công</div>
            </div>
         </div>
      </div>

      <!-- Thẻ 3: Tổng đơn thuốc -->
      <div class="col-xl-3 col-md-6 col-12">
         <div class="cust-kpi-card">
            <div class="cust-kpi-icon" style="background:#eff6ff; color:#1d4ed8;">
               <i class="fas fa-file-invoice-dollar"></i>
            </div>
            <div style="flex:1;">
               <div class="cust-kpi-val" style="color:#1d4ed8;">
                  <?php echo count($orders); ?> <span style="font-size:14px; font-weight:600;">đơn</span>
               </div>
               <div class="cust-kpi-lbl">Tổng số đơn hàng</div>
               <div class="cust-kpi-sub">Đơn đã đặt qua hệ thống</div>
            </div>
         </div>
      </div>

      <!-- Thẻ 4: Điểm đã dùng / tích lũy -->
      <div class="col-xl-3 col-md-6 col-12">
         <div class="cust-kpi-card">
            <div class="cust-kpi-icon" style="background:#faf5ff; color:#7c3aed;">
               <i class="fas fa-tags"></i>
            </div>
            <div style="flex:1;">
               <div class="cust-kpi-val" style="color:#7c3aed;">
                  <?php echo number_format($total_points_used, 0, ',', '.'); ?> <span style="font-size:14px; font-weight:600;">đ đã dùng</span>
               </div>
               <div class="cust-kpi-lbl">Lịch sử dùng điểm</div>
               <div class="cust-kpi-sub">Đã tích: +<?php echo number_format($total_points_earned, 0, ',', '.'); ?> điểm</div>
            </div>
         </div>
      </div>
   </div>

   <!-- 3. BỐ CỤC 2 CỘT CÂN ĐỐI -->
   <div class="row g-3">
      <!-- CỘT TRÁI: SỔ ĐỊA CHỈ & THÔNG TIN HỆ THỐNG -->
      <div class="col-xl-4 col-lg-5 col-12">
         <!-- Sổ địa chỉ nhận hàng -->
         <div class="cust-panel-card">
            <div class="cust-panel-header">
               <h5 class="cust-panel-title">
                  <i class="fas fa-map-marked-alt text-danger"></i> Sổ địa chỉ nhận hàng
               </h5>
               <span class="badge bg-light text-dark border"><?php echo count($shipping_addresses); ?></span>
            </div>
            <div class="p-3">
               <?php if(empty($shipping_addresses)){ ?>
                  <div class="text-center py-4 text-muted">
                     <i class="fas fa-map-pin fa-2x mb-2 text-secondary" style="opacity:0.3;"></i>
                     <p class="mb-0" style="font-size:13px;">Khách hàng chưa lưu địa chỉ nhận thuốc nào.</p>
                  </div>
               <?php } else { foreach($shipping_addresses as $idx => $addr){ ?>
                  <div class="cust-addr-item">
                     <i class="fas fa-map-marker-alt text-danger mt-1" style="font-size:16px;"></i>
                     <div style="flex:1; min-width:0;">
                        <div style="font-weight:600; color:#1e293b;"><?php echo dtHtml($addr); ?></div>
                        <?php if($idx === 0){ ?>
                           <span class="badge bg-primary-light text-primary mt-1" style="font-size:10.5px;">Mặc định / Gần nhất</span>
                        <?php } ?>
                     </div>
                  </div>
               <?php }} ?>
            </div>
         </div>

         <!-- Card thông tin bổ sung -->
         <div class="cust-panel-card">
            <div class="cust-panel-header">
               <h5 class="cust-panel-title">
                  <i class="fas fa-info-circle text-info"></i> Thông tin bổ sung
               </h5>
            </div>
            <div class="p-3" style="font-size:13px; line-height:1.7;">
               <div class="d-flex justify-content-between py-1 border-bottom">
                  <span class="text-muted">Nhóm tài khoản:</span>
                  <strong class="text-dark">Khách hàng thành viên</strong>
               </div>
               <div class="d-flex justify-content-between py-1 border-bottom">
                  <span class="text-muted">Phương thức đăng ký:</span>
                  <span class="text-dark">Số điện thoại / Web</span>
               </div>
               <div class="d-flex justify-content-between py-1 border-bottom">
                  <span class="text-muted">Địa chỉ hồ sơ:</span>
                  <span class="text-dark text-end" style="max-width:180px;"><?php echo dtHtml($customer->user_address ?: 'Chưa cập nhật'); ?></span>
               </div>
               <div class="d-flex justify-content-between py-1">
                  <span class="text-muted">Trạng thái mua hàng:</span>
                  <span class="text-success font-weight-bold"><?php echo count($orders) > 0 ? 'Đã phát sinh đơn' : 'Chưa có đơn'; ?></span>
               </div>
            </div>
         </div>
      </div>

      <!-- CỘT PHẢI: BẢNG LỊCH SỬ MUA THUỐC & ĐƠN HÀNG (CHUẨN HÓA BẢNG) -->
      <div class="col-xl-8 col-lg-7 col-12">
         <div class="cust-panel-card">
            <div class="cust-panel-header">
               <h5 class="cust-panel-title">
                  <i class="fas fa-receipt text-primary"></i> Lịch sử mua thuốc &amp; Đơn hàng
               </h5>
               <span class="badge bg-light text-dark border"><?php echo count($orders); ?> đơn</span>
            </div>
            <div class="p-0">
               <div class="table-responsive">
                  <table class="table cust-order-table">
                     <thead>
                        <tr>
                           <th style="width:20%;" class="ps-3">Mã đơn &amp; Ngày</th>
                           <th style="width:36%;">Danh sách thuốc</th>
                           <th style="width:16%;" class="text-center">Hình thức</th>
                           <th style="width:14%;" class="text-end">Tổng tiền</th>
                           <th style="width:8%;" class="text-center">Điểm</th>
                           <th style="width:6%;" class="text-center pe-3">Xem</th>
                        </tr>
                     </thead>
                     <tbody>
                     <?php if(empty($orders)){ ?>
                        <tr>
                           <td colspan="6" class="text-center py-5 text-muted">
                              <i class="fas fa-shopping-bag fa-3x mb-3 text-secondary" style="opacity:0.3;"></i>
                              <p class="mb-0">Khách hàng chưa phát sinh đơn thuốc nào.</p>
                           </td>
                        </tr>
                     <?php } else { foreach($orders as $ord){ 
                        $meds = json_decode($ord->medicines, true);
                     ?>
                        <tr>
                           <!-- Cột 1: Mã đơn & Ngày -->
                           <td class="ps-3">
                              <div style="font-weight:700; color:#1760a5; font-size:13.5px;">#DH<?php echo str_pad($ord->id, 5, '0', STR_PAD_LEFT); ?></div>
                              <div style="color:#64748b; font-size:12px; margin-top:2px;">
                                 <?php echo date('d/m/Y H:i', strtotime($ord->created_at)); ?>
                              </div>
                           </td>

                           <!-- Cột 2: Danh sách thuốc (Clean list, không tràn, không chèn chữ) -->
                           <td>
                              <?php if(!empty($meds) && is_array($meds)){ ?>
                                 <div class="cust-med-list">
                                    <?php foreach(array_slice($meds, 0, 2) as $m){ ?>
                                       <div class="cust-med-row">
                                          <i class="fas fa-capsules text-primary" style="font-size:11px; flex-shrink:0;"></i>
                                          <span class="cust-med-name" title="<?php echo dtHtml($m['name']); ?>">
                                             <?php echo dtHtml($m['name']); ?>
                                          </span>
                                          <span class="cust-med-qty">x<?php echo intval($m['qty']); ?></span>
                                       </div>
                                    <?php } ?>

                                    <?php if(count($meds) > 2){ ?>
                                       <div style="font-size:11.5px; color:#64748b; margin-left:17px;">
                                          +<?php echo count($meds) - 2; ?> loại thuốc khác
                                       </div>
                                    <?php } ?>
                                 </div>
                              <?php } else { ?>
                                 <span class="text-muted" style="font-style:italic;">Không có chi tiết</span>
                              <?php } ?>
                           </td>

                           <!-- Cột 3: Hình thức nhận thuốc -->
                           <td class="text-center">
                              <span class="badge bg-light text-dark border" style="font-size:11.5px; padding:5px 8px; font-weight:600;">
                                 <?php echo dtHtml($ord->ship_method ?: 'Nhận tại quầy'); ?>
                              </span>
                           </td>

                           <!-- Cột 4: Tổng tiền -->
                           <td class="text-end">
                              <span style="font-weight:800; color:#0f172a; font-size:13.5px;">
                                 <?php echo number_format($ord->total_amount, 0, ',', '.'); ?>đ
                              </span>
                           </td>

                           <!-- Cột 5: Điểm đơn -->
                           <td class="text-center">
                              <?php if(!empty($ord->points_earned)){ ?>
                                 <span class="text-success" style="font-weight:700; font-size:12px;" title="Điểm tích lũy">+<?php echo intval($ord->points_earned); ?> đ</span>
                              <?php } ?>
                              <?php if(!empty($ord->points_used)){ ?>
                                 <br><span class="text-danger" style="font-size:11px; font-weight:600;" title="Điểm đã dùng">-<?php echo intval($ord->points_used); ?> đ</span>
                              <?php } ?>
                              <?php if(empty($ord->points_earned) && empty($ord->points_used)){ echo '<span class="text-muted">-</span>'; } ?>
                           </td>

                           <!-- Cột 6: Xem chi tiết -->
                           <td class="text-center pe-3">
                              <a href="<?php echo XC_URL; ?>/admin/booking_internal/detail/<?php echo intval($ord->id); ?>" 
                                 class="btn btn-sm btn-outline-primary" 
                                 style="border-radius:8px; padding:4px 8px;" 
                                 title="Xem chi tiết đơn thuốc">
                                 <i class="fas fa-eye"></i>
                              </a>
                           </td>
                        </tr>
                     <?php }} ?>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<!-- Modal Chỉnh sửa thông tin khách hàng -->
<div class="modal fade" id="modalEditCustomer" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content" style="border-radius:18px; border:none; box-shadow:0 20px 40px rgba(0,0,0,0.15);">
         <div class="modal-header border-0 pb-0">
            <h5 class="modal-title" style="font-weight:700;"><i class="fas fa-user-edit text-primary me-2"></i>Cập nhật thông tin khách hàng</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body pt-3">
            <form id="formEditCustomer">
               <input type="hidden" id="edit_cust_id" name="id">
               <div class="mb-3">
                  <label class="form-label" style="font-weight:600; font-size:13px;">Họ và tên <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="edit_cust_fullname" name="fullname" required>
               </div>
               <div class="mb-3">
                  <label class="form-label" style="font-weight:600; font-size:13px;">Số điện thoại <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="edit_cust_phone" name="phone" placeholder="Ví dụ: 0353878958" required>
               </div>
               <div class="mb-3">
                  <label class="form-label" style="font-weight:600; font-size:13px;">Email</label>
                  <input type="email" class="form-control" id="edit_cust_email" name="email" placeholder="Ví dụ: customer@gmail.com">
               </div>
               <div class="mb-3">
                  <label class="form-label" style="font-weight:600; font-size:13px;">Địa chỉ nhận hàng mặc định</label>
                  <textarea class="form-control" id="edit_cust_address" name="address" rows="3" placeholder="Số nhà, đường, phường/xã, quận/huyện, tỉnh/thành phố..."></textarea>
               </div>
            </form>
         </div>
         <div class="modal-footer border-0 pt-0">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius:10px; font-weight:600;">Hủy</button>
            <button type="button" class="btn btn-primary" id="btnSaveCustomer" style="border-radius:10px; font-weight:600; background:#1760a5;">
               <i class="fas fa-save me-1"></i> Lưu thông tin
            </button>
         </div>
      </div>
   </div>
</div>

<!-- Modal Điều chỉnh điểm tích lũy -->
<div class="modal fade" id="modalAdjustPoints" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content" style="border-radius:18px; border:none; box-shadow:0 20px 40px rgba(0,0,0,0.15);">
         <div class="modal-header border-0 pb-0">
            <h5 class="modal-title" style="font-weight:700;"><i class="fas fa-coins text-warning me-2"></i>Điều chỉnh điểm tích lũy</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body pt-3">
            <div class="alert alert-light border mb-3" style="border-radius:10px;">
               Khách hàng: <strong id="point_cust_name" class="text-primary"></strong><br>
               Điểm hiện tại: <span class="badge bg-success" id="point_cust_current">0 điểm</span>
            </div>
            <form id="formAdjustPoints">
               <input type="hidden" id="point_cust_id" name="id">
               <div class="mb-3">
                  <label class="form-label" style="font-weight:600; font-size:13px;">Thao tác</label>
                  <select class="form-control" id="point_action" name="action">
                     <option value="add">Cộng thêm điểm thưởng (+)</option>
                     <option value="deduct">Khấu trừ điểm (-)</option>
                     <option value="set">Đặt lại số điểm cố định (=)</option>
                  </select>
               </div>
               <div class="mb-3">
                  <label class="form-label" style="font-weight:600; font-size:13px;">Số điểm điều chỉnh <span class="text-danger">*</span></label>
                  <input type="number" class="form-control" id="point_amount" name="amount" min="1" placeholder="Nhập số điểm..." required>
                  <small class="text-muted">1 điểm = 1.000đ giá trị giảm giá khi đặt thuốc.</small>
               </div>
               <div class="mb-3">
                  <label class="form-label" style="font-weight:600; font-size:13px;">Lý do điều chỉnh <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="point_reason" name="reason" placeholder="Ví dụ: Tặng quà sinh nhật, bồi hoàn đơn hàng, điều chỉnh sai sót..." required>
               </div>
            </form>
         </div>
         <div class="modal-footer border-0 pt-0">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius:10px; font-weight:600;">Hủy</button>
            <button type="button" class="btn btn-warning text-dark" id="btnConfirmAdjustPoints" style="border-radius:10px; font-weight:700;">
               <i class="fas fa-check me-1"></i> Xác nhận điều chỉnh
            </button>
         </div>
      </div>
   </div>
</div>

<script>
$(document).ready(function(){
   // 1. Mở modal sửa thông tin khách hàng
   $('.btn-edit-customer').click(function(){
      $('#edit_cust_id').val($(this).data('id'));
      $('#edit_cust_fullname').val($(this).data('fullname'));
      $('#edit_cust_phone').val($(this).data('phone'));
      $('#edit_cust_email').val($(this).data('email'));
      $('#edit_cust_address').val($(this).data('address'));
      $('#modalEditCustomer').modal('show');
   });

   $('#btnSaveCustomer').click(function(){
      var id = $('#edit_cust_id').val();
      var fullname = $.trim($('#edit_cust_fullname').val());
      var phone = $.trim($('#edit_cust_phone').val());
      var email = $.trim($('#edit_cust_email').val());
      var address = $.trim($('#edit_cust_address').val());

      if(fullname.length < 2){
         Swal.fire({position:'center', icon:'error', title:'Họ tên tối thiểu 2 ký tự.', showConfirmButton:true, confirmButtonText:'Đóng'});
         return;
      }
      if(phone !== '' && !/^0[35789][0-9]{8}$/.test(phone)){
         Swal.fire({position:'center', icon:'error', title:'Số điện thoại không đúng định dạng di động Việt Nam (10 số).', showConfirmButton:true, confirmButtonText:'Đóng'});
         return;
      }

      var btn = $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Đang lưu...');
      $.ajax({
         url: '<?php echo XC_URL; ?>/api/updateCustomerPharmacy',
         type: 'POST',
         dataType: 'json',
         data: { id: id, fullname: fullname, phone: phone, email: email, address: address },
         success: function(res){
            btn.prop('disabled', false).html('<i class="fas fa-save me-1"></i> Lưu thông tin');
            if(res && res.status === 200){
               $('#modalEditCustomer').modal('hide');
               Swal.fire({
                  position: 'center',
                  icon: 'success',
                  title: res.message || 'Cập nhật thành công!',
                  showConfirmButton: false,
                  timer: 1500,
                  timerProgressBar: true
               }).then(function(){
                  location.reload();
               });
            } else {
               Swal.fire({position:'center', icon:'error', title: (res && res.message) ? res.message : 'Lỗi cập nhật', showConfirmButton:true, confirmButtonText:'Đóng'});
            }
         },
         error: function(){
            btn.prop('disabled', false).html('<i class="fas fa-save me-1"></i> Lưu thông tin');
            Swal.fire({position:'center', icon:'error', title:'Không thể kết nối đến máy chủ.', showConfirmButton:true, confirmButtonText:'Đóng'});
         }
      });
   });

   // 2. Mở modal điều chỉnh điểm
   $('.btn-adjust-points').click(function(){
      $('#point_cust_id').val($(this).data('id'));
      $('#point_cust_name').text($(this).data('name'));
      $('#point_cust_current').text($(this).data('points') + ' điểm');
      $('#point_amount').val('');
      $('#point_reason').val('');
      $('#modalAdjustPoints').modal('show');
   });

   $('#btnConfirmAdjustPoints').click(function(){
      var id = $('#point_cust_id').val();
      var action = $('#point_action').val();
      var amount = parseInt($('#point_amount').val(), 10);
      var reason = $.trim($('#point_reason').val());

      if(isNaN(amount) || amount <= 0){
         Swal.fire({position:'center', icon:'error', title:'Vui lòng nhập số điểm hợp lệ lớn hơn 0.', showConfirmButton:true, confirmButtonText:'Đóng'});
         return;
      }
      if(reason.length < 3){
         Swal.fire({position:'center', icon:'error', title:'Vui lòng nhập lý do điều chỉnh cụ thể.', showConfirmButton:true, confirmButtonText:'Đóng'});
         return;
      }

      var btn = $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Đang xử lý...');
      $.ajax({
         url: '<?php echo XC_URL; ?>/api/adjustCustomerPoints',
         type: 'POST',
         dataType: 'json',
         data: { id: id, action: action, amount: amount, reason: reason },
         success: function(res){
            btn.prop('disabled', false).html('<i class="fas fa-check me-1"></i> Xác nhận điều chỉnh');
            if(res && res.status === 200){
               $('#modalAdjustPoints').modal('hide');
               Swal.fire({
                  position: 'center',
                  icon: 'success',
                  title: res.message || 'Điều chỉnh điểm thành công!',
                  showConfirmButton: false,
                  timer: 1500,
                  timerProgressBar: true
               }).then(function(){
                  location.reload();
               });
            } else {
               Swal.fire({position:'center', icon:'error', title: (res && res.message) ? res.message : 'Lỗi điều chỉnh điểm', showConfirmButton:true, confirmButtonText:'Đóng'});
            }
         },
         error: function(){
            btn.prop('disabled', false).html('<i class="fas fa-check me-1"></i> Xác nhận điều chỉnh');
            Swal.fire({position:'center', icon:'error', title:'Không thể kết nối đến máy chủ.', showConfirmButton:true, confirmButtonText:'Đóng'});
         }
      });
   });

   // 3. Khóa / Mở khóa tài khoản khách hàng
   $('.btn-toggle-status').click(function(){
      var id = $(this).data('id');
      var newStatus = $(this).data('status');
      var actionText = newStatus == 1 ? 'mở khóa' : 'tạm khóa';

      Swal.fire({
         position: 'center',
         title: 'Xác nhận ' + actionText + ' tài khoản?',
         text: 'Bạn có chắc chắn muốn ' + actionText + ' tài khoản khách hàng này?',
         icon: 'warning',
         showCancelButton: true,
         confirmButtonText: 'Đồng ý',
         cancelButtonText: 'Hủy'
      }).then(function(result){
         if(result.isConfirmed){
            $.ajax({
               url: '<?php echo XC_URL; ?>/api/toggleCustomerStatus',
               type: 'POST',
               dataType: 'json',
               data: { id: id, status: newStatus },
               success: function(res){
                  if(res && res.status === 200){
                     Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: res.message || 'Cập nhật trạng thái thành công!',
                        showConfirmButton: false,
                        timer: 1400,
                        timerProgressBar: true
                     }).then(function(){
                        location.reload();
                     });
                  } else {
                     Swal.fire({position:'center', icon:'error', title: (res && res.message) ? res.message : 'Lỗi cập nhật', showConfirmButton:true, confirmButtonText:'Đóng'});
                  }
               },
               error: function(){
                  Swal.fire({position:'center', icon:'error', title:'Không thể kết nối đến máy chủ.', showConfirmButton:true, confirmButtonText:'Đóng'});
               }
            });
         }
      });
   });
});
</script>

<?php include_once "footer.php"; ?>
