<?php
/**
 * Template Name: Contact
 * Template Post Type: page
 *
 * This template displays the Contact page.
 * URL: /contact
 *
 * HOW TO USE:
 * 1. Create a new page in WordPress called "Contact"
 * 2. Set the page slug to "contact"
 * 3. In the Page Attributes section, select "Contact" as the template
 * 4. Install a contact form plugin (like Contact Form 7 or WPForms)
 * 5. Add the form shortcode to the page content
 *
 * @package BFLUXCO
 */

get_header();
?>

<main id="main-content" class="site-main">

    <?php
    get_template_part('template-parts/page-header', null, array(
        'description' => __("Have a project in mind? Let's talk about how we can work together.", 'bfluxco'),
        'show_animations' => false,
        'use_excerpt' => true,
    ));
    ?>

    <!-- Contact Section -->
    <section class="section">
        <div class="container">
            <div class="grid grid-2 gap-8">

                <!-- Contact Form -->
                <div class="contact-form-wrapper">
                    <h2><?php esc_html_e('Send a Message', 'bfluxco'); ?></h2>

                    <?php
                    // Display page content (which should contain the contact form shortcode)
                    while (have_posts()) : the_post();
                        $content = get_the_content();
                        if (!empty($content)) :
                            the_content();
                        else :
                    ?>
                        <!-- Fallback HTML form if no content/plugin is set up -->
                        <form class="contact-form" action="#" method="post">
                            <p class="form-note text-gray-500 text-sm mb-4">
                                <?php esc_html_e('Add a contact form plugin and paste the shortcode in this page\'s content area.', 'bfluxco'); ?>
                            </p>

                            <div class="form-group mb-4">
                                <label for="contact-name"><?php esc_html_e('Name', 'bfluxco'); ?> *</label>
                                <input type="text" id="contact-name" name="name" required class="form-input">
                            </div>

                            <div class="form-group mb-4">
                                <label for="contact-email"><?php esc_html_e('Email', 'bfluxco'); ?> *</label>
                                <input type="email" id="contact-email" name="email" required class="form-input">
                            </div>

                            <div class="form-group mb-4">
                                <label for="contact-subject"><?php esc_html_e('Subject', 'bfluxco'); ?></label>
                                <input type="text" id="contact-subject" name="subject" class="form-input">
                            </div>

                            <div class="form-group mb-4">
                                <label for="contact-message"><?php esc_html_e('Message', 'bfluxco'); ?> *</label>
                                <textarea id="contact-message" name="message" rows="6" required class="form-textarea"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <?php esc_html_e('Send Message', 'bfluxco'); ?>
                            </button>
                        </form>
                    <?php
                        endif;
                    endwhile;
                    ?>
                </div>

                <!-- Contact Info -->
                <div class="contact-info">
                    <h2><?php esc_html_e('Other Ways to Connect', 'bfluxco'); ?></h2>

                    <div class="contact-methods">

                        <!-- Email -->
                        <div class="contact-method mb-6">
                            <h3 class="text-lg font-semibold mb-2"><?php esc_html_e('Email', 'bfluxco'); ?></h3>
                            <p class="text-gray-600">
                                <?php esc_html_e('For general inquiries:', 'bfluxco'); ?><br>
                                <a href="mailto:hello@bfluxco.com" class="link">hello@bfluxco.com</a>
                            </p>
                        </div>

                        <!-- Social -->
                        <div class="contact-method mb-6">
                            <h3 class="text-lg font-semibold mb-2"><?php esc_html_e('Social', 'bfluxco'); ?></h3>
                            <p class="text-gray-600">
                                <?php esc_html_e('Connect with me on:', 'bfluxco'); ?><br>
                                <a href="#" class="link" target="_blank" rel="noopener">LinkedIn</a>
                                <a href="#" class="link ml-4" target="_blank" rel="noopener">Twitter</a>
                            </p>
                        </div>

                        <!-- Response Time -->
                        <div class="contact-method mb-6">
                            <h3 class="text-lg font-semibold mb-2"><?php esc_html_e('Response Time', 'bfluxco'); ?></h3>
                            <p class="text-gray-600">
                                <?php esc_html_e('I typically respond within 1-2 business days. For urgent matters, please indicate in your message subject.', 'bfluxco'); ?>
                            </p>
                        </div>

                    </div>

                    <!-- FAQ Link -->
                    <div class="contact-faq mt-8 p-6" style="background-color: var(--bg-tertiary); border-radius: var(--radius-xl);">
                        <h3 class="text-lg font-semibold mb-2"><?php esc_html_e('Have Questions?', 'bfluxco'); ?></h3>
                        <p class="text-gray-600 mb-4">
                            <?php esc_html_e('Check out the support page for answers to common questions.', 'bfluxco'); ?>
                        </p>
                        <a href="<?php echo esc_url(home_url('/support')); ?>" class="btn btn-quad btn-sm">
                            <?php esc_html_e('Visit Support', 'bfluxco'); ?>
                        </a>
                    </div>

                </div>

            </div>
        </div>
    </section><!-- Contact Section -->

</main><!-- #main-content -->

<?php
get_footer();
