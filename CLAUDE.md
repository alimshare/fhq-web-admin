# FHQ Web Admin

Aplikasi web admin untuk manajemen lembaga pendidikan (pesantren) FHQ An-Nashr.

## Tech Stack

- **Backend:** Laravel 8.x (PHP 7.3+/8.x)
- **Frontend:** Blade templates + Materialize CSS, Laravel Mix (Webpack), Vue 2, jQuery
- **Database:** MySQL
- **Packages:** laravel-dompdf, maatwebsite/excel, phpoffice/phpword, ixudra/curl

## Project Structure

```
app/
  Http/Controllers/    # Controllers (flat, no subdirectory nesting)
  Model/               # Eloquent models (note: singular "Model", not "Models")
config/
database/
  migrations/
  seeds/               # Database seeders (classmap autoloaded)
resources/views/
  layouts/materialized/  # Main layout (Materialize CSS framework)
  pages/                 # Feature views organized by module
routes/web.php           # All web routes (single file)
public/assets/           # Static assets (CSS, JS, plugins)
```

## Key Conventions

- **Models** are in `app/Model/` (not `app/Models/`).
- **Routes** use a mix of string-based (`'Controller@method'`) and array-based (`[Controller::class, 'method']`) syntax. New routes should use the array syntax.
- **Permissions** use `spatie/laravel-permission`-style middleware: `->middleware(['permission:permission-name'])`.
- **Views** are organized under `resources/views/pages/{module}/`.
- **Naming** uses Indonesian terms: santri (student), pengajar (teacher), halaqoh (study group), lembaga (institution), semester, keuangan (finance).
- **Seeders** use the `database/seeds/` directory with classmap autoloading (Laravel 8 legacy style).

## Common Commands

```bash
php artisan serve            # Run dev server
php artisan migrate          # Run migrations
php artisan db:seed          # Run seeders
npm run dev                  # Compile assets (development)
npm run prod                 # Compile assets (production)
php artisan route:list       # List all routes
vendor/bin/phpunit           # Run tests
```

## Modules

| Module     | Route Prefix  | Controller             | Description                |
|------------|---------------|------------------------|----------------------------|
| Dashboard  | /dashboard    | HomeController         | Dashboard & rekap          |
| Santri     | /santri       | SantriController       | Student management         |
| Pengajar   | /pengajar     | PengajarController     | Teacher management         |
| Halaqoh    | /halaqoh      | HalaqohController      | Study group management     |
| Semester   | /semester     | SemesterController     | Semester management        |
| Absensi    | /absensi      | AbsensiController      | KBM attendance             |
| Keuangan   | /keuangan     | FinanceController      | Finance (kas masuk/keluar) |
| PSB        | /psb, /daftar-ulang | PSBController   | New student registration   |
| Users      | /users        | UserController         | User management            |
| Roles      | /role         | RolePermissionController | Roles & permissions      |
| Settings   | /settings     | SettingController       | App settings (resource)   |

## Branch Strategy

- `master` is the main branch.
- Feature branches use `feat/{feature-name}` convention.
