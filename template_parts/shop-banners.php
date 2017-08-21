<?php
$woo_shop_banner = smarket_option( 'woo_shop_banner', '' );

$banner_class = array( 'banner-shop banner-shop' );
if ( $woo_shop_banner ) : ?>
    <div class="<?php echo esc_attr( implode( ' ', $banner_class ) ); ?>">
        <figure>
            <img src="<?php echo esc_url($woo_shop_banner['url']); ?>" alt="<?php the_title(); ?>">
        </figure>
    </div>
<?php else : ?>
	<?php return; ?>
<?php endif; ?>
