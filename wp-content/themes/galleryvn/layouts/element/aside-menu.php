<?php if (!defined('ABSPATH')) exit; ?>
<aside class="aside aside-menu" id="asideMenu">
	<div class="navbar-close" id="navMenuClose">
		<button class="btn btn-close btnMenuClose">
			<i class="symbol icon-close"></i>
		</button>
	</div>
	<ul class="navigation-menu">
		<li class="menu-item">
			<a class="link lora" href="<?php echo esc_url(home_url()); ?>" title="<?php _e('Home');?>"><?php _e('Home'); ?></a>
		</li>
	<?php if(!empty(count($menuHeaderAside))): ?>
		<?php foreach ($menuHeaderAside as $key => $value): ?>
		<li class="menu-item">
			<a class="link lora" href="<?php echo $value['url'];?>"><?php echo $value['title'];?></a>
		</li>
		<?php endforeach; ?>
	<?php endif; ?>
	</ul>
	<?php if(!empty(count($menuTranslation))): ?>
	<div class="translation-menu">
		<?php foreach ($menuTranslation as $key => $value): ?>
		<div class="menu-item">
			<a class="link lora" href="<?php echo $value['url'];?>"><?php echo $value['title'];?></a>
		</div>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>
</aside>