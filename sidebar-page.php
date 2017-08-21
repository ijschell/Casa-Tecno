<?php
$smarket_page_used_sidebar = smarket_get_post_meta(get_the_ID(),'smarket_page_used_sidebar','widget-area');
?>
<?php if ( is_active_sidebar( $smarket_page_used_sidebar ) ) : ?>
    <div id="widget-area" class="widget-area">
        <?php dynamic_sidebar( $smarket_page_used_sidebar ); ?>
    </div><!-- .widget-area -->
<?php endif; ?>
