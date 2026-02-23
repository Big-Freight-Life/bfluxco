<?php
/**
 * The header template
 *
 * This file contains the opening HTML, head section, and header/navigation.
 * It's included at the top of every page via get_header().
 *
 * @package BFLUXCO
 *
 * PRO TIP: This file opens the HTML document. Notice it has opening
 * tags like <html>, <head>, and <body> but no closing tags - those are
 * in footer.php. Every page template calls get_header() at the top.
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php
    /**
     * Inline theme initialization script - MUST run before stylesheets load
     * to prevent flash of wrong theme (FOUST) when navigating between pages.
     * This synchronously reads localStorage and applies the theme immediately.
     */
    ?>
    <script>
    (function() {
        var stored = localStorage.getItem('bfluxco-theme');
        var prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        var theme = stored || (prefersDark ? 'dark' : 'light');
        document.documentElement.setAttribute('data-theme', theme);
        document.documentElement.style.colorScheme = theme;
    })();
    </script>
    <style>
    /* Suppress all transitions during page load to prevent flickering */
    .preload, .preload * { transition: none !important; }
    </style>

    <?php
    /**
     * wp_head() outputs essential WordPress scripts, styles, and meta tags.
     * NEVER remove this - it's required for WordPress and plugins to work.
     */
    wp_head();
    ?>
</head>

<body <?php body_class('preload'); ?>>

<?php
/**
 * wp_body_open() is a hook that fires immediately after the opening <body> tag.
 * Some plugins use this to add things like analytics or skip links.
 */
wp_body_open();
?>

<!-- Skip to main content link for accessibility (screen readers) -->
<a class="skip-link screen-reader-text" href="#main-content">
    <?php esc_html_e('Skip to content', 'bfluxco'); ?>
</a>

<?php
// Check if we're on a case study template page
$is_case_study = false;
if (is_page()) {
    $template = get_page_template_slug();
    if (strpos($template, 'template-case-study-style') !== false) {
        $is_case_study = true;
    }
}
?>

<header id="site-header" class="site-header<?php echo $is_case_study ? ' header-minimal' : ''; ?>">
    <div class="container">
        <?php if ($is_case_study) : ?>
        <!-- Minimal Header for Case Studies -->
        <div class="header-inner header-inner-minimal">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="back-button">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 12H5"/>
                    <path d="M12 19l-7-7 7-7"/>
                </svg>
                <span><?php esc_html_e('Back', 'bfluxco'); ?></span>
            </a>
        </div>
        <?php else : ?>
        <div class="header-inner">
            <!-- Site Logo/Brand -->
            <div class="site-branding">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo" rel="home">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo.png'); ?>" alt="<?php bloginfo('name'); ?>" class="site-logo-img">
                    <span class="logo-primary">BFLUX</span>
                    <span class="logo-secondary">Ray Butler</span>
                </a>
            </div><!-- .site-branding -->

            <!-- Primary Navigation with Mega Menu Triggers -->
            <nav id="primary-navigation" class="primary-nav" aria-label="<?php esc_attr_e('Primary Navigation', 'bfluxco'); ?>">
                <ul class="primary-menu">
                    <li class="menu-item">
                        <a href="<?php echo esc_url(home_url('/works')); ?>"><?php esc_html_e('Works', 'bfluxco'); ?></a>
                    </li>
                    <li class="menu-item">
                        <a href="<?php echo esc_url(home_url('/products')); ?>"><?php esc_html_e('Products', 'bfluxco'); ?></a>
                    </li>
                    <li class="menu-item has-megamenu" data-megamenu="services">
                        <a href="<?php echo esc_url(home_url('/services')); ?>">
                            <?php esc_html_e('Services', 'bfluxco'); ?>
                            <svg class="menu-chevron" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M6 9l6 6 6-6"/>
                            </svg>
                        </a>
                    </li>
                    <li class="menu-item has-megamenu" data-megamenu="about">
                        <a href="<?php echo esc_url(home_url('/about')); ?>">
                            <?php esc_html_e('About', 'bfluxco'); ?>
                            <svg class="menu-chevron" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M6 9l6 6 6-6"/>
                            </svg>
                        </a>
                    </li>
                </ul>
            </nav><!-- #primary-navigation -->

            <!-- Secondary Navigation (Right) -->
            <nav id="secondary-navigation" class="secondary-nav" aria-label="<?php esc_attr_e('Secondary Navigation', 'bfluxco'); ?>">
                <?php
                if (has_nav_menu('secondary')) {
                    wp_nav_menu(array(
                        'theme_location' => 'secondary',
                        'menu_id'        => 'secondary-menu',
                        'menu_class'     => 'secondary-menu',
                        'container'      => false,
                        'depth'          => 1,
                    ));
                } else {
                    ?>
                    <ul class="secondary-menu">
                        <li><a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-tertiary btn-sm"><?php esc_html_e('Contact', 'bfluxco'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/support')); ?>" class="btn btn-quad btn-sm">Support</a></li>
                    </ul>
                    <?php
                }
                ?>
            </nav><!-- #secondary-navigation -->

            <!-- Theme Toggle -->
            <div class="theme-toggle" role="radiogroup" aria-label="<?php esc_attr_e('Color theme', 'bfluxco'); ?>">
                <button class="theme-toggle-btn" data-theme="light" aria-label="<?php esc_attr_e('Light mode', 'bfluxco'); ?>" role="radio" aria-checked="false">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="5"/>
                        <line x1="12" y1="1" x2="12" y2="3"/>
                        <line x1="12" y1="21" x2="12" y2="23"/>
                        <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/>
                        <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
                        <line x1="1" y1="12" x2="3" y2="12"/>
                        <line x1="21" y1="12" x2="23" y2="12"/>
                        <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/>
                        <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
                    </svg>
                </button>
                <button class="theme-toggle-btn" data-theme="system" aria-label="<?php esc_attr_e('System preference', 'bfluxco'); ?>" role="radio" aria-checked="true">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="3" width="20" height="14" rx="2" ry="2"/>
                        <line x1="8" y1="21" x2="16" y2="21"/>
                        <line x1="12" y1="17" x2="12" y2="21"/>
                    </svg>
                </button>
                <button class="theme-toggle-btn" data-theme="dark" aria-label="<?php esc_attr_e('Dark mode', 'bfluxco'); ?>" role="radio" aria-checked="false">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu Toggle Button -->
            <button class="menu-toggle" aria-controls="mobile-navigation" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle Menu', 'bfluxco'); ?>">
                <span></span>
            </button>
        </div><!-- .header-inner -->
        <?php endif; ?>
    </div><!-- .container -->

    <?php if (!$is_case_study) : ?>
    <!-- Mega Menu: Services -->
    <div class="megamenu" id="megamenu-services" role="navigation" aria-label="<?php esc_attr_e('Services Navigation', 'bfluxco'); ?>">
        <div class="megamenu-backdrop"></div>
        <div class="megamenu-container">
            <div class="megamenu-inner">
                <!-- Left Panel: Navigation Index -->
                <div class="megamenu-left">
                    <h2 class="megamenu-section-title"><?php esc_html_e('Services', 'bfluxco'); ?></h2>
                    <ul class="megamenu-nav" role="menu">
                        <li class="megamenu-nav-item active" data-panel="experience-design" role="menuitem">
                            <a href="<?php echo esc_url(home_url('/services/experience-design')); ?>">
                                <span class="megamenu-nav-text"><?php esc_html_e('Experience Design', 'bfluxco'); ?></span>
                                <svg class="megamenu-nav-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M9 18l6-6-6-6"/>
                                </svg>
                            </a>
                        </li>
                        <li class="megamenu-nav-item" data-panel="gen-ai" role="menuitem">
                            <a href="<?php echo esc_url(home_url('/services/genai-experience-architecture')); ?>">
                                <span class="megamenu-nav-text"><?php esc_html_e('GenAI Experience Architecture', 'bfluxco'); ?></span>
                                <svg class="megamenu-nav-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M9 18l6-6-6-6"/>
                                </svg>
                            </a>
                        </li>
                        <li class="megamenu-nav-item" data-panel="customer-research" role="menuitem">
                            <a href="<?php echo esc_url(home_url('/services/customer-research')); ?>">
                                <span class="megamenu-nav-text"><?php esc_html_e('Customer Research', 'bfluxco'); ?></span>
                                <svg class="megamenu-nav-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M9 18l6-6-6-6"/>
                                </svg>
                            </a>
                        </li>
                        <li class="megamenu-nav-item" data-panel="digital-twins" role="menuitem">
                            <a href="<?php echo esc_url(home_url('/services/digital-twins')); ?>">
                                <span class="megamenu-nav-text"><?php esc_html_e('Digital Twins', 'bfluxco'); ?></span>
                                <svg class="megamenu-nav-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M9 18l6-6-6-6"/>
                                </svg>
                            </a>
                        </li>
                        <li class="megamenu-nav-item" data-panel="conversation-design" role="menuitem">
                            <a href="<?php echo esc_url(home_url('/services/conversation-design')); ?>">
                                <span class="megamenu-nav-text"><?php esc_html_e('Conversation Design', 'bfluxco'); ?></span>
                                <svg class="megamenu-nav-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M9 18l6-6-6-6"/>
                                </svg>
                            </a>
                        </li>
                        <li class="megamenu-nav-item" data-panel="workshops" role="menuitem">
                            <a href="<?php echo esc_url(home_url('/services/workshops')); ?>">
                                <span class="megamenu-nav-text"><?php esc_html_e('Workshops', 'bfluxco'); ?></span>
                                <svg class="megamenu-nav-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M9 18l6-6-6-6"/>
                                </svg>
                            </a>
                        </li>
                        <li class="megamenu-nav-item" data-panel="team-transformation" role="menuitem">
                            <a href="<?php echo esc_url(home_url('/transformation')); ?>">
                                <span class="megamenu-nav-text"><?php esc_html_e('Team Transformation', 'bfluxco'); ?></span>
                                <svg class="megamenu-nav-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M9 18l6-6-6-6"/>
                                </svg>
                            </a>
                        </li>
                    </ul>
                    <a href="<?php echo esc_url(home_url('/services')); ?>" class="megamenu-view-all">
                        <?php esc_html_e('View all services', 'bfluxco'); ?>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

                <!-- Right Panel: Contextual Content -->
                <div class="megamenu-right">
                    <!-- Experience Design Panel -->
                    <div class="megamenu-panel active" data-panel="experience-design">
                        <div class="megamenu-panel-image">
                            <div class="megamenu-image-placeholder" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8);"></div>
                        </div>
                        <div class="megamenu-panel-content">
                            <h3 class="megamenu-panel-title"><?php esc_html_e('Experience Design', 'bfluxco'); ?></h3>
                            <p class="megamenu-panel-desc"><?php esc_html_e('End-to-end experience design that transforms how customers interact with your brand across every touchpoint.', 'bfluxco'); ?></p>
                            <a href="<?php echo esc_url(home_url('/services/experience-design')); ?>" class="btn btn-primary btn-sm">
                                <?php esc_html_e('Learn more', 'bfluxco'); ?>
                            </a>
                        </div>
                    </div>

                    <!-- Gen AI Architecture Panel -->
                    <div class="megamenu-panel" data-panel="gen-ai">
                        <div class="megamenu-panel-image">
                            <div class="megamenu-image-placeholder" style="background: linear-gradient(135deg, #8b5cf6, #6d28d9);"></div>
                        </div>
                        <div class="megamenu-panel-content">
                            <h3 class="megamenu-panel-title"><?php esc_html_e('GenAI Experience Architecture', 'bfluxco'); ?></h3>
                            <p class="megamenu-panel-desc"><?php esc_html_e('Strategic AI implementation that integrates generative AI into your products and workflows meaningfully.', 'bfluxco'); ?></p>
                            <a href="<?php echo esc_url(home_url('/services/genai-experience-architecture')); ?>" class="btn btn-primary btn-sm">
                                <?php esc_html_e('Learn more', 'bfluxco'); ?>
                            </a>
                        </div>
                    </div>

                    <!-- Customer Research Panel -->
                    <div class="megamenu-panel" data-panel="customer-research">
                        <div class="megamenu-panel-image">
                            <div class="megamenu-image-placeholder" style="background: linear-gradient(135deg, #10b981, #059669);"></div>
                        </div>
                        <div class="megamenu-panel-content">
                            <h3 class="megamenu-panel-title"><?php esc_html_e('Customer Research', 'bfluxco'); ?></h3>
                            <p class="megamenu-panel-desc"><?php esc_html_e('Deep customer insights through qualitative and quantitative research that inform strategic decisions.', 'bfluxco'); ?></p>
                            <a href="<?php echo esc_url(home_url('/services/customer-research')); ?>" class="btn btn-primary btn-sm">
                                <?php esc_html_e('Learn more', 'bfluxco'); ?>
                            </a>
                        </div>
                    </div>

                    <!-- Digital Twins Panel -->
                    <div class="megamenu-panel" data-panel="digital-twins">
                        <div class="megamenu-panel-image">
                            <div class="megamenu-image-placeholder" style="background: linear-gradient(135deg, #06b6d4, #0891b2);"></div>
                        </div>
                        <div class="megamenu-panel-content">
                            <h3 class="megamenu-panel-title"><?php esc_html_e('Digital Twins', 'bfluxco'); ?></h3>
                            <p class="megamenu-panel-desc"><?php esc_html_e('Virtual replicas of physical systems that enable simulation, monitoring, and optimization at scale.', 'bfluxco'); ?></p>
                            <a href="<?php echo esc_url(home_url('/services/digital-twins')); ?>" class="btn btn-primary btn-sm">
                                <?php esc_html_e('Learn more', 'bfluxco'); ?>
                            </a>
                        </div>
                    </div>

                    <!-- Conversation Design Panel -->
                    <div class="megamenu-panel" data-panel="conversation-design">
                        <div class="megamenu-panel-image">
                            <div class="megamenu-image-placeholder" style="background: linear-gradient(135deg, #f59e0b, #d97706);"></div>
                        </div>
                        <div class="megamenu-panel-content">
                            <h3 class="megamenu-panel-title"><?php esc_html_e('Conversation Design', 'bfluxco'); ?></h3>
                            <p class="megamenu-panel-desc"><?php esc_html_e('Human-centered conversational experiences for chatbots, voice assistants, and AI-powered interfaces.', 'bfluxco'); ?></p>
                            <a href="<?php echo esc_url(home_url('/services/conversation-design')); ?>" class="btn btn-primary btn-sm">
                                <?php esc_html_e('Learn more', 'bfluxco'); ?>
                            </a>
                        </div>
                    </div>

                    <!-- Workshops Panel -->
                    <div class="megamenu-panel" data-panel="workshops">
                        <div class="megamenu-panel-image">
                            <div class="megamenu-image-placeholder" style="background: linear-gradient(135deg, #ec4899, #be185d);"></div>
                        </div>
                        <div class="megamenu-panel-content">
                            <h3 class="megamenu-panel-title"><?php esc_html_e('Workshops', 'bfluxco'); ?></h3>
                            <p class="megamenu-panel-desc"><?php esc_html_e('Collaborative sessions that align teams, accelerate decision-making, and unlock strategic clarity.', 'bfluxco'); ?></p>
                            <a href="<?php echo esc_url(home_url('/services/workshops')); ?>" class="btn btn-primary btn-sm">
                                <?php esc_html_e('Explore workshops', 'bfluxco'); ?>
                            </a>
                        </div>
                    </div>

                    <!-- Team Transformation Panel -->
                    <div class="megamenu-panel" data-panel="team-transformation">
                        <div class="megamenu-panel-image">
                            <div class="megamenu-image-placeholder" style="background: linear-gradient(135deg, #14b8a6, #0d9488);"></div>
                        </div>
                        <div class="megamenu-panel-content">
                            <h3 class="megamenu-panel-title"><?php esc_html_e('Team Transformation', 'bfluxco'); ?></h3>
                            <p class="megamenu-panel-desc"><?php esc_html_e('Build lasting capabilities through workshops, coaching, and embedded partnerships that empower your team.', 'bfluxco'); ?></p>
                            <a href="<?php echo esc_url(home_url('/transformation')); ?>" class="btn btn-primary btn-sm">
                                <?php esc_html_e('Learn more', 'bfluxco'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- #megamenu-services -->

    <!-- Mega Menu: About -->
    <div class="megamenu" id="megamenu-about" role="navigation" aria-label="<?php esc_attr_e('About Navigation', 'bfluxco'); ?>">
        <div class="megamenu-backdrop"></div>
        <div class="megamenu-container">
            <div class="megamenu-inner">
                <!-- Left Panel: Navigation Index -->
                <div class="megamenu-left">
                    <h2 class="megamenu-section-title"><?php esc_html_e('About', 'bfluxco'); ?></h2>
                    <ul class="megamenu-nav" role="menu">
                        <li class="megamenu-nav-item active" data-panel="ray" role="menuitem">
                            <a href="<?php echo esc_url(home_url('/about/ray')); ?>">
                                <span class="megamenu-nav-text"><?php esc_html_e('Ray Butler', 'bfluxco'); ?></span>
                                <svg class="megamenu-nav-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M9 18l6-6-6-6"/>
                                </svg>
                            </a>
                        </li>
                        <li class="megamenu-nav-item" data-panel="bfl" role="menuitem">
                            <a href="<?php echo esc_url(home_url('/about/bfl')); ?>">
                                <span class="megamenu-nav-text"><?php esc_html_e('Big Freight Life', 'bfluxco'); ?></span>
                                <svg class="megamenu-nav-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M9 18l6-6-6-6"/>
                                </svg>
                            </a>
                        </li>
                        <li class="megamenu-nav-item" data-panel="contact" role="menuitem">
                            <a href="<?php echo esc_url(home_url('/contact')); ?>">
                                <span class="megamenu-nav-text"><?php esc_html_e('Contact', 'bfluxco'); ?></span>
                                <svg class="megamenu-nav-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M9 18l6-6-6-6"/>
                                </svg>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Right Panel: Contextual Content -->
                <div class="megamenu-right">
                    <!-- Ray Butler Panel -->
                    <div class="megamenu-panel active" data-panel="ray">
                        <div class="megamenu-panel-image">
                            <div class="megamenu-image-placeholder" style="background: linear-gradient(135deg, var(--color-gray-400), var(--color-gray-600));"></div>
                        </div>
                        <div class="megamenu-panel-content">
                            <h3 class="megamenu-panel-title"><?php esc_html_e('Ray Butler', 'bfluxco'); ?></h3>
                            <p class="megamenu-panel-desc"><?php esc_html_e('Design strategist with years of experience helping organizations navigate complexity and create meaningful solutions.', 'bfluxco'); ?></p>
                            <a href="<?php echo esc_url(home_url('/about/ray')); ?>" class="btn btn-primary btn-sm">
                                <?php esc_html_e('Meet Ray', 'bfluxco'); ?>
                            </a>
                        </div>
                    </div>

                    <!-- Big Freight Life Panel -->
                    <div class="megamenu-panel" data-panel="bfl">
                        <div class="megamenu-panel-image">
                            <div class="megamenu-image-placeholder" style="background: linear-gradient(135deg, var(--color-gray-800), var(--color-black));"></div>
                        </div>
                        <div class="megamenu-panel-content">
                            <h3 class="megamenu-panel-title"><?php esc_html_e('Big Freight Life', 'bfluxco'); ?></h3>
                            <p class="megamenu-panel-desc"><?php esc_html_e('The creative studio and practice behind BFLUX. Learn about our mission, values, and approach.', 'bfluxco'); ?></p>
                            <a href="<?php echo esc_url(home_url('/about/bfl')); ?>" class="btn btn-primary btn-sm">
                                <?php esc_html_e('About the studio', 'bfluxco'); ?>
                            </a>
                        </div>
                    </div>

                    <!-- Contact Panel -->
                    <div class="megamenu-panel" data-panel="contact">
                        <div class="megamenu-panel-image">
                            <div class="megamenu-image-placeholder" style="background: linear-gradient(135deg, var(--color-primary-light), var(--color-primary-dark));"></div>
                        </div>
                        <div class="megamenu-panel-content">
                            <h3 class="megamenu-panel-title"><?php esc_html_e('Get in Touch', 'bfluxco'); ?></h3>
                            <p class="megamenu-panel-desc"><?php esc_html_e("Have a project in mind or want to explore working together? Let's start a conversation.", 'bfluxco'); ?></p>
                            <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-primary btn-sm">
                                <?php esc_html_e('Contact us', 'bfluxco'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- #megamenu-about -->

    <!-- Mobile Navigation (Hidden by default) -->
    <nav id="mobile-navigation" class="mobile-nav" aria-label="<?php esc_attr_e('Mobile Navigation', 'bfluxco'); ?>">
        <div class="mobile-nav-inner">
            <ul class="mobile-menu">
                <!-- Works (Direct Link) -->
                <li class="mobile-menu-item">
                    <a href="<?php echo esc_url(home_url('/works')); ?>"><?php esc_html_e('Works', 'bfluxco'); ?></a>
                </li>

                <!-- Products (Direct Link) -->
                <li class="mobile-menu-item">
                    <a href="<?php echo esc_url(home_url('/products')); ?>"><?php esc_html_e('Products', 'bfluxco'); ?></a>
                </li>

                <!-- Services (Accordion) -->
                <li class="mobile-menu-item has-submenu">
                    <button class="mobile-menu-toggle" aria-expanded="false">
                        <span><?php esc_html_e('Services', 'bfluxco'); ?></span>
                        <svg class="mobile-menu-chevron" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M6 9l6 6 6-6"/>
                        </svg>
                    </button>
                    <ul class="mobile-submenu">
                        <li><a href="<?php echo esc_url(home_url('/services')); ?>"><?php esc_html_e('Overview', 'bfluxco'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/services/experience-design')); ?>"><?php esc_html_e('Experience Design', 'bfluxco'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/services/genai-experience-architecture')); ?>"><?php esc_html_e('GenAI Experience Architecture', 'bfluxco'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/services/customer-research')); ?>"><?php esc_html_e('Customer Research', 'bfluxco'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/services/digital-twins')); ?>"><?php esc_html_e('Digital Twins', 'bfluxco'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/services/conversation-design')); ?>"><?php esc_html_e('Conversation Design', 'bfluxco'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/services/workshops')); ?>"><?php esc_html_e('Workshops', 'bfluxco'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/transformation')); ?>"><?php esc_html_e('Team Transformation', 'bfluxco'); ?></a></li>
                    </ul>
                </li>

                <!-- About (Accordion) -->
                <li class="mobile-menu-item has-submenu">
                    <button class="mobile-menu-toggle" aria-expanded="false">
                        <span><?php esc_html_e('About', 'bfluxco'); ?></span>
                        <svg class="mobile-menu-chevron" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M6 9l6 6 6-6"/>
                        </svg>
                    </button>
                    <ul class="mobile-submenu">
                        <li><a href="<?php echo esc_url(home_url('/about')); ?>"><?php esc_html_e('Overview', 'bfluxco'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/about/ray')); ?>"><?php esc_html_e('Ray Butler', 'bfluxco'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/about/bfl')); ?>"><?php esc_html_e('Big Freight Life', 'bfluxco'); ?></a></li>
                    </ul>
                </li>

                <!-- Support (Direct Link) -->
                <li class="mobile-menu-item">
                    <a href="<?php echo esc_url(home_url('/support')); ?>"><?php esc_html_e('Support', 'bfluxco'); ?></a>
                </li>
            </ul>

            <!-- Mobile CTA -->
            <div class="mobile-nav-cta">
                <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-primary btn-block">
                    <?php esc_html_e('Contact', 'bfluxco'); ?>
                </a>
            </div>

            <!-- Mobile Utility Links -->
            <div class="mobile-nav-utility">
                <a href="<?php echo esc_url(home_url('/privacy')); ?>"><?php esc_html_e('Privacy', 'bfluxco'); ?></a>
                <a href="<?php echo esc_url(home_url('/terms')); ?>"><?php esc_html_e('Terms', 'bfluxco'); ?></a>
            </div>
        </div>
    </nav><!-- #mobile-navigation -->
    <?php endif; ?>

</header><!-- #site-header -->
