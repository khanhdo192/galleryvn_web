<?php if (!defined('ABSPATH')) exit; ?>
<?php
	$postId = get_the_ID();
	$thePost = get_post($postId);
	//print_r($post);
	$detailTitle = esc_html($thePost->post_title);
	$detailTime = get_the_date('d.m.Y', $postId);
	$detailContent = $thePost->post_content;
?>
<div class="title-content">
	<h1 class="text lora"><?php echo $detailTitle; ?></h1>
</div>
<div class="detail-content">
	<?php echo $detailContent; ?>
</div>
