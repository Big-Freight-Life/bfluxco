<?php
/**
 * Template part for displaying CTA sections
 *
 * @package BFLUXCO
 *
 * Usage:
 * get_template_part('template-parts/section-cta', null, array(
 *     'heading' => 'Have a Similar Challenge?',
 *     'description' => 'Let\'s discuss how strategic design can help.',
 *     'button_text' => 'Start a Conversation',
 *     'button_url' => home_url('/contact'),  // optional, defaults to /contact
 *     'bg_class' => 'bg-gray-50',            // optional, defaults to 'bg-gray-50'
 * ));
 */

// Get args with defaults
$heading = isset($args['heading']) ? $args['heading'] : '';
$description = isset($args['description']) ? $args['description'] : '';
$button_text = isset($args['button_text']) ? $args['button_text'] : __('Get in Touch', 'bfluxco');
$button_url = isset($args['button_url']) ? $args['button_url'] : home_url('/contact');
$bg_class = isset($args['bg_class']) ? $args['bg_class'] : 'bg-gray-50';
?>

<!-- CTA Section -->
<section class="section <?php echo esc_attr($bg_class); ?> text-center">
    <div class="container">
        <h2 class="reveal-text"><?php echo esc_html($heading); ?></h2>
        <p class="text-gray-600 max-w-2xl mx-auto mb-8 reveal-text" data-delay="1">
            <?php echo esc_html($description); ?>
        </p>
        <div class="reveal" data-delay="2">
            <a href="<?php echo esc_url($button_url); ?>" class="btn btn-primary btn-lg">
                <?php echo esc_html($button_text); ?>
            </a>
        </div>
    </div>
</section><!-- CTA -->
