<?php
/**
 * Template Part: Back Link
 *
 * A reusable back navigation component.
 *
 * Usage: get_template_part('template-parts/back-link', null, array(
 *     'url' => home_url('/products'),
 *     'text' => 'Products'
 * ));
 *
 * @package BFLUXCO
 */

$back_url = isset($args['url']) ? $args['url'] : home_url();
$back_text = isset($args['text']) ? $args['text'] : __('Back', 'bfluxco');
?>

<nav class="back-link-nav">
    <a href="<?php echo esc_url($back_url); ?>" class="back-link">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M19 12H5"/>
            <path d="m12 19-7-7 7-7"/>
        </svg>
        <span><?php echo esc_html($back_text); ?></span>
    </a>
</nav>
