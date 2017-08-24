<?php
/**
 * Template Name: Page Have Sidebar
 *
 * @package WordPress
 * @subpackage smarket
 * @since smarket 1.0
 */
get_header();
?>
	<div class="fullwidth-sidebar-template">
		<div class="container-wapper">
			<div class="row">
				<div class="main-content col-content">
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
				<div class="sidebar col-sidebar">
					<div id="widget-area" class="widget-area">
						<?php dynamic_sidebar( 'page-widget-area' ); ?>
					</div><!-- .widget-area -->
				</div>
			</div>

		</div>
	</div>
<?php
get_footer();
