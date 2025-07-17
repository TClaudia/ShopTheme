<?php
/**
 * Theme Name: CoffeeShop
 * Description: Modern, elegant WooCommerce theme for coffee shops and online coffee stores
 * Version: 1.0.0
 * Author: Your Name
 * License: GPL v2 or later
 * Text Domain: coffeeshop
 * Domain Path: /languages
 * 
 * WC requires at least: 3.0
 * WC tested up to: 8.0
 * 
 * @package CoffeeShop
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define theme constants
define('COFFEESHOP_VERSION', '1.0.0');
define('COFFEESHOP_THEME_DIR', get_template_directory());
define('COFFEESHOP_THEME_URL', get_template_directory_uri());

/**
 * Theme setup
 */
function coffeeshop_setup() {
    // Load text domain
    load_theme_textdomain('coffeeshop', get_template_directory() . '/languages');
    
    // Add default posts and comments RSS feed links
    add_theme_support('automatic-feed-links');
    
    // Enable support for Post Thumbnails
    add_theme_support('post-thumbnails');
    
    // Enable support for HTML5 markup
    add_theme_support('html5', array(
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
        'navigation-widgets',
    ));
    
    // Add support for core custom logo
    add_theme_support('custom-logo', array(
        'height'      => 60,
        'width'       => 200,
        'flex-width'  => true,
        'flex-height' => true,
    ));
    
    // Add support for selective refresh for widgets
    add_theme_support('customize-selective-refresh-widgets');
    
    // Add support for responsive embeds
    add_theme_support('responsive-embeds');
    
    // Add support for editor styles
    add_theme_support('editor-styles');
    
    // Add support for WooCommerce
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'coffeeshop'),
        'footer'  => __('Footer Menu', 'coffeeshop'),
    ));
    
    // Add image sizes
    add_image_size('coffeeshop-featured', 800, 600, true);
    add_image_size('coffeeshop-thumb', 400, 300, true);
}
add_action('after_setup_theme', 'coffeeshop_setup');

/**
 * Set content width
 */
function coffeeshop_content_width() {
    $GLOBALS['content_width'] = apply_filters('coffeeshop_content_width', 1200);
}
add_action('after_setup_theme', 'coffeeshop_content_width', 0);

/**
 * Register widget areas
 */
function coffeeshop_widgets_init() {
    register_sidebar(array(
        'name'          => __('Sidebar', 'coffeeshop'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here to appear in your sidebar.', 'coffeeshop'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
    
    register_sidebar(array(
        'name'          => __('Footer 1', 'coffeeshop'),
        'id'            => 'footer-1',
        'description'   => __('Add widgets here to appear in your footer.', 'coffeeshop'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
    
    register_sidebar(array(
        'name'          => __('Footer 2', 'coffeeshop'),
        'id'            => 'footer-2',
        'description'   => __('Add widgets here to appear in your footer.', 'coffeeshop'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
    
    register_sidebar(array(
        'name'          => __('Footer 3', 'coffeeshop'),
        'id'            => 'footer-3',
        'description'   => __('Add widgets here to appear in your footer.', 'coffeeshop'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'coffeeshop_widgets_init');

/**
 * Enqueue scripts and styles
 */
function coffeeshop_scripts() {
    // Enqueue Google Fonts
    wp_enqueue_style('coffeeshop-fonts', 'https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Open+Sans:wght@300;400;600;700&display=swap', array(), null);
    
    // Enqueue main stylesheet
    wp_enqueue_style('coffeeshop-style', get_stylesheet_uri(), array(), COFFEESHOP_VERSION);
    
    // Enqueue theme scripts
    wp_enqueue_script('coffeeshop-main', get_template_directory_uri() . '/js/main.js', array('jquery'), COFFEESHOP_VERSION, true);
    
    // Enqueue comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
    
    // Localize script for AJAX
    wp_localize_script('coffeeshop-main', 'coffeeshop_ajax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('coffeeshop_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'coffeeshop_scripts');

/**
 * Custom template tags
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * WooCommerce compatibility
 */
if (class_exists('WooCommerce')) {
    require get_template_directory() . '/inc/woocommerce.php';
}

/**
 * Custom post types and fields
 */
require get_template_directory() . '/inc/custom-post-types.php';

/**
 * Admin functions
 */
require get_template_directory() . '/inc/admin.php';

/**
 * Custom CSS output
 */
function coffeeshop_custom_css() {
    $primary_color = get_theme_mod('coffeeshop_primary_color', '#6F4E37');
    $secondary_color = get_theme_mod('coffeeshop_secondary_color', '#FFFFFF');
    $accent_color = get_theme_mod('coffeeshop_accent_color', '#8B4513');
    
    $custom_css = "
    :root {
        --primary-color: {$primary_color};
        --secondary-color: {$secondary_color};
        --accent-color: {$accent_color};
    }
    ";
    
    wp_add_inline_style('coffeeshop-style', $custom_css);
}
add_action('wp_enqueue_scripts', 'coffeeshop_custom_css');

/**
 * Theme activation
 */
function coffeeshop_activation() {
    // Set default customizer values
    set_theme_mod('coffeeshop_primary_color', '#6F4E37');
    set_theme_mod('coffeeshop_secondary_color', '#FFFFFF');
    set_theme_mod('coffeeshop_accent_color', '#8B4513');
    
    // Create homepage if it doesn't exist
    if (!get_option('page_on_front')) {
        $homepage = wp_insert_post(array(
            'post_title'     => 'Home',
            'post_content'   => '',
            'post_status'    => 'publish',
            'post_type'      => 'page',
            'post_author'    => 1,
            'page_template'  => 'page-home.php'
        ));
        
        if ($homepage) {
            update_option('page_on_front', $homepage);
            update_option('show_on_front', 'page');
        }
    }
    
    // Flush rewrite rules
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'coffeeshop_activation');
