<?php
/**
 * Template Name: Full Width breadcrumb
 *
 * @package WordPress
 * @subpackage smarket
 * @since smarket 1.0
 */
get_header();
?>
	<div class="fullwidth-box-template wapper main-container">
		<?php get_template_part( 'template_parts/part', 'breadcrumb' ); ?>
		<?php get_template_part('template_parts/page','banner');?>
		<div class="container-wapper">
            <div class="page-title">
                <?php the_title();?>
            </div>
			<?php
			// Start the loop.
			while ( have_posts() ) : the_post();
				?>
				<?php the_content( );?>
				<?php
				// End the loop.
			endwhile;
			?>
		</div>
	</div>
<?php
get_footer();