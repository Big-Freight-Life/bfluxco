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
                <li class="mobile-drawer-item">
                    <a href="<?php echo esc_url(home_url('/products')); ?>" class="mobile-drawer-link">
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
                            <a href="<?php echo esc_url(home_url('/about/ray')); ?>" class="mobile-drawer-sublink">
                                <?php esc_html_e('Ray Butler', 'bfluxco'); ?>
                            </a>
                        </li>
                        <li class="mobile-drawer-subitem">
                            <a href="<?php echo esc_url(home_url('/about/bfl')); ?>" class="mobile-drawer-sublink">
                                <?php esc_html_e('Big Freight Life', 'bfluxco'); ?>
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

        <!-- Theme Toggle -->
        <div class="mobile-theme-toggle-section">
            <span class="mobile-theme-toggle-label"><?php esc_html_e('Appearance', 'bfluxco'); ?></span>
            <div class="mobile-theme-toggle" role="radiogroup" aria-label="<?php esc_attr_e('Color theme', 'bfluxco'); ?>">
                <button class="mobile-theme-toggle-btn" data-theme="light" aria-label="<?php esc_attr_e('Light mode', 'bfluxco'); ?>" role="radio" aria-checked="false">
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
                    <span><?php esc_html_e('Light', 'bfluxco'); ?></span>
                </button>
                <button class="mobile-theme-toggle-btn" data-theme="system" aria-label="<?php esc_attr_e('System preference', 'bfluxco'); ?>" role="radio" aria-checked="false">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="3" width="20" height="14" rx="2" ry="2"/>
                        <line x1="8" y1="21" x2="16" y2="21"/>
                        <line x1="12" y1="17" x2="12" y2="21"/>
                    </svg>
                    <span><?php esc_html_e('System', 'bfluxco'); ?></span>
                </button>
                <button class="mobile-theme-toggle-btn" data-theme="dark" aria-label="<?php esc_attr_e('Dark mode', 'bfluxco'); ?>" role="radio" aria-checked="false">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
                    </svg>
                    <span><?php esc_html_e('Dark', 'bfluxco'); ?></span>
                </button>
            </div>
        </div><!-- .mobile-theme-toggle-section -->

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
