<?php
/**
 * Template part for displaying posts
 *
 * This is a reusable template part for displaying post content
 * in archive pages and search results.
 *
 * @package BFLUXCO
 *
 * PRO TIP: Template parts are reusable snippets of code.
 * They're called using get_template_part() function.
 * This keeps your code DRY (Don't Repeat Yourself).
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('card'); ?>>

    <!-- Post Thumbnail -->
    <?php if (has_post_thumbnail()) : ?>
        <div class="card-image">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('card-thumbnail'); ?>
            </a>
        </div>
    <?php endif; ?>

    <div class="card-content">

        <!-- Categories (for posts) -->
        <?php if (has_category()) : ?>
            <div class="post-categories mb-2">
                <?php
                $categories = get_the_category();
                if (!empty($categories)) {
                    echo '<a href="' . esc_url(get_category_link($categories[0]->term_id)) . '" class="text-primary text-sm">';
                    echo esc_html($categories[0]->name);
                    echo '</a>';
                }
                ?>
            </div>
        <?php endif; ?>

        <!-- Post Title -->
        <h2 class="card-title">
            <a href="<?php the_permalink(); ?>"><?php echo esc_html(get_the_title()); ?></a>
        </h2>

        <!-- Post Excerpt -->
        <p class="card-description text-gray-600">
            <?php echo esc_html(bfluxco_truncate(get_the_excerpt(), 120)); ?>
        </p>

        <!-- Post Meta -->
        <div class="card-meta">
            <time datetime="<?php echo get_the_date('c'); ?>">
                <?php echo get_the_date(); ?>
            </time>
            <span>&middot;</span>
            <span><?php printf(esc_html__('%d min read', 'bfluxco'), bfluxco_reading_time()); ?></span>
        </div>

    </div>

</article><!-- #post-<?php the_ID(); ?> -->
