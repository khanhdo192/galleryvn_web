<?php if (!defined('ABSPATH')) exit; ?>
<div class="control-home">
<?php 
	if (Helper::pluginActive('vtt-plugin/vtt-plugin.php')){
		get_template_part('layouts/home/slideshow');
		get_template_part('layouts/home/product');
	};
?>	
	<?php get_template_part('layouts/home/article'); ?>
</div>