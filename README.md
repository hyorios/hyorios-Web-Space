# hyorios-Web-Space 🚀

Welcome to my personal digital space! This is a web application built from the ground up to be a canvas for creativity and experimentation.

## Architecture

This project was recently migrated from a FastAPI starting point to a modern, robust architecture:

-   **Backend:** Laravel (inside `laravel-api/`)
    -   Exposes a RESTful API.
    -   Includes Laravel Backpack for content management.
-   **Frontend:** Nuxt 3 (inside `nuxt-frontend/`)
    -   Vue 3 framework for the public facing portfolio and web space.
    -   Communicates with the Laravel API.

## Local Development Setup

To run this project locally, you will need PHP (with Composer) for the backend and Node.js (with npm) for the frontend.

### 1. Backend (Laravel) Setup

1. **Navigate to the backend directory:**
   ```bash
   cd laravel-api
   ```
2. **Install PHP dependencies:**
   ```bash
   composer install
   ```
3. **Environment Setup:**
   Copy the example environment file and configure your database (e.g., using SQLite).
   ```bash
   cp .env.example .env
   ```
   *Make sure your database connection settings are correct in `.env`.*
4. **Generate application key:**
   ```bash
   php artisan key:generate
   ```
5. **Run migrations (and seed data if available):**
   ```bash
   php artisan migrate --seed
   ```
6. **Start the Laravel development server:**
   ```bash
   php artisan serve
   ```
   The API will typically run on `http://127.0.0.1:8000`.

### 2. Frontend (Nuxt) Setup

1. **Navigate to the frontend directory:**
   (Open a new terminal window/tab)
   ```bash
   cd nuxt-frontend
   ```
2. **Install Node.js dependencies:**
   ```bash
   npm install
   ```
3. **Environment Setup:**
   Copy the example environment file (if provided) or create a `.env` file to set your API base URL.
   ```bash
   cp .env.example .env
   ```
   *Example `.env` content: `NUXT_PUBLIC_API_BASE=http://127.0.0.1:8000/api`*
4. **Start the Nuxt development server:**
   ```bash
   npm run dev
   ```
   The frontend will typically run on `http://localhost:3000`.

## Features

-   **Projects Showcase:** View a list of published portfolio projects, filterable by tech stack.
-   **Project Details:** Dedicated detail pages for individual projects.
-   **Backoffice:** Manage content via the Laravel Backpack admin panel.

---
*Built with the help of AI coding assistants.*
