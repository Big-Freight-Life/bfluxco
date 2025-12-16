<?php
/**
 * Template part for displaying a blog post card
 *
 * This reusable card component is used for blog post previews.
 *
 * @package BFLUXCO
 *
 * Expected $args:
 *   - delay: int (animation delay index)
 *   - is_placeholder: bool (whether this is placeholder content)
 *   - placeholder_data: array (data for placeholder: title, date, category, link)
 */

$delay = isset($args['delay']) ? intval($args['delay']) : 1;
$is_placeholder = isset($args['is_placeholder']) && $args['is_placeholder'];
$data = isset($args['placeholder_data']) ? $args['placeholder_data'] : array();

if ($is_placeholder) :
    // Placeholder mode
    $title = isset($data['title']) ? $data['title'] : 'Blog Post Title';
    $date = isset($data['date']) ? $data['date'] : 'Jan 1, 2024';
    $category = isset($data['category']) ? $data['category'] : 'Category';
    $link = isset($data['link']) ? $data['link'] : '#';
?>
    <article class="blog-card reveal-up" data-delay="<?php echo esc_attr($delay); ?>">
        <div class="blog-card-image">
            <div class="blog-image-placeholder"></div>
        </div>
        <div class="blog-card-content">
            <h3 class="blog-card-title"><?php echo esc_html($title); ?></h3>
            <div class="blog-card-meta">
                <span class="blog-date"><?php echo esc_html($date); ?></span>
                <span class="blog-category"><?php echo esc_html($category); ?></span>
            </div>
            <span class="blog-read-link">
                <?php esc_html_e('Read blog', 'bfluxco'); ?>
                <?php bfluxco_icon('chevron-right', array('size' => 16)); ?>
            </span>
        </div>
    </article>
<?php else :
    // Real post mode
    $categories = get_the_category();
    $category_name = $categories ? $categories[0]->name : 'Blog';
?>
    <article class="blog-card reveal-up" data-delay="<?php echo esc_attr($delay); ?>">
        <a href="<?php the_permalink(); ?>" class="blog-card-image">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('medium_large'); ?>
            <?php else : ?>
                <div class="blog-image-placeholder"></div>
            <?php endif; ?>
        </a>
        <div class="blog-card-content">
            <h3 class="blog-card-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h3>
            <div class="blog-card-meta">
                <span class="blog-date"><?php echo get_the_date('M j, Y'); ?></span>
                <span class="blog-category"><?php echo esc_html($category_name); ?></span>
            </div>
            <a href="<?php the_permalink(); ?>" class="blog-read-link">
                <?php esc_html_e('Read blog', 'bfluxco'); ?>
                <?php bfluxco_icon('chevron-right', array('size' => 16)); ?>
            </a>
        </div>
    </article>
<?php endif; ?>
