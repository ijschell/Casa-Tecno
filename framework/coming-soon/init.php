<?php
// don't load directly
if ( !defined( 'ABSPATH' ) ) {
	die( '-1' );
}

if ( !class_exists( 'Coming_Soon' ) ) {
	class Coming_Soon
	{

		/**
		 * Coming_Soon Constructor.
		 */
		public function __construct()
		{
			$this->includes();
			add_action( 'template_redirect', array( $this, 'smarket_coming_soon_redirect' ) );
			add_action( 'wp_before_admin_bar_render', array( $this, 'smarket_coming_soon_mode_admin_toolbar' ), 999 );
			add_filter( 'wp_title', array( $this, 'smarket_wp_title' ), 10, 2 );

		}
		/**
		 * Include required core files used in admin and on the frontend.
		 */
		public function includes()
		{

			include_once( get_template_directory() . '/framework/coming-soon/include/coming-soon.php' );

		}
		public function smarket_coming_soon_redirect()
		{

			$is_coming_soon_mode                  = ( smarket_option( 'enable_coming_soon', '' ) ) ? smarket_option( 'enable_coming_soon', '' ) == '1' : false;
			$disable_if_date_smaller_than_current = ( smarket_option( 'opt_disable_coming_soon_when_date_small', '' ) ) ? smarket_option( 'opt_disable_coming_soon_when_date_small', '' ) == '1' : false;
			$coming_date                          = ( smarket_option( 'coming_soon_date', '' ) ) ? smarket_option( 'coming_soon_date', '' ) : '';

			$today = date( 'm/d/Y' );

			if ( trim( $coming_date ) == '' || strtotime( $coming_date ) <= strtotime( $today ) ) {
				if ( $disable_if_date_smaller_than_current ) {
					$is_coming_soon_mode = false;
				}
			}

			// Dont't show coming soon page if is user logged in or is not coming soon mode on
			if ( is_user_logged_in() || !$is_coming_soon_mode ) {
				return;
			}

			smarket_coming_soon_html(); // Locate in theme_coming_soon_template.php

			exit();
		}
		public function smarket_coming_soon_mode_admin_toolbar()
		{
			global $wp_admin_bar;

			$is_coming_soon_mode                  = ( smarket_option( 'enable_coming_soon', '' ) ) ? smarket_option( 'enable_coming_soon', '' ) == '1' : false;
			$disable_if_date_smaller_than_current = ( smarket_option( 'opt_disable_coming_soon_when_date_small', '' ) ) ? smarket_option( 'opt_disable_coming_soon_when_date_small', '' ) == '1' : false;
			$coming_date                          = ( smarket_option( 'coming_soon_date', '' ) ) ? smarket_option( 'coming_soon_date', '' ) : '';

			$today = date( 'm/d/Y' );

			if ( trim( $coming_date ) == '' || strtotime( $coming_date ) <= strtotime( $today ) ) {
				if ( $disable_if_date_smaller_than_current && $is_coming_soon_mode ) {
					$is_coming_soon_mode = false;
					$menu_item_class     = 'smarket_coming_soon_expired';
					if ( current_user_can( 'administrator' ) ) { // Coming soon expired

						$date = ( smarket_option( 'coming_soon_date', '' ) ) ? smarket_option( 'coming_soon_date', '' ) : date();

						$args = array(
							'id'     => 'smarket_coming_soon',
							'parent' => 'top-secondary',
							'title'  => esc_html__( 'Coming Soon Mode Expired', 'smarket' ),
							'href'   => esc_url( admin_url( 'admin.php?page=smarket_options' ) ),
							'meta'   => array(
								'class' => 'smarket_coming_soon_expired',
								'title' => esc_html__( 'Coming soon mode is actived but expired', 'smarket' ),
							),
						);
						$wp_admin_bar->add_menu( $args );
					}
				}
			}

			if ( current_user_can( 'administrator' ) && $is_coming_soon_mode ) {

				$date = ( smarket_option( 'coming_soon_date', '' ) ) ? smarket_option( 'coming_soon_date', '' ) : date();

				$args = array(
					'id'     => 'maxstoreplus_coming_soon',
					'parent' => 'top-secondary',
					'title'  => esc_html__( 'Coming Soon Mode', 'smarket' ),
					'href'   => esc_url( admin_url( 'admin.php?page=smarket_options' ) ),
					'meta'   => array(
						'class' => 'smarket_coming_soon smarket-countdown-wrap countdown-admin-menu smarket-cms-date_' . esc_attr( $date ),
						'title' => esc_html__( 'Coming soon mode is actived', 'smarket' ),
					),
				);
				$wp_admin_bar->add_menu( $args );
			}

		}
		public function smarket_wp_title( $title, $separator )
		{

			if ( is_feed() ) {
				return $title;
			}

			$is_coming_soon_mode = ( smarket_option( 'enable_coming_soon', '' ) ) ? smarket_option( 'enable_coming_soon', '' ) == '1' : false;

			if ( !current_user_can( 'administrator' ) && $is_coming_soon_mode ) {
				$title = ( smarket_option( 'coming_soon_title', '' ) ) ? smarket_option( 'coming_soon_title', '' ) : $title;
			} else {
				return $title;
			}

			return $title;
		}
	}
	new Coming_Soon();
}
