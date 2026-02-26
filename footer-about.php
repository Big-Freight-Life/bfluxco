<?php
/**
 * Minimal footer template for About pages
 *
 * This footer omits the standard footer content but keeps
 * the wp_footer() hook for scripts to load properly.
 *
 * @package BFLUXCO
 */
?>

<?php
// Mobile Tab Bar & Drawer (shown on screens < 1024px via CSS, all pages)
get_template_part( 'template-parts/mobile-drawer' );
get_template_part( 'template-parts/mobile-tab-bar' );

wp_footer();
?>

</body>
</html>
