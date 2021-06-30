<?php if (!defined('ABSPATH')) exit; ?>
<?php
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	$filter0 = isset($_GET['f0']) ? $_GET['f0'] : '';
	$filter1 = isset($_GET['f1']) ? $_GET['f1'] : '';
	$filter2 = isset($_GET['f2']) ? $_GET['f2'] : '';
	
	$filterIds = array_filter(
		array(
			$filter0,
			$filter1,
			$filter2,
		)
	);
	
	$limit = 6;
	$offset = ($limit * $page) - $limit;
	$mPost = get_query_var('mPost');
	$mProductFilter = get_query_var('mProductFilter');
	
	$postIds = $mProductFilter->getPostIdInFilterId($filterIds);
	$postIds = array_column($postIds, 'post_id');
	
	$products =  $mPost->getFilter($postIds, $limit, $offset);
	$total = $mPost->countFilter($postIds);
	$total = ceil($total / $limit);
	$pagination = Helper::frontendPagination($limit, $page, $total);
	set_query_var('pagination', $pagination);
?>
<div class="row">
	<div class="col-12">
		<div class="filter-content">
		<?php 
			if (Helper::pluginActive('vtt-plugin/vtt-plugin.php')){
				get_template_part('layouts/element/tag-filter');
			};
		?>
		</div>
	</div>
	<?php if(count($products) > 0 && !empty($products)): ?>
	<div class="col-12">
		<div class="list-content">
			<div class="swiper-container" id="productSlide">
				<div class="swiper-pagination" id="productSlidePaging"></div>
				<div class="swiper-wrapper">
				<?php foreach ($products as $key => $value): 
				if($key<$limit):
					setup_postdata($value);
					$productId = $value->ID;
					$productUrl = esc_url(get_permalink($productId));
					$productTitle = esc_html($value->post_title);
					$productImage = Helper::getPostAvatar($productId);
					$productQuantity = $value->quantity;
					$productAuthor = $value->author_name;
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
	<?php else: ?>
	<div class="col-12">
		<div class="title-content">
			<h1 class="text lora">Không có thông tin lọc</h1>
		</div>
	</div>
	<?php endif; ?>
</div>