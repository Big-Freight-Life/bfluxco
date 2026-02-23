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

    <!-- About Options -->
    <section class="section bg-gray-50 section-reveal">
        <div class="container">
            <div class="grid grid-2 about-cards-grid">

                <!-- Meet Ray Butler -->
                <a href="<?php echo esc_url(home_url('/about/ray')); ?>" class="about-card card reveal" data-delay="1">
                    <div class="card-image about-card-image-ray">
                        <div class="about-card-icon">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                        </div>
                    </div>
                    <div class="card-content text-center">
                        <h2 class="card-title"><?php esc_html_e('Meet Ray Butler', 'bfluxco'); ?></h2>
                        <p class="card-description text-gray-600">
                            <?php esc_html_e('The person behind the work. Learn about my background, experience, and approach.', 'bfluxco'); ?>
                        </p>
                        <span class="btn btn-secondary"><?php esc_html_e('Learn More', 'bfluxco'); ?></span>
                    </div>
                </a>

                <!-- About Big Freight Life -->
                <a href="<?php echo esc_url(home_url('/about/bfl')); ?>" class="about-card card reveal" data-delay="2">
                    <div class="card-image about-card-image-bfl">
                        <div class="about-card-icon">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                                <rect x="2" y="3" width="20" height="14" rx="2"/>
                                <path d="M8 21h8"/>
                                <path d="M12 17v4"/>
                            </svg>
                        </div>
                    </div>
                    <div class="card-content text-center">
                        <h2 class="card-title"><?php esc_html_e('About Big Freight Life', 'bfluxco'); ?></h2>
                        <p class="card-description text-gray-600">
                            <?php esc_html_e('The company, its mission, and what we stand for.', 'bfluxco'); ?>
                        </p>
                        <span class="btn btn-secondary"><?php esc_html_e('Learn More', 'bfluxco'); ?></span>
                    </div>
                </a>

            </div>
        </div>
    </section><!-- About Options -->

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
