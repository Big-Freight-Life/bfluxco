<?php
/**
 * Template Name: Product - Low Ox Life
 * Template Post Type: page
 *
 * Product detail page for Low Ox Life iOS App (Paid Version).
 * URL: /products/low-ox-life
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
    'name'        => 'Low Ox Life',
    'slug'        => 'low-ox-life',
    'tagline'     => 'Oxalate Management Companion',
    'description' => 'Browse the complete Harvard 2023 Oxalate Table for free. Upgrade to Starter to log meals, track your daily oxalate intake, and sync across devices.',
    'category'    => 'iOS App',
    'version'     => '1.0',

    // Theme (product identity)
    'theme' => array(
        'accent'        => '#2D6A4F',
        'accent_rgb'    => '45, 106, 79',
        'hero_gradient' => 'linear-gradient(135deg, #1a3a2a 0%, #0d1b14 50%, #080f0c 100%)',
        'hero_glow'     => 'rgba(45, 106, 79, 0.15)',
    ),

    // Hero
    'hero_headline'    => 'Know Your Oxalates.',
    'hero_subheadline' => 'The only iOS app built on the Harvard 2023 Oxalate Table. Browse 400+ foods free, or upgrade to track your daily intake.',

    // Value Proposition
    'value_prop' => 'Low Ox Life gives you evidence-based oxalate data at your fingertips. Search the complete Harvard 2023 database, filter by oxalate level, log meals to your journal, and sync across every device — designed for people who take their health seriously.',

    // Pricing
    'price'          => 'Free',
    'original_price' => '',
    'price_note'     => 'Subscriptions starting at $4.99/month',
    'is_free'        => true,
    'availability'   => 'available',

    // Links
    'cta_url'        => 'https://apps.apple.com/us/app/low-ox-life-list/id6748654148',
    'cta_text'       => 'View in App Store',
    'cta_external'   => true,
    'secondary_url'  => 'https://www.facebook.com/groups/lowoxlife',
    'secondary_text' => 'Join Facebook Community',

    // Final CTA
    'cta_headline'    => 'Start Tracking Today',
    'cta_description' => 'Browse the Harvard 2023 Oxalate Table for free. Upgrade to Starter anytime to unlock food logging and cloud sync.',

    // Legal Links
    'legal_links' => array(
        array('label' => 'Privacy Policy', 'url' => home_url('/legal/low-ox-life-privacy')),
        array('label' => 'Terms of Service', 'url' => home_url('/legal/low-ox-life-terms')),
        array('label' => 'Support', 'url' => home_url('/support/low-ox-life')),
    ),

    // Images (pre-composited device mockups)
    'images' => array(
        array(
            'src' => get_template_directory_uri() . '/assets/images/lowoxlife-launch-device.png',
            'alt' => 'Low Ox Life - Oxalate management companion app launch screen',
        ),
        array(
            'src' => get_template_directory_uri() . '/assets/images/lowoxlife-foodlist-device.png',
            'alt' => 'Low Ox Life Foods - Browse Harvard 2023 database with search and oxalate level filters',
        ),
        array(
            'src' => get_template_directory_uri() . '/assets/images/lowoxlife-journal-device.png',
            'alt' => 'Low Ox Life Journal - Log meals and track daily oxalate intake with date navigation',
        ),
        array(
            'src' => get_template_directory_uri() . '/assets/images/lowoxlife-fooddatabase-device.png',
            'alt' => 'Low Ox Life Food Database - Manage databases and sync across devices',
        ),
    ),

    // Feature Spotlights (3 hero features with large imagery)
    'feature_spotlights' => array(
        array(
            'title'       => 'Harvard Database',
            'headline'    => '400+ Foods. One Search.',
            'desc'        => 'Browse the complete Harvard 2023 Oxalate Table with serving sizes and oxalate content for every food. Search instantly and filter by oxalate level.',
            'image_index' => 1,
            'background'  => 'light',
        ),
        array(
            'title'       => 'Food Journal',
            'headline'    => 'Log Meals. Track Intake.',
            'desc'        => 'Add foods to your daily journal with one tap. Track your total oxalate intake over time with date navigation and daily summaries.',
            'image_index' => 2,
            'background'  => 'dark',
        ),
        array(
            'title'       => 'Cloud Sync',
            'headline'    => 'Your Data. Every Device.',
            'desc'        => 'Sign in with Apple and your journal, favorites, and custom foods sync seamlessly across all your devices.',
            'image_index' => 3,
            'background'  => 'accent',
        ),
    ),

    // Secondary Features (remaining features for grid — spotlights removed)
    'features' => array(
        array(
            'title' => 'Quick Search',
            'desc'  => 'Find any food instantly with fast, responsive search.',
            'tier'  => 'Free',
            'icon'  => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>',
        ),
        array(
            'title' => 'Smart Filters',
            'desc'  => 'Filter by oxalate level (very low, low, moderate, high, very high).',
            'tier'  => 'Free',
            'icon'  => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>',
        ),
        array(
            'title' => 'Journal History',
            'desc'  => 'View past entries with date navigation.',
            'tier'  => 'Starter',
            'icon'  => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>',
        ),
        array(
            'title' => 'Custom Food Import',
            'desc'  => 'Import your own food lists from CSV files.',
            'tier'  => 'Pro',
            'icon'  => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>',
        ),
        array(
            'title' => 'Grocery Lists',
            'desc'  => 'Create and manage low-oxalate shopping lists.',
            'tier'  => 'Pro',
            'icon'  => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>',
        ),
        array(
            'title' => 'Insights & Trends',
            'desc'  => 'Review pattern-based insights and monitor progress over time.',
            'tier'  => 'Elite',
            'icon'  => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>',
        ),
        array(
            'title' => 'Recipe Builder',
            'desc'  => 'Create and save custom recipes with automatic oxalate calculations.',
            'tier'  => 'Elite',
            'icon'  => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 13.87A4 4 0 0 1 7.41 6a5.11 5.11 0 0 1 1.05-1.54 5 5 0 0 1 7.08 0A5.11 5.11 0 0 1 16.59 6 4 4 0 0 1 18 13.87V21H6Z"/><line x1="6" y1="17" x2="18" y2="17"/></svg>',
        ),
        array(
            'title' => 'Oscar AI Assistant',
            'desc'  => 'AI-powered guidance about oxalate management, powered by Google Gemini. Not medical advice.',
            'tier'  => 'Elite',
            'coming_soon' => true,
            'icon'  => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>',
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
                'Browse 400+ foods',
                'Harvard 2023 Oxalate Table',
                'Search & filter by level',
            ),
        ),
        array(
            'name'        => 'Starter',
            'price'       => '$4.99',
            'period'      => 'per month',
            'highlighted' => true,
            'badge'       => 'Most Popular',
            'features'    => array(
                'Everything in Free',
                'Food logging & journal',
                'Journal history',
                'Cloud sync across devices',
            ),
        ),
        array(
            'name'     => 'Pro',
            'price'    => '$9.99',
            'period'   => 'per month',
            'features' => array(
                'Everything in Starter',
                'Custom food imports (CSV)',
                'Grocery list builder',
            ),
        ),
        array(
            'name'     => 'Elite',
            'price'    => '$14.99',
            'period'   => 'per month',
            'features' => array(
                'Everything in Pro',
                'Insights & trends',
                'Recipe builder',
                'Oscar AI assistant',
            ),
        ),
    ),

    // FAQs
    'faqs' => array(
        array(
            'question' => 'What is Low Ox Life?',
            'answer'   => 'Low Ox Life is an iOS app for managing oxalate intake. It provides access to the Harvard 2023 Oxalate Table with 400+ foods, complete with serving sizes and oxalate content.',
        ),
        array(
            'question' => 'Is Low Ox Life free?',
            'answer'   => 'Yes, browsing the food database is completely free. The optional Starter subscription ($4.99/month or $49.99/year) adds food logging, journal history, and cloud sync.',
        ),
        array(
            'question' => 'What\'s included free vs Starter?',
            'answer'   => 'Free: Browse 400+ foods, search, and filter by oxalate level. Starter: Log food to your journal, view journal history with date navigation, and sync data across devices.',
        ),
        array(
            'question' => 'What about Pro and Elite subscriptions?',
            'answer'   => 'Pro ($9.99/month) adds custom food list imports and grocery lists. Elite ($14.99/month) adds insights and trends, recipe builder, and the Oscar AI assistant (coming soon).',
        ),
        array(
            'question' => 'Is Low Ox Life medical advice?',
            'answer'   => 'No. Low Ox Life is a tracking and reference tool for informational purposes only. Always consult your healthcare provider for medical guidance. This app does not diagnose, treat, or cure any condition.',
        ),
        array(
            'question' => 'What iOS version is required?',
            'answer'   => 'Low Ox Life requires iOS 16.7 or later and is available for iPhone.',
        ),
    ),

    // SEO
    'seo_title'       => 'Low Ox Life - Oxalate Tracking iOS App',
    'seo_description' => 'Low Ox Life iOS app - Browse 400+ foods from the Harvard 2023 Oxalate Table for free. Upgrade to Starter ($4.99/mo) for food logging, journal history, and cloud sync.',

    // Related
    'related' => array(
        array(
            'title' => 'Bio Break',
            'url'   => home_url('/products/bio-break/'),
            'price' => 'Free',
            'desc'  => 'Know Your Body Better',
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
        'operatingSystem' => 'iOS 16.7 or later',
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

    echo '<!-- Low Ox Life Product Schema -->' . "\n";
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
