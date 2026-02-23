<?php
/**
 * Interview Session Management
 *
 * Handles session creation, validation, and lifecycle for Interview Raybot.
 * Uses WordPress transients for session storage.
 *
 * @package BFLUXCO
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class BFLUXCO_Interview_Session
 *
 * Manages interview sessions including:
 * - Session creation with validation codes
 * - Session validation and verification
 * - Session state updates
 * - Session destruction
 *
 * @since 1.0.0
 */
class BFLUXCO_Interview_Session {

    /**
     * Transient key prefix for session data.
     *
     * @var string
     */
    const TRANSIENT_PREFIX = 'bfluxco_interview_';

    /**
     * Session duration in seconds (5 minutes).
     *
     * @var int
     */
    const SESSION_DURATION = 300;

    /**
     * Maximum number of follow-up questions per question.
     *
     * @var int
     */
    const MAX_FOLLOWUPS = 1;

    /**
     * Valid session states.
     *
     * @var array
     */
    const VALID_STATES = array( 'active', 'ended' );

    /**
     * Create a new interview session.
     *
     * @since 1.0.0
     *
     * @param string $session_code Optional validation code from the frontend.
     * @return array|WP_Error Session data array or WP_Error on failure.
     */
    public static function create( $session_code = '' ) {
        // Generate unique session ID.
        $session_id = wp_generate_uuid4();

        // Get client identifier for security binding.
        $client_ip = self::get_client_ip();

        // Create session data structure.
        $session_data = array(
            'session_id'     => $session_id,
            'created_at'     => time(),
            'expires_at'     => time() + self::SESSION_DURATION,
            'state'          => 'active',
            'question_asked' => null,
            'followup_used'  => false,
            'questions_log'  => array(),
            'ip_address'     => $client_ip,
            'user_agent'     => self::get_user_agent_hash(),
            'session_code'   => sanitize_text_field( $session_code ),
        );

        // Add signature for integrity verification.
        $session_data['signature'] = self::sign_data( $session_data );

        // Store in transient.
        $transient_key = self::TRANSIENT_PREFIX . $session_id;
        $stored = set_transient( $transient_key, $session_data, self::SESSION_DURATION + 60 );

        if ( ! $stored ) {
            return new WP_Error(
                'session_create_failed',
                __( 'Failed to create interview session.', 'bfluxco' ),
                array( 'status' => 500 )
            );
        }

        /**
         * Fires after an interview session is created.
         *
         * @since 1.0.0
         *
         * @param string $session_id   The session identifier.
         * @param array  $session_data The session data.
         */
        do_action( 'bfluxco_interview_session_created', $session_id, $session_data );

        return $session_data;
    }

    /**
     * Validate an existing session.
     *
     * @since 1.0.0
     *
     * @param string $session_id The session ID to validate.
     * @return array|WP_Error Session data if valid, WP_Error otherwise.
     */
    public static function validate( $session_id ) {
        // Validate session ID format.
        if ( empty( $session_id ) || ! self::is_valid_uuid( $session_id ) ) {
            return new WP_Error(
                'invalid_session_id',
                __( 'Invalid session identifier.', 'bfluxco' ),
                array( 'status' => 400 )
            );
        }

        // Retrieve session from transient.
        $transient_key = self::TRANSIENT_PREFIX . $session_id;
        $session_data  = get_transient( $transient_key );

        if ( false === $session_data ) {
            return new WP_Error(
                'session_not_found',
                __( 'Session not found or expired.', 'bfluxco' ),
                array( 'status' => 404 )
            );
        }

        // Verify signature integrity.
        $stored_signature = $session_data['signature'];
        unset( $session_data['signature'] );

        if ( $stored_signature !== self::sign_data( $session_data ) ) {
            // Session data has been tampered with.
            self::destroy( $session_id );

            return new WP_Error(
                'session_invalid',
                __( 'Session validation failed.', 'bfluxco' ),
                array( 'status' => 403 )
            );
        }

        // Restore signature for return.
        $session_data['signature'] = $stored_signature;

        // Check expiration.
        if ( $session_data['expires_at'] < time() ) {
            self::destroy( $session_id );

            return new WP_Error(
                'session_expired',
                __( 'Session has expired.', 'bfluxco' ),
                array( 'status' => 410 )
            );
        }

        // Check state.
        if ( 'ended' === $session_data['state'] ) {
            return new WP_Error(
                'session_ended',
                __( 'Session has already ended.', 'bfluxco' ),
                array( 'status' => 410 )
            );
        }

        // Verify IP binding (optional security check).
        $current_ip = self::get_client_ip();
        if ( $session_data['ip_address'] !== $current_ip ) {
            // Log potential session hijacking attempt.
            error_log( sprintf(
                'BFLUXCO Interview: IP mismatch for session %s. Original: %s, Current: %s',
                $session_id,
                $session_data['ip_address'],
                $current_ip
            ) );

            // For now, allow but could be made stricter.
            // Uncomment to enforce IP binding:
            // return new WP_Error( 'ip_mismatch', 'Session security check failed.', array( 'status' => 403 ) );
        }

        return $session_data;
    }

    /**
     * Update session data.
     *
     * @since 1.0.0
     *
     * @param string $session_id The session ID to update.
     * @param array  $updates    Array of fields to update.
     * @return array|WP_Error Updated session data or WP_Error.
     */
    public static function update( $session_id, $updates ) {
        // Validate session first.
        $session_data = self::validate( $session_id );

        if ( is_wp_error( $session_data ) ) {
            return $session_data;
        }

        // Remove signature before updating.
        unset( $session_data['signature'] );

        // Apply allowed updates.
        $allowed_updates = array(
            'question_asked',
            'followup_used',
            'questions_log',
            'state',
        );

        foreach ( $allowed_updates as $field ) {
            if ( isset( $updates[ $field ] ) ) {
                // Special handling for questions_log (append).
                if ( 'questions_log' === $field && isset( $session_data['questions_log'] ) ) {
                    if ( is_array( $updates[ $field ] ) ) {
                        $session_data['questions_log'] = array_merge(
                            $session_data['questions_log'],
                            $updates[ $field ]
                        );
                    }
                } elseif ( 'state' === $field ) {
                    // Validate state transitions.
                    if ( in_array( $updates[ $field ], self::VALID_STATES, true ) ) {
                        $session_data['state'] = $updates[ $field ];
                    }
                } else {
                    $session_data[ $field ] = $updates[ $field ];
                }
            }
        }

        // Re-sign the updated data.
        $session_data['signature'] = self::sign_data( $session_data );

        // Calculate remaining TTL.
        $remaining_ttl = max( 0, $session_data['expires_at'] - time() ) + 60;

        // Store updated session.
        $transient_key = self::TRANSIENT_PREFIX . $session_id;
        set_transient( $transient_key, $session_data, $remaining_ttl );

        /**
         * Fires after an interview session is updated.
         *
         * @since 1.0.0
         *
         * @param string $session_id   The session identifier.
         * @param array  $session_data The updated session data.
         * @param array  $updates      The updates that were applied.
         */
        do_action( 'bfluxco_interview_session_updated', $session_id, $session_data, $updates );

        return $session_data;
    }

    /**
     * End a session gracefully.
     *
     * Marks the session as ended but preserves data for logging.
     *
     * @since 1.0.0
     *
     * @param string $session_id The session ID to end.
     * @return array|WP_Error Ended session data or WP_Error.
     */
    public static function end( $session_id ) {
        $result = self::update( $session_id, array( 'state' => 'ended' ) );

        if ( ! is_wp_error( $result ) ) {
            /**
             * Fires when an interview session ends.
             *
             * @since 1.0.0
             *
             * @param string $session_id   The session identifier.
             * @param array  $session_data The final session data.
             */
            do_action( 'bfluxco_interview_session_ended', $session_id, $result );
        }

        return $result;
    }

    /**
     * Destroy a session completely.
     *
     * Removes all session data from storage.
     *
     * @since 1.0.0
     *
     * @param string $session_id The session ID to destroy.
     * @return bool True if destroyed, false otherwise.
     */
    public static function destroy( $session_id ) {
        $transient_key = self::TRANSIENT_PREFIX . $session_id;
        $deleted       = delete_transient( $transient_key );

        if ( $deleted ) {
            /**
             * Fires after an interview session is destroyed.
             *
             * @since 1.0.0
             *
             * @param string $session_id The session identifier.
             */
            do_action( 'bfluxco_interview_session_destroyed', $session_id );
        }

        return $deleted;
    }

    /**
     * Check if follow-up is available for the current question.
     *
     * @since 1.0.0
     *
     * @param array $session_data The session data.
     * @return bool True if follow-up is available.
     */
    public static function can_use_followup( $session_data ) {
        return ! $session_data['followup_used'];
    }

    /**
     * Sign session data for integrity verification.
     *
     * @since 1.0.0
     * @access private
     *
     * @param array $data Data to sign.
     * @return string HMAC signature.
     */
    private static function sign_data( $data ) {
        // Remove signature if present before signing.
        unset( $data['signature'] );

        return hash_hmac(
            'sha256',
            wp_json_encode( $data ),
            wp_salt( 'secure_auth' ) . 'bfluxco_interview'
        );
    }

    /**
     * Get client IP address.
     *
     * @since 1.0.0
     * @access private
     *
     * @return string Client IP address.
     */
    private static function get_client_ip() {
        // Only trust REMOTE_ADDR to prevent rate limit bypass via spoofed headers.
        return ! empty( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '127.0.0.1';
    }

    /**
     * Get hashed user agent for session binding.
     *
     * @since 1.0.0
     * @access private
     *
     * @return string Hashed user agent.
     */
    private static function get_user_agent_hash() {
        $user_agent = '';

        if ( isset( $_SERVER['HTTP_USER_AGENT'] ) ) {
            $user_agent = sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) );
        }

        return hash( 'sha256', $user_agent );
    }

    /**
     * Validate UUID format.
     *
     * @since 1.0.0
     * @access private
     *
     * @param string $uuid String to validate.
     * @return bool True if valid UUID v4 format.
     */
    private static function is_valid_uuid( $uuid ) {
        return (bool) preg_match(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i',
            $uuid
        );
    }

    /**
     * Get session expiration time remaining.
     *
     * @since 1.0.0
     *
     * @param array $session_data The session data.
     * @return int Seconds remaining until expiration.
     */
    public static function get_time_remaining( $session_data ) {
        return max( 0, $session_data['expires_at'] - time() );
    }

    /**
     * Extend session duration.
     *
     * @since 1.0.0
     *
     * @param string $session_id       The session ID to extend.
     * @param int    $additional_time  Seconds to add (default: SESSION_DURATION).
     * @return array|WP_Error Updated session data or WP_Error.
     */
    public static function extend( $session_id, $additional_time = null ) {
        if ( null === $additional_time ) {
            $additional_time = self::SESSION_DURATION;
        }

        // Validate session first.
        $session_data = self::validate( $session_id );

        if ( is_wp_error( $session_data ) ) {
            return $session_data;
        }

        // Remove signature before updating.
        unset( $session_data['signature'] );

        // Extend expiration.
        $session_data['expires_at'] = time() + $additional_time;

        // Re-sign.
        $session_data['signature'] = self::sign_data( $session_data );

        // Store with new TTL.
        $transient_key = self::TRANSIENT_PREFIX . $session_id;
        set_transient( $transient_key, $session_data, $additional_time + 60 );

        return $session_data;
    }
}
