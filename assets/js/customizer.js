

/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 */

(function($) {
    // Site title and description.
    wp.customize('blogname', function(value) {
        value.bind(function(to) {
            $('.site-title a').text(to);
        });
    });
    
    wp.customize('blogdescription', function(value) {
        value.bind(function(to) {
            $('.site-description').text(to);
        });
    });

    // Primary Color
    wp.customize('coffeeshop_primary_color', function(value) {
        value.bind(function(to) {
            $('body').get(0).style.setProperty('--primary-color', to);
        });
    });

    // Secondary Color
    wp.customize('coffeeshop_secondary_color', function(value) {
        value.bind(function(to) {
            $('body').get(0).style.setProperty('--secondary-color', to);
        });
    });

    // Accent Color
    wp.customize('coffeeshop_accent_color', function(value) {
        value.bind(function(to) {
            $('body').get(0).style.setProperty('--accent-color', to);
        });
    });

    // Hero Title
    wp.customize('coffeeshop_hero_title', function(value) {
        value.bind(function(to) {
            $('.hero-content h1').text(to);
        });
    });

    // Hero Subtitle
    wp.customize('coffeeshop_hero_subtitle', function(value) {
        value.bind(function(to) {
            $('.hero-content p').text(to);
        });
    });

    // Typography
    wp.customize('coffeeshop_heading_font', function(value) {
        value.bind(function(to) {
            $('body').get(0).style.setProperty('--font-primary', to + ', serif');
        });
    });

    wp.customize('coffeeshop_body_font', function(value) {
        value.bind(function(to) {
            $('body').get(0).style.setProperty('--font-secondary', to + ', sans-serif');
        });
    });

})(jQuery);


