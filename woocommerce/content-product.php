<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;
// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}


// Custom columns
$smarket_woo_bg_items = smarket_option('smarket_woo_bg_items',15);
$smarket_woo_lg_items = smarket_option('smarket_woo_lg_items',4);
$smarket_woo_md_items = smarket_option('smarket_woo_md_items',4);
$smarket_woo_sm_items = smarket_option('smarket_woo_sm_items',6);
$smarket_woo_xs_items = smarket_option('smarket_woo_xs_items',6);
$smarket_woo_ts_items = smarket_option('smarket_woo_ts_items',12);

$smarket_woo_product_style = smarket_option('smarket_woo_product_style',1);

$shop_display_mode = smarket_option('woo_shop_list_style','grid');

if( isset($_SESSION['shop_display_mode'])){
	$shop_display_mode = $_SESSION['shop_display_mode'];
}

$classes[] = 'product-item';
if( $shop_display_mode == "grid"){
	$classes[] = 'col-bg-'.$smarket_woo_bg_items;
	$classes[] = 'col-lg-'.$smarket_woo_lg_items;
    $classes[] = 'col-md-'.$smarket_woo_md_items;
    $classes[] = 'col-sm-'.$smarket_woo_sm_items;
    $classes[] = 'col-xs-'.$smarket_woo_xs_items;
    $classes[] = 'col-ts-'.$smarket_woo_ts_items;

}else{
	$classes[] = 'list col-sm-12';
}

$template_style = 'style-'.$smarket_woo_product_style;

$classes[] = 'style-'.$smarket_woo_product_style;
?>

<li <?php post_class( $classes ); ?>>
	<?php if( $shop_display_mode == "grid"):?>
	<?php wc_get_template_part('product-styles/content-product', $template_style );?>
	<?php else:?>
	<?php wc_get_template_part('content-product', 'list' );?>
	<?php endif;?>
</li>
