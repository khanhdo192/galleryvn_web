<?php
/**
 * @Author	HaiNM - VietTuongTac - BreadnTea
 * @Mail	nguyenminhhai@breadntea.vn
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

class VTT_FeFunctionContact {

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
	
	public function register()
	{
		check_ajax_referer('contact-register', 'security');

		$name = isset($_POST['name']) ? $_POST['name'] : '';
		$email = isset($_POST['email']) ? $_POST['email'] : '';
		$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
		$messenger = isset($_POST['messenger']) ? $_POST['messenger'] : '';

		if(empty($name) || empty($email) || empty($phone)){
			wp_send_json_error('Vui lòng nhập: Tên, Email, Số điện thoại!');
			wp_die();
		}

		$numlength = strlen($phone);
		if($numlength<10 || $numlength>12){
			wp_send_json_error('Số điện thoại định từ 10-12 ký tự!');
			wp_die();
		}

		$mContact = VTT_FeModelContact::instance();
		$checkContact = $mContact->hasContact('phone', $phone);
		if($checkContact!=0){
			wp_send_json_error('Đã đăng ký rồi!');
			die;
		}

		$data =	array( 
			'name' => $name, 
			'email' => $email,
			'phone' => $phone,
			'messenger' => $messenger,
		);
		
		$create = $mContact->create($data);
		if($create){
			wp_send_json_success('Đăng ký thành công!');
			wp_die();
		}else{
			wp_send_json_error('Lưu đăng ký gặp lỗi!');
			wp_die();
		}
	}
	
}