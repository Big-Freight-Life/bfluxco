<?php
/**
 * Template part for displaying a product card
 *
 * @package BFLUXCO
 *
 * Usage (inside loop):
 * get_template_part('template-parts/card-product', null, array(
 *     'index' => $index,  // optional, for animation delay
 * ));
 */

$index = isset($args['index']) ? $args['index'] : 1;
$product_type = get_post_meta(get_the_ID(), 'product_type', true);
$product_price = get_post_meta(get_the_ID(), 'product_price', true);
?>

<article class="product-card reveal-up" data-delay="<?php echo min($index, 4); ?>">
    <a href="<?php the_permalink(); ?>" class="product-card-inner">
        <div class="product-image">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('medium_large'); ?>
            <?php else : ?>
                <div class="product-placeholder"></div>
            <?php endif; ?>
        </div>
        <div class="product-content">
            <?php if ($product_type) : ?>
                <span class="product-type"><?php echo esc_html($product_type); ?></span>
            <?php endif; ?>
            <h2 class="product-title"><?php echo esc_html(get_the_title()); ?></h2>
            <p class="product-excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 20)); ?></p>
            <div class="product-footer">
                <?php if ($product_price) : ?>
                    <span class="product-price"><?php echo esc_html($product_price); ?></span>
                <?php endif; ?>
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
