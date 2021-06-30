<?php
/**
 * @Author	HaiNM - VietTuongTac - BreadnTea
 * @Mail	nguyenminhhai@breadntea.vn
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

class VTT_BeFunctionFilter {

	public static $_instance = null;
	
	// Private methods cannot be called
	private function __construct() {}
	
	// Private methods cannot be called
	private function __clone() {}

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	public function create()
	{
		check_ajax_referer('admin-filter-create', 'security');
		$this->auth();
		
		$parentName = isset($_POST['parent_name']) ? $_POST['parent_name'] : '';
		$childName = isset($_POST['child_name']) ? $_POST['child_name'] : [];

		if (empty($parentName)){
			wp_send_json_error('Nhập tên danh mục lọc!');
			wp_die();
		}
		
		foreach($childName as $value){
			if (empty($value)){
				wp_send_json_error('Nhập tên thông tin lọc!');
				wp_die();
			}		
		}

		$mFilter = VTT_BeModelFilter::instance();
	
		/** Data Parent */
		$dataParent = array(
			'name' => $parentName,
			'type' => 'product',
			'count' => count($childName), 
		);
		
		$parentId = $mFilter->create($dataParent);
		if(empty($parentId)){
			wp_send_json_error('Tạo thông tin gặp lỗi 1!');
			wp_die();
		}

		/** Data Child */
		$dataChild = array();
		foreach ($childName as $key => $value) {
			$dataChild[] = [
				'name' => $value,
				'type' => 'product',
				'parent_id' => $parentId,
			];
		}

		$multi = $mFilter->creates($dataChild);
		if($multi){
			wp_send_json_success('Tạo thông tin lọc thành công!');
			wp_die();
		}else{
			wp_send_json_error('Quá trình tạo gặp lỗi!');
			wp_die();
		}
	}

	public function edit()
	{
		check_ajax_referer('admin-filter-edit', 'security');
		$this->auth();
		
		$parentId = isset($_POST['parent_id']) ? $_POST['parent_id'] : 0;
		$parentName = isset($_POST['parent_name']) ? $_POST['parent_name'] : '';
		$childId = isset($_POST['child_id']) ? $_POST['child_id'] : [];
		$childName = isset($_POST['child_name']) ? $_POST['child_name'] : [];

		if (empty($parentId)){
			wp_send_json_error('Truyền dữ liệu gặp lỗi Id!');
			wp_die();
		}
		
		if (empty($parentName)){
			wp_send_json_error('Nhập tên danh mục lọc!');
			wp_die();
		}
		
		foreach($childName as $value){
			if (empty($value)){
				wp_send_json_error('Nhập tên thông tin lọc!');
				wp_die();
			}		
		}
		
		$mFilter = VTT_BeModelFilter::instance();
	
		/** Data Parent */
		$dataParent = array(
			'name' => $parentName,
			'type' => 'product',
			'count' => count($childName), 
		);
		
		$update = $mFilter->update($parentId, $dataParent);
		if(empty($update)){
			wp_send_json_error('Cập nhật thông tin gặp lỗi 1!');
			wp_die();
		}
		
		wp_send_json_success('Cập nhật thông tin lọc thành công!');
		wp_die();
	}
	
	private function auth(){
		if(!is_user_logged_in()) {
			wp_send_json_error('Error!');
			wp_die();
		}
	}
}