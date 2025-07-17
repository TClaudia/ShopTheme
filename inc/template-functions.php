<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package CoffeeShop
 */

/**
 * Adds custom classes to the array of body classes.
 */
function coffeeshop_body_classes($classes) {
    // Adds a class of hfeed to non-singular pages.
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }

    // Adds a class of no-sidebar when there is no sidebar present.
    if (!is_active_sidebar('sidebar-1')) {
        $classes[] = 'no-sidebar';
    }

    // Add class for Elementor
    if (class_exists('\Elementor\Plugin') && \Elementor\Plugin::$instance->preview->is_preview_mode()) {
        $classes[] = 'elementor-preview';
    }
    
    // Add class for WooCommerce
    if (class_exists('WooCommerce') && (is_woocommerce() || is_cart() || is_checkout())) {
        $classes[] = 'woocommerce-active';
    }
    
    // Add class for mobile
    if (wp_is_mobile()) {
        $classes[] = 'mobile-device';
    }

    return $classes;
}
add_filter('body_class', 'coffeeshop_body_classes');

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function coffeeshop_pingback_header() {
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s">', esc_url(get_bloginfo('pingback_url')));
    }
}
add_action('wp_head', 'coffeeshop_pingback_header');

/**
 * Add preconnect for Google Fonts.
 */
function coffeeshop_resource_hints($urls, $relation_type) {
    if (wp_style_is('coffeeshop-fonts', 'queue') && 'preconnect' === $relation_type) {
        $urls[] = array(
            'href' => 'https://fonts.gstatic.com',
            'crossorigin',
        );
    }
    return $urls;
}
add_filter('wp_resource_hints', 'coffeeshop_resource_hints', 10, 2);

/**
 * Custom excerpt length
 */
function coffeeshop_excerpt_length($length) {
    if (is_admin()) {
        return $length;
    }
    
    if (is_home() || is_category() || is_tag()) {
        return 25;
    }
    
    return 20;
}
add_filter('excerpt_length', 'coffeeshop_excerpt_length');

/**
 * Custom excerpt more
 */
function coffeeshop_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'coffeeshop_excerpt_more');

/**
 * Add custom image sizes to media library
 */
function coffeeshop_custom_image_sizes($sizes) {
    return array_merge($sizes, array(
        'coffeeshop-hero' => __('Hero Image', 'coffeeshop'),
        'coffeeshop-featured' => __('Featured Image', 'coffeeshop'),
        'coffeeshop-thumb' => __('Thumbnail', 'coffeeshop'),
        'coffeeshop-gallery' => __('Gallery Image', 'coffeeshop'),
        'coffeeshop-barista' => __('Barista Photo', 'coffeeshop'),
    ));
}
add_filter('image_size_names_choose', 'coffeeshop_custom_image_sizes');

/**
 * Filter products AJAX handler
 */
function coffeeshop_filter_products() {
    check_ajax_referer('coffeeshop_nonce', 'nonce');
    
    $categories = isset($_POST['categories']) ? $_POST['categories'] : array();
    $min_price = isset($_POST['min_price']) ? intval($_POST['min_price']) : 0;
    $max_price = isset($_POST['max_price']) ? intval($_POST['max_price']) : 999999;
    $sort_by = isset($_POST['sort_by']) ? sanitize_text_field($_POST['sort_by']) : 'date';
    
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 12,
        'meta_query' => array(
            array(
                'key' => '_price',
                'value' => array($min_price, $max_price),
                'compare' => 'BETWEEN',
                'type' => 'NUMERIC'
            )
        )
    );
    
    if (!empty($categories)) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => $categories,
            )
        );
    }
    
    // Sort options
    switch ($sort_by) {
        case 'price_low':
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = '_price';
            $args['order'] = 'ASC';
            break;
        case 'price_high':
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = '_price';
            $args['order'] = 'DESC';
            break;
        case 'popularity':
            $args['meta_key'] = 'total_sales';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'DESC';
            break;
        default:
            $args['orderby'] = 'date';
            $args['order'] = 'DESC';
    }
    
    $products = new WP_Query($args);
    
    if ($products->have_posts()) {
        while ($products->have_posts()) {
            $products->the_post();
            wc_get_template_part('content', 'product');
        }
    } else {
        echo '<p>' . __('No products found.', 'coffeeshop') . '</p>';
    }
    
    wp_reset_postdata();
    wp_die();
}
add_action('wp_ajax_filter_products', 'coffeeshop_filter_products');
add_action('wp_ajax_nopriv_filter_products', 'coffeeshop_filter_products');

/**
 * Newsletter signup AJAX handler
 */
function coffeeshop_newsletter_signup() {
    check_ajax_referer('coffeeshop_nonce', 'nonce');
    
    $email = sanitize_email($_POST['email']);
    
    if (!is_email($email)) {
        wp_send_json_error(array('message' => __('Please enter a valid email address.', 'coffeeshop')));
    }
    
    // Here you would typically integrate with your newsletter service
    // For this example, we'll just save to database
    $subscribers = get_option('coffeeshop_newsletter_subscribers', array());
    
    if (in_array($email, $subscribers)) {
        wp_send_json_error(array('message' => __('You are already subscribed.', 'coffeeshop')));
    }
    
    $subscribers[] = $email;
    update_option('coffeeshop_newsletter_subscribers', $subscribers);
    
    wp_send_json_success(array('message' => __('Thank you for subscribing!', 'coffeeshop')));
}
add_action('wp_ajax_newsletter_signup', 'coffeeshop_newsletter_signup');
add_action('wp_ajax_nopriv_newsletter_signup', 'coffeeshop_newsletter_signup');

/**
 * Handle booking form submission
 */
function coffeeshop_process_booking() {
    check_ajax_referer('coffeeshop_nonce', 'nonce');
    
    parse_str($_POST['form_data'], $form_data);
    
    // Validate required fields
    $required_fields = ['first_name', 'last_name', 'email', 'phone', 'date', 'time', 'guests'];
    foreach ($required_fields as $field) {
        if (empty($form_data[$field])) {
            wp_send_json_error(array('message' => sprintf(__('Please fill in the %s field.', 'coffeeshop'), str_replace('_', ' ', $field))));
        }
    }
    
    // Validate email
    if (!is_email($form_data['email'])) {
        wp_send_json_error(array('message' => __('Please enter a valid email address.', 'coffeeshop')));
    }
    
    // Validate date (must be in the future)
    if (strtotime($form_data['date']) < strtotime('today')) {
        wp_send_json_error(array('message' => __('Please select a future date.', 'coffeeshop')));
    }
    
    // Save booking to database
    $booking_data = array(
        'first_name' => sanitize_text_field($form_data['first_name']),
        'last_name' => sanitize_text_field($form_data['last_name']),
        'email' => sanitize_email($form_data['email']),
        'phone' => sanitize_text_field($form_data['phone']),
        'date' => sanitize_text_field($form_data['date']),
        'time' => sanitize_text_field($form_data['time']),
        'guests' => intval($form_data['guests']),
        'occasion' => sanitize_text_field($form_data['occasion'