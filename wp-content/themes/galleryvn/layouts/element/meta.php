<?php if (!defined('ABSPATH')) exit; ?>
<?php
	$MetaSiteTitle = get_query_var('MetaSiteTitle');
	$MetaDescription = get_query_var('MetaDescription');
	$MetaImage = get_query_var('MetaImage');
?>
<title><?php echo $MetaSiteTitle; ?></title>
<meta charset="UTF-8">
<meta name="title" content="<?php echo $MetaSiteTitle; ?>">
<meta name="description" content="<?php echo $MetaDescription; ?>">
<meta name="copyright" content="Developed and Design Website by HaiNM">
<meta name="generator" content="Developed and Design Website by HaiNM">
<meta name="author" content="Developed and Design Website by HaiNM">
<meta name="robots" content="index, follow, max-snippet:-1, max-video-preview:-1, max-image-preview:large">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no">
<meta name="distribution" content="Global">
<meta name="resource-type" content="Document">
<meta name="revisit-after" content="1 days">

<meta http-equiv="content-language" content="vi">
<meta http-equiv="x-ua-compatible" content="IE=edge,chrome=1">

<meta property="og:type" content="website">
<meta property="og:locale" content="vi_VN">
<meta property="og:site_name" content="<?php echo $_SERVER['HTTP_HOST'];?>">
<meta property="og:title" content="<?php echo $MetaSiteTitle; ?>">
<meta property="og:image" content="<?php echo $MetaImage;?>">
<meta property="og:description" content="<?php echo $MetaDescription; ?>">
<meta property="og:url" content="<?php echo (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";?>">

<meta name="twitter:title" content="<?php echo $MetaSiteTitle; ?>">
<meta name="twitter:description" content="<?php echo $MetaDescription; ?>">
<meta name="twitter:image" content="<?php echo $MetaImage;?>">
