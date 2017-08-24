<?php
// widgt slider home
function home_slider() {
  register_widget( 'home_slider' );
}
add_action( 'widgets_init', 'home_slider' );

// Creating the widget
class home_slider extends WP_Widget {

  function __construct() {
    parent::__construct(

      // Base ID of your widget
      'home_slider',

      // Widget name will appear in UI
      __('Slider Home', 'home_slider_domain'),

      // Widget description
      array( 'description' => __( 'Sample widget based on WPBeginner Tutorial', 'home_slider_domain' ), )
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
    include get_template_directory() . '/custom/custom-slider-home.php';
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
