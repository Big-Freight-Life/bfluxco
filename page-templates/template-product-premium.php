<?php
/**
 * Template Name: Product - Premium
 * Template Post Type: page
 *
 * Premium product detail template for software products.
 * Reusable data-driven template inspired by Amazon product pages.
 *
 * SEO/AEO Optimized with SoftwareApplication schema
 *
 * @package BFLUXCO
 */

// =============================================================================
// PRODUCT DATA CONFIGURATION
// Edit this section to customize for each product
// =============================================================================

$product = array(
    // Basic Info
    'name'        => 'Product Name',
    'tagline'     => 'Your compelling tagline goes here.',
    'description' => 'Full product description that explains the value proposition and key benefits to users.',
    'category'    => 'Software',
    'version'     => '1.0.0',

    // Pricing
    'price'          => '$99',
    'original_price' => '', // Leave empty if no discount
    'price_note'     => 'One-time purchase',
    'is_free'        => false,
    'availability'   => 'available', // 'available', 'coming-soon', 'pre-order'

    // Links
    'cta_url'        => '#',
    'cta_text'       => 'Get Started',
    'cta_external'   => false, // true for App Store links
    'secondary_url'  => '/contact',
    'secondary_text' => 'Contact Sales',

    // Images (array of image URLs for gallery)
    'images' => array(
        // Add your product screenshots here
        // get_template_directory_uri() . '/assets/images/products/screenshot-1.png',
    ),

    // Rating (optional - leave empty to hide)
    'rating'       => '',
    'rating_count' => '',

    // Quick Highlights (bullet points)
    'highlights' => array(
        'Key benefit or feature one',
        'Key benefit or feature two',
        'Key benefit or feature three',
        'Key benefit or feature four',
    ),

    // Features (with icons)
    'features' => array(
        array(
            'title' => 'Feature One',
            'desc'  => 'Description of this feature and its benefits.',
            'icon'  => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20V10"/><path d="M18 20V4"/><path d="M6 20v-4"/></svg>',
        ),
        array(
            'title' => 'Feature Two',
            'desc'  => 'Description of this feature and its benefits.',
            'icon'  => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>',
        ),
        array(
            'title' => 'Feature Three',
            'desc'  => 'Description of this feature and its benefits.',
            'icon'  => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>',
        ),
        array(
            'title' => 'Feature Four',
            'desc'  => 'Description of this feature and its benefits.',
            'icon'  => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>',
        ),
    ),

    // Technical Specifications (key => value pairs)
    'specs' => array(
        'Platform'     => 'Web / Desktop / Mobile',
        'Requirements' => 'Modern browser',
        'Version'      => '1.0.0',
        'Developer'    => 'Big Freight Life',
        'Support'      => 'Email support included',
        'Updates'      => 'Lifetime updates',
    ),

    // FAQs
    'faqs' => array(
        array(
            'question' => 'What is this product?',
            'answer'   => 'Detailed answer explaining the product.',
        ),
        array(
            'question' => 'How much does it cost?',
            'answer'   => 'Pricing details and what\'s included.',
        ),
        array(
            'question' => 'Is there a free trial?',
            'answer'   => 'Information about trials or free versions.',
        ),
        array(
            'question' => 'What support is included?',
            'answer'   => 'Details about customer support options.',
        ),
    ),

    // SEO/Meta
    'seo_title'       => '', // Leave empty to auto-generate
    'seo_description' => '', // Leave empty to auto-generate

    // Related Products (optional)
    'related' => array(
        // array('title' => 'Related Product', 'url' => '/products/related', 'price' => '$49'),
    ),
);

// =============================================================================
// SEO & SCHEMA SETUP (Auto-generated from product data)
// =============================================================================

// Custom page title
$seo_title = !empty($product['seo_title'])
    ? $product['seo_title']
    : $product['name'] . ' - ' . $product['category'] . ' | Big Freight Life';

add_filter('document_title_parts', function($title) use ($seo_title) {
    $title['title'] = $seo_title;
    return $title;
});

// Schema and meta description
add_action('wp_head', function() use ($product) {
    // Meta description
    $meta_desc = !empty($product['seo_description'])
        ? $product['seo_description']
        : $product['name'] . ' - ' . $product['tagline'] . ' ' . $product['price'] . '. ' . implode('. ', array_slice($product['highlights'], 0, 2));

    echo '<meta name="description" content="' . esc_attr(substr($meta_desc, 0, 160)) . '">' . "\n";

    // SoftwareApplication Schema
    $price_value = $product['is_free'] ? '0' : preg_replace('/[^0-9.]/', '', $product['price']);

    $schema = array(
        '@context' => 'https://schema.org',
        '@type'    => 'SoftwareApplication',
        '@id'      => get_permalink() . '#software',
        'name'     => $product['name'],
        'description' => $product['description'],
        'applicationCategory' => 'Application',
        'operatingSystem' => isset($product['specs']['Platform']) ? $product['specs']['Platform'] : 'Any',
        'offers'   => array(
            '@type'         => 'Offer',
            'price'         => $price_value,
            'priceCurrency' => 'USD',
            'availability'  => $product['availability'] === 'available'
                ? 'https://schema.org/InStock'
                : 'https://schema.org/PreOrder',
        ),
        'author' => array(
            '@type' => 'Organization',
            'name'  => 'Big Freight Life',
            'url'   => home_url('/'),
        ),
    );

    // Add rating if available
    if (!empty($product['rating'])) {
        $schema['aggregateRating'] = array(
            '@type'       => 'AggregateRating',
            'ratingValue' => $product['rating'],
            'ratingCount' => $product['rating_count'],
            'bestRating'  => '5',
            'worstRating' => '1',
        );
    }

    // Add features
    if (!empty($product['features'])) {
        $schema['featureList'] = array_column($product['features'], 'title');
    }

    echo '<!-- Product Schema -->' . "\n";
    printf(
        '<script type="application/ld+json">%s</script>' . "\n",
        wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
    );

    // FAQ Schema
    if (!empty($product['faqs'])) {
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

        printf(
            '<script type="application/ld+json">%s</script>' . "\n",
            wp_json_encode($faq_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
        );
    }
}, 2);

get_header();
?>

<main id="main-content" class="site-main">

    <!-- Back Link -->
    <div class="container">
        <?php get_template_part('template-parts/back-link', null, array(
            'url'  => home_url('/products'),
            'text' => __('Products', 'bfluxco')
        )); ?>
    </div>

    <!-- Product Hero -->
    <section class="product-hero-premium">
        <div class="container">
            <div class="product-hero-grid">

                <!-- Product Info Column -->
                <div class="product-info reveal-text">

                    <!-- Badges -->
                    <div class="product-badges">
                        <span class="product-badge product-badge-category">
                            <?php echo esc_html($product['category']); ?>
                        </span>
                        <?php if ($product['availability'] === 'coming-soon') : ?>
                            <span class="product-badge product-badge-coming-soon">Coming Soon</span>
                        <?php endif; ?>
                        <?php if ($product['is_free']) : ?>
                            <span class="product-badge product-badge-free">Free</span>
                        <?php endif; ?>
                    </div>

                    <!-- Title & Tagline -->
                    <h1 class="product-title"><?php echo esc_html($product['name']); ?></h1>
                    <p class="product-tagline"><?php echo esc_html($product['tagline']); ?></p>

                    <!-- Rating (if available) -->
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
                            <span class="product-price-current">
                                <?php echo $product['is_free'] ? 'Free' : esc_html($product['price']); ?>
                            </span>
                            <?php if (!empty($product['original_price'])) : ?>
                                <span class="product-price-original"><?php echo esc_html($product['original_price']); ?></span>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($product['price_note'])) : ?>
                            <span class="product-price-note"><?php echo esc_html($product['price_note']); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Quick Highlights -->
                    <?php if (!empty($product['highlights'])) : ?>
                    <ul class="product-highlights">
                        <?php foreach ($product['highlights'] as $highlight) : ?>
                            <li><?php echo esc_html($highlight); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>

                    <!-- CTA Buttons -->
                    <div class="product-cta-group">
                        <?php if ($product['availability'] === 'available') : ?>
                            <?php if ($product['cta_external']) : ?>
                                <a href="<?php echo esc_url($product['cta_url']); ?>" class="app-store-badge" target="_blank" rel="noopener">
                                    <img src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg" alt="<?php echo esc_attr($product['cta_text']); ?>" height="48">
                                </a>
                            <?php else : ?>
                                <a href="<?php echo esc_url($product['cta_url']); ?>" class="btn btn-primary btn-lg">
                                    <?php echo esc_html($product['cta_text']); ?>
                                </a>
                            <?php endif; ?>
                        <?php else : ?>
                            <span class="btn btn-primary btn-lg" style="opacity: 0.6; cursor: not-allowed;">
                                Coming Soon
                            </span>
                        <?php endif; ?>

                        <?php if (!empty($product['secondary_url'])) : ?>
                            <a href="<?php echo esc_url($product['secondary_url']); ?>" class="btn btn-secondary btn-lg">
                                <?php echo esc_html($product['secondary_text']); ?>
                            </a>
                        <?php endif; ?>
                    </div>

                </div>

                <!-- Gallery Column -->
                <div class="product-gallery-column reveal-scale" data-delay="1">
                    <?php if (!empty($product['images'])) : ?>
                    <div class="product-gallery">

                        <!-- Thumbnail Strip -->
                        <div class="product-gallery-thumbs" role="tablist" aria-label="<?php esc_attr_e('Product images', 'bfluxco'); ?>">
                            <?php foreach ($product['images'] as $index => $image) : ?>
                                <button
                                    class="product-thumb <?php echo $index === 0 ? 'is-active' : ''; ?>"
                                    role="tab"
                                    aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>"
                                    aria-controls="gallery-image-<?php echo $index; ?>"
                                    tabindex="<?php echo $index === 0 ? '0' : '-1'; ?>"
                                >
                                    <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($product['name']); ?> - View <?php echo $index + 1; ?>">
                                </button>
                            <?php endforeach; ?>
                        </div>

                        <!-- Main Image Display -->
                        <div class="product-gallery-main" tabindex="0" aria-label="<?php esc_attr_e('Product gallery, use arrow keys to navigate', 'bfluxco'); ?>">
                            <?php foreach ($product['images'] as $index => $image) : ?>
                                <div
                                    class="product-gallery-image <?php echo $index === 0 ? 'is-active' : ''; ?>"
                                    id="gallery-image-<?php echo $index; ?>"
                                    role="tabpanel"
                                    aria-hidden="<?php echo $index === 0 ? 'false' : 'true'; ?>"
                                >
                                    <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($product['name']); ?> - Screenshot <?php echo $index + 1; ?>">
                                </div>
                            <?php endforeach; ?>

                            <?php if (count($product['images']) > 1) : ?>
                            <div class="product-gallery-hint">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M5 12h14M12 5l7 7-7 7"/>
                                </svg>
                                <span><?php esc_html_e('Swipe to view', 'bfluxco'); ?></span>
                            </div>
                            <?php endif; ?>
                        </div>

                    </div>
                    <?php else : ?>
                    <!-- Placeholder when no images -->
                    <div class="product-gallery-main">
                        <div class="product-gallery-placeholder">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                                <circle cx="8.5" cy="8.5" r="1.5"/>
                                <polyline points="21 15 16 10 5 21"/>
                            </svg>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </section>

    <!-- Description Section -->
    <?php if (!empty($product['description'])) : ?>
    <section class="product-description-section">
        <div class="container container-narrow">
            <div class="reveal-text">
                <h2><?php esc_html_e('About This Product', 'bfluxco'); ?></h2>
                <p><?php echo esc_html($product['description']); ?></p>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Features Section -->
    <?php if (!empty($product['features'])) : ?>
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
    <?php endif; ?>

    <!-- Technical Specifications -->
    <?php if (!empty($product['specs'])) : ?>
    <section class="specs-section">
        <div class="container">
            <h2 class="section-title reveal-text"><?php esc_html_e('Technical Specifications', 'bfluxco'); ?></h2>

            <div class="specs-grid reveal-up" data-delay="1">
                <?php
                $specs_array = $product['specs'];
                $half = ceil(count($specs_array) / 2);
                $specs_chunks = array_chunk($specs_array, $half, true);
                $chunk_titles = array(__('Product Details', 'bfluxco'), __('Additional Information', 'bfluxco'));

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
    <?php endif; ?>

    <!-- FAQ Section -->
    <?php if (!empty($product['faqs'])) : ?>
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
    <?php endif; ?>

    <!-- CTA Section -->
    <section class="section text-center">
        <div class="container">
            <h2 class="reveal-text">
                <?php echo $product['availability'] === 'available'
                    ? esc_html__('Ready to Get Started?', 'bfluxco')
                    : esc_html__('Get Notified at Launch', 'bfluxco');
                ?>
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto mb-8 reveal-text" data-delay="1">
                <?php echo $product['availability'] === 'available'
                    ? esc_html($product['tagline'])
                    : esc_html__('Be the first to know when this product launches.', 'bfluxco');
                ?>
            </p>
            <div class="reveal" data-delay="2">
                <?php if ($product['availability'] === 'available') : ?>
                    <?php if ($product['cta_external']) : ?>
                        <a href="<?php echo esc_url($product['cta_url']); ?>" class="app-store-badge" target="_blank" rel="noopener">
                            <img src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg" alt="<?php echo esc_attr($product['cta_text']); ?>" height="52">
                        </a>
                    <?php else : ?>
                        <a href="<?php echo esc_url($product['cta_url']); ?>" class="btn btn-primary btn-lg">
                            <?php echo esc_html($product['cta_text']); ?>
                        </a>
                    <?php endif; ?>
                <?php else : ?>
                    <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-primary btn-lg">
                        <?php esc_html_e('Notify Me', 'bfluxco'); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Related Products -->
    <?php if (!empty($product['related'])) : ?>
    <section class="related-products-section">
        <div class="container">
            <h2 class="section-title reveal-text"><?php esc_html_e('You Might Also Like', 'bfluxco'); ?></h2>

            <div class="related-products-grid reveal-up" data-delay="1">
                <?php foreach ($product['related'] as $related) : ?>
                <a href="<?php echo esc_url($related['url']); ?>" class="product-card">
                    <div class="product-card-inner">
                        <div class="product-content">
                            <h3 class="product-title"><?php echo esc_html($related['title']); ?></h3>
                            <span class="product-price"><?php echo esc_html($related['price']); ?></span>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

</main>

<?php
get_footer();
