<?phpif ( !isset( $content_width ) ) $content_width = 900;if ( !class_exists( 'Smarket_Functions' ) ) {	class Smarket_Functions	{		/**		 * Instance of the class.		 *		 * @since   1.0.0		 *		 * @var   object		 */		protected static $instance = null;		/**		 * Initialize the plugin by setting localization and loading public scripts		 * and styles.		 *		 * @since    1.0.0		 */		public function __construct()		{			add_action( 'after_setup_theme', array( $this, 'settup' ) );			add_action( 'widgets_init', array( $this, 'widgets_init' ) );			add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );			add_action( 'admin_enqueue_scripts', array( &$this, 'admin_scripts' ) );			add_filter( 'get_default_comment_status', array( $this, 'open_default_comments_for_page' ), 10, 3 );			add_filter( 'comment_form_fields', array( &$this, 'smarket_move_comment_field_to_bottom' ), 10, 3 );			$this->includes();		}		public function settup()		{			/*			* Make theme available for translation.			* Translations can be filed in the /languages/ directory.			* If you're building a theme based on boutique, use a find and replace			* to change 'smarket' to the name of your theme in all the template files			*/			load_theme_textdomain( 'smarket', get_template_directory() . '/languages' );			// Add default posts and comments RSS feed links to head.			add_theme_support( 'automatic-feed-links' );			/*			 * Let WordPress manage the document title.			 * By adding theme support, we declare that this theme does not use a			 * hard-coded <title> tag in the document head, and expect WordPress to			 * provide it for us.			 */			add_theme_support( 'title-tag' );			/*			 * Enable support for Post Thumbnails on posts and pages.			 *			 * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails			 */			add_theme_support( 'post-thumbnails' );			set_post_thumbnail_size( 825, 510, true );			/*This theme uses wp_nav_menu() in two locations.*/			register_nav_menus( array(					'primary'        => esc_html__( 'Primary Menu', 'smarket' ),					'vertical_menu'  => esc_html__( 'Vertical Menu', 'smarket' ),					'top_right_menu' => esc_html__( 'Top bar right menu', 'smarket' ),				)			);			/*			 * Switch default core markup for search form, comment form, and comments			 * to output valid HTML5.			 */			add_theme_support( 'html5', array(					'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',				)			);			add_theme_support( 'post-thumbnails' );			add_theme_support( "custom-header" );			add_theme_support( "custom-background" );			add_editor_style( array( 'css/style.css', $this->google_fonts_url() ) );			/*Support woocommerce*/			add_theme_support( 'woocommerce' );			add_theme_support( 'wc-product-gallery-lightbox' );			add_theme_support( 'wc-product-gallery-slider' );			add_theme_support( 'wc-product-gallery-zoom' );		}		public function smarket_move_comment_field_to_bottom( $fields )		{			$comment_field = $fields[ 'comment' ];			unset( $fields[ 'comment' ] );			$fields[ 'comment' ] = $comment_field;			return $fields;		}		/**		 * Register widget area.		 *		 * @since Smarket 1.0		 *		 * @link https://codex.wordpress.org/Function_Reference/register_sidebar		 */		function widgets_init()		{			register_sidebar( array(					'name'          => esc_html__( 'Widget Area', 'smarket' ),					'id'            => 'widget-area',					'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'smarket' ),					'before_widget' => '<div id="%1$s" class="widget %2$s">',					'after_widget'  => '</div>',					'before_title'  => '<h2 class="widgettitle">',					'after_title'   => '<span class="arow"></span></h2>',				)			);			register_sidebar( array(					'name'          => esc_html__( 'Shop Widget Area', 'smarket' ),					'id'            => 'shop-widget-area',					'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'smarket' ),					'before_widget' => '<div id="%1$s" class="widget %2$s">',					'after_widget'  => '</div>',					'before_title'  => '<h2 class="widgettitle">',					'after_title'   => '<span class="arow"></span></h2>',				)			);			register_sidebar( array(					'name'          => esc_html__( 'Page Widget Area', 'smarket' ),					'id'            => 'page-widget-area',					'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'smarket' ),					'before_widget' => '<div id="%1$s" class="widget %2$s">',					'after_widget'  => '</div>',					'before_title'  => '<h2 class="widgettitle">',					'after_title'   => '<span class="arow"></span></h2>',				)			);			register_sidebar( array(					'name'          => esc_html__( 'Single Product Widget', 'smarket' ),					'id'            => 'single-product-widget',					'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'smarket' ),					'before_widget' => '<div id="%1$s" class="widget %2$s">',					'after_widget'  => '</div>',					'before_title'  => '<h2 class="widgettitle">',					'after_title'   => '<span class="arow"></span></h2>',				)			);		}		/*Load Google fonts*/		function google_fonts_url()		{			$fonts_url       = '';			$font_families   = array();			$font_families[] = 'Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i';			$query_args = array(				'family' => implode( '|', $font_families ),				'subset' => 'latin,latin-ext',			);			$fonts_url  = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );			return esc_url_raw( $fonts_url );		}		function admin_scripts()		{			wp_enqueue_style( 'admin-pe-icon-7-stroke', trailingslashit( get_template_directory_uri() ) . 'css/pe-icon-7-stroke.min.css', array(), '1.0' );		}		/**		 * Enqueue scripts and styles.		 *		 * @since smarket 1.0		 */		function scripts()		{			// Load fonts			wp_enqueue_style( 'smarket-googlefonts', $this->google_fonts_url(), array(), null );			/*Load our main stylesheet.*/			wp_enqueue_style( 'init-style', trailingslashit( get_template_directory_uri() ) . 'css/init-style.css', array(), '1.0' );			wp_enqueue_style( 'flaticon', trailingslashit( get_template_directory_uri() ) . 'fonts/flaticon/font/flaticon.min.css', array(), '1.0' );			wp_enqueue_style( 'smarket-style', trailingslashit( get_template_directory_uri() ) . 'css/style.min.css', array(), '1.0' );			wp_enqueue_style( 'smarket-main-style', get_stylesheet_uri() );			wp_enqueue_style( 'custom-style', trailingslashit( get_template_directory_uri() ) . 'css/custom.css', array(), '1.0' );			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {				wp_enqueue_script( 'comment-reply' );			}			/*Load lib js*/			wp_enqueue_script( 'imagesloaded' );			$opt_gmap_api_key = smarket_option( 'opt_gmap_api_key', '' );			$opt_gmap_api_key = trim( $opt_gmap_api_key );			wp_enqueue_script( 'maps', esc_url( 'https://maps.googleapis.com/maps/api/js?key=' . $opt_gmap_api_key ), array( 'jquery' ), null, true );			wp_enqueue_script( 'smarket-init', trailingslashit( get_template_directory_uri() ) . 'js/init-script.js', array( 'jquery' ), '2.4', true );			wp_enqueue_script( 'smarket-script', get_template_directory_uri() . '/js/functions.min.js', array( 'jquery' ), '1.0', true );			wp_localize_script( 'smarket-script', 'smarket_ajax_frontend', array(					'ajaxurl'  => admin_url( 'admin-ajax.php' ),					'security' => wp_create_nonce( 'smarket_ajax_frontend' ),				)			);			$smarket_enable_sticky_menu  = smarket_option( 'smarket_enable_sticky_menu', 1 );			$smarket_enable_popup_mobile = smarket_option( 'smarket_enable_popup_mobile', 0 );			$smarket_popup_delay_time    = smarket_option( 'smarket_popup_delay_time', 0 );			$smarket_enable_popup        = smarket_option( 'smarket_enable_popup', 0 );			$smarket_enable_lazy         = smarket_option( 'smarket_enable_lazy', 1 );			$smarket_spacing_sticky      = smarket_option( 'smarket_spacing_sticky', '60' );			wp_localize_script( 'smarket-script', 'smarket_fontend_global_script', array(					'smarket_enable_sticky_menu'  => $smarket_enable_sticky_menu,					'smarket_enable_popup'        => $smarket_enable_popup,					'smarket_popup_delay_time'    => $smarket_popup_delay_time,					'smarket_enable_popup_mobile' => $smarket_enable_popup_mobile,					'smarket_enable_lazy'         => $smarket_enable_lazy,					'smarket_spacing_sticky'      => $smarket_spacing_sticky,				)			);		}		/**		 * Filter whether comments are open for a given post type.		 *		 * @param string $status Default status for the given post type,		 *                             either 'open' or 'closed'.		 * @param string $post_type Post type. Default is `post`.		 * @param string $comment_type Type of comment. Default is `comment`.		 * @return string (Maybe) filtered default status for the given post type.		 */		function open_default_comments_for_page( $status, $post_type, $comment_type )		{			if ( 'page' == $post_type ) {				return 'open';			}			return $status;			/*You could be more specific here for different comment types if desired*/		}		public function includes()		{			include_once( get_template_directory() . '/framework/framework.php' );		}	}	new  Smarket_Functions();}// custom widgetsinclude get_template_directory() . '/custom/custom-widget.php';function cut_string($string, $letters){	$result = $string;	if(strlen($string) > $letters){		$result = substr($string, 0, $letters) . '...';	}		return $result;}
  include get_template_directory() . '/custom/custom-widget-marcas.php';

add_action( 'init', 'create_product_taxonomies', 0 );

function create_product_taxonomies(){
  $labels = array(
		'name'              => _x( 'Marcas', 'marcas', 'textdomain' ),
		'singular_name'     => _x( 'Marca', 'marca', 'textdomain' ),
		'search_items'      => __( 'Buscar Marcas', 'textdomain' ),
		'all_items'         => __( 'Todas las Marcas', 'textdomain' ),
		'edit_item'         => __( 'Editar Marca', 'textdomain' ),
		'update_item'       => __( 'Actualizar Marca', 'textdomain' ),
		'add_new_item'      => __( 'Agregar nueva Marca', 'textdomain' ),
		'new_item_name'     => __( 'Nombre de nueva Marca', 'textdomain' ),
		'menu_name'         => __( 'Marcas', 'textdomain' ),
	);
  $args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'marca' ),
	);
  register_taxonomy( 'marca', array( 'product' ), $args );
}
/*
// Our custom post type function
function blog_post_type() {

    register_post_type( 'blog',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Blog' ),
                'singular_name' => __( 'Blog Post' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'blog'),
            'supports' => array( 'title', 'editor', 'author', 'thumbnail'),
        )
    );
}
// Hooking up our function to theme setup
add_action( 'init', 'blog_post_type' );
*/
