<?php
/**
 * Template part for footer content
 *
 * Used when footer needs to be included within a wrapper (e.g., shared background)
 *
 * @package BFLUXCO
 */
?>

<footer id="site-footer" class="site-footer site-footer--transparent">

    <!-- Footer Navigation -->
    <div class="footer-nav-section">
        <div class="container">
            <div class="footer-nav-grid">

                <!-- Works Column -->
                <div class="footer-nav-col">
                    <h4 class="footer-nav-title"><?php esc_html_e('Works', 'bfluxco'); ?></h4>
                    <ul class="footer-nav-list">
                        <li><a href="<?php echo esc_url(home_url('/work/case-studies')); ?>"><?php esc_html_e('Case Studies', 'bfluxco'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/work/products')); ?>"><?php esc_html_e('Products', 'bfluxco'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/work/methodology')); ?>"><?php esc_html_e('Methodology', 'bfluxco'); ?></a></li>
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
                </div>
            </div>
        </div>
    </div>

</footer><!-- #site-footer -->
