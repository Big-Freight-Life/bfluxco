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
    'tagline'     => 'Evidence-based oxalate management.',
    'description' => 'Browse the complete Harvard 2023 Oxalate Table for free. Upgrade to Starter to log meals, track your daily oxalate intake, and sync across devices.',
    'category'    => 'iOS App',
    'version'     => '1.0',

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
    'secondary_text' => 'Visit Facebook Group',

    // Images
    'images' => array(
        array(
            'src' => '/wp-content/uploads/2026/01/lowOxLife-foods.png',
            'alt' => 'Low Ox Life Foods - Browse Harvard 2023 database with search and oxalate level filters',
        ),
        array(
            'src' => '/wp-content/uploads/2026/01/lowOxLife-journal.png',
            'alt' => 'Low Ox Life Journal - Log meals and track daily oxalate intake with date navigation',
        ),
        array(
            'src' => '/wp-content/uploads/2026/01/lowOxLife-welcome.png',
            'alt' => 'Low Ox Life Welcome - Sign in with Apple or continue as guest',
        ),
    ),

    // Rating (none yet - coming soon)
    'rating'       => '',
    'rating_count' => '',

    // Quick Highlights
    'highlights' => array(
        'Free to browse 400+ foods',
        'Harvard 2023 Oxalate Table',
        'Search & filter by oxalate level',
        'Starter: Log food & track intake',
        'Starter: Journal history & cloud sync',
        'Cancel anytime',
    ),

    // Features
    'features' => array(
        // FREE TIER
        array(
            'title' => 'Harvard Database',
            'desc'  => 'Browse 400+ foods with serving sizes and oxalate content from Harvard 2023.',
            'tier'  => 'Free',
            'icon'  => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>',
        ),
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
        // STARTER TIER
        array(
            'title' => 'Food Logging',
            'desc'  => 'Log meals to your journal with one tap or double-tap quick add.',
            'tier'  => 'Starter',
            'icon'  => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20V10"/><path d="M18 20V4"/><path d="M6 20v-4"/></svg>',
        ),
        array(
            'title' => 'Journal History',
            'desc'  => 'View past entries with date navigation.',
            'tier'  => 'Starter',
            'icon'  => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>',
        ),
        array(
            'title' => 'Cloud Sync',
            'desc'  => 'Access your data across all your devices.',
            'tier'  => 'Starter',
            'icon'  => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"/></svg>',
        ),
        // PRO TIER
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
        // ELITE TIER (Coming Soon)
        array(
            'title' => 'Insights & Trends',
            'desc'  => 'Review pattern-based insights and monitor progress over time.',
            'tier'  => 'Elite',
            'coming_soon' => true,
            'icon'  => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>',
        ),
        array(
            'title' => 'Recipe Builder',
            'desc'  => 'Create and save custom recipes with automatic oxalate calculations.',
            'tier'  => 'Elite',
            'coming_soon' => true,
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

    // Technical Specifications
    'specs' => array(
        'Platform'    => 'iPhone',
        'Requires'    => 'iOS 16.7 or later',
        'Price'       => 'Free / Starter $4.99/mo',
        'Developer'   => 'Big Freight Life',
        'Data Source' => 'Harvard 2023 Oxalate Table',
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
            'answer'   => 'Pro ($9.99/month) adds custom food list imports and grocery lists. Elite tier is coming soon and will include insights, recipes, Oscar AI assistant, and data export.',
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
            'title' => 'Low Ox Life (List)',
            'url'   => home_url('/products/low-ox-life-list'),
            'price' => 'Free',
            'desc'  => 'Browse the oxalate database',
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
        'featureList' => array(
            'Browse 400+ foods from Harvard 2023 Oxalate Table',
            'Quick search and smart filters',
            'Food logging to journal (Starter)',
            'Journal history with date navigation (Starter)',
            'Cloud sync across devices (Starter)',
        ),
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
        .product-gallery-counter { display: block !important; }
        .product-info { background: #fff !important; border-radius: 24px 24px 0 0 !important; margin-top: -24px !important; position: relative !important; z-index: 1 !important; padding: 24px 16px 16px !important; }
        .product-sticky-bar { display: block !important; position: fixed !important; bottom: 64px !important; left: 0 !important; right: 0 !important; z-index: 90 !important; }
        body:has(.product-hero-premium) .breadcrumbs { display: none !important; }
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
                        <a href="<?php echo esc_url($product['secondary_url']); ?>" class="btn btn-secondary btn-lg" target="_blank" rel="noopener">
                            <?php echo esc_html($product['secondary_text']); ?>
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
                <h2><?php esc_html_e('Free to Browse, Starter to Track', 'bfluxco'); ?></h2>
                <p><?php esc_html_e('Low Ox Life gives you free access to browse the complete Harvard 2023 Oxalate Table - over 400 foods with serving sizes and oxalate content. Search for any food and filter by oxalate level to make informed choices.', 'bfluxco'); ?></p>
                <p><?php esc_html_e('Ready to track your intake? The Starter subscription adds food logging, journal history with date navigation, and cloud sync across all your devices. Designed for people who value evidence-based nutrition and sustainable habits.', 'bfluxco'); ?></p>
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
            <header class="section-header text-center mb-12 reveal-text">
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
            <h2 class="reveal-text"><?php esc_html_e('Download Low Ox Life', 'bfluxco'); ?></h2>
            <p class="text-gray-600 max-w-2xl mx-auto mb-8 reveal-text" data-delay="1">
                <?php esc_html_e('Browse the Harvard 2023 Oxalate Table for free. Upgrade to Starter anytime to unlock food logging and cloud sync.', 'bfluxco'); ?>
            </p>
            <div class="reveal flex justify-center" data-delay="2">
                <a href="https://apps.apple.com/us/app/low-ox-life-list/id6748654148" target="_blank" rel="noopener" class="app-store-badge">
                    <img src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg" alt="<?php esc_attr_e('Download on the App Store', 'bfluxco'); ?>" width="156" height="52">
                </a>
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
// Product Gallery Thumbnail Navigation
document.addEventListener('DOMContentLoaded', function() {
    const thumbs = document.querySelectorAll('.product-thumb');
    const images = document.querySelectorAll('.product-gallery-image');

    if (thumbs.length && images.length) {
        thumbs.forEach((thumb, index) => {
            thumb.addEventListener('click', function() {
                // Remove active state from all
                thumbs.forEach(t => {
                    t.classList.remove('is-active');
                    t.setAttribute('aria-selected', 'false');
                    t.setAttribute('tabindex', '-1');
                });
                images.forEach(img => {
                    img.classList.remove('is-active');
                    img.setAttribute('aria-hidden', 'true');
                });

                // Add active state to clicked
                this.classList.add('is-active');
                this.setAttribute('aria-selected', 'true');
                this.setAttribute('tabindex', '0');

                if (images[index]) {
                    images[index].classList.add('is-active');
                    images[index].setAttribute('aria-hidden', 'false');
                }

                // Update counter
                const counter = document.querySelector('.gallery-counter-current');
                if (counter) counter.textContent = index + 1;
            });
        });
    }
});
</script>

<?php
get_footer();
