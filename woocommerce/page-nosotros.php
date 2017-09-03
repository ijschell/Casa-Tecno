<?php
/**
 * Template Name: Sobre Nosotros
 */
 get_header();

 include get_template_directory(). '/templates/data-page-nosotros.php';
?>
<style media="screen">
  footer div.footer-top{
    display: none;
  }
</style>
<div class="main-container nosotros">
  <div class="container-wapper">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
      <div class="image" style="background-image: url('<?php echo $quees['image'] ?>')"></div>
      <h2><?php echo $quees['post']->post_title?></h2>
      <p><?php echo wpautop($quees['post']->post_content)?></p>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
      <div class="image" style="background-image: url('<?php echo $comoson['image'] ?>')"></div>
      <h2><?php echo $comoson['post']->post_title?></h2>
      <p><?php echo wpautop($comoson['post']->post_content)?></p>
    </div>
  </div>
  <hr>
  <div class="container-wapper">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 foot">
      <div class="image" style="background-image: url('<?php echo $garantia['image'] ?>')"></div>
      <h2><?php echo $garantia['post']->post_title?></h2>
      <p><?php echo wpautop($garantia['post']->post_content)?></p>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 foot">
      <div class="image" style="background-image: url('<?php echo $comprar_pagar['image'] ?>')"></div>
      <h2><?php echo $comprar_pagar['post']->post_title?></h2>
      <p><?php echo wpautop($comprar_pagar['post']->post_content)?></p>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 foot">
      <div class="image" style="background-image: url('<?php echo $devolucion['image'] ?>')"></div>
      <h2><?php echo $devolucion['post']->post_title?></h2>
      <p><?php echo wpautop($devolucion['post']->post_content)?></p>
    </div>
  </div>
</div>

<?php
get_footer();
?>
