<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}


if ( !function_exists( 'smarket_coming_soon_html' ) ) {

	function smarket_coming_soon_html()
	{

		$date       = smarket_option( 'coming_soon_date', '' ) ? smarket_option( 'coming_soon_date', '' ) : date();
		$title      = smarket_option( 'coming_soon_title', '' );
		$des        = smarket_option( 'coming_soon_des', '' );
		$logo       = smarket_option( 'logo_coming_soon', '' );
		$footer     = smarket_option( 'coming_soon_footer', '' );
		$background = smarket_option( 'coming_soon_background', '' );

		get_header( 'soon' );

		$html            = '';
		$logo_html       = '';
		$title_html      = '';
		$des_html        = '';
		$count_down_html = '';
		$footer_html     = '';
		$date_html = '';

		if ( !empty( $logo ) ) {
			$logo_html = '<div class="logo-maintenance logo-coming-soon"><a href="' . esc_url( get_home_url() ) . '"><img src="' . esc_url( $logo[ 'url' ] ) . '" alt=""></a></div>';
		}
		if ( $title ) {
			$title_html = '<h1 class="title-coming-soon">' . esc_html( $title ) . '</h1>';
		}
		if ( $footer ) {
			$footer_html = '<div class="footer-maintenance footer-coming-soon">' . esc_html( $footer ) . '</div>';
		}
		if ( $des ) {
			$des_html = '<p class="des-coming-soon des">' . esc_html( $des ) . '</p>';
		}

		if ( $date ) {
			$time = explode('/',$date);
			$date_html .= ' data-d='.$time[0].'';
			$date_html .= ' data-m='.$time[1].'';
			$date_html .= ' data-y='.$time[2].'';
			$date_html .= ' data-h=00';
			$date_html .= ' data-i=00';
			$date_html .= ' data-s=00';
		}

		$count_down_html = '<div class="smarket-countdown" '.esc_attr($date_html).'></div><!-- /.smarket-countdown-wrap -->';
		$html            .= '<div class="page-maintenance coming-soon" style="background-image: url(' . esc_url( $background[ 'url' ] ) . ');">
                                ' . $logo_html . '
                                <div class="content-maintenance">
                                    ' . $title_html . '
                                    ' . $des_html . '
                                    ' . $count_down_html . '
                                </div>
                                ' . $footer_html . '
                            </div>';

		echo balanceTags( $html );
		get_footer( 'soon' );

	}
}