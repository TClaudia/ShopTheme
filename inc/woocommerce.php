<?php
/**
 * WooCommerce Compatibility
 *
 * @package CoffeeShop
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit('Direct access forbidden.');
}

/**
 * Check if WooCommerce is active
 */
if (!class_exists('WooCommerce')) {
    return;
}

/**
 * WooCommerce setup
 */
function coffeeshop_woocommerce_setup() {
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
}
add_action('after_setup_theme', 'coffeeshop_woocommerce_setup');

/**
 * WooCommerce specific scripts & stylesheets
 */
function coffeeshop_woocommerce_scripts() {
    wp_enqueue_style('coffeeshop-woocommerce-style', get_template_directory_uri() . '/assets/css/woocommerce.css', array(), COFFEESHOP_VERSION);

    $font_path   = WC()->plugin_url() . '/assets/fonts/';
    $inline_font = '@font-face {
            font-family: "star";
            src: url("' . $font_path . 'star.eot");
            src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
                url("' . $font_path . 'star.woff") format("woff"),
                url("' . $font_path . 'star.ttf") format("truetype"),
                url("' . $font_path . 'star.svg#star") format("svg");
            font-weight: normal;
            font-style: normal;
        }';

    wp_add_inline_style('coffeeshop-woocommerce-style', $inline_font);
}
add_action('wp_enqueue_scripts', 'coffeeshop_woocommerce_scripts');

/**
 * Disable the default WooCommerce stylesheet
 */
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

/**
 * Add 'woocommerce-active' class to the body tag
 */
function coffeeshop_woocommerce_active_body_class($classes) {
    $classes[] = 'woocommerce-active';
    return $classes;
}
add_filter('body_class', 'coffeeshop_woocommerce_active_body_class');

/**
 * Products per page
 */
function coffeeshop_woocommerce_products_per_page() {
    return get_theme_mod('coffeeshop_products_per_page', 12);
}
add_filter('loop_shop_per_page', 'coffeeshop_woocommerce_products_per_page');

/**
 * Product gallery thumnbail columns
 */
function coffeeshop_woocommerce_thumbnail_columns() {
    return 4;
}
add_filter('woocommerce_product_thumbnails_columns', 'coffeeshop_woocommerce_thumbnail_columns');

/**
 * Default loop columns on product archives
 */
function coffeeshop_woocommerce_loop_columns() {
    return get_theme_mod('coffeeshop_product_columns', 3);
}
add_filter('loop_shop_columns', 'coffeeshop_woocommerce_loop_columns');

/**
 * Related Products Args
 */
function coffeeshop_woocommerce_related_products_args($args) {
    $defaults = array(
        'posts_per_page' => 4,
        'columns'        => 4,
    );

    $args = wp_parse_args($defaults, $args);

    return $args;
}
add_filter('woocommerce_output_related_products_args', 'coffeeshop_woocommerce_related_products_args');

/**
 * Remove default WooCommerce wrapper
 */
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

if (!function_exists('coffeeshop_woocommerce_wrapper_before')) {
    /**
     * Before Content
     */
    function coffeeshop_woocommerce_wrapper_before() {
        ?>
        <main id="primary" class="site-main">
            <div class="container">
        <?php
    }
}
add_action('woocommerce_before_main_content', 'coffeeshop_woocommerce_wrapper_before');

if (!function_exists('coffeeshop_woocommerce_wrapper_after')) {
    /**
     * After Content
     */
    function coffeeshop_woocommerce_wrapper_after() {
        ?>
            </div>
        </main>
        <?php
    }
}
add_action('woocommerce_after_main_content', 'coffeeshop_woocommerce_wrapper_after');

/**
 * Sample implementation of the WooCommerce Mini Cart
 */
if (!function_exists('coffeeshop_woocommerce_cart_link_fragment')) {
    /**
     * Cart Fragments
     */
    function coffeeshop_woocommerce_cart_link_fragment($fragments) {
        ob_start();
        coffeeshop_woocommerce_cart_link();
        $fragments['a.cart-contents'] = ob_get_clean();

        return $fragments;
    }
}
add_filter('woocommerce_add_to_cart_fragments', 'coffeeshop_woocommerce_cart_link_fragment');

if (!function_exists('coffeeshop_woocommerce_cart_link')) {
    /**
     * Cart Link
     */
    function coffeeshop_woocommerce_cart_link() {
        ?>
        <a class="cart-contents" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e('View your shopping cart', 'coffeeshop'); ?>">
            <i class="fas fa-shopping-cart" aria-hidden="true"></i>
            <span class="count"><?php echo wp_kses_data(sprintf(_n('%d item', '%d items', WC()->cart->get_cart_contents_count(), 'coffeeshop'), WC()->cart->get_cart_contents_count())); ?></span>
            <span class="amount"><?php echo wp_kses_data(WC()->cart->get_cart_subtotal()); ?></span>
        </a>
        <?php
    }
}

if (!function_exists('coffeeshop_woocommerce_header_cart')) {
    /**
     * Display Header Cart
     */
    function coffeeshop_woocommerce_header_cart() {
        if (is_cart()) {
            $class = 'current-menu-item';
        } else {
            $class = '';
        }
        ?>
        <ul id="site-header-cart" class="site-header-cart">
            <li class="<?php echo esc_attr($class); ?>">
                <?php coffeeshop_woocommerce_cart_link(); ?>
            </li>
            <li>
                <?php
                $instance = array(
                    'title' => '',
                );

                the_widget('WC_Widget_Cart', $instance);
                ?>
            </li>
        </ul>
        <?php
    }
}

/**
 * Modify cross sells columns
 */
function coffeeshop_cross_sell_columns($columns) {
    return 2;
}
add_filter('woocommerce_cross_sells_columns', 'coffeeshop_cross_sell_columns');

/**
 * Modify upsells columns
 */
function coffeeshop_upsell_columns($columns) {
    return 2;
}
add_filter('woocommerce_upsells_columns', 'coffeeshop_upsell_columns');

/**
 * Change number of cross sells output
 */
function coffeeshop_cross_sell_total($total) {
    return 2;
}
add_filter('woocommerce_cross_sells_total', 'coffeeshop_cross_sell_total');

/**
 * Change number of upsells output
 */
function coffeeshop_upsell_total($total) {
    return 2;
}
add_filter('woocommerce_upsells_total', 'coffeeshop_upsell_total');