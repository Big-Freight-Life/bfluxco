# BFLUXCO WordPress Portfolio Website

A custom WordPress theme for BFLUXCO portfolio website. This is a hand-coded theme designed for showcasing case studies, workshops, products, and methodology.

## Table of Contents

1. [Requirements](#requirements)
2. [Installation](#installation)
3. [Quick Start](#quick-start)
4. [Theme Structure](#theme-structure)
5. [Creating Pages](#creating-pages)
6. [Setting Up Menus](#setting-up-menus)
7. [Custom Post Types](#custom-post-types)
8. [Customization](#customization)
9. [For Developers](#for-developers)
10. [Troubleshooting](#troubleshooting)

---

## Requirements

- WordPress 6.0 or higher
- PHP 7.4 or higher
- MySQL 5.7 or higher

**Recommended:**
- Local development environment (Local by Flywheel, MAMP, XAMPP, or Laragon)
- Code editor (VS Code, Sublime Text, or similar)

---

## Installation

### Step 1: Set Up WordPress

If you don't have WordPress installed:

1. Download WordPress from [wordpress.org](https://wordpress.org/download/)
2. Set up a local server (we recommend [Local by Flywheel](https://localwp.com/))
3. Create a new WordPress site

### Step 2: Install the Theme

1. Copy the entire `bfluxco` folder from `wp-content/themes/`
2. Paste it into your WordPress installation's `wp-content/themes/` directory
3. In WordPress admin, go to **Appearance > Themes**
4. Find "BFLUXCO Portfolio" and click **Activate**

### Step 3: Install Recommended Plugins

- **Contact Form 7** - For the contact page form
- **Yoast SEO** (optional) - For SEO optimization

---

## Quick Start

After activating the theme:

### 1. Create Required Pages

Go to **Pages > Add New** and create these pages:

| Page Name | Slug | Template |
|-----------|------|----------|
| Home | `home` | Default or Front Page |
| The Work | `work` | The Work |
| Case Studies | `case-studies` (parent: work) | Default |
| Workshops | `workshops` (parent: work) | Default |
| Products | `products` (parent: work) | Default |
| Methodology | `methodology` (parent: work) | Methodology |
| About | `about` | About |
| Meet Ray Butler | `ray` (parent: about) | About Person |
| About BFL | `bfl` (parent: about) | About Company |
| Contact | `contact` | Contact |
| Support | `support` | Support |
| Privacy Policy | `privacy` | Legal Page |
| Terms of Service | `terms` | Legal Page |

### 2. Set Up Homepage

1. Go to **Settings > Reading**
2. Select "A static page"
3. Set "Homepage" to your "Home" page
4. Save changes

### 3. Create Navigation Menus

1. Go to **Appearance > Menus**
2. Create a new menu called "Primary Menu"
3. Add pages according to the sitemap
4. Assign to "Primary Navigation" location
5. Save menu

### 4. Refresh Permalinks

1. Go to **Settings > Permalinks**
2. Select "Post name" option
3. Click **Save Changes** (important for custom post types!)

---

## Theme Structure

```
bfluxco/
├── assets/
│   ├── css/
│   │   └── custom.css          # Additional custom styles
│   ├── js/
│   │   ├── main.js             # Main JavaScript
│   │   └── navigation.js       # Navigation functionality
│   └── images/                 # Theme images
├── inc/
│   ├── customizer.php          # Theme customizer options
│   └── template-tags.php       # Helper functions
├── page-templates/
│   ├── template-work.php       # The Work page template
│   ├── template-about.php      # About overview page
│   ├── template-about-person.php  # Personal bio template
│   ├── template-about-company.php # Company about template
│   ├── template-contact.php    # Contact page template
│   ├── template-support.php    # Support/FAQ page
│   ├── template-methodology.php # Methodology page
│   └── template-legal.php      # Privacy/Terms pages
├── template-parts/
│   ├── content.php             # Default post content
│   ├── content-none.php        # No results message
│   └── card-case-study.php     # Case study card component
├── archive-case_study.php      # Case studies archive
├── archive-workshop.php        # Workshops archive
├── archive-product.php         # Products archive
├── single-case_study.php       # Single case study template
├── 404.php                     # 404 error page
├── footer.php                  # Site footer
├── front-page.php              # Homepage template
├── functions.php               # Theme functions
├── header.php                  # Site header
├── index.php                   # Main fallback template
├── page.php                    # Default page template
├── single.php                  # Single post template
└── style.css                   # Main stylesheet
```

---

## Creating Pages

### Setting Page Templates

1. Edit the page in WordPress
2. In the right sidebar, find "Page Attributes"
3. Under "Template," select the appropriate template
4. Update the page

### Setting Page Parent (for child pages)

1. Edit the child page
2. In "Page Attributes," find "Parent Page"
3. Select the parent page
4. Update

**Example:** For "Methodology," set parent to "The Work"

---

## Setting Up Menus

### Primary Navigation (Desktop Header)

Suggested structure:
```
Home
The Work
├── Case Studies
├── Workshops
├── Products
└── Methodology
About
├── Meet Ray Butler
└── About BFL
```

### Secondary Navigation (Header Utility)

```
Contact
Support
```

### Footer Navigation

Use WordPress widgets or edit footer.php directly.

### Mobile Navigation

Create a separate mobile menu or it will fall back to Primary Menu.

---

## Custom Post Types

The theme includes three custom post types:

### Case Studies

- **Admin Location:** Case Studies menu
- **URL:** /work/case-studies/[post-name]
- **Custom Fields Available:**
  - `case_study_client` - Client name
  - `case_study_timeline` - Project timeline
  - `case_study_role` - Your role
  - `case_study_results` - Results/outcomes

### Workshops

- **Admin Location:** Workshops menu
- **URL:** /work/workshops/[post-name]
- **Custom Fields Available:**
  - `workshop_duration` - Duration (e.g., "Half Day", "2 Days")
  - `workshop_format` - Format (e.g., "In-Person", "Virtual")

### Products

- **Admin Location:** Products menu
- **URL:** /work/products/[post-name]
- **Custom Fields Available:**
  - `product_type` - Type (e.g., "Tool", "Framework", "Course")
  - `product_price` - Price or pricing text

### Taxonomies

- **Industry** - For categorizing case studies
- **Service Type** - For tagging case studies and workshops

---

## Customization

### Theme Options (Customizer)

Go to **Appearance > Customize** to access:

- **Site Identity** - Logo and site title
- **Colors** - Primary brand color
- **Header Settings** - Sticky header, CTA button
- **Footer Settings** - Copyright text
- **Social Links** - LinkedIn, Twitter, Instagram, etc.
- **Contact Info** - Email, phone, address

### Changing Colors

1. Open the Customizer
2. Go to **Colors**
3. Set your **Primary Brand Color**
4. Publish changes

Or edit `style.css` and change the CSS variables:

```css
:root {
    --color-primary: #2563eb;  /* Your brand color */
}
```

### Adding Custom CSS

Use **Appearance > Customize > Additional CSS** or add to `assets/css/custom.css`

---

## For Developers

### Adding a New Page Template

1. Create a file in `page-templates/` named `template-[name].php`
2. Add the template header comment at the top:

```php
<?php
/**
 * Template Name: Your Template Name
 * Template Post Type: page
 */
```

3. Add your template code
4. The template will appear in the Page Attributes dropdown

### Adding Custom Post Meta

Example for adding a custom field to case studies:

```php
// In functions.php or a custom plugin
function bfluxco_get_case_study_meta($post_id) {
    return array(
        'client'   => get_post_meta($post_id, 'case_study_client', true),
        'timeline' => get_post_meta($post_id, 'case_study_timeline', true),
        'role'     => get_post_meta($post_id, 'case_study_role', true),
    );
}
```

### Using Custom Fields

To save/edit custom fields, you can:
1. Use the **Custom Fields** meta box (enable in Screen Options)
2. Install **Advanced Custom Fields (ACF)** plugin
3. Create a custom meta box in functions.php

### JavaScript Events

The theme fires custom events you can hook into:

```javascript
// Mobile menu opened
document.addEventListener('bfluxco:menu:opened', function() {
    // Your code
});

// Filter changed
document.addEventListener('bfluxco:filter:changed', function(e) {
    console.log(e.detail.filter);
});
```

---

## Troubleshooting

### Custom Post Types Not Showing

1. Go to **Settings > Permalinks**
2. Click **Save Changes** (even without changes)
3. This refreshes the permalink rules

### Menus Not Appearing

1. Check that menus are assigned to the correct locations
2. Ensure the menu location exists in Appearance > Menus > Manage Locations

### Contact Form Not Working

1. Install Contact Form 7 plugin
2. Create a new form
3. Copy the shortcode
4. Paste into the Contact page content

### 404 Errors on Pages

1. Go to Settings > Permalinks
2. Click Save Changes
3. Clear any caching plugins

### Styles Not Loading

1. Check the browser console for errors
2. Ensure theme is properly activated
3. Clear browser cache (Ctrl+Shift+R)

---

## Support

For questions or issues:
- Check the documentation in this README
- Review the code comments in theme files
- Create an issue in the project repository

---

## License

GNU General Public License v2 or later
http://www.gnu.org/licenses/gpl-2.0.html
