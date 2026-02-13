# KIW - Technical Documentation

This document provides a comprehensive technical guide for developers working on the Kiwi Sonus project. It covers the application's architecture, technology stack, installation procedures, and key development workflows.

## Table of Contents

1. [Project Overview](#1-project-overview)
2. [Core Features](#2-core-features)
3. [Technology Stack](#3-technology-stack)
4. [Architectural Deep-Dive](#4-architectural-deep-dive)
    - [Custom Addon System](#a-custom-addon-system)
    - [Manual Database Update Process](#b-manual-database-update-process)
    - [Background Job Processing](#c-background-job-processing)
5. [Getting Started](#5-getting-started)
    - [Prerequisites](#prerequisites)
    - [Installation](#installation)
    - [Environment Configuration](#environment-configuration)
6. [Development Workflow](#6-development-workflow)
7. [API & Authentication](#7-api--authentication)
8. [Testing](#8-testing)
9. [Deployment Notes](#9-deployment-notes)

---

## 1. Project Overview

Kiwi Sonus is a sophisticated, multi-vendor e-commerce marketplace platform. It is designed with a service-oriented architecture, where a Vue.js single-page application (SPA) consumes a robust backend API built on Laravel. The platform supports a wide range of e-commerce functionalities, from inventory management to complex order fulfillment and marketing campaigns.

## 2. Core Features

The application is functionally modularized into several key components:

- **Admin Panel**: A central dashboard for site-wide management, including user roles, product catalogs, system settings, and financial oversight.
- **Seller Panel**: A dedicated interface for vendors to manage their products, track inventory, process orders, and view sales analytics.
- **Delivery Management (Delivery Boy)**: A module for couriers to manage and track package pickups and deliveries.
- **Point of Sale (POS)**: A cashier interface designed for processing in-person sales, integrated with the central inventory system.
- **Affiliate System**: Enables marketing partners to earn commissions by driving sales, with tracking and payment management.
- **Refund System**: A structured workflow for managing customer refund requests and processing returns.

## 3. Technology Stack

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Vue.js](https://img.shields.io/badge/Vue.js-35495E?style=for-the-badge&logo=vue.js&logoColor=4FC08D)
![Vite](https://img.shields.io/badge/vite-%23646CFF.svg?style=for-the-badge&logo=vite&logoColor=white)
![Vuetify](https://img.shields.io/badge/Vuetify-1867C0?style=for-the-badge&logo=vuetify&logoColor=AEDDFF)
![MySQL](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white)

### Backend

- **Framework**: PHP 8.2 / Laravel 10
- **API Authentication**: `laravel/passport` (OAuth2)
- **Role-Based Access Control (RBAC)**: `spatie/laravel-permission`
- **Data Processing**: `maatwebsite/excel` for Excel/CSV imports and exports.
- **Payment Gateway Integrations**: Includes providers like `stripe/stripe-php` and `xendit/xendit-php`.

### Frontend

- **Framework**: Vue.js 3 (utilizing the Composition API)
- **Build Tool**: Vite
- **UI Framework**: Vuetify 3
- **State Management**: Vuex 4
- **Routing**: Vue Router 4

### Database

- The application uses Laravel's Eloquent ORM, making it compatible with multiple database systems (MySQL, PostgreSQL, etc.). It is primarily developed and tested on **MySQL/MariaDB**.

## 4. Architectural Deep-Dive

This project employs several non-standard architectural patterns that are critical for developers to understand.

### a. Custom Addon System

To maintain modularity, major features like **Affiliate** and **Refund** are implemented as "Addons" rather than being integrated directly into the core `app` directory.

- **Location**: Addon source code resides in `app/Addons/`.
- **Mechanism**: The `app/LaravelAddons/AddonManager.php` is the orchestrator. On application boot, it scans `app/Addons` for valid `addon.json` manifest files. For each valid addon found, it dynamically registers the addon's namespace using a custom `ClassLoader` and then boots the addon's dedicated Service Provider. This allows each addon to register its own routes, views, and dependencies in a self-contained manner.

### b. Manual Database Update Process

In addition to standard Eloquent migrations, the project uses a manual SQL update mechanism for complex schema changes or critical data patches.

- **Location**: Raw SQL files are stored in `sqlupdates/`.
- **Mechanism**: The `app/Http/Controllers/UpdateController.php` contains the logic to execute these scripts sequentially. This is typically triggered from a protected route in the admin panel.
- **CRITICAL WARNING**: This process is **stateful and not idempotent**. Scripts are executed based on versioning and must be run in the correct order. This is a mandatory step in the post-deployment checklist to ensure database integrity.

### c. Background Job Processing

The application offloads long-running tasks to a queue to prevent HTTP timeouts and improve user experience.

- **Examples**: `EditBulkUploadJob` (processing large product imports) and `ExportProductJob` (generating large reports).
- **Configuration**: The queue driver is configured in `config/queue.php`. For production, a robust driver like `redis` or `database` should be used instead of the default `sync`.
- **Execution**: A queue worker must be run in the production environment using a command like `php artisan queue:work`.

## 5. Getting Started

### Prerequisites

- PHP >= 8.2 (with required extensions: `pdo`, `mbstring`, `openssl`, etc.)
- Composer 2.x
- Node.js >= 18.x & NPM
- A compatible database server (e.g., MySQL 8.0)

### Installation

1. **Clone the repository:**

    ```bash
    git clone https://github.com/solarnusantara/kiw.git
    cd kiw.sonus.id
    ```

2. **Install backend dependencies:**

    ```bash
    composer install
    ```

3. **Create and configure the `.env` file:**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Set up the database and services:**
    - Run migrations and seed the database with initial data.

      ```bash
      php artisan migrate --seed
      ```

    - Install Laravel Passport keys for OAuth2.

      ```bash
      php artisan passport:install
      ```

5. **Install frontend dependencies:**

    ```bash
    npm install
    ```

### Environment Configuration

Open the `.env` file and configure the following critical variables:

```ini
APP_NAME=[APP_NAME]
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=[DB_NAME]
DB_USERNAME=root
DB_PASSWORD=

# Configure Mail, Queue, and Payment Gateway credentials as needed
MAIL_MAILER=smtp
QUEUE_CONNECTION=database
STRIPE_KEY=...
XENDIT_SECRET_KEY=...
```

## 6. Development Workflow

For local development, you need to run two separate processes concurrently in separate terminal sessions:

1. **Backend Server (Laravel):**

    ```bash
    php artisan serve
    ```

2. **Frontend Server (Vite):** This provides hot-reloading for Vue components.

    ```bash
    npm run dev
    ```

The application will be accessible at the URL provided by Vite (e.g., `http://localhost:5173`).

## 7. API & Authentication

The application is API-driven. The backend exposes a set of protected endpoints that the Vue.js frontend consumes.

- **Authentication**: Handled by Laravel Passport. Clients must obtain an OAuth2 Bearer Token from the relevant endpoints. This token must be included in the `Authorization` header for all subsequent API requests.
- **API Routes**: Defined in `routes/api.php` and are protected by the `auth:api` middleware group.
- **Guard Configuration**: The API authentication guard is configured in `config/auth.php`.

## 8. Testing

To run the PHPUnit test suite for the backend, use the following Artisan command:

```bash
php artisan test
```

## 9. Deployment Notes

- **Build Process**: For production, frontend assets **must** be built using `npm run build`. The backend requires `composer install --no-dev --optimize-autoloader`.
- **IIS / Windows Server**: The presence of a `web.config` file indicates that this application is configured for deployment on a Windows Server using IIS. This is a key environmental consideration.
- **Post-Deployment Checklist**: After deploying new code, always run the following commands:

  ```bash
  php artisan migrate --force
  php artisan passport:install # If not already run
  # Manually trigger the sqlupdates process from the admin panel
  php artisan config:cache
  php artisan route:cache
  php artisan view:cache
  ```

- **Queue Worker**: In a production environment, configure a robust service manager (like `Supervisor` on Linux or a Windows Service) to keep the `php artisan queue:work` process running continuously.
