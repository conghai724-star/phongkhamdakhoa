<?php
Class pageController extends baseController
{
    public function customerprofile()
    {
        global $db;
        if (empty($_SESSION['customer']['id']) || empty($_SESSION['customer']['zalo'])) {
            header('Location: '.XC_URL.'/login'); exit;
        }
        $id = (int)$_SESSION['customer']['id'];
        $db->query("SELECT user_fullname, user_phone FROM hicrm_users WHERE id = ".$id." AND user_status = 1 LIMIT 1");
        $customer = $db->fetch_object(true);
        if (!$customer) {
            unset($_SESSION['customer']); header('Location: '.XC_URL.'/login'); exit;
        }
        if (empty($_SESSION['customer_csrf'])) $_SESSION['customer_csrf'] = bin2hex(random_bytes(32));
        $this->view->data['customerProfilePage'] = true;
        $this->view->data['customer'] = $customer;
        $this->view->show('customer-profile');
    }

    public function zalocallback()
    {
        header('Cache-Control: no-store');
        header('Referrer-Policy: no-referrer');
        $flow = isset($_SESSION['zalo_oauth']) ? $_SESSION['zalo_oauth'] : null;
        $state = isset($_GET['state']) ? $_GET['state'] : '';
        if ($flow && is_string($state) && hash_equals($flow['state'], $state) && time() - $flow['created'] <= 600) {
            $_SESSION['zalo_callback'] = array('state' => $state, 'code' => isset($_GET['code']) && is_string($_GET['code']) && strlen($_GET['code']) <= 4096 ? $_GET['code'] : '', 'error' => !empty($_GET['error']));
        } else {
            unset($_SESSION['zalo_callback']);
            $_SESSION['zalo_login_error'] = 'Phiên đăng nhập Zalo không hợp lệ hoặc đã hết hạn. Vui lòng thử lại.';
        }
        $page = '/login';
        header('Location: '.XC_URL.$page);
        exit;
    }

    public function privacypolicy()
    {
        $this->view->data['pagetitle'] = 'Chính sách quyền riêng tư & Bảo mật dữ liệu';
        $this->view->show('privacy-policy');
    }
	public function index()
	{
		 
	}
	public function data($para)
	{ 
		var_dump($para);
	}
	public function introduce($para){
		$id = $para[1];
	
		$id = explode("-",$id);
		$id = $id[0];
		global $db;
		$db->query("SELECT * FROM hicrm_categories WHERE category_parent = 1 AND category_status NOT IN(99) ORDER BY category_orderby ASC");
		$category = $db->fetch_object();
		$db->query("SELECT * FROM hicrm_introduce WHERE id= '".$id."'");
		$introduce = $db->fetch_object(true);	
		$db->query("SELECT * FROM hicrm_categories WHERE category_parent = 4 AND category_status NOT IN(99) ORDER BY category_orderby ASC");
		$pro = $db->fetch_object();
		$em = $this->helper->get_doctors();
		$this->view->data['introduce'] = $introduce;
		$this->view->data['employee'] = $em;
		$this->view->data['product'] = $pro;
		$events = $this->helper->get_events('4');
		$this->view->data['events'] = $events;

		// var_dump($introduce->category_name);

		$this->view->data['id'] = $id;
		$this->view->show("gioithieu");
	}
	public function demo()
	{
		$this->pdf->income(6);
	}
	public function booking()
	{
		global $db;
		$db->query("SELECT * FROM hicrm_employees WHERE employee_status NOT IN (99) AND employee_position = '1'");
		$doctors = $db->fetch_object();
		$this->view->data['doctors'] = $doctors;
		$this->view->show('booking');
	}
	public function booking_internal(){
	    global $db;
	    $db->query("SELECT product_name, product_spec FROM hicrm_products WHERE product_status NOT IN (99)");
	    $products = $db->fetch_object();
	    $this->view->data['products'] = $products;
	    $this->view->show('booking_internal');
	}
	public function cart(){
		if(!$this->helper->is_cart_enabled()){
			header("Location: ".XC_URL."/nha-thuoc.html");
			return;
		}
		global $db;
		$cart = $this->helper->get_cart_items();
		$cartItems = array();
		$cartSubtotal = 0;
		if(!empty($cart)){
			$productIds = array();
			foreach($cart as $productId => $quantity){
				$productId = (int)$productId;
				if($productId > 0 && (int)$quantity > 0){
					$productIds[] = $productId;
				}
			}
			if(!empty($productIds)){
				$db->query("SELECT *, p.id as pid FROM hicrm_products as p
					LEFT JOIN hicrm_product_categories pc ON p.product_category = pc.id
					LEFT JOIN hicrm_units u ON p.product_unit = u.id
					WHERE p.id IN(".implode(',', $productIds).") AND p.product_status NOT IN (99)");
				$products = $db->fetch_object();
				foreach($products as $product){
					$quantity = isset($cart[$product->pid]) ? max(1, (int)$cart[$product->pid]) : 1;
					$price = (float)$product->product_price;
					$discount = max(0, (int)$product->product_discount);
					$finalPrice = $discount > 0 ? ($price * (100 - $discount) / 100) : $price;
					$lineTotal = $finalPrice * $quantity;
					$cartSubtotal += $lineTotal;
					$cartItems[] = (object) array(
						'pid' => $product->pid,
						'product_name' => $product->product_name,
						'product_image' => $product->product_image,
						'category_name' => isset($product->category_name) ? $product->category_name : '',
						'product_unit_name' => isset($product->unit_name) ? $product->unit_name : '',
						'product_spec' => isset($product->product_spec) ? $product->product_spec : '',
						'product_price' => $price,
						'product_discount' => $discount,
						'final_price' => $finalPrice,
						'quantity' => $quantity,
						'line_total' => $lineTotal
					);
				}
			}
		}
		$this->view->data['cart_items'] = $cartItems;
		$this->view->data['cart_subtotal'] = $cartSubtotal;
		$this->view->data['cart_count'] = $this->helper->get_cart_count();
		$db->query("SELECT id, code, name, description, discount_type, discount_value, max_discount, min_order_value, per_user_limit
			FROM hicrm_vouchers
			WHERE is_active = 1
			AND (start_at IS NULL OR start_at <= NOW())
			AND (end_at IS NULL OR end_at >= NOW())
			AND (usage_limit IS NULL OR used_count < usage_limit)
			ORDER BY min_order_value ASC, id ASC");
		$this->view->data['cart_vouchers'] = $db->fetch_object();
		$this->view->data['cart_user'] = null;
		$this->view->data['cart_user_points'] = 0;
		if(!empty($_SESSION['customer']['id']) || !empty($_SESSION['user']['id'])){
			$userId = !empty($_SESSION['customer']['id']) ? (int)$_SESSION['customer']['id'] : (int)$_SESSION['user']['id'];
			$db->query("SELECT id, user_fullname, user_email, user_phone, user_address, loyalty_points
				FROM hicrm_users WHERE id = '".$userId."' AND user_status = 1 LIMIT 1");
			$cartUser = $db->fetch_object(true);
			if($cartUser){
				$this->view->data['cart_user'] = $cartUser;
				$this->view->data['cart_user_points'] = max(0, (int)$cartUser->loyalty_points);
			}
		}
		$this->view->show('cart');
	}
	public function bmi($para)
	{
		global $db;
		$id = $para[1];
		$id = explode("-",$id);
		$id = $id[0];
		$events = $this->helper->get_events('4');
		$db->query("SELECT * FROM hicrm_introduce WHERE id= '".$id."'");
		$introduce = $db->fetch_object(true);
		$this->view->data['events'] = $events;
		$this->view->data['introduce'] = $introduce;
		$this->view->show('bmi');
	}
	public function products($para){
		global $db;
		if(isset($para[1]) && $para[1] == 'thuoc' && isset($para[2])){
			$proid = explode("-", $para[2]);
			$productId = (int)$proid[0];
			$db->query("SELECT *, p.id as pid FROM hicrm_products as p
				LEFT JOIN hicrm_product_categories pc ON p.product_category = pc.id
				LEFT JOIN hicrm_units u ON p.product_unit = u.id
				WHERE p.id = '".$productId."' AND p.product_status NOT IN (99) LIMIT 1");
			$productDetail = $db->fetch_object(true);
			if(!$productDetail){
				header("Location: ".XC_URL."/nha-thuoc.html");
				return;
			}
			$db->query("SELECT *, p.id as pid FROM hicrm_products as p
				LEFT JOIN hicrm_product_categories pc ON p.product_category = pc.id
				LEFT JOIN hicrm_units u ON p.product_unit = u.id
				WHERE p.product_category = '".(int)$productDetail->product_category."' AND p.id != '".$productDetail->pid."'
				AND p.product_status NOT IN (99)
				ORDER BY p.product_created_time DESC LIMIT 6");
			$this->view->data['related_products'] = $db->fetch_object();
			$this->view->data['product_detail'] = $productDetail;
			$this->view->show('product_detail');
			return;
		}
		$limit = 20;
		$page = 1;
		$page_index = array_search('page', $para);
		if($page_index !== false && isset($para[$page_index + 1])
			&& preg_match('/^(\d+)(?:\.html)?$/', (string) $para[$page_index + 1], $page_match)){
			$page = (int) $page_match[1];
		}
		$page = max(1, $page);

		$db->query("SELECT * FROM hicrm_product_categories ORDER BY id ASC");
		$product_category = $db->fetch_object();
		$this->view->data['product_category'] = $product_category;

		if(isset($para[1]) && $para[1] == 'category' && isset($para[2])){
			$proid = explode("-", $para[2]);
			$id_cate = (int) $proid[0];

			$db->query("SELECT COUNT(id) as total FROM hicrm_products WHERE product_category = '".$id_cate."' AND product_status NOT IN (99)");
			$total_records = (int) $db->fetch_object(true)->total;
			$total_pages = max(1, ceil($total_records / $limit));
			$page = min($page, $total_pages);
			$start = ($page - 1) * $limit;

			$db->query("SELECT *, p.id as pid FROM hicrm_products as p 
					LEFT JOIN hicrm_product_categories pc ON p.product_category = pc.id WHERE p.product_category = '".$id_cate."' AND p.product_status NOT IN (99) ORDER BY p.product_created_time DESC LIMIT ".$start.", ".$limit." ");
			$this->view->data['products'] = $db->fetch_object();

			$db->query("SELECT * FROM hicrm_product_categories WHERE id = '".$id_cate."' LIMIT 1");
			$this->view->data['category_fil'] = $db->fetch_object(true);
			$this->view->data['id_category'] = $id_cate;
			$this->view->data['category'] = $para[1];
			$this->view->data['current_page'] = $page;
			$this->view->data['total_pages'] = $total_pages;
			$this->view->data['total_records'] = $total_records;
			$this->view->data['pagination_base'] = XC_URL."/nha-thuoc/category/".$id_cate."-%s/page/%d.html";
			$this->view->show("products");
		}else{
			$db->query("SELECT COUNT(id) as total FROM hicrm_products WHERE product_status NOT IN (99)");
			$total_records = (int) $db->fetch_object(true)->total;
			$total_pages = max(1, ceil($total_records / $limit));
			$page = min($page, $total_pages);
			$start = ($page - 1) * $limit;
			$db->query("SELECT *, p.id as pid FROM hicrm_products as p 
					LEFT JOIN hicrm_product_categories pc ON p.product_category = pc.id WHERE p.product_status NOT IN (99) ORDER BY p.product_created_time DESC LIMIT ".$start.", ".$limit."");
			$this->view->data['products'] = $db->fetch_object();
			$this->view->data['current_page'] = $page;
			$this->view->data['total_pages'] = $total_pages;
			$this->view->data['total_records'] = $total_records;
			$this->view->data['pagination_base'] = XC_URL."/nha-thuoc/page/%d.html";
			$this->view->show("products");
		}
	}
	public function upcode(){
		$this->view->show("upcode");
	}
	public function lienhe(){
		global $db;
		$this->view->show("lien-he");
	}
	public function events($para){
		$proid = $para[1]; 
		$proid = explode("-",$proid);
		$id = $proid[0];
		$limit = 15;
		$page = isset($para[2]) ? $para[2] : 1;
		$start = ($page - 1) * $limit;
		global $db;
		if (isset($id) && ctype_digit($id)) {
				$db->query("SELECT * FROM hicrm_events WHERE event_status NOT IN (99) AND id = '".$id."'");
				$this->view->data['events'] = $db->fetch_object(true);
				$db->query("SELECT * FROM hicrm_events WHERE event_status NOT IN (99) AND id != '".$id."' ORDER BY event_created_date DESC LIMIT 8");
			$this->view->data['event_new'] = $db->fetch_object();
			$db->query("SELECT * FROM hicrm_events WHERE event_status NOT IN (99) AND event_hot = '1' ORDER BY event_created_date DESC LIMIT 5");
			$this->view->data['event_hot'] = $db->fetch_object();
			
			$this->view->show("event_detail");

		}else{
		$db->query("SELECT COUNT(id) as total FROM hicrm_events WHERE event_status NOT IN (99)");
		$total_records = $db->fetch_object(true)->total;
		$total_pages = ceil($total_records / $limit);
		// echo $total_pages;
		$db->query("SELECT * FROM hicrm_events WHERE event_status NOT IN (99) ORDER BY event_created_date DESC LIMIT $start, $limit");
		$this->view->data['events'] = $db->fetch_object();
		$db->query("SELECT * FROM hicrm_events WHERE event_status NOT IN (99) AND event_hot = '1' ORDER BY event_created_date DESC LIMIT 5");
		$this->view->data['event_hot'] = $db->fetch_object();
		$this->view->data['id'] = $id;
		$this->view->data['total_pages'] = $total_pages;
		$this->view->show("events");
		}
	}
	public function services($para){
		global $db;
		$id = $para[1];
		$proid = explode("-",$id);
		$id = $proid[0];
		if(isset($para[2])){
			$id_detail = explode("-",$para[2]);
			$id_detail = $id_detail[0];
			$db->query("SELECT *,s.id as sid FROM hicrm_service as s 
			LEFT JOIN hicrm_categories as c ON s.service_category = c.id
			WHERE  s.service_status NOT IN (99) AND s.id = '".$id_detail."'");
			
			$service_detail = $db->fetch_object(true);
			$db->query("SELECT *,s.id as sid FROM hicrm_service as s 
				LEFT JOIN hicrm_categories as c ON s.service_category = c.id
				WHERE  s.service_status NOT IN (99) AND s.service_category = '".$id."' AND s.id != '".$id_detail."' ORDER BY s.id ASC");
				$service_other = $db->fetch_object();
			$this->view->data['service_detail'] = $service_detail;
			$this->view->data['service_other'] = $service_other;
			$this->view->data['id_category'] = $id;
			$this->view->show('service_detail');
		}else{
		$db->query("SELECT *,s.id as sid FROM hicrm_service as s 
		LEFT JOIN hicrm_categories as c ON s.service_category = c.id
		WHERE  s.service_status NOT IN (99) AND s.service_category = '".$id."' ORDER BY s.id ASC");
		$services = $db->fetch_object();
		$db->query("SELECT * FROM hicrm_categories WHERE id = '".$id."'");
		$category_name = $db->fetch_object(true)->category_name;
		$this->view->data['category_name'] = $category_name;
		$this->view->data['services'] = $services;
		$this->view->show('service');
		}
	}
	
	public function lichcongtac($para){
		$id = $para[1];
		// $proid = explode("-",$proid);
		// $id = $proid[0];
		global $db;
		
		
		$db->query("SELECT *,w.id as wid FROM hicrm_calendar_works as w 
		LEFT JOIN hicrm_users as u ON w.calendar_work_user_created = u.id
		WHERE w.calendar_status NOT IN (99) ORDER BY w.calendar_work_created_date DESC LIMIT 1");
		$this->view->data['calendar_word_detail'] = $db->fetch_object(true);
		$db->query("SELECT * FROM hicrm_calendar_works WHERE calendar_status NOT IN (99) ORDER BY calendar_work_created_date DESC");
		$this->view->data['calendar_word'] = $db->fetch_object();
		$db->query("SELECT * FROM hicrm_calendar_works WHERE calendar_status NOT IN (99) ORDER BY calendar_work_created_date DESC LIMIT 1");
		$calendar_now = $db->fetch_object(true)->calendar_work_file;
	
		$this->view->data['calendar_now'] = $calendar_now;
		
		
		$this->view->data['id'] = $id;
		
		$this->view->show("lichcongtac");
	}
	public function lichcongtac_filter($para){
		$id = $para[1];
		// $proid = explode("-",$proid);
		// $id = $proid[0];
		global $db;
		
		if(isset($id) && $id != ''){
		$db->query("SELECT *,w.id as wid FROM hicrm_calendar_works as w 
		LEFT JOIN hicrm_users as u ON w.calendar_work_user_created = u.id
		WHERE w.calendar_status NOT IN (99) ORDER BY w.id = '".$id."'");
		$this->view->data['calendar_word_detail'] = $db->fetch_object(true);
		}
		$db->query("SELECT * FROM hicrm_calendar_works WHERE calendar_work_created_date >= DATE_FORMAT(CURDATE(), '%Y-%m-01')
  		AND calendar_work_created_date <  DATE_ADD(DATE_FORMAT(CURDATE(), '%Y-%m-01'), INTERVAL 1 MONTH) AND calendar_status NOT IN (99) ORDER BY calendar_work_created_date DESC");
		$this->view->data['calendar_word'] = $db->fetch_object();
		
		
		$this->view->data['id'] = $id;
		
		$this->view->show("lichcongtac");
	}
	public function doctors($para){
		$proid = $para[1];
		$proid = explode("-",$proid);
		$id = $proid[0];
		global $db;
		if (isset($id) && ctype_digit($id)) {
			
			$db->query("SELECT *, e.id as eid FROM hicrm_employees as e 
					LEFT JOIN hicrm_departments as d ON e.employee_department = d.id
		 WHERE e.employee_status NOT IN (99) AND e.id = '".$id."'");
		 	$this->view->data['doctor_detail'] = $db->fetch_object(true);
			$db->query("SELECT *, e.id as eid FROM hicrm_employees as e 
					LEFT JOIN hicrm_departments as d ON e.employee_department = d.id
		 WHERE e.employee_status NOT IN (99) AND e.id != '".$id."'");
		 	$this->view->data['doctor_other'] = $db->fetch_object();
			// $this->view->data['id'] = $id;
			$this->view->show("doctor_detail");
		}else{
		$db->query("SELECT * FROM hicrm_departments WHERE depart_status NOT IN (99)");
		$this->view->data['depart'] = $db->fetch_object();
		$db->query("SELECT *, e.id as eid FROM hicrm_employees as e 
					LEFT JOIN hicrm_departments as d ON e.employee_department = d.id
		 WHERE e.employee_status NOT IN (99)");
		$this->view->data['employess'] = $db->fetch_object();
		$this->view->data['id'] = $id;
		$this->view->show("doctors");
		}
	}
	public function chuyenkhoa($para){
		$proid = $para[1];
		$proid = explode("-",$proid);
		$id = $proid[0];
		global $db;
		// $db->query("SELECT * FROM hicrm_events WHERE event_status NOT IN (99) ORDER BY event_created_date DESC LIMIT 15");
		// $this->view->data['events'] = $db->fetch_object();
		$this->view->data['id'] = $id;
		$this->view->show("chuyenkhoa");
	}
	public function profile($para){
		$id = $para[1];
		global $db;
		$db->query("SELECT * FROM hicrm_customers WHERE id = '".$id."'");
		$user = $db->fetch_object(true);
		$this->view->data['user'] = $user;
		$this->view->show('profile');
	}
	public function editpost()
	{
		global $db;
		$pid = $_GET['id'];
		
		if(isset($_SESSION['staff']['id']) && $_SESSION['staff']['id'] != "")
		{
			$db->query("SELECT * FROM bds_posts WHERE id = '".$pid."' LIMIT 1");
			if($db->num_row())
			{
				$this->view->data["post"] = $db->fetch_object(true);
			}
			else
			{
				header("Location: ".XC_URL);
			}
		}
		elseif(isset($_SESSION['user']['id']) && $_SESSION['user']['id'] != "")
		{
			$db->query("SELECT * FROM bds_posts WHERE id = '".$pid."' AND post_author = '".$_SESSION['user']['id']."' LIMIT 1");
			if($db->num_row())
			{
				$this->view->data["post"] = $db->fetch_object(true);
			}
			else
			{
				header("Location: ".XC_URL);
			}
		}
		else
		{
			header("Location: ".XC_URL);
		}
		
		$this->view->show("edit-post");
	}
	public function test()
	{
		
	}
	public function categoryrent()
	{
		global $db;
		$catid = 2;
		$spp = 18;
		$page = 1;
		if(isset($_GET['page']) && $_GET['page'] != "")
		{
			$page = $_GET['page'];
		}
		$cp = $page - 1;
		$totalpost = general::getInstance()->count_post_by_category(2);
		$totalpage = $totalpost/$spp;
		$db->query("SELECT *, s.id as pid FROM bds_posts as s 
		LEFT JOIN hicrm_provinces as p ON s.post_province = p.id
		LEFT JOIN hicrm_districts as d ON s.post_district = d.id
		LEFT JOIN hicrm_wards as w ON s.post_ward = w.id
		WHERE s.post_type = '".$catid."'
		ORDER BY s.post_create_time DESC LIMIT ".$cp*$spp.",".$spp);
		$this->view->data["posts"] = $db->fetch_object();
		$this->view->data['totalpost'] = $totalpost;
		$this->view->data["page"] = $page;
		$this->view->data["spp"] = $spp;
		$this->view->data['totalpage'] = $totalpage;
		$this->view->data["page_name"] = "category";
		$this->view->data["page_title"] = "Danh sách tin đăng";
		$this->view->show("category");
	}
	public function categorysale()
	{
		global $db;
		$catid = 1;
		$spp = 18;
		$page = 1;
		if(isset($_GET['page']) && $_GET['page'] != "")
		{
			$page = $_GET['page'];
		}
		$cp = $page - 1;
		$totalpost = general::getInstance()->count_post_by_category(1);
		$totalpage = $totalpost/$spp;
		$db->query("SELECT *, s.id as pid FROM bds_posts as s 
		LEFT JOIN hicrm_provinces as p ON s.post_province = p.id
		LEFT JOIN hicrm_districts as d ON s.post_district = d.id
		LEFT JOIN hicrm_wards as w ON s.post_ward = w.id
		WHERE s.post_type = '".$catid."'
		ORDER BY s.post_create_time DESC LIMIT ".$cp*$spp.",".$spp);
		$this->view->data["posts"] = $db->fetch_object();
		$this->view->data['totalpost'] = $totalpost;
		$this->view->data["page"] = $page;
		$this->view->data["spp"] = $spp;
		$this->view->data['totalpage'] = $totalpage;
		$this->view->data["page_name"] = "category";
		$this->view->data["page_title"] = "Danh sách tin đăng";
		$this->view->show("category");
	}
	public function post($para)
	{
		$postid = $para[1];
		$postid = explode("-",$postid);
		$id = $postid[0];
		global $db;
		$db->query("SELECT *, s.id as pid FROM bds_posts as s 
		LEFT JOIN hicrm_provinces as p ON s.post_province = p.id
		LEFT JOIN hicrm_districts as d ON s.post_district = d.id
		LEFT JOIN hicrm_wards as w ON s.post_ward = w.id
		LEFT JOIN hicrm_users as u ON s.post_author = u.id
		WHERE s.id = '".$id."'");
		$this->view->data["post"] = $db->fetch_object(true);
		$this->view->show("post");
	}
	public function projects($para)
	{
		global $db;
		$catid = 1;
		$spp = 18;
		$page = 1;
		if(isset($_GET['page']) && $_GET['page'] != "")
		{
			$page = $_GET['page'];
		}
		$cp = $page - 1;
		$totalpost = $this->home->count_project();
		$totalpage = $totalpost/$spp;
		$db->query("SELECT *, s.id as pid FROM bds_projects as s 
		ORDER BY s.project_create_time DESC LIMIT ".$cp*$spp.",".$spp);
		$this->view->data["projects"] = $db->fetch_object();
		$this->view->data['totalpost'] = $totalpost;
		$this->view->data["page"] = $page;
		$this->view->data["spp"] = $spp;
		$this->view->data['totalpage'] = $totalpage;
		$this->view->data["page_name"] = "category";
		$this->view->data["page_title"] = "Danh sách tin đăng";
		$this->view->show("projects");
	}
	public function project($para)
	{
		$postid = $para[1];
		$postid = explode("-",$postid);
		$id = $postid[0];
		global $db;
		$db->query("SELECT *, s.id as pid FROM bds_projects as s 
		WHERE s.id = '".$id."'");
		$this->view->data["project"] = $db->fetch_object(true);
		$this->view->show("project");
	}
	public function pageview($para)
	{
		echo $postid = $para[1];
		$postid = explode("-",$postid);
		$id = $postid[0];
		global $db;
		$db->query("SELECT *, s.id as pid FROM bds_pages as s 
		WHERE s.id = '".$id."'");
		$this->view->data["id"] = $id;
		$this->view->data["page"] = $db->fetch_object(true);
		$this->view->show("page");
	}
	public function sms()
	{
		global $db;
		
		$spp = 40;
		$page = 1;
		if(isset($_GET['page']) && $_GET['page'] != "")
		{
			$page = $_GET['page'];
		}
		$cp = $page - 1;
		$totalsms = sms::getInstance()->countallsms($_SESSION['user']['id']);
		$totalpage = $totalsms/$spp;
		$db->query("SELECT * FROM sms_sents as s 
		LEFT JOIN sms_sent_status as st ON s.sent_status = st.status_id
		WHERE sent_uid = '".$_SESSION['user']['id']."' ORDER BY s.sent_at DESC LIMIT ".$cp*$spp.",".$spp);
		$this->view->data["sents"] = $db->fetch_object();
		$this->view->data['totalsms'] = $totalsms;
		$this->view->data["page"] = $page;
		$this->view->data["spp"] = $spp;
		$this->view->data['totalpage'] = $totalpage;
		$this->view->data["page_name"] = "sms_list";
		$this->view->data["page_title"] = "Danh sách SMS";
		$this->view->show("sms_list");
	}
	public function deposit()
	{
		$this->view->data["page_name"] = "deposit";
		$this->view->data["page_title"] = "Nạp tiền";
		$this->view->show("deposit");
	}
	public function user()
	{
		global $db;
		$db->query("SELECT * FROM sms_users WHERE id = '".$_SESSION['user']['id']."' LIMIT 1");
		$this->view->data["user"] = $db->fetch_object(true);
		$db->query("SELECT * FROM sms_transactions WHERE trans_uid = '".$_SESSION['user']['id']."' ORDER BY trans_date DESC");
		$this->view->data["transactions"] = $db->fetch_object();
		$this->view->data["page_name"] = "user";
		$this->view->data["page_title"] = "Tài khoản";
		$this->view->show("user");
	}
	public function testsms()
	{
		$Content = "Ma OTP cua ban la: 22222, thoi han su dung 5 phut";
		$params = array(
			'api_key' => 'key-c4a8d21f56a2827fa24a41b3a63dcbb7',
			'phone' => '0917281333',
			'message' => $Content
		);
		// $url = 'https://api.gialai.biz/service/send';
		// Khởi tạo CURL
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, count($params));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params); 
		//$result = curl_exec($ch);
		//curl_close($ch);
		//$result = json_decode($result,true);
		//var_dump($result);
	}
}
