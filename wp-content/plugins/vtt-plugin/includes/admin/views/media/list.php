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
				<a class="vtt-btn btn-create" href="<?php echo self::urlCreate();?>">Thêm hình ảnh & video</a>
			</div>
			<table class="vtt-table table-border">
				<tbody>
					<tr>
						<th width="5%">STT</th>
						<th width="15%">Tên hình ảnh</th>
						<th width="10%">Hình ảnh</th>
						<th width="10%">Vị trí</th>
						<th width="10%">Ngày nhập</th>
						<th width="8%">Thực hiện</th>
					</tr>
					<?php if(!empty($media) && count($media) > 0): ?>
					<?php foreach ($media as $key => $value): ?>
					<?php
						$id = $value->id;
						$type = $value->type;
						$name = $value->name;
						$url = $value->url;
						$createdAt = $value->created_at;
					?>
					<tr>
						<td><?php echo ($key+$offset+1) ?></td>
						<td><?php echo $name; ?></td>
						<td><img class="vtt-image-preview medium" src="<?php echo $helper->urlUpload($url);?>"/></td>
						<td><?php 
							if($type == 'slide'){
								echo __('Khu vực ảnh slide');
							}else if($type == 'service'){
								echo __('Khu vực ảnh service');
							}else{
								echo __('Chưa xác định');
							}; ?>
						</td>
						<td><?php echo $createdAt; ?></td>
						<td>
							<a class="vtt-action action-icon color-primary" href="<?php echo self::urlEdit($value->id);?>">
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