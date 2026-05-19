---
name: project-halzanin
description: Core project context for Halzanîn - Kurdish government document tracking system
metadata:
  type: project
---

Laravel 10 project called "Halzanîn" — a Kurdish government document tracking system.

**Why:** Built to help Iraqi Kurdistan citizens track their document/passport applications at the Directorate.

**Stack:** Laravel 10, Tailwind CSS, Vite, Blade components, no frontend framework (vanilla JS).

**Roles:** citizen, staff, admin — each has a separate dashboard under `resources/views/citizen/`, `staff/`, `admin/`.

**Layout:** `halzanin-app.blade.php` is the main authenticated layout (sidebar + mobile bottom nav). `halzanin-auth-layout.blade.php` is the auth layout (split panel). `track.blade.php` is a standalone public page.

**Features added so far:**
- Toast notifications (`components/toast.blade.php`, `showToast(type, title, message, duration)`)
- AI Chatbot widget (inline in `halzanin-app.blade.php`, posts to `/chatbot` route)
- WhatsApp notifications (`Services/WhatsAppService.php`, triggered on status update)
- QR camera scanner on track page (html5-qrcode library)
- Confirmation modals (in staff/admin views)

**How to apply:** When adding UI features, wire flash messages using `->with('success'|'error'|'info'|'warning', '...')` in controllers — the layouts handle toasts automatically.
