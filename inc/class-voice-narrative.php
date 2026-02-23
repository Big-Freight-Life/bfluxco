<?php
/**
 * Voice Narrative Case Study
 *
 * Handles registration of shortcodes, meta fields, and asset loading
 * for voice-led case study experiences.
 *
 * @package BFLUXCO
 * @version 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * BFLUXCO_Voice_Narrative Class
 *
 * Manages the voice narrative feature for case studies.
 */
class BFLUXCO_Voice_Narrative {

    /**
     * Singleton instance
     */
    private static $instance = null;

    /**
     * Get singleton instance
     */
    public static function get_instance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor
     */
    private function __construct() {
        add_action('init', array($this, 'register_shortcode'));
        add_action('init', array($this, 'register_meta'));
        add_action('wp_enqueue_scripts', array($this, 'maybe_enqueue_assets'));
    }

    /**
     * Register the voice_case_study shortcode
     */
    public function register_shortcode() {
        add_shortcode('voice_case_study', array($this, 'render_shortcode'));
    }

    /**
     * Render the shortcode
     *
     * @param array  $atts    Shortcode attributes
     * @param string $content Shortcode content (transcript)
     * @return string HTML output
     */
    public function render_shortcode($atts, $content = null) {
        $atts = shortcode_atts(array(
            'audio'    => '',
            'image'    => '',
            'duration' => '',
        ), $atts, 'voice_case_study');

        // Resolve audio URL
        $audio_url = '';
        if (is_numeric($atts['audio'])) {
            $audio_url = wp_get_attachment_url(intval($atts['audio']));
        } elseif (!empty($atts['audio'])) {
            $audio_url = esc_url($atts['audio']);
        }

        // Resolve image URL
        $image_url = '';
        $image_alt = '';
        if (is_numeric($atts['image'])) {
            $image_url = wp_get_attachment_url(intval($atts['image']));
            $image_alt = get_post_meta(intval($atts['image']), '_wp_attachment_image_alt', true);
        } elseif (!empty($atts['image'])) {
            $image_url = esc_url($atts['image']);
        }

        // Start output buffering
        ob_start();

        // Include template part with args
        get_template_part('template-parts/voice-case-study', null, array(
            'audio_url'  => $audio_url,
            'duration'   => $atts['duration'],
            'transcript' => do_shortcode($content),
            'image_url'  => $image_url,
            'image_alt'  => $image_alt,
        ));

        return ob_get_clean();
    }

    /**
     * Register meta fields for voice case studies
     */
    public function register_meta() {
        // Audio file attachment ID
        register_post_meta('case_study', 'voice_audio_file', array(
            'type'              => 'integer',
            'single'            => true,
            'show_in_rest'      => true,
            'description'       => 'Attachment ID for the voice narration audio file',
            'sanitize_callback' => 'absint',
        ));

        // Transcript HTML
        register_post_meta('case_study', 'voice_transcript', array(
            'type'              => 'string',
            'single'            => true,
            'show_in_rest'      => true,
            'description'       => 'Voice transcript with timing data',
            'sanitize_callback' => 'wp_kses_post',
        ));

        // Enable voice feature toggle
        register_post_meta('case_study', 'voice_enabled', array(
            'type'              => 'boolean',
            'single'            => true,
            'show_in_rest'      => true,
            'default'           => false,
            'description'       => 'Enable voice narrative for this case study',
            'sanitize_callback' => 'rest_sanitize_boolean',
        ));
    }

    /**
     * Conditionally enqueue voice narrative assets
     */
    public function maybe_enqueue_assets() {
        if (!$this->should_load_assets()) {
            return;
        }

        // Enqueue CSS
        wp_enqueue_style(
            'bfluxco-voice-narrative',
            get_template_directory_uri() . '/assets/css/partials/_voice-narrative.css',
            array(),
            BFLUXCO_THEME_VERSION ?? '1.0.0'
        );

        // Enqueue JS
        wp_enqueue_script(
            'bfluxco-voice-narrative',
            get_template_directory_uri() . '/assets/js/voice-narrative.js',
            array(),
            BFLUXCO_THEME_VERSION ?? '1.0.0',
            true // Load in footer
        );
    }

    /**
     * Determine if voice assets should be loaded
     *
     * @return bool
     */
    private function should_load_assets() {
        global $post;

        if (!$post) {
            return false;
        }

        // Check for shortcode in content
        if (has_shortcode($post->post_content, 'voice_case_study')) {
            return true;
        }

        // Check for voice meta enabled
        if (get_post_meta($post->ID, 'voice_enabled', true)) {
            return true;
        }

        // Check for voice audio file
        if (get_post_meta($post->ID, 'voice_audio_file', true)) {
            return true;
        }

        // Always load on single case studies (for flexibility)
        if (is_singular('case_study')) {
            return true;
        }

        return false;
    }

    /**
     * Helper: Format seconds to MM:SS
     *
     * @param int $seconds Total seconds
     * @return string Formatted time
     */
    public static function format_duration($seconds) {
        $mins = floor($seconds / 60);
        $secs = $seconds % 60;
        return sprintf('%d:%02d', $mins, $secs);
    }

    /**
     * Helper: Get audio duration from file
     *
     * @param int $attachment_id Audio attachment ID
     * @return int Duration in seconds, or 0 if unavailable
     */
    public static function get_audio_duration($attachment_id) {
        $metadata = wp_get_attachment_metadata($attachment_id);

        if ($metadata && isset($metadata['length'])) {
            return (int) $metadata['length'];
        }

        return 0;
    }
}

// Initialize
BFLUXCO_Voice_Narrative::get_instance();
