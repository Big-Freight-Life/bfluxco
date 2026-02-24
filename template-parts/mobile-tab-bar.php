<?php
/**
 * Template part for mobile bottom tab bar
 *
 * Fixed navigation bar at the bottom of the screen on mobile devices.
 * Five tabs: Home, Work, Blog, Contact, More (drawer toggle).
 *
 * @package BFLUXCO
 */

// Determine active tab based on current page/context.
$request_uri  = isset($_SERVER['REQUEST_URI']) ? sanitize_text_field(wp_unslash($_SERVER['REQUEST_URI'])) : '';
$is_home      = is_front_page();
$is_work      = (
	false !== strpos($request_uri, '/work') ||
	false !== strpos($request_uri, '/products') ||
	is_singular('case_study') ||
	is_singular('product')
);
$is_blog      = (
	false !== strpos($request_uri, '/blog') ||
	false !== strpos($request_uri, '/resources') ||
	is_home() ||
	( is_single() && ! is_singular('case_study') && ! is_singular('product') )
);
$is_contact   = ( false !== strpos($request_uri, '/contact') );
?>
<!-- Mobile Tab Bar -->
<nav id="mobile-tab-bar" class="mobile-tab-bar" aria-label="<?php esc_attr_e('Mobile Tab Bar', 'bfluxco'); ?>">
	<a href="<?php echo esc_url(home_url('/')); ?>" class="mobile-tab-bar__tab<?php echo $is_home ? ' is-active' : ''; ?>"<?php echo $is_home ? ' aria-current="page"' : ''; ?>>
		<svg class="mobile-tab-bar__icon" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
			<path d="M3 10L10 3l7 7"/>
			<path d="M5 8.5V16a1 1 0 001 1h3v-4h2v4h3a1 1 0 001-1V8.5"/>
		</svg>
		<span class="mobile-tab-bar__label"><?php esc_html_e('Home', 'bfluxco'); ?></span>
	</a>

	<a href="<?php echo esc_url(home_url('/works')); ?>" class="mobile-tab-bar__tab<?php echo $is_work ? ' is-active' : ''; ?>"<?php echo $is_work ? ' aria-current="page"' : ''; ?>>
		<svg class="mobile-tab-bar__icon" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
			<rect x="2" y="7" width="16" height="10" rx="1.5"/>
			<path d="M6 7V5a2 2 0 012-2h4a2 2 0 012 2v2"/>
			<path d="M2 11h16"/>
		</svg>
		<span class="mobile-tab-bar__label"><?php esc_html_e('Work', 'bfluxco'); ?></span>
	</a>

	<a href="<?php echo esc_url(home_url('/blog')); ?>" class="mobile-tab-bar__tab<?php echo $is_blog ? ' is-active' : ''; ?>"<?php echo $is_blog ? ' aria-current="page"' : ''; ?>>
		<svg class="mobile-tab-bar__icon" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
			<rect x="2" y="2" width="16" height="16" rx="1.5"/>
			<path d="M2 7h16"/>
			<path d="M9 7v11"/>
			<path d="M5 4.5h1"/>
			<path d="M12 10h3"/>
			<path d="M12 13h3"/>
		</svg>
		<span class="mobile-tab-bar__label"><?php esc_html_e('Blog', 'bfluxco'); ?></span>
	</a>

	<a href="<?php echo esc_url(home_url('/contact')); ?>" class="mobile-tab-bar__tab<?php echo $is_contact ? ' is-active' : ''; ?>"<?php echo $is_contact ? ' aria-current="page"' : ''; ?>>
		<svg class="mobile-tab-bar__icon" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
			<rect x="2" y="4" width="16" height="12" rx="1.5"/>
			<path d="M2 5.5L10 11l8-5.5"/>
		</svg>
		<span class="mobile-tab-bar__label"><?php esc_html_e('Contact', 'bfluxco'); ?></span>
	</a>

	<button type="button" class="mobile-tab-bar__tab mobile-tab-bar__tab--more" aria-expanded="false" aria-controls="mobile-drawer" aria-label="<?php esc_attr_e('Toggle navigation menu', 'bfluxco'); ?>">
		<svg class="mobile-tab-bar__icon" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
			<path d="M3 5h14"/>
			<path d="M3 10h14"/>
			<path d="M3 15h14"/>
		</svg>
		<span class="mobile-tab-bar__label"><?php esc_html_e('More', 'bfluxco'); ?></span>
	</button>
</nav><!-- #mobile-tab-bar -->
