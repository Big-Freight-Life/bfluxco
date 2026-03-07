<?php
/**
 * BFLUXCO Assets Management
 *
 * Configuration-driven style and script enqueuing.
 * Add new assets by adding entries to the $styles or $scripts arrays.
 *
 * @package BFLUXCO
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class BFLUXCO_Assets
 *
 * Handles enqueuing of all theme styles and scripts.
 */
class BFLUXCO_Assets {

    /**
     * Style configurations
     *
     * @var array
     */
    private static $styles = array(
        'bfluxco-google-fonts' => array(
            'src'     => 'https://fonts.googleapis.com/css2?family=Anton&family=Poppins:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600&display=swap',
            'deps'    => array(),
            'version' => null,
        ),
        'bfluxco-style' => array(
            'src'     => 'stylesheet_uri',
            'deps'    => array('bfluxco-google-fonts'),
            'version' => 'theme',
        ),
        'bfluxco-custom' => array(
            'src'     => '/assets/css/custom.css',
            'deps'    => array('bfluxco-style'),
            'version' => 'theme',
        ),
        'bfluxco-about-company' => array(
            'src'       => '/assets/css/pages/about-company.css',
            'deps'      => array('bfluxco-style'),
            'version'   => 'theme',
            'condition' => 'is_about_company',
        ),
        'bfluxco-claude-terminal' => array(
            'src'       => '/assets/css/partials/_claude-terminal.css',
            'deps'      => array('bfluxco-style'),
            'version'   => 'theme',
            'condition' => 'is_claude_terminal_page',
        ),
        'bfluxco-chatbot' => array(
            'src'       => '/assets/css/partials/_chatbot.css',
            'deps'      => array('bfluxco-custom'),
            'version'   => '2.0.0',
            'condition' => 'has_chat_interface',
        ),
        'bfluxco-contact' => array(
            'src'       => '/assets/css/partials/_contact.css',
            'deps'      => array('bfluxco-style'),
            'version'   => 'theme',
            'condition' => 'is_contact_page',
        ),
    );

    /**
     * Script configurations
     *
     * @var array
     */
    private static $scripts = array(
        // Library utilities (load first)
        'bfluxco-timing-utils' => array(
            'src'       => '/assets/js/lib/timing-utils.js',
            'deps'      => array(),
            'version'   => 'theme',
            'in_footer' => true,
        ),
        'bfluxco-event-manager' => array(
            'src'       => '/assets/js/lib/event-manager.js',
            'deps'      => array(),
            'version'   => 'theme',
            'in_footer' => true,
        ),
        // Components (load before main.js)
        'bfluxco-theme-toggle' => array(
            'src'       => '/assets/js/components/theme-toggle.js',
            'deps'      => array('bfluxco-timing-utils'),
            'version'   => 'theme',
            'in_footer' => true,
        ),
        // Main orchestrator
        'bfluxco-main' => array(
            'src'       => '/assets/js/main.js',
            'deps'      => array('bfluxco-timing-utils', 'bfluxco-event-manager', 'bfluxco-theme-toggle'),
            'version'   => 'theme',
            'in_footer' => true,
        ),
        'three-js' => array(
            'src'       => 'https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js',
            'deps'      => array(),
            'version'   => 'r128',
            'in_footer' => true,
        ),
        'bfluxco-particle-logo' => array(
            'src'       => '/assets/js/particle-logo.js',
            'deps'      => array('three-js'),
            'version'   => 'theme',
            'in_footer' => true,
        ),
        'bfluxco-claude-terminal' => array(
            'src'       => '/assets/js/claude-terminal.js',
            'deps'      => array(),
            'version'   => 'theme',
            'in_footer' => true,
            'condition' => 'is_claude_terminal_page',
        ),
        'bfluxco-ray-ambient' => array(
            'src'       => '/assets/js/ray-ambient.js',
            'deps'      => array(),
            'version'   => 'theme',
            'in_footer' => true,
            'condition' => 'is_about_person',
        ),
        'bfluxco-chatbot' => array(
            'src'       => '/assets/js/chatbot.js',
            'deps'      => array(),
            'version'   => '2.0.0',
            'in_footer' => true,
            'condition' => 'has_chat_interface',
        ),
    );

    /**
     * Image size configurations
     *
     * @var array
     */
    private static $image_sizes = array(
        'card-thumbnail'   => array('width' => 600, 'height' => 400, 'crop' => true),
        'hero-image'       => array('width' => 1920, 'height' => 800, 'crop' => true),
        'case-study-thumb' => array('width' => 800, 'height' => 600, 'crop' => true),
    );

    /**
     * Initialize asset management
     */
    public static function init() {
        add_action('wp_enqueue_scripts', array(__CLASS__, 'enqueue_assets'));
        add_action('after_setup_theme', array(__CLASS__, 'register_image_sizes'));
    }

    /**
     * Enqueue all styles and scripts
     */
    public static function enqueue_assets() {
        $theme_version = wp_get_theme()->get('Version');

        // Enqueue styles
        foreach (self::$styles as $handle => $config) {
            // Check conditional loading for styles
            if (isset($config['condition']) && !self::check_condition($config['condition'])) {
                continue;
            }

            $src = self::resolve_src($config['src']);
            $version = self::resolve_version($config['src'], $config['version'], $theme_version);

            wp_enqueue_style($handle, $src, $config['deps'], $version);
        }

        // Enqueue scripts
        foreach (self::$scripts as $handle => $config) {
            // Check conditional loading
            if (isset($config['condition']) && !self::check_condition($config['condition'])) {
                continue;
            }

            $src = self::resolve_src($config['src']);
            $version = self::resolve_version($config['src'], $config['version'], $theme_version);

            wp_enqueue_script($handle, $src, $config['deps'], $version, $config['in_footer']);
        }

        // Localize main script with data
        wp_localize_script('bfluxco-main', 'bfluxcoData', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('bfluxco_nonce'),
            'siteUrl' => home_url('/'),
        ));

        // Localize chatbot script (on pages with chat interface)
        if (self::check_condition('has_chat_interface')) {
            wp_localize_script('bfluxco-chatbot', 'bfluxcoChatbot', array(
                'apiUrl'      => rest_url('bfluxco/v1/chat'),
                'nonce'       => wp_create_nonce('wp_rest'),
                'scheduleUrl' => get_option('bfluxco_schedule_url', ''),
                'strings'     => array(
                    'placeholder'   => __('Ask how can we help you...', 'bfluxco'),
                    'sending'       => __('Sending...', 'bfluxco'),
                    'error'         => __('Sorry, something went wrong. Please try again.', 'bfluxco'),
                    'handoffTitle'  => __('Let me connect you with Ray', 'bfluxco'),
                    'handoffDesc'   => __('Leave your email and Ray will get back to you within 24 hours.', 'bfluxco'),
                    'successTitle'  => __('Message sent!', 'bfluxco'),
                    'successDesc'   => __('Ray will be in touch soon.', 'bfluxco'),
                    'scheduleBtn'   => __('Or schedule a call', 'bfluxco'),
                ),
            ));
        }

        // Comment reply script
        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }
    }

    /**
     * Register custom image sizes
     */
    public static function register_image_sizes() {
        foreach (self::$image_sizes as $name => $config) {
            add_image_size($name, $config['width'], $config['height'], $config['crop']);
        }
    }

    /**
     * Resolve version string (uses file modification time for cache busting)
     *
     * @param string $src Source path
     * @param string $version Version config value
     * @param string $theme_version Theme version fallback
     * @return string Version string
     */
    private static function resolve_version($src, $version, $theme_version) {
        if ($version !== 'theme') {
            return $version;
        }

        // For local files, use file modification time
        if (strpos($src, 'http') !== 0 && strpos($src, '//') !== 0 && $src !== 'stylesheet_uri') {
            $file_path = get_template_directory() . $src;
            if (file_exists($file_path)) {
                return filemtime($file_path);
            }
        }

        return $theme_version;
    }

    /**
     * Resolve source URL
     *
     * @param string $src Source path or special value
     * @return string Full URL
     */
    private static function resolve_src($src) {
        if ($src === 'stylesheet_uri') {
            return get_stylesheet_uri();
        }

        // External URLs
        if (strpos($src, 'http') === 0 || strpos($src, '//') === 0) {
            return $src;
        }

        // Theme-relative paths
        return get_template_directory_uri() . $src;
    }

    /**
     * Add a style dynamically
     *
     * @param string $handle Style handle
     * @param array $config Style configuration
     */
    public static function add_style($handle, $config) {
        self::$styles[$handle] = $config;
    }

    /**
     * Add a script dynamically
     *
     * @param string $handle Script handle
     * @param array $config Script configuration
     */
    public static function add_script($handle, $config) {
        self::$scripts[$handle] = $config;
    }

    /**
     * Check conditional loading conditions
     *
     * @param string $condition Condition name to check
     * @return bool Whether condition is met
     */
    private static function check_condition($condition) {
        switch ($condition) {
            case 'is_products_page':
                return is_page_template('page-templates/template-products.php');

            case 'is_code_simulation_page':
                return is_front_page() || is_page_template('page-templates/template-products.php');

            case 'is_claude_terminal_page':
                return is_front_page() || is_page_template('page-templates/template-products.php');

            case 'is_about_company':
                return is_page_template('page-templates/template-about-company.php');

            case 'is_about_person':
                return is_page_template('page-templates/template-about-person.php');

            case 'is_front_page':
                return is_front_page();

            case 'has_chat_interface':
                return is_front_page() || is_page_template('page-templates/template-transformation.php');

            case 'is_contact_page':
                return is_page_template('page-templates/template-contact.php');

            case 'is_single':
                return is_single();

            default:
                // Allow callable functions
                if (is_callable($condition)) {
                    return call_user_func($condition);
                }
                return true;
        }
    }
}

// Initialize
BFLUXCO_Assets::init();
