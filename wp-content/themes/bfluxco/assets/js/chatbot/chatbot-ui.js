/**
 * BFLUXCO Chatbot - UI Module
 * DOM manipulation and message rendering functions
 */

(function() {
    'use strict';

    // Get references from namespace
    var ns = window.BfluxcoChatbot;

    // =====================================================
    // SCROLLBAR MANAGEMENT
    // =====================================================

    var scrollbarTimeout = null;

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
        var elements = ns.state.elements;
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
            var elements = ns.state.elements;
            if (elements.messages) {
                elements.messages.classList.remove('is-scrolling');
            }
        }, 1000);
    }

    /**
     * Handle scroll for smart scrolling behavior
     */
    function handleScroll() {
        var elements = ns.state.elements;
        if (!elements.messages) return;

        var threshold = 100;
        var isAtBottom = elements.messages.scrollHeight - elements.messages.scrollTop - elements.messages.clientHeight < threshold;

        if (isAtBottom) {
            ns.state.userScrolledUp = false;
            if (elements.jumpBtn) {
                elements.jumpBtn.classList.remove('is-visible');
            }
        } else {
            ns.state.userScrolledUp = true;
            if (elements.jumpBtn && ns.state.conversationHistory.length > 0) {
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
        var elements = ns.state.elements;
        var hasText = elements.input && elements.input.value.trim().length > 0;
        var hasMessages = ns.state.conversationHistory.length > 0;
        var isExpanded = hasText || hasMessages;

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

    /**
     * Auto-resize textarea (grows upward, bottom anchored)
     * Uses CSS transform + negative margin to keep bottom edge fixed
     */
    function autoResizeInput() {
        var elements = ns.state.elements;
        if (!elements.input) return;

        // Measure true height needed
        elements.input.style.height = 'auto';
        var newHeight = Math.min(elements.input.scrollHeight, 120); // max-height
        elements.input.style.height = newHeight + 'px';

        // Handle overflow when at max height
        elements.input.style.overflowY = newHeight >= 120 ? 'auto' : 'hidden';

        // Calculate growth from base height
        var growth = newHeight - ns.BASE_INPUT_HEIGHT;

        if (elements.inputWrapper) {
            if (growth > 0) {
                // Shift visually upward
                elements.inputWrapper.style.transform = 'translateY(-' + growth + 'px)';
                // Compensate for height growth so parent doesn't expand
                elements.inputWrapper.style.marginBottom = '-' + growth + 'px';
            } else {
                elements.inputWrapper.style.transform = '';
                elements.inputWrapper.style.marginBottom = '';
            }
        }
    }

    /**
     * Scroll to bottom smoothly
     */
    function scrollToBottom(force) {
        var elements = ns.state.elements;
        if (!elements.messages) return;

        if (force || !ns.state.userScrolledUp) {
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
        var elements = ns.state.elements;
        if (elements.messages) {
            elements.messages.classList.add('is-active');
        }
        if (elements.blurOverlay) {
            elements.blurOverlay.classList.add('is-active');
        }
        if (elements.container) {
            elements.container.classList.add('is-expanded');
        }

        var heroVideo = document.querySelector('.hero-video');
        if (heroVideo) {
            heroVideo.pause();
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
        var messageEl = document.createElement('div');
        messageEl.className = 'chat-message chat-message--user';
        messageEl.dataset.index = index;
        messageEl.innerHTML = '\n            <div class="chat-bubble">' + escapeHtml(text) + '</div>\n            <div class="chat-message-actions">\n                <button type="button" class="chat-edit-btn" aria-label="Edit message" title="Edit">\n                    ' + ns.ICONS.edit + '\n                </button>\n            </div>\n        ';

        // Edit button handler
        var editBtn = messageEl.querySelector('.chat-edit-btn');
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
        var messageEl = document.createElement('div');
        messageEl.className = 'chat-message chat-message--bot';
        messageEl.dataset.index = index;
        messageEl.innerHTML = '\n            <div class="chat-bubble">' + escapeHtml(text) + '</div>\n            <div class="chat-actions is-visible">\n                <button type="button" class="chat-action-btn chat-copy-btn" aria-label="Copy" title="Copy">' + ns.ICONS.copy + '</button>\n                <button type="button" class="chat-action-btn chat-regenerate-btn" aria-label="Regenerate" title="Regenerate">' + ns.ICONS.regenerate + '</button>\n                <button type="button" class="chat-action-btn chat-like-btn" aria-label="Good response" title="Good response">' + ns.ICONS.like + '</button>\n                <button type="button" class="chat-action-btn chat-dislike-btn" aria-label="Bad response" title="Bad response">' + ns.ICONS.dislike + '</button>\n            </div>\n        ';

        setupBotMessageActions(messageEl, text);
        return messageEl;
    }

    /**
     * Add user message
     */
    function addUserMessage(text, messageIndex) {
        var elements = ns.state.elements;
        var index = messageIndex !== undefined ? messageIndex : ns.state.conversationHistory.length;

        ns.state.conversationHistory.push({
            role: 'user',
            content: text
        });

        var messageEl = createUserMessageElement(text, index);

        if (elements.messages) {
            elements.messages.appendChild(messageEl);
            scrollToBottom(true); // Force scroll for user messages
        }

        ns.history.saveHistory();
        updateButtonStates();
    }

    /**
     * Add thinking placeholder message
     * Shows immediately after user submits, transitions to typing when response arrives
     */
    function addThinkingPlaceholder() {
        var elements = ns.state.elements;
        var messageId = ns.generateMessageId();
        ns.state.thinkingStartTime = Date.now();

        var messageEl = document.createElement('div');
        messageEl.className = 'chat-message chat-message--bot chat-message--thinking';
        messageEl.dataset.messageId = messageId;
        messageEl.dataset.status = 'thinking';
        messageEl.innerHTML = '\n            <div class="chat-bubble">\n                <span class="chat-thinking-dots">\n                    <span class="chat-thinking-dot"></span>\n                    <span class="chat-thinking-dot"></span>\n                    <span class="chat-thinking-dot"></span>\n                </span>\n            </div>\n            <div class="chat-actions">\n                <button type="button" class="chat-action-btn chat-stop-btn-inline" aria-label="Stop" title="Stop">' + ns.ICONS.stop + '</button>\n            </div>\n        ';

        // Stop button handler
        var stopBtn = messageEl.querySelector('.chat-stop-btn-inline');
        if (stopBtn) {
            stopBtn.addEventListener('click', function() {
                ns.api.stopGeneration();
                // Convert to error message
                transitionPlaceholderToError(messageEl, 'Response cancelled.');
            });
        }

        if (elements.messages) {
            elements.messages.appendChild(messageEl);
            scrollToBottom(true);
        }

        ns.state.currentPlaceholder = messageEl;
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

        var bubble = placeholderEl.querySelector('.chat-bubble');
        var actions = placeholderEl.querySelector('.chat-actions');

        // Clear thinking dots
        bubble.innerHTML = '';

        // Add cursor immediately
        var cursor = document.createElement('span');
        cursor.className = 'chat-cursor';
        bubble.appendChild(cursor);

        // Hide stop button, prepare action buttons
        if (actions) {
            actions.innerHTML = '\n                <button type="button" class="chat-action-btn chat-copy-btn" aria-label="Copy" title="Copy">' + ns.ICONS.copy + '</button>\n                <button type="button" class="chat-action-btn chat-regenerate-btn" aria-label="Regenerate" title="Regenerate">' + ns.ICONS.regenerate + '</button>\n                <button type="button" class="chat-action-btn chat-like-btn" aria-label="Good response" title="Good response">' + ns.ICONS.like + '</button>\n                <button type="button" class="chat-action-btn chat-dislike-btn" aria-label="Bad response" title="Bad response">' + ns.ICONS.dislike + '</button>\n            ';
        }

        // Start typing animation
        ns.state.isStreaming = true;
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
            ns.state.conversationHistory.push({
                role: 'assistant',
                content: content
            });
            ns.history.saveHistory();

            ns.state.isStreaming = false;
            ns.state.currentPlaceholder = null;

            if (onComplete) onComplete();
        });

        // Speak the response if voice is enabled
        ns.api.speakText(content);
    }

    /**
     * Transition placeholder to error state
     */
    function transitionPlaceholderToError(placeholderEl, errorMessage) {
        if (!placeholderEl) return;

        placeholderEl.classList.remove('chat-message--thinking', 'chat-message--typing');
        placeholderEl.classList.add('chat-message--error');
        placeholderEl.dataset.status = 'final';

        var bubble = placeholderEl.querySelector('.chat-bubble');
        var actions = placeholderEl.querySelector('.chat-actions');

        bubble.className = 'chat-bubble chat-bubble--error';
        bubble.textContent = errorMessage;

        if (actions) {
            actions.innerHTML = '\n                <button type="button" class="chat-action-btn chat-retry-btn" aria-label="Retry" title="Retry">' + ns.ICONS.regenerate + '</button>\n            ';
            actions.classList.add('is-visible');

            var retryBtn = actions.querySelector('.chat-retry-btn');
            if (retryBtn) {
                retryBtn.addEventListener('click', function() {
                    retryFromPlaceholder(placeholderEl);
                });
            }
        }

        ns.state.currentPlaceholder = null;
        ns.state.isLoading = false;
        ns.state.isStreaming = false;
    }

    /**
     * Retry from error placeholder
     */
    function retryFromPlaceholder(errorEl) {
        if (ns.state.isStreaming || ns.state.isLoading || !ns.state.lastUserMessage) return;

        // Remove error message
        errorEl.remove();

        // Add new thinking placeholder and resend
        addThinkingPlaceholder();
        ns.api.sendMessage(ns.state.lastUserMessage);
    }

    /**
     * Type text into an element with cursor
     * @param {HTMLElement} element - Container element
     * @param {HTMLElement} cursor - Cursor element
     * @param {string} text - Text to type
     * @param {Function} onComplete - Callback when done
     */
    function typeTextInElement(element, cursor, text, onComplete) {
        var chunks = parseSemanticChunks(text);
        var currentIndex = 0;

        function addNextChunk() {
            if (!ns.state.isStreaming) {
                // Stopped - show remaining text immediately
                cursor.remove();
                element.textContent = text;
                if (onComplete) onComplete();
                return;
            }

            if (currentIndex < chunks.length) {
                var chunk = chunks[currentIndex];
                currentIndex++;

                var span = document.createElement('span');
                span.className = 'chat-word-group';
                span.textContent = chunk.text;
                element.insertBefore(span, cursor);

                if (!ns.state.userScrolledUp) {
                    scrollToBottom();
                }

                var delay = calculateChunkDelay(chunk);
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
        if (ns.state.isStreaming || ns.state.isLoading) return;

        var bubble = messageEl.querySelector('.chat-bubble');
        var actions = messageEl.querySelector('.chat-message-actions');

        // Replace bubble with textarea
        var textarea = document.createElement('textarea');
        textarea.className = 'chat-edit-input';
        textarea.value = originalText;
        bubble.replaceWith(textarea);
        actions.style.display = 'none';

        // Create edit controls
        var controls = document.createElement('div');
        controls.className = 'chat-edit-controls';
        controls.innerHTML = '\n            <button type="button" class="chat-edit-save btn btn-primary btn-sm">Save & Submit</button>\n            <button type="button" class="chat-edit-cancel btn btn-outline btn-sm">Cancel</button>\n        ';
        messageEl.appendChild(controls);

        textarea.focus({ preventScroll: true });
        textarea.setSelectionRange(textarea.value.length, textarea.value.length);

        // Save handler
        controls.querySelector('.chat-edit-save').addEventListener('click', function() {
            var newText = textarea.value.trim();
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
                var newText = textarea.value.trim();
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
        var textarea = messageEl.querySelector('.chat-edit-input');
        var controls = messageEl.querySelector('.chat-edit-controls');

        var bubble = document.createElement('div');
        bubble.className = 'chat-bubble';
        bubble.textContent = originalText;
        textarea.replaceWith(bubble);

        if (controls) controls.remove();
    }

    /**
     * Finish editing and regenerate from that point
     */
    function finishEditMessage(messageEl, newText, index) {
        var elements = ns.state.elements;
        // Remove all messages after this one
        var allMessages = elements.messages.querySelectorAll('.chat-message');
        var foundIndex = false;
        allMessages.forEach(function(msg) {
            if (foundIndex) {
                msg.remove();
            }
            if (msg === messageEl) {
                foundIndex = true;
            }
        });

        // Truncate conversation history
        ns.state.conversationHistory = ns.state.conversationHistory.slice(0, index);

        // Update the message
        var textarea = messageEl.querySelector('.chat-edit-input');
        var controls = messageEl.querySelector('.chat-edit-controls');
        var actions = messageEl.querySelector('.chat-message-actions');

        var bubble = document.createElement('div');
        bubble.className = 'chat-bubble';
        bubble.textContent = newText;
        textarea.replaceWith(bubble);

        if (controls) controls.remove();
        if (actions) actions.style.display = '';

        // Update history with new text
        ns.state.conversationHistory.push({
            role: 'user',
            content: newText
        });

        ns.history.saveHistory();

        // Send the edited message with thinking placeholder
        ns.state.lastUserMessage = newText;
        addThinkingPlaceholder();
        ns.api.sendMessage(newText);
    }

    /**
     * Add bot message with streaming
     * @param {string} text - The message text
     * @param {boolean} isError - Whether this is an error message
     * @param {boolean} typingWasShown - Whether typing indicator was shown (for seamless transition)
     */
    function addBotMessage(text, isError, typingWasShown) {
        var elements = ns.state.elements;
        ns.state.conversationHistory.push({
            role: 'assistant',
            content: text
        });

        var messageEl = document.createElement('div');
        messageEl.className = 'chat-message chat-message--bot' + (isError ? ' chat-message--error' : '');
        messageEl.dataset.index = ns.state.conversationHistory.length - 1;

        if (isError) {
            messageEl.innerHTML = '\n                <div class="chat-bubble chat-bubble--error">' + escapeHtml(text) + '</div>\n                <div class="chat-actions">\n                    <button type="button" class="chat-action-btn chat-retry-btn" aria-label="Retry" title="Retry">' + ns.ICONS.regenerate + '</button>\n                </div>\n            ';

            var retryBtn = messageEl.querySelector('.chat-retry-btn');
            retryBtn.addEventListener('click', function() {
                retryLastMessage(messageEl);
            });

            var actions = messageEl.querySelector('.chat-actions');
            actions.classList.add('is-visible');
        } else {
            messageEl.innerHTML = '\n                <div class="chat-bubble"></div>\n                <div class="chat-actions">\n                    <button type="button" class="chat-action-btn chat-copy-btn" aria-label="Copy" title="Copy">' + ns.ICONS.copy + '</button>\n                    <button type="button" class="chat-action-btn chat-regenerate-btn" aria-label="Regenerate" title="Regenerate">' + ns.ICONS.regenerate + '</button>\n                    <button type="button" class="chat-action-btn chat-like-btn" aria-label="Good response" title="Good response">' + ns.ICONS.like + '</button>\n                    <button type="button" class="chat-action-btn chat-dislike-btn" aria-label="Bad response" title="Bad response">' + ns.ICONS.dislike + '</button>\n                </div>\n            ';

            var bubble = messageEl.querySelector('.chat-bubble');
            var actions = messageEl.querySelector('.chat-actions');

            // Seamless transition: hide typing indicator, then stream with cursor already present
            if (typingWasShown) {
                hideTyping();
            }

            // Stream text with semantic chunking
            typeText(bubble, escapeHtml(text), function() {
                // Settle delay before showing actions (120-200ms per spec)
                setTimeout(function() {
                    actions.classList.add('is-visible');
                    ns.history.saveHistory();
                }, 150);
            });

            // Speak the response if voice is enabled
            ns.api.speakText(text);

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
        var copyBtn = messageEl.querySelector('.chat-copy-btn');
        var regenerateBtn = messageEl.querySelector('.chat-regenerate-btn');
        var likeBtn = messageEl.querySelector('.chat-like-btn');
        var dislikeBtn = messageEl.querySelector('.chat-dislike-btn');

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
        if (ns.state.isStreaming || ns.state.isLoading) return;

        var index = parseInt(messageEl.dataset.index);

        // Find the user message before this bot message
        var userMessage = null;
        for (var i = index - 1; i >= 0; i--) {
            if (ns.state.conversationHistory[i] && ns.state.conversationHistory[i].role === 'user') {
                userMessage = ns.state.conversationHistory[i].content;
                break;
            }
        }

        if (!userMessage) return;

        // Fade out then remove
        messageEl.classList.add('is-fading');

        setTimeout(function() {
            // Remove this bot message from DOM and history
            messageEl.remove();
            ns.state.conversationHistory = ns.state.conversationHistory.slice(0, index);
            ns.history.saveHistory();

            // Resend with new thinking placeholder
            ns.state.lastUserMessage = userMessage;
            addThinkingPlaceholder();
            ns.api.sendMessage(userMessage);
        }, 100);
    }

    /**
     * Retry after error
     */
    function retryLastMessage(errorMessageEl) {
        if (ns.state.isStreaming || ns.state.isLoading || !ns.state.lastUserMessage) return;

        // Remove error message
        errorMessageEl.remove();
        ns.state.conversationHistory.pop();
        ns.history.saveHistory();

        ns.api.sendMessage(ns.state.lastUserMessage);
    }

    /**
     * Show typing indicator with cursor and stop button
     */
    function showTyping() {
        var elements = ns.state.elements;
        var typingEl = document.createElement('div');
        typingEl.className = 'chat-typing-container';
        typingEl.id = 'chat-typing';
        typingEl.innerHTML = '\n            <span class="chat-cursor"></span>\n            <button type="button" class="chat-stop-btn" aria-label="Stop generating">\n                ' + ns.ICONS.stop + '\n                <span>Stop</span>\n            </button>\n        ';

        var stopBtn = typingEl.querySelector('.chat-stop-btn');
        stopBtn.addEventListener('click', ns.api.stopGeneration);

        if (elements.messages) {
            elements.messages.appendChild(typingEl);
            scrollToBottom();
        }
    }

    /**
     * Hide typing indicator
     */
    function hideTyping() {
        var typingEl = document.getElementById('chat-typing');
        if (typingEl) {
            typingEl.remove();
        }
    }

    // =====================================================
    // UTILITIES
    // =====================================================

    /**
     * Escape HTML
     */
    function escapeHtml(text) {
        var div = document.createElement('div');
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
        ns.state.isStreaming = true;

        // Add cursor immediately for presence
        var cursor = document.createElement('span');
        cursor.className = 'chat-cursor';
        element.appendChild(cursor);

        // Parse text into semantic chunks
        var chunks = parseSemanticChunks(text);
        var currentIndex = 0;

        function addNextChunk() {
            if (!ns.state.isStreaming) {
                // Stopped - show remaining text immediately
                cursor.remove();
                element.textContent = text;
                if (onComplete) onComplete();
                return;
            }

            if (currentIndex < chunks.length) {
                var chunk = chunks[currentIndex];
                currentIndex++;

                var span = document.createElement('span');
                span.className = 'chat-word-group';
                span.textContent = chunk.text;
                element.insertBefore(span, cursor);

                if (!ns.state.userScrolledUp) {
                    scrollToBottom();
                }

                // Calculate delay based on chunk ending
                var delay = calculateChunkDelay(chunk);
                setTimeout(addNextChunk, delay);
            } else {
                // Completion: wait for settle, then fade cursor
                setTimeout(function() {
                    cursor.classList.add('is-fading');
                    setTimeout(function() {
                        cursor.remove();
                        ns.state.isStreaming = false;
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
        var chunks = [];
        var words = text.split(' ');
        var currentChunk = [];
        var chunkStart = true;

        for (var i = 0; i < words.length; i++) {
            var word = words[i];
            currentChunk.push(word);

            // Check for sentence/clause endings
            var endsWithPunctuation = /[.!?;:]$/.test(word);
            var endsWithComma = /,$/.test(word);
            var isNewParagraph = word.indexOf('\n') !== -1;

            // Decide when to break chunk
            var shouldBreak = (
                endsWithPunctuation ||
                isNewParagraph ||
                (endsWithComma && currentChunk.length >= 2) ||
                currentChunk.length >= 5 ||
                (currentChunk.length >= 2 && Math.random() < 0.3) // Occasional early break
            );

            if (shouldBreak || i === words.length - 1) {
                var chunkText = (chunkStart ? '' : ' ') + currentChunk.join(' ');
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
        var delay = 50 + (Math.random() * 40 - 20);

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
    // CTA FORM CARD - Inline Lead Capture with Shimmer
    // =====================================================

    /**
     * Show lead form as inline CTA card in chat thread
     */
    function showLeadForm() {
        var elements = ns.state.elements;
        // Create the CTA card message
        var ctaCard = createCtaFormCard();

        // Add to chat thread as assistant message
        if (elements.messages) {
            elements.messages.appendChild(ctaCard);
            scrollToBottom(true);
        }

        // Simulate form "generation" delay then reveal
        setTimeout(function() {
            transitionCtaToReady(ctaCard);
        }, ns.CTA_FORM_GENERATE_MS);
    }

    /**
     * Create CTA form card element in generating state
     */
    function createCtaFormCard() {
        var messageEl = document.createElement('div');
        messageEl.className = 'chat-message chat-message--bot chat-message--cta';
        messageEl.dataset.type = 'cta_form';

        messageEl.innerHTML = '\n            <div class="chat-cta-card chat-cta-card--generating">\n                <div class="chat-cta-content">\n                    <!-- Skeleton structure -->\n                    <div class="chat-cta-skeleton">\n                        <div class="chat-cta-skeleton-title"></div>\n                        <div class="chat-cta-skeleton-desc"></div>\n                        <div class="chat-cta-skeleton-input"></div>\n                        <div class="chat-cta-skeleton-input"></div>\n                        <div class="chat-cta-skeleton-btn"></div>\n                    </div>\n\n                    <!-- Real form (hidden until ready) -->\n                    <div class="chat-cta-form-real">\n                        <h3 class="chat-cta-title">' + (ns.config.strings.handoffTitle || 'Let\'s connect you with Ray') + '</h3>\n                        <p class="chat-cta-desc">' + (ns.config.strings.handoffDesc || 'Leave your email and Ray will get back to you within 24 hours.') + '</p>\n                        <input type="text" class="chat-cta-input chat-cta-name" placeholder="Your name (optional)" autocomplete="name">\n                        <input type="email" class="chat-cta-input chat-cta-email" placeholder="Email address" autocomplete="email" required>\n                        <div class="chat-cta-email-error chat-cta-error" style="display: none;">Please enter a valid email address</div>\n                        <button type="button" class="chat-cta-submit">Send Message</button>\n                        ' + (ns.config.scheduleUrl ? '<a href="' + ns.config.scheduleUrl + '" target="_blank" class="chat-cta-secondary">Or schedule a call \u2192</a>' : '') + '\n                    </div>\n\n                    <!-- Error state -->\n                    <div class="chat-cta-error-state">\n                        <p class="chat-cta-error-message">Couldn\'t load the form. Try again.</p>\n                        <button type="button" class="chat-cta-retry-btn">Retry</button>\n                    </div>\n\n                    <!-- Success state -->\n                    <div class="chat-cta-success-state">\n                        <div class="chat-cta-success-icon">' + ns.CHECK_ICON + '</div>\n                        <h3 class="chat-cta-success-title">' + (ns.config.strings.successTitle || 'Message sent!') + '</h3>\n                        <p class="chat-cta-success-desc">' + (ns.config.strings.successDesc || 'Ray will be in touch soon.') + '</p>\n                    </div>\n                </div>\n\n                <span class="chat-cta-preparing">Preparing form\u2026</span>\n            </div>\n        ';

        return messageEl;
    }

    /**
     * Transition CTA card from generating to ready state
     */
    function transitionCtaToReady(messageEl) {
        var elements = ns.state.elements;
        var card = messageEl.querySelector('.chat-cta-card');
        if (!card) return;

        // Transition classes
        card.classList.remove('chat-cta-card--generating');
        card.classList.add('chat-cta-card--ready');

        // Bind form interactions
        bindCtaFormEvents(messageEl);

        // Focus handling - only if user is not typing
        setTimeout(function() {
            if (document.activeElement !== elements.input) {
                var emailInput = messageEl.querySelector('.chat-cta-email');
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
        var submitBtn = messageEl.querySelector('.chat-cta-submit');
        var emailInput = messageEl.querySelector('.chat-cta-email');
        var nameInput = messageEl.querySelector('.chat-cta-name');
        var errorEl = messageEl.querySelector('.chat-cta-email-error');
        var retryBtn = messageEl.querySelector('.chat-cta-retry-btn');

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
        var card = messageEl.querySelector('.chat-cta-card');
        var nameInput = messageEl.querySelector('.chat-cta-name');
        var emailInput = messageEl.querySelector('.chat-cta-email');
        var submitBtn = messageEl.querySelector('.chat-cta-submit');
        var errorEl = messageEl.querySelector('.chat-cta-email-error');

        var name = nameInput ? nameInput.value.trim() : '';
        var email = emailInput ? emailInput.value.trim() : '';

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
            submitBtn.textContent = ns.config.strings.sending || 'Sending...';
        }

        try {
            // Use API module for data submission
            await ns.api.submitLead({
                name: name,
                email: email,
                conversation: ns.state.conversationHistory
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
        var card = messageEl.querySelector('.chat-cta-card');
        if (!card) return;

        // Go back to generating state
        card.classList.remove('chat-cta-card--error');
        card.classList.add('chat-cta-card--generating');

        // Then transition to ready
        setTimeout(function() {
            transitionCtaToReady(messageEl);
        }, ns.CTA_FORM_GENERATE_MS);
    }

    /**
     * Show error state on CTA form
     */
    function showCtaError(messageEl) {
        var card = messageEl.querySelector('.chat-cta-card');
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
    // UI CALLBACKS (called by API module)
    // =====================================================

    /**
     * Handle speaking state change from API module
     * @param {boolean} speaking - Whether TTS is currently playing
     */
    function onSpeakingStateChange(speaking) {
        var elements = ns.state.elements;
        if (elements.container) {
            elements.container.classList.toggle('is-speaking', speaking);
        }
    }

    /**
     * Handle voice toggle state change from API module
     * @param {boolean} enabled - Whether voice output is enabled
     */
    function onVoiceToggleStateChange(enabled) {
        var elements = ns.state.elements;
        if (elements.voiceToggle) {
            elements.voiceToggle.classList.toggle('is-muted', !enabled);
            elements.voiceToggle.setAttribute('aria-label', enabled ? 'Mute voice' : 'Unmute voice');
        }
    }

    /**
     * Handle mic button state change from API module
     * @param {boolean} isListening - Whether voice input is active
     */
    function onMicButtonStateChange(isListening) {
        var elements = ns.state.elements;
        if (!elements.micBtn) return;

        elements.micBtn.classList.toggle('is-listening', isListening);
        elements.micBtn.setAttribute('aria-label', isListening ? 'Stop listening' : 'Voice input');
    }

    /**
     * Handle speech recognition not supported
     */
    function onSpeechNotSupported() {
        var elements = ns.state.elements;
        if (elements.micBtn) {
            elements.micBtn.style.display = 'none';
        }
    }

    // Export to namespace
    ns.ui = {
        handleScrollbarVisibility: handleScrollbarVisibility,
        showScrollbar: showScrollbar,
        hideScrollbarDelayed: hideScrollbarDelayed,
        handleScroll: handleScroll,
        updateButtonStates: updateButtonStates,
        autoResizeInput: autoResizeInput,
        scrollToBottom: scrollToBottom,
        showMessages: showMessages,
        createUserMessageElement: createUserMessageElement,
        createBotMessageElement: createBotMessageElement,
        addUserMessage: addUserMessage,
        addThinkingPlaceholder: addThinkingPlaceholder,
        transitionPlaceholderToTyping: transitionPlaceholderToTyping,
        transitionPlaceholderToError: transitionPlaceholderToError,
        retryFromPlaceholder: retryFromPlaceholder,
        typeTextInElement: typeTextInElement,
        startEditMessage: startEditMessage,
        cancelEditMessage: cancelEditMessage,
        finishEditMessage: finishEditMessage,
        addBotMessage: addBotMessage,
        setupBotMessageActions: setupBotMessageActions,
        regenerateResponse: regenerateResponse,
        retryLastMessage: retryLastMessage,
        showTyping: showTyping,
        hideTyping: hideTyping,
        escapeHtml: escapeHtml,
        typeText: typeText,
        parseSemanticChunks: parseSemanticChunks,
        calculateChunkDelay: calculateChunkDelay,
        showLeadForm: showLeadForm,
        createCtaFormCard: createCtaFormCard,
        transitionCtaToReady: transitionCtaToReady,
        bindCtaFormEvents: bindCtaFormEvents,
        handleCtaSubmit: handleCtaSubmit,
        isValidEmail: isValidEmail,
        retryCtaForm: retryCtaForm,
        showCtaError: showCtaError,
        handleLeadSubmit: handleLeadSubmit,
        showSuccess: showSuccess,
        // UI callbacks for API module
        onSpeakingStateChange: onSpeakingStateChange,
        onVoiceToggleStateChange: onVoiceToggleStateChange,
        onMicButtonStateChange: onMicButtonStateChange,
        onSpeechNotSupported: onSpeechNotSupported
    };

})();
