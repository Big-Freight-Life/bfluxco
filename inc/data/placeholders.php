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
            'label'    => 'Healthcare SaaS',
            'title'    => 'Seamless Salesforce Migration',
            'excerpt'  => 'Designed for clarity. Built for adoption. A unified platform transformation for AtlasMed Solutions.',
            'year'     => '2024',
            'image'    => 'brand',
            'link'     => '/case-study-style-1/',
            'gradient' => 'linear-gradient(135deg, #0ea5e9, #0284c7)',
        ),
        array(
            'label'    => 'Salesforce AppExchange',
            'title'    => 'Hyland OnBase Integration',
            'excerpt'  => 'Enterprise document management meets Salesforce. Drag-and-drop content management with automatic indexing across Financial Services, Healthcare, and Retail.',
            'year'     => '2024',
            'image'    => 'product',
            'link'     => '/hyland-onbase-salesforce-integration/',
            'gradient' => 'linear-gradient(135deg, #7c3aed, #4f46e5)',
        ),
        array(
            'label'    => 'Enterprise Integration',
            'title'    => 'Hyland for Workday',
            'excerpt'  => 'Unified content management embedded directly into Workday screens. No middleware. No custom code.',
            'year'     => '2024',
            'image'    => 'system',
            'link'     => '/work/case-studies/hyland-for-workday-integration/',
            'gradient' => 'linear-gradient(180deg, #0f172a, #1e293b)',
        ),
        array(
            'label'    => 'Workshop',
            'title'    => 'Strategic Alignment',
            'excerpt'  => 'Facilitating executive workshops to align product vision with organizational goals.',
            'year'     => '2023',
            'image'    => 'workshop',
            'link'     => '#',
            'gradient' => 'linear-gradient(135deg, #10b981, #059669)',
        ),
        array(
            'label'    => 'Research',
            'title'    => 'Discovery & Synthesis',
            'excerpt'  => 'Conducting foundational research to inform the next generation of healthcare tools.',
            'year'     => '2023',
            'image'    => 'research',
            'link'     => '#',
            'gradient' => 'linear-gradient(135deg, #f59e0b, #d97706)',
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
