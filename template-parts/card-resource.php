<?php
/**
 * Template part for displaying a resource card
 *
 * @package BFLUXCO
 *
 * @param array $args {
 *     @type string $type        Resource type: article, guide, framework, template, case-note
 *     @type string $title       Resource title
 *     @type string $description Resource description
 *     @type string $link        URL to the resource
 *     @type string $link_text   Link text (e.g., "Read article")
 *     @type bool   $featured    Whether this is a featured card (larger display)
 *     @type int    $delay       Animation delay (1-5)
 *     @type string $image       Optional image URL
 * }
 */

$type = isset($args['type']) ? $args['type'] : 'article';
$title = isset($args['title']) ? $args['title'] : '';
$description = isset($args['description']) ? $args['description'] : '';
$link = isset($args['link']) ? $args['link'] : '#';
$link_text = isset($args['link_text']) ? $args['link_text'] : __('Learn more', 'bfluxco');
$featured = isset($args['featured']) && $args['featured'];
$delay = isset($args['delay']) ? intval($args['delay']) : 0;
$image = isset($args['image']) ? $args['image'] : '';

// Type labels
$type_labels = array(
    'article'   => __('Article', 'bfluxco'),
    'guide'     => __('Guide', 'bfluxco'),
    'framework' => __('Framework', 'bfluxco'),
    'template'  => __('Template', 'bfluxco'),
    'case-note' => __('Case Note', 'bfluxco'),
);

$type_label = isset($type_labels[$type]) ? $type_labels[$type] : ucfirst($type);

// Type-specific icons (SVG paths)
$type_icons = array(
    'article' => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/>
        <polyline points="14 2 14 8 20 8"/>
        <line x1="16" y1="13" x2="8" y2="13"/>
        <line x1="16" y1="17" x2="8" y2="17"/>
        <line x1="10" y1="9" x2="8" y2="9"/>
    </svg>',
    'guide' => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
        <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
    </svg>',
    'framework' => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="3"/>
        <path d="M12 1v4"/>
        <path d="M12 19v4"/>
        <path d="M4.22 4.22l2.83 2.83"/>
        <path d="M16.95 16.95l2.83 2.83"/>
        <path d="M1 12h4"/>
        <path d="M19 12h4"/>
        <path d="M4.22 19.78l2.83-2.83"/>
        <path d="M16.95 7.05l2.83-2.83"/>
    </svg>',
    'template' => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
        <line x1="3" y1="9" x2="21" y2="9"/>
        <line x1="9" y1="21" x2="9" y2="9"/>
    </svg>',
    'case-note' => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
        <line x1="9" y1="10" x2="15" y2="10"/>
        <line x1="12" y1="7" x2="12" y2="13"/>
    </svg>',
);

$icon = isset($type_icons[$type]) ? $type_icons[$type] : $type_icons['article'];

// Build CSS classes
$card_classes = array('resource-card');
$card_classes[] = 'resource-card--' . esc_attr($type);
if ($featured) {
    $card_classes[] = 'resource-card--featured';
}
$card_classes[] = 'reveal-up';
?>

<article class="<?php echo esc_attr(implode(' ', $card_classes)); ?>" data-type="<?php echo esc_attr($type); ?>"<?php echo $delay ? ' data-delay="' . esc_attr($delay) . '"' : ''; ?>>
    <a href="<?php echo esc_url($link); ?>" class="resource-card-inner">
        <!-- Image/Placeholder Area -->
        <div class="resource-card-image">
            <?php if ($image) : ?>
                <img src="<?php echo esc_url($image); ?>" alt="" loading="lazy">
            <?php else : ?>
                <div class="resource-card-placeholder">
                    <div class="resource-card-placeholder-icon">
                        <?php echo $icon; ?>
                    </div>
                    <div class="resource-card-placeholder-pattern"></div>
                </div>
            <?php endif; ?>
            <span class="resource-card-type"><?php echo esc_html($type_label); ?></span>
        </div>

        <!-- Content Area -->
        <div class="resource-card-body">
            <div class="resource-card-content">
                <h3 class="resource-card-title"><?php echo esc_html($title); ?></h3>
                <?php if ($description) : ?>
                    <p class="resource-card-description"><?php echo esc_html($description); ?></p>
                <?php endif; ?>
            </div>

            <div class="resource-card-footer">
                <span class="resource-card-link">
                    <?php echo esc_html($link_text); ?>
                    <svg class="resource-card-arrow" width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                        <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
            </div>
        </div>
    </a>
</article>
