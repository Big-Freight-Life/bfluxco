<?php
/**
 * Template Name: Legal Page
 * Template Post Type: page
 *
 * This template is for legal pages like Privacy Policy and Terms of Service.
 * URLs: /privacy, /terms
 *
 * HOW TO USE:
 * 1. Create a new page in WordPress (e.g., "Privacy Policy" or "Terms of Service")
 * 2. Set the page slug appropriately ("privacy" or "terms")
 * 3. In the Page Attributes section, select "Legal Page" as the template
 * 4. Add your legal content in the page editor
 * 5. Publish the page
 *
 * @package BFLUXCO
 */

get_header();
?>

<main id="main-content" class="site-main">

    <?php while (have_posts()) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class('legal-page'); ?>>

            <!-- Page Header -->
            <header class="page-header">
                <div class="container">
                    <?php bfluxco_breadcrumbs(); ?>
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
            </header><!-- .page-header -->

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
                                <p><?php esc_html_e('Legal content will be displayed here. Edit this page in WordPress to add your privacy policy or terms of service.', 'bfluxco'); ?></p>

                                <h2><?php esc_html_e('Suggested Sections', 'bfluxco'); ?></h2>

                                <?php if (is_page('privacy')) : ?>
                                    <ul style="list-style: disc; padding-left: 1.5rem;">
                                        <li><?php esc_html_e('Information We Collect', 'bfluxco'); ?></li>
                                        <li><?php esc_html_e('How We Use Your Information', 'bfluxco'); ?></li>
                                        <li><?php esc_html_e('Information Sharing', 'bfluxco'); ?></li>
                                        <li><?php esc_html_e('Data Security', 'bfluxco'); ?></li>
                                        <li><?php esc_html_e('Your Rights', 'bfluxco'); ?></li>
                                        <li><?php esc_html_e('Contact Us', 'bfluxco'); ?></li>
                                    </ul>
                                <?php else : ?>
                                    <ul style="list-style: disc; padding-left: 1.5rem;">
                                        <li><?php esc_html_e('Acceptance of Terms', 'bfluxco'); ?></li>
                                        <li><?php esc_html_e('Description of Services', 'bfluxco'); ?></li>
                                        <li><?php esc_html_e('User Responsibilities', 'bfluxco'); ?></li>
                                        <li><?php esc_html_e('Intellectual Property', 'bfluxco'); ?></li>
                                        <li><?php esc_html_e('Limitation of Liability', 'bfluxco'); ?></li>
                                        <li><?php esc_html_e('Changes to Terms', 'bfluxco'); ?></li>
                                        <li><?php esc_html_e('Contact Information', 'bfluxco'); ?></li>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div><!-- .legal-content -->

        </article><!-- #post-<?php the_ID(); ?> -->

    <?php endwhile; ?>

    <!-- Related Legal Links -->
    <section class="section bg-gray-50">
        <div class="container">
            <div class="max-w-3xl mx-auto">
                <h2 class="text-lg font-semibold mb-4"><?php esc_html_e('Related Legal Documents', 'bfluxco'); ?></h2>
                <div class="flex gap-6">
                    <?php if (!is_page('privacy')) : ?>
                        <a href="<?php echo esc_url(home_url('/privacy')); ?>" class="link">
                            <?php esc_html_e('Privacy Policy', 'bfluxco'); ?>
                        </a>
                    <?php endif; ?>

                    <?php if (!is_page('terms')) : ?>
                        <a href="<?php echo esc_url(home_url('/terms')); ?>" class="link">
                            <?php esc_html_e('Terms of Service', 'bfluxco'); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section><!-- Related Legal Links -->

</main><!-- #main-content -->

<?php
get_footer();
