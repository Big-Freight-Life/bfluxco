<?php
/**
 * Interview Raybot REST API
 *
 * Handles REST API endpoints for the Interview Raybot feature.
 * Provides session management, question retrieval, and response generation.
 *
 * @package BFLUXCO
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class BFLUXCO_Interview_API
 *
 * REST API controller for Interview Raybot endpoints.
 *
 * Endpoints:
 * - POST /interview/init       - Initialize a new interview session
 * - GET  /interview/questions  - Get available interview questions
 * - POST /interview/ask        - Submit a question and get response
 * - POST /interview/followup   - Submit a follow-up question
 * - POST /interview/end        - End the interview session
 *
 * @since 1.0.0
 */
class BFLUXCO_Interview_API {

    /**
     * API namespace.
     *
     * @var string
     */
    const NAMESPACE = 'bfluxco/v1';

    /**
     * Rate limit: max session initializations per hour per IP.
     *
     * @var int
     */
    const INIT_RATE_LIMIT = 5;

    /**
     * Rate limit: max requests per session.
     *
     * @var int
     */
    const SESSION_REQUEST_LIMIT = 30;

    /**
     * Interview questions data.
     *
     * @var array
     */
    private $questions = array();

    /**
     * Avatar service instance.
     *
     * @var BFLUXCO_Avatar_Service_Interface
     */
    private $avatar_service;

    /**
     * Constructor.
     *
     * Registers REST API routes on initialization.
     *
     * @since 1.0.0
     */
    public function __construct() {
        $this->load_questions();
        $this->init_avatar_service();
        $this->register_routes();
    }

    /**
     * Load interview questions from data file.
     *
     * @since 1.0.0
     * @access private
     *
     * @return void
     */
    private function load_questions() {
        $questions_file = get_template_directory() . '/inc/data/interview-questions.php';

        if ( file_exists( $questions_file ) ) {
            $this->questions = include $questions_file;
        }
    }

    /**
     * Initialize the avatar service.
     *
     * Uses mock service by default, can be filtered for real implementation.
     *
     * @since 1.0.0
     * @access private
     *
     * @return void
     */
    private function init_avatar_service() {
        /**
         * Filter the avatar service instance.
         *
         * @since 1.0.0
         *
         * @param BFLUXCO_Avatar_Service_Interface $service The avatar service.
         */
        $this->avatar_service = apply_filters(
            'bfluxco_interview_avatar_service',
            new BFLUXCO_Mock_HeyGen_Service()
        );
    }

    /**
     * Register REST API routes.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function register_routes() {
        // Initialize session.
        register_rest_route(
            self::NAMESPACE,
            '/interview/init',
            array(
                'methods'             => 'POST',
                'callback'            => array( $this, 'init_session' ),
                'permission_callback' => array( $this, 'check_init_rate_limit' ),
                'args'                => array(
                    'session_code' => array(
                        'required'          => false,
                        'type'              => 'string',
                        'sanitize_callback' => 'sanitize_text_field',
                        'default'           => '',
                    ),
                ),
            )
        );

        // Get available questions.
        register_rest_route(
            self::NAMESPACE,
            '/interview/questions',
            array(
                'methods'             => 'GET',
                'callback'            => array( $this, 'get_questions' ),
                'permission_callback' => array( $this, 'check_session_permission' ),
                'args'                => array(
                    'session_id' => array(
                        'required'          => true,
                        'type'              => 'string',
                        'sanitize_callback' => 'sanitize_text_field',
                    ),
                ),
            )
        );

        // Submit a question.
        register_rest_route(
            self::NAMESPACE,
            '/interview/ask',
            array(
                'methods'             => 'POST',
                'callback'            => array( $this, 'submit_question' ),
                'permission_callback' => array( $this, 'check_session_permission' ),
                'args'                => array(
                    'session_id'  => array(
                        'required'          => true,
                        'type'              => 'string',
                        'sanitize_callback' => 'sanitize_text_field',
                    ),
                    'question_id' => array(
                        'required'          => true,
                        'type'              => 'string',
                        'sanitize_callback' => 'sanitize_text_field',
                    ),
                ),
            )
        );

        // Submit a follow-up question.
        register_rest_route(
            self::NAMESPACE,
            '/interview/followup',
            array(
                'methods'             => 'POST',
                'callback'            => array( $this, 'submit_followup' ),
                'permission_callback' => array( $this, 'check_session_permission' ),
                'args'                => array(
                    'session_id' => array(
                        'required'          => true,
                        'type'              => 'string',
                        'sanitize_callback' => 'sanitize_text_field',
                    ),
                    'followup'   => array(
                        'required'          => true,
                        'type'              => 'string',
                        'sanitize_callback' => 'sanitize_textarea_field',
                    ),
                ),
            )
        );

        // End session.
        register_rest_route(
            self::NAMESPACE,
            '/interview/end',
            array(
                'methods'             => 'POST',
                'callback'            => array( $this, 'end_session' ),
                'permission_callback' => array( $this, 'check_session_permission' ),
                'args'                => array(
                    'session_id' => array(
                        'required'          => true,
                        'type'              => 'string',
                        'sanitize_callback' => 'sanitize_text_field',
                    ),
                ),
            )
        );
    }

    /**
     * Initialize a new interview session.
     *
     * @since 1.0.0
     *
     * @param WP_REST_Request $request The request object.
     * @return WP_REST_Response Response with session data.
     */
    public function init_session( $request ) {
        $session_code = $request->get_param( 'session_code' );

        // Create new session.
        $session = BFLUXCO_Interview_Session::create( $session_code );

        if ( is_wp_error( $session ) ) {
            return new WP_REST_Response(
                array(
                    'success' => false,
                    'error'   => array(
                        'code'    => $session->get_error_code(),
                        'message' => $session->get_error_message(),
                    ),
                ),
                $this->get_error_status( $session )
            );
        }

        // Prepare response data (hide sensitive fields).
        $response_data = array(
            'session_id'     => $session['session_id'],
            'expires_at'     => $session['expires_at'],
            'time_remaining' => BFLUXCO_Interview_Session::get_time_remaining( $session ),
            'question_count' => count( $this->questions ),
        );

        return new WP_REST_Response(
            array(
                'success' => true,
                'data'    => $response_data,
            ),
            200
        );
    }

    /**
     * Get available interview questions.
     *
     * @since 1.0.0
     *
     * @param WP_REST_Request $request The request object.
     * @return WP_REST_Response Response with questions list.
     */
    public function get_questions( $request ) {
        $session_id   = $request->get_param( 'session_id' );
        $session_data = BFLUXCO_Interview_Session::validate( $session_id );

        if ( is_wp_error( $session_data ) ) {
            return $this->error_response( $session_data );
        }

        // Format questions for frontend (hide answers).
        $questions = array();

        foreach ( $this->questions as $id => $question ) {
            $questions[] = array(
                'id'       => $question['id'],
                'category' => $question['category'],
                'text'     => $question['text'],
            );
        }

        return new WP_REST_Response(
            array(
                'success' => true,
                'data'    => array(
                    'questions'      => $questions,
                    'time_remaining' => BFLUXCO_Interview_Session::get_time_remaining( $session_data ),
                ),
            ),
            200
        );
    }

    /**
     * Submit a question and get the response.
     *
     * @since 1.0.0
     *
     * @param WP_REST_Request $request The request object.
     * @return WP_REST_Response Response with answer data.
     */
    public function submit_question( $request ) {
        $session_id  = $request->get_param( 'session_id' );
        $question_id = $request->get_param( 'question_id' );

        // Validate session.
        $session_data = BFLUXCO_Interview_Session::validate( $session_id );

        if ( is_wp_error( $session_data ) ) {
            return $this->error_response( $session_data );
        }

        // Check rate limit for this session.
        if ( ! $this->check_session_request_limit( $session_id ) ) {
            return new WP_REST_Response(
                array(
                    'success' => false,
                    'error'   => array(
                        'code'    => 'rate_limit_exceeded',
                        'message' => __( 'Too many requests. Please wait a moment.', 'bfluxco' ),
                    ),
                ),
                429
            );
        }

        // Validate question exists.
        if ( ! isset( $this->questions[ $question_id ] ) ) {
            return new WP_REST_Response(
                array(
                    'success' => false,
                    'error'   => array(
                        'code'    => 'invalid_question',
                        'message' => __( 'Question not found.', 'bfluxco' ),
                    ),
                ),
                404
            );
        }

        $question = $this->questions[ $question_id ];

        // Generate avatar response.
        $avatar_response = $this->avatar_service->generate_response(
            $question['answer']['text'],
            array(
                'avatar_id' => 'ray_butler',
                'style'     => 'professional',
            )
        );

        // Update session state.
        $session_update = BFLUXCO_Interview_Session::update(
            $session_id,
            array(
                'question_asked' => $question_id,
                'followup_used'  => false,
                'questions_log'  => array(
                    array(
                        'question_id' => $question_id,
                        'asked_at'    => time(),
                        'type'        => 'question',
                    ),
                ),
            )
        );

        // Prepare response.
        $response_data = array(
            'question_id'     => $question_id,
            'question_text'   => $question['text'],
            'answer_text'     => $question['answer']['text'],
            'followup_prompt' => $question['answer']['followup_prompt'],
            'can_followup'    => ! empty( $question['answer']['followup_prompt'] ),
            'time_remaining'  => BFLUXCO_Interview_Session::get_time_remaining(
                is_wp_error( $session_update ) ? $session_data : $session_update
            ),
        );

        // Add avatar data if available.
        if ( ! is_wp_error( $avatar_response ) ) {
            $response_data['avatar'] = array(
                'video_url' => $avatar_response['video_url'],
                'duration'  => $avatar_response['duration'],
                'status'    => $avatar_response['status'],
            );
        }

        return new WP_REST_Response(
            array(
                'success' => true,
                'data'    => $response_data,
            ),
            200
        );
    }

    /**
     * Submit a follow-up question.
     *
     * @since 1.0.0
     *
     * @param WP_REST_Request $request The request object.
     * @return WP_REST_Response Response with follow-up answer.
     */
    public function submit_followup( $request ) {
        $session_id = $request->get_param( 'session_id' );
        $followup   = $request->get_param( 'followup' );

        // Validate session.
        $session_data = BFLUXCO_Interview_Session::validate( $session_id );

        if ( is_wp_error( $session_data ) ) {
            return $this->error_response( $session_data );
        }

        // Check if follow-up is allowed.
        if ( ! BFLUXCO_Interview_Session::can_use_followup( $session_data ) ) {
            return new WP_REST_Response(
                array(
                    'success' => false,
                    'error'   => array(
                        'code'    => 'followup_limit_reached',
                        'message' => __( 'You have already asked a follow-up question.', 'bfluxco' ),
                    ),
                ),
                400
            );
        }

        // Check if a question was asked first.
        if ( empty( $session_data['question_asked'] ) ) {
            return new WP_REST_Response(
                array(
                    'success' => false,
                    'error'   => array(
                        'code'    => 'no_question_asked',
                        'message' => __( 'Please ask a question first.', 'bfluxco' ),
                    ),
                ),
                400
            );
        }

        // Get the current question context.
        $current_question_id = $session_data['question_asked'];
        $current_question    = $this->questions[ $current_question_id ] ?? null;

        if ( ! $current_question ) {
            return new WP_REST_Response(
                array(
                    'success' => false,
                    'error'   => array(
                        'code'    => 'question_context_lost',
                        'message' => __( 'Question context not found.', 'bfluxco' ),
                    ),
                ),
                400
            );
        }

        // Generate follow-up response based on context.
        $followup_answer = $this->generate_followup_response(
            $current_question,
            $followup
        );

        // Generate avatar response.
        $avatar_response = $this->avatar_service->generate_response(
            $followup_answer,
            array(
                'avatar_id' => 'ray_butler',
                'style'     => 'conversational',
            )
        );

        // Update session state.
        $session_update = BFLUXCO_Interview_Session::update(
            $session_id,
            array(
                'followup_used' => true,
                'questions_log' => array(
                    array(
                        'question_id' => $current_question_id,
                        'followup'    => $followup,
                        'asked_at'    => time(),
                        'type'        => 'followup',
                    ),
                ),
            )
        );

        // Prepare response.
        $response_data = array(
            'followup_text'  => $followup,
            'answer_text'    => $followup_answer,
            'can_followup'   => false,
            'time_remaining' => BFLUXCO_Interview_Session::get_time_remaining(
                is_wp_error( $session_update ) ? $session_data : $session_update
            ),
        );

        // Add avatar data if available.
        if ( ! is_wp_error( $avatar_response ) ) {
            $response_data['avatar'] = array(
                'video_url' => $avatar_response['video_url'],
                'duration'  => $avatar_response['duration'],
                'status'    => $avatar_response['status'],
            );
        }

        return new WP_REST_Response(
            array(
                'success' => true,
                'data'    => $response_data,
            ),
            200
        );
    }

    /**
     * End the interview session.
     *
     * @since 1.0.0
     *
     * @param WP_REST_Request $request The request object.
     * @return WP_REST_Response Response confirming session end.
     */
    public function end_session( $request ) {
        $session_id = $request->get_param( 'session_id' );

        $result = BFLUXCO_Interview_Session::end( $session_id );

        if ( is_wp_error( $result ) ) {
            return $this->error_response( $result );
        }

        // Get session statistics.
        $questions_asked = count( $result['questions_log'] ?? array() );

        return new WP_REST_Response(
            array(
                'success' => true,
                'data'    => array(
                    'message'          => __( 'Interview session ended.', 'bfluxco' ),
                    'session_id'       => $session_id,
                    'questions_asked'  => $questions_asked,
                    'session_duration' => time() - $result['created_at'],
                ),
            ),
            200
        );
    }

    /**
     * Check session permission for protected endpoints.
     *
     * @since 1.0.0
     *
     * @param WP_REST_Request $request The request object.
     * @return bool|WP_Error True if permitted, WP_Error otherwise.
     */
    public function check_session_permission( $request ) {
        $session_id = $request->get_param( 'session_id' );

        if ( empty( $session_id ) ) {
            return new WP_Error(
                'missing_session_id',
                __( 'Session ID is required.', 'bfluxco' ),
                array( 'status' => 400 )
            );
        }

        // Validate session exists and is active.
        $session_data = BFLUXCO_Interview_Session::validate( $session_id );

        if ( is_wp_error( $session_data ) ) {
            return $session_data;
        }

        return true;
    }

    /**
     * Check rate limit for session initialization.
     *
     * @since 1.0.0
     *
     * @param WP_REST_Request $request The request object.
     * @return bool|WP_Error True if within limit, WP_Error if exceeded.
     */
    public function check_init_rate_limit( $request ) {
        $ip            = $this->get_client_ip();
        $transient_key = 'bfluxco_interview_init_' . md5( $ip );
        $count         = get_transient( $transient_key );

        if ( false === $count ) {
            set_transient( $transient_key, 1, HOUR_IN_SECONDS );
            return true;
        }

        if ( $count >= self::INIT_RATE_LIMIT ) {
            return new WP_Error(
                'rate_limit_exceeded',
                __( 'Too many session requests. Please try again later.', 'bfluxco' ),
                array( 'status' => 429 )
            );
        }

        set_transient( $transient_key, $count + 1, HOUR_IN_SECONDS );
        return true;
    }

    /**
     * Check rate limit for requests within a session.
     *
     * @since 1.0.0
     * @access private
     *
     * @param string $session_id The session ID.
     * @return bool True if within limit, false if exceeded.
     */
    private function check_session_request_limit( $session_id ) {
        $transient_key = 'bfluxco_interview_requests_' . md5( $session_id );
        $count         = get_transient( $transient_key );

        if ( false === $count ) {
            set_transient( $transient_key, 1, BFLUXCO_Interview_Session::SESSION_DURATION + 60 );
            return true;
        }

        if ( $count >= self::SESSION_REQUEST_LIMIT ) {
            return false;
        }

        set_transient( $transient_key, $count + 1, BFLUXCO_Interview_Session::SESSION_DURATION + 60 );
        return true;
    }

    /**
     * Get client IP address.
     *
     * @since 1.0.0
     * @access private
     *
     * @return string Client IP address.
     */
    private function get_client_ip() {
        // Only trust REMOTE_ADDR to prevent rate limit bypass via spoofed headers.
        return ! empty( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '127.0.0.1';
    }

    /**
     * Generate a follow-up response based on context.
     *
     * @since 1.0.0
     * @access private
     *
     * @param array  $question The original question data.
     * @param string $followup The follow-up question text.
     * @return string Generated follow-up response.
     */
    private function generate_followup_response( $question, $followup ) {
        // For now, return a contextual response based on the question category.
        // In the future, this could integrate with an AI service.

        $category_responses = array(
            'background'    => "Great question! Building on my earlier answer about my background - I'd be happy to elaborate. The key insight from my experience is that successful AI projects require both deep technical understanding and genuine empathy for users. Each project I've worked on has reinforced this dual focus.",
            'methodology'   => "That's exactly the kind of detail that matters in practice. When applying my methodology, I always start with observation and listening before proposing solutions. The framework I described adapts to each organization's unique culture and constraints while maintaining its core principles.",
            'philosophy'    => "I appreciate you wanting to go deeper here. My principles aren't just theoretical - they've been tested and refined through real projects with real consequences. The most important lesson is that ethical AI design and business success aren't at odds; they reinforce each other.",
            'collaboration' => "Team dynamics are crucial in AI work. What I've learned is that the best outcomes come when everyone feels ownership of both the vision and the process. I facilitate collaboration by making space for diverse perspectives while keeping the project focused.",
            'results'       => "Measuring outcomes in AI work requires thinking beyond traditional metrics. Yes, we track efficiency gains and user satisfaction, but the deeper measure is whether we've created something people genuinely trust and want to use. That's the real success.",
        );

        $category = $question['category'] ?? 'background';

        return $category_responses[ $category ] ?? $category_responses['background'];
    }

    /**
     * Create an error response from WP_Error.
     *
     * @since 1.0.0
     * @access private
     *
     * @param WP_Error $error The error object.
     * @return WP_REST_Response Error response.
     */
    private function error_response( $error ) {
        return new WP_REST_Response(
            array(
                'success' => false,
                'error'   => array(
                    'code'    => $error->get_error_code(),
                    'message' => $error->get_error_message(),
                ),
            ),
            $this->get_error_status( $error )
        );
    }

    /**
     * Get HTTP status code from WP_Error.
     *
     * @since 1.0.0
     * @access private
     *
     * @param WP_Error $error The error object.
     * @return int HTTP status code.
     */
    private function get_error_status( $error ) {
        $data = $error->get_error_data();

        if ( is_array( $data ) && isset( $data['status'] ) ) {
            return (int) $data['status'];
        }

        return 400;
    }
}
