/**
 * Created by khanh on 1/10/2017.
 */
(function ($) {
    "use strict"; // Start of use strict
    function change_input() {
        $('.rwmb-checkbox-wrapper').each(function () {
            if ( $(this).find('.rwmb-checkbox').is(":checked") ) {
                $(this).addClass('check');
            }
            $(this).find('.rwmb-input').change(function () {
                if( $(this).find('.rwmb-checkbox').is(":checked") ) {
                    $(this).parent().addClass("check");
                } else {
                    $(this).parent().removeClass("check");
                }
            })
        })
    };

    /* ---------------------------------------------
     Scripts ready
     --------------------------------------------- */
    $(document).ready(function() {
        if( $('.smarket_vc_taxonomy').length > 0){
            $('.smarket_vc_taxonomy').chosen();
        }
        $(document).on('change','.smarket_select_preview',function(){
            var url = $(this).find(':selected').data('img');
            $(this).parent('.container-select_preview').find('.image-preview img').attr('src',url);
        });
    });
    $(document).ajaxComplete(function (event, xhr, settings) {
        if( $('.smarket_vc_taxonomy').length > 0){
            $('.smarket_vc_taxonomy').chosen();
        }
    });

    /* ---------------------------------------------
     Scripts initialization
     --------------------------------------------- */
    $(window).load(function () {

    });
    $(window).bind("load", function () {
        change_input();
    });
})(jQuery); // End of use strict