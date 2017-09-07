<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage smarket
 * @since smarket 1.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/fonts/fonts.css">
	<link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/css/slick.css">
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/css/custom-footer.css">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> data-url="<?php echo get_site_url();?>/">
	<?php get_template_part('template_parts/popup','content');?>
    <div class="body-overlay"></div>
	<div id="box-mobile-menu" class="box-mobile-menu full-height">
		<div class="box-inner">
			<a href="#" class="close-menu"><span class="icon fa fa-times"></span></a>
		</div>
	</div>
    <?php smarket_get_header()?>
    <div class="wapper"></div>
