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
	false !== strpos($request_uri, '/works') ||
	is_singular('case_study')
);
$is_products  = (
	false !== strpos($request_uri, '/products') ||
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
			<path d="M17 2H7a2 2 0 00-2 2v18h4v-4h6v4h4V4a2 2 0 00-2-2zM9 14H7v-2h2v2zm0-4H7V8h2v2zm0-4H7V4h2v2zm4 8h-2v-2h2v2zm0-4h-2V8h2v2zm0-4h-2V4h2v2zm4 8h-2v-2h2v2zm0-4h-2V8h2v2zm0-4h-2V4h2v2z"/>
		</svg>
		<span class="mobile-tab-bar__label"><?php esc_html_e('Home', 'bfluxco'); ?></span>
	</a>

	<a href="<?php echo esc_url(home_url('/blog')); ?>" class="mobile-tab-bar__tab<?php echo $is_blog ? ' is-active' : ''; ?>"<?php echo $is_blog ? ' aria-current="page"' : ''; ?>>
		<svg class="mobile-tab-bar__icon" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
			<path d="M19 2H5a2 2 0 00-2 2v16a2 2 0 002 2h14a2 2 0 002-2V4a2 2 0 00-2-2zM7 4h2v2H7V4zm-2 6h14v10H5V10zm2-2h2v.01H7V8zm6 4h4v2h-4v-2zm0 4h4v2h-4v-2zM5 4h.01v2H5V4zm0 4h14v.01H5V8zM7 12h4v6H7v-6z"/>
		</svg>
		<span class="mobile-tab-bar__label"><?php esc_html_e('Blog', 'bfluxco'); ?></span>
	</a>

	<a href="<?php echo esc_url(home_url('/works')); ?>" class="mobile-tab-bar__tab<?php echo $is_work ? ' is-active' : ''; ?>"<?php echo $is_work ? ' aria-current="page"' : ''; ?>>
		<svg class="mobile-tab-bar__icon" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
			<path d="M20 7h-3V5a3 3 0 00-3-3h-4a3 3 0 00-3 3v2H4a2 2 0 00-2 2v2h20V9a2 2 0 00-2-2zM9 5a1 1 0 011-1h4a1 1 0 011 1v2H9V5zM2 13v7a2 2 0 002 2h16a2 2 0 002-2v-7H2z"/>
		</svg>
		<span class="mobile-tab-bar__label"><?php esc_html_e('Works', 'bfluxco'); ?></span>
	</a>

	<a href="<?php echo esc_url(home_url('/contact')); ?>" class="mobile-tab-bar__tab<?php echo $is_contact ? ' is-active' : ''; ?>"<?php echo $is_contact ? ' aria-current="page"' : ''; ?>>
		<svg class="mobile-tab-bar__icon" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
			<path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10h5v-2h-5c-4.34 0-8-3.66-8-8s3.66-8 8-8 8 3.66 8 8v1.43c0 .79-.71 1.57-1.5 1.57S17 14.22 17 13.43V12c0-2.76-2.24-5-5-5s-5 2.24-5 5 2.24 5 5 5c1.38 0 2.64-.56 3.54-1.47.65.89 1.77 1.47 2.96 1.47 1.97 0 3.5-1.6 3.5-3.57V12c0-5.52-4.48-10-10-10zm0 13c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"/>
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
