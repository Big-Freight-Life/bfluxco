<?php
/**
 * Template part for displaying page headers
 *
 * @package BFLUXCO
 *
 * Usage:
 * get_template_part('template-parts/page-header', null, array(
 *     'description' => 'Your page description text',
 *     'show_animations' => true,      // optional, default true
 *     'desc_delay' => '1',            // optional, default '1'
 *     'use_excerpt' => false,         // optional, use page excerpt as fallback
 * ));
 */

// Get args with defaults
$description = isset($args['description']) ? $args['description'] : '';
$show_animations = isset($args['show_animations']) ? $args['show_animations'] : true;
$desc_delay = isset($args['desc_delay']) ? $args['desc_delay'] : '1';
$use_excerpt = isset($args['use_excerpt']) ? $args['use_excerpt'] : false;

// Build classes
$title_class = 'page-title' . ($show_animations ? ' reveal-hero' : '');
$desc_class = 'page-description' . ($show_animations ? ' reveal' : '');
$desc_attrs = $show_animations ? ' data-delay="' . esc_attr($desc_delay) . '"' : '';

// Determine if we have description content to show
$has_desc_content = ($use_excerpt && has_excerpt()) || $description;
?>

<!-- Page Header -->
<header class="page-header">
    <div class="container">
        <?php bfluxco_breadcrumbs(); ?>
        <h1 class="<?php echo esc_attr($title_class); ?>"><?php the_title(); ?></h1>
        <?php if ($has_desc_content) : ?>
            <p class="<?php echo esc_attr($desc_class); ?>"<?php echo $desc_attrs; ?>>
                <?php
                if ($use_excerpt && has_excerpt()) {
                    the_excerpt();
                } elseif ($description) {
                    echo esc_html($description);
                }
                ?>
            </p>
        <?php endif; ?>
    </div>
</header><!-- .page-header -->
