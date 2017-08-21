<?php get_header(); ?>
<div class="main-container no-sidebar">
	<?php get_template_part( 'template_parts/part', 'breadcrumb' ); ?>
    <div class="container">
        <div class="row">
            <div class="main-content col-sm-12">
				<?php
				if ( have_posts() ) {
					?>
                    <div class="post-list post-items">
						<?php
						while ( have_posts() ) {
							the_post();
							?>
                            <div <?php post_class( 'post-item' ); ?>>
                                <div class="post-item-info">
                                    <h3 class="post-name">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>
                                    <div class="post-metas">
                                        <span class="author">
                                            <img src="<?php echo get_template_directory_uri() . '/images/user.png' ?>" alt="">
                                            <?php esc_html_e( 'By', 'smarket' ); ?> <?php the_author(); ?>
                                        </span>
                                        <span class="time">
                                            <img src="<?php echo get_template_directory_uri() . '/images/calendar.png' ?>" alt="">
                                            <?php echo get_the_date( 'M, d, Y' ); ?>
                                        </span>
                                    </div>
                                    <div class="post-thumb">
										<?php smarket_post_thumbnail(); ?>
                                    </div>
                                    <div class="post-excerpt"><?php echo wp_trim_words( get_the_content(), 100, esc_html__( '...', 'smarket' ) ); ?></div>
                                    <a href="<?php the_permalink(); ?>" class="button">
                                        <span class="text"><?php esc_html_e( 'Read more', 'smarket' ); ?></span>
                                    </a>
                                </div>
                            </div>
							<?php
						}
						?>
						<?php wp_reset_postdata(); ?>
                    </div>
					<?php
					smarket_paging_nav();
				} else {
					get_template_part( 'content', 'none' );
				}
				?>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>

