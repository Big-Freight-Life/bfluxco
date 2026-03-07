/**
 * BFLUXCO Chatbot - API Module
 * API/fetch calls and streaming logic
 */

(function() {
    'use strict';

    // Get references from namespace
    var ns = window.BfluxcoChatbot;

    // =====================================================
    // API COMMUNICATION
    // =====================================================

    /**
     * Send message to API
     * Uses placeholder-based flow with minimum thinking time
     */
    async function sendMessage(message) {
        ns.state.isLoading = true;
        setInputState(true);

        // Reset scroll state for new message
        ns.state.userScrolledUp = false;

        ns.state.currentStreamController = new AbortController();

        // Capture the placeholder that was created before calling this function
        var placeholder = ns.state.currentPlaceholder;

        try {
            var response = await fetch(ns.config.apiUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-WP-Nonce': ns.config.nonce
                },
                body: JSON.stringify({
                    message: message,
                    history: ns.state.conversationHistory.filter(function(m) {
                        return m.role !== 'assistant' || ns.state.conversationHistory.indexOf(m) < ns.state.conversationHistory.length - 1;
                    })
                }),
                signal: ns.state.currentStreamController.signal
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            var data = await response.json();

            if (data.success && data.response) {
                // Ensure minimum thinking time has elapsed
                var elapsed = Date.now() - ns.state.thinkingStartTime;
                var remainingDelay = Math.max(0, ns.MIN_THINK_MS - elapsed);

                setTimeout(function() {
                    if (placeholder && placeholder.parentNode) {
                        ns.ui.transitionPlaceholderToTyping(placeholder, data.response, function() {
                            if (data.handoff) {
                                ns.ui.showLeadForm();
                            }
                            processMessageQueue();
                        });
                    }
                }, remainingDelay);
            } else {
                // Error response from API
                if (placeholder && placeholder.parentNode) {
                    ns.ui.transitionPlaceholderToError(placeholder, ns.config.strings.error);
                }
                processMessageQueue();
            }

        } catch (error) {
            if (error.name === 'AbortError') {
                // User stopped generation - placeholder already handled by stop button
            } else {
                console.error('Chat error:', error);
                if (placeholder && placeholder.parentNode) {
                    ns.ui.transitionPlaceholderToError(placeholder, ns.config.strings.error);
                }
            }
            processMessageQueue();
        } finally {
            ns.state.isLoading = false;
            ns.state.currentStreamController = null;
            setInputState(true);
        }
    }

    /**
     * Process queued messages
     */
    function processMessageQueue() {
        if (ns.state.messageQueue.length > 0 && !ns.state.isLoading && !ns.state.isStreaming) {
            var nextMessage = ns.state.messageQueue.shift();
            ns.state.lastUserMessage = nextMessage;
            ns.ui.addUserMessage(nextMessage);
            ns.ui.addThinkingPlaceholder();
            sendMessage(nextMessage);
        }
    }

    /**
     * Set input state
     */
    function setInputState(enabled) {
        var elements = ns.state.elements;
        if (elements.input) {
            elements.input.disabled = !enabled;
        }
    }

    /**
     * Stop generation
     */
    function stopGeneration() {
        if (ns.state.currentStreamController) {
            ns.state.currentStreamController.abort();
            ns.state.currentStreamController = null;
        }
        ns.state.isStreaming = false;
        ns.state.isLoading = false;
        ns.ui.hideTyping();
        setInputState(true);
    }

    // =====================================================
    // VOICE OUTPUT (Text-to-Speech)
    // =====================================================

    /**
     * Speak text using ElevenLabs TTS
     */
    async function speakText(text) {
        if (!ns.state.voiceEnabled || !text) return;

        // Stop any currently playing audio
        stopSpeaking();

        try {
            var ttsUrl = ns.config.apiUrl.replace('/chat', '/tts');
            var response = await fetch(ttsUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-WP-Nonce': ns.config.nonce
                },
                body: JSON.stringify({
                    text: text
                })
            });

            var data = await response.json();

            if (data.success && data.audio) {
                // Decode base64 audio and play
                var audioBlob = base64ToBlob(data.audio, data.audio_type);
                var audioUrl = URL.createObjectURL(audioBlob);

                ns.state.currentAudio = new Audio(audioUrl);
                ns.state.currentAudio.onended = function() {
                    URL.revokeObjectURL(audioUrl);
                    ns.state.currentAudio = null;
                    updateSpeakingState(false);
                };
                ns.state.currentAudio.onerror = function() {
                    console.error('Audio playback error');
                    URL.revokeObjectURL(audioUrl);
                    ns.state.currentAudio = null;
                    updateSpeakingState(false);
                };

                updateSpeakingState(true);
                await ns.state.currentAudio.play();
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
        if (ns.state.currentAudio) {
            ns.state.currentAudio.pause();
            ns.state.currentAudio.currentTime = 0;
            ns.state.currentAudio = null;
            updateSpeakingState(false);
        }
    }

    /**
     * Update speaking visual state (via UI callback)
     */
    function updateSpeakingState(speaking) {
        // Delegate to UI module for DOM manipulation
        if (ns.ui && ns.ui.onSpeakingStateChange) {
            ns.ui.onSpeakingStateChange(speaking);
        }
    }

    /**
     * Convert base64 to Blob
     */
    function base64ToBlob(base64, mimeType) {
        var byteCharacters = atob(base64);
        var byteNumbers = new Array(byteCharacters.length);
        for (var i = 0; i < byteCharacters.length; i++) {
            byteNumbers[i] = byteCharacters.charCodeAt(i);
        }
        var byteArray = new Uint8Array(byteNumbers);
        return new Blob([byteArray], { type: mimeType });
    }

    /**
     * Toggle voice output on/off
     */
    function toggleVoiceOutput() {
        ns.state.voiceEnabled = !ns.state.voiceEnabled;
        updateVoiceToggleState();

        // Stop any current playback if disabling
        if (!ns.state.voiceEnabled) {
            stopSpeaking();
        }
    }

    /**
     * Update voice toggle button state (via UI callback)
     */
    function updateVoiceToggleState() {
        // Delegate to UI module for DOM manipulation
        if (ns.ui && ns.ui.onVoiceToggleStateChange) {
            ns.ui.onVoiceToggleStateChange(ns.state.voiceEnabled);
        }
    }

    // =====================================================
    // VOICE INPUT (Speech-to-Text)
    // =====================================================

    /**
     * Initialize Web Speech API
     */
    function initSpeechRecognition() {
        var SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        var elements = ns.state.elements;

        if (!SpeechRecognition) {
            console.warn('Speech recognition not supported');
            // Delegate to UI module for DOM manipulation
            if (ns.ui && ns.ui.onSpeechNotSupported) {
                ns.ui.onSpeechNotSupported();
            }
            return;
        }

        ns.state.recognition = new SpeechRecognition();
        ns.state.recognition.continuous = true;
        ns.state.recognition.interimResults = true;
        ns.state.recognition.lang = 'en-US';

        var finalTranscript = '';
        var silenceTimeout = null;

        ns.state.recognition.onstart = function() {
            ns.state.isListening = true;
            finalTranscript = '';
            updateMicButtonState();
            if (elements.input) {
                elements.input.placeholder = 'Listening...';
            }
        };

        ns.state.recognition.onresult = function(event) {
            var interimTranscript = '';

            for (var i = event.resultIndex; i < event.results.length; i++) {
                var transcript = event.results[i][0].transcript;
                if (event.results[i].isFinal) {
                    finalTranscript += transcript;
                } else {
                    interimTranscript += transcript;
                }
            }

            // Show transcription in real-time
            if (elements.input) {
                elements.input.value = finalTranscript + interimTranscript;
                ns.ui.autoResizeInput();
                ns.ui.updateButtonStates();
            }

            // Reset silence timeout on each result
            if (silenceTimeout) {
                clearTimeout(silenceTimeout);
            }

            // Auto-submit after 1.5s of silence
            silenceTimeout = setTimeout(function() {
                if (ns.state.isListening && (finalTranscript || interimTranscript)) {
                    stopListening();
                    // Small delay before submit for UX
                    setTimeout(function() {
                        if (elements.input && elements.input.value.trim()) {
                            ns.main.handleSubmit(new Event('submit'));
                        }
                    }, 200);
                }
            }, 1500);
        };

        ns.state.recognition.onerror = function(event) {
            console.error('Speech recognition error:', event.error);
            ns.state.isListening = false;
            updateMicButtonState();

            if (elements.input) {
                elements.input.placeholder = ns.config.strings.placeholder;
            }

            // Show error for certain types
            if (event.error === 'not-allowed') {
                alert('Microphone access denied. Please allow microphone access to use voice input.');
            }
        };

        ns.state.recognition.onend = function() {
            // Only update if we didn't manually stop (to avoid flicker)
            if (ns.state.isListening) {
                ns.state.isListening = false;
                updateMicButtonState();
                if (elements.input) {
                    elements.input.placeholder = ns.config.strings.placeholder;
                }
            }
        };
    }

    /**
     * Toggle voice input on/off
     */
    function toggleVoiceInput() {
        if (ns.state.isListening) {
            stopListening();
        } else {
            startListening();
        }
    }

    /**
     * Start listening for voice input
     */
    function startListening() {
        if (!ns.state.recognition || ns.state.isListening || ns.state.isStreaming || ns.state.isLoading) return;

        try {
            ns.state.recognition.start();
            ns.ui.showMessages(); // Expand chat area
        } catch (e) {
            console.error('Could not start speech recognition:', e);
        }
    }

    /**
     * Stop listening for voice input
     */
    function stopListening() {
        if (!ns.state.recognition || !ns.state.isListening) return;

        ns.state.isListening = false;
        updateMicButtonState();

        try {
            ns.state.recognition.stop();
        } catch (e) {
            console.error('Could not stop speech recognition:', e);
        }

        var elements = ns.state.elements;
        if (elements.input) {
            elements.input.placeholder = ns.config.strings.placeholder;
        }
    }

    /**
     * Update mic button visual state (via UI callback)
     */
    function updateMicButtonState() {
        // Delegate to UI module for DOM manipulation
        if (ns.ui && ns.ui.onMicButtonStateChange) {
            ns.ui.onMicButtonStateChange(ns.state.isListening);
        }
    }

    // =====================================================
    // LEAD SUBMISSION
    // =====================================================

    /**
     * Submit lead data to API
     * @param {Object} data - Lead data { name, email, conversation }
     * @returns {Promise} Fetch promise
     */
    function submitLead(data) {
        return fetch(ns.config.apiUrl.replace('/chat', '/lead'), {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-WP-Nonce': ns.config.nonce
            },
            body: JSON.stringify({
                name: data.name,
                email: data.email,
                message: '',
                conversation: data.conversation
            })
        });
    }

    // Export to namespace
    ns.api = {
        sendMessage: sendMessage,
        processMessageQueue: processMessageQueue,
        setInputState: setInputState,
        stopGeneration: stopGeneration,
        speakText: speakText,
        stopSpeaking: stopSpeaking,
        toggleVoiceOutput: toggleVoiceOutput,
        updateVoiceToggleState: updateVoiceToggleState,
        initSpeechRecognition: initSpeechRecognition,
        toggleVoiceInput: toggleVoiceInput,
        startListening: startListening,
        stopListening: stopListening,
        updateMicButtonState: updateMicButtonState,
        submitLead: submitLead
    };

})();
