<?php
/**
 * The base config
 *
 */
	date_default_timezone_set('Asia/Ho_Chi_Minh');

	$whitelist = array(
		'127.0.0.1',
		'::1'
	);
	
	if(in_array($_SERVER['REMOTE_ADDR'], $whitelist)){

		define('WP_HOME', ($_SERVER['SERVER_PORT'] == 443 ? 'https' : 'http').'://'.$_SERVER['SERVER_NAME']);
		define('WP_SITEURL', ($_SERVER['SERVER_PORT'] == 443 ? 'https' : 'http').'://'.$_SERVER['SERVER_NAME']);
		define('DB_NAME', 'galleryvn');
		define('DB_USER', 'root');
		define('DB_PASSWORD', '');
		define('DB_HOST', '127.0.0.1');
		define('DISALLOW_FILE_EDIT', true);
		define('DISALLOW_FILE_MODS', true);
		define('AUTOMATIC_UPDATER_DISABLED', false);
		define('FORCE_SSL_ADMIN', false);
		define('EMPTY_TRASH_DAYS', 1);
		
		// Debug
		define('WP_ENVIRONMENT_TYPE', 'development');
		define('WP_DEBUG', true);
		define('WP_DEBUG_LOG', true);
		define('WP_DEBUG_DISPLAY', true);
		define('SCRIPT_DEBUG', false);

	}else{

		define('WP_HOME', 'https://'.$_SERVER['SERVER_NAME'] );
		define('WP_SITEURL', 'https://'.$_SERVER['SERVER_NAME'] );
		if(isHTTPS() == false){
			header('Location: https://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);
			exit();
		}
		define('DB_NAME', 'sachluoc_galleryvn');
		define('DB_USER', 'sachluoc_galleryvn');
		define('DB_PASSWORD', 'xIL6lq@galleryvn');
		define('DB_HOST', 'localhost');
		define('DISALLOW_FILE_EDIT', true);
		define('DISALLOW_FILE_MODS', true);
		define('AUTOMATIC_UPDATER_DISABLED', true);
		define('FORCE_SSL_ADMIN', false);
		define('EMPTY_TRASH_DAYS', 30);
		// Debug
		define('WP_ENVIRONMENT_TYPE', 'production');
		define('WP_DEBUG', false);
		define('WP_DEBUG_LOG', false);
		define('WP_DEBUG_DISPLAY', true);
		define('SCRIPT_DEBUG', false);

	}
	
	function isHTTPS(){
		if (array_key_exists('HTTPS', $_SERVER) && 'on' === $_SERVER["HTTPS"]) {
			return true;
		}
		if (array_key_exists('SERVER_PORT', $_SERVER) && 443 === (int)$_SERVER["SERVER_PORT"]) {
			return true;
		}
		if (array_key_exists('HTTP_X_FORWARDED_SSL', $_SERVER) && 'on' === $_SERVER["HTTP_X_FORWARDED_SSL"]) {
			return true;
		}
		if (array_key_exists('HTTP_X_FORWARDED_PROTO', $_SERVER) && 'https' === $_SERVER["HTTP_X_FORWARDED_PROTO"]) {
			return true;
		}
		return false;
	}
