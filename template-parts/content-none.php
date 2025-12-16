<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * This template is shown when no posts match the current query.
 *
 * @package BFLUXCO
 */
?>

<section class="no-results not-found section text-center">
    <div class="container">
        <div class="max-w-2xl mx-auto">

            <h1 class="page-title"><?php esc_html_e('Nothing Found', 'bfluxco'); ?></h1>

            <?php if (is_home() && current_user_can('publish_posts')) : ?>

                <p class="text-gray-600 mb-6">
                    <?php
                    printf(
                        wp_kses(
                            /* translators: %s: Link to new post */
                            __('Ready to publish your first post? <a href="%s">Get started here</a>.', 'bfluxco'),
                            array('a' => array('href' => array()))
                        ),
                        esc_url(admin_url('post-new.php'))
                    );
                    ?>
                </p>

            <?php elseif (is_search()) : ?>

                <p class="text-gray-600 mb-6">
                    <?php esc_html_e('Sorry, nothing matched your search terms. Please try again with different keywords.', 'bfluxco'); ?>
                </p>

                <?php get_search_form(); ?>

            <?php else : ?>

                <p class="text-gray-600 mb-6">
                    <?php esc_html_e("It seems we can't find what you're looking for. Perhaps searching can help.", 'bfluxco'); ?>
                </p>

                <?php get_search_form(); ?>

            <?php endif; ?>

            <div class="mt-8">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">
                    <?php esc_html_e('Go to Homepage', 'bfluxco'); ?>
                </a>
            </div>

        </div>
    </div>
</section><!-- .no-results -->
