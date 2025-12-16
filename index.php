<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (along with style.css).
 * It is used to display a page when nothing more specific matches a query.
 *
 * @package BFLUXCO
 *
 * PRO TIP: WordPress uses a "template hierarchy" to decide which
 * template file to use. If no more specific template exists, it falls
 * back to index.php. Learn more: https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

get_header();
?>

<main id="main-content" class="site-main">

    <?php if (have_posts()) : ?>

        <div class="container">

            <?php if (is_home() && !is_front_page()) : ?>
                <header class="page-header">
                    <h1 class="page-title"><?php single_post_title(); ?></h1>
                </header>
            <?php endif; ?>

            <div class="posts-grid grid grid-3">

                <?php
                /* Start the Loop */
                while (have_posts()) :
                    the_post();

                    /*
                     * Include the Post-Type-specific template for the content.
                     * If you want to override this in a child theme, then include a file
                     * called content-___.php (where ___ is the Post Type name) and that will be used instead.
                     */
                    get_template_part('template-parts/content', get_post_type());

                endwhile;
                ?>

            </div><!-- .posts-grid -->

            <?php
            // Pagination
            the_posts_pagination(array(
                'mid_size'  => 2,
                'prev_text' => __('&larr; Previous', 'bfluxco'),
                'next_text' => __('Next &rarr;', 'bfluxco'),
            ));
            ?>

        </div><!-- .container -->

    <?php else : ?>

        <?php get_template_part('template-parts/content', 'none'); ?>

    <?php endif; ?>

</main><!-- #main-content -->

<?php
get_footer();
