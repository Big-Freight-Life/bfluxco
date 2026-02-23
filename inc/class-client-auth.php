<?php
/**
 * Client Authentication
 *
 * Handles client authentication, session management, encryption, and rate limiting.
 * Extracted from BFLUXCO_Client_Access class to improve code organization.
 *
 * @package BFLUXCO
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class BFLUXCO_Client_Auth
 *
 * Manages client authentication including:
 * - Credential validation
 * - Session creation and validation
 * - Session destruction
 * - Encryption and decryption
 * - Data signing
 * - Rate limiting
 *
 * @since 1.0.0
 */
class BFLUXCO_Client_Auth {

    /**
     * Cookie name for client sessions
     */
    const COOKIE_NAME = 'bfluxco_client_session';

    /**
     * Validate client credentials
     *
     * @since 1.0.0
     * @param string   $email    Client email address.
     * @param string   $password Client password.
     * @param int|null $post_id  Optional post ID to check access against.
     * @return array|WP_Error Client data on success, WP_Error on failure.
     */
    public static function validate_credentials( $email, $password, $post_id = null ) {
        $client = BFLUXCO_Client_Access::get_client_by_email( $email );

        if ( ! $client ) {
            return new WP_Error( 'invalid', __( 'Invalid credentials.', 'bfluxco' ) );
        }

        // Check password
        if ( ! password_verify( $password, $client['password_hash'] ) ) {
            return new WP_Error( 'invalid', __( 'Invalid credentials.', 'bfluxco' ) );
        }

        // Check status
        if ( $client['status'] === 'revoked' ) {
            return new WP_Error( 'invalid', __( 'Invalid credentials.', 'bfluxco' ) );
        }

        // Check expiry
        if ( $client['expires_at'] < current_time( 'timestamp' ) ) {
            return new WP_Error( 'invalid', __( 'Invalid credentials.', 'bfluxco' ) );
        }

        // Check post access if post_id provided
        if ( $post_id && ! in_array( $post_id, $client['case_studies'] ) ) {
            return new WP_Error( 'invalid', __( 'Invalid credentials.', 'bfluxco' ) );
        }

        return $client;
    }

    /**
     * Create session cookie
     *
     * Returns the encrypted session token for client-side cookie setting when
     * server-side setcookie() may not work (e.g., during AJAX with headers already sent).
     *
     * @since 1.0.0
     * @param string $client_id Client ID.
     * @return array|false Array with 'token' and 'expires' on success, false on failure.
     */
    public static function create_session( $client_id ) {
        $client = BFLUXCO_Client_Access::get_client( $client_id );
        if ( ! $client ) {
            return false;
        }

        $settings = BFLUXCO_Client_Access::get_settings();

        $session_data = array(
            'client_id'    => $client_id,
            'email'        => $client['email'],
            'case_studies' => $client['case_studies'],
            'created'      => current_time( 'timestamp' ),
            'expires'      => current_time( 'timestamp' ) + $settings['session_duration'],
            'pw_version'   => substr( md5( $client['password_hash'] ), 0, 16 ),
        );

        // Add signature
        $session_data['signature'] = self::sign_data( $session_data );

        // Encrypt
        $encrypted = self::encrypt_data( $session_data );

        // Calculate cookie expiration
        $cookie_expires = time() + $settings['session_duration'];

        // Try to set cookie server-side (may fail during AJAX if headers sent)
        if ( ! headers_sent() ) {
            setcookie(
                self::COOKIE_NAME,
                $encrypted,
                $cookie_expires,
                COOKIEPATH,
                COOKIE_DOMAIN,
                is_ssl(),
                true
            );
        }

        // Update last access
        BFLUXCO_Client_Access::update_client(
            $client_id,
            array(
                'last_access'  => current_time( 'timestamp' ),
                'access_count' => $client['access_count'] + 1,
            )
        );

        // Return token for client-side cookie setting (fallback for AJAX)
        return array(
            'token'       => $encrypted,
            'expires'     => $cookie_expires,
            'max_age'     => $settings['session_duration'],
            'cookie_name' => self::COOKIE_NAME,
            'secure'      => is_ssl(),
            'path'        => COOKIEPATH ? COOKIEPATH : '/',
        );
    }

    /**
     * Validate session from cookie
     *
     * @since 1.0.0
     * @return array|false Session data on success, false on failure.
     */
    public static function validate_session() {
        if ( ! isset( $_COOKIE[ self::COOKIE_NAME ] ) ) {
            return false;
        }

        $encrypted    = $_COOKIE[ self::COOKIE_NAME ];
        $session_data = self::decrypt_data( $encrypted );

        if ( ! $session_data ) {
            return false;
        }

        // Verify signature
        $signature = $session_data['signature'];
        unset( $session_data['signature'] );

        if ( $signature !== self::sign_data( $session_data ) ) {
            return false;
        }

        // Check expiry
        if ( $session_data['expires'] < current_time( 'timestamp' ) ) {
            return false;
        }

        // Verify client still exists and is active
        $client = BFLUXCO_Client_Access::get_client( $session_data['client_id'] );
        if ( ! $client || $client['status'] !== 'active' ) {
            return false;
        }

        // Verify password hasn't changed since session was created
        if ( isset( $session_data['pw_version'] ) ) {
            $current_pw_version = substr( md5( $client['password_hash'] ), 0, 16 );
            if ( $session_data['pw_version'] !== $current_pw_version ) {
                return false;
            }
        }

        return $session_data;
    }

    /**
     * Check if session has access to post
     *
     * @since 1.0.0
     * @param int $post_id Post ID to check access for.
     * @return bool True if session has access, false otherwise.
     */
    public static function has_access( $post_id ) {
        $session = self::validate_session();
        if ( ! $session ) {
            return false;
        }

        return in_array( $post_id, $session['case_studies'] );
    }

    /**
     * Destroy session
     *
     * @since 1.0.0
     * @return void
     */
    public static function destroy_session() {
        setcookie( self::COOKIE_NAME, '', time() - 3600, COOKIEPATH, COOKIE_DOMAIN, is_ssl(), true );
    }

    // =========================================================================
    // ENCRYPTION & SECURITY
    // =========================================================================

    /**
     * Get encryption key
     *
     * @since 1.0.0
     * @return string Encryption key.
     */
    private static function get_encryption_key() {
        return hash( 'sha256', wp_salt( 'auth' ) . 'bfluxco_client_access' );
    }

    /**
     * Encrypt data
     *
     * @since 1.0.0
     * @param array $data Data to encrypt.
     * @return string Encrypted data.
     */
    public static function encrypt_data( $data ) {
        $key       = self::get_encryption_key();
        $iv        = random_bytes( 16 );
        $encrypted = openssl_encrypt(
            json_encode( $data ),
            'AES-256-CBC',
            $key,
            OPENSSL_RAW_DATA,
            $iv
        );
        return base64_encode( $iv . $encrypted );
    }

    /**
     * Decrypt data
     *
     * @since 1.0.0
     * @param string $encrypted Encrypted data string.
     * @return array|false Decrypted data or false on failure.
     */
    public static function decrypt_data( $encrypted ) {
        $key  = self::get_encryption_key();
        $data = base64_decode( $encrypted );

        if ( strlen( $data ) < 16 ) {
            return false;
        }

        $iv             = substr( $data, 0, 16 );
        $encrypted_data = substr( $data, 16 );

        $decrypted = openssl_decrypt(
            $encrypted_data,
            'AES-256-CBC',
            $key,
            OPENSSL_RAW_DATA,
            $iv
        );

        if ( $decrypted === false ) {
            return false;
        }

        return json_decode( $decrypted, true );
    }

    /**
     * Sign data with HMAC
     *
     * @since 1.0.0
     * @param array $data Data to sign.
     * @return string HMAC signature.
     */
    public static function sign_data( $data ) {
        return hash_hmac( 'sha256', json_encode( $data ), wp_salt( 'secure_auth' ) );
    }

    // =========================================================================
    // RATE LIMITING
    // =========================================================================

    /**
     * Check rate limit
     *
     * @since 1.0.0
     * @return bool True if within rate limit, false if exceeded.
     */
    public static function check_rate_limit() {
        $settings = BFLUXCO_Client_Access::get_settings();
        $ip       = self::get_client_ip();
        $key      = 'bfluxco_login_' . md5( $ip );

        $attempts = get_transient( $key );

        if ( ! $attempts ) {
            return true;
        }

        if ( isset( $attempts['locked_until'] ) && $attempts['locked_until'] > time() ) {
            return false;
        }

        if ( $attempts['count'] >= $settings['max_login_attempts'] ) {
            return false;
        }

        return true;
    }

    /**
     * Record failed login attempt
     *
     * @since 1.0.0
     * @return void
     */
    public static function record_failed_attempt() {
        $settings = BFLUXCO_Client_Access::get_settings();
        $ip       = self::get_client_ip();
        $key      = 'bfluxco_login_' . md5( $ip );

        $attempts = get_transient( $key );

        if ( ! $attempts ) {
            $attempts = array(
                'count'         => 0,
                'first_attempt' => time(),
            );
        }

        $attempts['count']++;

        if ( $attempts['count'] >= $settings['max_login_attempts'] ) {
            $attempts['locked_until'] = time() + $settings['lockout_duration'];
        }

        set_transient( $key, $attempts, $settings['lockout_duration'] + 60 );
    }

    /**
     * Clear rate limit
     *
     * @since 1.0.0
     * @return void
     */
    public static function clear_rate_limit() {
        $ip  = self::get_client_ip();
        $key = 'bfluxco_login_' . md5( $ip );
        delete_transient( $key );
    }

    /**
     * Get client IP
     *
     * @since 1.0.0
     * @return string Client IP address.
     */
    private static function get_client_ip() {
        // Only trust REMOTE_ADDR to prevent rate limit bypass via spoofed headers.
        return isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( $_SERVER['REMOTE_ADDR'] ) : '127.0.0.1';
    }
}
