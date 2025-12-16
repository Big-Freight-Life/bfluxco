<?php
/**
 * BFLUXCO Sidebars Registration
 *
 * Configuration-driven widget area registration.
 * Add new sidebars by adding entries to the $sidebars array.
 *
 * @package BFLUXCO
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class BFLUXCO_Sidebars
 *
 * Handles registration of all widget areas (sidebars).
 */
class BFLUXCO_Sidebars {

    /**
     * Sidebar configurations
     *
     * @var array
     */
    private static $sidebars = array(
        'footer-1' => array(
            'name'        => 'Footer Column 1',
            'description' => 'Widgets in the first footer column.',
        ),
        'footer-2' => array(
            'name'        => 'Footer Column 2',
            'description' => 'Widgets in the second footer column.',
        ),
        'footer-3' => array(
            'name'        => 'Footer Column 3',
            'description' => 'Widgets in the third footer column.',
        ),
    );

    /**
     * Default widget wrapper markup
     *
     * @var array
     */
    private static $defaults = array(
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    );

    /**
     * Initialize sidebar registration
     */
    public static function init() {
        add_action('widgets_init', array(__CLASS__, 'register_sidebars'));
    }

    /**
     * Register all widget areas
     */
    public static function register_sidebars() {
        foreach (self::$sidebars as $id => $config) {
            register_sidebar(array_merge(
                self::$defaults,
                array(
                    'name'        => __($config['name'], 'bfluxco'),
                    'id'          => $id,
                    'description' => __($config['description'], 'bfluxco'),
                )
            ));
        }
    }

    /**
     * Add a new sidebar programmatically
     *
     * @param string $id Sidebar ID
     * @param array $config Sidebar configuration (name, description)
     */
    public static function add_sidebar($id, $config) {
        self::$sidebars[$id] = $config;
    }
}

// Initialize
BFLUXCO_Sidebars::init();
