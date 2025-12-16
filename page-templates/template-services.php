<?php
/**
 * Template Name: Services
 * Template Post Type: page
 *
 * This template displays the Services overview page.
 * URL: /services
 *
 * @package BFLUXCO
 */

get_header();
?>

<main id="main-content" class="site-main">

    <?php
    get_template_part('template-parts/page-header', null, array(
        'description' => __('Strategic design services that help organizations navigate complexity and create meaningful solutions.', 'bfluxco'),
    ));
    ?>

    <!-- Services Grid -->
    <section class="section">
        <div class="container">
            <div class="services-grid grid grid-2 gap-8">

                <!-- Experience Design -->
                <a href="<?php echo esc_url(home_url('/services/experience-design')); ?>" class="service-card reveal-up" data-delay="1">
                    <div class="service-card-icon gradient-experience-design">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                            <circle cx="8.5" cy="8.5" r="1.5"/>
                            <polyline points="21 15 16 10 5 21"/>
                        </svg>
                    </div>
                    <h2 class="service-card-title"><?php esc_html_e('Experience Design', 'bfluxco'); ?></h2>
                    <p class="service-card-desc"><?php esc_html_e('End-to-end experience design that transforms how customers interact with your brand across every touchpoint.', 'bfluxco'); ?></p>
                    <span class="service-card-link"><?php esc_html_e('Learn more', 'bfluxco'); ?> &rarr;</span>
                </a>

                <!-- Gen AI Architecture -->
                <a href="<?php echo esc_url(home_url('/services/gen-ai-architecture')); ?>" class="service-card reveal-up" data-delay="2">
                    <div class="service-card-icon gradient-gen-ai">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                            <path d="M2 17l10 5 10-5"/>
                            <path d="M2 12l10 5 10-5"/>
                        </svg>
                    </div>
                    <h2 class="service-card-title"><?php esc_html_e('Gen AI Architecture', 'bfluxco'); ?></h2>
                    <p class="service-card-desc"><?php esc_html_e('Strategic AI implementation that integrates generative AI into your products and workflows meaningfully.', 'bfluxco'); ?></p>
                    <span class="service-card-link"><?php esc_html_e('Learn more', 'bfluxco'); ?> &rarr;</span>
                </a>

                <!-- Customer Research -->
                <a href="<?php echo esc_url(home_url('/services/customer-research')); ?>" class="service-card reveal-up" data-delay="3">
                    <div class="service-card-icon gradient-customer-research">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <circle cx="11" cy="11" r="8"/>
                            <path d="M21 21l-4.35-4.35"/>
                            <path d="M11 8v6"/>
                            <path d="M8 11h6"/>
                        </svg>
                    </div>
                    <h2 class="service-card-title"><?php esc_html_e('Customer Research', 'bfluxco'); ?></h2>
                    <p class="service-card-desc"><?php esc_html_e('Deep customer insights through qualitative and quantitative research that inform strategic decisions.', 'bfluxco'); ?></p>
                    <span class="service-card-link"><?php esc_html_e('Learn more', 'bfluxco'); ?> &rarr;</span>
                </a>

                <!-- Digital Twins -->
                <a href="<?php echo esc_url(home_url('/services/digital-twins')); ?>" class="service-card reveal-up" data-delay="4">
                    <div class="service-card-icon gradient-digital-twins">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"/>
                            <path d="M8 21h8"/>
                            <path d="M12 17v4"/>
                        </svg>
                    </div>
                    <h2 class="service-card-title"><?php esc_html_e('Digital Twins', 'bfluxco'); ?></h2>
                    <p class="service-card-desc"><?php esc_html_e('Virtual replicas of physical systems that enable simulation, monitoring, and optimization at scale.', 'bfluxco'); ?></p>
                    <span class="service-card-link"><?php esc_html_e('Learn more', 'bfluxco'); ?> &rarr;</span>
                </a>

                <!-- Conversation Design -->
                <a href="<?php echo esc_url(home_url('/services/conversation-design')); ?>" class="service-card reveal-up" data-delay="5">
                    <div class="service-card-icon gradient-conversation-design">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                        </svg>
                    </div>
                    <h2 class="service-card-title"><?php esc_html_e('Conversation Design', 'bfluxco'); ?></h2>
                    <p class="service-card-desc"><?php esc_html_e('Human-centered conversational experiences for chatbots, voice assistants, and AI-powered interfaces.', 'bfluxco'); ?></p>
                    <span class="service-card-link"><?php esc_html_e('Learn more', 'bfluxco'); ?> &rarr;</span>
                </a>

                <!-- Workshops -->
                <a href="<?php echo esc_url(home_url('/services/workshops')); ?>" class="service-card reveal-up" data-delay="6">
                    <div class="service-card-icon gradient-workshops">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                    </div>
                    <h2 class="service-card-title"><?php esc_html_e('Workshops', 'bfluxco'); ?></h2>
                    <p class="service-card-desc"><?php esc_html_e('Collaborative sessions that align teams, accelerate decision-making, and unlock strategic clarity.', 'bfluxco'); ?></p>
                    <span class="service-card-link"><?php esc_html_e('Learn more', 'bfluxco'); ?> &rarr;</span>
                </a>

            </div>
        </div>
    </section><!-- Services Grid -->

    <?php
    get_template_part('template-parts/section-cta', null, array(
        'heading' => __('Ready to Get Started?', 'bfluxco'),
        'description' => __("Let's discuss how these services can help solve your business challenges.", 'bfluxco'),
        'button_text' => __('Start a Conversation', 'bfluxco'),
    ));
    ?>

</main><!-- #main-content -->

<?php
get_footer();
