<?php
/**
 * Gemini Image Generation API
 *
 * Integrates Google's Gemini API (Imagen 3) for generating
 * dynamic visuals for voice-led case studies.
 *
 * Media is optimized for immersive, fixed-viewport COVER display:
 * - Crop-safe composition (center 60% safe zone)
 * - Strong vertical continuity
 * - Graceful cropping across viewport sizes
 * - Atmospheric, editorial quality
 *
 * @package BFLUXCO
 * @version 2.1.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * BFLUXCO_Gemini_Image Class
 *
 * Handles image generation via Google Gemini API.
 */
class BFLUXCO_Gemini_Image {

    /**
     * Singleton instance
     */
    private static $instance = null;

    /**
     * Gemini API endpoint
     */
    const API_ENDPOINT = 'https://generativelanguage.googleapis.com/v1beta/models/';

    /**
     * Default model for image generation
     */
    const DEFAULT_MODEL = 'gemini-2.0-flash-exp';

    /**
     * Image generation model
     */
    const IMAGE_MODEL = 'imagen-3.0-generate-002';

    /**
     * Video generation model (Veo)
     */
    const VIDEO_MODEL = 'veo-2.0-generate-001';

    /**
     * Default aspect ratio for visuals
     */
    const DEFAULT_ASPECT_RATIO = '3:4';

    /**
     * Media composition system prompt
     * Ensures generated media is crop-safe, narrative-driven, and contextual
     */
    const MEDIA_COMPOSITION_PROMPT = '
CRITICAL: NARRATIVE, CONTEXTUAL IMAGERY (NOT ABSTRACT)

Generate STORY-DRIVEN visuals that illustrate the specific context of each capsule. Show real scenarios, people, environments, and moments - NOT abstract patterns or generative art.

CONTENT REQUIREMENTS:
- Show PEOPLE in realistic work/life contexts when relevant
- Depict actual ENVIRONMENTS (offices, workspaces, meetings, screens, tools)
- Illustrate MOMENTS that match the narrative beat (problem discovery, collaboration, breakthrough, success)
- Ground visuals in recognizable, relatable scenarios
- NO purely abstract visuals, geometric patterns, or decorative graphics

CROP-SAFE COMPOSITION (object-fit: cover):
- Primary subject in CENTER 60% safe zone
- Edges will be cropped - no critical details near borders
- Strong vertical continuity for tall panel display

FOR PEOPLE:
- Real professionals in authentic contexts (thinking, working, discussing, reviewing)
- Mid-torso framing, thoughtful expressions, natural posture
- Head/face NOT near top edge
- Neutral, inward-focused - not posed or stock-photo style

FOR ENVIRONMENTS:
- Workspaces, screens, whiteboards, meeting rooms, data visualizations
- Show context that matches the story (messy desk for tension, clean setup for resolution)
- Atmospheric lighting that matches the narrative mood

FOR VIDEO:
- 6-12 seconds, seamless loop
- Show subtle real-world motion (typing, scrolling, ambient office activity)
- Living moment, not a scene with narrative progression

STYLE: Cinematic, editorial photography quality. Dark theme. Calm but engaging. Supports reading.
';

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
        add_action('init', array($this, 'register_ajax_handlers'));
        add_action('admin_menu', array($this, 'add_settings_page'));
        add_action('admin_init', array($this, 'register_settings'));
    }

    /**
     * Register AJAX handlers
     */
    public function register_ajax_handlers() {
        // Admin-only handlers (require login)
        add_action('wp_ajax_gemini_generate_image', array($this, 'ajax_generate_image'));
        add_action('wp_ajax_gemini_generate_narrative_visuals', array($this, 'ajax_generate_narrative_visuals'));

        // Public handler for demo pages (uses transient caching)
        add_action('wp_ajax_gemini_get_demo_visuals', array($this, 'ajax_get_demo_visuals'));
        add_action('wp_ajax_nopriv_gemini_get_demo_visuals', array($this, 'ajax_get_demo_visuals'));
    }

    /**
     * Get API key
     */
    private function get_api_key() {
        // Check for constant first (wp-config.php)
        if (defined('GEMINI_API_KEY') && GEMINI_API_KEY) {
            return GEMINI_API_KEY;
        }

        // Fall back to option
        return get_option('bfluxco_gemini_api_key', '');
    }

    /**
     * Check if API is configured
     */
    public function is_configured() {
        return !empty($this->get_api_key());
    }

    /**
     * Generate image from text prompt
     *
     * @param string $prompt The text prompt for image generation
     * @param array  $options Generation options
     * @return array|WP_Error Response with image data or error
     */
    public function generate_image($prompt, $options = array()) {
        $api_key = $this->get_api_key();

        if (empty($api_key)) {
            return new WP_Error('no_api_key', 'Gemini API key not configured');
        }

        $defaults = array(
            'aspect_ratio' => self::DEFAULT_ASPECT_RATIO,
            'style' => 'photorealistic',
            'mood' => 'professional',
            'number_of_images' => 1,
            'media_type' => 'image', // 'image' or 'video'
        );

        $options = wp_parse_args($options, $defaults);

        // Build enhanced prompt with style guidance
        $enhanced_prompt = $this->build_enhanced_prompt($prompt, $options);

        // API request
        $url = self::API_ENDPOINT . self::IMAGE_MODEL . ':generateImage?key=' . $api_key;

        $body = array(
            'prompt' => $enhanced_prompt,
            'config' => array(
                'numberOfImages' => $options['number_of_images'],
                'aspectRatio' => $options['aspect_ratio'],
                'safetyFilterLevel' => 'BLOCK_MEDIUM_AND_ABOVE',
            ),
        );

        $response = wp_remote_post($url, array(
            'headers' => array(
                'Content-Type' => 'application/json',
            ),
            'body' => wp_json_encode($body),
            'timeout' => 60,
        ));

        if (is_wp_error($response)) {
            return $response;
        }

        $status_code = wp_remote_retrieve_response_code($response);
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);

        if ($status_code !== 200) {
            $error_message = isset($data['error']['message']) ? $data['error']['message'] : 'Unknown API error';
            return new WP_Error('api_error', $error_message, array('status' => $status_code));
        }

        return $data;
    }

    /**
     * Generate image using Gemini's native image generation
     * (Alternative method using generateContent with image output)
     *
     * @param string $prompt The text prompt
     * @param array  $options Options
     * @return array|WP_Error
     */
    public function generate_with_gemini($prompt, $options = array()) {
        $api_key = $this->get_api_key();

        if (empty($api_key)) {
            return new WP_Error('no_api_key', 'Gemini API key not configured');
        }

        $defaults = array(
            'aspect_ratio' => self::DEFAULT_ASPECT_RATIO,
            'style' => 'cinematic',
            'mood' => 'professional',
            'media_type' => 'image', // 'image' or 'video'
        );

        $options = wp_parse_args($options, $defaults);

        // Use Gemini 2.0 Flash for image generation
        $url = self::API_ENDPOINT . self::DEFAULT_MODEL . ':generateContent?key=' . $api_key;

        $enhanced_prompt = $this->build_enhanced_prompt($prompt, $options);

        $body = array(
            'contents' => array(
                array(
                    'parts' => array(
                        array('text' => "Generate an image: " . $enhanced_prompt)
                    )
                )
            ),
            'generationConfig' => array(
                'responseModalities' => array('image', 'text'),
            ),
        );

        $response = wp_remote_post($url, array(
            'headers' => array(
                'Content-Type' => 'application/json',
            ),
            'body' => wp_json_encode($body),
            'timeout' => 90,
        ));

        if (is_wp_error($response)) {
            return $response;
        }

        $status_code = wp_remote_retrieve_response_code($response);
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);

        if ($status_code !== 200) {
            $error_message = isset($data['error']['message']) ? $data['error']['message'] : 'Unknown API error';
            return new WP_Error('api_error', $error_message, array('status' => $status_code));
        }

        // Extract image from response
        if (isset($data['candidates'][0]['content']['parts'])) {
            foreach ($data['candidates'][0]['content']['parts'] as $part) {
                if (isset($part['inlineData'])) {
                    return array(
                        'success' => true,
                        'image' => array(
                            'data' => $part['inlineData']['data'],
                            'mimeType' => $part['inlineData']['mimeType'],
                        ),
                    );
                }
            }
        }

        return new WP_Error('no_image', 'No image generated in response');
    }

    /**
     * Generate video from text prompt using Veo
     *
     * @param string $prompt The text prompt for video generation
     * @param array  $options Generation options
     * @return array|WP_Error Response with video data or error
     */
    public function generate_video($prompt, $options = array()) {
        $api_key = $this->get_api_key();

        if (empty($api_key)) {
            return new WP_Error('no_api_key', 'Gemini API key not configured');
        }

        $defaults = array(
            'aspect_ratio' => self::DEFAULT_ASPECT_RATIO,
            'duration_seconds' => 5,
            'style' => 'cinematic',
        );

        $options = wp_parse_args($options, $defaults);

        // Build enhanced prompt
        $enhanced_prompt = $this->build_enhanced_prompt($prompt, $options);

        // Veo video generation endpoint
        $url = self::API_ENDPOINT . self::VIDEO_MODEL . ':generateContent?key=' . $api_key;

        $body = array(
            'contents' => array(
                array(
                    'parts' => array(
                        array('text' => "Generate a short video: " . $enhanced_prompt)
                    )
                )
            ),
            'generationConfig' => array(
                'responseModalities' => array('video'),
            ),
        );

        $response = wp_remote_post($url, array(
            'headers' => array(
                'Content-Type' => 'application/json',
            ),
            'body' => wp_json_encode($body),
            'timeout' => 120, // Videos take longer
        ));

        if (is_wp_error($response)) {
            return $response;
        }

        $status_code = wp_remote_retrieve_response_code($response);
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);

        if ($status_code !== 200) {
            $error_message = isset($data['error']['message']) ? $data['error']['message'] : 'Unknown API error';
            return new WP_Error('api_error', $error_message, array('status' => $status_code));
        }

        // Extract video from response
        if (isset($data['candidates'][0]['content']['parts'])) {
            foreach ($data['candidates'][0]['content']['parts'] as $part) {
                if (isset($part['inlineData']) && strpos($part['inlineData']['mimeType'], 'video') !== false) {
                    return array(
                        'success' => true,
                        'video' => array(
                            'data' => $part['inlineData']['data'],
                            'mimeType' => $part['inlineData']['mimeType'],
                        ),
                        'media_type' => 'video',
                    );
                }
            }
        }

        return new WP_Error('no_video', 'No video generated in response');
    }

    /**
     * Generate visual (image or video) based on context
     * AI decides whether image or video is more appropriate
     *
     * @param string $prompt The text prompt
     * @param array  $options Options including 'prefer' => 'image'|'video'|'auto'
     * @return array|WP_Error
     */
    public function generate_visual($prompt, $options = array()) {
        $defaults = array(
            'prefer' => 'image', // 'image', 'video', or 'auto'
            'aspect_ratio' => self::DEFAULT_ASPECT_RATIO,
            'style' => 'cinematic',
            'mood' => 'professional',
        );

        $options = wp_parse_args($options, $defaults);

        // For now, default to image generation (more reliable)
        // Video generation can be explicitly requested
        if ($options['prefer'] === 'video') {
            $result = $this->generate_video($prompt, $options);
            if (!is_wp_error($result)) {
                return $result;
            }
            // Fall back to image if video fails
        }

        // Generate image
        $result = $this->generate_with_gemini($prompt, $options);
        if (!is_wp_error($result) && isset($result['image'])) {
            $result['media_type'] = 'image';
        }

        return $result;
    }

    /**
     * Generate contextual text overlays for each narrative state
     *
     * @param string $context The case study context
     * @param array  $states  The narrative states with descriptions
     * @return array|WP_Error
     */
    public function generate_overlay_text($context, $states) {
        if (!$this->api_key) {
            return new WP_Error('no_api_key', 'Gemini API key not configured');
        }

        $prompt = sprintf(
            'You are a senior UX copywriter creating text overlays for a cinematic case study presentation about: %s

Write ENGAGING, STORY-DRIVEN copy that draws viewers in. NOT section titles. Think documentary narration meets Apple keynote.

Guidelines:
- Headlines should feel like story beats, not labels
- Use active voice, present tense
- Create emotional resonance
- Be specific, not generic
- Headlines: 4-8 words, punchy and memorable
- Subheads: 2-5 words, contextual anchor

Examples of GOOD copy:
- "When everything breaks at once" (not "The Challenge")
- "A radical simplification" (not "Our Approach")
- "The moment it clicked" (not "The Solution")

Return ONLY valid JSON:
{
  "grounding": {
    "position": "bottom-left",
    "subhead": "contextual anchor phrase",
    "headline": "engaging story opener that hooks the viewer"
  },
  "tension": {
    "position": "bottom-left",
    "subhead": "tension builder phrase",
    "headline": "dramatic problem statement that creates stakes"
  },
  "decision": {
    "position": "bottom-left",
    "subhead": "turning point phrase",
    "headline": "compelling insight or approach that shifted everything"
  },
  "outcome": {
    "position": "center",
    "stat": "impressive metric (use %% for percent, or a number)",
    "stat_label": "what changed (2-4 words)"
  }
}

Context for each phase:
- grounding: %s
- tension: %s
- decision: %s
- outcome: %s

Return ONLY the JSON, no markdown or explanation.',
            $context,
            isset($states['grounding']) ? $states['grounding'] : 'establishing context',
            isset($states['tension']) ? $states['tension'] : 'the challenge',
            isset($states['decision']) ? $states['decision'] : 'the approach',
            isset($states['outcome']) ? $states['outcome'] : 'the results'
        );

        // Use Gemini text generation endpoint
        $url = sprintf(
            'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash-exp:generateContent?key=%s',
            $this->api_key
        );

        $body = array(
            'contents' => array(
                array(
                    'parts' => array(
                        array('text' => $prompt),
                    ),
                ),
            ),
            'generationConfig' => array(
                'temperature' => 0.7,
                'maxOutputTokens' => 500,
            ),
        );

        $response = wp_remote_post($url, array(
            'timeout' => 30,
            'headers' => array('Content-Type' => 'application/json'),
            'body' => wp_json_encode($body),
        ));

        if (is_wp_error($response)) {
            return $response;
        }

        $status_code = wp_remote_retrieve_response_code($response);
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);

        if ($status_code !== 200) {
            $error_message = isset($data['error']['message']) ? $data['error']['message'] : 'Unknown API error';
            return new WP_Error('api_error', $error_message);
        }

        // Extract text from response
        if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
            $text = $data['candidates'][0]['content']['parts'][0]['text'];

            // Clean up any markdown formatting
            $text = preg_replace('/```json\s*/i', '', $text);
            $text = preg_replace('/```\s*/i', '', $text);
            $text = trim($text);

            $parsed = json_decode($text, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($parsed)) {
                return $parsed;
            }
        }

        return new WP_Error('parse_error', 'Could not parse text overlay response');
    }

    /**
     * Build enhanced prompt with style and composition guidance
     */
    private function build_enhanced_prompt($prompt, $options) {
        $style_guides = array(
            'photorealistic' => 'photorealistic, high detail, professional photography, 8k resolution, real people and environments',
            'cinematic' => 'cinematic lighting, film grain, dramatic composition, movie still quality, documentary style',
            'editorial' => 'editorial photography, authentic moments, candid professional settings, magazine quality',
            'narrative' => 'story-driven, real scenarios, authentic workplace moments, documentary photography',
            'dark_corporate' => 'dark theme, corporate setting, professional atmosphere, real office environments',
            'immersive' => 'immersive, atmospheric, editorial quality, authentic professional contexts',
        );

        $mood_guides = array(
            'professional' => 'professional atmosphere, business context, thoughtful',
            'grounding' => 'calm, stable, establishing context, neutral tones, atmospheric depth',
            'tension' => 'dramatic, challenging, obstacles, warm accent colors, building pressure',
            'decision' => 'pivotal moment, choice, clarity emerging, primary brand colors, focused',
            'outcome' => 'resolution, achievement, results, cool tones, expansive feeling',
        );

        $style = isset($style_guides[$options['style']]) ? $style_guides[$options['style']] : $style_guides['cinematic'];
        $mood = isset($mood_guides[$options['mood']]) ? $mood_guides[$options['mood']] : $mood_guides['professional'];

        // Include composition requirements for crop-safe cover display
        $composition = self::MEDIA_COMPOSITION_PROMPT;

        return sprintf(
            "%s\n\nStyle: %s. Mood: %s. Aspect ratio: %s. No text or watermarks.\n\n%s",
            $prompt,
            $style,
            $mood,
            $options['aspect_ratio'],
            $composition
        );
    }

    /**
     * Generate visuals for all narrative states of a case study
     *
     * @param string $case_study_context Brief description of the case study
     * @param array  $states Array of narrative states with descriptions
     * @return array Generated images for each state
     */
    public function generate_narrative_visuals($case_study_context, $states = array()) {
        $default_states = array(
            'grounding' => 'establishing the context and background',
            'tension' => 'revealing the challenge and obstacles',
            'decision' => 'the pivotal moment of choice',
            'outcome' => 'the results and resolution',
        );

        $states = wp_parse_args($states, $default_states);
        $results = array();

        foreach ($states as $state_id => $state_description) {
            $prompt = sprintf(
                "Abstract visual representation for a case study about %s. This image represents the '%s' phase: %s. Dark theme, suitable for a professional portfolio website.",
                $case_study_context,
                $state_id,
                $state_description
            );

            $result = $this->generate_with_gemini($prompt, array(
                'style' => 'dark_corporate',
                'mood' => $state_id,
                'aspect_ratio' => '16:9',
            ));

            if (is_wp_error($result)) {
                $results[$state_id] = array(
                    'success' => false,
                    'error' => $result->get_error_message(),
                );
            } else {
                $results[$state_id] = $result;
            }

            // Rate limiting - pause between requests
            sleep(2);
        }

        return $results;
    }

    /**
     * Save generated image to media library
     *
     * @param string $base64_data Base64 encoded image data
     * @param string $filename Desired filename
     * @param int    $post_id Optional post to attach to
     * @return int|WP_Error Attachment ID or error
     */
    public function save_to_media_library($base64_data, $filename, $post_id = 0) {
        $upload_dir = wp_upload_dir();

        // Decode base64
        $image_data = base64_decode($base64_data);

        if ($image_data === false) {
            return new WP_Error('decode_failed', 'Failed to decode image data');
        }

        // Generate unique filename
        $filename = sanitize_file_name($filename);
        $filename = wp_unique_filename($upload_dir['path'], $filename);
        $filepath = $upload_dir['path'] . '/' . $filename;

        // Save file
        $saved = file_put_contents($filepath, $image_data);

        if ($saved === false) {
            return new WP_Error('save_failed', 'Failed to save image file');
        }

        // Get mime type
        $mime_type = wp_check_filetype($filename)['type'] ?: 'image/png';

        // Create attachment
        $attachment = array(
            'post_mime_type' => $mime_type,
            'post_title' => preg_replace('/\.[^.]+$/', '', $filename),
            'post_content' => '',
            'post_status' => 'inherit',
        );

        $attachment_id = wp_insert_attachment($attachment, $filepath, $post_id);

        if (is_wp_error($attachment_id)) {
            return $attachment_id;
        }

        // Generate metadata
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        $metadata = wp_generate_attachment_metadata($attachment_id, $filepath);
        wp_update_attachment_metadata($attachment_id, $metadata);

        // Mark as AI-generated
        update_post_meta($attachment_id, '_ai_generated', true);
        update_post_meta($attachment_id, '_ai_generator', 'gemini');

        return $attachment_id;
    }

    /**
     * AJAX handler for single image generation
     */
    public function ajax_generate_image() {
        check_ajax_referer('gemini_generate', 'nonce');

        if (!current_user_can('upload_files')) {
            wp_send_json_error('Permission denied', 403);
        }

        $prompt = isset($_POST['prompt']) ? sanitize_textarea_field($_POST['prompt']) : '';

        if (empty($prompt)) {
            wp_send_json_error('Prompt is required');
        }

        $options = array(
            'style' => isset($_POST['style']) ? sanitize_text_field($_POST['style']) : 'cinematic',
            'mood' => isset($_POST['mood']) ? sanitize_text_field($_POST['mood']) : 'professional',
            'aspect_ratio' => isset($_POST['aspect_ratio']) ? sanitize_text_field($_POST['aspect_ratio']) : '16:9',
        );

        $result = $this->generate_with_gemini($prompt, $options);

        if (is_wp_error($result)) {
            wp_send_json_error($result->get_error_message());
        }

        // Optionally save to media library
        if (!empty($_POST['save_to_library']) && isset($result['image'])) {
            $filename = 'gemini-' . sanitize_title(substr($prompt, 0, 30)) . '-' . time() . '.png';
            $attachment_id = $this->save_to_media_library($result['image']['data'], $filename);

            if (!is_wp_error($attachment_id)) {
                $result['attachment_id'] = $attachment_id;
                $result['attachment_url'] = wp_get_attachment_url($attachment_id);
            }
        }

        wp_send_json_success($result);
    }

    /**
     * AJAX handler for narrative visuals generation
     */
    public function ajax_generate_narrative_visuals() {
        check_ajax_referer('gemini_generate', 'nonce');

        if (!current_user_can('upload_files')) {
            wp_send_json_error('Permission denied', 403);
        }

        $context = isset($_POST['context']) ? sanitize_textarea_field($_POST['context']) : '';
        $post_id = isset($_POST['post_id']) ? absint($_POST['post_id']) : 0;

        if (empty($context)) {
            wp_send_json_error('Case study context is required');
        }

        $states = array();
        if (!empty($_POST['states']) && is_array($_POST['states'])) {
            foreach ($_POST['states'] as $state_id => $description) {
                $states[sanitize_key($state_id)] = sanitize_text_field($description);
            }
        }

        $results = $this->generate_narrative_visuals($context, $states);

        // Save successful images to media library
        $saved_images = array();
        foreach ($results as $state_id => $result) {
            if (!empty($result['success']) && isset($result['image'])) {
                $filename = sprintf('narrative-%s-%s-%d.png', $state_id, sanitize_title(substr($context, 0, 20)), time());
                $attachment_id = $this->save_to_media_library($result['image']['data'], $filename, $post_id);

                if (!is_wp_error($attachment_id)) {
                    $saved_images[$state_id] = array(
                        'attachment_id' => $attachment_id,
                        'url' => wp_get_attachment_url($attachment_id),
                    );
                }
            }
        }

        wp_send_json_success(array(
            'results' => $results,
            'saved_images' => $saved_images,
        ));
    }

    /**
     * Public AJAX handler for demo visuals (cached)
     * No authentication required, but uses transient caching to prevent abuse.
     */
    public function ajax_get_demo_visuals() {
        $post_id = isset($_POST['post_id']) ? absint($_POST['post_id']) : 0;
        $context = isset($_POST['context']) ? sanitize_textarea_field($_POST['context']) : 'case study';
        $force_regenerate = isset($_POST['force_regenerate']) && $_POST['force_regenerate'] === '1';

        if (!$post_id) {
            wp_send_json_error('Post ID required');
        }

        // Check transient cache first (24 hour cache)
        $cache_key = 'gemini_demo_' . $post_id;

        // Clear cache if force regenerate requested
        if ($force_regenerate) {
            delete_transient($cache_key);
        }

        $cached = get_transient($cache_key);

        if ($cached && is_array($cached) && !$force_regenerate) {
            wp_send_json_success(array(
                'images' => $cached,
                'cached' => true,
            ));
        }

        // Generate new images
        $states = array(
            'grounding' => 'establishing context, wide view, neutral tones',
            'tension' => 'challenge and obstacles, dramatic, warm accents',
            'decision' => 'pivotal choice, clarity, focused, teal green',
            'outcome' => 'resolution and success, expansive, purple blue',
        );

        // Override with custom states if provided
        if (!empty($_POST['states']) && is_array($_POST['states'])) {
            foreach ($_POST['states'] as $state_id => $description) {
                $states[sanitize_key($state_id)] = sanitize_text_field($description);
            }
        }

        $results = array();
        $errors = array();
        $all_success = true;

        // Define media configuration per state
        // Each state can have multiple media items (images/videos)
        // Focus descriptions should be narrative and contextual
        $media_config = array(
            'grounding' => array(
                array('type' => 'image', 'focus' => 'professional reviewing documents or screens, establishing the situation'),
            ),
            'tension' => array(
                array('type' => 'video', 'focus' => 'person encountering a problem, frustration or complexity visible'),
                array('type' => 'image', 'focus' => 'close-up of hands on keyboard or troubled expression'),
            ),
            'decision' => array(
                array('type' => 'image', 'focus' => 'moment of realization, person having insight or making a choice'),
            ),
            'outcome' => array(
                array('type' => 'image', 'focus' => 'satisfied professional viewing successful results on screen'),
                array('type' => 'image', 'focus' => 'team celebrating or relaxed after achievement'),
            ),
        );

        // Define contextual text overlays for each state
        $state_text = array(
            'grounding' => array(
                'position' => 'bottom-left',
                'subhead' => '',
                'headline' => '',
            ),
            'tension' => array(
                'position' => 'bottom-left',
                'subhead' => '',
                'headline' => '',
            ),
            'decision' => array(
                'position' => 'bottom-left',
                'subhead' => '',
                'headline' => '',
            ),
            'outcome' => array(
                'position' => 'center',
                'stat' => '',
                'stat_label' => '',
            ),
        );

        // Generate contextual text for each state using Gemini
        $text_result = $this->generate_overlay_text($context, $states);
        if (!is_wp_error($text_result) && is_array($text_result)) {
            $state_text = array_merge($state_text, $text_result);
        }

        foreach ($states as $state_id => $state_description) {
            $state_media = array();
            $state_config = isset($media_config[$state_id]) ? $media_config[$state_id] : array(array('type' => 'image', 'focus' => ''));

            // Generate each media item for this state
            foreach ($state_config as $media_index => $media_item) {
                $media_type = $media_item['type'];
                $media_focus = $media_item['focus'];

                // Build narrative-driven prompt (NOT abstract)
                $prompt = sprintf(
                    "Photorealistic, story-driven image for a case study about: %s

NARRATIVE PHASE '%s': %s
VISUAL FOCUS: %s

REQUIREMENTS:
- Show REAL people, environments, or moments - NOT abstract art
- Illustrate this specific story beat with recognizable context
- People should be professionals in authentic work scenarios
- Environments should match the narrative (workspaces, screens, meetings)
- Cinematic, editorial photography quality
- Dark/moody lighting, atmospheric

COMPOSITION: Subject in center 60%% safe zone (edges will be cropped). Strong vertical framing.

No text, watermarks, or stock-photo poses.",
                    $context,
                    $state_id,
                    $state_description,
                    $media_focus
                );

                $result = null;
                $is_video = false;

                if ($media_type === 'video') {
                    $video_prompt = sprintf(
                        "Cinematic video clip for a case study about: %s

NARRATIVE PHASE '%s': %s
VISUAL FOCUS: %s

REQUIREMENTS:
- Show REAL scenarios - NOT abstract motion graphics
- People working, thinking, collaborating, or reviewing
- Authentic office/workspace environments with subtle activity
- 6-10 seconds, seamless loop
- Slow, ambient motion (typing, scrolling, ambient movement)

COMPOSITION: Subject in center 60%% safe zone. Edges may be cropped.

STYLE: Cinematic, dark/moody, editorial quality. No text or watermarks.",
                        $context,
                        $state_id,
                        $state_description,
                        $media_focus
                    );

                    $result = $this->generate_video($video_prompt, array(
                        'style' => 'cinematic',
                        'aspect_ratio' => self::DEFAULT_ASPECT_RATIO,
                        'duration_seconds' => 5,
                    ));

                    if (!is_wp_error($result) && isset($result['video'])) {
                        $is_video = true;
                    } else {
                        // Video failed, fall back to image
                        $result = null;
                    }
                }

                // Generate image if not video or video failed
                if (!$is_video) {
                    $result = $this->generate_with_gemini($prompt, array(
                        'style' => 'narrative',
                        'mood' => $state_id,
                        'aspect_ratio' => self::DEFAULT_ASPECT_RATIO,
                    ));
                }

                if (is_wp_error($result)) {
                    $errors[$state_id . '_' . $media_index] = $result->get_error_message();
                } elseif ($is_video && isset($result['video'])) {
                    // Save video to media library
                    $filename = sprintf('demo-%d-%s-%d-%d.mp4', $post_id, $state_id, $media_index, time());
                    $attachment_id = $this->save_to_media_library($result['video']['data'], $filename, $post_id);

                    if (!is_wp_error($attachment_id)) {
                        $state_media[] = array(
                            'url' => wp_get_attachment_url($attachment_id),
                            'type' => 'video',
                            'focus' => $media_focus,
                        );
                    } else {
                        $errors[$state_id . '_' . $media_index] = 'Video save failed';
                    }
                } elseif (isset($result['image'])) {
                    // Save image to media library
                    $filename = sprintf('demo-%d-%s-%d-%d.png', $post_id, $state_id, $media_index, time());
                    $attachment_id = $this->save_to_media_library($result['image']['data'], $filename, $post_id);

                    if (!is_wp_error($attachment_id)) {
                        $state_media[] = array(
                            'url' => wp_get_attachment_url($attachment_id),
                            'type' => 'image',
                            'focus' => $media_focus,
                        );
                    } else {
                        $errors[$state_id . '_' . $media_index] = 'Save failed';
                    }
                }

                // Rate limit between requests
                usleep(500000); // 0.5 second
            }

            // Store results for this state
            if (!empty($state_media)) {
                $results[$state_id] = array(
                    'media' => $state_media,
                    'text' => isset($state_text[$state_id]) ? $state_text[$state_id] : null,
                );
            } else {
                $all_success = false;
            }
        }

        // Cache results for 24 hours if we got at least some images
        if (!empty($results)) {
            set_transient($cache_key, $results, DAY_IN_SECONDS);
        }

        wp_send_json_success(array(
            'images' => $results,
            'cached' => false,
            'complete' => $all_success,
            'errors' => $errors,
        ));
    }

    /**
     * Add settings page
     */
    public function add_settings_page() {
        add_submenu_page(
            'bfluxco-options',
            'Gemini Image Settings',
            'Gemini Images',
            'manage_options',
            'bfluxco-gemini',
            array($this, 'render_settings_page')
        );
    }

    /**
     * Register settings
     */
    public function register_settings() {
        register_setting('bfluxco_gemini', 'bfluxco_gemini_api_key', array(
            'type' => 'string',
            'sanitize_callback' => 'sanitize_text_field',
        ));
    }

    /**
     * Render settings page
     */
    public function render_settings_page() {
        $api_key = get_option('bfluxco_gemini_api_key', '');
        $is_configured = $this->is_configured();
        ?>
        <div class="wrap">
            <h1>Gemini Image Generation Settings</h1>

            <?php if ($is_configured): ?>
                <div class="notice notice-success">
                    <p><strong>Gemini API is configured.</strong> You can generate images for voice case studies.</p>
                </div>
            <?php else: ?>
                <div class="notice notice-warning">
                    <p><strong>API key required.</strong> Get your key from <a href="https://aistudio.google.com/apikey" target="_blank">Google AI Studio</a>.</p>
                </div>
            <?php endif; ?>

            <form method="post" action="options.php">
                <?php settings_fields('bfluxco_gemini'); ?>

                <table class="form-table">
                    <tr>
                        <th scope="row">Gemini API Key</th>
                        <td>
                            <input type="password"
                                   name="bfluxco_gemini_api_key"
                                   value="<?php echo esc_attr($api_key); ?>"
                                   class="regular-text"
                                   autocomplete="off">
                            <p class="description">
                                Or define <code>GEMINI_API_KEY</code> in wp-config.php for better security.
                            </p>
                        </td>
                    </tr>
                </table>

                <?php submit_button('Save Settings'); ?>
            </form>

            <?php if ($is_configured): ?>
            <hr>
            <h2>Test Image Generation</h2>
            <div id="gemini-test-form">
                <p>
                    <label for="test-prompt"><strong>Prompt:</strong></label><br>
                    <textarea id="test-prompt" rows="3" class="large-text">Abstract visualization of digital transformation in healthcare, dark theme, professional</textarea>
                </p>
                <p>
                    <label><strong>Style:</strong></label><br>
                    <select id="test-style">
                        <option value="cinematic">Cinematic</option>
                        <option value="photorealistic">Photorealistic</option>
                        <option value="abstract">Abstract</option>
                        <option value="dark_corporate">Dark Corporate</option>
                    </select>
                </p>
                <p>
                    <button type="button" id="test-generate" class="button button-primary">Generate Test Image</button>
                    <span id="test-status" style="margin-left: 10px;"></span>
                </p>
                <div id="test-result" style="margin-top: 20px;"></div>
            </div>

            <script>
            jQuery(document).ready(function($) {
                $('#test-generate').on('click', function() {
                    var $btn = $(this);
                    var $status = $('#test-status');
                    var $result = $('#test-result');

                    $btn.prop('disabled', true);
                    $status.text('Generating...');
                    $result.empty();

                    $.post(ajaxurl, {
                        action: 'gemini_generate_image',
                        nonce: '<?php echo wp_create_nonce('gemini_generate'); ?>',
                        prompt: $('#test-prompt').val(),
                        style: $('#test-style').val(),
                        save_to_library: true
                    }, function(response) {
                        $btn.prop('disabled', false);

                        if (response.success && response.data.image) {
                            $status.text('Success!');
                            $result.html('<img src="data:' + response.data.image.mimeType + ';base64,' + response.data.image.data + '" style="max-width: 100%; border-radius: 8px;">');

                            if (response.data.attachment_url) {
                                $result.append('<p style="margin-top: 10px;"><a href="' + response.data.attachment_url + '" target="_blank">View in Media Library</a></p>');
                            }
                        } else {
                            $status.text('Error: ' + (response.data || 'Unknown error'));
                        }
                    }).fail(function() {
                        $btn.prop('disabled', false);
                        $status.text('Request failed');
                    });
                });
            });
            </script>
            <?php endif; ?>
        </div>
        <?php
    }
}

// Initialize
BFLUXCO_Gemini_Image::get_instance();
