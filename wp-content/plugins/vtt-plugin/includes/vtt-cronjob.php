<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

if ( class_exists( 'VTT_CronJob', false ) ) {
	return new VTT_CronJob();
}

class VTT_CronJob 
{
	/**
	 * Constructor.
	 */
	public function __construct()
	{		
		if (!defined('VTT_PATH_CRONJOB_MODEL')) define('VTT_PATH_CRONJOB_MODEL', VTT_PLUGIN_PATH . 'includes/cronjob/models/');
		if (!defined('VTT_PATH_CRONJOB_FUNCTION')) define('VTT_PATH_CRONJOB_FUNCTION', VTT_PLUGIN_PATH . 'includes/cronjob/functions/');
		
		$this->actionSendMail();
	}
	
	public function actionSendMail()
	{
		include_once VTT_PLUGIN_PATH . 'includes/helpers/vtt-template-email.php';
		include_once VTT_PATH_CRONJOB_MODEL . 'vtt-cj-model-contact.php';
		include_once VTT_PATH_CRONJOB_MODEL . 'vtt-cj-model-product-purchase.php';
		include_once VTT_PATH_CRONJOB_FUNCTION . 'vtt-cj-function-send-mail.php';

		$function = VTT_CjFunctionSendMail::instance();
		add_action('wp_ajax_cronjob-send-email', array($function, 'sendEmail'));
		add_action('wp_ajax_nopriv_cronjob-send-email', array($function, 'sendEmail'));
	}

}