<?php
/**
 * @Author	HaiNM - VietTuongTac - BreadnTea
 * @Mail	nguyenminhhai@breadntea.vn
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

class VTT_AdminProductPurchase
{
	
	public static function init()
	{
		include_once VTT_PATH_ADMIN_MODEL . 'vtt-be-model-product-purchase.php';

		//action, filter WP
		add_action('admin_enqueue_scripts', array(__CLASS__, 'admin_scripts'));
		
	}
	
	/**
	 * Enqueue scripts.
	 */
	public static function admin_scripts()
	{
		$helper = VTT_Helper::instance();
		
		wp_register_script('vtt-admin-contact', $helper->urlFileStatus('assets/scripts/vtt-admin-product-purchase.js'), array('jquery'), null, true);
		wp_localize_script(
			'vtt-admin-product-purchase',
			'vtt_admin_param',
			array(
				'url' => admin_url('admin-ajax.php')
			)
		);
	}
	
	/**
	 * View.
	 */
	public static function view()
	{
		$helper = VTT_Helper::instance();
		$mProductPurchase = VTT_BeModelProductPurchase::instance();
		$mPost = VTT_BeModelPost::instance();
		wp_enqueue_script('vtt-admin-product-purchase');

		$action = isset($_GET['action']) ? $_GET['action'] : '';
		switch (true) {
			case empty($action) || $action === 'list':
			
				$limit = 20;
				$pagin = isset($_GET['pagin']) ? $_GET['pagin'] : 1;
				$offset = ($limit * $pagin) - $limit;
				
				$total = $mProductPurchase->countPurchase();
				$purchases = $mProductPurchase->getPurchases($limit, $offset);
				$pagination = $helper->admin_pagination($limit, $pagin, $total);
				
				include_once VTT_PATH_ADMIN_VIEW . 'product-purchase/list.php';
				break;
				
			case $action == 'view' :

				$id = isset($_GET['id']) ? $_GET['id'] : 0;
				
				if(empty($id)){
					wp_die();
				}
				
				$detail = $mProductPurchase->detailPurchase($id);
				if(empty($detail)){
					wp_die();
				}
				
				include_once VTT_PATH_ADMIN_VIEW . 'product-purchase/view.php';
				break;
		}
	}
	
	private static function urlBack() {
		$makeUrl = admin_url('admin.php?page=vtt-product-purchase');
		return esc_url($makeUrl);
	}
	private static function urlView($_id=0) {
		$makeUrl = admin_url('admin.php?page=vtt-product-purchase&action=view&id='.absint($_id));
		return esc_url($makeUrl);
	}
}
VTT_AdminProductPurchase::init();