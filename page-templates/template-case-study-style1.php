<?php
/**
 * Template Name: Case Study - Style 1 (Editorial)
 * Template Post Type: page
 *
 * Clean editorial layout with large typography and full-width images.
 *
 * @package BFLUXCO
 */

get_header();
?>

<main id="main-content" class="site-main case-study-single style-editorial">

    <!-- Hero Section -->
    <header class="case-hero">
        <div class="container">
            <div class="case-hero-content">
                <span class="case-category reveal" data-delay="1">Healthcare SaaS / CRM Migration</span>
                <h1 class="case-hero-title reveal-hero">Seamless Salesforce Migration</h1>
                <p class="case-hero-tagline reveal" data-delay="2">Designed for clarity. Built for adoption.</p>
            </div>
        </div>
        <div class="case-hero-image reveal-scale" data-delay="3">
            <div class="case-hero-placeholder" style="background: linear-gradient(135deg, #0ea5e9, #0284c7);"></div>
        </div>
    </header>

    <!-- Quick Stats -->
    <section class="case-stats">
        <div class="container">
            <div class="stats-grid reveal-up" data-delay="1">
                <div class="stat-item">
                    <span class="stat-value">1.2M+</span>
                    <span class="stat-label">Records Migrated</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">98.9%</span>
                    <span class="stat-label">Data Fidelity</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">81%</span>
                    <span class="stat-label">Daily Active Users</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">30%</span>
                    <span class="stat-label">Productivity Increase</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content with Sticky Nav -->
    <div class="case-content-layout">
        <aside class="case-content-nav">
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
            <!-- The Challenge -->
            <section id="challenge" class="case-section">
                <div class="container container-narrow">
                    <h2 class="section-title reveal-text">The Challenge</h2>
                    <div class="case-content reveal" data-delay="1">
                        <p class="lead">AtlasMed Solutions, a growing healthcare SaaS company, had reached the limits of its legacy systems.</p>
                        <p>Sales operated in Zoho CRM. Support relied on a custom ERP. Marketing data lived elsewhere.</p>
                        <p>Teams worked hard—but not together.</p>
                        <ul class="case-list">
                            <li>Leadership lacked a clear, real-time view of the business</li>
                            <li>Users struggled with inconsistent workflows</li>
                            <li>The systems weren't built to scale</li>
                        </ul>
                        <p class="highlight">AtlasMed needed more than a migration. They needed a single system people would actually use.</p>
                    </div>
                </div>
            </section>

            <!-- Full Width Image -->
            <div class="case-image-full reveal-scale">
                <div class="case-image-placeholder" style="background: linear-gradient(135deg, #1e293b, #334155);"></div>
            </div>

            <!-- The Goal -->
            <section id="goal" class="case-section">
                <div class="container container-narrow">
                    <h2 class="section-title reveal-text">The Goal</h2>
                    <div class="case-content reveal" data-delay="1">
                        <p class="lead">Replace fragmented tools with a unified Salesforce platform—without losing data, disrupting teams, or sacrificing usability.</p>
                        <p>Success wouldn't be measured by go-live alone, but by how people worked afterward.</p>
                    </div>
                </div>
            </section>

            <!-- The Approach -->
            <section id="approach" class="case-section bg-gray-50">
                <div class="container container-narrow">
                    <h2 class="section-title reveal-text">The Approach</h2>
                    <div class="case-content reveal" data-delay="1">
                        <p class="lead">We treated Salesforce as a product—not just infrastructure.</p>
                        <p>That meant designing for:</p>
                        <ul class="case-list-inline">
                            <li>Real user behavior</li>
                            <li>Role-based workflows</li>
                            <li>Long-term adoption, not short-term compliance</li>
                        </ul>
                        <p>The work unfolded in four deliberate phases.</p>
                    </div>
                </div>
            </section>

            <!-- Phase 1 -->
            <section class="case-section">
                <div class="container">
                    <div class="case-phase">
                        <div class="phase-number reveal">01</div>
                        <div class="phase-content">
                            <h3 class="phase-title reveal-text">Understanding the System</h3>
                            <div class="case-content reveal" data-delay="1">
                                <p>We began with a full audit of AtlasMed's environment—Zoho CRM, custom ERP modules, and supporting tools.</p>
                                <p>Data models were mapped. Relationships clarified.</p>
                                <p>A future-state Salesforce architecture was defined across Sales, Service, and Marketing Clouds.</p>
                                <p class="highlight">This ensured continuity where it mattered—and change where it counted.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Phase 2 -->
            <section class="case-section bg-gray-50">
                <div class="container">
                    <div class="case-phase">
                        <div class="phase-number reveal">02</div>
                        <div class="phase-content">
                            <h3 class="phase-title reveal-text">Moving the Data</h3>
                            <div class="case-content reveal" data-delay="1">
                                <p>Over 1.2 million records were migrated, including leads, opportunities, cases, and custom objects.</p>
                                <p>Transformation was handled with Talend. Imports were validated through automated checks and targeted manual review.</p>
                                <p><strong>The result: 98.9% data fidelity, with historical context fully preserved.</strong></p>
                                <p>Legacy complexity stayed behind. Confidence moved forward.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Phase 3 -->
            <section class="case-section">
                <div class="container">
                    <div class="case-phase">
                        <div class="phase-number reveal">03</div>
                        <div class="phase-content">
                            <h3 class="phase-title reveal-text">Connecting the Ecosystem</h3>
                            <div class="case-content reveal" data-delay="1">
                                <p>Salesforce didn't exist in isolation. We integrated:</p>
                                <ul class="case-list">
                                    <li><strong>HubSpot</strong> for real-time lead flow</li>
                                    <li><strong>QuickBooks</strong> for invoicing and payment visibility</li>
                                    <li><strong>Custom BI platform</strong> for advanced analytics</li>
                                </ul>
                                <p>MuleSoft orchestrated the APIs—providing resilience, scalability, and future flexibility.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Phase 4 -->
            <section class="case-section bg-gray-50">
                <div class="container">
                    <div class="case-phase">
                        <div class="phase-number reveal">04</div>
                        <div class="phase-content">
                            <h3 class="phase-title reveal-text">Designing the Experience</h3>
                            <div class="case-content reveal" data-delay="1">
                                <p>Adoption doesn't happen by accident.</p>
                                <p>We redesigned Salesforce Lightning experiences around how people actually work:</p>
                                <ul class="case-list">
                                    <li>Role-specific dashboards</li>
                                    <li>Simplified record layouts</li>
                                    <li>Fewer clicks, clearer decisions</li>
                                </ul>
                                <p>Interactive onboarding replaced static documentation. Guidance appeared in context—when and where it was needed.</p>
                                <p class="highlight">The system taught itself.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Results -->
            <section id="results" class="case-section case-results">
                <div class="container container-narrow">
                    <h2 class="section-title reveal-text">Measuring What Matters</h2>
                    <div class="case-content reveal" data-delay="1">
                        <p class="lead">After launch, we tracked real usage—not assumptions.</p>
                        <p>Within 90 days:</p>
                    </div>
                    <div class="results-grid reveal-up" data-delay="2">
                        <div class="result-item">
                            <span class="result-value">81%</span>
                            <span class="result-label">Daily active users</span>
                        </div>
                        <div class="result-item">
                            <span class="result-value">93%</span>
                            <span class="result-label">User retention</span>
                        </div>
                        <div class="result-item">
                            <span class="result-value">42%</span>
                            <span class="result-label">Stickiness rate</span>
                        </div>
                    </div>
                    <div class="case-content reveal" data-delay="3">
                        <p>These weren't vanity metrics. They were signals of trust.</p>
                    </div>
                </div>
            </section>

            <!-- Impact -->
            <section id="impact" class="case-section bg-gray-50">
                <div class="container container-narrow">
                    <h2 class="section-title reveal-text">The Impact</h2>
                    <div class="case-content reveal" data-delay="1">
                        <ul class="impact-list">
                            <li><strong>Sales teams moved faster</strong>—productivity increased 30%</li>
                            <li><strong>Support resolved cases 25% quicker</strong> through automation and smarter routing</li>
                            <li><strong>Marketing gained real-time insight</strong> to iterate campaigns with confidence</li>
                            <li><strong>Executives finally saw the full picture</strong>—accurate forecasts, live pipelines, shared truth</li>
                        </ul>
                        <p class="highlight">Salesforce became the system teams relied on—not worked around.</p>
                    </div>
                </div>
            </section>

            <!-- Learnings -->
            <section id="learnings" class="case-section">
                <div class="container container-narrow">
                    <h2 class="section-title reveal-text">What We Learned</h2>
                    <div class="case-content reveal" data-delay="1">
                        <ul class="learnings-list">
                            <li>Migration is a behavioral challenge, not just a technical one</li>
                            <li>UX-driven onboarding dramatically reduces resistance</li>
                            <li>Analytics are essential—but only when paired with intent</li>
                            <li>The real work begins after launch</li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- Takeaway -->
            <section class="case-section case-takeaway">
                <div class="container container-narrow">
                    <blockquote class="featured-quote reveal-scale">
                        <p class="quote-emphasis">When systems are designed around people, adoption follows.</p>
                    </blockquote>
                    <div class="case-content reveal" data-delay="1">
                        <p>By combining thoughtful architecture, deliberate UX, and continuous measurement, AtlasMed didn't just migrate to Salesforce—they changed how the organization worked.</p>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <!-- Case Study Pagination -->
    <nav class="case-pagination">
        <div class="container">
            <div class="case-pagination-inner">
                <a href="<?php echo esc_url(home_url('/work/case-studies/hyland-for-workday-integration/')); ?>" class="case-pagination-link case-pagination-prev">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 12H5"/>
                        <path d="M12 19l-7-7 7-7"/>
                    </svg>
                    <div class="case-pagination-text">
                        <span class="case-pagination-label">Previous</span>
                        <span class="case-pagination-title">Hyland for Workday</span>
                    </div>
                </a>
                <a href="<?php echo esc_url(home_url('/case-study-style-2/')); ?>" class="case-pagination-link case-pagination-next">
                    <div class="case-pagination-text">
                        <span class="case-pagination-label">Next</span>
                        <span class="case-pagination-title">Salesforce Migration</span>
                    </div>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14"/>
                        <path d="M12 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </nav>

    <!-- CTA -->
    <section class="case-cta">
        <div class="container">
            <div class="cta-content reveal-up">
                <h2>Ready to transform your systems?</h2>
                <p>Let's discuss how strategic design can help your team work better together.</p>
                <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-primary btn-lg">Start a Conversation</a>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>
