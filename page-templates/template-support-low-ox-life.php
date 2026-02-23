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

<main id="main-content" class="site-main">

    <article class="app-support-detail-page">

        <!-- Page Header -->
        <header class="page-header app-detail-header">
            <div class="container">
                <div class="back-link-wrapper">
                    <a href="<?php echo esc_url(home_url('/support')); ?>" class="back-link">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="15 18 9 12 15 6"></polyline>
                        </svg>
                        <?php esc_html_e('All Apps', 'bfluxco'); ?>
                    </a>
                </div>
                <div class="app-detail-badge">iOS App</div>
                <h1 class="page-title">Low Ox Life Support</h1>
            </div>
        </header>

        <!-- Quick Help Section -->
        <section class="section app-detail-section">
            <div class="container">
                <div class="content-wrapper max-w-3xl mx-auto">
                    <h2 class="section-title">Quick Help</h2>
                    <div class="quick-help-grid">
                        <div class="quick-help-item">
                            <div class="quick-help-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="17 8 12 3 7 8"></polyline>
                                    <line x1="12" y1="3" x2="12" y2="15"></line>
                                </svg>
                            </div>
                            <h3>Restore Purchases</h3>
                            <p>Go to <strong>Settings &gt; Account &gt; Restore Purchases</strong> to restore your subscription on a new device.</p>
                        </div>
                        <div class="quick-help-item">
                            <div class="quick-help-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                            </div>
                            <h3>Manage Subscription</h3>
                            <p>To cancel or modify your subscription, go to <strong>iPhone Settings &gt; Apple ID &gt; Subscriptions</strong>.</p>
                        </div>
                        <div class="quick-help-item">
                            <div class="quick-help-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" y1="16" x2="12" y2="12"></line>
                                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                                </svg>
                            </div>
                            <h3>Check App Version</h3>
                            <p>Go to <strong>Settings &gt; About</strong> to see your current app version. Keep the app updated for the latest features.</p>
                        </div>
                        <div class="quick-help-item">
                            <div class="quick-help-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="1 4 1 10 7 10"></polyline>
                                    <path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path>
                                </svg>
                            </div>
                            <h3>Reset Data</h3>
                            <p>To clear cached data, go to <strong>Settings &gt; Data &gt; Clear Cache</strong>. Your tracked entries are stored in iCloud.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQs Section -->
        <section class="section app-detail-section">
            <div class="container">
                <div class="content-wrapper max-w-3xl mx-auto">
                    <h2 class="section-title">Frequently Asked Questions</h2>

                    <div class="faq-category">
                        <h3 class="faq-category-title">Subscription & Billing</h3>
                        <div class="faq-list">
                            <details class="faq-item">
                                <summary class="faq-question">How do I cancel my subscription?</summary>
                                <div class="faq-answer">
                                    <p>Subscriptions are managed through Apple. Go to <strong>iPhone Settings &gt; [Your Name] &gt; Subscriptions</strong>, find Low Ox Life, and tap "Cancel Subscription." Your access continues until the end of the current billing period.</p>
                                </div>
                            </details>
                            <details class="faq-item">
                                <summary class="faq-question">How do I get a refund?</summary>
                                <div class="faq-answer">
                                    <p>Refunds are processed by Apple. Visit <a href="https://reportaproblem.apple.com" target="_blank" rel="noopener">reportaproblem.apple.com</a>, sign in with your Apple ID, find your Low Ox Life purchase, and request a refund.</p>
                                </div>
                            </details>
                            <details class="faq-item">
                                <summary class="faq-question">Can I share my subscription with family?</summary>
                                <div class="faq-answer">
                                    <p>Low Ox Life supports Family Sharing. If Family Sharing is enabled on your Apple ID, family members can access your subscription at no additional cost.</p>
                                </div>
                            </details>
                        </div>
                    </div>

                    <div class="faq-category">
                        <h3 class="faq-category-title">Data & Sync</h3>
                        <div class="faq-list">
                            <details class="faq-item">
                                <summary class="faq-question">Where is my data stored?</summary>
                                <div class="faq-answer">
                                    <p>Your food logs and tracking data are stored in iCloud, linked to your Apple ID. This means your data syncs automatically across all your Apple devices signed into the same account.</p>
                                </div>
                            </details>
                            <details class="faq-item">
                                <summary class="faq-question">My data isn't syncing between devices</summary>
                                <div class="faq-answer">
                                    <p>Ensure iCloud is enabled for Low Ox Life on all devices: <strong>iPhone Settings &gt; [Your Name] &gt; iCloud &gt; Apps Using iCloud</strong>. Also check that you're signed into the same Apple ID on all devices.</p>
                                </div>
                            </details>
                            <details class="faq-item">
                                <summary class="faq-question">How do I export my data?</summary>
                                <div class="faq-answer">
                                    <p>Go to <strong>Settings &gt; Data &gt; Export</strong> to download a copy of your tracking history. You can export as CSV for spreadsheets or JSON for backup.</p>
                                </div>
                            </details>
                        </div>
                    </div>

                    <div class="faq-category">
                        <h3 class="faq-category-title">Oxalate Tracking</h3>
                        <div class="faq-list">
                            <details class="faq-item">
                                <summary class="faq-question">How accurate is the oxalate data?</summary>
                                <div class="faq-answer">
                                    <p>Our database is compiled from peer-reviewed research and updated regularly. However, oxalate content can vary based on growing conditions, preparation methods, and portion sizes. Use the data as a guide, not medical advice.</p>
                                </div>
                            </details>
                            <details class="faq-item">
                                <summary class="faq-question">A food I eat isn't in the database</summary>
                                <div class="faq-answer">
                                    <p>You can request foods to be added by emailing <a href="mailto:appsupport@bigfreightlife.com">appsupport@bigfreightlife.com</a> with the food name and any source information you have. We prioritize adding commonly requested items.</p>
                                </div>
                            </details>
                            <details class="faq-item">
                                <summary class="faq-question">What do the oxalate levels mean?</summary>
                                <div class="faq-answer">
                                    <p><strong>Low:</strong> Less than 5mg per serving. <strong>Medium:</strong> 5-15mg per serving. <strong>High:</strong> 15-50mg per serving. <strong>Very High:</strong> More than 50mg per serving. Your daily target depends on your individual health situation.</p>
                                </div>
                            </details>
                        </div>
                    </div>

                    <div class="faq-category">
                        <h3 class="faq-category-title">AI Chat Features</h3>
                        <div class="faq-list">
                            <details class="faq-item">
                                <summary class="faq-question">How does the AI assistant work?</summary>
                                <div class="faq-answer">
                                    <p>The AI assistant helps answer questions about oxalates, suggest low-oxalate alternatives, and provide meal planning guidance. It's powered by advanced language models but is not a substitute for medical advice.</p>
                                </div>
                            </details>
                            <details class="faq-item">
                                <summary class="faq-question">Is my chat history private?</summary>
                                <div class="faq-answer">
                                    <p>Chat conversations are processed to provide responses but are not stored permanently or used for training. Your privacy is important to us. See our <a href="<?php echo esc_url(home_url('/privacy')); ?>">Privacy Policy</a> for details.</p>
                                </div>
                            </details>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Support Section -->
        <section class="section bg-gray-50 app-detail-section">
            <div class="container">
                <div class="content-wrapper max-w-5xl mx-auto">
                    <h2 class="section-title">Contact Support</h2>
                    <div class="contact-support-grid">
                        <!-- Contact Form Column -->
                        <div class="contact-support-form">
                            <div class="support-form-card">
                                <h3>Send a Message</h3>
                                <?php
                                // Display success/error messages
                                $status = isset($_GET['status']) ? sanitize_text_field($_GET['status']) : '';
                                if ($status === 'success') : ?>
                                    <div class="form-message form-message-success">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                        </svg>
                                        <span><?php esc_html_e('Thank you! Your message has been sent. We\'ll get back to you soon.', 'bfluxco'); ?></span>
                                    </div>
                                <?php elseif ($status === 'error') : ?>
                                    <div class="form-message form-message-error">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <line x1="15" y1="9" x2="9" y2="15"></line>
                                            <line x1="9" y1="9" x2="15" y2="15"></line>
                                        </svg>
                                        <span><?php esc_html_e('Sorry, there was an error sending your message. Please try again or email us directly.', 'bfluxco'); ?></span>
                                    </div>
                                <?php endif; ?>
                                <form class="support-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
                                    <?php wp_nonce_field('bfluxco_support_form', 'bfluxco_support_nonce'); ?>
                                    <input type="hidden" name="action" value="bfluxco_support_submit">
                                    <input type="hidden" name="app" value="low-ox-life">

                                    <div class="form-group">
                                        <label for="support-name"><?php esc_html_e('Name', 'bfluxco'); ?> *</label>
                                        <input type="text" id="support-name" name="support_name" required class="form-input" placeholder="<?php esc_attr_e('Your name', 'bfluxco'); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="support-email"><?php esc_html_e('Email', 'bfluxco'); ?> *</label>
                                        <input type="email" id="support-email" name="support_email" required class="form-input" placeholder="<?php esc_attr_e('you@example.com', 'bfluxco'); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="support-subject"><?php esc_html_e('Subject', 'bfluxco'); ?></label>
                                        <input type="text" id="support-subject" name="support_subject" class="form-input" placeholder="<?php esc_attr_e('What can we help with?', 'bfluxco'); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="support-message"><?php esc_html_e('Message', 'bfluxco'); ?> *</label>
                                        <textarea id="support-message" name="support_message" rows="5" required class="form-textarea" placeholder="<?php esc_attr_e('Describe your issue or question...', 'bfluxco'); ?>"></textarea>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-full">
                                        <?php esc_html_e('Send Message', 'bfluxco'); ?>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Feedback Column -->
                        <div class="contact-support-info">
                            <div class="feedback-card">
                                <h3>Submit Feedback</h3>
                                <p>Have an idea to improve Low Ox Life? Found a bug? Use the form to send us your feedback.</p>
                                <p>Please include:</p>
                                <ul>
                                    <li>A clear description of the feature or issue</li>
                                    <li>Why it would be helpful</li>
                                    <li>Any screenshots or examples</li>
                                </ul>
                            </div>
                            <div class="feedback-card">
                                <h3>Beta Testing</h3>
                                <p>Want early access to new features? Join our TestFlight beta program to test upcoming releases before they're public.</p>
                                <p>Send a message with "Beta Request" in the subject to request access.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </article>

</main>

<style>
/* Back Link - left aligned */
.app-detail-header .back-link {
    display: inline-flex;
    align-items: center;
    gap: var(--spacing-2);
    color: var(--text-muted);
    text-decoration: none;
    font-size: var(--font-size-sm);
    transition: color var(--transition-fast);
}

.app-detail-header .back-link-wrapper {
    display: block;
    text-align: left;
    margin-bottom: var(--spacing-4);
    position: absolute;
    top: 16px;
    left: 0;
}

.app-detail-header .container {
    position: relative;
}

.back-link:hover {
    color: var(--color-primary);
}

/* Product Badge */
.app-detail-badge {
    display: inline-block;
    padding: var(--spacing-1) var(--spacing-3);
    background: rgba(20, 184, 166, 0.1);
    color: var(--color-primary);
    font-size: var(--font-size-xs);
    font-weight: var(--font-weight-semibold);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-radius: var(--radius-full);
    margin-bottom: var(--spacing-3);
}

/* Section Titles */
.app-detail-section .section-title {
    font-size: var(--font-size-xl);
    font-weight: var(--font-weight-semibold);
    color: var(--text-primary);
    margin-bottom: var(--spacing-6);
}

/* Quick Help Grid */
.quick-help-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: var(--spacing-6);
}

@media (max-width: 640px) {
    .quick-help-grid {
        grid-template-columns: 1fr;
    }
}

.quick-help-item {
    padding: var(--spacing-5);
    background: var(--bg-primary);
    border: 1px solid var(--border-primary);
    border-radius: var(--radius-lg);
}

.quick-help-icon {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(20, 184, 166, 0.1);
    border-radius: var(--radius-md);
    color: var(--color-primary);
    margin-bottom: var(--spacing-3);
}

.quick-help-item h3 {
    font-size: var(--font-size-base);
    font-weight: var(--font-weight-semibold);
    color: var(--text-primary);
    margin-bottom: var(--spacing-2);
}

.quick-help-item p {
    font-size: var(--font-size-sm);
    color: var(--text-muted);
    margin: 0;
    line-height: 1.6;
}

/* Contact Support Card */
.contact-support-card {
    background: var(--bg-primary);
    border: 1px solid var(--border-primary);
    border-radius: var(--radius-lg);
    overflow: hidden;
}

.contact-support-main {
    padding: var(--spacing-6);
    border-bottom: 1px solid var(--border-primary);
}

.contact-label {
    display: block;
    font-size: var(--font-size-sm);
    color: var(--text-muted);
    margin-bottom: var(--spacing-1);
}

.contact-email-link {
    font-size: var(--font-size-xl);
    font-weight: var(--font-weight-semibold);
    color: var(--color-primary);
    text-decoration: none;
}

.contact-email-link:hover {
    text-decoration: underline;
}

.contact-response {
    margin-top: var(--spacing-3);
    font-size: var(--font-size-sm);
    color: var(--text-muted);
}

.contact-include {
    padding: var(--spacing-5) var(--spacing-6);
    background: var(--bg-secondary);
}

.contact-include h4 {
    font-size: var(--font-size-sm);
    font-weight: var(--font-weight-semibold);
    color: var(--text-primary);
    margin-bottom: var(--spacing-3);
}

.contact-include ul {
    margin: 0;
    padding-left: var(--spacing-5);
    font-size: var(--font-size-sm);
    color: var(--text-muted);
}

.contact-include li {
    margin-bottom: var(--spacing-1);
}

/* Contact Support Grid */
.contact-support-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: var(--spacing-8);
    align-items: start;
}

@media (max-width: 768px) {
    .contact-support-grid {
        grid-template-columns: 1fr;
    }
}

/* Support Form Card */
.support-form-card {
    background: var(--bg-primary);
    border: 1px solid var(--border-primary);
    border-radius: var(--radius-lg);
    padding: var(--spacing-6);
}

.support-form-card h3 {
    font-size: var(--font-size-lg);
    font-weight: var(--font-weight-semibold);
    color: var(--text-primary);
    margin-bottom: var(--spacing-5);
}

.support-form .form-group {
    margin-bottom: var(--spacing-4);
}

.support-form label {
    display: block;
    font-size: var(--font-size-sm);
    font-weight: var(--font-weight-medium);
    color: var(--text-primary);
    margin-bottom: var(--spacing-2);
}

.support-form .form-input,
.support-form .form-textarea {
    width: 100%;
    padding: var(--spacing-3) var(--spacing-4);
    font-size: var(--font-size-base);
    color: var(--text-primary);
    background: var(--bg-primary);
    border: 1px solid var(--border-primary);
    border-radius: var(--radius-md);
    transition: border-color var(--transition-fast), box-shadow var(--transition-fast);
}

.support-form .form-input:focus,
.support-form .form-textarea:focus {
    outline: none;
    border-color: var(--color-primary);
    box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.1);
}

.support-form .form-textarea {
    resize: vertical;
    min-height: 120px;
}

.support-form .btn-full {
    width: 100%;
    justify-content: center;
}

/* Form Messages */
.form-message {
    display: flex;
    align-items: flex-start;
    gap: var(--spacing-3);
    padding: var(--spacing-4);
    border-radius: var(--radius-md);
    margin-bottom: var(--spacing-5);
    font-size: var(--font-size-sm);
    line-height: 1.5;
}

.form-message svg {
    flex-shrink: 0;
    margin-top: 2px;
}

.form-message-success {
    background: rgba(16, 185, 129, 0.1);
    border: 1px solid rgba(16, 185, 129, 0.3);
    color: #059669;
}

.form-message-error {
    background: rgba(239, 68, 68, 0.1);
    border: 1px solid rgba(239, 68, 68, 0.3);
    color: #dc2626;
}

/* FAQ Styles */
.faq-category {
    margin-bottom: var(--spacing-8);
}

.faq-category:last-child {
    margin-bottom: 0;
}

.faq-category-title {
    font-size: var(--font-size-lg);
    font-weight: var(--font-weight-semibold);
    color: var(--text-primary);
    margin-bottom: var(--spacing-4);
    padding-bottom: var(--spacing-2);
    border-bottom: 1px solid var(--border-primary);
}

.faq-list {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-3);
}

.faq-item {
    background: var(--bg-primary);
    border: 1px solid var(--border-primary);
    border-radius: var(--radius-md);
    overflow: hidden;
}

.faq-question {
    padding: var(--spacing-4) var(--spacing-5);
    font-size: var(--font-size-base);
    font-weight: var(--font-weight-medium);
    color: var(--text-primary);
    cursor: pointer;
    list-style: none;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.faq-question::-webkit-details-marker {
    display: none;
}

.faq-question::after {
    content: '+';
    font-size: var(--font-size-xl);
    color: var(--text-muted);
    transition: transform var(--transition-fast);
}

.faq-item[open] .faq-question::after {
    content: '−';
}

.faq-answer {
    padding: 0 var(--spacing-5) var(--spacing-4);
    font-size: var(--font-size-sm);
    color: var(--text-muted);
    line-height: 1.7;
}

.faq-answer p {
    margin: 0 0 var(--spacing-3);
}

.faq-answer p:last-child {
    margin-bottom: 0;
}

.faq-answer a {
    color: var(--color-primary);
}

/* Feedback Grid */
.feedback-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: var(--spacing-6);
}

@media (max-width: 640px) {
    .feedback-grid {
        grid-template-columns: 1fr;
    }
}

.feedback-card {
    padding: var(--spacing-5);
    background: var(--bg-primary);
    border: 1px solid var(--border-primary);
    border-radius: var(--radius-lg);
}

.feedback-card h3 {
    font-size: var(--font-size-base);
    font-weight: var(--font-weight-semibold);
    color: var(--text-primary);
    margin-bottom: var(--spacing-3);
}

.feedback-card p {
    font-size: var(--font-size-sm);
    color: var(--text-muted);
    margin-bottom: var(--spacing-3);
    line-height: 1.6;
}

.feedback-card ul {
    margin: 0;
    padding-left: var(--spacing-5);
    font-size: var(--font-size-sm);
    color: var(--text-muted);
}

.feedback-card a {
    color: var(--color-primary);
}
</style>

<?php
get_footer();
