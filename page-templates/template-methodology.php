<?php
/**
 * Template Name: Methodology
 * Template Post Type: page
 *
 * This template displays the Methodology page.
 * URL: /work/methodology
 *
 * HOW TO USE:
 * 1. Create a new page in WordPress called "Methodology"
 * 2. Set the page slug to "methodology"
 * 3. Set the parent page to "The Work"
 * 4. In the Page Attributes section, select "Methodology" as the template
 * 5. Add content about your methodology in the page editor
 *
 * @package BFLUXCO
 */

get_header();
?>

<main id="main-content" class="site-main">

    <?php
    get_template_part('template-parts/page-header', null, array(
        'description' => __('A proven approach to solving complex business challenges through strategic design thinking.', 'bfluxco'),
        'show_animations' => false,
        'use_excerpt' => true,
    ));
    ?>

    <!-- Methodology Overview -->
    <section class="section">
        <div class="container">
            <div class="max-w-3xl mx-auto text-center mb-12">
                <h2><?php esc_html_e('How I Work', 'bfluxco'); ?></h2>
                <p class="text-gray-600">
                    <?php esc_html_e('Every project is unique, but my approach follows a proven framework that ensures we understand the problem deeply before jumping to solutions.', 'bfluxco'); ?>
                </p>
            </div>

            <!-- Process Steps -->
            <div class="methodology-steps">

                <!-- Step 1 -->
                <div class="methodology-step grid grid-2 items-center gap-8 mb-12">
                    <div class="step-content">
                        <div class="step-number text-primary text-base font-semibold mb-2">01</div>
                        <h3><?php esc_html_e('Discover', 'bfluxco'); ?></h3>
                        <p class="text-gray-600">
                            <?php esc_html_e('We begin by deeply understanding your challenge, context, and constraints. This involves stakeholder interviews, research, and analysis to ensure we\'re solving the right problem.', 'bfluxco'); ?>
                        </p>
                        <ul class="mt-4 text-gray-600" style="list-style: disc; padding-left: 1.5rem;">
                            <li><?php esc_html_e('Stakeholder interviews', 'bfluxco'); ?></li>
                            <li><?php esc_html_e('Research & analysis', 'bfluxco'); ?></li>
                            <li><?php esc_html_e('Problem definition', 'bfluxco'); ?></li>
                        </ul>
                    </div>
                    <div class="step-image" style="background: var(--color-gray-200); aspect-ratio: 4/3; border-radius: var(--radius-xl);"></div>
                </div>

                <!-- Step 2 -->
                <div class="methodology-step grid grid-2 items-center gap-8 mb-12">
                    <div class="step-image hide-mobile" style="background: var(--color-gray-200); aspect-ratio: 4/3; border-radius: var(--radius-xl);"></div>
                    <div class="step-content">
                        <div class="step-number text-primary text-base font-semibold mb-2">02</div>
                        <h3><?php esc_html_e('Define', 'bfluxco'); ?></h3>
                        <p class="text-gray-600">
                            <?php esc_html_e('With a clear understanding of the problem, we define success criteria and explore potential directions. This phase ensures alignment before committing to a direction.', 'bfluxco'); ?>
                        </p>
                        <ul class="mt-4 text-gray-600" style="list-style: disc; padding-left: 1.5rem;">
                            <li><?php esc_html_e('Success criteria', 'bfluxco'); ?></li>
                            <li><?php esc_html_e('Direction exploration', 'bfluxco'); ?></li>
                            <li><?php esc_html_e('Stakeholder alignment', 'bfluxco'); ?></li>
                        </ul>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="methodology-step grid grid-2 items-center gap-8 mb-12">
                    <div class="step-content">
                        <div class="step-number text-primary text-base font-semibold mb-2">03</div>
                        <h3><?php esc_html_e('Design', 'bfluxco'); ?></h3>
                        <p class="text-gray-600">
                            <?php esc_html_e('This is where ideas take shape. Through iterative design and prototyping, we develop solutions that address the core challenge while meeting business objectives.', 'bfluxco'); ?>
                        </p>
                        <ul class="mt-4 text-gray-600" style="list-style: disc; padding-left: 1.5rem;">
                            <li><?php esc_html_e('Ideation & concepts', 'bfluxco'); ?></li>
                            <li><?php esc_html_e('Prototyping', 'bfluxco'); ?></li>
                            <li><?php esc_html_e('Iterative refinement', 'bfluxco'); ?></li>
                        </ul>
                    </div>
                    <div class="step-image" style="background: var(--color-gray-200); aspect-ratio: 4/3; border-radius: var(--radius-xl);"></div>
                </div>

                <!-- Step 4 -->
                <div class="methodology-step grid grid-2 items-center gap-8">
                    <div class="step-image hide-mobile" style="background: var(--color-gray-200); aspect-ratio: 4/3; border-radius: var(--radius-xl);"></div>
                    <div class="step-content">
                        <div class="step-number text-primary text-base font-semibold mb-2">04</div>
                        <h3><?php esc_html_e('Deliver', 'bfluxco'); ?></h3>
                        <p class="text-gray-600">
                            <?php esc_html_e('The final phase focuses on implementation support and knowledge transfer. I ensure your team has everything needed to move forward successfully.', 'bfluxco'); ?>
                        </p>
                        <ul class="mt-4 text-gray-600" style="list-style: disc; padding-left: 1.5rem;">
                            <li><?php esc_html_e('Final deliverables', 'bfluxco'); ?></li>
                            <li><?php esc_html_e('Implementation support', 'bfluxco'); ?></li>
                            <li><?php esc_html_e('Knowledge transfer', 'bfluxco'); ?></li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </section><!-- Methodology Overview -->

    <!-- Page Content (if any additional content) -->
    <?php
    while (have_posts()) : the_post();
        $content = get_the_content();
        if (!empty($content)) :
    ?>
        <section class="section page-content bg-gray-50">
            <div class="container">
                <div class="max-w-3xl mx-auto">
                    <?php the_content(); ?>
                </div>
            </div>
        </section>
    <?php
        endif;
    endwhile;
    ?>

    <!-- Principles Section -->
    <section class="section bg-gray-50">
        <div class="container">
            <h2 class="text-center mb-8"><?php esc_html_e('Guiding Principles', 'bfluxco'); ?></h2>

            <div class="grid grid-3">

                <div class="principle-card p-6 bg-white rounded-lg">
                    <h3 class="text-lg font-semibold mb-2"><?php esc_html_e('Clarity Over Complexity', 'bfluxco'); ?></h3>
                    <p class="text-gray-600">
                        <?php esc_html_e('Simple solutions that are understood and adopted beat complex solutions that gather dust.', 'bfluxco'); ?>
                    </p>
                </div>

                <div class="principle-card p-6 bg-white rounded-lg">
                    <h3 class="text-lg font-semibold mb-2"><?php esc_html_e('Collaboration Is Key', 'bfluxco'); ?></h3>
                    <p class="text-gray-600">
                        <?php esc_html_e('The best solutions emerge when diverse perspectives come together with a shared purpose.', 'bfluxco'); ?>
                    </p>
                </div>

                <div class="principle-card p-6 bg-white rounded-lg">
                    <h3 class="text-lg font-semibold mb-2"><?php esc_html_e('Progress Over Perfection', 'bfluxco'); ?></h3>
                    <p class="text-gray-600">
                        <?php esc_html_e('Iteration and learning beat waiting for the perfect solution that never ships.', 'bfluxco'); ?>
                    </p>
                </div>

            </div>
        </div>
    </section><!-- Principles Section -->

    <!-- CTA Section -->
    <section class="section text-center">
        <div class="container">
            <h2><?php esc_html_e('Ready to Apply This Approach?', 'bfluxco'); ?></h2>
            <p class="text-gray-600 max-w-2xl mx-auto mb-6">
                <?php esc_html_e("Let's discuss how this methodology can be applied to your specific challenges.", 'bfluxco'); ?>
            </p>
            <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-primary btn-lg">
                <?php esc_html_e('Start a Conversation', 'bfluxco'); ?>
            </a>
        </div>
    </section><!-- CTA -->

</main><!-- #main-content -->

<?php
get_footer();
