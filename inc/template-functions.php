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

    // Add class for current page template
    if (is_page_template()) {
        $template = get_page_template_slug();
        $template_class = 'page-template-' . str_replace('.php', '', str_replace('page-', '', basename($template)));
        $classes[] = sanitize_html_class($template_class);
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
        'occasion' => sanitize_text_field($form_data['occasion']),
        'special_requests' => sanitize_textarea_field($form_data['special_requests']),
        'status' => 'pending',
        'created_at' => current_time('mysql')
    );
    
    // Save to database
    global $wpdb;
    $table_name = $wpdb->prefix . 'coffeeshop_bookings';
    
    $result = $wpdb->insert(
        $table_name,
        $booking_data,
        array('%s', '%s', '%s', '%s', '%s', '%s', '%d', '%s', '%s', '%s', '%s')
    );
    
    if ($result === false) {
        wp_send_json_error(array('message' => __('Failed to save booking. Please try again.', 'coffeeshop')));
    }
    
    // Send confirmation email to customer
    $customer_subject = __('Booking Confirmation - CoffeeShop', 'coffeeshop');
    $customer_message = sprintf(
        __("Dear %s,\n\nThank you for your booking!\n\nBooking Details:\nDate: %s\nTime: %s\nGuests: %d\nOccasion: %s\n\nWe look forward to serving you!\n\nBest regards,\nCoffeeShop Team", 'coffeeshop'),
        $booking_data['first_name'] . ' ' . $booking_data['last_name'],
        date('F j, Y', strtotime($booking_data['date'])),
        date('g:i A', strtotime($booking_data['time'])),
        $booking_data['guests'],
        $booking_data['occasion'] ? $booking_data['occasion'] : __('Not specified', 'coffeeshop')
    );
    
    wp_mail($booking_data['email'], $customer_subject, $customer_message);
    
    // Send notification email to admin
    $admin_email = get_option('admin_email');
    $admin_subject = __('New Booking Received - CoffeeShop', 'coffeeshop');
    $admin_message = sprintf(
        __("A new booking has been received:\n\nCustomer: %s %s\nEmail: %s\nPhone: %s\nDate: %s\nTime: %s\nGuests: %d\nOccasion: %s\nSpecial Requests: %s\n\nPlease review and confirm the booking.", 'coffeeshop'),
        $booking_data['first_name'],
        $booking_data['last_name'],
        $booking_data['email'],
        $booking_data['phone'],
        date('F j, Y', strtotime($booking_data['date'])),
        date('g:i A', strtotime($booking_data['time'])),
        $booking_data['guests'],
        $booking_data['occasion'] ? $booking_data['occasion'] : __('Not specified', 'coffeeshop'),
        $booking_data['special_requests'] ? $booking_data['special_requests'] : __('None', 'coffeeshop')
    );
    
    wp_mail($admin_email, $admin_subject, $admin_message);
    
    wp_send_json_success(array('message' => __('Your booking has been submitted successfully! We will contact you shortly to confirm.', 'coffeeshop')));
}
add_action('wp_ajax_process_booking', 'coffeeshop_process_booking');
add_action('wp_ajax_nopriv_process_booking', 'coffeeshop_process_booking');

/**
 * Handle contact form submission
 */
function coffeeshop_process_contact() {
    check_ajax_referer('coffeeshop_nonce', 'nonce');
    
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $phone = sanitize_text_field($_POST['phone']);
    $subject = sanitize_text_field($_POST['subject']);
    $message = sanitize_textarea_field($_POST['message']);
    
    // Validate required fields
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        wp_send_json_error(array('message' => __('Please fill in all required fields.', 'coffeeshop')));
    }
    
    // Validate email
    if (!is_email($email)) {
        wp_send_json_error(array('message' => __('Please enter a valid email address.', 'coffeeshop')));
    }
    
    // Save to database
    global $wpdb;
    $table_name = $wpdb->prefix . 'coffeeshop_contacts';
    
    $contact_data = array(
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'subject' => $subject,
        'message' => $message,
        'status' => 'new',
        'created_at' => current_time('mysql')
    );
    
    $result = $wpdb->insert(
        $table_name,
        $contact_data,
        array('%s', '%s', '%s', '%s', '%s', '%s', '%s')
    );
    
    if ($result === false) {
        wp_send_json_error(array('message' => __('Failed to send message. Please try again.', 'coffeeshop')));
    }
    
    // Send email to admin
    $admin_email = get_option('admin_email');
    $email_subject = __('New Contact Form Submission - CoffeeShop', 'coffeeshop');
    $email_message = sprintf(
        __("A new contact form submission has been received:\n\nName: %s\nEmail: %s\nPhone: %s\nSubject: %s\n\nMessage:\n%s", 'coffeeshop'),
        $name,
        $email,
        $phone,
        $subject,
        $message
    );
    
    $headers = array('Reply-To: ' . $name . ' <' . $email . '>');
    wp_mail($admin_email, $email_subject, $email_message, $headers);
    
    // Send confirmation email to sender
    $confirmation_subject = __('Thank you for contacting us - CoffeeShop', 'coffeeshop');
    $confirmation_message = sprintf(
        __("Dear %s,\n\nThank you for contacting us. We have received your message and will get back to you as soon as possible.\n\nYour message:\nSubject: %s\nMessage: %s\n\nBest regards,\nCoffeeShop Team", 'coffeeshop'),
        $name,
        $subject,
        $message
    );
    
    wp_mail($email, $confirmation_subject, $confirmation_message);
    
    wp_send_json_success(array('message' => __('Thank you for your message! We will get back to you soon.', 'coffeeshop')));
}
add_action('wp_ajax_process_contact', 'coffeeshop_process_contact');
add_action('wp_ajax_nopriv_process_contact', 'coffeeshop_process_contact');

/**
 * Get opening hours for today
 */
function coffeeshop_get_opening_hours($day = null) {
    if ($day === null) {
        $day = strtolower(date('l'));
    }
    
    $hours = array(
        'monday' => array('open' => '07:00', 'close' => '20:00'),
        'tuesday' => array('open' => '07:00', 'close' => '20:00'),
        'wednesday' => array('open' => '07:00', 'close' => '20:00'),
        'thursday' => array('open' => '07:00', 'close' => '20:00'),
        'friday' => array('open' => '07:00', 'close' => '21:00'),
        'saturday' => array('open' => '08:00', 'close' => '21:00'),
        'sunday' => array('open' => '08:00', 'close' => '19:00'),
    );
    
    // Allow customization via theme options
    $custom_hours = get_theme_mod('coffeeshop_opening_hours', $hours);
    
    return isset($custom_hours[$day]) ? $custom_hours[$day] : $hours[$day];
}

/**
 * Check if shop is currently open
 */
function coffeeshop_is_open($day = null, $time = null) {
    if ($day === null) {
        $day = strtolower(date('l'));
    }
    
    if ($time === null) {
        $time = date('H:i');
    }
    
    $hours = coffeeshop_get_opening_hours($day);
    
    if (!$hours || empty($hours['open']) || empty($hours['close'])) {
        return false;
    }
    
    $current_time = strtotime($time);
    $open_time = strtotime($hours['open']);
    $close_time = strtotime($hours['close']);
    
    return ($current_time >= $open_time && $current_time <= $close_time);
}

/**
 * Add schema markup for business
 */
function coffeeshop_add_schema_markup() {
    if (!is_front_page()) {
        return;
    }
    
    $business_info = array(
        '@context' => 'https://schema.org',
        '@type' => 'CoffeeShop',
        'name' => get_bloginfo('name'),
        'description' => get_bloginfo('description'),
        'url' => home_url(),
        'telephone' => get_theme_mod('coffeeshop_phone', ''),
        'email' => get_theme_mod('coffeeshop_email', ''),
        'address' => array(
            '@type' => 'PostalAddress',
            'streetAddress' => get_theme_mod('coffeeshop_address', ''),
        ),
        'openingHours' => array(),
        'priceRange' => '$',
        'servesCuisine' => 'Coffee',
        'acceptsReservations' => true,
    );
    
    // Add opening hours
    $days = array('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday');
    foreach ($days as $day) {
        $hours = coffeeshop_get_opening_hours($day);
        if ($hours && !empty($hours['open']) && !empty($hours['close'])) {
            $business_info['openingHours'][] = ucfirst(substr($day, 0, 2)) . ' ' . $hours['open'] . '-' . $hours['close'];
        }
    }
    
    echo '<script type="application/ld+json">' . json_encode($business_info) . '</script>';
}
add_action('wp_head', 'coffeeshop_add_schema_markup');

/**
 * Custom comment callback
 */
function coffeeshop_comment_callback($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    
    switch ($comment->comment_type) {
        case 'pingback':
        case 'trackback':
            ?>
            <li class="pingback">
                <p><?php _e('Pingback:', 'coffeeshop'); ?> <?php comment_author_link(); ?> <?php edit_comment_link(__('Edit', 'coffeeshop'), '<span class="edit-link">', '</span>'); ?></p>
            </li>
            <?php
            break;
        default:
            ?>
            <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
                <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
                    <footer class="comment-meta">
                        <div class="comment-author vcard">
                            <?php if (0 != $args['avatar_size']) echo get_avatar($comment, $args['avatar_size']); ?>
                            <?php printf(__('%s <span class="says">says:</span>', 'coffeeshop'), sprintf('<cite class="fn">%s</cite>', get_comment_author_link())); ?>
                        </div>

                        <div class="comment-metadata">
                            <a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>">
                                <time datetime="<?php comment_time('c'); ?>">
                                    <?php printf(_x('%1$s at %2$s', '1: date, 2: time', 'coffeeshop'), get_comment_date(), get_comment_time()); ?>
                                </time>
                            </a>
                            <?php edit_comment_link(__('Edit', 'coffeeshop'), '<span class="edit-link">', '</span>'); ?>
                        </div>

                        <?php if ($comment->comment_approved == '0') : ?>
                            <p class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.', 'coffeeshop'); ?></p>
                        <?php endif; ?>
                    </footer>

                    <div class="comment-content">
                        <?php comment_text(); ?>
                    </div>

                    <?php
                    comment_reply_link(array_merge($args, array(
                        'add_below' => 'div-comment',
                        'depth' => $depth,
                        'max_depth' => $args['max_depth'],
                        'before' => '<div class="reply">',
                        'after' => '</div>',
                    )));
                    ?>
                </article>
            </li>
            <?php
            break;
    }
}

/**
 * Add custom fields to user profile
 */
function coffeeshop_add_user_fields($user) {
    ?>
    <h3><?php _e('Coffee Preferences', 'coffeeshop'); ?></h3>
    <table class="form-table">
        <tr>
            <th><label for="favorite_coffee"><?php _e('Favorite Coffee', 'coffeeshop'); ?></label></th>
            <td>
                <input type="text" name="favorite_coffee" id="favorite_coffee" value="<?php echo esc_attr(get_user_meta($user->ID, 'favorite_coffee', true)); ?>" class="regular-text" />
                <br /><span class="description"><?php _e('What is your favorite type of coffee?', 'coffeeshop'); ?></span>
            </td>
        </tr>
        <tr>
            <th><label for="coffee_strength"><?php _e('Preferred Strength', 'coffeeshop'); ?></label></th>
            <td>
                <select name="coffee_strength" id="coffee_strength">
                    <option value=""><?php _e('Select...', 'coffeeshop'); ?></option>
                    <option value="mild" <?php selected(get_user_meta($user->ID, 'coffee_strength', true), 'mild'); ?>><?php _e('Mild', 'coffeeshop'); ?></option>
                    <option value="medium" <?php selected(get_user_meta($user->ID, 'coffee_strength', true), 'medium'); ?>><?php _e('Medium', 'coffeeshop'); ?></option>
                    <option value="strong" <?php selected(get_user_meta($user->ID, 'coffee_strength', true), 'strong'); ?>><?php _e('Strong', 'coffeeshop'); ?></option>
                </select>
            </td>
        </tr>
    </table>
    <?php
}
add_action('show_user_profile', 'coffeeshop_add_user_fields');
add_action('edit_user_profile', 'coffeeshop_add_user_fields');

/**
 * Save custom user fields
 */
function coffeeshop_save_user_fields($user_id) {
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }
    
    if (isset($_POST['favorite_coffee'])) {
        update_user_meta($user_id, 'favorite_coffee', sanitize_text_field($_POST['favorite_coffee']));
    }
    
    if (isset($_POST['coffee_strength'])) {
        update_user_meta($user_id, 'coffee_strength', sanitize_text_field($_POST['coffee_strength']));
    }
}
add_action('personal_options_update', 'coffeeshop_save_user_fields');
add_action('edit_user_profile_update', 'coffeeshop_save_user_fields');

/**
 * Add coffee shop info to REST API
 */
function coffeeshop_add_rest_fields() {
    register_rest_field('post', 'reading_time', array(
        'get_callback' => 'coffeeshop_get_reading_time',
        'schema' => array(
            'description' => __('Estimated reading time in minutes', 'coffeeshop'),
            'type' => 'integer',
        ),
    ));
}
add_action('rest_api_init', 'coffeeshop_add_rest_fields');

/**
 * Calculate reading time for posts
 */
function coffeeshop_get_reading_time($post) {
    $content = get_post_field('post_content', $post['id']);
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200); // Average reading speed is 200 words per minute
    
    return max(1, $reading_time); // Minimum 1 minute
}

/**
 * Add reading time to posts
 */
function coffeeshop_add_reading_time() {
    if (is_single() && get_post_type() === 'post') {
        $reading_time = coffeeshop_get_reading_time(array('id' => get_the_ID()));
        echo '<span class="reading-time"><i class="fas fa-clock"></i> ' . sprintf(_n('%d minute read', '%d minutes read', $reading_time, 'coffeeshop'), $reading_time) . '</span>';
    }
}

/**
 * Security enhancements
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

/**
 * Remove WordPress version from head and feeds
 */
remove_action('wp_head', 'wp_generator');
add_filter('the_generator', '__return_empty_string');

/**
 * Disable XML-RPC
 */
add_filter('xmlrpc_enabled', '__return_false');

/**
 * Remove WordPress version from scripts and styles
 */
function coffeeshop_remove_version_scripts_styles($src) {
    if (strpos($src, 'ver=')) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
add_filter('style_loader_src', 'coffeeshop_remove_version_scripts_styles', 9999);
add_filter('script_loader_src', 'coffeeshop_remove_version_scripts_styles', 9999);

/**
 * Performance optimizations
 */
function coffeeshop_performance_optimizations() {
    // Remove emoji scripts
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    
    // Remove unnecessary head links
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'wp_shortlink_wp_head');
    
    // Remove feed links if not needed
    if (!get_theme_mod('coffeeshop_enable_feeds', true)) {
        remove_action('wp_head', 'feed_links', 2);
        remove_action('wp_head', 'feed_links_extra', 3);
    }
}
add_action('init', 'coffeeshop_performance_optimizations');

/**
 * Defer parsing of JavaScript
 */
function coffeeshop_defer_parsing_js($url) {
    if (is_admin()) return $url;
    if (FALSE === strpos($url, '.js')) return $url;
    if (strpos($url, 'jquery.js')) return $url;
    return str_replace(' src', ' defer src', $url);
}
if (get_theme_mod('coffeeshop_defer_js', false)) {
    add_filter('script_loader_tag', 'coffeeshop_defer_parsing_js', 10, 2);
}       

