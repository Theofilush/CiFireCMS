(function ($) {
    $(document).on('ready', function () {
        "use strict";
        /* Preload */
        $('#page-loader').delay(100).fadeOut(200, function () {
            $('body').fadeIn();
        });

        /* Tooltip */
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        })



        /* Menu */
        $('.menu-icon-mobile').on('click', function () {
            $('body').toggleClass("open-menu-mobile");
        });
        $('.menu-icon').on('click', function () {
            $('body').toggleClass("open-menu");
            setTimeout(scrollToTop, 0);
        });
        $('.menu-res li.menu-item-has-children').on('click', function (event) {
            event.stopPropagation();
            var submenu = $(this).find(" > ul");
            if ($(submenu).is(":visible")) {
                $(submenu).slideUp();
                $(this).removeClass("open-submenu-active");
            }
            else {
                $(submenu).slideDown();
                $(this).addClass("open-submenu-active");
            }
        });

        /* Back To Top */
        $(window).on('scroll', function () {
            if ($(this).scrollTop() >= 200) {
                $('.totop').addClass("show");
            } else {
                $('.totop').removeClass("show");
            }
        });
        $('.totop').on('click', function () {
            $("html, body").animate({ scrollTop: 0 }, 500);
        });

        /* Search Box */
        var header_right = $('.header-right');
        $('.search-icon').on('click', function () {
            if ($(header_right).hasClass("show-search")) {
                $(header_right).removeClass("show-search");
            }
            else {
                $(header_right).addClass("show-search");
            }
        });

        var mobile_bar = $('.mobile-bar');
        $('.search-icon-mobile').on('click', function () {
            if ($(mobile_bar).hasClass("show-search-mobile")) {
                $(mobile_bar).removeClass("show-search-mobile");
            }
            else {
                $(mobile_bar).addClass("show-search-mobile");
                setTimeout(function () { $('.txt-search').focus(); }, 300);
            }
        });

        /* review slider */
        var owl_breaking=$('.owl-breaking')
        $(owl_breaking).owlCarousel({
            loop: true,
            margin: 0,
            nav: false,
            autoplay: true,
            autoplayTimeout: 5000,
            items: 1,
        });

        /* top-review slider */
        var owl_top_review = $('.owl-top-review')
        $(owl_top_review).owlCarousel({
            loop: true,
            margin: 0,
            nav: false,
            autoplay: false,
            autoplayTimeout: 4000,
            items: 1
        });

        /* owl-special */
        var owl_special = $('.owl-special')
        $(owl_special).owlCarousel({
            loop: true,
            margin: 0,
            nav: false,
            autoplay: false,
            autoplayTimeout: 4000,
            items: 1
        });

        var owl_headlines = $('.owl-headlines')
        $(owl_headlines).owlCarousel({
            loop: true,
            margin: 0,
            nav: false,
            autoplay: true,
            autoplayTimeout: 4000,
            items: 1,
            navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"]
        });

        /* Grid pinterest style */
        var grid = $('.grid');
        if ($(grid).length) {
            $(grid).isotope({
                itemSelector: '.grid-item',
            });
        }

        /* Gallery fancybox */
        var fancybox = $('.fancybox');
        if ($(fancybox).length) {
            $(fancybox).fancybox({
                scrolling: true
            });
        }
    });
})(jQuery);

