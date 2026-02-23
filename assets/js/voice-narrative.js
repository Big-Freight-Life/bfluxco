/**
 * Voice Narrative Engine
 *
 * Voice-first storytelling for case studies.
 * Provides synchronized audio playback with transcript highlighting,
 * narrative state detection, and accessible controls.
 *
 * @package BFLUXCO
 * @version 1.0.0
 */

(function() {
  'use strict';

  // ==========================================================================
  // CONFIGURATION
  // ==========================================================================

  const CONFIG = {
    skipSeconds: 15,
    speeds: [0.75, 1, 1.25, 1.5],
    defaultSpeed: 1,
    highlightScrollOffset: 150,
    scrollBehavior: 'smooth',
    updateInterval: 100, // ms between time updates

    // Capsule activation thresholds
    capsuleActivationThreshold: 0.25, // Top quarter of viewport (tighter zone)
    capsuleTransitionDuration: 400, // ms for state transitions
    scrollHysteresis: 200, // ms before switching sections on scroll
  };

  // Narrative state definitions
  const NARRATIVE_STATES = {
    grounding: {
      id: 'grounding',
      label: 'Setting Context',
      keywords: /^(in|at|during|when|before)\s|initially|originally|at first|background|context|situation|environment|\d{4}|years? ago/i
    },
    tension: {
      id: 'tension',
      label: 'The Challenge',
      keywords: /however|but|yet|although|despite|challenge|problem|issue|obstacle|constraint|difficult|complex|competing|conflict|risk|pressure/i
    },
    decision: {
      id: 'decision',
      label: 'Making Choices',
      keywords: /decided|chose|selected|approach|strategy|because|therefore|thus|so we|trade-?off|priorit|weigh|consider|option|alternative/i
    },
    outcome: {
      id: 'outcome',
      label: 'Results',
      keywords: /result|outcome|achieve|accomplish|learned|realized|discovered|understood|ultimately|finally|in the end|impact|effect|improvement/i
    }
  };

  // ==========================================================================
  // VOICE NARRATIVE CLASS
  // ==========================================================================

  class VoiceNarrative {
    constructor(container) {
      this.container = container;
      this.audio = null;
      this.isPlaying = false;
      this.currentSpeed = CONFIG.defaultSpeed;
      this.currentSentenceIndex = -1;
      this.currentSection = null;
      this.currentState = null;
      this.updateTimer = null;

      // Capsule system state
      this.activeCapsule = null; // Currently active capsule element
      this.activationDriver = 'scroll'; // 'voice' or 'scroll'
      this.isComplete = false; // Interview completion state

      // Scroll sync mode
      this.scrollSyncEnabled = false;
      this.scrollObserver = null;
      this.pendingCapsule = null; // For hysteresis
      this.hysteresisTimer = null; // For scroll hysteresis

      // Cache DOM elements
      this.elements = {};

      // Bind methods
      this.handlePlay = this.handlePlay.bind(this);
      this.handlePause = this.handlePause.bind(this);
      this.handleTimeUpdate = this.handleTimeUpdate.bind(this);
      this.handleKeyboard = this.handleKeyboard.bind(this);
      this.handleProgressClick = this.handleProgressClick.bind(this);
      this.handleSentenceClick = this.handleSentenceClick.bind(this);
      this.handleScroll = this.handleScroll.bind(this);

      // Initialize
      this.init();
    }

    // --------------------------------------------------------------------------
    // Initialization
    // --------------------------------------------------------------------------

    init() {
      // Get audio source
      const audioSrc = this.container.dataset.audioSrc;
      if (!audioSrc) {
        console.warn('VoiceNarrative: No audio source specified');
        return;
      }

      // Cache elements
      this.cacheElements();

      // Create audio element
      this.createAudio(audioSrc);

      // Build control bar
      this.buildControlBar();

      // Parse transcript timestamps
      this.parseTranscript();

      // Validate timestamps (dev mode)
      this.validateTimestamps();

      // Bind events
      this.bindEvents();

      // Check for reduced motion preference
      this.reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

      // Initialize scroll sync if no audio or as fallback
      this.initScrollSync();
    }

    /**
     * Initialize scroll-based synchronization
     * Activates when audio is not playing
     */
    initScrollSync() {
      // Check if IntersectionObserver is supported
      if (!('IntersectionObserver' in window)) return;

      // Use transcript container as root in split layout
      const observerRoot = this.isSplitLayout && this.elements.transcriptContainer
        ? this.elements.transcriptContainer
        : null;

      // Create observer for capsule intersection
      // This provides a secondary activation mechanism for edge cases
      this.scrollObserver = new IntersectionObserver(
        (entries) => {
          // Voice mode takes priority
          if (this.isPlaying) return;

          entries.forEach(entry => {
            if (entry.isIntersecting && entry.intersectionRatio > 0.4) {
              const capsule = entry.target;

              // Activate this capsule (scroll-driven)
              this.activateCapsule(capsule);
              this.container.classList.add('scroll-synced');
            }
          });
        },
        {
          root: observerRoot,
          rootMargin: '-33% 0px -33% 0px', // Activate when in middle third
          threshold: [0, 0.3, 0.4, 0.5, 0.6, 0.7, 1]
        }
      );

      // Observe all capsules (narrative sections)
      this.elements.sections.forEach(section => {
        this.scrollObserver.observe(section);
      });

      // Enable scroll sync by default (will be disabled when audio plays)
      this.enableScrollSync();

      // Activate first capsule on load
      if (this.elements.sections.length > 0) {
        this.activateCapsule(this.elements.sections[0]);
      }
    }

    /**
     * Enable scroll-based sync mode
     */
    enableScrollSync() {
      this.scrollSyncEnabled = true;
      this.container.classList.add('scroll-synced');

      // Add scroll listener for smooth updates
      // In split layout, listen to the transcript container's scroll
      if (this.isSplitLayout && this.elements.transcriptContainer) {
        this.elements.transcriptContainer.addEventListener('scroll', this.handleScroll, { passive: true });
      } else {
        window.addEventListener('scroll', this.handleScroll, { passive: true });
      }
    }

    /**
     * Disable scroll-based sync mode
     */
    disableScrollSync() {
      this.scrollSyncEnabled = false;
      this.container.classList.remove('scroll-synced');

      if (this.isSplitLayout && this.elements.transcriptContainer) {
        this.elements.transcriptContainer.removeEventListener('scroll', this.handleScroll);
      } else {
        window.removeEventListener('scroll', this.handleScroll);
      }
    }

    /**
     * Handle scroll events for capsule activation (scroll-driven mode)
     * Uses hysteresis to prevent premature section switching.
     */
    handleScroll() {
      // Voice mode takes priority - ignore scroll when playing
      if (this.isPlaying || !this.scrollSyncEnabled) return;

      // Throttle scroll handling
      if (this.scrollThrottle) return;
      this.scrollThrottle = true;

      requestAnimationFrame(() => {
        this.scrollThrottle = false;

        // Get the viewport reference (container in split layout, window otherwise)
        const viewport = this.isSplitLayout && this.elements.transcriptContainer
          ? this.elements.transcriptContainer
          : null;
        const viewportRect = viewport ? viewport.getBoundingClientRect() : null;
        const viewportHeight = viewport ? viewportRect.height : window.innerHeight;
        const viewportTop = viewport ? viewportRect.top : 0;

        // Activation zone: top quarter of viewport (tighter than before)
        const activationZone = viewportHeight * CONFIG.capsuleActivationThreshold;

        // Find the capsule whose top is closest to (but below) the activation zone
        let capsuleToActivate = null;
        let minDistance = Infinity;

        this.elements.sections.forEach(section => {
          const rect = section.getBoundingClientRect();
          const relativeTop = viewport ? rect.top - viewportTop : rect.top;

          // Capsule is active if its top has passed the activation zone
          // but it's still mostly visible
          if (relativeTop <= activationZone && relativeTop > -rect.height * 0.7) {
            const distance = Math.abs(relativeTop - activationZone);
            if (distance < minDistance) {
              minDistance = distance;
              capsuleToActivate = section;
            }
          }
        });

        // Fallback: if no capsule found, use the most visible one
        if (!capsuleToActivate) {
          let maxVisibility = 0;
          this.elements.sections.forEach(section => {
            const rect = section.getBoundingClientRect();
            const relativeTop = viewport ? rect.top - viewportTop : rect.top;
            const relativeBottom = viewport ? rect.bottom - viewportTop : rect.bottom;
            const visibleTop = Math.max(0, relativeTop);
            const visibleBottom = Math.min(viewportHeight, relativeBottom);
            const visibleHeight = Math.max(0, visibleBottom - visibleTop);

            if (visibleHeight > maxVisibility) {
              maxVisibility = visibleHeight;
              capsuleToActivate = section;
            }
          });
        }

        // Apply hysteresis: only switch if the new capsule stays in zone
        if (capsuleToActivate && capsuleToActivate !== this.activeCapsule) {
          // If this is a different capsule than pending, reset timer
          if (capsuleToActivate !== this.pendingCapsule) {
            this.pendingCapsule = capsuleToActivate;
            clearTimeout(this.hysteresisTimer);

            // Wait before actually switching
            this.hysteresisTimer = setTimeout(() => {
              if (this.pendingCapsule && !this.isPlaying) {
                this.activateCapsule(this.pendingCapsule);
                this.pendingCapsule = null;
              }
            }, CONFIG.scrollHysteresis);
          }
        } else if (capsuleToActivate === this.activeCapsule) {
          // Current capsule is still valid, cancel any pending switch
          clearTimeout(this.hysteresisTimer);
          this.pendingCapsule = null;
        }
      });
    }

    /**
     * Update scroll indicator dots
     */
    updateScrollDots(activeState) {
      const dots = this.container.querySelectorAll('.voice-scroll-dot');
      dots.forEach(dot => {
        dot.classList.toggle('is-active', dot.dataset.state === activeState);
      });
    }

    cacheElements() {
      this.elements = {
        playBtn: this.container.querySelector('.voice-play-cta'),
        transcript: this.container.querySelector('.voice-transcript'),
        visualArea: this.container.querySelector('.voice-visual-area, .voice-split-image'),
        transcriptContainer: this.container.querySelector('.voice-split-right'),
        sections: this.container.querySelectorAll('.narrative-section'),
        sentences: this.container.querySelectorAll('.transcript-sentence'),
        loading: this.container.querySelector('.voice-loading'),
        error: this.container.querySelector('.voice-error'),
        retryBtn: this.container.querySelector('.voice-retry-btn'),
      };

      // Check if we're in split layout mode
      this.isSplitLayout = this.container.classList.contains('voice-split-layout');
    }

    createAudio(src) {
      this.audio = new Audio();
      this.audio.preload = 'metadata';
      this.audio.src = src;

      // Audio events
      this.audio.addEventListener('loadedmetadata', () => {
        this.updateDuration();
        this.container.classList.remove('is-loading');
      });

      this.audio.addEventListener('play', this.handlePlay);
      this.audio.addEventListener('pause', this.handlePause);
      this.audio.addEventListener('ended', () => this.handleEnded());
      this.audio.addEventListener('error', (e) => this.handleError(e));
      this.audio.addEventListener('waiting', () => this.showLoading(true));
      this.audio.addEventListener('canplay', () => this.showLoading(false));
    }

    buildControlBar() {
      const controlBar = document.createElement('div');
      controlBar.className = 'voice-control-bar';
      controlBar.setAttribute('role', 'region');
      controlBar.setAttribute('aria-label', 'Audio playback controls');

      controlBar.innerHTML = `
        <div class="voice-control-inner">
          <div class="voice-controls-group">
            <button type="button" class="voice-control-btn skip-back" aria-label="Skip back ${CONFIG.skipSeconds} seconds">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M11 17l-5-5 5-5"/>
                <path d="M18 17l-5-5 5-5"/>
              </svg>
              <span class="skip-time">${CONFIG.skipSeconds}</span>
            </button>

            <button type="button" class="voice-control-btn play-pause" aria-label="Play">
              <svg class="icon-play" viewBox="0 0 24 24" fill="currentColor">
                <path d="M8 5v14l11-7z"/>
              </svg>
              <svg class="icon-pause" viewBox="0 0 24 24" fill="currentColor" style="display:none">
                <rect x="6" y="4" width="4" height="16"/>
                <rect x="14" y="4" width="4" height="16"/>
              </svg>
            </button>

            <button type="button" class="voice-control-btn skip-forward" aria-label="Skip forward ${CONFIG.skipSeconds} seconds">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M13 17l5-5-5-5"/>
                <path d="M6 17l5-5-5-5"/>
              </svg>
              <span class="skip-time">${CONFIG.skipSeconds}</span>
            </button>
          </div>

          <div class="voice-progress-container">
            <div class="voice-progress-bar" role="slider" tabindex="0"
                 aria-label="Audio progress" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
              <div class="voice-progress-fill"></div>
              <div class="voice-progress-handle"></div>
            </div>
            <div class="voice-time-display">
              <span class="voice-time-current">0:00</span> /
              <span class="voice-time-total">0:00</span>
            </div>
          </div>

          <div class="voice-state-indicator" aria-live="polite"></div>

          <div class="voice-speed-control">
            <button type="button" class="voice-speed-btn" aria-haspopup="true" aria-expanded="false">
              <span class="voice-speed-value">1x</span>
              <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                <path d="M7 10l5 5 5-5z"/>
              </svg>
            </button>
            <div class="voice-speed-menu" role="menu" aria-label="Playback speed">
              ${CONFIG.speeds.map(speed => `
                <button type="button" class="voice-speed-option ${speed === CONFIG.defaultSpeed ? 'is-active' : ''}"
                        role="menuitem" data-speed="${speed}">
                  ${speed}x
                </button>
              `).join('')}
            </div>
          </div>

          <div class="voice-keyboard-hints">
            <span><kbd>Space</kbd> Play/Pause</span>
            <span><kbd>←</kbd><kbd>→</kbd> Skip</span>
          </div>

          <button type="button" class="voice-control-btn voice-close-btn" aria-label="Close controls">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M18 6L6 18M6 6l12 12"/>
            </svg>
          </button>
        </div>
      `;

      document.body.appendChild(controlBar);

      // Create floating reopen button
      this.reopenBtn = document.createElement('button');
      this.reopenBtn.type = 'button';
      this.reopenBtn.className = 'voice-reopen-btn';
      this.reopenBtn.setAttribute('aria-label', 'Show audio controls');
      this.reopenBtn.innerHTML = `
        <svg viewBox="0 0 24 24" fill="currentColor">
          <path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z"/>
        </svg>
      `;
      document.body.appendChild(this.reopenBtn);
      this.controlBar = controlBar;

      // Cache control bar elements
      this.elements.controlBar = controlBar;
      this.elements.playPauseBtn = controlBar.querySelector('.play-pause');
      this.elements.skipBackBtn = controlBar.querySelector('.skip-back');
      this.elements.skipForwardBtn = controlBar.querySelector('.skip-forward');
      this.elements.progressBar = controlBar.querySelector('.voice-progress-bar');
      this.elements.progressFill = controlBar.querySelector('.voice-progress-fill');
      this.elements.progressHandle = controlBar.querySelector('.voice-progress-handle');
      this.elements.timeCurrent = controlBar.querySelector('.voice-time-current');
      this.elements.timeTotal = controlBar.querySelector('.voice-time-total');
      this.elements.stateIndicator = controlBar.querySelector('.voice-state-indicator');
      this.elements.speedBtn = controlBar.querySelector('.voice-speed-btn');
      this.elements.speedMenu = controlBar.querySelector('.voice-speed-menu');
      this.elements.speedOptions = controlBar.querySelectorAll('.voice-speed-option');
      this.elements.iconPlay = controlBar.querySelector('.icon-play');
      this.elements.iconPause = controlBar.querySelector('.icon-pause');
      this.elements.closeBtn = controlBar.querySelector('.voice-close-btn');
      this.elements.reopenBtn = this.reopenBtn;
    }

    parseTranscript() {
      this.sentences = [];

      this.elements.sentences.forEach((el, index) => {
        const start = parseFloat(el.dataset.start) || 0;
        const end = parseFloat(el.dataset.end) || 0;
        const section = el.closest('.narrative-section');
        const state = section ? section.dataset.state : 'grounding';

        this.sentences.push({
          element: el,
          index,
          start,
          end,
          state,
          section
        });
      });

      // Sort by start time
      this.sentences.sort((a, b) => a.start - b.start);
    }

    /**
     * Validate transcript timestamps (dev mode warnings)
     */
    validateTimestamps() {
      if (this.sentences.length === 0) return;

      const issues = [];

      // Check for sequential timestamps
      for (let i = 1; i < this.sentences.length; i++) {
        const prev = this.sentences[i - 1];
        const curr = this.sentences[i];

        // Check for gaps > 0.5s
        if (curr.start - prev.end > 0.5) {
          issues.push(`Gap of ${(curr.start - prev.end).toFixed(1)}s between sentences ${i-1} and ${i}`);
        }

        // Check for overlaps
        if (curr.start < prev.end) {
          issues.push(`Overlap: sentence ${i} starts at ${curr.start}s but sentence ${i-1} ends at ${prev.end}s`);
        }
      }

      // Check that timestamps are valid numbers
      this.sentences.forEach((sentence, i) => {
        if (isNaN(sentence.start) || isNaN(sentence.end)) {
          issues.push(`Sentence ${i} has invalid timestamps: start=${sentence.start}, end=${sentence.end}`);
        }
        if (sentence.end <= sentence.start) {
          issues.push(`Sentence ${i} has end <= start: ${sentence.start}s to ${sentence.end}s`);
        }
      });

      // Log issues in development
      if (issues.length > 0) {
        console.warn('VoiceNarrative: Timestamp validation issues detected:');
        issues.forEach(issue => console.warn('  -', issue));
      }

      // Wait for audio duration to validate final timestamp
      this.audio.addEventListener('loadedmetadata', () => {
        const lastSentence = this.sentences[this.sentences.length - 1];
        const audioDuration = this.audio.duration;
        const tolerance = 2; // 2 second tolerance

        if (lastSentence && Math.abs(lastSentence.end - audioDuration) > tolerance) {
          console.warn(
            `VoiceNarrative: Last sentence ends at ${lastSentence.end}s but audio is ${audioDuration.toFixed(1)}s (${Math.abs(lastSentence.end - audioDuration).toFixed(1)}s difference)`
          );
        }

        // Mark as validated
        this.container.dataset.timestampsValidated = 'true';
      }, { once: true });
    }

    // --------------------------------------------------------------------------
    // Event Binding
    // --------------------------------------------------------------------------

    bindEvents() {
      // Play button
      if (this.elements.playBtn) {
        this.elements.playBtn.addEventListener('click', () => this.togglePlay());
      }

      // Control bar buttons
      this.elements.playPauseBtn.addEventListener('click', () => this.togglePlay());
      this.elements.skipBackBtn.addEventListener('click', () => this.skip(-CONFIG.skipSeconds));
      this.elements.skipForwardBtn.addEventListener('click', () => this.skip(CONFIG.skipSeconds));

      // Close and reopen buttons
      this.elements.closeBtn.addEventListener('click', () => this.hideControlBar());
      this.elements.reopenBtn.addEventListener('click', () => this.showControlBar(true));

      // Progress bar
      this.elements.progressBar.addEventListener('click', this.handleProgressClick);
      this.elements.progressBar.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') {
          e.preventDefault();
          this.skip(-5);
        } else if (e.key === 'ArrowRight') {
          e.preventDefault();
          this.skip(5);
        }
      });

      // Drag progress bar
      this.bindProgressDrag();

      // Speed control
      this.elements.speedBtn.addEventListener('click', () => this.toggleSpeedMenu());
      this.elements.speedOptions.forEach(option => {
        option.addEventListener('click', () => {
          this.setSpeed(parseFloat(option.dataset.speed));
          this.closeSpeedMenu();
        });
      });

      // Sentence clicks
      this.elements.sentences.forEach(sentence => {
        sentence.addEventListener('click', this.handleSentenceClick);
      });

      // Retry button
      if (this.elements.retryBtn) {
        this.elements.retryBtn.addEventListener('click', () => this.retry());
      }

      // Global keyboard shortcuts
      document.addEventListener('keydown', this.handleKeyboard);

      // Close speed menu on outside click
      document.addEventListener('click', (e) => {
        if (!e.target.closest('.voice-speed-control')) {
          this.closeSpeedMenu();
        }
      });

      // Page visibility
      document.addEventListener('visibilitychange', () => {
        if (document.hidden && this.isPlaying) {
          // Optionally pause when tab is hidden
          // this.pause();
        }
      });
    }

    bindProgressDrag() {
      let isDragging = false;

      const getProgress = (e) => {
        const rect = this.elements.progressBar.getBoundingClientRect();
        const x = e.clientX || (e.touches && e.touches[0].clientX);
        return Math.max(0, Math.min(1, (x - rect.left) / rect.width));
      };

      const startDrag = (e) => {
        isDragging = true;
        updateDrag(e);
      };

      const updateDrag = (e) => {
        if (!isDragging) return;
        e.preventDefault();
        const progress = getProgress(e);
        this.seekToProgress(progress);
      };

      const endDrag = () => {
        isDragging = false;
      };

      this.elements.progressBar.addEventListener('mousedown', startDrag);
      this.elements.progressBar.addEventListener('touchstart', startDrag, { passive: false });

      document.addEventListener('mousemove', updateDrag);
      document.addEventListener('touchmove', updateDrag, { passive: false });

      document.addEventListener('mouseup', endDrag);
      document.addEventListener('touchend', endDrag);
    }

    // --------------------------------------------------------------------------
    // Playback Controls
    // --------------------------------------------------------------------------

    async togglePlay() {
      if (this.isPlaying) {
        this.pause();
      } else {
        await this.play();
      }
    }

    async play() {
      try {
        this.showLoading(true);
        await this.audio.play();
      } catch (error) {
        console.error('VoiceNarrative: Playback failed', error);
        this.handleError(error);
      }
    }

    pause() {
      this.audio.pause();
    }

    skip(seconds) {
      if (!this.audio.duration) return;
      const newTime = Math.max(0, Math.min(this.audio.duration, this.audio.currentTime + seconds));
      this.audio.currentTime = newTime;
    }

    seekToProgress(progress) {
      if (!this.audio.duration) return;
      this.audio.currentTime = progress * this.audio.duration;
    }

    seekToTime(time) {
      if (!this.audio.duration) return;
      this.audio.currentTime = Math.max(0, Math.min(this.audio.duration, time));
    }

    setSpeed(speed) {
      this.currentSpeed = speed;
      this.audio.playbackRate = speed;

      // Update UI
      this.elements.speedBtn.querySelector('.voice-speed-value').textContent = speed + 'x';
      this.elements.speedOptions.forEach(option => {
        option.classList.toggle('is-active', parseFloat(option.dataset.speed) === speed);
      });
    }

    // --------------------------------------------------------------------------
    // Event Handlers
    // --------------------------------------------------------------------------

    handlePlay() {
      this.isPlaying = true;
      this.isComplete = false;
      this.activationDriver = 'voice';

      // Update UI state (no jarring mode switch)
      this.container.classList.add('voice-playing');
      this.container.classList.remove('scroll-synced', 'is-complete');

      // Voice takes over activation - disable scroll observer
      this.disableScrollSync();

      this.showControlBar(true);
      this.updatePlayPauseIcon(true);
      this.updateModeIndicator('voice');
      this.elements.playPauseBtn.setAttribute('aria-label', 'Pause');
      this.startTimeUpdates();

      // Hide completion overlay if it was visible
      this.hideCompletionOverlay();

      // Immediately sync capsule to current audio time
      const currentCapsule = this.getCapsuleByTime(this.audio.currentTime);
      if (currentCapsule) {
        this.activateCapsule(currentCapsule);
      }
    }

    handlePause() {
      this.isPlaying = false;
      this.activationDriver = 'scroll';

      this.updatePlayPauseIcon(false);
      this.updateModeIndicator('scroll');
      this.elements.playPauseBtn.setAttribute('aria-label', 'Play');
      this.stopTimeUpdates();

      // Seamlessly hand off to scroll - capsule state persists
      // No visible "mode switch" - just re-enable scroll observer
      this.enableScrollSync();
    }

    handleEnded() {
      this.isPlaying = false;
      this.isComplete = true;
      this.updatePlayPauseIcon(false);
      this.elements.playPauseBtn.setAttribute('aria-label', 'Replay');

      // Mark completion state on container
      this.container.classList.add('is-complete');
      this.container.classList.remove('voice-playing');

      // Update progress bar to show completion (success state)
      this.elements.progressFill.classList.add('is-complete');

      // Show completion overlay
      this.showCompletionOverlay();

      // Update mode indicator
      this.updateModeIndicator('complete');

      // Enable scroll sync for continued reading
      this.enableScrollSync();
    }

    handleError(error) {
      console.error('VoiceNarrative: Audio error', error);
      this.container.classList.add('has-error');
      this.container.classList.remove('is-loading');
    }

    handleTimeUpdate() {
      const currentTime = this.audio.currentTime;

      // Update progress bar
      this.updateProgress();

      // Update current time display
      this.elements.timeCurrent.textContent = this.formatTime(currentTime);

      // Find and highlight current sentence
      this.updateCurrentSentence(currentTime);
    }

    handleProgressClick(e) {
      const rect = this.elements.progressBar.getBoundingClientRect();
      const progress = (e.clientX - rect.left) / rect.width;
      this.seekToProgress(progress);
    }

    handleSentenceClick(e) {
      if (!this.isPlaying && !this.controlBar.classList.contains('is-visible')) {
        return; // Only clickable when playing or control bar is visible
      }

      const sentence = e.currentTarget;
      const start = parseFloat(sentence.dataset.start);

      if (!isNaN(start)) {
        this.seekToTime(start);
        if (!this.isPlaying) {
          this.play();
        }
      }
    }

    handleKeyboard(e) {
      // Only handle if control bar is visible
      if (!this.controlBar.classList.contains('is-visible')) return;

      // Ignore if typing in an input
      if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') return;

      switch (e.key) {
        case ' ':
          e.preventDefault();
          this.togglePlay();
          break;
        case 'ArrowLeft':
          if (!e.target.closest('.voice-progress-bar')) {
            e.preventDefault();
            this.skip(-CONFIG.skipSeconds);
          }
          break;
        case 'ArrowRight':
          if (!e.target.closest('.voice-progress-bar')) {
            e.preventDefault();
            this.skip(CONFIG.skipSeconds);
          }
          break;
        case 'Escape':
          if (this.isPlaying) {
            this.pause();
          }
          break;
      }
    }

    // --------------------------------------------------------------------------
    // UI Updates
    // --------------------------------------------------------------------------

    updateProgress() {
      if (!this.audio.duration) return;

      const progress = (this.audio.currentTime / this.audio.duration) * 100;
      this.elements.progressFill.style.width = progress + '%';
      this.elements.progressHandle.style.left = progress + '%';

      // Update ARIA
      this.elements.progressBar.setAttribute('aria-valuenow', Math.round(progress));
    }

    updateDuration() {
      this.elements.timeTotal.textContent = this.formatTime(this.audio.duration);

      // Update duration in play button if exists
      const durationEl = this.container.querySelector('.voice-play-cta-duration');
      if (durationEl) {
        durationEl.textContent = this.formatTime(this.audio.duration);
      }
    }

    updatePlayPauseIcon(isPlaying) {
      this.elements.iconPlay.style.display = isPlaying ? 'none' : 'block';
      this.elements.iconPause.style.display = isPlaying ? 'block' : 'none';
    }

    updateCurrentSentence(currentTime) {
      let foundIndex = -1;

      // Find the current sentence
      for (let i = 0; i < this.sentences.length; i++) {
        const sentence = this.sentences[i];
        if (currentTime >= sentence.start && currentTime < sentence.end) {
          foundIndex = i;
          break;
        }
      }

      // If we're past all sentences, show last one
      if (foundIndex === -1 && this.sentences.length > 0) {
        const lastSentence = this.sentences[this.sentences.length - 1];
        if (currentTime >= lastSentence.end) {
          foundIndex = this.sentences.length - 1;
        }
      }

      // Only update if changed
      if (foundIndex !== this.currentSentenceIndex) {
        this.highlightSentence(foundIndex);
        this.currentSentenceIndex = foundIndex;

        // Activate capsule based on current time (voice-driven)
        if (foundIndex >= 0) {
          const sentence = this.sentences[foundIndex];

          // Activate the capsule containing this sentence
          const capsule = this.getCapsuleByTime(currentTime);
          if (capsule) {
            this.activateCapsule(capsule);
          }

          // Scroll to keep sentence visible
          this.scrollToSentence(sentence.element);
        }
      }
    }

    highlightSentence(index) {
      // Clear previous highlights
      this.elements.sentences.forEach((el, i) => {
        el.classList.remove('is-current');
        if (i < index) {
          el.classList.add('is-past');
        } else {
          el.classList.remove('is-past');
        }
      });

      // Highlight current
      if (index >= 0 && index < this.sentences.length) {
        this.sentences[index].element.classList.add('is-current');
      }
    }

    clearAllHighlights() {
      this.elements.sentences.forEach(el => {
        el.classList.remove('is-current', 'is-past');
      });
      this.currentSentenceIndex = -1;
    }

    /**
     * Update mode indicator (Listening/Reading/Complete)
     */
    updateModeIndicator(mode) {
      const indicator = this.container.querySelector('.voice-mode-indicator');
      if (!indicator) return;

      const textEl = indicator.querySelector('.voice-mode-text');
      if (!textEl) return;

      // Update text and class
      indicator.classList.remove('mode-voice', 'mode-scroll', 'mode-complete');

      switch (mode) {
        case 'voice':
          textEl.textContent = 'Listening';
          indicator.classList.add('mode-voice');
          break;
        case 'scroll':
          textEl.textContent = 'Reading';
          indicator.classList.add('mode-scroll');
          break;
        case 'complete':
          textEl.textContent = 'Complete';
          indicator.classList.add('mode-complete');
          break;
      }

      // Pulse animation on mode switch
      indicator.classList.add('mode-switching');
      setTimeout(() => indicator.classList.remove('mode-switching'), 300);
    }

    /**
     * Show completion overlay
     */
    showCompletionOverlay() {
      // Create overlay if it doesn't exist
      if (!this.completionOverlay) {
        this.createCompletionOverlay();
      }

      // Show with animation
      requestAnimationFrame(() => {
        this.completionOverlay.classList.add('is-visible');
      });
    }

    /**
     * Hide completion overlay
     */
    hideCompletionOverlay() {
      if (this.completionOverlay) {
        this.completionOverlay.classList.remove('is-visible');
      }

      // Reset progress bar completion state
      if (this.elements.progressFill) {
        this.elements.progressFill.classList.remove('is-complete');
      }
    }

    /**
     * Create completion overlay element
     */
    createCompletionOverlay() {
      this.completionOverlay = document.createElement('div');
      this.completionOverlay.className = 'voice-completion-overlay';
      this.completionOverlay.setAttribute('role', 'dialog');
      this.completionOverlay.setAttribute('aria-label', 'Interview complete');

      this.completionOverlay.innerHTML = `
        <div class="voice-completion-content">
          <div class="voice-completion-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
              <polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
          </div>
          <h3 class="voice-completion-title">Interview Complete</h3>
          <p class="voice-completion-message">You've finished listening to this case study.</p>
          <div class="voice-completion-actions">
            <button type="button" class="voice-completion-btn voice-completion-replay">
              <svg viewBox="0 0 24 24" fill="currentColor" width="16" height="16">
                <path d="M12 5V1L7 6l5 5V7c3.31 0 6 2.69 6 6s-2.69 6-6 6-6-2.69-6-6H4c0 4.42 3.58 8 8 8s8-3.58 8-8-3.58-8-8-8z"/>
              </svg>
              Replay
            </button>
            <button type="button" class="voice-completion-btn voice-completion-continue">
              Continue Reading
            </button>
          </div>
        </div>
      `;

      // Bind events
      const replayBtn = this.completionOverlay.querySelector('.voice-completion-replay');
      const continueBtn = this.completionOverlay.querySelector('.voice-completion-continue');

      replayBtn.addEventListener('click', () => {
        this.audio.currentTime = 0;
        this.hideCompletionOverlay();
        this.clearAllHighlights();
        this.isComplete = false;
        this.container.classList.remove('is-complete');

        // Activate first capsule
        if (this.elements.sections.length > 0) {
          this.activateCapsule(this.elements.sections[0]);
        }

        this.play();
      });

      continueBtn.addEventListener('click', () => {
        this.hideCompletionOverlay();
        // Keep completion state but allow scrolling
      });

      // Append to container
      this.container.appendChild(this.completionOverlay);
    }

    scrollToSentence(element) {
      if (!element || this.reducedMotion) return;

      // For split layout, scroll the transcript container
      if (this.isSplitLayout && this.elements.transcriptContainer) {
        const container = this.elements.transcriptContainer;
        const containerRect = container.getBoundingClientRect();
        const elementRect = element.getBoundingClientRect();

        // Check if element is outside visible area of container
        const relativeTop = elementRect.top - containerRect.top;
        const relativeBottom = elementRect.bottom - containerRect.top;
        const containerHeight = containerRect.height;
        const scrollPadding = 100; // Padding from top/bottom

        if (relativeTop < scrollPadding || relativeBottom > containerHeight - scrollPadding) {
          // Calculate scroll position to center the element
          const elementCenter = element.offsetTop - container.offsetTop;
          const scrollTarget = elementCenter - (containerHeight / 3);

          container.scrollTo({
            top: Math.max(0, scrollTarget),
            behavior: CONFIG.scrollBehavior
          });
        }
      } else {
        // Standard layout - scroll the window
        const rect = element.getBoundingClientRect();
        const isAbove = rect.top < CONFIG.highlightScrollOffset;
        const isBelow = rect.bottom > window.innerHeight - CONFIG.highlightScrollOffset;

        if (isAbove || isBelow) {
          const targetY = window.scrollY + rect.top - CONFIG.highlightScrollOffset;
          window.scrollTo({
            top: targetY,
            behavior: CONFIG.scrollBehavior
          });
        }
      }
    }

    // --------------------------------------------------------------------------
    // Capsule Activation System
    // --------------------------------------------------------------------------

    /**
     * Activate a capsule (only one active at a time)
     * This is the single point of control for capsule state changes.
     * Works identically whether driven by voice or scroll.
     *
     * @param {Element} capsule - The capsule element to activate
     * @param {string} driver - 'voice' or 'scroll' (for debugging only)
     */
    activateCapsule(capsule) {
      if (!capsule || capsule === this.activeCapsule) return;

      const previousCapsule = this.activeCapsule;
      const previousState = this.currentState;
      const newState = capsule.dataset.state;

      // Deactivate previous capsule
      if (previousCapsule) {
        previousCapsule.classList.remove('is-active');
      }

      // Activate new capsule
      capsule.classList.add('is-active');
      this.activeCapsule = capsule;
      this.currentState = newState;

      // Update container state
      this.container.dataset.narrativeState = newState;

      // Update state indicator in control bar
      const stateConfig = NARRATIVE_STATES[newState];
      if (stateConfig && this.elements.stateIndicator) {
        this.elements.stateIndicator.textContent = stateConfig.label;
      }

      // Update scroll dots
      this.updateScrollDots(newState);

      // Switch visual state (image transition)
      this.switchStateImage(previousState, newState);

      // Switch text overlays
      this.switchTextOverlay(previousState, newState);
    }

    /**
     * Find capsule by state ID
     */
    getCapsuleByState(state) {
      return this.container.querySelector(`.narrative-section[data-state="${state}"]`);
    }

    /**
     * Find capsule containing a specific time
     */
    getCapsuleByTime(time) {
      for (const section of this.elements.sections) {
        const start = parseFloat(section.dataset.start) || 0;
        const end = parseFloat(section.dataset.end) || Infinity;
        if (time >= start && time < end) {
          return section;
        }
      }
      return null;
    }

    updateNarrativeState(state) {
      // Use capsule activation system
      const capsule = this.getCapsuleByState(state);
      if (capsule) {
        this.activateCapsule(capsule);
      }
    }

    /**
     * Switch text overlays based on state
     */
    switchTextOverlay(fromState, toState) {
      if (!this.elements.visualArea) return;

      const overlays = this.elements.visualArea.querySelectorAll('.voice-text-overlay');
      if (overlays.length === 0) return;

      overlays.forEach(overlay => {
        const overlayState = overlay.dataset.state;
        if (overlayState === toState) {
          overlay.classList.add('is-active');
        } else {
          overlay.classList.remove('is-active');
        }
      });
    }

    /**
     * Switch between state-specific images/videos
     * Supports multiple media items per state with auto-cycling
     */
    switchStateImage(fromState, toState) {
      if (!this.elements.visualArea) return;

      const stateVisuals = this.elements.visualArea.querySelectorAll('.voice-state-image, video[data-state]');
      if (stateVisuals.length === 0) return;

      // Group visuals by state
      const visualsByState = {};
      stateVisuals.forEach(el => {
        const state = el.dataset.state;
        if (!visualsByState[state]) visualsByState[state] = [];
        visualsByState[state].push(el);
      });

      const isVideo = (el) => el.tagName === 'VIDEO';

      // Handle each state's visuals
      Object.keys(visualsByState).forEach(state => {
        const visuals = visualsByState[state];

        if (state === toState) {
          // Activate first visual for this state
          visuals.forEach((el, index) => {
            el.classList.remove('is-exiting');

            if (index === 0) {
              el.classList.add('is-active');
              if (isVideo(el)) {
                el.muted = true;
                el.play().catch(() => {});
              }
            } else {
              el.classList.remove('is-active');
              if (isVideo(el)) el.pause();
            }
          });

          // Start cycling if multiple media items (4s per item)
          if (visuals.length > 1) {
            this.startMediaCycle(state, visuals);
          }
        } else if (state === fromState) {
          // Stop cycling and exit visuals
          this.stopMediaCycle(state);

          visuals.forEach(el => {
            el.classList.remove('is-active');
            el.classList.add('is-exiting');
            if (isVideo(el)) el.pause();

            setTimeout(() => {
              el.classList.remove('is-exiting');
            }, 1200);
          });
        } else {
          // Ensure other states are hidden
          this.stopMediaCycle(state);
          visuals.forEach(el => {
            el.classList.remove('is-active', 'is-exiting');
            if (isVideo(el)) el.pause();
          });
        }
      });
    }

    /**
     * Start cycling through multiple media items for a state
     */
    startMediaCycle(state, visuals) {
      // Respect reduced motion preference - don't auto-cycle
      if (this.reducedMotion) return;

      this.stopMediaCycle(state);
      if (!this.mediaCycles) this.mediaCycles = {};
      if (!this.mediaCycleStates) this.mediaCycleStates = {};

      // Store cycle state for this state
      this.mediaCycleStates[state] = {
        currentIndex: 0,
        visuals: visuals,
        paused: false
      };

      // Create cycle indicators if multiple items
      if (visuals.length > 1) {
        this.createCycleIndicators(state, visuals);
      }

      const cycleInterval = 4000; // 4 seconds per media item

      this.mediaCycles[state] = setInterval(() => {
        const cycleState = this.mediaCycleStates[state];
        if (!cycleState || cycleState.paused) return;

        const isVideo = (el) => el.tagName === 'VIDEO';

        // Hide current
        visuals[cycleState.currentIndex].classList.remove('is-active');
        if (isVideo(visuals[cycleState.currentIndex])) {
          visuals[cycleState.currentIndex].pause();
        }

        // Move to next
        cycleState.currentIndex = (cycleState.currentIndex + 1) % visuals.length;

        // Show next
        visuals[cycleState.currentIndex].classList.add('is-active');
        if (isVideo(visuals[cycleState.currentIndex])) {
          visuals[cycleState.currentIndex].muted = true;
          visuals[cycleState.currentIndex].play().catch(() => {});
        }

        // Update indicators
        this.updateCycleIndicators(state, cycleState.currentIndex);
      }, cycleInterval);
    }

    /**
     * Stop cycling for a state
     */
    stopMediaCycle(state) {
      if (this.mediaCycles && this.mediaCycles[state]) {
        clearInterval(this.mediaCycles[state]);
        delete this.mediaCycles[state];
      }
      if (this.mediaCycleStates && this.mediaCycleStates[state]) {
        delete this.mediaCycleStates[state];
      }
      // Remove cycle indicators
      this.removeCycleIndicators(state);
    }

    /**
     * Create cycle indicators for a state's media items
     */
    createCycleIndicators(state, visuals) {
      if (!this.elements.visualArea) return;

      // Remove existing indicators
      this.removeCycleIndicators(state);

      const indicatorContainer = document.createElement('div');
      indicatorContainer.className = 'voice-cycle-indicators';
      indicatorContainer.dataset.state = state;

      visuals.forEach((_, index) => {
        const dot = document.createElement('button');
        dot.type = 'button';
        dot.className = 'voice-cycle-dot' + (index === 0 ? ' is-active' : '');
        dot.dataset.index = index;
        dot.setAttribute('aria-label', `Show image ${index + 1} of ${visuals.length}`);

        // Click to manually advance
        dot.addEventListener('click', () => this.advanceMediaCycle(state, index));

        indicatorContainer.appendChild(dot);
      });

      this.elements.visualArea.appendChild(indicatorContainer);

      // Pause cycling on hover
      if (this.elements.visualArea) {
        this.elements.visualArea.addEventListener('mouseenter', () => this.pauseMediaCycle(state));
        this.elements.visualArea.addEventListener('mouseleave', () => this.resumeMediaCycle(state));
      }
    }

    /**
     * Remove cycle indicators for a state
     */
    removeCycleIndicators(state) {
      if (!this.elements.visualArea) return;
      const existing = this.elements.visualArea.querySelector(`.voice-cycle-indicators[data-state="${state}"]`);
      if (existing) existing.remove();
    }

    /**
     * Update cycle indicators to show current index
     */
    updateCycleIndicators(state, activeIndex) {
      if (!this.elements.visualArea) return;
      const container = this.elements.visualArea.querySelector(`.voice-cycle-indicators[data-state="${state}"]`);
      if (!container) return;

      container.querySelectorAll('.voice-cycle-dot').forEach((dot, index) => {
        dot.classList.toggle('is-active', index === activeIndex);
      });
    }

    /**
     * Manually advance to a specific media item
     */
    advanceMediaCycle(state, targetIndex) {
      const cycleState = this.mediaCycleStates && this.mediaCycleStates[state];
      if (!cycleState) return;

      const visuals = cycleState.visuals;
      const isVideo = (el) => el.tagName === 'VIDEO';

      // Hide current
      visuals[cycleState.currentIndex].classList.remove('is-active');
      if (isVideo(visuals[cycleState.currentIndex])) {
        visuals[cycleState.currentIndex].pause();
      }

      // Show target
      cycleState.currentIndex = targetIndex;
      visuals[targetIndex].classList.add('is-active');
      if (isVideo(visuals[targetIndex])) {
        visuals[targetIndex].muted = true;
        visuals[targetIndex].play().catch(() => {});
      }

      // Update indicators
      this.updateCycleIndicators(state, targetIndex);
    }

    /**
     * Pause media cycling (on hover)
     */
    pauseMediaCycle(state) {
      if (this.mediaCycleStates && this.mediaCycleStates[state]) {
        this.mediaCycleStates[state].paused = true;
      }
    }

    /**
     * Resume media cycling (on mouse leave)
     */
    resumeMediaCycle(state) {
      if (this.mediaCycleStates && this.mediaCycleStates[state]) {
        this.mediaCycleStates[state].paused = false;
      }
    }

    /**
     * Initialize state images (called after images are generated/loaded)
     */
    initStateImages(images) {
      if (!this.elements.visualArea) return;

      // Mark visual area as having state images
      this.elements.visualArea.classList.add('has-state-images');

      // Create image elements for each state
      Object.entries(images).forEach(([state, url]) => {
        const img = document.createElement('img');
        img.className = 'voice-state-image';
        img.dataset.state = state;
        img.src = url;
        img.alt = `Visual for ${state} phase`;
        img.loading = 'lazy';

        // Activate first state image
        if (state === 'grounding') {
          img.classList.add('is-active');
        }

        this.elements.visualArea.appendChild(img);
      });
    }

    showControlBar(show) {
      this.controlBar.classList.toggle('is-visible', show);
      this.elements.reopenBtn.classList.toggle('is-visible', !show);
    }

    hideControlBar() {
      // Pause audio when hiding controls
      if (this.isPlaying) {
        this.pause();
      }
      this.controlBar.classList.remove('is-visible');
      this.elements.reopenBtn.classList.add('is-visible');
    }

    showLoading(show) {
      this.container.classList.toggle('is-loading', show);
    }

    toggleSpeedMenu() {
      const isOpen = this.elements.speedMenu.classList.contains('is-open');
      this.elements.speedMenu.classList.toggle('is-open');
      this.elements.speedBtn.setAttribute('aria-expanded', !isOpen);
    }

    closeSpeedMenu() {
      this.elements.speedMenu.classList.remove('is-open');
      this.elements.speedBtn.setAttribute('aria-expanded', 'false');
    }

    // --------------------------------------------------------------------------
    // Time Updates
    // --------------------------------------------------------------------------

    startTimeUpdates() {
      this.stopTimeUpdates();
      this.updateTimer = setInterval(() => {
        this.handleTimeUpdate();
      }, CONFIG.updateInterval);
    }

    stopTimeUpdates() {
      if (this.updateTimer) {
        clearInterval(this.updateTimer);
        this.updateTimer = null;
      }
    }

    // --------------------------------------------------------------------------
    // Utilities
    // --------------------------------------------------------------------------

    formatTime(seconds) {
      if (!seconds || isNaN(seconds)) return '0:00';

      const mins = Math.floor(seconds / 60);
      const secs = Math.floor(seconds % 60);
      return `${mins}:${secs.toString().padStart(2, '0')}`;
    }

    retry() {
      this.container.classList.remove('has-error');
      this.audio.load();
    }

    // --------------------------------------------------------------------------
    // Cleanup
    // --------------------------------------------------------------------------

    destroy() {
      this.stopTimeUpdates();
      document.removeEventListener('keydown', this.handleKeyboard);

      if (this.audio) {
        this.audio.pause();
        this.audio.src = '';
      }

      if (this.controlBar) {
        this.controlBar.remove();
      }
    }
  }

  // ==========================================================================
  // HEURISTIC STATE DETECTOR
  // ==========================================================================

  const HeuristicStateDetector = {
    detectState(text) {
      for (const [state, config] of Object.entries(NARRATIVE_STATES)) {
        if (config.keywords.test(text)) {
          return state;
        }
      }
      return null;
    }
  };

  // ==========================================================================
  // INITIALIZATION
  // ==========================================================================

  function initVoiceNarratives() {
    const containers = document.querySelectorAll('.voice-case-study');

    containers.forEach(container => {
      // Check if already initialized
      if (container.voiceNarrative) return;

      // Create instance
      container.voiceNarrative = new VoiceNarrative(container);
    });
  }

  // Initialize on DOM ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initVoiceNarratives);
  } else {
    initVoiceNarratives();
  }

  // Expose to global scope
  window.VoiceNarrative = VoiceNarrative;
  window.initVoiceNarratives = initVoiceNarratives;

})();
