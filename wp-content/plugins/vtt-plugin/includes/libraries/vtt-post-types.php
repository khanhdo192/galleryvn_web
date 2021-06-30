<?php
/**
 * Post Types
 *
 * Registers post types and taxonomies.
 *
 */

defined('ABSPATH') || exit;

if ( class_exists('VTT_PostTypes', false ) ) {
	return new VTT_PostTypes();
}
/**
 * Post types Class.
 */
class VTT_PostTypes {

	private $pluginName = '';

	private $permalinks = array();

	private $capabilities = array();

	public function __construct()
	{
		$helper = VTT_Helper::instance();
		$this->pluginName = 'vtt-plugin';
		$this->permalinks = $helper->get_permalink_structure();
		$this->init_hooks();
	}

	/**
	 * Hook in methods.
	 */
	private function init_hooks()
	{
		add_action('init', array($this, 'custom_taxonomy'), 0);
		add_action('init', array($this, 'products_post_type'), 0);
		add_action('admin_init', array($this, 'add_theme_caps'), 0);
	}
	
	// Register Custom Taxonomy
	public function custom_taxonomy()
	{
		$labels = array(
			'name'                       => _x('Product categories', 'Taxonomy General Name', $this->pluginName),
			'singular_name'              => _x('Product category', 'Taxonomy Singular Name', $this->pluginName),
			'menu_name'                  => __('Product categories', $this->pluginName),
			'all_items'                  => __('All product categories', $this->pluginName),
			'parent_item'                => __('Parent product category', $this->pluginName),
			'parent_item_colon'          => __('Parent product category:', $this->pluginName),
			'new_item_name'              => __('New product category name', $this->pluginName),
			'add_new_item'               => __('Add new product category', $this->pluginName),
			'edit_item'                  => __('Edit product category', $this->pluginName),
			'update_item'                => __('Update product category', $this->pluginName),
			'view_item'                  => __('View Item', $this->pluginName),
			'separate_items_with_commas' => __('Separate items with commas', $this->pluginName),
			'add_or_remove_items'        => __('Add or remove items', $this->pluginName),
			'choose_from_most_used'      => __('Choose from the most used', $this->pluginName),
			'popular_items'              => __('Popular Items', $this->pluginName),
			'search_items'               => __('Search categories', $this->pluginName),
			'not_found'                  => __('No categories found', $this->pluginName),
			'no_terms'                   => __('No items', $this->pluginName),
			'items_list'                 => __('Items list', $this->pluginName),
			'items_list_navigation'      => __('Items list navigation', $this->pluginName),
		);
		
		
		$rewrite = array(
			'slug'                       => $this->permalinks['product_category_rewrite_slug'],
			'with_front'                 => false,
			'hierarchical'               => true,
		);
		
		$capabilities = array(
			'manage_terms'               => 'manage_product_terms',
			'edit_terms'                 => 'edit_product_terms',
			'delete_terms'               => 'delete_product_terms',
			'assign_terms'               => 'assign_product_terms',
		);

		array_push($this->capabilities, $capabilities);

		$args = array(
			'label'						 => __('Product categories', $this->pluginName),
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_in_rest'               => true,
			'show_tagcloud'              => false,
			'query_var'					 => true,
			'rewrite'                    => $rewrite,
			'capabilities'               => $capabilities,
			'update_count_callback'		 => '_update_post_term_count',
		);
		
		register_taxonomy('product_category', array('product'), $args );
	}

	public function products_post_type()
	{
		$labels = array(
			'name'                  => _x('Sản phẩm', 'Post Type General Name', $this->pluginName),
			'singular_name'         => _x('Sản phẩm', 'Post Type Singular Name', $this->pluginName),
			'menu_name'             => __('Products', $this->pluginName),
			'name_admin_bar'        => __('Product', $this->pluginName),
			'archives'              => __('Item Archives', $this->pluginName),
			'attributes'            => __('Item Attributes', $this->pluginName),
			'parent_item_colon'     => __('Parent Product:', $this->pluginName),
			'all_items'             => __('All Products', $this->pluginName),
			'add_new_item'          => __('Add New Product', $this->pluginName),
			'add_new'               => __('New Product', $this->pluginName),
			'new_item'              => __('New Item', $this->pluginName),
			'edit_item'             => __('Edit Product', $this->pluginName),
			'update_item'           => __('Update Product', $this->pluginName),
			'view_item'             => __('View Product', $this->pluginName),
			'view_items'            => __('View Items', $this->pluginName),
			'search_items'          => __('Search products', $this->pluginName),
			'not_found'             => __('No products found', $this->pluginName),
			'not_found_in_trash'    => __('No products found in Trash', $this->pluginName),
			'featured_image'        => __('Featured Image', $this->pluginName),
			'set_featured_image'    => __('Set featured image', $this->pluginName),
			'remove_featured_image' => __('Remove featured image', $this->pluginName),
			'use_featured_image'    => __('Use as featured image', $this->pluginName),
			'insert_into_item'      => __('Insert into item', $this->pluginName),
			'uploaded_to_this_item' => __('Uploaded to this item', $this->pluginName),
			'items_list'            => __('Items list', $this->pluginName),
			'items_list_navigation' => __('Items list navigation', $this->pluginName),
			'filter_items_list'     => __('Filter items list', $this->pluginName),
		);

		$rewrite = array(
			'slug'                  => $this->permalinks['product_rewrite_slug'],
			'with_front'            => false,
			'pages'                 => true,
			'feeds'                 => true,
		);
		
		$supports = array('title', 'editor', 'excerpt', 'thumbnail');
		
		$capabilities = array(
			'edit_post'             => 'edit_product',
			'read_post'             => 'read_product',
			'delete_post'           => 'delete_product',
			'edit_posts'            => 'edit_products',
			'edit_others_posts'     => 'edit_others_products',
			'publish_posts'         => 'publish_products',
			'read_private_posts'    => 'read_private_products',
		);
		
		array_push($this->capabilities, $capabilities);

		$args = array(
			'label'                 => __('Product', $this->pluginName),
			'description'           => __('Product information pages.', $this->pluginName),
			'labels'                => $labels,
			'supports'              => $supports,
			'taxonomies'            => array('product_category'),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_nav_menus'     => true,
			'show_in_rest'			=> true,
			'menu_position'         => 100,
			'menu_icon'             => 'dashicons-archive',
			'has_archive'           => true,
			'exclude_from_search'   => true,
			'publicly_queryable'    => true,
			'rewrite'               => $rewrite,
			'capabilities'          => $capabilities,
			'map_meta_cap'			=> true,
			'query_var'				=> true,
		);

		register_post_type('product', $args);
	}

	public function add_theme_caps()
	{
		$role = get_role('administrator');
		foreach($this->capabilities[0] as $value){
			$role->add_cap($value);
		};
		foreach($this->capabilities[1] as $value){
			$role->add_cap($value);
		};
	}
}