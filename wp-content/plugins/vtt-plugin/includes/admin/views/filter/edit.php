<?php
/**
 * Admin View: Page - Reports
 */
if (!defined('ABSPATH')) {
	exit;
}
//print_r($detail);
?>
<div class="vtt-reboot">
	<div class="vtt-container">
		<h1 class="vtt-title">Thêm thông tin lọc</h1>
		<?php if(!empty($detail[0])): ?>
		<form class="vtt-form vtt-form-large">
			<div class="vtt-row row-fx">
				<div class="vtt-col-12 col-fx">
					<div class="form-group">
						<label for="parentName" class="label">Tên mục thông tin lọc</label>
						<input type="text" class="input" name="parentId" value="<?php echo $detail[0]['id']; ?>" hidden>
						<input type="text" class="input" id="parentName" name="parentName" value="<?php echo $detail[0]['name']; ?>" placeholder="Nhập tên mục thông tin lọc...">
					</div>
				</div>
				<div class="vtt-col-12 col-fx">
					<div class="form-button border-bottom">
						<button type="button" class="vtt-btn btn-outline-primary" id="btnAdd" data-id="<?php echo $detail[0]['count']; ?>">Thêm thông tin lọc</button>
					</div>
				</div>
			</div>
			<div class="vtt-row" id="target">
				<?php foreach ($detail[0]['children'] as $key => $value): ?>
				<?php 
					$num = $key+1;
					$tagId = 'childName'.$num;
				?>
				<div class="vtt-col-lg-6 vtt-col-12 col-fx appendBlock">
					<div class="form-group">
						<label for="<?php echo $tagId; ?>" class="label">Tên thông tin lọc <?php echo $num; ?></label>
						<input type="text" class="input" name="childId" value="<?php echo $value['id']; ?>" hidden>
						<div class="inline-group">
							<input type="text" class="input" id="<?php echo $tagId; ?>" name="childName" value="<?php echo $value['name']; ?>" placeholder="Nhập tên thông tin lọc <?php echo $num; ?>...">
							<div class="group-append">
								<button type="button" class="vtt-btn btn-outline-danger btnRemove">Xóa</button>
							</div>
						</div>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
			<div class="vtt-row">
				<div class="vtt-col-12">
					<div class="form-button border-top">
						<a class="vtt-btn btn-danger" id="btnEsc" href="<?php echo self::urlBack(); ?>">Hủy bỏ</a>
					</div>
				</div>
			</div>
		</form>
		<?php endif; ?>
	</div>
</div>