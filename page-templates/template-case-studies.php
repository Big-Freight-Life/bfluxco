<?php
/**
 * Template Name: Case Studies
 * Template Post Type: page
 *
 * This template displays the Case Studies archive page.
 * URL: /work/case-studies
 *
 * @package BFLUXCO
 */

get_header();
?>

<main id="main-content" class="site-main">

    <?php
    get_template_part('template-parts/page-header', null, array(
        'description' => __('Real-world examples of strategic design solving complex business challenges across industries.', 'bfluxco'),
    ));
    ?>

    <!-- Filter Bar -->
    <section class="filter-section">
        <div class="container">
            <div class="filter-bar reveal" data-delay="2">
                <span class="filter-label"><?php esc_html_e('Filter by:', 'bfluxco'); ?></span>
                <div class="filter-buttons">
                    <button class="filter-btn active" data-filter="all"><?php esc_html_e('All', 'bfluxco'); ?></button>
                    <button class="filter-btn" data-filter="brand"><?php esc_html_e('Brand Systems', 'bfluxco'); ?></button>
                    <button class="filter-btn" data-filter="product"><?php esc_html_e('Product Strategy', 'bfluxco'); ?></button>
                    <button class="filter-btn" data-filter="design-system"><?php esc_html_e('Design Systems', 'bfluxco'); ?></button>
                    <button class="filter-btn" data-filter="research"><?php esc_html_e('Research', 'bfluxco'); ?></button>
                </div>
            </div>
        </div>
    </section>

    <!-- Case Studies Grid -->
    <section class="section case-studies-archive">
        <div class="container">
            <?php
            $case_studies = new WP_Query(array(
                'post_type'      => 'case_study',
                'posts_per_page' => -1,
                'orderby'        => 'date',
                'order'          => 'DESC',
            ));

            if ($case_studies->have_posts()) :
            ?>
            <div class="grid grid-2 gap-8">
                <?php
                $index = 0;
                while ($case_studies->have_posts()) : $case_studies->the_post();
                    $index++;
                    $industry = get_the_terms(get_the_ID(), 'industry');
                    $industry_name = $industry ? $industry[0]->name : 'Case Study';
                    $industry_slug = $industry ? $industry[0]->slug : 'general';
                ?>
                <article class="case-study-card reveal-up" data-delay="<?php echo min($index, 4); ?>" data-category="<?php echo esc_attr($industry_slug); ?>">
                    <a href="<?php the_permalink(); ?>" class="case-study-card-inner">
                        <div class="case-study-image">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('large'); ?>
                            <?php else : ?>
                                <div class="case-study-placeholder"></div>
                            <?php endif; ?>
                        </div>
                        <div class="case-study-content">
                            <span class="case-study-label"><?php echo esc_html($industry_name); ?></span>
                            <h2 class="case-study-title"><?php the_title(); ?></h2>
                            <p class="case-study-excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 20)); ?></p>
                            <div class="case-study-meta">
                                <span class="case-study-year"><?php echo get_the_date('Y'); ?></span>
                                <?php
                                $client = get_post_meta(get_the_ID(), 'case_study_client', true);
                                if ($client) : ?>
                                    <span class="case-study-client"><?php echo esc_html($client); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </a>
                </article>
                <?php
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
            <?php else : ?>
            <!-- Placeholder Case Studies -->
            <div class="grid grid-2 gap-8">
                <?php
                $placeholders = array(
                    array(
                        'category' => 'brand',
                        'label' => 'Brand Systems',
                        'title' => 'Unified Identity Framework',
                        'excerpt' => 'Developing a cohesive brand architecture for a multi-product fintech organization entering new markets.',
                        'year' => '2024',
                        'client' => 'FinTech Corp'
                    ),
                    array(
                        'category' => 'product',
                        'label' => 'Product Strategy',
                        'title' => 'Platform Redesign',
                        'excerpt' => 'Rethinking the core experience of an enterprise collaboration tool used by distributed teams.',
                        'year' => '2024',
                        'client' => 'Enterprise Co'
                    ),
                    array(
                        'category' => 'design-system',
                        'label' => 'Design Systems',
                        'title' => 'Component Architecture',
                        'excerpt' => 'Building a scalable design system that serves 40+ product teams across three business units.',
                        'year' => '2023',
                        'client' => 'Tech Giant'
                    ),
                    array(
                        'category' => 'research',
                        'label' => 'Research',
                        'title' => 'Discovery & Synthesis',
                        'excerpt' => 'Conducting foundational research to inform the next generation of healthcare tools.',
                        'year' => '2023',
                        'client' => 'HealthTech Inc'
                    ),
                    array(
                        'category' => 'brand',
                        'label' => 'Brand Systems',
                        'title' => 'Visual Language System',
                        'excerpt' => 'Creating a flexible visual system that scales across digital and physical touchpoints.',
                        'year' => '2023',
                        'client' => 'Retail Brand'
                    ),
                    array(
                        'category' => 'product',
                        'label' => 'Product Strategy',
                        'title' => 'Mobile Experience Overhaul',
                        'excerpt' => 'Reimagining the mobile banking experience for a new generation of users.',
                        'year' => '2023',
                        'client' => 'Digital Bank'
                    ),
                );

                $index = 0;
                foreach ($placeholders as $item) :
                    $index++;
                ?>
                <article class="case-study-card reveal-up" data-delay="<?php echo min($index, 4); ?>" data-category="<?php echo esc_attr($item['category']); ?>">
                    <div class="case-study-card-inner">
                        <div class="case-study-image">
                            <div class="case-study-placeholder"></div>
                        </div>
                        <div class="case-study-content">
                            <span class="case-study-label"><?php echo esc_html($item['label']); ?></span>
                            <h2 class="case-study-title"><?php echo esc_html($item['title']); ?></h2>
                            <p class="case-study-excerpt"><?php echo esc_html($item['excerpt']); ?></p>
                            <div class="case-study-meta">
                                <span class="case-study-year"><?php echo esc_html($item['year']); ?></span>
                                <span class="case-study-client"><?php echo esc_html($item['client']); ?></span>
                            </div>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </section><!-- Case Studies Grid -->

    <?php
    get_template_part('template-parts/section-cta', null, array(
        'heading' => __('Have a Similar Challenge?', 'bfluxco'),
        'description' => __("Let's discuss how strategic design can help solve your business challenges.", 'bfluxco'),
        'button_text' => __('Start a Conversation', 'bfluxco'),
    ));
    ?>

</main><!-- #main-content -->

<?php
get_footer();
