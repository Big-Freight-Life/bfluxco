/**
 * BFLUXCO Event Manager
 *
 * A utility class for tracking and managing event listeners.
 * Helps prevent memory leaks by providing a centralized way to
 * add, remove, and clean up all event listeners.
 *
 * @package BFLUXCO
 */

/**
 * EventManager Class
 *
 * Tracks all event listeners and provides methods for cleanup.
 * Particularly useful for components that need to be destroyed
 * without leaving behind orphaned event handlers.
 *
 * @example
 * const events = new EventManager();
 *
 * // Add listeners (automatically tracked)
 * events.on(window, 'resize', handleResize);
 * events.on(document, 'click', handleClick);
 * events.on(button, 'click', handleButtonClick);
 *
 * // Remove a specific listener
 * events.off(window, 'resize', handleResize);
 *
 * // Clean up everything when done
 * events.destroy();
 */
class EventManager {
    constructor() {
        // Store listeners as array of objects for easy cleanup
        this.listeners = [];
    }

    /**
     * Add an event listener and track it for later cleanup
     *
     * @param {EventTarget} target - The DOM element or object to listen on
     * @param {string} event - The event type (e.g., 'click', 'resize')
     * @param {Function} handler - The event handler function
     * @param {Object|boolean} options - Event listener options (passive, capture, etc.)
     * @returns {EventManager} Returns this for chaining
     */
    on(target, event, handler, options) {
        if (!target || !event || !handler) {
            console.warn('EventManager.on: Missing required parameters');
            return this;
        }

        // Add the event listener
        target.addEventListener(event, handler, options);

        // Track it for cleanup
        this.listeners.push({
            target: target,
            event: event,
            handler: handler,
            options: options
        });

        return this;
    }

    /**
     * Remove a specific event listener
     *
     * @param {EventTarget} target - The DOM element or object
     * @param {string} event - The event type
     * @param {Function} handler - The event handler function
     * @returns {EventManager} Returns this for chaining
     */
    off(target, event, handler) {
        // Remove the actual event listener
        target.removeEventListener(event, handler);

        // Remove from tracked listeners
        this.listeners = this.listeners.filter(function(listener) {
            return !(
                listener.target === target &&
                listener.event === event &&
                listener.handler === handler
            );
        });

        return this;
    }

    /**
     * Add a one-time event listener (fires once then removes itself)
     *
     * @param {EventTarget} target - The DOM element or object
     * @param {string} event - The event type
     * @param {Function} handler - The event handler function
     * @param {Object|boolean} options - Event listener options
     * @returns {EventManager} Returns this for chaining
     */
    once(target, event, handler, options) {
        var self = this;

        var wrappedHandler = function(e) {
            handler.call(this, e);
            self.off(target, event, wrappedHandler);
        };

        return this.on(target, event, wrappedHandler, options);
    }

    /**
     * Remove all listeners for a specific target
     *
     * @param {EventTarget} target - The DOM element or object
     * @returns {EventManager} Returns this for chaining
     */
    offAll(target) {
        var self = this;

        // Filter and remove listeners for this target
        this.listeners = this.listeners.filter(function(listener) {
            if (listener.target === target) {
                target.removeEventListener(listener.event, listener.handler, listener.options);
                return false; // Remove from array
            }
            return true; // Keep in array
        });

        return this;
    }

    /**
     * Remove all listeners for a specific event type across all targets
     *
     * @param {string} event - The event type
     * @returns {EventManager} Returns this for chaining
     */
    offEvent(event) {
        this.listeners = this.listeners.filter(function(listener) {
            if (listener.event === event) {
                listener.target.removeEventListener(listener.event, listener.handler, listener.options);
                return false;
            }
            return true;
        });

        return this;
    }

    /**
     * Get the count of tracked listeners
     *
     * @returns {number} The number of active listeners
     */
    count() {
        return this.listeners.length;
    }

    /**
     * Check if a specific listener exists
     *
     * @param {EventTarget} target - The DOM element or object
     * @param {string} event - The event type
     * @param {Function} handler - The event handler function (optional)
     * @returns {boolean} True if the listener exists
     */
    has(target, event, handler) {
        return this.listeners.some(function(listener) {
            var matches = listener.target === target && listener.event === event;
            if (handler) {
                matches = matches && listener.handler === handler;
            }
            return matches;
        });
    }

    /**
     * Remove all tracked event listeners
     * Call this when destroying a component to prevent memory leaks
     *
     * @returns {EventManager} Returns this for chaining
     */
    destroy() {
        // Remove all event listeners
        this.listeners.forEach(function(listener) {
            listener.target.removeEventListener(
                listener.event,
                listener.handler,
                listener.options
            );
        });

        // Clear the array
        this.listeners = [];

        return this;
    }
}

// Backward compatibility - attach to window.bfluxco
window.bfluxco = window.bfluxco || {};
window.bfluxco.EventManager = EventManager;
