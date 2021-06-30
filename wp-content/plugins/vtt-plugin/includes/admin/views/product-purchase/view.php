<?php
/**
 * Admin View: Page - Contact
 */
if (!defined('ABSPATH')) {
	exit;
}

if(empty($detail)){
	return;
}
?>
<div class="vtt-reboot">
	<div class="vtt-container">
		<div class="vtt-title">
			<h1 class="text">Thông tin sản phẩm</h1>
		</div>
		<div class="vtt-row">
			<div class="vtt-col-12">
				<table class="vtt-table table-border page-detail">
					<tbody>
						<tr>
							<th scope="row">Trạng thái</th>
							<td>
								<?php 
									if($detail->type === 'buy'){
										echo 'Mua tác phẩm';
									}elseif($detail->type === 'order'){
										echo 'Đặt họa sĩ vẽ';
									}else{
										echo 'Chưa rõ';
									}
								?>
							</td>
						</tr>
						<?php if($detail->type === 'buy'): ?>
						<?php $name = $mPost->detailName($detail->post_id); ?>
						<tr>
							<th scope="row">Sản phẩm</th>
							<td><?php echo $name->post_title; ?></td>
						</tr>
						<?php endif; ?>
						<tr>
							<th scope="row">Họ và tên</th>
							<td><?php echo $detail->name; ?></td>
						</tr>
						<tr>
							<th scope="row">Email</th>
							<td><?php echo $detail->email; ?></td>
						</tr>
						<tr>
							<th scope="row">Số điện thoại</th>
							<td><?php echo $detail->phone; ?></td>
						</tr>
						<tr>
							<th scope="row">Ghi chú</th>
							<td><?php echo $detail->messenger; ?></td>
						</tr>
						<tr>
							<th scope="row">Thời gian</th>
							<td><?php echo $detail->created_at; ?></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="vtt-col-12">
				<div class="vtt-block-btn-center">
					<a class="button button-secondary vtt-btn-esc" href="<?php echo self::urlBack(); ?>">Hủy bỏ</a>
				</div>
			</div>
		</div>
	</div>
</div>