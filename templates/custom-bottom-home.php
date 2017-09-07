<link rel="stylesheet" href="<?php echo get_template_directory_uri(). '/css/custom-bottom-home.css'; ?>">
<div class="custom-bottom-home">
  <div class="custom-title">
    <h2>Super sale</h2>
    <span></span>
    <p class="descuento-txt">¡Hasta 40% de descuento!</p>
  </div>
  <div>
    <!-- carrousel de productos -->
    <div class="slider-products-home-bottom">
      <?php
      $args = array(
        'post_type' => 'product',
        'posts_per_page' => 10,
        'order' => 'DESC'
      );

      $the_query = new WP_Query( $args );
      if(count($the_query->posts) > 0){
        foreach ($the_query->posts as $key => $value) {
          $url = $value->guid;
          $prod = wc_get_product($value->ID);
          $image = get_the_post_thumbnail_url($value->ID, 'medium');
          $normal_price = $prod->get_regular_price();
          $down_price = $prod->get_price();
          echo '<div>';
          ?>
          <div class="image" style="background-image: url('<?php echo $image ?>')"><a href="<?php echo $url ?>"></a></div>
          <h3><a href="<?php echo $url ?>"><?php echo cut_string($value->post_title, 26) ?></a></h3>
          <p class="price">

            <?php
            if($normal_price == $down_price){
              echo '<span class="real_price">'.wc_price($normal_price).'</span>';
            }else {
              echo '<span class="normal_price">'.wc_price($normal_price).'</span>';
              echo '<span class="real_price">'.wc_price($down_price).'</span>';
            }
            ?>
          </p>
          <?php
          echo '</div>';
        }
      }

      ?>
    </div>
    <script type="text/javascript">
      jQuery(document).ready(function(){
        jQuery('.slider-products-home-bottom').slick({
          dots: false,
          infinite: true,
          speed: 1000,
          slidesToShow: 5,
          arrows: true,
          autoplay: true,
          autoplaySpeed: 3000,
          cssEase: 'ease'
        });
      })
    </script>

    <!-- carrouser de marcas -->
    <div class="slider-marcas-home-bottom">
      <?php
      dynamic_sidebar( 'marcas' );
      ?>
    </div>
    <script type="text/javascript">
      jQuery(document).ready(function(){
        jQuery('.slider-marcas-home-bottom').slick({
          dots: false,
          infinite: true,
          speed: 1000,
          slidesToShow: 7,
          arrows: true,
          autoplay: true,
          autoplaySpeed: 1000,
          cssEase: 'ease'
        });
      })
    </script>
  </div>
  <div class="custom-title">
    <h2>Nosotros</h2>
    <span></span>
  </div>
  <div class="nosotros-bottom-home">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 page-home">
        <?php
        $page1 = get_page_by_title('¿Qué es casatecno?');
        $image = get_the_post_thumbnail_url($page1->ID, 'medium');
        // var_dump($page1);
        ?>
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="image" style="background-image: url('<?php echo $image?>')"></div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <h3><?php echo $page1->post_title ?></h3>
            <p><?php echo cut_string($page1->post_content, 230); ?></p>
            <a href="nosotros">VER MÁS</a>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 page-home">
        <?php
        $page1 = get_page_by_title('¿Cómo son los productos outlet?');
        $image = get_the_post_thumbnail_url($page1->ID, 'medium');
        // var_dump($page1);
        ?>
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="image" style="background-image: url('<?php echo $image?>')"></div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <h3><?php echo $page1->post_title ?></h3>
            <p><?php echo cut_string($page1->post_content, 230); ?></p>
            <a href="nosotros">VER MÁS</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
