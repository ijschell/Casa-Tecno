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
                <h1 class="page-title"><?php echo esc_html__( 'Search Results for: ', 'smarket' ) . '<span style="text-transform: none;">"' . get_search_query() . '"</span>'; ?></h1>
				<?php get_template_part('templates/blogs/blog','search');?>
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

