# Case Study Carousel Alignment

> **Reference document for reproducing the carousel card alignment with page content.**

## The Problem

Horizontal scroll carousels with `scroll-snap` tend to snap cards to the viewport edge (position 0), ignoring any padding meant to align content with the page layout.

## The Solution

Use `scroll-padding-left` on the scroll container to offset snap points by the same amount as the content padding.

---

## Key CSS Properties

### 1. Scroll Container (`.case-carousel`)

```css
.case-carousel {
    scroll-snap-type: x mandatory;
    scroll-padding-left: max(
        var(--container-padding),
        calc((100vw - var(--container-max-width)) / 2 + var(--container-padding))
    );
}
```

**What this does:**
- `scroll-snap-type: x mandatory` - Forces horizontal snapping
- `scroll-padding-left` - Offsets the snap point inward, so cards snap to align with page content instead of the viewport edge

### 2. Track Container (`.case-carousel-track`)

```css
.case-carousel-track {
    display: flex;
    gap: 24px;
    padding-left: max(
        var(--container-padding),
        calc((100vw - var(--container-max-width)) / 2 + var(--container-padding))
    );
    padding-right: var(--container-padding);
}
```

**What this does:**
- Creates the visual left margin that aligns the first card with page content
- The calculation ensures alignment regardless of viewport width

### 3. Cards (`.case-card`)

```css
.case-card {
    width: 939px;
    height: 528px;
    flex: 0 0 auto;
    scroll-snap-align: start;
    scroll-snap-stop: always;
}
```

**What this does:**
- `scroll-snap-align: start` - Card's left edge is the snap point
- `scroll-snap-stop: always` - Prevents skipping cards during fast scroll

---

## The Alignment Formula

```css
max(var(--container-padding), calc((100vw - var(--container-max-width)) / 2 + var(--container-padding)))
```

### Variables (from `_variables.css`)
- `--container-max-width: 1400px`
- `--container-padding: 1rem` (16px default, increases at breakpoints)

### How it calculates

| Viewport | Calculation | Result |
|----------|-------------|--------|
| 1440px | `(1440 - 1400) / 2 + 16` | 36px |
| 1920px | `(1920 - 1400) / 2 + 16` | 276px |
| 1200px | `max(16, (1200 - 1400) / 2 + 16)` | 16px (uses min) |

The `max()` function ensures padding never goes below `--container-padding` on smaller screens.

---

## Why Both Properties Are Needed

| Property | Purpose |
|----------|---------|
| `padding-left` on track | Visual spacing - pushes first card away from viewport edge |
| `scroll-padding-left` on container | Snap behavior - tells browser where "start" position is for snapping |

**Without `scroll-padding-left`:** Cards visually start with correct padding, but scroll-snap pulls them back to viewport edge after any scroll interaction.

**Without `padding-left`:** Snap points are correct, but there's no visual spacing on initial load before any interaction.

---

## Files

| File | What to edit |
|------|--------------|
| `assets/css/custom.css` | `.case-carousel` scroll-padding-left |
| `assets/css/custom.css` | `.case-carousel-track` padding-left |
| `assets/css/custom.css` | `.case-card` dimensions and snap-align |
| `assets/js/main.js` | `initCaseCarousel()` - JS scroll behavior |

---

## Navigation Alignment

The nav arrows should align with the card width:

```css
.case-studies-nav {
    width: 939px;  /* Match card width */
    justify-content: flex-end;
    background: none;
    border: none;
    padding: 0;
}

.case-studies-nav .section-nav-arrow {
    background: var(--btn-tertiary-bg);
    border: none;
}
```

---

## Troubleshooting

### Cards snap to viewport edge
- Check `scroll-padding-left` is set on `.case-carousel`
- Ensure the value matches `padding-left` on `.case-carousel-track`

### Cards reset position after ~1 minute
- This is scroll-snap re-asserting itself after layout recalculation
- Fix: Add `scroll-padding-left` to offset snap points

### Alignment breaks at certain viewport widths
- Check `max()` function is working (browser support)
- Verify CSS variables are defined in `:root`
