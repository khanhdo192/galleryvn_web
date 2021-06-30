<?php
/**
 * @Author	HaiNM - VietTuongTac - BreadnTea
 * @Mail	nguyenminhhai@breadntea.vn
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

class VTT_BeFunctionMedia {

	public static $_instance = null;
	
	private $urlUpload = '';

	// Private methods cannot be called
	private function __construct() {
		$this->urlUpload = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}/wp-content/uploads/";
	}
	
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
		check_ajax_referer('admin-media-create', 'security');
		$this->auth();
		
		$name = isset($_POST['name']) ? $_POST['name'] : '';
		$type = isset($_POST['type']) ? $_POST['type'] : '';
		$link = isset($_POST['link']) ? $_POST['link'] : '';
		$image = isset($_POST['image']) ? $_POST['image'] : '';

		if (empty($name) || empty($type) || empty($image)){
			wp_send_json_error('Vui lòng nhập: tên ảnh, vị trí, hình ảnh!');
			wp_die();
		}

		$data = array(
			'name' => $name,
			'type' => $type,
			'link' => $link,
		);
		
		$checkImage = strpos($image, $this->urlUpload);
		if ($checkImage !== false) {
			$data['url'] = str_replace($this->urlUpload,'',$image);
		}else {
			wp_send_json_error('Truyền hình ảnh / video gặp lỗi!');
			wp_die();
		}

		$mMedia = VTT_BeModelMedia::instance();
		$create = $mMedia->create($data);
		if($create){
			wp_send_json_success('Thêm hình ảnh / video thành công!');
			wp_die();
		}else{
			wp_send_json_error('Quá trình tạo gặp lỗi!');
			wp_die();
		}
	}

	public function edit()
	{
		check_ajax_referer('admin-media-edit', 'security');
		$this->auth();
		
		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		$name = isset($_POST['name']) ? $_POST['name'] : '';
		$type = isset($_POST['type']) ? $_POST['type'] : '';
		$link = isset($_POST['link']) ? $_POST['link'] : '';
		$image = isset($_POST['image']) ? $_POST['image'] : '';

		if (empty($id)){
			wp_send_json_error('Truyền dữ liệu gặp lỗi Id!');
			wp_die();
		}

		if (empty($name) || empty($type) || empty($image)){
			wp_send_json_error('Vui lòng nhập: tên ảnh, vị trí, hình ảnh!');
			wp_die();
		}
		
		$data = array(
			'name' => $name,
			'type' => $type,
			'link' => $link,
		);
		
		$checkImage = strpos($image, $this->urlUpload);
		if ($checkImage !== false) {
			$data['url'] = str_replace($this->urlUpload,'',$image);
		}else {
			wp_send_json_error('Truyền hình ảnh / video gặp lỗi!');
			wp_die();
		}

		$mMedia = VTT_BeModelMedia::instance();
		$update = $mMedia->update($id, $data);
		if($update){
			wp_send_json_success('Sửa hình ảnh / video thành công!');
			wp_die();
		}else{
			wp_send_json_error('Quá trình cập nhật gặp lỗi!');
			wp_die();
		}
	}
	
	private function auth(){
		if(!is_user_logged_in()) {
			wp_send_json_error('Error!');
			wp_die();
		}
	}
}