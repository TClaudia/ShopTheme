<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package CoffeeShop
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main">
    
    <?php if (is_home() || is_front_page()) : ?>
        
        <!-- Hero Section -->
        <section class="hero-section">
            <?php 
            $hero_bg = get_theme_mod('coffeeshop_hero_bg_image');
            if ($hero_bg) : ?>
                <img src="<?php echo esc_url($hero_bg); ?>" alt="<?php esc_attr_e('Hero Background', 'coffeeshop'); ?>" class="hero-bg-image">
            <?php endif; ?>
            
            <div class="container">
                <div class="hero-content">
                    <h1><?php echo esc_html(get_theme_mod('coffeeshop_hero_title', __('Premium Coffee Experience', 'coffeeshop'))); ?></h1>
                    <p><?php echo esc_html(get_theme_mod('coffeeshop_hero_subtitle', __('Discover our carefully selected coffee beans from around the world, crafted with passion and served with excellence.', 'coffeeshop'))); ?></p>
                    
                    <div class="hero-actions">
                        <?php
                        $menu_page = get_page_by_path('menu');
                        $contact_page = get_page_by_path('contact');
                        ?>
                        
                        <?php if ($menu_page) : ?>
                            <a href="<?php echo esc_url(get_permalink($menu_page->ID)); ?>" class="btn btn-primary">
                                <i class="fas fa-coffee" aria-hidden="true"></i>
                                <?php esc_html_e('View Menu', 'coffeeshop'); ?>
                            </a>
                        <?php endif; ?>
                        
                        <?php if ($contact_page) : ?>
                            <a href="<?php echo esc_url(get_permalink($contact_page->ID)); ?>" class="btn btn-secondary">
                                <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                                <?php esc_html_e('Visit Us', 'coffeeshop'); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Products Section -->
        <?php if (class_exists('WooCommerce') && get_theme_mod('coffeeshop_show_featured_products', true)) : ?>
            <section class="section">
                <div class="container">
                    <div class="section-header text-center">
                        <h2 class="section-title"><?php echo esc_html(get_theme_mod('coffeeshop_featured_products_title', __('Featured Products', 'coffeeshop'))); ?></h2>
                        <p class="section-subtitle"><?php echo esc_html(get_theme_mod('coffeeshop_featured_products_subtitle', __('Our most popular coffee selections', 'coffeeshop'))); ?></p>
                    </div>
                    
                    <?php
                    $featured_products = wc_get_featured_product_ids();
                    if (!empty($featured_products)) :
                        $args = array(
                            'post_type' => 'product',
                            'posts_per_page' => get_theme_mod('coffeeshop_featured_products_count', 6),
                            'post__in' => $featured_products,
                            'meta_query' => WC()->query->get_meta_query(),
                        );
                        
                        $featured_query = new WP_Query($args);
                        
                        if ($featured_query->have_posts()) : ?>
                            <div class="grid grid-3">
                                <?php while ($featured_query->have_posts()) : $featured_query->the_post(); ?>
                                    <?php wc_get_template_part('content', 'product'); ?>
                                <?php endwhile; ?>
                            </div>
                            
                            <div class="text-center mt-4">
                                <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="btn btn-outline">
                                    <?php esc_html_e('View All Products', 'coffeeshop'); ?>
                                    <i class="fas fa-arrow-right" aria-hidden="true"></i>
                                </a>
                            </div>
                        <?php endif;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </section>
        <?php endif; ?>

        <!-- About Section -->
        <?php if (get_theme_mod('coffeeshop_show_about_section', true)) : ?>
            <section class="section section-alt">
                <div class="container">
                    <div class="row align-center">
                        <div class="col">
                            <?php
                            $about_image = get_theme_mod('coffeeshop_about_image');
                            if ($about_image) : ?>
                                <div class="about-image">
                                    <img src="<?php echo esc_url($about_image); ?>" alt="<?php esc_attr_e('About Us', 'coffeeshop'); ?>" class="rounded-lg shadow">
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col">
                            <div class="about-content">
                                <h2><?php echo esc_html(get_theme_mod('coffeeshop_about_title', __('Our Story', 'coffeeshop'))); ?></h2>
                                <p><?php echo wp_kses_post(get_theme_mod('coffeeshop_about_content', __('We are passionate coffee enthusiasts dedicated to bringing you the finest coffee beans from around the world. Our journey began with a simple mission: to share exceptional coffee experiences with fellow coffee lovers.', 'coffeeshop'))); ?></p>
                                
                                <?php
                                $about_page = get_page_by_path('about');
                                if ($about_page) : ?>
                                    <a href="<?php echo esc_url(get_permalink($about_page->ID)); ?>" class="btn btn-primary">
                                        <?php esc_html_e('Learn More', 'coffeeshop'); ?>
                                        <i class="fas fa-arrow-right" aria-hidden="true"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <!-- Testimonials Section -->
        <?php if (get_theme_mod('coffeeshop_show_testimonials', true)) : ?>
            <section class="section">
                <div class="container">
                    <div class="section-header text-center">
                        <h2 class="section-title"><?php echo esc_html(get_theme_mod('coffeeshop_testimonials_title', __('What Our Customers Say', 'coffeeshop'))); ?></h2>
                        <p class="section-subtitle"><?php echo esc_html(get_theme_mod('coffeeshop_testimonials_subtitle', __('Real reviews from real coffee lovers', 'coffeeshop'))); ?></p>
                    </div>
                    
                    <?php
                    $testimonials = get_theme_mod('coffeeshop_testimonials', array(
                        array(
                            'name' => __('Sarah Johnson', 'coffeeshop'),
                            'position' => __('Coffee Enthusiast', 'coffeeshop'),
                            'content' => __('The best coffee shop in town! Their Ethiopian blend is absolutely amazing. The atmosphere is perfect for working or relaxing.', 'coffeeshop'),
                            'rating' => 5
                        ),
                        array(
                            'name' => __('Emma Davis', 'coffeeshop'),
                            'position' => __('Designer', 'coffeeshop'),
                            'content' => __('Love the cozy environment and friendly staff. Their latte art is Instagram-worthy and tastes even better!', 'coffeeshop'),
                            'rating' => 5
                        )
                    ));
                    
                    if (!empty($testimonials)) : ?>
                        <div class="grid grid-3">
                            <?php foreach ($testimonials as $testimonial) : ?>
                                <div class="card testimonial-card">
                                    <div class="card-content">
                                        <div class="testimonial-rating mb-2">
                                            <?php for ($i = 1; $i <= 5; $i++) : ?>
                                                <i class="fas fa-star <?php echo $i <= $testimonial['rating'] ? 'text-accent' : 'text-gray-300'; ?>" aria-hidden="true"></i>
                                            <?php endfor; ?>
                                        </div>
                                        <blockquote class="testimonial-content">
                                            <p>"<?php echo esc_html($testimonial['content']); ?>"</p>
                                        </blockquote>
                                        <div class="testimonial-author">
                                            <h4 class="author-name"><?php echo esc_html($testimonial['name']); ?></h4>
                                            <p class="author-position text-gray-500"><?php echo esc_html($testimonial['position']); ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        <?php endif; ?>

        <!-- Blog Section -->
        <?php if (get_theme_mod('coffeeshop_show_blog_section', true)) : ?>
            <section class="section section-alt">
                <div class="container">
                    <div class="section-header text-center">
                        <h2 class="section-title"><?php echo esc_html(get_theme_mod('coffeeshop_blog_title', __('Latest News & Articles', 'coffeeshop'))); ?></h2>
                        <p class="section-subtitle"><?php echo esc_html(get_theme_mod('coffeeshop_blog_subtitle', __('Stay updated with coffee tips, news, and stories', 'coffeeshop'))); ?></p>
                    </div>
                    
                    <?php
                    $blog_args = array(
                        'post_type' => 'post',
                        'posts_per_page' => get_theme_mod('coffeeshop_blog_posts_count', 3),
                        'post_status' => 'publish',
                        'ignore_sticky_posts' => true
                    );
                    
                    $blog_query = new WP_Query($blog_args);
                    
                    if ($blog_query->have_posts()) : ?>
                        <div class="grid grid-3">
                            <?php while ($blog_query->have_posts()) : $blog_query->the_post(); ?>
                                <article <?php post_class('card post-card'); ?>>
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="post-featured-image">
                                            <a href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
                                                <?php the_post_thumbnail('coffeeshop-featured', array('class' => 'card-image')); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="post-content card-content">
                                        <div class="post-meta">
                                            <span><i class="fas fa-calendar" aria-hidden="true"></i> <?php echo get_the_date(); ?></span>
                                            <span><i class="fas fa-user" aria-hidden="true"></i> <?php the_author(); ?></span>
                                            <?php if (has_category()) : ?>
                                                <span><i class="fas fa-folder" aria-hidden="true"></i> <?php the_category(', '); ?></span>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <h3 class="post-title card-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h3>
                                        
                                        <div class="post-excerpt card-text">
                                            <?php the_excerpt(); ?>
                                        </div>
                                        
                                        <a href="<?php the_permalink(); ?>" class="read-more">
                                            <?php esc_html_e('Read More', 'coffeeshop'); ?>
                                            <i class="fas fa-arrow-right" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </article>
                            <?php endwhile; ?>
                        </div>
                        
                        <div class="text-center mt-4">
                            <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="btn btn-outline">
                                <?php esc_html_e('View All Articles', 'coffeeshop'); ?>
                                <i class="fas fa-arrow-right" aria-hidden="true"></i>
                            </a>
                        </div>
                    <?php endif;
                    wp_reset_postdata();
                    ?>
                </div>
            </section>
        <?php endif; ?>

    <?php else : ?>
        
        <!-- Regular Blog/Archive Content -->
        <div class="container">
            <div class="content-area">
                
                <?php if (is_search()) : ?>
                    <header class="page-header">
                        <h1 class="page-title">
                            <?php
                            printf(
                                /* translators: %s: search query. */
                                esc_html__('Search Results for: %s', 'coffeeshop'),
                                '<span>' . get_search_query() . '</span>'
                            );
                            ?>
                        </h1>
                        
                        <div class="search-form-container">
                            <?php get_search_form(); ?>
                        </div>
                    </header>
                <?php elseif (is_archive()) : ?>
                    <header class="page-header">
                        <?php the_archive_title('<h1 class="page-title">', '</h1>'); ?>
                        <?php the_archive_description('<div class="archive-description">', '</div>'); ?>
                    </header>
                <?php endif; ?>

                <?php if (have_posts()) : ?>
                    
                    <div class="post-grid">
                        <?php while (have_posts()) : the_post(); ?>
                            
                            <article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>
                                
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="post-featured-image">
                                        <a href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
                                            <?php the_post_thumbnail('coffeeshop-featured'); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="post-content">
                                    <div class="post-meta">
                                        <span><i class="fas fa-calendar" aria-hidden="true"></i> <?php echo get_the_date(); ?></span>
                                        <span><i class="fas fa-user" aria-hidden="true"></i> <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"><?php the_author(); ?></a></span>
                                        <?php if (has_category()) : ?>
                                            <span><i class="fas fa-folder" aria-hidden="true"></i> <?php the_category(', '); ?></span>
                                        <?php endif; ?>
                                        <?php if (comments_open() || get_comments_number()) : ?>
                                            <span><i class="fas fa-comments" aria-hidden="true"></i> <a href="<?php comments_link(); ?>"><?php comments_number(__('No Comments', 'coffeeshop'), __('1 Comment', 'coffeeshop'), __('% Comments', 'coffeeshop')); ?></a></span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <h2 class="post-title">
                                        <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
                                    </h2>
                                    
                                    <div class="post-excerpt">
                                        <?php
                                        if (has_excerpt()) {
                                            the_excerpt();
                                        } else {
                                            echo wp_trim_words(get_the_content(), get_theme_mod('coffeeshop_excerpt_length', 25), '...');
                                        }
                                        ?>
                                    </div>
                                    
                                    <?php if (has_tag()) : ?>
                                        <div class="post-tags">
                                            <i class="fas fa-tags" aria-hidden="true"></i>
                                            <?php the_tags('', ', '); ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <a href="<?php the_permalink(); ?>" class="read-more" aria-label="<?php printf(__('Read more about %s', 'coffeeshop'), get_the_title()); ?>">
                                        <?php esc_html_e('Read More', 'coffeeshop'); ?>
                                        <i class="fas fa-arrow-right" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </article>
                            
                        <?php endwhile; ?>
                    </div>

                    <?php
                    // Pagination
                    the_posts_pagination(array(
                        'mid_size'  => 2,
                        'prev_text' => '<i class="fas fa-chevron-left"></i> ' . __('Previous', 'coffeeshop'),
                        'next_text' => __('Next', 'coffeeshop') . ' <i class="fas fa-chevron-right"></i>',
                        'before_page_number' => '<span class="screen-reader-text">' . __('Page', 'coffeeshop') . ' </span>',
                    ));
                    ?>

                <?php else : ?>
                    
                    <section class="no-results not-found">
                        <header class="page-header">
                            <h1 class="page-title"><?php esc_html_e('Nothing here', 'coffeeshop'); ?></h1>
                        </header>

                        <div class="page-content">
                            <?php if (is_home() && current_user_can('publish_posts')) : ?>
                                
                                <p>
                                    <?php
                                    printf(
                                        wp_kses(
                                            /* translators: 1: link to WP admin new post page. */
                                            __('Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'coffeeshop'),
                                            array(
                                                'a' => array(
                                                    'href' => array(),
                                                ),
                                            )
                                        ),
                                        esc_url(admin_url('post-new.php'))
                                    );
                                    ?>
                                </p>
                                
                            <?php elseif (is_search()) : ?>
                                
                                <p><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'coffeeshop'); ?></p>
                                <?php get_search_form(); ?>
                                
                            <?php else : ?>
                                
                                <p><?php esc_html_e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'coffeeshop'); ?></p>
                                <?php get_search_form(); ?>
                                
                            <?php endif; ?>
                        </div>
                    </section>
                    
                <?php endif; ?>
                
            </div>

            <?php get_sidebar(); ?>
            
        </div>
        
    <?php endif; ?>

</main>

<?php
get_sidebar();
get_footer();
?>
                        ),
                        array(
                            'name' => __('Mike Chen', 'coffeeshop'),
                            'position' => __('Local Business Owner', 'coffeeshop'),
                            'content' => __('I start every morning here. The baristas know their craft and the quality is consistently excellent. Highly recommended!', 'coffeeshop'),
                            'rating' => 5