<?php
/**
 * Template Name: Clients
 * Template Post Type: page
 *
 * This template displays the "Who We Serve" page describing ideal clients
 * and the types of businesses Big Freight Life is built to help.
 * URL: /clients
 *
 * HOW TO USE:
 * 1. Create a new page in WordPress called "Clients"
 * 2. Set the page slug to "clients"
 * 3. In the Page Attributes section, select "Clients" as the template
 * 4. Publish the page
 *
 * @package BFLUXCO
 */

get_header();
?>

<main id="main-content" class="site-main clients-page">

    <!-- Hero Section -->
    <section class="clients-hero section-reveal">
        <div class="container">
            <div class="clients-hero-content reveal-hero">
                <span class="clients-hero-label"><?php esc_html_e('Who We Serve', 'bfluxco'); ?></span>
                <h1 class="clients-hero-title">
                    <?php esc_html_e('Built for teams', 'bfluxco'); ?>
                    <span class="clients-hero-accent"><?php esc_html_e('doing meaningful work.', 'bfluxco'); ?></span>
                </h1>
                <p class="clients-hero-description reveal" data-delay="1">
                    <?php esc_html_e('We work with small and minority-owned businesses navigating complexity, adopting AI, and building intelligent systems they can trust.', 'bfluxco'); ?>
                </p>
            </div>
        </div>
    </section><!-- Hero -->

    <!-- Who We Work With -->
    <section class="section section-reveal">
        <div class="container">
            <div class="max-w-3xl mx-auto">
                <h2 class="mb-6 reveal-text"><?php esc_html_e('Who We Work With', 'bfluxco'); ?></h2>
                <p class="text-gray-700 leading-relaxed mb-6 reveal" data-delay="1">
                    <?php esc_html_e('Big Freight Life is purpose-built for solopreneurs, founders, and operators running businesses in complex, real-world conditions. Whether you\'re a one-person operation or leading a growing team, constrained resources and increasing demands are the norm, not the exception.', 'bfluxco'); ?>
                </p>
                <p class="text-gray-600 leading-relaxed reveal" data-delay="2">
                    <?php esc_html_e('Our clients want AI to support better decisions, not introduce new uncertainty. They value clarity, structure, and systems designed to evolve alongside their business.', 'bfluxco'); ?>
                </p>
            </div>
        </div>
    </section><!-- Who We Work With -->

    <!-- Ideal Client Profiles -->
    <section class="section bg-gray-50 section-reveal">
        <div class="container">
            <h2 class="text-center mb-12 reveal-text"><?php esc_html_e('We\'re a Good Fit If You\'re...', 'bfluxco'); ?></h2>
            <div class="clients-profiles-grid">
                <div class="clients-profile-card reveal" data-delay="1">
                    <div class="clients-profile-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>
                    <h3><?php esc_html_e('A Solopreneur Wearing Every Hat', 'bfluxco'); ?></h3>
                    <p><?php esc_html_e('You\'re building alone and need intelligent systems that multiply your capacity without multiplying your complexity.', 'bfluxco'); ?></p>
                </div>

                <div class="clients-profile-card reveal" data-delay="2">
                    <div class="clients-profile-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                    </div>
                    <h3><?php esc_html_e('A Small Team Scaling Up', 'bfluxco'); ?></h3>
                    <p><?php esc_html_e('You\'re growing fast and need systems that scale with you, not bolt-on tools that create more work.', 'bfluxco'); ?></p>
                </div>

                <div class="clients-profile-card reveal" data-delay="3">
                    <div class="clients-profile-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="2" y1="12" x2="22" y2="12"/>
                            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                        </svg>
                    </div>
                    <h3><?php esc_html_e('Exploring AI Adoption', 'bfluxco'); ?></h3>
                    <p><?php esc_html_e('You know AI can help, but you need someone to separate signal from noise and design systems that actually fit your operations.', 'bfluxco'); ?></p>
                </div>

                <div class="clients-profile-card reveal" data-delay="4">
                    <div class="clients-profile-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                            <polyline points="22 4 12 14.01 9 11.01"/>
                        </svg>
                    </div>
                    <h3><?php esc_html_e('Minority- or Founder-Led', 'bfluxco'); ?></h3>
                    <p><?php esc_html_e('You operate with precision because the margin for error is smaller. You want a partner who understands that reality.', 'bfluxco'); ?></p>
                </div>
            </div>
        </div>
    </section><!-- Ideal Client Profiles -->

    <!-- CTA Section -->
    <section class="section clients-cta-section section-reveal">
        <div class="container">
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="text-2xl mb-4 reveal-text"><?php esc_html_e('Sound like you?', 'bfluxco'); ?></h2>
                <p class="text-gray-600 mb-8 reveal" data-delay="1">
                    <?php esc_html_e('Whether you\'re navigating AI adoption, redesigning a service, or building something new, we\'d love to hear from you.', 'bfluxco'); ?>
                </p>
                <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-primary reveal" data-delay="2">
                    <?php esc_html_e('Get in Touch', 'bfluxco'); ?>
                </a>
            </div>
        </div>
    </section><!-- CTA -->

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

</main><!-- #main-content -->

<?php
get_footer();
