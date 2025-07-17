

// ====================
// COMMENTS.PHP
// ====================

<?php
/**
 * The template for displaying comments
 *
 * @package CoffeeShop
 */

if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">
    <?php if (have_comments()) : ?>
        <h2 class="comments-title">
            <?php
            $coffeeshop_comment_count = get_comments_number();
            if ('1' === $coffeeshop_comment_count) {
                printf(
                    /* translators: 1: title. */
                    esc_html__('One thought on &ldquo;%1$s&rdquo;', 'coffeeshop'),
                    '<span>' . get_the_title() . '</span>'
                );
            } else {
                printf(
                    /* translators: 1: comment count number, 2: title. */
                    esc_html(_nx('%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $coffeeshop_comment_count, 'comments title', 'coffeeshop')),
                    number_format_i18n($coffeeshop_comment_count),
                    '<span>' . get_the_title() . '</span>'
                );
            }
            ?>
        </h2>

        <ol class="comment-list">
            <?php
            wp_list_comments(array(
                'style'      => 'ol',
                'short_ping' => true,
                'callback'   => 'coffeeshop_comment_callback',
            ));
            ?>
        </ol>

        <?php
        the_comments_navigation();

        // If comments are closed and there are comments, let's leave a little note, shall we?
        if (!comments_open()) :
            ?>
            <p class="no-comments"><?php esc_html_e('Comments are closed.', 'coffeeshop'); ?></p>
            <?php
        endif;

    endif; // Check for have_comments().

    comment_form();
    ?>
</div><!-- #comments -->

// ====================
// 404.PHP
// ====================

<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package CoffeeShop
 */

get_header();
?>

<main id="main" class="site-main">
    <div class="container">
        <div class="error-404 not-found">
            <header class="page-header">
                <h1 class="page-title"><?php esc_html_e('Oops! That page can&rsquo;t be found.', 'coffeeshop'); ?></h1>
            </header>

            <div class="page-content">
                <p><?php esc_html_e('It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'coffeeshop'); ?></p>

                <?php get_search_form(); ?>

                <?php if (class_exists('WooCommerce')) : ?>
                    <div class="widget widget_product_categories">
                        <h2 class="widget-title"><?php esc_html_e('Product Categories', 'coffeeshop'); ?></h2>
                        <ul>
                            <?php
                            wp_list_categories(array(
                                'orderby'    => 'count',
                                'order'      => 'DESC',
                                'show_count' => 1,
                                'title_li'   => '',
                                'number'     => 10,
                                'taxonomy'   => 'product_cat',
                            ));
                            ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php
                /* translators: %1$s: smiley */
                $coffeeshop_archive_content = '<p>' . sprintf(esc_html__('Try looking in the monthly archives. %1$s', 'coffeeshop'), convert_smilies(':)')) . '</p>';
                the_widget('WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$coffeeshop_archive_content");

                the_widget('WP_Widget_Tag_Cloud');
                ?>
            </div>
        </div>
    </div>
</main>

<?php
get_footer();
