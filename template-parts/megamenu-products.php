<?php
/**
 * Template part for Products mega menu
 *
 * @package BFLUXCO
 */
?>
<!-- Mega Menu: Products -->
<div class="megamenu" id="megamenu-products" role="navigation" aria-label="<?php esc_attr_e('Products Navigation', 'bfluxco'); ?>">
    <div class="megamenu-backdrop"></div>
    <div class="megamenu-container">
        <div class="megamenu-inner">
            <!-- Left Panel: Navigation Index -->
            <div class="megamenu-left">
                <h2 class="megamenu-section-title"><?php esc_html_e('Products', 'bfluxco'); ?></h2>
                <ul class="megamenu-nav" role="menu">
                    <li class="megamenu-nav-item active" data-panel="low-ox-life" role="menuitem">
                        <a href="<?php echo esc_url(home_url('/products/low-ox-life')); ?>">
                            <span class="megamenu-nav-text"><?php esc_html_e('Low Ox Life', 'bfluxco'); ?></span>
                            <svg class="megamenu-nav-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 18l6-6-6-6"/>
                            </svg>
                        </a>
                    </li>
                    <li class="megamenu-nav-item" data-panel="recipe-calculator" role="menuitem">
                        <a href="<?php echo esc_url(home_url('/products/recipe-calculator')); ?>">
                            <span class="megamenu-nav-text"><?php esc_html_e('Recipe Calculator', 'bfluxco'); ?></span>
                            <svg class="megamenu-nav-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 18l6-6-6-6"/>
                            </svg>
                        </a>
                    </li>
                    <li class="megamenu-nav-item" data-panel="legal" role="menuitem">
                        <a href="<?php echo esc_url(home_url('/legal')); ?>">
                            <span class="megamenu-nav-text"><?php esc_html_e('Legal', 'bfluxco'); ?></span>
                            <svg class="megamenu-nav-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 18l6-6-6-6"/>
                            </svg>
                        </a>
                    </li>
                </ul>
                <a href="<?php echo esc_url(home_url('/products')); ?>" class="megamenu-view-all">
                    <?php esc_html_e('View all products', 'bfluxco'); ?>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            <!-- Right Panel: Contextual Content -->
            <div class="megamenu-right">
                <!-- Low Ox Life Panel -->
                <div class="megamenu-panel active" data-panel="low-ox-life">
                    <div class="megamenu-panel-image">
                        <div class="megamenu-image-placeholder gradient-products-premium"></div>
                    </div>
                    <div class="megamenu-panel-content">
                        <h3 class="megamenu-panel-title"><?php esc_html_e('Low Ox Life', 'bfluxco'); ?></h3>
                        <p class="megamenu-panel-desc"><?php esc_html_e('Premium oxalate tracking with AI-powered insights, meal logging, and personalized recommendations for kidney health.', 'bfluxco'); ?></p>
                        <a href="<?php echo esc_url(home_url('/products/low-ox-life')); ?>" class="btn btn-primary btn-sm">
                            <?php esc_html_e('Learn more', 'bfluxco'); ?>
                        </a>
                    </div>
                </div>

                <!-- Recipe Calculator Panel -->
                <div class="megamenu-panel" data-panel="recipe-calculator">
                    <div class="megamenu-panel-image">
                        <div class="megamenu-image-placeholder gradient-recipe-calculator"></div>
                    </div>
                    <div class="megamenu-panel-content">
                        <h3 class="megamenu-panel-title"><?php esc_html_e('Recipe Calculator', 'bfluxco'); ?></h3>
                        <p class="megamenu-panel-desc"><?php esc_html_e('AI-powered recipe scaling and measurement conversion with 140+ ingredients. Scale any recipe to any serving size.', 'bfluxco'); ?></p>
                        <a href="<?php echo esc_url(home_url('/products/recipe-calculator')); ?>" class="btn btn-primary btn-sm">
                            <?php esc_html_e('Learn more', 'bfluxco'); ?>
                        </a>
                    </div>
                </div>

                <!-- Legal Panel -->
                <div class="megamenu-panel" data-panel="legal">
                    <div class="megamenu-panel-image">
                        <div class="megamenu-image-placeholder gradient-legal"></div>
                    </div>
                    <div class="megamenu-panel-content">
                        <h3 class="megamenu-panel-title"><?php esc_html_e('Legal', 'bfluxco'); ?></h3>
                        <p class="megamenu-panel-desc"><?php esc_html_e('Privacy policies and terms of service for all our products. Find the legal documents for your purchased products.', 'bfluxco'); ?></p>
                        <a href="<?php echo esc_url(home_url('/legal')); ?>" class="btn btn-primary btn-sm">
                            <?php esc_html_e('View policies', 'bfluxco'); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- #megamenu-products -->
