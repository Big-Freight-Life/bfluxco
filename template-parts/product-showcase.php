<?php
/**
 * Product Showcase Template Part
 *
 * Apple-inspired showcase layout shared between all product pages.
 * Receives $args (the $product array) from get_template_part().
 *
 * @package BFLUXCO
 */

$product = $args;
?>

<main id="main-content" class="site-main psc-page"
    style="--product-accent: <?php echo esc_attr($product['theme']['accent']); ?>;
           --product-accent-rgb: <?php echo esc_attr($product['theme']['accent_rgb']); ?>;
           --product-hero-gradient: <?php echo esc_attr($product['theme']['hero_gradient']); ?>;
           --product-hero-glow: <?php echo esc_attr($product['theme']['hero_glow']); ?>;">

    <!-- 1. Cinematic Hero -->
    <section class="psc-hero">
        <div class="container">
            <div class="psc-hero-grid">
                <div class="psc-hero-text reveal-up">
                    <span class="psc-hero-badge"><?php echo esc_html($product['category']); ?></span>
                    <h1 class="psc-hero-name"><?php echo esc_html($product['name']); ?></h1>
                    <p class="psc-hero-headline"><?php echo esc_html($product['hero_headline']); ?></p>
                    <p class="psc-hero-sub"><?php echo esc_html($product['hero_subheadline']); ?></p>
                    <div class="psc-hero-cta">
                        <a href="<?php echo esc_url($product['cta_url']); ?>" target="_blank" rel="noopener" class="app-store-badge">
                            <img src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg"
                                 alt="<?php esc_attr_e('Download on the App Store', 'bfluxco'); ?>"
                                 width="156" height="52">
                        </a>
                        <span class="psc-hero-price"><?php echo esc_html($product['price'] . ($product['price_note'] ? ' · ' . $product['price_note'] : '')); ?></span>
                    </div>
                </div>
                <?php $is_dual = !empty($product['hero_layout']) && $product['hero_layout'] === 'dual-device'; ?>
                <div class="psc-hero-device<?php echo $is_dual ? ' psc-hero-device--dual' : ''; ?> reveal-scale">
                    <img class="psc-device-mockup" src="<?php echo esc_url($product['images'][0]['src']); ?>"
                         alt="<?php echo esc_attr($product['images'][0]['alt']); ?>"
                         loading="eager" width="1350" height="2760">
                    <?php if (!empty($product['hero_watch_image'])) : ?>
                    <img class="psc-watch-mockup"
                         src="<?php echo esc_url($product['hero_watch_image']['src']); ?>"
                         alt="<?php echo esc_attr($product['hero_watch_image']['alt']); ?>"
                         loading="eager" width="600" height="940">
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. Value Proposition -->
    <section class="psc-value-prop">
        <div class="container">
            <p class="psc-value-prop-text reveal-text"><?php echo esc_html($product['value_prop']); ?></p>
        </div>
    </section>

    <!-- 3-5. Feature Spotlights -->
    <?php foreach ($product['feature_spotlights'] as $i => $spotlight) :
        $bg_class = 'psc-spotlight--' . esc_attr($spotlight['background']);
        $reversed = ($i % 2 === 1) ? ' psc-spotlight--reversed' : '';
        $image_index = isset($spotlight['image_index']) ? $spotlight['image_index'] : $i;
        $image = isset($product['images'][$image_index]) ? $product['images'][$image_index] : $product['images'][0];
    ?>
    <section class="psc-spotlight <?php echo $bg_class . $reversed; ?>">
        <div class="container">
            <div class="psc-spotlight-grid">
                <div class="psc-spotlight-image reveal-scale">
                    <img class="psc-device-mockup" src="<?php echo esc_url($image['src']); ?>"
                         alt="<?php echo esc_attr($image['alt']); ?>"
                         loading="lazy" width="1350" height="2760">
                </div>
                <div class="psc-spotlight-content reveal-up">
                    <div class="psc-spotlight-label"><?php echo esc_html($spotlight['title']); ?></div>
                    <h2 class="psc-spotlight-headline"><?php echo esc_html($spotlight['headline']); ?></h2>
                    <p class="psc-spotlight-desc"><?php echo esc_html($spotlight['desc']); ?></p>
                </div>
            </div>
        </div>
    </section>
    <?php endforeach; ?>

    <!-- 6. Secondary Features Grid -->
    <section class="psc-features">
        <div class="container">
            <h2 class="psc-features-title reveal-text"><?php esc_html_e('Everything You Need', 'bfluxco'); ?></h2>

            <div class="psc-features-grid">
                <?php foreach ($product['features'] as $index => $feature) :
                    $is_coming_soon = !empty($feature['coming_soon']);
                ?>
                <div class="psc-feature-card<?php echo $is_coming_soon ? ' psc-feature-card--coming-soon' : ''; ?> reveal-up" data-delay="<?php echo min($index + 1, 4); ?>">
                    <div class="psc-feature-icon">
                        <span aria-hidden="true"><?php echo $feature['icon']; ?></span>
                    </div>
                    <div class="psc-feature-body">
                        <h3><?php echo esc_html($feature['title']); ?></h3>
                        <p><?php echo esc_html($feature['desc']); ?></p>
                        <?php if (!empty($feature['tier']) || $is_coming_soon) : ?>
                        <div class="psc-feature-badges">
                            <?php if (!empty($feature['tier'])) : ?>
                            <span class="feature-tier feature-tier--<?php echo esc_attr(strtolower($feature['tier'])); ?>"><?php echo esc_html($feature['tier']); ?></span>
                            <?php endif; ?>
                            <?php if ($is_coming_soon) : ?>
                            <span class="feature-coming-soon"><?php esc_html_e('Coming Soon', 'bfluxco'); ?></span>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- 7. Pricing Tiers -->
    <?php if (!empty($product['pricing_tiers'])) : ?>
    <section class="psc-pricing">
        <div class="container">
            <h2 class="psc-pricing-title reveal-text"><?php esc_html_e('Simple Pricing', 'bfluxco'); ?></h2>
            <p class="psc-pricing-sub reveal-text" data-delay="1"><?php echo esc_html(isset($product['pricing_subtitle']) ? $product['pricing_subtitle'] : 'Start free. Upgrade anytime.'); ?></p>

            <div class="psc-pricing-grid">
                <?php foreach ($product['pricing_tiers'] as $tier) : ?>
                <div class="psc-price-card<?php echo !empty($tier['highlighted']) ? ' psc-price-card--highlighted' : ''; ?> reveal-up">
                    <?php if (!empty($tier['badge'])) : ?>
                    <span class="psc-price-badge"><?php echo esc_html($tier['badge']); ?></span>
                    <?php endif; ?>
                    <div class="psc-price-name"><?php echo esc_html($tier['name']); ?></div>
                    <div class="psc-price-amount"><?php echo esc_html($tier['price']); ?></div>
                    <div class="psc-price-period"><?php echo esc_html(isset($tier['period']) ? $tier['period'] : ''); ?></div>
                    <ul class="psc-price-features">
                        <?php foreach ($tier['features'] as $feat) : ?>
                        <li><?php echo esc_html($feat); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- 8. FAQ Accordion -->
    <?php if (!empty($product['faqs'])) : ?>
    <section class="psc-faq">
        <div class="container">
            <h2 class="psc-faq-title reveal-text"><?php esc_html_e('Frequently Asked Questions', 'bfluxco'); ?></h2>

            <div class="psc-faq-list">
                <?php foreach ($product['faqs'] as $index => $faq) : ?>
                <div class="psc-faq-item reveal-up" data-delay="<?php echo min($index + 1, 4); ?>">
                    <button class="psc-faq-question" aria-expanded="false" aria-controls="faq-answer-<?php echo $index; ?>">
                        <span><?php echo esc_html($faq['question']); ?></span>
                        <svg class="psc-faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                    </button>
                    <div class="psc-faq-answer" id="faq-answer-<?php echo $index; ?>">
                        <p><?php echo esc_html($faq['answer']); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- 9. Final CTA -->
    <section class="psc-final-cta">
        <div class="container">
            <h2 class="psc-final-cta-headline reveal-text"><?php echo esc_html(isset($product['cta_headline']) ? $product['cta_headline'] : 'Download ' . $product['name']); ?></h2>
            <p class="psc-final-cta-sub reveal-text" data-delay="1"><?php echo esc_html(isset($product['cta_description']) ? $product['cta_description'] : $product['description']); ?></p>
            <div class="reveal" data-delay="2">
                <a href="<?php echo esc_url($product['cta_url']); ?>" target="_blank" rel="noopener" class="app-store-badge">
                    <img src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg"
                         alt="<?php esc_attr_e('Download on the App Store', 'bfluxco'); ?>"
                         width="156" height="52">
                </a>
            </div>
            <?php if (!empty($product['secondary_url'])) : ?>
            <div class="psc-final-cta-links reveal" data-delay="3">
                <a href="<?php echo esc_url($product['secondary_url']); ?>" class="btn btn-facebook btn-lg" target="_blank" rel="noopener">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    <?php echo esc_html($product['secondary_text']); ?>
                </a>
            </div>
            <?php endif; ?>
            <?php if (!empty($product['legal_links'])) : ?>
            <div class="product-legal-links reveal" data-delay="3">
                <?php foreach ($product['legal_links'] as $link) : ?>
                <a href="<?php echo esc_url($link['url']); ?>"><?php echo esc_html($link['label']); ?></a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>

</main>

<script>
/* FAQ Accordion */
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.psc-faq-question').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var item = this.closest('.psc-faq-item');
            var isOpen = item.classList.contains('is-open');

            /* Close all others */
            document.querySelectorAll('.psc-faq-item.is-open').forEach(function(open) {
                open.classList.remove('is-open');
                open.querySelector('.psc-faq-question').setAttribute('aria-expanded', 'false');
            });

            /* Toggle current */
            if (!isOpen) {
                item.classList.add('is-open');
                this.setAttribute('aria-expanded', 'true');
            }
        });
    });
});
</script>
