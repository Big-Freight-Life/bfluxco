<?php
/**
 * Template part for displaying a service card
 *
 * This reusable card component is used for service previews.
 *
 * @package BFLUXCO
 *
 * Expected $args:
 *   - title: string
 *   - description: string
 *   - icon: string (icon name for bfluxco_icon())
 *   - link: string (URL)
 *   - delay: int (animation delay index)
 */

$title = isset($args['title']) ? $args['title'] : '';
$description = isset($args['description']) ? $args['description'] : '';
$icon = isset($args['icon']) ? $args['icon'] : 'layers';
$link = isset($args['link']) ? $args['link'] : '#';
$delay = isset($args['delay']) ? intval($args['delay']) : 1;
?>

<div class="card reveal-up micro-hover" data-delay="<?php echo esc_attr($delay); ?>">
    <div class="card-content text-center">
        <div class="card-icon mb-4">
            <?php bfluxco_icon($icon, array('size' => 48)); ?>
        </div>
        <h3 class="card-title"><?php echo esc_html($title); ?></h3>
        <p class="card-description"><?php echo esc_html($description); ?></p>
        <a href="<?php echo esc_url(home_url($link)); ?>" class="btn btn-tertiary btn-sm btn-icon">
            <span><?php esc_html_e('Learn More', 'bfluxco'); ?></span>
            <?php bfluxco_icon('arrow-right', array('size' => 16)); ?>
        </a>
    </div>
</div>
