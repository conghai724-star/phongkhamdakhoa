<!DOCTYPE html>
<html lang="vi">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Đặt thuốc nội bộ</title>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
	<style>
		:root{--blue:#1760a5;--orange:#e36928;--bg:#f4f7f9}
		*{box-sizing:border-box} body{font-family:Segoe UI,Tahoma,sans-serif;background:var(--bg);margin:0;padding:20px;color:#333}
		.container{max-width:900px;margin:auto;background:#fff;padding:30px;border-radius:9px;box-shadow:0 4px 15px #0002;border-top:6px solid var(--blue)}
		h1,h3{text-align:center;text-transform:uppercase} h1{color:var(--blue);font-size:23px;margin:0 0 10px} h3{color:var(--orange);font-size:15px;margin:0 0 25px}
		.section-title{background:var(--blue);color:#fff;padding:11px 15px;margin:25px 0 15px;border-radius:4px;font-weight:700}.section-title i{margin-right:8px}
		.form-group{margin-bottom:15px;position:relative} label{display:block;margin-bottom:6px;font-weight:600}
		input[type=text],input[type=tel],select,textarea,input[type=file]{width:100%;padding:11px;border:1px solid #ccc;border-radius:4px;font-size:14px}
		input:focus,select:focus,textarea:focus{border-color:var(--orange);outline:none;box-shadow:0 0 0 3px #e3692820}
		.radio-group{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:10px;background:#f8f8f8;padding:15px;border-radius:4px}.radio-group label{font-weight:400;margin:0}
		.grid-3{display:grid;grid-template-columns:2fr 1fr 1fr;gap:10px}.product-card{border:2px dashed #ddd;padding:15px;border-radius:5px}
		button{cursor:pointer}.btn-add,.btn-submit{border:0;color:#fff;border-radius:4px;font-weight:700}.btn-add{background:var(--blue);padding:11px 18px}.btn-submit{background:var(--orange);padding:15px;width:100%;font-size:16px;margin-top:25px}.btn-submit:disabled{opacity:.6;cursor:not-allowed}
		table{width:100%;border-collapse:collapse;margin-top:10px}th,td{padding:11px;border:1px solid #ddd;text-align:left}th{background:#f2f2f2;color:var(--blue)}.table-wrap{overflow-x:auto}
		.autocomplete{display:none;position:absolute;z-index:10;background:#fff;border:1px solid #ddd;width:100%;max-height:220px;overflow:auto;box-shadow:0 4px 8px #0002}.suggestion{padding:9px;cursor:pointer;border-bottom:1px solid #eee}.suggestion:hover{background:#f2f6fa}
		#other-time-wrap{display:none}.message{display:none;padding:12px;margin-top:15px;border-radius:4px}.message.success{display:block;background:#dff5e5;color:#176b30}.message.error{display:block;background:#fde4e4;color:#a51d1d}
		.note{font-size:13px;color:#666;font-style:italic}@media(max-width:650px){body{padding:8px}.container{padding:18px}.grid-3{grid-template-columns:1fr}}
	</style>
</head>
<body>
<div class="container">
	<h1>Phòng khám Đa khoa và Nhà thuốc Trường Cao đẳng Kon Tum</h1>
	<h3>Phiếu đăng ký nhu cầu mua thuốc và sản phẩm chăm sóc sức khỏe</h3>
	<form id="mainForm" enctype="multipart/form-data">
		<div class="section-title"><i class="fas fa-user-circle"></i> Phần 1: Thông tin người đặt mua</div>
		<div class="form-group"><label>Họ và tên *</label><input type="text" name="fullname" required maxlength="255"></div>
		<div class="form-group"><label>Bạn thuộc đối tượng nào?</label><div class="radio-group">
			<label><input type="radio" name="user_type" value="Viên chức"> Viên chức</label>
			<label><input type="radio" name="user_type" value="Người lao động"> Người lao động</label>
			<label><input type="radio" name="user_type" value="Học sinh/Sinh viên"> Học sinh/Sinh viên</label>
			<label><input type="radio" name="user_type" value="Người thân"> Người thân VC-NLĐ-HSSV</label>
			<label><input type="radio" name="user_type" value="Khách hàng khác"> Khách hàng khác</label>
		</div></div>
		<div class="form-group"><label>Đơn vị / Lớp / Bộ phận công tác</label><input type="text" name="department" maxlength="255"></div>
		<div class="form-group"><label>Số điện thoại liên hệ *</label><input type="tel" name="phone" required maxlength="30"></div>

		<div class="section-title"><i class="fas fa-map-marker-alt"></i> Phần 2: Thông tin giao hàng</div>
		<div class="form-group"><label>Hình thức nhận hàng</label><div class="radio-group">
			<label><input type="radio" name="ship_method" value="Nhận tại Nhà thuốc"> Nhận tại Nhà thuốc</label>
			<label><input type="radio" name="ship_method" value="Giao tại cơ quan/trường"> Giao tại cơ quan/trường</label>
			<label><input type="radio" name="ship_method" value="Giao tận nhà"> Giao tận nhà</label>
		</div></div>
		<div class="form-group"><label>Địa chỉ nhận hàng</label><textarea name="address" rows="2"></textarea></div>
		<div class="form-group"><label>Thời gian mong muốn nhận hàng</label><select name="receive_time" id="receiveTime">
			<option value="Trong ngày">Trong ngày</option><option value="Trong 24 giờ">Trong 24 giờ</option><option value="Thời gian khác">Thời gian khác</option>
		</select></div>
		<div class="form-group" id="other-time-wrap"><label>Thời gian cụ thể *</label><input type="text" id="otherTime" maxlength="255" placeholder="Ví dụ: Sáng thứ 2, sau 17h..."></div>

		<div class="section-title"><i class="fas fa-shopping-cart"></i> Phần 3: Sản phẩm cần mua</div>
		<div class="product-card">
			<div class="grid-3">
				<div class="form-group"><label>Tên thuốc/sản phẩm *</label><input type="text" id="pName" autocomplete="off"><div id="suggestions" class="autocomplete"></div></div>
				<div class="form-group"><label>Hàm lượng</label><input type="text" id="pSpec"></div>
				<div class="form-group"><label>Số lượng *</label><input type="text" id="pQty" placeholder="1 vỉ/hộp"></div>
			</div>
			<div class="form-group"><label>Ghi chú sản phẩm</label><input type="text" id="pNote"></div>
			<button type="button" class="btn-add" id="addItem"><i class="fas fa-plus-circle"></i> Thêm thuốc</button>
		</div>
		<div class="table-wrap"><table><thead><tr><th>Tên sản phẩm</th><th>Hàm lượng</th><th>Số lượng</th><th>Ghi chú</th><th></th></tr></thead><tbody id="listBody"><tr id="emptyRow"><td colspan="5" style="text-align:center;color:#888">Chưa có sản phẩm nào.</td></tr></tbody></table></div>

		<div class="section-title"><i class="fas fa-file-medical"></i> Phần 4: Tải lên đơn thuốc</div>
		<div class="form-group"><label>Ảnh/PDF đơn thuốc (nếu có, tối đa 5MB)</label><input type="file" name="prescription_file" accept="image/jpeg,image/png,image/webp,.pdf"><p class="note">Vui lòng chụp rõ đơn thuốc để Nhà thuốc tư vấn chính xác.</p></div>
		<div class="section-title"><i class="fas fa-wallet"></i> Phần 5: Thanh toán</div>
		<div class="radio-group"><label><input type="radio" name="payment_method" value="COD"> Thanh toán khi nhận hàng</label><label><input type="radio" name="payment_method" value="Tại Nhà thuốc"> Tại Nhà thuốc</label></div>
		<div class="section-title"><i class="fas fa-edit"></i> Phần 6: Ghi chú thêm</div>
		<div class="form-group"><textarea name="extra_note" rows="3"></textarea></div>
		<label><input type="checkbox" required> Tôi xác nhận các thông tin trên là chính xác.</label>
		<div id="message" class="message"></div>
		<button type="submit" class="btn-submit" id="submitButton">Gửi phiếu đăng ký</button>
	</form>
</div>
<?php
// $medicineData = array();
// foreach($products as $item){
// 	$medicineData[] = array('name' => $item->product_name, 'spec' => isset($item->product_spec) ? $item->product_spec : '');
// }
?>
<script>
const medicineData = <?php echo json_encode($medicineData, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
const items = [];
const form = document.getElementById('mainForm'), listBody = document.getElementById('listBody');
const pName = document.getElementById('pName'), pSpec = document.getElementById('pSpec'), suggestions = document.getElementById('suggestions');
const escapeHtml = value => String(value).replace(/[&<>"']/g, char => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[char]));
function renderItems(){
	if(!items.length){listBody.innerHTML='<tr id="emptyRow"><td colspan="5" style="text-align:center;color:#888">Chưa có sản phẩm nào.</td></tr>';return}
	listBody.innerHTML=items.map((item,index)=>`<tr><td>${escapeHtml(item.name)}</td><td>${escapeHtml(item.spec)}</td><td>${escapeHtml(item.qty)}</td><td>${escapeHtml(item.note)}</td><td><button type="button" data-index="${index}" class="remove-item" style="border:0;background:none;color:#c33"><i class="fas fa-trash"></i></button></td></tr>`).join('');
}
document.getElementById('addItem').addEventListener('click',function(){
	const item={name:pName.value.trim(),spec:pSpec.value.trim(),qty:document.getElementById('pQty').value.trim(),note:document.getElementById('pNote').value.trim()};
	if(!item.name||!item.qty){alert('Vui lòng nhập tên sản phẩm và số lượng.');return}
	items.push(item); renderItems(); ['pName','pSpec','pQty','pNote'].forEach(id=>document.getElementById(id).value=''); pName.focus();
});
listBody.addEventListener('click',event=>{const button=event.target.closest('.remove-item');if(button){items.splice(Number(button.dataset.index),1);renderItems()}});
pName.addEventListener('input',function(){
	const value=this.value.trim().toLowerCase(); suggestions.innerHTML='';
	if(!value){suggestions.style.display='none';return}
	medicineData.filter(item=>String(item.name).toLowerCase().includes(value)).slice(0,20).forEach(item=>{
		const div=document.createElement('div');div.className='suggestion';div.textContent=item.name+(item.spec?' - '+item.spec:'');
		div.addEventListener('click',()=>{pName.value=item.name;pSpec.value=item.spec;suggestions.style.display='none'});suggestions.appendChild(div);
	}); suggestions.style.display=suggestions.children.length?'block':'none';
});
document.addEventListener('click',event=>{if(!event.target.closest('.form-group'))suggestions.style.display='none'});
document.getElementById('receiveTime').addEventListener('change',function(){
	const custom=this.value==='Thời gian khác';document.getElementById('other-time-wrap').style.display=custom?'block':'none';document.getElementById('otherTime').required=custom;
});
form.addEventListener('submit',async function(event){
	event.preventDefault(); if(!items.length){alert('Vui lòng thêm ít nhất một thuốc hoặc sản phẩm.');return}
	const data=new FormData(form); if(data.get('receive_time')==='Thời gian khác')data.set('receive_time',document.getElementById('otherTime').value.trim()); data.append('medicines',JSON.stringify(items));
	const button=document.getElementById('submitButton'),message=document.getElementById('message');button.disabled=true;button.textContent='Đang gửi...';message.className='message';
	try{const response=await fetch('<?php echo XC_URL; ?>/api/addBookingInternal',{method:'POST',body:data});const result=await response.json();message.textContent=result.message;message.className='message '+(result.status===200?'success':'error');if(result.status===200){form.reset();items.length=0;renderItems();document.getElementById('other-time-wrap').style.display='none';window.scrollTo({top:0,behavior:'smooth'})}}
	catch(error){message.textContent='Không thể kết nối máy chủ. Vui lòng thử lại.';message.className='message error'}
	finally{button.disabled=false;button.textContent='Gửi phiếu đăng ký'}
});
</script>
</body>
</html>
