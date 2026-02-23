<?php
/**
 * AI Chat Metrics
 *
 * Handles metrics collection, storage, and aggregation for AI Chat observability.
 * All data is aggregate only - no user content is stored.
 *
 * @package BFLUXCO
 */

if (!defined('ABSPATH')) {
    exit;
}

class BFLUXCO_AI_Chat_Metrics {

    /**
     * Table names (without prefix)
     */
    const TABLE_METRICS = 'bfluxco_ai_metrics';
    const TABLE_EVENTS = 'bfluxco_ai_events';
    const TABLE_FEEDBACK = 'bfluxco_ai_feedback';
    const TABLE_RULES = 'bfluxco_ai_rules';
    const TABLE_RATE_LIMITS = 'bfluxco_ai_rate_limits';

    /**
     * DB version for migrations
     */
    const DB_VERSION = '1.0.0';
    const DB_VERSION_OPTION = 'bfluxco_ai_metrics_db_version';

    /**
     * Initialize the class
     */
    public static function init() {
        // Create tables on theme activation
        add_action('after_switch_theme', array(__CLASS__, 'create_tables'));

        // Schedule hourly rollup
        add_action('bfluxco_ai_metrics_rollup', array(__CLASS__, 'aggregate_hourly_metrics'));

        // Schedule daily cleanup
        add_action('bfluxco_ai_metrics_cleanup', array(__CLASS__, 'cleanup_old_data'));

        // Check if tables need creation
        if (get_option(self::DB_VERSION_OPTION) !== self::DB_VERSION) {
            self::create_tables();
        }
    }

    /**
     * Create database tables
     */
    public static function create_tables() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        // Table 1: Aggregate Metrics (hourly rollups)
        $table_metrics = $wpdb->prefix . self::TABLE_METRICS;
        $sql_metrics = "CREATE TABLE $table_metrics (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            metric_type VARCHAR(50) NOT NULL,
            metric_value DECIMAL(10,4) NOT NULL,
            bucket_start DATETIME NOT NULL,
            bucket_end DATETIME NOT NULL,
            sample_count INT UNSIGNED DEFAULT 1,
            metadata LONGTEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_type_bucket (metric_type, bucket_start),
            INDEX idx_bucket (bucket_start)
        ) $charset_collate;";
        dbDelta($sql_metrics);

        // Table 2: Conversation Events (aggregate only, no content)
        $table_events = $wpdb->prefix . self::TABLE_EVENTS;
        $sql_events = "CREATE TABLE $table_events (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            session_hash VARCHAR(64) NOT NULL,
            event_type VARCHAR(50) NOT NULL,
            turn_number TINYINT UNSIGNED,
            feature_flags LONGTEXT,
            response_time_ms INT UNSIGNED,
            triggered_rules LONGTEXT,
            provider VARCHAR(30),
            is_error TINYINT(1) DEFAULT 0,
            is_fallback TINYINT(1) DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_type_date (event_type, created_at),
            INDEX idx_session (session_hash),
            INDEX idx_created (created_at)
        ) $charset_collate;";
        dbDelta($sql_events);

        // Table 3: User Feedback (aggregate only)
        $table_feedback = $wpdb->prefix . self::TABLE_FEEDBACK;
        $sql_feedback = "CREATE TABLE $table_feedback (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            feedback_type ENUM('helpful', 'not_helpful') NOT NULL,
            reason VARCHAR(100),
            response_length_bucket VARCHAR(20),
            turn_number TINYINT UNSIGNED,
            hour_of_day TINYINT UNSIGNED,
            day_of_week TINYINT UNSIGNED,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_type_date (feedback_type, created_at),
            INDEX idx_created (created_at)
        ) $charset_collate;";
        dbDelta($sql_feedback);

        // Table 4: Boundary Rules
        $table_rules = $wpdb->prefix . self::TABLE_RULES;
        $sql_rules = "CREATE TABLE $table_rules (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            rule_name VARCHAR(100) NOT NULL,
            rule_type ENUM('redirect', 'block', 'escalate', 'modify') NOT NULL,
            trigger_pattern TEXT NOT NULL,
            trigger_count INT UNSIGNED DEFAULT 0,
            action_config LONGTEXT,
            is_active TINYINT(1) DEFAULT 1,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_active (is_active)
        ) $charset_collate;";
        dbDelta($sql_rules);

        // Table 5: Rate Limit Events
        $table_rate_limits = $wpdb->prefix . self::TABLE_RATE_LIMITS;
        $sql_rate_limits = "CREATE TABLE $table_rate_limits (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            limit_type VARCHAR(30) NOT NULL,
            event_type ENUM('warning', 'blocked') NOT NULL,
            provider VARCHAR(30),
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_type_date (limit_type, created_at),
            INDEX idx_created (created_at)
        ) $charset_collate;";
        dbDelta($sql_rate_limits);

        // Update version
        update_option(self::DB_VERSION_OPTION, self::DB_VERSION);

        // Schedule cron jobs if not scheduled
        if (!wp_next_scheduled('bfluxco_ai_metrics_rollup')) {
            wp_schedule_event(time(), 'hourly', 'bfluxco_ai_metrics_rollup');
        }
        if (!wp_next_scheduled('bfluxco_ai_metrics_cleanup')) {
            wp_schedule_event(time(), 'daily', 'bfluxco_ai_metrics_cleanup');
        }
    }

    /**
     * Record a conversation event
     */
    public static function record_event($event_type, $data = array()) {
        global $wpdb;

        $table = $wpdb->prefix . self::TABLE_EVENTS;

        $insert_data = array(
            'session_hash' => sanitize_text_field($data['session_hash'] ?? ''),
            'event_type' => sanitize_text_field($event_type),
            'turn_number' => isset($data['turn_number']) ? absint($data['turn_number']) : null,
            'feature_flags' => isset($data['features']) ? wp_json_encode($data['features']) : null,
            'response_time_ms' => isset($data['response_time_ms']) ? absint($data['response_time_ms']) : null,
            'triggered_rules' => isset($data['triggered_rules']) ? wp_json_encode($data['triggered_rules']) : null,
            'provider' => sanitize_text_field($data['provider'] ?? ''),
            'is_error' => !empty($data['is_error']) ? 1 : 0,
            'is_fallback' => !empty($data['is_fallback']) ? 1 : 0,
            'created_at' => current_time('mysql'),
        );

        $wpdb->insert($table, $insert_data);

        return $wpdb->insert_id;
    }

    /**
     * Record user feedback
     */
    public static function record_feedback($type, $data = array()) {
        global $wpdb;

        $table = $wpdb->prefix . self::TABLE_FEEDBACK;

        $now = current_time('timestamp');

        $insert_data = array(
            'feedback_type' => in_array($type, array('helpful', 'not_helpful')) ? $type : 'helpful',
            'reason' => isset($data['reason']) ? sanitize_text_field($data['reason']) : null,
            'response_length_bucket' => isset($data['length_bucket']) ? sanitize_text_field($data['length_bucket']) : null,
            'turn_number' => isset($data['turn_number']) ? absint($data['turn_number']) : null,
            'hour_of_day' => date('G', $now),
            'day_of_week' => date('w', $now),
            'created_at' => current_time('mysql'),
        );

        $wpdb->insert($table, $insert_data);

        return $wpdb->insert_id;
    }

    /**
     * Record rate limit event
     */
    public static function record_rate_limit($limit_type, $event_type, $provider = '') {
        global $wpdb;

        $table = $wpdb->prefix . self::TABLE_RATE_LIMITS;

        $wpdb->insert($table, array(
            'limit_type' => sanitize_text_field($limit_type),
            'event_type' => in_array($event_type, array('warning', 'blocked')) ? $event_type : 'warning',
            'provider' => sanitize_text_field($provider),
            'created_at' => current_time('mysql'),
        ));

        return $wpdb->insert_id;
    }

    /**
     * Increment rule trigger count
     */
    public static function increment_rule_trigger($rule_id) {
        global $wpdb;

        $table = $wpdb->prefix . self::TABLE_RULES;

        $wpdb->query($wpdb->prepare(
            "UPDATE $table SET trigger_count = trigger_count + 1 WHERE id = %d",
            $rule_id
        ));
    }

    /**
     * Get chart data for various chart types
     * Max 10 charts total across all tabs
     */
    public static function get_chart_data($chart_type, $time_range = '7d') {
        $range = self::parse_time_range($time_range);

        switch ($chart_type) {
            // Tab 1: Overview (2 charts)
            case 'response_time_trend':
                return self::get_response_time_trend($range);
            case 'error_fallback_rate':
                return self::get_error_fallback_rate($range);
            // Tab 3: Boundaries (2 charts)
            case 'top_triggered_rules':
                return self::get_top_triggered_rules($range);
            case 'boundary_triggers_trend':
                return self::get_boundary_triggers_trend($range);
            // Tab 4: Monitoring (2 charts)
            case 'conversation_funnel':
                return self::get_conversation_funnel($range);
            case 'dropoff_by_turn':
                return self::get_dropoff_by_turn($range);
            // Tab 5: User Feedback (2 charts)
            case 'feedback_trend':
                return self::get_feedback_trend($range);
            case 'feedback_reasons':
                return self::get_feedback_reasons($range);
            // Tab 7: System (2 charts)
            case 'provider_usage':
                return self::get_provider_usage($range);
            case 'rate_limit_events':
                return self::get_rate_limit_events($range);
            default:
                return array('error' => 'Unknown chart type');
        }
    }

    /**
     * Parse time range string to start/end dates
     */
    private static function parse_time_range($range) {
        $end = current_time('mysql');
        $days = 7;

        switch ($range) {
            case '24h':
                $days = 1;
                break;
            case '7d':
                $days = 7;
                break;
            case '30d':
                $days = 30;
                break;
        }

        $start = date('Y-m-d H:i:s', strtotime("-{$days} days", strtotime($end)));

        return array(
            'start' => $start,
            'end' => $end,
            'days' => $days,
        );
    }

    /**
     * Chart: Response Time Trend (p50 and p95)
     */
    private static function get_response_time_trend($range) {
        global $wpdb;

        $table = $wpdb->prefix . self::TABLE_EVENTS;

        // Get hourly buckets with response times
        $results = $wpdb->get_results($wpdb->prepare(
            "SELECT
                DATE_FORMAT(created_at, '%%Y-%%m-%%d %%H:00:00') as bucket,
                response_time_ms
            FROM $table
            WHERE created_at >= %s
                AND created_at <= %s
                AND response_time_ms IS NOT NULL
            ORDER BY created_at ASC",
            $range['start'],
            $range['end']
        ));

        // Group by bucket and calculate percentiles
        $buckets = array();
        foreach ($results as $row) {
            if (!isset($buckets[$row->bucket])) {
                $buckets[$row->bucket] = array();
            }
            $buckets[$row->bucket][] = (int) $row->response_time_ms;
        }

        $labels = array();
        $p50_data = array();
        $p95_data = array();

        foreach ($buckets as $bucket => $times) {
            $labels[] = $bucket;
            sort($times);
            $count = count($times);
            $p50_data[] = $times[(int) floor($count * 0.5)] ?? 0;
            $p95_data[] = $times[(int) floor($count * 0.95)] ?? 0;
        }

        return array(
            'labels' => $labels,
            'datasets' => array(
                array(
                    'label' => 'p50 Response Time (ms)',
                    'data' => $p50_data,
                    'borderColor' => '#10b981',
                    'fill' => false,
                ),
                array(
                    'label' => 'p95 Response Time (ms)',
                    'data' => $p95_data,
                    'borderColor' => '#f59e0b',
                    'fill' => false,
                ),
            ),
            'helper' => 'If p95 spikes above 3 seconds, review provider status or reduce max_tokens.',
        );
    }

    /**
     * Chart: Error + Fallback Rate
     */
    private static function get_error_fallback_rate($range) {
        global $wpdb;

        $table = $wpdb->prefix . self::TABLE_EVENTS;

        $results = $wpdb->get_results($wpdb->prepare(
            "SELECT
                DATE_FORMAT(created_at, '%%Y-%%m-%%d') as bucket,
                SUM(is_error) as errors,
                SUM(is_fallback) as fallbacks,
                COUNT(*) as total
            FROM $table
            WHERE created_at >= %s
                AND created_at <= %s
                AND event_type = 'turn'
            GROUP BY bucket
            ORDER BY bucket ASC",
            $range['start'],
            $range['end']
        ));

        $labels = array();
        $error_data = array();
        $fallback_data = array();

        foreach ($results as $row) {
            $labels[] = $row->bucket;
            $error_data[] = $row->total > 0 ? round(($row->errors / $row->total) * 100, 1) : 0;
            $fallback_data[] = $row->total > 0 ? round(($row->fallbacks / $row->total) * 100, 1) : 0;
        }

        return array(
            'labels' => $labels,
            'datasets' => array(
                array(
                    'label' => 'Error Rate (%)',
                    'data' => $error_data,
                    'backgroundColor' => 'rgba(239, 68, 68, 0.5)',
                    'borderColor' => '#ef4444',
                ),
                array(
                    'label' => 'Fallback Rate (%)',
                    'data' => $fallback_data,
                    'backgroundColor' => 'rgba(245, 158, 11, 0.5)',
                    'borderColor' => '#f59e0b',
                ),
            ),
            'helper' => 'Rising fallback rate indicates primary provider issues. Consider adjusting priority.',
        );
    }

    /**
     * Chart: Top Triggered Rules
     */
    private static function get_top_triggered_rules($range) {
        global $wpdb;

        $table = $wpdb->prefix . self::TABLE_RULES;

        $results = $wpdb->get_results(
            "SELECT rule_name, trigger_count
            FROM $table
            WHERE is_active = 1
            ORDER BY trigger_count DESC
            LIMIT 10"
        );

        $labels = array();
        $data = array();

        foreach ($results as $row) {
            $labels[] = $row->rule_name;
            $data[] = (int) $row->trigger_count;
        }

        return array(
            'labels' => $labels,
            'datasets' => array(
                array(
                    'label' => 'Trigger Count',
                    'data' => $data,
                    'backgroundColor' => '#6366f1',
                ),
            ),
            'helper' => 'High triggers indicate common user intents. Consider adding dedicated content.',
        );
    }

    /**
     * Chart: Boundary Triggers Over Time
     */
    private static function get_boundary_triggers_trend($range) {
        global $wpdb;

        $table = $wpdb->prefix . self::TABLE_EVENTS;

        $results = $wpdb->get_results($wpdb->prepare(
            "SELECT
                DATE_FORMAT(created_at, '%%Y-%%m-%%d') as bucket,
                COUNT(*) as count
            FROM $table
            WHERE created_at >= %s
                AND created_at <= %s
                AND triggered_rules IS NOT NULL
                AND triggered_rules != '[]'
            GROUP BY bucket
            ORDER BY bucket ASC",
            $range['start'],
            $range['end']
        ));

        $labels = array();
        $data = array();

        foreach ($results as $row) {
            $labels[] = $row->bucket;
            $data[] = (int) $row->count;
        }

        return array(
            'labels' => $labels,
            'datasets' => array(
                array(
                    'label' => 'Boundary Triggers',
                    'data' => $data,
                    'borderColor' => '#f59e0b',
                    'backgroundColor' => 'rgba(245, 158, 11, 0.1)',
                    'fill' => true,
                ),
            ),
            'helper' => 'Rising triggers after changes may indicate new risk patterns.',
        );
    }

    /**
     * DEPRECATED: Rule Trigger Heatmap - removed per refined spec
     */
    private static function get_rule_heatmap_deprecated($range) {
        global $wpdb;

        $table = $wpdb->prefix . self::TABLE_EVENTS;

        $results = $wpdb->get_results($wpdb->prepare(
            "SELECT
                DAYOFWEEK(created_at) as day_of_week,
                HOUR(created_at) as hour_of_day,
                COUNT(*) as count
            FROM $table
            WHERE created_at >= %s
                AND created_at <= %s
                AND triggered_rules IS NOT NULL
                AND triggered_rules != '[]'
            GROUP BY day_of_week, hour_of_day",
            $range['start'],
            $range['end']
        ));

        // Build 7x24 matrix
        $matrix = array();
        $days = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');

        foreach ($results as $row) {
            $matrix[] = array(
                'x' => (int) $row->hour_of_day,
                'y' => $days[$row->day_of_week - 1],
                'v' => (int) $row->count,
            );
        }

        return array(
            'data' => $matrix,
            'helper' => 'Spikes during traffic peaks suggest adding pre-clarification prompts.',
        );
    }

    /**
     * Chart: Conversation Funnel
     */
    private static function get_conversation_funnel($range) {
        global $wpdb;

        $table = $wpdb->prefix . self::TABLE_EVENTS;

        // Count unique sessions at each stage
        $started = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(DISTINCT session_hash) FROM $table
            WHERE created_at >= %s AND created_at <= %s AND event_type = 'conversation_start'",
            $range['start'], $range['end']
        ));

        $ai_responded = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(DISTINCT session_hash) FROM $table
            WHERE created_at >= %s AND created_at <= %s AND event_type = 'turn' AND turn_number = 1",
            $range['start'], $range['end']
        ));

        $continued = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(DISTINCT session_hash) FROM $table
            WHERE created_at >= %s AND created_at <= %s AND event_type = 'turn' AND turn_number >= 2",
            $range['start'], $range['end']
        ));

        $reached_3_turns = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(DISTINCT session_hash) FROM $table
            WHERE created_at >= %s AND created_at <= %s AND event_type = 'turn' AND turn_number >= 3",
            $range['start'], $range['end']
        ));

        return array(
            'labels' => array('Conversations Started', 'AI Responded', 'User Continued', 'Reached 3+ Turns'),
            'datasets' => array(
                array(
                    'data' => array(
                        (int) $started ?: 0,
                        (int) $ai_responded ?: 0,
                        (int) $continued ?: 0,
                        (int) $reached_3_turns ?: 0,
                    ),
                    'backgroundColor' => array('#10b981', '#6366f1', '#8b5cf6', '#ec4899'),
                ),
            ),
            'helper' => 'Drop-off after first AI turn suggests revising first response rules.',
        );
    }

    /**
     * Chart: Drop-off by Turn Number
     */
    private static function get_dropoff_by_turn($range) {
        global $wpdb;

        $table = $wpdb->prefix . self::TABLE_EVENTS;

        $results = $wpdb->get_results($wpdb->prepare(
            "SELECT turn_number, COUNT(DISTINCT session_hash) as sessions
            FROM $table
            WHERE created_at >= %s
                AND created_at <= %s
                AND event_type = 'turn'
                AND turn_number <= 10
            GROUP BY turn_number
            ORDER BY turn_number ASC",
            $range['start'],
            $range['end']
        ));

        $labels = array();
        $data = array();

        foreach ($results as $row) {
            $labels[] = 'Turn ' . $row->turn_number;
            $data[] = (int) $row->sessions;
        }

        return array(
            'labels' => $labels,
            'datasets' => array(
                array(
                    'label' => 'Active Sessions',
                    'data' => $data,
                    'backgroundColor' => '#6366f1',
                ),
            ),
            'helper' => 'Sharp drop at specific turns indicates problematic responses at that point.',
        );
    }

    /**
     * Chart: Feature Impact Comparison
     */
    private static function get_feature_impact($range) {
        global $wpdb;

        $table = $wpdb->prefix . self::TABLE_EVENTS;

        // Compare continuation rates with different features
        $cta_on = $wpdb->get_results($wpdb->prepare(
            "SELECT
                COUNT(DISTINCT CASE WHEN turn_number >= 2 THEN session_hash END) as continued,
                COUNT(DISTINCT session_hash) as total
            FROM $table
            WHERE created_at >= %s
                AND created_at <= %s
                AND event_type = 'turn'
                AND feature_flags LIKE '%%\"cta_generation\":true%%'",
            $range['start'],
            $range['end']
        ));

        $cta_off = $wpdb->get_results($wpdb->prepare(
            "SELECT
                COUNT(DISTINCT CASE WHEN turn_number >= 2 THEN session_hash END) as continued,
                COUNT(DISTINCT session_hash) as total
            FROM $table
            WHERE created_at >= %s
                AND created_at <= %s
                AND event_type = 'turn'
                AND (feature_flags NOT LIKE '%%\"cta_generation\":true%%' OR feature_flags IS NULL)",
            $range['start'],
            $range['end']
        ));

        $cta_on_rate = ($cta_on[0]->total ?? 0) > 0
            ? round(($cta_on[0]->continued / $cta_on[0]->total) * 100, 1)
            : 0;
        $cta_off_rate = ($cta_off[0]->total ?? 0) > 0
            ? round(($cta_off[0]->continued / $cta_off[0]->total) * 100, 1)
            : 0;

        return array(
            'labels' => array('CTA Enabled', 'CTA Disabled'),
            'datasets' => array(
                array(
                    'label' => 'Continuation Rate (%)',
                    'data' => array($cta_on_rate, $cta_off_rate),
                    'backgroundColor' => array('#10b981', '#6b7280'),
                ),
            ),
            'helper' => 'Disable features that reduce continuation rate.',
        );
    }

    /**
     * Chart: Feedback Trend (Helpful vs Not Helpful)
     */
    private static function get_feedback_trend($range) {
        global $wpdb;

        $table = $wpdb->prefix . self::TABLE_FEEDBACK;

        $results = $wpdb->get_results($wpdb->prepare(
            "SELECT
                DATE_FORMAT(created_at, '%%Y-%%m-%%d') as bucket,
                SUM(CASE WHEN feedback_type = 'helpful' THEN 1 ELSE 0 END) as helpful,
                SUM(CASE WHEN feedback_type = 'not_helpful' THEN 1 ELSE 0 END) as not_helpful
            FROM $table
            WHERE created_at >= %s AND created_at <= %s
            GROUP BY bucket
            ORDER BY bucket ASC",
            $range['start'],
            $range['end']
        ));

        $labels = array();
        $helpful_data = array();
        $not_helpful_data = array();

        foreach ($results as $row) {
            $labels[] = $row->bucket;
            $helpful_data[] = (int) $row->helpful;
            $not_helpful_data[] = (int) $row->not_helpful;
        }

        return array(
            'labels' => $labels,
            'datasets' => array(
                array(
                    'label' => 'Helpful',
                    'data' => $helpful_data,
                    'borderColor' => '#10b981',
                    'fill' => false,
                ),
                array(
                    'label' => 'Not Helpful',
                    'data' => $not_helpful_data,
                    'borderColor' => '#ef4444',
                    'fill' => false,
                ),
            ),
            'helper' => 'Declining trend after config change suggests rolling back.',
        );
    }

    /**
     * Chart: Feedback Reason Breakdown
     */
    private static function get_feedback_reasons($range) {
        global $wpdb;

        $table = $wpdb->prefix . self::TABLE_FEEDBACK;

        $results = $wpdb->get_results($wpdb->prepare(
            "SELECT reason, COUNT(*) as count
            FROM $table
            WHERE created_at >= %s
                AND created_at <= %s
                AND feedback_type = 'not_helpful'
                AND reason IS NOT NULL
            GROUP BY reason
            ORDER BY count DESC",
            $range['start'],
            $range['end']
        ));

        $labels = array();
        $data = array();

        foreach ($results as $row) {
            $labels[] = ucfirst(str_replace('_', ' ', $row->reason));
            $data[] = (int) $row->count;
        }

        return array(
            'labels' => $labels,
            'datasets' => array(
                array(
                    'data' => $data,
                    'backgroundColor' => array('#ef4444', '#f59e0b', '#6366f1', '#8b5cf6', '#ec4899'),
                ),
            ),
            'helper' => 'Dominant reasons point to specific fixes: "too long" = reduce max_tokens.',
        );
    }

    /**
     * Chart: Feedback by Response Length
     */
    private static function get_feedback_by_length($range) {
        global $wpdb;

        $table = $wpdb->prefix . self::TABLE_FEEDBACK;

        $results = $wpdb->get_results($wpdb->prepare(
            "SELECT
                response_length_bucket,
                SUM(CASE WHEN feedback_type = 'helpful' THEN 1 ELSE 0 END) as helpful,
                SUM(CASE WHEN feedback_type = 'not_helpful' THEN 1 ELSE 0 END) as not_helpful
            FROM $table
            WHERE created_at >= %s
                AND created_at <= %s
                AND response_length_bucket IS NOT NULL
            GROUP BY response_length_bucket
            ORDER BY FIELD(response_length_bucket, 'short', 'medium', 'long', 'very_long')",
            $range['start'],
            $range['end']
        ));

        $labels = array();
        $helpful_data = array();
        $not_helpful_data = array();

        foreach ($results as $row) {
            $labels[] = ucfirst(str_replace('_', ' ', $row->response_length_bucket));
            $helpful_data[] = (int) $row->helpful;
            $not_helpful_data[] = (int) $row->not_helpful;
        }

        return array(
            'labels' => $labels,
            'datasets' => array(
                array(
                    'label' => 'Helpful',
                    'data' => $helpful_data,
                    'backgroundColor' => '#10b981',
                ),
                array(
                    'label' => 'Not Helpful',
                    'data' => $not_helpful_data,
                    'backgroundColor' => '#ef4444',
                ),
            ),
            'helper' => 'Optimal length bucket has highest helpful ratio.',
        );
    }

    /**
     * Chart: Provider Usage Mix
     */
    private static function get_provider_usage($range) {
        global $wpdb;

        $table = $wpdb->prefix . self::TABLE_EVENTS;

        $results = $wpdb->get_results($wpdb->prepare(
            "SELECT provider, COUNT(*) as count
            FROM $table
            WHERE created_at >= %s
                AND created_at <= %s
                AND event_type = 'turn'
                AND provider IS NOT NULL
                AND provider != ''
            GROUP BY provider
            ORDER BY count DESC",
            $range['start'],
            $range['end']
        ));

        $labels = array();
        $data = array();

        foreach ($results as $row) {
            $labels[] = ucfirst($row->provider);
            $data[] = (int) $row->count;
        }

        return array(
            'labels' => $labels,
            'datasets' => array(
                array(
                    'data' => $data,
                    'backgroundColor' => array('#6366f1', '#10b981', '#f59e0b'),
                ),
            ),
            'helper' => 'Fallback provider spike indicates primary provider issues.',
        );
    }

    /**
     * Chart: Rate Limit Events
     */
    private static function get_rate_limit_events($range) {
        global $wpdb;

        $table = $wpdb->prefix . self::TABLE_RATE_LIMITS;

        $results = $wpdb->get_results($wpdb->prepare(
            "SELECT
                DATE_FORMAT(created_at, '%%Y-%%m-%%d') as bucket,
                SUM(CASE WHEN event_type = 'warning' THEN 1 ELSE 0 END) as warnings,
                SUM(CASE WHEN event_type = 'blocked' THEN 1 ELSE 0 END) as blocked
            FROM $table
            WHERE created_at >= %s AND created_at <= %s
            GROUP BY bucket
            ORDER BY bucket ASC",
            $range['start'],
            $range['end']
        ));

        $labels = array();
        $warning_data = array();
        $blocked_data = array();

        foreach ($results as $row) {
            $labels[] = $row->bucket;
            $warning_data[] = (int) $row->warnings;
            $blocked_data[] = (int) $row->blocked;
        }

        return array(
            'labels' => $labels,
            'datasets' => array(
                array(
                    'label' => 'Warnings',
                    'data' => $warning_data,
                    'borderColor' => '#f59e0b',
                    'fill' => false,
                ),
                array(
                    'label' => 'Blocked',
                    'data' => $blocked_data,
                    'borderColor' => '#ef4444',
                    'fill' => false,
                ),
            ),
            'helper' => 'Frequent blocking = increase rate limits or add caching.',
        );
    }

    /**
     * Get overview stats for dashboard
     */
    public static function get_overview_stats() {
        global $wpdb;

        $events_table = $wpdb->prefix . self::TABLE_EVENTS;
        $today_start = date('Y-m-d 00:00:00');
        $today_end = date('Y-m-d 23:59:59');

        // Conversations today
        $conversations_today = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(DISTINCT session_hash) FROM $events_table
            WHERE created_at >= %s AND created_at <= %s",
            $today_start, $today_end
        ));

        // Average response time (last 24h)
        $avg_response_time = $wpdb->get_var($wpdb->prepare(
            "SELECT AVG(response_time_ms) FROM $events_table
            WHERE created_at >= %s AND response_time_ms IS NOT NULL",
            date('Y-m-d H:i:s', strtotime('-24 hours'))
        ));

        // Error rate (last 24h)
        $error_stats = $wpdb->get_row($wpdb->prepare(
            "SELECT
                SUM(is_error) as errors,
                COUNT(*) as total
            FROM $events_table
            WHERE created_at >= %s AND event_type = 'turn'",
            date('Y-m-d H:i:s', strtotime('-24 hours'))
        ));

        $error_rate = ($error_stats->total ?? 0) > 0
            ? round(($error_stats->errors / $error_stats->total) * 100, 1)
            : 0;

        // Last successful response
        $last_success = $wpdb->get_var(
            "SELECT created_at FROM $events_table
            WHERE is_error = 0 AND event_type = 'turn'
            ORDER BY created_at DESC LIMIT 1"
        );

        return array(
            'conversations_today' => (int) $conversations_today ?: 0,
            'avg_response_time' => round($avg_response_time ?: 0),
            'error_rate' => $error_rate,
            'last_success' => $last_success,
        );
    }

    /**
     * Aggregate hourly metrics (cron job)
     */
    public static function aggregate_hourly_metrics() {
        // This would aggregate raw events into the metrics table
        // For now, we rely on direct queries to events table
    }

    /**
     * Cleanup old data based on retention policy
     */
    public static function cleanup_old_data() {
        global $wpdb;

        $settings = class_exists('BFLUXCO_AI_Chat_Settings')
            ? BFLUXCO_AI_Chat_Settings::get_system()
            : array('data_retention_days' => 30);

        $retention_days = $settings['data_retention_days'] ?? 30;
        $cutoff = date('Y-m-d H:i:s', strtotime("-{$retention_days} days"));

        // Clean events
        $wpdb->query($wpdb->prepare(
            "DELETE FROM " . $wpdb->prefix . self::TABLE_EVENTS . " WHERE created_at < %s",
            $cutoff
        ));

        // Clean feedback
        $wpdb->query($wpdb->prepare(
            "DELETE FROM " . $wpdb->prefix . self::TABLE_FEEDBACK . " WHERE created_at < %s",
            $cutoff
        ));

        // Clean rate limit events
        $wpdb->query($wpdb->prepare(
            "DELETE FROM " . $wpdb->prefix . self::TABLE_RATE_LIMITS . " WHERE created_at < %s",
            $cutoff
        ));

        // Clean metrics rollups
        $wpdb->query($wpdb->prepare(
            "DELETE FROM " . $wpdb->prefix . self::TABLE_METRICS . " WHERE created_at < %s",
            $cutoff
        ));
    }
}

// Initialize
BFLUXCO_AI_Chat_Metrics::init();
