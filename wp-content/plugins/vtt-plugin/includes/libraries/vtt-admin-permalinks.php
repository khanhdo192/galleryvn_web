<?php
/**
 * HAINM Admin Permalink Class
 *
 * @Author	HaiNM - JITVN
 * @Website	http://hainm.com/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'VTT_AdminPermalinks', false ) ) {
	return new VTT_AdminPermalinks();
}

/**
 * Admin_Permalink Class.
 */
class VTT_AdminPermalinks {

	/**
	 * Permalink settings.
	 *
	 * @var array
	 */
	private $permalinks = array();

	/**
	 * Hook in tabs.
	 */
	public function __construct() {
		$this->settings_init();
		$this->settings_save();
	}

	/**
	 * Init our settings.
	 */
	public function settings_init() {
		add_settings_field(
			'product_category_base_slug',
			__( 'Product category base', 'hainm-plugin' ),
			array( $this, 'product_category_slug_input' ),
			'permalink',
			'optional'
		);
		add_settings_field(
			'product_base_slug',
			__( 'Product base', 'hainm-plugin' ),
			array( $this, 'product_base_slug_input' ),
			'permalink',
			'optional'
		);
		$helper = VTT_Helper::instance();
		$this->permalinks = $helper->get_permalink_structure();
	}

	/**
	 * Show a slug input box.
	 */
	public function product_category_slug_input() {
		?>
		<input name="product_category_base_slug" type="text" class="regular-text code" value="<?php echo esc_attr( $this->permalinks['product_category_base'] ); ?>"/>
		<?php
	}

	/**
	 * Show a slug input box.
	 */
	public function product_base_slug_input() {
		?>
		<input name="product_base_slug" type="text" class="regular-text code" value="<?php echo esc_attr( $this->permalinks['product_base'] ); ?>" />
		<?php
	}

	/**
	 * Save the settings.
	 */
	public function settings_save() {
		if ( ! is_admin() ) {
			return;
		}

		// We need to save the options ourselves; settings api does not trigger save for the permalinks page.
		if ( isset( $_POST['permalink_structure'], $_POST['product_category_base_slug'], $_POST['product_base_slug'] ) ){

			$permalinks = (array) get_option( 'vtt_permalinks', array() );
			// Generate product base.
			$product_category_base = wp_unslash($_POST['product_category_base_slug']);
			$product_base = wp_unslash($_POST['product_base_slug']);

			$permalinks['product_category_base']  = $this->_sanitize_permalink( $product_category_base );
			$permalinks['product_base'] = $this->_sanitize_permalink( $product_base );

			update_option('vtt_permalinks', $permalinks);
		}
	}

	public function _sanitize_permalink( $value ) {
		global $wpdb;

		$value = $wpdb->strip_invalid_text_for_column( $wpdb->options, 'option_value', $value );

		if ( is_wp_error( $value ) ) {
			$value = '';
		}

		$value = esc_url_raw( trim( $value ) );
		$value = str_replace( 'http://', '', $value );
		return untrailingslashit( $value );
	}

}