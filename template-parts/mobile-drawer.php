<?php
/**
 * Template part for the mobile "More" drawer
 *
 * Slides up from the bottom tab bar on mobile. Contains navigation links
 * not in the tab bar, a theme toggle, and utility links.
 *
 * @package BFLUXCO
 */
?>
<!-- Mobile Drawer Backdrop -->
<div class="mobile-drawer-backdrop" id="mobile-drawer-backdrop"></div>

<!-- Mobile Drawer -->
<div class="mobile-drawer" id="mobile-drawer" role="dialog" aria-modal="true" aria-hidden="true" aria-label="<?php esc_attr_e('More menu', 'bfluxco'); ?>">
    <div class="mobile-drawer-handle"></div>
    <div class="mobile-drawer-content">

        <!-- Navigation Links -->
        <nav class="mobile-drawer-nav" aria-label="<?php esc_attr_e('Drawer Navigation', 'bfluxco'); ?>">
            <ul class="mobile-drawer-list">
                <!-- Products -->
                <?php
                $request_uri = isset($_SERVER['REQUEST_URI']) ? sanitize_text_field(wp_unslash($_SERVER['REQUEST_URI'])) : '';
                $is_products_active = (false !== strpos($request_uri, '/products') || is_singular('product'));
                ?>
                <li class="mobile-drawer-item<?php echo $is_products_active ? ' is-active' : ''; ?>">
                    <a href="<?php echo esc_url(home_url('/products')); ?>" class="mobile-drawer-link<?php echo $is_products_active ? ' is-active' : ''; ?>">
                        <svg class="mobile-drawer-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
                            <line x1="3" y1="6" x2="21" y2="6"/>
                            <path d="M16 10a4 4 0 01-8 0"/>
                        </svg>
                        <span><?php esc_html_e('Products', 'bfluxco'); ?></span>
                    </a>
                </li>

                <!-- About (with sub-items) -->
                <li class="mobile-drawer-item has-children">
                    <a href="<?php echo esc_url(home_url('/about')); ?>" class="mobile-drawer-link">
                        <svg class="mobile-drawer-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                        <span><?php esc_html_e('About', 'bfluxco'); ?></span>
                    </a>
                    <ul class="mobile-drawer-sublist">
                        <li class="mobile-drawer-subitem">
                            <a href="<?php echo esc_url(home_url('/about')); ?>" class="mobile-drawer-sublink">
                                <?php esc_html_e('About Us', 'bfluxco'); ?>
                            </a>
                        </li>
                        <li class="mobile-drawer-subitem">
                            <a href="<?php echo esc_url(home_url('/clients')); ?>" class="mobile-drawer-sublink">
                                <?php esc_html_e('Who We Serve', 'bfluxco'); ?>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Support -->
                <li class="mobile-drawer-item">
                    <a href="<?php echo esc_url(home_url('/support')); ?>" class="mobile-drawer-link">
                        <svg class="mobile-drawer-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <circle cx="12" cy="12" r="4"/>
                            <line x1="4.93" y1="4.93" x2="9.17" y2="9.17"/>
                            <line x1="14.83" y1="14.83" x2="19.07" y2="19.07"/>
                            <line x1="14.83" y1="9.17" x2="19.07" y2="4.93"/>
                            <line x1="4.93" y1="19.07" x2="9.17" y2="14.83"/>
                        </svg>
                        <span><?php esc_html_e('Support', 'bfluxco'); ?></span>
                    </a>
                </li>

                <!-- Transformation -->
                <li class="mobile-drawer-item">
                    <a href="<?php echo esc_url(home_url('/transformation')); ?>" class="mobile-drawer-link">
                        <svg class="mobile-drawer-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="23 4 23 10 17 10"/>
                            <polyline points="1 20 1 14 7 14"/>
                            <path d="M3.51 9a9 9 0 0114.85-3.36L23 10"/>
                            <path d="M20.49 15a9 9 0 01-14.85 3.36L1 14"/>
                        </svg>
                        <span><?php esc_html_e('Transformation', 'bfluxco'); ?></span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Utility Links -->
        <div class="mobile-drawer-utility">
            <a href="<?php echo esc_url(home_url('/privacy')); ?>" class="mobile-drawer-utility-link">
                <?php esc_html_e('Privacy', 'bfluxco'); ?>
            </a>
            <a href="<?php echo esc_url(home_url('/terms')); ?>" class="mobile-drawer-utility-link">
                <?php esc_html_e('Terms', 'bfluxco'); ?>
            </a>
        </div>

    </div>
</div><!-- #mobile-drawer -->
