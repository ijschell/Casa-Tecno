<?php
$categories_list = get_the_term_list( get_the_ID(), 'portfolio_category', '', ' ' );
$images          = rwmb_meta( 'smarket_portfolio_gallery', 'type=image_advanced&size=full', get_the_ID() );
$images_src      = get_the_post_thumbnail_url( get_the_ID(), 'full' );
?>
<div <?php post_class( 'portfolio-item' ); ?>>
    <div class="post-thumb">
		<?php $image_thumb = smarket_resize_image( get_post_thumbnail_id(), null, 417, 260, true, true, false ); ?>
        <a href="<?php the_permalink(); ?>">
            <img width="<?php echo esc_attr( $image_thumb[ 'width' ] ); ?>"
                 height="<?php echo esc_attr( $image_thumb[ 'height' ] ); ?>"
                 class="attachment-post-thumbnail wp-post-image"
                 src="<?php echo esc_attr( $image_thumb[ 'url' ] ) ?>" alt="<?php the_title(); ?>"/>
        </a>
        <div class="hover-thumb">
            <a href="<?php the_post_thumbnail_url( 'full' ); ?>" class="html5lightbox" data-group="portfolio<?php echo get_the_ID(); ?>"><i
                        class="fa fa-search"></i></a>
			<?php if ( !empty( $images ) ) : ?>
                <span class="gallery" style="display: none;">
                    <?php foreach ( $images as $image ) : ?>
                        <a href="<?php echo esc_url( $image[ 'full_url' ] ) ?>" class="html5lightbox"
                           data-group="portfolio<?php echo get_the_ID(); ?>"></a>
					<?php endforeach; ?>
                </span>
			<?php endif; ?>
            <a href="<?php the_permalink(); ?>"><i class="fa fa-link"></i></a>
        </div>
    </div>
    <div class="post-detail">
		<?php if ( $categories_list ) : ?>
            <div class="post-meta">
				<?php printf( esc_html__( '%1$s', 'smarket' ), $categories_list ); ?>
            </div>
		<?php endif; ?>
        <h3 class="post-name">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
    </div>
</div>