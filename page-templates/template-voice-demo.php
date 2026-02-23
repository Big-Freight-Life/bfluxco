<?php
/**
 * Template Name: Voice Case Study Demo
 * Template Post Type: page
 *
 * Split-layout voice-led case study experience.
 * Image on left (sticky), transcript on right (scrolling).
 * Dual-mode: audio-driven or scroll-driven sync.
 */

// Clear server-side cache if requested
if (isset($_GET['clear_cache']) && $_GET['clear_cache'] === '1') {
    delete_transient('gemini_demo_' . get_the_ID());
    // Redirect to clean URL
    wp_redirect(remove_query_arg('clear_cache'));
    exit;
}

// Enqueue voice narrative assets
wp_enqueue_style(
    'bfluxco-voice-narrative',
    get_template_directory_uri() . '/assets/css/partials/_voice-narrative.css',
    array(),
    '3.0.0'
);
wp_enqueue_script(
    'bfluxco-voice-narrative',
    get_template_directory_uri() . '/assets/js/voice-narrative.js',
    array(),
    '3.0.0',
    true
);

get_header();

// Demo audio (optional - page works with scroll sync if no audio)
$demo_audio = 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3';

// Check if Gemini is configured
$gemini_configured = class_exists('BFLUXCO_Gemini_Image') && BFLUXCO_Gemini_Image::get_instance()->is_configured();

// Narrative states configuration
$states = array(
    'grounding' => array(
        'label' => 'Context',
        'heading' => 'Setting the Scene',
        'color' => '#1a847b',
    ),
    'tension' => array(
        'label' => 'Challenge',
        'heading' => 'The Problem We Faced',
        'color' => '#e07c4f',
    ),
    'decision' => array(
        'label' => 'Approach',
        'heading' => 'How We Solved It',
        'color' => '#1a847b',
    ),
    'outcome' => array(
        'label' => 'Results',
        'heading' => 'What We Achieved',
        'color' => '#7c5cbf',
    ),
);
?>

<main id="main-content" class="site-main">

    <div class="voice-case-study voice-split-layout"
         data-audio-src="<?php echo esc_url($demo_audio); ?>"
         data-narrative-state="grounding">

        <!-- LEFT: Sticky Image Area -->
        <div class="voice-split-left">
            <div class="voice-split-image has-state-images" id="voice-visual-area">

                <!-- State images/videos - 4:3 aspect ratio, crossfade based on scroll or audio -->
                <img class="voice-state-image is-active" data-state="grounding"
                     src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1600 1200'%3E%3Cdefs%3E%3ClinearGradient id='g1' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='%231a1a2e'/%3E%3Cstop offset='50%25' stop-color='%2316213e'/%3E%3Cstop offset='100%25' stop-color='%230f3460'/%3E%3C/linearGradient%3E%3C/defs%3E%3Crect fill='url(%23g1)' width='1600' height='1200'/%3E%3Ccircle cx='800' cy='600' r='200' fill='none' stroke='%231a847b' stroke-width='1' opacity='0.3'/%3E%3Ccircle cx='800' cy='600' r='350' fill='none' stroke='%231a847b' stroke-width='0.5' opacity='0.15'/%3E%3Ctext x='800' y='620' text-anchor='middle' fill='%23ffffff' opacity='0.15' font-size='32' font-family='system-ui' font-weight='300'%3ECONTEXT%3C/text%3E%3C/svg%3E"
                     alt="Grounding - Setting the context">

                <img class="voice-state-image" data-state="tension"
                     src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1600 1200'%3E%3Cdefs%3E%3ClinearGradient id='g2' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='%231a1a2e'/%3E%3Cstop offset='50%25' stop-color='%232d1f3d'/%3E%3Cstop offset='100%25' stop-color='%23462639'/%3E%3C/linearGradient%3E%3C/defs%3E%3Crect fill='url(%23g2)' width='1600' height='1200'/%3E%3Cpath d='M200 950 L800 300 L1400 950' fill='none' stroke='%23e07c4f' stroke-width='2' opacity='0.4'/%3E%3Ctext x='800' y='620' text-anchor='middle' fill='%23ffffff' opacity='0.15' font-size='32' font-family='system-ui' font-weight='300'%3ECHALLENGE%3C/text%3E%3C/svg%3E"
                     alt="Tension - The challenge">

                <img class="voice-state-image" data-state="decision"
                     src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1600 1200'%3E%3Cdefs%3E%3ClinearGradient id='g3' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='%230d2818'/%3E%3Cstop offset='50%25' stop-color='%23134529'/%3E%3Cstop offset='100%25' stop-color='%231a5c3a'/%3E%3C/linearGradient%3E%3C/defs%3E%3Crect fill='url(%23g3)' width='1600' height='1200'/%3E%3Cpath d='M800 150 L800 1050' fill='none' stroke='%231a847b' stroke-width='3' opacity='0.5'/%3E%3Ccircle cx='800' cy='600' r='40' fill='%231a847b' opacity='0.6'/%3E%3Ctext x='800' y='720' text-anchor='middle' fill='%23ffffff' opacity='0.15' font-size='32' font-family='system-ui' font-weight='300'%3EAPPROACH%3C/text%3E%3C/svg%3E"
                     alt="Decision - Making the choice">

                <img class="voice-state-image" data-state="outcome"
                     src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1600 1200'%3E%3Cdefs%3E%3ClinearGradient id='g4' x1='0%25' y1='100%25' x2='100%25' y2='0%25'%3E%3Cstop offset='0%25' stop-color='%230a0a15'/%3E%3Cstop offset='50%25' stop-color='%231a1a2e'/%3E%3Cstop offset='100%25' stop-color='%232a2a4e'/%3E%3C/linearGradient%3E%3C/defs%3E%3Crect fill='url(%23g4)' width='1600' height='1200'/%3E%3Ccircle cx='800' cy='500' r='150' fill='%237c5cbf' opacity='0.2'/%3E%3Ccircle cx='800' cy='500' r='100' fill='%237c5cbf' opacity='0.3'/%3E%3Ctext x='800' y='620' text-anchor='middle' fill='%23ffffff' opacity='0.15' font-size='32' font-family='system-ui' font-weight='300'%3ERESULTS%3C/text%3E%3C/svg%3E"
                     alt="Outcome - The results">

                <!-- Text Overlays - AI generates contextual copy -->
                <div class="voice-text-overlay voice-text-overlay--bottom-left is-active" data-state="grounding">
                    <p class="voice-text-overlay__subhead">Where it began</p>
                    <h2 class="voice-text-overlay__headline">A system built for yesterday</h2>
                </div>

                <div class="voice-text-overlay voice-text-overlay--bottom-left" data-state="tension">
                    <p class="voice-text-overlay__subhead">Then reality hit</p>
                    <h2 class="voice-text-overlay__headline">When everything breaks at once</h2>
                </div>

                <div class="voice-text-overlay voice-text-overlay--bottom-left" data-state="decision">
                    <p class="voice-text-overlay__subhead">The turning point</p>
                    <h2 class="voice-text-overlay__headline">We stopped adding. We started removing.</h2>
                </div>

                <div class="voice-text-overlay voice-text-overlay--center" data-state="outcome">
                    <p class="voice-text-overlay__stat">60%</p>
                    <p class="voice-text-overlay__stat-label">faster task completion</p>
                </div>

                <!-- State label overlay -->
                <div class="voice-split-state-label" id="state-label">Context</div>

                <?php if ($gemini_configured): ?>
                <!-- Regenerate AI Images Icon Button -->
                <button type="button" id="generate-visuals-btn" aria-label="Regenerate visuals"
                        style="position: absolute; top: 20px; right: 20px; z-index: 10; width: 36px; height: 36px; padding: 0; background: rgba(255, 255, 255, 0.1); color: rgba(255,255,255,0.7); border: 1px solid rgba(255,255,255,0.2); border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(8px); transition: all 0.2s;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M23 4v6h-6"/><path d="M1 20v-6h6"/>
                        <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/>
                    </svg>
                </button>
                <?php endif; ?>
            </div>
        </div>

        <!-- RIGHT: Scrolling Transcript -->
        <div class="voice-split-right">

            <!-- Fixed Header -->
            <header class="voice-right-header">
                <a href="<?php echo home_url('/'); ?>" class="voice-back-button">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>
                    Home
                </a>

                <button type="button" class="voice-menu-button" id="voice-menu-toggle" aria-label="Case studies menu" aria-expanded="false">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="3" y1="6" x2="21" y2="6"/>
                        <line x1="3" y1="12" x2="21" y2="12"/>
                        <line x1="3" y1="18" x2="21" y2="18"/>
                    </svg>
                </button>

                <!-- Case Studies Menu -->
                <nav class="voice-menu-dropdown" id="voice-menu-dropdown" aria-hidden="true">
                    <div class="voice-menu-header">Case Studies</div>
                    <ul class="voice-menu-list">
                        <?php
                        // Query case studies
                        $case_studies = new WP_Query(array(
                            'post_type' => 'case_study',
                            'posts_per_page' => 10,
                            'orderby' => 'date',
                            'order' => 'DESC',
                        ));

                        if ($case_studies->have_posts()) :
                            while ($case_studies->have_posts()) : $case_studies->the_post();
                        ?>
                            <li>
                                <a href="<?php the_permalink(); ?>" class="voice-menu-item <?php echo (get_the_ID() === get_queried_object_id()) ? 'is-current' : ''; ?>">
                                    <?php the_title(); ?>
                                </a>
                            </li>
                        <?php
                            endwhile;
                            wp_reset_postdata();
                        else :
                        ?>
                            <li>
                                <a href="#" class="voice-menu-item is-current">Voice-Led Storytelling Demo</a>
                            </li>
                            <li>
                                <a href="#" class="voice-menu-item">Enterprise Platform Redesign</a>
                            </li>
                            <li>
                                <a href="#" class="voice-menu-item">Healthcare Data Transformation</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </header>

            <!-- Content Area -->
            <div class="voice-right-content">
                <h1 style="font-size: clamp(1.75rem, 4vw, 2.5rem); font-weight: var(--font-weight-medium); line-height: 1.2; margin-bottom: var(--spacing-4);">
                    Voice-Led Storytelling
                </h1>
                <p style="color: var(--text-secondary); font-size: var(--font-size-lg); max-width: 480px; margin-bottom: var(--spacing-6);">
                    Scroll to explore, or listen to the narration. The visuals respond to your journey through the story.
                </p>

                <!-- Play Controls -->
                <div class="voice-split-cta">
                    <button type="button" class="voice-play-cta" aria-label="Listen to narration">
                        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                        <span class="voice-play-cta-text">
                            <span class="voice-play-cta-label">Listen</span>
                            <span class="voice-play-cta-duration">2:25</span>
                        </span>
                    </button>

                    <div class="voice-mode-indicator mode-scroll">
                        <span class="voice-mode-text">Reading</span>
                    </div>
                </div>

                <!-- Loading/Error states -->
                <div class="voice-loading" aria-live="polite">
                    <div class="voice-loading-spinner"></div>
                    <span>Loading audio...</span>
                </div>
                <div class="voice-error" role="alert">
                    <svg class="voice-error-icon" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                    </svg>
                    <span>Audio unavailable. Scroll to explore instead.</span>
                </div>

            <!-- Transcript Sections -->
            <div id="transcript" class="voice-transcript">

                <!-- GROUNDING (0-50s) -->
                <section class="narrative-section" data-state="grounding" data-start="0" data-end="50">
                    <span class="narrative-section-label">Context</span>
                    <h2 class="narrative-section-heading">Setting the Scene</h2>
                    <p class="transcript-paragraph">
                        <span class="transcript-sentence" data-start="0" data-end="4">
                            Every great project begins with understanding the landscape.
                        </span>
                        <span class="transcript-sentence" data-start="4" data-end="10">
                            In this case, we were asked to reimagine how users interact with complex data systems.
                        </span>
                    </p>
                    <p class="transcript-paragraph">
                        <span class="transcript-sentence" data-start="10" data-end="17">
                            The existing solution had grown organically over years, accumulating features without a cohesive vision.
                        </span>
                        <span class="transcript-sentence" data-start="17" data-end="23">
                            Users were overwhelmed. Workflows that should take minutes stretched into hours.
                        </span>
                    </p>
                    <p class="transcript-paragraph">
                        <span class="transcript-sentence" data-start="23" data-end="30">
                            Our first step was simply listening—conducting interviews, observing workflows, mapping pain points.
                        </span>
                        <span class="transcript-sentence" data-start="30" data-end="36">
                            What emerged was a picture of a system that had lost sight of its users.
                        </span>
                    </p>
                </section>

                <!-- TENSION (36-72s) -->
                <section class="narrative-section" data-state="tension" data-start="36" data-end="72">
                    <span class="narrative-section-label">Challenge</span>
                    <h2 class="narrative-section-heading">The Problem We Faced</h2>
                    <p class="transcript-paragraph">
                        <span class="transcript-sentence" data-start="36" data-end="40">
                            However, simplifying wasn't straightforward.
                        </span>
                        <span class="transcript-sentence" data-start="40" data-end="50">
                            The system served diverse user groups with competing needs—analysts who wanted depth, executives who wanted summaries, operators who needed real-time alerts.
                        </span>
                    </p>
                    <p class="transcript-paragraph">
                        <span class="transcript-sentence" data-start="50" data-end="55">
                            Every stakeholder had a feature they couldn't live without.
                        </span>
                        <span class="transcript-sentence" data-start="55" data-end="60">
                            The political landscape was as complex as the technical one.
                        </span>
                    </p>
                    <p class="transcript-paragraph">
                        <span class="transcript-sentence" data-start="60" data-end="67">
                            We faced a fundamental tension: how do you simplify without removing capability?
                        </span>
                    </p>
                </section>

                <!-- DECISION (67-110s) -->
                <section class="narrative-section" data-state="decision" data-start="67" data-end="110">
                    <span class="narrative-section-label">Approach</span>
                    <h2 class="narrative-section-heading">How We Solved It</h2>
                    <p class="transcript-paragraph">
                        <span class="transcript-sentence" data-start="67" data-end="72">
                            We decided to embrace progressive disclosure.
                        </span>
                        <span class="transcript-sentence" data-start="72" data-end="80">
                            Rather than showing everything at once, we would reveal complexity only when users needed it.
                        </span>
                    </p>
                    <p class="transcript-paragraph">
                        <span class="transcript-sentence" data-start="80" data-end="89">
                            The interface would adapt to behavior—learning what each user actually used and surfacing those tools first.
                        </span>
                        <span class="transcript-sentence" data-start="89" data-end="96">
                            Power features remained accessible but didn't clutter the default experience.
                        </span>
                    </p>
                    <p class="transcript-paragraph">
                        <span class="transcript-sentence" data-start="96" data-end="101">
                            This wasn't just a design choice—it was a philosophy.
                        </span>
                        <span class="transcript-sentence" data-start="101" data-end="110">
                            We believed that software should meet users where they are, not where we think they should be.
                        </span>
                    </p>
                </section>

                <!-- OUTCOME (110-145s) -->
                <section class="narrative-section" data-state="outcome" data-start="110" data-end="145">
                    <span class="narrative-section-label">Results</span>
                    <h2 class="narrative-section-heading">What We Achieved</h2>
                    <p class="transcript-paragraph">
                        <span class="transcript-sentence" data-start="110" data-end="114">
                            The results exceeded expectations.
                        </span>
                        <span class="transcript-sentence" data-start="114" data-end="121">
                            Task completion times dropped by 60%. Support tickets fell by half.
                        </span>
                    </p>
                    <p class="transcript-paragraph">
                        <span class="transcript-sentence" data-start="121" data-end="130">
                            But the metric that mattered most was qualitative: users described the new system as "intuitive."
                        </span>
                        <span class="transcript-sentence" data-start="130" data-end="136">
                            They stopped fighting with the tool and started using it.
                        </span>
                    </p>
                    <p class="transcript-paragraph">
                        <span class="transcript-sentence" data-start="136" data-end="145">
                            That's the outcome we design for—technology that disappears into usefulness.
                        </span>
                    </p>
                </section>

            </div>

            </div><!-- .voice-right-content -->

        </div><!-- .voice-split-right -->

        <!-- Scroll Indicator Dots -->
        <nav class="voice-scroll-indicator" aria-label="Section navigation">
            <button class="voice-scroll-dot is-active" data-state="grounding" aria-label="Context section"></button>
            <button class="voice-scroll-dot" data-state="tension" aria-label="Challenge section"></button>
            <button class="voice-scroll-dot" data-state="decision" aria-label="Approach section"></button>
            <button class="voice-scroll-dot" data-state="outcome" aria-label="Results section"></button>
        </nav>

    </div>

</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.querySelector('.voice-case-study');
    const stateLabel = document.getElementById('state-label');
    const visualArea = document.getElementById('voice-visual-area');

    const stateLabels = {
        grounding: 'Context',
        tension: 'Challenge',
        decision: 'Approach',
        outcome: 'Results'
    };

    // Menu Toggle
    const menuToggle = document.getElementById('voice-menu-toggle');
    const menuDropdown = document.getElementById('voice-menu-dropdown');

    if (menuToggle && menuDropdown) {
        menuToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            const isOpen = menuDropdown.classList.toggle('is-open');
            menuToggle.setAttribute('aria-expanded', isOpen);
            menuDropdown.setAttribute('aria-hidden', !isOpen);
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!menuDropdown.contains(e.target) && !menuToggle.contains(e.target)) {
                menuDropdown.classList.remove('is-open');
                menuToggle.setAttribute('aria-expanded', 'false');
                menuDropdown.setAttribute('aria-hidden', 'true');
            }
        });

        // Close menu on Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && menuDropdown.classList.contains('is-open')) {
                menuDropdown.classList.remove('is-open');
                menuToggle.setAttribute('aria-expanded', 'false');
                menuDropdown.setAttribute('aria-hidden', 'true');
                menuToggle.focus();
            }
        });
    }

    // Observer to watch for state changes (narrative state label only)
    // Mode indicator updates are now handled by VoiceNarrative class
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.attributeName === 'data-narrative-state') {
                const state = container.dataset.narrativeState;
                if (stateLabel && stateLabels[state]) {
                    stateLabel.textContent = stateLabels[state];
                }
            }
        });
    });

    observer.observe(container, { attributes: true });

    // Scroll dot click handlers
    document.querySelectorAll('.voice-scroll-dot').forEach(dot => {
        dot.addEventListener('click', function() {
            const state = this.dataset.state;
            const section = document.querySelector(`.narrative-section[data-state="${state}"]`);
            if (section) {
                section.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
    });

    <?php if ($gemini_configured): ?>
    // Helper to update visual element (handles multiple media items per state)
    function updateVisualElement(state, stateData) {
        // Handle new format with media array
        if (stateData && stateData.media && Array.isArray(stateData.media)) {
            const mediaItems = stateData.media;
            const existingEls = visualArea.querySelectorAll(`[data-state="${state}"]`);

            // Remove existing elements for this state (except text overlays)
            existingEls.forEach(el => {
                if (!el.classList.contains('voice-text-overlay')) {
                    el.remove();
                }
            });

            // Create new media elements
            mediaItems.forEach((item, index) => {
                const isFirst = index === 0;
                const isActive = container.dataset.narrativeState === state && isFirst;

                if (item.type === 'video') {
                    const video = document.createElement('video');
                    video.className = 'voice-state-image' + (isActive ? ' is-active' : '');
                    video.dataset.state = state;
                    video.dataset.mediaIndex = index;
                    video.src = item.url;
                    video.muted = true;
                    video.setAttribute('muted', '');
                    video.loop = true;
                    video.playsInline = true;
                    video.setAttribute('playsinline', '');
                    if (isActive) {
                        video.autoplay = true;
                    }
                    // Insert before text overlays
                    const firstOverlay = visualArea.querySelector('.voice-text-overlay');
                    if (firstOverlay) {
                        visualArea.insertBefore(video, firstOverlay);
                    } else {
                        visualArea.appendChild(video);
                    }
                    if (isActive) {
                        video.muted = true;
                        video.play().catch(() => {});
                    }
                } else {
                    const img = document.createElement('img');
                    img.className = 'voice-state-image' + (isActive ? ' is-active' : '');
                    img.dataset.state = state;
                    img.dataset.mediaIndex = index;
                    img.src = item.url;
                    img.alt = item.focus || state;
                    // Insert before text overlays
                    const firstOverlay = visualArea.querySelector('.voice-text-overlay');
                    if (firstOverlay) {
                        visualArea.insertBefore(img, firstOverlay);
                    } else {
                        visualArea.appendChild(img);
                    }
                }
            });

            // Update text overlay if provided
            if (stateData.text) {
                updateTextOverlay(state, stateData.text);
            }
        } else {
            // Handle legacy single-item format
            const existingEl = visualArea.querySelector(`img[data-state="${state}"], video[data-state="${state}"]`);
            if (!existingEl) return;

            const url = typeof stateData === 'string' ? stateData : (stateData.url || '');
            const type = typeof stateData === 'string' ? 'image' : (stateData.type || 'image');
            const text = (typeof stateData === 'object' && stateData.text) ? stateData.text : null;

            if (type === 'video') {
                const video = document.createElement('video');
                video.className = existingEl.className;
                video.dataset.state = state;
                video.src = url;
                video.muted = true;
                video.setAttribute('muted', '');
                video.loop = true;
                video.playsInline = true;
                video.setAttribute('playsinline', '');
                video.autoplay = existingEl.classList.contains('is-active');
                existingEl.replaceWith(video);
                if (video.autoplay) {
                    video.muted = true;
                    video.play().catch(() => {});
                }
            } else {
                existingEl.src = url;
            }

            if (text) {
                updateTextOverlay(state, text);
            }
        }
    }

    // Helper to update text overlay content
    function updateTextOverlay(state, text) {
        const overlay = visualArea.querySelector(`.voice-text-overlay[data-state="${state}"]`);
        if (!overlay) return;

        // Update position class if specified
        if (text.position) {
            overlay.className = `voice-text-overlay voice-text-overlay--${text.position}`;
            if (state === container.dataset.narrativeState) {
                overlay.classList.add('is-active');
            }
        }

        // Clear existing content
        overlay.innerHTML = '';

        // Build new content based on text type
        if (text.stat) {
            // Stat display (for outcome)
            const statEl = document.createElement('p');
            statEl.className = 'voice-text-overlay__stat';
            statEl.textContent = text.stat;
            overlay.appendChild(statEl);

            if (text.stat_label) {
                const labelEl = document.createElement('p');
                labelEl.className = 'voice-text-overlay__stat-label';
                labelEl.textContent = text.stat_label;
                overlay.appendChild(labelEl);
            }
        } else {
            // Headline/subhead display
            if (text.subhead) {
                const subEl = document.createElement('p');
                subEl.className = 'voice-text-overlay__subhead';
                subEl.textContent = text.subhead;
                overlay.appendChild(subEl);
            }

            if (text.headline) {
                const headEl = document.createElement('h2');
                headEl.className = 'voice-text-overlay__headline';
                headEl.textContent = text.headline;
                overlay.appendChild(headEl);
            }
        }
    }

    // Auto-generate AI visuals on page load (uses public endpoint with server-side caching)
    (function autoGenerateVisuals() {
        const postId = <?php echo get_the_ID(); ?>;
        const localCacheKey = 'voice_demo_visuals_' + postId;
        const localCached = localStorage.getItem(localCacheKey);

        // Check browser cache first
        if (localCached) {
            try {
                const visuals = JSON.parse(localCached);
                if (Object.keys(visuals).length >= 4) {
                    Object.entries(visuals).forEach(([state, media]) => {
                        updateVisualElement(state, media);
                    });
                    console.log('Loaded AI visuals from browser cache');
                    return;
                }
            } catch (e) {
                localStorage.removeItem(localCacheKey);
            }
        }

        // Show generating state
        visualArea.classList.add('is-generating');
        stateLabel.textContent = 'Generating visuals...';

        // Fetch from server (uses transient caching + generates if needed)
        fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({
                action: 'gemini_get_demo_visuals',
                post_id: postId,
                context: 'Enterprise software redesign and digital transformation',
                'states[grounding]': 'Complex interconnected systems, data flows, enterprise architecture, muted blues and teals',
                'states[tension]': 'Competing forces and tension, fragmented elements, warm orange accents, dramatic motion',
                'states[decision]': 'Clarity and focus, converging lines, decisive moment, teal and green accents',
                'states[outcome]': 'Success and resolution, harmonious composition, purple and blue gradients, elegant'
            })
        })
        .then(r => r.json())
        .then(data => {
            visualArea.classList.remove('is-generating');

            if (data.success && data.data.images && Object.keys(data.data.images).length > 0) {
                const visuals = data.data.images;

                Object.entries(visuals).forEach(([state, media]) => {
                    updateVisualElement(state, media);
                });

                // Cache in browser for instant loading next time
                localStorage.setItem(localCacheKey, JSON.stringify(visuals));
                stateLabel.textContent = stateLabels[container.dataset.narrativeState] || 'Context';
                console.log('AI visuals loaded' + (data.data.cached ? ' (from server cache)' : ' (freshly generated)'));
            } else {
                throw new Error(data.data || 'No visuals returned');
            }
        })
        .catch(err => {
            visualArea.classList.remove('is-generating');
            stateLabel.textContent = stateLabels[container.dataset.narrativeState] || 'Context';
            console.warn('AI visual generation failed, using placeholders:', err);
        });
    })();

    // Manual regenerate button - forces fresh visual generation (includes video)
    const generateBtn = document.getElementById('generate-visuals-btn');
    const postId = <?php echo get_the_ID(); ?>;
    const localCacheKey = 'voice_demo_visuals_' + postId;

    if (generateBtn) {
        generateBtn.addEventListener('click', function() {
            // Clear browser cache
            localStorage.removeItem(localCacheKey);

            // Show generating state
            visualArea.classList.add('is-generating');
            stateLabel.textContent = 'Regenerating...';
            generateBtn.disabled = true;

            // Force regenerate with video for tension state
            fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({
                    action: 'gemini_get_demo_visuals',
                    post_id: postId,
                    force_regenerate: '1',
                    context: 'Enterprise software redesign and digital transformation',
                    'states[grounding]': 'Complex interconnected systems, data flows, enterprise architecture, muted blues and teals',
                    'states[tension]': 'Competing forces and tension, fragmented elements, warm orange accents, dramatic motion',
                    'states[decision]': 'Clarity and focus, converging lines, decisive moment, teal and green accents',
                    'states[outcome]': 'Success and resolution, harmonious composition, purple and blue gradients, elegant'
                })
            })
            .then(r => r.json())
            .then(data => {
                visualArea.classList.remove('is-generating');
                generateBtn.disabled = false;

                if (data.success && data.data.images && Object.keys(data.data.images).length > 0) {
                    const visuals = data.data.images;
                    Object.entries(visuals).forEach(([state, media]) => {
                        updateVisualElement(state, media);
                    });
                    localStorage.setItem(localCacheKey, JSON.stringify(visuals));
                    stateLabel.textContent = stateLabels[container.dataset.narrativeState] || 'Context';
                }
            })
            .catch(err => {
                visualArea.classList.remove('is-generating');
                generateBtn.disabled = false;
                stateLabel.textContent = stateLabels[container.dataset.narrativeState] || 'Context';
                console.error('Regeneration failed:', err);
            });
        });
    }
    <?php endif; ?>
});
</script>

<style>
.animate-spin { animation: spin 1s linear infinite; }
@keyframes spin { to { transform: rotate(360deg); } }
</style>

<?php
// Skip footer on this page - output minimal closing tags
wp_footer();
?>
</body>
</html>
