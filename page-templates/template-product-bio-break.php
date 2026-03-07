<?php
/**
 * Template Name: Product - Bio Break
 * Template Post Type: page
 *
 * Product detail page for Bio Break iOS App.
 * URL: /products/bio-break
 *
 * SEO/AEO Optimized with MobileApplication schema
 *
 * @package BFLUXCO
 */

// =============================================================================
// PRODUCT DATA CONFIGURATION
// =============================================================================

$product = array(
    // Basic Info
    'name'        => 'Bio Break',
    'slug'        => 'bio-break',
    'tagline'     => 'Know Your Body Better',
    'description' => 'Track bathroom habits to gain insights into hydration, digestive health, and wellness patterns. Log in seconds on iPhone or Apple Watch, understand your body, and share reports with your doctor.',
    'category'    => 'iOS App',
    'version'     => '1.0',

    // Theme (product identity)
    'theme' => array(
        'accent'        => '#0891B2',
        'accent_rgb'    => '8, 145, 178',
        'hero_gradient' => 'linear-gradient(135deg, #0c3d4a 0%, #0a2333 50%, #061520 100%)',
        'hero_glow'     => 'rgba(8, 145, 178, 0.15)',
    ),

    // Hero
    'hero_headline'    => 'Know Your Body Better.',
    'hero_subheadline' => 'Track bathroom habits on iPhone and Apple Watch. Understand your hydration, digestive patterns, and share reports with your doctor.',

    // Value Proposition
    'value_prop' => 'Bathroom habits say a lot about your health — but tracking them shouldn\'t feel awkward. Bio Break makes it simple, private, and insightful. Log in seconds, understand your patterns, and take better care of your body.',

    // Pricing
    'price'          => 'Free',
    'original_price' => '',
    'price_note'     => 'Pro upgrade $4.99/month',
    'is_free'        => true,
    'availability'   => 'available',

    // Links
    'cta_url'        => '#', // TODO: Replace with actual App Store URL when Bio Break is published
    'cta_text'       => 'View in App Store',
    'cta_external'   => true,
    'secondary_url'  => '',
    'secondary_text' => '',

    // Final CTA
    'cta_headline'    => 'Start Tracking for Free',
    'cta_description' => 'Download Bio Break and start understanding your body. Upgrade to Pro anytime for insights, doctor reports, and iCloud sync.',

    // Legal Links
    'legal_links' => array(
        array('label' => 'Privacy Policy', 'url' => home_url('/legal/bio-break-privacy')),
        array('label' => 'Terms of Service', 'url' => home_url('/legal/bio-break-terms')),
        array('label' => 'Support', 'url' => home_url('/support/bio-break')),
    ),

    // Hero layout (dual-device: iPhone + Apple Watch side by side)
    'hero_layout' => 'dual-device',

    // Images (pre-composited device mockups in assets/images/)
    'images' => array(
        array(
            'src' => get_template_directory_uri() . '/assets/images/biobreak-today-device.png',
            'alt' => 'Bio Break Today dashboard - Ring chart showing daily progress with Log BB1 and BB2 buttons',
        ),
        array(
            'src' => get_template_directory_uri() . '/assets/images/biobreak-insights-device.png',
            'alt' => 'Bio Break Insights - Activity trends, 7-day chart, and hydration analysis',
        ),
        array(
            'src' => get_template_directory_uri() . '/assets/images/biobreak-reports-device.png',
            'alt' => 'Bio Break Reports - Weekly activity charts and Bristol Stool distribution',
        ),
        array(
            'src' => get_template_directory_uri() . '/assets/images/biobreak-history-device.png',
            'alt' => 'Bio Break History - Detailed log entries with timestamps, color, and urgency',
        ),
    ),

    // Apple Watch hero image (displayed alongside iPhone in dual-device hero)
    'hero_watch_image' => array(
        'src' => get_template_directory_uri() . '/assets/images/biobreak-watch-device.png',
        'alt' => 'Bio Break on Apple Watch Ultra 2 - Log BB1 and view activity from your wrist',
    ),

    // Feature Spotlights (3 hero features with large imagery)
    'feature_spotlights' => array(
        array(
            'title'       => 'Pattern Insights',
            'headline'    => 'Understand Your Patterns.',
            'desc'        => 'See your activity trends over time with daily comparison charts, 7-day averages, and intelligent hydration insights powered by your data.',
            'image_index' => 1,
            'background'  => 'light',
        ),
        array(
            'title'       => 'Weekly Reports',
            'headline'    => 'Share With Your Doctor.',
            'desc'        => 'Professional weekly and monthly reports with activity charts, Bristol Stool distribution, and symptom tracking — ready to export as CSV or PDF.',
            'image_index' => 2,
            'background'  => 'dark',
        ),
        array(
            'title'       => 'Activity History',
            'headline'    => 'Every Break. Tracked.',
            'desc'        => 'Detailed log with timestamps, urine color, urgency, water intake, and notes. Filter by type and navigate by date.',
            'image_index' => 3,
            'background'  => 'accent',
        ),
    ),

    // Secondary Features (remaining features for grid — spotlights removed)
    'features' => array(
        array(
            'title' => 'Bristol Stool Scale',
            'desc'  => 'Medical-grade reference built in. Track bowel movements using the standard Bristol Stool Scale (Types 1-7).',
            'tier'  => 'Free',
            'icon'  => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11H4a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1v-8a1 1 0 0 0-1-1h-5"/><path d="M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3"/><line x1="12" y1="15" x2="12" y2="15.01"/></svg>',
        ),
        array(
            'title' => 'Calendar Heat Map',
            'desc'  => 'Visualize your patterns at a glance with a color-coded calendar view.',
            'tier'  => 'Free',
            'icon'  => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>',
        ),
        array(
            'title' => 'Smart Reminders',
            'desc'  => 'Hydration reminders with quiet hours so you only get nudged when it matters.',
            'tier'  => 'Free',
            'icon'  => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>',
        ),
        array(
            'title' => 'Pattern Insights',
            'desc'  => 'Trend analysis and pattern-based insights to help you understand your body over time.',
            'tier'  => 'Pro',
            'icon'  => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>',
        ),
        array(
            'title' => 'Community Stats',
            'desc'  => 'Compare your patterns against anonymous, aggregated community averages. Fully opt-in.',
            'tier'  => 'Pro',
            'icon'  => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
        ),
        array(
            'title' => 'Doctor Reports',
            'desc'  => 'Export CSV/PDF reports to share with your healthcare provider. Professional-grade documentation.',
            'tier'  => 'Pro',
            'icon'  => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>',
        ),
        array(
            'title' => 'iCloud Sync',
            'desc'  => 'Sync your data across iPhone and Apple Watch with end-to-end encrypted iCloud.',
            'tier'  => 'Pro',
            'icon'  => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"/></svg>',
        ),
    ),

    // Pricing Tiers
    'pricing_subtitle' => 'Start free. Upgrade when you\'re ready.',
    'pricing_tiers' => array(
        array(
            'name'     => 'Free',
            'price'    => '$0',
            'period'   => 'forever',
            'features' => array(
                'Hydration dashboard',
                'Quick logging (both types)',
                'Bristol Stool Scale',
                'Calendar heat map',
                'Smart reminders',
                'Apple Watch companion app',
            ),
        ),
        array(
            'name'        => 'Pro',
            'price'       => '$4.99',
            'period'      => 'per month',
            'highlighted' => true,
            'badge'       => 'Full Experience',
            'features'    => array(
                'Everything in Free',
                'Pattern insights & trends',
                'Community stats comparison',
                'CSV/PDF doctor reports',
                'iCloud sync across devices',
            ),
        ),
    ),

    // FAQs
    'faqs' => array(
        array(
            'question' => 'What is Bio Break?',
            'answer'   => 'Bio Break is a health tracking app that helps you monitor bathroom habits to gain insights into hydration levels, digestive health, and overall wellness patterns. It works on iPhone and Apple Watch.',
        ),
        array(
            'question' => 'Is Bio Break free?',
            'answer'   => 'Yes. The free tier includes a hydration dashboard, quick logging for both types, calendar heat map, Bristol Stool Scale reference, smart reminders, and the full Apple Watch companion app.',
        ),
        array(
            'question' => 'What does Pro add?',
            'answer'   => 'Pro ($4.99/month) adds pattern insights with trend analysis, anonymous community stats comparison, CSV/PDF doctor reports, and iCloud sync across all your devices.',
        ),
        array(
            'question' => 'Is my data private?',
            'answer'   => 'Absolutely. Bio Break is private by default — all data is encrypted at rest on your device. There are no ads, no third-party analytics, and no tracking. iCloud sync uses end-to-end encryption.',
        ),
        array(
            'question' => 'Does it work on Apple Watch?',
            'answer'   => 'Yes. The full Apple Watch companion app lets you log breaks, view time since last break, see today\'s count, and check your 7-day average — all from your wrist. It includes 4 complication families.',
        ),
        array(
            'question' => 'Is Bio Break medical advice?',
            'answer'   => 'No. Bio Break is for informational and tracking purposes only. The Bristol Stool Scale and urine color references should not replace professional medical evaluation. Always consult a qualified healthcare provider.',
        ),
    ),

    // SEO
    'seo_title'       => 'Bio Break - Bathroom Health Tracking iOS App',
    'seo_description' => 'Bio Break iOS app — Track bathroom habits to understand hydration and digestive health. Free with Apple Watch companion. Pro upgrade adds insights, doctor reports, and iCloud sync.',

    // Related
    'related' => array(
        array(
            'title' => 'Low Ox Life',
            'url'   => home_url('/products/low-ox-life'),
            'price' => 'Free',
            'desc'  => 'Oxalate tracking companion',
        ),
    ),
);

// =============================================================================
// SEO & SCHEMA SETUP
// =============================================================================

add_filter('document_title_parts', function($title) use ($product) {
    $title['title'] = $product['seo_title'];
    return $title;
});

add_action('wp_head', function() use ($product) {
    // Meta description
    echo '<meta name="description" content="' . esc_attr($product['seo_description']) . '">' . "\n";

    // Build featureList from spotlights + features
    $feature_list = array_map(function($s) { return $s['headline']; }, $product['feature_spotlights']);
    foreach ($product['features'] as $f) {
        $feature_list[] = $f['title'] . ': ' . $f['desc'];
    }

    // MobileApplication Schema
    $schema = array(
        '@context' => 'https://schema.org',
        '@type'    => 'MobileApplication',
        '@id'      => get_permalink() . '#app',
        'name'     => $product['name'],
        'description' => $product['description'],
        'applicationCategory' => 'HealthApplication',
        'operatingSystem' => 'iOS 17 or later',
        'offers'   => array(
            '@type'         => 'Offer',
            'price'         => '0',
            'priceCurrency' => 'USD',
            'availability'  => 'https://schema.org/InStock',
        ),
        'author' => array(
            '@type' => 'Organization',
            'name'  => 'Big Freight Life',
            'url'   => home_url('/'),
        ),
        'featureList' => array_slice($feature_list, 0, 10),
    );

    echo '<!-- Bio Break Product Schema -->' . "\n";
    printf('<script type="application/ld+json">%s</script>' . "\n",
        wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

    // FAQ Schema
    $faq_schema = array(
        '@context' => 'https://schema.org',
        '@type'    => 'FAQPage',
        'mainEntity' => array_map(function($faq) {
            return array(
                '@type' => 'Question',
                'name'  => $faq['question'],
                'acceptedAnswer' => array(
                    '@type' => 'Answer',
                    'text'  => $faq['answer'],
                ),
            );
        }, $product['faqs']),
    );

    printf('<script type="application/ld+json">%s</script>' . "\n",
        wp_json_encode($faq_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
}, 2);

global $bfluxco_product_tagline, $bfluxco_product_category;
$bfluxco_product_tagline = $product['tagline'];
$bfluxco_product_category = $product['category'];

get_header();

get_template_part('template-parts/product-showcase', null, $product);

get_footer();
