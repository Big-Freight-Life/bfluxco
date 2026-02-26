<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * This template is displayed when a visitor tries to access a page
 * that doesn't exist on your site.
 *
 * @package BFLUXCO
 */

get_header();
?>

<main id="main-content" class="site-main">

    <section class="error-404 section text-center">
        <div class="container">
            <div class="max-w-2xl mx-auto">

                <!-- Error Code -->
                <div class="error-code" style="font-size: 8rem; font-weight: 700; color: var(--color-gray-200); line-height: 1;">
                    404
                </div>

                <h1 class="page-title"><?php esc_html_e('Page Not Found', 'bfluxco'); ?></h1>

                <p class="text-gray-600 mb-8">
                    <?php esc_html_e("Sorry, the page you're looking for doesn't exist or has been moved.", 'bfluxco'); ?>
                </p>

                <!-- Helpful Links -->
                <div class="error-actions mb-8">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">
                        <?php esc_html_e('Go to Homepage', 'bfluxco'); ?>
                    </a>
                    <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-outline">
                        <?php esc_html_e('Contact Us', 'bfluxco'); ?>
                    </a>
                </div>

                <!-- Quick Links -->
                <div class="error-links">
                    <p class="text-gray-500 mb-4"><?php esc_html_e('Or try one of these pages:', 'bfluxco'); ?></p>
                    <ul class="inline-flex gap-6 justify-center flex-wrap">
                        <li><a href="<?php echo esc_url(home_url('/works')); ?>" class="link"><?php esc_html_e('The Work', 'bfluxco'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/about')); ?>" class="link"><?php esc_html_e('About', 'bfluxco'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/contact')); ?>" class="link"><?php esc_html_e('Contact', 'bfluxco'); ?></a></li>
                    </ul>
                </div>

            </div>
        </div>
    </section><!-- .error-404 -->

</main><!-- #main-content -->

<?php
get_footer();
