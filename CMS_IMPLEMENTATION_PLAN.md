# CMS Implementation Plan for Piano Depot

## Project Summary

We're building a custom CMS for Piano Depot that balances simplicity with flexibility. The system will manage:

- **Dynamic Pages**: Hierarchical page structure with different content types (standard pages, piano listings, blog, contact forms)
- **Flexible Menu System**: Drag-and-drop menu builder that's separate from page hierarchy, allowing custom menu arrangements
- **Piano Inventory**: Dedicated system for managing new Yamaha and used piano listings with galleries and specifications
- **Blog/Resources**: Content management for educational articles and resources
- **Admin Panel**: User-friendly interface for managing all content with visual editors and preview capabilities

### Key Design Decisions
- Single `Page` model with `page_type` field to handle different content types
- Self-referencing parent-child relationships for unlimited page hierarchy
- Separate `MenuItem` model for flexible menu management independent of page structure
- Dedicated models for specialized content (Pianos, BlogPosts) while keeping the Page model simple
- Menu items can link to pages, external URLs, or custom routes

## Phase 1: Core Models & Database Structure

### Pages System
1. [x] Create Page model with self-referencing hierarchy
2. [x] Create migration for pages table with fields:
   - id, parent_id, title, slug, menu_title
   - page_type enum ('standard', 'blog', 'piano_listing', 'contact', 'landing')
   - content, meta_description
   - is_published, show_in_menu, menu_order
   - timestamps

### Piano Inventory System
3. [x] Create Piano model for inventory management
4. [x] Create migration for pianos table with fields:
   - id, brand, model, year, price
   - condition ('new', 'used', 'restored')
   - description, specifications
   - featured_image, gallery_images
   - is_available, is_featured
   - timestamps

### Blog/Resources System
5. [x] Create BlogPost model for resources section
6. [x] Create migration for blog_posts table with fields:
   - id, title, slug, excerpt, content
   - author_id, category_id
   - featured_image
   - is_published, published_at
   - timestamps

### Menu Management System
7. [x] Create MenuItem model for flexible menu management
8. [x] Create migration for menu_items table with fields:
   - id, menu_location ('header', 'footer')
   - type ('page', 'external', 'custom')
   - page_id (nullable FK to pages)
   - title, url, parent_id
   - order, is_active
   - timestamps

## Phase 2: Admin Panel

### Basic Admin Setup
Before we begin on the Admin Panel, I want to set a couple of ground rules.
- I would like to use DaisyUI components whenever possible. (https://daisyui.com/llms.txt)
- I want the content sections to use TipTap (https://tiptap.dev/docs/editor/getting-started/overview)
- I like old school CRUD apps with minimal javascript.  Use stimulus.js if js is nescessary, but prefer controllers, forms and anchor tags.
- I like to keep controllers to either be invokable controllers or to use laravel resource method names.  No custom methods if they can be avoided.
9. [x] Set up admin routes with authentication
10. [x] Create AdminController base class
11. [x] Build admin layout template
12. [x] Implement admin dashboard

### Page Management
13. [x] Create PageController with CRUD operations
14. [x] Build page listing with tree view
15. [x] Implement create/edit forms with dynamic fields based on page_type
16. [x] Add drag-and-drop reordering (using Sortable.js)
17. [x] Implement publish/unpublish functionality
18. [x] Add page preview feature

### Menu Builder
19. [x] Create MenuController for menu management
20. [x] Build visual menu editor interface
21. [x] Implement drag-and-drop menu item reordering
22. [x] Add support for nested menu items (dropdowns)
23. [x] Create menu item types (page link, external URL, custom)

### Piano Inventory Management
24. [x] Create PianoController with CRUD operations
25. [x] Build piano listing with filters (new/used, brand, price range)
26. [x] Implement image upload for piano galleries
27. [x] Add featured piano management
28. [x] Create bulk import/export functionality

### Blog Management
29. [ ] Create BlogPostController with CRUD operations
30. [ ] Build blog post editor with rich text editing
31. [ ] Implement category management
32. [ ] Add featured image upload
33. [ ] Create scheduling for future posts

## Phase 3: Frontend Integration

### Dynamic Routing
34. [ ] Create PageController for public routes
35. [ ] Implement dynamic slug-based routing
36. [ ] Build fallback route handler for CMS pages
37. [ ] Add 404 handling for non-existent pages

### Page Templates
38. [ ] Create blade template for 'standard' pages
39. [ ] Create blade template for 'piano_listing' pages
40. [ ] Create blade template for 'blog' pages
41. [ ] Create blade template for 'contact' pages
42. [ ] Create blade template for 'landing' pages

### Navigation Updates
43. [ ] Update header.blade.php to pull menu from database
44. [ ] Implement dynamic dropdown menus
45. [ ] Add active state highlighting
46. [ ] Create breadcrumb component
47. [ ] Update mobile menu to use database

### Piano Display
48. [ ] Create piano listing component
49. [ ] Build individual piano detail view
50. [ ] Implement piano search and filters
51. [ ] Add piano comparison feature
52. [ ] Create piano inquiry form

### Blog Display
53. [ ] Create blog listing page
54. [ ] Build individual blog post view
55. [ ] Implement blog categories and tags
56. [ ] Add related posts feature
57. [ ] Create blog search functionality

## Phase 4: Enhanced Features

### SEO & Meta Tags
58. [ ] Implement dynamic meta tags for all pages
59. [ ] Add Open Graph tags support
60. [ ] Create XML sitemap generator
61. [ ] Implement canonical URLs
62. [ ] Add structured data markup

### Media Management
63. [ ] Create media library for image uploads
64. [ ] Implement image optimization on upload
65. [ ] Add image cropping/resizing tools
66. [ ] Create gallery management for pianos
67. [ ] Implement lazy loading for images

### Performance & Caching
68. [ ] Implement page caching strategy
69. [ ] Add database query optimization
70. [ ] Set up CDN for static assets
71. [ ] Implement menu caching
72. [ ] Add Redis caching for frequently accessed data

### User Experience
73. [ ] Add page versioning/history
74. [ ] Implement autosave for admin forms
75. [ ] Create content preview before publishing
76. [ ] Add bulk actions for admin panels
77. [ ] Implement search across all content types

## Phase 5: Testing & Deployment

### Testing
78. [ ] Write unit tests for models
79. [ ] Create feature tests for admin panel
80. [ ] Test menu rendering and navigation
81. [ ] Verify SEO implementation
82. [ ] Cross-browser testing

### Documentation
83. [ ] Create admin user guide
84. [ ] Document content management workflows
85. [ ] Write developer documentation
86. [ ] Create backup and restore procedures

### Deployment
87. [ ] Set up staging environment
88. [ ] Migrate existing content
89. [ ] Configure production caching
90. [ ] Set up monitoring and logging
91. [ ] Plan rollout strategy

## Notes

### Priority Order
1. Start with Pages and Menu system (core functionality)
2. Add Piano inventory (key business feature)
3. Implement Blog (content marketing)
4. Enhance with SEO and performance features

### Technology Stack
- **Backend**: Laravel 11
- **Frontend**: Blade templates, Alpine.js for interactivity
- **Admin UI**: Tailwind CSS, Sortable.js for drag-and-drop
- **Rich Text Editor**: TinyMCE or Trix
- **Image Management**: Intervention Image
- **Caching**: Redis
- **Search**: Laravel Scout (optional)

### Database Relationships
- Pages: Self-referencing for parent-child hierarchy
- MenuItems: Polymorphic relation to pages or external URLs
- Pianos: Standalone with category relationships
- BlogPosts: Many-to-one with categories and users
