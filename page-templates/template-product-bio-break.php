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
    'tagline'     => 'Know Your Body Better',
    'description' => 'Track bathroom habits to gain insights into hydration, digestive health, and wellness patterns. Log in seconds on iPhone or Apple Watch, understand your body, and share reports with your doctor.',
    'category'    => 'iOS App',
    'version'     => '1.0',

    // Pricing
    'price'          => 'Free',
    'original_price' => '',
    'price_note'     => 'Pro upgrade $4.99/month',
    'is_free'        => true,
    'availability'   => 'available',

    // Links
    'cta_url'        => '#',
    'cta_text'       => 'View in App Store',
    'cta_external'   => true,
    'secondary_url'  => '',
    'secondary_text' => '',

    // Images
    'images' => array(
        array(
            'src' => '/wp-content/uploads/2026/03/biobreak-dashboard.png',
            'alt' => 'Bio Break Dashboard - Real-time hydration status and daily break count',
        ),
        array(
            'src' => '/wp-content/uploads/2026/03/biobreak-log.png',
            'alt' => 'Bio Break Quick Log - Log bathroom visits in seconds with urgency and color',
        ),
        array(
            'src' => '/wp-content/uploads/2026/03/biobreak-watch.png',
            'alt' => 'Bio Break Apple Watch - Log breaks and view stats right from your wrist',
        ),
    ),

    // Rating (none yet - new app)
    'rating'       => '',
    'rating_count' => '',

    // Quick Highlights
    'highlights' => array(
        'Log breaks in seconds',
        'Apple Watch companion app',
        'Private by default — no tracking',
    ),

    // Features
    'features' => array(
        // FREE TIER
        array(
            'title' => 'Hydration Dashboard',
            'desc'  => 'Real-time hydration status with color-coded indicators based on urine color and frequency.',
            'tier'  => 'Free',
            'icon'  => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/></svg>',
        ),
        array(
            'title' => 'Quick Logging',
            'desc'  => 'Log bathroom visits with timestamp, urgency, pain indicator, and optional notes in seconds.',
            'tier'  => 'Free',
            'icon'  => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>',
        ),
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
            'title' => 'Apple Watch App',
            'desc'  => 'Full companion app with complications. Log breaks, view stats, and track time since last break from your wrist.',
            'tier'  => 'Free',
            'icon'  => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="6" y="1" width="12" height="22" rx="2"/><path d="M9 5h6"/><path d="M9 19h6"/></svg>',
        ),
        // PRO TIER
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

    // Technical Specifications
    'specs' => array(
        'Platform'     => 'iPhone + Apple Watch',
        'Requires'     => 'iOS 17 / watchOS 10 or later',
        'Price'        => 'Free / Pro $4.99 per month',
        'Developer'    => 'Big Freight Life',
        'Size'         => '18.6 MB',
        'Age Rating'   => '4+',
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
        'featureList' => array(
            'Hydration dashboard with real-time status',
            'Quick bathroom visit logging',
            'Bristol Stool Scale reference',
            'Calendar heat map for pattern visualization',
            'Apple Watch companion with complications',
            'Smart hydration reminders',
        ),
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
?>

<main id="main-content" class="site-main">

    <?php /* Mobile product layout — inline for reliable cache-busting.
       Gallery is first in DOM (mobile-first). Desktop CSS reorders via order property. */ ?>
    <style>
    @media (max-width: 1023px) {
        .product-hero-premium { padding: 0 !important; }
        .product-hero-premium > .container { padding: 0 !important; max-width: none !important; }
        .product-hero-premium .product-hero-grid { display: flex !important; flex-direction: column !important; gap: 0 !important; }
        .product-gallery-column { opacity: 1 !important; transform: none !important; transition: none !important; min-height: 52vh !important; }
        .product-info { opacity: 1 !important; transform: none !important; transition: none !important; }
        .product-gallery { gap: 0 !important; }
        .product-gallery--phone { display: block !important; height: 100% !important; }
        .product-gallery--phone .product-gallery-main { border-radius: 0 !important; border: none !important; height: 52vh !important; min-height: 52vh !important; max-height: none !important; aspect-ratio: unset !important; width: 100% !important; }
        .product-gallery-thumbs { display: none !important; }
        .product-gallery-counter { display: none !important; }
        .product-gallery-dots { display: flex !important; position: relative !important; z-index: 2 !important; }
        .product-info { background: #fff !important; border-radius: 24px 24px 0 0 !important; margin-top: -24px !important; position: relative !important; z-index: 1 !important; padding: 24px 16px 16px !important; }
        .product-sticky-bar { display: none !important; }
        body:has(.product-hero-premium) .breadcrumbs { display: none !important; }
        .product-hero-premium .product-title { display: none !important; }
        .product-hero-premium .product-tagline { display: none !important; }
        .product-cta-group { align-items: flex-start !important; }
        .product-cta-group .app-store-badge img { height: 64px !important; }
        .app-store-badge--lg img { height: 64px !important; }
        #main-content { padding-bottom: 140px !important; }
    }
    </style>

    <!-- Breadcrumbs -->
    <div class="container">
        <?php bfluxco_breadcrumbs(); ?>
    </div>

    <!-- Product Hero -->
    <section class="product-hero-premium">
        <div class="container">
            <div class="product-hero-grid">

                <!-- Gallery Column (first in DOM for mobile-first; desktop reorders via CSS order) -->
                <div class="product-gallery-column">
                    <?php if (!empty($product['images'])) : ?>
                    <div class="product-gallery product-gallery--phone">
                        <!-- Main Image Display -->
                        <div class="product-gallery-main" tabindex="0" aria-label="<?php esc_attr_e('Product screenshot gallery', 'bfluxco'); ?>">
                            <?php foreach ($product['images'] as $index => $image) : ?>
                                <div class="product-gallery-image<?php echo $index === 0 ? ' is-active' : ''; ?>" aria-hidden="<?php echo $index === 0 ? 'false' : 'true'; ?>">
                                    <img src="<?php echo esc_url($image['src']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" loading="<?php echo $index === 0 ? 'eager' : 'lazy'; ?>">
                                </div>
                            <?php endforeach; ?>
                            <?php if (count($product['images']) > 1) : ?>
                            <span class="product-gallery-counter"><span class="gallery-counter-current">1</span> / <?php echo count($product['images']); ?></span>
                            <?php endif; ?>
                        </div>

                        <!-- Dot Navigation (mobile) -->
                        <?php if (count($product['images']) > 1) : ?>
                        <div class="product-gallery-dots" role="tablist" aria-label="<?php esc_attr_e('Screenshot navigation', 'bfluxco'); ?>">
                            <?php foreach ($product['images'] as $index => $image) : ?>
                                <button type="button" class="product-gallery-dot<?php echo $index === 0 ? ' is-active' : ''; ?>" data-index="<?php echo $index; ?>" aria-label="<?php echo esc_attr(sprintf(__('View screenshot %d', 'bfluxco'), $index + 1)); ?>"></button>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>

                        <!-- Thumbnail Navigation -->
                        <div class="product-gallery-thumbs" role="tablist" aria-label="<?php esc_attr_e('Screenshot thumbnails', 'bfluxco'); ?>">
                            <?php foreach ($product['images'] as $index => $image) : ?>
                                <button type="button" class="product-thumb<?php echo $index === 0 ? ' is-active' : ''; ?>" role="tab" aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>" tabindex="<?php echo $index === 0 ? '0' : '-1'; ?>" aria-label="<?php echo esc_attr(sprintf(__('View screenshot %d', 'bfluxco'), $index + 1)); ?>">
                                    <img src="<?php echo esc_url($image['src']); ?>" alt="" loading="lazy">
                                </button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php else : ?>
                    <div class="product-gallery-main">
                        <div class="product-gallery-placeholder">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <rect x="5" y="2" width="14" height="20" rx="2" ry="2"/>
                                <line x1="12" y1="18" x2="12.01" y2="18"/>
                            </svg>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Product Info Column -->
                <div class="product-info reveal-text">

                    <!-- Badges -->
                    <div class="product-badges">
                        <span class="product-badge product-badge-category"><?php echo esc_html($product['category']); ?></span>
                    </div>

                    <!-- Title & Tagline -->
                    <h1 class="product-title"><?php echo esc_html($product['name']); ?></h1>
                    <p class="product-tagline"><?php echo esc_html($product['tagline']); ?></p>

                    <!-- Pricing Block -->
                    <div class="product-pricing">
                        <div class="product-price">
                            <span class="product-price-current"><?php echo esc_html($product['price']); ?></span>
                        </div>
                        <span class="product-price-note"><?php echo esc_html($product['price_note']); ?></span>
                    </div>

                    <!-- Quick Highlights -->
                    <ul class="product-highlights">
                        <?php foreach ($product['highlights'] as $highlight) : ?>
                            <li><?php echo esc_html($highlight); ?></li>
                        <?php endforeach; ?>
                    </ul>

                    <!-- CTA Buttons -->
                    <div class="product-cta-group">
                        <a href="<?php echo esc_url($product['cta_url']); ?>" target="_blank" rel="noopener" class="app-store-badge">
                            <img src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg" alt="<?php esc_attr_e('Download on the App Store', 'bfluxco'); ?>" width="156" height="52">
                        </a>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <!-- Description Section -->
    <section class="product-description-section">
        <div class="container container-narrow">
            <div class="reveal-text">
                <h2><?php esc_html_e('Built for Real Life', 'bfluxco'); ?></h2>
                <p><?php esc_html_e('Bathroom habits say a lot about your health — but tracking them shouldn\'t feel awkward. Bio Break makes it simple, private, and even insightful. Log in seconds, understand your patterns, and take better care of your body.', 'bfluxco'); ?></p>
                <p><?php esc_html_e('The free tier gives you everything you need: a hydration dashboard, quick logging with urgency and color tracking, the Bristol Stool Scale, calendar heat map, smart reminders, and a full Apple Watch companion app. Upgrade to Pro for trend analysis, community stats, doctor reports, and iCloud sync.', 'bfluxco'); ?></p>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section-premium">
        <div class="container">
            <h2 class="section-title reveal-text"><?php esc_html_e('Key Features', 'bfluxco'); ?></h2>

            <div class="features-grid-premium">
                <?php foreach ($product['features'] as $index => $feature) :
                    $is_coming_soon = !empty($feature['coming_soon']);
                    $tier = isset($feature['tier']) ? $feature['tier'] : '';
                ?>
                    <div class="feature-card-premium reveal-up<?php echo $is_coming_soon ? ' feature-card--coming-soon' : ''; ?>" data-delay="<?php echo min($index + 1, 4); ?>">
                        <?php if ($tier || $is_coming_soon) : ?>
                        <div class="feature-badges">
                            <?php if ($tier) : ?>
                            <span class="feature-tier feature-tier--<?php echo esc_attr(strtolower($tier)); ?>"><?php echo esc_html($tier); ?></span>
                            <?php endif; ?>
                            <?php if ($is_coming_soon) : ?>
                            <span class="feature-coming-soon"><?php esc_html_e('Coming Soon', 'bfluxco'); ?></span>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                        <div class="feature-icon-premium">
                            <?php echo $feature['icon']; ?>
                        </div>
                        <h3><?php echo esc_html($feature['title']); ?></h3>
                        <p><?php echo esc_html($feature['desc']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Technical Specifications -->
    <section class="specs-section">
        <div class="container">
            <h2 class="section-title reveal-text"><?php esc_html_e('Technical Specifications', 'bfluxco'); ?></h2>

            <div class="specs-grid reveal-up" data-delay="1">
                <?php
                $specs_array = $product['specs'];
                $half = ceil(count($specs_array) / 2);
                $specs_chunks = array_chunk($specs_array, $half, true);
                $chunk_titles = array(__('App Details', 'bfluxco'), __('Additional Info', 'bfluxco'));

                foreach ($specs_chunks as $chunk_index => $chunk) :
                ?>
                <div class="specs-card">
                    <h3 class="specs-table-header"><?php echo esc_html($chunk_titles[$chunk_index]); ?></h3>
                    <table class="specs-table">
                        <tbody>
                            <?php foreach ($chunk as $label => $value) : ?>
                                <tr>
                                    <th><?php echo esc_html($label); ?></th>
                                    <td><?php echo esc_html($value); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="section bg-gray-50">
        <div class="container">
            <header class="section-header text-center reveal-text" style="margin-bottom: 20px;">
                <h2><?php esc_html_e('Frequently Asked Questions', 'bfluxco'); ?></h2>
            </header>

            <div class="faq-list max-w-3xl mx-auto">
                <?php foreach ($product['faqs'] as $index => $faq) : ?>
                <div class="faq-item reveal-up" data-delay="<?php echo min($index + 1, 5); ?>">
                    <h3 class="faq-question"><?php echo esc_html($faq['question']); ?></h3>
                    <p class="faq-answer"><?php echo esc_html($faq['answer']); ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="section text-center">
        <div class="container">
            <h2 class="reveal-text"><?php esc_html_e('Download Bio Break', 'bfluxco'); ?></h2>
            <p class="text-gray-600 max-w-2xl mx-auto mb-8 reveal-text" data-delay="1">
                <?php esc_html_e('Start tracking for free. Upgrade to Pro anytime to unlock insights, doctor reports, and iCloud sync.', 'bfluxco'); ?>
            </p>
            <div class="reveal flex justify-center mb-4" data-delay="2">
                <a href="<?php echo esc_url($product['cta_url']); ?>" target="_blank" rel="noopener" class="app-store-badge app-store-badge--lg">
                    <img src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg" alt="<?php esc_attr_e('Download on the App Store', 'bfluxco'); ?>" width="156" height="52">
                </a>
            </div>
            <div class="product-legal-links reveal" data-delay="3">
                <a href="<?php echo esc_url(home_url('/legal/bio-break-privacy')); ?>"><?php esc_html_e('Privacy Policy', 'bfluxco'); ?></a>
                <a href="<?php echo esc_url(home_url('/legal/bio-break-terms')); ?>"><?php esc_html_e('Terms of Service', 'bfluxco'); ?></a>
                <a href="<?php echo esc_url(home_url('/support/bio-break')); ?>"><?php esc_html_e('Support', 'bfluxco'); ?></a>
            </div>
        </div>
    </section>

    <!-- Sticky Bottom Bar (mobile) -->
    <div class="product-sticky-bar">
        <div class="product-sticky-bar-inner">
            <div class="product-sticky-info">
                <span class="product-sticky-price"><?php echo esc_html($product['price']); ?></span>
                <span class="product-sticky-note"><?php echo esc_html($product['price_note']); ?></span>
            </div>
            <a href="<?php echo esc_url($product['cta_url']); ?>" target="_blank" rel="noopener" class="btn btn-primary">
                <?php esc_html_e('Download', 'bfluxco'); ?>
            </a>
        </div>
    </div>

</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const thumbs = document.querySelectorAll('.product-thumb');
    const dots = document.querySelectorAll('.product-gallery-dot');
    const images = document.querySelectorAll('.product-gallery-image');
    const galleryMain = document.querySelector('.product-gallery-main');
    let currentIndex = 0;

    function goToSlide(index) {
        if (index < 0 || index >= images.length) return;
        currentIndex = index;

        images.forEach(img => {
            img.classList.remove('is-active');
            img.setAttribute('aria-hidden', 'true');
        });
        thumbs.forEach(t => {
            t.classList.remove('is-active');
            t.setAttribute('aria-selected', 'false');
        });
        dots.forEach(d => d.classList.remove('is-active'));

        images[index].classList.add('is-active');
        images[index].setAttribute('aria-hidden', 'false');
        if (thumbs[index]) {
            thumbs[index].classList.add('is-active');
            thumbs[index].setAttribute('aria-selected', 'true');
        }
        if (dots[index]) dots[index].classList.add('is-active');

        const counter = document.querySelector('.gallery-counter-current');
        if (counter) counter.textContent = index + 1;
    }

    // Thumbnail clicks
    thumbs.forEach((thumb, i) => thumb.addEventListener('click', () => goToSlide(i)));

    // Dot clicks
    dots.forEach((dot, i) => dot.addEventListener('click', () => goToSlide(i)));

    // Touch swipe
    if (galleryMain && images.length > 1) {
        let startX = 0;
        let startY = 0;
        let distX = 0;

        galleryMain.addEventListener('touchstart', function(e) {
            startX = e.touches[0].clientX;
            startY = e.touches[0].clientY;
            distX = 0;
        }, { passive: true });

        galleryMain.addEventListener('touchmove', function(e) {
            distX = e.touches[0].clientX - startX;
            const distY = Math.abs(e.touches[0].clientY - startY);
            if (Math.abs(distX) > distY) e.preventDefault();
        }, { passive: false });

        galleryMain.addEventListener('touchend', function() {
            if (Math.abs(distX) > 50) {
                if (distX < 0 && currentIndex < images.length - 1) {
                    goToSlide(currentIndex + 1);
                } else if (distX > 0 && currentIndex > 0) {
                    goToSlide(currentIndex - 1);
                }
            }
        }, { passive: true });
    }
});
</script>

<?php
get_footer();
