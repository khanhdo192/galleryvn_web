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

class Controller {

	public static $_instance = null;

	private $_SiteTitle = '';

	private $_SiteSlogan = '';

	private $_MetaSiteTitle = '';

	private $_MetaDescription = '';

	private $_MetaImage = '';
	
	private $_seo = null;

	// Private methods cannot be called
	private function __construct()
	{
		$this->_SiteTitle = get_bloginfo('name');
		$this->_SiteSlogan = get_bloginfo('description');
		
		if (Helper::pluginActive('vtt-plugin/vtt-plugin.php')){
			self::hasPlugin();
		}else{
			self::notPlugin();
		}
	}
	
	// Private methods cannot be called
	private function __clone() {}

	public static function instance() 
	{
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function hasPlugin()
	{
		$this->logicMetaTag();
		$this->setQueryVar();
		$this->setQueryMenu();
		
		$mFilter = VTT_FeModelFilter::instance();
		$dataFilter = $mFilter->getAll();
		set_query_var('mFilter', $mFilter);
		set_query_var('dataFilter', $dataFilter);
		
		if(is_home()){
			$mMedia = VTT_FeModelMedia::instance();
			set_query_var('mMedia', $mMedia);
		}

		if(is_search()){
			$mPost = VTT_FeModelPost::instance();
			$mProductFilter = VTT_FeModelProductFilter::instance();
			set_query_var('mPost', $mPost);
			set_query_var('mProductFilter', $mProductFilter);
		}
		
		if(is_singular('product')){
			$mProduct = VTT_FeModelProduct::instance();
			$mProductFilter = VTT_FeModelProductFilter::instance();
			$mProductImage = VTT_FeModelProductImage::instance();
			set_query_var('mProduct', $mProduct);
			set_query_var('mProductFilter', $mProductFilter);
			set_query_var('mProductImage', $mProductImage);
		}
	}

	public function notPlugin()
	{
		$this->logicMetaTag();
		$this->setQueryMenu();
		$this->setQueryVar();
	}
	
	private function logicMetaTag($model = null){
		
		$SiteTitle = $this->_SiteTitle;
		$SiteSlogan = $this->_SiteSlogan;
		$objectWP = get_queried_object();

		$SiteSEO = $this->_seo;
		if(empty($SiteSEO)){
			$MetaDescription = '';
			$MetaImage = '';
		}else{
			$MetaDescription = $SiteSEO->MetaDescription;
			$MetaImage = Helper::imageUrlUpload($SiteSEO->MetaImage);
		}

		switch (true) {
			// Trang ch???
			case (is_home()):
				$this->_MetaSiteTitle = $SiteTitle . ' - ' .$SiteSlogan;
				$this->_MetaDescription = $MetaDescription;
				break;
			// b??i vi???t - danh m???c
			case (is_category() && !is_search()):
				$this->_MetaSiteTitle = $objectWP->cat_name . ' - ' .$SiteTitle;
				$this->_MetaDescription = $MetaDescription;
				$this->_MetaImage = $MetaImage;
				break;
			// l?? 1 trang
			case (is_single() && is_attachment() || is_page()) :
				$this->_MetaSiteTitle = $objectWP->post_title . ' - ' .$SiteTitle;
				$this->_MetaDescription = $MetaDescription;
				$this->_MetaImage = $MetaImage;
				break;
			// chi ti???t b??i vi???t
			case (is_single() && !is_attachment() && !is_singular('product')) :
				$this->_MetaSiteTitle = $objectWP->post_title . ' - ' .$SiteTitle;
				$this->_MetaDescription = $MetaDescription;
				$this->_MetaImage = $MetaImage;
				break;
			// trang danh m???c
			case is_tax('product_category'):
				$this->_MetaSiteTitle = $objectWP->name . ' - ' .$SiteTitle;
				$this->_MetaDescription = $MetaDescription;
				$this->_MetaImage = $MetaImage;
				break;
			// trang t???t c??? s???n ph???m
			case is_archive('product') :
				$this->_MetaSiteTitle = 'T???t c??? s???n ph???m - ' .$SiteTitle;
				$this->_MetaDescription = $MetaDescription;
				$this->_MetaImage = $MetaImage;
				break;
			// trang chi ti???t s???n ph???m
			case is_singular('product') :
				$this->_MetaSiteTitle = $objectWP->post_title . ' - ' .$SiteTitle;
				$this->_MetaDescription = $MetaDescription;
				$this->_MetaImage = $MetaImage;
				break;
			// trang t??m ki???m
			case (is_search()) :
				$type = isset($_GET['type']) ? $_GET['type'] : '';
				if($type == 'post'){
					$this->_MetaSiteTitle = 'T??m ki???m b??i vi???t - ' .$SiteTitle;
				}else if($type =='product'){
					$this->_MetaSiteTitle = 'T??m ki???m t??c ph???m - ' .$SiteTitle;
				}else if($type =='filter'){
					$this->_MetaSiteTitle = 'L???c t??c ph???m - ' .$SiteTitle;
				}
				$this->_MetaDescription = $MetaDescription;
				$this->_MetaImage = $MetaImage;
				break;
			case (is_tag()) :
				$this->_MetaSiteTitle = 'Th???: '. $objectWP->name . ' - ' .$SiteTitle;
				$this->_MetaDescription = $MetaDescription;
				$this->_MetaImage = $MetaImage;
				break;	
			case (is_author()) :
				$this->_MetaSiteTitle = 'T??c gi???: '. $objectWP->name . ' - ' .$SiteTitle;
				$this->_MetaDescription = $MetaDescription;
				$this->_MetaImage = $MetaImage;
				break;
			case (is_404()) :
				$this->_MetaSiteTitle = 'Kh??ng t??m th???y trang - ' .$SiteTitle;
				$this->_MetaDescription = $MetaDescription;
				$this->_MetaImage = $MetaImage;
				break;
		};

	}
	
	private function setQueryVar()
	{
		set_query_var('SiteTitle', $this->_SiteTitle);
		set_query_var('SiteSlogan', $this->_SiteSlogan);
		set_query_var('MetaSiteTitle', $this->_MetaSiteTitle);
		set_query_var('MetaDescription', $this->_MetaDescription);
		set_query_var('MetaImage', $this->_MetaImage);
	}
	
	private function setQueryMenu(){
		$menuHeaderAside = ___getNameMenu('header-aside-menu');
		set_query_var('menuHeaderAside', $menuHeaderAside);
		$menuTranslation = ___getNameMenu('header-translation');
		set_query_var('menuTranslation', $menuTranslation);
		
		if(is_home()){
			$homeProduct = ___getHomeProduct('home-product');
			set_query_var('homeProduct', $homeProduct);
		}
	}
}