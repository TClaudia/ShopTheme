


<?php
/**
 * WooCommerce Compatibility File
 *
 * @package CoffeeShop
 */

/**
 * WooCommerce setup function.
 */
function coffeeshop_woocommerce_setup() {
    add_theme_support('woocommerce', array(
        'thumbnail_image_width' => 300,
        'single_image_width'    => 600,
        'product_grid'          => array(
            'default_rows'    => 3,
            'min_rows'        => 2,
            'max_rows'        => 8,
            'default_columns' => 4,
            'min_columns'     => 2,
            'max_columns'     => 5,
        ),
    ));
}
add_action('after_setup_theme', 'coffeeshop_woocommerce_setup');

/**
 * Remove default WooCommerce wrapper.
 */
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

/**
 * Add custom WooCommerce wrapper.
 */
function coffeeshop_woocommerce_wrapper_start() {
    echo '<div class="container"><div class="woocommerce-container">';
}
add_action('woocommerce_before_main_content', 'coffeeshop_woocommerce_wrapper_start', 10);

function coffeeshop_woocommerce_wrapper_end() {
    echo '</div></div>';
}
add_action('woocommerce_after_main_content', 'coffeeshop_woocommerce_wrapper_end', 10);

/**
 * Change number of products per row to 3.
 */
function coffeeshop_woocommerce_loop_columns() {
    return 3;
}
add_filter('loop_shop_columns', 'coffeeshop_woocommerce_loop_columns');

/**
 * Disable WooCommerce styles.
 */
function coffeeshop_dequeue_woocommerce_styles($enqueue_styles) {
    unset($enqueue_styles['woocommerce-general']);
    unset($enqueue_styles['woocommerce-layout']);
    unset($enqueue_styles['woocommerce-smallscreen']);
    return $enqueue_styles;
}
add_filter('woocommerce_enqueue_styles', 'coffeeshop_dequeue_woocommerce_styles');

/**
 * Add cart fragment for AJAX cart updates.
 */
function coffeeshop_cart_fragment($fragments) {
    $cart_count = WC()->cart->get_cart_contents_count();
    $fragments['span.cart-count'] = '<span class="cart-count">' . $cart_count . '</span>';
    return $fragments;
}
add_filter('woocommerce_add_to_cart_fragments', 'coffeeshop_cart_fragment');

/**
 * Change "Add to Cart" button text.
 */
function coffeeshop_custom_add_to_cart_text() {
    return __('Add to Cart', 'coffeeshop');
}
add_filter('woocommerce_product_add_to_cart_text', 'coffeeshop_custom_add_to_cart_text');

/**
 * Customize WooCommerce breadcrumb.
 */
function coffeeshop_woocommerce_breadcrumb() {
    $args = array(
        'delimiter'   => ' / ',
        'wrap_before' => '<nav class="woocommerce-breadcrumb">',
        'wrap_after'  => '</nav>',
        'before'      => '',
        'after'       => '',
        'home'        => _x('Home', 'breadcrumb', 'coffeeshop'),
    );
    return $args;
}
add_filter('woocommerce_breadcrumb_defaults', 'coffeeshop_woocommerce_breadcrumb');