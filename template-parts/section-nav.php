<?php
/**
 * Template part for displaying section navigation arrows
 *
 * Consistent navigation pattern for carousels and content sections.
 *
 * @package BFLUXCO
 *
 * Expected $args:
 *   - prev_label: string (optional) - Aria label for prev button
 *   - next_label: string (optional) - Aria label for next button
 *   - prev_class: string (optional) - Additional class for prev button
 *   - next_class: string (optional) - Additional class for next button
 *   - hint: string (optional) - Hint text to display (e.g., "Scroll to explore")
 *   - class: string (optional) - Additional wrapper classes
 */

$prev_label = isset($args['prev_label']) ? $args['prev_label'] : __('Previous', 'bfluxco');
$next_label = isset($args['next_label']) ? $args['next_label'] : __('Next', 'bfluxco');
$prev_class = isset($args['prev_class']) ? $args['prev_class'] : 'section-prev';
$next_class = isset($args['next_class']) ? $args['next_class'] : 'section-next';
$hint = isset($args['hint']) ? $args['hint'] : '';
$class = isset($args['class']) ? $args['class'] : '';

$wrapper_classes = 'section-nav reveal';
if (!empty($class)) {
    $wrapper_classes .= ' ' . esc_attr($class);
}
?>

<div class="<?php echo esc_attr($wrapper_classes); ?>" data-delay="2">
    <?php if (!empty($hint)) : ?>
        <span class="section-nav-hint"><?php echo esc_html($hint); ?></span>
    <?php endif; ?>

    <div class="section-nav-arrows">
        <button class="section-nav-arrow <?php echo esc_attr($prev_class); ?>" aria-label="<?php echo esc_attr($prev_label); ?>">
            <?php bfluxco_icon('chevron-left', array('size' => 24)); ?>
        </button>
        <button class="section-nav-arrow <?php echo esc_attr($next_class); ?>" aria-label="<?php echo esc_attr($next_label); ?>">
            <?php bfluxco_icon('chevron-right', array('size' => 24)); ?>
        </button>
    </div>
</div>
