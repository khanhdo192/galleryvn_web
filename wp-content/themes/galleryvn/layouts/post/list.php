<?php if (!defined('ABSPATH')) exit; ?>
<?php
	$maxPost = 6;
	$categoryId = get_query_var('cat');
	$theCategory = get_category( $categoryId );
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	$offset = ($maxPost * $page) - $maxPost;
	
	$newQueryWP = new WP_Query(array(
		'post_type' => 'post',
		'posts_per_page' => $maxPost,
		'post_status' => 'publish',
		'cat' => $categoryId,
		'page' => $page,
		'offset' => $offset
	));
	
	$totalPage = $newQueryWP->max_num_pages;
	$pagination = Helper::frontendPagination($maxPost, $page, $totalPage);
	set_query_var('pagination', $pagination);
?>
<div class="row">
	<?php foreach ($newQueryWP->posts as $key => $value): 
		if($key<$maxPost):
			setup_postdata($value);
			$postId = $value->ID;
			$postUrl = esc_url(get_permalink($postId));
			$postTitle = esc_html($value->post_title);
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
	<?php endif; ?>
	<?php endforeach; ?>
	<?php wp_reset_postdata();?>
</div>