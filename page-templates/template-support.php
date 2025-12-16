<?php
/**
 * Template Name: Support
 * Template Post Type: page
 *
 * This template displays the Support page.
 * URL: /support
 *
 * HOW TO USE:
 * 1. Create a new page in WordPress called "Support"
 * 2. Set the page slug to "support"
 * 3. In the Page Attributes section, select "Support" as the template
 * 4. Add FAQs and support content as needed
 *
 * @package BFLUXCO
 */

get_header();
?>

<main id="main-content" class="site-main">

    <?php
    get_template_part('template-parts/page-header', null, array(
        'description' => __('Find answers to common questions and get the help you need.', 'bfluxco'),
        'show_animations' => false,
        'use_excerpt' => true,
    ));
    ?>

    <!-- FAQ Section -->
    <section class="section">
        <div class="container">
            <div class="max-w-3xl mx-auto">

                <h2 class="mb-6"><?php esc_html_e('Frequently Asked Questions', 'bfluxco'); ?></h2>

                <!-- FAQ Items -->
                <div class="faq-list">

                    <details class="faq-item mb-4 p-4 bg-gray-50 rounded-lg">
                        <summary class="faq-question font-semibold cursor-pointer">
                            <?php esc_html_e('What services do you offer?', 'bfluxco'); ?>
                        </summary>
                        <div class="faq-answer mt-4 text-gray-600">
                            <p><?php esc_html_e('I offer strategic design consulting, workshops, and products. This includes case study work, team facilitation workshops, and various tools and frameworks to help businesses solve complex challenges.', 'bfluxco'); ?></p>
                        </div>
                    </details>

                    <details class="faq-item mb-4 p-4 bg-gray-50 rounded-lg">
                        <summary class="faq-question font-semibold cursor-pointer">
                            <?php esc_html_e('How do I get started with a project?', 'bfluxco'); ?>
                        </summary>
                        <div class="faq-answer mt-4 text-gray-600">
                            <p><?php esc_html_e('The best way to get started is to reach out through the contact page. Share a brief overview of your project or challenge, and I\'ll get back to you within 1-2 business days to schedule an initial conversation.', 'bfluxco'); ?></p>
                        </div>
                    </details>

                    <details class="faq-item mb-4 p-4 bg-gray-50 rounded-lg">
                        <summary class="faq-question font-semibold cursor-pointer">
                            <?php esc_html_e('What is your typical project timeline?', 'bfluxco'); ?>
                        </summary>
                        <div class="faq-answer mt-4 text-gray-600">
                            <p><?php esc_html_e('Project timelines vary depending on scope and complexity. Workshops typically range from half-day to multi-day sessions. Consulting engagements can be a few weeks to several months. We\'ll discuss specific timelines during our initial conversation.', 'bfluxco'); ?></p>
                        </div>
                    </details>

                    <details class="faq-item mb-4 p-4 bg-gray-50 rounded-lg">
                        <summary class="faq-question font-semibold cursor-pointer">
                            <?php esc_html_e('Do you work with remote teams?', 'bfluxco'); ?>
                        </summary>
                        <div class="faq-answer mt-4 text-gray-600">
                            <p><?php esc_html_e('Yes! I work with teams both in-person and remotely. Many workshops and consulting sessions can be conducted virtually using video conferencing and collaborative tools.', 'bfluxco'); ?></p>
                        </div>
                    </details>

                    <details class="faq-item mb-4 p-4 bg-gray-50 rounded-lg">
                        <summary class="faq-question font-semibold cursor-pointer">
                            <?php esc_html_e('How can I stay updated on new content?', 'bfluxco'); ?>
                        </summary>
                        <div class="faq-answer mt-4 text-gray-600">
                            <p><?php esc_html_e('Follow me on social media or check back regularly for new case studies, workshop offerings, and products. You can also reach out via the contact page to be added to the mailing list.', 'bfluxco'); ?></p>
                        </div>
                    </details>

                </div>

            </div>
        </div>
    </section><!-- FAQ Section -->

    <!-- Page Content (if any) -->
    <?php
    while (have_posts()) : the_post();
        $content = get_the_content();
        if (!empty($content)) :
    ?>
        <section class="section page-content bg-gray-50">
            <div class="container">
                <div class="max-w-3xl mx-auto">
                    <?php the_content(); ?>
                </div>
            </div>
        </section>
    <?php
        endif;
    endwhile;
    ?>

    <!-- Still Need Help -->
    <section class="section bg-gray-50">
        <div class="container">
            <div class="max-w-3xl mx-auto text-center">
                <h2><?php esc_html_e('Still Have Questions?', 'bfluxco'); ?></h2>
                <p class="text-gray-600 mb-6">
                    <?php esc_html_e("Couldn't find what you're looking for? Feel free to reach out directly.", 'bfluxco'); ?>
                </p>
                <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-primary">
                    <?php esc_html_e('Contact Me', 'bfluxco'); ?>
                </a>
            </div>
        </div>
    </section><!-- Still Need Help -->

</main><!-- #main-content -->

<?php
get_footer();
