<?php if (!defined('ABSPATH')) exit; ?>
		<footer class="footer">
			<div class="container-fluid main-witdh">
				<?php if(is_home()):?>
					<div class="control-button">
						<button type="button" class="btn btn-slide btnEventHover" id="btnPrev" disabled>
							<i class="symbol chevron-up2x white"></i>
						</button>
						<button type="button" class="btn btn-slide btnEventHover" id="btnNext">
							<i class="symbol chevron-down2x white"></i>
						</button>
					</div>
				</div>
				<?php else: ?>
					<?php $pagination = get_query_var('pagination');?>
					<?php if(isset($pagination) && !empty($pagination) && count($pagination) > 1): ?>
					<div class="col-12">
						<ul class="pagination pagination-next-prev">
						<?php foreach ($pagination as $value): ?>
							<li class="page-item">
								<p class="page-link">
									<?php echo $value;?>
								</p>
							</li>
						<?php endforeach; ?>
						</ul>
					</div>
					<?php endif; ?>
				<?php endif; ?>
			</div>
			<div class="container-fluid line">
				<div class="footer-content">
					<div class="tooltip-content" id="licenseContent">
						<p class="tip lora">Chứng nhận giám định và bảo hộ tác quyền</p>
					</div>
					<div class="tooltip-content" id="bankcardContent">
						<p class="tip lora">Thanh toán quốc tế thuận tiện</p>
					</div>
					<div class="tooltip-content" id="deliveryContent">
						<p class="tip lora">Miễn phí vận chuyển trong nước</p>
					</div>
					<ul class="service-list">
						<li class="service-item">
							<i class="symbol license" id="licenseTip"></i>
						</li>
						<li class="service-item">
							<i class="symbol bankcard" id="bankcardTip"></i>
						</li>
						<li class="service-item">
							<i class="symbol delivery" id="deliveryTip"></i>
						</li>
					</ul>
					<p class="text lora">Logos used on the website are trademarks of the respective companies / owners. <span class="text lora span">© Vietnam Gallery 2020 - 2021</span></p>
				</div>
			</div>
		</footer>
		<?php wp_footer(); ?>
	</body>
</html>