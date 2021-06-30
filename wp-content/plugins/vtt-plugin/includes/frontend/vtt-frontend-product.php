<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

if ( class_exists( 'VTT_FrontendProduct', false ) ) {
	return new VTT_FrontendProduct();
}

class VTT_FrontendProduct
{
	/**
	 * Constructor.
	 */
	public function __construct()
	{
		include_once VTT_PATH_FRONTEND_FUNCTION . 'vtt-fe-function-product.php';
		include_once VTT_PATH_FRONTEND_MODEL . 'vtt-fe-model-product-purchase.php';

		$function = VTT_FeFunctionProduct::instance();
		add_action('wp_footer', array($this, 'localize_variables'));
		add_action('wp_ajax_product-purchase', array($function, 'purchase'));
		add_action('wp_ajax_nopriv_product-purchase', array($function, 'purchase'));
	}

	public function localize_variables()
	{
		$param = array(
			'url' => admin_url('admin-ajax.php'),
			'action' => 'product-purchase',
			'nonce' => wp_create_nonce('product-purchase')
		);

		echo "<script type=\"text/javascript\">";
		echo "var product_param = ".json_encode($param);
		echo "</script>\n";
	}
}