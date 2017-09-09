<?php
// $marcas = get_terms('marca');
?>
<h2 class="widgettitle">Marcas<span class="arow"></span></h2>
<?php
$marcas = get_posts(array(
  'post_type' => 'marcas',
  'posts_per_page' => -1
));
// var_dump($marcas);
// dynamic_sidebar( 'marcas' );
?>
<ul class="ms-accordion">
  <?php
  if(!empty($marcas)){
    foreach ($marcas as $key => $value) {
      ?>
        <li><a href="<?php echo get_site_url()?>/marcas/<?php echo $value->post_name?>"><?php echo $value->post_title?></a></li>
      <?php
    }
  }
  ?>
</ul>
