<?php
/**
 * AI Chat Admin
 *
 * WordPress Admin page for AI Chat governance and observability.
 *
 * @package BFLUXCO
 */

if (!defined('ABSPATH')) {
    exit;
}

class BFLUXCO_AI_Chat_Admin {

    /**
     * Constants
     */
    const PAGE_SLUG = 'ai-chat-admin';
    const CAPABILITY = 'manage_options';
    const NONCE_ACTION = 'bfluxco_ai_chat_admin';

    /**
     * Tab definitions
     */
    private static $tabs = array(
        'overview' => 'Overview',
        'persona' => 'Bot Persona',
        'behavior' => 'Behavior',
        'boundaries' => 'Boundaries',
        'monitoring' => 'Monitoring',
        'feedback' => 'User Feedback',
        'training' => 'Training',
        'system' => 'System',
    );

    /**
     * Initialize the class
     */
    public static function init() {
        // Admin menu
        add_action('admin_menu', array(__CLASS__, 'add_admin_menu'));

        // Enqueue assets
        add_action('admin_enqueue_scripts', array(__CLASS__, 'enqueue_assets'));

        // Menu icon styles
        add_action('admin_head', array(__CLASS__, 'menu_icon_styles'));

        // AJAX handlers
        add_action('wp_ajax_bfluxco_ai_get_chart_data', array(__CLASS__, 'ajax_get_chart_data'));
        add_action('wp_ajax_bfluxco_ai_save_behavior', array(__CLASS__, 'ajax_save_behavior'));
        add_action('wp_ajax_bfluxco_ai_save_system', array(__CLASS__, 'ajax_save_system'));
        add_action('wp_ajax_bfluxco_ai_save_boundaries', array(__CLASS__, 'ajax_save_boundaries'));
        add_action('wp_ajax_bfluxco_ai_save_rule', array(__CLASS__, 'ajax_save_rule'));
        add_action('wp_ajax_bfluxco_ai_delete_rule', array(__CLASS__, 'ajax_delete_rule'));
        add_action('wp_ajax_bfluxco_ai_add_training', array(__CLASS__, 'ajax_add_training'));
        add_action('wp_ajax_bfluxco_ai_update_training', array(__CLASS__, 'ajax_update_training'));
        add_action('wp_ajax_bfluxco_ai_delete_training', array(__CLASS__, 'ajax_delete_training'));
        add_action('wp_ajax_bfluxco_ai_bulk_training', array(__CLASS__, 'ajax_bulk_training'));
        add_action('wp_ajax_bfluxco_ai_export_training', array(__CLASS__, 'ajax_export_training'));
        add_action('wp_ajax_bfluxco_ai_save_persona', array(__CLASS__, 'ajax_save_persona'));
        add_action('wp_ajax_bfluxco_ai_rollback_persona', array(__CLASS__, 'ajax_rollback_persona'));
    }

    /**
     * Add admin menu page
     */
    public static function add_admin_menu() {
        add_menu_page(
            __('AI Chat', 'bfluxco'),
            __('AI Chat', 'bfluxco'),
            self::CAPABILITY,
            self::PAGE_SLUG,
            array(__CLASS__, 'render_admin_page'),
            self::get_menu_icon(),
            3
        );
    }

    /**
     * Get menu icon URL
     */
    private static function get_menu_icon() {
        return get_template_directory_uri() . '/assets/images/logo.png';
    }

    /**
     * Menu icon styles
     */
    public static function menu_icon_styles() {
        echo '<style>
            #adminmenu .toplevel_page_ai-chat-admin .wp-menu-image img {
                width: 20px;
                height: 20px;
                padding: 6px 0 0;
                opacity: 0.6;
            }
            #adminmenu .toplevel_page_ai-chat-admin:hover .wp-menu-image img,
            #adminmenu .toplevel_page_ai-chat-admin.current .wp-menu-image img {
                opacity: 1;
            }
        </style>';
    }

    /**
     * Enqueue admin assets
     */
    public static function enqueue_assets($hook) {
        if ($hook !== 'toplevel_page_' . self::PAGE_SLUG) {
            return;
        }

        // Chart.js
        wp_enqueue_script(
            'chartjs',
            'https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js',
            array(),
            '4.4.1',
            true
        );

        // Date adapter for time-series
        wp_enqueue_script(
            'chartjs-adapter-date-fns',
            'https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@3.0.0/dist/chartjs-adapter-date-fns.bundle.min.js',
            array('chartjs'),
            '3.0.0',
            true
        );

        // Custom admin JS
        wp_enqueue_script(
            'bfluxco-ai-chat-admin',
            get_template_directory_uri() . '/assets/js/admin-ai-chat.js',
            array('chartjs', 'chartjs-adapter-date-fns'),
            filemtime(get_template_directory() . '/assets/js/admin-ai-chat.js'),
            true
        );

        // Localize script
        wp_localize_script('bfluxco-ai-chat-admin', 'bfluxcoAiChat', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce(self::NONCE_ACTION),
            'strings' => array(
                'loading' => __('Loading...', 'bfluxco'),
                'error' => __('Error loading data', 'bfluxco'),
                'saved' => __('Settings saved', 'bfluxco'),
                'confirmDelete' => __('Are you sure you want to delete this?', 'bfluxco'),
            ),
        ));

        // Custom admin CSS
        wp_enqueue_style(
            'bfluxco-ai-chat-admin',
            get_template_directory_uri() . '/assets/css/admin-ai-chat.css',
            array(),
            filemtime(get_template_directory() . '/assets/css/admin-ai-chat.css')
        );
    }

    /**
     * Render admin page
     */
    public static function render_admin_page() {
        if (!current_user_can(self::CAPABILITY)) {
            wp_die(__('You do not have sufficient permissions to access this page.', 'bfluxco'));
        }

        $current_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'overview';
        if (!array_key_exists($current_tab, self::$tabs)) {
            $current_tab = 'overview';
        }

        ?>
        <div class="wrap bfluxco-ai-chat-admin">
            <h1><?php esc_html_e('AI Chat', 'bfluxco'); ?></h1>

            <nav class="nav-tab-wrapper">
                <?php foreach (self::$tabs as $tab_id => $tab_label) : ?>
                    <a href="<?php echo esc_url(add_query_arg('tab', $tab_id, admin_url('admin.php?page=' . self::PAGE_SLUG))); ?>"
                       class="nav-tab <?php echo $current_tab === $tab_id ? 'nav-tab-active' : ''; ?>"
                       data-tab="<?php echo esc_attr($tab_id); ?>">
                        <?php echo esc_html($tab_label); ?>
                    </a>
                <?php endforeach; ?>
            </nav>

            <div class="tab-content">
                <?php
                switch ($current_tab) {
                    case 'overview':
                        self::render_tab_overview();
                        break;
                    case 'persona':
                        self::render_tab_persona();
                        break;
                    case 'behavior':
                        self::render_tab_behavior();
                        break;
                    case 'boundaries':
                        self::render_tab_boundaries();
                        break;
                    case 'monitoring':
                        self::render_tab_monitoring();
                        break;
                    case 'feedback':
                        self::render_tab_feedback();
                        break;
                    case 'training':
                        self::render_tab_training();
                        break;
                    case 'system':
                        self::render_tab_system();
                        break;
                }
                ?>
            </div>
        </div>
        <?php
    }

    /**
     * Tab 1: Overview
     */
    private static function render_tab_overview() {
        $stats = BFLUXCO_AI_Chat_Metrics::get_overview_stats();
        $behavior = BFLUXCO_AI_Chat_Settings::get_behavior();
        $provider_status = BFLUXCO_AI_Chat_Settings::get_provider_status();
        ?>
        <div class="ai-chat-overview">
            <!-- Status Cards -->
            <div class="stats-row">
                <div class="stat-card <?php echo $behavior['enabled'] ? 'status-active' : 'status-inactive'; ?>">
                    <div class="stat-label"><?php esc_html_e('AI Chat Status', 'bfluxco'); ?></div>
                    <div class="stat-value"><?php echo $behavior['enabled'] ? __('Enabled', 'bfluxco') : __('Disabled', 'bfluxco'); ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-label"><?php esc_html_e('Active Provider', 'bfluxco'); ?></div>
                    <div class="stat-value">
                        <?php echo esc_html(ucfirst($provider_status['provider'])); ?>
                        <?php if (!$provider_status['has_api_key']) : ?>
                            <span class="status-warning"><?php esc_html_e('(No API Key)', 'bfluxco'); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-label"><?php esc_html_e('Conversations Today', 'bfluxco'); ?></div>
                    <div class="stat-value"><?php echo esc_html($stats['conversations_today']); ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-label"><?php esc_html_e('Avg Response Time', 'bfluxco'); ?></div>
                    <div class="stat-value"><?php echo esc_html($stats['avg_response_time']); ?>ms</div>
                </div>
                <div class="stat-card <?php echo $stats['error_rate'] > 5 ? 'status-warning' : ''; ?>">
                    <div class="stat-label"><?php esc_html_e('Error Rate (24h)', 'bfluxco'); ?></div>
                    <div class="stat-value"><?php echo esc_html($stats['error_rate']); ?>%</div>
                </div>
            </div>

            <!-- Charts -->
            <div class="charts-row">
                <div class="chart-container">
                    <div class="chart-header">
                        <h3><?php esc_html_e('Response Time Trend', 'bfluxco'); ?></h3>
                        <div class="time-range-toggle" data-chart="response_time_trend">
                            <button class="time-btn" data-range="24h">24h</button>
                            <button class="time-btn active" data-range="7d">7d</button>
                        </div>
                    </div>
                    <canvas id="chart-response-time" height="250"></canvas>
                    <p class="chart-helper"><?php esc_html_e('Rising p95 indicates degraded worst-case performance.', 'bfluxco'); ?></p>
                </div>

                <div class="chart-container">
                    <div class="chart-header">
                        <h3><?php esc_html_e('Error + Fallback Rate', 'bfluxco'); ?></h3>
                        <div class="time-range-toggle" data-chart="error_fallback_rate">
                            <button class="time-btn" data-range="24h">24h</button>
                            <button class="time-btn active" data-range="7d">7d</button>
                        </div>
                    </div>
                    <canvas id="chart-error-rate" height="250"></canvas>
                    <p class="chart-helper"><?php esc_html_e('Sustained fallback usage may indicate provider instability.', 'bfluxco'); ?></p>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Tab 2: Bot Persona & Conversation Design
     */
    private static function render_tab_persona() {
        $persona = BFLUXCO_AI_Chat_Settings::get_persona();
        $versions = BFLUXCO_AI_Chat_Settings::get_persona_versions();
        ?>
        <div class="ai-chat-persona">
            <form id="persona-form" class="settings-form">
                <input type="hidden" name="action" value="bfluxco_ai_save_persona">
                <input type="hidden" name="nonce" value="<?php echo wp_create_nonce(self::NONCE_ACTION); ?>">

                <!-- Section 1: Bot Persona (Identity & Stance) -->
                <div class="form-section persona-section">
                    <h3><?php esc_html_e('Bot Persona (Identity & Stance)', 'bfluxco'); ?></h3>
                    <p class="section-description"><?php esc_html_e('Define who the bot is and how it positions itself relative to your brand.', 'bfluxco'); ?></p>

                    <div class="form-field">
                        <label><?php esc_html_e('Persona Role', 'bfluxco'); ?></label>
                        <p class="description"><?php esc_html_e('Describe what the bot does, not who it pretends to be.', 'bfluxco'); ?></p>
                        <input type="text" name="persona_role" value="<?php echo esc_attr($persona['persona_role'] ?? ''); ?>" placeholder="<?php esc_attresc_html_e('e.g., Portfolio Guide', 'bfluxco'); ?>" maxlength="40">
                    </div>

                    <div class="form-field">
                        <label><?php esc_html_e('Persona Name (Optional)', 'bfluxco'); ?></label>
                        <p class="description"><?php esc_html_e('Give the bot a name if you want it to identify itself. Leave blank for nameless assistant.', 'bfluxco'); ?></p>
                        <input type="text" name="persona_name" value="<?php echo esc_attr($persona['persona_name'] ?? ''); ?>" placeholder="<?php esc_attresc_html_e('e.g., Flux', 'bfluxco'); ?>" maxlength="20">
                    </div>

                    <div class="form-field">
                        <label><?php esc_html_e('Stance Statement', 'bfluxco'); ?></label>
                        <p class="description"><?php esc_html_e('State what the bot represents and helps with. Avoid promotional language.', 'bfluxco'); ?></p>
                        <textarea name="stance_statement" rows="3" maxlength="280" placeholder="<?php esc_attresc_html_e('e.g., I represent Ray Butler\'s portfolio and help visitors understand his approach to GenAI experience design.', 'bfluxco'); ?>"><?php echo esc_textarea($persona['stance_statement'] ?? ''); ?></textarea>
                    </div>

                    <div class="form-field">
                        <label><?php esc_html_e('Knowledge Boundaries', 'bfluxco'); ?></label>
                        <p class="description"><?php esc_html_e('Be explicit about limits. This improves trust.', 'bfluxco'); ?></p>
                        <textarea name="knowledge_boundaries" rows="3" maxlength="300" placeholder="<?php esc_attresc_html_e('e.g., I can discuss Ray\'s public portfolio work but cannot share pricing, internal processes, or confidential client details.', 'bfluxco'); ?>"><?php echo esc_textarea($persona['knowledge_boundaries'] ?? ''); ?></textarea>
                    </div>
                </div>

                <!-- Section 2: Voice Constraints -->
                <div class="form-section persona-section">
                    <h3><?php esc_html_e('Voice Constraints', 'bfluxco'); ?></h3>
                    <p class="section-description"><?php esc_html_e('Fine-tune the linguistic style beyond the basic tone preset.', 'bfluxco'); ?></p>

                    <div class="form-row">
                        <div class="form-field">
                            <label><?php esc_html_e('Vocabulary Level', 'bfluxco'); ?></label>
                            <select name="vocabulary_level">
                                <option value="simple" <?php selected($persona['vocabulary_level'] ?? '', 'simple'); ?>><?php esc_html_e('Simple', 'bfluxco'); ?></option>
                                <option value="balanced" <?php selected($persona['vocabulary_level'] ?? 'balanced', 'balanced'); ?>><?php esc_html_e('Balanced (some industry terms OK)', 'bfluxco'); ?></option>
                                <option value="advanced" <?php selected($persona['vocabulary_level'] ?? '', 'advanced'); ?>><?php esc_html_e('Advanced', 'bfluxco'); ?></option>
                            </select>
                        </div>
                        <div class="form-field">
                            <label><?php esc_html_e('Sentence Complexity', 'bfluxco'); ?></label>
                            <select name="sentence_complexity">
                                <option value="short" <?php selected($persona['sentence_complexity'] ?? '', 'short'); ?>><?php esc_html_e('Short & direct', 'bfluxco'); ?></option>
                                <option value="mixed" <?php selected($persona['sentence_complexity'] ?? 'mixed', 'mixed'); ?>><?php esc_html_e('Mixed lengths', 'bfluxco'); ?></option>
                                <option value="complex" <?php selected($persona['sentence_complexity'] ?? '', 'complex'); ?>><?php esc_html_e('Longer, structured responses', 'bfluxco'); ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="form-field">
                        <label><?php esc_html_e('Banned Words/Phrases', 'bfluxco'); ?></label>
                        <p class="description"><?php esc_html_e('Comma-separated list of words or phrases the bot should never use.', 'bfluxco'); ?></p>
                        <textarea name="banned_phrases" rows="2" placeholder="<?php esc_attresc_html_e('e.g., synergy, leverage, circle back, low-hanging fruit', 'bfluxco'); ?>"><?php echo esc_textarea($persona['banned_phrases'] ?? ''); ?></textarea>
                    </div>

                    <div class="form-field">
                        <label><?php esc_html_e('Required Phrases', 'bfluxco'); ?></label>
                        <p class="description"><?php esc_html_e('Phrases the bot should naturally incorporate when relevant. Comma-separated.', 'bfluxco'); ?></p>
                        <textarea name="required_phrases" rows="2" placeholder="<?php esc_attresc_html_e('e.g., human-centered design, thoughtful approach', 'bfluxco'); ?>"><?php echo esc_textarea($persona['required_phrases'] ?? ''); ?></textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-field">
                            <label class="toggle-switch">
                                <input type="checkbox" name="use_contractions" value="1" <?php checked($persona['use_contractions'] ?? true); ?>>
                                <span class="toggle-slider"></span>
                                <span class="toggle-label"><?php esc_html_e('Use contractions (I\'m, you\'re, etc.)', 'bfluxco'); ?></span>
                            </label>
                        </div>
                        <div class="form-field">
                            <label class="toggle-switch">
                                <input type="checkbox" name="use_emoji" value="1" <?php checked($persona['use_emoji'] ?? false); ?>>
                                <span class="toggle-slider"></span>
                                <span class="toggle-label"><?php esc_html_e('Allow emoji in responses', 'bfluxco'); ?></span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Section 3: First-Turn & Intro Behavior -->
                <div class="form-section persona-section">
                    <h3><?php esc_html_e('First-Turn & Intro Behavior', 'bfluxco'); ?></h3>
                    <p class="section-description"><?php esc_html_e('Control how the bot introduces itself and sets conversation expectations.', 'bfluxco'); ?></p>

                    <div class="form-field">
                        <label><?php esc_html_e('Greeting Message', 'bfluxco'); ?></label>
                        <p class="description"><?php esc_html_e('The first message shown when chat opens. Leave blank to let the AI generate contextually.', 'bfluxco'); ?></p>
                        <textarea name="greeting_message" rows="3" placeholder="<?php esc_attresc_html_e('e.g., Hi! I\'m here to help you explore Ray\'s portfolio. What kind of work are you interested in?', 'bfluxco'); ?>"><?php echo esc_textarea($persona['greeting_message'] ?? ''); ?></textarea>
                    </div>

                    <div class="form-field">
                        <label><?php esc_html_e('Suggested First Questions', 'bfluxco'); ?></label>
                        <p class="description"><?php esc_html_e('Up to 3 suggested prompts shown as quick-action chips. One per line.', 'bfluxco'); ?></p>
                        <textarea name="suggested_questions" rows="3" placeholder="<?php esc_attresc_html_e("What kind of projects does Ray work on?\nTell me about the AI chatbot case study\nHow can I get in touch?", 'bfluxco'); ?>"><?php echo esc_textarea($persona['suggested_questions'] ?? ''); ?></textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-field">
                            <label class="toggle-switch">
                                <input type="checkbox" name="announce_capabilities" value="1" <?php checked($persona['announce_capabilities'] ?? false); ?> class="first-turn-toggle">
                                <span class="toggle-slider"></span>
                                <span class="toggle-label"><?php esc_html_e('Announce capabilities in greeting', 'bfluxco'); ?></span>
                            </label>
                            <p class="description"><?php esc_html_e('Add "I can help you with X, Y, and Z" to the greeting.', 'bfluxco'); ?></p>
                        </div>
                        <div class="form-field">
                            <label class="toggle-switch">
                                <input type="checkbox" name="show_bot_limitations" value="1" <?php checked($persona['show_bot_limitations'] ?? false); ?> class="first-turn-toggle">
                                <span class="toggle-slider"></span>
                                <span class="toggle-label"><?php esc_html_e('Proactively mention limitations', 'bfluxco'); ?></span>
                            </label>
                            <p class="description"><?php esc_html_e('Include "I\'m an AI assistant and may make mistakes" disclaimer.', 'bfluxco'); ?></p>
                        </div>
                    </div>
                    <p class="first-turn-warning" style="display: none; color: #d97706; font-size: 13px; margin-top: 12px;">
                        <?php esc_html_e('Too many first-turn elements reduce engagement.', 'bfluxco'); ?>
                    </p>
                </div>

                <!-- Section 4: Clarification & Recovery Patterns -->
                <div class="form-section persona-section">
                    <h3><?php esc_html_e('Clarification & Recovery Patterns', 'bfluxco'); ?></h3>
                    <p class="section-description"><?php esc_html_e('Define how the bot handles uncertainty, errors, and off-topic requests.', 'bfluxco'); ?></p>

                    <div class="form-field">
                        <label><?php esc_html_e('Low-Confidence Response Template', 'bfluxco'); ?></label>
                        <p class="description"><?php esc_html_e('How the bot responds when it\'s not sure. Use {topic} as a placeholder.', 'bfluxco'); ?></p>
                        <textarea name="low_confidence_template" rows="2" placeholder="<?php esc_attresc_html_e('e.g., I want to make sure I understand correctly—are you asking about {topic}?', 'bfluxco'); ?>"><?php echo esc_textarea($persona['low_confidence_template'] ?? ''); ?></textarea>
                    </div>

                    <div class="form-field">
                        <label><?php esc_html_e('Off-Topic Redirect Message', 'bfluxco'); ?></label>
                        <p class="description"><?php esc_html_e('How to steer back to relevant topics gracefully.', 'bfluxco'); ?></p>
                        <textarea name="off_topic_redirect" rows="2" placeholder="<?php esc_attresc_html_e('e.g., That\'s outside my area of expertise, but I\'d be happy to tell you about Ray\'s work in...', 'bfluxco'); ?>"><?php echo esc_textarea($persona['off_topic_redirect'] ?? ''); ?></textarea>
                    </div>

                    <div class="form-field">
                        <label><?php esc_html_e('Error/Failure Message', 'bfluxco'); ?></label>
                        <p class="description"><?php esc_html_e('Shown when something goes wrong (API failure, timeout, etc.).', 'bfluxco'); ?></p>
                        <textarea name="error_message" rows="2" placeholder="<?php esc_attresc_html_e('e.g., I\'m having trouble right now. You can reach Ray directly at the contact page.', 'bfluxco'); ?>"><?php echo esc_textarea($persona['error_message'] ?? ''); ?></textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-field">
                            <label><?php esc_html_e('Max Clarification Attempts', 'bfluxco'); ?></label>
                            <p class="description"><?php esc_html_e('How many times to ask for clarification before offering handoff.', 'bfluxco'); ?></p>
                            <input type="number" name="max_clarification_attempts" value="<?php echo esc_attr($persona['max_clarification_attempts'] ?? 2); ?>" min="1" max="5">
                        </div>
                        <div class="form-field">
                            <label class="toggle-switch">
                                <input type="checkbox" name="auto_escalate_on_frustration" value="1" <?php checked($persona['auto_escalate_on_frustration'] ?? true); ?>>
                                <span class="toggle-slider"></span>
                                <span class="toggle-label"><?php esc_html_e('Auto-escalate on detected frustration', 'bfluxco'); ?></span>
                            </label>
                            <p class="description"><?php esc_html_e('Escalation routes users out of AI when confidence or trust drops.', 'bfluxco'); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Section 5: CTA Language Governance -->
                <div class="form-section persona-section">
                    <h3><?php esc_html_e('CTA Language Governance', 'bfluxco'); ?></h3>
                    <p class="section-description"><?php esc_html_e('Control how calls-to-action are worded and presented.', 'bfluxco'); ?></p>

                    <div class="form-field">
                        <label><?php esc_html_e('CTA Phrasing Style', 'bfluxco'); ?></label>
                        <div class="radio-group">
                            <label class="radio-option">
                                <input type="radio" name="cta_style" value="direct" <?php checked($persona['cta_style'] ?? '', 'direct'); ?>>
                                <span class="radio-label"><?php esc_html_e('Direct', 'bfluxco'); ?></span>
                                <span class="radio-desc"><?php esc_html_e('"Schedule a call" / "Get in touch"', 'bfluxco'); ?></span>
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="cta_style" value="suggestive" <?php checked($persona['cta_style'] ?? 'suggestive', 'suggestive'); ?>>
                                <span class="radio-label"><?php esc_html_e('Suggestive', 'bfluxco'); ?></span>
                                <span class="radio-desc"><?php esc_html_e('"Would you like to..." / "You might want to..."', 'bfluxco'); ?></span>
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="cta_style" value="embedded" <?php checked($persona['cta_style'] ?? '', 'embedded'); ?>>
                                <span class="radio-label"><?php esc_html_e('Embedded', 'bfluxco'); ?></span>
                                <span class="radio-desc"><?php esc_html_e('Woven into response naturally without explicit prompt', 'bfluxco'); ?></span>
                            </label>
                        </div>
                    </div>

                    <div class="form-field">
                        <label><?php esc_html_e('Allowed CTA Types', 'bfluxco'); ?></label>
                        <p class="description"><?php esc_html_e('Which types of CTAs can the bot generate?', 'bfluxco'); ?></p>
                        <div class="checkbox-group">
                            <label class="checkbox-option">
                                <input type="checkbox" name="allowed_ctas[contact]" value="1" <?php checked($persona['allowed_ctas']['contact'] ?? true); ?>>
                                <span><?php esc_html_e('Contact/Get in touch', 'bfluxco'); ?></span>
                            </label>
                            <label class="checkbox-option">
                                <input type="checkbox" name="allowed_ctas[case_study]" value="1" <?php checked($persona['allowed_ctas']['case_study'] ?? true); ?>>
                                <span><?php esc_html_e('View case study', 'bfluxco'); ?></span>
                            </label>
                            <label class="checkbox-option">
                                <input type="checkbox" name="allowed_ctas[about]" value="1" <?php checked($persona['allowed_ctas']['about'] ?? true); ?>>
                                <span><?php esc_html_e('Learn more about', 'bfluxco'); ?></span>
                            </label>
                            <label class="checkbox-option">
                                <input type="checkbox" name="allowed_ctas[schedule]" value="1" <?php checked($persona['allowed_ctas']['schedule'] ?? false); ?>>
                                <span><?php esc_html_e('Schedule/Book call', 'bfluxco'); ?></span>
                            </label>
                        </div>
                    </div>

                    <div class="form-field">
                        <label><?php esc_html_e('CTA Cooldown Phrases', 'bfluxco'); ?></label>
                        <p class="description"><?php esc_html_e('Phrases that indicate user isn\'t ready for CTAs (bot will hold off). One per line.', 'bfluxco'); ?></p>
                        <textarea name="cta_cooldown_phrases" rows="2" placeholder="<?php esc_attresc_html_e("just browsing\nstill exploring\nnot ready", 'bfluxco'); ?>"><?php echo esc_textarea($persona['cta_cooldown_phrases'] ?? ''); ?></textarea>
                    </div>
                </div>

                <!-- Section 6: Versioning & Change Awareness -->
                <div class="form-section persona-section persona-versioning">
                    <h3><?php esc_html_e('Versioning & Change Awareness', 'bfluxco'); ?></h3>
                    <p class="section-description"><?php esc_html_e('Track changes to persona configuration over time.', 'bfluxco'); ?></p>

                    <div class="form-row">
                        <div class="form-field">
                            <label><?php esc_html_e('Current Version', 'bfluxco'); ?></label>
                            <div class="version-badge">v<?php echo esc_html($persona['version'] ?? '1.0'); ?></div>
                        </div>
                        <div class="form-field">
                            <label><?php esc_html_e('Last Modified', 'bfluxco'); ?></label>
                            <div class="version-date">
                                <?php
                                if (!empty($persona['last_modified'])) {
                                    echo esc_html(human_time_diff(strtotime($persona['last_modified']))) . ' ago';
                                } else {
                                    esc_html_e('Never', 'bfluxco');
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-field">
                        <label><?php esc_html_e('Change Notes', 'bfluxco'); ?></label>
                        <p class="description"><?php esc_html_e('Briefly describe what you\'re changing (stored with version history).', 'bfluxco'); ?></p>
                        <input type="text" name="change_notes" placeholder="<?php esc_attresc_html_e('e.g., Updated greeting message, added new banned phrases', 'bfluxco'); ?>">
                    </div>

                    <?php if (!empty($versions)) : ?>
                        <div class="version-history">
                            <h4><?php esc_html_e('Version History', 'bfluxco'); ?></h4>
                            <table class="versions-table widefat">
                                <thead>
                                    <tr>
                                        <th><?php esc_html_e('Version', 'bfluxco'); ?></th>
                                        <th><?php esc_html_e('Date', 'bfluxco'); ?></th>
                                        <th><?php esc_html_e('Notes', 'bfluxco'); ?></th>
                                        <th><?php esc_html_e('Actions', 'bfluxco'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach (array_slice($versions, 0, 5) as $version) : ?>
                                        <tr>
                                            <td>v<?php echo esc_html($version['version']); ?></td>
                                            <td><?php echo esc_html(date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime($version['date']))); ?></td>
                                            <td><?php echo esc_html($version['notes'] ?: '—'); ?></td>
                                            <td>
                                                <button type="button" class="button-link rollback-version" data-version="<?php echo esc_attr($version['version']); ?>"><?php esc_html_e('Rollback', 'bfluxco'); ?></button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Persona Summary Preview -->
                <div class="form-section persona-section persona-summary">
                    <h3><?php esc_html_e('Current Bot Persona Summary', 'bfluxco'); ?></h3>
                    <p class="section-description"><?php esc_html_e('Read-only summary of the current configuration. Review before saving.', 'bfluxco'); ?></p>

                    <div class="summary-grid">
                        <div class="summary-item">
                            <span class="summary-label"><?php esc_html_e('Role', 'bfluxco'); ?></span>
                            <span class="summary-value" id="summary-role"><?php echo esc_html($persona['persona_role'] ?? '—'); ?></span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label"><?php esc_html_e('Stance', 'bfluxco'); ?></span>
                            <span class="summary-value" id="summary-stance"><?php echo esc_html(wp_trim_words($persona['stance_statement'] ?? '—', 15)); ?></span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label"><?php esc_html_e('Voice', 'bfluxco'); ?></span>
                            <span class="summary-value" id="summary-voice">
                                <?php
                                $vocab = $persona['vocabulary_level'] ?? 'balanced';
                                $complexity = $persona['sentence_complexity'] ?? 'mixed';
                                echo esc_html(ucfirst($vocab) . ' vocabulary, ' . $complexity . ' sentences');
                                ?>
                            </span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label"><?php esc_html_e('First-Turn', 'bfluxco'); ?></span>
                            <span class="summary-value" id="summary-first-turn">
                                <?php
                                $elements = array();
                                if (!empty($persona['greeting_message'])) $elements[] = __('Custom greeting', 'bfluxco');
                                if (!empty($persona['announce_capabilities'])) $elements[] = __('Capabilities', 'bfluxco');
                                if (!empty($persona['show_bot_limitations'])) $elements[] = __('Limitations', 'bfluxco');
                                echo !empty($elements) ? esc_html(implode(', ', $elements)) : '—';
                                ?>
                            </span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label"><?php esc_html_e('CTA Style', 'bfluxco'); ?></span>
                            <span class="summary-value" id="summary-cta"><?php echo esc_html(ucfirst($persona['cta_style'] ?? 'suggestive')); ?></span>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="button button-primary"><?php esc_html_e('Save Persona Settings', 'bfluxco'); ?></button>
                    <span class="save-status"></span>
                </div>
            </form>
        </div>
        <?php
    }

    /**
     * Tab 3: Behavior
     */
    private static function render_tab_behavior() {
        $behavior = BFLUXCO_AI_Chat_Settings::get_behavior();
        ?>
        <div class="ai-chat-behavior">
            <form id="behavior-form" class="settings-form">
                <input type="hidden" name="action" value="bfluxco_ai_save_behavior">
                <input type="hidden" name="nonce" value="<?php echo wp_create_nonce(self::NONCE_ACTION); ?>">

                <!-- AI Enabled -->
                <div class="form-section">
                    <h3><?php esc_html_e('AI Chat Status', 'bfluxco'); ?></h3>
                    <label class="toggle-switch">
                        <input type="checkbox" name="enabled" value="1" <?php checked($behavior['enabled']); ?>>
                        <span class="toggle-slider"></span>
                        <span class="toggle-label"><?php esc_html_e('Enable AI Chat', 'bfluxco'); ?></span>
                    </label>
                </div>

                <!-- Tone -->
                <div class="form-section">
                    <h3><?php esc_html_e('Tone Preset', 'bfluxco'); ?></h3>
                    <p class="description"><?php esc_html_e('Set the personality of AI responses.', 'bfluxco'); ?></p>
                    <div class="radio-group">
                        <label class="radio-option">
                            <input type="radio" name="tone" value="professional" <?php checked($behavior['tone'], 'professional'); ?>>
                            <span class="radio-label"><?php esc_html_e('Professional', 'bfluxco'); ?></span>
                            <span class="radio-desc"><?php esc_html_e('Formal, business-appropriate language', 'bfluxco'); ?></span>
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="tone" value="friendly" <?php checked($behavior['tone'], 'friendly'); ?>>
                            <span class="radio-label"><?php esc_html_e('Friendly', 'bfluxco'); ?></span>
                            <span class="radio-desc"><?php esc_html_e('Warm, approachable, conversational', 'bfluxco'); ?></span>
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="tone" value="casual" <?php checked($behavior['tone'], 'casual'); ?>>
                            <span class="radio-label"><?php esc_html_e('Casual', 'bfluxco'); ?></span>
                            <span class="radio-desc"><?php esc_html_e('Relaxed, informal style', 'bfluxco'); ?></span>
                        </label>
                    </div>
                </div>

                <!-- Response Length -->
                <div class="form-section">
                    <h3><?php esc_html_e('Response Length Bias', 'bfluxco'); ?></h3>
                    <p class="description"><?php esc_html_e('Control the typical length of AI responses.', 'bfluxco'); ?></p>
                    <div class="radio-group horizontal">
                        <label class="radio-option">
                            <input type="radio" name="response_length" value="short" <?php checked($behavior['response_length'], 'short'); ?>>
                            <span class="radio-label"><?php esc_html_e('Short', 'bfluxco'); ?></span>
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="response_length" value="medium" <?php checked($behavior['response_length'], 'medium'); ?>>
                            <span class="radio-label"><?php esc_html_e('Balanced', 'bfluxco'); ?></span>
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="response_length" value="long" <?php checked($behavior['response_length'], 'long'); ?>>
                            <span class="radio-label"><?php esc_html_e('Detailed', 'bfluxco'); ?></span>
                        </label>
                    </div>
                </div>

                <!-- Clarification -->
                <div class="form-section">
                    <h3><?php esc_html_e('Clarification Behavior', 'bfluxco'); ?></h3>
                    <label class="toggle-switch">
                        <input type="checkbox" name="ask_clarifying_questions" value="1" <?php checked($behavior['ask_clarifying_questions']); ?>>
                        <span class="toggle-slider"></span>
                        <span class="toggle-label"><?php esc_html_e('Ask clarifying questions when confidence is low', 'bfluxco'); ?></span>
                    </label>
                </div>

                <!-- Features -->
                <div class="form-section">
                    <h3><?php esc_html_e('Feature Enablement', 'bfluxco'); ?></h3>
                    <div class="checkbox-group">
                        <label class="checkbox-option">
                            <input type="checkbox" name="features[chat_responses]" value="1" <?php checked($behavior['features']['chat_responses'] ?? true); ?>>
                            <span><?php esc_html_e('Chat Responses', 'bfluxco'); ?></span>
                        </label>
                        <label class="checkbox-option">
                            <input type="checkbox" name="features[image_generation]" value="1" <?php checked($behavior['features']['image_generation'] ?? false); ?>>
                            <span><?php esc_html_e('Image Generation', 'bfluxco'); ?></span>
                        </label>
                        <label class="checkbox-option">
                            <input type="checkbox" name="features[cta_generation]" value="1" <?php checked($behavior['features']['cta_generation'] ?? true); ?>>
                            <span><?php esc_html_e('CTA Generation', 'bfluxco'); ?></span>
                        </label>
                        <label class="checkbox-option">
                            <input type="checkbox" name="features[form_generation]" value="1" <?php checked($behavior['features']['form_generation'] ?? false); ?>>
                            <span><?php esc_html_e('Form Generation', 'bfluxco'); ?></span>
                        </label>
                    </div>
                </div>

                <!-- CTA Governance -->
                <div class="form-section">
                    <h3><?php esc_html_e('CTA Governance', 'bfluxco'); ?></h3>
                    <label class="toggle-switch">
                        <input type="checkbox" name="cta[enabled]" value="1" <?php checked($behavior['cta']['enabled'] ?? true); ?>>
                        <span class="toggle-slider"></span>
                        <span class="toggle-label"><?php esc_html_e('Enable CTAs in responses', 'bfluxco'); ?></span>
                    </label>
                    <div class="form-row">
                        <div class="form-field">
                            <label><?php esc_html_e('Minimum turns before CTA', 'bfluxco'); ?></label>
                            <input type="number" name="cta[min_turns_before_cta]" value="<?php echo esc_attr($behavior['cta']['min_turns_before_cta'] ?? 2); ?>" min="1" max="10">
                        </div>
                        <div class="form-field">
                            <label><?php esc_html_e('Maximum CTAs per conversation', 'bfluxco'); ?></label>
                            <input type="number" name="cta[frequency_cap]" value="<?php echo esc_attr($behavior['cta']['frequency_cap'] ?? 3); ?>" min="1" max="10">
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="button button-primary"><?php esc_html_e('Save Changes', 'bfluxco'); ?></button>
                    <span class="save-status"></span>
                </div>
            </form>
        </div>
        <?php
    }

    /**
     * Tab 3: Boundaries
     */
    private static function render_tab_boundaries() {
        $boundaries = BFLUXCO_AI_Chat_Settings::get_boundaries();
        global $wpdb;
        $rules = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}bfluxco_ai_rules ORDER BY trigger_count DESC");
        ?>
        <div class="ai-chat-boundaries">
            <!-- Boundary Settings (Collapsible) -->
            <div class="collapsible-section is-collapsed">
                <button type="button" class="collapsible-header">
                    <span class="collapsible-header-left">
                        <span class="collapsible-title"><?php esc_html_e('Default Boundary Settings', 'bfluxco'); ?></span>
                        <span class="collapsible-desc"><?php esc_html_e('Restricted topics, response limits, and fallback message', 'bfluxco'); ?></span>
                    </span>
                    <span class="collapsible-header-right">
                        <span class="collapsible-icon"></span>
                    </span>
                </button>
                <div class="collapsible-content">
                    <form id="boundaries-form" class="settings-form">
                        <input type="hidden" name="action" value="bfluxco_ai_save_boundaries">
                        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce(self::NONCE_ACTION); ?>">

                        <div class="form-section">
                            <h3><?php esc_html_e('Restricted Topic Categories', 'bfluxco'); ?></h3>
                    <p class="description"><?php esc_html_e('AI will redirect or refuse to answer on these topics.', 'bfluxco'); ?></p>
                    <div class="checkbox-group">
                        <label class="checkbox-option">
                            <input type="checkbox" name="restricted_topics[medical_advice]" value="1" <?php checked($boundaries['restricted_topics']['medical_advice'] ?? true); ?>>
                            <span><?php esc_html_e('Medical Advice', 'bfluxco'); ?></span>
                        </label>
                        <label class="checkbox-option">
                            <input type="checkbox" name="restricted_topics[legal_advice]" value="1" <?php checked($boundaries['restricted_topics']['legal_advice'] ?? true); ?>>
                            <span><?php esc_html_e('Legal Advice', 'bfluxco'); ?></span>
                        </label>
                        <label class="checkbox-option">
                            <input type="checkbox" name="restricted_topics[financial_advice]" value="1" <?php checked($boundaries['restricted_topics']['financial_advice'] ?? true); ?>>
                            <span><?php esc_html_e('Financial Advice', 'bfluxco'); ?></span>
                        </label>
                        <label class="checkbox-option">
                            <input type="checkbox" name="restricted_topics[competitor_info]" value="1" <?php checked($boundaries['restricted_topics']['competitor_info'] ?? true); ?>>
                            <span><?php esc_html_e('Competitor Information', 'bfluxco'); ?></span>
                        </label>
                    </div>
                </div>

                <div class="form-section">
                    <h3><?php esc_html_e('Response Limits', 'bfluxco'); ?></h3>
                    <div class="form-field">
                        <label><?php esc_html_e('Maximum response length (characters)', 'bfluxco'); ?></label>
                        <input type="number" name="max_response_length" value="<?php echo esc_attr($boundaries['max_response_length'] ?? 1000); ?>" min="100" max="5000">
                    </div>
                </div>

                <div class="form-section">
                    <h3><?php esc_html_e('Fallback Message', 'bfluxco'); ?></h3>
                    <p class="description"><?php esc_html_e('Message shown when a boundary rule is triggered.', 'bfluxco'); ?></p>
                    <textarea name="fallback_message" rows="3"><?php echo esc_textarea($boundaries['fallback_message'] ?? ''); ?></textarea>
                </div>

                        <div class="form-actions">
                            <button type="submit" class="button button-primary"><?php esc_html_e('Save Boundaries', 'bfluxco'); ?></button>
                            <span class="save-status"></span>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Rules Table (Collapsible) -->
            <div class="collapsible-section rules-section">
                <div class="collapsible-header">
                    <span class="collapsible-header-left">
                        <span class="collapsible-title"><?php esc_html_e('Boundary Rules', 'bfluxco'); ?></span>
                        <button type="button" class="info-btn" id="rules-info-btn" title="<?php esc_attresc_html_e('Learn about boundary rules', 'bfluxco'); ?>">
                            <span class="dashicons dashicons-info-outline"></span>
                        </button>
                        <span class="collapsible-desc"><?php printf(__('%d rules configured', 'bfluxco'), count($rules)); ?></span>
                    </span>
                    <span class="collapsible-header-right">
                        <button type="button" class="button" id="add-rule-btn"><?php esc_html_e('Add Rule', 'bfluxco'); ?></button>
                        <span class="collapsible-icon"></span>
                    </span>
                </div>
                <div class="collapsible-content">

                    <div class="rules-explainer" style="display: none;">
                        <p><?php esc_html_e('Boundary rules define how the AI responds when it detects specific patterns in user messages. Each rule has a trigger pattern (keywords or regex) and an action type:', 'bfluxco'); ?></p>
                        <ul>
                            <li><strong><?php esc_html_e('Redirect', 'bfluxco'); ?></strong> &mdash; <?php esc_html_e('Guide the user to a specific page or resource instead of answering directly.', 'bfluxco'); ?></li>
                            <li><strong><?php esc_html_e('Block', 'bfluxco'); ?></strong> &mdash; <?php esc_html_e('Politely decline to answer and explain why (e.g., medical/legal advice).', 'bfluxco'); ?></li>
                            <li><strong><?php esc_html_e('Escalate', 'bfluxco'); ?></strong> &mdash; <?php esc_html_e('Immediately trigger a handoff to connect the user with Ray.', 'bfluxco'); ?></li>
                            <li><strong><?php esc_html_e('Modify', 'bfluxco'); ?></strong> &mdash; <?php esc_html_e('Add a disclaimer or additional context to the AI response.', 'bfluxco'); ?></li>
                        </ul>
                        <p class="rules-tip"><?php esc_html_e('Tip: Start with broad categories (pricing, competitors) and refine based on trigger counts.', 'bfluxco'); ?></p>
                    </div>

                    <?php if (empty($rules)) : ?>
                        <div class="empty-state">
                            <p><?php esc_html_e('No boundary rules configured yet.', 'bfluxco'); ?></p>
                        </div>
                    <?php else : ?>
                        <table class="rules-table widefat">
                            <thead>
                                <tr>
                                    <th><?php esc_html_e('Rule Name', 'bfluxco'); ?></th>
                                    <th><?php esc_html_e('Type', 'bfluxco'); ?></th>
                                    <th><?php esc_html_e('Triggers', 'bfluxco'); ?></th>
                                    <th><?php esc_html_e('Status', 'bfluxco'); ?></th>
                                    <th><?php esc_html_e('Actions', 'bfluxco'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rules as $rule) : ?>
                                    <tr data-rule-id="<?php echo esc_attr($rule->id); ?>">
                                        <td><strong><?php echo esc_html($rule->rule_name); ?></strong></td>
                                        <td><span class="rule-type rule-type-<?php echo esc_attr($rule->rule_type); ?>"><?php echo esc_html(ucfirst($rule->rule_type)); ?></span></td>
                                        <td><?php echo esc_html($rule->trigger_count); ?></td>
                                        <td>
                                            <span class="status-badge <?php echo $rule->is_active ? 'status-active' : 'status-inactive'; ?>">
                                                <?php echo $rule->is_active ? __('Active', 'bfluxco') : __('Inactive', 'bfluxco'); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <button type="button" class="button-link edit-rule" data-id="<?php echo esc_attr($rule->id); ?>"><?php esc_html_e('Edit', 'bfluxco'); ?></button>
                                            <button type="button" class="button-link delete-rule" data-id="<?php echo esc_attr($rule->id); ?>"><?php esc_html_e('Delete', 'bfluxco'); ?></button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Charts -->
            <div class="charts-row">
                <div class="chart-container">
                    <div class="chart-header">
                        <h3><?php esc_html_e('Top Triggered Rules', 'bfluxco'); ?></h3>
                        <div class="time-range-toggle" data-chart="top_triggered_rules">
                            <button class="time-btn active" data-range="7d">7d</button>
                            <button class="time-btn" data-range="30d">30d</button>
                        </div>
                    </div>
                    <canvas id="chart-top-rules" height="250"></canvas>
                    <p class="chart-helper"></p>
                </div>

                <div class="chart-container">
                    <div class="chart-header">
                        <h3><?php esc_html_e('Boundary Triggers Over Time', 'bfluxco'); ?></h3>
                        <div class="time-range-toggle" data-chart="boundary_triggers_trend">
                            <button class="time-btn active" data-range="7d">7d</button>
                            <button class="time-btn" data-range="30d">30d</button>
                        </div>
                    </div>
                    <canvas id="chart-boundary-trend" height="250"></canvas>
                    <p class="chart-helper"></p>
                </div>
            </div>
        </div>

        <!-- Rule Modal -->
        <div id="rule-modal" class="modal">
            <div class="modal-backdrop"></div>
            <div class="modal-content">
                <div class="modal-header">
                    <h3><?php esc_html_e('Add Rule', 'bfluxco'); ?></h3>
                    <button type="button" class="modal-close">&times;</button>
                </div>
                <form id="rule-form">
                    <input type="hidden" name="rule_id" value="">
                    <div class="modal-body">
                        <div class="form-field">
                            <label><?php esc_html_e('Rule Name', 'bfluxco'); ?></label>
                            <input type="text" name="rule_name" required>
                        </div>
                        <div class="form-field">
                            <label><?php esc_html_e('Rule Type', 'bfluxco'); ?></label>
                            <select name="rule_type">
                                <option value="redirect"><?php esc_html_e('Redirect', 'bfluxco'); ?></option>
                                <option value="block"><?php esc_html_e('Block', 'bfluxco'); ?></option>
                                <option value="escalate"><?php esc_html_e('Escalate', 'bfluxco'); ?></option>
                                <option value="modify"><?php esc_html_e('Modify', 'bfluxco'); ?></option>
                            </select>
                        </div>
                        <div class="form-field">
                            <label><?php esc_html_e('Trigger Pattern (keywords or regex)', 'bfluxco'); ?></label>
                            <textarea name="trigger_pattern" rows="3" required></textarea>
                        </div>
                        <div class="form-field">
                            <label class="checkbox-option">
                                <input type="checkbox" name="is_active" value="1" checked>
                                <span><?php esc_html_e('Active', 'bfluxco'); ?></span>
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="button modal-cancel"><?php esc_html_e('Cancel', 'bfluxco'); ?></button>
                        <button type="submit" class="button button-primary"><?php esc_html_e('Save Rule', 'bfluxco'); ?></button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Rules Info Modal -->
        <div id="rules-info-modal" class="modal">
            <div class="modal-backdrop"></div>
            <div class="modal-content modal-lg">
                <div class="modal-header">
                    <h3><?php esc_html_e('About Boundary Rules', 'bfluxco'); ?></h3>
                    <button type="button" class="modal-close">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="rules-explainer-modal">
                        <p><?php esc_html_e('Boundary rules define how the AI responds when it detects specific patterns in user messages. Each rule has a trigger pattern (keywords or regex) and an action type:', 'bfluxco'); ?></p>
                        <ul>
                            <li><strong><?php esc_html_e('Redirect', 'bfluxco'); ?></strong> &mdash; <?php esc_html_e('Guide the user to a specific page or resource instead of answering directly.', 'bfluxco'); ?></li>
                            <li><strong><?php esc_html_e('Block', 'bfluxco'); ?></strong> &mdash; <?php esc_html_e('Politely decline to answer and explain why (e.g., medical/legal advice).', 'bfluxco'); ?></li>
                            <li><strong><?php esc_html_e('Escalate', 'bfluxco'); ?></strong> &mdash; <?php esc_html_e('Immediately trigger a handoff to connect the user with Ray.', 'bfluxco'); ?></li>
                            <li><strong><?php esc_html_e('Modify', 'bfluxco'); ?></strong> &mdash; <?php esc_html_e('Add a disclaimer or additional context to the AI response.', 'bfluxco'); ?></li>
                        </ul>
                    </div>

                    <h4><?php esc_html_e('Example Rules for This Site', 'bfluxco'); ?></h4>
                    <p class="example-intro"><?php esc_html_e('Here are some boundary rules that would be appropriate for a GenAI experience design portfolio:', 'bfluxco'); ?></p>

                    <table class="example-rules-table widefat">
                        <thead>
                            <tr>
                                <th><?php esc_html_e('Rule Name', 'bfluxco'); ?></th>
                                <th><?php esc_html_e('Type', 'bfluxco'); ?></th>
                                <th><?php esc_html_e('Trigger Pattern', 'bfluxco'); ?></th>
                                <th><?php esc_html_e('Purpose', 'bfluxco'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong><?php esc_html_e('Pricing Inquiry', 'bfluxco'); ?></strong></td>
                                <td><span class="rule-type rule-type-redirect"><?php esc_html_e('Redirect', 'bfluxco'); ?></span></td>
                                <td><code>price|cost|rate|quote|budget|how much</code></td>
                                <td><?php esc_html_e('Direct pricing questions to the contact page for personalized discussion.', 'bfluxco'); ?></td>
                            </tr>
                            <tr>
                                <td><strong><?php esc_html_e('Competitor Info', 'bfluxco'); ?></strong></td>
                                <td><span class="rule-type rule-type-block"><?php esc_html_e('Block', 'bfluxco'); ?></span></td>
                                <td><code>vs |compare|competitor|alternative to</code></td>
                                <td><?php esc_html_e('Avoid comparisons with other consultants or agencies.', 'bfluxco'); ?></td>
                            </tr>
                            <tr>
                                <td><strong><?php esc_html_e('Urgent Project', 'bfluxco'); ?></strong></td>
                                <td><span class="rule-type rule-type-escalate"><?php esc_html_e('Escalate', 'bfluxco'); ?></span></td>
                                <td><code>urgent|asap|immediately|deadline|rush</code></td>
                                <td><?php esc_html_e('Fast-track time-sensitive inquiries to direct contact.', 'bfluxco'); ?></td>
                            </tr>
                            <tr>
                                <td><strong><?php esc_html_e('Confidential Work', 'bfluxco'); ?></strong></td>
                                <td><span class="rule-type rule-type-block"><?php esc_html_e('Block', 'bfluxco'); ?></span></td>
                                <td><code>NDA|confidential|internal|proprietary</code></td>
                                <td><?php esc_html_e('Decline to share details about confidential client projects.', 'bfluxco'); ?></td>
                            </tr>
                            <tr>
                                <td><strong><?php esc_html_e('AI Ethics', 'bfluxco'); ?></strong></td>
                                <td><span class="rule-type rule-type-modify"><?php esc_html_e('Modify', 'bfluxco'); ?></span></td>
                                <td><code>bias|ethics|responsible AI|fairness</code></td>
                                <td><?php esc_html_e('Add context about Ray\'s human-centered AI approach.', 'bfluxco'); ?></td>
                            </tr>
                            <tr>
                                <td><strong><?php esc_html_e('Job Inquiries', 'bfluxco'); ?></strong></td>
                                <td><span class="rule-type rule-type-redirect"><?php esc_html_e('Redirect', 'bfluxco'); ?></span></td>
                                <td><code>hiring|job|position|career|work for you</code></td>
                                <td><?php esc_html_e('Guide employment inquiries to LinkedIn or contact form.', 'bfluxco'); ?></td>
                            </tr>
                        </tbody>
                    </table>

                    <p class="rules-tip"><?php esc_html_e('Tip: Start with broad categories and refine based on trigger counts. Monitor which rules fire most frequently to optimize your boundaries.', 'bfluxco'); ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="button button-primary modal-cancel"><?php esc_html_e('Close', 'bfluxco'); ?></button>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Tab 4: Monitoring
     */
    private static function render_tab_monitoring() {
        ?>
        <div class="ai-chat-monitoring">
            <div class="charts-row">
                <div class="chart-container">
                    <div class="chart-header">
                        <h3><?php esc_html_e('Conversation Continuation Funnel', 'bfluxco'); ?></h3>
                        <div class="time-range-toggle" data-chart="conversation_funnel">
                            <button class="time-btn" data-range="24h">24h</button>
                            <button class="time-btn active" data-range="7d">7d</button>
                        </div>
                    </div>
                    <canvas id="chart-funnel" height="280"></canvas>
                    <p class="chart-helper"></p>
                </div>

                <div class="chart-container">
                    <div class="chart-header">
                        <h3><?php esc_html_e('Drop-off by Turn Number', 'bfluxco'); ?></h3>
                        <div class="time-range-toggle" data-chart="dropoff_by_turn">
                            <button class="time-btn" data-range="24h">24h</button>
                            <button class="time-btn active" data-range="7d">7d</button>
                        </div>
                    </div>
                    <canvas id="chart-dropoff" height="280"></canvas>
                    <p class="chart-helper"></p>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Tab 5: User Feedback
     */
    private static function render_tab_feedback() {
        global $wpdb;
        $table = $wpdb->prefix . 'bfluxco_ai_feedback';

        // Get quick stats
        $total = $wpdb->get_var("SELECT COUNT(*) FROM $table");
        $helpful = $wpdb->get_var("SELECT COUNT(*) FROM $table WHERE feedback_type = 'helpful'");
        $not_helpful = $total - $helpful;
        $helpful_rate = $total > 0 ? round(($helpful / $total) * 100, 1) : 0;
        ?>
        <div class="ai-chat-feedback">
            <!-- Stats -->
            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-label"><?php esc_html_e('Total Feedback', 'bfluxco'); ?></div>
                    <div class="stat-value"><?php echo esc_html($total); ?></div>
                </div>
                <div class="stat-card status-active">
                    <div class="stat-label"><?php esc_html_e('Helpful', 'bfluxco'); ?></div>
                    <div class="stat-value"><?php echo esc_html($helpful); ?></div>
                </div>
                <div class="stat-card <?php echo $helpful_rate < 70 ? 'status-warning' : ''; ?>">
                    <div class="stat-label"><?php esc_html_e('Helpful Rate', 'bfluxco'); ?></div>
                    <div class="stat-value"><?php echo esc_html($helpful_rate); ?>%</div>
                </div>
            </div>

            <!-- Charts -->
            <div class="charts-row">
                <div class="chart-container">
                    <div class="chart-header">
                        <h3><?php esc_html_e('Helpful vs Not Helpful Trend', 'bfluxco'); ?></h3>
                        <div class="time-range-toggle" data-chart="feedback_trend">
                            <button class="time-btn active" data-range="7d">7d</button>
                            <button class="time-btn" data-range="30d">30d</button>
                        </div>
                    </div>
                    <canvas id="chart-feedback-trend" height="280"></canvas>
                    <p class="chart-helper"></p>
                </div>

                <div class="chart-container">
                    <div class="chart-header">
                        <h3><?php esc_html_e('Not Helpful Reasons', 'bfluxco'); ?></h3>
                        <div class="time-range-toggle" data-chart="feedback_reasons">
                            <button class="time-btn active" data-range="7d">7d</button>
                            <button class="time-btn" data-range="30d">30d</button>
                        </div>
                    </div>
                    <canvas id="chart-feedback-reasons" height="280"></canvas>
                    <p class="chart-helper"></p>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Tab 6: Training
     */
    private static function render_tab_training() {
        $counts = BFLUXCO_AI_Chat_Training::get_counts();
        $categories = BFLUXCO_AI_Chat_Training::get_categories();
        $examples = BFLUXCO_AI_Chat_Training::get_examples(array('limit' => 50));
        ?>
        <div class="ai-chat-training">
            <!-- Notice -->
            <div class="training-notice">
                <p><strong><?php esc_html_e('Human-in-the-loop training only.', 'bfluxco'); ?></strong> <?php esc_html_e('User conversations are not used for training by default. Only admin-curated examples are stored here.', 'bfluxco'); ?></p>
            </div>

            <!-- Stats -->
            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-label"><?php esc_html_e('Total Examples', 'bfluxco'); ?></div>
                    <div class="stat-value"><?php echo esc_html($counts['total']); ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-label"><?php esc_html_e('Pending Review', 'bfluxco'); ?></div>
                    <div class="stat-value"><?php echo esc_html($counts['pending']); ?></div>
                </div>
                <div class="stat-card status-active">
                    <div class="stat-label"><?php esc_html_e('Approved', 'bfluxco'); ?></div>
                    <div class="stat-value"><?php echo esc_html($counts['approved']); ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-label"><?php esc_html_e('Rejected', 'bfluxco'); ?></div>
                    <div class="stat-value"><?php echo esc_html($counts['rejected']); ?></div>
                </div>
            </div>

            <!-- Actions -->
            <div class="section-header">
                <h3><?php esc_html_e('Training Examples', 'bfluxco'); ?></h3>
                <div class="section-actions">
                    <button type="button" class="button" id="add-training-btn"><?php esc_html_e('Add Example', 'bfluxco'); ?></button>
                    <button type="button" class="button" id="export-training-btn"><?php esc_html_e('Export Approved', 'bfluxco'); ?></button>
                </div>
            </div>

            <!-- Bulk Actions -->
            <div class="bulk-actions" style="display: none;">
                <span class="selected-count">0 selected</span>
                <button type="button" class="button bulk-approve"><?php esc_html_e('Approve Selected', 'bfluxco'); ?></button>
                <button type="button" class="button bulk-reject"><?php esc_html_e('Reject Selected', 'bfluxco'); ?></button>
                <button type="button" class="button bulk-delete"><?php esc_html_e('Delete Selected', 'bfluxco'); ?></button>
            </div>

            <!-- Table -->
            <?php if (empty($examples)) : ?>
                <div class="empty-state">
                    <span class="dashicons dashicons-welcome-learn-more"></span>
                    <p><?php esc_html_e('No training examples yet', 'bfluxco'); ?></p>
                    <span class="empty-state-hint"><?php esc_html_e('Add examples to improve AI responses.', 'bfluxco'); ?></span>
                    <div class="empty-state-action">
                        <button type="button" class="button button-primary" id="add-training-btn-empty"><?php esc_html_e('Add Example', 'bfluxco'); ?></button>
                    </div>
                </div>
            <?php else : ?>
                <table class="training-table widefat">
                    <thead>
                        <tr>
                            <th class="check-column"><input type="checkbox" id="select-all-training"></th>
                            <th><?php esc_html_e('Input', 'bfluxco'); ?></th>
                            <th><?php esc_html_e('Expected Output', 'bfluxco'); ?></th>
                            <th><?php esc_html_e('Category', 'bfluxco'); ?></th>
                            <th><?php esc_html_e('Status', 'bfluxco'); ?></th>
                            <th><?php esc_html_e('Actions', 'bfluxco'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($examples as $example) : ?>
                            <tr data-id="<?php echo esc_attr($example->id); ?>">
                                <td><input type="checkbox" class="training-checkbox" value="<?php echo esc_attr($example->id); ?>"></td>
                                <td class="input-col"><?php echo esc_html(wp_trim_words($example->input_text, 20)); ?></td>
                                <td class="output-col"><?php echo esc_html(wp_trim_words($example->expected_output, 20)); ?></td>
                                <td><?php echo esc_html($categories[$example->category] ?? $example->category); ?></td>
                                <td>
                                    <span class="status-badge status-<?php echo esc_attr($example->status); ?>">
                                        <?php echo esc_html(ucfirst($example->status)); ?>
                                    </span>
                                </td>
                                <td>
                                    <button type="button" class="button-link edit-training" data-id="<?php echo esc_attr($example->id); ?>"><?php esc_html_e('Edit', 'bfluxco'); ?></button>
                                    <?php if ($example->status === 'pending') : ?>
                                        <button type="button" class="button-link approve-training" data-id="<?php echo esc_attr($example->id); ?>"><?php esc_html_e('Approve', 'bfluxco'); ?></button>
                                    <?php endif; ?>
                                    <button type="button" class="button-link delete-training" data-id="<?php echo esc_attr($example->id); ?>"><?php esc_html_e('Delete', 'bfluxco'); ?></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

        <!-- Training Modal -->
        <div id="training-modal" class="modal">
            <div class="modal-backdrop"></div>
            <div class="modal-content modal-lg">
                <div class="modal-header">
                    <h3><?php esc_html_e('Add Training Example', 'bfluxco'); ?></h3>
                    <button type="button" class="modal-close">&times;</button>
                </div>
                <form id="training-form">
                    <input type="hidden" name="training_id" value="">
                    <div class="modal-body">
                        <div class="form-field">
                            <label><?php esc_html_e('User Input (Example Prompt)', 'bfluxco'); ?></label>
                            <textarea name="input_text" rows="3" required placeholder="<?php esc_attresc_html_e('What a user might ask...', 'bfluxco'); ?>"></textarea>
                        </div>
                        <div class="form-field">
                            <label><?php esc_html_e('Expected Output (Ideal Response)', 'bfluxco'); ?></label>
                            <textarea name="expected_output" rows="5" required placeholder="<?php esc_attresc_html_e('How the AI should respond...', 'bfluxco'); ?>"></textarea>
                        </div>
                        <div class="form-row">
                            <div class="form-field">
                                <label><?php esc_html_e('Category', 'bfluxco'); ?></label>
                                <select name="category">
                                    <option value=""><?php esc_html_e('Select category...', 'bfluxco'); ?></option>
                                    <?php foreach ($categories as $key => $label) : ?>
                                        <option value="<?php echo esc_attr($key); ?>"><?php echo esc_html($label); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-field">
                                <label><?php esc_html_e('Tags (comma-separated)', 'bfluxco'); ?></label>
                                <input type="text" name="tags" placeholder="<?php esc_attresc_html_e('e.g., pricing, enterprise', 'bfluxco'); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="button modal-cancel"><?php esc_html_e('Cancel', 'bfluxco'); ?></button>
                        <button type="submit" class="button button-primary"><?php esc_html_e('Save Example', 'bfluxco'); ?></button>
                    </div>
                </form>
            </div>
        </div>
        <?php
    }

    /**
     * Tab 7: System
     */
    private static function render_tab_system() {
        $system = BFLUXCO_AI_Chat_Settings::get_system();
        $provider_status = BFLUXCO_AI_Chat_Settings::get_provider_status();
        ?>
        <div class="ai-chat-system">
            <form id="system-form" class="settings-form">
                <input type="hidden" name="action" value="bfluxco_ai_save_system">
                <input type="hidden" name="nonce" value="<?php echo wp_create_nonce(self::NONCE_ACTION); ?>">

                <!-- Provider -->
                <div class="form-section">
                    <h3><?php esc_html_e('AI Provider', 'bfluxco'); ?></h3>
                    <div class="form-row">
                        <div class="form-field">
                            <label><?php esc_html_e('Primary Provider', 'bfluxco'); ?></label>
                            <select name="primary_provider">
                                <option value="mistral" <?php selected($system['primary_provider'], 'mistral'); ?>>Mistral AI</option>
                                <option value="openai" <?php selected($system['primary_provider'], 'openai'); ?>>OpenAI</option>
                                <option value="gemini" <?php selected($system['primary_provider'], 'gemini'); ?>>Google Gemini</option>
                            </select>
                            <?php if (!$provider_status['has_api_key']) : ?>
                                <p class="field-warning"><?php esc_html_e('API key not configured. Add to wp-config.php', 'bfluxco'); ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="form-field">
                            <label><?php esc_html_e('Fallback Provider', 'bfluxco'); ?></label>
                            <select name="fallback_provider">
                                <option value="" <?php selected($system['fallback_provider'], ''); ?>><?php esc_html_e('None', 'bfluxco'); ?></option>
                                <option value="mistral" <?php selected($system['fallback_provider'], 'mistral'); ?>>Mistral AI</option>
                                <option value="openai" <?php selected($system['fallback_provider'], 'openai'); ?>>OpenAI</option>
                                <option value="gemini" <?php selected($system['fallback_provider'], 'gemini'); ?>>Google Gemini</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Rate Limits -->
                <div class="form-section">
                    <h3><?php esc_html_e('Rate Limiting', 'bfluxco'); ?></h3>
                    <div class="form-row">
                        <div class="form-field">
                            <label><?php esc_html_e('Requests per minute (per IP)', 'bfluxco'); ?></label>
                            <input type="number" name="rate_limit_per_minute" value="<?php echo esc_attr($system['rate_limit_per_minute']); ?>" min="1" max="100">
                        </div>
                        <div class="form-field">
                            <label><?php esc_html_e('Requests per day (global)', 'bfluxco'); ?></label>
                            <input type="number" name="rate_limit_per_day" value="<?php echo esc_attr($system['rate_limit_per_day']); ?>" min="10" max="10000">
                        </div>
                    </div>
                </div>

                <!-- Timeouts -->
                <div class="form-section">
                    <h3><?php esc_html_e('Reliability', 'bfluxco'); ?></h3>
                    <div class="form-row">
                        <div class="form-field">
                            <label><?php esc_html_e('API Timeout (seconds)', 'bfluxco'); ?></label>
                            <input type="number" name="api_timeout" value="<?php echo esc_attr($system['api_timeout']); ?>" min="5" max="120">
                        </div>
                        <div class="form-field">
                            <label><?php esc_html_e('Retry Attempts', 'bfluxco'); ?></label>
                            <input type="number" name="retry_attempts" value="<?php echo esc_attr($system['retry_attempts']); ?>" min="0" max="5">
                        </div>
                    </div>
                </div>

                <!-- Data Retention -->
                <div class="form-section">
                    <h3><?php esc_html_e('Data Retention', 'bfluxco'); ?></h3>
                    <div class="form-row">
                        <div class="form-field">
                            <label><?php esc_html_e('Keep metrics for (days)', 'bfluxco'); ?></label>
                            <input type="number" name="data_retention_days" value="<?php echo esc_attr($system['data_retention_days']); ?>" min="7" max="365">
                        </div>
                        <div class="form-field">
                            <label><?php esc_html_e('Logging Level', 'bfluxco'); ?></label>
                            <select name="logging_level">
                                <option value="metadata" <?php selected($system['logging_level'], 'metadata'); ?>><?php esc_html_e('Metadata Only', 'bfluxco'); ?></option>
                                <option value="expanded" <?php selected($system['logging_level'], 'expanded'); ?>><?php esc_html_e('Expanded', 'bfluxco'); ?></option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="button button-primary"><?php esc_html_e('Save Settings', 'bfluxco'); ?></button>
                    <span class="save-status"></span>
                </div>
            </form>

            <!-- Charts -->
            <div class="charts-row">
                <div class="chart-container">
                    <div class="chart-header">
                        <h3><?php esc_html_e('Provider Usage Mix', 'bfluxco'); ?></h3>
                        <div class="time-range-toggle" data-chart="provider_usage">
                            <button class="time-btn" data-range="24h">24h</button>
                            <button class="time-btn active" data-range="7d">7d</button>
                            <button class="time-btn" data-range="30d">30d</button>
                        </div>
                    </div>
                    <canvas id="chart-provider-usage" height="250"></canvas>
                    <p class="chart-helper"></p>
                </div>

                <div class="chart-container">
                    <div class="chart-header">
                        <h3><?php esc_html_e('Rate Limit Events', 'bfluxco'); ?></h3>
                        <div class="time-range-toggle" data-chart="rate_limit_events">
                            <button class="time-btn" data-range="24h">24h</button>
                            <button class="time-btn active" data-range="7d">7d</button>
                            <button class="time-btn" data-range="30d">30d</button>
                        </div>
                    </div>
                    <canvas id="chart-rate-limits" height="250"></canvas>
                    <p class="chart-helper"></p>
                </div>
            </div>
        </div>
        <?php
    }

    // ==========================================
    // AJAX Handlers
    // ==========================================

    /**
     * AJAX: Get chart data
     */
    public static function ajax_get_chart_data() {
        check_ajax_referer(self::NONCE_ACTION, 'nonce');

        if (!current_user_can(self::CAPABILITY)) {
            wp_send_json_error('Permission denied');
        }

        $chart_type = sanitize_text_field($_POST['chart_type'] ?? '');
        $time_range = sanitize_text_field($_POST['time_range'] ?? '7d');

        $data = BFLUXCO_AI_Chat_Metrics::get_chart_data($chart_type, $time_range);

        wp_send_json_success($data);
    }

    /**
     * AJAX: Save behavior settings
     */
    public static function ajax_save_behavior() {
        check_ajax_referer(self::NONCE_ACTION, 'nonce');

        if (!current_user_can(self::CAPABILITY)) {
            wp_send_json_error('Permission denied');
        }

        $result = BFLUXCO_AI_Chat_Settings::save_behavior($_POST);

        if ($result) {
            wp_send_json_success(array('message' => __('Settings saved', 'bfluxco')));
        } else {
            wp_send_json_error(__('Failed to save settings', 'bfluxco'));
        }
    }

    /**
     * AJAX: Save system settings
     */
    public static function ajax_save_system() {
        check_ajax_referer(self::NONCE_ACTION, 'nonce');

        if (!current_user_can(self::CAPABILITY)) {
            wp_send_json_error('Permission denied');
        }

        $result = BFLUXCO_AI_Chat_Settings::save_system($_POST);

        if ($result) {
            wp_send_json_success(array('message' => __('Settings saved', 'bfluxco')));
        } else {
            wp_send_json_error(__('Failed to save settings', 'bfluxco'));
        }
    }

    /**
     * AJAX: Save boundary settings
     */
    public static function ajax_save_boundaries() {
        check_ajax_referer(self::NONCE_ACTION, 'nonce');

        if (!current_user_can(self::CAPABILITY)) {
            wp_send_json_error('Permission denied');
        }

        $result = BFLUXCO_AI_Chat_Settings::save_boundaries($_POST);

        if ($result) {
            wp_send_json_success(array('message' => __('Boundaries saved', 'bfluxco')));
        } else {
            wp_send_json_error(__('Failed to save boundaries', 'bfluxco'));
        }
    }

    /**
     * AJAX: Save rule
     */
    public static function ajax_save_rule() {
        check_ajax_referer(self::NONCE_ACTION, 'nonce');

        if (!current_user_can(self::CAPABILITY)) {
            wp_send_json_error('Permission denied');
        }

        global $wpdb;
        $table = $wpdb->prefix . 'bfluxco_ai_rules';

        $rule_id = absint($_POST['rule_id'] ?? 0);
        $data = array(
            'rule_name' => sanitize_text_field($_POST['rule_name'] ?? ''),
            'rule_type' => sanitize_text_field($_POST['rule_type'] ?? 'block'),
            'trigger_pattern' => sanitize_textarea_field($_POST['trigger_pattern'] ?? ''),
            'is_active' => !empty($_POST['is_active']) ? 1 : 0,
        );

        if ($rule_id > 0) {
            $wpdb->update($table, $data, array('id' => $rule_id));
        } else {
            $wpdb->insert($table, $data);
            $rule_id = $wpdb->insert_id;
        }

        wp_send_json_success(array('rule_id' => $rule_id));
    }

    /**
     * AJAX: Delete rule
     */
    public static function ajax_delete_rule() {
        check_ajax_referer(self::NONCE_ACTION, 'nonce');

        if (!current_user_can(self::CAPABILITY)) {
            wp_send_json_error('Permission denied');
        }

        global $wpdb;
        $table = $wpdb->prefix . 'bfluxco_ai_rules';

        $rule_id = absint($_POST['rule_id'] ?? 0);
        $wpdb->delete($table, array('id' => $rule_id));

        wp_send_json_success();
    }

    /**
     * AJAX: Add training example
     */
    public static function ajax_add_training() {
        check_ajax_referer(self::NONCE_ACTION, 'nonce');

        if (!current_user_can(self::CAPABILITY)) {
            wp_send_json_error('Permission denied');
        }

        $result = BFLUXCO_AI_Chat_Training::add_example(
            $_POST['input_text'] ?? '',
            $_POST['expected_output'] ?? '',
            $_POST['category'] ?? '',
            $_POST['tags'] ?? ''
        );

        if (is_wp_error($result)) {
            wp_send_json_error($result->get_error_message());
        }

        wp_send_json_success(array('id' => $result));
    }

    /**
     * AJAX: Update training example
     */
    public static function ajax_update_training() {
        check_ajax_referer(self::NONCE_ACTION, 'nonce');

        if (!current_user_can(self::CAPABILITY)) {
            wp_send_json_error('Permission denied');
        }

        $id = absint($_POST['training_id'] ?? 0);
        $action_type = sanitize_text_field($_POST['action_type'] ?? '');

        if ($action_type === 'approve') {
            BFLUXCO_AI_Chat_Training::approve_example($id);
        } elseif ($action_type === 'reject') {
            BFLUXCO_AI_Chat_Training::reject_example($id, $_POST['notes'] ?? '');
        } else {
            BFLUXCO_AI_Chat_Training::update_example($id, $_POST);
        }

        wp_send_json_success();
    }

    /**
     * AJAX: Delete training example
     */
    public static function ajax_delete_training() {
        check_ajax_referer(self::NONCE_ACTION, 'nonce');

        if (!current_user_can(self::CAPABILITY)) {
            wp_send_json_error('Permission denied');
        }

        $id = absint($_POST['training_id'] ?? 0);
        BFLUXCO_AI_Chat_Training::delete_example($id);

        wp_send_json_success();
    }

    /**
     * AJAX: Bulk training actions
     */
    public static function ajax_bulk_training() {
        check_ajax_referer(self::NONCE_ACTION, 'nonce');

        if (!current_user_can(self::CAPABILITY)) {
            wp_send_json_error('Permission denied');
        }

        $ids = isset($_POST['ids']) ? array_map('absint', $_POST['ids']) : array();
        $action_type = sanitize_text_field($_POST['action_type'] ?? '');

        switch ($action_type) {
            case 'approve':
                BFLUXCO_AI_Chat_Training::bulk_approve($ids);
                break;
            case 'reject':
                BFLUXCO_AI_Chat_Training::bulk_reject($ids);
                break;
            case 'delete':
                BFLUXCO_AI_Chat_Training::bulk_delete($ids);
                break;
        }

        wp_send_json_success();
    }

    /**
     * AJAX: Export training data
     */
    public static function ajax_export_training() {
        check_ajax_referer(self::NONCE_ACTION, 'nonce');

        if (!current_user_can(self::CAPABILITY)) {
            wp_send_json_error('Permission denied');
        }

        $export = BFLUXCO_AI_Chat_Training::export_approved();

        wp_send_json_success($export);
    }

    /**
     * AJAX: Save persona settings
     */
    public static function ajax_save_persona() {
        check_ajax_referer(self::NONCE_ACTION, 'nonce');

        if (!current_user_can(self::CAPABILITY)) {
            wp_send_json_error('Permission denied');
        }

        $change_notes = sanitize_text_field($_POST['change_notes'] ?? '');
        $result = BFLUXCO_AI_Chat_Settings::save_persona($_POST, $change_notes);

        if ($result) {
            $persona = BFLUXCO_AI_Chat_Settings::get_persona();
            wp_send_json_success(array(
                'message' => __('Persona settings saved', 'bfluxco'),
                'version' => $persona['version'] ?? '1.0',
            ));
        } else {
            wp_send_json_error(__('Failed to save persona settings', 'bfluxco'));
        }
    }

    /**
     * AJAX: Rollback persona to previous version
     */
    public static function ajax_rollback_persona() {
        check_ajax_referer(self::NONCE_ACTION, 'nonce');

        if (!current_user_can(self::CAPABILITY)) {
            wp_send_json_error('Permission denied');
        }

        $version = sanitize_text_field($_POST['version'] ?? '');

        if (empty($version)) {
            wp_send_json_error(__('No version specified', 'bfluxco'));
        }

        $result = BFLUXCO_AI_Chat_Settings::rollback_persona($version);

        if ($result) {
            wp_send_json_success(array(
                'message' => sprintf(__('Rolled back to version %s', 'bfluxco'), $version),
            ));
        } else {
            wp_send_json_error(__('Failed to rollback persona settings', 'bfluxco'));
        }
    }
}

// Initialize
BFLUXCO_AI_Chat_Admin::init();
