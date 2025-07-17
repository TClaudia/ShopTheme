<?php
/**
 * Template Name: About Us
 * 
 * @package CoffeeShop
 */

get_header();
?>

<main id="main" class="site-main">
    <?php
    // Check if page is built with Elementor
    if (class_exists('\Elementor\Plugin') && \Elementor\Plugin::$instance->documents->get(get_the_ID())->is_built_with_elementor()) {
        while (have_posts()) {
            the_post();
            the_content();
        }
    } else {
        ?>
        <div class="page-template">
            <div class="container">
                <header class="page-header">
                    <h1 class="page-title"><?php _e('About Us', 'coffeeshop'); ?></h1>
                    <p class="page-subtitle"><?php _e('Learn about our passion for coffee and commitment to quality', 'coffeeshop'); ?></p>
                </header>

                <div class="about-content">
                    <div class="about-text">
                        <h2><?php _e('Our Story', 'coffeeshop'); ?></h2>
                        <p><?php _e('Founded in 2008 by coffee enthusiasts Maria and Giuseppe, our coffee shop began as a small neighborhood cafe with a big dream: to bring the authentic taste of premium coffee to our community.', 'coffeeshop'); ?></p>
                        <p><?php _e('What started as a passion project has grown into a beloved local institution, known for our carefully curated selection of beans, expert brewing techniques, and warm, welcoming atmosphere.', 'coffeeshop'); ?></p>
                        <p><?php _e('We source our beans directly from sustainable farms around the world, ensuring fair trade practices and the highest quality standards. Every cup tells a story of dedication, craftsmanship, and love for the art of coffee making.', 'coffeeshop'); ?></p>
                    </div>
                    <div class="about-image">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/about-founders.jpg" alt="<?php _e('Our founders', 'coffeeshop'); ?>" loading="lazy">
                    </div>
                </div>

                <div class="stats-grid">
                    <div class="stat-item">
                        <span class="stat-number">15</span>
                        <span class="stat-label"><?php _e('Years Experience', 'coffeeshop'); ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">50+</span>
                        <span class="stat-label"><?php _e('Coffee Varieties', 'coffeeshop'); ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">10K+</span>
                        <span class="stat-label"><?php _e('Happy Customers', 'coffeeshop'); ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">25</span>
                        <span class="stat-label"><?php _e('Countries Sourced', 'coffeeshop'); ?></span>
                    </div>
                </div>

                <div class="mission-vision">
                    <div class="mission">
                        <h3><?php _e('Our Mission', 'coffeeshop'); ?></h3>
                        <p><?php _e('To provide exceptional coffee experiences that bring people together, support sustainable farming practices, and celebrate the rich cultural heritage of coffee from around the world.', 'coffeeshop'); ?></p>
                    </div>
                    <div class="vision">
                        <h3><?php _e('Our Vision', 'coffeeshop'); ?></h3>
                        <p><?php _e('To be the premier destination for coffee lovers, known for our quality, sustainability, and community spirit. We envision a world where every cup of coffee makes a positive impact.', 'coffeeshop'); ?></p>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
</main>

<?php
get_footer();