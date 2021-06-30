<?php if (!defined('ABSPATH')) exit; ?>
<?php
	$postId = get_the_ID();
	$thePost = get_post($postId);
	$detailTitle = esc_html($thePost->post_title);
	$detailImage = Helper::getPostAvatar($postId);
	$urlBuyOrder = esc_url(get_permalink($postId));

	$theProduct = $mProduct->detail($postId);
	$productImage = $mProductImage->detail($postId);
	$detailFilter = $mProductFilter->detail($postId);
	$filter = $mFilter->getFilterParentId();
	$mergeArray = array_merge($detailFilter,$filter);
	$productFilter = $mFilter->buildFilter($mergeArray,0);
?>
<div class="col-xl-7 col-lg-12 col-12">
	<div class="detail-thumbnail">
		<div class="thumbnail-list">
			<div class="swiper-container" id="thumbnailList">
				<div class="swiper-wrapper">
					<div class="swiper-slide">
						<figure class="image">
							<img src="<?php echo $detailImage; ?>" alt="<?php echo $detailTitle; ?>">
						</figure>
					</div>
					<?php foreach ($productImage as $key => $value):?>
					<div class="swiper-slide">
						<figure class="image">
							<img src="<?php echo Helper::imageUrlUpload($value['url']); ?>" alt="<?php echo $detailTitle; ?>">
						</figure>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
		<div class="thumbnail-show">
			<div class="swiper-container" id="thumbnailShow">
				<div class="swiper-wrapper">
					<div class="swiper-slide swiper-slide-show">
						<figure class="image">
							<img src="<?php echo $detailImage; ?>" alt="<?php echo $detailTitle; ?>">
						</figure>
					</div>
					<?php foreach ($productImage as $key => $value):?>
					<div class="swiper-slide swiper-slide-show">
						<figure class="image">
							<img src="<?php echo Helper::imageUrlUpload($value['url']); ?>" alt="<?php echo $detailTitle; ?>">
						</figure>
					</div>
					<?php endforeach; ?>
				</div>
				<div class="swiper-pagination" id="detailImagePagination"></div>
			</div>
		</div>
	</div>
</div>
<div class="col-xl-5 col-lg-12 col-12">
	<div class="detail-content">
		<div class="gallery-name">
			<h1 class="text lora"><?php echo $detailTitle; ?></h1>
		</div>
		<div class="line"><hr></div>
		<div class="media media-author">
			<div class="media-header">
				<p class="title lora">Tác giả</p>
			</div>
			<div class="media-body">
				<?php if(!empty($theProduct->author_name)):?>
				<h2 class="name"><?php echo $theProduct->author_name; ?></h2>
				<?php endif;?>
				<?php if(!empty($theProduct->author_story)):?>
				<p class="story"><?php echo $theProduct->author_story; ?></p>
				<?php endif;?>
			</div>
		</div>
		<div class="line"><hr></div>
		<div class="media">
			<div class="media-header">
				<p class="title lora">Tác phẩm</p>
			</div>
			<div class="media-body">
				<?php if(!empty($theProduct)):?>
				<ul class="box-tag">
				<?php if(!empty($productFilter) || count($productFilter)):?>
					<?php foreach($productFilter as $key => $value):?>
					<?php if(!empty($value['children'])):?>
					<li class="item">
						<p class="info"><?php echo $value['name']; ?></p>
						<p class="desc"><?php echo $value['children'][0]['name']; ?></p>
					</li>
					<?php endif;?>
					<?php endforeach;?>
				<?php endif;?>
					<?php if(!empty($theProduct->size)):?>
					<li class="item">
						<p class="info">Kích thước</p>
						<p class="desc"><?php echo $theProduct->size; ?></p>
					</li>
					<?php endif;?>
				</ul>
				<?php endif;?>
			</div>
		</div>
		<div class="line"><hr></div>
		<div class="media media-price">
			<div class="media-header">
				<p class="title lora">Giá bán</p>
			</div>
			<div class="media-body">
			<?php if(!empty($theProduct->default_price)):?>
				<p class="price lora formatPrice"><?php echo $theProduct->default_price; ?> VNĐ</p>
			<?php else: ?>
				<p class="price lora">Đang cập nhật...</p>
			<?php endif;?>
			</div>
		</div>
		<div class="button-buy-order">
			<?php if(!empty($theProduct->default_price) && $theProduct->quantity == 1):?>
				<a href="<?php echo $urlBuyOrder;?>?action=buy" class="btn btn-buy">Mua</a>
			<?php else: ?>
				<a href="javascript:void(0);" class="btn btn-buy btn-disabled">Mua</a>
			<?php endif;?>
				<a href="<?php echo $urlBuyOrder;?>?action=order" class="btn btn-order">Đặt họa sĩ vẽ riêng</a>
		</div>
	</div>
</div>