# Halzanîn — Phase Tracker
*READ THIS + `PORTAL_PLAN.md` before starting any new session. This file tracks exactly where we are and what to do next.*

---

## Quick Status
| Phase | Name | Status |
|---|---|---|
| 1 | Portal homepage + planning | ✅ Complete |
| 2 | Database + 5 service forms | ✅ Complete |
| 3 | Polish + Kurdish + Admin UI | ✅ Complete (4/5 — PDF receipts pending) |

**Current phase: Phase 3 is nearly done. Only remaining item is service-specific PDF receipt templates. Final submission due 2026-06-01.**

---

## Key Files — Know Before You Touch Anything
| File | Status | Rule |
|---|---|---|
| `resources/views/welcome.blade.php` | ✅ Phase 1–3 done | Portal homepage — Office Locator added; can improve design |
| `resources/views/citizen/appointment.blade.php` | Existing ✅ | Passport booking — DO NOT TOUCH |
| `resources/views/services/show.blade.php` | ✅ Phase 2 done | Service detail page — full nav/footer, rewritten |
| `resources/views/admin/services/index.blade.php` | ✅ Phase 3 done | Admin services management UI |
| `app/Http/Controllers/ChatbotController.php` | ✅ Phase 3 done | Full 5-ministry knowledge base |
| `app/Http/Controllers/AdminController.php` | ✅ Phase 3 done | `services()` + `toggleService()` added |
| `routes/web.php` | Existing ✅ | All routes working — only add, never remove |
| `public/js/translations.js` | ✅ Phase 2–3 done | Full Kurdish portal translations added |
| `PORTAL_PLAN.md` | Reference doc | Full architecture, workflows, decisions |
| `public/images/` | Has logo + hero image | Add new images here — do not remove existing |

---

## Phase 1 — Complete ✅
Everything below is done and working.

- [x] Portal homepage (`welcome.blade.php`) — full rewrite as government portal
- [x] Official announcement bar at top of page
- [x] Hero section with image panel (`hero-building.png`)
- [x] 5 ministry cards — all services initially marked "Coming Soon"
- [x] How It Works (4 steps)
- [x] Platform Features (4 cards)
- [x] Inline application tracker (submits to `/track/{code}`)
- [x] FAQ section (8 questions, native accordion)
- [x] Footer (3-column)
- [x] Dark mode, Kurdish RTL, all screen sizes
- [x] Chatbot widget (guest-aware welcome message)
- [x] `PORTAL_PLAN.md` created with full architecture doc
- [x] Memory saved for future sessions

---

## Phase 2 — Complete ✅

### Step 1 — Database ✅
- [x] `ministries` table + migration
- [x] `services` table + migration (with `form_schema`, `statuses`, `required_documents` JSON columns)
- [x] `ministry_id` on `users` table (staff scoping)
- [x] `service_id` on `applications` / `appointments` tables
- [x] `Ministry` model + `Service` model
- [x] `MinistriesAndServicesSeeder` — all 5 ministries, 15 services seeded (6 active)
- [x] Migrations run, seeder run

### Step 2 — Ministry staff role ✅
- [x] 3-tier staff system: staff + sub-roles + task-types
- [x] `ministry_id` scoping — staff see only their ministry's applications
- [x] Ministry assignment UI in admin user management page
- [x] Sub-roles system (`SubRole` model, pivot)

### Step 3 — 5 service forms ✅
- [x] **Civil Registry: National ID Card** — statuses, required docs, dynamic form
- [x] **Civil Registry: Birth Certificate** — statuses, required docs, dynamic form
- [x] **Traffic Police: Driving License** — 7-step status flow, theory/practical test stages
- [x] **Electricity: New Connection** — 7-step flow incl. inspection + fee + install
- [x] **Water: New Connection** — 6-step flow
- [x] **Business Registration: Business License** — name check + legal review flow

### Step 4 — Wire services to portal ✅
- [x] Service detail page (`/services/{slug}`) — standalone HTML with full nav + footer
- [x] "Apply" links on homepage (active services only — from DB query)
- [x] "Coming Soon" pills remain for inactive services
- [x] Ministry card footer shows live active-service count
- [x] Logo in authenticated app navbar links back to portal homepage (`/`)

### Step 5 — Kurdish translations ✅
- [x] All service names, ministry names added to `translations.js`
- [x] Portal homepage keys (hero, stats, ministries, steps, features, FAQ, footer) translated
- [x] Office locator keys translated (ku + en)
- [x] RTL layout tested on all portal sections

---

## Phase 3 — Complete ✅ (4/5)

- [x] **Admin: Services Management UI** — `/admin/services` — toggle active/inactive per service, per ministry; summary cards; preview links to public service pages
- [x] **Homepage live statistics** — `portalStats` passed from route; `Ministry::count()`, `Service::count()`, `Application::count()`, `User::where('role','citizen')->count()` all live from DB
- [x] **Chatbot full knowledge base** — System prompt updated to all-portal assistant; `$krgPassportRulesPrompt` covers all 5 ministries (6 active services, required docs, process steps, rules); `fallbackReply()` handles all service types in English + Kurdish
- [x] **Office Locator section** — `#offices` section on homepage; 5 ministry cards with address, working hours (Sun–Thu 8:00–15:00), phone; color-coded by ministry; responsive (3-col → 2-col → 1-col); linked in navbar + footer
- [ ] **Service-specific PDF receipt templates** — Per-service PDF with QR code, service name, and ministry branding *(still to do)*

---

## Images — Status
| Filename | Where used | Status |
|---|---|---|
| `hero-building.png` | Hero section right panel | ✅ Added |
| `halzanin-logo.png` | Navbar + footer | ✅ Added |

---

## Do NOT Do (Rules Carried Forward)
1. Never touch the passport flow (`citizen/appointment.blade.php`, appointment routes)
2. Never remove existing routes from `web.php`
3. Never remove existing translation keys from `translations.js`
4. Never change the design system colors/fonts (PORTAL_PLAN.md has the tokens)
5. Mobile-first always — test on 375px width first
6. No emoji Unicode characters in any view files — SVG icons only

---

## Deadlines
- **2026-05-24 (Sunday)** — Report due to supervisor. Portal homepage demo-ready. ✅ Done.
- **2026-06-01** — Final project submission. Phase 3 PDF receipts is the only remaining item.
