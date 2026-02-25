<?php
/**
 * Template part for displaying a case study card in the carousel
 *
 * This card variant is specifically designed for the homepage carousel.
 * For archive/grid layouts, use card-case-study.php instead.
 *
 * @package BFLUXCO
 *
 * Expected $args:
 *   - is_placeholder: bool (whether this is placeholder content)
 *   - placeholder_data: array (label, title, excerpt, year, gradient, link)
 */

$is_placeholder = isset($args['is_placeholder']) && $args['is_placeholder'];
$data = isset($args['placeholder_data']) ? $args['placeholder_data'] : array();

if ($is_placeholder) :
    // Placeholder mode
    $label = isset($data['label']) ? $data['label'] : 'Case Study';
    $title = isset($data['title']) ? $data['title'] : 'Project Title';
    $excerpt = isset($data['excerpt']) ? $data['excerpt'] : 'Project description goes here.';
    $year = isset($data['year']) ? $data['year'] : date('Y');
    $gradient = isset($data['gradient']) ? $data['gradient'] : 'linear-gradient(135deg, #6366f1, #8b5cf6)';
    $image_url = isset($data['image_url']) && $data['image_url'] ? $data['image_url'] : '';
    $link = isset($data['link']) ? $data['link'] : '#';
    $card_bg = $image_url ? 'background-image: url(' . esc_url($image_url) . ');' : 'background: ' . esc_attr($gradient) . ';';
    $image_bg = $image_url ? 'background-image: url(' . esc_url($image_url) . ');' : 'background: ' . esc_attr($gradient) . ';';
?>
    <a href="<?php echo esc_url(home_url($link)); ?>" class="case-card" style="<?php echo $card_bg; ?>">
        <div class="case-card-image" style="<?php echo $image_bg; ?>"></div>
        <div class="case-card-content">
            <span class="case-label"><?php echo esc_html($label); ?></span>
            <h3 class="case-title"><?php echo esc_html($title); ?></h3>
            <p class="case-excerpt"><?php echo esc_html($excerpt); ?></p>
            <div class="case-meta">
                <span><?php echo esc_html($year); ?></span>
            </div>
        </div>
    </a>
<?php else :
    // Real post mode
    $industry = get_the_terms(get_the_ID(), 'industry');
    $industry_name = $industry ? $industry[0]->name : 'Case Study';
    $bg_style = '';
    $thumb_url = '';
    if (has_post_thumbnail()) {
        $thumb_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
        $bg_style = 'background-image: url(' . esc_url($thumb_url) . ');';
    }

    // Get excerpt - use post_excerpt directly for protected posts
    $post_obj = get_post();
    if (post_password_required() && !empty($post_obj->post_excerpt)) {
        $card_excerpt = wp_trim_words($post_obj->post_excerpt, 24);
    } else {
        $card_excerpt = wp_trim_words(get_the_excerpt(), 24);
        // Replace protected post message
        if (strpos($card_excerpt, 'no excerpt') !== false) {
            $card_excerpt = 'Password protected content.';
        }
    }
?>
    <?php
    $has_password = !empty($post_obj->post_password);
    // Check if user has client access via session (bypasses WordPress password check)
    $has_client_access = $has_password && class_exists('BFLUXCO_Client_Access') && BFLUXCO_Client_Access::has_access(get_the_ID());
    $is_locked = $has_password && !$has_client_access && post_password_required();
    ?>
    <a href="<?php the_permalink(); ?>" class="case-card<?php echo $is_locked ? ' is-locked' : ''; ?>" style="<?php echo esc_attr($bg_style); ?>">
        <?php if ($thumb_url) : ?>
        <div class="case-card-image" style="background-image: url('<?php echo esc_url($thumb_url); ?>');">
            <?php if ($is_locked) : ?>
            <span class="case-card-lock"><svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg></span>
            <?php elseif ($has_password) : ?>
            <span class="case-card-lock is-unlocked"><svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm6-9h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6h1.9c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm0 12H6V10h12v10z"/></svg></span>
            <?php endif; ?>
        </div>
        <?php else : ?>
            <?php if ($is_locked) : ?>
            <span class="case-card-lock"><svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg></span>
            <?php elseif ($has_password) : ?>
            <span class="case-card-lock is-unlocked"><svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm6-9h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6h1.9c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm0 12H6V10h12v10z"/></svg></span>
            <?php endif; ?>
        <?php endif; ?>
        <div class="case-card-content">
            <span class="case-label"><?php echo esc_html($industry_name); ?></span>
            <h3 class="case-title"><?php echo esc_html($post_obj->post_title); ?></h3>
            <p class="case-excerpt"><?php echo esc_html($card_excerpt); ?></p>
            <div class="case-meta">
                <span><?php echo get_the_date('Y'); ?></span>
            </div>
        </div>
    </a>
<?php endif; ?>
