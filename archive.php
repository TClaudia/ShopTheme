

<?php
/**
 * The template for displaying archive pages
 *
 * @package CoffeeShop
 */

get_header();
?>

<main id="main" class="site-main">
    <div class="container">
        <div class="content-wrapper">
            <?php if (have_posts()) : ?>
                <header class="page-header">
                    <?php
                    the_archive_title('<h1 class="page-title">', '</h1>');
                    the_archive_description('<div class="archive-description">', '</div>');
                    ?>
                </header>

                <div class="posts-grid">
                    <?php
                    while (have_posts()) :
                        the_post();
                        ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="post-thumbnail">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('coffeeshop-featured'); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <div class="post-content">
                                <header class="entry-header">
                                    <?php the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>'); ?>
                                </header>

                                <div class="entry-summary">
                                    <?php the_excerpt(); ?>
                                </div>

                                <div class="entry-meta">
                                    <?php
                                    coffeeshop_posted_on();
                                    coffeeshop_posted_by();
                                    ?>
                                </div>
                            </div>
                        </article>
                        <?php
                    endwhile;
                    ?>
                </div>

                <?php
                the_posts_navigation();
            else :
                ?>
                <section class="no-results not-found">
                    <header class="page-header">
                        <h1 class="page-title"><?php esc_html_e('Nothing here', 'coffeeshop'); ?></h1>
                    </header>
                    <div class="page-content">
                        <p><?php esc_html_e('It looks like nothing was found at this location. Maybe try a search?', 'coffeeshop'); ?></p>
                        <?php get_search_form(); ?>
                    </div>
                </section>
                <?php
            endif;
            ?>
        </div>
    </div>
</main>

<?php
get_footer();