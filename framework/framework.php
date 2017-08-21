<?php
// Prevent direct access to this file
defined( 'ABSPATH' ) || die( 'Direct access to this file is not allowed.' );

/**
 * Core class.
 *
 * @package  KuteThemes
 * @since    1.0
 */

if ( !class_exists( 'Smarket_framework' ) ) {
	class Smarket_framework
	{
		/**
		 * Define theme version.
		 *
		 * @var  string
		 */
		const VERSION = '1.0.0';

		/**
		 * Instance of the class.
		 *
		 * @since   1.0.0
		 *
		 * @var   object
		 */
		protected static $instance = null;

		/**
		 * Return an instance of this class.
		 *
		 * @since    1.0.0
		 *
		 * @return  object  A single instance of the class.
		 */
		public static function get_instance()
		{

			// If the single instance hasn't been set yet, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
			}

			return self::$instance;

		}

		public function __construct()
		{
			$this->includes();
		}

		public function includes()
		{
			/* Comming soon */
			include_once( get_template_directory() . '/framework/coming-soon/init.php' );

			/* Classes */
			include_once( get_template_directory() . '/framework/includes/classes/class-tgm-plugin-activation.php' );
			include_once( get_template_directory() . '/framework/includes/classes/breadcrumbs.php' );

			/*Mega menu */
			include_once( get_template_directory() . '/framework/includes/megamenu/megamenu.php' );
			/*Plugin load*/
			include_once( get_template_directory() . '/framework/settings/plugins-load.php' );
			/*Theme options*/
			include_once( get_template_directory() . '/framework/settings/theme-options.php' );
			/*Metabox*/
			include_once( get_template_directory() . '/framework/includes/meta-box/meta-box.php' );
			include_once( get_template_directory() . '/framework/settings/meta-box.php' );

			/*Theme Functions*/
			include_once( get_template_directory() . '/framework/includes/theme-functions.php' );

			if ( class_exists( 'WooCommerce' ) ) {

				/* Woo Functions*/
				include_once( get_template_directory() . '/framework/includes/woo-functions.php' );

			}

			/* Custom css and js*/
			include_once( get_template_directory() . '/framework/includes/custom-css-js.php' );

			// Register custom shortcodes
			if ( class_exists( 'Vc_Manager' ) ) {
				include_once( get_template_directory() . '/framework/includes/visual-composer.php' );
			}
		}

	}

	new Smarket_framework();
}