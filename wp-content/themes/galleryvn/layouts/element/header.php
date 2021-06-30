<?php if (!defined('ABSPATH')) exit; ?>
<?php 
	$SiteTitle = get_query_var('SiteTitle');
	$SiteSlogan = get_query_var('SiteSlogan');
	$TitleSlogan = sprintf('%s - %s', $SiteTitle, $SiteSlogan);
	$customLogo = wp_get_attachment_image_src(get_theme_mod('custom_logo'), 'full');
?>
<header class="header" id="navHeader">
	<div class="container-fluid menu-web">
		<div class="nav-logo-translation">
			<?php if (!empty($customLogo)): ?>
			<div class="navbar-logo">
				<a class="logo" href="<?php echo esc_url(home_url('/'));?>" title="<?php echo $TitleSlogan; ?>">
					<img src="<?php echo esc_url($customLogo[0]); ?>" alt="<?php echo $TitleSlogan; ?>"/>
				</a>
			</div>
			<?php endif; ?>
			<?php if(!empty(count($menuTranslation))): ?>
			<div class="navbar-translation">
				<?php foreach ($menuTranslation as $key => $value): ?>
				<div class="translate-item">
					<a class="link lora" href="<?php echo $value['url'];?>"><?php echo $value['title'];?></a>
				</div>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
		</div>
		<nav class="navbar navbar-expand">
			<div class="navbar-menu">
				<button class="btn btn-menu btnMenu">
					<span></span>
					<span></span>
					<span></span>
				</button>
			</div>
			<?php 
				if (Helper::pluginActive('vtt-plugin/vtt-plugin.php')){
					get_template_part('layouts/element/filter-search');
				};
			?>
		</nav>
	</div>
	<div class="container-fluid menu-mobile">
		<div class="row menu-row">
			<div class="col-3">
				<div class="navbar-menu">
					<button class="btn btn-menu btnMenu">
						<span></span>
						<span></span>
						<span></span>
					</button>
				</div>
			</div>
			<div class="col-6">
				<?php if (!empty($customLogo)): ?>
				<div class="navbar-logo">
					<a class="logo" href="<?php echo esc_url(home_url('/'));?>" title="<?php echo $TitleSlogan; ?>">
						<img src="<?php echo esc_url($customLogo[0]); ?>" alt="<?php echo $TitleSlogan; ?>"/>
					</a>
				</div>
				<?php endif; ?>
			</div>
			<div class="col-3">
				<div class="navbar-nav-button">
					<button type="button" class="btn btn-search btnOpen">
						<i class="symbol icon-search"></i>
					</button>
				</div>
			</div>
		</div>
	</div>
</header>