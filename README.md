<div align="center">

# Halzanîn · حالزانین

### A Digital Public Document Tracking & e‑Government Portal

A unified platform that lets citizens request, track, and receive official
government documents online — across multiple ministries — from a single,
secure account.

**Sulaimani Polytechnic University**
Technical College of Informatics · Academic Year 2025–2026

![Laravel](https://img.shields.io/badge/Laravel-10-FF2D20?logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.1%2B-777BB4?logo=php&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3-38B2AC?logo=tailwindcss&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8-4479A1?logo=mysql&logoColor=white)

</div>

---

## Overview

**Halzanîn** is a multi-ministry e-government portal built to digitise the
public-document lifecycle. Citizens authenticate once and can then apply for
services across several ministries, upload supporting documents, book
in-person appointments, and follow each application's status in real time —
receiving a verifiable, QR-coded receipt when their document is ready.

The platform serves three distinct audiences through role-based dashboards:
**citizens**, **ministry staff**, and **administrators**.

## Key Features

- **Secure citizen onboarding** — registration with email OTP verification.
- **Government Digital ID** — every citizen receives a unique national ID with
  a scannable QR code, usable as an alternative login credential.
- **Multi-ministry services** — a single portal spanning ministries such as
  Civil Registry, Health, Electricity, Water, and Traffic Police.
- **Application tracking** — submit requests, upload documents, and follow live
  status updates from submission to completion.
- **Appointment booking** — a multi-step wizard with per-service availability
  calendars for in-person visits.
- **QR-coded PDF receipts** — generated automatically for verification.
- **Role-based dashboards** — tailored experiences for citizens, staff, and
  ministry administrators, including staff management and availability control.
- **Bilingual interface** — full English / Kurdish support with live toggling.

## Tech Stack

| Layer | Technology |
|-------|------------|
| Framework | Laravel 10 (PHP 8.1+) |
| Frontend | Blade Templates · Tailwind CSS · Vite |
| Database | MySQL 8 |
| Authentication | Laravel Breeze · Sanctum |
| QR Codes | simplesoftwareio/simple-qrcode |
| PDF Generation | barryvdh/laravel-dompdf |
| Local Environment | Laragon |

## Getting Started

### Prerequisites
- PHP 8.1+ and Composer
- Node.js and npm
- MySQL 8

### Installation

```bash
# 1. Clone the repository
git clone https://github.com/bawanabbas20-wq/halzanin-final-project.git
cd halzanin-final-project

# 2. Install dependencies
composer install
npm install

# 3. Set up environment
cp .env.example .env
php artisan key:generate

# 4. Configure your database credentials in .env, then run migrations & seeders
php artisan migrate --seed

# 5. Build front-end assets
npm run build

# 6. Serve the application
php artisan serve
```

Then open the application in your browser (e.g. `http://127.0.0.1:8000`).

### Demo Accounts

> For evaluation only. Change or remove these credentials before any
> production deployment.

| Role | Email | Password |
|------|-------|----------|
| Citizen | `citizen@test.com` | `password123` |
| Staff | `staff@test.com` | `password123` |
| Admin | `admin@test.com` | `password123` |

## Team

- Bawan Abbas
- Zhyar Kamaran
- Kara Zahir
- Sahand Mohammed

**Supervised by** Renas Wrya

---

<div align="center">
<sub>Built as a graduation project at Sulaimani Polytechnic University · 2025–2026</sub>
</div>
