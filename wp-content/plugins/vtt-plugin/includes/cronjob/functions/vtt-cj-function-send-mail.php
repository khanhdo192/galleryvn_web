<?php
/**
 * @Author	HaiNM - VietTuongTac - BreadnTea
 * @Mail	nguyenminhhai@breadntea.vn
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

class VTT_CjFunctionSendMail {

	public static $_instance = null;

	//public $toPrimary = 'nguyenminhhai@breadntea.vn';
	public $toPrimary = 'hainm0912@gmail.com';
	
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
	
	public function sendEmail()
	{
		$cj = isset($_GET['cj']) ? $_GET['cj'] : '';
		if(empty($cj) || $cj != 'run'){
			wp_send_json_error('command error.');
			wp_die;
		}
		
		add_filter('wp_mail_content_type', array($this, 'mailContentType'));
		add_action('phpmailer_init', array($this, 'mailInitSMTP'));
		
		$tempEmail = VTT_TemplateEmail::instance();
		$mContact = VTT_CjModelContact::instance();
		$mProductPurchase = VTT_CjModelProductPurchase::instance();
		
		$subject = '['. date('d.m.Y') .'] GalleryVN Admin';
		$header = array('Content-Type: text/html; charset=UTF-8');
		
		$titleBuy = 'Khách hàng mua tác phẩm:';
		$dataBuy = $mProductPurchase->getAllBuy(3);
		
		$titleOrder = 'Khách hàng đặt vẽ tranh:';
		$dataOrder = $mProductPurchase->getAllOrder(3);
		
		$titleContact = 'Khách hàng để lại thông tin:';
		$dataContact = $mContact->getAll(3);
		
		if((empty($dataBuy) || count($dataBuy) < 1) && (empty($dataOrder) || count($dataOrder) < 1) && (empty($dataContact) || count($dataContact) < 1)){
			wp_send_json_error('No data');
			wp_die();
		};
		
		$contentBuy = $tempEmail->handleTemp($titleBuy, $dataBuy);
		$contentOrder = $tempEmail->handleTemp($titleOrder, $dataOrder);
		$contentContact = $tempEmail->handleTemp($titleContact, $dataContact);

		$message = $tempEmail->buildHTML($contentBuy, $contentOrder, $contentContact);
		//echo $message;
		//die;
		/** Send **/
		$result = wp_mail( $this->toPrimary, $subject, $message, $header );

		if(!$result) {
			wp_send_json_error('Email send error');
			wp_die();
		}
		/** Update **/
		$data =	array( 
			'send_at' => current_time('mysql'),
		);
		
		if(!empty($dataBuy) || count($dataBuy) > 0){
			foreach($dataBuy as $value){
				$mProductPurchase->update($value['id'], $data);
			}
		};
		if(!empty($dataOrder) || count($dataOrder) > 0){
			foreach($dataOrder as $value){
				$mProductPurchase->update($value['id'], $data);
			}
		};
		if(!empty($dataContact) || count($dataContact) > 0){
			foreach($dataContact as $value){
				$mContact->update($value['id'], $data);
			}
		};
		
		/** Notify **/
		wp_send_json_success('Send mail success.');
		wp_die();
	}
	
	public function mailInitSMTP($phpmailer)
	{
		$phpmailer->isSMTP();
		$phpmailer->Host       = 'smtp.mailgun.org';
		$phpmailer->Port       = 587;
		$phpmailer->SMTPSecure = 'tls';
		$phpmailer->SMTPAuth   = true;
		$phpmailer->Username   = 'postmaster@galleryvn.vn';
		$phpmailer->Password   = 'dbedce966ef2e7863e8de33ab5850fa9-1f1bd6a9-a1428b6a';
		$phpmailer->From       = 'noreply@galleryvn.vn';
		$phpmailer->FromName   = 'GalleryVN Admin';
	}
	
	public function mailContentType()
	{
		return 'text/html';
	}
	
}