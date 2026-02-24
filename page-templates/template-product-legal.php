<?php
/**
 * Template Name: Product Legal Hub
 * Template Post Type: page
 *
 * A searchable hub for users to find privacy policy and terms of service
 * for their purchased product or service.
 *
 * @package BFLUXCO
 */

get_header();

// Product legal documents data
$products_legal = array(
    array(
        'name' => 'Low Ox Life',
        'type' => 'iOS App',
        'slug' => 'low-ox-life',
        'description' => 'Premium oxalate tracking and health insights',
        'privacy' => home_url('/legal/low-ox-life-privacy'),
        'terms' => home_url('/legal/low-ox-life-terms'),
    ),
);
?>

<main id="main-content" class="site-main">

    <!-- Page Header -->
    <header class="page-header legal-header">
        <div class="container">
            <div class="legal-header-row">
                <h1 class="page-title"><?php the_title(); ?></h1>
                <div class="header-search-box">
                    <div class="search-input-wrapper">
                        <svg class="search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        <input
                            type="text"
                            id="product-search"
                            class="search-input"
                            placeholder="<?php esc_attr_e('Search for your product or service...', 'bfluxco'); ?>"
                            aria-label="<?php esc_attr_e('Search for your product', 'bfluxco'); ?>"
                        >
                    </div>
                </div>
                <div class="header-spacer"></div>
            </div>
        </div>
    </header>

    <!-- Products Section -->
    <section class="section">
        <div class="container">
            <div class="product-legal-search max-w-2xl mx-auto">

                <h3 class="product-list-label"><?php esc_html_e('Products & Services', 'bfluxco'); ?> <span class="product-count-badge"><?php echo count($products_legal); ?></span></h3>

                <!-- Products List -->
                <div class="product-legal-list" id="product-legal-list">
                    <?php foreach ($products_legal as $product) : ?>
                    <div class="product-legal-item" data-product="<?php echo esc_attr(strtolower($product['name'])); ?>" data-type="<?php echo esc_attr(strtolower($product['type'])); ?>">
                        <div class="product-legal-info">
                            <span class="product-legal-type"><?php echo esc_html($product['type']); ?></span>
                            <h3 class="product-legal-name"><?php echo esc_html($product['name']); ?></h3>
                        </div>
                        <div class="product-legal-links">
                            <a href="<?php echo esc_url($product['privacy']); ?>" class="product-legal-link">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                </svg>
                                <?php esc_html_e('Privacy Policy', 'bfluxco'); ?>
                            </a>
                            <a href="<?php echo esc_url($product['terms']); ?>" class="product-legal-link">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                    <polyline points="10 9 9 9 8 9"></polyline>
                                </svg>
                                <?php esc_html_e('Terms of Service', 'bfluxco'); ?>
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- No Results Message -->
                <div class="product-legal-no-results" id="no-results" style="display: none;">
                    <p><?php esc_html_e('No products found matching your search.', 'bfluxco'); ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- General Legal Links -->
    <section class="section bg-gray-50 general-legal-section">
        <div class="container">
            <div class="general-legal-content">
                <h2><?php esc_html_e('General Legal Documents', 'bfluxco'); ?></h2>
                <p><?php esc_html_e('Looking for our company-wide policies?', 'bfluxco'); ?></p>
                <div class="general-legal-buttons">
                    <a href="<?php echo esc_url(home_url('/privacy')); ?>" class="btn btn-secondary">
                        <?php esc_html_e('Privacy Policy', 'bfluxco'); ?>
                    </a>
                    <a href="<?php echo esc_url(home_url('/terms')); ?>" class="btn btn-secondary">
                        <?php esc_html_e('Terms of Service', 'bfluxco'); ?>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="section text-center">
        <div class="container">
            <h2><?php esc_html_e('Have Questions?', 'bfluxco'); ?></h2>
            <p class="text-gray-600 max-w-2xl mx-auto mb-8">
                <?php esc_html_e('If you have questions about our policies or need clarification, we are here to help.', 'bfluxco'); ?>
            </p>
            <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-primary">
                <?php esc_html_e('Contact Us', 'bfluxco'); ?>
            </a>
        </div>
    </section>

</main>

<style>
.legal-header {
    background: transparent;
    padding-bottom: 24px;
}

.legal-header-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.legal-header-row .page-title {
    flex: 1;
    margin: 0;
    text-align: left;
}

.legal-header-row .header-spacer {
    flex: 1;
}

.header-search-box {
    width: 600px;
    max-width: 100%;
}

.header-search-box .search-input-wrapper {
    position: relative;
    width: 100%;
}

.header-search-box .search-icon {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-muted);
    pointer-events: none;
}

.header-search-box .search-input {
    width: 100%;
    padding: 14px 16px 14px 48px;
    font-size: var(--font-size-base);
    border: 1px solid var(--border-primary);
    border-radius: 50px;
    background: var(--bg-primary);
    color: var(--text-primary);
    transition: border-color var(--transition-fast), box-shadow var(--transition-fast);
}

.header-search-box .search-input:focus {
    outline: none;
    border-color: var(--color-primary);
    box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.1);
}

@media (max-width: 768px) {
    .legal-header-row {
        flex-direction: column;
        align-items: stretch;
        gap: var(--spacing-4);
    }

    .legal-header-row .page-title {
        text-align: center;
    }

    .legal-header-row .header-spacer {
        display: none;
    }
}

.page-header + .section {
    padding-top: 0;
}

.product-legal-search {
    margin-top: 0;
}

.product-list-label {
    display: flex;
    align-items: center;
    gap: var(--spacing-2);
    font-size: var(--font-size-lg);
    font-weight: var(--font-weight-semibold);
    color: var(--text-primary);
    margin-bottom: var(--spacing-4);
}

.product-count-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 24px;
    height: 24px;
    padding: 0 var(--spacing-2);
    font-size: var(--font-size-sm);
    font-weight: var(--font-weight-medium);
    color: var(--color-primary);
    background: rgba(20, 184, 166, 0.1);
    border-radius: var(--radius-full);
}

.product-legal-list {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-4);
}

.product-legal-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: var(--spacing-5) var(--spacing-6);
    background: var(--bg-primary);
    border: 1px solid var(--border-primary);
    border-radius: var(--radius-lg);
    transition: border-color var(--transition-fast), box-shadow var(--transition-fast);
}

.product-legal-item:hover {
    border-color: var(--color-primary);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.product-legal-item.hidden {
    display: none;
}

.product-legal-type {
    display: inline-block;
    font-size: var(--font-size-xs);
    font-weight: var(--font-weight-medium);
    color: var(--color-primary);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: var(--spacing-1);
}

.product-legal-name {
    font-size: var(--font-size-base);
    font-weight: var(--font-weight-semibold);
    color: var(--text-primary);
    margin: 0;
}

.product-legal-links {
    display: flex;
    gap: var(--spacing-4);
}

.product-legal-link {
    display: inline-flex;
    align-items: center;
    gap: var(--spacing-2);
    font-size: var(--font-size-sm);
    color: var(--text-secondary);
    text-decoration: none;
    padding: var(--spacing-2) var(--spacing-3);
    border-radius: var(--radius-md);
    transition: color var(--transition-fast), background var(--transition-fast);
}

.product-legal-link:hover {
    color: var(--color-primary);
    background: rgba(20, 184, 166, 0.1);
}

.product-legal-no-results {
    text-align: center;
    padding: var(--spacing-8);
    color: var(--text-muted);
}

@media (max-width: 640px) {
    .product-legal-item {
        flex-direction: column;
        align-items: flex-start;
        gap: var(--spacing-4);
    }

    .product-legal-links {
        width: 100%;
        justify-content: flex-start;
    }
}

.general-legal-content {
    max-width: 600px;
    margin: 0 auto;
    text-align: center;
}

.general-legal-content h2 {
    font-size: var(--font-size-xl);
    font-weight: var(--font-weight-semibold);
    margin-bottom: var(--spacing-4);
}

.general-legal-content p {
    color: var(--text-muted);
    margin-bottom: var(--spacing-6);
}

.general-legal-buttons {
    display: flex;
    gap: var(--spacing-4);
    justify-content: center;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('product-search');
    const productItems = document.querySelectorAll('.product-legal-item');
    const noResults = document.getElementById('no-results');

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            let visibleCount = 0;

            productItems.forEach(function(item) {
                const productName = item.getAttribute('data-product');
                const productType = item.getAttribute('data-type');
                const matches = productName.includes(query) || productType.includes(query);

                if (matches || query === '') {
                    item.classList.remove('hidden');
                    visibleCount++;
                } else {
                    item.classList.add('hidden');
                }
            });

            if (noResults) {
                noResults.style.display = visibleCount === 0 ? 'block' : 'none';
            }
        });
    }
});
</script>

<?php
get_footer();
