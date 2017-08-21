<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

global $post, $product;
$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
$full_size_image   = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
$image_title       = get_post_field( 'post_excerpt', $post_thumbnail_id );
$attachment_ids    = $product->get_gallery_image_ids();
$placeholder       = has_post_thumbnail() ? 'with-images' : 'without-images';
$wrapper_classes   = apply_filters( 'woocommerce_single_product_image_gallery_classes', array(
		'woocommerce-product-gallery',
		'woocommerce-product-gallery--' . $placeholder,
		'woocommerce-product-gallery--columns-' . absint( $columns ),
		'images',
	)
);

$style_single_product = smarket_option( 'style_single_product', 'style-standard-horizon' );
$product_video        = get_post_meta( get_the_ID(), 'smarket_product_video', '#' );
$view_video           = '';
if ( $product_video ) {
	$view_video = '<a href="' . esc_url( $product_video ) . '" class="html5lightbox play-video"><i class="fa fa-play"></i>' . esc_html__( 'view video', 'smarket' ) . '</a>';
}
?>

<?php if ( $style_single_product == 'style-with-sticky' ) : ?>
	<?php echo  $view_video; ?>
    <div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>"
         data-columns="<?php echo esc_attr( $columns ); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;">
        <figure class="woocommerce-gallery-carousel woocommerce-product-gallery__wrapper">
			<?php
			$attributes = array(
				'title'                   => $image_title,
				'data-src'                => $full_size_image[ 0 ],
				'data-large_image'        => $full_size_image[ 0 ],
				'data-large_image_width'  => $full_size_image[ 1 ],
				'data-large_image_height' => $full_size_image[ 2 ],
			);

			if ( has_post_thumbnail() ) {
				$html = '<div data-thumb="' . get_the_post_thumbnail_url( $post->ID, 'shop_thumbnail' ) . '" class="woocommerce-product-gallery__image"><a href="' . esc_url( $full_size_image[ 0 ] ) . '">';
				$html .= get_the_post_thumbnail( $post->ID, 'shop_single', $attributes );
				$html .= '</a>';
				$html .= '</div>';
			} else {
				$html = '<div class="woocommerce-product-gallery__image--placeholder">';
				$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'smarket' ) );
				$html .= '</div>';
			}

			echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, get_post_thumbnail_id( $post->ID ) );

			if ( $attachment_ids && has_post_thumbnail() ) {
				foreach ( $attachment_ids as $attachment_id ) {
					$full_size_image = wp_get_attachment_image_src( $attachment_id, 'full' );
					$thumbnail       = wp_get_attachment_image_src( $attachment_id, 'shop_thumbnail' );
					$image_title     = get_post_field( 'post_excerpt', $attachment_id );

					$attributes = array(
						'title'                   => $image_title,
						'data-src'                => $full_size_image[ 0 ],
						'data-large_image'        => $full_size_image[ 0 ],
						'data-large_image_width'  => $full_size_image[ 1 ],
						'data-large_image_height' => $full_size_image[ 2 ],
					);

					$html = '<div data-thumb="' . esc_url( $thumbnail[ 0 ] ) . '" class="woocommerce-product-gallery__image"><a href="' . esc_url( $full_size_image[ 0 ] ) . '">';
					$html .= wp_get_attachment_image( $attachment_id, 'shop_single', false, $attributes );
					$html .= '</a>';
					$html .= '</div>';

					echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_id );
				}
			}
			?>
        </figure>
    </div>
<?php elseif ( $style_single_product == 'style-gallery-thumbnail' ) : ?>
	<?php echo  $view_video; ?>
    <div class="woocommerce-gallery-carousel <?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>"
         data-columns="<?php echo esc_attr( $columns ); ?>">
        <a href="<?php echo esc_url( $full_size_image[ 0 ] ) ?>" class="html5lightbox" data-group="mygroup">
            <img class="attachment-shop_single size-shop_single wp-post-image"
                 src="<?php echo esc_url( $full_size_image[ 0 ] ) ?>" alt="feature-image">
        </a>
		<?php
		$i = 0;
		if ( $attachment_ids && has_post_thumbnail() ) {
			foreach ( $attachment_ids as $attachment_id ) {
				$i++;
				if ( $i < 4 ) {
					$thumbnail = wp_get_attachment_image_src( $attachment_id, 'full' ); ?>
                    <a href="<?php echo esc_url( $thumbnail[ 0 ] ); ?>" class="html5lightbox" data-group="mygroup">
                        <img class="attachment-shop_single size-shop_single wp-post-image"
                             src="<?php echo esc_url( $thumbnail[ 0 ] ); ?>" alt="gallery-image">
                    </a>
					<?php
				}
			}
		}
		?>
    </div>
<?php else: ?>
    <div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>"
         data-columns="<?php echo esc_attr( $columns ); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;">
        <figure class="woocommerce-gallery-carousel woocommerce-product-gallery__wrapper">
			<?php
			$attributes = array(
				'title'                   => $image_title,
				'data-src'                => $full_size_image[ 0 ],
				'data-large_image'        => $full_size_image[ 0 ],
				'data-large_image_width'  => $full_size_image[ 1 ],
				'data-large_image_height' => $full_size_image[ 2 ],
			);

			if ( has_post_thumbnail() ) {
				$html = '<div data-thumb="' . get_the_post_thumbnail_url( $post->ID, 'shop_thumbnail' ) . '" class="woocommerce-product-gallery__image"><a href="' . esc_url( $full_size_image[ 0 ] ) . '">';
				$html .= get_the_post_thumbnail( $post->ID, 'shop_single', $attributes );
				$html .= '</a>';
				$html .= $view_video;
				$html .= '</div>';
			} else {
				$html = '<div class="woocommerce-product-gallery__image--placeholder">';
				$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'smarket' ) );
				$html .= $view_video;
				$html .= '</div>';
			}

			echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, get_post_thumbnail_id( $post->ID ) );

			if ( $attachment_ids && has_post_thumbnail() ) {
				foreach ( $attachment_ids as $attachment_id ) {
					$full_size_image = wp_get_attachment_image_src( $attachment_id, 'full' );
					$thumbnail       = wp_get_attachment_image_src( $attachment_id, 'shop_thumbnail' );
					$image_title     = get_post_field( 'post_excerpt', $attachment_id );

					$attributes = array(
						'title'                   => $image_title,
						'data-src'                => $full_size_image[ 0 ],
						'data-large_image'        => $full_size_image[ 0 ],
						'data-large_image_width'  => $full_size_image[ 1 ],
						'data-large_image_height' => $full_size_image[ 2 ],
					);

					$html = '<div data-thumb="' . esc_url( $thumbnail[ 0 ] ) . '" class="woocommerce-product-gallery__image"><a href="' . esc_url( $full_size_image[ 0 ] ) . '">';
					$html .= wp_get_attachment_image( $attachment_id, 'shop_single', false, $attributes );
					$html .= '</a>';
					$html .= $view_video;
					$html .= '</div>';

					echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_id );
				}
			}
			?>
        </figure>
    </div>
<?php endif; ?>
