<?php if (!defined('ABSPATH')) exit; ?>
<?php if(!empty(count($homeProduct))): ?>
<div class="product-home control">
	<div class="swiper-container" id="productSlide">
		<div class="swiper-pagination" id="productSlidePaging"></div>
		<div class="swiper-wrapper">
		<?php foreach ($homeProduct as $key => $value):
		if($key<6):
			$productId = $value['trueId'];
			$productImage = Helper::getPostAvatar($productId);
		?>
			<div class="swiper-slide">
				<ul class="box-gallery">
					<li class="box-image">
						<a href="<?php echo $value['url'];?>" title="<?php echo $value['title'];?>">
							<img class="image" src="<?php echo $productImage; ?>" alt="<?php echo $value['title'];?>">
						</a>
						<?php if(!empty($value['quantity']) || $value['quantity'] == 1): ?>
							<span class="tag tag-contact">Liên hệ</span>
						<?php else: ?>
							<span class="tag tag-sold">Đã bán</span>
						<?php endif; ?>
					</li>
					<li class="box-info">
						<h3 class="name lora"><?php echo $value['title'];?></h3>
						<p class="author"><?php echo $value['author_name'];?></p>
					</li>
				</ul>
			</div>
		<?php endif; ?>
		<?php endforeach; ?>
		</div>
	</div>
</div>
<?php endif; ?>
