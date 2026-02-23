<?php
/**
 * Template Name: Case Study - Style 3 (Immersive)
 * Template Post Type: page
 *
 * Dark, immersive layout with large visuals and bold typography.
 *
 * @package BFLUXCO
 */

get_header();
?>

<main id="main-content" class="site-main case-study-single style-immersive">

    <!-- Full Screen Hero -->
    <header class="case-hero-immersive">
        <div class="case-hero-bg">
            <div class="case-hero-placeholder" style="background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);"></div>
            <div class="case-hero-overlay"></div>
        </div>
        <div class="case-hero-content">
            <div class="container">
                <span class="case-category-pill">Enterprise Integration</span>
                <h1 class="case-hero-title-large">Hyland for Workday Integration</h1>
                <p class="case-hero-subtitle">Unified content management. Seamless user experience.</p>
                <div class="scroll-indicator">
                    <span>Scroll to explore</span>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 5v14M19 12l-7 7-7-7"/>
                    </svg>
                </div>
            </div>
        </div>
    </header>

    <!-- Overview Section -->
    <section class="case-overview-dark">
        <div class="container">
            <div class="overview-grid">
                <div class="overview-main">
                    <p class="overview-lead">Workday customers needed a way to capture, index, search, view, and manage content directly from their Workday screens—without custom development or middleware.</p>
                    <p>Documents lived in silos. HR and Finance teams toggled between systems. Content governance was fragmented. Hyland partnered with Workday to change that.</p>
                </div>
                <div class="overview-meta">
                    <div class="meta-block">
                        <span class="meta-label">Client</span>
                        <span class="meta-value">Hyland Software</span>
                    </div>
                    <div class="meta-block">
                        <span class="meta-label">Industry</span>
                        <span class="meta-value">Enterprise Software</span>
                    </div>
                    <div class="meta-block">
                        <span class="meta-label">Duration</span>
                        <span class="meta-value">18 Months</span>
                    </div>
                    <div class="meta-block">
                        <span class="meta-label">Services</span>
                        <span class="meta-value">Integration Design, UX Strategy</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Big Numbers -->
    <section class="case-numbers">
        <div class="container">
            <div class="numbers-grid">
                <div class="number-item">
                    <span class="number-value">Zero</span>
                    <span class="number-label">Custom Code Required</span>
                </div>
                <div class="number-item">
                    <span class="number-value">SSO</span>
                    <span class="number-label">Single Sign-On</span>
                </div>
                <div class="number-item">
                    <span class="number-value">2</span>
                    <span class="number-label">Platforms Unified</span>
                </div>
                <div class="number-item">
                    <span class="number-value">AI</span>
                    <span class="number-label">Ready Architecture</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content with Sticky Nav -->
    <div class="case-content-layout case-content-layout-dark">
        <aside class="case-content-nav case-content-nav-dark">
            <nav class="case-toc">
                <span class="toc-label">Contents</span>
                <ul>
                    <li><a href="#challenge" class="active">The Challenge</a></li>
                    <li><a href="#goal">The Goal</a></li>
                    <li><a href="#approach">The Approach</a></li>
                    <li><a href="#results">Results</a></li>
                    <li><a href="#impact">Impact</a></li>
                    <li><a href="#learnings">Learnings</a></li>
                </ul>
            </nav>
        </aside>

        <div class="case-content-main">
            <!-- Challenge - Full Width Text -->
            <section id="challenge" class="case-statement">
                <div class="container container-narrow">
                    <h2 class="statement-label">The Challenge</h2>
                    <p class="statement-text">Enterprise organizations running Workday HCM and Financial Management had content scattered across disconnected systems. Users left Workday to find documents, breaking workflows and creating compliance risks.</p>
                </div>
            </section>

            <!-- Full Bleed Image -->
            <div class="case-image-bleed">
                <div class="case-image-placeholder" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8);"></div>
            </div>

            <!-- Goal -->
            <section id="goal" class="case-statement">
                <div class="container container-narrow">
                    <h2 class="statement-label">The Goal</h2>
                    <p class="statement-text">Create a native integration that brings content management directly into Workday screens—no middleware, no custom development, no context switching.</p>
                    <p class="statement-note">Users should access, upload, and manage documents without ever leaving their workflow.</p>
                </div>
            </section>

            <!-- Approach Cards -->
            <section id="approach" class="case-approach-cards">
                <div class="container">
                    <h2 class="section-title-center">The Approach</h2>
                    <p class="section-subtitle">Built on Workday. Designed for humans.</p>

                    <div class="approach-cards-grid">
                        <div class="approach-card">
                            <span class="approach-number">01</span>
                            <h3>Native Integration</h3>
                            <p>Leveraged the Built on Workday program to embed content management directly into Workday screens. No Workday Extend required. No custom development needed.</p>
                        </div>
                        <div class="approach-card">
                            <span class="approach-number">02</span>
                            <h3>Unified Repository</h3>
                            <p>Single repository to manage and retain content across Workday HCM and Financial Management. Documents linked to multiple entities, accessible from anywhere.</p>
                        </div>
                        <div class="approach-card">
                            <span class="approach-number">03</span>
                            <h3>Security by Design</h3>
                            <p>SSO authentication through Workday credentials. Granular permissions mapped to Workday security roles. Retention policies, legal holds, and version control built in.</p>
                        </div>
                        <div class="approach-card">
                            <span class="approach-number">04</span>
                            <h3>AI-Ready Architecture</h3>
                            <p>Documents structured for intelligent search, governance, and contextual insights—laying groundwork for agentic automation and knowledge discovery.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Full Bleed Image -->
            <div class="case-image-bleed">
                <div class="case-image-placeholder" style="background: linear-gradient(135deg, #0f172a, #334155);"></div>
            </div>

            <!-- Results -->
            <section id="results" class="case-results-immersive">
                <div class="container">
                    <h2 class="section-title-center">Measuring What Matters</h2>
                    <p class="section-subtitle">The integration delivered immediate, measurable impact:</p>

                    <div class="results-showcase">
                        <div class="result-showcase-item">
                            <div class="result-circle">
                                <span class="result-number">60%</span>
                            </div>
                            <span class="result-text">Fewer clicks to capture</span>
                        </div>
                        <div class="result-showcase-item">
                            <div class="result-circle">
                                <span class="result-number">100%</span>
                            </div>
                            <span class="result-text">Compliance coverage</span>
                        </div>
                        <div class="result-showcase-item">
                            <div class="result-circle">
                                <span class="result-number">0</span>
                            </div>
                            <span class="result-text">Context switches</span>
                        </div>
                    </div>

                    <p class="results-note">Users stayed in Workday. Documents stayed governed. IT stayed happy.</p>
                </div>
            </section>

            <!-- Impact -->
            <section id="impact" class="case-impact-immersive">
                <div class="container container-narrow">
                    <h2 class="section-title-center">The Impact</h2>

                    <div class="impact-list-large">
                        <div class="impact-row">
                            <span class="impact-metric">Faster</span>
                            <p>HR onboarding accelerated with instant document access</p>
                        </div>
                        <div class="impact-row">
                            <span class="impact-metric">Simpler</span>
                            <p>Invoice processing streamlined through AP automation</p>
                        </div>
                        <div class="impact-row">
                            <span class="impact-metric">Governed</span>
                            <p>Retention policies and legal holds applied automatically</p>
                        </div>
                        <div class="impact-row">
                            <span class="impact-metric">Future-proof</span>
                            <p>AI-ready document structure enables intelligent automation</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Big Quote -->
            <section class="case-quote-full">
                <div class="container">
                    <blockquote class="featured-quote featured-quote--large">
                        <p class="quote-emphasis">Content management became invisible—exactly as it should be.</p>
                    </blockquote>
                </div>
            </section>

            <!-- Learnings -->
            <section id="learnings" class="case-learnings-immersive">
                <div class="container container-narrow">
                    <h2 class="section-title-center">What We Learned</h2>

                    <ol class="learnings-ordered">
                        <li>Native integrations outperform middleware every time</li>
                        <li>Security that follows existing roles reduces friction</li>
                        <li>Single repositories eliminate content silos</li>
                        <li>AI-readiness is a design decision, not an afterthought</li>
                    </ol>
                </div>
            </section>

            <!-- Final Takeaway -->
            <section class="case-takeaway-immersive">
                <div class="container container-narrow">
                    <p class="takeaway-lead">The best integrations disappear into the workflow.</p>
                    <p>By embedding content management directly into Workday, Hyland created an experience where documents are always accessible, always governed, and never in the way.</p>
                </div>
            </section>
        </div>
    </div>

    <!-- Case Study Pagination -->
    <nav class="case-pagination case-pagination-dark">
        <div class="container">
            <div class="case-pagination-inner">
                <a href="<?php echo esc_url(home_url('/case-study-style-2/')); ?>" class="case-pagination-link case-pagination-prev">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 12H5"/>
                        <path d="M12 19l-7-7 7-7"/>
                    </svg>
                    <div class="case-pagination-text">
                        <span class="case-pagination-label">Previous</span>
                        <span class="case-pagination-title">Previous Case Study</span>
                    </div>
                </a>
                <a href="<?php echo esc_url(home_url('/case-study-style-1/')); ?>" class="case-pagination-link case-pagination-next">
                    <div class="case-pagination-text">
                        <span class="case-pagination-label">Next</span>
                        <span class="case-pagination-title">Next Case Study</span>
                    </div>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14"/>
                        <path d="M12 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </nav>

    <!-- CTA Dark -->
    <section class="case-cta-immersive">
        <div class="container">
            <div class="cta-immersive-content">
                <h2>Let's Build the Future Together</h2>
                <p>Ready to transform how your team works?</p>
                <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-white btn-lg">Start a Conversation</a>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>
