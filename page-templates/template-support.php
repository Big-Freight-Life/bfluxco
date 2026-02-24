<?php
/**
 * Template Name: Support Hub
 * Template Post Type: page
 *
 * A searchable hub for users to find support for their apps.
 * Each app links to its dedicated support detail page.
 *
 * @package BFLUXCO
 */

get_header();

// App support data
$apps_support = array(
    array(
        'name' => 'Low Ox Life',
        'type' => 'iOS App',
        'slug' => 'low-ox-life',
        'description' => 'Premium oxalate tracking and health insights',
        'support_url' => home_url('/support/low-ox-life'),
    ),
);
?>

<main id="main-content" class="site-main">

    <!-- Page Header -->
    <header class="page-header support-header">
        <div class="container">
            <div class="support-header-row">
                <h1 class="page-title"><?php the_title(); ?></h1>
                <div class="header-search-box">
                    <div class="search-input-wrapper">
                        <svg class="search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        <input
                            type="text"
                            id="app-search"
                            class="search-input"
                            placeholder="<?php esc_attr_e('Search for your app...', 'bfluxco'); ?>"
                            aria-label="<?php esc_attr_e('Search for your app', 'bfluxco'); ?>"
                        >
                    </div>
                </div>
                <div class="header-spacer"></div>
            </div>
        </div>
    </header>

    <!-- Apps Section -->
    <section class="section">
        <div class="container">
            <div class="app-support-search max-w-2xl mx-auto">

                <h3 class="app-list-label"><?php esc_html_e('Apps', 'bfluxco'); ?> <span class="app-count-badge"><?php echo count($apps_support); ?></span></h3>

                <!-- Apps List -->
                <div class="app-support-list" id="app-support-list">
                    <?php foreach ($apps_support as $app) : ?>
                    <a href="<?php echo esc_url($app['support_url']); ?>" class="app-support-item" data-app="<?php echo esc_attr(strtolower($app['name'])); ?>" data-type="<?php echo esc_attr(strtolower($app['type'])); ?>">
                        <div class="app-support-info">
                            <span class="app-support-type"><?php echo esc_html($app['type']); ?></span>
                            <h3 class="app-support-name"><?php echo esc_html($app['name']); ?></h3>
                        </div>
                        <div class="app-support-arrow">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>

                <!-- No Results Message -->
                <div class="app-support-no-results" id="no-results" style="display: none;">
                    <p><?php esc_html_e('No apps found matching your search.', 'bfluxco'); ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- General Support Links -->
    <section class="section bg-gray-50 general-support-section">
        <div class="container">
            <div class="general-support-content">
                <h2><?php esc_html_e('General Support', 'bfluxco'); ?></h2>
                <p><?php esc_html_e('Need help with something else?', 'bfluxco'); ?></p>
                <div class="general-support-buttons">
                    <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-secondary">
                        <?php esc_html_e('Contact Us', 'bfluxco'); ?>
                    </a>
                    <a href="<?php echo esc_url(home_url('/legal')); ?>" class="btn btn-secondary">
                        <?php esc_html_e('Legal Documents', 'bfluxco'); ?>
                    </a>
                </div>
            </div>
        </div>
    </section>

</main>

<style>
.support-header {
    background: transparent;
    padding-bottom: 24px;
}

.support-header-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.support-header-row .page-title {
    flex: 1;
    margin: 0;
    text-align: left;
}

.support-header-row .header-spacer {
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
    .support-header-row {
        flex-direction: column;
        align-items: stretch;
        gap: var(--spacing-4);
    }

    .support-header-row .page-title {
        text-align: center;
    }

    .support-header-row .header-spacer {
        display: none;
    }
}

.page-header + .section {
    padding-top: 0;
}

.app-support-search {
    margin-top: 0;
}

.app-list-label {
    display: flex;
    align-items: center;
    gap: var(--spacing-2);
    font-size: var(--font-size-lg);
    font-weight: var(--font-weight-semibold);
    color: var(--text-primary);
    margin-bottom: var(--spacing-4);
}

.app-count-badge {
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

.app-support-list {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-4);
}

.app-support-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: var(--spacing-5) var(--spacing-6);
    background: var(--bg-primary);
    border: 1px solid var(--border-primary);
    border-radius: var(--radius-lg);
    text-decoration: none;
    transition: border-color var(--transition-fast), box-shadow var(--transition-fast);
}

.app-support-item:hover {
    border-color: var(--color-primary);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.app-support-item.hidden {
    display: none;
}

.app-support-type {
    display: inline-block;
    font-size: var(--font-size-xs);
    font-weight: var(--font-weight-medium);
    color: var(--color-primary);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: var(--spacing-1);
}

.app-support-name {
    font-size: var(--font-size-base);
    font-weight: var(--font-weight-semibold);
    color: var(--text-primary);
    margin: 0;
}

.app-support-arrow {
    color: var(--text-muted);
    transition: color var(--transition-fast), transform var(--transition-fast);
}

.app-support-item:hover .app-support-arrow {
    color: var(--color-primary);
    transform: translateX(4px);
}

.app-support-no-results {
    text-align: center;
    padding: var(--spacing-8);
    color: var(--text-muted);
}

@media (max-width: 640px) {
    .app-support-item {
        padding: var(--spacing-4) var(--spacing-5);
    }
}

.general-support-content {
    max-width: 600px;
    margin: 0 auto;
    text-align: center;
}

.general-support-content h2 {
    font-size: var(--font-size-xl);
    font-weight: var(--font-weight-semibold);
    margin-bottom: var(--spacing-4);
}

.general-support-content p {
    color: var(--text-muted);
    margin-bottom: var(--spacing-6);
}

.general-support-buttons {
    display: flex;
    gap: var(--spacing-4);
    justify-content: center;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('app-search');
    const appItems = document.querySelectorAll('.app-support-item');
    const noResults = document.getElementById('no-results');

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            let visibleCount = 0;

            appItems.forEach(function(item) {
                const appName = item.getAttribute('data-app');
                const appType = item.getAttribute('data-type');
                const matches = appName.includes(query) || appType.includes(query);

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
