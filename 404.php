<?php
/**
 * The template for displaying 404 pages (not found)
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container">
        
        <section class="error-404 not-found">
            <header class="page-header">
                <h1 class="page-title"><?php esc_html_e('Oops! That page can&rsquo;t be found.', 'coffeeshop'); ?></h1>
            </header>

            <div class="page-content">
                <p><?php esc_html_e('It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'coffeeshop'); ?></p>

                <?php get_search_form(); ?>

                <div class="widget-area">
                    <?php if (is_active_sidebar('sidebar-1')) : ?>
                        <?php dynamic_sidebar('sidebar-1'); ?>
                    <?php endif; ?>
                </div>

                <?php
                $recent_posts = wp_get_recent_posts(array(
                    'numberposts' => 5,
                    'post_status' => 'publish',
                ), OBJECT);

                if (!empty($recent_posts)) : ?>
                    <div class="recent-posts">
                        <h2><?php esc_html_e('Recent Posts', 'coffeeshop'); ?></h2>
                        <ul>
                            <?php foreach ($recent_posts as $post) : ?>
                                <li>
                                    <a href="<?php echo esc_url(get_permalink($post->ID)); ?>">
                                        <?php echo esc_html($post->post_title); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

            </div>
        </section>
        
    </div>
</main>

<?php
get_footer();