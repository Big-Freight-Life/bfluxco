# Mobile-First Redesign Plan

## Status: IN PROGRESS
**Started:** 2026-02-24
**Current Phase:** A — Mobile Navigation Overhaul

---

## Overview

Redesign bflux.co with a mobile-first approach. This document tracks the full plan so work can resume if interrupted.

---

## Phase A: Mobile Navigation Overhaul (CURRENT)

### Goal
Replace the plain hamburger → full-screen drawer navigation with a modern mobile navigation system:
1. **Bottom tab bar** for primary actions (persistent, always visible)
2. **Enhanced slide-up drawer** triggered from a "More" tab for secondary navigation
3. **Theme toggle** accessible from mobile (currently hidden)

### What exists today
- `header.php` — Sticky header with logo, desktop nav, hamburger toggle (lines 78–181)
- `template-parts/navigation-mobile.php` — Exists but is now inlined directly in `header.php` (lines 451–503)
- `assets/css/partials/_header.css` — All mobile nav CSS (lines 346–869)
- `assets/js/main.js` — `initMobileNav()` function (line 438+)
- `footer.php` — Standard footer, no bottom bar

### Design: Bottom Tab Bar

```
┌─────────────────────────────────────────┐
│  [Home]   [Work]   [Blog]   [Contact]  [More] │
│   🏠       💼       📝       ✉️        ≡    │
└─────────────────────────────────────────┘
```

- Fixed to bottom of viewport on mobile only (< 1024px)
- 5 tabs: Home, Work, Blog, Contact, More
- SVG icons (no emoji — using inline SVGs matching existing icon style)
- Active state highlights current section
- "More" opens enhanced drawer with: About, Products, Support, theme toggle, legal links
- Tab bar hides on scroll-down, shows on scroll-up (matches header behavior)
- Safe area inset padding for notched phones

### Files to Create/Modify

| File | Action | Description |
|------|--------|-------------|
| `template-parts/mobile-tab-bar.php` | **CREATE** | Bottom tab bar HTML |
| `template-parts/mobile-drawer.php` | **CREATE** | Enhanced "More" drawer content |
| `assets/css/partials/_mobile-tab-bar.css` | **CREATE** | Tab bar + drawer styles |
| `footer.php` | **MODIFY** | Include tab bar before `wp_footer()` |
| `header.php` | **MODIFY** | Hide hamburger on mobile when tab bar is active, keep for tablet |
| `assets/css/partials/_header.css` | **MODIFY** | Adjust mobile nav to work as drawer from bottom |
| `assets/js/main.js` | **MODIFY** | Add tab bar JS: active state, drawer toggle, scroll hide/show |
| `style.css` | **MODIFY** | Import new CSS partial |
| `assets/css/partials/_footer.css` | **MODIFY** | Add bottom padding to account for tab bar |

### Implementation Steps

- [x] Step 1: Audit current mobile nav (header.php, CSS, JS)
- [x] Step 2: Create `mobile-tab-bar.php` template part
- [x] Step 3: Create `mobile-drawer.php` template part (replaces old mobile-nav)
- [x] Step 4: Create `_mobile-tab-bar.css` with all styles
- [x] Step 5: Modify `footer.php` to include tab bar
- [x] Step 6: Modify `_header.css` — hide hamburger below 1024px (tab bar replaces it)
- [x] Step 7: Add `initMobileTabBar()` in `main.js` (active state, drawer, scroll hide, theme sync)
- [x] Step 8: Import CSS partial in `style.css`
- [x] Step 9: Body bottom padding via CSS (in `_mobile-tab-bar.css`)
- [x] Step 10: Code review — 7 issues found and fixed
- [ ] Step 11: Test across breakpoints (360px, 480px, 768px, 1024px+)

### Key Decisions
- Tab bar only shows on screens < 1024px (same breakpoint where desktop nav appears)
- Drawer replaces the old full-screen mobile nav
- Header hamburger hidden on mobile, tab bar takes over
- Footer gets `padding-bottom` to clear tab bar
- Use CSS `env(safe-area-inset-bottom)` for notch-safe spacing
- Active tab detection via PHP `is_page()` / URL matching
- Theme toggle moves into the "More" drawer

---

## Phase B: Homepage Mobile Redesign (COMPLETE)

### Goal
Optimize the front-page.php hero and sections for mobile.

### Changes Made
- [x] Replace video background with static poster image on mobile (already existed)
- [x] Stack CTA buttons vertically on all mobile (moved from 480px to 767px breakpoint)
- [x] Keep case study carousel (horizontal scroll, image-on-top layout at ≤480px)
- [x] Remove Claude terminal from About Preview section (already existed)
- [x] Reduce section padding on mobile (services, CTA, principles)
- [x] Larger body text on mobile (`font-size-lg` / 1.125rem, line-height 1.7)
- [x] Larger section headings on mobile (`clamp(1.75rem, 4vw, 2.5rem)`)
- [x] Hide "Behind every system..." intro paragraph on mobile
- [x] Better card contrast on mobile (`bg-tertiary` + border)
- [ ] Move AI chat to floating button → bottom sheet pattern (deferred to Phase D)

### Files Modified
| File | Change |
|------|--------|
| `front-page.php` | Added `principles-body--intro` class to first principles paragraph |
| `assets/css/custom.css` | Added Phase B mobile rules in `@media (max-width: 767px)` block, updated 480px hero-description override |

### Status: COMPLETE

---

## Phase C: Performance — Conditional Component Loading (PLANNED)

### Goal
Skip heavy desktop-only features on mobile.

### Planned Changes
- Skip Three.js particle logo enqueue on mobile (`wp_is_mobile()`)
- Skip hero video source tags on mobile
- Lazy-load all images below the fold
- Consider system font stack on mobile (skip Google Fonts)
- Conditional chatbot loading

### Status: NOT STARTED

---

## Phase D: Page-Specific Mobile Redesigns (PLANNED)

### Pages to Exclude on Mobile
- Interview Raybot → show "Best on desktop" message
- Voice Case Study Demo → show "Best on desktop" message
- Blog templates: Data Insights, Framework Guide, Timeline Evolution → fall back to Editorial Classic

### Pages to Redesign
- Case Study Style 2 (Split) → single column
- Case Study Style 3 (Immersive) → simplified
- Transformation page → accordion sections
- Works/Portfolio → single-column card list
- About Person → remove particle animation, use static image
- Products grid → single card stack with App Store link

### Status: NOT STARTED

---

## Notes
- All changes are responsive CSS/PHP — no separate mobile theme
- Desktop experience should remain unchanged
- Dark mode must work with all new mobile components
- WCAG touch targets: minimum 44px (48px on small screens)
