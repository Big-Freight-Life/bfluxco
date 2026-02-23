<?php
/**
 * Template Name: Product - Recipe Calculator
 * Template Post Type: page
 *
 * Product detail page for Recipe Calculator iOS App.
 * URL: /products/recipe-calculator
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
    'name'        => 'Recipe Calculator',
    'tagline'     => 'Scale any recipe. Convert any measurement. Cook with confidence.',
    'description' => 'A smart iOS recipe calculator that combines precise measurement conversions with AI-powered cooking intelligence. Scale recipes to any serving size, convert between volume and weight using ingredient-specific densities, and get intelligent cooking assistance.',
    'category'    => 'iOS App',
    'version'     => '1.0',

    // Pricing
    'price'          => 'Free',
    'premium_price'  => '$4.99/mo',
    'annual_price'   => '$39.99/yr',
    'price_note'     => 'Premium features available',
    'is_free'        => true,
    'availability'   => 'coming_soon',

    // Links
    'cta_url'        => '#notify',
    'cta_text'       => 'Get Notified',
    'cta_external'   => false,

    // Images
    'images' => array(
        get_template_directory_uri() . '/assets/images/products/recipe-calculator-1.png',
    ),

    // Rating
    'rating'       => 0,
    'rating_count' => 0,

    // Quick Highlights
    'highlights' => array(
        '140+ ingredient database with precise densities',
        'Scale recipes from any serving size to any other',
        'AI-powered recipe scanner and cooking assistant',
        'Cloud sync across all your devices',
        '7-day free trial for premium features',
    ),

    // Free Features
    'free_features' => array(
        'Recipe scaling calculator (up to 3 ingredients)',
        'Access to 50 common ingredients',
        '5 AI questions per day',
        'Basic recipe calculations',
        'Fraction to decimal conversions',
    ),

    // Premium Features
    'premium_features' => array(
        'Unlimited recipe storage',
        'Full 140+ ingredient database',
        'Unlimited AI assistant access',
        'AI-powered recipe scanner (OCR)',
        'Recipe import from URLs',
        'Cloud sync across devices',
        'Shopping list generator',
        'Export recipes',
    ),

    // Features
    'features' => array(
        array(
            'title' => 'Smart Scaling',
            'desc'  => 'Scale any recipe from any serving size to any other with fraction support and precise calculations.',
            'icon'  => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg>',
        ),
        array(
            'title' => '140+ Ingredients',
            'desc'  => 'Accurate gram-per-cup conversions using ingredient-specific densities for precise measurements.',
            'icon'  => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>',
        ),
        array(
            'title' => 'AI Recipe Scanner',
            'desc'  => 'Scan recipes from photos, PDFs, or URLs with OCR technology. Import recipes instantly.',
            'icon'  => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>',
        ),
        array(
            'title' => 'AI Cooking Assistant',
            'desc'  => 'Get intelligent substitution suggestions, recipe troubleshooting, and cooking guidance.',
            'icon'  => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>',
        ),
    ),

    // Technical Specifications
    'specs' => array(
        'Platform'    => 'iPhone',
        'Requires'    => 'iOS 17.0 or later',
        'Price'       => 'Free with Premium',
        'Developer'   => 'Big Freight Life',
        'AI Provider' => 'Google Gemini',
        'Data Sync'   => 'Supabase Cloud',
    ),

    // FAQs
    'faqs' => array(
        array(
            'question' => 'What is Recipe Calculator?',
            'answer'   => 'Recipe Calculator is an iOS app that helps home cooks and bakers accurately scale recipes, convert measurements using ingredient-specific densities, and get AI-powered cooking assistance.',
        ),
        array(
            'question' => 'Is Recipe Calculator free?',
            'answer'   => 'Recipe Calculator offers a free tier with basic scaling (up to 3 ingredients), 50 common ingredients, and 5 AI questions per day. Premium features are available for $4.99/month or $39.99/year.',
        ),
        array(
            'question' => 'What AI features are included?',
            'answer'   => 'Premium users get unlimited access to AI recipe scanning (import recipes from photos or URLs), intelligent substitution suggestions, recipe troubleshooting, and cooking guidance powered by Google Gemini.',
        ),
        array(
            'question' => 'How does the ingredient database work?',
            'answer'   => 'Our database includes 140+ ingredients with accurate gram-per-cup conversions based on density. This allows precise volume-to-weight conversions for baking and cooking.',
        ),
        array(
            'question' => 'Can I sync recipes across devices?',
            'answer'   => 'Yes! Premium subscribers can sync their recipes across all their iOS devices using secure cloud sync powered by Supabase.',
        ),
    ),

    // SEO
    'seo_title'       => 'Recipe Calculator - AI-Powered Recipe Scaling & Measurement Conversion iOS App',
    'seo_description' => 'Scale any recipe to any serving size with Recipe Calculator. 140+ ingredient database, AI recipe scanner, smart unit conversions. Free iOS app with premium features.',
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
        'applicationCategory' => 'LifestyleApplication',
        'operatingSystem' => 'iOS 17.0 or later',
        'offers'   => array(
            '@type'         => 'Offer',
            'price'         => '0',
            'priceCurrency' => 'USD',
            'availability'  => 'https://schema.org/PreOrder',
        ),
        'author' => array(
            '@type' => 'Organization',
            'name'  => 'Big Freight Life',
            'url'   => home_url('/'),
        ),
        'featureList' => $product['highlights'],
    );

    echo '<!-- Recipe Calculator Product Schema -->' . "\n";
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
                        <span class="product-badge product-badge-coming-soon">Coming Soon</span>
                    </div>

                    <!-- Title & Tagline -->
                    <h1 class="product-title"><?php echo esc_html($product['name']); ?></h1>
                    <p class="product-tagline"><?php echo esc_html($product['tagline']); ?></p>

                    <!-- Pricing Block -->
                    <div class="product-pricing">
                        <div class="product-price">
                            <span class="product-price-current"><?php echo esc_html($product['price']); ?></span>
                            <span class="product-price-premium">Premium: <?php echo esc_html($product['premium_price']); ?> or <?php echo esc_html($product['annual_price']); ?></span>
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
                        <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-primary btn-lg">
                            <?php echo esc_html($product['cta_text']); ?>
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
                <h2><?php esc_html_e('The Smart Recipe Calculator', 'bfluxco'); ?></h2>
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

    <!-- Pricing Tiers Section -->
    <section class="section bg-gray-50">
        <div class="container">
            <h2 class="section-title text-center reveal-text"><?php esc_html_e('Free vs Premium', 'bfluxco'); ?></h2>

            <div class="pricing-comparison reveal-up" data-delay="1">
                <div class="pricing-tier">
                    <h3><?php esc_html_e('Free', 'bfluxco'); ?></h3>
                    <p class="pricing-tier-price">$0</p>
                    <ul>
                        <?php foreach ($product['free_features'] as $feature) : ?>
                            <li><?php echo esc_html($feature); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="pricing-tier pricing-tier-premium">
                    <h3><?php esc_html_e('Premium', 'bfluxco'); ?></h3>
                    <p class="pricing-tier-price"><?php echo esc_html($product['premium_price']); ?> <span>or <?php echo esc_html($product['annual_price']); ?></span></p>
                    <ul>
                        <?php foreach ($product['premium_features'] as $feature) : ?>
                            <li><?php echo esc_html($feature); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <p class="pricing-tier-note"><?php esc_html_e('7-day free trial included', 'bfluxco'); ?></p>
                </div>
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
                $chunk_titles = array(__('App Details', 'bfluxco'), __('Technology', 'bfluxco'));

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
            <h2 class="reveal-text"><?php esc_html_e('Be the First to Know', 'bfluxco'); ?></h2>
            <p class="text-gray-600 max-w-2xl mx-auto mb-8 reveal-text" data-delay="1">
                <?php esc_html_e('Recipe Calculator is coming soon to the App Store. Get notified when it launches and be among the first to scale your recipes with precision.', 'bfluxco'); ?>
            </p>
            <div class="reveal" data-delay="2">
                <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-primary btn-lg">
                    <?php esc_html_e('Get Notified', 'bfluxco'); ?>
                </a>
            </div>
        </div>
    </section>

</main>

<style>
.product-badge-coming-soon {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
}

.product-price-premium {
    display: block;
    font-size: var(--font-size-sm);
    color: var(--text-muted);
    margin-top: var(--spacing-1);
}

.pricing-comparison {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: var(--spacing-6);
    max-width: 800px;
    margin: 0 auto;
}

@media (max-width: 640px) {
    .pricing-comparison {
        grid-template-columns: 1fr;
    }
}

.pricing-tier {
    padding: var(--spacing-8);
    background: var(--bg-primary);
    border: 1px solid var(--border-primary);
    border-radius: var(--radius-lg);
}

.pricing-tier h3 {
    font-size: var(--font-size-xl);
    margin-bottom: var(--spacing-2);
}

.pricing-tier-price {
    font-size: var(--font-size-3xl);
    font-weight: var(--font-weight-bold);
    color: var(--color-primary);
    margin-bottom: var(--spacing-6);
}

.pricing-tier-price span {
    font-size: var(--font-size-sm);
    font-weight: var(--font-weight-normal);
    color: var(--text-muted);
}

.pricing-tier ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.pricing-tier li {
    padding: var(--spacing-2) 0;
    padding-left: var(--spacing-6);
    position: relative;
    border-bottom: 1px solid var(--border-primary);
}

.pricing-tier li:last-child {
    border-bottom: none;
}

.pricing-tier li::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 16px;
    height: 16px;
    background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2314b8a6' stroke-width='2'%3E%3Cpolyline points='20 6 9 17 4 12'/%3E%3C/svg%3E") no-repeat center;
    background-size: contain;
}

.pricing-tier-premium {
    border-color: var(--color-primary);
    box-shadow: 0 4px 20px rgba(20, 184, 166, 0.15);
}

.pricing-tier-note {
    margin-top: var(--spacing-4);
    padding-top: var(--spacing-4);
    border-top: 1px solid var(--border-primary);
    font-size: var(--font-size-sm);
    color: var(--text-muted);
    text-align: center;
}
</style>

<?php
get_footer();
