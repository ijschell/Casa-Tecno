<?php
$args = array(
  'post_type' => 'product',
  'posts_per_page' => 3,
  'order' => 'DESC'
);

$loop = new WP_Query( $args );

?>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(). '/custom/custom-slider-home-style.css' ?>">

<div id="home-slider">
  <?php
  while ( $loop->have_posts() ) : $loop->the_post();
    $prod = wc_get_product(get_post()->ID);
    $id = get_post()->ID;
    $slug = get_post()->guid;
    $title = get_post()->post_title;
    $sku = $prod->get_sku();
    $image = get_the_post_thumbnail_url(get_post()->ID, 'medium');
    ?>
    <div class="home-slider-item">
      <div class="info">
        <?php
        if(strlen($title) > 23){
          $title = substr($title, 0, 23) . '...';
        }
        ?>
        <h2><?php echo $title?></h2>
        <p class="suk"><?php echo $sku?></p>
        <a href="<?php echo $slug?>">Consultar</a>
      </div>
      <div class="image">
        <img src="<?php echo $image?>" alt="<?php echo $title?>">
      </div>
    </div>
    <?php
  endwhile;
  ?>
</div>
<script type="text/javascript">
  jQuery(document).ready(function(){
    jQuery('#home-slider').slick({
      dots: true,
      infinite: true,
      speed: 1000,
      slidesToShow: 1,
      arrows: false,
      autoplay: true,
      autoplaySpeed: 4000,
      cssEase: 'ease'
    });
  })
</script>
