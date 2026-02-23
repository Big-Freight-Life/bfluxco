<?php
/**
 * Template Name: Case Study - Hyland OnBase
 * Template Post Type: page
 *
 * Hyland OnBase Integration for Salesforce case study.
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
                <span class="case-category">Salesforce AppExchange / Enterprise Integration</span>
                <h1 class="case-hero-title">Hyland OnBase Integration for Salesforce</h1>
                <p class="case-hero-tagline">Enterprise document management meets CRM. Seamlessly.</p>
                <div class="case-meta-row">
                    <div class="meta-item">
                        <span class="meta-label">Client</span>
                        <span class="meta-value">Hyland Software, Inc.</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Timeline</span>
                        <span class="meta-value">18 months</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Role</span>
                        <span class="meta-value">Lead UX Designer</span>
                    </div>
                </div>
                <a href="https://appexchange.salesforce.com/appxListingDetail?listingId=a0N3A00000G0oQCUAZ" class="case-external-link" target="_blank" rel="noopener noreferrer">
                    View on Salesforce AppExchange
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
                        <polyline points="15 3 21 3 21 9"/>
                        <line x1="10" y1="14" x2="21" y2="3"/>
                    </svg>
                </a>
            </div>
        </div>
        <div class="case-hero-split-image">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('full', array('class' => 'case-hero-img')); ?>
            <?php else : ?>
                <div class="case-hero-placeholder" style="background: linear-gradient(180deg, #7c3aed, #4f46e5);"></div>
            <?php endif; ?>
        </div>
    </header>

    <!-- Stats Bar -->
    <section class="case-stats-bar">
        <div class="container">
            <div class="stats-bar-inner">
                <div class="stat-item">
                    <span class="stat-value">3</span>
                    <span class="stat-label">Industries</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">Zero</span>
                    <span class="stat-label">Custom Code</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">Native</span>
                    <span class="stat-label">Lightning UX</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">Live</span>
                    <span class="stat-label">AppExchange</span>
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
                    <li><a href="#approach">The Approach</a></li>
                    <li><a href="#solution">The Solution</a></li>
                    <li><a href="#technical">Technical Integration</a></li>
                    <li><a href="#results">Results</a></li>
                    <li><a href="#learnings">Learnings</a></li>
                </ul>
            </nav>
        </aside>

        <div class="case-split-content">
            <!-- Challenge -->
            <section id="challenge" class="case-chapter">
                <h2 class="chapter-title">The Challenge</h2>
                <p class="lead">Enterprise organizations using both Hyland OnBase and Salesforce faced a persistent problem: constant context switching between applications.</p>
                <p>Sales teams couldn't quickly access customer contracts. Service agents struggled to retrieve supporting documentation. The disconnect between content management and CRM was costing organizations time and money.</p>

                <div class="case-callout">
                    <h4>Pain Points</h4>
                    <ul>
                        <li>Users switching between apps to manage documents and records</li>
                        <li>Manual data entry creating errors and inconsistencies</li>
                        <li>No unified search across enterprise content</li>
                        <li>Complex implementations requiring custom API development</li>
                    </ul>
                </div>

                <p><strong>Hyland needed more than an integration. They needed a product that felt native to Salesforce.</strong></p>
            </section>

            <!-- Image Break -->
            <div class="case-image-break">
                <div class="case-image-placeholder" style="background: linear-gradient(135deg, #1e293b, #475569);"></div>
                <span class="image-caption">Context switching between OnBase and Salesforce before integration</span>
            </div>

            <!-- Approach -->
            <section id="approach" class="case-chapter">
                <h2 class="chapter-title">The Approach</h2>
                <p class="lead">We treated the integration as a product experience, not just a technical connection.</p>

                <div class="approach-principles">
                    <div class="principle">
                        <span class="principle-icon">01</span>
                        <span class="principle-text">Zero context switching</span>
                    </div>
                    <div class="principle">
                        <span class="principle-icon">02</span>
                        <span class="principle-text">Intelligent automation</span>
                    </div>
                    <div class="principle">
                        <span class="principle-icon">03</span>
                        <span class="principle-text">Admin-friendly config</span>
                    </div>
                </div>

                <h3>Discovery & Research</h3>
                <p>We conducted user interviews across Financial Services, Healthcare, and Retail sectors. Each industry had unique workflows, but the frustration was universal: too many clicks, too many apps, too much friction.</p>

                <h3>Design System Alignment</h3>
                <p>Every component was designed to match Salesforce Lightning patterns exactly. The integration shouldn't feel like an add-on—it should feel like Salesforce built it themselves.</p>

                <h3>Progressive Disclosure</h3>
                <p>Power users needed advanced features. Casual users needed simplicity. We designed interfaces that revealed complexity only when needed, keeping the default experience clean and focused.</p>
            </section>

            <!-- Solution -->
            <section id="solution" class="case-chapter">
                <h2 class="chapter-title">The Solution</h2>
                <p class="lead">Four core capabilities that transformed how enterprises manage content within Salesforce.</p>

                <h3>Drag-and-Drop Document Management</h3>
                <p>Users can drag files directly onto Salesforce records, automatically storing them in OnBase with proper indexing and retention policies applied. No manual categorization. No switching apps.</p>

                <h3>Intelligent Field Mapping</h3>
                <p>Salesforce field values automatically map to OnBase keywords. When a user uploads a document to an Account record, the account name, industry, and owner are automatically indexed—eliminating manual data entry entirely.</p>

                <h3>Unified Search</h3>
                <p>Search and retrieve enterprise content from OnBase without leaving Salesforce. Results appear in a familiar grid view that integrates naturally with the Lightning experience. Users find what they need in seconds, not minutes.</p>

                <h3>Out-of-Box Configuration</h3>
                <p>Administrators can configure the integration through a visual interface—no custom API development required. This dramatically reduces implementation time and total cost of ownership.</p>
            </section>

            <!-- Image Break -->
            <div class="case-image-break">
                <div class="case-image-placeholder" style="background: linear-gradient(135deg, #0ea5e9, #0284c7);"></div>
                <span class="image-caption">Drag-and-drop document management within Salesforce Lightning</span>
            </div>

            <!-- Technical -->
            <section id="technical" class="case-chapter">
                <h2 class="chapter-title">Technical Integration</h2>
                <p class="lead">Enterprise-grade architecture designed for security, scalability, and reliability.</p>

                <div class="case-callout">
                    <h4>Integration Stack</h4>
                    <ul>
                        <li><strong>Hyland Identity Provider</strong> - Secure authentication</li>
                        <li><strong>Hyland API Server</strong> - Reliable data exchange</li>
                        <li><strong>IIS Web Application</strong> - Seamless communication layer</li>
                        <li><strong>OnBase Foundation EP2+</strong> - Content management backbone</li>
                    </ul>
                </div>

                <h3>Salesforce Compatibility</h3>
                <p>The integration supports Sales Cloud and Service Cloud across Professional, Enterprise, Unlimited, Force.com, and Developer editions. Full Lightning Experience support ensures a modern, responsive interface.</p>

                <h3>Security & Compliance</h3>
                <p>Enterprise customers in regulated industries need confidence. The integration maintains OnBase's security model while providing seamless access through Salesforce's trusted platform.</p>
            </section>

            <!-- Results -->
            <section id="results" class="case-chapter">
                <h2 class="chapter-title">Results by Industry</h2>
                <p class="lead">The integration now serves enterprise customers across three key verticals on the Salesforce AppExchange.</p>

                <div class="results-cards">
                    <div class="result-card">
                        <span class="result-value">Financial</span>
                        <span class="result-label">Streamlined loan documents, faster onboarding, improved compliance</span>
                    </div>
                    <div class="result-card">
                        <span class="result-value">Healthcare</span>
                        <span class="result-label">Unified patient records, simplified claims, better care coordination</span>
                    </div>
                    <div class="result-card">
                        <span class="result-value">Retail</span>
                        <span class="result-label">Centralized vendor docs, efficient contracts, stronger supplier relationships</span>
                    </div>
                </div>

                <p>The product launched on the Salesforce AppExchange with a starting price of $20/user/month for enterprises with 25+ users.</p>
            </section>

            <!-- Learnings -->
            <section id="learnings" class="case-chapter">
                <h2 class="chapter-title">What We Learned</h2>

                <div class="learnings-grid">
                    <div class="learning-item">
                        <span class="learning-number">01</span>
                        <p>Integration UX is product UX—it deserves the same rigor</p>
                    </div>
                    <div class="learning-item">
                        <span class="learning-number">02</span>
                        <p>Native feel matters more than feature count</p>
                    </div>
                    <div class="learning-item">
                        <span class="learning-number">03</span>
                        <p>Admin experience determines implementation success</p>
                    </div>
                    <div class="learning-item">
                        <span class="learning-number">04</span>
                        <p>Cross-industry research reveals universal patterns</p>
                    </div>
                </div>
            </section>

            <!-- Takeaway -->
            <section class="case-chapter case-takeaway-split">
                <blockquote class="featured-quote">
                    <p class="quote-emphasis">When systems are designed to work together seamlessly, users stop thinking about tools and start focusing on outcomes.</p>
                </blockquote>
                <p>By combining Hyland's industry-leading content management with Salesforce's CRM power, we created an integration that enterprises actually want to use—not work around.</p>
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
                <a href="<?php echo esc_url(home_url('/work/case-studies/hyland-for-workday-integration/')); ?>" class="case-pagination-link case-pagination-next">
                    <div class="case-pagination-text">
                        <span class="case-pagination-label">Next</span>
                        <span class="case-pagination-title">Hyland for Workday</span>
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
                <h2>Ready to integrate your enterprise systems?</h2>
                <p>Let's discuss how thoughtful UX can bridge complex platforms.</p>
                <div class="cta-buttons">
                    <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-white btn-lg">Start a Conversation</a>
                    <a href="https://appexchange.salesforce.com/appxListingDetail?listingId=a0N3A00000G0oQCUAZ" class="btn btn-outline-white btn-lg" target="_blank" rel="noopener noreferrer">View on AppExchange</a>
                </div>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>
