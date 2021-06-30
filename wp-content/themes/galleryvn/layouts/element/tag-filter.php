<?php if (!defined('ABSPATH')) exit; ?>
<?php 
	$filter0 = isset($_GET['f0']) ? $_GET['f0'] : '';
	$filter1 = isset($_GET['f1']) ? $_GET['f1'] : '';
	$filter2 = isset($_GET['f2']) ? $_GET['f2'] : '';
?>
<div class="cloud-tag">
    <?php if(!empty($filter0)): ?>
    <?php 
        $attribute = ' data-input=f0';
        $arrayfilter = array();
        foreach($dataFilter[0]['children'] as $value){
            $arrayfilter[$value['id']] = $value['name'];
        }
    ?>
    <div class="tag-item tagItem"<?php echo $attribute; ?>>
        <p class="tag-name"><?php echo $arrayfilter[$filter0];?></p>
        <button type="button" class="btn btn-closetag closeTag"><i class="fa fa-times"></i></button>
    </div>
    <?php endif; ?>
    <?php if(!empty($filter1)): ?>
    <?php 
        $attribute = ' data-input=f1';
        $arrayfilter = array();
        foreach($dataFilter[1]['children'] as $value){
            $arrayfilter[$value['id']] = $value['name'];
        }
    ?>
    <div class="tag-item tagItem"<?php echo $attribute; ?>>
        <p class="tag-name"><?php echo $arrayfilter[$filter1];?></p>
        <button type="button" class="btn btn-closetag closeTag"><i class="fa fa-times"></i></button>
    </div>
    <?php endif; ?>
    <?php if(!empty($filter2)): ?>
    <?php 
        $attribute = ' data-input=f2';
        $arrayfilter = array();
        foreach($dataFilter[2]['children'] as $value){
            $arrayfilter[$value['id']] = $value['name'];
        }
    ?>
    <div class="tag-item tagItem"<?php echo $attribute; ?>>
        <p class="tag-name"><?php echo $arrayfilter[$filter2];?></p>
        <button type="button" class="btn btn-closetag closeTag"><i class="fa fa-times"></i></button>
    </div>
    <?php endif; ?>
</div>