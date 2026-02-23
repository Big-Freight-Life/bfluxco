<?php
/**
 * Template Name: Experience Design
 * Template Post Type: page
 *
 * Designing Experiences as Systems - capability page.
 *
 * @package BFLUXCO
 */

get_header();
?>

<main id="main-content" class="site-main experience-design-page">

    <!-- Hero Section -->
    <header class="xd-hero">
        <div class="xd-hero-visual">
            <div class="xd-hero-grid">
                <?php for ($i = 0; $i < 64; $i++) : ?>
                    <div class="xd-grid-cell" style="animation-delay: <?php echo ($i * 0.02); ?>s;"></div>
                <?php endfor; ?>
            </div>
            <div class="xd-hero-orb xd-hero-orb-1"></div>
            <div class="xd-hero-orb xd-hero-orb-2"></div>
        </div>
        <div class="container">
            <div class="xd-hero-content">
                <span class="xd-hero-label reveal-hero"><?php esc_html_e('Experience Design', 'bfluxco'); ?></span>
                <h1 class="xd-hero-title reveal-hero" data-delay="1"><?php esc_html_e('Designing Experiences as Systems', 'bfluxco'); ?></h1>
                <p class="xd-hero-tagline reveal-hero" data-delay="2"><?php esc_html_e('Experiences are shaped by structure before they\'re shaped by interfaces.', 'bfluxco'); ?></p>
            </div>
        </div>
    </header>

    <!-- Introduction Section -->
    <section class="xd-section xd-intro">
        <div class="container container-narrow">
            <div class="xd-intro-content reveal-up">
                <p class="xd-lead"><?php esc_html_e('What people experience isn\'t just what they see on a screen. It\'s how goals are set, how information flows, how decisions are made, and how the system responds over time.', 'bfluxco'); ?></p>
                <p><?php esc_html_e('When those elements aren\'t aligned, even well-designed interfaces struggle to hold up in real-world use.', 'bfluxco'); ?></p>
                <p class="xd-emphasis"><?php esc_html_e('Our work focuses on designing experiences from the inside out—so what people encounter makes sense because the system beneath it does.', 'bfluxco'); ?></p>
            </div>
        </div>
    </section>

    <!-- How We Approach Section -->
    <section class="xd-section xd-approach">
        <div class="container">
            <div class="xd-approach-grid">
                <div class="xd-approach-content reveal-up">
                    <h2 class="xd-approach-title"><?php esc_html_e('How We Approach Experience Design', 'bfluxco'); ?></h2>
                    <p class="xd-approach-lead"><?php esc_html_e('We start by clarifying intent—what the system is meant to enable and what decisions it needs to support. From there, we design structure before interaction, ensuring roles, information, and constraints are clear before shaping interfaces.', 'bfluxco'); ?></p>
                    <p><?php esc_html_e('Our work moves from the inside out. Visual design expresses underlying logic rather than compensating for its absence. The result is experiences that remain understandable over time, even as conditions change.', 'bfluxco'); ?></p>
                </div>
                <div class="xd-approach-visual reveal-up" data-delay="1">
                    <div class="xd-approach-diagram">
                        <div class="xd-approach-layer xd-layer-core">
                            <span><?php esc_html_e('Intent', 'bfluxco'); ?></span>
                        </div>
                        <div class="xd-approach-layer xd-layer-mid">
                            <span><?php esc_html_e('Structure', 'bfluxco'); ?></span>
                        </div>
                        <div class="xd-approach-layer xd-layer-outer">
                            <span><?php esc_html_e('Interface', 'bfluxco'); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- From Intent to Outcome -->
    <section class="xd-section xd-feature xd-feature-intent">
        <div class="container">
            <div class="xd-feature-grid">
                <div class="xd-feature-visual reveal-up">
                    <div class="xd-visual-frame">
                        <div class="xd-visual-placeholder xd-visual-intent">
                            <div class="xd-intent-diagram">
                                <div class="xd-intent-node xd-intent-start">
                                    <span><?php esc_html_e('Intent', 'bfluxco'); ?></span>
                                </div>
                                <div class="xd-intent-line"></div>
                                <div class="xd-intent-node xd-intent-mid">
                                    <span><?php esc_html_e('Structure', 'bfluxco'); ?></span>
                                </div>
                                <div class="xd-intent-line"></div>
                                <div class="xd-intent-node xd-intent-mid">
                                    <span><?php esc_html_e('Interaction', 'bfluxco'); ?></span>
                                </div>
                                <div class="xd-intent-line"></div>
                                <div class="xd-intent-node xd-intent-end">
                                    <span><?php esc_html_e('Outcome', 'bfluxco'); ?></span>
                                </div>
                            </div>
                        </div>
                        <span class="xd-visual-caption"><?php esc_html_e('The progression from intent to outcome', 'bfluxco'); ?></span>
                    </div>
                </div>
                <div class="xd-feature-content reveal-up" data-delay="1">
                    <span class="xd-section-label"><?php esc_html_e('01', 'bfluxco'); ?></span>
                    <h2 class="xd-feature-title"><?php esc_html_e('From Intent to Outcome', 'bfluxco'); ?></h2>
                    <p><?php esc_html_e('Every experience begins with intent, whether it\'s clearly articulated or not. When intent is vague, systems drift. When intent is clear, design decisions have a foundation to stand on.', 'bfluxco'); ?></p>
                    <p><?php esc_html_e('We help teams define what an experience is meant to enable before shaping how it looks or behaves. That intent informs structure, structure informs interaction, and interaction shapes outcomes.', 'bfluxco'); ?></p>
                    <p class="xd-highlight"><?php esc_html_e('This progression creates experiences that feel coherent—not because they are simplified, but because they are well-ordered.', 'bfluxco'); ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Structure Creates Clarity -->
    <section class="xd-section xd-feature xd-feature-structure xd-feature-reverse">
        <div class="container">
            <div class="xd-feature-grid">
                <div class="xd-feature-content reveal-up">
                    <span class="xd-section-label"><?php esc_html_e('02', 'bfluxco'); ?></span>
                    <h2 class="xd-feature-title"><?php esc_html_e('Structure Creates Clarity', 'bfluxco'); ?></h2>
                    <p class="xd-callout"><?php esc_html_e('Most experience problems aren\'t usability problems. They\'re structural ones.', 'bfluxco'); ?></p>
                    <p><?php esc_html_e('When responsibilities are unclear, information is scattered, or decisions are buried inside tools, users are forced to compensate. Over time, that friction becomes the experience.', 'bfluxco'); ?></p>
                    <p><?php esc_html_e('We design the underlying structure that supports an experience: roles, relationships, flows, and constraints. This makes interactions easier to navigate and decisions easier to understand—especially when conditions change.', 'bfluxco'); ?></p>
                </div>
                <div class="xd-feature-visual reveal-up" data-delay="1">
                    <div class="xd-visual-frame">
                        <div class="xd-visual-placeholder xd-visual-structure">
                            <div class="xd-structure-diagram">
                                <div class="xd-structure-layer xd-layer-1">
                                    <span><?php esc_html_e('Roles', 'bfluxco'); ?></span>
                                </div>
                                <div class="xd-structure-layer xd-layer-2">
                                    <span><?php esc_html_e('Relationships', 'bfluxco'); ?></span>
                                </div>
                                <div class="xd-structure-layer xd-layer-3">
                                    <span><?php esc_html_e('Flows', 'bfluxco'); ?></span>
                                </div>
                                <div class="xd-structure-layer xd-layer-4">
                                    <span><?php esc_html_e('Constraints', 'bfluxco'); ?></span>
                                </div>
                            </div>
                        </div>
                        <span class="xd-visual-caption"><?php esc_html_e('Structural layers of experience', 'bfluxco'); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Designing Across Time -->
    <section class="xd-section xd-feature xd-feature-time">
        <div class="container">
            <div class="xd-feature-grid">
                <div class="xd-feature-visual reveal-up">
                    <div class="xd-visual-frame">
                        <div class="xd-visual-placeholder xd-visual-time">
                            <div class="xd-timeline">
                                <div class="xd-timeline-phase xd-phase-before">
                                    <div class="xd-phase-marker"></div>
                                    <span><?php esc_html_e('Before', 'bfluxco'); ?></span>
                                </div>
                                <div class="xd-timeline-connector"></div>
                                <div class="xd-timeline-phase xd-phase-during">
                                    <div class="xd-phase-marker xd-phase-active"></div>
                                    <span><?php esc_html_e('During', 'bfluxco'); ?></span>
                                </div>
                                <div class="xd-timeline-connector"></div>
                                <div class="xd-timeline-phase xd-phase-after">
                                    <div class="xd-phase-marker"></div>
                                    <span><?php esc_html_e('After', 'bfluxco'); ?></span>
                                </div>
                            </div>
                        </div>
                        <span class="xd-visual-caption"><?php esc_html_e('Experiences unfold across time', 'bfluxco'); ?></span>
                    </div>
                </div>
                <div class="xd-feature-content reveal-up" data-delay="1">
                    <span class="xd-section-label"><?php esc_html_e('03', 'bfluxco'); ?></span>
                    <h2 class="xd-feature-title"><?php esc_html_e('Designing Across Time', 'bfluxco'); ?></h2>
                    <p class="xd-callout"><?php esc_html_e('Experiences don\'t happen in a single moment. They unfold.', 'bfluxco'); ?></p>
                    <p><?php esc_html_e('We design for what happens before an interaction, during it, and after it—across sessions, roles, and states. This includes how systems handle exceptions, how feedback is communicated, and how people regain orientation when something goes wrong.', 'bfluxco'); ?></p>
                    <p class="xd-highlight"><?php esc_html_e('Designing across time ensures experiences remain usable under pressure, not just in ideal conditions.', 'bfluxco'); ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Experience as Decision Support -->
    <section class="xd-section xd-feature xd-feature-decision xd-feature-reverse">
        <div class="container">
            <div class="xd-feature-grid">
                <div class="xd-feature-content reveal-up">
                    <span class="xd-section-label"><?php esc_html_e('04', 'bfluxco'); ?></span>
                    <h2 class="xd-feature-title"><?php esc_html_e('Experience as Decision Support', 'bfluxco'); ?></h2>
                    <p class="xd-callout"><?php esc_html_e('At its best, experience design helps people make better decisions with less effort.', 'bfluxco'); ?></p>
                    <p><?php esc_html_e('Our approach treats experience design as a form of decision support. We focus on making options visible, consequences understandable, and actions intentional—especially in systems that involve automation or AI, where errors can scale quickly.', 'bfluxco'); ?></p>
                    <p class="xd-highlight"><?php esc_html_e('An experience that supports judgment builds trust. One that obscures it erodes confidence.', 'bfluxco'); ?></p>
                </div>
                <div class="xd-feature-visual reveal-up" data-delay="1">
                    <div class="xd-visual-frame">
                        <div class="xd-visual-placeholder xd-visual-decision">
                            <div class="xd-decision-diagram">
                                <div class="xd-decision-center">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <circle cx="12" cy="12" r="10"/>
                                        <path d="M12 6v6l4 2"/>
                                    </svg>
                                </div>
                                <div class="xd-decision-orbit">
                                    <div class="xd-decision-option xd-option-1">
                                        <span><?php esc_html_e('Options', 'bfluxco'); ?></span>
                                    </div>
                                    <div class="xd-decision-option xd-option-2">
                                        <span><?php esc_html_e('Consequences', 'bfluxco'); ?></span>
                                    </div>
                                    <div class="xd-decision-option xd-option-3">
                                        <span><?php esc_html_e('Actions', 'bfluxco'); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <span class="xd-visual-caption"><?php esc_html_e('Decision support framework', 'bfluxco'); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Closing Statement -->
    <section class="xd-section xd-closing">
        <div class="container container-narrow">
            <div class="xd-closing-content reveal-up">
                <h2 class="xd-closing-heading"><?php esc_html_e('Designing With Intent', 'bfluxco'); ?></h2>
                <p class="xd-closing-lead"><?php esc_html_e('Experience design is not decoration.', 'bfluxco'); ?></p>
                <p class="xd-closing-emphasis"><?php esc_html_e('It\'s how systems communicate their intent.', 'bfluxco'); ?></p>
                <div class="xd-closing-divider"></div>
                <p class="xd-closing-final"><?php esc_html_e('When structure, interaction, and behavior are aligned, experiences become easier to use—not because they are simpler, but because they are clear.', 'bfluxco'); ?></p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="xd-cta">
        <div class="container">
            <div class="xd-cta-content reveal-up">
                <h2 class="xd-cta-title"><?php esc_html_e('Ready to design experiences that work?', 'bfluxco'); ?></h2>
                <p class="xd-cta-description"><?php esc_html_e('Let\'s discuss how systems thinking can transform how your users experience your product.', 'bfluxco'); ?></p>
                <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-primary btn-lg">
                    <?php esc_html_e('Start a Conversation', 'bfluxco'); ?>
                    <?php bfluxco_icon('arrow-right', array('size' => 16)); ?>
                </a>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>
