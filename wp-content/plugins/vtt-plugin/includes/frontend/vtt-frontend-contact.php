<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

if ( class_exists( 'VTT_FrontendContact', false ) ) {
	return new VTT_FrontendContact();
}

class VTT_FrontendContact
{
	private $allowSlug = array();
	/**
	 * Constructor.
	 */
	public function __construct()
	{
		$this->allowSlug = ['lien-he','contact'];

		include_once VTT_PATH_FRONTEND_FUNCTION . 'vtt-fe-function-contact.php';
		include_once VTT_PATH_FRONTEND_MODEL . 'vtt-fe-model-contact.php';

		$function = VTT_FeFunctionContact::instance();

		add_action('wp_footer', array($this, 'localize_variables'));
		add_action('wp_ajax_contact-register', array($function, 'register'));
		add_action('wp_ajax_nopriv_contact-register', array($function, 'register'));
	}

	public function localize_variables()
	{
		$param = array(
			'url' => admin_url('admin-ajax.php'),
			'action' => 'contact-register',
			'nonce' => wp_create_nonce('contact-register')
		);

		echo "<script type=\"text/javascript\">";
		echo "var contact_param = ".json_encode($param);
		echo "</script>\n";
	}
}