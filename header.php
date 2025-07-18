<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package CoffeeShop
 * @since 1.0.0
 */

?>
<!doctype html>
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
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'coffeeshop'); ?></a>

    <header id="masthead" class="site-header" role="banner">
        <div class="container">
            <div class="header-content">
                
                <!-- Site Branding -->
                <div class="site-branding">
                    <?php
                    $custom_logo_id = get_theme_mod('custom_logo');
                    
                    if ($custom_logo_id && has_custom_logo()) :
                        the_custom_logo();
                    else : ?>
                        <div class="site-title-wrapper">
                            <?php if (is_front_page() && is_home()) : ?>
                                <h1 class="site-title">
                                    <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                                        <?php bloginfo('name'); ?>
                                    </a>
                                </h1>
                            <?php else : ?>
                                <p class="site-title">
                                    <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                                        <?php bloginfo('name'); ?>
                                    </a>
                                </p>
                            <?php endif; ?>
                            
                            <?php
                            $coffeeshop_description = get_bloginfo('description', 'display');
                            if ($coffeeshop_description || is_customize_preview()) : ?>
                                <p class="site-description"><?php echo $coffeeshop_description; ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div><!-- .site-branding -->

                <!-- Main Navigation -->
                <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e('Primary Menu', 'coffeeshop'); ?>">
                    
                    <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation menu', 'coffeeshop'); ?>">
                        <span class="menu-toggle-icon">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                        <span class="menu-toggle-text screen-reader-text"><?php esc_html_e('Menu', 'coffeeshop'); ?></span>
                    </button>
                    
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'primary',
                            'menu_id'        => 'primary-menu',
                            'menu_class'     => 'primary-menu',
                            'container'      => false,
                            'depth'          => 3,
                            'fallback_cb'    => 'coffeeshop_fallback_menu',
                        )
                    );
                    ?>
                    
                    <!-- Header Actions -->
                    <div class="header-actions">
                        
                        <!-- Search Toggle -->
                        <?php if (get_theme_mod('coffeeshop_enable_header_search', true)) : ?>
                            <button class="search-toggle" aria-label="<?php esc_attr_e('Toggle search', 'coffeeshop'); ?>" aria-expanded="false" aria-controls="header-search">
                                <i class="fas fa-search" aria-hidden="true"></i>
                            </button>
                        <?php endif; ?>
                        
                        <!-- WooCommerce Cart -->
                        <?php if (class_exists('WooCommerce') && get_theme_mod('coffeeshop_enable_header_cart', true)) : ?>
                            <div class="header-cart">
                                <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="cart-toggle" aria-label="<?php esc_attr_e('View shopping cart', 'coffeeshop'); ?>">
                                    <i class="fas fa-shopping-cart" aria-hidden="true"></i>
                                    <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                                </a>
                                
                                <?php if (get_theme_mod('coffeeshop_enable_cart_dropdown', true)) : ?>
                                    <div class="cart-dropdown">
                                        <div class="widget_shopping_cart_content">
                                            <?php woocommerce_mini_cart(); ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Language Switcher (WPML/Polylang Support) -->
                        <?php if (function_exists('icl_get_languages') || function_exists('pll_the_languages')) : ?>
                            <div class="language-switcher">
                                <?php
                                if (function_exists('icl_get_languages')) :
                                    // WPML Support
                                    $languages = icl_get_languages('skip_missing=0&orderby=code');
                                    if (!empty($languages)) :
                                        foreach ($languages as $lang) :
                                            if ($lang['active']) continue;
                                            ?>
                                            <a href="<?php echo esc_url($lang['url']); ?>" class="lang-link" title="<?php echo esc_attr($lang['native_name']); ?>">
                                                <?php echo esc_html($lang['language_code']); ?>
                                            </a>
                                            <?php
                                        endforeach;
                                    endif;
                                elseif (function_exists('pll_the_languages')) :
                                    // Polylang Support
                                    pll_the_languages(array(
                                        'dropdown' => 0,
                                        'show_names' => 1,
                                        'display_names_as' => 'slug',
                                        'show_flags' => 0,
                                        'hide_if_no_translation' => 0,
                                        'force_home' => 0,
                                        'echo' => 1,
                                        'hide_if_empty' => 1,
                                        'show_current' => 0
                                    ));
                                endif;
                                ?>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Social Links -->
                        <?php if (get_theme_mod('coffeeshop_enable_header_social', false)) : ?>
                            <div class="header-social">
                                <?php coffeeshop_social_links(); ?>
                            </div>
                        <?php endif; ?>
                        
                    </div><!-- .header-actions -->
                    
                </nav><!-- #site-navigation -->
                
            </div><!-- .header-content -->
            
            <!-- Header Search Form -->
            <?php if (get_theme_mod('coffeeshop_enable_header_search', true)) : ?>
                <div id="header-search" class="header-search" aria-hidden="true">
                    <div class="search-form-container">
                        <?php get_search_form(); ?>
                        <button class="search-close" aria-label="<?php esc_attr_e('Close search', 'coffeeshop'); ?>">
                            <i class="fas fa-times" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            <?php endif; ?>
            
        </div><!-- .container -->
    </header><!-- #masthead -->
    
    <!-- Breadcrumbs -->
    <?php if (get_theme_mod('coffeeshop_enable_breadcrumbs', true) && !is_front_page()) : ?>
        <div class="breadcrumbs" role="navigation" aria-label="<?php esc_attr_e('Breadcrumb Navigation', 'coffeeshop'); ?>">
            <div class="container">
                <?php coffeeshop_breadcrumbs(); ?>
            </div>
        </div>
    <?php endif; ?>

    <div id="content" class="site-content">