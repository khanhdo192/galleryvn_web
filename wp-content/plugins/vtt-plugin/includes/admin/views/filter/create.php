<?php
/**
 * Admin View: Page - Reports
 */
if (!defined('ABSPATH')) {
	exit;
}
?>
<div class="vtt-reboot">
	<div class="vtt-container">
		<h1 class="vtt-title">Thêm thông tin lọc</h1>
		<form class="vtt-form vtt-form-large">
			<div class="vtt-row row-fx">
				<div class="vtt-col-12 col-fx">
					<div class="form-group">
						<label for="parentName" class="label">Tên mục thông tin lọc</label>
						<input type="text" class="input" id="parentName" name="parentName" placeholder="Nhập tên mục thông tin lọc...">
					</div>
				</div>
				<div class="vtt-col-12 col-fx">
					<div class="form-button border-bottom">
						<button type="button" class="vtt-btn btn-outline-primary" id="btnAdd" data-id="0">Thêm thông tin lọc</button>
					</div>
				</div>
			</div>
			<div class="vtt-row" id="target"></div>
			<div class="vtt-row">
				<div class="vtt-col-12">
					<div class="form-button border-top">
						<a class="vtt-btn btn-danger" id="btnEsc" href="<?php echo self::urlBack(); ?>">Hủy bỏ</a>
						<button type="button" class="vtt-btn btn-primary" id="btnCreate">Hoàn thành</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>