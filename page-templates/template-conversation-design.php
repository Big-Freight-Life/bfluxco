<?php
/**
 * Template Name: Conversation Design
 * Template Post Type: page
 *
 * Conversation Design service page - Designing Conversations as Systems
 * URL: /services/conversation-design or /conversation-design
 *
 * @package BFLUXCO
 */

get_header();
?>

<main id="main-content" class="site-main page-conversation-design">

    <!-- Hero Section -->
    <section class="cd-hero section">
        <div class="container">
            <div class="cd-hero-content reveal-hero">
                <span class="overline reveal-up">Conversation Design</span>
                <h1 class="display-text reveal-up" data-delay="1">Designing Conversations<br><span class="text-accent">as Systems</span></h1>
                <p class="lead reveal-up" data-delay="2">Conversation design at Big Freight Life begins with a simple reality: conversation is not just interaction—it is decision-making in motion.</p>
            </div>
        </div>
        <div class="cd-hero-visual">
            <div class="cd-visual-element cd-visual-flow"></div>
        </div>
    </section>

    <!-- Introduction Section -->
    <section class="cd-intro section">
        <div class="container container-narrow">
            <div class="cd-intro-content reveal-up">
                <p class="cd-intro-modality">Conversation design spans modalities. Chat, voice, hybrid interactions, and assistive agents all require the same discipline: clarity of intent, responsibility, and control.</p>
                <p class="cd-intro-text">In modern systems, conversation often sits between people and complex processes. It shapes how information is requested, how uncertainty is handled, and how responsibility moves between humans and systems.</p>
                <p class="cd-intro-emphasis">When these exchanges are poorly designed, confusion and false confidence follow.</p>
                <div class="cd-intro-principle">
                    <p>Our work treats conversation as a system behavior, not a personality layer. The goal is not to make systems sound human, but to make their intent, limits, and role clear.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Approach Section -->
    <section class="cd-approach-editorial section bg-secondary">
        <div class="container container-narrow">
            <header class="cd-section-header reveal-up">
                <span class="cd-section-number">01</span>
                <h2>How We Approach<br>Conversation Design</h2>
            </header>
            <div class="cd-approach-prose reveal-up" data-delay="1">
                <p>We begin by defining the role a conversational system plays. Is it gathering information, supporting a decision, explaining outcomes, or escalating responsibility? Clarity about role comes before tone, phrasing, or interaction patterns.</p>
                <p>From there, we design boundaries—what the system can do, what it cannot do, and when it must defer to human judgment. Conversation is shaped by these constraints, not by stylistic preference.</p>
                <p class="cd-approach-principle">Well-designed conversations make responsibility visible rather than hiding it behind fluency.</p>
            </div>
        </div>
    </section>

    <!-- Decision Support Section -->
    <section class="cd-feature section">
        <div class="container">
            <div class="cd-feature-grid">
                <div class="cd-feature-visual reveal-up">
                    <div class="cd-decision-diagram">
                        <div class="cd-diagram-node cd-node-input">
                            <span>Input</span>
                        </div>
                        <div class="cd-diagram-flow"></div>
                        <div class="cd-diagram-node cd-node-process">
                            <span>Process</span>
                        </div>
                        <div class="cd-diagram-flow"></div>
                        <div class="cd-diagram-node cd-node-decision">
                            <span>Decision</span>
                        </div>
                    </div>
                </div>
                <div class="cd-feature-content reveal-up" data-delay="1">
                    <span class="cd-section-number">02</span>
                    <h2>Conversation as<br>Decision Support</h2>
                    <p class="lead">Every conversational exchange influences a decision, even when no explicit choice is presented.</p>
                    <p>We design conversations to surface options, clarify consequences, and reduce ambiguity. This includes how questions are framed, how uncertainty is acknowledged, and how next steps are presented.</p>
                    <div class="cd-callout">
                        <p>In AI-assisted environments, this is especially critical. Confidence without clarity leads to error. A conversational system should support judgment, not replace it.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Uncertainty Section -->
    <section class="cd-feature cd-feature-alt section bg-tertiary">
        <div class="container">
            <div class="cd-feature-grid cd-feature-reverse">
                <div class="cd-feature-content reveal-up">
                    <span class="cd-section-number">03</span>
                    <h2>Designing for Uncertainty<br>and Failure</h2>
                    <p>Real conversations do not follow scripts. They include incomplete information, unexpected inputs, and moments where the system does not know the answer.</p>
                    <p>We design for these moments intentionally. This means planning how a system responds when it reaches its limits, how it communicates uncertainty, and how it hands control back to a human when appropriate.</p>
                    <div class="cd-principle-statement">
                        <span class="cd-principle-mark">"</span>
                        <p>A system that can fail clearly is more trustworthy than one that pretends it cannot fail at all.</p>
                    </div>
                </div>
                <div class="cd-feature-visual reveal-up" data-delay="1">
                    <div class="cd-uncertainty-visual">
                        <div class="cd-path cd-path-primary"></div>
                        <div class="cd-path cd-path-alt"></div>
                        <div class="cd-path cd-path-fallback"></div>
                        <div class="cd-node cd-node-branch"></div>
                        <div class="cd-node cd-node-handoff"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Closing Statement -->
    <section class="cd-closing section">
        <div class="container container-narrow">
            <div class="cd-closing-content reveal-up">
                <h2 class="cd-closing-title">Designing<br>With Intent</h2>
                <div class="cd-closing-statement">
                    <p class="cd-closing-lead">Conversation design is not about sounding natural.</p>
                    <p class="cd-closing-emphasis">It's about making responsibility, intent, and limits clear.</p>
                </div>
                <p class="cd-closing-body">When conversations are designed as part of a larger system, they become tools for understanding rather than sources of confusion. They help people stay in control, even as systems become more capable.</p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cd-cta section bg-dark">
        <div class="container">
            <div class="cd-cta-content reveal-up">
                <h2>Ready to design conversations that clarify rather than confuse?</h2>
                <p>Let's explore how conversation design can improve your systems.</p>
                <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-primary btn-large">Start a Conversation</a>
            </div>
        </div>
    </section>

</main>

<?php
get_footer();
?>
