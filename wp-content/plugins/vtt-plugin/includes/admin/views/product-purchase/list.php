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
			<table class="vtt-table table-border">
				<tbody>
					<tr>
						<th width="5%">STT</th>
						<th width="15%">Trạng thái</th>
						<th width="20%">Thông tin khách</th>
						<th width="10%">Ngày nhập</th>
						<th width="8%">Thực hiện</th>
					</tr>
					<?php if(!empty($purchases) && count($purchases) > 0): ?>
					<?php foreach ($purchases as $key => $value): ?>
					<tr>
						<td><?php echo ($key+$offset+1) ?></td>
						<td>
							<?php 
								if($value->type === 'buy'){
									echo 'Mua tác phẩm';
								}elseif($value->type === 'order'){
									echo 'Đặt họa sĩ vẽ';
								}else{
									echo 'Chưa rõ';
								}
							?>
						</td>
						<td>
							<p><b>Họ và tên: </b><span><?php echo $value->name; ?></span></p>
							<p><b>Email: </b><span><?php echo $value->email; ?></span></p>
							<p><b>Số điện thoại: </b><span><?php echo $value->phone; ?></span></p>
						</td>
						<td><?php echo $value->created_at; ?></td>
						<td>
							<a class="vtt-action action-icon color-dark" href="<?php echo self::urlView($value->id);?>">
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