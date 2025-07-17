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
            'message' => __('Failed to save booking. Please try again.', 'coffeeshop')
        ]);
    }
    
    // Add to newsletter if requested
    if ($booking_data['newsletter']) {
        $subscribers = get_option('coffeeshop_newsletter_subscribers', []);
        if (!in_array($booking_data['email'], $subscribers)) {
            $subscribers[] = $booking_data['email'];
            update_option('coffeeshop_newsletter_subscribers', $subscribers);
        }
    }
    
    // Send confirmation email (you can implement this)
    // coffeeshop_send_booking_confirmation($booking_data);
    
    wp_send_json_success([
        'message' => __('Your table has been booked successfully! We will contact you shortly to confirm.', 'coffeeshop')
    ]);
}
add_action('wp_ajax_coffeeshop_elementor_booking', 'coffeeshop_elementor_booking_handler');
add_action('wp_ajax_nopriv_coffeeshop_elementor_booking', 'coffeeshop_elementor_booking_handler');

/**
 * Handle AJAX requests for contact form
 */
function coffeeshop_elementor_contact_handler() {
    check_ajax_referer('coffeeshop_elementor_nonce', 'nonce');
    
    $contact_data = [
        'name' => sanitize_text_field($_POST['name'] ?? ''),
        'email' => sanitize_email($_POST['email'] ?? ''),
        'phone' => sanitize_text_field($_POST['phone'] ?? ''),
        'subject' => sanitize_text_field($_POST['subject'] ?? ''),
        'message' => sanitize_textarea_field($_POST['message'] ?? ''),
    ];
    
    // Validate required fields
    $required_fields = ['name', 'email', 'subject', 'message'];
    foreach ($required_fields as $field) {
        if (empty($contact_data[$field])) {
            wp_send_json_error([
                'message' => sprintf(__('Please fill in the %s field.', 'coffeeshop'), str_replace('_', ' ', $field))
            ]);
        }
    }
    
    // Validate email
    if (!is_email($contact_data['email'])) {
        wp_send_json_error([
            'message' => __('Please enter a valid email address.', 'coffeeshop')
        ]);
    }
    
    // Save contact to database
    global $wpdb;
    $table_name = $wpdb->prefix . 'coffeeshop_contacts';
    
    $result = $wpdb->insert(
        $table_name,
        [
            'name' => $contact_data['name'],
            'email' => $contact_data['email'],
            'phone' => $contact_data['phone'],
            'subject' => $contact_data['subject'],
            'message' => $contact_data['message'],
            'status' => 'new',
            'created_at' => current_time('mysql'),
        ],
        ['%s', '%s', '%s', '%s', '%s', '%s', '%s']
    );
    
    if ($result === false) {
        wp_send_json_error([
            'message' => __('Failed to send message. Please try again.', 'coffeeshop')
        ]);
    }
    
    // Send notification email to admin
    $admin_email = get_option('admin_email');
    $site_name = get_bloginfo('name');
    
    wp_mail(
        $admin_email,
        sprintf(__('[%s] New Contact Form Submission', 'coffeeshop'), $site_name),
        sprintf(
            __("New contact form submission:\n\nName: %s\nEmail: %s\nPhone: %s\nSubject: %s\nMessage: %s", 'coffeeshop'),
            $contact_data['name'],
            $contact_data['email'],
            $contact_data['phone'],
            $contact_data['subject'],
            $contact_data['message']
        ),
        ['Reply-To: ' . $contact_data['email']]
    );
    
    wp_send_json_success([
        'message' => __('Thank you for your message! We will get back to you soon.', 'coffeeshop')
    ]);
}
add_action('wp_ajax_coffeeshop_elementor_contact', 'coffeeshop_elementor_contact_handler');
add_action('wp_ajax_nopriv_coffeeshop_elementor_contact', 'coffeeshop_elementor_contact_handler');

/**
 * Handle AJAX requests for newsletter signup
 */
function coffeeshop_elementor_newsletter_handler() {
    check_ajax_referer('coffeeshop_elementor_nonce', 'nonce');
    
    $email = sanitize_email($_POST['email'] ?? '');
    
    if (empty($email)) {
        wp_send_json_error([
            'message' => __('Please enter your email address.', 'coffeeshop')
        ]);
    }
    
    if (!is_email($email)) {
        wp_send_json_error([
            'message' => __('Please enter a valid email address.', 'coffeeshop')
        ]);
    }
    
    // Get existing subscribers
    $subscribers = get_option('coffeeshop_newsletter_subscribers', []);
    
    if (in_array($email, $subscribers)) {
        wp_send_json_error([
            'message' => __('You are already subscribed to our newsletter.', 'coffeeshop')
        ]);
    }
    
    // Add to subscribers
    $subscribers[] = $email;
    update_option('coffeeshop_newsletter_subscribers', $subscribers);
    
    // Send welcome email
    $site_name = get_bloginfo('name');
    wp_mail(
        $email,
        sprintf(__('Welcome to %s Newsletter!', 'coffeeshop'), $site_name),
        sprintf(
            __("Thank you for subscribing to our newsletter!\n\nYou'll receive updates about our latest coffee offerings, special promotions, and events.\n\nBest regards,\nThe %s Team", 'coffeeshop'),
            $site_name
        )
    );
    
    wp_send_json_success([
        'message' => __('Thank you for subscribing! Check your email for confirmation.', 'coffeeshop')
    ]);
}
add_action('wp_ajax_coffeeshop_elementor_newsletter', 'coffeeshop_elementor_newsletter_handler');
add_action('wp_ajax_nopriv_coffeeshop_elementor_newsletter', 'coffeeshop_elementor_newsletter_handler');

/**
 * Enqueue scripts and styles for Elementor widgets
 */
function coffeeshop_elementor_enqueue_scripts() {
    if (\Elementor\Plugin::$instance->preview->is_preview_mode()) {
        wp_enqueue_script('coffeeshop-elementor-widgets');
        wp_enqueue_style('coffeeshop-elementor-widgets');
    }
}
add_action('elementor/frontend/after_enqueue_styles', 'coffeeshop_elementor_enqueue_scripts');

/**
 * Add Elementor support for custom post types
 */
function coffeeshop_add_elementor_support() {
    // Add Elementor support to testimonials
    add_post_type_support('testimonial', 'elementor');
    
    // Add custom locations for Elementor Pro theme builder
    if (defined('ELEMENTOR_PRO_VERSION')) {
        add_action('elementor/theme/register_locations', function($elementor_theme_manager) {
            $elementor_theme_manager->register_location('coffee_hero');
            $elementor_theme_manager->register_location('coffee_menu');
            $elementor_theme_manager->register_location('coffee_footer');
        });
    }
}
add_action('init', 'coffeeshop_add_elementor_support');

/**
 * Custom Elementor controls for CoffeeShop theme
 */
function coffeeshop_elementor_controls() {
    // Add custom controls if needed
    if (class_exists('\Elementor\Controls_Manager')) {
        // Register custom control for coffee types
        \Elementor\Plugin::$instance->controls_manager->register_control(
            'coffee_type_select',
            new \Elementor\Control_Select([
                'label' => __('Coffee Type', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'espresso' => __('Espresso', 'coffeeshop'),
                    'americano' => __('Americano', 'coffeeshop'),
                    'latte' => __('Latte', 'coffeeshop'),
                    'cappuccino' => __('Cappuccino', 'coffeeshop'),
                    'macchiato' => __('Macchiato', 'coffeeshop'),
                    'mocha' => __('Mocha', 'coffeeshop'),
                ],
                'default' => 'espresso',
            ])
        );
    }
}
add_action('elementor/controls/controls_registered', 'coffeeshop_elementor_controls');

/**
 * Add custom CSS for Elementor editor
 */
function coffeeshop_elementor_editor_css() {
    ?>
    <style>
        .elementor-panel .elementor-control-coffee_type_select .elementor-control-input-wrapper:before {
            content: '☕';
            margin-right: 5px;
        }
        
        .elementor-element.elementor-widget-coffeeshop-coffee-menu {
            border: 2px dashed #6F4E37;
        }
        
        .elementor-element.elementor-widget-coffeeshop-barista-team {
            border: 2px dashed #8B4513;
        }
        
        .elementor-widget-coffeeshop-booking-form .elementor-widget-container {
            position: relative;
        }
        
        .elementor-widget-coffeeshop-booking-form .elementor-widget-container:before {
            content: 'CoffeeShop Booking Form';
            position: absolute;
            top: -20px;
            left: 0;
            background: #6F4E37;
            color: white;
            padding: 2px 8px;
            font-size: 10px;
            border-radius: 3px;
            z-index: 1;
        }
    </style>
    <?php
}
add_action('elementor/editor/after_enqueue_styles', 'coffeeshop_elementor_editor_css');

/**
 * Register dynamic tags for Elementor Pro
 */
function coffeeshop_register_dynamic_tags($dynamic_tags) {
    if (!class_exists('\Elementor\Core\DynamicTags\Tag')) {
        return;
    }
    
    // Coffee shop business hours tag
    $dynamic_tags->register_tag('CoffeeShop_Business_Hours_Tag');
    
    // Coffee shop contact info tag
    $dynamic_tags->register_tag('CoffeeShop_Contact_Info_Tag');
}
add_action('elementor/dynamic_tags/register_tags', 'coffeeshop_register_dynamic_tags');

/**
 * Custom Elementor finder items
 */
function coffeeshop_elementor_finder_items($categories) {
    $categories['coffeeshop'] = [
        'title' => __('CoffeeShop', 'coffeeshop'),
        'dynamic' => false,
        'items' => [
            'coffee-menu' => [
                'title' => __('Coffee Menu', 'coffeeshop'),
                'url' => admin_url('edit.php?post_type=product'),
                'icon' => 'coffee',
            ],
            'bookings' => [
                'title' => __('Bookings', 'coffeeshop'),
                'url' => admin_url('admin.php?page=coffeeshop-bookings'),
                'icon' => 'calendar',
            ],
            'testimonials' => [
                'title' => __('Testimonials', 'coffeeshop'),
                'url' => admin_url('edit.php?post_type=testimonial'),
                'icon' => 'star',
            ],
        ],
    ];
    
    return $categories;
}
add_filter('elementor/finder/categories', 'coffeeshop_elementor_finder_items');

/**
 * Add CoffeeShop specific Elementor experiments
 */
function coffeeshop_elementor_experiments($experiments_manager) {
    $experiments_manager->add_feature([
        'name' => 'coffeeshop_advanced_widgets',
        'title' => __('CoffeeShop Advanced Widgets', 'coffeeshop'),
        'description' => __('Enable advanced CoffeeShop specific widgets and features.', 'coffeeshop'),
        'default' => \Elementor\Core\Experiments\Manager::STATE_ACTIVE,
    ]);
}
add_action('elementor/experiments/default-features-registered', 'coffeeshop_elementor_experiments');



/**
 * Modify Elementor widgets for CoffeeShop theme
 */
function coffeeshop_modify_elementor_widgets($widgets_manager) {
    // Remove unwanted widgets in CoffeeShop context
    $widgets_to_remove = ['video', 'audio']; // Example
    
    foreach ($widgets_to_remove as $widget_name) {
        $widgets_manager->unregister_widget_type($widget_name);
    }
}
// Uncomment if needed: add_action('elementor/widgets/widgets_registered', 'coffeeshop_modify_elementor_widgets');

/**
 * Add custom icons to Elementor
 */
function coffeeshop_elementor_icons($tabs) {
    $tabs['coffeeshop-icons'] = [
        'name' => 'coffeeshop-icons',
        'label' => __('CoffeeShop Icons', 'coffeeshop'),
        'url' => get_template_directory_uri() . '/css/coffeeshop-icons.css',
        'enqueue' => [get_template_directory_uri() . '/css/coffeeshop-icons.css'],
        'prefix' => 'cs-icon-',
        'displayPrefix' => 'cs',
        'labelIcon' => 'cs-icon-coffee',
        'ver' => COFFEESHOP_VERSION,
        'fetchJson' => get_template_directory_uri() . '/inc/coffeeshop-icons.json',
        'native' => false,
    ];
    
    return $tabs;
}
add_filter('elementor/icons_manager/additional_tabs', 'coffeeshop_elementor_icons');

