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
		<div class="vtt-title">
			<h1 class="text">Thông tin sản phẩm</h1>
		</div>
		<form class="vtt-form vtt-form-medium" autocomplete="off">
			<div class="vtt-row row-fx">
				<div class="vtt-col-12">
					<div class="form-group">
						<label for="name" class="label">Tên ảnh *</label>
						<input type="text" class="input" id="name" name="name" placeholder="Nhập tên ảnh..." maxlength="100">
					</div>
				</div>
				<div class="vtt-col-12">
					<div class="form-group">
						<label for="type" class="label">Chọn vị trí *</label>
						<select id="type" class="select" name="type">
							<option value="">Vui lòng chọn...</option>
							<option value="slide">Ảnh Slide</option>
						</select>
					</div>
				</div>
				<div class="vtt-col-12">
					<div class="form-group">
						<label for="link" class="label">Đường dẫn</label>
						<input type="text" class="input" id="link" name="link" placeholder="Nhập tên ảnh..." maxlength="250">
					</div>
				</div>
				<div class="vtt-col-12">
					<div class="form-group">
						<label class="label">Hình ảnh / video *</label>
						<button type="button" class="vtt-btn btn-outline-secondary" id="btnAddImage">Chọn hình ảnh</button>
						<div class="group-images" id="groupImage">
							<figure class="image" id="image">
								<input type="text" name="image" value="" hidden />
								<img class="img" id="img" src="<?php echo $helper->assetImage('placeholder.png'); ?>"/>
								<a href="javascript:void(0);" class="vtt-btn btn-outline-danger btn-text" id="btnRemoveImage">Xóa</a>
							</figure>
						</div>
					</div>
				</div>
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