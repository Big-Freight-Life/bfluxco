<?php
/**
 * BFLUXCO Post Types Registration
 *
 * Configuration-driven custom post type registration.
 * Add new post types by adding entries to the $post_types array.
 *
 * @package BFLUXCO
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class BFLUXCO_Post_Types
 *
 * Handles registration of all custom post types.
 */
class BFLUXCO_Post_Types {

    /**
     * Post type configurations
     *
     * @var array
     */
    private static $post_types = array(
        'case_study' => array(
            'singular'      => 'Case Study',
            'plural'        => 'Case Studies',
            'slug'          => 'work/case-studies',
            'menu_position' => 5,
            'menu_icon'     => 'dashicons-portfolio',
            'has_archive'   => false,
        ),
        'workshop' => array(
            'singular'      => 'Workshop',
            'plural'        => 'Workshops',
            'slug'          => 'work/workshops',
            'menu_position' => 6,
            'menu_icon'     => 'dashicons-welcome-learn-more',
            'has_archive'   => false,
        ),
        'product' => array(
            'singular'      => 'Product',
            'plural'        => 'Products',
            'slug'          => 'work/products',
            'menu_position' => 7,
            'menu_icon'     => 'dashicons-products',
            'has_archive'   => false,
        ),
    );

    /**
     * Initialize post type registration
     */
    public static function init() {
        add_action('init', array(__CLASS__, 'register_post_types'));
    }

    /**
     * Register all custom post types
     */
    public static function register_post_types() {
        foreach (self::$post_types as $post_type => $config) {
            register_post_type($post_type, self::build_args($config));
        }
    }

    /**
     * Build post type arguments from config
     *
     * @param array $config Post type configuration
     * @return array WordPress register_post_type arguments
     */
    private static function build_args($config) {
        $singular = $config['singular'];
        $plural   = $config['plural'];

        return array(
            'labels' => array(
                'name'               => __($plural, 'bfluxco'),
                'singular_name'      => __($singular, 'bfluxco'),
                'add_new'            => __('Add New', 'bfluxco'),
                'add_new_item'       => sprintf(__('Add New %s', 'bfluxco'), $singular),
                'edit_item'          => sprintf(__('Edit %s', 'bfluxco'), $singular),
                'new_item'           => sprintf(__('New %s', 'bfluxco'), $singular),
                'view_item'          => sprintf(__('View %s', 'bfluxco'), $singular),
                'search_items'       => sprintf(__('Search %s', 'bfluxco'), $plural),
                'not_found'          => sprintf(__('No %s found', 'bfluxco'), strtolower($plural)),
                'not_found_in_trash' => sprintf(__('No %s found in Trash', 'bfluxco'), strtolower($plural)),
                'menu_name'          => __($plural, 'bfluxco'),
            ),
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'show_in_rest'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => $config['slug'], 'with_front' => false),
            'capability_type'    => 'post',
            'has_archive'        => $config['has_archive'],
            'hierarchical'       => false,
            'menu_position'      => $config['menu_position'],
            'menu_icon'          => $config['menu_icon'],
            'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        );
    }

    /**
     * Get post type config (useful for other parts of the theme)
     *
     * @param string $post_type Post type name
     * @return array|null Configuration array or null if not found
     */
    public static function get_config($post_type) {
        return isset(self::$post_types[$post_type]) ? self::$post_types[$post_type] : null;
    }
}

// Initialize
BFLUXCO_Post_Types::init();
