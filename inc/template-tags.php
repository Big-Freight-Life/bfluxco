<?php
/**
 * Custom template tags for this theme
 *
 * This file contains functions that output HTML for common theme elements.
 * These functions can be called directly in template files.
 *
 * @package BFLUXCO
 *
 * PRO TIP: Template tags are helper functions that make it easier
 * to output common pieces of HTML. Instead of writing the same code
 * multiple times, you create a function and call it when needed.
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Display post date
 *
 * Outputs the post publication date with appropriate markup.
 *
 * Usage: bfluxco_posted_on();
 */
function bfluxco_posted_on() {
    $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

    if (get_the_time('U') !== get_the_modified_time('U')) {
        $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
    }

    $time_string = sprintf(
        $time_string,
        esc_attr(get_the_date(DATE_W3C)),
        esc_html(get_the_date()),
        esc_attr(get_the_modified_date(DATE_W3C)),
        esc_html(get_the_modified_date())
    );

    printf(
        '<span class="posted-on">%s</span>',
        $time_string
    );
}

/**
 * Display post author
 *
 * Outputs the post author with link to their archive.
 *
 * Usage: bfluxco_posted_by();
 */
function bfluxco_posted_by() {
    printf(
        '<span class="byline">%s <a href="%s">%s</a></span>',
        esc_html__('by', 'bfluxco'),
        esc_url(get_author_posts_url(get_the_author_meta('ID'))),
        esc_html(get_the_author())
    );
}

/**
 * Display post categories
 *
 * Outputs a comma-separated list of categories.
 *
 * Usage: bfluxco_entry_categories();
 */
function bfluxco_entry_categories() {
    if ('post' === get_post_type()) {
        $categories_list = get_the_category_list(', ');
        if ($categories_list) {
            printf(
                '<span class="cat-links">%s %s</span>',
                esc_html__('Posted in', 'bfluxco'),
                $categories_list
            );
        }
    }
}

/**
 * Display post tags
 *
 * Outputs a comma-separated list of tags.
 *
 * Usage: bfluxco_entry_tags();
 */
function bfluxco_entry_tags() {
    if ('post' === get_post_type()) {
        $tags_list = get_the_tag_list('', ', ');
        if ($tags_list) {
            printf(
                '<span class="tags-links">%s %s</span>',
                esc_html__('Tagged', 'bfluxco'),
                $tags_list
            );
        }
    }
}

/**
 * Display comments link
 *
 * Outputs a link to the comments section if comments are open.
 *
 * Usage: bfluxco_comments_link();
 */
function bfluxco_comments_link() {
    if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
        echo '<span class="comments-link">';
        comments_popup_link(
            sprintf(
                wp_kses(
                    __('Leave a Comment<span class="screen-reader-text"> on %s</span>', 'bfluxco'),
                    array('span' => array('class' => array()))
                ),
                wp_kses_post(get_the_title())
            )
        );
        echo '</span>';
    }
}

/**
 * Display post thumbnail with fallback
 *
 * Outputs the featured image or a placeholder if none exists.
 *
 * @param string $size Image size to use
 *
 * Usage: bfluxco_post_thumbnail('large');
 */
function bfluxco_post_thumbnail($size = 'post-thumbnail') {
    if (post_password_required() || is_attachment()) {
        return;
    }

    if (has_post_thumbnail()) : ?>
        <div class="post-thumbnail">
            <?php if (is_singular()) : ?>
                <?php the_post_thumbnail($size); ?>
            <?php else : ?>
                <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail($size, array('alt' => the_title_attribute(array('echo' => false)))); ?>
                </a>
            <?php endif; ?>
        </div>
    <?php else : ?>
        <div class="post-thumbnail post-thumbnail-placeholder" style="background-color: var(--color-gray-200); aspect-ratio: 16/9;">
            <?php if (!is_singular()) : ?>
                <a href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>"></a>
            <?php endif; ?>
        </div>
    <?php endif;
}

/**
 * Display edit post link for logged-in users
 *
 * Shows an edit link for users with permission to edit the post.
 *
 * Usage: bfluxco_edit_link();
 */
function bfluxco_edit_link() {
    edit_post_link(
        sprintf(
            wp_kses(
                __('Edit <span class="screen-reader-text">%s</span>', 'bfluxco'),
                array('span' => array('class' => array()))
            ),
            wp_kses_post(get_the_title())
        ),
        '<span class="edit-link">',
        '</span>'
    );
}

/**
 * Display pagination for archive pages
 *
 * Outputs numbered pagination with previous/next links.
 *
 * Usage: bfluxco_pagination();
 */
function bfluxco_pagination() {
    the_posts_pagination(array(
        'mid_size'  => 2,
        'prev_text' => sprintf(
            '<span aria-hidden="true">&larr;</span> <span class="screen-reader-text">%s</span>',
            __('Previous', 'bfluxco')
        ),
        'next_text' => sprintf(
            '<span class="screen-reader-text">%s</span> <span aria-hidden="true">&rarr;</span>',
            __('Next', 'bfluxco')
        ),
    ));
}

/**
 * Display custom logo or site title
 *
 * Outputs the custom logo if set, otherwise the site title.
 *
 * Usage: bfluxco_site_logo();
 */
function bfluxco_site_logo() {
    if (has_custom_logo()) {
        the_custom_logo();
    } else {
        ?>
        <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo" rel="home">
            <?php bloginfo('name'); ?>
        </a>
        <?php
    }
}

/**
 * Check if the current page is a child of a specific page
 *
 * @param int|string $parent Parent page ID or slug
 * @return bool
 *
 * Usage: if (bfluxco_is_child_of('about')) { ... }
 */
function bfluxco_is_child_of($parent) {
    global $post;

    if (!is_page() || !$post) {
        return false;
    }

    // If parent is a slug, get the ID
    if (!is_numeric($parent)) {
        $parent_page = get_page_by_path($parent);
        if (!$parent_page) {
            return false;
        }
        $parent = $parent_page->ID;
    }

    // Check if current page is a descendant of the parent
    $ancestors = get_post_ancestors($post);

    return in_array($parent, $ancestors);
}

/**
 * Get the excerpt with custom length
 *
 * Returns a trimmed excerpt with specified word count.
 *
 * @param int $length Number of words
 * @param string $more What to append (default: ...)
 * @return string
 *
 * Usage: echo bfluxco_get_excerpt(20);
 */
function bfluxco_get_excerpt($length = 25, $more = '...') {
    $excerpt = get_the_excerpt();

    if (empty($excerpt)) {
        $excerpt = get_the_content();
    }

    $excerpt = wp_strip_all_tags($excerpt);
    $words = explode(' ', $excerpt);

    if (count($words) > $length) {
        $excerpt = implode(' ', array_slice($words, 0, $length)) . $more;
    }

    return $excerpt;
}

/**
 * Display post meta information
 *
 * Outputs a formatted meta section with date, author, and categories.
 *
 * @param array $show Which meta items to show: 'date', 'author', 'categories', 'comments'
 *
 * Usage: bfluxco_entry_meta(array('date', 'author'));
 */
function bfluxco_entry_meta($show = array('date', 'author', 'categories')) {
    echo '<div class="entry-meta">';

    if (in_array('date', $show)) {
        bfluxco_posted_on();
    }

    if (in_array('author', $show)) {
        bfluxco_posted_by();
    }

    if (in_array('categories', $show)) {
        bfluxco_entry_categories();
    }

    if (in_array('comments', $show)) {
        bfluxco_comments_link();
    }

    echo '</div>';
}
