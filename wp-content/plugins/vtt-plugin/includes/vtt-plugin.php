<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

final class VTT_Plugin {
	
	protected static $_instance = null;
	
	/* Main Instance */
	public static function instance() 
	{
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	/* HAINM Constructor */
	public function __construct() 
	{
		$this->includes();
		$this->initHooks();
	}
	
	private function includes() 
	{
		include_once VTT_PLUGIN_PATH . 'includes/vtt-install.php';
		include_once VTT_PLUGIN_PATH . 'includes/helpers/vtt-helper.php';
		include_once VTT_PLUGIN_PATH . 'includes/helpers/vtt-query.php';
		include_once VTT_PLUGIN_PATH . 'includes/libraries/vtt-post-types.php';
		include_once VTT_PLUGIN_PATH . 'includes/vtt-cronjob.php';
		
		if ($this->is_request('admin')) {
			include_once VTT_PLUGIN_PATH . 'includes/vtt-admin.php';
		}

		if ($this->is_request('frontend')) {
			include_once VTT_PLUGIN_PATH . 'includes/vtt-frontend.php';
		}
	}
	
	private function initHooks()
	{
		register_activation_hook(VTT_PLUGIN_FILE, array('VTT_Install', 'install'));
	}
	
	/**
	 * What type of request is this?
	 *
	 * @param  string $type admin, ajax, cron or frontend.
	 * @return bool
	 */
	private function is_request( $type )
	{
		switch ( $type ) {
			case 'admin':
				return is_admin();
			case 'ajax':
				return defined( 'DOING_AJAX' );
			case 'cron':
				return defined( 'DOING_CRON' );
			case 'frontend':
				return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
		}
	}
	/**
	 * Get the plugin url.
	 *
	 * @return string
	 */
	public function plugin_url()
	{
		return untrailingslashit( plugins_url( '/', VTT_PLUGIN_FILE ) );
	}

	/**
	 * Get the plugin path.
	 *
	 * @return string
	 */
	public function plugin_path()
	{
		return untrailingslashit( plugin_dir_path( VTT_PLUGIN_FILE ) );
	}
}