<?php
// widgt slider home
function marcas_widget() {
  register_widget( 'marcas_widget' );
}
add_action( 'widgets_init', 'marcas_widget' );

// Creating the widget
class marcas_widget extends WP_Widget {

  function __construct() {
    parent::__construct(

      // Base ID of your widget
      'marcas_widget',

      // Widget name will appear in UI
      __('Widget Marcas', 'marcas_widget_domain'),

      // Widget description
      array( 'description' => __( 'Widget para marcas de productos', 'marcas_widget_domain' ), )
    );
  }

  // Creating widget front-end

  public function widget( $args, $instance ) {
    $title = apply_filters( 'widget_title', $instance['title'] );

    // before and after widget arguments are defined by themes
    echo $args['before_widget'];
    if ( ! empty( $title ) )
    echo $args['before_title'] . $title . $args['after_title'];

    // This is where you run the code and display the output
    // echo __( 'Hello, World!', 'home_slider_domain' );
    include get_template_directory() . '/custom/custom-marcas.php';
    echo $args['after_widget'];
  }

  // Widget Backend


  // Updating widget replacing old instances with new
  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    return $instance;
  }
} // Class home_slider ends here
?>
