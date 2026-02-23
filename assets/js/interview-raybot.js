/**
 * Interview Raybot - Voice-First State Machine
 *
 * 5-minute time-boxed digital twin interview experience.
 * Voice-to-voice primary with optional keyboard input.
 *
 * States:
 * - idle: Initial, waiting to start
 * - connecting: Establishing connection
 * - ready: Connected, waiting for question selection
 * - listening: User is speaking (mic active)
 * - thinking: Processing input
 * - speaking: Ray is delivering response
 * - closing: Delivering closing message
 * - complete: Session ended
 * - error: Error state
 *
 * Input Modes:
 * - voice (default)
 * - keyboard
 *
 * @package BFLUXCO
 * @version 2.0.0
 */

(function() {
    'use strict';

    // ==========================================================================
    // CONFIGURATION
    // ==========================================================================

    const CONFIG = window.interviewRaybotConfig || {
        ajaxUrl: '/wp-admin/admin-ajax.php',
        nonce: '',
        strings: {
            connecting: 'Connecting',
            ready: 'Ready',
            listening: 'Listening',
            speaking: 'Speaking',
            thinking: 'Thinking',
            sessionEnding: 'Session Ending',
            complete: 'Complete',
            error: 'Error',
            speakNow: 'Speak now...',
            tapToSpeak: 'Tap mic to speak',
            copySuccess: 'Transcript copied!',
            downloadSuccess: 'Transcript downloaded',
            noTimeForFollowup: 'Not enough time for a follow-up'
        },
        timerDuration: 300,
        timerWarningThreshold: 60,
        timerCriticalThreshold: 30,
        replayDisableThreshold: 20
    };

    // Mock response delays (milliseconds)
    const MOCK_DELAYS = {
        connect: 1500,
        think: 1200,
        speakPerChar: 45,
        speakVariance: 15,
        chunkDelay: 70,
        listenDuration: 3000 // Simulated listening time
    };

    // Placeholder responses
    const PLACEHOLDER_RESPONSES = {
        '1': {
            question: 'What is your experience with GenAI and experience design?',
            answer: "I've been working at the intersection of AI and experience design for over 8 years. My journey started in traditional UX, but I became fascinated with how conversational interfaces could create more natural, human-centered interactions. Today, I focus on helping organizations design GenAI experiences that feel intuitive and trustworthy."
        },
        '2': {
            question: 'How do you approach a new GenAI project?',
            answer: "Every project starts with understanding the human context - who are the users, what are they trying to accomplish, and where does AI fit naturally into their workflow? I use a framework I call 'Conversation Architecture' that maps out the dialogue flows, error handling, and trust-building moments before any code is written."
        },
        '3': {
            question: 'What makes a GenAI experience successful?',
            answer: "The best GenAI experiences are ones where users forget they're talking to AI - not because we're deceiving them, but because the interaction feels so natural and helpful. Success comes from three things: clear purpose, appropriate transparency, and graceful handling of uncertainty."
        },
        '4': {
            question: 'How do you work with client teams?',
            answer: "I believe in embedded collaboration. Rather than delivering a report and walking away, I work alongside product teams, engineers, and stakeholders to build shared understanding. We prototype early, test with real users, and iterate together. The goal is to transfer knowledge so the team can continue evolving the experience."
        },
        '5': {
            question: 'Can you share a specific success story?',
            answer: "One project I'm particularly proud of was helping a healthcare company redesign their patient intake chatbot. The original version had a 40% abandonment rate. By reimagining it as a conversational experience with better error recovery and empathetic language, we reduced abandonment to under 15% and improved patient satisfaction significantly."
        }
    };

    const CLOSING_MESSAGE = "Thanks for taking the time to chat with me today. I hope this gave you a sense of how I think about GenAI experience design. If you'd like to continue the conversation, please reach out through the contact page. Take care!";

    const INTRODUCTION_MESSAGE = "Hi, I'm Ray Bot — a digital version of Ray Butler. I'm here to answer your questions about GenAI experience design. Feel free to ask me anything, or pick one of the suggested questions to get started.";

    // ==========================================================================
    // STATE MACHINE CLASS
    // ==========================================================================

    class InterviewStateMachine {
        constructor(container) {
            this.container = container;
            this.state = 'idle';
            this.inputMode = 'voice';
            this.previousState = null;

            // Timer
            this.timerInterval = null;
            this.timeRemaining = CONFIG.timerDuration;
            this.timerStarted = false;

            // Interview
            this.selectedQuestion = null;
            this.currentStep = 1;
            this.followupUsed = false;
            this.transcript = [];
            this.lastResponse = null;

            // Audio
            this.isMuted = false;
            this.captionsEnabled = true;

            // Caption
            this.captionTimeout = null;
            this.currentCaptionChunks = [];
            this.captionIndex = 0;

            // Transcript resize
            this.isResizing = false;
            this.resizeStartY = 0;
            this.resizeStartHeight = 0;

            // DOM cache
            this.elements = {};

            // Bindings
            this.handleKeyboard = this.handleKeyboard.bind(this);

            this.init();
        }

        // --------------------------------------------------------------------------
        // Initialization
        // --------------------------------------------------------------------------

        init() {
            this.cacheElements();
            this.bindEvents();
            this.updateUI();
        }

        cacheElements() {
            this.elements = {
                // Top bar
                topbar: this.container.querySelector('.interview-topbar'),
                timerBadge: this.container.querySelector('.interview-timer-badge'),
                timerValue: this.container.querySelector('.interview-timer-value'),
                aboutBtn: this.container.querySelector('.interview-about-btn'),

                // Avatar stage
                avatarStage: this.container.querySelector('.interview-avatar-stage'),
                voiceStatus: this.container.querySelector('.interview-voice-status'),
                voiceStatusDot: this.container.querySelector('.interview-voice-status-dot'),
                voiceStatusText: this.container.querySelector('.interview-voice-status-text'),
                nowAnswering: this.container.querySelector('.interview-now-answering'),
                nowAnsweringText: this.container.querySelector('.interview-now-answering-text'),
                avatarContainer: this.container.querySelector('.interview-avatar-container'),
                avatarPlaceholder: this.container.querySelector('.interview-avatar-placeholder'),
                avatarSilhouette: this.container.querySelector('.interview-avatar-silhouette'),
                captionOverlay: this.container.querySelector('.interview-caption-overlay'),
                captionText: this.container.querySelector('.interview-caption-text'),
                voiceHint: this.container.querySelector('.interview-voice-hint'),

                // Controls
                controls: this.container.querySelector('.interview-controls'),
                micBtn: this.container.querySelector('.interview-mic-btn'),
                keyboardBtn: this.container.querySelector('.interview-keyboard-btn'),
                muteBtn: this.container.querySelector('.interview-mute-btn'),
                captionsBtn: this.container.querySelector('.interview-captions-btn'),
                replayBtn: this.container.querySelector('.interview-replay-btn'),

                // Keyboard tray
                keyboardTray: this.container.querySelector('.interview-keyboard-tray'),
                textInput: this.container.querySelector('.interview-text-input'),
                textSend: this.container.querySelector('.interview-text-send'),

                // Panel
                panel: this.container.querySelector('.interview-panel'),
                stepper: this.container.querySelector('.interview-stepper'),
                steps: this.container.querySelectorAll('.interview-step'),
                stepQuestion: this.container.querySelector('.interview-step-question'),
                stepAnswer: this.container.querySelector('.interview-step-answer'),
                stepFollowup: this.container.querySelector('.interview-step-followup'),

                // Questions
                questionList: this.container.querySelector('.interview-question-list'),
                questionCards: this.container.querySelectorAll('.interview-question-card'),
                startArea: this.container.querySelector('.interview-start-area'),
                startBtn: this.container.querySelector('.interview-start-btn'),
                startHint: this.container.querySelector('.interview-start-hint'),

                // Step 2
                currentQuestionText: this.container.querySelector('.interview-current-question-text'),
                answerStatusText: this.container.querySelector('.interview-answer-status-text'),

                // Step 3
                followupInstruction: this.container.querySelector('.interview-followup-instruction'),
                endSessionBtn: this.container.querySelector('.interview-end-session-btn'),
                followupTimeWarning: this.container.querySelector('.interview-followup-time-warning'),

                // Persistent End Session
                persistentEnd: this.container.querySelector('.interview-persistent-end'),
                persistentEndBtn: this.container.querySelector('.interview-end-session-persistent'),

                // Panel input (inline)
                panelInput: this.container.querySelector('.interview-panel-input'),
                panelTextInput: this.container.querySelector('.interview-panel-text-input'),
                panelSendBtn: this.container.querySelector('.interview-panel-send-btn'),

                // Inline transcript (during session)
                inlineTranscript: this.container.querySelector('.interview-inline-transcript'),
                inlineTranscriptEntries: this.container.querySelector('.interview-inline-transcript-entries'),
                inlineTranscriptEmpty: this.container.querySelector('.interview-inline-transcript .interview-transcript-empty'),
                inlineCopyBtn: this.container.querySelector('.interview-inline-copy-btn'),
                inlineDownloadBtn: this.container.querySelector('.interview-inline-download-btn'),
                transcriptResizeHandle: this.container.querySelector('.interview-transcript-resize-handle'),

                // Modals & overlays
                aboutModal: document.querySelector('.interview-about-modal'),
                aboutBackdrop: document.querySelector('.interview-about-backdrop'),
                aboutClose: document.querySelector('.interview-about-close'),
                sessionEnding: document.querySelector('.interview-session-ending'),
                sessionComplete: document.querySelector('.interview-session-complete'),
                downloadTranscriptBtn: document.querySelector('.interview-download-transcript-btn'),

                // End state left pane
                endState: this.container.querySelector('.interview-end-state'),
                endStateCta: this.container.querySelector('.interview-end-state-cta'),

                // Transcript utility mode (right panel complete state)
                transcriptUtility: this.container.querySelector('.interview-transcript-utility'),
                transcriptUtilityContent: this.container.querySelector('.interview-transcript-utility-content'),
                utilityCopyBtn: this.container.querySelector('.interview-utility-copy-btn'),
                utilityDownloadBtn: this.container.querySelector('.interview-utility-download-btn')
            };
        }

        bindEvents() {
            const self = this;

            // Question cards
            this.elements.questionCards.forEach(card => {
                card.addEventListener('click', () => {
                    const questionText = card.querySelector('.interview-question-text').textContent;
                    const questionId = card.dataset.questionId;

                    // If session is active, send immediately
                    if (self.container.dataset.sessionState === 'active') {
                        self.sendSuggestedQuestion(questionId, questionText);
                    } else if (self.canSelectQuestion()) {
                        // Pre-session: just select the question
                        self.selectQuestion(questionId, questionText);
                    }
                });
            });

            // Start button
            if (this.elements.startBtn) {
                this.elements.startBtn.addEventListener('click', () => self.startInterview());
            }

            // Mic button
            if (this.elements.micBtn) {
                this.elements.micBtn.addEventListener('click', () => self.toggleMic());
            }

            // Keyboard toggle
            if (this.elements.keyboardBtn) {
                this.elements.keyboardBtn.addEventListener('click', () => self.toggleKeyboardMode());
            }

            // Mute button
            if (this.elements.muteBtn) {
                this.elements.muteBtn.addEventListener('click', () => self.toggleMute());
            }

            // Captions button
            if (this.elements.captionsBtn) {
                this.elements.captionsBtn.addEventListener('click', () => self.toggleCaptions());
            }

            // Replay button
            if (this.elements.replayBtn) {
                this.elements.replayBtn.addEventListener('click', () => self.replayLastResponse());
            }

            // Text input
            if (this.elements.textInput) {
                this.elements.textInput.addEventListener('input', () => self.onTextInput());
                this.elements.textInput.addEventListener('keydown', e => {
                    if (e.key === 'Enter' && !e.shiftKey) {
                        e.preventDefault();
                        self.submitText();
                    }
                });
            }

            // Text send button
            if (this.elements.textSend) {
                this.elements.textSend.addEventListener('click', () => self.submitText());
            }

            // Panel text input (inline)
            if (this.elements.panelTextInput) {
                this.elements.panelTextInput.addEventListener('input', () => self.onPanelTextInput());
                this.elements.panelTextInput.addEventListener('keydown', e => {
                    if (e.key === 'Enter' && !e.shiftKey) {
                        e.preventDefault();
                        self.submitPanelText();
                    }
                });
            }

            // Panel send button
            if (this.elements.panelSendBtn) {
                this.elements.panelSendBtn.addEventListener('click', () => self.submitPanelText());
            }

            // End session button
            if (this.elements.endSessionBtn) {
                this.elements.endSessionBtn.addEventListener('click', () => self.endInterview());
            }

            // Persistent end session button
            if (this.elements.persistentEndBtn) {
                this.elements.persistentEndBtn.addEventListener('click', () => self.endInterview());
            }

            // Copy/Download transcript (inline transcript during session)
            if (this.elements.inlineCopyBtn) {
                this.elements.inlineCopyBtn.addEventListener('click', () => self.copyTranscript());
            }
            if (this.elements.inlineDownloadBtn) {
                this.elements.inlineDownloadBtn.addEventListener('click', () => self.downloadTranscript());
            }
            if (this.elements.downloadTranscriptBtn) {
                this.elements.downloadTranscriptBtn.addEventListener('click', () => self.downloadTranscript());
            }

            // Transcript utility mode buttons (complete state)
            if (this.elements.utilityCopyBtn) {
                this.elements.utilityCopyBtn.addEventListener('click', () => self.copyTranscript());
            }
            if (this.elements.utilityDownloadBtn) {
                this.elements.utilityDownloadBtn.addEventListener('click', () => self.downloadTranscript());
            }

            // About modal
            if (this.elements.aboutBtn) {
                this.elements.aboutBtn.addEventListener('click', () => self.openAboutModal());
            }
            if (this.elements.aboutClose) {
                this.elements.aboutClose.addEventListener('click', () => self.closeAboutModal());
            }
            if (this.elements.aboutBackdrop) {
                this.elements.aboutBackdrop.addEventListener('click', () => self.closeAboutModal());
            }

            // Transcript resize handle
            if (this.elements.transcriptResizeHandle) {
                this.elements.transcriptResizeHandle.addEventListener('mousedown', (e) => self.startResize(e));
                this.elements.transcriptResizeHandle.addEventListener('touchstart', (e) => self.startResize(e), { passive: false });
            }
            document.addEventListener('mousemove', (e) => self.doResize(e));
            document.addEventListener('mouseup', () => self.stopResize());
            document.addEventListener('touchmove', (e) => self.doResize(e), { passive: false });
            document.addEventListener('touchend', () => self.stopResize());

            // Global keyboard
            document.addEventListener('keydown', this.handleKeyboard);
        }

        // --------------------------------------------------------------------------
        // State Machine
        // --------------------------------------------------------------------------

        transitionTo(newState, data = {}) {
            const validTransitions = {
                'idle': ['connecting', 'error'],
                'connecting': ['ready', 'error'],
                'ready': ['listening', 'thinking', 'speaking', 'closing', 'error'],
                'listening': ['thinking', 'ready', 'error'],
                'thinking': ['speaking', 'error'],
                'speaking': ['ready', 'closing', 'error'],
                'closing': ['complete'],
                'complete': ['idle'],
                'error': ['idle', 'connecting']
            };

            if (!validTransitions[this.state] || !validTransitions[this.state].includes(newState)) {
                console.warn('InterviewRay: Invalid transition from', this.state, 'to', newState);
                return false;
            }

            this.previousState = this.state;
            this.state = newState;
            this.container.dataset.state = newState;

            this.onStateEnter(newState, data);
            this.updateUI();

            return true;
        }

        onStateEnter(state, data) {
            switch (state) {
                case 'connecting':
                    this.updateVoiceStatus(CONFIG.strings.connecting);
                    this.mockConnection();
                    break;

                case 'ready':
                    this.updateVoiceStatus(CONFIG.strings.ready);
                    if (!this.timerStarted) {
                        this.startTimer();
                        this.timerStarted = true;
                    }
                    this.elements.micBtn.dataset.micState = 'ready';

                    // Update panel input button state
                    this.onPanelTextInput();

                    // If question was selected during idle, speak it now
                    if (data.speakQuestion && this.selectedQuestion) {
                        this.speakResponse(this.selectedQuestion.id, this.selectedQuestion.text);
                    }
                    break;

                case 'listening':
                    this.updateVoiceStatus(CONFIG.strings.listening);
                    this.elements.micBtn.dataset.micState = 'listening';
                    this.showVoiceHint(true);
                    this.simulateListening();
                    break;

                case 'thinking':
                    this.updateVoiceStatus(CONFIG.strings.thinking);
                    this.elements.micBtn.dataset.micState = 'off';
                    this.showVoiceHint(false);

                    if (data.question) {
                        // Processing a question
                        setTimeout(() => {
                            if (this.state === 'thinking') {
                                this.speakResponse(data.question.id, data.question.text);
                            }
                        }, MOCK_DELAYS.think);
                    } else if (data.followup) {
                        // Processing a follow-up
                        setTimeout(() => {
                            if (this.state === 'thinking') {
                                const response = this.generateFollowupResponse(data.followup);
                                this.transitionTo('speaking', { response, isFollowup: true });
                            }
                        }, MOCK_DELAYS.think);
                    }
                    break;

                case 'speaking':
                    this.updateVoiceStatus(CONFIG.strings.speaking);
                    this.elements.micBtn.dataset.micState = 'disabled';
                    if (data.response) {
                        this.displaySpeech(data.response, data.isFollowup);
                    }
                    break;

                case 'closing':
                    this.updateVoiceStatus(CONFIG.strings.sessionEnding);
                    this.displaySpeech(CLOSING_MESSAGE);
                    break;

                case 'complete':
                    this.updateVoiceStatus(CONFIG.strings.complete);
                    this.stopTimer();
                    this.showSessionComplete();
                    break;

                case 'error':
                    this.updateVoiceStatus(CONFIG.strings.error);
                    break;
            }
        }

        // --------------------------------------------------------------------------
        // Timer
        // --------------------------------------------------------------------------

        startTimer() {
            this.timeRemaining = CONFIG.timerDuration;
            this.updateTimerDisplay();

            this.timerInterval = setInterval(() => {
                this.timeRemaining--;
                this.updateTimerDisplay();

                if (this.timeRemaining === CONFIG.timerWarningThreshold) {
                    this.onTimerWarning();
                } else if (this.timeRemaining === CONFIG.timerCriticalThreshold) {
                    this.onTimerCritical();
                } else if (this.timeRemaining <= 0) {
                    this.onTimerEnd();
                }
            }, 1000);
        }

        stopTimer() {
            if (this.timerInterval) {
                clearInterval(this.timerInterval);
                this.timerInterval = null;
            }
        }

        updateTimerDisplay() {
            const minutes = Math.floor(this.timeRemaining / 60);
            const seconds = this.timeRemaining % 60;
            const formatted = String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');

            if (this.elements.timerValue) {
                this.elements.timerValue.textContent = formatted;
            }

            // Timer badge states
            if (this.elements.timerBadge) {
                this.elements.timerBadge.classList.toggle('is-warning',
                    this.timeRemaining <= CONFIG.timerWarningThreshold && this.timeRemaining > CONFIG.timerCriticalThreshold);
                this.elements.timerBadge.classList.toggle('is-critical',
                    this.timeRemaining <= CONFIG.timerCriticalThreshold);
            }
        }

        onTimerWarning() {
            // Disable follow-ups
            if (this.elements.followupTimeWarning) {
                this.elements.followupTimeWarning.hidden = false;
            }
        }

        onTimerCritical() {
            // Show session ending overlay briefly
            if (this.elements.sessionEnding) {
                this.elements.sessionEnding.hidden = false;
                setTimeout(() => {
                    this.elements.sessionEnding.hidden = true;
                }, 3000);
            }

            // Disable all inputs
            this.elements.micBtn.dataset.micState = 'disabled';
            this.elements.textInput && (this.elements.textInput.disabled = true);
            this.elements.textSend && (this.elements.textSend.disabled = true);
            this.elements.panelTextInput && (this.elements.panelTextInput.disabled = true);
            this.elements.panelSendBtn && (this.elements.panelSendBtn.disabled = true);
        }

        onTimerEnd() {
            this.stopTimer();
            if (this.state !== 'speaking' && this.state !== 'closing' && this.state !== 'complete') {
                this.transitionTo('closing');
            }
        }

        // --------------------------------------------------------------------------
        // Interview Flow
        // --------------------------------------------------------------------------

        canSelectQuestion() {
            return ['idle', 'ready'].includes(this.state);
        }

        selectQuestion(id, text) {
            // Deselect all
            this.elements.questionCards.forEach(card => {
                card.setAttribute('aria-checked', 'false');
            });

            // Select this one
            const card = this.container.querySelector(`[data-question-id="${id}"]`);
            if (card) {
                card.setAttribute('aria-checked', 'true');
            }

            this.selectedQuestion = { id, text };
        }

        startInterview() {
            // Set session state to active
            this.container.dataset.sessionState = 'active';

            // Hide the Begin Interview button
            if (this.elements.startArea) {
                this.elements.startArea.hidden = true;
            }

            // Show persistent end session button
            if (this.elements.persistentEnd) {
                this.elements.persistentEnd.hidden = false;
            }

            // Show inline transcript and resize handle
            if (this.elements.transcriptResizeHandle) {
                this.elements.transcriptResizeHandle.hidden = false;
            }
            if (this.elements.inlineTranscript) {
                this.elements.inlineTranscript.hidden = false;
            }

            this.transitionTo('connecting');
        }

        mockConnection() {
            if (this.elements.avatarPlaceholder) {
                this.elements.avatarPlaceholder.classList.add('is-connecting');
            }

            setTimeout(() => {
                if (this.elements.avatarPlaceholder) {
                    this.elements.avatarPlaceholder.classList.remove('is-connecting');
                    this.elements.avatarPlaceholder.classList.add('is-connected');
                }

                // Speak introduction first, then transition to ready
                this.speakIntroduction();
            }, MOCK_DELAYS.connect);
        }

        speakIntroduction() {
            // Start timer when introduction begins
            if (!this.timerStarted) {
                this.startTimer();
                this.timerStarted = true;
            }

            // Transition to speaking state
            this.transitionTo('speaking');

            // Add introduction to transcript
            this.addTranscriptEntry('assistant', INTRODUCTION_MESSAGE);

            // Show caption
            if (this.elements.captionText) {
                this.elements.captionText.textContent = INTRODUCTION_MESSAGE;
            }
            if (this.elements.captionOverlay) {
                this.elements.captionOverlay.hidden = false;
            }

            // Calculate speaking duration based on message length
            const speakDuration = INTRODUCTION_MESSAGE.length * MOCK_DELAYS.speakPerChar;

            // After introduction, transition to ready
            setTimeout(() => {
                // Hide caption
                if (this.elements.captionOverlay) {
                    this.elements.captionOverlay.hidden = true;
                }

                // Transition to ready (will speak selected question if any)
                this.transitionTo('ready', { speakQuestion: true });
            }, speakDuration);
        }

        sendSuggestedQuestion(questionId, questionText) {
            // Don't send if Ray is currently speaking or thinking
            if (this.state === 'speaking' || this.state === 'thinking') {
                return;
            }

            // Use existing speakResponse to handle the question
            this.speakResponse(questionId, questionText);
        }

        speakResponse(questionId, questionText) {
            const response = PLACEHOLDER_RESPONSES[questionId];
            if (!response) return;

            // Add question to transcript
            this.addTranscriptEntry('user', questionText);

            // Update step 2
            if (this.elements.currentQuestionText) {
                this.elements.currentQuestionText.textContent = questionText;
            }

            // Show "Now answering"
            if (this.elements.nowAnsweringText) {
                this.elements.nowAnsweringText.textContent = questionText;
            }
            if (this.elements.nowAnswering) {
                this.elements.nowAnswering.hidden = false;
            }

            // Move to step 2
            this.setStep(2);

            // Transition to speaking
            this.transitionTo('speaking', { response: response.answer });
        }

        // --------------------------------------------------------------------------
        // Voice Interaction
        // --------------------------------------------------------------------------

        toggleMic() {
            const currentState = this.elements.micBtn.dataset.micState;

            if (currentState === 'disabled') return;

            if (currentState === 'listening') {
                // Stop listening
                this.transitionTo('ready');
            } else if (currentState === 'ready' || currentState === 'off') {
                // Start listening
                if (this.state === 'ready' && this.currentStep === 3) {
                    this.transitionTo('listening');
                }
            }
        }

        simulateListening() {
            // Simulate user speaking for a duration, then process
            setTimeout(() => {
                if (this.state === 'listening') {
                    // Simulate captured speech
                    const mockSpeech = "Can you elaborate on that approach?";
                    this.processVoiceInput(mockSpeech);
                }
            }, MOCK_DELAYS.listenDuration);
        }

        processVoiceInput(speech) {
            // Add to transcript
            this.addTranscriptEntry('user', speech);

            // Mark follow-up as used
            this.followupUsed = true;

            // Process as follow-up
            this.transitionTo('thinking', { followup: speech });
        }

        showVoiceHint(show) {
            if (this.elements.voiceHint) {
                this.elements.voiceHint.hidden = !show;
            }
        }

        // --------------------------------------------------------------------------
        // Keyboard Mode
        // --------------------------------------------------------------------------

        toggleKeyboardMode() {
            const isKeyboard = this.inputMode === 'keyboard';

            if (isKeyboard) {
                // Switch to voice
                this.inputMode = 'voice';
                this.container.dataset.inputMode = 'voice';
                this.elements.keyboardBtn.setAttribute('aria-pressed', 'false');
                this.elements.keyboardTray.hidden = true;

                // If was listening via keyboard, stop
                if (this.state === 'listening') {
                    this.transitionTo('ready');
                }
            } else {
                // Switch to keyboard
                this.inputMode = 'keyboard';
                this.container.dataset.inputMode = 'keyboard';
                this.elements.keyboardBtn.setAttribute('aria-pressed', 'true');
                this.elements.keyboardTray.hidden = false;

                // If was listening via mic, stop
                if (this.state === 'listening') {
                    this.transitionTo('ready');
                }

                // Focus the input
                setTimeout(() => this.elements.textInput?.focus(), 100);
            }
        }

        onTextInput() {
            const hasText = this.elements.textInput?.value.trim().length > 0;
            const canSend = this.state === 'ready' && this.currentStep === 3 &&
                           this.timeRemaining > CONFIG.timerCriticalThreshold && !this.followupUsed;

            if (this.elements.textSend) {
                this.elements.textSend.disabled = !hasText || !canSend;
            }
        }

        submitText() {
            const text = this.elements.textInput?.value.trim();
            if (!text) return;

            if (this.state !== 'ready' || this.currentStep !== 3) return;
            if (this.timeRemaining <= CONFIG.timerCriticalThreshold) return;
            if (this.followupUsed) return;

            // Clear input
            this.elements.textInput.value = '';
            this.elements.textSend.disabled = true;

            // Add to transcript
            this.addTranscriptEntry('user', text);

            // Mark follow-up as used
            this.followupUsed = true;

            // Process
            this.transitionTo('thinking', { followup: text });
        }

        // Panel input (inline in right panel)
        onPanelTextInput() {
            const hasText = this.elements.panelTextInput?.value.trim().length > 0;
            const canSend = this.container.dataset.sessionState === 'active' &&
                           this.state === 'ready';

            if (this.elements.panelSendBtn) {
                this.elements.panelSendBtn.disabled = !hasText || !canSend;
            }
        }

        submitPanelText() {
            const text = this.elements.panelTextInput?.value.trim();
            if (!text) return;
            if (this.state !== 'ready') return;

            // Clear input
            this.elements.panelTextInput.value = '';
            this.elements.panelSendBtn.disabled = true;

            // Send the custom question
            this.sendCustomQuestion(text);
        }

        sendCustomQuestion(text) {
            // Add user question to transcript
            this.addTranscriptEntry('user', text);

            // Transition to thinking
            this.transitionTo('thinking');

            // After thinking delay, speak a response
            setTimeout(() => {
                const response = "That's a great question. While I don't have a specific prepared answer for that, I'd love to discuss it further. Feel free to reach out through the contact page for a more in-depth conversation.";
                this.displaySpeech(response, true);
                this.transitionTo('speaking');

                // Calculate speaking duration
                const speakDuration = response.length * MOCK_DELAYS.speakPerChar;

                // After speaking, return to ready
                setTimeout(() => {
                    this.transitionTo('ready');
                }, speakDuration);
            }, MOCK_DELAYS.think);
        }

        // --------------------------------------------------------------------------
        // Speech Display
        // --------------------------------------------------------------------------

        displaySpeech(text, isFollowup = false) {
            this.lastResponse = text;

            // Enable replay
            if (this.elements.replayBtn && this.timeRemaining > CONFIG.replayDisableThreshold) {
                this.elements.replayBtn.disabled = false;
            }

            // Add to transcript
            this.addTranscriptEntry('ray', text);

            // Calculate duration
            const duration = text.length * MOCK_DELAYS.speakPerChar + Math.random() * MOCK_DELAYS.speakVariance * 10;

            // Start captions
            if (this.captionsEnabled) {
                this.startCaptions(text);
            }

            // Animate avatar
            if (this.elements.avatarPlaceholder) {
                this.elements.avatarPlaceholder.classList.add('is-speaking');
            }

            setTimeout(() => {
                this.stopCaptions();

                if (this.elements.avatarPlaceholder) {
                    this.elements.avatarPlaceholder.classList.remove('is-speaking');
                }

                // Hide "Now answering"
                if (this.elements.nowAnswering) {
                    this.elements.nowAnswering.hidden = true;
                }

                if (this.state === 'closing') {
                    this.transitionTo('complete');
                } else if (this.timeRemaining <= 0) {
                    this.transitionTo('closing');
                } else {
                    // Move to step 3 (follow-up)
                    if (!this.followupUsed && this.timeRemaining > CONFIG.timerWarningThreshold) {
                        this.setStep(3);
                    }
                    this.transitionTo('ready');
                }
            }, duration);
        }

        startCaptions(text) {
            this.currentCaptionChunks = this.splitIntoChunks(text);
            this.captionIndex = 0;

            if (this.elements.captionOverlay) {
                this.elements.captionOverlay.hidden = false;
            }

            this.showNextCaptionChunk();
        }

        splitIntoChunks(text) {
            const sentences = text.match(/[^.!?]+[.!?]+/g) || [text];
            const chunks = [];
            const maxLength = 80;

            sentences.forEach(sentence => {
                sentence = sentence.trim();
                if (sentence.length <= maxLength) {
                    chunks.push(sentence);
                } else {
                    const parts = sentence.split(/,\s+/);
                    parts.forEach(part => {
                        if (part.length <= maxLength) {
                            chunks.push(part.trim());
                        } else {
                            const mid = Math.floor(part.length / 2);
                            const spaceIndex = part.indexOf(' ', mid);
                            if (spaceIndex !== -1) {
                                chunks.push(part.substring(0, spaceIndex).trim());
                                chunks.push(part.substring(spaceIndex + 1).trim());
                            } else {
                                chunks.push(part.trim());
                            }
                        }
                    });
                }
            });

            return chunks;
        }

        showNextCaptionChunk() {
            if (this.captionIndex >= this.currentCaptionChunks.length) return;

            const chunk = this.currentCaptionChunks[this.captionIndex];
            if (this.elements.captionText) {
                this.elements.captionText.textContent = chunk;
            }

            this.captionIndex++;
            const delay = Math.max(MOCK_DELAYS.chunkDelay * chunk.length / 2, 1500);

            this.captionTimeout = setTimeout(() => this.showNextCaptionChunk(), delay);
        }

        stopCaptions() {
            if (this.captionTimeout) {
                clearTimeout(this.captionTimeout);
                this.captionTimeout = null;
            }

            if (this.elements.captionOverlay) {
                this.elements.captionOverlay.hidden = true;
            }

            if (this.elements.captionText) {
                this.elements.captionText.textContent = '';
            }

            this.currentCaptionChunks = [];
            this.captionIndex = 0;
        }

        generateFollowupResponse(followup) {
            const responses = [
                "That's a great follow-up. Based on my experience, it really depends on the specific context. Every situation is unique, but there are common patterns I've observed.",
                "I appreciate you diving deeper into this. The most successful approaches combine technical excellence with genuine empathy for the end user.",
                "Good question. In practice, this often comes down to having the right conversations early and being willing to iterate based on feedback."
            ];
            return responses[Math.floor(Math.random() * responses.length)];
        }

        replayLastResponse() {
            if (this.lastResponse && this.state === 'ready' && this.timeRemaining > CONFIG.replayDisableThreshold) {
                this.transitionTo('speaking', { response: this.lastResponse });
            }
        }

        // --------------------------------------------------------------------------
        // UI Updates
        // --------------------------------------------------------------------------

        updateUI() {
            this.updateMicState();
        }

        updateVoiceStatus(text) {
            if (this.elements.voiceStatusText) {
                this.elements.voiceStatusText.textContent = text;
            }
        }

        updateMicState() {
            const canUseMic = ['ready'].includes(this.state) && this.currentStep === 3 &&
                             this.timeRemaining > CONFIG.timerCriticalThreshold && !this.followupUsed;

            if (this.elements.micBtn) {
                if (this.state === 'speaking' || this.state === 'thinking') {
                    this.elements.micBtn.dataset.micState = 'disabled';
                } else if (canUseMic && this.state === 'ready') {
                    this.elements.micBtn.dataset.micState = 'ready';
                } else if (this.state === 'listening') {
                    this.elements.micBtn.dataset.micState = 'listening';
                } else {
                    this.elements.micBtn.dataset.micState = 'off';
                }
            }
        }

        setStep(stepNumber) {
            this.currentStep = stepNumber;

            this.elements.steps.forEach(step => {
                const num = parseInt(step.dataset.step);
                if (num < stepNumber) {
                    step.dataset.stepState = 'completed';
                    step.hidden = true;
                } else if (num === stepNumber) {
                    step.dataset.stepState = 'active';
                    step.hidden = false;
                } else {
                    step.dataset.stepState = 'pending';
                    step.hidden = true;
                }
            });

            // Update answer status text based on state
            if (stepNumber === 2 && this.elements.answerStatusText) {
                this.elements.answerStatusText.textContent =
                    this.state === 'thinking' ? 'Thinking...' : 'Speaking...';
            }
        }

        toggleMute() {
            this.isMuted = !this.isMuted;

            if (this.elements.muteBtn) {
                this.elements.muteBtn.setAttribute('aria-pressed', String(this.isMuted));
                const iconOn = this.elements.muteBtn.querySelector('.icon-volume-on');
                const iconOff = this.elements.muteBtn.querySelector('.icon-volume-off');
                if (iconOn) iconOn.style.display = this.isMuted ? 'none' : '';
                if (iconOff) iconOff.style.display = this.isMuted ? '' : 'none';
            }
        }

        toggleCaptions() {
            this.captionsEnabled = !this.captionsEnabled;

            if (this.elements.captionsBtn) {
                this.elements.captionsBtn.setAttribute('aria-pressed', String(this.captionsEnabled));
            }

            if (!this.captionsEnabled && this.elements.captionOverlay) {
                this.elements.captionOverlay.hidden = true;
            }
        }

        // --------------------------------------------------------------------------
        // Transcript
        // --------------------------------------------------------------------------

        addTranscriptEntry(role, content) {
            const timestamp = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

            this.transcript.push({ role, content, timestamp });
            this.renderTranscript();

            // Enable inline transcript buttons
            if (this.elements.inlineCopyBtn) this.elements.inlineCopyBtn.disabled = false;
            if (this.elements.inlineDownloadBtn) this.elements.inlineDownloadBtn.disabled = false;
        }

        renderTranscript() {
            if (!this.elements.inlineTranscriptEntries) return;

            if (this.elements.inlineTranscriptEmpty) {
                this.elements.inlineTranscriptEmpty.style.display = 'none';
            }

            let html = '';
            this.transcript.forEach(entry => {
                const speakerClass = entry.role === 'user' ? 'is-user' : 'is-ray';
                const speakerName = entry.role === 'user' ? 'YOU' : 'RAY BOT';

                html += `<div class="interview-transcript-entry">
                    <div class="interview-transcript-meta">
                        <span class="interview-transcript-speaker ${speakerClass}">${speakerName}</span>
                        <span class="interview-transcript-time">${entry.timestamp}</span>
                    </div>
                    <p class="interview-transcript-message">${this.escapeHtml(entry.content)}</p>
                </div>`;
            });

            this.elements.inlineTranscriptEntries.innerHTML = html;
            this.elements.inlineTranscriptEntries.scrollTop = this.elements.inlineTranscriptEntries.scrollHeight;
        }

        // --------------------------------------------------------------------------
        // Transcript Resize
        // --------------------------------------------------------------------------

        startResize(e) {
            e.preventDefault();
            this.isResizing = true;
            this.resizeStartY = e.type.includes('touch') ? e.touches[0].clientY : e.clientY;

            if (this.elements.inlineTranscript) {
                this.resizeStartHeight = this.elements.inlineTranscript.offsetHeight;
            }

            if (this.elements.transcriptResizeHandle) {
                this.elements.transcriptResizeHandle.classList.add('is-dragging');
            }

            document.body.style.cursor = 'ns-resize';
            document.body.style.userSelect = 'none';
        }

        doResize(e) {
            if (!this.isResizing) return;

            e.preventDefault();
            const clientY = e.type.includes('touch') ? e.touches[0].clientY : e.clientY;
            const deltaY = this.resizeStartY - clientY; // Negative = dragging down, Positive = dragging up

            if (this.elements.inlineTranscript) {
                const newHeight = Math.max(100, Math.min(500, this.resizeStartHeight + deltaY));
                this.elements.inlineTranscript.style.maxHeight = `${newHeight}px`;
            }
        }

        stopResize() {
            if (!this.isResizing) return;

            this.isResizing = false;

            if (this.elements.transcriptResizeHandle) {
                this.elements.transcriptResizeHandle.classList.remove('is-dragging');
            }

            document.body.style.cursor = '';
            document.body.style.userSelect = '';
        }

        copyTranscript() {
            const text = this.formatTranscriptAsText();
            navigator.clipboard.writeText(text).then(() => {
                this.elements.copyBtn.classList.add('is-copied');
                setTimeout(() => this.elements.copyBtn.classList.remove('is-copied'), 2000);
            });
        }

        downloadTranscript() {
            const text = this.formatTranscriptAsText();
            const blob = new Blob([text], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);

            const a = document.createElement('a');
            a.href = url;
            a.download = `interview-ray-${new Date().toISOString().slice(0, 10)}.txt`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        }

        formatTranscriptAsText() {
            let text = 'Interview with Ray\n';
            text += `Date: ${new Date().toLocaleDateString()}\n`;
            text += '='.repeat(40) + '\n\n';

            this.transcript.forEach(entry => {
                const name = entry.role === 'user' ? 'You' : 'Ray';
                text += `[${entry.timestamp}] ${name}:\n${entry.content}\n\n`;
            });

            return text;
        }

        // --------------------------------------------------------------------------
        // End Interview
        // --------------------------------------------------------------------------

        endInterview() {
            this.transitionTo('closing');
        }

        showSessionComplete() {
            // Set session state attribute for CSS transitions
            this.container.dataset.sessionState = 'complete';

            // Hide session ending overlay
            if (this.elements.sessionEnding) {
                this.elements.sessionEnding.hidden = true;
            }

            // Hide persistent end session button
            if (this.elements.persistentEnd) {
                this.elements.persistentEnd.hidden = true;
            }

            // Show end state left pane view
            if (this.elements.endState) {
                this.elements.endState.hidden = false;

                // Focus on CTA for accessibility after animation
                setTimeout(() => {
                    if (this.elements.endStateCta) {
                        this.elements.endStateCta.focus();
                    }
                }, 300);
            }

            // Show transcript utility in right panel
            if (this.elements.transcriptUtility) {
                this.elements.transcriptUtility.hidden = false;
                this.renderTranscriptUtility();
            }

            // Hide the old session complete overlay (we're using the left pane view instead)
            // Keep it hidden - the left pane end state is the new complete view
            if (this.elements.sessionComplete) {
                this.elements.sessionComplete.hidden = true;
            }
        }

        renderTranscriptUtility() {
            if (!this.elements.transcriptUtilityContent) return;

            if (this.transcript.length === 0) {
                this.elements.transcriptUtilityContent.innerHTML = `
                    <p class="interview-transcript-empty" style="color: var(--interview-text-muted); font-style: italic; font-size: 13px;">
                        No conversation recorded.
                    </p>
                `;
                return;
            }

            let html = '';
            this.transcript.forEach(entry => {
                const speakerClass = entry.role === 'user' ? 'is-user' : 'is-ray';
                const speakerName = entry.role === 'user' ? 'You' : 'Ray Bot';

                html += `<div class="interview-transcript-entry">
                    <div class="interview-transcript-meta">
                        <span class="interview-transcript-speaker ${speakerClass}">${speakerName}</span>
                        <span class="interview-transcript-time">${entry.timestamp}</span>
                    </div>
                    <p class="interview-transcript-message">${this.escapeHtml(entry.content)}</p>
                </div>`;
            });

            this.elements.transcriptUtilityContent.innerHTML = html;
        }

        // --------------------------------------------------------------------------
        // Modal
        // --------------------------------------------------------------------------

        openAboutModal() {
            if (this.elements.aboutModal) {
                this.elements.aboutModal.setAttribute('aria-hidden', 'false');
                this.elements.aboutModal.classList.add('is-open');
                this.elements.aboutClose?.focus();
            }
        }

        closeAboutModal() {
            if (this.elements.aboutModal) {
                this.elements.aboutModal.setAttribute('aria-hidden', 'true');
                this.elements.aboutModal.classList.remove('is-open');
                this.elements.aboutBtn?.focus();
            }
        }

        // --------------------------------------------------------------------------
        // Keyboard
        // --------------------------------------------------------------------------

        handleKeyboard(e) {
            if (e.key === 'Escape') {
                if (this.elements.aboutModal?.classList.contains('is-open')) {
                    this.closeAboutModal();
                    e.preventDefault();
                }
            }
        }

        // --------------------------------------------------------------------------
        // Utilities
        // --------------------------------------------------------------------------

        escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        destroy() {
            this.stopTimer();
            this.stopCaptions();
            document.removeEventListener('keydown', this.handleKeyboard);
        }
    }

    // ==========================================================================
    // INITIALIZATION
    // ==========================================================================

    function initInterviewRaybot() {
        const container = document.querySelector('.interview-raybot');
        if (!container) return;
        container.interviewRaybot = new InterviewStateMachine(container);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initInterviewRaybot);
    } else {
        initInterviewRaybot();
    }

    window.InterviewRaybot = InterviewStateMachine;
    window.initInterviewRaybot = initInterviewRaybot;

})();
