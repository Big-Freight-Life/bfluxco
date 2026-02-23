<?php
/**
 * AI Chat Settings
 *
 * Handles storage and retrieval of AI Chat configuration.
 *
 * @package BFLUXCO
 */

if (!defined('ABSPATH')) {
    exit;
}

class BFLUXCO_AI_Chat_Settings {

    /**
     * Option names
     */
    const BEHAVIOR_OPTION = 'bfluxco_ai_behavior';
    const SYSTEM_OPTION = 'bfluxco_ai_system';
    const BOUNDARIES_OPTION = 'bfluxco_ai_boundaries';
    const PERSONA_OPTION = 'bfluxco_ai_persona';
    const PERSONA_VERSIONS_OPTION = 'bfluxco_ai_persona_versions';

    /**
     * Default behavior settings
     */
    private static function get_behavior_defaults() {
        return array(
            'enabled' => true,
            'tone' => 'professional',
            'response_length' => 'medium',
            'max_tokens' => 500,
            'temperature' => 0.7,
            'ask_clarifying_questions' => true,
            'features' => array(
                'chat_responses' => true,
                'image_generation' => false,
                'cta_generation' => true,
                'form_generation' => false,
            ),
            'cta' => array(
                'enabled' => true,
                'min_turns_before_cta' => 2,
                'frequency_cap' => 3,
            ),
        );
    }

    /**
     * Default system settings
     */
    private static function get_system_defaults() {
        return array(
            'primary_provider' => 'mistral',
            'fallback_provider' => '',
            'rate_limit_per_minute' => 10,
            'rate_limit_per_day' => 500,
            'api_timeout' => 30,
            'retry_attempts' => 2,
            'data_retention_days' => 30,
            'logging_level' => 'metadata',
        );
    }

    /**
     * Default boundary settings
     */
    private static function get_boundaries_defaults() {
        return array(
            'restricted_topics' => array(
                'medical_advice' => true,
                'legal_advice' => true,
                'financial_advice' => true,
                'competitor_info' => true,
            ),
            'max_response_length' => 1000,
            'fallback_message' => "I'm not able to help with that specific topic, but I'd be happy to connect you with Ray who can provide expert guidance.",
        );
    }

    /**
     * Get behavior settings
     */
    public static function get_behavior() {
        $saved = get_option(self::BEHAVIOR_OPTION, array());
        return wp_parse_args($saved, self::get_behavior_defaults());
    }

    /**
     * Save behavior settings
     */
    public static function save_behavior($data) {
        $sanitized = self::sanitize_behavior($data);
        return update_option(self::BEHAVIOR_OPTION, $sanitized);
    }

    /**
     * Sanitize behavior settings
     */
    private static function sanitize_behavior($data) {
        $defaults = self::get_behavior_defaults();
        $sanitized = array();

        $sanitized['enabled'] = !empty($data['enabled']);
        $sanitized['tone'] = in_array($data['tone'] ?? '', array('professional', 'friendly', 'casual'))
            ? $data['tone']
            : $defaults['tone'];
        $sanitized['response_length'] = in_array($data['response_length'] ?? '', array('short', 'medium', 'long'))
            ? $data['response_length']
            : $defaults['response_length'];
        $sanitized['max_tokens'] = min(max(absint($data['max_tokens'] ?? 500), 100), 2000);
        $sanitized['temperature'] = min(max(floatval($data['temperature'] ?? 0.7), 0), 1);
        $sanitized['ask_clarifying_questions'] = !empty($data['ask_clarifying_questions']);

        // Features
        $sanitized['features'] = array(
            'chat_responses' => !empty($data['features']['chat_responses']),
            'image_generation' => !empty($data['features']['image_generation']),
            'cta_generation' => !empty($data['features']['cta_generation']),
            'form_generation' => !empty($data['features']['form_generation']),
        );

        // CTA settings
        $sanitized['cta'] = array(
            'enabled' => !empty($data['cta']['enabled']),
            'min_turns_before_cta' => min(max(absint($data['cta']['min_turns_before_cta'] ?? 2), 1), 10),
            'frequency_cap' => min(max(absint($data['cta']['frequency_cap'] ?? 3), 1), 10),
        );

        return $sanitized;
    }

    /**
     * Get system settings
     */
    public static function get_system() {
        $saved = get_option(self::SYSTEM_OPTION, array());
        return wp_parse_args($saved, self::get_system_defaults());
    }

    /**
     * Save system settings
     */
    public static function save_system($data) {
        $sanitized = self::sanitize_system($data);
        return update_option(self::SYSTEM_OPTION, $sanitized);
    }

    /**
     * Sanitize system settings
     */
    private static function sanitize_system($data) {
        $defaults = self::get_system_defaults();
        $sanitized = array();

        $sanitized['primary_provider'] = in_array($data['primary_provider'] ?? '', array('mistral', 'openai', 'gemini'))
            ? $data['primary_provider']
            : $defaults['primary_provider'];
        $sanitized['fallback_provider'] = in_array($data['fallback_provider'] ?? '', array('', 'mistral', 'openai', 'gemini'))
            ? $data['fallback_provider']
            : '';
        $sanitized['rate_limit_per_minute'] = min(max(absint($data['rate_limit_per_minute'] ?? 10), 1), 100);
        $sanitized['rate_limit_per_day'] = min(max(absint($data['rate_limit_per_day'] ?? 500), 10), 10000);
        $sanitized['api_timeout'] = min(max(absint($data['api_timeout'] ?? 30), 5), 120);
        $sanitized['retry_attempts'] = min(max(absint($data['retry_attempts'] ?? 2), 0), 5);
        $sanitized['data_retention_days'] = min(max(absint($data['data_retention_days'] ?? 30), 7), 365);
        $sanitized['logging_level'] = in_array($data['logging_level'] ?? '', array('metadata', 'expanded'))
            ? $data['logging_level']
            : $defaults['logging_level'];

        return $sanitized;
    }

    /**
     * Get boundary settings
     */
    public static function get_boundaries() {
        $saved = get_option(self::BOUNDARIES_OPTION, array());
        return wp_parse_args($saved, self::get_boundaries_defaults());
    }

    /**
     * Save boundary settings
     */
    public static function save_boundaries($data) {
        $sanitized = self::sanitize_boundaries($data);
        return update_option(self::BOUNDARIES_OPTION, $sanitized);
    }

    /**
     * Sanitize boundary settings
     */
    private static function sanitize_boundaries($data) {
        $defaults = self::get_boundaries_defaults();
        $sanitized = array();

        $sanitized['restricted_topics'] = array(
            'medical_advice' => !empty($data['restricted_topics']['medical_advice']),
            'legal_advice' => !empty($data['restricted_topics']['legal_advice']),
            'financial_advice' => !empty($data['restricted_topics']['financial_advice']),
            'competitor_info' => !empty($data['restricted_topics']['competitor_info']),
        );
        $sanitized['max_response_length'] = min(max(absint($data['max_response_length'] ?? 1000), 100), 5000);
        $sanitized['fallback_message'] = sanitize_textarea_field($data['fallback_message'] ?? $defaults['fallback_message']);

        return $sanitized;
    }

    /**
     * Get runtime config for chatbot API
     * Merges behavior and system settings into a single config object
     */
    public static function get_runtime_config() {
        $behavior = self::get_behavior();
        $system = self::get_system();
        $boundaries = self::get_boundaries();

        return array(
            'enabled' => $behavior['enabled'],
            'provider' => $system['primary_provider'],
            'fallback_provider' => $system['fallback_provider'],
            'max_tokens' => $behavior['max_tokens'],
            'temperature' => $behavior['temperature'],
            'tone' => $behavior['tone'],
            'response_length' => $behavior['response_length'],
            'ask_clarifying_questions' => $behavior['ask_clarifying_questions'],
            'features' => $behavior['features'],
            'cta' => $behavior['cta'],
            'rate_limit_per_minute' => $system['rate_limit_per_minute'],
            'rate_limit_per_day' => $system['rate_limit_per_day'],
            'api_timeout' => $system['api_timeout'],
            'retry_attempts' => $system['retry_attempts'],
            'restricted_topics' => $boundaries['restricted_topics'],
            'max_response_length' => $boundaries['max_response_length'],
            'fallback_message' => $boundaries['fallback_message'],
        );
    }

    /**
     * Check if AI chat is enabled
     */
    public static function is_enabled() {
        $behavior = self::get_behavior();
        return !empty($behavior['enabled']);
    }

    /**
     * Get provider status (includes API key check)
     */
    public static function get_provider_status() {
        $system = self::get_system();
        $provider = $system['primary_provider'];

        $status = array(
            'provider' => $provider,
            'has_api_key' => false,
            'fallback_provider' => $system['fallback_provider'],
            'fallback_has_key' => false,
        );

        // Check primary API key
        if ($provider === 'mistral') {
            $status['has_api_key'] = defined('BFLUXCO_MISTRAL_API_KEY') || get_option('bfluxco_mistral_api_key');
        } elseif ($provider === 'openai') {
            $status['has_api_key'] = defined('BFLUXCO_OPENAI_API_KEY') || get_option('bfluxco_openai_api_key');
        } elseif ($provider === 'gemini') {
            $status['has_api_key'] = defined('BFLUXCO_GEMINI_API_KEY') || get_option('bfluxco_gemini_api_key');
        }

        // Check fallback API key
        if ($system['fallback_provider'] === 'mistral') {
            $status['fallback_has_key'] = defined('BFLUXCO_MISTRAL_API_KEY') || get_option('bfluxco_mistral_api_key');
        } elseif ($system['fallback_provider'] === 'openai') {
            $status['fallback_has_key'] = defined('BFLUXCO_OPENAI_API_KEY') || get_option('bfluxco_openai_api_key');
        } elseif ($system['fallback_provider'] === 'gemini') {
            $status['fallback_has_key'] = defined('BFLUXCO_GEMINI_API_KEY') || get_option('bfluxco_gemini_api_key');
        }

        return $status;
    }

    /**
     * Default persona settings
     */
    private static function get_persona_defaults() {
        return array(
            // Identity & Stance
            'persona_role' => '',
            'persona_name' => '',
            'stance_statement' => '',
            'knowledge_boundaries' => '',

            // Voice Constraints
            'vocabulary_level' => 'balanced',
            'sentence_complexity' => 'mixed',
            'banned_phrases' => '',
            'required_phrases' => '',
            'use_contractions' => true,
            'use_emoji' => false,

            // First-Turn & Intro Behavior
            'greeting_message' => '',
            'suggested_questions' => '',
            'announce_capabilities' => false,
            'show_bot_limitations' => false,

            // Clarification & Recovery Patterns
            'low_confidence_template' => '',
            'off_topic_redirect' => '',
            'error_message' => '',
            'max_clarification_attempts' => 2,
            'auto_escalate_on_frustration' => true,

            // CTA Language Governance
            'cta_style' => 'suggestive',
            'allowed_ctas' => array(
                'contact' => true,
                'case_study' => true,
                'about' => true,
                'schedule' => false,
            ),
            'cta_cooldown_phrases' => '',

            // Versioning
            'version' => '1.0',
            'last_modified' => '',
        );
    }

    /**
     * Get persona settings
     */
    public static function get_persona() {
        $saved = get_option(self::PERSONA_OPTION, array());
        return wp_parse_args($saved, self::get_persona_defaults());
    }

    /**
     * Save persona settings with versioning
     */
    public static function save_persona($data, $change_notes = '') {
        // Get current persona for version history
        $current = self::get_persona();

        // Sanitize new data
        $sanitized = self::sanitize_persona($data);

        // Increment version
        $current_version = floatval($current['version'] ?? '1.0');
        $new_version = number_format($current_version + 0.1, 1);
        $sanitized['version'] = $new_version;
        $sanitized['last_modified'] = current_time('mysql');

        // Save version history (if current has content)
        if (!empty($current['last_modified'])) {
            $versions = get_option(self::PERSONA_VERSIONS_OPTION, array());
            array_unshift($versions, array(
                'version' => $current['version'],
                'date' => $current['last_modified'],
                'notes' => $change_notes,
                'data' => $current,
            ));

            // Keep only last 10 versions
            $versions = array_slice($versions, 0, 10);
            update_option(self::PERSONA_VERSIONS_OPTION, $versions);
        }

        return update_option(self::PERSONA_OPTION, $sanitized);
    }

    /**
     * Sanitize persona settings
     */
    private static function sanitize_persona($data) {
        $defaults = self::get_persona_defaults();
        $sanitized = array();

        // Identity & Stance
        $sanitized['persona_role'] = sanitize_text_field($data['persona_role'] ?? '');
        $sanitized['persona_name'] = sanitize_text_field($data['persona_name'] ?? '');
        $sanitized['stance_statement'] = sanitize_textarea_field($data['stance_statement'] ?? '');
        $sanitized['knowledge_boundaries'] = sanitize_textarea_field($data['knowledge_boundaries'] ?? '');

        // Voice Constraints
        $sanitized['vocabulary_level'] = in_array($data['vocabulary_level'] ?? '', array('simple', 'balanced', 'technical'))
            ? $data['vocabulary_level']
            : $defaults['vocabulary_level'];
        $sanitized['sentence_complexity'] = in_array($data['sentence_complexity'] ?? '', array('short', 'mixed', 'complex'))
            ? $data['sentence_complexity']
            : $defaults['sentence_complexity'];
        $sanitized['banned_phrases'] = sanitize_textarea_field($data['banned_phrases'] ?? '');
        $sanitized['required_phrases'] = sanitize_textarea_field($data['required_phrases'] ?? '');
        $sanitized['use_contractions'] = !empty($data['use_contractions']);
        $sanitized['use_emoji'] = !empty($data['use_emoji']);

        // First-Turn & Intro Behavior
        $sanitized['greeting_message'] = sanitize_textarea_field($data['greeting_message'] ?? '');
        $sanitized['suggested_questions'] = sanitize_textarea_field($data['suggested_questions'] ?? '');
        $sanitized['announce_capabilities'] = !empty($data['announce_capabilities']);
        $sanitized['show_bot_limitations'] = !empty($data['show_bot_limitations']);

        // Clarification & Recovery Patterns
        $sanitized['low_confidence_template'] = sanitize_textarea_field($data['low_confidence_template'] ?? '');
        $sanitized['off_topic_redirect'] = sanitize_textarea_field($data['off_topic_redirect'] ?? '');
        $sanitized['error_message'] = sanitize_textarea_field($data['error_message'] ?? '');
        $sanitized['max_clarification_attempts'] = min(max(absint($data['max_clarification_attempts'] ?? 2), 1), 5);
        $sanitized['auto_escalate_on_frustration'] = !empty($data['auto_escalate_on_frustration']);

        // CTA Language Governance
        $sanitized['cta_style'] = in_array($data['cta_style'] ?? '', array('direct', 'suggestive', 'embedded'))
            ? $data['cta_style']
            : $defaults['cta_style'];
        $sanitized['allowed_ctas'] = array(
            'contact' => !empty($data['allowed_ctas']['contact']),
            'case_study' => !empty($data['allowed_ctas']['case_study']),
            'about' => !empty($data['allowed_ctas']['about']),
            'schedule' => !empty($data['allowed_ctas']['schedule']),
        );
        $sanitized['cta_cooldown_phrases'] = sanitize_textarea_field($data['cta_cooldown_phrases'] ?? '');

        return $sanitized;
    }

    /**
     * Get persona version history
     */
    public static function get_persona_versions() {
        return get_option(self::PERSONA_VERSIONS_OPTION, array());
    }

    /**
     * Rollback persona to a previous version
     */
    public static function rollback_persona($target_version) {
        $versions = self::get_persona_versions();

        foreach ($versions as $version) {
            if ($version['version'] === $target_version && !empty($version['data'])) {
                // Save the rolled-back version as a new version
                $rolled_back = $version['data'];
                $rolled_back['version'] = $target_version;
                $rolled_back['last_modified'] = current_time('mysql');

                // Add current version to history first
                $current = self::get_persona();
                if (!empty($current['last_modified'])) {
                    array_unshift($versions, array(
                        'version' => $current['version'],
                        'date' => $current['last_modified'],
                        'notes' => 'Before rollback to v' . $target_version,
                        'data' => $current,
                    ));
                    $versions = array_slice($versions, 0, 10);
                    update_option(self::PERSONA_VERSIONS_OPTION, $versions);
                }

                return update_option(self::PERSONA_OPTION, $rolled_back);
            }
        }

        return false;
    }

    /**
     * Get persona config for chatbot API (merged with behavior)
     */
    public static function get_persona_config() {
        $persona = self::get_persona();

        return array(
            'role' => $persona['persona_role'],
            'name' => $persona['persona_name'],
            'stance' => $persona['stance_statement'],
            'knowledge_limits' => $persona['knowledge_boundaries'],
            'vocabulary' => $persona['vocabulary_level'],
            'sentence_style' => $persona['sentence_complexity'],
            'banned_words' => array_filter(array_map('trim', explode(',', $persona['banned_phrases']))),
            'required_words' => array_filter(array_map('trim', explode(',', $persona['required_phrases']))),
            'use_contractions' => $persona['use_contractions'],
            'use_emoji' => $persona['use_emoji'],
            'greeting' => $persona['greeting_message'],
            'suggested_prompts' => array_filter(array_map('trim', explode("\n", $persona['suggested_questions']))),
            'announce_capabilities' => $persona['announce_capabilities'],
            'show_limitations' => $persona['show_bot_limitations'],
            'low_confidence_response' => $persona['low_confidence_template'],
            'off_topic_response' => $persona['off_topic_redirect'],
            'error_response' => $persona['error_message'],
            'max_clarifications' => $persona['max_clarification_attempts'],
            'auto_escalate_frustration' => $persona['auto_escalate_on_frustration'],
            'cta_style' => $persona['cta_style'],
            'allowed_ctas' => array_keys(array_filter($persona['allowed_ctas'])),
            'cta_cooldown_triggers' => array_filter(array_map('trim', explode("\n", $persona['cta_cooldown_phrases']))),
        );
    }
}
