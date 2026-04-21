# The Grapes

A Laravel 13 + Livewire 4 site for the band The Grapes. The app includes a public homepage, an authenticated admin dashboard, and Fortify-powered auth pages for login, registration, password reset, and two-factor flows.

## What It Does

- Public homepage that shows upcoming gigs and active social links from the database.
- Admin dashboard for managing shows and social links.
- Auth pages styled to match the site branding.
- Registration flow that normalizes user names to title case and email addresses to lowercase before saving.

## Tech Stack

- Laravel 13
- Livewire 4
- Livewire Flux UI
- Fortify authentication
- Tailwind CSS 4 via Vite
- MySQL for local development

## Requirements

- PHP 8.3 or newer
- Composer
- Node.js and npm
- MySQL

## Local Setup

1. Install PHP dependencies:

   ```bash
   composer install
   ```

2. Install frontend dependencies:

   ```bash
   npm install
   ```

3. Copy the example environment file if needed:

   ```bash
   copy .env.example .env
   ```

4. Generate an application key:

   ```bash
   php artisan key:generate
   ```

5. Create and migrate the database:

   ```bash
   php artisan migrate
   ```

6. Build frontend assets:

   ```bash
   npm run build
   ```

7. Start the app:

   ```bash
   php artisan serve
   ```

## Recommended Environment Values

For the current local XAMPP setup, the app expects values similar to these:

```env
APP_NAME="The Grapes"
APP_URL=http://localhost:8000
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=grapes
DB_USERNAME=root
DB_PASSWORD=
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
```

## Main Routes

Public and app routes are registered in Laravel and Fortify.

- `/` - public homepage
- `/dashboard` - admin dashboard for logged-in, verified users
- `/login` - login screen
- `/register` - registration screen
- `/forgot-password` - password reset request screen
- `/reset-password/{token}` - password reset form
- `/email/verify` - email verification notice
- `/two-factor-challenge` - two-factor challenge screen
- `/settings/profile` - profile settings
- `/settings/appearance` - appearance settings
- `/settings/security` - security settings

## Database Tables

The band content is stored in these tables:

- `shows` - upcoming gigs and featured show content
- `social_links` - social and booking links
- `users` - admin accounts

## Testing

Run the full test suite with:

```bash
php artisan test
```

You can also use the Composer script:

```bash
composer test
```

## Development Commands

- `php artisan serve` - start the backend server
- `npm run dev` - start the Vite dev server
- `composer test` - run lint checks and the test suite
- `composer run lint:check` - run Pint in test mode

## Notes

- Login and registration routes are provided by Fortify, not defined directly in `routes/web.php`.
- The homepage, dashboard, and auth screens are all customized for The Grapes branding.
- User registration lowercases emails and title-cases names before saving.
