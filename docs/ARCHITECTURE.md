# Architecture - hyorios Web Space

## 1) Repository-Struktur (Ist)
- `/laravel-api`: aktives Laravel-Backend inkl. Backpack-Admin.
- `/nuxt-frontend`: aktives Nuxt-Frontend (Portfolio-UI).
- `/archive_v1`: historischer FastAPI/Jinja-Stand (nicht Teil des aktuellen Haupt-Stacks).

## 2) Tech-Stack Überblick

### Backend
- **Framework:** Laravel `^12.0`
- **Sprache:** PHP `^8.2`
- **Admin:** Backpack CRUD `^7.0`, Theme Tabler `^2.0`
- **Auth/API:** Laravel Sanctum `^4.0`
- **Build:** Vite `^7`, Tailwind CSS `^4` (Laravel-Asset-Pipeline)
- **DB (Default):** SQLite

### Frontend
- **Framework:** Nuxt `^4.3.1`
- **UI Runtime:** Vue `^3.5.x`
- **Routing:** Vue Router `^4.6.x`
- **Integration:** Clientseitiger Fetch auf Laravel API (`/api/projects`)

### Tooling/Test
- **PHP Tests:** PHPUnit `^11.5`
- **Code Style (PHP):** Laravel Pint
- **JS Package Manager:** npm (lockfile vorhanden)

## 3) Backend-Architektur (Laravel + Backpack)

### 3.1 Routing
- `routes/web.php`: Root `/` auf Laravel Welcome View.
- `routes/api.php`:
  - `GET /api/projects` (öffentlich)
  - `GET /api/user` (auth:sanctum)
- `routes/backpack/custom.php`:
  - Backpack CRUD Route für `project` unter `/admin/project`.

### 3.2 Domain-Modell
- `App\Models\Project`
  - Felder: `title`, `description`, `status`
  - nutzt Backpack `CrudTrait`

### 3.3 Admin Layer
- `ProjectCrudController`
  - aktiviert List/Create/Update/Delete/Show
  - generiert Felder/Spalten aktuell mit `setFromDb()`
- `ProjectRequest`
  - Authorisierung via `backpack_auth()->check()`
  - Validierungsregeln aktuell leer

### 3.4 Security/Auth
- Backpack Middleware-Key: `admin`
- Custom Middleware `CheckIfAdmin` ist aktiv, prüft derzeit aber faktisch nicht auf Rollen (`checkIfUserIsAdmin()` gibt `true` zurück).
- Sanctum ist konfiguriert (stateful Domains inkl. localhost-Umgebungen).

### 3.5 Persistence
- Standard-Migrationen für Users/Sessions/Jobs/Cache.
- Zusätzliche Migrationen:
  - `projects`
  - `personal_access_tokens`
- Entwicklungs-Default aus `.env.example`: SQLite (`DB_CONNECTION=sqlite`).

## 4) Frontend-Architektur (Nuxt)

### 4.1 Aktuelle Struktur
- Der relevante UI-Code liegt zentral in `app/app.vue`.
- Keine ausgeprägte Feature-/Modulstruktur (noch frühes Stadium).

### 4.2 Datenfluss
1. Frontend mounted.
2. Browser ruft `http://127.0.0.1:8000/api/projects` auf.
3. Response wird als Projektliste gerendert.
4. Status-Widget zeigt Erfolg/Fehler der Verbindung an.

### 4.3 Rendering/UX
- Single-Page-artige Portfolio-Dashboard-Oberfläche.
- Visuelle Effekte (animierte Quotes, Hintergründe, Hover-Interaktion auf Cards).

## 5) Laufzeit- und Integrationsbild
- Lokal laufen zwei getrennte Prozesse:
  - Laravel API (typisch Port 8000)
  - Nuxt Dev Server (typisch Port 3000)
- Integration ist aktuell über hardcodierte Backend-URL im Frontend gelöst.
- CORS-/Proxy-Strategie ist nicht explizit zentralisiert dokumentiert.

## 6) Aktuelle Architektur-Qualität

### Stärken
- Klare Trennung zwischen API/Admin und Public Frontend.
- Schneller Content-Flow dank Backpack CRUD.
- Minimal funktionsfähige End-to-End-Datenkette (`admin -> DB -> /api/projects -> frontend`).

### Schwächen
- Geringe Testabdeckung für echte Produktpfade.
- Rollen-/Berechtigungsmodell nicht produktionsreif.
- API-Vertrag ist minimal (keine Pagination/Filter/Versionierung).
- Frontend-Struktur aktuell stark monolithisch (`app.vue` als zentraler Block).

## 7) Technische Schulden / Legacy
- `archive_v1` enthält eine ältere FastAPI/Jinja-Implementierung.
- Root-README referenziert noch überwiegend den alten Python-Setup-Pfad.
- Für neue Mitwirkende kann das zu Onboarding-Verwirrung führen, solange "active stack" nicht klar markiert wird.
