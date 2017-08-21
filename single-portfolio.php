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
/*Single portfolio layout*/
$smarket_portfolio_layout  = 'full';


/*Main container class*/
$smarket_main_container_class   = array();
$smarket_main_container_class[] = 'main-container';
if ( $smarket_portfolio_layout == 'full' ) {
	$smarket_main_container_class[] = 'no-sidebar';
} else {
	$smarket_main_container_class[] = $smarket_portfolio_layout . '-slidebar';
}


$smarket_main_content_class   = array();
$smarket_main_content_class[] = 'main-content';
if ( $smarket_portfolio_layout == 'full' ) {
	$smarket_main_content_class[] = 'col-sm-12';
} else {
	$smarket_main_content_class[] = 'col-lg-9 col-md-9 col-sm-8';
}

$smarket_slidebar_class   = array();
$smarket_slidebar_class[] = 'sidebar';
if ( $smarket_portfolio_layout != 'full' ) {
	$smarket_slidebar_class[] = 'col-lg-3 col-md-3 col-sm-4';
}
?>
    <div class="<?php echo esc_attr( implode( ' ', $smarket_main_container_class ) ); ?>">
		<?php get_template_part( 'template_parts/part', 'breadcrumb' ); ?>
        <div class="container-wapper">
            <div class="row">
                <div class="<?php echo esc_attr( implode( ' ', $smarket_main_content_class ) ); ?>">
					<?php
					while ( have_posts() ): the_post();
						get_template_part( 'templates/portfolio/portfolio', 'single' );
					endwhile;
					?>
					<?php wp_reset_postdata(); ?>
                </div>
            </div>
        </div>
    </div>
<?php get_footer(); ?>