<?php
if ( !class_exists( 'Smarket_Visual_Composer' ) ) {
	class Smarket_Visual_Composer
	{

		public function __construct()
		{
			$this->define_constants();
			add_filter( 'vc_google_fonts_get_fonts_filter', array( $this, 'vc_fonts' ) );
			add_action( 'vc_after_mapping', array( &$this, 'params' ) );
			add_action( 'vc_after_mapping', array( &$this, 'autocomplete' ) );
			/* Custom font Icon*/
			add_filter( 'vc_iconpicker-type-smarketcustomfonts', array( &$this, 'iconpicker_type_smarket_customfonts' ) );
			$this->map_shortcode();
		}

		/**
		 * Define  Constants.
		 */
		private function define_constants()
		{
			$this->define( 'SMARKET_SHORTCODE_PREVIEW', get_template_directory_uri() . "/framework/assets/images/shortcode-previews/" );
			$this->define( 'SMARKET_PRODUCT_STYLE_PREVIEW', get_template_directory_uri() . "/woocommerce/product-styles/" );

		}

		/**
		 * Define constant if not already set.
		 *
		 * @param  string $name
		 * @param  string|bool $value
		 */
		private function define( $name, $value )
		{
			if ( !defined( $name ) ) {
				define( $name, $value );
			}
		}

		function params()
		{
			if ( function_exists( 'smarket_toolkit_vc_param' ) ) {
				smarket_toolkit_vc_param( 'taxonomy', array( &$this, 'taxonomy_field' ) );
				smarket_toolkit_vc_param( 'animate', array( &$this, 'animate_field' ) );
				smarket_toolkit_vc_param( 'uniqid', array( &$this, 'uniqid_field' ) );
				smarket_toolkit_vc_param( 'select_preview', array( &$this, 'select_preview_field' ) );
				smarket_toolkit_vc_param( 'number', array( &$this, 'number_field' ) );

			}


		}

		/**
		 * load param autocomplete render
		 * */
		public function autocomplete()
		{
			add_filter( 'vc_autocomplete_smarket_products_ids_callback', array( &$this, 'productIdAutocompleteSuggester' ), 10, 1 );
			add_filter( 'vc_autocomplete_smarket_products_ids_render', array( &$this, 'productIdAutocompleteRender' ), 10, 1 );
			add_filter( 'vc_autocomplete_smarket_deal_ids_callback', array( &$this, 'productIdAutocompleteSuggester' ), 10, 1 );
			add_filter( 'vc_autocomplete_smarket_deal_ids_render', array( &$this, 'productIdAutocompleteRender' ), 10, 1 );
		}

		/*
         * taxonomy_field
         * */
		public function taxonomy_field( $settings, $value )
		{
			$dependency = '';
			$value_arr  = $value;
			if ( !is_array( $value_arr ) ) {
				$value_arr = array_map( 'trim', explode( ',', $value_arr ) );
			}
			$output = '';
			if ( isset( $settings[ 'hide_empty' ] ) && $settings[ 'hide_empty' ] ) {
				$settings[ 'hide_empty' ] = 1;
			} else {
				$settings[ 'hide_empty' ] = 0;
			}
			if ( !empty( $settings[ 'taxonomy' ] ) ) {
				$terms_fields = array();
				if ( isset( $settings[ 'placeholder' ] ) && $settings[ 'placeholder' ] ) {
					$terms_fields[] = "<option value=''>" . $settings[ 'placeholder' ] . "</option>";
				}
				$terms = get_terms( $settings[ 'taxonomy' ], array( 'hide_empty' => false, 'parent' => $settings[ 'parent' ], 'hide_empty' => $settings[ 'hide_empty' ] ) );
				if ( $terms && !is_wp_error( $terms ) ) {
					foreach ( $terms as $term ) {
						$selected       = ( in_array( $term->slug, $value_arr ) ) ? ' selected="selected"' : '';
						$terms_fields[] = "<option value='{$term->slug}' {$selected}>{$term->name}</option>";
					}
				}
				$size     = ( !empty( $settings[ 'size' ] ) ) ? 'size="' . $settings[ 'size' ] . '"' : '';
				$multiple = ( !empty( $settings[ 'multiple' ] ) ) ? 'multiple="multiple"' : '';
				$uniqeID  = uniqid();
				$output   = '<select style="width:100%;" id="vc_taxonomy-' . $uniqeID . '" ' . $multiple . ' ' . $size . ' name="' . $settings[ 'param_name' ] . '" class="smarket_vc_taxonomy wpb_vc_param_value wpb-input wpb-select ' . $settings[ 'param_name' ] . ' ' . $settings[ 'type' ] . '_field" ' . $dependency . '>'
					. implode( $terms_fields )
					. '</select>';
			}

			return $output;
		}

		public function animate_field( $settings, $value )
		{
			// Animate list
			$animate_arr = array(
				'bounce',
				'flash',
				'pulse',
				'rubberBand',
				'shake',
				'headShake',
				'swing',
				'tada',
				'wobble',
				'jello',
				'bounceIn',
				'bounceInDown',
				'bounceInLeft',
				'bounceInRight',
				'bounceInUp',
				'bounceOut',
				'bounceOutDown',
				'bounceOutLeft',
				'bounceOutRight',
				'bounceOutUp',
				'fadeIn',
				'fadeInDown',
				'fadeInDownBig',
				'fadeInLeft',
				'fadeInLeftBig',
				'fadeInRight',
				'fadeInRightBig',
				'fadeInUp',
				'fadeInUpBig',
				'fadeOut',
				'fadeOutDown',
				'fadeOutDownBig',
				'fadeOutLeft',
				'fadeOutLeftBig',
				'fadeOutRight',
				'fadeOutRightBig',
				'fadeOutUp',
				'fadeOutUpBig',
				'flipInX',
				'flipInY',
				'flipOutX',
				'flipOutY',
				'lightSpeedIn',
				'lightSpeedOut',
				'rotateIn',
				'rotateInDownLeft',
				'rotateInDownRight',
				'rotateInUpLeft',
				'rotateInUpRight',
				'rotateOut',
				'rotateOutDownLeft',
				'rotateOutDownRight',
				'rotateOutUpLeft',
				'rotateOutUpRight',
				'hinge',
				'rollIn',
				'rollOut',
				'zoomIn',
				'zoomInDown',
				'zoomInLeft',
				'zoomInRight',
				'zoomInUp',
				'zoomOut',
				'zoomOutDown',
				'zoomOutLeft',
				'zoomOutRight',
				'zoomOutUp',
				'slideInDown',
				'slideInLeft',
				'slideInRight',
				'slideInUp',
				'slideOutDown',
				'slideOutLeft',
				'slideOutRight',
				'slideOutUp',
			);
			$uniqeID     = uniqid();
			ob_start();
			?>
            <select id="kt_animate-<?php echo esc_attr($uniqeID) ?>" name="<?php echo esc_attr($settings[ 'param_name' ]); ?>"
                    class="wpb_vc_param_value wpb-input wpb-select <?php echo esc_attr($settings[ 'param_name' ]); ?> <?php echo esc_attr($settings[ 'type' ]); ?>_field">
                <option value=""><?php esc_html_e( 'None', 'smarket' ) ?></option>
				<?php foreach ( $animate_arr as $animate ):
					$selected = ( $value == $animate ) ? ' selected="selected"' : '';
					?>
                    <option value='<?php echo esc_attr( $animate ) ?>' <?php echo esc_attr( $selected ) ?>><?php echo esc_attr( $animate ) ?></option>
				<?php endforeach; ?>
            </select>
			<?php
			return ob_get_clean();
		}

		public function uniqid_field( $settings, $value )
		{
			if ( !$value ) {
				$value = uniqid( hash( 'crc32', $settings[ 'param_name' ] ) . '-' );
			}
			$output = '<input type="text" class="wpb_vc_param_value textfield" name="' . $settings[ 'param_name' ] . '" value="' . esc_attr( $value ) . '" />';

			return $output;
		}

		public function number_field( $settings, $value )
		{
			$dependency = '';
			$param_name = isset( $settings[ 'param_name' ] ) ? $settings[ 'param_name' ] : '';
			$type       = isset( $settings[ 'type ' ] ) ? $settings[ 'type' ] : '';
			$min        = isset( $settings[ 'min' ] ) ? $settings[ 'min' ] : '';
			$max        = isset( $settings[ 'max' ] ) ? $settings[ 'max' ] : '';
			$suffix     = isset( $settings[ 'suffix' ] ) ? $settings[ 'suffix' ] : '';
			$class      = isset( $settings[ 'class' ] ) ? $settings[ 'class' ] : '';
			if ( !$value && isset( $settings[ 'std' ] ) ) {
				$value = $settings[ 'std' ];
			}
			$output = '<input type="number" min="' . esc_attr( $min ) . '" max="' . esc_attr( $max ) . '" class="wpb_vc_param_value textfield ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" value="' . esc_attr( $value ) . '" ' . $dependency . ' style="max-width:100px; margin-right: 10px;" />' . $suffix;

			return $output;
		}

		public function select_preview_field( $settings, $value )
		{
			ob_start();
			// Get menus list
			$options = $settings[ 'value' ];
			$default = $settings[ 'default' ];
			if ( is_array( $options ) && count( $options ) > 0 ) {
				$uniqeID = uniqid();
				$i       = 0;
				?>
                <div class="container-select_preview">
                    <select id="kt_select_preview-<?php echo esc_attr($uniqeID); ?>" name="<?php echo esc_attr($settings[ 'param_name' ]); ?>"
                            class="smarket_select_preview vc_select_image wpb_vc_param_value wpb-input wpb-select <?php echo esc_attr($settings[ 'param_name' ]); ?> <?php echo esc_attr($settings[ 'type' ]); ?>_field">
						<?php foreach ( $options as $k => $option ): ?>
							<?php
							if ( $i == 0 ) {
								$first_value = $k;
							}
							$i++;
							?>
							<?php $selected = ( $k == $value ) ? ' selected="selected"' : ''; ?>
                            <option data-img="<?php echo esc_url( $option[ 'img' ] ); ?>"
                                    value='<?php echo esc_attr( $k ) ?>' <?php echo esc_attr( $selected ) ?>><?php echo esc_attr( $option[ 'alt' ] ) ?></option>
						<?php endforeach; ?>
                    </select>
                    <div class="image-preview">
						<?php if ( isset( $options[ $value ] ) && $options[ $value ] && ( isset( $options[ $value ][ 'img' ] ) ) ): ?>
                            <img style="margin-top: 10px; max-width: 100%;height: auto;"
                                 src="<?php echo esc_url( $options[ $value ][ 'img' ] ); ?>" alt="">
						<?php else: ?>
                            <img style="margin-top: 10px; max-width: 100%;height: auto;"
                                 src="<?php echo esc_url( $options[ $default ][ 'img' ] ); ?>" alt="">
						<?php endif; ?>
                    </div>
                </div>
				<?php
			}

			return ob_get_clean();
		}

		/**
		 * Suggester for autocomplete by id/name/title/sku
		 * @since 1.0
		 *
		 * @param $query
		 * @author Reapple
		 * @return array - id's from products with title/sku.
		 */
		public function productIdAutocompleteSuggester( $query )
		{
			global $wpdb;
			$product_id      = (int)$query;
			$post_meta_infos = $wpdb->get_results( $wpdb->prepare( "SELECT a.ID AS id, a.post_title AS title, b.meta_value AS sku
    					FROM {$wpdb->posts} AS a
    					LEFT JOIN ( SELECT meta_value, post_id  FROM {$wpdb->postmeta} WHERE `meta_key` = '_sku' ) AS b ON b.post_id = a.ID
    					WHERE a.post_type = 'product' AND ( a.ID = '%d' OR b.meta_value LIKE '%%%s%%' OR a.post_title LIKE '%%%s%%' )", $product_id > 0 ? $product_id : -1, stripslashes( $query ), stripslashes( $query )
			), ARRAY_A
			);
			$results         = array();
			if ( is_array( $post_meta_infos ) && !empty( $post_meta_infos ) ) {
				foreach ( $post_meta_infos as $value ) {
					$data            = array();
					$data[ 'value' ] = $value[ 'id' ];
					$data[ 'label' ] = esc_html__( 'Id', 'smarket' ) . ': ' . $value[ 'id' ] . ( ( strlen( $value[ 'title' ] ) > 0 ) ? ' - ' . esc_html__( 'Title', 'smarket' ) . ': ' . $value[ 'title' ] : '' ) . ( ( strlen( $value[ 'sku' ] ) > 0 ) ? ' - ' . esc_html__( 'Sku', 'smarket' ) . ': ' . $value[ 'sku' ] : '' );
					$results[]       = $data;
				}
			}

			return $results;
		}

		/**
		 * Find product by id
		 * @since 1.0
		 *
		 * @param $query
		 * @author Reapple
		 *
		 * @return bool|array
		 */
		public function productIdAutocompleteRender( $query )
		{
			$query = trim( $query[ 'value' ] ); // get value from requested
			if ( !empty( $query ) ) {
				// get product
				$product_object = wc_get_product( (int)$query );
				if ( is_object( $product_object ) ) {
					$product_sku         = $product_object->get_sku();
					$product_title       = $product_object->get_title();
					$product_id          = $product_object->get_id();
					$product_sku_display = '';
					if ( !empty( $product_sku ) ) {
						$product_sku_display = ' - ' . esc_html__( 'Sku', 'smarket' ) . ': ' . $product_sku;
					}
					$product_title_display = '';
					if ( !empty( $product_title ) ) {
						$product_title_display = ' - ' . esc_html__( 'Title', 'smarket' ) . ': ' . $product_title;
					}
					$product_id_display = esc_html__( 'Id', 'smarket' ) . ': ' . $product_id;
					$data               = array();
					$data[ 'value' ]    = $product_id;
					$data[ 'label' ]    = $product_id_display . $product_title_display . $product_sku_display;

					return !empty( $data ) ? $data : false;
				}

				return false;
			}

			return false;
		}

		public function vc_fonts( $fonts_list )
		{
			/* Gotham */
			$Gotham              = new stdClass();
			$Gotham->font_family = "Gotham";
			$Gotham->font_styles = "100,300,400,600,700";
			$Gotham->font_types  = "300 Light:300:light,400 Normal:400:normal";

			$fonts = array( $Gotham );

			return array_merge( $fonts_list, $fonts );
		}

		/* Custom Font icon*/
		function iconpicker_type_smarket_customfonts( $icons )
		{
			$customfonts_icons = array(
				array( 'pe-7s-plane' => '01' ),
				array( 'pe-7s-back' => '02' ),
				array( 'pe-7s-help2' => '03' ),
				array( 'pe-7s-door-lock' => '04' ),
			);

			return array_merge( $icons, $customfonts_icons );
		}

		public static function map_shortcode()
		{
			/* ADD PARAM*/
			// Update parameters for Row.
			vc_add_params(
				'vc_single_image',
				array(
					array(
						'param_name' => 'image_effect',
						'heading'    => esc_html__( 'Effect', 'smarket' ),
						'group'      => esc_html__( 'Image Effect', 'smarket' ),
						'type'       => 'dropdown',
						'value'      => array(
							esc_html__( 'Normal Effect', 'smarket' ) => 'normal-effect',
							esc_html__( 'Plus Zoom', 'smarket' ) => 'plus-zoom',
							esc_html__( 'Underline Center', 'smarket' ) => 'underline-center',
                            esc_html__( 'None', 'smarket' )    => '',
						),
						'sdt'        => 'normal-effect',
					),
				)
			);
			// Map new Tabs element.
			vc_map(
				array(
					'name'                    => esc_html__( 'Smarket: Tabs', 'smarket' ),
					'base'                    => 'smarket_tabs',
					'icon'                    => 'icon-wpb-ui-tab-content',
					'is_container'            => true,
					'show_settings_on_create' => false,
					'as_parent'               => array(
						'only' => 'vc_tta_section',
					),
					'category'                => esc_html__( 'Smarket Elements', 'smarket' ),
					'description'             => esc_html__( 'Tabbed content', 'smarket' ),
					'params'                  => array(
						array(
							'type'        => 'select_preview',
							'heading'     => esc_html__( 'Select style', 'smarket' ),
							'value'       => array(
								'default' => array(
									'alt' => 'Default', //SMARKET_SHORTCODE_PREVIEW
									'img' => SMARKET_SHORTCODE_PREVIEW . '/tabs/default.jpg',
								),
								'style1'  => array(
									'alt' => 'Style 01', //SMARKET_SHORTCODE_PREVIEW
									'img' => SMARKET_SHORTCODE_PREVIEW . '/tabs/layout1.jpg',
								),
							),
							'default'     => 'default',
							'admin_label' => true,
							'param_name'  => 'style',
						),
						array(
							'type'        => 'textfield',
							'heading'     => esc_html__( 'Tabs title', 'smarket' ),
							'param_name'  => 'tab_title',
							'value'       => '',
							'admin_label' => true,
							'dependency'  => array(
								'element' => 'style',
								'value'   => 'style1',
							),
						),
						array(
							'param_name'  => 'title_style',
							'heading'     => esc_html__( 'Tabs title style', 'smarket' ),
							'type'        => 'dropdown',
							'admin_label' => true,
							'value'       => array(
								esc_html__( 'Style 1', 'smarket' ) => 'style-1',
								esc_html__( 'Style 2', 'smarket' ) => 'style-2',
							),
							'std'         => 'style-1',
							'dependency'  => array(
								'element' => 'style',
								'value'   => 'style1',
							),
						),
						array(
							"type"        => "colorpicker",
							"heading"     => esc_html__( "Color", 'smarket' ),
							"param_name"  => "color",
							'value'       => '#FF7F00',
							"description" => esc_html__( "Choose color", 'smarket' ),
							"dependency"  => array(
								"element" => "style",
								"value"   => array( 'default' ),
							),
						),
						array(
							'type'        => 'textfield',
							'heading'     => esc_html__( 'Tabs Link padding', 'smarket' ),
							'param_name'  => 'tab_padding',
							'std'         => '0',
							'admin_label' => true,
						),
						array(
							'type'        => 'animate',
							'heading'     => esc_html__( 'Tabs animate', 'smarket' ),
							'param_name'  => 'tab_animate',
							'value'       => '',
							'admin_label' => false,
						),
						array(
							'param_name' => 'ajax_check',
							'heading'    => esc_html__( 'Using Ajax Tabs', 'smarket' ),
							'type'       => 'dropdown',
							'value'      => array(
								esc_html__( 'Yes', 'smarket' ) => '1',
								esc_html__( 'No', 'smarket' )  => '0',
							),
							'std'        => '0',
						),
						array(
							'type'        => 'textfield',
							'heading'     => esc_html__( 'Extra class name', 'smarket' ),
							'param_name'  => 'el_class',
							'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'smarket' ),
						),
						array(
							'type'       => 'css_editor',
							'heading'    => esc_html__( 'CSS box', 'smarket' ),
							'param_name' => 'css',
							'group'      => esc_html__( 'Design Options', 'smarket' ),
						),
						array(
							'param_name'       => 'tabs_custom_id',
							'heading'          => esc_html__( 'Hidden ID', 'smarket' ),
							'type'             => 'uniqid',
							'edit_field_class' => 'hidden',
						),
						array(
							'type'             => 'checkbox',
							'param_name'       => 'collapsible_all',
							'heading'          => esc_html__( 'Allow collapse all?', 'smarket' ),
							'description'      => esc_html__( 'Allow collapse all accordion sections.', 'smarket' ),
							'edit_field_class' => 'hidden',
						),
					),
					'js_view'                 => 'VcBackendTtaTabsView',
					'custom_markup'           => '
                    <div class="vc_tta-container" data-vc-action="collapse">
                        <div class="vc_general vc_tta vc_tta-tabs vc_tta-color-backend-tabs-white vc_tta-style-flat vc_tta-shape-rounded vc_tta-spacing-1 vc_tta-tabs-position-top vc_tta-controls-align-left">
                            <div class="vc_tta-tabs-container">'
						. '<ul class="vc_tta-tabs-list">'
						. '<li class="vc_tta-tab" data-vc-tab data-vc-target-model-id="{{ model_id }}" data-element_type="vc_tta_section"><a href="javascript:;" data-vc-tabs data-vc-container=".vc_tta" data-vc-target="[data-model-id=\'{{ model_id }}\']" data-vc-target-model-id="{{ model_id }}"><span class="vc_tta-title-text">{{ section_title }}</span></a></li>'
						. '</ul>
                            </div>
                            <div class="vc_tta-panels vc_clearfix {{container-class}}">
                              {{ content }}
                            </div>
                        </div>
                    </div>',
					'default_content'         => '
                        [vc_tta_section title="' . sprintf( '%s %d', esc_html__( 'Tab', 'smarket' ), 1 ) . '"][/vc_tta_section]
                        [vc_tta_section title="' . sprintf( '%s %d', esc_html__( 'Tab', 'smarket' ), 2 ) . '"][/vc_tta_section]
                    ',
					'admin_enqueue_js'        => array(
						vc_asset_url( 'lib/vc_tabs/vc-tabs.min.js' ),
					),
				)
			);

			// Map new Products
			// CUSTOM PRODUCT SIZE
			$product_size_width_list = array();
			$width                   = 300;
			$height                  = 300;
			$crop                    = 1;
			if ( function_exists( 'wc_get_image_size' ) ) {
				$size   = wc_get_image_size( 'shop_catalog' );
				$width  = isset( $size[ 'width' ] ) ? $size[ 'width' ] : $width;
				$height = isset( $size[ 'height' ] ) ? $size[ 'height' ] : $height;
				$crop   = isset( $size[ 'crop' ] ) ? $size[ 'crop' ] : $crop;
			}
			for ( $i = 100; $i < $width; $i = $i + 10 ) {
				array_push( $product_size_width_list, $i );
			}
			$product_size_list                           = array();
			$product_size_list[ $width . 'x' . $height ] = $width . 'x' . $height;
			foreach ( $product_size_width_list as $k => $w ) {
				$w = intval( $w );
				if ( isset( $width ) && $width > 0 ) {
					$h = round( $height * $w / $width );
				} else {
					$h = $w;
				}
				$product_size_list[ $w . 'x' . $h ] = $w . 'x' . $h;
			}
			$product_size_list[ 'Custom' ] = 'custom';
			$attributes_tax                = array();
			if ( function_exists( 'wc_get_attribute_taxonomies' ) ) {
				$attributes_tax = wc_get_attribute_taxonomies();
			}

			$attributes = array();
			if ( is_array( $attributes_tax ) && count( $attributes_tax ) > 0 ) {
				foreach ( $attributes_tax as $attribute ) {
					$attributes[ $attribute->attribute_label ] = $attribute->attribute_name;
				}
			}


			vc_map(
				array(
					'name'        => esc_html__( 'Smarket: Products', 'smarket' ),
					'base'        => 'smarket_products', // shortcode
					'class'       => '',
					'category'    => esc_html__( 'Smarket Elements', 'smarket' ),
					'description' => esc_html__( 'Display a product list.', 'smarket' ),
					'params'      => array(
						array(
							'heading'     => esc_html__( 'Title', 'smarket' ),
							'description' => esc_html__( 'title of shortcode.', 'smarket' ),
							'type'        => 'textfield',
							'param_name'  => 'the_title',
							'admin_label' => true,
						),
						array(
							'type'        => 'dropdown',
							'heading'     => esc_html__( 'Title style', 'smarket' ),
							'param_name'  => 'title_style',
							'value'       => array(
								esc_html__( 'Style 01', 'smarket' ) => 'style-1',
								esc_html__( 'Style 02', 'smarket' ) => 'style-2',
							),
							'description' => esc_html__( 'Select a Title style.', 'smarket' ),
							'admin_label' => true,
							'std'         => 'style-1',
						),
						array(
							'type'        => 'dropdown',
							'heading'     => esc_html__( 'Product List style', 'smarket' ),
							'param_name'  => 'productsliststyle',
							'value'       => array(
								esc_html__( 'Grid', 'smarket' )         => 'grid',
								esc_html__( 'Owl Carousel', 'smarket' ) => 'owl',
							),
							'description' => esc_html__( 'Select a style for list', 'smarket' ),
							'admin_label' => true,
							'std'         => 'grid',
							"dependency"  => array( "element" => "product_style", "value" => array( '1', '3', '4', '5', '6', '7' ) ),
						),
						array(
							'type'        => 'select_preview',
							'heading'     => esc_html__( 'Product style', 'smarket' ),
							'value'       => array(
								'1' => array(
									'alt' => esc_html__( 'Style 01', 'smarket' ),
									'img' => SMARKET_PRODUCT_STYLE_PREVIEW . 'content-product-style-1.jpg',
								),
								'2' => array(
									'alt' => esc_html__( 'Style 02', 'smarket' ),
									'img' => SMARKET_PRODUCT_STYLE_PREVIEW . 'content-product-style-2.jpg',
								),
								'3' => array(
									'alt' => esc_html__( 'Style 03', 'smarket' ),
									'img' => SMARKET_PRODUCT_STYLE_PREVIEW . 'content-product-style-3.jpg',
								),
								'4' => array(
									'alt' => esc_html__( 'Style 04', 'smarket' ),
									'img' => SMARKET_PRODUCT_STYLE_PREVIEW . 'content-product-style-4.jpg',
								),
								'5' => array(
									'alt' => esc_html__( 'Style 05', 'smarket' ),
									'img' => SMARKET_PRODUCT_STYLE_PREVIEW . 'content-product-style-5.jpg',
								),
								'6' => array(
									'alt' => esc_html__( 'Style 06', 'smarket' ),
									'img' => SMARKET_PRODUCT_STYLE_PREVIEW . 'content-product-style-6.jpg',
								),
								'7' => array(
									'alt' => esc_html__( 'Style 07', 'smarket' ),
									'img' => SMARKET_PRODUCT_STYLE_PREVIEW . 'content-product-style-7.jpg',
								),
							),
							'default'     => '1',
							'admin_label' => true,
							'param_name'  => 'product_style',
							'description' => esc_html__( 'Select a style for product item', 'smarket' ),
						),
						/* countdown */
						array(
							'heading'     => esc_html__( 'Description', 'smarket' ),
							'description' => esc_html__( 'description of shortcode.', 'smarket' ),
							'type'        => 'textarea',
							'param_name'  => 'des',
							"dependency"  => array( "element" => "product_style", "value" => array( '2' ) ),
							'group'       => esc_html__( 'Countdown options', 'smarket' ),
						),
						array(
							'heading'     => esc_html__( 'Number', 'smarket' ),
							'description' => esc_html__( 'Number of gallery to show.', 'smarket' ),
							'type'        => 'textfield',
							'std'         => '4',
							'param_name'  => 'number_gallery',
							"dependency"  => array( "element" => "product_style", "value" => array( '2' ) ),
							'group'       => esc_html__( 'Countdown options', 'smarket' ),
						),
						array(
							'heading'          => esc_html__( 'Year', 'smarket' ),
							'description'      => esc_html__( 'year of countdown.', 'smarket' ),
							'type'             => 'textfield',
							'std'              => '0000',
							'param_name'       => 'year',
							"dependency"       => array( "element" => "product_style", "value" => array( '2' ) ),
							'group'            => esc_html__( 'Countdown options', 'smarket' ),
							'edit_field_class' => 'vc_col-sm-4',
						),
						array(
							'heading'          => esc_html__( 'Month', 'smarket' ),
							'description'      => esc_html__( 'Month of countdown.', 'smarket' ),
							'type'             => 'textfield',
							'std'              => '00',
							'param_name'       => 'month',
							"dependency"       => array( "element" => "product_style", "value" => array( '2' ) ),
							'group'            => esc_html__( 'Countdown options', 'smarket' ),
							'edit_field_class' => 'vc_col-sm-4',
						),
						array(
							'heading'          => esc_html__( 'Day', 'smarket' ),
							'description'      => esc_html__( 'day of countdown.', 'smarket' ),
							'type'             => 'textfield',
							'std'              => '00',
							'param_name'       => 'day',
							"dependency"       => array( "element" => "product_style", "value" => array( '2' ) ),
							'group'            => esc_html__( 'Countdown options', 'smarket' ),
							'edit_field_class' => 'vc_col-sm-4',
						),
						array(
							'heading'          => esc_html__( 'Hour', 'smarket' ),
							'description'      => esc_html__( 'Hour of countdown.', 'smarket' ),
							'type'             => 'textfield',
							'std'              => '0',
							'param_name'       => 'hour',
							"dependency"       => array( "element" => "product_style", "value" => array( '2' ) ),
							'group'            => esc_html__( 'Countdown options', 'smarket' ),
							'edit_field_class' => 'vc_col-sm-4',
						),
						array(
							'heading'          => esc_html__( 'Mins', 'smarket' ),
							'description'      => esc_html__( 'Mins of countdown.', 'smarket' ),
							'type'             => 'textfield',
							'std'              => '0',
							'param_name'       => 'mins',
							"dependency"       => array( "element" => "product_style", "value" => array( '2' ) ),
							'group'            => esc_html__( 'Countdown options', 'smarket' ),
							'edit_field_class' => 'vc_col-sm-4',
						),
						array(
							'heading'          => esc_html__( 'Secs', 'smarket' ),
							'description'      => esc_html__( 'Secs of countdown.', 'smarket' ),
							'type'             => 'textfield',
							'std'              => '0',
							'param_name'       => 'secs',
							"dependency"       => array( "element" => "product_style", "value" => array( '2' ) ),
							'group'            => esc_html__( 'Countdown options', 'smarket' ),
							'edit_field_class' => 'vc_col-sm-4',
						),
						/* countdown */
						array(
							'type'        => 'dropdown',
							'heading'     => esc_html__( 'Image size', 'smarket' ),
							'param_name'  => 'product_image_size',
							'value'       => $product_size_list,
							'description' => esc_html__( 'Select a size for product', 'smarket' ),
							'admin_label' => true,
							"dependency"  => array( "element" => "product_style", "value" => array( '1', '2', '3', '5', '6', '7' ) ),
						),
						array(
							"type"       => "textfield",
							"heading"    => esc_html__( "Width", 'smarket' ),
							"param_name" => "product_custom_thumb_width",
							"value"      => $width,
							"suffix"     => esc_html__( "px", 'smarket' ),
							"dependency" => array( "element" => "product_image_size", "value" => array( 'custom' ) ),
						),
						array(
							"type"       => "textfield",
							"heading"    => esc_html__( "Height", 'smarket' ),
							"param_name" => "product_custom_thumb_height",
							"value"      => $height,
							"suffix"     => esc_html__( "px", 'smarket' ),
							"dependency" => array( "element" => "product_image_size", "value" => array( 'custom' ) ),
						),
						/*Products */
						array(
							"type"        => "taxonomy",
							"taxonomy"    => "product_cat",
							"class"       => "",
							"heading"     => esc_html__( "Product Category", 'smarket' ),
							"param_name"  => "taxonomy",
							"value"       => '',
							'parent'      => '',
							'multiple'    => true,
							'hide_empty'  => false,
							'placeholder' => esc_html__( 'Choose category', 'smarket' ),
							"description" => esc_html__( "Note: If you want to narrow output, select category(s) above. Only selected categories will be displayed.", 'smarket' ),
							'std'         => '',
							'group'       => esc_html__( 'Products options', 'smarket' ),
						),
						array(
							'type'        => 'dropdown',
							'heading'     => esc_html__( 'Target', 'smarket' ),
							'param_name'  => 'target',
							'value'       => array(
								esc_html__( 'Best Selling Products', 'smarket' ) => 'best-selling',
								esc_html__( 'Top Rated Products', 'smarket' )    => 'top-rated',
								esc_html__( 'Recent Products', 'smarket' )       => 'recent-product',
								esc_html__( 'Product Category', 'smarket' )      => 'product-category',
								esc_html__( 'Products', 'smarket' )              => 'products',
								esc_html__( 'Featured Products', 'smarket' )     => 'featured_products',
								esc_html__( 'On Sale', 'smarket' )               => 'on_sale',
								esc_html__( 'On New', 'smarket' )                => 'on_new',
							),
							'description' => esc_html__( 'Choose the target to filter products', 'smarket' ),
							'std'         => 'recent-product',
							'group'       => esc_html__( 'Products options', 'smarket' ),
						),
						array(
							"type"        => "dropdown",
							"heading"     => esc_html__( "Order by", 'smarket' ),
							"param_name"  => "orderby",
							"value"       => array(
								'',
								esc_html__( 'Date', 'smarket' )          => 'date',
								esc_html__( 'ID', 'smarket' )            => 'ID',
								esc_html__( 'Author', 'smarket' )        => 'author',
								esc_html__( 'Title', 'smarket' )         => 'title',
								esc_html__( 'Modified', 'smarket' )      => 'modified',
								esc_html__( 'Random', 'smarket' )        => 'rand',
								esc_html__( 'Comment count', 'smarket' ) => 'comment_count',
								esc_html__( 'Menu order', 'smarket' )    => 'menu_order',
								esc_html__( 'Sale price', 'smarket' )    => '_sale_price',
							),
							'std'         => 'date',
							"description" => esc_html__( "Select how to sort.", 'smarket' ),
							"dependency"  => array( "element" => "target", "value" => array( 'top-rated', 'recent-product', 'product-category', 'featured_products', 'on_sale', 'on_new', 'product_attribute' ) ),
							'group'       => esc_html__( 'Products options', 'smarket' ),
						),
						array(
							"type"        => "dropdown",
							"heading"     => esc_html__( "Order", 'smarket' ),
							"param_name"  => "order",
							"value"       => array(
								esc_html__( 'ASC', 'smarket' )  => 'ASC',
								esc_html__( 'DESC', 'smarket' ) => 'DESC',
							),
							'std'         => 'DESC',
							"description" => esc_html__( "Designates the ascending or descending order.", 'smarket' ),
							"dependency"  => array( "element" => "target", "value" => array( 'top-rated', 'recent-product', 'product-category', 'featured_products', 'on_sale', 'on_new', 'product_attribute' ) ),
							'group'       => esc_html__( 'Products options', 'smarket' ),
						),
						array(
							'type'       => 'textfield',
							'heading'    => esc_html__( 'Product per page', 'smarket' ),
							'param_name' => 'per_page',
							'value'      => 6,
							"dependency" => array( "element" => "target", "value" => array( 'best-selling', 'top-rated', 'recent-product', 'product-category', 'featured_products', 'product_attribute', 'on_sale', 'on_new' ) ),
							'group'      => esc_html__( 'Products options', 'smarket' ),
						),
						array(
							'type'        => 'autocomplete',
							'heading'     => esc_html__( 'Products', 'smarket' ),
							'param_name'  => 'ids',
							'settings'    => array(
								'multiple'      => true,
								'sortable'      => true,
								'unique_values' => true,
							),
							'save_always' => true,
							'description' => esc_html__( 'Enter List of Products', 'smarket' ),
							"dependency"  => array( "element" => "target", "value" => array( 'products' ) ),
							'group'       => esc_html__( 'Products options', 'smarket' ),
						),
						/* OWL Settings */
						array(
							'type'        => 'dropdown',
							'value'       => array(
								esc_html__( '1 Row', 'smarket' )  => '1',
								esc_html__( '2 Rows', 'smarket' ) => '2',
								esc_html__( '3 Rows', 'smarket' ) => '3',
								esc_html__( '4 Rows', 'smarket' ) => '4',
								esc_html__( '5 Rows', 'smarket' ) => '5',
							),
							'std'         => '1',
							'heading'     => esc_html__( 'The number of rows which are shown on block', 'smarket' ),
							'param_name'  => 'owl_number_row',
							'group'       => esc_html__( 'Carousel settings', 'smarket' ),
							'admin_label' => false,
							"dependency"  => array(
								"element" => "productsliststyle", "value" => array( 'owl' ),
							),
						),

						array(
							'type'       => 'dropdown',
							'heading'    => esc_html__( 'Rows space', 'smarket' ),
							'param_name' => 'owl_rows_space',
							'value'      => array(
								esc_html__( 'Default', 'smarket' ) => 'rows-space-0',
								esc_html__( '10px', 'smarket' )    => 'rows-space-10',
								esc_html__( '20px', 'smarket' )    => 'rows-space-20',
								esc_html__( '30px', 'smarket' )    => 'rows-space-30',
								esc_html__( '40px', 'smarket' )    => 'rows-space-40',
								esc_html__( '50px', 'smarket' )    => 'rows-space-50',
								esc_html__( '60px', 'smarket' )    => 'rows-space-60',
								esc_html__( '70px', 'smarket' )    => 'rows-space-70',
								esc_html__( '80px', 'smarket' )    => 'rows-space-80',
								esc_html__( '90px', 'smarket' )    => 'rows-space-90',
								esc_html__( '100px', 'smarket' )   => 'rows-space-100',
							),
							'std'        => 'rows-space-0',
							'group'      => esc_html__( 'Carousel settings', 'smarket' ),
							"dependency" => array( "element" => "owl_number_row", "value" => array( '2', '3', '4', '5' ) ),
						),
						array(
							'type'        => 'dropdown',
							'value'       => array(
								esc_html__( 'Yes', 'smarket' ) => 'true',
								esc_html__( 'No', 'smarket' )  => 'false',
							),
							'std'         => 'false',
							'heading'     => esc_html__( 'AutoPlay', 'smarket' ),
							'param_name'  => 'owl_autoplay',
							'group'       => esc_html__( 'Carousel settings', 'smarket' ),
							'admin_label' => false,
							"dependency"  => array(
								"element" => "productsliststyle", "value" => array( 'owl' ),
							),
						),
						array(
							'type'        => 'dropdown',
							'value'       => array(
								esc_html__( 'No', 'smarket' )  => 'false',
								esc_html__( 'Yes', 'smarket' ) => 'true',
							),
							'std'         => false,
							'heading'     => esc_html__( 'Navigation', 'smarket' ),
							'param_name'  => 'owl_navigation',
							'description' => esc_html__( "Show buton 'next' and 'prev' buttons.", 'smarket' ),
							'group'       => esc_html__( 'Carousel settings', 'smarket' ),
							"dependency"  => array(
								"element" => "productsliststyle", "value" => array( 'owl' ),
							),
							'admin_label' => false,
						),
						array(
							'type'        => 'dropdown',
							'value'       => array(
								esc_html__( 'Yes', 'smarket' ) => 'true',
								esc_html__( 'No', 'smarket' )  => 'false',
							),
							'std'         => false,
							'heading'     => esc_html__( 'Loop', 'smarket' ),
							'param_name'  => 'owl_loop',
							'description' => esc_html__( "Inifnity loop. Duplicate last and first items to get loop illusion.", 'smarket' ),
							'group'       => esc_html__( 'Carousel settings', 'smarket' ),
							'admin_label' => false,
							"dependency"  => array(
								"element" => "productsliststyle", "value" => array( 'owl' ),
							),
						),
						array(
							"type"        => "textfield",
							"heading"     => esc_html__( "Slide Speed", 'smarket' ),
							"param_name"  => "owl_slidespeed",
							"value"       => "200",
							"suffix"      => esc_html__( "milliseconds", 'smarket' ),
							"description" => esc_html__( 'Slide speed in milliseconds', 'smarket' ),
							'group'       => esc_html__( 'Carousel settings', 'smarket' ),
							'admin_label' => false,
							"dependency"  => array(
								"element" => "productsliststyle", "value" => array( 'owl' ),
							),
						),
						array(
							"type"        => "textfield",
							"heading"     => esc_html__( "Margin", 'smarket' ),
							"param_name"  => "owl_margin",
							"value"       => "0",
							"description" => esc_html__( 'Distance( or space) between 2 item', 'smarket' ),
							'group'       => esc_html__( 'Carousel settings', 'smarket' ),
							'admin_label' => false,
							"dependency"  => array(
								"element" => "productsliststyle", "value" => array( 'owl' ),
							),
						),
						array(
							"type"        => "textfield",
							"heading"     => esc_html__( "The items on desktop (Screen resolution of device >= 1500px )", 'smarket' ),
							"param_name"  => "owl_ls_items",
							"value"       => "5",
							'group'       => esc_html__( 'Carousel settings', 'smarket' ),
							'admin_label' => false,
							"dependency"  => array(
								"element" => "productsliststyle", "value" => array( 'owl' ),
							),
						),
						array(
							"type"        => "textfield",
							"heading"     => esc_html__( "The items on desktop (Screen resolution of device >= 1200px and < 1500px )", 'smarket' ),
							"param_name"  => "owl_lg_items",
							"value"       => "4",
							'group'       => esc_html__( 'Carousel settings', 'smarket' ),
							'admin_label' => false,
							"dependency"  => array(
								"element" => "productsliststyle", "value" => array( 'owl' ),
							),
						),
						array(
							"type"        => "textfield",
							"heading"     => esc_html__( "The items on desktop (Screen resolution of device >= 992px < 1200px )", 'smarket' ),
							"param_name"  => "owl_md_items",
							"value"       => "3",
							'group'       => esc_html__( 'Carousel settings', 'smarket' ),
							'admin_label' => false,
							"dependency"  => array(
								"element" => "productsliststyle", "value" => array( 'owl' ),
							),
						),
						array(
							"type"        => "textfield",
							"heading"     => esc_html__( "The items on tablet (Screen resolution of device >=768px and < 992px )", 'smarket' ),
							"param_name"  => "owl_sm_items",
							"value"       => "3",
							'group'       => esc_html__( 'Carousel settings', 'smarket' ),
							'admin_label' => false,
							"dependency"  => array(
								"element" => "productsliststyle", "value" => array( 'owl' ),
							),
						),
						array(
							"type"        => "textfield",
							"heading"     => esc_html__( "The items on mobile landscape(Screen resolution of device >=480px and < 768px)", 'smarket' ),
							"param_name"  => "owl_xs_items",
							"value"       => "2",
							'group'       => esc_html__( 'Carousel settings', 'smarket' ),
							'admin_label' => false,
							"dependency"  => array(
								"element" => "productsliststyle", "value" => array( 'owl' ),
							),
						),
						array(
							"type"        => "textfield",
							"heading"     => esc_html__( "The items on mobile (Screen resolution of device < 480px)", 'smarket' ),
							"param_name"  => "owl_ts_items",
							"value"       => "1",
							'group'       => esc_html__( 'Carousel settings', 'smarket' ),
							'admin_label' => false,
							"dependency"  => array(
								"element" => "productsliststyle", "value" => array( 'owl' ),
							),
						),
						/* Bostrap setting */
						array(
							'type'       => 'dropdown',
							'heading'    => esc_html__( 'Rows space', 'smarket' ),
							'param_name' => 'boostrap_rows_space',
							'value'      => array(
								esc_html__( 'Default', 'smarket' ) => 'rows-space-0',
								esc_html__( '10px', 'smarket' )    => 'rows-space-10',
								esc_html__( '20px', 'smarket' )    => 'rows-space-20',
								esc_html__( '30px', 'smarket' )    => 'rows-space-30',
								esc_html__( '40px', 'smarket' )    => 'rows-space-40',
								esc_html__( '50px', 'smarket' )    => 'rows-space-50',
								esc_html__( '60px', 'smarket' )    => 'rows-space-60',
								esc_html__( '70px', 'smarket' )    => 'rows-space-70',
								esc_html__( '80px', 'smarket' )    => 'rows-space-80',
								esc_html__( '90px', 'smarket' )    => 'rows-space-90',
								esc_html__( '100px', 'smarket' )   => 'rows-space-100',
							),
							'std'        => 'rows-space-0',
							'group'      => esc_html__( 'Boostrap settings', 'smarket' ),
							"dependency" => array(
								"element" => "productsliststyle", "value" => array( 'grid' ),
							),
						),
						array(
							'type'        => 'dropdown',
							'heading'     => esc_html__( 'Items per row on Desktop', 'smarket' ),
							'param_name'  => 'boostrap_bg_items',
							'value'       => array(
								esc_html__( '1 item', 'smarket' )  => '12',
								esc_html__( '2 items', 'smarket' ) => '6',
								esc_html__( '3 items', 'smarket' ) => '4',
								esc_html__( '4 items', 'smarket' ) => '3',
								esc_html__( '5 items', 'smarket' ) => '15',
								esc_html__( '6 items', 'smarket' ) => '2',
							),
							'description' => esc_html__( '(Item per row on screen resolution of device >= 1500px )', 'smarket' ),
							'group'       => esc_html__( 'Boostrap settings', 'smarket' ),
							'std'         => '15',
							"dependency"  => array(
								"element" => "productsliststyle", "value" => array( 'grid' ),
							),
						),
						array(
							'type'        => 'dropdown',
							'heading'     => esc_html__( 'Items per row on Desktop', 'smarket' ),
							'param_name'  => 'boostrap_lg_items',
							'value'       => array(
								esc_html__( '1 item', 'smarket' )  => '12',
								esc_html__( '2 items', 'smarket' ) => '6',
								esc_html__( '3 items', 'smarket' ) => '4',
								esc_html__( '4 items', 'smarket' ) => '3',
								esc_html__( '5 items', 'smarket' ) => '15',
								esc_html__( '6 items', 'smarket' ) => '2',
							),
							'description' => esc_html__( '(Item per row on screen resolution of device >= 1200px and < 1500px )', 'smarket' ),
							'group'       => esc_html__( 'Boostrap settings', 'smarket' ),
							'std'         => '3',
							"dependency"  => array(
								"element" => "productsliststyle", "value" => array( 'grid' ),
							),
						),
						array(
							'type'        => 'dropdown',
							'heading'     => esc_html__( 'Items per row on landscape tablet', 'smarket' ),
							'param_name'  => 'boostrap_md_items',
							'value'       => array(
								esc_html__( '1 item', 'smarket' )  => '12',
								esc_html__( '2 items', 'smarket' ) => '6',
								esc_html__( '3 items', 'smarket' ) => '4',
								esc_html__( '4 items', 'smarket' ) => '3',
								esc_html__( '5 items', 'smarket' ) => '15',
								esc_html__( '6 items', 'smarket' ) => '2',
							),
							'description' => esc_html__( '(Item per row on screen resolution of device >=992px and < 1200px )', 'smarket' ),
							'group'       => esc_html__( 'Boostrap settings', 'smarket' ),
							'std'         => '3',
							"dependency"  => array(
								"element" => "productsliststyle", "value" => array( 'grid' ),
							),
						),
						array(
							'type'        => 'dropdown',
							'heading'     => esc_html__( 'Items per row on portrait tablet', 'smarket' ),
							'param_name'  => 'boostrap_sm_items',
							'value'       => array(
								esc_html__( '1 item', 'smarket' )  => '12',
								esc_html__( '2 items', 'smarket' ) => '6',
								esc_html__( '3 items', 'smarket' ) => '4',
								esc_html__( '4 items', 'smarket' ) => '3',
								esc_html__( '5 items', 'smarket' ) => '15',
								esc_html__( '6 items', 'smarket' ) => '2',
							),
							'description' => esc_html__( '(Item per row on screen resolution of device >=768px and < 992px )', 'smarket' ),
							'group'       => esc_html__( 'Boostrap settings', 'smarket' ),
							'std'         => '4',
							"dependency"  => array(
								"element" => "productsliststyle", "value" => array( 'grid' ),
							),
						),
						array(
							'type'        => 'dropdown',
							'heading'     => esc_html__( 'Items per row on Mobile', 'smarket' ),
							'param_name'  => 'boostrap_xs_items',
							'value'       => array(
								esc_html__( '1 item', 'smarket' )  => '12',
								esc_html__( '2 items', 'smarket' ) => '6',
								esc_html__( '3 items', 'smarket' ) => '4',
								esc_html__( '4 items', 'smarket' ) => '3',
								esc_html__( '5 items', 'smarket' ) => '15',
								esc_html__( '6 items', 'smarket' ) => '2',
							),
							'description' => esc_html__( '(Item per row on screen resolution of device >=480  add < 768px )', 'smarket' ),
							'group'       => esc_html__( 'Boostrap settings', 'smarket' ),
							'std'         => '6',
							"dependency"  => array(
								"element" => "productsliststyle", "value" => array( 'grid' ),
							),
						),
						array(
							'type'        => 'dropdown',
							'heading'     => esc_html__( 'Items per row on Mobile', 'smarket' ),
							'param_name'  => 'boostrap_ts_items',
							'value'       => array(
								esc_html__( '1 item', 'smarket' )  => '12',
								esc_html__( '2 items', 'smarket' ) => '6',
								esc_html__( '3 items', 'smarket' ) => '4',
								esc_html__( '4 items', 'smarket' ) => '3',
								esc_html__( '5 items', 'smarket' ) => '15',
								esc_html__( '6 items', 'smarket' ) => '2',
							),
							'description' => esc_html__( '(Item per row on screen resolution of device < 480px)', 'smarket' ),
							'group'       => esc_html__( 'Boostrap settings', 'smarket' ),
							'std'         => '12',
							"dependency"  => array(
								"element" => "productsliststyle", "value" => array( 'grid' ),
							),
						),
						array(
							"type"        => "textfield",
							"heading"     => esc_html__( "Extra class name", "smarket" ),
							"param_name"  => "el_class",
							"description" => esc_html__( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "smarket" ),
						),
						array(
							'type'       => 'css_editor',
							'heading'    => esc_html__( 'Css', 'smarket' ),
							'param_name' => 'css',
							'group'      => esc_html__( 'Design options', 'smarket' ),
						),
						array(
							'param_name'       => 'products_custom_id',
							'heading'          => esc_html__( 'Hidden ID', 'smarket' ),
							'type'             => 'uniqid',
							'edit_field_class' => 'hidden',
						),
					),
				)
			);
			/* new icon box*/
			vc_map(
				array(
					'name'     => esc_html__( 'Smarket: Icon Box', 'smarket' ),
					'base'     => 'smarket_iconbox',
					'category' => esc_html__( 'Smarket Elements', 'smarket' ),
					'params'   => array(
						array(
							'type'        => 'select_preview',
							'heading'     => esc_html__( 'Select style', 'smarket' ),
							'value'       => array(
								'default' => array(
									'alt' => 'Default',
									'img' => SMARKET_SHORTCODE_PREVIEW . '/iconbox/default.jpg',
								),
							),
							'default'     => 'default',
							'admin_label' => true,
							'param_name'  => 'style',
						),
						array(
							'type'        => 'textfield',
							'heading'     => esc_html__( 'Title', 'smarket' ),
							'param_name'  => 'title',
							'admin_label' => true,
						),
						array(
							'param_name'  => 'text_content',
							'heading'     => esc_html__( 'Content', 'smarket' ),
							'type'        => 'textarea',
							'admin_label' => true,
						),
						array(
							'type'        => 'vc_link',
							'heading'     => esc_html__( 'URL (Link)', 'smarket' ),
							'param_name'  => 'link',
							'description' => esc_html__( 'Add link.', 'smarket' ),
						),
						array(
							'param_name' => 'icon_type',
							'heading'    => esc_html__( 'Icon Library', 'smarket' ),
							'type'       => 'dropdown',
							'value'      => array(
								esc_html__( 'Font Awesome', 'smarket' ) => 'fontawesome',
								esc_html__( 'Open Iconic', 'smarket' )  => 'openiconic',
								esc_html__( 'Typicons', 'smarket' )     => 'typicons',
								esc_html__( 'Entypo', 'smarket' )       => 'entypo',
								esc_html__( 'Linecons', 'smarket' )     => 'linecons',
								esc_html__( 'Other', 'smarket' )        => 'smarketcustomfonts',
							),
						),
						array(
							'param_name'  => 'icon_smarketcustomfonts',
							'heading'     => esc_html__( 'Icon', 'smarket' ),
							'description' => esc_html__( 'Select icon from library.', 'smarket' ),
							'type'        => 'iconpicker',
							'settings'    => array(
								'emptyIcon' => false,
								'type'      => 'smarketcustomfonts',
							),
							'dependency'  => array(
								'element' => 'icon_type',
								'value'   => 'smarketcustomfonts',
							),
						),
						array(
							'param_name'  => 'icon_fontawesome',
							'heading'     => esc_html__( 'Icon', 'smarket' ),
							'description' => esc_html__( 'Select icon from library.', 'smarket' ),
							'type'        => 'iconpicker',
							'settings'    => array(
								'emptyIcon'    => true,
								'iconsPerPage' => 4000,
							),
							'dependency'  => array(
								'element' => 'icon_type',
								'value'   => 'fontawesome',
							),
						),
						array(
							'param_name'  => 'icon_openiconic',
							'heading'     => esc_html__( 'Icon', 'smarket' ),
							'description' => esc_html__( 'Select icon from library.', 'smarket' ),
							'type'        => 'iconpicker',
							'settings'    => array(
								'emptyIcon'    => true,
								'type'         => 'openiconic',
								'iconsPerPage' => 4000,
							),
							'dependency'  => array(
								'element' => 'icon_type',
								'value'   => 'openiconic',
							),
						),
						array(
							'param_name'  => 'icon_typicons',
							'heading'     => esc_html__( 'Icon', 'smarket' ),
							'description' => esc_html__( 'Select icon from library.', 'smarket' ),
							'type'        => 'iconpicker',
							'settings'    => array(
								'emptyIcon'    => true,
								'type'         => 'typicons',
								'iconsPerPage' => 4000,
							),
							'dependency'  => array(
								'element' => 'icon_type',
								'value'   => 'typicons',
							),
						),
						array(
							'param_name' => 'icon_entypo',
							'heading'    => esc_html__( 'Icon', 'smarket' ),
							'type'       => 'iconpicker',
							'settings'   => array(
								'emptyIcon'    => true,
								'type'         => 'entypo',
								'iconsPerPage' => 4000,
							),
							'dependency' => array(
								'element' => 'icon_type',
								'value'   => 'entypo',
							),
						),
						array(
							'param_name'  => 'icon_linecons',
							'heading'     => esc_html__( 'Icon', 'smarket' ),
							'description' => esc_html__( 'Select icon from library.', 'smarket' ),
							'type'        => 'iconpicker',
							'settings'    => array(
								'emptyIcon'    => true,
								'type'         => 'linecons',
								'iconsPerPage' => 4000,
							),
							'dependency'  => array(
								'element' => 'icon_type',
								'value'   => 'linecons',
							),
						),
						array(
							'type'        => 'textfield',
							'heading'     => esc_html__( 'Extra class name', 'smarket' ),
							'param_name'  => 'el_class',
							'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'smarket' ),
						),
						array(
							'type'       => 'css_editor',
							'heading'    => esc_html__( 'CSS box', 'smarket' ),
							'param_name' => 'css',
							'group'      => esc_html__( 'Design Options', 'smarket' ),
						),
						array(
							'param_name'       => 'iconbox_custom_id',
							'heading'          => esc_html__( 'Hidden ID', 'smarket' ),
							'type'             => 'uniqid',
							'edit_field_class' => 'hidden',
						),
					),
				)
			);

			/* Map New blog */
			$categories_array = array(
				esc_html__( 'All', 'smarket' ) => '',
			);
			$args             = array();
			$categories       = get_categories( $args );
			foreach ( $categories as $category ) {
				$categories_array[ $category->name ] = $category->slug;
			}

			vc_map(
				array(
					'name'        => esc_html__( 'Smarket: Blogs', 'smarket' ),
					'base'        => 'smarket_blogs', // shortcode
					'class'       => '',
					'category'    => esc_html__( 'Smarket Elements', 'smarket' ),
					'description' => esc_html__( 'Display a blog lists.', 'smarket' ),
					'params'      => array(
						array(
							'type'        => 'select_preview',
							'heading'     => esc_html__( 'Select style', 'smarket' ),
							'value'       => array(
								'default' => array(
									'alt' => 'Default',
									'img' => SMARKET_SHORTCODE_PREVIEW . '/blogs/default.jpg',
								),
							),
							'default'     => 'default',
							'admin_label' => true,
							'param_name'  => 'style',
						),
						array(
							'type'        => 'textfield',
							'heading'     => esc_html__( 'The Title', 'smarket' ),
							'param_name'  => 'title',
							'admin_label' => true,
							'description' => esc_html__( 'Title of shortcode.', 'smarket' ),
						),
						array(
							'type'        => 'textfield',
							'heading'     => esc_html__( 'Number Post', 'smarket' ),
							'param_name'  => 'per_page',
							'std'         => 10,
							'admin_label' => true,
							'description' => esc_html__( 'Number post in a slide', 'smarket' ),
						),
						array(
							'param_name'  => 'category_slug',
							'type'        => 'dropdown',
							'value'       => $categories_array, // here I'm stuck
							'heading'     => esc_html__( 'Category filter:', 'smarket' ),
							"admin_label" => true,
						),
						array(
							"type"        => "dropdown",
							"heading"     => esc_html__( "Order by", 'smarket' ),
							"param_name"  => "orderby",
							"value"       => array(
								esc_html__( 'None', 'smarket' )     => 'none',
								esc_html__( 'ID', 'smarket' )       => 'ID',
								esc_html__( 'Author', 'smarket' )   => 'author',
								esc_html__( 'Name', 'smarket' )     => 'name',
								esc_html__( 'Date', 'smarket' )     => 'date',
								esc_html__( 'Modified', 'smarket' ) => 'modified',
								esc_html__( 'Rand', 'smarket' )     => 'rand',
							),
							'std'         => 'date',
							"description" => esc_html__( "Select how to sort retrieved posts.", 'smarket' ),
						),
						array(
							"type"        => "dropdown",
							"heading"     => esc_html__( "Order", 'smarket' ),
							"param_name"  => "order",
							"value"       => array(
								esc_html__( 'ASC', 'smarket' )  => 'ASC',
								esc_html__( 'DESC', 'smarket' ) => 'DESC',
							),
							'std'         => 'DESC',
							"description" => esc_html__( "Designates the ascending or descending order.", 'smarket' ),
						),
						/* Owl */
						array(
							'type'        => 'dropdown',
							'value'       => array(
								esc_html__( 'Yes', 'smarket' ) => 'true',
								esc_html__( 'No', 'smarket' )  => 'false',
							),
							'std'         => 'false',
							'heading'     => esc_html__( 'AutoPlay', 'smarket' ),
							'param_name'  => 'autoplay',
							'group'       => esc_html__( 'Carousel settings', 'smarket' ),
							'admin_label' => false,
						),
						array(
							'type'        => 'dropdown',
							'value'       => array(
								esc_html__( 'No', 'smarket' )  => 'false',
								esc_html__( 'Yes', 'smarket' ) => 'true',
							),
							'std'         => 'false',
							'heading'     => esc_html__( 'Navigation', 'smarket' ),
							'param_name'  => 'navigation',
							'description' => esc_html__( "Show buton 'next' and 'prev' buttons.", 'smarket' ),
							'group'       => esc_html__( 'Carousel settings', 'smarket' ),
							'admin_label' => false,
						),
						array(
							'type'        => 'dropdown',
							'value'       => array(
								esc_html__( 'Yes', 'smarket' ) => 'true',
								esc_html__( 'No', 'smarket' )  => 'false',
							),
							'std'         => 'false',
							'heading'     => esc_html__( 'Loop', 'smarket' ),
							'param_name'  => 'loop',
							'description' => esc_html__( "Inifnity loop. Duplicate last and first items to get loop illusion.", 'smarket' ),
							'group'       => esc_html__( 'Carousel settings', 'smarket' ),
							'admin_label' => false,
						),
						array(
							"type"        => "textfield",
							"heading"     => esc_html__( "Slide Speed", 'smarket' ),
							"param_name"  => "slidespeed",
							"value"       => "200",
							"description" => esc_html__( 'Slide speed in milliseconds', 'smarket' ),
							'group'       => esc_html__( 'Carousel settings', 'smarket' ),
							'admin_label' => false,
						),
						array(
							"type"        => "textfield",
							"heading"     => esc_html__( "Margin", 'smarket' ),
							"param_name"  => "margin",
							"value"       => "30",
							"description" => esc_html__( 'Distance( or space) between 2 item', 'smarket' ),
							'group'       => esc_html__( 'Carousel settings', 'smarket' ),
							'admin_label' => false,
						),
						array(
							"type"        => "textfield",
							"heading"     => esc_html__( "The items on desktop (Screen resolution of device >= 1200px )", 'smarket' ),
							"param_name"  => "lg_items",
							"value"       => "3",
							'group'       => esc_html__( 'Carousel settings', 'smarket' ),
							'admin_label' => false,
						),
						array(
							"type"        => "textfield",
							"heading"     => esc_html__( "The items on desktop (Screen resolution of device >= 992px < 1200px )", 'smarket' ),
							"param_name"  => "md_items",
							"value"       => "3",
							'group'       => esc_html__( 'Carousel settings', 'smarket' ),
							'admin_label' => false,
						),
						array(
							"type"        => "textfield",
							"heading"     => esc_html__( "The items on tablet (Screen resolution of device >=768px and < 992px )", 'smarket' ),
							"param_name"  => "sm_items",
							"value"       => "2",
							'group'       => esc_html__( 'Carousel settings', 'smarket' ),
							'admin_label' => false,
						),
						array(
							"type"        => "textfield",
							"heading"     => esc_html__( "The items on mobile landscape(Screen resolution of device >=480px and < 768px)", 'smarket' ),
							"param_name"  => "xs_items",
							"value"       => "2",
							'group'       => esc_html__( 'Carousel settings', 'smarket' ),
							'admin_label' => false,
						),
						array(
							"type"        => "textfield",
							"heading"     => esc_html__( "The items on mobile (Screen resolution of device < 480px)", 'smarket' ),
							"param_name"  => "ts_items",
							"value"       => "1",
							'group'       => esc_html__( 'Carousel settings', 'smarket' ),
							'admin_label' => false,
						),
						array(
							"type"        => "textfield",
							"heading"     => esc_html__( "Extra class name", "smarket" ),
							"param_name"  => "el_class",
							"description" => esc_html__( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "smarket" ),
						),
						array(
							'type'       => 'css_editor',
							'heading'    => esc_html__( 'Css', 'smarket' ),
							'param_name' => 'css',
							'group'      => esc_html__( 'Design options', 'smarket' ),
						),
						array(
							'param_name'       => 'blogs_custom_id',
							'heading'          => esc_html__( 'Hidden ID', 'smarket' ),
							'type'             => 'uniqid',
							'edit_field_class' => 'hidden',
						),
					),
				)
			);


			/*Map new container */
			vc_map(
				array(
					'name'                    => esc_html__( 'Smarket: Container', 'smarket' ),
					'base'                    => 'smarket_container',
					'category'                => esc_html__( 'Smarket Elements', 'smarket' ),
					'content_element'         => true,
					'show_settings_on_create' => true,
					'is_container'            => true,
					'js_view'                 => 'VcColumnView',
					'params'                  => array(
						array(
							'param_name'  => 'content_width',
							'heading'     => esc_html__( 'Content width', 'smarket' ),
							'type'        => 'dropdown',
							'value'       => array(
								esc_html__( 'Default', 'smarket' )         => 'default',
								esc_html__( 'Custom Boostrap', 'smarket' ) => 'custom_col',
								esc_html__( 'Custom Width', 'smarket' )    => 'custom_width',
							),
							'admin_label' => true,
							'std'         => 'container',
						),
                        array(
                            'type'        => 'dropdown',
                            'heading'     => esc_html__( 'Percent width row on Desktop', 'smarket' ),
                            'param_name'  => 'boostrap_bg_items',
                            'value'       => array(
								esc_html__( '12 column - 12/12', 'smarket' ) => '12',
								esc_html__( '11 column - 11/12', 'smarket' ) => '11',
								esc_html__( '10 column - 10/12', 'smarket' ) => '10',
								esc_html__( '9 column - 9/12', 'smarket' )  => '9',
								esc_html__( '8 column - 8/12', 'smarket' )  => '8',
								esc_html__( '7 column - 7/12', 'smarket' )  => '7',
								esc_html__( '6 column - 6/12', 'smarket' )  => '6',
								esc_html__( '5 column - 5/12', 'smarket' )  => '5',
								esc_html__( '4 column - 4/12', 'smarket' )  => '4',
								esc_html__( '3 column - 3/12', 'smarket' )  => '3',
								esc_html__( '2 column - 2/12', 'smarket' )  => '2',
								esc_html__( '1 column - 1/12', 'smarket' )  => '1',
								esc_html__( '1 column 5 - 1/5', 'smarket' )   => '15',
								esc_html__( '4 column 5 - 4/5', 'smarket' )   => '45',
                            ),
                            'description' => esc_html__( '(Percent width row on screen resolution of device >= 1500px )', 'smarket' ),
                            'group'       => esc_html__( 'Boostrap settings', 'smarket' ),
                            'std'         => '15',
                            'dependency'  => array(
                                'element' => 'content_width',
                                'value'   => array( 'custom_col' ),
                            ),
                        ),
                        array(
                            'type'        => 'dropdown',
                            'heading'     => esc_html__( 'Percent width row on Desktop', 'smarket' ),
                            'param_name'  => 'boostrap_lg_items',
                            'value'       => array(
								esc_html__( '12 column - 12/12', 'smarket' ) => '12',
								esc_html__( '11 column - 11/12', 'smarket' ) => '11',
								esc_html__( '10 column - 10/12', 'smarket' ) => '10',
								esc_html__( '9 column - 9/12', 'smarket' )  => '9',
								esc_html__( '8 column - 8/12', 'smarket' )  => '8',
								esc_html__( '7 column - 7/12', 'smarket' )  => '7',
								esc_html__( '6 column - 6/12', 'smarket' )  => '6',
								esc_html__( '5 column - 5/12', 'smarket' )  => '5',
								esc_html__( '4 column - 4/12', 'smarket' )  => '4',
								esc_html__( '3 column - 3/12', 'smarket' )  => '3',
								esc_html__( '2 column - 2/12', 'smarket' )  => '2',
								esc_html__( '1 column - 1/12', 'smarket' )  => '1',
								esc_html__( '1 column 5 - 1/5', 'smarket' )   => '15',
								esc_html__( '4 column 5 - 4/5', 'smarket' )   => '45',
                            ),
                            'description' => esc_html__( '(Percent width row on screen resolution of device >= 1200px and < 1500px )', 'smarket' ),
                            'group'       => esc_html__( 'Boostrap settings', 'smarket' ),
                            'std'         => '12',
                            'dependency'  => array(
                                'element' => 'content_width',
                                'value'   => array( 'custom_col' ),
                            ),
                        ),
                        array(
                            'type'        => 'dropdown',
                            'heading'     => esc_html__( 'Percent width row on landscape tablet', 'smarket' ),
                            'param_name'  => 'boostrap_md_items',
                            'value'       => array(
								esc_html__( '12 column - 12/12', 'smarket' ) => '12',
								esc_html__( '11 column - 11/12', 'smarket' ) => '11',
								esc_html__( '10 column - 10/12', 'smarket' ) => '10',
								esc_html__( '9 column - 9/12', 'smarket' )  => '9',
								esc_html__( '8 column - 8/12', 'smarket' )  => '8',
								esc_html__( '7 column - 7/12', 'smarket' )  => '7',
								esc_html__( '6 column - 6/12', 'smarket' )  => '6',
								esc_html__( '5 column - 5/12', 'smarket' )  => '5',
								esc_html__( '4 column - 4/12', 'smarket' )  => '4',
								esc_html__( '3 column - 3/12', 'smarket' )  => '3',
								esc_html__( '2 column - 2/12', 'smarket' )  => '2',
								esc_html__( '1 column - 1/12', 'smarket' )  => '1',
								esc_html__( '1 column 5 - 1/5', 'smarket' )   => '15',
								esc_html__( '4 column 5 - 4/5', 'smarket' )   => '45',
                            ),
                            'description' => esc_html__( '(Percent width row on screen resolution of device >=992px and < 1200px )', 'smarket' ),
                            'group'       => esc_html__( 'Boostrap settings', 'smarket' ),
                            'std'         => '12',
                            'dependency'  => array(
                                'element' => 'content_width',
                                'value'   => array( 'custom_col' ),
                            ),
                        ),
                        array(
                            'type'        => 'dropdown',
                            'heading'     => esc_html__( 'Percent width row on portrait tablet', 'smarket' ),
                            'param_name'  => 'boostrap_sm_items',
                            'value'       => array(
								esc_html__( '12 column - 12/12', 'smarket' ) => '12',
								esc_html__( '11 column - 11/12', 'smarket' ) => '11',
								esc_html__( '10 column - 10/12', 'smarket' ) => '10',
								esc_html__( '9 column - 9/12', 'smarket' )  => '9',
								esc_html__( '8 column - 8/12', 'smarket' )  => '8',
								esc_html__( '7 column - 7/12', 'smarket' )  => '7',
								esc_html__( '6 column - 6/12', 'smarket' )  => '6',
								esc_html__( '5 column - 5/12', 'smarket' )  => '5',
								esc_html__( '4 column - 4/12', 'smarket' )  => '4',
								esc_html__( '3 column - 3/12', 'smarket' )  => '3',
								esc_html__( '2 column - 2/12', 'smarket' )  => '2',
								esc_html__( '1 column - 1/12', 'smarket' )  => '1',
								esc_html__( '1 column 5 - 1/5', 'smarket' )   => '15',
								esc_html__( '4 column 5 - 4/5', 'smarket' )   => '45',
                            ),
                            'description' => esc_html__( '(Percent width row on screen resolution of device >=768px and < 992px )', 'smarket' ),
                            'group'       => esc_html__( 'Boostrap settings', 'smarket' ),
                            'std'         => '12',
                            'dependency'  => array(
                                'element' => 'content_width',
                                'value'   => array( 'custom_col' ),
                            ),
                        ),
                        array(
                            'type'        => 'dropdown',
                            'heading'     => esc_html__( 'Percent width row on Mobile', 'smarket' ),
                            'param_name'  => 'boostrap_xs_items',
                            'value'       => array(
								esc_html__( '12 column - 12/12', 'smarket' ) => '12',
								esc_html__( '11 column - 11/12', 'smarket' ) => '11',
								esc_html__( '10 column - 10/12', 'smarket' ) => '10',
								esc_html__( '9 column - 9/12', 'smarket' )  => '9',
								esc_html__( '8 column - 8/12', 'smarket' )  => '8',
								esc_html__( '7 column - 7/12', 'smarket' )  => '7',
								esc_html__( '6 column - 6/12', 'smarket' )  => '6',
								esc_html__( '5 column - 5/12', 'smarket' )  => '5',
								esc_html__( '4 column - 4/12', 'smarket' )  => '4',
								esc_html__( '3 column - 3/12', 'smarket' )  => '3',
								esc_html__( '2 column - 2/12', 'smarket' )  => '2',
								esc_html__( '1 column - 1/12', 'smarket' )  => '1',
								esc_html__( '1 column 5 - 1/5', 'smarket' )   => '15',
								esc_html__( '4 column 5 - 4/5', 'smarket' )   => '45',
                            ),
                            'description' => esc_html__( '(Percent width row on screen resolution of device >=480  add < 768px )', 'smarket' ),
                            'group'       => esc_html__( 'Boostrap settings', 'smarket' ),
                            'std'         => '12',
                            'dependency'  => array(
                                'element' => 'content_width',
                                'value'   => array( 'custom_col' ),
                            ),
                        ),
                        array(
                            'type'        => 'dropdown',
                            'heading'     => esc_html__( 'Percent width row on Mobile', 'smarket' ),
                            'param_name'  => 'boostrap_ts_items',
                            'value'       => array(
								esc_html__( '12 column - 12/12', 'smarket' ) => '12',
								esc_html__( '11 column - 11/12', 'smarket' ) => '11',
								esc_html__( '10 column - 10/12', 'smarket' ) => '10',
								esc_html__( '9 column - 9/12', 'smarket' )  => '9',
								esc_html__( '8 column - 8/12', 'smarket' )  => '8',
								esc_html__( '7 column - 7/12', 'smarket' )  => '7',
								esc_html__( '6 column - 6/12', 'smarket' )  => '6',
								esc_html__( '5 column - 5/12', 'smarket' )  => '5',
								esc_html__( '4 column - 4/12', 'smarket' )  => '4',
								esc_html__( '3 column - 3/12', 'smarket' )  => '3',
								esc_html__( '2 column - 2/12', 'smarket' )  => '2',
								esc_html__( '1 column - 1/12', 'smarket' )  => '1',
								esc_html__( '1 column 5 - 1/5', 'smarket' )   => '15',
								esc_html__( '4 column 5 - 4/5', 'smarket' )   => '45',
                            ),
                            'description' => esc_html__( '(Percent width row on screen resolution of device < 480px)', 'smarket' ),
                            'group'       => esc_html__( 'Boostrap settings', 'smarket' ),
                            'std'         => '12',
                            'dependency'  => array(
                                'element' => 'content_width',
                                'value'   => array( 'custom_col' ),
                            ),
                        ),
						array(
							'param_name'  => 'number_width',
							'heading'     => esc_html__( 'width', 'smarket' ),
							"description" => esc_html__( "you can width by px or %, ex: 100%", "smarket" ),
							'std'         => '50%',
							'admin_label' => true,
							'type'        => 'textfield',
							'dependency'  => array(
								'element' => 'content_width',
								'value'   => array( 'custom_width' ),
							),
						),
						'css' => array(
							'type'       => 'css_editor',
							'heading'    => esc_html__( 'Css', 'smarket' ),
							'param_name' => 'css',
							'group'      => esc_html__( 'Design options', 'smarket' ),
						),
						array(
							"type"        => "textfield",
							"heading"     => esc_html__( "Extra class name", "smarket" ),
							"param_name"  => "el_class",
							"description" => esc_html__( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "smarket" ),
						),
						array(
							'param_name'       => 'container_custom_id',
							'heading'          => esc_html__( 'Hidden ID', 'smarket' ),
							'type'             => 'uniqid',
							'edit_field_class' => 'hidden',
						),
					),
				)
			);

			/*Map New Social*/
			$socials     = array();
			$all_socials = smarket_get_all_social();
			if ( $all_socials ) {
				foreach ( $all_socials as $key => $social )
					$socials[ $social[ 'name' ] ] = $key;
			}
			vc_map(
				array(
					'name'        => esc_html__( 'Smarket: Socials', 'smarket' ),
					'base'        => 'smarket_socials', // shortcode
					'class'       => '',
					'category'    => esc_html__( 'Smarket Elements', 'smarket' ),
					'description' => esc_html__( 'Display a social list.', 'smarket' ),
					'params'      => array(
						array(
							'type'        => 'select_preview',
							'heading'     => esc_html__( 'Select style', 'smarket' ),
							'value'       => array(
								'default' => array(
									'alt' => 'Default',
									'img' => SMARKET_SHORTCODE_PREVIEW . '/socials/default.jpg',
								),
							),
							'default'     => 'default',
							'admin_label' => true,
							'param_name'  => 'style',
						),
						array(
							'type'        => 'textfield',
							'heading'     => esc_html__( 'Title', 'smarket' ),
							'param_name'  => 'title',
							'description' => esc_html__( 'The title of shortcode', 'smarket' ),
							'admin_label' => true,
							'std'         => '',
						),
						array(
							'param_name' => 'text_align',
							'heading'    => esc_html__( 'Text align', 'smarket' ),
							'type'       => 'dropdown',
							'value'      => array(
								esc_html__( 'Left', 'smarket' )   => 'text-left',
								esc_html__( 'Right', 'smarket' )  => 'text-right',
								esc_html__( 'Center', 'smarket' ) => 'text-center',
							),
							'std'        => 'text-left',
						),
						array(
							'type'        => 'checkbox',
							'heading'     => esc_html__( 'Display on', 'smarket' ),
							'param_name'  => 'use_socials',
							'class'       => 'checkbox-display-block',
							'value'       => $socials,
							'admin_label' => true,
						),
						array(
							"type"        => "textfield",
							"heading"     => esc_html__( "Extra class name", "smarket" ),
							"param_name"  => "el_class",
							"description" => esc_html__( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "smarket" ),
						),
						array(
							'type'       => 'css_editor',
							'heading'    => esc_html__( 'Css', 'smarket' ),
							'param_name' => 'css',
							'group'      => esc_html__( 'Design options', 'smarket' ),
						),
						array(
							'param_name'       => 'socials_custom_id',
							'heading'          => esc_html__( 'Hidden ID', 'smarket' ),
							'type'             => 'uniqid',
							'edit_field_class' => 'hidden',
						),
					),
				)
			);

			/*Map New Newsletter*/
			vc_map(
				array(
					'name'        => esc_html__( 'Smarket: Newsletter', 'smarket' ),
					'base'        => 'smarket_newsletter', // shortcode
					'class'       => '',
					'category'    => esc_html__( 'Smarket Elements', 'smarket' ),
					'description' => esc_html__( 'Display a newsletter box.', 'smarket' ),
					'params'      => array(
						array(
							'type'        => 'select_preview',
							'heading'     => esc_html__( 'Layout', 'smarket' ),
							'value'       => array(
								'default' => array(
									'alt' => 'default',
									'img' => SMARKET_SHORTCODE_PREVIEW . 'newsletter/default.jpg',
								),
								'layout1' => array(
									'alt' => 'Layout 01',
									'img' => SMARKET_SHORTCODE_PREVIEW . 'newsletter/layout1.jpg',
								),
							),
							'default'     => 'default',
							'admin_label' => true,
							'param_name'  => 'style',
						),
						array(
							'type'        => 'textfield',
							'heading'     => esc_html__( 'Title', 'smarket' ),
							'param_name'  => 'title',
							'description' => esc_html__( 'The title of shortcode', 'smarket' ),
							'admin_label' => true,
							'std'         => '',
						),
						array(
							'type'        => 'textarea',
							'heading'     => esc_html__( 'Sub title', 'smarket' ),
							'param_name'  => 'subtitle',
							'description' => esc_html__( 'The sub title of shortcode, using element "strong" for hight text', 'smarket' ),
							'std'         => '',
						),
						array(
							"type"        => "textfield",
							"heading"     => esc_html__( "Placeholder text", 'smarket' ),
							"param_name"  => "placeholder_text",
							"admin_label" => false,
							'std'         => 'Email address here',
						),
						array(
							"type"        => "textfield",
							"heading"     => esc_html__( "Extra class name", "smarket" ),
							"param_name"  => "el_class",
							"description" => esc_html__( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "smarket" ),
						),
						array(
							'type'       => 'css_editor',
							'heading'    => esc_html__( 'Css', 'smarket' ),
							'param_name' => 'css',
							'group'      => esc_html__( 'Design options', 'smarket' ),
						),
						array(
							'param_name'       => 'newsletter_custom_id',
							'heading'          => esc_html__( 'Hidden ID', 'smarket' ),
							'type'             => 'uniqid',
							'edit_field_class' => 'hidden',
						),
					),
				)
			);

			/*Map Custom menu*/

			$all_menu = array();
			$menus    = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
			if ( $menus && count( $menus ) > 0 ) {
				foreach ( $menus as $m ) {
					$all_menu[ $m->name ] = $m->slug;
				}
			}
			vc_map(
				array(
					'name'        => esc_html__( 'Smarket: Custom Menu', 'smarket' ),
					'base'        => 'smarket_custommenu', // shortcode
					'class'       => '',
					'category'    => esc_html__( 'Smarket Elements', 'smarket' ),
					'description' => esc_html__( 'Display a custom menu.', 'smarket' ),
					'params'      => array(
						array(
							'type'        => 'select_preview',
							'heading'     => esc_html__( 'Layout', 'smarket' ),
							'value'       => array(
								'default' => array(
									'alt' => 'Default',
									'img' => SMARKET_SHORTCODE_PREVIEW . 'custom_menu/default.jpg',
								),
								'layout1' => array(
									'alt' => 'Layout 01',
									'img' => SMARKET_SHORTCODE_PREVIEW . 'custom_menu/layout1.jpg',
								),
							),
							'default'     => 'default',
							'admin_label' => true,
							'param_name'  => 'layout',
						),
						array(
							'type'        => 'textfield',
							'heading'     => esc_html__( 'Title', 'smarket' ),
							'param_name'  => 'title',
							'description' => esc_html__( 'The title of shortcode', 'smarket' ),
							'admin_label' => true,
							'std'         => '',
						),
						array(
							"type"        => "attach_image",
							"heading"     => esc_html__( "Image Banner", 'smarket' ),
							"param_name"  => "menu_banner",
							"admin_label" => true,
							'dependency'  => array(
								'element' => 'layout',
								'value'   => array( 'layout1' ),
							),
						),
						array(
							'type'        => 'dropdown',
							'heading'     => esc_html__( 'Menu', 'smarket' ),
							'param_name'  => 'menu',
							'value'       => $all_menu,
							'description' => esc_html__( 'Select menu to display.', 'smarket' ),
						),
						array(
							'type'        => 'vc_link',
							'heading'     => esc_html__( 'URL (Link)', 'smarket' ),
							'param_name'  => 'link',
							'description' => esc_html__( 'Add link.', 'smarket' ),
							'dependency'  => array(
								'element' => 'layout',
								'value'   => array( 'layout1' ),
							),
						),
						array(
							"type"        => "textfield",
							"heading"     => esc_html__( "Extra class name", "smarket" ),
							"param_name"  => "el_class",
							"description" => esc_html__( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "smarket" ),
						),
						array(
							'type'       => 'css_editor',
							'heading'    => esc_html__( 'Css', 'smarket' ),
							'param_name' => 'css',
							'group'      => esc_html__( 'Design options', 'smarket' ),
						),
						array(
							'param_name'       => 'custommenu_custom_id',
							'heading'          => esc_html__( 'Hidden ID', 'smarket' ),
							'type'             => 'uniqid',
							'edit_field_class' => 'hidden',
						),
					),
				)
			);

			/* Map New Categories */

			vc_map(
				array(
					'name'        => esc_html__( 'Smarket: Categories', 'smarket' ),
					'base'        => 'smarket_categories', // shortcode
					'class'       => '',
					'category'    => esc_html__( 'Smarket Elements', 'smarket' ),
					'description' => esc_html__( 'Display Categories.', 'smarket' ),
					'params'      => array(
						array(
							'type'        => 'select_preview',
							'heading'     => esc_html__( 'Layout', 'smarket' ),
							'value'       => array(
								'default' => array(
									'alt' => 'Default',
									'img' => SMARKET_SHORTCODE_PREVIEW . 'categories/default.jpg',
								),
							),
							'default'     => 'default',
							'admin_label' => true,
							'param_name'  => 'style',
						),
						array(
							"type"        => "attach_image",
							"heading"     => esc_html__( "Background", "smarket" ),
							"param_name"  => "bg_cat",
							"admin_label" => true,
						),
						array(
							"type"        => "taxonomy",
							"taxonomy"    => "product_cat",
							"class"       => "",
							"heading"     => esc_html__( "Product Category", 'smarket' ),
							"param_name"  => "taxonomy",
							"value"       => '',
							'parent'      => '',
							'multiple'    => false,
							'hide_empty'  => false,
							'placeholder' => esc_html__( 'Choose category', 'smarket' ),
							"description" => esc_html__( "Note: If you want to narrow output, select category(s) above. Only selected categories will be displayed.", 'smarket' ),
							'std'         => '',
						),
						array(
							"type"        => "textfield",
							"heading"     => esc_html__( "Extra class name", "smarket" ),
							"param_name"  => "el_class",
							"description" => esc_html__( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "smarket" ),
						),
						array(
							'type'       => 'css_editor',
							'heading'    => esc_html__( 'Css', 'smarket' ),
							'param_name' => 'css',
							'group'      => esc_html__( 'Design options', 'smarket' ),
						),
						array(
							'param_name'       => 'categories_custom_id',
							'heading'          => esc_html__( 'Hidden ID', 'smarket' ),
							'type'             => 'uniqid',
							'edit_field_class' => 'hidden',
						),
					),
				)
			);

			/*Map New Slider*/

			vc_map(
				array(
					'name'                    => esc_html__( 'Smarket: Slider', 'smarket' ),
					'base'                    => 'smarket_slider',
					'category'                => esc_html__( 'Smarket Elements', 'smarket' ),
					'description'             => esc_html__( 'Display a custom slide.', 'smarket' ),
					'as_parent'               => array( 'only' => 'vc_single_image, smarket_custommenu, smarket_categories' ),
					'content_element'         => true,
					'show_settings_on_create' => true,
					'js_view'                 => 'VcColumnView',
					'params'                  => array(
						array(
							'type'        => 'select_preview',
							'heading'     => esc_html__( 'Select style', 'smarket' ),
							'value'       => array(
								'default' => array(
									'alt' => 'Default',
									'img' => SMARKET_SHORTCODE_PREVIEW . '/slider/default.jpg',
								),
								'style1'  => array(
									'alt' => 'Style 01',
									'img' => SMARKET_SHORTCODE_PREVIEW . '/slider/layout1.jpg',
								),
								'style2'  => array(
									'alt' => 'Style 02',
									'img' => SMARKET_SHORTCODE_PREVIEW . '/slider/layout2.jpg',
								),
							),
							'default'     => 'default',
							'admin_label' => true,
							'param_name'  => 'style',
						),
						array(
							'type'       => 'dropdown',
							'value'      => array(
								esc_html__( 'Owl', 'smarket' )  => 'owl',
								esc_html__( 'List', 'smarket' ) => 'list',
							),
							'std'        => 'owl',
							'heading'    => esc_html__( 'Type show', 'smarket' ),
							'param_name' => 'type_show',
							'dependency' => array(
								'element' => 'style',
								'value'   => array( 'default' ),
							),
						),
						array(
							'type'        => 'textfield',
							'admin_label' => true,
							'heading'     => esc_html__( 'Title', 'smarket' ),
							'description' => esc_html__( 'title of shortcode.', 'smarket' ),
							'param_name'  => 'title',
							'dependency'  => array(
								'element' => 'style',
								'value'   => array( 'style1', 'style2' ),
							),
                        ),
                        array(
                            'type'        => 'dropdown',
                            'heading'     => esc_html__( 'Title style', 'smarket' ),
                            'param_name'  => 'title_slide_style',
                            'value'       => array(
                                esc_html__( 'Style 01', 'smarket' ) => 'style-1',
                                esc_html__( 'Style 02', 'smarket' ) => 'style-2',
                            ),
                            'description' => esc_html__( 'Select a Title style.', 'smarket' ),
                            'admin_label' => true,
                            'std'         => 'style-1',
                            'dependency'  => array(
                                'element' => 'style',
                                'value'   => array( 'style1' ),
                            ),
                        ),
                        array(
                            'type'        => 'textfield',
                            'heading'     => esc_html__( 'Title padding', 'smarket' ),
                            'param_name'  => 'title_slide_padding',
                            'std'         => '0',
                            'admin_label' => true,
                            'dependency'  => array(
                                'element' => 'style',
                                'value'   => 'style1',
                            ),
                        ),
						array(
							'type'        => 'textarea',
							'admin_label' => true,
							'heading'     => esc_html__( 'Description', 'smarket' ),
							'description' => esc_html__( 'Description of shortcode.', 'smarket' ),
							'param_name'  => 'des',
							'dependency'  => array(
								'element' => 'style',
								'value'   => array( 'style2' ),
							),
						),
						/* Owl */
						array(
							'type'        => 'dropdown',
							'value'       => array(
								esc_html__( 'Yes', 'smarket' ) => 'true',
								esc_html__( 'No', 'smarket' )  => 'false',
							),
							'std'         => 'false',
							'heading'     => esc_html__( 'AutoPlay', 'smarket' ),
							'param_name'  => 'autoplay',
							'group'       => esc_html__( 'Carousel settings', 'smarket' ),
							'admin_label' => false,
						),
						array(
							'type'        => 'dropdown',
							'value'       => array(
								esc_html__( 'No', 'smarket' )  => 'false',
								esc_html__( 'Yes', 'smarket' ) => 'true',
							),
							'std'         => 'false',
							'heading'     => esc_html__( 'Navigation', 'smarket' ),
							'param_name'  => 'navigation',
							'description' => esc_html__( "Show buton 'next' and 'prev' buttons.", 'smarket' ),
							'group'       => esc_html__( 'Carousel settings', 'smarket' ),
							'admin_label' => false,
						),
						array(
							'type'        => 'dropdown',
							'value'       => array(
								esc_html__( 'Yes', 'smarket' ) => 'true',
								esc_html__( 'No', 'smarket' )  => 'false',
							),
							'std'         => 'false',
							'heading'     => esc_html__( 'Loop', 'smarket' ),
							'param_name'  => 'loop',
							'description' => esc_html__( "Inifnity loop. Duplicate last and first items to get loop illusion.", 'smarket' ),
							'group'       => esc_html__( 'Carousel settings', 'smarket' ),
							'admin_label' => false,
						),
						array(
							"type"        => "textfield",
							"heading"     => esc_html__( "Slide Speed", 'smarket' ),
							"param_name"  => "slidespeed",
							"value"       => "200",
							"description" => esc_html__( 'Slide speed in milliseconds', 'smarket' ),
							'group'       => esc_html__( 'Carousel settings', 'smarket' ),
							'admin_label' => false,
						),
						array(
							"type"        => "textfield",
							"heading"     => esc_html__( "Margin", 'smarket' ),
							"param_name"  => "margin",
							"value"       => "30",
							"description" => esc_html__( 'Distance( or space) between 2 item', 'smarket' ),
							'group'       => esc_html__( 'Carousel settings', 'smarket' ),
							'admin_label' => false,
						),
						array(
							"type"        => "textfield",
							"heading"     => esc_html__( "The items on desktop (Screen resolution of device >= 1500px )", 'smarket' ),
							"param_name"  => "ls_items",
							"value"       => "5",
							'group'       => esc_html__( 'Carousel settings', 'smarket' ),
							'admin_label' => false,
						),
						array(
							"type"        => "textfield",
							"heading"     => esc_html__( "The items on desktop (Screen resolution of device >= 1200px < 1500px )", 'smarket' ),
							"param_name"  => "lg_items",
							"value"       => "4",
							'group'       => esc_html__( 'Carousel settings', 'smarket' ),
							'admin_label' => false,
						),
						array(
							"type"        => "textfield",
							"heading"     => esc_html__( "The items on desktop (Screen resolution of device >= 992px < 1200px )", 'smarket' ),
							"param_name"  => "md_items",
							"value"       => "3",
							'group'       => esc_html__( 'Carousel settings', 'smarket' ),
							'admin_label' => false,
						),
						array(
							"type"        => "textfield",
							"heading"     => esc_html__( "The items on tablet (Screen resolution of device >=768px and < 992px )", 'smarket' ),
							"param_name"  => "sm_items",
							"value"       => "2",
							'group'       => esc_html__( 'Carousel settings', 'smarket' ),
							'admin_label' => false,
						),
						array(
							"type"        => "textfield",
							"heading"     => esc_html__( "The items on mobile landscape(Screen resolution of device >=480px and < 768px)", 'smarket' ),
							"param_name"  => "xs_items",
							"value"       => "2",
							'group'       => esc_html__( 'Carousel settings', 'smarket' ),
							'admin_label' => false,
						),
						array(
							"type"        => "textfield",
							"heading"     => esc_html__( "The items on mobile (Screen resolution of device < 480px)", 'smarket' ),
							"param_name"  => "ts_items",
							"value"       => "1",
							'group'       => esc_html__( 'Carousel settings', 'smarket' ),
							'admin_label' => false,
						),
						array(
							'heading'     => esc_html__( 'Extra Class Name', 'smarket' ),
							'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'smarket' ),
							'type'        => 'textfield',
							'param_name'  => 'el_class',
						),
						'css' => array(
							'type'       => 'css_editor',
							'heading'    => esc_html__( 'Css', 'smarket' ),
							'param_name' => 'css',
							'group'      => esc_html__( 'Design options', 'smarket' ),
						),
						array(
							'param_name'       => 'slider_custom_id',
							'heading'          => esc_html__( 'Hidden ID', 'smarket' ),
							'type'             => 'uniqid',
							'edit_field_class' => 'hidden',
						),
					),
				)
			);

			/*Map Googlemap */
			vc_map(
				array(
					'name'        => esc_html__( 'Smarket: Google Map', 'smarket' ),
					'base'        => 'smarket_googlemap', // shortcode
					'class'       => '',
					'category'    => esc_html__( 'Smarket Elements', 'smarket' ),
					'description' => esc_html__( 'Display a google map.', 'smarket' ),
					'params'      => array(
						array(
							"type"        => "textfield",
							"heading"     => esc_html__( "Title", 'smarket' ),
							"param_name"  => "title",
							'admin_label' => true,
							"description" => esc_html__( "title.", 'smarket' ),
							'std'         => 'Kute themes',
						),
						array(
							"type"        => "textfield",
							"heading"     => esc_html__( "Phone", 'smarket' ),
							"param_name"  => "phone",
							'admin_label' => true,
							"description" => esc_html__( "phone.", 'smarket' ),
							'std'         => '088-465 9965 02',
						),
						array(
							"type"        => "textfield",
							"heading"     => esc_html__( "Email", 'smarket' ),
							"param_name"  => "email",
							'admin_label' => true,
							"description" => esc_html__( "email.", 'smarket' ),
							'std'         => 'kutethemes@gmail.com',
						),
						array(
							"type"        => "textfield",
							"heading"     => esc_html__( "Map Height", 'smarket' ),
							"param_name"  => "map_height",
							'admin_label' => true,
							'std'         => '400',
						),
						array(
							'type'       => 'dropdown',
							'heading'    => esc_html__( 'Maps type', 'smarket' ),
							'param_name' => 'map_type',
							'value'      => array(
								esc_html__( 'ROADMAP', 'smarket' )   => 'ROADMAP',
								esc_html__( 'SATELLITE', 'smarket' ) => 'SATELLITE',
								esc_html__( 'HYBRID', 'smarket' )    => 'HYBRID',
								esc_html__( 'TERRAIN', 'smarket' )   => 'TERRAIN',
							),
							'std'        => 'ROADMAP',
						),
						array(
							'type'       => 'dropdown',
							'heading'    => esc_html__( 'Show info content?', 'smarket' ),
							'param_name' => 'info_content',
							'value'      => array(
								esc_html__( 'Yes', 'smarket' ) => '1',
								esc_html__( 'No', 'smarket' )  => '2',
							),
							'std'        => '1',
						),
						array(
							"type"        => "textfield",
							"heading"     => esc_html__( "Address", 'smarket' ),
							"param_name"  => "address",
							'admin_label' => true,
							"description" => esc_html__( "address.", 'smarket' ),
							'std'         => 'Z115 TP. Thai Nguyen',
						),
						array(
							"type"        => "textfield",
							"heading"     => esc_html__( "Longitude", 'smarket' ),
							"param_name"  => "longitude",
							'admin_label' => true,
							"description" => esc_html__( "longitude.", 'smarket' ),
							'std'         => '105.800286',
						),
						array(
							"type"        => "textfield",
							"heading"     => esc_html__( "Latitude", 'smarket' ),
							"param_name"  => "latitude",
							'admin_label' => true,
							"description" => esc_html__( "latitude.", 'smarket' ),
							'std'         => '21.587001',
						),
						array(
							"type"        => "textfield",
							"heading"     => esc_html__( "Zoom", 'smarket' ),
							"param_name"  => "zoom",
							'admin_label' => true,
							"description" => esc_html__( "zoom.", 'smarket' ),
							'std'         => '14',
						),
						array(
							"type"        => "textfield",
							"heading"     => esc_html__( "Extra class name", 'smarket' ),
							"param_name"  => "el_class",
							"description" => esc_html__( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "smarket" ),
						),
						array(
							'type'       => 'css_editor',
							'heading'    => esc_html__( 'Css', 'smarket' ),
							'param_name' => 'css',
							'group'      => esc_html__( 'Design options', 'smarket' ),
						),
						array(
							'param_name'       => 'googlemap_custom_id',
							'heading'          => esc_html__( 'Hidden ID', 'smarket' ),
							'type'             => 'uniqid',
							'edit_field_class' => 'hidden',
						),
					),
				)
			);

			/*Map Contact Us */
			vc_map(
				array(
					'name'        => esc_html__( 'Smarket: Contact Us', 'smarket' ),
					'base'        => 'smarket_contact', // shortcode
					'class'       => '',
					'category'    => esc_html__( 'Smarket Elements', 'smarket' ),
					'description' => esc_html__( 'Display Contact Us.', 'smarket' ),
					'params'      => array(
						array(
							"type"        => "textfield",
							"heading"     => esc_html__( "Title", 'smarket' ),
							"param_name"  => "title",
							'admin_label' => true,
							"description" => esc_html__( "title.", 'smarket' ),
							'std'         => 'contact us',
						),
						array(
							"type"        => "textarea",
							"heading"     => esc_html__( "Address", 'smarket' ),
							"param_name"  => "address",
							'admin_label' => true,
							"description" => esc_html__( "Address.", 'smarket' ),
							'std'         => 'S.Market London Oxford Street 02 United Kingdom.',
						),
						array(
							"type"        => "textarea",
							"heading"     => esc_html__( "Phone", 'smarket' ),
							"param_name"  => "phone",
							'admin_label' => true,
							"description" => esc_html__( "phone.", 'smarket' ),
							'std'         => '(+92) 3456 7890',
						),
						array(
							"type"        => "textarea",
							"heading"     => esc_html__( "Email", 'smarket' ),
							"param_name"  => "email",
							'admin_label' => true,
							"description" => esc_html__( "email.", 'smarket' ),
							'std'         => 'emails.market@gmail.com',
						),
						array(
							"type"        => "textfield",
							"heading"     => esc_html__( "Extra class name", 'smarket' ),
							"param_name"  => "el_class",
							"description" => esc_html__( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "smarket" ),
						),
						array(
							'type'       => 'css_editor',
							'heading'    => esc_html__( 'Css', 'smarket' ),
							'param_name' => 'css',
							'group'      => esc_html__( 'Design options', 'smarket' ),
						),
						array(
							'param_name'       => 'contact_custom_id',
							'heading'          => esc_html__( 'Hidden ID', 'smarket' ),
							'type'             => 'uniqid',
							'edit_field_class' => 'hidden',
						),
					),
				)
			);

		}
	}

	new Smarket_Visual_Composer();
}
VcShortcodeAutoloader::getInstance()->includeClass( 'WPBakeryShortCode_VC_Tta_Accordion' );

class WPBakeryShortCode_Smarket_Banner extends WPBakeryShortCodesContainer
{
}

;

class WPBakeryShortCode_Smarket_Tabs extends WPBakeryShortCode_VC_Tta_Accordion
{
}

;

class WPBakeryShortCode_Smarket_Container extends WPBakeryShortCodesContainer
{
}

;

class WPBakeryShortCode_Smarket_Slider extends WPBakeryShortCodesContainer
{
}

;
