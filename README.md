# Halzanîn | حالزانین
### A Digital Public Document Tracking System
**Sulaimani Polytechnic University — Technical College of Informatics**
Academic Year 2025–2026

## Team
- Bawan Abbas
- Zhyar Kamaran
- Kara Zahir
- Sahand Mohammed

**Supervised by:** Dr. Bakhtiar Saeed

## Tech Stack
- Laravel 10, PHP 8.3, MySQL 8.4
- Tailwind CSS, Blade Templates
- simplesoftwareio/simple-qrcode
- barryvdh/laravel-dompdf
- Laragon (local development)

## Setup Instructions
1. Clone: `git clone https://github.com/bawanabbas20-wq/halzanin-final-project.git`
2. Install: `composer install && npm install`
3. Copy env: `cp .env.example .env`
4. Configure `.env` with your database credentials
5. Generate key: `php artisan key:generate`
6. Migrate & seed: `php artisan migrate --seed`
7. Build assets: `npm run build`
8. Open: `http://localhost/final%20project/public`

## Test Accounts
| Role | Email | Password |
|------|-------|----------|
| Citizen | citizen@test.com | password123 |
| Staff | staff@test.com | password123 |
| Admin | admin@test.com | password123 |
