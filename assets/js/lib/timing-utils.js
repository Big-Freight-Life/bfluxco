/**
 * BFLUXCO Timing Utilities
 *
 * Provides debounce and throttle functions for performance optimization.
 * Can be used as ES6 modules or via window.bfluxco for backward compatibility.
 *
 * @package BFLUXCO
 */

/**
 * Debounce Function
 *
 * Limits how often a function can be called by waiting for a pause in invocations.
 * Useful for resize and input handlers where you want to wait until the user
 * has stopped their action.
 *
 * @param {Function} func - The function to debounce
 * @param {number} wait - Milliseconds to wait after last invocation
 * @returns {Function} The debounced function
 *
 * @example
 * // Wait 100ms after user stops resizing before handling
 * window.addEventListener('resize', debounce(handleResize, 100));
 */
function debounce(func, wait) {
    var timeout;
    return function() {
        var context = this;
        var args = arguments;
        clearTimeout(timeout);
        timeout = setTimeout(function() {
            func.apply(context, args);
        }, wait);
    };
}

/**
 * Throttle Function
 *
 * Ensures a function is called at most once per specified time period.
 * Useful for scroll handlers where you want regular updates but not on every frame.
 *
 * @param {Function} func - The function to throttle
 * @param {number} limit - Milliseconds between allowed calls
 * @returns {Function} The throttled function
 *
 * @example
 * // Update at most every 100ms during scroll
 * window.addEventListener('scroll', throttle(handleScroll, 100));
 */
function throttle(func, limit) {
    var inThrottle;
    return function() {
        var context = this;
        var args = arguments;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(function() {
                inThrottle = false;
            }, limit);
        }
    };
}

// Backward compatibility - attach to window.bfluxco
window.bfluxco = window.bfluxco || {};
window.bfluxco.debounce = debounce;
window.bfluxco.throttle = throttle;
