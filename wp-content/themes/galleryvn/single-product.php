<?php if (!defined('ABSPATH')) exit; ?>
<?php get_header(); ?>
<main class="main">
	<?php if(isset($_GET['action'])): ?>
		<?php if($_GET['action'] == 'buy'): ?>
			<section class="section-product product-buy">
				<div class="container-fluid">
					<?php get_template_part('layouts/product/buy'); ?>
				</div>
			</section>
		<?php endif; ?> 
		<?php if($_GET['action'] == 'order'): ?>
			<section class="section-product product-order">
				<div class="container-fluid">
					<?php get_template_part('layouts/product/order'); ?>
				</div>
			</section>
		<?php endif; ?>
	<?php else:?>
	<section class="section-product product-detail">
		<div class="container-fluid">
			<div class="row">
				<?php get_template_part('layouts/product/detail'); ?>
			</div>
		</div>
	</section>
	<?php endif; ?>
</main>
<?php get_footer(); ?>