# Comprehensive Testing Results

## 🔴 Critical — Test these first

### 1. Authentication

- [X] Go to http://localhost/final%20project/public → redirects to login
- [X] Login as citizen@test.com / password123 → lands on citizen dashboard
- [X] Login as staff@test.com / password123 → lands on staff dashboard
- [X] Login as admin@test.com / password123 → lands on admin dashboard
- [ ] Register new account → lands on citizen dashboard
- [ ] Logout → redirects to login page (not Laravel welcome page)
- [ ] Citizen tries /admin/dashboard → gets 403

### 2. Full Citizen Journey (most important)

- [ ] Login as citizen
- [ ] Click "Book Appointment"
- [ ] Fill Step 1 (name + national ID) → click Continue
- [ ] Fill Step 2 (date + time + document type) → click Continue
- [ ] Step 3 shows review summary with correct data
- [ ] Click Submit → lands on QR receipt page
- [ ] QR receipt shows: name, tracking code, QR code, date
- [ ] Click "Download PDF" → PDF downloads with QR visible
- [ ] Open incognito → go to /track/TRK-XXXXXXXX → tracking page loads without login
- [ ] Tracking page shows: submitted status in timeline

### 3. Sticky Form Test

- [ ] Go to booking form
- [ ] Type something in Full Name
- [ ] Wait 1 second
- [ ] Open DevTools Network tab → see save-draft POST request with 200 status
- [ ] Refresh the page → Full Name is still there

### 4. Staff Journey

- [ ] Login as staff
- [ ] See application queue with all submitted applications
- [ ] Click filter chip "Received" → list filters instantly
- [ ] Type in search bar → filters by name/tracking code
- [ ] Click View on an application
- [ ] Select new status from dropdown → click Update Status
- [ ] See success message
- [ ] Go back to queue → status badge updated
- [ ] Open Mailpit at http://localhost:8025 → see notification email

### 5. Admin Journey

- [ ] Login as admin
- [ ] See 8 stat cards with correct numbers
- [ ] See bar chart with applications this week
- [ ] Click User Management → see all users
- [ ] Change a user's role → see success message
- [ ] Try to change own role → see 403 or error message

### 6. QR & Tracking

- [ ] Scan the QR code with your phone → opens tracking page on phone
- [ ] Tracking page shows correct status and timeline
- [ ] After staff updates status → refresh tracking page → new status appears in timeline

### 7. Dark Mode & RTL

- [ ] Click moon icon → dark mode activates on current page
- [ ] Navigate to another page → dark mode persists
- [ ] Click "کوردی" toggle → page switches to RTL
- [ ] Navigate to another page → RTL persists
- [ ] Refresh page → dark mode and language preference saved

### 8. Document Upload

- [ ] Staff sets an application to "Received"
- [ ] Login as citizen → see "Upload Documents" button on that application
- [ ] Click → upload form loads
- [ ] Check all 3 checkboxes → submit button enables
- [ ] Upload 3 files → redirected to dashboard with success message
- [ ] Check HeidiSQL documents table → 3 rows created

## 🟡 Secondary — Check these after

### 9. Mobile responsiveness

- [ ] Open DevTools → toggle mobile view (F12 → phone icon)
- [ ] Citizen dashboard → bottom nav visible, cards stack properly
- [ ] Booking form → all steps work on mobile
- [ ] Track page → readable on 375px width

### 10. Security

- [ ] Login as citizen → try /staff/queue → get 403
- [ ] Login as citizen → try /citizen/applications/999/qr-receipt (someone else's) → get 403
- [ ] Logout → try going back with browser back button → redirected to login
