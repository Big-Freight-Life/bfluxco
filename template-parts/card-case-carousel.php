<?php
/**
 * Template part for displaying a case study card in the carousel
 *
 * This card variant is specifically designed for the homepage carousel.
 * For archive/grid layouts, use card-case-study.php instead.
 *
 * @package BFLUXCO
 *
 * Expected $args:
 *   - is_placeholder: bool (whether this is placeholder content)
 *   - placeholder_data: array (label, title, excerpt, year, gradient, link)
 */

$is_placeholder = isset($args['is_placeholder']) && $args['is_placeholder'];
$data = isset($args['placeholder_data']) ? $args['placeholder_data'] : array();

if ($is_placeholder) :
    // Placeholder mode
    $label = isset($data['label']) ? $data['label'] : 'Case Study';
    $title = isset($data['title']) ? $data['title'] : 'Project Title';
    $excerpt = isset($data['excerpt']) ? $data['excerpt'] : 'Project description goes here.';
    $year = isset($data['year']) ? $data['year'] : date('Y');
    $gradient = isset($data['gradient']) ? $data['gradient'] : 'linear-gradient(135deg, #6366f1, #8b5cf6)';
    $link = isset($data['link']) ? $data['link'] : '#';
?>
    <a href="<?php echo esc_url(home_url($link)); ?>" class="case-card">
        <div class="case-card-content">
            <span class="case-label"><?php echo esc_html($label); ?></span>
            <h3 class="case-title"><?php echo esc_html($title); ?></h3>
            <p class="case-excerpt"><?php echo esc_html($excerpt); ?></p>
            <div class="case-meta">
                <span><?php echo esc_html($year); ?></span>
            </div>
        </div>
        <div class="case-card-image">
            <div class="case-image-placeholder" style="background: <?php echo esc_attr($gradient); ?>;"></div>
        </div>
    </a>
<?php else :
    // Real post mode
    $industry = get_the_terms(get_the_ID(), 'industry');
    $industry_name = $industry ? $industry[0]->name : 'Case Study';
?>
    <a href="<?php the_permalink(); ?>" class="case-card">
        <div class="case-card-content">
            <span class="case-label"><?php echo esc_html($industry_name); ?></span>
            <h3 class="case-title"><?php the_title(); ?></h3>
            <p class="case-excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 24)); ?></p>
            <div class="case-meta">
                <span><?php echo get_the_date('Y'); ?></span>
            </div>
        </div>
        <div class="case-card-image">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('medium_large'); ?>
            <?php else : ?>
                <div class="case-image-placeholder"></div>
            <?php endif; ?>
        </div>
    </a>
<?php endif; ?>
