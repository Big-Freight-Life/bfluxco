<?php
/**
 * Template Name: Product Legal Document
 * Template Post Type: page
 *
 * Template for individual product privacy policies and terms of service.
 *
 * HOW TO USE:
 * 1. Create a new page (e.g., "Low Ox Life (List) Privacy Policy")
 * 2. Set the slug to match the URL structure (e.g., "privacy" under parent "low-ox-life-list")
 * 3. Set parent page to the product page (e.g., Low Ox Life List)
 * 4. Select "Product Legal Document" as the template
 * 5. Add your legal content in the editor
 * 6. Publish the page
 *
 * @package BFLUXCO
 */

get_header();

// Get parent product info
$parent_id = wp_get_post_parent_id(get_the_ID());
$parent_title = $parent_id ? get_the_title($parent_id) : '';
$parent_url = $parent_id ? get_permalink($parent_id) : '';

// Determine document type from slug
$current_slug = get_post_field('post_name', get_the_ID());
$doc_type = '';
if (strpos($current_slug, 'privacy') !== false) {
    $doc_type = 'privacy';
} elseif (strpos($current_slug, 'terms') !== false) {
    $doc_type = 'terms';
}
?>

<main id="main-content" class="site-main">

    <?php while (have_posts()) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class('legal-page product-legal-doc'); ?>>

            <!-- Page Header -->
            <header class="page-header">
                <div class="container">
                    <?php bfluxco_breadcrumbs(); ?>

                    <?php if ($parent_title) : ?>
                    <p class="product-legal-parent">
                        <a href="<?php echo esc_url($parent_url); ?>">
                            <?php echo esc_html($parent_title); ?>
                        </a>
                    </p>
                    <?php endif; ?>

                    <h1 class="page-title"><?php the_title(); ?></h1>
                    <p class="text-gray-500 text-sm">
                        <?php
                        printf(
                            esc_html__('Last updated: %s', 'bfluxco'),
                            get_the_modified_date()
                        );
                        ?>
                    </p>
                </div>
            </header>

            <!-- Legal Content -->
            <div class="legal-content section">
                <div class="container">
                    <div class="content-wrapper max-w-3xl mx-auto">
                        <?php
                        the_content();

                        // If no content exists, show placeholder
                        if (empty(get_the_content())) :
                        ?>
                            <div class="placeholder-content text-gray-500">
                                <p><?php esc_html_e('Legal content will be displayed here. Edit this page in WordPress to add your content.', 'bfluxco'); ?></p>

                                <?php if ($doc_type === 'privacy') : ?>
                                    <h2><?php esc_html_e('Suggested Privacy Policy Sections', 'bfluxco'); ?></h2>
                                    <ul style="list-style: disc; padding-left: 1.5rem;">
                                        <li><?php esc_html_e('Information We Collect', 'bfluxco'); ?></li>
                                        <li><?php esc_html_e('How We Use Your Information', 'bfluxco'); ?></li>
                                        <li><?php esc_html_e('Data Storage and Security', 'bfluxco'); ?></li>
                                        <li><?php esc_html_e('Third-Party Services', 'bfluxco'); ?></li>
                                        <li><?php esc_html_e('Your Rights and Choices', 'bfluxco'); ?></li>
                                        <li><?php esc_html_e('Children\'s Privacy', 'bfluxco'); ?></li>
                                        <li><?php esc_html_e('Changes to This Policy', 'bfluxco'); ?></li>
                                        <li><?php esc_html_e('Contact Us', 'bfluxco'); ?></li>
                                    </ul>
                                <?php elseif ($doc_type === 'terms') : ?>
                                    <h2><?php esc_html_e('Suggested Terms of Service Sections', 'bfluxco'); ?></h2>
                                    <ul style="list-style: disc; padding-left: 1.5rem;">
                                        <li><?php esc_html_e('Acceptance of Terms', 'bfluxco'); ?></li>
                                        <li><?php esc_html_e('License Grant', 'bfluxco'); ?></li>
                                        <li><?php esc_html_e('Restrictions on Use', 'bfluxco'); ?></li>
                                        <li><?php esc_html_e('Intellectual Property', 'bfluxco'); ?></li>
                                        <li><?php esc_html_e('Disclaimer of Warranties', 'bfluxco'); ?></li>
                                        <li><?php esc_html_e('Limitation of Liability', 'bfluxco'); ?></li>
                                        <li><?php esc_html_e('Termination', 'bfluxco'); ?></li>
                                        <li><?php esc_html_e('Governing Law', 'bfluxco'); ?></li>
                                        <li><?php esc_html_e('Contact Information', 'bfluxco'); ?></li>
                                    </ul>
                                <?php else : ?>
                                    <p><?php esc_html_e('Add your legal content for this product.', 'bfluxco'); ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </article>

    <?php endwhile; ?>

    <!-- Related Documents -->
    <section class="section bg-gray-50">
        <div class="container">
            <div class="max-w-3xl mx-auto">
                <h2 class="text-lg font-semibold mb-4"><?php esc_html_e('Related Documents', 'bfluxco'); ?></h2>
                <div class="product-legal-related-links">
                    <?php if ($parent_id) : ?>
                        <?php
                        // Get sibling legal pages
                        $siblings = get_children(array(
                            'post_parent' => $parent_id,
                            'post_type' => 'page',
                            'post_status' => 'publish',
                            'orderby' => 'menu_order',
                            'order' => 'ASC',
                        ));

                        foreach ($siblings as $sibling) :
                            if ($sibling->ID !== get_the_ID()) :
                        ?>
                            <a href="<?php echo esc_url(get_permalink($sibling->ID)); ?>" class="link">
                                <?php echo esc_html($sibling->post_title); ?>
                            </a>
                        <?php
                            endif;
                        endforeach;
                        ?>

                        <a href="<?php echo esc_url($parent_url); ?>" class="link">
                            <?php printf(esc_html__('Back to %s', 'bfluxco'), esc_html($parent_title)); ?>
                        </a>
                    <?php endif; ?>

                    <a href="<?php echo esc_url(home_url('/legal')); ?>" class="link">
                        <?php esc_html_e('All Product Legal Documents', 'bfluxco'); ?>
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
                <?php esc_html_e('If you have questions about this policy or need clarification, we are here to help.', 'bfluxco'); ?>
            </p>
            <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-primary">
                <?php esc_html_e('Contact Us', 'bfluxco'); ?>
            </a>
        </div>
    </section>

</main>

<style>
.product-legal-parent {
    margin-bottom: var(--spacing-2);
}

.product-legal-parent a {
    font-size: var(--font-size-sm);
    color: var(--color-primary);
    text-decoration: none;
    font-weight: var(--font-weight-medium);
}

.product-legal-parent a:hover {
    text-decoration: underline;
}

.product-legal-related-links {
    display: flex;
    flex-wrap: wrap;
    gap: var(--spacing-6);
}

.product-legal-related-links .link {
    color: var(--text-secondary);
    text-decoration: none;
    transition: color var(--transition-fast);
}

.product-legal-related-links .link:hover {
    color: var(--color-primary);
}
</style>

<?php
get_footer();
