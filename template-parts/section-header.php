<?php
/**
 * Template part for displaying a section header
 *
 * Consistent header pattern for content sections.
 * Based on the Latest Blogs section specification.
 *
 * @package BFLUXCO
 *
 * Expected $args:
 *   - title: string (required) - Section title
 *   - subtitle: string (optional) - Subtitle/description text
 *   - cta_text: string (optional) - CTA button text (e.g., "View All")
 *   - cta_url: string (optional) - CTA button URL
 *   - cta_icon: string (optional) - Icon name for CTA button (default: 'arrow-right')
 *   - class: string (optional) - Additional header classes
 *   - centered: bool (optional) - Center-align the header (default: false)
 */

$title = isset($args['title']) ? $args['title'] : '';
$subtitle = isset($args['subtitle']) ? $args['subtitle'] : '';
$cta_text = isset($args['cta_text']) ? $args['cta_text'] : '';
$cta_url = isset($args['cta_url']) ? $args['cta_url'] : '';
$cta_icon = isset($args['cta_icon']) ? $args['cta_icon'] : 'arrow-right';
$class = isset($args['class']) ? $args['class'] : '';
$centered = isset($args['centered']) && $args['centered'];
$heading_tag = isset($args['heading_tag']) ? $args['heading_tag'] : 'h2';

$header_classes = 'section-header reveal-text';
if ($centered) {
    $header_classes .= ' text-center';
}
if (!empty($class)) {
    $header_classes .= ' ' . esc_attr($class);
}
?>

<header class="<?php echo esc_attr($header_classes); ?>">
    <div class="section-header-content">
        <?php if (!empty($title)) : ?>
            <h2 class="section-title"><?php echo wp_kses_post($title); ?></h2>
        <?php endif; ?>

        <?php if (!empty($subtitle)) : ?>
            <p class="section-subtitle"><?php echo wp_kses_post($subtitle); ?></p>
        <?php endif; ?>
    </div>

    <?php if (!empty($cta_text) && !empty($cta_url)) : ?>
        <a href="<?php echo esc_url($cta_url); ?>" class="btn btn-tertiary btn-icon">
            <span><?php echo esc_html($cta_text); ?></span>
            <?php bfluxco_icon($cta_icon, array('size' => 16)); ?>
        </a>
    <?php endif; ?>
</header>
