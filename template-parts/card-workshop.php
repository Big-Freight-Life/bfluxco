<?php
/**
 * Template part for displaying a workshop card
 *
 * @package BFLUXCO
 *
 * Usage (inside loop):
 * get_template_part('template-parts/card-workshop', null, array(
 *     'index' => $index,  // optional, for animation delay
 * ));
 */

$index = isset($args['index']) ? $args['index'] : 1;
$duration = get_post_meta(get_the_ID(), 'workshop_duration', true);
$format = get_post_meta(get_the_ID(), 'workshop_format', true);
?>

<article class="workshop-item reveal-up" data-delay="<?php echo min($index, 4); ?>">
    <a href="<?php the_permalink(); ?>" class="workshop-item-inner">
        <div class="workshop-item-content">
            <h3 class="workshop-item-title"><?php the_title(); ?></h3>
            <p class="workshop-item-excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 25)); ?></p>
        </div>
        <div class="workshop-item-meta">
            <?php if ($duration) : ?>
                <span class="workshop-duration"><?php echo esc_html($duration); ?></span>
            <?php endif; ?>
            <?php if ($format) : ?>
                <span class="workshop-format"><?php echo esc_html($format); ?></span>
            <?php endif; ?>
            <span class="workshop-arrow">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 18l6-6-6-6"/>
                </svg>
            </span>
        </div>
    </a>
</article>
