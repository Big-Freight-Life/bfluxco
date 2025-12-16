<?php
/**
 * Template Name: About Company
 * Template Post Type: page
 *
 * This template is for company pages like "About Big Freight Life (BFL)".
 * URL: /about/bfl
 *
 * HOW TO USE:
 * 1. Create a new page in WordPress called "About Big Freight Life"
 * 2. Set the page slug to "bfl"
 * 3. Set the parent page to "About"
 * 4. In the Page Attributes section, select "About Company" as the template
 * 5. Set a featured image (company logo or hero image)
 * 6. Add your company content in the page editor
 *
 * @package BFLUXCO
 */

get_header();
?>

<main id="main-content" class="site-main">

    <?php while (have_posts()) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class('about-company'); ?>>

            <?php
            get_template_part('template-parts/page-header', null, array(
                'show_animations' => false,
                'use_excerpt' => true,
            ));
            ?>

            <!-- Hero Image -->
            <?php if (has_post_thumbnail()) : ?>
                <div class="company-hero-image section">
                    <div class="container">
                        <?php the_post_thumbnail('hero-image', array('class' => 'rounded-lg')); ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Company Content -->
            <section class="company-content section">
                <div class="container">
                    <div class="max-w-3xl mx-auto">
                        <?php
                        $content = get_the_content();
                        if (!empty($content)) :
                            the_content();
                        else :
                        ?>
                            <!-- Placeholder content -->
                            <h2><?php esc_html_e('Our Story', 'bfluxco'); ?></h2>
                            <p><?php esc_html_e('Add your company story and history in the WordPress page editor. This placeholder will be replaced with your actual content.', 'bfluxco'); ?></p>

                            <h2><?php esc_html_e('Our Mission', 'bfluxco'); ?></h2>
                            <p><?php esc_html_e('Describe your company\'s mission and purpose.', 'bfluxco'); ?></p>

                            <h2><?php esc_html_e('Our Values', 'bfluxco'); ?></h2>
                            <p><?php esc_html_e('Share the core values that guide your work.', 'bfluxco'); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </section><!-- .company-content -->

            <!-- Values Section -->
            <section class="company-values section bg-gray-50">
                <div class="container">
                    <h2 class="text-center mb-8"><?php esc_html_e('Our Values', 'bfluxco'); ?></h2>

                    <div class="grid grid-3">

                        <div class="value-card p-6 bg-white rounded-lg text-center">
                            <div class="value-icon mb-4 text-primary">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mx-auto">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold mb-2"><?php esc_html_e('Integrity', 'bfluxco'); ?></h3>
                            <p class="text-gray-600"><?php esc_html_e('We do what we say and say what we mean. Honesty and transparency guide every interaction.', 'bfluxco'); ?></p>
                        </div>

                        <div class="value-card p-6 bg-white rounded-lg text-center">
                            <div class="value-icon mb-4 text-primary">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mx-auto">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
                                    <line x1="9" y1="9" x2="9.01" y2="9"></line>
                                    <line x1="15" y1="9" x2="15.01" y2="9"></line>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold mb-2"><?php esc_html_e('Impact', 'bfluxco'); ?></h3>
                            <p class="text-gray-600"><?php esc_html_e('We focus on work that matters and creates meaningful change for our clients and their customers.', 'bfluxco'); ?></p>
                        </div>

                        <div class="value-card p-6 bg-white rounded-lg text-center">
                            <div class="value-icon mb-4 text-primary">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mx-auto">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold mb-2"><?php esc_html_e('Excellence', 'bfluxco'); ?></h3>
                            <p class="text-gray-600"><?php esc_html_e('We strive for excellence in everything we do, continuously learning and improving.', 'bfluxco'); ?></p>
                        </div>

                    </div>
                </div>
            </section><!-- .company-values -->

        </article><!-- #post-<?php the_ID(); ?> -->

    <?php endwhile; ?>

    <!-- Team/Contact CTA -->
    <section class="section text-center">
        <div class="container">
            <h2><?php esc_html_e('Meet the Team', 'bfluxco'); ?></h2>
            <p class="text-gray-600 max-w-2xl mx-auto mb-6">
                <?php esc_html_e('Want to learn more about the people behind Big Freight Life?', 'bfluxco'); ?>
            </p>
            <div class="flex gap-4 justify-center">
                <a href="<?php echo esc_url(home_url('/about/ray')); ?>" class="btn btn-primary">
                    <?php esc_html_e('Meet Ray Butler', 'bfluxco'); ?>
                </a>
                <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-outline">
                    <?php esc_html_e('Get in Touch', 'bfluxco'); ?>
                </a>
            </div>
        </div>
    </section><!-- Team CTA -->

</main><!-- #main-content -->

<?php
get_footer();
