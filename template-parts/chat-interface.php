<?php
/**
 * Template part for the AI chat interface
 * Can be included on any page that needs chat functionality
 *
 * @package BFLUXCO
 */

// Get chat context from template args or URL
$chat_context = '';
if (isset($args['context'])) {
    $chat_context = $args['context'];
}

// Determine if chat should be hidden by default (non-homepage)
$is_hidden = !is_front_page();
$chat_classes = 'hero-chat' . ($is_hidden ? ' is-hidden' : '');
?>
<!-- Full-screen blur overlay for chat -->
<div class="chat-blur-overlay" id="chat-blur-overlay"></div>

<!-- AI Chat Interface -->
<div class="<?php echo esc_attr($chat_classes); ?>" id="hero-chat" data-context="<?php echo esc_attr($chat_context); ?>"<?php if ($is_hidden) echo ' data-hide-on-close="true"'; ?>>
    <!-- Chat Input Area (messages float above this) -->
    <div class="chat-input-area">
        <!-- Conversation Messages (appears when chatting) -->
        <div class="chat-messages" id="chat-messages" role="log" aria-live="polite" aria-label="<?php esc_attr_e('Chat conversation', 'bfluxco'); ?>"></div>

        <!-- Lead Capture Form (appears on handoff) -->
        <div class="chat-lead-form" id="chat-lead-form">
            <h3 class="chat-lead-form-title"><?php esc_html_e("Let's connect you with Ray", 'bfluxco'); ?></h3>
            <p class="chat-lead-form-desc"><?php esc_html_e('Leave your details and Ray will get back to you within 24 hours.', 'bfluxco'); ?></p>
            <input type="text" class="chat-lead-input chat-lead-name" placeholder="<?php esc_attr_e('Your name', 'bfluxco'); ?>" />
            <input type="email" class="chat-lead-input chat-lead-email" placeholder="<?php esc_attr_e('Your email', 'bfluxco'); ?>" required />
            <textarea class="chat-lead-input chat-lead-message" rows="2" placeholder="<?php esc_attr_e('Brief message (optional)', 'bfluxco'); ?>"></textarea>
            <div class="chat-lead-actions">
                <button type="button" class="btn btn-primary chat-lead-submit"><?php esc_html_e('Send Message', 'bfluxco'); ?></button>
                <a href="#" class="btn btn-outline chat-lead-schedule" style="display: none;" target="_blank" rel="noopener"><?php esc_html_e('Schedule a Call', 'bfluxco'); ?></a>
            </div>
        </div>

        <!-- Success Message -->
        <div class="chat-success" id="chat-success">
            <div class="chat-success-icon">
                <?php bfluxco_icon('check', array('size' => 24)); ?>
            </div>
            <h3 class="chat-success-title"><?php esc_html_e('Message sent!', 'bfluxco'); ?></h3>
            <p class="chat-success-desc"><?php esc_html_e("Ray will be in touch soon.", 'bfluxco'); ?></p>
        </div>

        <!-- Chat Input -->
        <form class="chat-form" id="chat-form" onsubmit="return false;">
            <div class="chat-input-wrapper">
                <span class="chat-input-icon" aria-hidden="true">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                </span>
                <textarea class="chat-input" id="chat-input" placeholder="<?php esc_attr_e('Ask how can we help you...', 'bfluxco'); ?>" autocomplete="off" rows="1"></textarea>
                <button type="button" class="chat-clear-btn" id="chat-clear-btn" aria-label="<?php esc_attr_e('Clear input', 'bfluxco'); ?>">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M18.3 5.71a1 1 0 0 0-1.42 0L12 10.59 7.12 5.71a1 1 0 0 0-1.42 1.42L10.59 12l-4.89 4.88a1 1 0 1 0 1.42 1.42L12 13.41l4.88 4.89a1 1 0 0 0 1.42-1.42L13.41 12l4.89-4.88a1 1 0 0 0 0-1.41z"/></svg>
                </button>
                <button type="button" class="chat-mic-btn" id="chat-mic-btn" aria-label="<?php esc_attr_e('Voice input', 'bfluxco'); ?>">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"></path><path d="M19 10v2a7 7 0 0 1-14 0v-2"></path><line x1="12" y1="19" x2="12" y2="23"></line><line x1="8" y1="23" x2="16" y2="23"></line></svg>
                </button>
                <button type="button" class="chat-voice-toggle" id="chat-voice-toggle" aria-label="<?php esc_attr_e('Toggle voice output', 'bfluxco'); ?>">
                    <svg class="icon-speaker" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon><path d="M19.07 4.93a10 10 0 0 1 0 14.14"></path><path d="M15.54 8.46a5 5 0 0 1 0 7.07"></path></svg>
                    <svg class="icon-muted" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon><line x1="23" y1="9" x2="17" y2="15"></line><line x1="17" y1="9" x2="23" y2="15"></line></svg>
                </button>
            </div>
            <button type="button" class="chat-close-btn" id="chat-close-btn" aria-label="<?php esc_attr_e('Close chat', 'bfluxco'); ?>">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </form>
    </div>

    <!-- Action Buttons -->
    <div class="hero-chat-actions">
        <a href="<?php echo esc_url(home_url('/about/ray')); ?>" class="btn btn-primary">
            <?php esc_html_e('Interview Ray', 'bfluxco'); ?>
        </a>
        <a href="<?php echo esc_url(home_url('/works/products')); ?>" class="btn btn-outline">
            <?php esc_html_e('Git In Touch', 'bfluxco'); ?>
        </a>
        <a href="<?php echo esc_url(home_url('/transformation')); ?>" class="btn btn-outline">
            <?php esc_html_e('Transform My Team', 'bfluxco'); ?>
        </a>
    </div>
</div>
