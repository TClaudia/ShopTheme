<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package CoffeeShop
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit('Direct access forbidden.');
}

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
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

    // Add custom classes based on page type
    if (is_home()) {
        $classes[] = 'blog-home';
    }
    
    if (is_front_page()) {
        $classes[] = 'front-page';
    }
    
    if (is_search()) {
        $classes[] = 'search-results';
    }
    
    if (is_404()) {
        $classes[] = 'error-404';
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
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
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
 *
 * @param int $length Excerpt length.
 * @return int
 */
function coffeeshop_excerpt_length($length) {
    if (is_admin()) {
        return $length;
    }
    
    // Different excerpt lengths for different contexts
    if (is_home() || is_category() || is_tag()) {
        return get_theme_mod('coffeeshop_excerpt_length', 25);
    }
    
    if (is_search()) {
        return 15;
    }
    
    return 20;
}
add_filter('excerpt_length', 'coffeeshop_excerpt_length');

/**
 * Custom excerpt more
 *
 * @param string $more Excerpt more string.
 * @return string
 */
function coffeeshop_excerpt_more($more) {
    if (is_admin()) {
        return $more;
    }
    
    return '...';
}
add_filter('excerpt_more', 'coffeeshop_excerpt_more');

/**
 * Add custom image sizes to media library
 *
 * @param array $sizes Existing image sizes.
 * @return array
 */
function coffeeshop_custom_image_sizes($sizes) {
    return array_merge($sizes, array(
        'coffeeshop-hero' => __('Hero Image', 'coffeeshop'),
        'coffeeshop-featured' => __('Featured Image', 'coffeeshop'),
        'coffeeshop-thumb' => __('Thumbnail', 'coffeeshop'),
        'coffeeshop-gallery' => __('Gallery Image', 'coffeeshop'),
        'coffeeshop-product' => __('Product Image', 'coffeeshop'),
        'coffeeshop-blog-thumb' => __('Blog Thumbnail', 'coffeeshop'),
    ));
}
add_filter('image_size_names_choose', 'coffeeshop_custom_image_sizes');

/**
 * Modify the comments link text
 *
 * @param string $comments_link Comments link HTML.
 * @return string
 */
function coffeeshop_comments_link($comments_link) {
    $comments_link = str_replace('Leave a comment', __('Leave a Comment', 'coffeeshop'), $comments_link);
    $comments_link = str_replace('1 Comment', __('1 Comment', 'coffeeshop'), $comments_link);
    $comments_link = str_replace(' Comments', __(' Comments', 'coffeeshop'), $comments_link);
    
    return $comments_link;
}
add_filter('comments_popup_link_attributes', 'coffeeshop_comments_link');

/**
 * Filter the "read more" excerpt string link to the post.
 *
 * @param string $more_link_element Read more link element.
 * @param string $more_link_text    Read more text.
 * @return string
 */
function coffeeshop_read_more_link($more_link_element, $more_link_text) {
    $more_link_element = str_replace($more_link_text, __('Continue Reading', 'coffeeshop'), $more_link_element);
    return $more_link_element;
}
add_filter('the_content_more_link', 'coffeeshop_read_more_link', 10, 2);

/**
 * Add reading time estimation
 *
 * @param string $content Post content.
 * @return string
 */
function coffeeshop_reading_time($content) {
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200); // Average reading speed
    
    if ($reading_time == 1) {
        $timer = __('1 minute read', 'coffeeshop');
    } else {
        $timer = sprintf(__('%d minutes read', 'coffeeshop'), $reading_time);
    }
    
    return '<span class="reading-time"><i class="fas fa-clock" aria-hidden="true"></i> ' . $timer . '</span>';
}

/**
 * Get reading time for current post
 *
 * @return string
 */
function coffeeshop_get_reading_time() {
    global $post;
    
    if (!$post) {
        return '';
    }
    
    return coffeeshop_reading_time($post->post_content);
}

/**
 * Security enhancements - Remove version from scripts and styles
 *
 * @param string $src Script/style source URL.
 * @return string
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
 * Custom search form modifications
 *
 * @param string $form Search form HTML.
 * @return string
 */
function coffeeshop_search_form($form) {
    $form = '<form role="search" method="get" class="search-form" action="' . esc_url(home_url('/')) . '">
        <label>
            <span class="screen-reader-text">' . _x('Search for:', 'label', 'coffeeshop') . '</span>
            <input type="search" class="search-field" placeholder="' . esc_attr_x('Search...', 'placeholder', 'coffeeshop') . '" value="' . get_search_query() . '" name="s" />
        </label>
        <button type="submit" class="search-submit">
            <i class="fas fa-search" aria-hidden="true"></i>
            <span class="screen-reader-text">' . _x('Search', 'submit button', 'coffeeshop') . '</span>
        </button>
    </form>';
    
    return $form;
}
add_filter('get_search_form', 'coffeeshop_search_form');

/**
 * Modify tag cloud widget
 *
 * @param array $args Tag cloud arguments.
 * @return array
 */
function coffeeshop_widget_tag_cloud_args($args) {
    $args['number'] = 20;
    $args['largest'] = 1.2;
    $args['smallest'] = 0.9;
    $args['unit'] = 'em';
    
    return $args;
}
add_filter('widget_tag_cloud_args', 'coffeeshop_widget_tag_cloud_args');

/**
 * Add meta viewport for better mobile experience
 */
function coffeeshop_mobile_viewport() {
    echo '<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">';
}
add_action('wp_head', 'coffeeshop_mobile_viewport', 1);

/**
 * Add theme color for mobile browsers
 */
function coffeeshop_theme_color() {
    $primary_color = get_theme_mod('coffeeshop_primary_color', '#8B4513');
    echo '<meta name="theme-color" content="' . esc_attr($primary_color) . '">';
    echo '<meta name="msapplication-TileColor" content="' . esc_attr($primary_color) . '">';
}
add_action('wp_head', 'coffeeshop_theme_color');

/**
 * Customize login page
 */
function coffeeshop_login_logo() {
    $custom_logo_id = get_theme_mod('custom_logo');
    $logo_url = wp_get_attachment_image_url($custom_logo_id, 'full');
    
    if ($logo_url) {
        ?>
        <style type="text/css">
            #login h1 a, .login h1 a {
                background-image: url('<?php echo esc_url($logo_url); ?>');
                height: 80px;
                width: 320px;
                background-size: contain;
                background-repeat: no-repeat;
                padding-bottom: 30px;
            }
        </style>
        <?php
    }
}
add_action('login_enqueue_scripts', 'coffeeshop_login_logo');

/**
 * Change login logo URL
 *
 * @return string
 */
function coffeeshop_login_logo_url() {
    return home_url();
}
add_filter('login_headerurl', 'coffeeshop_login_logo_url');

/**
 * Change login logo title
 *
 * @return string
 */
function coffeeshop_login_logo_url_title() {
    return get_bloginfo('name');
}
add_filter('login_headertext', 'coffeeshop_login_logo_url_title');

/**
 * Filter products AJAX handler
 */
function coffeeshop_filter_products() {
    check_ajax_referer('coffeeshop_nonce', 'nonce');
    
    $categories = isset($_POST['categories']) ? array_map('sanitize_text_field', $_POST['categories']) : array();
    $min_price = isset($_POST['min_price']) ? intval($_POST['min_price']) : 0;
    $max_price = isset($_POST['max_price']) ? intval($_POST['max_price']) : 999999;
    $sort_by = isset($_POST['sort_by']) ? sanitize_text_field($_POST['sort_by']) : 'date';
    
    $args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => 12,
        'meta_query' => array(
            array(
                'key' => '_price',
                'value' => array($min_price, $max_price),
                'type' => 'NUMERIC',
                'compare' => 'BETWEEN',
            ),
        ),
    );
    
    if (!empty($categories)) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => $categories,
            ),
        );
    }
    
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
        case 'name':
            $args['orderby'] = 'title';
            $args['order'] = 'ASC';
            break;
        default:
            $args['orderby'] = 'date';
            $args['order'] = 'DESC';
    }
    
    $query = new WP_Query($args);
    
    ob_start();
    
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            wc_get_template_part('content', 'product');
        }
    } else {
        echo '<p class="no-products-found">' . esc_html__('No products found matching your criteria.', 'coffeeshop') . '</p>';
    }
    
    wp_reset_postdata();
    
    $output = ob_get_clean();
    
    wp_send_json_success($output);
}
add_action('wp_ajax_filter_products', 'coffeeshop_filter_products');
add_action('wp_ajax_nopriv_filter_products', 'coffeeshop_filter_products');

/**
 * Load more posts AJAX handler
 */
function coffeeshop_load_more_posts() {
    check_ajax_referer('coffeeshop_nonce', 'nonce');
    
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $posts_per_page = isset($_POST['posts_per_page']) ? intval($_POST['posts_per_page']) : 6;
    
    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => $posts_per_page,
        'paged' => $page,
    );
    
    $query = new WP_Query($args);
    
    ob_start();
    
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('template-parts/content', 'blog');
        }
    }
    
    wp_reset_postdata();
    
    $output = ob_get_clean();
    
    wp_send_json_success(array(
        'html' => $output,
        'has_more' => $page < $query->max_num_pages,
    ));
}
add_action('wp_ajax_load_more_posts', 'coffeeshop_load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'coffeeshop_load_more_posts');

/**
 * Add schema markup for organization
 */
function coffeeshop_schema_markup() {
    if (!is_front_page()) {
        return;
    }
    
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'CafeOrCoffeeShop',
        'name' => get_bloginfo('name'),
        'description' => get_bloginfo('description'),
        'url' => home_url(),
        'telephone' => get_theme_mod('coffeeshop_phone', ''),
        'address' => array(
            '@type' => 'PostalAddress',
            'streetAddress' => get_theme_mod('coffeeshop_address', ''),
            'addressLocality' => get_theme_mod('coffeeshop_city', ''),
            'postalCode' => get_theme_mod('coffeeshop_zip', ''),
            'addressCountry' => get_theme_mod('coffeeshop_country', ''),
        ),
        'openingHours' => get_theme_mod('coffeeshop_hours', 'Mo-Su 08:00-20:00'),
        'priceRange' => get_theme_mod('coffeeshop_price_range', '$'),
    );
    
    $logo_id = get_theme_mod('custom_logo');
    if ($logo_id) {
        $logo_url = wp_get_attachment_image_url($logo_id, 'full');
        $schema['logo'] = $logo_url;
        $schema['image'] = $logo_url;
    }
    
    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
}
add_action('wp_head', 'coffeeshop_schema_markup');

/**
 * Add Open Graph meta tags
 */
function coffeeshop_open_graph() {
    if (is_single() || is_page()) {
        global $post;
        
        echo '<meta property="og:title" content="' . esc_attr(get_the_title()) . '">' . "\n";
        echo '<meta property="og:description" content="' . esc_attr(wp_strip_all_tags(get_the_excerpt())) . '">' . "\n";
        echo '<meta property="og:type" content="article">' . "\n";
        echo '<meta property="og:url" content="' . esc_url(get_permalink()) . '">' . "\n";
        echo '<meta property="og:site_name" content="' . esc_attr(get_bloginfo('name')) . '">' . "\n";
        
        if (has_post_thumbnail()) {
            $thumbnail_id = get_post_thumbnail_id();
            $thumbnail_url = wp_get_attachment_image_url($thumbnail_id, 'large');
            echo '<meta property="og:image" content="' . esc_url($thumbnail_url) . '">' . "\n";
        }
    } elseif (is_home() || is_front_page()) {
        echo '<meta property="og:title" content="' . esc_attr(get_bloginfo('name')) . '">' . "\n";
        echo '<meta property="og:description" content="' . esc_attr(get_bloginfo('description')) . '">' . "\n";
        echo '<meta property="og:type" content="website">' . "\n";
        echo '<meta property="og:url" content="' . esc_url(home_url()) . '">' . "\n";
        echo '<meta property="og:site_name" content="' . esc_attr(get_bloginfo('name')) . '">' . "\n";
        
        $logo_id = get_theme_mod('custom_logo');
        if ($logo_id) {
            $logo_url = wp_get_attachment_image_url($logo_id, 'large');
            echo '<meta property="og:image" content="' . esc_url($logo_url) . '">' . "\n";
        }
    }
}
add_action('wp_head', 'coffeeshop_open_graph');

/**
 * Add Twitter Card meta tags
 */
function coffeeshop_twitter_card() {
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    
    if (is_single() || is_page()) {
        echo '<meta name="twitter:title" content="' . esc_attr(get_the_title()) . '">' . "\n";
        echo '<meta name="twitter:description" content="' . esc_attr(wp_strip_all_tags(get_the_excerpt())) . '">' . "\n";
        
        if (has_post_thumbnail()) {
            $thumbnail_id = get_post_thumbnail_id();
            $thumbnail_url = wp_get_attachment_image_url($thumbnail_id, 'large');
            echo '<meta name="twitter:image" content="' . esc_url($thumbnail_url) . '">' . "\n";
        }
    } elseif (is_home() || is_front_page()) {
        echo '<meta name="twitter:title" content="' . esc_attr(get_bloginfo('name')) . '">' . "\n";
        echo '<meta name="twitter:description" content="' . esc_attr(get_bloginfo('description')) . '">' . "\n";
        
        $logo_id = get_theme_mod('custom_logo');
        if ($logo_id) {
            $logo_url = wp_get_attachment_image_url($logo_id, 'large');
            echo '<meta name="twitter:image" content="' . esc_url($logo_url) . '">' . "\n";
        }
    }
    
    $twitter_handle = get_theme_mod('coffeeshop_twitter_handle');
    if ($twitter_handle) {
        echo '<meta name="twitter:site" content="@' . esc_attr($twitter_handle) . '">' . "\n";
        echo '<meta name="twitter:creator" content="@' . esc_attr($twitter_handle) . '">' . "\n";
    }
}
add_action('wp_head', 'coffeeshop_twitter_card');

/**
 * Customize comment form fields
 *
 * @param array $fields Comment form fields.
 * @return array
 */
function coffeeshop_comment_form_fields($fields) {
    $commenter = wp_get_current_commenter();
    $req = get_option('require_name_email');
    $aria_req = ($req ? ' aria-required="true"' : '');
    $html_req = ($req ? ' required="required"' : '');
    
    $fields['author'] = '<div class="form-group"><label for="author">' . __('Name', 'coffeeshop') . ($req ? ' <span class="required">*</span>' : '') . '</label> ' .
                       '<input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" class="form-control"' . $aria_req . $html_req . ' /></div>';
                       
    $fields['email'] = '<div class="form-group"><label for="email">' . __('Email', 'coffeeshop') . ($req ? ' <span class="required">*</span>' : '') . '</label> ' .
                      '<input id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" class="form-control"' . $aria_req . $html_req . ' /></div>';
                      
    $fields['url'] = '<div class="form-group"><label for="url">' . __('Website', 'coffeeshop') . '</label> ' .
                    '<input id="url" name="url" type="url" value="' . esc_attr($commenter['comment_author_url']) . '" class="form-control" /></div>';
    
    return $fields;
}
add_filter('comment_form_default_fields', 'coffeeshop_comment_form_fields');

/**
 * Modify comment form
 *
 * @param array $args Comment form arguments.
 * @return array
 */
function coffeeshop_comment_form($args) {
    $args['comment_field'] = '<div class="form-group"><label for="comment">' . _x('Comment', 'noun', 'coffeeshop') . ' <span class="required">*</span></label> <textarea id="comment" name="comment" class="form-control" rows="6" aria-required="true" required="required"></textarea></div>';
    
    $args['class_submit'] = 'btn btn-primary';
    $args['submit_button'] = '<button name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s">%4$s</button>';
    $args['title_reply'] = __('Leave a Comment', 'coffeeshop');
    $args['title_reply_to'] = __('Leave a Reply to %s', 'coffeeshop');
    $args['cancel_reply_link'] = __('Cancel Reply', 'coffeeshop');
    $args['label_submit'] = __('Post Comment', 'coffeeshop');
    
    return $args;
}
add_filter('comment_form_defaults', 'coffeeshop_comment_form');