

<?php
/**
 * Template for displaying search forms
 *
 * @package CoffeeShop
 */
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <label>
        <span class="screen-reader-text"><?php echo _x('Search for:', 'label', 'coffeeshop'); ?></span>
        <input type="search" class="search-field" placeholder="<?php echo esc_attr_x('Search products...', 'placeholder', 'coffeeshop'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
        <?php if (class_exists('WooCommerce')) : ?>
            <input type="hidden" name="post_type" value="product" />
        <?php endif; ?>
    </label>
    <input type="submit" class="search-submit" value="<?php echo esc_attr_x('Search', 'submit button', 'coffeeshop'); ?>" />
</form>