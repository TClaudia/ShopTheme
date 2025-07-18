(function($) {
    'use strict';

    // Header scroll effect
    $(window).on('scroll', function() {
        const $header = $('.site-header');
        if ($(window).scrollTop() > 100) {
            $header.addClass('scrolled');
        } else {
            $header.removeClass('scrolled');
        }
    });

    // Mobile menu toggle
    $('.menu-toggle').on('click', function() {
        $(this).toggleClass('active');
        $('.primary-menu').toggleClass('active');
        $('body').toggleClass('menu-open');
    });

    // Back to top button
    $(window).on('scroll', function() {
        const $backToTop = $('.back-to-top');
        if ($(window).scrollTop() > 300) {
            $backToTop.addClass('visible');
        } else {
            $backToTop.removeClass('visible');
        }
    });

    $('.back-to-top').on('click', function(e) {
        e.preventDefault();
        $('html, body').animate({
            scrollTop: 0
        }, 800);
    });

    // Smooth scrolling for anchor links
    $('a[href*="#"]').on('click', function(e) {
        const target = $(this.getAttribute('href'));
        if (target.length) {
            e.preventDefault();
            $('html, body').stop().animate({
                scrollTop: target.offset().top - 80
            }, 1000);
        }
    });

})(jQuery);