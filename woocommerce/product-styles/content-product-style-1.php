<?php
/*
     Name:Product style 1
     Slug:content-product
*/
do_action( 'woocommerce_before_shop_loop_item' );
remove_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_rating',5);
global $post;

$shop_display_mode = smarket_option('woo_shop_list_style','grid');

if( isset($_SESSION['shop_display_mode'])){
	$shop_display_mode = $_SESSION['shop_display_mode'];
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
        <?php do_action('smarket_function_shop_loop_item_quickview');?>
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
        <div class="info-hover">
            <?php if ( $post->post_excerpt ) : ?>
                <div class="product-item-des">
					<?php
                    if ( is_shop() && $shop_display_mode == 'list' ) {
						echo get_the_excerpt();
                    } else {
						echo wp_trim_words(get_the_excerpt(),15,'...');
                    }
                    ?>
                </div>
            <?php endif; ?>
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
                    do_action('smarket_function_shop_loop_item_wishlist');
                    do_action('smarket_function_shop_loop_item_compare');
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php add_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_rating',5); ?>