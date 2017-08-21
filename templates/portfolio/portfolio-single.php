<?php
$categories_list = get_the_term_list( get_the_ID(), 'portfolio_category', '', ' ' );
$client_list     = get_the_term_list( get_the_ID(), 'portfolio_client', '', ' ' );
$client_location = get_the_term_list( get_the_ID(), 'portfolio_location', '', ' ' );
$images          = rwmb_meta( 'smarket_portfolio_gallery', 'type=image_advanced&size=full', get_the_ID() );
?>
<div <?php post_class( 'portfolio-item' ); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
        <div class="thumb-single">
			<?php if ( !empty( $images ) ) : ?>
                <div class="owl-carousel owl-portfolio" data-nav=true data-dots=false data-items="1">
					<?php foreach ( $images as $image ) : ?>
						<?php $image_thumb = smarket_resize_image( $image[ 'ID' ], null, 1760, 914, true, true, false ); ?>
                        <img width="<?php echo esc_attr( $image_thumb[ 'width' ] ); ?>"
                             height="<?php echo esc_attr( $image_thumb[ 'height' ] ); ?>"
                             class="attachment-post-thumbnail wp-post-image"
                             src="<?php echo esc_attr( $image_thumb[ 'url' ] ) ?>" alt="<?php the_title(); ?>"/>
					<?php endforeach; ?>
                </div>
			<?php else : ?>
				<?php the_post_thumbnail( 'full' ); ?>
			<?php endif; ?>
        </div>
	<?php endif; ?>
    <div class="left-content">
        <h2 class="post-title"><?php the_title(); ?></h2>
        <div class="post-detail">
            <div class="post-content"><?php the_content(); ?></div>
        </div>
        <div class="post-footer">
			<?php
			the_post_navigation( array(
					'prev_text' => '<span class="screen-reader-text"><i class="fa fa-caret-left" aria-hidden="true"></i>' . esc_html__( 'Previous', 'smarket' ) . '</span>',
					'next_text' => '<span class="screen-reader-text">' . esc_html__( 'Next', 'smarket' ) . '<i class="fa fa-caret-right" aria-hidden="true"></i></span>',
				)
			);
			?>
			<?php get_template_part( 'templates/portfolio/portfolio', 'related' ); ?>
        </div>
    </div>
    <div class="sidebar-single">
        <ul class="post-metas">
            <li>
                <span class="text"><?php echo esc_html__( 'date:', 'smarket' ) ?></span>
                <span class="detail"><?php echo get_the_date( 'F j, Y' ); ?></span>
            </li>
			<?php if ( $categories_list ) : ?>
                <li>
                    <span class="text"><?php echo esc_html__( 'categories:', 'smarket' ) ?></span>
                    <span class="detail">
                    <?php printf( esc_html__( '%1$s', 'smarket' ), $categories_list ); ?>
                </span>
                </li>
			<?php endif; ?>
			<?php if ( $client_list ) : ?>
                <li>
                    <span class="text"><?php echo esc_html__( 'client:', 'smarket' ) ?></span>
                    <span class="detail">
                    <?php printf( esc_html__( '%1$s', 'smarket' ), $client_list ); ?>
                </span>
                </li>
			<?php endif; ?>
			<?php if ( $client_location ) : ?>
                <li>
                    <span class="text"><?php echo esc_html__( 'location:', 'smarket' ) ?></span>
                    <span class="detail">
                   <?php printf( esc_html__( '%1$s', 'smarket' ), $client_location ); ?>
                </span>
                </li>
			<?php endif; ?>
            <li>
				<?php get_template_part( 'templates/blogs/blog', 'share' ); ?>
            </li>
        </ul>
    </div>
</div>