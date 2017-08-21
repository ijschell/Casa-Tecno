<?php
/**
 * Template Name: Full Width Box
 *
 * @package WordPress
 * @subpackage smarket
 * @since smarket 1.0
 */
get_header();
?>
	<div class="fullwidth-box-template wapper">
		<div class="container-wapper">
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