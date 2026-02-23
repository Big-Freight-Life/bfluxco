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

### Font Philosophy
- Editorial
- Calm
- Highly readable
- No novelty fonts

---

### Type Scale (Suggested)
- H1: Page-level statements (used sparingly)
- H2: Section titles (bold)
- H3: Card titles
- Body: Long-form reading
- Small: Metadata and labels

Rules:
- Titles never shout
- Body text never competes with titles
- Avoid bold-heavy paragraphs

---

### Text Behavior
- Headings appear before body text
- Body text may fade in slightly after headers
- No animated text effects

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
