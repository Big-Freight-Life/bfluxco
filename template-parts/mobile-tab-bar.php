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
		<svg class="mobile-tab-bar__icon" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
			<path d="M12.71 2.29a1 1 0 00-1.42 0l-9 9a1 1 0 001.42 1.42L4 12.41V20a2 2 0 002 2h4v-5a1 1 0 011-1h2a1 1 0 011 1v5h4a2 2 0 002-2v-7.59l.29.3a1 1 0 001.42-1.42l-9-9z"/>
		</svg>
		<span class="mobile-tab-bar__label"><?php esc_html_e('Home', 'bfluxco'); ?></span>
	</a>

	<a href="<?php echo esc_url(home_url('/works')); ?>" class="mobile-tab-bar__tab<?php echo $is_work ? ' is-active' : ''; ?>"<?php echo $is_work ? ' aria-current="page"' : ''; ?>>
		<svg class="mobile-tab-bar__icon" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
			<path d="M20 7h-3V5a3 3 0 00-3-3h-4a3 3 0 00-3 3v2H4a2 2 0 00-2 2v2h20V9a2 2 0 00-2-2zM9 5a1 1 0 011-1h4a1 1 0 011 1v2H9V5zM2 13v7a2 2 0 002 2h16a2 2 0 002-2v-7H2z"/>
		</svg>
		<span class="mobile-tab-bar__label"><?php esc_html_e('Work', 'bfluxco'); ?></span>
	</a>

	<a href="<?php echo esc_url(home_url('/blog')); ?>" class="mobile-tab-bar__tab<?php echo $is_blog ? ' is-active' : ''; ?>"<?php echo $is_blog ? ' aria-current="page"' : ''; ?>>
		<svg class="mobile-tab-bar__icon" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
			<path d="M19 2H5a2 2 0 00-2 2v16a2 2 0 002 2h14a2 2 0 002-2V4a2 2 0 00-2-2zM7 4h2v2H7V4zm-2 6h14v10H5V10zm2-2h2v.01H7V8zm6 4h4v2h-4v-2zm0 4h4v2h-4v-2zM5 4h.01v2H5V4zm0 4h14v.01H5V8zM7 12h4v6H7v-6z"/>
		</svg>
		<span class="mobile-tab-bar__label"><?php esc_html_e('Blog', 'bfluxco'); ?></span>
	</a>

	<a href="<?php echo esc_url(home_url('/contact')); ?>" class="mobile-tab-bar__tab<?php echo $is_contact ? ' is-active' : ''; ?>"<?php echo $is_contact ? ' aria-current="page"' : ''; ?>>
		<svg class="mobile-tab-bar__icon" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
			<path d="M20 4H4a2 2 0 00-2 2v12a2 2 0 002 2h16a2 2 0 002-2V6a2 2 0 00-2-2zm-1.2 2L12 11.26 5.2 6h13.6zM4 18V8.21l7.45 5.67a1 1 0 001.1 0L20 8.21V18H4z"/>
		</svg>
		<span class="mobile-tab-bar__label"><?php esc_html_e('Contact', 'bfluxco'); ?></span>
	</a>

	<button type="button" class="mobile-tab-bar__tab mobile-tab-bar__tab--more" aria-expanded="false" aria-controls="mobile-drawer" aria-label="<?php esc_attr_e('Toggle navigation menu', 'bfluxco'); ?>">
		<svg class="mobile-tab-bar__icon" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
			<rect x="3" y="4" width="18" height="2.5" rx="1.25"/>
			<rect x="3" y="10.75" width="18" height="2.5" rx="1.25"/>
			<rect x="3" y="17.5" width="18" height="2.5" rx="1.25"/>
		</svg>
		<span class="mobile-tab-bar__label"><?php esc_html_e('More', 'bfluxco'); ?></span>
	</button>
</nav><!-- #mobile-tab-bar -->
