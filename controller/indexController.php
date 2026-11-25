<?php

Class indexController Extends baseController
{
	public function index()
    {
		// if(!(isset($_SESSION['user']['id']) && $_SESSION['user']['id'] != "")){ header("Location: ".XC_URL."/admin/login"); }
		
		global $db;
		 $db->query("SELECT * FROM hicrm_departments WHERE depart_status NOT IN (99)");
		 $this->view->data['chuyenkhoa'] = $db->fetch_object();
		 $db->query("SELECT *, e.id as employeeid FROM hicrm_employees as e 
		LEFT JOIN hicrm_branchs as b ON e.employee_branch = b.id 
		LEFT JOIN hicrm_departments as d ON e.employee_department = d.id
		LEFT JOIN hicrm_positions as p ON e.employee_position = p.id
		WHERE e.employee_status NOT IN (99)");
		$this->view->data['employee'] = $db->fetch_object();
		$db->query("SELECT * FROM hicrm_events WHERE event_status NOT IN (99) ORDER BY event_created_date DESC LIMIT 12");
		$this->view->data['events'] = $db->fetch_object();
		$db->query("SELECT * FROM hicrm_images WHERE image_status NOT IN (99) AND image_category = '3' ");
		$this->view->data['slider'] = $db->fetch_object();
		//không gian phòng khám
		$db->query("SELECT * FROM hicrm_images WHERE image_status NOT IN (99) AND image_category = '2' ");
		$this->view->data['pic'] = $db->fetch_object();
		
		// Sản phẩm mới nhất hiển thị slider trang chủ
		$db->query("SELECT *, p.id as pid FROM hicrm_products as p 
			LEFT JOIN hicrm_product_categories pc ON p.product_category = pc.id 
			LEFT JOIN hicrm_units u ON p.product_unit = u.id 
			WHERE p.product_status NOT IN (99) 
			ORDER BY p.product_created_time DESC, p.id DESC LIMIT 15");
		$this->view->data['new_products'] = $db->fetch_object();

		$this->view->show("index");
		
	}
	private function countorderbydate($date)
	{
		global $db;
		$db->query("SELECT count(*) as countorder FROM ow_orders WHERE date(order_time) = '".date("Y-m-d",strtotime($date))."'");
		return $db->fetch_object(true)->countorder;
	}
	private function countorderbydatedeposited($date)
	{
		global $db;
		$db->query("SELECT count(*) as countorder FROM ow_orders WHERE order_status > 1 AND date(order_time) = '".date("Y-m-d",strtotime($date))."'");
		return $db->fetch_object(true)->countorder;
	}
	
}

?>
