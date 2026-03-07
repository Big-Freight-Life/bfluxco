/**
 * AI Chat Admin JavaScript
 * Handles Chart.js charts, form submissions, and interactive UI
 */

(function() {
    'use strict';

    // Chart instances storage
    const charts = {};

    // Default chart colors
    const colors = {
        primary: '#2271b1',
        success: '#00a32a',
        warning: '#dba617',
        danger: '#d63638',
        purple: '#8b5cf6',
        pink: '#ec4899',
        gray: '#646970',
        teal: '#10b981',
        indigo: '#6366f1',
        orange: '#f59e0b'
    };

    // ==========================================
    // Initialization
    // ==========================================

    document.addEventListener('DOMContentLoaded', function() {
        initCharts();
        initForms();
        initModals();
        initTimeRangeToggles();
        initTrainingTable();
        initRulesTable();
        initCollapsibles();
        initPersonaTab();
    });

    // ==========================================
    // Collapsible Sections
    // ==========================================

    function initCollapsibles() {
        document.querySelectorAll('.collapsible-header').forEach(header => {
            header.addEventListener('click', function(e) {
                // Don't toggle if clicking a button inside the header
                if (e.target.closest('.button') || e.target.closest('.info-btn')) {
                    return;
                }
                const section = this.closest('.collapsible-section');
                section.classList.toggle('is-collapsed');
            });
        });

        // Info button opens modal
        const rulesInfoBtn = document.getElementById('rules-info-btn');
        if (rulesInfoBtn) {
            rulesInfoBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                openModal('rules-info-modal');
            });
        }
    }

    // ==========================================
    // Chart Initialization
    // ==========================================

    function initCharts() {
        // Get current tab from URL
        const urlParams = new URLSearchParams(window.location.search);
        const currentTab = urlParams.get('tab') || 'overview';

        // Initialize charts based on current tab
        // Max 10 charts total, max 2 per tab
        switch (currentTab) {
            case 'overview':
                // Chart 1 & 2: System health
                loadChart('response_time_trend', 'chart-response-time', 'line');
                loadChart('error_fallback_rate', 'chart-error-rate', 'line');
                break;
            case 'boundaries':
                // Chart 3 & 4: Risk awareness
                loadChart('top_triggered_rules', 'chart-top-rules', 'bar');
                loadChart('boundary_triggers_trend', 'chart-boundary-trend', 'line');
                break;
            case 'monitoring':
                // Chart 5 & 6: Conversation observability
                loadChart('conversation_funnel', 'chart-funnel', 'bar');
                loadChart('dropoff_by_turn', 'chart-dropoff', 'bar');
                break;
            case 'feedback':
                // Chart 7 & 8: User perception
                loadChart('feedback_trend', 'chart-feedback-trend', 'line');
                loadChart('feedback_reasons', 'chart-feedback-reasons', 'bar');
                break;
            case 'system':
                // Chart 9 & 10: Sustainability
                loadChart('provider_usage', 'chart-provider-usage', 'doughnut');
                loadChart('rate_limit_events', 'chart-rate-limits', 'line');
                break;
        }
    }

    function loadChart(chartType, canvasId, chartKind, timeRange = '7d') {
        const canvas = document.getElementById(canvasId);
        if (!canvas) return;

        // Show loading state
        const container = canvas.closest('.chart-container');
        const helperEl = container?.querySelector('.chart-helper');

        // Fetch chart data
        fetchChartData(chartType, timeRange)
            .then(data => {
                if (data.error) {
                    console.error('Chart error:', data.error);
                    return;
                }

                // Destroy existing chart if any
                if (charts[canvasId]) {
                    charts[canvasId].destroy();
                }

                // Create chart based on type
                charts[canvasId] = createChart(canvas, chartKind, data);

                // Update helper text
                if (helperEl && data.helper) {
                    helperEl.textContent = data.helper;
                }
            })
            .catch(err => {
                console.error('Failed to load chart:', err);
            });
    }

    function fetchChartData(chartType, timeRange) {
        const formData = new FormData();
        formData.append('action', 'bfluxco_ai_get_chart_data');
        formData.append('nonce', bfluxcoAiChat.nonce);
        formData.append('chart_type', chartType);
        formData.append('time_range', timeRange);

        return fetch(bfluxcoAiChat.ajaxUrl, {
            method: 'POST',
            credentials: 'same-origin',
            body: formData
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                return result.data;
            }
            throw new Error(result.data || 'Unknown error');
        });
    }

    function createChart(canvas, type, data) {
        const ctx = canvas.getContext('2d');

        const config = {
            type: type,
            data: {
                labels: data.labels || [],
                datasets: data.datasets || []
            },
            options: getChartOptions(type)
        };

        return new Chart(ctx, config);
    }

    function getChartOptions(type) {
        const baseOptions = {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                }
            }
        };

        if (type === 'line') {
            return {
                ...baseOptions,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                elements: {
                    line: {
                        tension: 0.3
                    },
                    point: {
                        radius: 3,
                        hoverRadius: 5
                    }
                }
            };
        }

        if (type === 'bar') {
            return {
                ...baseOptions,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            };
        }

        if (type === 'doughnut' || type === 'pie') {
            return {
                ...baseOptions,
                cutout: type === 'doughnut' ? '60%' : 0
            };
        }

        return baseOptions;
    }

    // ==========================================
    // Time Range Toggles
    // ==========================================

    function initTimeRangeToggles() {
        document.querySelectorAll('.time-range-toggle').forEach(toggle => {
            toggle.querySelectorAll('.time-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const chartType = toggle.dataset.chart;
                    const timeRange = this.dataset.range;

                    // Update active state
                    toggle.querySelectorAll('.time-btn').forEach(b => b.classList.remove('active'));
                    this.classList.add('active');

                    // Reload chart
                    const container = toggle.closest('.chart-container');
                    const canvas = container.querySelector('canvas');
                    if (canvas && chartType) {
                        const chartKind = getChartKind(chartType);
                        loadChart(chartType, canvas.id, chartKind, timeRange);
                    }
                });
            });
        });
    }

    function getChartKind(chartType) {
        const lineCharts = [
            'response_time_trend',
            'error_fallback_rate',
            'boundary_triggers_trend',
            'feedback_trend',
            'rate_limit_events'
        ];
        const doughnutCharts = ['provider_usage'];

        if (lineCharts.includes(chartType)) return 'line';
        if (doughnutCharts.includes(chartType)) return 'doughnut';
        return 'bar';
    }

    // ==========================================
    // Form Handling
    // ==========================================

    function initForms() {
        // Behavior form
        const behaviorForm = document.getElementById('behavior-form');
        if (behaviorForm) {
            behaviorForm.addEventListener('submit', handleFormSubmit);
        }

        // System form
        const systemForm = document.getElementById('system-form');
        if (systemForm) {
            systemForm.addEventListener('submit', handleFormSubmit);
        }

        // Boundaries form
        const boundariesForm = document.getElementById('boundaries-form');
        if (boundariesForm) {
            boundariesForm.addEventListener('submit', handleFormSubmit);
        }
    }

    function handleFormSubmit(e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);
        formData.append('nonce', bfluxcoAiChat.nonce);

        const statusEl = form.querySelector('.save-status');
        const submitBtn = form.querySelector('button[type="submit"]');

        // Disable button
        submitBtn.disabled = true;
        statusEl.textContent = bfluxcoAiChat.strings.loading;
        statusEl.classList.remove('error');

        fetch(bfluxcoAiChat.ajaxUrl, {
            method: 'POST',
            credentials: 'same-origin',
            body: formData
        })
        .then(response => response.json())
        .then(result => {
            submitBtn.disabled = false;
            if (result.success) {
                statusEl.textContent = bfluxcoAiChat.strings.saved;
                statusEl.classList.remove('error');
                setTimeout(() => {
                    statusEl.textContent = '';
                }, 3000);
            } else {
                statusEl.textContent = result.data || bfluxcoAiChat.strings.error;
                statusEl.classList.add('error');
            }
        })
        .catch(err => {
            submitBtn.disabled = false;
            statusEl.textContent = bfluxcoAiChat.strings.error;
            statusEl.classList.add('error');
        });
    }

    // ==========================================
    // Modal Handling
    // ==========================================

    function initModals() {
        // Close modal on backdrop click
        document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
            backdrop.addEventListener('click', function() {
                this.closest('.modal').classList.remove('is-open');
            });
        });

        // Close modal on X click
        document.querySelectorAll('.modal-close, .modal-cancel').forEach(btn => {
            btn.addEventListener('click', function() {
                this.closest('.modal').classList.remove('is-open');
            });
        });

        // Close modal on ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('.modal.is-open').forEach(modal => {
                    modal.classList.remove('is-open');
                });
            }
        });
    }

    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('is-open');
        }
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('is-open');
        }
    }

    // ==========================================
    // Rules Table
    // ==========================================

    function initRulesTable() {
        // Add rule button
        const addRuleBtn = document.getElementById('add-rule-btn');
        if (addRuleBtn) {
            addRuleBtn.addEventListener('click', function() {
                const form = document.getElementById('rule-form');
                form.reset();
                form.querySelector('[name="rule_id"]').value = '';
                document.querySelector('#rule-modal .modal-header h3').textContent = 'Add Rule';
                openModal('rule-modal');
            });
        }

        // Edit rule buttons
        document.querySelectorAll('.edit-rule').forEach(btn => {
            btn.addEventListener('click', function() {
                const ruleId = this.dataset.id;
                // In a full implementation, fetch rule data and populate form
                document.querySelector('#rule-modal .modal-header h3').textContent = 'Edit Rule';
                document.querySelector('[name="rule_id"]').value = ruleId;
                openModal('rule-modal');
            });
        });

        // Delete rule buttons
        document.querySelectorAll('.delete-rule').forEach(btn => {
            btn.addEventListener('click', function() {
                if (!confirm(bfluxcoAiChat.strings.confirmDelete)) return;

                const ruleId = this.dataset.id;
                const row = this.closest('tr');

                const formData = new FormData();
                formData.append('action', 'bfluxco_ai_delete_rule');
                formData.append('nonce', bfluxcoAiChat.nonce);
                formData.append('rule_id', ruleId);

                fetch(bfluxcoAiChat.ajaxUrl, {
                    method: 'POST',
                    credentials: 'same-origin',
                    body: formData
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        row.remove();
                    }
                });
            });
        });

        // Rule form submission
        const ruleForm = document.getElementById('rule-form');
        if (ruleForm) {
            ruleForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                formData.append('action', 'bfluxco_ai_save_rule');
                formData.append('nonce', bfluxcoAiChat.nonce);

                fetch(bfluxcoAiChat.ajaxUrl, {
                    method: 'POST',
                    credentials: 'same-origin',
                    body: formData
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        closeModal('rule-modal');
                        location.reload();
                    }
                });
            });
        }
    }

    // ==========================================
    // Training Table
    // ==========================================

    function initTrainingTable() {
        // Add training button
        const addTrainingBtn = document.getElementById('add-training-btn');
        if (addTrainingBtn) {
            addTrainingBtn.addEventListener('click', function() {
                const form = document.getElementById('training-form');
                form.reset();
                form.querySelector('[name="training_id"]').value = '';
                document.querySelector('#training-modal .modal-header h3').textContent = 'Add Training Example';
                openModal('training-modal');
            });
        }

        // Add training button (empty state)
        const addTrainingBtnEmpty = document.getElementById('add-training-btn-empty');
        if (addTrainingBtnEmpty) {
            addTrainingBtnEmpty.addEventListener('click', function() {
                const form = document.getElementById('training-form');
                form.reset();
                form.querySelector('[name="training_id"]').value = '';
                document.querySelector('#training-modal .modal-header h3').textContent = 'Add Training Example';
                openModal('training-modal');
            });
        }

        // Export button
        const exportBtn = document.getElementById('export-training-btn');
        if (exportBtn) {
            exportBtn.addEventListener('click', function() {
                const formData = new FormData();
                formData.append('action', 'bfluxco_ai_export_training');
                formData.append('nonce', bfluxcoAiChat.nonce);

                fetch(bfluxcoAiChat.ajaxUrl, {
                    method: 'POST',
                    credentials: 'same-origin',
                    body: formData
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        const dataStr = JSON.stringify(result.data, null, 2);
                        const blob = new Blob([dataStr], { type: 'application/json' });
                        const url = URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = 'ai-chat-training-' + new Date().toISOString().slice(0, 10) + '.json';
                        a.click();
                        URL.revokeObjectURL(url);
                    }
                });
            });
        }

        // Select all checkbox
        const selectAll = document.getElementById('select-all-training');
        if (selectAll) {
            selectAll.addEventListener('change', function() {
                document.querySelectorAll('.training-checkbox').forEach(cb => {
                    cb.checked = this.checked;
                });
                updateBulkActions();
            });
        }

        // Individual checkboxes
        document.querySelectorAll('.training-checkbox').forEach(cb => {
            cb.addEventListener('change', updateBulkActions);
        });

        // Edit training buttons
        document.querySelectorAll('.edit-training').forEach(btn => {
            btn.addEventListener('click', function() {
                const trainingId = this.dataset.id;
                document.querySelector('#training-modal .modal-header h3').textContent = 'Edit Training Example';
                document.querySelector('[name="training_id"]').value = trainingId;
                // In full implementation, populate form with existing data
                openModal('training-modal');
            });
        });

        // Approve training buttons
        document.querySelectorAll('.approve-training').forEach(btn => {
            btn.addEventListener('click', function() {
                const trainingId = this.dataset.id;
                updateTrainingStatus(trainingId, 'approve');
            });
        });

        // Delete training buttons
        document.querySelectorAll('.delete-training').forEach(btn => {
            btn.addEventListener('click', function() {
                if (!confirm(bfluxcoAiChat.strings.confirmDelete)) return;

                const trainingId = this.dataset.id;
                const row = this.closest('tr');

                const formData = new FormData();
                formData.append('action', 'bfluxco_ai_delete_training');
                formData.append('nonce', bfluxcoAiChat.nonce);
                formData.append('training_id', trainingId);

                fetch(bfluxcoAiChat.ajaxUrl, {
                    method: 'POST',
                    credentials: 'same-origin',
                    body: formData
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        row.remove();
                    }
                });
            });
        });

        // Training form submission
        const trainingForm = document.getElementById('training-form');
        if (trainingForm) {
            trainingForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const trainingId = formData.get('training_id');
                formData.append('action', trainingId ? 'bfluxco_ai_update_training' : 'bfluxco_ai_add_training');
                formData.append('nonce', bfluxcoAiChat.nonce);

                fetch(bfluxcoAiChat.ajaxUrl, {
                    method: 'POST',
                    credentials: 'same-origin',
                    body: formData
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        closeModal('training-modal');
                        location.reload();
                    }
                });
            });
        }

        // Bulk action buttons
        document.querySelectorAll('.bulk-approve, .bulk-reject, .bulk-delete').forEach(btn => {
            btn.addEventListener('click', function() {
                const action = this.classList.contains('bulk-approve') ? 'approve' :
                              this.classList.contains('bulk-reject') ? 'reject' : 'delete';

                if (action === 'delete' && !confirm(bfluxcoAiChat.strings.confirmDelete)) return;

                const ids = getSelectedTrainingIds();
                if (ids.length === 0) return;

                const formData = new FormData();
                formData.append('action', 'bfluxco_ai_bulk_training');
                formData.append('nonce', bfluxcoAiChat.nonce);
                formData.append('action_type', action);
                ids.forEach(id => formData.append('ids[]', id));

                fetch(bfluxcoAiChat.ajaxUrl, {
                    method: 'POST',
                    credentials: 'same-origin',
                    body: formData
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        location.reload();
                    }
                });
            });
        });
    }

    function updateBulkActions() {
        const selected = getSelectedTrainingIds();
        const bulkActions = document.querySelector('.bulk-actions');
        const countEl = document.querySelector('.selected-count');

        if (bulkActions) {
            bulkActions.style.display = selected.length > 0 ? 'flex' : 'none';
        }
        if (countEl) {
            countEl.textContent = selected.length + ' selected';
        }
    }

    function getSelectedTrainingIds() {
        const ids = [];
        document.querySelectorAll('.training-checkbox:checked').forEach(cb => {
            ids.push(cb.value);
        });
        return ids;
    }

    function updateTrainingStatus(trainingId, actionType) {
        const formData = new FormData();
        formData.append('action', 'bfluxco_ai_update_training');
        formData.append('nonce', bfluxcoAiChat.nonce);
        formData.append('training_id', trainingId);
        formData.append('action_type', actionType);

        fetch(bfluxcoAiChat.ajaxUrl, {
            method: 'POST',
            credentials: 'same-origin',
            body: formData
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                location.reload();
            }
        });
    }

    // ==========================================
    // Persona Tab
    // ==========================================

    function initPersonaTab() {
        // Persona form submission
        const personaForm = document.getElementById('persona-form');
        if (personaForm) {
            personaForm.addEventListener('submit', handlePersonaSubmit);
        }

        // Rollback buttons
        document.querySelectorAll('.rollback-version').forEach(btn => {
            btn.addEventListener('click', handleRollback);
        });

        // First-turn guardrail warning
        initFirstTurnWarning();
    }

    function initFirstTurnWarning() {
        const greetingField = document.querySelector('textarea[name="greeting_message"]');
        const capabilitiesToggle = document.querySelector('input[name="announce_capabilities"]');
        const limitationsToggle = document.querySelector('input[name="show_bot_limitations"]');
        const warningEl = document.querySelector('.first-turn-warning');

        if (!greetingField || !capabilitiesToggle || !limitationsToggle || !warningEl) return;

        function checkFirstTurnElements() {
            let count = 0;
            if (greetingField.value.trim()) count++;
            if (capabilitiesToggle.checked) count++;
            if (limitationsToggle.checked) count++;

            warningEl.style.display = count > 2 ? 'block' : 'none';
        }

        greetingField.addEventListener('input', checkFirstTurnElements);
        capabilitiesToggle.addEventListener('change', checkFirstTurnElements);
        limitationsToggle.addEventListener('change', checkFirstTurnElements);

        // Initial check
        checkFirstTurnElements();
    }

    function handlePersonaSubmit(e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);
        formData.append('action', 'bfluxco_ai_save_persona');
        formData.append('nonce', bfluxcoAiChat.nonce);

        const statusEl = form.querySelector('.save-status');
        const submitBtn = form.querySelector('button[type="submit"]');

        // Disable button
        submitBtn.disabled = true;
        statusEl.textContent = bfluxcoAiChat.strings.loading;
        statusEl.classList.remove('error');

        fetch(bfluxcoAiChat.ajaxUrl, {
            method: 'POST',
            credentials: 'same-origin',
            body: formData
        })
        .then(response => response.json())
        .then(result => {
            submitBtn.disabled = false;
            if (result.success) {
                statusEl.textContent = bfluxcoAiChat.strings.saved;
                statusEl.classList.remove('error');

                // Update version badge if present
                const versionBadge = document.querySelector('.version-badge');
                if (versionBadge && result.data.version) {
                    versionBadge.textContent = 'v' + result.data.version;
                }

                // Update last modified
                const versionDate = document.querySelector('.version-date');
                if (versionDate) {
                    versionDate.textContent = 'Just now';
                }

                // Clear change notes
                const changeNotes = form.querySelector('[name="change_notes"]');
                if (changeNotes) {
                    changeNotes.value = '';
                }

                setTimeout(() => {
                    statusEl.textContent = '';
                }, 3000);
            } else {
                statusEl.textContent = result.data || bfluxcoAiChat.strings.error;
                statusEl.classList.add('error');
            }
        })
        .catch(err => {
            submitBtn.disabled = false;
            statusEl.textContent = bfluxcoAiChat.strings.error;
            statusEl.classList.add('error');
        });
    }

    function handleRollback(e) {
        const version = this.dataset.version;

        if (!confirm('Are you sure you want to rollback to version ' + version + '? Your current settings will be saved to version history.')) {
            return;
        }

        const formData = new FormData();
        formData.append('action', 'bfluxco_ai_rollback_persona');
        formData.append('nonce', bfluxcoAiChat.nonce);
        formData.append('version', version);

        fetch(bfluxcoAiChat.ajaxUrl, {
            method: 'POST',
            credentials: 'same-origin',
            body: formData
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                // Reload page to show rolled-back version
                location.reload();
            } else {
                alert(result.data || 'Failed to rollback. Please try again.');
            }
        })
        .catch(err => {
            alert('Failed to rollback. Please try again.');
        });
    }

})();
