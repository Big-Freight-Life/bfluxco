/**
 * Claude Code Terminal Simulation
 *
 * Interactive terminal-style UI demonstrating agent workflow.
 * Simulates realistic human-agent discourse.
 *
 * @package BFLUXCO
 */

(function() {
    'use strict';

    // Configuration - very fast timing
    var config = {
        humanTypingSpeed: 2,         // Human typing speed (very fast)
        humanTypingVariation: 1,     // Minimal variation
        agentTypingSpeed: 1,         // Agent types instantly
        agentTypingVariation: 0,     // No variation
        linePause: 60,               // Pause between lines
        blockPause: 120,             // Pause between blocks
        thinkingDuration: 500,       // Agent thinking time
        responseDelay: 80,           // Delay before agent responds
        codeLineDelay: 10,           // Delay between code lines
        initialDelay: 800,           // Initial delay before starting
        loopDelay: 2500              // Delay before restarting
    };

    // Simulation sequence - human/agent discourse
    var sequence = [
        {
            type: 'human',
            text: 'build a multi-agent system for automated customer support with intent classification and escalation paths'
        },
        {
            type: 'thinking',
            text: 'Analyzing requirements...'
        },
        {
            type: 'agent',
            text: "Hey Ray! I'll design a multi-agent workflow with specialized handlers for triage, resolution, and escalation."
        },
        {
            type: 'action',
            verb: 'Planning',
            file: 'workflow architecture'
        },
        {
            type: 'empty'
        },
        {
            type: 'agent',
            text: 'The workflow will use three coordinated agents:'
        },
        {
            type: 'code',
            lines: [
                { text: '1. Triage Agent', color: 'type' },
                { text: '   → Classifies incoming requests', color: 'comment' },
                { text: '   → Routes to appropriate handler', color: 'comment' },
            ]
        },
        {
            type: 'code',
            lines: [
                { text: '2. Resolution Agent', color: 'type' },
                { text: '   → Handles common issues', color: 'comment' },
                { text: '   → Accesses knowledge base', color: 'comment' },
            ]
        },
        {
            type: 'code',
            lines: [
                { text: '3. Escalation Agent', color: 'type' },
                { text: '   → Complex issue handling', color: 'comment' },
                { text: '   → Human handoff when needed', color: 'comment' },
            ]
        },
        {
            type: 'empty'
        },
        {
            type: 'action',
            verb: 'Write',
            file: 'src/agents/triage.py'
        },
        {
            type: 'code',
            lines: [
                { parts: [
                    { text: 'from', color: 'keyword' },
                    { text: ' langchain.agents ', color: 'default' },
                    { text: 'import', color: 'keyword' },
                    { text: ' Agent', color: 'type' }
                ]},
                { parts: [
                    { text: 'from', color: 'keyword' },
                    { text: ' langchain.tools ', color: 'default' },
                    { text: 'import', color: 'keyword' },
                    { text: ' Tool', color: 'type' }
                ]},
                { text: '', color: 'default' },
                { parts: [
                    { text: 'class', color: 'keyword' },
                    { text: ' TriageAgent', color: 'type' },
                    { text: ':', color: 'default' }
                ]},
                { parts: [
                    { text: '    ', color: 'default' },
                    { text: 'def', color: 'keyword' },
                    { text: ' classify', color: 'function' },
                    { text: '(self, request):', color: 'default' }
                ]},
                { parts: [
                    { text: '        ', color: 'default' },
                    { text: '"""Route request to handler"""', color: 'string' }
                ]},
                { parts: [
                    { text: '        intent = self.', color: 'default' },
                    { text: 'analyze', color: 'function' },
                    { text: '(request)', color: 'default' }
                ]},
                { parts: [
                    { text: '        ', color: 'default' },
                    { text: 'return', color: 'keyword' },
                    { text: ' self.router[intent]', color: 'default' }
                ]}
            ]
        },
        {
            type: 'success',
            text: 'Created src/agents/triage.py'
        },
        {
            type: 'empty'
        },
        {
            type: 'human',
            text: 'add try-catch error handling with fallback to human support queue'
        },
        {
            type: 'thinking',
            text: 'Adding error handling...'
        },
        {
            type: 'action',
            verb: 'Edit',
            file: 'src/agents/triage.py'
        },
        {
            type: 'code',
            lines: [
                { parts: [
                    { text: '        ', color: 'default' },
                    { text: 'try', color: 'keyword' },
                    { text: ':', color: 'default' }
                ]},
                { parts: [
                    { text: '            intent = self.', color: 'default' },
                    { text: 'analyze', color: 'function' },
                    { text: '(request)', color: 'default' }
                ]},
                { parts: [
                    { text: '        ', color: 'default' },
                    { text: 'except', color: 'keyword' },
                    { text: ' ClassificationError:', color: 'type' }
                ]},
                { parts: [
                    { text: '            ', color: 'default' },
                    { text: 'return', color: 'keyword' },
                    { text: ' self.', color: 'default' },
                    { text: 'fallback_handler', color: 'function' }
                ]}
            ]
        },
        {
            type: 'success',
            text: 'Updated src/agents/triage.py'
        },
        {
            type: 'empty'
        },
        {
            type: 'agent',
            text: 'Error handling added. The agent now gracefully handles classification failures.'
        }
    ];

    var terminals = [];

    /**
     * Initialize all terminal instances
     */
    function init() {
        var elements = document.querySelectorAll('.claude-terminal');
        elements.forEach(function(el) {
            var terminal = new ClaudeTerminal(el);
            terminals.push(terminal);
            terminal.start();
        });
    }

    /**
     * Claude Terminal Class
     */
    function ClaudeTerminal(element) {
        this.element = element;
        this.output = element.querySelector('.claude-terminal-output');
        this.input = element.querySelector('.claude-terminal-input');
        this.sequenceIndex = 0;
        this.isRunning = false;
    }

    /**
     * Start the simulation
     */
    ClaudeTerminal.prototype.start = function() {
        if (this.isRunning) return;
        this.isRunning = true;

        var self = this;

        // Show initial state for a moment
        setTimeout(function() {
            self.runSequence();
        }, config.initialDelay);
    };

    /**
     * Run through the simulation sequence
     */
    ClaudeTerminal.prototype.runSequence = function() {
        var self = this;

        if (this.sequenceIndex >= sequence.length) {
            // Reset and loop
            setTimeout(function() {
                self.reset();
                self.runSequence();
            }, config.loopDelay);
            return;
        }

        var item = sequence[this.sequenceIndex];
        this.sequenceIndex++;

        this.renderItem(item, function() {
            var pause = item.type === 'human' ? config.responseDelay : config.linePause;
            setTimeout(function() {
                self.runSequence();
            }, pause);
        });
    };

    /**
     * Render a sequence item
     */
    ClaudeTerminal.prototype.renderItem = function(item, callback) {
        switch (item.type) {
            case 'human':
                this.renderHumanPrompt(item.text, callback);
                break;
            case 'thinking':
                this.renderThinking(item.text, callback);
                break;
            case 'agent':
                this.renderAgentResponse(item.text, callback);
                break;
            case 'action':
                this.renderAction(item.verb, item.file, callback);
                break;
            case 'code':
                this.renderCode(item.lines, callback);
                break;
            case 'success':
                this.renderSuccess(item.text, callback);
                break;
            case 'empty':
                this.renderEmpty(callback);
                break;
            default:
                callback();
        }
    };

    /**
     * Render human prompt with typing in input field
     */
    ClaudeTerminal.prototype.renderHumanPrompt = function(text, callback) {
        var self = this;
        var index = 0;

        // Clear input field first
        if (this.input) {
            this.input.value = '';
            this.input.placeholder = '';
        }

        // Type into input field
        function typeInInput() {
            if (index >= text.length) {
                // Pause, then move to output
                setTimeout(function() {
                    self.movePromptToOutput(text, callback);
                }, 150);
                return;
            }

            if (self.input) {
                self.input.value += text[index];
            }
            index++;

            var delay = config.humanTypingSpeed + (Math.random() * config.humanTypingVariation);
            setTimeout(typeInInput, delay);
        }

        typeInInput();
    };

    /**
     * Move prompt from input to output area
     */
    ClaudeTerminal.prototype.movePromptToOutput = function(text, callback) {
        // Clear input
        if (this.input) {
            this.input.value = '';
            this.input.placeholder = 'Try "design an agent workflow"';
        }

        // Add to output
        var line = document.createElement('div');
        line.className = 'claude-terminal-user-prompt';
        line.innerHTML = '<span class="prompt-symbol">&gt;</span><span class="prompt-text">' + text + '</span>';
        this.output.appendChild(line);
        this.scrollToBottom();

        callback();
    };

    /**
     * Render thinking indicator
     */
    ClaudeTerminal.prototype.renderThinking = function(text, callback) {
        var line = document.createElement('div');
        line.className = 'claude-terminal-thinking';
        line.innerHTML = '<span class="dot">●</span><span class="text">' + text + '</span>';
        this.output.appendChild(line);
        this.scrollToBottom();

        setTimeout(function() {
            callback();
        }, config.thinkingDuration);
    };

    /**
     * Render agent response instantly (no typing simulation)
     */
    ClaudeTerminal.prototype.renderAgentResponse = function(text, callback) {
        var line = document.createElement('div');
        line.className = 'claude-terminal-response';
        line.textContent = text;
        this.output.appendChild(line);
        this.scrollToBottom();

        setTimeout(callback, config.responseDelay);
    };

    /**
     * Render action line
     */
    ClaudeTerminal.prototype.renderAction = function(verb, file, callback) {
        var line = document.createElement('div');
        line.className = 'claude-terminal-action';
        line.innerHTML = '<span class="action-verb">' + verb + '</span><span class="action-file">' + file + '</span>';
        this.output.appendChild(line);
        this.scrollToBottom();

        setTimeout(callback, 300);
    };

    /**
     * Render code block
     */
    ClaudeTerminal.prototype.renderCode = function(lines, callback) {
        var self = this;
        var container = document.createElement('div');
        container.className = 'claude-terminal-code';
        this.output.appendChild(container);

        var lineIndex = 0;

        function renderNextLine() {
            if (lineIndex >= lines.length) {
                callback();
                return;
            }

            var lineData = lines[lineIndex];
            var lineEl = document.createElement('div');
            lineEl.className = 'claude-terminal-line';

            if (lineData.parts) {
                // Multi-part line with different colors
                lineData.parts.forEach(function(part) {
                    var span = document.createElement('span');
                    span.className = part.color || 'default';
                    span.textContent = part.text;
                    lineEl.appendChild(span);
                });
            } else if (lineData.text === '') {
                lineEl.className += ' empty';
            } else {
                var span = document.createElement('span');
                span.className = lineData.color || 'default';
                span.textContent = lineData.text;
                lineEl.appendChild(span);
            }

            container.appendChild(lineEl);
            self.scrollToBottom();
            lineIndex++;

            setTimeout(renderNextLine, config.codeLineDelay);
        }

        renderNextLine();
    };

    /**
     * Render success message
     */
    ClaudeTerminal.prototype.renderSuccess = function(text, callback) {
        var line = document.createElement('div');
        line.className = 'claude-terminal-success';
        line.innerHTML = '<span class="checkmark">✓</span><span class="message">' + text + '</span>';
        this.output.appendChild(line);
        this.scrollToBottom();

        setTimeout(callback, config.blockPause);
    };

    /**
     * Render empty line
     */
    ClaudeTerminal.prototype.renderEmpty = function(callback) {
        var line = document.createElement('div');
        line.className = 'claude-terminal-line empty';
        this.output.appendChild(line);

        setTimeout(callback, 150);
    };

    /**
     * Scroll output to bottom
     */
    ClaudeTerminal.prototype.scrollToBottom = function() {
        this.output.scrollTop = this.output.scrollHeight;
    };

    /**
     * Reset terminal for loop
     */
    ClaudeTerminal.prototype.reset = function() {
        // Keep the help text, clear everything else
        var help = this.output.querySelector('.claude-terminal-help');

        this.output.innerHTML = '';

        if (help) {
            this.output.appendChild(help);
        }

        // Reset input
        if (this.input) {
            this.input.value = '';
            this.input.placeholder = 'Try "design an agent workflow"';
        }

        this.sequenceIndex = 0;
    };

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // Expose API
    window.claudeTerminal = {
        init: init
    };

})();
