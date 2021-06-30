<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

class VTT_AdminHome 
{
	
	public static function output() {
		include_once VTT_PATH_ADMIN_VIEW . 'main-page.php';
	}
	
}