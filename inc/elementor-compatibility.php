<?php
/**
 * Elementor Compatibility
 *
 * @package CoffeeShop
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Check if Elementor is loaded
 */
function coffeeshop_elementor_loaded() {
    return did_action('elementor/loaded');
}

/**
 * Initialize Elementor compatibility
 */
function coffeeshop_elementor_init() {
    // Add Elementor support
    add_theme_support('elementor');
    add_theme_support('elementor-pro');
    
    // Add custom breakpoints
    add_theme_support('custom-units');
    
    // Remove Elementor's default fonts
    add_filter('elementor/fonts/groups', 'coffeeshop_elementor_remove_fonts');
    
    // Register custom Elementor locations
    add_action('elementor/theme/register_locations', 'coffeeshop_register_elementor_locations');
    
    // Enqueue Elementor custom CSS
    add_action('elementor/frontend/after_enqueue_styles', 'coffeeshop_elementor_custom_css');
    
    // Add custom Elementor widgets
    add_action('elementor/widgets/widgets_registered', 'coffeeshop_register_elementor_widgets');
    
    // Add custom Elementor controls
    add_action('elementor/controls/controls_registered', 'coffeeshop_register_elementor_controls');
}

/**
 * Register Elementor theme locations
 */
function coffeeshop_register_elementor_locations($elementor_theme_manager) {
    $elementor_theme_manager->register_location('header');
    $elementor_theme_manager->register_location('footer');
    $elementor_theme_manager->register_location('single');
    $elementor_theme_manager->register_location('archive');
    $elementor_theme_manager->register_location('404');
}

/**
 * Enqueue Elementor custom CSS
 */
function coffeeshop_elementor_custom_css() {
    wp_enqueue_style(
        'coffeeshop-elementor-custom',
        get_template_directory_uri() . '/css/elementor-custom.css',
        [],
        COFFEESHOP_VERSION
    );
}

/**
 * Remove default Elementor fonts
 */
function coffeeshop_elementor_remove_fonts($font_groups) {
    unset($font_groups['googlefonts']);
    return $font_groups;
}

/**
 * Register custom Elementor widgets
 */
function coffeeshop_register_elementor_widgets() {
    require_once get_template_directory() . '/inc/elementor-widgets/coffee-menu-widget.php';
    require_once get_template_directory() . '/inc/elementor-widgets/barista-team-widget.php';
    require_once get_template_directory() . '/inc/elementor-widgets/booking-form-widget.php';
    require_once get_template_directory() . '/inc/elementor-widgets/testimonials-widget.php';
    require_once get_template_directory() . '/inc/elementor-widgets/gallery-widget.php';
    require_once get_template_directory() . '/inc/elementor-widgets/contact-info-widget.php';
    require_once get_template_directory() . '/inc/elementor-widgets/opening-hours-widget.php';
    require_once get_template_directory() . '/inc/elementor-widgets/featured-products-widget.php';
}

/**
 * Register custom Elementor controls
 */
function coffeeshop_register_elementor_controls() {
    // Register custom controls if needed
}

/**
 * Add Elementor Pro missing widgets for free version
 */
function coffeeshop_elementor_pro_features() {
    // Add theme builder support
    add_action('elementor/theme/register_locations', function($elementor_theme_manager) {
        $elementor_theme_manager->register_all_core_location();
    });
}

/**
 * Elementor Canvas template
 */
function coffeeshop_elementor_canvas_template($template) {
    if (is_page_template('elementor_canvas')) {
        $template = get_template_directory() . '/templates/elementor-canvas.php';
    }
    return $template;
}
add_filter('template_include', 'coffeeshop_elementor_canvas_template', 99);

/**
 * Add CoffeeShop category to Elementor widgets
 */
function coffeeshop_elementor_widget_categories($elements_manager) {
    $elements_manager->add_category(
        'coffeeshop',
        [
            'title' => __('CoffeeShop Elements', 'coffeeshop'),
            'icon' => 'fa fa-coffee',
        ]
    );
}
add_action('elementor/elements/categories_registered', 'coffeeshop_elementor_widget_categories');

/**
 * Initialize when Elementor is loaded
 */
if (coffeeshop_elementor_loaded()) {
    add_action('init', 'coffeeshop_elementor_init');
    add_action('init', 'coffeeshop_elementor_pro_features');
}

/**
 * Fallback for when Elementor is not installed
 */
function coffeeshop_elementor_missing_notice() {
    if (!coffeeshop_elementor_loaded() && current_user_can('install_plugins')) {
        echo '<div class="notice notice-warning">
            <p><strong>' . __('CoffeeShop Theme', 'coffeeshop') . '</strong></p>
            <p>' . __('This theme works best with Elementor. Please install and activate Elementor to unlock all features.', 'coffeeshop') . '</p>
            <p><a href="' . admin_url('plugin-install.php?s=elementor&tab=search&type=term') . '" class="button button-primary">' . __('Install Elementor', 'coffeeshop') . '</a></p>
        </div>';
    }
}
add_action('admin_notices', 'coffeeshop_elementor_missing_notice');

/**
 * Add Elementor support to custom post types
 */
function coffeeshop_elementor_cpt_support() {
    // Add Elementor support to testimonials
    add_post_type_support('testimonial', 'elementor');
    
    // Add Elementor support to team members
    add_post_type_support('team_member', 'elementor');
    
    // Add Elementor support to menu items
    add_post_type_support('menu_item', 'elementor');
}
add_action('init', 'coffeeshop_elementor_cpt_support');

/**
 * Elementor theme conditions
 */
function coffeeshop_elementor_conditions() {
    return [
        'include' => [
            [
                'type' => 'general',
                'rules' => [
                    [
                        'name' => 'general',
                        'operator' => 'is',
                        'value' => 'true'
                    ]
                ]
            ]
        ]
    ];
}

/**
 * Override Elementor page template
 */
function coffeeshop_elementor_page_template($template) {
    if (is_singular() && \Elementor\Plugin::$instance->documents->get(get_the_ID())->is_built_with_elementor()) {
        $template = get_template_directory() . '/templates/elementor-page.php';
    }
    return $template;
}
add_filter('template_include', 'coffeeshop_elementor_page_template', 99);

/**
 * Add Elementor custom CSS variables
 */
function coffeeshop_elementor_css_variables() {
    ?>
    <style>
    :root {
        --coffeeshop-primary: <?php echo get_theme_mod('coffeeshop_primary_color', '#6F4E37'); ?>;
        --coffeeshop-secondary: <?php echo get_theme_mod('coffeeshop_secondary_color', '#FFFFFF'); ?>;
        --coffeeshop-accent: <?php echo get_theme_mod('coffeeshop_accent_color', '#8B4513'); ?>;
        --coffeeshop-font-primary: '<?php echo get_theme_mod('coffeeshop_heading_font', 'Playfair Display'); ?>', serif;
        --coffeeshop-font-secondary: '<?php echo get_theme_mod('coffeeshop_body_font', 'Open Sans'); ?>', sans-serif;
    }
    </style>
    <?php
}
add_action('wp_head', 'coffeeshop_elementor_css_variables');