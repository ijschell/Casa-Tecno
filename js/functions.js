(function ($) {
    "use strict"; // Start of use strict

    function kt_masonry($masonry) {
        var t = $masonry.attr("data-cols");
        if ( t == "1" ) {
            var n = $masonry.width();
            var r = 1;
            return r
        }
        if ( t == "2" ) {
            var n = $masonry.width();
            var r = 2;
            if ( n < 600 ) r = 1;
            return r
        } else if ( t == "3" ) {
            var n = $masonry.width();
            var r = 3;
            if ( n < 600 ) r = 1;
            else if ( n >= 600 && n < 768 ) r = 2;
            else if ( n >= 768 && n < 992 ) r = 3;
            else if ( n >= 992 ) r = 3;
            return r
        } else if ( t == "4" ) {
            var n = $masonry.width();
            var r = 4;
            if ( n < 600 ) r = 1;
            else if ( n >= 600 && n < 768 ) r = 2;
            else if ( n >= 768 && n < 992 ) r = 3;
            else if ( n >= 992 ) r = 4;
            return r
        } else if ( t == "5" ) {
            var n = $masonry.width();
            var r = 5;
            if ( n < 600 ) r = 1;
            else if ( n >= 600 && n < 768 ) r = 2;
            else if ( n >= 768 && n < 992 ) r = 3;
            else if ( n >= 992 && n < 1140 ) r = 4;
            else if ( n >= 1140 ) r = 5;
            return r
        } else if ( t == "6" ) {
            var n = $masonry.width();
            var r = 5;
            if ( n < 600 ) r = 1;
            else if ( n >= 600 && n < 768 ) r = 2;
            else if ( n >= 768 && n < 992 ) r = 3;
            else if ( n >= 992 && n < 1160 ) r = 4;
            else if ( n >= 1160 ) r = 6;
            return r
        } else if ( t == "8" ) {
            var n = $masonry.width();
            var r = 5;
            if ( n < 600 ) r = 1;
            else if ( n >= 600 && n < 768 ) r = 2;
            else if ( n >= 768 && n < 992 ) r = 3;
            else if ( n >= 992 && n < 1160 ) r = 4;
            else if ( n >= 1160 ) r = 8;
            return r
        }
    };

    function cp_s($masonry) {
        var t = kt_masonry($masonry);
        var n = $masonry.width();
        var r = n / t;
        r     = Math.floor(r);
        $masonry.find(".portfolio-item").each(function (t) {
            $(this).css({
                width: r + "px"
            });
        });
    };

    function sm_masonry() {
        $('.sm-portfolio').each(function () {
            var $masonry    = $(this).find('.portfolio-grid');
            var $layoutMode = $masonry.attr('data-layoutMode');
            cp_s($masonry);
            // init Isotope
            var $grid = $masonry.isotope({
                itemSelector: '.portfolio',
                layoutMode: $layoutMode,
                itemPositionDataEnabled: true
            });

            $grid.imagesLoaded().progress(function () {
                $grid.isotope({
                    itemSelector: '.portfolio',
                    layoutMode: $layoutMode,
                    itemPositionDataEnabled: true
                });
            });

            $(this).find('.portfolio_fillter .item-fillter').on('click', function () {
                var $filterValue = $(this).attr('data-filter');
                $grid.isotope({
                    filter: $filterValue
                });
                $(this).closest('.sm-portfolio').find('.portfolio_fillter .item-fillter').removeClass('fillter-active');
                $(this).addClass('fillter-active');
            });

        });
    };


    /* ---------------------------------------------
     Woocommerce Quantily
     --------------------------------------------- */
    function smarket_woo_quantily() {
        $('body').on('click', '.quantity .quantity-plus', function () {
            var obj_qty  = $(this).closest('.quantity').find('input.qty'),
                val_qty  = parseInt(obj_qty.val()),
                min_qty  = parseInt(obj_qty.data('min')),
                max_qty  = parseInt(obj_qty.data('max')),
                step_qty = parseInt(obj_qty.data('step'));
            val_qty      = val_qty + step_qty;
            if ( max_qty && val_qty > max_qty ) {
                val_qty = max_qty;
            }
            obj_qty.val(val_qty);
            obj_qty.trigger("change");
            return false;
        });

        $('body').on('click', '.quantity .quantity-minus', function () {
            var obj_qty  = $(this).closest('.quantity').find('input.qty'),
                val_qty  = parseInt(obj_qty.val()),
                min_qty  = parseInt(obj_qty.data('min')),
                max_qty  = parseInt(obj_qty.data('max')),
                step_qty = parseInt(obj_qty.data('step'));
            val_qty      = val_qty - step_qty;
            if ( min_qty && val_qty < min_qty ) {
                val_qty = min_qty;
            }
            if ( !min_qty && val_qty < 0 ) {
                val_qty = 0;
            }
            obj_qty.val(val_qty);
            obj_qty.trigger("change");
            return false;
        });
    }

    function dropdown_menu(contain) {
        $(contain).each(function () {
            var _main = $(this);
            _main.children('.menu-item.parent').each(function () {

                var curent = $(this).find('.submenu');

                $(this).children('.toggle-submenu').on('click', function () {
                    $(this).parent().children('.submenu').slideToggle(400);
                    _main.find('.submenu').not(curent).slideUp(400);

                    $(this).parent().toggleClass('show-submenu');
                    _main.find('.menu-item.parent').not($(this).parent()).removeClass('show-submenu');
                });

                var next_curent = $(this).find('.submenu');

                next_curent.children('.menu-item.parent').each(function () {

                    var child_curent = $(this).find('.submenu');
                    $(this).children('.toggle-submenu').on('click', function () {
                        $(this).parent().parent().find('.submenu').not(child_curent).slideUp(400);
                        $(this).parent().children('.submenu').slideToggle(400);

                        $(this).parent().parent().find('.menu-item.parent').not($(this).parent()).removeClass('show-submenu');
                        $(this).parent().toggleClass('show-submenu');
                    })
                });
            });
        });
    };
    dropdown_menu('.smarket-nav.vertical-menu');

    /* ---------------------------------------------
     MENU REPONSIIVE
     --------------------------------------------- */
    function smarket_init_menu_reposive() {

        var window_size = $('body').innerWidth();

        if ( window_size <= 1024 ) {
            dropdown_menu('#box-mobile-menu .smarket-nav');
        } else {
            $(document).on('mouseenter', '.header .smarket-nav .menu-item-has-children', function () {
                $(this).addClass('show-submenu');
            }).on('mouseleave', '.header .smarket-nav .menu-item-has-children', function () {
                $(this).removeClass('show-submenu');
            });
        }
    }

    function smarket_clone_main_menu() {
        if ( $('#header .clone-main-menu').length > 0 ) {
            $('#box-mobile-menu .clone-main-menu').remove();
            $("#header .clone-main-menu").clone().appendTo("#box-mobile-menu .box-inner");
            $('#box-mobile-menu').find('.clone-main-menu').removeAttr('id');
        }
    }

    /* ---------------------------------------------
     Resize mega menu
     --------------------------------------------- */
    function smarket_resizeMegamenu() {
        var window_size = jQuery('body').innerWidth();
        window_size += smarket_get_scrollbar_width();
        if ( window_size > 767 ) {
            if ( $('#header .main-menu-wapper').length > 0 ) {
                var container = $('#header .main-menu-wapper');
                if ( container != 'undefined' ) {
                    var container_width  = 0;
                    container_width      = container.innerWidth();
                    var container_offset = container.offset();
                    setTimeout(function () {
                        $('.main-menu .item-megamenu').each(function (index, element) {
                            $(element).children('.megamenu').css({'max-width': container_width + 'px'});
                            var sub_menu_width = $(element).children('.megamenu').outerWidth();
                            var item_width     = $(element).outerWidth();
                            $(element).children('.megamenu').css({'left': '-' + (sub_menu_width / 2 - item_width / 2) + 'px'});
                            var container_left  = container_offset.left;
                            var container_right = (container_left + container_width);
                            var item_left       = $(element).offset().left;
                            var overflow_left   = (sub_menu_width / 2 > (item_left - container_left));
                            var overflow_right  = ((sub_menu_width / 2 + item_left) > container_right);
                            if ( overflow_left ) {
                                var left = (item_left - container_left);
                                $(element).children('.megamenu').css({'left': -left + 'px'});
                            }
                            if ( overflow_right && !overflow_left ) {
                                var left = (item_left - container_left);
                                left     = left - ( container_width - sub_menu_width );
                                $(element).children('.megamenu').css({'left': -left + 'px'});
                            }
                        })
                    }, 100);
                }
            }
        }
    }

    function smarket_get_scrollbar_width() {
        var $inner = jQuery('<div style="width: 100%; height:200px;">test</div>'),
            $outer = jQuery('<div style="width:200px;height:150px; position: absolute; top: 0; left: 0; visibility: hidden; overflow:hidden;"></div>').append($inner),
            inner  = $inner[ 0 ],
            outer  = $outer[ 0 ];
        jQuery('body').append(outer);
        var width1 = inner.offsetWidth;
        $outer.css('overflow', 'scroll');
        var width2 = outer.clientWidth;
        $outer.remove();
        return (width1 - width2);
    }

    /*==============================
     Auto width Vertical menu
     ===============================*/
    function smarket_auto_width_vertical_menu() {
        setTimeout(function () {
            var full_width = parseInt($('.container').innerWidth()) - 30;
            var menu_width = parseInt($('.verticalmenu-content').actual('width'));

            var w = (full_width - menu_width);
            $('.verticalmenu-content').find('.megamenu').each(function () {
                $(this).css('max-width', w + 'px');
            });
        }, 100)

    }

    function smarket_show_other_item_vertical_menu() {
        if ( $('.block-nav-categori').length > 0 ) {

            $('.block-nav-categori').each(function () {
                var all_item   = 0;
                var limit_item = $(this).data('items') - 1;
                all_item       = $(this).find('.vertical-menu>li').length;

                if ( all_item > (limit_item + 1) ) {
                    $(this).addClass('show-button-all');
                }
                $(this).find('.vertical-menu>li').each(function (i) {
                    all_item = all_item + 1;
                    if ( i > limit_item ) {
                        $(this).addClass('link-orther');
                    }
                })
            })
        }
    }

    //EQUAL ELEM
    function better_equal_elems() {
        setTimeout(function () {
            $('.equal-container.better-height').each(function () {
                var $this = $(this);
                if ( $this.find('.equal-elem').length ) {
                    $this.find('.equal-elem').css({
                        'height': 'auto'
                    });
                    var elem_height = 0;
                    $this.find('.equal-elem').each(function () {
                        var this_elem_h = $(this).height();
                        if ( elem_height < this_elem_h ) {
                            elem_height = this_elem_h;
                        }
                    });
                    $this.find('.equal-elem').height(elem_height);
                }
            });
        }, 2000);
    }

    /* ---------------------------------------------
     TAB EFFECT
     --------------------------------------------- */
    function smarket_tab_fade_effect() {
        // effect click
        $(document).on('click', '.smarket-tabs .tabs-link a', function () {
            var tab_id       = $(this).attr('href');
            var tab_animated = $(this).data('animate');

            tab_animated = ( tab_animated == undefined || tab_animated == "" ) ? '' : tab_animated;
            if ( tab_animated == "" ) {
                return false;
            }

            $(tab_id).find('.product-list-owl .owl-item.active, .product-list-grid .product-item').each(function (i) {

                var t     = $(this);
                var style = $(this).attr("style");
                style     = ( style == undefined ) ? '' : style;
                var delay = i * 400;
                t.attr("style", style +
                    ";-webkit-animation-delay:" + delay + "ms;"
                    + "-moz-animation-delay:" + delay + "ms;"
                    + "-o-animation-delay:" + delay + "ms;"
                    + "animation-delay:" + delay + "ms;"
                ).addClass(tab_animated + ' animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                    t.removeClass(tab_animated + ' animated');
                    t.attr("style", style);
                });
            })
        })
    }

    function smarket_init_carousel() {

        var _width = $(window).innerWidth();

        $('#yith-quick-view-content .woocommerce-gallery-carousel').each(function () {
            $(this).addClass('owl-carousel');
            $(this).owlCarousel({
                navText: [ '<i class="pe-7s-angle-left"></i>', '<i class="pe-7s-angle-right"></i>' ],
                loop: true,
                items: 1,
                nav: true,
                dots: false
            })
        });

        $(".owl-carousel").each(function (index, el) {
            var config = $(this).data();
            if ( $(this).hasClass('nav-awesome') ) {
                config.navText = [ '<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>' ];
            } else {
                config.navText = [ '<i class="pe-7s-angle-left"></i>', '<i class="pe-7s-angle-right"></i>' ];
            }
            var animateOut = $(this).data('animateout');
            var animateIn  = $(this).data('animatein');
            var slidespeed = $(this).data('slidespeed');
            if ( typeof animateOut != 'undefined' ) {
                config.animateOut = animateOut;
            }
            if ( typeof animateIn != 'undefined' ) {
                config.animateIn = animateIn;
            }
            if ( typeof (slidespeed) != 'undefined' ) {
                config.smartSpeed = slidespeed;
            }

            if ( $('body').hasClass('rtl') ) {
                config.rtl = true;
            }
            if ( smarket_fontend_global_script.smarket_enable_lazy == '1' ) {
                config.lazyLoad = true;
            }

            var owl = $(this);
            owl.on('initialized.owl.carousel', function (event) {
                var total_active = owl.find('.owl-item.active').length;
                var i            = 0;
                owl.find('.owl-item').removeClass('item-first item-last');
                setTimeout(function () {
                    owl.find('.owl-item.active').each(function () {
                        i++;
                        if ( i == 1 ) {
                            $(this).addClass('item-first');
                        }
                        if ( i == total_active ) {
                            $(this).addClass('item-last');
                        }
                    });

                }, 100);
            })
            owl.on('refreshed.owl.carousel', function (event) {
                var total_active = owl.find('.owl-item.active').length;
                var i            = 0;
                owl.find('.owl-item').removeClass('item-first item-last');
                setTimeout(function () {
                    owl.find('.owl-item.active').each(function () {
                        i++;
                        if ( i == 1 ) {
                            $(this).addClass('item-first');
                        }
                        if ( i == total_active ) {
                            $(this).addClass('item-last');
                        }
                    });

                }, 100);
            })
            owl.on('change.owl.carousel', function (event) {
                var total_active = owl.find('.owl-item.active').length;
                var i            = 0;
                owl.find('.owl-item').removeClass('item-first item-last');
                setTimeout(function () {
                    owl.find('.owl-item.active').each(function () {
                        i++;
                        if ( i == 1 ) {
                            $(this).addClass('item-first');
                        }
                        if ( i == total_active ) {
                            $(this).addClass('item-last');
                        }
                    });

                }, 100);


            })
            owl.owlCarousel(config);

        });
    }

    /* ---------------------------------------------
     COUNTDOWN
     --------------------------------------------- */
    function smarket__countdown() {
        if ( $('.smarket-countdown').length > 0 ) {
            var labels = [ 'Years', 'Months', 'Weeks', 'Days', 'Hrs', 'Mins', 'Secs' ];
            var layout = '<span class="box-count day"><span class="number">{dnn}</span> <span class="text">Days</span></span><span class="dot">:</span><span class="box-count hrs"><span class="number">{hnn}</span> <span class="text">Hours</span></span><span class="dot">:</span><span class="box-count min"><span class="number">{mnn}</span> <span class="text">Mins</span></span><span class="dot">:</span><span class="box-count secs"><span class="number">{snn}</span> <span class="text">Secs</span></span>';
            $('.smarket-countdown').each(function () {
                var austDay = new Date($(this).data('y'), $(this).data('m') - 1, $(this).data('d'), $(this).data('h'), $(this).data('i'), $(this).data('s'));
                $(this).countdown({
                    until: austDay,
                    labels: labels,
                    layout: layout
                });
            });
        }
    };

    function smarket_back_to_top() {
        var h = $(window).scrollTop();

        if ( h > 1000 ) {
            $('.backtotop').addClass('show');
        }
        else {
            $('.backtotop').removeClass('show');
        }
    };

    /* ---------------------------------------------
     Init popup
     --------------------------------------------- */
    function smarket_init_popup() {
        if ( smarket_fontend_global_script.smarket_enable_popup_mobile == 0 ) {
            if ( $(window).width() + smarket_get_scrollbar_width() < 768 ) {
                return false;
            }
        }
        var disabled_popup_by_user = getCookie('smarket_disabled_popup_by_user');
        if ( disabled_popup_by_user == 'true' ) {

        } else {
            if ( $('body').hasClass('home') && smarket_fontend_global_script.smarket_enable_popup && smarket_fontend_global_script.smarket_enable_popup == '1' ) {
                setTimeout(function () {
                    $('#popup-newsletter').modal({
                        keyboard: false
                    })
                }, smarket_fontend_global_script.smarket_popup_delay_time);

            }
        }
    }

    $(document).on('change', '.smarket_disabled_popup_by_user', function () {
        if ( $(this).is(":checked") ) {
            setCookie("smarket_disabled_popup_by_user", 'true', 7);
        } else {
            setCookie("smarket_disabled_popup_by_user", '', 0);
        }
    });

    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires     = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + "; " + expires;
    }

    function getCookie(cname) {
        var name = cname + "=";
        var ca   = document.cookie.split(';');
        for ( var i = 0; i < ca.length; i++ ) {
            var c = ca[ i ];
            while ( c.charAt(0) == ' ' ) {
                c = c.substring(1);
            }
            if ( c.indexOf(name) == 0 ) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    function smarket_google_maps() {
        if ( $('.smarket-google-maps').length <= 0 ) {
            return;
        }
        $('.smarket-google-maps').each(function () {
            var $this            = $(this),
                $id              = $this.attr('id'),
                $title_maps      = $this.attr('data-title_maps'),
                $phone           = $this.attr('data-phone'),
                $email           = $this.attr('data-email'),
                $zoom            = parseInt($this.attr('data-zoom')),
                $latitude        = $this.attr('data-latitude'),
                $longitude       = $this.attr('data-longitude'),
                $address         = $this.attr('data-address'),
                $map_type        = $this.attr('data-map-type'),
                $pin_icon        = $this.attr('data-pin-icon'),
                $modify_coloring = $this.attr('data-modify-coloring') === "true" ? true : false,
                $saturation      = $this.attr('data-saturation'),
                $hue             = $this.attr('data-hue'),
                $map_style       = $this.data('map-style'),
                $styles;

            if ( $modify_coloring == true ) {
                var $styles = [
                    {
                        stylers: [
                            {hue: $hue},
                            {invert_lightness: false},
                            {saturation: $saturation},
                            {lightness: 1},
                            {
                                featureType: "landscape.man_made",
                                stylers: [ {
                                    visibility: "on"
                                } ]
                            }
                        ]
                    }, {
                        featureType: 'water',
                        elementType: 'geometry',
                        stylers: [
                            {color: '#46bcec'}
                        ]
                    }
                ];
            }
            var map;
            var bounds     = new google.maps.LatLngBounds();
            var mapOptions = {
                zoom: $zoom,
                panControl: true,
                zoomControl: true,
                mapTypeControl: true,
                scaleControl: true,
                draggable: true,
                scrollwheel: false,
                mapTypeId: google.maps.MapTypeId[ $map_type ],
                styles: $styles
            };

            map = new google.maps.Map(document.getElementById($id), mapOptions);
            map.setTilt(45);

            // Multiple Markers
            var markers           = [];
            var infoWindowContent = [];

            if ( $latitude != '' && $longitude != '' ) {
                markers[ 0 ]           = [ $address, $latitude, $longitude ];
                infoWindowContent[ 0 ] = [ $address ];
            }

            var infoWindow = new google.maps.InfoWindow(), marker, i;

            for ( i = 0; i < markers.length; i++ ) {
                var position = new google.maps.LatLng(markers[ i ][ 1 ], markers[ i ][ 2 ]);
                bounds.extend(position);
                marker = new google.maps.Marker({
                    position: position,
                    map: map,
                    title: markers[ i ][ 0 ],
                    icon: $pin_icon
                });
                if ( $map_style == '1' ) {

                    if ( infoWindowContent[ i ][ 0 ].length > 1 ) {
                        infoWindow.setContent(
                            '<div style="background-color:#fff; padding: 30px 30px 10px 25px; width:290px;line-height: 22px" class="smarket-map-info">' +
                            '<h4 class="map-title">' + $title_maps + '</h4>' +
                            '<div class="map-field"><i class="fa fa-map-marker"></i><span>&nbsp;' + $address + '</span></div>' +
                            '<div class="map-field"><i class="fa fa-phone"></i><span>&nbsp;' + $phone + '</span></div>' +
                            '<div class="map-field"><i class="fa fa-envelope"></i><span><a href="mailto:' + $email + '">&nbsp;' + $email + '</a></span></div> ' +
                            '</div>'
                        );
                    }

                    infoWindow.open(map, marker);

                }
                if ( $map_style == '2' ) {
                    google.maps.event.addListener(marker, 'click', (function (marker, i) {
                        return function () {
                            if ( infoWindowContent[ i ][ 0 ].length > 1 ) {
                                infoWindow.setContent(
                                    '<div style="background-color:#fff; padding: 30px 30px 10px 25px; width:290px;line-height: 22px" class="smarket-map-info">' +
                                    '<h4 class="map-title">' + $title_maps + '</h4>' +
                                    '<div class="map-field"><i class="fa fa-map-marker"></i><span>&nbsp;' + $address + '</span></div>' +
                                    '<div class="map-field"><i class="fa fa-phone"></i><span>&nbsp;' + $phone + '</span></div>' +
                                    '<div class="map-field"><i class="fa fa-envelope"></i><span><a href="mailto:' + $email + '">&nbsp;' + $email + '</a></span></div> ' +
                                    '</div>'
                                );
                            }

                            infoWindow.open(map, marker);
                        }
                    })(marker, i));
                }

                map.fitBounds(bounds);
            }

            var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function (event) {
                this.setZoom($zoom);
                google.maps.event.removeListener(boundsListener);
            });
        });
    }

    /* AJAX REMOVE */
    $(document).on('click', '.minicart-items .delete', function (e) {
        var $this      = $(this);
        var thisItem   = $this.closest('.mini-cart-content');
        var remove_url = $this.attr('href');
        var product_id = $this.attr('data-product_id');

        if ( thisItem.is('.loading') ) {
            return false;
        }

        if ( $.trim(remove_url) !== '' && $.trim(remove_url) !== '#' ) {

            thisItem.addClass('loading');

            var nonce         = smarket_get_url_var('_wpnonce', remove_url);
            var cart_item_key = smarket_get_url_var('remove_item', remove_url);

            var data = {
                action: 'smarket_remove_cart_item_via_ajax',
                product_id: product_id,
                cart_item_key: cart_item_key,
                nonce: nonce
            };

            $.post(smarket_ajax_frontend[ 'ajaxurl' ], data, function (response) {

                if ( response[ 'err' ] != 'yes' ) {
                    $('.smarket-mini-cart').replaceWith(response[ 'mini_cart_html' ]);
                    $(document.body).trigger('wc_fragment_refresh');
                }
                thisItem.removeClass('loading');

            });

            e.preventDefault();
        }

        return false;

    });

    function smarket_get_url_var(key, url) {
        var result = new RegExp(key + "=([^&]*)", "i").exec(url);
        return result && result[ 1 ] || "";
    }

    /* ORDER BY */
    $(document).on('submit', '.woocommerce-ordering', function () {
        return false;
    });
    $(document).on('change', '.woocommerce-ordering .orderby', function () {
        var _val = $(this).val();
        var _url = window.location.href;
        var xhttp;

        _url += ( _url.indexOf("?") === -1 ? "?" : "&" ) + "orderby=" + _val;

        $('.main-content').addClass('loading');

        if ( window.XMLHttpRequest )
            xhttp = new XMLHttpRequest();
        else
            xhttp = new ActiveXObject("Microsoft.XMLHTTP");
        xhttp.onreadystatechange = function () {
            if ( xhttp.readyState == 4 && xhttp.status == 200 ) {
                var $html       = $.parseHTML(xhttp.responseText);
                var $new_form   = $('.main-content', $html);
                var $new_form_2 = $('.woocommerce-breadcrumb', $html);

                $('.main-content').replaceWith($new_form);
                $('.woocommerce-breadcrumb').replaceWith($new_form_2);

                $('.shop-perpage .option-perpage,.woocommerce-ordering .orderby').trigger("chosen:updated");
                $('.main-content').removeClass('loading');
                smarket_ajax_lazy_load();
                //window.history.pushState({"html": xhttp.responseText, "pageTitle": _val}, "", window.location.href);
            }
        };
        xhttp.open("GET", _url, true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(null);
        return false;
    });

    /* option perpage products */
    $(document).on('change', '.shop-perpage .option-perpage', function () {
        var _mode = $(this).val();
        var _url  = window.location.href;
        var xhttp;

        _url += ( _url.indexOf("?") === -1 ? "?" : "&" ) + 'woo_products_perpage=' + _mode;

        $('.main-content').addClass('loading');

        if ( window.XMLHttpRequest )
            xhttp = new XMLHttpRequest();
        else
            xhttp = new ActiveXObject("Microsoft.XMLHTTP");
        xhttp.onreadystatechange = function () {
            if ( xhttp.readyState == 4 && xhttp.status == 200 ) {
                var $html       = $.parseHTML(xhttp.responseText);
                var $new_form   = $('.main-content', $html);
                var $new_form_2 = $('.woocommerce-breadcrumb', $html);

                $('.main-content').replaceWith($new_form);
                $('.woocommerce-breadcrumb').replaceWith($new_form_2);

                $('.shop-perpage .option-perpage,.woocommerce-ordering .orderby').trigger("chosen:updated");
                $('.main-content').removeClass('loading');
                smarket_ajax_lazy_load();
            }
        };
        xhttp.open("POST", _url, true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("smarket_woo_products_perpage=" + _mode);
        return false;
    });
    /*  VIEW GRID LIST */
    $(document).on('click', '.display-mode', function () {
        var _mode = $(this).data('mode');
        var _url  = window.location.href;
        var xhttp;

        _url += ( _url.indexOf("?") === -1 ? "?" : "&" ) + 'woo_shop_list_style=' + _mode;

        $(this).addClass('active').siblings().removeClass('active');
        $('.main-content').addClass('loading');

        if ( window.XMLHttpRequest )
            xhttp = new XMLHttpRequest();
        else
            xhttp = new ActiveXObject("Microsoft.XMLHTTP");
        xhttp.onreadystatechange = function () {
            if ( xhttp.readyState == 4 && xhttp.status == 200 ) {
                var $html       = $.parseHTML(xhttp.responseText);
                var $new_form   = $('.main-content', $html);
                var $new_form_2 = $('.woocommerce-breadcrumb', $html);

                $('.main-content').replaceWith($new_form);
                $('.woocommerce-breadcrumb').replaceWith($new_form_2);

                $('.shop-perpage .option-perpage,.woocommerce-ordering .orderby').trigger("chosen:updated");
                $('.main-content').removeClass('loading');
                smarket_ajax_lazy_load();
            }
        };
        xhttp.open("POST", _url, true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("shop_display_mode=" + _mode);
        return false;
    });

    /* update wishlist count */

    var smarket_update_wishlist_count = function () {
        $.ajax({
            beforeSend: function () {

            },
            complete: function () {

            },
            data: {
                action: 'smarket_update_wishlist_count'
            },
            success: function (data) {
                //do something
                $('.header-wishlist .count').text('(' + data + ')');
            },

            url: yith_wcwl_l10n.ajax_url
        });
    };

    $('body').on('added_to_wishlist removed_from_wishlist', smarket_update_wishlist_count);

    function slick_slider() {
        $('.style-standard-horizon .flex-control-thumbs').each(function () {
            if ( $(this).children().length == 0 ) {
                return;
            }
            $(this).slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                infinite: false,
                prevArrow: '<span class="pe-7s-angle-left"></span>',
                nextArrow: '<span class="pe-7s-angle-right"></span>',
                responsive: [
                    {
                        breakpoint: 1025,
                        settings: {
                            slidesToShow: 3,
                        }
                    }
                ]
            });
        });
        $('.style-standard-vertical .flex-control-thumbs').each(function () {
            if ( $(this).children().length == 0 ) {
                return;
            }
            $(this).slick({
                vertical: true,
                slidesToShow: 4,
                slidesToScroll: 1,
                infinite: false,
                prevArrow: '<span class="pe-7s-angle-up"></span>',
                nextArrow: '<span class="pe-7s-angle-down"></span>',
                responsive: [
                    {
                        breakpoint: 1025,
                        settings: {
                            vertical: false,
                            slidesToShow: 3,
                            prevArrow: '<span class="pe-7s-angle-left"></span>',
                            nextArrow: '<span class="pe-7s-angle-right"></span>',
                        }
                    }
                ]
            });
        });

        $('.dots-custom').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            asNavFor: '.sm-dots-custom'
        });
        $('.sm-dots-custom').each(function () {
            var _number = $(this).data('number');
            $(this).slick({
                vertical: true,
                slidesToShow: _number,
                slidesToScroll: 1,
                asNavFor: '.dots-custom',
                prevArrow: '<span class="pe-7s-angle-up"></span>',
                nextArrow: '<span class="pe-7s-angle-down"></span>',
                focusOnSelect: true,
                responsive: [
                    {
                        breakpoint: 1025,
                        settings: {
                            vertical: false,
                            prevArrow: '<span class="pe-7s-angle-left"></span>',
                            nextArrow: '<span class="pe-7s-angle-right"></span>',
                        }
                    }
                ]
            });
        });
    }

    /* CHECK STICKY */
    function sticky_product() {
        if ( $('body.single-product .style-with-sticky').length > 0 ) {
            $('.style-with-sticky').each(function () {
                if ( smarket_fontend_global_script.smarket_enable_sticky_menu == 1 ) {
                    $(this).find('.summary').sticky({
                        topSpacing: parseInt(smarket_fontend_global_script.smarket_spacing_sticky),
                    });
                } else {
                    $(this).find('.summary').sticky({
                        topSpacing: 0,
                    });
                }

                $(window).resize($(this).find('.summary').sticky('update'));
            })
        }
    };

    //Menu Sticky
    function smarket_stick_menu() {
        if ( $('body.single-product .style-with-sticky').length > 0 ) {
            var scrollUp = 0;
            $(window).scroll(function (event) {
                var scrollTop          = $(this).scrollTop();
                var height_single_left = $('.single-left').outerHeight() - $('.summary').outerHeight();
                //Remove summary sticky
                if ( scrollTop > height_single_left / 2 ) {
                    $('.summary').addClass('remove-sticky-detail-half')
                } else {
                    $('.summary').removeClass('remove-sticky-detail-half');
                }
                if ( scrollTop > height_single_left ) {
                    $('.summary').addClass('remove-sticky-detail')
                } else {
                    $('.summary').removeClass('remove-sticky-detail');
                }

                scrollUp = scrollTop;
            })
        }
    };

    function sticky_header() {
        if ( smarket_fontend_global_script.smarket_enable_sticky_menu == 1 ) {
            if ( $('.header-sticky').length > 0 ) {
                $('.header-sticky').sticky({topSpacing: 0});
                if ( $('#menu-vertical-menu').length > 0 ) {
                    var height_sticky = $('#menu-vertical-menu').height();
                    var offset        = $('#menu-vertical-menu').offset();
                    $(window).scroll(function (event) {
                        var scroll = $(window).scrollTop();
                        if ( scroll > (height_sticky + offset.top) ) {
                            $('.header-sticky').parent().addClass('is-sticky');
                            $('.header-sticky').css('position', 'fixed');
                        } else {
                            $('.header-sticky').css('position', 'relative');
                            $('.header-sticky').parent().removeClass('is-sticky');
                        }
                    });
                }
            }
        }
    }

    $(".ms-accordion").each(function () {
        var _main = $(this);
        _main.find('.cat-parent').each(function () {
            $(this).append('<span class="carets fa fa-plus"></span>');
        });
        _main.children('.cat-parent').each(function () {

            var curent = $(this).find('.children');
            $(this).children('.carets').on('click', function () {
                $(this).parent().toggleClass('show-sub');
                $(this).parent().children('.children').slideToggle(400);
                _main.find('.children').not(curent).slideUp(400);
                _main.find('.cat-parent').not($(this).parent()).removeClass('show-sub');
            });
            var next_curent = $(this).find('.children');
            next_curent.children('.cat-parent').each(function () {
                var child_curent = $(this).find('.children');
                $(this).children('.carets').on('click', function () {
                    $(this).parent().toggleClass('show-sub');
                    $(this).parent().parent().find('.cat-parent').not($(this).parent()).removeClass('show-sub');
                    $(this).parent().parent().find('.children').not(child_curent).slideUp(400);
                    $(this).parent().children('.children').slideToggle(400);
                })
            });
        });
    });

    function smarket_click_open_compare_table() {
        $('#smarket_open_compare_table').on('click', function (e) {
            e.preventDefault();
            $('body').trigger('yith_woocompare_open_popup', {response: smarket_yith_add_query_arg('action', yith_woocompare.actionview) + '&iframe=true'});
        });
    }

    function smarket_yith_add_query_arg(key, value) {
        key   = escape(key);
        value = escape(value);

        var s   = document.location.search;
        var kvp = key + "=" + value;

        var r = new RegExp("(&|\\?)" + key + "=[^\&]*");

        s = s.replace(r, "$1" + kvp);

        if ( !RegExp.$1 ) {
            s += (s.length > 0 ? '&' : '?') + kvp;
        }
        ;

        //again, do what you will here
        return s;
    }

    function smarket_init_lazy_load() {
        if ( $("img.lazy").length > 0 ) {
            $("img.lazy").lazyload(
                {
                    effect: "fadeIn"
                }
            );
        }
    }

    function smarket_ajax_lazy_load() {
        if ( $('img.lazy').length > 0 ) {
            $('img.lazy').each(function () {
                if ( $(this).data('original') ) {
                    $(this).attr('src', $(this).data('original'));
                }
            });
        }
    }

    /* Menu mobile */
    function menu_mobile() {
        function action_addClass() {
            $('body').addClass('open-mobile-menu');
            return false;
        }

        function action_removeClass() {
            $('body').removeClass('open-mobile-menu');
            return false;
        }

        $(".mobile-navigation").click(action_addClass);
        $(".box-mobile-menu .close-menu, .body-overlay").click(action_removeClass);
    };

    /* TOGGLE MINI - CART*/
    $(document).mouseup(function (e) {
        var container = $('.mini-cart-content');
        $(document).on('click', '.cartlink', function () {
            $(this).parent().toggleClass('open');
            return false;
        });
        if ( !container.is(e.target) // if the target of the click isn't the container...
            && container.has(e.target).length === 0 ) // ... nor a descendant of the container
        {
            container.parent().removeClass('open');
        }
    });

    /* ---------------------------------------------
     Ajax Tab
     --------------------------------------------- */
    $(document).on('click', '[data-ajax="1"]', function () {
        if ( !$(this).hasClass('loaded') ) {
            var t          = $(this);
            var id         = t.data('id');
            var tab_id     = t.attr('href');
            var section_id = tab_id.replace('#', '');

            $(tab_id).closest('.tab-container').append('<div class="cssload-wapper" style="min-height: 400px;position: static"><div class="cssload-square"><div class="cssload-square-part cssload-square-green"></div><div class="cssload-square-part cssload-square-pink"></div><div class="cssload-square-blend"></div></div></div>');
            $.ajax({
                type: 'POST',
                url: smarket_ajax_frontend.ajaxurl,
                data: {
                    action: 'smarket_ajax_tabs',
                    security: smarket_ajax_frontend.security,
                    id: id,
                    section_id: section_id,
                },
                success: function (response) {
                    if ( response[ 'success' ] == 'ok' ) {
                        $(tab_id).closest('.tab-container').find('.cssload-wapper').remove();
                        $(tab_id).html($(response[ 'html' ]).find('.vc_tta-panel-body').html());
                        t.addClass('loaded');
                    }
                },
                complete: function () {
                    smarket_init_carousel();
                    smarket_ajax_lazy_load();
                    smarket_tab_fade_effect();
                }
            });
        }
    });

    function hover_product_item() {
        $(document).on('mouseenter', '.product-item.style-1', function () {
            $(this).closest('.owl-stage-outer').css({
                'padding': '10px 10px 200px',
                'margin': '-10px -10px -200px',
            });
        }).on('mouseleave', '.product-item.style-1', function () {
            $(this).closest('.owl-stage-outer').css({
                'padding': '0',
                'margin': '0',
            });
        });
    };

    // Reinit some important things after ajax
    $(document).ajaxComplete(function (event, xhr, settings) {
        smarket_init_carousel();
        smarket_tab_fade_effect();
    });

    /* ---------------------------------------------
     Scripts bind
     --------------------------------------------- */

    $(window).bind("load", function () {
        sm_masonry();
        smarket_tab_fade_effect();
    });

    /* ---------------------------------------------
     Scripts load
     --------------------------------------------- */

    $(window).load(function () {
        better_equal_elems();
        smarket_init_carousel();
        smarket_clone_main_menu();
        smarket_resizeMegamenu();
        menu_mobile();
        smarket_init_menu_reposive();
    });
    /* ---------------------------------------------
     Scripts resize
     --------------------------------------------- */
    $(window).on("resize", function () {
        smarket_clone_main_menu();
        smarket_init_menu_reposive();
        smarket_resizeMegamenu();
        smarket_init_carousel();
        smarket_auto_width_vertical_menu();
        sm_masonry();
        better_equal_elems();
        smarket_stick_menu();
    });
    /* ---------------------------------------------
     Scripts scroll
     --------------------------------------------- */
    $(window).scroll(function () {
        smarket_back_to_top();
    });

    /* ---------------------------------------------
     Scripts ready
     --------------------------------------------- */
    $(document).ready(function () {
        sticky_product();
        smarket_stick_menu();
        better_equal_elems();
        smarket_init_lazy_load();
        smarket_resizeMegamenu();
        smarket_woo_quantily();
        smarket_auto_width_vertical_menu();
        smarket_show_other_item_vertical_menu();
        smarket__countdown();
        smarket_click_open_compare_table();
        smarket_init_popup();
        smarket_google_maps();
        sticky_header();
        slick_slider();
        hover_product_item();

        $(document).on('change', '.smarket_disabled_popup_by_user', function () {
            if ( $(this).is(":checked") ) {
                setCookie("smarket_disabled_popup_by_user", 'true', 7);
            } else {
                setCookie("smarket_disabled_popup_by_user", '', 0);
            }
        });
        /*  [ All Categorie ]
         - - - - - - - - - - - - - - - - - - - - */
        $(document).on('click', '.open-cate', function () {
            $(this).closest('.block-nav-categori').find('li.link-orther').each(function () {
                $(this).slideDown();
            });
            var closetext = $(this).data('closetext');
            $(this).addClass('close-cate').removeClass('open-cate').html(closetext);
            return false;
        });

        /* Close Categorie */
        $(document).on('click', '.close-cate', function () {
            $(this).closest('.block-nav-categori').find('li.link-orther').each(function () {
                $(this).slideUp();
            });
            var alltext = $(this).data('alltext');
            $(this).addClass('open-cate').removeClass('close-cate').html(alltext);
            return false;
        });

        // $(".block-nav-categori .block-title").on('click', function () {
        //     $(this).toggleClass('active');
        //     $(this).parent().toggleClass('has-open');
        //     $("body").toggleClass("categori-open");
        // });

        $(document).ready(function(){
          $("body").addClass("categori-open");
        })

        if ( $('.categori-search-option').length > 0 ) {
            $('.categori-search-option').chosen();
        }

        /*Open search form */
        $(document).on('click', '.search-icon', function () {
            $(this).toggleClass('open');
            $(this).closest('.header').find('.block-search').toggleClass('open');
            return false;
        })

        /*Close widget */
        $(document).on('click', '.widgettitle .arow', function () {
            $(this).closest('.widget').toggleClass('widget-close');
        });

        /* Block search */
        $(document).on('click', '.search-icon-mobile', function () {
            $('#block-search-mobile').addClass('open');
            $('body').addClass('open-block-serach');
            return false;
        });

        $(document).on('click', '.close-block-serach', function () {
            $('#block-search-mobile').removeClass('open');
            $('body').removeClass('open-block-serach');
            return false;
        });

        // Scroll top
        $(document).on('click', '.scroll_top', function () {
            $('body,html').animate({scrollTop: 0}, 400);
            return false;
        });

        //BACK TO TOP
        $('a.backtotop').on('click', function () {
            $('html, body').animate({scrollTop: 0}, 800);
            return false;
        });

    });

})
(jQuery); // End of use strict
