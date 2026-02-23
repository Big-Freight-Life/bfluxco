<?php
/**
 * The template for displaying single Product posts
 *
 * This template is automatically used for individual products.
 *
 * @package BFLUXCO
 */

get_header();
?>

<main id="main-content" class="site-main">

    <?php while (have_posts()) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class('product-single'); ?>>

            <!-- Product Header -->
            <header class="product-header section bg-gray-50">
                <div class="container">
                    <div class="max-w-3xl">

                        <?php bfluxco_breadcrumbs(); ?>

                        <!-- Product Type Badge -->
                        <?php
                        $product_type = get_post_meta(get_the_ID(), 'product_type', true);
                        if ($product_type) :
                        ?>
                            <div class="product-type-badge mb-4">
                                <span class="type-tag text-primary text-base"><?php echo esc_html($product_type); ?></span>
                            </div>
                        <?php endif; ?>

                        <h1 class="product-title"><?php the_title(); ?></h1>

                        <?php if (has_excerpt()) : ?>
                            <p class="product-subtitle text-xl text-gray-600">
                                <?php the_excerpt(); ?>
                            </p>
                        <?php endif; ?>

                        <!-- Product Meta -->
                        <div class="product-meta flex flex-wrap gap-6 mt-6">
                            <?php
                            $price = get_post_meta(get_the_ID(), 'product_price', true);
                            ?>

                            <?php if ($product_type) : ?>
                                <div class="meta-item">
                                    <span class="meta-label text-base text-gray-500"><?php esc_html_e('Type', 'bfluxco'); ?></span>
                                    <span class="meta-value font-medium"><?php echo esc_html($product_type); ?></span>
                                </div>
                            <?php endif; ?>

                            <?php if ($price) : ?>
                                <div class="meta-item">
                                    <span class="meta-label text-base text-gray-500"><?php esc_html_e('Price', 'bfluxco'); ?></span>
                                    <span class="meta-value font-medium"><?php echo esc_html($price); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            </header><!-- .product-header -->

            <!-- Featured Image -->
            <?php if (has_post_thumbnail()) : ?>
                <div class="product-hero-image">
                    <div class="container">
                        <?php the_post_thumbnail('hero-image', array('class' => 'rounded-lg')); ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Product Content -->
            <div class="product-content section">
                <div class="container">
                    <div class="content-wrapper max-w-3xl">
                        <?php the_content(); ?>
                    </div>
                </div>
            </div><!-- .product-content -->

            <!-- Product Footer -->
            <footer class="product-footer section">
                <div class="container">
                    <div class="max-w-3xl">

                        <!-- Share Links -->
                        <div class="product-share mb-8">
                            <strong><?php esc_html_e('Share:', 'bfluxco'); ?></strong>
                            <?php bfluxco_social_share(); ?>
                        </div>

                        <!-- Navigation to other products -->
                        <nav class="product-navigation">
                            <?php
                            the_post_navigation(array(
                                'prev_text' => '<span class="nav-subtitle">' . esc_html__('Previous Product', 'bfluxco') . '</span><span class="nav-title">%title</span>',
                                'next_text' => '<span class="nav-subtitle">' . esc_html__('Next Product', 'bfluxco') . '</span><span class="nav-title">%title</span>',
                                'in_same_term' => false,
                            ));
                            ?>
                        </nav>

                    </div>
                </div>
            </footer><!-- .product-footer -->

        </article><!-- #post-<?php the_ID(); ?> -->

    <?php endwhile; ?>

    <!-- Related Products -->
    <?php
    $related = new WP_Query(array(
        'post_type' => 'product',
        'posts_per_page' => 3,
        'post__not_in' => array(get_the_ID()),
        'orderby' => 'date',
        'order' => 'DESC',
    ));

    if ($related->have_posts()) :
    ?>
        <section class="related-products section bg-gray-50">
            <div class="container">
                <h2 class="text-center mb-8"><?php esc_html_e('More Products', 'bfluxco'); ?></h2>
                <div class="grid grid-3">
                    <?php
                    while ($related->have_posts()) : $related->the_post();
                        get_template_part('template-parts/card', 'product');
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
                <div class="text-center mt-8">
                    <a href="<?php echo esc_url(home_url('/products')); ?>" class="btn btn-outline">
                        <?php esc_html_e('View All Products', 'bfluxco'); ?>
                    </a>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php
    get_template_part('template-parts/section-cta', null, array(
        'heading' => __('Interested in This Product?', 'bfluxco'),
        'description' => __("Let's discuss how this product can help you.", 'bfluxco'),
        'button_text' => __('Get in Touch', 'bfluxco'),
    ));
    ?>

</main><!-- #main-content -->

<?php
get_footer();
