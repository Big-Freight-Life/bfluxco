<?php
/**
 * Template Name: Workshops
 * Template Post Type: page
 *
 * This template displays the Workshops archive page.
 * URL: /work/workshops
 *
 * @package BFLUXCO
 */

get_header();
?>

<main id="main-content" class="site-main">

    <?php
    get_template_part('template-parts/page-header', null, array(
        'description' => __('Collaborative sessions designed to align teams, accelerate decision-making, and unlock strategic clarity.', 'bfluxco'),
    ));
    ?>

    <!-- Workshop Types -->
    <section class="section">
        <div class="container">
            <div class="workshop-types grid grid-3 gap-8">

                <!-- Strategy Workshops -->
                <div class="workshop-type-card reveal-up" data-delay="1">
                    <div class="workshop-type-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M12 16v-4"/>
                            <path d="M12 8h.01"/>
                        </svg>
                    </div>
                    <h3 class="workshop-type-title"><?php esc_html_e('Strategy Sessions', 'bfluxco'); ?></h3>
                    <p class="workshop-type-desc"><?php esc_html_e('Align leadership on vision, priorities, and roadmap through structured facilitation.', 'bfluxco'); ?></p>
                    <span class="workshop-type-duration"><?php esc_html_e('1-2 days', 'bfluxco'); ?></span>
                </div>

                <!-- Design Sprints -->
                <div class="workshop-type-card reveal-up" data-delay="2">
                    <div class="workshop-type-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
                        </svg>
                    </div>
                    <h3 class="workshop-type-title"><?php esc_html_e('Design Sprints', 'bfluxco'); ?></h3>
                    <p class="workshop-type-desc"><?php esc_html_e('Move from problem to tested prototype in 4-5 days using the proven sprint methodology.', 'bfluxco'); ?></p>
                    <span class="workshop-type-duration"><?php esc_html_e('4-5 days', 'bfluxco'); ?></span>
                </div>

                <!-- Team Workshops -->
                <div class="workshop-type-card reveal-up" data-delay="3">
                    <div class="workshop-type-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                    </div>
                    <h3 class="workshop-type-title"><?php esc_html_e('Team Alignment', 'bfluxco'); ?></h3>
                    <p class="workshop-type-desc"><?php esc_html_e('Build shared understanding and collaborative practices across cross-functional teams.', 'bfluxco'); ?></p>
                    <span class="workshop-type-duration"><?php esc_html_e('Half day', 'bfluxco'); ?></span>
                </div>

            </div>
        </div>
    </section>

    <!-- Workshops List -->
    <section class="section bg-gray-50">
        <div class="container">
            <header class="section-header mb-8 reveal-text">
                <h2><?php esc_html_e('Available Workshops', 'bfluxco'); ?></h2>
                <p class="text-gray-600"><?php esc_html_e('Each workshop is customized to your specific context and goals.', 'bfluxco'); ?></p>
            </header>

            <?php
            $workshops = new WP_Query(array(
                'post_type'      => 'workshop',
                'posts_per_page' => -1,
                'orderby'        => 'menu_order',
                'order'          => 'ASC',
            ));

            if ($workshops->have_posts()) :
            ?>
            <div class="workshops-list">
                <?php
                $index = 0;
                while ($workshops->have_posts()) : $workshops->the_post();
                    $index++;
                    get_template_part('template-parts/card-workshop', null, array('index' => $index));
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
            <?php else : ?>
            <!-- Placeholder Workshops -->
            <div class="workshops-list">
                <?php
                $placeholder_workshops = array(
                    array(
                        'title' => 'Strategic Vision Workshop',
                        'excerpt' => 'Align leadership teams on product vision, market positioning, and strategic priorities through structured exercises.',
                        'duration' => '2 days',
                        'format' => 'In-person'
                    ),
                    array(
                        'title' => 'Design Sprint Facilitation',
                        'excerpt' => 'Move from challenge to tested prototype in one week using the proven Google Ventures methodology.',
                        'duration' => '5 days',
                        'format' => 'In-person / Remote'
                    ),
                    array(
                        'title' => 'Design System Foundations',
                        'excerpt' => 'Establish the principles, patterns, and governance for a scalable design system.',
                        'duration' => '1 day',
                        'format' => 'Remote-friendly'
                    ),
                    array(
                        'title' => 'Customer Journey Mapping',
                        'excerpt' => 'Visualize and analyze the complete customer experience to identify opportunities and pain points.',
                        'duration' => 'Half day',
                        'format' => 'Remote-friendly'
                    ),
                    array(
                        'title' => 'Innovation Discovery',
                        'excerpt' => 'Explore new market opportunities and generate validated concepts through rapid ideation.',
                        'duration' => '3 days',
                        'format' => 'In-person'
                    ),
                );

                $index = 0;
                foreach ($placeholder_workshops as $workshop) :
                    $index++;
                ?>
                <article class="workshop-item reveal-up" data-delay="<?php echo min($index, 4); ?>">
                    <div class="workshop-item-inner">
                        <div class="workshop-item-content">
                            <h3 class="workshop-item-title"><?php echo esc_html($workshop['title']); ?></h3>
                            <p class="workshop-item-excerpt"><?php echo esc_html($workshop['excerpt']); ?></p>
                        </div>
                        <div class="workshop-item-meta">
                            <span class="workshop-duration"><?php echo esc_html($workshop['duration']); ?></span>
                            <span class="workshop-format"><?php echo esc_html($workshop['format']); ?></span>
                            <span class="workshop-arrow">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M9 18l6-6-6-6"/>
                                </svg>
                            </span>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </section><!-- Workshops List -->

    <!-- Process Section -->
    <section class="section">
        <div class="container">
            <header class="section-header text-center mb-12 reveal-text">
                <h2><?php esc_html_e('How It Works', 'bfluxco'); ?></h2>
            </header>

            <div class="process-steps grid grid-4 gap-8">
                <div class="process-step reveal-up" data-delay="1">
                    <span class="process-step-number">01</span>
                    <h3 class="process-step-title"><?php esc_html_e('Discovery', 'bfluxco'); ?></h3>
                    <p class="process-step-desc"><?php esc_html_e('We discuss your challenges, goals, and context to design the right workshop.', 'bfluxco'); ?></p>
                </div>
                <div class="process-step reveal-up" data-delay="2">
                    <span class="process-step-number">02</span>
                    <h3 class="process-step-title"><?php esc_html_e('Design', 'bfluxco'); ?></h3>
                    <p class="process-step-desc"><?php esc_html_e('Custom exercises and activities are created for your specific situation.', 'bfluxco'); ?></p>
                </div>
                <div class="process-step reveal-up" data-delay="3">
                    <span class="process-step-number">03</span>
                    <h3 class="process-step-title"><?php esc_html_e('Facilitate', 'bfluxco'); ?></h3>
                    <p class="process-step-desc"><?php esc_html_e('Expert facilitation keeps your team focused and productive.', 'bfluxco'); ?></p>
                </div>
                <div class="process-step reveal-up" data-delay="4">
                    <span class="process-step-number">04</span>
                    <h3 class="process-step-title"><?php esc_html_e('Document', 'bfluxco'); ?></h3>
                    <p class="process-step-desc"><?php esc_html_e('Comprehensive documentation ensures insights translate to action.', 'bfluxco'); ?></p>
                </div>
            </div>
        </div>
    </section><!-- Process -->

    <?php
    get_template_part('template-parts/section-cta', null, array(
        'heading' => __('Ready to Align Your Team?', 'bfluxco'),
        'description' => __("Let's discuss which workshop format would best serve your goals.", 'bfluxco'),
        'button_text' => __('Schedule a Call', 'bfluxco'),
    ));
    ?>

</main><!-- #main-content -->

<?php
get_footer();
