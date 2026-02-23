# Voice Case Study Authoring Guide

This guide explains how to create voice-led case studies for the BFLUXCO portfolio.

## Overview

A voice-led case study combines:
1. **Audio narration** - Your voice explaining the project
2. **Synchronized transcript** - Text that highlights as you speak
3. **Visual atmosphere** - Subtle motion that responds to narrative state

The system is designed for **restraint and clarity**. Voice is the primary layer; everything else supports comprehension.

---

## Quick Start

### 1. Record Your Audio

- **Format**: MP3 (64-128kbps, mono is fine)
- **Length**: 5-12 minutes recommended
- **Pace**: Speak at 140-160 words per minute
- **Tone**: Thoughtful, first-person ("I considered...", "We decided...")

### 2. Create the Transcript

Structure your transcript with timing data:

```html
[voice_case_study audio="123" image="456" duration="8:30"]

<section class="narrative-section" data-state="grounding" data-start="0" data-end="45" data-state-label="Context">
  <p class="transcript-paragraph">
    <span class="transcript-sentence" data-start="0" data-end="8">
      In early 2024, a Fortune 500 healthcare company approached us.
    </span>
    <span class="transcript-sentence" data-start="8" data-end="16">
      Their customer support team was overwhelmed by complexity.
    </span>
  </p>
</section>

<section class="narrative-section" data-state="tension" data-start="45" data-end="180" data-state-label="Challenge">
  <p class="transcript-paragraph">
    <span class="transcript-sentence" data-start="45" data-end="52">
      However, we encountered an unexpected constraint.
    </span>
  </p>
</section>

[/voice_case_study]
```

### 3. Upload to WordPress

1. Upload your MP3 to the Media Library
2. Note the attachment ID (visible in the URL when editing)
3. Create a new Case Study post
4. Use the shortcode with your content

---

## Transcript Markup Reference

### Shortcode Attributes

| Attribute | Required | Description |
|-----------|----------|-------------|
| `audio` | Yes | Attachment ID or URL of the MP3 file |
| `image` | No | Attachment ID or URL for the visual area |
| `duration` | No | Display string (e.g., "8:30") |

### Narrative Sections

Each major part of your story is wrapped in a section:

```html
<section class="narrative-section"
         data-state="grounding"
         data-start="0"
         data-end="45"
         data-state-label="Context">
```

| Attribute | Description |
|-----------|-------------|
| `data-state` | One of: `grounding`, `tension`, `decision`, `outcome` |
| `data-start` | Section start time in seconds |
| `data-end` | Section end time in seconds |
| `data-state-label` | Label shown in sidebar (e.g., "Context", "Challenge") |

### Sentences

Each sentence is individually timed for highlighting:

```html
<span class="transcript-sentence" data-start="8" data-end="16">
  Their customer support team was overwhelmed by complexity.
</span>
```

| Attribute | Description |
|-----------|-------------|
| `data-start` | When this sentence starts (seconds) |
| `data-end` | When this sentence ends (seconds) |

---

## Narrative States Explained

### Grounding (10-15% of duration)
- **Purpose**: Set context, establish who/what/where
- **Tone**: Calm, measured
- **Keywords that trigger**: "initially", "at first", "context", dates
- **Visual**: Neutral colors, slow drift motion

### Tension (25-35% of duration)
- **Purpose**: Introduce challenge, raise stakes
- **Tone**: Alert, focused
- **Keywords**: "however", "but", "challenge", "constraint"
- **Visual**: Warm accent, subtle pulse

### Decision (30-40% of duration)
- **Purpose**: Explore options, explain trade-offs, reveal choice
- **Tone**: Deliberate, analytical
- **Keywords**: "decided", "because", "trade-off", "approach"
- **Visual**: Primary color accent, stable focus

### Outcome (15-25% of duration)
- **Purpose**: Results, lessons, implications
- **Tone**: Reflective, resolved
- **Keywords**: "result", "learned", "ultimately", "impact"
- **Visual**: Cool accent, settling motion

---

## Recording Tips

### Before Recording
1. Write a rough script (don't read verbatim)
2. Practice once or twice out loud
3. Identify the emotional arc (where's the tension? the resolution?)

### During Recording
1. Use a quiet room with soft surfaces
2. Position mic 6-8 inches from mouth
3. Pause 0.5-1 second between sentences
4. Pause 1.5-2 seconds between sections
5. Let key phrases breathe

### After Recording
1. Edit out long silences, ums, and restarts
2. Normalize audio levels
3. Export as MP3 at 64-128kbps mono
4. Note timing of major section transitions

---

## Timing Your Transcript

### Manual Method
1. Open audio in Audacity or similar
2. Play and note the timestamp when each sentence starts/ends
3. Enter these as `data-start` and `data-end` values

### Faster Method
1. Record your transcript timing while listening
2. Use a spreadsheet to track sentence numbers and times
3. Generate the HTML markup from the spreadsheet

### Example Timing Spreadsheet

| Sentence | Start (s) | End (s) | State | Text |
|----------|-----------|---------|-------|------|
| 1 | 0 | 8 | grounding | In early 2024... |
| 2 | 8 | 16 | grounding | Their customer support... |
| 3 | 16 | 25 | grounding | The legacy system... |
| 4 | 45 | 52 | tension | However, we encountered... |

---

## Example: Complete Case Study

```html
[voice_case_study audio="1234" image="5678" duration="6:45"]

<!-- GROUNDING: Setting the Scene (0:00 - 0:45) -->
<section class="narrative-section" data-state="grounding" data-start="0" data-end="45" data-state-label="Context">
  <p class="transcript-paragraph">
    <span class="transcript-sentence" data-start="0" data-end="7">
      In the fall of 2024, we received an unusual request from a healthcare technology company.
    </span>
    <span class="transcript-sentence" data-start="7" data-end="15">
      They had built an innovative patient portal, but adoption was stalling.
    </span>
    <span class="transcript-sentence" data-start="15" data-end="23">
      Users praised the features but rarely returned after the first visit.
    </span>
  </p>
  <p class="transcript-paragraph">
    <span class="transcript-sentence" data-start="25" data-end="32">
      The client assumed they needed more features.
    </span>
    <span class="transcript-sentence" data-start="32" data-end="40">
      Our initial research suggested something different.
    </span>
  </p>
</section>

<!-- TENSION: The Real Problem (0:45 - 2:30) -->
<section class="narrative-section" data-state="tension" data-start="45" data-end="150" data-state-label="Challenge">
  <p class="transcript-paragraph">
    <span class="transcript-sentence" data-start="45" data-end="53">
      However, when we interviewed actual users, a pattern emerged.
    </span>
    <span class="transcript-sentence" data-start="53" data-end="62">
      The portal wasn't missing features; it was missing context.
    </span>
  </p>
  <p class="transcript-paragraph">
    <span class="transcript-sentence" data-start="64" data-end="75">
      Users arrived with specific questions: When is my next appointment? What were my last test results?
    </span>
    <span class="transcript-sentence" data-start="75" data-end="86">
      But the portal greeted them with a dashboard full of everything except what they needed.
    </span>
  </p>
</section>

<!-- DECISION: Our Approach (2:30 - 5:00) -->
<section class="narrative-section" data-state="decision" data-start="150" data-end="300" data-state-label="Approach">
  <p class="transcript-paragraph">
    <span class="transcript-sentence" data-start="150" data-end="160">
      We decided to completely reimagine the entry experience.
    </span>
    <span class="transcript-sentence" data-start="160" data-end="172">
      Instead of showing everything, we would show only what mattered right now.
    </span>
  </p>
  <p class="transcript-paragraph">
    <span class="transcript-sentence" data-start="175" data-end="188">
      This required a trade-off: we would hide powerful features behind progressive disclosure.
    </span>
    <span class="transcript-sentence" data-start="188" data-end="200">
      Some stakeholders worried users wouldn't find advanced options.
    </span>
    <span class="transcript-sentence" data-start="200" data-end="212">
      But our research showed users weren't finding them anyway.
    </span>
  </p>
</section>

<!-- OUTCOME: Results (5:00 - 6:45) -->
<section class="narrative-section" data-state="outcome" data-start="300" data-end="405" data-state-label="Results">
  <p class="transcript-paragraph">
    <span class="transcript-sentence" data-start="300" data-end="312">
      The results exceeded our expectations.
    </span>
    <span class="transcript-sentence" data-start="312" data-end="324">
      Return visits increased by 340% in the first month.
    </span>
    <span class="transcript-sentence" data-start="324" data-end="336">
      Support tickets dropped by half.
    </span>
  </p>
  <p class="transcript-paragraph">
    <span class="transcript-sentence" data-start="340" data-end="355">
      What I learned from this project is that features aren't value.
    </span>
    <span class="transcript-sentence" data-start="355" data-end="370">
      Value is helping someone accomplish their goal with the least friction.
    </span>
    <span class="transcript-sentence" data-start="370" data-end="385">
      Sometimes that means showing less, not more.
    </span>
  </p>
</section>

[/voice_case_study]
```

---

## Accessibility Checklist

Before publishing, verify:

- [ ] Transcript is complete and matches audio exactly
- [ ] All timestamps are accurate (within 1 second)
- [ ] Each sentence is properly wrapped in `<span>` tags
- [ ] Narrative states are appropriate for content
- [ ] Audio quality is clear and audible
- [ ] Image has meaningful alt text (if used)

---

## Troubleshooting

### Audio Won't Play
- Verify the attachment ID is correct
- Check that the file is a valid MP3
- Test in an incognito window (cache issues)

### Highlighting is Off
- Double-check your timing data
- Sentences should not overlap in time
- End time of one sentence should match start of next

### Visual Effects Not Showing
- Ensure `data-state` values are spelled correctly
- Check browser console for JavaScript errors
- Verify CSS is loading (view source)

### Mobile Issues
- Test on actual devices, not just browser DevTools
- Ensure audio plays after user tap (iOS requirement)

---

## Need Help?

Contact the development team or refer to:
- `/docs/VOICE-CASE-STUDY-SPEC.md` - Technical specification
- `/assets/js/voice-narrative.js` - JavaScript implementation
- `/assets/css/partials/_voice-narrative.css` - Styles
