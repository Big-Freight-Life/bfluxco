<?php
/**
 * Template Name: Interview Raybot
 * Template Post Type: page
 *
 * Voice-first 5-minute digital twin interview experience.
 * HeyGen avatar with voice-to-voice interaction + optional keyboard mode.
 *
 * @package BFLUXCO
 */

get_header();
?>

<main id="main-content" class="site-main interview-raybot-page">

    <!-- Interview Container -->
    <div class="interview-raybot" data-state="idle" data-input-mode="voice" role="application" aria-label="<?php esc_attr_e('Interview with Ray', 'bfluxco'); ?>">

        <!-- Top Bar (Sticky) -->
        <header class="interview-topbar">
            <div class="interview-topbar-left">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="interview-back-btn" aria-label="<?php esc_attr_e('Back to home', 'bfluxco'); ?>">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path d="M19 12H5"/>
                        <polyline points="12 19 5 12 12 5"/>
                    </svg>
                </a>
                <div class="interview-topbar-titles">
                    <h1 class="interview-topbar-title"><?php esc_html_e('Interview Ray', 'bfluxco'); ?></h1>
                    <p class="interview-topbar-subtitle"><?php esc_html_e('Begin a 5-minute interview with Ray\'s digital twin', 'bfluxco'); ?></p>
                </div>
            </div>
            <div class="interview-topbar-right">
                <div class="interview-timer-badge" role="timer" aria-live="polite" aria-atomic="true">
                    <span class="interview-timer-label"><?php esc_html_e('Time remaining', 'bfluxco'); ?></span>
                    <span class="interview-timer-value">05:00</span>
                </div>
                <button type="button" class="interview-about-btn" aria-haspopup="dialog">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
                        <line x1="12" y1="17" x2="12.01" y2="17"/>
                    </svg>
                    <span><?php esc_html_e('About Ray', 'bfluxco'); ?></span>
                </button>
            </div>
        </header>

        <!-- Main Split Layout -->
        <div class="interview-layout">

            <!-- Left Panel: Avatar Stage (Primary) -->
            <div class="interview-avatar-stage">

                <!-- Voice Status Pill (top-left) -->
                <div class="interview-voice-status" role="status" aria-live="polite">
                    <span class="interview-voice-status-dot"></span>
                    <span class="interview-voice-status-text"><?php esc_html_e('Ready', 'bfluxco'); ?></span>
                </div>

                <!-- Now Answering Context -->
                <div class="interview-now-answering" aria-live="polite" hidden>
                    <span class="interview-now-answering-label"><?php esc_html_e('Now answering:', 'bfluxco'); ?></span>
                    <span class="interview-now-answering-text"></span>
                </div>

                <!-- Avatar Container -->
                <div class="interview-avatar-container">
                    <!-- HeyGen video will be injected here -->
                    <div class="interview-avatar-video" id="heygen-avatar">
                        <!-- Placeholder until HeyGen connects -->
                        <div class="interview-avatar-placeholder" aria-hidden="true">
                            <div class="interview-avatar-silhouette">
                                <svg viewBox="0 0 120 120" fill="currentColor" aria-hidden="true">
                                    <circle cx="60" cy="40" r="28"/>
                                    <path d="M60 75c-30 0-50 15-50 35v10h100v-10c0-20-20-35-50-35z"/>
                                </svg>
                            </div>
                            <div class="interview-avatar-pulse"></div>
                        </div>
                    </div>

                    <!-- Caption Overlay -->
                    <div class="interview-caption-overlay" aria-live="polite" hidden>
                        <p class="interview-caption-text"></p>
                    </div>
                </div>

                <!-- Voice Hint (shown during listening) -->
                <div class="interview-voice-hint" hidden aria-live="polite">
                    <div class="interview-voice-waveform" aria-hidden="true">
                        <span></span><span></span><span></span><span></span><span></span>
                    </div>
                    <span class="interview-voice-hint-text"><?php esc_html_e('Speak now...', 'bfluxco'); ?></span>
                </div>

                <!-- Simple Icon Controls -->
                <div class="interview-controls">
                    <!-- Mic Button -->
                    <button type="button" class="interview-icon-btn interview-mic-btn" data-mic-state="off" aria-label="<?php esc_attr_e('Microphone', 'bfluxco'); ?>">
                        <svg class="icon-mic" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"/>
                            <path d="M19 10v2a7 7 0 0 1-14 0v-2"/>
                            <line x1="12" y1="19" x2="12" y2="23"/>
                            <line x1="8" y1="23" x2="16" y2="23"/>
                        </svg>
                        <svg class="icon-mic-off" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true" style="display: none;">
                            <line x1="1" y1="1" x2="23" y2="23"/>
                            <path d="M9 9v3a3 3 0 0 0 5.12 2.12M15 9.34V4a3 3 0 0 0-5.94-.6"/>
                            <path d="M17 16.95A7 7 0 0 1 5 12v-2m14 0v2a7 7 0 0 1-.11 1.23"/>
                            <line x1="12" y1="19" x2="12" y2="23"/>
                            <line x1="8" y1="23" x2="16" y2="23"/>
                        </svg>
                    </button>

                    <!-- Speaker Button -->
                    <button type="button" class="interview-icon-btn interview-mute-btn" aria-pressed="false" aria-label="<?php esc_attr_e('Speaker', 'bfluxco'); ?>">
                        <svg class="icon-volume-on" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/>
                            <path d="M15.54 8.46a5 5 0 0 1 0 7.07"/>
                        </svg>
                        <svg class="icon-volume-off" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true" style="display: none;">
                            <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/>
                            <line x1="23" y1="9" x2="17" y2="15"/>
                            <line x1="17" y1="9" x2="23" y2="15"/>
                        </svg>
                    </button>
                </div>

                <!-- End Session Left Pane View (shown when session complete) -->
                <div class="interview-end-state" hidden aria-live="polite">
                    <div class="interview-end-state-card">
                        <h1 class="interview-end-state-headline">
                            <?php esc_html_e('Thanks for interviewing Ray Bot.', 'bfluxco'); ?>
                        </h1>
                        <p class="interview-end-state-body">
                            <?php esc_html_e("If you'd like to continue the conversation, contact Ray directly and we'll follow up.", 'bfluxco'); ?>
                        </p>
                        <a href="<?php echo esc_url(home_url('/contact')); ?>" class="interview-end-state-cta">
                            <?php esc_html_e('Contact Ray', 'bfluxco'); ?>
                        </a>
                        <p class="interview-end-state-helper">
                            <?php esc_html_e('Typical response: 1–2 business days', 'bfluxco'); ?>
                        </p>
                    </div>
                </div>

            </div><!-- .interview-avatar-stage -->

            <!-- Right Panel: Interview Flow -->
            <div class="interview-panel">

                <!-- Interview Stepper -->
                <div class="interview-stepper">

                    <!-- Step 1: Select Question -->
                    <div class="interview-step interview-step-question" data-step="1" data-step-state="active">
                        <div class="interview-step-header">
                            <span class="interview-step-number">1</span>
                            <h2 class="interview-step-title"><?php esc_html_e('Choose a question', 'bfluxco'); ?></h2>
                        </div>
                        <p class="interview-step-instruction"><?php esc_html_e('Select a question to get started — or begin the interview and ask your own questions live.', 'bfluxco'); ?></p>

                        <div class="interview-question-list" role="radiogroup" aria-label="<?php esc_attr_e('Select a question to ask Ray', 'bfluxco'); ?>">
                            <button type="button"
                                    class="interview-question-card"
                                    role="radio"
                                    aria-checked="false"
                                    data-question-id="1"
                                    data-question-category="background">
                                <span class="interview-question-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                        <circle cx="12" cy="7" r="4"/>
                                    </svg>
                                </span>
                                <span class="interview-question-text"><?php esc_html_e('What is your experience with GenAI and experience design?', 'bfluxco'); ?></span>
                                <span class="interview-question-badge"><?php esc_html_e('Background', 'bfluxco'); ?></span>
                                <span class="interview-question-send" aria-label="<?php esc_attr_e('Send question', 'bfluxco'); ?>" title="<?php esc_attr_e('Send question', 'bfluxco'); ?>">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <line x1="22" y1="2" x2="11" y2="13"/>
                                        <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                                    </svg>
                                </span>
                            </button>

                            <button type="button"
                                    class="interview-question-card"
                                    role="radio"
                                    aria-checked="false"
                                    data-question-id="2"
                                    data-question-category="methodology">
                                <span class="interview-question-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <polygon points="12 2 2 7 12 12 22 7 12 2"/>
                                        <polyline points="2 17 12 22 22 17"/>
                                        <polyline points="2 12 12 17 22 12"/>
                                    </svg>
                                </span>
                                <span class="interview-question-text"><?php esc_html_e('How do you approach a new GenAI project?', 'bfluxco'); ?></span>
                                <span class="interview-question-badge"><?php esc_html_e('Methodology', 'bfluxco'); ?></span>
                                <span class="interview-question-send" aria-label="<?php esc_attr_e('Send question', 'bfluxco'); ?>" title="<?php esc_attr_e('Send question', 'bfluxco'); ?>">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <line x1="22" y1="2" x2="11" y2="13"/>
                                        <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                                    </svg>
                                </span>
                            </button>

                            <button type="button"
                                    class="interview-question-card"
                                    role="radio"
                                    aria-checked="false"
                                    data-question-id="3"
                                    data-question-category="philosophy">
                                <span class="interview-question-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <circle cx="12" cy="12" r="10"/>
                                        <path d="M12 16v-4"/>
                                        <path d="M12 8h.01"/>
                                    </svg>
                                </span>
                                <span class="interview-question-text"><?php esc_html_e('What makes a GenAI experience successful?', 'bfluxco'); ?></span>
                                <span class="interview-question-badge"><?php esc_html_e('Philosophy', 'bfluxco'); ?></span>
                                <span class="interview-question-send" aria-label="<?php esc_attr_e('Send question', 'bfluxco'); ?>" title="<?php esc_attr_e('Send question', 'bfluxco'); ?>">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <line x1="22" y1="2" x2="11" y2="13"/>
                                        <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                                    </svg>
                                </span>
                            </button>

                            <button type="button"
                                    class="interview-question-card"
                                    role="radio"
                                    aria-checked="false"
                                    data-question-id="4"
                                    data-question-category="collaboration">
                                <span class="interview-question-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                        <circle cx="9" cy="7" r="4"/>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                    </svg>
                                </span>
                                <span class="interview-question-text"><?php esc_html_e('How do you work with client teams?', 'bfluxco'); ?></span>
                                <span class="interview-question-badge"><?php esc_html_e('Collaboration', 'bfluxco'); ?></span>
                                <span class="interview-question-send" aria-label="<?php esc_attr_e('Send question', 'bfluxco'); ?>" title="<?php esc_attr_e('Send question', 'bfluxco'); ?>">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <line x1="22" y1="2" x2="11" y2="13"/>
                                        <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                                    </svg>
                                </span>
                            </button>

                            <button type="button"
                                    class="interview-question-card"
                                    role="radio"
                                    aria-checked="false"
                                    data-question-id="5"
                                    data-question-category="results">
                                <span class="interview-question-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                                    </svg>
                                </span>
                                <span class="interview-question-text"><?php esc_html_e('Can you share a specific success story?', 'bfluxco'); ?></span>
                                <span class="interview-question-badge"><?php esc_html_e('Results', 'bfluxco'); ?></span>
                                <span class="interview-question-send" aria-label="<?php esc_attr_e('Send question', 'bfluxco'); ?>" title="<?php esc_attr_e('Send question', 'bfluxco'); ?>">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <line x1="22" y1="2" x2="11" y2="13"/>
                                        <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                                    </svg>
                                </span>
                            </button>
                        </div>

                        <!-- Start Button -->
                        <div class="interview-start-area">
                            <button type="button" class="interview-start-btn">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"/>
                                    <polygon points="10 8 16 12 10 16 10 8" fill="currentColor"/>
                                </svg>
                                <span><?php esc_html_e('Begin Interview', 'bfluxco'); ?></span>
                            </button>
                        </div>
                    </div>

                    <!-- Step 2: Ray Answers -->
                    <div class="interview-step interview-step-answer" data-step="2" data-step-state="pending" hidden>
                        <div class="interview-step-header">
                            <span class="interview-step-number">2</span>
                            <h2 class="interview-step-title"><?php esc_html_e('Ray is answering', 'bfluxco'); ?></h2>
                        </div>
                        <div class="interview-current-question">
                            <p class="interview-current-question-text"></p>
                        </div>
                        <div class="interview-answer-status">
                            <div class="interview-answer-indicator"></div>
                            <span class="interview-answer-status-text"><?php esc_html_e('Listening...', 'bfluxco'); ?></span>
                        </div>
                    </div>

                    <!-- Step 3: Follow-up -->
                    <div class="interview-step interview-step-followup" data-step="3" data-step-state="pending" hidden>
                        <div class="interview-step-header">
                            <span class="interview-step-number">3</span>
                            <h2 class="interview-step-title"><?php esc_html_e('Ask a follow-up', 'bfluxco'); ?></h2>
                            <span class="interview-step-optional"><?php esc_html_e('Optional', 'bfluxco'); ?></span>
                        </div>
                        <p class="interview-followup-instruction"><?php esc_html_e('Use your mic or keyboard to ask a follow-up question.', 'bfluxco'); ?></p>
                        <p class="interview-followup-time-warning" hidden>
                            <?php esc_html_e('Not enough time for a follow-up', 'bfluxco'); ?>
                        </p>
                    </div>

                    <!-- Persistent End Session Button (visible once interview starts) -->
                    <div class="interview-persistent-end" hidden>
                        <button type="button" class="interview-end-session-btn interview-end-session-persistent">
                            <?php esc_html_e('End Session', 'bfluxco'); ?>
                        </button>
                    </div>

                    <!-- Transcript Resize Handle -->
                    <div class="interview-transcript-resize-handle" hidden aria-label="<?php esc_attr_e('Drag to resize transcript', 'bfluxco'); ?>">
                        <div class="interview-transcript-resize-bar"></div>
                    </div>

                    <!-- Inline Transcript (visible during session) -->
                    <div class="interview-inline-transcript" hidden>
                        <div class="interview-inline-transcript-header">
                            <span class="interview-inline-transcript-title"><?php esc_html_e('Transcript', 'bfluxco'); ?></span>
                            <div class="interview-inline-transcript-actions">
                                <button type="button" class="interview-transcript-btn interview-inline-copy-btn" disabled aria-label="<?php esc_attr_e('Copy transcript', 'bfluxco'); ?>">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/>
                                        <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                                    </svg>
                                    <span><?php esc_html_e('Copy', 'bfluxco'); ?></span>
                                </button>
                                <button type="button" class="interview-transcript-btn interview-inline-download-btn" disabled aria-label="<?php esc_attr_e('Download transcript', 'bfluxco'); ?>">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                        <polyline points="7 10 12 15 17 10"/>
                                        <line x1="12" y1="15" x2="12" y2="3"/>
                                    </svg>
                                    <span><?php esc_html_e('Download', 'bfluxco'); ?></span>
                                </button>
                            </div>
                        </div>
                        <div class="interview-inline-transcript-entries" role="log" aria-live="polite">
                            <p class="interview-transcript-empty"><?php esc_html_e('Conversation will appear here...', 'bfluxco'); ?></p>
                        </div>
                    </div>

                </div><!-- .interview-stepper -->

                <!-- Transcript Utility Mode (shown when session complete) -->
                <div class="interview-transcript-utility" hidden aria-live="polite">
                    <div class="interview-transcript-utility-header">
                        <div class="interview-transcript-utility-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <polyline points="14 2 14 8 20 8"/>
                                <line x1="16" y1="13" x2="8" y2="13"/>
                                <line x1="16" y1="17" x2="8" y2="17"/>
                            </svg>
                        </div>
                        <div class="interview-transcript-utility-titles">
                            <h2 class="interview-transcript-utility-title"><?php esc_html_e('Interview Transcript', 'bfluxco'); ?></h2>
                            <p class="interview-transcript-utility-subtitle"><?php esc_html_e('Read or download your conversation with Ray Bot.', 'bfluxco'); ?></p>
                        </div>
                    </div>
                    <div class="interview-transcript-utility-actions">
                        <button type="button" class="interview-transcript-utility-btn interview-utility-copy-btn" aria-label="<?php esc_attr_e('Copy transcript', 'bfluxco'); ?>">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/>
                                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                            </svg>
                            <span><?php esc_html_e('Copy', 'bfluxco'); ?></span>
                        </button>
                        <button type="button" class="interview-transcript-utility-btn interview-utility-download-btn" aria-label="<?php esc_attr_e('Download transcript', 'bfluxco'); ?>">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                <polyline points="7 10 12 15 17 10"/>
                                <line x1="12" y1="15" x2="12" y2="3"/>
                            </svg>
                            <span><?php esc_html_e('Download', 'bfluxco'); ?></span>
                        </button>
                    </div>
                    <div class="interview-transcript-utility-content" role="log">
                        <!-- Transcript entries will be rendered here by JS -->
                    </div>
                </div>

                <!-- Inline Input Field -->
                <div class="interview-panel-input">
                    <div class="interview-panel-input-wrapper">
                        <label for="interview-panel-text-input" class="sr-only"><?php esc_html_e('Type your question', 'bfluxco'); ?></label>
                        <textarea
                            id="interview-panel-text-input"
                            class="interview-panel-text-input"
                            placeholder="<?php esc_attr_e('Type your question...', 'bfluxco'); ?>"
                            rows="1"
                            maxlength="500"
                            autocomplete="off"></textarea>
                        <button type="button" class="interview-panel-send-btn" disabled aria-label="<?php esc_attr_e('Send', 'bfluxco'); ?>">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <line x1="22" y1="2" x2="11" y2="13"/>
                                <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                            </svg>
                        </button>
                    </div>
                </div>

            </div><!-- .interview-panel -->

        </div><!-- .interview-layout -->

    </div><!-- .interview-raybot -->

    <!-- About Ray Modal -->
    <div class="interview-about-modal" role="dialog" aria-modal="true" aria-labelledby="about-ray-title" aria-hidden="true">
        <div class="interview-about-backdrop"></div>
        <div class="interview-about-content">
            <button type="button" class="interview-about-close" aria-label="<?php esc_attr_e('Close dialog', 'bfluxco'); ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>

            <h2 id="about-ray-title" class="interview-about-title"><?php esc_html_e('About This Interview', 'bfluxco'); ?></h2>

            <div class="interview-about-body">
                <section class="interview-about-section">
                    <h3><?php esc_html_e('What is this?', 'bfluxco'); ?></h3>
                    <p><?php esc_html_e('This is a voice-to-voice interview with a digital twin of Ray Butler. Ask questions using your microphone and Ray will respond in real-time.', 'bfluxco'); ?></p>
                </section>

                <section class="interview-about-section">
                    <h3><?php esc_html_e('How does it work?', 'bfluxco'); ?></h3>
                    <p><?php esc_html_e('The avatar is powered by HeyGen, with responses generated by a language model trained on Ray\'s content and speaking style. This demonstrates conversational AI experience design.', 'bfluxco'); ?></p>
                </section>

                <section class="interview-about-section">
                    <h3><?php esc_html_e('Voice or Keyboard', 'bfluxco'); ?></h3>
                    <p><?php esc_html_e('Voice is the primary interaction mode. Tap the mic button to speak. If you prefer, tap the keyboard icon to type your questions instead.', 'bfluxco'); ?></p>
                </section>

                <section class="interview-about-section">
                    <h3><?php esc_html_e('Transparency', 'bfluxco'); ?></h3>
                    <ul class="interview-about-list">
                        <li><?php esc_html_e('This is an AI simulation, not a live video call', 'bfluxco'); ?></li>
                        <li><?php esc_html_e('Responses are generated, not pre-recorded', 'bfluxco'); ?></li>
                        <li><?php esc_html_e('The 5-minute limit keeps the experience focused', 'bfluxco'); ?></li>
                        <li><?php esc_html_e('Your questions are not stored or shared', 'bfluxco'); ?></li>
                    </ul>
                </section>

                <section class="interview-about-section">
                    <h3><?php esc_html_e('Want the real thing?', 'bfluxco'); ?></h3>
                    <p><?php esc_html_e('If you\'d like to speak with Ray directly, schedule a call or send a message.', 'bfluxco'); ?></p>
                    <div class="interview-about-cta">
                        <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-primary btn-sm">
                            <?php esc_html_e('Contact Ray', 'bfluxco'); ?>
                        </a>
                    </div>
                </section>
            </div>
        </div>
    </div><!-- .interview-about-modal -->

    <!-- Session Ending Overlay -->
    <div class="interview-session-ending" hidden>
        <div class="interview-session-ending-content">
            <h2><?php esc_html_e('Session Ending', 'bfluxco'); ?></h2>
            <p><?php esc_html_e('Less than 30 seconds remaining', 'bfluxco'); ?></p>
        </div>
    </div>

    <!-- Session Complete Overlay -->
    <div class="interview-session-complete" hidden>
        <div class="interview-session-complete-content">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                <polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
            <h2><?php esc_html_e('Session Complete', 'bfluxco'); ?></h2>
            <p><?php esc_html_e('Thank you for interviewing Ray', 'bfluxco'); ?></p>
            <a href="<?php echo esc_url(home_url('/contact')); ?>" class="interview-contact-banner">
                <?php esc_html_e('Contact Ray', 'bfluxco'); ?>
            </a>
        </div>
    </div>

</main><!-- #main-content -->

<?php
// Enqueue the interview raybot script
wp_enqueue_script(
    'bfluxco-interview-raybot',
    get_template_directory_uri() . '/assets/js/interview-raybot.js',
    array(),
    BFLUXCO_THEME_VERSION,
    true
);

// Pass configuration to JavaScript
wp_localize_script('bfluxco-interview-raybot', 'interviewRaybotConfig', array(
    'ajaxUrl' => admin_url('admin-ajax.php'),
    'nonce' => wp_create_nonce('interview_raybot_nonce'),
    'strings' => array(
        'connecting' => __('Connecting', 'bfluxco'),
        'ready' => __('Ready', 'bfluxco'),
        'listening' => __('Listening', 'bfluxco'),
        'speaking' => __('Speaking', 'bfluxco'),
        'thinking' => __('Thinking', 'bfluxco'),
        'sessionEnding' => __('Session Ending', 'bfluxco'),
        'complete' => __('Complete', 'bfluxco'),
        'error' => __('Error', 'bfluxco'),
        'speakNow' => __('Speak now...', 'bfluxco'),
        'tapToSpeak' => __('Tap mic to speak', 'bfluxco'),
        'copySuccess' => __('Transcript copied!', 'bfluxco'),
        'downloadSuccess' => __('Transcript downloaded', 'bfluxco'),
        'noTimeForFollowup' => __('Not enough time remaining for a follow-up', 'bfluxco'),
    ),
    'timerDuration' => 300, // 5 minutes in seconds
    'timerWarningThreshold' => 60, // 1 minute - disable follow-ups
    'timerCriticalThreshold' => 30, // 30 seconds - session ending
    'replayDisableThreshold' => 20, // 20 seconds - disable replay
));

// Add inline script for transcript toggle event delegation (cache-bust fallback)
wp_add_inline_script('bfluxco-interview-raybot', "
    document.addEventListener('DOMContentLoaded', function() {
        var container = document.querySelector('.interview-raybot');
        if (container) {
            container.addEventListener('click', function(e) {
                var toggle = e.target.closest('.interview-transcript-toggle');
                if (toggle && container.interviewRaybot) {
                    e.preventDefault();
                    container.interviewRaybot.toggleTranscript();
                }
            });
        }
    });
", 'after');

get_footer();
