<?php
/**
 * Template Name: About Person
 * Template Post Type: page
 *
 * This template is for personal bio pages like "Meet Ray Butler".
 * URL: /about/ray
 *
 * HOW TO USE:
 * 1. Create a new page in WordPress called "Meet Ray Butler"
 * 2. Set the page slug to "ray"
 * 3. Set the parent page to "About"
 * 4. In the Page Attributes section, select "About Person" as the template
 * 5. Set a featured image (this will be your profile photo)
 * 6. Add your bio content in the page editor
 *
 * @package BFLUXCO
 */

get_header();
?>

<!-- Sidebar Navigation (Fixed) -->
<nav class="about-sidebar">
    <div class="about-sidebar-inner">
        <button class="about-menu-item is-active" data-tab="about-ray" type="button">
            <svg class="about-menu-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
            </svg>
            <span class="about-menu-label"><?php esc_html_e('About Ray', 'bfluxco'); ?></span>
        </button>
        <button class="about-menu-item" data-tab="accomplishments" type="button">
            <svg class="about-menu-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="16" rx="2"></rect>
                <path d="M7 8h10"></path>
                <path d="M7 12h10"></path>
                <path d="M7 16h6"></path>
            </svg>
            <span class="about-menu-label"><?php esc_html_e('Accomplishments', 'bfluxco'); ?></span>
        </button>
        <button class="about-menu-item" data-tab="skills" type="button">
            <svg class="about-menu-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 2L2 7l10 5 10-5-10-5z"></path>
                <path d="M2 17l10 5 10-5"></path>
                <path d="M2 12l10 5 10-5"></path>
            </svg>
            <span class="about-menu-label"><?php esc_html_e('Skills', 'bfluxco'); ?></span>
        </button>
        <button class="about-menu-item" data-tab="bookshelf" type="button">
            <svg class="about-menu-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
            </svg>
            <span class="about-menu-label"><?php esc_html_e('Bookshelf', 'bfluxco'); ?></span>
        </button>
    </div>
</nav>

<main id="main-content" class="site-main about-page-layout">

    <?php while (have_posts()) : the_post(); ?>

    <!-- Page Content -->
    <div class="about-page-content">

        <article id="post-<?php the_ID(); ?>" <?php post_class('about-person'); ?>>

            <!-- Tab Content Panels -->
            <div class="about-tab-panels">
                <!-- About Ray Tab -->
                <div class="about-tab-panel is-active" id="about-ray">

                    <!-- Cinematic Hero Section -->
                    <section class="ray-hero">
                        <!-- Portrait Panel (Left) -->
                        <div class="ray-hero-portrait">
                            <div class="portrait-frame">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/ray-butler-profile.png'); ?>"
                                     alt="<?php esc_attr_e('Ray Butler', 'bfluxco'); ?>">
                            </div>
                            <div class="portrait-overlay"></div>
                            <canvas class="ray-ambient-canvas" id="ray-ambient"></canvas>
                        </div>

                        <!-- Content Panel (Right) -->
                        <div class="ray-hero-content">
                            <span class="ray-overline reveal-up" data-delay="1"><?php esc_html_e('GenAI Experience Architect', 'bfluxco'); ?></span>
                            <h1 class="ray-hero-title">
                                <span class="title-line reveal-up" data-delay="2"><?php esc_html_e('I design systems', 'bfluxco'); ?></span>
                                <span class="title-line reveal-up" data-delay="3"><?php esc_html_e('that design themselves.', 'bfluxco'); ?></span>
                            </h1>
                            <p class="ray-hero-statement reveal-up" data-delay="4">
                                <?php esc_html_e('My number one goal is to figure out your real problem.', 'bfluxco'); ?>
                            </p>
                            <div class="ray-hero-cta reveal-up" data-delay="5" style="margin-top: var(--spacing-8);">
                                <a href="https://www.linkedin.com/in/braybutler/" class="btn btn-secondary" target="_blank" rel="noopener" aria-label="LinkedIn Profile">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>

                    </section><!-- .ray-hero -->

                    <!-- Capabilities/Industries Carousel -->
                    <section class="logo-carousel-section">
                        <div class="logo-carousel">
                            <div class="logo-carousel-track">
                                <?php
                                $industries = bfluxco_get_industry_carousel_items();
                                // Output twice for seamless loop
                                for ($loop = 0; $loop < 2; $loop++) :
                                    foreach ($industries as $index => $industry) :
                                ?>
                                    <span class="logo-text logo-style-<?php echo ($index % 10) + 1; ?>"><?php echo esc_html($industry); ?></span>
                                <?php
                                    endforeach;
                                endfor;
                                ?>
                            </div>
                        </div>
                    </section><!-- .logo-carousel -->

                    <!-- Chapter 01: Background -->
                    <section class="narrative-chapter">
                        <div class="container">
                            <div class="chapter-divider">
                                <span class="chapter-number">01</span>
                                <h2 class="chapter-title reveal-up"><?php esc_html_e('Background', 'bfluxco'); ?></h2>
                            </div>
                            <div class="narrative-grid">
                                <div class="narrative-visual reveal-mask">
                                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/ray-working.jpg'); ?>"
                                         alt="<?php esc_attr_e('Ray Butler at work', 'bfluxco'); ?>"
                                         onerror="this.src='<?php echo esc_url(get_template_directory_uri() . '/assets/images/placeholder-portrait.jpg'); ?>'">
                                </div>
                                <div class="narrative-text reveal-up" data-delay="1">
                                    <p class="lead-paragraph"><?php esc_html_e('I design GenAI experiences by combining service design, UX generalist practice, and system architecture.', 'bfluxco'); ?></p>
                                    <p><?php esc_html_e('My work focuses on how intelligent systems behave within real services—across workflows, roles, and decision points—not just how they appear on screen.', 'bfluxco'); ?></p>
                                    <p><?php esc_html_e('This includes shaping AI participation, defining human oversight, and ensuring experiences remain understandable and trustworthy as complexity grows.', 'bfluxco'); ?></p>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Pull Quote Break -->
                    <section class="pullquote-break">
                        <div class="container">
                            <blockquote class="cinematic-quote reveal-scale">
                                <p><?php esc_html_e('"I design systems that support better decisions, not just faster ones."', 'bfluxco'); ?></p>
                            </blockquote>
                        </div>
                    </section>

                    <!-- Chapter 02: Experience -->
                    <section class="narrative-chapter">
                        <div class="container">
                            <div class="chapter-divider">
                                <span class="chapter-number">02</span>
                                <h2 class="chapter-title reveal-up"><?php esc_html_e('Experience', 'bfluxco'); ?></h2>
                            </div>
                            <div class="narrative-grid">
                                <div class="narrative-visual reveal-mask-right">
                                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/bfl-tractor-trailer.jpg'); ?>"
                                         alt="<?php esc_attr_e('BFL Freight Lines tractor trailer', 'bfluxco'); ?>">
                                </div>
                                <div class="narrative-text reveal-up" data-delay="1">
                                    <p class="lead-paragraph"><?php esc_html_e('I\'ve worked on GenAI-enabled and enterprise systems where decisions are distributed, exceptions are common, and outcomes compound over time.', 'bfluxco'); ?></p>
                                    <p><?php esc_html_e('My experience includes collaborating with product, engineering, operations, and leadership teams to design AI-assisted workflows with clear human oversight.', 'bfluxco'); ?></p>
                                    <p><?php esc_html_e('The work often sits between strategy and delivery—connecting intent to implementation while staying grounded in operational reality.', 'bfluxco'); ?></p>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Pull Quote Break -->
                    <section class="pullquote-break">
                        <div class="container">
                            <blockquote class="cinematic-quote reveal-scale">
                                <p><?php esc_html_e('"AI should augment judgment, not replace it. Automation should earn its place."', 'bfluxco'); ?></p>
                            </blockquote>
                        </div>
                    </section>

                    <!-- Chapter 03: Approach -->
                    <section class="narrative-chapter">
                        <div class="container">
                            <div class="chapter-divider">
                                <span class="chapter-number">03</span>
                                <h2 class="chapter-title reveal-up"><?php esc_html_e('Approach', 'bfluxco'); ?></h2>
                            </div>
                            <div class="narrative-grid">
                                <div class="narrative-visual reveal-mask">
                                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/methodology-hero.jpg'); ?>"
                                         alt="<?php esc_attr_e('Design methodology', 'bfluxco'); ?>"
                                         onerror="this.src='<?php echo esc_url(get_template_directory_uri() . '/assets/images/placeholder-work.jpg'); ?>'">
                                </div>
                                <div class="narrative-text reveal-up" data-delay="1">
                                    <p class="lead-paragraph"><?php esc_html_e('GenAI experiences require more than good interfaces—they require disciplined system design.', 'bfluxco'); ?></p>
                                    <p><?php esc_html_e('My approach focuses on understanding system behavior before introducing intelligence. That means identifying decision points, defining where AI should participate, and designing for confidence, override, and accountability.', 'bfluxco'); ?></p>
                                    <p><?php esc_html_e('This allows teams to move forward with intention instead of reacting to downstream consequences.', 'bfluxco'); ?></p>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Enhanced Expertise Section -->
                    <section class="about-skills section">
                        <div class="container">
                            <header class="section-header text-center mb-12">
                                <span class="ray-overline reveal-up"><?php esc_html_e('Areas of Focus', 'bfluxco'); ?></span>
                                <h2 class="reveal-up" data-delay="1"><?php esc_html_e('Where I create impact', 'bfluxco'); ?></h2>
                            </header>

                            <div class="expertise-showcase">
                                <!-- Strategy Card -->
                                <article class="expertise-item reveal-up" data-delay="2">
                                    <div class="expertise-item-front">
                                        <div class="expertise-icon-large">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <line x1="2" y1="12" x2="22" y2="12"></line>
                                                <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                                            </svg>
                                        </div>
                                        <h3><?php esc_html_e('Strategy', 'bfluxco'); ?></h3>
                                        <span class="expertise-tagline"><?php esc_html_e('Vision to Execution', 'bfluxco'); ?></span>
                                    </div>
                                    <div class="expertise-item-back">
                                        <p><?php esc_html_e('Clarifying where GenAI creates real value. I help teams define use cases, constraints, and success criteria before committing to models or tooling.', 'bfluxco'); ?></p>
                                        <ul class="expertise-skills">
                                            <li><?php esc_html_e('Product Strategy', 'bfluxco'); ?></li>
                                            <li><?php esc_html_e('Roadmap Development', 'bfluxco'); ?></li>
                                            <li><?php esc_html_e('Stakeholder Alignment', 'bfluxco'); ?></li>
                                        </ul>
                                    </div>
                                </article>

                                <!-- Facilitation Card -->
                                <article class="expertise-item reveal-up" data-delay="3">
                                    <div class="expertise-item-front">
                                        <div class="expertise-icon-large">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="9" cy="7" r="4"></circle>
                                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                            </svg>
                                        </div>
                                        <h3><?php esc_html_e('Facilitation', 'bfluxco'); ?></h3>
                                        <span class="expertise-tagline"><?php esc_html_e('Aligning Teams', 'bfluxco'); ?></span>
                                    </div>
                                    <div class="expertise-item-back">
                                        <p><?php esc_html_e('Aligning people around intelligent systems. I facilitate cross-functional conversations that surface assumptions and establish shared understanding.', 'bfluxco'); ?></p>
                                        <ul class="expertise-skills">
                                            <li><?php esc_html_e('Workshop Design', 'bfluxco'); ?></li>
                                            <li><?php esc_html_e('Design Sprints', 'bfluxco'); ?></li>
                                            <li><?php esc_html_e('Consensus Building', 'bfluxco'); ?></li>
                                        </ul>
                                    </div>
                                </article>

                                <!-- Design Card -->
                                <article class="expertise-item reveal-up" data-delay="4">
                                    <div class="expertise-item-front">
                                        <div class="expertise-icon-large">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                                <line x1="3" y1="9" x2="21" y2="9"></line>
                                                <line x1="9" y1="21" x2="9" y2="9"></line>
                                            </svg>
                                        </div>
                                        <h3><?php esc_html_e('Design', 'bfluxco'); ?></h3>
                                        <span class="expertise-tagline"><?php esc_html_e('End-to-End Experience', 'bfluxco'); ?></span>
                                    </div>
                                    <div class="expertise-item-back">
                                        <p><?php esc_html_e('GenAI experience and service design, from research to deployment. This includes service blueprints, interaction models, and AI decision flows.', 'bfluxco'); ?></p>
                                        <ul class="expertise-skills">
                                            <li><?php esc_html_e('Service Design', 'bfluxco'); ?></li>
                                            <li><?php esc_html_e('UX Architecture', 'bfluxco'); ?></li>
                                            <li><?php esc_html_e('AI Workflows', 'bfluxco'); ?></li>
                                        </ul>
                                    </div>
                                </article>

                                <!-- Execution Card -->
                                <article class="expertise-item reveal-up" data-delay="5">
                                    <div class="expertise-item-front">
                                        <div class="expertise-icon-large">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                            </svg>
                                        </div>
                                        <h3><?php esc_html_e('Execution', 'bfluxco'); ?></h3>
                                        <span class="expertise-tagline"><?php esc_html_e('Concept to Reality', 'bfluxco'); ?></span>
                                    </div>
                                    <div class="expertise-item-back">
                                        <p><?php esc_html_e('From concept to operational reality. I stay close to implementation to ensure designs remain usable, trustworthy, and grounded once deployed.', 'bfluxco'); ?></p>
                                        <ul class="expertise-skills">
                                            <li><?php esc_html_e('Implementation', 'bfluxco'); ?></li>
                                            <li><?php esc_html_e('Quality Assurance', 'bfluxco'); ?></li>
                                            <li><?php esc_html_e('Iteration', 'bfluxco'); ?></li>
                                        </ul>
                                    </div>
                                </article>
                            </div>
                        </div>
                    </section><!-- .about-skills -->

                    <!-- Capabilities Section -->
                    <section class="section transform-capabilities">
                        <div class="container">
                            <header class="transform-capabilities-header">
                                <span class="section-label reveal-text"><?php esc_html_e('Capabilities', 'bfluxco'); ?></span>
                                <h2 class="transform-capabilities-title reveal-text" data-delay="1">
                                    <?php esc_html_e('What we bring to the work', 'bfluxco'); ?>
                                </h2>
                                <p class="transform-capabilities-intro reveal-text" data-delay="2">
                                    <?php esc_html_e('Transformation draws on deep expertise across disciplines. These are the capabilities we apply—through workshops, coaching, and embedded partnership—to help teams build lasting strength.', 'bfluxco'); ?>
                                </p>
                            </header>

                            <div class="transform-capabilities-grid">
                                <a href="<?php echo esc_url(home_url('/services/experience-design')); ?>" class="transform-capability-link reveal-up" data-delay="1">
                                    <div class="transform-capability-icon">
                                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                                            <circle cx="8.5" cy="8.5" r="1.5"/>
                                            <polyline points="21 15 16 10 5 21"/>
                                        </svg>
                                    </div>
                                    <div class="transform-capability-content">
                                        <h3 class="transform-capability-title"><?php esc_html_e('Experience Design', 'bfluxco'); ?></h3>
                                        <p class="transform-capability-desc"><?php esc_html_e('End-to-end design that transforms how customers interact with your brand.', 'bfluxco'); ?></p>
                                    </div>
                                    <span class="transform-capability-arrow">&rarr;</span>
                                </a>

                                <a href="<?php echo esc_url(home_url('/services/gen-ai-architecture')); ?>" class="transform-capability-link reveal-up" data-delay="2">
                                    <div class="transform-capability-icon">
                                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                            <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                                            <path d="M2 17l10 5 10-5"/>
                                            <path d="M2 12l10 5 10-5"/>
                                        </svg>
                                    </div>
                                    <div class="transform-capability-content">
                                        <h3 class="transform-capability-title"><?php esc_html_e('Gen AI Architecture', 'bfluxco'); ?></h3>
                                        <p class="transform-capability-desc"><?php esc_html_e('Strategic AI implementation that integrates meaningfully into products and workflows.', 'bfluxco'); ?></p>
                                    </div>
                                    <span class="transform-capability-arrow">&rarr;</span>
                                </a>

                                <a href="<?php echo esc_url(home_url('/services/customer-research')); ?>" class="transform-capability-link reveal-up" data-delay="3">
                                    <div class="transform-capability-icon">
                                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                            <circle cx="11" cy="11" r="8"/>
                                            <path d="M21 21l-4.35-4.35"/>
                                            <path d="M11 8v6"/>
                                            <path d="M8 11h6"/>
                                        </svg>
                                    </div>
                                    <div class="transform-capability-content">
                                        <h3 class="transform-capability-title"><?php esc_html_e('Customer Research', 'bfluxco'); ?></h3>
                                        <p class="transform-capability-desc"><?php esc_html_e('Deep insights through qualitative and quantitative research that inform strategic decisions.', 'bfluxco'); ?></p>
                                    </div>
                                    <span class="transform-capability-arrow">&rarr;</span>
                                </a>

                                <a href="<?php echo esc_url(home_url('/services/digital-twins')); ?>" class="transform-capability-link reveal-up" data-delay="4">
                                    <div class="transform-capability-icon">
                                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"/>
                                            <path d="M8 21h8"/>
                                            <path d="M12 17v4"/>
                                        </svg>
                                    </div>
                                    <div class="transform-capability-content">
                                        <h3 class="transform-capability-title"><?php esc_html_e('Digital Twins', 'bfluxco'); ?></h3>
                                        <p class="transform-capability-desc"><?php esc_html_e('Virtual replicas that enable simulation, monitoring, and optimization at scale.', 'bfluxco'); ?></p>
                                    </div>
                                    <span class="transform-capability-arrow">&rarr;</span>
                                </a>

                                <a href="<?php echo esc_url(home_url('/services/conversation-design')); ?>" class="transform-capability-link reveal-up" data-delay="5">
                                    <div class="transform-capability-icon">
                                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                                        </svg>
                                    </div>
                                    <div class="transform-capability-content">
                                        <h3 class="transform-capability-title"><?php esc_html_e('Conversation Design', 'bfluxco'); ?></h3>
                                        <p class="transform-capability-desc"><?php esc_html_e('Human-centered conversational experiences for chatbots, voice assistants, and AI interfaces.', 'bfluxco'); ?></p>
                                    </div>
                                    <span class="transform-capability-arrow">&rarr;</span>
                                </a>
                            </div>
                        </div>
                    </section><!-- .transform-capabilities -->
                </div>

                <!-- Accomplishments Tab -->
                <div class="about-tab-panel" id="accomplishments">
                    <section class="section">
                        <div class="container">
                            <header class="section-header mb-12">
                                <h2><?php esc_html_e('Accomplishments', 'bfluxco'); ?></h2>
                                <p class="text-muted"><?php esc_html_e('Professional certifications and continuous learning.', 'bfluxco'); ?></p>
                            </header>

                            <div class="cert-gallery">
                                <?php
                                $cert_images_path = get_template_directory_uri() . '/assets/images/certificates/';
                                $cert_pdfs_path = get_template_directory_uri() . '/assets/certificates/';

                                $certificates = array(
                                    array(
                                        'title' => 'Human-Computer Interaction for UX Design',
                                        'issuer' => 'MIT CSAIL',
                                        'year' => '2024',
                                        'courses' => '',
                                        'color' => '#A31F34',
                                        'url' => 'https://www.credential.net/ac2075af-00de-4419-9840-35759ab5d09f',
                                        'image' => 'https://pdf.ms.credential.net/v2/certificate/image?env=production&credential=4d7l90hb&variant=medium',
                                    ),
                                    array(
                                        'title' => 'IBM AI Product Manager',
                                        'issuer' => 'IBM',
                                        'year' => '2025',
                                        'courses' => '10 courses',
                                        'color' => '#0530AD',
                                        'url' => $cert_pdfs_path . 'coursera-ibm-ai-product-manager.pdf',
                                        'image' => $cert_images_path . 'coursera-ibm-ai-product-manager.png',
                                    ),
                                    array(
                                        'title' => 'AI in Healthcare',
                                        'issuer' => 'Stanford Online',
                                        'year' => '2025',
                                        'courses' => '5 courses',
                                        'color' => '#8C1515',
                                        'url' => $cert_pdfs_path . 'coursera-stanford-ai-healthcare.pdf',
                                        'image' => $cert_images_path . 'coursera-stanford-ai-healthcare.png',
                                    ),
                                    array(
                                        'title' => 'AI Series: Introduction to Clinical Data',
                                        'issuer' => 'Stanford Medicine',
                                        'year' => '2025',
                                        'courses' => '11 hours',
                                        'color' => '#8C1515',
                                        'url' => $cert_pdfs_path . 'stanford-ai-clinical-data.pdf',
                                        'image' => $cert_images_path . 'stanford-ai-clinical-data.png',
                                    ),
                                    array(
                                        'title' => 'AI For Business',
                                        'issuer' => 'University of Pennsylvania',
                                        'year' => '2025',
                                        'courses' => '4 courses',
                                        'color' => '#011F5B',
                                        'url' => $cert_pdfs_path . 'coursera-upenn-ai-business.pdf',
                                        'image' => $cert_images_path . 'coursera-upenn-ai-business.png',
                                    ),
                                    array(
                                        'title' => 'AI Strategy and Governance',
                                        'issuer' => 'Wharton (UPenn)',
                                        'year' => '2025',
                                        'courses' => '',
                                        'color' => '#011F5B',
                                        'url' => $cert_pdfs_path . 'coursera-v3wytm104ejl.pdf',
                                        'image' => $cert_images_path . 'coursera-v3wytm104ejl.png',
                                    ),
                                    array(
                                        'title' => 'Intro to Generative AI',
                                        'issuer' => 'Google Cloud',
                                        'year' => '2025',
                                        'courses' => '4 courses',
                                        'color' => '#4285F4',
                                        'url' => $cert_pdfs_path . 'coursera-google-genai.pdf',
                                        'image' => $cert_images_path . 'coursera-google-genai.png',
                                    ),
                                    array(
                                        'title' => 'Create a High-Performing Team',
                                        'issuer' => 'Google',
                                        'year' => '2025',
                                        'courses' => '',
                                        'color' => '#4285F4',
                                        'url' => $cert_pdfs_path . 'coursera-google-high-performing-team.pdf',
                                        'image' => $cert_images_path . 'coursera-google-high-performing-team.png',
                                    ),
                                    array(
                                        'title' => 'GenAI for HR Professionals',
                                        'issuer' => 'IBM',
                                        'year' => '2025',
                                        'courses' => '3 courses',
                                        'color' => '#0530AD',
                                        'url' => $cert_pdfs_path . 'coursera-genai-hr.pdf',
                                        'image' => $cert_images_path . 'coursera-genai-hr.png',
                                    ),
                                    array(
                                        'title' => 'Certified Conversation Designer',
                                        'issuer' => 'Conversation Design Institute',
                                        'year' => '2023',
                                        'courses' => '',
                                        'color' => '#1E3A5F',
                                        'url' => $cert_pdfs_path . 'certified-conversation-designer.pdf',
                                        'image' => $cert_images_path . 'certified-conversation-designer.png',
                                    ),
                                    array(
                                        'title' => 'AI Product Design Bootcamp',
                                        'issuer' => 'STRAT Events',
                                        'year' => '2025',
                                        'courses' => '',
                                        'color' => '#E85D04',
                                        'url' => $cert_pdfs_path . 'ai-product-design-bootcamp.pdf',
                                        'image' => $cert_images_path . 'ai-product-design-bootcamp.png',
                                    ),
                                    array(
                                        'title' => 'Product Management: Foundations & Stakeholder Collaboration',
                                        'issuer' => 'SkillUp',
                                        'year' => '2025',
                                        'courses' => '',
                                        'color' => '#2D3748',
                                        'url' => $cert_pdfs_path . 'coursera-apr9rcfuilx8.pdf',
                                        'image' => $cert_images_path . 'coursera-apr9rcfuilx8.png',
                                    ),
                                    array(
                                        'title' => 'Generative AI: Foundation Models and Platforms',
                                        'issuer' => 'IBM',
                                        'year' => '2025',
                                        'courses' => '',
                                        'color' => '#0530AD',
                                        'url' => $cert_pdfs_path . 'coursera-hx1qy3w9g29m.pdf',
                                        'image' => $cert_images_path . 'coursera-hx1qy3w9g29m.png',
                                    ),
                                    array(
                                        'title' => 'Product Management: Building AI-Powered Products',
                                        'issuer' => 'SkillUp',
                                        'year' => '2025',
                                        'courses' => '',
                                        'color' => '#2D3748',
                                        'url' => $cert_pdfs_path . 'coursera-sbt04zdrara9.pdf',
                                        'image' => $cert_images_path . 'coursera-sbt04zdrara9.png',
                                    ),
                                    array(
                                        'title' => 'Product Management: Developing and Delivering a New Product',
                                        'issuer' => 'SkillUp',
                                        'year' => '2025',
                                        'courses' => '',
                                        'color' => '#2D3748',
                                        'url' => $cert_pdfs_path . 'coursera-73mdktmbhcts.pdf',
                                        'image' => $cert_images_path . 'coursera-73mdktmbhcts.png',
                                    ),
                                    array(
                                        'title' => 'Product Management: Initial Product Strategy and Plan',
                                        'issuer' => 'SkillUp',
                                        'year' => '2025',
                                        'courses' => '',
                                        'color' => '#2D3748',
                                        'url' => $cert_pdfs_path . 'coursera-88lfznmzv6bw.pdf',
                                        'image' => $cert_images_path . 'coursera-88lfznmzv6bw.png',
                                    ),
                                    array(
                                        'title' => 'AI Applications in People Management',
                                        'issuer' => 'Wharton (UPenn)',
                                        'year' => '2025',
                                        'courses' => '',
                                        'color' => '#011F5B',
                                        'url' => $cert_pdfs_path . 'coursera-fvacvi3zlj67.pdf',
                                        'image' => $cert_images_path . 'coursera-fvacvi3zlj67.png',
                                    ),
                                    array(
                                        'title' => 'AI Applications in Marketing and Finance',
                                        'issuer' => 'Wharton (UPenn)',
                                        'year' => '2025',
                                        'courses' => '',
                                        'color' => '#011F5B',
                                        'url' => $cert_pdfs_path . 'coursera-4xazsdlycavm.pdf',
                                        'image' => $cert_images_path . 'coursera-4xazsdlycavm.png',
                                    ),
                                    array(
                                        'title' => 'Responsible AI: Applying AI Principles with Google Cloud',
                                        'issuer' => 'Google Cloud',
                                        'year' => '2025',
                                        'courses' => '',
                                        'color' => '#4285F4',
                                        'url' => $cert_pdfs_path . 'coursera-eyz8scohpvvh.pdf',
                                        'image' => $cert_images_path . 'coursera-eyz8scohpvvh.png',
                                    ),
                                );

                                foreach ($certificates as $index => $cert) :
                                ?>
                                <a href="<?php echo esc_url($cert['url']); ?>"
                                   target="_blank"
                                   rel="noopener"
                                   class="cert-card reveal-up"
                                   data-delay="<?php echo $index; ?>"
                                   style="--cert-color: <?php echo esc_attr($cert['color']); ?>">
                                    <div class="cert-card-image">
                                        <img src="<?php echo esc_url($cert['image']); ?>" alt="<?php echo esc_attr($cert['title']); ?>">
                                        <div class="cert-card-image-overlay">
                                            <span class="cert-card-badge"><?php echo esc_html($cert['year']); ?></span>
                                        </div>
                                    </div>
                                    <div class="cert-card-content">
                                        <h3 class="cert-card-title"><?php echo esc_html($cert['title']); ?></h3>
                                        <p class="cert-card-issuer"><?php echo esc_html($cert['issuer']); ?></p>
                                        <?php if (!empty($cert['courses'])) : ?>
                                        <span class="cert-card-courses"><?php echo esc_html($cert['courses']); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="cert-card-footer">
                                        <span class="cert-card-view">View Certificate</span>
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M7 17L17 7M17 7H7M17 7V17"/>
                                        </svg>
                                    </div>
                                </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </section>
                </div>

                <!-- Skills Tab -->
                <div class="about-tab-panel" id="skills">
                    <section class="section">
                        <div class="container">
                            <header class="section-header mb-12">
                                <h2><?php esc_html_e('Skills', 'bfluxco'); ?></h2>
                                <p class="text-muted"><?php esc_html_e('Tools, technologies, and methodologies I work with.', 'bfluxco'); ?></p>
                            </header>

                            <!-- Design Skills -->
                            <div class="skills-category mb-12">
                                <h3 class="skills-category-title mb-6"><?php esc_html_e('Design', 'bfluxco'); ?></h3>
                                <div class="skills-grid">
                                    <span class="skill-tag">Figma</span>
                                    <span class="skill-tag">Sketch</span>
                                    <span class="skill-tag">Adobe XD</span>
                                    <span class="skill-tag">Prototyping</span>
                                    <span class="skill-tag">Wireframing</span>
                                    <span class="skill-tag">Design Systems</span>
                                    <span class="skill-tag">User Research</span>
                                    <span class="skill-tag">Usability Testing</span>
                                    <span class="skill-tag">Information Architecture</span>
                                    <span class="skill-tag">Interaction Design</span>
                                </div>
                            </div>

                            <!-- Development Skills -->
                            <div class="skills-category mb-12">
                                <h3 class="skills-category-title mb-6"><?php esc_html_e('Development', 'bfluxco'); ?></h3>
                                <div class="skills-grid">
                                    <span class="skill-tag">HTML/CSS</span>
                                    <span class="skill-tag">JavaScript</span>
                                    <span class="skill-tag">React</span>
                                    <span class="skill-tag">WordPress</span>
                                    <span class="skill-tag">PHP</span>
                                    <span class="skill-tag">Git</span>
                                    <span class="skill-tag">REST APIs</span>
                                    <span class="skill-tag">Responsive Design</span>
                                </div>
                            </div>

                            <!-- AI & Technology -->
                            <div class="skills-category mb-12">
                                <h3 class="skills-category-title mb-6"><?php esc_html_e('AI & Technology', 'bfluxco'); ?></h3>
                                <div class="skills-grid">
                                    <span class="skill-tag">GenAI Systems</span>
                                    <span class="skill-tag">Prompt Engineering</span>
                                    <span class="skill-tag">AI UX Design</span>
                                    <span class="skill-tag">LLM Integration</span>
                                    <span class="skill-tag">Conversational AI</span>
                                    <span class="skill-tag">AI Ethics</span>
                                </div>
                            </div>

                            <!-- Strategy & Process -->
                            <div class="skills-category">
                                <h3 class="skills-category-title mb-6"><?php esc_html_e('Strategy & Process', 'bfluxco'); ?></h3>
                                <div class="skills-grid">
                                    <span class="skill-tag">Service Design</span>
                                    <span class="skill-tag">Design Thinking</span>
                                    <span class="skill-tag">Workshop Facilitation</span>
                                    <span class="skill-tag">Stakeholder Management</span>
                                    <span class="skill-tag">Agile/Scrum</span>
                                    <span class="skill-tag">Product Strategy</span>
                                    <span class="skill-tag">Journey Mapping</span>
                                    <span class="skill-tag">Systems Thinking</span>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <!-- Bookshelf Tab -->
                <div class="about-tab-panel" id="bookshelf">
                    <section class="section bookshelf-section">
                        <div class="container">
                            <header class="section-header mb-8">
                                <h2><?php esc_html_e('My Bookshelf', 'bfluxco'); ?></h2>
                                <p class="text-muted"><?php esc_html_e('Books that have shaped my thinking and practice.', 'bfluxco'); ?></p>
                            </header>

                            <?php
                            // Book data organized by category with Open Library cover URLs
                            $book_categories = array(
                                'design' => array(
                                    'title' => 'Design & UX',
                                    'books' => array(
                                        array('title' => 'The Design of Everyday Things', 'author' => 'Don Norman', 'color' => '#1a1a1a', 'cover' => 'https://covers.openlibrary.org/b/isbn/9780465050659-L.jpg'),
                                        array('title' => 'Don\'t Make Me Think', 'author' => 'Steve Krug', 'color' => '#f59e0b', 'cover' => 'https://covers.openlibrary.org/b/isbn/9780321965516-L.jpg'),
                                        array('title' => 'Articulating Design Decisions', 'author' => 'Tom Greever', 'color' => '#14b8a6', 'cover' => 'https://covers.openlibrary.org/b/isbn/9781491921562-L.jpg'),
                                        array('title' => 'Creative Confidence', 'author' => 'Tom & David Kelley', 'color' => '#ef4444', 'cover' => 'https://covers.openlibrary.org/b/isbn/9780385349369-L.jpg'),
                                        array('title' => 'Inspired', 'author' => 'Marty Cagan', 'color' => '#3b82f6', 'cover' => 'https://covers.openlibrary.org/b/isbn/9781119387503-L.jpg'),
                                        array('title' => 'Refactoring UI', 'author' => 'Adam Wathan & Steve Schoger', 'color' => '#6366f1', 'cover' => 'https://covers.openlibrary.org/b/isbn/9780999773307-L.jpg'),
                                        array('title' => 'About Face', 'author' => 'Alan Cooper', 'color' => '#0ea5e9', 'cover' => 'https://covers.openlibrary.org/b/isbn/9781118766576-L.jpg'),
                                        array('title' => 'Laws of UX', 'author' => 'Jon Yablonski', 'color' => '#84cc16', 'cover' => 'https://covers.openlibrary.org/b/isbn/9781492055310-L.jpg'),
                                        array('title' => 'Designing Interfaces', 'author' => 'Jenifer Tidwell', 'color' => '#a855f7', 'cover' => 'https://covers.openlibrary.org/b/isbn/9781492051961-L.jpg'),
                                        array('title' => 'Designing Connected Products', 'author' => 'Claire Rowland et al.', 'color' => '#6b7280', 'cover' => 'https://covers.openlibrary.org/b/isbn/9781449372569-L.jpg'),
                                        array('title' => 'Design for Care', 'author' => 'Peter Jones', 'color' => '#ef4444', 'cover' => 'https://covers.openlibrary.org/b/isbn/9781933820231-L.jpg'),
                                        array('title' => 'Experience Design', 'author' => 'Patrick Newbery & Kevin Farnham', 'color' => '#dc2626', 'cover' => 'https://covers.openlibrary.org/b/isbn/9780470479612-L.jpg'),
                                        array('title' => 'Designing Human-Centric AI Experiences', 'author' => 'Akshay Kore', 'color' => '#1e3a5f', 'cover' => 'https://covers.openlibrary.org/b/isbn/9781484280874-L.jpg'),
                                        array('title' => 'A Project Guide to UX Design', 'author' => 'Russ Unger & Carolyn Chandler', 'color' => '#0891b2', 'cover' => 'https://covers.openlibrary.org/b/isbn/9780321815385-L.jpg'),
                                        array('title' => 'Flow', 'author' => 'Mihaly Csikszentmihalyi', 'color' => '#3b82f6', 'cover' => 'https://covers.openlibrary.org/b/isbn/9780061339202-L.jpg'),
                                        array('title' => 'Design Thinking', 'author' => 'Tim Brown', 'color' => '#f59e0b', 'cover' => 'https://covers.openlibrary.org/b/isbn/9780062856623-L.jpg'),
                                        array('title' => 'Forms that Work', 'author' => 'Caroline Jarrett & Gerry Gaffney', 'color' => '#0ea5e9', 'cover' => 'https://covers.openlibrary.org/b/isbn/9781558607101-L.jpg'),
                                        array('title' => 'The UX Book', 'author' => 'Rex Hartson & Pardha S. Pyla', 'color' => '#1e3a5f', 'cover' => 'https://covers.openlibrary.org/b/isbn/9780128053423-L.jpg'),
                                        array('title' => 'Information Architecture', 'author' => 'Christina Wodtke & Austin Govella', 'color' => '#7c3aed', 'cover' => 'https://covers.openlibrary.org/b/isbn/9780596527341-L.jpg'),
                                        array('title' => 'Strategic Writing for UX', 'author' => 'Torrey Podmajersky', 'color' => '#dc2626', 'cover' => 'https://covers.openlibrary.org/b/isbn/9781492049395-L.jpg'),
                                        array('title' => 'User Story Mapping', 'author' => 'Jeff Patton', 'color' => '#f59e0b', 'cover' => 'https://covers.openlibrary.org/b/isbn/9781491904909-L.jpg'),
                                        array('title' => 'Communicating the User Experience', 'author' => 'Richard Caddick & Steve Cable', 'color' => '#6b7280', 'cover' => 'https://covers.openlibrary.org/b/isbn/9781119971108-L.jpg'),
                                        array('title' => 'Search Patterns', 'author' => 'Peter Morville & Jeffery Callender', 'color' => '#ea580c', 'cover' => 'https://covers.openlibrary.org/b/isbn/9780596802271-L.jpg'),
                                        array('title' => 'The New Designer', 'author' => 'Manuel Lima', 'color' => '#eab308', 'cover' => 'https://covers.openlibrary.org/b/isbn/9780262047630-L.jpg'),
                                        array('title' => 'Handbook of Usability Testing', 'author' => 'Jeffrey Rubin & Dana Chisnell', 'color' => '#2563eb', 'cover' => 'https://covers.openlibrary.org/b/isbn/9780470185483-L.jpg'),
                                        array('title' => 'GUI Bloopers 2.0', 'author' => 'Jeff Johnson', 'color' => '#dc2626', 'cover' => 'https://covers.openlibrary.org/b/isbn/9780123706430-L.jpg'),
                                        array('title' => 'Universal Methods of Design', 'author' => 'Bruce Hanington & Bella Martin', 'color' => '#7c3aed', 'cover' => 'https://covers.openlibrary.org/b/isbn/9781631597480-L.jpg'),
                                        array('title' => 'The Elements of Voice First Style', 'author' => 'Ahmed Bouzid & Weiye Ma', 'color' => '#0ea5e9', 'cover' => 'https://covers.openlibrary.org/b/isbn/9781484270882-L.jpg'),
                                        array('title' => 'Design Beyond Devices', 'author' => 'Cheryl Platz', 'color' => '#ec4899', 'cover' => 'https://covers.openlibrary.org/b/isbn/9781933820989-L.jpg'),
                                        array('title' => 'Conversations with Things', 'author' => 'Diana Deibel & Rebecca Evanhoe', 'color' => '#14b8a6', 'cover' => 'https://covers.openlibrary.org/b/isbn/9781933820682-L.jpg'),
                                        array('title' => 'Customers Know You Suck', 'author' => 'Debbie Levitt', 'color' => '#ef4444', 'cover' => 'https://covers.openlibrary.org/b/isbn/9781735466408-L.jpg'),
                                        array('title' => 'Customer Experience Excellence', 'author' => 'Tim Knight & David Conway', 'color' => '#1e3a5f', 'cover' => 'https://covers.openlibrary.org/b/isbn/9781398601642-L.jpg'),
                                        array('title' => 'The Cult of the Customer', 'author' => 'Shep Hyken', 'color' => '#dc2626', 'cover' => 'https://covers.openlibrary.org/b/isbn/9781640951532-L.jpg'),
                                        array('title' => 'Intersection', 'author' => 'Milan Guenther', 'color' => '#0891b2', 'cover' => 'https://covers.openlibrary.org/b/isbn/9780123884350-L.jpg'),
                                        array('title' => 'Emotionally Intelligent Design', 'author' => 'Pamela Pavliscak', 'color' => '#f59e0b', 'cover' => 'https://covers.openlibrary.org/b/isbn/9781491953143-L.jpg'),
                                        array('title' => 'Drive', 'author' => 'Daniel H. Pink', 'color' => '#ec4899', 'cover' => 'https://covers.openlibrary.org/b/isbn/9781594484803-L.jpg'),
                                        array('title' => 'Designing with the Mind in Mind', 'author' => 'Jeff Johnson', 'color' => '#0ea5e9', 'cover' => 'https://covers.openlibrary.org/b/isbn/9780124079144-L.jpg'),
                                        array('title' => 'Designing for Behavior Change', 'author' => 'Stephen Wendel', 'color' => '#6b7280', 'cover' => 'https://covers.openlibrary.org/b/isbn/9781492056034-L.jpg'),
                                        array('title' => 'Design for How People Think', 'author' => 'John Whalen', 'color' => '#1e3a5f', 'cover' => 'https://covers.openlibrary.org/b/isbn/9781491985458-L.jpg'),
                                        array('title' => 'Designing with Sound', 'author' => 'Amber Case & Aaron Day', 'color' => '#0ea5e9', 'cover' => 'https://covers.openlibrary.org/b/isbn/9781491961100-L.jpg'),
                                        array('title' => 'Designing for Emerging Technologies', 'author' => 'Jonathan Follett', 'color' => '#dc2626', 'cover' => 'https://covers.openlibrary.org/b/isbn/9781449370510-L.jpg'),
                                        array('title' => 'Designing Autonomous AI', 'author' => 'Kence Anderson', 'color' => '#6b7280', 'cover' => 'https://covers.openlibrary.org/b/isbn/9781098100643-L.jpg'),
                                    ),
                                ),
                                'strategy' => array(
                                    'title' => 'Strategy & Business',
                                    'books' => array(
                                        array('title' => 'Good Strategy Bad Strategy', 'author' => 'Richard Rumelt', 'color' => '#1f2937', 'cover' => 'https://covers.openlibrary.org/b/isbn/9780307886231-L.jpg'),
                                        array('title' => 'Zero to One', 'author' => 'Peter Thiel', 'color' => '#2563eb', 'cover' => 'https://covers.openlibrary.org/b/isbn/9780804139298-L.jpg'),
                                        array('title' => 'The Lean Startup', 'author' => 'Eric Ries', 'color' => '#8b5cf6', 'cover' => 'https://covers.openlibrary.org/b/isbn/9780307887894-L.jpg'),
                                        array('title' => 'The Innovator\'s Dilemma', 'author' => 'Clayton Christensen', 'color' => '#dc2626', 'cover' => 'https://covers.openlibrary.org/b/isbn/9780062060242-L.jpg'),
                                        array('title' => 'Measure What Matters', 'author' => 'John Doerr', 'color' => '#22c55e', 'cover' => 'https://covers.openlibrary.org/b/isbn/9780525536222-L.jpg'),
                                        array('title' => 'Blue Ocean Strategy', 'author' => 'W. Chan Kim', 'color' => '#0284c7', 'cover' => 'https://covers.openlibrary.org/b/isbn/9781625274496-L.jpg'),
                                        array('title' => 'Competing Against Luck', 'author' => 'Clayton Christensen', 'color' => '#7c3aed', 'cover' => 'https://covers.openlibrary.org/b/isbn/9780062435613-L.jpg'),
                                        array('title' => 'Playing to Win', 'author' => 'A.G. Lafley & Roger Martin', 'color' => '#ea580c', 'cover' => 'https://covers.openlibrary.org/b/isbn/9781422187395-L.jpg'),
                                        array('title' => 'Built to Last', 'author' => 'Jim Collins', 'color' => '#0d9488', 'cover' => 'https://covers.openlibrary.org/b/isbn/9780060516406-L.jpg'),
                                        array('title' => 'The Emergent Approach to Strategy', 'author' => 'Peter Compo', 'color' => '#be185d', 'cover' => 'https://covers.openlibrary.org/b/isbn/9781529396935-L.jpg'),
                                    ),
                                ),
                                'thinking' => array(
                                    'title' => 'Thinking & Psychology',
                                    'books' => array(
                                        array('title' => 'Thinking, Fast and Slow', 'author' => 'Daniel Kahneman', 'color' => '#dc2626', 'cover' => 'https://covers.openlibrary.org/b/isbn/9780374533557-L.jpg'),
                                        array('title' => 'Range', 'author' => 'David Epstein', 'color' => '#be185d', 'cover' => 'https://covers.openlibrary.org/b/isbn/9780735214484-L.jpg'),
                                        array('title' => 'Atomic Habits', 'author' => 'James Clear', 'color' => '#f59e0b', 'cover' => 'https://covers.openlibrary.org/b/isbn/9780735211292-L.jpg'),
                                        array('title' => 'Deep Work', 'author' => 'Cal Newport', 'color' => '#1e3a5f', 'cover' => 'https://covers.openlibrary.org/b/isbn/9781455586691-L.jpg'),
                                        array('title' => 'The Culture Code', 'author' => 'Daniel Coyle', 'color' => '#059669', 'cover' => 'https://covers.openlibrary.org/b/isbn/9780525492467-L.jpg'),
                                        array('title' => 'Influence', 'author' => 'Robert Cialdini', 'color' => '#b91c1c', 'cover' => 'https://covers.openlibrary.org/b/isbn/9780062937650-L.jpg'),
                                        array('title' => 'Predictably Irrational', 'author' => 'Dan Ariely', 'color' => '#4f46e5', 'cover' => 'https://covers.openlibrary.org/b/isbn/9780061353246-L.jpg'),
                                        array('title' => 'Mindset', 'author' => 'Carol Dweck', 'color' => '#0891b2', 'cover' => 'https://covers.openlibrary.org/b/isbn/9780345472328-L.jpg'),
                                        array('title' => 'The 48 Laws of Power', 'author' => 'Robert Greene', 'color' => '#1a1a1a', 'cover' => 'https://covers.openlibrary.org/b/isbn/9780140280197-L.jpg'),
                                        array('title' => 'Bullshit Jobs', 'author' => 'David Graeber', 'color' => '#dc2626', 'cover' => 'https://covers.openlibrary.org/b/isbn/9781501143311-L.jpg'),
                                        array('title' => 'The Laws of Human Nature', 'author' => 'Robert Greene', 'color' => '#7c3aed', 'cover' => 'https://covers.openlibrary.org/b/isbn/9780525428145-L.jpg'),
                                    ),
                                ),
                                'product' => array(
                                    'title' => 'Product & Research',
                                    'books' => array(
                                        array('title' => 'Sprint', 'author' => 'Jake Knapp', 'color' => '#f59e0b', 'cover' => 'https://covers.openlibrary.org/b/isbn/9781501121746-L.jpg'),
                                        array('title' => 'Hooked', 'author' => 'Nir Eyal', 'color' => '#ef4444', 'cover' => 'https://covers.openlibrary.org/b/isbn/9781591847786-L.jpg'),
                                        array('title' => 'The Mom Test', 'author' => 'Rob Fitzpatrick', 'color' => '#ec4899', 'cover' => 'https://covers.openlibrary.org/b/isbn/9781492180746-L.jpg'),
                                        array('title' => 'Building a StoryBrand', 'author' => 'Donald Miller', 'color' => '#6366f1', 'cover' => 'https://covers.openlibrary.org/b/isbn/9780718033323-L.jpg'),
                                        array('title' => 'The Hard Thing About Hard Things', 'author' => 'Ben Horowitz', 'color' => '#374151', 'cover' => 'https://covers.openlibrary.org/b/isbn/9780062273208-L.jpg'),
                                        array('title' => 'Continuous Discovery Habits', 'author' => 'Teresa Torres', 'color' => '#2dd4bf', 'cover' => 'https://covers.openlibrary.org/b/isbn/9781736633304-L.jpg'),
                                        array('title' => 'Escaping the Build Trap', 'author' => 'Melissa Perri', 'color' => '#f472b6', 'cover' => 'https://covers.openlibrary.org/b/isbn/9781491973790-L.jpg'),
                                        array('title' => 'Empowered', 'author' => 'Marty Cagan', 'color' => '#34d399', 'cover' => 'https://covers.openlibrary.org/b/isbn/9781119691297-L.jpg'),
                                        array('title' => 'Transformed', 'author' => 'Marty Cagan', 'color' => '#8b5cf6', 'cover' => 'https://covers.openlibrary.org/b/isbn/9781119697336-L.jpg'),
                                    ),
                                ),
                                'team' => array(
                                    'title' => 'Team Building',
                                    'books' => array(
                                        array('title' => 'The Five Dysfunctions of a Team', 'author' => 'Patrick Lencioni', 'color' => '#1e3a5f', 'cover' => 'https://covers.openlibrary.org/b/isbn/9780787960759-L.jpg'),
                                        array('title' => 'Team of Teams', 'author' => 'General Stanley McChrystal', 'color' => '#374151', 'cover' => 'https://covers.openlibrary.org/b/isbn/9781591847489-L.jpg'),
                                        array('title' => 'Radical Candor', 'author' => 'Kim Scott', 'color' => '#ea580c', 'cover' => 'https://covers.openlibrary.org/b/isbn/9781250103512-L.jpg'),
                                        array('title' => 'Leaders Eat Last', 'author' => 'Simon Sinek', 'color' => '#dc2626', 'cover' => 'https://covers.openlibrary.org/b/isbn/9781591845324-L.jpg'),
                                        array('title' => 'Turn the Ship Around', 'author' => 'L. David Marquet', 'color' => '#0ea5e9', 'cover' => 'https://covers.openlibrary.org/b/isbn/9781591846406-L.jpg'),
                                        array('title' => 'The Ideal Team Player', 'author' => 'Patrick Lencioni', 'color' => '#22c55e', 'cover' => 'https://covers.openlibrary.org/b/isbn/9781119209591-L.jpg'),
                                        array('title' => 'Dare to Lead', 'author' => 'Brené Brown', 'color' => '#eab308', 'cover' => 'https://covers.openlibrary.org/b/isbn/9780399592522-L.jpg'),
                                        array('title' => 'Start with Why', 'author' => 'Simon Sinek', 'color' => '#f59e0b', 'cover' => 'https://covers.openlibrary.org/b/isbn/9781591846444-L.jpg'),
                                        array('title' => 'The One Minute Manager', 'author' => 'Ken Blanchard & Spencer Johnson', 'color' => '#2563eb', 'cover' => 'https://covers.openlibrary.org/b/isbn/9780062367549-L.jpg'),
                                    ),
                                ),
                                'ux_management' => array(
                                    'title' => 'UX Management',
                                    'books' => array(
                                        array('title' => 'Org Design for Design Orgs', 'author' => 'Peter Merholz & Kristin Skinner', 'color' => '#7c3aed', 'cover' => 'https://covers.openlibrary.org/b/isbn/9781491938409-L.jpg'),
                                        array('title' => 'Design Leadership', 'author' => 'Richard Banfield', 'color' => '#0891b2', 'cover' => 'https://covers.openlibrary.org/b/isbn/9781491929186-L.jpg'),
                                        array('title' => 'The User Experience Team of One', 'author' => 'Leah Buley', 'color' => '#dc2626', 'cover' => 'https://covers.openlibrary.org/b/isbn/9781933820187-L.jpg'),
                                        array('title' => 'Articulating Design Decisions', 'author' => 'Tom Greever', 'color' => '#059669', 'cover' => 'https://covers.openlibrary.org/b/isbn/9781491921562-L.jpg'),
                                        array('title' => 'Design Is a Job', 'author' => 'Mike Monteiro', 'color' => '#ea580c', 'cover' => 'https://covers.openlibrary.org/b/isbn/9781937557041-L.jpg'),
                                        array('title' => 'Creative Confidence', 'author' => 'Tom Kelley & David Kelley', 'color' => '#2563eb', 'cover' => 'https://covers.openlibrary.org/b/isbn/9780385349369-L.jpg'),
                                        array('title' => 'User Experience Management', 'author' => 'Arnie Lund', 'color' => '#6366f1', 'cover' => 'https://covers.openlibrary.org/b/isbn/9780123854964-L.jpg'),
                                    ),
                                ),
                            );

                            foreach ($book_categories as $category_key => $category) :
                            ?>
                            <!-- <?php echo esc_html($category['title']); ?> -->
                            <div class="bookshelf-row">
                                <h3 class="bookshelf-row-title"><?php echo esc_html($category['title']); ?> <span class="bookshelf-count">(<?php echo count($category['books']); ?>)</span></h3>
                                <div class="bookshelf-scroll">
                                    <div class="bookshelf-track">
                                        <?php foreach ($category['books'] as $index => $book) : ?>
                                        <div class="book-item">
                                            <div class="book-cover-wrap" style="background-color: <?php echo esc_attr($book['color']); ?>;">
                                                <?php if (!empty($book['cover'])) : ?>
                                                <img src="<?php echo esc_url($book['cover']); ?>"
                                                     alt="<?php echo esc_attr($book['title']); ?>"
                                                     class="book-cover-image"
                                                     loading="lazy"
                                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                                <?php endif; ?>
                                                <div class="book-cover-content" style="<?php echo !empty($book['cover']) ? 'display:none;' : ''; ?>">
                                                    <span class="book-cover-title"><?php echo esc_html($book['title']); ?></span>
                                                    <span class="book-cover-author"><?php echo esc_html($book['author']); ?></span>
                                                </div>
                                            </div>
                                            <div class="book-info">
                                                <span class="book-info-title"><?php echo esc_html($book['title']); ?></span>
                                                <span class="book-info-author"><?php echo esc_html($book['author']); ?></span>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>

                        </div>
                    </section>
                </div>
            </div>

        </article><!-- #post-<?php the_ID(); ?> -->

        <!-- CTA Section -->
        <section class="section text-center" style="padding-bottom: 100px;">
            <div class="container">
                <h2><?php esc_html_e("Let's Work Together", 'bfluxco'); ?></h2>
                <p class="text-gray-600 max-w-2xl mx-auto mb-6">
                    <?php esc_html_e('I work with teams who want to design GenAI experiences deliberately—balancing innovation with responsibility, clarity, and long-term impact.', 'bfluxco'); ?>
                </p>
                <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-primary btn-lg">
                    <?php esc_html_e('Get in Touch', 'bfluxco'); ?>
                </a>
            </div>
        </section><!-- CTA -->

    </div><!-- .about-page-content -->

    <?php endwhile; ?>

</main><!-- #main-content -->

<script>
document.addEventListener('DOMContentLoaded', function () {
    var buttons = document.querySelectorAll('.about-menu-item[data-tab]');
    var panels = document.querySelectorAll('.about-tab-panel');

    buttons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            var tab = this.getAttribute('data-tab');

            buttons.forEach(function (b) { b.classList.remove('is-active'); });
            panels.forEach(function (p) { p.classList.remove('is-active'); });

            this.classList.add('is-active');
            var target = document.getElementById(tab);
            if (target) {
                target.classList.add('is-active');
            }
        });
    });
});
</script>

<?php
get_footer('about');
