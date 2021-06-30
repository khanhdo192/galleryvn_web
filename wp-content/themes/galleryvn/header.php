<?php if (!defined('ABSPATH')) exit; ?>
<?php
	Controller::instance();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<?php get_template_part('layouts/element/meta'); ?>
		<?php wp_head(); ?>
	</head>
	<body class="body">
		<?php get_template_part('layouts/element/header'); ?>
		<?php get_sidebar(); ?>
