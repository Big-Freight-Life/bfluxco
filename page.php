<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @package BFLUXCO
 *
 * PRO TIP: In WordPress, "Pages" are different from "Posts".
 * Pages are for static content like About, Contact, etc.
 * Posts are for blog entries and time-based content.
 */

get_header();
?>

<main id="main-content" class="site-main">

    <?php while (have_posts()) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <?php
            get_template_part('template-parts/page-header', null, array(
                'show_animations' => false,
            ));
            ?>

            <!-- Page Content -->
            <div class="page-content section">
                <div class="container">
                    <div class="content-wrapper">
                        <?php
                        the_content();

                        // If the page is split into multiple pages with <!--nextpage-->
                        wp_link_pages(array(
                            'before' => '<div class="page-links">' . esc_html__('Pages:', 'bfluxco'),
                            'after'  => '</div>',
                        ));
                        ?>
                    </div>
                </div>
            </div><!-- .page-content -->

        </article><!-- #post-<?php the_ID(); ?> -->

        <?php
        // If comments are open or we have at least one comment, load up the comment template.
        if (comments_open() || get_comments_number()) :
            comments_template();
        endif;
        ?>

    <?php endwhile; ?>

</main><!-- #main-content -->

<?php
get_footer();
