# Halzanîn | حالزانین
## Complete Design System & UI Guide
**Version 1.0 — May 2026**
**Project: Digital Public Document Tracking System**
**Institution: Sulaimani Polytechnic University — Technical College of Informatics**

---

## 1. Brand Identity

### Name
| Script | Text |
|--------|------|
| Latin | Halzanîn |
| Kurdish (Sorani) | حالزانین |

### Tagline
| Language | Text |
|----------|------|
| English | *"Know where your documents stand"* |
| Kurdish | *"بزانە بەلگەکەت لە کوێیە"* |

### Brand Personality
- **Trustworthy** — citizens trust it with sensitive documents
- **Clear** — no confusion, no jargon
- **Accessible** — works for all ages, all tech levels
- **Official** — feels like a real government service

---

## 2. Color System

### Primary Palette
```
--color-primary:        #1e1b4b   /* Deep Indigo — main brand color */
--color-primary-light:  #312e81   /* Indigo 800 — hover states */
--color-primary-soft:   #e0e7ff   /* Indigo 100 — backgrounds, tints */

--color-accent:         #059669   /* Emerald Green — Kurdish cultural accent */
--color-accent-light:   #d1fae5   /* Emerald 100 — success backgrounds */
--color-accent-dark:    #047857   /* Emerald 700 — hover on accent */
```

### Neutral Palette
```
--color-white:          #ffffff
--color-gray-50:        #f8fafc   /* Page background */
--color-gray-100:       #f1f5f9   /* Card backgrounds */
--color-gray-200:       #e2e8f0   /* Borders */
--color-gray-400:       #94a3b8   /* Placeholder text */
--color-gray-600:       #475569   /* Secondary text */
--color-gray-900:       #0f172a   /* Primary text */
```

### Dark Mode Palette
```
--dark-bg:              #0f172a   /* Page background */
--dark-surface:         #1e293b   /* Card background */
--dark-surface-2:       #334155   /* Elevated cards */
--dark-border:          #334155   /* Borders */
--dark-text:            #f1f5f9   /* Primary text */
--dark-text-muted:      #94a3b8   /* Secondary text */
```

### Status Colors (consistent across all pages)
```
--status-submitted:     #64748b   /* Gray — neutral start */
--status-received:      #2563eb   /* Blue — in the system */
--status-under-review:  #d97706   /* Amber — being processed */
--status-approved:      #059669   /* Emerald — success */
--status-rejected:      #dc2626   /* Red — action needed */
```

### Usage Rules
- Never use more than 2 colors on one component
- Primary indigo for all CTAs (call to action buttons)
- Emerald green for success states and positive actions only
- Gray for disabled states and secondary information
- Status colors ONLY for status badges — never reuse them decoratively

---

## 3. Typography

### Font Stack
```css
/* English & Numbers */
font-family: 'Outfit', sans-serif;
/* Import: https://fonts.google.com/specimen/Outfit */

/* Kurdish (Sorani) & Arabic */
font-family: 'Noto Naskh Arabic', serif;
/* Import: https://fonts.google.com/noto/specimen/Noto+Naskh+Arabic */

/* Monospace (tracking codes, IDs) */
font-family: 'JetBrains Mono', monospace;
/* Import: https://fonts.google.com/specimen/JetBrains+Mono */
```

### Type Scale
```
--text-xs:    12px / line-height: 1.5   /* Labels, captions */
--text-sm:    14px / line-height: 1.5   /* Body small, table cells */
--text-base:  16px / line-height: 1.6   /* Body text, form inputs */
--text-lg:    18px / line-height: 1.5   /* Subheadings */
--text-xl:    20px / line-height: 1.4   /* Section titles */
--text-2xl:   24px / line-height: 1.3   /* Page titles (mobile) */
--text-3xl:   30px / line-height: 1.2   /* Page titles (desktop) */
--text-4xl:   36px / line-height: 1.1   /* Hero headlines */
```

### Font Weights
```
Regular:   400   /* Body text, descriptions */
Medium:    500   /* Labels, nav items */
Semibold:  600   /* Subheadings, card titles */
Bold:      700   /* Page titles, CTAs, tracking codes */
```

### RTL Rules (Kurdish)
- When Kurdish is active: `dir="rtl"` on `<html>` tag
- All flex rows reverse: `flex-direction: row-reverse`
- All text aligns right: `text-align: right`
- Icons that imply direction (arrows, chevrons) must flip: `transform: scaleX(-1)`
- Padding/margin sides swap: left becomes right and vice versa
- Use logical CSS properties where possible: `margin-inline-start` instead of `margin-left`

---

## 4. Spacing System

```
--space-1:   4px
--space-2:   8px
--space-3:   12px
--space-4:   16px    /* Base unit */
--space-5:   20px
--space-6:   24px
--space-8:   32px
--space-10:  40px
--space-12:  48px
--space-16:  64px
--space-20:  80px
```

### Layout Spacing Rules
- Page padding mobile: `16px` left/right
- Page padding desktop: `32px` left/right
- Card inner padding: `20px` (mobile) / `24px` (desktop)
- Section gap: `32px` (mobile) / `48px` (desktop)
- Form field gap: `16px`
- Button padding: `12px 24px`

---

## 5. Border Radius

```
--radius-sm:   6px    /* Tags, small badges */
--radius-md:   10px   /* Buttons, inputs */
--radius-lg:   16px   /* Cards */
--radius-xl:   24px   /* Modals, bottom sheets */
--radius-full: 9999px /* Pills, avatars, circular buttons */
```

---

## 6. Shadows

```css
/* Subtle card lift */
--shadow-sm: 0 1px 3px rgba(0,0,0,0.08), 0 1px 2px rgba(0,0,0,0.04);

/* Standard card */
--shadow-md: 0 4px 6px rgba(0,0,0,0.07), 0 2px 4px rgba(0,0,0,0.04);

/* Elevated card / dropdown */
--shadow-lg: 0 10px 15px rgba(0,0,0,0.08), 0 4px 6px rgba(0,0,0,0.04);

/* Modal / bottom sheet */
--shadow-xl: 0 20px 25px rgba(0,0,0,0.10), 0 8px 10px rgba(0,0,0,0.05);

/* Primary button glow */
--shadow-primary: 0 4px 14px rgba(30,27,75,0.35);

/* Accent button glow */
--shadow-accent: 0 4px 14px rgba(5,150,105,0.35);
```

---

## 7. Animation & Motion

### Timing Functions
```css
--ease-default:  cubic-bezier(0.4, 0, 0.2, 1)    /* Standard */
--ease-spring:   cubic-bezier(0.34, 1.56, 0.64, 1) /* Bouncy, for success states */
--ease-out:      cubic-bezier(0, 0, 0.2, 1)        /* Exits */
--ease-in:       cubic-bezier(0.4, 0, 1, 1)        /* Entrances */
```

### Duration
```
--duration-fast:    150ms   /* Hover states, toggles */
--duration-normal:  250ms   /* Page transitions, dropdowns */
--duration-slow:    400ms   /* Modal open, page load animations */
--duration-slower:  600ms   /* Success animations, QR reveal */
```

### Standard Animations
```css
/* Card entrance — stagger with delay */
@keyframes fadeUp {
  from { opacity: 0; transform: translateY(16px); }
  to   { opacity: 1; transform: translateY(0); }
}

/* Success checkmark draw */
@keyframes checkDraw {
  from { stroke-dashoffset: 100; }
  to   { stroke-dashoffset: 0; }
}

/* Status pulse (under_review badge) */
@keyframes pulse {
  0%, 100% { opacity: 1; }
  50%       { opacity: 0.5; }
}

/* QR code reveal */
@keyframes qrReveal {
  from { opacity: 0; transform: scale(0.8); }
  to   { opacity: 1; transform: scale(1); }
}

/* Skeleton loading shimmer */
@keyframes shimmer {
  from { background-position: -200% 0; }
  to   { background-position: 200% 0; }
}
```

### Animation Rules
- NEVER animate more than 2 properties at once
- Always use `will-change: transform` for animated elements
- Stagger card entrance by `50ms` per card
- Disable all animations when `prefers-reduced-motion: reduce` is set
- No looping animations except status pulse (which is intentional)

---

## 8. Component Library

### 8.1 Buttons

```
PRIMARY BUTTON
- Background: --color-primary
- Text: white, font-weight: 600
- Padding: 12px 24px
- Border-radius: --radius-md
- Shadow: --shadow-primary
- Hover: --color-primary-light, translateY(-1px)
- Active: scale(0.98)
- Min-width: 120px (never let buttons be too narrow)

SECONDARY BUTTON
- Background: transparent
- Border: 1.5px solid --color-primary
- Text: --color-primary
- Same padding and radius as primary
- Hover: --color-primary-soft background

DANGER BUTTON
- Background: #dc2626
- Use only for destructive actions (reject, delete)

ICON BUTTON (circular)
- Size: 40px × 40px
- Background: --color-gray-100
- Border-radius: --radius-full
- Icon size: 20px

MOBILE FULL-WIDTH BUTTON
- width: 100%
- height: 52px (larger touch target)
- font-size: --text-base
```

### 8.2 Form Inputs

```
TEXT INPUT
- Height: 48px (mobile) / 44px (desktop)
- Padding: 12px 16px
- Border: 1.5px solid --color-gray-200
- Border-radius: --radius-md
- Background: white
- Font-size: --text-base
- Focus: border-color --color-primary, box-shadow 0 0 0 3px --color-primary-soft
- Error: border-color #dc2626
- Icon left: 20px from left, color --color-gray-400

SELECT DROPDOWN
- Same height and styling as text input
- Custom chevron icon (no browser default)
- Options: white background, 48px height each

TEXTAREA
- Min-height: 100px
- Resize: vertical only
- Same border and focus styles

LABEL
- Font-size: --text-sm
- Font-weight: 500
- Color: --color-gray-600
- Margin-bottom: 6px
- Required indicator: emerald green asterisk *

ERROR MESSAGE
- Font-size: --text-xs
- Color: #dc2626
- Margin-top: 4px
- Icon: ⚠ before text
```

### 8.3 Cards

```
STANDARD CARD
- Background: white
- Border-radius: --radius-lg
- Shadow: --shadow-md
- Padding: 20px (mobile) / 24px (desktop)
- Border: none (shadow is enough)

APPLICATION CARD (citizen dashboard)
- Left border: 4px solid (color = current status color)
- Header: tracking code (monospace, bold) + status badge
- Body: document type, preferred date, submitted date
- Footer: action buttons

STAT CARD (admin dashboard)
- Icon in colored circle top-left
- Large number: --text-3xl, font-weight: 700
- Label: --text-sm, --color-gray-600
- Optional trend indicator (↑↓)

QR RECEIPT CARD
- Ticket-style with dashed divider
- Top section: app logo + name
- Middle: applicant info in 2-column grid
- Divider: dashed border
- Bottom: QR code centered + tracking code in monospace
- Shadow: --shadow-xl
```

### 8.4 Status Badges

```css
/* Base badge style */
.badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 4px 10px;
  border-radius: var(--radius-full);
  font-size: 12px;
  font-weight: 600;
  letter-spacing: 0.02em;
}

/* Each status */
.badge-submitted    { background: #f1f5f9; color: #475569; }
.badge-received     { background: #dbeafe; color: #1d4ed8; }
.badge-under-review { background: #fef3c7; color: #b45309; animation: pulse 2s infinite; }
.badge-approved     { background: #d1fae5; color: #065f46; }
.badge-rejected     { background: #fee2e2; color: #991b1b; }

/* Dot before text */
.badge::before {
  content: '';
  width: 6px; height: 6px;
  border-radius: 50%;
  background: currentColor;
}
```

### 8.5 Navigation

```
MOBILE — Bottom Navigation Bar
- Fixed to bottom of screen
- Height: 64px + safe area inset
- Background: white with top border
- 4 items max: Home, Book, Track, Profile
- Active item: primary color icon + label
- Inactive: gray icon, no label
- Icons: 24px, labels: 11px

DESKTOP — Left Sidebar
- Width: 240px (expanded) / 64px (collapsed)
- Background: --color-primary (dark indigo)
- Logo + app name at top: 64px height
- Nav items: 48px height, 16px padding
- Active item: white background, --radius-md, primary text
- Inactive: white/70 opacity text
- Collapse button at bottom
- User avatar + name at very bottom

TOPBAR (both mobile and desktop)
- Height: 60px
- White background
- Left: hamburger (mobile) or page title (desktop)
- Right: language toggle (EN | کوردی) + dark mode toggle + user avatar
```

### 8.6 Timeline Component

```
VERTICAL TIMELINE
- Left column: 40px wide — contains icon circles + vertical line
- Right column: flex-1 — contains status name, date, notes

ICON CIRCLE
- Size: 36px × 36px
- Border-radius: 50%
- Background: status color (light version)
- Icon: status-specific SVG, 18px, status color (dark version)

CONNECTOR LINE
- Width: 2px
- Background: --color-gray-200
- Height: fills space between circles
- Last item: no line

STATUS ENTRY
- Status name: font-weight: 600, status text color
- Date/time: --text-xs, --color-gray-400
- Notes: --text-sm, --color-gray-600, italic
- Entrance animation: fadeUp with stagger
```

### 8.7 File Upload Component

```
DROPZONE
- Border: 2px dashed --color-gray-200
- Border-radius: --radius-lg
- Background: --color-gray-50
- Height: 120px
- Center: upload icon + "Tap to upload or drag files here"
- Drag-over state: border-color --color-primary, background --color-primary-soft
- Font-size: --text-sm, color: --color-gray-400

FILE LIST ITEM
- Height: 56px
- Left: file type icon (PDF/IMG) in colored square, --radius-sm
- Center: filename (truncated) + file size
- Right: delete icon button OR progress bar if uploading
- Border-bottom: 1px solid --color-gray-100

PROGRESS BAR
- Height: 3px
- Background: --color-gray-200
- Fill: --color-primary
- Border-radius: full
- Transition: width 300ms ease
```

### 8.8 Multi-Step Form Progress

```
STEP INDICATOR (top of booking form)
- Horizontal row of steps connected by lines
- Each step: circle (32px) + label below
- Completed step: filled emerald circle + white checkmark
- Current step: filled primary circle + white number
- Upcoming step: gray border circle + gray number
- Connector line: 2px, gray (incomplete) or emerald (complete)
- Mobile: show only current step label (save space)
```

---

## 9. Page-by-Page Layout Specifications

### 9.1 Login / Register Page
```
MOBILE LAYOUT (single column)
- Top 40%: illustration (SVG, document/government themed)
- App logo + "Halzanîn" centered below illustration
- Tagline in Kurdish below name
- Form card: white, --radius-xl, slides up from bottom
- Inputs with icons inside (left for LTR, right for RTL)
- Primary CTA button full-width
- "Don't have an account? Register" link below

DESKTOP LAYOUT (two column)
- Left 45%: deep indigo background, logo, tagline, illustration
- Right 55%: white, centered form, max-width 400px
```

### 9.2 Citizen Dashboard
```
MOBILE LAYOUT
- Topbar: greeting "سڵاو، [Name]!" + notification bell
- Quick action card: "Book New Appointment" — full width, primary color
- Section: "My Applications" — list of application cards
- Each card: left status border + tracking code + status badge + dates
- If no applications: empty state illustration + "Book your first appointment"
- Bottom navigation

DESKTOP LAYOUT
- Left sidebar navigation
- Main content: same cards in 2-column grid
- Right sidebar (optional): quick stats + AI assistant button
```

### 9.3 Appointment Booking Form
```
MOBILE LAYOUT
- Step indicator at top (3 steps)
- Step 1: Personal info (full name, national ID)
- Step 2: Appointment details (date, time slot, document type, notes)
- Step 3: Review + submit
- Each step: single card, full width
- Bottom: Back + Continue buttons (full width on mobile)
- Sticky form autosave: subtle "Draft saved" toast bottom-left
```

### 9.4 QR Receipt Page
```
MOBILE LAYOUT
- Success animation at top (checkmark draw, 600ms)
- "Application Submitted!" heading in emerald
- Ticket card:
  - App logo + name top
  - Dashed divider
  - Info grid: Name, Tracking Code (monospace large), Date, Doc Type
  - Dashed divider
  - QR code centered (200×200)
  - "Scan to track your application" below QR
- Two buttons: "Download PDF" + "Back to Dashboard"
```

### 9.5 Public Tracking Page (no login)
```
MOBILE LAYOUT
- Topbar: Halzanîn logo only (no nav, public page)
- Search bar at top: "Enter tracking code" with scan QR button
- Application info card: name, tracking code, current status badge
- "Timeline History" section
- Each timeline entry: icon + status name + date + notes
- Current (latest) entry: highlighted with primary color
- Language toggle visible (many citizens may prefer Kurdish)
```

### 9.6 Staff Queue Page
```
MOBILE LAYOUT
- Search bar at top
- Filter chips: All | Submitted | Received | Under Review
- List of application cards (same style as citizen but with View button)

DESKTOP LAYOUT
- Sidebar navigation
- Full data table with sortable columns
- Search + filter bar above table
- Pagination at bottom
```

### 9.7 Admin Dashboard
```
DESKTOP LAYOUT (primary — admins use desktop)
- Sidebar navigation
- Stats grid: 2×3 or 3×2 cards
- Bar chart: applications per week (last 4 weeks)
- Donut chart: applications by status
- Recent applications table (last 5)
- Quick links: Manage Users, View All Applications
```

---

## 10. Iconography

### Icon Library
Use **Heroicons** (https://heroicons.com) — outline style only.

### Icon Sizes
```
16px — inline with text, table cells
20px — buttons, nav items, form input icons
24px — standalone icons, empty states
32px — feature icons in cards
48px — empty state illustrations
```

### Status-Specific Icons
```
submitted    → clock (outline)
received     → inbox-arrow-down
under_review → magnifying-glass
approved     → check-circle
rejected     → x-circle
```

### Navigation Icons
```
dashboard  → home
book       → calendar-plus
track      → map-pin
documents  → folder
profile    → user-circle
staff      → users
admin      → shield-check
logout     → arrow-right-on-rectangle
```

---

## 11. Illustration Style

### Style Guidelines
- Use **unDraw** (https://undraw.co) SVG illustrations
- Change unDraw primary color to `#1e1b4b` (our primary indigo)
- Style: flat, minimal, professional
- Subject matter: documents, government buildings, people with phones, checkmarks

### Where to Use Illustrations
- Login page: person submitting documents
- Empty states: person looking confused (no applications yet)
- Success states: person celebrating (application approved)
- 404 page: person looking lost

### Avatar System
- User avatars: generated initials in colored circles
- Color based on first letter of name (consistent per user)
- Size: 32px (nav) / 40px (profile) / 64px (profile page)
- Format: `<div class="avatar">BA</div>` — first + last initial

---

## 12. Dark Mode

### Implementation
```css
/* Default: light mode */
:root { ... light variables ... }

/* Dark mode — activated by class on <html> */
html.dark { ... dark variables ... }

/* Also respect system preference */
@media (prefers-color-scheme: dark) {
  html:not(.light) { ... dark variables ... }
}
```

### Dark Mode Toggle
- Sun/moon icon in topbar
- Clicking: toggles `dark` class on `<html>`
- Saves preference to `localStorage`
- Smooth transition: `transition: background 200ms, color 200ms`

### Dark Mode Rules
- Never use pure black (`#000`) — use `#0f172a`
- Never use pure white text — use `#f1f5f9`
- Status badge backgrounds darken: use 20% opacity of status color
- Shadows become less visible — increase opacity slightly
- Images and illustrations: add `filter: brightness(0.9)`

---

## 13. RTL (Kurdish) Language Support

### Implementation
```html
<!-- Toggle triggers this -->
<html lang="ckb" dir="rtl">
```

```css
/* RTL-specific overrides */
[dir="rtl"] .sidebar { left: auto; right: 0; }
[dir="rtl"] .badge::before { margin-right: 0; margin-left: 6px; }
[dir="rtl"] .timeline-icon { margin-right: 0; margin-left: 16px; }
[dir="rtl"] input { text-align: right; }
[dir="rtl"] .chevron-icon { transform: scaleX(-1); }
```

### Language Toggle Component
```
Location: topbar, right side (left side in RTL)
Design: pill toggle — [EN] [کوردی]
Active language: filled primary background
Inactive: transparent with border
On switch: page reloads with lang preference saved to localStorage
```

### Kurdish-Specific UX Notes
- Date format in Kurdish: `٢٠٢٦/٠٥/١٦` (Arabic-Indic numerals optional)
- Phone numbers: Kurdish format `07XX XXX XXXX`
- All error messages must be translated
- Placeholder text must be in Kurdish when RTL active

---

## 14. Mobile-First Breakpoints

```css
/* Mobile first — base styles are mobile */
/* sm */  @media (min-width: 640px)  { ... }
/* md */  @media (min-width: 768px)  { ... }
/* lg */  @media (min-width: 1024px) { ... }
/* xl */  @media (min-width: 1280px) { ... }
```

### Layout Shifts at Breakpoints
```
< 768px   — bottom nav, single column, full-width buttons
768–1023px — top nav, 2-column cards, sidebar hidden
≥ 1024px  — left sidebar visible, multi-column layouts, hover states active
```

### Touch Targets (mobile)
- Minimum tap target: 44px × 44px (Apple HIG standard)
- Buttons: minimum 48px height
- Nav items: minimum 56px height
- Table rows (mobile): minimum 64px height
- Never place two tappable elements less than 8px apart

---

## 15. Tailwind CSS Configuration

### Custom Tailwind Config (`tailwind.config.js`)
```javascript
module.exports = {
  darkMode: 'class',
  theme: {
    extend: {
      colors: {
        primary: {
          50:  '#e0e7ff',
          100: '#c7d2fe',
          500: '#312e81',
          600: '#1e1b4b',
          700: '#16134a',
        },
        accent: {
          50:  '#d1fae5',
          500: '#059669',
          600: '#047857',
        },
        status: {
          submitted:   '#64748b',
          received:    '#2563eb',
          review:      '#d97706',
          approved:    '#059669',
          rejected:    '#dc2626',
        }
      },
      fontFamily: {
        sans:    ['Outfit', 'sans-serif'],
        arabic:  ['Noto Naskh Arabic', 'serif'],
        mono:    ['JetBrains Mono', 'monospace'],
      },
      borderRadius: {
        'sm':  '6px',
        'md':  '10px',
        'lg':  '16px',
        'xl':  '24px',
      },
      animation: {
        'fade-up':    'fadeUp 0.4s ease forwards',
        'pulse-slow': 'pulse 2s infinite',
        'qr-reveal':  'qrReveal 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) forwards',
      }
    }
  },
  plugins: [
    require('@tailwindcss/forms'),
  ]
}
```

---

## 16. Page Redesign Order

Redesign pages in this exact order — one at a time, verify before moving on:

| Order | Page | Route | Priority |
|-------|------|--------|----------|
| 1 | Login + Register | `/login`, `/register` | 🔴 Critical |
| 2 | Citizen Dashboard | `/citizen/dashboard` | 🔴 Critical |
| 3 | Booking Form | `/citizen/appointment/create` | 🔴 Critical |
| 4 | QR Receipt | `/citizen/applications/{id}/qr-receipt` | 🔴 Critical |
| 5 | Public Tracking | `/track/{code}` | 🔴 Critical |
| 6 | Staff Queue | `/staff/queue` | 🟡 Important |
| 7 | Staff Application Detail | `/staff/applications/{id}` | 🟡 Important |
| 8 | Admin Dashboard | `/admin/dashboard` | 🟡 Important |
| 9 | Document Upload | `/citizen/applications/{id}/upload` | 🟢 Nice to have |
| 10 | Admin Users | `/admin/users` | 🟢 Nice to have |

---

## 17. Quality Checklist (Before Submission)

### Visual
- [ ] All pages use Outfit font for English, Noto Naskh Arabic for Kurdish
- [ ] Color palette is consistent — no random colors outside the system
- [ ] All status badges use the correct status colors
- [ ] Dark mode works on all pages
- [ ] RTL layout works correctly when Kurdish is selected
- [ ] All animations respect `prefers-reduced-motion`

### Mobile
- [ ] All pages tested on 375px width (iPhone SE)
- [ ] All tap targets are minimum 44px
- [ ] Bottom navigation works on all citizen pages
- [ ] No horizontal scroll on any page
- [ ] Forms are usable with keyboard on mobile

### Functional
- [ ] Sticky form still saves drafts after redesign
- [ ] QR code still generates and scans correctly
- [ ] PDF download works after redesign
- [ ] Email notifications still send
- [ ] All role-based redirects still work

### Demo Preparation
- [ ] Seed fresh data before supervisor demo
- [ ] Have all 3 test accounts ready
- [ ] Phone ready to scan QR code live during demo
- [ ] Mailpit open on second screen to show email arriving
- [ ] Admin dashboard showing real statistics

---

*Document prepared for: Bawan Abbas, Zhyar Kamaran, Kara Zahir, Sahand Mohammed*
*Supervised by: Dr. Bakhtiar Saeed*
*Academic Year: 2025–2026*
