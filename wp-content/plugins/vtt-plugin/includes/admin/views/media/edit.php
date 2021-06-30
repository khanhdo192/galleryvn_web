<?php
/**
 * Admin View: Page - Contact
 */
if (!defined('ABSPATH')) {
	exit;
}

$id = $detail->id;
$name = $detail->name;
$type = $detail->type;
$url = $detail->url;
$link = $detail->link;
$url = $helper->urlUpload($url);
$description = $detail->description;
$createdAt = $detail->created_at;
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
						<input type="text" class="input" name="id" value="<?php echo $id; ?>" hidden>
						<input type="text" class="input" id="name" name="name" value="<?php echo $name ?>" placeholder="Nhập tên ảnh..." maxlength="100">
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
						<input type="text" class="input" id="link" name="link" value="<?php echo $link; ?>" placeholder="Nhập tên ảnh..." maxlength="255">
					</div>
				</div>
				<div class="vtt-col-12">
					<div class="form-group">
						<label class="label">Hình ảnh / video *</label>
						<button type="button" class="vtt-btn btn-outline-secondary" id="btnAddImage">Chọn hình ảnh</button>
						<div class="group-images" id="groupImage">
							<figure class="image" id="image">
								<input type="text" name="image" value="<?php echo $url; ?>" hidden />
								<img class="img" id="img" src="<?php echo $url; ?>"/>
								<a href="javascript:void(0);" class="vtt-btn btn-outline-danger btn-text" id="btnRemoveImage">Xóa</a>
							</figure>
						</div>
					</div>
				</div>
				<div class="vtt-col-12">
					<div class="form-button border-top">
						<a class="vtt-btn btn-danger" id="btnEsc" href="<?php echo self::urlBack(); ?>">Hủy bỏ</a>
						<button type="button" class="vtt-btn btn-primary" id="btnEdit">Hoàn thành</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<script>
jQuery(function() {
	jQuery('select[name="type"] option[value="<?php echo $type; ?>"]').prop('selected', true);
});
</script>