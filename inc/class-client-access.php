<?php
/**
 * Client Access Manager
 *
 * Manages client-based access to protected case studies.
 * Each client (identified by email) has a unique password that grants
 * access to specific case studies assigned to them.
 *
 * @package BFLUXCO
 */

if (!defined('ABSPATH')) {
    exit;
}

class BFLUXCO_Client_Access {

    /**
     * Option name for storing client data
     */
    const OPTION_NAME = 'bfluxco_client_access';

    /**
     * Cookie name for client sessions
     */
    const COOKIE_NAME = 'bfluxco_client_session';

    /**
     * Initialize the class
     */
    public static function init() {
        // Admin menu - disabled, functionality moved to PW Manager
        // add_action('admin_menu', array(__CLASS__, 'add_admin_menu'));

        // Register AJAX handlers
        add_action('wp_ajax_bfluxco_add_client', array(__CLASS__, 'ajax_add_client'));
        add_action('wp_ajax_bfluxco_delete_client', array(__CLASS__, 'ajax_delete_client'));
        add_action('wp_ajax_bfluxco_regenerate_client_password', array(__CLASS__, 'ajax_regenerate_password'));
        add_action('wp_ajax_bfluxco_revoke_client', array(__CLASS__, 'ajax_revoke_client'));

        // Frontend login (works for logged out users too)
        add_action('wp_ajax_bfluxco_client_login', array(__CLASS__, 'ajax_client_login'));
        add_action('wp_ajax_nopriv_bfluxco_client_login', array(__CLASS__, 'ajax_client_login'));

        // Enqueue admin styles and scripts
        add_action('admin_enqueue_scripts', array(__CLASS__, 'admin_assets'));

        // Frontend: Check session and override password requirement
        add_action('template_redirect', array(__CLASS__, 'check_client_session'), 5);

        // Override password form
        add_filter('the_password_form', array(__CLASS__, 'custom_password_form'), 20);
    }

    // =========================================================================
    // DATA MANAGEMENT
    // =========================================================================

    /**
     * Cache key for transient
     */
    const CACHE_KEY = 'bfluxco_client_access_cache';

    /**
     * Cache duration in seconds (5 minutes)
     */
    const CACHE_DURATION = 300;

    /**
     * Get all data (clients and settings) with transient caching
     */
    public static function get_data() {
        // Try to get from cache first
        $cached = get_transient(self::CACHE_KEY);
        if ($cached !== false) {
            return $cached;
        }

        $defaults = array(
            'clients' => array(),
            'settings' => array(
                'default_expiry_days' => 30,
                'password_length' => 12,
                'session_duration' => 86400, // 24 hours
                'max_login_attempts' => 5,
                'lockout_duration' => 900, // 15 minutes
            ),
        );
        $data = wp_parse_args(get_option(self::OPTION_NAME, array()), $defaults);

        // Cache the result
        set_transient(self::CACHE_KEY, $data, self::CACHE_DURATION);

        return $data;
    }

    /**
     * Save all data and invalidate cache
     */
    public static function save_data($data) {
        // Invalidate cache when data changes
        delete_transient(self::CACHE_KEY);
        return update_option(self::OPTION_NAME, $data);
    }

    /**
     * Get settings
     */
    public static function get_settings() {
        $data = self::get_data();
        return $data['settings'];
    }

    /**
     * Get all clients
     */
    public static function get_clients() {
        $data = self::get_data();
        return $data['clients'];
    }

    /**
     * Get a single client by ID
     */
    public static function get_client($client_id) {
        $clients = self::get_clients();
        return isset($clients[$client_id]) ? $clients[$client_id] : null;
    }

    /**
     * Get client by email
     */
    public static function get_client_by_email($email) {
        $clients = self::get_clients();
        foreach ($clients as $id => $client) {
            if (strtolower($client['email']) === strtolower($email)) {
                return array_merge($client, array('id' => $id));
            }
        }
        return null;
    }

    /**
     * Generate unique client ID
     */
    public static function generate_client_id() {
        return wp_generate_uuid4();
    }

    /**
     * Generate secure password
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
     * Add a new client
     */
    public static function add_client($email, $case_study_ids, $expiry_days = null, $name = '', $company = '') {
        $data = self::get_data();
        $settings = $data['settings'];

        if ($expiry_days === null) {
            $expiry_days = $settings['default_expiry_days'];
        }

        // Check if email already exists
        if (self::get_client_by_email($email)) {
            return new WP_Error('email_exists', __('A client with this email already exists.', 'bfluxco'));
        }

        // Generate password
        $plain_password = self::generate_password($settings['password_length']);

        // Create client record
        $client_id = self::generate_client_id();
        $data['clients'][$client_id] = array(
            'name' => sanitize_text_field($name),
            'email' => sanitize_email($email),
            'company' => sanitize_text_field($company),
            'password_hash' => password_hash($plain_password, PASSWORD_BCRYPT, array('cost' => 12)),
            'created_at' => current_time('timestamp'),
            'expires_at' => current_time('timestamp') + ($expiry_days * DAY_IN_SECONDS),
            'case_studies' => array_map('absint', $case_study_ids),
            'last_access' => null,
            'access_count' => 0,
            'status' => 'active',
        );

        self::save_data($data);

        return array(
            'client_id' => $client_id,
            'password' => $plain_password,
        );
    }

    /**
     * Update client
     */
    public static function update_client($client_id, $updates) {
        $data = self::get_data();

        if (!isset($data['clients'][$client_id])) {
            return new WP_Error('not_found', __('Client not found.', 'bfluxco'));
        }

        $data['clients'][$client_id] = array_merge($data['clients'][$client_id], $updates);
        self::save_data($data);

        return true;
    }

    /**
     * Delete client
     */
    public static function delete_client($client_id) {
        $data = self::get_data();

        if (!isset($data['clients'][$client_id])) {
            return new WP_Error('not_found', __('Client not found.', 'bfluxco'));
        }

        unset($data['clients'][$client_id]);
        self::save_data($data);

        return true;
    }

    /**
     * Regenerate client password
     */
    public static function regenerate_password($client_id) {
        $data = self::get_data();
        $settings = $data['settings'];

        if (!isset($data['clients'][$client_id])) {
            return new WP_Error('not_found', __('Client not found.', 'bfluxco'));
        }

        $plain_password = self::generate_password($settings['password_length']);

        $data['clients'][$client_id]['password_hash'] = password_hash($plain_password, PASSWORD_BCRYPT, array('cost' => 12));
        $data['clients'][$client_id]['expires_at'] = current_time('timestamp') + ($settings['default_expiry_days'] * DAY_IN_SECONDS);

        self::save_data($data);

        return $plain_password;
    }

    /**
     * Revoke client access
     */
    public static function revoke_client($client_id) {
        return self::update_client($client_id, array('status' => 'revoked'));
    }

    // =========================================================================
    // AUTHENTICATION (delegated to BFLUXCO_Client_Auth)
    // =========================================================================

    /**
     * Validate client credentials
     *
     * Delegated to BFLUXCO_Client_Auth for the actual implementation.
     *
     * @param string   $email    Client email.
     * @param string   $password Client password.
     * @param int|null $post_id  Optional post ID to check access.
     * @return array|WP_Error Client data on success, WP_Error on failure.
     */
    public static function validate_credentials($email, $password, $post_id = null) {
        if (class_exists('BFLUXCO_Client_Auth')) {
            return BFLUXCO_Client_Auth::validate_credentials($email, $password, $post_id);
        }

        // Fallback implementation if auth class not loaded
        $client = self::get_client_by_email($email);

        if (!$client) {
            return new WP_Error('invalid', __('Invalid credentials.', 'bfluxco'));
        }

        if (!password_verify($password, $client['password_hash'])) {
            return new WP_Error('invalid', __('Invalid credentials.', 'bfluxco'));
        }

        if ($client['status'] === 'revoked') {
            return new WP_Error('invalid', __('Invalid credentials.', 'bfluxco'));
        }

        if ($client['expires_at'] < current_time('timestamp')) {
            return new WP_Error('invalid', __('Invalid credentials.', 'bfluxco'));
        }

        if ($post_id && !in_array($post_id, $client['case_studies'])) {
            return new WP_Error('invalid', __('Invalid credentials.', 'bfluxco'));
        }

        return $client;
    }

    /**
     * Create session cookie
     *
     * Delegated to BFLUXCO_Client_Auth for the actual implementation.
     *
     * @param string $client_id Client ID.
     * @return array|false Array with session token data on success, false on failure.
     */
    public static function create_session($client_id) {
        if (class_exists('BFLUXCO_Client_Auth')) {
            return BFLUXCO_Client_Auth::create_session($client_id);
        }

        // Fallback: minimal implementation
        return false;
    }

    /**
     * Validate session from cookie
     *
     * Delegated to BFLUXCO_Client_Auth for the actual implementation.
     *
     * @return array|false Session data on success, false on failure.
     */
    public static function validate_session() {
        if (class_exists('BFLUXCO_Client_Auth')) {
            return BFLUXCO_Client_Auth::validate_session();
        }

        return false;
    }

    /**
     * Check if session has access to post
     *
     * @param int $post_id Post ID to check.
     * @return bool True if has access, false otherwise.
     */
    public static function has_access($post_id) {
        if (class_exists('BFLUXCO_Client_Auth')) {
            return BFLUXCO_Client_Auth::has_access($post_id);
        }

        $session = self::validate_session();
        if (!$session) {
            return false;
        }

        return in_array($post_id, $session['case_studies']);
    }

    /**
     * Destroy session
     *
     * Delegated to BFLUXCO_Client_Auth for the actual implementation.
     */
    public static function destroy_session() {
        if (class_exists('BFLUXCO_Client_Auth')) {
            BFLUXCO_Client_Auth::destroy_session();
            return;
        }

        setcookie(self::COOKIE_NAME, '', time() - 3600, COOKIEPATH, COOKIE_DOMAIN, is_ssl(), true);
    }

    // =========================================================================
    // ENCRYPTION & SECURITY (delegated to BFLUXCO_Client_Auth)
    // =========================================================================

    /**
     * Encrypt data
     *
     * @param array $data Data to encrypt.
     * @return string Encrypted data.
     */
    public static function encrypt_data($data) {
        if (class_exists('BFLUXCO_Client_Auth')) {
            return BFLUXCO_Client_Auth::encrypt_data($data);
        }

        // Fallback to crypto utils
        if (class_exists('BFLUXCO_Crypto_Utils')) {
            return BFLUXCO_Crypto_Utils::encrypt($data);
        }

        throw new RuntimeException('No encryption provider available. BFLUXCO_Client_Auth or BFLUXCO_Crypto_Utils required.');
    }

    /**
     * Decrypt data
     *
     * @param string $encrypted Encrypted data.
     * @return array|false Decrypted data or false.
     */
    public static function decrypt_data($encrypted) {
        if (class_exists('BFLUXCO_Client_Auth')) {
            return BFLUXCO_Client_Auth::decrypt_data($encrypted);
        }

        // Fallback to crypto utils
        if (class_exists('BFLUXCO_Crypto_Utils')) {
            return BFLUXCO_Crypto_Utils::decrypt($encrypted);
        }

        throw new RuntimeException('No decryption provider available. BFLUXCO_Client_Auth or BFLUXCO_Crypto_Utils required.');
    }

    /**
     * Sign data with HMAC
     *
     * @param array $data Data to sign.
     * @return string Signature.
     */
    public static function sign_data($data) {
        if (class_exists('BFLUXCO_Client_Auth')) {
            return BFLUXCO_Client_Auth::sign_data($data);
        }

        return hash_hmac('sha256', json_encode($data), wp_salt('secure_auth'));
    }

    // =========================================================================
    // RATE LIMITING (delegated to BFLUXCO_Client_Auth)
    // =========================================================================

    /**
     * Check rate limit
     *
     * @return bool True if within limit, false if exceeded.
     */
    public static function check_rate_limit() {
        if (class_exists('BFLUXCO_Client_Auth')) {
            return BFLUXCO_Client_Auth::check_rate_limit();
        }

        return true;
    }

    /**
     * Record failed login attempt
     */
    public static function record_failed_attempt() {
        if (class_exists('BFLUXCO_Client_Auth')) {
            BFLUXCO_Client_Auth::record_failed_attempt();
        }
    }

    /**
     * Clear rate limit
     */
    public static function clear_rate_limit() {
        if (class_exists('BFLUXCO_Client_Auth')) {
            BFLUXCO_Client_Auth::clear_rate_limit();
        }
    }

    // =========================================================================
    // FRONTEND
    // =========================================================================

    /**
     * Check client session on page load
     */
    public static function check_client_session() {
        if (!is_singular('case_study')) {
            return;
        }

        $post = get_post();
        if (empty($post->post_password)) {
            return;
        }

        if (self::has_access($post->ID)) {
            // Client has valid session with access to this post
            add_filter('post_password_required', '__return_false', 100);
        }
    }

    /**
     * Custom password form with email field
     */
    public static function custom_password_form($output) {
        global $post;

        // Check if this is a case study
        if ($post->post_type !== 'case_study') {
            return $output;
        }

        $form = '<div class="protected-content-wrapper">
            <div class="protected-content-card">
                <div class="protected-icon" id="protected-icon">
                    <svg id="lock-icon" width="48" height="48" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
                    </svg>
                    <svg id="unlock-icon" width="48" height="48" viewBox="0 0 24 24" fill="currentColor" style="display:none;">
                        <path d="M12 17c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm6-9h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6h1.9c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm0 12H6V10h12v10z"/>
                    </svg>
                </div>
                <h2 class="protected-title">' . esc_html__('Protected Content', 'bfluxco') . '</h2>
                <p class="protected-desc">' . esc_html__('Enter your credentials to view this case study.', 'bfluxco') . '</p>
                <form class="protected-form" id="client-login-form" data-post-id="' . esc_attr($post->ID) . '">
                    <div class="protected-input-wrap">
                        <input type="email" name="client_email" id="client-email" placeholder="' . esc_attr__('Email address', 'bfluxco') . '" required />
                    </div>
                    <div class="protected-input-wrap">
                        <input type="password" name="client_password" id="client-password" placeholder="' . esc_attr__('Password', 'bfluxco') . '" required />
                    </div>
                    <p class="protected-error" id="login-error" style="display: none;">' . esc_html__('Invalid credentials.', 'bfluxco') . '</p>
                    <button type="submit" class="protected-submit" id="login-submit">' . esc_html__('Unlock', 'bfluxco') . '</button>
                </form>
                <a href="' . esc_url(home_url('/')) . '" class="protected-back">' . esc_html__('Back to Home', 'bfluxco') . '</a>
            </div>
        </div>
        <script>
        (function() {
            var form = document.getElementById("client-login-form");
            var errorEl = document.getElementById("login-error");
            var submitBtn = document.getElementById("login-submit");

            if (!form) return;

            form.addEventListener("submit", function(e) {
                e.preventDefault();

                var email = document.getElementById("client-email").value;
                var password = document.getElementById("client-password").value;
                var postId = form.getAttribute("data-post-id");

                errorEl.style.display = "none";
                submitBtn.disabled = true;
                submitBtn.textContent = "' . esc_js(__('Checking...', 'bfluxco')) . '";

                var formData = new FormData();
                formData.append("action", "bfluxco_client_login");
                formData.append("email", email);
                formData.append("password", password);
                formData.append("post_id", postId);
                formData.append("nonce", "' . wp_create_nonce('bfluxco_client_login') . '");

                fetch("' . admin_url('admin-ajax.php') . '", {
                    method: "POST",
                    credentials: "same-origin",
                    body: formData
                })
                .then(function(response) { return response.json(); })
                .then(function(data) {
                    if (data.success && data.data) {
                        // Set session cookie client-side (ensures it works even if server-side setcookie failed)
                        var d = data.data;
                        if (d.session_token && d.cookie_name) {
                            var cookieStr = d.cookie_name + "=" + encodeURIComponent(d.session_token);
                            cookieStr += "; path=" + (d.path || "/");
                            cookieStr += "; max-age=" + (d.max_age || 86400);
                            cookieStr += "; SameSite=Lax";
                            if (d.secure) {
                                cookieStr += "; Secure";
                            }
                            document.cookie = cookieStr;
                        }
                        // Show unlock icon with success color
                        var lockIcon = document.getElementById("lock-icon");
                        var unlockIcon = document.getElementById("unlock-icon");
                        var iconContainer = document.getElementById("protected-icon");
                        if (lockIcon && unlockIcon) {
                            lockIcon.style.display = "none";
                            unlockIcon.style.display = "block";
                        }
                        if (iconContainer) {
                            iconContainer.style.color = "#059669";
                        }
                        // Update button text and style
                        submitBtn.textContent = "' . esc_js(__('Unlocked!', 'bfluxco')) . '";
                        submitBtn.style.background = "#059669";
                        // Brief delay to show the unlocked state before reload
                        setTimeout(function() {
                            window.location.reload();
                        }, 500);
                    } else {
                        errorEl.textContent = (data.data && typeof data.data === "string") ? data.data : "' . esc_js(__('Invalid credentials.', 'bfluxco')) . '";
                        errorEl.style.display = "block";
                        submitBtn.disabled = false;
                        submitBtn.textContent = "' . esc_js(__('Unlock', 'bfluxco')) . '";
                        document.getElementById("client-password").value = "";
                    }
                })
                .catch(function() {
                    errorEl.textContent = "' . esc_js(__('Connection error. Please try again.', 'bfluxco')) . '";
                    errorEl.style.display = "block";
                    submitBtn.disabled = false;
                    submitBtn.textContent = "' . esc_js(__('Unlock', 'bfluxco')) . '";
                });
            });
        })();
        </script>';

        return $form;
    }

    // =========================================================================
    // AJAX HANDLERS
    // =========================================================================

    /**
     * AJAX: Client login
     */
    public static function ajax_client_login() {
        // Verify nonce
        if (!wp_verify_nonce($_POST['nonce'], 'bfluxco_client_login')) {
            wp_send_json_error(__('Security check failed.', 'bfluxco'));
        }

        // Check rate limit
        if (!self::check_rate_limit()) {
            wp_send_json_error(__('Too many attempts. Please try again later.', 'bfluxco'));
        }

        $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $post_id = isset($_POST['post_id']) ? absint($_POST['post_id']) : 0;

        if (!$email || !$password) {
            self::record_failed_attempt();
            wp_send_json_error(__('Invalid credentials.', 'bfluxco'));
        }

        $result = self::validate_credentials($email, $password, $post_id);

        if (is_wp_error($result)) {
            self::record_failed_attempt();
            wp_send_json_error(__('Invalid credentials.', 'bfluxco'));
        }

        // Create session
        self::clear_rate_limit();
        $session_result = self::create_session($result['id']);

        if (!$session_result) {
            wp_send_json_error(__('Session creation failed. Please try again.', 'bfluxco'));
        }

        // Log the login event
        if (class_exists('BFLUXCO_Case_Study_Passwords')) {
            $post_title = get_the_title($post_id);
            BFLUXCO_Case_Study_Passwords::log_event(
                'client_login',
                $email,
                $post_title ? sprintf(__('Viewed: %s', 'bfluxco'), $post_title) : ''
            );
        }

        // Return session token for client-side cookie setting
        wp_send_json_success(array(
            'redirect'      => true,
            'session_token' => $session_result['token'],
            'cookie_name'   => $session_result['cookie_name'],
            'max_age'       => $session_result['max_age'],
            'secure'        => $session_result['secure'],
            'path'          => $session_result['path'],
        ));
    }

    /**
     * AJAX: Add client
     */
    public static function ajax_add_client() {
        if (!current_user_can('manage_options')) {
            wp_send_json_error(__('Permission denied.', 'bfluxco'));
        }

        if (!wp_verify_nonce($_POST['nonce'], 'bfluxco_client_access_admin')) {
            wp_send_json_error(__('Security check failed.', 'bfluxco'));
        }

        $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
        $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
        $company = isset($_POST['company']) ? sanitize_text_field($_POST['company']) : '';
        $case_studies = isset($_POST['case_studies']) ? array_map('absint', $_POST['case_studies']) : array();
        $duration_type = isset($_POST['duration_type']) ? sanitize_text_field($_POST['duration_type']) : 'days';

        // Calculate expiry based on duration type
        if ($duration_type === 'hours') {
            $expiry_hours = isset($_POST['expiry_hours']) ? floatval($_POST['expiry_hours']) : 24;
            $expiry_days = $expiry_hours / 24; // Convert to fractional days
        } else {
            $expiry_days = isset($_POST['expiry_days']) ? absint($_POST['expiry_days']) : null;
        }

        if (!$email || !is_email($email)) {
            wp_send_json_error(__('Please enter a valid email address.', 'bfluxco'));
        }

        $result = self::add_client($email, $case_studies, $expiry_days, $name, $company);

        if (is_wp_error($result)) {
            wp_send_json_error($result->get_error_message());
        }

        // Get case study titles for copy message
        $case_study_info = array();
        foreach ($case_studies as $cs_id) {
            $cs_post = get_post($cs_id);
            if ($cs_post) {
                $case_study_info[] = array(
                    'title' => $cs_post->post_title,
                    'url' => get_permalink($cs_id),
                );
            }
        }

        $client = self::get_client($result['client_id']);

        // Log the event
        if (class_exists('BFLUXCO_Case_Study_Passwords')) {
            $cs_count = count($case_studies);
            BFLUXCO_Case_Study_Passwords::log_event(
                'client_added',
                $email,
                sprintf(_n('Access to %d case study', 'Access to %d case studies', $cs_count, 'bfluxco'), $cs_count)
            );
        }

        wp_send_json_success(array(
            'client_id' => $result['client_id'],
            'password' => $result['password'],
            'email' => $email,
            'expires' => date_i18n(get_option('date_format'), $client['expires_at']),
            'case_studies' => $case_study_info,
        ));
    }

    /**
     * AJAX: Delete client
     */
    public static function ajax_delete_client() {
        if (!current_user_can('manage_options')) {
            wp_send_json_error(__('Permission denied.', 'bfluxco'));
        }

        if (!wp_verify_nonce($_POST['nonce'], 'bfluxco_client_access_admin')) {
            wp_send_json_error(__('Security check failed.', 'bfluxco'));
        }

        $client_id = isset($_POST['client_id']) ? sanitize_text_field($_POST['client_id']) : '';

        // Get client email before deletion for logging
        $client = self::get_client($client_id);
        $client_email = $client ? $client['email'] : 'Unknown';

        $result = self::delete_client($client_id);

        if (is_wp_error($result)) {
            wp_send_json_error($result->get_error_message());
        }

        // Log the event
        if (class_exists('BFLUXCO_Case_Study_Passwords')) {
            BFLUXCO_Case_Study_Passwords::log_event('client_deleted', $client_email);
        }

        wp_send_json_success();
    }

    /**
     * AJAX: Regenerate password
     */
    public static function ajax_regenerate_password() {
        if (!current_user_can('manage_options')) {
            wp_send_json_error(__('Permission denied.', 'bfluxco'));
        }

        if (!wp_verify_nonce($_POST['nonce'], 'bfluxco_client_access_admin')) {
            wp_send_json_error(__('Security check failed.', 'bfluxco'));
        }

        $client_id = isset($_POST['client_id']) ? sanitize_text_field($_POST['client_id']) : '';

        $new_password = self::regenerate_password($client_id);

        if (is_wp_error($new_password)) {
            wp_send_json_error($new_password->get_error_message());
        }

        $client = self::get_client($client_id);

        // Log the event
        if (class_exists('BFLUXCO_Case_Study_Passwords')) {
            BFLUXCO_Case_Study_Passwords::log_event(
                'password_regenerated',
                $client['email'],
                sprintf(__('Expires %s', 'bfluxco'), date_i18n(get_option('date_format'), $client['expires_at']))
            );
        }

        wp_send_json_success(array(
            'password' => $new_password,
            'expires' => date_i18n(get_option('date_format'), $client['expires_at']),
        ));
    }

    /**
     * AJAX: Revoke client
     */
    public static function ajax_revoke_client() {
        if (!current_user_can('manage_options')) {
            wp_send_json_error(__('Permission denied.', 'bfluxco'));
        }

        if (!wp_verify_nonce($_POST['nonce'], 'bfluxco_client_access_admin')) {
            wp_send_json_error(__('Security check failed.', 'bfluxco'));
        }

        $client_id = isset($_POST['client_id']) ? sanitize_text_field($_POST['client_id']) : '';

        // Get client email before revocation for logging
        $client = self::get_client($client_id);
        $client_email = $client ? $client['email'] : 'Unknown';

        $result = self::revoke_client($client_id);

        if (is_wp_error($result)) {
            wp_send_json_error($result->get_error_message());
        }

        // Log the event
        if (class_exists('BFLUXCO_Case_Study_Passwords')) {
            BFLUXCO_Case_Study_Passwords::log_event('client_revoked', $client_email);
        }

        wp_send_json_success();
    }

    // =========================================================================
    // ADMIN INTERFACE (delegated to BFLUXCO_Client_Admin)
    // =========================================================================

    /**
     * Add admin menu
     */
    public static function add_admin_menu() {
        add_submenu_page(
            'edit.php?post_type=case_study',
            __('Client Access Manager', 'bfluxco'),
            __('Client Access', 'bfluxco'),
            'manage_options',
            'client-access',
            array(__CLASS__, 'render_admin_page')
        );
    }

    /**
     * Admin assets
     *
     * Delegates to BFLUXCO_Client_Admin for the actual styles output.
     *
     * @param string $hook Current admin page hook.
     */
    public static function admin_assets($hook) {
        if (strpos($hook, 'client-access') === false) {
            return;
        }

        // Delegate to the admin UI class
        if (class_exists('BFLUXCO_Client_Admin')) {
            BFLUXCO_Client_Admin::admin_styles();
        }
    }

    /**
     * Admin styles
     *
     * Delegates to BFLUXCO_Client_Admin for the actual styles output.
     */
    public static function admin_styles() {
        if (class_exists('BFLUXCO_Client_Admin')) {
            BFLUXCO_Client_Admin::admin_styles();
        }
    }

    /**
     * Render admin page
     *
     * Delegates to BFLUXCO_Client_Admin for the actual rendering.
     */
    public static function render_admin_page() {
        if (class_exists('BFLUXCO_Client_Admin')) {
            BFLUXCO_Client_Admin::render_admin_page();
        }
    }
}

// Initialize
BFLUXCO_Client_Access::init();
