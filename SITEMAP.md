# Website Sitemap

This document outlines the complete site structure for the BFLUXCO portfolio website.

**Last Updated:** December 2025

---

## Desktop Navigation

### Primary Navigation
- Home
- The Work
- About

### The Work (Child Pages)
- Case Studies
- Workshops
- Products
- Methodology

### Secondary Navigation
- Contact
- Support

### About
- Meet Ray Butler
- About Big Freight Life (BFL)

### Footer Navigation
- Privacy Policy
- Terms of Service

---

## Mobile Navigation

### Top-Level Menu
- Home
- The Work
- About
- Contact

### The Work (Drill-Down)
- Case Studies
- Workshops
- Products
- Methodology

### About (Drill-Down)
- Meet Ray Butler
- About Big Freight Life (BFL)

### Utility (Bottom of Menu)
- Support
- Privacy Policy
- Terms of Service

---

## URL Structure

| Page | URL | Template | Parent |
|------|-----|----------|--------|
| Home | `/` | front-page.php | - |
| The Work | `/work` | template-work.php | - |
| Case Studies | `/work/case-studies` | archive-case_study.php | work |
| Workshops | `/work/workshops` | archive-workshop.php | work |
| Products | `/work/products` | archive-product.php | work |
| Methodology | `/work/methodology` | template-methodology.php | work |
| About | `/about` | template-about.php | - |
| Meet Ray Butler | `/about/ray` | template-about-person.php | about |
| About BFL | `/about/bfl` | template-about-company.php | about |
| Contact | `/contact` | template-contact.php | - |
| Support | `/support` | template-support.php | - |
| Privacy Policy | `/privacy` | template-legal.php | - |
| Terms of Service | `/terms` | template-legal.php | - |

---

## Page Hierarchy Visualization

```
/                           (Home)
├── /work                   (The Work - overview)
│   ├── /work/case-studies  (Case Studies archive)
│   │   └── /work/case-studies/[slug]  (Individual case study)
│   ├── /work/workshops     (Workshops archive)
│   │   └── /work/workshops/[slug]     (Individual workshop)
│   ├── /work/products      (Products archive)
│   │   └── /work/products/[slug]      (Individual product)
│   └── /work/methodology   (Methodology)
├── /about                  (About - overview)
│   ├── /about/ray          (Meet Ray Butler)
│   └── /about/bfl          (About Big Freight Life)
├── /contact                (Contact)
├── /support                (Support / FAQ)
├── /privacy                (Privacy Policy)
└── /terms                  (Terms of Service)
```

---

## Custom Post Type URLs

### Case Studies
- Archive: `/work/case-studies`
- Single: `/work/case-studies/[post-slug]`
- Industry Term: `/industry/[term-slug]`

### Workshops
- Archive: `/work/workshops`
- Single: `/work/workshops/[post-slug]`

### Products
- Archive: `/work/products`
- Single: `/work/products/[post-slug]`

---

## WordPress Page Setup Checklist

To recreate this structure in WordPress:

### 1. Create Parent Pages

- [ ] Home (slug: `home`)
- [ ] The Work (slug: `work`)
- [ ] About (slug: `about`)
- [ ] Contact (slug: `contact`)
- [ ] Support (slug: `support`)
- [ ] Privacy Policy (slug: `privacy`)
- [ ] Terms of Service (slug: `terms`)

### 2. Create Child Pages

**Under "The Work":**
- [ ] Methodology (slug: `methodology`, parent: The Work)

**Under "About":**
- [ ] Meet Ray Butler (slug: `ray`, parent: About)
- [ ] About Big Freight Life (slug: `bfl`, parent: About)

### 3. Apply Templates

- [ ] Home → (Set as static front page)
- [ ] The Work → "The Work" template
- [ ] Methodology → "Methodology" template
- [ ] About → "About" template
- [ ] Meet Ray Butler → "About Person" template
- [ ] About BFL → "About Company" template
- [ ] Contact → "Contact" template
- [ ] Support → "Support" template
- [ ] Privacy Policy → "Legal Page" template
- [ ] Terms of Service → "Legal Page" template

### 4. Set Up Reading Settings

1. Go to Settings > Reading
2. Select "A static page"
3. Homepage: "Home"
4. Posts page: (leave blank or create a Blog page if needed)

### 5. Configure Permalinks

1. Go to Settings > Permalinks
2. Select "Post name"
3. Save Changes

---

## Menu Locations

### Primary Navigation
Location: `primary`
Purpose: Main desktop header navigation

**Structure:**
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

### Secondary Navigation
Location: `secondary`
Purpose: Header utility links

**Structure:**
```
Contact
Support
```

### Mobile Navigation
Location: `mobile`
Purpose: Mobile menu (fallbacks to Primary if not set)

### Footer Navigation
Location: `footer`
Purpose: Footer links

### Legal Links
Location: `legal`
Purpose: Footer legal links

**Structure:**
```
Privacy Policy
Terms of Service
```

---

## Change Log

| Date | Change | Reason |
|------|--------|--------|
| Dec 2025 | Initial sitemap created | Project setup |

---

## Notes

- Case Studies, Workshops, and Products are **custom post types** and their archives are automatically generated
- The `/work/case-studies`, `/work/workshops`, and `/work/products` URLs are defined by the custom post type rewrite rules
- Individual items within these post types follow the pattern `/work/[type]/[post-slug]`
- The "Methodology" page is a regular WordPress page, not a custom post type
