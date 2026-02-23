<?php
/**
 * Template Name: Works
 * Template Post Type: page
 *
 * Portfolio showcase with featured projects and filterable grid.
 * URL: /works
 *
 * @package BFLUXCO
 */

get_header();
?>

<main id="main-content" class="site-main works-page">

    <!-- Page Hero - Spotlight Project -->
    <header class="works-hero works-featured-hero">
        <div class="container">
            <div class="section-header">
                <span class="section-label"><?php esc_html_e('Featured', 'bfluxco'); ?></span>
                <h2 class="section-title"><?php esc_html_e('Spotlight Project', 'bfluxco'); ?></h2>
            </div>

            <?php
            // Get a featured case study (most recent or a specific one)
            $featured = new WP_Query(array(
                'post_type'      => 'case_study',
                'posts_per_page' => 1,
                'meta_key'       => '_is_featured',
                'meta_value'     => '1',
            ));

            // Fallback to most recent if no featured
            if (!$featured->have_posts()) {
                $featured = new WP_Query(array(
                    'post_type'      => 'case_study',
                    'posts_per_page' => 1,
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                ));
            }

            if ($featured->have_posts()) :
                while ($featured->have_posts()) : $featured->the_post();
                    $client = get_post_meta(get_the_ID(), 'case_study_client', true);
            ?>
            <a href="<?php the_permalink(); ?>" class="featured-project">
                <div class="featured-project-image">
                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('large'); ?>
                    <?php else : ?>
                        <div class="featured-project-placeholder">
                            <div class="featured-placeholder-icon">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                                    <path d="M2 17l10 5 10-5"/>
                                    <path d="M2 12l10 5 10-5"/>
                                </svg>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="featured-project-content">
                    <div class="featured-project-meta">
                        <span class="featured-project-type"><?php esc_html_e('Case Study', 'bfluxco'); ?></span>
                        <?php if ($client) : ?>
                            <span class="featured-project-client"><?php echo esc_html($client); ?></span>
                        <?php endif; ?>
                    </div>
                    <h3 class="featured-project-title"><?php the_title(); ?></h3>
                    <p class="featured-project-excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 35)); ?></p>
                    <span class="featured-project-cta">
                        <?php esc_html_e('View case study', 'bfluxco'); ?>
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                </div>
            </a>
            <?php
                endwhile;
                wp_reset_postdata();
            else :
            ?>
            <!-- Placeholder featured project -->
            <a href="#" class="featured-project">
                <div class="featured-project-image">
                    <div class="featured-project-placeholder">
                        <div class="featured-placeholder-icon">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                                <path d="M2 17l10 5 10-5"/>
                                <path d="M2 12l10 5 10-5"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="featured-project-content">
                    <div class="featured-project-meta">
                        <span class="featured-project-type"><?php esc_html_e('Case Study', 'bfluxco'); ?></span>
                        <span class="featured-project-client">Hyland Software</span>
                    </div>
                    <h3 class="featured-project-title"><?php esc_html_e('Enterprise Content Platform Transformation', 'bfluxco'); ?></h3>
                    <p class="featured-project-excerpt"><?php esc_html_e('How we redesigned information architecture and user workflows to reduce complexity and improve decision-making across a global enterprise platform.', 'bfluxco'); ?></p>
                    <span class="featured-project-cta">
                        <?php esc_html_e('View case study', 'bfluxco'); ?>
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                </div>
            </a>
            <?php endif; ?>
        </div>
    </header>

    <!-- Editorial List Section -->
    <section class="works-editorial-list">
        <div class="container">
            <div class="editorial-layout">
                <!-- Left Column - Heading -->
                <div class="editorial-heading">
                    <h2><?php esc_html_e('Selected Works', 'bfluxco'); ?></h2>
                    <p class="editorial-help"><?php esc_html_e('Choose a designer', 'bfluxco'); ?></p>
                    <div class="editorial-dropdown">
                        <select id="works-author-filter" class="editorial-select">
                            <option value="ray-butler" selected><?php esc_html_e('Ray Butler', 'bfluxco'); ?></option>
                        </select>
                    </div>
                </div>

                <!-- Right Column - Featured List -->
                <div class="editorial-list">
                    <!-- Column Headers -->
                    <div class="editorial-header">
                        <span class="editorial-header-title"><?php esc_html_e('Title', 'bfluxco'); ?></span>
                        <span class="editorial-header-category"><?php esc_html_e('Type', 'bfluxco'); ?></span>
                        <span class="editorial-header-meta"><?php esc_html_e('Date', 'bfluxco'); ?></span>
                    </div>
                    <?php
                    // Query featured case studies
                    $featured_works = new WP_Query(array(
                        'post_type'      => array('case_study', 'special_project'),
                        'posts_per_page' => 7,
                        'orderby'        => 'date',
                        'order'          => 'DESC',
                        'meta_query'     => array(
                            'relation' => 'OR',
                            array(
                                'key'     => '_is_featured',
                                'value'   => '1',
                                'compare' => '='
                            ),
                            array(
                                'key'     => '_is_featured',
                                'compare' => 'NOT EXISTS'
                            )
                        )
                    ));

                    if ($featured_works->have_posts()) :
                        while ($featured_works->have_posts()) : $featured_works->the_post();
                            $post_type = get_post_type();
                            $post_type_obj = get_post_type_object($post_type);
                            $category_label = $post_type_obj ? $post_type_obj->labels->singular_name : 'Project';
                            $client = get_post_meta(get_the_ID(), 'case_study_client', true);
                            $date = get_the_date('M j, Y');
                    ?>
                    <a href="<?php the_permalink(); ?>" class="editorial-item">
                        <span class="editorial-item-title"><?php the_title(); ?></span>
                        <span class="editorial-item-category"><?php echo esc_html($category_label); ?></span>
                        <span class="editorial-item-meta"><?php echo $client ? esc_html($client) : esc_html($date); ?></span>
                    </a>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    else :
                    ?>
                    <!-- Placeholder items when no posts exist -->
                    <a href="#" class="editorial-item">
                        <span class="editorial-item-title">Enterprise Content Platform Transformation</span>
                        <span class="editorial-item-category">Case Study</span>
                        <span class="editorial-item-meta">Hyland Software</span>
                    </a>
                    <a href="#" class="editorial-item">
                        <span class="editorial-item-title">AI-Powered Customer Support Redesign</span>
                        <span class="editorial-item-category">Case Study</span>
                        <span class="editorial-item-meta">TechCorp</span>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Bottom CTA Section -->
    <section class="works-cta">
        <div class="container">
            <div class="works-cta-content reveal-up">
                <h2 class="works-cta-title"><?php esc_html_e('Have a Complex Challenge?', 'bfluxco'); ?></h2>
                <p class="works-cta-description">
                    <?php esc_html_e("Let's discuss how systems thinking and thoughtful design can help your organization navigate complexity.", 'bfluxco'); ?>
                </p>
                <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-primary btn-lg">
                    <?php esc_html_e('Start a Conversation', 'bfluxco'); ?>
                    <?php bfluxco_icon('arrow-right', array('size' => 16)); ?>
                </a>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>
