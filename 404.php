<!DOCTYPE html>
<html style="height: 100%;">
  <head>
    <title>404 - Casa Tecno Error</title>
    <!-- <link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/fonts/fonts.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/css/bootstrap.min.css'?>">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/css/custom.css'?>">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/css/custom-footer.css'?>"> -->
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
  	<meta name="viewport" content="width=device-width, initial-scale=1" />
  	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
  	<link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/fonts/fonts.css">
  	<link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/css/slick.css">
  	<link rel="profile" href="http://gmpg.org/xfn/11" />
  	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
  	<link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/css/custom-footer.css">
  	<?php wp_head(); ?>
  </head>
  <body class="error-404">
    <div class="full-height">
      <div class="container-404">
        <h1>404</h1>
        <h2>Esta no es la sección que buscas</h2>
        <p>Por favor, pruebe una de las siguientes páginas <a class="btn-404-inicio" href="<?php echo get_site_url();?>">Inicio</a></p>
        <form action="<?php echo get_site_url();?>" method="get">
          <input type="text" name="s" value="" placeholder="Ingrese su búsqueda">
          <input type="submit" class="btn-404-enviar" name="" value="">
        </form>
      </div>
    </div>
    <?php get_footer();?>
