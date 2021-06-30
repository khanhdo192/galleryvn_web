<?php
/**
 * @Author	HaiNM - VietTuongTac - BreadnTea
 * @Mail	nguyenminhhai@breadntea.vn
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

class VTT_AdminProduct
{
	
	public static function init()
	{
		include_once VTT_PATH_ADMIN_MODEL . 'vtt-be-model-product.php';
		include_once VTT_PATH_ADMIN_MODEL . 'vtt-be-model-post.php';
		include_once VTT_PATH_ADMIN_MODEL . 'vtt-be-model-filter.php';
		include_once VTT_PATH_ADMIN_MODEL . 'vtt-be-model-product-image.php';
		include_once VTT_PATH_ADMIN_MODEL . 'vtt-be-model-product-filter.php';
		include_once VTT_PATH_ADMIN_FUNCTION . 'vtt-be-function-product.php';
		
		$function = VTT_BeFunctionProduct::instance();
		
		//action, filter WP
		add_action('admin_enqueue_scripts', array(__CLASS__, 'admin_scripts'));
		add_action('wp_ajax_admin-product-create', array($function, 'create'));
		add_action('wp_ajax_admin-product-edit', array($function, 'edit'));
	}
	
	/**
	 * Enqueue scripts.
	 */
	public static function admin_scripts()
	{
		$helper = VTT_Helper::instance();
		
		wp_register_script('vtt-admin-product', $helper->urlFileStatus('assets/scripts/vtt-admin-product.js'), array('jquery'), null, true);
		wp_localize_script(
			'vtt-admin-product',
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
		$mProduct = VTT_BeModelProduct::instance();
		$mPost = VTT_BeModelPost::instance();
		$mFilter = VTT_BeModelFilter::instance();
		
		wp_localize_script('vtt-admin-product',
			'admin_product',
			array(
				'create' => array(
					'action' => 'admin-product-create',
					'nonce' => wp_create_nonce('admin-product-create')
				),
				'edit' => array(
					'action' => 'admin-product-edit',
					'nonce' => wp_create_nonce('admin-product-edit')
				)
			)
		);
		wp_enqueue_script('vtt-admin-product');
		
		$action = isset($_GET['action']) ? $_GET['action'] : '';
		
		switch (true) {
			case empty($action) || $action === 'list':
			
				$limit = 20;
				$pagin = isset($_GET['pagin']) ? $_GET['pagin'] : 1;
				$offset = ($limit * $pagin) - $limit;
				
				$total = $mProduct->countProduct();
				$products = $mProduct->getProducts($limit, $offset);
				$pagination = $helper->admin_pagination($limit, $pagin, $total);
				
				include_once VTT_PATH_ADMIN_VIEW . 'product/list.php';
				break;

			case $action === 'create' :
				wp_enqueue_media();
				$postIds = array();
				$productIds = $mProduct->arrayProductIds();
				foreach ($productIds as $key => $value){
					$postIds[] = $value['post_id'];
				};
				
				$posts = $mPost->postNotProduct($postIds);
				$filters = $mFilter->getFilterProduct();
				
				include_once VTT_PATH_ADMIN_VIEW . 'product/create.php';
				break;
				
			case $action == 'edit' :				
				$id = isset($_GET['id']) ? $_GET['id'] : 0;
				
				if(empty($id)){
					wp_die();
				}
	
				$detail = $mProduct->detailProduct($id);
				if(empty($detail)){
					wp_die();
				}
				
				$mProductImage = VTT_BeModelProductImage::instance();
				$mProductFilter = VTT_BeModelProductFilter::instance();
				
				$filters = $mFilter->getFilterProduct();
				$myImages = $mProductImage->getAllByPostId($detail->post_id);
				$myFilters = $mProductFilter->getAllByPostId($detail->post_id);
				
				wp_enqueue_media();
				include_once VTT_PATH_ADMIN_VIEW . 'product/edit.php';
				break;
		}
	}

	private static function urlBack() {
		$makeUrl = admin_url('admin.php?page=vtt-product');
		return esc_url($makeUrl);
	}
	private static function urlEdit($_id=0) {
		$makeUrl = admin_url('admin.php?page=vtt-product&action=edit&id='.absint($_id));
		return esc_url($makeUrl);
	}
	private static function urlCreate($_id=0) {
		$makeUrl = admin_url('admin.php?page=vtt-product&action=create');
		return esc_url($makeUrl);
	}
}
VTT_AdminProduct::init();