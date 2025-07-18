<?php
/**
 * Admin Functions
 *
 * @package CoffeeShop
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit('Direct access forbidden.');
}

/**
 * Add theme options page
 */
function coffeeshop_admin_menu() {
    add_theme_page(
        esc_html__('CoffeeShop Pro Options', 'coffeeshop'),
        esc_html__('Theme Options', 'coffeeshop'),
        'manage_options',
        'coffeeshop-options',
        'coffeeshop_options_page'
    );
}
add_action('admin_menu', 'coffeeshop_admin_menu');

/**
 * Theme options page content
 */
function coffeeshop_options_page() {
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        
        <div class="coffeeshop-admin-content">
            <div class="coffeeshop-admin-main">
                <div class="card">
                    <h2><?php esc_html_e('Welcome to CoffeeShop Pro', 'coffeeshop'); ?></h2>
                    <p><?php esc_html_e('Thank you for choosing CoffeeShop Pro! This theme is designed to help you create a beautiful coffee shop website.', 'coffeeshop'); ?></p>
                    
                    <h3><?php esc_html_e('Getting Started', 'coffeeshop'); ?></h3>
                    <ol>
                        <li><?php esc_html_e('Install recommended plugins', 'coffeeshop'); ?></li>
                        <li><?php esc_html_e('Go to Appearance > Customize to set up your site', 'coffeeshop'); ?></li>
                        <li><?php esc_html_e('Add your content and customize colors', 'coffeeshop'); ?></li>
                    </ol>
                    
                    <p>
                        <a href="<?php echo esc_url(admin_url('customize.php')); ?>" class="button button-primary">
                            <?php esc_html_e('Customize Your Site', 'coffeeshop'); ?>
                        </a>
                        <a href="<?php echo esc_url(admin_url('themes.php?page=tgmpa-install-plugins')); ?>" class="button">
                            <?php esc_html_e('Install Plugins', 'coffeeshop'); ?>
                        </a>
                    </p>
                </div>
                
                <div class="card">
                    <h3><?php esc_html_e('Recommended Plugins', 'coffeeshop'); ?></h3>
                    <ul>
                        <li><strong>WooCommerce</strong> - <?php esc_html_e('For online store functionality', 'coffeeshop'); ?></li>
                        <li><strong>Elementor</strong> - <?php esc_html_e('For advanced page building', 'coffeeshop'); ?></li>
                        <li><strong>Contact Form 7</strong> - <?php esc_html_e('For contact forms', 'coffeeshop'); ?></li>
                    </ul>
                </div>
            </div>
            
            <div class="coffeeshop-admin-sidebar">
                <div class="card">
                    <h3><?php esc_html_e('Documentation', 'coffeeshop'); ?></h3>
                    <p><?php esc_html_e('Need help setting up your theme? Check out our documentation.', 'coffeeshop'); ?></p>
                    <p>
                        <a href="#" class="button" target="_blank">
                            <?php esc_html_e('View Documentation', 'coffeeshop'); ?>
                        </a>
                    </p>
                </div>
                
                <div class="card">
                    <h3><?php esc_html_e('Support', 'coffeeshop'); ?></h3>
                    <p><?php esc_html_e('Have questions? Our support team is here to help.', 'coffeeshop'); ?></p>
                    <p>
                        <a href="#" class="button" target="_blank">
                            <?php esc_html_e('Get Support', 'coffeeshop'); ?>
                        </a>
                    </p>
                </div>
                
                <div class="card">
                    <h3><?php esc_html_e('Theme Info', 'coffeeshop'); ?></h3>
                    <ul>
                        <li><strong><?php esc_html_e('Version:', 'coffeeshop'); ?></strong> <?php echo esc_html(COFFEESHOP_VERSION); ?></li>
                        <li><strong><?php esc_html_e('Author:', 'coffeeshop'); ?></strong> YourCompany</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <style>
    .coffeeshop-admin-content {
        display: flex;
        gap: 20px;
        margin-top: 20px;
    }
    
    .coffeeshop-admin-main {
        flex: 2;
    }
    
    .coffeeshop-admin-sidebar {
        flex: 1;
    }
    
    .card {
        background: #fff;
        border: 1px solid #ccd0d4;
        border-radius: 4px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 1px 1px rgba(0,0,0,.04);
    }
    
    .card h2, .card h3 {
        margin-top: 0;
        color: #8B4513;
    }
    
    .card ol, .card ul {
        padding-left: 20px;
    }
    
    .card li {
        margin-bottom: 5px;
    }
    
    @media (max-width: 768px) {
        .coffeeshop-admin-content {
            flex-direction: column;
        }
    }
    </style>
    <?php
}

/**
 * Add admin notices
 */
function coffeeshop_admin_notices() {
    // Check if required plugins are installed
    $required_plugins = array(
        'woocommerce/woocommerce.php' => 'WooCommerce',
        'elementor/elementor.php' => 'Elementor',
    );
    
    $missing_plugins = array();
    foreach ($required_plugins as $plugin_path => $plugin_name) {
        if (!is_plugin_active($plugin_path)) {
            $missing_plugins[] = $plugin_name;
        }
    }
    
    if (!empty($missing_plugins) && !get_user_meta(get_current_user_id(), 'coffeeshop_dismiss_plugins_notice', true)) {
        ?>
        <div class="notice notice-warning is-dismissible coffeeshop-plugins-notice">
            <h3><?php esc_html_e('CoffeeShop Pro - Recommended Plugins', 'coffeeshop'); ?></h3>
            <p><?php esc_html_e('To get the most out of your theme, we recommend installing these plugins:', 'coffeeshop'); ?></p>
            <ul style="list-style: disc; margin-left: 20px;">
                <?php foreach ($missing_plugins as $plugin) : ?>
                    <li><?php echo esc_html($plugin); ?></li>
                <?php endforeach; ?>
            </ul>
            <p>
                <a href="<?php echo esc_url(admin_url('themes.php?page=tgmpa-install-plugins')); ?>" class="button button-primary">
                    <?php esc_html_e('Install Plugins', 'coffeeshop'); ?>
                </a>
                <button type="button" class="notice-dismiss">
                    <span class="screen-reader-text"><?php esc_html_e('Dismiss this notice.', 'coffeeshop'); ?></span>
                </button>
            </p>
        </div>
        
        <script>
        jQuery(document).ready(function($) {
            $(document).on('click', '.coffeeshop-plugins-notice .notice-dismiss', function() {
                $.post(ajaxurl, {
                    action: 'coffeeshop_dismiss_plugins_notice',
                    nonce: '<?php echo wp_create_nonce('coffeeshop_dismiss_plugins_notice'); ?>'
                });
            });
        });
        </script>
        <?php
    }
}
add_action('admin_notices', 'coffeeshop_admin_notices');

/**
 * AJAX handler for dismissing plugins notice
 */
function coffeeshop_dismiss_plugins_notice() {
    check_ajax_referer('coffeeshop_dismiss_plugins_notice', 'nonce');
    
    update_user_meta(get_current_user_id(), 'coffeeshop_dismiss_plugins_notice', true);
    
    wp_die();
}
add_action('wp_ajax_coffeeshop_dismiss_plugins_notice', 'coffeeshop_dismiss_plugins_notice');

/**
 * Add admin CSS
 */
function coffeeshop_admin_styles($hook) {
    if ('appearance_page_coffeeshop-options' === $hook) {
        wp_enqueue_style('coffeeshop-admin-style', get_template_directory_uri() . '/assets/css/admin.css', array(), COFFEESHOP_VERSION);
    }
}
add_action('admin_enqueue_scripts', 'coffeeshop_admin_styles');

/**
 * Add theme support indicator to admin bar
 */
functi