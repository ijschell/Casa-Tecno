<?php if( !is_product() ):?>
<div class="toolbar-products toolbar-top clear-both">
    <div class="short-by">
        <span class="title-control"><?php echo esc_html__('Ordenar:','smarket')?></span>
        <!-- <span class="title-control">Ordenar:</span> -->
		<?php woocommerce_catalog_ordering();?>
    </div>
    <div class="shop-perpage">
		<?php smarket_shop_post_perpage(); ?>
    </div>
    <div class="modes">
        <!-- <?php smarket_shop_view_more();?> -->
    </div>
	<?php global $wp_query; if ( $wp_query->max_num_pages <= 1 ) : return; ?>
	<?php else : ?>
        <div class="pagination-top">
            <?php
            $curent_paged = max( 1, get_query_var( 'paged' ) );
            $max_page = $wp_query->max_num_pages;
            ?>
			<?php echo get_previous_posts_link('<i class="pe-7s-angle-left"></i>'); ?>
            <span class="curent-page"><?php echo  $curent_paged; ?></span>
            <span class="text"><?php echo esc_html__('de','smarket')?></span>
            <span class="max-page"><?php echo  $max_page; ?></span>
			<?php echo get_next_posts_link('<i class="pe-7s-angle-right"></i>'); ?>
        </div>
	<?php endif; ?>
</div>
<?php endif;?>
