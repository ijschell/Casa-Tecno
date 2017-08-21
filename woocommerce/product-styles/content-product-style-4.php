<?php
/*
	 Name:Product style 4
	 Slug:content-product
*/
do_action( 'woocommerce_before_shop_loop_item' );
global $post,$product;
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
        <a class="thumb-link" href="<?php the_permalink(); ?>">
			<?php $image_thumb = smarket_resize_image( get_post_thumbnail_id( $product->get_id() ), null, 130, 130, false, true, false ); ?>
            <img width="<?php echo esc_attr( $image_thumb[ 'width' ] ); ?>"
                 height="<?php echo esc_attr( $image_thumb[ 'height' ] ); ?>"
                 class="attachment-post-thumbnail wp-post-image"
                 src="<?php echo esc_attr( $image_thumb[ 'url' ] ) ?>" alt=""/>
        </a>
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
    </div>
</div>