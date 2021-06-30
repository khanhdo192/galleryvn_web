<?php if (!defined('ABSPATH')) exit; ?>
<?php
	$postId = get_the_ID();
	$thePost = get_post($postId);
	$detailTitle = esc_html($thePost->post_title);
	$detailImage = Helper::getPostAvatar($postId);
	$theProduct = $mProduct->detail($postId);
?>
<div class="row">
	<div class="col-12">
		<div class="title-content">
			<h1 class="text lora">Mua tác phẩm</h1>
		</div>
	</div>
	<div class="col-lg-7 col-md-12 col-12">
        <div class="order-content">
			<div class="content-price">
				<h4 class="text lora">Giá bán:</h4>
				<?php if(!empty($theProduct->default_price)):?>
					<p class="price lora formatPrice"><?php echo $theProduct->default_price; ?> VNĐ</p>
				<?php else: ?>
					<p class="price lora">Đang cập nhật...</p>
				<?php endif;?>
			</div>
            <div class="content-image">
                <figure class="image">
                    <img src="<?php echo $detailImage; ?>" alt="<?php echo $detailTitle; ?>">
                </figure>
            </div>
        </div>
	</div>
	<div class="col-lg-5 col-md-12 col-12">
		<form class="contact-form" id="formBuyOrder" autocomplete="off">
			<div class="form-group">
				<h4 class="form-title lora">Xin hãy để lại thông tin của bạn!</h4>
				<input type="text" name="type" class="sr-only" value="<?php echo $_GET['action']; ?>" disabled />
				<input type="number" name="postId" class="sr-only" value="<?php echo $postId; ?>" disabled />
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
				<?php if(!empty($theProduct->default_price)):?>
					<button type="button" class="btn btn-contact" id="btnBuyOrder">Gửi</button>
				<?php else: ?>
					<button type="button" class="btn btn-contact btn-disabled">Gửi</button>
				<?php endif;?>
			</div>
		</form>
	</div>
</div>