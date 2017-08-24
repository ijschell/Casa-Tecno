<!-- aqui mi widget -->
<div style="margin-top: -40px;">
  <div class="slider-home">
    <?php
    the_widget('home_slider');
    ?>
  </div>
  <div class="content-images-home">
    <?php
    dynamic_sidebar( 'primer-imagen-home' );
    dynamic_sidebar( 'segunda-imagen-home' );
    ?>
  </div>
</div>
