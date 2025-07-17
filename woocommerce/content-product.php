

<?php
/**
 * The template for displaying product content within loops
 *
 * @package CoffeeShop
 */

defined('ABSPATH') || exit;

global $product;

// Ensure visibility.
if (empty($product) || !$product->is_visible()) {
    return;
}
?>
<div <?php wc_product_class('product-card', $product); ?>>
    <div class="product-image">
        <?php
        /**
         * Hook: woocommerce_before_shop_loop_item.
         */
        do_action('woocommerce_before_shop_loop_item');
        ?>
        <a href="<?php the_permalink(); ?>">
            <?php
            /**
             * Hook: woocommerce_before_shop_loop_item_title.
             */
            do_action('woocommerce_before_shop_loop_item_title');
            ?>
        </a>
        
        <?php if ($product->is_on_sale()) : ?>
            <span class="sale-badge"><?php _e('Sale!', 'coffeeshop'); ?></span>
        <?php endif; ?>
    </div>
    
    <div class="product-info">
        <h3 class="product-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        
        <?php
        /**
         * Hook: woocommerce_after_shop_loop_item_title.
         */
        do_action('woocommerce_after_shop_loop_item_title');
        ?>
        
        <div class="product-price">
            <?php echo $product->get_price_html(); ?>
        </div>
        
        <?php
        /**
         * Hook: woocommerce_after_shop_loop_item.
         */
        do_action('woocommerce_after_shop_loop_item');
        ?>
    </div>
</div>
