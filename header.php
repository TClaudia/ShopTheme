<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#main"><?php _e('Skip to content', 'coffeeshop'); ?></a>

    <header id="masthead" class="site-header">
        <div class="container">
            <div class="header-container">
                <div class="site-branding">
                    <?php
                    $custom_logo_id = get_theme_mod('custom_logo');
                    if ($custom_logo_id) {
                        $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                        echo '<a href="' . esc_url(home_url('/')) . '" class="site-logo"><img src="' . esc_url($logo[0]) . '" alt="' . get_bloginfo('name') . '"></a>';
                    } else {
                        echo '<h1 class="site-title"><a href="' . esc_url(home_url('/')) . '">' . get_bloginfo('name') . '</a></h1>';
                    }
                    ?>
                </div>

                <nav id="site-navigation" class="main-navigation">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'menu_class'     => 'nav-menu',
                        'container'      => false,
                        'fallback_cb'    => 'coffeeshop_fallback_menu',
                    ));
                    ?>
                </nav>

                <div class="header-actions">
                    <button class="search-toggle" aria-label="<?php _e('Search', 'coffeeshop'); ?>">
                        <i class="fas fa-search"></i>
                    </button>
                    
                    <?php if (class_exists('WooCommerce')) : ?>
                        <a href="<?php echo wc_get_cart_url(); ?>" class="cart-toggle" aria-label="<?php _e('View cart', 'coffeeshop'); ?>">
                            <i class="fas fa-shopping-cart"></i>
                            <?php
                            $cart_count = WC()->cart->get_cart_contents_count();
                            if ($cart_count > 0) {
                                echo '<span class="cart-count">' . $cart_count . '</span>';
                            }
                            ?>
                        </a>
                    <?php endif; ?>
                    
                    <button class="mobile-menu-toggle" aria-label="<?php _e('Toggle menu', 'coffeeshop'); ?>">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Search Form -->
        <div class="search-form-container" style="display: none;">
            <div class="container">
                <?php get_search_form(); ?>
            </div>
        </div>
    </header>

    <div id="content" class="site-content">