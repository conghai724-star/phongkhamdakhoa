<?php include_once "header.php"; ?>
<?php function bookingInternalHtml($value){ return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); } ?>
<div class="content container-fluid">
	<div class="page-header"><div class="row align-items-center"><div class="col"><h3 class="page-title">Quản lý đơn thuốc nội bộ</h3></div></div></div>
	<div class="card"><div class="card-body">
		<form method="get" action="<?php echo XC_URL; ?>/admin/booking_internal" class="row align-items-end">
			<div class="col-md-4 form-group"><label>Tên người đặt</label><input type="text" name="name" class="form-control" value="<?php echo bookingInternalHtml($filter_name); ?>" placeholder="Nhập tên cần tìm"></div>
			<div class="col-md-3 form-group"><label>Ngày đặt</label><input type="date" name="date" class="form-control" value="<?php echo bookingInternalHtml($filter_date); ?>"></div>
			<div class="col-md-5 form-group"><button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Lọc</button> <a href="<?php echo XC_URL; ?>/admin/booking_internal" class="btn btn-white">Xóa bộ lọc</a></div>
		</form>
	</div></div>
	<div class="card card-table"><div class="card-body"><div class="table-responsive">
		<table class="table table-center table-hover"><thead class="thead-light"><tr><th>STT</th><th>Người đặt</th><th>Điện thoại</th><th>Đơn vị/Lớp</th><th>Số sản phẩm</th><th>Ngày đặt</th><th>Thao tác</th></tr></thead><tbody>
		<?php if(empty($booking_internals)){ ?><tr><td colspan="7" class="text-center">Không có đơn thuốc phù hợp.</td></tr>
		<?php } else { $i=1; foreach($booking_internals as $booking){ $medicines=json_decode($booking->medicines,true); ?>
			<tr id="booking-row-<?php echo intval($booking->id); ?>">
				<td><?php echo $i++; ?></td><td><?php echo bookingInternalHtml($booking->fullname); ?></td><td><?php echo bookingInternalHtml($booking->phone); ?></td>
				<td><?php echo bookingInternalHtml($booking->department); ?></td><td><?php echo is_array($medicines)?count($medicines):0; ?></td><td><?php echo date('d/m/Y H:i',strtotime($booking->created_at)); ?></td>
				<td><a class="btn btn-sm btn-white text-primary" href="<?php echo XC_URL; ?>/admin/booking_internal/detail/<?php echo intval($booking->id); ?>">Xem chi tiết</a> <button type="button" class="btn btn-sm btn-white text-danger btn-delete-internal" data-id="<?php echo intval($booking->id); ?>">Xóa</button></td>
			</tr>
		<?php }} ?>
		</tbody></table>
	</div></div></div>
</div></div>
<script>
document.querySelectorAll('.btn-delete-internal').forEach(function(button){
	button.addEventListener('click',function(){
		const id=this.dataset.id;
		Swal.fire({title:'Xóa đơn thuốc này?',text:'Dữ liệu và file đính kèm sẽ bị xóa.',icon:'warning',showCancelButton:true,confirmButtonText:'Xóa',cancelButtonText:'Hủy'}).then(function(result){
			if(!result.isConfirmed)return;
			fetch('<?php echo XC_URL; ?>/api/deleteBookingInternal',{method:'POST',headers:{'Content-Type':'application/x-www-form-urlencoded'},body:'id='+encodeURIComponent(id)})
			.then(response=>response.json()).then(function(data){
				if(data.status===200){document.getElementById('booking-row-'+id).remove();Swal.fire({icon:'success',title:data.message,timer:1500,showConfirmButton:false})}
				else Swal.fire({icon:'error',title:'Lỗi',text:data.message});
			}).catch(()=>Swal.fire({icon:'error',title:'Lỗi',text:'Không thể kết nối máy chủ.'}));
		});
	});
});
</script>
<?php include_once "footer.php"; ?>
