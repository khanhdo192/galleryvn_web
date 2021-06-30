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
		<form class="vtt-form">
			<div class="vtt-row">
				<div class="vtt-col-lg-6 vtt-col-12">
					<div class="vtt-row row-fx">
						<div class="vtt-col-12 col-fx">
							<div class="form-group">
								<label for="postId" class="label">Chọn sản phẩm *</label>
								<select id="postId" class="select" name="postId">
									<option value="0">Vui lòng chọn...</option>
								<?php if(!empty(count($posts))): ?>
									<?php foreach ($posts as $key => $value): ?>
									<option value="<?php echo $value->ID; ?>"><?php echo $value->post_title; ?></option>
									<?php endforeach; ?>
								<?php endif; ?>
								</select>
							</div>
						</div>
						<div class="vtt-col-12 col-fx">
							<div class="form-group">
								<label for="defaultPrice" class="label">Giá bán *</label>
								<input type="number" onKeyPress="if(this.value.length > 11) return false;" class="input" id="defaultPrice" name="defaultPrice" placeholder="Nhập giá bán..." />
							</div>
						</div>
						<div class="vtt-col-12 col-fx">
							<div class="form-group">
								<label for="size" class="label">Kích thước *</label>
								<input type="text" class="input" id="size" name="size" placeholder="Nhập kích thước..." maxlength="100"/>
							</div>
						</div>
						<div class="vtt-col-12 col-fx">
							<div class="form-group">
								<label for="authorName" class="label">Tác giả *</label>
								<input type="text" class="input" id="authorName" name="authorName" placeholder="Nhập tác giả..." maxlength="100"/>
							</div>
						</div>
						<div class="vtt-col-12 col-fx">
							<div class="form-group">
								<label for="authorStory" class="label">Tiểu sử</label>
								<textarea class="textarea" id="authorStory" name="authorStory" placeholder="Nhập tiểu sử..." maxlength="250"></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="vtt-col-lg-6 vtt-col-12">
					<div class="vtt-row row-fx">
					<?php if(!empty(count($filters))): ?>
						<?php $tagArray = ['style', 'theme', 'material']; ?>
						<?php foreach ($filters as $key => $value): ?>
						<?php 
							$tagLabel = $value['name'];
							$tagIdName = $tagArray[$key];
						?>
						<div class="vtt-col-12 col-fx">
							<div class="form-group">
								<label for="<?php echo $tagIdName; ?>" class="label"><?php echo $tagLabel; ?></label>
								<select id="<?php echo $tagIdName; ?>" class="select" name="<?php echo $tagIdName; ?>">
									<option value="0">Vui lòng chọn...</option>
								<?php if(!empty(count($value['children']))): ?>
									<?php foreach ($value['children'] as $k => $v): ?>
									<option value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
									<?php endforeach; ?>
								<?php endif; ?>
								</select>
							</div>
						</div>
						<?php endforeach; ?>
					<?php endif; ?>
						<div class="vtt-col-12 col-fx">
							<div class="form-group">
								<label class="label">Hình ảnh</label>
								<button type="button" class="vtt-btn btn-outline-secondary" id="btnAddImage">Chọn hình ảnh</button>
								<div class="group-images" id="groupImage"></div>
							</div>
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