<?php
get_header();
$brand_id = get_the_id();
$brand_image_url = get_the_post_thumbnail_url(get_post($brand_id)->ID);

$posts = get_posts(array(
  'numberposts'	=> -1,
	'post_type'		=> 'product'
));

$products = array();

foreach ($posts as $key => $value) {
  if(get_field('marca', $value->ID)->ID == $brand_id){
    array_push($products, $value);
  }
}
?>
<div class="container-wapper">
  <img src="<?php echo $brand_image_url?>" alt="">
  <ul class="product-grid">
    <?php
    if(!empty($products)){
      foreach ($products as $key => $value) {
        $title = $value->post_title;
        $url = get_permalink($value->ID);
        $content = $value->post_excerpt;
        $image_url = get_the_post_thumbnail_url($value->ID);
        $_product = wc_get_product($value->ID);
        $regular_price = $_product->get_regular_price();
        $sale_price = $_product->get_sale_price();
        ?>
        <li class="product-item col-bg-15 col-lg-4 col-md-4 col-sm-4 col-xs-6 col-ts-12 style-1 post-205 product type-product status-publish has-post-thumbnail product_cat-electro-cocina  instock sale taxable shipping-taxable purchasable product-type-simple">
      		<div class="product-inner equal-elem">
            <div class="product-thumb">
      		    <div class="thumb-inner hover-default">
                <a class="thumb-link" href="<?php echo $url?>">
    						  <img width="300" height="300" class="attachment-post-thumbnail wp-post-image lazy owl-lazy" src="<?php echo $image_url ?>" data-original="<?php echo $image_url ?>" data-src="<?php echo $image_url ?>" alt="" style="display: block;">
                </a>
              </div>
    	        <a href="#" class="button yith-wcqv-button" data-product_id="<?php echo $value->ID?>">Quick View</a>
            </div>
            <div class="product-info">
              <h3 class="product-name product_title short">
                <a href="<?php echo $url?>"><?php echo $title?></a>
              </h3>
              <span class="price">
                <?php
                if($sale_price != ''){
                  ?>
                  <del>
                    <span class="woocommerce-Price-amount amount">
                      <span class="woocommerce-Price-currencySymbol">$</span><?php echo $sale_price?>
                    </span>
                  </del>
                  <?php
                }
                if($regular_price != ''){
                ?>
                <ins>
                  <span class="woocommerce-Price-amount amount">
                    <span class="woocommerce-Price-currencySymbol">$</span>
                    <?php echo $regular_price?>
                  </span>
                </ins>
                <?php
                }
                ?>
              </span>
              <div class="info-hover">
              <div class="product-item-des">
                <?php
                echo substr(strip_tags($content), 0, 100) . '...';
                ?>
              <div class="group-button">
              <div class="inner">
            </div>
          </div>
        </div>
      </div>
      </div>
    	</li>
        <?php
      }
    }else {
      echo 'No hay productos con esta marca';
    }
    ?>
  </ul>
</div>
<?php
get_footer();
?>
