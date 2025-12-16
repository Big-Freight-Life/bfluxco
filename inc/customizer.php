<?php
/**
 * Theme Customizer Options
 *
 * This file adds custom options to the WordPress Customizer.
 * Access via Appearance > Customize in WordPress admin.
 *
 * @package BFLUXCO
 *
 * PRO TIP: The Customizer lets you modify theme settings
 * with a live preview. These settings are saved in the database
 * and can be retrieved using get_theme_mod().
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Customizer Settings
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function bfluxco_customize_register($wp_customize) {

    // ==========================================================================
    // SITE IDENTITY SECTION (extends default section)
    // ==========================================================================

    // Site Description Toggle
    $wp_customize->add_setting('bfluxco_show_site_description', array(
        'default'           => true,
        'sanitize_callback' => 'bfluxco_sanitize_checkbox',
    ));

    $wp_customize->add_control('bfluxco_show_site_description', array(
        'label'    => __('Display site tagline', 'bfluxco'),
        'section'  => 'title_tagline',
        'type'     => 'checkbox',
    ));

    // ==========================================================================
    // THEME OPTIONS PANEL
    // ==========================================================================

    $wp_customize->add_panel('bfluxco_theme_options', array(
        'title'    => __('Theme Options', 'bfluxco'),
        'priority' => 130,
    ));

    // ==========================================================================
    // HEADER SETTINGS SECTION
    // ==========================================================================

    $wp_customize->add_section('bfluxco_header_settings', array(
        'title'    => __('Header Settings', 'bfluxco'),
        'panel'    => 'bfluxco_theme_options',
        'priority' => 10,
    ));

    // Sticky Header
    $wp_customize->add_setting('bfluxco_sticky_header', array(
        'default'           => true,
        'sanitize_callback' => 'bfluxco_sanitize_checkbox',
    ));

    $wp_customize->add_control('bfluxco_sticky_header', array(
        'label'       => __('Enable Sticky Header', 'bfluxco'),
        'description' => __('Header stays fixed at the top when scrolling.', 'bfluxco'),
        'section'     => 'bfluxco_header_settings',
        'type'        => 'checkbox',
    ));

    // Header CTA Button Text
    $wp_customize->add_setting('bfluxco_header_cta_text', array(
        'default'           => __('Contact', 'bfluxco'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('bfluxco_header_cta_text', array(
        'label'   => __('Header Button Text', 'bfluxco'),
        'section' => 'bfluxco_header_settings',
        'type'    => 'text',
    ));

    // Header CTA Button URL
    $wp_customize->add_setting('bfluxco_header_cta_url', array(
        'default'           => '/contact',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('bfluxco_header_cta_url', array(
        'label'   => __('Header Button URL', 'bfluxco'),
        'section' => 'bfluxco_header_settings',
        'type'    => 'url',
    ));

    // ==========================================================================
    // FOOTER SETTINGS SECTION
    // ==========================================================================

    $wp_customize->add_section('bfluxco_footer_settings', array(
        'title'    => __('Footer Settings', 'bfluxco'),
        'panel'    => 'bfluxco_theme_options',
        'priority' => 20,
    ));

    // Footer Copyright Text
    $wp_customize->add_setting('bfluxco_footer_copyright', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
    ));

    $wp_customize->add_control('bfluxco_footer_copyright', array(
        'label'       => __('Copyright Text', 'bfluxco'),
        'description' => __('Leave empty to use default. Use {year} for current year, {site} for site name.', 'bfluxco'),
        'section'     => 'bfluxco_footer_settings',
        'type'        => 'textarea',
    ));

    // ==========================================================================
    // SOCIAL LINKS SECTION
    // ==========================================================================

    $wp_customize->add_section('bfluxco_social_links', array(
        'title'    => __('Social Links', 'bfluxco'),
        'panel'    => 'bfluxco_theme_options',
        'priority' => 30,
    ));

    // Social platforms to add
    $social_platforms = array(
        'linkedin'  => __('LinkedIn URL', 'bfluxco'),
        'twitter'   => __('Twitter/X URL', 'bfluxco'),
        'instagram' => __('Instagram URL', 'bfluxco'),
        'facebook'  => __('Facebook URL', 'bfluxco'),
        'youtube'   => __('YouTube URL', 'bfluxco'),
        'github'    => __('GitHub URL', 'bfluxco'),
    );

    foreach ($social_platforms as $platform => $label) {
        $wp_customize->add_setting("bfluxco_social_{$platform}", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control("bfluxco_social_{$platform}", array(
            'label'   => $label,
            'section' => 'bfluxco_social_links',
            'type'    => 'url',
        ));
    }

    // ==========================================================================
    // CONTACT INFO SECTION
    // ==========================================================================

    $wp_customize->add_section('bfluxco_contact_info', array(
        'title'    => __('Contact Information', 'bfluxco'),
        'panel'    => 'bfluxco_theme_options',
        'priority' => 40,
    ));

    // Email
    $wp_customize->add_setting('bfluxco_contact_email', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_email',
    ));

    $wp_customize->add_control('bfluxco_contact_email', array(
        'label'   => __('Contact Email', 'bfluxco'),
        'section' => 'bfluxco_contact_info',
        'type'    => 'email',
    ));

    // Phone
    $wp_customize->add_setting('bfluxco_contact_phone', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('bfluxco_contact_phone', array(
        'label'   => __('Phone Number', 'bfluxco'),
        'section' => 'bfluxco_contact_info',
        'type'    => 'text',
    ));

    // Address
    $wp_customize->add_setting('bfluxco_contact_address', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
    ));

    $wp_customize->add_control('bfluxco_contact_address', array(
        'label'   => __('Address', 'bfluxco'),
        'section' => 'bfluxco_contact_info',
        'type'    => 'textarea',
    ));

    // ==========================================================================
    // COLORS SECTION (extends default section)
    // ==========================================================================

    // Primary Color
    $wp_customize->add_setting('bfluxco_primary_color', array(
        'default'           => '#2563eb',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'bfluxco_primary_color', array(
        'label'   => __('Primary Brand Color', 'bfluxco'),
        'section' => 'colors',
    )));

}
add_action('customize_register', 'bfluxco_customize_register');


// ==========================================================================
// SANITIZATION CALLBACKS
// ==========================================================================

/**
 * Sanitize checkbox values
 *
 * @param bool $checked Whether the checkbox is checked.
 * @return bool
 */
function bfluxco_sanitize_checkbox($checked) {
    return ((isset($checked) && true === $checked) ? true : false);
}


// ==========================================================================
// CUSTOMIZER OUTPUT
// ==========================================================================

/**
 * Output Customizer CSS
 *
 * Generates CSS from customizer settings and outputs to head.
 */
function bfluxco_customizer_css() {
    $primary_color = get_theme_mod('bfluxco_primary_color', '#2563eb');

    // Only output if color has been changed from default
    if ($primary_color !== '#2563eb') :
    ?>
    <style type="text/css">
        :root {
            --color-primary: <?php echo esc_html($primary_color); ?>;
        }
    </style>
    <?php
    endif;
}
add_action('wp_head', 'bfluxco_customizer_css');


// ==========================================================================
// HELPER FUNCTIONS FOR TEMPLATES
// ==========================================================================

/**
 * Get social links as array
 *
 * @return array Social links that have URLs set
 */
function bfluxco_get_social_links() {
    $platforms = array('linkedin', 'twitter', 'instagram', 'facebook', 'youtube', 'github');
    $links = array();

    foreach ($platforms as $platform) {
        $url = get_theme_mod("bfluxco_social_{$platform}");
        if (!empty($url)) {
            $links[$platform] = $url;
        }
    }

    return $links;
}

/**
 * Display social links
 *
 * Outputs social media links as a list.
 *
 * @param string $class Additional CSS class for the list
 */
function bfluxco_social_links($class = '') {
    $links = bfluxco_get_social_links();

    if (empty($links)) {
        return;
    }

    echo '<ul class="social-links ' . esc_attr($class) . '">';

    foreach ($links as $platform => $url) {
        printf(
            '<li><a href="%s" target="_blank" rel="noopener noreferrer" aria-label="%s">%s</a></li>',
            esc_url($url),
            esc_attr(ucfirst($platform)),
            esc_html(ucfirst($platform))
        );
    }

    echo '</ul>';
}

/**
 * Get footer copyright text
 *
 * @return string Formatted copyright text
 */
function bfluxco_get_copyright() {
    $custom_copyright = get_theme_mod('bfluxco_footer_copyright', '');

    if (!empty($custom_copyright)) {
        $copyright = str_replace(
            array('{year}', '{site}'),
            array(date('Y'), get_bloginfo('name')),
            $custom_copyright
        );
    } else {
        $copyright = sprintf(
            '&copy; %s %s. %s',
            date('Y'),
            get_bloginfo('name'),
            __('All rights reserved.', 'bfluxco')
        );
    }

    return $copyright;
}
