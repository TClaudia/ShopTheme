<?php
/**
 * CoffeeShop Pro Theme Customizer
 *
 * @package CoffeeShop
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit('Direct access forbidden.');
}

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function coffeeshop_customize_register($wp_customize) {
    $wp_customize->get_setting('blogname')->transport         = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport  = 'postMessage';
    $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

    if (isset($wp_customize->selective_refresh)) {
        $wp_customize->selective_refresh->add_partial('blogname', array(
            'selector'        => '.site-title a',
            'render_callback' => 'coffeeshop_customize_partial_blogname',
        ));
        $wp_customize->selective_refresh->add_partial('blogdescription', array(
            'selector'        => '.site-description',
            'render_callback' => 'coffeeshop_customize_partial_blogdescription',
        ));
    }

    // Theme Colors Section
    $wp_customize->add_section('coffeeshop_colors', array(
        'title'    => esc_html__('Theme Colors', 'coffeeshop'),
        'priority' => 40,
    ));

    // Primary Color
    $wp_customize->add_setting('coffeeshop_primary_color', array(
        'default'           => '#8B4513',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'coffeeshop_primary_color', array(
        'label'    => esc_html__('Primary Color', 'coffeeshop'),
        'section'  => 'coffeeshop_colors',
        'settings' => 'coffeeshop_primary_color',
    )));

    // Secondary Color
    $wp_customize->add_setting('coffeeshop_secondary_color', array(
        'default'           => '#FFFFFF',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'coffeeshop_secondary_color', array(
        'label'    => esc_html__('Secondary Color', 'coffeeshop'),
        'section'  => 'coffeeshop_colors',
        'settings' => 'coffeeshop_secondary_color',
    )));

    // Accent Color
    $wp_customize->add_setting('coffeeshop_accent_color', array(
        'default'           => '#D2691E',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'coffeeshop_accent_color', array(
        'label'    => esc_html__('Accent Color', 'coffeeshop'),
        'section'  => 'coffeeshop_colors',
        'settings' => 'coffeeshop_accent_color',
    )));

    // Typography Section
    $wp_customize->add_section('coffeeshop_typography', array(
        'title'    => esc_html__('Typography', 'coffeeshop'),
        'priority' => 50,
    ));

    // Base Font Size
    $wp_customize->add_setting('coffeeshop_base_font_size', array(
        'default'           => 16,
        'sanitize_callback' => 'coffeeshop_sanitize_number',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('coffeeshop_base_font_size', array(
        'label'       => esc_html__('Base Font Size (px)', 'coffeeshop'),
        'section'     => 'coffeeshop_typography',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 12,
            'max'  => 24,
            'step' => 1,
        ),
    ));

    // Header Section
    $wp_customize->add_section('coffeeshop_header', array(
        'title'    => esc_html__('Header Options', 'coffeeshop'),
        'priority' => 60,
    ));

    // Enable Header Search
    $wp_customize->add_setting('coffeeshop_enable_header_search', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('coffeeshop_enable_header_search', array(
        'label'   => esc_html__('Enable Header Search', 'coffeeshop'),
        'section' => 'coffeeshop_header',
        'type'    => 'checkbox',
    ));

    // Enable Header Cart
    $wp_customize->add_setting('coffeeshop_enable_header_cart', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('coffeeshop_enable_header_cart', array(
        'label'   => esc_html__('Enable Header Cart (WooCommerce)', 'coffeeshop'),
        'section' => 'coffeeshop_header',
        'type'    => 'checkbox',
    ));

    // Homepage Section
    $wp_customize->add_section('coffeeshop_homepage', array(
        'title'    => esc_html__('Homepage Settings', 'coffeeshop'),
        'priority' => 70,
    ));

    // Hero Title
    $wp_customize->add_setting('coffeeshop_hero_title', array(
        'default'           => __('Premium Coffee Experience', 'coffeeshop'),
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('coffeeshop_hero_title', array(
        'label'   => esc_html__('Hero Title', 'coffeeshop'),
        'section' => 'coffeeshop_homepage',
        'type'    => 'text',
    ));

    // Hero Subtitle
    $wp_customize->add_setting('coffeeshop_hero_subtitle', array(
        'default'           => __('Discover our carefully selected coffee beans from around the world, crafted with passion and served with excellence.', 'coffeeshop'),
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('coffeeshop_hero_subtitle', array(
        'label'   => esc_html__('Hero Subtitle', 'coffeeshop'),
        'section' => 'coffeeshop_homepage',
        'type'    => 'textarea',
    ));

    // Hero Background Image
    $wp_customize->add_setting('coffeeshop_hero_bg_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'coffeeshop_hero_bg_image', array(
        'label'    => esc_html__('Hero Background Image', 'coffeeshop'),
        'section'  => 'coffeeshop_homepage',
        'settings' => 'coffeeshop_hero_bg_image',
    )));

    // Show Featured Products
    $wp_customize->add_setting('coffeeshop_show_featured_products', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('coffeeshop_show_featured_products', array(
        'label'   => esc_html__('Show Featured Products', 'coffeeshop'),
        'section' => 'coffeeshop_homepage',
        'type'    => 'checkbox',
    ));

    // Featured Products Title
    $wp_customize->add_setting('coffeeshop_featured_products_title', array(
        'default'           => __('Featured Products', 'coffeeshop'),
        'sanitize_callback' => 'wp_kses_post',
    ));

    $wp_customize->add_control('coffeeshop_featured_products_title', array(
        'label'   => esc_html__('Featured Products Title', 'coffeeshop'),
        'section' => 'coffeeshop_homepage',
        'type'    => 'text',
    ));

    // Show About Section
    $wp_customize->add_setting('coffeeshop_show_about_section', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('coffeeshop_show_about_section', array(
        'label'   => esc_html__('Show About Section', 'coffeeshop'),
        'section' => 'coffeeshop_homepage',
        'type'    => 'checkbox',
    ));

    // About Title
    $wp_customize->add_setting('coffeeshop_about_title', array(
        'default'           => __('Our Story', 'coffeeshop'),
        'sanitize_callback' => 'wp_kses_post',
    ));

    $wp_customize->add_control('coffeeshop_about_title', array(
        'label'   => esc_html__('About Section Title', 'coffeeshop'),
        'section' => 'coffeeshop_homepage',
        'type'    => 'text',
    ));

    // About Content
    $wp_customize->add_setting('coffeeshop_about_content', array(
        'default'           => __('We are passionate coffee enthusiasts dedicated to bringing you the finest coffee beans from around the world. Our journey began with a simple mission: to share exceptional coffee experiences with fellow coffee lovers.', 'coffeeshop'),
        'sanitize_callback' => 'wp_kses_post',
    ));

    $wp_customize->add_control('coffeeshop_about_content', array(
        'label'   => esc_html__('About Section Content', 'coffeeshop'),
        'section' => 'coffeeshop_homepage',
        'type'    => 'textarea',
    ));

    // Social Media Section
    $wp_customize->add_section('coffeeshop_social', array(
        'title'    => esc_html__('Social Media', 'coffeeshop'),
        'priority' => 80,
    ));

    // Social Media Links
    $social_networks = array(
        'facebook'  => esc_html__('Facebook URL', 'coffeeshop'),
        'twitter'   => esc_html__('Twitter URL', 'coffeeshop'),
        'instagram' => esc_html__('Instagram URL', 'coffeeshop'),
        'youtube'   => esc_html__('YouTube URL', 'coffeeshop'),
        'linkedin'  => esc_html__('LinkedIn URL', 'coffeeshop'),
    );

    foreach ($social_networks as $network => $label) {
        $wp_customize->add_setting('coffeeshop_' . $network . '_url', array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control('coffeeshop_' . $network . '_url', array(
            'label'   => $label,
            'section' => 'coffeeshop_social',
            'type'    => 'url',
        ));
    }

    // Blog Section
    $wp_customize->add_section('coffeeshop_blog', array(
        'title'    => esc_html__('Blog Settings', 'coffeeshop'),
        'priority' => 90,
    ));

    // Excerpt Length
    $wp_customize->add_setting('coffeeshop_excerpt_length', array(
        'default'           => 25,
        'sanitize_callback' => 'coffeeshop_sanitize_number',
    ));

    $wp_customize->add_control('coffeeshop_excerpt_length', array(
        'label'       => esc_html__('Excerpt Length (words)', 'coffeeshop'),
        'section'     => 'coffeeshop_blog',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 10,
            'max'  => 100,
            'step' => 1,
        ),
    ));

    // Show Blog Section on Homepage
    $wp_customize->add_setting('coffeeshop_show_blog_section', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('coffeeshop_show_blog_section', array(
        'label'   => esc_html__('Show Blog Section on Homepage', 'coffeeshop'),
        'section' => 'coffeeshop_blog',
        'type'    => 'checkbox',
    ));

    // WooCommerce Section
    if (class_exists('WooCommerce')) {
        $wp_customize->add_section('coffeeshop_woocommerce', array(
            'title'    => esc_html__('WooCommerce Settings', 'coffeeshop'),
            'priority' => 100,
        ));

        // Products per page
        $wp_customize->add_setting('coffeeshop_products_per_page', array(
            'default'           => 12,
            'sanitize_callback' => 'coffeeshop_sanitize_number',
        ));

        $wp_customize->add_control('coffeeshop_products_per_page', array(
            'label'       => esc_html__('Products per page', 'coffeeshop'),
            'section'     => 'coffeeshop_woocommerce',
            'type'        => 'number',
            'input_attrs' => array(
                'min'  => 4,
                'max'  => 48,
                'step' => 4,
            ),
        ));

        // Product columns
        $wp_customize->add_setting('coffeeshop_product_columns', array(
            'default'           => 3,
            'sanitize_callback' => 'coffeeshop_sanitize_select',
        ));

        $wp_customize->add_control('coffeeshop_product_columns', array(
            'label'   => esc_html__('Product columns', 'coffeeshop'),
            'section' => 'coffeeshop_woocommerce',
            'type'    => 'select',
            'choices' => array(
                '2' => esc_html__('2 Columns', 'coffeeshop'),
                '3' => esc_html__('3 Columns', 'coffeeshop'),
                '4' => esc_html__('4 Columns', 'coffeeshop'),
            ),
        ));
    }

    // Footer Section
    $wp_customize->add_section('coffeeshop_footer', array(
        'title'    => esc_html__('Footer Settings', 'coffeeshop'),
        'priority' => 110,
    ));

    // Copyright Text
    $wp_customize->add_setting('coffeeshop_copyright_text', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
    ));

    $wp_customize->add_control('coffeeshop_copyright_text', array(
        'label'   => esc_html__('Copyright Text', 'coffeeshop'),
        'section' => 'coffeeshop_footer',
        'type'    => 'textarea',
        'description' => esc_html__('Leave empty to use default copyright text.', 'coffeeshop'),
    ));

    // Enable Footer Social Links
    $wp_customize->add_setting('coffeeshop_enable_footer_social', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('coffeeshop_enable_footer_social', array(
        'label'   => esc_html__('Show Social Links in Footer', 'coffeeshop'),
        'section' => 'coffeeshop_footer',
        'type'    => 'checkbox',
    ));

    // Layout Section
    $wp_customize->add_section('coffeeshop_layout', array(
        'title'    => esc_html__('Layout Settings', 'coffeeshop'),
        'priority' => 120,
    ));

    // Enable Breadcrumbs
    $wp_customize->add_setting('coffeeshop_enable_breadcrumbs', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('coffeeshop_enable_breadcrumbs', array(
        'label'   => esc_html__('Enable Breadcrumbs', 'coffeeshop'),
        'section' => 'coffeeshop_layout',
        'type'    => 'checkbox',
    ));

    // Enable Back to Top Button
    $wp_customize->add_setting('coffeeshop_enable_scroll_top', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('coffeeshop_enable_scroll_top', array(
        'label'   => esc_html__('Enable Back to Top Button', 'coffeeshop'),
        'section' => 'coffeeshop_layout',
        'type'    => 'checkbox',
    ));

    // Performance Section
    $wp_customize->add_section('coffeeshop_performance', array(
        'title'    => esc_html__('Performance', 'coffeeshop'),
        'priority' => 130,
    ));

    // Defer JavaScript
    $wp_customize->add_setting('coffeeshop_defer_js', array(
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('coffeeshop_defer_js', array(
        'label'       => esc_html__('Defer JavaScript Loading', 'coffeeshop'),
        'section'     => 'coffeeshop_performance',
        'type'        => 'checkbox',
        'description' => esc_html__('May improve page load speed but could break some functionality.', 'coffeeshop'),
    ));

    // Custom CSS Section
    $wp_customize->add_section('coffeeshop_custom_css', array(
        'title'    => esc_html__('Additional CSS', 'coffeeshop'),
        'priority' => 140,
    ));

    // Custom CSS
    $wp_customize->add_setting('coffeeshop_custom_css', array(
        'default'           => '',
        'sanitize_callback' => 'wp_strip_all_tags',
    ));

    $wp_customize->add_control('coffeeshop_custom_css', array(
        'label'       => esc_html__('Custom CSS', 'coffeeshop'),
        'section'     => 'coffeeshop_custom_css',
        'type'        => 'textarea',
        'description' => esc_html__('Add your custom CSS here.', 'coffeeshop'),
        'input_attrs' => array(
            'placeholder' => '.my-class { color: #000; }',
            'rows'        => 10,
        ),
    ));
}
add_action('customize_register', 'coffeeshop_customize_register');

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function coffeeshop_customize_partial_blogname() {
    bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function coffeeshop_customize_partial_blogdescription() {
    bloginfo('description');
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function coffeeshop_customize_preview_js() {
    wp_enqueue_script('coffeeshop-customizer-preview', get_template_directory_uri() . '/assets/js/customizer-preview.js', array('customize-preview'), COFFEESHOP_VERSION, true);
}
add_action('customize_preview_init', 'coffeeshop_customize_preview_js');

/**
 * Enqueue customizer controls scripts
 */
function coffeeshop_customize_controls_js() {
    wp_enqueue_script('coffeeshop-customizer-controls', get_template_directory_uri() . '/assets/js/customizer-controls.js', array('customize-controls'), COFFEESHOP_VERSION, true);
}
add_action('customize_controls_enqueue_scripts', 'coffeeshop_customize_controls_js');

/**
 * Add custom CSS from customizer
 */
function coffeeshop_customizer_css() {
    $custom_css = get_theme_mod('coffeeshop_custom_css', '');
    $base_font_size = get_theme_mod('coffeeshop_base_font_size', 16);
    
    if (!empty($custom_css) || $base_font_size != 16) {
        echo '<style type="text/css" id="coffeeshop-customizer-css">';
        
        // Font size
        if ($base_font_size != 16) {
            echo "body { font-size: {$base_font_size}px; }";
        }
        
        // Custom CSS
        if (!empty($custom_css)) {
            echo wp_strip_all_tags($custom_css);
        }
        
        echo '</style>';
    }
}
add_action('wp_head', 'coffeeshop_customizer_css');

/**
 * Sanitization functions
 */

/**
 * Sanitize select fields
 */
function coffeeshop_sanitize_select($input, $setting) {
    $input = sanitize_key($input);
    $choices = $setting->manager->get_control($setting->id)->choices;
    return (array_key_exists($input, $choices) ? $input : $setting->default);
}

/**
 * Sanitize checkbox
 */
function coffeeshop_sanitize_checkbox($checked) {
    return ((isset($checked) && true == $checked) ? true : false);
}

/**
 * Sanitize number
 */
function coffeeshop_sanitize_number($number, $setting) {
    $number = absint($number);
    return ($number ? $number : $setting->default);
}

/**
 * Sanitize range
 */
function coffeeshop_sanitize_range($number, $setting) {
    $number = absint($number);
    $atts = $setting->manager->get_control($setting->id)->input_attrs;
    $min = (isset($atts['min']) ? $atts['min'] : $number);
    $max = (isset($atts['max']) ? $atts['max'] : $number);
    return ($number >= $min && $number <= $max ? $number : $setting->default);
}

/**
 * Sanitize email
 */
function coffeeshop_sanitize_email($email, $setting) {
    $email = sanitize_email($email);
    return (!is_null($email) ? $email : $setting->default);
}

/**
 * Sanitize URL
 */
function coffeeshop_sanitize_url($url, $setting) {
    $url = esc_url_raw($url);
    return (!is_null($url) ? $url : $setting->default);
}

/**
 * Sanitize textarea
 */
function coffeeshop_sanitize_textarea($input) {
    return wp_kses_post(force_balance_tags($input));
}

/**
 * Sanitize HTML
 */
function coffeeshop_sanitize_html($input) {
    return wp_kses_post(force_balance_tags($input));
}

/**
 * Sanitize CSS
 */
function coffeeshop_sanitize_css($input) {
    return wp_strip_all_tags($input);
}

/**
 * Custom Customizer Controls
 */

/**
 * Info control class
 */
if (class_exists('WP_Customize_Control')) {
    class CoffeeShop_Customize_Info_Control extends WP_Customize_Control {
        public $type = 'info';
        public $label = '';
        public $description = '';

        public function render_content() {
            ?>
            <div class="customize-control-info">
                <?php if (!empty($this->label)) : ?>
                    <h3><?php echo esc_html($this->label); ?></h3>
                <?php endif; ?>
                <?php if (!empty($this->description)) : ?>
                    <p><?php echo wp_kses_post($this->description); ?></p>
                <?php endif; ?>
            </div>
            <?php
        }
    }
}

/**
 * Range control class
 */
if (class_exists('WP_Customize_Control')) {
    class CoffeeShop_Customize_Range_Control extends WP_Customize_Control {
        public $type = 'range';

        public function enqueue() {
            wp_enqueue_script('coffeeshop-customizer-range-control', get_template_directory_uri() . '/assets/js/customizer-range-control.js', array('jquery'), COFFEESHOP_VERSION, true);
        }

        public function render_content() {
            ?>
            <label>
                <?php if (!empty($this->label)) : ?>
                    <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <?php endif;
                if (!empty($this->description)) : ?>
                    <span class="description customize-control-description"><?php echo esc_html($this->description); ?></span>
                <?php endif; ?>
                <input type="range" <?php $this->input_attrs(); ?> value="<?php echo esc_attr($this->value()); ?>" <?php $this->link(); ?> />
                <span class="range-value"><?php echo esc_html($this->value()); ?></span>
            </label>
            <?php
        }
    }
}

/**
 * Typography control class
 */
if (class_exists('WP_Customize_Control')) {
    class CoffeeShop_Customize_Typography_Control extends WP_Customize_Control {
        public $type = 'typography';

        public function render_content() {
            $fonts = array(
                '' => esc_html__('Default', 'coffeeshop'),
                'Arial, sans-serif' => 'Arial',
                'Helvetica, sans-serif' => 'Helvetica',
                'Georgia, serif' => 'Georgia',
                'Times New Roman, serif' => 'Times New Roman',
                'Verdana, sans-serif' => 'Verdana',
                'Playfair Display, serif' => 'Playfair Display',
                'Open Sans, sans-serif' => 'Open Sans',
                'Lato, sans-serif' => 'Lato',
                'Montserrat, sans-serif' => 'Montserrat',
                'Roboto, sans-serif' => 'Roboto',
            );
            ?>
            <label>
                <?php if (!empty($this->label)) : ?>
                    <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <?php endif;
                if (!empty($this->description)) : ?>
                    <span class="description customize-control-description"><?php echo esc_html($this->description); ?></span>
                <?php endif; ?>
                <select <?php $this->link(); ?>>
                    <?php foreach ($fonts as $value => $label) : ?>
                        <option value="<?php echo esc_attr($value); ?>" <?php selected($this->value(), $value); ?>><?php echo esc_html($label); ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <?php
        }
    }
}

/**
 * Add customizer info sections
 */
function coffeeshop_customize_register_info($wp_customize) {
    // Theme info
    $wp_customize->add_section('coffeeshop_theme_info', array(
        'title'    => esc_html__('Theme Information', 'coffeeshop'),
        'priority' => 1,
    ));

    $wp_customize->add_setting('coffeeshop_theme_info_welcome', array(
        'sanitize_callback' => 'wp_kses_post',
    ));

    $wp_customize->add_control(new CoffeeShop_Customize_Info_Control($wp_customize, 'coffeeshop_theme_info_welcome', array(
        'label' => esc_html__('Welcome to CoffeeShop Pro!', 'coffeeshop'),
        'description' => sprintf(
            esc_html__('Thank you for choosing CoffeeShop Pro. This theme is designed for coffee shops and cafes. For support and documentation, please visit %s.', 'coffeeshop'),
            '<a href="#" target="_blank">' . esc_html__('our website', 'coffeeshop') . '</a>'
        ),
        'section' => 'coffeeshop_theme_info',
    )));
}
add_action('customize_register', 'coffeeshop_customize_register_info', 5);

/**
 * Output customizer CSS for live preview
 */
function coffeeshop_customizer_live_css() {
    ?>
    <style type="text/css">
        .customize-control-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
            border-left: 4px solid #8B4513;
        }
        
        .customize-control-info h3 {
            margin: 0 0 10px 0;
            color: #8B4513;
            font-size: 14px;
            font-weight: 600;
        }
        
        .customize-control-info p {
            margin: 0;
            font-size: 13px;
            line-height: 1.5;
        }
        
        .customize-control-range input[type="range"] {
            width: 100%;
            margin: 10px 0;
        }
        
        .range-value {
            font-weight: 600;
            color: #8B4513;
        }
    </style>
    <?php
}
add_action('customize_controls_print_styles', 'coffeeshop_customizer_live_css');