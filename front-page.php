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

<main id="main-content" class="site-main">

    <!-- Hero Section -->
    <section class="hero">
        <!-- Video Background - Scroll-Driven Parallax -->
        <div class="hero-video-container">
            <video class="hero-video" id="hero-video" muted playsinline webkit-playsinline preload="metadata"
                disablePictureInPicture controlslist="nodownload nofullscreen noremoteplayback"
                poster="<?php echo esc_url(get_template_directory_uri() . '/assets/images/hero-eye.jpg'); ?>">
                <source src="<?php echo esc_url(get_template_directory_uri() . '/assets/videos/hero-bg.webm'); ?>"
                    type="video/webm">
                <source src="<?php echo esc_url(get_template_directory_uri() . '/assets/videos/hero-bg.mp4'); ?>"
                    type="video/mp4">
            </video>
            <div class="hero-video-fallback" id="hero-video-fallback"
                style="display: none; background-image: url('<?php echo esc_url(get_template_directory_uri() . '/assets/images/hero-eye.jpg'); ?>');">
            </div>
            <div class="hero-video-overlay"></div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var video = document.getElementById('hero-video');
                var fallback = document.getElementById('hero-video-fallback');
                if (video) {
                    video.muted = true;
                    video.setAttribute('muted', '');
                    video.setAttribute('playsinline', '');

                    // Show fallback on video error
                    video.addEventListener('error', function () {
                        if (fallback) {
                            video.style.display = 'none';
                            fallback.style.display = 'block';
                        }
                    });

                    // On mobile, autoplay as fallback (scroll-driven JS handles desktop)
                    if (window.innerWidth < 768) {
                        video.play().catch(function () {
                            if (fallback) {
                                video.style.display = 'none';
                                fallback.style.display = 'block';
                            }
                        });
                    }
                }
            });
        </script>
        <div class="container">
            <h1 class="hero-title reveal-hero">
                <span class="hero-title-primary">Let's build something</span>
                <span class="hero-title-secondary" style="font-weight: var(--font-weight-bold);">wonderful <span class="text-accent">together</span></span>
            </h1>
            <p class="hero-description reveal" data-delay="1">We design scalable systems that make complexity visible
                and enable confident decisions.</p>
            <!-- Full-screen blur overlay for chat -->
            <div class="chat-blur-overlay" id="chat-blur-overlay"></div>

            <!-- AI Chat Interface -->
            <div class="hero-chat reveal" data-delay="2">
                <!-- Chat Input Area (messages float above this) -->
                <div class="chat-input-area">
                    <!-- Conversation Messages (appears when chatting) -->
                    <div class="chat-messages" id="chat-messages" role="log" aria-live="polite"
                        aria-label="<?php esc_attr_e('Chat conversation', 'bfluxco'); ?>"></div>

                    <!-- Lead Capture Form (appears on handoff) -->
                    <div class="chat-lead-form" id="chat-lead-form">
                        <h3 class="chat-lead-form-title"><?php esc_html_e("Let's connect you with Ray", 'bfluxco'); ?>
                        </h3>
                        <p class="chat-lead-form-desc">
                            <?php esc_html_e('Leave your details and Ray will get back to you within 24 hours.', 'bfluxco'); ?>
                        </p>
                        <input type="text" class="chat-lead-input chat-lead-name"
                            placeholder="<?php esc_attr_e('Your name', 'bfluxco'); ?>" />
                        <input type="email" class="chat-lead-input chat-lead-email"
                            placeholder="<?php esc_attr_e('Your email', 'bfluxco'); ?>" required />
                        <textarea class="chat-lead-input chat-lead-message" rows="2"
                            placeholder="<?php esc_attr_e('Brief message (optional)', 'bfluxco'); ?>"></textarea>
                        <div class="chat-lead-actions">
                            <button type="button"
                                class="btn btn-primary chat-lead-submit"><?php esc_html_e('Send Message', 'bfluxco'); ?></button>
                            <a href="#" class="btn btn-outline chat-lead-schedule" style="display: none;"
                                target="_blank" rel="noopener"><?php esc_html_e('Schedule a Call', 'bfluxco'); ?></a>
                        </div>
                    </div>

                    <!-- Success Message -->
                    <div class="chat-success" id="chat-success">
                        <div class="chat-success-icon">
                            <?php bfluxco_icon('check', array('size' => 24)); ?>
                        </div>
                        <h3 class="chat-success-title"><?php esc_html_e('Message sent!', 'bfluxco'); ?></h3>
                        <p class="chat-success-desc"><?php esc_html_e("Ray will be in touch soon.", 'bfluxco'); ?></p>
                    </div>

                    <!-- Chat Input (hidden) -->
                    <form class="chat-form" id="chat-form" onsubmit="return false;" style="display: none !important;">
                        <div class="chat-input-wrapper">
                            <span class="chat-input-icon" aria-hidden="true">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                </svg>
                            </span>
                            <textarea class="chat-input" id="chat-input"
                                placeholder="<?php esc_attr_e('Ask how can we help you...', 'bfluxco'); ?>"
                                autocomplete="off" rows="1"></textarea>
                            <button type="button" class="chat-clear-btn" id="chat-clear-btn"
                                aria-label="<?php esc_attr_e('Clear input', 'bfluxco'); ?>">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M18.3 5.71a1 1 0 0 0-1.42 0L12 10.59 7.12 5.71a1 1 0 0 0-1.42 1.42L10.59 12l-4.89 4.88a1 1 0 1 0 1.42 1.42L12 13.41l4.88 4.89a1 1 0 0 0 1.42-1.42L13.41 12l4.89-4.88a1 1 0 0 0 0-1.41z" />
                                </svg>
                            </button>
                            <button type="button" class="chat-mic-btn" id="chat-mic-btn"
                                aria-label="<?php esc_attr_e('Voice input', 'bfluxco'); ?>">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"></path>
                                    <path d="M19 10v2a7 7 0 0 1-14 0v-2"></path>
                                    <line x1="12" y1="19" x2="12" y2="23"></line>
                                    <line x1="8" y1="23" x2="16" y2="23"></line>
                                </svg>
                            </button>
                            <button type="button" class="chat-voice-toggle" id="chat-voice-toggle"
                                aria-label="<?php esc_attr_e('Toggle voice output', 'bfluxco'); ?>">
                                <svg class="icon-speaker" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon>
                                    <path d="M19.07 4.93a10 10 0 0 1 0 14.14"></path>
                                    <path d="M15.54 8.46a5 5 0 0 1 0 7.07"></path>
                                </svg>
                                <svg class="icon-muted" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon>
                                    <line x1="23" y1="9" x2="17" y2="15"></line>
                                    <line x1="17" y1="9" x2="23" y2="15"></line>
                                </svg>
                            </button>
                        </div>
                        <button type="button" class="chat-close-btn" id="chat-close-btn"
                            aria-label="<?php esc_attr_e('Close chat', 'bfluxco'); ?>">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </form>
                </div>

                <!-- Action Buttons -->
                <div class="hero-chat-actions">
                    <button type="button" class="btn btn-primary" id="interview-ray-btn" style="display: none;">
                        <?php esc_html_e('Interview Ray', 'bfluxco'); ?>
                    </button>
                    <a href="<?php echo esc_url(home_url('/products')); ?>" class="btn btn-secondary">
                        <?php esc_html_e('Git In Touch', 'bfluxco'); ?>
                    </a>
                    <a href="<?php echo esc_url(home_url('/transformation')); ?>" class="btn btn-primary">
                        <?php esc_html_e('Transform My Team', 'bfluxco'); ?>
                    </a>
                </div>
            </div>
        </div>
    </section><!-- .hero -->

    <!-- Principles Section -->
    <section class="section principles-section">
        <div class="container">
            <div class="principles-centered">
                <h2 class="principles-title">
                    <?php esc_html_e('AI is not a feature.', 'bfluxco'); ?><br>
                    <?php esc_html_e('Design is not decoration.', 'bfluxco'); ?>
                </h2>
                <p class="principles-body principles-body--intro">
                    <?php esc_html_e('Behind every system are professionals navigating trade-offs, exceptions, and consequences. Our work starts there.', 'bfluxco'); ?>
                </p>
                <p class="principles-body">
                    <?php esc_html_e('Our focus are the conditions that shape real decisions: fragmented tools, evolving rules, and outcomes that compound over time. As AI reshapes work, we extend human capability.', 'bfluxco'); ?>
                </p>
            </div>
        </div>
    </section><!-- .principles-section -->

    <!-- Industry Logo Carousel -->
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
    <section class="section case-studies-section section-reveal"
        style="padding-top: calc(var(--spacing-20) + 50px); padding-bottom: var(--spacing-16);">
        <div class="container">
            <header class="section-header reveal-text case-studies-header">
                <div class="section-header-content">
                    <h2 class="section-title"><?php esc_html_e('Real work.', 'bfluxco'); ?><br><?php esc_html_e('Real constraints.', 'bfluxco'); ?></h2>
                </div>
                <a href="<?php echo esc_url(home_url('/works')); ?>" class="btn btn-tertiary btn-icon">
                    <span><?php esc_html_e('View All Work', 'bfluxco'); ?></span>
                    <?php bfluxco_icon('arrow-right', array('size' => 16)); ?>
                </a>
            </header>
        </div>

        <!-- Horizontal Scroll Carousel -->
        <div class="case-carousel" role="region" aria-label="Case studies carousel" tabindex="0">
            <div class="case-carousel-track">
                <?php
                $featured_cases = new WP_Query(array(
                    'post_type' => 'case_study',
                    'posts_per_page' => 5,
                    'orderby' => 'date',
                    'order' => 'DESC',
                ));

                if ($featured_cases->have_posts()):
                    while ($featured_cases->have_posts()):
                        $featured_cases->the_post();
                        get_template_part('template-parts/card-case', 'carousel');
                    endwhile;
                    wp_reset_postdata();
                else:
                    foreach (bfluxco_get_placeholder_case_studies() as $placeholder):
                        get_template_part('template-parts/card-case', 'carousel', array(
                            'is_placeholder' => true,
                            'placeholder_data' => $placeholder,
                        ));
                    endforeach;
                endif;
                ?>
            </div>
        </div>

        <!-- Mobile: "View All Work" below carousel -->
        <div class="case-studies-mobile-cta">
            <a href="<?php echo esc_url(home_url('/works')); ?>" class="btn btn-secondary btn-icon">
                <span><?php esc_html_e('View All Work', 'bfluxco'); ?></span>
                <?php bfluxco_icon('arrow-right', array('size' => 16)); ?>
            </a>
        </div>

        <div class="container">
            <?php
            get_template_part('template-parts/section', 'nav', array(
                'prev_label' => __('Previous case study', 'bfluxco'),
                'next_label' => __('Next case study', 'bfluxco'),
                'prev_class' => 'carousel-prev',
                'next_class' => 'carousel-next',
                'class' => 'case-studies-nav',
            ));
            ?>
        </div>
    </section><!-- Case Studies -->

    <!-- About Preview Section -->
    <section class="section section-reveal about-preview-section">
        <div class="about-preview-code-bg" aria-hidden="true">
            <div class="claude-terminal">
                <div class="claude-terminal-output">
                    <div class="claude-terminal-help">? for shortcuts</div>
                </div>
                <div class="claude-terminal-input-container">
                    <span class="claude-terminal-input-symbol">&gt;</span>
                    <input type="text" class="claude-terminal-input" placeholder='Try "design an agent workflow"'
                        readonly />
                </div>
            </div>
        </div>
        <div class="about-preview-overlay"></div>
        <div class="container about-preview-container">
            <div class="about-preview-content reveal-text">
                <h4><?php esc_html_e('GenAI Experience Architect', 'bfluxco'); ?></h4>
                <p><?php esc_html_e('Anyone can build something, few know what to build and why. I design and build modular systems where human judgment, system behavior, and agentic capabilities align.', 'bfluxco'); ?>
                </p>
                <a href="<?php echo esc_url(home_url('/about/ray')); ?>" class="hero-announce">
                    <span class="announce-badge"><?php esc_html_e('New', 'bfluxco'); ?></span>
                    <span class="announce-text"><?php esc_html_e('Ray v2.7 Available Now', 'bfluxco'); ?></span>
                    <?php bfluxco_icon('chevron-right', array('size' => 16, 'class' => 'announce-arrow')); ?>
                </a>
            </div>
        </div>
    </section><!-- About Preview -->

    <!-- Productivity Section -->
    <section class="section productivity-section section-reveal">
        <div class="container">
            <div class="productivity-media reveal-scale">
                <div class="media-showcase">
                    <div class="media-placeholder"
                        style="background-image: url('<?php echo esc_url(get_template_directory_uri() . '/assets/images/brain-backdrop.jpg'); ?>'); background-size: cover; background-position: center;">
                        <div class="media-overlay"></div>
                        <!-- TODO: Add actual video URL -->
                        <button class="media-play-btn video-play-btn"
                            data-video-url="#" aria-label="Play video">
                            <?php bfluxco_icon('play', array('size' => 24)); ?>
                        </button>
                        <span class="media-title"><?php esc_html_e('the thinker', 'bfluxco'); ?></span>
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
                'title' => __('What we design for', 'bfluxco'),
                'class' => 'services-header',
            ));
            ?>

            <div class="services-grid grid grid-2">
                <?php
                $services = bfluxco_get_placeholder_services();
                foreach ($services as $index => $service):
                    get_template_part('template-parts/card', 'service', array(
                        'title' => $service['title'],
                        'description' => $service['description'],
                        'icon' => $service['icon'],
                        'link' => $service['link'],
                        'delay' => $index + 1,
                    ));
                endforeach;
                ?>
            </div>
        </div>
    </section><!-- Services Overview -->

    <!-- Resources Section (mobile only — matches prototype) -->
    <section class="resources-mobile-section">
        <h2><?php esc_html_e('Resources', 'bfluxco'); ?></h2>
        <div class="resource-card">
            <h3><?php esc_html_e('Designing for Decision Complexity', 'bfluxco'); ?></h3>
            <p><?php esc_html_e('How to build systems that support confident decisions in uncertain environments.', 'bfluxco'); ?></p>
        </div>
        <div class="resource-card">
            <h3><?php esc_html_e('The AI-Human Handoff', 'bfluxco'); ?></h3>
            <p><?php esc_html_e('Patterns for graceful transitions between automated and human-driven workflows.', 'bfluxco'); ?></p>
        </div>
    </section><!-- Resources (mobile) -->

    <!-- CTA Section -->
    <section class="section cta-section text-center section-reveal">
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



</main><!-- #main-content -->

<!-- Interview Code Modal -->
<div class="modal-overlay" id="interview-modal" role="dialog" aria-modal="true" aria-labelledby="interview-modal-title"
    hidden>
    <div class="modal">
        <button type="button" class="modal-close" aria-label="<?php esc_attr_e('Close modal', 'bfluxco'); ?>">
            <?php bfluxco_icon('x', array('size' => 24)); ?>
        </button>
        <div class="modal-content">
            <h2 id="interview-modal-title" class="modal-title"><?php esc_html_e('Interview Ray', 'bfluxco'); ?></h2>
            <p class="modal-description"><?php esc_html_e('Enter your interview session code to begin.', 'bfluxco'); ?>
            </p>
            <form class="interview-form" id="interview-form">
                <div class="form-group">
                    <label for="interview-code"
                        class="form-label"><?php esc_html_e('Interview Session Code', 'bfluxco'); ?></label>
                    <input type="text" id="interview-code" name="interview_code" class="form-input"
                        placeholder="<?php esc_attr_e('Enter code...', 'bfluxco'); ?>" autocomplete="off" required>
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
