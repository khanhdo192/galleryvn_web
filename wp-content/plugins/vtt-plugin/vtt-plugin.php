<?php
/*
Plugin Name: VTT Plugin
Plugin URI: http://hainm.com
Description: This is a plugin
Author: HaiNM
Version: 1.0
Author URI: http://hainm.com
*/

defined( 'ABSPATH' ) || exit;

define('VTT_PLUGIN_FILE', __FILE__);
define('VTT_VERSION', get_file_data(__FILE__, ['Version'], 'plugin')[0]);
define('VTT_PLUGIN_PATH', plugin_dir_path( __FILE__ ));

if (!class_exists('VTT_Plugin', false)) {
	include_once VTT_PLUGIN_PATH . 'includes/vtt-plugin.php';
}
//print_r(ABSPATH);
function VTT_Plugin() {
	return VTT_Plugin::instance();
}
$GLOBALS['VTT_Plugin'] = VTT_Plugin();