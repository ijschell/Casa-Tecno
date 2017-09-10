<footer>
  <div class="footer-top">
    <div>
      <div>
        <img src="<?php echo get_template_directory_uri(). '/images/footer1.png' ?>" alt="">
        <p>Garantías</p>
      </div>
      <div>
        <img src="<?php echo get_template_directory_uri(). '/images/footer4.png' ?>" alt="">
        <p>Devoluciones</p>
      </div>
      <div>
        <img src="<?php echo get_template_directory_uri(). '/images/footer3.png' ?>" alt="">
        <p>Medios de pago</p>
      </div>
      <div>
        <img src="<?php echo get_template_directory_uri(). '/images/footer2.png' ?>" alt="">
        <p>Cómo comprar</p>
      </div>
    </div>
  	</div>
    <?php// var_dump(wp_get_nav_menu_items('28'));?>
    	<div class="footer-bottom">
        <div class="container-wapper">
          <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <h2>INFO</h2>
              <ul class="info">
                <li class="ubicacion"><span>Pilar Panamericana KM 55,5 Ramal Pilar, Colectora 12 de Octubre.	entre El Colibrí y La Carreta. Local 8. Pilar. Bs. As.</span></li>
                <li class="telefono"><span>(0230) 4262810</span></li>
                <li class="mail"><span>info@casatecno.com</span></li>
                <li class="horarios"><span>Lunes a Viernes de 10 a 19 hs. <br />	Sábados de 10 a 14 hs.</span></li>
              </ul>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d26259.224309573463!2d-58.402078732888604!3d-34.644523048710234!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95bccb5af2d5c42f%3A0xab1261cf6e8c2f2d!2sBarracas%2C+CABA%2C+Argentina!5e0!3m2!1ses-419!2suy!4v1503885532133" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <h2>MAPA DEL SITIO</h2>
              <?php					$mapa_sitio = wp_get_nav_menu_items('28');					echo '<ul>';					foreach ($mapa_sitio as $key => $value) {						echo '<li><a href="'.$value->url.'">'.$value->title.'</a></li>';					}					echo '</ul>';					?>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <h2>NEWSLETTER</h2>
              <p>Registrate para recibir ofertas imperdibles!</p>
              <?php es_subbox($namefield = "NO", $desc = "", $group = "Public"); ?>
              <script type="text/javascript">
              jQuery(document).ready(function(){
                jQuery('footer div.footer-bottom form.es_shortcode_form .es_button input').attr('value', '');
                jQuery('footer div.footer-bottom form.es_shortcode_form .es_textbox input').attr('placeholder', 'Ingrese su email');						})
                </script>
                <p>SEGUINOS EN FACEBOOK!</p>
                <a href="#" class="facebook"></a>
              </div>
            </div>
          </div>
        </div>
        <div class="footer-under">
          <p>Copyright @<?php echo date('Y')?>. <span>CasaTecno.</span> Todos los derechos reservados.</p>
        </div>
      </footer>
      <div id="menu-mobile" class="hidden-lg">
        <?php
        wp_nav_menu( array(
            'menu'            => 'primary',
            'theme_location'  => 'primary',
            'depth'           => 3,
            'container'       => '',
            'container_class' => '',
            'container_id'    => '',
            'menu_class'      => 'clone-main-menu smarket-nav main-menu center',
            'fallback_cb'     => 'Smarket_navwalker::fallback',
            'walker'          => new Smarket_navwalker(),
          )
        );
        ?>
      </div>
      <?php smarket_get_footer();?><a href="#" class="backtotop"><i class="fa fa-angle-up" aria-hidden="true"></i></a><?php wp_footer(); ?></body></html>
      <script src="<?php echo get_template_directory_uri() . '/js/custom.js'?>" charset="utf-8"></script>
</body>
</html>
