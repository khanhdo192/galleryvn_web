<?php
/**
 * @Author	HaiNM
 * @Website	http://hainm.com/
 */
 
// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

/**
 * VTT_Install Class.
 */
class VTT_Install 
{
	private static $_wpdb = null;
	
	private static $_collate = '';
	
	private static $_prefix = '';
	
	public static function install()
	{
		if ( ! is_blog_installed() ) {
			return;
		}
		
		global $wpdb;
		self::$_wpdb =& $wpdb;
		self::$_prefix = $wpdb->prefix;
		self::$_collate = self::get_collate($wpdb);
		
		self::create_tables();
		self::create_roles();
		
	}

	private static function create_tables()
	{
		$wpdb = self::$_wpdb;
		$prefix = self::$_prefix;
		
		$wpdb->hide_errors();
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

		$tableContacts = $prefix.'vtt_contacts';
		if (!$wpdb->get_var('SHOW TABLES LIKE "'.($tableContacts).'";') == $tableContacts) {
			dbDelta(self::createSchemaContacts());
		}
		
		$tableMedia = $prefix.'vtt_media';
		if (!$wpdb->get_var('SHOW TABLES LIKE "'.($tableMedia).'";') == $tableMedia) {
			dbDelta(self::createSchemaMedia());
		}

		$tableFilters = $prefix.'vtt_filters';
		if (!$wpdb->get_var('SHOW TABLES LIKE "'.($tableFilters).'";') == $tableFilters) {
			dbDelta(self::createSchemaFilters());
		}

		$tableProducts = $prefix.'vtt_products';
		if (!$wpdb->get_var('SHOW TABLES LIKE "'.($tableProducts).'";') == $tableProducts) {
			dbDelta(self::createSchemaProducts());
		}

		$tableProductImages = $prefix.'vtt_product_images';
		if (!$wpdb->get_var('SHOW TABLES LIKE "'.($tableProductImages).'";') == $tableProductImages) {
			dbDelta(self::createSchemaProductImages());
		}

		$tableProductFilters = $prefix.'vtt_product_filters';
		if (!$wpdb->get_var('SHOW TABLES LIKE "'.($tableProductFilters).'";') == $tableProductFilters) {
			dbDelta(self::createSchemaProductFilters());
		}

		$tableProductPurchase = $prefix.'vtt_product_purchases';
		if (!$wpdb->get_var('SHOW TABLES LIKE "'.($tableProductPurchase).'";') == $tableProductPurchase) {
			dbDelta(self::createSchemaProductPurchases());
		}
	}

	private static function createSchemaContacts()
	{
		$tables = "";
		$tables .= "CREATE TABLE ".(self::$_prefix)."vtt_contacts (
			id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
			name varchar(255) NOT NULL,
			email varchar(255) NOT NULL,
			phone VARCHAR(20) NOT NULL,
			messenger varchar(255) NULL,
			send_at DATETIME NULL,
			created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
			
			PRIMARY KEY (id)
			) ".(self::$_collate).";";

		return $tables;
	}

	private static function createSchemaMedia()
	{
		$tables = "";
		$tables .= "CREATE TABLE ".(self::$_prefix)."vtt_media (
			id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
			name varchar(255) NOT NULL,
			type varchar(255) NOT NULL,
			url varchar(255) NOT NULL,
			link varchar(255) NULL,
			description text NULL,
			created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
			updated_at DATETIME NOT NULL ON UPDATE CURRENT_TIMESTAMP,
			
			PRIMARY KEY (id)
			) ".(self::$_collate).";";

		return $tables;
	}

	private static function createSchemaFilters()
	{
		$tables = "";
		$tables .= "CREATE TABLE ".(self::$_prefix)."vtt_filters (
			id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
			name varchar(255) NOT NULL,
			value varchar(255) NULL,
			type varchar(255) NULL,
			count int(11) UNSIGNED NOT NULL DEFAULT 0,
			parent_id int(11) UNSIGNED NOT NULL DEFAULT 0,
			is_valid tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
			created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,			
			updated_at DATETIME NOT NULL ON UPDATE CURRENT_TIMESTAMP,			
			PRIMARY KEY (id)
			) ".(self::$_collate).";";

		return $tables;
	}


	private static function createSchemaProducts()
	{
		$tables = "";
		$tables .= "CREATE TABLE ".(self::$_prefix)."vtt_products (
			id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
			post_id bigint(20) NOT NULL DEFAULT 0,
			default_price bigint(20) NOT NULL DEFAULT 0,
			discount_price bigint(20) NOT NULL DEFAULT 0,
			size varchar(255) NOT NULL,
			quantity smallint(5) NOT NULL DEFAULT 1,
			author_name varchar(255) NOT NULL,
			author_story text NULL,
			is_valid tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
			created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
			updated_at DATETIME NOT NULL ON UPDATE CURRENT_TIMESTAMP,
			
			PRIMARY KEY (id)
			) ".(self::$_collate).";";

		return $tables;
	}

	private static function createSchemaProductImages()
	{		
		$tables = "";
		$tables .= "CREATE TABLE ".(self::$_prefix)."vtt_product_images (
			id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
			post_id bigint(20) NOT NULL DEFAULT 0,
			url varchar(255) NOT NULL,
			created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
			
			PRIMARY KEY (id)
			) ".(self::$_collate).";";

		return $tables;
	}

	private static function createSchemaProductFilters()
	{		
		$tables = "";
		$tables .= "CREATE TABLE ".(self::$_prefix)."vtt_product_filters (
			id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
			post_id bigint(20) NOT NULL DEFAULT 0,
			filter_id int(11) UNSIGNED NOT NULL,
			filter_value varchar(255) NULL,
			created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
			
			PRIMARY KEY (id)
			) ".(self::$_collate).";";

		return $tables;
	}

	private static function createSchemaProductPurchases()
	{		
		$tables = "";
		$tables .= "CREATE TABLE ".(self::$_prefix)."vtt_product_purchases (
			id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
			type varchar(255) NOT NULL,
			post_id bigint(20) NOT NULL DEFAULT 0,
			name varchar(255) NOT NULL,
			email varchar(255) NOT NULL,
			phone VARCHAR(20) NOT NULL,
			messenger varchar(255) NULL,
			send_at DATETIME NULL,
			created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

			PRIMARY KEY (id)
			) ".(self::$_collate).";";

		return $tables;
	}

	private static function get_collate($wpdb)
	{
		if ($wpdb->has_cap('collation')) {
			return  $wpdb->get_charset_collate();
		}else{
			return '';
		}
	}
	
	public static function create_roles()
	{
		global $wp_roles;
		$wp_roles->add_cap('administrator','vtt_menu_admin'); 
	}
	
	public static function remove_roles()
	{
		global $wp_roles;
		$wp_roles->remove_cap('administrator', 'vtt_menu_admin');
	}
}