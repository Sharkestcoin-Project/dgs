(function ($) {
    'use strict';

    var $constrom_window = $(window);

    // Preloader Active Code
    $constrom_window.on('load', function () {
        $('#preloader').fadeOut('slow', function () {
            $(this).remove();
        });
    });



    // ::  Sticky Header

    window.onscroll = function () {
        scrollFunction();
    };

    function scrollFunction() {
        if (
            document.body.scrollTop > 50 ||
            document.documentElement.scrollTop > 50
        ) {
            $(".site-header--sticky").addClass("scrolling");
        } else {
            $(".site-header--sticky").removeClass("scrolling");
        }
        if (
            document.body.scrollTop > 700 ||
            document.documentElement.scrollTop > 700
        ) {
            $(".site-header--sticky.scrolling").addClass("reveal-header");
        } else {
            $(".site-header--sticky.scrolling").removeClass("reveal-header");
        }
    }

    // :: Animation on Scroll initializing
    if ($.fn.init) {
        AOS.init();
    }


     // :: Client Slides Active Code

     if ($.fn.owlCarousel) {
        var topsellerSlider = $('.client-slider');
        topsellerSlider.owlCarousel({
            items: 3,
            loop: true,
            autoplay: true,
            smartSpeed: 1500,
            margin: 30,
            dots: true,
            navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
            nav:true,

            responsive: {
                0: {
                    items: 1
                },
                 480: {
                    items: 1
                },
                768: {
                    items: 2
                },
                992: {
                    items: 2
                },
                1200: {
                    items: 3
                }
            }
        });
    }

      // :: Partner Slides Active Code

      if ($.fn.owlCarousel) {
        var topsellerSlider = $('.parnet-slider');
        topsellerSlider.owlCarousel({
            items: 7,
            loop: true,
            autoplay: true,
            smartSpeed: 1500,
            margin: 30,
            dots: true,
          
            nav:false,

            responsive: {
                0: {
                    items: 2
                },
                 480: {
                    items: 3
                },
                768: {
                    items: 4
                },
                992: {
                    items: 5
                },
                1200: {
                    items: 7
                }
            }
        });
    }



})(jQuery)