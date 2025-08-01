<?php
/**
 * The template for displaying archive pages
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container">
        
        <?php if (have_posts()) : ?>
            
            <header class="page-header">
                <?php
                the_archive_title('<h1 class="page-title">', '</h1>');
                the_archive_description('<div class="archive-description">', '</div>');
                ?>
            </header>

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
                                <?php if (has_category()) : ?>
                                    <span><i class="fas fa-folder"></i> <?php the_category(', '); ?></span>
                                <?php endif; ?>
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
            the_posts_pagination(array(
                'mid_size'  => 2,
                'prev_text' => '<i class="fas fa-chevron-left"></i> ' . __('Previous', 'coffeeshop'),
                'next_text' => __('Next', 'coffeeshop') . ' <i class="fas fa-chevron-right"></i>',
            ));
            ?>

        <?php else : ?>
            
            <section class="no-results not-found">
                <header class="page-header">
                    <h1 class="page-title"><?php esc_html_e('Nothing here', 'coffeeshop'); ?></h1>
                </header>

                <div class="page-content">
                    <p><?php esc_html_e('It seems we can&rsquo;t find what you&rsquo;re looking for.', 'coffeeshop'); ?></p>
                    <?php get_search_form(); ?>
                </div>
            </section>
            
        <?php endif; ?>
        
    </div>
</main>

<?php
get_sidebar();
get_footer();