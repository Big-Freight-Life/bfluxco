<?php
/**
 * The front page template
 *
 * This template is used when the site's front page is set to display
 * a static page (Settings > Reading > Your homepage displays > A static page)
 *
 * @package BFLUXCO
 *
 * PRO TIP: To use this template:
 * 1. Create a page called "Home" in WordPress admin
 * 2. Go to Settings > Reading
 * 3. Select "A static page" under "Your homepage displays"
 * 4. Choose your "Home" page as the Homepage
 */

get_header();
?>

<style>
.case-card {
    width: 939px !important;
    height: 528px !important;
    max-width: none !important;
}
</style>

<main id="main-content" class="site-main">

    <!-- Hero Section -->
    <section class="hero">
        <!-- Video Background -->
        <div class="hero-video-container">
            <video class="hero-video" id="hero-video" autoplay muted loop playsinline webkit-playsinline preload="auto" disablePictureInPicture>
                <source src="<?php echo esc_url(get_template_directory_uri() . '/assets/videos/hero-bg.webm'); ?>" type="video/webm">
                <source src="<?php echo esc_url(get_template_directory_uri() . '/assets/videos/hero-bg.mp4'); ?>" type="video/mp4">
            </video>
            <div class="hero-video-overlay"></div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var video = document.getElementById('hero-video');
                if (video) {
                    video.muted = true;
                    video.setAttribute('muted', '');
                    video.setAttribute('playsinline', '');
                    video.play().catch(function() {
                        setTimeout(function() {
                            video.play();
                        }, 100);
                    });
                }
            });
        </script>
        <div class="container">
            <h1 class="hero-title reveal-hero">
                <span class="hero-title-primary"><span class="text-accent">People</span> are our</span>
                <span class="hero-title-secondary">secret weapon</span>
            </h1>
            <p class="hero-description reveal" data-delay="1">We help organizations unlock their full potential through strategic consulting, innovative solutions, and transformative partnerships.</p>
            <div class="hero-cta reveal" data-delay="2">
                <button type="button" class="btn btn-primary btn-lg btn-icon" id="interview-ray-btn" aria-haspopup="dialog">
                    <?php bfluxco_icon('microphone', array('size' => 20)); ?>
                    <span><?php esc_html_e('Interview Ray', 'bfluxco'); ?></span>
                </button>
                <a href="<?php echo esc_url(home_url('/transformation')); ?>" class="btn btn-outline btn-lg">
                    <?php esc_html_e('Transform My Team', 'bfluxco'); ?>
                </a>
            </div>
        </div>
    </section><!-- .hero -->

    <!-- Logo Carousel -->
    <section class="logo-carousel-section">
        <div class="logo-carousel">
            <div class="logo-carousel-track">
                <?php
                $industries = bfluxco_get_industry_carousel_items();
                // Output twice for seamless loop
                for ($loop = 0; $loop < 2; $loop++) :
                    foreach ($industries as $index => $industry) :
                ?>
                    <span class="logo-text logo-style-<?php echo ($index % 10) + 1; ?>"><?php echo esc_html($industry); ?></span>
                <?php
                    endforeach;
                endfor;
                ?>
            </div>
        </div>
    </section><!-- .logo-carousel -->

    <!-- Case Studies Section -->
    <section class="section case-studies-section section-reveal">
        <div class="container">
            <?php
            get_template_part('template-parts/section', 'header', array(
                'title'    => __('Work that speaks', 'bfluxco') . '<br><span class="text-muted">' . __('for itself', 'bfluxco') . '</span>',
                'cta_text' => __('View All Work', 'bfluxco'),
                'cta_url'  => home_url('/work'),
                'class'    => 'case-studies-header',
            ));
            ?>
        </div>

        <!-- Horizontal Scroll Carousel -->
        <div class="case-carousel" role="region" aria-label="Case studies carousel" tabindex="0">
            <div class="case-carousel-track">
                <?php
                $featured_cases = new WP_Query(array(
                    'post_type'      => 'case_study',
                    'posts_per_page' => 5,
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                ));

                if ($featured_cases->have_posts()) :
                    while ($featured_cases->have_posts()) : $featured_cases->the_post();
                        get_template_part('template-parts/card-case', 'carousel');
                    endwhile;
                    wp_reset_postdata();
                else :
                    foreach (bfluxco_get_placeholder_case_studies() as $placeholder) :
                        get_template_part('template-parts/card-case', 'carousel', array(
                            'is_placeholder'   => true,
                            'placeholder_data' => $placeholder,
                        ));
                    endforeach;
                endif;
                ?>
            </div>
        </div>

        <div class="container">
            <?php
            get_template_part('template-parts/section', 'nav', array(
                'hint'       => __('Scroll to explore case studies', 'bfluxco'),
                'prev_label' => __('Previous case study', 'bfluxco'),
                'next_label' => __('Next case study', 'bfluxco'),
                'prev_class' => 'carousel-prev',
                'next_class' => 'carousel-next',
                'class'      => 'case-studies-nav',
            ));
            ?>
        </div>
    </section><!-- Case Studies -->

    <!-- Productivity Section -->
    <section class="section productivity-section section-reveal">
        <div class="container">
            <h2 class="productivity-title reveal-text">
                Advanced <span class="text-problem-solving">problem solving</span><br>
                <span class="text-muted">and beyond</span>
            </h2>

            <div class="productivity-media reveal-scale" data-delay="2">
                <div class="media-showcase">
                    <div class="media-placeholder" style="background-image: url('<?php echo esc_url(get_template_directory_uri() . '/assets/images/brain-backdrop.jpg'); ?>'); background-size: cover; background-position: center;">
                        <button class="media-play-btn" aria-label="Play video">
                            <?php bfluxco_icon('play', array('size' => 24)); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- Productivity -->

    <!-- Services Overview Section -->
    <section class="section services-section section-reveal">
        <div class="container">
            <?php
            get_template_part('template-parts/section', 'header', array(
                'title'    => __('How I Can Help', 'bfluxco'),
                'subtitle' => __('Services designed to move your business forward', 'bfluxco'),
                'cta_text' => __('View All Services', 'bfluxco'),
                'cta_url'  => home_url('/work'),
                'class'    => 'services-header',
            ));
            ?>

            <div class="services-grid grid grid-3">
                <?php
                $services = bfluxco_get_placeholder_services();
                foreach ($services as $index => $service) :
                    get_template_part('template-parts/card', 'service', array(
                        'title'       => $service['title'],
                        'description' => $service['description'],
                        'icon'        => $service['icon'],
                        'link'        => $service['link'],
                        'delay'       => $index + 1,
                    ));
                endforeach;
                ?>
            </div>
        </div>
    </section><!-- Services Overview -->

    <!-- About Preview Section -->
    <section class="section bg-gray-50 section-reveal">
        <div class="container">
            <div class="grid grid-2 items-center gap-8">

                <div class="about-preview-image reveal-scale">
                    <?php
                    /**
                     * Display featured image if set on the front page
                     */
                    if (has_post_thumbnail()) :
                        the_post_thumbnail('large', array('class' => 'rounded-lg'));
                    else :
                    ?>
                        <div style="background-color: var(--color-gray-300); aspect-ratio: 4/3; border-radius: var(--radius-xl);"></div>
                    <?php endif; ?>
                </div>

                <div class="about-preview-content reveal-text" data-delay="2">
                    <a href="<?php echo esc_url(home_url('/about/ray')); ?>" class="hero-announce">
                        <span class="announce-badge"><?php esc_html_e('New', 'bfluxco'); ?></span>
                        <span class="announce-text"><?php esc_html_e('Ray v2.7 Available Now', 'bfluxco'); ?></span>
                        <?php bfluxco_icon('chevron-right', array('size' => 16, 'class' => 'announce-arrow')); ?>
                    </a>
                    <h2><?php esc_html_e('GenAI Experience Architect', 'bfluxco'); ?></h2>
                    <p><?php esc_html_e('With years of experience in design strategy and product development, I help organizations navigate complexity and create meaningful solutions.', 'bfluxco'); ?></p>
                    <p><?php esc_html_e('My approach combines strategic thinking with hands-on execution, ensuring ideas become reality.', 'bfluxco'); ?></p>
                </div>

            </div>
        </div>
    </section><!-- About Preview -->

    <!-- CTA Section -->
    <section class="section text-center section-reveal">
        <div class="container">
            <h2 class="reveal-text"><?php esc_html_e('Ready to Get Started?', 'bfluxco'); ?></h2>
            <p class="text-gray-600 max-w-2xl mx-auto mb-8 reveal-text" data-delay="2">
                <?php esc_html_e("Whether you have a specific project in mind or just want to explore how we might work together, I'd love to hear from you.", 'bfluxco'); ?>
            </p>
            <div class="reveal" data-delay="3">
                <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-primary btn-lg">
                    <?php esc_html_e('Get in Touch', 'bfluxco'); ?>
                </a>
            </div>
        </div>
    </section><!-- CTA -->

    <!-- Latest Blogs Section -->
    <section class="section blogs-section section-reveal">
        <div class="container">
            <?php
            get_template_part('template-parts/section', 'header', array(
                'title'    => __('Latest Blogs', 'bfluxco'),
                'cta_text' => __('View All Blogs', 'bfluxco'),
                'cta_url'  => home_url('/blog'),
                'class'    => 'blogs-header',
            ));
            ?>

            <div class="blogs-grid">
                <?php
                $latest_posts = new WP_Query(array(
                    'post_type'      => 'post',
                    'posts_per_page' => 3,
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                ));

                if ($latest_posts->have_posts()) :
                    $blog_index = 0;
                    while ($latest_posts->have_posts()) : $latest_posts->the_post();
                        $blog_index++;
                        get_template_part('template-parts/card', 'blog', array('delay' => $blog_index));
                    endwhile;
                    wp_reset_postdata();
                else :
                    $placeholder_posts = bfluxco_get_placeholder_blog_posts();
                    foreach ($placeholder_posts as $index => $post_item) :
                        get_template_part('template-parts/card', 'blog', array(
                            'delay'            => $index + 1,
                            'is_placeholder'   => true,
                            'placeholder_data' => $post_item,
                        ));
                    endforeach;
                endif;
                ?>
            </div>

            <?php
            get_template_part('template-parts/section', 'nav', array(
                'prev_label' => __('Previous posts', 'bfluxco'),
                'next_label' => __('Next posts', 'bfluxco'),
                'prev_class' => 'blogs-prev',
                'next_class' => 'blogs-next',
                'class'      => 'blogs-nav',
            ));
            ?>
        </div>
    </section><!-- Latest Blogs -->


</main><!-- #main-content -->

<!-- Interview Code Modal -->
<div class="modal-overlay" id="interview-modal" role="dialog" aria-modal="true" aria-labelledby="interview-modal-title" hidden>
    <div class="modal">
        <button type="button" class="modal-close" aria-label="<?php esc_attr_e('Close modal', 'bfluxco'); ?>">
            <?php bfluxco_icon('x', array('size' => 24)); ?>
        </button>
        <div class="modal-content">
            <h2 id="interview-modal-title" class="modal-title"><?php esc_html_e('Interview Ray', 'bfluxco'); ?></h2>
            <p class="modal-description"><?php esc_html_e('Enter your interview session code to begin.', 'bfluxco'); ?></p>
            <form class="interview-form" id="interview-form">
                <div class="form-group">
                    <label for="interview-code" class="form-label"><?php esc_html_e('Interview Session Code', 'bfluxco'); ?></label>
                    <input
                        type="text"
                        id="interview-code"
                        name="interview_code"
                        class="form-input"
                        placeholder="<?php esc_attr_e('Enter code...', 'bfluxco'); ?>"
                        autocomplete="off"
                        required
                    >
                </div>
                <button type="submit" class="btn btn-primary btn-lg w-full">
                    <?php esc_html_e('Start Interview', 'bfluxco'); ?>
                </button>
            </form>
        </div>
    </div>
</div>

<?php
get_footer();
