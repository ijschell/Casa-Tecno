<?php

if ( !function_exists( 'smarket_custom_css' ) ) {
	function smarket_custom_css()
	{
		$css = smarket_option( 'smarket_custom_css', '' );
		$css .= smarket_theme_color();
		$css .= smarket_vc_custom_css_footer();
		wp_enqueue_style(
			'smarket-style',
			get_template_directory_uri() . '/css/style.css'
		);
		wp_add_inline_style( 'smarket-style', $css );
	}
}
add_action( 'wp_enqueue_scripts', 'smarket_custom_css', 999 );

if ( !function_exists( 'smarket_theme_color' ) ) {
	function smarket_theme_color()
	{

		$main_color = smarket_option( 'smarket_main_color', '#ff7f00' );
		$main_color = str_replace( "#", '', $main_color );
		$main_color = "#" . $main_color;

		$main_color2 = smarket_option( 'smarket_main_color2', '#ff9933' );
		$main_color2 = str_replace( "#", '', $main_color2 );
		$main_color2 = "#" . $main_color2;

		$main_color2_rgb = smarket_hex2rgb( $main_color2 );

		/* Main color */
		$css = '
a:hover,
.top-bar-menu.left>li .icon,
.top-bar-menu>li>a:hover,
.top-bar-menu>li.active>a,
.top-bar-menu .submenu>li:hover>a,
.top-bar-menu .submenu>li.active>a,
.post-item .post-name:hover a,
.post-item .post-metas > span.sticky-post,
.post-comments .comments .comment-content .date,
.post-comments .comments .comment-content .comment-reply-link:hover,
.smarket_posts_widget .post .item-date,
.yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a,
.yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a,
.smarket-products .compare.added,
.entry-summary .compare.added,
.product-item .compare.added,
.smarket-tabs.style1 .tabs-link li.active a,
.smarket-tabs.style1 .tabs-link li:hover a,
.portfolio-item .post-detail .post-meta a:hover,
.portfolio-item .post-metas .post-item-share > a:hover,
.widget_product_categories .cat-item .carets:hover,
.product-countdown .product-info .hurry-up-title,
.smarket-custommenu > a,
.smarket-iconbox .icon,
.smarket-custommenu .menu a:hover,
.smarket-blogs .post-item .post-item-info > a,
.smarket-categories .info > a:hover,
.social-header .social-list a:hover,
.sidebar .widget_product_categories .cat-item a:hover,
.sidebar .widget_product_categories .children .cat-item a:hover,
.sidebar .widget_layered_nav > div a:hover,
.sidebar .widget_product_categories .cat-item.show-sub > a,
body.home .sidebar .smarket_posts_widget .post .post-name a:hover,
body.home .sidebar .smarket_posts_widget .post .item-detail > a,
.portfolio-item .post-name a:hover,
.shop_table tbody .product-name a:not(.button):hover,
.switcher-login a:hover span:not(.icon),
.entry-summary .block-stock .stock,
.entry-summary .woocommerce-review-link:hover,
.sidebar .widget_shopping_cart .mini_cart_item>a:not(.remove):hover,
body.woocommerce-account .lost_password a,
body.woocommerce-account .banner-account ul li i,
.wcml_currency_switcher .wcml-cs-active-currency a:hover
{
    color:' . $main_color . ';
}
.smarket-banner .banner-content a:hover
{
    color:' . $main_color . ' !important;
}
.button:not(.add_to_cart_button):not(.ajax_add_to_cart):not(.added_to_cart):not(.product_type_grouped):not(.compare):not(.yith-wcqv-button),
input[type="submit"],
.form-search .btn-search,
.block-minicart .cartlink .cart-icon .count,
.header-nav ,
.mini-cart-content .actions .btn-viewcart:hover,
.sidebar .widgettitle::before,
.widget_calendar #today,
.bx-wrapper .bx-controls-direction a:hover,
.wc-tabs li.active a,
.smarket-tabs.default .tabs-link li.active a,
a.backtotop i,
a.modes-mode.active span,
a.modes-mode:hover span,
.toolbar-products .pagination-top .curent-page,
.toolbar-products .pagination-top a:hover,
.woocommerce-pagination .page-numbers li .current,
.woocommerce-pagination .page-numbers li a:hover,
.smarket-title.style-2::before,
.ui-slider .ui-slider-range,
.smarket-slider.style2 .owl-carousel .owl-nav .owl-prev:hover,
.smarket-slider.style2 .owl-carousel .owl-nav .owl-next:hover,
.widget_tag_cloud .tagcloud a:hover,
.added_to_cart,
.shop-page .page-title::before
{
    background-color:' . $main_color . ';
}
.bx-wrapper .bx-controls-direction a:hover,
a.backtotop,
.woocommerce .woocommerce-error,
.woocommerce .woocommerce-info,
.woocommerce .woocommerce-message,
.smarket-tabs.style1 .tabs-link li.active a,
.smarket-tabs.style1 .tabs-link li:hover a,
.ui-slider .ui-slider-handle,
.smarket-slider.style2 .owl-carousel .owl-nav .owl-prev:hover,
.smarket-slider.style2 .owl-carousel .owl-nav .owl-next:hover,
.product-countdown .product-countdown-gallery .owl-dot.slick-current img,
.widget_tag_cloud .tagcloud a:hover,
.footer.style3 .widget_tag_cloud .tagcloud a:hover,
.footer.style2 .widget_tag_cloud .tagcloud a:hover,
.yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a,
.yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a,
.smarket-products .compare.added,
.entry-summary .compare.added,
.product-item .compare.added
{
    border-color:' . $main_color . ';
}
.product-countdown .product-countdown-gallery .owl-dot.slick-current::before
{
    border-right-color:' . $main_color . ';
}
.product-countdown .product-countdown-gallery .owl-dot.slick-current::before
{
    border-bottom-color:' . $main_color . ';
}
.button:not(.add_to_cart_button):not(.ajax_add_to_cart):not(.added_to_cart):not(.product_type_grouped):not(.compare):not(.yith-wcqv-button):hover,
.add_to_cart_button:hover,
.ajax_add_to_cart:hover,
.added_to_cart:hover,
.product_type_grouped:hover,
.add_to_cart_button:focus,
.ajax_add_to_cart:focus,
.added_to_cart:focus,
.product_type_grouped:focus,
.yith-wcqv-button:hover,
input[type="submit"]:hover,
.button:focus,
input[type="submit"]:focus,
.form-search .btn-search:hover,
.header.style2 .form-search .btn-search:hover,
.product-item .product-thumb .yith-wcqv-button:hover,
.product-item .product-info .add_to_cart_button:hover,
.product-item .product-info .ajax_add_to_cart:hover,
.product-item .product-info .added_to_cart:hover,
.product-item .product-info .product_type_grouped:hover,
.yith-wcwl-add-to-wishlist .yith-wcwl-add-button:hover a,
.yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse:hover a,
.yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse:hover a,
.smarket-products .compare:hover,
.entry-summary .compare:hover,
.product-item .compare:hover,
.smarket-products .compare.added:hover,
.entry-summary .compare.added:hover,
.product-item .compare.added:hover,
.quantity a:hover,
.product-gallery .play-video:hover,
.portfolio-item .post-thumb .hover-thumb > a:hover,
.owl-portfolio .owl-nav .owl-prev:hover,
.owl-portfolio .owl-nav .owl-next:hover,
a.backtotop:hover i,
.product-gallery .woocommerce-product-gallery__trigger:hover,
.contact-header .top-bar-menu li .icon,
.header.style2 .block-nav-categori .block-title,
.wishlist_table .product-name a.button:hover,
.slick-slider .slick-arrow:hover,
#html5-close:hover,
#yith-quick-view-close:hover,
.mini-cart-content .minicart-items .remove a:hover,
#customer_login .button:hover,
.mini-cart-content .minicart-items .item-remove a:hover
{
    background-color:' . $main_color2 . ';
}
.yith-wcwl-add-to-wishlist .yith-wcwl-add-button:hover a,
.yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse:hover a,
.yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse:hover a,
.smarket-products .compare:hover,
.entry-summary .compare:hover,
.product-item .compare:hover,
.smarket-products .compare.added:hover,
.entry-summary .compare.added:hover,
.product-item .compare.added:hover,
.quantity a:hover,
.product-gallery .play-video:hover,
a.backtotop:hover,
.product-gallery .woocommerce-product-gallery__trigger:hover,
.page-404 .des .button:hover
{
    border-color:' . $main_color2 . ';
}
.page-404 .des .button:hover,
.mini-cart-content .actions .btn-viewcart:hover
{
    background-color:' . $main_color2 . ' !important;
}
@media (min-width : 1025px) {
    .vertical-menu>li:hover>a,
    .vertical-menu>li.active>a,
    .vertical-menu .submenu>li:hover>a,
    .vertical-menu .submenu>li.active>a,
    .vertical-menu li:hover> .toggle-submenu,
    .vertical-menu li.active> .toggle-submenu,
    .main-menu .submenu>li:hover>a,
    .main-menu .submenu>li.active>a,
    .main-menu .submenu>li:hover>.toggle-submenu,
    .main-menu .submenu>li.active>.toggle-submenu,
    .header.style2 .main-menu>li.active>a,
    .header.style2 .main-menu>li:hover>a
    {
        color:' . $main_color . ';
    }
    .slick-slider .slick-slide:hover img
    {
        border-color:' . $main_color . ';
    }
    .main-menu>li:hover>a,
    .main-menu>li.active>a
    {
        background-color:' . $main_color2 . ';
    }
}
';

		return $css;
	}
}

if ( !function_exists( 'smarket_vc_custom_css_footer' ) ) {
	function smarket_vc_custom_css_footer()
	{
		$smarket_footer_style = smarket_option( 'smarket_footer_style', '' );

		if ( is_page() ) {

			global $wp_query;

			$the_id = $wp_query->post->ID;

			$smarket_page_setting = smarket_get_post_meta( $the_id, 'page_setting', '0' );

			$smarket_metabox_footer_style = smarket_get_post_meta( $the_id, 'box_style_footer', '' );

			if ( $smarket_page_setting == 1 ) {
				$smarket_footer_style = $smarket_metabox_footer_style;
			}
		}


		$shortcodes_custom_css = get_post_meta( $smarket_footer_style, '_wpb_shortcodes_custom_css', true );
		$shortcodes_custom_css .= get_post_meta( $smarket_footer_style, '_smarket_shortcode_custom_css', true );

		return $shortcodes_custom_css;
	}
}

if ( !function_exists( 'smarket_write_custom_js ' ) ) {
	function smarket_write_custom_js()
	{
		$smarket_custom_js = smarket_option( 'smarket_custom_js', '' );
		wp_enqueue_script( 'smarket-script', get_template_directory_uri() . '/js/functions.min.js', array( 'jquery' ), '1.0' );
		wp_add_inline_script( 'smarket-script', $smarket_custom_js );
	}
}
add_action( 'wp_enqueue_scripts', 'smarket_write_custom_js' );

if ( !function_exists( 'smarket_hex2rgb' ) ) {
	/**
	 * Convert HEX to RGB.
	 *
	 * @since smarket 1.0
	 *
	 * @param string $color The original color, in 3- or 6-digit hexadecimal form.
	 * @return array Array containing RGB (red, green, and blue) values for the given HEX code, empty array otherwise.
	 * @author KuteThemes
	 */
	function smarket_hex2rgb( $color )
	{
		$color = trim( $color, '#' );

		if ( strlen( $color ) == 3 ) {
			$r = hexdec( substr( $color, 0, 1 ) . substr( $color, 0, 1 ) );
			$g = hexdec( substr( $color, 1, 1 ) . substr( $color, 1, 1 ) );
			$b = hexdec( substr( $color, 2, 1 ) . substr( $color, 2, 1 ) );
		} else if ( strlen( $color ) == 6 ) {
			$r = hexdec( substr( $color, 0, 2 ) );
			$g = hexdec( substr( $color, 2, 2 ) );
			$b = hexdec( substr( $color, 4, 2 ) );
		} else {
			return array();
		}

		return array( 'red' => $r, 'green' => $g, 'blue' => $b );
	}
}