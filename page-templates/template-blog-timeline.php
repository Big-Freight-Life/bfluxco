<?php
/**
 * Template Name: Blog - Timeline Evolution
 * Template Post Type: post, page
 *
 * Style: Modern split hero with timeline elements and evolution visuals
 * Best for: Technology evolution posts, historical overviews, process explanations
 *
 * @package BFLUXCO
 */

get_header();
?>

<!-- Reading Progress Bar -->
<div class="reading-progress" id="reading-progress">
    <div class="reading-progress__bar"></div>
</div>

<main id="main-content" class="site-main blog-template blog-timeline">

    <?php while (have_posts()) : the_post(); ?>

    <!-- Split Hero Section -->
    <header class="blog-hero blog-hero--split">
        <div class="blog-hero__left">
            <div class="blog-hero__content">
                <?php
                $categories = get_the_category();
                if ($categories) : ?>
                    <a href="<?php echo esc_url(get_category_link($categories[0]->term_id)); ?>" class="blog-category-badge">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                            <path d="M2 17l10 5 10-5"/>
                            <path d="M2 12l10 5 10-5"/>
                        </svg>
                        <?php echo esc_html($categories[0]->name); ?>
                    </a>
                <?php endif; ?>
                <h1 class="blog-hero__title"><?php the_title(); ?></h1>
                <?php if (has_excerpt()) : ?>
                    <p class="blog-hero__subtitle"><?php echo get_the_excerpt(); ?></p>
                <?php endif; ?>
                <div class="blog-hero__meta-row">
                    <span class="meta-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12,6 12,12 16,14"></polyline>
                        </svg>
                        <?php echo bfluxco_reading_time(); ?> min read
                    </span>
                    <span class="meta-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        <?php echo get_the_date('F Y'); ?>
                    </span>
                </div>
                <div class="blog-hero__author-inline">
                    <?php echo get_avatar(get_the_author_meta('ID'), 40); ?>
                    <span>By <?php the_author(); ?></span>
                </div>
            </div>
        </div>
        <div class="blog-hero__right">
            <?php if (has_post_thumbnail()) : ?>
                <div class="blog-hero__image-wrapper">
                    <?php the_post_thumbnail('large', ['class' => 'hero-featured-image']); ?>
                    <div class="image-decoration image-decoration--tl"></div>
                    <div class="image-decoration image-decoration--br"></div>
                </div>
            <?php else : ?>
                <div class="evolution-visual">
                    <div class="evolution-icon evolution-icon--past">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <rect x="2" y="6" width="20" height="12" rx="2"/>
                            <line x1="6" y1="10" x2="6" y2="10"/>
                            <line x1="10" y1="10" x2="10" y2="10"/>
                            <line x1="14" y1="10" x2="14" y2="10"/>
                            <line x1="18" y1="10" x2="18" y2="10"/>
                            <line x1="8" y1="14" x2="16" y2="14"/>
                        </svg>
                        <span>Past</span>
                    </div>
                    <div class="evolution-connector">
                        <div class="connector-line"></div>
                        <div class="connector-arrow">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                <polyline points="12 5 19 12 12 19"></polyline>
                            </svg>
                        </div>
                    </div>
                    <div class="evolution-icon evolution-icon--future">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M12 2a9 9 0 0 0-9 9c0 3.6 3.4 6.2 6 9 .6.6 1.3 1.2 2 2h2c.7-.8 1.4-1.4 2-2 2.6-2.8 6-5.4 6-9a9 9 0 0 0-9-9z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                        <span>Future</span>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </header>

    <!-- Main Content -->
    <article class="blog-content-section">
        <div class="container">
            <div class="blog-content blog-content--timeline" id="article-content">
                <?php the_content(); ?>

                <!-- Tags -->
                <?php if (has_tag()) : ?>
                <div class="blog-tags">
                    <span class="tags-label">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/>
                            <line x1="7" y1="7" x2="7.01" y2="7"/>
                        </svg>
                        Topics
                    </span>
                    <?php the_tags('', '', ''); ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </article>

    <!-- CTA Section -->
    <section class="blog-cta-section blog-cta-section--timeline">
        <div class="container">
            <div class="blog-cta blog-cta--gradient">
                <div class="cta-content">
                    <h3>Ready to evolve your approach?</h3>
                    <p>Let's discuss how emerging technologies could transform your project.</p>
                    <a href="/contact" class="btn btn-primary btn-lg">Let's Talk</a>
                </div>
                <div class="cta-decoration">
                    <svg viewBox="0 0 120 120" fill="none" stroke="currentColor" stroke-width="1">
                        <circle cx="60" cy="60" r="50" opacity="0.2"/>
                        <circle cx="60" cy="60" r="35" opacity="0.3"/>
                        <circle cx="60" cy="60" r="20" opacity="0.4"/>
                    </svg>
                </div>
            </div>
        </div>
    </section>

    <!-- Author Info -->
    <section class="blog-author-section">
        <div class="container">
            <div class="author-card author-card--horizontal">
                <div class="author-card__avatar">
                    <?php echo get_avatar(get_the_author_meta('ID'), 96); ?>
                </div>
                <div class="author-card__info">
                    <span class="author-card__label">Written by</span>
                    <h4 class="author-card__name"><?php the_author(); ?></h4>
                    <?php if (get_the_author_meta('description')) : ?>
                        <p class="author-card__bio"><?php echo get_the_author_meta('description'); ?></p>
                    <?php endif; ?>
                    <div class="author-card__share">
                        <span>Share this article:</span>
                        <div class="share-buttons">
                            <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>"
                               target="_blank" rel="noopener" class="share-btn share-btn--twitter">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                </svg>
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode(get_permalink()); ?>"
                               target="_blank" rel="noopener" class="share-btn share-btn--linkedin">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                            </a>
                        </div>
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
                        Previous
                    </span>
                    <span class="post-nav-card__title"><?php echo get_the_title($prev_post); ?></span>
                </a>
                <?php else : ?>
                <div class="post-nav-card post-nav-card--empty"></div>
                <?php endif; ?>

                <?php if ($next_post) : ?>
                <a href="<?php echo get_permalink($next_post); ?>" class="post-nav-card post-nav-card--next">
                    <span class="post-nav-card__direction">
                        Next
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
});
</script>

<?php get_footer(); ?>
