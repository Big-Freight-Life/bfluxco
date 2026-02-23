# BFLUXCO Interface Specification

> **DO NOT CHANGE** - This document defines interaction design and behavior.
> Reference this when refactoring to ensure nothing breaks.

---

## Table of Contents

1. [Chat Bar Interface](#1-chat-bar-interface)
2. [Mega Menu Navigation](#2-mega-menu-navigation)
3. [Mobile Navigation](#3-mobile-navigation)
4. [Header Scroll Behavior](#4-header-scroll-behavior)
5. [Theme Toggle](#5-theme-toggle)
6. [Case Studies Carousel](#6-case-studies-carousel)
7. [Product Gallery](#7-product-gallery)
8. [Interview Modal](#8-interview-modal)
9. [Video Modal](#9-video-modal)
10. [Orbit Popups](#10-orbit-popups)
11. [Scroll Reveal Animations](#11-scroll-reveal-animations)
12. [Brand Stroke Animation](#12-brand-stroke-animation)

---

## 1. Chat Bar Interface

**Files:** `front-page.php` (lines 74-138), `assets/js/chatbot.js`, `assets/css/partials/_chatbot.css`

### HTML Structure

```
.hero-chat
├── .chat-blur-overlay          (full-screen backdrop)
├── .chat-input-area
│   ├── .chat-messages          (conversation display)
│   ├── .chat-lead-form         (email capture form)
│   ├── .chat-success           (confirmation message)
│   └── .chat-form
│       └── .chat-input-wrapper
│           ├── .chat-input-icon
│           ├── .chat-input     (textarea)
│           ├── .chat-clear-btn
│           ├── .chat-mic-btn
│           └── .chat-voice-toggle
│       └── .chat-close-btn
└── .hero-chat-actions          (CTA buttons)
```

### Theme-Specific Styling

#### Blur Overlay

| Theme | Background | Effect |
|-------|------------|--------|
| Dark | `rgba(0, 0, 0, 0.8)` | Dark frosted glass |
| Light | `rgba(255, 255, 255, 0.7)` | Light frosted glass |

Both themes use `backdrop-filter: blur(20px)`.

#### CTA Buttons (`.hero-chat-actions`)

**Button Order:** Interview Ray, Git In Touch, Transform My Team

**Dark Mode:**

| Button Type | Background | Border | Text Color |
|-------------|------------|--------|------------|
| Primary (`.btn-primary`) | `#2c2c2e` | none | `#d4d4d4` |
| Primary hover | `#3c3c3e` | none | `#d4d4d4` |
| Outline (`.btn-outline`) | `rgba(18, 18, 18, 0.5)` | `1px solid rgba(255, 255, 255, 0.2)` | `#8e8e93` |
| Outline hover | `rgba(18, 18, 18, 0.7)` | `1px solid rgba(255, 255, 255, 0.3)` | `#8e8e93` |

**Light Mode:**

| Button Type | Background | Border | Text Color |
|-------------|------------|--------|------------|
| Primary (`.btn-primary`) | `#ffffff` | `#ffffff` | `#111827` |
| Primary hover | `#ffffff` | `#ffffff` | `#111827` |
| Outline (`.btn-outline`) | `rgba(255, 255, 255, 0.3)` | `#ffffff` | `#111827` |
| Outline hover | `rgba(255, 255, 255, 0.5)` | `#ffffff` | `#111827` |

All buttons use `font-weight: 400`.

### State Classes

| Class | Element | Effect |
|-------|---------|--------|
| `.is-expanded` | `.hero-chat` | Width: 384px → 768px |
| `.is-active` | `.chat-messages` | Shows messages container |
| `.is-active` | `.chat-blur-overlay` | Shows backdrop with blur |
| `.is-active` | `.chat-lead-form` | Shows lead capture form |
| `.is-active` | `.chat-success` | Shows success message |
| `.is-visible` | `.chat-clear-btn` | Shows clear button |
| `.is-visible` | `.chat-close-btn` | Shows close button |
| `.is-listening` | `.chat-mic-btn` | Red color + pulse animation |
| `.is-muted` | `.chat-voice-toggle` | Shows muted icon |
| `.is-scrolling` | `.chat-messages` | Shows scrollbar |
| `.is-speaking` | `.hero-chat` | TTS active pulse |

**Note:** Opening chat does NOT lock page scroll.

### Input Behavior

| Behavior | Details |
|----------|---------|
| Auto-resize | Grows upward (bottom anchored), max 120px height |
| Send | Enter key (without Shift) |
| New line | Shift+Enter |
| Clear button | Appears when text is present |
| Close button | Appears when chat is expanded |
| Placeholder | "Ask me anything..." |
| Caret color | iOS blue (#007AFF) |

### Message Display

| Message Type | Alignment | Background |
|--------------|-----------|------------|
| User | Right | Semi-transparent white |
| Bot | Left (full-width) | Transparent |
| Error | Left | Red text color |

**Bot Message Actions:**
- Copy (clipboard icon)
- Regenerate (refresh icon)
- Like/Dislike (thumbs icons)

**User Message Actions:**
- Edit (pencil icon)

### Typewriter Effect

| Property | Value |
|----------|-------|
| Base delay | 50ms + random variation |
| After period (. ! ?) | +80ms pause |
| After comma | +30ms pause |
| After paragraph | +120ms pause |
| Chunking | Semantic (clause boundaries, max 5 words) |
| Cursor blink | 530ms interval |
| Cursor fade | 0.1s at completion |

### Scrolling Behavior

| Behavior | Details |
|----------|---------|
| Auto-scroll | To bottom (unless user scrolled up) |
| User scroll detection | 100px threshold |
| Jump button | Appears when scrolled up |
| Scrollbar visibility | Hidden default, shows on scroll/hover |
| Top fade | CSS mask gradient (48px) |
| Scroll behavior | `smooth` |

### Voice Input (Web Speech API)

| State | Behavior |
|-------|----------|
| Idle | Mic icon, neutral color |
| Listening | Red color, pulse animation, outer ring pulse |
| Transcribing | Real-time text in input field |
| Auto-submit | After 1.5s silence |

### Voice Output (ElevenLabs TTS)

| State | Behavior |
|-------|----------|
| Enabled | Speaker icon, auto-plays responses |
| Disabled | Muted icon, no audio |
| Speaking | Green pulse animation |

### Lead Capture Flow

1. API returns `handoff: true`
2. Lead form slides in (name, email, message fields)
3. Submit → sends to `/wp-json/bfluxco/v1/lead`
4. Success message replaces form
5. Optional "Schedule a Call" button (if URL configured)

### Keyboard Shortcuts

| Key | Action |
|-----|--------|
| Enter | Send message |
| Shift+Enter | New line in input |
| Escape | Stop streaming OR close chat |

### Animations

| Name | Duration | Purpose |
|------|----------|---------|
| `userMessageIn` | 0.15s | User message slide up + fade |
| `typingFadeIn` | 0.1s | Typing indicator appearance |
| `cursorBlink` | 530ms infinite | Streaming cursor blink |
| `cursorFadeOut` | 0.1s | Cursor fade at completion |
| `wordGroupIn` | 60ms | Word chunk fade in |
| `pulse-mic` | 1.5s infinite | Mic button pulse while listening |
| `pulse-ring` | 1.5s infinite | Outer ring pulse while listening |
| `pulse-speaking` | 1s infinite | Speaker toggle pulse while speaking |
| `errorMessageIn` | 0.14s | Error message appearance |

### API Endpoints

| Endpoint | Method | Purpose |
|----------|--------|---------|
| `/wp-json/bfluxco/v1/chat` | POST | Send message, get AI response |
| `/wp-json/bfluxco/v1/tts` | POST | Text-to-speech audio |
| `/wp-json/bfluxco/v1/lead` | POST | Submit lead capture form |

### LocalStorage

| Key | Value |
|-----|-------|
| `bfluxco_chat_history` | JSON array of `{role, content}` messages |

---

## 2. Mega Menu Navigation

**Files:** `header.php`, `main.js` (lines 239-440), `style.css` (section 5.5)

### Structure

```
.megamenu
├── .megamenu-left (300px)
│   ├── .megamenu-section-title
│   └── .megamenu-nav
│       └── .megamenu-nav-item (multiple)
└── .megamenu-right (flexible)
    └── .megamenu-panel (multiple, one visible)
        ├── .megamenu-image
        ├── .megamenu-title
        ├── .megamenu-desc
        └── .megamenu-cta
```

### Behavior

| Trigger | Action |
|---------|--------|
| Click menu trigger | Toggle menu open/close |
| Hover left-panel item | Cross-fade to corresponding right panel |
| Click outside menu | Close menu |
| Click backdrop | Close menu |
| ESC key | Close menu |
| Tab key | Navigate within menu (focus trapped) |

### State Classes

| Class | Element | Effect |
|-------|---------|--------|
| `.is-open` | `.megamenu` | Menu visible |
| `.is-active` | `.megamenu-nav-item` | Selected item highlight |
| `.is-active` | `.megamenu-panel` | Panel visible |

### Timing

| Property | Value |
|----------|-------|
| Open delay | 180ms (hover intent) |
| Close delay | 150ms (prevents accidental close) |
| Panel transition | CSS cross-fade |

### Responsive

| Breakpoint | Behavior |
|------------|----------|
| >= 1024px | Mega menu visible |
| < 1024px | Hidden (mobile accordion instead) |

---

## 3. Mobile Navigation

**Files:** `template-parts/navigation-mobile.php`, `main.js` (lines 448-547)

### Structure

```
.mobile-nav-drawer
├── .mobile-nav-header
│   └── .mobile-nav-close
├── .mobile-nav-menu
│   └── .mobile-nav-item (multiple)
│       └── .mobile-nav-submenu (accordion)
└── .mobile-nav-cta
```

### Behavior

| Action | Effect |
|--------|--------|
| Click hamburger | Open drawer (full-screen slide) |
| Click menu link | Close drawer + navigate |
| Click accordion header | Expand/collapse submenu |
| ESC key | Close drawer |
| Resize to >= 1024px | Auto-close drawer |

### Scroll Lock

| Property | Value |
|----------|-------|
| Body | `overflow: hidden` |
| iOS fix | Save/restore scroll position |
| Touch | Prevent scroll behind drawer |

### State Management

| State | Implementation |
|-------|----------------|
| Open/closed | `.is-open` class on drawer |
| Accordion expanded | `.is-expanded` class on submenu |
| Focus | Return to trigger on close |
| ARIA | `aria-expanded` tracking |

---

## 4. Header Scroll Behavior

**File:** `main.js` (lines 165-228)

### Behavior

| Scroll Direction | Effect |
|------------------|--------|
| Down | Header hides (translate up) |
| Up | Header shows (translate 0) |
| Near top (< threshold) | Header always visible |

### Implementation

| Property | Value |
|----------|-------|
| Animation | CSS transform + transition |
| Performance | `requestAnimationFrame` |
| CSS variable | `--header-height` (for layout) |
| Debounce | Applied to scroll listener |

---

## 5. Theme Toggle

**Files:** `header.php` (lines 242-268), `main.js` (lines 52-116)

### Options

| Value | Effect |
|-------|--------|
| `light` | Light theme applied |
| `dark` | Dark theme applied |
| `system` | Follows OS preference |

### Implementation

| Property | Value |
|----------|-------|
| Storage | `localStorage` key: `bfluxco-theme` |
| Application | `data-theme` attribute on `<html>` |
| Button state | `aria-checked` attribute |
| System listener | `matchMedia('prefers-color-scheme')` |

---

## 6. Case Studies Carousel

**Files:** `front-page.php`, `main.js` (lines 555-612)

### Behavior

| Action | Effect |
|--------|--------|
| Click prev button | Scroll left by card width + gap |
| Click next button | Scroll right by card width + gap |
| Arrow keys (focused) | Navigate left/right |
| Touch drag | Native momentum scroll |

### Implementation

| Property | Value |
|----------|-------|
| Scroll | `scrollBy()` with `behavior: 'smooth'` |
| Scroll amount | Dynamic (card width + gap) |
| Touch | CSS `-webkit-overflow-scrolling: touch` |
| Initial position | First card visible |

---

## 7. Product Gallery

**File:** `main.js` (lines 1142-1253)

### Behavior

| Action | Effect |
|--------|--------|
| Click thumbnail | Show corresponding main image |
| Arrow keys | Navigate through images (wraps) |
| Touch swipe | Change image (horizontal, 50px threshold) |

### State

| Property | Implementation |
|----------|----------------|
| Current index | JavaScript variable |
| Active thumbnail | `.is-active` class |
| Active image | `.is-active` class |
| ARIA | `aria-selected` on thumbnails |
| Focus | `tabindex` management |

---

## 8. Interview Modal

**Files:** `front-page.php` (lines 391-418), `main.js` (lines 953-1022)

### Behavior

| Action | Effect |
|--------|--------|
| Click "Interview Ray" button | Open modal |
| Click close button | Close modal |
| Click backdrop | Close modal |
| Press ESC | Close modal |
| Submit code | Redirect to interview URL |

### Focus Management

| Event | Focus Target |
|-------|--------------|
| Open | Auto-focus to input field |
| Close | Return focus to trigger button |
| Clear | Input cleared on close |

### ARIA

| Property | Value |
|----------|-------|
| Modal | `aria-modal="true"` |
| Role | `role="dialog"` |

---

## 9. Video Modal

**File:** `main.js` (lines 1293-1343)

### Behavior

| Action | Effect |
|--------|--------|
| Click `.video-play-btn` | Open modal with YouTube iframe |
| Click close button | Close modal, remove iframe |
| Click backdrop | Close modal |
| Press ESC | Close modal |

### YouTube Parameters

```
?autoplay=1&rel=0&modestbranding=1&controls=1&showinfo=0
```

### Body Lock

| State | Effect |
|-------|--------|
| Open | `body { overflow: hidden }` |
| Close | `body { overflow: auto }` |

---

## 10. Orbit Popups

**Files:** `front-page.php` (lines 174-227), `main.js` (lines 1076-1134)

### Structure

```
.orbit-legend
└── .orbit-legend-item[data-orbit="id"]

.orbit-popup#orbit-popup-{id}
├── .orbit-popup-close
└── .orbit-popup-content
```

### Behavior

| Action | Effect |
|--------|--------|
| Click legend item | Toggle corresponding popup |
| Click same item again | Close popup |
| Click different item | Switch to new popup |
| Click close button | Close popup |
| Click outside | Close popup |
| Press ESC | Close popup |

### Constraint

Only one popup can be active at a time.

---

## 11. Scroll Reveal Animations

**File:** `main.js` (lines 624-676)

### Selectors

```css
.reveal
.reveal-up
.reveal-fade
.reveal-scale
.reveal-hero
.reveal-text
.section-reveal
.reveal-lines
```

### IntersectionObserver Config

| Property | Value |
|----------|-------|
| Threshold | 0.15 (15% visible) |
| Root margin | `0px 0px -80px 0px` |
| Trigger | One-time (unobserve after) |

### Motion Preference

| Setting | Behavior |
|---------|----------|
| Default | Animations play |
| `prefers-reduced-motion: reduce` | Animations disabled |

### State

| Class | Effect |
|-------|--------|
| `.is-visible` | Triggers CSS animation |

---

## 12. Brand Stroke Animation

**File:** `main.js` (lines 768-810)

### Element

`.footer-brand-large`

### Trigger

IntersectionObserver at 30% visibility

### Animation

| Property | Value |
|----------|-------|
| Duration | 3 seconds |
| Type | SVG stroke draw |

### State Classes

| Class | Timing | Effect |
|-------|--------|--------|
| `.animate` | On trigger | Starts animation |
| `.animate-complete` | After 3s | Animation finished |

---

## Utility Functions

### JavaScript Utilities (main.js)

| Function | Purpose |
|----------|---------|
| `debounce(func, wait)` | Delay function execution |
| `throttle(func, limit)` | Limit function execution frequency |
| `escapeHtml(text)` | XSS protection |

### Chatbot Utilities (chatbot.js)

| Function | Purpose |
|----------|---------|
| `parseSemanticChunks(text)` | Break text at clause boundaries |
| `calculateChunkDelay(chunk)` | Natural timing for typewriter |
| `autoResizeInput()` | Textarea height adjustment |
| `scrollToBottom(force)` | Smart scroll management |

---

## Accessibility Requirements

### ARIA Attributes (Preserve)

| Element | Attributes |
|---------|------------|
| Chat messages | `role="log"`, `aria-live="polite"` |
| Modals | `role="dialog"`, `aria-modal="true"` |
| Menus | `role="navigation"`, `aria-expanded` |
| Tabs | `aria-selected` |
| Toggles | `aria-checked` |
| Buttons | `aria-label` |

### Keyboard Navigation (Required)

| Component | Keys |
|-----------|------|
| All focusable | Tab navigation |
| Modals | ESC to close, focus trap |
| Menus | ESC to close, arrow keys |
| Carousel | Arrow keys |
| Gallery | Arrow keys |

### Motion (Respect)

```css
@media (prefers-reduced-motion: reduce) {
  /* Disable animations */
}
```

---

## Version

| Field | Value |
|-------|-------|
| Created | December 2025 |
| Last Updated | December 2025 |
| Purpose | Refactoring reference |
