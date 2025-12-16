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
            'src'     => 'https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600&display=swap',
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
    );

    /**
     * Script configurations
     *
     * @var array
     */
    private static $scripts = array(
        'bfluxco-main' => array(
            'src'       => '/assets/js/main.js',
            'deps'      => array(),
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
            $src = self::resolve_src($config['src']);
            $version = ($config['version'] === 'theme') ? $theme_version : $config['version'];

            wp_enqueue_style($handle, $src, $config['deps'], $version);
        }

        // Enqueue scripts
        foreach (self::$scripts as $handle => $config) {
            $src = self::resolve_src($config['src']);
            $version = ($config['version'] === 'theme') ? $theme_version : $config['version'];

            wp_enqueue_script($handle, $src, $config['deps'], $version, $config['in_footer']);
        }

        // Localize main script with data
        wp_localize_script('bfluxco-main', 'bfluxcoData', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('bfluxco_nonce'),
            'siteUrl' => home_url('/'),
        ));

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
}

// Initialize
BFLUXCO_Assets::init();
