# Claude Memory - BFLUXCO WordPress Portfolio

## Project Overview

**Project Name:** BFLUXCO Portfolio Website
**Type:** Custom WordPress Theme
**Status:** Initial Setup Complete
**Created:** December 2025

---

## Quick Reference

### Local Development (LIVE SITE)
```
/Users/raybutler/Local Sites/bfluxco/app/public/wp-content/themes/bfluxco/
```
**URL:** http://bfluxco.local

> **IMPORTANT:** Always edit files in the Local Sites folder above. This is where Local by Flywheel serves the site from. Changes here appear immediately on http://bfluxco.local

### Backup/Source Location
```
/Users/raybutler/Downloads/BFLUXCO-wordpressWebsite/
```
This is a backup copy. Sync changes from Local Sites if needed.

### Key Files
| File | Purpose |
|------|---------|
| `style.css` | Main stylesheet with CSS variables |
| `functions.php` | Theme setup, custom post types, menus |
| `front-page.php` | Homepage template |
| `header.php` | Site header and navigation |
| `footer.php` | Site footer |
| `DESIGN-SYSTEM.md` | Visual design guidelines and principles |
| `CAROUSEL.md` | Case studies carousel specification |

---

## Architecture Decisions

### 1. Custom Post Types (functions.php)

**Case Studies** (`case_study`)
- URL: `/work/case-studies/[slug]`
- Supports: title, editor, thumbnail, excerpt, custom-fields
- Taxonomies: industry, service_type

**Workshops** (`workshop`)
- URL: `/work/workshops/[slug]`
- Supports: title, editor, thumbnail, excerpt, custom-fields
- Taxonomies: service_type

**Products** (`product`)
- URL: `/work/products/[slug]`
- Supports: title, editor, thumbnail, excerpt, custom-fields

### 2. Page Templates

Located in `page-templates/`:
- `template-work.php` - The Work overview
- `template-about.php` - About overview
- `template-about-person.php` - Bio pages (Ray)
- `template-about-company.php` - Company pages (BFL)
- `template-contact.php` - Contact page
- `template-support.php` - FAQ/Support
- `template-methodology.php` - Methodology
- `template-legal.php` - Privacy/Terms

### 3. Navigation Structure

**Registered Menus:**
- `primary` - Main header nav
- `secondary` - Header utility
- `footer` - Footer links
- `mobile` - Mobile menu
- `legal` - Legal links

### 4. CSS Architecture

Using CSS custom properties (variables) defined in `:root`:
- Colors: `--color-primary`, `--color-gray-*`
- Spacing: `--spacing-1` through `--spacing-20`
- Typography: `--font-size-*`, `--font-weight-*`
- Layout: `--container-max-width`

---

## Sitemap Reference

```
/                           (Home)
├── /work                   (The Work)
│   ├── /work/case-studies
│   ├── /work/workshops
│   ├── /work/products
│   └── /work/methodology
├── /about
│   ├── /about/ray
│   └── /about/bfl
├── /contact
├── /support
├── /privacy
└── /terms
```

**Important:** See `SITEMAP.md` for full details. Any changes to site structure should be reflected there.

---

## Development Guidelines

### Adding New Pages

1. Create page in WordPress admin
2. Set appropriate slug
3. Set parent page if needed
4. Apply correct template
5. Update `SITEMAP.md` if URL structure changes

### Adding New Page Template

```php
<?php
/**
 * Template Name: Your Template Name
 * Template Post Type: page
 */

get_header();
?>

<!-- Your template content -->

<?php
get_footer();
```

### Custom Fields Pattern

Case studies use these meta keys:
- `case_study_client`
- `case_study_timeline`
- `case_study_role`
- `case_study_results`

Workshops:
- `workshop_duration`
- `workshop_format`

Products:
- `product_type`
- `product_price`

### Helper Functions

**Available in template files:**
```php
bfluxco_breadcrumbs();           // Display breadcrumbs
bfluxco_truncate($text, 150);    // Truncate text
bfluxco_reading_time();          // Get reading time
bfluxco_social_share();          // Display share links
bfluxco_asset('images/logo.png'); // Get asset URL
```

---

## Current Status

### Completed
- [x] Theme file structure
- [x] Core template files (header, footer, index, page, etc.)
- [x] Custom post types (case_study, workshop, product)
- [x] Page templates for all sitemap pages
- [x] Navigation menu registration
- [x] CSS framework with variables
- [x] JavaScript (navigation, smooth scroll, filtering)
- [x] Customizer options
- [x] Documentation (README, SITEMAP)

### Pending Setup (WordPress Admin Required)
- [ ] Create WordPress pages
- [ ] Set up navigation menus
- [ ] Configure Reading settings (static front page)
- [ ] Save permalinks
- [ ] Install Contact Form 7
- [ ] Add content to pages
- [ ] Add case studies/workshops/products

---

## Common Tasks

### Change Primary Brand Color

Option 1: Customizer
- Appearance > Customize > Colors > Primary Brand Color

Option 2: CSS
```css
/* In style.css or custom.css */
:root {
    --color-primary: #your-color;
}
```

### Add New Custom Post Type Meta

1. Register meta in `functions.php`:
```php
function bfluxco_register_meta() {
    register_post_meta('case_study', 'new_meta_key', array(
        'show_in_rest' => true,
        'single' => true,
        'type' => 'string',
    ));
}
add_action('init', 'bfluxco_register_meta');
```

2. Display in template:
```php
$value = get_post_meta(get_the_ID(), 'new_meta_key', true);
```

### Add New Navigation Menu

1. Register in `functions.php`:
```php
register_nav_menu('new-location', __('New Menu Location', 'bfluxco'));
```

2. Display in template:
```php
wp_nav_menu(array('theme_location' => 'new-location'));
```

---

## Troubleshooting Notes

### Custom Post Types Return 404
- Go to Settings > Permalinks
- Click Save Changes (flushes rewrite rules)

### Styles Not Loading
- Check `wp_enqueue_style` in `functions.php`
- Clear browser cache
- Check for PHP errors in debug log

### Template Not Appearing in Dropdown
- Ensure template header comment is correct:
  ```php
  /**
   * Template Name: Name Here
   * Template Post Type: page
   */
  ```

---

## File Modification History

| File | Last Modified | Change |
|------|---------------|--------|
| All files | Dec 2025 | Initial creation |

---

## Case Studies Carousel

> **DO NOT CHANGE** - See `CAROUSEL.md` for full specification.

The homepage carousel has carefully tuned behavior including second-card centering on load, drag-to-scroll, and specific card dimensions.

---

## Mega Menu Navigation

> **Salesforce-inspired navigational surface**

The mega menu is an enterprise-grade navigation component with:

### Structure
- **Left Panel (300px)**: Navigation index with section title and menu items
- **Right Panel (flexible)**: Contextual content preview with image, title, description, and CTA button

### Behavior
- **Hover activation**: 180ms intent delay before opening (prevents accidental triggers)
- **Panel switching**: Hovering left-panel items updates right-panel content with cross-fade
- **Close delay**: 150ms delay before closing (allows cursor movement between trigger and menu)
- **ESC to close**: Keyboard accessible dismissal
- **Focus trapping**: Tab navigation stays within open menu

### CSS Classes
- `.megamenu` - Container (positioned absolute below header)
- `.megamenu.is-open` - Active state
- `.megamenu-left` / `.megamenu-right` - Panel containers
- `.megamenu-nav-item` - Left panel navigation items
- `.megamenu-panel` - Right panel content areas

### Files
- `header.php` - HTML structure (lines 114-308)
- `style.css` - Styles (section 5.5)
- `assets/js/main.js` - JavaScript behavior (`initMegaMenu()`)

### Mobile Behavior
- Mega menu is hidden on mobile (< 1024px)
- Mobile navigation uses accordion-style expandable sections
- Full-screen drawer with smooth slide-in animation

---

## Notes for Future Development

1. **Consider adding:**
   - Blog functionality (if needed)
   - Search functionality
   - Newsletter integration
   - More animations/interactions

2. **Performance optimizations:**
   - Image optimization
   - CSS/JS minification
   - Caching strategy

3. **Content considerations:**
   - SEO meta fields (Yoast or custom)
   - Social sharing images
   - Structured data markup

---

## Contact Form Setup

1. Install Contact Form 7 plugin
2. Create new form
3. Configure email settings
4. Copy shortcode
5. Paste into Contact page content

Fallback HTML form is included in template but not functional without plugin or custom handler.

---

## Version History

| Version | Date | Changes |
|---------|------|---------|
| 1.0.0 | Dec 2025 | Initial theme setup |
