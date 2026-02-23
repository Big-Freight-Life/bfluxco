<?php
/**
 * BFLUXCO SEO Class
 *
 * Handles meta descriptions, Open Graph tags, Twitter cards, and canonical URLs.
 * Outputs via wp_head hook for clean integration.
 *
 * @package BFLUXCO
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class BFLUXCO_SEO
 *
 * Core SEO functionality without plugin dependency.
 */
class BFLUXCO_SEO {

    /**
     * Singleton instance
     *
     * @var BFLUXCO_SEO|null
     */
    private static $instance = null;

    /**
     * Get singleton instance
     *
     * @return BFLUXCO_SEO
     */
    public static function init() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor - register hooks
     */
    private function __construct() {
        add_action('wp_head', array($this, 'output_meta_description'), 5);
        add_action('wp_head', array($this, 'output_og_tags'), 6);
        add_action('wp_head', array($this, 'output_twitter_tags'), 6);
        add_action('wp_head', array($this, 'output_canonical'), 7);
        add_action('wp_head', array($this, 'output_robots'), 8);
    }

    /**
     * Get meta description for current page
     *
     * @return string
     */
    public function get_meta_description() {
        // Check for custom meta description field first
        if (is_singular()) {
            $custom_desc = get_post_meta(get_the_ID(), '_bfluxco_meta_description', true);
            if (!empty($custom_desc)) {
                return $this->sanitize_meta_description($custom_desc);
            }
        }

        // Auto-generate based on page type
        if (is_front_page()) {
            return $this->sanitize_meta_description(get_bloginfo('description'));
        }

        if (is_singular()) {
            $post = get_post();
            if (has_excerpt()) {
                return $this->sanitize_meta_description(get_the_excerpt());
            }
            return $this->sanitize_meta_description($post->post_content);
        }

        if (is_category() || is_tag() || is_tax()) {
            $term = get_queried_object();
            if (!empty($term->description)) {
                return $this->sanitize_meta_description($term->description);
            }
            return $this->sanitize_meta_description(sprintf(
                __('Browse %s on %s', 'bfluxco'),
                single_term_title('', false),
                get_bloginfo('name')
            ));
        }

        if (is_post_type_archive()) {
            $post_type = get_post_type_object(get_query_var('post_type'));
            if ($post_type) {
                return $this->sanitize_meta_description(sprintf(
                    __('Browse all %s from %s', 'bfluxco'),
                    $post_type->labels->name,
                    get_bloginfo('name')
                ));
            }
        }

        if (is_author()) {
            $author = get_queried_object();
            $bio = get_the_author_meta('description', $author->ID);
            if (!empty($bio)) {
                return $this->sanitize_meta_description($bio);
            }
            return $this->sanitize_meta_description(sprintf(
                __('Posts by %s on %s', 'bfluxco'),
                $author->display_name,
                get_bloginfo('name')
            ));
        }

        if (is_search()) {
            return $this->sanitize_meta_description(sprintf(
                __('Search results for "%s" on %s', 'bfluxco'),
                esc_html(get_search_query()),
                get_bloginfo('name')
            ));
        }

        // Default fallback
        return $this->sanitize_meta_description(get_bloginfo('description'));
    }

    /**
     * Sanitize and truncate meta description
     *
     * @param string $text Raw text
     * @param int $max_length Maximum length (default 160)
     * @return string
     */
    private function sanitize_meta_description($text, $max_length = 160) {
        // Strip HTML and shortcodes
        $text = wp_strip_all_tags($text);
        $text = strip_shortcodes($text);

        // Normalize whitespace
        $text = preg_replace('/\s+/', ' ', $text);
        $text = trim($text);

        // Truncate if needed
        if (mb_strlen($text) > $max_length) {
            $text = mb_substr($text, 0, $max_length - 3);
            // Cut at last word boundary
            $last_space = mb_strrpos($text, ' ');
            if ($last_space !== false && $last_space > $max_length - 30) {
                $text = mb_substr($text, 0, $last_space);
            }
            $text .= '...';
        }

        return esc_attr($text);
    }

    /**
     * Output meta description tag
     */
    public function output_meta_description() {
        $description = $this->get_meta_description();
        if (!empty($description)) {
            printf('<meta name="description" content="%s">' . "\n", $description);
        }
    }

    /**
     * Get OG image URL
     *
     * @return string
     */
    public function get_og_image() {
        if (is_singular() && has_post_thumbnail()) {
            $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
            if ($image) {
                return $image[0];
            }
        }

        // Fallback to customizer default OG image
        $default_og = get_theme_mod('bfluxco_seo_default_og_image', '');
        if (!empty($default_og)) {
            return $default_og;
        }

        // Ultimate fallback to site logo or theme asset
        $custom_logo_id = get_theme_mod('custom_logo');
        if ($custom_logo_id) {
            $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
            if ($logo) {
                return $logo[0];
            }
        }

        return '';
    }

    /**
     * Get page title for meta tags
     *
     * @return string
     */
    public function get_page_title() {
        if (is_front_page()) {
            return get_bloginfo('name');
        }

        if (is_singular()) {
            return get_the_title();
        }

        if (is_category() || is_tag() || is_tax()) {
            return single_term_title('', false);
        }

        if (is_post_type_archive()) {
            return post_type_archive_title('', false);
        }

        if (is_author()) {
            return get_the_author();
        }

        if (is_search()) {
            return sprintf(__('Search: %s', 'bfluxco'), esc_html(get_search_query()));
        }

        return get_bloginfo('name');
    }

    /**
     * Get OG type
     *
     * @return string
     */
    public function get_og_type() {
        if (is_singular('post')) {
            return 'article';
        }
        if (is_singular('case_study')) {
            return 'article';
        }
        return 'website';
    }

    /**
     * Get canonical URL
     *
     * @return string
     */
    public function get_canonical_url() {
        if (is_singular()) {
            return get_permalink();
        }

        if (is_front_page()) {
            return home_url('/');
        }

        if (is_category() || is_tag() || is_tax()) {
            return get_term_link(get_queried_object());
        }

        if (is_post_type_archive()) {
            return get_post_type_archive_link(get_query_var('post_type'));
        }

        if (is_author()) {
            return get_author_posts_url(get_queried_object_id());
        }

        if (is_search()) {
            return home_url('/') . '?s=' . urlencode(get_search_query());
        }

        // Handle pagination
        global $wp;
        $current_url = home_url(add_query_arg(array(), $wp->request));

        return trailingslashit($current_url);
    }

    /**
     * Output Open Graph tags
     */
    public function output_og_tags() {
        $title = $this->get_page_title();
        $description = $this->get_meta_description();
        $url = $this->get_canonical_url();
        $image = $this->get_og_image();
        $type = $this->get_og_type();
        $site_name = get_bloginfo('name');

        echo '<!-- Open Graph -->' . "\n";
        printf('<meta property="og:type" content="%s">' . "\n", esc_attr($type));
        printf('<meta property="og:title" content="%s">' . "\n", esc_attr($title));
        printf('<meta property="og:description" content="%s">' . "\n", esc_attr($description));
        printf('<meta property="og:url" content="%s">' . "\n", esc_url($url));
        printf('<meta property="og:site_name" content="%s">' . "\n", esc_attr($site_name));
        printf('<meta property="og:locale" content="%s">' . "\n", esc_attr(get_locale()));

        if (!empty($image)) {
            printf('<meta property="og:image" content="%s">' . "\n", esc_url($image));
            printf('<meta property="og:image:width" content="1200">' . "\n");
            printf('<meta property="og:image:height" content="630">' . "\n");
        }

        // Article-specific OG tags
        if (is_singular('post') || is_singular('case_study')) {
            printf('<meta property="article:published_time" content="%s">' . "\n", esc_attr(get_the_date('c')));
            printf('<meta property="article:modified_time" content="%s">' . "\n", esc_attr(get_the_modified_date('c')));

            if (is_singular('post')) {
                $author = get_the_author();
                printf('<meta property="article:author" content="%s">' . "\n", esc_attr($author));
            }
        }
    }

    /**
     * Output Twitter Card tags
     */
    public function output_twitter_tags() {
        $title = $this->get_page_title();
        $description = $this->get_meta_description();
        $image = $this->get_og_image();
        $twitter_handle = get_theme_mod('bfluxco_seo_twitter_handle', '');

        echo '<!-- Twitter Card -->' . "\n";
        echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
        printf('<meta name="twitter:title" content="%s">' . "\n", esc_attr($title));
        printf('<meta name="twitter:description" content="%s">' . "\n", esc_attr($description));

        if (!empty($image)) {
            printf('<meta name="twitter:image" content="%s">' . "\n", esc_url($image));
        }

        if (!empty($twitter_handle)) {
            $handle = ltrim($twitter_handle, '@');
            printf('<meta name="twitter:site" content="@%s">' . "\n", esc_attr($handle));
            printf('<meta name="twitter:creator" content="@%s">' . "\n", esc_attr($handle));
        }
    }

    /**
     * Output canonical URL
     */
    public function output_canonical() {
        $canonical = $this->get_canonical_url();
        if (!empty($canonical)) {
            printf('<link rel="canonical" href="%s">' . "\n", esc_url($canonical));
        }
    }

    /**
     * Output robots meta tag
     */
    public function output_robots() {
        // Let search pages and archives with no content be noindexed
        if (is_search()) {
            echo '<meta name="robots" content="noindex, follow">' . "\n";
            return;
        }

        // Default: allow indexing
        echo '<meta name="robots" content="index, follow">' . "\n";
    }
}

// Initialize
BFLUXCO_SEO::init();
