<?php
/**
 * AJAX Handler Trait
 *
 * Provides reusable AJAX verification and response methods for admin handlers.
 * Extract common patterns from BFLUXCO_Client_Access, BFLUXCO_Case_Study_Passwords,
 * and BFLUXCO_AI_Chat_Admin classes.
 *
 * @package BFLUXCO
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Trait BFLUXCO_Ajax_Handler
 *
 * Provides common AJAX request verification and response handling.
 *
 * Usage:
 * ```php
 * class My_Admin_Class {
 *     use BFLUXCO_Ajax_Handler;
 *
 *     public function ajax_my_action() {
 *         $this->verify_ajax( 'my_nonce_action' );
 *         // ... handle request ...
 *         $this->send_response( true, array( 'message' => 'Success!' ) );
 *     }
 * }
 * ```
 *
 * For static classes:
 * ```php
 * class My_Static_Class {
 *     use BFLUXCO_Ajax_Handler;
 *
 *     public static function ajax_my_action() {
 *         self::verify_ajax_request( 'my_nonce_action' );
 *         // ... handle request ...
 *         self::send_ajax_response( true, array( 'message' => 'Success!' ) );
 *     }
 * }
 * ```
 *
 * @since 1.0.0
 */
trait BFLUXCO_Ajax_Handler {

    /**
     * Verify AJAX request (static version)
     *
     * Checks nonce and user capability. Sends error response and dies if verification fails.
     *
     * @since 1.0.0
     *
     * @param string $nonce_action   The nonce action name to verify against.
     * @param string $capability     Required capability. Default 'manage_options'.
     * @param string $nonce_field    POST field containing the nonce. Default 'nonce'.
     * @param bool   $check_referer  Whether to also check the HTTP referer. Default false.
     * @return void
     */
    public static function verify_ajax_request( $nonce_action, $capability = 'manage_options', $nonce_field = 'nonce', $check_referer = false ) {
        // Check user capability first.
        if ( ! current_user_can( $capability ) ) {
            wp_send_json_error(
                array(
                    'message' => __( 'Permission denied.', 'bfluxco' ),
                    'code'    => 'insufficient_permissions',
                ),
                403
            );
        }

        // Get nonce from POST data.
        $nonce = isset( $_POST[ $nonce_field ] ) ? sanitize_text_field( wp_unslash( $_POST[ $nonce_field ] ) ) : '';

        // Verify nonce.
        if ( ! wp_verify_nonce( $nonce, $nonce_action ) ) {
            wp_send_json_error(
                array(
                    'message' => __( 'Security check failed. Please refresh the page and try again.', 'bfluxco' ),
                    'code'    => 'invalid_nonce',
                ),
                403
            );
        }

        // Optional: Check HTTP referer.
        if ( $check_referer && ! check_ajax_referer( $nonce_action, $nonce_field, false ) ) {
            wp_send_json_error(
                array(
                    'message' => __( 'Invalid request origin.', 'bfluxco' ),
                    'code'    => 'invalid_referer',
                ),
                403
            );
        }
    }

    /**
     * Verify AJAX request (instance version)
     *
     * Wrapper for static method to allow use with $this.
     *
     * @since 1.0.0
     *
     * @param string $nonce_action   The nonce action name to verify against.
     * @param string $capability     Required capability. Default 'manage_options'.
     * @param string $nonce_field    POST field containing the nonce. Default 'nonce'.
     * @param bool   $check_referer  Whether to also check the HTTP referer. Default false.
     * @return void
     */
    public function verify_ajax( $nonce_action, $capability = 'manage_options', $nonce_field = 'nonce', $check_referer = false ) {
        self::verify_ajax_request( $nonce_action, $capability, $nonce_field, $check_referer );
    }

    /**
     * Verify frontend AJAX request (no capability check)
     *
     * Use this for AJAX handlers that work for non-logged-in users (nopriv actions).
     *
     * @since 1.0.0
     *
     * @param string $nonce_action The nonce action name to verify against.
     * @param string $nonce_field  POST field containing the nonce. Default 'nonce'.
     * @return void
     */
    public static function verify_frontend_ajax( $nonce_action, $nonce_field = 'nonce' ) {
        $nonce = isset( $_POST[ $nonce_field ] ) ? sanitize_text_field( wp_unslash( $_POST[ $nonce_field ] ) ) : '';

        if ( ! wp_verify_nonce( $nonce, $nonce_action ) ) {
            wp_send_json_error(
                array(
                    'message' => __( 'Security check failed.', 'bfluxco' ),
                    'code'    => 'invalid_nonce',
                ),
                403
            );
        }
    }

    /**
     * Send AJAX response (static version)
     *
     * Sends a JSON response with consistent structure and terminates execution.
     *
     * @since 1.0.0
     *
     * @param bool         $success Whether the operation was successful.
     * @param array|string $data    Response data. String is converted to message array.
     * @param int          $status  HTTP status code. Default 200.
     * @return void
     */
    public static function send_ajax_response( $success, $data = array(), $status = 200 ) {
        // Convert string data to message array for consistency.
        if ( is_string( $data ) ) {
            $data = array( 'message' => $data );
        }

        if ( $success ) {
            wp_send_json_success( $data, $status );
        } else {
            // Use 400 status for errors by default if not specified.
            $error_status = ( 200 === $status ) ? 400 : $status;
            wp_send_json_error( $data, $error_status );
        }
    }

    /**
     * Send AJAX response (instance version)
     *
     * Wrapper for static method to allow use with $this.
     *
     * @since 1.0.0
     *
     * @param bool         $success Whether the operation was successful.
     * @param array|string $data    Response data. String is converted to message array.
     * @param int          $status  HTTP status code. Default 200.
     * @return void
     */
    public function send_response( $success, $data = array(), $status = 200 ) {
        self::send_ajax_response( $success, $data, $status );
    }

    /**
     * Send success response
     *
     * Convenience method for successful responses.
     *
     * @since 1.0.0
     *
     * @param array|string $data   Response data.
     * @param int          $status HTTP status code. Default 200.
     * @return void
     */
    public static function send_success( $data = array(), $status = 200 ) {
        self::send_ajax_response( true, $data, $status );
    }

    /**
     * Send error response
     *
     * Convenience method for error responses.
     *
     * @since 1.0.0
     *
     * @param string $message    Error message.
     * @param string $code       Error code for programmatic handling. Default 'error'.
     * @param int    $status     HTTP status code. Default 400.
     * @param array  $extra_data Additional data to include in response.
     * @return void
     */
    public static function send_error( $message, $code = 'error', $status = 400, $extra_data = array() ) {
        $data = array_merge(
            array(
                'message' => $message,
                'code'    => $code,
            ),
            $extra_data
        );
        self::send_ajax_response( false, $data, $status );
    }

    /**
     * Get sanitized POST value
     *
     * Helper to retrieve and sanitize a value from $_POST.
     *
     * @since 1.0.0
     *
     * @param string $key          The POST key to retrieve.
     * @param mixed  $default      Default value if key doesn't exist. Default empty string.
     * @param string $sanitize_cb  Sanitization callback. Default 'sanitize_text_field'.
     * @return mixed Sanitized value or default.
     */
    public static function get_post_value( $key, $default = '', $sanitize_cb = 'sanitize_text_field' ) {
        if ( ! isset( $_POST[ $key ] ) ) {
            return $default;
        }

        $value = wp_unslash( $_POST[ $key ] );

        // Handle array values.
        if ( is_array( $value ) ) {
            return array_map( $sanitize_cb, $value );
        }

        // Apply sanitization callback.
        if ( is_callable( $sanitize_cb ) ) {
            return call_user_func( $sanitize_cb, $value );
        }

        return $value;
    }

    /**
     * Get required POST values
     *
     * Retrieves multiple POST values and validates they are not empty.
     * Sends error response if any required field is missing.
     *
     * @since 1.0.0
     *
     * @param array $fields Array of field names to retrieve, or associative array
     *                      with field names as keys and sanitization callbacks as values.
     * @return array Associative array of sanitized values.
     */
    public static function get_required_post_values( $fields ) {
        $values = array();
        $missing = array();

        foreach ( $fields as $key => $value ) {
            // Handle both indexed and associative arrays.
            if ( is_numeric( $key ) ) {
                $field_name = $value;
                $sanitize_cb = 'sanitize_text_field';
            } else {
                $field_name = $key;
                $sanitize_cb = $value;
            }

            $field_value = self::get_post_value( $field_name, '', $sanitize_cb );

            if ( '' === $field_value || ( is_array( $field_value ) && empty( $field_value ) ) ) {
                $missing[] = $field_name;
            }

            $values[ $field_name ] = $field_value;
        }

        if ( ! empty( $missing ) ) {
            self::send_error(
                sprintf(
                    /* translators: %s: comma-separated list of field names */
                    __( 'Missing required fields: %s', 'bfluxco' ),
                    implode( ', ', $missing )
                ),
                'missing_fields',
                400,
                array( 'missing_fields' => $missing )
            );
        }

        return $values;
    }
}
