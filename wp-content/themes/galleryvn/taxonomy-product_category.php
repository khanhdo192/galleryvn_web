<?php if (!defined('ABSPATH')) exit; ?>
<?php get_header();?>
<main class="main">
	<section class="section-product product-list">
		<div class="container-fluid">
			<?php get_template_part('layouts/product/list'); ?>
		</div>
	</section>
</main>
<?php get_footer(); ?>