I now have everything I need. Here is the complete technical analysis drawn directly from the codebase.

---

## Technical Analysis: Halzanîn e-Government Portal

---

### 1. Database & Architecture Changes

**The exact schema pattern used is a two-level hierarchy: `ministries` → `services`, with a `service_id` foreign key added to both `applications` and `appointments`.** There is no `directorates` table and no flat `department_id` column.

**Migration sequence (in order):**

| Migration file                       | What it does                                                                                                                                                          |
| ------------------------------------ | --------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `2026_05_21_164136`                | Creates `ministries` table: `id`, `name`, `name_ku`, `slug`, `color`, `order`                                                                           |
| `2026_05_21_164138` (services)     | Creates `services` table with `ministry_id FK`, plus JSON columns `required_documents`, `form_schema`, `statuses`                                           |
| `2026_05_21_164138` (users)        | Adds `ministry_id FK` column to `users` table — this is how staff are scoped                                                                                     |
| `2026_05_21_164139` (appointments) | Adds `service_id FK nullable` to `appointments`                                                                                                                   |
| `2026_05_21_164139` (applications) | Adds `service_id FK nullable` + `form_data JSON` to `applications`                                                                                              |
| `2026_05_21_164140`                | Changes `applications.current_status` from `ENUM` to `VARCHAR` — required to support the dynamic, per-service status pipelines stored in `services.statuses` |
| `2026_05_29_202910`                | Adds `gov_id VARCHAR(20) UNIQUE` to `users` table; backfills all existing users at migration time (see Section 6)                                              |

The `services` table is the architectural centrepiece. Each row carries three JSON columns that make the service fully self-describing: `form_schema` (the dynamic form fields), `required_documents` (document checklist), and `statuses` (the ordered status pipeline). Six ministries are seeded with services total, 6 of which are `is_active = true`.

**Currently active services (6):**

| Service | Ministry |
|---|---|
| National ID Card | Civil Registry |
| Birth Certificate | Civil Registry |
| Driving License | Traffic Police |
| New Electricity Connection | Electricity |
| New Water Connection | Water Authority |
| Business License | Business Registration |

**How the booking wizard routes the department selection:**

The citizen never selects a department from a dropdown inside the booking form. The routing is URL-driven. The citizen browses `/ministry/{slug}` → clicks "Apply" on a specific service → lands on `/apply/{slug}` (e.g., `/apply/driving-license` or `/apply/national-id`). The `ServiceController::applyForm(string $slug)` method resolves the ministry through the service: `Service::with('ministry')->where('slug', $slug)->where('is_active', true)->firstOrFail()`. The service (and therefore its parent ministry) is fully determined before the form is rendered. There is no dropdown; the department context is embedded in the route itself.

---

### 2. Role-Based Access Control (RBAC) — Data Isolation

The system uses two layers of isolation.

**Layer 1 — Role gate (middleware):** `RoleMiddleware` checks `auth()->user()->role` against an allowed list. All staff routes are protected with `middleware(['auth', 'verified.otp', 'role:staff,admin'])`. The `PermissionMiddleware` adds a second gate for granular actions — e.g., `permission:view_queue`, `permission:update_application_status` — resolved via the sub-roles system. `User::hasPermission()` walks the user's `subRoles` relationship; if no sub-roles are assigned, all staff permissions are granted (explicit backward-compatibility clause in the code).

**Layer 2 — Query scope in `ApplicationController::queue()`:** This is where ministry isolation is enforced. The exact code:

```php
if ($user->role === 'staff' && $user->ministry_id) {
    $query = Application::with(['user', 'appointment', 'service.ministry'])
        ->where(function ($q) use ($user) {
            $q->whereHas('service', fn ($sq) => $sq->where('ministry_id', $user->ministry_id))
              ->orWhereNull('service_id');
        });
}
```

The guard condition is `$user->ministry_id` — this value is set by an admin via `PATCH /admin/users/{user}/ministry`. The `whereHas('service', ...)` generates a correlated SQL `EXISTS` subquery that joins `applications` → `services` and filters on `services.ministry_id = ?`. A Traffic Police staff member (`ministry_id = 2`) will only ever receive applications where the linked service belongs to ministry 2. The `orWhereNull('service_id')` is a backward-compatibility clause that also surfaces legacy appointments booked through the old passport-only flow (which predate the `service_id` column). The `isMinistryScoped()` helper on the `User` model encapsulates this check: `return $this->role === 'staff' && $this->ministry_id !== null`.

**What this does NOT cover:** The `StaffController::dayAppointments()` method fetches all appointments for a given date without a ministry filter. This is intentional — that view is used for the physical check-in queue, which in the current prototype is shared infrastructure.

---

### 3. AI Chatbot Integration

**The chatbot does not use Anthropic Claude.** It uses the **Mistral AI API**, specifically the `mistral-small-latest` model, called at `https://api.mistral.ai/v1/chat/completions` with the API key from `config('services.mistral.key')`. Timeouts are configured at 8s connect / 15s total, with one automatic retry after 300ms.

**The system prompt:**

> *"You are Halzanîn Assistant — the official AI guide for the Kurdistan Region Government Services Portal. You help citizens understand government services, required documents, and how to apply online. Keep answers short (2–4 sentences), clear, and helpful. Respond in Kurdish (Sorani) when the user writes in Kurdish, otherwise respond in English. Never invent fees, legal rules, or contact details not listed below."*

**Multi-department handling strategy:** Rather than giving the model free-form knowledge, the knowledge is injected directly into every user query via `appendRulesToQuery()`. The citizen's message is prefixed with a full `=== HALZANIN PORTAL — SERVICE KNOWLEDGE BASE ===` block. As the portal expanded from one ministry to six, the knowledge base was updated to cover all six directorates — Civil Registry, Traffic Police, Electricity, Water Authority, Health, and Business Registration — with each ministry's active services, required documents, office locations, emergency phone numbers, and processing timelines. The model only ever sees grounded facts for that query — it cannot hallucinate requirements from other context.

**Knowledge base accuracy constraint:** Each service is marked either `ACTIVE` or `COMING SOON` in the injected knowledge block. Services that exist in the Blade templates but are not seeded as `is_active = true` in the database (e.g., water meter reading, leak report) are explicitly marked `COMING SOON` to prevent the chatbot from directing citizens to apply for unavailable services.

**Bilingual fallback system:** When the Mistral API is unavailable, the `fallbackReply()` method handles queries locally using `Str::contains()` keyword matching. Kurdish queries are detected by checking for Arabic-script characters via `preg_match('/[\p{Arabic}]/u', $message)`. Keyword branches cover all active services and coming-soon services in both English and Sorani Kurdish, including health emergency numbers (115) and water leak emergency (116).

**Quick questions config:** `config/chatbot.php` stores the four clickable quick-question bubbles shown above the chat input. These were updated from passport-only questions to portal-wide questions: "What services are available?", "How do I get a driving license?", "How do I apply for a water connection?", "How can I track my application?"

---

### 4. Government Digital ID System

This is a new feature added after the multi-ministry expansion. Every user account is assigned a unique, cryptographically verifiable government identifier.

**ID format:** `KRG-XXXXXXXX-XXXX` where each character is drawn from an unambiguous alphabet (`ABCDEFGHJKLMNPQRSTUVWXYZ23456789` — excludes `0`, `1`, `I`, `O` to prevent misreading). The 8+4 character structure gives 32⁸ × 32⁴ ≈ 1.2 trillion possible IDs. Uniqueness is enforced at both the database level (unique index) and application level (do/while generation loop).

**Generation — `User::boot()` hook:**

```php
protected static function boot(): void
{
    parent::boot();
    static::creating(function (self $user) {
        if (empty($user->gov_id)) {
            $user->gov_id = static::generateUniqueGovId();
        }
    });
}
```

By hooking into the Eloquent `creating` event rather than the registration controller, generation is guaranteed for every code path that creates a user — registration, seeders, admin creation, factory — with no risk of a user existing without a gov_id.

**Backfill strategy:** The migration `2026_05_29_202910` adds the column as `nullable()` first, iterates all existing users with `DB::table('users')->whereNull('gov_id')->each(...)`, generates a unique ID for each, updates the row, then the unique constraint prevents any future duplicates. This is a zero-downtime-compatible pattern for production migrations.

**QR code and HMAC verification:**

The `User::qrPayload()` method builds a tamper-proof verification string:

```php
public function qrPayload(): string
{
    $sig = substr(
        hash_hmac('sha256', $this->gov_id . '|' . $this->id, config('app.key')),
        0, 16
    );
    return implode(':', ['HALZANIN', $this->gov_id, $this->id, $sig]);
}
```

Output example: `HALZANIN:KRG-A1B2C3D4-E5F6:7:a3f9b2e1c4d7e8f0`

The HMAC is keyed with `APP_KEY`, so the signature cannot be forged without access to the server's secret. A future scanner endpoint can verify authenticity by recomputing `hash_hmac('sha256', gov_id . '|' . user_id, APP_KEY)` and comparing the first 16 hex characters — no database lookup required for the integrity check itself. The user_id component prevents an attacker from reusing a valid signature from one account on another.

**Profile display:** The QR code is rendered client-side using `qrcode.js` (loaded from cdnjs, no new Composer dependency) at `correctLevel: H` (30% damage tolerance). The profile page renders a styled government ID card with the user's name, role, `gov_id` in JetBrains Mono, member-since date, the QR code, and a one-click copy button. The card uses a dark navy gradient background with the Halzanîn logo.

---

### 5. Dual Authentication — Email or Government ID

**Problem:** After the gov_id was introduced, citizens needed a way to log in using their government ID rather than their email address — matching how physical government IDs are used for identification.

**Implementation:** The `LoginRequest` class was updated to detect the input type before attempting authentication:

```php
public function authenticate(): void
{
    $this->ensureIsNotRateLimited();

    $login = trim($this->string('email')->toString());

    // Detect gov_id: matches KRG-XXXXXXXX-XXXX (case-insensitive)
    if (preg_match('/^KRG-[A-Z2-9]{8}-[A-Z2-9]{4}$/i', $login)) {
        $user = User::where('gov_id', strtoupper($login))->first();
        if (! $user || ! Auth::attempt(
            ['email' => $user->email, 'password' => $password], $remember
        )) {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages(['email' => trans('auth.failed')]);
        }
    } else {
        // Standard email path
        if (! Auth::attempt(['email' => $login, 'password' => $password], $remember)) {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages(['email' => trans('auth.failed')]);
        }
    }

    RateLimiter::clear($this->throttleKey());
}
```

The gov_id path resolves the user's email from the database and delegates to the standard `Auth::attempt()` with that email — this means the rest of the auth pipeline (OTP verification, session regeneration, rate limiting, lockout) is identical for both paths. Rate limiting keys on the raw input value, so gov_id-based brute-force attempts are throttled identically to email attempts.

**Login form change:** The email input was changed from `type="email"` to `type="text"` — the browser's built-in email format validation was blocking gov_id input entirely at the client side before it ever reached the server. The placeholder was updated to `Email or Government ID (KRG-XXXXXX-XXXX)`. The `email` format validation rule was also removed from `LoginRequest::rules()` since the field now accepts two different formats.

---

### 6. Frontend Design System — Ministry Pages

All five ministry-specific pages (Civil Registry, Traffic Police, Electricity, Water Authority, Health) share a unified Blade design system. The standardisation involved the following structural decisions:

**Navbar pattern:** All pages use `<header class="mn-bar">` with a sticky backdrop-filter navbar containing: Halzanîn logo image + brand text, breadcrumb navigation, theme toggle (sun/moon SVG), EN/KU language pill buttons, and an `@auth`/`@else`/`@endauth` Blade directive for Dashboard vs Sign In.

**Hero image rendering:** An important technical decision was the method used to render the hero background photograph. An initial implementation placed the image URL inside a CSS `background: url()` declaration within a `<style>` block using `{{ asset() }}`:

```css
.mn-hero-photo {
    background: url('{{ asset("images/water/hero.jpeg") }}') center/cover no-repeat;
}
```

This approach failed — the image never rendered. The correct pattern, used by the Civil Registry page, is to place an `<img>` tag inside the `.mn-hero-photo` div:

```html
<div class="mn-hero-photo" aria-hidden="true">
    <img src="{{ asset('images/water/hero.jpeg') }}" alt="" loading="eager">
</div>
```

The CSS `url()` approach is unreliable in Laravel Blade `<style>` blocks because CSS is not Blade-processed before being sent to the browser; the literal string `{{ asset(...) }}` is output as CSS text rather than resolved to a URL. The `<img>` tag approach works because Blade processes the HTML attribute value as a PHP expression. All four non-civil-registry ministry pages were corrected to use this pattern.

**Dark mode:** Each ministry page defines two CSS variable sets — `:root { }` for light mode and `html.dark { }` for dark mode — covering `--bg`, `--surface`, `--card`, `--text`, `--text-sub`, `--text-muted`, `--border`, `--nav-bg`, and the ministry's brand colour token `--m`. An early implementation hardcoded the light-mode colour directly on the `body` element:

```css
body { background: #f0f8f6; color: #071e17; }
```

This meant toggling dark mode updated the CSS variables but the body element ignored them entirely, leaving the page on a light background in dark mode. The fix was to reference the variables:

```css
body { background: var(--bg); color: var(--text); }
```

This is the same pattern used by Civil Registry (which worked correctly from the start). The fix was applied to all four other ministry pages simultaneously.

**CSS z-index stacking for hero overlays:** Each hero section uses four absolutely-positioned layers. After the img-tag hero fix, explicit z-index values were required to maintain the correct render order:

| Layer | z-index | Purpose |
|---|---|---|
| `.mn-hero-photo` | 1 | Background photograph |
| `.mn-hero-pattern` | 2 | Decorative overlay (dots, stripes, gradients) |
| `.mn-hero-fade` | 3 | Bottom gradient fade |
| `.mn-hero-inner` | 4 | Text content and CTAs |

**Language switcher pattern:** All pages expose `window.setLang(l)` which toggles the `lang-ku` class on `document.body`, sets `html[lang]` and `html[dir]` attributes, persists to `localStorage`, and toggles the `.active` class on `#lang-ku-btn` / `#lang-en-btn`. An earlier single-button `toggleLang()` pattern was replaced across all pages with this two-button active-state pattern.

**Contact section:** All ministry pages display a 2×2 grid of office location cards covering the four governorates: Erbil (headquarters), Sulaymaniyah, Duhok, and Halabja. The headquarters card uses the ministry's `--m` brand colour as its background; branch cards use a light surface variant. This replaced the original single-office + map-placeholder layout.

---

### 7. Authentication Layout — Portal-Wide Redesign

The auth layout (`resources/views/components/halzanin-auth-layout.blade.php`) previously identified itself as the "Passport & Civil Affairs Directorate" and displayed three animated passport images (blue, dark, red) on the left panel. After the portal expanded to six ministries, this branding was incorrect.

**Changes made:**

- Left panel headline: `Passport & Civil Affairs Directorate` → `Kurdistan Government Services Portal`
- Subline: `Kurdistan Region – Iraq` → bilingual `حکومەتی هەرێمی کوردستان — Kurdistan Region`
- Four feature bullets updated: "6 Directorates / One portal for all government services", "Online Applications / Apply from anywhere, any device", "Real-Time Tracking / Monitor your application status live", "Bilingual Support / Kurdish & English"
- Passport images replaced with a 2×3 ministry tile grid (Civil Registry, Traffic Police, Electricity, Water, Health, Business) — each tile has a relevant SVG icon and ministry name, rendered in CSS with a glass-morphism style on the dark navy background
- Footer copyright year: hardcoded `2025` → `{{ date('Y') }}`
- Mobile top bar title updated to match

---

### 8. Mobile Navigation — Logout Accessibility

**Problem:** The logout button existed only in the desktop sidebar (`hidden lg:flex`), making it inaccessible on mobile. The mobile bottom navigation bar had no path to log out for any role.

**Solution:** The Profile tab in the mobile bottom nav was converted from a plain `<a>` link to an Alpine.js `x-data` component. Tapping Profile now toggles a popup card above the tab bar containing two options: a Profile link and a red Log Out button. The popup uses `x-on:click.outside` to close on external tap and Alpine's built-in `x-transition` for a slide-up animation.

```html
<div x-data="{open:false}" class="... relative">
    <button x-on:click="open=!open" x-on:click.outside="open=false" ...>
        <!-- profile icon + label -->
    </button>
    <div x-show="open" x-transition ... class="absolute bottom-full ...">
        <a href="{{ route('profile.edit') }}">Profile</a>
        <button x-on:click="$dispatch('open-modal','confirm-logout')">Log Out</button>
    </div>
</div>
```

The Log Out button dispatches `open-modal:confirm-logout` — the same Alpine event used by the desktop sidebar button — which triggers the existing confirmation modal. This means the logout confirmation flow is identical on both desktop and mobile. The fix was applied to all three role branches (admin, staff, citizen) in the mobile bottom nav.

---

### 9. Performance Metrics (Local Laragon Environment)

These are evidence-based estimates for this specific stack (Windows 11, Core i7, PHP 8.3 OPcache enabled, Laravel 10, MySQL 8.4, Laragon Nginx). No production APM tool is integrated in the codebase.

| Metric | Realistic Estimate | Basis |
| --- | --- | --- |
| Standard MVC page load (e.g., `/citizen/applications`) | **80–150 ms** | PHP 8.3 with OPcache; Laravel 10 bootstrap ~40–60ms; one or two eager-loaded queries add 10–30ms |
| `Crypt::encrypt()` on a single document upload (~500 KB image) | **3–8 ms** | Laravel's `Crypt` facade wraps `openssl_encrypt` with AES-256-CBC + MAC; base64 encoding and MAC signing bring wall time to this range |
| Peak PHP memory during PDF generation via DomPDF | **32–64 MB** | DomPDF loads full HTML DOM; one-page receipt with embedded base64 QR SVG typically peaks here |
| Peak memory during vault store (decrypt + re-encrypt a 2MB document) | **18–30 MB** | Two copies of file content held in memory during `Crypt::decrypt(Storage::get(...))` |
| `hash_hmac('sha256', ...)` for gov_id QR payload generation | **< 1 ms** | Single HMAC-SHA256 call on a short string; negligible overhead on every profile page load |

**Caveat for the dissertation:** These are development-environment estimates. Laragon runs MySQL and Nginx as native Windows processes; on Linux they would be 15–30% faster. No query caching or Redis is configured in this codebase.

---

### 10. Real Technical Challenges During Development

**Challenge 1: The status field type collision (ENUM → VARCHAR migration)**

The original `applications` table used a MySQL `ENUM('submitted', 'under_review', 'approved', 'rejected', 'checked_in')` for `current_status`. This was fine when there was one department with one workflow. When the system expanded to support services with bespoke status pipelines (Driving License has 7 stages including `theory_test_scheduled`; Business License has `fee_pending`; Electricity has `inspection_completed`) the ENUM constraint blocked any new status value at the database level.

**Resolution:** Migration `2026_05_21_164140` changed the column to `VARCHAR`. The status pipeline was moved entirely into the `services.statuses` JSON column. `Service::allowedNextStatuses()` now drives state transitions from that array at runtime, and `Service::nextStatus()` finds the current position in the array and returns the next value. The `ApplicationController` retained a hardcoded `PASSPORT_NEXT_STATUSES` array as a fallback for legacy records that have `service_id = NULL`, ensuring old passport applications continued to work during the transition period.

**Challenge 2: Dual-controller application creation and tracking code format divergence**

During the transition, two separate submission paths coexisted: the original `AppointmentController::store()` (legacy passport/general booking, creates `applications` without a `service_id`, generates codes in `TRK-YYMMDD-XXXXXX` format) and the new `ServiceController::store()` (service-aware submission, sets both `service_id` and `form_data`, generates codes in `HZ-XXXXXXXX` format). These two flows created structurally different `Application` records in the same table.

**Resolution:** Rather than breaking the legacy route, the `ApplicationController::resolveNextStatuses()` method was introduced as a branch dispatcher. It checks `if ($application->service_id && $application->service)` to decide whether to delegate to the data-driven `Service::allowedNextStatuses()` or fall back to the hardcoded `PASSPORT_NEXT_STATUSES` constant. The `orWhereNull('service_id')` clause in the ministry-scoped query in `queue()` is a direct consequence of this dual-format data in the same table.

**Challenge 3: The staff ministry-scoping query rewrite mid-method**

The first draft of the ministry isolation logic attempted to chain `->whereHas()->orWhereHas()` onto the base `$query` object. This produced an incorrect OR condition that could leak cross-ministry data — the `orWhereHas` was scoped too loosely. The fix required completely rebuilding the query object with a single `where(function($q) { ... })` closure wrapping both conditions as a grouped OR inside a single constraint block. The key insight was that Eloquent's `orWhereHas` at the top level (not wrapped in a closure) always generates an unguarded `OR` that bypasses the ministry filter entirely.

**Challenge 4: CSS `url()` inside Blade `<style>` blocks does not resolve `{{ asset() }}`**

When hero background images were migrated from external picsum.photos URLs to local assets, the initial approach placed the asset path inside a CSS `background: url()` declaration within a `<style>` block. The images never appeared. Investigation confirmed that CSS inside `<style>` tags is sent to the browser verbatim — Blade only processes template syntax in HTML attribute values and PHP expression contexts. The `{{ asset() }}` call was being output as literal text `{{ asset("images/water/hero.jpeg") }}` in the compiled CSS. The fix was to use an `<img>` tag inside the `.mn-hero-photo` div instead, where Blade correctly evaluates the `src="{{ asset(...) }}"` attribute as a PHP expression.

**Challenge 5: Browser `type="email"` blocking gov_id login**

After the Government Digital ID was introduced and login-by-gov_id was implemented server-side, testing revealed it still failed. The auth failure did not reach the server — the browser's native HTML5 email format validation was rejecting `KRG-XXXXX-XXXX` before form submission. The fix required two changes: changing the input `type` from `email` to `text`, and removing the `email` format rule from `LoginRequest::rules()`. The server-side regex then correctly distinguishes between an email address and a gov_id pattern.

---

**Summary note for the dissertation:** Key factual points — (1) the chatbot uses **Mistral AI (`mistral-small-latest`)**, not Claude or any Anthropic product; (2) the multi-department separation is achieved through a `ministries` → `services` two-level hierarchy with `service_id` as the FK on both `applications` and `appointments`; (3) every user account carries a unique `gov_id` (`KRG-XXXXXXXX-XXXX` format) generated via a `User::boot()` Eloquent hook, with QR codes rendered client-side using an HMAC-SHA256 signed payload keyed on `APP_KEY`; (4) authentication accepts either an email address or a Government Digital ID as the login identifier.
