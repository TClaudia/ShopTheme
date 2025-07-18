<?php
/**
 * Custom template tags for this theme
 *
 * @package CoffeeShop
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit('Direct access forbidden.');
}

if (!function_exists('coffeeshop_posted_on')) :
    /**
     * Prints HTML with meta information for the current post-date/time.
     */
    function coffeeshop_posted_on() {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if (get_the_time('U') !== get_the_modified_time('U')) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf($time_string,
            esc_attr(get_the_date(DATE_W3C)),
            esc_html(get_the_date()),
            esc_attr(get_the_modified_date(DATE_W3C)),
            esc_html(get_the_modified_date())
        );

        $posted_on = sprintf(
            /* translators: %s: post date. */
            esc_html_x('Posted on %s', 'post date', 'coffeeshop'),
            '<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>'
        );

        echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
endif;

if (!function_exists('coffeeshop_posted_by')) :
    /**
     * Prints HTML with meta information for the current author.
     */
    function coffeeshop_posted_by() {
        $byline = sprintf(
            /* translators: %s: post author. */
            esc_html_x('by %s', 'post author', 'coffeeshop'),
            '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>'
        );

        echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
endif;

if (!function_exists('coffeeshop_entry_footer')) :
    /**
     * Prints HTML with meta information for the categories, tags and comments.
     */
    function coffeeshop_entry_footer() {
        // Hide category and tag text for pages.
        if ('post' === get_post_type()) {
            /* translators: used between list items, there is a space after the comma */
            $categories_list = get_the_category_list(esc_html__(', ', 'coffeeshop'));
            if ($categories_list) {
                /* translators: 1: list of categories. */
                printf('<span class="cat-links">' . esc_html__('Posted in %1$s', 'coffeeshop') . '</span>', $categories_list); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            }

            /* translators: used between list items, there is a space after the comma */
            $tags_list = get_the_tag_list('', esc_html_x(', ', 'list item separator', 'coffeeshop'));
            if ($tags_list) {
                /* translators: 1: list of tags. */
                printf('<span class="tags-links">' . esc_html__('Tagged %1$s', 'coffeeshop') . '</span>', $tags_list); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            }
        }

        if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
            echo '<span class="comments-link">';
            comments_popup_link(
                sprintf(
                    wp_kses(
                        /* translators: %s: post title */
                        __('Leave a Comment<span class="screen-reader-text"> on %s</span>', 'coffeeshop'),
                        array(
                            'span' => array(
                                'class' => array(),
                            ),
                        )
                    ),
                    wp_kses_post(get_the_title())
                )
            );
            echo '</span>';
        }

        edit_post_link(
            sprintf(
                wp_kses(
                    /* translators: %s: Name of current post. Only visible to screen readers */
                    __('Edit <span class="screen-reader-text">"%s"</span>', 'coffeeshop'),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                wp_kses_post(get_the_title())
            ),
            '<span class="edit-link">',
            '</span>'
        );
    }
endif;

if (!function_exists('coffeeshop_post_thumbnail')) :
    /**
     * Displays an optional post thumbnail.
     */
    function coffeeshop_post_thumbnail() {
        if (post_password_required() || is_attachment() || !has_post_thumbnail()) {
            return;
        }

        if (is_singular()) :
            ?>
            <div class="post-thumbnail">
                <?php the_post_thumbnail(); ?>
            </div><!-- .post-thumbnail -->
        <?php else : ?>
            <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                <?php
                the_post_thumbnail('post-thumbnail', array(
                    'alt' => the_title_attribute(array(
                        'echo' => false,
                    )),
                ));
                ?>
            </a>
            <?php
        endif; // End is_singular().
    }
endif;

if (!function_exists('wp_body_open')) :
    /**
     * Shim for sites older than 5.2.
     */
    function wp_body_open() {
        do_action('wp_body_open');
    }
endif;

if (!function_exists('coffeeshop_fallback_menu')) :
    /**
     * Fallback menu when no menu is assigned
     */
    function coffeeshop_fallback_menu() {
        echo '<ul class="primary-menu">';
        echo '<li><a href="' . esc_url(home_url('/')) . '">' . esc_html__('Home', 'coffeeshop') . '</a></li>';
        
        // Show pages
        $pages = get_pages(array('sort_column' => 'menu_order'));
        foreach ($pages as $page) {
            echo '<li><a href="' . esc_url(get_permalink($page->ID)) . '">' . esc_html($page->post_title) . '</a></li>';
        }
        
        if (current_user_can('manage_options')) {
            echo '<li><a href="' . esc_url(admin_url('nav-menus.php')) . '">' . esc_html__('Add Menu', 'coffeeshop') . '</a></li>';
        }
        echo '</ul>';
    }
endif;

if (!function_exists('coffeeshop_comment')) :
    /**
     * Template for comments and pingbacks.
     */
    function coffeeshop_comment($comment, $args, $depth) {
        if ('pingback' == $comment->comment_type || 'trackback' == $comment->comment_type) : ?>
            <li id="comment-<?php comment_ID(); ?>" <?php comment_class('pingback'); ?>>
                <div class="comment-body">
                    <?php esc_html_e('Pingback:', 'coffeeshop'); ?> <?php comment_author_link(); ?> <?php edit_comment_link(esc_html__('Edit', 'coffeeshop'), '<span class="edit-link">', '</span>'); ?>
                </div>
        <?php else : ?>
            <li id="comment-<?php comment_ID(); ?>" <?php comment_class(empty($args['has_children']) ? '' : 'parent'); ?>>
                <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
                    <footer class="comment-meta">
                        <div class="comment-author vcard">
                            <?php if (0 != $args['avatar_size']) echo get_avatar($comment, $args['avatar_size']); ?>
                            <?php printf(__('<b class="fn">%s</b> <span class="says">says:</span>', 'coffeeshop'), get_comment_author_link()); ?>
                        </div><!-- .comment-author -->

                        <div class="comment-metadata">
                            <a href="<?php echo esc_url(get_comment_link($comment, $args)); ?>">
                                <time datetime="<?php comment_time('c'); ?>">
                                    <?php printf(esc_html__('%1$s at %2$s', 'coffeeshop'), get_comment_date(), get_comment_time()); ?>
                                </time>
                            </a>
                            <?php edit_comment_link(esc_html__('Edit', 'coffeeshop'), '<span class="edit-link">', '</span>'); ?>
                        </div><!-- .comment-metadata -->

                        <?php if ('0' == $comment->comment_approved) : ?>
                            <p class="comment-awaiting-moderation"><?php esc_html_e('Your comment is awaiting moderation.', 'coffeeshop'); ?></p>
                        <?php endif; ?>
                    </footer><!-- .comment-meta -->

                    <div class="comment-content">
                        <?php comment_text(); ?>
                    </div><!-- .comment-content -->

                    <?php
                    comment_reply_link(array_merge($args, array(
                        'add_below' => 'div-comment',
                        'depth' => $depth,
                        'max_depth' => $args['max_depth'],
                        'before' => '<div class="reply">',
                        'after' => '</div>',
                    )));
                    ?>
                </article><!-- .comment-body -->
        <?php endif;
    }
endif;

if (!function_exists('coffeeshop_social_links')) :
    /**
     * Display social media links
     */
    function coffeeshop_social_links() {
        $social_links = array(
            'facebook' => get_theme_mod('coffeeshop_facebook_url'),
            'twitter' => get_theme_mod('coffeeshop_twitter_url'),
            'instagram' => get_theme_mod('coffeeshop_instagram_url'),
            'youtube' => get_theme_mod('coffeeshop_youtube_url'),
            'linkedin' => get_theme_mod('coffeeshop_linkedin_url'),
        );

        $social_links = array_filter($social_links); // Remove empty values

        if (!empty($social_links)) {
            echo '<div class="social-links">';
            foreach ($social_links as $platform => $url) {
                echo '<a href="' . esc_url($url) . '" target="_blank" rel="nofollow noopener" aria-label="' . esc_attr(ucfirst($platform)) . '">';
                echo '<i class="fab fa-' . esc_attr($platform) . '" aria-hidden="true"></i>';
                echo '</a>';
            }
            echo '</div>';
        }
    }
endif;

if (!function_exists('coffeeshop_breadcrumbs')) :
    /**
     * Display breadcrumb navigation
     */
    function coffeeshop_breadcrumbs() {
        if (is_front_page()) {
            return;
        }

        $separator = '<span class="breadcrumb-separator"> / </span>';
        $home_title = esc_html__('Home', 'coffeeshop');

        echo '<nav class="breadcrumbs" aria-label="' . esc_attr__('Breadcrumb Navigation', 'coffeeshop') . '">';
        echo '<ol class="breadcrumb-list">';
        echo '<li><a href="' . esc_url(home_url('/')) . '">' . $home_title . '</a></li>';

        if (is_category() || is_single()) {
            if (is_single()) {
                $categories = get_the_category();
                if (!empty($categories)) {
                    $category = $categories[0];
                    echo '<li>' . $separator . '<a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a></li>';
                }
                echo '<li>' . $separator . '<span class="current">' . get_the_title() . '</span></li>';
            } else {
                echo '<li>' . $separator . '<span class="current">' . single_cat_title('', false) . '</span></li>';
            }
        } elseif (is_page()) {
            $parent_id = wp_get_post_parent_id(get_the_ID());
            if ($parent_id) {
                $breadcrumbs = array();
                while ($parent_id) {
                    $page = get_page($parent_id);
                    $breadcrumbs[] = '<a href="' . esc_url(get_permalink($page->ID)) . '">' . esc_html(get_the_title($page->ID)) . '</a>';
                    $parent_id = $page->post_parent;
                }
                $breadcrumbs = array_reverse($breadcrumbs);
                foreach ($breadcrumbs as $crumb) {
                    echo '<li>' . $separator . $crumb . '</li>';
                }
            }
            echo '<li>' . $separator . '<span class="current">' . get_the_title() . '</span></li>';
        } elseif (is_search()) {
            echo '<li>' . $separator . '<span class="current">' . esc_html__('Search Results', 'coffeeshop') . '</span></li>';
        } elseif (is_404()) {
            echo '<li>' . $separator . '<span class="current">' . esc_html__('404 Error', 'coffeeshop') . '</span></li>';
        } elseif (is_archive()) {
            echo '<li>' . $separator . '<span class="current">' . get_the_archive_title() . '</span></li>';
        }

        echo '</ol>';
        echo '</nav>';
    }
endif;

if (!function_exists('coffeeshop_get_reading_time')) :
    /**
     * Calculate reading time for a post
     */
    function coffeeshop_get_reading_time($post_id = null) {
        if (!$post_id) {
            $post_id = get_the_ID();
        }

        $content = get_post_field('post_content', $post_id);
        $word_count = str_word_count(wp_strip_all_tags($content));
        $reading_time = ceil($word_count / 200); // Assuming 200 words per minute

        if ($reading_time == 1) {
            return esc_html__('1 min read', 'coffeeshop');
        } else {
            return sprintf(esc_html__('%d min read', 'coffeeshop'), $reading_time);
        }
    }
endif;

if (!function_exists('coffeeshop_post_meta')) :
    /**
     * Display post meta information
     */
    function coffeeshop_post_meta() {
        echo '<div class="post-meta">';
        
        // Date
        echo '<span class="post-date">';
        echo '<i class="fas fa-calendar" aria-hidden="true"></i> ';
        echo '<a href="' . esc_url(get_permalink()) . '">' . esc_html(get_the_date()) . '</a>';
        echo '</span>';
        
        // Author
        echo '<span class="post-author">';
        echo '<i class="fas fa-user" aria-hidden="true"></i> ';
        echo '<a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a>';
        echo '</span>';
        
        // Categories
        if (has_category()) {
            echo '<span class="post-categories">';
            echo '<i class="fas fa-folder" aria-hidden="true"></i> ';
            the_category(', ');
            echo '</span>';
        }
        
        // Reading time
        echo '<span class="reading-time">';
        echo '<i class="fas fa-clock" aria-hidden="true"></i> ';
        echo coffeeshop_get_reading_time();
        echo '</span>';
        
        // Comments
        if (comments_open() || get_comments_number()) {
            echo '<span class="post-comments">';
            echo '<i class="fas fa-comments" aria-hidden="true"></i> ';
            comments_popup_link(
                esc_html__('No Comments', 'coffeeshop'),
                esc_html__('1 Comment', 'coffeeshop'),
                esc_html__('% Comments', 'coffeeshop')
            );
            echo '</span>';
        }
        
        echo '</div>';
    }
endif;

if (!function_exists('coffeeshop_pagination')) :
    /**
     * Display pagination
     */
    function coffeeshop_pagination() {
        the_posts_pagination(array(
            'mid_size'  => 2,
            'prev_text' => '<i class="fas fa-chevron-left"></i> ' . esc_html__('Previous', 'coffeeshop'),
            'next_text' => esc_html__('Next', 'coffeeshop') . ' <i class="fas fa-chevron-right"></i>',
            'before_page_number' => '<span class="screen-reader-text">' . esc_html__('Page', 'coffeeshop') . ' </span>',
        ));
    }
endif;

if (!function_exists('coffeeshop_post_navigation')) :
    /**
     * Display post navigation
     */
    function coffeeshop_post_navigation() {
        the_post_navigation(array(
            'prev_text' => '<span class="nav-subtitle">' . esc_html__('Previous Post:', 'coffeeshop') . '</span> <span class="nav-title">%title</span>',
            'next_text' => '<span class="nav-subtitle">' . esc_html__('Next Post:', 'coffeeshop') . '</span> <span class="nav-title">%title</span>',
        ));
    }
endif;

if (!function_exists('coffeeshop_archive_title')) :
    /**
     * Display archive title
     */
    function coffeeshop_archive_title() {
        if (is_category()) {
            echo '<h1 class="archive-title">' . esc_html(single_cat_title('', false)) . '</h1>';
        } elseif (is_tag()) {
            echo '<h1 class="archive-title">' . esc_html(single_tag_title('', false)) . '</h1>';
        } elseif (is_author()) {
            echo '<h1 class="archive-title">' . esc_html(get_the_author()) . '</h1>';
        } elseif (is_date()) {
            if (is_month()) {
                echo '<h1 class="archive-title">' . esc_html(get_the_date('F Y')) . '</h1>';
            } elseif (is_year()) {
                echo '<h1 class="archive-title">' . esc_html(get_the_date('Y')) . '</h1>';
            } else {
                echo '<h1 class="archive-title">' . esc_html(get_the_date()) . '</h1>';
            }
        } else {
            echo '<h1 class="archive-title">' . esc_html__('Archives', 'coffeeshop') . '</h1>';
        }
    }
endif;

if (!function_exists('coffeeshop_get_attachment_caption')) :
    /**
     * Get attachment caption
     */
    function coffeeshop_get_attachment_caption($attachment_id = null) {
        if (!$attachment_id) {
            $attachment_id = get_the_ID();
        }
        
        $caption = wp_get_attachment_caption($attachment_id);
        if ($caption) {
            return '<figcaption class="wp-caption-text">' . wp_kses_post($caption) . '</figcaption>';
        }
        
        return '';
    }
endif;

if (!function_exists('coffeeshop_link_pages')) :
    /**
     * Display page links for paginated posts
     */
    function coffeeshop_link_pages() {
        wp_link_pages(array(
            'before' => '<div class="page-links">' . esc_html__('Pages:', 'coffeeshop'),
            'after'  => '</div>',
            'link_before' => '<span class="page-number">',
            'link_after'  => '</span>',
        ));
    }
endif;

if (!function_exists('coffeeshop_search_form')) :
    /**
     * Custom search form
     */
    function coffeeshop_search_form() {
        $search_form = '<form role="search" method="get" class="search-form" action="' . esc_url(home_url('/')) . '">
            <label>
                <span class="screen-reader-text">' . esc_html__('Search for:', 'coffeeshop') . '</span>
                <input type="search" class="search-field" placeholder="' . esc_attr__('Search...', 'coffeeshop') . '" value="' . get_search_query() . '" name="s" />
            </label>
            <button type="submit" class="search-submit">
                <i class="fas fa-search" aria-hidden="true"></i>
                <span class="screen-reader-text">' . esc_html__('Search', 'coffeeshop') . '</span>
            </button>
        </form>';
        
        return $search_form;
    }
endif;

if (!function_exists('coffeeshop_post_tags')) :
    /**
     * Display post tags
     */
    function coffeeshop_post_tags() {
        if (has_tag()) {
            echo '<div class="post-tags">';
            echo '<span class="tags-label">' . esc_html__('Tags:', 'coffeeshop') . '</span>';
            the_tags('<span class="tag-list">', ', ', '</span>');
            echo '</div>';
        }
    }
endif;

if (!function_exists('coffeeshop_author_bio')) :
    /**
     * Display author bio
     */
    function coffeeshop_author_bio() {
        if (is_single() && get_the_author_meta('description')) {
            echo '<div class="author-bio">';
            echo '<div class="author-avatar">';
            echo get_avatar(get_the_author_meta('ID'), 80);
            echo '</div>';
            echo '<div class="author-info">';
            echo '<h3 class="author-name">' . esc_html(get_the_author()) . '</h3>';
            echo '<p class="author-description">' . wp_kses_post(get_the_author_meta('description')) . '</p>';
            echo '<a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '" class="author-link">';
            echo esc_html__('View all posts by', 'coffeeshop') . ' ' . esc_html(get_the_author());
            echo '</a>';
            echo '</div>';
            echo '</div>';
        }
    }
endif;

if (!function_exists('coffeeshop_related_posts')) :
    /**
     * Display related posts
     */
    function coffeeshop_related_posts($posts_per_page = 3) {
        if (!is_single()) {
            return;
        }
        
        global $post;
        
        $categories = get_the_category($post->ID);
        if (empty($categories)) {
            return;
        }
        
        $category_ids = wp_list_pluck($categories, 'term_id');
        
        $related_posts = get_posts(array(
            'category__in' => $category_ids,
            'post__not_in' => array($post->ID),
            'posts_per_page' => $posts_per_page,
            'post_status' => 'publish',
            'orderby' => 'rand',
        ));
        
        if (empty($related_posts)) {
            return;
        }
        
        echo '<div class="related-posts">';
        echo '<h3 class="related-posts-title">' . esc_html__('Related Posts', 'coffeeshop') . '</h3>';
        echo '<div class="related-posts-grid">';
        
        foreach ($related_posts as $related_post) {
            setup_postdata($related_post);
            echo '<article class="related-post">';
            
            if (has_post_thumbnail($related_post->ID)) {
                echo '<div class="related-post-thumbnail">';
                echo '<a href="' . esc_url(get_permalink($related_post->ID)) . '">';
                echo get_the_post_thumbnail($related_post->ID, 'coffeeshop-thumb');
                echo '</a>';
                echo '</div>';
            }
            
            echo '<div class="related-post-content">';
            echo '<h4 class="related-post-title">';
            echo '<a href="' . esc_url(get_permalink($related_post->ID)) . '">' . esc_html(get_the_title($related_post->ID)) . '</a>';
            echo '</h4>';
            echo '<div class="related-post-meta">';
            echo '<span class="related-post-date">' . esc_html(get_the_date('', $related_post->ID)) . '</span>';
            echo '</div>';
            echo '</div>';
            
            echo '</article>';
        }
        
        wp_reset_postdata();
        
        echo '</div>';
        echo '</div>';
    }
endif;

if (!function_exists('coffeeshop_get_svg')) :
    /**
     * Get SVG icon
     */
    function coffeeshop_get_svg($icon_name, $size = 24) {
        $icons = array(
            'coffee' => '<svg xmlns="http://www.w3.org/2000/svg" width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="currentColor"><path d="M2 21h18v-2H2v2zm1.15-4.05L4 15.47l.85 1.48L3.5 17.4c-.8-.46-1.19-1.34-.35-2.45zM5.1 12.8L6.2 11.2c.45-.8 1.19-1.19 2.45-.35l1.47.85 1.48-.85c1.26-.84 2-.45 2.45.35l1.1 1.6.85-1.48c.84-1.11.45-1.99-.35-2.45l-1.47-.85 1.48-.85c.8-.46 1.19-1.34.35-2.45L14.9 3.2c-.45-.8-1.19-1.19-2.45-.35l-1.48.85L9.5 2.85C8.24 2.01 7.5 2.4 7.05 3.2L5.95 4.8 5.1 3.32c-.84 1.11-.45 1.99.35 2.45l1.47.85-1.48.85c-.8.46-1.19 1.34-.35 2.45l1.05 1.6-.85 1.48z"/></svg>',
            'arrow-right' => '<svg xmlns="http://www.w3.org/2000/svg" width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="currentColor"><path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/></svg>',
            'arrow-left' => '<svg xmlns="http://www.w3.org/2000/svg" width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="currentColor"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>',
            'menu' => '<svg xmlns="http://www.w3.org/2000/svg" width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="currentColor"><path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/></svg>',
            'close' => '<svg xmlns="http://www.w3.org/2000/svg" width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="currentColor"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>',
        );
        
        if (array_key_exists($icon_name, $icons)) {
            return $icons[$icon_name];
        }
        
        return '';
    }
endif;

if (!function_exists('coffeeshop_the_svg')) :
    /**
     * Display SVG icon
     */
    function coffeeshop_the_svg($icon_name, $size = 24) {
        echo coffeeshop_get_svg($icon_name, $size);
    }
endif;

if (!function_exists('coffeeshop_custom_logo')) :
    /**
     * Display custom logo or site title
     */
    function coffeeshop_custom_logo() {
        if (has_custom_logo()) {
            the_custom_logo();
        } else {
            if (is_front_page() && is_home()) {
                echo '<h1 class="site-title"><a href="' . esc_url(home_url('/')) . '" rel="home">' . esc_html(get_bloginfo('name')) . '</a></h1>';
            } else {
                echo '<p class="site-title"><a href="' . esc_url(home_url('/')) . '" rel="home">' . esc_html(get_bloginfo('name')) . '</a></p>';
            }
            
            $description = get_bloginfo('description', 'display');
            if ($description || is_customize_preview()) {
                echo '<p class="site-description">' . esc_html($description) . '</p>';
            }
        }
    }
endif;

if (!function_exists('coffeeshop_footer_text')) :
    /**
     * Display footer copyright text
     */
    function coffeeshop_footer_text() {
        $copyright_text = get_theme_mod('coffeeshop_copyright_text');
        
        if ($copyright_text) {
            echo wp_kses_post($copyright_text);
        } else {
            printf(
                esc_html__('© %1$s %2$s. All rights reserved.', 'coffeeshop'),
                date('Y'),
                get_bloginfo('name')
            );
        }
    }
endif;

if (!function_exists('coffeeshop_back_to_top')) :
    /**
     * Display back to top button
     */
    function coffeeshop_back_to_top() {
        if (get_theme_mod('coffeeshop_enable_scroll_top', true)) {
            echo '<button class="back-to-top" aria-label="' . esc_attr__('Back to top', 'coffeeshop') . '" title="' . esc_attr__('Back to top', 'coffeeshop') . '">';
            echo '<i class="fas fa-chevron-up" aria-hidden="true"></i>';
            echo '</button>';
        }
    }
endif;

if (!function_exists('coffeeshop_loading_spinner')) :
    /**
     * Display loading spinner
     */
    function coffeeshop_loading_spinner() {
        echo '<div class="loading-spinner" aria-hidden="true">';
        echo '<div class="spinner"></div>';
        echo '</div>';
    }
endif;

if (!function_exists('coffeeshop_no_content')) :
    /**
     * Display no content message
     */
    function coffeeshop_no_content($title = '', $message = '') {
        if (empty($title)) {
            $title = esc_html__('Nothing found', 'coffeeshop');
        }
        
        if (empty($message)) {
            if (is_search()) {
                $message = esc_html__('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'coffeeshop');
            } else {
                $message = esc_html__('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'coffeeshop');
            }
        }
        
        echo '<section class="no-results not-found">';
        echo '<header class="page-header">';
        echo '<h1 class="page-title">' . esc_html($title) . '</h1>';
        echo '</header>';
        echo '<div class="page-content">';
        echo '<p>' . esc_html($message) . '</p>';
        echo coffeeshop_search_form();
        echo '</div>';
        echo '</section>';
    }
endif;