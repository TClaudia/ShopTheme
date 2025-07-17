

<?php
/**
 * The template for displaying all single posts
 *
 * @package CoffeeShop
 */

get_header();
?>

<main id="main" class="site-main">
    <div class="container">
        <div class="content-wrapper">
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <?php
                    if (is_singular()) :
                        the_title('<h1 class="entry-title">', '</h1>');
                    else :
                        the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
                    endif;
                    ?>
                    
                    <div class="entry-meta">
                        <?php
                        coffeeshop_posted_on();
                        coffeeshop_posted_by();
                        ?>
                    </div>
                </header>

                <?php if (has_post_thumbnail()) : ?>
                    <div class="entry-thumbnail">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>

                <div class="entry-content">
                    <?php
                    the_content(sprintf(
                        wp_kses(
                            /* translators: %s: Name of current post. Only visible to screen readers */
                            __('Continue reading<span class="screen-reader-text"> "%s"</span>', 'coffeeshop'),
                            array(
                                'span' => array(
                                    'class' => array(),
                                ),
                            )
                        ),
                        get_the_title()
                    ));

                    wp_link_pages(array(
                        'before' => '<div class="page-links">' . esc_html__('Pages:', 'coffeeshop'),
                        'after'  => '</div>',
                    ));
                    ?>
                </div>

                <footer class="entry-footer">
                    <?php
                    // Entry footer content
                    $categories_list = get_the_category_list(esc_html__(', ', 'coffeeshop'));
                    if ($categories_list) {
                        printf('<span class="cat-links">' . esc_html__('Posted in %1$s', 'coffeeshop') . '</span>', $categories_list);
                    }

                    $tags_list = get_the_tag_list('', esc_html_x(', ', 'list item separator', 'coffeeshop'));
                    if ($tags_list) {
                        printf('<span class="tags-links">' . esc_html__('Tagged %1$s', 'coffeeshop') . '</span>', $tags_list);
                    }
                    ?>
                </footer>
            </article>

            <?php
            // If comments are open or we have at least one comment, load up the comment template.
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;
            ?>
        </div>
    </div>
</main>

<?php
get_footer();