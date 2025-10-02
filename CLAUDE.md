# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a Laravel 12 application using Livewire v3 with Flux UI components, Filament Admin Panel, and Laravel Fortify for authentication. The project is based on the official Laravel Livewire starter kit and uses:

- **Backend**: Laravel 12 (PHP 8.2+)
- **Frontend**: Livewire v3, Flux UI components, Volt (single-file components)
- **Admin Panel**: Filament v4 (accessible at `/admin`)
- **Auth**: Laravel Fortify (frontend) + Filament Auth (admin panel) with email verification, password reset, and two-factor authentication
- **Styling**: Tailwind CSS v4 with Vite
- **Testing**: Pest PHP
- **Database**: MySQL (configured for `flexcommerce` database)
- **Local URL**: http://flexcommerce.test (using Laravel Valet)

## Development Commands

### Starting Development Server
```bash
composer dev
```
This runs a concurrent development environment with:
- PHP development server (`php artisan serve`)
- Queue worker (`php artisan queue:listen --tries=1`)
- Log viewer (`php artisan pail`)
- Vite dev server (`npm run dev`)

### Individual Services
```bash
php artisan serve          # Start Laravel dev server (http://localhost:8000)
npm run dev                # Start Vite dev server only
php artisan queue:listen   # Start queue worker
php artisan pail           # View application logs
```

### Testing
```bash
composer test              # Run all Pest tests (clears config first)
php artisan test           # Run tests directly
php artisan test --filter=TestName  # Run specific test
```

### Building Assets
```bash
npm run build              # Build production assets with Vite
```

### Code Quality
```bash
./vendor/bin/pint          # Run Laravel Pint code formatter
```

### Database
```bash
php artisan migrate        # Run migrations
php artisan migrate:fresh --seed  # Fresh migration with seeding
php artisan db:seed        # Run seeders
```

## Architecture

### Livewire Component Structure

The application follows a Livewire-centric architecture where pages are Livewire components:

- **Full-page components**: Located in `app/Livewire/` with corresponding views in `resources/views/livewire/`
- **Volt components**: Single-file Livewire components may be used for simpler pages
- **Flux UI components**: Pre-built UI components from Livewire Flux (located in `resources/views/flux/`)

#### Component Organization
```
app/Livewire/
├── Auth/           # Authentication pages (Login, Register, ForgotPassword, etc.)
├── Settings/       # User settings pages (Profile, Password, TwoFactor, Appearance)
└── Actions/        # Livewire actions (e.g., Logout)
```

### Routing Pattern

Routes in `routes/web.php` map directly to Livewire components:

```php
Route::get('settings/profile', Profile::class)->name('settings.profile');
```

This means the `Profile` Livewire class serves as both the controller and view logic. Authentication pages are defined in `routes/auth.php`.

### Authentication Flow

- **Laravel Fortify** handles authentication logic (registration, login, password reset)
- **Livewire components** provide the UI layer (`app/Livewire/Auth/`)
- Features include: email verification, password confirmation, two-factor authentication
- Auth views are in `resources/views/livewire/auth/`

### Frontend Asset Pipeline

- **Vite** bundles assets defined in `vite.config.js`
- **Entry points**: `resources/css/app.css` and `resources/js/app.js`
- **Tailwind CSS v4** is integrated via the Vite plugin
- Hot module replacement (HMR) enabled in development

### Testing Structure

- **Pest PHP** is the testing framework
- **Feature tests**: `tests/Feature/` - test full user flows and Livewire components
- **Unit tests**: `tests/Unit/` - test isolated logic
- Test configuration in `tests/Pest.php` auto-applies `RefreshDatabase` trait to Feature tests
- Tests use in-memory SQLite database

### Database

- **Database**: MySQL (`flexcommerce` database on localhost:3306)
- **Migrations**: `database/migrations/`
- **Factories**: `database/factories/`
- **Seeders**: `database/seeders/`
- Queue and cache tables use the database driver

## Key Conventions

### Livewire Component Development

When creating new Livewire components:
1. Create the component class in `app/Livewire/[Category]/`
2. Create the corresponding Blade view in `resources/views/livewire/[category]/`
3. Use Flux UI components for consistent styling
4. Register routes in `routes/web.php` or `routes/auth.php`

### Environment Configuration

- Copy `.env.example` to `.env` for local setup
- Default queue driver: `database` (requires migrations)
- Default session driver: `database` (requires migrations)
- Mail driver: `log` (emails written to logs in development)

### Filament Admin Panel

The project includes Filament v4 for the admin panel:

- **URL**: http://flexcommerce.test/admin
- **Login**: http://flexcommerce.test/admin/login
- **Panel Provider**: `app/Providers/Filament/AdminPanelProvider.php`
- **Resources**: `app/Filament/Resources/` - CRUD interfaces for models
- **Pages**: `app/Filament/Pages/` - Custom admin pages
- **Widgets**: `app/Filament/Widgets/` - Dashboard widgets
- **Primary Color**: Amber (configured in AdminPanelProvider)

#### Filament Artisan Commands
```bash
php artisan make:filament-resource ModelName  # Generate resource (CRUD)
php artisan make:filament-page PageName       # Generate custom page
php artisan make:filament-widget WidgetName   # Generate dashboard widget
php artisan make:filament-user                # Create admin user
```

### Artisan Commands

Standard Laravel artisan commands are available via `./artisan` or `php artisan`:
- `php artisan make:livewire ComponentName` - Generate Livewire component
- `php artisan livewire:make ComponentName` - Alternative syntax
- `php artisan route:list` - List all routes
- `php artisan tinker` - Interactive REPL

## Architectural Decisions

### Multi-Provider Abstraction Pattern

This project implements an abstracted architecture for critical integrations, allowing multiple providers per service:

**1. Shipping System** (`app/Services/Shipping/`)
- Interface: `ShippingProviderInterface`
- Factory: `ShippingService`
- Providers: Melhor Envio (default), Correios, Jadlog, Loggi, Kangu
- Config: `config/shipping.php`
- Benefit: Customer chooses shipping method from multiple carriers

**2. Payment System** (`app/Services/Payment/`)
- Interface: `PaymentGatewayInterface`
- Factory: `PaymentService`
- Gateways: Mercado Pago (default), Stripe, Asaas, PagSeguro, Pagar.me
- Config: `config/payment.php`
- Benefit: Multiple payment methods from different gateways simultaneously

**3. Invoice System (NFe)** (`app/Services/Invoice/`)
- Interface: `InvoiceProviderInterface`
- Factory: `InvoiceService`
- Providers: Focus NFe (default), eNotas, NFe.io, WebMania
- Config: `config/invoice.php`
- Benefit: Flexibility in fiscal compliance providers

### Theme System

5 pre-built themes located in `resources/views/themes/`:
- `modern/` - Modern and minimalist design
- `classic/` - Traditional e-commerce layout
- `bold/` - Vibrant colors and bold typography
- `minimal/` - Ultra-minimalist approach
- `elegant/` - Sophisticated and refined design

Theme switching via Settings in Filament admin panel (one-click change).

### CMS Pages

Institutional pages managed via Filament Page Resource:
- Terms of Service, Privacy Policy, About Us, FAQ, Contact
- WYSIWYG editor (Filament RichEditor)
- Full SEO support per page

### Product Reviews

Built-in review system with:
- Star ratings (1-5)
- Customer comments
- Photo uploads (optional)
- Admin moderation via Filament

## Important Files

- [ROADMAP.md](ROADMAP.md) - Complete development roadmap with phases, sprints, and implementation details
- `config/shipping.php` - Shipping providers configuration
- `config/payment.php` - Payment gateways configuration
- `config/invoice.php` - Invoice providers configuration
