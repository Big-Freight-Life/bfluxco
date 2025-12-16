<?php
/**
 * BFLUXCO Theme Functions
 *
 * This file contains all the theme's core functionality.
 *
 * ==========================================================================
 * TABLE OF CONTENTS
 * ==========================================================================
 * 1. Theme Setup
 * 2. Script & Style Enqueuing
 * 3. Navigation Menus
 * 4. Widget Areas
 * 5. Custom Post Types
 * 6. Custom Taxonomies
 * 7. Helper Functions
 * 8. Template Functions
 * 9. AJAX Handlers
 * 10. Admin Customizations
 * ==========================================================================
 *
 * PRO TIP: Functions.php is like the "brain" of your WordPress theme.
 * It tells WordPress what features your theme supports and adds custom
 * functionality. Each function is explained with comments!
 */

// Prevent direct access to this file
if (!defined('ABSPATH')) {
    exit;
}

// ==========================================================================
// 1. THEME SETUP
// ==========================================================================

/**
 * Theme Setup
 *
 * This function runs when WordPress loads the theme.
 * It registers support for various WordPress features.
 *
 * PRO TIP: The 'after_setup_theme' hook ensures this code runs
 * after WordPress is fully loaded but before any output is sent.
 */
function bfluxco_theme_setup() {

    // Enable support for translating the theme into other languages
    load_theme_textdomain('bfluxco', get_template_directory() . '/languages');

    // Let WordPress manage the document title (the text in the browser tab)
    add_theme_support('title-tag');

    // Enable featured images (thumbnails) for posts and pages
    add_theme_support('post-thumbnails');

    // Set default thumbnail size (width, height, crop)
    set_post_thumbnail_size(1200, 630, true);

    // Custom image sizes are registered in inc/class-assets.php

    // Enable HTML5 markup for various WordPress elements
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));

    // Enable custom logo support
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    // Enable selective refresh for widgets in the customizer
    add_theme_support('customize-selective-refresh-widgets');

    // Add support for responsive embeds (videos, etc.)
    add_theme_support('responsive-embeds');

    // Disable the default block patterns (we'll create our own)
    remove_theme_support('core-block-patterns');
}
add_action('after_setup_theme', 'bfluxco_theme_setup');


// ==========================================================================
// 2. SCRIPT & STYLE ENQUEUING
// ==========================================================================

// Asset enqueuing is handled in inc/class-assets.php
// To add new styles/scripts, edit the configuration arrays in that file.


// ==========================================================================
// 3. NAVIGATION MENUS
// ==========================================================================

/**
 * Register Navigation Menus
 *
 * This creates menu locations that can be managed in
 * WordPress Admin > Appearance > Menus
 *
 * PRO TIP: After registering menus here, you need to create
 * actual menus in the WordPress admin and assign them to these locations.
 */
function bfluxco_register_menus() {
    register_nav_menus(array(
        'primary'   => __('Primary Navigation', 'bfluxco'),      // Main header menu
        'secondary' => __('Secondary Navigation', 'bfluxco'),    // Header utility menu
        'footer'    => __('Footer Navigation', 'bfluxco'),       // Footer links
        'mobile'    => __('Mobile Navigation', 'bfluxco'),       // Mobile menu
        'legal'     => __('Legal Links', 'bfluxco'),             // Privacy, Terms, etc.
    ));
}
add_action('init', 'bfluxco_register_menus');

/**
 * Custom Walker for Primary Navigation
 *
 * This class customizes how the navigation menu HTML is generated.
 * It adds classes for styling and supports dropdown menus.
 *
 * PRO TIP: A "Walker" in WordPress is a class that traverses
 * through menu items and generates the HTML output.
 */
class BFLUXCO_Primary_Nav_Walker extends Walker_Nav_Menu {

    /**
     * Starts the element output
     */
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {

        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        // Check if item has children (for dropdown arrow)
        if (in_array('menu-item-has-children', $classes)) {
            $classes[] = 'has-dropdown';
        }

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $output .= '<li' . $class_names . '>';

        $atts = array(
            'title'  => !empty($item->attr_title) ? $item->attr_title : '',
            'target' => !empty($item->target) ? $item->target : '',
            'rel'    => !empty($item->xfn) ? $item->xfn : '',
            'href'   => !empty($item->url) ? $item->url : '',
        );

        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $attributes .= ' ' . $attr . '="' . esc_attr($value) . '"';
            }
        }

        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}


// ==========================================================================
// 4. WIDGET AREAS
// ==========================================================================

// Widget areas (sidebars) are registered in inc/class-sidebars.php
// To add new sidebars, edit the configuration array in that file.


// ==========================================================================
// 5. CUSTOM POST TYPES
// ==========================================================================

// Custom post types are registered in inc/class-post-types.php
// To add new post types, edit the configuration array in that file.
// Remember to flush permalinks (Settings > Permalinks > Save) after changes.


// ==========================================================================
// 6. CUSTOM TAXONOMIES
// ==========================================================================

// Custom taxonomies are registered in inc/class-taxonomies.php
// To add new taxonomies, edit the configuration array in that file.


// ==========================================================================
// 7. HELPER FUNCTIONS
// ==========================================================================

/**
 * Get Theme Asset URL
 *
 * Helper function to get URLs for theme assets.
 *
 * @param string $path Path to the asset relative to assets folder
 * @return string Full URL to the asset
 *
 * Usage: bfluxco_asset('images/logo.png')
 */
function bfluxco_asset($path) {
    return get_template_directory_uri() . '/assets/' . $path;
}

// SVG icon helper moved to inc/helpers/icons.php
// Use: bfluxco_icon('name', ['size' => 16, 'class' => 'icon-class'])

/**
 * Truncate Text
 *
 * Shortens text to a specified length and adds ellipsis.
 *
 * @param string $text The text to truncate
 * @param int $length Maximum length
 * @param string $append What to append (default: ...)
 * @return string Truncated text
 */
function bfluxco_truncate($text, $length = 150, $append = '...') {
    $text = wp_strip_all_tags($text);

    if (strlen($text) <= $length) {
        return $text;
    }

    $text = substr($text, 0, $length);
    $text = substr($text, 0, strrpos($text, ' '));

    return $text . $append;
}

/**
 * Get Reading Time
 *
 * Calculates estimated reading time for content.
 *
 * @param string $content The content to calculate
 * @return int Minutes to read
 */
function bfluxco_reading_time($content = null) {
    if ($content === null) {
        $content = get_the_content();
    }

    $word_count = str_word_count(wp_strip_all_tags($content));
    $reading_time = ceil($word_count / 200); // Average reading speed

    return max(1, $reading_time);
}


// ==========================================================================
// 8. TEMPLATE FUNCTIONS
// ==========================================================================

/**
 * Display Breadcrumbs
 *
 * Outputs breadcrumb navigation for the current page.
 *
 * Usage: bfluxco_breadcrumbs();
 */
function bfluxco_breadcrumbs() {
    // Breadcrumbs disabled - using back-link component instead
    return;
    echo '<a href="' . home_url('/') . '">' . __('Home', 'bfluxco') . '</a>';

    if (is_page()) {
        $ancestors = get_post_ancestors(get_the_ID());

        if ($ancestors) {
            $ancestors = array_reverse($ancestors);

            foreach ($ancestors as $ancestor) {
                echo $separator;
                echo '<a href="' . get_permalink($ancestor) . '">' . get_the_title($ancestor) . '</a>';
            }
        }

        echo $separator;
        echo '<span class="current">' . get_the_title() . '</span>';

    } elseif (is_single()) {
        $post_type = get_post_type();
        $post_type_obj = get_post_type_object($post_type);

        if ($post_type !== 'post') {
            echo $separator;
            echo '<a href="' . get_post_type_archive_link($post_type) . '">' . $post_type_obj->labels->name . '</a>';
        }

        echo $separator;
        echo '<span class="current">' . get_the_title() . '</span>';

    } elseif (is_archive()) {
        echo $separator;

        if (is_post_type_archive()) {
            echo '<span class="current">' . post_type_archive_title('', false) . '</span>';
        } elseif (is_category()) {
            echo '<span class="current">' . single_cat_title('', false) . '</span>';
        } elseif (is_tax()) {
            echo '<span class="current">' . single_term_title('', false) . '</span>';
        }
    }

    echo '</nav>';
}

/**
 * Display Social Share Links
 *
 * Outputs social media sharing buttons for the current post.
 */
function bfluxco_social_share() {
    $url = urlencode(get_permalink());
    $title = urlencode(get_the_title());

    $links = array(
        'twitter' => array(
            'url'   => 'https://twitter.com/intent/tweet?url=' . $url . '&text=' . $title,
            'label' => __('Share on Twitter', 'bfluxco'),
        ),
        'linkedin' => array(
            'url'   => 'https://www.linkedin.com/shareArticle?mini=true&url=' . $url . '&title=' . $title,
            'label' => __('Share on LinkedIn', 'bfluxco'),
        ),
        'facebook' => array(
            'url'   => 'https://www.facebook.com/sharer/sharer.php?u=' . $url,
            'label' => __('Share on Facebook', 'bfluxco'),
        ),
    );

    echo '<div class="social-share">';

    foreach ($links as $network => $data) {
        echo '<a href="' . esc_url($data['url']) . '" target="_blank" rel="noopener noreferrer" class="social-share-link social-share-' . $network . '" aria-label="' . esc_attr($data['label']) . '">';
        echo '<span class="social-icon">' . ucfirst($network) . '</span>';
        echo '</a>';
    }

    echo '</div>';
}


// ==========================================================================
// 9. AJAX HANDLERS
// ==========================================================================

/**
 * AJAX Handler Example
 *
 * This is a template for handling AJAX requests.
 *
 * PRO TIP: AJAX lets you load content or perform actions
 * without refreshing the entire page.
 */
function bfluxco_ajax_example() {
    // Verify the security nonce
    check_ajax_referer('bfluxco_nonce', 'nonce');

    // Your AJAX logic here
    $response = array(
        'success' => true,
        'message' => __('Action completed successfully!', 'bfluxco'),
    );

    wp_send_json($response);
}
add_action('wp_ajax_bfluxco_example', 'bfluxco_ajax_example');
add_action('wp_ajax_nopriv_bfluxco_example', 'bfluxco_ajax_example');


// ==========================================================================
// 10. ADMIN CUSTOMIZATIONS
// ==========================================================================

/**
 * Add Theme Options Page
 *
 * Creates a settings page in the WordPress admin.
 */
function bfluxco_add_options_page() {
    add_theme_page(
        __('Theme Options', 'bfluxco'),
        __('Theme Options', 'bfluxco'),
        'manage_options',
        'bfluxco-options',
        'bfluxco_options_page_html'
    );
}
add_action('admin_menu', 'bfluxco_add_options_page');

/**
 * Theme Options Page HTML
 */
function bfluxco_options_page_html() {
    if (!current_user_can('manage_options')) {
        return;
    }
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <p><?php _e('Theme options will be added here. For now, use the Customizer for theme settings.', 'bfluxco'); ?></p>
        <p><a href="<?php echo admin_url('customize.php'); ?>" class="button button-primary"><?php _e('Open Customizer', 'bfluxco'); ?></a></p>
    </div>
    <?php
}

/**
 * Add Custom Dashboard Widget
 */
function bfluxco_add_dashboard_widget() {
    wp_add_dashboard_widget(
        'bfluxco_dashboard_widget',
        __('BFLUXCO Theme Quick Links', 'bfluxco'),
        'bfluxco_dashboard_widget_html'
    );
}
add_action('wp_dashboard_setup', 'bfluxco_add_dashboard_widget');

/**
 * Dashboard Widget HTML
 */
function bfluxco_dashboard_widget_html() {
    ?>
    <ul>
        <li><a href="<?php echo admin_url('customize.php'); ?>"><?php _e('Customize Theme', 'bfluxco'); ?></a></li>
        <li><a href="<?php echo admin_url('nav-menus.php'); ?>"><?php _e('Edit Menus', 'bfluxco'); ?></a></li>
        <li><a href="<?php echo admin_url('edit.php?post_type=case_study'); ?>"><?php _e('Manage Case Studies', 'bfluxco'); ?></a></li>
        <li><a href="<?php echo admin_url('edit.php?post_type=workshop'); ?>"><?php _e('Manage Workshops', 'bfluxco'); ?></a></li>
        <li><a href="<?php echo admin_url('edit.php?post_type=product'); ?>"><?php _e('Manage Products', 'bfluxco'); ?></a></li>
    </ul>
    <?php
}


// ==========================================================================
// INCLUDE ADDITIONAL FILES
// ==========================================================================

/**
 * Load additional functionality from the /inc directory
 *
 * Class files handle registration of:
 * - Post types (case_study, workshop, product)
 * - Taxonomies (industry, service_type)
 * - Sidebars (footer-1, footer-2, footer-3)
 * - Assets (styles, scripts, image sizes)
 */

// Post types registration
require_once get_template_directory() . '/inc/class-post-types.php';

// Taxonomies registration
require_once get_template_directory() . '/inc/class-taxonomies.php';

// Sidebars registration
require_once get_template_directory() . '/inc/class-sidebars.php';

// Assets (styles, scripts, image sizes)
require_once get_template_directory() . '/inc/class-assets.php';

// Custom template tags (additional helper functions)
require_once get_template_directory() . '/inc/template-tags.php';

// Theme customizer options
require_once get_template_directory() . '/inc/customizer.php';

// Helper functions
require_once get_template_directory() . '/inc/helpers/icons.php';

// Placeholder data
require_once get_template_directory() . '/inc/data/placeholders.php';
