<?php
/**
 * Template Name: Blog - Editorial Classic
 * Template Post Type: post, page
 *
 * Style: Premium editorial with reading progress, sticky TOC, and elegant typography
 * Best for: Thought leadership pieces, listicles, pillar content
 *
 * @package BFLUXCO
 */

get_header();
?>

<!-- Reading Progress Bar -->
<div class="reading-progress" id="reading-progress">
    <div class="reading-progress__bar"></div>
</div>

<main id="main-content" class="site-main blog-template blog-editorial">

    <?php while (have_posts()) : the_post(); ?>

    <!-- Hero Section -->
    <header class="blog-hero blog-hero--editorial <?php echo has_post_thumbnail() ? 'has-featured-image' : ''; ?>">
        <?php if (has_post_thumbnail()) : ?>
        <div class="blog-hero__background">
            <?php the_post_thumbnail('full', ['class' => 'hero-bg-image']); ?>
            <div class="hero-overlay hero-overlay--gradient"></div>
        </div>
        <?php else : ?>
        <div class="blog-hero__pattern"></div>
        <?php endif; ?>

        <div class="container">
            <div class="blog-hero__content">
                <div class="blog-hero__meta">
                    <?php
                    $categories = get_the_category();
                    if ($categories) : ?>
                        <a href="<?php echo esc_url(get_category_link($categories[0]->term_id)); ?>" class="blog-category">
                            <?php echo esc_html($categories[0]->name); ?>
                        </a>
                    <?php endif; ?>
                    <span class="blog-reading-time">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12,6 12,12 16,14"></polyline>
                        </svg>
                        <?php echo bfluxco_reading_time(); ?> min read
                    </span>
                </div>
                <h1 class="blog-hero__title"><?php the_title(); ?></h1>
                <?php if (has_excerpt()) : ?>
                    <p class="blog-hero__subtitle"><?php echo get_the_excerpt(); ?></p>
                <?php endif; ?>
                <div class="blog-hero__author">
                    <div class="author-avatar">
                        <?php echo get_avatar(get_the_author_meta('ID'), 56); ?>
                    </div>
                    <div class="author-info">
                        <span class="author-name"><?php the_author(); ?></span>
                        <span class="author-date">
                            <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date('F j, Y'); ?></time>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll indicator -->
        <div class="scroll-indicator">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 5v14M19 12l-7 7-7-7"/>
            </svg>
        </div>
    </header>

    <!-- Main Content with Sidebar Navigation -->
    <div class="blog-layout blog-layout--sidebar">
        <div class="container">
            <div class="blog-layout__grid">

                <!-- Sticky Section Navigation -->
                <aside class="blog-sidebar">
                    <nav class="section-nav" aria-label="Article sections">
                        <div class="section-nav__header">
                            <span class="section-nav__label">Contents</span>
                            <span class="section-nav__progress" id="section-progress">0%</span>
                        </div>
                        <ol class="section-nav__list" id="toc-list">
                            <!-- Populated by JavaScript -->
                        </ol>
                    </nav>

                    <!-- Social Share (Sidebar) -->
                    <div class="sidebar-share">
                        <span class="share-label">Share</span>
                        <div class="share-buttons share-buttons--vertical">
                            <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>"
                               target="_blank" rel="noopener" class="share-btn share-btn--twitter" aria-label="Share on Twitter">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                </svg>
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode(get_permalink()); ?>"
                               target="_blank" rel="noopener" class="share-btn share-btn--linkedin" aria-label="Share on LinkedIn">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                            </a>
                            <button class="share-btn share-btn--copy" data-url="<?php echo esc_url(get_permalink()); ?>" aria-label="Copy link">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/>
                                    <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </aside>

                <!-- Article Content -->
                <article class="blog-content blog-content--editorial">
                    <div class="blog-content__inner" id="article-content">
                        <?php the_content(); ?>
                    </div>

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

                    <!-- Author Bio Card -->
                    <div class="author-bio-card">
                        <div class="author-bio-card__avatar">
                            <?php echo get_avatar(get_the_author_meta('ID'), 80); ?>
                        </div>
                        <div class="author-bio-card__content">
                            <span class="author-bio-card__label">Written by</span>
                            <h4 class="author-bio-card__name"><?php the_author(); ?></h4>
                            <?php if (get_the_author_meta('description')) : ?>
                                <p class="author-bio-card__bio"><?php echo get_the_author_meta('description'); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- CTA Section -->
                    <div class="blog-cta blog-cta--editorial">
                        <div class="blog-cta__icon">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
                            </svg>
                        </div>
                        <h3>Found this insightful?</h3>
                        <p>Let's discuss how these ideas could apply to your project.</p>
                        <a href="/contact" class="btn btn-primary btn-lg">Start a Conversation</a>
                    </div>

                </article>

            </div>
        </div>
    </div>

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
                        Previous Article
                    </span>
                    <span class="post-nav-card__title"><?php echo get_the_title($prev_post); ?></span>
                </a>
                <?php else : ?>
                <div class="post-nav-card post-nav-card--empty"></div>
                <?php endif; ?>

                <?php if ($next_post) : ?>
                <a href="<?php echo get_permalink($next_post); ?>" class="post-nav-card post-nav-card--next">
                    <span class="post-nav-card__direction">
                        Next Article
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
    const content = document.getElementById('article-content');
    const tocList = document.getElementById('toc-list');
    const progressBar = document.querySelector('.reading-progress__bar');
    const sectionProgress = document.getElementById('section-progress');
    const headings = content.querySelectorAll('h2');

    // Generate TOC
    headings.forEach((heading, index) => {
        const id = heading.textContent.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
        heading.id = id;

        const li = document.createElement('li');
        const a = document.createElement('a');
        a.href = '#' + id;
        a.className = 'section-nav__link';
        a.setAttribute('data-index', index);
        a.innerHTML = '<span class="section-nav__number">' + (index + 1) + '</span>' + heading.textContent;
        li.appendChild(a);
        tocList.appendChild(li);
    });

    // Reading progress & active section tracking
    function updateProgress() {
        const scrollTop = window.scrollY;
        const docHeight = document.documentElement.scrollHeight - window.innerHeight;
        const progress = (scrollTop / docHeight) * 100;

        progressBar.style.width = progress + '%';
        sectionProgress.textContent = Math.round(progress) + '%';

        // Update active section
        let activeIndex = 0;
        headings.forEach((heading, index) => {
            if (heading.getBoundingClientRect().top < 150) {
                activeIndex = index;
            }
        });

        document.querySelectorAll('.section-nav__link').forEach((link, index) => {
            link.classList.toggle('is-active', index === activeIndex);
        });
    }

    window.addEventListener('scroll', updateProgress);
    updateProgress();

    // Smooth scroll for TOC links
    document.querySelectorAll('.section-nav__link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });

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
