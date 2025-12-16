<?php
/**
 * Template Name: Product - Low Ox Life (List)
 * Template Post Type: page
 *
 * Product detail page for Low Ox Life (List) iOS App.
 * URL: /products/low-ox-life-list
 *
 * @package BFLUXCO
 */

get_header();
?>

<main id="main-content" class="site-main">

    <!-- Back Link -->
    <div class="container">
        <?php get_template_part('template-parts/back-link', null, array(
            'url' => home_url('/products'),
            'text' => __('Products', 'bfluxco')
        )); ?>
    </div>

    <!-- Product Hero -->
    <section class="product-hero">
        <div class="container">
            <div class="product-hero-grid">
                <div class="product-hero-content reveal-text">
                    <span class="product-category"><?php esc_html_e('iOS App', 'bfluxco'); ?></span>
                    <h1 class="product-hero-title"><?php esc_html_e('Low Ox Life (List)', 'bfluxco'); ?></h1>
                    <p class="product-hero-tagline"><?php esc_html_e('Your pocket guide to low-oxalate living.', 'bfluxco'); ?></p>
                    <p class="product-hero-description"><?php esc_html_e('Browse the complete 2023 Harvard food oxalate database on the go. Make informed dietary choices with quick search, smart filters, and personalized favorites.', 'bfluxco'); ?></p>

                    <div class="product-hero-cta">
                        <a href="https://apps.apple.com/us/app/low-ox-life-list/id6748654148" target="_blank" rel="noopener" class="app-store-badge">
                            <img src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg" alt="<?php esc_attr_e('Download on the App Store', 'bfluxco'); ?>" width="156" height="52">
                        </a>
                        <span class="product-price-tag"><?php esc_html_e('Free', 'bfluxco'); ?></span>
                    </div>
                </div>
                <div class="product-hero-image reveal-scale" data-delay="2">
                    <div class="product-mockup">
                        <div class="product-placeholder" style="background: linear-gradient(135deg, #34d399, #059669); aspect-ratio: 9/16; border-radius: var(--radius-xl);"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="section bg-gray-50">
        <div class="container">
            <h2 class="section-title text-center reveal-text"><?php esc_html_e('Key Features', 'bfluxco'); ?></h2>
            <div class="features-grid reveal-up" data-delay="1">
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"/>
                            <path d="m21 21-4.35-4.35"/>
                        </svg>
                    </div>
                    <h3><?php esc_html_e('Quick Search', 'bfluxco'); ?></h3>
                    <p><?php esc_html_e('Find any food instantly with fast, responsive search functionality.', 'bfluxco'); ?></p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
                        </svg>
                    </div>
                    <h3><?php esc_html_e('Smart Filters', 'bfluxco'); ?></h3>
                    <p><?php esc_html_e('Filter foods by oxalate level range to match your dietary needs.', 'bfluxco'); ?></p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/>
                        </svg>
                    </div>
                    <h3><?php esc_html_e('Favorites & Allergens', 'bfluxco'); ?></h3>
                    <p><?php esc_html_e('Mark foods as favorites or allergens for quick reference.', 'bfluxco'); ?></p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        </svg>
                    </div>
                    <h3><?php esc_html_e('Privacy First', 'bfluxco'); ?></h3>
                    <p><?php esc_html_e('No data collection. Your health information stays on your device.', 'bfluxco'); ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Data Source Section -->
    <section class="section">
        <div class="container container-narrow">
            <div class="content-block reveal-text">
                <h2><?php esc_html_e('Trusted Data Source', 'bfluxco'); ?></h2>
                <p><?php esc_html_e('Low Ox Life uses the 2023 Harvard oxalate database, providing you with scientifically-backed oxalate information for hundreds of foods. Each entry includes serving size and oxalate content to help you make informed decisions.', 'bfluxco'); ?></p>
            </div>
        </div>
    </section>

    <!-- App Details -->
    <section class="section bg-gray-50">
        <div class="container">
            <div class="app-details-grid">
                <div class="app-detail">
                    <span class="app-detail-label"><?php esc_html_e('Platform', 'bfluxco'); ?></span>
                    <span class="app-detail-value"><?php esc_html_e('iPhone', 'bfluxco'); ?></span>
                </div>
                <div class="app-detail">
                    <span class="app-detail-label"><?php esc_html_e('Requires', 'bfluxco'); ?></span>
                    <span class="app-detail-value"><?php esc_html_e('iOS 16.7 or later', 'bfluxco'); ?></span>
                </div>
                <div class="app-detail">
                    <span class="app-detail-label"><?php esc_html_e('Size', 'bfluxco'); ?></span>
                    <span class="app-detail-value"><?php esc_html_e('1.4 MB', 'bfluxco'); ?></span>
                </div>
                <div class="app-detail">
                    <span class="app-detail-label"><?php esc_html_e('Price', 'bfluxco'); ?></span>
                    <span class="app-detail-value"><?php esc_html_e('Free', 'bfluxco'); ?></span>
                </div>
                <div class="app-detail">
                    <span class="app-detail-label"><?php esc_html_e('Developer', 'bfluxco'); ?></span>
                    <span class="app-detail-value"><?php esc_html_e('Big Freight Life LLC', 'bfluxco'); ?></span>
                </div>
                <div class="app-detail">
                    <span class="app-detail-label"><?php esc_html_e('Rating', 'bfluxco'); ?></span>
                    <span class="app-detail-value"><?php esc_html_e('4.3 / 5', 'bfluxco'); ?></span>
                </div>
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
                <a href="https://apps.apple.com/us/app/low-ox-life-list/id6748654148" target="_blank" rel="noopener" class="app-store-badge">
                    <img src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg" alt="<?php esc_attr_e('Download on the App Store', 'bfluxco'); ?>" width="156" height="52">
                </a>
            </div>
        </div>
    </section>

</main>

<?php
get_footer();
