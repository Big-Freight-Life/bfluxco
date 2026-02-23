<?php
/**
 * Template Name: Transformation
 * Template Post Type: page
 *
 * Award-winning Transformation services page.
 * URL: /transformation
 *
 * @package BFLUXCO
 */

get_header();
?>

<main id="main-content" class="site-main transformation-page">

    <!-- Hero: Typographic Statement -->
    <header class="transform-hero">
        <div class="container">
            <div class="transform-hero-content">
                <span class="transform-hero-eyebrow reveal-text"><?php esc_html_e('Transformation', 'bfluxco'); ?></span>
                <h1 class="transform-hero-title">
                    <span class="reveal-text" data-delay="1"><?php esc_html_e('Build teams that', 'bfluxco'); ?></span>
                    <span class="transform-hero-accent reveal-text" data-delay="2"><?php esc_html_e('don\'t need you.', 'bfluxco'); ?></span>
                </h1>
                <p class="transform-hero-sub reveal-text" data-delay="3">
                    <?php esc_html_e('The best transformation work ends with independence, not dependency.', 'bfluxco'); ?>
                </p>
            </div>
        </div>
        <div class="transform-hero-scroll reveal-up" data-delay="4">
            <span><?php esc_html_e('Scroll', 'bfluxco'); ?></span>
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M12 5v14M19 12l-7 7-7-7"/>
            </svg>
        </div>
    </header>

    <!-- Introduction Section - Cinematic Philosophy -->
    <section class="section transform-intro">
        <div class="transform-intro-inner">
            <!-- Video Side -->
            <div class="transform-intro-media reveal-up">
                <figure class="transform-video-figure">
                    <div class="transform-video-wrapper">
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/transformation-dancer.jpg'); ?>" alt="<?php esc_attr_e('Transformation video preview', 'bfluxco'); ?>">
                        <button class="video-play-btn" data-video-url="https://www.youtube.com/embed/dQw4w9WgXcQ" aria-label="<?php esc_attr_e('Play video', 'bfluxco'); ?>">
                            <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="40" cy="40" r="39" stroke="currentColor" stroke-width="2" fill="rgba(0,0,0,0.3)"/>
                                <path d="M32 24L56 40L32 56V24Z" fill="currentColor"/>
                            </svg>
                        </button>
                    </div>
                    <figcaption class="transform-video-caption"><?php esc_html_e('The performance of a lifetime', 'bfluxco'); ?></figcaption>
                </figure>
            </div>

            <!-- Content Side -->
            <div class="transform-intro-content">
                <div class="transform-intro-text">
                    <p class="transform-intro-lead reveal-text">
                        <?php esc_html_e('Transformation isn\'t about adopting the latest framework or chasing the next trend.', 'bfluxco'); ?>
                    </p>
                    <p class="transform-intro-highlight reveal-text" data-delay="1">
                        <?php esc_html_e('It\'s about building durable capabilities that compound over time.', 'bfluxco'); ?>
                    </p>
                    <p class="transform-intro-body reveal-text" data-delay="2">
                        <?php esc_html_e('We work with teams to strengthen how they think, decide, and collaborate—especially in complex environments shaped by emerging technologies like GenAI. The goal isn\'t dependency. It\'s confidence, clarity, and the ability to navigate ambiguity independently.', 'bfluxco'); ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Services: Editorial Staggered Layout -->
    <section class="section transform-services">
        <div class="container">
            <header class="transform-services-header">
                <span class="section-label reveal-text"><?php esc_html_e('How We Help', 'bfluxco'); ?></span>
                <h2 class="transform-services-title reveal-text" data-delay="1">
                    <?php esc_html_e('Three ways to work together', 'bfluxco'); ?>
                </h2>
            </header>

            <div class="transform-services-grid">
                <!-- Service 1: Workshops -->
                <article class="transform-service-card reveal-up" data-delay="1">
                    <div class="transform-service-number">01</div>
                    <div class="transform-service-content">
                        <h3 class="transform-service-title"><?php esc_html_e('Team Workshops', 'bfluxco'); ?></h3>
                        <p class="transform-service-desc">
                            <?php esc_html_e('Focused, hands-on sessions designed to shift how teams frame problems, make decisions, and work together.', 'bfluxco'); ?>
                        </p>
                        <ul class="transform-service-list">
                            <li><?php esc_html_e('Problem framing and systems thinking', 'bfluxco'); ?></li>
                            <li><?php esc_html_e('Shared language across roles', 'bfluxco'); ?></li>
                            <li><?php esc_html_e('Practical tools that outlast the session', 'bfluxco'); ?></li>
                        </ul>
                        <p class="transform-service-note">
                            <?php esc_html_e('Tailored to real challenges—not hypothetical exercises.', 'bfluxco'); ?>
                        </p>
                    </div>
                    <div class="transform-service-visual">
                        <svg viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="40" cy="50" r="16" stroke="currentColor" stroke-width="1.5"/>
                            <circle cx="80" cy="50" r="16" stroke="currentColor" stroke-width="1.5"/>
                            <circle cx="60" cy="85" r="16" stroke="currentColor" stroke-width="1.5"/>
                            <line x1="52" y1="58" x2="68" y2="73" stroke="currentColor" stroke-width="1.5"/>
                            <line x1="68" y1="58" x2="52" y2="73" stroke="currentColor" stroke-width="1.5"/>
                        </svg>
                    </div>
                </article>

                <!-- Service 2: Coaching -->
                <article class="transform-service-card transform-service-card--offset reveal-up" data-delay="2">
                    <div class="transform-service-number">02</div>
                    <div class="transform-service-content">
                        <h3 class="transform-service-title"><?php esc_html_e('Leadership Coaching', 'bfluxco'); ?></h3>
                        <p class="transform-service-desc">
                            <?php esc_html_e('One-on-one guidance for leaders navigating complexity, scale, and change.', 'bfluxco'); ?>
                        </p>
                        <ul class="transform-service-list">
                            <li><?php esc_html_e('Decision-making under uncertainty', 'bfluxco'); ?></li>
                            <li><?php esc_html_e('Leading through ambiguity and constraint', 'bfluxco'); ?></li>
                            <li><?php esc_html_e('Bridging strategy, design, and execution', 'bfluxco'); ?></li>
                        </ul>
                        <p class="transform-service-note">
                            <?php esc_html_e('Clarity and judgment—not performance theater.', 'bfluxco'); ?>
                        </p>
                    </div>
                    <div class="transform-service-visual">
                        <svg viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M60 20L60 100" stroke="currentColor" stroke-width="1.5"/>
                            <circle cx="60" cy="35" r="12" stroke="currentColor" stroke-width="1.5"/>
                            <path d="M40 60L60 50L80 60" stroke="currentColor" stroke-width="1.5" fill="none"/>
                            <path d="M35 85L60 70L85 85" stroke="currentColor" stroke-width="1.5" fill="none"/>
                        </svg>
                    </div>
                </article>

                <!-- Service 3: Embedded Partnership -->
                <article class="transform-service-card reveal-up" data-delay="3">
                    <div class="transform-service-number">03</div>
                    <div class="transform-service-content">
                        <h3 class="transform-service-title"><?php esc_html_e('Embedded Partnership', 'bfluxco'); ?></h3>
                        <p class="transform-service-desc">
                            <?php esc_html_e('A deeper collaboration where we work alongside your team over time.', 'bfluxco'); ?>
                        </p>
                        <ul class="transform-service-list">
                            <li><?php esc_html_e('Knowledge transfer through real work', 'bfluxco'); ?></li>
                            <li><?php esc_html_e('Capability-building while solving problems', 'bfluxco'); ?></li>
                            <li><?php esc_html_e('Design thinking embedded into daily practice', 'bfluxco'); ?></li>
                        </ul>
                        <p class="transform-service-note">
                            <?php esc_html_e('Progress that sticks—because it\'s built into operations.', 'bfluxco'); ?>
                        </p>
                    </div>
                    <div class="transform-service-visual">
                        <svg viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="60" cy="60" r="35" stroke="currentColor" stroke-width="1.5"/>
                            <circle cx="60" cy="60" r="22" stroke="currentColor" stroke-width="1.5"/>
                            <circle cx="60" cy="60" r="8" fill="currentColor"/>
                        </svg>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <!-- Outcomes: Large-Scale Typography -->
    <section class="section transform-outcomes">
        <div class="container">
            <header class="transform-outcomes-header">
                <span class="section-label reveal-text"><?php esc_html_e('Outcomes', 'bfluxco'); ?></span>
                <h2 class="reveal-text" data-delay="1"><?php esc_html_e('What transformation looks like', 'bfluxco'); ?></h2>
            </header>

            <div class="transform-outcomes-grid">
                <div class="transform-outcome reveal-up" data-delay="1">
                    <div class="transform-outcome-icon">
                        <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5">
                            <circle cx="24" cy="24" r="20"/>
                            <path d="M24 14v10l7 7"/>
                        </svg>
                    </div>
                    <h3 class="transform-outcome-title"><?php esc_html_e('Confident Decisions', 'bfluxco'); ?></h3>
                    <p class="transform-outcome-desc">
                        <?php esc_html_e('Teams navigate ambiguity and make sound decisions without constant escalation or external validation.', 'bfluxco'); ?>
                    </p>
                </div>

                <div class="transform-outcome reveal-up" data-delay="2">
                    <div class="transform-outcome-icon">
                        <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M8 24h32"/>
                            <path d="M24 8v32"/>
                            <circle cx="24" cy="24" r="8"/>
                        </svg>
                    </div>
                    <h3 class="transform-outcome-title"><?php esc_html_e('Effective Collaboration', 'bfluxco'); ?></h3>
                    <p class="transform-outcome-desc">
                        <?php esc_html_e('Cross-functional teams communicate clearly, align faster, and work productively across disciplines.', 'bfluxco'); ?>
                    </p>
                </div>

                <div class="transform-outcome reveal-up" data-delay="3">
                    <div class="transform-outcome-icon">
                        <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M12 36L24 12L36 36"/>
                            <path d="M16 28h16"/>
                        </svg>
                    </div>
                    <h3 class="transform-outcome-title"><?php esc_html_e('Sustainable Practices', 'bfluxco'); ?></h3>
                    <p class="transform-outcome-desc">
                        <?php esc_html_e('Processes and habits that persist after the engagement ends—practical, understood, and owned.', 'bfluxco'); ?>
                    </p>
                </div>

                <div class="transform-outcome reveal-up" data-delay="4">
                    <div class="transform-outcome-icon">
                        <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5">
                            <polyline points="8,32 16,24 24,28 32,16 40,20"/>
                            <circle cx="40" cy="20" r="4" fill="currentColor"/>
                        </svg>
                    </div>
                    <h3 class="transform-outcome-title"><?php esc_html_e('Measurable Impact', 'bfluxco'); ?></h3>
                    <p class="transform-outcome-desc">
                        <?php esc_html_e('Clear improvements in decision quality, delivery velocity, and team confidence. Not just activity metrics.', 'bfluxco'); ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Process: Immersive Journey -->
    <section class="section transform-process">
        <div class="container">
            <header class="transform-process-header">
                <span class="section-label reveal-text"><?php esc_html_e('Process', 'bfluxco'); ?></span>
                <h2 class="transform-process-title reveal-text" data-delay="1">
                    <?php esc_html_e('How we work together', 'bfluxco'); ?>
                </h2>
            </header>

            <div class="transform-process-journey">
                <div class="transform-process-line"></div>

                <div class="transform-process-step reveal-up" data-delay="1">
                    <div class="transform-process-marker">
                        <span class="transform-process-number">01</span>
                    </div>
                    <div class="transform-process-content">
                        <h3><?php esc_html_e('Discovery', 'bfluxco'); ?></h3>
                        <p><?php esc_html_e('We start by understanding your current state: team dynamics, challenges, goals, constraints, and context. No assumptions. No templates.', 'bfluxco'); ?></p>
                    </div>
                </div>

                <div class="transform-process-step reveal-up" data-delay="2">
                    <div class="transform-process-marker">
                        <span class="transform-process-number">02</span>
                    </div>
                    <div class="transform-process-content">
                        <h3><?php esc_html_e('Design', 'bfluxco'); ?></h3>
                        <p><?php esc_html_e('Together, we shape an approach tailored to your organization—grounded in how your systems, services, and people actually operate.', 'bfluxco'); ?></p>
                    </div>
                </div>

                <div class="transform-process-step reveal-up" data-delay="3">
                    <div class="transform-process-marker">
                        <span class="transform-process-number">03</span>
                    </div>
                    <div class="transform-process-content">
                        <h3><?php esc_html_e('Deliver', 'bfluxco'); ?></h3>
                        <p><?php esc_html_e('Execution happens through workshops, coaching, and hands-on collaboration. Learning happens in real time, alongside real work.', 'bfluxco'); ?></p>
                    </div>
                </div>

                <div class="transform-process-step reveal-up" data-delay="4">
                    <div class="transform-process-marker">
                        <span class="transform-process-number">04</span>
                    </div>
                    <div class="transform-process-content">
                        <h3><?php esc_html_e('Sustain', 'bfluxco'); ?></h3>
                        <p><?php esc_html_e('Changes are reinforced through documentation, shared practices, and follow-up support—so progress continues after the engagement ends.', 'bfluxco'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statement Section -->
    <section class="section transform-statement">
        <div class="container">
            <blockquote class="featured-quote reveal-text">
                <p class="quote-setup"><?php esc_html_e('The measure of good transformation work is simple:', 'bfluxco'); ?></p>
                <p class="quote-emphasis"><?php esc_html_e('Does the team need you less than when you started?', 'bfluxco'); ?></p>
            </blockquote>
        </div>
    </section>

</main><!-- #main-content -->

<!-- CTA + Footer with shared background -->
<div class="cta-footer-wrapper" style="background-image: url('<?php echo esc_url(get_template_directory_uri() . '/assets/images/team-collaboration.png'); ?>');">
    <!-- CTA Section -->
    <section class="section text-center cta-hero">
        <div class="container">
            <h2 class="reveal-text"><?php esc_html_e('Ready to build lasting capability?', 'bfluxco'); ?></h2>
            <p class="max-w-2xl mx-auto mb-8 reveal-text" data-delay="1">
                <?php esc_html_e('Let\'s discuss how we can help your team build the clarity, confidence, and capabilities they need to thrive.', 'bfluxco'); ?>
            </p>
            <div class="reveal" data-delay="2">
                <button type="button" class="btn btn-primary btn-lg" id="transformation-chat-trigger" data-chat-context="transformation">
                    <?php esc_html_e('Start a Conversation', 'bfluxco'); ?>
                </button>
            </div>
        </div>
    </section>

    <?php get_template_part('template-parts/footer', 'content'); ?>
</div><!-- .cta-footer-wrapper -->

<?php get_template_part('template-parts/chat-interface', null, array('context' => 'transformation')); ?>

<!-- Video Modal -->
<div class="video-modal" id="video-modal" aria-hidden="true">
    <div class="video-modal-content">
        <button class="video-modal-close" aria-label="<?php esc_attr_e('Close video', 'bfluxco'); ?>">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
        <iframe id="video-iframe" src="" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
</div>

<?php wp_footer(); ?>
</body>
</html>
