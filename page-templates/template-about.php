<?php
/**
 * Template Name: About
 * Template Post Type: page
 *
 * This template displays the About overview page.
 * URL: /about
 *
 * HOW TO USE:
 * 1. Create a new page in WordPress called "About"
 * 2. Set the page slug to "about"
 * 3. In the Page Attributes section, select "About" as the template
 * 4. Publish the page
 *
 * @package BFLUXCO
 */

get_header();
?>

<main id="main-content" class="site-main">

    <?php
    get_template_part('template-parts/page-header', null, array(
        'description' => __('Learn more about Ray Butler and Big Freight Life.', 'bfluxco'),
        'show_animations' => false,
        'use_excerpt' => true,
    ));
    ?>

    <!-- About Options -->
    <section class="section">
        <div class="container">
            <div class="grid grid-2">

                <!-- Meet Ray Butler -->
                <a href="<?php echo esc_url(home_url('/about/ray')); ?>" class="about-card card">
                    <div class="card-image" style="background: var(--color-gray-200); aspect-ratio: 1/1;">
                        <!-- Placeholder for profile image -->
                    </div>
                    <div class="card-content text-center">
                        <h2 class="card-title"><?php esc_html_e('Meet Ray Butler', 'bfluxco'); ?></h2>
                        <p class="card-description text-gray-600">
                            <?php esc_html_e('The person behind the work. Learn about my background, experience, and approach.', 'bfluxco'); ?>
                        </p>
                        <span class="btn btn-primary"><?php esc_html_e('Learn More', 'bfluxco'); ?></span>
                    </div>
                </a>

                <!-- About Big Freight Life -->
                <a href="<?php echo esc_url(home_url('/about/bfl')); ?>" class="about-card card">
                    <div class="card-image" style="background: linear-gradient(135deg, var(--color-primary-light), var(--color-primary-dark)); aspect-ratio: 1/1;">
                        <!-- Placeholder for company image/logo -->
                    </div>
                    <div class="card-content text-center">
                        <h2 class="card-title"><?php esc_html_e('About Big Freight Life', 'bfluxco'); ?></h2>
                        <p class="card-description text-gray-600">
                            <?php esc_html_e('The company, its mission, and what we stand for.', 'bfluxco'); ?>
                        </p>
                        <span class="btn btn-primary"><?php esc_html_e('Learn More', 'bfluxco'); ?></span>
                    </div>
                </a>

            </div>
        </div>
    </section><!-- About Options -->

    <!-- Page Content (if any) -->
    <?php
    while (have_posts()) : the_post();
        $content = get_the_content();
        if (!empty($content)) :
    ?>
        <section class="section page-content bg-gray-50">
            <div class="container">
                <div class="max-w-3xl mx-auto">
                    <?php the_content(); ?>
                </div>
            </div>
        </section>
    <?php
        endif;
    endwhile;
    ?>

    <!-- CTA Section -->
    <section class="section text-center">
        <div class="container">
            <h2><?php esc_html_e('Want to Connect?', 'bfluxco'); ?></h2>
            <p class="text-gray-600 max-w-2xl mx-auto mb-6">
                <?php esc_html_e("I'd love to hear from you. Whether you have a question or just want to say hello.", 'bfluxco'); ?>
            </p>
            <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-primary btn-lg">
                <?php esc_html_e('Get in Touch', 'bfluxco'); ?>
            </a>
        </div>
    </section><!-- CTA -->

</main><!-- #main-content -->

<?php
get_footer();
