<?php
/**
 * Template Name: Blog
 * Template Post Type: page
 *
 * Blog/Resources library page - curated thinking tools for small and minority-owned businesses.
 * URL: /blog
 *
 * @package BFLUXCO
 */

get_header();
?>

<main id="main-content" class="site-main resources-page blog-page">

    <!-- Page Header -->
    <header class="page-header resources-header">
        <div class="container">
            <h1 class="page-title reveal-hero"><?php esc_html_e('Blog', 'bfluxco'); ?></h1>
            <p class="page-description reveal" data-delay="1">
                <?php esc_html_e('Practical tools and perspectives to help small businesses design systems, adopt AI responsibly, and make better decisions as complexity grows.', 'bfluxco'); ?>
            </p>
        </div>
    </header>

    <!-- Featured Resources Section -->
    <section class="section resources-featured" data-section="featured">
        <div class="container">
            <div class="section-header reveal-up">
                <h2 class="section-title"><?php esc_html_e('Start Here', 'bfluxco'); ?></h2>
                <p class="section-description">
                    <?php esc_html_e('Foundational resources that reflect how we think about systems, decisions, and responsible AI.', 'bfluxco'); ?>
                </p>
            </div>

            <div class="resources-grid resources-grid-featured">
                <?php
                // Featured Resource 1 - Guide
                get_template_part('template-parts/card-resource', null, array(
                    'type' => 'guide',
                    'title' => __('Designing Intelligent Systems for Small Businesses', 'bfluxco'),
                    'description' => __('A practical guide for founders and operators navigating AI adoption without enterprise teams or enterprise risk tolerance.', 'bfluxco'),
                    'link' => '#',
                    'link_text' => __('Read the guide', 'bfluxco'),
                    'featured' => true,
                    'delay' => 1,
                ));

                // Featured Resource 2 - Framework
                get_template_part('template-parts/card-resource', null, array(
                    'type' => 'framework',
                    'title' => __('When to Automate—and When Not To', 'bfluxco'),
                    'description' => __('A decision framework to help teams evaluate whether automation will reduce complexity or introduce new risk.', 'bfluxco'),
                    'link' => '#',
                    'link_text' => __('View framework', 'bfluxco'),
                    'featured' => true,
                    'delay' => 2,
                ));

                // Featured Resource 3 - Article
                get_template_part('template-parts/card-resource', null, array(
                    'type' => 'article',
                    'title' => __('AI Is Not a Feature', 'bfluxco'),
                    'description' => __('Why treating AI as a bolt-on leads to fragile systems—and what to design instead.', 'bfluxco'),
                    'link' => '#',
                    'link_text' => __('Read article', 'bfluxco'),
                    'featured' => true,
                    'delay' => 3,
                ));
                ?>
            </div>
        </div>
    </section>

    <!-- Articles Section -->
    <section class="section resources-section" data-section="articles" data-type="article">
        <div class="container">
            <div class="section-header reveal-up">
                <div class="section-header-row">
                    <h2 class="section-title"><?php esc_html_e('Articles', 'bfluxco'); ?></h2>
                    <div class="resources-archives-wrapper">
                        <button class="btn btn-secondary resources-archives-toggle" aria-expanded="false" aria-controls="archives-menu">
                            <?php esc_html_e('View Archives', 'bfluxco'); ?>
                            <svg class="archives-chevron" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M6 9l6 6 6-6"/>
                            </svg>
                        </button>
                        <div class="resources-archives-menu" id="archives-menu" aria-hidden="true">
                            <div class="archives-menu-inner">
                                <div class="archives-menu-header">
                                    <span class="archives-menu-title"><?php esc_html_e('All Articles', 'bfluxco'); ?></span>
                                </div>
                                <ul class="archives-menu-list">
                                    <li><a href="#">Designing for Exceptions, Not the Happy Path</a></li>
                                    <li><a href="#">Why Small Teams Can't Afford Bad AI Decisions</a></li>
                                    <li><a href="#">AI Is Not a Feature</a></li>
                                    <li><a href="#">The Hidden Cost of Automation</a></li>
                                    <li><a href="#">Building Trust in AI Systems</a></li>
                                    <li><a href="#">Decision-Making Under Uncertainty</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="section-description">
                    <?php esc_html_e('Short essays that clarify complex ideas, surface common failure patterns, and challenge assumptions about AI, design, and systems.', 'bfluxco'); ?>
                </p>
            </div>

            <div class="resources-grid">
                <?php
                get_template_part('template-parts/card-resource', null, array(
                    'type' => 'article',
                    'title' => __('Designing for Exceptions, Not the Happy Path', 'bfluxco'),
                    'description' => __('Why edge cases are often the clearest signal of how a system really works.', 'bfluxco'),
                    'link' => '#',
                    'link_text' => __('Read article', 'bfluxco'),
                    'delay' => 1,
                ));

                get_template_part('template-parts/card-resource', null, array(
                    'type' => 'article',
                    'title' => __("Why Small Teams Can't Afford Bad AI Decisions", 'bfluxco'),
                    'description' => __('How limited margin for error changes how AI should be designed and deployed.', 'bfluxco'),
                    'link' => '#',
                    'link_text' => __('Read article', 'bfluxco'),
                    'delay' => 2,
                ));
                ?>
            </div>
        </div>
    </section>

    <!-- Guides Section -->
    <section class="section resources-section" data-section="guides" data-type="guide">
        <div class="container">
            <div class="section-header reveal-up">
                <h2 class="section-title"><?php esc_html_e('Guides', 'bfluxco'); ?></h2>
                <p class="section-description">
                    <?php esc_html_e('Step-by-step thinking tools for teams making real decisions under real constraints.', 'bfluxco'); ?>
                </p>
            </div>

            <div class="resources-grid">
                <?php
                get_template_part('template-parts/card-resource', null, array(
                    'type' => 'guide',
                    'title' => __('A Small Business Guide to Responsible AI Adoption', 'bfluxco'),
                    'description' => __('How to introduce AI into your workflows without losing visibility, control, or trust.', 'bfluxco'),
                    'link' => '#',
                    'link_text' => __('View guide', 'bfluxco'),
                    'delay' => 1,
                ));

                get_template_part('template-parts/card-resource', null, array(
                    'type' => 'guide',
                    'title' => __('Evaluating AI Tools Without a Data Science Team', 'bfluxco'),
                    'description' => __("A practical approach to assessing AI products when you don't have specialized technical staff.", 'bfluxco'),
                    'link' => '#',
                    'link_text' => __('View guide', 'bfluxco'),
                    'delay' => 2,
                ));
                ?>
            </div>
        </div>
    </section>

    <!-- Frameworks Section -->
    <section class="section resources-section" data-section="frameworks" data-type="framework">
        <div class="container">
            <div class="section-header reveal-up">
                <h2 class="section-title"><?php esc_html_e('Frameworks', 'bfluxco'); ?></h2>
                <p class="section-description">
                    <?php esc_html_e('Models and structures we use to make system behavior, responsibility, and decision-making visible.', 'bfluxco'); ?>
                </p>
            </div>

            <div class="resources-grid">
                <?php
                get_template_part('template-parts/card-resource', null, array(
                    'type' => 'framework',
                    'title' => __('Human–AI Responsibility Map', 'bfluxco'),
                    'description' => __('A framework for defining where human judgment ends, where AI assists, and where accountability lives.', 'bfluxco'),
                    'link' => '#',
                    'link_text' => __('View framework', 'bfluxco'),
                    'delay' => 1,
                ));

                get_template_part('template-parts/card-resource', null, array(
                    'type' => 'framework',
                    'title' => __('Decision Visibility Model', 'bfluxco'),
                    'description' => __('A way to surface how decisions move through systems and where breakdowns are most likely to occur.', 'bfluxco'),
                    'link' => '#',
                    'link_text' => __('View framework', 'bfluxco'),
                    'delay' => 2,
                ));
                ?>
            </div>
        </div>
    </section>

    <!-- Templates Section -->
    <section class="section resources-section" data-section="templates" data-type="template">
        <div class="container">
            <div class="section-header reveal-up">
                <h2 class="section-title"><?php esc_html_e('Templates', 'bfluxco'); ?></h2>
                <p class="section-description">
                    <?php esc_html_e('Simple, practical templates teams can use immediately.', 'bfluxco'); ?>
                </p>
            </div>

            <div class="resources-grid">
                <?php
                get_template_part('template-parts/card-resource', null, array(
                    'type' => 'template',
                    'title' => __('AI Use Case Definition Template', 'bfluxco'),
                    'description' => __('A worksheet to clarify intent, constraints, and risk before introducing automation.', 'bfluxco'),
                    'link' => '#',
                    'link_text' => __('Download template', 'bfluxco'),
                    'delay' => 1,
                ));

                get_template_part('template-parts/card-resource', null, array(
                    'type' => 'template',
                    'title' => __('Conversation Design Checklist', 'bfluxco'),
                    'description' => __('A checklist for designing AI-assisted conversations with clear boundaries and expectations.', 'bfluxco'),
                    'link' => '#',
                    'link_text' => __('Download template', 'bfluxco'),
                    'delay' => 2,
                ));
                ?>
            </div>
        </div>
    </section>

    <!-- Case Notes Section -->
    <section class="section resources-section" data-section="case-notes" data-type="case-note">
        <div class="container">
            <div class="section-header reveal-up">
                <h2 class="section-title"><?php esc_html_e('Case Notes', 'bfluxco'); ?></h2>
                <p class="section-description">
                    <?php esc_html_e('Short reflections on real work, focused on decisions and lessons—not polished success stories.', 'bfluxco'); ?>
                </p>
            </div>

            <div class="resources-grid">
                <?php
                get_template_part('template-parts/card-resource', null, array(
                    'type' => 'case-note',
                    'title' => __("Why We Didn't Automate—and What Changed Instead", 'bfluxco'),
                    'description' => __('A case note on choosing clarity over speed and the downstream impact of that decision.', 'bfluxco'),
                    'link' => '#',
                    'link_text' => __('Read case note', 'bfluxco'),
                    'delay' => 1,
                ));

                get_template_part('template-parts/card-resource', null, array(
                    'type' => 'case-note',
                    'title' => __('Making System Behavior Visible Prevented Escalations', 'bfluxco'),
                    'description' => __('What happened when a team modeled decision flow before deploying AI.', 'bfluxco'),
                    'link' => '#',
                    'link_text' => __('Read case note', 'bfluxco'),
                    'delay' => 2,
                ));
                ?>
            </div>
        </div>
    </section>

    <!-- Bottom CTA Section -->
    <section class="section resources-cta">
        <div class="container">
            <div class="resources-cta-content reveal-up">
                <h2 class="resources-cta-title"><?php esc_html_e('Looking for Something Specific?', 'bfluxco'); ?></h2>
                <p class="resources-cta-description">
                    <?php esc_html_e("If you're navigating complexity that isn't covered here, we're always open to a conversation.", 'bfluxco'); ?>
                </p>
                <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-primary">
                    <?php esc_html_e('Contact Big Freight Life', 'bfluxco'); ?>
                    <?php bfluxco_icon('arrow-right', array('size' => 16)); ?>
                </a>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>
