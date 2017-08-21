<?php
$smarket_page_header_background = smarket_get_post_meta( get_the_ID(), 'smarket_page_header_background', '' );
$smarket_page_heading_height    = smarket_get_post_meta( get_the_ID(), 'smarket_page_heading_height', '' );
$smarket_page_margin_top        = smarket_get_post_meta( get_the_ID(), 'smarket_page_margin_top', '' );
$smarket_page_margin_bottom     = smarket_get_post_meta( get_the_ID(), 'smarket_page_margin_bottom', '' );
$css                            = '';

if ( $smarket_page_header_background && $smarket_page_header_background != "" ) {
	$css .= 'background-image:url("' . wp_get_attachment_url( $smarket_page_header_background ) . '");background-repeat: no-repeat;background-size: cover;';
}
if ( $smarket_page_heading_height && $smarket_page_heading_height != "" ) {
	$css .= 'min-height:' . $smarket_page_heading_height . 'px;';
}
if ( $smarket_page_margin_top && $smarket_page_margin_top != "" ) {
	$css .= 'margin-top:' . $smarket_page_margin_top . 'px;';
}
if ( $smarket_page_margin_bottom && $smarket_page_margin_bottom != "" ) {
	$css .= 'margin-bottom:' . $smarket_page_margin_bottom . 'px;';
}

?>
<!-- Banner page -->
<div class="banner-page banner-blog1" style='<?php echo  $css; ?>'>
    <div class="content-banner">
    </div>
</div>
<!-- /Banner page -->