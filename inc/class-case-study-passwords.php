<?php
/**
 * Case Study PW Manager
 *
 * Handles automatic password rotation and admin interface for case study passwords.
 *
 * @package BFLUXCO
 */

if (!defined('ABSPATH')) {
    exit;
}

class BFLUXCO_Case_Study_Passwords {

    /**
     * Option name for storing password data
     */
    const OPTION_NAME = 'bfluxco_case_study_passwords';

    /**
     * Option name for rotation settings
     */
    const SETTINGS_OPTION = 'bfluxco_password_rotation_settings';

    /**
     * Option name for history log
     */
    const HISTORY_OPTION = 'bfluxco_client_access_history';

    /**
     * Initialize the class
     */
    public static function init() {
        // Admin menu
        add_action('admin_menu', array(__CLASS__, 'add_admin_menu'));

        // Register settings
        add_action('admin_init', array(__CLASS__, 'register_settings'));

        // Schedule cron on theme activation
        add_action('after_switch_theme', array(__CLASS__, 'schedule_rotation'));

        // Cron hook
        add_action('bfluxco_rotate_passwords', array(__CLASS__, 'rotate_passwords'));

        // Handle manual actions
        add_action('admin_init', array(__CLASS__, 'handle_admin_actions'));

        // Enqueue admin styles
        add_action('admin_enqueue_scripts', array(__CLASS__, 'admin_styles'));

        // Menu icon styles (on all admin pages)
        add_action('admin_head', array(__CLASS__, 'menu_icon_styles'));

        // AJAX handler for saving email template
        add_action('wp_ajax_bfluxco_save_email_template', array(__CLASS__, 'ajax_save_email_template'));

        // AJAX handler for clearing history
        add_action('wp_ajax_bfluxco_clear_history', array(__CLASS__, 'ajax_clear_history'));

        // AJAX handler for saving client custom message
        add_action('wp_ajax_bfluxco_save_client_message', array(__CLASS__, 'ajax_save_client_message'));
    }

    /**
     * AJAX: Save email template
     */
    public static function ajax_save_email_template() {
        if (!current_user_can('manage_options')) {
            wp_send_json_error(__('Permission denied.', 'bfluxco'));
        }

        if (!wp_verify_nonce($_POST['nonce'], 'bfluxco_save_template')) {
            wp_send_json_error(__('Security check failed.', 'bfluxco'));
        }

        $template = isset($_POST['template']) ? wp_kses_post($_POST['template']) : '';

        if (empty(trim($template))) {
            wp_send_json_error(__('Template cannot be empty.', 'bfluxco'));
        }

        $settings = self::get_settings();
        $settings['email_template'] = $template;
        update_option(self::SETTINGS_OPTION, $settings);

        wp_send_json_success();
    }

    /**
     * AJAX: Clear history
     */
    public static function ajax_clear_history() {
        if (!current_user_can('manage_options')) {
            wp_send_json_error(__('Permission denied.', 'bfluxco'));
        }

        if (!wp_verify_nonce($_POST['nonce'], 'bfluxco_clear_history')) {
            wp_send_json_error(__('Security check failed.', 'bfluxco'));
        }

        self::clear_history();

        wp_send_json_success();
    }

    /**
     * AJAX: Save client custom message
     */
    public static function ajax_save_client_message() {
        if (!current_user_can('manage_options')) {
            wp_send_json_error(__('Permission denied.', 'bfluxco'));
        }

        if (!wp_verify_nonce($_POST['nonce'], 'bfluxco_save_client_message')) {
            wp_send_json_error(__('Security check failed.', 'bfluxco'));
        }

        $client_id = isset($_POST['client_id']) ? sanitize_text_field($_POST['client_id']) : '';
        $message_type = isset($_POST['message_type']) ? sanitize_text_field($_POST['message_type']) : 'default';
        $custom_message = isset($_POST['custom_message']) ? wp_kses_post($_POST['custom_message']) : '';

        if (empty($client_id)) {
            wp_send_json_error(__('Client ID is required.', 'bfluxco'));
        }

        // Validate message type
        if (!in_array($message_type, array('default', 'custom'))) {
            $message_type = 'default';
        }

        // If custom type, require message content
        if ($message_type === 'custom') {
            $custom_message = trim($custom_message);
            if (empty($custom_message)) {
                wp_send_json_error(__('Custom message cannot be empty.', 'bfluxco'));
            }
        } else {
            // Default type - clear any custom message
            $custom_message = '';
        }

        // Update client via Client Access class
        if (!class_exists('BFLUXCO_Client_Access')) {
            wp_send_json_error(__('Client Access class not found.', 'bfluxco'));
        }

        $updates = array(
            'message_type' => $message_type,
            'custom_message' => $message_type === 'custom' ? $custom_message : '',
        );

        $result = BFLUXCO_Client_Access::update_client($client_id, $updates);

        if (is_wp_error($result)) {
            wp_send_json_error($result->get_error_message());
        }

        // Log the event
        $client = BFLUXCO_Client_Access::get_client($client_id);
        if ($client) {
            $action_detail = $message_type === 'custom'
                ? __('Set custom message', 'bfluxco')
                : __('Reverted to default template', 'bfluxco');
            self::log_event('message_updated', $client['email'], $action_detail);
        }

        wp_send_json_success(array(
            'message_type' => $message_type,
            'message' => __('Message template saved successfully.', 'bfluxco'),
        ));
    }

    /**
     * Add admin menu page
     */
    public static function add_admin_menu() {
        add_menu_page(
            __('Password Manager', 'bfluxco'),
            __('PW Manager', 'bfluxco'),
            'manage_options',
            'case-study-passwords',
            array(__CLASS__, 'render_admin_page'),
            self::get_menu_icon(),
            2
        );
    }

    /**
     * Get menu icon URL
     */
    public static function get_menu_icon() {
        return get_template_directory_uri() . '/assets/images/pw-manager-icon.ico';
    }

    /**
     * Menu icon styles for admin sidebar
     */
    public static function menu_icon_styles() {
        echo '<style>
            #adminmenu .toplevel_page_case-study-passwords .wp-menu-image img {
                width: 20px;
                height: 20px;
                padding: 6px 0 0;
                filter: brightness(0) invert(0.7);
            }
            #adminmenu .toplevel_page_case-study-passwords:hover .wp-menu-image img,
            #adminmenu .toplevel_page_case-study-passwords:focus .wp-menu-image img {
                filter: brightness(0) saturate(100%) invert(58%) sepia(72%) saturate(2547%) hue-rotate(165deg) brightness(96%) contrast(101%);
            }
            #adminmenu .toplevel_page_case-study-passwords.current .wp-menu-image img,
            #adminmenu .toplevel_page_case-study-passwords.wp-has-current-submenu .wp-menu-image img {
                filter: brightness(0) invert(1);
            }
        </style>';
    }

    /**
     * Register settings
     */
    public static function register_settings() {
        register_setting(self::SETTINGS_OPTION, self::SETTINGS_OPTION, array(
            'sanitize_callback' => array(__CLASS__, 'sanitize_settings'),
        ));
    }

    /**
     * Default email template
     */
    public static function get_default_email_template() {
        return "Hi [CLIENT NAME],

You can use your email and password below to access protected case studies.

Password: [PASSWORD]

Your access will end on [EXPIRY DATE]. Please view at your convenience before then.

Best regards,
Ray";
    }

    /**
     * Log a history event
     */
    public static function log_event($action, $client_email, $details = '') {
        $history = get_option(self::HISTORY_OPTION, array());

        // Add new entry at the beginning (use UTC timestamp for proper timezone conversion)
        array_unshift($history, array(
            'timestamp' => time(),
            'action' => $action,
            'client_email' => $client_email,
            'details' => $details,
            'user_id' => get_current_user_id(),
        ));

        // Keep only last 500 entries
        $history = array_slice($history, 0, 500);

        update_option(self::HISTORY_OPTION, $history);
    }

    /**
     * Get history log
     */
    public static function get_history($limit = 100) {
        $history = get_option(self::HISTORY_OPTION, array());
        return array_slice($history, 0, $limit);
    }

    /**
     * Clear history log
     */
    public static function clear_history() {
        return delete_option(self::HISTORY_OPTION);
    }

    /**
     * Sanitize settings
     */
    public static function sanitize_settings($input) {
        $sanitized = array();
        $sanitized['rotation_days'] = isset($input['rotation_days']) ? absint($input['rotation_days']) : 30;
        $sanitized['password_length'] = isset($input['password_length']) ? min(max(absint($input['password_length']), 8), 32) : 12;
        $sanitized['email_template'] = isset($input['email_template']) ? wp_kses_post($input['email_template']) : self::get_default_email_template();
        return $sanitized;
    }

    /**
     * Get settings
     */
    public static function get_settings() {
        $defaults = array(
            'rotation_days' => 30,
            'password_length' => 12,
            'email_template' => self::get_default_email_template(),
        );
        return wp_parse_args(get_option(self::SETTINGS_OPTION, array()), $defaults);
    }

    /**
     * Generate a secure random password
     */
    public static function generate_password($length = 12) {
        $chars = 'abcdefghjkmnpqrstuvwxyz23456789';
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[random_int(0, strlen($chars) - 1)];
        }
        return $password;
    }

    /**
     * Get all protected case studies
     */
    public static function get_protected_case_studies() {
        return get_posts(array(
            'post_type' => 'case_study',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'has_password' => true,
        ));
    }

    /**
     * Encrypt a password before storage.
     *
     * @param string $plain The plaintext password.
     * @return string Encrypted password, or original if encryption fails.
     */
    private static function encrypt_password( $plain ) {
        if ( ! class_exists( 'BFLUXCO_Crypto_Utils' ) ) {
            return $plain;
        }
        $encrypted = BFLUXCO_Crypto_Utils::encrypt( $plain, 'case_study_pw' );
        return ( false !== $encrypted ) ? $encrypted : $plain;
    }

    /**
     * Decrypt a stored password.
     *
     * Falls back to returning the raw value if decryption fails,
     * which handles legacy plaintext passwords gracefully.
     *
     * @param string $stored The stored (possibly encrypted) password.
     * @return string The plaintext password.
     */
    private static function decrypt_password( $stored ) {
        if ( ! class_exists( 'BFLUXCO_Crypto_Utils' ) ) {
            return $stored;
        }
        $decrypted = BFLUXCO_Crypto_Utils::decrypt( $stored, 'case_study_pw', false );
        return ( false !== $decrypted ) ? $decrypted : $stored;
    }

    /**
     * Get password data for all case studies
     *
     * Returns data with passwords decrypted for use.
     */
    public static function get_password_data() {
        $data = get_option(self::OPTION_NAME, array());
        foreach ( $data as $post_id => &$entry ) {
            if ( isset( $entry['password'] ) ) {
                $entry['password'] = self::decrypt_password( $entry['password'] );
            }
        }
        unset( $entry );
        return $data;
    }

    /**
     * Get raw password data without decryption.
     *
     * Used internally when we need to update the stored data
     * without a decrypt-then-re-encrypt round-trip.
     */
    private static function get_raw_password_data() {
        return get_option(self::OPTION_NAME, array());
    }

    /**
     * Update password for a case study
     */
    public static function update_case_study_password($post_id, $new_password = null) {
        $settings = self::get_settings();

        if ($new_password === null) {
            $new_password = self::generate_password($settings['password_length']);
        }

        // Update the WordPress post password
        wp_update_post(array(
            'ID' => $post_id,
            'post_password' => $new_password,
        ));

        // Store metadata about the password (encrypted)
        $password_data = self::get_raw_password_data();
        $password_data[$post_id] = array(
            'password' => self::encrypt_password($new_password),
            'created' => current_time('timestamp'),
            'expires' => current_time('timestamp') + ($settings['rotation_days'] * DAY_IN_SECONDS),
        );
        update_option(self::OPTION_NAME, $password_data);

        return $new_password;
    }

    /**
     * Rotate all passwords
     */
    public static function rotate_passwords() {
        $case_studies = self::get_protected_case_studies();
        $settings = self::get_settings();
        $password_data = self::get_password_data();
        $now = current_time('timestamp');

        foreach ($case_studies as $case_study) {
            $data = isset($password_data[$case_study->ID]) ? $password_data[$case_study->ID] : null;

            // Rotate if no data exists or if expired
            if (!$data || $data['expires'] <= $now) {
                self::update_case_study_password($case_study->ID);
            }
        }
    }

    /**
     * Schedule the cron job
     */
    public static function schedule_rotation() {
        if (!wp_next_scheduled('bfluxco_rotate_passwords')) {
            wp_schedule_event(time(), 'daily', 'bfluxco_rotate_passwords');
        }
    }

    /**
     * Handle admin actions (regenerate, copy, etc.)
     */
    public static function handle_admin_actions() {
        if (!isset($_GET['page']) || $_GET['page'] !== 'case-study-passwords') {
            return;
        }

        if (!current_user_can('manage_options')) {
            return;
        }

        // Regenerate single password
        if (isset($_GET['regenerate']) && isset($_GET['_wpnonce'])) {
            if (wp_verify_nonce($_GET['_wpnonce'], 'regenerate_password')) {
                $post_id = absint($_GET['regenerate']);
                self::update_case_study_password($post_id);
                wp_redirect(admin_url('admin.php?page=case-study-passwords&message=regenerated'));
                exit;
            }
        }

        // Regenerate all passwords
        if (isset($_GET['regenerate_all']) && isset($_GET['_wpnonce'])) {
            if (wp_verify_nonce($_GET['_wpnonce'], 'regenerate_all_passwords')) {
                $case_studies = self::get_protected_case_studies();
                foreach ($case_studies as $case_study) {
                    self::update_case_study_password($case_study->ID);
                }
                wp_redirect(admin_url('admin.php?page=case-study-passwords&message=all_regenerated'));
                exit;
            }
        }

        // Initialize missing passwords
        if (isset($_GET['initialize']) && isset($_GET['_wpnonce'])) {
            if (wp_verify_nonce($_GET['_wpnonce'], 'initialize_passwords')) {
                self::initialize_existing_passwords();
                wp_redirect(admin_url('admin.php?page=case-study-passwords&message=initialized'));
                exit;
            }
        }

        // Client actions (using BFLUXCO_Client_Access class)
        if (class_exists('BFLUXCO_Client_Access')) {
            // Regenerate client password
            if (isset($_GET['regenerate_client']) && isset($_GET['_wpnonce'])) {
                $client_id = sanitize_text_field($_GET['regenerate_client']);
                if (wp_verify_nonce($_GET['_wpnonce'], 'regenerate_client_' . $client_id)) {
                    $client = BFLUXCO_Client_Access::get_client($client_id);
                    $result = BFLUXCO_Client_Access::regenerate_password($client_id);
                    if ($result) {
                        if ($client) {
                            self::log_event('password_regenerated', $client['email']);
                        }
                        wp_redirect(admin_url('admin.php?page=case-study-passwords&message=client_regenerated'));
                    } else {
                        wp_redirect(admin_url('admin.php?page=case-study-passwords&message=client_error'));
                    }
                    exit;
                }
            }

            // Revoke client
            if (isset($_GET['revoke_client']) && isset($_GET['_wpnonce'])) {
                $client_id = sanitize_text_field($_GET['revoke_client']);
                if (wp_verify_nonce($_GET['_wpnonce'], 'revoke_client_' . $client_id)) {
                    $client = BFLUXCO_Client_Access::get_client($client_id);
                    $result = BFLUXCO_Client_Access::revoke_client($client_id);
                    if ($result) {
                        if ($client) {
                            self::log_event('client_revoked', $client['email']);
                        }
                        wp_redirect(admin_url('admin.php?page=case-study-passwords&message=client_revoked'));
                    } else {
                        wp_redirect(admin_url('admin.php?page=case-study-passwords&message=client_error'));
                    }
                    exit;
                }
            }

            // Delete client
            if (isset($_GET['delete_client']) && isset($_GET['_wpnonce'])) {
                $client_id = sanitize_text_field($_GET['delete_client']);
                if (wp_verify_nonce($_GET['_wpnonce'], 'delete_client_' . $client_id)) {
                    $client = BFLUXCO_Client_Access::get_client($client_id);
                    $client_email = $client ? $client['email'] : 'Unknown';
                    $result = BFLUXCO_Client_Access::delete_client($client_id);
                    if ($result) {
                        self::log_event('client_deleted', $client_email);
                        wp_redirect(admin_url('admin.php?page=case-study-passwords&message=client_deleted'));
                    } else {
                        wp_redirect(admin_url('admin.php?page=case-study-passwords&message=client_error'));
                    }
                    exit;
                }
            }
        }
    }

    /**
     * Initialize tracking for existing password-protected posts
     */
    public static function initialize_existing_passwords() {
        $case_studies = self::get_protected_case_studies();
        $password_data = self::get_raw_password_data();
        $settings = self::get_settings();

        foreach ($case_studies as $case_study) {
            if (!isset($password_data[$case_study->ID]) && !empty($case_study->post_password)) {
                $password_data[$case_study->ID] = array(
                    'password' => self::encrypt_password($case_study->post_password),
                    'created' => current_time('timestamp'),
                    'expires' => current_time('timestamp') + ($settings['rotation_days'] * DAY_IN_SECONDS),
                );
            }
        }

        update_option(self::OPTION_NAME, $password_data);
    }

    /**
     * Admin styles
     *
     * Delegates to BFLUXCO_Password_Admin for the actual styles output.
     *
     * @param string $hook The current admin page hook.
     */
    public static function admin_styles( $hook ) {
        if ( strpos( $hook, 'case-study-passwords' ) === false ) {
            return;
        }

        // Delegate to the admin UI class
        if ( class_exists( 'BFLUXCO_Password_Admin' ) ) {
            BFLUXCO_Password_Admin::admin_styles();
        }
    }

    /**
     * Render admin page
     *
     * Delegates to BFLUXCO_Password_Admin for the actual rendering.
     */
    public static function render_admin_page() {
        // Delegate to the admin UI class
        if ( class_exists( 'BFLUXCO_Password_Admin' ) ) {
            BFLUXCO_Password_Admin::render_admin_page();
        }
    }
}

// Initialize
BFLUXCO_Case_Study_Passwords::init();
