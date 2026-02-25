<?php
/**
 * BFLUXCO Placeholder Data
 *
 * Centralized placeholder content for development and fallback display.
 * This file contains sample data used when no real content exists.
 *
 * @package BFLUXCO
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get placeholder case studies
 *
 * @return array Array of placeholder case study data
 */
function bfluxco_get_placeholder_case_studies() {
    return array(
        array(
            'label'    => 'Creative Services',
            'title'    => 'Designing a Portfolio When Anyone Can Build Anything',
            'excerpt'  => 'In a world where generative AI can produce websites in seconds, how do you make a portfolio that actually means something?',
            'year'     => '2025',
            'image_url' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=800&q=80',
            'link'     => '/case-study-style-1/',
            'gradient' => 'linear-gradient(135deg, #0ea5e9, #0284c7)',
        ),
        array(
            'label'    => 'Enterprise Software',
            'title'    => 'Hyland OnBase Integration',
            'excerpt'  => 'Enterprise document management meets Salesforce. Drag-and-drop content management with automatic indexing.',
            'year'     => '2025',
            'image_url' => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=800&q=80',
            'link'     => '/hyland-onbase-salesforce-integration/',
            'gradient' => 'linear-gradient(135deg, #7c3aed, #4f46e5)',
        ),
        array(
            'label'    => 'Enterprise Software',
            'title'    => 'Hyland for Workday Integration',
            'excerpt'  => 'Unified content management embedded directly into Workday screens. No middleware. No custom code.',
            'year'     => '2025',
            'image_url' => '',
            'link'     => '/work/case-studies/hyland-for-workday-integration/',
            'gradient' => 'linear-gradient(180deg, #0f172a, #1e293b)',
        ),
        array(
            'label'    => 'Case Study',
            'title'    => 'Salesforce Migration Editorial',
            'excerpt'  => 'Designed for clarity. Built for adoption. A unified platform transformation.',
            'year'     => '2025',
            'image_url' => 'https://images.unsplash.com/photo-1553877522-43269d4ea984?w=800&q=80',
            'link'     => '#',
            'gradient' => 'linear-gradient(135deg, #10b981, #059669)',
        ),
    );
}

/**
 * Get placeholder blog posts
 *
 * @return array Array of placeholder blog post data
 */
function bfluxco_get_placeholder_blog_posts() {
    return array(
        array(
            'title'    => 'Design Systems at Scale',
            'date'     => 'Dec 10, 2024',
            'category' => 'Design',
            'link'     => '#',
        ),
        array(
            'title'    => 'The Future of Product Strategy',
            'date'     => 'Dec 5, 2024',
            'category' => 'Strategy',
            'link'     => '#',
        ),
        array(
            'title'    => 'Building Better Workshops',
            'date'     => 'Nov 28, 2024',
            'category' => 'Process',
            'link'     => '#',
        ),
    );
}

/**
 * Get placeholder services
 *
 * @return array Array of placeholder service data
 */
function bfluxco_get_placeholder_services() {
    return array(
        array(
            'title'       => 'Clarity before automation',
            'description' => 'We help teams understand their system before adding intelligence—surfacing assumptions, constraints, and hidden dependencies.',
            'icon'        => 'layout',
            'link'        => '/work/methodology',
        ),
        array(
            'title'       => 'Decision-ready systems',
            'description' => 'We design experiences and architectures that make consequences visible, so teams can act with confidence, not guesswork.',
            'icon'        => 'arrow-right',
            'link'        => '/work/methodology',
        ),
        array(
            'title'       => 'Human–AI collaboration',
            'description' => 'We design agentic systems that know when to act, when to assist, and when to defer to human judgment.',
            'icon'        => 'users',
            'link'        => '/work/methodology',
        ),
        array(
            'title'       => 'Scalability without fragility',
            'description' => 'We design systems that evolve without breaking—across workflows, roles, and time.',
            'icon'        => 'layers',
            'link'        => '/work/methodology',
        ),
    );
}

/**
 * Get industry carousel items
 *
 * @return array Array of industry names for the logo carousel
 */
function bfluxco_get_industry_carousel_items() {
    return array(
        'FINANCE',
        'HEALTHCARE',
        'HUMAN RESOURCES',
        'TECHNOLOGY',
        'RETAIL',
        'MANUFACTURING',
        'LOGISTICS',
        'EDUCATION',
        'GEN AI',
        'INTEGRATIONS',
    );
}
