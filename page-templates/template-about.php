<?php
/**
 * Template Name: About
 * Template Post Type: page
 *
 * This template displays the About overview page.
 * URL: /about
 *
 * HOW TO USE:
 * 1. Create a new page in WordPress called "About"
 * 2. Set the page slug to "about"
 * 3. In the Page Attributes section, select "About" as the template
 * 4. Publish the page
 *
 * @package BFLUXCO
 */

get_header();
?>

<main id="main-content" class="site-main about-page">

    <!-- Hero Section with Animated Graphics -->
    <section class="about-hero-section">
        <div class="about-hero-bg">
            <!-- Animated geometric shapes -->
            <div class="hero-shape hero-shape-1"></div>
            <div class="hero-shape hero-shape-2"></div>
            <div class="hero-shape hero-shape-3"></div>
            <div class="hero-shape hero-shape-4"></div>
            <div class="hero-shape hero-shape-5"></div>
            <!-- Grid pattern -->
            <div class="hero-grid"></div>
        </div>
        <div class="about-hero-overlay"></div>
        <div class="container about-hero-container">
            <div class="about-hero-content reveal-hero">
                <span class="about-hero-label"><?php esc_html_e('About', 'bfluxco'); ?></span>
                <h1 class="about-hero-title">
                    <?php esc_html_e('We design clarity', 'bfluxco'); ?>
                    <span class="about-hero-title-accent"><?php esc_html_e('into complexity.', 'bfluxco'); ?></span>
                </h1>
                <p class="about-hero-description reveal" data-delay="1">
                    <?php esc_html_e('Big Freight Life is a GenAI experience design company helping small and minority-owned businesses build intelligent systems they can trust.', 'bfluxco'); ?>
                </p>
            </div>
            <div class="about-hero-scroll reveal" data-delay="2">
                <span><?php esc_html_e('Scroll to explore', 'bfluxco'); ?></span>
                <div class="scroll-line"></div>
            </div>
        </div>
    </section><!-- Hero -->

    <!-- Introduction -->
    <section class="section section-reveal">
        <div class="container">
            <div class="max-w-3xl">
                <p class="text-xl leading-relaxed mb-6 reveal-text">
                    <?php esc_html_e('We help small and minority-owned businesses design intelligent systems—systems where human judgment, system behavior, and AI capabilities work together as complexity scales.', 'bfluxco'); ?>
                </p>
                <p class="text-gray-600 leading-relaxed reveal" data-delay="1">
                    <?php esc_html_e("As small teams adopt AI, they often encounter fragmented tools, evolving rules, and limited visibility into how decisions actually play out. Without the margin for error that scale provides, even small misalignments can have outsized consequences.", 'bfluxco'); ?>
                </p>
                <p class="text-gray-700 leading-relaxed mt-4 font-medium reveal" data-delay="2">
                    <?php esc_html_e("That's where our work begins.", 'bfluxco'); ?>
                </p>
            </div>
        </div>
    </section><!-- Introduction -->

    <!-- Our Perspective -->
    <section class="section bg-gray-50 section-reveal">
        <div class="container">
            <div class="max-w-3xl mx-auto">
                <h2 class="mb-6 reveal-text"><?php esc_html_e('Our Perspective', 'bfluxco'); ?></h2>
                <p class="text-gray-700 leading-relaxed mb-6 reveal" data-delay="1">
                    <?php esc_html_e('AI is often introduced as a feature. Design is often treated as decoration. In practice, this leads to automation layered onto systems that were never fully understood in the first place.', 'bfluxco'); ?>
                </p>
                <p class="text-gray-600 leading-relaxed reveal" data-delay="2">
                    <?php esc_html_e('As systems grow, cause and effect become harder to see. Speed increases, but shared understanding does not. When structure is missing, AI amplifies confusion instead of reducing it.', 'bfluxco'); ?>
                </p>
            </div>
        </div>
    </section><!-- Our Perspective -->

    <!-- What We Do Differently -->
    <section class="section section-reveal">
        <div class="container">
            <div class="grid grid-2 gap-12 items-center">
                <div class="about-approach-visual order-2-desktop reveal-scale">
                    <div class="approach-rings-wrapper">
                        <div class="approach-ring approach-ring-outer"></div>
                        <div class="approach-ring approach-ring-middle"></div>
                        <div class="approach-ring approach-ring-inner"></div>
                        <div class="approach-ring-core">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div>
                    <h2 class="mb-6 reveal-text"><?php esc_html_e('What We Do Differently', 'bfluxco'); ?></h2>
                    <p class="text-gray-700 leading-relaxed mb-6 reveal" data-delay="1">
                        <?php esc_html_e('We design intelligent systems around how decisions are made, not just how workflows are documented.', 'bfluxco'); ?>
                    </p>
                    <p class="text-gray-600 leading-relaxed mb-6 reveal" data-delay="2">
                        <?php esc_html_e('Before automation, we make system behavior understandable. Human judgment stays visible where it matters, and AI is treated as a participant in the system—not a replacement for thinking. Exceptions are not edge cases; they reveal how the system actually operates.', 'bfluxco'); ?>
                    </p>
                    <p class="text-gray-600 leading-relaxed reveal" data-delay="3">
                        <?php esc_html_e('Our work spans experience design, system architecture, and applied AI, with a single focus: helping teams build systems they can trust and evolve over time.', 'bfluxco'); ?>
                    </p>
                </div>
            </div>
        </div>
    </section><!-- What We Do Differently -->

    <!-- Who This Work Is For -->
    <section class="section bg-gray-50 section-reveal">
        <div class="container">
            <div class="max-w-3xl mx-auto">
                <h2 class="mb-6 reveal-text"><?php esc_html_e('Who This Work Is For', 'bfluxco'); ?></h2>
                <p class="text-gray-700 leading-relaxed mb-6 reveal" data-delay="1">
                    <?php esc_html_e('Big Freight Life works with small and minority-owned businesses operating in complex, real-world conditions—growing teams, constrained resources, and increasing operational demands.', 'bfluxco'); ?>
                </p>
                <p class="text-gray-600 leading-relaxed reveal" data-delay="2">
                    <?php esc_html_e('This work is for founders and leaders who want AI to support better decisions, not introduce new uncertainty.', 'bfluxco'); ?>
                </p>
            </div>
        </div>
    </section><!-- Who This Work Is For -->

    <!-- Meet the Founder -->
    <section class="section section-reveal">
        <div class="container">
            <div class="about-founder-grid">
                <div class="about-founder-portrait reveal-scale">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/ray-butler-profile.png'); ?>"
                         alt="<?php esc_attr_e('Ray Butler', 'bfluxco'); ?>"
                         class="about-founder-img">
                </div>
                <div class="about-founder-bio">
                    <span class="about-founder-label reveal" data-delay="1"><?php esc_html_e('Meet the Founder', 'bfluxco'); ?></span>
                    <h2 class="mb-2 reveal-text"><?php esc_html_e('Ray Butler', 'bfluxco'); ?></h2>
                    <p class="about-founder-role reveal" data-delay="1"><?php esc_html_e('GenAI Experience Architect', 'bfluxco'); ?></p>
                    <p class="text-gray-700 leading-relaxed mb-4 reveal" data-delay="2">
                        <?php esc_html_e('I design GenAI experiences by combining service design, UX generalist practice, and system architecture. My work focuses on how intelligent systems behave within real services—across workflows, roles, and decision points—not just how they appear on screen.', 'bfluxco'); ?>
                    </p>
                    <p class="text-gray-600 leading-relaxed mb-6 reveal" data-delay="3">
                        <?php esc_html_e('This includes shaping AI participation, defining human oversight, and ensuring experiences remain understandable and trustworthy as complexity grows.', 'bfluxco'); ?>
                    </p>
                    <a href="https://www.linkedin.com/in/braybutler/" class="btn btn-secondary reveal" data-delay="4" target="_blank" rel="noopener">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" style="margin-right: 8px; vertical-align: -3px;">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                        <?php esc_html_e('Connect on LinkedIn', 'bfluxco'); ?>
                    </a>
                </div>
            </div>
        </div>
    </section><!-- Meet the Founder -->

    <!-- Credentials Highlights -->
    <section class="section bg-gray-50 section-reveal">
        <div class="container">
            <div class="max-w-3xl mx-auto">
                <h2 class="text-center mb-8 reveal-text"><?php esc_html_e('Credentials', 'bfluxco'); ?></h2>
                <div class="credentials-grid">
                    <a href="https://www.credential.net/ac2075af-00de-4419-9840-35759ab5d09f" target="_blank" rel="noopener" class="credential-item reveal" data-delay="1">
                        <span class="credential-issuer"><?php esc_html_e('MIT CSAIL', 'bfluxco'); ?></span>
                        <span class="credential-title"><?php esc_html_e('Human-Computer Interaction for UX Design', 'bfluxco'); ?></span>
                    </a>
                    <div class="credential-item reveal" data-delay="2">
                        <span class="credential-issuer"><?php esc_html_e('IBM', 'bfluxco'); ?></span>
                        <span class="credential-title"><?php esc_html_e('AI Product Manager', 'bfluxco'); ?></span>
                    </div>
                    <div class="credential-item reveal" data-delay="3">
                        <span class="credential-issuer"><?php esc_html_e('Stanford Online', 'bfluxco'); ?></span>
                        <span class="credential-title"><?php esc_html_e('AI in Healthcare', 'bfluxco'); ?></span>
                    </div>
                    <div class="credential-item reveal" data-delay="4">
                        <span class="credential-issuer"><?php esc_html_e('Wharton (UPenn)', 'bfluxco'); ?></span>
                        <span class="credential-title"><?php esc_html_e('AI Strategy and Governance', 'bfluxco'); ?></span>
                    </div>
                    <div class="credential-item reveal" data-delay="5">
                        <span class="credential-issuer"><?php esc_html_e('CDI', 'bfluxco'); ?></span>
                        <span class="credential-title"><?php esc_html_e('Certified Conversation Designer', 'bfluxco'); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- Credentials Highlights -->

    <!-- Closing -->
    <section class="section section-lg about-closing-section section-reveal">
        <div class="container">
            <div class="max-w-3xl mx-auto text-center">
                <p class="text-2xl text-gray-300 leading-relaxed mb-4 reveal-text">
                    <?php esc_html_e('Complexity is unavoidable.', 'bfluxco'); ?>
                </p>
                <p class="text-3xl font-medium text-white reveal-hero">
                    <?php esc_html_e('Designing for it is a choice.', 'bfluxco'); ?>
                </p>
            </div>
        </div>
    </section><!-- Closing -->

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
