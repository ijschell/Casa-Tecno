<?php
$smarket_blog_used_sidebar = smarket_option( 'smarket_blog_used_sidebar', 'widget-area' );
if( is_single()){
    $smarket_blog_used_sidebar = smarket_option( 'smarket_single_used_sidebar', 'widget-area' );
}
?>
<?php if ( is_active_sidebar( $smarket_blog_used_sidebar ) ) : ?>
<div id="widget-area" class="widget-area sidebar-blog">
	<?php dynamic_sidebar( $smarket_blog_used_sidebar ); ?>
</div><!-- .widget-area -->
<?php endif; ?>