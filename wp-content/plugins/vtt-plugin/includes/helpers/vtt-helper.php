<?php
/**
 * @Author	HaiNM
 * @Website	http://hainm.com/
 */
if (!defined('ABSPATH')) {
	exit;
}

class VTT_Helper {
		
	private static $_instance = null;

	private $URL = '';

	// Private methods cannot be called
	private function __construct()
	{
		$this->URL = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] === 'on' ? 'https' : 'http').'://'.$_SERVER["HTTP_HOST"];
	}
	
	// Private methods cannot be called
	private function __clone() {}

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	public function admin_pagination($limit=0, $pagin=0, $total=0)
	{
		$pagination = array();
		$URL = $this->URL . $_SERVER["REQUEST_URI"];
		
		if ($total > 1){
			$count = ceil($total / $limit);
			
			$posUrl = strpos($URL,'&pagin=');
			if($posUrl !== false){
				$myUrl = substr_replace($URL,'&pagin=%#%', $posUrl, strlen($URL));
			}else{
				$myUrl = $URL.'&pagin=%#%';
			}
			
			$pagination = paginate_links(array(
				'base' => $myUrl,
				'format' => '&pagin=%#%',
				'current' => max(1, $pagin),
				'total' => $count,
				'prev_text' => '&laquo',
				'next_text' => '&raquo',
				'type' => 'array'
			));
			
			return $pagination;
		}
		
		return $pagination;
	}
	
	public function getPostAvatar(int $_id=0) {
		$imageId = get_post_thumbnail_id($_id);
		$imageUrl = $this->assetImage('placeholder.png');
		if($imageId) {
			$imageUrl = wp_get_attachment_url($imageId);
		}
		return $imageUrl;
	}
	
	public function assetImage(string $param=''){
		$url = VTT_Plugin()->plugin_url() . '/assets/images/'. $param;
		return $url;
	}
	
	public function urlUpload(string $param=''){
		$finalUrl = $this->URL . '/wp-content/uploads/' . $param;
		return $finalUrl;
	}
	
	public function urlFileStatus($urlFile='')
	{
		if(empty($urlFile)){
			return '';
		}
		
		$reUrl = '';
		$length = strlen($urlFile);

		if(self::isLocal() == true){
			$suffix = '.';
		}else{
			$suffix = '.min.';
		}
		
		$posCSS = strpos($urlFile,'.css');
		if($posCSS !== false){
			$urlFile = substr_replace($urlFile, '', $posCSS, $length);
			$reName = $urlFile.$suffix.'css';
			
		}

		$posJS = strpos($urlFile,'.js');
		if($posJS !== false){
			$urlFile = substr_replace($urlFile, '', $posJS, $length);
			$reName = $urlFile.$suffix.'js';
		}

		$reUrl = VTT_Plugin()->plugin_url().'/'.$reName;
		$dirUrl = str_replace('/',DIRECTORY_SEPARATOR, VTT_Plugin()->plugin_path().'/'.$reName);
		$urlNew = $reUrl.'?v='.filemtime($dirUrl);
		
		return $urlNew;
	}

	public function check_user_role($roles, $user_id = null) {
		if ($user_id) $user = get_userdata($user_id);
		else $user = wp_get_current_user();
		if (empty($user)) return false;
		foreach ($user->roles as $role) {
			if (in_array($role, $roles)) {
				return true;
			}
		}
		return false;
	}

	public function get_permalink_structure()
	{
		$saved_permalinks = (array) get_option( 'vtt_permalinks', array() );
		$permalinks = wp_parse_args(
			array_filter( $saved_permalinks ),
			array(
				'product_category_base' => 'product-category',
				'product_base' => 'product',
			)
		);

		if ( $saved_permalinks !== $permalinks ) {
			update_option( 'vtt_permalinks', $permalinks );
		}

		$permalinks['product_category_rewrite_slug'] = untrailingslashit( $permalinks['product_category_base'] );
		$permalinks['product_rewrite_slug'] = untrailingslashit( $permalinks['product_base'] );

		return $permalinks;
	}

	/**
	 * Converts a mysql datetime value into a unix timestamp
	 * @param $mysqlDateTime string The timestamp in the mysql datetime format
	 * @return int The time in seconds
	 */
	public function GetTimestampFromMySql($mysqlDateTime)
	{
		list($date, $hours) = explode(' ', $mysqlDateTime);
		list($year, $month, $day) = explode('-', $date);
		list($hour, $min, $sec) = explode(':', $hours);
		return mktime(intval($hour), intval($min), intval($sec), intval($month), intval($day), intval($year));
	}

	private function isLocal()
	{
		$whitelist = array(
			'127.0.0.1',
			'::1'
		);

		if(in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
			return true;
		}
			
		return false;
	}
}