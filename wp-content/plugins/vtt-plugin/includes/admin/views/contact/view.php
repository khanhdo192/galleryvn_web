<?php
/**
 * Admin View: Page - Contact
 */
if (!defined('ABSPATH')) {
	exit;
}
$name = $detail->name;
$email = $detail->email;
$phone = $detail->phone;
$messenger = $detail->messenger;
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
						<label for="name" class="label">Họ và tên</label>
						<input type="text" class="input" id="name" name="name" value="<?php echo $name ?>" placeholder="Nhập tên ảnh..." readonly>
					</div>
				</div>
				<div class="vtt-col-12">
					<div class="form-group">
						<label for="email" class="label">Email</label>
						<input type="text" class="input" id="email" name="email" value="<?php echo $email ?>" placeholder="Nhập email..." readonly>
					</div>
				</div>
				<div class="vtt-col-12">
					<div class="form-group">
						<label for="phone" class="label">Số điện thoại</label>
						<input type="text" class="input" id="phone" name="phone" value="<?php echo $phone ?>" placeholder="Nhập số điện thoại..." readonly>
					</div>
				</div>
				<div class="vtt-col-12">
					<div class="form-group">
						<label for="messenger" class="label">Lời nhắn</label>
						<textarea class="textarea" id="messenger" name="messenger" placeholder="Nhập lời nhắn..." readonly><?php echo $messenger ?></textarea>
					</div>
				</div>
				<div class="vtt-col-12">
					<div class="form-group">
						<label for="createdAt" class="label">Ngày đăng ký</label>
						<input type="text" class="input" id="createdAt" name="createdAt" value="<?php echo $createdAt ?>" placeholder="Chọn ngày đăng ký..." readonly>
					</div>
				</div>
				<div class="vtt-col-12">
					<div class="form-button border-top">
						<a class="vtt-btn btn-primary" id="btnEsc" href="<?php echo self::urlBack(); ?>">Quay lại</a>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>