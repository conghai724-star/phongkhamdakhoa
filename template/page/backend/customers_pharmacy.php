<?php include_once "header.php"; ?>
<?php function custHtml($val){ return htmlspecialchars((string)$val, ENT_QUOTES, 'UTF-8'); } ?>
<style>
.cust-kpi-card {
   border-radius: 14px;
   border: 1px solid #e2e8f0;
   background: #fff;
   padding: 18px 20px;
   box-shadow: 0 4px 12px rgba(15, 23, 42, 0.04);
   display: flex;
   align-items: center;
   gap: 16px;
   margin-bottom: 20px;
   transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.cust-kpi-card:hover {
   transform: translateY(-2px);
   box-shadow: 0 8px 20px rgba(15, 23, 42, 0.08);
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
.cust-kpi-label {
   font-size: 13px;
   color: #64748b;
   margin-top: 3px;
   font-weight: 500;
}
.badge-tier-vip {
   background: linear-gradient(135deg, #f59e0b, #d97706);
   color: #fff;
   font-weight: 700;
   padding: 4px 10px;
   border-radius: 20px;
   font-size: 11px;
}
.badge-tier-loyal {
   background: linear-gradient(135deg, #0ea5e9, #0284c7);
   color: #fff;
   font-weight: 700;
   padding: 4px 10px;
   border-radius: 20px;
   font-size: 11px;
}
.badge-tier-new {
   background: #f1f5f9;
   color: #475569;
   font-weight: 600;
   padding: 4px 10px;
   border-radius: 20px;
   font-size: 11px;
}
.points-pill {
   background: #ecfdf5;
   color: #059669;
   border: 1px solid #a7f3d0;
   font-weight: 700;
   padding: 3px 8px;
   border-radius: 6px;
   font-size: 12px;
   display: inline-flex;
   align-items: center;
   gap: 4px;
}
.avatar-circle {
   width: 38px;
   height: 38px;
   border-radius: 50%;
   background: #1760a5;
   color: #fff;
   display: flex;
   align-items: center;
   justify-content: center;
   font-weight: 700;
   font-size: 15px;
   flex-shrink: 0;
}
</style>

<div class="content container-fluid">
   <div class="page-header">
      <div class="row align-items-center">
         <div class="col">
            <h3 class="page-title">Quản lý Khách hàng</h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="<?php echo XC_URL; ?>/admin">Trang quản trị</a></li>
               <li class="breadcrumb-item active">Khách hàng nhà thuốc</li>
            </ul>
         </div>
      </div>
   </div>

   <!-- Thống kê KPIs -->
   <div class="row">
      <div class="col-xl-3 col-sm-6 col-12">
         <div class="cust-kpi-card">
            <div class="cust-kpi-icon" style="background:#e0f2fe; color:#0284c7;">
               <i class="fas fa-users"></i>
            </div>
            <div>
               <div class="cust-kpi-val"><?php echo number_format($kpi['total_customers'], 0, ',', '.'); ?></div>
               <div class="cust-kpi-label">Tổng khách hàng</div>
            </div>
         </div>
      </div>
      <div class="col-xl-3 col-sm-6 col-12">
         <div class="cust-kpi-card">
            <div class="cust-kpi-icon" style="background:#ecfdf5; color:#059669;">
               <i class="fas fa-coins"></i>
            </div>
            <div>
               <div class="cust-kpi-val"><?php echo number_format($kpi['total_points'], 0, ',', '.'); ?></div>
               <div class="cust-kpi-label">Điểm tích lũy lưu hành</div>
            </div>
         </div>
      </div>
      <div class="col-xl-3 col-sm-6 col-12">
         <div class="cust-kpi-card">
            <div class="cust-kpi-icon" style="background:#fef3c7; color:#d97706;">
               <i class="fas fa-money-bill-wave"></i>
            </div>
            <div>
               <div class="cust-kpi-val"><?php echo number_format($kpi['total_revenue'], 0, ',', '.'); ?>đ</div>
               <div class="cust-kpi-label">Tổng chi tiêu đơn thuốc</div>
            </div>
         </div>
      </div>
      <div class="col-xl-3 col-sm-6 col-12">
         <div class="cust-kpi-card">
            <div class="cust-kpi-icon" style="background:#f3e8ff; color:#7e22ce;">
               <i class="fas fa-user-plus"></i>
            </div>
            <div>
               <div class="cust-kpi-val"><?php echo number_format($kpi['new_this_month'], 0, ',', '.'); ?></div>
               <div class="cust-kpi-label">Khách mới tháng này</div>
            </div>
         </div>
      </div>
   </div>

   <!-- Bộ lọc & Tìm kiếm -->
   <div class="card mb-4" style="border-radius:14px; border:1px solid #e2e8f0;">
      <div class="card-body">
         <form method="get" action="<?php echo XC_URL; ?>/admin/customers" class="row align-items-end g-3">
            <div class="col-md-5">
               <label class="form-label" style="font-weight:600; font-size:13px;">Tìm kiếm khách hàng</label>
               <div class="input-group">
                  <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                  <input type="text" name="keyword" class="form-control border-start-0" placeholder="Nhập họ tên, số điện thoại, email hoặc địa chỉ..." value="<?php echo custHtml($filter_keyword); ?>">
               </div>
            </div>
            <div class="col-md-3">
               <label class="form-label" style="font-weight:600; font-size:13px;">Hạng khách hàng</label>
               <select name="tier" class="form-control">
                  <option value="">-- Tất cả các hạng --</option>
                  <option value="vip" <?php if($filter_tier === 'vip') echo 'selected'; ?>>VIP (Chi tiêu &ge; 2.000.000đ)</option>
                  <option value="loyal" <?php if($filter_tier === 'loyal') echo 'selected'; ?>>Thân thiết (500k - 2.000.000đ)</option>
                  <option value="new" <?php if($filter_tier === 'new') echo 'selected'; ?>>Khách mới (&lt; 500.000đ)</option>
               </select>
            </div>
            <div class="col-md-2">
               <label class="form-label" style="font-weight:600; font-size:13px;">Trạng thái</label>
               <select name="status" class="form-control">
                  <option value="">-- Tất cả --</option>
                  <option value="1" <?php if($filter_status === '1') echo 'selected'; ?>>Đang hoạt động</option>
                  <option value="2" <?php if($filter_status === '2') echo 'selected'; ?>>Tạm khóa</option>
               </select>
            </div>
            <div class="col-md-2">
               <button type="submit" class="btn btn-primary w-100" style="height:40px; font-weight:600;">
                  <i class="fas fa-filter me-1"></i> Lọc
               </button>
            </div>
         </form>
      </div>
   </div>

   <!-- Danh sách khách hàng -->
   <div class="card card-table" style="border-radius:14px; border:1px solid #e2e8f0; overflow:hidden;">
      <div class="card-body p-0">
         <div class="table-responsive">
            <table class="table table-hover table-center mb-0">
               <thead style="background:#f8fafc; font-size:12.5px; text-transform:uppercase; color:#64748b;">
                  <tr>
                     <th class="ps-3" style="width:70px;">Mã KH</th>
                     <th>Khách hàng</th>
                     <th>Số điện thoại</th>
                     <th>Địa chỉ nhận hàng</th>
                     <th class="text-center">Điểm tích lũy</th>
                     <th class="text-center">Số đơn</th>
                     <th class="text-end">Tổng chi tiêu</th>
                     <th class="text-center">Hạng KH</th>
                     <th class="text-center">Trạng thái</th>
                     <th class="text-center pe-3" style="width:140px;">Thao tác</th>
                  </tr>
               </thead>
               <tbody style="font-size:13.5px;">
               <?php if(empty($customers)){ ?>
                  <tr>
                     <td colspan="10" class="text-center py-5 text-muted">
                        <i class="fas fa-user-slash fa-3x mb-3 text-secondary" style="opacity:0.4;"></i>
                        <p class="mb-0">Không tìm thấy khách hàng nào phù hợp với điều kiện tìm kiếm.</p>
                     </td>
                  </tr>
               <?php } else { foreach($customers as $c){ 
                  $totalSpent = (float)$c->total_spent;
                  $tierClass = 'badge-tier-new';
                  $tierName = 'Mới';
                  if($totalSpent >= 2000000){
                     $tierClass = 'badge-tier-vip';
                     $tierName = 'VIP';
                  } elseif($totalSpent >= 500000){
                     $tierClass = 'badge-tier-loyal';
                     $tierName = 'Thân thiết';
                  }
                  $initial = mb_substr(trim($c->user_fullname !== '' ? $c->user_fullname : ($c->user_username ?: 'K')), 0, 1, 'UTF-8');
                  $shippingAddr = !empty($c->last_order_address) ? $c->last_order_address : ($c->user_address ?: 'Chưa cập nhật');
               ?>
                  <tr id="cust-row-<?php echo intval($c->id); ?>">
                     <td class="ps-3 text-muted" style="font-weight:600;">#KH<?php echo str_pad($c->id, 4, '0', STR_PAD_LEFT); ?></td>
                     <td>
                        <div class="d-flex align-items-center gap-2">
                           <?php if(!empty($c->user_avatar)){ ?>
                              <img src="<?php echo custHtml($c->user_avatar); ?>" class="avatar-circle" style="object-fit:cover;" alt="Avatar">
                           <?php } else { ?>
                              <div class="avatar-circle"><?php echo custHtml(mb_strtoupper($initial, 'UTF-8')); ?></div>
                           <?php } ?>
                           <div>
                              <div style="font-weight:700; color:#0f172a;">
                                 <a href="<?php echo XC_URL; ?>/admin/customers/detail/<?php echo intval($c->id); ?>" style="color:#0f172a; text-decoration:none;">
                                    <?php echo custHtml($c->user_fullname !== '' ? $c->user_fullname : $c->user_username); ?>
                                 </a>
                              </div>
                              <div style="font-size:12px; color:#94a3b8;"><?php echo custHtml($c->user_email ?: 'Không có email'); ?></div>
                           </div>
                        </div>
                     </td>
                     <td>
                        <?php if(!empty($c->user_phone)){ ?>
                           <span style="font-weight:600; color:#1e293b;"><?php echo custHtml($c->user_phone); ?></span>
                        <?php } else { ?>
                           <span class="text-muted" style="font-style:italic;">Chưa có</span>
                        <?php } ?>
                     </td>
                     <td style="max-width:220px;" title="<?php echo custHtml($shippingAddr); ?>">
                        <div style="white-space:nowrap; overflow:hidden; text-overflow:ellipsis; color:#475569;">
                           <?php echo custHtml($shippingAddr); ?>
                        </div>
                     </td>
                     <td class="text-center">
                        <span class="points-pill" title="Tương đương <?php echo number_format($c->loyalty_points * 1000, 0, ',', '.'); ?>đ">
                           <i class="fas fa-coins text-warning"></i> <?php echo number_format($c->loyalty_points, 0, ',', '.'); ?>
                        </span>
                     </td>
                     <td class="text-center" style="font-weight:600;">
                        <?php echo intval($c->total_orders); ?>
                     </td>
                     <td class="text-end" style="font-weight:700; color:#155191;">
                        <?php echo number_format($totalSpent, 0, ',', '.'); ?>đ
                     </td>
                     <td class="text-center">
                        <span class="<?php echo $tierClass; ?>"><?php echo $tierName; ?></span>
                     </td>
                     <td class="text-center">
                        <?php if($c->user_status == 1){ ?>
                           <span class="badge badge-pill bg-success-light text-success" style="font-weight:600; padding:4px 8px;">Hoạt động</span>
                        <?php } else { ?>
                           <span class="badge badge-pill bg-danger-light text-danger" style="font-weight:600; padding:4px 8px;">Tạm khóa</span>
                        <?php } ?>
                     </td>
                     <td class="text-center pe-3">
                        <div class="d-inline-flex gap-1">
                           <a href="<?php echo XC_URL; ?>/admin/customers/detail/<?php echo intval($c->id); ?>" class="btn btn-sm btn-white text-primary" title="Xem hồ sơ & lịch sử đơn hàng">
                              <i class="fas fa-eye"></i>
                           </a>
                           <button type="button" class="btn btn-sm btn-white text-warning btn-adjust-points" 
                                   data-id="<?php echo intval($c->id); ?>" 
                                   data-name="<?php echo custHtml($c->user_fullname !== '' ? $c->user_fullname : $c->user_username); ?>" 
                                   data-points="<?php echo intval($c->loyalty_points); ?>" 
                                   title="Cộng/Trừ điểm thưởng">
                              <i class="fas fa-coins"></i>
                           </button>
                           <button type="button" class="btn btn-sm btn-white text-info btn-edit-customer"
                                   data-id="<?php echo intval($c->id); ?>"
                                   data-fullname="<?php echo custHtml($c->user_fullname); ?>"
                                   data-phone="<?php echo custHtml($c->user_phone); ?>"
                                   data-email="<?php echo custHtml($c->user_email); ?>"
                                   data-address="<?php echo custHtml($c->user_address); ?>"
                                   title="Chỉnh sửa thông tin">
                              <i class="fas fa-edit"></i>
                           </button>
                           <?php if($c->user_status == 1){ ?>
                              <button type="button" class="btn btn-sm btn-white text-danger btn-toggle-status" data-id="<?php echo intval($c->id); ?>" data-status="2" title="Khóa tài khoản">
                                 <i class="fas fa-lock"></i>
                              </button>
                           <?php } else { ?>
                              <button type="button" class="btn btn-sm btn-white text-success btn-toggle-status" data-id="<?php echo intval($c->id); ?>" data-status="1" title="Kích hoạt tài khoản">
                                 <i class="fas fa-unlock"></i>
                              </button>
                           <?php } ?>
                        </div>
                     </td>
                  </tr>
               <?php }} ?>
               </tbody>
            </table>
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
   // 1. Mở modal chỉnh sửa thông tin khách hàng
   $('.btn-edit-customer').click(function(){
      $('#edit_cust_id').val($(this).data('id'));
      $('#edit_cust_fullname').val($(this).data('fullname'));
      $('#edit_cust_phone').val($(this).data('phone'));
      $('#edit_cust_email').val($(this).data('email'));
      $('#edit_cust_address').val($(this).data('address'));
      $('#modalEditCustomer').modal('show');
   });

   // Lưu chỉnh sửa thông tin khách hàng
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
                  title: res.message || 'Cập nhật thông tin khách hàng thành công!',
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

   // 2. Mở modal điều chỉnh điểm thưởng
   $('.btn-adjust-points').click(function(){
      $('#point_cust_id').val($(this).data('id'));
      $('#point_cust_name').text($(this).data('name'));
      $('#point_cust_current').text($(this).data('points') + ' điểm');
      $('#point_amount').val('');
      $('#point_reason').val('');
      $('#modalAdjustPoints').modal('show');
   });

   // Xác nhận điều chỉnh điểm thưởng
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
         Swal.fire({position:'center', icon:'error', title:'Vui lòng nhập lý do điều chỉnh điểm cụ thể.', showConfirmButton:true, confirmButtonText:'Đóng'});
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

