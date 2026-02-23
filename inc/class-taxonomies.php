<?php
/**
 * BFLUXCO Taxonomies Registration
 *
 * Configuration-driven custom taxonomy registration.
 * Add new taxonomies by adding entries to the $taxonomies array.
 *
 * @package BFLUXCO
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class BFLUXCO_Taxonomies
 *
 * Handles registration of all custom taxonomies.
 */
class BFLUXCO_Taxonomies {

    /**
     * Taxonomy configurations
     *
     * @var array
     */
    private static $taxonomies = array(
        'industry' => array(
            'singular'     => 'Industry',
            'plural'       => 'Industries',
            'post_types'   => array('case_study'),
            'hierarchical' => true,
            'slug'         => 'industry',
        ),
        'service_type' => array(
            'singular'     => 'Service Type',
            'plural'       => 'Service Types',
            'post_types'   => array('case_study'),
            'hierarchical' => false,
            'slug'         => 'service-type',
        ),
    );

    /**
     * Initialize taxonomy registration
     */
    public static function init() {
        add_action('init', array(__CLASS__, 'register_taxonomies'));
    }

    /**
     * Register all custom taxonomies
     */
    public static function register_taxonomies() {
        foreach (self::$taxonomies as $taxonomy => $config) {
            register_taxonomy($taxonomy, $config['post_types'], self::build_args($config));
        }
    }

    /**
     * Build taxonomy arguments from config
     *
     * @param array $config Taxonomy configuration
     * @return array WordPress register_taxonomy arguments
     */
    private static function build_args($config) {
        $singular = $config['singular'];
        $plural   = $config['plural'];

        return array(
            'labels' => array(
                'name'              => __($plural, 'bfluxco'),
                'singular_name'     => __($singular, 'bfluxco'),
                'search_items'      => sprintf(__('Search %s', 'bfluxco'), $plural),
                'all_items'         => sprintf(__('All %s', 'bfluxco'), $plural),
                'edit_item'         => sprintf(__('Edit %s', 'bfluxco'), $singular),
                'update_item'       => sprintf(__('Update %s', 'bfluxco'), $singular),
                'add_new_item'      => sprintf(__('Add New %s', 'bfluxco'), $singular),
                'new_item_name'     => sprintf(__('New %s Name', 'bfluxco'), $singular),
                'menu_name'         => __($plural, 'bfluxco'),
            ),
            'hierarchical'      => $config['hierarchical'],
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_rest'      => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => $config['slug']),
        );
    }

    /**
     * Get taxonomy config
     *
     * @param string $taxonomy Taxonomy name
     * @return array|null Configuration array or null if not found
     */
    public static function get_config($taxonomy) {
        return isset(self::$taxonomies[$taxonomy]) ? self::$taxonomies[$taxonomy] : null;
    }
}

// Initialize
BFLUXCO_Taxonomies::init();
