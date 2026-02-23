<?php
/**
 * Template Part: Voice-Led Case Study
 *
 * Voice-first storytelling experience with synchronized transcript.
 * Requires data attributes for audio sync and narrative states.
 *
 * @package BFLUXCO
 * @version 1.0.0
 *
 * Usage in templates:
 * get_template_part('template-parts/voice-case-study', null, array(
 *     'audio_url' => 'https://example.com/audio.mp3',
 *     'duration' => '8:30',
 *     'transcript' => $transcript_html,
 *     'image_url' => 'https://example.com/hero.jpg',
 *     'image_alt' => 'Case study hero image',
 * ));
 *
 * Or via shortcode:
 * [voice_case_study audio="123" image="456" duration="8:30"]
 * ...transcript content...
 * [/voice_case_study]
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Get template args
$args = wp_parse_args($args ?? array(), array(
    'audio_url'   => '',
    'duration'    => '',
    'transcript'  => '',
    'image_url'   => '',
    'image_alt'   => '',
    'title'       => '',
    'post_id'     => get_the_ID(),
));

// Try to get audio from post meta if not provided
if (empty($args['audio_url'])) {
    $audio_id = get_post_meta($args['post_id'], 'voice_audio_file', true);
    if ($audio_id) {
        $args['audio_url'] = wp_get_attachment_url($audio_id);

        // Try to get duration from audio metadata
        if (empty($args['duration']) && class_exists('BFLUXCO_Voice_Narrative')) {
            $duration_seconds = BFLUXCO_Voice_Narrative::get_audio_duration($audio_id);
            if ($duration_seconds > 0) {
                $args['duration'] = BFLUXCO_Voice_Narrative::format_duration($duration_seconds);
            }
        }
    }
}

// Try to get image from featured image if not provided
if (empty($args['image_url']) && has_post_thumbnail($args['post_id'])) {
    $args['image_url'] = get_the_post_thumbnail_url($args['post_id'], 'hero-image');
    $args['image_alt'] = get_post_meta(get_post_thumbnail_id($args['post_id']), '_wp_attachment_image_alt', true);
}

// Early return if no audio
if (empty($args['audio_url'])) {
    // Fallback: just show transcript without voice controls
    if (!empty($args['transcript'])) {
        echo '<div class="voice-case-study voice-fallback">';
        echo '<div class="voice-transcript">' . wp_kses_post($args['transcript']) . '</div>';
        echo '</div>';
    }
    return;
}
?>

<div class="voice-case-study"
     data-audio-src="<?php echo esc_url($args['audio_url']); ?>"
     data-narrative-state="grounding">

    <!-- Voice CTA Section -->
    <div class="voice-cta-section">
        <button type="button" class="voice-play-cta" aria-label="<?php esc_attr_e('Listen to this case study', 'bfluxco'); ?>">
            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                <path d="M8 5v14l11-7z"/>
            </svg>
            <span class="voice-play-cta-text">
                <span class="voice-play-cta-label"><?php esc_html_e('Listen to This Case Study', 'bfluxco'); ?></span>
                <?php if (!empty($args['duration'])) : ?>
                    <span class="voice-play-cta-duration"><?php echo esc_html($args['duration']); ?></span>
                <?php endif; ?>
            </span>
        </button>

        <a href="#transcript" class="voice-read-link">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path d="M4 6h16M4 12h16M4 18h12"/>
            </svg>
            <?php esc_html_e('Read Transcript', 'bfluxco'); ?>
        </a>

        <!-- Loading state -->
        <div class="voice-loading" aria-live="polite">
            <div class="voice-loading-spinner"></div>
            <span><?php esc_html_e('Loading audio...', 'bfluxco'); ?></span>
        </div>

        <!-- Error state -->
        <div class="voice-error" role="alert">
            <svg class="voice-error-icon" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
            </svg>
            <span><?php esc_html_e('Unable to load audio. Please try again.', 'bfluxco'); ?></span>
            <button type="button" class="voice-retry-btn"><?php esc_html_e('Retry', 'bfluxco'); ?></button>
        </div>
    </div>

    <?php if (!empty($args['image_url'])) : ?>
    <!-- Visual Area -->
    <div class="voice-visual-area">
        <img src="<?php echo esc_url($args['image_url']); ?>"
             alt="<?php echo esc_attr($args['image_alt']); ?>"
             loading="lazy">
    </div>
    <?php endif; ?>

    <!-- Transcript -->
    <div id="transcript" class="voice-transcript">
        <?php
        if (!empty($args['transcript'])) {
            // Transcript HTML is already escaped by shortcode handler
            echo $args['transcript'];
        } else {
            // If no transcript provided, try post meta
            $stored_transcript = get_post_meta($args['post_id'], 'voice_transcript', true);
            if ($stored_transcript) {
                echo wp_kses_post($stored_transcript);
            } else {
                // Fallback to post content
                the_content();
            }
        }
        ?>
    </div>

</div>
