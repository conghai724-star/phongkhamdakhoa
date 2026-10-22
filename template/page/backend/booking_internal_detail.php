<?php include_once "header.php"; ?>
<?php
function bookingInternalDetailHtml($value){ return nl2br(htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8')); }
$medicines=$booking_internal?json_decode($booking_internal->medicines,true):array();
?>
<div class="content container-fluid">
	<div class="page-header"><div class="row align-items-center"><div class="col"><h3 class="page-title">Chi tiết đơn thuốc nội bộ</h3></div><div class="col-auto"><a href="<?php echo XC_URL; ?>/admin/booking_internal" class="btn btn-white">Quay lại danh sách</a></div></div></div>
	<?php if(!$booking_internal){ ?><div class="alert alert-warning">Không tìm thấy đơn thuốc.</div><?php } else { ?>
	<div class="card"><div class="card-body"><h4 class="card-title">Thông tin người đặt</h4><div class="row">
		<div class="col-md-6"><p><strong>Họ tên:</strong> <?php echo bookingInternalDetailHtml($booking_internal->fullname); ?></p></div>
		<div class="col-md-6"><p><strong>Điện thoại:</strong> <?php echo bookingInternalDetailHtml($booking_internal->phone); ?></p></div>
		<div class="col-md-6"><p><strong>Đối tượng:</strong> <?php echo bookingInternalDetailHtml($booking_internal->user_type); ?></p></div>
		<div class="col-md-6"><p><strong>Đơn vị/Lớp/Bộ phận:</strong> <?php echo bookingInternalDetailHtml($booking_internal->department); ?></p></div>
		<div class="col-md-6"><p><strong>Hình thức nhận:</strong> <?php echo bookingInternalDetailHtml($booking_internal->ship_method); ?></p></div>
		<div class="col-md-6"><p><strong>Thời gian nhận:</strong> <?php echo bookingInternalDetailHtml($booking_internal->receive_time); ?></p></div>
		<div class="col-md-6"><p><strong>Thanh toán:</strong> <?php echo bookingInternalDetailHtml($booking_internal->payment_method); ?></p></div>
		<div class="col-md-6"><p><strong>Ngày đặt:</strong> <?php echo date('d/m/Y H:i',strtotime($booking_internal->created_at)); ?></p></div>
		<div class="col-12"><p><strong>Địa chỉ:</strong> <?php echo bookingInternalDetailHtml($booking_internal->address); ?></p></div>
		<div class="col-12"><p><strong>Ghi chú:</strong> <?php echo bookingInternalDetailHtml($booking_internal->extra_note); ?></p></div>
		<?php if(!empty($booking_internal->prescription_file)){ ?><div class="col-12"><p><strong>Đơn thuốc:</strong> <a target="_blank" href="<?php echo XC_URL; ?>/uploads/booking_internal/<?php echo rawurlencode($booking_internal->prescription_file); ?>">Xem file đính kèm</a></p></div><?php } ?>
	</div></div></div>
	<div class="card card-table"><div class="card-body"><div class="table-responsive"><table class="table table-center">
		<thead class="thead-light"><tr><th>STT</th><th>Tên thuốc/sản phẩm</th><th>Hàm lượng</th><th>Số lượng</th><th>Ghi chú</th></tr></thead><tbody>
		<?php if(empty($medicines)){ ?><tr><td colspan="5" class="text-center">Không có dữ liệu thuốc.</td></tr>
		<?php } else { $i=1; foreach($medicines as $medicine){ ?><tr>
			<td><?php echo $i++; ?></td><td><?php echo bookingInternalDetailHtml(isset($medicine['name'])?$medicine['name']:''); ?></td><td><?php echo bookingInternalDetailHtml(isset($medicine['spec'])?$medicine['spec']:''); ?></td><td><?php echo bookingInternalDetailHtml(isset($medicine['qty'])?$medicine['qty']:''); ?></td><td><?php echo bookingInternalDetailHtml(isset($medicine['note'])?$medicine['note']:''); ?></td>
		</tr><?php }} ?>
		</tbody></table></div></div></div>
	<?php } ?>
</div></div>
<?php include_once "footer.php"; ?>
