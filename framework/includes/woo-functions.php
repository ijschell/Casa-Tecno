<?php
/*Remove woocommerce_template_loop_product_link_open */
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

/*Custom product thumb*/
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'smarket_template_loop_product_thumbnail', 10 );

/*Custom product name*/
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title' );
add_action( 'woocommerce_shop_loop_item_title', 'smarket_template_loop_product_title', 10 );

/*Custom product per page*/
add_filter( 'loop_shop_per_page', 'smarket_loop_shop_per_page', 20 );
add_filter( 'woof_products_query', 'smarket_woof_products_query', 20 );

/*Custom flash icon*/
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'smarket_group_flash', 5 );

/*Custom shop banner*/
add_action( 'smarket_before_main_content', 'smarket_shop_banners', 1 );

/*Custom shop top control*/
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
add_action( 'woocommerce_before_shop_loop', 'smarket_shop_top_control', 1 );
add_action( 'woocommerce_after_shop_loop', 'smarket_shop_bottom_control', 1 );

add_action( 'smarket_display_product_countdown_in_loop', 'smarket_display_product_countdown_in_loop', 1 );

/*CUSTOM CART PAGE*/
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display', 10, 1 );
add_action( 'woocommerce_after_cart', 'woocommerce_cross_sell_display', 10, 1 );
/* SINGLE PRODUCT */

remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
add_action( 'woocommerce_single_product_summary', 'get_product_stock', 10 );

/*Custom placeholder*/
add_filter( 'woocommerce_placeholder_img_src', 'kutetheme_ovi_custom_woocommerce_placeholder_img_src' );

remove_action( 'yith_wcqv_product_summary', 'woocommerce_template_single_meta', 30 );

/* WC_Vendors */
if ( class_exists( 'WC_Vendors' ) && class_exists( 'WCV_Vendor_Shop' ) ) {
	// Add sold by to product loop before add to cart
	if ( WC_Vendors::$pv_options->get_option( 'sold_by' ) ) {
		remove_action( 'woocommerce_after_shop_loop_item', array( 'WCV_Vendor_Shop', 'template_loop_sold_by' ), 9 );
		add_action( 'woocommerce_shop_loop_item_title', array( 'WCV_Vendor_Shop', 'template_loop_sold_by' ), 1 );
	}
}


add_action( 'smarket_woocommerce_breadcrumb', 'smarket_woocommerce_breadcrumb', 1 );
/* CUSTOM BREADCRUMB */
if ( !function_exists( 'smarket_woocommerce_breadcrumb' ) ) {
	function smarket_woocommerce_breadcrumb()
	{
		$args = array(
			'delimiter'   => '',
			'wrap_before' => '<nav class="woocommerce-breadcrumb breadcrumbs-wapper"><div class="container-wapper"><div class="breadcrumb">',
			'wrap_after'  => '</div></div></nav>',
			'before'      => '',
			'after'       => '',
		);
		woocommerce_breadcrumb( $args );
	}
}

if ( !function_exists( 'get_product_stock' ) ) {
	function get_product_stock()
	{
		global $product;
		if ( $product->is_in_stock() ) {
			echo '<div class="block-stock">';
			echo '<span class="title">' . esc_html__( 'availability: ', 'smarket' ) . '</span>';
			echo '<span class="stock">' . esc_html__( 'in stock', 'smarket' ) . '</span>';
			echo '</div>';
		} else {
			echo '<div class="block-stock">';
			echo '<span class="title">' . esc_html__( 'availability: ', 'smarket' ) . '</span>';
			echo '<span class="stock">' . esc_html__( 'out stock', 'smarket' ) . '</span>';
			echo '</div>';
		}
	}
}
/**
 * Function remove style css of Woocommerce
 *
 * @since smarket 1.0
 * @author ReaApple
 **/
add_filter( 'woocommerce_enqueue_styles', 'smarket_dequeue_styles' );
function smarket_dequeue_styles( $enqueue_styles )
{
	unset( $enqueue_styles[ 'woocommerce-general' ] );    // Remove the gloss
	unset( $enqueue_styles[ 'woocommerce-layout' ] );        // Remove the layout
	unset( $enqueue_styles[ 'woocommerce-smallscreen' ] );    // Remove the smallscreen optimisation

	return $enqueue_styles;

}

if ( !function_exists( 'smarket_template_loop_product_thumbnail' ) ) {

	function smarket_template_loop_product_thumbnail()
	{
		global $product;
		$thumb_inner_class = array( 'thumb-inner' );

		$smarket_enable_lazy = smarket_option( 'smarket_enable_lazy', '1' );
		$kt_using_two_image  = smarket_option( 'woo_style_hover', '1' );

		$kt_disable_using_two_image_mobile = 'yes';
		// GET SIZE IMAGE SETTING
		$w    = 400;
		$h    = 400;
		$crop = true;
		$size = wc_get_image_size( 'shop_catalog' );
		if ( $size ) {
			$w = $size[ 'width' ];
			$h = $size[ 'height' ];
			if ( !$size[ 'crop' ] ) {
				$crop = false;
			}
		}
		$w = apply_filters( 'smarket_shop_pruduct_thumb_width', $w );
		$h = apply_filters( 'smarket_shop_pruduct_thumb_height', $h );

		$url_img = get_template_directory_uri() . '/images/1x1.jpg';

		$back_image = '';
		$lazy_class = '';

		if ( $smarket_enable_lazy == '1' ) {
			$lazy_class = 'lazy owl-lazy';
		}
		if ( $kt_using_two_image == "1" ) {

			$attachment_ids = $product->get_gallery_image_ids();
			if ( wp_is_mobile() && $kt_disable_using_two_image_mobile == "yes" ) {
				$attachment_ids = false;
			}
			if ( $attachment_ids ) {
				$image_back_thumb = smarket_resize_image( $attachment_ids[ 0 ], null, $w, $h, $crop, true, false );
				if ( $smarket_enable_lazy == '0' ) {
					$url_img = $image_back_thumb[ 'url' ];
				}
				$back_image          = '<img width="' . $image_back_thumb[ 'width' ] . '" height="' . $image_back_thumb[ 'height' ] . '" class="attachment-product-thumbnail ' . $lazy_class . '" src="' . esc_url( $url_img ) . '" data-original="' . $image_back_thumb[ 'url' ] . '" data-src="' . $image_back_thumb[ 'url' ] . '" alt="" />';
				$thumb_inner_class[] = 'hover-default';
			} else {
				$thumb_inner_class[] = 'hover-style1';
			}
		} else {
			$thumb_inner_class[] = 'hover-style1';
		}
		ob_start();
		?>
        <div class="<?php echo esc_attr( implode( ' ', $thumb_inner_class ) ); ?>">
            <a class="thumb-link" href="<?php the_permalink(); ?>">
				<?php if ( $back_image ): ?>
                    <span class="back-image"><?php echo force_balance_tags( $back_image ); ?></span>
				<?php endif; ?>
				<?php
				$image_thumb = smarket_resize_image( get_post_thumbnail_id(
					$product->get_id()
				), null, $w, $h, $crop, true, false
				);
				if ( $smarket_enable_lazy == '0' ) {
					$url_img = $image_thumb[ 'url' ];
				}
				?>
                <img width="<?php echo esc_attr( $image_thumb[ 'width' ] ); ?>"
                     height="<?php echo esc_attr( $image_thumb[ 'height' ] ); ?>"
                     class="attachment-post-thumbnail wp-post-image <?php echo esc_attr( $lazy_class ); ?>"
                     src="<?php echo esc_url( $url_img ); ?>"
                     data-original="<?php echo esc_attr( $image_thumb[ 'url' ] ) ?>"
                     data-src="<?php echo esc_attr( $image_thumb[ 'url' ] ) ?>" alt=""/>
            </a>
        </div>

		<?php
		echo ob_get_clean();
	}
}


if ( !function_exists( 'smarket_template_loop_product_title' ) ) {
	function smarket_template_loop_product_title()
	{
		$title_class = array( 'product-name product_title' );

		$smarket_short_product_name = smarket_option( 'smarket_short_product_name', 1 );
		if ( $smarket_short_product_name == 1 ) {
			$title_class[] = 'short';
		}
		?>
        <h3 class="<?php echo esc_attr( implode( ' ', $title_class ) ); ?>">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
		<?php
	}
}

if ( !function_exists( 'smarket_group_flash' ) ) {
	function smarket_group_flash()
	{
		global $product;
		?>
        <div class="flash">
			<?php
			woocommerce_show_product_loop_sale_flash();
			smarket_show_product_loop_new_flash();
			?>
        </div>
		<?php
	}
}
/*New flash*/

if ( !function_exists( 'smarket_show_product_loop_new_flash' ) ) {
	/**
	 * Get the sale flash for the loop.
	 *
	 * @subpackage    Loop
	 */
	function smarket_show_product_loop_new_flash()
	{
		wc_get_template( 'loop/new-flash.php' );
	}
}

if ( !function_exists( 'smarket_shop_top_control' ) ) {
	function smarket_shop_top_control()
	{
		get_template_part( 'template_parts/shop-top', 'control' );
	}
}

if ( !function_exists( 'smarket_shop_bottom_control' ) ) {
	function smarket_shop_bottom_control()
	{
		get_template_part( 'template_parts/shop-bottom', 'control' );
	}
}

if ( !function_exists( 'smarket_loop_shop_per_page' ) ) {
	function smarket_loop_shop_per_page()
	{
		$smarket_woo_products_perpage = smarket_option( 'woo_products_perpage', '12' );
		if ( isset( $_SESSION[ 'smarket_woo_products_perpage' ] ) ) {
			$smarket_woo_products_perpage = $_SESSION[ 'smarket_woo_products_perpage' ];
		}

		return $smarket_woo_products_perpage;
	}
}
/* SET VIEW MORE */
if ( isset( $_POST[ "shop_display_mode" ] ) ) {
	session_start();
	$_SESSION[ 'shop_display_mode' ] = $_POST[ "shop_display_mode" ];
}
/*Custom shop view more*/
if ( !function_exists( 'smarket_shop_view_more' ) ) {
	function smarket_shop_view_more()
	{

		$shop_display_mode = smarket_option( 'woo_shop_list_style', 'grid' );
		if ( isset( $_SESSION[ 'shop_display_mode' ] ) ) {
			$shop_display_mode = $_SESSION[ 'shop_display_mode' ];
		}
		?>
        <p class="title-control"><?php echo esc_html__( 'view as:', 'smarket' ) ?></p>
        <div class="grid-view-mode">
            <a data-mode="grid"
               class="modes-mode mode-grid display-mode <?php if ( $shop_display_mode == "grid" ): ?>active<?php endif; ?>"
               href="javascript:void(0)">
                <span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span>
            </a>
            <a data-mode="list"
               class="modes-mode mode-list display-mode <?php if ( $shop_display_mode == "list" ): ?>active<?php endif; ?>"
               href="javascript:void(0)">
                <span></span><span></span><span></span><span></span><span></span><span></span>
            </a>
        </div>
		<?php
	}
}
/* SET PRODUCT PER PAGE */
if ( isset( $_POST[ "smarket_woo_products_perpage" ] ) ) {
	session_start();
	$_SESSION[ 'smarket_woo_products_perpage' ] = $_POST[ "smarket_woo_products_perpage" ];
}
if ( !function_exists( 'smarket_shop_post_perpage' ) ) {
	function smarket_shop_post_perpage()
	{
		$perpage = smarket_option( 'woo_products_perpage', '12' );
		if ( isset( $_SESSION[ 'smarket_woo_products_perpage' ] ) ) {
			$perpage = $_SESSION[ 'smarket_woo_products_perpage' ];
		}
		?>
        <span class="title-control"><?php echo esc_html__( 'Ver:', 'smarket' ) ?></span>
				<!-- <span class="title-control">Ver</span> -->
        <select name="perpage" class="option-perpage">
            <option value="4" <?php if ( $perpage == 4 ) {
				echo 'selected';
			} ?>>4
            </option>
            <option value="5" <?php if ( $perpage == 5 ) {
				echo 'selected';
			} ?>>5
            </option>
            <option value="6" <?php if ( $perpage == 6 ) {
				echo 'selected';
			} ?>>6
            </option>
            <option value="7" <?php if ( $perpage == 7 ) {
				echo 'selected';
			} ?>>7
            </option>
            <option value="8" <?php if ( $perpage == 8 ) {
				echo 'selected';
			} ?>>8
            </option>
            <option value="9" <?php if ( $perpage == 9 ) {
				echo 'selected';
			} ?>>9
            </option>
            <option value="10" <?php if ( $perpage == 10 ) {
				echo 'selected';
			} ?>>10
            </option>
            <option value="11" <?php if ( $perpage == 11 ) {
				echo 'selected';
			} ?>>11
            </option>
            <option value="12" <?php if ( $perpage == 12 ) {
				echo 'selected';
			} ?>>12
            </option>
            <option value="13" <?php if ( $perpage == 13 ) {
				echo 'selected';
			} ?>>13
            </option>
            <option value="14" <?php if ( $perpage == 14 ) {
				echo 'selected';
			} ?>>14
            </option>
            <option value="15" <?php if ( $perpage == 15 ) {
				echo 'selected';
			} ?>>15
            </option>
            <option value="16" <?php if ( $perpage == 16 ) {
				echo 'selected';
			} ?>>16
            </option>
        </select>
		<?php
	}
}

function smarket_woo_hide_page_title()
{
	return false;
}

function smarket_woocommerce_breadcrumbs()
{
	return array(
		'delimiter'   => '',
		'wrap_before' => '<div class="woocommerce-breadcrumb">',
		'wrap_after'  => '</div>',
		'before'      => '',
		'after'       => '',
		'home'        => _x( 'Home', 'breadcrumb', 'smarket' ),
	);
}

if ( !function_exists( 'smarket_product_short_descript' ) ) {
	function smarket_product_short_descript()
	{
		global $post;
		$shop_display_mode = smarket_option( 'smarket_shop_display_mode', 'grid' );
		if ( isset( $_SESSION[ 'shop_display_mode' ] ) ) {
			$shop_display_mode = $_SESSION[ 'shop_display_mode' ];
		}
		if ( is_shop() || is_product_category() || is_product_tag() ) {
			if ( !$post->post_excerpt ) return;
			if ( $shop_display_mode == "grid" ) return;
			?>
            <div class="product-item-des">
				<?php the_excerpt(); ?>
            </div>
			<?php
		}
	}
}
add_filter( 'woocommerce_sale_flash', 'smarket_custom_sale_flash' );

if ( !function_exists( 'smarket_custom_sale_flash' ) ) {
	function smarket_custom_sale_flash( $text )
	{
		$percent = smarket_get_percent_discount();
		if ( $percent != '' ) {
			return '<span class="onsale">' . $percent . '</span>';
		} else {
			return '';
		}

	}
}

function kutetheme_ovi_custom_woocommerce_placeholder_img_src( $src )
{
	$size = wc_get_image_size( 'shop_single' );
	$src  = 'https://placehold.it/' . $size[ 'width' ] . 'x' . $size[ 'height' ];

	return $src;
}

if ( !function_exists( 'smarket_get_percent_discount' ) ) {
	function smarket_get_percent_discount()
	{
		global $product;
		$percent = '';
		if ( $product->is_on_sale() ) {
			if ( $product->is_type( 'variable' ) ) {
				$available_variations = $product->get_available_variations();
				$maximumper           = 0;
				$minimumper           = 0;
				$percentage           = 0;

				for ( $i = 0; $i < count( $available_variations ); ++$i ) {
					$variation_id = $available_variations[ $i ][ 'variation_id' ];

					$variable_product1 = new WC_Product_Variation( $variation_id );
					$regular_price     = $variable_product1->get_regular_price();
					$sales_price       = $variable_product1->get_sale_price();
					if ( $regular_price > 0 && $sales_price > 0 ) {
						$percentage = round( ( ( ( $regular_price - $sales_price ) / $regular_price ) * 100 ), 0 );
					}

					if ( $minimumper == 0 ) {
						$minimumper = $percentage;
					}
					if ( $percentage > $maximumper ) {
						$maximumper = $percentage;
					}

					if ( $percentage < $minimumper ) {
						$minimumper = $percentage;
					}
				}
				if ( $minimumper == $maximumper ) {
					$percent .= '-' . $minimumper . '%';
				} else {
					$percent .= '-(' . $minimumper . '-' . $maximumper . ')%';
				}

			} else {
				if ( $product->get_regular_price() > 0 && $product->get_sale_price() > 0 ) {
					$percentage = round( ( ( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100 ), 0 );
					$percent    .= '-' . $percentage . '%';
				}
			}
		}

		return $percent;
	}
}

/* SHARE SINGLE PRODUCT */
if ( !function_exists( 'smarket_single_product_share' ) ) {
	function smarket_single_product_share()
	{
		global $post;

		$thum_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
		$url        = get_permalink( $post->ID );

		add_action( 'wp_footer', 'smarket_print_scripts' );
		?>
        <div class="smarket-single-product-socials">
            <!-- Facebook -->
            <div class="fb-like" data-href="<?php echo esc_url( $url ); ?>" data-layout="button_count"
                 data-action="like" data-size="small" data-show-faces="false" data-share="false"></div>
            <!-- Twitter -->
            <a class="twitter-share-button"
               href="<?php echo esc_url( add_query_arg( array( 'text' => urlencode( get_the_title( $post->ID ) ), 'url' => $url ), 'https://twitter.com/intent/tweet' ) ); ?>"
               data-size="small">
				<?php esc_html_e( 'Tweet', 'smarket' ); ?></a>
            <!-- Pinit -->
			<?php ?>
            <a href="<?php echo esc_url( add_query_arg( array( 'url' => $url, 'media' => $thum_image[ 0 ], 'description' => urlencode( get_the_title( $post->ID ) ) ), 'http://pinterest.com/pin/create/button/' ) ); ?>"
               class="pin-it-button" count-layout="hozizontal"><?php esc_html_e( 'Pin It', 'smarket' ); ?></a>
            <!-- G+ -->
            <div class="g-plus" data-action="share" data-annotation="bubble"
                 data-href="<?php echo esc_url( $url ); ?>"></div>
        </div>
		<?php
	}
}
add_action( 'woocommerce_share', 'smarket_single_product_share' );

if ( !function_exists( 'smarket_ssl' ) ) {
	function smarket_ssl( $echo = false )
	{
		$ssl = '';
		if ( is_ssl() ) $ssl = 's';
		if ( $echo ) {
			echo esc_attr( $ssl );
		}

		return $ssl;
	}
}

if ( !function_exists( 'smarket_print_scripts' ) ) {
	function smarket_print_scripts()
	{
		?>
        <!-- Facebook scripts -->
        <div id="fb-root"></div>
        <script>(function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[ 0 ];
                if ( d.getElementById(id) ) return;
                js     = d.createElement(s);
                js.id  = id;
                js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8&appId=1115604095124213";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>
        <!-- Twitter -->
        <script>window.twttr = (function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[ 0 ],
                    t       = window.twttr || {};
                if ( d.getElementById(id) ) return t;
                js     = d.createElement(s);
                js.id  = id;
                js.src = "https://platform.twitter.com/widgets.js";
                fjs.parentNode.insertBefore(js, fjs);

                t._e    = [];
                t.ready = function (f) {
                    t._e.push(f);
                };

                return t;
            }(document, "script", "twitter-wjs"));</script>
        <!-- Pinterest -->
        <script type="text/javascript">
            (function () {
                window.PinIt = window.PinIt || {loaded: false};
                if ( window.PinIt.loaded ) return;
                window.PinIt.loaded = true;

                function async_load() {
                    var s   = document.createElement("script");
                    s.type  = "text/javascript";
                    s.async = true;
                    s.src   = "http<?php smarket_ssl( true ); ?>://assets.pinterest.com/js/pinit.js";
                    var x   = document.getElementsByTagName("script")[ 0 ];
                    x.parentNode.insertBefore(s, x);
                }

                if ( window.attachEvent )
                    window.attachEvent("onload", async_load);
                else
                    window.addEventListener("load", async_load, false);
            })();
        </script>

        <!-- G+ -->
        <script src="https://apis.google.com/js/platform.js" async defer></script>
		<?php

	}
}
/* SHARE SINGLE PRODUCT */

if ( !function_exists( 'smarket_woof_products_query' ) ) {
	function smarket_woof_products_query( $wr )
	{
		$smarket_woo_products_perpage = smarket_option( 'smarket_woo_products_perpage', '12' );
		$wr[ 'posts_per_page' ]       = $smarket_woo_products_perpage;

		return $wr;
	}
}

/**
 * Override WooCommerce function smarket_variation_attribute_options (Locate in wc-template-functions.php)
 * Output a list of variation attributes for use in the cart forms.
 *
 * @param array $args
 *
 * @since  1.0
 * @author Gordon Freeman
 */
if ( !function_exists( 'smarket_variation_attribute_options' ) ) {

	/**
	 * Output a list of variation attributes for use in the cart forms.
	 *
	 * @param array $args
	 * @since 2.4.0
	 */
	function smarket_variation_attribute_options( $args = array() )
	{
		$args = wp_parse_args( apply_filters( 'woocommerce_dropdown_variation_attribute_options_args', $args ), array(
				'options'          => false,
				'attribute'        => false,
				'product'          => false,
				'selected'         => false,
				'name'             => '',
				'id'               => '',
				'class'            => '',
				'show_option_none' => esc_html__( 'Choose an option', 'smarket' ),
			)
		);

		$options               = $args[ 'options' ];
		$product               = $args[ 'product' ];
		$attribute             = $args[ 'attribute' ];
		$name                  = $args[ 'name' ] ? $args[ 'name' ] : 'attribute_' . sanitize_title( $attribute );
		$id                    = $args[ 'id' ] ? $args[ 'id' ] : sanitize_title( $attribute );
		$class                 = $args[ 'class' ];
		$show_option_none      = $args[ 'show_option_none' ] ? true : false;
		$show_option_none_text = $args[ 'show_option_none' ] ? $args[ 'show_option_none' ] : esc_html__( 'Choose an option', 'smarket' ); // We'll do our best to hide the placeholder, but we'll need to show something when resetting options.

		if ( empty( $options ) && !empty( $product ) && !empty( $attribute ) ) {
			$attributes = $product->get_variation_attributes();
			$options    = $attributes[ $attribute ];
		}

		$html = '<select id="' . esc_attr( $id ) . '" class="' . esc_attr( $class ) . '" name="' . esc_attr( $name ) . '" data-attribute_name="attribute_' . esc_attr( sanitize_title( $attribute ) ) . '" data-show_option_none="' . ( $show_option_none ? 'yes' : 'no' ) . '">';
		$html .= '<option data-type="" data-' . esc_attr( $id ) . '="" value="">' . esc_html( $show_option_none_text ) . '</option>';

		if ( !empty( $options ) ) {
			if ( $product && taxonomy_exists( $attribute ) ) {
				// Get terms if this is a taxonomy - ordered. We need the names too.
				$terms = wc_get_product_terms( $product->get_id(), $attribute, array( 'fields' => 'all' ) );

				foreach ( $terms as $term ) {
					if ( in_array( $term->slug, $options ) ) {
						// For color attribute
						$data_type  = get_woocommerce_term_meta( $term->term_id, $term->taxonomy . '_attribute_swatch_type', true );
						$data_color = get_woocommerce_term_meta( $term->term_id, $term->taxonomy . '_attribute_swatch_color', true );
						$data_photo = get_woocommerce_term_meta( $term->term_id, $term->taxonomy . '_attribute_swatch_photo', true );
						$photo_url  = wp_get_attachment_url( $data_photo );

						if ( $data_type == 'color' ) {
							$html .= '<option data-type="' . esc_attr( $data_type ) . '" data-' . esc_attr( $id ) . '="' . esc_attr( $data_color ) . '" value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $args[ 'selected' ] ), $term->slug, false ) . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $term->name ) ) . '</option>';
						} elseif ( $data_type == 'photo' ) {
							$html .= '<option data-type="' . esc_attr( $data_type ) . '" data-' . esc_attr( $id ) . '=" url(' . esc_url( $photo_url ) . ') " value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $args[ 'selected' ] ), $term->slug, false ) . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $term->name ) ) . '</option>';
						} else {
							$html .= '<option data-type="' . esc_attr( $data_type ) . '" data-' . esc_attr( $id ) . '="' . esc_attr( $term->slug ) . '" value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $args[ 'selected' ] ), $term->slug, false ) . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $term->name ) ) . '</option>';
						}
					}
				}
			} else {
				foreach ( $options as $option ) {
					// This handles < 2.4.0 bw compatibility where text attributes were not sanitized.
					$selected = sanitize_title( $args[ 'selected' ] ) === $args[ 'selected' ] ? selected( $args[ 'selected' ], sanitize_title( $option ), false ) : selected( $args[ 'selected' ], $option, false );
					$html     .= '<option value="' . esc_attr( $option ) . '" ' . $selected . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) ) . '</option>';
				}
			}
		}

		$html .= '</select>';
		$html .= '<div class="data-val attribute-' . esc_attr( $id ) . '"></div>';

		echo apply_filters( 'woocommerce_dropdown_variation_attribute_options_html', $html, $args );
	}
}

add_filter( 'woof_before_term_name', 'smarket_woof_before_term_name', 20, 2 );

if ( !function_exists( 'smarket_woof_before_term_name' ) ) {
	function smarket_woof_before_term_name( $term, $taxonomy_info )
	{
		global $woocommerce;
		$type  = get_woocommerce_term_meta( $term[ 'term_id' ], $term[ 'taxonomy' ] . '_attribute_swatch_type', true );
		$class = 'term-attr';
		$style = '';
		ob_start();
		if ( $type == 'color' ) {
			$color = get_woocommerce_term_meta( $term[ 'term_id' ], $term[ 'taxonomy' ] . '_attribute_swatch_color', true );
			$class .= ' swatch swatch-color';
			$style = 'style="background-color: ' . $color . '"';
		}
		if ( $type == 'photo' ) {
			$thumbnail_id = get_woocommerce_term_meta( $term[ 'term_id' ], $term[ 'taxonomy' ] . '_attribute_swatch_photo', true );
			if ( $thumbnail_id ) {
				$imgsrc = wp_get_attachment_image_src( $thumbnail_id, 'attribute_swatch' );
				if ( $imgsrc && is_array( $imgsrc ) ) {
					$thumbnail_src = current( $imgsrc );
				} else {
					$thumbnail_src = $woocommerce->plugin_url() . '/assets/images/placeholder.png';
				}
				$class .= ' swatch swatch-photo';
				$style = 'style="background-image: url(' . esc_url( $thumbnail_src ) . ')"';

			}
		}
		echo '<span class="' . esc_attr( $class ) . '" ' . balanceTags( $style ) . '></span>';
		echo balanceTags( $term[ 'name' ] );
		$content1 = ob_get_contents();
		ob_clean();
		ob_end_flush();

		return $content1;
	}
}


/* Compare */
if ( class_exists( 'YITH_Woocompare' ) && get_option( 'yith_woocompare_compare_button_in_products_list' ) == 'yes' ) {
	global $yith_woocompare;
	$is_ajax = ( defined( 'DOING_AJAX' ) && DOING_AJAX );
	if ( $yith_woocompare->is_frontend() || $is_ajax ) {
		if ( $is_ajax ) {
			if ( !class_exists( 'YITH_Woocompare_Frontend' ) ) {
				if ( file_exists( YITH_WOOCOMPARE_DIR . 'includes/class.yith-woocompare-frontend.php' ) ) {
					require_once( YITH_WOOCOMPARE_DIR . 'includes/class.yith-woocompare-frontend.php' );
				}
			}
			$yith_woocompare->obj = new YITH_Woocompare_Frontend();
		}
		/* Remove button */
		remove_action( 'woocommerce_after_shop_loop_item', array( $yith_woocompare->obj, 'add_compare_link' ), 20 );
		/* Add compare button */
		if ( !function_exists( 'smarket_wc_loop_product_compare_btn' ) ) {
			function smarket_wc_loop_product_compare_btn()
			{
				if ( shortcode_exists( 'yith_compare_button' ) ) {
					echo do_shortcode( '[yith_compare_button product_id="' . get_the_ID() . '"]' );
				} // End if ( shortcode_exists( 'yith_compare_button' ) )
				else {
					if ( class_exists( 'YITH_Woocompare_Frontend' ) ) {
						$YITH_Woocompare_Frontend = new YITH_Woocompare_Frontend();
						echo do_shortcode( '[yith_compare_button product_id="' . get_the_ID() . '"]' );
					}
				}
			}
		}
		add_action( 'smarket_function_shop_loop_item_compare', 'smarket_wc_loop_product_compare_btn', 1 );
	}

}

if ( class_exists( 'YITH_WCWL' ) && get_option( 'yith_wcwl_enabled' ) == 'yes' ) {
	if ( !function_exists( 'smarket_wc_loop_product_wishlist_btn' ) ) {
		function smarket_wc_loop_product_wishlist_btn()
		{
			if ( shortcode_exists( 'yith_wcwl_add_to_wishlist' ) ) {
				echo do_shortcode( '[yith_wcwl_add_to_wishlist product_id="' . get_the_ID() . '"]' );
			}
		}
	}
	add_action( 'smarket_function_shop_loop_item_wishlist', 'smarket_wc_loop_product_wishlist_btn', 1 );
}

if ( !function_exists( ( 'smarket_update_wishlist_count' ) ) ) {
	function smarket_update_wishlist_count()
	{
		if ( function_exists( 'YITH_WCWL' ) ) {
			wp_send_json( YITH_WCWL()->count_products() );
		}
	}

	// Wishlist ajaxify update
	add_action( 'wp_ajax_smarket_update_wishlist_count', 'smarket_update_wishlist_count' );
	add_action( 'wp_ajax_nopriv_smarket_update_wishlist_count', 'smarket_update_wishlist_count' );
}

/*Custom hook quick view*/
if ( class_exists( 'YITH_WCQV_Frontend' ) ) {
	// Class frontend
	$enable           = get_option( 'yith-wcqv-enable' ) == 'yes' ? true : false;
	$enable_on_mobile = get_option( 'yith-wcqv-enable-mobile' ) == 'yes' ? true : false;
	// Class frontend
	if ( ( !wp_is_mobile() && $enable ) || ( wp_is_mobile() && $enable_on_mobile && $enable ) ) {
		remove_action( 'woocommerce_after_shop_loop_item', array( YITH_WCQV_Frontend::get_instance(), 'yith_add_quick_view_button' ), 15 );
		add_action( 'smarket_function_shop_loop_item_quickview', array( YITH_WCQV_Frontend::get_instance(), 'yith_add_quick_view_button' ), 5 );
	}
}

if ( !function_exists( 'smarket_single_product_sharing' ) ) {
	function smarket_single_product_sharing()
	{
		global $product, $post;
		$url   = get_the_permalink( $post->ID );
		$title = esc_html( urlencode( get_the_title( $post->ID ) ) );
		$desc  = urlencode( get_the_excerpt( $post->ID ) );
		ob_start();
		?>
        <div class="product_share">
            <a class="facebook" target="_blank" title="<?php esc_html_e( 'share on facebook', 'smarket' ); ?>"
               href="<?php echo esc_url( "https://www.facebook.com/sharer.php?u=" . $url ); ?>"><i
                        class="fa fa-facebook-square" aria-hidden="true"></i></a>
            <a class="twitter" target="_blank" title="<?php esc_html_e( 'share on twitter', 'smarket' ); ?>"
               href="<?php echo esc_url( "https://twitter.com/intent/tweet?url=" . $url . "&text=" . $title ); ?>"><i
                        class="fa fa-twitter-square" aria-hidden="true"></i></a>
            <a class="google" target="_blank" title="<?php esc_html_e( 'share on google+', 'smarket' ); ?>"
               href="<?php echo esc_url( "https://plus.google.com/share?url=" . $url ); ?>"><i
                        class="fa fa-google-plus-square" aria-hidden="true"></i></a>
            <a class="linkedin" target="_blank" title="<?php esc_html_e( 'share on linkedin', 'smarket' ); ?>"
               href="<?php echo esc_url( "https://www.linkedin.com/shareArticle?mini=true&url=" . $url . "&title=" . $title . "&summary=" . $desc ); ?>"><i
                        class="fa fa-linkedin-square" aria-hidden="true"></i></a>
            <a class="tumblr" target="_blank" title="<?php esc_html_e( 'share on tumblr', 'smarket' ); ?>"
               href="<?php echo esc_url( "https://www.tumblr.com/share/link?url=" . $url ); ?>"><i
                        class="fa fa-tumblr-square" aria-hidden="true"></i></a>

        </div>
		<?php
		$content = ob_get_clean();
		echo balanceTags( $content );
	}
}

if ( !function_exists( 'smarket_woo_get_stock_status' ) ) {
	function smarket_woo_get_stock_status()
	{
		global $product;
		?>
        <div class="product-info-stock-sku">
            <div class="stock available">
                <span class="label-available"><?php esc_html_e( 'Avaiability: ', 'smarket' ); ?> </span><?php $product->is_in_stock() ? esc_html_e( 'In Stock', 'smarket' ) : esc_html_e( 'Out Of Stock', 'smarket' ); ?>
            </div>
        </div>
		<?php
	}
}


// GET DATE SALE
if ( !function_exists( 'smarket_get_max_date_sale' ) ) {
	function smarket_get_max_date_sale( $product_id )
	{
		$time = 0;
		// Get variations
		$args          = array(
			'post_type'   => 'product_variation',
			'post_status' => array( 'private', 'publish' ),
			'numberposts' => -1,
			'orderby'     => 'menu_order',
			'order'       => 'asc',
			'post_parent' => $product_id,
		);
		$variations    = get_posts( $args );
		$variation_ids = array();
		if ( $variations ) {
			foreach ( $variations as $variation ) {
				$variation_ids[] = $variation->ID;
			}
		}
		$sale_price_dates_to = false;

		if ( !empty( $variation_ids ) ) {
			global $wpdb;
			$sale_price_dates_to = $wpdb->get_var( "
                SELECT
                meta_value
                FROM $wpdb->postmeta
                WHERE meta_key = '_sale_price_dates_to' and post_id IN(" . join( ',', $variation_ids ) . ")
                ORDER BY meta_value DESC
                LIMIT 1
            "
			);

			if ( $sale_price_dates_to != '' ) {
				return $sale_price_dates_to;
			}
		}

		if ( !$sale_price_dates_to ) {
			$sale_price_dates_to = get_post_meta( $product_id, '_sale_price_dates_to', true );

			if ( $sale_price_dates_to == '' ) {
				$sale_price_dates_to = '0';
			}

			return $sale_price_dates_to;
		}
	}
}


if ( !function_exists( 'smarket_display_product_countdown_in_loop' ) ) {
	function smarket_display_product_countdown_in_loop()
	{
		global $product;
		$date = smarket_get_max_date_sale( $product->get_id() );
		?>
		<?php if ( $date > 0 ):
		$y = date( 'Y', $date );
		$m    = date( 'm', $date );
		$d    = date( 'd', $date );
		$h    = date( 'h', $date );
		$i    = date( 'i', $date );
		$s    = date( 's', $date );
		?>
        <div class="product-count-down">
            <div class="smarket-countdown" data-y="<?php echo esc_attr( $y ); ?>" data-m="<?php echo esc_attr( $m ); ?>"
                 data-d="<?php echo esc_attr( $d ); ?>" data-h="<?php echo esc_attr( $h ); ?>"
                 data-i="<?php echo esc_attr( $i ); ?>" data-s="<?php echo esc_attr( $s ); ?>"></div>
        </div>
	<?php endif; ?>
		<?php
	}
}

if ( !function_exists( 'smarket_shop_banners' ) ) {
	function smarket_shop_banners()
	{
		get_template_part( 'template_parts/shop', 'banners' );
	}
}

add_filter( 'woocommerce_pagination_args', 'custom_pagination' );

if ( !function_exists( 'custom_pagination' ) ) {
	function custom_pagination()
	{
		global $wp_query;

		if ( $wp_query->max_num_pages <= 1 ) {
			return;
		}
		$args = array(
			'base'      => esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) ),
			'format'    => '',
			'add_args'  => false,
			'current'   => max( 1, get_query_var( 'paged' ) ),
			'total'     => $wp_query->max_num_pages,
			'prev_text' => '<i class="pe-7s-angle-left"></i>',
			'next_text' => '<i class="pe-7s-angle-right"></i>',
			'type'      => 'list',
			'end_size'  => 0,
			'mid_size'  => 1,
		);

		return $args;
	}
}

/* AJAX UPDATE WISH LIST */
if ( !function_exists( ( 'smarket_update_wishlist_count' ) ) ) {
	function smarket_update_wishlist_count()
	{
		if ( function_exists( 'YITH_WCWL' ) ) {
			wp_send_json( YITH_WCWL()->count_products() );
		}
	}

	// Wishlist ajaxify update
	add_action( 'wp_ajax_smarket_update_wishlist_count', 'smarket_update_wishlist_count' );
	add_action( 'wp_ajax_nopriv_smarket_update_wishlist_count', 'smarket_update_wishlist_count' );
}

/* REFRESHED FRAGMENTS */
if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '2.3', '>=' ) ) {
	add_filter( 'woocommerce_add_to_cart_fragments', 'smarket_header_add_to_cart_fragment' );
} else {
	add_filter( 'add_to_cart_fragments', 'smarket_header_add_to_cart_fragment' );
}

if ( !function_exists( 'smarket_header_add_to_cart_fragment' ) ) {
	function smarket_header_add_to_cart_fragment( $fragments )
	{
		ob_start();

		get_template_part( 'template_parts/header-mini', 'cart' );

		$fragments[ 'div.smarket-mini-cart' ] = ob_get_clean();

		return $fragments;
	}
}

/* REMOVE CART ITEM */
if ( !function_exists( 'smarket_remove_cart_item_via_ajax' ) ) {
	add_action( 'wp_ajax_smarket_remove_cart_item_via_ajax', 'smarket_remove_cart_item_via_ajax' );
	add_action( 'wp_ajax_nopriv_smarket_remove_cart_item_via_ajax', 'smarket_remove_cart_item_via_ajax' );

	function smarket_remove_cart_item_via_ajax()
	{

		$response = array(
			'message'        => '',
			'fragments'      => '',
			'cart_hash'      => '',
			'mini_cart_html' => '',
			'err'            => 'no',
		);

		$cart_item_key = isset( $_POST[ 'cart_item_key' ] ) ? sanitize_text_field( $_POST[ 'cart_item_key' ] ) : '';
		$nonce         = isset( $_POST[ 'nonce' ] ) ? trim( $_POST[ 'nonce' ] ) : '';

		if ( $cart_item_key == '' || $nonce == '' ) {
			$response[ 'err' ] = 'yes';
			wp_send_json( $response );
		}

		if ( ( wp_verify_nonce( $nonce, 'woocommerce-cart' ) ) ) {

			if ( $cart_item = WC()->cart->get_cart_item( $cart_item_key ) ) {
				WC()->cart->remove_cart_item( $cart_item_key );

				$product = wc_get_product( $cart_item[ 'product_id' ] );

				$item_removed_title = apply_filters( 'woocommerce_cart_item_removed_title', $product ? sprintf( _x( '&ldquo;%s&rdquo;', 'Item name in quotes', 'smarket' ), $product->get_name() ) : esc_html__( 'Item', 'smarket' ), $cart_item );

				// Don't show undo link if removed item is out of stock.
				if ( $product->is_in_stock() && $product->has_enough_stock( $cart_item[ 'quantity' ] ) ) {
					$removed_notice = sprintf( esc_html__( '%s removed.', 'smarket' ), $item_removed_title );
					$removed_notice .= ' <a href="' . esc_url( WC()->cart->get_undo_url( $cart_item_key ) ) . '">' . esc_html__( 'Undo?', 'smarket' ) . '</a>';
				} else {
					$removed_notice = sprintf( esc_html__( '%s removed.', 'smarket' ), $item_removed_title );
				}

				wc_add_notice( $removed_notice );
			}
		} else {
			$response[ 'message' ] = esc_html__( 'Security check error!', 'smarket' );
			$response[ 'err' ]     = 'yes';
			wp_send_json( $response );
		}

		ob_start();

		get_template_part( 'template_parts/header-mini', 'cart' );
		$mini_cart = ob_get_clean();

		$response[ 'fragments' ]      = apply_filters( 'woocommerce_add_to_cart_fragments', array(
				'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>',
			)
		);
		$response[ 'cart_hash' ]      = apply_filters( 'woocommerce_add_to_cart_hash', WC()->cart->get_cart_for_session() ? md5( json_encode( WC()->cart->get_cart_for_session() ) ) : '', WC()->cart->get_cart_for_session() );
		$response[ 'mini_cart_html' ] = $mini_cart;

		wp_send_json( $response );
		die();
	}
}
function smarket_detect_shortcode( $id, $tab_id )
{
	$post = get_post( $id );
	preg_match_all( '/\[vc_tta_section(.*?)vc_tta_section\]/', $post->post_content, $matches );

	if ( $matches[ 0 ] && is_array( $matches[ 0 ] ) && count( $matches[ 0 ] ) > 0 ) {
		foreach ( $matches[ 0 ] as $key => $value ) {
			preg_match_all( '/tab_id="([^"]+)"/', $value, $matches_ids );
			foreach ( $matches_ids[ 1 ] as $matches_id ) {
				if ( $tab_id == $matches_id ) {
					return $value;
				}
			}
		}
	}
}

/* AJAX TABS */
if ( !function_exists( ( 'smarket_ajax_tabs' ) ) ) {
	function smarket_ajax_tabs()
	{
		$response   = array(
			'html'    => '',
			'message' => '',
			'success' => 'no',
		);
		$section_id = isset( $_POST[ 'section_id' ] ) ? $_POST[ 'section_id' ] : '';
		$id         = isset( $_POST[ 'id' ] ) ? $_POST[ 'id' ] : '';
		$shortcode  = smarket_detect_shortcode( $id, $section_id );

		WPBMap::addAllMappedShortcodes();

		$response[ 'html' ]    =  do_shortcode( $shortcode );
		$response[ 'success' ] = 'ok';

		wp_send_json( $response );
		die();
	}

	// TABS ajaxify update
	add_action( 'wp_ajax_smarket_ajax_tabs', 'smarket_ajax_tabs' );
	add_action( 'wp_ajax_nopriv_smarket_ajax_tabs', 'smarket_ajax_tabs' );
}
