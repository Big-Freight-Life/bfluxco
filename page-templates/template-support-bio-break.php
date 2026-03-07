<?php
/**
 * Template Name: Bio Break Support
 * Template Post Type: page
 *
 * Dedicated support page for the Bio Break iOS app.
 * URL: /support/bio-break
 *
 * @package BFLUXCO
 */

get_header();
?>

<main id="main-content" class="site-main bb-support-page">

    <article class="app-support-detail-page">

        <!-- Hero -->
        <section class="bb-support-hero">
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
                <h1 class="hero-title reveal" data-delay="1">Bio Break Support</h1>
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
                    <div class="bb-quick-help-grid">
                        <div class="bb-quick-help-card reveal" data-delay="0">
                            <div class="card-icon">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="17 8 12 3 7 8"></polyline>
                                    <line x1="12" y1="3" x2="12" y2="15"></line>
                                </svg>
                            </div>
                            <h3>Restore Purchases</h3>
                            <p><strong>Settings &gt; Account &gt; Restore Purchases</strong> to restore your Pro subscription on a new device.</p>
                        </div>
                        <div class="bb-quick-help-card reveal" data-delay="1">
                            <div class="card-icon">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                            </div>
                            <h3>Manage Subscription</h3>
                            <p><strong>iPhone Settings &gt; Apple ID &gt; Subscriptions</strong> to cancel or modify your Pro plan.</p>
                        </div>
                        <div class="bb-quick-help-card reveal" data-delay="2">
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
                        <div class="bb-quick-help-card reveal" data-delay="3">
                            <div class="card-icon">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"></path>
                                </svg>
                            </div>
                            <h3>iCloud Sync</h3>
                            <p><strong>Settings &gt; Sync</strong> to enable iCloud sync across iPhone and Apple Watch (Pro feature).</p>
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

                    <nav class="bb-faq-tabs reveal" aria-label="FAQ categories">
                        <button class="bb-faq-tab is-active" data-faq-tab="billing" type="button">Billing</button>
                        <button class="bb-faq-tab" data-faq-tab="data" type="button">Data &amp; Sync</button>
                        <button class="bb-faq-tab" data-faq-tab="tracking" type="button">Tracking</button>
                        <button class="bb-faq-tab" data-faq-tab="watch" type="button">Apple Watch</button>
                    </nav>

                    <!-- Billing -->
                    <div class="bb-faq-panel is-active" data-faq-panel="billing">
                        <div class="bb-faq-list">
                            <details class="bb-faq-item">
                                <summary class="bb-faq-question">How do I cancel my Pro subscription?</summary>
                                <div class="bb-faq-answer">
                                    <p>Subscriptions are managed through Apple. Go to <strong>iPhone Settings &gt; [Your Name] &gt; Subscriptions</strong>, find Bio Break, and tap "Cancel Subscription." Your Pro access continues until the end of the current billing period.</p>
                                </div>
                            </details>
                            <details class="bb-faq-item">
                                <summary class="bb-faq-question">How do I get a refund?</summary>
                                <div class="bb-faq-answer">
                                    <p>Refunds are processed by Apple. Visit <a href="https://reportaproblem.apple.com" target="_blank" rel="noopener">reportaproblem.apple.com</a>, sign in with your Apple ID, find your Bio Break purchase, and request a refund.</p>
                                </div>
                            </details>
                            <details class="bb-faq-item">
                                <summary class="bb-faq-question">Is the free tier really free?</summary>
                                <div class="bb-faq-answer">
                                    <p>Yes. The free tier includes the hydration dashboard, quick logging for both types, Bristol Stool Scale, calendar heat map, smart reminders, and the full Apple Watch companion app. No time limits, no ads.</p>
                                </div>
                            </details>
                        </div>
                    </div>

                    <!-- Data & Sync -->
                    <div class="bb-faq-panel" data-faq-panel="data">
                        <div class="bb-faq-list">
                            <details class="bb-faq-item">
                                <summary class="bb-faq-question">Where is my data stored?</summary>
                                <div class="bb-faq-answer">
                                    <p>Your data is stored locally on your device by default. With Pro, you can enable iCloud sync to keep data in sync across iPhone and Apple Watch. All data is encrypted at rest on your device and encrypted in transit via iCloud.</p>
                                </div>
                            </details>
                            <details class="bb-faq-item">
                                <summary class="bb-faq-question">My data isn't syncing between devices</summary>
                                <div class="bb-faq-answer">
                                    <p>Make sure you have a Pro subscription and iCloud sync is enabled in <strong>Settings &gt; Sync</strong>. Verify iCloud is enabled on your device: <strong>iPhone Settings &gt; [Your Name] &gt; iCloud &gt; Apps Using iCloud</strong>. Try pulling down to refresh.</p>
                                </div>
                            </details>
                            <details class="bb-faq-item">
                                <summary class="bb-faq-question">How do I export my data?</summary>
                                <div class="bb-faq-answer">
                                    <p>With Pro, go to <strong>Settings &gt; Export Data</strong> to download your logs as CSV or PDF. Reports include timestamps, Bristol Stool types, urine color, urgency, hydration, and notes — ready to share with your healthcare provider.</p>
                                </div>
                            </details>
                            <details class="bb-faq-item">
                                <summary class="bb-faq-question">Is my data private?</summary>
                                <div class="bb-faq-answer">
                                    <p>Absolutely. Bio Break is private by default — all data is encrypted at rest on your device. There are no ads, no third-party analytics, and no tracking. iCloud sync uses end-to-end encryption. See our <a href="<?php echo esc_url(home_url('/legal/bio-break-privacy')); ?>">Privacy Policy</a> for full details.</p>
                                </div>
                            </details>
                        </div>
                    </div>

                    <!-- Tracking -->
                    <div class="bb-faq-panel" data-faq-panel="tracking">
                        <div class="bb-faq-list">
                            <details class="bb-faq-item">
                                <summary class="bb-faq-question">What is the Bristol Stool Scale?</summary>
                                <div class="bb-faq-answer">
                                    <p>The Bristol Stool Scale is a medical classification system that categorizes stool into 7 types based on form and consistency. Types 1-2 indicate constipation, Types 3-4 are considered normal, and Types 5-7 indicate loose stools. Bio Break uses this standard to help you track patterns over time.</p>
                                </div>
                            </details>
                            <details class="bb-faq-item">
                                <summary class="bb-faq-question">How do I log a break?</summary>
                                <div class="bb-faq-answer">
                                    <p>From the Today dashboard, tap <strong>Log BB1</strong> (urination) or <strong>Log BB2</strong> (bowel movement). You can add optional details like urgency, color, Bristol type, and notes. The whole process takes just seconds.</p>
                                </div>
                            </details>
                            <details class="bb-faq-item">
                                <summary class="bb-faq-question">What do the urine color indicators mean?</summary>
                                <div class="bb-faq-answer">
                                    <p>Urine color is a common indicator of hydration levels. Pale/clear indicates good hydration, while dark yellow or amber may suggest dehydration. Bio Break provides a color reference chart to help you track over time. This is for informational purposes only — consult your doctor for medical concerns.</p>
                                </div>
                            </details>
                        </div>
                    </div>

                    <!-- Apple Watch -->
                    <div class="bb-faq-panel" data-faq-panel="watch">
                        <div class="bb-faq-list">
                            <details class="bb-faq-item">
                                <summary class="bb-faq-question">How does the Apple Watch app work?</summary>
                                <div class="bb-faq-answer">
                                    <p>The Apple Watch companion app lets you log breaks directly from your wrist. You can log BB1 and BB2, view time since last break, see today's count, and check your 7-day average. It includes 4 complication families for your watch face.</p>
                                </div>
                            </details>
                            <details class="bb-faq-item">
                                <summary class="bb-faq-question">Is the Apple Watch app included in the free tier?</summary>
                                <div class="bb-faq-answer">
                                    <p>Yes. The full Apple Watch companion app is included in the free tier. You can log breaks, view stats, and use complications at no cost.</p>
                                </div>
                            </details>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact — Dark band -->
        <section class="section bb-contact-section">
            <div class="contact-bg"></div>
            <div class="container">
                <div class="content-wrapper max-w-3xl mx-auto">
                    <span class="section-label reveal">Contact</span>
                    <h2 class="section-title reveal">Need more help?</h2>
                    <p class="section-subtitle reveal">Reach out directly and we'll get back to you.</p>

                    <div class="bb-contact-email reveal">
                        <div class="bb-email-icon">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                        </div>
                        <h3>Email Us Directly</h3>
                        <a href="mailto:appsupport@bigfreightlife.com?subject=Bio%20Break%20Support" class="bb-email-link">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            appsupport@bigfreightlife.com
                        </a>
                        <p class="bb-email-note">We typically respond within 24-48 hours.</p>
                    </div>

                    <div class="bb-info-cards">
                        <div class="bb-info-card reveal" data-delay="1">
                            <h3>Submit Feedback</h3>
                            <p>Have an idea to improve Bio Break? Found a bug? Email us with your feedback. Please include:</p>
                            <ul>
                                <li>A clear description of the feature or issue</li>
                                <li>Why it would be helpful</li>
                                <li>Any screenshots or examples</li>
                            </ul>
                        </div>
                        <div class="bb-info-card reveal" data-delay="2">
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
