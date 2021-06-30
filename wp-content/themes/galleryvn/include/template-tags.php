<?php
if (!defined('ABSPATH')) exit;
/**
 * Menu header.
 */
if (!function_exists('___getNameMenu'))
{
	function ___getNameMenu($_name='')
	{
		$arrayMenu = wp_get_nav_menu_items($_name);
		if(empty($arrayMenu)){
			return [];
		}
		
		$headerMenu = array();
		foreach ($arrayMenu as $value) {

			$pos0 = substr($value->url,0,1);
			if($pos0 === '/'){
				$slug = 'javascript:void(0)';
			}else{
				$slug = $value->url;
			}

			$headerMenu[] = [
				'id' => $value->ID,
				'trueId' => $value->object_id,
				'title' => $value->title,
				'url' => $slug,
				'parent' => $value->menu_item_parent,
				'children' => array()
			];
		}


		$tree = Helper::buildTree($headerMenu,0);
		
		return $tree;
	}
}
/**
 * Menu header.
 */
if (!function_exists('___getHomeProduct'))
{
	function ___getHomeProduct($_name='')
	{
		$arrayMenu = wp_get_nav_menu_items($_name);
		if(empty($arrayMenu)){
			return [];
		}
		
		$postIds = array_column($arrayMenu, 'object_id');
		$mProduct = VTT_FeModelProduct::instance();
		$theProduct = $mProduct->getExtraPostIds($postIds);

		$products = array();
		foreach ($arrayMenu as $key => $value) {
			$trueId = $value->object_id;
			$default_price = null;
			$quantity = null;
			$author_name = null;
			
			if(!empty($theProduct[$trueId])){
				$default_price = $theProduct[$trueId]->default_price;
				$quantity = $theProduct[$trueId]->quantity;
				$author_name = $theProduct[$trueId]->author_name;
			};
			
			$products[] = [
				'id' => $value->ID,
				'trueId' => $trueId,
				'title' => $value->title,
				'url' => $value->url,
				'default_price' => $default_price,
				'quantity' => $quantity,
				'author_name' => $author_name
			];
		}
		
		return $products;
	}
}

/**
 * Menu header.
 */
if (!function_exists('___getTranslation'))
{
	function ___getTranslation($_name='')
	{
		$arrayMenu = wp_get_nav_menu_items($_name);
		if(empty($arrayMenu)){
			return [];
		}

		$translations = array();
		foreach ($arrayMenu as $key => $value) {
			$translations = [
				'title' => $value->title,
				'url' => $value->url,
			];
		}
		return $translations;
	}
}

/**
 * Menu header.
 */
if (!function_exists('___getCategoryByIdAndPost')){
	function ___getCategoryByIdAndPost(int $id = 0, int $maxPost = 0){
		if(empty($id)){
			return (object)[];
		}

		$category = get_term_by('id', $id, 'category');
		if(empty($category)){
			return (object)[];
		};

		$page = 1;
		$offset = 0;
		$newQueryWP = new WP_Query(array(
			'posts_per_page' => $maxPost,
			'post_status' => 'publish',
			'post_type' => 'post',
			'cat' => $id,
			'page' => $page,
			'offset' => $offset
		));

		$outData = (object) [
			'name' => $category->name,
			'url' => get_category_link($category->term_taxonomy_id),
			'posts' => $newQueryWP->posts,
		];

		return $outData;
	}
}