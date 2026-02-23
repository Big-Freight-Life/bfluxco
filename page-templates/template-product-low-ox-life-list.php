<?php
/**
 * Template Name: Product - Low Ox Life (List)
 * Template Post Type: page
 *
 * Product detail page for Low Ox Life (List) iOS App.
 * URL: /products/low-ox-life-list
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
    'name'        => 'Low Ox Life (List)',
    'tagline'     => 'Your pocket guide to low-oxalate living.',
    'description' => 'Browse the complete 2023 Harvard food oxalate database on the go. Make informed dietary choices with quick search, smart filters, and personalized favorites.',
    'category'    => 'iOS App',
    'version'     => '1.0',

    // Pricing
    'price'          => 'Free',
    'original_price' => '',
    'price_note'     => 'No in-app purchases',
    'is_free'        => true,
    'availability'   => 'available',

    // Links
    'cta_url'        => 'https://apps.apple.com/us/app/low-ox-life-list/id6748654148',
    'cta_text'       => 'Download on App Store',
    'cta_external'   => true,
    'secondary_url'  => home_url('/products/low-ox-life'),
    'secondary_text' => 'See Full Version',

    // Images
    'images' => array(
        get_template_directory_uri() . '/assets/images/products/low-ox-life-list-1.png',
        // Add more screenshots as available
    ),

    // Rating
    'rating'       => 4.3,
    'rating_count' => 10,

    // Quick Highlights
    'highlights' => array(
        'Harvard 2023 Oxalate Table data',
        'Quick search & smart filters',
        'Mark favorites and allergens',
        'Privacy-focused, no data collection',
        'Works offline',
    ),

    // Features
    'features' => array(
        array(
            'title' => 'Quick Search',
            'desc'  => 'Find any food instantly with fast, responsive search functionality.',
            'icon'  => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>',
        ),
        array(
            'title' => 'Smart Filters',
            'desc'  => 'Filter foods by oxalate level range to match your dietary needs.',
            'icon'  => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>',
        ),
        array(
            'title' => 'Favorites & Allergens',
            'desc'  => 'Mark foods as favorites or allergens for quick reference.',
            'icon'  => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg>',
        ),
        array(
            'title' => 'Privacy First',
            'desc'  => 'No data collection. Your health information stays on your device.',
            'icon'  => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
        ),
    ),

    // Technical Specifications
    'specs' => array(
        'Platform'    => 'iPhone',
        'Requires'    => 'iOS 16.7 or later',
        'Size'        => '1.4 MB',
        'Price'       => 'Free',
        'Developer'   => 'Big Freight Life',
        'Data Source' => 'Harvard 2023 Oxalate Table',
    ),

    // FAQs
    'faqs' => array(
        array(
            'question' => 'What is Low Ox Life (List)?',
            'answer'   => 'Low Ox Life (List) is a free iOS app that lets you browse the complete 2023 Harvard food oxalate database. Search any food, filter by oxalate level, and mark favorites to support a low-oxalate lifestyle.',
        ),
        array(
            'question' => 'Is Low Ox Life (List) free?',
            'answer'   => 'Yes, Low Ox Life (List) is completely free to download and use. There are no in-app purchases or subscriptions required.',
        ),
        array(
            'question' => 'What data source does it use?',
            'answer'   => 'Low Ox Life (List) uses the 2023 Harvard Oxalate Table, providing scientifically-backed oxalate information for hundreds of foods with serving sizes and oxalate content.',
        ),
        array(
            'question' => 'Does it collect my data?',
            'answer'   => 'No. Low Ox Life (List) is privacy-focused and does not collect any personal data. All your health information stays on your device.',
        ),
        array(
            'question' => 'What iOS version is required?',
            'answer'   => 'Low Ox Life (List) requires iOS 16.7 or later. The app is only 1.4 MB so it works great on any compatible iPhone.',
        ),
    ),

    // SEO
    'seo_title'       => 'Low Ox Life (List) - Free Oxalate Food Database iOS App',
    'seo_description' => 'Free iOS app to browse the Harvard 2023 oxalate food database. Search foods, filter by oxalate level, mark favorites. Privacy-focused, no data collection.',

    // Related
    'related' => array(
        array(
            'title' => 'Low Ox Life',
            'url'   => home_url('/products/low-ox-life'),
            'price' => '$4.99/mo',
            'desc'  => 'Add food logging & cloud sync',
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
        'downloadUrl' => $product['cta_url'],
        'installUrl'  => $product['cta_url'],
        'offers'   => array(
            '@type'         => 'Offer',
            'price'         => '0',
            'priceCurrency' => 'USD',
            'availability'  => 'https://schema.org/InStock',
        ),
        'aggregateRating' => array(
            '@type'       => 'AggregateRating',
            'ratingValue' => $product['rating'],
            'ratingCount' => $product['rating_count'],
            'bestRating'  => '5',
            'worstRating' => '1',
        ),
        'author' => array(
            '@type' => 'Organization',
            'name'  => 'Big Freight Life',
            'url'   => home_url('/'),
        ),
        'featureList' => $product['highlights'],
        'fileSize' => '1.4 MB',
    );

    echo '<!-- Low Ox Life (List) Product Schema -->' . "\n";
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

    <!-- Breadcrumbs -->
    <div class="container">
        <?php bfluxco_breadcrumbs(); ?>
    </div>

    <!-- Product Hero -->
    <section class="product-hero-premium">
        <div class="container">
            <div class="product-hero-grid">

                <!-- Product Info Column -->
                <div class="product-info reveal-text">

                    <!-- Badges -->
                    <div class="product-badges">
                        <span class="product-badge product-badge-category"><?php echo esc_html($product['category']); ?></span>
                        <span class="product-badge product-badge-free">Free</span>
                    </div>

                    <!-- Title & Tagline -->
                    <h1 class="product-title"><?php echo esc_html($product['name']); ?></h1>
                    <p class="product-tagline"><?php echo esc_html($product['tagline']); ?></p>

                    <!-- Rating -->
                    <?php if (!empty($product['rating'])) : ?>
                    <div class="product-rating">
                        <div class="product-stars">
                            <?php for ($i = 1; $i <= 5; $i++) : ?>
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="<?php echo $i <= round($product['rating']) ? 'currentColor' : 'none'; ?>" stroke="currentColor" stroke-width="2">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                </svg>
                            <?php endfor; ?>
                        </div>
                        <span class="product-rating-count">
                            <?php echo esc_html($product['rating']); ?> (<?php echo esc_html($product['rating_count']); ?> reviews)
                        </span>
                    </div>
                    <?php endif; ?>

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
                        <a href="<?php echo esc_url($product['cta_url']); ?>" class="app-store-badge" target="_blank" rel="noopener">
                            <img src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg" alt="<?php echo esc_attr($product['cta_text']); ?>" height="48">
                        </a>
                        <a href="<?php echo esc_url($product['secondary_url']); ?>" class="btn btn-secondary btn-lg">
                            <?php echo esc_html($product['secondary_text']); ?>
                        </a>
                    </div>

                </div>

                <!-- Gallery Column -->
                <div class="product-gallery-column reveal-scale" data-delay="1">
                    <div class="product-gallery-main">
                        <div class="product-gallery-placeholder">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <rect x="5" y="2" width="14" height="20" rx="2" ry="2"/>
                                <line x1="12" y1="18" x2="12.01" y2="18"/>
                            </svg>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Description Section -->
    <section class="product-description-section">
        <div class="container container-narrow">
            <div class="reveal-text">
                <h2><?php esc_html_e('Trusted Data Source', 'bfluxco'); ?></h2>
                <p><?php echo esc_html($product['description']); ?></p>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section-premium">
        <div class="container">
            <h2 class="section-title reveal-text"><?php esc_html_e('Key Features', 'bfluxco'); ?></h2>

            <div class="features-grid-premium">
                <?php foreach ($product['features'] as $index => $feature) : ?>
                    <div class="feature-card-premium reveal-up" data-delay="<?php echo min($index + 1, 4); ?>">
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
            <h2 class="reveal-text"><?php esc_html_e('Start Your Low-Oxalate Journey', 'bfluxco'); ?></h2>
            <p class="text-gray-600 max-w-2xl mx-auto mb-8 reveal-text" data-delay="1">
                <?php esc_html_e('Download Low Ox Life (List) today and take control of your dietary choices with oxalate information at your fingertips.', 'bfluxco'); ?>
            </p>
            <div class="reveal" data-delay="2">
                <a href="<?php echo esc_url($product['cta_url']); ?>" target="_blank" rel="noopener" class="app-store-badge">
                    <img src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg" alt="<?php esc_attr_e('Download on the App Store', 'bfluxco'); ?>" width="156" height="52">
                </a>
            </div>
        </div>
    </section>

    <!-- Upgrade CTA -->
    <section class="section bg-gray-50">
        <div class="container text-center">
            <h3 class="reveal-text"><?php esc_html_e('Need More Features?', 'bfluxco'); ?></h3>
            <p class="text-gray-600 max-w-xl mx-auto mb-6 reveal-text" data-delay="1">
                <?php esc_html_e('Upgrade to Low Ox Life for daily tracking, pattern-based insights, and progress monitoring.', 'bfluxco'); ?>
            </p>
            <div class="reveal" data-delay="2">
                <a href="<?php echo esc_url(home_url('/products/low-ox-life')); ?>" class="btn btn-secondary"><?php esc_html_e('Learn About Low Ox Life', 'bfluxco'); ?></a>
            </div>
        </div>
    </section>

</main>

<?php
get_footer();
