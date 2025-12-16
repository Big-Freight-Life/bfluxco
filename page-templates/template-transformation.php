<?php
/**
 * Template Name: Transformation
 * Template Post Type: page
 *
 * This template displays the Transformation services page.
 * URL: /transformation
 *
 * @package BFLUXCO
 */

get_header();
?>

<main id="main-content" class="site-main">

    <?php
    get_template_part('template-parts/page-header', null, array(
        'description' => __('Elevate your team\'s capabilities through strategic design thinking and hands-on guidance.', 'bfluxco'),
        'use_excerpt' => true,
    ));
    ?>

    <!-- Introduction Section -->
    <section class="section">
        <div class="container container-narrow">
            <div class="service-content reveal-text">
                <p class="lead"><?php esc_html_e('Transformation isn\'t about following trends. It\'s about building lasting capabilities that compound over time.', 'bfluxco'); ?></p>
                <p><?php esc_html_e('I work with teams to develop the skills, mindsets, and practices they need to solve complex problems independently. The goal isn\'t dependency—it\'s empowerment.', 'bfluxco'); ?></p>
            </div>
        </div>
    </section>

    <!-- What I Offer Section -->
    <section class="section bg-gray-50">
        <div class="container">
            <h2 class="section-title text-center reveal-text"><?php esc_html_e('How I Help Teams Transform', 'bfluxco'); ?></h2>

            <div class="grid grid-3 gap-8 mt-12">
                <!-- Workshops -->
                <div class="service-card reveal-up" data-delay="1">
                    <div class="service-card-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                    </div>
                    <h3><?php esc_html_e('Team Workshops', 'bfluxco'); ?></h3>
                    <p><?php esc_html_e('Intensive, hands-on sessions that build practical skills in design thinking, problem framing, and collaborative decision-making.', 'bfluxco'); ?></p>
                </div>

                <!-- Coaching -->
                <div class="service-card reveal-up" data-delay="2">
                    <div class="service-card-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M12 20h9"></path>
                            <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                        </svg>
                    </div>
                    <h3><?php esc_html_e('Leadership Coaching', 'bfluxco'); ?></h3>
                    <p><?php esc_html_e('One-on-one guidance for design and product leaders navigating complex organizational challenges and team dynamics.', 'bfluxco'); ?></p>
                </div>

                <!-- Embedded Partnership -->
                <div class="service-card reveal-up" data-delay="3">
                    <div class="service-card-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="2" y1="12" x2="22" y2="12"></line>
                            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                        </svg>
                    </div>
                    <h3><?php esc_html_e('Embedded Partnership', 'bfluxco'); ?></h3>
                    <p><?php esc_html_e('Long-term collaboration where I work alongside your team, transferring knowledge and building capabilities as we solve real problems together.', 'bfluxco'); ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Outcomes Section -->
    <section class="section">
        <div class="container container-narrow">
            <h2 class="section-title reveal-text"><?php esc_html_e('What Transformation Looks Like', 'bfluxco'); ?></h2>

            <div class="outcomes-list mt-8">
                <div class="outcome-item reveal-up" data-delay="1">
                    <h3><?php esc_html_e('Confident Decision-Making', 'bfluxco'); ?></h3>
                    <p><?php esc_html_e('Teams that can navigate ambiguity and make sound decisions without constant escalation.', 'bfluxco'); ?></p>
                </div>

                <div class="outcome-item reveal-up" data-delay="2">
                    <h3><?php esc_html_e('Effective Collaboration', 'bfluxco'); ?></h3>
                    <p><?php esc_html_e('Cross-functional teams that communicate clearly and work together productively.', 'bfluxco'); ?></p>
                </div>

                <div class="outcome-item reveal-up" data-delay="3">
                    <h3><?php esc_html_e('Sustainable Practices', 'bfluxco'); ?></h3>
                    <p><?php esc_html_e('Processes and habits that stick long after the engagement ends.', 'bfluxco'); ?></p>
                </div>

                <div class="outcome-item reveal-up" data-delay="4">
                    <h3><?php esc_html_e('Measurable Impact', 'bfluxco'); ?></h3>
                    <p><?php esc_html_e('Clear improvements in velocity, quality, and team satisfaction.', 'bfluxco'); ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Process Section -->
    <section class="section bg-gray-50">
        <div class="container container-narrow">
            <h2 class="section-title reveal-text"><?php esc_html_e('How We Work Together', 'bfluxco'); ?></h2>

            <div class="process-steps mt-8">
                <div class="process-step reveal-up" data-delay="1">
                    <span class="step-number">01</span>
                    <div class="step-content">
                        <h3><?php esc_html_e('Discovery', 'bfluxco'); ?></h3>
                        <p><?php esc_html_e('We start by understanding your current state—team dynamics, challenges, goals, and constraints.', 'bfluxco'); ?></p>
                    </div>
                </div>

                <div class="process-step reveal-up" data-delay="2">
                    <span class="step-number">02</span>
                    <div class="step-content">
                        <h3><?php esc_html_e('Design', 'bfluxco'); ?></h3>
                        <p><?php esc_html_e('Together we craft a transformation approach tailored to your specific context and objectives.', 'bfluxco'); ?></p>
                    </div>
                </div>

                <div class="process-step reveal-up" data-delay="3">
                    <span class="step-number">03</span>
                    <div class="step-content">
                        <h3><?php esc_html_e('Deliver', 'bfluxco'); ?></h3>
                        <p><?php esc_html_e('We execute through workshops, coaching, and hands-on collaboration—learning and adapting as we go.', 'bfluxco'); ?></p>
                    </div>
                </div>

                <div class="process-step reveal-up" data-delay="4">
                    <span class="step-number">04</span>
                    <div class="step-content">
                        <h3><?php esc_html_e('Sustain', 'bfluxco'); ?></h3>
                        <p><?php esc_html_e('We ensure changes stick through documentation, practice reinforcement, and follow-up support.', 'bfluxco'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="section text-center">
        <div class="container">
            <h2 class="reveal-text"><?php esc_html_e('Ready to Transform Your Team?', 'bfluxco'); ?></h2>
            <p class="text-gray-600 max-w-2xl mx-auto mb-8 reveal-text" data-delay="1">
                <?php esc_html_e('Let\'s discuss how I can help your team build the capabilities they need to thrive.', 'bfluxco'); ?>
            </p>
            <div class="reveal" data-delay="2">
                <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-primary btn-lg">
                    <?php esc_html_e('Start a Conversation', 'bfluxco'); ?>
                </a>
            </div>
        </div>
    </section>

</main><!-- #main-content -->

<?php
get_footer();
