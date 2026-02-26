/**
 * BFLUXCO Main JavaScript
 *
 * This file contains the main JavaScript functionality for the theme.
 *
 * PRO TIP: This JavaScript handles interactive features like
 * smooth scrolling, animations, and dynamic content loading.
 *
 * @package BFLUXCO
 */

(function() {
    'use strict';

    /**
     * DOM Ready Handler
     *
     * This code runs after the page has finished loading.
     */
    document.addEventListener('DOMContentLoaded', function() {

        // Initialize all components
        initThemeToggle();
        initSmoothScroll();
        initScrollAnimations();
        initHidingHeader();
        initMegaMenu();
        initMobileNav();
        initMobileTabBar();
        initCaseCarousel();
        initFilterButtons();
        initLazyLoading();
        initBrandStrokeAnimation();

    });

    /**
     * Theme Toggle
     *
     * Handles light/dark/system theme switching with localStorage persistence.
     * Supports three modes: light, dark, and system (follows OS preference).
     */
    function initThemeToggle() {
        const toggle = document.querySelector('.theme-toggle');
        if (!toggle) return;

        const buttons = toggle.querySelectorAll('.theme-toggle-btn');
        const STORAGE_KEY = 'bfluxco-theme';

        // Get the current effective theme based on system preference
        function getSystemTheme() {
            return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        }

        // Apply theme to document
        function applyTheme(theme) {
            const html = document.documentElement;

            if (theme === 'system') {
                // Remove data-theme to let CSS media query handle it
                html.removeAttribute('data-theme');
            } else {
                // Set explicit theme
                html.setAttribute('data-theme', theme);
            }
        }

        // Update button states
        function updateButtons(activeTheme) {
            buttons.forEach(function(btn) {
                const btnTheme = btn.getAttribute('data-theme');
                const isActive = btnTheme === activeTheme;

                btn.classList.toggle('is-active', isActive);
                btn.setAttribute('aria-checked', isActive ? 'true' : 'false');
            });
        }

        // Initialize theme from localStorage or default to system
        function initTheme() {
            const savedTheme = localStorage.getItem(STORAGE_KEY) || 'system';
            applyTheme(savedTheme);
            updateButtons(savedTheme);
        }

        // Handle button clicks
        buttons.forEach(function(btn) {
            btn.addEventListener('click', function() {
                const theme = this.getAttribute('data-theme');
                localStorage.setItem(STORAGE_KEY, theme);
                applyTheme(theme);
                updateButtons(theme);
            });
        });

        // Listen for system theme changes (only affects 'system' mode)
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function() {
            const savedTheme = localStorage.getItem(STORAGE_KEY) || 'system';
            if (savedTheme === 'system') {
                // Re-apply to trigger any necessary updates
                applyTheme('system');
            }
        });

        // Initialize on load
        initTheme();
    }

    /**
     * Smooth Scroll for Anchor Links
     *
     * Makes clicking on anchor links (#section) scroll smoothly
     * instead of jumping instantly.
     */
    function initSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');

                // Skip if it's just "#" or if target doesn't exist
                if (href === '#' || href === '#!') {
                    return;
                }

                const target = document.querySelector(href);

                if (target) {
                    e.preventDefault();

                    // Get header height for offset
                    const header = document.querySelector('.site-header');
                    const headerHeight = header ? header.offsetHeight : 0;

                    // Calculate scroll position
                    const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - headerHeight - 20;

                    // Smooth scroll to target
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });

                    // Update URL without jumping
                    history.pushState(null, null, href);
                }
            });
        });
    }

    /**
     * Hiding Header on Scroll
     *
     * Header hides when scrolling down, shows when scrolling up.
     * Uses smooth transitions for a polished feel.
     */
    function initHidingHeader() {
        const header = document.querySelector('.site-header');
        if (!header) return;

        let lastScrollY = window.scrollY;
        let ticking = false;

        // Get header height for offset
        const headerHeight = header.offsetHeight;

        function updateHeader() {
            const currentScrollY = window.scrollY;

            // Add/remove scrolled state class (for background color change)
            if (currentScrollY > 0) {
                header.classList.add('is-scrolled');
            } else {
                header.classList.remove('is-scrolled');
            }

            // Don't hide if near top of page
            if (currentScrollY < headerHeight) {
                header.classList.remove('header-hidden');
                lastScrollY = currentScrollY;
                ticking = false;
                return;
            }

            // Scrolling down - hide header
            if (currentScrollY > lastScrollY) {
                header.classList.add('header-hidden');
            }
            // Scrolling up - show header
            else {
                header.classList.remove('header-hidden');
            }

            lastScrollY = currentScrollY;
            ticking = false;
        }

        window.addEventListener('scroll', function() {
            if (!ticking) {
                requestAnimationFrame(updateHeader);
                ticking = true;
            }
        }, { passive: true });
    }

    /**
     * Mega Menu (Click-based)
     *
     * Clean, stable navigation with:
     * - Click to open/close (toggle)
     * - Click outside to close
     * - Panel switching on hover
     * - Keyboard accessibility (ESC to close)
     */
    function initMegaMenu() {
        const menuTriggers = document.querySelectorAll('.menu-item.has-megamenu');
        const megamenus = document.querySelectorAll('.megamenu');
        const header = document.querySelector('.site-header');

        if (menuTriggers.length === 0 || megamenus.length === 0) return;

        // State
        let activeMenu = null;

        // Get megamenu by ID
        function getMegamenu(menuType) {
            return document.getElementById('megamenu-' + menuType);
        }

        // Open a specific megamenu
        function openMenu(menuType) {
            const megamenu = getMegamenu(menuType);
            if (!megamenu) return;

            // Close other menus first
            megamenus.forEach(function(menu) {
                if (menu !== megamenu) {
                    menu.classList.remove('is-open');
                }
            });

            // Deactivate other triggers
            menuTriggers.forEach(function(trigger) {
                if (trigger.dataset.megamenu !== menuType) {
                    trigger.classList.remove('is-active');
                }
            });

            // Activate current trigger and menu
            const trigger = document.querySelector('[data-megamenu="' + menuType + '"]');
            if (trigger) trigger.classList.add('is-active');

            megamenu.classList.add('is-open');
            activeMenu = menuType;

            // Prevent header from hiding while menu is open
            if (header) header.classList.remove('header-hidden');
        }

        // Close all megamenus
        function closeAllMenus() {
            megamenus.forEach(function(menu) {
                menu.classList.remove('is-open');
            });

            menuTriggers.forEach(function(trigger) {
                trigger.classList.remove('is-active');
            });

            activeMenu = null;
        }

        // Toggle menu
        function toggleMenu(menuType) {
            if (activeMenu === menuType) {
                closeAllMenus();
            } else {
                openMenu(menuType);
            }
        }

        // Handle panel switching in left navigation (hover-based)
        function initPanelSwitching(megamenu) {
            const navItems = megamenu.querySelectorAll('.megamenu-nav-item');
            const panels = megamenu.querySelectorAll('.megamenu-panel');

            navItems.forEach(function(item) {
                item.addEventListener('mouseenter', function() {
                    const panelId = this.dataset.panel;

                    // Update active nav item
                    navItems.forEach(function(navItem) {
                        navItem.classList.remove('active');
                    });
                    this.classList.add('active');

                    // Switch panel
                    panels.forEach(function(panel) {
                        if (panel.dataset.panel === panelId) {
                            panel.classList.add('active');
                        } else {
                            panel.classList.remove('active');
                        }
                    });
                });
            });
        }

        // Initialize panel switching for all megamenus
        megamenus.forEach(function(megamenu) {
            initPanelSwitching(megamenu);
        });

        // Click handlers for menu triggers
        menuTriggers.forEach(function(trigger) {
            const link = trigger.querySelector('a');
            if (!link) return;

            link.addEventListener('click', function(e) {
                e.preventDefault();
                const menuType = trigger.dataset.megamenu;
                toggleMenu(menuType);
            });
        });

        // Click on backdrop closes menu
        megamenus.forEach(function(megamenu) {
            const backdrop = megamenu.querySelector('.megamenu-backdrop');
            if (backdrop) {
                backdrop.addEventListener('click', function() {
                    closeAllMenus();
                });
            }
        });

        // Click outside closes menu
        document.addEventListener('click', function(e) {
            if (!activeMenu) return;

            const clickedTrigger = e.target.closest('.menu-item.has-megamenu');
            const clickedMenu = e.target.closest('.megamenu-container');

            if (!clickedTrigger && !clickedMenu) {
                closeAllMenus();
            }
        });

        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            // ESC to close
            if (e.key === 'Escape' && activeMenu) {
                closeAllMenus();
                // Return focus to trigger
                const trigger = document.querySelector('[data-megamenu="' + activeMenu + '"] a');
                if (trigger) trigger.focus();
            }
        });

        // Close when clicking outside
        document.addEventListener('click', function(e) {
            if (!activeMenu) return;

            const clickedTrigger = e.target.closest('.menu-item.has-megamenu');
            const clickedMenu = e.target.closest('.megamenu');

            if (!clickedTrigger && !clickedMenu) {
                closeAllMenus();
            }
        });

        // Handle focus for keyboard users
        menuTriggers.forEach(function(trigger) {
            const link = trigger.querySelector('a');
            if (!link) return;

            link.addEventListener('focus', function() {
                const menuType = trigger.dataset.megamenu;
                openMenu(menuType);
            });
        });

        // Focus trap within megamenu
        megamenus.forEach(function(megamenu) {
            const focusableElements = megamenu.querySelectorAll('a, button, [tabindex]:not([tabindex="-1"])');

            if (focusableElements.length === 0) return;

            const firstFocusable = focusableElements[0];
            const lastFocusable = focusableElements[focusableElements.length - 1];

            megamenu.addEventListener('keydown', function(e) {
                if (e.key !== 'Tab') return;

                if (e.shiftKey) {
                    // Shift + Tab
                    if (document.activeElement === firstFocusable) {
                        // If focus on first element, close menu and go back to trigger
                        e.preventDefault();
                        closeAllMenus();
                    }
                } else {
                    // Tab
                    if (document.activeElement === lastFocusable) {
                        // If focus on last element, close menu
                        e.preventDefault();
                        closeAllMenus();
                    }
                }
            });
        });

        // Touch device handling - tap to toggle
        if ('ontouchstart' in window) {
            menuTriggers.forEach(function(trigger) {
                const link = trigger.querySelector('a');
                if (!link) return;

                link.addEventListener('click', function(e) {
                    const menuType = trigger.dataset.megamenu;

                    if (activeMenu === menuType) {
                        // Menu is open, allow navigation
                        return;
                    }

                    // Menu is closed, open it instead of navigating
                    e.preventDefault();
                    openMenu(menuType);
                });
            });
        }
    }

    /**
     * Mobile Navigation
     *
     * Handles mobile menu toggle and accordion submenus.
     * Full-screen navigation drawer with smooth animations.
     */
    function initMobileNav() {
        const menuToggle = document.querySelector('.menu-toggle');
        const mobileNav = document.querySelector('.mobile-nav');
        const accordionToggles = document.querySelectorAll('.mobile-menu-toggle');

        if (!menuToggle || !mobileNav) return;

        // Toggle mobile menu
        menuToggle.addEventListener('click', function() {
            const isOpen = mobileNav.classList.contains('is-open');

            if (isOpen) {
                closeMobileMenu();
            } else {
                openMobileMenu();
            }
        });

        function openMobileMenu() {
            mobileNav.classList.add('is-open');
            menuToggle.classList.add('is-active');
            menuToggle.setAttribute('aria-expanded', 'true');
            document.body.classList.add('mobile-nav-open');
            document.body.style.overflow = 'hidden';
        }

        function closeMobileMenu() {
            mobileNav.classList.remove('is-open');
            menuToggle.classList.remove('is-active');
            menuToggle.setAttribute('aria-expanded', 'false');
            document.body.classList.remove('mobile-nav-open');
            document.body.style.overflow = '';

            // Close all accordions
            accordionToggles.forEach(function(toggle) {
                const parent = toggle.closest('.mobile-menu-item');
                parent.classList.remove('is-open');
                toggle.setAttribute('aria-expanded', 'false');
            });
        }

        // Accordion toggles
        accordionToggles.forEach(function(toggle) {
            toggle.addEventListener('click', function() {
                const parent = this.closest('.mobile-menu-item');
                const isOpen = parent.classList.contains('is-open');

                if (isOpen) {
                    parent.classList.remove('is-open');
                    this.setAttribute('aria-expanded', 'false');
                } else {
                    parent.classList.add('is-open');
                    this.setAttribute('aria-expanded', 'true');
                }
            });
        });

        // Close on ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && mobileNav.classList.contains('is-open')) {
                closeMobileMenu();
                menuToggle.focus();
            }
        });

        // Close when clicking a link (after navigation)
        mobileNav.querySelectorAll('a').forEach(function(link) {
            link.addEventListener('click', function() {
                // Small delay to allow navigation
                setTimeout(closeMobileMenu, 100);
            });
        });

        // Close on resize to desktop
        window.addEventListener('resize', debounce(function() {
            if (window.innerWidth >= 1024 && mobileNav.classList.contains('is-open')) {
                closeMobileMenu();
            }
        }, 100));
    }

    /**
     * Mobile Tab Bar & Drawer
     *
     * Bottom tab bar with scroll-hide behavior and "More" drawer.
     * Syncs theme toggle with the desktop toggle.
     */
    function initMobileTabBar() {
        var tabBar = document.getElementById('mobile-tab-bar');
        var drawer = document.getElementById('mobile-drawer');
        var backdrop = document.getElementById('mobile-drawer-backdrop');
        var moreBtn = tabBar ? tabBar.querySelector('.mobile-tab-bar__tab--more') : null;

        if (!tabBar) return;

        // --- Scroll hide/show (mirrors header behavior) ---
        var lastScrollY = window.scrollY;
        var scrollTicking = false;

        function updateTabBar() {
            var currentScrollY = window.scrollY;
            var tabBarHeight = tabBar.offsetHeight;

            // Don't hide if drawer is open
            if (document.body.classList.contains('mobile-drawer-open')) {
                tabBar.classList.remove('is-hidden');
                lastScrollY = currentScrollY;
                scrollTicking = false;
                return;
            }

            // Near top — always show
            if (currentScrollY < tabBarHeight) {
                tabBar.classList.remove('is-hidden');
                lastScrollY = currentScrollY;
                scrollTicking = false;
                return;
            }

            // Scrolling down — hide
            if (currentScrollY > lastScrollY + 10) {
                tabBar.classList.add('is-hidden');
            }
            // Scrolling up — show
            else if (currentScrollY < lastScrollY - 5) {
                tabBar.classList.remove('is-hidden');
            }

            lastScrollY = currentScrollY;
            scrollTicking = false;
        }

        var scrollHandler = function() {
            if (!scrollTicking) {
                requestAnimationFrame(updateTabBar);
                scrollTicking = true;
            }
        };

        window.addEventListener('scroll', scrollHandler, { passive: true });

        // --- Drawer toggle ---
        if (!moreBtn || !drawer || !backdrop) return;

        var handle = drawer.querySelector('.mobile-drawer-handle');
        var drawerContent = drawer.querySelector('.mobile-drawer-content');

        // Move drawer and backdrop to document.body to prevent fixed-positioning
        // bugs caused by any ancestor element that has a CSS transform applied.
        document.body.appendChild(backdrop);
        document.body.appendChild(drawer);

        var savedScrollY = 0;

        // Prevent pull-to-refresh and all background scrolling when drawer is open
        function preventScroll(e) {
            // Allow scrolling inside drawer content
            if (drawerContent && drawerContent.contains(e.target)) {
                // Only prevent if at scroll boundaries (prevents pull-to-refresh)
                var st = drawerContent.scrollTop;
                var sh = drawerContent.scrollHeight;
                var ch = drawerContent.clientHeight;
                if (st <= 0 && e.touches[0].clientY > touchStartY) {
                    // At top, pulling down — let swipe-to-close handle it
                    return;
                }
                if (st + ch >= sh && e.touches[0].clientY < touchStartY) {
                    e.preventDefault(); // At bottom, pulling up
                    return;
                }
                return; // Normal scroll inside drawer
            }
            e.preventDefault(); // Block everything else (backdrop, body)
        }

        // Track animation state to prevent race conditions
        var isDismissing = false;
        var isOpening = false;

        function openDrawer() {
            if (isOpening) return;
            isOpening = true;
            savedScrollY = window.scrollY;
            isDismissing = false;

            // Lock body scroll (position:fixed approach prevents iOS rubber-band scroll)
            document.body.style.overflow = 'hidden';
            document.body.style.position = 'fixed';
            document.body.style.width = '100%';
            document.body.style.top = '-' + savedScrollY + 'px';
            document.body.style.touchAction = 'none';
            document.body.style.overscrollBehavior = 'none';

            // Clear any leftover inline styles from a previous drag so the
            // CSS default translate3d(0,110%,0) is in effect before we animate.
            drawer.style.transform = '';
            drawer.style.transition = '';
            backdrop.style.opacity = '';
            backdrop.style.transition = '';

            // ARIA (set before animation so screen readers announce immediately)
            drawer.setAttribute('aria-hidden', 'false');
            moreBtn.setAttribute('aria-expanded', 'true');

            // Block background touch events
            document.addEventListener('touchmove', preventScroll, { passive: false });

            // Double RAF: first frame paints the closed position; second frame
            // adds the body class which triggers CSS transitions to the open state.
            requestAnimationFrame(function() {
                requestAnimationFrame(function() {
                    document.body.classList.add('mobile-drawer-open');
                    isOpening = false;
                });
            });
        }

        function cleanupDrawerState(returnFocus) {
            // Single source of truth: remove body class
            document.body.classList.remove('mobile-drawer-open');

            drawer.setAttribute('aria-hidden', 'true');
            moreBtn.setAttribute('aria-expanded', 'false');

            // Clear any inline styles left from drag gestures
            drawer.style.transform = '';
            drawer.style.transition = '';
            backdrop.style.opacity = '';
            backdrop.style.transition = '';

            isDismissing = false;
            isOpening = false;

            // Restore scroll
            document.body.style.overflow = '';
            document.body.style.position = '';
            document.body.style.width = '';
            document.body.style.top = '';
            document.body.style.touchAction = '';
            document.body.style.overscrollBehavior = '';
            window.scrollTo(0, savedScrollY);

            // Remove touch block
            document.removeEventListener('touchmove', preventScroll);

            // Only refocus More button for keyboard dismissals
            if (returnFocus) {
                moreBtn.focus();
            } else {
                document.activeElement && document.activeElement.blur();
            }
        }

        function closeDrawer(returnFocus) {
            if (isDismissing) return; // Already animating out
            if (!document.body.classList.contains('mobile-drawer-open')) return;

            isDismissing = true;

            // Remove body class — CSS transitions animate drawer to translate3d(0,110%,0)
            // and backdrop to opacity:0 automatically.
            document.body.classList.remove('mobile-drawer-open');

            // Finalize ONLY after transform animation completes (no setTimeout)
            function onTransitionDone(e) {
                if (e.propertyName !== 'transform') return;
                drawer.removeEventListener('transitionend', onTransitionDone);
                cleanupDrawerState(returnFocus);
            }
            drawer.addEventListener('transitionend', onTransitionDone);
        }

        moreBtn.addEventListener('click', function() {
            if (document.body.classList.contains('mobile-drawer-open') || isOpening) {
                closeDrawer();
            } else {
                openDrawer();
            }
        });

        // --- Tap handle bar to close ---
        if (handle) {
            handle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                if (document.body.classList.contains('mobile-drawer-open')) {
                    closeDrawer();
                }
            });
            handle.style.cursor = 'pointer';
        }

        // Prevent click-through from inside drawer to backdrop/background
        drawer.addEventListener('click', function(e) {
            e.stopPropagation();
        });

        // --- iOS-style swipe-to-close gesture ---
        var touchStartY = 0;
        var touchCurrentY = 0;
        var isDragging = false;
        var dragThreshold = 80; // px to trigger close
        var drawerHeight = 0;

        function onTouchStart(e) {
            if (!document.body.classList.contains('mobile-drawer-open') || isDismissing || isOpening) return;

            // Only allow drag from the handle area or when drawer content is scrolled to top
            var target = e.target;
            var isHandle = handle && handle.contains(target);
            var isScrolledToTop = !drawerContent || drawerContent.scrollTop <= 0;

            if (!isHandle && !isScrolledToTop) return;

            touchStartY = e.touches[0].clientY;
            touchCurrentY = touchStartY;
            isDragging = true;
            drawerHeight = drawer.offsetHeight;

            // Disable CSS transition during drag for immediate response
            drawer.style.transition = 'none';
            backdrop.style.transition = 'none';
        }

        function onTouchMove(e) {
            if (!isDragging) return;

            touchCurrentY = e.touches[0].clientY;
            var deltaY = touchCurrentY - touchStartY;

            // Only allow downward drag (positive deltaY)
            if (deltaY < 0) {
                deltaY = 0;
            }

            // Apply rubber-band resistance at the top
            drawer.style.transform = 'translate3d(0,' + deltaY + 'px,0)';

            // Fade scrim proportionally
            var progress = Math.min(deltaY / drawerHeight, 1);
            backdrop.style.opacity = 1 - progress;

            // Prevent page scroll while dragging
            if (deltaY > 0) {
                e.preventDefault();
            }
        }

        function onTouchEnd() {
            if (!isDragging) return;
            isDragging = false;

            var deltaY = touchCurrentY - touchStartY;

            // Restore transitions with canonical timing values
            drawer.style.transition = 'transform 360ms cubic-bezier(0.22, 1, 0.36, 1)';
            backdrop.style.transition = 'opacity 220ms ease';

            if (deltaY > dragThreshold) {
                // Dismiss: animate to fully offscreen, then clean up
                isDismissing = true;
                drawer.style.transform = 'translate3d(0,110%,0)';
                backdrop.style.opacity = '0';

                // Finalize ONLY after transform animation completes (no setTimeout)
                function onDragDismissDone(e) {
                    if (e.propertyName !== 'transform') return;
                    drawer.removeEventListener('transitionend', onDragDismissDone);
                    cleanupDrawerState();
                }
                drawer.addEventListener('transitionend', onDragDismissDone);
            } else {
                // Snap back to open position
                drawer.style.transform = 'translate3d(0,0,0)';
                backdrop.style.opacity = '1';

                // After snap animation settles, clear inline styles so CSS
                // class rules are the authoritative source of truth again.
                function onSnapBackDone(e) {
                    if (e.propertyName !== 'transform') return;
                    drawer.removeEventListener('transitionend', onSnapBackDone);
                    drawer.style.transform = '';
                    drawer.style.transition = '';
                    backdrop.style.opacity = '';
                    backdrop.style.transition = '';
                }
                drawer.addEventListener('transitionend', onSnapBackDone);
            }
        }

        drawer.addEventListener('touchstart', onTouchStart, { passive: true });
        drawer.addEventListener('touchmove', onTouchMove, { passive: false });
        drawer.addEventListener('touchend', onTouchEnd, { passive: true });

        // Close on backdrop click
        backdrop.addEventListener('click', function() { closeDrawer(); });

        // Close on ESC (keyboard — return focus to More button)
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && document.body.classList.contains('mobile-drawer-open')) {
                closeDrawer(true);
            }
        });

        // Close on link click within drawer
        drawer.querySelectorAll('a').forEach(function(link) {
            link.addEventListener('click', function() {
                setTimeout(closeDrawer, 100);
            });
        });

        // Close on resize to desktop
        window.addEventListener('resize', debounce(function() {
            if (window.innerWidth >= 1024 && document.body.classList.contains('mobile-drawer-open')) {
                closeDrawer();
            }
        }, 100));

        // --- Cleanup on page unload (Fix 1 & 2) ---
        // Close drawer and remove scroll listener when navigating away
        window.addEventListener('beforeunload', function() {
            cleanupDrawerState();
            window.removeEventListener('scroll', scrollHandler);
        });

        // Close drawer when page becomes hidden (e.g. tab switch, navigation)
        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                cleanupDrawerState();
            }
        });

        // --- Focus trap in drawer (Fix 4) ---
        drawer.addEventListener('keydown', function(e) {
            if (e.key !== 'Tab') return;
            if (!document.body.classList.contains('mobile-drawer-open')) return;

            var focusableEls = drawer.querySelectorAll('a, button, [tabindex]:not([tabindex="-1"])');
            if (focusableEls.length === 0) return;

            var firstEl = focusableEls[0];
            var lastEl = focusableEls[focusableEls.length - 1];

            if (e.shiftKey) {
                // Shift+Tab: if on first element, wrap to last
                if (document.activeElement === firstEl) {
                    e.preventDefault();
                    lastEl.focus();
                }
            } else {
                // Tab: if on last element, wrap to first
                if (document.activeElement === lastEl) {
                    e.preventDefault();
                    firstEl.focus();
                }
            }
        });

        // --- Mobile Theme Toggle (sync with desktop) ---
        var mobileToggle = drawer.querySelector('.mobile-theme-toggle');
        if (mobileToggle) {
            var mobileButtons = mobileToggle.querySelectorAll('.mobile-theme-toggle-btn');
            var desktopButtons = document.querySelectorAll('.theme-toggle .theme-toggle-btn');
            var STORAGE_KEY = 'bfluxco-theme';

            function applyTheme(theme) {
                var html = document.documentElement;
                if (theme === 'system') {
                    html.removeAttribute('data-theme');
                } else {
                    html.setAttribute('data-theme', theme);
                }
            }

            function updateAllToggleButtons(activeTheme) {
                // Update mobile buttons
                mobileButtons.forEach(function(btn) {
                    var btnTheme = btn.getAttribute('data-theme');
                    var isActive = btnTheme === activeTheme;
                    btn.classList.toggle('is-active', isActive);
                    btn.setAttribute('aria-checked', isActive ? 'true' : 'false');
                });
                // Update desktop buttons (keep in sync)
                desktopButtons.forEach(function(btn) {
                    var btnTheme = btn.getAttribute('data-theme');
                    var isActive = btnTheme === activeTheme;
                    btn.classList.toggle('is-active', isActive);
                    btn.setAttribute('aria-checked', isActive ? 'true' : 'false');
                });
            }

            // Initialize mobile toggle state
            var savedTheme = localStorage.getItem(STORAGE_KEY) || 'system';
            updateAllToggleButtons(savedTheme);

            // Handle mobile toggle clicks
            mobileButtons.forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var theme = this.getAttribute('data-theme');
                    localStorage.setItem(STORAGE_KEY, theme);
                    applyTheme(theme);
                    updateAllToggleButtons(theme);
                });
            });
        } // end if (mobileToggle)
    }

    /**
     * Case Studies Carousel
     *
     * Editorial, calm, intelligent.
     * Horizontal scroll with arrow and keyboard navigation.
     */
    function initCaseCarousel() {
        const carousel = document.querySelector('.case-carousel');
        const prevBtn = document.querySelector('.carousel-prev');
        const nextBtn = document.querySelector('.carousel-next');

        if (!carousel) return;

        // Get card width for scroll amount
        const getScrollAmount = function() {
            const card = carousel.querySelector('.case-card');
            if (card) {
                return card.offsetWidth + 24; // Card width + gap
            }
            return 450;
        };

        // Center the second card on load (desktop only)
        if (window.innerWidth >= 1024) {
            var cards = carousel.querySelectorAll('.case-card');
            if (cards.length >= 2) {
                var secondCard = cards[1];
                var cardCenter = secondCard.offsetLeft + (secondCard.offsetWidth / 2);
                var viewportCenter = carousel.offsetWidth / 2;
                var scrollToCenter = cardCenter - viewportCenter;
                carousel.scrollLeft = Math.max(0, scrollToCenter);
            }
        }

        // Scroll functions
        const scrollPrev = function() {
            carousel.scrollBy({
                left: -getScrollAmount(),
                behavior: 'smooth'
            });
        };

        const scrollNext = function() {
            carousel.scrollBy({
                left: getScrollAmount(),
                behavior: 'smooth'
            });
        };

        // Button navigation
        if (prevBtn) {
            prevBtn.addEventListener('click', scrollPrev);
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', scrollNext);
        }

        // Keyboard navigation when carousel is focused
        carousel.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowLeft') {
                e.preventDefault();
                scrollPrev();
            } else if (e.key === 'ArrowRight') {
                e.preventDefault();
                scrollNext();
            }
        });

        // Mouse drag to scroll
        var isDown = false;
        var startX;
        var scrollLeft;

        carousel.addEventListener('mousedown', function(e) {
            isDown = true;
            carousel.style.cursor = 'grabbing';
            startX = e.pageX - carousel.offsetLeft;
            scrollLeft = carousel.scrollLeft;
        });

        carousel.addEventListener('mouseleave', function() {
            isDown = false;
            carousel.style.cursor = 'grab';
        });

        carousel.addEventListener('mouseup', function() {
            isDown = false;
            carousel.style.cursor = 'grab';
        });

        carousel.addEventListener('mousemove', function(e) {
            if (!isDown) return;
            e.preventDefault();
            var x = e.pageX - carousel.offsetLeft;
            var walk = (x - startX) * 1.5; // Scroll speed multiplier
            carousel.scrollLeft = scrollLeft - walk;
        });

        // Set initial cursor style
        carousel.style.cursor = 'grab';
    }

    /**
     * Scroll Reveal System (Antigravity-Inspired)
     *
     * Motion is structural. Slowness is intentional.
     * One idea per moment. The user should always know where to look.
     *
     * Uses IntersectionObserver for performant scroll-triggered reveals.
     * Elements with .reveal, .reveal-up, .reveal-hero, etc. are revealed
     * when they enter the viewport.
     */
    function initScrollAnimations() {
        // Check if IntersectionObserver is supported
        if (!('IntersectionObserver' in window)) {
            // Fallback: show all elements immediately
            document.querySelectorAll('.reveal, .reveal-up, .reveal-fade, .reveal-scale, .reveal-hero, .reveal-text, .section-reveal, .reveal-lines').forEach(function(el) {
                el.classList.add('is-visible');
            });
            return;
        }

        // Respect user's motion preferences
        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        if (prefersReducedMotion) {
            document.querySelectorAll('.reveal, .reveal-up, .reveal-fade, .reveal-scale, .reveal-hero, .reveal-text, .section-reveal, .reveal-lines').forEach(function(el) {
                el.classList.add('is-visible');
            });
            return;
        }

        // Select all reveal elements
        const revealElements = document.querySelectorAll('.reveal, .reveal-up, .reveal-fade, .reveal-scale, .reveal-hero, .reveal-text, .section-reveal, .reveal-lines');

        if (revealElements.length === 0) {
            return;
        }

        // Create observer with settings for smooth, deliberate reveals
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    // Add visible class to trigger CSS transition
                    entry.target.classList.add('is-visible');

                    // Stop observing after reveal (one-time animation)
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.15,  // Trigger when 15% visible (more deliberate)
            rootMargin: '0px 0px -80px 0px'  // Offset for better timing
        });

        // Observe all reveal elements
        revealElements.forEach(function(el) {
            observer.observe(el);
        });

        // Also support legacy class for backwards compatibility
        const legacyElements = document.querySelectorAll('.animate-on-scroll');
        legacyElements.forEach(function(el) {
            observer.observe(el);
        });
    }

    /**
     * Filter Buttons
     *
     * Handles filtering of items (like case studies by industry).
     */
    function initFilterButtons() {
        const filterButtons = document.querySelectorAll('.filter-btn');

        if (filterButtons.length === 0) {
            return;
        }

        filterButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                const filter = this.dataset.filter;

                // Update active button
                filterButtons.forEach(function(btn) {
                    btn.classList.remove('active');
                    btn.classList.remove('btn-primary');
                    btn.classList.add('btn-secondary');
                });

                this.classList.add('active');
                this.classList.remove('btn-secondary');
                this.classList.add('btn-primary');

                // Filter items
                const items = document.querySelectorAll('[data-industry]');

                items.forEach(function(item) {
                    if (filter === 'all') {
                        item.style.display = '';
                    } else {
                        const industries = item.dataset.industry.split(' ');
                        if (industries.includes(filter)) {
                            item.style.display = '';
                        } else {
                            item.style.display = 'none';
                        }
                    }
                });
            });
        });
    }

    /**
     * Lazy Loading for Images
     *
     * Defers loading of images until they're needed.
     * Uses native lazy loading with a JavaScript fallback.
     */
    function initLazyLoading() {
        // Check for native lazy loading support
        if ('loading' in HTMLImageElement.prototype) {
            // Browser supports native lazy loading
            document.querySelectorAll('img.lazy').forEach(function(img) {
                img.src = img.dataset.src;
                img.classList.remove('lazy');
            });
        } else {
            // Fallback for older browsers
            if ('IntersectionObserver' in window) {
                const lazyImages = document.querySelectorAll('img.lazy');

                const imageObserver = new IntersectionObserver(function(entries) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            img.src = img.dataset.src;
                            img.classList.remove('lazy');
                            imageObserver.unobserve(img);
                        }
                    });
                });

                lazyImages.forEach(function(img) {
                    imageObserver.observe(img);
                });
            }
        }
    }

    /**
     * Brand Stroke Draw Animation
     *
     * Animates the "Big Freight Life" text in the footer
     * by drawing the stroke when it comes into view.
     * Uses IntersectionObserver for performance.
     */
    function initBrandStrokeAnimation() {
        const brandElement = document.querySelector('.footer-brand-large');

        if (!brandElement) return;

        // Check if IntersectionObserver is supported
        if (!('IntersectionObserver' in window)) {
            // Fallback: just show the text
            brandElement.classList.add('animate');
            return;
        }

        // Respect user's motion preferences
        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        if (prefersReducedMotion) {
            brandElement.classList.add('animate');
            brandElement.classList.add('animate-complete');
            return;
        }

        // Create observer to trigger animation when element comes into view
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    // Start the animation
                    brandElement.classList.add('animate');

                    // Add complete class after animation finishes
                    setTimeout(function() {
                        brandElement.classList.add('animate-complete');
                    }, 3000); // Match animation duration

                    // Stop observing after animation triggered
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.3,  // Trigger when 30% visible
            rootMargin: '0px 0px -50px 0px'
        });

        observer.observe(brandElement);
    }

    /**
     * Utility: Debounce Function
     *
     * Limits how often a function can be called.
     * Useful for scroll and resize handlers.
     *
     * @param {Function} func - The function to debounce
     * @param {number} wait - Milliseconds to wait
     * @returns {Function}
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
     * Utility: Throttle Function
     *
     * Ensures a function is called at most once per time period.
     *
     * @param {Function} func - The function to throttle
     * @param {number} limit - Milliseconds between calls
     * @returns {Function}
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

    // Expose utility functions globally if needed
    window.bfluxco = window.bfluxco || {};
    window.bfluxco.debounce = debounce;
    window.bfluxco.throttle = throttle;

})();
