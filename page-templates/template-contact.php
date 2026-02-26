<?php
/**
 * Template Name: Contact
 * Template Post Type: page
 *
 * Premium enterprise-grade contact page with animated network visual,
 * styled form, contact info cards, and FAQ accordion.
 *
 * @package BFLUXCO
 */

get_header();
?>

<main id="main-content" class="site-main">

    <!-- Hero Section -->
    <section class="contact-hero">
        <div class="container">
            <div class="contact-hero-inner">

                <!-- Hero Content -->
                <div class="contact-hero-content">
                    <span class="overline"><?php esc_html_e('Get in Touch', 'bfluxco'); ?></span>
                    <h1 class="display-text"><?php esc_html_e("Let's Build the Future Together", 'bfluxco'); ?></h1>
                    <p class="lead">
                        <?php esc_html_e("Whether you're exploring AI-powered solutions, refining customer experiences, or designing intelligent systems, I'd love to hear about your vision.", 'bfluxco'); ?>
                    </p>
                </div>

                <!-- Animated Network Visual -->
                <div class="contact-hero-visual">
                    <div class="contact-network">
                        <!-- Central hub -->
                        <div class="contact-network-hub"></div>

                        <!-- Satellite nodes -->
                        <div class="contact-network-node"></div>
                        <div class="contact-network-node"></div>
                        <div class="contact-network-node node-secondary"></div>
                        <div class="contact-network-node"></div>
                        <div class="contact-network-node node-secondary"></div>
                        <div class="contact-network-node"></div>

                        <!-- Connection lines (SVG) -->
                        <div class="contact-network-lines">
                            <svg viewBox="0 0 400 400" preserveAspectRatio="xMidYMid meet">
                                <!-- Lines from center to nodes -->
                                <line class="contact-network-line" x1="200" y1="200" x2="200" y2="40" />
                                <line class="contact-network-line" x1="200" y1="200" x2="360" y2="100" />
                                <line class="contact-network-line line-secondary" x1="200" y1="200" x2="360" y2="300" />
                                <line class="contact-network-line" x1="200" y1="200" x2="200" y2="360" />
                                <line class="contact-network-line line-secondary" x1="200" y1="200" x2="40" y2="300" />
                                <line class="contact-network-line" x1="200" y1="200" x2="40" y2="100" />
                            </svg>
                        </div>

                        <!-- Floating particles -->
                        <div class="contact-network-particle"></div>
                        <div class="contact-network-particle"></div>
                        <div class="contact-network-particle"></div>
                    </div>
                </div>

            </div>
        </div>
    </section><!-- .contact-hero -->


    <!-- Contact Form Section -->
    <section id="contact-form" class="contact-form-section">
        <div class="container">
            <div class="contact-form-grid">

                <!-- Form Column -->
                <div class="contact-form-column">
                    <div class="contact-section-header">
                        <h2><?php esc_html_e('Send a Message', 'bfluxco'); ?></h2>
                    </div>

                    <div class="contact-form-wrapper">
                        <?php
                        // Display page content (which should contain the contact form shortcode)
                        while (have_posts()) : the_post();
                            $content = get_the_content();
                            if (!empty($content)) :
                                the_content();
                            else :
                        ?>
                            <!-- Fallback HTML form - SECURITY NOTE: This form is non-functional by design.
                                 Install Contact Form 7 or WPForms plugin for a working, secure contact form. -->
                            <form class="contact-form" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post">
                                <?php wp_nonce_field( 'bfluxco_contact_form', 'bfluxco_contact_nonce' ); ?>
                                <input type="hidden" name="action" value="bfluxco_contact_submit">

                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="bfluxco-contact-name"><?php esc_html_e('Name', 'bfluxco'); ?> *</label>
                                        <input type="text" id="bfluxco-contact-name" name="bfluxco_contact_name" required class="form-input" maxlength="100" autocomplete="name" placeholder="<?php esc_attr_e('Your name', 'bfluxco'); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="bfluxco-contact-email"><?php esc_html_e('Email', 'bfluxco'); ?> *</label>
                                        <input type="email" id="bfluxco-contact-email" name="bfluxco_contact_email" required class="form-input" maxlength="254" autocomplete="email" placeholder="<?php esc_attr_e('you@company.com', 'bfluxco'); ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="bfluxco-contact-project-type"><?php esc_html_e('Project Type', 'bfluxco'); ?></label>
                                    <select id="bfluxco-contact-project-type" name="bfluxco_contact_project_type" class="form-select">
                                        <option value=""><?php esc_html_e('Select a project type', 'bfluxco'); ?></option>
                                        <option value="new-project"><?php esc_html_e('New Project', 'bfluxco'); ?></option>
                                        <option value="consultation"><?php esc_html_e('Consultation', 'bfluxco'); ?></option>
                                        <option value="partnership"><?php esc_html_e('Partnership', 'bfluxco'); ?></option>
                                        <option value="other"><?php esc_html_e('Other', 'bfluxco'); ?></option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="bfluxco-contact-subject"><?php esc_html_e('Subject', 'bfluxco'); ?></label>
                                    <input type="text" id="bfluxco-contact-subject" name="bfluxco_contact_subject" class="form-input" maxlength="200" placeholder="<?php esc_attr_e('What is this about?', 'bfluxco'); ?>">
                                </div>

                                <div class="form-group">
                                    <label for="bfluxco-contact-message"><?php esc_html_e('Message', 'bfluxco'); ?> *</label>
                                    <textarea id="bfluxco-contact-message" name="bfluxco_contact_message" rows="6" required class="form-textarea" maxlength="5000" placeholder="<?php esc_attr_e('Tell me about your project or idea...', 'bfluxco'); ?>"></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary" disabled title="<?php esc_attr_e('Contact form requires plugin setup', 'bfluxco'); ?>">
                                    <?php esc_html_e('Send Message', 'bfluxco'); ?>
                                </button>
                            </form>
                        <?php
                            endif;
                        endwhile;
                        ?>
                    </div>
                </div>

                <!-- Contact Info Column -->
                <div class="contact-info-column">
                    <div class="contact-section-header">
                        <h2><?php esc_html_e('Other Ways to Connect', 'bfluxco'); ?></h2>
                    </div>

                    <div class="contact-info-wrapper">

                        <!-- Social Card -->
                        <div class="contact-info-card">
                            <div class="contact-info-card-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path>
                                    <rect x="2" y="9" width="4" height="12"></rect>
                                    <circle cx="4" cy="4" r="2"></circle>
                                </svg>
                            </div>
                            <h3><?php esc_html_e('Social', 'bfluxco'); ?></h3>
                            <p><?php esc_html_e('Connect with me on:', 'bfluxco'); ?></p>
                            <div class="contact-social-links">
                                <a href="https://www.linkedin.com/company/big-freight-life-llc/?viewAsMember=true" target="_blank" rel="noopener noreferrer">LinkedIn</a>
                                <a href="https://medium.com/@bfluxco" target="_blank" rel="noopener noreferrer">Medium</a>
                            </div>
                        </div>

                        <!-- Response Time Card -->
                        <div class="contact-info-card">
                            <div class="contact-info-card-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                            </div>
                            <h3><?php esc_html_e('Response Time', 'bfluxco'); ?></h3>
                            <p>
                                <?php esc_html_e('I typically respond within 1-2 business days. For urgent matters, please indicate in your message subject.', 'bfluxco'); ?>
                            </p>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section><!-- .contact-form-section -->

</main><!-- #main-content -->

<?php
get_footer();
