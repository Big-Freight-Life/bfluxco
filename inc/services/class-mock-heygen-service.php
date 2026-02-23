<?php
/**
 * Mock HeyGen Service
 *
 * Provides a mock implementation of the HeyGen avatar service for development.
 * Implements BFLUXCO_Avatar_Service_Interface for future real API integration.
 *
 * @package BFLUXCO
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Avatar Service Interface
 *
 * Defines the contract for avatar/video generation services.
 * Implement this interface to integrate with HeyGen or other providers.
 *
 * @since 1.0.0
 */
interface BFLUXCO_Avatar_Service_Interface {

    /**
     * Generate a video response with avatar speaking the provided text.
     *
     * @since 1.0.0
     *
     * @param string $text   The text for the avatar to speak.
     * @param array  $config Optional configuration array.
     *                       - avatar_id: (string) The avatar identifier.
     *                       - voice_id: (string) The voice identifier.
     *                       - style: (string) The speaking style.
     * @return array|WP_Error Response array with video data or WP_Error on failure.
     *                        Response format:
     *                        - video_url: (string) URL to the generated video.
     *                        - duration: (float) Video duration in seconds.
     *                        - status: (string) Generation status.
     */
    public function generate_response( $text, $config = array() );

    /**
     * Check if the service is available and configured.
     *
     * @since 1.0.0
     *
     * @return bool True if service is available, false otherwise.
     */
    public function is_available();

    /**
     * Get the service name for logging and display.
     *
     * @since 1.0.0
     *
     * @return string The service name.
     */
    public function get_service_name();
}

/**
 * Class BFLUXCO_Mock_HeyGen_Service
 *
 * Mock implementation of the HeyGen avatar service.
 * Simulates API responses for development and testing.
 *
 * @since 1.0.0
 */
class BFLUXCO_Mock_HeyGen_Service implements BFLUXCO_Avatar_Service_Interface {

    /**
     * Minimum simulated delay in milliseconds.
     *
     * @var int
     */
    private $simulated_delay_min = 500;

    /**
     * Maximum simulated delay in milliseconds.
     *
     * @var int
     */
    private $simulated_delay_max = 1500;

    /**
     * Average speaking rate in words per minute.
     *
     * @var int
     */
    private $speaking_rate_wpm = 150;

    /**
     * Default avatar configuration.
     *
     * @var array
     */
    private $default_config = array(
        'avatar_id' => 'mock_ray_avatar',
        'voice_id'  => 'mock_ray_voice',
        'style'     => 'professional',
    );

    /**
     * Constructor.
     *
     * @since 1.0.0
     *
     * @param array $options Optional configuration options.
     *                       - delay_min: (int) Minimum delay in ms.
     *                       - delay_max: (int) Maximum delay in ms.
     *                       - speaking_rate: (int) Words per minute.
     */
    public function __construct( $options = array() ) {
        if ( isset( $options['delay_min'] ) ) {
            $this->simulated_delay_min = absint( $options['delay_min'] );
        }

        if ( isset( $options['delay_max'] ) ) {
            $this->simulated_delay_max = absint( $options['delay_max'] );
        }

        if ( isset( $options['speaking_rate'] ) ) {
            $this->speaking_rate_wpm = absint( $options['speaking_rate'] );
        }
    }

    /**
     * Generate a mock video response.
     *
     * Simulates the HeyGen API by calculating duration based on word count
     * and returning mock video data after a simulated delay.
     *
     * @since 1.0.0
     *
     * @param string $text   The text for the avatar to speak.
     * @param array  $config Optional configuration array.
     * @return array|WP_Error Response array with mock video data.
     */
    public function generate_response( $text, $config = array() ) {
        // Validate input.
        if ( empty( $text ) ) {
            return new WP_Error(
                'empty_text',
                __( 'Text content is required for video generation.', 'bfluxco' ),
                array( 'status' => 400 )
            );
        }

        // Merge configuration with defaults.
        $config = wp_parse_args( $config, $this->default_config );

        // Simulate processing delay.
        $this->simulate_delay();

        // Calculate video duration based on word count.
        $word_count = str_word_count( wp_strip_all_tags( $text ) );
        $duration   = $this->calculate_duration( $word_count );

        // Generate mock response.
        $response = array(
            'success'   => true,
            'video_url' => $this->generate_mock_video_url( $config['avatar_id'] ),
            'duration'  => $duration,
            'status'    => 'completed',
            'metadata'  => array(
                'word_count'    => $word_count,
                'avatar_id'     => $config['avatar_id'],
                'voice_id'      => $config['voice_id'],
                'style'         => $config['style'],
                'generated_at'  => current_time( 'mysql' ),
                'service'       => $this->get_service_name(),
                'is_mock'       => true,
            ),
        );

        /**
         * Filter the mock HeyGen response.
         *
         * @since 1.0.0
         *
         * @param array  $response The mock response array.
         * @param string $text     The input text.
         * @param array  $config   The configuration used.
         */
        return apply_filters( 'bfluxco_mock_heygen_response', $response, $text, $config );
    }

    /**
     * Check if the mock service is available.
     *
     * The mock service is always available for development.
     *
     * @since 1.0.0
     *
     * @return bool Always returns true for mock service.
     */
    public function is_available() {
        return true;
    }

    /**
     * Get the service name.
     *
     * @since 1.0.0
     *
     * @return string The service identifier.
     */
    public function get_service_name() {
        return 'mock_heygen';
    }

    /**
     * Simulate processing delay.
     *
     * Adds a random delay between min and max to simulate API latency.
     *
     * @since 1.0.0
     * @access private
     *
     * @return void
     */
    private function simulate_delay() {
        $delay_ms = wp_rand( $this->simulated_delay_min, $this->simulated_delay_max );

        // Convert to microseconds for usleep.
        usleep( $delay_ms * 1000 );
    }

    /**
     * Calculate video duration based on word count.
     *
     * Uses the speaking rate (words per minute) to estimate duration.
     *
     * @since 1.0.0
     * @access private
     *
     * @param int $word_count Number of words in the text.
     * @return float Duration in seconds.
     */
    private function calculate_duration( $word_count ) {
        // Calculate duration: (words / words_per_minute) * 60 seconds.
        $duration = ( $word_count / $this->speaking_rate_wpm ) * 60;

        // Add a small buffer for pauses and transitions.
        $duration += 1.5;

        // Round to 2 decimal places.
        return round( $duration, 2 );
    }

    /**
     * Generate a mock video URL.
     *
     * Creates a placeholder URL for development purposes.
     *
     * @since 1.0.0
     * @access private
     *
     * @param string $avatar_id The avatar identifier.
     * @return string Mock video URL.
     */
    private function generate_mock_video_url( $avatar_id ) {
        // Generate a unique-ish identifier.
        $unique_id = substr( md5( microtime() . $avatar_id ), 0, 12 );

        // Return a mock URL structure (not a real video).
        return sprintf(
            '%s/mock-videos/%s-%s.mp4',
            get_template_directory_uri(),
            sanitize_file_name( $avatar_id ),
            $unique_id
        );
    }

    /**
     * Get service status information.
     *
     * Useful for debugging and admin display.
     *
     * @since 1.0.0
     *
     * @return array Service status information.
     */
    public function get_status() {
        return array(
            'service'       => $this->get_service_name(),
            'available'     => $this->is_available(),
            'type'          => 'mock',
            'delay_range'   => sprintf( '%d-%d ms', $this->simulated_delay_min, $this->simulated_delay_max ),
            'speaking_rate' => sprintf( '%d wpm', $this->speaking_rate_wpm ),
            'config'        => $this->default_config,
        );
    }
}
