<?php if (!defined('ABSPATH')) exit; ?>
<?php 
	$articleHome = ___getCategoryByIdAndPost(1,6);
	if ( $articleHome != new stdClass() ):
?>
<div class="article-home control">
	<div class="row">
		<?php foreach ($articleHome->posts as $key => $value): 
			setup_postdata($value);
			$postId = $value->ID;
			$postUrl = esc_url(get_permalink($postId));
			$postTitle = $value->post_title;
			$postTime = get_the_date('H:i d/m/Y',$postId);
			$postImage = Helper::getPostAvatar($postId);
		?>
		<div class="col-lg-6 col-md-6 col-xl-4 col-12">
			<div class="list-content">
				<div class="box-image">
					<figure class="image" style="<?php echo 'background-image: url('. $postImage .')';?>">
						<a href="<?php echo $postUrl; ?>" title="<?php echo $postTitle; ?>">
							<img src="<?php echo $postImage; ?>" alt="<?php echo $postTitle; ?>">
						</a>
					</figure>
				</div>
				<div class="box-info">
					<h3 class="name lora">
						<a href="<?php echo $postUrl; ?>"><?php echo $postTitle; ?></a>
					</h3>
					<p class="time"><?php echo $postTime; ?></p>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
	<?php wp_reset_postdata();?> 
	</div>
</div>
<?php endif; ?>