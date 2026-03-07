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

                <!-- The Work Column -->
                <div class="footer-nav-col">
                    <h4 class="footer-nav-title"><?php esc_html_e('THE WORK', 'bfluxco'); ?></h4>
                    <ul class="footer-nav-list">
                        <li><a href="<?php echo esc_url(home_url('/works/case-studies')); ?>"><?php esc_html_e('Case Studies', 'bfluxco'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/works/workshops')); ?>"><?php esc_html_e('Workshops', 'bfluxco'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/works/products')); ?>"><?php esc_html_e('Products', 'bfluxco'); ?></a></li>
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
    <!-- Large Brand Text (Homepage only) - Stroke Draw Animation -->
    <div class="footer-brand-large">
        <div class="container">
            <svg class="footer-brand-svg" viewBox="0 0 1400 220" preserveAspectRatio="xMidYMid meet" aria-label="Big Freight Life">
                <text class="brand-text-stroke" x="50%" y="55%" dominant-baseline="middle" text-anchor="middle">
                    Big Freight Life
                </text>
            </svg>
        </div>
    </div>
    <?php endif; ?>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="container">
            <div class="footer-bottom-inner">
                <div class="footer-copyright">
                    <?php bloginfo('name'); ?>
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

<?php
wp_footer();
?>

<script>
// Remove preload class after page is ready to enable transitions
// Small delay ensures styles are fully applied first
requestAnimationFrame(function() {
    requestAnimationFrame(function() {
        document.body.classList.remove('preload');
    });
});
</script>

</body>
</html>
