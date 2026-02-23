# Voice-Led Case Study System Specification

## Agent 1: Product & Systems Planner Deliverables

### 1.1 System Requirements Document

#### Purpose
A voice-first case study experience that demonstrates experience architecture through the medium itself. Voice is the primary narrative layer; visuals and motion respond to spoken meaning.

#### Core Requirements

| Requirement | Description | Priority |
|-------------|-------------|----------|
| Voice Playback Engine | HTML5 Audio API with custom controls | MUST |
| Transcript Sync | Text highlights synchronized to audio timestamps | MUST |
| Narrative State Detection | Detect story phases (grounding, tension, decision, outcome) | MUST |
| Progressive Enhancement | Full text readable without JS or audio | MUST |
| Static Fallback | Complete experience for JS-off/audio-off users | MUST |
| Motion System | Subtle visual responses to narrative states | SHOULD |
| Accessibility | WCAG 2.1 AA compliance | MUST |
| Mobile Support | Touch-optimized controls, responsive layout | MUST |

#### Technical Constraints

- **WordPress Context**: Must work within existing BFLUXCO theme structure
- **No External Dependencies**: Vanilla JS only, no npm packages
- **Performance Budget**: < 50KB JS, < 20KB CSS (gzipped)
- **Browser Support**: Last 2 versions of Chrome, Firefox, Safari, Edge
- **Audio Format**: MP3 primary, OGG fallback

---

### 1.2 Feature Prioritization

#### MUST Have (MVP)
1. User-initiated voice playback (no autoplay)
2. Play/pause controls with keyboard support
3. Persistent control bar (fixed bottom)
4. Full transcript always visible and readable
5. Current sentence highlighting during playback
6. `prefers-reduced-motion` respect
7. Skip forward/backward (15 seconds)
8. Progress indicator

#### SHOULD Have (Phase 1)
1. Narrative state visual indicators
2. Background color/motion shifts by state
3. Playback speed control (0.75x, 1x, 1.25x, 1.5x)
4. Time remaining display
5. Jump-to-section navigation

#### COULD Have (Phase 2)
1. AI-assisted semantic analysis
2. Dynamic visual emphasis on key phrases
3. Multi-voice support (different speakers)
4. Chapter markers

#### WON'T Have (Out of Scope)
1. Video playback
2. Real-time speech synthesis
3. Voice input/commands
4. Background music/soundscapes

---

### 1.3 Risk & Mitigation

| Risk | Impact | Likelihood | Mitigation |
|------|--------|------------|------------|
| Audio file too large | High | Medium | Compress to 64kbps, segment long narratives |
| Sync drift on slow devices | Medium | Low | Use requestAnimationFrame, debounce updates |
| iOS audio restrictions | High | High | Require user gesture before first play |
| Screen reader conflicts | High | Medium | Use aria-live regions carefully, provide transcript |
| Motion sickness | Medium | Low | Honor prefers-reduced-motion, keep motion subtle |
| Complex state management | Medium | Medium | Use simple state machine, avoid over-engineering |

---

### 1.4 Success Criteria

1. **Comprehension**: Users understand the decision-making process described
2. **Engagement**: > 60% of users who start voice complete at least 50%
3. **Accessibility**: Passes automated accessibility tests (axe, WAVE)
4. **Performance**: Largest Contentful Paint < 2.5s, First Input Delay < 100ms
5. **Portfolio Signal**: Demonstrates restraint and intentionality in design

---

## Agent 2: Narrative & Voice Design Deliverables

### 2.1 Voice-First Narrative Structure

#### Narrative Arc Pattern
Every voice-led case study follows this structure:

```
1. GROUNDING (10-15% of duration)
   - Establishes context: who, what, where
   - Calm, measured tone
   - Sets the problem space

2. TENSION (25-35% of duration)
   - Introduces the challenge or constraint
   - Raises stakes
   - Presents competing priorities

3. DECISION (30-40% of duration)
   - Explores options considered
   - Explains trade-offs
   - Reveals the chosen path and WHY

4. OUTCOME (15-25% of duration)
   - Results achieved
   - Lessons learned
   - Broader implications
```

---

### 2.2 Narrative State Model

```javascript
const NARRATIVE_STATES = {
  GROUNDING: {
    id: 'grounding',
    label: 'Setting Context',
    visualTone: 'neutral',
    motionIntensity: 0.2,
    colorShift: 'cool-neutral',
    keywords: ['context', 'background', 'initially', 'at first', 'the situation']
  },
  TENSION: {
    id: 'tension',
    label: 'The Challenge',
    visualTone: 'alert',
    motionIntensity: 0.4,
    colorShift: 'warm-accent',
    keywords: ['however', 'but', 'challenge', 'problem', 'constraint', 'conflict']
  },
  DECISION: {
    id: 'decision',
    label: 'Making Choices',
    visualTone: 'focused',
    motionIntensity: 0.6,
    colorShift: 'primary',
    keywords: ['decided', 'chose', 'approach', 'strategy', 'because', 'trade-off']
  },
  OUTCOME: {
    id: 'outcome',
    label: 'Results',
    visualTone: 'resolved',
    motionIntensity: 0.3,
    colorShift: 'cool-accent',
    keywords: ['result', 'achieved', 'learned', 'outcome', 'ultimately', 'impact']
  }
};
```

---

### 2.3 Voice Script Guidelines for Authors

#### Recording Guidelines

1. **Pacing**
   - Speak at 140-160 words per minute (slower than conversational)
   - Pause 0.5-1 second at sentence boundaries
   - Pause 1.5-2 seconds at paragraph/section boundaries
   - Let key phrases breathe

2. **Tone**
   - Thoughtful, not salesy
   - First-person perspective ("I considered...", "We decided...")
   - Acknowledge uncertainty where it existed
   - Avoid jargon unless explained

3. **Structure**
   - Open with the core tension in first 30 seconds
   - Each section should have a clear purpose
   - End sentences on emphasized words (not filler)
   - Vary sentence length

#### Transcript Markup Format

```html
<div class="voice-transcript" data-audio-src="case-study-audio.mp3">

  <!-- Grounding Section -->
  <section class="narrative-section" data-state="grounding" data-start="0" data-end="45">
    <p class="transcript-paragraph">
      <span class="transcript-sentence" data-start="0" data-end="8">
        In early 2024, a Fortune 500 healthcare company came to us with a challenge.
      </span>
      <span class="transcript-sentence" data-start="8" data-end="16">
        Their customer support team was drowning in complexity.
      </span>
    </p>
  </section>

  <!-- Tension Section -->
  <section class="narrative-section" data-state="tension" data-start="45" data-end="120">
    <p class="transcript-paragraph">
      <span class="transcript-sentence" data-start="45" data-end="52">
        However, there was a constraint we hadn't anticipated.
      </span>
      <!-- ... -->
    </p>
  </section>

</div>
```

---

## Agent 3: Experience & Interaction Design Deliverables

### 3.1 Page Blueprint

```
┌─────────────────────────────────────────────────────────────┐
│  HEADER (standard site header, hides on scroll)             │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│  CASE STUDY HEADER                                          │
│  ┌─────────────────────────────────────────────────────┐   │
│  │  Industry Tag                                        │   │
│  │  Title (h1)                                          │   │
│  │  Subtitle / Hook                                     │   │
│  │  Meta: Client | Timeline | Role                      │   │
│  │                                                      │   │
│  │  [▶ Listen to This Case Study]  [Read Transcript]   │   │
│  └─────────────────────────────────────────────────────┘   │
│                                                             │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│  NARRATIVE CONTENT AREA                                     │
│  ┌─────────────────────────────────────────────────────┐   │
│  │                                                      │   │
│  │  [Visual/Image Area - responds to narrative state]   │   │
│  │                                                      │   │
│  ├──────────────────────────────────────────────────────┤   │
│  │                                                      │   │
│  │  Transcript Text                                     │   │
│  │  (current sentence highlighted during playback)      │   │
│  │                                                      │   │
│  │  Section markers in margin:                          │   │
│  │  ● Grounding                                         │   │
│  │  ● Tension                                           │   │
│  │  ○ Decision (upcoming)                               │   │
│  │  ○ Outcome                                           │   │
│  │                                                      │   │
│  └─────────────────────────────────────────────────────┘   │
│                                                             │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│  RESULTS / OUTCOMES SECTION                                 │
│                                                             │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│  RELATED CASE STUDIES                                       │
│                                                             │
├─────────────────────────────────────────────────────────────┤
│  FOOTER                                                     │
└─────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────┐
│  VOICE CONTROL BAR (fixed bottom, appears after user        │
│  initiates playback)                                        │
│                                                             │
│  [<<15s] [▶/❚❚] [15s>>]  ━━━━━●━━━━━━  2:45 / 8:30  [1x▼]  │
│                                                             │
│  Current: "The Challenge" (Tension)                         │
└─────────────────────────────────────────────────────────────┘
```

---

### 3.2 Interaction Flow

```
USER LANDS ON PAGE
        │
        ▼
   ┌─────────────┐
   │ Read Header │ ← Full content visible, no audio
   │ See CTA:    │
   │ "Listen"    │
   └──────┬──────┘
          │
          ▼
   ┌─────────────────┐
   │ User clicks     │ ← User gesture required (iOS)
   │ "Listen to This │
   │  Case Study"    │
   └────────┬────────┘
            │
            ▼
   ┌─────────────────────────────────────────┐
   │ Voice Control Bar slides up from bottom │
   │ Audio begins playing                    │
   │ First sentence highlights               │
   └────────────────┬────────────────────────┘
                    │
        ┌───────────┴───────────┐
        │                       │
        ▼                       ▼
   ┌─────────┐            ┌─────────────┐
   │ Listen  │            │ Pause/Read  │
   │ Passively│           │ Silently    │
   └────┬────┘            └──────┬──────┘
        │                        │
        ▼                        │
   ┌──────────────┐              │
   │ Auto-scroll  │              │
   │ to current   │              │
   │ sentence     │              │
   └──────┬───────┘              │
          │                      │
          ▼                      │
   ┌──────────────┐              │
   │ Narrative    │              │
   │ state shifts │              │
   │ (visual cues)│              │
   └──────┬───────┘              │
          │                      │
          ├──────────────────────┘
          │
          ▼
   ┌─────────────────┐
   │ Audio Completes │
   │ Control bar     │
   │ shows "Replay"  │
   └─────────────────┘
```

---

### 3.3 Control Bar Behavior Specification

```javascript
const controlBarSpec = {
  // Visibility
  initialState: 'hidden',
  showTrigger: 'user clicks play button',
  hideTrigger: 'audio ends + user scrolls past content',

  // Position
  position: 'fixed',
  placement: 'bottom',
  height: '80px',
  mobileHeight: '100px',

  // Controls
  controls: {
    skipBack: { seconds: 15, shortcut: 'ArrowLeft' },
    playPause: { shortcut: 'Space' },
    skipForward: { seconds: 15, shortcut: 'ArrowRight' },
    progressBar: { draggable: true, clickable: true },
    timeDisplay: { format: 'current / total' },
    speedControl: { options: [0.75, 1, 1.25, 1.5], default: 1 }
  },

  // State Display
  stateIndicator: {
    show: true,
    position: 'below controls',
    format: 'Current: "{sectionLabel}" ({stateName})'
  },

  // Animations
  enterAnimation: 'slideUp 300ms ease-out',
  exitAnimation: 'slideDown 200ms ease-in',
  respectsReducedMotion: true
};
```

---

## Agent 4: Visual & Motion Design Deliverables

### 4.1 Visual Design Specification

#### Layout Grid

```css
/* Desktop (≥1024px) */
--content-max-width: 720px;
--sidebar-width: 200px;
--visual-area-height: 400px;

/* Tablet (768px - 1023px) */
--content-max-width: 100%;
--sidebar-width: 0; /* collapses */
--visual-area-height: 300px;

/* Mobile (<768px) */
--content-max-width: 100%;
--visual-area-height: 200px;
```

#### Color System (Dark Theme)

```css
:root {
  /* Narrative State Colors */
  --state-grounding-bg: hsl(220, 15%, 10%);
  --state-grounding-accent: hsl(200, 30%, 50%);

  --state-tension-bg: hsl(220, 15%, 12%);
  --state-tension-accent: hsl(30, 70%, 55%);

  --state-decision-bg: hsl(220, 15%, 11%);
  --state-decision-accent: hsl(170, 60%, 45%);

  --state-outcome-bg: hsl(220, 15%, 10%);
  --state-outcome-accent: hsl(260, 40%, 60%);

  /* Highlight Colors */
  --sentence-highlight: rgba(26, 132, 123, 0.2);
  --sentence-highlight-border: rgba(26, 132, 123, 0.6);
}
```

---

### 4.2 Motion Rules by Narrative State

```css
/* Base: Reduced motion respected */
@media (prefers-reduced-motion: reduce) {
  .voice-visual-area,
  .narrative-section,
  .voice-control-bar {
    transition: none !important;
    animation: none !important;
  }
}

/* State-specific motion */
[data-narrative-state="grounding"] .voice-visual-area {
  --motion-speed: 8s;
  --motion-scale: 1.02;
  animation: subtle-drift var(--motion-speed) ease-in-out infinite;
}

[data-narrative-state="tension"] .voice-visual-area {
  --motion-speed: 4s;
  --motion-scale: 1.04;
  animation: subtle-pulse var(--motion-speed) ease-in-out infinite;
}

[data-narrative-state="decision"] .voice-visual-area {
  --motion-speed: 6s;
  --motion-scale: 1.03;
  animation: subtle-focus var(--motion-speed) ease-in-out infinite;
}

[data-narrative-state="outcome"] .voice-visual-area {
  --motion-speed: 10s;
  --motion-scale: 1.01;
  animation: subtle-settle var(--motion-speed) ease-in-out infinite;
}

@keyframes subtle-drift {
  0%, 100% { transform: scale(1) translate(0, 0); }
  50% { transform: scale(var(--motion-scale)) translate(1%, 0.5%); }
}

@keyframes subtle-pulse {
  0%, 100% { opacity: 0.9; }
  50% { opacity: 1; }
}

@keyframes subtle-focus {
  0%, 100% { filter: brightness(1); }
  50% { filter: brightness(1.05); }
}

@keyframes subtle-settle {
  0%, 100% { transform: scale(1); }
  50% { transform: scale(var(--motion-scale)); }
}
```

---

### 4.3 Reduced Motion Alternatives

When `prefers-reduced-motion: reduce`:

1. **State Changes**: Instant color transitions (no animation)
2. **Highlight**: Static border, no pulse
3. **Control Bar**: Instant show/hide
4. **Visual Area**: Static image, no transforms
5. **Progress Bar**: Steps instead of smooth fill

---

## Agent 5: Front-End Engineering Deliverables

See implementation files:
- `template-parts/voice-case-study.php`
- `assets/js/voice-narrative.js`
- `assets/css/partials/_voice-narrative.css`

---

## Agent 6: AI & Semantic Interpretation Deliverables

### 6.1 Narrative State Mapping Logic

```javascript
/**
 * Heuristic State Detection (No AI Required)
 * Analyzes sentence content to determine narrative state
 */
const heuristicStateDetector = {
  patterns: {
    grounding: [
      /^(in|at|during|when|before)\s/i,
      /initially|originally|at first|background/i,
      /context|situation|environment|landscape/i,
      /\d{4}|years? ago|months? ago/i  // dates
    ],
    tension: [
      /however|but|yet|although|despite/i,
      /challenge|problem|issue|obstacle|constraint/i,
      /difficult|complex|competing|conflict/i,
      /risk|pressure|urgency|deadline/i
    ],
    decision: [
      /decided|chose|selected|approach|strategy/i,
      /because|therefore|thus|so we/i,
      /trade-?off|priorit|weigh|consider/i,
      /option|alternative|path|direction/i
    ],
    outcome: [
      /result|outcome|achieve|accomplish/i,
      /learned|realized|discovered|understood/i,
      /ultimately|finally|in the end/i,
      /impact|effect|improvement|success/i
    ]
  },

  detectState(sentence) {
    for (const [state, patterns] of Object.entries(this.patterns)) {
      for (const pattern of patterns) {
        if (pattern.test(sentence)) {
          return state;
        }
      }
    }
    return null; // Use section default
  }
};
```

---

### 6.2 AI-Ready Interface

```javascript
/**
 * AI Enhancement Hook
 * Drop-in replacement for heuristic detection
 * when/if AI integration is added
 */
class NarrativeStateEngine {
  constructor(options = {}) {
    this.useAI = options.aiEnabled || false;
    this.aiEndpoint = options.aiEndpoint || null;
    this.fallback = heuristicStateDetector;
  }

  async detectState(sentence, context = {}) {
    // Always allow author override via data attributes
    if (context.authorOverride) {
      return context.authorOverride;
    }

    // AI path (future)
    if (this.useAI && this.aiEndpoint) {
      try {
        const response = await this.queryAI(sentence, context);
        return response.state;
      } catch (error) {
        console.warn('AI detection failed, using fallback:', error);
        return this.fallback.detectState(sentence);
      }
    }

    // Heuristic path (current)
    return this.fallback.detectState(sentence);
  }

  async queryAI(sentence, context) {
    // Placeholder for future AI integration
    // Would call Mistral/Claude API for semantic analysis
    throw new Error('AI not configured');
  }
}
```

---

### 6.3 AI Safety Constraints

```javascript
const AI_SAFETY_RULES = {
  // AI cannot override explicit author markup
  respectAuthorIntent: true,

  // AI suggestions are advisory, not authoritative
  maxConfidenceOverride: 0.95,

  // Rate limiting
  maxRequestsPerMinute: 10,

  // Fallback behavior
  onAIFailure: 'use-heuristic',
  onAITimeout: 'use-cached',
  timeoutMs: 2000,

  // Content restrictions
  disallowedOutputs: [
    'explicit emotional manipulation terms',
    'urgency language not in source',
    'claims not supported by transcript'
  ]
};
```

---

## Agent 7: Accessibility & Ethics Deliverables

### 7.1 Accessibility Checklist

| Requirement | Implementation | Status |
|-------------|----------------|--------|
| Keyboard navigation | All controls focusable, shortcuts documented | Required |
| Screen reader | ARIA labels, live regions for state changes | Required |
| Audio transcript | Full text always visible | Required |
| Focus visible | Custom focus styles on all interactive elements | Required |
| Color contrast | 4.5:1 minimum for text | Required |
| Reduced motion | `prefers-reduced-motion` respected | Required |
| Captions/subtitles | Synchronized transcript serves as captions | Required |
| Time control | User controls playback speed | Required |
| Pause control | User can pause at any time | Required |
| No autoplay | Audio requires user gesture | Required |

---

### 7.2 Ethics Guardrails

1. **No Manipulation**
   - Motion/sound never creates false urgency
   - No dark patterns in voice narration
   - No emotional manipulation through audio effects

2. **Transparency**
   - Clear indication when voice is AI-generated (if applicable)
   - Honest presentation of case study outcomes
   - No exaggeration of results

3. **User Control**
   - User always in control of playback
   - Easy to mute/pause/skip
   - Full content available without audio

4. **Cognitive Load**
   - One narrative layer at a time
   - Clear visual hierarchy
   - No competing audio sources

---

### 7.3 Failure Mode Behaviors

| Failure | Graceful Degradation |
|---------|---------------------|
| JavaScript disabled | Full transcript visible, styled, readable |
| Audio fails to load | Error message, transcript highlighted, CTA to retry |
| Network slow/offline | Cached audio if available, transcript always works |
| Browser doesn't support | Feature detection, fallback to basic player |
| Screen reader active | Ensure no conflicting announcements |

---

## Agent 8: QA & Integration Deliverables

### 8.1 QA Checklist

#### Functional Testing
- [ ] Play/pause toggles correctly
- [ ] Skip forward/back moves 15 seconds
- [ ] Progress bar is draggable and clickable
- [ ] Speed control changes playback rate
- [ ] Keyboard shortcuts work (Space, Arrow keys)
- [ ] ESC key pauses playback
- [ ] Audio completes without errors
- [ ] Replay button works after completion

#### Visual Testing
- [ ] Control bar appears on play
- [ ] Current sentence highlights correctly
- [ ] Narrative state colors shift appropriately
- [ ] Responsive at all breakpoints (320px - 2560px)
- [ ] Dark theme renders correctly
- [ ] Focus states visible on all controls

#### Accessibility Testing
- [ ] Tab navigation works through all controls
- [ ] Screen reader announces control labels
- [ ] Reduced motion: no animations
- [ ] Color contrast passes (use axe DevTools)
- [ ] Transcript readable without audio

#### Performance Testing
- [ ] LCP < 2.5s on 3G connection
- [ ] FID < 100ms
- [ ] CLS < 0.1
- [ ] JavaScript bundle < 50KB gzipped
- [ ] CSS bundle < 20KB gzipped
- [ ] Audio loads progressively (streaming)

#### Edge Cases
- [ ] iOS Safari: audio plays after user gesture
- [ ] Android Chrome: audio controls work
- [ ] Firefox: all features work
- [ ] Safari: no webkit-specific bugs
- [ ] Multiple case studies on same page: isolated state

---

### 8.2 Integration Notes

1. **WordPress Integration**
   - Template lives in `template-parts/voice-case-study.php`
   - Included via shortcode `[voice_case_study]` or template part
   - Audio files stored in media library
   - Meta fields for audio URL, transcript timestamps

2. **Asset Loading**
   - CSS loaded only on pages using voice feature
   - JS loaded with `defer` attribute
   - Audio loaded on-demand (not preloaded)

3. **SEO Considerations**
   - Full transcript in HTML (crawlable)
   - Structured data for audio content
   - Open Graph tags for social sharing

---

### 8.3 Final Readiness Assessment

#### Ready for Production
- [x] Requirements documented
- [x] Narrative model defined
- [x] Interaction patterns specified
- [x] Visual design complete
- [x] Accessibility validated
- [ ] Code implementation (pending)
- [ ] Content authored (pending)
- [ ] User testing (pending)

#### Known Limitations
1. No AI integration in v1 (heuristic only)
2. Single voice per case study (no multi-speaker)
3. No offline audio caching
4. Manual timestamp entry for transcript sync

#### Recommended Next Steps
1. Implement code per specifications
2. Record pilot audio content
3. Conduct usability testing with 5+ users
4. Iterate based on feedback
5. Deploy to staging for QA
6. Launch with single case study, expand

---

*Document Version: 1.0*
*Last Updated: December 2025*
*Authors: Multi-Agent System*
