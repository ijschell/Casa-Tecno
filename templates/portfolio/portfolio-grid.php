<?php
/**
 * Created by PhpStorm.
 * User: hoangkhanh
 * Date: 12/24/2016
 * Time: 10:17 AM
 */
?>
<?php if ( have_posts() ): ?>
    <div class="sm-portfolio">
        <div class="portfolio_fillter project-fillter">
            <div data-filter="*" class="item-fillter fillter-active"><?php echo esc_html__( 'all works', 'smarket' ) ?></div>
			<?php
			$terms = get_terms( 'portfolio_category' );
			if ( !empty( $terms ) && !is_wp_error( $terms ) ) :
				foreach ( $terms as $term ) : ?>
                    <div data-filter=".portfolio_category-<?php echo esc_attr( $term->slug ); ?>" class="item-fillter">
						<?php echo esc_html( $term->name ); ?>
                    </div>
				<?php endforeach; ?>
			<?php endif; ?>
        </div>
        <div class="portfolio-grid" data-layoutMode="fitRows" data-cols="4">
			<?php while ( have_posts() ): the_post(); ?>
				<?php get_template_part( 'templates/portfolio/content-style/style', '2' ); ?>
			<?php endwhile; ?>
        </div>
		<?php smarket_paging_nav(); ?>
    </div>
	<?php wp_reset_postdata(); ?>
<?php else: ?>
	<?php get_template_part( 'content', 'none' ); ?>
<?php endif; ?>
