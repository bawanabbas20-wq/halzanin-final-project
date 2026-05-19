# Halzanin Feature Testing Checklist

Use this file to test both:
- `Main Features (P0)`: quick smoke tests for the most important user journeys.
- `Full Feature Coverage (P1/P2)`: detailed checks for all implemented modules.

---

## Test Setup

- Base URL: `http://localhost/document-tracking-system/public`
- Test accounts:
  - Citizen: `citizen@test.com / password123`
  - Staff: `staff@test.com / password123`
  - Admin: `admin@test.com / password123`
- Browser: Chrome/Edge (desktop + mobile responsive mode)

---

## Main Features (P0 Smoke Test)

### 1) Authentication and Role Routing
- [x] Login as citizen -> redirects to `/citizen/dashboard`
- [x] Login as staff -> redirects to `/staff/dashboard`
- [x] Login as admin -> redirects to `/admin/dashboard`
- [x] Logout works and returns to login page

### 2) Citizen Appointment Core Flow
- [x] Citizen opens appointment calendar `/citizen/appointments`
- [x] Available slots load correctly for selected date
- [x] Citizen submits appointment successfully
- [x] New appointment appears on citizen dashboard

### 3) Public Tracking Core Flow
- [ ] Open `/track/{code}` with valid tracking code
- [ ] Application details and timeline/status display correctly

### 4) Staff Processing Core Flow
- [x] Staff sees appointments in calendar/day view
- [x] Staff updates appointment status
- [x] Updated status is visible to citizen

### 5) Admin Management Core Flow
- [x] Admin dashboard loads stats
- [ ] Admin can add off-day
- [ ] Admin can remove off-day

### 6) Chatbot Core Flow
- [x] Chat widget opens and sends message
- [x] `POST /chatbot/chat` returns `200`
- [x] Quick-question bubbles are visible
- [x] Quick-question bubbles send message on click
- [x] Bubbles switch language with EN/KU toggle

### 7) Notifications Core Flow
 it should be all of it just on whatsapp 
---

## Full Feature Coverage (P1/P2)

### A) Citizen Module

#### Dashboard
- [x] Dashboard loads without errors
- [x] Application/appointment cards show correct counts
- [x] Recent activity blocks render correctly

#### Appointments
- [ ] Month data endpoint works: `/citizen/appointments/month-data`
- [ ] Slots endpoint works: `/citizen/appointments/slots`
- [ ] Vault docs endpoint works: `/citizen/appointments/vault-docs`
- [x] Cannot book on blocked/off days
- [x] Cancel appointment works via patch endpoint

#### Vault
- [x] Vault index loads: `/citizen/vault`
- [x] Scan page loads: `/citizen/vault/scan`
- [x] Upload/store document works
- [x] View document in all supported formats works
- [x] Delete document works

### B) Staff Module

- [x] Staff dashboard loads
- [x] Staff calendar page loads: `/staff/calendar`
- [x] Day appointments endpoint works: `/staff/appointments/day`
- [x] Status update endpoint works: `/staff/appointments/{id}/status`
- [ ] Staff can open citizen document file: `/staff/documents/{document}/file`

### C) Admin Module

- [x] Admin dashboard loads
- [x] Off-days page loads: `/admin/off-days`
- [x] Add off-day validation works (required/duplicate/date format)
- [x] Delete off-day works
- [x] Off-day changes reflect in appointment availability

### D) Profile Module

- [x] Profile page loads
- [x] Update profile works
- [x] Password update flow works (if enabled in form)
- [x] Account delete flow works (only in test database)

### E) Chatbot + Prompt Logic

- [x] Hardcoded KRG rules are appended before Mistral request
- [x] Kurdish question receives Kurdish response
- [x] English question receives English response
- [x] API outage returns fallback response (not 500 page)
- [x] Legacy endpoint `/chat` works

### F) Notifications

- [ ] `/notifications` returns unread count + list
- [ ] `/notifications/{id}/read` marks item correctly
- [ ] `/notifications/read-all` marks all correctly
- [ ] Notification badge updates in UI

### G) Localization and UI Preferences

- [x] EN/KU toggle updates page direction (`ltr`/`rtl`)
- [x] EN/KU preference persists after refresh
- [x] Dark mode toggle works
- [x] Dark mode preference persists after refresh

### H) Route Protection / Authorization

- [x] Citizen cannot access admin routes
- [x] Citizen cannot access staff routes
- [x] Staff cannot access admin-only routes
- [x] Unauthenticated user is redirected to login for protected routes

### I) Validation / Error Handling

- [ ] Invalid form payloads show user-friendly validation messages
- [ ] Expired session during action is handled safely
- [ ] 404 pages are shown for unknown routes/resources

### J) Responsive Testing

- [ ] Citizen dashboard usable at 375px width
- [ ] Chat widget usable on mobile viewport
- [ ] Tables/cards don’t overflow on small screens
- [ ] Sidebar/mobile nav behavior is correct

---

## Suggested Release Gate

Do not release unless:
- [ ] All P0 items pass
- [ ] No critical auth/role/security bug
- [ ] No blocking issue in appointment booking/tracking/chatbot
- [ ] No unhandled 500 error in core flows

