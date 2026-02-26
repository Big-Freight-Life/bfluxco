<?php
/**
 * The footer template
 *
 * This file contains the footer and closing HTML tags.
 * It's included at the bottom of every page via get_footer().
 *
 * @package BFLUXCO
 */
?>

<footer id="site-footer" class="site-footer">

    <!-- Footer Navigation -->
    <div class="footer-nav-section">
        <div class="container">
            <div class="footer-nav-grid">

                <!-- Works Column -->
                <div class="footer-nav-col">
                    <h4 class="footer-nav-title"><?php esc_html_e('Works', 'bfluxco'); ?></h4>
                    <ul class="footer-nav-list">
                        <li><a href="<?php echo esc_url(home_url('/works/case-studies')); ?>"><?php esc_html_e('Case Studies', 'bfluxco'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/products')); ?>"><?php esc_html_e('Products', 'bfluxco'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/works/methodology')); ?>"><?php esc_html_e('Methodology', 'bfluxco'); ?></a></li>
                    </ul>
                </div>

                <!-- About Column -->
                <div class="footer-nav-col">
                    <h4 class="footer-nav-title"><?php esc_html_e('ABOUT', 'bfluxco'); ?></h4>
                    <ul class="footer-nav-list">
                        <li><a href="<?php echo esc_url(home_url('/about/ray')); ?>"><?php esc_html_e('Meet Ray Butler', 'bfluxco'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/about/bfl')); ?>"><?php esc_html_e('About Big Freight Life', 'bfluxco'); ?></a></li>
                    </ul>
                </div>

            </div>
        </div>
    </div>

    <?php if (is_front_page()) : ?>
    <!-- Large Brand Text (Homepage only) - Full-width Wordmark -->
    <div class="footer-brand-large">
        <svg class="footer-brand-svg" viewBox="0 0 1000 120" preserveAspectRatio="xMidYMid meet" role="img" aria-label="Big Freight Life">
            <text class="brand-text" x="500" y="95" text-anchor="middle">BIG FREIGHT LIFE</text>
        </svg>
    </div>
    <?php endif; ?>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="container">
            <div class="footer-bottom-inner">
                <div class="footer-copyright">
                    &copy; <?php echo esc_html(wp_date('Y')); ?> Big Freight Life LLC. All rights reserved.
                </div>
                <div class="footer-legal">
                    <a href="<?php echo esc_url(home_url('/about')); ?>"><?php esc_html_e('About', 'bfluxco'); ?></a>
                    <a href="<?php echo esc_url(home_url('/privacy')); ?>"><?php esc_html_e('Privacy', 'bfluxco'); ?></a>
                    <a href="<?php echo esc_url(home_url('/terms')); ?>"><?php esc_html_e('Terms', 'bfluxco'); ?></a>
                    <a href="<?php echo esc_url(home_url('/legal')); ?>"><?php esc_html_e('Product Policies', 'bfluxco'); ?></a>
                </div>
            </div>
        </div>
    </div>

</footer><!-- #site-footer -->

<?php
// Mobile Tab Bar & Drawer (shown on screens < 1024px via CSS, all pages)
get_template_part( 'template-parts/mobile-drawer' );
get_template_part( 'template-parts/mobile-tab-bar' );
?>

<!-- Video Modal -->
<div class="video-modal" id="video-modal" aria-hidden="true">
    <div class="video-modal-content">
        <button class="video-modal-close" aria-label="<?php esc_attr_e('Close video', 'bfluxco'); ?>">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
        <iframe id="video-iframe" src="" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
</div>

<?php
wp_footer();
?>

</body>
</html>
