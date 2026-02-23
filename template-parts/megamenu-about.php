<?php
/**
 * Template part for About mega menu
 *
 * @package BFLUXCO
 */
?>
<!-- Mega Menu: About -->
<div class="megamenu" id="megamenu-about" role="navigation" aria-label="<?php esc_attr_e('About Navigation', 'bfluxco'); ?>">
    <div class="megamenu-backdrop"></div>
    <div class="megamenu-container">
        <div class="megamenu-inner">
            <!-- Left Panel: Navigation Index -->
            <div class="megamenu-left">
                <h2 class="megamenu-section-title"><?php esc_html_e('About', 'bfluxco'); ?></h2>
                <ul class="megamenu-nav" role="menu">
                    <li class="megamenu-nav-item active" data-panel="overview" role="menuitem">
                        <a href="<?php echo esc_url(home_url('/about')); ?>">
                            <span class="megamenu-nav-text"><?php esc_html_e('Overview', 'bfluxco'); ?></span>
                            <svg class="megamenu-nav-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 18l6-6-6-6"/>
                            </svg>
                        </a>
                    </li>
                    <li class="megamenu-nav-item" data-panel="bfl" role="menuitem">
                        <a href="<?php echo esc_url(home_url('/about/bfl')); ?>">
                            <span class="megamenu-nav-text"><?php esc_html_e('Big Freight Life', 'bfluxco'); ?></span>
                            <svg class="megamenu-nav-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 18l6-6-6-6"/>
                            </svg>
                        </a>
                    </li>
                    <li class="megamenu-nav-item" data-panel="ray" role="menuitem">
                        <a href="<?php echo esc_url(home_url('/about/ray')); ?>">
                            <span class="megamenu-nav-text"><?php esc_html_e('Ray Butler', 'bfluxco'); ?></span>
                            <svg class="megamenu-nav-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 18l6-6-6-6"/>
                            </svg>
                        </a>
                    </li>
                    <li class="megamenu-nav-item" data-panel="contact" role="menuitem">
                        <a href="<?php echo esc_url(home_url('/contact')); ?>">
                            <span class="megamenu-nav-text"><?php esc_html_e('Contact', 'bfluxco'); ?></span>
                            <svg class="megamenu-nav-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 18l6-6-6-6"/>
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Right Panel: Contextual Content -->
            <div class="megamenu-right">
                <!-- Overview Panel -->
                <div class="megamenu-panel active" data-panel="overview">
                    <div class="megamenu-panel-image">
                        <div class="megamenu-image-placeholder gradient-about"></div>
                    </div>
                    <div class="megamenu-panel-content">
                        <h3 class="megamenu-panel-title"><?php esc_html_e('About BFLUX', 'bfluxco'); ?></h3>
                        <p class="megamenu-panel-desc"><?php esc_html_e('Discover the story, philosophy, and people behind BFLUX. Learn what drives our work and approach.', 'bfluxco'); ?></p>
                        <a href="<?php echo esc_url(home_url('/about')); ?>" class="btn btn-primary btn-sm">
                            <?php esc_html_e('Learn more', 'bfluxco'); ?>
                        </a>
                    </div>
                </div>

                <!-- Big Freight Life Panel -->
                <div class="megamenu-panel" data-panel="bfl">
                    <div class="megamenu-panel-image">
                        <div class="megamenu-image-placeholder gradient-bfl"></div>
                    </div>
                    <div class="megamenu-panel-content">
                        <h3 class="megamenu-panel-title"><?php esc_html_e('Big Freight Life', 'bfluxco'); ?></h3>
                        <p class="megamenu-panel-desc"><?php esc_html_e('The creative studio and practice behind BFLUX. Learn about our mission, values, and approach.', 'bfluxco'); ?></p>
                        <a href="<?php echo esc_url(home_url('/about/bfl')); ?>" class="btn btn-primary btn-sm">
                            <?php esc_html_e('About the studio', 'bfluxco'); ?>
                        </a>
                    </div>
                </div>

                <!-- Ray Butler Panel -->
                <div class="megamenu-panel" data-panel="ray">
                    <div class="megamenu-panel-image">
                        <div class="megamenu-image-placeholder gradient-ray"></div>
                    </div>
                    <div class="megamenu-panel-content">
                        <h3 class="megamenu-panel-title"><?php esc_html_e('Ray Butler', 'bfluxco'); ?></h3>
                        <p class="megamenu-panel-desc"><?php esc_html_e('Design strategist with years of experience helping organizations navigate complexity and create meaningful solutions.', 'bfluxco'); ?></p>
                        <a href="<?php echo esc_url(home_url('/about/ray')); ?>" class="btn btn-primary btn-sm">
                            <?php esc_html_e('Meet Ray', 'bfluxco'); ?>
                        </a>
                    </div>
                </div>

                <!-- Contact Panel -->
                <div class="megamenu-panel" data-panel="contact">
                    <div class="megamenu-panel-image">
                        <div class="megamenu-image-placeholder gradient-contact"></div>
                    </div>
                    <div class="megamenu-panel-content">
                        <h3 class="megamenu-panel-title"><?php esc_html_e('Get in Touch', 'bfluxco'); ?></h3>
                        <p class="megamenu-panel-desc"><?php esc_html_e("Have a project in mind or want to explore working together? Let's start a conversation.", 'bfluxco'); ?></p>
                        <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-primary btn-sm">
                            <?php esc_html_e('Contact us', 'bfluxco'); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- #megamenu-about -->
