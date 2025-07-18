<?php
/**
 * Elementor Compatibility
 *
 * @package CoffeeShop
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit('Direct access forbidden.');
}

/**
 * Check if Elementor is active
 */
if (!defined('ELEMENTOR_VERSION')) {
    return;
}

/**
 * Add Elementor support
 */
function coffeeshop_elementor_support() {
    add_theme_support('elementor');
}
add_action('after_setup_theme', 'coffeeshop_elementor_support');

/**
 * Register Elementor locations
 */
function coffeeshop_elementor_register_locations($elementor_theme_manager) {
    $elementor_theme_manager->register_location('header');
    $elementor_theme_manager->register_location('footer');
    $elementor_theme_manager->register_location('single');
    $elementor_theme_manager->register_location('archive');
}
add_action('elementor/theme/register_locations', 'coffeeshop_elementor_register_locations');

/**
 * Elementor Pro header/footer support
 */
function coffeeshop_elementor_pro_locations() {
    if (!function_exists('elementor_theme_do_location')) {
        return;
    }

    // Replace header if Elementor template exists
    if (elementor_theme_do_location('header')) {
        remove_action('wp_head', 'wp_head');
        add_action('wp_head', function() {
            wp_head();
        });
    }

    // Replace footer if Elementor template exists
    if (elementor_theme_do_location('footer')) {
        remove_action('wp_footer', 'wp_footer');
        add_action('wp_footer', function() {
            wp_footer();
        });
    }
}
add_action('wp', 'coffeeshop_elementor_pro_locations');

/**
 * Enqueue Elementor styles
 */
function coffeeshop_elementor_styles() {
    wp_enqueue_style(
        'coffeeshop-elementor',
        get_template_directory_uri() . '/assets/css/elementor.css',
        array(),
        COFFEESHOP_VERSION
    );
}
add_action('elementor/frontend/after_enqueue_styles', 'coffeeshop_elementor_styles');

/**
 * Add custom Elementor widgets category
 */
function coffeeshop_elementor_widget_categories($elements_manager) {
    $elements_manager->add_category(
        'coffeeshop',
        array(
            'title' => esc_html__('CoffeeShop Elements', 'coffeeshop'),
            'icon' => 'fa fa-coffee',
        )
    );
}
add_action('elementor/elements/categories_registered', 'coffeeshop_elementor_widget_categories');