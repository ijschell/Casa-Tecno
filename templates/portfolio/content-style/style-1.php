<?php $categories_list = get_the_term_list( get_the_ID(), 'portfolio_category', '', ' ' ); ?>
<div <?php post_class( 'portfolio-item' ); ?>>
    <div class="post-thumb">
		<?php $image_thumb = smarket_resize_image( get_post_thumbnail_id(), null, 330, 205, true, true, false ); ?>
        <img width="<?php echo esc_attr( $image_thumb[ 'width' ] ); ?>"
             height="<?php echo esc_attr( $image_thumb[ 'height' ] ); ?>"
             class="attachment-post-thumbnail wp-post-image"
             src="<?php echo esc_attr( $image_thumb[ 'url' ] ) ?>" alt="<?php the_title(); ?>"/>
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