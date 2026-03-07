<?php
/**
 * BFLUXCO Chatbot API
 *
 * Handles REST API endpoints for the AI chatbot.
 * Uses Mistral AI for conversation handling.
 *
 * @package BFLUXCO
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class BFLUXCO_Chatbot_API {

    /**
     * API namespace
     */
    const NAMESPACE = 'bfluxco/v1';

    /**
     * Mistral API endpoint
     */
    const MISTRAL_API_URL = 'https://api.mistral.ai/v1/chat/completions';

    /**
     * ElevenLabs API endpoint
     */
    const ELEVENLABS_API_URL = 'https://api.elevenlabs.io/v1/text-to-speech';

    /**
     * Default ElevenLabs voice ID (Rachel - warm, friendly)
     */
    const DEFAULT_VOICE_ID = '21m00Tcm4TlvDq8ikWAM';

    /**
     * Rate limit: max requests per minute per IP
     */
    const RATE_LIMIT = 10;

    /**
     * Lead rate limit: max lead submissions per hour per IP
     */
    const LEAD_RATE_LIMIT = 3;

    /**
     * Initialize the chatbot API
     */
    public function __construct() {
        add_action( 'rest_api_init', array( $this, 'register_routes' ) );
    }

    /**
     * Register REST API routes
     */
    public function register_routes() {
        // Chat endpoint
        register_rest_route(
            self::NAMESPACE,
            '/chat',
            array(
                'methods'             => 'POST',
                'callback'            => array( $this, 'handle_chat' ),
                'permission_callback' => array( $this, 'check_rate_limit' ),
                'args'                => array(
                    'message' => array(
                        'required'          => true,
                        'type'              => 'string',
                        'sanitize_callback' => 'sanitize_text_field',
                    ),
                    'history' => array(
                        'required' => false,
                        'type'     => 'array',
                        'default'  => array(),
                    ),
                ),
            )
        );

        // Lead capture endpoint
        register_rest_route(
            self::NAMESPACE,
            '/lead',
            array(
                'methods'             => 'POST',
                'callback'            => array( $this, 'handle_lead' ),
                'permission_callback' => array( $this, 'check_lead_rate_limit' ),
                'args'                => array(
                    'name' => array(
                        'required'          => false,
                        'type'              => 'string',
                        'sanitize_callback' => 'sanitize_text_field',
                    ),
                    'email' => array(
                        'required'          => true,
                        'type'              => 'string',
                        'sanitize_callback' => 'sanitize_email',
                    ),
                    'message' => array(
                        'required'          => false,
                        'type'              => 'string',
                        'sanitize_callback' => 'sanitize_textarea_field',
                    ),
                    'conversation' => array(
                        'required' => false,
                        'type'     => 'array',
                        'default'  => array(),
                    ),
                ),
            )
        );

        // Text-to-speech endpoint
        register_rest_route(
            self::NAMESPACE,
            '/tts',
            array(
                'methods'             => 'POST',
                'callback'            => array( $this, 'handle_tts' ),
                'permission_callback' => array( $this, 'check_rate_limit' ),
                'args'                => array(
                    'text' => array(
                        'required'          => true,
                        'type'              => 'string',
                        'sanitize_callback' => 'sanitize_text_field',
                    ),
                    'voice_id' => array(
                        'required' => false,
                        'type'     => 'string',
                        'default'  => self::DEFAULT_VOICE_ID,
                    ),
                ),
            )
        );

        // Feedback endpoint for thumbs up/down
        register_rest_route(
            self::NAMESPACE,
            '/feedback',
            array(
                'methods'             => 'POST',
                'callback'            => array( $this, 'handle_feedback' ),
                'permission_callback' => '__return_true',
                'args'                => array(
                    'type' => array(
                        'required'          => true,
                        'type'              => 'string',
                        'enum'              => array( 'helpful', 'not_helpful' ),
                        'sanitize_callback' => 'sanitize_text_field',
                    ),
                    'reason' => array(
                        'required'          => false,
                        'type'              => 'string',
                        'sanitize_callback' => 'sanitize_text_field',
                    ),
                    'message_length' => array(
                        'required' => false,
                        'type'     => 'integer',
                    ),
                    'turn_number' => array(
                        'required' => false,
                        'type'     => 'integer',
                    ),
                ),
            )
        );
    }

    /**
     * Handle feedback request (thumbs up/down)
     */
    public function handle_feedback( $request ) {
        $type           = $request->get_param( 'type' );
        $reason         = $request->get_param( 'reason' );
        $message_length = $request->get_param( 'message_length' );
        $turn_number    = $request->get_param( 'turn_number' );

        // Determine length bucket
        $length_bucket = 'medium';
        if ( $message_length ) {
            if ( $message_length < 100 ) {
                $length_bucket = 'short';
            } elseif ( $message_length > 500 ) {
                $length_bucket = 'very_long';
            } elseif ( $message_length > 300 ) {
                $length_bucket = 'long';
            }
        }

        // Record feedback if metrics class exists
        if ( class_exists( 'BFLUXCO_AI_Chat_Metrics' ) ) {
            BFLUXCO_AI_Chat_Metrics::record_feedback( $type, array(
                'reason'        => $reason,
                'length_bucket' => $length_bucket,
                'turn_number'   => $turn_number,
            ) );
        }

        return new WP_REST_Response(
            array( 'success' => true ),
            200
        );
    }

    /**
     * Check rate limit for chat requests
     */
    public function check_rate_limit( $request ) {
        $ip = $this->get_client_ip();
        $transient_key = 'bfluxco_chat_rate_' . md5( $ip );
        $count = get_transient( $transient_key );

        if ( false === $count ) {
            set_transient( $transient_key, 1, MINUTE_IN_SECONDS );
            return true;
        }

        if ( $count >= self::RATE_LIMIT ) {
            return new WP_Error(
                'rate_limit_exceeded',
                __( 'Too many requests. Please wait a moment and try again.', 'bfluxco' ),
                array( 'status' => 429 )
            );
        }

        set_transient( $transient_key, $count + 1, MINUTE_IN_SECONDS );
        return true;
    }

    /**
     * Check rate limit for lead submissions (stricter - per hour)
     */
    public function check_lead_rate_limit( $request ) {
        $ip = $this->get_client_ip();
        $transient_key = 'bfluxco_lead_rate_' . md5( $ip );
        $count = get_transient( $transient_key );

        if ( false === $count ) {
            set_transient( $transient_key, 1, HOUR_IN_SECONDS );
            return true;
        }

        if ( $count >= self::LEAD_RATE_LIMIT ) {
            return new WP_Error(
                'rate_limit_exceeded',
                __( 'Too many submissions. Please try again later.', 'bfluxco' ),
                array( 'status' => 429 )
            );
        }

        set_transient( $transient_key, $count + 1, HOUR_IN_SECONDS );
        return true;
    }

    /**
     * Get client IP address
     */
    private function get_client_ip() {
        // Only trust REMOTE_ADDR to prevent rate limit bypass via spoofed headers.
        return ! empty( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '127.0.0.1';
    }

    /**
     * Handle chat request
     */
    public function handle_chat( $request ) {
        $start_time = microtime( true );
        $message    = $request->get_param( 'message' );
        $history    = $request->get_param( 'history' );

        // Calculate turn number
        $turn_number = is_array( $history ) ? ( count( $history ) / 2 ) + 1 : 1;

        // Generate session hash for metrics (privacy-preserving)
        $session_hash = $this->get_session_hash();

        // Record conversation start event if first turn
        if ( $turn_number === 1 && class_exists( 'BFLUXCO_AI_Chat_Metrics' ) ) {
            BFLUXCO_AI_Chat_Metrics::record_event( 'conversation_start', array(
                'session_hash' => $session_hash,
            ) );
        }

        // Get API key
        $api_key = $this->get_api_key();
        if ( empty( $api_key ) ) {
            $this->record_chat_metrics( $session_hash, $turn_number, $start_time, true, false );
            return new WP_REST_Response(
                array(
                    'success'  => false,
                    'response' => __( 'Chat is currently unavailable. Please contact us directly.', 'bfluxco' ),
                ),
                200
            );
        }

        // Build messages array for Mistral
        $messages = $this->build_messages( $message, $history );

        // Call Mistral API
        $response = $this->call_mistral( $messages, $api_key );

        if ( is_wp_error( $response ) ) {
            $this->record_chat_metrics( $session_hash, $turn_number, $start_time, true, false );
            return new WP_REST_Response(
                array(
                    'success'  => false,
                    'response' => __( 'Sorry, I encountered an error. Please try again.', 'bfluxco' ),
                ),
                200
            );
        }

        // Check for handoff triggers
        $handoff = $this->should_handoff( $message, $response );

        // Record successful chat metrics
        $this->record_chat_metrics( $session_hash, $turn_number, $start_time, false, false, $handoff );

        return new WP_REST_Response(
            array(
                'success'  => true,
                'response' => $response,
                'handoff'  => $handoff,
            ),
            200
        );
    }

    /**
     * Generate a privacy-preserving session hash
     */
    private function get_session_hash() {
        $ip = $this->get_client_ip();
        $ua = isset( $_SERVER['HTTP_USER_AGENT'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) ) : '';
        return hash( 'sha256', $ip . $ua . date( 'Y-m-d' ) );
    }

    /**
     * Record chat metrics
     */
    private function record_chat_metrics( $session_hash, $turn_number, $start_time, $is_error = false, $is_fallback = false, $triggered_handoff = false ) {
        if ( ! class_exists( 'BFLUXCO_AI_Chat_Metrics' ) ) {
            return;
        }

        $response_time_ms = (int) ( ( microtime( true ) - $start_time ) * 1000 );

        // Get active features from settings
        $features = array();
        if ( class_exists( 'BFLUXCO_AI_Chat_Settings' ) ) {
            $behavior = BFLUXCO_AI_Chat_Settings::get_behavior();
            $features = $behavior['features'] ?? array();
        }

        BFLUXCO_AI_Chat_Metrics::record_event( 'turn', array(
            'session_hash'     => $session_hash,
            'turn_number'      => $turn_number,
            'response_time_ms' => $response_time_ms,
            'is_error'         => $is_error,
            'is_fallback'      => $is_fallback,
            'provider'         => 'mistral',
            'features'         => $features,
            'triggered_rules'  => $triggered_handoff ? array( 'handoff' ) : array(),
        ) );
    }

    /**
     * Handle text-to-speech request
     */
    public function handle_tts( $request ) {
        $text     = $request->get_param( 'text' );
        $voice_id = $request->get_param( 'voice_id' );

        // Get ElevenLabs API key
        $api_key = $this->get_elevenlabs_api_key();
        if ( empty( $api_key ) ) {
            return new WP_REST_Response(
                array(
                    'success' => false,
                    'message' => __( 'Voice output is currently unavailable.', 'bfluxco' ),
                ),
                200
            );
        }

        // Limit text length to prevent abuse (ElevenLabs has character limits)
        $text = substr( $text, 0, 5000 );

        // Call ElevenLabs API
        $audio_data = $this->call_elevenlabs( $text, $voice_id, $api_key );

        if ( is_wp_error( $audio_data ) ) {
            return new WP_REST_Response(
                array(
                    'success' => false,
                    'message' => __( 'Could not generate audio. Please try again.', 'bfluxco' ),
                ),
                200
            );
        }

        // Return audio as base64-encoded data
        return new WP_REST_Response(
            array(
                'success'    => true,
                'audio'      => base64_encode( $audio_data ),
                'audio_type' => 'audio/mpeg',
            ),
            200
        );
    }

    /**
     * Call ElevenLabs TTS API
     */
    private function call_elevenlabs( $text, $voice_id, $api_key ) {
        $url = self::ELEVENLABS_API_URL . '/' . $voice_id;

        $body = array(
            'text'           => $text,
            'model_id'       => 'eleven_monolingual_v1',
            'voice_settings' => array(
                'stability'        => 0.5,
                'similarity_boost' => 0.75,
            ),
        );

        $response = wp_remote_post(
            $url,
            array(
                'headers' => array(
                    'xi-api-key'   => $api_key,
                    'Content-Type' => 'application/json',
                    'Accept'       => 'audio/mpeg',
                ),
                'body'    => wp_json_encode( $body ),
                'timeout' => 60, // TTS can take a while for long text
            )
        );

        if ( is_wp_error( $response ) ) {
            return $response;
        }

        $response_code = wp_remote_retrieve_response_code( $response );
        if ( $response_code !== 200 ) {
            $error_body = wp_remote_retrieve_body( $response );
            error_log( 'ElevenLabs API error: ' . $response_code . ' - ' . $error_body );
            return new WP_Error( 'elevenlabs_error', 'ElevenLabs API returned error: ' . $response_code );
        }

        return wp_remote_retrieve_body( $response );
    }

    /**
     * Get ElevenLabs API key
     */
    private function get_elevenlabs_api_key() {
        // Check for constant first (most secure)
        if ( defined( 'BFLUXCO_ELEVENLABS_API_KEY' ) ) {
            return BFLUXCO_ELEVENLABS_API_KEY;
        }

        // Fall back to option
        return get_option( 'bfluxco_elevenlabs_api_key', '' );
    }

    /**
     * Build messages array for Mistral API
     */
    private function build_messages( $message, $history ) {
        $messages = array();

        // Add system prompt
        $system_prompt = $this->get_system_prompt();
        $messages[] = array(
            'role'    => 'system',
            'content' => $system_prompt,
        );

        // Add conversation history (limit to last 10 messages)
        if ( ! empty( $history ) && is_array( $history ) ) {
            $history = array_slice( $history, -10 );
            foreach ( $history as $msg ) {
                if ( isset( $msg['role'] ) && isset( $msg['content'] ) ) {
                    $messages[] = array(
                        'role'    => sanitize_text_field( $msg['role'] ),
                        'content' => sanitize_text_field( $msg['content'] ),
                    );
                }
            }
        }

        // Add current user message
        $messages[] = array(
            'role'    => 'user',
            'content' => $message,
        );

        return $messages;
    }

    /**
     * Get system prompt with knowledge base
     */
    private function get_system_prompt() {
        // Load knowledge base
        $knowledge = '';
        $knowledge_file = get_template_directory() . '/inc/chatbot-knowledge.php';
        if ( file_exists( $knowledge_file ) ) {
            $knowledge = include $knowledge_file;
        }

        $prompt = "You are a helpful assistant for Big Freight Life, a GenAI experience design company led by Ray Butler. You help visitors learn about Big Freight Life's services, approach, and expertise.

## Your Personality
- Professional but approachable
- Concise and direct (keep responses under 3 sentences when possible)
- Helpful and informative
- If you don't know something specific, say so honestly

## What You Know
{$knowledge}

## Guidelines
1. Answer questions about Big Freight Life's services, methodology, and approach
2. For pricing, custom project scopes, or hiring inquiries, suggest connecting with Ray directly
3. Keep responses conversational and brief
4. If someone wants to schedule a call or discuss a project, offer to collect their email

## Handoff Triggers
If the visitor asks about:
- Specific pricing or quotes
- Custom project work
- Hiring or working with Ray
- Complex technical requirements
- Anything you're unsure about

Acknowledge their interest and suggest connecting with Ray directly for a detailed conversation.";

        return $prompt;
    }

    /**
     * Call Mistral API
     */
    private function call_mistral( $messages, $api_key ) {
        $body = array(
            'model'       => 'mistral-small-latest',
            'messages'    => $messages,
            'max_tokens'  => 500,
            'temperature' => 0.7,
        );

        $response = wp_remote_post(
            self::MISTRAL_API_URL,
            array(
                'headers' => array(
                    'Authorization' => 'Bearer ' . $api_key,
                    'Content-Type'  => 'application/json',
                ),
                'body'    => wp_json_encode( $body ),
                'timeout' => 30,
            )
        );

        if ( is_wp_error( $response ) ) {
            return $response;
        }

        $response_code = wp_remote_retrieve_response_code( $response );
        if ( $response_code !== 200 ) {
            return new WP_Error( 'mistral_error', 'Mistral API returned error: ' . $response_code );
        }

        $body = wp_remote_retrieve_body( $response );
        $data = json_decode( $body, true );

        if ( empty( $data['choices'][0]['message']['content'] ) ) {
            return new WP_Error( 'mistral_error', 'Invalid response from Mistral API' );
        }

        return $data['choices'][0]['message']['content'];
    }

    /**
     * Check if we should trigger handoff
     */
    private function should_handoff( $user_message, $bot_response ) {
        $handoff_keywords = array(
            'pricing',
            'quote',
            'cost',
            'hire',
            'work with',
            'project',
            'budget',
            'rate',
            'schedule',
            'call',
            'meeting',
            'discuss',
            'consultation',
        );

        $message_lower = strtolower( $user_message );
        $response_lower = strtolower( $bot_response );

        foreach ( $handoff_keywords as $keyword ) {
            if ( strpos( $message_lower, $keyword ) !== false ) {
                return true;
            }
        }

        // Also check if bot response suggests connecting with Ray
        if ( strpos( $response_lower, 'connect with ray' ) !== false ||
             strpos( $response_lower, 'reach out' ) !== false ||
             strpos( $response_lower, 'contact ray' ) !== false ||
             strpos( $response_lower, 'email' ) !== false ) {
            return true;
        }

        return false;
    }

    /**
     * Get Mistral API key
     */
    private function get_api_key() {
        // Check for constant first (most secure)
        if ( defined( 'BFLUXCO_MISTRAL_API_KEY' ) ) {
            return BFLUXCO_MISTRAL_API_KEY;
        }

        // Fall back to option
        return get_option( 'bfluxco_mistral_api_key', '' );
    }

    /**
     * Handle lead capture
     */
    public function handle_lead( $request ) {
        $name         = $request->get_param( 'name' );
        $email        = $request->get_param( 'email' );
        $message      = $request->get_param( 'message' );
        $conversation = $request->get_param( 'conversation' );

        // Validate email
        if ( ! is_email( $email ) ) {
            return new WP_REST_Response(
                array(
                    'success' => false,
                    'message' => __( 'Please provide a valid email address.', 'bfluxco' ),
                ),
                400
            );
        }

        // Save lead to database
        $lead_id = $this->save_lead( $name, $email, $message, $conversation );

        // Send notification email
        $this->send_notification( $name, $email, $message, $conversation );

        return new WP_REST_Response(
            array(
                'success' => true,
                'message' => __( 'Thank you! Ray will be in touch soon.', 'bfluxco' ),
            ),
            200
        );
    }

    /**
     * Save lead to database
     */
    private function save_lead( $name, $email, $message, $conversation ) {
        global $wpdb;

        $table_name = $wpdb->prefix . 'bfluxco_leads';

        // Create table if it doesn't exist
        $this->maybe_create_leads_table();

        // Format conversation for storage
        $conversation_text = '';
        if ( ! empty( $conversation ) && is_array( $conversation ) ) {
            foreach ( $conversation as $msg ) {
                if ( isset( $msg['role'] ) && isset( $msg['content'] ) ) {
                    $role = $msg['role'] === 'user' ? 'Visitor' : 'Bot';
                    $conversation_text .= "{$role}: {$msg['content']}\n\n";
                }
            }
        }

        $result = $wpdb->insert(
            $table_name,
            array(
                'name'         => $name,
                'email'        => $email,
                'message'      => $message,
                'conversation' => $conversation_text,
                'ip_address'   => $this->get_client_ip(),
                'created_at'   => current_time( 'mysql' ),
                'status'       => 'new',
            ),
            array( '%s', '%s', '%s', '%s', '%s', '%s', '%s' )
        );

        return $result ? $wpdb->insert_id : false;
    }

    /**
     * Create leads table if needed
     */
    private function maybe_create_leads_table() {
        global $wpdb;

        $table_name = $wpdb->prefix . 'bfluxco_leads';

        if ( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) === $table_name ) {
            return;
        }

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            name varchar(255) DEFAULT '',
            email varchar(255) NOT NULL,
            message text DEFAULT '',
            conversation longtext DEFAULT '',
            ip_address varchar(45) DEFAULT '',
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            status varchar(20) DEFAULT 'new',
            PRIMARY KEY (id),
            KEY email (email),
            KEY status (status),
            KEY created_at (created_at)
        ) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta( $sql );
    }

    /**
     * Send notification email
     */
    private function send_notification( $name, $email, $message, $conversation ) {
        $admin_email = get_option( 'admin_email' );

        // Format conversation for email
        $conversation_html = '';
        if ( ! empty( $conversation ) && is_array( $conversation ) ) {
            $conversation_html = "<h3>Conversation History:</h3>\n<div style='background:#f5f5f5;padding:15px;border-radius:8px;'>\n";
            foreach ( $conversation as $msg ) {
                if ( isset( $msg['role'] ) && isset( $msg['content'] ) ) {
                    $role  = $msg['role'] === 'user' ? 'Visitor' : 'Bot';
                    $color = $msg['role'] === 'user' ? '#007AFF' : '#666';
                    $conversation_html .= "<p><strong style='color:{$color}'>{$role}:</strong> " . esc_html( $msg['content'] ) . "</p>\n";
                }
            }
            $conversation_html .= "</div>\n";
        }

        $subject = sprintf(
            __( '[Big Freight Life] New Chat Lead: %s', 'bfluxco' ),
            ! empty( $name ) ? $name : $email
        );

        $body = sprintf(
            "<h2>New Lead from Website Chat</h2>
            <p><strong>Name:</strong> %s</p>
            <p><strong>Email:</strong> <a href='mailto:%s'>%s</a></p>
            <p><strong>Message:</strong> %s</p>
            %s
            <hr>
            <p style='color:#888;font-size:12px;'>Received: %s</p>",
            esc_html( $name ?: 'Not provided' ),
            esc_attr( $email ),
            esc_html( $email ),
            esc_html( $message ?: 'No additional message' ),
            $conversation_html,
            current_time( 'F j, Y g:i a' )
        );

        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'Reply-To: ' . $email,
        );

        wp_mail( $admin_email, $subject, $body, $headers );
    }
}

// Initialize
new BFLUXCO_Chatbot_API();
