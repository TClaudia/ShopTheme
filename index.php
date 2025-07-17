<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 *
 * @package CoffeeShop
 */

get_header();
?>

<main id="main" class="site-main">
    <?php if (is_home() || is_front_page()) : ?>
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

        <!-- Featured Products/Menu -->
        <?php if (class_exists('WooCommerce')) : ?>
            <section class="products-section">
                <div class="container">
                    <div class="section-header">
                        <h2 class="section-title"><?php _e('Featured Products', 'coffeeshop'); ?></h2>
                        <p class="section-subtitle"><?php _e('Our most popular coffee selections', 'coffeeshop'); ?></p>
                    </div>
                    
                    <?php
                    $featured_products = wc_get_featured_product_ids();
                    if (!empty($featured_products)) :
                        $args = array(
                            'post_type' => 'product',
                            'posts_per_page' => 6,
                            'post__in' => $featured_products,
                            'meta_query' => array(
                                array(
                                    'key' => '_visibility',
                                    'value' => array('catalog', 'visible'),
                                    'compare' => 'IN'
                                )
                            )
                        );
                        $featured_query = new WP_Query($args);
                        
                        if ($featured_query->have_posts()) :
                    ?>
                        <div class="products-grid">
                            <?php while ($featured_query->have_posts()) : $featured_query->the_post(); ?>
                                <?php wc_get_template_part('content', 'product'); ?>
                            <?php endwhile; ?>
                        </div>
                    <?php
                        endif;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </section>
        <?php endif; ?>

        <!-- Testimonials Section -->
        <section class="testimonials-section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title"><?php _e('What Our Customers Say', 'coffeeshop'); ?></h2>
                </div>
                <div class="testimonials-grid">
                    <?php
                    $testimonials = new WP_Query(array(
                        'post_type' => 'testimonial',
                        'posts_per_page' => 3,
                        'post_status' => 'publish'
                    ));
                    
                    if ($testimonials->have_posts()) :
                        while ($testimonials->have_posts()) : $testimonials->the_post();
                            $author_name = get_post_meta(get_the_ID(), '_testimonial_author', true);
                            $author_position = get_post_meta(get_the_ID(), '_testimonial_position', true);
                            $rating = get_post_meta(get_the_ID(), '_testimonial_rating', true);
                    ?>
                        <div class="testimonial-card">
                            <?php if ($rating) : ?>
                                <div class="testimonial-rating">
                                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                                        <span class="star <?php echo $i <= $rating ? 'active' : ''; ?>">★</span>
                                    <?php endfor; ?>
                                </div>
                            <?php endif; ?>
                            <p class="testimonial-text">"<?php the_content(); ?>"</p>
                            <div class="testimonial-author">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="author-image">
                                        <?php the_post_thumbnail('coffeeshop-thumb'); ?>
                                    </div>
                                <?php endif; ?>
                                <div class="author-info">
                                    <h4 class="author-name"><?php echo $author_name ?: get_the_title(); ?></h4>
                                    <?php if ($author_position) : ?>
                                        <p class="author-position"><?php echo $author_position; ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    else :
                        // Default testimonials if none exist
                        $default_testimonials = array(
                            array(
                                'text' => __('The best coffee I\'ve ever tasted! The quality is exceptional and the service is outstanding.', 'coffeeshop'),
                                'author' => 'Sarah Johnson',
                                'position' => __('Coffee Enthusiast', 'coffeeshop'),
                                'rating' => 5
                            ),
                            array(
                                'text' => __('Amazing atmosphere and incredible coffee. I come here every morning!', 'coffeeshop'),
                                'author' => 'Michael Chen',
                                'position' => __('Regular Customer', 'coffeeshop'),
                                'rating' => 5
                            ),
                            array(
                                'text' => __('Perfect place to work and enjoy premium coffee. Highly recommended!', 'coffeeshop'),
                                'author' => 'Emma Davis',
                                'position' => __('Freelancer', 'coffeeshop'),
                                'rating' => 5
                            )
                        );
                        
                        foreach ($default_testimonials as $testimonial) :
                    ?>
                        <div class="testimonial-card">
                            <div class="testimonial-rating">
                                <?php for ($i = 1; $i <= 5; $i++) : ?>
                                    <span class="star <?php echo $i <= $testimonial['rating'] ? 'active' : ''; ?>">★</span>
                                <?php endfor; ?>
                            </div>
                            <p class="testimonial-text">"<?php echo $testimonial['text']; ?>"</p>
                            <div class="testimonial-author">
                                <div class="author-info">
                                    <h4 class="author-name"><?php echo $testimonial['author']; ?></h4>
                                    <p class="author-position"><?php echo $testimonial['position']; ?></p>
                                </div>
                            </div>
                        </div>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>
        </section>

    <?php else : ?>
        <!-- Regular blog/page content -->
        <div class="container">
            <div class="content-area">
                <?php if (have_posts()) : ?>
                    <div class="blog-grid">
                        <?php while (have_posts()) : the_post(); ?>
                            <article id="post-<?php the_ID(); ?>" <?php post_class('blog-card'); ?>>
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="blog-image">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('coffeeshop-featured'); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="blog-content">
                                    <div class="blog-meta">
                                        <span><i class="fas fa-calendar"></i> <?php the_date(); ?></span>
                                        <span><i class="fas fa-user"></i> <?php the_author(); ?></span>
                                        <span><i class="fas fa-folder"></i> <?php the_category(', '); ?></span>
                                    </div>
                                    
                                    <h2 class="blog-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h2>
                                    
                                    <div class="blog-excerpt">
                                        <?php the_excerpt(); ?>
                                    </div>
                                    
                                    <a href="<?php the_permalink(); ?>" class="read-more"><?php _e('Read More', 'coffeeshop'); ?></a>
                                </div>
                            </article>
                        <?php endwhile; ?>
                    </div>
                    
                    <?php
                    // Pagination
                    the_posts_pagination(array(
                        'prev_text' => __('Previous', 'coffeeshop'),
                        'next_text' => __('Next', 'coffeeshop'),
                    ));
                    ?>
                <?php else : ?>
                    <div class="no-content">
                        <h1><?php _e('Nothing Found', 'coffeeshop'); ?></h1>
                        <p><?php _e('It looks like nothing was found at this location. Maybe try a search?', 'coffeeshop'); ?></p>
                        <?php get_search_form(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</main>

<?php get_footer(); ?>