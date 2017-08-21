<?php

if ( !class_exists( 'Smarket_Meta_Box_Settings' ) ) {
	class Smarket_Meta_Box_Settings
	{


		public function __construct()
		{
			add_filter( 'rwmb_meta_boxes', array( __CLASS__, 'meta_boxes' ) );
		}

		/**
		 * Register additional meta boxes.
		 *
		 * @param   array $meta_boxes Current meta boxes.
		 *
		 * @return  array
		 */
		public static function meta_boxes( $meta_boxes )
		{
			/* sidebar */

			global $wp_registered_sidebars;
			$sidebars = array();
			foreach ( $wp_registered_sidebars as $sidebar ) {
				$sidebars[ $sidebar[ 'id' ] ] = $sidebar[ 'name' ];
			}

			/* sidebar */

			/* footer style page */

			$footer_options  = array();
			$footer_previews = array();
			$args            = array(
				'post_type'      => array( 'footer' ),
				'posts_per_page' => -1,
				'orderby'        => 'title',
				'order'          => 'ASC',
			);

			$loop  = new wp_query( $args );
			$loops = $loop->get_posts();

			foreach ( $loops as $loop ) {
				$thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id( $loop->ID ), 'full', true );

				$footer_options[ $loop->ID ] = $loop->post_title;

				$footer_previews[] = array(
					'id'         => 'footer_preview',
					'name'       => esc_html__( 'Footer Preview', 'smarket' ),
					'type'       => 'image_select',
					'options'    => array(
						'preview' => esc_url( $thumb_url[ 0 ] ),
					),
					'dependency' => array(
						'id'    => 'box_style_footer',
						'value' => array( $loop->ID ),
					),
				);
			}

			/* footer style page */

			/* footer style footer */

			$footer_style_options = array(
				'default' => esc_html__( 'Default', 'smarket' ),
			);
			$layoutDir            = get_template_directory() . '/templates/footers/';
			if ( is_dir( $layoutDir ) ) {
				$files = scandir( $layoutDir );
				if ( $files && is_array( $files ) ) {
					$option = '';
					foreach ( $files as $file ) {
						if ( $file != '.' && $file != '..' ) {
							$fileInfo = pathinfo( $file );
							if ( $fileInfo[ 'extension' ] == 'php' && $fileInfo[ 'basename' ] != 'index.php' ) {
								$file_data                          = get_file_data( $layoutDir . $file, array( 'Name' => 'Name' ) );
								$file_name                          = str_replace( 'footer-', '', $fileInfo[ 'filename' ] );
								$footer_style_options[ $file_name ] = $file_data[ 'Name' ];
							}
						}
					}
				}
			}

			/* footer style footer */

			/* header style page */

			$layoutDir            = get_template_directory() . '/templates/headers/';
			$header_options       = array();
			$header_previews      = array();
			$preview_options_done = array();

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
								$header_options[ $file_name ] = $file_data[ 'Name' ];
								$header_previews[]            = array(
									'id'         => 'header_preview',
									'name'       => esc_html__( 'Header Preview', 'smarket' ),
									'type'       => 'image_select',
									'options'    => array(
										'preview' => get_template_directory_uri() . '/templates/headers/header-' . $file_name . '.jpg',
									),
									'dependency' => array(
										'id'    => 'box_style_header',
										'value' => array( $file_name ),
									),
								);
							}
						}
					}
				}
			}

			$preview_options_done[] = array(
				'name' => esc_html__( 'Using Page Setting', 'smarket' ),
				'id'   => 'page_setting',
				'type' => 'checkbox',
			);

			$preview_options_done[] = array(
				'name'             => esc_html__( 'Header Style:', 'smarket' ),
				'id'               => 'box_style_header',
				'type'             => 'select',
				'show_option_none' => true,
				'options'          => $header_options,
			);

			foreach ( $header_previews as $header_preview ) {
				$preview_options_done[] = $header_preview;
			}

			$preview_options_done[] = array(
				'name'    => esc_html__( 'Vertical Menu', 'smarket' ),
				'id'      => 'header_vectical_menu',
				'type'    => 'select',
				'std'     => '0',
				'options' => array(
					'1' => esc_html__( 'Yes', 'smarket' ),
					'0' => esc_html__( 'No', 'smarket' ),
				),
			);
			$preview_options_done[] = array(
				'name'       => esc_html__( 'Vertical Menu Title', 'smarket' ),
				'id'         => 'header_vectical_title',
				'type'       => 'text',
				'std'        => esc_html__( 'Shop By Category', 'smarket' ),
				'dependency' => array(
					'id'    => 'header_vectical_menu',
					'value' => array( '1' ),
				),
			);
			$preview_options_done[] = array(
				'name'       => esc_html__( 'Vertical Menu Button show all text', 'smarket' ),
				'id'         => 'header_vectical_button_all_text',
				'type'       => 'text',
				'std'        => esc_html__( 'All Categories', 'smarket' ),
				'dependency' => array(
					'id'    => 'header_vectical_menu',
					'value' => array( '1' ),
				),
			);
			$preview_options_done[] = array(
				'name'       => esc_html__( 'Vertical Menu Button close text', 'smarket' ),
				'id'         => 'header_vectical_button_close_text',
				'type'       => 'text',
				'std'        => esc_html__( 'Close', 'smarket' ),
				'dependency' => array(
					'id'    => 'header_vectical_menu',
					'value' => array( '1' ),
				),
			);
			$preview_options_done[] = array(
				'name'       => esc_html__( 'Collapse', 'smarket' ),
				'id'         => 'header_vectical_collapse',
				'type'       => 'checkbox',
				'std'        => '1',
				'dependency' => array(
					'id'    => 'header_vectical_menu',
					'value' => array( '1' ),
				),
			);
			$preview_options_done[] = array(
				'name'       => esc_html__( 'The number of visible vertical menu items', 'smarket' ),
				'desc'       => esc_html__( 'The number of visible vertical menu items', 'smarket' ),
				'id'         => 'header_vectical_item_visible',
				'type'       => 'text',
				'std'        => '10',
				'dependency' => array(
					'id'    => 'header_vectical_menu',
					'value' => array( '1' ),
				),
			);

			$preview_options_done[] = array(
				'name'             => esc_html__( 'Footer Style:', 'smarket' ),
				'id'               => 'box_style_footer',
				'type'             => 'select',
				'show_option_none' => true,
				'options'          => $footer_options,
			);

			foreach ( $footer_previews as $footer_preview ) {
				$preview_options_done[] = $footer_preview;
			}

			/* header style page */

			/* Metabox for page*/
			$meta_boxes[] = array(
				'id'         => 'themes_box_option',
				'title'      => esc_html__( 'Themes Option', 'smarket' ),
				'post_types' => array( 'page' ),
				'fields'     => $preview_options_done,
			);
			$fields       = array(
				array(
					'name'             => esc_html__( 'Page header backgound', 'smarket' ),
					'desc'             => esc_html__( 'Setting your page banner', 'smarket' ),
					'id'               => 'smarket_page_header_background',
					'type'             => 'image_advanced',
					'max_file_uploads' => 1,
				),
				array(
					'name' => esc_html__( 'Page heading height', 'smarket' ),
					'id'   => 'smarket_page_heading_height',
					'type' => 'text',
					'desc' => esc_html__( 'Unit PX', 'smarket' ),
				),
				array(
					'name' => esc_html__( 'Page Margin Top', 'smarket' ),
					'id'   => 'smarket_page_margin_top',
					'type' => 'text',
					'desc' => esc_html__( 'Unit PX', 'smarket' ),
				),
				array(
					'name' => esc_html__( 'Page Margin Bottom', 'smarket' ),
					'id'   => 'smarket_page_margin_bottom',
					'type' => 'text',
					'desc' => esc_html__( 'Unit PX', 'smarket' ),
				),
				array(
					'id'      => 'smarket_page_layout',
					'name'    => esc_html__( 'Page layout', 'smarket' ),
					'type'    => 'image_select',
					'options' => array(
						'full'  => get_template_directory_uri() . '/images/1column.png',
						'left'  => get_template_directory_uri() . '/images/2cl.png',
						'right' => get_template_directory_uri() . '/images/2cr.png',
					),
					'tab'     => esc_html__( 'General', 'smarket' ),
					'std'     => 'left',
				),
				array(
					'name'             => esc_html__( 'Sidebar for page layout', 'smarket' ),
					'id'               => 'smarket_page_used_sidebar',
					'type'             => 'select',
					'show_option_none' => true,
					'options'          => $sidebars,
					'desc'             => esc_html__( 'Setting sidebar in the area sidebar', 'smarket' ),
					'dependency'       => array(
						'id'    => 'smarket_page_layout',
						'value' => array( 'left', 'right' ),
					),
					'tab'              => esc_html__( 'General', 'smarket' ),
				),
				array(
					'name' => esc_html__( 'Extra page class', 'smarket' ),
					'desc' => esc_html__( 'If you wish to add extra classes to the body class of the page (for custom css use), then please add the class(es) here.', 'smarket' ),
					'id'   => 'smarket_page_extra_class',
					'type' => 'text',
					'tab'  => esc_html__( 'General', 'smarket' ),
				),
			);
			$demo_options = array();
			$demo_options = array(
				'name'    => esc_html__( 'Page type', 'smarket' ),
				'desc'    => esc_html__( "This page can be used as homepage or default page", 'smarket' ),
				'id'      => 'smarket_page_type',
				'type'    => 'select',
				'std'     => 'page',
				'options' => array(
					'page'     => esc_html__( 'Default page', 'smarket' ),
					'homepage' => esc_html__( 'Home page', 'smarket' ),
				),
				'tab'     => esc_html__( 'General', 'smarket' ),
			);
			array_push( $fields, $demo_options );
			$meta_boxes[] = array(
				'id'         => 'smarket_page_option',
				'title'      => esc_html__( 'Page Options', 'smarket' ),
				'post_types' => 'page',
				'fields'     => $fields,
			);

			/*Meta box for footer */
			$meta_boxes[] = array(
				'id'         => 'smarket_footer_option',
				'title'      => esc_html__( 'Footer Options', 'smarket' ),
				'post_types' => 'footer',
				'fields'     => array(
					array(
						'name'    => esc_html__( 'Template', 'smarket' ),
						'id'      => 'smarket_template_style',
						'type'    => 'select',
						'options' => $footer_style_options,
						'std'     => 'default',
						'tab'     => esc_html__( 'Template', 'smarket' ),
					),
				),
			);

			/*Meta box for portfolio */
			$meta_boxes[] = array(
				'id'         => 'smarket_portfolio_option',
				'title'      => esc_html__( 'Portfolio Options', 'smarket' ),
				'post_types' => 'portfolio',
				'fields'     => array(
					array(
						'name' => esc_html__( 'Gallery', 'smarket' ),
						'id'   => 'smarket_portfolio_gallery',
						'type' => 'image_advanced',
					),
				),
			);

			/*Meta box for product */
			$meta_boxes[] = array(
				'id'         => 'smarket_product_option',
				'title'      => esc_html__( 'Product Options', 'smarket' ),
				'post_types' => 'product',
				'fields'     => array(
					array(
						'name' => esc_html__( 'Video Link', 'smarket' ),
						'id'   => 'smarket_product_video',
						'type' => 'text',
					),
				),
			);

			/*Meta box for testimonial */
			$meta_boxes[] = array(
				'id'         => 'smarket_testimonial_option',
				'title'      => esc_html__( 'Testimonial Options', 'smarket' ),
				'post_types' => 'testimonial',
				'fields'     => array(
					array(
						'name' => esc_html__( 'Name', 'smarket' ),
						'id'   => 'smarket_testimonial_name',
						'type' => 'text',
					),
					array(
						'name' => esc_html__( 'Position', 'smarket' ),
						'id'   => 'smarket_testimonial_position',
						'type' => 'text',
					),
				),
			);

			/*Meta box for Mega menu */
			$meta_boxes[] = array(
				'id'         => 'smarket_mega_menu_option',
				'title'      => esc_html__( 'Mega Options', 'smarket' ),
				'post_types' => 'megamenu',
				'fields'     => array(
					array(
						'name'             => esc_html__( 'Background Image', 'smarket' ),
						'id'               => 'smarket_mega_menu_bg_image',
						'type'             => 'image_advanced',
						'max_file_uploads' => 1,
					),
					array(
						'name'    => esc_html__( 'Menu Style', 'smarket' ),
						'id'      => 'smarket_megamenu_style',
						'type'    => 'select',
						'options' => array(
							'default' => esc_html__( 'Default', 'smarket' ),
							'dark'    => esc_html__( 'Dark', 'smarket' ),
						),
						'std'     => 'default',
					),
				),
			);

			return $meta_boxes;
		}
	}
}
new  Smarket_Meta_Box_Settings();