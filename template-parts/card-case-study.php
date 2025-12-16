<?php
/**
 * Template part for displaying a case study card
 *
 * This reusable card component is used throughout the site
 * to display case study previews.
 *
 * @package BFLUXCO
 */
?>

<article class="card case-study-card">

    <!-- Card Image -->
    <div class="card-image">
        <?php if (has_post_thumbnail()) : ?>
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('card-thumbnail'); ?>
            </a>
        <?php else : ?>
            <a href="<?php the_permalink(); ?>" style="display: block; background: var(--color-gray-200); aspect-ratio: 16/9;"></a>
        <?php endif; ?>
    </div>

    <div class="card-content">

        <!-- Industry Tags -->
        <?php
        $industries = get_the_terms(get_the_ID(), 'industry');
        if ($industries && !is_wp_error($industries)) :
        ?>
            <div class="case-study-industries mb-2">
                <?php foreach (array_slice($industries, 0, 2) as $industry) : ?>
                    <span class="industry-tag text-primary text-sm">
                        <?php echo esc_html($industry->name); ?>
                    </span>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Title -->
        <h3 class="card-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>

        <!-- Excerpt -->
        <p class="card-description text-gray-600">
            <?php echo bfluxco_truncate(get_the_excerpt(), 100); ?>
        </p>

        <!-- Link -->
        <a href="<?php the_permalink(); ?>" class="link">
            <?php esc_html_e('View Case Study', 'bfluxco'); ?> &rarr;
        </a>

    </div>

</article>
