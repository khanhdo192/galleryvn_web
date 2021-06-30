<?php
/**
 * @Author	HaiNM - VietTuongTac - BreadnTea
 * @Mail	nguyenminhhai@breadntea.vn
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

class VTT_BeFunctionProduct {

	public static $_instance = null;

	private $urlUpload = '';

	// Private methods cannot be called
	private function __construct() {
		$this->urlUpload = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}/wp-content/uploads/";
	}
	
	// Private methods cannot be called
	private function __clone() {}

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	public function create()
	{
		check_ajax_referer('admin-product-create', 'security');
		$this->auth();

		$postId = isset($_POST['postId']) ? $_POST['postId'] : 0;
		$defaultPrice = isset($_POST['defaultPrice']) ? $_POST['defaultPrice'] : 0;
		$size = isset($_POST['size']) ? $_POST['size'] : '';
		$authorName = isset($_POST['authorName']) ? $_POST['authorName'] : '';
		$authorStory = isset($_POST['authorStory']) ? $_POST['authorStory'] : '';
		$image = isset($_POST['image']) ? $_POST['image'] : [];
		$style = isset($_POST['style']) ? $_POST['style'] : 0;
		$theme = isset($_POST['theme']) ? $_POST['theme'] : 0;
		$material = isset($_POST['material']) ? $_POST['material'] : 0;

		if (empty($postId) || empty($defaultPrice) || empty($size) || empty($authorName)){
			wp_send_json_error('Vui lòng nhập: sản phẩm, giá bán, kích thước, tác giả!');
			wp_die();
		}

		$mProduct = VTT_BeModelProduct::instance();
		$haveProduct = $mProduct->checkProduct('post_id', $postId);
		if($haveProduct!=0){
			wp_send_json_error('Thông tin sản phẩm đã tồn tại!');
			die;
		}
	
		/** Data Parent */
		$dataProduct = array(
			'post_id' => $postId,
			'default_price' => $defaultPrice,
			'size' => $size, 
			'author_name' => $authorName,
			'author_story' => $authorStory
		);
		
		$productId = $mProduct->create($dataProduct);
		if(empty($productId)){
			wp_send_json_error('Quá trình tạo gặp lỗi 1!');
			wp_die();
		}

		/** Data Image */
		if(count($image) > 0 || !empty($image)){
			$dataImage = array();
			foreach($image as $value){
				$checkImage = strpos($value, $this->urlUpload);
				if ($checkImage !== false) {
					$dataImage[] = array(
						'post_id' => $postId,
						'url' => str_replace($this->urlUpload,'',$value),
					);
				}else {
					wp_send_json_error('Truyền hình ảnh gặp lỗi!');
					wp_die();
				}
			}

			$mProductImage = VTT_BeModelProductImage::instance();
			$create = $mProductImage->creates($dataImage);
			if(!$create){
				wp_send_json_error('Quá trình tạo gặp lỗi 2!');
				wp_die();
			}
		}

		/** Data Image */
		$filter = array();
		if(!empty($style)){
			array_push($filter, $style);
		}
		
		if(!empty($theme)){
			array_push($filter, $theme);
		}
		
		if(!empty($material)){
			array_push($filter, $material);
		}

		if(count($filter) > 0 || !empty($filter)){
			$dataFilter = array();
			foreach($filter as $value){
				$dataFilter[] = array(
					'post_id' => $postId,
					'filter_id' => $value,
				);
			}

			$mProductFilter = VTT_BeModelProductFilter::instance();
			$create = $mProductFilter->creates($dataFilter);
			if(!$create){
				wp_send_json_error('Quá trình tạo gặp lỗi 3!');
				wp_die();
			}
		}
		
		wp_send_json_success('Tạo thông tin sản phẩm thành công!');
		wp_die();
	}

	public function edit()
	{
		check_ajax_referer('admin-product-edit', 'security');
		$this->auth();

		$postId = isset($_POST['postId']) ? $_POST['postId'] : 0;
		$defaultPrice = isset($_POST['defaultPrice']) ? $_POST['defaultPrice'] : 0;
		$size = isset($_POST['size']) ? $_POST['size'] : '';
		$authorName = isset($_POST['authorName']) ? $_POST['authorName'] : '';
		$authorStory = isset($_POST['authorStory']) ? $_POST['authorStory'] : '';
		$image = isset($_POST['image']) ? $_POST['image'] : [];
		$style = isset($_POST['style']) ? $_POST['style'] : 0;
		$theme = isset($_POST['theme']) ? $_POST['theme'] : 0;
		$material = isset($_POST['material']) ? $_POST['material'] : 0;

		if (empty($postId) || empty($defaultPrice) || empty($size) || empty($authorName)){
			wp_send_json_error('Vui lòng nhập: sản phẩm, giá bán, kích thước, tác giả!');
			wp_die();
		}

		$mProduct = VTT_BeModelProduct::instance();
		$haveProduct = $mProduct->checkProduct('post_id', $postId);
		if($haveProduct!=1){
			wp_send_json_error('Sản phẩm không có trong hệ thống!');
			die;
		}
	
		/** Data Parent */
		$dataProduct = array(
			'post_id' => $postId,
			'default_price' => $defaultPrice,
			'size' => $size, 
			'author_name' => $authorName,
			'author_story' => $authorStory
		);
		
		$update = $mProduct->update(array('post_id' => $postId), $dataProduct);
		if(!$update){
			wp_send_json_error('Quá trình tạo gặp lỗi 1!');
			wp_die();
		}

		/** Data Image */
		if(count($image) > 0 || !empty($image)){
			$dataImage = array();
			foreach($image as $value){
				$checkImage = strpos($value, $this->urlUpload);
				if ($checkImage !== false) {
					$dataImage[] = array(
						'post_id' => $postId,
						'url' => str_replace($this->urlUpload,'',$value),
					);
				}else {
					wp_send_json_error('Truyền hình ảnh gặp lỗi!');
					wp_die();
				}
			}

			$mProductImage = VTT_BeModelProductImage::instance();
			$delete = $mProductImage->delete(array('post_id' => $postId));
			if(!$delete){
				wp_send_json_error('Quá trình xóa gặp lỗi 1!');
				wp_die();
			}

			$create = $mProductImage->creates($dataImage);
			if(!$create){
				wp_send_json_error('Quá trình tạo gặp lỗi 2!');
				wp_die();
			}
		}

		/** Data Image */
		$filter = array();
		if(!empty($style)){
			array_push($filter, $style);
		}
		if(!empty($theme)){
			array_push($filter, $theme);
		}
		if(!empty($material)){
			array_push($filter, $material);
		}

		if(count($filter) > 0 || !empty($filter)){
			$dataFilter = array();
			foreach($filter as $value){
				$dataFilter[] = array(
					'post_id' => $postId,
					'filter_id' => $value,
				);
			}

			$mProductFilter = VTT_BeModelProductFilter::instance();
			$delete = $mProductFilter->delete(array('post_id' => $postId));
			if(!$delete){
				wp_send_json_error('Quá trình xóa gặp lỗi 2!');
				wp_die();
			}

			$create = $mProductFilter->creates($dataFilter);
			if(!$create){
				wp_send_json_error('Quá trình tạo gặp lỗi 3!');
				wp_die();
			}
		}
		
		wp_send_json_success('Sửa thông tin sản phẩm thành công!');
		wp_die();
	}
	
	private function auth(){
		if(!is_user_logged_in()) {
			wp_send_json_error('Error!');
			wp_die();
		}
	}
}