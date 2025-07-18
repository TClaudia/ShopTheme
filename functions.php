<?php
/**
 * CoffeeShop Pro Theme Functions
 *
 * @package CoffeeShop
 * @version 2.1.0
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit('Direct access forbidden.');
}

// Define theme constants
define('COFFEESHOP_VERSION', '2.1.0');
define('COFFEESHOP_THEME_DIR', get_template_directory());
define('COFFEESHOP_THEME_URL', get_template_directory_uri());
define('COFFEESHOP_THEME_NAME', 'CoffeeShop Pro');

/**
 * Theme Setup
 * Required by ThemeForest
 */
function coffeeshop_setup() {
    // Make theme available for translation
    load_theme_textdomain('coffeeshop', get_template_directory() . '/languages');

    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails
    add_theme_support('post-thumbnails');

    // Enable support for HTML5 markup
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));

    // Set up the WordPress core custom background feature
    add_theme_support('custom-background', apply_filters('coffeeshop_custom_background_args', array(
        'default-color' => 'ffffff',
        'default-image' => '',
    )));

    // Add theme support for selective refresh for widgets
    add_theme_support('customize-selective-refresh-widgets');

    // Add support for core custom logo
    add_theme_support('custom-logo', array(
        'height'      => 250,
        'width'       => 250,
        'flex-width'  => true,
        'flex-height' => true,
    ));

    // Add support for custom header
    add_theme_support('custom-header', array(
        'default-image'          => '',
        'width'                  => 1920,
        'height'                 => 1080,
        'flex-height'            => true,
        'flex-width'             => true,
        'uploads'                => true,
        'random-default'         => false,
        'header-text'            => true,
        'default-text-color'     => '000',
    ));

    // WooCommerce support
    add_theme_support('woocommerce', array(
        'thumbnail_image_width' => 300,
        'gallery_thumbnail_image_width' => 100,
        'single_image_width' => 600,
        'product_grid' => array(
            'default_rows'    => 3,
            'min_rows'        => 2,
            'max_rows'        => 8,
            'default_columns' => 4,
            'min_columns'     => 2,
            'max_columns'     => 5,
        ),
    ));
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');

    // Gutenberg support
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');
    add_theme_support('editor-styles');
    add_editor_style('assets/css/editor-style.css');
    add_theme_support('responsive-embeds');

    // Elementor support
    add_theme_support('elementor');

    // Register navigation menus
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'coffeeshop'),
        'footer'  => esc_html__('Footer Menu', 'coffeeshop'),
        'mobile'  => esc_html__('Mobile Menu', 'coffeeshop'),
    ));

    // Add image sizes
    add_image_size('coffeeshop-featured', 800, 450, true);
    add_image_size('coffeeshop-gallery', 400, 400, true);
    add_image_size('coffeeshop-product', 300, 300, true);
    add_image_size('coffeeshop-blog-thumb', 300, 200, true);
    add_image_size('coffeeshop-hero', 1920, 1080, true);
}
add_action('after_setup_theme', 'coffeeshop_setup');

/**
 * Content Width
 * Required by ThemeForest
 */
function coffeeshop_content_width() {
    $GLOBALS['content_width'] = apply_filters('coffeeshop_content_width', 1200);
}
add_action('after_setup_theme', 'coffeeshop_content_width', 0);

/**
 * Enqueue Styles and Scripts
 * Required by ThemeForest
 */
function coffeeshop_scripts() {
    // Google Fonts
    wp_enqueue_style('coffeeshop-fonts', 'https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Open+Sans:wght@300;400;500;600;700&display=swap', array(), null);

    // Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0');

    // Main stylesheet
    wp_enqueue_style('coffeeshop-style', get_stylesheet_uri(), array(), COFFEESHOP_VERSION);

    // Additional CSS files
    wp_enqueue_style('coffeeshop-responsive', get_template_directory_uri() . '/assets/css/responsive.css', array('coffeeshop-style'), COFFEESHOP_VERSION);

    // JavaScript files
    wp_enqueue_script('coffeeshop-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array('jquery'), COFFEESHOP_VERSION, true);
    wp_enqueue_script('coffeeshop-custom', get_template_directory_uri() . '/assets/js/custom.js', array('jquery'), COFFEESHOP_VERSION, true);

    // Localize script for AJAX
    wp_localize_script('coffeeshop-custom', 'coffeeshop_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('coffeeshop_nonce'),
        'strings'  => array(
            'loading' => esc_html__('Loading...', 'coffeeshop'),
            'error'   => esc_html__('Error occurred. Please try again.', 'coffeeshop'),
        ),
    ));

    // Comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'coffeeshop_scripts');

/**
 * Admin Styles
 */
function coffeeshop_admin_styles() {
    wp_enqueue_style('coffeeshop-admin', get_template_directory_uri() . '/assets/css/admin.css', array(), COFFEESHOP_VERSION);
}
add_action('admin_enqueue_scripts', 'coffeeshop_admin_styles');

/**
 * Register Widget Areas
 * Required by ThemeForest
 */
function coffeeshop_widgets_init() {
    register_sidebar(array(
        'name'          => esc_html__('Primary Sidebar', 'coffeeshop'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets here to appear in your sidebar.', 'coffeeshop'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer Area 1', 'coffeeshop'),
        'id'            => 'footer-1',
        'description'   => esc_html__('Add widgets here to appear in your footer.', 'coffeeshop'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer Area 2', 'coffeeshop'),
        'id'            => 'footer-2',
        'description'   => esc_html__('Add widgets here to appear in your footer.', 'coffeeshop'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer Area 3', 'coffeeshop'),
        'id'            => 'footer-3',
        'description'   => esc_html__('Add widgets here to appear in your footer.', 'coffeeshop'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer Area 4', 'coffeeshop'),
        'id'            => 'footer-4',
        'description'   => esc_html__('Add widgets here to appear in your footer.', 'coffeeshop'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));

    // WooCommerce Sidebar
    if (class_exists('WooCommerce')) {
        register_sidebar(array(
            'name'          => esc_html__('Shop Sidebar', 'coffeeshop'),
            'id'            => 'shop-sidebar',
            'description'   => esc_html__('Add widgets here to appear in WooCommerce pages.', 'coffeeshop'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ));
    }
}
add_action('widgets_init', 'coffeeshop_widgets_init');

/**
 * Custom CSS Output
 * Required for ThemeForest customization
 */
function coffeeshop_custom_css() {
    $primary_color = get_theme_mod('coffeeshop_primary_color', '#8B4513');
    $secondary_color = get_theme_mod('coffeeshop_secondary_color', '#FFFFFF');
    $accent_color = get_theme_mod('coffeeshop_accent_color', '#D2691E');
    
    $custom_css = "
    :root {
        --primary-color: {$primary_color};
        --secondary-color: {$secondary_color};
        --accent-color: {$accent_color};
    }
    ";
    
    // Additional customizer CSS
    $hero_bg = get_theme_mod('coffeeshop_hero_bg_image');
    if ($hero_bg) {
        $custom_css .= "
        .hero-section {
            background-image: linear-gradient(rgba(139, 69, 19, 0.7), rgba(139, 69, 19, 0.7)), url('{$hero_bg}');
        }
        ";
    }
    
    wp_add_inline_style('coffeeshop-style', $custom_css);
}
add_action('wp_enqueue_scripts', 'coffeeshop_custom_css');

/**
 * Theme Activation
 * Required by ThemeForest
 */
function coffeeshop_activation() {
    // Set default customizer values
    $defaults = array(
        'coffeeshop_primary_color' => '#8B4513',
        'coffeeshop_secondary_color' => '#FFFFFF',
        'coffeeshop_accent_color' => '#D2691E',
        'coffeeshop_logo_width' => 200,
        'coffeeshop_enable_breadcrumbs' => true,
        'coffeeshop_enable_scroll_top' => true,
    );
    
    foreach ($defaults as $setting => $value) {
        if (!get_theme_mod($setting)) {
            set_theme_mod($setting, $value);
        }
    }
    
    // Create sample pages
    $pages = array(
        'home' => array(
            'title' => 'Home',
            'template' => 'page-home.php'
        ),
        'menu' => array(
            'title' => 'Menu',
            'template' => 'page-menu.php'
        ),
        'about' => array(
            'title' => 'About Us',
            'template' => 'page-about.php'
        ),
        'contact' => array(
            'title' => 'Contact',
            'template' => 'page-contact.php'
        ),
    );
    
    foreach ($pages as $slug => $page_data) {
        if (!get_page_by_path($slug)) {
            $page_id = wp_insert_post(array(
                'post_title'     => $page_data['title'],
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
 * Required Plugins Notice
 * ThemeForest requirement
 */
function coffeeshop_required_plugins_notice() {
    if (!get_transient('coffeeshop_activation_notice')) {
        return;
    }
    
    $required_plugins = array(
        'woocommerce/woocommerce.php' => 'WooCommerce',
        'elementor/elementor.php' => 'Elementor',
        'contact-form-7/wp-contact-form-7.php' => 'Contact Form 7',
    );
    
    $missing_plugins = array();
    foreach ($required_plugins as $plugin_path => $plugin_name) {
        if (!is_plugin_active($plugin_path)) {
            $missing_plugins[] = $plugin_name;
        }
    }
    
    if (!empty($missing_plugins)) {
        ?>
        <div class="notice notice-warning is-dismissible">
            <p><strong><?php echo esc_html(COFFEESHOP_THEME_NAME); ?></strong></p>
            <p><?php esc_html_e('To get the full functionality of this theme, please install the following recommended plugins:', 'coffeeshop'); ?></p>
            <ul style="list-style: disc; margin-left: 20px;">
                <?php foreach ($missing_plugins as $plugin) : ?>
                    <li><?php echo esc_html($plugin); ?></li>
                <?php endforeach; ?>
            </ul>
            <p>
                <a href="<?php echo esc_url(admin_url('themes.php?page=tgmpa-install-plugins')); ?>" class="button button-primary">
                    <?php esc_html_e('Install Plugins', 'coffeeshop'); ?>
                </a>
            </p>
        </div>
        <?php
    }
    
    delete_transient('coffeeshop_activation_notice');
}
add_action('admin_notices', 'coffeeshop_required_plugins_notice');

/**
 * Security Enhancements
 * ThemeForest requirement
 */
function coffeeshop_security_headers() {
    if (!is_admin()) {
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('X-XSS-Protection: 1; mode=block');
        header('Referrer-Policy: strict-origin-when-cross-origin');
    }
}
add_action('send_headers', 'coffeeshop_security_headers');

// Remove WordPress version
remove_action('wp_head', 'wp_generator');
add_filter('the_generator', '__return_empty_string');

// Disable XML-RPC
add_filter('xmlrpc_enabled', '__return_false');

/**
 * Performance Optimizations
 * ThemeForest best practices
 */
function coffeeshop_performance_optimizations() {
    // Remove emoji scripts
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    
    // Remove unnecessary head links
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'wp_shortlink_wp_head');
}
add_action('init', 'coffeeshop_performance_optimizations');

/**
 * Defer JavaScript Loading
 */
function coffeeshop_defer_parsing_js($tag, $handle, $src) {
    if (is_admin()) return $tag;
    
    $defer_scripts = array('coffeeshop-custom', 'coffeeshop-navigation');
    
    if (in_array($handle, $defer_scripts)) {
        return str_replace(' src', ' defer src', $tag);
    }
    
    return $tag;
}
add_filter('script_loader_tag', 'coffeeshop_defer_parsing_js', 10, 3);

/**
 * Theme Support for Editor Styles
 */
add_theme_support('editor-styles');
add_editor_style('assets/css/editor-style.css');

/**
 * Add Block Editor Support
 */
function coffeeshop_block_editor_assets() {
    wp_enqueue_script(
        'coffeeshop-block-editor',
        get_template_directory_uri() . '/assets/js/block-editor.js',
        array('wp-blocks', 'wp-dom-ready', 'wp-edit-post'),
        COFFEESHOP_VERSION
    );
}
add_action('enqueue_block_editor_assets', 'coffeeshop_block_editor_assets');

/**
 * Theme Documentation Link
 * ThemeForest requirement
 */
function coffeeshop_admin_menu() {
    add_theme_page(
        esc_html__('Theme Documentation', 'coffeeshop'),
        esc_html__('Theme Help', 'coffeeshop'),
        'manage_options',
        'coffeeshop-help',
        'coffeeshop_help_page'
    );
}
add_action('admin_menu', 'coffeeshop_admin_menu');

function coffeeshop_help_page() {
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(COFFEESHOP_THEME_NAME); ?> - <?php esc_html_e('Documentation', 'coffeeshop'); ?></h1>
        <div class="card">
            <h2><?php esc_html_e('Getting Started', 'coffeeshop'); ?></h2>
            <p><?php esc_html_e('Thank you for choosing our theme! For detailed documentation, please visit:', 'coffeeshop'); ?></p>
            <p><a href="https://docs.yourwebsite.com/coffeeshop-pro" target="_blank" class="button button-primary"><?php esc_html_e('View Documentation', 'coffeeshop'); ?></a></p>
        </div>
        <div class="card">
            <h2><?php esc_html_e('Support', 'coffeeshop'); ?></h2>
            <p><?php esc_html_e('Need help? Contact our support team:', 'coffeeshop'); ?></p>
            <p><a href="https://support.yourwebsite.com" target="_blank" class="button"><?php esc_html_e('Get Support', 'coffeeshop'); ?></a></p>
        </div>
    </div>
    <?php
}

/**
 * Include Required Files
 * IMPORTANT: Include these AFTER all functions are declared
 */
require get_template_directory() . '/inc/template-functions.php';
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/customizer.php';

// WooCommerce integration
if (class_exists('WooCommerce')) {
    require get_template_directory() . '/inc/woocommerce.php';
}

// Elementor integration
if (defined('ELEMENTOR_VERSION')) {
    require get_template_directory() . '/inc/elementor.php';
}

// Admin functions
if (is_admin()) {
    require get_template_directory() . '/inc/admin.php';
}

/**
 * TGMPA Plugin Activation
 * ThemeForest requirement for bundled plugins
 */
require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';

function coffeeshop_register_required_plugins() {
    $plugins = array(
        array(
            'name'      => 'WooCommerce',
            'slug'      => 'woocommerce',
            'required'  => false,
        ),
        array(
            'name'      => 'Elementor',
            'slug'      => 'elementor',
            'required'  => false,
        ),
        array(
            'name'      => 'Contact Form 7',
            'slug'      => 'contact-form-7',
            'required'  => false,
        ),
    );

    $config = array(
        'id'           => 'coffeeshop',
        'default_path' => '',
        'menu'         => 'tgmpa-install-plugins',
        'has_notices'  => true,
        'dismissable'  => true,
        'dismiss_msg'  => '',
        'is_automatic' => false,
        'message'      => '',
    );

    tgmpa($plugins, $config);
}
add_action('tgmpa_register', 'coffeeshop_register_required_plugins');