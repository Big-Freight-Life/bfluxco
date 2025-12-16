<?php
/**
 * Template Name: Case Study - Style 2 (Split)
 * Template Post Type: page
 *
 * Split layout with sticky sidebar and scrolling content.
 *
 * @package BFLUXCO
 */

get_header();
?>

<main id="main-content" class="site-main case-study-single style-split">

    <!-- Hero - Full Bleed -->
    <header class="case-hero-split">
        <div class="case-hero-split-content">
            <div class="case-hero-split-inner">
                <span class="case-category">Healthcare SaaS / CRM Migration</span>
                <h1 class="case-hero-title">Seamless Salesforce Migration</h1>
                <p class="case-hero-tagline">Designed for clarity. Built for adoption.</p>
                <div class="case-meta-row">
                    <div class="meta-item">
                        <span class="meta-label">Client</span>
                        <span class="meta-value">AtlasMed Solutions</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Timeline</span>
                        <span class="meta-value">6 months</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Role</span>
                        <span class="meta-value">Lead Strategist</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="case-hero-split-image">
            <div class="case-hero-placeholder" style="background: linear-gradient(180deg, #7c3aed, #4f46e5);"></div>
        </div>
    </header>

    <!-- Stats Bar -->
    <section class="case-stats-bar">
        <div class="container">
            <div class="stats-bar-inner">
                <div class="stat-item">
                    <span class="stat-value">1.2M+</span>
                    <span class="stat-label">Records</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">98.9%</span>
                    <span class="stat-label">Accuracy</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">81%</span>
                    <span class="stat-label">Adoption</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">30%</span>
                    <span class="stat-label">Faster</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content with Sticky Nav -->
    <div class="case-split-layout">
        <aside class="case-split-nav">
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

        <div class="case-split-content">
            <!-- Challenge -->
            <section id="challenge" class="case-chapter">
                <h2 class="chapter-title">The Challenge</h2>
                <p class="lead">AtlasMed Solutions, a growing healthcare SaaS company, had reached the limits of its legacy systems.</p>
                <p>Sales operated in Zoho CRM. Support relied on a custom ERP. Marketing data lived elsewhere. Teams worked hard—but not together.</p>

                <div class="case-callout">
                    <h4>Pain Points</h4>
                    <ul>
                        <li>Leadership lacked a clear, real-time view of the business</li>
                        <li>Users struggled with inconsistent workflows</li>
                        <li>The systems weren't built to scale</li>
                    </ul>
                </div>

                <p><strong>AtlasMed needed more than a migration. They needed a single system people would actually use.</strong></p>
            </section>

            <!-- Image Break -->
            <div class="case-image-break">
                <div class="case-image-placeholder" style="background: linear-gradient(135deg, #1e293b, #475569);"></div>
                <span class="image-caption">Legacy system architecture before migration</span>
            </div>

            <!-- Goal -->
            <section id="goal" class="case-chapter">
                <h2 class="chapter-title">The Goal</h2>
                <p class="lead">Replace fragmented tools with a unified Salesforce platform—without losing data, disrupting teams, or sacrificing usability.</p>
                <p>Success wouldn't be measured by go-live alone, but by how people worked afterward.</p>
            </section>

            <!-- Approach -->
            <section id="approach" class="case-chapter">
                <h2 class="chapter-title">The Approach</h2>
                <p class="lead">We treated Salesforce as a product—not just infrastructure.</p>

                <div class="approach-principles">
                    <div class="principle">
                        <span class="principle-icon">01</span>
                        <span class="principle-text">Real user behavior</span>
                    </div>
                    <div class="principle">
                        <span class="principle-icon">02</span>
                        <span class="principle-text">Role-based workflows</span>
                    </div>
                    <div class="principle">
                        <span class="principle-icon">03</span>
                        <span class="principle-text">Long-term adoption</span>
                    </div>
                </div>

                <h3>Phase 1: Understanding the System</h3>
                <p>We began with a full audit of AtlasMed's environment—Zoho CRM, custom ERP modules, and supporting tools. Data models were mapped. Relationships clarified. A future-state Salesforce architecture was defined across Sales, Service, and Marketing Clouds.</p>

                <h3>Phase 2: Moving the Data</h3>
                <p>Over 1.2 million records were migrated, including leads, opportunities, cases, and custom objects. Transformation was handled with Talend. Imports were validated through automated checks and targeted manual review.</p>
                <p><strong>The result: 98.9% data fidelity, with historical context fully preserved.</strong></p>

                <h3>Phase 3: Connecting the Ecosystem</h3>
                <p>Salesforce didn't exist in isolation. We integrated:</p>
                <ul>
                    <li><strong>HubSpot</strong> for real-time lead flow</li>
                    <li><strong>QuickBooks</strong> for invoicing and payment visibility</li>
                    <li><strong>Custom BI platform</strong> for advanced analytics</li>
                </ul>
                <p>MuleSoft orchestrated the APIs—providing resilience, scalability, and future flexibility.</p>

                <h3>Phase 4: Designing the Experience</h3>
                <p>Adoption doesn't happen by accident. We redesigned Salesforce Lightning experiences around how people actually work: role-specific dashboards, simplified record layouts, fewer clicks, clearer decisions.</p>
                <p>Interactive onboarding replaced static documentation. Guidance appeared in context—when and where it was needed. <strong>The system taught itself.</strong></p>
            </section>

            <!-- Image Break -->
            <div class="case-image-break">
                <div class="case-image-placeholder" style="background: linear-gradient(135deg, #0ea5e9, #0284c7);"></div>
                <span class="image-caption">Redesigned Salesforce Lightning dashboard</span>
            </div>

            <!-- Results -->
            <section id="results" class="case-chapter">
                <h2 class="chapter-title">Measuring What Matters</h2>
                <p class="lead">After launch, we tracked real usage—not assumptions.</p>

                <div class="results-cards">
                    <div class="result-card">
                        <span class="result-value">81%</span>
                        <span class="result-label">Daily active users within 90 days</span>
                    </div>
                    <div class="result-card">
                        <span class="result-value">93%</span>
                        <span class="result-label">User retention rate</span>
                    </div>
                    <div class="result-card">
                        <span class="result-value">42%</span>
                        <span class="result-label">Stickiness rate</span>
                    </div>
                </div>

                <p>These weren't vanity metrics. They were signals of trust.</p>
            </section>

            <!-- Impact -->
            <section id="impact" class="case-chapter">
                <h2 class="chapter-title">The Impact</h2>

                <div class="impact-grid">
                    <div class="impact-item">
                        <span class="impact-stat">+30%</span>
                        <p>Sales teams moved faster—productivity increased significantly</p>
                    </div>
                    <div class="impact-item">
                        <span class="impact-stat">+25%</span>
                        <p>Support resolved cases quicker through automation and smarter routing</p>
                    </div>
                    <div class="impact-item">
                        <span class="impact-stat">Real-time</span>
                        <p>Marketing gained insight to iterate campaigns with confidence</p>
                    </div>
                    <div class="impact-item">
                        <span class="impact-stat">Unified</span>
                        <p>Executives finally saw the full picture—accurate forecasts, live pipelines</p>
                    </div>
                </div>

                <blockquote class="case-quote-inline">
                    Salesforce became the system teams relied on—not worked around.
                </blockquote>
            </section>

            <!-- Learnings -->
            <section id="learnings" class="case-chapter">
                <h2 class="chapter-title">What We Learned</h2>

                <div class="learnings-grid">
                    <div class="learning-item">
                        <span class="learning-number">01</span>
                        <p>Migration is a behavioral challenge, not just a technical one</p>
                    </div>
                    <div class="learning-item">
                        <span class="learning-number">02</span>
                        <p>UX-driven onboarding dramatically reduces resistance</p>
                    </div>
                    <div class="learning-item">
                        <span class="learning-number">03</span>
                        <p>Analytics are essential—but only when paired with intent</p>
                    </div>
                    <div class="learning-item">
                        <span class="learning-number">04</span>
                        <p>The real work begins after launch</p>
                    </div>
                </div>
            </section>

            <!-- Takeaway -->
            <section class="case-chapter case-takeaway-split">
                <blockquote class="final-quote">
                    <p>When systems are designed around people, adoption follows.</p>
                </blockquote>
                <p>By combining thoughtful architecture, deliberate UX, and continuous measurement, AtlasMed didn't just migrate to Salesforce—they changed how the organization worked.</p>
            </section>
        </div>
    </div>

    <!-- Case Study Pagination -->
    <nav class="case-pagination">
        <div class="container">
            <div class="case-pagination-inner">
                <a href="<?php echo esc_url(home_url('/case-study-style-1/')); ?>" class="case-pagination-link case-pagination-prev">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 12H5"/>
                        <path d="M12 19l-7-7 7-7"/>
                    </svg>
                    <div class="case-pagination-text">
                        <span class="case-pagination-label">Previous</span>
                        <span class="case-pagination-title">Seamless Salesforce Migration</span>
                    </div>
                </a>
                <a href="<?php echo esc_url(home_url('/case-study-style-3/')); ?>" class="case-pagination-link case-pagination-next">
                    <div class="case-pagination-text">
                        <span class="case-pagination-label">Next</span>
                        <span class="case-pagination-title">AtlasMed Transformation</span>
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
    <section class="case-cta case-cta-dark">
        <div class="container">
            <div class="cta-content">
                <h2>Ready to transform your systems?</h2>
                <p>Let's discuss how strategic design can help your team work better together.</p>
                <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-white btn-lg">Start a Conversation</a>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>
