<?php get_header(); ?>
<?php
/*Blog layout*/
$smarket_blog_layout = smarket_option( 'smarket_blog_layout', 'left' );


/*Blog settinglist*/
$smarket_blog_list_columns = smarket_option( 'smarket_blog_list_columns', 3 );

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
                <!-- Main content -->
				<?php get_template_part( 'templates/blogs/custom', 'home' ); ?>
                <!-- ./Main content -->
            </div>
			<?php if ( $smarket_blog_layout != "full" ): ?>
                <div class="<?php echo esc_attr( implode( ' ', $smarket_slidebar_class ) ); ?>">
					<?php get_sidebar(); ?>
                </div>
			<?php endif; ?>
        </div>
				<div style="clear: both;">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<?php include get_template_directory(). '/templates/custom-bottom-home.php' ?>
					</div>
				</div>
    </div>
</div>
<?php get_footer(); ?>
