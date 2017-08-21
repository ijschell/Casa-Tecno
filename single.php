<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package KuteTheme
 * @subpackage smarket
 * @since smarket 1.0
 */

get_header();
?>
<?php
/*Single post layout*/
$smarket_blog_layout = smarket_option( 'smarket_single_layout', 'left' );


/*Main container class*/
$smarket_main_container_class   = array();
$smarket_main_container_class[] = 'main-container';
if ( $smarket_blog_layout == 'full' ) {
	$smarket_main_container_class[] = 'no-sidebar';
} else {
	$smarket_main_container_class[] = $smarket_blog_layout . '-slidebar';
}


$smarket_main_content_class   = array();
$smarket_main_content_class[] = 'main-content';
if ( $smarket_blog_layout == 'full' ) {
	$smarket_main_content_class[] = 'col-sm-12';
} else {
	$smarket_main_content_class[] = 'col-content';
}

$smarket_slidebar_class   = array();
$smarket_slidebar_class[] = 'sidebar';
if ( $smarket_blog_layout != 'full' ) {
	$smarket_slidebar_class[] = 'col-sidebar';
}
?>
    <div class="<?php echo esc_attr( implode( ' ', $smarket_main_container_class ) ); ?>">
		<?php get_template_part( 'template_parts/part', 'breadcrumb' ); ?>
        <div class="container-wapper">
            <div class="row">
                <div class="<?php echo esc_attr( implode( ' ', $smarket_main_content_class ) ); ?>">
					<?php
					while ( have_posts() ): the_post();
						smarket_set_post_views( get_the_ID() );
						get_template_part( 'templates/blogs/blog', 'single' );

						/*If comments are open or we have at least one comment, load up the comment template.*/
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;
					endwhile;
					?>
					<?php wp_reset_postdata(); ?>
                </div>
				<?php if ( $smarket_blog_layout != "full" ): ?>
                    <div class="<?php echo esc_attr( implode( ' ', $smarket_slidebar_class ) ); ?>">
						<?php get_sidebar(); ?>
                    </div>
				<?php endif; ?>
            </div>
        </div>
    </div>
<?php get_footer(); ?>