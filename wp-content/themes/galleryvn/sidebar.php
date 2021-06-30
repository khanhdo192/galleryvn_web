<?php if (!defined('ABSPATH')) exit; ?>
<?php get_template_part('layouts/element/aside-menu'); ?>
<?php 
	if (Helper::pluginActive('vtt-plugin/vtt-plugin.php')){
		get_template_part('layouts/element/aside-filter');
	};
?>
<div class="overlay" id="overlay"></div>