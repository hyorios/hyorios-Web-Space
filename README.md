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

<<<<<<< HEAD
---
*Built with the help of AI coding assistants.*
=======
    # Aktivieren (macOS/Linux)
    source venv/bin/activate

    # Aktivieren (Windows)
    .\venv\Scripts\activate
    ```
    *Sie erkennen die aktive Umgebung an dem `(venv)` vor Ihrer Kommandozeilen-Eingabe.*

4.  **Abhängigkeiten installieren:**
    Installieren Sie alle benötigten Python-Pakete mit einem einzigen Befehl.
    ```bash
    pip install -r requirements.txt
    ```

5.  **Webserver starten:**
    Starten Sie die FastAPI-Anwendung mit `uvicorn`.
    ```bash
    uvicorn app.main:app --host 0.0.0.0 --port 8000 --reload
    ```

6.  **Anwendung im Browser aufrufen:**
    Der Server läuft jetzt! Öffnen Sie Ihren Webbrowser und gehen Sie zu folgender Adresse:
    [http://localhost:8000](http://localhost:8000)

    Sie sollten nun die Web-Plattform sehen. Um den Server zu stoppen, wechseln Sie zurück ins Terminal und drücken `STRG+C`.

## Development Notes

- **2026-02-25:** Added CORS middleware to the FastAPI backend (`backend/main.py`) to resolve connection issues between the frontend and backend during local development.
>>>>>>> a1d2f8419b4adf21b301f3b82751028989e7689c
