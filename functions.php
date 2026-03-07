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

// Define theme version constant
if (!defined('BFLUXCO_THEME_VERSION')) {
    define('BFLUXCO_THEME_VERSION', '1.3.0');
}

// ==========================================================================
// SECURITY HEADERS
// ==========================================================================

/**
 * Add Security Headers
 *
 * Adds HTTP security headers to protect against common attacks.
 * - X-Content-Type-Options: Prevents MIME type sniffing
 * - X-Frame-Options: Prevents clickjacking attacks
 * - X-XSS-Protection: Enables browser XSS filtering
 * - Referrer-Policy: Controls referrer information leakage
 * - Content-Security-Policy: Controls resource loading sources
 * - Permissions-Policy: Restricts browser feature access
 */
function bfluxco_security_headers() {
    if (!is_admin()) {
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('X-XSS-Protection: 1; mode=block');
        header('Referrer-Policy: strict-origin-when-cross-origin');

        // Content Security Policy - allows self + inline for WordPress compatibility
        // 'unsafe-inline' needed for WordPress admin bar, customizer, and inline styles/scripts
        $csp = "default-src 'self'; " .
               "script-src 'self' 'unsafe-inline' 'unsafe-eval' *.googleapis.com *.gstatic.com cdnjs.cloudflare.com; " .
               "style-src 'self' 'unsafe-inline' fonts.googleapis.com; " .
               "font-src 'self' fonts.gstatic.com data:; " .
               "img-src 'self' data: https: blob:; " .
               "connect-src 'self' *.googleapis.com; " .
               "frame-src 'self' www.youtube.com www.youtube-nocookie.com player.vimeo.com; " .
               "frame-ancestors 'self'; " .
               "base-uri 'self'; " .
               "form-action 'self';";
        header('Content-Security-Policy: ' . $csp);

        // Permissions Policy - restrict sensitive browser APIs
        $permissions = "accelerometer=(), " .
                      "camera=(), " .
                      "geolocation=(), " .
                      "gyroscope=(), " .
                      "magnetometer=(), " .
                      "microphone=(), " .
                      "payment=(), " .
                      "usb=()";
        header('Permissions-Policy: ' . $permissions);
    }
}
add_action('send_headers', 'bfluxco_security_headers');

// ==========================================================================
// PAGE REDIRECTS
// ==========================================================================

/**
 * Redirect /services to /transformation
 *
 * Services content has been merged into the Transformation page.
 * This redirect ensures old links and bookmarks still work.
 */
function bfluxco_services_redirect() {
    if (is_page('services')) {
        wp_redirect(home_url('/transformation/'), 301);
        exit;
    }
}
add_action('template_redirect', 'bfluxco_services_redirect');

// ==========================================================================
// EXCERPT FOR PROTECTED POSTS
// ==========================================================================

/**
 * Replace Protected Post Excerpt Message
 *
 * Changes the default "There is no excerpt because this is a protected post"
 * message to something cleaner.
 */
function bfluxco_protected_excerpt_message($excerpt) {
    if (strpos($excerpt, 'There is no excerpt because this is a protected post') !== false) {
        return 'Password protected content.';
    }
    return $excerpt;
}
add_filter('the_excerpt', 'bfluxco_protected_excerpt_message', 20);
add_filter('get_the_excerpt', 'bfluxco_protected_excerpt_message', 20);

/**
 * Replace "Protected:" Title Prefix with Lock/Unlock Icon
 */
function bfluxco_protected_title_format($format) {
    // SVG lock icon that inherits text color
    $lock_icon = '<svg class="lock-icon" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" style="display:inline-block;vertical-align:middle;margin-right:6px;opacity:0.6;"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>';
    $unlock_icon = '<svg class="lock-icon" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" style="display:inline-block;vertical-align:middle;margin-right:6px;opacity:0.6;"><path d="M12 17c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm6-9h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6h1.9c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm0 12H6V10h12v10z"/></svg>';

    // Show lock icon if password required, unlock if already entered
    if (post_password_required()) {
        return $lock_icon . '%s';
    }
    return $unlock_icon . '%s';
}
add_filter('protected_title_format', 'bfluxco_protected_title_format');

/**
 * Custom Password Form for Protected Posts
 *
 * Replaces the default WordPress password form with a modern, mobile-optimized design.
 * Note: Case studies are handled by BFLUXCO_Client_Access class with email+password form.
 */
function bfluxco_custom_password_form($output) {
    global $post;

    // Skip case studies - handled by Client Access class with email+password form
    if ($post && $post->post_type === 'case_study') {
        return $output;
    }

    $label = 'pwbox-' . (empty($post->ID) ? rand() : $post->ID);

    $output = '<div class="protected-content-wrapper">
        <div class="protected-content-card">
            <div class="protected-icon">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
                </svg>
            </div>
            <h2 class="protected-title">' . esc_html__('Protected Content', 'bfluxco') . '</h2>
            <p class="protected-desc">' . esc_html__('This content is password protected. Enter the password to view.', 'bfluxco') . '</p>
            <form action="' . esc_url(site_url('wp-login.php?action=postpass', 'login_post')) . '" class="protected-form" method="post">
                <div class="protected-input-wrap">
                    <input name="post_password" id="' . esc_attr($label) . '" type="password" placeholder="' . esc_attr__('Enter password', 'bfluxco') . '" required />
                </div>
                <button type="submit" class="protected-submit">' . esc_html__('Unlock', 'bfluxco') . '</button>
            </form>
            <a href="' . esc_url(home_url('/')) . '" class="protected-back">' . esc_html__('Back to Home', 'bfluxco') . '</a>
        </div>
    </div>';

    return $output;
}
add_filter('the_password_form', 'bfluxco_custom_password_form');

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

/**
 * Get API Key
 *
 * Safely retrieves API keys defined in wp-config.php.
 * Returns null if the key doesn't exist or is a placeholder.
 *
 * @param string $key_name The constant name (e.g., 'MISTRAL_API_KEY')
 * @return string|null The API key or null if not configured
 *
 * Usage: $key = bfluxco_get_api_key('MISTRAL_API_KEY');
 */
function bfluxco_get_api_key($key_name) {
    // Check if the constant is defined
    if (!defined($key_name)) {
        return null;
    }

    $key = constant($key_name);

    // Check for placeholder values (not configured)
    $placeholders = array(
        '',
        'your-mistral-api-key-here',
        'your-elevenlabs-api-key-here',
        'your-hagen-api-key-here',
        'your-api-key-here',
        'key-here',
    );

    if (in_array($key, $placeholders, true)) {
        return null;
    }

    return $key;
}

/**
 * Check if API Key is Configured
 *
 * Quick check to see if an API key is available and valid.
 *
 * @param string $key_name The constant name
 * @return bool True if key is configured, false otherwise
 *
 * Usage: if (bfluxco_has_api_key('MISTRAL_API_KEY')) { ... }
 */
function bfluxco_has_api_key($key_name) {
    return bfluxco_get_api_key($key_name) !== null;
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
    $separator = '<span class="breadcrumb-separator">/</span>';

    echo '<nav class="breadcrumbs" aria-label="Breadcrumb">';
    echo '<ol class="breadcrumb-list">';

    // Home link
    echo '<li class="breadcrumb-item">';
    echo '<a href="' . esc_url(home_url('/')) . '">' . esc_html__('Home', 'bfluxco') . '</a>';
    echo '</li>';

    if (is_page()) {
        $ancestors = get_post_ancestors(get_the_ID());

        if ($ancestors) {
            $ancestors = array_reverse($ancestors);

            foreach ($ancestors as $ancestor) {
                echo '<li class="breadcrumb-item">';
                echo $separator;
                echo '<a href="' . esc_url(get_permalink($ancestor)) . '">' . esc_html(wp_strip_all_tags(get_the_title($ancestor))) . '</a>';
                echo '</li>';
            }
        }

        echo '<li class="breadcrumb-item current">';
        echo $separator;
        echo '<span aria-current="page">' . esc_html(wp_strip_all_tags(get_the_title())) . '</span>';
        echo '</li>';

    } elseif (is_single()) {
        $post_type = get_post_type();
        $post_type_obj = get_post_type_object($post_type);

        if ($post_type === 'post') {
            // Blog posts - link to blog page
            $blog_page_id = get_option('page_for_posts');
            $blog_url = $blog_page_id ? get_permalink($blog_page_id) : home_url('/blog');
            echo '<li class="breadcrumb-item">';
            echo $separator;
            echo '<a href="' . esc_url($blog_url) . '">' . esc_html__('Blog', 'bfluxco') . '</a>';
            echo '</li>';
        } elseif ($post_type_obj) {
            // Custom post types - link to archive
            echo '<li class="breadcrumb-item">';
            echo $separator;
            echo '<a href="' . esc_url(get_post_type_archive_link($post_type)) . '">' . esc_html($post_type_obj->labels->name) . '</a>';
            echo '</li>';
        }

        echo '<li class="breadcrumb-item current">';
        echo $separator;
        echo '<span aria-current="page">' . esc_html(wp_strip_all_tags(get_the_title())) . '</span>';
        echo '</li>';

    } elseif (is_archive()) {
        echo '<li class="breadcrumb-item current">';
        echo $separator;

        if (is_post_type_archive()) {
            echo '<span aria-current="page">' . esc_html(post_type_archive_title('', false)) . '</span>';
        } elseif (is_category()) {
            echo '<span aria-current="page">' . esc_html(single_cat_title('', false)) . '</span>';
        } elseif (is_tax()) {
            echo '<span aria-current="page">' . esc_html(single_term_title('', false)) . '</span>';
        }
        echo '</li>';
    }

    echo '</ol>';
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

// AJAX handlers are registered in individual class files:
// - inc/class-chatbot-api.php (chat, lead, TTS endpoints)
// - inc/class-client-access.php (client login)
// - inc/class-case-study-passwords.php (password management)
// - inc/class-ai-chat-admin.php (admin AJAX)


// ==========================================================================
// 10. ADMIN CUSTOMIZATIONS
// ==========================================================================

/**
 * Add Custom Dashboard Widget
 *
 * Provides quick links to manage theme content from the WordPress dashboard.
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
        <li><a href="<?php echo esc_url(admin_url('customize.php')); ?>"><?php esc_html_e('Customize Theme', 'bfluxco'); ?></a></li>
        <li><a href="<?php echo esc_url(admin_url('nav-menus.php')); ?>"><?php esc_html_e('Edit Menus', 'bfluxco'); ?></a></li>
        <li><a href="<?php echo esc_url(admin_url('edit.php?post_type=case_study')); ?>"><?php esc_html_e('Manage Case Studies', 'bfluxco'); ?></a></li>
        <li><a href="<?php echo esc_url(admin_url('edit.php?post_type=product')); ?>"><?php esc_html_e('Manage Products', 'bfluxco'); ?></a></li>
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
 * - Post types (case_study, product, special_project)
 * - Taxonomies (industry, service_type)
 * - Sidebars (footer-1, footer-2, footer-3)
 * - Assets (styles, scripts, image sizes)
 *
 * Initialization Patterns Used:
 * 1. Static init: Most classes use BFLUXCO_*::init() for stateless utilities
 * 2. Singleton: Voice Narrative, Gemini Image use ::get_instance() for stateful single instances
 * 3. Constructor: Chatbot API uses new BFLUXCO_*() for stateful instance methods
 * 4. Static-only: AI Chat Settings/Training have no init (pure static utility methods)
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

// SEO & Structured Data (AEO) - Always needed for frontend
require_once get_template_directory() . '/inc/class-seo.php';
require_once get_template_directory() . '/inc/class-schema.php';

// Client Authentication - Needed before Client Access Manager
require_once get_template_directory() . '/inc/class-client-auth.php';

// Client Access Manager - Needed for protected case studies (frontend + admin)
require_once get_template_directory() . '/inc/class-client-access.php';

// ==========================================================================
// LAZY-LOADED FEATURES
// These features only load when needed to improve performance
// ==========================================================================

// Admin UI Classes - Admin only
if (is_admin()) {
    // Password Admin UI - Needed before Case Study Passwords
    require_once get_template_directory() . '/inc/admin/class-password-admin.php';

    // Client Admin UI - Extends Client Access functionality
    require_once get_template_directory() . '/inc/admin/class-client-admin.php';
}

// Case Study Password Manager - Admin only
if (is_admin()) {
    require_once get_template_directory() . '/inc/class-case-study-passwords.php';
}

// ==========================================================================
// AI CHAT - Plugin or Theme Fallback
// If the BFLUXCO AI Chat plugin is active, skip loading theme AI chat code
// ==========================================================================
$ai_chat_plugin_active = defined('BFLUXCO_AI_CHAT_VERSION') ||
    (function_exists('is_plugin_active') && is_plugin_active('bfluxco-ai-chat/bfluxco-ai-chat.php'));

if (!$ai_chat_plugin_active) {
    // Chatbot API - Only when enabled or in admin (THEME FALLBACK)
    $chatbot_enabled = get_option('bfluxco_chatbot_enabled', true);
    if ($chatbot_enabled || is_admin()) {
        require_once get_template_directory() . '/inc/class-chatbot-api.php';
    }

    // AI Chat Admin Suite - Admin only (THEME FALLBACK)
    if (is_admin()) {
        require_once get_template_directory() . '/inc/class-ai-chat-settings.php';
        require_once get_template_directory() . '/inc/class-ai-chat-metrics.php';
        require_once get_template_directory() . '/inc/class-ai-chat-training.php';
        require_once get_template_directory() . '/inc/class-ai-chat-admin.php';
    }
}

// Voice Narrative - Load for case studies or admin
if (is_admin()) {
    // Load immediately in admin for settings/editor
    require_once get_template_directory() . '/inc/class-voice-narrative.php';
} else {
    // Defer loading on frontend until we know it's a case study
    add_action('template_redirect', function() {
        if (is_singular('case_study')) {
            require_once get_template_directory() . '/inc/class-voice-narrative.php';
        }
    }, 1);
}

// Gemini Image Generation - Admin only
if (is_admin()) {
    require_once get_template_directory() . '/inc/class-gemini-image.php';
}

// ==========================================================================
// INTERVIEW RAYBOT API
// ==========================================================================

/**
 * Initialize Interview Raybot REST API
 *
 * Loads the Interview Raybot API classes and registers REST endpoints.
 * Only loads on rest_api_init to minimize frontend impact.
 *
 * @since 1.0.0
 */
function bfluxco_init_interview_api() {
    // Prevent double initialization.
    if ( class_exists( 'BFLUXCO_Interview_API' ) ) {
        return;
    }

    // Load required classes.
    require_once get_template_directory() . '/inc/class-interview-session.php';
    require_once get_template_directory() . '/inc/services/class-mock-heygen-service.php';
    require_once get_template_directory() . '/inc/class-interview-api.php';

    // Initialize API.
    new BFLUXCO_Interview_API();
}
add_action( 'rest_api_init', 'bfluxco_init_interview_api' );

/**
 * Conditional Asset Loading for Interview Raybot Page
 *
 * Enqueues JavaScript and localized data only on the Interview Raybot page.
 *
 * @since 1.0.0
 */
function bfluxco_interview_assets() {
    // Only load on interview raybot page template.
    if ( ! is_page_template( 'page-templates/template-interview-raybot.php' ) ) {
        return;
    }

    $script_path = get_template_directory() . '/assets/js/interview-raybot.js';

    // Only enqueue if script exists.
    if ( ! file_exists( $script_path ) ) {
        return;
    }

    wp_enqueue_script(
        'bfluxco-interview',
        get_template_directory_uri() . '/assets/js/interview-raybot.js',
        array(),
        filemtime( $script_path ),
        true
    );

    // Localize script with API data.
    wp_localize_script(
        'bfluxco-interview',
        'bfluxcoInterview',
        array(
            'restUrl'         => rest_url( 'bfluxco/v1/interview/' ),
            'nonce'           => wp_create_nonce( 'wp_rest' ),
            'sessionDuration' => 300, // 5 minutes
            'maxFollowups'    => 1,
        )
    );
}
add_action( 'wp_enqueue_scripts', 'bfluxco_interview_assets' );

// ==========================================================================
// SUPPORT FORM HANDLER
// ==========================================================================

/**
 * Handle Low Ox Life Support Form Submission
 *
 * Processes the contact form on /support/low-ox-life and sends
 * an email to the support team.
 */
function bfluxco_handle_support_form() {
    // Verify nonce for security
    if ( ! isset( $_POST['bfluxco_support_nonce'] ) ||
         ! wp_verify_nonce( $_POST['bfluxco_support_nonce'], 'bfluxco_support_form' ) ) {
        wp_safe_redirect( add_query_arg( 'status', 'error', wp_get_referer() ) );
        exit;
    }

    // Sanitize form inputs
    $name    = isset( $_POST['support_name'] ) ? sanitize_text_field( $_POST['support_name'] ) : '';
    $email   = isset( $_POST['support_email'] ) ? sanitize_email( $_POST['support_email'] ) : '';
    $subject = isset( $_POST['support_subject'] ) ? sanitize_text_field( $_POST['support_subject'] ) : 'Support Request';
    $message = isset( $_POST['support_message'] ) ? sanitize_textarea_field( $_POST['support_message'] ) : '';
    $app     = isset( $_POST['app'] ) ? sanitize_text_field( $_POST['app'] ) : 'unknown';

    // Validate required fields
    if ( empty( $name ) || empty( $email ) || empty( $message ) ) {
        wp_safe_redirect( add_query_arg( 'status', 'error', wp_get_referer() ) );
        exit;
    }

    // Build email
    $to = 'appsupport@bigfreightlife.com';
    $email_subject = sprintf( '[%s Support] %s', ucwords( str_replace( '-', ' ', $app ) ), $subject );

    $email_body = "New support request from the website:\n\n";
    $email_body .= "App: " . ucwords( str_replace( '-', ' ', $app ) ) . "\n";
    $email_body .= "Name: {$name}\n";
    $email_body .= "Email: {$email}\n";
    $email_body .= "Subject: {$subject}\n\n";
    $email_body .= "Message:\n{$message}\n";

    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'Reply-To: ' . $name . ' <' . $email . '>',
    );

    // Send email
    $sent = wp_mail( $to, $email_subject, $email_body, $headers );

    // Redirect back with status
    $status = $sent ? 'success' : 'error';
    wp_safe_redirect( add_query_arg( 'status', $status, wp_get_referer() ) );
    exit;
}
add_action( 'admin_post_bfluxco_support_submit', 'bfluxco_handle_support_form' );
add_action( 'admin_post_nopriv_bfluxco_support_submit', 'bfluxco_handle_support_form' );
