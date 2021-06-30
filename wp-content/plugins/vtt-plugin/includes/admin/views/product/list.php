<?php
/**
 * Admin View: Page - Contact
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
		<div class="vtt-card">
			<div class="card-header">
				<a class="vtt-btn btn-create" href="<?php echo self::urlCreate();?>">Thêm thông tin sản phẩm</a>
			</div>
			<table class="vtt-table table-border">
				<tbody>
					<tr>
						<th width="5%">STT</th>
						<th width="20%">Sản phẩm</th>
						<th width="10%">Trạng thái</th>
						<th width="10%">Cập nhật</th>
						<th width="8%">Thực hiện</th>
					</tr>
					<?php if(!empty($products) && count($products) > 0): ?>
					<?php foreach ($products as $key => $value): ?>
					<?php
						$id = $value->id;
						$postId	= $value->post_id;
						$name = $value->post_title;
						$image = $helper->getPostAvatar($postId);
						$createdAt = $value->created_at;					
					?>
					<tr>
						<td><?php echo ($key+$offset+1) ?></td>
						<td>
							<h6 class="vtt-name"><?php echo $name; ?></h6>
							<img class="vtt-image-preview medium" src="<?php echo $image;?>"/>
						</td>
						<td><?php echo 'Đã nhập thông tin'; ?></td>
						<td><?php echo $createdAt; ?></td>
						<td>
							<a class="vtt-action action-icon color-primary" href="<?php echo self::urlEdit($id);?>">
								<i class="fa fa-pencil" aria-hidden="true"></i>
							</a>
						</td>
					</tr>
					<?php endforeach; ?>
					<?php endif; ?>
					<?php if(isset($pagination) && !empty(count($pagination))): ?>
					<tr>
						<td colspan="5">
							<ul class="vtt-pagination">
								<?php foreach ($pagination as $value): ?>
								<li class="page-item">
									<?php echo $value;?>
								</li>
								<?php endforeach; ?>
							</ul>
						</td>
					</tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>