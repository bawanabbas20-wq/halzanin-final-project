# Halzanîn — Government Services Portal: Full Plan
*Last updated: 2026-05-21 | Status: Phase 1 complete — awaiting supervisor sign-off before Phase 2*

---

## Project Goal
Transform Halzanîn from a single-service (passport) app into a **Kurdistan Government Services Portal**. Citizens submit applications, upload documents, book appointments, and track status for ANY government service — all from one unified platform, without leaving home.

---

## What Is Built (Do Not Break)
- Full citizen/staff/admin role system with OTP email verification
- Passport application flow (appointments, document upload, QR receipt, PDF)
- Staff queue, application review, status updates, QR check-in
- Admin user management, task types, off-days, sub-roles/permissions
- Document vault (citizen), public tracking endpoint
- AI chatbot (Gemini), dark mode, Kurdish RTL support
- Email notifications on status change

**Rule: Do not touch the passport flow. Only update navigation to integrate it into the portal.**

---

## Architecture Decisions

### Public Portal Homepage
- Fully public-facing — no login required to browse services
- Shows all ministries and their services
- Active services link to login → service form
- Coming Soon services show a disabled badge
- Contains: hero, ministry grid, how-it-works, platform features, inline track widget, FAQ, footer
- Supports dark mode, Kurdish RTL, all screen sizes (mobile-first)

### Staff & Admin Structure: Option B — Ministry-Isolated

```
Super Admin  (existing 'admin' role)
  └── Sees and manages everything across all ministries
  └── Manages ministries, services, all users

Ministry Admin  (new scoped role — 'ministry_admin')
  └── One per ministry (e.g. Civil Registry Admin)
  └── Manages staff within their ministry only
  └── Views only their ministry's applications and appointments
  └── Can toggle off-days for their ministry

Staff  (existing 'staff' role — now ministry-assigned)
  └── Assigned to exactly one ministry
  └── Sees ONLY applications for their ministry's services
  └── Same dashboard layout, filtered by ministry
```

One portal, one login system — isolation is achieved through data filtering, not separate apps.

### Authentication & Users
- Login/Register pages: **unchanged**
- Citizen, Staff, Admin roles: **unchanged**
- New: `ministry_id` column on users (for staff and ministry admins)
- New: `ministry_admin` as a sub-role or extended role
- Registration page copy updated from "Passport" to generic "government services"

---

## Database Changes (Phase 2)

### New Tables
```
ministries
  id, name, name_ku, icon (svg name), color (hex), order (int), created_at

services
  id, ministry_id (FK), name, name_ku, slug (unique), description, description_ku
  is_active (boolean, default false)
  required_documents (JSON array of document names)
  form_fields (JSON — service-specific form field definitions)
  task_type_id (FK → task_types, nullable)
  estimated_days (int — processing time estimate)
  created_at
```

### Modified Tables
```
users
  + ministry_id (FK → ministries, nullable) — for staff and ministry admins

appointments
  + service_id (FK → services, nullable)

applications
  + service_id (FK → services, nullable)
```

---

## Ministries & Services

### Ministry 1 — Civil Registry (تۆماری مەدەنی)
Color: #1B4F8A | Icon: identification

| Service | Slug | Status |
|---|---|---|
| Passport Application | passport | ✅ Active (existing — do not rebuild) |
| National ID Card | national-id | ✅ Active (Phase 2) |
| Birth Certificate | birth-certificate | ✅ Active (Phase 2) |
| Marriage Certificate | marriage-certificate | 🔒 Coming Soon |
| Death Certificate | death-certificate | 🔒 Coming Soon |

### Ministry 2 — Traffic Police (پۆلیسی ترافیک)
Color: #dc2626 | Icon: car/shield

| Service | Slug | Status |
|---|---|---|
| Driving License | driving-license | ✅ Active (Phase 2) |
| Vehicle Registration | vehicle-registration | 🔒 Coming Soon |
| Traffic Fine Payment | traffic-fine | 🔒 Coming Soon |

### Ministry 3 — Electricity Directorate (بەرپرسایەتی کارەبا)
Color: #d97706 | Icon: lightning bolt

| Service | Slug | Status |
|---|---|---|
| New Connection | electricity-connection | ✅ Active (Phase 2) |
| Service Complaint | electricity-complaint | 🔒 Coming Soon |
| Meter Reading Issue | electricity-meter | 🔒 Coming Soon |

### Ministry 4 — Water Directorate (بەرپرسایەتی ئاو)
Color: #0284c7 | Icon: water drop

| Service | Slug | Status |
|---|---|---|
| New Connection | water-connection | ✅ Active (Phase 2) |
| Service Complaint | water-complaint | 🔒 Coming Soon |

### Ministry 5 — Business Registration (تۆماری بازرگانی)
Color: #059669 | Icon: briefcase/building

| Service | Slug | Status |
|---|---|---|
| Business License | business-license | ✅ Active (Phase 2) |
| Trade License Renewal | trade-renewal | 🔒 Coming Soon |

---

## Realistic Service Workflows (Phase 2 Implementation)

### National ID Card — Civil Registry
**Real process:** Fill form → submit docs at office → staff verifies against registry → ID printed → citizen returns to collect  
**Virtual:** Submit form online → upload docs → book verification appointment (one short visit) → staff reviews → notified "Ready for Pickup"  
**Statuses:** `Submitted` → `Documents Verified` → `Under Processing` → `Ready for Pickup` → `Completed`  
**Required docs:** Birth certificate (scan), Family registry book (scan), Passport photo (JPG), Current ID if renewal

### Driving License — Traffic Police
**Real process:** Submit docs → medical cert → theory test at office → practical test at office → license issued  
**Virtual:** Submit form + docs → staff verifies → theory test appointment → staff records result → practical test appointment → license ready  
**Statuses:** `Submitted` → `Documents Verified` → `Theory Test Scheduled` → `Theory Test Passed` → `Practical Test Scheduled` → `License Ready` → `Collected`  
**Required docs:** National ID (scan), Medical fitness certificate, Passport photo, Old license if renewal  
**Form fields:** License type (motorcycle/car/heavy vehicle), New or renewal, Medical clinic name, Emergency contact

### Electricity New Connection — Electricity Directorate
**Real process:** Fill application → submit docs → site inspection by technical team → fee calculated → citizen pays → installation  
**Virtual:** Submit form + docs → staff approves docs → inspection appointment scheduled (technician visits property) → fee notification → installation date set  
**Statuses:** `Submitted` → `Documents Reviewed` → `Inspection Scheduled` → `Inspection Completed` → `Fee Assessed` → `Installation Scheduled` → `Connected`  
**Required docs:** National ID, Property deed or rental contract, Building completion certificate  
**Form fields:** Address, Property type (residential/commercial), Requested load (KW), Owner or tenant, Floor/apartment

### Water New Connection — Water Directorate
**Real process:** Same structure as electricity — application → docs → inspection → fee → installation  
**Virtual:** Same workflow as electricity  
**Statuses:** `Submitted` → `Documents Reviewed` → `Site Inspection Scheduled` → `Approved` → `Installation Scheduled` → `Connected`  
**Required docs:** National ID, Property deed or rental contract, Location sketch  
**Form fields:** Address, Property type, Water usage type, Distance from main line (approximate)

### Business License — Business Registration
**Real process:** Choose business type → submit docs → name availability check → legal review → pay fee → license issued  
**Virtual:** Submit form + docs → staff checks name availability → legal review → fee notification → license ready for collection  
**Statuses:** `Submitted` → `Name Availability Check` → `Under Legal Review` → `Approved` → `Fee Pending` → `License Ready` → `Completed`  
**Required docs:** National ID of all owners, Business premises lease agreement, No-criminal-record certificate  
**Form fields:** Business name (EN + KU), Business type (sole trader/partnership/LLC), Activity description, Business address, Estimated capital, All owner names + national IDs

---

## Implementation Phases

### Phase 1 — Complete (before supervisor meeting)
- [x] Portal homepage with all 5 ministries and all services (all marked Coming Soon)
- [x] Navigation updated to reflect portal scope (not passport-only)
- [x] Planning document created
- [x] Existing passport flow untouched

### Phase 2 — After Supervisor Approval (May 25 – June 1)
- [ ] Migrations: `ministries`, `services` tables
- [ ] Add `ministry_id` to `users`, `service_id` to `appointments` + `applications`
- [ ] Seed all ministries and services (active + coming soon)
- [ ] Ministry Admin role (scoped admin — sees only own ministry)
- [ ] Staff ministry assignment (UI in admin panel)
- [ ] National ID service — form + workflow
- [ ] Driving License service — form + workflow
- [ ] Electricity New Connection — form + workflow
- [ ] Water New Connection — form + workflow
- [ ] Business License — form + workflow
- [ ] Kurdish translations for all new content
- [ ] Flip passport service from "Coming Soon" to "Active" on portal
- [ ] Admin: service management UI (toggle active/inactive)

### Phase 3 — Polish
- [ ] Statistics on portal homepage (seeded realistic numbers)
- [ ] Chatbot updated to know about all services
- [ ] Office locator section (addresses per ministry)
- [ ] Service-specific PDF receipts

---

## Design System (Do Not Change)

| Token | Value |
|---|---|
| Brand | `#1B4F8A` (navy blue) |
| Brand dark | `#163F6E` |
| Background light | `#EFEDE8` (warm beige) |
| Background dark | `#141414` |
| Card light | `#ffffff` |
| Card dark | `#1F1F1F` |
| Accent green | `#059669` |
| Font (EN) | Outfit |
| Font (KU) | Noto Naskh Arabic |
| Dark mode | Class-based, localStorage |
| Language | EN/KU toggle, RTL, localStorage |
| Mobile nav | Fixed bottom bar, 68px |

---

## Key Rules for All Future Development
1. **Never touch the passport flow** — only update navigation around it
2. **Mobile-first always** — 90% of users are on phones
3. **No generic AI design** — follow the existing design system exactly
4. **Kurdish translations** for all user-facing strings (data-i18n attributes)
5. **No code errors** — test every route and form before marking complete
6. **Ministry isolation** — staff/ministry-admin can never see other ministries' data
7. **All services Coming Soon** until supervisor approves specific service implementation
