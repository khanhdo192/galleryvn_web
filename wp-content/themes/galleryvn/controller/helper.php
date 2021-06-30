<?php
/**
 * HAINM Controll Frontend Class
 *
 * @Author	HaiNM
 * @Website	http://hainm.com/
 */

if (!defined('ABSPATH')) {
	exit;
}

class Helper {

	public static $URL;

	public static $myURL;

	public static function load(){
		self::$URL = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] === 'on' ? 'https' : 'http').'://'.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
		self::$myURL = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] === 'on' ? 'https' : 'http').'://'.$_SERVER["HTTP_HOST"];
	}

	public static function frontendPagination($limit=0, $page=0, $total=0) {
		if ($total > 1){
			//fixbug
			//$count = ceil($total / $limit);
			
			$pos_symbol = strpos(self::$URL,'?');
			// Chưa có ?
			if($pos_symbol === false){
				$symbol = '?page=%#%';
				$my_url = self::$URL.$symbol;
			}
			// Đã có ?
			if($pos_symbol !== false){
				$symbol = '&page=%#%';
				$my_url = self::$URL.$symbol;
			}

			$pos_symbol_1 = strpos(self::$URL,'?page=');
			if($pos_symbol_1 !== false){
				$symbol = '?page=%#%';
				$my_url = substr_replace (self::$URL, $symbol, $pos_symbol_1, strlen(self::$URL));
			}

			$pos_symbol_2 = strpos(self::$URL,'&page=');
			if($pos_symbol_2 !== false){
				$symbol = '&page=%#%';
				$my_url = substr_replace (self::$URL, $symbol, $pos_symbol_2, strlen(self::$URL));
			}

			$pagination = paginate_links(array(
				'base' => $my_url,
				'format' => $symbol,
				'current' => max(1, $page),
				'total' => $total,
				'prev_next' => true,
				'prev_text' => '<span class="page-symbols"><i class="symbol chevron-prev2x white"></i></span>',
				'next_text' => '<span class="page-symbols"><i class="symbol chevron-next2x white"></i></span>',
				'type' => 'array'
			));
			return $pagination;
		}else{
			return array();
		}
	}
	public static function getPostAvatar(int $_id=0) {
		$imageId = get_post_thumbnail_id($_id);
		$imageAvatar = self::imageUrlAsset('placeholder.png');
		if($imageId) {
			$imageAvatar = wp_get_attachment_url($imageId);
		}
		return $imageAvatar;
	}
	public static function urlFileStatus($urlFile='')
	{
		if(empty($urlFile)){
			return '';
		}
		
		$urlNew = null;
		$length = strlen($urlFile);

		if(self::isLocal() === true){
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
		
		$parseUrl = parse_url($urlFile);
		if(empty($parseUrl['scheme'])){
			$reUrl = get_template_directory_uri().'/'.$reName;
			$dirUrl = str_replace('/',DIRECTORY_SEPARATOR, get_template_directory().'/'.$reName);
			$urlNew = $reUrl.'?v='.filemtime($dirUrl);
		}else{
			$urlNew = $reName;
		};
		
		return $urlNew;
	}

	public static function imageUrlAsset(string $param=''){
		$finalUrl = self::$myURL .'/wp-content/themes/'. NAME_THEME . '/assets/images/'. $param;
		return $finalUrl;
	}
	public static function imageUrlUpload(string $param=''){
		$finalUrl = self::$myURL . '/wp-content/uploads/' . $param;
		return $finalUrl;
	}
	public static function pluginActive(string $dir=''){
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		if (is_plugin_active($dir)){
			return true;
		}else{
			return false;
		}
	}

	/**
	 * Build level recursive Array;
	 */
	public static function buildLevel($arrData, $parent = 0, $level = 0, &$result) {
		if (count($arrData) > 0) {
			foreach ($arrData as $key => $val) {
				if ($parent == $val['parent']) {
					$val['level'] = $level;
					$result[] = $val;
					$_parent = $val['id'];
					unset($arrData[$key]);
					self::buildLevel($arrData, $_parent, $level + 1, $result);
				}
			}
		}
	}
	/**
	 * Create a nested array recursively
	 */
	public static function buildTree(array $elements, $parentId = 0) {
		$branch = array();
		foreach ($elements as $element) {
			if ($element['parent'] == $parentId) {
				$children = self::buildTree($elements, $element['id']);
				if ($children) {
					$element['children'] = $children;
				}
				$branch[] = $element;
			}
		}

		return $branch;
	}

	public static function isLocal(){
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
Helper::load();