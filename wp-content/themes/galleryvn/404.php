<?php if (!defined('ABSPATH')) exit; ?>
<?php get_header(); ?>
<main class="main">
    <?php get_sidebar(); ?>
    <section class="section">
		<div class="container-fluid">
			<div class="page-error">
				<h1 class="title lora">Trang không tồn tại</h1>
				<p class="desc lora">Rất tiếc, trang bạn tìm kiếm không tồn tại</p>
				<a class="btn btn-home" href="<?php echo esc_url(home_url('/'));?>">Về trang chủ</a>
			</div>
		</div>
    </section>
</main>
<?php get_footer(); ?>