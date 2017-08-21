<?php
$smarket_enable_popup = smarket_option('smarket_enable_popup','0');
$smarket_popup_title = smarket_option('smarket_popup_title','Newsletter');
$smarket_popup_subtitle = smarket_option('smarket_popup_subtitle','Subscribe to our mailling list to get updates to your email inbox.');

$smarket_popup_input_placeholder = smarket_option('smarket_popup_input_placeholder','Email Address');
$smarket_popup_butotn_text = smarket_option('smarket_popup_button_text','Sign Up');
$smarket_poppup_background = smarket_option('smarket_poppup_background','');
$smarket_poppup_socials = smarket_option('smarket_poppup_socials','');

if( $smarket_enable_popup == 0 ) return;
?>
<!--  Popup Newsletter-->
<div class="modal fade" id="popup-newsletter" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content" <?php if( $smarket_poppup_background['url'] ):?> style="background-image: url('<?php echo esc_url( $smarket_poppup_background['url']);?>');" <?php endif;?> >
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <div class="modal-inner">
                <?php if( $smarket_popup_title ):?>
                    <h3 class="title"><?php echo esc_html( $smarket_popup_title );?></h3>
                <?php endif;?>
                <?php if( $smarket_popup_subtitle ):?>
                    <div class="sub-title"><?php echo esc_html( $smarket_popup_subtitle );?></div>
                <?php endif;?>
                <div class="newsletter-form-wrap">
                    <input class="email" type="email" name="email" placeholder="<?php echo esc_html( $smarket_popup_input_placeholder );?>">
                    <button type="submit" name="submit_button" class="btn-submit submit-newsletter"><?php echo esc_html( $smarket_popup_butotn_text );?></button>
                </div>
                <div class="checkbox btn-checkbox">
                    <label>
                        <input class="smarket_disabled_popup_by_user" type="checkbox"><span><?php echo esc_html__('Don&rsquo;t show this popup again','smarket');?></span>
                    </label>
                </div>
                <?php if( $smarket_poppup_socials && is_array( $smarket_poppup_socials ) && count( $smarket_poppup_socials ) > 0 ):?>
                    <div class="block-social">
                        <div class="block-title"><?php esc_html_e('Flolow Us','smarket');?></div>
                        <div class="block-content">
                            <?php
                            foreach ( $smarket_poppup_socials as $social ){
                                smarket_social($social);
                            }
                            ?>
                        </div>
                    </div>
                <?php endif;?>
            </div>
        </div>
    </div>
</div><!--  Popup Newsletter-->