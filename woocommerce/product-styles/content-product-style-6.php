<?php
/*
     Name:Product style 6
     Slug:content-product
*/
do_action( 'woocommerce_before_shop_loop_item' );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
global $post, $product;

$units_sold   = get_post_meta( $product->get_id(), 'total_sales', true );
$availability = $product->get_stock_quantity();

if ( $availability == '' ) {
	$percent = 0;
} else {
	$total_percent = $availability + $units_sold;
	$percent       = round( ( ( $units_sold / $total_percent ) * 100 ), 0 );
}
?>
    <div class="product-inner equal-elem">
		<?php
		/**
		 * woocommerce_before_shop_loop_item hook.
		 *
		 * @hooked woocommerce_template_loop_product_link_open - 10
		 */
		do_action( 'woocommerce_before_shop_loop_item' );
		?>
        <div class="product-thumb">
			<?php
			/**
			 * woocommerce_before_shop_loop_item_title hook.
			 *
			 * @hooked woocommerce_show_product_loop_sale_flash - 10
			 * @hooked woocommerce_template_loop_product_thumbnail - 10
			 */
			do_action( 'woocommerce_before_shop_loop_item_title' );
			?>
			<?php do_action( 'smarket_function_shop_loop_item_quickview' ); ?>
            <div class="process-valiable">
                <div class="valiable-text">
                    <p class="text"><?php echo esc_html__( 'availability:', 'smarket' ) ?>
                        <span>
                        <?php if ( $availability != '' ) {
                            echo  $availability - $units_sold;
                        } else {
                            echo esc_html__( 'Unlimit', 'smarket' );
                        } ?>
                    </span>
                    </p>
                    <p class="text"><?php echo esc_html__( 'sold:', 'smarket' ) ?>
                        <span><?php echo  $units_sold; ?></span>
                    </p>
                </div>
                <span class="valiable-total total">
                <span class="process" style="width: <?php echo  $percent . '%' ?>"></span>
            </span>
            </div>
        </div>
        <div class="product-info">
			<?php
			/**
			 * woocommerce_shop_loop_item_title hook.
			 *
			 * @hooked woocommerce_template_loop_product_title - 10
			 */
			do_action( 'woocommerce_shop_loop_item_title' );

			/**
			 * woocommerce_after_shop_loop_item_title hook.
			 *
			 * @hooked woocommerce_template_loop_rating - 5
			 * @hooked woocommerce_template_loop_price - 10
			 */
			do_action( 'woocommerce_after_shop_loop_item_title' );
			?>
			<?php do_action( 'smarket_display_product_countdown_in_loop' ); ?>
            <div class="group-button">
                <div class="inner">
					<?php
					/**
					 * woocommerce_after_shop_loop_item hook.
					 *
					 * @hooked woocommerce_template_loop_product_link_close - 5
					 * @hooked woocommerce_template_loop_add_to_cart - 10
					 */
					do_action( 'woocommerce_after_shop_loop_item' );
					do_action( 'smarket_function_shop_loop_item_wishlist' );
					do_action( 'smarket_function_shop_loop_item_compare' );
					?>
                </div>
            </div>
        </div>
    </div>
<?php add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 ); ?>