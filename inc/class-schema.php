<?php
/**
 * BFLUXCO Schema Class
 *
 * Generates JSON-LD structured data for AEO (Answer Engine Optimization).
 * Outputs schema.org markup via wp_head hook.
 *
 * @package BFLUXCO
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class BFLUXCO_Schema
 *
 * Structured data generator for AI answer engines and search.
 */
class BFLUXCO_Schema {

    /**
     * Collected schemas to output
     *
     * @var array
     */
    private static $schemas = array();

    /**
     * Initialize schema collection and output
     */
    public static function init() {
        add_action('wp', array(__CLASS__, 'collect_schemas'));
        add_action('wp_head', array(__CLASS__, 'output_schemas'), 1);
    }

    /**
     * Collect all relevant schemas for current page
     */
    public static function collect_schemas() {
        // Always add Organization schema
        self::add('organization', self::get_organization_schema());

        // Homepage: add WebSite schema
        if (is_front_page()) {
            self::add('website', self::get_website_schema());
        }

        // Blog posts: add Article schema
        if (is_singular('post')) {
            self::add('article', self::get_article_schema());
        }

        // Case studies: add CreativeWork schema
        if (is_singular('case_study')) {
            self::add('casestudy', self::get_case_study_schema());
        }

        // Support/FAQ page: add FAQPage schema
        if (is_page_template('page-templates/template-support.php')) {
            self::add('faq', self::get_faq_schema());
        }

        // All singular content: add BreadcrumbList schema
        if (is_singular()) {
            self::add('breadcrumb', self::get_breadcrumb_schema());
        }
    }

    /**
     * Add a schema to the collection
     *
     * @param string $key Unique identifier
     * @param array $schema Schema data
     */
    public static function add($key, $schema) {
        if (!empty($schema)) {
            self::$schemas[$key] = $schema;
        }
    }

    /**
     * Output all collected schemas
     */
    public static function output_schemas() {
        if (empty(self::$schemas)) {
            return;
        }

        echo '<!-- Schema.org JSON-LD -->' . "\n";

        foreach (self::$schemas as $schema) {
            if (!empty($schema)) {
                printf(
                    '<script type="application/ld+json">%s</script>' . "\n",
                    wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
                );
            }
        }
    }

    /**
     * Get Organization schema
     *
     * @return array
     */
    private static function get_organization_schema() {
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            '@id' => home_url('/#organization'),
            'name' => get_bloginfo('name'),
            'url' => home_url('/'),
        );

        // Add logo if available
        $custom_logo_id = get_theme_mod('custom_logo');
        if ($custom_logo_id) {
            $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
            if ($logo) {
                $schema['logo'] = array(
                    '@type' => 'ImageObject',
                    'url' => $logo[0],
                    'width' => $logo[1],
                    'height' => $logo[2],
                );
            }
        }

        // Add contact email if set in customizer
        $email = get_theme_mod('bfluxco_contact_email', '');
        if (!empty($email)) {
            $schema['contactPoint'] = array(
                '@type' => 'ContactPoint',
                'contactType' => 'customer service',
                'email' => $email,
            );
        }

        // Add social profiles
        $social_links = self::get_social_links();
        if (!empty($social_links)) {
            $schema['sameAs'] = $social_links;
        }

        return $schema;
    }

    /**
     * Get WebSite schema (homepage only)
     *
     * @return array
     */
    private static function get_website_schema() {
        return array(
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            '@id' => home_url('/#website'),
            'url' => home_url('/'),
            'name' => get_bloginfo('name'),
            'description' => get_bloginfo('description'),
            'publisher' => array(
                '@id' => home_url('/#organization'),
            ),
            'potentialAction' => array(
                '@type' => 'SearchAction',
                'target' => home_url('/?s={search_term_string}'),
                'query-input' => 'required name=search_term_string',
            ),
        );
    }

    /**
     * Get BlogPosting schema for blog posts
     *
     * @return array
     */
    private static function get_article_schema() {
        $post = get_post();
        if (!$post) {
            return array();
        }

        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            '@id' => get_permalink() . '#blogposting',
            'headline' => get_the_title(),
            'description' => self::get_description($post),
            'datePublished' => get_the_date('c'),
            'dateModified' => get_the_modified_date('c'),
            'mainEntityOfPage' => array(
                '@type' => 'WebPage',
                '@id' => get_permalink(),
            ),
            'publisher' => array(
                '@id' => home_url('/#organization'),
            ),
        );

        // Add author
        $author_id = $post->post_author;
        $schema['author'] = array(
            '@type' => 'Person',
            'name' => get_the_author_meta('display_name', $author_id),
            'url' => get_author_posts_url($author_id),
        );

        // Add featured image
        if (has_post_thumbnail()) {
            $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
            if ($image) {
                $schema['image'] = array(
                    '@type' => 'ImageObject',
                    'url' => $image[0],
                    'width' => $image[1],
                    'height' => $image[2],
                );
            }
        }

        // Add word count
        $word_count = str_word_count(strip_tags($post->post_content));
        $schema['wordCount'] = $word_count;

        // Add categories as articleSection
        $categories = get_the_category();
        if (!empty($categories)) {
            $schema['articleSection'] = $categories[0]->name;
        }

        // Add tags as keywords
        $tags = get_the_tags();
        if (!empty($tags)) {
            $schema['keywords'] = implode(', ', wp_list_pluck($tags, 'name'));
        }

        return $schema;
    }

    /**
     * Get CreativeWork schema for case studies
     *
     * @return array
     */
    private static function get_case_study_schema() {
        $post = get_post();
        if (!$post) {
            return array();
        }

        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'CreativeWork',
            '@id' => get_permalink() . '#casestudy',
            'name' => get_the_title(),
            'description' => self::get_description($post),
            'datePublished' => get_the_date('c'),
            'dateModified' => get_the_modified_date('c'),
            'author' => array(
                '@id' => home_url('/#organization'),
            ),
            'publisher' => array(
                '@id' => home_url('/#organization'),
            ),
        );

        // Add featured image
        if (has_post_thumbnail()) {
            $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
            if ($image) {
                $schema['image'] = $image[0];
            }
        }

        // Add client as "about"
        $client = get_post_meta(get_the_ID(), 'case_study_client', true);
        if (!empty($client)) {
            $schema['about'] = array(
                '@type' => 'Organization',
                'name' => $client,
            );
        }

        // Add industries as genre
        $industries = get_the_terms(get_the_ID(), 'industry');
        if ($industries && !is_wp_error($industries)) {
            $schema['genre'] = wp_list_pluck($industries, 'name');
        }

        // Add service types as keywords
        $services = get_the_terms(get_the_ID(), 'service_type');
        if ($services && !is_wp_error($services)) {
            $schema['keywords'] = implode(', ', wp_list_pluck($services, 'name'));
        }

        // Add custom properties (timeline, role, results)
        $additional_properties = array();

        $timeline = get_post_meta(get_the_ID(), 'case_study_timeline', true);
        if (!empty($timeline)) {
            $additional_properties[] = array(
                '@type' => 'PropertyValue',
                'name' => 'Timeline',
                'value' => $timeline,
            );
        }

        $role = get_post_meta(get_the_ID(), 'case_study_role', true);
        if (!empty($role)) {
            $additional_properties[] = array(
                '@type' => 'PropertyValue',
                'name' => 'Role',
                'value' => $role,
            );
        }

        $results = get_post_meta(get_the_ID(), 'case_study_results', true);
        if (!empty($results)) {
            $additional_properties[] = array(
                '@type' => 'PropertyValue',
                'name' => 'Results',
                'value' => wp_strip_all_tags($results),
            );
        }

        if (!empty($additional_properties)) {
            $schema['additionalProperty'] = $additional_properties;
        }

        return $schema;
    }

    /**
     * Get FAQPage schema
     *
     * @return array
     */
    private static function get_faq_schema() {
        $faq_items = self::get_faq_items();

        if (empty($faq_items)) {
            return array();
        }

        $main_entity = array();
        foreach ($faq_items as $item) {
            $main_entity[] = array(
                '@type' => 'Question',
                'name' => $item['question'],
                'acceptedAnswer' => array(
                    '@type' => 'Answer',
                    'text' => $item['answer'],
                ),
            );
        }

        return array(
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => $main_entity,
        );
    }

    /**
     * Get FAQ items for schema and template use
     *
     * @return array
     */
    public static function get_faq_items() {
        return array(
            array(
                'question' => __('What services do you offer?', 'bfluxco'),
                'answer' => __('I offer strategic design consulting, workshops, and products. This includes case study work, team facilitation workshops, and various tools and frameworks to help businesses solve complex challenges.', 'bfluxco'),
            ),
            array(
                'question' => __('How do I get started with a project?', 'bfluxco'),
                'answer' => __("The best way to get started is to reach out through the contact page. Share a brief overview of your project or challenge, and I'll get back to you within 1-2 business days to schedule an initial conversation.", 'bfluxco'),
            ),
            array(
                'question' => __('What is your typical project timeline?', 'bfluxco'),
                'answer' => __("Project timelines vary depending on scope and complexity. Workshops typically range from half-day to multi-day sessions. Consulting engagements can be a few weeks to several months. We'll discuss specific timelines during our initial conversation.", 'bfluxco'),
            ),
            array(
                'question' => __('Do you work with remote teams?', 'bfluxco'),
                'answer' => __('Yes! I work with teams both in-person and remotely. Many workshops and consulting sessions can be conducted virtually using video conferencing and collaborative tools.', 'bfluxco'),
            ),
            array(
                'question' => __('How can I stay updated on new content?', 'bfluxco'),
                'answer' => __('Follow me on social media or check back regularly for new case studies, workshop offerings, and products. You can also reach out via the contact page to be added to the mailing list.', 'bfluxco'),
            ),
        );
    }

    /**
     * Get BreadcrumbList schema
     *
     * @return array
     */
    private static function get_breadcrumb_schema() {
        $breadcrumbs = self::build_breadcrumb_items();

        if (count($breadcrumbs) < 2) {
            return array();
        }

        $items = array();
        $position = 1;

        foreach ($breadcrumbs as $crumb) {
            $item = array(
                '@type' => 'ListItem',
                'position' => $position,
                'name' => $crumb['name'],
            );

            if (!empty($crumb['url'])) {
                $item['item'] = $crumb['url'];
            }

            $items[] = $item;
            $position++;
        }

        return array(
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $items,
        );
    }

    /**
     * Build breadcrumb items array
     *
     * @return array
     */
    private static function build_breadcrumb_items() {
        $breadcrumbs = array();

        // Always start with Home
        $breadcrumbs[] = array(
            'name' => __('Home', 'bfluxco'),
            'url' => home_url('/'),
        );

        if (is_singular('post')) {
            // Blog post: Home > Blog > Post Title
            $breadcrumbs[] = array(
                'name' => __('Blog', 'bfluxco'),
                'url' => get_permalink(get_option('page_for_posts')),
            );
            $breadcrumbs[] = array(
                'name' => get_the_title(),
                'url' => '',
            );
        } elseif (is_singular('case_study')) {
            // Case study: Home > Work > Case Studies > Title
            $breadcrumbs[] = array(
                'name' => __('Work', 'bfluxco'),
                'url' => home_url('/work/'),
            );
            $breadcrumbs[] = array(
                'name' => __('Case Studies', 'bfluxco'),
                'url' => home_url('/work/case-studies/'),
            );
            $breadcrumbs[] = array(
                'name' => get_the_title(),
                'url' => '',
            );
        } elseif (is_singular('workshop')) {
            // Workshop: Home > Work > Workshops > Title
            $breadcrumbs[] = array(
                'name' => __('Work', 'bfluxco'),
                'url' => home_url('/work/'),
            );
            $breadcrumbs[] = array(
                'name' => __('Workshops', 'bfluxco'),
                'url' => home_url('/work/workshops/'),
            );
            $breadcrumbs[] = array(
                'name' => get_the_title(),
                'url' => '',
            );
        } elseif (is_singular('product')) {
            // Product: Home > Work > Products > Title
            $breadcrumbs[] = array(
                'name' => __('Work', 'bfluxco'),
                'url' => home_url('/work/'),
            );
            $breadcrumbs[] = array(
                'name' => __('Products', 'bfluxco'),
                'url' => home_url('/work/products/'),
            );
            $breadcrumbs[] = array(
                'name' => get_the_title(),
                'url' => '',
            );
        } elseif (is_page()) {
            // Regular page: check for parent
            $post = get_post();
            if ($post->post_parent) {
                $ancestors = get_post_ancestors($post);
                $ancestors = array_reverse($ancestors);
                foreach ($ancestors as $ancestor_id) {
                    $breadcrumbs[] = array(
                        'name' => get_the_title($ancestor_id),
                        'url' => get_permalink($ancestor_id),
                    );
                }
            }
            $breadcrumbs[] = array(
                'name' => get_the_title(),
                'url' => '',
            );
        }

        return $breadcrumbs;
    }

    /**
     * Get description for schema
     *
     * @param WP_Post $post Post object
     * @return string
     */
    private static function get_description($post) {
        if (has_excerpt($post)) {
            return wp_strip_all_tags(get_the_excerpt($post));
        }

        $content = wp_strip_all_tags($post->post_content);
        $content = strip_shortcodes($content);
        $content = preg_replace('/\s+/', ' ', $content);
        $content = trim($content);

        if (mb_strlen($content) > 200) {
            $content = mb_substr($content, 0, 197) . '...';
        }

        return $content;
    }

    /**
     * Get social links from customizer or hardcoded
     *
     * @return array
     */
    private static function get_social_links() {
        $links = array();

        // Try to get from customizer
        $linkedin = get_theme_mod('bfluxco_social_linkedin', '');
        $twitter = get_theme_mod('bfluxco_social_twitter', '');

        if (!empty($linkedin)) {
            $links[] = $linkedin;
        }

        if (!empty($twitter)) {
            $links[] = $twitter;
        }

        return $links;
    }
}

// Initialize
BFLUXCO_Schema::init();
