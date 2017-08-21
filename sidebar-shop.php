<?php
/**
 * The sidebar containing the main widget area
 *
 */
?>
<?php
$smarket_woo_shop_used_sidebar = smarket_option( 'smarket_woo_shop_used_sidebar', 'shop-widget-area' );
if( is_product() ){
	$smarket_woo_shop_used_sidebar = smarket_option('smarket_woo_single_used_sidebar','shop-widget-area');
}

?>

<?php if ( is_active_sidebar( $smarket_woo_shop_used_sidebar ) ) : ?>
<div id="widget-area" class="widget-area shop-sidebar">
	<?php dynamic_sidebar( $smarket_woo_shop_used_sidebar ); ?>
</div><!-- .widget-area -->
<?php endif; ?>
