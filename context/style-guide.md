# Piano Depot Style Guide
*A comprehensive design system for elegant, traditional piano retail*

---

## Brand Identity

### Mission Statement
Piano Depot represents decades of expertise in premium piano sales, combining traditional craftsmanship with personalized service. Our design reflects the timeless elegance of fine musical instruments and the sophistication of our clientele.

### Design Principles
- **Timeless Elegance** - Classical design that transcends trends
- **Craftsmanship** - Attention to detail in every element
- **Trust & Authority** - Established expertise and reliability
- **Sophisticated Simplicity** - Clean, uncluttered, refined

---

## Color Palette

### Primary Colors

| Color Name | Hex Code | Usage | Example |
|------------|----------|-------|---------|
| **Deep Navy** | `#2c3e50` | Section backgrounds, headers | Service section backgrounds |
| **Forest Green** | `#228b22` | Primary CTAs, success states | "Schedule Appointment" button |
| **Warm Gold** | `#d4af37` | Accents, highlights, patterns | Geometric background patterns |
| **Rich Wood** | `#8b4513` | Borders, frames, accents | Inspired by Notre Dame wood trim |

### Neutral Colors

| Color Name | Hex Code | Usage | Example |
|------------|----------|-------|---------|
| **Pure White** | `#ffffff` | Card backgrounds, content areas | Service cards, testimonials |
| **Cream** | `#faf0e6` | Section backgrounds, subtle areas | Warm content sections |
| **Soft Beige** | `#f5f5dc` | Alternative backgrounds | Light section variations |
| **Charcoal** | `#333333` | Primary text, headings | Body text, navigation |
| **Medium Gray** | `#64748b` | Secondary text, borders | Subtitle text, dividers |
| **Light Gray** | `#f8f9fa` | Subtle backgrounds, borders | Input backgrounds, dividers |

### Semantic Colors

| Color Name | Hex Code | Usage | Example |
|------------|----------|-------|---------|
| **Success Green** | `#10b981` | Success messages, confirmations | Form submissions |
| **Warning Amber** | `#f59e0b` | Warnings, alerts | Important notices |
| **Error Red** | `#ef4444` | Error states, validation | Form errors |
| **Info Blue** | `#3b82f6` | Information, links | Help text, links |

---

## Typography

### Font Families

#### Primary: System Sans-Serif
```css
font-family: ui-sans-serif, system-ui, sans-serif
```
- **Usage**: Body text, navigation, interface elements
- **Characteristics**: Clean, highly legible, universal compatibility
- **Weights**: 400 (Regular), 500 (Medium), 600 (Semibold), 700 (Bold)

#### Secondary: Serif (Headings)
```css
font-family: Georgia, "Times New Roman", serif
```
- **Usage**: Headings, elegant titles, formal announcements
- **Characteristics**: Traditional, sophisticated, authoritative
- **Weights**: 400 (Regular), 600 (Semibold), 700 (Bold)

### Typography Scale

| Element | Font | Size | Weight | Line Height | Usage |
|---------|------|------|--------|-------------|-------|
| **H1** | Serif | `text-4xl` (36px) | `font-bold` | `leading-tight` | Page titles |
| **H2** | Serif | `text-3xl` (30px) | `font-semibold` | `leading-tight` | Section headers |
| **H3** | Serif | `text-2xl` (24px) | `font-semibold` | `leading-snug` | Subsection headers |
| **H4** | Sans | `text-xl` (20px) | `font-semibold` | `leading-snug` | Card titles |
| **H5** | Sans | `text-lg` (18px) | `font-medium` | `leading-normal` | Small headings |
| **Body Large** | Sans | `text-lg` (18px) | `font-normal` | `leading-relaxed` | Important body text |
| **Body** | Sans | `text-base` (16px) | `font-normal` | `leading-relaxed` | Default body text |
| **Body Small** | Sans | `text-sm` (14px) | `font-normal` | `leading-normal` | Secondary text |
| **Caption** | Sans | `text-xs` (12px) | `font-medium` | `leading-normal` | Labels, captions |
| **Button** | Sans | `text-base` (16px) | `font-medium` | `leading-none` | Button text |

### Typography Examples

```html
<!-- Primary Heading -->
<h1 class="text-4xl font-bold text-slate-800 font-serif leading-tight">
  READY TO FIND YOUR PERFECT PIANO?
</h1>

<!-- Section Heading -->
<h2 class="text-3xl font-semibold text-slate-800 font-serif leading-tight mb-8">
  OUR SERVICES
</h2>

<!-- Body Text -->
<p class="text-base text-slate-600 leading-relaxed">
  Our appointment-only model ensures you get personalized attention 
  and expert guidance without sales pressure.
</p>

<!-- Small Text -->
<p class="text-sm text-slate-500 leading-normal">
  © 2024 Piano Depot | Privacy | Terms | Warranty
</p>
```

---

## Spacing & Layout

### Spacing Scale
Based on Tailwind's 4px base unit:

| Token | Value | Usage |
|-------|-------|-------|
| `space-1` | 4px | Fine adjustments |
| `space-2` | 8px | Small gaps |
| `space-3` | 12px | Medium gaps |
| `space-4` | 16px | Standard spacing |
| `space-6` | 24px | Large gaps |
| `space-8` | 32px | Section spacing |
| `space-12` | 48px | Large section spacing |
| `space-16` | 64px | Major section spacing |
| `space-20` | 80px | Hero section spacing |
| `space-24` | 96px | Extra large spacing |

### Layout Grid
- **Desktop**: 12-column grid with 24px gutters
- **Tablet**: 8-column grid with 20px gutters  
- **Mobile**: 4-column grid with 16px gutters

### Container Widths
- **Small**: `max-w-screen-sm` (640px)
- **Medium**: `max-w-screen-md` (768px)
- **Large**: `max-w-screen-lg` (1024px)
- **XL**: `max-w-screen-xl` (1280px)
- **2XL**: `max-w-screen-2xl` (1536px)

---

## Components

### Buttons

#### Primary Button (Green CTA)
```html
<button class="bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-6 rounded-md transition-colors duration-200 shadow-sm hover:shadow-md">
  Schedule Appointment
</button>
```

#### Secondary Button (Gold Accent)
```html
<button class="bg-amber-500 hover:bg-amber-600 text-white font-medium py-3 px-6 rounded-md transition-colors duration-200 shadow-sm hover:shadow-md">
  Learn More
</button>
```

#### Tertiary Button (Outline)
```html
<button class="border-2 border-slate-600 text-slate-600 hover:bg-slate-600 hover:text-white font-medium py-3 px-6 rounded-md transition-all duration-200">
  Read More Testimonials
</button>
```

#### Ghost Button (For Dark Backgrounds)
```html
<button class="bg-white text-slate-800 hover:bg-gray-100 font-medium py-3 px-6 rounded-md transition-colors duration-200 shadow-sm">
  Schedule Your Free Consultation
</button>
```

### Cards

#### Service Card
```html
<div class="bg-white rounded-lg shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-shadow duration-300">
  <div class="text-center mb-4">
    <!-- Icon -->
    <div class="w-16 h-16 mx-auto mb-4 text-amber-500">
      <!-- SVG Icon -->
    </div>
    <h3 class="text-xl font-semibold text-slate-800 mb-2">Piano Tuning & Repair</h3>
    <p class="text-slate-600 leading-relaxed">Professional maintenance services...</p>
  </div>
  <div class="text-center">
    <a href="#" class="text-green-600 hover:text-green-700 font-medium">Learn More →</a>
  </div>
</div>
```

#### Testimonial Card
```html
<div class="bg-cream rounded-lg p-6 shadow-md">
  <div class="flex items-center mb-3">
    <!-- 5 Star Rating -->
    <div class="flex text-amber-400 mb-2">
      ★★★★★
    </div>
  </div>
  <blockquote class="text-slate-700 italic mb-4">
    "Frank's expertise helped us find the perfect starter piano for our daughter..."
  </blockquote>
  <footer class="text-sm">
    <cite class="font-semibold text-slate-800">- The Miller Family</cite>
    <div class="text-slate-500">Clarks Summit</div>
  </footer>
</div>
```

### Forms

#### Input Fields
```html
<div class="mb-4">
  <label class="block text-sm font-medium text-slate-700 mb-2">
    Full Name
  </label>
  <input 
    type="text" 
    class="w-full border border-gray-300 rounded-md px-4 py-3 bg-white focus:border-amber-500 focus:ring-1 focus:ring-amber-500 focus:outline-none transition-colors"
    placeholder="Enter your full name"
  >
</div>
```

#### Select Dropdown
```html
<div class="mb-4">
  <label class="block text-sm font-medium text-slate-700 mb-2">
    Service Interest
  </label>
  <select class="w-full border border-gray-300 rounded-md px-4 py-3 bg-white focus:border-amber-500 focus:ring-1 focus:ring-amber-500 focus:outline-none">
    <option>Piano Purchase</option>
    <option>Piano Tuning</option>
    <option>Piano Moving</option>
    <option>Piano Lessons</option>
  </select>
</div>
```

### Navigation

#### Header Navigation
```html
<nav class="bg-white shadow-sm border-b border-gray-200">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center h-16">
      <!-- Logo -->
      <div class="flex-shrink-0">
        <img class="h-8 w-auto" src="logo.png" alt="Piano Depot">
      </div>
      
      <!-- Navigation Links -->
      <div class="hidden md:block">
        <div class="ml-10 flex items-baseline space-x-8">
          <a href="#" class="text-slate-700 hover:text-slate-900 px-3 py-2 text-sm font-medium">About Us</a>
          <a href="#" class="text-slate-700 hover:text-slate-900 px-3 py-2 text-sm font-medium">Pianos</a>
          <a href="#" class="text-slate-700 hover:text-slate-900 px-3 py-2 text-sm font-medium">Services</a>
          <a href="#" class="text-slate-700 hover:text-slate-900 px-3 py-2 text-sm font-medium">Resources</a>
          <a href="#" class="text-slate-700 hover:text-slate-900 px-3 py-2 text-sm font-medium">Contact</a>
        </div>
      </div>
      
      <!-- CTA Button -->
      <div class="hidden md:block">
        <button class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md transition-colors">
          Schedule Appointment
        </button>
      </div>
    </div>
  </div>
</nav>
```

---

## Patterns & Backgrounds

### Available Background Patterns
Use these elegant background patterns from the public folder:

#### Regal Pattern (Primary)
```html
<!-- Background Pattern -->
<div class="absolute inset-0 opacity-30">
    <div class="absolute inset-0" style="background-image: url('/regal.webp'); background-repeat: repeat; background-size: 400px 400px;"></div>
</div>
```

#### Oriental Tiles Pattern (Alternative)
```html
<!-- Background Pattern -->
<div class="absolute inset-0 opacity-30">
    <div class="absolute inset-0" style="background-image: url('/oriental-tiles.png'); background-repeat: repeat; background-size: 300px 300px;"></div>
</div>
```

#### Silver Scales Pattern (Subtle)
```html
<!-- Background Pattern -->
<div class="absolute inset-0 opacity-20">
    <div class="absolute inset-0" style="background-image: url('/silver_scales.webp'); background-repeat: repeat; background-size: 200px 200px;"></div>
</div>
```

### Pattern Implementation Guidelines
- Always use `absolute` positioning with `inset-0`
- Set appropriate `opacity` (20-30% for subtlety)
- Use `background-repeat: repeat` for seamless tiling
- Adjust `background-size` based on pattern detail
- Layer content with `relative z-10` on parent container

### Section Backgrounds

#### Navy Service Section
```html
<section class="bg-slate-800 text-white py-16">
  <div class="max-w-7xl mx-auto px-4">
    <!-- Content -->
  </div>
</section>
```

#### Patterned Content Section
```html
<section class="py-20 bg-gray-50 relative overflow-hidden">
  <!-- Background Pattern -->
  <div class="absolute inset-0 opacity-30">
    <div class="absolute inset-0" style="background-image: url('/regal.webp'); background-repeat: repeat; background-size: 400px 400px;"></div>
  </div>
  
  <div class="container mx-auto px-4 relative z-10 max-w-7xl">
    <!-- Content -->
  </div>
</section>
```

#### Call-to-Action Section
```html
<section class="bg-green-700 text-white py-20">
  <div class="max-w-4xl mx-auto text-center px-4">
    <!-- CTA Content -->
  </div>
</section>
```

---

## Iconography

### Icon Style Guidelines
- **Style**: Outline icons with 1.5px stroke weight
- **Size**: 24px standard, 16px small, 32px large
- **Color**: Match text color or use accent colors
- **Source**: Heroicons, Lucide, or custom SVGs

### Common Icons
- **Piano**: Musical instrument representation
- **Wrench**: Tuning and repair services  
- **Truck**: Moving and delivery services
- **Home**: Climate control systems
- **Book**: Lessons and education
- **Star**: Ratings and testimonials
- **Phone**: Contact information
- **Location**: Address and directions
- **Clock**: Hours and scheduling
- **Arrow**: Navigation and links

---

## Images & Media

### Photography Style
- **High Quality**: Professional, well-lit photography
- **Warm Tones**: Emphasize wood textures and warm lighting
- **Lifestyle**: Pianos in beautiful home settings
- **Detail Shots**: Close-ups of piano craftsmanship
- **People**: Authentic customers and family moments

### Image Specifications
- **Hero Images**: 1920x1080px minimum
- **Service Cards**: 400x300px
- **Testimonial Avatars**: 80x80px
- **Piano Gallery**: 600x400px
- **Format**: WebP preferred, JPG fallback
- **Optimization**: Compressed for web delivery

---

## Responsive Design

### Breakpoints
```css
/* Mobile First Approach */
sm: 640px   /* Small devices */
md: 768px   /* Medium devices */  
lg: 1024px  /* Large devices */
xl: 1280px  /* Extra large devices */
2xl: 1536px /* 2X large devices */
```

### Mobile Considerations
- **Touch Targets**: Minimum 44px tap targets
- **Navigation**: Hamburger menu for mobile
- **Typography**: Slightly smaller scales on mobile
- **Spacing**: Reduced padding and margins
- **Images**: Optimized sizes for mobile bandwidth

---

## Accessibility

### Color Contrast
- **Normal Text**: 4.5:1 minimum ratio
- **Large Text**: 3:1 minimum ratio  
- **UI Elements**: 3:1 minimum ratio

### Focus States
```css
.focus-visible {
  outline: 2px solid #3b82f6;
  outline-offset: 2px;
}
```

### Screen Reader Support
- Semantic HTML structure
- Proper heading hierarchy (h1 → h2 → h3)
- Alt text for all images
- ARIA labels where needed
- Skip navigation links

---

## Animation & Transitions

### Standard Transitions
```css
/* Hover Effects */
transition: all 0.2s ease-in-out;

/* Color Changes */
transition: color 0.2s ease-in-out;

/* Shadow Changes */
transition: box-shadow 0.3s ease-in-out;

/* Transform Effects */
transition: transform 0.2s ease-in-out;
```

### Micro-Interactions
- **Button Hover**: Subtle color darkening
- **Card Hover**: Elevated shadow effect
- **Link Hover**: Color change with underline
- **Form Focus**: Border color and shadow change
- **Loading States**: Subtle pulse or spinner

---

## Performance Guidelines

### Optimization Targets
- **First Contentful Paint**: < 2 seconds
- **Largest Contentful Paint**: < 2.5 seconds
- **Cumulative Layout Shift**: < 0.1
- **First Input Delay**: < 100ms

### Best Practices
- Optimize and compress images
- Use WebP format with JPG fallbacks
- Minimize CSS and JavaScript
- Implement lazy loading for images
- Use efficient fonts and font loading strategies

---

## Usage Examples

### Complete Service Card Implementation
```html
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 max-w-7xl mx-auto px-4">
  <!-- Piano Tuning Card -->
  <div class="bg-white rounded-lg shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-shadow duration-300 text-center">
    <div class="w-16 h-16 mx-auto mb-4 text-amber-500">
      <!-- Wrench Icon SVG -->
      <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
      </svg>
    </div>
    <h3 class="text-xl font-semibold text-slate-800 mb-3 font-serif">Piano Tuning & Repair</h3>
    <p class="text-slate-600 leading-relaxed mb-4">Professional maintenance services to keep your piano sounding its best.</p>
    <a href="#" class="inline-flex items-center text-green-600 hover:text-green-700 font-medium transition-colors">
      Learn More 
      <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
      </svg>
    </a>
  </div>
</div>
```

This style guide provides a comprehensive foundation for maintaining consistent, elegant design across the Piano Depot website while honoring the traditional, sophisticated aesthetic that your clientele expects.
