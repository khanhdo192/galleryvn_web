<?php if (!defined('ABSPATH')) exit; ?>
<?php 
	$type = isset($_GET['type']) ? $_GET['type'] : '';
?>
<?php get_header();?>
<main class="main">
	<section class="section-product product-list product-search-filter">
		<div class="container-fluid">
			<?php 
				if($type === 'product'){
					get_template_part('layouts/product/search'); 
				}elseif($type === 'filter'){
					get_template_part('layouts/product/filter'); 
				};
			?>
		</div>
	</section>
</main>
<?php get_footer(); ?>