/**
 * BFLUXCO Chatbot
 * AI-powered chat interface with ChatGPT-style behavior
 */

(function() {
    'use strict';

    // =====================================================
    // CONFIGURATION & STATE
    // =====================================================

    const config = window.bfluxcoChatbot || {
        apiUrl: '/wp-json/bfluxco/v1/chat',
        nonce: '',
        scheduleUrl: '',
        strings: {
            placeholder: 'Ask me anything about BFLUXCO...',
            sending: 'Sending...',
            error: 'Sorry, something went wrong. Please try again.',
            handoffTitle: 'Let me connect you with Ray',
            handoffDesc: 'Leave your email and a brief message, and Ray will get back to you within 24 hours.',
            successTitle: 'Message sent!',
            successDesc: 'Ray will be in touch soon.',
            scheduleBtn: 'Or schedule a call'
        }
    };

    // Storage key for persistence
    const STORAGE_KEY = 'bfluxco_chat_history';

    // Storage mode: 'session' (clears on browser close) or 'local' (persists)
    // Using sessionStorage by default for better privacy - conversations don't persist
    const STORAGE_MODE = config.storageMode || 'session';

    // History expiration in milliseconds (24 hours) - prevents stale data accumulation
    const HISTORY_MAX_AGE_MS = 24 * 60 * 60 * 1000;

    // Maximum messages to store (prevents unbounded storage growth)
    const MAX_HISTORY_MESSAGES = 50;

    // Minimum thinking time (ms) - ensures thinking indicator shows for at least this long
    const MIN_THINK_MS = 400;

    // Generate unique message ID
    let messageIdCounter = 0;
    function generateMessageId() {
        return 'msg_' + Date.now() + '_' + (++messageIdCounter);
    }

    // SVG Icons (reused across components)
    const ICONS = {
        edit: '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>',
        copy: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>',
        regenerate: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 4 23 10 17 10"></polyline><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path></svg>',
        like: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg>',
        dislike: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"></path></svg>',
        chevronDown: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>',
        stop: '<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><rect x="4" y="4" width="16" height="16" rx="2"></rect></svg>'
    };

    // State
    let conversationHistory = [];
    let isStreaming = false;
    let isLoading = false;
    let currentStreamController = null;
    let messageQueue = [];
    let userScrolledUp = false;
    let lastUserMessage = null;
    let currentPlaceholder = null; // Reference to thinking placeholder element
    let thinkingStartTime = null;  // Track when thinking started

    // Voice input state
    let isListening = false;
    let recognition = null;
    let voiceEnabled = true; // TTS enabled by default
    let currentAudio = null;

    // DOM Elements
    let elements = {};

    // =====================================================
    // INITIALIZATION
    // =====================================================

    // Context prompts for different chat modes
    const CONTEXT_PROMPTS = {
        transformation: "I'm interested in learning more about team transformation services. How can you help teams build lasting capabilities and work more effectively?",
        general: null
    };

    /**
     * Initialize the chatbot
     */
    function init() {
        elements = {
            container: document.querySelector('.hero-chat'),
            inputArea: document.querySelector('.chat-input-area'),
            inputWrapper: document.querySelector('.chat-input-wrapper'),
            blurOverlay: document.querySelector('.chat-blur-overlay'),
            messages: document.querySelector('.chat-messages'),
            input: document.querySelector('.chat-input'),
            clearBtn: document.querySelector('.chat-clear-btn'),
            closeBtn: document.querySelector('.chat-close-btn'),
            form: document.querySelector('.chat-form'),
            leadForm: document.querySelector('.chat-lead-form'),
            leadName: document.querySelector('.chat-lead-name'),
            leadEmail: document.querySelector('.chat-lead-email'),
            leadMessage: document.querySelector('.chat-lead-message'),
            leadSubmit: document.querySelector('.chat-lead-submit'),
            leadSchedule: document.querySelector('.chat-lead-schedule'),
            success: document.querySelector('.chat-success'),
            micBtn: document.querySelector('.chat-mic-btn'),
            voiceToggle: document.querySelector('.chat-voice-toggle')
        };

        if (!elements.container) return;

        // Create jump to bottom button
        createJumpToBottomButton();

        // Load persisted history (but don't auto-open chat)
        loadHistory();

        // Bind events
        bindEvents();

        // Check for chat context in URL parameters
        handleChatContext();

        // Bind click events to chat trigger buttons
        bindChatTriggers();
    }

    /**
     * Bind click events to elements with data-chat-context attribute
     */
    function bindChatTriggers() {
        document.querySelectorAll('[data-chat-context]').forEach(function(trigger) {
            trigger.addEventListener('click', function(e) {
                e.preventDefault();
                const context = this.getAttribute('data-chat-context');
                openChatWithContext(context);
            });
        });
    }

    /**
     * Open chat interface with a specific context
     * Can be called directly: window.bfluxcoOpenChat('transformation')
     * @param {string} context - The context key (e.g., 'transformation')
     */
    function openChatWithContext(context) {
        if (!elements.container) return;

        const contextPrompt = CONTEXT_PROMPTS[context];
        if (!contextPrompt) return;

        // Clear any existing history for a fresh conversation
        conversationHistory = [];
        clearHistory();

        // Clear messages display
        if (elements.messages) {
            elements.messages.innerHTML = '';
        }

        // Remove hidden class if present (for non-homepage pages)
        elements.container.classList.remove('is-hidden');

        // Show the chat interface
        showMessages();

        // Scroll chat into view smoothly
        if (elements.container) {
            elements.container.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        // Focus the input after scroll completes
        setTimeout(function() {
            if (elements.input) {
                elements.input.focus({ preventScroll: true });
            }
        }, 300);

        // Send the context-specific prompt automatically
        lastUserMessage = contextPrompt;
        addUserMessage(contextPrompt);
        addThinkingPlaceholder();
        sendMessage(contextPrompt);
    }

    // Expose openChatWithContext globally for external use
    window.bfluxcoOpenChat = openChatWithContext;

    /**
     * Handle chat context from URL parameters
     * Supports ?chat=transformation to auto-open with transformation focus
     */
    function handleChatContext() {
        const urlParams = new URLSearchParams(window.location.search);
        const chatContext = urlParams.get('chat');

        if (chatContext && CONTEXT_PROMPTS[chatContext]) {
            // Clear any existing history for a fresh conversation
            conversationHistory = [];
            clearHistory();

            // Small delay to ensure DOM is ready
            setTimeout(function() {
                // Show the chat interface
                showMessages();

                // Focus the input
                if (elements.input) {
                    elements.input.focus({ preventScroll: true });
                }

                // Send the context-specific prompt automatically
                const contextPrompt = CONTEXT_PROMPTS[chatContext];
                lastUserMessage = contextPrompt;
                addUserMessage(contextPrompt);
                addThinkingPlaceholder();
                sendMessage(contextPrompt);

                // Clean up URL (remove query param without reload)
                const cleanUrl = window.location.pathname;
                window.history.replaceState({}, document.title, cleanUrl);
            }, 300);
        }
    }

    /**
     * Create jump to bottom button
     */
    function createJumpToBottomButton() {
        const btn = document.createElement('button');
        btn.className = 'chat-jump-bottom';
        btn.type = 'button';
        btn.setAttribute('aria-label', 'Jump to latest');
        btn.innerHTML = ICONS.chevronDown;
        btn.addEventListener('click', function() {
            scrollToBottom(true);
            userScrolledUp = false;
            btn.classList.remove('is-visible');
        });

        if (elements.inputArea) {
            elements.inputArea.appendChild(btn);
        }
        elements.jumpBtn = btn;
    }

    // =====================================================
    // EVENT BINDING
    // =====================================================

    /**
     * Bind event listeners
     */
    function bindEvents() {
        if (elements.form) {
            elements.form.addEventListener('submit', handleSubmit);
        }

        if (elements.input) {
            elements.input.addEventListener('keydown', function(e) {
                // Enter handling (submit to chatbot)
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    handleSubmit(e);
                }
            });

            elements.input.addEventListener('input', function() {
                updateButtonStates();
                autoResizeInput();
            });

            elements.input.addEventListener('focus', function(e) {
                if (conversationHistory.length > 0 && elements.messages.children.length === 0) {
                    // Restore previous conversation on first focus
                    restoreMessages();
                }
            });
        }

        if (elements.clearBtn) {
            elements.clearBtn.addEventListener('click', function() {
                elements.input.value = '';
                elements.input.style.height = 'auto';
                elements.input.focus({ preventScroll: true });
                updateButtonStates();
            });
        }

        if (elements.closeBtn) {
            elements.closeBtn.addEventListener('click', resetChat);
        }

        // Click on blur overlay dismisses chat
        if (elements.blurOverlay) {
            elements.blurOverlay.addEventListener('click', resetChat);
        }

        if (elements.micBtn) {
            elements.micBtn.addEventListener('click', toggleVoiceInput);
            initSpeechRecognition();
        }

        if (elements.voiceToggle) {
            elements.voiceToggle.addEventListener('click', toggleVoiceOutput);
            updateVoiceToggleState();
        }

        if (elements.leadSubmit) {
            elements.leadSubmit.addEventListener('click', handleLeadSubmit);
        }

        if (elements.leadForm) {
            elements.leadForm.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && e.target.tagName !== 'TEXTAREA') {
                    e.preventDefault();
                    handleLeadSubmit(e);
                }
            });
        }

        // ESC key to dismiss or stop streaming
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                if (isStreaming) {
                    stopGeneration();
                } else {
                    const hasText = elements.input && elements.input.value.trim().length > 0;
                    const hasMessages = conversationHistory.length > 0;
                    if (hasText || hasMessages) {
                        resetChat();
                    }
                }
            }
        });

        // Scroll detection for smart scrolling and scrollbar visibility
        if (elements.messages) {
            elements.messages.addEventListener('scroll', handleScroll);
            elements.messages.addEventListener('scroll', handleScrollbarVisibility);
            elements.messages.addEventListener('mouseenter', showScrollbar);
            elements.messages.addEventListener('mouseleave', hideScrollbarDelayed);
        }
    }

    // =====================================================
    // SCROLLBAR MANAGEMENT
    // =====================================================

    let scrollbarTimeout = null;

    /**
     * Show scrollbar on scroll activity
     */
    function handleScrollbarVisibility() {
        showScrollbar();
        hideScrollbarDelayed();
    }

    /**
     * Show scrollbar immediately
     */
    function showScrollbar() {
        if (elements.messages) {
            elements.messages.classList.add('is-scrolling');
        }
        if (scrollbarTimeout) {
            clearTimeout(scrollbarTimeout);
            scrollbarTimeout = null;
        }
    }

    /**
     * Hide scrollbar after delay (1000ms)
     */
    function hideScrollbarDelayed() {
        if (scrollbarTimeout) {
            clearTimeout(scrollbarTimeout);
        }
        scrollbarTimeout = setTimeout(function() {
            if (elements.messages) {
                elements.messages.classList.remove('is-scrolling');
            }
        }, 1000);
    }

    /**
     * Handle scroll for smart scrolling behavior
     */
    function handleScroll() {
        if (!elements.messages) return;

        const threshold = 100;
        const isAtBottom = elements.messages.scrollHeight - elements.messages.scrollTop - elements.messages.clientHeight < threshold;

        if (isAtBottom) {
            userScrolledUp = false;
            if (elements.jumpBtn) {
                elements.jumpBtn.classList.remove('is-visible');
            }
        } else {
            userScrolledUp = true;
            if (elements.jumpBtn && conversationHistory.length > 0) {
                elements.jumpBtn.classList.add('is-visible');
            }
        }
    }

    // =====================================================
    // INPUT HANDLING
    // =====================================================

    /**
     * Update button states
     */
    function updateButtonStates() {
        const hasText = elements.input && elements.input.value.trim().length > 0;
        const hasMessages = conversationHistory.length > 0;
        const isExpanded = hasText || hasMessages;

        if (elements.clearBtn) {
            elements.clearBtn.classList.toggle('is-visible', hasText);
        }

        if (elements.closeBtn) {
            elements.closeBtn.classList.toggle('is-visible', isExpanded);
        }

        // Expand width when typing or has messages (stays in hero)
        if (elements.container) {
            elements.container.classList.toggle('is-expanded', isExpanded);
        }
    }

    // Base height for single line input
    const BASE_INPUT_HEIGHT = 24;

    /**
     * Auto-resize textarea (grows upward, bottom anchored)
     * Uses CSS transform + negative margin to keep bottom edge fixed
     */
    function autoResizeInput() {
        if (!elements.input) return;

        // Measure true height needed
        elements.input.style.height = 'auto';
        const newHeight = Math.min(elements.input.scrollHeight, 120); // max-height
        elements.input.style.height = newHeight + 'px';

        // Handle overflow when at max height
        elements.input.style.overflowY = newHeight >= 120 ? 'auto' : 'hidden';

        // Calculate growth from base height
        const growth = newHeight - BASE_INPUT_HEIGHT;

        if (elements.inputWrapper) {
            if (growth > 0) {
                // Shift visually upward
                elements.inputWrapper.style.transform = `translateY(-${growth}px)`;
                // Compensate for height growth so parent doesn't expand
                elements.inputWrapper.style.marginBottom = `-${growth}px`;
            } else {
                elements.inputWrapper.style.transform = '';
                elements.inputWrapper.style.marginBottom = '';
            }
        }
    }

    /**
     * Reset the entire chat and unlock page scroll
     */
    function resetChat() {
        // Stop any active streaming and audio
        stopGeneration();
        stopSpeaking();

        conversationHistory = [];
        messageQueue = [];
        currentPlaceholder = null;
        thinkingStartTime = null;
        clearHistory();

        if (elements.input) {
            elements.input.value = '';
            elements.input.style.height = 'auto';
        }

        // Reset input wrapper transform/margin
        if (elements.inputWrapper) {
            elements.inputWrapper.style.transform = '';
            elements.inputWrapper.style.marginBottom = '';
        }

        if (elements.messages) {
            elements.messages.classList.remove('is-active');
            elements.messages.innerHTML = '';
        }

        if (elements.blurOverlay) {
            elements.blurOverlay.classList.remove('is-active');
        }

        // Re-hide chat on non-homepage pages
        if (elements.container && elements.container.dataset.hideOnClose === 'true') {
            elements.container.classList.add('is-hidden');
        }

        const heroVideo = document.querySelector('.hero-video');
        if (heroVideo) {
            heroVideo.play();
        }

        if (elements.leadForm) {
            elements.leadForm.classList.remove('is-active');
        }

        if (elements.success) {
            elements.success.classList.remove('is-active');
        }

        if (elements.jumpBtn) {
            elements.jumpBtn.classList.remove('is-visible');
        }

        userScrolledUp = false;
        updateButtonStates();

        // Only focus input if chat is still visible (homepage)
        if (elements.input && !elements.container.classList.contains('is-hidden')) {
            elements.input.focus({ preventScroll: true });
        }
    }

    // =====================================================
    // MESSAGE MANAGEMENT
    // =====================================================

    /**
     * Create a user message element with edit button
     * @param {string} text - The message text
     * @param {number} index - The message index in conversation history
     * @returns {HTMLElement} The message element
     */
    function createUserMessageElement(text, index) {
        const messageEl = document.createElement('div');
        messageEl.className = 'chat-message chat-message--user';
        messageEl.dataset.index = index;
        messageEl.innerHTML = `
            <div class="chat-bubble">${escapeHtml(text)}</div>
            <div class="chat-message-actions">
                <button type="button" class="chat-edit-btn" aria-label="Edit message" title="Edit">
                    ${ICONS.edit}
                </button>
            </div>
        `;

        // Edit button handler
        const editBtn = messageEl.querySelector('.chat-edit-btn');
        editBtn.addEventListener('click', function() {
            startEditMessage(messageEl, text, index);
        });

        return messageEl;
    }

    /**
     * Create a bot message element with action buttons (for restored messages)
     * @param {string} text - The message text
     * @param {number} index - The message index in conversation history
     * @returns {HTMLElement} The message element
     */
    function createBotMessageElement(text, index) {
        const messageEl = document.createElement('div');
        messageEl.className = 'chat-message chat-message--bot';
        messageEl.dataset.index = index;
        messageEl.innerHTML = `
            <div class="chat-bubble">${escapeHtml(text)}</div>
            <div class="chat-actions is-visible">
                <button type="button" class="chat-action-btn chat-copy-btn" aria-label="Copy" title="Copy">${ICONS.copy}</button>
                <button type="button" class="chat-action-btn chat-regenerate-btn" aria-label="Regenerate" title="Regenerate">${ICONS.regenerate}</button>
                <button type="button" class="chat-action-btn chat-like-btn" aria-label="Good response" title="Good response">${ICONS.like}</button>
                <button type="button" class="chat-action-btn chat-dislike-btn" aria-label="Bad response" title="Bad response">${ICONS.dislike}</button>
            </div>
        `;

        setupBotMessageActions(messageEl, text);
        return messageEl;
    }

    /**
     * Handle form submission
     */
    function handleSubmit(e) {
        e.preventDefault();

        const message = elements.input.value.trim();
        if (!message) return;

        // If currently streaming, queue the message
        if (isStreaming || isLoading) {
            messageQueue.push(message);
            elements.input.value = '';
            autoResizeInput();
            updateButtonStates();
            return;
        }

        // Clear input immediately
        elements.input.value = '';
        autoResizeInput();

        showMessages();

        // Retain focus after submit
        setTimeout(function() {
            elements.input.focus({ preventScroll: true });
        }, 0);

        lastUserMessage = message;
        addUserMessage(message);

        // Add thinking placeholder immediately
        addThinkingPlaceholder();

        // Start the API request
        sendMessage(message);
    }

    /**
     * Add user message
     */
    function addUserMessage(text, messageIndex) {
        const index = messageIndex !== undefined ? messageIndex : conversationHistory.length;

        conversationHistory.push({
            role: 'user',
            content: text
        });

        const messageEl = createUserMessageElement(text, index);

        if (elements.messages) {
            elements.messages.appendChild(messageEl);
            scrollToBottom(true); // Force scroll for user messages
        }

        saveHistory();
        updateButtonStates();
    }

    /**
     * Add thinking placeholder message
     * Shows immediately after user submits, transitions to typing when response arrives
     */
    function addThinkingPlaceholder() {
        const messageId = generateMessageId();
        thinkingStartTime = Date.now();

        const messageEl = document.createElement('div');
        messageEl.className = 'chat-message chat-message--bot chat-message--thinking';
        messageEl.dataset.messageId = messageId;
        messageEl.dataset.status = 'thinking';
        messageEl.innerHTML = `
            <div class="chat-bubble">
                <span class="chat-thinking-dots">
                    <span class="chat-thinking-dot"></span>
                    <span class="chat-thinking-dot"></span>
                    <span class="chat-thinking-dot"></span>
                </span>
            </div>
            <div class="chat-actions">
                <button type="button" class="chat-action-btn chat-stop-btn-inline" aria-label="Stop" title="Stop">${ICONS.stop}</button>
            </div>
        `;

        // Stop button handler
        const stopBtn = messageEl.querySelector('.chat-stop-btn-inline');
        if (stopBtn) {
            stopBtn.addEventListener('click', function() {
                stopGeneration();
                // Convert to error message
                transitionPlaceholderToError(messageEl, 'Response cancelled.');
            });
        }

        if (elements.messages) {
            elements.messages.appendChild(messageEl);
            scrollToBottom(true);
        }

        currentPlaceholder = messageEl;
        return messageEl;
    }

    /**
     * Transition placeholder from thinking to typing with content
     * @param {HTMLElement} placeholderEl - The placeholder element
     * @param {string} content - The response content to type
     * @param {Function} onComplete - Callback when typing is done
     */
    function transitionPlaceholderToTyping(placeholderEl, content, onComplete) {
        if (!placeholderEl) return;

        // Update status
        placeholderEl.classList.remove('chat-message--thinking');
        placeholderEl.classList.add('chat-message--typing');
        placeholderEl.dataset.status = 'typing';

        const bubble = placeholderEl.querySelector('.chat-bubble');
        const actions = placeholderEl.querySelector('.chat-actions');

        // Clear thinking dots
        bubble.innerHTML = '';

        // Add cursor immediately
        const cursor = document.createElement('span');
        cursor.className = 'chat-cursor';
        bubble.appendChild(cursor);

        // Hide stop button, prepare action buttons
        if (actions) {
            actions.innerHTML = `
                <button type="button" class="chat-action-btn chat-copy-btn" aria-label="Copy" title="Copy">${ICONS.copy}</button>
                <button type="button" class="chat-action-btn chat-regenerate-btn" aria-label="Regenerate" title="Regenerate">${ICONS.regenerate}</button>
                <button type="button" class="chat-action-btn chat-like-btn" aria-label="Good response" title="Good response">${ICONS.like}</button>
                <button type="button" class="chat-action-btn chat-dislike-btn" aria-label="Bad response" title="Bad response">${ICONS.dislike}</button>
            `;
        }

        // Start typing animation
        isStreaming = true;
        typeTextInElement(bubble, cursor, escapeHtml(content), function() {
            // Typing complete
            placeholderEl.classList.remove('chat-message--typing');
            placeholderEl.dataset.status = 'final';

            // Show action buttons
            if (actions) {
                actions.classList.add('is-visible');
                setupBotMessageActions(placeholderEl, content);
            }

            // Add to conversation history
            conversationHistory.push({
                role: 'assistant',
                content: content
            });
            saveHistory();

            isStreaming = false;
            currentPlaceholder = null;

            if (onComplete) onComplete();
        });

        // Speak the response if voice is enabled
        speakText(content);
    }

    /**
     * Transition placeholder to error state
     */
    function transitionPlaceholderToError(placeholderEl, errorMessage) {
        if (!placeholderEl) return;

        placeholderEl.classList.remove('chat-message--thinking', 'chat-message--typing');
        placeholderEl.classList.add('chat-message--error');
        placeholderEl.dataset.status = 'final';

        const bubble = placeholderEl.querySelector('.chat-bubble');
        const actions = placeholderEl.querySelector('.chat-actions');

        bubble.className = 'chat-bubble chat-bubble--error';
        bubble.textContent = errorMessage;

        if (actions) {
            actions.innerHTML = `
                <button type="button" class="chat-action-btn chat-retry-btn" aria-label="Retry" title="Retry">${ICONS.regenerate}</button>
            `;
            actions.classList.add('is-visible');

            const retryBtn = actions.querySelector('.chat-retry-btn');
            if (retryBtn) {
                retryBtn.addEventListener('click', function() {
                    retryFromPlaceholder(placeholderEl);
                });
            }
        }

        currentPlaceholder = null;
        isLoading = false;
        isStreaming = false;
    }

    /**
     * Retry from error placeholder
     */
    function retryFromPlaceholder(errorEl) {
        if (isStreaming || isLoading || !lastUserMessage) return;

        // Remove error message
        errorEl.remove();

        // Add new thinking placeholder and resend
        addThinkingPlaceholder();
        sendMessage(lastUserMessage);
    }

    /**
     * Type text into an element with cursor
     * @param {HTMLElement} element - Container element
     * @param {HTMLElement} cursor - Cursor element
     * @param {string} text - Text to type
     * @param {Function} onComplete - Callback when done
     */
    function typeTextInElement(element, cursor, text, onComplete) {
        const chunks = parseSemanticChunks(text);
        let currentIndex = 0;

        function addNextChunk() {
            if (!isStreaming) {
                // Stopped - show remaining text immediately
                cursor.remove();
                element.textContent = text;
                if (onComplete) onComplete();
                return;
            }

            if (currentIndex < chunks.length) {
                const chunk = chunks[currentIndex];
                currentIndex++;

                const span = document.createElement('span');
                span.className = 'chat-word-group';
                span.textContent = chunk.text;
                element.insertBefore(span, cursor);

                if (!userScrolledUp) {
                    scrollToBottom();
                }

                const delay = calculateChunkDelay(chunk);
                setTimeout(addNextChunk, delay);
            } else {
                // Completion: fade cursor
                setTimeout(function() {
                    cursor.classList.add('is-fading');
                    setTimeout(function() {
                        cursor.remove();
                        if (onComplete) onComplete();
                    }, 100);
                }, 120);
            }
        }

        addNextChunk();
    }

    /**
     * Start editing a user message
     */
    function startEditMessage(messageEl, originalText, index) {
        if (isStreaming || isLoading) return;

        const bubble = messageEl.querySelector('.chat-bubble');
        const actions = messageEl.querySelector('.chat-message-actions');

        // Replace bubble with textarea
        const textarea = document.createElement('textarea');
        textarea.className = 'chat-edit-input';
        textarea.value = originalText;
        bubble.replaceWith(textarea);
        actions.style.display = 'none';

        // Create edit controls
        const controls = document.createElement('div');
        controls.className = 'chat-edit-controls';
        controls.innerHTML = `
            <button type="button" class="chat-edit-save btn btn-primary btn-sm">Save & Submit</button>
            <button type="button" class="chat-edit-cancel btn btn-outline btn-sm">Cancel</button>
        `;
        messageEl.appendChild(controls);

        textarea.focus({ preventScroll: true });
        textarea.setSelectionRange(textarea.value.length, textarea.value.length);

        // Save handler
        controls.querySelector('.chat-edit-save').addEventListener('click', function() {
            const newText = textarea.value.trim();
            if (newText) {
                finishEditMessage(messageEl, newText, index);
            }
        });

        // Cancel handler
        controls.querySelector('.chat-edit-cancel').addEventListener('click', function() {
            cancelEditMessage(messageEl, originalText);
            actions.style.display = '';
        });

        // Enter to save, Escape to cancel
        textarea.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                const newText = textarea.value.trim();
                if (newText) {
                    finishEditMessage(messageEl, newText, index);
                }
            } else if (e.key === 'Escape') {
                cancelEditMessage(messageEl, originalText);
                actions.style.display = '';
            }
        });
    }

    /**
     * Cancel editing a message
     */
    function cancelEditMessage(messageEl, originalText) {
        const textarea = messageEl.querySelector('.chat-edit-input');
        const controls = messageEl.querySelector('.chat-edit-controls');

        const bubble = document.createElement('div');
        bubble.className = 'chat-bubble';
        bubble.textContent = originalText;
        textarea.replaceWith(bubble);

        if (controls) controls.remove();
    }

    /**
     * Finish editing and regenerate from that point
     */
    function finishEditMessage(messageEl, newText, index) {
        // Remove all messages after this one
        const allMessages = elements.messages.querySelectorAll('.chat-message');
        let foundIndex = false;
        allMessages.forEach(function(msg) {
            if (foundIndex) {
                msg.remove();
            }
            if (msg === messageEl) {
                foundIndex = true;
            }
        });

        // Truncate conversation history
        conversationHistory = conversationHistory.slice(0, index);

        // Update the message
        const textarea = messageEl.querySelector('.chat-edit-input');
        const controls = messageEl.querySelector('.chat-edit-controls');
        const actions = messageEl.querySelector('.chat-message-actions');

        const bubble = document.createElement('div');
        bubble.className = 'chat-bubble';
        bubble.textContent = newText;
        textarea.replaceWith(bubble);

        if (controls) controls.remove();
        if (actions) actions.style.display = '';

        // Update history with new text
        conversationHistory.push({
            role: 'user',
            content: newText
        });

        saveHistory();

        // Send the edited message with thinking placeholder
        lastUserMessage = newText;
        addThinkingPlaceholder();
        sendMessage(newText);
    }

    /**
     * Add bot message with streaming
     * @param {string} text - The message text
     * @param {boolean} isError - Whether this is an error message
     * @param {boolean} typingWasShown - Whether typing indicator was shown (for seamless transition)
     */
    function addBotMessage(text, isError, typingWasShown) {
        conversationHistory.push({
            role: 'assistant',
            content: text
        });

        const messageEl = document.createElement('div');
        messageEl.className = 'chat-message chat-message--bot' + (isError ? ' chat-message--error' : '');
        messageEl.dataset.index = conversationHistory.length - 1;

        if (isError) {
            messageEl.innerHTML = `
                <div class="chat-bubble chat-bubble--error">${escapeHtml(text)}</div>
                <div class="chat-actions">
                    <button type="button" class="chat-action-btn chat-retry-btn" aria-label="Retry" title="Retry">${ICONS.regenerate}</button>
                </div>
            `;

            const retryBtn = messageEl.querySelector('.chat-retry-btn');
            retryBtn.addEventListener('click', function() {
                retryLastMessage(messageEl);
            });

            const actions = messageEl.querySelector('.chat-actions');
            actions.classList.add('is-visible');
        } else {
            messageEl.innerHTML = `
                <div class="chat-bubble"></div>
                <div class="chat-actions">
                    <button type="button" class="chat-action-btn chat-copy-btn" aria-label="Copy" title="Copy">${ICONS.copy}</button>
                    <button type="button" class="chat-action-btn chat-regenerate-btn" aria-label="Regenerate" title="Regenerate">${ICONS.regenerate}</button>
                    <button type="button" class="chat-action-btn chat-like-btn" aria-label="Good response" title="Good response">${ICONS.like}</button>
                    <button type="button" class="chat-action-btn chat-dislike-btn" aria-label="Bad response" title="Bad response">${ICONS.dislike}</button>
                </div>
            `;

            const bubble = messageEl.querySelector('.chat-bubble');
            const actions = messageEl.querySelector('.chat-actions');

            // Seamless transition: hide typing indicator, then stream with cursor already present
            if (typingWasShown) {
                hideTyping();
            }

            // Stream text with semantic chunking
            typeText(bubble, escapeHtml(text), function() {
                // Settle delay before showing actions (120-200ms per spec)
                setTimeout(function() {
                    actions.classList.add('is-visible');
                    saveHistory();
                }, 150);
            });

            // Speak the response if voice is enabled
            speakText(text);

            // Action button handlers
            setupBotMessageActions(messageEl, text);
        }

        if (elements.messages) {
            elements.messages.appendChild(messageEl);
            scrollToBottom(true); // Force scroll when bot message appears
        }

        updateButtonStates();
        return messageEl;
    }

    /**
     * Setup bot message action buttons
     */
    function setupBotMessageActions(messageEl, text) {
        const copyBtn = messageEl.querySelector('.chat-copy-btn');
        const regenerateBtn = messageEl.querySelector('.chat-regenerate-btn');
        const likeBtn = messageEl.querySelector('.chat-like-btn');
        const dislikeBtn = messageEl.querySelector('.chat-dislike-btn');

        if (copyBtn) {
            copyBtn.addEventListener('click', function() {
                navigator.clipboard.writeText(text).then(function() {
                    copyBtn.classList.add('is-copied');
                    setTimeout(function() {
                        copyBtn.classList.remove('is-copied');
                    }, 2000);
                });
            });
        }

        if (regenerateBtn) {
            regenerateBtn.addEventListener('click', function() {
                regenerateResponse(messageEl);
            });
        }

        if (likeBtn) {
            likeBtn.addEventListener('click', function() {
                likeBtn.classList.toggle('is-active');
                if (dislikeBtn) dislikeBtn.classList.remove('is-active');
            });
        }

        if (dislikeBtn) {
            dislikeBtn.addEventListener('click', function() {
                dislikeBtn.classList.toggle('is-active');
                if (likeBtn) likeBtn.classList.remove('is-active');
            });
        }
    }

    /**
     * Regenerate a response with fade out
     */
    function regenerateResponse(messageEl) {
        if (isStreaming || isLoading) return;

        const index = parseInt(messageEl.dataset.index);

        // Find the user message before this bot message
        let userMessage = null;
        for (let i = index - 1; i >= 0; i--) {
            if (conversationHistory[i] && conversationHistory[i].role === 'user') {
                userMessage = conversationHistory[i].content;
                break;
            }
        }

        if (!userMessage) return;

        // Fade out then remove
        messageEl.classList.add('is-fading');

        setTimeout(function() {
            // Remove this bot message from DOM and history
            messageEl.remove();
            conversationHistory = conversationHistory.slice(0, index);
            saveHistory();

            // Resend with new thinking placeholder
            lastUserMessage = userMessage;
            addThinkingPlaceholder();
            sendMessage(userMessage);
        }, 100);
    }

    /**
     * Retry after error
     */
    function retryLastMessage(errorMessageEl) {
        if (isStreaming || isLoading || !lastUserMessage) return;

        // Remove error message
        errorMessageEl.remove();
        conversationHistory.pop();
        saveHistory();

        sendMessage(lastUserMessage);
    }

    /**
     * Show typing indicator with cursor and stop button
     */
    function showTyping() {
        const typingEl = document.createElement('div');
        typingEl.className = 'chat-typing-container';
        typingEl.id = 'chat-typing';
        typingEl.innerHTML = `
            <span class="chat-cursor"></span>
            <button type="button" class="chat-stop-btn" aria-label="Stop generating">
                ${ICONS.stop}
                <span>Stop</span>
            </button>
        `;

        const stopBtn = typingEl.querySelector('.chat-stop-btn');
        stopBtn.addEventListener('click', stopGeneration);

        if (elements.messages) {
            elements.messages.appendChild(typingEl);
            scrollToBottom();
        }
    }

    /**
     * Hide typing indicator
     */
    function hideTyping() {
        const typingEl = document.getElementById('chat-typing');
        if (typingEl) {
            typingEl.remove();
        }
    }

    /**
     * Stop generation
     */
    function stopGeneration() {
        if (currentStreamController) {
            currentStreamController.abort();
            currentStreamController = null;
        }
        isStreaming = false;
        isLoading = false;
        hideTyping();
        setInputState(true);
    }

    /**
     * Scroll to bottom smoothly
     */
    function scrollToBottom(force) {
        if (!elements.messages) return;

        if (force || !userScrolledUp) {
            requestAnimationFrame(function() {
                elements.messages.scrollTop = elements.messages.scrollHeight;
            });
        }
    }

    // =====================================================
    // UI STATE
    // =====================================================

    /**
     * Show messages container
     */
    function showMessages() {
        if (elements.messages) {
            elements.messages.classList.add('is-active');
        }
        if (elements.blurOverlay) {
            elements.blurOverlay.classList.add('is-active');
        }
        if (elements.container) {
            elements.container.classList.add('is-expanded');
        }

        const heroVideo = document.querySelector('.hero-video');
        if (heroVideo) {
            heroVideo.pause();
        }
    }

    // =====================================================
    // API COMMUNICATION
    // =====================================================

    /**
     * Send message to API
     * Uses placeholder-based flow with minimum thinking time
     */
    async function sendMessage(message) {
        isLoading = true;
        setInputState(true);

        // Reset scroll state for new message
        userScrolledUp = false;

        currentStreamController = new AbortController();

        // Capture the placeholder that was created before calling this function
        const placeholder = currentPlaceholder;

        try {
            const response = await fetch(config.apiUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-WP-Nonce': config.nonce
                },
                body: JSON.stringify({
                    message: message,
                    history: conversationHistory.filter(m => m.role !== 'assistant' || conversationHistory.indexOf(m) < conversationHistory.length - 1)
                }),
                signal: currentStreamController.signal
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const data = await response.json();

            if (data.success && data.response) {
                // Ensure minimum thinking time has elapsed
                const elapsed = Date.now() - thinkingStartTime;
                const remainingDelay = Math.max(0, MIN_THINK_MS - elapsed);

                setTimeout(function() {
                    if (placeholder && placeholder.parentNode) {
                        transitionPlaceholderToTyping(placeholder, data.response, function() {
                            if (data.handoff) {
                                showLeadForm();
                            }
                            processMessageQueue();
                        });
                    }
                }, remainingDelay);
            } else {
                // Error response from API
                if (placeholder && placeholder.parentNode) {
                    transitionPlaceholderToError(placeholder, config.strings.error);
                }
                processMessageQueue();
            }

        } catch (error) {
            if (error.name === 'AbortError') {
                // User stopped generation - placeholder already handled by stop button
            } else {
                console.error('Chat error:', error);
                if (placeholder && placeholder.parentNode) {
                    transitionPlaceholderToError(placeholder, config.strings.error);
                }
            }
            processMessageQueue();
        } finally {
            isLoading = false;
            currentStreamController = null;
            setInputState(true);
        }
    }

    /**
     * Process queued messages
     */
    function processMessageQueue() {
        if (messageQueue.length > 0 && !isLoading && !isStreaming) {
            const nextMessage = messageQueue.shift();
            lastUserMessage = nextMessage;
            addUserMessage(nextMessage);
            addThinkingPlaceholder();
            sendMessage(nextMessage);
        }
    }

    /**
     * Set input state
     */
    function setInputState(enabled) {
        if (elements.input) {
            elements.input.disabled = !enabled;
        }
    }

    // =====================================================
    // HISTORY MANAGEMENT
    // =====================================================

    /**
     * Get the appropriate storage object based on config
     * @returns {Storage} sessionStorage or localStorage
     */
    function getStorage() {
        return STORAGE_MODE === 'local' ? localStorage : sessionStorage;
    }

    /**
     * Sanitize message content before storage (strip potential XSS)
     * @param {string} content - Message content
     * @returns {string} Sanitized content
     */
    function sanitizeForStorage(content) {
        if (typeof content !== 'string') return '';
        // Create a text node to safely encode HTML entities
        const div = document.createElement('div');
        div.textContent = content;
        return div.textContent;
    }

    /**
     * Save history to storage with expiration and size limits
     * SECURITY: Uses sessionStorage by default (clears on browser close)
     */
    function saveHistory() {
        try {
            const storage = getStorage();

            // Limit history size to prevent storage abuse
            const limitedHistory = conversationHistory.slice(-MAX_HISTORY_MESSAGES);

            // Sanitize all messages before storage
            const sanitizedHistory = limitedHistory.map(function(msg) {
                return {
                    role: msg.role,
                    content: sanitizeForStorage(msg.content)
                };
            });

            const storageData = {
                timestamp: Date.now(),
                history: sanitizedHistory
            };

            storage.setItem(STORAGE_KEY, JSON.stringify(storageData));
        } catch (e) {
            console.warn('Could not save chat history:', e);
        }
    }

    /**
     * Load history from storage with expiration check
     */
    function loadHistory() {
        try {
            const storage = getStorage();
            const saved = storage.getItem(STORAGE_KEY);

            if (saved) {
                const data = JSON.parse(saved);

                // Check if data has expired
                if (data.timestamp && (Date.now() - data.timestamp) > HISTORY_MAX_AGE_MS) {
                    // History expired, clear it
                    clearHistory();
                    conversationHistory = [];
                    return;
                }

                // Load history (handle both old format and new format)
                if (Array.isArray(data.history)) {
                    conversationHistory = data.history;
                } else if (Array.isArray(data)) {
                    // Legacy format: migrate to new format
                    conversationHistory = data;
                    saveHistory(); // Re-save in new format
                }
            }
        } catch (e) {
            console.warn('Could not load chat history:', e);
            conversationHistory = [];
        }
    }

    /**
     * Clear history from storage
     */
    function clearHistory() {
        try {
            const storage = getStorage();
            storage.removeItem(STORAGE_KEY);
        } catch (e) {
            console.warn('Could not clear chat history:', e);
        }
    }

    /**
     * Restore messages from history
     */
    function restoreMessages() {
        if (!elements.messages || conversationHistory.length === 0) return;

        showMessages();

        conversationHistory.forEach(function(msg, index) {
            const messageEl = msg.role === 'user'
                ? createUserMessageElement(msg.content, index)
                : createBotMessageElement(msg.content, index);

            elements.messages.appendChild(messageEl);
        });

        // Find last user message for potential retry
        for (let i = conversationHistory.length - 1; i >= 0; i--) {
            if (conversationHistory[i].role === 'user') {
                lastUserMessage = conversationHistory[i].content;
                break;
            }
        }

        scrollToBottom(true);
        updateButtonStates();
    }

    // =====================================================
    // CTA FORM CARD - Inline Lead Capture with Shimmer
    // =====================================================

    // Minimum time to show generating state (ms)
    const CTA_FORM_GENERATE_MS = 800;

    // SVG for success checkmark
    const CHECK_ICON = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>';

    /**
     * Show lead form as inline CTA card in chat thread
     */
    function showLeadForm() {
        // Create the CTA card message
        const ctaCard = createCtaFormCard();

        // Add to chat thread as assistant message
        if (elements.messages) {
            elements.messages.appendChild(ctaCard);
            scrollToBottom(true);
        }

        // Simulate form "generation" delay then reveal
        const generateStart = Date.now();

        setTimeout(function() {
            transitionCtaToReady(ctaCard);
        }, CTA_FORM_GENERATE_MS);
    }

    /**
     * Create CTA form card element in generating state
     */
    function createCtaFormCard() {
        const messageEl = document.createElement('div');
        messageEl.className = 'chat-message chat-message--bot chat-message--cta';
        messageEl.dataset.type = 'cta_form';

        messageEl.innerHTML = `
            <div class="chat-cta-card chat-cta-card--generating">
                <div class="chat-cta-content">
                    <!-- Skeleton structure -->
                    <div class="chat-cta-skeleton">
                        <div class="chat-cta-skeleton-title"></div>
                        <div class="chat-cta-skeleton-desc"></div>
                        <div class="chat-cta-skeleton-input"></div>
                        <div class="chat-cta-skeleton-input"></div>
                        <div class="chat-cta-skeleton-btn"></div>
                    </div>

                    <!-- Real form (hidden until ready) -->
                    <div class="chat-cta-form-real">
                        <h3 class="chat-cta-title">${config.strings.handoffTitle || 'Let\'s connect you with Ray'}</h3>
                        <p class="chat-cta-desc">${config.strings.handoffDesc || 'Leave your email and Ray will get back to you within 24 hours.'}</p>
                        <input type="text" class="chat-cta-input chat-cta-name" placeholder="Your name (optional)" autocomplete="name">
                        <input type="email" class="chat-cta-input chat-cta-email" placeholder="Email address" autocomplete="email" required>
                        <div class="chat-cta-email-error chat-cta-error" style="display: none;">Please enter a valid email address</div>
                        <button type="button" class="chat-cta-submit">Send Message</button>
                        ${config.scheduleUrl ? '<a href="' + config.scheduleUrl + '" target="_blank" class="chat-cta-secondary">Or schedule a call →</a>' : ''}
                    </div>

                    <!-- Error state -->
                    <div class="chat-cta-error-state">
                        <p class="chat-cta-error-message">Couldn't load the form. Try again.</p>
                        <button type="button" class="chat-cta-retry-btn">Retry</button>
                    </div>

                    <!-- Success state -->
                    <div class="chat-cta-success-state">
                        <div class="chat-cta-success-icon">${CHECK_ICON}</div>
                        <h3 class="chat-cta-success-title">${config.strings.successTitle || 'Message sent!'}</h3>
                        <p class="chat-cta-success-desc">${config.strings.successDesc || 'Ray will be in touch soon.'}</p>
                    </div>
                </div>

                <span class="chat-cta-preparing">Preparing form…</span>
            </div>
        `;

        return messageEl;
    }

    /**
     * Transition CTA card from generating to ready state
     */
    function transitionCtaToReady(messageEl) {
        const card = messageEl.querySelector('.chat-cta-card');
        if (!card) return;

        // Transition classes
        card.classList.remove('chat-cta-card--generating');
        card.classList.add('chat-cta-card--ready');

        // Bind form interactions
        bindCtaFormEvents(messageEl);

        // Focus handling - only if user is not typing
        setTimeout(function() {
            if (document.activeElement !== elements.input) {
                const emailInput = messageEl.querySelector('.chat-cta-email');
                if (emailInput) {
                    emailInput.focus({ preventScroll: true });
                }
            }
        }, 350); // After animation completes
    }

    /**
     * Bind CTA form event handlers
     */
    function bindCtaFormEvents(messageEl) {
        const submitBtn = messageEl.querySelector('.chat-cta-submit');
        const emailInput = messageEl.querySelector('.chat-cta-email');
        const nameInput = messageEl.querySelector('.chat-cta-name');
        const errorEl = messageEl.querySelector('.chat-cta-email-error');
        const retryBtn = messageEl.querySelector('.chat-cta-retry-btn');

        // Submit handler
        if (submitBtn) {
            submitBtn.addEventListener('click', function() {
                handleCtaSubmit(messageEl);
            });
        }

        // Enter key on email input
        if (emailInput) {
            emailInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    handleCtaSubmit(messageEl);
                }
            });

            // Clear error on input
            emailInput.addEventListener('input', function() {
                emailInput.classList.remove('has-error');
                if (errorEl) errorEl.style.display = 'none';
            });
        }

        // Enter key on name input moves to email
        if (nameInput && emailInput) {
            nameInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    emailInput.focus();
                }
            });
        }

        // Retry handler
        if (retryBtn) {
            retryBtn.addEventListener('click', function() {
                retryCtaForm(messageEl);
            });
        }
    }

    /**
     * Handle CTA form submission
     */
    async function handleCtaSubmit(messageEl) {
        const card = messageEl.querySelector('.chat-cta-card');
        const nameInput = messageEl.querySelector('.chat-cta-name');
        const emailInput = messageEl.querySelector('.chat-cta-email');
        const submitBtn = messageEl.querySelector('.chat-cta-submit');
        const errorEl = messageEl.querySelector('.chat-cta-email-error');

        const name = nameInput ? nameInput.value.trim() : '';
        const email = emailInput ? emailInput.value.trim() : '';

        // Validate email
        if (!email || !isValidEmail(email)) {
            if (emailInput) {
                emailInput.classList.add('has-error');
                emailInput.focus();
            }
            if (errorEl) errorEl.style.display = 'block';
            return;
        }

        // Disable submit
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.textContent = config.strings.sending || 'Sending...';
        }

        try {
            await fetch(config.apiUrl.replace('/chat', '/lead'), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-WP-Nonce': config.nonce
                },
                body: JSON.stringify({
                    name: name,
                    email: email,
                    message: '',
                    conversation: conversationHistory
                })
            });

            // Show success state
            if (card) {
                card.classList.remove('chat-cta-card--ready');
                card.classList.add('chat-cta-card--success');
            }

        } catch (error) {
            console.error('Lead submission error:', error);
            // Still show success (best effort)
            if (card) {
                card.classList.remove('chat-cta-card--ready');
                card.classList.add('chat-cta-card--success');
            }
        }
    }

    /**
     * Simple email validation
     */
    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    /**
     * Retry CTA form after error
     */
    function retryCtaForm(messageEl) {
        const card = messageEl.querySelector('.chat-cta-card');
        if (!card) return;

        // Go back to generating state
        card.classList.remove('chat-cta-card--error');
        card.classList.add('chat-cta-card--generating');

        // Then transition to ready
        setTimeout(function() {
            transitionCtaToReady(messageEl);
        }, CTA_FORM_GENERATE_MS);
    }

    /**
     * Show error state on CTA form
     */
    function showCtaError(messageEl) {
        const card = messageEl.querySelector('.chat-cta-card');
        if (!card) return;

        card.classList.remove('chat-cta-card--generating', 'chat-cta-card--ready');
        card.classList.add('chat-cta-card--error');
    }

    // Legacy functions for backwards compatibility
    function handleLeadSubmit(e) {
        // This is now handled by handleCtaSubmit
        e.preventDefault();
    }

    function showSuccess() {
        // This is now handled inline in handleCtaSubmit
    }

    // =====================================================
    // UTILITIES
    // =====================================================

    /**
     * Escape HTML
     */
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // =====================================================
    // TYPEWRITER EFFECT
    // =====================================================

    /**
     * Typewriter effect with semantic chunking and natural timing
     * - Chunks at clause/sentence boundaries when possible
     * - Pauses after punctuation (. ? ! : ;)
     * - Longer pauses after paragraph breaks
     * - Slight timing variation for natural feel
     */
    function typeText(element, text, onComplete) {
        isStreaming = true;

        // Add cursor immediately for presence
        const cursor = document.createElement('span');
        cursor.className = 'chat-cursor';
        element.appendChild(cursor);

        // Parse text into semantic chunks
        const chunks = parseSemanticChunks(text);
        let currentIndex = 0;

        function addNextChunk() {
            if (!isStreaming) {
                // Stopped - show remaining text immediately
                cursor.remove();
                element.textContent = text;
                if (onComplete) onComplete();
                return;
            }

            if (currentIndex < chunks.length) {
                const chunk = chunks[currentIndex];
                currentIndex++;

                const span = document.createElement('span');
                span.className = 'chat-word-group';
                span.textContent = chunk.text;
                element.insertBefore(span, cursor);

                if (!userScrolledUp) {
                    scrollToBottom();
                }

                // Calculate delay based on chunk ending
                const delay = calculateChunkDelay(chunk);
                setTimeout(addNextChunk, delay);
            } else {
                // Completion: wait for settle, then fade cursor
                setTimeout(function() {
                    cursor.classList.add('is-fading');
                    setTimeout(function() {
                        cursor.remove();
                        isStreaming = false;
                        if (onComplete) onComplete();
                    }, 100);
                }, 120); // Settle delay before cursor fade
            }
        }

        addNextChunk();
    }

    /**
     * Parse text into semantic chunks
     * Prefers breaking at clause boundaries (punctuation)
     */
    function parseSemanticChunks(text) {
        const chunks = [];
        const words = text.split(' ');
        let currentChunk = [];
        let chunkStart = true;

        for (let i = 0; i < words.length; i++) {
            const word = words[i];
            currentChunk.push(word);

            // Check for sentence/clause endings
            const endsWithPunctuation = /[.!?;:]$/.test(word);
            const endsWithComma = /,$/.test(word);
            const isNewParagraph = word.includes('\n');

            // Decide when to break chunk
            const shouldBreak = (
                endsWithPunctuation ||
                isNewParagraph ||
                (endsWithComma && currentChunk.length >= 2) ||
                currentChunk.length >= 5 ||
                (currentChunk.length >= 2 && Math.random() < 0.3) // Occasional early break
            );

            if (shouldBreak || i === words.length - 1) {
                const chunkText = (chunkStart ? '' : ' ') + currentChunk.join(' ');
                chunks.push({
                    text: chunkText,
                    endsWithPunctuation: endsWithPunctuation,
                    endsWithComma: endsWithComma,
                    isNewParagraph: isNewParagraph
                });
                currentChunk = [];
                chunkStart = false;
            }
        }

        return chunks;
    }

    /**
     * Calculate delay after chunk based on its ending
     * Natural variation with punctuation pauses
     */
    function calculateChunkDelay(chunk) {
        // Base delay with slight variation (±20ms)
        let delay = 50 + (Math.random() * 40 - 20);

        if (chunk.isNewParagraph) {
            // Longer pause after paragraph
            delay += 120;
        } else if (chunk.endsWithPunctuation) {
            // Pause after sentence-ending punctuation
            delay += 80;
        } else if (chunk.endsWithComma) {
            // Slight pause after comma
            delay += 30;
        }

        return Math.round(delay);
    }

    // =====================================================
    // VOICE INPUT (Speech-to-Text)
    // =====================================================

    /**
     * Initialize Web Speech API
     */
    function initSpeechRecognition() {
        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;

        if (!SpeechRecognition) {
            console.warn('Speech recognition not supported');
            if (elements.micBtn) {
                elements.micBtn.style.display = 'none';
            }
            return;
        }

        recognition = new SpeechRecognition();
        recognition.continuous = true;
        recognition.interimResults = true;
        recognition.lang = 'en-US';

        let finalTranscript = '';
        let silenceTimeout = null;

        recognition.onstart = function() {
            isListening = true;
            finalTranscript = '';
            updateMicButtonState();
            if (elements.input) {
                elements.input.placeholder = 'Listening...';
            }
        };

        recognition.onresult = function(event) {
            let interimTranscript = '';

            for (let i = event.resultIndex; i < event.results.length; i++) {
                const transcript = event.results[i][0].transcript;
                if (event.results[i].isFinal) {
                    finalTranscript += transcript;
                } else {
                    interimTranscript += transcript;
                }
            }

            // Show transcription in real-time
            if (elements.input) {
                elements.input.value = finalTranscript + interimTranscript;
                autoResizeInput();
                updateButtonStates();
            }

            // Reset silence timeout on each result
            if (silenceTimeout) {
                clearTimeout(silenceTimeout);
            }

            // Auto-submit after 1.5s of silence
            silenceTimeout = setTimeout(function() {
                if (isListening && (finalTranscript || interimTranscript)) {
                    stopListening();
                    // Small delay before submit for UX
                    setTimeout(function() {
                        if (elements.input && elements.input.value.trim()) {
                            handleSubmit(new Event('submit'));
                        }
                    }, 200);
                }
            }, 1500);
        };

        recognition.onerror = function(event) {
            console.error('Speech recognition error:', event.error);
            isListening = false;
            updateMicButtonState();

            if (elements.input) {
                elements.input.placeholder = config.strings.placeholder;
            }

            // Show error for certain types
            if (event.error === 'not-allowed') {
                alert('Microphone access denied. Please allow microphone access to use voice input.');
            }
        };

        recognition.onend = function() {
            // Only update if we didn't manually stop (to avoid flicker)
            if (isListening) {
                isListening = false;
                updateMicButtonState();
                if (elements.input) {
                    elements.input.placeholder = config.strings.placeholder;
                }
            }
        };
    }

    /**
     * Toggle voice input on/off
     */
    function toggleVoiceInput() {
        if (isListening) {
            stopListening();
        } else {
            startListening();
        }
    }

    /**
     * Start listening for voice input
     */
    function startListening() {
        if (!recognition || isListening || isStreaming || isLoading) return;

        try {
            recognition.start();
            showMessages(); // Expand chat area
        } catch (e) {
            console.error('Could not start speech recognition:', e);
        }
    }

    /**
     * Stop listening for voice input
     */
    function stopListening() {
        if (!recognition || !isListening) return;

        isListening = false;
        updateMicButtonState();

        try {
            recognition.stop();
        } catch (e) {
            console.error('Could not stop speech recognition:', e);
        }

        if (elements.input) {
            elements.input.placeholder = config.strings.placeholder;
        }
    }

    /**
     * Update mic button visual state
     */
    function updateMicButtonState() {
        if (!elements.micBtn) return;

        if (isListening) {
            elements.micBtn.classList.add('is-listening');
            elements.micBtn.setAttribute('aria-label', 'Stop listening');
        } else {
            elements.micBtn.classList.remove('is-listening');
            elements.micBtn.setAttribute('aria-label', 'Voice input');
        }
    }

    // =====================================================
    // VOICE OUTPUT (Text-to-Speech)
    // =====================================================

    /**
     * Speak text using ElevenLabs TTS
     */
    async function speakText(text) {
        if (!voiceEnabled || !text) return;

        // Stop any currently playing audio
        stopSpeaking();

        try {
            const ttsUrl = config.apiUrl.replace('/chat', '/tts');
            const response = await fetch(ttsUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-WP-Nonce': config.nonce
                },
                body: JSON.stringify({
                    text: text
                })
            });

            const data = await response.json();

            if (data.success && data.audio) {
                // Decode base64 audio and play
                const audioBlob = base64ToBlob(data.audio, data.audio_type);
                const audioUrl = URL.createObjectURL(audioBlob);

                currentAudio = new Audio(audioUrl);
                currentAudio.onended = function() {
                    URL.revokeObjectURL(audioUrl);
                    currentAudio = null;
                    updateSpeakingState(false);
                };
                currentAudio.onerror = function() {
                    console.error('Audio playback error');
                    URL.revokeObjectURL(audioUrl);
                    currentAudio = null;
                    updateSpeakingState(false);
                };

                updateSpeakingState(true);
                await currentAudio.play();
            }
        } catch (error) {
            console.error('TTS error:', error);
            updateSpeakingState(false);
        }
    }

    /**
     * Stop current audio playback
     */
    function stopSpeaking() {
        if (currentAudio) {
            currentAudio.pause();
            currentAudio.currentTime = 0;
            currentAudio = null;
            updateSpeakingState(false);
        }
    }

    /**
     * Update speaking visual state
     */
    function updateSpeakingState(speaking) {
        if (elements.container) {
            elements.container.classList.toggle('is-speaking', speaking);
        }
    }

    /**
     * Convert base64 to Blob
     */
    function base64ToBlob(base64, mimeType) {
        const byteCharacters = atob(base64);
        const byteNumbers = new Array(byteCharacters.length);
        for (let i = 0; i < byteCharacters.length; i++) {
            byteNumbers[i] = byteCharacters.charCodeAt(i);
        }
        const byteArray = new Uint8Array(byteNumbers);
        return new Blob([byteArray], { type: mimeType });
    }

    /**
     * Toggle voice output on/off
     */
    function toggleVoiceOutput() {
        voiceEnabled = !voiceEnabled;
        updateVoiceToggleState();

        // Stop any current playback if disabling
        if (!voiceEnabled) {
            stopSpeaking();
        }
    }

    /**
     * Update voice toggle button state
     */
    function updateVoiceToggleState() {
        if (elements.voiceToggle) {
            elements.voiceToggle.classList.toggle('is-muted', !voiceEnabled);
            elements.voiceToggle.setAttribute('aria-label', voiceEnabled ? 'Mute voice' : 'Unmute voice');
        }
    }

    // Initialize
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})();
