<?php
/**
 * Template part for Services mega menu
 *
 * @package BFLUXCO
 */
?>
<!-- Mega Menu: Services -->
<div class="megamenu" id="megamenu-services" role="navigation" aria-label="<?php esc_attr_e('Services Navigation', 'bfluxco'); ?>">
    <div class="megamenu-backdrop"></div>
    <div class="megamenu-container">
        <div class="megamenu-inner">
            <!-- Left Panel: Navigation Index -->
            <div class="megamenu-left">
                <h2 class="megamenu-section-title"><?php esc_html_e('Services', 'bfluxco'); ?></h2>
                <ul class="megamenu-nav" role="menu">
                    <li class="megamenu-nav-item active" data-panel="experience-design" role="menuitem">
                        <a href="<?php echo esc_url(home_url('/services/experience-design')); ?>">
                            <span class="megamenu-nav-text"><?php esc_html_e('Experience Design', 'bfluxco'); ?></span>
                            <svg class="megamenu-nav-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 18l6-6-6-6"/>
                            </svg>
                        </a>
                    </li>
                    <li class="megamenu-nav-item" data-panel="gen-ai" role="menuitem">
                        <a href="<?php echo esc_url(home_url('/services/genai-experience-architecture')); ?>">
                            <span class="megamenu-nav-text"><?php esc_html_e('GenAI Experience Architecture', 'bfluxco'); ?></span>
                            <svg class="megamenu-nav-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 18l6-6-6-6"/>
                            </svg>
                        </a>
                    </li>
                    <li class="megamenu-nav-item" data-panel="customer-research" role="menuitem">
                        <a href="<?php echo esc_url(home_url('/services/customer-research')); ?>">
                            <span class="megamenu-nav-text"><?php esc_html_e('Customer Research', 'bfluxco'); ?></span>
                            <svg class="megamenu-nav-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 18l6-6-6-6"/>
                            </svg>
                        </a>
                    </li>
                    <li class="megamenu-nav-item" data-panel="digital-twins" role="menuitem">
                        <a href="<?php echo esc_url(home_url('/services/digital-twins')); ?>">
                            <span class="megamenu-nav-text"><?php esc_html_e('Digital Twins', 'bfluxco'); ?></span>
                            <svg class="megamenu-nav-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 18l6-6-6-6"/>
                            </svg>
                        </a>
                    </li>
                    <li class="megamenu-nav-item" data-panel="conversation-design" role="menuitem">
                        <a href="<?php echo esc_url(home_url('/services/conversation-design')); ?>">
                            <span class="megamenu-nav-text"><?php esc_html_e('Conversation Design', 'bfluxco'); ?></span>
                            <svg class="megamenu-nav-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 18l6-6-6-6"/>
                            </svg>
                        </a>
                    </li>
                    <li class="megamenu-nav-item" data-panel="workshops" role="menuitem">
                        <a href="<?php echo esc_url(home_url('/services/workshops')); ?>">
                            <span class="megamenu-nav-text"><?php esc_html_e('Workshops', 'bfluxco'); ?></span>
                            <svg class="megamenu-nav-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 18l6-6-6-6"/>
                            </svg>
                        </a>
                    </li>
                    <li class="megamenu-nav-item" data-panel="team-transformation" role="menuitem">
                        <a href="<?php echo esc_url(home_url('/transformation')); ?>">
                            <span class="megamenu-nav-text"><?php esc_html_e('Team Transformation', 'bfluxco'); ?></span>
                            <svg class="megamenu-nav-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 18l6-6-6-6"/>
                            </svg>
                        </a>
                    </li>
                </ul>
                <a href="<?php echo esc_url(home_url('/services')); ?>" class="megamenu-view-all">
                    <?php esc_html_e('View all services', 'bfluxco'); ?>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            <!-- Right Panel: Contextual Content -->
            <div class="megamenu-right">
                <!-- Experience Design Panel -->
                <div class="megamenu-panel active" data-panel="experience-design">
                    <div class="megamenu-panel-image">
                        <div class="megamenu-image-placeholder gradient-experience-design"></div>
                    </div>
                    <div class="megamenu-panel-content">
                        <h3 class="megamenu-panel-title"><?php esc_html_e('Experience Design', 'bfluxco'); ?></h3>
                        <p class="megamenu-panel-desc"><?php esc_html_e('End-to-end experience design that transforms how customers interact with your brand across every touchpoint.', 'bfluxco'); ?></p>
                        <a href="<?php echo esc_url(home_url('/services/experience-design')); ?>" class="btn btn-primary btn-sm">
                            <?php esc_html_e('Learn more', 'bfluxco'); ?>
                        </a>
                    </div>
                </div>

                <!-- Gen AI Architecture Panel -->
                <div class="megamenu-panel" data-panel="gen-ai">
                    <div class="megamenu-panel-image">
                        <div class="megamenu-image-placeholder gradient-gen-ai"></div>
                    </div>
                    <div class="megamenu-panel-content">
                        <h3 class="megamenu-panel-title"><?php esc_html_e('GenAI Experience Architecture', 'bfluxco'); ?></h3>
                        <p class="megamenu-panel-desc"><?php esc_html_e('Strategic AI implementation that integrates generative AI into your products and workflows meaningfully.', 'bfluxco'); ?></p>
                        <a href="<?php echo esc_url(home_url('/services/genai-experience-architecture')); ?>" class="btn btn-primary btn-sm">
                            <?php esc_html_e('Learn more', 'bfluxco'); ?>
                        </a>
                    </div>
                </div>

                <!-- Customer Research Panel -->
                <div class="megamenu-panel" data-panel="customer-research">
                    <div class="megamenu-panel-image">
                        <div class="megamenu-image-placeholder gradient-customer-research"></div>
                    </div>
                    <div class="megamenu-panel-content">
                        <h3 class="megamenu-panel-title"><?php esc_html_e('Customer Research', 'bfluxco'); ?></h3>
                        <p class="megamenu-panel-desc"><?php esc_html_e('Deep customer insights through qualitative and quantitative research that inform strategic decisions.', 'bfluxco'); ?></p>
                        <a href="<?php echo esc_url(home_url('/services/customer-research')); ?>" class="btn btn-primary btn-sm">
                            <?php esc_html_e('Learn more', 'bfluxco'); ?>
                        </a>
                    </div>
                </div>

                <!-- Digital Twins Panel -->
                <div class="megamenu-panel" data-panel="digital-twins">
                    <div class="megamenu-panel-image">
                        <div class="megamenu-image-placeholder gradient-digital-twins"></div>
                    </div>
                    <div class="megamenu-panel-content">
                        <h3 class="megamenu-panel-title"><?php esc_html_e('Digital Twins', 'bfluxco'); ?></h3>
                        <p class="megamenu-panel-desc"><?php esc_html_e('Virtual replicas of physical systems that enable simulation, monitoring, and optimization at scale.', 'bfluxco'); ?></p>
                        <a href="<?php echo esc_url(home_url('/services/digital-twins')); ?>" class="btn btn-primary btn-sm">
                            <?php esc_html_e('Learn more', 'bfluxco'); ?>
                        </a>
                    </div>
                </div>

                <!-- Conversation Design Panel -->
                <div class="megamenu-panel" data-panel="conversation-design">
                    <div class="megamenu-panel-image">
                        <div class="megamenu-image-placeholder gradient-conversation-design"></div>
                    </div>
                    <div class="megamenu-panel-content">
                        <h3 class="megamenu-panel-title"><?php esc_html_e('Conversation Design', 'bfluxco'); ?></h3>
                        <p class="megamenu-panel-desc"><?php esc_html_e('Human-centered conversational experiences for chatbots, voice assistants, and AI-powered interfaces.', 'bfluxco'); ?></p>
                        <a href="<?php echo esc_url(home_url('/services/conversation-design')); ?>" class="btn btn-primary btn-sm">
                            <?php esc_html_e('Learn more', 'bfluxco'); ?>
                        </a>
                    </div>
                </div>

                <!-- Workshops Panel -->
                <div class="megamenu-panel" data-panel="workshops">
                    <div class="megamenu-panel-image">
                        <div class="megamenu-image-placeholder gradient-workshops"></div>
                    </div>
                    <div class="megamenu-panel-content">
                        <h3 class="megamenu-panel-title"><?php esc_html_e('Workshops', 'bfluxco'); ?></h3>
                        <p class="megamenu-panel-desc"><?php esc_html_e('Collaborative sessions that align teams, accelerate decision-making, and unlock strategic clarity.', 'bfluxco'); ?></p>
                        <a href="<?php echo esc_url(home_url('/services/workshops')); ?>" class="btn btn-primary btn-sm">
                            <?php esc_html_e('Explore workshops', 'bfluxco'); ?>
                        </a>
                    </div>
                </div>

                <!-- Team Transformation Panel -->
                <div class="megamenu-panel" data-panel="team-transformation">
                    <div class="megamenu-panel-image">
                        <div class="megamenu-image-placeholder gradient-team-transformation"></div>
                    </div>
                    <div class="megamenu-panel-content">
                        <h3 class="megamenu-panel-title"><?php esc_html_e('Team Transformation', 'bfluxco'); ?></h3>
                        <p class="megamenu-panel-desc"><?php esc_html_e('Build lasting capabilities through workshops, coaching, and embedded partnerships that empower your team.', 'bfluxco'); ?></p>
                        <a href="<?php echo esc_url(home_url('/transformation')); ?>" class="btn btn-primary btn-sm">
                            <?php esc_html_e('Learn more', 'bfluxco'); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- #megamenu-services -->
