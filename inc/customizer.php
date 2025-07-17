<?php
/**
 * Theme Customizer
 *
 * @package CoffeeShop
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 */
function coffeeshop_customize_register($wp_customize) {
    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport = 'postMessage';
    $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

    // Add Colors Panel
    $wp_customize->add_panel('coffeeshop_colors', array(
        'title' => __('Theme Colors', 'coffeeshop'),
        'priority' => 30,
    ));

    // Primary Color Section
    $wp_customize->add_section('coffeeshop_primary_colors', array(
        'title' => __('Primary Colors', 'coffeeshop'),
        'panel' => 'coffeeshop_colors',
    ));

    // Primary Color
    $wp_customize->add_setting('coffeeshop_primary_color', array(
        'default' => '#6F4E37',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'coffeeshop_primary_color', array(
        'label' => __('Primary Color', 'coffeeshop'),
        'section' => 'coffeeshop_primary_colors',
        'settings' => 'coffeeshop_primary_color',
    )));

    // Secondary Color
    $wp_customize->add_setting('coffeeshop_secondary_color', array(
        'default' => '#FFFFFF',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'coffeeshop_secondary_color', array(
        'label' => __('Secondary Color', 'coffeeshop'),
        'section' => 'coffeeshop_primary_colors',
        'settings' => 'coffeeshop_secondary_color',
    )));

    // Accent Color
    $wp_customize->add_setting('coffeeshop_accent_color', array(
        'default' => '#8B4513',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'coffeeshop_accent_color', array(
        'label' => __('Accent Color', 'coffeeshop'),
        'section' => 'coffeeshop_primary_colors',
        'settings' => 'coffeeshop_accent_color',
    )));

    // Typography Section
    $wp_customize->add_section('coffeeshop_typography', array(
        'title' => __('Typography', 'coffeeshop'),
        'priority' => 40,
    ));

    // Heading Font
    $wp_customize->add_setting('coffeeshop_heading_font', array(
        'default' => 'Playfair Display',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control('coffeeshop_heading_font', array(
        'label' => __('Heading Font', 'coffeeshop'),
        'section' => 'coffeeshop_typography',
        'type' => 'select',
        'choices' => array(
            'Playfair Display' => 'Playfair Display',
            'Georgia' => 'Georgia',
            'Times New Roman' => 'Times New Roman',
            'Merriweather' => 'Merriweather',
            'Lora' => 'Lora',
            'Crimson Text' => 'Crimson Text',
            'Cormorant Garamond' => 'Cormorant Garamond',
        ),
    ));

    // Body Font
    $wp_customize->add_setting('coffeeshop_body_font', array(
        'default' => 'Open Sans',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control('coffeeshop_body_font', array(
        'label' => __('Body Font', 'coffeeshop'),
        'section' => 'coffeeshop_typography',
        'type' => 'select',
        'choices' => array(
            'Open Sans' => 'Open Sans',
            'Roboto' => 'Roboto',
            'Lato' => 'Lato',
            'Source Sans Pro' => 'Source Sans Pro',
            'Nunito' => 'Nunito',
            'Poppins' => 'Poppins',
            'Montserrat' => 'Montserrat',
        ),
    ));

    // Font Sizes
    $wp_customize->add_setting('coffeeshop_base_font_size', array(
        'default' => '16',
        'sanitize_callback' => 'absint',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control('coffeeshop_base_font_size', array(
        'label' => __('Base Font Size (px)', 'coffeeshop'),
        'section' => 'coffeeshop_typography',
        'type' => 'number',
        'input_attrs' => array(
            'min' => 12,
            'max' => 24,
            'step' => 1,
        ),
    ));

    // Homepage Settings
    $wp_customize->add_section('coffeeshop_homepage', array(
        'title' => __('Homepage Settings', 'coffeeshop'),
        'priority' => 50,
    ));

    // Hero Title
    $wp_customize->add_setting('coffeeshop_hero_title', array(
        'default' => __('Premium Coffee Experience', 'coffeeshop'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control('coffeeshop_hero_title', array(
        'label' => __('Hero Title', 'coffeeshop'),
        'section' => 'coffeeshop_homepage',
        'type' => 'text',
    ));

    // Hero Subtitle
    $wp_customize->add_setting('coffeeshop_hero_subtitle', array(
        'default' => __('Discover our carefully selected coffee beans from around the world', 'coffeeshop'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control('coffeeshop_hero_subtitle', array(
        'label' => __('Hero Subtitle', 'coffeeshop'),
        'section' => 'coffeeshop_homepage',
        'type' => 'textarea',
    ));

    // Hero Background Image
    $wp_customize->add_setting('coffeeshop_hero_bg', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'coffeeshop_hero_bg', array(
        'label' => __('Hero Background Image', 'coffeeshop'),
        'section' => 'coffeeshop_homepage',
        'settings' => 'coffeeshop_hero_bg',
    )));

    // Enable/Disable Sections
    $wp_customize->add_setting('coffeeshop_show_about_section', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('coffeeshop_show_about_section', array(
        'label' => __('Show About Section', 'coffeeshop'),
        'section' => 'coffeeshop_homepage',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('coffeeshop_show_products_section', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('coffeeshop_show_products_section', array(
        'label' => __('Show Products Section', 'coffeeshop'),
        'section' => 'coffeeshop_homepage',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('coffeeshop_show_testimonials_section', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('coffeeshop_show_testimonials_section', array(
        'label' => __('Show Testimonials Section', 'coffeeshop'),
        'section' => 'coffeeshop_homepage',
        'type' => 'checkbox',
    ));

    // Business Information Section
    $wp_customize->add_section('coffeeshop_business_info', array(
        'title' => __('Business Information', 'coffeeshop'),
        'priority' => 60,
    ));

    // Business Address
    $wp_customize->add_setting('coffeeshop_address', array(
        'default' => '123 Coffee Street, Downtown District, City, State 12345',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('coffeeshop_address', array(
        'label' => __('Business Address', 'coffeeshop'),
        'section' => 'coffeeshop_business_info',
        'type' => 'textarea',
    ));

    // Business Phone
    $wp_customize->add_setting('coffeeshop_phone', array(
        'default' => '(123) 456-7890',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('coffeeshop_phone', array(
        'label' => __('Business Phone', 'coffeeshop'),
        'section' => 'coffeeshop_business_info',
        'type' => 'text',
    ));

    // Business Email
    $wp_customize->add_setting('coffeeshop_email', array(
        'default' => 'info@coffeeshop.com',
        'sanitize_callback' => 'sanitize_email',
    ));

    $wp_customize->add_control('coffeeshop_email', array(
        'label' => __('Business Email', 'coffeeshop'),
        'section' => 'coffeeshop_business_info',
        'type' => 'email',
    ));

    // Business Hours
    $wp_customize->add_setting('coffeeshop_hours', array(
        'default' => 'Mon-Fri: 6AM-8PM, Sat-Sun: 7AM-9PM',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('coffeeshop_hours', array(
        'label' => __('Business Hours', 'coffeeshop'),
        'section' => 'coffeeshop_business_info',
        'type' => 'textarea',
    ));

    // Social Media Section
    $wp_customize->add_section('coffeeshop_social_media', array(
        'title' => __('Social Media', 'coffeeshop'),
        'priority' => 70,
    ));

    // Social Media Links
    $social_networks = array(
        'facebook' => 'Facebook',
        'instagram' => 'Instagram',
        'twitter' => 'Twitter',
        'linkedin' => 'LinkedIn',
        'youtube' => 'YouTube',
        'pinterest' => 'Pinterest',
    );

    foreach ($social_networks as $network => $label) {
        $wp_customize->add_setting('coffeeshop_social_' . $network, array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control('coffeeshop_social_' . $network, array(
            'label' => $label . ' ' . __('URL', 'coffeeshop'),
            'section' => 'coffeeshop_social_media',
            'type' => 'url',
        ));
    }

    // Performance Section
    $wp_customize->add_section('coffeeshop_performance', array(
        'title' => __('Performance', 'coffeeshop'),
        'priority' => 80,
    ));

    // Enable Preloader
    $wp_customize->add_setting('coffeeshop_enable_preloader', array(
        'default' => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('coffeeshop_enable_preloader', array(
        'label' => __('Enable Preloader', 'coffeeshop'),
        'section' => 'coffeeshop_performance',
        'type' => 'checkbox',
    ));

    // Enable Lazy Loading
    $wp_customize->add_setting('coffeeshop_enable_lazy_loading', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('coffeeshop_enable_lazy_loading', array(
        'label' => __('Enable Lazy Loading', 'coffeeshop'),
        'section' => 'coffeeshop_performance',
        'type' => 'checkbox',
    ));

    // Google Analytics
    $wp_customize->add_setting('coffeeshop_google_analytics', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('coffeeshop_google_analytics', array(
        'label' => __('Google Analytics Tracking ID', 'coffeeshop'),
        'section' => 'coffeeshop_performance',
        'type' => 'text',
        'description' => __('Enter your Google Analytics tracking ID (e.g., G-XXXXXXXXXX)', 'coffeeshop'),
    ));

    // Custom CSS Section
    $wp_customize->add_section('coffeeshop_custom_css', array(
        'title' => __('Additional CSS', 'coffeeshop'),
        'priority' => 90,
    ));

    $wp_customize->add_setting('coffeeshop_custom_css', array(
        'default' => '',
        'sanitize_callback' => 'wp_strip_all_tags',
    ));

    $wp_customize->add_control('coffeeshop_custom_css', array(
        'label' => __('Custom CSS', 'coffeeshop'),
        'section' => 'coffeeshop_custom_css',
        'type' => 'textarea',
        'description' => __('Add your custom CSS here. This will be added to the head of your website.', 'coffeeshop'),
    ));

    // Footer Section
    $wp_customize->add_section('coffeeshop_footer', array(
        'title' => __('Footer Settings', 'coffeeshop'),
        'priority' => 100,
    ));

    // Footer Copyright Text
    $wp_customize->add_setting('coffeeshop_footer_copyright', array(
        'default' => sprintf(__('© %s %s. All rights reserved.', 'coffeeshop'), date('Y'), get_bloginfo('name')),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('coffeeshop_footer_copyright', array(
        'label' => __('Footer Copyright Text', 'coffeeshop'),
        'section' => 'coffeeshop_footer',
        'type' => 'text',
    ));

    // Show Footer Social Links
    $wp_customize->add_setting('coffeeshop_show_footer_social', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('coffeeshop_show_footer_social', array(
        'label' => __('Show Social Links in Footer', 'coffeeshop'),
        'section' => 'coffeeshop_footer',
        'type' => 'checkbox',
    ));
}
add_action('customize_register', 'coffeeshop_customize_register');

/**
 * Bind JS handlers to instantly live-preview changes.
 */
function coffeeshop_customize_preview_js() {
    wp_enqueue_script('coffeeshop-customizer', get_template_directory_uri() . '/js/customizer.js', array('customize-preview'), COFFEESHOP_VERSION, true);
}
add_action('customize_preview_init', 'coffeeshop_customize_preview_js');

/**
 * Add custom CSS from customizer
 */
function coffeeshop_customizer_css() {
    $custom_css = get_theme_mod('coffeeshop_custom_css', '');
    $base_font_size = get_theme_mod('coffeeshop_base_font_size', 16);
    $heading_font = get_theme_mod('coffeeshop_heading_font', 'Playfair Display');
    $body_font = get_theme_mod('coffeeshop_body_font', 'Open Sans');
    
    if (!empty($custom_css) || $base_font_size != 16 || $heading_font != 'Playfair Display' || $body_font != 'Open Sans') {
        echo '<style type="text/css">';
        
        // Font size
        if ($base_font_size != 16) {
            echo "body { font-size: {$base_font_size}px; }";
        }
        
        // Fonts
        if ($heading_font != 'Playfair Display') {
            echo ":root { --font-primary: '{$heading_font}', serif; }";
        }
        
        if ($body_font != 'Open Sans') {
            echo ":root { --font-secondary: '{$body_font}', sans-serif; }";
        }
        
        // Custom CSS
        if (!empty($custom_css)) {
            echo $custom_css;
        }
        
        echo '</style>';
    }
}
add_action('wp_head', 'coffeeshop_customizer_css');

/**
 * Enqueue additional Google Fonts based on customizer settings
 */
function coffeeshop_customizer_fonts() {
    $heading_font = get_theme_mod('coffeeshop_heading_font', 'Playfair Display');
    $body_font = get_theme_mod('coffeeshop_body_font', 'Open Sans');
    
    $fonts = array();
    
    if ($heading_font && $heading_font != 'Playfair Display') {
        $fonts[] = $heading_font . ':400,700';
    }
    
    if ($body_font && $body_font != 'Open Sans') {
        $fonts[] = $body_font . ':300,400,600,700';
    }
    
    if (!empty($fonts)) {
        $fonts_url = 'https://fonts.googleapis.com/css2?family=' . implode('&family=', $fonts) . '&display=swap';
        wp_enqueue_style('coffeeshop-custom-fonts', $fonts_url, array(), null);
    }
}
add_action('wp_enqueue_scripts', 'coffeeshop_customizer_fonts');

/**
 * Customizer sanitization functions
 */
function coffeeshop_sanitize_select($input, $setting) {
    $input = sanitize_key($input);
    $choices = $setting->manager->get_control($setting->id)->choices;
    return (array_key_exists($input, $choices) ? $input : $setting->default);
}

function coffeeshop_sanitize_checkbox($checked) {
    return ((isset($checked) && true == $checked) ? true : false);
}

function coffeeshop_sanitize_number($number, $setting) {
    $number = absint($number);
    return (in_array($number, range($setting->manager->get_control($setting->id)->input_attrs['min'], $setting->manager->get_control($setting->id)->input_attrs['max'])) ? $number : $setting->default);
}