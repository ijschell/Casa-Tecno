<?php
/**
 * The template for displaying product widget entries
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-widget-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.5.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product; ?>

<li class="item-product">
	<div class="thumb">
		<a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
			<?php echo  $product->get_image(); ?>
		</a>
	</div>
	<div class="info">
		<span class="product-title product_title"><a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>"><?php echo  $product->get_title(); ?></a></span>
		<?php if ( ! empty( $show_rating ) ) : ?>
		<?php echo  wc_get_rating_html( $product->get_average_rating() ); ?>
		<?php endif; ?>
		<span class="price">
			<?php echo  $product->get_price_html(); ?>
		</span>
	</div>
</li>
