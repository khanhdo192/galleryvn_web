<?php if (!defined('ABSPATH')) exit; ?>
<aside class="aside aside-filter" id="asideFilter">
	<div class="navbar-close" id="navFilterClose">
		<button class="btn btn-close" id="btnFilterClose">
			<i class="symbol icon-close"></i>
		</button>
	</div>
	<ul class="navigation-menu" id="searchMobile">
		<?php foreach($dataFilter as $key => $value): ?>
		<?php if($key<3): ?>
		<li class="menu-item">
			<?php 
				$attributeInput = ' data-input=f'. $key;
			?>
			<select class="form-control filter-item"<?php echo $attributeInput; ?>>
				<option><?php echo $value['name']?></option>
				<?php foreach($value['children'] as $keyitem => $item): ?>
				<?php 
					$attributeId = ' data-id='. $item['id'];
				?>
				<option value="<?php echo $item['name']; ?>"<?php echo $attributeId; ?>><?php echo $item['name']; ?></option>
				<?php endforeach; ?>
			</select>
		</li>
		<?php endif; ?>
		<?php endforeach; ?>
		<li class="menu-item">
			<?php 
				if (Helper::pluginActive('vtt-plugin/vtt-plugin.php')){
					get_template_part('layouts/element/tag-filter');
				};
			?>
			<form id="filterMobile" role="search" method="get" action="<?php echo site_url('/'); ?>" hidden>
				<input type="text" name="type" value="filter" hidden />
				<input type="text" name="s" value="" hidden />
				<input type="text" name="f0" value="" hidden />
				<input type="text" name="f1" value="" hidden />
				<input type="text" name="f2" value="" hidden />
			</form>
			<div class="line"></div>
			<div class="search-input">
				<form id="formSearch" role="search" method="get" action="<?php echo site_url('/'); ?>">
					<input type="text" name="type" value="product" hidden />
					<div class="input-group">
						<input type="text" class="form-control" maxlength="60" name="s" placeholder="Nội dung tìm kiếm" value="<?php echo get_search_query(); ?>"/>
					</div>
				</form>
			</div>
			<?php 
				if (Helper::pluginActive('vtt-plugin/vtt-plugin.php')){
					get_template_part('layouts/element/tag-search');
				};
			?>
		</li>
		<li class="menu-item">
			<div class="form-group text-center">
				<button type="button" class="btn btn-search" id="btnSearch">Tìm kiếm</button>
			</div>
		</li>
	</ul>
</aside>