<?php
/**
 * The template for displaying single posts
 *
 * This template is used for single blog posts.
 * For custom post types like case studies, workshops, and products,
 * see single-case_study.php, single-workshop.php, etc.
 *
 * @package BFLUXCO
 */

get_header();
?>

<main id="main-content" class="site-main">

    <?php while (have_posts()) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <!-- Article Header -->
            <header class="article-header section bg-gray-50">
                <div class="container">
                    <div class="max-w-3xl mx-auto">

                        <?php bfluxco_breadcrumbs(); ?>

                        <!-- Categories -->
                        <?php if (has_category()) : ?>
                            <div class="article-categories mb-4">
                                <?php the_category(' '); ?>
                            </div>
                        <?php endif; ?>

                        <h1 class="article-title"><?php the_title(); ?></h1>

                        <!-- Article Meta -->
                        <div class="article-meta flex items-center gap-4 text-gray-500">
                            <time datetime="<?php echo get_the_date('c'); ?>">
                                <?php echo get_the_date(); ?>
                            </time>
                            <span>&middot;</span>
                            <span><?php printf(esc_html__('%d min read', 'bfluxco'), bfluxco_reading_time()); ?></span>
                        </div>

                    </div>
                </div>
            </header><!-- .article-header -->

            <!-- Featured Image -->
            <?php if (has_post_thumbnail()) : ?>
                <div class="article-featured-image">
                    <div class="container">
                        <?php the_post_thumbnail('hero-image', array('class' => 'rounded-lg')); ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Article Content -->
            <div class="article-content section">
                <div class="container">
                    <div class="content-wrapper max-w-3xl mx-auto">
                        <?php
                        the_content();

                        wp_link_pages(array(
                            'before' => '<div class="page-links">' . esc_html__('Pages:', 'bfluxco'),
                            'after'  => '</div>',
                        ));
                        ?>
                    </div>
                </div>
            </div><!-- .article-content -->

            <!-- Article Footer -->
            <footer class="article-footer section bg-gray-50">
                <div class="container">
                    <div class="max-w-3xl mx-auto">

                        <!-- Tags -->
                        <?php if (has_tag()) : ?>
                            <div class="article-tags mb-6">
                                <strong><?php esc_html_e('Tags:', 'bfluxco'); ?></strong>
                                <?php the_tags('', ', ', ''); ?>
                            </div>
                        <?php endif; ?>

                        <!-- Share Links -->
                        <div class="article-share mb-6">
                            <strong><?php esc_html_e('Share:', 'bfluxco'); ?></strong>
                            <?php bfluxco_social_share(); ?>
                        </div>

                        <!-- Post Navigation -->
                        <nav class="post-navigation">
                            <?php
                            the_post_navigation(array(
                                'prev_text' => '<span class="nav-subtitle">' . esc_html__('Previous:', 'bfluxco') . '</span> <span class="nav-title">%title</span>',
                                'next_text' => '<span class="nav-subtitle">' . esc_html__('Next:', 'bfluxco') . '</span> <span class="nav-title">%title</span>',
                            ));
                            ?>
                        </nav>

                    </div>
                </div>
            </footer><!-- .article-footer -->

        </article><!-- #post-<?php the_ID(); ?> -->

        <?php
        // Comments
        if (comments_open() || get_comments_number()) :
            comments_template();
        endif;
        ?>

    <?php endwhile; ?>

</main><!-- #main-content -->

<?php
get_footer();
