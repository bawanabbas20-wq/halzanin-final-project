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

The `services` table is the architectural centrepiece. Each row carries three JSON columns that make the service fully self-describing: `form_schema` (the dynamic form fields), `required_documents` (document checklist), and `statuses` (the ordered status pipeline). Five ministries are seeded with 14 services total, 6 of which are `is_active = true`.

**How the booking wizard routes the department selection:**

The citizen never selects a department from a dropdown inside the booking form. The routing is URL-driven. The citizen browses `/ministry/{slug}` → clicks "Apply" on a specific service → lands on `/apply/{slug}` (e.g., `/apply/driving-license` or `/apply/national-id`). The `ServiceController::applyForm(string $slug)` method resolves the ministry through the service: `Service::with('ministry')->where('slug', $slug)->where('is_active', true)->firstOrFail()`. The service (and therefore its parent ministry) is fully determined before the form is rendered. There is no dropdown; the department context is embedded in the route itself.

---

### 2. Role-Based Access Control (RBAC) — Data Isolation

The system uses two layers of isolation.

**Layer 1 — Role gate (middleware):** `RoleMiddleware` checks `auth()->user()->role` against an allowed list. All staff routes are protected with `middleware(['auth', 'verified.otp', 'role:staff,admin'])`. The `PermissionMiddleware` adds a second gate for granular actions — e.g., `permission:view_queue`, `permission:update_application_status` — resolved via the sub-roles system. `User::hasPermission()` walks the user's `subRoles` relationship; if no sub-roles are assigned, all staff permissions are granted (explicit backward-compatibility clause in the code).

**Layer 2 — Query scope in `ApplicationController::queue()`:** This is where ministry isolation is enforced. The exact code ([ApplicationController.php:56-64](vscode-webview://076nj023nddb2bt43qnl54r3u35ubf2fk4pqr7qs44oqgfrj70cl/app/Http/Controllers/ApplicationController.php#L56-L64)):

```php
if ($user->role === 'staff' && $user->ministry_id) {
    $query = Application::with(['user', 'appointment', 'service.ministry'])
        ->where(function ($q) use ($user) {
            $q->whereHas('service', fn ($sq) => $sq->where('ministry_id', $user->ministry_id))
              ->orWhereNull('service_id');
        });
}
```

The guard condition is `$user->ministry_id` — this value is set by an admin via `PATCH /admin/users/{user}/ministry`. The `whereHas('service', ...)` generates a correlated SQL `EXISTS` subquery that joins `applications` → `services` and filters on `services.ministry_id = ?`. A Traffic Police staff member (`ministry_id = 2`) will only ever receive applications where the linked service belongs to ministry 2. The `orWhereNull('service_id')` is a backward-compatibility clause that also surfaces legacy appointments booked through the old passport-only flow (which predate the `service_id` column). The `isMinistryScoped()` helper on the `User` model ([User.php:104-107](vscode-webview://076nj023nddb2bt43qnl54r3u35ubf2fk4pqr7qs44oqgfrj70cl/app/Models/User.php#L104-L107)) encapsulates this check: `return $this->role === 'staff' && $this->ministry_id !== null`.

**What this does NOT cover:** The `StaffController::dayAppointments()` method fetches all appointments for a given date without a ministry filter. This is intentional — that view is used for the physical check-in queue, which in the current prototype is shared infrastructure.

---

### 3. AI Chatbot Integration — Important Correction

**The chatbot does not use Anthropic Claude.** It uses the  **Mistral AI API** , specifically the `mistral-small-latest` model, called at `https://api.mistral.ai/v1/chat/completions` with the API key from `config('services.mistral.key')`. Timeouts are configured at 8s connect / 15s total, with one automatic retry after 300ms.

**The system prompt** ([ChatbotController.php:15](vscode-webview://076nj023nddb2bt43qnl54r3u35ubf2fk4pqr7qs44oqgfrj70cl/app/Http/Controllers/ChatbotController.php#L15)):

> *"You are Halzanîn Assistant — the official AI guide for the Kurdistan Region Government Services Portal. You help citizens understand government services, required documents, and how to apply online. Keep answers short (2–4 sentences), clear, and helpful. Respond in Kurdish (Sorani) when the user writes in Kurdish, otherwise respond in English. Never invent fees, legal rules, or contact details not listed below."*

**Multi-department handling strategy:** Rather than giving the model free-form knowledge, the knowledge is injected directly into every user query via `appendRulesToQuery()`. The citizen's message is prefixed with a full `=== HALZANIN PORTAL — SERVICE KNOWLEDGE BASE ===` block covering all five ministries, all active services, their required documents, their status pipeline labels, and estimated processing days. The model only ever sees grounded facts for that query — it cannot hallucinate requirements from other context. Five strict rules are appended to the knowledge base, including "Never invent requirements, fees, timelines, or legal details not listed above" and "If uncertain, advise the user to visit the relevant directorate."

**Bilingual fallback system:** When the Mistral API is unavailable, the `fallbackReply()` method handles queries locally using `Str::contains()` keyword matching. Kurdish queries are detected by checking for Arabic-script characters via `preg_match('/[\p{Arabic}]/u', $message)`. Keyword branches cover all six active services in both English and Sorani Kurdish.

---

### 4. Performance Metrics (Local Laragon Environment)

These are evidence-based estimates for this specific stack (Windows 11, Core i7, PHP 8.3 OPcache enabled, Laravel 10, MySQL 8.4, Laragon Nginx). No production APM tool is integrated in the codebase.

| Metric                                                                                        | Realistic Estimate   | Basis                                                                                                                                                                                                                                            |
| --------------------------------------------------------------------------------------------- | -------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| Standard MVC page load (e.g.,`/citizen/applications`, simple Eloquent query + Blade render) | **80–150 ms** | PHP 8.3 with OPcache on a local stack; Laravel 10's typical bootstrap overhead is ~40–60ms; one or two eager-loaded queries add 10–30ms                                                                                                        |
| `Crypt::encrypt()` on a single document upload (~500 KB image)                              | **3–8 ms**    | Laravel's `Crypt` facade wraps PHP's `openssl_encrypt` with AES-256-CBC + a MAC. OpenSSL encryption of 500 KB on a modern i7 is sub-millisecond; the base64 encoding, JSON wrapping, and MAC signing bring realistic wall time to this range |
| Peak PHP memory during PDF generation (`Pdf::loadView(...)->download()`) via DomPDF         | **32–64 MB**  | DomPDF loads the full HTML DOM tree into memory; a one-page receipt with embedded base64 QR SVG (`QrCode::format('svg')->size(200)`) and a Blade view typically peaks here. PHP's default `memory_limit` of 128MB is not approached          |
| Peak memory during vault store (decrypt + re-encrypt a 2MB document)                          | **18–30 MB**  | Two copies of the file content held in memory during `Crypt::decrypt(Storage::get(...))` before the response is streamed                                                                                                                       |

**Caveat for the dissertation:** These are development-environment estimates. Laragon runs MySQL and Nginx as native Windows processes; on Linux they would be 15–30% faster. No query caching or Redis is configured in this codebase.

---

### 5. Real Technical Challenges During the Single → Multi-Department Transition

**Challenge 1: The status field type collision (ENUM → VARCHAR migration)**

The original `applications` table used a MySQL `ENUM('submitted', 'under_review', 'approved', 'rejected', 'checked_in')` for `current_status`. This was fine when there was one department with one workflow. When the system expanded to support services with bespoke status pipelines (Driving License has 7 stages including `theory_test_scheduled`; Business License has `fee_pending`; Electricity has `inspection_completed`) the ENUM constraint blocked any new status value at the database level.

**Resolution:** Migration `2026_05_21_164140_change_applications_status_to_varchar.php` changed the column to `VARCHAR`. The status pipeline was moved entirely into the `services.statuses` JSON column. `Service::allowedNextStatuses()` now drives state transitions from that array at runtime, and `Service::nextStatus()` finds the current position in the array and returns the next value. The `ApplicationController` retained a hardcoded `PASSPORT_NEXT_STATUSES` array as a fallback for legacy records that have `service_id = NULL`, ensuring old passport applications continued to work during the transition period.

**Challenge 2: Dual-controller application creation and tracking code format divergence**

During the transition, two separate submission paths coexisted: the original `AppointmentController::store()` (legacy passport/general booking, creates `applications` without a `service_id`, generates codes in `TRK-YYMMDD-XXXXXX` format) and the new `ServiceController::store()` (service-aware submission, sets both `service_id` and `form_data`, generates codes in `HZ-XXXXXXXX` format). These two flows created structurally different `Application` records in the same table.

**Resolution:** Rather than breaking the legacy route, the `ApplicationController::resolveNextStatuses()` method was introduced as a branch dispatcher. It checks `if ($application->service_id && $application->service)` to decide whether to delegate to the data-driven `Service::allowedNextStatuses()` or fall back to the hardcoded `PASSPORT_NEXT_STATUSES` constant. The `orWhereNull('service_id')` clause in the ministry-scoped query in `queue()` is a direct consequence of this dual-format data in the same table.

**Challenge 3: The staff ministry-scoping query rewrite mid-method**

The first draft of the ministry isolation logic in `ApplicationController::queue()` attempted to chain `->whereHas()->orWhereHas()` onto the base `$query` object. This produced an incorrect OR condition that could leak cross-ministry data (the `orWhereHas` on `appointment` checked for null `service_id` but was scoped too loosely). The fix required completely rebuilding the query object with a single `where(function($q) { ... })` closure wrapping both conditions as a grouped OR inside a single constraint block. The old lines were left as commented intent above the replacement query in the current code, showing the iteration. The key insight was that Eloquent's `orWhereHas` at the top level (not wrapped in a closure) always generates an unguarded `OR` that bypasses the ministry filter entirely.

---

**Summary note for the dissertation:** Two important factual corrections for any draft that calls this an "Anthropic Claude integration" — the chatbot uses  **Mistral AI (`mistral-small-latest`)** , not Claude. Second, the multi-department separation is achieved through a `ministries` → `services` two-level hierarchy, with `service_id` as the FK on both `applications` and `appointments`, not a single `department_id` column.
