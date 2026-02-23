<?php
/**
 * Template Name: Blog - Framework Guide
 * Template Post Type: post, page
 *
 * Style: Centered hero with visual framework/diagram area
 * Best for: How-to guides, methodologies, frameworks, step-by-step processes
 *
 * @package BFLUXCO
 */

get_header();
?>

<!-- Reading Progress Bar -->
<div class="reading-progress" id="reading-progress">
    <div class="reading-progress__bar"></div>
</div>

<main id="main-content" class="site-main blog-template blog-framework">

    <?php while (have_posts()) : the_post(); ?>

    <!-- Hero Section - Centered with Framework Visual -->
    <header class="blog-hero blog-hero--framework">
        <div class="blog-hero__background-pattern"></div>
        <div class="container">
            <div class="blog-hero__content">
                <?php
                $categories = get_the_category();
                if ($categories) : ?>
                    <a href="<?php echo esc_url(get_category_link($categories[0]->term_id)); ?>" class="blog-source-badge">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polygon points="12 2 2 7 12 12 22 7 12 2"/>
                            <polyline points="2 17 12 22 22 17"/>
                            <polyline points="2 12 12 17 22 12"/>
                        </svg>
                        <?php echo esc_html($categories[0]->name); ?>
                    </a>
                <?php endif; ?>
                <h1 class="blog-hero__title"><?php the_title(); ?></h1>
                <?php if (has_excerpt()) : ?>
                    <p class="blog-hero__subtitle"><?php echo get_the_excerpt(); ?></p>
                <?php endif; ?>
                <div class="blog-hero__meta-inline">
                    <div class="author-mini">
                        <?php echo get_avatar(get_the_author_meta('ID'), 32); ?>
                        <span><?php the_author(); ?></span>
                    </div>
                    <span class="separator">&bull;</span>
                    <span><?php echo get_the_date(); ?></span>
                    <span class="separator">&bull;</span>
                    <span><?php echo bfluxco_reading_time(); ?> min read</span>
                </div>
            </div>

            <!-- Featured Image as Framework Diagram -->
            <?php if (has_post_thumbnail()) : ?>
            <div class="blog-hero__diagram">
                <div class="diagram-wrapper">
                    <?php the_post_thumbnail('large', ['class' => 'framework-diagram']); ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </header>

    <!-- Main Content -->
    <article class="blog-content-section">
        <div class="container">
            <div class="blog-content blog-content--framework" id="article-content">
                <?php the_content(); ?>

                <!-- Tags -->
                <?php if (has_tag()) : ?>
                <div class="blog-tags">
                    <span class="tags-label">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/>
                            <line x1="7" y1="7" x2="7.01" y2="7"/>
                        </svg>
                        Related Topics
                    </span>
                    <?php the_tags('', '', ''); ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </article>

    <!-- CTA Section -->
    <section class="blog-cta-section">
        <div class="container">
            <div class="blog-cta blog-cta--framework">
                <div class="cta-icon-wrapper">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>
                    </svg>
                </div>
                <h3>Ready to Apply This Framework?</h3>
                <p>Let's discuss how it could transform your project's approach.</p>
                <a href="/contact" class="btn btn-primary btn-lg">Start the Conversation</a>
            </div>
        </div>
    </section>

    <!-- Author & Share -->
    <section class="blog-footer-section">
        <div class="container">
            <div class="blog-footer-grid">
                <div class="author-card">
                    <div class="author-card__avatar">
                        <?php echo get_avatar(get_the_author_meta('ID'), 64); ?>
                    </div>
                    <div class="author-card__info">
                        <span class="author-card__label">Written by</span>
                        <h4 class="author-card__name"><?php the_author(); ?></h4>
                        <?php if (get_the_author_meta('description')) : ?>
                            <p class="author-card__bio"><?php echo get_the_author_meta('description'); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="share-section">
                    <span class="share-label">Share this guide</span>
                    <div class="share-buttons">
                        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>"
                           target="_blank" rel="noopener" class="share-btn share-btn--twitter">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                            </svg>
                        </a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode(get_permalink()); ?>"
                           target="_blank" rel="noopener" class="share-btn share-btn--linkedin">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                        <button class="share-btn share-btn--copy" data-url="<?php echo esc_url(get_permalink()); ?>">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/>
                                <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Post Navigation -->
    <nav class="blog-post-nav">
        <div class="container">
            <?php
            $prev_post = get_previous_post();
            $next_post = get_next_post();
            ?>
            <div class="post-nav-grid">
                <?php if ($prev_post) : ?>
                <a href="<?php echo get_permalink($prev_post); ?>" class="post-nav-card post-nav-card--prev">
                    <span class="post-nav-card__direction">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M19 12H5M12 19l-7-7 7-7"/>
                        </svg>
                        Previous Guide
                    </span>
                    <span class="post-nav-card__title"><?php echo get_the_title($prev_post); ?></span>
                </a>
                <?php else : ?>
                <div class="post-nav-card post-nav-card--empty"></div>
                <?php endif; ?>

                <?php if ($next_post) : ?>
                <a href="<?php echo get_permalink($next_post); ?>" class="post-nav-card post-nav-card--next">
                    <span class="post-nav-card__direction">
                        Next Guide
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </span>
                    <span class="post-nav-card__title"><?php echo get_the_title($next_post); ?></span>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <?php endwhile; ?>

</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const progressBar = document.querySelector('.reading-progress__bar');

    function updateProgress() {
        const scrollTop = window.scrollY;
        const docHeight = document.documentElement.scrollHeight - window.innerHeight;
        const progress = (scrollTop / docHeight) * 100;
        progressBar.style.width = progress + '%';
    }

    window.addEventListener('scroll', updateProgress);
    updateProgress();

    // Copy link button
    document.querySelectorAll('.share-btn--copy').forEach(btn => {
        btn.addEventListener('click', function() {
            navigator.clipboard.writeText(this.dataset.url).then(() => {
                this.classList.add('copied');
                setTimeout(() => this.classList.remove('copied'), 2000);
            });
        });
    });
});
</script>

<?php get_footer(); ?>
