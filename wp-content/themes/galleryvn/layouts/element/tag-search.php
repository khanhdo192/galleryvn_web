<?php if (!defined('ABSPATH')) exit; ?>
<?php 
	$search = isset($_GET['s']) ? $_GET['s'] : '';
?>
<div class="cloud-tag">
    <?php if(!empty($search)): ?>
    <?php 
        $searchValue = $_GET['s'];
    ?>
    <div class="tag-item tagItem">
        <p class="tag-name"><?php echo $searchValue;?></p>
        <button type="button" class="btn btn-closetag closeTagSearch"><i class="fa fa-times"></i></button>
    </div>
    <?php endif; ?>
</div>