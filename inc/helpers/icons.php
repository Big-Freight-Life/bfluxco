<?php
/**
 * BFLUXCO Icon Helper Functions
 *
 * Centralized icon management to eliminate inline SVG duplication.
 * Icons are stored as SVG files in /assets/images/icons/
 *
 * @package BFLUXCO
 * @version 1.0.1
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get SVG icon markup
 *
 * @param string $name    Icon name (without .svg extension)
 * @param array  $args    Optional arguments:
 *                        - size: int (applies to width and height)
 *                        - width: int
 *                        - height: int
 *                        - class: string (additional CSS classes)
 *                        - aria_label: string (accessibility label)
 * @return string SVG markup or empty string if icon not found
 *
 * Usage:
 *   echo bfluxco_get_icon('chevron-right');
 *   echo bfluxco_get_icon('arrow-right', ['size' => 16, 'class' => 'icon-sm']);
 */
function bfluxco_get_icon($name, $args = array()) {
    $defaults = array(
        'size'       => null,
        'width'      => null,
        'height'     => null,
        'class'      => '',
        'aria_label' => '',
    );

    $args = wp_parse_args($args, $defaults);
    $icon_path = get_template_directory() . '/assets/images/icons/' . sanitize_file_name($name) . '.svg';

    if (!file_exists($icon_path)) {
        return '';
    }

    $svg = file_get_contents($icon_path);

    if (empty($svg)) {
        return '';
    }

    // Process size attributes
    $width = $args['width'] ?? $args['size'];
    $height = $args['height'] ?? $args['size'];

    if ($width) {
        // Only replace the first width attribute (on the <svg> element, not internal elements)
        // Use negative lookbehind to avoid matching stroke-width, etc.
        $svg = preg_replace('/(?<![a-z-])width="[^"]*"/', 'width="' . intval($width) . '"', $svg, 1);
    }

    if ($height) {
        // Only replace the first height attribute (on the <svg> element, not internal elements)
        // Use negative lookbehind to avoid matching line-height, etc.
        $svg = preg_replace('/(?<![a-z-])height="[^"]*"/', 'height="' . intval($height) . '"', $svg, 1);
    }

    // Add CSS class if provided
    if (!empty($args['class'])) {
        if (strpos($svg, 'class="') !== false) {
            $svg = preg_replace('/class="([^"]*)"/', 'class="$1 ' . esc_attr($args['class']) . '"', $svg);
        } else {
            $svg = str_replace('<svg ', '<svg class="' . esc_attr($args['class']) . '" ', $svg);
        }
    }

    // Add aria-label for accessibility
    if (!empty($args['aria_label'])) {
        $svg = str_replace('<svg ', '<svg aria-label="' . esc_attr($args['aria_label']) . '" role="img" ', $svg);
    } else {
        // Add aria-hidden if no label (decorative icon)
        if (strpos($svg, 'aria-') === false) {
            $svg = str_replace('<svg ', '<svg aria-hidden="true" ', $svg);
        }
    }

    return $svg;
}

/**
 * Echo SVG icon markup
 *
 * @param string $name Icon name
 * @param array  $args Optional arguments (see bfluxco_get_icon)
 */
function bfluxco_icon($name, $args = array()) {
    echo bfluxco_get_icon($name, $args);
}

/**
 * Get all available icon names
 *
 * @return array List of icon names (without .svg extension)
 */
function bfluxco_get_available_icons() {
    $icons_dir = get_template_directory() . '/assets/images/icons/';

    if (!is_dir($icons_dir)) {
        return array();
    }

    $files = glob($icons_dir . '*.svg');
    $icons = array();

    foreach ($files as $file) {
        $icons[] = basename($file, '.svg');
    }

    return $icons;
}
