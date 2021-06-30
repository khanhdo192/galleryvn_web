<?php
if (!defined('ABSPATH')) exit;
/**
 * HaiNM theme functions and definitions
 * @package WordPress
 */
define('NAME_THEME', 'galleryvn');

/**
 * HaiNM Theme only works in WordPress 5.2.3 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '5.2.3', '<' ) ) {
	add_action( 'admin_notices', '___error_notice' );
}

if (!class_exists('Helper', false)) {
	include_once get_template_directory() . '/controller/helper.php';
}
if (!class_exists('Controller', false)) {
	include_once get_template_directory() . '/controller/controller.php';
}
/**
 * Hook
 */
add_action('after_setup_theme', '___setup');
add_action('wp_enqueue_scripts','___scripts');
add_action('init', '___disableExtraImageSizes');
//add_action('wp_default_scripts', '___dequeueJqueryMigrate');
add_action('customize_register', '___disableCustomizeCSS' );

add_filter('image_resize_dimensions', '___disableCrop', 10, 6);
add_filter('sanitize_file_name', '___reFileNameToHash', 10, 1);

// Core, Plugin, Theme Notifications
add_filter('pre_site_transient_update_core','___removeWPCoreUpdate');
add_filter('pre_site_transient_update_plugins','___removeWPCoreUpdate');
add_filter('pre_site_transient_update_themes','___removeWPCoreUpdate');

remove_action('wp_head', 'wp_generator');
remove_action('wp_head', '_wp_render_title_tag', 1);
remove_action('wp_head', 'rest_output_link_wp_head', 10);
remove_action('wp_head', 'wp_resource_hints', 2);     
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_filter('wp_robots', 'wp_robots_max_image_preview_large');

remove_action('wp_head', 'feed_links_extra', 3);	// Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2);	// Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link');	// Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link');	// Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);	// Display relational links for the posts adjacent to the current post.
// Remove the REST API lines from the HTML Header
remove_action('wp_head', 'rest_output_link_wp_head', 10);
remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
//other
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('template_redirect', 'wp_shortlink_header', 11);

//admin
add_action('admin_menu', '___removeMenuComment');
add_action('admin_init', '___disableCommentAndTrackback');
add_action('wp_before_admin_bar_render', '___removeMenuBarComment');

remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu');
remove_action('admin_head', 'wp_admin_canonical_url');
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('admin_print_styles', 'print_emoji_styles');
/**
 * Cài đặt theme.
 */
if (!function_exists('___setup')){
	
	function ___setup() {

		/* Thêm ngôn ngữ tìm trong folder: languages */
		load_theme_textdomain(NAME_THEME, get_template_directory() . '/languages');
		
		add_theme_support('title-tag');
		add_theme_support('post-thumbnails');
		add_theme_support('post-formats',array(
			'image',
		));
		add_theme_support('admin-bar', array( 'callback' => '__return_false' ));
		add_post_type_support('page', 'excerpt');
		
		// header menu.
		register_nav_menus(
			array(
				'header-aside-menu' => __('Header aside menu', NAME_THEME),
				'home-product' => __('Home product', NAME_THEME),
			)
		);
		
		// Logo.
		add_theme_support(
			'custom-logo',
			array(
				'width'       => 300,
				'height'      => 60,
				'flex-width'  => false,
				'flex-height' => false,
			)
		);

	}
}
/**
 * Enqueues scripts and styles.
 */
function ___scripts()
{
	/* Khai báo css */
	wp_dequeue_style('wp-block-library');
	wp_enqueue_style(NAME_THEME .'-swiper', Helper::urlFileStatus('https://unpkg.com/swiper/swiper-bundle.css'), array(), null);
	wp_enqueue_style(NAME_THEME .'-app', Helper::urlFileStatus('assets/styles/app.css'), array(), null);
	
	/* Khai báo script */
    wp_deregister_script('jquery-core');
	wp_deregister_script('wp-embed');
    wp_register_script('jquery-core', Helper::urlFileStatus('assets/scripts/jquery-3.5.1.js'), array(), null, true);
	wp_enqueue_script(NAME_THEME .'-app', Helper::urlFileStatus('assets/scripts/app.js'), array('jquery'), null, true);
	wp_enqueue_script(NAME_THEME .'-swiper', Helper::urlFileStatus('https://unpkg.com/swiper/swiper-bundle.js'), array('jquery'), null, true);
	wp_enqueue_script(NAME_THEME .'-script', Helper::urlFileStatus('assets/scripts/script.js'), array('jquery'), null, true);
}

function ___dequeueJqueryMigrate( $scripts )
{
    if ( ! is_admin() && ! empty( $scripts->registered['jquery'] ) ) {
        $scripts->registered['jquery']->deps = array_diff(
            $scripts->registered['jquery']->deps,
            [ 'jquery-migrate' ]
        );
    }
}
function ___disableCustomizeCSS( $wp_customize )
{
   $wp_customize->remove_section('custom_css');
}
/**
 * Loại bỏ image resize và rename.
 */
function ___disableExtraImageSizes()
{
    foreach ( get_intermediate_image_sizes() as $size ) {
        remove_image_size( $size );
    }
}
function ___disableCrop( $enable, $orig_w, $orig_h, $dest_w, $dest_h, $crop )
{
    return false;
}
function ___reFileNameToHash($filename)
{
    $info = pathinfo($filename);
    $ext  = empty($info['extension']) ? '' : '.' . $info['extension'];
	$name = md5(uniqid(mt_rand())).$ext;

	return $name;
}
/**
 * Admin.
 */
function ___disableCommentAndTrackback() {
    $postTypes = get_post_types();
    foreach ($postTypes as $post_type) {
        if(post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
        } 
		if(post_type_supports($post_type, 'trackbacks')) {
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
}
function ___removeMenuComment(){
	remove_menu_page('edit-comments.php');
}
function ___removeMenuBarComment(){
    global $wp_admin_bar;
    $wp_admin_bar->remove_node('comments');
}
/**
 * System.
 */
function ___removeWPCoreUpdate()
{
	if(Helper::isLocal() === true){
		return false;
	}else{
		return true;
	}
}
/**
 * Tìm kiếm theo title (sql 1 - where like)
 */
function ___posts_where($query, $wp_query)
{	
    if(empty($query)) {
        return $query;
    }
	
    if ($search_term = $wp_query->get('search_title')) {
		global $wpdb;

		$query .= ' AND ('.$wpdb->posts.'.post_type = "post") ';

		if (!is_user_logged_in()){
            $query .= ' AND ('.$wpdb->posts.'.post_password = "") ';
		}

		$search_term = esc_sql($wpdb->esc_like($search_term));
        $query .= ' AND ('.$wpdb->posts.'.post_title LIKE \'%'.$search_term.'%\')';

    }
    return $query;
}

/**
 * Tìm kiếm theo title (sql 1 - order by)
 */
function ___posts_orderby($query, $wp_query)
{
	global $wpdb;
	
	if ($search_term = $wp_query->get('search_title')) {
		$search_term = esc_sql($wpdb->esc_like($search_term));
		$query = ''.$wpdb->posts.'.post_title LIKE \'%'.$search_term.'%\' DESC,'.$query;
	}
    return $query;
}
/**
 * Version error notice.
 */
function ___error_notice()
{
	$message = sprintf( __( 'Theme sử dụng cho WordPress phiên bản 5.2.3 trở lên. Hiện tại phiên bản của bạn là %s. Vui lòng nâng cấp phiên bản mới.', NAME_THEME ), $GLOBALS['wp_version'] );
	printf( '<div class="error"><p>%s</p></div>', $message );
}
/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/include/template-tags.php';