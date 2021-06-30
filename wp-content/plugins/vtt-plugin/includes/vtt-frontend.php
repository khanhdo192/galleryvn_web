<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

if ( class_exists( 'VTT_Frontend', false ) ) {
	return new VTT_Frontend();
}

class VTT_Frontend {
	
	/**
	 * Hook in methods.
	 */
	 
	/**
	 * Constructor.
	 */
	public function __construct()
	{		
		if (!defined('VTT_PATH_FRONTEND')) define('VTT_PATH_FRONTEND', VTT_PLUGIN_PATH . 'includes/frontend/');
		if (!defined('VTT_PATH_FRONTEND_MODEL')) define('VTT_PATH_FRONTEND_MODEL', VTT_PLUGIN_PATH . 'includes/frontend/models/');
		if (!defined('VTT_PATH_FRONTEND_FUNCTION')) define('VTT_PATH_FRONTEND_FUNCTION', VTT_PLUGIN_PATH . 'includes/frontend/functions/');
		
		add_action('init', array( $this, 'includes'));
	}
	
	/**
	 * Include any classes we need within frontend.
	 */
	public function includes()
	{
		include_once VTT_PATH_FRONTEND . 'vtt-frontend-product.php';
		include_once VTT_PATH_FRONTEND . 'vtt-frontend-contact.php';
		include_once VTT_PATH_FRONTEND_MODEL . 'vtt-fe-model-media.php';
		include_once VTT_PATH_FRONTEND_MODEL . 'vtt-fe-model-post.php';
		include_once VTT_PATH_FRONTEND_MODEL . 'vtt-fe-model-filter.php';
		include_once VTT_PATH_FRONTEND_MODEL . 'vtt-fe-model-product-filter.php';
		include_once VTT_PATH_FRONTEND_MODEL . 'vtt-fe-model-product.php';
		include_once VTT_PATH_FRONTEND_MODEL . 'vtt-fe-model-product-image.php';
	}
	
}