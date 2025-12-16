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
     * wp_head() outputs essential WordPress scripts, styles, and meta tags.
     * NEVER remove this - it's required for WordPress and plugins to work.
     */
    wp_head();
    ?>
</head>

<body <?php body_class(); ?>>

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
    if (strpos($template, 'template-case-study-') !== false) {
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
                    <li class="menu-item">
                        <a href="<?php echo esc_url(home_url('/blog')); ?>"><?php esc_html_e('Blogs', 'bfluxco'); ?></a>
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
                        <li><a href="<?php echo esc_url(home_url('/support')); ?>"><?php esc_html_e('Support', 'bfluxco'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-tertiary btn-sm"><?php esc_html_e('Contact', 'bfluxco'); ?></a></li>
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
    <?php get_template_part('template-parts/megamenu-services'); ?>
    <?php get_template_part('template-parts/megamenu-about'); ?>
    <?php get_template_part('template-parts/navigation-mobile'); ?>
    <?php endif; ?>

</header><!-- #site-header -->
