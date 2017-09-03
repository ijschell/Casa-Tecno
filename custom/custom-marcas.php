<?php
$marcas = get_terms('marca');
?>
<h2 class="widgettitle">Marcas<span class="arow"></span></h2>
<ul class="ms-accordion">
  <?php
  foreach ($marcas as $key => $value) {
    echo '<li><a href="#">'.$value->name.'</a></li>';
  }
  ?>
</ul>
