<?php
/**
 * Chatbot Knowledge Base
 *
 * This file returns the knowledge context for the AI chatbot.
 * Add information about BFLUXCO that the bot should know.
 *
 * @package BFLUXCO
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Return the knowledge base content for the chatbot system prompt.
 * This content helps the AI understand BFLUXCO and answer visitor questions accurately.
 *
 * To update: Simply edit the text below. The chatbot will use this information
 * when responding to visitors.
 */
return <<<'KNOWLEDGE'
## About Big Freight Life

Big Freight Life is a GenAI experience design company led by Ray Butler, GenAI Experience Architect.

## What We Do

We design scalable systems that make complexity visible and decisions confident. Our work spans:

- **Experience Design**: Creating interfaces and workflows that help professionals navigate complex decisions
- **System Architecture**: Building systems that encode good decisions and reduce complexity
- **Applied Generative AI**: Designing and implementing AI-powered solutions that augment human capability

## Our Philosophy

"People are our secret weapon."

We believe:
- AI is not a feature. Design is not decoration.
- Behind every system are professionals navigating trade-offs, exceptions, and consequences
- Technology should serve people, not the other way around
- Understanding how people think, decide, and behave shapes every interaction with technology

## About Ray Butler

Ray Butler is a GenAI Experience Architect who designs and builds intelligent systems where human judgment, system behavior, and AI capabilities align.

His work is grounded in experience design and AI engineering for real-world complexity.

## Services

Big Freight Life offers consulting and implementation services in:
- Experience design for complex systems
- AI strategy and implementation
- System architecture design
- Workshop facilitation

## How to Work With Us

For project inquiries, pricing, or to discuss working together, the best approach is to:
1. Schedule a call with Ray
2. Or email directly to discuss your specific needs

## Location & Contact

Big Freight Life is based in the United States. For inquiries, visitors can use the contact form on the website or schedule a call directly.

---
Note: For specific pricing, custom project scopes, or detailed technical requirements, please suggest that visitors connect with Ray directly.
KNOWLEDGE;
