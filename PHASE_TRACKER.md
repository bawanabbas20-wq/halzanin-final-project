# Halzanîn — Phase Tracker
*READ THIS + `PORTAL_PLAN.md` before starting any new session. This file tracks exactly where we are and what to do next.*

---

## Quick Status
| Phase | Name | Status |
|---|---|---|
| 1 | Portal homepage + planning | ✅ Complete |
| 2 | Database + 5 service forms | ⏳ Waiting for supervisor (meeting ~May 24) |
| 3 | Polish + Kurdish + Admin UI | ⏳ Not started |

**Current phase: 1 is done. Do NOT start Phase 2 until the user confirms their supervisor approved the plan.**

---

## Key Files — Know Before You Touch Anything
| File | Status | Rule |
|---|---|---|
| `resources/views/welcome.blade.php` | Phase 1 ✅ | Portal homepage — can improve design |
| `resources/views/citizen/appointment.blade.php` | Existing ✅ | Passport booking — DO NOT TOUCH |
| `routes/web.php` | Existing ✅ | All routes working — only add, never remove |
| `PORTAL_PLAN.md` | Reference doc | Full architecture, workflows, decisions |
| `public/images/` | Has passport images | Add new images here — do not remove existing |
| `public/js/translations.js` | Existing | Add new translation keys, never remove existing ones |

---

## Phase 1 — Complete ✅
Everything below is done and working.

- [x] Portal homepage (`welcome.blade.php`) — full rewrite as government portal
- [x] Official announcement bar at top of page
- [x] Hero section with image panel (accepts `hero-building.jpg`)
- [x] 5 ministry cards — all services marked "Coming Soon"
- [x] How It Works (4 steps)
- [x] Platform Features (4 cards)
- [x] Inline application tracker (submits to `/track/{code}`)
- [x] FAQ section (8 questions, native accordion)
- [x] Footer (3-column)
- [x] Dark mode, Kurdish RTL, all screen sizes
- [x] Chatbot widget (guest-aware welcome message)
- [x] `PORTAL_PLAN.md` created with full architecture doc
- [x] `PHASE_TRACKER.md` created (this file)
- [x] Memory saved for future sessions

---

## Phase 2 — After Supervisor Approval
**Before starting:** User must confirm supervisor approved the portal idea and the specific service flows in `PORTAL_PLAN.md`.

### Step 1 — Database (do all at once)
- [ ] `php artisan make:migration create_ministries_table`
- [ ] `php artisan make:migration create_services_table`
- [ ] `php artisan make:migration add_ministry_id_to_users_table`
- [ ] `php artisan make:migration add_service_id_to_appointments_table`
- [ ] `php artisan make:migration add_service_id_to_applications_table`
- [ ] Run migrations
- [ ] Create `Ministry` model + `Service` model
- [ ] Create `database/seeders/MinistriesAndServicesSeeder.php` with all data from PORTAL_PLAN.md
- [ ] Run seeder

### Step 2 — Ministry Admin role
- [ ] Add `'ministry_admin'` to valid roles (or use sub-role system — see PORTAL_PLAN.md)
- [ ] Scope admin queries by `ministry_id` for non-super-admins
- [ ] Add ministry assignment UI in admin user management page

### Step 3 — Build 5 service forms (one per ministry)
Each service needs: form fields, required docs list, status flow

**3a — Civil Registry: National ID Card**
- Statuses: Submitted → Documents Verified → Under Processing → Ready for Pickup → Completed
- Required docs: Birth cert scan, Family registry scan, Photo
- Form fields: Full name, DOB, Reason (new/renewal/lost), Address

**3b — Traffic Police: Driving License**
- Statuses: Submitted → Docs Verified → Theory Test Scheduled → Theory Passed → Practical Test Scheduled → License Ready → Collected
- Required docs: National ID, Medical certificate, Photo, Old license (if renewal)
- Form fields: License type (motorcycle/car/heavy), New or renewal, Medical clinic name

**3c — Electricity: New Connection**
- Statuses: Submitted → Docs Reviewed → Inspection Scheduled → Inspection Completed → Fee Assessed → Installation Scheduled → Connected
- Required docs: National ID, Property deed or rental contract, Building completion certificate
- Form fields: Address, Property type, Requested KW load, Owner/tenant

**3d — Water: New Connection**
- Statuses: Submitted → Docs Reviewed → Inspection Scheduled → Approved → Installation Scheduled → Connected
- Required docs: National ID, Property deed or rental contract
- Form fields: Address, Property type, Water usage type

**3e — Business Registration: Business License**
- Statuses: Submitted → Name Check → Under Legal Review → Approved → Fee Pending → License Ready → Completed
- Required docs: National ID (all owners), Lease agreement, Criminal record clearance
- Form fields: Business name (EN + KU), Business type, Activity description, Address, Capital amount

### Step 4 — Wire services to portal
- [ ] Service detail page (`/services/{slug}`) — shows requirements, "Apply Now" button
- [ ] Citizen appointment form: pre-select service from portal click
- [ ] Update existing passport to use new `service_id` system
- [ ] Flip Civil Registry passport service from Coming Soon → Active on portal

### Step 5 — Kurdish translations
- [ ] Add all new service names, ministry names, form labels to `public/js/translations.js`
- [ ] Test RTL layout on all new pages

---

## Phase 3 — Polish
- [ ] Admin: services management UI (toggle active/inactive, edit names)
- [ ] Homepage statistics bar with seeded real-looking numbers
- [ ] Chatbot updated to know about all services and their requirements
- [ ] Office locator section (addresses per ministry)
- [ ] Service-specific PDF receipt templates

---

## Images Still Needed
The following images should be placed in `public/images/` when available:

| Filename | Where used | What it should be |
|---|---|---|
| `hero-building.jpg` | Hero section right panel | Kurdistan government/parliament building or Sulaymaniyah Citadel. Landscape, min 900×700px. Professional photo. |
| `portal-citizen.jpg` | Features section (optional) | Person using phone/laptop for online services. Middle Eastern appearance preferred. From Unsplash or similar. |

The page works and looks great without these images. Adding them makes the hero section much more impactful.

---

## Do NOT Do (Rules Carried Forward)
1. Never touch the passport flow (`citizen/appointment.blade.php`, appointment routes)
2. Never remove existing routes from `web.php`
3. Never remove existing translation keys from `translations.js`
4. Never change the design system colors/fonts (PORTAL_PLAN.md has the tokens)
5. Never start Phase 2 work without user confirming supervisor approval
6. Mobile-first always — test on 375px width first
7. No emoji Unicode characters in any view files — SVG icons only

---

## Deadlines
- **2026-05-24 (Sunday)** — Report due to supervisor. Portal homepage must be demo-ready. ✅ Done.
- **2026-06-01** — Final project submission. All of Phase 2 should be complete.
