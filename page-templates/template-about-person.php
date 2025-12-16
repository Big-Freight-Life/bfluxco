<?php
/**
 * Template Name: About Person
 * Template Post Type: page
 *
 * This template is for personal bio pages like "Meet Ray Butler".
 * URL: /about/ray
 *
 * HOW TO USE:
 * 1. Create a new page in WordPress called "Meet Ray Butler"
 * 2. Set the page slug to "ray"
 * 3. Set the parent page to "About"
 * 4. In the Page Attributes section, select "About Person" as the template
 * 5. Set a featured image (this will be your profile photo)
 * 6. Add your bio content in the page editor
 *
 * @package BFLUXCO
 */

get_header();
?>

<main id="main-content" class="site-main">

    <?php while (have_posts()) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class('about-person'); ?>>

            <!-- Hero Section -->
            <section class="about-hero section">
                <div class="container">
                    <div class="grid grid-2 items-center gap-8">

                        <!-- Profile Image -->
                        <div class="about-hero-image">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('large', array('class' => 'rounded-lg')); ?>
                            <?php else : ?>
                                <div style="background: var(--color-gray-200); aspect-ratio: 1/1; border-radius: var(--radius-xl);"></div>
                            <?php endif; ?>
                        </div>

                        <!-- Hero Content -->
                        <div class="about-hero-content">
                            <?php bfluxco_breadcrumbs(); ?>
                            <h1 class="page-title"><?php the_title(); ?></h1>

                            <?php if (has_excerpt()) : ?>
                                <p class="text-xl text-gray-600">
                                    <?php the_excerpt(); ?>
                                </p>
                            <?php else : ?>
                                <p class="text-xl text-gray-600">
                                    <?php esc_html_e('Strategic designer helping organizations solve complex challenges through thoughtful design and collaboration.', 'bfluxco'); ?>
                                </p>
                            <?php endif; ?>

                            <!-- Social Links -->
                            <div class="about-social flex gap-4 mt-6">
                                <a href="#" class="btn btn-secondary btn-sm" target="_blank" rel="noopener">
                                    LinkedIn
                                </a>
                                <a href="#" class="btn btn-secondary btn-sm" target="_blank" rel="noopener">
                                    Twitter
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </section><!-- .about-hero -->

            <!-- Bio Content -->
            <section class="about-bio section bg-gray-50">
                <div class="container">
                    <div class="max-w-3xl mx-auto">
                        <?php
                        $content = get_the_content();
                        if (!empty($content)) :
                            the_content();
                        else :
                        ?>
                            <!-- Placeholder bio content -->
                            <h2><?php esc_html_e('Background', 'bfluxco'); ?></h2>
                            <p><?php esc_html_e('Add your bio content in the WordPress page editor. This is a placeholder that will be replaced with your actual content.', 'bfluxco'); ?></p>

                            <h2><?php esc_html_e('Experience', 'bfluxco'); ?></h2>
                            <p><?php esc_html_e('Describe your professional experience, past roles, and key accomplishments.', 'bfluxco'); ?></p>

                            <h2><?php esc_html_e('Approach', 'bfluxco'); ?></h2>
                            <p><?php esc_html_e('Share your philosophy and approach to work.', 'bfluxco'); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </section><!-- .about-bio -->

            <!-- Skills/Expertise Section -->
            <section class="about-skills section">
                <div class="container">
                    <h2 class="text-center mb-8"><?php esc_html_e('Areas of Expertise', 'bfluxco'); ?></h2>

                    <div class="grid grid-4">
                        <div class="skill-item text-center p-4">
                            <div class="skill-icon mb-4" style="font-size: 2rem;">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="2" y1="12" x2="22" y2="12"></line>
                                    <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold"><?php esc_html_e('Strategy', 'bfluxco'); ?></h3>
                        </div>

                        <div class="skill-item text-center p-4">
                            <div class="skill-icon mb-4">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold"><?php esc_html_e('Facilitation', 'bfluxco'); ?></h3>
                        </div>

                        <div class="skill-item text-center p-4">
                            <div class="skill-icon mb-4">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="3" y1="9" x2="21" y2="9"></line>
                                    <line x1="9" y1="21" x2="9" y2="9"></line>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold"><?php esc_html_e('Design', 'bfluxco'); ?></h3>
                        </div>

                        <div class="skill-item text-center p-4">
                            <div class="skill-icon mb-4">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold"><?php esc_html_e('Execution', 'bfluxco'); ?></h3>
                        </div>
                    </div>
                </div>
            </section><!-- .about-skills -->

        </article><!-- #post-<?php the_ID(); ?> -->

    <?php endwhile; ?>

    <!-- CTA Section -->
    <section class="section bg-gray-50 text-center">
        <div class="container">
            <h2><?php esc_html_e("Let's Work Together", 'bfluxco'); ?></h2>
            <p class="text-gray-600 max-w-2xl mx-auto mb-6">
                <?php esc_html_e('Interested in collaborating? I\'d love to hear about your project.', 'bfluxco'); ?>
            </p>
            <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-primary btn-lg">
                <?php esc_html_e('Get in Touch', 'bfluxco'); ?>
            </a>
        </div>
    </section><!-- CTA -->

</main><!-- #main-content -->

<?php
get_footer();
