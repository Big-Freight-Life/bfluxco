<?php
/**
 * Template for displaying search forms
 *
 * This template is used when get_search_form() is called.
 *
 * @package BFLUXCO
 */
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <label>
        <span class="screen-reader-text"><?php echo _x('Search for:', 'label', 'bfluxco'); ?></span>
        <input type="search" class="search-field" placeholder="<?php echo esc_attr_x('Search&hellip;', 'placeholder', 'bfluxco'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
    </label>
    <button type="submit" class="search-submit btn btn-primary">
        <span class="screen-reader-text"><?php echo _x('Search', 'submit button', 'bfluxco'); ?></span>
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"></circle>
            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        </svg>
    </button>
</form>
