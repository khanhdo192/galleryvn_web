<?php if (!defined('ABSPATH')) exit; ?>
<?php
	$allowSlug = array(
		'contact',
		'lien-he'
	);
?>
<?php get_header();?>
<main class="main">
	<?php if(!empty(is_page($allowSlug))): ?>
	<article class="article article-contact">
		<div class="container-fluid">
			<?php get_template_part('layouts/post/contact'); ?>
		</div>
	</article>
	<?php else: ?>
		<article class="article article-detail">
			<div class="container-fluid">
				<?php get_template_part('layouts/post/detail'); ?>
			</div>
		</article>
	<?php endif; ?>
</main>
<?php get_footer(); ?>