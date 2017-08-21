<?php get_header(); ?>
<?php
/*Shop layout*/
$smarket_woo_shop_layout = smarket_option( 'woo_shop_layout', 'left' );

if ( is_product() ) {
	$smarket_woo_shop_layout = smarket_option( 'smarket_woo_single_layout', 'left' );
}

/*Main container class*/
$main_container_class   = array();
$main_container_class[] = 'main-container shop-page';
if ( $smarket_woo_shop_layout == 'full' ) {
	$main_container_class[] = 'no-sidebar';
} else {
	$main_container_class[] = $smarket_woo_shop_layout . '-slidebar';
}

/*Setting single product*/

$main_content_class   = array();
$main_content_class[] = 'main-content';
if ( $smarket_woo_shop_layout == 'full' ) {
	$main_content_class[] = 'col-sm-12';
} else {
	$main_content_class[] = 'col-content';
}

$slidebar_class   = array();
$slidebar_class[] = 'sidebar';
if ( $smarket_woo_shop_layout != 'full' ) {
	$slidebar_class[] = 'col-sidebar';
}
?>
    <div class="<?php echo esc_attr( implode( ' ', $main_container_class ) ); ?>">
		<?php do_action( 'smarket_woocommerce_breadcrumb' ); ?>
        <div class="columns container-wapper">
            <div class="row">
				<?php
				/**
				 * woocommerce_before_main_content hook
				 *
				 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
				 * @hooked woocommerce_breadcrumb - 20
				 */
				do_action( 'woocommerce_before_main_content' );
				?>
                <div class="<?php echo esc_attr( implode( ' ', $main_content_class ) ); ?>">
					<?php
					if ( !is_single() ) {
						/**
						 * @hooked smarket_shop_banners - 1
						 */
						do_action( 'smarket_before_main_content' );
					}
					?>
					<?php
					/**
					 * smarket_woocommerce_before_loop_start hook
					 *
					 * @hooked smarket_shop_top_control - 10
					 */
					do_action( 'smarket_woocommerce_before_loop_start' );
					?>
					<?php woocommerce_content(); ?>
                </div>
				<?php
				/**
				 * woocommerce_before_main_content hook
				 *
				 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
				 * @hooked woocommerce_breadcrumb - 20
				 */
				do_action( 'woocommerce_after_main_content' );
				?>
				<?php if ( $smarket_woo_shop_layout != "full" ): ?>
                    <div class="<?php echo esc_attr( implode( ' ', $slidebar_class ) ); ?>">
						<?php get_sidebar( 'shop' ); ?>
                    </div>
				<?php endif; ?>
            </div>
        </div>
    </div>
<?php get_footer(); ?>