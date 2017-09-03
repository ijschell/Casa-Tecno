<?php if( !is_product() ):?>
	<div class="toolbar-products toolbar-bottom clear-both">
		<div class="short-by">
			<span class="title-control"><?php echo esc_html__('Ordenar:','smarket')?></span>
			<?php woocommerce_catalog_ordering();?>
		</div>
		<div class="shop-perpage">
			<?php smarket_shop_post_perpage(); ?>
		</div>
	</div>
<?php endif;?>
