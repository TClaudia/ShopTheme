<?php
/**
 * PAGE-HOME.PHP - Homepage Template
 */
?>
<?php
/**
 * Template Name: Home Page
 * 
 * @package CoffeeShop
 */

get_header();
?>

<main id="main" class="site-main">
    <?php
    // Check if page is built with Elementor
    if (class_exists('\Elementor\Plugin') && \Elementor\Plugin::$instance->documents->get(get_the_ID())->is_built_with_elementor()) {
        // Display Elementor content
        while (have_posts()) {
            the_post();
            the_content();
        }
    } else {
        // Display default homepage content
        ?>
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="container">
                <div class="hero-content">
                    <h1><?php echo get_theme_mod('coffeeshop_hero_title', __('Premium Coffee Experience', 'coffeeshop')); ?></h1>
                    <p><?php echo get_theme_mod('coffeeshop_hero_subtitle', __('Discover our carefully selected coffee beans from around the world', 'coffeeshop')); ?></p>
                    <a href="<?php echo get_permalink(get_page_by_path('menu')); ?>" class="btn"><?php _e('View Menu', 'coffeeshop'); ?></a>
                    <a href="<?php echo get_permalink(get_page_by_path('book')); ?>" class="btn btn-secondary"><?php _e('Book Table', 'coffeeshop'); ?></a>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section class="about-section">
            <div class="container">
                <div class="about-content">
                    <div class="about-text">
                        <h2><?php _e('Our Story', 'coffeeshop'); ?></h2>
                        <p><?php _e('We are passionate coffee enthusiasts dedicated to bringing you the finest coffee beans from around the world. Our journey began with a simple mission: to share exceptional coffee experiences with fellow coffee lovers.', 'coffeeshop'); ?></p>
                        <p><?php _e('Every bean is carefully selected, roasted to perfection, and delivered fresh to your door. We believe that great coffee brings people together and creates memorable moments.', 'coffeeshop'); ?></p>
                        <a href="<?php echo get_permalink(get_page_by_path('about')); ?>" class="btn"><?php _e('Learn More', 'coffeeshop'); ?></a>
                    </div>
                    <div class="about-image">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/about-image.jpg" alt="<?php _e('About our coffee shop', 'coffeeshop'); ?>" loading="lazy">
                    </div>
                </div>
                
                <div class="stats-grid">
                    <div class="stat-item">
                        <span class="stat-number">50+</span>
                        <span class="stat-label"><?php _e('Coffee Varieties', 'coffeeshop'); ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">1000+</span>
                        <span class="stat-label"><?php _e('Happy Customers', 'coffeeshop'); ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">15</span>
                        <span class="stat-label"><?php _e('Years Experience', 'coffeeshop'); ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">5</span>
                        <span class="stat-label"><?php _e('Expert Baristas', 'coffeeshop'); ?></span>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
    ?>
</main>

<?php
get_footer();