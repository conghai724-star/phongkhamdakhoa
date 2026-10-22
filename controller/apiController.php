<?php
/**
 * Project: thuvien.
 * File: tourController.php.
 * Author: Ken Zaki
 * Email: kenzaki@xiao.vn
 * Create Date: 09:54 - 07/10/2016
 * Website: www.xiao.vn
 */
Class apiController extends baseController
{ 
    public function index()
    {
		
    }
	public function getbalance()
	{
		$result = array();
		$result["status"] = 200;
		$result["balance"] = "20.000.000";
		echo json_encode($result);
	}
	public function applogin()
	{
		$result = array();
		$result["status"] = 200;
		$result["email"] = $_POST['email'];
		$result["fullname"] = "Sang Test";
		$result["uid"] = 1;
		$result["token"] = "21231231238821";
		echo json_encode($result);
	}
	//======================== user =================================//
	public function adduser(){
		global $db;
		
		$user_fullname = $_POST['user_fullname'];
		$user_email = $db->escapestring($_POST['user_email']);
		$user_phone = $_POST['user_phone'];
		$user_address = $_POST['user_address'];
		$user_username = $db->escapestring($_POST['user_username']);
		$user_password = md5($db->escapestring($_POST['user_password']));
		// $user_password_confirm = md5($db->escapestring($_POST['user_password_confirm']));	
		$user_avatar = $_POST['user_avatar'];
		$user_group = $_POST['user_group'];
		$user_dept = $_POST['user_dept'];
		$user_status = 1;
		$user_commission = 0.00;
		$user_basic_salary = 0.00;
		$user_register_time = date("Y-m-d H:i:s");
		$result = array();
		// echo $user_fullname . 'aeqwe';
		$error = '';
			$db->query("SELECT * FROM hicrm_users WHERE user_email = '".$user_email."' ");
			$queryEmail = $db->fetch_object(true);
			if($db->num_row($queryEmail)){
				$error .= "Email đã tồn tại!"; 
				
			}
			$db->query("SELECT * FROM hicrm_users WHERE user_phone = '".$user_phone."' ");
			$queryPhone = $db->fetch_object(true);
			if($db->num_row($queryPhone)){
				$error .= "Số điện thoại đã tồn tại!"; 
				
			}
			$db->query("SELECT * FROM hicrm_users WHERE user_username = '".$user_username."' ");
			$queryUsername = $db->fetch_object(true);
			if($db->num_row($queryUsername)){
				$error .= "Tên đăng nhập đã tồn tại!"; 
				
			}
			// if($user_password != $user_password_confirm){
			// 	$result['status'] = 500;
			// 	$result['message'] = "Mật khẩu không trùng khớp!"; 
				
			// }elseif(isset($error) && $error != ''){
			// 	$result['status'] = 500;
			// 	$result['message'] = $error; 
			// }else{
			// $db->query("INSERT INTO hicrm_users(user_username, user_password, user_email, user_fullname, user_phone, user_group, user_dept, user_address, user_avatar, user_status, user_commission, user_basic_salary, user_register_time) VALUES ('".$user_username."','".$user_password."','".$user_email."','".$user_fullname."','".$user_phone."','".$user_group."','".$user_dept."','".$user_address."','".$user_avatar."','".$user_status."','".$user_commission."','".$user_basic_salary."','".$user_register_time."') "); 
			// $result['status'] = 200;
			// }
			$db->query("INSERT INTO hicrm_users(user_username, user_password, user_email, user_fullname, user_phone, user_group, user_dept, user_address, user_avatar, user_status, user_commission, user_basic_salary, user_register_time) VALUES ('".$user_username."','".$user_password."','".$user_email."','".$user_fullname."','".$user_phone."','".$user_group."','".$user_dept."','".$user_address."','".$user_avatar."','".$user_status."','".$user_commission."','".$user_basic_salary."','".$user_register_time."') "); 
			$result['status'] = 200;
		
		echo json_encode($result);
		
	}
	////Update user
	public function updateUser(){
		
		$id = $_POST['userid'];
		$user_fullname = $_POST['user_fullname'];
		$user_address = $_POST['user_address']; 
		$user_phone = $_POST['user_phone']; 
		$user_email = $_POST['user_email']; 
		$user_dept = $_POST['user_dept']; 
		$user_group = $_POST['user_group']; 
		$user_username = $_POST['user_username']; 
		$user_dept = $_POST['user_dept'];
		global $db;
		$result = array();
		if(!empty($user_username)) {
			$db->query("UPDATE hicrm_users SET user_username='".$user_username."' where id = '".$id."'");
		}
		if(!empty($user_fullname)) {
			$db->query("UPDATE hicrm_users SET user_fullname='".$user_fullname."' where id = '".$id."'");
		}
		if(!empty($user_address)) {
			$db->query("UPDATE hicrm_users SET user_address='".$user_address."' where id = '".$id."'");
		}
		if(!empty($user_phone)) {
			$db->query("UPDATE hicrm_users SET user_phone='".$user_phone."' where id = '".$id."'");
		}
		if(!empty($user_email)) {
			$db->query("UPDATE hicrm_users SET user_email='".$user_email."' where id = '".$id."'");
		}
		if(!empty($user_dept)) {
			$db->query("UPDATE hicrm_users SET user_dept='".$user_dept."' where id = '".$id."'");
		}
		if(!empty($user_group)) {
			$db->query("UPDATE hicrm_users SET user_group='".$user_group."' where id = '".$id."'");
		}
		$result['status'] = 200;
		echo json_encode($result);
		
	}
	public function addtypedm(){
		global $db;
	
		$type_name = $_POST['type_name'];
		$type_detail = $_POST['type_detail'];
		$type_status = '1';
		$db->query("INSERT INTO hicrm_type(type_name, type_detail,type_status) VALUES ('".$type_name."','".$type_detail."','".$type_status."') "); 
		$result['status'] = 200;
		
		echo json_encode($result);
		
	}
	public function deleteDmtype(){
		global $db;
		$result = array();
		$db->query("SELECT * FROM hicrm_type WHERE id = '".$_POST['id']."'");
		if($db->num_row())
		{
			$db->query("UPDATE hicrm_type SET type_status = '99' WHERE id = '".$_POST['id']."'");
			$result["status"] = 200;
		}
		else
		{
			$result["status"] = 500;
			$result["message"] = "Tài khoản không tồn tại";
		}
		echo json_encode($result);
	}
	public function addImage(){
		global $db;
		$image_name = $_POST['image_name'];
		$image_user_created = $_POST['image_usercreate'];
		$image_created_date = date('Y-m-d H:i:s');
		$image_status = 1;
		$result = array();
		$FinalFilenameFront = "";
		$FinalFilenameFront2 = "";
		$expensions = array("jpeg","jpg","png");
		// echo $_FILES['employee_image']['name'];
		// echo $_FILES['image_file']['size']."ssss";
		if(isset($_FILES['image_file']))
			{
				$errors= array();
				$file_name = $_FILES['image_file']['name'];
				$file_size =$_FILES['image_file']['size'];
				$file_tmp =$_FILES['image_file']['tmp_name'];
				$file_type=$_FILES['image_file']['type'];
				$file_ext=strtolower(end(explode('.',$_FILES['image_file']['name'])));
				$OriginalFilename = $FinalFilename = preg_replace('`[^a-z0-9-_.]`i','',$_FILES['image_file']['name']); 
				$FinalFilenameFront = md5(time())."-".$FinalFilename;
				if(in_array($file_ext,$expensions)=== false){
					$errors[]="Extension not allowed, please choose a .png, .jpg file.";
				}
				if($file_size > 5242880){
					$errors[]='File size must be max 2Mb';
				}
				
				if(empty($errors)==true){
					move_uploaded_file($file_tmp,"./uploads/images/".$FinalFilenameFront);
					
				}else
				{
					$result["status"] = 500;
				}
				
			}
		$db->query("INSERT INTO hicrm_images (image_name, image_url, image_user_created, image_created_date, image_status) VALUES('".$image_name."','".$FinalFilenameFront."','".$image_user_created."','".$image_created_date."','".$image_status."')");
		
		$result['status'] = 200;
		$result["url"] = XC_URL."/uploads/images/".$FinalFilenameFront;
		$result["id"] = $FinalFilenameFront;
		echo json_encode($result);

	}

	public function deleteImage(){
		global $db;
		$iid = $_POST['iid'];
		$result = array();
		$db->query("SELECT * FROM hicrm_images WHERE id = '".$iid."'");
		$db->fetch_object(true);
		if($db->num_row()){
			$db->query("UPDATE hicrm_images SET image_status = 99 WHERE id = '".$iid."'");
			
			$result["status"] = 200;
		}else{
			$result['message'] = "Không tìm thấy nhân viên này";
			$result["status"] = 500;
		}
		
		echo json_encode($result);
	}
    public function load_work_schedule(){
		global $db;
		$id = $_POST['id'];
		$db->query("SELECT * FROM hicrm_calendar_works WHERE id = '".$id."'");
		$work = $db->fetch_object(true);

		$result['src'] = XC_URL ."/uploads/files/".$work->calendar_work_file;
		$result['status'] = 200;
		echo json_encode($result);
	}
	public function updateIntroduce(){
		global $db;
		$result = array();
		$id = $_POST['type_id'];

		$page_content = $db->escapestring($_POST['content']);
		// var_dump($page_content);
		$page_uid = $_POST['userid'];
		$page_status = 1;
		$page_created_date = date('Y-m-d H:i:s');
		// echo "UPDATE hicrm_introduce SET introduce_id_type ='".$id."',introduce_content='".$page_content."',introduce_uid = '".$page_uid."',introduce_created_date='".$page_created_date."' WHERE introduce_id_type ='".$id."'";
		$db->query("UPDATE hicrm_introduce SET introduce_content='".$page_content."',introduce_uid = '".$page_uid."',introduce_created_date='".$page_created_date."' WHERE id = '".$id."'");
		
		$result['message'] = "Thành công";
		$result['status'] = 200;
		
		echo json_encode($result);
	}
	public function loadIntroduce(){
		global $db;
		$id = $_POST['id'];
		$db->query("SELECT *, i.id as id FROM hicrm_introduce as i
					LEFT JOIN hicrm_type as t ON i.introduce_id_type = t.id WHERE i.introduce_id_type= '".$id."'");
		$introduce = $db->fetch_object(true);
		$result['title'] = $introduce->type_name;
		$result['content'] = $introduce->introduce_content;
		$result['status'] = 200;
		echo json_encode($result);

	}
	
	public function calendarEmployee(){
		global $db;
		$result = array();
		$id = $_POST['eid'];
		// echo $id;
		$employee_calendar = $_POST['employee_calendar'];
		$employee_shift = $_POST['employee_shift'];
		$db->query("SELECT * FROM hicrm_employees WHERE id = '".$id."'");
		$db->fetch_object(true);
		if($db->num_row()){
				$db->query("UPDATE hicrm_employees SET employee_calendar='".$employee_calendar."',employee_shift='".$employee_shift."' WHERE id = '".$id."' ");
				$result['message'] = "Sửa thành công";
				$result['status'] = 200;
			
		}else{
			$result['message'] = "Thất bại";
			$result['status'] = 500;
		}
		echo json_encode($result);

	}
	public function addBooking(){
		global $db;
		$result = array();
		
		$db->query("INSERT INTO 
		hicrm_bookings(booking_person_name, booking_person_gender, booking_person_year, booking_person_address, booking_person_phone, booking_doctor, booking_date, booking_hour, booking_description, booking_created_date)
		VALUES ('".$_POST['booking_person_name']."','".$_POST['booking_person_gender']."','".$_POST['booking_person_year']."','".$_POST['booking_person_address']."','".$_POST['booking_person_phone']."',
		'".$_POST['booking_doctor']."','".$_POST['booking_date']."','".$_POST['booking_hour']."','".$_POST['booking_description']."', '".date("Y-m-d H:i:s")."')");
		
		$result['status'] = 200;
		$result['message'] = "Bộ phận tiếp nhận sẽ sớm liên hệ để xác nhận lịch hẹn.";
		echo json_encode($result);
	}
	private function ensureBookingInternalTable(){
		global $db;
		$db->query("CREATE TABLE IF NOT EXISTS booking_internal (
			id INT UNSIGNED NOT NULL AUTO_INCREMENT,
			fullname VARCHAR(255) NOT NULL,
			user_type VARCHAR(100) DEFAULT NULL,
			department VARCHAR(255) DEFAULT NULL,
			phone VARCHAR(30) NOT NULL,
			ship_method VARCHAR(100) DEFAULT NULL,
			address TEXT,
			receive_time VARCHAR(255) DEFAULT NULL,
			medicines LONGTEXT NOT NULL,
			prescription_file VARCHAR(255) DEFAULT NULL,
			payment_method VARCHAR(50) DEFAULT NULL,
			extra_note TEXT,
			created_at DATETIME NOT NULL,
			PRIMARY KEY (id),
			KEY idx_booking_internal_created_at (created_at),
			KEY idx_booking_internal_fullname (fullname)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
	}
	private function respondJson($result){
		$result['success'] = isset($result['status']) && $result['status'] === 200;
		if(isset($result['cart_count']) && $this->helper->is_cart_enabled()){
			$cart = $this->helper->get_cart_items();
			$items = array();
			$count = 0;
			foreach($this->getCartProducts() as $product){
				$quantity = (int)$cart[$product->pid];
				$price = max(0, (float)$product->product_price);
				$discount = min(100, max(0, (int)$product->product_discount));
				$finalPrice = $discount > 0 ? ($price * (100 - $discount) / 100) : $price;
				$lineTotal = $finalPrice * $quantity;
				$subtotal = isset($subtotal) ? $subtotal + $lineTotal : $lineTotal;
				$items[] = array('id' => (int)$product->pid, 'name' => $product->product_name,
					'image' => !empty($product->product_image) ? XC_URL.'/uploads/products/'.rawurlencode($product->product_image) : XC_URL.'/template/page/assets/images/logo.png',
					'price' => $finalPrice, 'original_price' => $price,
					'quantity' => $quantity, 'line_total' => $lineTotal,
					'unit' => isset($product->unit_name) ? $product->unit_name : '',
					'spec' => isset($product->product_spec) ? $product->product_spec : '',
					'url' => $this->helper->permalink($product->pid, 'product_detail'));
				$count += $quantity;
			}
			$result['cart_count'] = $count;
			$result['data'] = array(
				'items' => $items,
				'subtotal' => isset($subtotal) ? $subtotal : 0,
				'formatted_subtotal' => number_format(isset($subtotal) ? $subtotal : 0, 0, ',', '.') . 'đ'
			);
		}
		if(ob_get_length()) ob_clean();
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($result, JSON_UNESCAPED_UNICODE);
	}
	private function getCartProducts(){
		global $db;
		$cart = $this->helper->get_cart_items();
		$productIds = array();
		foreach($cart as $productId => $quantity){
			$productId = (int)$productId;
			if($productId > 0 && (int)$quantity > 0){
				$productIds[] = $productId;
			}
		}
		if(empty($productIds)){
			return array();
		}
		$db->query("SELECT *, p.id as pid FROM hicrm_products as p
			LEFT JOIN hicrm_units u ON p.product_unit = u.id
			WHERE p.id IN(".implode(',', $productIds).") AND p.product_status NOT IN (99)");
		$products = $db->fetch_object();
		return is_array($products) ? $products : array();
	}
	private function validateCartRequest(){
		$token = isset($_SERVER['HTTP_X_CART_CSRF']) ? $_SERVER['HTTP_X_CART_CSRF'] : '';
		if($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SESSION['cart_csrf']) || !hash_equals($_SESSION['cart_csrf'], $token)){
			$this->respondJson(array('status' => 403, 'message' => 'Phiên giỏ hàng đã hết hạn. Vui lòng tải lại trang và thử lại.'));
			return false;
		}
		return true;
	}
	public function cartSummary(){
		if(!$this->helper->is_cart_enabled()){
			$this->respondJson(array('status' => 403, 'message' => 'Chức năng giỏ hàng đang tắt.'));
			return;
		}
		$this->respondJson(array('status' => 200, 'message' => 'Đã tải giỏ hàng.', 'cart_count' => 0));
	}
	public function administrativeUnits(){
		global $db;
		$level = isset($_GET['level']) ? trim($_GET['level']) : 'province';
		$data = array();

		if($level === 'province'){
			$db->query("SELECT province_code AS code, province_full_name AS name
				FROM hicrm_administrative_units
				GROUP BY province_code, province_full_name
				ORDER BY province_code ASC");
			$rows = $db->fetch_object();
		} elseif($level === 'ward'){
			$provinceCode = isset($_GET['province_code']) ? trim($_GET['province_code']) : '';
			if(!preg_match('/^[0-9]{2}$/', $provinceCode)){
				$this->respondJson(array('status' => 422, 'message' => 'Vui lòng chọn tỉnh/thành phố hợp lệ.'));
				return;
			}
			$db->query("SELECT ward_code AS code, ward_full_name AS name
				FROM hicrm_administrative_units
				WHERE province_code = '".$db->escapestring($provinceCode)."'
				ORDER BY ward_name ASC, ward_code ASC");
			$rows = $db->fetch_object();
		} else {
			$this->respondJson(array('status' => 422, 'message' => 'Cấp hành chính không hợp lệ.'));
			return;
		}

		if(is_array($rows)){
			foreach($rows as $row){
				$data[] = array('code' => (string)$row->code, 'name' => (string)$row->name);
			}
		}
		$this->respondJson(array('status' => 200, 'message' => 'Đã tải danh mục hành chính.', 'data' => $data));
	}
	public function cartAdd(){
		if(!$this->helper->is_cart_enabled()){
			$this->respondJson(array('status' => 403, 'message' => 'Chức năng giỏ hàng đang tắt.'));
			return;
		}
		if(!$this->validateCartRequest()) return;
		global $db;
		$productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
		$quantity = isset($_POST['quantity']) ? max(1, (int)$_POST['quantity']) : 1;
		$db->query("SELECT id, product_name FROM hicrm_products WHERE id = '".$productId."' AND product_status NOT IN (99) LIMIT 1");
		$product = $db->fetch_object(true);
		if(!$product){
			$this->respondJson(array('status' => 404, 'message' => 'Không tìm thấy sản phẩm.'));
			return;
		}
		$currentCart = $this->helper->get_cart_items();
		$currentQty = isset($currentCart[$productId]) ? (int)$currentCart[$productId] : 0;
		$this->helper->set_cart_quantity($productId, $currentQty + $quantity);
		$this->respondJson(array(
			'status' => 200,
			'message' => 'Đã thêm vào giỏ hàng.',
			'cart_count' => $this->helper->get_cart_count()
		));
	}
	public function cartUpdate(){
		if(!$this->helper->is_cart_enabled()){
			$this->respondJson(array('status' => 403, 'message' => 'Chức năng giỏ hàng đang tắt.'));
			return;
		}
		if(!$this->validateCartRequest()) return;
		global $db;
		$productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
		$quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;
		if($productId < 1 || $quantity < 1 || $quantity > 99){
			$this->respondJson(array('status' => 422, 'message' => 'Số lượng sản phẩm phải từ 1 đến 99.'));
			return;
		}
		$db->query("SELECT id FROM hicrm_products WHERE id = '".$productId."' AND product_status NOT IN (99) LIMIT 1");
		if(!$db->num_row()){
			$this->respondJson(array('status' => 404, 'message' => 'Sản phẩm không còn khả dụng.'));
			return;
		}
		$this->helper->set_cart_quantity($productId, $quantity);
		$this->respondJson(array(
			'status' => 200,
			'message' => 'Đã cập nhật giỏ hàng.',
			'cart_count' => $this->helper->get_cart_count()
		));
	}
	public function cartRemove(){
		if(!$this->helper->is_cart_enabled()){
			$this->respondJson(array('status' => 403, 'message' => 'Chức năng giỏ hàng đang tắt.'));
			return;
		}
		if(!$this->validateCartRequest()) return;
		$productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
		if($productId < 1){
			$this->respondJson(array('status' => 422, 'message' => 'Sản phẩm cần xóa không hợp lệ.'));
			return;
		}
		$this->helper->set_cart_quantity($productId, 0);
		$this->respondJson(array(
			'status' => 200,
			'message' => 'Đã xóa sản phẩm khỏi giỏ hàng.',
			'cart_count' => $this->helper->get_cart_count()
		));
	}
	public function cartClear(){
		if(!$this->helper->is_cart_enabled()){
			$this->respondJson(array('status' => 403, 'message' => 'Chức năng giỏ hàng đang tắt.'));
			return;
		}
		if(!$this->validateCartRequest()) return;
		$this->helper->clear_cart();
		$this->respondJson(array(
			'status' => 200,
			'message' => 'Đã xóa toàn bộ giỏ hàng.',
			'cart_count' => 0
		));
	}
	public function cartCheckout(){
		global $db;
		if(!$this->helper->is_cart_enabled()){
			$this->respondJson(array('status' => 403, 'message' => 'Chức năng giỏ hàng đang tắt.'));
			return;
		}
		if(!$this->validateCartRequest()) return;
		$fullname = trim(isset($_POST['fullname']) ? $_POST['fullname'] : '');
		$phone = preg_replace('/[\s\.\-]/', '', trim(isset($_POST['phone']) ? $_POST['phone'] : ''));
		$email = trim(isset($_POST['email']) ? $_POST['email'] : '');
		if(mb_strlen($fullname) < 2 || mb_strlen($fullname) > 255){
			$this->respondJson(array('status' => 422, 'message' => 'Họ tên phải có từ 2 đến 255 ký tự.'));
			return;
		}
		if(!preg_match('/^(0|\+84)[0-9]{9,10}$/', $phone)){
			$this->respondJson(array('status' => 422, 'message' => 'Số điện thoại không đúng định dạng.'));
			return;
		}
		if($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)){
			$this->respondJson(array('status' => 422, 'message' => 'Email nhận thông báo không đúng định dạng.'));
			return;
		}
		$products = $this->getCartProducts();
		if(empty($products)){
			$this->respondJson(array('status' => 422, 'message' => 'Giỏ hàng đang trống.'));
			return;
		}
		$cart = $this->helper->get_cart_items();
		$cleanMedicines = array();
		$subtotal = 0;
		foreach($products as $product){
			$quantity = isset($cart[$product->pid]) ? max(1, (int)$cart[$product->pid]) : 1;
			$price = (float)$product->product_price;
			$discount = max(0, (int)$product->product_discount);
			$finalPrice = $discount > 0 ? ($price * (100 - $discount) / 100) : $price;
			$lineTotal = $finalPrice * $quantity;
			$subtotal += $lineTotal;
			$noteParts = array();
			if(!empty($product->unit_name)){
				$noteParts[] = 'DVT: '.$product->unit_name;
			}
			$noteParts[] = 'Don gia: '.number_format($finalPrice, 0, ',', '.').'d';
			$noteParts[] = 'Thanh tien: '.number_format($lineTotal, 0, ',', '.').'d';
			$cleanMedicines[] = array(
				'name' => mb_substr($product->product_name, 0, 255),
				'spec' => mb_substr(isset($product->product_spec) ? $product->product_spec : '', 0, 255),
				'qty' => (string)$quantity,
				'note' => implode(' | ', $noteParts)
			);
		}
		$this->ensureBookingInternalTable();
		$shipMethod = trim(isset($_POST['ship_method']) ? $_POST['ship_method'] : 'Nhận tại Nhà thuốc');
		$allowedShipMethods = array('Nhận tại Nhà thuốc', 'Giao hàng tận nơi');
		if(!in_array($shipMethod, $allowedShipMethods, true)){
			$this->respondJson(array('status' => 422, 'message' => 'Hình thức nhận hàng không hợp lệ.'));
			return;
		}
		$paymentMethod = $shipMethod === 'Nhận tại Nhà thuốc' ? 'Tại Nhà thuốc' : 'Thanh toán khi nhận hàng';
		$address = trim(isset($_POST['address']) ? $_POST['address'] : '');
		if($shipMethod === 'Giao hàng tận nơi' && (mb_strlen($address) < 5 || mb_strlen($address) > 500)){
			$this->respondJson(array('status' => 422, 'message' => 'Vui lòng nhập địa chỉ giao thuốc đầy đủ.'));
			return;
		}
		$extraNote = trim(isset($_POST['extra_note']) ? $_POST['extra_note'] : '');
		if(mb_strlen($extraNote) > 1000){
			$this->respondJson(array('status' => 422, 'message' => 'Ghi chú không được vượt quá 1.000 ký tự.'));
			return;
		}

		$userId = isset($_SESSION['customer']['id']) ? max(0, (int)$_SESSION['customer']['id']) : (isset($_SESSION['user']['id']) ? max(0, (int)$_SESSION['user']['id']) : 0);
		$userPoints = 0;
		if($userId > 0){
			$db->query("SELECT loyalty_points, user_phone FROM hicrm_users WHERE id = '".$userId."' AND user_status = 1 LIMIT 1");
			$userRow = $db->fetch_object(true);
			if(!$userRow){
				$this->respondJson(array('status' => 403, 'message' => 'Tài khoản không còn khả dụng. Vui lòng đăng nhập lại.'));
				return;
			}
            if (!empty($_SESSION['customer']['id']) && !preg_match('/^0[35789][0-9]{8}$/D', (string)$userRow->user_phone)) {
                $this->respondJson(array('status' => 422, 'success' => false, 'message' => 'Vui lòng cập nhật số điện thoại tài khoản trước khi đặt hàng.', 'data' => array('url' => XC_URL.'/page/customerprofile')));
                return;
            }
			$userPoints = max(0, (int)$userRow->loyalty_points);
		}

		$voucherCode = strtoupper(trim(isset($_POST['voucher_code']) ? $_POST['voucher_code'] : ''));
		$voucherDiscount = 0;
		$voucher = null;
		if($voucherCode !== ''){
			if(!preg_match('/^[A-Z0-9_-]{2,50}$/', $voucherCode)){
				$this->respondJson(array('status' => 422, 'message' => 'Mã voucher không đúng định dạng.'));
				return;
			}
			$db->query("SELECT * FROM hicrm_vouchers WHERE code = '".$db->escapestring($voucherCode)."' AND is_active = 1
				AND (start_at IS NULL OR start_at <= NOW()) AND (end_at IS NULL OR end_at >= NOW()) LIMIT 1");
			$voucher = $db->fetch_object(true);
			if(!$voucher || ($voucher->usage_limit !== null && (int)$voucher->used_count >= (int)$voucher->usage_limit)){
				$this->respondJson(array('status' => 422, 'message' => 'Voucher không tồn tại, đã hết hạn hoặc đã hết lượt sử dụng.'));
				return;
			}
			if($subtotal < (float)$voucher->min_order_value){
				$this->respondJson(array('status' => 422, 'message' => 'Đơn hàng chưa đạt giá trị tối thiểu của voucher.'));
				return;
			}
			$identityCondition = $userId > 0 ? "user_id = '".$userId."'" : "user_id IS NULL AND phone = '".$db->escapestring($phone)."'";
			$db->query("SELECT COUNT(*) AS used_times FROM booking_internal WHERE voucher_code = '".$db->escapestring($voucherCode)."' AND ".$identityCondition);
			$usage = $db->fetch_object(true);
			if($usage && (int)$usage->used_times >= (int)$voucher->per_user_limit){
				$this->respondJson(array('status' => 422, 'message' => 'Bạn đã sử dụng hết số lượt cho voucher này.'));
				return;
			}
			if($voucher->discount_type === 'percent'){
				$voucherDiscount = $subtotal * max(0, min(100, (float)$voucher->discount_value)) / 100;
				if($voucher->max_discount !== null){
					$voucherDiscount = min($voucherDiscount, (float)$voucher->max_discount);
				}
			}else{
				$voucherDiscount = max(0, (float)$voucher->discount_value);
			}
			$voucherDiscount = min($subtotal, round($voucherDiscount));
		}

		$shippingFee = ($shipMethod === 'Giao hàng tận nơi' && $subtotal < 300000) ? 20000 : 0;
		$usePoints = isset($_POST['use_points']) && (string)$_POST['use_points'] === '1';
		$pointsUsed = 0;
		$pointsDiscount = 0;
		if($usePoints && $userId > 0 && $userPoints > 0){
			$maximumPointDiscount = max(0, $subtotal + $shippingFee - $voucherDiscount);
			$pointsUsed = min($userPoints, (int)floor($maximumPointDiscount / 1000));
			$pointsDiscount = $pointsUsed * 1000;
		}
		$totalAmount = max(0, $subtotal + $shippingFee - $voucherDiscount - $pointsDiscount);
		$pointsEarned = $userId > 0 ? (int)floor($totalAmount / 10000) : 0;

		$summaryLines = array();
		if($email !== '') $summaryLines[] = 'Email: '.$email;
		if($extraNote !== '') $summaryLines[] = $extraNote;
		$summaryLines[] = 'Tạm tính: '.number_format($subtotal, 0, ',', '.').'đ';
		$summaryLines[] = 'Phí giao hàng: '.number_format($shippingFee, 0, ',', '.').'đ';
		if($voucherCode !== '') $summaryLines[] = 'Voucher '.$voucherCode.': -'.number_format($voucherDiscount, 0, ',', '.').'đ';
		if($pointsUsed > 0) $summaryLines[] = 'Dùng '.$pointsUsed.' điểm: -'.number_format($pointsDiscount, 0, ',', '.').'đ';
		$summaryLines[] = 'Tổng thanh toán: '.number_format($totalAmount, 0, ',', '.').'đ';
		$extraNote = implode("\n", $summaryLines);
		$medicinesJson = $db->escapestring(json_encode($cleanMedicines, JSON_UNESCAPED_UNICODE));
		$db->query("START TRANSACTION");
		$db->query("INSERT INTO booking_internal
			(user_id, fullname, user_type, department, phone, ship_method, address, receive_time, medicines, prescription_file, payment_method, extra_note,
			subtotal, shipping_fee, voucher_code, voucher_discount, points_used, points_discount, total_amount, points_earned, created_at)
			VALUES (
				".($userId > 0 ? "'".$userId."'" : "NULL").", '".$db->escapestring($fullname)."', 'Khách mua thuốc online', '',
				'".$db->escapestring($phone)."', '".$db->escapestring($shipMethod)."', '".$db->escapestring($address)."',
				'', '".$medicinesJson."', '',
				'".$db->escapestring($paymentMethod)."', '".$db->escapestring($extraNote)."',
				'".(float)$subtotal."', '".(float)$shippingFee."', ".($voucherCode !== '' ? "'".$db->escapestring($voucherCode)."'" : "NULL").",
				'".(float)$voucherDiscount."', '".$pointsUsed."', '".(float)$pointsDiscount."', '".(float)$totalAmount."', '".$pointsEarned."', '".date('Y-m-d H:i:s')."'
			)");
		$db->query("SELECT LAST_INSERT_ID() AS order_id");
		$orderRow = $db->fetch_object(true);
		$orderId = $orderRow ? (int)$orderRow->order_id : 0;
		if($voucher){
			$db->query("UPDATE hicrm_vouchers SET used_count = used_count + 1 WHERE id = '".(int)$voucher->id."'");
		}
		$newPointBalance = $userPoints;
		if($userId > 0){
			$newPointBalance = max(0, $userPoints - $pointsUsed + $pointsEarned);
			$db->query("UPDATE hicrm_users SET loyalty_points = '".$newPointBalance."' WHERE id = '".$userId."' LIMIT 1");
		}
		$db->query("COMMIT");
		$this->helper->clear_cart();
		$this->respondJson(array(
			'status' => 200,
			'message' => 'Đã gửi đơn đặt thuốc thành công. Nhà thuốc sẽ liên hệ xác nhận.',
			'cart_count' => 0,
			'order' => array(
				'id' => $orderId,
				'total_amount' => $totalAmount,
				'points_used' => $pointsUsed,
				'points_earned' => $pointsEarned,
				'point_balance' => $newPointBalance
			)
		));
	}
	public function addBookingInternal(){
		global $db;
		if(ob_get_length()) ob_clean();
		header('Content-Type: application/json; charset=utf-8');
		$result = array('status' => 500, 'message' => 'Không thể gửi phiếu đặt thuốc.');
		$fullname = trim(isset($_POST['fullname']) ? $_POST['fullname'] : '');
		$phone = trim(isset($_POST['phone']) ? $_POST['phone'] : '');
		$medicines = json_decode(isset($_POST['medicines']) ? $_POST['medicines'] : '[]', true);

		if($fullname === '' || $phone === ''){
			$result['message'] = 'Vui lòng nhập họ tên và số điện thoại.';
			echo json_encode($result, JSON_UNESCAPED_UNICODE);
			return;
		}
		if(!is_array($medicines) || count($medicines) < 1){
			$result['message'] = 'Vui lòng thêm ít nhất một thuốc hoặc sản phẩm.';
			echo json_encode($result, JSON_UNESCAPED_UNICODE);
			return;
		}

		$cleanMedicines = array();
		foreach(array_slice($medicines, 0, 100) as $medicine){
			$name = trim(isset($medicine['name']) ? $medicine['name'] : '');
			$qty = trim(isset($medicine['qty']) ? $medicine['qty'] : '');
			if($name === '' || $qty === '') continue;
			$cleanMedicines[] = array(
				'name' => mb_substr($name, 0, 255),
				'spec' => mb_substr(trim(isset($medicine['spec']) ? $medicine['spec'] : ''), 0, 255),
				'qty' => mb_substr($qty, 0, 100),
				'note' => mb_substr(trim(isset($medicine['note']) ? $medicine['note'] : ''), 0, 500)
			);
		}
		if(count($cleanMedicines) < 1){
			$result['message'] = 'Danh sách thuốc không hợp lệ.';
			echo json_encode($result, JSON_UNESCAPED_UNICODE);
			return;
		}

		$prescriptionFile = '';
		if(isset($_FILES['prescription_file']) && $_FILES['prescription_file']['error'] !== UPLOAD_ERR_NO_FILE){
			if($_FILES['prescription_file']['error'] !== UPLOAD_ERR_OK || $_FILES['prescription_file']['size'] > 5242880){
				$result['message'] = 'Đơn thuốc tải lên không hợp lệ hoặc vượt quá 5MB.';
				echo json_encode($result, JSON_UNESCAPED_UNICODE);
				return;
			}
			$extension = strtolower(pathinfo($_FILES['prescription_file']['name'], PATHINFO_EXTENSION));
			if(!in_array($extension, array('jpg', 'jpeg', 'png', 'webp', 'pdf'))){
				$result['message'] = 'Chỉ chấp nhận ảnh JPG, PNG, WEBP hoặc file PDF.';
				echo json_encode($result, JSON_UNESCAPED_UNICODE);
				return;
			}
			$uploadDirectory = __SITE_PATH . '/uploads/booking_internal';
			if(!is_dir($uploadDirectory)) mkdir($uploadDirectory, 0755, true);
			$prescriptionFile = date('YmdHis') . '-' . bin2hex(random_bytes(6)) . '.' . $extension;
			if(!move_uploaded_file($_FILES['prescription_file']['tmp_name'], $uploadDirectory . '/' . $prescriptionFile)){
				$result['message'] = 'Không thể lưu file đơn thuốc.';
				echo json_encode($result, JSON_UNESCAPED_UNICODE);
				return;
			}
		}

		$this->ensureBookingInternalTable();
		$value = function($key) use ($db) {
			return $db->escapestring(trim(isset($_POST[$key]) ? $_POST[$key] : ''));
		};
		$medicinesJson = $db->escapestring(json_encode($cleanMedicines, JSON_UNESCAPED_UNICODE));
		$db->query("INSERT INTO booking_internal
			(fullname, user_type, department, phone, ship_method, address, receive_time, medicines, prescription_file, payment_method, extra_note, created_at)
			VALUES (
				'".$db->escapestring($fullname)."', '".$value('user_type')."', '".$value('department')."',
				'".$db->escapestring($phone)."', '".$value('ship_method')."', '".$value('address')."',
				'".$value('receive_time')."', '".$medicinesJson."', '".$db->escapestring($prescriptionFile)."',
				'".$value('payment_method')."', '".$value('extra_note')."', '".date('Y-m-d H:i:s')."'
			)");
		$result['status'] = 200;
		$result['message'] = 'Đã gửi phiếu đặt thuốc thành công. Nhà thuốc sẽ sớm liên hệ xác nhận.';
		echo json_encode($result, JSON_UNESCAPED_UNICODE);
	}
	public function deleteBookingInternal(){
		global $db;
		if(ob_get_length()) ob_clean();
		header('Content-Type: application/json; charset=utf-8');
		$result = array('status' => 500, 'message' => 'Không thể xóa phiếu đặt thuốc.');
		if(!(isset($_SESSION['user']['id']) && $_SESSION['user']['id'] != "")){
			$result['message'] = 'Phiên đăng nhập quản trị đã hết hạn.';
			echo json_encode($result, JSON_UNESCAPED_UNICODE);
			return;
		}
		$this->ensureBookingInternalTable();
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$db->query("SELECT prescription_file FROM booking_internal WHERE id = '".$id."' LIMIT 1");
		$booking = $db->fetch_object(true);
		if(!$booking){
			$result['message'] = 'Không tìm thấy phiếu đặt thuốc.';
			echo json_encode($result, JSON_UNESCAPED_UNICODE);
			return;
		}
		$db->query("DELETE FROM booking_internal WHERE id = '".$id."'");
		if(!empty($booking->prescription_file)){
			$filePath = __SITE_PATH . '/uploads/booking_internal/' . basename($booking->prescription_file);
			if(is_file($filePath)) unlink($filePath);
		}
		$result['status'] = 200;
		$result['message'] = 'Đã xóa phiếu đặt thuốc.';
		echo json_encode($result, JSON_UNESCAPED_UNICODE);
	}
	public function addFeedback(){
	    global $db;
		$result = array();
		$date = date("Y-m-d H:i:s");
		$rating = $_POST['rating'];
		$db->query("INSERT INTO hicrm_customer_feedback(customer_name, customer_phone, customer_email, customer_address, content, status, rating, create_date) VALUES ('".$_POST['customer_name']."','".$_POST['customer_phone']."','".$_POST['customer_email']."','".$_POST['customer_address']."','".$_POST['content']."','0','".$rating."','".$date."')");
		
		$result['status'] = 200;
		$result['message'] = "Cảm ơn Quý khách đã gửi phản hồi. Chúng tôi rất trân trọng ý kiến của bạn.";
		echo json_encode($result);
	}
	public function approveBooking()
	{
		global $db;
		// echo $_POST['bid'];
		$bid = $_POST['bid'];
		$result = array();
		$db->query("SELECT * FROM hicrm_bookings WHERE id = '".$_POST['bid']."'");
		$db->fetch_object(true);
		if($db->num_row()){
				$db->query("UPDATE hicrm_bookings SET booking_status='2' WHERE id = '".$bid."'");
				$result['message'] = "Duyệt thành công";
				$result['status'] = 200;
			
		}else{
			$result['message'] = "Không có dữ liệu";
			$result['status'] = 500;
		}

		echo json_encode($result);
	}
	//===== API NEWS === 
	public function news()
	{
		global $db;
		$new_name = $_POST['new_name'];
		$new_description = $_POST['new_description'];
		$new_content = $db->escapestring($_POST['new_content']);
		$new_user_created = $_POST['new_user_created'];
		$new_created_date = date('Y-m-d H:i:s');
		$FinalFilenameFront = "";
		$FinalFilenameFront2 = "";
		$expensions = array("jpeg","jpg","png");
		$method = $_POST['method'];
		$result = array();
		$id = $_POST['nid'];
		
		if(isset($method) && $method == "add")
		{
			$FinalFilenameFront = "";
			$FinalFilenameFront2 = "";
			//echo $_FILES['hinhanh']['name']."ssss";
			if ($_FILES['new_image']['error'] == 4) {
				// Không có file upload → gán hình mặc định
				$FinalFilenameFront = '';
			}else{
				$errors= array();
				$file_name = $_FILES['new_image']['name'];
				$file_size =$_FILES['new_image']['size'];
				$file_tmp =$_FILES['new_image']['tmp_name'];
				$file_type=$_FILES['new_image']['type'];
				$file_ext=strtolower(end(explode('.',$_FILES['new_image']['name'])));
				$OriginalFilename = $FinalFilename = preg_replace('`[^a-z0-9-_.]`i','',$_FILES['new_image']['name']); 
				$FinalFilenameFront = md5(time())."-".$FinalFilename;
				if(in_array($file_ext,$expensions)=== false){
					$errors[]="Extension not allowed, please choose a .png, .jpg file.";
				}
				if($file_size > 5242880){
					$errors[]='File size must be max 2Mb';
				}
				if(empty($errors)==true){
					move_uploaded_file($file_tmp,"./uploads/news/".$FinalFilenameFront);
					
				}else
				{
					$result["status"] = 500;
				}
				
			}
			$db->query("INSERT INTO hicrm_news(new_name,new_description,new_content,new_image,new_user_created,new_status,new_created_date)
			VALUES('".$_POST['new_name']."','".$_POST['new_description']."','".$new_content."','".$FinalFilenameFront."','".$new_user_created."',1,'".$new_created_date."')");
			$result["status"] = 200;
			$result["url"] = XC_URL."/uploads/news/".$FinalFilenameFront;
			$result["id"] = $FinalFilenameFront;
			$result['message'] = 'Thêm thành công';
			$result['returnUrl'] = XC_URL."/admin/news";
		}
		elseif(isset($method) && $method == "edit")
		{
			// echo "ssss";
			// echo $id .'id';
			$db->query("SELECT * FROM hicrm_news WHERE id = '".$id."'");
			$db->fetch_object(true);
			if($db->num_row())
			{
				// echo "aa";
				$FinalFilenameFront = "";
				//echo $_FILES['hinhanh']['name']."ssss";
				if(isset($_FILES['new_image']))
				{
					$errors= array();
					$file_name = $_FILES['new_image']['name'];
					$file_size =$_FILES['new_image']['size'];
					$file_tmp =$_FILES['new_image']['tmp_name'];
					$file_type=$_FILES['new_image']['type'];
					$file_ext=strtolower(end(explode('.',$_FILES['new_image']['name'])));
					$OriginalFilename = $FinalFilename = preg_replace('`[^a-z0-9-_.]`i','',$_FILES['new_image']['name']); 
					$FinalFilenameFront = md5(time())."-".$FinalFilename;
					if(in_array($file_ext,$expensions)=== false){
						$errors[]="Extension not allowed, please choose a .png, .jpg file.";
					}
					if($file_size > 5242880){
						$errors[]='File size must be max 2Mb';
					}
					if(empty($errors)==true){
						move_uploaded_file($file_tmp,"./uploads/news/".$FinalFilenameFront);
						
					}else
					{
						$result["status"] = 500;
					}
					
				}
				
				$updateimage = ($FinalFilenameFront != "")? ", new_image = '".$FinalFilenameFront."'" : "";
				// echo "UPDATE hicrm_news SET new_name = '".$_POST['new_name']."',new_description = '".$_POST['new_description']."', new_content = '".$new_content."'".$updateimage." WHERE id = '".$id."'";
				$db->query("UPDATE hicrm_news SET new_name = '".$_POST['new_name']."',new_description = '".$_POST['new_description']."', new_content = '".$new_content."'".$updateimage." WHERE id = '".$id."'");
				$result["status"] = 200;
				$result['message'] = 'Sửa thành công';
				$result['returnUrl'] = XC_URL."/admin/news";
			}
			else
			{
				$result["status"] = 500;
				$result["message"] = "Không tồn tại nội dung này!";
			}
		}
		echo json_encode($result);
	}
	//====END====/
    //API Update image_type
    public function update_imagetype(){
        global $db;
        if(isset($_POST['cancel_slider']) && $_POST['cancel_slider'] == 1){
            $db->query("UPDATE hicrm_images SET image_category='0',image_device='0' WHERE id = '".$_POST['iid']."'");
             $result["status"] = 200;
        }else{
        $db->query("UPDATE hicrm_images SET image_category='3',image_device='".$_POST['image_type']."' WHERE id = '".$_POST['iid']."'");
        $result["status"] = 200;
        }
        echo json_encode($result);
    }
    //END
	//===== API events === 
	public function events()
	{
		global $db;
		$event_name = $_POST['event_name'];
		$event_description = $_POST['event_description'];
		$event_content = $db->escapestring($_POST['event_content']);
		$event_user_created = $_POST['event_user_created'];
		$event_hot = $_POST['event_hot'];
		$event_created_date = date('Y-m-d H:i:s');
		$FinalFilenameFront = "";
		$FinalFilenameFront2 = "";
		$expensions = array("jpeg","jpg","png");
		$method = $_POST['method'];
		$result = array();
		$id = $_POST['eid'];
		
		if(isset($method) && $method == "add")
		{
			$FinalFilenameFront = "";
			$FinalFilenameFront2 = "";
			//echo $_FILES['hinhanh']['name']."ssss";
			if ($_FILES['event_image']['error'] == 4) {
				// Không có file upload → gán hình mặc định
				$FinalFilenameFront = '';
			}else{
				$errors= array();
				$file_name = $_FILES['event_image']['name'];
				$file_size =$_FILES['event_image']['size'];
				$file_tmp =$_FILES['event_image']['tmp_name'];
				$file_type=$_FILES['event_image']['type'];
				$file_ext=strtolower(end(explode('.',$_FILES['event_image']['name'])));
				$OriginalFilename = $FinalFilename = preg_replace('`[^a-z0-9-_.]`i','',$_FILES['event_image']['name']); 
				$FinalFilenameFront = md5(time())."-".$FinalFilename;
				if(in_array($file_ext,$expensions)=== false){
					$errors[]="Extension not allowed, please choose a .png, .jpg file.";
				}
				if($file_size > 5242880){
					$errors[]='File size must be max 2Mb';
				}
				if(empty($errors)==true){
					move_uploaded_file($file_tmp,"./uploads/events/".$FinalFilenameFront);
					
				}else
				{
					$result["status"] = 500;
				}
				
			}
			$db->query("INSERT INTO hicrm_events(event_name,event_description,event_content,event_image,event_hot, event_user_created,event_status,event_created_date)
			VALUES('".$_POST['event_name']."','".$_POST['event_description']."','".$event_content."','".$FinalFilenameFront."','".$event_hot."','".$event_user_created."',1,'".$event_created_date."')");
			$result["status"] = 200;
			$result["url"] = XC_URL."/uploads/events/".$FinalFilenameFront;
			$result["id"] = $FinalFilenameFront;
			$result['message'] = 'Thêm thành công';
			$result['returnUrl'] = XC_URL."/admin/events";
		}
		elseif(isset($method) && $method == "edit")
		{
			// echo "ssss";
			// echo $id .'id';
			$db->query("SELECT * FROM hicrm_events WHERE id = '".$id."'");
			$db->fetch_object(true);
			if($db->num_row())
			{
				// echo "aa";
				$FinalFilenameFront = "";
				//echo $_FILES['hinhanh']['name']."ssss";
				if(isset($_FILES['event_image']))
				{
					$errors= array();
					$file_name = $_FILES['event_image']['name'];
					$file_size =$_FILES['event_image']['size'];
					$file_tmp =$_FILES['event_image']['tmp_name'];
					$file_type=$_FILES['event_image']['type'];
					$file_ext=strtolower(end(explode('.',$_FILES['event_image']['name'])));
					$OriginalFilename = $FinalFilename = preg_replace('`[^a-z0-9-_.]`i','',$_FILES['event_image']['name']); 
					$FinalFilenameFront = md5(time())."-".$FinalFilename;
					if(in_array($file_ext,$expensions)=== false){
						$errors[]="Extension not allowed, please choose a .png, .jpg file.";
					}
					if($file_size > 5242880){
						$errors[]='File size must be max 2Mb';
					}
					if(empty($errors)==true){
						move_uploaded_file($file_tmp,"./uploads/events/".$FinalFilenameFront);
						
					}else
					{
						$result["status"] = 500;
					}
					
				}
				
				$updateimage = ($FinalFilenameFront != "")? ", event_image = '".$FinalFilenameFront."'" : "";
				// echo "UPDATE hicrm_events SET event_name = '".$_POST['event_name']."',event_description = '".$_POST['event_description']."', event_content = '".$event_content."'".$updateimage.", event_hot = '".$event_hot."' WHERE id = '".$id."'";
				$db->query("UPDATE hicrm_events SET event_name = '".$_POST['event_name']."',event_description = '".$_POST['event_description']."', event_content = '".$event_content."'".$updateimage.", event_hot = '".$event_hot."' WHERE id = '".$id."'");
				$result["status"] = 200;
				$result['message'] = 'Sửa thành công';
				$result['returnUrl'] = XC_URL."/admin/events";
			}
			else
			{
				$result["status"] = 500;
				$result["message"] = "Không tồn tại nội dung này!";
			}
		}
		echo json_encode($result);
	}
	//====END====/

	//=======API product ========== ////
	public function productActions()
	{
		global $db;
		$product_code = $_POST['product_code'];
		$product_name = $_POST['product_name'];
		$product_price = $_POST['product_price'];
		$product_discount = $_POST['product_discount'];
		$product_category = $_POST['product_category'];
		$product_description = $db->escapestring($_POST['product_description']);
		$product_unit = $_POST['product_unit'];
		$product_created_time = date('Y-m-d H:i:s');
		$product_vat_name = '';
		$product_barcode = '';
		$FinalFilenameFront = "";
		$FinalFilenameFront2 = "";
		$expensions = array("jpeg","jpg","png");
		$method = $_POST['method'];
		$result = array();
		$id = $_POST['pid'];
		if(isset($method) && $method == "new")
		{
			$FinalFilenameFront = "";
			$FinalFilenameFront2 = "";
			//echo $_FILES['hinhanh']['name']."ssss";
			if ($_FILES['product_image']['error'] == 4) {
				// Không có file upload → gán hình mặc định
				$FinalFilenameFront = '';
			}else{
				$errors= array();
				$file_name = $_FILES['product_image']['name'];
				$file_size =$_FILES['product_image']['size'];
				$file_tmp =$_FILES['product_image']['tmp_name'];
				$file_type=$_FILES['product_image']['type'];
				$file_ext=strtolower(end(explode('.',$_FILES['product_image']['name'])));
				$OriginalFilename = $FinalFilename = preg_replace('`[^a-z0-9-_.]`i','',$_FILES['product_image']['name']); 
				$FinalFilenameFront = md5(time())."-".$FinalFilename;
				if(in_array($file_ext,$expensions)=== false){
					$errors[]="Extension not allowed, please choose a .png, .jpg file.";
				}
				if($file_size > 5242880){
					$errors[]='File size must be max 2Mb';
				}
				if(empty($errors)==true){
					move_uploaded_file($file_tmp,"./uploads/products/".$FinalFilenameFront);
					
				}else
				{
					$result["status"] = 500;
				}
				
			}
			$db->query("INSERT INTO hicrm_products(product_name,product_code,product_barcode,product_vat_name,product_unit,product_category,product_price,product_discount,product_tax_id,product_description,product_image,product_created_time,product_status) VALUES ('".$product_name."','".$product_code."','".$product_barcode."','".$product_vat_name."','".$product_unit."','".$product_category."','".$product_price."','".$product_discount."',0,'".$product_description."','".$FinalFilenameFront."','".$product_created_time."',1)");			
			$result["status"] = 200;
			$result["url"] = XC_URL."/uploads/products/".$FinalFilenameFront;
			$result["id"] = $FinalFilenameFront;
			$result['message'] = 'Thêm thành công';
			$result['returnUrl'] = XC_URL."/admin/products";
		}
		elseif(isset($method) && $method == "update")
		{
			// echo "ssss";
			// echo $id .'id';
			$db->query("SELECT * FROM hicrm_products WHERE id = '".$id."'");
			$db->fetch_object(true);
			if($db->num_row())
			{
				// echo "aa";
				$FinalFilenameFront = "";
				//echo $_FILES['hinhanh']['name']."ssss";
				if(isset($_FILES['product_image']))
				{
					$errors= array();
					$file_name = $_FILES['product_image']['name'];
					$file_size =$_FILES['product_image']['size'];
					$file_tmp =$_FILES['product_image']['tmp_name'];
					$file_type=$_FILES['product_image']['type'];
					$file_ext=strtolower(end(explode('.',$_FILES['product_image']['name'])));
					$OriginalFilename = $FinalFilename = preg_replace('`[^a-z0-9-_.]`i','',$_FILES['product_image']['name']); 
					$FinalFilenameFront = md5(time())."-".$FinalFilename;
					if(in_array($file_ext,$expensions)=== false){
						$errors[]="Extension not allowed, please choose a .png, .jpg file.";
					}
					if($file_size > 5242880){
						$errors[]='File size must be max 2Mb';
					}
					if(empty($errors)==true){
						move_uploaded_file($file_tmp,"./uploads/products/".$FinalFilenameFront);
						
					}else
					{
						$result["status"] = 500;
					}
					
				}
				
				$updateimage = ($FinalFilenameFront != "")? ", product_image = '".$FinalFilenameFront."'" : "";
				// echo "UPDATE hicrm_products SET product_name='".$product_name."',product_code='".$product_code."',product_barcode='".$product_barcode."',product_vat_name='".$product_vat_name."',product_unit='".$product_unit."',product_category='".$product_category."',product_price='".$product_price."',product_discount='".$product_discount."',product_tax_id=0,product_description='".$product_description."".$updateimage." WHERE id='".$id."'";
				$db->query("UPDATE hicrm_products SET product_name='".$product_name."',product_code='".$product_code."',product_barcode='".$product_barcode."',product_vat_name='".$product_vat_name."',product_unit='".$product_unit."',product_category='".$product_category."',product_price='".$product_price."',product_discount='".$product_discount."',product_tax_id=0,product_description='".$product_description."'".$updateimage." WHERE id='".$id."'");

				$result["status"] = 200;
				$result['message'] = 'Sửa thành công';
				$result['returnUrl'] = XC_URL."/admin/products";
			}
			else
			{
				$result["status"] = 500;
				$result["message"] = "Không tồn tại nội dung này!";
			}
		}
		if(isset($method) && $method == "delete")
		{
			$db->query("SELECT * FROM hicrm_products WHERE id = '".$id."' AND product_status NOT IN (99) LIMIT 1");
			$product = $db->fetch_object(true);
			if($product)
			{
				$db->query("UPDATE hicrm_products SET product_status = 99 WHERE id = '".$id."'");
				$result["status"] = 200;
				$result["message"] = "Xoa thanh cong";
				$result["returnUrl"] = XC_URL."/admin/products";
			}
			else
			{
				$result["status"] = 500;
				$result["message"] = "Khong ton tai thuoc nay!";
			}
		}
		echo json_encode($result);
	}


	///===END====//

	public function addnews()
	{
		global $db;
		$result = array();
		$updatetype = $_POST['updatetype'];
		if(isset($_POST['updatetype']) && $_POST['updatetype'] == "new")
		{
			$FinalFilenameFront = "";
			$FinalFilenameFront2 = "";
			//echo $_FILES['hinhanh']['name']."ssss";
			if ($_FILES['hinhanh']['error'] == 4) {
				// Không có file upload → gán hình mặc định
				$FinalFilenameFront = $default_image;
			}else{
				$errors= array();
				$file_name = $_FILES['hinhanh']['name'];
				$file_size =$_FILES['hinhanh']['size'];
				$file_tmp =$_FILES['hinhanh']['tmp_name'];
				$file_type=$_FILES['hinhanh']['type'];
				$file_ext=strtolower(end(explode('.',$_FILES['hinhanh']['name'])));
				$OriginalFilename = $FinalFilename = preg_replace('`[^a-z0-9-_.]`i','',$_FILES['hinhanh']['name']); 
				$FinalFilenameFront = md5(time())."-".$FinalFilename;
				if(in_array($file_ext,$expensions)=== false){
					$errors[]="Extension not allowed, please choose a .png, .jpg file.";
				}
				if($file_size > 5242880){
					$errors[]='File size must be max 2Mb';
				}
				if(empty($errors)==true){
					move_uploaded_file($file_tmp,"./uploads/general/".$FinalFilenameFront);
					
				}else
				{
					$result["status"] = 500;
				}
				
			}
			
			$db->query("INSERT INTO bds_news(news_title,news_category,news_content,news_author,news_feature,news_view,news_image) VALUES('".$_POST['title']."','".$_POST['category']."','".$_POST['noidung']."','".$_SESSION['staff']['id']."',1,0,'".$FinalFilenameFront."')");
			$result["status"] = 200;
			$result["url"] = XC_URL."/uploads/general/".$FinalFilenameFront;
			$result["id"] = $FinalFilenameFront;
		}
		elseif(isset($_POST['updatetype']) && $_POST['updatetype'] == "edit")
		{
			$db->query("SELECT * FROM bds_news WHERE id = '".$_POST['id']."'");
			if($db->num_row())
			{
				$FinalFilenameFront = "";
				//echo $_FILES['hinhanh']['name']."ssss";
				if(isset($_FILES['hinhanh']))
				{
					$errors= array();
					$file_name = $_FILES['hinhanh']['name'];
					$file_size =$_FILES['hinhanh']['size'];
					$file_tmp =$_FILES['hinhanh']['tmp_name'];
					$file_type=$_FILES['hinhanh']['type'];
					$file_ext=strtolower(end(explode('.',$_FILES['hinhanh']['name'])));
					$OriginalFilename = $FinalFilename = preg_replace('`[^a-z0-9-_.]`i','',$_FILES['hinhanh']['name']); 
					$FinalFilenameFront = md5(time())."-".$FinalFilename;
					if(in_array($file_ext,$expensions)=== false){
						$errors[]="Extension not allowed, please choose a .png, .jpg file.";
					}
					if($file_size > 5242880){
						$errors[]='File size must be max 2Mb';
					}
					if(empty($errors)==true){
						move_uploaded_file($file_tmp,"./uploads/general/".$FinalFilenameFront);
						
					}else
					{
						$result["status"] = 500;
					}
					
				}
				
				$updateimage = ($FinalFilenameFront != "")? ", news_image = '".$FinalFilenameFront."'" : "";
				$db->query("UPDATE bds_news SET news_title = '".$_POST['title']."', news_category = '".$_POST['category']."', news_content = '".$_POST['noidung']."' ".$updateimage." WHERE id = '".$_POST['id']."'");
				$result["status"] = 200;
			}
			else
			{
				$result["status"] = 500;
				$result["message"] = "Không tồn tại nội dung này!";
			}
		}
		echo json_encode($result);
	}
	//==========API Category ==============//
	public function addCategory(){
		global $db;
		$result = array();
		$db->query("INSERT INTO hicrm_categories(category_name, category_description, category_parent, category_orderby, category_status) 
		VALUES ('".$_POST['category_name']."','".$_POST['category_des']."','".$_POST['category_parent']."','".$_POST['category_orderby']."','1')");
		$result['status'] = 200;
        $result['message'] = "Thêm hành công!";
        echo json_encode($result);
	}
	//====END====//
	//==========API SERVICES ===========//
	public function services(){
		global $db;
		$service_name = $_POST['service_name'];
		$service_description = $db->escapestring($_POST['service_description']);
		$service_created_date = date('Y-m-d H:i:s');
		$FinalFilenameFront = "";
		$FinalFilenameFront2 = "";
		$expensions = array("jpeg","jpg","png");
		$method = $_POST['method'];
		$result = array();
		$id = $_POST['sid'];
		$service_category = $_POST['service_category'];
		
		if(isset($method) && $method == "add")
		{
			$FinalFilenameFront = "";
			$FinalFilenameFront2 = "";
			//echo $_FILES['hinhanh']['name']."ssss";
			if ($_FILES['service_image']['error'] == 4) {
				// Không có file upload → gán hình mặc định
				$FinalFilenameFront = '';
			}else{
				$errors= array();
				$file_name = $_FILES['service_image']['name'];
				$file_size =$_FILES['service_image']['size'];
				$file_tmp =$_FILES['service_image']['tmp_name'];
				$file_type=$_FILES['service_image']['type'];
				$file_ext=strtolower(end(explode('.',$_FILES['service_image']['name'])));
				$OriginalFilename = $FinalFilename = preg_replace('`[^a-z0-9-_.]`i','',$_FILES['service_image']['name']); 
				$FinalFilenameFront = md5(time())."-".$FinalFilename;
				if(in_array($file_ext,$expensions)=== false){
					$errors[]="Extension not allowed, please choose a .png, .jpg file.";
				}
				if($file_size > 5242880){
					$errors[]='File size must be max 2Mb';
				}
				if(empty($errors)==true){
					move_uploaded_file($file_tmp,"./uploads/services/".$FinalFilenameFront);
					
				}else
				{
					$result["status"] = 500;
				}
				
			}
			$db->query("INSERT INTO hicrm_service(service_name, service_description, service_image, service_category, service_created_date, service_status) VALUES ('".$service_name."','".$service_description."','".$FinalFilenameFront."','".$service_category."','".$service_created_date."','1')");
			
			$result["status"] = 200;
			$result["url"] = XC_URL."/uploads/services/".$FinalFilenameFront;
			$result["id"] = $FinalFilenameFront;
			$result['message'] = 'Thêm thành công';
			$result['returnUrl'] = XC_URL."/admin/service/".$service_category;
		}
		elseif(isset($method) && $method == "edit")
		{
			$db->query("SELECT * FROM hicrm_service WHERE id = '".$id."'");
			$db->fetch_object(true);
			if($db->num_row())
			{
				// echo "aa";
				$FinalFilenameFront = "";
				//echo $_FILES['hinhanh']['name']."ssss";
				if(isset($_FILES['service_image']))
				{
					$errors= array();
					$file_name = $_FILES['service_image']['name'];
					$file_size =$_FILES['service_image']['size'];
					$file_tmp =$_FILES['service_image']['tmp_name'];
					$file_type=$_FILES['service_image']['type'];
					$file_ext=strtolower(end(explode('.',$_FILES['service_image']['name'])));
					$OriginalFilename = $FinalFilename = preg_replace('`[^a-z0-9-_.]`i','',$_FILES['service_image']['name']); 
					$FinalFilenameFront = md5(time())."-".$FinalFilename;
					if(in_array($file_ext,$expensions)=== false){
						$errors[]="Extension not allowed, please choose a .png, .jpg file.";
					}
					if($file_size > 5242880){
						$errors[]='File size must be max 2Mb';
					}
					if(empty($errors)==true){
						move_uploaded_file($file_tmp,"./uploads/services/".$FinalFilenameFront);
						
					}else
					{
						$result["status"] = 500;
					}
					
				}
				
				$updateimage = ($FinalFilenameFront != "")? ", service_image = '".$FinalFilenameFront."'" : "";
				// echo "UPDATE hicrm_service SET service_name='".$service_name."',service_description='".$service_description."', ".$updateimage." service_category='".$service_category."' WHERE id = '".$id."'";
				$db->query("UPDATE hicrm_service SET service_name='".$service_name."',service_description='".$service_description."' ".$updateimage." ,service_category='".$service_category."' WHERE id = '".$id."'");
				$result["status"] = 200;
				$result['message'] = 'Sửa thành công';
				$result['returnUrl'] = XC_URL."/admin/service/".$service_category;
			}
			else
			{
				$result["status"] = 500;
				$result["message"] = "Không tồn tại nội dung này!";
			}
		}
		echo json_encode($result);
	}
	public function deleteservices(){
		$id = $_POST['id'];
		$table = 'hicrm_service';
		$row = 'service_status';
		$this->model->action($id, $row, $table);
		$result['status'] = 200;
		echo json_encode($result);
	}
	//===========END==============//
	//==============API LỊCH CÔNG TÁC ===========//
	public function calendar_works(){
		global $db;
		$calendar_work_name = $_POST['calendar_work_name'];
		$calendar_work_to = $_POST['calendar_work_to'];
		$calendar_work_from = $_POST['calendar_work_from'];
		$calendar_work_content = $db->escapestring($_POST['calendar_work_description']);
		$calendar_work_created_date = date('Y-m-d H:i:s');
		$FinalFilenameFront = "";
		$FinalFilenameFront2 = "";
		$expensions = array("pdf","doc");
		$method = $_POST['method'];
		$result = array();
		$id = $_POST['wid'];
		$uid = $_POST['uid'];
		
		if(isset($method) && $method == "add")
		{
			$FinalFilenameFront = "";
			$FinalFilenameFront2 = "";
			
			//echo $_FILES['hinhanh']['name']."ssss";
			if ($_FILES['calendar_work_file']['error'] == 4) {
				// Không có file upload → gán hình mặc định
				$FinalFilenameFront = '';
			}else{
				$errors= array();
				$file_name = $_FILES['calendar_work_file']['name'];
				$file_size =$_FILES['calendar_work_file']['size'];
				$file_tmp =$_FILES['calendar_work_file']['tmp_name'];
				$file_type=$_FILES['calendar_work_file']['type'];
				$file_ext=strtolower(end(explode('.',$_FILES['calendar_work_file']['name'])));
				$OriginalFilename = $FinalFilename = preg_replace('`[^a-z0-9-_.]`i','',$_FILES['calendar_work_file']['name']); 
				$FinalFilenameFront = md5(time())."-".$FinalFilename;
				if(in_array($file_ext,$expensions)=== false){
					$errors[]="Extension not allowed, please choose a .pdf, .doc file.";
				}
				if($file_size > 5242880){
					$errors[]='File size must be max 2Mb';
				}
				if(empty($errors)==true){
					move_uploaded_file($file_tmp,"./uploads/files/".$FinalFilenameFront);
					
				}else
				{
					$result["status"] = 500;
				}
				
			}
			$db->query("INSERT INTO hicrm_calendar_works(calendar_work_name, calendar_work_content, calendar_work_file, calendar_work_from_date, calendar_work_to_date, calendar_work_created_date, calendar_work_user_created, calendar_status) VALUES ('".$_POST['calendar_work_name']."','".$_POST['calendar_work_content']."','".$FinalFilenameFront."','".$_POST['calendar_work_from']."','".$_POST['calendar_work_to']."','".$calendar_work_created_date."','".$_POST['uid']."','1')");

			
			$result["status"] = 200;
			$result["url"] = XC_URL."/uploads/files/".$FinalFilenameFront;
			$result["id"] = $FinalFilenameFront;
			$result['message'] = 'Thêm thành công';
			$result['returnUrl'] = XC_URL."/admin/lichcongtac/";
		}
		elseif(isset($method) && $method == "edit")
		{
			$db->query("SELECT * FROM hicrm_calendar_works WHERE id = '".$id."'");
			$db->fetch_object(true);
			if($db->num_row())
			{
				// echo "aa";
				$FinalFilenameFront = "";
				//echo $_FILES['hinhanh']['name']."ssss";
				if(isset($_FILES['calendar_work_file']))
				{
					$errors= array();
					$file_name = $_FILES['calendar_work_file']['name'];
					$file_size =$_FILES['calendar_work_file']['size'];
					$file_tmp =$_FILES['calendar_work_file']['tmp_name'];
					$file_type=$_FILES['calendar_work_file']['type'];
					$file_ext=strtolower(end(explode('.',$_FILES['calendar_work_file']['name'])));
					$OriginalFilename = $FinalFilename = preg_replace('`[^a-z0-9-_.]`i','',$_FILES['calendar_work_file']['name']); 
					$FinalFilenameFront = md5(time())."-".$FinalFilename;
					if(in_array($file_ext,$expensions)=== false){
						$errors[]="Extension not allowed, please choose a .doc, .pdf file.";
					}
					if($file_size > 5242880){
						$errors[]='File size must be max 2Mb';
					}
					if(empty($errors)==true){
						move_uploaded_file($file_tmp,"./uploads/files/".$FinalFilenameFront);
						
					}else
					{
						$result["status"] = 500;
					}
					
				}
				
				$updatefile = ($FinalFilenameFront != "")? ", calendar_work_file = '".$FinalFilenameFront."'" : "";
				// echo "UPDATE hicrm_service SET service_name='".$service_name."',service_description='".$service_description."' ".$updateimage." ,service_category='".$service_category."' WHERE id = '".$id."'";
				$db->query("UPDATE hicrm_calendar_works SET calendar_work_name='".$calendar_work_name."',calendar_work_content='".$calendar_work_content."' ".$updatefile.",calendar_work_from_date='".$calendar_work_from."',calendar_work_to_date='".$calendar_work_to."' WHERE id = '".$id."' ");

				
				$result["status"] = 200;
				$result['message'] = 'Sửa thành công';
				$result['returnUrl'] = XC_URL."/admin/lichcongtac/";
			}
			else
			{
				$result["status"] = 500;
				$result["message"] = "Không tồn tại nội dung này!";
			}
		}
		echo json_encode($result);
	}
	//=========END=========//
	//======================== ORDER API =================================//
    
	public function addorders(){
        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";
        global $db;
        $result = array();
        $db->query("INSERT INTO hicrm_orders(order_customer_id, order_employee_id, order_payment_policy_id, order_warehouse_id, order_code, order_name_contact, order_payment_active, order_description, order_date, order_active, order_delivery_date, order_create_date, order_status) VALUES ('".$_POST['order_customer_id']."','".$_POST['order_employee_id']."','".$_POST['order_payment_policy_id']."','".$_POST['order_warehouse_id']."','".$_POST['order_code']."','".$_POST['order_name_contact']."','".$_POST['order_payment_active']."','".$_POST['order_description']."','".$_POST['order_date']."','".$_POST['order_active']."','".$_POST['order_delivery_date']."','".date("Y-m-d H:i:s")."','1')");
        //check order code
        $db->query("SELECT * FROM hicrm_orders WHERE order_code = '".$_POST['order_code']."' LIMIT 1 ");
        $id_oder = $db->fetch_object(true)->id;
        
        foreach($_POST['products'] as $product)
        {
			
            $db->query("SELECT * FROM hicrm_category_products WHERE cat_product_code = '".$product[0]."' AND cat_product_status NOT IN(99) ");
            $row_product = $db->fetch_object(true);
			
            if($db->num_row($row_product)){
                $id_product = $row_product->id;
                $db->query("INSERT INTO hicrm_order_details(order_id, order_product_id, order_product_quantity, order_product_price, order_product_vat_tax, order_product_discount) VALUE('".$id_oder."', '".$id_product."', '".$product[3]."', '".$product[4]."', '".$product[5]."', '".$product[6]."' )");

            }else{
                $db->query("INSERT INTO hicrm_category_products(cat_product_code, cat_product_name,cat_product_unit, cat_product_status, cat_product_parent) VALUE('".$product[0]."', '".$product[1]."', '".$product[2]."', '1','0') ");
                $db->query("SELECT * FROM hicrm_category_products WHERE cat_product_code = '".$product[0]."' LIMIT 1");
                $id_product = $db->fetch_object(true)->id;
				$db->query("INSERT INTO hicrm_order_details(order_id, order_product_id, order_product_quantity, order_product_price, order_product_vat_tax, order_product_discount) VALUE('".$id_oder."', '".$id_product."', '".$product[3]."', '".$product[4]."', '".$product[5]."', '".$product[6]."' )");
            }


        }

        $result['status'] = 200;
        $result['message'] = "Tạo đơn thành công!";
        echo json_encode($result);
    }
    public function autocompleteProductcode(){
        global $db;
        $result = array();
        if(isset($_GET['data']) && $_GET['data'] != ''){
            $db->query("SELECT * FROM hicrm_category_products WHERE cat_product_name LIKE '%".$_GET['data']."%' AND cat_product_status NOT IN (99)");
            $data_cat_pr = $db->fetch_object();
            foreach($data_cat_pr as $pr){
                array_push($result,  $pr->cat_product_code . " - ". $pr->cat_product_name);
            }
        }
        echo json_encode($result);
    }
	public function searchproduct()
	{
		$q = "m";
		
		global $db;
		$db->query("SELECT * FROM hicrm_category_products WHERE (cat_product_name LIKE '%".$q."%' OR cat_product_code LIKE '%".$q."%') AND NOT(cat_product_status = 99)");
		
		$products = $db->fetch_object();
		$result = array();
		$s = array();
		
		foreach($products as $p)
		{
			$sub = array();
			$sub["code"] = $p->cat_product_code;
			$sub["name"] = $p->cat_product_name;
			$sub["unit"] = $p->cat_product_unit;
			array_push($s,$sub);
		}
		$result["suggestions"]= $s;
		
		echo json_encode($result);
	}
	
	public function deleteEvent(){
		$id = $_POST['id'];
		$table = 'hicrm_events';
		$row = 'event_status';
		$this->model->action($id, $row, $table);
		$result['status'] = 200;
		echo json_encode($result);

	}
	public function orderGetBranch(){
		global $db;
		$db->query("SELECT * FROM hicrm_employees WHERE id = '".$_POST['order_employee_id']."'");
		$branch_id = $db->fetch_object(true)->employee_branch;
		$result = array();
		$db->query("SELECT * FROM hicrm_branchs WHERE id = '".$branch_id."'");
		$data = $db->fetch_object(true)->branch_name;
		$result['status'] = 200;
		$result['data'] = $data;
		echo json_encode($result);
	}
	public function orderGetPaymentPolicy(){
		global $db;
		$result = array();
		$db->query("SELECT * FROM hicrm_payment_policies WHERE id = '".$_POST['id_payment']."'");
		$data = $db->fetch_object(true)->policy_debt_day;
		$result['status'] = 200;
		$result['data'] = $data;
		echo json_encode($result);
	}
	public function getproductcodeorder(){
		global $db;
		$result = array();
		$db->query("SELECT * FROM hicrm_category_products WHERE cat_product_status NOT IN(99)");
		$data_cat_pr = $db->fetch_object();
		$data = '<option disabled selected="selected" >Chọn</option>';
			foreach($data_cat_pr as $row_product){
			$data .= '<option value="'.$row_product->id.'">'.$row_product->cat_product_code.'</option>';
			}
		$result['status'] = 200;
		$result['data'] = $data;
		echo json_encode($result);
	}
	public function getcategoryproductorder(){
		global $db;
		$result = array();
		$db->query("SELECT * FROM hicrm_category_products WHERE cat_product_status NOT IN(99)");
		$data_cat_pr = $db->fetch_object();
		$data = '	<option value="" disabled selected="selected">Chọn</option>
					<option value="0" >Danh mục gốc</option>';
		foreach($data_cat_pr as $row_cat_pr){
		$data .= '<option value="'. $row_cat_pr->id.'">'.$row_cat_pr->cat_product_name.'</option>';
		}	
		$result['status'] = 200;
		$result['data'] = $data;
		echo json_encode($result);		
	}
	//======================== END ORDER API =================================//
	
	//======================== WAREHOUSE API =================================//
	//					Function add warehouses	//
	public function warehouses(){
		global $db;
		$result = array();
		if($_POST['method'] == "new"){
			echo "INSERT INTO hicrm_warehouses(warehouse_code, warehouse_branch_id, warehouse_name,warehouse_description,warehouse_parent,warehouse_create_date,warehouse_status) VALUES ('".$_POST['warehouse_code']."','".$_POST['warehouse_branch_id']."','".$_POST['warehouse_name']."','".$_POST['warehouse_description']."','".$_POST['warehouse_parent']."','".date("Y-m-d H:i:s")."','1' )";
				$db->query("INSERT INTO hicrm_warehouses(warehouse_code, warehouse_branch_id, warehouse_name,warehouse_description,warehouse_parent,warehouse_create_date,warehouse_status) VALUES ('".$_POST['warehouse_code']."','".$_POST['warehouse_branch_id']."','".$_POST['warehouse_name']."','".$_POST['warehouse_description']."','".$_POST['warehouse_parent']."','".date("Y-m-d H:i:s")."','1' )");
				$result['message'] = "Thêm thành công";
				$result['status'] = 200;
		}elseif($_POST['method'] == "update"){
			
			$db->query("SELECT * FROM hicrm_warehouses WHERE id = '".$_POST['id']."'");
			
			$db->fetch_object(true);
				if($db->num_row()){
						$db->query("UPDATE hicrm_warehouses SET warehouse_code='".$_POST['warehouse_code']."',warehouse_branch_id='".$_POST['warehouse_branch_id']."',warehouse_name='".$_POST['warehouse_name']."',warehouse_description='".$_POST['warehouse_description']."',warehouse_parent='".$_POST['warehouse_parent']."' WHERE id='".$_POST['id']."'");
						$result['message'] = "Sửa thành công";
						$result['status'] = 200;
					
				}else{
					$result['message'] = "Không tìm  khoản mục chi phí này";
					$result['status'] = 500;
				}
				
		}
		echo json_encode($result);
	}
	public function addrowtableorder(){
		global $db;
		$result = array();
		$row = $_POST['rowcount'];
		$db->query("SELECT * FROM hicrm_category_products WHERE cat_product_status NOT IN(99)");
		$category_product = $db->fetch_object();
		$db->query("SELECT * FROM hicrm_units WHERE unit_status NOT IN(99)"); 
		$units = $db->fetch_object();
		$data ='
		 <tr></td>
		<td> 
            <div class="box-product-code">
            <input type="text" class="form-control product_code" id="product_code_'.$row.'" placeholder="Mã sản phẩm" autocomplete="off">
            </div>
            
                
            </td>
            <td>
                <input value="" class="form-control cat_product_name"  name="cat_product_name" id="cat_product_name_id_'.$row.'"  />
            </td>
            <td>
				<select name="product_unit_id" id="product_unit_id'.$row.'" class="select select2 product_unit_id">';
									foreach($units as $unit){ 
									$data.='<option value=" '.$unit->id.'">'.$unit->unit_name.'</option>';
								 }
				$data.='</select>
            </td>
            <td>
                <input value="" class="form-control product_quantity" type="number" min="0" id="product_quantity_'.$row.'" name="product_quantity">
            </td>
            <td>
                <input value="" class="form-control product_price"  name="product_price" id="product_price_'.$row.'"/>
            </td>
            <td>
                <input value="" class="form-control product_into_money"  name="product_into_money" id="product_into_money_'.$row.'" readonly/>
            </td>
            <td>
                <select class="select select2withsearch product_vat_tax"  name="product_vat_tax" id="product_vat_tax'.$row.'">
                <option value="0">0</option>
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="0">KCT</option>
                
                </select>
            </td>
            <td>
                <input value="" class="product_money_vat_tax form-control" id="product_money_vat_tax_'.$row.'" readonly/>
            </td>
            <td>
            <input value="0" type="number" class=" form-control product_discount" id="product_discount_'.$row.'"  />
          </td>
		</tr>';
		 $result['data'] = $data;
		 $result['status'] = 200;
		echo json_encode($result);
	}
	public function action_warehouses(){
		global $db;
		$result = array();
		$db->query("SELECT * FROM hicrm_warehouses WHERE id = '".$_POST['id']."'");
		$db->fetch_object(true);
		if($db->num_row()){
			if($_POST['method'] == "active"){
				if($_POST['warehouse_status'] == 1){
					$db->query("UPDATE hicrm_warehouses SET warehouse_status = 2 WHERE id = '".$_POST['id']."'");
					$result['status'] = 200;
					$result['message'] = "Đã ngừng hoạt động";
				}else{
					$db->query("UPDATE hicrm_warehouses SET warehouse_status = 1 WHERE id = '".$_POST['id']."'");
					$result['status'] = 200;
					$result['message'] = "Đã hoạt động";
				}
			}elseif($_POST['method'] == "delete"){
					$db->query("UPDATE hicrm_warehouses SET warehouse_status = 99 WHERE id = '".$_POST['id']."'");
					$result['status'] = 200;
					$result['message'] = "Xóa thành công";
			}else{
				$result['message'] = "Không tìm thấy tác vụ thực hiện";
				$result['status'] = 500;
			}
		}else{
			$result['message'] = "Lỗi hệ thống. Không tìm khoản mục chi phí này";
			$result['status'] = 500;
		}
		echo json_encode($result);
	}
	//					END Function add warehouses	//
	//					Function add branchs	//
	public function addBranchs(){
		
		global $db;
		$result = array();
		$db->query("INSERT INTO hicrm_branchs(branch_uid, branch_tax_code, branch_name, branch_address, branch_phone, branch_email, branch_director, branch_type, branch_founded_date, branch_created_date) VALUES ('".$_SESSION['user']['id']."','".$_POST['branch_tax_code']."','".$_POST['branch_name']."','".$_POST['branch_address']."','".$_POST['branch_phone']."','".$_POST['branch_email']."','".$_POST['branch_director']."','1','".$_POST['branch_founded_date']."','".date("Y-m-d H:i:s")."')");
		$result['status'] = 200;
		$result['message'] = "Thêm thành công";
		echo json_encode($result);
		
	}
	//					END Function add branchs	//
	//======================== END ORDER API =================================//
	//					Function get Customer_ID	//
	public function orderCustomerid(){
		global $db;
		$result = array();
		$db->query("SELECT * FROM hicrm_customers WHERE id = '".$_POST['customer_id']."'");
		$row_customers = $db->fetch_object(true);
		$result['status'] = 200;
		$result['customer_address'] = $row_customers->customer_address;
		$result['customer_tax_code'] = $row_customers->customer_tax_code;
		$result['customer_phone'] = $row_customers->customer_phone;
		$result['customer_email'] = $row_customers->customer_email;
		$result['customer_debt'] = number_format($row_customers->customer_debt,0);
		echo json_encode($result);
	}
	//					Function get Category_product	//
	public function orderCategoryproduct(){
		global $db;
		$result = array();
		
		$db->query("SELECT *, cp.id as cpid FROM hicrm_category_products as cp LEFT JOIN hicrm_units as u ON cp.cat_product_unit = u.id WHERE cp.id = '".$_POST['cat_pr_id']."'");
		$data_cat_product = $db->fetch_object(true);
		
		$cat_product_name = $data_cat_product->cat_product_name;
		$cat_product_unit = $data_cat_product->unit_name;
		$result['status'] = 200;
		$result['cat_product_name'] = $cat_product_name;
		$result['cat_product_unit'] = $cat_product_unit;
		echo json_encode($result);
	}
	//======================== Customer API =================================//
	//					Function Duplicate Customer 						 //
	public function duplicatecustomer()
	{
		global $db;
		$cid = $_POST['cid'];
		$customer_uid = $_SESSION['user']['id'];
		$result = array();
		
		$db->query("SELECT * FROM hicrm_customers ORDER BY id DESC LIMIT 1");
		$lastno = $db->fetch_object(true)->customer_code;
		$prefix = $this->helper->get_config("customer_prefix");
		//PREFIX1234567
		$lastno = substr($lastno,-7);
		$lastno = $lastno+1;
		$lastno = $prefix."".str_pad($lastno, 7, '0', STR_PAD_LEFT);
		$db->query("SELECT * FROM hicrm_customers WHERE id = '".$cid."' ORDER BY id DESC LIMIT 1");
		$oc = $db->fetch_object(true);
		$db->query("INSERT INTO hicrm_customers(customer_uid,customer_code,customer_tax_code,customer_name,customer_title,customer_address,customer_phone,customer_email,customer_group,customer_type,customer_is_vendor,customer_staff,customer_note,customer_payment_policy,customer_debit,customer_credit,customer_created_date,customer_status) VALUES('".$customer_uid."','".$lastno."','".$oc->customer_tax_code."','".$oc->customer_name."','".$oc->customer_title."','".$oc->customer_address."','".$oc->customer_phone."','".$oc->customer_email."','".$oc->customer_group."','".$oc->customer_type."','".$oc->customer_is_vendor."','".$oc->customer_staff."','".$oc->customer_note."','".$oc->customer_payment_policy."','".$oc->customer_debit."','".$oc->customer_credit."','".date("Y-m-d H:i:s")."','".$oc->customer_status."')");
		$result["status"] = 200;
		$result["new_customer_code"] = $lastno;
		echo json_encode($result);
	}
	public function deletecustomer()
	{
		global $db;
		$cid = $_POST['cid'];
		$result = array();
		$db->query("UPDATE hicrm_customers SET customer_status = 99 WHERE id = '".$cid."'");
		$result["status"] = 200;
		echo json_encode($result);
	}
	public function deactivecustomer()
	{
		global $db;
		$cid = $_POST['cid'];
		$result = array();
		$db->query("UPDATE hicrm_customers SET customer_status = 2 WHERE id = '".$cid."'");
		$result["status"] = 200;
		echo json_encode($result);
	}
	public function activecustomer()
	{
		global $db;
		$cid = $_POST['cid'];
		$result = array();
		$db->query("UPDATE hicrm_customers SET customer_status = 1 WHERE id = '".$cid."'");
		$result["status"] = 200;
		echo json_encode($result);
	}
	
	//======================== Customer API =================================//
	//======================== Income API =================================//
	public function addnewincomerow()
	{
		global $db;
		$result = array();
		$row = $_POST['rowcount'];
		$db->query("SELECT * FROM hicrm_accounts WHERE account_status = 1 ORDER BY id ASC");
		$accounts = $db->fetch_object();
		$data = '<tr class="data-row-2">
		  <td>
			 <input type="text" id="income_detail_description_'.$row.'" class="form-control">
		  </td>
		  <td>
			 <select id="income_detail_credit_'.$row.'" class="select select2withsearch">';
				foreach($accounts as $account)
				{
					$data .= '<option value="'.$account->account_number.'" >'.$account->account_number.' - '.$account->account_name.'</option>';
				
				}
			$data .= '
		   </select>
		  </td>
		  <td>
			 <select id="income_detail_debit_'.$row.'" class="select select2withsearch">';
			 
				foreach($accounts as $account)
				{
					$data .= '<option value="'.$account->account_number.'" >'.$account->account_number.' - '.$account->account_name.'</option>';
				
				}
		   $data .= '</select>
		  </td>
		  <td>
			 <input id="income_detail_amount_'.$row.'" type="text" class="form-control row-amount">
		  </td>
		  <td class="add-remove text-end">
			 <i data-row="2" class="fas fa-plus-circle btn-add-row"></i > <i class="fas fa-minus-circle btn-remove-row"></i>
		  </td>
	   </tr>';
	   $result["status"] = 200;
	   $result["data"] = $data;
	   echo json_encode($result);
	}
	public function newincome()
	{
		global $db;
		//array(8) { ["income_type"]=> string(1) "1" ["income_code"]=> string(10) "ALI0000001" ["income_to"]=> string(1) "7" ["income_account_date"]=> string(10) "23-08-2021" ["income_create_date"]=> string(10) "23-08-2021" ["income_staff"]=> string(1) "4" ["income_note"]=> string(12) "Test phiếu" ["income_document"]=> string(1) "2" }
		$db->query("INSERT INTO hicrm_incomes(income_no,income_type,income_created_date,income_accounting_date,income_to,income_note,income_staff,income_document,income_status,income_created_by) VALUES('".$_POST['income_code']."','".$_POST['income_type']."','".date("Y-m-d H:i:s",strtotime($_POST['income_create_date']))."','".date("Y-m-d H:i:s",strtotime($_POST['income_account_date']))."','".$_POST['income_to']."','".$_POST['income_note']."','".$_POST['income_staff']."','".$_POST['income_document']."','0','".$_SESSION['user']['id']."')");
		$db->query("SELECT id FROM hicrm_incomes WHERE income_no = '".$_POST['income_code']."' ORDER BY id DESC LIMIT 1");
		$incomeid = $db->fetch_object(true)->id;
		foreach($_POST['details'] as $detail)
		{
			$db->query("INSERT INTO hicrm_income_details(income_id,income_detail,income_debit,income_credit,income_amount) VALUES('".$incomeid."','".$detail[0]."','".$detail[1]."','".$detail[2]."','".$detail[3]."')");
		}
		//var_dump($_POST);
	}
	//======================== Income API =================================//
	//======================== Template API =================================//
	public function gettemplatedetail()
	{
		global $db;
		$result = array();
		$db->query("SELECT * FROM hicrm_templates WHERE id = '".$_POST['id']."'ORDER BY id DESC LIMIT 1");
		$template = $db->fetch_object(true);
		$result["html"] = $template->template_html;
		echo json_encode($result);
	}
	public function updatetemplate()
	{
		global $db;
		$result = array();
		$db->query("UPDATE hicrm_templates SET template_html = '".$_POST['html']."' WHERE id = '".$_POST['id']."'");
		$result["status"] = 200;
		echo json_encode($result);
	}
	//======================== Template API =================================//
	//login eOffice
	public function editCustomer(){
		global $db;
		
		$result = array();
		if(isset($_POST['id']) && $_POST['id'] != ''){
			$db->query("UPDATE hicrm_customers SET customer_tax_code='".$_POST['customer_tax_code']."',customer_name='".$_POST['customer_name']."',customer_title='".$_POST['customer_title']."',customer_address='".$_POST['customer_address']."',customer_phone='".$_POST['customer_phone']."',customer_email='".$_POST['customer_email']."',customer_group='".$_POST['customer_group']."',customer_type='".$_POST['customer_type']."',customer_is_vendor='".$_POST['customer_is_vendor']."',customer_staff='".$_POST['customer_staff']."',customer_note='".$_POST['customer_note']."',customer_last_update='".date("Y-m-d H:i:s")."' WHERE id = '".$_POST['id']."'");
			$result['status'] = 200;
			$result['message'] = "Sửa thành công";
			$result['return_url'] = XC_URL."/app/customers";
		}else{
			$result['status'] = 200;
			$result['message'] = "Không tìm thấy khách hàng/NCC này!";
		}
		echo json_encode($result);
	}
	public function addCustomer()
	{
		global $db;
		$customer_code = $_POST['customer_code'];
		$customer_tax_code = $_POST['customer_tax_code'];
		$customer_title = $_POST['customer_title'];
		$customer_name = $_POST['customer_name'];
		$customer_note = $_POST['customer_note'];
		$customer_address = $_POST['customer_address'];
		$customer_email = $_POST['customer_email'];
		$customer_phone = $_POST['customer_phone']; 
		$customer_is_vendor = $_POST['customer_is_vendor'];
		$customer_staff = $_POST['customer_staff'];
		$customer_type = $_POST['customer_type'];
		$customer_group = 1;
		$customer_payment_policy = 1;
		$customer_debit = 1111;
		$customer_credit = 1111;
		$customer_created_date = $customer_last_update = date('Y-m-d H:i:s');
		$customer_status = 1;
		$customer_uid = $_SESSION['user']['id'];
		$result = array();
		
		$db->query("INSERT INTO hicrm_customers(customer_uid, customer_code, customer_tax_code, customer_name, customer_title, customer_address, customer_phone, customer_email, customer_group, customer_type, customer_is_vendor, customer_staff, customer_note, customer_payment_policy, customer_debit, customer_credit, customer_created_date, customer_last_update, customer_status) VALUES ('".$uid."','".$customer_code."','".$customer_tax_code."','".$customer_name."','".$customer_title."','".$customer_address."','".$customer_phone."','".$customer_email."','".$customer_group."','".$customer_type."','".$customer_is_vendor."','".$customer_staff."','".$customer_note."','".$customer_payment_policy."','".$customer_debit."','".$customer_credit."','".$customer_created_date."','".$customer_last_update."','".$customer_status."' ) ");
		$result['status'] = 200;
		echo json_encode($result);
	}
		//======================== USER API =================================//
	
	public function action_category_users(){
		global $db;
		$uid = $_POST['id'];
		$result = array();
		$db->query("SELECT * FROM hicrm_users WHERE id = '".$uid."'");
		$db->fetch_object(true);
		
		if($db->num_row()){
			if($_POST['method'] == 'active'){
				
				if($_POST['user_status'] == 1){
					$db->query("UPDATE hicrm_users SET user_status = 2 WHERE id = '".$uid."'");
					$result["message"] = "Đã ngưng hoạt động";
					$result["status"] = 200;
				}else{
					$db->query("UPDATE hicrm_users SET user_status = 1 WHERE id = '".$uid."'");
					$result["message"] = "Đã hoạt động";
					$result["status"] = 200;
				}
				
			}elseif($_POST['method'] == "role"){
					$result['status'] = 404;
					$result['message'] = "Tính năng đang nâng cấp";
			}elseif($_POST['method'] == 'delete'){
				var_dump('delete');
				$db->query("UPDATE hicrm_users SET user_status = 99 WHERE id = '".$uid."'");
				$result["message"] = "Xóa thành công";
				$result["status"] = 200;
			}else{
				$result["message"] = "Không tìm thấy tác vụ thực hiện!";
				$result["status"] = 500;
			}
			
		}else{
			$result["message"] = "Không tìm thấy tài khoản này!";
			$result["status"] = 500;
		}
		
		echo json_encode($result);
	}
	//end user
	
		//======================== Employees API =================================//
	//Employees
	public function addEmployee(){
		// echo 'sssssa';
		global $db;
		$employee_code = $_POST['employee_code'];
		$employee_name = $_POST['employee_name'];
		// $employee_branch = $_POST['employee_branch'];
		// $employee_position = $_POST['employee_position'];
		$employee_address = $_POST['employee_address'];
		$employee_birthday = $_POST['employee_birthday'];
		$employee_birthday = date('Y-m-d', strtotime($employee_birthday));
		$employee_gender = $_POST['employee_gender'];
		$employee_phone = $_POST['employee_phone'];
		$employee_national_id = $_POST['employee_national_id'];
		$employee_issue_date = $_POST['employee_issue_date'];
		$employee_issue_date = date("Y-m-d", strtotime($employee_issue_date));
		$employee_issue_by = $_POST['employee_issue_by'];
		$employee_email = $_POST['employee_email'];
		$employee_department = $_POST['employee_department'];
		$employee_debt = '0.0';
		$employee_des = $_POST['employee_des'];
		$employee_status = 1;
		$result = array();
		$employee_created_date = $employee_last_update = date('Y-m-d H:i:s');
		$default_image = 'doctor_default.png';
		$FinalFilenameFront = "";
		$FinalFilenameFront2 = "";
		$expensions = array("jpeg","jpg","png");
		// echo $_FILES['employee_image']['name'];
		//echo $_FILES['hinhanh']['name']."ssss";
		if(isset($_FILES['employee_image'])) {
			// Không có file upload → gán hình mặc định
			$FinalFilenameFront = $default_image;
	
			$errors= array();
			$file_name = $_FILES['employee_image']['name'];
			$file_size =$_FILES['employee_image']['size'];
			$file_tmp =$_FILES['employee_image']['tmp_name'];
			$file_type=$_FILES['employee_image']['type'];
			$file_ext=strtolower(end(explode('.',$_FILES['employee_image']['name'])));
			$OriginalFilename = $FinalFilename = preg_replace('`[^a-z0-9-_.]`i','',$_FILES['employee_image']['name']); 
			$FinalFilenameFront = md5(time())."-".$FinalFilename;
			if(in_array($file_ext,$expensions)=== false){
				$errors[]="Vui lòng chọn file định dạng .png, .jpg.";
			}
			if($file_size > 5242880){
				$errors[]='Dung lượng file tối đa 2Mb';
			}
			if(empty($errors)==true){
				move_uploaded_file($file_tmp,"./uploads/doctors/".$FinalFilenameFront);
				
			}else
			{
				$result["status"] = 500;
			}
		}
		
		$db->query("INSERT INTO hicrm_employees(employee_code, employee_name, employee_gender, employee_birthday, employee_branch, employee_department, employee_position, employee_national_id, employee_issue_date, employee_issue_by, employee_address, employee_phone, employee_email,employee_debt,employee_image, employee_des,employee_status, employee_created_date, employee_last_update) VALUES('".$employee_code."','".$employee_name."','".$employee_gender."','".$employee_birthday."','".$employee_branch."','".$employee_department."','".$employee_position."','".$employee_national_id."','".$employee_issue_date."','".$employee_issue_by."','".$employee_address."','".$employee_phone."','".$employee_email."','".$employee_debt."','".$FinalFilenameFront."','".$employee_des."','".$employee_status."','".$employee_created_date."','".$employee_last_update."' )");
		$result['status'] = 200;
		$result["url"] = XC_URL."/uploads/doctors/".$FinalFilenameFront;
		$result["id"] = $FinalFilenameFront;
		echo json_encode($result);
	}
	public function updateEmployee(){
				
		global $db;
		$id = $_POST['employeeid'];
		$employee_code = $_POST['employee_code'];
		$employee_name = $_POST['employee_name'];
		// $employee_branch = $_POST['employee_branch'];
		// $employee_position = $_POST['employee_position'];
		$employee_address = $_POST['employee_address'];
		$employee_birthday = $_POST['employee_birthday'];
		$employee_birthday = date('Y-m-d', strtotime($employee_birthday));
		$employee_gender = $_POST['employee_gender'];
		$employee_phone = $_POST['employee_phone'];
		$employee_national_id = $_POST['employee_national_id'];
		$employee_issue_date = $_POST['employee_issue_date'];
		$employee_issue_date = date("Y-m-d", strtotime($employee_issue_date));
		$employee_issue_by = $_POST['employee_issue_by'];
		$employee_email = $_POST['employee_email'];
		$employee_department = $_POST['employee_department'];
		$employee_debt = '0.0';
		$employee_des =  $_POST['employee_des'];
		$employee_status = 1;
		$result = array();
		$employee_created_date = $employee_last_update = date('Y-m-d H:i:s');
		$expensions = array("jpeg","jpg","png");
		
		$db->query("SELECT * FROM hicrm_employees WHERE id = '".$id."'");
		if($db->num_row())
		{
		
			if(isset($_FILES['employee_image']))
			{
				$errors= array();
				$file_name = $_FILES['employee_image']['name'];
				$file_size =$_FILES['employee_image']['size'];
				$file_tmp =$_FILES['employee_image']['tmp_name'];
				$file_type=$_FILES['employee_image']['type'];
				$file_ext=strtolower(end(explode('.',$_FILES['employee_image']['name'])));
				$OriginalFilename = $FinalFilename = preg_replace('`[^a-z0-9-_.]`i','',$_FILES['employee_image']['name']); 
				$FinalFilenameFront = md5(time())."-".$FinalFilename;
				if(in_array($file_ext,$expensions)=== false){
					$errors[]="Extension not allowed, please choose a .png, .jpg file.";
				}
				if($file_size > 5242880){
					$errors[]='File size must be max 2Mb';
				}
				if(empty($errors)==true){
					move_uploaded_file($file_tmp,"./uploads/doctors/".$FinalFilenameFront);
					
				}else
				{
					$result["status"] = 500;
				}
				
			}
			
				
		$updateimage = ($FinalFilenameFront != "")? ", employee_image = '".$FinalFilenameFront."'" : "";
		$db->query("UPDATE hicrm_employees SET employee_code='".$employee_code."',employee_name='".$employee_name."',employee_gender='".$employee_gender."',employee_birthday='".$employee_birthday."',employee_department='".$employee_department."',employee_national_id='".$employee_national_id."',employee_issue_date='".$employee_issue_date."',employee_issue_by='".$employee_issue_by."',employee_address='".$employee_address."',employee_phone='".$employee_phone."',employee_email='".$employee_email."',employee_debt = '".$employee_debt."'".$updateimage.",employee_des = '".$employee_des."', employee_status = '".$employee_status."',employee_created_date='".$employee_created_date."',employee_last_update='".$employee_last_update."' WHERE id = '".$id."'");
		// echo $kq;
		// echo "UPDATE hicrm_employees SET employee_code='".$employee_code."',employee_name='".$employee_name."',employee_gender='".$employee_gender."',employee_birthday='".$employee_birthday."',employee_branch='".$employee_branch."',employee_department='".$employee_department."',employee_position='".$employee_position."',employee_national_id='".$employee_national_id."',employee_issue_date='".$employee_issue_date."',employee_issue_by='".$employee_issue_by."',employee_address='".$employee_address."',employee_phone='".$employee_phone."',employee_email='".$employee_email."',employee_debt = '".$employee_debt."'".$updateimage.",employee_des = '".$employee_des."', employee_status = '".$employee_status."',employee_created_date='".	$employee_created_date."',employee_last_update='".$employee_last_update."' WHERE id = '".$id."'";
		$result['status'] = 200;
		$result["url"] = XC_URL."/uploads/doctors/".$FinalFilenameFront;
		echo json_encode($result);
		}
		
		
	}
	public function duplicateEmployee()
	{
		global $db;
		$eid = $_POST['eid'];
		$result = array();
		$db->query("SELECT * FROM hicrm_employees ORDER BY id DESC LIMIT 1");
		$lastno = $db->fetch_object(true)->employee_code;
		$prefix = $this->helper->get_config("employee_prefix");
		//PREFIX1234567
		$lastno = substr($lastno,-7);
		$lastno = $lastno+1;
		$lastno = $prefix."".str_pad($lastno, 7, '0', STR_PAD_LEFT);
		$db->query("SELECT * FROM hicrm_employees WHERE id = '".$eid."' ORDER BY id DESC LIMIT 1");
		$oe = $db->fetch_object(true);
		$employee_created_date = $employee_last_update = date("Y:m:d H:i:s");
		
		$db->query("INSERT INTO hicrm_employees(employee_code, employee_name, employee_gender, employee_birthday, employee_branch, employee_department, employee_position, employee_national_id, employee_issue_date, employee_issue_by, employee_address, employee_phone, employee_email,employee_debt, employee_status, employee_created_date, employee_last_update) VALUES('".$lastno."','".$oe->employee_name."','".$oe->employee_gender."','".$oe->employee_birthday."','".$oe->employee_branch."','".$oe->employee_department."','".$oe->employee_position."','".$oe->employee_national_id."','".$oe->employee_issue_date."','".$oe->employee_issue_by."','".$oe->employee_address."','".$oe->employee_phone."','".$oe->employee_email."','".$oe->employee_debt."','".$oe->employee_status."','".$employee_created_date."','".$employee_last_update."' )");
		$result["status"] = 200;
		$result["new_employee_code"] = $lastno;
		echo json_encode($result);
	}
	
	public function deleteEmployee()
	{
		global $db;
		$eid = $_POST['eid'];
		$result = array();
		$db->query("SELECT * FROM hicrm_employees WHERE id = '".$eid."'");
		$db->fetch_object(true);
		if($db->num_row()){
			$db->query("UPDATE hicrm_employees SET employee_status = 99 WHERE id = '".$eid."'");
			
			$result["status"] = 200;
		}else{
			$result['message'] = "Không tìm thấy nhân viên này";
			$result["status"] = 500;
		}
		
		echo json_encode($result);
	}
	//end employee
	//======================== Categories API =================================//
	//Selected compobox edit_accounts
	public function cpbaccounts(){
		global $db;
		$result = array();
		$db->query("SELECT * FROM hicrm_accounts WHERE account_status = 1");
		$accounts = $db->fetch_object();
		$db->query("SELECT * FROM hicrm_accounts WHERE id = '".$_POST['id']."'");
		$row_account = $db->fetch_object(true);
		
		$data = '<option value = ""> Chọn loại </option>';
		
		foreach($accounts as $account){
			if($_POST['method'] == 'update'){
			$isSelected = ($account->id == $row_account->account_parent) ? "selected" : "" ;
			$data .= '<option value = "'.$account->id.'" '.$isSelected.'> '.$account->account_number.' - '.$account->account_name.' </option>';
			}else{
				
				$data .= '
				
				<option value = "'.$account->id.'"> '.$account->account_number.' - '.$account->account_name.' </option>';
			}
			
		}
		
		
			$result['status'] = 200;
			$result['data'] =  $data;
		echo json_encode($result);
		
	}
	
	//end
	//Category expense items
	public function category_expenseitems(){
		global $db;
		if($_POST['expense_parent'] != ''){
			$expense_parent = $_POST['expense_parent'];
		}else{
			$expense_parent = 0;
		}
		$result = array();
		if($_POST['method'] == "new"){
			$db->query("SELECT * FROM hicrm_expense_items WHERE expense_code = '".$_POST['expense_code']."' AND expense_status NOT IN(99) ");
			$db->fetch_object(true);
			if($db->num_row()){
				$result['message'] = "Mã khoản mục chi phí đã tồn tại";
				$result['status'] = 500;
			}else{
			
				$db->query("INSERT INTO hicrm_expense_items(expense_code, expense_name,expense_description, expense_parent,expense_status) VALUES ('".$_POST['expense_code']."','".$_POST['expense_name']."','".$_POST['expense_description']."','".$expense_parent."','1' )");
				$result['message'] = "Thêm thành công";
				$result['status'] = 200;
			}
		}elseif($_POST['method'] == "update"){
			
			$db->query("SELECT * FROM hicrm_expense_items WHERE id = '".$_POST['id']."'");
			
			$db->fetch_object(true);
				if($db->num_row()){
					
						$db->query("UPDATE hicrm_expense_items SET expense_code='".$_POST['expense_code']."',expense_name='".$_POST['expense_name']."',expense_description='".$_POST['expense_description']."',expense_parent='".$expense_parent."' WHERE id='".$_POST['id']."'");
						$result['message'] = "Sửa thành công";
						$result['status'] = 200;
					
				}else{
					$result['message'] = "Không tìm  khoản mục chi phí này";
					$result['status'] = 500;
				}
				
		}
		echo json_encode($result);
	}
	public function action_expenseitems(){
		global $db;
		//var_dump($_POST);
		$result = array();
		$db->query("SELECT * FROM hicrm_expense_items WHERE id = '".$_POST['id']."'");
		$db->fetch_object(true);
		if($db->num_row()){
			if($_POST['method'] == "active"){
				if($_POST['expense_status'] == 1){
					$db->query("UPDATE hicrm_expense_items SET expense_status = 2 WHERE id = '".$_POST['id']."'");
					$result['status'] = 200;
					$result['message'] = "Đã ngừng hoạt động";
				}else{
					$db->query("UPDATE hicrm_expense_items SET expense_status = 1 WHERE id = '".$_POST['id']."'");
					$result['status'] = 200;
					$result['message'] = "Đã hoạt động";
				}
			}elseif($_POST['method'] == "delete"){
					$db->query("UPDATE hicrm_expense_items SET expense_status = 99 WHERE id = '".$_POST['id']."'");
					$result['status'] = 200;
					$result['message'] = "Xóa thành công";
			}else{
				$result['message'] = "Không tìm thấy tác vụ thực hiện";
				$result['status'] = 500;
			}
		}else{
			$result['message'] = "Lỗi hệ thống. Không tìm khoản mục chi phí này";
			$result['status'] = 500;
		}
		echo json_encode($result);
	}
	public function cpbExpenseitem(){
		global $db;
		$result = array();
		$db->query("SELECT * FROM hicrm_expense_items WHERE expense_status NOT IN(99)");
		$row_expenses = $db->fetch_object();
		$data = '<option value="" disabled selected="selected" >Chọn </option>
					<option value="0">Mục gốc </option>';
			foreach($row_expenses as $row){
				if($_POST['method'] == 'update'){
					$isSelected = ($_POST['expense_parent'] == $row->id) ? 'selected="selected" ' : '';
					$data .= '<option value="'.$row->id.'" '.$isSelected.'>'.$row->expense_code.' - '.$row->expense_name.' </option>';
				}else{
					$data .= '<option value="'.$row->id.'">'.$row->expense_code.' - '.$row->expense_name.' </option>';
				}
			}
		
		$result['status'] = 200;
		$result['data'] = $data;
		echo json_encode($result);
	}
	//end expense
	//api show category product when edit category product
	public function cpbCategoryproduct(){
		global $db;
		$result = array();
		$db->query("SELECT * FROM hicrm_category_products WHERE cat_product_status NOT IN(99)");
		$row_cat_pr = $db->fetch_object();
		$db->query("SELECT * FROM hicrm_units WHERE unit_status NOT IN(99)");
		$cat_product_units = $db->fetch_object();
		$data_category = '<option disabled selected="selected" >Chọn danh mục </option>
					<option value="0">Danh mục gốc  </option>';
		$data_unit = '<option value="" disabled selected="selected" >Lựa chọn</option>';
			foreach($cat_product_units as $row_unit){
				if($_POST['method'] == 'update'){
					
				$isSelected = ($_POST['cat_product_unit'] == $row_unit->id) ? 'selected="selected" ' : '';
				$data_unit .= '<option value="'.$row_unit->id.'" '.$isSelected.'>'.$row_unit->unit_code.' - '.$row_unit->unit_name.' </option>';
				}else{
					$data_unit .= '<option value="'.$row_unit->id.'" >'.$row_unit->unit_code.' - '.$row_unit->unit_name.' </option>';
				}
			}
			foreach($row_cat_pr as $row){
				if($_POST['method'] == 'update'){
				$isSelected = ($_POST['cat_product_parent'] == $row->id) ? 'selected="selected" ' : '';
				$data_category .= '<option value="'.$row->id.'" '.$isSelected.'>'.$row->cat_product_code.' - '.$row->cat_product_name.' </option>';
				}else{
					$data_category .= '<option value="'.$row->id.'">'.$row->cat_product_code.' - '.$row->cat_product_name.' </option>';
				}
			}
		
		$result['status'] = 200;
		$result['data_category'] = $data_category;
		$result['data_unit'] = $data_unit;
		echo json_encode($result);
	}
	//end
	//Category template Type
	public function category_template_types(){
		if(isset($_POST['template_type_debt']) && $_POST['template_type_debt'] != ''){
			$template_type_debt = $_POST['template_type_debt'];
		}else{
			$template_type_debt = 0;
		}
		if(isset($_POST['template_type_to']) && $_POST['template_type_to'] != ''){
			$template_type_to = $_POST['template_type_to'];
		}else{
			$template_type_to = 0;
		}
		global $db;
		$result = array();
		if($_POST['method'] == "new"){
			$db->query("SELECT * FROM hicrm_template_types WHERE template_type_code = '".$_POST['template_type_code']."' AND template_type_status = '1' ");
			$db->fetch_object(true);
			if($db->num_row()){
				$result['message'] = "Mã loại chứng từ đã tồn tại";
				$result['status'] = 500;
			}else{
			
				$db->query("INSERT INTO hicrm_template_types(template_type_code, template_type_name,template_type_description, template_type_status) VALUES ('".$_POST['template_type_code']."','".$_POST['template_type_name']."','".$_POST['template_type_description']."','1' )");
				$result['message'] = "Thêm thành công";
				$result['status'] = 200;
			}
		}elseif($_POST['method'] == "duplicate")
		{
			$db->query("SELECT * FROM hicrm_template_types WHERE id = '".$_POST['id']."'");
			$db->fetch_object(true);
				if($db->num_row()){
					$db->query("SELECT * FROM hicrm_template_types WHERE template_type_code = '".$_POST['template_type_code']."' AND template_type_status NOT IN(99) ");
					$db->fetch_object(true);
					if($db->num_row()){
						$result['message'] = "Mã loại chứng từ đã tồn tại";
						$result['status'] = 500;
					}else{
						$db->query("INSERT INTO hicrm_template_types(template_type_code, template_type_name, template_type_description, template_type_status) VALUES ('".$_POST['template_type_code']."','".$_POST['template_type_name']."','".$_POST['template_type_description']."','1' )");
						$result['message'] = "Nhân bản thành công";
						$result['status'] = 200;
					}
					
				}else{
					$result['message'] = "Không tìm thấy loại chứng từ này này";
					$result['status'] = 500;
				}
		}elseif($_POST['method'] == "update"){
			
			$db->query("SELECT * FROM hicrm_template_types WHERE id = '".$_POST['id']."'");
			
			$db->fetch_object(true);
				if($db->num_row()){
					
						$db->query("UPDATE hicrm_template_types SET template_type_code='".$_POST['template_type_code']."',template_type_name='".$_POST['template_type_name']."',template_type_description='".$_POST['template_type_description']."' WHERE id='".$_POST['id']."'");
						$result['message'] = "Sửa thành công";
						$result['status'] = 200;
					
				}else{
					$result['message'] = "Không tìm thấy thấy loại chứng từ này";
					$result['status'] = 500;
				}
				
		}
		echo json_encode($result);
	}
	public function action_template_types(){
		global $db;
		//var_dump($_POST);
		$result = array();
		$db->query("SELECT * FROM hicrm_template_types WHERE id = '".$_POST['id']."'");
		$db->fetch_object(true);
		if($db->num_row()){
			if($_POST['method'] == "active"){
				if($_POST['template_type_status'] == 1){
					$db->query("UPDATE hicrm_template_types SET template_type_status = 2 WHERE id = '".$_POST['id']."'");
					$result['status'] = 200;
					$result['message'] = "Đã ngừng hoạt động";
				}else{
					$db->query("UPDATE hicrm_template_types SET template_type_status = 1 WHERE id = '".$_POST['id']."'");
					$result['status'] = 200;
					$result['message'] = "Đã hoạt động";
				}
			}elseif($_POST['method'] == "delete"){
					$db->query("UPDATE hicrm_template_types SET template_type_status = 99 WHERE id = '".$_POST['id']."'");
					$result['status'] = 200;
					$result['message'] = "Xóa thành công";
			}else{
				$result['message'] = "Không tìm thấy tác vụ thực hiện";
				$result['status'] = 500;
			}
		}else{
			$result['message'] = "Lỗi hệ thống. Không tìm loại chứng từ này";
			$result['status'] = 500;
		}
		echo json_encode($result);
	}
	
	//end
	//Category payment policies
	public function category_payment_policies(){
		global $db;
		if(isset($_POST['policy_comission']) && $_POST['policy_comission'] != ''){
			$policy_comission = $_POST['policy_comission'];
		}else{
			$policy_comission = 0.0;
		}
		$result = array();
		if($_POST['method'] == "new"){
			$db->query("SELECT * FROM hicrm_payment_policies WHERE policy_code = '".$_POST['policy_code']."' AND policy_status = '1' ");
			$db->fetch_object(true);
			if($db->num_row()){
				$result['message'] = "Mã điều khoản thanh toán đã tồn tại";
				$result['status'] = 500;
			}else{
				
				$db->query("INSERT INTO hicrm_payment_policies(policy_uid,policy_code, policy_title, policy_debt_day, policy_comission, policy_status) VALUES ('".$_SESSION['user']['id']."','".$_POST['policy_code']."','".$_POST['policy_title']."','".$_POST['policy_debt_day']."','".$policy_comission."','1' )");
				$result['message'] = "Thêm thành công";
				$result['status'] = 200;
			}
		}elseif($_POST['method'] == "duplicate"){
			$db->query("SELECT * FROM hicrm_payment_policies WHERE id = '".$_POST['id']."'");
			$db->fetch_object(true);
				if($db->num_row()){
					$db->query("SELECT * FROM hicrm_payment_policies WHERE policy_code = '".$_POST['policy_code']."' AND policy_status NOT IN(99) ");
					$db->fetch_object(true);
					if($db->num_row()){
						$result['message'] = "Mã điều khoản thanh toán đã tồn tại";
						$result['status'] = 500;
					}else{
						$db->query("INSERT INTO hicrm_payment_policies(policy_uid,policy_code, policy_title, policy_debt_day, policy_comission, policy_status) VALUES ('".$_SESSION['user']['id']."','".$_POST['policy_code']."','".$_POST['policy_title']."','".$_POST['policy_debt_day']."','".$policy_comission."','1' )");
						$result['message'] = "Nhân bản thành công";
						$result['status'] = 200;
					}
					
				}else{
					$result['message'] = "Không tìm thấy điều khoản thanh toán này";
					$result['status'] = 500;
				}
		}elseif($_POST['method'] == "update"){
			$db->query("SELECT * FROM hicrm_payment_policies WHERE id = '".$_POST['id']."'");
			$db->fetch_object(true);
				if($db->num_row()){
						$db->query("UPDATE hicrm_payment_policies SET  policy_uid='".$_SESSION['user']['id']."', policy_code='".$_POST['policy_code']."',policy_title='".$_POST['policy_title']."',policy_debt_day='".$_POST['policy_debt_day']."',policy_comission='".$policy_comission."',policy_status='1' WHERE id = '".$_POST['id']."'");
						$result['message'] = "Sửa thành công";
						$result['status'] = 200;
					
				}else{
					$result['message'] = "Không tìm thấy thấy điều khoản thanh toán này";
					$result['status'] = 500;
				}
				
		}
		echo json_encode($result);
	}
	public function action_payment_policies(){
		global $db;
		$result = array();
		$db->query("SELECT * FROM hicrm_payment_policies WHERE id = '".$_POST['id']."'");
		$db->fetch_object(true);
		if($db->num_row()){
			if($_POST['method'] == "active"){
				if($_POST['policy_status'] == 1){
					$db->query("UPDATE hicrm_payment_policies SET policy_status = 2 WHERE id = '".$_POST['id']."'");
					$result['status'] = 200;
					$result['message'] = "Đã ngừng hoạt động";
				}else{
					$db->query("UPDATE hicrm_payment_policies SET policy_status = 1 WHERE id = '".$_POST['id']."'");
					$result['status'] = 200;
					$result['message'] = "Đã hoạt động";
				}
			}elseif($_POST['method'] == "delete"){
					$db->query("UPDATE hicrm_payment_policies SET policy_status = 99 WHERE id = '".$_POST['id']."'");
					$result['status'] = 200;
					$result['message'] = "Xóa thành công";
			}else{
				$result['message'] = "Không tìm thấy tác vụ thực hiện";
				$result['status'] = 500;
			}
		}else{
			$result['message'] = "Lỗi hệ thống. Không tìm điều khoản thanh toán này";
			$result['status'] = 500;
		}
		echo json_encode($result);
	}
	//end
	//Category_spend_collectes
	public function category_spend_collectes(){
		
		global $db;
		if(isset($_POST['spend_collecte_active']) && $_POST['spend_collecte_active'] != ""){
			$spend_collecte_active = 1;
		}else{
			$spend_collecte_active = 0;
		}
		$result = array();
		if($_POST['method'] == "new"){
			$db->query("SELECT * FROM hicrm_spend_collectes WHERE spend_collecte_code = '".$_POST['spend_collecte_code']."' AND spend_collecte_status = '1' ");
			$db->fetch_object(true);
			if($db->num_row()){
				$result['message'] = "Mã Thu/Chi đã tồn tại";
				$result['status'] = 500;
			}else{
				
				$db->query("INSERT INTO hicrm_spend_collectes(spend_collecte_code, spend_collecte_name, spend_collecte_type, spend_collecte_active, spend_collecte_parent, spend_collecte_description, spend_collecte_status) VALUES ('".$_POST['spend_collecte_code']."','".$_POST['spend_collecte_name']."','".$_POST['spend_collecte_type']."','".$_POST['spend_collecte_active']."','".$_POST['spend_collecte_parent']."','".$_POST['spend_collecte_description']."','1' )");
				$result['message'] = "Thêm thành công";
				$result['status'] = 200;
			}
		}elseif($_POST['method'] == "duplicate"){
			$db->query("SELECT * FROM hicrm_spend_collectes WHERE id = '".$_POST['id']."'");
			$db->fetch_object(true);
				if($db->num_row()){
					$db->query("SELECT * FROM hicrm_spend_collectes WHERE spend_collecte_code = '".$_POST['spend_collecte_code']."' AND spend_collecte_status NOT IN(99) ");
					$db->fetch_object(true);
					if($db->num_row()){
						$result['message'] = "Mã Thu/Chi đã tồn tại";
						$result['status'] = 500;
					}else{
						$db->query("INSERT INTO hicrm_spend_collectes(spend_collecte_code, spend_collecte_name, spend_collecte_type, spend_collecte_active, spend_collecte_parent, spend_collecte_description, spend_collecte_status) VALUES ('".$_POST['spend_collecte_code']."','".$_POST['spend_collecte_name']."','".$_POST['spend_collecte_type']."','".$spend_collecte_active."','".$_POST['spend_collecte_parent']."','".$_POST['spend_collecte_description']."','1' )");
						$result['message'] = "Nhân bản thành công";
						$result['status'] = 200;
					}
					
				}else{
					$result['message'] = "Không tìm thấy Thu/Chi này";
					$result['status'] = 500;
				}
		}elseif($_POST['method'] == "update"){
			$db->query("SELECT * FROM hicrm_spend_collectes WHERE id = '".$_POST['id']."'");
			$db->fetch_object(true);
				if($db->num_row()){
						$db->query("UPDATE hicrm_spend_collectes SET spend_collecte_code='".$_POST['spend_collecte_code']."',spend_collecte_name='".$_POST['spend_collecte_name']."',spend_collecte_type='".$_POST['spend_collecte_type']."',spend_collecte_active='".$spend_collecte_active."',spend_collecte_parent='".$_POST['spend_collecte_parent']."',spend_collecte_description='".$_POST['spend_collecte_description']."' WHERE id = '".$_POST['id']."'");
						$result['message'] = "Sửa thành công";
						$result['status'] = 200;
					
				}else{
					$result['message'] = "Không tìm thấy Thu/Chi này";
					$result['status'] = 500;
				}
				
		}
		echo json_encode($result);
	}
	public function action_spend_collectes(){
		global $db;
		$result = array();
		$db->query("SELECT * FROM hicrm_spend_collectes WHERE id = '".$_POST['id']."'");
		$db->fetch_object(true);
		if($db->num_row()){
			if($_POST['method'] == "active"){
				if($_POST['spend_collecte_status'] == 1){
					$db->query("UPDATE hicrm_spend_collectes SET spend_collecte_status = 2 WHERE id = '".$_POST['id']."'");
					$result['status'] = 200;
					$result['message'] = "Đã ngừng hoạt động";
				}else{
					$db->query("UPDATE hicrm_spend_collectes SET spend_collecte_status = 1 WHERE id = '".$_POST['id']."'");
					$result['status'] = 200;
					$result['message'] = "Đã hoạt động";
				}
			}elseif($_POST['method'] == "delete"){
					$db->query("UPDATE hicrm_spend_collectes SET spend_collecte_status = 99 WHERE id = '".$_POST['id']."'");
					$result['status'] = 200;
					$result['message'] = "Xóa thành công";
			}else{
				$result['message'] = "Không tìm thấy tác vụ thực hiện";
				$result['status'] = 500;
			}
		}else{
			$result['message'] = "Lỗi hệ thống. Không tìm Thu/Chi này";
			$result['status'] = 500;
		}
		echo json_encode($result);
	}
	public function cpbSpendcollecte(){
		global $db;
		$db->query("SELECT * FROM hicrm_spend_collectes WHERE spend_collecte_status NOT IN(99)");
		$row_spend_collectes = $db->fetch_object();
		$data = '<option value="" disabled selected="selected" >Lựa chọn </option>';
		$result = array();
		foreach($row_spend_collectes as $row){
			if($_POST['method'] == 'update' || $_POST['method'] == 'duplicate' ){
				$isSelected = ($_POST['spend_collecte_parent'] == $row->id) ? 'selected="selected"' : '';
					
				$data .= '<option value="'.$row->id.'" '.$isSelected.' > '.$row->spend_collecte_code.' - '.$row->spend_collecte_name.' </option>';
				
				$result['status'] = 200;
				$result['data'] = $data;
			}elseif($_POST['method'] == 'new'){
				$data .= '<option value="'.$row->id.'"  > '.$row->spend_collecte_code.' - '.$row->spend_collecte_name.' </option>';
				$result['status'] = 200;
				$result['data'] = $data;
			}else{
				$result['status'] = 404;
				$result['message'] = "Dữ liệu trống";
			}
		}
		echo json_encode($result);
		
		
	}
	//end
	//Category_product
	public function category_products(){
		global $db;
		$result = array();
		if($_POST['method'] == "new"){
			$db->query("SELECT * FROM hicrm_category_products WHERE cat_product_code = '".$_POST['cat_product_code']."' AND cat_product_status = '1' ");
			$db->fetch_object(true);
			if($db->num_row()){
				$result['message'] = "Mã danh mục sản phẩm đã tồn tại";
				$result['status'] = 500;
			}else{
				$db->query("INSERT INTO hicrm_category_products(cat_product_code, cat_product_name,cat_product_unit,cat_product_description, cat_product_status, cat_product_parent) VALUES ('".$_POST['cat_product_code']."','".$_POST['cat_product_name']."','".$_POST['cat_product_unit']."','".$_POST['cat_product_description']."','1','".$_POST['cat_product_parent']."' )");
				$result['message'] = "Thêm thành công";
				$result['status'] = 200;
			}
		}elseif($_POST['method'] == "duplicate"){
			$db->query("SELECT * FROM hicrm_category_products WHERE id = '".$_POST['id']."'");
			$db->fetch_object(true);
				if($db->num_row()){
					$db->query("SELECT * FROM hicrm_category_products WHERE cat_product_code = '".$_POST['cat_product_code']."' AND cat_product_status NOT IN(99) ");
					$db->fetch_object(true);
					if($db->num_row()){
						$result['message'] = "Mã danh mục sản phẩm đã tồn tại";
						$result['status'] = 500;
					}else{
						$db->query("INSERT INTO hicrm_category_products(cat_product_code, cat_product_name, cat_product_unit, cat_product_description, cat_product_status, cat_product_parent) VALUES ('".$_POST['cat_product_code']."','".$_POST['cat_product_name']."','".$_POST['cat_product_unit']."','".$_POST['cat_product_description']."','1','".$_POST['cat_product_parent']."' )");
						$result['message'] = "Nhân bản thành công";
						$result['status'] = 200;
					}
					
				}else{
					$result['message'] = "Không tìm thấy danh mục sản phẩm này";
					$result['status'] = 500;
				}
		}elseif($_POST['method'] == "update"){
			$db->query("SELECT * FROM hicrm_category_products WHERE id = '".$_POST['id']."'");
			$db->fetch_object(true);
				if($db->num_row()){
						$db->query("UPDATE hicrm_category_products SET cat_product_code='".$_POST['cat_product_code']."',cat_product_name='".$_POST['cat_product_name']."',cat_product_unit='".$_POST['cat_product_unit']."',cat_product_description='".$_POST['cat_product_description']."',cat_product_parent='".$_POST['cat_product_parent']."' WHERE id = '".$_POST['id']."'");
						$result['message'] = "Sửa thành công";
						$result['status'] = 200;
					
				}else{
					$result['message'] = "Không tìm thấy danh mục sản phẩm này";
					$result['status'] = 500;
				}
				
		}
		echo json_encode($result);
		
	}
	public function action_products(){
		global $db;
		$result = array();
		$db->query("SELECT * FROM hicrm_category_products WHERE id = '".$_POST['id']."'");
		$db->fetch_object(true);
		if($db->num_row()){
			if($_POST['method'] == "active"){
				if($_POST['cat_product_status'] == 1){
					$db->query("UPDATE hicrm_category_products SET cat_product_status = 2 WHERE id = '".$_POST['id']."'");
					$result['status'] = 200;
					$result['message'] = "Đã ngừng hoạt động";
				}else{
					$db->query("UPDATE hicrm_category_products SET cat_product_status = 1 WHERE id = '".$_POST['id']."'");
					$result['status'] = 200;
					$result['message'] = "Đã hoạt động";
				}
			}elseif($_POST['method'] == "delete"){
					$db->query("UPDATE hicrm_category_products SET cat_product_status = 99 WHERE id = '".$_POST['id']."'");
					$result['status'] = 200;
					$result['message'] = "Xóa thành công";
			}else{
				$result['message'] = "Không tìm thấy tác vụ thực hiện";
				$result['status'] = 500;
			}
		}else{
			$result['message'] = "Lỗi hệ thống. Không tìm danh mục sản phẩm này";
			$result['status'] = 500;
		}
		echo json_encode($result);
	}
	//Currency
	public function category_currencies(){
		global $db;
		var_dump($_POST);
		$result = array();
		if($_POST['method'] == "new"){
			$db->query("SELECT * FROM hicrm_currencies WHERE currency_code = '".$_POST['currency_code']."' AND currency_status = '1' ");
			$db->fetch_object(true);
			if($db->num_row()){
				$result['message'] = "Mã loại tiền đã tồn tại";
				$result['status'] = 500;
			}else{
				$db->query("INSERT INTO hicrm_currencies(currency_code, currency_name, currency_rate, currency_type, currency_status) VALUES ('".$_POST['currency_code']."','".$_POST['currency_name']."','".$_POST['currency_rate']."','".$_POST['currency_type']."','1' )");
				$result['message'] = "Thêm thành công";
				$result['status'] = 200;
			}
		}elseif($_POST['method'] == "update"){
			$db->query("SELECT * FROM hicrm_currencies WHERE id = '".$_POST['id']."'");
			$db->fetch_object(true);
				if($db->num_row()){
						$db->query("UPDATE hicrm_currencies SET currency_code='".$_POST['currency_code']."',currency_name='".$_POST['currency_name']."',currency_rate='".$_POST['currency_rate']."',currency_type='".$_POST['currency_type']."' WHERE id = '".$_POST['id']."'");
						$result['message'] = "Sửa thành công";
						$result['status'] = 200;
				}else{
					$result['message'] = "Không tìm thấy đơn vị tính này";
					$result['status'] = 500;
				}
				
		}
		echo json_encode($result);
	}
	public function action_currencies(){
		global $db;
		$result = array();
		$db->query("SELECT * FROM hicrm_currencies WHERE id = '".$_POST['id']."'");
		$db->fetch_object(true);
		if($db->num_row()){
			if($_POST['method'] == "active"){
				if($_POST['currency_status'] == 1){
					$db->query("UPDATE hicrm_currencies SET currency_status = 2 WHERE id = '".$_POST['id']."'");
					$result['status'] = 200;
					$result['message'] = "Đã ngừng hoạt động";
				}else{
					$db->query("UPDATE hicrm_currencies SET currency_status = 1 WHERE id = '".$_POST['id']."'");
					$result['status'] = 200;
					$result['message'] = "Đã hoạt động";
				}
			}elseif($_POST['method'] == "delete"){
					$db->query("UPDATE hicrm_currencies SET currency_status = 99 WHERE id = '".$_POST['id']."'");
					$result['status'] = 200;
					$result['message'] = "Xóa thành công";
			}else{
				$result['message'] = "Không tìm thấy tác vụ thực hiện";
				$result['status'] = 500;
			}
		}else{
			$result['message'] = "Lỗi hệ thống. Không tìm thấy tài khoản ngân hàng";
			$result['status'] = 500;
		}
		echo json_encode($result);
	}
	public function cpbCurrency(){
		global $db;
		$db->query("SELECT * FROM hicrm_accounts WHERE account_status NOT IN(99)");
		$row_accounts = $db->fetch_object();
		$data = '<option value="" disabled selected="selected" >Lựa chọn </option>';
		$result = array();
		$currency_type = $_POST['currency_type'];
		foreach($row_accounts as $row){
			if($_POST['method'] == 'update'){
				$isSelected = ($currency_type == $row->id) ? 'selected="selected"' : '';
					
				$data .= '<option value="'.$row->id.'" '.$isSelected.' > '.$row->account_number.' - '.$row->account_name.' </option>';
				
				$result['status'] = 200;
				$result['data'] = $data;
			}elseif($_POST['method'] == 'new'){
				$data .= '<option value="'.$row->id.'"  > '.$row->account_number.' - '.$row->account_name.' </option>';
				$result['status'] = 200;
				$result['data'] = $data;
			}else{
				$result['status'] = 404;
				$result['message'] = "Dữ liệu trống";
			}
		}
		echo json_encode($result);
		
		
	}
	//end
	//Units
	public function category_units(){
		global $db;
		$result = array();
		if($_POST['method'] == "new"){
			$db->query("SELECT * FROM hicrm_units WHERE unit_code = '".$_POST['unit_code']."' AND unit_status = '1' ");
			$db->fetch_object(true);
			if($db->num_row()){
				$result['message'] = "Mã đơn vị tính đã tồn tại";
				$result['status'] = 500;
			}else{
				$db->query("INSERT INTO hicrm_units(unit_code, unit_name, unit_description, unit_status) VALUES ('".$_POST['unit_code']."','".$_POST['unit_name']."','".$_POST['unit_description']."','1' )");
				$result['message'] = "Thêm thành công";
				$result['status'] = 200;
			}
		}elseif($_POST['method'] == "update"){
			$db->query("SELECT * FROM hicrm_units WHERE id = '".$_POST['id']."'");
			$db->fetch_object(true);
				if($db->num_row()){
						$db->query("UPDATE hicrm_units SET unit_code='".$_POST['unit_code']."',unit_name='".$_POST['unit_name']."',unit_description='".$_POST['unit_description']."',unit_status='1' WHERE id = '".$_POST['id']."'");
						$result['message'] = "Sửa thành công";
						$result['status'] = 200;
					
				}else{
					$result['message'] = "Không tìm thấy đơn vị tính này";
					$result['status'] = 500;
				}
		}
		echo json_encode($result);
	}
	public function action_units(){
		global $db;
		$result = array();
		$db->query("SELECT * FROM hicrm_units WHERE id = '".$_POST['id']."'");
		$db->fetch_object(true);
		if($db->num_row()){
			if($_POST['method'] == "active"){
				if($_POST['unit_status'] == 1){
					$db->query("UPDATE hicrm_units SET unit_status = 2 WHERE id = '".$_POST['id']."'");
					$result['status'] = 200;
					$result['message'] = "Đã ngừng hoạt động";
				}else{
					$db->query("UPDATE hicrm_units SET unit_status = 1 WHERE id = '".$_POST['id']."'");
					$result['status'] = 200;
					$result['message'] = "Đã hoạt động";
				}
			}elseif($_POST['method'] == "delete"){
					$db->query("UPDATE hicrm_units SET unit_status = 99 WHERE id = '".$_POST['id']."'");
					$result['status'] = 200;
					$result['message'] = "Xóa thành công";
			}else{
				$result['message'] = "Không tìm thấy tác vụ thực hiện";
				$result['status'] = 500;
			}
		}else{
			$result['message'] = "Lỗi hệ thống. Không tìm thấy tài khoản ngân hàng";
			$result['status'] = 500;
		}
		echo json_encode($result);
	}
	//End Units
	//Bankaccounts
	public function category_bankaccounts(){
		global $db;
		$result = array();
		
		if($_POST['method'] == "new"){
			$db->query("SELECT * FROM hicrm_bank_accounts WHERE ba_account = '".$_POST['ba_account']."' AND ba_status = '1' ");
			$db->fetch_object(true);
			if($db->num_row()){
				$result['message'] = "Số tài khoản ngân hàng đã tồn tại";
				$result['status'] = 500;
			}else{
				$db->query("INSERT INTO hicrm_bank_accounts(bank_id, ba_account,ba_holder,ba_branch,ba_description,ba_status,ba_primary) VALUES('".$_POST['bank_id']."','".$_POST['ba_account']."','".$_POST['ba_holder']."','".$_POST['ba_branch']."','".$_POST['ba_description']."', '1','0')");
				$result['message'] = "Thêm thành công";
				$result['status'] = 200;
			}
		}elseif($_POST['method'] == "duplicate"){
			$db->query("SELECT * FROM hicrm_bank_accounts WHERE id = '".$_POST['id']."'");
			$db->fetch_object(true);
				if($db->num_row()){
					$db->query("SELECT * FROM hicrm_bank_accounts WHERE ba_account = '".$_POST['ba_account']."' AND ba_status = NOT IN(99) ");
					$db->fetch_object(true);
					if($db->num_row()){
						$result['message'] = "Số tài khoản ngân hàng đã tồn tại";
						$result['status'] = 500;
					}else{
						$db->query("INSERT INTO hicrm_bank_accounts(bank_id, ba_account,ba_holder,ba_branch,ba_description,ba_status,ba_primary) VALUES('".$_POST['bank_id']."','".$_POST['ba_account']."','".$_POST['ba_holder']."','".$_POST['ba_branch']."','".$_POST['ba_description']."', '1','0')");
						$result['message'] = "Nhân bản thành công";
						$result['status'] = 200;
					}
					
				}else{
					$result['message'] = "Không tìm thấy tài khoản ngân hàng này";
					$result['status'] = 500;
				}
		}elseif($_POST['method'] == "update"){
			$db->query("SELECT * FROM hicrm_bank_accounts WHERE id = '".$_POST['id']."'");
			$db->fetch_object(true);
				if($db->num_row()){
					$db->query("UPDATE hicrm_bank_accounts SET bank_id = '".$_POST['bank_id']."',ba_account = '".$_POST['ba_account']."',ba_holder = '".$_POST['ba_holder']."',ba_branch = '".$_POST['ba_branch']."',ba_description = '".$_POST['ba_description']."' WHERE id = '".$_POST['id']."'");
					$result['message'] = "Sửa thành công";
					$result['status'] = 200;
				}else{
					$result['message'] = "Không tìm thấy tài khoản ngân hàng này";
					$result['status'] = 500;
				}
		}else{
				$result['message'] = "Không tìm thấy tác vụ thực hiện";
				$result['status'] = 500;
			}
		
		echo json_encode($result);
	}
	public function action_bankaccounts(){
		global $db;
		$result = array();
		$db->query("SELECT * FROM hicrm_bank_accounts WHERE id = '".$_POST['id']."'");
		$db->fetch_object(true);
		if($db->num_row()){
			if($_POST['method'] == "active"){
				if($_POST['ba_status'] == 1){
					$db->query("UPDATE hicrm_bank_accounts SET ba_status = 2 WHERE id = '".$_POST['id']."'");
					$result['status'] = 200;
					$result['message'] = "Đã ngừng hoạt động";
				}else{
					$db->query("UPDATE hicrm_bank_accounts SET ba_status = 1 WHERE id = '".$_POST['id']."'");
					$result['status'] = 200;
					$result['message'] = "Đã hoạt động";
				}
			}elseif($_POST['method'] == "delete"){
					$db->query("UPDATE hicrm_bank_accounts SET ba_status = 99 WHERE id = '".$_POST['id']."'");
					$result['status'] = 200;
					$result['message'] = "Xóa thành công";
			}else{
				$result['message'] = "Không tìm thấy tác vụ thực hiện";
				$result['status'] = 500;
			}
		}else{
			$result['message'] = "Lỗi hệ thống. Không tìm thấy tài khoản ngân hàng";
			$result['status'] = 500;
		}
		echo json_encode($result);
	}
	//api combobox Ten ngan hang muc EDIT
	public function cmpAccountbank(){
		global $db;
		$db->query("SELECT * FROM hicrm_banks WHERE bank_status NOT IN(99)");
		$row_banks = $db->fetch_object();
		$data = '<option disabled selected="selected"> Chọn ngân hàng </option>';
		$result = array();
		foreach($row_banks as $bank){
			if($_POST['method'] == 'update'){
				$bank_name = ($bank->bank_code) ? $bank->bank_code ."&nbsp;-&nbsp;".$bank->bank_name : "" .$bank->bank_name; 
				$isSelected = ($_POST['bankid'] == $bank->id) ? 'selected="selected"' : '';
					
				$data .= '<option value="'.$bank->id.'" '.$isSelected.' > '.$bank_name.' </option>';
			}elseif($_POST['method'] == 'new'){
				$bank_name = ($bank->bank_code) ? $bank->bank_code ."&nbsp;-&nbsp;".$bank->bank_name : "" .$bank->bank_name; 
				$data .= '<option value="'.$bank->id.'" > '.$bank_name.' </option>';
			}elseif($_POST['method'] == 'duplicate'){
				$bank_name = ($bank->bank_code) ? $bank->bank_code ."&nbsp;-&nbsp;".$bank->bank_name : "" .$bank->bank_name; 
				$isSelected = ($_POST['bankid'] == $bank->id) ? 'selected="selected"' : '';
					
				$data .= '<option value="'.$bank->id.'" '.$isSelected.' > '.$bank_name.' </option>';
			}else{
				$result['status'] = 200;
				$result['message'] = "Dữ liệu trống";
			}
		}
			$result['status'] = 200;
			$result['data'] = $data;
			echo json_encode($result);
	}
	//end Bankaccounts
	//Departments
	public function category_departments(){
		global $db;
		$result = array();
		
		if($_POST['method'] == "new"){
			$db->query("SELECT * FROM hicrm_departments WHERE depart_name = '".$_POST['department_name']."' AND depart_status = '1' ");
			$db->fetch_object(true);
			if($db->num_row()){
				$result['message'] = "Tên phòng ban đã tồn tại";
				$result['status'] = 500;
			}else{
				$db->query("INSERT INTO hicrm_departments(depart_name, depart_status) VALUES('".$_POST['department_name']."', '1')");
				$result['message'] = "Thêm thành công";
				$result['status'] = 200;
			}
		}elseif($_POST['method'] == "update"){
			$db->query("SELECT * FROM hicrm_departments WHERE id = '".$_POST['id']."'");
			$db->fetch_object(true);
				if($db->num_row()){
					$db->query("UPDATE hicrm_departments SET depart_name = '".$_POST['department_name']."' WHERE id = '".$_POST['id']."'");
					$result['message'] = "Sửa thành công";
					$result['status'] = 200;
				}else{
					$result['message'] = "Không tìm thấy phòng ban này";
					$result['status'] = 500;
				}
		}else{
				$result['message'] = "Không tìm thấy tác vụ thực hiện";
				$result['status'] = 500;
			}
		
		echo json_encode($result);
	}
	public function action_departments(){
		global $db;
		$result = array();
		$db->query("SELECT * FROM hicrm_departments WHERE id = '".$_POST['id']."'");
		$db->fetch_object(true);
		if($db->num_row()){
			if($_POST['method'] == 'delete'){
				$db->query("UPDATE hicrm_departments SET depart_status = '99' WHERE id = '".$_POST['id']."'");
				$result['message'] = "Xóa thành công";
				$result['status'] = 200;
			}else{
				$result['message'] = "Không tìm thấy tác vụ thực hiện";
				$result['status'] = 500;
			}
		}else{
			$result['message'] = "Không tìm thấy phòng ban này";
			$result['status'] = 500;
		}
		echo json_encode($result);
	}
	public function getdepartdata()
	{
		global $db;
		$result = array();
		$id = $_POST['id'];
		$db->query("SELECT * FROM hicrm_departments WHERE id = '".$id."' ORDER BY id DESC LIMIT 1");
		if($db->num_row())
		{
			$depart = $db->fetch_object(true);
			$result["data"]["name"] = $depart->depart_name;
			$result["status"] = 200;
		}
		else
		{
			$result["status"] = 404;
			$result["message"] = "Không tìm thấy phòng ban này!";
		}
		echo json_encode($result);
	}
	// end Departments
	//Customers group
	public function customergroup(){
		global $db;
		$cgid = $_POST['gid'];
		$method = $_POST['method'];
		$group_name = $_POST['group_name'];
		$group_code = $_POST['group_code'];
		$group_color = $_POST['group_color'];
		$group_description = $_POST['group_description'];
		$group_status = 1;
		$result = array();
		if($method == 'new'){
			$db->query("SELECT * FROM hicrm_customer_groups WHERE group_code = '".$group_code."'");
			$db->fetch_object(true);
			if($db->num_row()){
				$result['message'] = "Đã tồn tại mã khách hàng";
				$result['status'] = 500;
			}else{
				$db->query("INSERT INTO hicrm_customer_groups(group_code, group_name, group_color, group_description, group_status) VALUES ('".$group_code ."','".$group_name."','".$group_color."','".$group_description."','".$group_status."') ");
				$result["message"] = "Thêm thành công";
				$result['status'] = 200;
			}
		}elseif($method == "update"){
				$db->query("SELECT * FROM hicrm_customer_groups WHERE id = '".$cgid."'");
				$db->fetch_object(true);
				if($db->num_row()){
					$db->query("UPDATE hicrm_customer_groups SET group_code='".$group_code."',group_name='".$group_name."',group_color='".$group_color."',group_description='".$group_description."',group_status='".$group_status."' WHERE id = '".$cgid."'");
					$result["message"] = "Cập nhật thành công";
					$result['status'] = 200;
				}else{
					$result['message'] = " Không tồn tại khách hàng";
					$result['status'] = 500;
				}
		}elseif($method == 'delete'){
				$db->query("SELECT * FROM hicrm_customer_groups WHERE id = '".$cgid."'");
				$db->fetch_object(true);
				if($db->num_row()){
					$db->query("UPDATE hicrm_customer_groups SET group_status = 99 WHERE id = '".$cgid."'");
					$result['message'] = "Xóa thành công";
					$result["status"] = 200;
				}else{
					$result['message'] = " Không tồn tại khách hàng";
					$result['status'] = 500;
				}
		}else{
			$result['message'] = " Lỗi hệ thống";
			$result['status'] = 500;
		}
		echo json_encode($result);
	}
	public function actioncustomergroup(){
		global $db;
		$result = array();
		$db->query("SELECT * FROM hicrm_customer_groups WHERE id = '".$_POST['gid']."'");
		$db->fetch_object(true);
		if($db->num_row()){
			if($_POST['method'] == "active"){
				if($_POST['group_status'] == 1){
					$db->query("UPDATE hicrm_customer_groups SET group_status = 2 WHERE id = '".$_POST['gid']."'");
					$result['status'] = 200;
					$result['message'] = "Đã ngừng hoạt động";
				}else{
					$db->query("UPDATE hicrm_customer_groups SET group_status = 1 WHERE id = '".$_POST['gid']."'");
					$result['status'] = 200;
					$result['message'] = "Đã hoạt động";
				}
			}elseif($_POST['method'] == "delete"){
					$db->query("UPDATE hicrm_customer_groups SET group_status = 99 WHERE id = '".$_POST['gid']."'");
					$result['status'] = 200;
					$result['message'] = "Xóa thành công";
			}else{
				$result['message'] = "Không tìm thấy tác vụ thực hiện";
				$result['status'] = 500;
			}
		}else{
			$result['message'] = "Lỗi hệ thống";
			$result['status'] = 500;
		}
		echo json_encode($result);

	}
	
	//========================  Accounts =================================//
	public function category_accounts(){
		global $db;
		$method = $_POST['method'];
		$id = $_POST['aid'];
		
		$result = array();
	if($method == "new"){
		$db->query("SELECT * FROM hicrm_accounts WHERE account_number = '".$_POST['account_number']."'");
		$db->fetch_object(true);
		if($db->num_row()){
			$result['message'] = "Số tài khoản đã tồn tại";
			$result['status'] = 500;
			
		}else{
			$db->query("INSERT INTO hicrm_accounts(account_number, account_name, account_type, account_name_en, account_description, account_status, account_parent) VALUES ('".$_POST['account_number']."','".$_POST['account_name']."','".$_POST['account_type']."','".$_POST['account_name_en']."','".$_POST['account_description']."','1','".$_POST['account_parent']."')");
			$result['message'] = "Thêm thành công";
			$result['status'] = 200;
		}
	}elseif($method == "update"){
		$db->query("SELECT * FROM hicrm_accounts WHERE id = '".$id."'");
		$db->fetch_object(true);
		if($db->num_row()){
			$db->query("UPDATE hicrm_accounts SET account_number='".$_POST['account_number']."',account_name='".$_POST['account_name']."',account_type='".$_POST['account_type']."',account_name_en='".$_POST['account_name_en']."',account_description='".$_POST['account_description']."',account_status='1',account_parent='".$_POST['account_parent']."' WHERE id = '".$id."'");
			$result['message'] = "Sửa thành công";
			$result['status'] = 200;
		}else{
			$result['message'] = "Số tài khoản không tồn tại";
			$result['status'] = 500;
		}
	}else{
		$result['status'] = 404;
		$result['message'] = "Không tìm thấy tác vụ thực hiện";
	}
	echo json_encode($result);
	}
	public function actionaccount(){
		global $db;
		$result = array();
		$db->query("SELECT * FROM hicrm_accounts WHERE id = '".$_POST['aid']."'");
		$db->fetch_object(true);
		if($db->num_row()){
			if($_POST['method'] == 'active'){
				if($_POST['account_status'] == 1){
					$db->query("UPDATE hicrm_accounts SET account_status = 2 WHERE id = '".$_POST['aid']."'");
					$result['message'] = "Đã ngừng hoạt động";
					$result['status'] = 200;
				}elseif($_POST['account_status'] == 2){
					$db->query("UPDATE hicrm_accounts SET account_status = 1 WHERE id = '".$_POST['aid']."'");
					$result['message'] = "Đã hoạt động";
					$result['status'] = 200;
				}else{
					$result['message'] = "Không tìm thấy tác vụ thực hiện";
					$result['status'] = 500;
				}
			}elseif($_POST['method'] == 'delete'){
				$db->query("UPDATE hicrm_accounts SET account_status = 99 WHERE id = '".$_POST['aid']."'");
				$result['message'] = "Xóa thành công";
				$result["status"] = 200;
			}else{
				$result['message'] = "Không tìm thấy tác vụ thực hiện";
				$result['status'] = 500;
			}
		}
		echo json_encode($result);
	}
	public function deleteaccount(){}
	
	
	
	//======================== End Accounts =================================//
	
	//======================== Supplies  =================================//
	public function category_supplies(){
		global $db;
		$method = $_POST['method'];
		$id = $_POST['id'];
		
		$result = array();
		if($method == "new"){
			$db->query("SELECT * FROM hicrm_supplies WHERE supplie_code = '".$_POST['supplie_code']."'");
			$db->fetch_object(true);
			if($db->num_row()){
				$result['message'] = "Mã nhóm đã tồn tại";
				$result['status'] = 500;
				
			}else{
				$db->query("INSERT INTO hicrm_supplies(supplie_code, supplie_name, supplie_status, supplie_parent) VALUES ('".$_POST['supplie_code']."','".$_POST['supplie_name']."','1','".$_POST['supplie_parent']."')");
				$result['message'] = "Thêm thành công";
				$result['status'] = 200;
			}
		}elseif($method == "duplicate"){
			$db->query("SELECT * FROM hicrm_supplies WHERE supplie_code = '".$_POST['supplie_code']."'");
			$db->fetch_object(true);
			if($db->num_row()){
				$result['message'] = "Mã nhóm đã tồn tại";
				$result['status'] = 500;
				
			}else{
				$db->query("INSERT INTO hicrm_supplies(supplie_code, supplie_name, supplie_status, supplie_parent) VALUES ('".$_POST['supplie_code']."','".$_POST['supplie_name']."','1','".$_POST['supplie_parent']."')");
				$result['message'] = "Nhân bản thành công";
				$result['status'] = 200;
			}
		}elseif($method == "update"){
			$db->query("SELECT * FROM hicrm_supplies WHERE id = '".$id."'");
			$db->fetch_object(true);
				if($db->num_row()){
					$db->query("UPDATE hicrm_supplies SET supplie_code='".$_POST['supplie_code']."',supplie_name='".$_POST['supplie_name']."',supplie_status='1',supplie_parent='".$_POST['supplie_parent']."' WHERE id = '".$id."'");
					$result['message'] = "Sửa thành công";
					$result['status'] = 200;
				}else{
					$result['message'] = "Số tài khoản không tồn tại";
					$result['status'] = 500;
				}
		}else{
			$result['status'] = 404;
			$result['message'] = "Không tìm thấy tác vụ thực hiện";
		}
	echo json_encode($result);
	}
	public function action_supplies(){
		global $db;
		$result = array();
		$db->query("SELECT * FROM hicrm_supplies WHERE id = '".$_POST['id']."'");
		$db->fetch_object(true);
		if($db->num_row()){
			if($_POST['method'] == 'active'){
				if($_POST['supplie_status'] == 1){
					$db->query("UPDATE hicrm_supplies SET supplie_status = 2 WHERE id = '".$_POST['id']."'");
					$result['message'] = "Đã ngừng hoạt động";
					$result['status'] = 200;
				}elseif($_POST['supplie_status'] == 2){
					$db->query("UPDATE hicrm_supplies SET supplie_status = 1 WHERE id = '".$_POST['id']."'");
					$result['message'] = "Đã hoạt động";
					$result['status'] = 200;
				}else{
					$result['message'] = "Không tìm thấy tác vụ thực hiện";
					$result['status'] = 500;
				}
			}elseif($_POST['method'] == 'delete'){
				$db->query("UPDATE hicrm_supplies SET supplie_status = 99 WHERE id = '".$_POST['id']."'");
				$result['message'] = "Xóa thành công";
				$result["status"] = 200;
			}else{
				$result['message'] = "Không tìm thấy tác vụ thực hiện";
				$result['status'] = 500;
			}
		}else{
			$result['message'] = "Không tồn tại nhóm vật tư";
			$result['status'] = 500;
		}
		echo json_encode($result);
	}
	//======================== END Supplies  =================================//
	//======================== End Categories API =================================//
	//======================== Bookings API =================================//
	public function addbookings(){
		
		$event_assign_to = implode(",",$_POST['event_assign_to']);
		global $db;
		$result = array();
		$event_time_from = date("Y-m-d H:i:s", strtotime($_POST['event_from']));
		$event_time_to = date("Y-m-d H:i:s", strtotime($_POST['event_to']));
		
		$db->query("INSERT INTO hicrm_bookings(event_created_by, event_assign_to, event_host, event_time_from, event_time_to, event_title, event_description, event_type) VALUES ('".$_SESSION['user']['id']."', '".$event_assign_to."', '".$_POST['event_host']."', '".$event_time_from."', '".$event_time_to."', '".$_POST['event_title']."', '".$_POST['event_description']."', '".$_POST['event_type']."') ");
		$result['message'] = "Đặt lịch thành công";
		$result['status'] = 200;
		echo json_encode($result);
	}
	//======================== END Bookings API =================================//
	public function filterCustomer(){
		global $db;
		$keywork = $_POST['keywork'];
		$group_customer = $_POST['group_customer'];
		$status_customer = $_POST['status_customer'];
		if($keywork != ''){
			$db->query("SELECT * FROM  hicrm_customers WHERE customer_name LIKE '%".$keyword."%' OR customer_code LIKE '%".$keyword."%' OR customer_phone LIKE '%".$keyword."%' OR customer_email LIKE '%".$keyword."%'");
			
		}
		if(isset($group_customer) && $group_customer != 0){
			$customer_group = $_GET['customer_group'];
			$db->query("SELECT * FROM  hicrm_customers WHERE customer_group = '".$customer_group."'");
			return true;
		}
		if(isset($status_customer) && $status_customer != 0){
			$customer_status = $_GET['customer_status'];
			$db->query(" SELECT * FROM  hicrm_customers WHERE customer_status = '".$customer_status."'");
			return true;
		}
		
	}
    public function login()
    {
        global $db;
        @error_reporting(0);
        while (ob_get_level()) { @ob_end_clean(); }
        header('Content-Type: application/json; charset=utf-8');
        header('Cache-Control: no-store');
        $result = array('success' => false, 'status' => 500, 'message' => 'Thông tin tài khoản hoặc mật khẩu không chính xác.');
        $csrf = isset($_POST['csrf']) ? $_POST['csrf'] : '';
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !is_string($csrf) || empty($_SESSION['login_csrf']) || !hash_equals($_SESSION['login_csrf'], $csrf)) {
            $result['message'] = 'Phiên đăng nhập không hợp lệ. Vui lòng tải lại trang.';
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            return;
        }

        $account = isset($_POST['email']) ? $_POST['email'] : (isset($_POST['phone']) ? $_POST['phone'] : '');
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $page = isset($_POST['page']) && $_POST['page'] === 'admin' ? 'admin' : 'public';

        if (!is_string($account) || !is_string($password) || trim($account) === '' || strlen($account) > 255 || strlen($password) === 0 || strlen($password) > 1024) {
            $result['message'] = 'Vui lòng nhập tài khoản và mật khẩu hợp lệ.';
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            return;
        }

        $account = $db->escapestring(trim($account));
        $db->query("SELECT * FROM hicrm_users WHERE (user_email = '".$account."' OR user_username = '".$account."' OR user_phone = '".$account."') LIMIT 1");
        if (!$db->num_row()) {
            $result['message'] = 'Tài khoản không tồn tại trên hệ thống.';
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            return;
        }

        $row = $db->fetch_object(true);
        if ((int)$row->user_status !== 1) {
            $result = array('success' => false, 'status' => 403, 'message' => 'Tài khoản của bạn đã bị khóa hoặc tạm dừng hoạt động.');
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            return;
        }

        $dbPass = (string)$row->user_password;
        $matched = (md5($password) === $dbPass) 
                || (password_verify($password, $dbPass)) 
                || ($password === $dbPass);

        if (!$matched) {
            $result['message'] = 'Mật khẩu không chính xác.';
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            return;
        }

        @session_regenerate_id(true);
        unset($_SESSION['zalo_oauth'], $_SESSION['zalo_callback'], $_SESSION['google_oauth'], $_SESSION['facebook_oauth']);

        $group = (int)$row->user_group;

        // Phân quyền: Khách hàng (group 0) vs Quản trị / Nhân viên (group >= 1)
        if ($group === 0) {
            if ($page === 'admin') {
                $result = array('success' => false, 'status' => 403, 'message' => 'Tài khoản của bạn không có quyền truy cập trang quản trị.');
                echo json_encode($result, JSON_UNESCAPED_UNICODE);
                return;
            }

            // Khởi tạo phiên khách hàng (TUYỆT ĐỐI không cấp user/staff/LoggedIn)
            unset($_SESSION['user'], $_SESSION['staff'], $_SESSION['LoggedIn']);
            $_SESSION['customer'] = array(
                'id'       => (int)$row->id,
                'fullname' => !empty($row->user_fullname) ? $row->user_fullname : $row->user_username,
                'phone'    => $row->user_phone,
                'email'    => $row->user_email,
                'avatar'   => $row->user_avatar,
                'provider' => 'local',
                'zalo'     => false
            );
            $_SESSION['customer_csrf'] = bin2hex(random_bytes(32));

            $returnUrl = XC_URL;
            if (!empty($_SESSION['login_redirect_url'])) {
                $returnUrl = $_SESSION['login_redirect_url'];
                unset($_SESSION['login_redirect_url']);
            }

            $result = array(
                'success'    => true,
                'status'     => 200,
                'message'    => 'Đăng nhập thành công.',
                'return_url' => $returnUrl
            );
        } else {
            // Quản trị viên / Bác sĩ / Nhân viên phòng khám
            $_SESSION['user'] = array(
                'id'       => (int)$row->id,
                'email'    => $row->user_email,
                'fullname' => $row->user_fullname,
                'group'    => $group
            );
            $_SESSION['staff'] = array(
                'id'         => (int)$row->id,
                'fullname'   => $row->user_fullname,
                'group'      => $group,
                'department' => isset($row->user_dept) ? $row->user_dept : ''
            );
            $_SESSION['LoggedIn'] = 1;

            $returnUrl = XC_URL . '/admin';
            $result = array(
                'success'    => true,
                'status'     => 200,
                'message'    => 'Đăng nhập quản trị thành công.',
                'return_url' => $returnUrl
            );
        }

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    public function savezalosettings()
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Cache-Control: no-store');
        $result = array('success' => false, 'message' => 'Bạn không có quyền hoặc phiên cấu hình đã hết hạn. Vui lòng đăng nhập lại.');
        $csrf = isset($_POST['csrf']) ? $_POST['csrf'] : '';
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SESSION['user']['id']) || !is_string($csrf) || empty($_SESSION['zalo_config_csrf']) || !hash_equals($_SESSION['zalo_config_csrf'], $csrf)) {
            echo json_encode($result, JSON_UNESCAPED_UNICODE); return;
        }
        $appId = isset($_POST['app_id']) && is_string($_POST['app_id']) ? trim($_POST['app_id']) : '';
        $secret = isset($_POST['app_secret']) && is_string($_POST['app_secret']) ? trim($_POST['app_secret']) : '';
        $callback = isset($_POST['callback_url']) && is_string($_POST['callback_url']) ? trim($_POST['callback_url']) : '';
        if (!preg_match('/^[0-9]{1,30}$/D', $appId) || strlen($secret) > 255 || preg_match('/[\x00-\x20\x7f]/', $secret) || strlen($callback) > 2048 || !filter_var($callback, FILTER_VALIDATE_URL) || parse_url($callback, PHP_URL_SCHEME) !== 'https' || parse_url($callback, PHP_URL_USER) !== null || parse_url($callback, PHP_URL_FRAGMENT) !== null) {
            echo json_encode(array('success' => false, 'message' => 'App ID phải là số, App Secret không chứa khoảng trắng và Callback phải là URL HTTPS hợp lệ.'), JSON_UNESCAPED_UNICODE); return;
        }
        $conn = null;
        try {
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            $conn->set_charset('utf8mb4');
            $id = (int)$_SESSION['user']['id'];
            $stmt = $conn->prepare('SELECT id FROM hicrm_users WHERE id = ? AND user_group = 1 AND user_status = 1');
            $stmt->bind_param('i', $id); $stmt->execute();
            if (!$stmt->get_result()->fetch_assoc()) throw new Exception('Unauthorized');
            $conn->query("SELECT GET_LOCK('hicrm_zalo_config_save', 5) AS acquired");
            $lock = $conn->query("SELECT IS_USED_LOCK('hicrm_zalo_config_save') = CONNECTION_ID() AS acquired")->fetch_assoc();
            if (empty($lock['acquired'])) throw new Exception('Configuration busy');
            $conn->begin_transaction();
            $current = $conn->query("SELECT config_value FROM hicrm_configs WHERE config_key = 'zalo_app_secret' ORDER BY id LIMIT 1")->fetch_assoc();
            $oldId = $conn->query("SELECT config_value FROM hicrm_configs WHERE config_key = 'zalo_app_id' ORDER BY id LIMIT 1")->fetch_assoc();
            if ($secret === '' && (empty($current['config_value']) || !empty($oldId['config_value']) && $oldId['config_value'] !== $appId)) {
                $conn->rollback();
                $result['message'] = 'Vui lòng nhập App Secret khi cấu hình lần đầu hoặc thay đổi App ID.';
            } else {
                $values = array('zalo_app_id' => $appId, 'zalo_callback_url' => $callback);
                if ($secret !== '') $values['zalo_app_secret'] = $secret;
                foreach ($values as $key => $value) {
                    $stmt = $conn->prepare('SELECT id FROM hicrm_configs WHERE config_key = ? LIMIT 1');
                    $stmt->bind_param('s', $key); $stmt->execute();
                    $exists = $stmt->get_result()->fetch_assoc();
                    $stmt = $conn->prepare($exists ? 'UPDATE hicrm_configs SET config_value = ? WHERE config_key = ?' : 'INSERT INTO hicrm_configs (config_value, config_key) VALUES (?, ?)');
                    $stmt->bind_param('ss', $value, $key); $stmt->execute();
                }
                $conn->commit();
                $result = array('success' => true, 'message' => 'Đã lưu cấu hình đăng nhập Zalo.', 'data' => array('secret_configured' => true));
            }
        } catch (Throwable $e) {
            if ($conn) $conn->rollback();
            $result['message'] = 'Không thể lưu cấu hình. Vui lòng kiểm tra kết nối database hoặc thử lại sau.';
        } finally {
            if ($conn) $conn->close();
        }
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    public function savesocialsettings()
    {
        @error_reporting(0);
        while (ob_get_level()) { @ob_end_clean(); }
        header('Content-Type: application/json; charset=utf-8');
        header('Cache-Control: no-store');
        $result = array('success' => false, 'message' => 'Phiên đăng nhập quản trị đã hết hạn. Vui lòng đăng nhập lại tài khoản admin.');

        $csrf = isset($_POST['csrf']) ? $_POST['csrf'] : '';
        $validCsrf = (is_string($csrf) && !empty($_SESSION['social_config_csrf']) && hash_equals($_SESSION['social_config_csrf'], $csrf))
                  || (is_string($csrf) && !empty($_SESSION['zalo_config_csrf']) && hash_equals($_SESSION['zalo_config_csrf'], $csrf));

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SESSION['user']['id']) || !$validCsrf) {
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            return;
        }

        $provider = isset($_POST['provider']) && is_string($_POST['provider']) ? trim($_POST['provider']) : '';
        $conn = null;
        try {
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            $host = DB_HOST;
            $port = defined('DB_PORT') ? (int)DB_PORT : 3306;
            if (strpos($host, ':') !== false) {
                list($h, $p) = explode(':', $host, 2);
                $host = $h;
                $port = (int)$p;
            }
            $conn = new mysqli($host, DB_USER, DB_PASSWORD, DB_NAME, $port);
            $conn->set_charset('utf8mb4');

            // Kiểm tra quyền Admin nhóm 1
            $uid = (int)$_SESSION['user']['id'];
            $stmt = $conn->prepare('SELECT id FROM hicrm_users WHERE id = ? AND user_group = 1 AND user_status = 1');
            $stmt->bind_param('i', $uid);
            $stmt->execute();
            $adminUser = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            if (!$adminUser) {
                throw new Exception('Bạn không có quyền quản trị viên.');
            }

            $values = array();

            if ($provider === 'google') {
                $clientId = isset($_POST['client_id']) ? trim($_POST['client_id']) : '';
                $clientSecret = isset($_POST['client_secret']) ? trim($_POST['client_secret']) : '';
                $redirectUri = isset($_POST['redirect_uri']) ? trim($_POST['redirect_uri']) : '';

                if ($clientId === '' || $redirectUri === '') {
                    echo json_encode(array('success' => false, 'message' => 'Vui lòng điền Client ID và Redirect URI của Google.'), JSON_UNESCAPED_UNICODE);
                    return;
                }

                $checkSecret = $conn->query("SELECT config_value FROM hicrm_configs WHERE config_key = 'google_client_secret' LIMIT 1")->fetch_assoc();
                $hasSecret = !empty($checkSecret['config_value']);
                if ($clientSecret === '' && !$hasSecret) {
                    echo json_encode(array('success' => false, 'message' => 'Vui lòng nhập Client Secret của Google trong lần cấu hình đầu tiên.'), JSON_UNESCAPED_UNICODE);
                    return;
                }

                $values['google_client_id'] = $clientId;
                $values['google_redirect_uri'] = $redirectUri;
                if ($clientSecret !== '') {
                    $values['google_client_secret'] = $clientSecret;
                }
            } elseif ($provider === 'facebook') {
                $appId = isset($_POST['app_id']) ? trim($_POST['app_id']) : '';
                $appSecret = isset($_POST['app_secret']) ? trim($_POST['app_secret']) : '';
                $redirectUri = isset($_POST['redirect_uri']) ? trim($_POST['redirect_uri']) : '';

                if ($appId === '' || $redirectUri === '') {
                    echo json_encode(array('success' => false, 'message' => 'Vui lòng điền App ID và Redirect URI của Facebook.'), JSON_UNESCAPED_UNICODE);
                    return;
                }

                $checkSecret = $conn->query("SELECT config_value FROM hicrm_configs WHERE config_key = 'facebook_app_secret' LIMIT 1")->fetch_assoc();
                $hasSecret = !empty($checkSecret['config_value']);
                if ($appSecret === '' && !$hasSecret) {
                    echo json_encode(array('success' => false, 'message' => 'Vui lòng nhập App Secret của Facebook trong lần cấu hình đầu tiên.'), JSON_UNESCAPED_UNICODE);
                    return;
                }

                $values['facebook_app_id'] = $appId;
                $values['facebook_redirect_uri'] = $redirectUri;
                if ($appSecret !== '') {
                    $values['facebook_app_secret'] = $appSecret;
                }
            } elseif ($provider === 'zalo') {
                $appId = isset($_POST['app_id']) ? trim($_POST['app_id']) : '';
                $appSecret = isset($_POST['app_secret']) ? trim($_POST['app_secret']) : '';
                $callbackUrl = isset($_POST['callback_url']) ? trim($_POST['callback_url']) : '';

                if ($appId === '' || $callbackUrl === '') {
                    echo json_encode(array('success' => false, 'message' => 'Vui lòng điền App ID và Callback URL của Zalo.'), JSON_UNESCAPED_UNICODE);
                    return;
                }

                $checkSecret = $conn->query("SELECT config_value FROM hicrm_configs WHERE config_key = 'zalo_app_secret' LIMIT 1")->fetch_assoc();
                $hasSecret = !empty($checkSecret['config_value']);
                if ($appSecret === '' && !$hasSecret) {
                    echo json_encode(array('success' => false, 'message' => 'Vui lòng nhập App Secret của Zalo trong lần cấu hình đầu tiên.'), JSON_UNESCAPED_UNICODE);
                    return;
                }

                $values['zalo_app_id'] = $appId;
                $values['zalo_callback_url'] = $callbackUrl;
                if ($appSecret !== '') {
                    $values['zalo_app_secret'] = $appSecret;
                }
            } else {
                echo json_encode(array('success' => false, 'message' => 'Nhà cung cấp không hợp lệ.'), JSON_UNESCAPED_UNICODE);
                return;
            }

            // Ghi cấu hình an toàn vào hicrm_configs
            $conn->begin_transaction();
            foreach ($values as $k => $v) {
                $checkStmt = $conn->prepare('SELECT id FROM hicrm_configs WHERE config_key = ? LIMIT 1');
                $checkStmt->bind_param('s', $k);
                $checkStmt->execute();
                $exists = $checkStmt->get_result()->fetch_assoc();
                $checkStmt->close();

                if ($exists) {
                    $saveStmt = $conn->prepare('UPDATE hicrm_configs SET config_value = ? WHERE config_key = ?');
                    $saveStmt->bind_param('ss', $v, $k);
                    $saveStmt->execute();
                    $saveStmt->close();
                } else {
                    $saveStmt = $conn->prepare('INSERT INTO hicrm_configs (config_key, config_value) VALUES (?, ?)');
                    $saveStmt->bind_param('ss', $k, $v);
                    $saveStmt->execute();
                    $saveStmt->close();
                }
            }
            $conn->commit();

            $result = array(
                'success' => true,
                'message' => 'Đã lưu cấu hình đăng nhập ' . ucfirst($provider) . ' thành công!',
                'data'    => array('secret_configured' => true)
            );
        } catch (Throwable $e) {
            if ($conn) $conn->rollback();
            $result['message'] = 'Không thể lưu cấu hình. Lỗi: ' . $e->getMessage();
        } finally {
            if ($conn) $conn->close();
        }

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }


    public function customerlogout()
    {
        header('Content-Type: application/json; charset=utf-8');
        $csrf = isset($_POST['csrf']) ? $_POST['csrf'] : '';
        $ok = $_SERVER['REQUEST_METHOD'] === 'POST' && is_string($csrf) && !empty($_SESSION['customer_csrf']) && hash_equals($_SESSION['customer_csrf'], $csrf);
        if ($ok) unset($_SESSION['customer'], $_SESSION['customer_csrf']);
        echo json_encode(array('success' => $ok, 'message' => $ok ? 'Đã đăng xuất.' : 'Phiên đăng xuất không hợp lệ. Vui lòng tải lại trang.', 'data' => array('url' => XC_URL)), JSON_UNESCAPED_UNICODE);
    }

    public function customerphone()
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Cache-Control: no-store');
        $result = array('success' => false, 'message' => 'Phiên đăng nhập không hợp lệ. Vui lòng đăng nhập lại.');
        $csrf = isset($_POST['csrf']) ? $_POST['csrf'] : '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_SESSION['customer']['id']) && is_string($csrf) && !empty($_SESSION['customer_csrf']) && hash_equals($_SESSION['customer_csrf'], $csrf)) {
            $phone = isset($_POST['phone']) && is_string($_POST['phone']) ? preg_replace('/[\s.\-]/', '', trim($_POST['phone'])) : '';
            $phone = preg_replace('/^(?:\+84|84)/', '0', $phone);
            if (!preg_match('/^0[35789][0-9]{8}$/D', $phone)) {
                $result['message'] = 'Vui lòng nhập số điện thoại di động Việt Nam hợp lệ (10 số).';
            } else {
                try {
                    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
                    if ($conn->connect_errno) throw new Exception('Database unavailable');
                    $conn->set_charset('utf8mb4');
                    $id = (int)$_SESSION['customer']['id'];
                    $stmt = $conn->prepare('SELECT id FROM hicrm_users WHERE user_phone = ? AND id <> ? AND user_status = 1 LIMIT 1');
                    $stmt->bind_param('si', $phone, $id); $stmt->execute();
                    if ($stmt->get_result()->fetch_assoc()) {
                        $result['message'] = 'Số điện thoại đã được dùng cho tài khoản khác. Vui lòng liên hệ phòng khám để được hỗ trợ.';
                    } else {
                        $stmt = $conn->prepare('SELECT id FROM hicrm_users WHERE id = ? AND user_status = 1 LIMIT 1');
                        $stmt->bind_param('i', $id); $stmt->execute();
                        if (!$stmt->get_result()->fetch_assoc()) throw new Exception('Account unavailable');
                        $stmt = $conn->prepare('UPDATE hicrm_users SET user_phone = ? WHERE id = ? AND user_status = 1');
                        $stmt->bind_param('si', $phone, $id); $stmt->execute();
                        $_SESSION['customer']['phone'] = $phone;
                        $result = array('success' => true, 'message' => 'Đã cập nhật số điện thoại.', 'data' => array('url' => XC_URL));
                    }
                    $conn->close();
                } catch (Throwable $e) {
                    $result['message'] = 'Không thể lưu số điện thoại. Vui lòng thử lại sau.';
                }
            }
        }
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    public function zalologin()
    {
        global $db;
        header('Content-Type: application/json; charset=utf-8');
        header('Cache-Control: no-store');
        $result = array('success' => false, 'message' => 'Phiên đăng nhập không hợp lệ. Vui lòng tải lại trang.');
        $csrf = isset($_POST['csrf']) ? $_POST['csrf'] : '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && is_string($csrf) && !empty($_SESSION['login_csrf']) && hash_equals($_SESSION['login_csrf'], $csrf)) {
            require_once __SITE_PATH.'/application/login_zalo.class.php';
            try {
                $zalo = new LoginZalo();
                if (isset($_POST['action']) && $_POST['action'] === 'complete') {
                    $profile = $zalo->complete();
                    // A dedicated connection uses prepared statements and never exposes SQL errors.
                    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
                    if ($conn->connect_errno) throw new Exception('Database unavailable');
                    $conn->set_charset('utf8mb4');
                    $column = $conn->query("SHOW COLUMNS FROM hicrm_users LIKE 'user_zalo_id'");
                    if (!$column || !$column->num_rows) {
                        throw new LoginZaloException('Đăng nhập khách hàng chưa được cấu hình đầy đủ. Vui lòng liên hệ phòng khám.');
                    }
                    $indexes = $conn->query("SHOW INDEX FROM hicrm_users WHERE Non_unique = 0");
                    $uniqueIndexes = array();
                    while ($index = $indexes->fetch_assoc()) $uniqueIndexes[$index['Key_name']][] = $index['Column_name'];
                    if (!in_array(array('user_zalo_id'), $uniqueIndexes, true)) {
                        throw new LoginZaloException('Đăng nhập khách hàng chưa được cấu hình đầy đủ. Vui lòng liên hệ phòng khám.');
                    }
                    $stmt = $conn->prepare('SELECT id, user_status, user_phone FROM hicrm_users WHERE user_zalo_id = ? LIMIT 1');
                    $stmt->bind_param('s', $profile['id']); $stmt->execute();
                    $existing = $stmt->get_result()->fetch_assoc();
                    if ($existing && (int)$existing['user_status'] !== 1) {
                        throw new LoginZaloException('Tài khoản đã bị khóa. Vui lòng liên hệ phòng khám.');
                    }
                    if (!$existing) {
                        // The UNIQUE Zalo ID prevents duplicate creation from simultaneous requests.
                        // Group 0 + a separate customer session: never an employee/admin login.
                        $username = 'zalo_'.$profile['id'];
                        $password = password_hash(bin2hex(random_bytes(32)), PASSWORD_DEFAULT);
                        $stmt = $conn->prepare("INSERT INTO hicrm_users (user_zalo_id, user_username, user_password, user_email, user_fullname, user_avatar, user_phone, user_group, user_status) VALUES (?, ?, ?, '', ?, ?, NULL, 0, 1) ON DUPLICATE KEY UPDATE id = id");
                        $stmt->bind_param('sssss', $profile['id'], $username, $password, $profile['name'], $profile['avatar']);
                        $stmt->execute();
                    }
                    $stmt = $conn->prepare('SELECT id, user_fullname, user_phone, user_status FROM hicrm_users WHERE user_zalo_id = ? LIMIT 1');
                    $stmt->bind_param('s', $profile['id']); $stmt->execute();
                    $row = $stmt->get_result()->fetch_assoc();
                    if (!$row || (int)$row['user_status'] !== 1) {
                        throw new LoginZaloException('Tài khoản không còn hoạt động. Vui lòng liên hệ phòng khám.');
                    }
                    $stmt = $conn->prepare('UPDATE hicrm_users SET user_fullname = ?, user_avatar = ? WHERE id = ? AND user_status = 1');
                    $stmt->bind_param('ssi', $profile['name'], $profile['avatar'], $row['id']); $stmt->execute();
                    $conn->close();
                    session_regenerate_id(true);
                    // Do not populate user/staff/LoggedIn: these sessions grant backend access.
                    $_SESSION['customer'] = array('id' => (int)$row['id'], 'fullname' => $profile['name'], 'phone' => $row['user_phone'], 'zalo' => true);
                    $_SESSION['customer_csrf'] = bin2hex(random_bytes(32));
                    $result = array('success' => true, 'message' => 'Đăng nhập Zalo thành công.', 'data' => array('url' => XC_URL));
                } else {
                    $page = '/login';
                    $result = array('success' => true, 'message' => 'Đang chuyển đến Zalo.', 'data' => array('url' => $zalo->begin($page)));
                }
            } catch (LoginZaloException $e) {
                $result['message'] = $e->getMessage();
            } catch (Throwable $e) {
                $result['message'] = 'Không thể hoàn tất đăng nhập. Vui lòng thử lại sau.';
            }
        }
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
	public function stafflogin()
	{
		$result = array();
		$email = mysql_real_escape_string($_POST["username"]);
        $password = md5(mysql_real_escape_string($_POST["password"]));
		global $db;
		$db->query("SELECT * FROM hicrm_users WHERE user_email = '".$email."' AND user_password = '".$password."' AND user_group IN (1,2,3) ORDER BY id DESC LIMIT 1");
		if($db->num_row())
		{
			$user = $db->fetch_object(true);
			$_SESSION['staff']['id'] = $user->id;
			$_SESSION['staff']['fullname'] = $user->user_fullname;
			$_SESSION['staff']['group'] = $user->user_group;
			$_SESSION['staff']['department'] = $user->user_dept;
			$result["status"] = 200;
		}
		else
		{
			$result["status"] = 404;
			$result["message"] = "Không tìm thấy tài khoản";
		}
        echo json_encode($result);
	}
	public function login1()
	{
		$result = array();
		$email = mysql_real_escape_string($_POST["email"]);
        $password = md5(mysql_real_escape_string($_POST["password"]));
        $member_login = $this->model->get('memberloginModel')->user_login($email,$password);
		if($member_login)
		{
			$result["status"] = "200";
			$result["name"] = $_SESSION['user']['fullname'];
			//echo $_SESSION['user']['id'];
		}
		else
		{
			$result["status"] = "500";
			//echo "error";
		}
		echo json_encode($result);
	}
	public function addnote()
	{
		$result = array();
		global $db;
		$oid = $_POST["id"];
		$db->query("INSERT INTO ow_order_notes(oid,uid,note_text) VALUES('".$oid."','".$_SESSION['staff']['id']."','".$_POST['content']."')");
		$result["status"] = 200;
		echo json_encode($result);
	}
	public function CreatePackage()
	{
		$result = array();
		global $db;
		$packtype = $_POST['packtype'];
		$code = $this->func->generateid("package");
		$db->query("INSERT INTO ow_packages(pack_code,pack_created_by,pack_status,pack_type) VALUES('".$code."','".$_SESSION['staff']['id']."',1,'".$packtype."')");
		$result["status"] = 200;
		echo json_encode($result);
	}
	public function AssignCustomerToStaff()
	{
		$result = array();
		global $db;
		$cid = $_POST['cid'];
		$staff = $_POST['staff'];
		$note = $_POST['note'];
		//$result["data"] = $_POST;
		$db->query("SELECT * FROM hicrm_users WHERE id = '".$_SESSION['staff']['id']."'");
		if($db->num_row())
		{
			$user = $db->fetch_object(true);
			if($user->user_group == 1)
			{
				$db->query("SELECT * FROM ow_users WHERE id = '".$cid."'");
				if($db->num_row())
				{
					$db->query("UPDATE ow_users SET user_staff = '".$staff."' WHERE id = '".$cid."' LIMIT 1");
					$db->query("UPDATE ow_orders SET order_staff = '".$staff."' WHERE uid = '".$cid."'");
					$db->query("SELECT * FROM hicrm_users WHERE id = '".$staff."'");
					$staff = $db->fetch_object(true);
					$db->query("INSERT INTO ow_system_logs(uid,cid,log_key,log_value,log_note) VALUES('".$_SESSION['staff']['id']."','".$cid."','ASSIGN_CUSTOMER_TO_NEW_STAFF','".$staff."','".$note."')");
					$result["status"] = 200;
				}
				else
				{
					$result["status"] = 404;
					$result["message"] = "Không tìm thấy khách hàng này!";
				}
			}
			else
			{
				$result["status"] = 500;
			$result["message"] = "Bạn không đủ quyền để thực hiện tác vụ này!";
			}
		}
		else
		{
			$result["status"] = 500;
			$result["message"] = "Bạn không đủ quyền để thực hiện tác vụ này!";
		}
		echo json_encode($result);
	}
	public function UpdateOrderStatus()
	{
		$result = array();
		global $db;
		$oid = $_POST["id"];
		$newstatus = $_POST['newstatus'];
		$updatename = $_POST["newstatustext"];
		$note = $_POST['note'];
		$db->query("UPDATE ow_orders SET order_status = '".$newstatus."' WHERE id = '".$oid."'");
		$noteupdate = "Cập nhật trang thái đơn hàng mới: ".$updatename;
		$db->query("SELECT * FROM ow_order_status WHERE id = '".$newstatus."'");
		$status = $db->fetch_object(true);
		$db->query("INSERT ow_order_updates(oid,uid,update_type,update_key,update_value) VALUES('".$oid."','".$_SESSION['staff']['id']."','2','".$status->status_key."','".$noteupdate."')");
		if($note != "")
		{
			$db->query("INSERT INTO ow_order_notes(oid,uid,note_text) VALUES('".$oid."','".$_SESSION['staff']['id']."','".$note."')");
		}
		$result["status"] = 200;
		echo json_encode($result);
	}
	public function GetItemsofOrder()
	{
		$result = array();
		$oid = $_POST["id"];
		global $db;
		$db->query("SELECT * FROM ow_order_items WHERE oid = '".$oid."'");
		$items = $db->fetch_object();
		$data = '';
		foreach($items as $item)
		{
			$disabled = ($item->item_buy == 1)? "disabled" : "";
			$data .= '<div class="col-md-12">
                            <div class="custom-control custom-block custom-control-primary">
                                <input type="checkbox" '.$disabled.' data-id="'.$item->id.'" class="custom-control-input" id="item-'.$item->id.'" name="buyitem[]">
                                <label class="custom-control-label" for="item-'.$item->id.'">
                                    <span class="d-flex align-items-center">
                                        <img class="img-avatar img-avatar48" src="'.$item->item_p_image.'" alt="">
                                        <span class="ml-2">
                                            <span class="font-w700">'.$item->item_pname.'</span>
                                            <span class="d-block font-size-sm text-muted">Price: '.number_format($item->item_price,0).' NDT | Size: '.$item->item_p_size.' | Color: '.$item->item_p_color.'</span> 
                                        </span>
                                    </span>
                                </label>
                                <span class="custom-block-indicator">
                                    <i class="fa fa-check"></i>
                                </span>
                            </div>
                        </div>';
		}
		$result["status"] = 200;
		$result["data"] = $data;
		echo json_encode($result);
	}
	public function ChangeItemMetas()
	{
		$result = array();
		global $db;
		$type = $_POST['type'];
		$id = $_POST['id'];
		$value = $_POST['values'];
		$db->query("UPDATE ow_order_items SET ".$type." = '".$value."' WHERE id = '".$id."'");
		$result["status"] = 200;
		echo json_encode($result);
	}
	public function UpdateOrderItemBuy()
	{
		$result = array();
		global $db;
		$oid = $_POST['id'];
		$items = $_POST['itemlist'];
		if(count($items) > 0)
		{
			$code = $_POST['note'];
			$items = implode(",",$items);
			$db->query("SELECT * FROM ow_order_items WHERE id IN (".$items.")");
			$listitems = $db->fetch_object();
			foreach($listitems as $item)
			{
				$db->query("UPDATE ow_order_items SET item_buy = '1',item_status = 2, item_kr_tracking_code = '".$code."', item_buy_date = '".date("Y-m-d H:i:s")."' WHERE id = '".$item->id."' AND item_buy = 0");
				$note = "Mua sản phẩm: ".$item->item_pname." (Vận đơn: ".$code.")";
				$db->query("INSERT ow_order_updates(oid,uid,update_type,update_value) VALUES('".$oid."','".$_SESSION['staff']['id']."','2','".$note."')");
				$db->query("INSERT INTO ow_order_notes(oid,uid,note_text) VALUES('".$oid."','".$_SESSION['staff']['id']."','".$note."')");
			}
			
			$result["status"] = 200;
		}
		else
		{
			$result["status"] = 500;
			$result["message"] = "Không có dữ liệu cập nhật!";
		}
		echo json_encode($result);
	}
	public function ScanTrackingItemIntoKRStock()
	{
		$result = array();
		global $db;
		$code = $_POST['code'];
		$db->query("SELECT *, oi.id as oiid,o.id as oid FROM ow_order_items as oi
		LEFT JOIN ow_orders as o ON oi.oid = o.id
		WHERE item_status = 2 AND item_kr_tracking_code = '".$code."'");
		if($db->num_row())
		{
			$item = $db->fetch_object(true);
			$data = '<tr>
				<td class="text-center">
					<img class="img-avatar img-avatar48" src="'.$item->item_p_image.'" alt="">
				</td>
				<td class="font-w600">
					<a href="javascript:void(0)" class="font-size-sm">'.$item->item_pname.'</a>
				</td>
				<td class="d-none d-sm-table-cell">
					'.$item->order_code.'
				</td>
				<td class="d-none d-lg-table-cell">
					<div class="form-group mb-0">
						<div class="input-group">
							<input type="text" class="form-control item-meta-weight" value="'.$item->item_weight.'" data-id="'.$item->oiid.'" id="item-meta-weight" name="item-meta-width">
						</div>
					</div>
				</td>
				<td class="text-center">
					<div class="form-group mb-0 form-row">
				<div class="col-12">
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">
								L
							</span>
						</div>
						<input type="text" value="'.$item->item_lenght.'" class="form-control item-meta-lenght" data-id="'.$item->oiid.'" id="item-meta-lenght" name="item-meta-lenght">
						<div class="input-group-prepend">
							<span class="input-group-text">
								W
							</span>
						</div>
						<input type="text" class="form-control item-meta-width" value="'.$item->item_width.'" data-id="'.$item->oiid.'" id="item-meta-width" name="item-meta-width">
						<div class="input-group-prepend">
							<span class="input-group-text">
								H
							</span>
						</div>
						<input type="text" class="form-control item-meta-height" value="'.$item->item_height.'" data-id="'.$item->oiid.'" id="item-meta-height" name="item-meta-height">
					</div>
				</div>
				
			</div>
				</td>
				<td><button type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Edit">
                                        <i class="fa fa-check-square"></i>
                                    </button></td>
			</tr>';
			$db->query("UPDATE ow_order_items SET item_status = 3 WHERE id = '".$item->oiid."'");
			$note = "Sản phẩm: ".$item->item_pname." (Vận đơn: ".$code.") đã về kho Hàn Quốc";
			$db->query("INSERT ow_order_updates(oid,uid,update_type,update_value) VALUES('".$item->oid."','".$_SESSION['staff']['id']."','2','".$note."')");
			$result["status"] = 200;
			$result["data"] = $data;
		}
		else
		{
			$result["status"] = 500;
			$result["message"] = "Không tìm thấy sản phẩm có vận đơn phù hợp!";
		}
		
		
			
			echo json_encode($result);
		
	}
	public function ScanItemForPackage()
	{
		$result = array();
		global $db;
		$code = $_POST['code'];
		$pid = $_POST['id'];
		$db->query("SELECT *, oi.id as oiid FROM ow_order_items as oi
		LEFT JOIN ow_orders as o ON oi.oid = o.id
		WHERE item_status = 2 AND item_kr_tracking_code = '".$code."' AND (SELECT count(*) FROM ow_package_items WHERE itemid = oi.id) = 0");
		if($db->num_row())
		{
			$item = $db->fetch_object(true);
			$data = '<tr>
						<td class="text-center">
							<img class="img-avatar img-avatar48" src="'.$item->item_p_image.'" alt="">
						</td>
						<td class="font-w600">
							<a href="javascript:void(0)" class="font-size-sm">'.$item->item_pname.'</a>
						</td>
						<td class="d-none d-sm-table-cell">
							'.$item->order_code.'
						</td>
						<td class="d-none d-lg-table-cell text-center">
							'.number_format($item->item_weight,0).'
						</td>
						<td class="text-center">
							<div class="form-group mb-0 form-row">
						<div class="col-12">
							'.number_format($item->item_lenght,0).' x '.number_format($item->item_width,0).' x '.number_format($item->item_height,0).'
						</td>
						<td><button type="button" class="btn btn-sm btn-danger js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Delete">
												<i class="fa fa-times"></i>
											</button></td>
					</tr>';
			$db->query("INSERT INTO ow_package_items(pid,itemid) VALUES('".$pid."','".$item->oiid."')");
			$result["status"] = 200;
			$result["data"] = $data;
		}
		else
		{
			$result["status"] = 500;
			$result["message"] = "Không tìm thấy sản phẩm có vận đơn phù hợp!";
		}
		
		
			
			echo json_encode($result);
		
	}
	public function UpdateOrderFixFee()
	{
		$result = array();
		global $db;
		$oid = $_POST['id'];
		$type = $_POST['type'];
		$amount = $_POST['amount'];
		$typename = $_POST['typename'];
		$db->query("SELECT * FROM ow_orders WHERE id = '".$oid."' LIMIT 1");
		$order = $db->fetch_object(true);
		
		$db->query("SELECT * FROM ow_users WHERE id = '".$order->uid."'");
		$user = $db->fetch_object(true);
		if($user->user_available_wallet <= $amount)
		{
			$result["status"] = 500;
			$result["message"] = "Số dư của Khách hàng không đủ để thực hiện giao dịch này!";
		}
		else
		{
			$db->query("UPDATE ow_orders SET ".$type." = '".$amount."' WHERE id = '".$oid."'");
			$note = "Cập nhật ".$typename." số tiền: ".number_format($amount,0)."đ";
			
			$db->query("INSERT ow_order_updates(oid,uid,update_type,update_value) VALUES('".$oid."','".$_SESSION['staff']['id']."','4','".$note."')");
			$db->query("UPDATE ow_users SET user_available_wallet = user_available_wallet - ".$amount." WHERE id = '".$order->uid."'");
			$transcode = general::getInstance()->generateid("transaction");
			
			$sql = "INSERT INTO ow_transactions(uid,trans_code,trans_type,trans_bank,trans_method,trans_amount,trans_hash,trans_status,trans_note) VALUES('".$order->uid."','".$transcode."','2','1','1','".$amount."','".bin2hex(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM))."','2','Thanh toán phí cho đơn hàng".$order->order_code."')";
			$db->query($sql);
			$db->query("INSERT INTO ow_order_notes(oid,uid,note_text) VALUES('".$oid."','".$_SESSION['staff']['id']."','".$note."')");
			$result["status"] = 200;
		}
		
		echo json_encode($result);
	}
	public function AssignToStaff()
	{
		$result = array();
		global $db;
		$oid = $_POST['id'];
		$staffname = $_POST['staffname'];
		$db->query("UPDATE ow_orders SET order_staff = '".$_POST['staff']."', order_assign_date = '".date("Y-m-d H:i:s")."' WHERE id = '".$oid."'");
		$note = "Giao đơn hàng cho ".$staffname;
		$db->query("INSERT ow_order_updates(oid,uid,update_type,update_value) VALUES('".$oid."','".$_SESSION['staff']['id']."','4','".$note."')");
		$db->query("INSERT INTO ow_order_notes(oid,uid,note_text) VALUES('".$oid."','".$_SESSION['staff']['id']."','".$_POST['note']."')");
		$result["status"] = 200;
		echo json_encode($result);
	}
	public function approvetransaction()
	{
		$result = array();
		$tid = $_POST['id'];
		global $db;
		$db->query("SELECT * FROM ow_transactions WHERE id = '".$tid."' AND trans_status = 1");
		if($db->num_row())
		{
			$trans = $db->fetch_object(true);
			switch($trans->trans_type)
			{
				case 1:
				{
					$result["uid"] = $trans->uid;
					$result["sql"] = $sql = "UPDATE ow_users SET user_available_wallet = user_available_wallet + ".$trans->trans_amount." WHERE id = '".$trans->uid."'";
					$db->query($sql);
					$db->query("UPDATE ow_transactions SET trans_status = 2, trans_approved_by = '".$_SESSION['staff']['id']."', trans_approved_date = '".date("Y-m-d H:i:s")."' WHERE id = '".$tid."'");
					$result["status"] = 200;
					break;
				}
				default:
				{
					$result["status"] = 500;
					$result["message"] = "Không rõ yêu cầu!";
					break;
				}
			}
			
		}
		else
		{
			$result["status"] = 500;
			$result["message"] = "Không tồn tại giao dịch này hoặc đã được xử lý!";
		}
		echo json_encode($result);
	}
	public function deninetransaction()
	{
		$result = array();
		$tid = $_POST['id'];
		global $db;
		$db->query("SELECT * FROM ow_transactions WHERE id = '".$tid."' AND trans_status = 1");
		if($db->num_row())
		{
			$trans = $db->fetch_object(true);
			switch($trans->trans_type)
			{
				case 1:
				{
					$db->query("UPDATE ow_transactions SET trans_status = 3, trans_approved_by = '".$_SESSION['staff']['id']."', trans_approved_date = '".date("Y-m-d H:i:s")."' WHERE id = '".$tid."'");
					$result["status"] = 200;
					break;
				}
				default:
				{
					$result["status"] = 500;
					$result["message"] = "Không rõ yêu cầu!";
					break;
				}
			}
			
		}
		else
		{
			$result["status"] = 500;
			$result["message"] = "Không tồn tại giao dịch này hoặc đã được xử lý!";
		}
		echo json_encode($result);
	}
	public function getuser()
	{
		global $db;
		$result = array();
		if(isset($_POST['id']) && $_POST['id'] != "")
		{
			$db->query("SELECT *, u.id as uid FROM hicrm_users as u 
			LEFT JOIN hicrm_departments as d ON u.user_dept = d.id
			WHERE u.id = '".$_POST['id']."'");
			if($db->num_row())
			{
				$user = $db->fetch_object(true);
				$result["id"] = $user->uid;
				$result["email"] = $user->user_email;
				$result["name"] = $user->user_fullname;
				$result["group"] = $user->user_group;
				$result["status"] = 200;
			}
			else
			{
				$result["status"] = 500;
				$result["message"] = "Tài khoản không tồn tại!";
			}
		}
		else
		{
			$result["status"] = 500;
			$result["message"] = "Dữ liệu không hợp lệ!";
		}
		echo json_encode($result);
	}
	// public function adduser()
	// {
	// 	global $db;
	// 	$result = array();
	// 	if(isset($_POST['updatetype']) && $_POST['updatetype'] == "new")
	// 	{
	// 		$email = mysql_real_escape_string($_POST["email"]);
	// 		$password = md5(mysql_real_escape_string($_POST["password"]));
	// 		$name = $_POST['name'];
	// 		$group = $_POST['group'];
	// 		$dept  = $_POST['dept'];
	// 		if(filter_var($email, FILTER_VALIDATE_EMAIL))
	// 		{
	// 			$db->query("SELECT * FROM hicrm_users WHERE user_email = '".$email."'");
	// 			if($db->num_row())
	// 			{
	// 				$result["status"] = 500;
	// 				$result["message"] = "Địa chỉ email đã được sử dụng!";
	// 			}
	// 			else
	// 			{
	// 				$db->query("INSERT INTO hicrm_users(user_email,user_password,user_fullname,user_group,user_dept,user_status) VALUES('".$email."','".$password."','".$name."','".$group."','".$dept."',1)");
	// 				$result["status"] = 200;
	// 			}
	// 		}
	// 		else
	// 		{
	// 			$result["status"] = 500;
	// 			$result["message"] = "Địa chỉ email không hợp lệ!";
	// 		}
	// 	}
	// 	elseif(isset($_POST['updatetype']) && $_POST['updatetype'] == "edit")
	// 	{
	// 		$password = "";
	// 		if($_POST["password"] != "")
	// 		{
	// 			$password = md5(mysql_real_escape_string($_POST["password"]));
	// 		}
	// 		$name = $_POST['name'];
	// 		$group = $_POST['group'];
	// 		$uid = $_POST['uid'];
	// 		$dept = $_POST['dept'];
	// 		if($password != "")
	// 		{
	// 			$db->query("UPDATE hicrm_users SET user_fullname = '".$name."', user_group = '".$group."',user_dept = '".$dept."', user_password = '".$password."' WHERE id = '".$uid."'");
	// 			$result["status"] = 200;
	// 		}
	// 		else
	// 		{
	// 			$db->query("UPDATE hicrm_users SET user_fullname = '".$name."', user_group = '".$group."',user_dept = '".$dept."' WHERE id = '".$uid."'");
	// 			$result["status"] = 200;
	// 		}
	// 	}
		
	// 	echo json_encode($result);
	// }
	public function deleteuser()
	{
		global $db;
		$result = array();
		$db->query("SELECT * FROM hicrm_users WHERE id = '".$_POST['id']."'");
		if($db->num_row())
		{
			$db->query("UPDATE hicrm_users SET user_status = '99' WHERE id = '".$_POST['id']."'");
			$result["status"] = 200;
		}
		else
		{
			$result["status"] = 500;
			$result["message"] = "Tài khoản không tồn tại";
		}
		echo json_encode($result);
	}
    public function register()
    {
        global $db;
        @error_reporting(0);
        while (ob_get_level()) { @ob_end_clean(); }
        header('Content-Type: application/json; charset=utf-8');
        header('Cache-Control: no-store');
        $result = array('success' => false, 'status' => 500, 'message' => 'Thông tin đăng ký không hợp lệ.');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $result['message'] = 'Phương thức không được hỗ trợ.';
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            return;
        }

        $csrf = isset($_POST['csrf']) ? (string)$_POST['csrf'] : '';
        if (!empty($_SESSION['register_csrf']) && !hash_equals($_SESSION['register_csrf'], $csrf)) {
            if (!empty($_SESSION['login_csrf']) && !hash_equals($_SESSION['login_csrf'], $csrf)) {
                $result['message'] = 'Phiên đăng ký đã hết hạn. Vui lòng tải lại trang.';
                echo json_encode($result, JSON_UNESCAPED_UNICODE);
                return;
            }
        }

        $fullname  = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
        $firstname = isset($_POST['firstname']) ? trim($_POST['firstname']) : '';
        $lastname  = isset($_POST['lastname']) ? trim($_POST['lastname']) : '';
        if ($fullname === '' && ($firstname !== '' || $lastname !== '')) {
            $fullname = trim($firstname . ' ' . $lastname);
        }

        $phone = isset($_POST['phone']) ? preg_replace('/[\s.\-]/', '', trim($_POST['phone'])) : '';
        $phone = preg_replace('/^(?:\+84|84)/', '0', $phone);
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $password = isset($_POST['password']) ? (string)$_POST['password'] : '';
        $repassword = isset($_POST['repassword']) ? (string)$_POST['repassword'] : '';

        if (mb_strlen($fullname) < 2) {
            $result['message'] = 'Vui lòng nhập họ và tên (tối thiểu 2 ký tự).';
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            return;
        }

        if (!preg_match('/^0[35789][0-9]{8}$/D', $phone)) {
            $result['message'] = 'Vui lòng nhập số điện thoại di động Việt Nam hợp lệ (10 chữ số, ví dụ: 0912345678).';
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            return;
        }

        if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $result['message'] = 'Địa chỉ email không đúng định dạng.';
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            return;
        }

        if (strlen($password) < 6) {
            $result['message'] = 'Mật khẩu phải có tối thiểu 6 ký tự.';
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            return;
        }

        if ($repassword !== '' && $repassword !== $password) {
            $result['message'] = 'Mật khẩu xác nhận không khớp.';
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            return;
        }

        // Kiểm tra số điện thoại đã tồn tại
        $checkPhone = $db->escapestring($phone);
        $db->query("SELECT id FROM hicrm_users WHERE user_phone = '".$checkPhone."' LIMIT 1");
        if ($db->num_row()) {
            $result = array('success' => false, 'status' => 409, 'message' => 'Số điện thoại này đã được đăng ký tài khoản. Vui lòng đăng nhập hoặc dùng số khác.');
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            return;
        }

        // Kiểm tra email nếu có
        if ($email !== '') {
            $checkEmail = $db->escapestring($email);
            $db->query("SELECT id FROM hicrm_users WHERE user_email = '".$checkEmail."' LIMIT 1");
            if ($db->num_row()) {
                $result = array('success' => false, 'status' => 409, 'message' => 'Địa chỉ email này đã được sử dụng.');
                echo json_encode($result, JSON_UNESCAPED_UNICODE);
                return;
            }
        }

        // Tạo tài khoản khách hàng mới với user_group = 0
        $hash = md5($password);
        $uName = $checkPhone;
        $fName = $db->escapestring($fullname);
        $eMail = $db->escapestring($email);
        $now = date('Y-m-d H:i:s');

        $db->query("INSERT INTO hicrm_users (user_username, user_password, user_email, user_fullname, user_phone, user_group, user_status, user_register_time) VALUES ('".$uName."', '".$hash."', '".$eMail."', '".$fName."', '".$checkPhone."', 0, 1, '".$now."')");
        $newId = (int)$db->insert_id();

        // Tự động đăng nhập khách hàng ngay sau khi đăng ký
        unset($_SESSION['user'], $_SESSION['staff'], $_SESSION['LoggedIn']);
        $_SESSION['customer'] = array(
            'id'       => $newId,
            'fullname' => $fullname,
            'phone'    => $phone,
            'email'    => $email,
            'avatar'   => '',
            'provider' => 'local',
            'zalo'     => false
        );
        $_SESSION['customer_csrf'] = bin2hex(random_bytes(32));
        $_SESSION['social_login_success'] = 'Đăng ký tài khoản thành công! Chào mừng ' . $fullname . '.';

        $result = array(
            'success'    => true,
            'status'     => 200,
            'message'    => 'Đăng ký thành công! Đang chuyển hướng...',
            'return_url' => XC_URL
        );
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

	public function registers()
	{
		global $db;
		$result = array();
		$email = $db->escapestring($_POST["email"]);
        $password = md5($db->escapestring($_POST["password"]));
		$username = $db->escapestring($_POST["username"]);
		$phone = $_POST['phone'];
		$fullname = $_POST['fullname'];
		if(filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			
			$db->query("SELECT * FROM hicrm_users WHERE user_email = '".$email."'");
			$db->fetch_object(true);
			if($db->num_row()){
				$result["status"] = 500;
				$result["message"] = "Địa chỉ email đã được sử dụng!";
			}else{
				$db->query("SELECT * FROM hicrm_users WHERE user_username = '".$username."'");
				$db->fetch_object(true);
				if($db->num_row()){
					$result["status"] = 500;
					$result["message"] = "Tên đăng nhập đã tồn tại!";
				}else{
					$db->query("SELECT * FROM hicrm_users WHERE user_phone = '".$phone."'");
					$db->fetch_object(true);
					if($db->num_row() > 5){
						$result["status"] = 500;
						$result["message"] = "Số điện thoại này đã đăng ký hơn 5 tài khoản!";
					}else{
						
						$db->query("INSERT INTO hicrm_users(user_username, user_password, user_email, user_fullname, user_phone, user_group,user_status, user_register_time) VALUES ('".$username."','".$password."','".$email."','".$fullname."','".$phone."','2','1','".date('Y-m-d H:i:s')."')");
						$result['message'] = "Đăng ký thành công!";
						$result["status"] = 200;
					}
				}
			}
		}else
		{
			$result["status"] = 500;
			$result["message"] = "Địa chỉ email không hợp lệ!";
		}
		
		echo json_encode($result);
			/*
			$db->query("SELECT * FROM hicrm_users WHERE user_email = '".$email."'");
			$db->fetch_object(true);
			if($db->num_row())
			{
				$result["status"] = 500;
				$result["message"] = "Địa chỉ email đã được sử dụng!";
			}
			elseif()
			{
				$db->query("SELECT * FROM hicrm_users WHERE user_phone = '".$phone."'");
				$db->fetch_object(true);
				if($db->num_row()){
					$result['message'] = "Số điện thoại đã được sử dụng!";
					$result['status'] = 200;
				}else{
					echo "INSERT INTO hicrm_users(user_username, user_password, user_email, user_fullname, user_phone, user_group,user_status, user_register_time) VALUES ('".$username."','".$password."','".$email."','".$fullname."','".$phone."','2','".date('Y-m-d H:i:s')."')";
					$db->query("INSERT INTO hicrm_users(user_username, user_password, user_email, user_fullname, user_phone, user_group,user_status, user_register_time) VALUES ('".$username."','".$password."','".$email."','".$fullname."','".$phone."','2','".date('Y-m-d H:i:s')."')");
					$result['message'] = "Đăng ký thành công!";
					$result["status"] = 200;
				}
			} */
		
	}
	public function deletelisting()
	{
		$result = array();
		global $db;
		$id = $_POST['id'];
		$db->query("SELECT * FROM bds_posts WHERE post_author = '".$_SESSION['user']['id']."' AND id = '".$id."'");
		if($db->num_row())
		{
			$db->query("DELETE FROM bds_posts WHERE post_author = '".$_SESSION['user']['id']."' AND id = '".$id."'");
			$result["status"] = 200;
		}
		else
		{
			$result["status"] = 500;
			$result["message"] = "Bạn không đủ quyền thực hiện thao tác này!";
		}
		echo json_encode($result);
	}
	public function admindeletelisting()
	{
		$result = array();
		global $db;
		$id = $_POST['id'];
		$db->query("SELECT * FROM hicrm_users WHERE id = '".$_SESSION['staff']['id']."' AND user_group IN (1,2,3)");
		if($db->num_row())
		{
			$db->query("SELECT * FROM bds_posts WHERE id = '".$id."'");
			if($db->num_row())
			{
				$db->query("UPDATE bds_posts SET post_status = 3 WHERE id = '".$id."'");
				$db->query("INSERT INTO bds_logs(uid,log_key,log_value) VALUES('".$_SESSION['staff']['id']."','DELETE_LISTING','".$id."')");
				$result["status"] = 200;
			}
			else
			{
				$result["status"] = 500;
				$result["message"] = "Không tồn tại nội dung này!";
			}
			
		}
		else
		{
			$result["status"] = 500;
			$result["message"] = "Bạn không có quyền thực hiện thao tác này!";
		}
		echo json_encode($result);
	}
	public function adminapprovedlisting()
	{
		$result = array();
		global $db;
		$id = $_POST['id'];
		$db->query("SELECT * FROM hicrm_users WHERE id = '".$_SESSION['staff']['id']."' AND user_group IN (1,2,3)");
		if($db->num_row())
		{
			$db->query("SELECT * FROM bds_posts WHERE id = '".$id."'");
			if($db->num_row())
			{
				$db->query("UPDATE bds_posts SET post_status = 1 WHERE id = '".$id."'");
				$db->query("INSERT INTO bds_logs(uid,log_key,log_value) VALUES('".$_SESSION['staff']['id']."','APPROVED_LISTING','".$id."')");
				$result["status"] = 200;
			}
			else
			{
				$result["status"] = 500;
				$result["message"] = "Không tồn tại nội dung này!";
			}
			
		}
		else
		{
			$result["status"] = 500;
			$result["message"] = "Bạn không có quyền thực hiện thao tác này!";
		}
		echo json_encode($result);
	}
	public function addproject()
	{
		global $db;
		$result = array();
		$updatetype = $_POST['updatetype'];
		if(isset($_POST['updatetype']) && $_POST['updatetype'] == "new")
		{
			$FinalFilenameFront = "";
			if(isset($_FILES['anhbia']))
			{
				$errors= array();
				$file_name = $_FILES['anhbia']['name'];
				$file_size =$_FILES['anhbia']['size'];
				$file_tmp =$_FILES['anhbia']['tmp_name'];
				$file_type=$_FILES['anhbia']['type'];
				$file_ext=strtolower(end(explode('.',$_FILES['anhbia']['name'])));
				$OriginalFilename = $FinalFilename = preg_replace('`[^a-z0-9-_.]`i','',$_FILES['anhbia']['name']); 
				$FinalFilenameFront = md5(time())."-".$FinalFilename;
				if(in_array($file_ext,$expensions)=== false){
					$errors[]="Extension not allowed, please choose a .png, .jpg file.";
				}
				if($file_size > 5242880){
					$errors[]='File size must be max 2Mb';
				}
				if(empty($errors)==true){
					move_uploaded_file($file_tmp,"./uploads/post/".$FinalFilenameFront);
					
				}else
				{
					$result["status"] = 500;
				}
			}
			$db->query("INSERT INTO bds_projects(project_name,project_holder,project_address,project_categories,project_area,project_scale,project_area_detail,project_price,project_intro) VALUES('".$_POST['name']."','".$_POST['holder']."','".$_POST['address']."','".$_POST['category']."','".$_POST['area']."','".$_POST['scale']."','".$_POST['ad']."','".$_POST['price']."','".$_POST['noidung']."')");
			$db->query("SELECT id FROM bds_projects ORDER BY id DESC LIMIT 1");
			$pid = $db->fetch_object(true)->id;
			$db->query("INSERT INTO bds_project_images(pid,image_url,image_feature) VALUES('".$pid."','".$FinalFilenameFront."',1)");
			if(isset($_POST['hinhanh']) && count($_POST['hinhanh']))
			{
				$hinhanh = $_POST['hinhanh'];
				$i = 0;
				foreach($hinhanh as $img)
				{
					$f = ($i == 0)? 1 : 0;
					$db->query("INSERT INTO bds_project_images(pid,image_url,image_feature) VALUES('".$pid."','".$img."','0')");
					$i++;
				}
			}
			$result["status"] = 200;
			$result["url"] = XC_URL."/uploads/general/".$FinalFilenameFront;
			$result["id"] = $FinalFilenameFront;
		}
		elseif(isset($_POST['updatetype']) && $_POST['updatetype'] == "edit")
		{
			$db->query("SELECT * FROM bds_projects WHERE id = '".$_POST['id']."'");
			if($db->num_row())
			{
				$FinalFilenameFront = "";
				$FinalFilenameFront2 = "";
				//echo $_FILES['hinhanh']['name']."ssss";
				if(isset($_FILES['hinhanh']))
				{
					$errors= array();
					$file_name = $_FILES['hinhanh']['name'];
					$file_size =$_FILES['hinhanh']['size'];
					$file_tmp =$_FILES['hinhanh']['tmp_name'];
					$file_type=$_FILES['hinhanh']['type'];
					$file_ext=strtolower(end(explode('.',$_FILES['hinhanh']['name'])));
					$OriginalFilename = $FinalFilename = preg_replace('`[^a-z0-9-_.]`i','',$_FILES['hinhanh']['name']); 
					$FinalFilenameFront = md5(time())."-".$FinalFilename;
					if(in_array($file_ext,$expensions)=== false){
						$errors[]="Extension not allowed, please choose a .png, .jpg file.";
					}
					if($file_size > 5242880){
						$errors[]='File size must be max 2Mb';
					}
					if(empty($errors)==true){
						move_uploaded_file($file_tmp,"./uploads/general/".$FinalFilenameFront);
						
					}else
					{
						$result["status"] = 500;
					}
					
				}
				if(isset($_FILES['feature']))
				{
					$errors= array();
					$file_name = $_FILES['feature']['name'];
					$file_size =$_FILES['feature']['size'];
					$file_tmp =$_FILES['feature']['tmp_name'];
					$file_type=$_FILES['feature']['type'];
					$file_ext=strtolower(end(explode('.',$_FILES['feature']['name'])));
					$OriginalFilename = $FinalFilename = preg_replace('`[^a-z0-9-_.]`i','',$_FILES['feature']['name']); 
					$FinalFilenameFront2 = md5(time())."-".$FinalFilename;
					if(in_array($file_ext,$expensions)=== false){
						$errors[]="Extension not allowed, please choose a .png, .jpg file.";
					}
					if($file_size > 5242880){
						$errors[]='File size must be max 2Mb';
					}
					if(empty($errors)==true){
						move_uploaded_file($file_tmp,"./uploads/general/".$FinalFilenameFront2);
						
					}else
					{
						$result["status"] = 500;
					}
					
				}
				$updateimage = ($FinalFilenameFront != "")? ", place_image = '".$FinalFilenameFront."'" : "";
				$updateimage2 = ($FinalFilenameFront2 != "")? ", place_feature_image = '".$FinalFilenameFront2."'" : "";
				$db->query("UPDATE bds_projects SET project_name = '".$_POST['name']."', project_address = '".$_POST['address']."', project_categories = '".$_POST['category']."', project_area = '".$_POST['area']."',project_scale = '".$_POST['scale']."',project_area_detail = '".$_POST['ad']."',project_price = '".$_POST['price']."',project_intro = '".$_POST['noidung']."' WHERE id = '".$_POST['id']."'");
				if($FinalFilenameFront != "")
				{
					$db->query("DELETE FROM bds_project_images WHERE pid = '".$_POST['id']."' AND image_feature = 1");
					$db->query("INSERT INTO bds_project_images(pid,image_url,image_feature) VALUES('".$pid."','".$FinalFilenameFront."',1)");
				}
				if(isset($_POST['hinhanh']) && count($_POST['hinhanh']))
				{
					$db->query("DELETE FROM bds_project_images WHERE pid = '".$_POST['id']."' AND image_feature = 0");
					$hinhanh = $_POST['hinhanh'];
					$i = 0;
					foreach($hinhanh as $img)
					{
						$f = ($i == 0)? 1 : 0;
						$db->query("INSERT INTO bds_project_images(pid,image_url,image_feature) VALUES('".$pid."','".$img."','0')");
						$i++;
					}
				}
				$result["status"] = 200;
			}
			else
			{
				$result["status"] = 500;
				$result["message"] = "Không tồn tại nội dung này!";
			}
		}
		echo json_encode($result);
		
	}
	public function addplace()
	{
		global $db;
		$result = array();
		$updatetype = $_POST['updatetype'];
		if(isset($_POST['updatetype']) && $_POST['updatetype'] == "new")
		{
			$FinalFilenameFront = "";
			$FinalFilenameFront2 = "";
			//echo $_FILES['hinhanh']['name']."ssss";
			if(isset($_FILES['hinhanh']))
			{
				$errors= array();
				$file_name = $_FILES['hinhanh']['name'];
				$file_size =$_FILES['hinhanh']['size'];
				$file_tmp =$_FILES['hinhanh']['tmp_name'];
				$file_type=$_FILES['hinhanh']['type'];
				$file_ext=strtolower(end(explode('.',$_FILES['hinhanh']['name'])));
				$OriginalFilename = $FinalFilename = preg_replace('`[^a-z0-9-_.]`i','',$_FILES['hinhanh']['name']); 
				$FinalFilenameFront = md5(time())."-".$FinalFilename;
				if(in_array($file_ext,$expensions)=== false){
					$errors[]="Extension not allowed, please choose a .png, .jpg file.";
				}
				if($file_size > 5242880){
					$errors[]='File size must be max 2Mb';
				}
				if(empty($errors)==true){
					move_uploaded_file($file_tmp,"./uploads/general/".$FinalFilenameFront);
					
				}else
				{
					$result["status"] = 500;
				}
				
			}
			if(isset($_FILES['feature']))
			{
				$errors= array();
				$file_name = $_FILES['feature']['name'];
				$file_size =$_FILES['feature']['size'];
				$file_tmp =$_FILES['feature']['tmp_name'];
				$file_type=$_FILES['feature']['type'];
				$file_ext=strtolower(end(explode('.',$_FILES['feature']['name'])));
				$OriginalFilename = $FinalFilename = preg_replace('`[^a-z0-9-_.]`i','',$_FILES['feature']['name']); 
				$FinalFilenameFront2 = md5(time())."-".$FinalFilename;
				if(in_array($file_ext,$expensions)=== false){
					$errors[]="Extension not allowed, please choose a .png, .jpg file.";
				}
				if($file_size > 5242880){
					$errors[]='File size must be max 2Mb';
				}
				if(empty($errors)==true){
					move_uploaded_file($file_tmp,"./uploads/general/".$FinalFilenameFront2);
					
				}else
				{
					$result["status"] = 500;
				}
				
			}
			$db->query("INSERT INTO bds_places(place_name,place_district,place_province,place_about,place_image,place_feature_image) VALUES('".$_POST['title']."','".$_POST['huyen']."','".$_POST['tinh']."','".$_POST['noidung']."','".$FinalFilenameFront."','".$FinalFilenameFront2."')");
			$result["status"] = 200;
			$result["url"] = XC_URL."/uploads/general/".$FinalFilenameFront;
			$result["id"] = $FinalFilenameFront;
		}
		elseif(isset($_POST['updatetype']) && $_POST['updatetype'] == "edit")
		{
			$db->query("SELECT * FROM bds_places WHERE id = '".$_POST['id']."'");
			if($db->num_row())
			{
				$FinalFilenameFront = "";
				$FinalFilenameFront2 = "";
				//echo $_FILES['hinhanh']['name']."ssss";
				if(isset($_FILES['hinhanh']))
				{
					$errors= array();
					$file_name = $_FILES['hinhanh']['name'];
					$file_size =$_FILES['hinhanh']['size'];
					$file_tmp =$_FILES['hinhanh']['tmp_name'];
					$file_type=$_FILES['hinhanh']['type'];
					$file_ext=strtolower(end(explode('.',$_FILES['hinhanh']['name'])));
					$OriginalFilename = $FinalFilename = preg_replace('`[^a-z0-9-_.]`i','',$_FILES['hinhanh']['name']); 
					$FinalFilenameFront = md5(time())."-".$FinalFilename;
					if(in_array($file_ext,$expensions)=== false){
						$errors[]="Extension not allowed, please choose a .png, .jpg file.";
					}
					if($file_size > 5242880){
						$errors[]='File size must be max 2Mb';
					}
					if(empty($errors)==true){
						move_uploaded_file($file_tmp,"./uploads/general/".$FinalFilenameFront);
						
					}else
					{
						$result["status"] = 500;
					}
					
				}
				if(isset($_FILES['feature']))
				{
					$errors= array();
					$file_name = $_FILES['feature']['name'];
					$file_size =$_FILES['feature']['size'];
					$file_tmp =$_FILES['feature']['tmp_name'];
					$file_type=$_FILES['feature']['type'];
					$file_ext=strtolower(end(explode('.',$_FILES['feature']['name'])));
					$OriginalFilename = $FinalFilename = preg_replace('`[^a-z0-9-_.]`i','',$_FILES['feature']['name']); 
					$FinalFilenameFront2 = md5(time())."-".$FinalFilename;
					if(in_array($file_ext,$expensions)=== false){
						$errors[]="Extension not allowed, please choose a .png, .jpg file.";
					}
					if($file_size > 5242880){
						$errors[]='File size must be max 2Mb';
					}
					if(empty($errors)==true){
						move_uploaded_file($file_tmp,"./uploads/general/".$FinalFilenameFront2);
						
					}else
					{
						$result["status"] = 500;
					}
					
				}
				$updateimage = ($FinalFilenameFront != "")? ", place_image = '".$FinalFilenameFront."'" : "";
				$updateimage2 = ($FinalFilenameFront2 != "")? ", place_feature_image = '".$FinalFilenameFront2."'" : "";
				$db->query("UPDATE bds_places SET place_name = '".$_POST['title']."', place_province = '".$_POST['tinh']."', place_district = '".$_POST['huyen']."', place_about = '".$_POST['noidung']."' ".$updateimage."".$updateimage2." WHERE id = '".$_POST['id']."'");
				$result["status"] = 200;
			}
			else
			{
				$result["status"] = 500;
				$result["message"] = "Không tồn tại nội dung này!";
			}
		}
		echo json_encode($result);
	}
	//===================================== NEWS FUNCTION ======================//
	
	public function addpage()
	{
		global $db;
		$result = array();
		$updatetype = $_POST['updatetype'];
		if(isset($_POST['updatetype']) && $_POST['updatetype'] == "new")
		{
			$FinalFilenameFront = "";
			
			if(isset($_FILES['hinhanh']))
			{
				$errors= array();
				$file_name = $_FILES['hinhanh']['name'];
				$file_size =$_FILES['hinhanh']['size'];
				$file_tmp =$_FILES['hinhanh']['tmp_name'];
				$file_type=$_FILES['hinhanh']['type'];
				$file_ext=strtolower(end(explode('.',$_FILES['hinhanh']['name'])));
				$OriginalFilename = $FinalFilename = preg_replace('`[^a-z0-9-_.]`i','',$_FILES['hinhanh']['name']); 
				$FinalFilenameFront = md5(time())."-".$FinalFilename;
				if(in_array($file_ext,$expensions)=== false){
					$errors[]="Extension not allowed, please choose a .png, .jpg file.";
				}
				if($file_size > 5242880){
					$errors[]='File size must be max 2Mb';
				}
				if(empty($errors)==true){
					move_uploaded_file($file_tmp,"./uploads/general/".$FinalFilenameFront);
					
				}else
				{
					$result["status"] = 500;
				}
				
			}
			
			$db->query("INSERT INTO bds_pages(page_title,page_content,page_author,page_view,page_image) VALUES('".$_POST['title']."','".$_POST['noidung']."','".$_SESSION['staff']['id']."',0,'".$FinalFilenameFront."')");
			$result["status"] = 200;
			$result["url"] = XC_URL."/uploads/general/".$FinalFilenameFront;
			$result["id"] = $FinalFilenameFront;
		}
		elseif(isset($_POST['updatetype']) && $_POST['updatetype'] == "edit")
		{
			$db->query("SELECT * FROM bds_pages WHERE id = '".$_POST['id']."'");
			if($db->num_row())
			{
				$FinalFilenameFront = "";
				//echo $_FILES['hinhanh']['name']."ssss";
				if(isset($_FILES['hinhanh']))
				{
					$errors= array();
					$file_name = $_FILES['hinhanh']['name'];
					$file_size =$_FILES['hinhanh']['size'];
					$file_tmp =$_FILES['hinhanh']['tmp_name'];
					$file_type=$_FILES['hinhanh']['type'];
					$file_ext=strtolower(end(explode('.',$_FILES['hinhanh']['name'])));
					$OriginalFilename = $FinalFilename = preg_replace('`[^a-z0-9-_.]`i','',$_FILES['hinhanh']['name']); 
					$FinalFilenameFront = md5(time())."-".$FinalFilename;
					if(in_array($file_ext,$expensions)=== false){
						$errors[]="Extension not allowed, please choose a .png, .jpg file.";
					}
					if($file_size > 5242880){
						$errors[]='File size must be max 2Mb';
					}
					if(empty($errors)==true){
						move_uploaded_file($file_tmp,"./uploads/general/".$FinalFilenameFront);
						
					}else
					{
						$result["status"] = 500;
					}
					
				}
				
				$updateimage = ($FinalFilenameFront != "")? ", page_image = '".$FinalFilenameFront."'" : "";
				$db->query("UPDATE bds_pages SET page_title = '".$_POST['title']."', page_content = '".$_POST['noidung']."' ".$updateimage." WHERE id = '".$_POST['id']."'");
				$result["status"] = 200;
			}
			else
			{
				$result["status"] = 500;
				$result["message"] = "Không tồn tại nội dung này!";
			}
		}
		echo json_encode($result);
	}
	public function deletepage()
	{
		global $db;
		$result = array();
		$db->query("SELECT * FROM bds_pages WHERE id = '".$_POST['id']."'");
		if($db->num_row())
		{
			$db->query("DELETE FROM bds_pages WHERE id = '".$_POST['id']."'");
			$result["status"] = 200;
		}
		else
		{
			$result["status"] = 500;
			$result["message"] = "Nội dung không tồn tại";
		}
		echo json_encode($result);
	}
	public function getpage()
	{
		global $db;
		$result = array();
		$db->query("SELECT * FROM bds_pages WHERE id = '".$_POST['id']."' LIMIT 1");
		if($db->num_row())
		{
			$news = $db->fetch_object(true);
			$result["status"] = 200;
			$result["title"] = $news->page_title;
			$result["content"] = $news->page_content;
		}
		else
		{
			$result["status"] = 500;
			$result["message"] = "Nội dung không tồn tại";
		}
		
		echo json_encode($result);
	}
	public function getnews()
	{
		global $db;
		$result = array();
		$db->query("SELECT * FROM bds_news WHERE id = '".$_POST['id']."' LIMIT 1");
		if($db->num_row())
		{
			$news = $db->fetch_object(true);
			$result["status"] = 200;
			$result["title"] = $news->news_title;
			$result["content"] = $news->news_content;
			$db->query("SELECT * FROM bds_news_categories");
			$cats = $db->fetch_object();
			$cate = '';
			foreach($cats as $d)
			{
				$selected = ($d->id == $news->news_category)? "selected" : "";
				$cate .= '<option value="'.$d->id.'" '.$selected.'>'.$d->cat_name.'</option>';
			}
			$result["category"] = $cate;
		}
		else
		{
			$result["status"] = 500;
			$result["message"] = "Nội dung không tồn tại";
		}
		
		echo json_encode($result);
	}
	public function deletenews()
	{
		global $db;
		$result = array();
		$db->query("SELECT * FROM hicrm_news WHERE id = '".$_POST['id']."'");
		if($db->num_row())
		{
			$db->query("UPDATE hicrm_news SET new_status = '99' WHERE id = '".$_POST['id']."'");
			$result["status"] = 200;
		}
		else
		{
			$result["status"] = 500;
			$result["message"] = "Nội dung không tồn tại";
		}
		echo json_encode($result);
	}
	//===================================== END NEWS FUNCTION ======================//
	
	
	//==================================CATEGORY FUNCTION ==========================//
	public function addcat()
	{
		global $db;
		$result = array();
		$updatetype = $_POST['updatetype'];
		$title = $_POST['title'];
		if(isset($_POST['updatetype']) && $_POST['updatetype'] == "new")
		{
			$db->query("SELECT * FROM bds_categories WHERE cat_name = '".$title."'");
			if($db->num_row())
			{
				$result["status"] = 400;
				$result["message"] = "Danh mục này đã tồn tại!";
			}
			else
			{
				$db->query("INSERT INTO bds_categories(cat_name) VALUES('".$title."')");
				$result["status"] = 200;
			}
		}
		else
		{
			$id = $_POST['id'];
			$db->query("SELECT * FROM bds_categories WHERE id = '".$id."'");
			if($db->num_row())
			{
				$db->query("SELECT * FROM bds_categories WHERE cat_name = '".$title."'");
				if($db->num_row())
				{
					$result["status"] = 400;
					$result["message"] = "Danh mục này đã tồn tại!";
				}
				else
				{
					$db->query("UPDATE bds_categories SET cat_name = '".$title."' WHERE id = '".$id."'");
					$result["status"] = 200;
				}
			}
			else
			{
				$result["status"] = 404;
				$result["message"] = "Không tìm thấy nội dung này";
			}
		}
		echo json_encode($result);
	}
	public function adddepart()
	{
		global $db;
		$result = array();
		$updatetype = $_POST['updatetype'];
		$title = $_POST['title'];
		if(isset($_POST['updatetype']) && $_POST['updatetype'] == "new")
		{
			$db->query("SELECT * FROM hicrm_departments WHERE depart_name = '".$title."'");
			if($db->num_row())
			{
				$result["status"] = 400;
				$result["message"] = "Phòng ban này đã tồn tại!";
			}
			else
			{
				$db->query("INSERT INTO hicrm_departments(depart_name) VALUES('".$title."')");
				$result["status"] = 200;
			}
		}
		else
		{
			$id = $_POST['id'];
			$db->query("SELECT * FROM hicrm_departments WHERE id = '".$id."'");
			if($db->num_row())
			{
				$db->query("SELECT * FROM hicrm_departments WHERE depart_name = '".$title."'");
				if($db->num_row())
				{
					$result["status"] = 400;
					$result["message"] = "Phòng ban này đã tồn tại!";
				}
				else
				{
					$db->query("UPDATE hicrm_departments SET depart_name = '".$title."' WHERE id = '".$id."'");
					$result["status"] = 200;
				}
			}
			else
			{
				$result["status"] = 404;
				$result["message"] = "Không tìm thấy phòng ban này";
			}
		}
		echo json_encode($result);
	}
	public function addmenu()
	{
		global $db;
		$result = array();
		$updatetype = $_POST['updatetype'];
		$title = $_POST['title'];
		$url = $_POST['url'];
		$order = $_POST['order'];
		if(isset($_POST['updatetype']) && $_POST['updatetype'] == "new")
		{
			$db->query("SELECT * FROM bds_menus WHERE menu_title = '".$title."'");
			if($db->num_row())
			{
				$result["status"] = 400;
				$result["message"] = "Danh mục này đã tồn tại!";
			}
			else
			{
				$db->query("INSERT INTO bds_menus(menu_title,menu_url,menu_order) VALUES('".$title."','".$url."','".$order."')");
				$result["status"] = 200;
			}
		}
		else
		{
			$id = $_POST['id'];
			$db->query("SELECT * FROM bds_menus WHERE id = '".$id."'");
			if($db->num_row())
			{
				$db->query("SELECT * FROM bds_menus WHERE menu_title = '".$title."'");
				if($db->num_row())
				{
					$result["status"] = 400;
					$result["message"] = "Danh mục này đã tồn tại!";
				}
				else
				{
					$db->query("UPDATE bds_menus SET menu_title = '".$title."', menu_url = '".$url."', menu_order = '".$order."' WHERE id = '".$id."'");
					$result["status"] = 200;
				}
			}
			else
			{
				$result["status"] = 404;
				$result["message"] = "Không tìm thấy nội dung này";
			}
		}
		echo json_encode($result);
	}
	public function deletemenu()
	{
		global $db;
		$result = array();
		$id = $_POST['id'];
		$db->query("SELECT * FROM bds_menus WHERE id = '".$id."'");
		if($db->num_row())
		{
			$db->query("DELETE FROM bds_menus WHERE id = '".$id."'");
			$result["status"] = 200;
		}
		else
		{
			$result["status"] = 500;
			$result["message"] = "Không tìm thấy danh mục này!";
		}
		echo json_encode($result);
	}
	public function deletecat()
	{
		global $db;
		$result = array();
		$id = $_POST['id'];
		$db->query("SELECT * FROM bds_categories WHERE id = '".$id."'");
		if($db->num_row())
		{
			$db->query("DELETE FROM bds_categories WHERE id = '".$id."'");
			$result["status"] = 200;
		}
		else
		{
			$result["status"] = 500;
			$result["message"] = "Không tìm thấy danh mục này!";
		}
		echo json_encode($result);
	}
	public function deletedepart()
	{
		global $db;
		$result = array();
		$id = $_POST['id'];
		$db->query("SELECT * FROM hicrm_departments WHERE id = '".$id."'");
		if($db->num_row())
		{
			$db->query("DELETE FROM hicrm_departments WHERE id = '".$id."'");
			$result["status"] = 200;
		}
		else
		{
			$result["status"] = 500;
			$result["message"] = "Không tìm thấy phòng ban này!";
		}
		echo json_encode($result);
	}
	public function getplace()
	{
		global $db;
		$result = array();
		$db->query("SELECT * FROM bds_places WHERE id = '".$_POST['id']."' LIMIT 1");
		if($db->num_row())
		{
			$place = $db->fetch_object(true);
			$result["status"] = 200;
			$result["title"] = $place->place_name;
			$result["province"] = $place->place_province;
			$result["about"] = $place->place_about;
			$db->query("SELECT * FROM hicrm_districts WHERE district_province = '".$place->place_province."'");
			$districts = $db->fetch_object();
			$districttext = '';
			foreach($districts as $d)
			{
				$selected = ($d->id == $place->place_district)? "selected" : "";
				$districttext .= '<option value="'.$d->id.'" '.$selected.'>'.$d->district_name.'</option>';
			}
			$result["district"] = $districttext;
		}
		else
		{
			$result["status"] = 500;
			$result["message"] = "Nội dung không tồn tại";
		}
		
		echo json_encode($result);
	}
	public function getproject()
	{
		global $db;
		$result = array();
		$db->query("SELECT * FROM bds_projects WHERE id = '".$_POST['id']."' LIMIT 1");
		if($db->num_row())
		{
			$place = $db->fetch_object(true);
			$result["status"] = 200;
			$result["title"] = $place->project_name;
			$result["holder"] = $place->project_holder;
			$result["address"] = $place->project_address;
			$result["area"] = $place->project_area;
			$result["price"] = $place->project_price;
			$result["scale"] = $place->project_scale;
			$result["category"] = $place->project_categories;
			$result["intro"] = $place->project_intro;
			$result["area_detail"] = $place->project_area_detail;
		}
		else
		{
			$result["status"] = 500;
			$result["message"] = "Nội dung không tồn tại";
		}
		
		echo json_encode($result);
	}
	public function favorite()
	{
		$result = array();
		global $db;
		$id = $_POST['id'];
		if(isset($_SESSION["user"]["id"]) && $_SESSION["user"]["id"] != "")
		{
			$db->query("SELECT * FROM bds_user_favorites WHERE uid = '".$_SESSION['user']['id']."' AND pid = '".$id."'");
			if($db->num_row())
			{
				$db->query("DELETE FROM bds_user_favorites WHERE uid = '".$_SESSION['user']['id']."' AND pid = '".$id."'");
				$result["status"] = 200;
				$result["message"] = "Đã xóa tin này khỏi danh sách quan tâm";
				$result["url"] = XC_URL."/danh-sach-quan-tam.html";
			}
			else
			{
				$db->query("INSERT INTO bds_user_favorites(uid,pid) VALUES('".$_SESSION['user']['id']."','".$id."')");
				$result["status"] = 200;
				$result["message"] = "Đã thêm tin này vào danh sách quan tâm";
				$result["url"] = XC_URL."/danh-sach-quan-tam.html";
			}
		}
		else
		{
			$result["status"] = 503;
			$result["message"] = "Vui lòng đăng nhập để thực hiện thao tác này!";
			$result["url"] = XC_URL."/login";
		}
		echo json_encode($result);
	}
	public function changepass()
	{
		global $db;
		$result = array();
		if(!(isset($_SESSION['user']['id']) && $_SESSION['user']['id'] != ""))
		{
			$result["status"] = 500;
			$result["message"] = "Vui lòng đăng nhập lại để tiếp tục!";
			$result["url"] = XC_URL."/admin/login";
			echo json_encode($result);
			return;
		}
		$uid = $_SESSION['user']['id'];
		$oldpass_plain = isset($_POST["oldpass"]) ? trim($_POST["oldpass"]) : "";
		$newpass_plain = isset($_POST["newpass"]) ? trim($_POST["newpass"]) : "";
		$renewpass_plain = isset($_POST["renewpass"]) ? trim($_POST["renewpass"]) : "";
		if($oldpass_plain == "" || $newpass_plain == "" || $renewpass_plain == "")
		{
			$result["status"] = 500;
			$result["message"] = "Vui lòng nhập đầy đủ thông tin!";
			echo json_encode($result);
			return;
		}
		if($newpass_plain !== $renewpass_plain)
		{
			$result["status"] = 500;
			$result["message"] = "Mật khẩu mới không khớp!";
			echo json_encode($result);
			return;
		}
		$oldpass = md5($db->escapestring($oldpass_plain));
		$newpass = md5($db->escapestring($newpass_plain));
		$db->query("SELECT * FROM hicrm_users WHERE id = '".$uid."' AND user_password = '".$oldpass."'");
		if($db->num_row())
		{
			$db->query("UPDATE hicrm_users SET user_password = '".$newpass."' WHERE id = '".$uid."'");
			$result["status"] = 200;
			$result["message"] = "Đổi mật khẩu thành công. Vui lòng đăng nhập lại!";
			$result["url"] = XC_URL."/admin/login";
			unset($_SESSION["user"]);
		}
		else
		{
			$result["status"] = 500;
			$result["message"] = "Mật khẩu cũ không đúng, vui lòng thử lại!";
		}
		echo json_encode($result);
	}
	public function upload()
	{
		$result = array();
		if(isset($_FILES['file']))
		{
			$errors= array();
			$file_name = $_FILES['file']['name'];
			$file_size =$_FILES['file']['size'];
			$file_tmp =$_FILES['file']['tmp_name'];
			$file_type=$_FILES['file']['type'];
			$file_ext=strtolower(end(explode('.',$_FILES['file']['name'])));
			$OriginalFilename = $FinalFilename = preg_replace('`[^a-z0-9-_.]`i','',$_FILES['file']['name']); 
			$FinalFilenameFront = md5(time())."-".$FinalFilename;
			if(in_array($file_ext,$expensions)=== false){
				$errors[]="Extension not allowed, please choose a .pdf, .doc, .docx file.";
			}
			// Set the files size limit. Use this tool to convert the file size param https://www.thecalculator.co/others/File-Size-Converter-69.html
			if($file_size > 5242880){
				$errors[]='File size must be max 2Mb';
			}
			if(empty($errors)==true){
				move_uploaded_file($file_tmp,"./uploads/post/".$FinalFilenameFront);
				$result["status"] = 200;
				$result["url"] = XC_URL."/uploads/post/".$FinalFilenameFront;
				$result["id"] = $FinalFilenameFront;
			}else
			{
				$result["status"] = 500;
			}
			
		}
		echo json_encode($result);
	}
	public function uploadavatar()
	{
		global $db;
		$result = array();
		if(isset($_FILES['file']))
		{
			$errors= array();
			$file_name = $_FILES['file']['name'];
			$file_size =$_FILES['file']['size'];
			$file_tmp =$_FILES['file']['tmp_name'];
			$file_type=$_FILES['file']['type'];
			$file_ext=strtolower(end(explode('.',$_FILES['file']['name'])));
			$OriginalFilename = $FinalFilename = preg_replace('`[^a-z0-9-_.]`i','',$_FILES['file']['name']); 
			$FinalFilenameFront = md5(time())."-".$FinalFilename;
			if(in_array($file_ext,$expensions)=== false){
				$errors[]="Extension not allowed, please choose a .pdf, .doc, .docx file.";
			}
			// Set the files size limit. Use this tool to convert the file size param https://www.thecalculator.co/others/File-Size-Converter-69.html
			if($file_size > 5242880){
				$errors[]='File size must be max 2Mb';
			}
			if(empty($errors)==true){
				move_uploaded_file($file_tmp,"./uploads/users/".$FinalFilenameFront);
				$db->query("UPDATE hicrm_users SET user_avatar = '".$FinalFilenameFront."' WHERE id = '".$_SESSION['user']['id']."'");
				$result["status"] = 200;
				$result["url"] = XC_URL."/uploads/users/".$FinalFilenameFront;
				$result["id"] = $FinalFilenameFront;
			}else
			{
				$result["status"] = 500;
			}
			
		}
		echo json_encode($result);
	}
	public function uploadslider()
	{
		global $db;
		$result = array();
		if(isset($_FILES['file']))
		{
			$errors= array();
			$file_name = $_FILES['file']['name'];
			$file_size =$_FILES['file']['size'];
			$file_tmp =$_FILES['file']['tmp_name'];
			$file_type=$_FILES['file']['type'];
			$file_ext=strtolower(end(explode('.',$_FILES['file']['name'])));
			$OriginalFilename = $FinalFilename = preg_replace('`[^a-z0-9-_.]`i','',$_FILES['file']['name']); 
			$FinalFilenameFront = md5(time())."-".$FinalFilename;
			if(in_array($file_ext,$expensions)=== false){
				$errors[]="Extension not allowed, please choose a .pdf, .doc, .docx file.";
			}
			// Set the files size limit. Use this tool to convert the file size param https://www.thecalculator.co/others/File-Size-Converter-69.html
			if($file_size > 5242880){
				$errors[]='File size must be max 2Mb';
			}
			if(empty($errors)==true){
				move_uploaded_file($file_tmp,"./uploads/general/".$FinalFilenameFront);
				$db->query("UPDATE bds_configs SET config_value = '".$FinalFilenameFront."' WHERE config_key = 'slider_image'");
				$result["status"] = 200;
				$result["url"] = XC_URL."/uploads/general/".$FinalFilenameFront;
				$result["id"] = $FinalFilenameFront;
			}else
			{
				$result["status"] = 500;
			}
			
		}
		echo json_encode($result);
	}
	public function getdistrict()
	{
		$result = array();
		global $db;
		$pid = $_POST['pid'];
		$db->query("SELECT * FROM hicrm_districts WHERE district_province = '".$pid."'");
		if($db->num_row())
		{
			$districts = $db->fetch_object();
			$data = '';
			foreach($districts as $d)
			{
				$data .= '<option value="'.$d->id.'">'.$d->district_name.'</option>';
			}
			$result["status"] = 200;
			$result["data"] = $data;
		}
		else
		{
			$result["status"] = 500;
			$result["message"] = "Không tồn tại tỉnh/thành";
		}
		echo json_encode($result);
	}
	public function getward()
	{
		$result = array();
		global $db;
		$did = $_POST['did'];
		$db->query("SELECT * FROM hicrm_wards WHERE ward_district = '".$did."'");
		if($db->num_row())
		{
			$districts = $db->fetch_object();
			$data = '';
			foreach($districts as $d)
			{
				$data .= '<option value="'.$d->id.'">'.$d->ward_name.'</option>';
			}
			$result["status"] = 200;
			$result["data"] = $data;
		}
		else
		{
			$result["status"] = 500;
			//$result["message"] = "Không tồn tại quận/huyện";
		}
		echo json_encode($result);
	}
	public function post()
	{
		global $db;
		$result = array();
		$code = general::getInstance()->generateid("transaction");
		$price = str_replace('.','',$_POST['tonggia']);
		$metas = $_POST['metas'];
		//$metas = json_decode($metas);
		$db->query("INSERT INTO bds_posts(post_code, post_title,post_content,post_type,post_author,post_category,post_price,post_ward,post_district,post_province,post_featured,post_update_time,post_view,post_status,post_appoved_by,post_video,post_title_en,post_content_en) VALUES('".$code."','".$_POST['title']."','".$_POST['noidung']."','".$_POST['type']."','".$_SESSION['user']['id']."','".$_POST['category']."','".$price."','".$_POST['xa']."','".$_POST['huyen']."','".$_POST['tinh']."',1,'".date("Y-m-d H:i:s")."',0,0,1,'".$_POST['video']."','".$_POST['title_en']."','".$_POST['noidung_en']."')");
		$db->query("SELECT id FROM bds_posts WHERE post_code = '".$code."' ORDER BY post_create_time DESC LIMIT 1");
		$postid = $db->fetch_object(true)->id;
		if(isset($_POST['dongia']) && $_POST['dongia'] != "")
		{
			$db->query("INSERT INTO bds_post_metas(pid,meta_key,meta_value) VALUES('".$postid."','DON_GIA','".$_POST['dongia']."')");
		}
		
		foreach ($metas as $mt)
		{
			$text = explode("|",$mt);
			//$textdata .= $mt." - ssss -";
			$db->query("INSERT INTO bds_post_metas(pid,meta_key,meta_value) VALUES('".$postid."','".$text[0]."','".$text[1]."')");
		}
		/*
		if(isset($_POST['duongvao']) && $_POST['duongvao'] != "")
		{
			$db->query("INSERT INTO bds_post_metas(pid,meta_key,meta_value) VALUES('".$postid."','DUONG_VAO','".$_POST['duongvao']."')");
		}
		if(isset($_POST['mattien']) && $_POST['mattien'] != "")
		{
			$db->query("INSERT INTO bds_post_metas(pid,meta_key,meta_value) VALUES('".$postid."','MAT_TIEN','".$_POST['mattien']."')");
		}
		if(isset($_POST['sophong']) && $_POST['sophong'] != "")
		{
			$db->query("INSERT INTO bds_post_metas(pid,meta_key,meta_value) VALUES('".$postid."','SO_PHONG','".$_POST['sophong']."')");
		}
		if(isset($_POST['sophongwc']) && $_POST['sophongwc'] != "")
		{
			$db->query("INSERT INTO bds_post_metas(pid,meta_key,meta_value) VALUES('".$postid."','SO_PHONG_WC','".$_POST['sophongwc']."')");
		}
		if(isset($_POST['dien_tich']) && $_POST['dien_tich'] != "")
		{
			$db->query("INSERT INTO bds_post_metas(pid,meta_key,meta_value) VALUES('".$postid."','DIEN_TICH','".$_POST['dien_tich']."')");
		}
		*/
		if(isset($_POST['hinhanh']) && count($_POST['hinhanh']))
		{
			$hinhanh = $_POST['hinhanh'];
			$i = 0;
			foreach($hinhanh as $img)
			{
				$f = ($i == 0)? 1 : 0;
				$db->query("INSERT INTO bds_images(pid,image_url,image_feature) VALUES('".$postid."','".$img."','".$f."')");
				$i++;
			}
		}
		$result["status"] = 200;
		$result["code"] = $code;
		$result["data"]["data"] = $_POST['metas'];
		$result["data"]["post"] = $_POST;
		echo json_encode($result);
	}
	public function editpost()
	{
		global $db;
		$result = array();
		$id = $_POST['id'];
		//$code = general::getInstance()->generateid("transaction");
		$price = str_replace('.','',$_POST['tonggia']);
		if($_POST['title'] != ""){ $db->query("UPDATE bds_posts SET post_title = '".$_POST['title']."' WHERE id = '".$id."'"); }
		if($_POST['title_en'] != ""){ $db->query("UPDATE bds_posts SET post_title_en = '".$_POST['title_en']."' WHERE id = '".$id."'"); }
		if($_POST['noidung'] != ""){ $db->query("UPDATE bds_posts SET post_content = '".$_POST['noidung']."' WHERE id = '".$id."'"); }
		if($_POST['noidung_en'] != ""){ $db->query("UPDATE bds_posts SET post_content_en = '".$_POST['noidung_en']."' WHERE id = '".$id."'"); }
		if($_POST['type'] != ""){ $db->query("UPDATE bds_posts SET post_type = '".$_POST['type']."' WHERE id = '".$id."'"); }
		if($_POST['category'] != ""){ $db->query("UPDATE bds_posts SET post_category = '".$_POST['category']."' WHERE id = '".$id."'"); }
		if($price != 0){ $db->query("UPDATE bds_posts SET post_price = '".$price."' WHERE id = '".$id."'"); }
		if($_POST['xa'] != ""){ $db->query("UPDATE bds_posts SET post_ward = '".$_POST['xa']."' WHERE id = '".$id."'"); }
		if($_POST['huyen'] != ""){ $db->query("UPDATE bds_posts SET post_district = '".$_POST['huyen']."' WHERE id = '".$id."'"); }
		if($_POST['tinh'] != ""){ $db->query("UPDATE bds_posts SET post_province = '".$_POST['tinh']."' WHERE id = '".$id."'"); }
		if($_POST['video'] != ""){ $db->query("UPDATE bds_posts SET post_video = '".$_POST['video']."' WHERE id = '".$id."'"); }
		
		//$db->query("INSERT INTO bds_posts(post_code, post_title,post_content,post_type,post_author,post_category,post_price,post_ward,post_district,post_province,post_featured,post_update_time,post_view,post_status,post_appoved_by) VALUES('".$code."','".$_POST['title']."','".$_POST['noidung']."','".$_POST['type']."','".$_SESSION['user']['id']."','".$_POST['category']."','".$price."','".$_POST['xa']."','".$_POST['huyen']."','".$_POST['tinh']."',1,'".date("Y-m-d H:i:s")."',0,0,1)");
		//$db->query("SELECT id FROM bds_posts WHERE post_code = '".$code."' ORDER BY post_create_time DESC LIMIT 1");
		$postid = $id;
		if(isset($_POST['dongia']) && $_POST['dongia'] != "")
		{
			$db->query("UPDATE bds_post_metas SET meta_value = '".$_POST['dongia']."' WHERE pid = '".$postid."' AND meta_key = 'DON_GIA'");
		}
		if(isset($_POST['duongvao']) && $_POST['duongvao'] != "")
		{
			$db->query("UPDATE bds_post_metas SET meta_value = '".$_POST['duongvao']."' WHERE pid = '".$postid."' AND meta_key = 'DUONG_VAO'");
		}
		if(isset($_POST['mattien']) && $_POST['mattien'] != "")
		{
			$db->query("UPDATE bds_post_metas SET meta_value = '".$_POST['mattien']."' WHERE pid = '".$postid."' AND meta_key = 'MAT_TIEN'");
		}
		if(isset($_POST['sophong']) && $_POST['sophong'] != "")
		{
			$db->query("UPDATE bds_post_metas SET meta_value = '".$_POST['sophong']."' WHERE pid = '".$postid."' AND meta_key = 'SO_PHONG'");
		}
		if(isset($_POST['sophongwc']) && $_POST['sophongwc'] != "")
		{
			$db->query("UPDATE bds_post_metas SET meta_value = '".$_POST['sophongwc']."' WHERE pid = '".$postid."' AND meta_key = 'SO_PHONG_WC'");
		}
		if(isset($_POST['dien_tich']) && $_POST['dien_tich'] != "")
		{
			$db->query("UPDATE bds_post_metas SET meta_value = '".$_POST['dien_tich']."' WHERE pid = '".$postid."' AND meta_key = 'DIEN_TICH'");
		}
		if(isset($_POST['hinhanh']) && count($_POST['hinhanh']))
		{
			$db->query("DELETE FROM bds_images WHERE pid = '".$id."'");
			$hinhanh = $_POST['hinhanh'];
			$i = 0;
			foreach($hinhanh as $img)
			{
				$f = ($i == 0)? 1 : 0;
				$db->query("INSERT INTO bds_images(pid,image_url,image_feature) VALUES('".$postid."','".$img."','".$f."')");
				$i++;
			}
		}
		$result["status"] = 200;
		$result["code"] = $code;
		$result["data"] = $_POST;
		echo json_encode($result);
	}
	public function testval()
	{
		$price = "55.000.000";
		echo floatval($price);
	}
	public function getmetadata()
	{
		$category = $_POST['cat'];
		$result = array();
		global $db;
		$db->query("SELECT * FROM bds_meta_datas as md
		LEFT JOIN bds_meta_type as mt ON md.meta_data = mt.id
		WHERE post_category = '".$category."'");
		$result["status"] = 200;
		$datatext = '';
		$listmeta = $db->fetch_object();
		foreach($listmeta as $meta)
		{
			$datatext .= '<div class="col-md-6">
                                       <div class="form-group">
                                          <label>'.$meta->meta_name.' ('.$meta->meta_unit.')</label>
                                          <input type="text" maxlength="4" class="fmfloat form-control form-control-sm" name="metadata[]" id="metadata[]" data-key="'.$meta->meta_key.'" value="">
                                       </div>
                                    </div>';
		}
		$result["data"] = $datatext;
		echo json_encode($result);
	}
	public function getmetadatacat()
	{
		global $db;
		$result = array();
		$depart = $_POST['id'];
		$db->query("SELECT permission_id FROM hicrm_permission_datas WHERE depart = '".$depart."'");
		$list = $db->fetch_object();
		$metaa = array();
		foreach($list as $meta)
		{
			array_push($metaa,$meta->permission_id);
		}
		$listmeta = home::getInstance()->get_list_permission();
		$text = '';
		foreach($listmeta as $per)
		{
			$selected = (in_array($per->id,$metaa))? "checked=checked" : "";
			$text .= '<div class="col-3">
								<div class="form-check">
									<input class="form-check-input" '.$selected.' type="checkbox" value="'.$per->id.'" id="'.$per->id.'" name="metadata[]">
									<label class="form-check-label" for="'.$per->id.'">'.$per->permission_name.'</label>
								</div>
							</div>';
		}
		$result["status"] = 200;
		$result["data"] = $text;
		echo json_encode($result);
	}
	public function getmetabycategory()
	{
		global $db;
		$result = array();
		$catid = $_POST['id'];
		$db->query("SELECT meta_data FROM bds_meta_datas WHERE post_category = '".$catid."'");
		$list = $db->fetch_object();
		$metaa = array();
		foreach($list as $meta)
		{
			array_push($metaa,$meta->meta_data);
		}
		$result["status"] = 200;
		$result["data"] = $metaa;
		echo json_encode($result);
	}
	public function updatecatmeta()
	{
		global $db;
		$result = array();
		$catid = $_POST['id'];
		$meta = $_POST['data'];
		$db->query("DELETE FROM hicrm_permission_datas WHERE depart = '".$catid."'");
		foreach($meta as $m)
		{
			$db->query("INSERT INTO hicrm_permission_datas(depart,permission_id) VALUES('".$catid."','".$m."')");
		}
		$result["status"] = 200;
		$result["data"] = $meta;
		echo json_encode($result);
	}
	public function setlanguage()
	{
		$result = array();
		$_SESSION['lang'] = $_POST['lang'];
		$result["status"] = 200;
		echo json_encode($result);
	}
	
	//AGENCY API
	public function ApproveAgency()
	{
		global $db;
		$result = array();
		$db->query("SELECT * FROM ow_users WHERE id = '".$_POST['id']."' AND user_is_agency = 2");
		if($db->num_row())
		{
			$db->query("UPDATE ow_users SET user_is_agency = 1 WHERE id = '".$_POST['id']."'");
			$result["status"] = 200;
		}
		else
		{
			$result["status"] = 404;
			$result["message"] = "Không tìm thấy tài khoản!";
		}
		echo json_encode($result);
	}
	public function DenineAgency()
	{
		global $db;
		$result = array();
		$db->query("SELECT * FROM ow_users WHERE id = '".$_POST['id']."' AND user_is_agency = 2");
		if($db->num_row())
		{
			$db->query("UPDATE ow_users SET user_is_agency = 0 WHERE id = '".$_POST['id']."'");
			$result["status"] = 200;
		}
		else
		{
			$result["status"] = 404;
			$result["message"] = "Không tìm thấy tài khoản!";
		}
		echo json_encode($result);
	}
	public function DepositeCustomer()
	{
		global $db;
		$result = array();
		$uid = $_POST['uid'];
		$hash = $_POST['hash'];
		$amount = $_POST['amount'];
		$note = $_POST['note'];
		$code = $_POST['code'];
		$staffid = $_SESSION['staff']['id'];
		$db->query("SELECT * FROM ow_transactions WHERE trans_hash = '".$hash."'");
		if($db->num_row())
		{
			$result["status"] = 500;
			$result["message"] = "Đã tồn tại giao dịch!";
		}
		else
		{
			$transcode = general::getInstance()->generateid("transaction");
			$sql = "INSERT INTO ow_transactions(uid,trans_code,trans_type,trans_bank,trans_method,trans_amount,trans_hash,trans_status,trans_note,trans_data,trans_approved_by,trans_approved_date) VALUES('".$uid."','".$transcode."','1','1','1','".$amount."','".$hash."','2','".$note."','".$code."','".$_SESSION['staff']['id']."','".date("Y-m-d H:i:s")."')";
			$db->query($sql);
			$sql = "UPDATE ow_users SET user_available_wallet = user_available_wallet + ".$amount." WHERE id = '".$uid."'";
			$db->query($sql);
			//$db->query("UPDATE ow_transactions SET trans_status = 2, trans_approved_by = '".$_SESSION['staff']['id']."', trans_approved_date = '".date("Y-m-d H:i:s")."' WHERE id = '".$tid."'");
			$result["status"] = 200;
		}
		echo json_encode($result);
	}
	//AGENCY API
	
}













