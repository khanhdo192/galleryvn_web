<?php if (!defined('ABSPATH')) exit; ?>
<div class="row">
	<div class="col-12">
		<div class="title-content">
			<h1 class="text lora">Đặt họa sĩ vẽ riêng</h1>
		</div>
		<form class="contact-form" id="formBuyOrder" autocomplete="off">
			<div class="form-group">
				<h4 class="form-title lora">Xin hãy để lại thông tin của bạn!</h4>
				<input type="text" name="type" class="sr-only" value="order" disabled />
			</div>
			<div class="form-group">
				<label class="form-label" for="name">Tên đầy đủ</label>
				<input type="text" class="form-control" name="name" id="name" placeholder="Nhập tên đầy đủ" maxlength="30"/>
			</div>
			<div class="form-group">
				<label class="form-label" for="email">Email</label>
				<input type="text" class="form-control" name="email" id="email" placeholder="Nhập email" maxlength="40"/>
			</div>
			<div class="form-group">
				<label class="form-label" for="phone">Số điện thoại</label>
				<input type="number" class="form-control" name="phone" id="phone" placeholder="Nhập số điện thoại" onKeyPress="if(this.value.length > 11) return false;" />
			</div>
			<div class="form-group">
			  <label class="form-label" for="messenger">Lời nhắn</label>
			  <textarea class="form-control" name="messenger" id="messenger" placeholder="Nhập lời nhắn" maxlength="200"></textarea>
			</div>
			<div class="form-group text-center">
				<p class="notice-result"></p>
				<button type="button" class="btn btn-contact" id="btnBuyOrder">Gửi</button>
			</div>
		</form>
	</div>
</div>