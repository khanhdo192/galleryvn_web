<?php if (!defined('ABSPATH')) exit; ?>
<?php
	$mMedia = get_query_var('mMedia');
	$slides = $mMedia->getSlide(3);
	// print_r($slides);
 ?>
<?php if(count($slides) > 0 && !empty($slides)): ?>
<div class="slideshow-home control">
	<div class="swiper-container" id="slideShow">
		<div class="swiper-wrapper">
			<?php foreach($slides as $key => $value):
				$slideUrl = $value->url;
				$slideName = $value->name;
				$slideLink = $value->link;
				if(empty($slideLink)){
					$slideLink = 'javascript:void(0);';
				};
			?>
			<div class="swiper-slide">
				<figure class="slideshow-image">
					<a href="<?php echo $slideLink; ?>" title="<?php echo $slideName; ?>">
						<img src="<?php echo Helper::imageUrlUpload($slideUrl); ?>" alt="<?php echo $slideName; ?>">
					</a>
				</figure>
				<ul class="slideshow-info">
					<li class="name">
						<h3 class="lora text"><?php echo $slideName; ?></h3>
					</li>
				</ul>
			</div>
			<?php endforeach; ?>
		</div>
		<div class="swiper-pagination" id="slideShowPaging"></div>
	</div>
</div>
<?php endif; ?>