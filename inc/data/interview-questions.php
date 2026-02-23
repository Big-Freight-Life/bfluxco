<?php
/**
 * Interview Raybot Questions Data
 *
 * Curated Q&A content for the Interview Raybot feature.
 * Each question has a scripted answer and optional follow-up prompt.
 *
 * @package BFLUXCO
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Return the interview questions array
 *
 * Categories:
 * - background: Professional experience and expertise
 * - methodology: Design approach and process
 * - philosophy: Beliefs and principles
 * - collaboration: Working style and team dynamics
 * - results: Outcomes and impact
 *
 * @return array Interview questions with answers and follow-up prompts.
 */
return array(
    'q1' => array(
        'id'       => 'q1',
        'category' => 'background',
        'text'     => 'What is your experience with GenAI and experience design?',
        'answer'   => array(
            'text'            => "I've spent over 15 years at the intersection of technology and human experience design, with the last several years focused specifically on generative AI. My background combines enterprise UX leadership at companies like Salesforce with hands-on technical implementation. What makes my approach unique is that I don't just design interfaces for AI systems - I understand the underlying models, their capabilities, and their limitations. This allows me to create experiences that leverage AI's strengths while gracefully handling its constraints. I've led teams building conversational interfaces, AI-powered creative tools, and enterprise automation systems that have transformed how organizations work.",
            'followup_prompt' => 'Would you like to know more about a specific project or domain?',
        ),
    ),

    'q2' => array(
        'id'       => 'q2',
        'category' => 'methodology',
        'text'     => 'How do you approach designing AI-powered experiences?',
        'answer'   => array(
            'text'            => "My methodology centers on what I call 'human-AI collaboration design.' Rather than treating AI as a black box, I map out the entire interaction loop between human intent, AI processing, and feedback mechanisms. I start by deeply understanding the user's mental model - what do they expect the AI to do, and how do they expect to communicate with it? From there, I design transparent interfaces that help users understand when AI is working, what it's doing, and how to guide it toward better results. This includes progressive disclosure of AI capabilities, clear confidence indicators, and intuitive correction mechanisms. The goal is always to amplify human capability, not replace human judgment.",
            'followup_prompt' => 'Should I walk you through a specific design framework I use?',
        ),
    ),

    'q3' => array(
        'id'       => 'q3',
        'category' => 'philosophy',
        'text'     => 'What principles guide your work with AI technologies?',
        'answer'   => array(
            'text'            => "Three core principles guide everything I do. First, transparency over magic - users should understand what AI can and cannot do, and never feel deceived by the technology. Second, augmentation over automation - AI should enhance human creativity and decision-making, not circumvent it. Third, graceful degradation - when AI fails, and it will, the experience should fail gracefully with clear pathways for human intervention. I also believe strongly in ethical AI design: considering bias, ensuring accessibility, and building systems that respect user privacy and agency. These aren't just nice-to-haves; they're fundamental to creating AI experiences that people will actually trust and use.",
            'followup_prompt' => 'Would you like to discuss how these principles apply to a specific challenge?',
        ),
    ),

    'q4' => array(
        'id'       => 'q4',
        'category' => 'collaboration',
        'text'     => 'How do you work with teams and stakeholders on AI projects?',
        'answer'   => array(
            'text'            => "AI projects require a unique collaborative approach because they involve so many disciplines - data science, engineering, product, design, legal, and ethics. I act as a translator between these worlds, helping technical teams understand user needs and helping business stakeholders understand technical constraints. I've found that workshops work particularly well for AI projects - bringing together diverse perspectives to explore possibilities and identify risks early. I also advocate for iterative prototyping with real AI outputs, not mockups, so everyone can experience the variability and edge cases inherent in AI systems. This builds shared understanding and leads to more robust solutions.",
            'followup_prompt' => 'Want to hear about my workshop facilitation approach?',
        ),
    ),

    'q5' => array(
        'id'       => 'q5',
        'category' => 'results',
        'text'     => 'What kind of outcomes have you achieved with AI experience design?',
        'answer'   => array(
            'text'            => "The outcomes I'm most proud of combine measurable business impact with genuine user delight. At the enterprise level, I've designed AI systems that reduced customer service resolution times by 40% while improving satisfaction scores - proving that efficiency and experience can go together. I've also led creative AI tools that unlocked entirely new workflows for designers and content creators, measurably accelerating their work while maintaining creative control. Beyond metrics, I value the feedback from users who say the AI feels like a helpful collaborator rather than a frustrating tool. That's the real success - when people actually want to use AI, rather than having to use it. Building that trust and delight is what drives my work.",
            'followup_prompt' => null, // Last question - no follow-up
        ),
    ),
);
