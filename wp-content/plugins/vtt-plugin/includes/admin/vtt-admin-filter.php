<?php
/**
 * @Author	HaiNM - VietTuongTac - BreadnTea
 * @Mail	nguyenminhhai@breadntea.vn
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

class VTT_AdminFilter
{
	
	public static function init()
	{
		include_once VTT_PATH_ADMIN_MODEL . 'vtt-be-model-filter.php';
		include_once VTT_PATH_ADMIN_FUNCTION . 'vtt-be-function-filter.php';
		
		$function = VTT_BeFunctionFilter::instance();
		
		//action, filter WP
		add_action('admin_enqueue_scripts', array(__CLASS__, 'admin_scripts'));
		add_action('wp_ajax_admin-filter-create', array($function, 'create'));
		add_action('wp_ajax_admin-filter-edit', array($function, 'edit'));
	}
	
	/**
	 * Enqueue scripts.
	 */
	public static function admin_scripts()
	{
		$helper = VTT_Helper::instance();
		
		wp_register_script('vtt-admin-filter', $helper->urlFileStatus('assets/scripts/vtt-admin-filter.js'), array('jquery'), null, true);
		wp_localize_script(
			'vtt-admin-filter',
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
		$mFilter = VTT_BeModelFilter::instance();
		
		wp_localize_script('vtt-admin-filter',
			'admin_filter',
			array(
				'create' => array(
					'action' => 'admin-filter-create',
					'nonce' => wp_create_nonce('admin-filter-create')
				),
				'edit' => array(
					'action' => 'admin-filter-edit',
					'nonce' => wp_create_nonce('admin-filter-edit')
				)
			)
		);
		wp_enqueue_script('vtt-admin-filter');
		
		$action = isset($_GET['action']) ? $_GET['action'] : '';
		switch (true) {
			case empty($action) || $action === 'list':
			
				$limit = 20;
				$pagin = isset($_GET['pagin']) ? $_GET['pagin'] : 1;
				$offset = ($limit * $pagin) - $limit;
				
				$total = $mFilter->countFilter();
				$filters = $mFilter->getFilters($limit, $offset);
				$pagination = $helper->admin_pagination($limit, $pagin, $total);
				
				include_once VTT_PATH_ADMIN_VIEW . 'filter/list.php';
				break;
				
			case $action === 'create' :
				
				include_once VTT_PATH_ADMIN_VIEW . 'filter/create.php';
				break;
				
			case $action == 'edit' :

				$id = isset($_GET['id']) ? $_GET['id'] : 0;
				
				if(empty($id)){
					wp_die();
				}
				
				$detail = $mFilter->detailFilter($id);
				if(empty($detail)){
					wp_die();
				}
				
				include_once VTT_PATH_ADMIN_VIEW . 'filter/edit.php';
				break;
		}
	}
	
	private static function urlBack() {
		$makeUrl = admin_url('admin.php?page=vtt-filter');
		return esc_url($makeUrl);
	}
	private static function urlEdit($_id=0) {
		$makeUrl = admin_url('admin.php?page=vtt-filter&action=edit&id='.absint($_id));
		return esc_url($makeUrl);
	}
	private static function urlCreate($_id=0) {
		$makeUrl = admin_url('admin.php?page=vtt-filter&action=create');
		return esc_url($makeUrl);
	}
}
VTT_AdminFilter::init();