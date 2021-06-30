<?php if (!defined('ABSPATH')) exit; ?>
<?php
	$theCategory = get_queried_object();
	$categoryId = $theCategory->term_id;
	$categorySlug = $theCategory->slug;
	$categoryTaxonomy = $theCategory->taxonomy;
	
	$maxProduct = 6;
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	$offset = ($maxProduct * $page) - $maxProduct;
	
	$newQueryWP = new WP_Query(array(
		'post_type' => 'product',
		'posts_per_page' => $maxProduct,
		'post_status' => 'publish',
		'tax_query' => array(
			array(
				'taxonomy' => $categoryTaxonomy,   // taxonomy name
				'field' => $categorySlug,           // term_id, slug or name
				'terms' =>  $categoryId,                  // term id, term slug or term name
			)
		),
		'page' => $page,
		'offset' => $offset
	));
	
	$posts = $newQueryWP->posts;
	$postIds = array_column($posts, 'ID');
	
	$mProduct = VTT_FeModelProduct::instance();
	$theProduct = $mProduct->getExtraPostIds($postIds);
	
	$products = array();
	foreach ($posts as $key => $value) {
		$id = $value->ID;
		$default_price = null;
		$quantity = null;
		$author_name = null;
		
		if(!empty($theProduct[$id])){
			$default_price = $theProduct[$id]->default_price;
			$quantity = $theProduct[$id]->quantity;
			$author_name = $theProduct[$id]->author_name;
		};
		
		$products[] = [
			'id' => $id,
			'title' => $value->post_title,
			'default_price' => $default_price,
			'quantity' => $quantity,
			'author_name' => $author_name
		];
	}

	$totalPage = $newQueryWP->max_num_pages;
	$pagination = Helper::frontendPagination($maxProduct, $page, $totalPage);
	set_query_var('pagination', $pagination);
?>
<div class="row">
	<?php if(count($products) > 0): ?>
	<div class="col-12">
		<div class="list-content">
			<div class="swiper-container" id="productSlide">
				<div class="swiper-pagination" id="productSlidePaging"></div>
				<div class="swiper-wrapper">
				<?php foreach ($products as $key => $value):
				if($key<$maxProduct):
					setup_postdata($value);
					$productId = $value['id'];
					$productUrl = esc_url(get_permalink($productId));
					$productTitle = esc_html($value['title']);
					$productImage = Helper::getPostAvatar($productId);
					$productQuantity = $value['quantity'];
					$productAuthor = $value['author_name'];
				?>
					<div class="swiper-slide">
						<ul class="box-gallery">
							<li class="box-image">
								<a href="<?php echo $productUrl; ?>" title="<?php echo $productTitle; ?>">
									<img class="image" src="<?php echo $productImage; ?>" alt="<?php echo $productTitle; ?>">
								</a>
								<?php if(!empty($productQuantity) || $productQuantity == 1): ?>
									<span class="tag tag-contact">Liên hệ</span>
								<?php else: ?>
									<span class="tag tag-sold">Đã bán</span>
								<?php endif; ?>
							</li>
							<li class="box-info">
								<h3 class="name lora"><?php echo $productTitle; ?></h3>
								<p class="author"><?php echo $productAuthor; ?></p>
							</li>
						</ul>
					</div>
					<?php endif; ?>
				<?php endforeach; ?>
				<?php wp_reset_postdata();?>
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>
</div>