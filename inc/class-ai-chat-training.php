<?php
/**
 * AI Chat Training
 *
 * Handles human-curated training examples for AI improvement.
 * No automatic learning from user conversations.
 *
 * @package BFLUXCO
 */

if (!defined('ABSPATH')) {
    exit;
}

class BFLUXCO_AI_Chat_Training {

    /**
     * Table name (without prefix)
     */
    const TABLE_TRAINING = 'bfluxco_ai_training';

    /**
     * Training categories
     */
    public static function get_categories() {
        return array(
            'greeting' => __('Greeting', 'bfluxco'),
            'services' => __('Services', 'bfluxco'),
            'pricing' => __('Pricing', 'bfluxco'),
            'case_studies' => __('Case Studies', 'bfluxco'),
            'company_info' => __('Company Info', 'bfluxco'),
            'contact' => __('Contact', 'bfluxco'),
            'off_topic' => __('Off Topic', 'bfluxco'),
            'clarification' => __('Clarification', 'bfluxco'),
            'handoff' => __('Handoff', 'bfluxco'),
        );
    }

    /**
     * Create training table
     */
    public static function create_table() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();
        $table = $wpdb->prefix . self::TABLE_TRAINING;

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        $sql = "CREATE TABLE $table (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            input_text TEXT NOT NULL,
            expected_output TEXT NOT NULL,
            category VARCHAR(50),
            tags VARCHAR(255),
            status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
            added_by BIGINT UNSIGNED,
            reviewed_by BIGINT UNSIGNED,
            notes TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            reviewed_at DATETIME,
            INDEX idx_status (status),
            INDEX idx_category (category)
        ) $charset_collate;";

        dbDelta($sql);
    }

    /**
     * Add training example
     */
    public static function add_example($input, $output, $category = '', $tags = '') {
        global $wpdb;

        $table = $wpdb->prefix . self::TABLE_TRAINING;

        $result = $wpdb->insert($table, array(
            'input_text' => wp_kses_post($input),
            'expected_output' => wp_kses_post($output),
            'category' => sanitize_text_field($category),
            'tags' => sanitize_text_field($tags),
            'status' => 'pending',
            'added_by' => get_current_user_id(),
            'created_at' => current_time('mysql'),
        ));

        if ($result === false) {
            return new WP_Error('db_error', 'Failed to add training example');
        }

        return $wpdb->insert_id;
    }

    /**
     * Update training example
     */
    public static function update_example($id, $data) {
        global $wpdb;

        $table = $wpdb->prefix . self::TABLE_TRAINING;

        $update_data = array();

        if (isset($data['input_text'])) {
            $update_data['input_text'] = wp_kses_post($data['input_text']);
        }
        if (isset($data['expected_output'])) {
            $update_data['expected_output'] = wp_kses_post($data['expected_output']);
        }
        if (isset($data['category'])) {
            $update_data['category'] = sanitize_text_field($data['category']);
        }
        if (isset($data['tags'])) {
            $update_data['tags'] = sanitize_text_field($data['tags']);
        }
        if (isset($data['notes'])) {
            $update_data['notes'] = wp_kses_post($data['notes']);
        }

        if (empty($update_data)) {
            return false;
        }

        return $wpdb->update($table, $update_data, array('id' => absint($id)));
    }

    /**
     * Approve training example
     */
    public static function approve_example($id) {
        global $wpdb;

        $table = $wpdb->prefix . self::TABLE_TRAINING;

        return $wpdb->update($table, array(
            'status' => 'approved',
            'reviewed_by' => get_current_user_id(),
            'reviewed_at' => current_time('mysql'),
        ), array('id' => absint($id)));
    }

    /**
     * Reject training example
     */
    public static function reject_example($id, $notes = '') {
        global $wpdb;

        $table = $wpdb->prefix . self::TABLE_TRAINING;

        return $wpdb->update($table, array(
            'status' => 'rejected',
            'reviewed_by' => get_current_user_id(),
            'reviewed_at' => current_time('mysql'),
            'notes' => wp_kses_post($notes),
        ), array('id' => absint($id)));
    }

    /**
     * Delete training example
     */
    public static function delete_example($id) {
        global $wpdb;

        $table = $wpdb->prefix . self::TABLE_TRAINING;

        return $wpdb->delete($table, array('id' => absint($id)));
    }

    /**
     * Get training examples
     */
    public static function get_examples($args = array()) {
        global $wpdb;

        $table = $wpdb->prefix . self::TABLE_TRAINING;

        $defaults = array(
            'status' => '',
            'category' => '',
            'limit' => 50,
            'offset' => 0,
            'orderby' => 'created_at',
            'order' => 'DESC',
        );

        $args = wp_parse_args($args, $defaults);

        $where = array('1=1');
        $params = array();

        if (!empty($args['status'])) {
            $where[] = 'status = %s';
            $params[] = $args['status'];
        }

        if (!empty($args['category'])) {
            $where[] = 'category = %s';
            $params[] = $args['category'];
        }

        $where_sql = implode(' AND ', $where);
        $orderby = in_array($args['orderby'], array('created_at', 'reviewed_at', 'category')) ? $args['orderby'] : 'created_at';
        $order = strtoupper($args['order']) === 'ASC' ? 'ASC' : 'DESC';

        $sql = "SELECT * FROM $table WHERE $where_sql ORDER BY $orderby $order LIMIT %d OFFSET %d";
        $params[] = $args['limit'];
        $params[] = $args['offset'];

        return $wpdb->get_results($wpdb->prepare($sql, $params));
    }

    /**
     * Get single training example
     */
    public static function get_example($id) {
        global $wpdb;

        $table = $wpdb->prefix . self::TABLE_TRAINING;

        return $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM $table WHERE id = %d",
            absint($id)
        ));
    }

    /**
     * Count examples by status
     */
    public static function get_counts() {
        global $wpdb;

        $table = $wpdb->prefix . self::TABLE_TRAINING;

        $results = $wpdb->get_results(
            "SELECT status, COUNT(*) as count FROM $table GROUP BY status"
        );

        $counts = array(
            'pending' => 0,
            'approved' => 0,
            'rejected' => 0,
            'total' => 0,
        );

        foreach ($results as $row) {
            $counts[$row->status] = (int) $row->count;
            $counts['total'] += (int) $row->count;
        }

        return $counts;
    }

    /**
     * Count examples by category
     */
    public static function get_category_counts() {
        global $wpdb;

        $table = $wpdb->prefix . self::TABLE_TRAINING;

        $results = $wpdb->get_results(
            "SELECT category, COUNT(*) as count FROM $table WHERE status = 'approved' GROUP BY category"
        );

        $counts = array();
        foreach ($results as $row) {
            $counts[$row->category] = (int) $row->count;
        }

        return $counts;
    }

    /**
     * Export approved examples as JSON
     */
    public static function export_approved() {
        global $wpdb;

        $table = $wpdb->prefix . self::TABLE_TRAINING;

        $examples = $wpdb->get_results(
            "SELECT input_text, expected_output, category, tags FROM $table WHERE status = 'approved' ORDER BY category, created_at"
        );

        $export = array(
            'version' => '1.0',
            'exported_at' => current_time('c'),
            'examples' => array(),
        );

        foreach ($examples as $example) {
            $export['examples'][] = array(
                'input' => $example->input_text,
                'output' => $example->expected_output,
                'category' => $example->category,
                'tags' => $example->tags ? explode(',', $example->tags) : array(),
            );
        }

        return $export;
    }

    /**
     * Import examples from JSON
     */
    public static function import_examples($json_data) {
        $data = json_decode($json_data, true);

        if (!$data || !isset($data['examples'])) {
            return new WP_Error('invalid_json', 'Invalid JSON format');
        }

        $imported = 0;
        $errors = 0;

        foreach ($data['examples'] as $example) {
            if (empty($example['input']) || empty($example['output'])) {
                $errors++;
                continue;
            }

            $result = self::add_example(
                $example['input'],
                $example['output'],
                $example['category'] ?? '',
                is_array($example['tags'] ?? null) ? implode(',', $example['tags']) : ''
            );

            if (!is_wp_error($result)) {
                $imported++;
            } else {
                $errors++;
            }
        }

        return array(
            'imported' => $imported,
            'errors' => $errors,
        );
    }

    /**
     * Bulk approve examples
     */
    public static function bulk_approve($ids) {
        global $wpdb;

        if (empty($ids) || !is_array($ids)) {
            return 0;
        }

        $table = $wpdb->prefix . self::TABLE_TRAINING;
        $ids = array_map('absint', $ids);
        $placeholders = implode(',', array_fill(0, count($ids), '%d'));

        return $wpdb->query($wpdb->prepare(
            "UPDATE $table SET status = 'approved', reviewed_by = %d, reviewed_at = %s WHERE id IN ($placeholders)",
            array_merge(
                array(get_current_user_id(), current_time('mysql')),
                $ids
            )
        ));
    }

    /**
     * Bulk reject examples
     */
    public static function bulk_reject($ids) {
        global $wpdb;

        if (empty($ids) || !is_array($ids)) {
            return 0;
        }

        $table = $wpdb->prefix . self::TABLE_TRAINING;
        $ids = array_map('absint', $ids);
        $placeholders = implode(',', array_fill(0, count($ids), '%d'));

        return $wpdb->query($wpdb->prepare(
            "UPDATE $table SET status = 'rejected', reviewed_by = %d, reviewed_at = %s WHERE id IN ($placeholders)",
            array_merge(
                array(get_current_user_id(), current_time('mysql')),
                $ids
            )
        ));
    }

    /**
     * Bulk delete examples
     */
    public static function bulk_delete($ids) {
        global $wpdb;

        if (empty($ids) || !is_array($ids)) {
            return 0;
        }

        $table = $wpdb->prefix . self::TABLE_TRAINING;
        $ids = array_map('absint', $ids);
        $placeholders = implode(',', array_fill(0, count($ids), '%d'));

        return $wpdb->query($wpdb->prepare(
            "DELETE FROM $table WHERE id IN ($placeholders)",
            $ids
        ));
    }
}
