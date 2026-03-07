<?php
/**
 * Template Name: Low Ox Life Support
 * Template Post Type: page
 *
 * Dedicated support page for the Low Ox Life iOS app.
 * URL: /support/low-ox-life
 *
 * @package BFLUXCO
 */

get_header();
?>

<main id="main-content" class="site-main lol-support-page">

    <article class="app-support-detail-page">

        <!-- Hero -->
        <section class="lol-support-hero">
            <div class="hero-bg"></div>
            <div class="hero-grid"></div>
            <div class="container">
                <a href="<?php echo esc_url(home_url('/support')); ?>" class="back-link reveal-fade">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                    <?php esc_html_e('All Apps', 'bfluxco'); ?>
                </a>
                <div class="hero-badge reveal-fade" data-delay="1">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.8-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83"/><path d="M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11"/></svg>
                    iOS App
                </div>
                <h1 class="hero-title reveal" data-delay="1">Low Ox Life Support</h1>
                <p class="hero-subtitle reveal" data-delay="2">Find answers, manage your account, or get in touch with our team.</p>
            </div>
        </section>

        <!-- Quick Help -->
        <section class="section">
            <div class="container">
                <div class="content-wrapper max-w-5xl mx-auto">
                    <span class="section-label reveal">Quick Help</span>
                    <h2 class="section-title reveal">Common actions at a glance</h2>
                    <p class="section-subtitle reveal">The most frequently needed steps, right here.</p>
                    <div class="lol-quick-help-grid">
                        <div class="lol-quick-help-card reveal" data-delay="0">
                            <div class="card-icon">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="17 8 12 3 7 8"></polyline>
                                    <line x1="12" y1="3" x2="12" y2="15"></line>
                                </svg>
                            </div>
                            <h3>Restore Purchases</h3>
                            <p><strong>Settings &gt; Account &gt; Restore Purchases</strong> to restore your subscription on a new device.</p>
                        </div>
                        <div class="lol-quick-help-card reveal" data-delay="1">
                            <div class="card-icon">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                            </div>
                            <h3>Manage Subscription</h3>
                            <p><strong>iPhone Settings &gt; Apple ID &gt; Subscriptions</strong> to cancel or modify.</p>
                        </div>
                        <div class="lol-quick-help-card reveal" data-delay="2">
                            <div class="card-icon">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" y1="16" x2="12" y2="12"></line>
                                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                                </svg>
                            </div>
                            <h3>Check Version</h3>
                            <p><strong>Settings &gt; About</strong> to see your current app version. Keep updated for latest features.</p>
                        </div>
                        <div class="lol-quick-help-card reveal" data-delay="3">
                            <div class="card-icon">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="1 4 1 10 7 10"></polyline>
                                    <path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path>
                                </svg>
                            </div>
                            <h3>Reset Data</h3>
                            <p><strong>Settings &gt; Data &gt; Clear Cache</strong> to clear cached data. Tracked entries stay safe.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQs — Tabbed -->
        <section class="section">
            <div class="container">
                <div class="content-wrapper max-w-3xl mx-auto">
                    <span class="section-label reveal">FAQ</span>
                    <h2 class="section-title reveal">Frequently Asked Questions</h2>
                    <p class="section-subtitle reveal">Browse by category to find what you need.</p>

                    <nav class="lol-faq-tabs reveal" aria-label="FAQ categories">
                        <button class="lol-faq-tab is-active" data-faq-tab="billing" type="button">Billing</button>
                        <button class="lol-faq-tab" data-faq-tab="data" type="button">Data &amp; Sync</button>
                        <button class="lol-faq-tab" data-faq-tab="tracking" type="button">Tracking</button>
                        <button class="lol-faq-tab" data-faq-tab="ai" type="button">AI Chat</button>
                    </nav>

                    <!-- Billing -->
                    <div class="lol-faq-panel is-active" data-faq-panel="billing">
                        <div class="lol-faq-list">
                            <details class="lol-faq-item">
                                <summary class="lol-faq-question">How do I cancel my subscription?</summary>
                                <div class="lol-faq-answer">
                                    <p>Subscriptions are managed through Apple. Go to <strong>iPhone Settings &gt; [Your Name] &gt; Subscriptions</strong>, find Low Ox Life, and tap "Cancel Subscription." Your access continues until the end of the current billing period.</p>
                                </div>
                            </details>
                            <details class="lol-faq-item">
                                <summary class="lol-faq-question">How do I get a refund?</summary>
                                <div class="lol-faq-answer">
                                    <p>Refunds are processed by Apple. Visit <a href="https://reportaproblem.apple.com" target="_blank" rel="noopener">reportaproblem.apple.com</a>, sign in with your Apple ID, find your Low Ox Life purchase, and request a refund.</p>
                                </div>
                            </details>
                            <details class="lol-faq-item">
                                <summary class="lol-faq-question">Can I share my subscription with family?</summary>
                                <div class="lol-faq-answer">
                                    <p>Low Ox Life supports Family Sharing. If Family Sharing is enabled on your Apple ID, family members can access your subscription at no additional cost.</p>
                                </div>
                            </details>
                        </div>
                    </div>

                    <!-- Data & Sync -->
                    <div class="lol-faq-panel" data-faq-panel="data">
                        <div class="lol-faq-list">
                            <details class="lol-faq-item">
                                <summary class="lol-faq-question">Where is my data stored?</summary>
                                <div class="lol-faq-answer">
                                    <p>Your food journal, recipes, custom foods, and grocery lists are stored securely on our servers and sync automatically across all your devices when you sign in with your Low Ox Life account. App preferences (theme, language) also sync via iCloud. All data is encrypted in transit (TLS 1.3) and at rest (AES-256).</p>
                                </div>
                            </details>
                            <details class="lol-faq-item">
                                <summary class="lol-faq-question">My data isn't syncing between devices</summary>
                                <div class="lol-faq-answer">
                                    <p>Make sure you're signed into the same Low Ox Life account on all devices. Check your internet connection and try pulling down to refresh. If preferences (theme, language) aren't syncing, also verify iCloud is enabled: <strong>iPhone Settings &gt; [Your Name] &gt; iCloud &gt; Apps Using iCloud</strong>.</p>
                                </div>
                            </details>
                            <details class="lol-faq-item">
                                <summary class="lol-faq-question">How do I export my data?</summary>
                                <div class="lol-faq-answer">
                                    <p>Go to <strong>Account &gt; Privacy Settings &gt; Export Data</strong> to download all your data. Choose JSON (for backup) or CSV (for spreadsheets). You can save directly to iCloud Drive or share to any app. Exports include journal entries, recipes, custom food lists, and grocery lists.</p>
                                </div>
                            </details>
                            <details class="lol-faq-item">
                                <summary class="lol-faq-question">Is my data secure?</summary>
                                <div class="lol-faq-answer">
                                    <p>Yes. All data is encrypted in transit and at rest. Your health data is stored securely and is never shared with third parties. You can delete your account and all associated data at any time from Account settings. See our <a href="<?php echo esc_url(home_url('/legal/low-ox-life/privacy')); ?>">Privacy Policy</a> for full details.</p>
                                </div>
                            </details>
                        </div>
                    </div>

                    <!-- Tracking -->
                    <div class="lol-faq-panel" data-faq-panel="tracking">
                        <div class="lol-faq-list">
                            <details class="lol-faq-item">
                                <summary class="lol-faq-question">How accurate is the oxalate data?</summary>
                                <div class="lol-faq-answer">
                                    <p>Our database is compiled from peer-reviewed research and updated regularly. However, oxalate content can vary based on growing conditions, preparation methods, and portion sizes. Use the data as a guide, not medical advice.</p>
                                </div>
                            </details>
                            <details class="lol-faq-item">
                                <summary class="lol-faq-question">A food I eat isn't in the database</summary>
                                <div class="lol-faq-answer">
                                    <p>You can request foods to be added by emailing <a href="mailto:appsupport@bigfreightlife.com">appsupport@bigfreightlife.com</a> with the food name and any source information you have. We prioritize adding commonly requested items.</p>
                                </div>
                            </details>
                            <details class="lol-faq-item">
                                <summary class="lol-faq-question">What do the oxalate levels mean?</summary>
                                <div class="lol-faq-answer">
                                    <p><strong>Low:</strong> Less than 5mg per serving. <strong>Medium:</strong> 5-15mg per serving. <strong>High:</strong> 15-50mg per serving. <strong>Very High:</strong> More than 50mg per serving. Your daily target depends on your individual health situation.</p>
                                </div>
                            </details>
                        </div>
                    </div>

                    <!-- AI Chat -->
                    <div class="lol-faq-panel" data-faq-panel="ai">
                        <div class="lol-faq-list">
                            <details class="lol-faq-item">
                                <summary class="lol-faq-question">How does the AI assistant work?</summary>
                                <div class="lol-faq-answer">
                                    <p>The AI assistant helps answer questions about oxalates, suggest low-oxalate alternatives, and provide meal planning guidance. It's powered by advanced language models but is not a substitute for medical advice.</p>
                                </div>
                            </details>
                            <details class="lol-faq-item">
                                <summary class="lol-faq-question">Is my chat history private?</summary>
                                <div class="lol-faq-answer">
                                    <p>Chat conversations are processed to provide responses but are not stored permanently or used for training. Your privacy is important to us. See our <a href="<?php echo esc_url(home_url('/privacy')); ?>">Privacy Policy</a> for details.</p>
                                </div>
                            </details>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact — Dark band -->
        <section class="section lol-contact-section">
            <div class="contact-bg"></div>
            <div class="container">
                <div class="content-wrapper max-w-3xl mx-auto">
                    <span class="section-label reveal">Contact</span>
                    <h2 class="section-title reveal">Need more help?</h2>
                    <p class="section-subtitle reveal">Reach out directly and we'll get back to you.</p>

                    <div class="lol-contact-email reveal">
                        <div class="lol-email-icon">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                        </div>
                        <h3>Email Us Directly</h3>
                        <a href="mailto:appsupport@bigfreightlife.com?subject=Low%20Ox%20Life%20Support" class="lol-email-link">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            appsupport@bigfreightlife.com
                        </a>
                        <p class="lol-email-note">We typically respond within 24-48 hours.</p>
                    </div>

                    <div class="lol-info-cards">
                        <div class="lol-info-card reveal" data-delay="1">
                            <h3>Submit Feedback</h3>
                            <p>Have an idea to improve Low Ox Life? Found a bug? Email us with your feedback. Please include:</p>
                            <ul>
                                <li>A clear description of the feature or issue</li>
                                <li>Why it would be helpful</li>
                                <li>Any screenshots or examples</li>
                            </ul>
                        </div>
                        <div class="lol-info-card reveal" data-delay="2">
                            <h3>Beta Testing</h3>
                            <p>Want early access to new features? Join our TestFlight beta program to test upcoming releases before they're public.</p>
                            <p>Email us with "Beta Request" in the subject to request access.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </article>

</main>

<script>
(function() {
    var tabs = document.querySelectorAll('[data-faq-tab]');
    var panels = document.querySelectorAll('[data-faq-panel]');

    tabs.forEach(function(tab) {
        tab.addEventListener('click', function() {
            var target = this.getAttribute('data-faq-tab');

            tabs.forEach(function(t) { t.classList.remove('is-active'); });
            panels.forEach(function(p) { p.classList.remove('is-active'); });

            this.classList.add('is-active');
            var panel = document.querySelector('[data-faq-panel="' + target + '"]');
            if (panel) panel.classList.add('is-active');
        });
    });
})();
</script>

<?php
get_footer();
