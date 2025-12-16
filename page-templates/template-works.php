<?php
/**
 * Template Name: Works
 * Template Post Type: page
 *
 * This template displays the Works archive page - a collection of all works
 * including case studies not featured on the homepage.
 * URL: /works
 *
 * @package BFLUXCO
 */

get_header();
?>

<main id="main-content" class="site-main">

    <?php
    get_template_part('template-parts/page-header', null, array(
        'description' => __('A collection of case studies, projects, and design work spanning industries and disciplines.', 'bfluxco'),
        'use_excerpt' => true,
    ));
    ?>

    <!-- Works Section with Filter Bar -->
    <section class="section works-archive">
        <div class="container">
            <!-- Filter Bar -->
            <div class="filter-bar reveal mb-8" data-delay="2">
                <button class="filter-btn active" data-filter="all"><?php esc_html_e('All Work', 'bfluxco'); ?></button>
                <?php
                // Get all industries from case studies
                $industries = get_terms(array(
                    'taxonomy' => 'industry',
                    'hide_empty' => true,
                ));

                if (!empty($industries) && !is_wp_error($industries)) :
                    foreach ($industries as $industry) :
                ?>
                    <button class="filter-btn" data-filter="<?php echo esc_attr($industry->slug); ?>">
                        <?php echo esc_html($industry->name); ?>
                    </button>
                <?php
                    endforeach;
                else :
                    // Placeholder filters when no taxonomies exist yet
                ?>
                    <button class="filter-btn" data-filter="fintech"><?php esc_html_e('Fintech', 'bfluxco'); ?></button>
                    <button class="filter-btn" data-filter="healthcare"><?php esc_html_e('Healthcare', 'bfluxco'); ?></button>
                    <button class="filter-btn" data-filter="enterprise"><?php esc_html_e('Enterprise', 'bfluxco'); ?></button>
                    <button class="filter-btn" data-filter="ai"><?php esc_html_e('AI/ML', 'bfluxco'); ?></button>
                <?php endif; ?>
            </div>
            <?php
            $case_studies = new WP_Query(array(
                'post_type'      => 'case_study',
                'posts_per_page' => -1,
                'orderby'        => 'menu_order date',
                'order'          => 'ASC',
            ));

            if ($case_studies->have_posts()) :
            ?>
            <div class="works-grid">
                <?php
                $index = 0;
                while ($case_studies->have_posts()) : $case_studies->the_post();
                    $index++;
                    $client = get_post_meta(get_the_ID(), 'case_study_client', true);
                    $industries = get_the_terms(get_the_ID(), 'industry');
                    $industry_classes = '';
                    if ($industries && !is_wp_error($industries)) {
                        $industry_classes = implode(' ', wp_list_pluck($industries, 'slug'));
                    }
                ?>
                <article class="work-card reveal-up <?php echo esc_attr($industry_classes); ?>" data-delay="<?php echo min($index, 6); ?>" data-categories="<?php echo esc_attr($industry_classes); ?>">
                    <a href="<?php the_permalink(); ?>" class="work-card-inner">
                        <div class="work-card-image">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('large'); ?>
                            <?php else : ?>
                                <div class="work-card-placeholder"></div>
                            <?php endif; ?>
                        </div>
                        <div class="work-card-content">
                            <?php if ($client) : ?>
                                <span class="work-card-client"><?php echo esc_html($client); ?></span>
                            <?php endif; ?>
                            <h2 class="work-card-title"><?php the_title(); ?></h2>
                            <p class="work-card-excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 20)); ?></p>
                            <?php if ($industries && !is_wp_error($industries)) : ?>
                                <div class="work-card-tags">
                                    <?php foreach ($industries as $industry) : ?>
                                        <span class="work-tag"><?php echo esc_html($industry->name); ?></span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </a>
                </article>
                <?php
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
            <?php else : ?>
            <!-- Placeholder Works -->
            <div class="works-grid">
                <?php
                $placeholder_works = array(
                    array(
                        'client' => 'Global Bank',
                        'title' => 'Reimagining Digital Banking',
                        'excerpt' => 'A complete digital transformation of the retail banking experience, from mobile app to branch integration.',
                        'industry' => 'Fintech',
                        'filter' => 'fintech'
                    ),
                    array(
                        'client' => 'HealthTech Startup',
                        'title' => 'Patient Portal Redesign',
                        'excerpt' => 'Simplifying complex medical information into an intuitive patient experience.',
                        'industry' => 'Healthcare',
                        'filter' => 'healthcare'
                    ),
                    array(
                        'client' => 'Enterprise SaaS',
                        'title' => 'Design System at Scale',
                        'excerpt' => 'Building a unified design language across 12 products and 200+ engineers.',
                        'industry' => 'Enterprise',
                        'filter' => 'enterprise'
                    ),
                    array(
                        'client' => 'AI Research Lab',
                        'title' => 'Conversational AI Interface',
                        'excerpt' => 'Designing human-centered interactions for generative AI applications.',
                        'industry' => 'AI/ML',
                        'filter' => 'ai'
                    ),
                    array(
                        'client' => 'Insurance Co.',
                        'title' => 'Claims Process Optimization',
                        'excerpt' => 'Reducing claims processing time by 60% through thoughtful UX improvements.',
                        'industry' => 'Fintech',
                        'filter' => 'fintech'
                    ),
                    array(
                        'client' => 'Telehealth Platform',
                        'title' => 'Virtual Care Experience',
                        'excerpt' => 'Creating seamless video consultations that feel personal and professional.',
                        'industry' => 'Healthcare',
                        'filter' => 'healthcare'
                    ),
                    array(
                        'client' => 'Logistics Giant',
                        'title' => 'Supply Chain Dashboard',
                        'excerpt' => 'Visualizing complex logistics data for real-time decision making.',
                        'industry' => 'Enterprise',
                        'filter' => 'enterprise'
                    ),
                    array(
                        'client' => 'EdTech Company',
                        'title' => 'Adaptive Learning Platform',
                        'excerpt' => 'Personalizing education through AI-driven content recommendations.',
                        'industry' => 'AI/ML',
                        'filter' => 'ai'
                    ),
                );

                $index = 0;
                foreach ($placeholder_works as $work) :
                    $index++;
                ?>
                <article class="work-card reveal-up <?php echo esc_attr($work['filter']); ?>" data-delay="<?php echo min($index, 6); ?>" data-categories="<?php echo esc_attr($work['filter']); ?>">
                    <div class="work-card-inner">
                        <div class="work-card-image">
                            <div class="work-card-placeholder"></div>
                        </div>
                        <div class="work-card-content">
                            <span class="work-card-client"><?php echo esc_html($work['client']); ?></span>
                            <h2 class="work-card-title"><?php echo esc_html($work['title']); ?></h2>
                            <p class="work-card-excerpt"><?php echo esc_html($work['excerpt']); ?></p>
                            <div class="work-card-tags">
                                <span class="work-tag"><?php echo esc_html($work['industry']); ?></span>
                            </div>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </section><!-- Works Grid -->

    <?php
    get_template_part('template-parts/section-cta', null, array(
        'heading' => __('Have a Project in Mind?', 'bfluxco'),
        'description' => __("Let's discuss how strategic design can help solve your business challenges.", 'bfluxco'),
        'button_text' => __('Start a Conversation', 'bfluxco'),
    ));
    ?>

</main><!-- #main-content -->

<?php
get_footer();
