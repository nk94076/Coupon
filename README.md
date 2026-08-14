# Coupon CMS — Phase 1 (Admin Foundation)

A production-ready **Admin CMS** foundation for a coupon website, built with Laravel, Blade, Tailwind CSS and Alpine.js.

This phase ships the admin side only — authentication, dashboard, Stores/Categories/Coupons management, media uploads, admin users, roles, activity logs and settings. The public coupon website, affiliate tracking, automated importing and SEO automation are intentionally out of scope and will be built on top of this foundation in later phases.

## Tech Stack

- PHP 8.2+
- Laravel 13 (11/12-compatible application structure)
- MySQL 8+
- Blade templates, Tailwind CSS, Alpine.js
- Laravel Auth, Migrations, Eloquent, Form Requests, Policies/Gates, Storage
- Vite

## Features

- Secure admin authentication (login, logout, remember me, forgot/reset password, login throttling, session security) scoped to a dedicated `admin` guard and `admin_users` table
- Collapsible sidebar / topbar SaaS-style admin layout with a reusable Blade UI kit (buttons, inputs, selects, tables, modals, alerts, badges, pagination, empty states, confirmation dialogs)
- Dashboard with store/category/coupon stats, recent records and quick actions
- Full CRUD for Stores, Categories (parent/child) and Coupons, each with search/filter/sort, server-side pagination, status & featured toggles, and SEO placeholder fields
- Coupon classification (discount type, coupon type, new-user/app-only/bank-offer/student tags), verified/exclusive/featured flags, and a non-destructive "expired" indicator based on `expiry_date`
- Reusable, security-conscious media upload service (safe random filenames, real MIME-type validation, JPG/PNG/WebP only) plus a Media Library
- Admin user management with role-based access (Super Admin vs Manager) and self-lockout protection
- Activity log of admin actions (who, what, when, IP, user agent) with filters
- Global settings (general, basic SEO defaults, system) backed by a key/value store
- Custom 404/403/419/422/500 error pages

## Requirements

- PHP 8.2+
- Composer 2
- Node.js 18+ and npm
- MySQL 8+ (or SQLite for quick local trials)

## Installation

```bash
git clone <repository-url> coupon-cms
cd coupon-cms

composer install
npm install
```

## Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` and set your database credentials (MySQL is the default in `.env.example`):

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=coupon_cms
DB_USERNAME=root
DB_PASSWORD=
```

> Quick local trial without MySQL: set `DB_CONNECTION=sqlite` and run `touch database/database.sqlite`.

Optionally set the seeded super admin's credentials before seeding (defaults shown):

```env
SEED_ADMIN_NAME="Super Admin"
SEED_ADMIN_EMAIL=admin@example.com
SEED_ADMIN_PASSWORD=ChangeMe123!
```

## Database Setup

Create the database (MySQL example):

```bash
mysql -u root -p -e "CREATE DATABASE coupon_cms CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

## Migration Commands

```bash
php artisan migrate            # run migrations
php artisan migrate:fresh      # drop all tables and re-run (destructive, dev only)
```

## Seeder Commands

```bash
php artisan db:seed
```

This creates:

- A **Super Admin** (`SEED_ADMIN_EMAIL` / `SEED_ADMIN_PASSWORD`, defaults `admin@example.com` / `ChangeMe123!`) and a demo **Manager** (`manager@example.com` / `ChangeMe123!`)
- 10 top-level categories (Fashion, Electronics, Travel, Food, Beauty, Hosting, Software, Grocery, Home & Kitchen, Sports) with a few child categories
- 6 demo stores (Amazon, Flipkart, Myntra, AJIO, Nykaa, Hostinger India)
- A handful of coupons per store, clearly titled `[DEMO] ...` and flagged in their description as test/demo data — **not real, working coupon codes**

Run both migrations and seeders from a clean database in one go:

```bash
php artisan migrate:fresh --seed
```

**Change the seeded admin passwords immediately after first login in any shared/production environment.**

## Storage Setup

Uploaded files (store logos, category images, coupon/OG images, the Media Library) are written to the `public` disk. Link it so uploads are web-accessible:

```bash
php artisan storage:link
```

## Development Commands

```bash
npm run dev          # Vite dev server with hot reload
php artisan serve    # PHP dev server (http://127.0.0.1:8000)
```

Or run both together:

```bash
composer run dev
```

Log in at `/admin/login` with the seeded admin credentials.

## Production Deployment Notes

- Set `APP_ENV=production`, `APP_DEBUG=false`, and a strong, unique `APP_KEY`
- Serve over HTTPS; `SESSION_SECURE_COOKIE` should be `true` behind HTTPS
- Run `npm run build` to compile production assets (do **not** run `npm run dev` in production)
- Run `composer install --no-dev --optimize-autoloader`
- Run `php artisan migrate --force` (never `migrate:fresh` against production data)
- Run `php artisan config:cache route:cache view:cache`
- Ensure `storage/` and `bootstrap/cache/` are writable by the web server
- Confirm `php artisan storage:link` has been run so uploaded media is servable
- Never commit `.env` — keep DB credentials, `APP_KEY`, mail credentials and future affiliate/API keys out of source control

## Default Admin Login

After seeding, log in at `/admin/login`:

| Role | Email | Password |
|---|---|---|
| Super Admin | `admin@example.com` (or `SEED_ADMIN_EMAIL`) | `ChangeMe123!` (or `SEED_ADMIN_PASSWORD`) |
| Manager (demo) | `manager@example.com` | `ChangeMe123!` |

Super Admins have full access, including Admin Users and Settings. Managers can manage Stores, Categories and Coupons but not Admin Users or Settings.

## Roles & Permissions

Authorization is implemented with Laravel Policies and Gates (`App\Policies\*`, `Gate::before` in `AppServiceProvider`) rather than a permissions package, so additional roles can be introduced later without a rewrite.

## Project Structure Notes

- Admin routes live in `routes/admin.php` (prefixed `/admin`, named `admin.*`), kept separate from `routes/web.php`, which is reserved for the public coupon website built in a later phase.
- `App\Enums` holds the fixed vocabularies (`Status`, `AdminRole`, `DiscountType`, `CouponType`) so coupon/store types aren't hard-coded across the app.
- `App\Services` holds `SlugService` (unique slug generation), `MediaUploadService` (secure uploads), `ActivityLogService` and `SettingsService`, so future phases can reuse or extend them without touching controllers.
- SEO fields (`meta_title`, `meta_description`, `canonical_url`, `robots_index`, `robots_follow`, `og_*`) exist on categories/stores/coupons now so Phase 3's SEO engine has data to work with, but no SEO rendering logic ships in Phase 1.

## What's Not in Phase 1

By design, this phase does **not** include the public coupon website, affiliate network integrations, automated coupon importing/verification, cashback, public user accounts, or programmatic SEO generation. The database and architecture are intentionally left room to add these in later phases (see the SEO/affiliate placeholder fields and the `routes/web.php` split).
