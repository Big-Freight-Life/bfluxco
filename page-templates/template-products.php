<?php
/**
 * Template Name: Products
 * Template Post Type: page
 *
 * This template displays the Products archive page.
 * URL: /work/products
 *
 * @package BFLUXCO
 */

get_header();
?>

<main id="main-content" class="site-main">

    <!-- Products Hero Section -->
    <header class="page-hero page-hero--products">
        <div class="page-hero-bg" style="background-image: url('<?php echo esc_url(home_url('/wp-content/uploads/2026/01/envato-labs-image-edit-11-scaled.png')); ?>');"></div>
        <div class="page-hero-overlay"></div>
        <div class="page-hero-content">
            <div class="container">
                <h1 class="page-hero-title reveal-hero"><?php the_title(); ?></h1>
                <p class="page-hero-description reveal" data-delay="1">
                    <?php esc_html_e('Tools, templates, and apps for everyday life and work.', 'bfluxco'); ?>
                </p>
            </div>
        </div>
    </header><!-- .page-hero -->

    <!-- Products Grid -->
    <section class="section products-section">
        <div class="container">
            <?php
            $products = new WP_Query(array(
                'post_type'      => 'product',
                'posts_per_page' => -1,
                'orderby'        => 'menu_order',
                'order'          => 'ASC',
            ));

            if ($products->have_posts()) :
            ?>
            <div class="products-grid">
                <?php
                $index = 0;
                while ($products->have_posts()) : $products->the_post();
                    $index++;
                    get_template_part('template-parts/card-product', null, array('index' => $index));
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
            <?php else : ?>
            <!-- Placeholder Products -->
            <div class="products-grid">
                <?php
                $placeholder_products = array(
                    array(
                        'type' => 'iOS App',
                        'title' => 'Low Ox Life',
                        'excerpt' => 'Browse the Harvard 2023 Oxalate Table for free. Upgrade for food logging, journal history, and cloud sync.',
                        'price' => 'Download for free',
                        'url' => home_url('/products/low-ox-life'),
                        'image' => '/wp-content/uploads/2026/01/lowOxLife-foods.png',
                        'image_class' => 'product-image--phone'
                    ),
                    array(
                        'type' => 'Template',
                        'title' => 'Design System Starter Kit',
                        'excerpt' => 'A comprehensive Figma library with components, tokens, and documentation to kickstart your design system.',
                        'price' => '$149'
                    ),
                    array(
                        'type' => 'Framework',
                        'title' => 'Strategy Canvas Bundle',
                        'excerpt' => 'A collection of strategic planning templates including vision boards, roadmaps, and prioritization matrices.',
                        'price' => '$79'
                    ),
                    array(
                        'type' => 'Guide',
                        'title' => 'Workshop Facilitation Guide',
                        'excerpt' => 'Step-by-step playbooks for running effective design sprints, strategy sessions, and team workshops.',
                        'price' => '$49'
                    ),
                    array(
                        'type' => 'Template',
                        'title' => 'Brand Guidelines Template',
                        'excerpt' => 'A professional brand book template with sections for voice, visual identity, and usage guidelines.',
                        'price' => '$99'
                    ),
                    array(
                        'type' => 'Tool',
                        'title' => 'Research Repository',
                        'excerpt' => 'A Notion-based system for organizing user research, insights, and findings across projects.',
                        'price' => '$59'
                    ),
                    array(
                        'type' => 'Course',
                        'title' => 'Design Leadership Essentials',
                        'excerpt' => 'Self-paced video course covering the fundamentals of leading design teams and organizations.',
                        'price' => '$299'
                    ),
                );

                $index = 0;
                foreach ($placeholder_products as $product) :
                    $index++;
                ?>
                <?php
                $product_url = isset($product['url']) ? $product['url'] : '#';
                $is_external = isset($product['url']) && strpos($product['url'], 'http') === 0;
                $link_target = $is_external ? ' target="_blank" rel="noopener"' : '';
                ?>
                <?php $image_class = isset($product['image_class']) ? ' ' . $product['image_class'] : ''; ?>
                <article class="product-card reveal-up" data-delay="<?php echo min($index, 4); ?>">
                    <a href="<?php echo esc_url($product_url); ?>"<?php echo $link_target; ?> class="product-card-inner">
                        <div class="product-image<?php echo esc_attr($image_class); ?>">
                            <?php if (!empty($product['image'])) : ?>
                                <img src="<?php echo esc_url($product['image']); ?>" alt="<?php echo esc_attr($product['title']); ?>">
                            <?php else : ?>
                                <div class="product-placeholder"></div>
                            <?php endif; ?>
                        </div>
                        <div class="product-content">
                            <span class="product-type"><?php echo esc_html($product['type']); ?></span>
                            <h2 class="product-title"><?php echo esc_html($product['title']); ?></h2>
                            <p class="product-excerpt"><?php echo esc_html($product['excerpt']); ?></p>
                            <div class="product-footer">
                                <span class="product-price"><?php echo esc_html($product['price']); ?></span>
                                <span class="product-link">
                                    <?php esc_html_e('Learn more', 'bfluxco'); ?>
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M9 18l6-6-6-6"/>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </a>
                </article>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </section><!-- Products Grid -->

    <!-- Featured Product -->
    <section class="section bg-gray-50">
        <div class="container">
            <div class="featured-product reveal-scale">
                <div class="featured-product-inner grid grid-2 items-center gap-12">
                    <div class="featured-product-image">
                        <div class="featured-product-placeholder"></div>
                        <div class="particle-logo-overlay">
                            <canvas id="featured-particle-canvas"></canvas>
                        </div>
                    </div>
                    <div class="featured-product-content">
                        <span class="featured-product-badge"><?php esc_html_e('Featured', 'bfluxco'); ?></span>
                        <h2 class="featured-product-title"><?php esc_html_e('The Complete Design Toolkit', 'bfluxco'); ?></h2>
                        <p class="featured-product-desc">
                            <?php esc_html_e('Everything you need to run a professional design practice. Includes all templates, frameworks, and guides in one comprehensive package.', 'bfluxco'); ?>
                        </p>
                        <ul class="featured-product-features">
                            <li><?php esc_html_e('Design System Starter Kit', 'bfluxco'); ?></li>
                            <li><?php esc_html_e('Strategy Canvas Bundle', 'bfluxco'); ?></li>
                            <li><?php esc_html_e('Workshop Facilitation Guide', 'bfluxco'); ?></li>
                            <li><?php esc_html_e('Lifetime updates included', 'bfluxco'); ?></li>
                        </ul>
                        <div class="featured-product-cta">
                            <span class="featured-product-price"><?php esc_html_e('$399', 'bfluxco'); ?> <small><?php esc_html_e('(Save $127)', 'bfluxco'); ?></small></span>
                            <a href="#" class="btn btn-primary"><?php esc_html_e('Get the Toolkit', 'bfluxco'); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- Featured Product -->

    <!-- FAQ Section -->
    <section class="section">
        <div class="container">
            <header class="section-header text-center mb-12 reveal-text">
                <h2><?php esc_html_e('Frequently Asked Questions', 'bfluxco'); ?></h2>
            </header>

            <div class="faq-list max-w-3xl mx-auto">
                <div class="faq-item reveal-up" data-delay="1">
                    <h3 class="faq-question"><?php esc_html_e('What format are the templates in?', 'bfluxco'); ?></h3>
                    <p class="faq-answer"><?php esc_html_e('Templates are available in Figma, Notion, and PDF formats depending on the product. Each listing specifies the included formats.', 'bfluxco'); ?></p>
                </div>
                <div class="faq-item reveal-up" data-delay="2">
                    <h3 class="faq-question"><?php esc_html_e('Do you offer team licenses?', 'bfluxco'); ?></h3>
                    <p class="faq-answer"><?php esc_html_e('Yes, team licenses are available for organizations. Contact us for volume pricing and custom licensing options.', 'bfluxco'); ?></p>
                </div>
                <div class="faq-item reveal-up" data-delay="3">
                    <h3 class="faq-question"><?php esc_html_e('Are updates included?', 'bfluxco'); ?></h3>
                    <p class="faq-answer"><?php esc_html_e('All products include free updates for the lifetime of the product. You will receive notifications when new versions are available.', 'bfluxco'); ?></p>
                </div>
            </div>
        </div>
    </section><!-- FAQ -->

    <?php
    get_template_part('template-parts/section-cta', null, array(
        'heading' => __('Need Something Custom?', 'bfluxco'),
        'description' => __("If you need a custom solution or have specific requirements, let's talk.", 'bfluxco'),
        'button_text' => __('Get in Touch', 'bfluxco'),
    ));
    ?>

</main><!-- #main-content -->

<?php
get_footer();
