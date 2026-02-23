<?php
/**
 * The template for displaying single Case Study posts
 *
 * This template is automatically used for individual case studies.
 *
 * @package BFLUXCO
 */

get_header();
?>

<main id="main-content" class="site-main">

    <?php while (have_posts()) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class('case-study-single'); ?>>

            <!-- Case Study Header -->
            <header class="case-study-header section bg-gray-50">
                <div class="container">
                    <div class="max-w-3xl">

                        <?php bfluxco_breadcrumbs(); ?>

                        <!-- Industries -->
                        <?php
                        $industries = get_the_terms(get_the_ID(), 'industry');
                        if ($industries && !is_wp_error($industries)) :
                        ?>
                            <div class="case-study-industries mb-4">
                                <?php foreach ($industries as $industry) : ?>
                                    <a href="<?php echo esc_url(get_term_link($industry)); ?>" class="industry-tag text-primary text-sm">
                                        <?php echo esc_html($industry->name); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <h1 class="case-study-title"><?php the_title(); ?></h1>

                        <?php if (has_excerpt()) : ?>
                            <p class="case-study-subtitle text-xl text-gray-600">
                                <?php the_excerpt(); ?>
                            </p>
                        <?php endif; ?>

                        <!-- Case Study Meta -->
                        <div class="case-study-meta flex flex-wrap gap-6 mt-6">
                            <?php
                            $client = get_post_meta(get_the_ID(), 'case_study_client', true);
                            $timeline = get_post_meta(get_the_ID(), 'case_study_timeline', true);
                            $role = get_post_meta(get_the_ID(), 'case_study_role', true);
                            ?>

                            <?php if ($client) : ?>
                                <div class="meta-item">
                                    <span class="meta-label text-sm text-gray-500"><?php esc_html_e('Client', 'bfluxco'); ?></span>
                                    <span class="meta-value font-medium"><?php echo esc_html($client); ?></span>
                                </div>
                            <?php endif; ?>

                            <?php if ($timeline) : ?>
                                <div class="meta-item">
                                    <span class="meta-label text-sm text-gray-500"><?php esc_html_e('Timeline', 'bfluxco'); ?></span>
                                    <span class="meta-value font-medium"><?php echo esc_html($timeline); ?></span>
                                </div>
                            <?php endif; ?>

                            <?php if ($role) : ?>
                                <div class="meta-item">
                                    <span class="meta-label text-sm text-gray-500"><?php esc_html_e('My Role', 'bfluxco'); ?></span>
                                    <span class="meta-value font-medium"><?php echo esc_html($role); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            </header><!-- .case-study-header -->

            <!-- Featured Image -->
            <?php if (has_post_thumbnail()) : ?>
                <div class="case-study-hero-image">
                    <div class="container">
                        <?php the_post_thumbnail('hero-image', array('class' => 'rounded-lg')); ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Case Study Content -->
            <div class="case-study-content section">
                <div class="container">
                    <div class="content-wrapper max-w-3xl">
                        <?php the_content(); ?>
                    </div>
                </div>
            </div><!-- .case-study-content -->

            <!-- Results Section (if custom fields exist) -->
            <?php
            $results = get_post_meta(get_the_ID(), 'case_study_results', true);
            if ($results) :
            ?>
                <section class="case-study-results section bg-gray-50">
                    <div class="container">
                        <div class="max-w-3xl">
                            <h2><?php esc_html_e('Results', 'bfluxco'); ?></h2>
                            <div class="results-content">
                                <?php echo wp_kses_post($results); ?>
                            </div>
                        </div>
                    </div>
                </section>
            <?php endif; ?>

            <!-- Case Study Footer -->
            <footer class="case-study-footer section">
                <div class="container">
                    <div class="max-w-3xl">

                        <!-- Service Types -->
                        <?php
                        $services = get_the_terms(get_the_ID(), 'service_type');
                        if ($services && !is_wp_error($services)) :
                        ?>
                            <div class="case-study-services mb-6">
                                <strong><?php esc_html_e('Services:', 'bfluxco'); ?></strong>
                                <?php echo esc_html(implode(', ', wp_list_pluck($services, 'name'))); ?>
                            </div>
                        <?php endif; ?>

                        <!-- Share Links -->
                        <div class="case-study-share mb-8">
                            <strong><?php esc_html_e('Share:', 'bfluxco'); ?></strong>
                            <?php bfluxco_social_share(); ?>
                        </div>

                        <!-- Navigation to other case studies -->
                        <nav class="case-study-navigation">
                            <?php
                            the_post_navigation(array(
                                'prev_text' => '<span class="nav-subtitle">' . esc_html__('Previous Case Study', 'bfluxco') . '</span><span class="nav-title">%title</span>',
                                'next_text' => '<span class="nav-subtitle">' . esc_html__('Next Case Study', 'bfluxco') . '</span><span class="nav-title">%title</span>',
                                'in_same_term' => false,
                            ));
                            ?>
                        </nav>

                    </div>
                </div>
            </footer><!-- .case-study-footer -->

        </article><!-- #post-<?php the_ID(); ?> -->

    <?php endwhile; ?>

    <!-- Related Case Studies -->
    <?php
    $related = new WP_Query(array(
        'post_type' => 'case_study',
        'posts_per_page' => 3,
        'post__not_in' => array(get_the_ID()),
        'orderby' => 'rand',
    ));

    if ($related->have_posts()) :
    ?>
        <section class="related-case-studies section bg-gray-50">
            <div class="container">
                <h2 class="text-center mb-8"><?php esc_html_e('More Case Studies', 'bfluxco'); ?></h2>
                <div class="grid grid-3">
                    <?php
                    while ($related->have_posts()) : $related->the_post();
                        get_template_part('template-parts/card', 'case-study');
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
                <div class="text-center mt-8">
                    <a href="<?php echo esc_url(get_post_type_archive_link('case_study')); ?>" class="btn btn-outline">
                        <?php esc_html_e('View All Case Studies', 'bfluxco'); ?>
                    </a>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- CTA Section -->
    <section class="section text-center">
        <div class="container">
            <h2><?php esc_html_e('Ready to Start Your Project?', 'bfluxco'); ?></h2>
            <p class="text-gray-600 max-w-2xl mx-auto mb-6">
                <?php esc_html_e("Let's discuss how I can help solve your business challenges.", 'bfluxco'); ?>
            </p>
            <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-primary btn-lg">
                <?php esc_html_e('Get in Touch', 'bfluxco'); ?>
            </a>
        </div>
    </section><!-- CTA -->

</main><!-- #main-content -->

<?php
get_footer();
