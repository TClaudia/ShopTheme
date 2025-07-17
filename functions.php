<?php
/**
 * Theme Name: CoffeeShop Pro
 * Description: Modern, professional WordPress theme for coffee shops with Elementor integration and drag-and-drop customization
 * Version: 2.0.0
 * Author: Your Name
 * License: GPL v2 or later
 * Text Domain: coffeeshop
 * Domain Path: /languages
 * 
 * WC requires at least: 3.0
 * WC tested up to: 8.0
 * Elementor tested up to: 3.15.0
 * 
 * @package CoffeeShop
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define theme constants
define('COFFEESHOP_VERSION', '2.0.0');
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
    
    // Add support for Elementor
    add_theme_support('elementor');
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'coffeeshop'),
        'footer'  => __('Footer Menu', 'coffeeshop'),
        'mobile'  => __('Mobile Menu', 'coffeeshop'),
    ));
    
    // Add image sizes
    add_image_size('coffeeshop-hero', 1920, 1080, true);
    add_image_size('coffeeshop-featured', 800, 600, true);
    add_image_size('coffeeshop-thumb', 400, 300, true);
    add_image_size('coffeeshop-gallery', 600, 400, true);
    add_image_size('coffeeshop-barista', 300, 300, true);
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
    // Sidebar
    register_sidebar(array(
        'name'          => __('Sidebar', 'coffeeshop'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here to appear in your sidebar.', 'coffeeshop'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
    
    // Footer widgets
    for ($i = 1; $i <= 4; $i++) {
        register_sidebar(array(
            'name'          => sprintf(__('Footer %d', 'coffeeshop'), $i),
            'id'            => 'footer-' . $i,
            'description'   => __('Add widgets here to appear in your footer.', 'coffeeshop'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ));
    }
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
    
    // Enqueue Elementor compatibility styles
    wp_enqueue_style('coffeeshop-elementor', get_template_directory_uri() . '/css/elementor.css', array('coffeeshop-style'), COFFEESHOP_VERSION);
    
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
 * Enqueue Elementor compatibility
 */
function coffeeshop_elementor_scripts() {
    if (did_action('elementor/loaded')) {
        wp_enqueue_script('coffeeshop-elementor', get_template_directory_uri() . '/js/elementor.js', array('jquery', 'elementor-frontend'), COFFEESHOP_VERSION, true);
    }
}
add_action('wp_enqueue_scripts', 'coffeeshop_elementor_scripts');

/**
 * Include required files
 */
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/template-functions.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/elementor-compatibility.php';
require get_template_directory() . '/inc/custom-post-types.php';
require get_template_directory() . '/inc/admin.php';

// WooCommerce compatibility
if (class_exists('WooCommerce')) {
    require get_template_directory() . '/inc/woocommerce.php';
}

// Elementor compatibility
if (did_action('elementor/loaded')) {
    require get_template_directory() . '/inc/elementor-widgets.php';
}

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
 * Theme activation - Create required pages
 */
function coffeeshop_activation() {
    // Set default customizer values
    set_theme_mod('coffeeshop_primary_color', '#6F4E37');
    set_theme_mod('coffeeshop_secondary_color', '#FFFFFF');
    set_theme_mod('coffeeshop_accent_color', '#8B4513');
    
    // Create required pages
    $pages = array(
        'home' => array(
            'title' => 'Home',
            'template' => 'page-home.php'
        ),
        'about' => array(
            'title' => 'About Us',
            'template' => 'page-about.php'
        ),
        'barista' => array(
            'title' => 'Our Baristas',
            'template' => 'page-barista.php'
        ),
        'book' => array(
            'title' => 'Book a Table',
            'template' => 'page-book.php'
        ),
        'menu' => array(
            'title' => 'Menu',
            'template' => 'page-menu.php'
        ),
        'gallery' => array(
            'title' => 'Gallery',
            'template' => 'page-gallery.php'
        ),
        'faq' => array(
            'title' => 'FAQ',
            'template' => 'page-faq.php'
        ),
        'contact' => array(
            'title' => 'Contact Us',
            'template' => 'page-contact.php'
        )
    );
    
    foreach ($pages as $slug => $page_data) {
        $existing_page = get_page_by_path($slug);
        if (!$existing_page) {
            $page_id = wp_insert_post(array(
                'post_title'     => $page_data['title'],
                'post_name'      => $slug,
                'post_content'   => '',
                'post_status'    => 'publish',
                'post_type'      => 'page',
                'post_author'    => 1,
                'page_template'  => $page_data['template']
            ));
            
            // Set homepage
            if ($slug === 'home' && $page_id) {
                update_option('page_on_front', $page_id);
                update_option('show_on_front', 'page');
            }
        }
    }
    
    // Install required plugins notification
    set_transient('coffeeshop_activation_notice', true, 30);
    
    // Flush rewrite rules
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'coffeeshop_activation');

/**
 * Required plugins notice
 */
function coffeeshop_required_plugins_notice() {
    if (!get_transient('coffeeshop_activation_notice')) {
        return;
    }
    
    $required_plugins = array(
        'elementor' => 'Elementor',
        'elementskit-lite' => 'ElementsKit Lite',
        'header-footer-elementor' => 'Elementor Header & Footer Builder',
        'metform' => 'MetForm'
    );
    
    $missing_plugins = array();
    foreach ($required_plugins as $plugin_slug => $plugin_name) {
        if (!is_plugin_active($plugin_slug . '/' . $plugin_slug . '.php')) {
            $missing_plugins[] = $plugin_name;
        }
    }
    
    if (!empty($missing_plugins)) {
        ?>
        <div class="notice notice-warning is-dismissible">
            <p><strong><?php _e('CoffeeShop Pro Theme', 'coffeeshop'); ?></strong></p>
            <p><?php _e('To get the full functionality of this theme, please install the following plugins:', 'coffeeshop'); ?></p>
            <ul>
                <?php foreach ($missing_plugins as $plugin) : ?>
                    <li>• <?php echo esc_html($plugin); ?></li>
                <?php endforeach; ?>
            </ul>
            <p>
                <a href="<?php echo admin_url('themes.php?page=coffeeshop-plugins'); ?>" class="button button-primary">
                    <?php _e('Install Plugins', 'coffeeshop'); ?>
                </a>
            </p>
        </div>
        <?php
    }
    
    delete_transient('coffeeshop_activation_notice');
}
add_action('admin_notices', 'coffeeshop_required_plugins_notice');

/**
 * Create database tables on theme activation
 */
function coffeeshop_create_tables() {
    global $wpdb;
    
    $charset_collate = $wpdb->get_charset_collate();
    
    // Bookings table
    $bookings_table = $wpdb->prefix . 'coffeeshop_bookings';
    
    $bookings_sql = "CREATE TABLE $bookings_table (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        first_name tinytext NOT NULL,
        last_name tinytext NOT NULL,
        email varchar(100) NOT NULL,
        phone varchar(20) NOT NULL,
        date date NOT NULL,
        time time NOT NULL,
        guests int(2) NOT NULL,
        occasion varchar(50),
        special_requests text,
        status varchar(20) DEFAULT 'pending',
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) $charset_collate;";
    
    // Contacts table
    $contacts_table = $wpdb->prefix . 'coffeeshop_contacts';
    
    $contacts_sql = "CREATE TABLE $contacts_table (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name tinytext NOT NULL,
        email varchar(100) NOT NULL,
        phone varchar(20),
        subject varchar(200) NOT NULL,
        message text NOT NULL,
        status varchar(20) DEFAULT 'new',
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) $charset_collate;";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($bookings_sql);
    dbDelta($contacts_sql);
}
add_action('after_switch_theme', 'coffeeshop_create_tables');