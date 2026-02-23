/**
 * BFLUXCO Theme Toggle Component
 *
 * Handles light/dark/system theme switching with localStorage persistence.
 * Supports three modes:
 *   - 'light': Force light theme
 *   - 'dark': Force dark theme
 *   - 'system': Follow OS/browser preference
 *
 * CRITICAL REQUIREMENTS (from INTERFACE.md):
 * - Persists to localStorage key: 'bfluxco-theme'
 * - Supports: 'light', 'dark', 'system' values
 * - Listens to matchMedia('prefers-color-scheme') changes
 * - Updates aria-checked on buttons
 *
 * @package BFLUXCO
 */

/**
 * ThemeToggle Class
 *
 * Self-contained theme toggle management with full accessibility support.
 *
 * @example
 * // Initialize (auto-finds .theme-toggle element)
 * const themeToggle = new ThemeToggle();
 *
 * // Or initialize with custom container
 * const themeToggle = new ThemeToggle(document.querySelector('.my-theme-toggle'));
 *
 * // Programmatically set theme
 * themeToggle.setTheme('dark');
 *
 * // Get current theme
 * const current = themeToggle.getTheme(); // 'light', 'dark', or 'system'
 *
 * // Destroy when done
 * themeToggle.destroy();
 */
class ThemeToggle {
    /**
     * Create a new ThemeToggle instance
     *
     * @param {HTMLElement} container - Optional container element (default: .theme-toggle)
     */
    constructor(container) {
        // Constants
        this.STORAGE_KEY = 'bfluxco-theme';
        this.VALID_THEMES = ['light', 'dark', 'system'];

        // Find container
        this.container = container || document.querySelector('.theme-toggle');

        if (!this.container) {
            return;
        }

        // Get buttons
        this.buttons = this.container.querySelectorAll('.theme-toggle-btn');

        if (this.buttons.length === 0) {
            return;
        }

        // Bind methods
        this._handleButtonClick = this._handleButtonClick.bind(this);
        this._handleSystemChange = this._handleSystemChange.bind(this);

        // Initialize
        this._init();
    }

    /**
     * Initialize the theme toggle
     * @private
     */
    _init() {
        // Set up button click handlers
        var self = this;
        this.buttons.forEach(function(btn) {
            btn.addEventListener('click', self._handleButtonClick);
        });

        // Listen for system theme changes
        this.mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
        this.mediaQuery.addEventListener('change', this._handleSystemChange);

        // Apply saved theme or default to system
        this._applyInitialTheme();
    }

    /**
     * Get the current effective theme based on system preference
     *
     * @returns {string} 'dark' or 'light'
     */
    getSystemTheme() {
        return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    }

    /**
     * Get the current saved theme preference
     *
     * @returns {string} 'light', 'dark', or 'system'
     */
    getTheme() {
        var saved = localStorage.getItem(this.STORAGE_KEY);
        return this.VALID_THEMES.indexOf(saved) !== -1 ? saved : 'system';
    }

    /**
     * Set the theme
     *
     * @param {string} theme - 'light', 'dark', or 'system'
     */
    setTheme(theme) {
        // Validate theme value
        if (this.VALID_THEMES.indexOf(theme) === -1) {
            console.warn('ThemeToggle: Invalid theme value:', theme);
            return;
        }

        // Save to localStorage
        localStorage.setItem(this.STORAGE_KEY, theme);

        // Apply theme to document
        this._applyTheme(theme);

        // Update button states
        this._updateButtons(theme);
    }

    /**
     * Apply theme to document
     *
     * @param {string} theme - 'light', 'dark', or 'system'
     * @private
     */
    _applyTheme(theme) {
        var html = document.documentElement;

        if (theme === 'system') {
            // Apply the system preference as data-theme for consistent styling
            var systemTheme = this.getSystemTheme();
            html.setAttribute('data-theme', systemTheme);
        } else {
            // Set explicit theme
            html.setAttribute('data-theme', theme);
        }
    }

    /**
     * Update button active states and aria-checked
     *
     * @param {string} activeTheme - The current theme
     * @private
     */
    _updateButtons(activeTheme) {
        this.buttons.forEach(function(btn) {
            var btnTheme = btn.getAttribute('data-theme');
            var isActive = btnTheme === activeTheme;

            btn.classList.toggle('is-active', isActive);
            btn.setAttribute('aria-checked', isActive ? 'true' : 'false');
        });
    }

    /**
     * Apply initial theme from localStorage or default to system
     * @private
     */
    _applyInitialTheme() {
        var savedTheme = this.getTheme();
        this._applyTheme(savedTheme);
        this._updateButtons(savedTheme);
    }

    /**
     * Handle button click events
     *
     * @param {Event} e - Click event
     * @private
     */
    _handleButtonClick(e) {
        var theme = e.currentTarget.getAttribute('data-theme');
        this.setTheme(theme);
    }

    /**
     * Handle system theme changes (only affects 'system' mode)
     * @private
     */
    _handleSystemChange() {
        var savedTheme = this.getTheme();
        if (savedTheme === 'system') {
            // Re-apply to trigger any necessary updates
            this._applyTheme('system');
        }
    }

    /**
     * Destroy the theme toggle and clean up event listeners
     */
    destroy() {
        var self = this;

        // Remove button listeners
        if (this.buttons) {
            this.buttons.forEach(function(btn) {
                btn.removeEventListener('click', self._handleButtonClick);
            });
        }

        // Remove media query listener
        if (this.mediaQuery) {
            this.mediaQuery.removeEventListener('change', this._handleSystemChange);
        }
    }
}

/**
 * Initialize theme toggle (standalone function for backward compatibility)
 *
 * @returns {ThemeToggle|null} The ThemeToggle instance or null if not found
 */
function initThemeToggle() {
    var instance = new ThemeToggle();
    return instance.container ? instance : null;
}

// Backward compatibility - attach to window.bfluxco
window.bfluxco = window.bfluxco || {};
window.bfluxco.ThemeToggle = ThemeToggle;
window.bfluxco.initThemeToggle = initThemeToggle;
