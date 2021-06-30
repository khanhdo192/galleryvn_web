<?php
/**
 * @Author	HaiNM - VietTuongTac - BreadnTea
 * @Mail	nguyenminhhai@breadntea.vn
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

class VTT_FeFunctionProduct {

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
	
	public function purchase()
	{
		check_ajax_referer('product-purchase', 'security');

		$type = isset($_POST['type']) ? $_POST['type'] : '';
		$postId = isset($_POST['postId']) ? $_POST['postId'] : 0;
		$name = isset($_POST['name']) ? $_POST['name'] : '';
		$email = isset($_POST['email']) ? $_POST['email'] : '';
		$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
		$messenger = isset($_POST['messenger']) ? $_POST['messenger'] : '';

		if(empty($type)){
			wp_send_json_error('Dữ liệu truyền lên chưa đúng!');
			wp_die();
		}
		
		if(empty($name) || empty($email) || empty($phone)){
			wp_send_json_error('Vui lòng nhập: Tên, Email, Số điện thoại!');
			wp_die();
		}
		
		if($type !== 'buy' && $type !== 'order'){
			wp_send_json_error('Dữ liệu sai xót!');
			wp_die();
		};
		
		if( $type === 'buy' && empty($postId)){
			wp_send_json_error('Không rõ sản phẩm!');
			wp_die();
		}
		
		$numlength = strlen($phone);
		if($numlength<10 || $numlength>12){
			wp_send_json_error('Số điện thoại định từ 10-12 ký tự!');
			wp_die();
		}

		$mPurchase = VTT_FeModelProductPurchase::instance();
		$have = $mPurchase->hasPurchase('phone', $phone);
		if($have > 5){
			wp_send_json_error('Đã đăng ký rồi!');
			die;
		}
		
		$data =	array( 
			'type' => $type, 
			'post_id' => $postId, 
			'name' => $name, 
			'email' => $email,
			'phone' => $phone,
			'messenger' => $messenger,
		);
		
		$create = $mPurchase->create($data);
		if($create){
			if($type === 'buy'){
				wp_send_json_success('Mua sản phẩm thành công, chúng tôi sẽ sớm liên lạc!');
			}elseif($type === 'order'){
				wp_send_json_success('Đặt họa sĩ vẽ riêng thành công, chúng tôi sẽ sớm liên lạc!');
			}
			wp_die();
		}else{
			wp_send_json_error('Lưu đăng ký gặp lỗi!');
			wp_die();
		}
	}
	
}