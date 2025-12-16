<?php
/**
 * The template for displaying single Workshop posts
 *
 * This template is automatically used for individual workshops.
 *
 * @package BFLUXCO
 */

get_header();
?>

<main id="main-content" class="site-main">

    <?php while (have_posts()) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class('workshop-single'); ?>>

            <!-- Workshop Header -->
            <header class="workshop-header section bg-gray-50">
                <div class="container">
                    <div class="max-w-3xl">

                        <?php bfluxco_breadcrumbs(); ?>

                        <!-- Service Types -->
                        <?php
                        $services = get_the_terms(get_the_ID(), 'service_type');
                        if ($services && !is_wp_error($services)) :
                        ?>
                            <div class="workshop-services mb-4">
                                <?php foreach ($services as $service) : ?>
                                    <a href="<?php echo esc_url(get_term_link($service)); ?>" class="service-tag text-primary text-sm">
                                        <?php echo esc_html($service->name); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <h1 class="workshop-title"><?php the_title(); ?></h1>

                        <?php if (has_excerpt()) : ?>
                            <p class="workshop-subtitle text-xl text-gray-600">
                                <?php the_excerpt(); ?>
                            </p>
                        <?php endif; ?>

                        <!-- Workshop Meta -->
                        <div class="workshop-meta flex flex-wrap gap-6 mt-6">
                            <?php
                            $duration = get_post_meta(get_the_ID(), 'workshop_duration', true);
                            $format = get_post_meta(get_the_ID(), 'workshop_format', true);
                            ?>

                            <?php if ($duration) : ?>
                                <div class="meta-item">
                                    <span class="meta-label text-sm text-gray-500"><?php esc_html_e('Duration', 'bfluxco'); ?></span>
                                    <span class="meta-value font-medium"><?php echo esc_html($duration); ?></span>
                                </div>
                            <?php endif; ?>

                            <?php if ($format) : ?>
                                <div class="meta-item">
                                    <span class="meta-label text-sm text-gray-500"><?php esc_html_e('Format', 'bfluxco'); ?></span>
                                    <span class="meta-value font-medium"><?php echo esc_html($format); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            </header><!-- .workshop-header -->

            <!-- Featured Image -->
            <?php if (has_post_thumbnail()) : ?>
                <div class="workshop-hero-image">
                    <div class="container">
                        <?php the_post_thumbnail('hero-image', array('class' => 'rounded-lg')); ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Workshop Content -->
            <div class="workshop-content section">
                <div class="container">
                    <div class="content-wrapper max-w-3xl">
                        <?php the_content(); ?>
                    </div>
                </div>
            </div><!-- .workshop-content -->

            <!-- Workshop Footer -->
            <footer class="workshop-footer section">
                <div class="container">
                    <div class="max-w-3xl">

                        <!-- Share Links -->
                        <div class="workshop-share mb-8">
                            <strong><?php esc_html_e('Share:', 'bfluxco'); ?></strong>
                            <?php bfluxco_social_share(); ?>
                        </div>

                        <!-- Navigation to other workshops -->
                        <nav class="workshop-navigation">
                            <?php
                            the_post_navigation(array(
                                'prev_text' => '<span class="nav-subtitle">' . esc_html__('Previous Workshop', 'bfluxco') . '</span><span class="nav-title">%title</span>',
                                'next_text' => '<span class="nav-subtitle">' . esc_html__('Next Workshop', 'bfluxco') . '</span><span class="nav-title">%title</span>',
                                'in_same_term' => false,
                            ));
                            ?>
                        </nav>

                    </div>
                </div>
            </footer><!-- .workshop-footer -->

        </article><!-- #post-<?php the_ID(); ?> -->

    <?php endwhile; ?>

    <!-- Related Workshops -->
    <?php
    $related = new WP_Query(array(
        'post_type' => 'workshop',
        'posts_per_page' => 3,
        'post__not_in' => array(get_the_ID()),
        'orderby' => 'rand',
    ));

    if ($related->have_posts()) :
    ?>
        <section class="related-workshops section bg-gray-50">
            <div class="container">
                <h2 class="text-center mb-8"><?php esc_html_e('More Workshops', 'bfluxco'); ?></h2>
                <div class="grid grid-3">
                    <?php
                    while ($related->have_posts()) : $related->the_post();
                        get_template_part('template-parts/card', 'workshop');
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
                <div class="text-center mt-8">
                    <a href="<?php echo esc_url(home_url('/workshops')); ?>" class="btn btn-outline">
                        <?php esc_html_e('View All Workshops', 'bfluxco'); ?>
                    </a>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php
    get_template_part('template-parts/section-cta', null, array(
        'heading' => __('Interested in This Workshop?', 'bfluxco'),
        'description' => __("Let's discuss how this workshop can help your team.", 'bfluxco'),
        'button_text' => __('Get in Touch', 'bfluxco'),
    ));
    ?>

</main><!-- #main-content -->

<?php
get_footer();
