<?php
/**
 * The template for displaying search results pages
 *
 * @package BFLUXCO
 */

get_header();
?>

<main id="main-content" class="site-main">

    <!-- Search Header -->
    <header class="page-header">
        <div class="container">
            <h1 class="page-title">
                <?php
                printf(
                    esc_html__('Search Results for: %s', 'bfluxco'),
                    '<span>' . esc_html( get_search_query() ) . '</span>'
                );
                ?>
            </h1>
        </div>
    </header><!-- .page-header -->

    <!-- Search Results -->
    <section class="section">
        <div class="container">

            <?php if (have_posts()) : ?>

                <div class="search-results-count mb-6 text-gray-600">
                    <?php
                    global $wp_query;
                    printf(
                        esc_html(_n('%d result found', '%d results found', $wp_query->found_posts, 'bfluxco')),
                        $wp_query->found_posts
                    );
                    ?>
                </div>

                <div class="search-results grid grid-2">

                    <?php while (have_posts()) : the_post(); ?>

                        <article id="post-<?php the_ID(); ?>" <?php post_class('card'); ?>>

                            <?php if (has_post_thumbnail()) : ?>
                                <div class="card-image">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('card-thumbnail'); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <div class="card-content">

                                <!-- Post Type Label -->
                                <span class="post-type-label text-sm text-primary mb-2" style="display: inline-block;">
                                    <?php
                                    $post_type_obj = get_post_type_object(get_post_type());
                                    echo esc_html($post_type_obj->labels->singular_name);
                                    ?>
                                </span>

                                <h2 class="card-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>

                                <p class="card-description text-gray-600">
                                    <?php echo bfluxco_truncate(get_the_excerpt(), 120); ?>
                                </p>

                                <a href="<?php the_permalink(); ?>" class="link">
                                    <?php esc_html_e('Read More', 'bfluxco'); ?> &rarr;
                                </a>

                            </div>

                        </article>

                    <?php endwhile; ?>

                </div>

                <?php
                the_posts_pagination(array(
                    'mid_size'  => 2,
                    'prev_text' => __('&larr; Previous', 'bfluxco'),
                    'next_text' => __('Next &rarr;', 'bfluxco'),
                ));
                ?>

            <?php else : ?>

                <div class="no-results text-center py-8">
                    <h2><?php esc_html_e('Nothing Found', 'bfluxco'); ?></h2>
                    <p class="text-gray-600 mb-6">
                        <?php esc_html_e('Sorry, no results matched your search. Try different keywords.', 'bfluxco'); ?>
                    </p>
                    <?php get_search_form(); ?>
                </div>

            <?php endif; ?>

            <!-- Search Again -->
            <div class="search-again mt-8 p-6 bg-gray-50 rounded-lg">
                <h3 class="mb-4"><?php esc_html_e('Search Again', 'bfluxco'); ?></h3>
                <?php get_search_form(); ?>
            </div>

        </div>
    </section>

</main><!-- #main-content -->

<?php
get_footer();
