<?php
/**
 * The template for displaying search results pages
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container">
        
        <header class="page-header">
            <h1 class="page-title">
                <?php
                printf(
                    esc_html__('Search Results for: %s', 'coffeeshop'),
                    '<span>' . get_search_query() . '</span>'
                );
                ?>
            </h1>
            
            <div class="search-form-container">
                <?php get_search_form(); ?>
            </div>
        </header>

        <?php if (have_posts()) : ?>
            
            <div class="post-grid">
                <?php while (have_posts()) : the_post(); ?>
                    
                    <article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>
                        
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="post-featured-image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('coffeeshop-featured'); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <div class="post-content">
                            <div class="post-meta">
                                <span><i class="fas fa-calendar"></i> <?php echo get_the_date(); ?></span>
                                <span><i class="fas fa-user"></i> <?php the_author(); ?></span>
                                <span><i class="fas fa-folder"></i> <?php echo get_post_type(); ?></span>
                            </div>
                            
                            <h2 class="post-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            
                            <div class="post-excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                            
                            <a href="<?php the_permalink(); ?>" class="read-more">
                                <?php esc_html_e('Read More', 'coffeeshop'); ?>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </article>
                    
                <?php endwhile; ?>
            </div>

            <?php
            the_posts_pagination();
            ?>

        <?php else : ?>
            
            <section class="no-results not-found">
                <header class="page-header">
                    <h1 class="page-title"><?php esc_html_e('Nothing found', 'coffeeshop'); ?></h1>
                </header>

                <div class="page-content">
                    <p><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'coffeeshop'); ?></p>
                    <?php get_search_form(); ?>
                </div>
            </section>
            
        <?php endif; ?>
        
    </div>
</main>

<?php
get_sidebar();
get_footer();