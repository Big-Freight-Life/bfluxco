<?php
/**
 * Template Name: App Support Detail
 * Template Post Type: page
 *
 * Individual app support page with details, FAQs, and contact options.
 * URLs: /support/low-ox-life
 *
 * HOW TO USE:
 * 1. Create a new page in WordPress (e.g., "Low Ox Life Support")
 * 2. Set the page slug (e.g., "low-ox-life") under parent "Support"
 * 3. Select "App Support Detail" as the template
 * 4. Add support content in the page editor
 * 5. Publish the page
 *
 * @package BFLUXCO
 */

get_header();
?>

<main id="main-content" class="site-main">

    <?php while (have_posts()) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class('app-support-page'); ?>>

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

            <!-- Support Content -->
            <div class="app-support-content section">
                <div class="container">
                    <div class="content-wrapper max-w-3xl mx-auto">
                        <?php
                        the_content();

                        // If no content exists, show placeholder
                        if (empty(get_the_content())) :
                        ?>
                            <div class="placeholder-content text-gray-500">
                                <p><?php esc_html_e('App support content will be displayed here. Edit this page in WordPress to add support information for this app.', 'bfluxco'); ?></p>

                                <h2><?php esc_html_e('Suggested Content', 'bfluxco'); ?></h2>

                                <ul style="list-style: disc; padding-left: 1.5rem;">
                                    <li><?php esc_html_e('App Store Support Links', 'bfluxco'); ?></li>
                                    <li><?php esc_html_e('In-App Help Documentation', 'bfluxco'); ?></li>
                                    <li><?php esc_html_e('Bug Reporting / Feature Requests', 'bfluxco'); ?></li>
                                    <li><?php esc_html_e('Contact Email for App Support', 'bfluxco'); ?></li>
                                    <li><?php esc_html_e('FAQs and Troubleshooting Guides', 'bfluxco'); ?></li>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div><!-- .app-support-content -->

        </article><!-- #post-<?php the_ID(); ?> -->

    <?php endwhile; ?>

    <!-- Related Pages -->
    <section class="section bg-gray-50">
        <div class="container">
            <div class="max-w-3xl mx-auto">
                <h2 class="text-lg font-semibold mb-4"><?php esc_html_e('Related Pages', 'bfluxco'); ?></h2>
                <div class="flex gap-6">
                    <a href="<?php echo esc_url(home_url('/support')); ?>" class="link">
                        <?php esc_html_e('All Apps', 'bfluxco'); ?>
                    </a>
                    <a href="<?php echo esc_url(home_url('/contact')); ?>" class="link">
                        <?php esc_html_e('Contact', 'bfluxco'); ?>
                    </a>
                    <a href="<?php echo esc_url(home_url('/legal')); ?>" class="link">
                        <?php esc_html_e('Legal Documents', 'bfluxco'); ?>
                    </a>
                </div>
            </div>
        </div>
    </section><!-- Related Pages -->

</main><!-- #main-content -->

<?php
get_footer();
