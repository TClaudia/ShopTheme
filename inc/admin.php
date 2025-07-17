

<?php
/**
 * Admin-specific functionality
 *
 * @package CoffeeShop
 */

/**
 * Add theme admin menu
 */
function coffeeshop_admin_menu() {
    add_theme_page(
        __('CoffeeShop Theme Options', 'coffeeshop'),
        __('Theme Options', 'coffeeshop'),
        'manage_options',
        'coffeeshop-options',
        'coffeeshop_theme_options_page'
    );
}
add_action('admin_menu', 'coffeeshop_admin_menu');

/**
 * Theme options page
 */
function coffeeshop_theme_options_page() {
    ?>
    <div class="wrap">
        <h1><?php _e('CoffeeShop Theme Options', 'coffeeshop'); ?></h1>
        
        <div class="card">
            <h2><?php _e('Getting Started', 'coffeeshop'); ?></h2>
            <p><?php _e('Thank you for choosing CoffeeShop theme! Here are some quick tips to get you started:', 'coffeeshop'); ?></p>
            
            <ul>
                <li><strong><?php _e('Install WooCommerce:', 'coffeeshop'); ?></strong> <?php _e('This theme is optimized for WooCommerce. Install and activate the WooCommerce plugin.', 'coffeeshop'); ?></li>
                <li><strong><?php _e('Import Demo Content:', 'coffeeshop'); ?></strong> <?php _e('Use the demo content to quickly set up your site structure.', 'coffeeshop'); ?></li>
                <li><strong><?php _e('Customize Colors:', 'coffeeshop'); ?></strong> <?php _e('Go to Appearance > Customize > Theme Colors to change the color scheme.', 'coffeeshop'); ?></li>
                <li><strong><?php _e('Set Up Menus:', 'coffeeshop'); ?></strong> <?php _e('Create your navigation menus in Appearance > Menus.', 'coffeeshop'); ?></li>
                <li><strong><?php _e('Add Logo:', 'coffeeshop'); ?></strong> <?php _e('Upload your logo in Appearance > Customize > Site Identity.', 'coffeeshop'); ?></li>
            </ul>
        </div>
        
        <div class="card">
            <h2><?php _e('Theme Features', 'coffeeshop'); ?></h2>
            <ul>
                <li>✓ <?php _e('Responsive Design', 'coffeeshop'); ?></li>
                <li>✓ <?php _e('WooCommerce Integration', 'coffeeshop'); ?></li>
                <li>✓ <?php _e('Color Customization', 'coffeeshop'); ?></li>
                <li>✓ <?php _e('Google Fonts', 'coffeeshop'); ?></li>
                <li>✓ <?php _e('Translation Ready', 'coffeeshop'); ?></li>
                <li>✓ <?php _e('SEO Optimized', 'coffeeshop'); ?></li>
                <li>✓ <?php _e('Cross-browser Compatible', 'coffeeshop'); ?></li>
            </ul>
        </div>
        
        <div class="card">
            <h2><?php _e('Newsletter Subscribers', 'coffeeshop'); ?></h2>
            <?php
            $subscribers = get_option('coffeeshop_newsletter_subscribers', array());
            if (!empty($subscribers)) {
                echo '<p>' . sprintf(__('You have %d newsletter subscribers:', 'coffeeshop'), count($subscribers)) . '</p>';
                echo '<ul>';
                foreach ($subscribers as $email) {
                    echo '<li>' . esc_html($email) . '</li>';
                }
                echo '</ul>';
            } else {
                echo '<p>' . __('No newsletter subscribers yet.', 'coffeeshop') . '</p>';
            }
            ?>
        </div>
        
        <div class="card">
            <h2><?php _e('Support', 'coffeeshop'); ?></h2>
            <p><?php _e('Need help with the theme? Check out our documentation or contact support.', 'coffeeshop'); ?></p>
            <p>
                <a href="#" class="button button-primary"><?php _e('Documentation', 'coffeeshop'); ?></a>
                <a href="#" class="button"><?php _e('Support Forum', 'coffeeshop'); ?></a>
            </p>
        </div>
    </div>
    <?php
}

/**
 * Add admin styles
 */
function coffeeshop_admin_styles() {
    ?>
    <style>
        .coffeeshop-admin .card {
            margin-bottom: 20px;
        }
        .coffeeshop-admin .card h2 {
            margin-top: 0;
        }
        .coffeeshop-admin .card ul {
            list-style: disc;
            margin-left: 20px;
        }
    </style>
    <?php
}
add_action('admin_head', 'coffeeshop_admin_styles');

/**
 * Add welcome notice
 */
function coffeeshop_welcome_notice() {
    if (get_option('coffeeshop_welcome_notice_dismissed')) {
        return;
    }
    ?>
    <div class="notice notice-info is-dismissible coffeeshop-welcome-notice">
        <p><strong><?php _e('Welcome to CoffeeShop Theme!', 'coffeeshop'); ?></strong></p>
        <p><?php _e('Thank you for choosing our theme. To get started, please install WooCommerce and visit the Theme Options page.', 'coffeeshop'); ?></p>
        <p>
            <a href="<?php echo admin_url('themes.php?page=coffeeshop-options'); ?>" class="button button-primary"><?php _e('Get Started', 'coffeeshop'); ?></a>
            <a href="#" class="button coffeeshop-dismiss-notice"><?php _e('Dismiss', 'coffeeshop'); ?></a>
        </p>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        $('.coffeeshop-dismiss-notice').on('click', function(e) {
            e.preventDefault();
            $('.coffeeshop-welcome-notice').fadeOut();
            
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'coffeeshop_dismiss_welcome_notice',
                    nonce: '<?php echo wp_create_nonce('coffeeshop_dismiss_notice'); ?>'
                }
            });
        });
    });
    </script>
    <?php
}
add_action('admin_notices', 'coffeeshop_welcome_notice');

/**
 * Dismiss welcome notice
 */
function coffeeshop_dismiss_welcome_notice() {
    if (!wp_verify_nonce($_POST['nonce'], 'coffeeshop_dismiss_notice')) {
        wp_die('Invalid nonce');
    }
    
    update_option('coffeeshop_welcome_notice_dismissed', true);
    wp_die();
}
add_action('wp_ajax_coffeeshop_dismiss_welcome_notice', 'coffeeshop_dismiss_welcome_notice');