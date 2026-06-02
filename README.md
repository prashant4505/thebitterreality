# The Bitter Reality

A bilingual (Hindi / English) web platform that presents history as immersive stories. Built with **Laravel 12**, **Tailwind CSS 4**, and **Alpine.js**.

## Features

- Bilingual content — every topic, chapter, figure, and page is available in Hindi (`/hi/...`) and English (`/...`)
- Topics organized by category with multi-chapter support
- Historical figures with dedicated profile pages
- Interactive timelines with entries
- Full-text search with live suggestions and trending searches
- Bookmarking and commenting on topics (rate-limited)
- Admin panel for managing all content, comments, and image uploads
- SEO-ready: sitemap, robots.txt, canonical URLs

## Tech Stack

| Layer      | Technology                     |
|------------|-------------------------------|
| Backend    | PHP 8.2+, Laravel 12          |
| Frontend   | Tailwind CSS 4, Alpine.js 3   |
| Bundler    | Vite 7 + laravel-vite-plugin  |
| Dev env    | Lando (LAMP, PHP 8.3)         |

## Requirements

- PHP >= 8.2
- Composer
- Node.js >= 18
- MySQL / MariaDB

## Getting Started

```bash
# 1. Clone the repository
git clone git@github.com:prashant4505/thebitterreality.git
cd thebitterreality

# 2. Install dependencies and bootstrap the project
composer run setup

# 3. Configure your environment
cp .env.example .env
# Edit .env — set DB_*, APP_URL, etc.

# 4. Run migrations (if not already run by setup)
php artisan migrate

# 5. Start the development server
composer run dev
```

The app will be available at `http://localhost:8000`.

## Project Structure

```
app/
  Http/Controllers/
    Admin/      — admin panel controllers
    Public/     — public-facing controllers
  Models/       — Eloquent models (bilingual via *Translation models)
  Services/     — business logic services
resources/
  views/
    admin/      — admin panel Blade views
    public/     — public Blade views
    layouts/    — shared layouts
    components/ — reusable Blade components
routes/
  web.php       — all routes (admin + bilingual public)
```

## Running Tests

```bash
composer run test
```

## Admin Panel

Visit `/admin/login` to access the admin panel. The admin middleware restricts access to users with the `admin` role.

## License

MIT
