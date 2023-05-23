(function($, window) {
    'use strict';
    var arrowWidth = 16;
    $.fn.resizeselect = function(settings) {
        return this.each(function() {
            $(this).change(function() {
                var $this = $(this);
                // create test element
                var text = $this.find("option:selected").text();
                var $test = $("<span>").html(text);
                // add to body, get width, and get out
                $test.appendTo('body');
                var width = $test.width();
                $test.remove();
                // set select width
                $this.width(width + arrowWidth);
                // run on start
            }).change();
        });
    };
})(jQuery, window);
(function($, window) {
    'use strict';
    $.fn.navigationResize = function() {
        var $menuContainer = $(this);
        var $navItemMore = $menuContainer.find('li.amr-flex-more-menu-item');
        var $overflowItemsContainer = $navItemMore.find('.overflow-items');
        $navItemMore.before($navItemMore.find('.overflow-items > li'));
        $navItemMore.siblings('.dropdown-submenu').removeClass('dropdown-submenu').addClass('dropdown');
        var $navItems = $navItemMore.parent().children('li:not(.amr-flex-more-menu-item)'),
            navItemMoreWidth = $navItemMore.outerWidth(),
            navItemWidth = navItemMoreWidth,
            $menuContainerWidth = $menuContainer.width() - navItemMoreWidth;
        $navItems.each(function() {
            navItemWidth += $(this).outerWidth();
        });
        if (navItemWidth > $menuContainerWidth) {
            $navItemMore.show();
            while (navItemWidth >= $menuContainerWidth) {
                navItemWidth -= $navItems.last().outerWidth();
                $navItems.last().prependTo($overflowItemsContainer);
                $navItems.splice(-1, 1);
            }
            $overflowItemsContainer.children('li.dropdown').removeClass('dropdown').addClass('dropdown-submenu');
        } else {
            $navItemMore.hide();
        }
    }
})(jQuery, window);
(function($) {
    'use strict';
    var is_rtl = $('body,html').hasClass('rtl');
    /*===================================================================================*/
    /*  Smooth scroll for wc tabs with @href started with '#' only
    /*===================================================================================*/
    $('.amr-tabs-wrapper ul.tm-tabs > li').on('click', 'a[href^="#"]', function(e) {
        // target element id
        var id = $(this).attr('href');
        // target element
        var $id = $(id);
        if ($id.length === 0) {
            return;
        }
        // prevent standard hash navigation (avoid blinking in IE)
        e.preventDefault();
        // top position relative to the document
        var pos = $id.offset().top;
        // animated top scrolling
        $('body, html').animate({
            scrollTop: pos
        });
    });
    /*===================================================================================*/
    /*  Add to Cart animation
    /*===================================================================================*/
    $('body').on('adding_to_cart', function(e, $btn, data) {
        $btn.closest('.product').block();
    });
    $('body').on('added_to_cart', function() {
        $('.product').unblock();
    });
    /*===================================================================================*/
    /*  WC Variation Availability
    /*===================================================================================*/
    $('body').on('amr_variation_has_changed', function(e) {
        var $singleVariationWrap = $('form.variations_form').find('.single_variation_wrap');
        var $availability = $singleVariationWrap.find('.amr-variation-availability').html();
        if (typeof $availability !== "undefined" && $availability !== false) {
            $('.amr-stock-availability').html($availability);
        }
    });
    /*===================================================================================*/
    /*  Product Categories Filter
    /*===================================================================================*/
    $(".section-categories-filter").each(function() {
        var $this = $(this);
        $this.find('.categories-dropdown').change(function() {
            $this.block({
                message: null
            });
            var $selectedKey = $(this).val();
            var $shortcode_atts = $this.find('.categories-filter-products').data('shortcode_atts');
            if ($selectedKey !== '' || $selectedKey !== 0 || $selectedKey !== '0') {
                $shortcode_atts['category'] = $selectedKey;
            }
            $.ajax({
                url: amr_options.ajax_url,
                type: 'post',
                data: {
                    action: 'product_categories_filter',
                    shortcode_atts: $shortcode_atts
                },
                success: function(response) {
                    $this.find('.categories-filter-products').html(response);
                    $this.find('.products > div[class*="post-"]').addClass("product");
                    $this.unblock();
                }
            });
            return false;
        });
    });
    $(window).on('resize', function() {
        if ($('[data-nav="flex-menu"]').is(':visible')) {
            $('[data-nav="flex-menu"]').each(function() {
                $(this).navigationResize();
            });
        }
    });
    $(window).on('load', function() {
        $(".section-categories-filter").each(function() {
            $(this).find('.categories-dropdown').trigger('change');
        });
        /*===================================================================================*/
        /*  Bootstrap multi level dropdown trigger
        /*===================================================================================*/
        $('li.dropdown-submenu > a[data-toggle="dropdown"]').on('click', function(event) {
            event.preventDefault();
            event.stopPropagation();
            if ($(this).closest('li.dropdown-submenu').hasClass('show')) {
                $(this).closest('li.dropdown-submenu').removeClass('show');
            } else {
                $(this).closest('li.dropdown-submenu').removeClass('show');
                $(this).closest('li.dropdown-submenu').addClass('show');
            }
        });
        $('.minicart-btn, .plus.button.detail, .minus.button.detail').on('click', function(event) {
            event.preventDefault();
            event.stopPropagation();
            $('body').addClass('show-mini-cart')
        });
        $('.close-mini-cart').on('click', function(event) {
            $('body').removeClass('show-mini-cart')
        });
    });
    $(document).ready(function() {
        $('select.resizeselect').resizeselect();
        /*===================================================================================*/
        /*  Flex Menu
        /*===================================================================================*/
        if ($('[data-nav="flex-menu"]').is(':visible')) {
            $('[data-nav="flex-menu"]').each(function() {
                $(this).navigationResize();
            });
        }
        /*===================================================================================*/
        /*  PRODUCT CATEGORIES TOGGLE
        /*===================================================================================*/
        if (is_rtl) {
            var $fa_icon_angle_right = '<i class="fa fa-angle-left"></i>';
        } else {
            var $fa_icon_angle_right = '<i class="fa fa-angle-right"></i>';
        }
        $('.product-categories .show-all-cat-dropdown').each(function() {
            if ($(this).siblings('ul').length > 0) {
                var $childIndicator = $('<span class="child-indicator">' + $fa_icon_angle_right + '</span>');
                $(this).siblings('ul').hide();
                if ($(this).siblings('ul').is(':visible')) {
                    $childIndicator.addClass('open');
                    $childIndicator.html('<i class="fa fa-angle-up"></i>');
                }
                $(this).on('click', function() {
                    $(this).siblings('ul').toggle('fast', function() {
                        if ($(this).is(':visible')) {
                            $childIndicator.addClass('open');
                            $childIndicator.html('<i class="fa fa-angle-up"></i>');
                        } else {
                            $childIndicator.removeClass('open');
                            $childIndicator.html($fa_icon_angle_right);
                        }
                    });
                    return false;
                });
                $(this).append($childIndicator);
            }
        });
        /*===================================================================================*/
        /*  Slick Carousel
        /*===================================================================================*/
        $('[data-ride="amr-slick-carousel"]').each(function() {
            var $slick_target = false;
            if ($(this).data('slick') !== 'undefined' && $(this).find($(this).data('wrap')).length > 0) {
                $slick_target = $(this).find($(this).data('wrap'));
                $slick_target.data('slick', $(this).data('slick'));
            } else if ($(this).data('slick') !== 'undefined' && $(this).is($(this).data('wrap'))) {
                $slick_target = $(this);
            }
            if ($slick_target) {
                $slick_target.slick();
            }
        });
        $(".custom-slick-pagination .slider-prev").click(function(e) {
            if ($(this).data('target') !== 'undefined') {
                e.preventDefault();
                e.stopPropagation();
                var slick_wrap_id = $(this).data('target');
                $(slick_wrap_id).slick('slickPrev');
            }
        });
        $(".custom-slick-pagination .slider-next").click(function(e) {
            if ($(this).data('target') !== 'undefined') {
                e.preventDefault();
                e.stopPropagation();
                var slick_wrap_id = $(this).data('target');
                $(slick_wrap_id).slick('slickNext');
            }
        });
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            var $target = $(e.target).attr("href");
            $($target).find('[data-ride="amr-slick-carousel"]').each(function() {
                var $slick_target = $(this).data('wrap');
                if ($($target).find($slick_target).length > 0) {
                    $($target).find($slick_target).slick('setPosition');
                }
            });
        });
        $('#section-landscape-product-card-with-gallery .products').on('init', function(event, slick) {
            $(slick.$slides[0]).find(".big-image figure:eq(0)").nextAll().hide();
            $(slick.$slides[0]).find(".small-images figure").click(function(e) {
                var index = $(this).index();
                $(slick.$slides[0]).find(".big-image figure").eq(index).show().siblings().hide();
            });
        });
        $("#section-landscape-product-card-with-gallery .products").slick({
            'infinite': false,
            'slidesToShow': 1,
            'slidesToScroll': 1,
            'dots': false,
            'arrows': true,
            'prevArrow': '<a href="#"><i class="tm tm-arrow-left"></i></a>',
            'nextArrow': '<a href="#"><i class="tm tm-arrow-right"></i></a>'
        });
        $("#section-landscape-product-card-with-gallery .products").slick('setPosition');
        $('#section-landscape-product-card-with-gallery .products').on('afterChange', function(event, slick, currentSlide) {
            var current_element = $(slick.$slides[currentSlide]);
            current_element.find(".big-image figure:eq(0)").nextAll().hide();
            current_element.find(".small-images figure").click(function(e) {
                var index = $(this).index();
                current_element.find(".big-image figure").eq(index).show().siblings().hide();
            });
        });
        /*===================================================================================*/
        /*  Sticky Header
        /*===================================================================================*/
        $('.site-header .header-sticky-wrap').each(function() {
            var tm_sticky_header = new Waypoint.Sticky({
                element: $(this),
                stuckClass: 'stuck animated fadeInDown faster'
            });
        });
        /*===================================================================================*/
        /*  Departments Menu
        /*===================================================================================*/
        // Set Home Page Sidebar margin-top
        var departments_menu_height_home_v5 = $('.page-template-template-homepage-v5 .departments-menu > ul.dropdown-menu').height(),
            departments_menu_height_home_v6 = $('.page-template-template-homepage-v6 .departments-menu > ul.dropdown-menu').height();
        $('.page-template-template-homepage-v5 #secondary').css('margin-top', departments_menu_height_home_v5 + 35);
        $('.page-template-template-homepage-v6 #secondary').css('margin-top', departments_menu_height_home_v6 + 35);
        if ($(window).width() > 768) {
            // Departments Menu Height
            var $departments_menu_dropdown = $('.departments-menu-dropdown'),
                departments_menu_dropdown_height = $departments_menu_dropdown.height();
            $departments_menu_dropdown.find('.dropdown-submenu > .dropdown-menu').each(function() {
                $(this).find('.menu-item-object-static_block').css('min-height', departments_menu_dropdown_height - 4);
                $(this).css('min-height', departments_menu_dropdown_height - 4);
            });
            $('.departments-menu-dropdown').on('mouseleave', function() {
                var $this = $(this);
                $this.removeClass('animated-dropdown');
            });
            $('.departments-menu-dropdown .menu-item-has-children').on({
                mouseenter: function() {
                    var $this = $(this),
                        $dropdown_menu = $this.find('> .dropdown-menu'),
                        $departments_menu = $this.parents('.departments-menu-dropdown'),
                        css_properties = {
                            width: 540,
                            opacity: 1
                        },
                        animation_duration = 300,
                        has_changed_width = true,
                        animated_class = '',
                        $container = '';
                    if ($departments_menu.length > 0) {
                        $container = $departments_menu;
                    }
                    if ($this.hasClass('yamm-tfw')) {
                        css_properties.width = 540;
                        if ($departments_menu.length > 0) {
                            css_properties.width = 600;
                        }
                    } else if ($this.hasClass('yamm-fw')) {
                        css_properties.width = 900;
                    } else if ($this.hasClass('yamm-hw')) {
                        css_properties.width = 450;
                    } else {
                        css_properties.width = 277;
                    }
                    $dropdown_menu.css({
                        visibility: 'visible',
                        display: 'block',
                        // overflow:    'hidden'
                    });
                    if (!$container.hasClass('animated-dropdown')) {
                        $dropdown_menu.animate(css_properties, animation_duration, function() {
                            $container.addClass('animated-dropdown');
                        });
                    } else {
                        $dropdown_menu.css(css_properties);
                    }
                },
                mouseleave: function() {
                    $(this).find('> .dropdown-menu').css({
                        visibility: 'hidden',
                        opacity: 0,
                        width: 0,
                        display: 'none'
                    });
                }
            });
        }
        /*===================================================================================*/
        /*  Handheld Menu
        /*===================================================================================*/
        // Hamburger Menu Toggler
        $('.header-category-menu .main-menu-btn').on('click', function(e) {
            $('.handheld-navigation-menu').addClass("toggled");
            $('body').addClass("active-hh-menu");
            e.stopPropagation()
        });
        // Hamburger Menu Close Trigger
        $('.iconhm-close').on('click', function() {
            $('.handheld-navigation-menu').removeClass("toggled");
            $('body').removeClass("active-hh-menu");
        });
        $(document).on("click", function(e) {
            if ($(e.target).is(".handheld-navigation-menu-inner") === false) {
                $('.handheld-navigation-menu').removeClass("toggled");
            }
        });
        // Search focus Trigger
        $('.handheld-header .site-search .search-field').focus(function() {
            $(this).closest('.site-search').addClass('active');
        }).blur(function() {
            $(this).closest('.site-search').removeClass('active');
        });
        /*===================================================================================*/
        /*  Handheld Sidebar
        /*===================================================================================*/
        // Hamburger Sidebar Toggler
        $('.handheld-sidebar-toggle .sidebar-toggler').on('click', function() {
            $(this).closest('.site-content').toggleClass("active-hh-sidebar");
        });
        // Hamburger Sidebar Close Trigger
        $('.tmhh-sidebar-close').on('click', function() {
            $(this).closest('.site-content').toggleClass("active-hh-sidebar");
        });
        // Hamburger Sidebar Close Trigger when click outside menu slide
        $(document).on("click", function(event) {
            if ($('.site-content').hasClass('active-hh-sidebar')) {
                if (!$('.handheld-sidebar-toggle').is(event.target) && 0 === $('.handheld-sidebar-toggle').has(event.target).length && !$('#secondary').is(event.target) && 0 === $('#secondary').has(event.target).length) {
                    $('.site-content').toggleClass("active-hh-sidebar");
                }
            }
        });
        /*===================================================================================*/
        /*  Products LIVE Search
        /*===================================================================================*/
    });
    /*===================================================================================*/
    /*  Price Filter
    /*===================================================================================*/
    $(function() {
        $("#slider-range").slider({
            range: true,
            min: 0,
            max: 500,
            values: [0, 500],
            slide: function(event, ui) {
                $("#amount").val(ui.values[0] + " - " + ui.values[1]);
            }
        });
        $("#amount").val($("#slider-range").slider("values", 0) + " - " + $("#slider-range").slider("values", 1));
    });
    $(document).ready(function() {
        $('.maxlist-more ul').hideMaxListItems({
            'max': 5,
            'speed': 500,
            'moreText': '+ Show more',
            'lessText': '- Show less',
            'moreHTML': '<p class="maxlist-more"><a href="#"></a></p>'
        });
        $('.home-slider').on('init', function(event, slick) {
            $('.slick-active .caption .pre-title').removeClass('hidden');
            $('.slick-active .caption .pre-title').addClass('animated slideInRight');
            $('.slick-active .caption .title').removeClass('hidden');
            $('.slick-active .caption .title').addClass('animated slideInRight');
            $('.slick-active .caption .sub-title').removeClass('hidden');
            $('.slick-active .caption .sub-title').addClass('animated slideInRight');
            $('.slick-active .caption .button').removeClass('hidden');
            $('.slick-active .caption .button').addClass('animated slideInDown');
            $('.slick-active .caption .offer-price').removeClass('hidden');
            $('.slick-active .caption .offer-price').addClass('animated fadeInLeft');
            $('.slick-active .caption .sale-price').removeClass('hidden');
            $('.slick-active .caption .sale-price').addClass('animated fadeInRight');
            $('.slick-active .caption .bottom-caption').removeClass('hidden');
            $('.slick-active .caption .bottom-caption').addClass('animated slideInDown');
        });
        $('.home-slider').slick({
            dots: true,
            infinite: true,
            speed: 300,
            slidesToShow: 1,
            autoplay: true,
            pauseOnHover: false,
            arrows: true,
            autoplaySpeed: 3000,
            lazyLoad: 'progressive',
            cssEase: 'linear'
        });
        $('.home-slider').on('afterChange', function(event, slick, currentSlide) {
            $('.slick-active .caption .pre-title').removeClass('hidden');
            $('.slick-active .caption .pre-title').addClass('animated slideInRight');
            $('.slick-active .caption .title').removeClass('hidden');
            $('.slick-active .caption .title').addClass('animated slideInRight');
            $('.slick-active .caption .sub-title').removeClass('hidden');
            $('.slick-active .caption .sub-title').addClass('animated slideInRight');
            $('.slick-active .caption .button').removeClass('hidden');
            $('.slick-active .caption .button').addClass('animated slideInDown');
            $('.slick-active .caption .offer-price').removeClass('hidden');
            $('.slick-active .caption .offer-price').addClass('animated fadeInLeft');
            $('.slick-active .caption .sale-price').removeClass('hidden');
            $('.slick-active .caption .sale-price').addClass('animated fadeInRight');
            $('.slick-active .caption .bottom-caption').removeClass('hidden');
            $('.slick-active .caption .bottom-caption').addClass('animated slideInDown');
        });
        $('.home-slider').on('beforeChange', function(event, slick, currentSlide) {
            $('.slick-active .caption .pre-title').removeClass('animated slideInRight');
            $('.slick-active .caption .pre-title').addClass('hidden');
            $('.slick-active .caption .title').removeClass('animated slideInRight');
            $('.slick-active .caption .title').addClass('hidden');
            $('.slick-active .caption .sub-title').removeClass('animated slideInRight');
            $('.slick-active .caption .sub-title').addClass('hidden');
            $('.slick-active .caption .button').removeClass('animated slideInDown');
            $('.slick-active .caption .button').addClass('hidden');
            $('.slick-active .caption .offer-price').removeClass('animated fadeInLeft');
            $('.slick-active .caption .offer-price').addClass('hidden');
            $('.slick-active .caption .sale-price').removeClass('animated fadeInRight');
            $('.slick-active .caption .sale-price').addClass('hidden');
            $('.slick-active .caption .bottom-caption').removeClass('animated slideInDown');
            $('.slick-active .caption .bottom-caption').addClass('hidden');
        });
    });
    jQuery('[data-fancybox="portfolioImage"]').fancybox({
        baseClass: "fancybox-custom-layout",
        infobar: false,
        touch: {
            vertical: false
        },
        buttons: ["close", "thumbs", "share"],
        animationEffect: "fade",
        transitionEffect: "fade",
        preventCaptionOverlap: false,
        idleTime: false,
        gutter: 0,
    });
    jQuery(window).scroll(function() {
        var scroll = jQuery(window).scrollTop();
        if (scroll >= 80) {
            jQuery("body").addClass("sticky-menu");
        } else {
            jQuery("body").removeClass("sticky-menu");
        }
    });
    // Off Canvas Open close
    $(".main-menu-btn a").on('click', function() {
        $("body").addClass('fix');
        $(".off-canvas-wrapper").addClass('open');
    });
    $(".btn-close-off-canvas,.off-canvas-overlay").on('click', function() {
        $("body").removeClass('fix');
        $(".off-canvas-wrapper").removeClass('open');
    });
    // offcanvas mobile menu
    var $offCanvasNav = $('.mobile-menu'),
        $offCanvasNavSubMenu = $offCanvasNav.find('.dropdown');
    /*Add Toggle Button With Off Canvas Sub Menu*/
    $offCanvasNavSubMenu.parent().prepend('<span class="menu-expand"><i></i></span>');
    /*Close Off Canvas Sub Menu*/
    $offCanvasNavSubMenu.slideUp();
    /*Category Sub Menu Toggle*/
    $offCanvasNav.on('click', 'li a, li .menu-expand', function(e) {
        var $this = $(this);
        if (($this.parent().attr('class').match(/\b(menu-item-has-children|has-children|has-sub-menu)\b/)) && ($this.attr('href') === '#' || $this.hasClass('menu-expand'))) {
            e.preventDefault();
            if ($this.siblings('ul:visible').length) {
                $this.parent('li').removeClass('active');
                $this.siblings('ul').slideUp();
            } else {
                $this.parent('li').addClass('active');
                $this.closest('li').siblings('li').removeClass('active').find('li').removeClass('active');
                $this.closest('li').siblings('li').find('ul:visible').slideUp();
                $this.siblings('ul').slideDown();
            }
        }
    });
    jQuery('.mobile-navigation .mobile-menu').addClass("mobile-menu-visible");
    jQuery('.mobile-navigation .sub-categories-div ul li:has(ul.child-categories li)').addClass('has-child');
    jQuery(".mobile-menu li.mobile-menu-main-category-link a").click(function() {
        setTimeout(function() {
            jQuery('.mobile-navigation .mobile-menu').removeClass("mobile-menu-visible");
        }, 250);
        jQuery('.mobile-navigation .mobile-menu').addClass("mobile-menu-translateX-left");
        //jQuery('.sub-categories .sub-categories-div').hide();
        var id = jQuery(this).attr('data-category');
        jQuery('#' + id).removeClass('mobile-menu-translateX-right');
        jQuery('#' + id).addClass('mobile-menu-visible mobile-menu-translateX');
    });
    jQuery(".back-menu-link").click(function() {
        jQuery(this).parent('.sub-categories-div').removeClass('mobile-menu-visible mobile-menu-translateX');
        jQuery(this).parent('.sub-categories-div').addClass('mobile-menu-translateX-right');
        jQuery('.mobile-navigation .mobile-menu').removeClass("mobile-menu-translateX-left");
        jQuery('.mobile-navigation .mobile-menu').addClass("mobile-menu-visible");
    });
    //mobile-menu-translateX-right
    jQuery(".search-input-label").click(function() {
        jQuery('.search-popup').addClass("active");
        jQuery('.product-search-field').focus();
    });
    jQuery(".search-close").click(function() {
        jQuery('.search-popup').removeClass("active");
    });
})(jQuery);
faqList = jQuery(".questions-answers li").length;
x = 5;
var total_show_faq = x;
jQuery('.questions-answers li:lt(' + x + ')').show();
jQuery('.loadMore a').click(function() {
    x = (x + 5 <= faqList) ? x + 5 : faqList;
    jQuery('.questions-answers li:lt(' + x + ')').fadeIn();
    if (faqList / x == 1) {
        $('.loadMore').hide();
    } else {
        $('.loadMore').show();
    }
});