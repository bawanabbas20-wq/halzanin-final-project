# Chapter 4 Raw Results Data

Raw factual notes extracted from the current Halzanin Document Tracking System codebase at `d:\final project`.

## 1. Testing Environment and Synthetic Dataset

### Hardware and Software Specs

| Item | Value |
|---|---|
| OS | Windows 11 Pro 64-bit, version `10.0.26200` |
| Machine | ASUS TUF Dash F15 `FX517ZR_FX517ZR` |
| CPU | 12th Gen Intel Core i7-12650H, 10 cores / 16 logical processors |
| RAM | Approximately 16 GB |
| Local server stack | Laragon, product version `8`, file version `8.3.0.1009` |
| PHP | PHP `8.3.26` |
| PHP path | `D:\laragon\bin\php\php-8.3.26-Win32-vs16-x64\php.exe` |
| Laravel | Laravel Framework `10.50.2` |
| MySQL | MySQL Community Server `8.4.3` |
| Database connection | MySQL on `127.0.0.1:3306` |
| Database name | `laravel` |
| Database user | `root` |
| App mode | `APP_ENV=local`, `APP_DEBUG=true` |
| App URL | `http://localhost` |

### Current Database Record Counts

| Entity / Table | Count |
|---|---:|
| Users | 3 |
| Appointments | 4 |
| Applications | 4 |
| Vault Documents | 1 |
| Supporting `documents` rows | 14 |

### Seeder Notes

- `DatabaseSeeder.php` does not currently seed bulk dummy records.
- `UserSeeder.php` creates three test users:
  - Citizen User
  - Staff User
  - Admin User

## 2. Performance and Speed Metrics

These values are local-development estimates unless marked as measured.

| Operation | Estimated / Measured Time |
|---|---:|
| Citizen Dashboard load | Approximately 40-90 ms server-side on local Laragon |
| AJAX calendar month navigation | Approximately 25-70 ms server-side |
| Staff Queue page | Approximately 50-120 ms server-side with the current small dataset |
| Vault AES-256-CBC encryption | Measured approximately 81.6 ms for an approximately 6.96 MB payload |
| Vault PDF generation using DomPDF | Measured approximately 570 ms for a tiny image PDF |
| Realistic scanned-image vault PDF generation | Approximately 600-1200 ms locally |
| QR receipt PDF generation | Approximately 400-900 ms locally |

### Relevant Code Paths

- Citizen dashboard: `CitizenController@index`
- Calendar month AJAX: `AppointmentController@monthData`
- Staff queue: `ApplicationController@queue`
- Vault upload and encryption: `VaultController@store`
- QR receipt PDF: `ApplicationController@downloadPdf`

## 3. Concurrency and Security Validations

### Race Condition Handling for Appointment Booking

The booking controller first checks whether the selected slot is already taken:

```php
Appointment::where('date', $request->date)
    ->where('time_slot', $request->time_slot)
    ->whereNotIn('status', ['cancelled'])
    ->exists();
```

The stronger concurrency protection is implemented at the database level through a unique index on the `appointments` table.

Verified active database index:

| Index | Columns | Unique |
|---|---|---|
| `appointments_date_time_slot_unique` | `date`, `time_slot` | Yes |

Effect:

- If two citizens submit the same date and time slot at the same millisecond, both requests may pass the PHP pre-check.
- MySQL still prevents the second insert because `(date, time_slot)` must be unique.
- Therefore, duplicate bookings for the exact same slot are prevented at the database level.

Current limitation:

- The controller does not currently catch the database integrity exception.
- The duplicate booking is prevented, but the second user may receive a server error instead of a friendly validation message.

### Route Protection

Staff/admin routes use:

- `web`
- `auth`
- `role:staff,admin` for staff routes
- `role:admin` for admin routes
- `throttle:authenticated`

Sensitive staff routes also use permission middleware:

| Route Area | Permission Middleware |
|---|---|
| Staff queue | `permission:view_queue` |
| Staff application detail | `permission:view_documents` |
| Staff document file viewing | `permission:view_documents` |
| Status updates | `permission:update_application_status` |
| Appointment confirmation | `permission:confirm_appointments` |
| QR check-in scanner | `permission:scan_qr_checkin` |

Vault document routes use:

- `web`
- `auth`
- `role:citizen`
- `throttle:authenticated`

Vault file access also uses ownership scoping in `VaultController@viewFile`:

```php
auth()->user()->vaultDocuments()->findOrFail($document);
```

This means a citizen can only view vault documents that belong to their own account.

## 4. Real Technical Challenges and Bug Fixes

### 4.1 Broken Routes and Crashing Staff/Admin Pages

Commit evidence: `ec1d310` - `fix: wire up all broken routes and fix crashing pages`

Bug:

- Staff queue, application detail, admin users, tracking pages, and related links were missing or mismatched.
- Some views expected variables and route names that were not yet registered.

Why it happened:

- Routes and controller methods were added incrementally.
- Views referenced controller data such as `$stats`, `$recent`, staff queue handlers, and tracking routes before all backend methods existed.

Technical solution:

- Added missing routes.
- Added missing controller methods.
- Added admin dashboard statistics.
- Added staff queue/application handlers.
- Corrected route and view references.

### 4.2 Appointment/Application Relationship Mismatch

Commit evidence: `ec1d310`

Bug:

- Staff calendar/application views could crash or show missing documents.

Why it happened:

- The system evolved from appointment-centered records to application-centered tracking.
- Some code still expected documents to be loaded directly through `Appointment::documents()`, while application workflows required loading documents through the application relationship.

Technical solution:

- Corrected relationship loading paths.
- Loaded documents through application-related relationships where needed.
- Added null-safe relationship access in affected views/controllers.

### 4.3 Orphaned Appointments Without Application Records

Commit evidence: `8f44f60` - `fix: backfill Application records for orphaned appointments`

Bug:

- Some existing appointments had no matching application/tracking record.
- Receipt, queue, and tracking workflows could not work consistently for those appointments.

Why it happened:

- Earlier appointment data existed before the application-tracking layer was fully connected.

Technical solution:

- Added a migration to find appointments without applications.
- Created matching `applications` records with generated tracking codes.
- Created matching `status_logs` records with `submitted` status.

### 4.4 Staff Document Viewer Did Not Handle All Document Sources

Commit evidence: `a9edb21` - `fix: staff document viewer handles upload, vault, and confirmed sources`

Bug:

- Staff document viewing originally handled uploaded files only.
- Vault documents and documents marked as physically confirmed were not handled correctly.

Why it happened:

- The code assumed every document had a normal uploaded file path.
- In reality, document sources can be `upload`, `vault`, or `confirmed`.

Technical solution:

- Added source-specific handling:
  - `upload`: return normal stored file response.
  - `vault`: decrypt stored vault content and stream it inline.
  - `confirmed`: return an HTML confirmation page explaining that the citizen will bring the original document physically.

Important note:

- This fix exists in the nested project history.
- The root `StaffController` currently appears to handle uploaded files only, so the deployed/active tree should be verified before presenting this as current behavior.

### 4.5 Step 3 Document Validation Ambiguity

Commit evidence: `98a6ad2` - `fix: stricter Step 3 document validation with amber/green badges and warnings`

Bug:

- Users could proceed with unclear document fulfillment status.
- The UI did not clearly distinguish uploaded/vault documents from checkbox-only physical confirmations.

Why it happened:

- Frontend state did not clearly model the difference between:
  - uploaded document,
  - vault-selected document,
  - citizen-confirmed physical original.

Technical solution:

- Added stricter client-side validation.
- Added warning banner when all required documents are confirm-only.
- Added red highlighting for unfulfilled document cards.
- Added green `Fulfilled` badges for uploaded/vault documents.
- Added amber `Confirmed` badges for physical-original confirmations.
- Added hidden vault document ID synchronization.

## 5. Current System Limitations

### 5.1 Local-Only Configuration

- The app is configured as `APP_ENV=local`.
- `APP_DEBUG=true`.
- `APP_URL=http://localhost`.
- No production HTTPS configuration is visible in the current `.env`.

### 5.2 Vault Encryption Depends on a Single Application Key

- Vault files are encrypted using Laravel `Crypt`.
- Laravel `Crypt` depends on the application `APP_KEY`.
- If the single `APP_KEY` is leaked, all encrypted vault documents are at risk.
- If the `APP_KEY` is lost or changed without migration, existing encrypted vault files may become unreadable.

### 5.3 Email and Notification Delivery Are Not Production-Ready

- Mail is configured for SMTP using `MAIL_HOST=mailpit`.
- Mail port is `1025`.
- Mail username and password are null.
- This is suitable for local testing, not production delivery.

### 5.4 Queue Processing Is Synchronous

- `QUEUE_CONNECTION=sync`.
- Notifications and heavier tasks run during the web request instead of being processed by background workers.
- PDF generation and external notification calls may slow down user-facing requests.

### 5.5 Staff Permission Fallback Is Broad

- `User::hasPermission()` returns `true` for staff users with no assigned sub-roles.
- This was implemented for backward compatibility.
- It is convenient during testing but permissive for production RBAC.

### 5.6 Current Dataset Is Too Small for Scalability Claims

- The current database contains only:
  - 3 users
  - 4 appointments
  - 4 applications
  - 1 vault document
- Performance results should be described as local prototype/testing results, not large-scale production benchmarks.
