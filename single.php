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

                    </div>
                </div>
            </footer><!-- .article-footer -->

        </article><!-- #post-<?php the_ID(); ?> -->

    <?php endwhile; ?>

    <!-- Related Articles -->
    <?php
    $related = new WP_Query(array(
        'post_type' => 'post',
        'posts_per_page' => 3,
        'post__not_in' => array(get_the_ID()),
        'orderby' => 'date',
        'order' => 'DESC',
    ));

    if ($related->have_posts()) :
    ?>
        <section class="related-articles section bg-gray-50" style="padding-top: var(--spacing-8);">
            <div class="container">
                <h2 class="text-center mb-8"><?php esc_html_e('More Articles', 'bfluxco'); ?></h2>
                <div class="blog-archive-grid" style="max-width: 1000px; margin: 0 auto;">
                    <?php
                    while ($related->have_posts()) : $related->the_post();
                        $categories = get_the_category();
                    ?>
                    <article class="blog-archive-card">
                        <a href="<?php the_permalink(); ?>" class="blog-archive-card-inner">
                            <div class="blog-archive-card-image">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('medium_large'); ?>
                                <?php else : ?>
                                    <div class="blog-archive-card-placeholder">
                                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/>
                                            <polyline points="14 2 14 8 20 8"/>
                                            <line x1="16" y1="13" x2="8" y2="13"/>
                                            <line x1="16" y1="17" x2="8" y2="17"/>
                                            <line x1="10" y1="9" x2="8" y2="9"/>
                                        </svg>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="blog-archive-card-content">
                                <?php if ($categories) : ?>
                                    <span class="blog-archive-card-category"><?php echo esc_html($categories[0]->name); ?></span>
                                <?php endif; ?>
                                <h3 class="blog-archive-card-title"><?php the_title(); ?></h3>
                                <p class="blog-archive-card-excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 15)); ?></p>
                                <div class="blog-archive-card-meta">
                                    <span class="blog-archive-card-date"><?php echo get_the_date('M j, Y'); ?></span>
                                    <span class="blog-archive-card-readtime"><?php echo bfluxco_reading_time(); ?></span>
                                </div>
                            </div>
                        </a>
                    </article>
                    <?php
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- CTA Section -->
    <section class="section text-center">
        <div class="container">
            <h2><?php esc_html_e('Want to Learn More?', 'bfluxco'); ?></h2>
            <p class="text-gray-600 max-w-2xl mx-auto mb-6">
                <?php esc_html_e("Let's discuss how strategic design can help solve your business challenges.", 'bfluxco'); ?>
            </p>
            <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-primary btn-lg">
                <?php esc_html_e('Get in Touch', 'bfluxco'); ?>
            </a>
        </div>
    </section><!-- CTA -->

</main><!-- #main-content -->

<?php
get_footer();
