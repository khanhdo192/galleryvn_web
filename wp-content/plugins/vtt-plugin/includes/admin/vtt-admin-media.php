<?php
/**
 * @Author	HaiNM - VietTuongTac - BreadnTea
 * @Mail	nguyenminhhai@breadntea.vn
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

class VTT_AdminMedia
{	
	public static function init()
	{
		include_once VTT_PATH_ADMIN_MODEL . 'vtt-be-model-media.php';
		include_once VTT_PATH_ADMIN_FUNCTION . 'vtt-be-function-media.php';

		$function = VTT_BeFunctionMedia::instance();

		//action, filter WP
		add_action('admin_enqueue_scripts', array(__CLASS__, 'admin_scripts'));
		add_action('wp_ajax_admin-media-create', array($function, 'create'));
		add_action('wp_ajax_admin-media-edit', array($function, 'edit'));
	}
	
	/**
	 * Enqueue scripts.
	 */
	public static function admin_scripts()
	{
		$helper = VTT_Helper::instance();
		
		wp_register_script('vtt-admin-media', $helper->urlFileStatus('assets/scripts/vtt-admin-media.js'), array('jquery'), null, true);
		wp_localize_script(
			'vtt-admin-media',
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
		$model = VTT_BeModelMedia::instance();
		
		wp_localize_script('vtt-admin-media',
			'admin_media',
			array(
				'create' => array(
					'action' => 'admin-media-create',
					'nonce' => wp_create_nonce('admin-media-create')
				),
				'edit' => array(
					'action' => 'admin-media-edit',
					'nonce' => wp_create_nonce('admin-media-edit')
				),
				'param' => array(
					'defaultImage' => $helper->assetImage('placeholder.png'),
				),
			)
		);
		
		wp_enqueue_script('vtt-admin-media');

		$action = isset($_GET['action']) ? $_GET['action'] : '';
		switch (true) {
			case empty($action) || $action === 'list':
			
				$limit = 20;
				$pagin = isset($_GET['pagin']) ? $_GET['pagin'] : 1;
				$offset = ($limit * $pagin) - $limit;
				
				$total = $model->countAll();
				$media = $model->getAll($limit, $offset);
				$pagination = $helper->admin_pagination($limit, $pagin, $total);
				
				include_once VTT_PATH_ADMIN_VIEW . 'media/list.php';
				break;
				
			case $action === 'create' :
				wp_enqueue_media();
				include_once VTT_PATH_ADMIN_VIEW . 'media/create.php';
				break;
				
			case $action == 'edit' :

				$id = isset($_GET['id']) ? $_GET['id'] : 0;
				
				if(empty($id)){
					wp_die();
				}
				
				$detail =  $model->detail($id);
				if(empty($detail)){
					wp_die();
				}
				
				wp_enqueue_media();
				include_once VTT_PATH_ADMIN_VIEW . 'media/edit.php';
				break;
		}
	}
	

	private static function urlBack() {
		$makeUrl = admin_url('admin.php?page=vtt-media');
		return esc_url($makeUrl);
	}
	private static function urlEdit($_id=0) {
		$makeUrl = admin_url('admin.php?page=vtt-media&action=edit&id='.absint($_id));
		return esc_url($makeUrl);
	}
	private static function urlCreate() {
		$makeUrl = admin_url('admin.php?page=vtt-media&action=create');
		return esc_url($makeUrl);
	}
}
VTT_AdminMedia::init();