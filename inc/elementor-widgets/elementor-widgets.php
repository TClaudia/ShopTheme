<?php
/**
 * Register Elementor Widgets
 *
 * @package CoffeeShop
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Main Elementor Widgets Class
 */
class CoffeeShop_Elementor_Widgets {

    /**
     * Initialize the class
     */
    public function __construct() {
        add_action('elementor/widgets/widgets_registered', [$this, 'register_widgets']);
        add_action('elementor/elements/categories_registered', [$this, 'add_widget_categories']);
        add_action('elementor/frontend/after_register_scripts', [$this, 'register_widget_scripts']);
        add_action('elementor/frontend/after_register_styles', [$this, 'register_widget_styles']);
    }

    /**
     * Add widget categories
     */
    public function add_widget_categories($elements_manager) {
        $elements_manager->add_category(
            'coffeeshop',
            [
                'title' => __('CoffeeShop Elements', 'coffeeshop'),
                'icon' => 'fa fa-coffee',
            ]
        );
    }

    /**
     * Register widgets
     */
    public function register_widgets() {
        // Only load widgets if Elementor is active
        if (!did_action('elementor/loaded')) {
            return;
        }

        // Load widget files
        $this->load_widget_files();

        // Register widgets
        $this->register_widget_instances();
    }

    /**
     * Load widget files
     */
    private function load_widget_files() {
        $widget_files = [
            'coffee-menu-widget.php',
            'barista-team-widget.php',
            'booking-form-widget.php',
            'testimonials-widget.php',
            'gallery-widget.php',
            'contact-info-widget.php',
            'opening-hours-widget.php',
            'featured-products-widget.php',
        ];

        foreach ($widget_files as $file) {
            $file_path = get_template_directory() . '/inc/elementor-widgets/' . $file;
            if (file_exists($file_path)) {
                require_once $file_path;
            }
        }
    }

    /**
     * Register widget instances
     */
    private function register_widget_instances() {
        $widgets = [
            'CoffeeShop_Coffee_Menu_Widget',
            'CoffeeShop_Barista_Team_Widget',
            'CoffeeShop_Booking_Form_Widget',
            'CoffeeShop_Testimonials_Widget',
            'CoffeeShop_Gallery_Widget',
            'CoffeeShop_Contact_Info_Widget',
            'CoffeeShop_Opening_Hours_Widget',
            'CoffeeShop_Featured_Products_Widget',
        ];

        foreach ($widgets as $widget_class) {
            if (class_exists($widget_class)) {
                \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new $widget_class());
            }
        }
    }

    /**
     * Register widget scripts
     */
    public function register_widget_scripts() {
        wp_register_script(
            'coffeeshop-elementor-widgets',
            get_template_directory_uri() . '/js/elementor-widgets.js',
            ['jquery', 'elementor-frontend'],
            COFFEESHOP_VERSION,
            true
        );

        wp_localize_script(
            'coffeeshop-elementor-widgets',
            'coffeeshop_elementor_ajax',
            [
                'ajaxurl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('coffeeshop_elementor_nonce'),
            ]
        );
    }

    /**
     * Register widget styles
     */
    public function register_widget_styles() {
        wp_register_style(
            'coffeeshop-elementor-widgets',
            get_template_directory_uri() . '/css/elementor-widgets.css',
            [],
            COFFEESHOP_VERSION
        );
    }
}

// Initialize the widgets
new CoffeeShop_Elementor_Widgets();

/**
 * Handle AJAX requests for booking form
 */
function coffeeshop_elementor_booking_handler() {
    check_ajax_referer('coffeeshop_elementor_nonce', 'nonce');
    
    $booking_data = [
        'first_name' => sanitize_text_field($_POST['first_name'] ?? ''),
        'last_name' => sanitize_text_field($_POST['last_name'] ?? ''),
        'full_name' => sanitize_text_field($_POST['full_name'] ?? ''),
        'email' => sanitize_email($_POST['email'] ?? ''),
        'phone' => sanitize_text_field($_POST['phone'] ?? ''),
        'date' => sanitize_text_field($_POST['date'] ?? ''),
        'time' => sanitize_text_field($_POST['time'] ?? ''),
        'guests' => intval($_POST['guests'] ?? 1),
        'occasion' => sanitize_text_field($_POST['occasion'] ?? ''),
        'special_requests' => sanitize_textarea_field($_POST['special_requests'] ?? ''),
        'newsletter' => isset($_POST['newsletter']) ? 1 : 0,
    ];
    
    // Validate required fields
    $required_fields = ['email', 'phone', 'date', 'time', 'guests'];
    foreach ($required_fields as $field) {
        if (empty($booking_data[$field])) {
            wp_send_json_error([
                'message' => sprintf(__('Please fill in the %s field.', 'coffeeshop'), str_replace('_', ' ', $field))
            ]);
        }
    }
    
    // Validate name fields
    if (empty($booking_data['first_name']) && empty($booking_data['last_name']) && empty($booking_data['full_name'])) {
        wp_send_json_error([
            'message' => __('Please fill in the name field.', 'coffeeshop')
        ]);
    }
    
    // Validate email
    if (!is_email($booking_data['email'])) {
        wp_send_json_error([
            'message' => __('Please enter a valid email address.', 'coffeeshop')
        ]);
    }
    
    // Validate date
    if (strtotime($booking_data['date']) < strtotime('today')) {
        wp_send_json_error([
            'message' => __('Please select a future date.', 'coffeeshop')
        ]);
    }
    
    // Save booking to database
    global $wpdb;
    $table_name = $wpdb->prefix . 'coffeeshop_bookings';
    
    $result = $wpdb->insert(
        $table_name,
        [
            'first_name' => $booking_data['first_name'] ?: explode(' ', $booking_data['full_name'])[0],
            'last_name' => $booking_data['last_name'] ?: (explode(' ', $booking_data['full_name'])[1] ?? ''),
            'email' => $booking_data['email'],
            'phone' => $booking_data['phone'],
            'date' => $booking_data['date'],
            'time' => $booking_data['time'],
            'guests' => $booking_data['guests'],
            'occasion' => $booking_data['occasion'],
            'special_requests' => $booking_data['special_requests'],
            'status' => 'pending',
            'created_at' => current_time('mysql'),
        ],
        ['%s', '%s', '%s', '%s', '%s', '%s', '%d', '%s', '%s', '%s', '%s']
    );
    
    if ($result === false) {
        wp_send_json_error([
            'message' => __('Faile