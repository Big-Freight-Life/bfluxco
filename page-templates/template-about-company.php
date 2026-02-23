<?php
/**
 * Template Name: About Company
 * Template Post Type: page
 *
 * Premium immersive experience for the Big Freight Life company page.
 * URL: /about/bfl
 *
 * @package BFLUXCO
 */

get_header();
?>

<main id="main-content" class="site-main about-company-page">

    <?php while (have_posts()) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class('about-company'); ?>>

            <!-- HERO: Full-viewport immersive intro -->
            <section class="bfl-hero">
                <div class="bfl-hero-bg">
                    <div class="bfl-hero-gradient"></div>
                    <div class="bfl-hero-grid"></div>
                    <div class="bfl-hero-particles" id="bfl-particles"></div>
                </div>

                <div class="bfl-hero-content">
                    <div class="bfl-hero-wordmark">
                        <svg class="bfl-wordmark-svg" viewBox="0 0 1000 320" preserveAspectRatio="xMidYMid meet" aria-label="Big Freight Life">
                            <defs>
                                <linearGradient id="wordmark-gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" style="stop-color:#24A89C"/>
                                    <stop offset="50%" style="stop-color:#2DD4BF"/>
                                    <stop offset="100%" style="stop-color:#24A89C"/>
                                </linearGradient>
                            </defs>
                            <text class="bfl-wordmark-text" x="500" y="120" text-anchor="middle">BIG</text>
                            <text class="bfl-wordmark-text" x="500" y="220" text-anchor="middle">FREIGHT</text>
                            <text class="bfl-wordmark-text" x="500" y="320" text-anchor="middle">LIFE</text>
                        </svg>
                    </div>

                    <p class="bfl-hero-tagline reveal-up">
                        <?php esc_html_e('Designing systems that carry weight responsibly.', 'bfluxco'); ?>
                    </p>
                </div>

                <div class="bfl-hero-scroll">
                    <span><?php esc_html_e('Scroll to explore', 'bfluxco'); ?></span>
                    <div class="bfl-scroll-line"></div>
                </div>
            </section>

            <!-- SECTION 1: Why Big Freight Life -->
            <section class="bfl-section bfl-why">
                <div class="bfl-section-bg">
                    <div class="bfl-floating-shape bfl-shape-1"></div>
                    <div class="bfl-floating-shape bfl-shape-2"></div>
                </div>

                <div class="container">
                    <div class="bfl-split">
                        <div class="bfl-split-content">
                            <span class="bfl-section-label reveal-up"><?php esc_html_e('The Philosophy', 'bfluxco'); ?></span>
                            <h2 class="bfl-section-title reveal-up" data-delay="1">
                                <?php esc_html_e('Why', 'bfluxco'); ?><br>
                                <span class="text-accent"><?php esc_html_e('Big Freight Life', 'bfluxco'); ?></span>
                            </h2>

                            <div class="bfl-prose reveal-up" data-delay="2">
                                <p class="bfl-lead">
                                    <?php esc_html_e('Big Freight Life reflects a simple belief: real work carries responsibility.', 'bfluxco'); ?>
                                </p>
                                <p>
                                    <?php esc_html_e('In logistics, freight represents obligation, cost, timing, and consequence. Once it\'s in motion, it has to be carried carefully to its destination. Decisions in organizations work the same way. They move through systems, compound over time, and shape outcomes long after they\'re made.', 'bfluxco'); ?>
                                </p>
                                <p class="bfl-emphasis">
                                    <?php esc_html_e('Big Freight Life exists to acknowledge that weight—and to design systems that can carry it responsibly.', 'bfluxco'); ?>
                                </p>
                            </div>
                        </div>

                        <div class="bfl-split-visual reveal-scale" data-delay="2">
                            <div class="bfl-visual-freight">
                                <div class="bfl-freight-container">
                                    <div class="bfl-freight-box bfl-freight-1"></div>
                                    <div class="bfl-freight-box bfl-freight-2"></div>
                                    <div class="bfl-freight-box bfl-freight-3"></div>
                                </div>
                                <div class="bfl-freight-platform"></div>
                                <div class="bfl-freight-shadow"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- PULL QUOTE: Transition -->
            <section class="bfl-pullquote">
                <div class="bfl-pullquote-bg"></div>
                <div class="container">
                    <blockquote class="bfl-quote reveal-up">
                        <span class="bfl-quote-mark">"</span>
                        <p><?php esc_html_e('Speed without structure usually shifts risk instead of reducing it.', 'bfluxco'); ?></p>
                    </blockquote>
                </div>
            </section>

            <!-- SECTION 2: Clarity Before Speed -->
            <section class="bfl-section bfl-clarity">
                <div class="container">
                    <div class="bfl-split bfl-split-reverse">
                        <div class="bfl-split-visual reveal-scale">
                            <div class="bfl-visual-lens">
                                <div class="bfl-lens-ring bfl-lens-1"></div>
                                <div class="bfl-lens-ring bfl-lens-2"></div>
                                <div class="bfl-lens-ring bfl-lens-3"></div>
                                <div class="bfl-lens-core"></div>
                                <div class="bfl-lens-flare"></div>
                            </div>
                        </div>

                        <div class="bfl-split-content">
                            <span class="bfl-section-label reveal-up"><?php esc_html_e('The Approach', 'bfluxco'); ?></span>
                            <h2 class="bfl-section-title reveal-up" data-delay="1">
                                <?php esc_html_e('Clarity', 'bfluxco'); ?><br>
                                <span class="text-accent"><?php esc_html_e('Before Speed', 'bfluxco'); ?></span>
                            </h2>

                            <div class="bfl-prose reveal-up" data-delay="2">
                                <p>
                                    <?php esc_html_e('Small and growing businesses are often under pressure to move quickly: adopt AI, automate processes, and keep pace with larger competitors. But speed without structure usually shifts risk instead of reducing it.', 'bfluxco'); ?>
                                </p>
                                <p>
                                    <?php esc_html_e('When systems are designed without clear understanding, the cost shows up later—in exceptions, rework, operational friction, and loss of trust. The problem isn\'t complexity itself. It\'s complexity that hasn\'t been recognized or designed for.', 'bfluxco'); ?>
                                </p>
                                <p class="bfl-emphasis">
                                    <?php esc_html_e('Our work focuses on making that complexity visible before it compounds.', 'bfluxco'); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- SECTION 3: Responsibility in System Design -->
            <section class="bfl-section bfl-responsibility">
                <div class="bfl-section-bg bfl-responsibility-bg">
                    <div class="bfl-network-lines"></div>
                </div>

                <div class="container">
                    <div class="bfl-centered-content">
                        <span class="bfl-section-label reveal-up"><?php esc_html_e('The Principle', 'bfluxco'); ?></span>
                        <h2 class="bfl-section-title bfl-title-centered reveal-up" data-delay="1">
                            <?php esc_html_e('Responsibility in', 'bfluxco'); ?><br>
                            <span class="text-accent"><?php esc_html_e('System Design', 'bfluxco'); ?></span>
                        </h2>

                        <div class="bfl-prose bfl-prose-centered reveal-up" data-delay="2">
                            <p class="bfl-lead">
                                <?php esc_html_e('Automation doesn\'t remove responsibility. It redistributes it across people, processes, and technology.', 'bfluxco'); ?>
                            </p>
                        </div>

                        <!-- Animated Network Visual -->
                        <div class="bfl-network-visual reveal-scale" data-delay="3">
                            <div class="bfl-network">
                                <div class="bfl-node bfl-node-center">
                                    <span><?php esc_html_e('Decision', 'bfluxco'); ?></span>
                                </div>
                                <div class="bfl-node bfl-node-1"><span><?php esc_html_e('People', 'bfluxco'); ?></span></div>
                                <div class="bfl-node bfl-node-2"><span><?php esc_html_e('Process', 'bfluxco'); ?></span></div>
                                <div class="bfl-node bfl-node-3"><span><?php esc_html_e('Technology', 'bfluxco'); ?></span></div>
                                <svg class="bfl-network-connections" viewBox="0 0 400 400">
                                    <line class="bfl-connection" x1="200" y1="200" x2="200" y2="60"/>
                                    <line class="bfl-connection" x1="200" y1="200" x2="80" y2="300"/>
                                    <line class="bfl-connection" x1="200" y1="200" x2="320" y2="300"/>
                                    <line class="bfl-connection bfl-connection-arc" x1="200" y1="60" x2="80" y2="300"/>
                                    <line class="bfl-connection bfl-connection-arc" x1="200" y1="60" x2="320" y2="300"/>
                                    <line class="bfl-connection bfl-connection-arc" x1="80" y1="300" x2="320" y2="300"/>
                                </svg>
                            </div>
                        </div>

                        <div class="bfl-prose bfl-prose-centered reveal-up" data-delay="4">
                            <p>
                                <?php esc_html_e('Big Freight Life was built on the idea that systems should be designed with a clear understanding of what they are responsible for, who carries that responsibility, and how decisions travel through the organization over time.', 'bfluxco'); ?>
                            </p>
                            <p class="bfl-emphasis">
                                <?php esc_html_e('That means slowing down just enough to understand what\'s being built before accelerating execution.', 'bfluxco'); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- CLOSING: Statement -->
            <section class="bfl-closing">
                <div class="bfl-closing-bg">
                    <div class="bfl-closing-gradient"></div>
                    <div class="bfl-closing-texture"></div>
                </div>

                <div class="container">
                    <div class="bfl-closing-content">
                        <p class="bfl-closing-intro reveal-up">
                            <?php esc_html_e('Big Freight Life is about designing systems that hold up under real-world conditions.', 'bfluxco'); ?>
                        </p>

                        <div class="bfl-closing-statement reveal-up" data-delay="1">
                            <p class="bfl-statement-line"><?php esc_html_e('Not everything needs to move faster.', 'bfluxco'); ?></p>
                            <p class="bfl-statement-emphasis"><?php esc_html_e('Some things need to be understood first.', 'bfluxco'); ?></p>
                        </div>
                    </div>
                </div>
            </section>

        </article>

    <?php endwhile; ?>

    <!-- CTA: The Person Behind -->
    <section class="bfl-cta">
        <div class="container">
            <div class="bfl-cta-content">
                <span class="bfl-section-label reveal-up"><?php esc_html_e('The Founder', 'bfluxco'); ?></span>
                <h2 class="bfl-cta-title reveal-up" data-delay="1">
                    <?php esc_html_e('The Person Behind the Work', 'bfluxco'); ?>
                </h2>
                <p class="bfl-cta-text reveal-up" data-delay="2">
                    <?php esc_html_e('Big Freight Life was founded by Ray Butler—a designer and systems thinker focused on helping small businesses navigate complexity with intention.', 'bfluxco'); ?>
                </p>
                <div class="bfl-cta-buttons reveal-up" data-delay="3">
                    <a href="<?php echo esc_url(home_url('/about/ray')); ?>" class="btn btn-primary btn-lg">
                        <?php esc_html_e('Meet Ray Butler', 'bfluxco'); ?>
                    </a>
                    <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-outline btn-lg">
                        <?php esc_html_e('Get in Touch', 'bfluxco'); ?>
                    </a>
                </div>
            </div>
        </div>
    </section>

</main>

<?php
get_footer();
?>
