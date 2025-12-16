# Big Freight Life (BFLUXCO)
## Portfolio Design System v1.0

This design system governs **visual design, layout, typography, spacing, motion, and components**
for the BFLUXCO portfolio.

The goal is **editorial clarity, structural consistency, and calm authority**.

This is not a marketing system.
This is an authored body of work.

---

## 1. Design Principles

1. **Restraint over density**
2. **Structure over decoration**
3. **Consistency over cleverness**
4. **One idea per moment**
5. **Motion explains hierarchy**

If a design choice adds noise, remove it.

---

## 2. Color System

### Core Surfaces
- `--surface-primary`
  - Light: near-white / soft neutral
  - Dark: near-black / charcoal
- `--surface-secondary`
  - Used for cards and contained sections
- `--surface-muted`
  - Used sparingly for background separation

No gradients as decoration.
Gradients only allowed inside imagery.

---

### Text Colors
- `--text-primary`
  High contrast, used for titles and key statements
- `--text-secondary`
  Reduced contrast, used for descriptions
- `--text-muted`
  Metadata, labels, timestamps

Never use pure black or pure white for text.

---

### Accent Color
- One accent color maximum
- Used for:
  - Links
  - Focus states
  - Minimal emphasis
- Never used for large surfaces

---

## 3. Typography System

### Font Choice
**Primary Font:** Poppins (Google Fonts)
**Weights:** 400 (normal), 500 (medium), 600 (semibold), 700 (bold)
**Includes:** Italic variants for 400, 500, 600

Poppins is a geometric sans-serif with friendly, approachable letterforms while maintaining professional clarity.

---

### Font Philosophy
- Editorial
- Calm
- Highly readable
- No novelty fonts

---

### CSS Variables

```css
/* Font Families */
--font-family-primary: 'Poppins', system-fallback;
--font-family-heading: 'Poppins', system-fallback;
--font-family-mono: 'SF Mono', 'Monaco', monospace;

/* Font Sizes */
--font-size-xs: 0.75rem;     /* 12px */
--font-size-sm: 0.875rem;    /* 14px */
--font-size-base: 1rem;      /* 16px */
--font-size-lg: 1.125rem;    /* 18px */
--font-size-xl: 1.25rem;     /* 20px */
--font-size-2xl: 1.5rem;     /* 24px */
--font-size-3xl: 1.875rem;   /* 30px */
--font-size-4xl: 2.25rem;    /* 36px */
--font-size-5xl: 3rem;       /* 48px */
--font-size-6xl: 3.75rem;    /* 60px */
--font-size-7xl: 4.5rem;     /* 72px */

/* Font Weights */
--font-weight-normal: 400;
--font-weight-medium: 500;
--font-weight-semibold: 600;
--font-weight-bold: 700;

/* Line Heights */
--line-height-none: 1;
--line-height-tight: 1.25;
--line-height-snug: 1.375;
--line-height-normal: 1.5;
--line-height-relaxed: 1.625;
--line-height-loose: 2;

/* Letter Spacing */
--letter-spacing-tighter: -0.05em;
--letter-spacing-tight: -0.025em;
--letter-spacing-normal: 0;
--letter-spacing-wide: 0.025em;
--letter-spacing-wider: 0.05em;
--letter-spacing-widest: 0.1em;
```

---

### Heading Scale (Responsive)

| Level | Mobile | Tablet (768px) | Desktop (1024px) | Large (1280px) |
|-------|--------|----------------|------------------|----------------|
| H1    | 30px   | 36px           | 48px             | 60px           |
| H2    | 24px   | 30px           | 36px             | 36px           |
| H3    | 20px   | 24px           | 30px             | 30px           |
| H4    | 18px   | 20px           | 24px             | 24px           |
| H5    | 16px   | 16px           | 18px             | 18px           |
| H6    | 14px (uppercase) | 14px   | 14px             | 14px           |

**Note:** Headings use `font-weight: 600` (semibold) - Poppins looks better at 600 than 700 for headings.

---

### Typography Utility Classes

**Font Size:** `.text-xs` through `.text-7xl`
**Font Weight:** `.font-normal`, `.font-medium`, `.font-semibold`, `.font-bold`
**Line Height:** `.leading-none`, `.leading-tight`, `.leading-snug`, `.leading-normal`, `.leading-relaxed`, `.leading-loose`
**Letter Spacing:** `.tracking-tighter`, `.tracking-tight`, `.tracking-normal`, `.tracking-wide`, `.tracking-wider`, `.tracking-widest`
**Text Transform:** `.uppercase`, `.lowercase`, `.capitalize`, `.normal-case`
**Text Style:** `.italic`, `.not-italic`, `.underline`, `.line-through`, `.no-underline`
**Text Wrapping:** `.truncate`, `.text-wrap`, `.text-nowrap`, `.break-words`
**Prose Width:** `.prose-sm` (55ch), `.prose` (65ch), `.prose-lg` (75ch), `.prose-full`

---

### Special Typography Patterns

**Display Text** (hero headlines):
```html
<h1 class="display-text">Large headline</h1>
<h1 class="display-text-lg">Larger headline</h1>
<h1 class="display-text-xl">Extra large headline</h1>
```

**Overline/Eyebrow:**
```html
<span class="overline">Category</span>
<span class="overline overline-accent">Featured</span>
```

**Caption/Label:**
```html
<p class="caption">Image caption text</p>
<span class="label">Metadata label</span>
```

**Lead Paragraph:**
```html
<p class="lead">Introductory paragraph with larger text</p>
```

**Blockquote:**
```html
<blockquote>
  Quote text here.
  <cite>Author Name</cite>
</blockquote>
```

**Pull Quote:**
```html
<div class="pullquote">
  Featured quote for emphasis.
  <span class="pullquote-author">Author Name</span>
</div>
```

---

### Text Behavior
- Headings appear before body text
- Body text may fade in slightly after headers
- No animated text effects
- Use `.text-balance` on headlines for better line breaks

---

### Rules
- Titles never shout
- Body text never competes with titles
- Avoid bold-heavy paragraphs
- Use semibold (600) for inline emphasis, not bold (700)
- Large display text benefits from negative letter-spacing

---

## 4. Spacing System

### Base Unit
- **8px system**

Common values:
- 8 / 16 / 24 / 32 / 48 / 64 / 96

---

### Section Spacing
- Vertical spacing between major sections: **96–128px**
- Between subsection blocks: **48–64px**

White space is an active design element.

---

## 5. Layout System

### Content Width
- Max content width: **1400px**
- Content must never stretch full-bleed unintentionally

---

### Grid Philosophy
- Prefer **vertical flow**
- Avoid dense multi-column grids
- Use horizontal layouts sparingly and intentionally

This is a narrative site, not a dashboard.

---

## 6. Motion System

### Motion Principles
- Motion explains structure
- Motion is slow and deliberate
- Nothing bounces, snaps, or springs

---

### Global Timing
- Section reveal: 600–900ms
- Major transitions: 900–1400ms
- Micro interactions: 200–300ms

---

### Easing (Mandatory)
```css
cubic-bezier(0.22, 1, 0.36, 1)
```

---

## 7. CSS Variables Reference

```css
/* Motion */
--ease-out-expo: cubic-bezier(0.22, 1, 0.36, 1);
--motion-micro: 200ms;
--motion-fast: 300ms;
--motion-reveal: 700ms;
--motion-section: 1000ms;
--motion-dramatic: 1400ms;

/* Layout */
--container-max-width: 1400px;

/* Spacing (8px base) */
--spacing-1: 0.25rem;   /* 4px */
--spacing-2: 0.5rem;    /* 8px */
--spacing-3: 0.75rem;   /* 12px */
--spacing-4: 1rem;      /* 16px */
--spacing-6: 1.5rem;    /* 24px */
--spacing-8: 2rem;      /* 32px */
--spacing-12: 3rem;     /* 48px */
--spacing-16: 4rem;     /* 64px */
--spacing-20: 5rem;     /* 80px */
--spacing-24: 6rem;     /* 96px */
```
