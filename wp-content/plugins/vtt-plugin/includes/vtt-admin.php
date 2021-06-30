<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

if ( class_exists( 'VTT_Admin', false ) ) {
	return new VTT_Admin();
}

class VTT_Admin
{
	/**
	 * Constructor.
	 */
	public function __construct()
	{
		if (!defined('VTT_PATH_ADMIN')) define('VTT_PATH_ADMIN', VTT_PLUGIN_PATH . 'includes/admin/');
		if (!defined('VTT_PATH_ADMIN_MODEL')) define('VTT_PATH_ADMIN_MODEL', VTT_PLUGIN_PATH . 'includes/admin/models/');
		if (!defined('VTT_PATH_ADMIN_VIEW')) define('VTT_PATH_ADMIN_VIEW', VTT_PLUGIN_PATH . 'includes/admin/views/');
		if (!defined('VTT_PATH_ADMIN_FUNCTION')) define('VTT_PATH_ADMIN_FUNCTION', VTT_PLUGIN_PATH . 'includes/admin/functions/');
		
		add_action('init', array( $this, 'includes'));
		add_action('current_screen', array( $this, 'conditional_includes' ) );
		add_action('admin_menu', array($this, 'admin_menu'), 9);
		add_action('admin_enqueue_scripts', array($this, 'admin_scripts'));
	}
	
	/**
	 * Include any classes we need within admin.
	 */
	public function includes()
	{
		include_once VTT_PATH_ADMIN . 'vtt-admin-home.php';
		include_once VTT_PATH_ADMIN . 'vtt-admin-contact.php';
		include_once VTT_PATH_ADMIN . 'vtt-admin-media.php';
		include_once VTT_PATH_ADMIN . 'vtt-admin-filter.php';
		include_once VTT_PATH_ADMIN . 'vtt-admin-product.php';
		include_once VTT_PATH_ADMIN . 'vtt-admin-product-purchase.php';
	}
	/**
	 * Include admin files conditionally.
	 */
	public function conditional_includes()
	{
		$screen = get_current_screen();
		if ( ! $screen ) {
			return;
		}

		switch ( $screen->id ) {
			case 'options-permalink':
				include_once VTT_PLUGIN_PATH . 'includes/libraries/vtt-admin-permalinks.php';
				break;
		}
	}
	/**
	 * Add menu items.
	 */
	public function admin_menu()
	{
		add_menu_page(__('VTT Menu', 'vtt-plugin'), __('VTT Menu', 'vtt-plugin'), 'vtt_menu_admin', 'vtt-plugin');
		add_submenu_page('vtt-plugin', __('Trang chính', 'vtt-plugin'), __('Trang chính', 'vtt-plugin'), 'vtt_menu_admin', 'vtt-plugin', array($this, 'pageHome'));
		add_submenu_page('vtt-plugin', __('Quản lý sản phẩm', 'vtt-plugin'), __('Quản lý sản phẩm', 'vtt-plugin'), 'vtt_menu_admin', 'vtt-product', array($this, 'pageProduct'));
		add_submenu_page('vtt-plugin', __('Quản lý lọc', 'vtt-plugin'), __('Quản lý lọc', 'vtt-plugin'), 'vtt_menu_admin', 'vtt-filter', array($this, 'pageFilter'));
		add_submenu_page('vtt-plugin', __('Quản lý hình ảnh, video', 'vtt-plugin'), __('Quản lý hình ảnh, video', 'vtt-plugin'), 'vtt_menu_admin', 'vtt-media', array($this, 'pageMedia'));
		add_submenu_page('vtt-plugin', __('Quản lý liên hệ', 'vtt-plugin'), __('Quản lý liên hệ', 'vtt-plugin'), 'vtt_menu_admin', 'vtt-contact', array($this, 'pageContact'));
		add_submenu_page('vtt-plugin', __('Quản lý mua, đặt hàng', 'vtt-plugin'), __('Quản lý mua, đặt hàng', 'vtt-plugin'), 'vtt_menu_admin', 'vtt-product-purchase', array($this, 'pageProductPurchase'));
	}
	
	// Nạp trước tài liệu;
	public function admin_scripts()
	{
		$helper = VTT_Helper::instance();
		
		wp_register_style('vtt-admin-style', $helper->urlFileStatus('assets/styles/vtt-plugin.css'), array(), null);
		wp_register_script('vtt-admin-core', $helper->urlFileStatus('assets/scripts/vtt-core.js'), array('jquery'), null, true);
		wp_register_script('vtt-admin', $helper->urlFileStatus('assets/scripts/vtt-admin.js'), array('jquery'), null, true);
		
		wp_enqueue_style('vtt-admin-style');
		wp_enqueue_script('vtt-admin-core');
		wp_enqueue_script('vtt-admin');
	}
	
	/**
	 * Add menu item.
	 */
	public function pageHome()
	{
		VTT_AdminHome::output();
	}
	/**
	 * Add menu item.
	 */
	public function pageContact()
	{
		VTT_AdminContact::view();
	}
	/**
	 * Add menu item.
	 */
	public function pageFilter()
	{
		VTT_AdminFilter::view();
	}
	/**
	 * Add menu item.
	 */
	public function pageProduct()
	{
		VTT_AdminProduct::view();
	}
	/**
	 * Add menu item.
	 */
	public function pageProductPurchase()
	{
		VTT_AdminProductPurchase::view();
	}
	/**
	 * Add menu item.
	 */
	public function pageMedia()
	{
		VTT_AdminMedia::view();
	}
}