<?php
/**
 * Template Name: GenAI Experience Architecture
 * Template Post Type: page
 *
 * Award-winning service page for GenAI Experience Design.
 * Features animated code graphics, immersive sections, and captivating visuals.
 *
 * @package BFLUXCO
 */

get_header();
?>

<main id="main-content" class="site-main genai-page">

    <!-- Hero: Animated Code Background -->
    <header class="genai-hero">
        <div class="genai-hero-code">
            <pre class="code-stream code-stream-1"><code><span class="code-keyword">const</span> <span class="code-var">experience</span> = <span class="code-keyword">await</span> <span class="code-func">designWithIntent</span>({
  <span class="code-prop">humanJudgment</span>: <span class="code-string">"visible"</span>,
  <span class="code-prop">systemBehavior</span>: <span class="code-string">"legible"</span>,
  <span class="code-prop">serviceDesign</span>: <span class="code-string">"aligned"</span>,
  <span class="code-prop">responsibility</span>: <span class="code-string">"accountable"</span>
});</code></pre>
            <pre class="code-stream code-stream-2"><code><span class="code-comment">// Service-Level Collaboration</span>
<span class="code-keyword">interface</span> <span class="code-type">WorkflowState</span> {
  <span class="code-prop">tasks</span>: <span class="code-type">Task</span>[];
  <span class="code-prop">handoffs</span>: <span class="code-type">Handoff</span>[];
  <span class="code-prop">accountability</span>: <span class="code-type">Owner</span>[];
  <span class="code-prop">adaptable</span>: <span class="code-type">boolean</span>;
}</code></pre>
            <pre class="code-stream code-stream-3"><code><span class="code-keyword">function</span> <span class="code-func">manageChange</span>(<span class="code-var">service</span>) {
  <span class="code-keyword">const</span> <span class="code-var">visibility</span> = <span class="code-func">ensureTransparency</span>(<span class="code-var">service</span>);
  <span class="code-keyword">const</span> <span class="code-var">governance</span> = <span class="code-func">maintainAccountability</span>();

  <span class="code-keyword">return</span> { <span class="code-var">visibility</span>, <span class="code-var">governance</span>, <span class="code-prop">manageable</span>: <span class="code-keyword">true</span> };
}</code></pre>
        </div>

        <div class="genai-hero-overlay"></div>

        <div class="container genai-hero-content">
            <h1 class="genai-hero-title">
                <span class="reveal-text" data-delay="1">GenAI Experience</span>
                <span class="genai-hero-accent reveal-text" data-delay="2">Design</span>
            </h1>
            <p class="genai-hero-tagline reveal-text" data-delay="3">
                Designing Experiences in AI-Driven Systems
            </p>
        </div>

        <div class="genai-hero-scroll reveal-up" data-delay="5">
            <div class="scroll-indicator">
                <span class="scroll-line"></span>
            </div>
        </div>
    </header>

    <!-- Introduction Section -->
    <section class="genai-section genai-intro">
        <div class="container">
            <div class="genai-intro-grid">
                <div class="genai-intro-content">
                    <p class="genai-lead reveal-text">
                        GenAI experience design focuses on what changes when systems begin to reason, adapt, and act alongside people.
                    </p>
                    <p class="reveal-text" data-delay="1">
                        AI doesn't just add features. It reshapes how decisions are made.
                    </p>
                    <p class="reveal-text" data-delay="2">
                        When AI enters a workspace, it changes more than interfaces. It alters workflows, handoffs, roles, and accountability. Decisions move differently through the organization, and responsibility shifts in ways that are not always visible.
                    </p>
                    <p class="genai-highlight reveal-text" data-delay="3">
                        GenAI experience design addresses these changes directly—designing experiences that account for system behavior, human judgment, and the services that connect them.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Beyond the Interface -->
    <section class="genai-section genai-beyond">
        <div class="container">
            <div class="genai-split-grid">
                <div class="genai-split-content">
                    <h2 class="genai-section-title reveal-text">Experience Design Beyond the Interface</h2>
                    <p class="genai-lead reveal-text" data-delay="1">
                        In AI-driven systems, experience is shaped as much by processes and coordination as by interaction.
                    </p>
                    <p class="reveal-text" data-delay="2">
                        People don't just experience screens or conversations. They experience delays, escalations, workarounds, approvals, and outcomes that unfold across teams and tools. These service-level conditions shape trust far more than interface polish.
                    </p>
                    <p class="genai-highlight reveal-text" data-delay="3">
                        GenAI experience design ensures that these underlying processes are considered part of the experience—not hidden behind automation.
                    </p>
                </div>
                <div class="genai-split-visual reveal-up" data-delay="2">
                    <div class="behavior-signals">
                        <div class="signal-item signal-item-1">
                            <span class="signal-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <circle cx="12" cy="12" r="10"/>
                                    <path d="M12 6v6l4 2"/>
                                </svg>
                            </span>
                            <span class="signal-label">Delays</span>
                        </div>
                        <div class="signal-item signal-item-2">
                            <span class="signal-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M12 19V5M5 12l7-7 7 7"/>
                                </svg>
                            </span>
                            <span class="signal-label">Escalations</span>
                        </div>
                        <div class="signal-item signal-item-3">
                            <span class="signal-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M9 12l2 2 4-4"/>
                                    <circle cx="12" cy="12" r="10"/>
                                </svg>
                            </span>
                            <span class="signal-label">Approvals</span>
                        </div>
                        <div class="signal-item signal-item-4">
                            <span class="signal-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
                                </svg>
                            </span>
                            <span class="signal-label">Outcomes</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Service Design -->
    <section class="genai-section genai-service">
        <div class="container">
            <div class="genai-split-grid genai-split-reverse">
                <div class="genai-split-visual reveal-up" data-delay="1">
                    <div class="service-blueprint">
                        <!-- Service Blueprint Layers -->
                        <div class="blueprint-layer blueprint-layer-people">
                            <span class="layer-label">People</span>
                            <div class="layer-content">
                                <div class="blueprint-step">
                                    <span class="step-icon">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                            <circle cx="12" cy="7" r="4"/>
                                            <path d="M5.5 21a6.5 6.5 0 0 1 13 0"/>
                                        </svg>
                                    </span>
                                    <span class="step-text">Initiate</span>
                                </div>
                                <div class="blueprint-arrow">→</div>
                                <div class="blueprint-step">
                                    <span class="step-icon">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                            <circle cx="12" cy="12" r="3"/>
                                        </svg>
                                    </span>
                                    <span class="step-text">Review</span>
                                </div>
                                <div class="blueprint-arrow">→</div>
                                <div class="blueprint-step">
                                    <span class="step-icon">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                            <polyline points="22 4 12 14.01 9 11.01"/>
                                        </svg>
                                    </span>
                                    <span class="step-text">Decide</span>
                                </div>
                            </div>
                        </div>

                        <div class="blueprint-divider">
                            <span class="divider-label">Line of Interaction</span>
                        </div>

                        <div class="blueprint-layer blueprint-layer-ai">
                            <span class="layer-label">AI</span>
                            <div class="layer-content">
                                <div class="blueprint-step blueprint-step-ai">
                                    <span class="step-icon">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                            <rect x="4" y="4" width="16" height="16" rx="2"/>
                                            <path d="M9 9h6M9 12h6M9 15h4"/>
                                        </svg>
                                    </span>
                                    <span class="step-text">Process</span>
                                </div>
                                <div class="blueprint-arrow">→</div>
                                <div class="blueprint-step blueprint-step-ai">
                                    <span class="step-icon">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                            <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/>
                                        </svg>
                                    </span>
                                    <span class="step-text">Assist</span>
                                </div>
                                <div class="blueprint-arrow">→</div>
                                <div class="blueprint-step blueprint-step-ai">
                                    <span class="step-icon">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                            <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/>
                                            <polyline points="14 2 14 8 20 8"/>
                                        </svg>
                                    </span>
                                    <span class="step-text">Deliver</span>
                                </div>
                            </div>
                        </div>

                        <div class="blueprint-divider">
                            <span class="divider-label">Line of Visibility</span>
                        </div>

                        <div class="blueprint-layer blueprint-layer-system">
                            <span class="layer-label">Systems</span>
                            <div class="layer-content">
                                <div class="blueprint-step blueprint-step-system">
                                    <span class="step-icon">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                            <ellipse cx="12" cy="5" rx="9" ry="3"/>
                                            <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/>
                                            <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/>
                                        </svg>
                                    </span>
                                    <span class="step-text">Data</span>
                                </div>
                                <div class="blueprint-arrow">→</div>
                                <div class="blueprint-step blueprint-step-system">
                                    <span class="step-icon">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                            <polyline points="16 18 22 12 16 6"/>
                                            <polyline points="8 6 2 12 8 18"/>
                                        </svg>
                                    </span>
                                    <span class="step-text">Logic</span>
                                </div>
                                <div class="blueprint-arrow">→</div>
                                <div class="blueprint-step blueprint-step-system">
                                    <span class="step-icon">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                            <rect x="3" y="3" width="7" height="7"/>
                                            <rect x="14" y="3" width="7" height="7"/>
                                            <rect x="14" y="14" width="7" height="7"/>
                                            <rect x="3" y="14" width="7" height="7"/>
                                        </svg>
                                    </span>
                                    <span class="step-text">Integrate</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="genai-split-content">
                    <h2 class="genai-section-title reveal-text">Service Design in AI-Enabled Workspaces</h2>
                    <p class="genai-lead reveal-text" data-delay="1">
                        AI changes how work flows through an organization.
                    </p>
                    <p class="reveal-text" data-delay="2">
                        Tasks may be automated, reassigned, or split between humans and systems. New dependencies emerge. Exceptions surface in new places. Without intentional service design, these changes introduce friction and confusion instead of efficiency.
                    </p>
                    <p class="reveal-text" data-delay="3">
                        GenAI experience design incorporates service design to make these shifts explicit. We examine how work moves end to end, where decisions are made, and how responsibility is handed off—before automation is introduced.
                    </p>
                    <p class="genai-highlight reveal-text" data-delay="4">
                        Designing services alongside experiences ensures AI fits into real workflows, not idealized ones.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Human-AI Collaboration -->
    <section class="genai-section genai-collaboration">
        <div class="container">
            <div class="genai-split-grid">
                <div class="genai-split-content">
                    <h2 class="genai-section-title reveal-text">Designing for Human–AI Collaboration</h2>
                    <p class="genai-lead reveal-text" data-delay="1">
                        AI systems do not replace work. They participate in it.
                    </p>
                    <p class="reveal-text" data-delay="2">
                        GenAI experience design clarifies how people and AI collaborate across services and processes. This includes defining where AI assists, where it advises, and where human judgment remains essential—especially when exceptions or edge cases arise.
                    </p>
                    <p class="genai-highlight reveal-text" data-delay="3">
                        Clear collaboration prevents over-reliance on automation and keeps accountability grounded in the organization.
                    </p>
                </div>
                <div class="genai-split-visual reveal-up" data-delay="2">
                    <div class="collaboration-diagram">
                        <div class="collab-center">
                            <span>Work</span>
                        </div>
                        <div class="collab-orbit collab-ai">
                            <span class="collab-label">AI</span>
                            <div class="collab-roles">
                                <span>Assists</span>
                                <span>Advises</span>
                            </div>
                        </div>
                        <div class="collab-orbit collab-human">
                            <span class="collab-label">Human</span>
                            <div class="collab-roles">
                                <span>Judges</span>
                                <span>Owns</span>
                            </div>
                        </div>
                        <svg class="collab-lines" viewBox="0 0 300 200">
                            <!-- Assists - connects to right side of box -->
                            <path class="collab-line" d="M150,100 Q100,60 70,75" fill="none"/>
                            <!-- Judges - connects to left side of box -->
                            <path class="collab-line" d="M150,100 Q200,60 230,75" fill="none"/>
                            <!-- Advises - connects to right side of box -->
                            <path class="collab-line" d="M150,100 Q100,140 70,125" fill="none"/>
                            <!-- Owns - connects to left side of box -->
                            <path class="collab-line" d="M150,100 Q200,140 230,125" fill="none"/>
                            <!-- Endpoint dots -->
                            <circle class="collab-dot" cx="70" cy="75" r="4"/>
                            <circle class="collab-dot" cx="230" cy="75" r="4"/>
                            <circle class="collab-dot" cx="70" cy="125" r="4"/>
                            <circle class="collab-dot" cx="230" cy="125" r="4"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- System Behavior -->
    <section class="genai-section genai-behavior">
        <div class="container">
            <div class="genai-split-grid genai-split-reverse">
                <div class="genai-split-visual reveal-up" data-delay="1">
                    <div class="genai-terminal">
                        <div class="terminal-header">
                            <span class="terminal-dot"></span>
                            <span class="terminal-dot"></span>
                            <span class="terminal-dot"></span>
                            <span class="terminal-title">service-behavior.log</span>
                        </div>
                        <div class="terminal-body">
                            <div class="terminal-output">
                                <span class="terminal-timestamp">[09:14:23]</span>
                                <span class="terminal-action">Task routed to AI</span>
                            </div>
                            <div class="terminal-output">
                                <span class="terminal-timestamp">[09:14:24]</span>
                                <span class="terminal-detail">Confidence: 0.72</span>
                            </div>
                            <div class="terminal-output">
                                <span class="terminal-timestamp">[09:14:24]</span>
                                <span class="terminal-detail">Exception detected</span>
                            </div>
                            <div class="terminal-output terminal-highlight">
                                <span class="terminal-timestamp">[09:14:25]</span>
                                <span class="terminal-action">Handoff to human reviewer</span>
                            </div>
                            <div class="terminal-output">
                                <span class="terminal-timestamp">[09:14:25]</span>
                                <span class="terminal-detail">Accountability: Operations Team</span>
                            </div>
                            <div class="terminal-line">
                                <span class="terminal-prompt">$</span>
                                <span class="terminal-command">trace decision path</span>
                                <span class="terminal-cursor"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="genai-split-content">
                    <h2 class="genai-section-title reveal-text">Making System and Service Behavior Understandable</h2>
                    <p class="genai-lead reveal-text" data-delay="1">
                        One of the greatest risks in GenAI systems is invisible behavior—both technical and operational.
                    </p>
                    <p class="reveal-text" data-delay="2">
                        When people can't see how decisions are made or where work goes next, trust erodes. GenAI experience design focuses on making both system behavior and service behavior observable and interpretable.
                    </p>
                    <p class="genai-highlight reveal-text" data-delay="3">
                        This visibility supports governance, learning, and long-term adoption.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Adaptation Over Time -->
    <section class="genai-section genai-adaptation">
        <div class="container">
            <div class="genai-split-grid">
                <div class="genai-split-content">
                    <h2 class="genai-section-title reveal-text">Designing for Adaptation Over Time</h2>
                    <p class="genai-lead reveal-text" data-delay="1">
                        AI-enabled services evolve. Models change, workloads shift, and organizations adapt their processes in response.
                    </p>
                    <p class="reveal-text" data-delay="2">
                        GenAI experience design accounts for this by designing services and experiences that can adjust without breaking. This includes planning for how changes are communicated, how teams recalibrate responsibility, and how feedback loops inform future decisions.
                    </p>
                    <p class="genai-highlight reveal-text" data-delay="3">
                        Adaptation is not an edge case. It is the steady state.
                    </p>
                </div>
                <div class="genai-split-visual reveal-up" data-delay="2">
                    <div class="adaptation-timeline">
                        <div class="timeline-track"></div>
                        <div class="timeline-point timeline-point-1">
                            <span class="point-marker"></span>
                            <span class="point-label">Deploy</span>
                        </div>
                        <div class="timeline-point timeline-point-2">
                            <span class="point-marker"></span>
                            <span class="point-label">Learn</span>
                        </div>
                        <div class="timeline-point timeline-point-3">
                            <span class="point-marker"></span>
                            <span class="point-label">Adapt</span>
                        </div>
                        <div class="timeline-point timeline-point-4">
                            <span class="point-marker active"></span>
                            <span class="point-label">Evolve</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- System Responsibility -->
    <section class="genai-section genai-responsibility">
        <div class="container">
            <div class="genai-centered-content">
                <h2 class="genai-section-title reveal-text">GenAI Experience as System Responsibility</h2>
                <p class="genai-lead reveal-text" data-delay="1">
                    GenAI experience design is not just about usability. It is about responsibility across systems and services.
                </p>
                <p class="reveal-text" data-delay="2">
                    Every AI-assisted decision affects people, processes, and outcomes. Designing responsibly means making those effects visible, accountable, and governable—across the entire service, not just the interface.
                </p>
                <p class="genai-highlight reveal-text" data-delay="3">
                    When experience design, service design, conversation design, and adaptive research are aligned, GenAI systems can scale without losing clarity, control, or trust.
                </p>
            </div>

            <div class="responsibility-pillars">
                <div class="pillar reveal-up" data-delay="1">
                    <div class="pillar-icon">
                        <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5">
                            <circle cx="24" cy="24" r="20"/>
                            <path d="M24 14v10l7 7"/>
                        </svg>
                    </div>
                    <h3>Clarity</h3>
                    <p>What the system is doing and why</p>
                </div>
                <div class="pillar reveal-up" data-delay="2">
                    <div class="pillar-icon">
                        <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M24 4L6 14v20l18 10 18-10V14L24 4z"/>
                            <path d="M24 24v20"/>
                            <path d="M6 14l18 10 18-10"/>
                        </svg>
                    </div>
                    <h3>Control</h3>
                    <p>Where decisions reside and who owns them</p>
                </div>
                <div class="pillar reveal-up" data-delay="3">
                    <div class="pillar-icon">
                        <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M20 6h8v8h-8zM6 34h8v8H6zM34 34h8v8h-8z"/>
                            <path d="M24 14v8M10 34v-8h28v8"/>
                        </svg>
                    </div>
                    <h3>Trust</h3>
                    <p>Confidence that scales with capability</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Statement -->
    <section class="genai-section genai-statement">
        <div class="statement-wrapper">
            <blockquote class="featured-quote featured-quote--teal reveal-text">
                <p class="quote-setup">GenAI experience design is not about making AI feel seamless.</p>
                <p class="quote-emphasis">It is about making change manageable.</p>
            </blockquote>
            <p class="genai-statement-close reveal-text" data-delay="1">
                When systems, services, and experiences are designed together, organizations can adopt AI without losing sight of how work actually gets done.
            </p>
        </div>
    </section>

    <!-- CTA -->
    <section class="genai-cta">
        <div class="genai-cta-code">
            <pre><code><span class="code-keyword">await</span> <span class="code-func">designWithIntent</span>({
  <span class="code-prop">systems</span>: <span class="code-string">"aligned"</span>,
  <span class="code-prop">services</span>: <span class="code-string">"designed"</span>,
  <span class="code-prop">change</span>: <span class="code-string">"manageable"</span>
});</code></pre>
        </div>
        <div class="container genai-cta-content">
            <h2 class="reveal-text">Ready to design AI experiences with intent?</h2>
            <p class="reveal-text" data-delay="1">Let's discuss how GenAI experience design can help your organization adopt AI responsibly.</p>
            <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-primary btn-lg reveal-up" data-delay="2">Start a Conversation</a>
        </div>
    </section>

</main>

<?php get_footer(); ?>
