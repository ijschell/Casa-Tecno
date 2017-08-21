<?php

if ( !class_exists( 'Smarket_ThemeOptions' ) ) {
	class Smarket_ThemeOptions
	{

		public $args           = array();
		public $sections       = array();
		public $theme;
		public $ReduxFramework;
		public $sidebars       = array();
		public $header_options = array();
		public $socials        = array();

		public function __construct()
		{
			if ( !class_exists( "ReduxFramework" ) ) {
				return;
			}
			$this->get_socials();
			$this->get_sidebars();
			$this->get_header_options();
			$this->get_footer_options();
			$this->initSettings();
		}

		public function get_socials()
		{
			if ( function_exists( 'smarket_get_all_social' ) ) {
				$all_socials = smarket_get_all_social();
				foreach ( $all_socials as $social ) {
					$this->socials[ $social[ 'id' ] ] = $social[ 'name' ];
				}
			}

		}

		public function get_sidebars()
		{
			global $wp_registered_sidebars;
			foreach ( $wp_registered_sidebars as $sidebar ) {
				$sidebars[ $sidebar[ 'id' ] ] = $sidebar[ 'name' ];
			}
			$this->sidebars = $sidebars;
		}

		public function get_header_options()
		{
			$layoutDir      = get_template_directory() . '/templates/headers/';
			$header_options = array();

			if ( is_dir( $layoutDir ) ) {
				$files = scandir( $layoutDir );
				if ( $files && is_array( $files ) ) {
					$option = '';
					foreach ( $files as $file ) {
						if ( $file != '.' && $file != '..' ) {
							$fileInfo = pathinfo( $file );
							if ( $fileInfo[ 'extension' ] == 'php' && $fileInfo[ 'basename' ] != 'index.php' ) {
								$file_data                    = get_file_data( $layoutDir . $file, array( 'Name' => 'Name' ) );
								$file_name                    = str_replace( 'header-', '', $fileInfo[ 'filename' ] );
								$header_options[ $file_name ] = array(
									'title'   => $file_data[ 'Name' ],
									'preview' => get_template_directory_uri() . '/templates/headers/header-' . $file_name . '.jpg',
								);
							}
						}
					}
				}
			}
			$this->header_options = $header_options;
		}

		public function get_footer_options()
		{
			$footer_options = array();
			$args           = array(
				'post_type'      => array( 'footer' ),
				'posts_per_page' => -1,
				'orderby'        => 'title',
				'order'          => 'ASC',
			);

			$loop  = new wp_query( $args );
			$loops = $loop->get_posts();

			foreach ( $loops as $loop ) {
				$thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id( $loop->ID ), 'full', true );

				$footer_options[ $loop->ID ] = array(
					'title'   => $loop->post_title,
					'preview' => $thumb_url[ 0 ],
				);
			}

			$this->footer_options = $footer_options;
		}

		public function initSettings()
		{

			// Just for demo purposes. Not needed per say.
			$this->theme = wp_get_theme();

			// Set the default arguments
			$this->setArguments();

			// Set a few help tabs so you can see how it's done
			$this->setHelpTabs();

			// Create the sections and fields
			$this->setSections();

			if ( !isset( $this->args[ 'opt_name' ] ) ) { // No errors please
				return;
			}

			// If Redux is running as a plugin, this will remove the demo notice and links
			//add_action( 'redux/loaded', array( $this, 'remove_demo' ) );

			// Function to test the compiler hook and demo CSS output.
			//add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 2);
			// Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
			// Change the arguments after they've been declared, but before the panel is created
			//add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
			// Change the default value of a field after it's been set, but before it's been useds
			//add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );
			// Dynamically add a section. Can be also used to modify sections/fields
			//add_filter( 'redux/options/' . $this->args['opt_name'] . '/sections', array( $this, 'dynamic_section' ) );

			$sections = array_values( apply_filters( 'smarket_all_theme_option_sections', $this->sections ) );

			$this->ReduxFramework = new ReduxFramework( $sections, $this->args );
		}

		/**
		 *
		 * This is a test function that will let you see when the compiler hook occurs.
		 * It only runs if a field   set with compiler=>true is changed.
		 * */
		function compiler_action( $options, $css )
		{

		}

		function ts_redux_update_options_user_can_register( $options, $css )
		{
			global $smarket;
			$users_can_register = isset( $smarket[ 'opt-users-can-register' ] ) ? $smarket[ 'opt-users-can-register' ] : 0;
			update_option( 'users_can_register', $users_can_register );
		}

		/**
		 *
		 * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
		 * Simply include this function in the child themes functions.php file.
		 *
		 * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
		 * so you must use get_template_directory_uri() if you want to use any of the built in icons
		 * */
		function dynamic_section( $sections )
		{
			//$sections = array();
			$sections[] = array(
				'title'  => esc_html__( 'Section via hook', 'smarket' ),
				'desc'   => wp_kses( esc_html__( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'smarket' ), array( 'p' => array( 'class' => array() ) ) ),
				'icon'   => 'el-icon-paper-clip',
				// Leave this as a blank section, no options just some intro text set above.
				'fields' => array(),
			);

			return $sections;
		}

		/**
		 *
		 * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
		 * */
		function change_arguments( $args )
		{
			//$args['dev_mode'] = true;

			return $args;
		}

		/**
		 *
		 * Filter hook for filtering the default value of any given field. Very useful in development mode.
		 * */
		function change_defaults( $defaults )
		{
			$defaults[ 'str_replace' ] = "Testing filter hook!";

			return $defaults;
		}

		// Remove the demo link and the notice of integrated demo from the redux-framework plugin
		function remove_demo()
		{

			// Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
			if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
				remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::instance(), 'plugin_metalinks' ), null, 2 );

				// Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
				remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );

			}
		}

		public function setSections()
		{

			ob_start();

			$ct          = wp_get_theme();
			$this->theme = $ct;
			$item_name   = $this->theme->get( 'Name' );
			$tags        = $this->theme->Tags;
			$screenshot  = $this->theme->get_screenshot();
			$class       = $screenshot ? 'has-screenshot' : '';

			$customize_title = sprintf( esc_html__( 'Customize &#8220;%s&#8221;', 'smarket' ), $this->theme->display( 'Name' ) );
			?>
            <div id="current-theme" class="<?php echo esc_attr( $class ); ?>">
				<?php if ( $screenshot ) : ?>
					<?php if ( current_user_can( 'edit_theme_options' ) ) : ?>
                        <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize"
                           title="<?php echo esc_attr( $customize_title ); ?>">
                            <img src="<?php echo esc_url( $screenshot ); ?>"
                                 alt="<?php esc_attr_e( 'Current theme preview', 'smarket' ); ?>"/>
                        </a>
					<?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url( $screenshot ); ?>"
                         alt="<?php esc_attr_e( 'Current theme preview', 'smarket' ); ?>"/>
				<?php endif; ?>

                <h4>
					<?php echo sanitize_text_field( $this->theme->display( 'Name' ) ); ?>
                </h4>

                <div>
                    <ul class="theme-info">
                        <li><?php printf( esc_html__( 'By %s', 'smarket' ), $this->theme->display( 'Author' ) ); ?></li>
                        <li><?php printf( esc_html__( 'Version %s', 'smarket' ), $this->theme->display( 'Version' ) ); ?></li>
                        <li><?php echo '<strong>' . esc_html__( 'Tags', 'smarket' ) . ':</strong> '; ?><?php printf( $this->theme->display( 'Tags' ) ); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo esc_attr( $this->theme->display( 'Description' ) ); ?></p>
					<?php
					if ( $this->theme->parent() ) {
						printf(
							' <p class="howto">' . wp_kses( esc_html__( 'This <a href="%1$s">child theme</a> requires its parent theme, %2$s.', 'smarket' ), array( 'a' => array( 'href' => array() ) ) ) . '</p>', esc_html__( 'http://codex.wordpress.org/Child_Themes', 'smarket' ), $this->theme->parent()
							->display( 'Name' )
						);
					}
					?>

                </div>

            </div>

			<?php
			$item_info = ob_get_contents();

			ob_end_clean();

			/*--General Settings--*/
			$this->sections[] = array(
				'title'            => esc_html__( 'General', 'smarket' ),
				'id'               => 'general',
				'desc'             => esc_html__( 'This General Setings', 'smarket' ),
				'customizer_width' => '400px',
				'icon'             => 'el-icon-wordpress',
			);
			/* Logo */
			$this->sections[] = array(
				'title'            => esc_html__( 'Logo', 'smarket' ),
				'id'               => 'logo',
				'subsection'       => true,
				'customizer_width' => '450px',
				'desc'             => esc_html__( 'Setting logo of site', 'smarket' ),
				'fields'           => array(
					array(
						'id'       => 'smarket_logo',
						'type'     => 'media',
						'url'      => true,
						'title'    => esc_html__( 'Logo', 'smarket' ),
						'compiler' => 'true',
						//'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
						'desc'     => esc_html__( 'Basic media uploader with disabled URL input field.', 'smarket' ),
						'subtitle' => esc_html__( 'Upload any media using the WordPress native uploader', 'smarket' ),
						'default'  => array( 'url' => get_template_directory_uri() . '/images/logo.png' ),
					),
				),
			);
			/* Color */
			$this->sections[] = array(
				'title'      => esc_html__( 'Color', 'smarket' ),
				'desc'       => esc_html__( 'Setting Color of site ', 'smarket' ),
				'id'         => 'site-color',
				'subsection' => true,
				'fields'     => array(
					array(
						'id'       => 'smarket_main_color',
						'type'     => 'color',
						'title'    => esc_html__( 'Main site Color', 'smarket' ),
						'subtitle' => esc_html__( 'Pick a background color for the theme (default: #fcd022).', 'smarket' ),
						'default'  => '#ff7f00',
						'validate' => 'color',
					),
					array(
						'id'       => 'smarket_main_color2',
						'type'     => 'color',
						'title'    => esc_html__( 'Main site Color 2', 'smarket' ),
						'subtitle' => esc_html__( 'Pick a background color for the theme (default: #e5b700).', 'smarket' ),
						'default'  => '#ff9933',
						'validate' => 'color',
					),
					array(
						'id'       => 'smarket_button_hover_color',
						'type'     => 'color',
						'title'    => esc_html__( 'Main site Color 3', 'smarket' ),
						'default'  => '#222',
						'validate' => 'color',
					),
				),
			);
			/* Custom 404 */
			$this->sections[] = array(
				'title'      => esc_html__( '404', 'smarket' ),
				'desc'       => esc_html__( 'Custom 404 your site ', 'smarket' ),
				'id'         => 'custom-404',
				'subsection' => true,
				'fields'     => array(
					array(
						'title'   => esc_html__( '404 Logo', 'smarket' ),
						'id'      => '404_logo',
						'type'    => 'media',
					),
					array(
						'title'   => esc_html__( 'Background', 'smarket' ),
						'id'      => '404_background',
						'type'    => 'media',
						'default' => array( 'url' => get_template_directory_uri() . '/images/comming-soon.jpg' ),
					),
					array(
						'title'   => esc_html__( 'title', 'smarket' ),
						'id'      => 'title',
						'type'    => 'text',
						'default' => "404",
					),
					array(
						'title'   => esc_html__( 'Sub Title', 'smarket' ),
						'id'      => 'subtitle',
						'type'    => 'editor',
						'args'    => array(
							'teeny'         => true,
							'textarea_rows' => 10,
						),
						'default' => "This's Not The Web Page You're Looking For",
					),
					array(
						'title'   => esc_html__( 'Footer', 'smarket' ),
						'id'      => 'footer_404',
						'type'    => 'editor',
						'args'    => array(
							'teeny'         => true,
							'textarea_rows' => 10,
						),
						'default' => esc_html__( '&copy; 2017 Maxstore Kutethemes. All rights reserved', 'smarket' ),
					),
				),
			);
			/* Coming soon */
			$this->sections[] = array(
				'title'      => esc_html__( 'Coming Soon !', 'smarket' ),
				'id'         => 'coming_soon',
				'subsection' => true,
				'fields'     => array(
					array(
						'title'   => esc_html__( 'Enable Coming Soon !', 'smarket' ),
						'id'      => 'enable_coming_soon',
						'type'    => 'switch',
						'default' => '0',
						'on'      => esc_html__( 'Enable', 'smarket' ),
						'off'     => esc_html__( 'Disable', 'smarket' ),
					),
					array(
						'title'    => esc_html__( 'Coming Soon Logo', 'smarket' ),
						'id'       => 'logo_coming_soon',
						'type'     => 'media',
						'default'  => array( 'url' => get_template_directory_uri() . '/images/logo.png' ),
						'required' => array( 'enable_coming_soon', '=', array( '1' ) ),
					),
					array(
						'title'    => esc_html__( 'Coming Soon Background', 'smarket' ),
						'id'       => 'coming_soon_background',
						'type'     => 'media',
						'default'  => array( 'url' => get_template_directory_uri() . '/images/comming-soon.jpg' ),
						'required' => array( 'enable_coming_soon', '=', array( '1' ) ),
					),
					array(
						'title'    => esc_html__( 'Title', 'smarket' ),
						'id'       => 'coming_soon_title',
						'type'     => 'text',
						'default'  => esc_html__( "This&rsquo;s The Site Under Construction", 'smarket' ),
						'required' => array( 'enable_coming_soon', '=', array( '1' ) ),
					),
					array(
						'title'    => esc_html__( 'Description', 'smarket' ),
						'id'       => 'coming_soon_des',
						'type'     => 'editor',
						'args'     => array(
							'teeny'         => true,
							'textarea_rows' => 10,
						),
						'default'  => esc_html__( "We&rsquo;re working one some improvements and will come back in", 'smarket' ),
						'required' => array( 'enable_coming_soon', '=', array( '1' ) ),
					),
					array(
						'id'          => 'coming_soon_date',
						'type'        => 'date',
						'title'       => esc_html__( 'Date Option', 'smarket' ),
						'placeholder' => 'Click to enter a date',
						'required'    => array( 'enable_coming_soon', '=', array( '1' ) ),
					),
					array(
						'id'       => 'coming_soon_footer',
						'type'     => 'editor',
						'title'    => esc_html__( 'Footer Coming Soon', 'smarket' ),
						'default'  => esc_html__( '&copy; 2017 Maxstore Kutethemes. All rights reserved', 'smarket' ),
						'args'     => array(
							'teeny'         => true,
							'textarea_rows' => 10,
						),
						'required' => array( 'enable_coming_soon', '=', array( '1' ) ),
					),
					array(
						'id'       => 'opt_disable_coming_soon_when_date_small',
						'type'     => 'switch',
						'title'    => esc_html__( 'Coming soon when count down date expired', 'smarket' ),
						'default'  => 1,
						'on'       => esc_html__( 'Disable coming soon', 'smarket' ),
						'off'      => esc_html__( "Don't disable coming soon", 'smarket' ),
						'required' => array( 'enable_coming_soon', '=', array( '1' ) ),
					),
				),
			);
			/* Custom css, js */
			$this->sections[] = array(
				'title'      => esc_html__( 'Custom CSS/JS', 'smarket' ),
				'desc'       => esc_html__( 'Custom css,js your site ', 'smarket' ),
				'id'         => 'custom-css-js',
				'subsection' => true,
				'fields'     => array(
					array(
						'id'       => 'smarket_custom_css',
						'type'     => 'ace_editor',
						'title'    => esc_html__( 'Custom CSS', 'smarket' ),
						'subtitle' => esc_html__( 'Paste your custom CSS code here.', 'smarket' ),
						'mode'     => 'css',
						'theme'    => 'monokai',
						'desc'     => 'Custom css code.',
						'default'  => "",
					),
					array(
						'id'       => 'smarket_custom_js',
						'type'     => 'ace_editor',
						'title'    => esc_html__( 'Custom JS ', 'smarket' ),
						'subtitle' => esc_html__( 'Paste your custom JS code here.', 'smarket' ),
						'mode'     => 'javascript',
						'theme'    => 'chrome',
						'desc'     => 'Custom javascript code',
						//'default' => "jQuery(document).ready(function(){\n\n});"
					),
				),
			);
			$this->sections[] = array(
				'title'      => esc_html__( 'Developer', 'smarket' ),
				'desc'       => esc_html__( 'Developer', 'smarket' ),
				'id'         => 'developer',
				'subsection' => true,
				'fields'     => array(
					array(
						'id'      => 'smarket_dev_mode',
						'type'    => 'switch',
						'title'   => esc_html__( 'Developer Mode', 'smarket' ),
						'default' => '0',
						'on'      => esc_html__( 'On', 'smarket' ),
						'off'     => esc_html__( 'Off', 'smarket' ),
					),
				),
			);

			$this->sections[] = array(
				'title'            => esc_html__( 'Header', 'smarket' ),
				'id'               => 'header',
				'desc'             => esc_html__( 'Header Setings', 'smarket' ),
				'customizer_width' => '400px',
				'icon'             => 'el el-folder-open',
				'fields'           => array(
					array(
						'id'       => 'smarket_used_header',
						'type'     => 'select_preview',
						'title'    => esc_html__( 'Header Layout', 'smarket' ),
						'subtitle' => esc_html__( 'Select a header layout', 'smarket' ),
						'options'  => $this->header_options,
						'default'  => 'style-01',
					),
					array(
						'id'      => 'smarket_enable_sticky_menu',
						'type'    => 'switch',
						'title'   => esc_html__( 'Main Menu Sticky', 'smarket' ),
						'default' => '1',
						'on'      => esc_html__( 'On', 'smarket' ),
						'off'     => esc_html__( 'Off', 'smarket' ),
					),
					array(
						'title'   => esc_html__( 'Hotline', 'smarket' ),
						'id'      => 'opt_hotline',
						'type'    => 'text',
					),
					array(
						'title'   => esc_html__( 'Email', 'smarket' ),
						'id'      => 'opt_email',
						'type'    => 'text',
					),
				),
			);
			$this->sections[] = array(
				'title'      => esc_html__( 'Vertical Menu Settings', 'smarket' ),
				'desc'       => esc_html__( 'Vertical Menu Settings', 'smarket' ),
				'subsection' => true,
				'fields'     => array(
					array(
						'title'    => esc_html__( 'Use Vertical Menu', 'smarket' ),
						'id'       => 'opt_enable_vertical_menu',
						'type'     => 'switch',
						'default'  => '1',
						'on'       => esc_html__( 'Enable', 'smarket' ),
						'off'      => esc_html__( 'Disable', 'smarket' ),
						'subtitle' => esc_html__( 'Use Vertical Menu on show any page', 'smarket' ),
					),
					array(
						'title'    => esc_html__( 'Vertical Menu Title', 'smarket' ),
						'id'       => 'opt_vertical_menu_title',
						'type'     => 'text',
						'default'  => esc_html__( 'Shop By Category', 'smarket' ),
						'required' => array( 'opt_enable_vertical_menu', '=', '1' ),
					),
					array(
						'title'    => esc_html__( 'Vertical Menu Button show all text', 'smarket' ),
						'id'       => 'opt_vertical_menu_button_all_text',
						'type'     => 'text',
						'default'  => esc_html__( 'All Categories', 'smarket' ),
						'required' => array( 'opt_enable_vertical_menu', '=', '1' ),
					),

					array(
						'title'    => esc_html__( 'Vertical Menu Button close text', 'smarket' ),
						'id'       => 'opt_vertical_menu_button_close_text',
						'type'     => 'text',
						'default'  => esc_html__( 'Close', 'smarket' ),
						'required' => array( 'opt_enable_vertical_menu', '=', '1' ),
					),
					array(
						'title'    => esc_html__( 'Collapse', 'smarket' ),
						'id'       => 'opt_click_open_vertical_menu',
						'type'     => 'switch',
						'default'  => '1',
						'on'       => esc_html__( 'Enable', 'smarket' ),
						'off'      => esc_html__( 'Disable', 'smarket' ),
						'subtitle' => esc_html__( 'Vertical menu will expand on click', 'smarket' ),
						'required' => array( 'opt_enable_vertical_menu', '=', '1' ),
					),

					array(
						'title'    => esc_html__( 'The number of visible vertical menu items', 'smarket' ),
						'subtitle' => esc_html__( 'The number of visible vertical menu items', 'smarket' ),
						'id'       => 'opt_vertical_item_visible',
						'default'  => 10,
						'type'     => 'text',
						'validate' => 'numeric',
						'required' => array( 'opt_enable_vertical_menu', '=', '1' ),
					),
				),
			);
			// -> Footer Settings

			$this->sections[] = array(
				'title'  => esc_html__( 'Footer Settings', 'smarket' ),
				'desc'   => esc_html__( 'Footer Settings', 'smarket' ),
				'icon'   => 'el el-folder-open',
				'fields' => array(
					array(
						'id'      => 'smarket_footer_style',
						'type'    => 'select_preview',
						'title'   => esc_html__( 'Footer Display', 'smarket' ),
						'options' => $this->footer_options,
						'default' => '',
					),
				),
			);
			// -> Blog Settings
			$this->sections[] = array(
				'title'            => esc_html__( 'Blog Settings', 'smarket' ),
				'id'               => 'blog',
				'desc'             => esc_html__( 'This Blog Setings', 'smarket' ),
				'customizer_width' => '400px',
				'icon'             => 'el-icon-podcast',
				'fields'           => array(
					array(
						'id'       => 'smarket_blog_layout',
						'type'     => 'image_select',
						'compiler' => true,
						'title'    => esc_html__( 'Blog Layout', 'smarket' ),
						'subtitle' => esc_html__( 'Select a layout.', 'smarket' ),
						'options'  => array(
							'left'  => array( 'alt' => 'Left Sidebar', 'img' => get_template_directory_uri() . '/images/2cl.png' ),
							'right' => array( 'alt' => 'Right Sidebar', 'img' => get_template_directory_uri() . '/images/2cr.png' ),
							'full'  => array( 'alt' => 'Full Width', 'img' => get_template_directory_uri() . '/images/1column.png' ),
						),
						'default'  => 'left',
					),
					array(
						'id'       => 'smarket_blog_used_sidebar',
						'type'     => 'select',
						'multi'    => false,
						'title'    => esc_html__( 'Blog Sidebar', 'smarket' ),
						'options'  => $this->sidebars,
						'default'  => 'widget-area',
						'required' => array( 'smarket_blog_layout', '=', array( 'left', 'right' ) ),
					),
					array(
						'id'      => 'smarket_blog_full_content',
						'type'    => 'switch',
						'title'   => esc_html__( 'Blog full content', 'smarket' ),
						'default' => '1',
						'on'      => esc_html__( 'On', 'smarket' ),
						'off'     => esc_html__( 'Off', 'smarket' ),
					),
					array(
						'id'      => 'smarket_blog_placehold',
						'type'    => 'switch',
						'title'   => esc_html__( 'Use Placehold', 'smarket' ),
						'default' => '0',
						'on'      => esc_html__( 'On', 'smarket' ),
						'off'     => esc_html__( 'Off', 'smarket' ),
					),
					array(
						'id'      => 'smarket_blog_list_style',
						'type'    => 'select',
						'multi'   => false,
						'title'   => esc_html__( 'Blog Layout Style', 'smarket' ),
						'options' => array(
							'classic' => esc_html__( 'Classic Style', 'smarket' ),
							'list'    => esc_html__( 'List Style', 'smarket' ),
						),
						'default' => 'list',
					),

					/* Blog grid */
					array(
						'title'    => esc_html__( 'Items per row on Desktop', 'smarket' ),
						'subtitle' => esc_html__( '(Screen resolution of device >= 1200px )', 'smarket' ),
						'id'       => 'smarket_blog_lg_items',
						'type'     => 'select',
						'default'  => '4',
						'options'  => array(
							'12' => esc_html__( '1 item', 'smarket' ),
							'6'  => esc_html__( '2 items', 'smarket' ),
							'4'  => esc_html__( '3 items', 'smarket' ),
							'3'  => esc_html__( '4 items', 'smarket' ),
							'15' => esc_html__( '5 items', 'smarket' ),
							'2'  => esc_html__( '6 items', 'smarket' ),
						),
						'required' => array( 'smarket_blog_list_style', '=', array( 'grid' ) ),
					),
					array(
						'title'    => esc_html__( 'Items per row on landscape tablet', 'smarket' ),
						'subtitle' => esc_html__( '(Screen resolution of device >=992px and < 1200px )', 'smarket' ),
						'id'       => 'smarket_blog_md_items',
						'type'     => 'select',
						'default'  => '4',
						'options'  => array(
							'12' => esc_html__( '1 item', 'smarket' ),
							'6'  => esc_html__( '2 items', 'smarket' ),
							'4'  => esc_html__( '3 items', 'smarket' ),
							'3'  => esc_html__( '4 items', 'smarket' ),
							'15' => esc_html__( '5 items', 'smarket' ),
							'2'  => esc_html__( '6 items', 'smarket' ),
						),
						'required' => array( 'smarket_blog_list_style', '=', array( 'grid' ) ),
					),
					array(
						'title'    => esc_html__( 'Items per row on portrait tablet', 'smarket' ),
						'subtitle' => esc_html__( '(Screen resolution of device >=768px and < 992px )', 'smarket' ),
						'id'       => 'smarket_blog_sm_items',
						'type'     => 'select',
						'default'  => '4',
						'options'  => array(
							'12' => esc_html__( '1 item', 'smarket' ),
							'6'  => esc_html__( '2 items', 'smarket' ),
							'4'  => esc_html__( '3 items', 'smarket' ),
							'3'  => esc_html__( '4 items', 'smarket' ),
							'15' => esc_html__( '5 items', 'smarket' ),
							'2'  => esc_html__( '6 items', 'smarket' ),
						),
						'required' => array( 'smarket_blog_list_style', '=', array( 'grid' ) ),
					),
					array(
						'title'    => esc_html__( 'Items per row on Mobile', 'smarket' ),
						'subtitle' => esc_html__( '(Screen resolution of device >=480  add < 768px)', 'smarket' ),
						'id'       => 'smarket_blog_xs_items',
						'type'     => 'select',
						'default'  => '6',
						'options'  => array(
							'12' => esc_html__( '1 item', 'smarket' ),
							'6'  => esc_html__( '2 items', 'smarket' ),
							'4'  => esc_html__( '3 items', 'smarket' ),
							'3'  => esc_html__( '4 items', 'smarket' ),
							'15' => esc_html__( '5 items', 'smarket' ),
							'2'  => esc_html__( '6 items', 'smarket' ),
						),
						'required' => array( 'smarket_blog_list_style', '=', array( 'grid' ) ),
					),
					array(
						'title'    => esc_html__( 'Items per row on Mobile', 'smarket' ),
						'subtitle' => esc_html__( '(Screen resolution of device < 480px)', 'smarket' ),
						'id'       => 'smarket_blog_ts_items',
						'type'     => 'select',
						'default'  => '12',
						'options'  => array(
							'12' => esc_html__( '1 item', 'smarket' ),
							'6'  => esc_html__( '2 items', 'smarket' ),
							'4'  => esc_html__( '3 items', 'smarket' ),
							'3'  => esc_html__( '4 items', 'smarket' ),
							'15' => esc_html__( '5 items', 'smarket' ),
							'2'  => esc_html__( '6 items', 'smarket' ),
						),
						'required' => array( 'smarket_blog_list_style', '=', array( 'grid' ) ),
					),
				),
			);

			/* Single blog settings */
			$this->sections[] = array(
				'title'            => esc_html__( 'Single post', 'smarket' ),
				'id'               => 'blog-single',
				'desc'             => esc_html__( 'This Single post Setings', 'smarket' ),
				'customizer_width' => '400px',
				'subsection'       => true,
				'fields'           => array(
					array(
						'id'       => 'smarket_single_layout',
						'type'     => 'image_select',
						'compiler' => true,
						'title'    => esc_html__( 'Layout', 'smarket' ),
						'subtitle' => esc_html__( 'Select a layout.', 'smarket' ),
						'options'  => array(
							'left'  => array( 'alt' => 'Left Sidebar', 'img' => get_template_directory_uri() . '/images/2cl.png' ),
							'right' => array( 'alt' => 'Right Sidebar', 'img' => get_template_directory_uri() . '/images/2cr.png' ),
							'full'  => array( 'alt' => 'Full Width', 'img' => get_template_directory_uri() . '/images/1column.png' ),
						),
						'default'  => 'left',
					),
					array(
						'id'       => 'smarket_single_used_sidebar',
						'type'     => 'select',
						'multi'    => false,
						'title'    => esc_html__( 'Sidebar', 'smarket' ),
						'options'  => $this->sidebars,
						'default'  => 'widget-area',
						'required' => array( 'smarket_single_layout', '=', array( 'left', 'right' ) ),
					),
					array(
						'id'      => 'smarket_enable_share',
						'type'    => 'switch',
						'title'   => esc_html__( 'Enable Share', 'smarket' ),
						'default' => '0',
						'on'      => esc_html__( 'On', 'smarket' ),
						'off'     => esc_html__( 'Off', 'smarket' ),
					),
				),
			);

			if ( class_exists( 'WooCommerce' ) ) {
				// -> Woo Settings
				$this->sections[] = array(
					'title'  => esc_html__( 'WooCommerce', 'smarket' ),
					'desc'   => esc_html__( 'WooCommerce Settings', 'smarket' ),
					'icon'   => 'el-icon-shopping-cart',
					'fields' => array(
						array(
							'title'   => esc_html__( 'Number of days newness', 'smarket' ),
							'id'      => 'smarket_woo_newness',
							'type'    => 'text',
							'default' => '7',
						),
						array(
							'title'    => esc_html__( 'Products perpage', 'smarket' ),
							'id'       => 'woo_products_perpage',
							'type'     => 'text',
							'default'  => '12',
							'validate' => 'numeric',
							'subtitle' => esc_html__( 'Number of products on shop page', 'smarket' ),
						),
						array(
							'id'       => 'woo_shop_banner',
							'type'     => 'media',
							'url'      => true,
							'title'    => esc_html__( 'banner in shop page', 'smarket' ),
							'compiler' => 'true',
							'desc'     => esc_html__( 'Basic media uploader with disabled URL input field.', 'smarket' ),
							'subtitle' => esc_html__( 'Upload any media using the WordPress native uploader', 'smarket' ),
						),
						array(
							'id'      => 'smarket_enable_lazy',
							'type'    => 'switch',
							'title'   => esc_html__( 'Use Lazy Load', 'smarket' ),
							'default' => '1',
							'on'      => esc_html__( 'On', 'smarket' ),
							'off'     => esc_html__( 'Off', 'smarket' ),
						),
						array(
							'id'      => 'smarket_short_product_name',
							'type'    => 'switch',
							'title'   => esc_html__( 'Use short name', 'smarket' ),
							'default' => '1',
							'on'      => esc_html__( 'YES', 'smarket' ),
							'off'     => esc_html__( 'NO', 'smarket' ),
						),
						array(
							'id'       => 'woo_style_hover',
							'type'     => 'switch',
							'title'    => esc_html__( 'Enable two image', 'smarket' ),
							'subtitle' => esc_html__( 'Enable two image in products', 'smarket' ),
							'default'  => '1',
							'on'       => esc_html__( 'Enable', 'smarket' ),
							'off'      => esc_html__( 'Disable', 'smarket' ),
						),
						array(
							'id'       => 'smarket_woo_product_style',
							'type'     => 'image_select',
							'compiler' => true,
							'title'    => esc_html__( 'Product grid style', 'smarket' ),
							'options'  => array(
								'1' => array( 'alt' => 'Product Style 01', 'img' => get_template_directory_uri() . '/woocommerce/product-styles/content-product-style-1.jpg' ),
							),
							'default'  => '1',
						),
						array(
							'id'       => 'woo_shop_layout',
							'type'     => 'image_select',
							'compiler' => true,
							'title'    => esc_html__( 'Sidebar Position', 'smarket' ),
							'subtitle' => esc_html__( 'Select sidebar position on shop, product archive page.', 'smarket' ),
							'options'  => array(
								'left'  => array( 'alt' => '1 Column Left', 'img' => get_template_directory_uri() . '/images/2cl.png' ),
								'right' => array( 'alt' => '2 Column Right', 'img' => get_template_directory_uri() . '/images/2cr.png' ),
								'full'  => array( 'alt' => 'Full Width', 'img' => get_template_directory_uri() . '/images/1column.png' ),
							),
							'default'  => 'left',
						),
						array(
							'id'       => 'woo_shop_used_sidebar',
							'type'     => 'select',
							'multi'    => false,
							'title'    => esc_html__( 'Sidebar', 'smarket' ),
							'options'  => $this->sidebars,
							'default'  => 'shop-widget-area',
							'required' => array( 'woo_shop_layout', '=', array( 'left', 'right' ) ),
						),
						array(
							'id'       => 'woo_shop_list_style',
							'type'     => 'image_select',
							'compiler' => true,
							'title'    => esc_html__( 'Shop Default Layout', 'smarket' ),
							'subtitle' => esc_html__( 'Select default layout for shop, product category archive.', 'smarket' ),
							'options'  => array(
								'grid' => array( 'alt' => 'Layout Grid', 'img' => get_template_directory_uri() . '/images/grid-display.png' ),
								'list' => array( 'alt' => 'Layout List', 'img' => get_template_directory_uri() . '/images/list-display.png' ),
							),
							'default'  => 'grid',
						),

						array(
							'title'    => esc_html__( 'Items per row on Desktop( For grid mode )', 'smarket' ),
							'subtitle' => esc_html__( '(Screen resolution of device >= 1500px )', 'smarket' ),
							'id'       => 'smarket_woo_bg_items',
							'type'     => 'select',
							'default'  => '15',
							'options'  => array(
								'12' => esc_html__( '1 item', 'smarket' ),
								'6'  => esc_html__( '2 items', 'smarket' ),
								'4'  => esc_html__( '3 items', 'smarket' ),
								'3'  => esc_html__( '4 items', 'smarket' ),
								'15' => esc_html__( '5 items', 'smarket' ),
								'2'  => esc_html__( '6 items', 'smarket' ),
							),

						),
						array(
							'title'    => esc_html__( 'Items per row on Desktop( For grid mode )', 'smarket' ),
							'subtitle' => esc_html__( '(Screen resolution of device >= 1200px < 1500px )', 'smarket' ),
							'id'       => 'smarket_woo_lg_items',
							'type'     => 'select',
							'default'  => '4',
							'options'  => array(
								'12' => esc_html__( '1 item', 'smarket' ),
								'6'  => esc_html__( '2 items', 'smarket' ),
								'4'  => esc_html__( '3 items', 'smarket' ),
								'3'  => esc_html__( '4 items', 'smarket' ),
								'15' => esc_html__( '5 items', 'smarket' ),
								'2'  => esc_html__( '6 items', 'smarket' ),
							),

						),
						array(
							'title'    => esc_html__( 'Items per row on landscape tablet( For grid mode )', 'smarket' ),
							'subtitle' => esc_html__( '(Screen resolution of device >=992px and < 1200px )', 'smarket' ),
							'id'       => 'smarket_woo_md_items',
							'type'     => 'select',
							'default'  => '4',
							'options'  => array(
								'12' => esc_html__( '1 item', 'smarket' ),
								'6'  => esc_html__( '2 items', 'smarket' ),
								'4'  => esc_html__( '3 items', 'smarket' ),
								'3'  => esc_html__( '4 items', 'smarket' ),
								'15' => esc_html__( '5 items', 'smarket' ),
								'2'  => esc_html__( '6 items', 'smarket' ),
							),

						),
						array(
							'title'    => esc_html__( 'Items per row on portrait tablet( For grid mode )', 'smarket' ),
							'subtitle' => esc_html__( '(Screen resolution of device >=768px and < 992px )', 'smarket' ),
							'id'       => 'smarket_woo_sm_items',
							'type'     => 'select',
							'default'  => '4',
							'options'  => array(
								'12' => esc_html__( '1 item', 'smarket' ),
								'6'  => esc_html__( '2 items', 'smarket' ),
								'4'  => esc_html__( '3 items', 'smarket' ),
								'3'  => esc_html__( '4 items', 'smarket' ),
								'15' => esc_html__( '5 items', 'smarket' ),
								'2'  => esc_html__( '6 items', 'smarket' ),
							),

						),
						array(
							'title'    => esc_html__( 'Items per row on Mobile( For grid mode )', 'smarket' ),
							'subtitle' => esc_html__( '(Screen resolution of device >=480  add < 768px)', 'smarket' ),
							'id'       => 'smarket_woo_xs_items',
							'type'     => 'select',
							'default'  => '6',
							'options'  => array(
								'12' => esc_html__( '1 item', 'smarket' ),
								'6'  => esc_html__( '2 items', 'smarket' ),
								'4'  => esc_html__( '3 items', 'smarket' ),
								'3'  => esc_html__( '4 items', 'smarket' ),
								'15' => esc_html__( '5 items', 'smarket' ),
								'2'  => esc_html__( '6 items', 'smarket' ),
							),

						),
						array(
							'title'    => esc_html__( 'Items per row on Mobile( For grid mode )', 'smarket' ),
							'subtitle' => esc_html__( '(Screen resolution of device < 480px)', 'smarket' ),
							'id'       => 'smarket_woo_ts_items',
							'type'     => 'select',
							'default'  => '12',
							'options'  => array(
								'12' => esc_html__( '1 item', 'smarket' ),
								'6'  => esc_html__( '2 items', 'smarket' ),
								'4'  => esc_html__( '3 items', 'smarket' ),
								'3'  => esc_html__( '4 items', 'smarket' ),
								'15' => esc_html__( '5 items', 'smarket' ),
								'2'  => esc_html__( '6 items', 'smarket' ),
							),
						),
					),
				);
				/** Single Product **/
				$this->sections[] = array(
					'title'      => esc_html__( 'Single product', 'smarket' ),
					'desc'       => esc_html__( 'Single product settings', 'smarket' ),
					'subsection' => true,
					'fields'     => array(
						array(
							'id'       => 'smarket_woo_single_layout',
							'type'     => 'image_select',
							'title'    => esc_html__( 'Single Product Sidebar Position', 'smarket' ),
							'subtitle' => esc_html__( 'Select sidebar position on single product page.', 'smarket' ),
							'options'  => array(
								'left'  => array( 'alt' => '1 Column Left', 'img' => get_template_directory_uri() . '/images/2cl.png' ),
								'right' => array( 'alt' => '2 Column Right', 'img' => get_template_directory_uri() . '/images/2cr.png' ),
								'full'  => array( 'alt' => 'Full Width', 'img' => get_template_directory_uri() . '/images/1column.png' ),
							),
							'default'  => 'left',
						),
						array(
							'id'       => 'smarket_woo_single_used_sidebar',
							'type'     => 'select',
							'multi'    => false,
							'title'    => esc_html__( 'Sidebar', 'smarket' ),
							'options'  => $this->sidebars,
							'default'  => 'widget-area',
							'required' => array( 'smarket_woo_single_layout', '=', array( 'left', 'right' ) ),
						),
						array(
							'title'    => esc_html__( 'Single Style', 'smarket' ),
							'subtitle' => esc_html__( 'Style Show in single product', 'smarket' ),
							'id'       => 'style_single_product',
							'type'     => 'select',
							'default'  => 'style-standard-horizon',
							'options'  => array(
								'style-standard-horizon'  => esc_html__( 'Detail Standard Horizon', 'smarket' ),
								'style-standard-vertical' => esc_html__( 'Detail Standard Vertical', 'smarket' ),
								'style-gallery-thumbnail' => esc_html__( 'Detail Gallery Thumbnail', 'smarket' ),
								'style-with-sticky'       => esc_html__( 'Detail With Sticky', 'smarket' ),
							),
						),
						array(
							'title'    => esc_html__( 'Spacing Top Element Sticky', 'smarket' ),
							'id'       => 'smarket_spacing_sticky',
							'type'     => 'text',
							'default'  => '60',
							'subtitle' => esc_html__( 'the spacing element single product with sticky header.', 'smarket' ),
							'required' => array( 'style_single_product', '=', array( 'style-with-sticky' ) ),
						),
					),

				);
				/** Cross sell products **/
				$this->sections[ 'woocommerce-cross-sell' ] = array(
					'title'      => esc_html__( 'Cross sell', 'smarket' ),
					'desc'       => esc_html__( 'Cross sell settings', 'smarket' ),
					'subsection' => true,
					'fields'     => array(
						array(
							'id'      => 'enable_cross_sell',
							'type'    => 'switch',
							'title'   => esc_html__( 'Enable Cross sell', 'smarket' ),
							'default' => '1',
							'on'      => esc_html__( 'Enable', 'smarket' ),
							'off'     => esc_html__( 'Disable', 'smarket' ),
						),
						array(
							'title'    => esc_html__( 'Cross sell title', 'smarket' ),
							'id'       => 'smarket_cross_sells_products_title',
							'type'     => 'text',
							'default'  => esc_html__( 'You may be interested in...', 'smarket' ),
							'subtitle' => esc_html__( 'Cross sell title', 'smarket' ),
							'required' => array( 'enable_cross_sell', '=', array( '1' ) ),
						),

						array(
							'title'    => esc_html__( 'Cross sell items per row on Desktop', 'smarket' ),
							'subtitle' => esc_html__( '(Screen resolution of device >= 1500px )', 'smarket' ),
							'id'       => 'smarket_woo_crosssell_ls_items',
							'type'     => 'select',
							'default'  => '4',
							'options'  => array(
								'1' => esc_html__( '1 item', 'smarket' ),
								'2' => esc_html__( '2 items', 'smarket' ),
								'3' => esc_html__( '3 items', 'smarket' ),
								'4' => esc_html__( '4 items', 'smarket' ),
								'5' => esc_html__( '5 items', 'smarket' ),
								'6' => esc_html__( '6 items', 'smarket' ),
							),
							'required' => array( 'enable_cross_sell', '=', array( '1' ) ),
						),
						array(
							'title'    => esc_html__( 'Cross sell items per row on Desktop', 'smarket' ),
							'subtitle' => esc_html__( '(Screen resolution of device >= 1200px < 1500px )', 'smarket' ),
							'id'       => 'smarket_woo_crosssell_lg_items',
							'type'     => 'select',
							'default'  => '4',
							'options'  => array(
								'1' => esc_html__( '1 item', 'smarket' ),
								'2' => esc_html__( '2 items', 'smarket' ),
								'3' => esc_html__( '3 items', 'smarket' ),
								'4' => esc_html__( '4 items', 'smarket' ),
								'5' => esc_html__( '5 items', 'smarket' ),
								'6' => esc_html__( '6 items', 'smarket' ),
							),
							'required' => array( 'enable_cross_sell', '=', array( '1' ) ),
						),
						array(
							'title'    => esc_html__( 'Cross sell items per row on landscape tablet', 'smarket' ),
							'subtitle' => esc_html__( '(Screen resolution of device >=992px and < 1200px )', 'smarket' ),
							'id'       => 'smarket_woo_crosssell_md_items',
							'type'     => 'select',
							'default'  => '3',
							'options'  => array(
								'1' => esc_html__( '1 item', 'smarket' ),
								'2' => esc_html__( '2 items', 'smarket' ),
								'3' => esc_html__( '3 items', 'smarket' ),
								'4' => esc_html__( '4 items', 'smarket' ),
								'5' => esc_html__( '5 items', 'smarket' ),
								'6' => esc_html__( '6 items', 'smarket' ),
							),
							'required' => array( 'enable_cross_sell', '=', array( '1' ) ),
						),
						array(
							'title'    => esc_html__( 'Cross sell items per row on portrait tablet', 'smarket' ),
							'subtitle' => esc_html__( '(Screen resolution of device >=768px and < 992px )', 'smarket' ),
							'id'       => 'smarket_woo_crosssell_sm_items',
							'type'     => 'select',
							'default'  => '2',
							'options'  => array(
								'1' => esc_html__( '1 item', 'smarket' ),
								'2' => esc_html__( '2 items', 'smarket' ),
								'3' => esc_html__( '3 items', 'smarket' ),
								'4' => esc_html__( '4 items', 'smarket' ),
								'5' => esc_html__( '5 items', 'smarket' ),
								'6' => esc_html__( '6 items', 'smarket' ),
							),
							'required' => array( 'enable_cross_sell', '=', array( '1' ) ),
						),
						array(
							'title'    => esc_html__( 'Cross sell items per row on Mobile', 'smarket' ),
							'subtitle' => esc_html__( '(Screen resolution of device >=480  add < 768px)', 'smarket' ),
							'id'       => 'smarket_woo_crosssell_xs_items',
							'type'     => 'select',
							'default'  => '2',
							'options'  => array(
								'1' => esc_html__( '1 item', 'smarket' ),
								'2' => esc_html__( '2 items', 'smarket' ),
								'3' => esc_html__( '3 items', 'smarket' ),
								'4' => esc_html__( '4 items', 'smarket' ),
								'5' => esc_html__( '5 items', 'smarket' ),
								'6' => esc_html__( '6 items', 'smarket' ),
							),
							'required' => array( 'enable_cross_sell', '=', array( '1' ) ),
						),
						array(
							'title'    => esc_html__( 'Cross sell items per row on Mobile', 'smarket' ),
							'subtitle' => esc_html__( '(Screen resolution of device < 480px)', 'smarket' ),
							'id'       => 'smarket_woo_crosssell_ts_items',
							'type'     => 'select',
							'default'  => '1',
							'options'  => array(
								'1' => esc_html__( '1 item', 'smarket' ),
								'2' => esc_html__( '2 items', 'smarket' ),
								'3' => esc_html__( '3 items', 'smarket' ),
								'4' => esc_html__( '4 items', 'smarket' ),
								'5' => esc_html__( '5 items', 'smarket' ),
								'6' => esc_html__( '6 items', 'smarket' ),
							),
							'required' => array( 'enable_cross_sell', '=', array( '1' ) ),
						),
					),
				);

				/*-- RELATED PRODUCTS --*/
				$this->sections[] = array(
					'title'      => esc_html__( 'Related products', 'smarket' ),
					'desc'       => esc_html__( 'Related products settings', 'smarket' ),
					'subsection' => true,
					'fields'     => array(
						array(
							'id'      => 'enable_relate_products',
							'type'    => 'switch',
							'title'   => esc_html__( 'Enable Relate Products', 'smarket' ),
							'default' => '1',
							'on'      => esc_html__( 'Enable', 'smarket' ),
							'off'     => esc_html__( 'Disable', 'smarket' ),
						),
						array(
							'title'    => esc_html__( 'Related products title', 'smarket' ),
							'id'       => 'smarket_related_products_title',
							'type'     => 'text',
							'default'  => esc_html__( 'Related Products', 'smarket' ),
							'subtitle' => esc_html__( 'Related products title', 'smarket' ),
							'required' => array( 'enable_relate_products', '=', array( '1' ) ),
						),

						array(
							'title'    => esc_html__( 'Related products items per row on Desktop', 'smarket' ),
							'subtitle' => esc_html__( '(Screen resolution of device >= 1500px )', 'smarket' ),
							'id'       => 'smarket_woo_related_ls_items',
							'type'     => 'select',
							'default'  => '4',
							'options'  => array(
								'1' => esc_html__( '1 item', 'smarket' ),
								'2' => esc_html__( '2 items', 'smarket' ),
								'3' => esc_html__( '3 items', 'smarket' ),
								'4' => esc_html__( '4 items', 'smarket' ),
								'5' => esc_html__( '5 items', 'smarket' ),
								'6' => esc_html__( '6 items', 'smarket' ),
							),
							'required' => array( 'enable_relate_products', '=', array( '1' ) ),
						),
						array(
							'title'    => esc_html__( 'Related products items per row on Desktop', 'smarket' ),
							'subtitle' => esc_html__( '(Screen resolution of device >= 1200px < 1500px )', 'smarket' ),
							'id'       => 'smarket_woo_related_lg_items',
							'type'     => 'select',
							'default'  => '4',
							'options'  => array(
								'1' => esc_html__( '1 item', 'smarket' ),
								'2' => esc_html__( '2 items', 'smarket' ),
								'3' => esc_html__( '3 items', 'smarket' ),
								'4' => esc_html__( '4 items', 'smarket' ),
								'5' => esc_html__( '5 items', 'smarket' ),
								'6' => esc_html__( '6 items', 'smarket' ),
							),
							'required' => array( 'enable_relate_products', '=', array( '1' ) ),
						),
						array(
							'title'    => esc_html__( 'Related products items per row on landscape tablet', 'smarket' ),
							'subtitle' => esc_html__( '(Screen resolution of device >=992px and < 1200px )', 'smarket' ),
							'id'       => 'smarket_woo_related_md_items',
							'type'     => 'select',
							'default'  => '3',
							'options'  => array(
								'1' => esc_html__( '1 item', 'smarket' ),
								'2' => esc_html__( '2 items', 'smarket' ),
								'3' => esc_html__( '3 items', 'smarket' ),
								'4' => esc_html__( '4 items', 'smarket' ),
								'5' => esc_html__( '5 items', 'smarket' ),
								'6' => esc_html__( '6 items', 'smarket' ),
							),
							'required' => array( 'enable_relate_products', '=', array( '1' ) ),
						),
						array(
							'title'    => esc_html__( 'Related product items per row on portrait tablet', 'smarket' ),
							'subtitle' => esc_html__( '(Screen resolution of device >=768px and < 992px )', 'smarket' ),
							'id'       => 'smarket_woo_related_sm_items',
							'type'     => 'select',
							'default'  => '2',
							'options'  => array(
								'1' => esc_html__( '1 item', 'smarket' ),
								'2' => esc_html__( '2 items', 'smarket' ),
								'3' => esc_html__( '3 items', 'smarket' ),
								'4' => esc_html__( '4 items', 'smarket' ),
								'5' => esc_html__( '5 items', 'smarket' ),
								'6' => esc_html__( '6 items', 'smarket' ),
							),
							'required' => array( 'enable_relate_products', '=', array( '1' ) ),
						),
						array(
							'title'    => esc_html__( 'Related products items per row on Mobile', 'smarket' ),
							'subtitle' => esc_html__( '(Screen resolution of device >=480  add < 768px)', 'smarket' ),
							'id'       => 'smarket_woo_related_xs_items',
							'type'     => 'select',
							'default'  => '2',
							'options'  => array(
								'1' => esc_html__( '1 item', 'smarket' ),
								'2' => esc_html__( '2 items', 'smarket' ),
								'3' => esc_html__( '3 items', 'smarket' ),
								'4' => esc_html__( '4 items', 'smarket' ),
								'5' => esc_html__( '5 items', 'smarket' ),
								'6' => esc_html__( '6 items', 'smarket' ),
							),
							'required' => array( 'enable_relate_products', '=', array( '1' ) ),
						),
						array(
							'title'    => esc_html__( 'Related products items per row on Mobile', 'smarket' ),
							'subtitle' => esc_html__( '(Screen resolution of device < 480px)', 'smarket' ),
							'id'       => 'smarket_woo_related_ts_items',
							'type'     => 'select',
							'default'  => '1',
							'options'  => array(
								'1' => esc_html__( '1 item', 'smarket' ),
								'2' => esc_html__( '2 items', 'smarket' ),
								'3' => esc_html__( '3 items', 'smarket' ),
								'4' => esc_html__( '4 items', 'smarket' ),
								'5' => esc_html__( '5 items', 'smarket' ),
								'6' => esc_html__( '6 items', 'smarket' ),
							),
							'required' => array( 'enable_relate_products', '=', array( '1' ) ),
						),
					),
				);

				/*-- UP SELL PRODUCTS --*/
				$this->sections[] = array(
					'title'      => esc_html__( 'Up sells products', 'smarket' ),
					'desc'       => esc_html__( 'Up sells products settings', 'smarket' ),
					'subsection' => true,
					'fields'     => array(
						array(
							'id'      => 'enable_up_sell',
							'type'    => 'switch',
							'title'   => esc_html__( 'Enable Up Sell', 'smarket' ),
							'default' => '1',
							'on'      => esc_html__( 'Enable', 'smarket' ),
							'off'     => esc_html__( 'Disable', 'smarket' ),
						),
						array(
							'title'    => esc_html__( 'Up sells title', 'smarket' ),
							'id'       => 'smarket_upsell_products_title',
							'type'     => 'text',
							'default'  => esc_html__( 'You may also like&hellip;', 'smarket' ),
							'subtitle' => esc_html__( 'Up sells products title', 'smarket' ),
							'required' => array( 'enable_up_sell', '=', array( '1' ) ),
						),

						array(
							'title'    => esc_html__( 'Up sells items per row on Desktop', 'smarket' ),
							'subtitle' => esc_html__( '(Screen resolution of device >= 1500px )', 'smarket' ),
							'id'       => 'smarket_woo_upsell_ls_items',
							'type'     => 'select',
							'default'  => '3',
							'options'  => array(
								'1' => esc_html__( '1 item', 'smarket' ),
								'2' => esc_html__( '2 items', 'smarket' ),
								'3' => esc_html__( '3 items', 'smarket' ),
								'4' => esc_html__( '4 items', 'smarket' ),
								'5' => esc_html__( '5 items', 'smarket' ),
								'6' => esc_html__( '6 items', 'smarket' ),
							),
							'required' => array( 'enable_up_sell', '=', array( '1' ) ),
						),
						array(
							'title'    => esc_html__( 'Up sells items per row on Desktop', 'smarket' ),
							'subtitle' => esc_html__( '(Screen resolution of device >= 1200px < 1500px )', 'smarket' ),
							'id'       => 'smarket_woo_upsell_lg_items',
							'type'     => 'select',
							'default'  => '3',
							'options'  => array(
								'1' => esc_html__( '1 item', 'smarket' ),
								'2' => esc_html__( '2 items', 'smarket' ),
								'3' => esc_html__( '3 items', 'smarket' ),
								'4' => esc_html__( '4 items', 'smarket' ),
								'5' => esc_html__( '5 items', 'smarket' ),
								'6' => esc_html__( '6 items', 'smarket' ),
							),
							'required' => array( 'enable_up_sell', '=', array( '1' ) ),
						),
						array(
							'title'    => esc_html__( 'Up sells items per row on landscape tablet', 'smarket' ),
							'subtitle' => esc_html__( '(Screen resolution of device >=992px and < 1200px )', 'smarket' ),
							'id'       => 'smarket_woo_upsell_md_items',
							'type'     => 'select',
							'default'  => '3',
							'options'  => array(
								'1' => esc_html__( '1 item', 'smarket' ),
								'2' => esc_html__( '2 items', 'smarket' ),
								'3' => esc_html__( '3 items', 'smarket' ),
								'4' => esc_html__( '4 items', 'smarket' ),
								'5' => esc_html__( '5 items', 'smarket' ),
								'6' => esc_html__( '6 items', 'smarket' ),
							),
							'required' => array( 'enable_up_sell', '=', array( '1' ) ),
						),
						array(
							'title'    => esc_html__( 'Up sells items per row on portrait tablet', 'smarket' ),
							'subtitle' => esc_html__( '(Screen resolution of device >=768px and < 992px )', 'smarket' ),
							'id'       => 'smarket_woo_upsell_sm_items',
							'type'     => 'select',
							'default'  => '2',
							'options'  => array(
								'1' => esc_html__( '1 item', 'smarket' ),
								'2' => esc_html__( '2 items', 'smarket' ),
								'3' => esc_html__( '3 items', 'smarket' ),
								'4' => esc_html__( '4 items', 'smarket' ),
								'5' => esc_html__( '5 items', 'smarket' ),
								'6' => esc_html__( '6 items', 'smarket' ),
							),
							'required' => array( 'enable_up_sell', '=', array( '1' ) ),
						),
						array(
							'title'    => esc_html__( 'Up sells items per row on Mobile', 'smarket' ),
							'subtitle' => esc_html__( '(Screen resolution of device >=480  add < 768px)', 'smarket' ),
							'id'       => 'smarket_woo_upsell_xs_items',
							'type'     => 'select',
							'default'  => '2',
							'options'  => array(
								'1' => esc_html__( '1 item', 'smarket' ),
								'2' => esc_html__( '2 items', 'smarket' ),
								'3' => esc_html__( '3 items', 'smarket' ),
								'4' => esc_html__( '4 items', 'smarket' ),
								'5' => esc_html__( '5 items', 'smarket' ),
								'6' => esc_html__( '6 items', 'smarket' ),
							),
							'required' => array( 'enable_up_sell', '=', array( '1' ) ),
						),
						array(
							'title'    => esc_html__( 'Up sells items per row on Mobile', 'smarket' ),
							'subtitle' => esc_html__( '(Screen resolution of device < 480px)', 'smarket' ),
							'id'       => 'smarket_woo_upsell_ts_items',
							'type'     => 'select',
							'default'  => '1',
							'options'  => array(
								'1' => esc_html__( '1 item', 'smarket' ),
								'2' => esc_html__( '2 items', 'smarket' ),
								'3' => esc_html__( '3 items', 'smarket' ),
								'4' => esc_html__( '4 items', 'smarket' ),
								'5' => esc_html__( '5 items', 'smarket' ),
								'6' => esc_html__( '6 items', 'smarket' ),
							),
							'required' => array( 'enable_up_sell', '=', array( '1' ) ),
						),
					),
				);

			}
			/*--Social Settings--*/
			$this->sections[] = array(
				'title'  => esc_html__( 'Social Settings', 'smarket' ),
				'icon'   => 'el-icon-group',
				'fields' => array(
					array(
						'id'       => 'opt_twitter_link',
						'type'     => 'text',
						'title'    => esc_html__( 'Twitter', 'smarket' ),
						'default'  => 'https://twitter.com',
						'validate' => 'url',
					),
					array(
						'id'       => 'opt_fb_link',
						'type'     => 'text',
						'title'    => esc_html__( 'Facebook', 'smarket' ),
						'default'  => 'https://facebook.com',
						'validate' => 'url',
					),
					array(
						'id'       => 'opt_google_plus_link',
						'type'     => 'text',
						'title'    => esc_html__( 'Google Plus', 'smarket' ),
						'default'  => '',
						'validate' => 'url',
					),
					array(
						'id'       => 'opt_dribbble_link',
						'type'     => 'text',
						'title'    => esc_html__( 'Dribbble', 'smarket' ),
						'default'  => '',
						'validate' => 'url',
					),
					array(
						'id'       => 'opt_behance_link',
						'type'     => 'text',
						'title'    => esc_html__( 'Behance', 'smarket' ),
						'default'  => '',
						'validate' => 'url',
					),
					array(
						'id'       => 'opt_tumblr_link',
						'type'     => 'text',
						'title'    => esc_html__( 'Tumblr', 'smarket' ),
						'default'  => '',
						'validate' => 'url',
					),
					array(
						'id'       => 'opt_instagram_link',
						'type'     => 'text',
						'title'    => esc_html__( 'Instagram', 'smarket' ),
						'default'  => '',
						'validate' => 'url',
					),
					array(
						'id'       => 'opt_pinterest_link',
						'type'     => 'text',
						'title'    => esc_html__( 'Pinterest', 'smarket' ),
						'default'  => '',
						'validate' => 'url',
					),
					array(
						'id'       => 'opt_youtube_link',
						'type'     => 'text',
						'title'    => esc_html__( 'Youtube', 'smarket' ),
						'default'  => '',
						'validate' => 'url',
					),
					array(
						'id'       => 'opt_vimeo_link',
						'type'     => 'text',
						'title'    => esc_html__( 'Vimeo', 'smarket' ),
						'default'  => '',
						'validate' => 'url',
					),
					array(
						'id'       => 'opt_linkedin_link',
						'type'     => 'text',
						'title'    => esc_html__( 'Linkedin', 'smarket' ),
						'default'  => '',
						'validate' => 'url',
					),
					array(
						'id'       => 'opt_rss_link',
						'type'     => 'text',
						'title'    => esc_html__( 'RSS', 'smarket' ),
						'default'  => '',
						'validate' => 'url',
					),
				),
			);
			/*--Typograply Options--*/
			$this->sections[] = array(
				'icon'   => 'el-icon-font',
				'title'  => esc_html__( 'Typography Options', 'smarket' ),
				'fields' => array(
					array(
						'id'       => 'opt_typography_body_font',
						'type'     => 'typography',
						'title'    => esc_html__( 'Body Font Setting', 'smarket' ),
						'subtitle' => esc_html__( 'Specify the body font properties.', 'smarket' ),
						'google'   => true,
						'output'   => 'body',
					),
					array(
						'id'       => 'opt_typography_h1_font',
						'type'     => 'typography',
						'title'    => esc_html__( 'Heading 1(H1) Font Setting', 'smarket' ),
						'subtitle' => esc_html__( 'Specify the H1 tag font properties.', 'smarket' ),
						'google'   => true,
						'output'   => 'h1',
					),

					array(
						'id'       => 'opt_typography_h2_font',
						'type'     => 'typography',
						'title'    => esc_html__( 'Heading 2(H2) Font Setting', 'smarket' ),
						'subtitle' => esc_html__( 'Specify the H2 tag font properties.', 'smarket' ),
						'google'   => true,
						'output'   => 'h2',
					),

					array(
						'id'       => 'opt_typography_h3_font',
						'type'     => 'typography',
						'title'    => esc_html__( 'Heading 3(H3) Font Setting', 'smarket' ),
						'subtitle' => esc_html__( 'Specify the H3 tag font properties.', 'smarket' ),
						'google'   => true,
						'output'   => 'h3',
					),

					array(
						'id'       => 'opt_typography_h4_font',
						'type'     => 'typography',
						'title'    => esc_html__( 'Heading 4(H4) Font Setting', 'smarket' ),
						'subtitle' => esc_html__( 'Specify the H4 tag font properties.', 'smarket' ),
						'google'   => true,
						'output'   => 'h4',
					),

					array(
						'id'       => 'opt_typography_h5_font',
						'type'     => 'typography',
						'title'    => esc_html__( 'Heading 5(H5) Font Setting', 'smarket' ),
						'subtitle' => esc_html__( 'Specify the H5 tag font properties.', 'smarket' ),
						'google'   => true,
						'output'   => 'h5',
					),

					array(
						'id'       => 'opt_typography_h6_font',
						'type'     => 'typography',
						'title'    => esc_html__( 'Heading 6(H6) Font Setting', 'smarket' ),
						'subtitle' => esc_html__( 'Specify the H6 tag font properties.', 'smarket' ),
						'google'   => true,
						'output'   => 'h6',
					),
				),
			);
			/*--Popup Newsletter Options--*/
			$this->sections[] = array(
				'icon'   => 'el el-comment-alt',
				'title'  => esc_html__( 'Popup Newsletter', 'smarket' ),
				'fields' => array(
					array(
						'id'      => 'smarket_enable_popup',
						'type'    => 'switch',
						'title'   => esc_html__( 'Enable Poppup', 'smarket' ),
						'default' => '0',
						'on'      => esc_html__( 'On', 'smarket' ),
						'off'     => esc_html__( 'Off', 'smarket' ),
					),
					array(
						'id'       => 'smarket_popup_title',
						'type'     => 'text',
						'title'    => esc_html__( 'Title', 'smarket' ),
						'default'  => esc_html__( 'Newsletter', 'smarket' ),
						'required' => array( 'smarket_enable_popup', '=', array( '1' ) ),
					),
					array(
						'id'       => 'smarket_popup_subtitle',
						'type'     => 'text',
						'title'    => esc_html__( 'Sub Title', 'smarket' ),
						'default'  => esc_html__( 'Subscribe to our mailling list to get updates to your email inbox.', 'smarket' ),
						'required' => array( 'smarket_enable_popup', '=', array( '1' ) ),
					),
					array(
						'id'       => 'smarket_popup_input_placeholder',
						'type'     => 'text',
						'title'    => esc_html__( 'Input placeholder text', 'smarket' ),
						'default'  => esc_html__( 'Email Address', 'smarket' ),
						'required' => array( 'smarket_enable_popup', '=', array( '1' ) ),
					),
					array(
						'id'       => 'smarket_popup_button_text',
						'type'     => 'text',
						'title'    => esc_html__( 'Input placeholder text', 'smarket' ),
						'default'  => esc_html__( 'Sign Up', 'smarket' ),
						'required' => array( 'smarket_enable_popup', '=', array( '1' ) ),
					),
					array(
						'id'       => 'smarket_poppup_background',
						'type'     => 'media',
						'url'      => true,
						'title'    => esc_html__( 'Popup Background', 'smarket' ),
						'compiler' => 'true',
						'required' => array( 'smarket_enable_popup', '=', array( '1' ) ),
					),
					array(
						'id'       => 'smarket_poppup_socials',
						'type'     => 'select',
						'multi'    => true,
						'title'    => esc_html__( 'Socials', 'smarket' ),
						'options'  => $this->socials,
						'required' => array( 'smarket_enable_popup', '=', array( '1' ) ),
					),
					array(
						'id'       => 'smarket_popup_delay_time',
						'type'     => 'text',
						'title'    => esc_html__( 'Delay time', 'smarket' ),
						'default'  => '0',
						'required' => array( 'smarket_enable_popup', '=', array( '1' ) ),
					),
					array(
						'id'       => 'smarket_enable_popup_mobile',
						'type'     => 'switch',
						'title'    => esc_html__( 'Enable Poppup on Mobile', 'smarket' ),
						'default'  => '0',
						'on'       => esc_html__( 'On', 'smarket' ),
						'off'      => esc_html__( 'Off', 'smarket' ),
						'required' => array( 'smarket_enable_popup', '=', array( '1' ) ),
					),
				),
			);
			/*--  Google map API key --*/
			$this->sections[] = array(
				'title'  => esc_html__( 'Google Map', 'smarket' ),
				'fields' => array(
					array(
						'id'    => 'opt_gmap_api_key',
						'type'  => 'text',
						'title' => esc_html__( 'Google Map API Key', 'smarket' ),
						'desc'  => wp_kses( sprintf( esc_html__( 'Enter your Google Map API key. <a href="%s" target="_blank">How to get?</a>', 'smarket' ), 'https://developers.google.com/maps/documentation/javascript/get-api-key' ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ),
					),
				),
			);
		}

		public function setHelpTabs()
		{

			// Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
			$this->args[ 'help_tabs' ][] = array(
				'id'      => 'redux-opts-1',
				'title'   => esc_html__( 'Theme Information 1', 'smarket' ),
				'content' => wp_kses( esc_html__( '<p>This is the tab content, HTML is allowed.</p>', 'smarket' ), array( 'p' ) ),
			);

			$this->args[ 'help_tabs' ][] = array(
				'id'      => 'redux-opts-2',
				'title'   => esc_html__( 'Theme Information 2', 'smarket' ),
				'content' => wp_kses( esc_html__( '<p>This is the tab content, HTML is allowed.</p>', 'smarket' ), array( 'p' ) ),
			);

			// Set the help sidebar
			$this->args[ 'help_sidebar' ] = wp_kses( esc_html__( '<p>This is the tab content, HTML is allowed.</p>', 'smarket' ), array( 'p' ) );
		}

		/**
		 *
		 * All the possible arguments for Redux.
		 * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
		 * */
		public function setArguments()
		{

			$theme = wp_get_theme(); // For use with some settings. Not necessary.

			$this->args = array(
				// TYPICAL -> Change these values as you need/desire
				'opt_name'            => 'smarket', // This is where your data is stored in the database and also becomes your global variable name.
				'display_name'        => '<span class="theme-name">' . sanitize_text_field( $theme->get( 'Name' ) ) . '</span>', // Name that appears at the top of your panel
				'display_version'     => $theme->get( 'Version' ), // Version that appears at the top of your panel
				'menu_type'           => 'submenu', //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
				'allow_sub_menu'      => false, // Show the sections below the admin menu item or not
				'menu_title'          => esc_html__( 'Theme Options', 'smarket' ),
				'page_title'          => esc_html__( 'Theme Options', 'smarket' ),
				// You will need to generate a Google API key to use this feature.
				// Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
				'google_api_key'      => '', // Must be defined to add google fonts to the typography module
				//'async_typography'    => true, // Use a asynchronous font on the front end or font string
				//'admin_bar'           => false, // Show the panel pages on the admin bar
				'global_variable'     => 'smarket', // Set a different name for your global variable other than the opt_name
				'dev_mode'            => false, // Show the time the page took to load, etc
				'customizer'          => true, // Enable basic customizer support
				// OPTIONAL -> Give you extra features
				'page_priority'       => null, // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
				'page_parent'         => 'smarket_welcome', // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
				'page_permissions'    => 'manage_options', // Permissions needed to access the options panel.
				'menu_icon'           => '', // Specify a custom URL to an icon
				'last_tab'            => '', // Force your panel to always open to a specific tab (by id)
				'page_icon'           => 'icon-themes', // Icon displayed in the admin panel next to your menu_title
				'page_slug'           => 'smarket_options', // Page slug used to denote the panel
				'save_defaults'       => true, // On load save the defaults to DB before user clicks save or not
				'default_show'        => false, // If true, shows the default value next to each field that is not the default value.
				'default_mark'        => '', // What to print by the field's title if the value shown is default. Suggested: *
				// CAREFUL -> These options are for advanced use only
				'transient_time'      => 60 * MINUTE_IN_SECONDS,
				'output'              => true, // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
				'output_tag'          => true, // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
				//'domain'              => 'smarket', // Translation domain key. Don't change this unless you want to retranslate all of Redux.
				'footer_credit'       => esc_html__( 'KuteThemes WordPress Team', 'smarket' ), // Disable the footer credit of Redux. Please leave if you can help it.
				// FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
				'database'            => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
				'show_import_export'  => true, // REMOVE
				'system_info'         => false, // REMOVE
				'help_tabs'           => array(),
				'help_sidebar'        => '', // esc_html__( '', $this->args['domain'] );
				'show_options_object' => false,
				'hints'               => array(
					'icon'          => 'icon-question-sign',
					'icon_position' => 'right',
					'icon_color'    => 'lightgray',
					'icon_size'     => 'normal',

					'tip_style'    => array(
						'color'   => 'light',
						'shadow'  => true,
						'rounded' => false,
						'style'   => '',
					),
					'tip_position' => array(
						'my' => 'top left',
						'at' => 'bottom right',
					),
					'tip_effect'   => array(
						'show' => array(
							'effect'   => 'slide',
							'duration' => '500',
							'event'    => 'mouseover',
						),
						'hide' => array(
							'effect'   => 'slide',
							'duration' => '500',
							'event'    => 'click mouseleave',
						),
					),
				),
			);

			// Panel Intro text -> before the form
			if ( !isset( $this->args[ 'global_variable' ] ) || $this->args[ 'global_variable' ] !== false ) {
				if ( !empty( $this->args[ 'global_variable' ] ) ) {
					$v = $this->args[ 'global_variable' ];
				} else {
					$v = str_replace( "-", "_", $this->args[ 'opt_name' ] );
				}

			} else {

			}

		}
	}
}

if ( !function_exists( 'Smarket_ThemeOptions' ) ) {
	function Smarket_ThemeOptions()
	{
		new Smarket_ThemeOptions();
	}
}
add_action( 'init', 'Smarket_ThemeOptions', 1 );