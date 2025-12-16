<?php
/**
 * Template part for mobile navigation
 *
 * @package BFLUXCO
 */
?>
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
