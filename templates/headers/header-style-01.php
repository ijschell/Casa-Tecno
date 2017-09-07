<?php
/*
 Name:  Header style 01
 */
 //Poner en true si tiene carrito de compras
 $carrito = false;
?>
<?php
$opt_enable_vertical_menu = smarket_option( 'opt_enable_vertical_menu', '1' );
$smarket_phone            = smarket_option( 'opt_hotline', '' );
$smarket_email            = smarket_option( 'opt_email', '' );

$smarket_vectical_menu = smarket_get_post_meta( get_the_ID(), 'header_vectical_menu', '1' );

$smarket_page_setting = smarket_get_post_meta( get_the_ID(), 'page_setting', '0' );

if ( $smarket_page_setting == 1 ) {
	$opt_enable_vertical_menu = $smarket_vectical_menu;
}

$header_nav_class = array( 'header-nav header-sticky' );
if ( $opt_enable_vertical_menu == 1 ) {
	$header_nav_class[] = 'has-vertical-menu';
}
?>

<header id="header" class="header style1">
    <!-- <div class="top-header">
        <div class="container-wapper">
            <ul class="smarket-nav top-bar-menu left">
				<?php get_template_part( 'template_parts/header', 'language' ); ?>
				<?php get_template_part( 'template_parts/header', 'currency' ); ?>
				<?php if ( $smarket_phone != '' || $smarket_email != '' ) : ?>
                    <li class="menu-item phone-email">
                        <a href="javascript:void(0)">
                            <span class="icon fa fa-phone"></span>
							<?php echo esc_html( $smarket_phone ); ?>
                        </a>
                        <span><?php echo esc_html__( '/', 'smarket' ); ?></span>
                        <a href="mailto:<?php echo esc_attr( $smarket_email ); ?>">
                            <span class="icon fa fa-envelope"></span>
							<?php echo esc_html( $smarket_email ); ?>
                        </a>
                    </li>
				<?php endif; ?>
            </ul>
			<?php
			wp_nav_menu( array(
					'menu'            => 'top_right_menu',
					'theme_location'  => 'top_right_menu',
					'depth'           => 1,
					'container'       => '',
					'container_class' => '',
					'container_id'    => '',
					'menu_class'      => 'smarket-nav top-bar-menu right',
					'fallback_cb'     => 'Smarket_navwalker::fallback',
					'walker'          => new Smarket_navwalker(),
				)
			);
			?>
        </div>
    </div> -->
    <div class="main-header">
        <div class="container-wapper">
            <div class="header-content">
                <div class="logo">
					<?php smarket_get_logo(); ?>
                </div>
                <div class="header-search-box">
					<?php smarket_search_form(); ?>
                </div>
                <div class="header-control clear-both">
					<?php
					$opt_enable_wishlist_link = smarket_option( 'opt_enable_wishlist_link', '1' );
					?>
                    <a href="#" class="search-icon-mobile"><?php esc_html_e( 'Serach', 'smarket' ); ?></a>
										<?php if($carrito == true){?>
					<?php if ( defined( 'YITH_WCWL' ) && $opt_enable_wishlist_link ) : ?>
						<?php
						$yith_wcwl_wishlist_page_id = get_option( 'yith_wcwl_wishlist_page_id' );
						$wishlist_url               = get_page_link( $yith_wcwl_wishlist_page_id );
						?>
						<?php if ( $wishlist_url != '' ) : ?>
                            <a class="woo-wishlist-link header-wishlist" href="<?php echo esc_url( $wishlist_url ); ?>">
                                <span class="count"><?php echo '(' . YITH_WCWL()->count_products() . ')'; ?></span>
                            </a>
						<?php endif; ?>
					<?php endif; ?>
					<?php if ( class_exists( 'WooCommerce' ) ): ?>
						<?php get_template_part( 'template_parts/header-mini', 'cart' ); ?>
					<?php endif; ?>
                    <a class="menu-bar mobile-navigation" href="#">
                        <span class="icon"><span></span><span></span><span></span></span>
                        <span class="text"><?php esc_html_e( 'MAIN MENU', 'smarket' ); ?></span>
                    </a>
									<?php }else{
										?>
										<div class="header-custom-icons">
											<a href="#" class="facebook"></a>
											<a href="#" class="mail"></a>
											<a href="#" class="phone"></a>
											<a href="#" class="location"></a>
										</div>
										<?php
									}?>
                </div>
            </div>
        </div>
    </div>
    <div class="<?php echo esc_attr( implode( ' ', $header_nav_class ) ); ?>">
        <div class="container-wapper">
            <div class="header-nav-inner">
				<?php get_template_part( 'template_parts/header', 'vectical-menu' ); ?>
                <div class="box-header-nav">
                    <div class="main-menu-wapper"></div>
					<?php
					wp_nav_menu( array(
							'menu'            => 'primary',
							'theme_location'  => 'primary',
							'depth'           => 3,
							'container'       => '',
							'container_class' => '',
							'container_id'    => '',
							'menu_class'      => 'clone-main-menu smarket-nav main-menu center',
							'fallback_cb'     => 'Smarket_navwalker::fallback',
							'walker'          => new Smarket_navwalker(),
						)
					);
					?>
                </div>
            </div>
        </div>
    </div>
</header>
