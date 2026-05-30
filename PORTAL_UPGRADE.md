# Halzanîn Portal Upgrade — Tracker

## Goal
Expand the portal from a single-ministry (passport) UX to a full multi-ministry
e-government platform with 5 directorates, distinct ministry colors, per-ministry
appointment booking, scoped staff dashboards, and a rebuilt admin overview.

---

## Ministries & Colors

| Ministry            | Color     | Slug                  | Active Services |
|---------------------|-----------|-----------------------|-----------------|
| Civil Registry      | `#1B4F8A` | `civil-registry`      | National ID, Birth Certificate |
| Traffic Police      | `#dc2626` | `traffic-police`      | Driving License |
| Electricity         | `#d97706` | `electricity`         | New Connection |
| Water               | `#0284c7` | `water`               | New Connection |
| Business Reg.       | `#059669` | `business-registration` | Business License |

---

## Key Architecture Notes

- `appointments.service_id` already exists (nullable FK) — Phase 3 makes it required
- `users.ministry_id` already exists — staff assignment is DB-ready, not yet surfaced in UI
- Ministry colors always queried from `ministries.color` — never hardcoded in views
- Document requirements come from `services.required_documents` JSON — Phase 3 replaces hardcoded JS
- Existing calendar AJAX endpoints (`monthData`, `slots`, `vaultDocs`) are extended, not rewritten
- `OffDay::isOffDay()` becomes ministry-aware — null `ministry_id` = global closure (all ministries)
- Tracking code format (`TRK-YYMMDD-XXXXXX`) stays unchanged

---

## Phases

---

### ✅ Phase 1 — Data Layer
*Foundation. No UI changes. Safe stopping point after this phase.*

**Files changed:**
- `database/migrations/2026_05_30_000001_add_ministry_id_to_off_days_table.php` ✅
- `app/Models/OffDay.php` ✅
- `app/Models/Appointment.php` ✅
- `app/Http/Controllers/CitizenController.php` ✅

**Changes:**
- [x] Migration: `ministry_id` (nullable FK → ministries) added to `off_days`
      — null means global closure; ministry-specific value means only that ministry is closed
- [x] `OffDay::isOffDay(date, ministry_id = null)` — checks global + ministry-specific off days
- [x] `OffDay::offDatesForMonth(year, month, ministry_id = null)` — returns global + ministry dates
- [x] `Appointment::bookedSlotsForDate(date, service_id = null)` — scoped by service when provided
- [x] `Appointment::availableSlotsForDate(date, service_id = null)` — scoped by service
- [x] `Appointment::bookingCountForDate(date, service_id = null)` — scoped by service
- [x] `CitizenController::index()` — removed `whereNull('service_id')` bug; added `upcoming` to appStats

---

### ✅ Phase 2 — Citizen Dashboard UI
*One main view + layout sidebar. Safe stopping point after this phase.*

**Files changed:**
- `resources/views/citizen/dashboard.blade.php` ✅
- `resources/views/layouts/halzanin-app.blade.php` ✅
- `app/Http/Controllers/CitizenController.php` ✅

**Changes:**
- [x] Ministry quick-access grid — 5 cards, each with top-border + icon in ministry color, active service count, "Apply →" link
- [x] Hero banner CTA — "Passport Booking" button → "Book Appointment"
- [x] Sidebar nav — "Passport Booking" label → "Appointments"
- [x] 4th stat card — "Upcoming Appointments" (purple, calendar icon)
- [x] Stats grid — changed from `grid-cols-3` to `grid-cols-2 sm:grid-cols-4`
- [x] Application cards — ministry color dot + name badge in card footer
- [x] Appointments section — renamed "Passport Appointments" → "My Appointments";
      date card header now uses ministry color; ministry dot + name shown inline;
      falls back gracefully for old appointments without `service_id`

---

### ✅ Phase 3 — Booking Flow (Per Ministry / Service)
*Biggest phase. Reuses existing calendar UX entirely — parameterized by service.*

**Files changed:**
- `database/migrations/2026_05_30_000002_update_appointments_unique_constraint.php` ✅
- `resources/views/citizen/appointments/index.blade.php` ✅ (new picker)
- `resources/views/citizen/appointments/calendar.blade.php` ✅ (service-aware)
- `app/Http/Controllers/AppointmentController.php` ✅
- `routes/web.php` ✅

**Changes:**
- [x] Migration: dropped global `(date, time_slot)` unique; added `(date, time_slot, service_id)` — services share slots independently
- [x] Picker page: 5 ministry cards with color-top-border, each lists active services (Book button) + inactive (Coming Soon); shows processing time + doc count per service
- [x] Calendar: `{ministry}/{service}` route params; ministry color on accent bars, step indicators, buttons, summary text; breadcrumb navigation
- [x] Document requirements: `SERVICE_DOCS` from `$service->required_documents` JSON — replaces all hardcoded JS `DOC_REQS`
- [x] Vault matching: `VAULT_MAP` built server-side via `buildVaultTypeMap()` keyword matching — replaces hardcoded `VAULT_TYPES`
- [x] Doc type dropdown removed — service name auto-sent as `document_type`; Step 1 shows read-only service + ministry badge
- [x] LocalStorage keys namespaced by `service_id` so different services don't overwrite each other
- [x] `AppointmentController::index()` — picker entry point
- [x] `AppointmentController::calendar()` — scopes counts + off-days to ministry
- [x] `AppointmentController::monthData()` — scoped by `service_id`; ministry-aware off-days
- [x] `AppointmentController::slots()` — scoped by `service_id`; ministry-aware off-days
- [x] `AppointmentController::store()` — `service_id` required; scoped conflict checks; sets `service_id` on both appointment and application
- [x] Route `citizen.appointments.calendar` → picker; new `citizen.appointments.book` → per-service calendar
- [x] Named routes ordered so specific paths (month-data, slots, vault-docs) resolve before `{ministry}/{service}` wildcard

---

### ✅ Phase 4 — Staff Dashboard & Calendar
*Staff sees only their assigned ministry.*

**Files changed:**
- `app/Http/Controllers/StaffController.php` ✅
- `app/Http/Controllers/ApplicationController.php` ✅ (queue() scoping)
- `resources/views/staff/dashboard.blade.php` ✅
- `resources/views/staff/calendar.blade.php` ✅

**Changes:**
- [x] Dashboard greeting — ministry badge with color dot (hidden if no ministry assigned)
- [x] Stats — all 4 counters scoped to staff's `ministry_id` via controller; pending badge + CTA use ministry color
- [x] Calendar slot counts — scoped by `ministry_id`; off-days ministry-aware
- [x] Appointment cards — service name badge in ministry color; `dayAppointments()` ministry-scoped
- [x] Both calendar accent bars use `$ministry->color` dynamically

---

### ✅ Phase 5 — Admin Dashboard
*Purely additive to existing layout.*

**Files changed:**
- `app/Http/Controllers/AdminController.php` ✅
- `resources/views/admin/dashboard.blade.php` ✅
- `resources/views/layouts/halzanin-app.blade.php` ✅ (sidebar rename)

**Changes:**
- [x] Ministry Overview section — 5 cards with colored top-border, ministry icon, app count, active services count; "active services" badge in section header; links to admin.services
- [x] Recent Applications table — "Ministry" column with color dot + name; colspan 4→5 for empty state
- [x] Quick Actions — "Manage Services" added as 3rd button
- [x] Sidebar — "Off Days" → "Appointment Availability"
- [x] `AdminController::index()` — `active_services` in stats; `$ministryStats` via `withCount`; `service.ministry` eager-loaded on `$recent`

---

## Session Log

| Date       | Phase | Work Done |
|------------|-------|-----------|
| 2026-05-30 | 1     | Created tracker. Phase 1 complete: off_days ministry scoping, Appointment service-scoped methods, CitizenController bug fix. |
| 2026-05-30 | 2     | Phase 2 complete: ministry grid on citizen dashboard, 4-stat card row, hero CTA updated, "My Appointments" rename, ministry color badges throughout, sidebar label renamed. |
| 2026-05-30 | 5     | Phase 5 complete: ministry overview section on admin dashboard, Ministry column in recent apps table, Manage Services quick action, sidebar "Off Days" renamed, active_services stat added. |
| 2026-05-30 | 4     | Phase 4 complete: staff dashboard ministry badge + scoped stats, calendar slot counts scoped to ministry, service name badge on appointment cards, ministry colors on all accent bars. |
| 2026-05-30 | 3     | Phase 3 complete: per-service appointment booking flow. Picker page, service-aware calendar with ministry color theming, dynamic doc requirements, per-service slot scoping, service_id on appointments + applications. |
