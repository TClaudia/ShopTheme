<?php
/**
 * Plugin installation and activation for WordPress themes.
 *
 * This library is a simplified version for basic plugin activation.
 * For full TGMPA functionality, download from: http://tgmpluginactivation.com/
 *
 * @package CoffeeShop
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit('Direct access forbidden.');
}

/**
 * Simplified TGMPA functionality
 * This is a basic implementation for theme requirements
 */
if (!class_exists('TGM_Plugin_Activation')) {

    class TGM_Plugin_Activation {
        
        /**
         * Instance of this class.
         */
        protected static $instance = null;
        
        /**
         * Array of plugins.
         */
        protected $plugins = array();
        
        /**
         * Array of configuration settings.
         */
        protected $config = array();
        
        /**
         * Constructor
         */
        public function __construct() {
            add_action('admin_menu', array($this, 'admin_menu'));
            add_action('admin_notices', array($this, 'notices'));
            add_action('admin_init', array($this, 'admin_init'));
        }
        
        /**
         * Return an instance of this class.
         */
        public static function get_instance() {
            if (null === self::$instance) {
                self::$instance = new self();
            }
            return self::$instance;
        }
        
        /**
         * Register plugins
         */
        public function register($plugins, $config = array()) {
            $this->plugins = $plugins;
            $this->config = wp_parse_args($config, array(
                'id'           => 'tgmpa',
                'default_path' => '',
                'menu'         => 'tgmpa-install-plugins',
                'has_notices'  => true,
                'dismissable'  => true,
                'dismiss_msg'  => '',
                'is_automatic' => false,
                'message'      => '',
            ));
        }
        
        /**
         * Add admin menu
         */
        public function admin_menu() {
            if (empty($this->plugins)) {
                return;
            }
            
            add_theme_page(
                esc_html__('Install Required Plugins', 'coffeeshop'),
                esc_html__('Install Plugins', 'coffeeshop'),
                'manage_options',
                $this->config['menu'],
                array($this, 'install_plugins_page')
            );
        }
        
        /**
         * Admin notices
         */
        public function notices() {
            if (!$this->config['has_notices'] || empty($this->plugins)) {
                return;
            }
            
            $missing_plugins = $this->get_missing_plugins();
            
            if (empty($missing_plugins)) {
                return;
            }
            
            $dismissable = $this->config['dismissable'] ? 'is-dismissible' : '';
            
            ?>
            <div class="notice notice-warning <?php echo esc_attr($dismissable); ?>">
                <h3><?php esc_html_e('Required Plugins', 'coffeeshop'); ?></h3>
                <p><?php esc_html_e('This theme requires the following plugins to work properly:', 'coffeeshop'); ?></p>
                <ul style="list-style: disc; margin-left: 20px;">
                    <?php foreach ($missing_plugins as $plugin) : ?>
                        <li><?php echo esc_html($plugin['name']); ?></li>
                    <?php endforeach; ?>
                </ul>
                <p>
                    <a href="<?php echo esc_url(admin_url('themes.php?page=' . $this->config['menu'])); ?>" class="button button-primary">
                        <?php esc_html_e('Install Plugins', 'coffeeshop'); ?>
                    </a>
                </p>
            </div>
            <?php
        }
        
        /**
         * Get missing plugins
         */
        protected function get_missing_plugins() {
            $missing = array();
            
            foreach ($this->plugins as $plugin) {
                if (!$this->is_plugin_active($plugin)) {
                    $missing[] = $plugin;
                }
            }
            
            return $missing;
        }
        
        /**
         * Check if plugin is active
         */
        protected function is_plugin_active($plugin) {
            if (isset($plugin['slug'])) {
                $plugin_path = $plugin['slug'] . '/' . $plugin['slug'] . '.php';
                return is_plugin_active($plugin_path);
            }
            return false;
        }
        
        /**
         * Admin init
         */
        public function admin_init() {
            if (isset($_GET['plugin']) && isset($_GET['tgmpa-install'])) {
                $this->install_plugin($_GET['plugin']);
            }
        }
        
        /**
         * Install plugins page
         */
        public function install_plugins_page() {
            ?>
            <div class="wrap">
                <h1><?php esc_html_e('Install Required Plugins', 'coffeeshop'); ?></h1>
                
                <?php if (empty($this->plugins)) : ?>
                    <p><?php esc_html_e('No plugins are required for this theme.', 'coffeeshop'); ?></p>
                <?php else : ?>
                    
                    <p><?php esc_html_e('The following plugins are recommended for this theme. Click on the big blue button below to install and activate them.', 'coffeeshop'); ?></p>
                    
                    <table class="wp-list-table widefat fixed striped">
                        <thead>
                            <tr>
                                <th scope="col"><?php esc_html_e('Plugin', 'coffeeshop'); ?></th>
                                <th scope="col"><?php esc_html_e('Status', 'coffeeshop'); ?></th>
                                <th scope="col"><?php esc_html_e('Required', 'coffeeshop'); ?></th>
                                <th scope="col"><?php esc_html_e('Action', 'coffeeshop'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($this->plugins as $plugin) : ?>
                                <tr>
                                    <td>
                                        <strong><?php echo esc_html($plugin['name']); ?></strong>
                                        <?php if (isset($plugin['description'])) : ?>
                                            <br><span class="description"><?php echo esc_html($plugin['description']); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($this->is_plugin_active($plugin)) : ?>
                                            <span style="color: green;">
                                                <strong><?php esc_html_e('Active', 'coffeeshop'); ?></strong>
                                            </span>
                                        <?php else : ?>
                                            <span style="color: #d54e21;">
                                                <strong><?php esc_html_e('Not Installed', 'coffeeshop'); ?></strong>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php echo isset($plugin['required']) && $plugin['required'] ? esc_html__('Yes', 'coffeeshop') : esc_html__('Recommended', 'coffeeshop'); ?>
                                    </td>
                                    <td>
                                        <?php if (!$this->is_plugin_active($plugin)) : ?>
                                            <a href="<?php echo esc_url(admin_url('plugin-install.php?tab=search&s=' . urlencode($plugin['slug']))); ?>" class="button">
                                                <?php esc_html_e('Install', 'coffeeshop'); ?>
                                            </a>
                                        <?php else : ?>
                                            <span style="color: green;"><?php esc_html_e('Installed', 'coffeeshop'); ?></span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    
                    <br>
                    <h3><?php esc_html_e('Bulk Actions', 'coffeeshop'); ?></h3>
                    <p><?php esc_html_e('Install all recommended plugins at once:', 'coffeeshop'); ?></p>
                    
                    <?php
                    $missing_plugins = $this->get_missing_plugins();
                    if (!empty($missing_plugins)) :
                        $install_links = array();
                        foreach ($missing_plugins as $plugin) {
                            $install_links[] = admin_url('plugin-install.php?tab=search&s=' . urlencode($plugin['slug']));
                        }
                        ?>
                        <p>
                            <a href="<?php echo esc_url($install_links[0]); ?>" class="button button-primary button-hero">
                                <?php esc_html_e('Install Recommended Plugins', 'coffeeshop'); ?>
                            </a>
                        </p>
                        <p class="description">
                            <?php esc_html_e('Note: You will be redirected to the WordPress plugin installer. Install each plugin individually.', 'coffeeshop'); ?>
                        </p>
                    <?php else : ?>
                        <p style="color: green;">
                            <strong><?php esc_html_e('All recommended plugins are installed!', 'coffeeshop'); ?></strong>
                        </p>
                    <?php endif; ?>
                    
                <?php endif; ?>
                
                <hr>
                <h3><?php esc_html_e('Manual Installation', 'coffeeshop'); ?></h3>
                <p><?php esc_html_e('You can also install plugins manually by going to:', 'coffeeshop'); ?></p>
                <ol>
                    <li><a href="<?php echo esc_url(admin_url('plugin-install.php')); ?>"><?php esc_html_e('Plugins > Add New', 'coffeeshop'); ?></a></li>
                    <li><?php esc_html_e('Search for the plugin name', 'coffeeshop'); ?></li>
                    <li><?php esc_html_e('Click "Install Now" and then "Activate"', 'coffeeshop'); ?></li>
                </ol>
            </div>
            
            <style>
            .button-hero {
                padding: 10px 20px !important;
                font-size: 16px !important;
                height: auto !important;
            }
            
            .description {
                font-style: italic;
                color: #666;
            }
            
            .wp-list-table th,
            .wp-list-table td {
                padding: 12px;
            }
            </style>
            <?php
        }
        
        /**
         * Install plugin (simplified)
         */
        protected function install_plugin($plugin_slug) {
            // Redirect to WordPress plugin installer
            wp_redirect(admin_url('plugin-install.php?tab=search&s=' . urlencode($plugin_slug)));
            exit;
        }
    }
}

/**
 * Main function
 */
function tgmpa($plugins, $config = array()) {
    $instance = TGM_Plugin_Activation::get_instance();
    $instance->register($plugins, $config);
}