


<?php
/**
 * Custom Post Types and Taxonomies
 *
 * @package CoffeeShop
 */

/**
 * Register Testimonials Post Type
 */
function coffeeshop_register_testimonials() {
    $args = array(
        'labels' => array(
            'name' => __('Testimonials', 'coffeeshop'),
            'singular_name' => __('Testimonial', 'coffeeshop'),
            'add_new' => __('Add New', 'coffeeshop'),
            'add_new_item' => __('Add New Testimonial', 'coffeeshop'),
            'edit_item' => __('Edit Testimonial', 'coffeeshop'),
            'new_item' => __('New Testimonial', 'coffeeshop'),
            'view_item' => __('View Testimonial', 'coffeeshop'),
            'search_items' => __('Search Testimonials', 'coffeeshop'),
            'not_found' => __('No testimonials found', 'coffeeshop'),
            'not_found_in_trash' => __('No testimonials found in trash', 'coffeeshop'),
        ),
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'testimonials'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 25,
        'menu_icon' => 'dashicons-format-quote',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'show_in_rest' => true,
    );
    
    register_post_type('testimonial', $args);
}
add_action('init', 'coffeeshop_register_testimonials');

/**
 * Add custom meta boxes for testimonials
 */
function coffeeshop_add_testimonial_meta_boxes() {
    add_meta_box(
        'testimonial_details',
        __('Testimonial Details', 'coffeeshop'),
        'coffeeshop_testimonial_meta_box_callback',
        'testimonial',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'coffeeshop_add_testimonial_meta_boxes');

/**
 * Testimonial meta box callback
 */
function coffeeshop_testimonial_meta_box_callback($post) {
    wp_nonce_field('coffeeshop_testimonial_nonce', 'testimonial_nonce');
    
    $author_name = get_post_meta($post->ID, '_testimonial_author', true);
    $author_position = get_post_meta($post->ID, '_testimonial_position', true);
    $rating = get_post_meta($post->ID, '_testimonial_rating', true);
    
    ?>
    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="testimonial_author"><?php _e('Author Name', 'coffeeshop'); ?></label>
            </th>
            <td>
                <input type="text" id="testimonial_author" name="testimonial_author" value="<?php echo esc_attr($author_name); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="testimonial_position"><?php _e('Author Position', 'coffeeshop'); ?></label>
            </th>
            <td>
                <input type="text" id="testimonial_position" name="testimonial_position" value="<?php echo esc_attr($author_position); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="testimonial_rating"><?php _e('Rating', 'coffeeshop'); ?></label>
            </th>
            <td>
                <select id="testimonial_rating" name="testimonial_rating">
                    <option value=""><?php _e('Select Rating', 'coffeeshop'); ?></option>
                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                        <option value="<?php echo $i; ?>" <?php selected($rating, $i); ?>><?php echo $i; ?> <?php _e('Stars', 'coffeeshop'); ?></option>
                    <?php endfor; ?>
                </select>
            </td>
        </tr>
    </table>
    <?php
}

/**
 * Save testimonial meta data
 */
function coffeeshop_save_testimonial_meta($post_id) {
    if (!isset($_POST['testimonial_nonce']) || !wp_verify_nonce($_POST['testimonial_nonce'], 'coffeeshop_testimonial_nonce')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (isset($_POST['post_type']) && 'testimonial' == $_POST['post_type']) {
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    }
    
    if (isset($_POST['testimonial_author'])) {
        update_post_meta($post_id, '_testimonial_author', sanitize_text_field($_POST['testimonial_author']));
    }
    
    if (isset($_POST['testimonial_position'])) {
        update_post_meta($post_id, '_testimonial_position', sanitize_text_field($_POST['testimonial_position']));
    }
    
    if (isset($_POST['testimonial_rating'])) {
        update_post_meta($post_id, '_testimonial_rating', sanitize_text_field($_POST['testimonial_rating']));
    }
}
add_action('save_post', 'coffeeshop_save_testimonial_meta');