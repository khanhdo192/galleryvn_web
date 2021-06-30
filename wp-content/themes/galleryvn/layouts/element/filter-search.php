<?php if (!defined('ABSPATH')) exit; ?>
<?php 
	$show = ' ';
	$disable = ' ';
	if(is_search()){
		$show = ' show';
		$disable = ' disabled';
	}
	$dataFilter = get_query_var('dataFilter');
?>
<div class="navbar-collapse navbar-search">
	<div class="navbar-nav navbar-nav-search<?php echo $show; ?>" style="display: none;">
		<div class="search-value" id="searchValue">
			<?php foreach($dataFilter as $key => $value): ?>
			<?php if($key<3): ?>
			<?php 
				$attributeInput = ' data-input=f'. $key;
			?>
			<div class="item-value">
				<button type="button" class="btn dropdown-toggle" id="navbarDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"<?php echo $attributeInput; ?>>
					<span class="text"><?php echo $value['name']?></span>
					<i class="symbol chevron-down"></i>
				</button>
				<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
					<?php foreach($value['children'] as $keyitem => $item): ?>
					<?php 
						$attributeId = ' data-id='. $item['id'];
						$attributeName = ' data-name=fn'. $keyitem;
					?>
					<li class="dropdown-item"<?php echo $attributeId; ?>>
						<p class="item-name"<?php echo $attributeName; ?>><?php echo $item['name']; ?></p>
					</li>
					<?php endforeach; ?>
				</ul>
			</div>
			<?php endif; ?>
			<?php endforeach; ?>
			<form id="filter" role="search" method="get" action="<?php echo site_url('/'); ?>" hidden>
				<input type="text" name="type" value="filter" hidden />
				<input type="text" name="s" value="" hidden />
				<input type="text" name="f0" value="" hidden />
				<input type="text" name="f1" value="" hidden />
				<input type="text" name="f2" value="" hidden />
			</form>
		</div>
		<div class="search-line"></div>
		<div class="search-input">
			<form id="search" role="search" method="get" action="<?php echo site_url('/'); ?>" autocomplete="off">
				<input type="text" name="type" value="product" hidden />
				<div class="input-group">
					<input type="text" class="form-control" id="inputSearch" maxlength="60" name="s" placeholder="Nội dung tìm kiếm" value="<?php echo get_search_query(); ?>"/>
				</div>
				<button type="submit" hidden></button>
			</form>
		</div>
	</div>
	<div class="navbar-nav-button">
		<button type="button" class="btn btn-search btnOpen<?php echo $show; ?>" <?php echo $disable; ?>>
			<i class="symbol icon-search"></i>
		</button>
	</div>
</div>
