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
 * Register Barista Post Type
 */
function coffeeshop_register_baristas() {
    $args = array(
        'labels' => array(
            'name' => __('Baristas', 'coffeeshop'),
            'singular_name' => __('Barista', 'coffeeshop'),
            'add_new' => __('Add New', 'coffeeshop'),
            'add_new_item' => __('Add New Barista', 'coffeeshop'),
            'edit_item' => __('Edit Barista', 'coffeeshop'),
            'new_item' => __('New Barista', 'coffeeshop'),
            'view_item' => __('View Barista', 'coffeeshop'),
            'search_items' => __('Search Baristas', 'coffeeshop'),
            'not_found' => __('No baristas found', 'coffeeshop'),
            'not_found_in_trash' => __('No baristas found in trash', 'coffeeshop'),
        ),
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'baristas'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 26,
        'menu_icon' => 'dashicons-groups',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'show_in_rest' => true,
    );
    
    register_post_type('barista', $args);
}
add_action('init', 'coffeeshop_register_baristas');

/**
 * Register Menu Item Post Type
 */
function coffeeshop_register_menu_items() {
    $args = array(
        'labels' => array(
            'name' => __('Menu Items', 'coffeeshop'),
            'singular_name' => __('Menu Item', 'coffeeshop'),
            'add_new' => __('Add New', 'coffeeshop'),
            'add_new_item' => __('Add New Menu Item', 'coffeeshop'),
            'edit_item' => __('Edit Menu Item', 'coffeeshop'),
            'new_item' => __('New Menu Item', 'coffeeshop'),
            'view_item' => __('View Menu Item', 'coffeeshop'),
            'search_items' => __('Search Menu Items', 'coffeeshop'),
            'not_found' => __('No menu items found', 'coffeeshop'),
            'not_found_in_trash' => __('No menu items found in trash', 'coffeeshop'),
        ),
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'menu-items'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 27,
        'menu_icon' => 'dashicons-coffee',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'show_in_rest' => true,
    );
    
    register_post_type('menu_item', $args);
}
add_action('init', 'coffeeshop_register_menu_items');

/**
 * Register Menu Categories Taxonomy
 */
function coffeeshop_register_menu_categories() {
    $args = array(
        'hierarchical' => true,
        'labels' => array(
            'name' => __('Menu Categories', 'coffeeshop'),
            'singular_name' => __('Menu Category', 'coffeeshop'),
            'search_items' => __('Search Menu Categories', 'coffeeshop'),
            'all_items' => __('All Menu Categories', 'coffeeshop'),
            'parent_item' => __('Parent Menu Category', 'coffeeshop'),
            'parent_item_colon' => __('Parent Menu Category:', 'coffeeshop'),
            'edit_item' => __('Edit Menu Category', 'coffeeshop'),
            'update_item' => __('Update Menu Category', 'coffeeshop'),
            'add_new_item' => __('Add New Menu Category', 'coffeeshop'),
            'new_item_name' => __('New Menu Category Name', 'coffeeshop'),
            'menu_name' => __('Menu Categories', 'coffeeshop'),
        ),
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'menu-category'),
        'show_in_rest' => true,
    );
    
    register_taxonomy('menu_category', array('menu_item'), $args);
}
add_action('init', 'coffeeshop_register_menu_categories');

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

/**
 * Add custom meta boxes for baristas
 */
function coffeeshop_add_barista_meta_boxes() {
    add_meta_box(
        'barista_details',
        __('Barista Details', 'coffeeshop'),
        'coffeeshop_barista_meta_box_callback',
        'barista',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'coffeeshop_add_barista_meta_boxes');

/**
 * Barista meta box callback
 */
function coffeeshop_barista_meta_box_callback($post) {
    wp_nonce_field('coffeeshop_barista_nonce', 'barista_nonce');
    
    $position = get_post_meta($post->ID, '_barista_position', true);
    $specialty = get_post_meta($post->ID, '_barista_specialty', true);
    $experience = get_post_meta($post->ID, '_barista_experience', true);
    $facebook = get_post_meta($post->ID, '_barista_facebook', true);
    $instagram = get_post_meta($post->ID, '_barista_instagram', true);
    $twitter = get_post_meta($post->ID, '_barista_twitter', true);
    
    ?>
    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="barista_position"><?php _e('Position', 'coffeeshop'); ?></label>
            </th>
            <td>
                <input type="text" id="barista_position" name="barista_position" value="<?php echo esc_attr($position); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="barista_specialty"><?php _e('Specialty', 'coffeeshop'); ?></label>
            </th>
            <td>
                <input type="text" id="barista_specialty" name="barista_specialty" value="<?php echo esc_attr($specialty); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="barista_experience"><?php _e('Years of Experience', 'coffeeshop'); ?></label>
            </th>
            <td>
                <input type="number" id="barista_experience" name="barista_experience" value="<?php echo esc_attr($experience); ?>" min="0" max="50" />
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="barista_facebook"><?php _e('Facebook URL', 'coffeeshop'); ?></label>
            </th>
            <td>
                <input type="url" id="barista_facebook" name="barista_facebook" value="<?php echo esc_attr($facebook); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="barista_instagram"><?php _e('Instagram URL', 'coffeeshop'); ?></label>
            </th>
            <td>
                <input type="url" id="barista_instagram" name="barista_instagram" value="<?php echo esc_attr($instagram); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="barista_twitter"><?php _e('Twitter URL', 'coffeeshop'); ?></label>
            </th>
            <td>
                <input type="url" id="barista_twitter" name="barista_twitter" value="<?php echo esc_attr($twitter); ?>" class="regular-text" />
            </td>
        </tr>
    </table>
    <?php
}

/**
 * Save barista meta data
 */
function coffeeshop_save_barista_meta($post_id) {
    if (!isset($_POST['barista_nonce']) || !wp_verify_nonce($_POST['barista_nonce'], 'coffeeshop_barista_nonce')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (isset($_POST['post_type']) && 'barista' == $_POST['post_type']) {
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    }
    
    $fields = ['barista_position', 'barista_specialty', 'barista_experience', 'barista_facebook', 'barista_instagram', 'barista_twitter'];
    
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            if ($field === 'barista_experience') {
                update_post_meta($post_id, '_' . $field, intval($_POST[$field]));
            } elseif (in_array($field, ['barista_facebook', 'barista_instagram', 'barista_twitter'])) {
                update_post_meta($post_id, '_' . $field, esc_url_raw($_POST[$field]));
            } else {
                update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
            }
        }
    }
}
add_action('save_post', 'coffeeshop_save_barista_meta');

/**
 * Add custom meta boxes for menu items
 */
function coffeeshop_add_menu_item_meta_boxes() {
    add_meta_box(
        'menu_item_details',
        __('Menu Item Details', 'coffeeshop'),
        'coffeeshop_menu_item_meta_box_callback',
        'menu_item',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'coffeeshop_add_menu_item_meta_boxes');

/**
 * Menu item meta box callback
 */
function coffeeshop_menu_item_meta_box_callback($post) {
    wp_nonce_field('coffeeshop_menu_item_nonce', 'menu_item_nonce');
    
    $price = get_post_meta($post->ID, '_menu_item_price', true);
    $ingredients = get_post_meta($post->ID, '_menu_item_ingredients', true);
    $allergens = get_post_meta($post->ID, '_menu_item_allergens', true);
    $featured = get_post_meta($post->ID, '_menu_item_featured', true);
    $available = get_post_meta($post->ID, '_menu_item_available', true);
    
    ?>
    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="menu_item_price"><?php _e('Price', 'coffeeshop'); ?></label>
            </th>
            <td>
                <input type="text" id="menu_item_price" name="menu_item_price" value="<?php echo esc_attr($price); ?>" class="regular-text" placeholder="$0.00" />
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="menu_item_ingredients"><?php _e('Ingredients', 'coffeeshop'); ?></label>
            </th>
            <td>
                <textarea id="menu_item_ingredients" name="menu_item_ingredients" rows="3" class="large-text"><?php echo esc_textarea($ingredients); ?></textarea>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="menu_item_allergens"><?php _e('Allergens', 'coffeeshop'); ?></label>
            </th>
            <td>
                <input type="text" id="menu_item_allergens" name="menu_item_allergens" value="<?php echo esc_attr($allergens); ?>" class="regular-text" placeholder="e.g., Contains nuts, dairy" />
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="menu_item_featured"><?php _e('Featured Item', 'coffeeshop'); ?></label>
            </th>
            <td>
                <input type="checkbox" id="menu_item_featured" name="menu_item_featured" value="1" <?php checked($featured, '1'); ?> />
                <span class="description"><?php _e('Check to feature this item on the homepage', 'coffeeshop'); ?></span>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="menu_item_available"><?php _e('Available', 'coffeeshop'); ?></label>
            </th>
            <td>
                <input type="checkbox" id="menu_item_available" name="menu_item_available" value="1" <?php checked($available, '1'); ?> />
                <span class="description"><?php _e('Uncheck if item is temporarily unavailable', 'coffeeshop'); ?></span>
            </td>
        </tr>
    </table>
    <?php
}

/**
 * Save menu item meta data
 */
function coffeeshop_save_menu_item_meta($post_id) {
    if (!isset($_POST['menu_item_nonce']) || !wp_verify_nonce($_POST['menu_item_nonce'], 'coffeeshop_menu_item_nonce')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (isset($_POST['post_type']) && 'menu_item' == $_POST['post_type']) {
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    }
    
    // Save price
    if (isset($_POST['menu_item_price'])) {
        update_post_meta($post_id, '_menu_item_price', sanitize_text_field($_POST['menu_item_price']));
    }
    
    // Save ingredients
    if (isset($_POST['menu_item_ingredients'])) {
        update_post_meta($post_id, '_menu_item_ingredients', sanitize_textarea_field($_POST['menu_item_ingredients']));
    }
    
    // Save allergens
    if (isset($_POST['menu_item_allergens'])) {
        update_post_meta($post_id, '_menu_item_allergens', sanitize_text_field($_POST['menu_item_allergens']));
    }
    
    // Save featured status
    if (isset($_POST['menu_item_featured'])) {
        update_post_meta($post_id, '_menu_item_featured', '1');
    } else {
        delete_post_meta($post_id, '_menu_item_featured');
    }
    
    // Save availability status
    if (isset($_POST['menu_item_available'])) {
        update_post_meta($post_id, '_menu_item_available', '1');
    } else {
        delete_post_meta($post_id, '_menu_item_available');
    }
}
add_action('save_post', 'coffeeshop_save_menu_item_meta');

/**
 * Add custom columns to testimonials admin
 */
function coffeeshop_testimonial_columns($columns) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = $columns['title'];
    $new_columns['author'] = __('Author', 'coffeeshop');
    $new_columns['rating'] = __('Rating', 'coffeeshop');
    $new_columns['date'] = $columns['date'];
    
    return $new_columns;
}
add_filter('manage_testimonial_posts_columns', 'coffeeshop_testimonial_columns');

/**
 * Fill custom columns for testimonials
 */
function coffeeshop_testimonial_column_content($column, $post_id) {
    switch ($column) {
        case 'author':
            $author = get_post_meta($post_id, '_testimonial_author', true);
            echo $author ? esc_html($author) : '—';
            break;
        case 'rating':
            $rating = get_post_meta($post_id, '_testimonial_rating', true);
            if ($rating) {
                echo str_repeat('★', intval($rating)) . str_repeat('☆', 5 - intval($rating));
            } else {
                echo '—';
            }
            break;
    }
}
add_action('manage_testimonial_posts_custom_column', 'coffeeshop_testimonial_column_content', 10, 2);

/**
 * Add custom columns to baristas admin
 */
function coffeeshop_barista_columns($columns) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['thumbnail'] = __('Photo', 'coffeeshop');
    $new_columns['title'] = $columns['title'];
    $new_columns['position'] = __('Position', 'coffeeshop');
    $new_columns['specialty'] = __('Specialty', 'coffeeshop');
    $new_columns['experience'] = __('Experience', 'coffeeshop');
    $new_columns['date'] = $columns['date'];
    
    return $new_columns;
}
add_filter('manage_barista_posts_columns', 'coffeeshop_barista_columns');

/**
 * Fill custom columns for baristas
 */
function coffeeshop_barista_column_content($column, $post_id) {
    switch ($column) {
        case 'thumbnail':
            if (has_post_thumbnail($post_id)) {
                echo get_the_post_thumbnail($post_id, array(50, 50));
            } else {
                echo '<span class="dashicons dashicons-businessman" style="font-size: 50px; color: #ccc;"></span>';
            }
            break;
        case 'position':
            $position = get_post_meta($post_id, '_barista_position', true);
            echo $position ? esc_html($position) : '—';
            break;
        case 'specialty':
            $specialty = get_post_meta($post_id, '_barista_specialty', true);
            echo $specialty ? esc_html($specialty) : '—';
            break;
        case 'experience':
            $experience = get_post_meta($post_id, '_barista_experience', true);
            echo $experience ? esc_html($experience) . ' ' . __('years', 'coffeeshop') : '—';
            break;
    }
}
add_action('manage_barista_posts_custom_column', 'coffeeshop_barista_column_content', 10, 2);

/**
 * Add custom columns to menu items admin
 */
function coffeeshop_menu_item_columns($columns) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['thumbnail'] = __('Image', 'coffeeshop');
    $new_columns['title'] = $columns['title'];
    $new_columns['price'] = __('Price', 'coffeeshop');
    $new_columns['category'] = __('Category', 'coffeeshop');
    $new_columns['featured'] = __('Featured', 'coffeeshop');
    $new_columns['available'] = __('Available', 'coffeeshop');
    $new_columns['date'] = $columns['date'];
    
    return $new_columns;
}
add_filter('manage_menu_item_posts_columns', 'coffeeshop_menu_item_columns');

/**
 * Fill custom columns for menu items
 */
function coffeeshop_menu_item_column_content($column, $post_id) {
    switch ($column) {
        case 'thumbnail':
            if (has_post_thumbnail($post_id)) {
                echo get_the_post_thumbnail($post_id, array(50, 50));
            } else {
                echo '<span class="dashicons dashicons-coffee" style="font-size: 50px; color: #ccc;"></span>';
            }
            break;
        case 'price':
            $price = get_post_meta($post_id, '_menu_item_price', true);
            echo $price ? esc_html($price) : '—';
            break;
        case 'category':
            $terms = get_the_terms($post_id, 'menu_category');
            if ($terms && !is_wp_error($terms)) {
                $category_names = wp_list_pluck($terms, 'name');
                echo implode(', ', $category_names);
            } else {
                echo '—';
            }
            break;
        case 'featured':
            $featured = get_post_meta($post_id, '_menu_item_featured', true);
            echo $featured ? '<span class="dashicons dashicons-star-filled" style="color: #ffb900;"></span>' : '—';
            break;
        case 'available':
            $available = get_post_meta($post_id, '_menu_item_available', true);
            $available = $available !== '' ? $available : '1'; // Default to available
            echo $available ? '<span class="dashicons dashicons-yes-alt" style="color: #46b450;"></span>' : '<span class="dashicons dashicons-dismiss" style="color: #dc3232;"></span>';
            break;
    }
}
add_action('manage_menu_item_posts_custom_column', 'coffeeshop_menu_item_column_content', 10, 2);

/**
 * Make custom columns sortable
 */
function coffeeshop_sortable_columns($columns) {
    $columns['rating'] = 'rating';
    $columns['experience'] = 'experience';
    $columns['price'] = 'price';
    $columns['featured'] = 'featured';
    $columns['available'] = 'available';
    
    return $columns;
}
add_filter('manage_edit-testimonial_sortable_columns', 'coffeeshop_sortable_columns');
add_filter('manage_edit-barista_sortable_columns', 'coffeeshop_sortable_columns');
add_filter('manage_edit-menu_item_sortable_columns', 'coffeeshop_sortable_columns');

/**
 * Handle sorting for custom columns
 */
function coffeeshop_posts_orderby($query) {
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }
    
    $orderby = $query->get('orderby');
    
    switch ($orderby) {
        case 'rating':
            $query->set('meta_key', '_testimonial_rating');
            $query->set('orderby', 'meta_value_num');
            break;
        case 'experience':
            $query->set('meta_key', '_barista_experience');
            $query->set('orderby', 'meta_value_num');
            break;
        case 'price':
            $query->set('meta_key', '_menu_item_price');
            $query->set('orderby', 'meta_value');
            break;
        case 'featured':
            $query->set('meta_key', '_menu_item_featured');
            $query->set('orderby', 'meta_value');
            break;
        case 'available':
            $query->set('meta_key', '_menu_item_available');
            $query->set('orderby', 'meta_value');
            break;
    }
}
add_action('pre_get_posts', 'coffeeshop_posts_orderby');

/**
 * Create default menu categories on theme activation
 */
function coffeeshop_create_default_menu_categories() {
    $categories = array(
        'Coffee & Espresso' => 'Hot coffee drinks including espresso, americano, cappuccino, and latte',
        'Cold Beverages' => 'Iced coffees, cold brew, and other refreshing drinks',
        'Pastries & Desserts' => 'Fresh baked goods and sweet treats',
        'Light Meals' => 'Sandwiches, salads, and other light food options',
        'Specialty Drinks' => 'Seasonal and signature beverages'
    );
    
    foreach ($categories as $name => $description) {
        if (!term_exists($name, 'menu_category')) {
            wp_insert_term($name, 'menu_category', array(
                'description' => $description,
                'slug' => sanitize_title($name)
            ));
        }
    }
}
add_action('after_switch_theme', 'coffeeshop_create_default_menu_categories');