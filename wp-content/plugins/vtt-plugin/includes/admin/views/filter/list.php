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
				<a class="vtt-btn btn-create" href="<?php echo self::urlCreate();?>">Thêm thông tin lọc</a>
			</div>
			<table class="vtt-table table-border">
				<tbody>
					<tr>
						<th width="5%">STT</th>
						<th width="20%">Tên mục lọc</th>
						<th width="8%">Tổng thông tin lọc</th>
						<th width="8%">Cập nhật</th>
						<th width="8%">Thực hiện</th>
					</tr>
					<?php if(!empty($filters) && count($filters) > 0): ?>
					<?php foreach ($filters as $key => $value): ?>
					<tr>
						<td><?php echo ($key+$offset+1) ?></td>
						<td><?php echo $value->name; ?></td>
						<td><?php echo $value->count; ?></td>
						<td><?php echo $value->created_at; ?></td>
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