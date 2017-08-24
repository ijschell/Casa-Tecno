<?php
$opt_enable_vertical_menu     = smarket_option( 'opt_enable_vertical_menu', '1' );
$opt_click_open_vertical_menu = smarket_option( 'opt_click_open_vertical_menu', '1' );
$opt_vertical_item_visible    = smarket_option( 'opt_vertical_item_visible', 10 );

$smarket_page_setting         = smarket_get_post_meta( get_the_ID(), 'page_setting', '0' );
$header_vectical_collapse     = smarket_get_post_meta( get_the_ID(), 'header_vectical_collapse', '1' );
$header_vectical_item_visible = smarket_get_post_meta( get_the_ID(), 'header_vectical_item_visible', '10' );
$header_vectical_menu         = smarket_get_post_meta( get_the_ID(), 'header_vectical_menu', '1' );

if ( $smarket_page_setting == 1 ) {
	$opt_enable_vertical_menu     = $header_vectical_menu;
	$opt_click_open_vertical_menu = $header_vectical_collapse;
	$opt_vertical_item_visible    = $header_vectical_item_visible;
}

$header_nav_class = array( 'header-nav header-sticky' );
if ( $opt_enable_vertical_menu == 1 ) {
	$header_nav_class[] = 'has-vertical-menu';
}
?>
<?php if ( $opt_enable_vertical_menu == '1' ): ?>
	<?php
	$block_vertical_class = array( 'vertical-wapper block-nav-categori' );
	if ( ( $opt_click_open_vertical_menu == '0' ) && ( is_front_page() || ( isset( $_GET[ 'smarket_is_home' ] ) && $_GET[ 'smarket_is_home' ] == 'true' ) ) || smarket_check_demo_is_homepage() ) {
		$block_vertical_class[] = 'open-on-home is-home always-open';
	}
	$opt_vertical_menu_title             = smarket_option( 'opt_vertical_menu_title', 'Shop By Category' );
	$opt_vertical_menu_button_all_text   = smarket_option( 'opt_vertical_menu_button_all_text', 'All Categories' );
	$opt_vertical_menu_button_close_text = smarket_option( 'opt_vertical_menu_button_close_text', 'Close' );

	$header_vectical_title             = smarket_get_post_meta( get_the_ID(), 'header_vectical_title', 'Shop By Category' );
	$header_vectical_button_all_text   = smarket_get_post_meta( get_the_ID(), 'header_vectical_button_all_text', 'All Categories' );
	$header_vectical_button_close_text = smarket_get_post_meta( get_the_ID(), 'header_vectical_button_close_text', 'Close' );

	if ( $smarket_page_setting == 1 ) {
		$opt_vertical_menu_title             = $header_vectical_title;
		$opt_vertical_menu_button_all_text   = $header_vectical_button_all_text;
		$opt_vertical_menu_button_close_text = $header_vectical_button_close_text;
	}

	?>
    <!-- block categori -->
    <div data-items="<?php echo esc_attr( $opt_vertical_item_visible ); ?>"
         class="<?php echo esc_attr( implode( ' ', $block_vertical_class ) ); ?> has-open">
        <div class="block-title active">
			<span class="icon-bar">
				<i class="fa fa-align-justify" aria-hidden="true"></i>
			</span>
            <span class="text"><?php echo esc_html( $opt_vertical_menu_title ); ?></span>
        </div>
        <div class="block-content verticalmenu-content">
					<ul>
						<?php
						$categories_prods = get_terms('product_cat');
						foreach ($categories_prods as $key => $value) {
							// var_dump($value);
							$thumbnail_id = get_woocommerce_term_meta( $value->term_taxonomy_id, 'thumbnail_id', true );
							if ( $thumbnail_id ) {
								$image = wp_get_attachment_thumb_url( $thumbnail_id );
							} else {
								$image = false;
							}
							$name = $value->name;
							$slug = $value->slug;
							?>
							<li>
									<a href="<?php echo $slug; ?>" class="btn-view-all open-cate">
										<?php
										if($image != false){
											echo '<span style="background-image: url('.$image.')"></span>';
										}
										?>
										<i><?php echo $name; ?></i>
									</a>
							</li>
						<?php
						}
						?>
					</ul>
        </div>
    </div><!-- block categori -->
<?php endif; ?>
