<?php get_header(); ?>
<?php
/*Portfolio layout*/
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
	$smarket_main_content_class[] = 'col-content';
}

$smarket_slidebar_class   = array();
$smarket_slidebar_class[] = 'sidebar';
if ( $smarket_portfolio_layout != 'full' ) {
	$smarket_slidebar_class[] = 'col-sidebar';
}
?>
<div class="<?php echo esc_attr( implode( ' ', $smarket_main_container_class ) ); ?>">
    <?php get_template_part( 'template_parts/part', 'breadcrumb' ); ?>
    <div class="container-wapper">
        <div class="row">
            <div class="<?php echo esc_attr( implode( ' ', $smarket_main_content_class ) ); ?>">
                <!-- Main content -->
				<?php get_template_part( 'templates/portfolio/portfolio', 'grid' ); ?>
                <!-- ./Main content -->
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>

