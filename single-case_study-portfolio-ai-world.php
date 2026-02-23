<?php
/**
 * Custom template for the "Portfolio in the AI World" case study
 *
 * This template is automatically used for the case study with slug "portfolio-ai-world"
 * Features a unique editorial layout designed for this meta case study.
 *
 * @package BFLUXCO
 */

get_header();
?>

<main id="main-content" class="site-main case-study-ai-world">

    <?php while (have_posts()) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class('cs-ai-article'); ?>>

            <!-- Hero Section - Full Width Statement -->
            <header class="cs-ai-hero">
                <div class="container">
                    <div class="cs-ai-hero-inner">

                        <div class="cs-ai-hero-content">
                            <span class="cs-ai-label">Case Study</span>
                            <h1 class="cs-ai-title"><?php the_title(); ?></h1>

                            <?php if (has_excerpt()) : ?>
                                <p class="cs-ai-subtitle">
                                    <?php echo get_the_excerpt(); ?>
                                </p>
                            <?php endif; ?>
                        </div>

                        <!-- Meta Strip -->
                        <div class="cs-ai-meta-strip">
                            <?php
                            $client = get_post_meta(get_the_ID(), 'case_study_client', true);
                            $timeline = get_post_meta(get_the_ID(), 'case_study_timeline', true);
                            $role = get_post_meta(get_the_ID(), 'case_study_role', true);
                            ?>

                            <?php if ($client) : ?>
                                <div class="cs-ai-meta-item">
                                    <span class="meta-label">Client</span>
                                    <span class="meta-value"><?php echo esc_html($client); ?></span>
                                </div>
                            <?php endif; ?>

                            <?php if ($timeline) : ?>
                                <div class="cs-ai-meta-item">
                                    <span class="meta-label">Timeline</span>
                                    <span class="meta-value"><?php echo esc_html($timeline); ?></span>
                                </div>
                            <?php endif; ?>

                            <?php if ($role) : ?>
                                <div class="cs-ai-meta-item">
                                    <span class="meta-label">Role</span>
                                    <span class="meta-value"><?php echo esc_html($role); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            </header>

            <!-- The Paradox - Opening Statement -->
            <section class="cs-ai-paradox">
                <div class="container">
                    <div class="cs-ai-paradox-inner">
                        <div class="cs-ai-paradox-mark">"</div>
                        <p class="cs-ai-paradox-text">
                            The website you're looking at could have been generated in minutes.
                            A dozen AI tools can scaffold a portfolio site before your coffee gets cold.
                        </p>
                        <p class="cs-ai-paradox-question">
                            So why spend time designing one?
                        </p>
                    </div>
                </div>
            </section>

            <!-- The Brief -->
            <section class="cs-ai-section cs-ai-brief">
                <div class="container">
                    <div class="cs-ai-section-header">
                        <span class="cs-ai-section-number">01</span>
                        <h2 class="cs-ai-section-title">The Brief</h2>
                    </div>

                    <div class="cs-ai-brief-grid">
                        <div class="cs-ai-brief-item">
                            <h3>Challenge</h3>
                            <p>Create a portfolio for a design and strategy practice in 2025, when the very act of "building" has been commoditized.</p>
                        </div>
                        <div class="cs-ai-brief-item">
                            <h3>Constraint</h3>
                            <p>The portfolio must demonstrate value that AI cannot replicate—not through complexity, but through clarity of thought.</p>
                        </div>
                        <div class="cs-ai-brief-item">
                            <h3>Success</h3>
                            <p>Someone viewing this site should understand not just what I do, but how I think.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- The Problem -->
            <section class="cs-ai-section cs-ai-problem">
                <div class="container">
                    <div class="cs-ai-section-header">
                        <span class="cs-ai-section-number">02</span>
                        <h2 class="cs-ai-section-title">The Problem with Portfolios Now</h2>
                    </div>

                    <div class="cs-ai-prose">
                        <p class="lead">Traditional portfolios operate on a simple premise: show what you've made, prove you can make things.</p>
                        <p>This worked when making things was hard. But we're past that now.</p>
                        <p>The designer who can "make a website" competes with every person who can type a prompt. The strategist who can "create a brand" competes with tools that generate hundreds of options instantly.</p>
                    </div>

                    <div class="cs-ai-callout">
                        <p>Production skill has become table stakes—necessary but insufficient.</p>
                        <p class="cs-ai-callout-emphasis">The new differentiator isn't what you can make. It's what you choose to make and why.</p>
                    </div>
                </div>
            </section>

            <!-- Strategy -->
            <section class="cs-ai-section cs-ai-strategy">
                <div class="container">
                    <div class="cs-ai-section-header">
                        <span class="cs-ai-section-number">03</span>
                        <h2 class="cs-ai-section-title">Strategy: Demonstrate Judgment</h2>
                    </div>

                    <div class="cs-ai-prose">
                        <p class="lead">I approached this portfolio with a counter-intuitive strategy: be less impressive.</p>
                        <p>Most portfolios try to overwhelm—more projects, more animations, more proof. But in an AI world, volume is suspicious. Anyone can generate volume.</p>
                    </div>

                    <div class="cs-ai-principles">
                        <div class="cs-ai-principle">
                            <span class="cs-ai-principle-number">1</span>
                            <div class="cs-ai-principle-content">
                                <h4>Constraints over capabilities</h4>
                                <p>Showing what I chose not to do matters as much as what I did</p>
                            </div>
                        </div>
                        <div class="cs-ai-principle">
                            <span class="cs-ai-principle-number">2</span>
                            <div class="cs-ai-principle-content">
                                <h4>Process over polish</h4>
                                <p>The thinking behind decisions, documented in real-time</p>
                            </div>
                        </div>
                        <div class="cs-ai-principle">
                            <span class="cs-ai-principle-number">3</span>
                            <div class="cs-ai-principle-content">
                                <h4>Clarity over complexity</h4>
                                <p>Simple solutions to real problems, not complex solutions to manufactured ones</p>
                            </div>
                        </div>
                        <div class="cs-ai-principle">
                            <span class="cs-ai-principle-number">4</span>
                            <div class="cs-ai-principle-content">
                                <h4>Intention over execution</h4>
                                <p>Every element exists for a reason I can articulate</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Design System -->
            <section class="cs-ai-section cs-ai-design-system">
                <div class="container">
                    <div class="cs-ai-section-header">
                        <span class="cs-ai-section-number">04</span>
                        <h2 class="cs-ai-section-title">The Design System</h2>
                        <p class="cs-ai-section-subtitle">Intentional Minimalism</p>
                    </div>

                    <div class="cs-ai-prose">
                        <p>The visual design follows a principle I call <em>earned simplicity</em>—minimalism that comes from removing everything unnecessary, not from lacking ideas.</p>
                    </div>

                    <div class="cs-ai-design-grid">
                        <div class="cs-ai-design-item">
                            <h4>Typography</h4>
                            <p>One typeface (Poppins), used at carefully chosen scales. Not because I couldn't use more, but because more would be noise.</p>
                        </div>
                        <div class="cs-ai-design-item">
                            <h4>Color</h4>
                            <p>A restrained palette with a single accent color. The constraint forces hierarchy through layout and typography rather than visual decoration.</p>
                        </div>
                        <div class="cs-ai-design-item">
                            <h4>Space</h4>
                            <p>Generous whitespace isn't empty—it's the most intentional element on the page. It says: I don't need to fill every pixel to prove my worth.</p>
                        </div>
                        <div class="cs-ai-design-item">
                            <h4>Components</h4>
                            <p>A small set of patterns used consistently. The system is simple enough to hold in your head, complex enough to be flexible.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- AI Collaboration -->
            <section class="cs-ai-section cs-ai-collaboration">
                <div class="container">
                    <div class="cs-ai-section-header">
                        <span class="cs-ai-section-number">05</span>
                        <h2 class="cs-ai-section-title">The AI Collaboration Model</h2>
                    </div>

                    <div class="cs-ai-prose">
                        <p class="lead">I used AI extensively to build this site. But how I used it matters.</p>
                    </div>

                    <div class="cs-ai-split">
                        <div class="cs-ai-split-panel cs-ai-split-ai">
                            <h3>AI Handled</h3>
                            <ul>
                                <li>Code generation for WordPress theme structure</li>
                                <li>CSS implementation of design decisions</li>
                                <li>Repetitive template creation</li>
                                <li>Documentation drafting</li>
                            </ul>
                        </div>
                        <div class="cs-ai-split-panel cs-ai-split-human">
                            <h3>I Handled</h3>
                            <ul>
                                <li>Strategic direction (what should this portfolio do?)</li>
                                <li>Design decisions (what should it feel like?)</li>
                                <li>Quality judgment (is this good?)</li>
                                <li>Constraint definition (what should it not be?)</li>
                            </ul>
                        </div>
                    </div>

                    <div class="cs-ai-insight">
                        <p>The collaboration model treated AI as a production partner, not a creative one. I made the decisions; AI made them real.</p>
                    </div>
                </div>
            </section>

            <!-- Lessons Learned -->
            <section class="cs-ai-section cs-ai-lessons">
                <div class="container">
                    <div class="cs-ai-section-header">
                        <span class="cs-ai-section-number">06</span>
                        <h2 class="cs-ai-section-title">What I Learned</h2>
                    </div>

                    <div class="cs-ai-lessons-grid">
                        <div class="cs-ai-lesson">
                            <span class="cs-ai-lesson-number">01</span>
                            <h4>Constraints are content</h4>
                            <p>The choices you don't make communicate as much as the ones you do. A portfolio in 2025 should show constraint and intention, not maximum capability.</p>
                        </div>
                        <div class="cs-ai-lesson">
                            <span class="cs-ai-lesson-number">02</span>
                            <h4>Process is the new portfolio</h4>
                            <p>Showing finished work is necessary but not sufficient. Documenting how you think, how you make decisions—that's the differentiator.</p>
                        </div>
                        <div class="cs-ai-lesson">
                            <span class="cs-ai-lesson-number">03</span>
                            <h4>Speed changes the question</h4>
                            <p>When production is instant, the valuable skill shifts from "how do I make this?" to "should I make this at all?"</p>
                        </div>
                        <div class="cs-ai-lesson">
                            <span class="cs-ai-lesson-number">04</span>
                            <h4>Transparency is trust</h4>
                            <p>In a world where AI-generation is suspected everywhere, honesty about the collaboration builds more trust than denial.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Results -->
            <?php
            $results = get_post_meta(get_the_ID(), 'case_study_results', true);
            if ($results) :
            ?>
                <section class="cs-ai-section cs-ai-results">
                    <div class="container">
                        <div class="cs-ai-section-header">
                            <span class="cs-ai-section-number">07</span>
                            <h2 class="cs-ai-section-title">Results</h2>
                        </div>
                        <div class="cs-ai-results-content">
                            <?php echo wp_kses_post($results); ?>
                        </div>
                    </div>
                </section>
            <?php endif; ?>

            <!-- The Meta-Lesson -->
            <section class="cs-ai-section cs-ai-meta-lesson">
                <div class="container">
                    <div class="cs-ai-meta-lesson-inner">
                        <h2>The Meta-Lesson</h2>
                        <p class="cs-ai-meta-lesson-text">
                            This portfolio is itself a case study in navigating the AI transition. The temptation is to compete with AI on its terms—more, faster, cheaper. But that's a losing game.
                        </p>
                        <p class="cs-ai-meta-lesson-emphasis">
                            The opportunity is to compete on different terms entirely: judgment, strategy, taste, context, relationship.
                        </p>
                        <p class="cs-ai-meta-lesson-close">
                            The website you're viewing isn't impressive because of what it is. It's useful because of what it tells you about how I work.
                        </p>
                        <p class="cs-ai-meta-lesson-statement">
                            That's the portfolio that matters in 2026.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Principles Summary -->
            <section class="cs-ai-section cs-ai-principles-summary">
                <div class="container">
                    <div class="cs-ai-section-header">
                        <h2 class="cs-ai-section-title">Principles for Designing in the AI Era</h2>
                    </div>

                    <div class="cs-ai-principles-list">
                        <div class="cs-ai-summary-principle">
                            <span class="cs-ai-sp-number">1</span>
                            <p><strong>Start with the question, not the output</strong> — What does this need to communicate? Not: what can I make?</p>
                        </div>
                        <div class="cs-ai-summary-principle">
                            <span class="cs-ai-sp-number">2</span>
                            <p><strong>Document your decisions</strong> — The why matters more than the what</p>
                        </div>
                        <div class="cs-ai-summary-principle">
                            <span class="cs-ai-sp-number">3</span>
                            <p><strong>Embrace constraints publicly</strong> — Show what you chose not to do</p>
                        </div>
                        <div class="cs-ai-summary-principle">
                            <span class="cs-ai-sp-number">4</span>
                            <p><strong>Be transparent about AI use</strong> — Honesty builds trust; hiding it erodes it</p>
                        </div>
                        <div class="cs-ai-summary-principle">
                            <span class="cs-ai-sp-number">5</span>
                            <p><strong>Focus on judgment, not production</strong> — Anyone can make things now; not everyone knows what to make</p>
                        </div>
                        <div class="cs-ai-summary-principle">
                            <span class="cs-ai-sp-number">6</span>
                            <p><strong>Build for clarity, not impression</strong> — In a world of noise, clarity is remarkable</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Footer Note -->
            <footer class="cs-ai-footer">
                <div class="container">
                    <p class="cs-ai-footer-note">
                        This portfolio was designed by a human, built with AI assistance, and documented because the process matters as much as the result.
                    </p>

                    <!-- Services -->
                    <?php
                    $services = get_the_terms(get_the_ID(), 'service_type');
                    if ($services && !is_wp_error($services)) :
                    ?>
                        <div class="cs-ai-services">
                            <strong>Services:</strong>
                            <?php echo esc_html(implode(', ', wp_list_pluck($services, 'name'))); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Share -->
                    <div class="cs-ai-share">
                        <?php bfluxco_social_share(); ?>
                    </div>
                </div>
            </footer>

        </article>

    <?php endwhile; ?>

    <!-- CTA Section -->
    <section class="cs-ai-cta">
        <div class="container">
            <h2>Ready to Start Your Project?</h2>
            <p>Let's discuss how I can help solve your business challenges.</p>
            <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-primary btn-lg">
                Get in Touch
            </a>
        </div>
    </section>

</main>

<?php
get_footer();
