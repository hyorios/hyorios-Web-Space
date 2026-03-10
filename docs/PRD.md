# PRD - hyorios Web Space

## 1) Ziel des Dokuments
Dieses Dokument beschreibt:
- den aktuellen Produktumfang (Ist-Zustand),
- den logischen nächsten Schritt für ein portfoliotaugliches Release,
- klare Anforderungen für die nächste Ausbaustufe.

## 2) Produktkontext
`hyorios-Web-Space` ist aktuell als persönlicher Web Space angelegt:
- ein öffentliches Frontend zur Darstellung von Projekten,
- ein Admin-Backend auf Laravel/Backpack zur Pflege der Projektdaten.

## 3) Aktueller Funktionsumfang (Ist-Zustand)

### 3.1 Nutzerrollen
- Besucher: sehen die Portfolio-Startseite und Projektkarten im Frontend.
- Admin: verwaltet Projekte im Backpack-Adminbereich.

### 3.2 Öffentliche Oberfläche (Nuxt)
- Eine zentrale Seite rendert Projektkarten aus dem API-Endpoint `GET /api/projects`.
- Ein "System Status"-Element prüft die Backend-Erreichbarkeit per manueller API-Abfrage.
- Visuelle/atmosphärische Darstellung (animierte Quotes, Dashboard-Look).
- Aktuell keine dedizierten Projekt-Detailseiten und keine Navigation über mehrere Inhaltsseiten.

### 3.3 Backend/API (Laravel)
- `GET /api/projects`: liefert alle Projekte nach `created_at` absteigend.
- `GET /api/user`: vorhanden, nur mit `auth:sanctum`.
- Health-Endpoint via Laravel Bootstrap auf `/up`.

### 3.4 Admin-Bereich (Backpack)
- CRUD für `projects` unter `/admin/project`.
- Operationen: List, Create, Update, Delete, Show.
- Menüeintrag "Projects" im Admin-Menü vorhanden.
- Zugriff auf Admin-Routen wird über Backpack-Auth + `CheckIfAdmin` gesichert.
- Der Admin-Check erlaubt aktuell jeden eingeloggten User (`return true`), ohne echte Rollenprüfung.

### 3.5 Datenmodell
- Tabelle `projects`:
  - `id`
  - `title` (string, required)
  - `description` (nullable text)
  - `status` (string, default `planned`)
  - `timestamps`
- Eloquent Model `Project` mit Fillable-Feldern: `title`, `description`, `status`.

### 3.6 Qualität/Tests
- Nur Laravel-Standardbeispiele in Unit/Feature-Tests.
- Keine gezielten Tests für Projects-API, Admin-CRUD oder Frontend-Logik.

## 4) Produktlücken
- Kein klarer Content-Typ für Portfolio (z. B. Slug, Cover, Tech-Stack, Links, Sortierung, Featured).
- Kaum Validierung auf Projektebene (Request-Regeln leer).
- Keine echte Rollen-/Berechtigungsstrategie für Admin.
- Keine API-Versionierung oder strukturierte Response-Konvention.
- Frontend ist aktuell eher "Single View" statt vollständiges Portfolio-Erlebnis.
- Root-README ist inhaltlich noch auf den früheren FastAPI-Stand ausgerichtet.

## 5) Nächster logischer Schritt (Portfolio v1)
**Ziel:** Von einem technischen Skeleton zu einem präsentierbaren, wartbaren Portfolio-Produkt.

### 5.1 Produktziel
Ein öffentliches Portfolio, das reale Projekte strukturiert zeigt und sich über das Admin-Backend zuverlässig pflegen lässt.

### 5.2 Scope für Portfolio v1
- Public Seitenstruktur:
  - Startseite mit Hero + Featured Projects
  - Projektübersicht mit Filter/Sortierung
  - Projekt-Detailseite pro Eintrag
- Content-Modell erweitern:
  - `slug`, `excerpt`, `thumbnail/cover`, `tech_stack`, `repo_url`, `live_url`, `is_featured`, `published_at`
- Admin-Usability:
  - valide Felder, klare Formulare, Veröffentlichungsstatus
- API verbessern:
  - öffentliche, stabile Endpunkte für Liste + Detail
  - optional Filter (`status`, `featured`, `tech`)
- Basisqualität:
  - Feature-Tests für API
  - Smoke-Test für zentrale Frontend-Datenladung

### 5.3 Nicht im Scope (v1)
- Mehrsprachigkeit
- Nutzerregistrierung für Endkunden
- Kommentar-/CMS-Komplexität
- Vollständiges Analytics/Tracking-Ökosystem

## 6) Akzeptanzkriterien für Portfolio v1
- Besucher können Projekte auflisten und ein einzelnes Projekt über eine sprechende URL öffnen.
- Admin kann Projekte inklusive Metadaten erstellen, bearbeiten, veröffentlichen und depublizieren.
- API liefert nur veröffentlichte Inhalte an die öffentliche Oberfläche.
- Mindestens grundlegende Testabdeckung für API-Hauptpfade vorhanden.
- Lokales Setup bleibt mit dokumentierten Schritten reproduzierbar.

## 7) Risiken
- Ohne saubere Rollenlogik bleibt Admin-Sicherheit schwach.
- Ohne klare Content-Standards wird Portfolio inkonsistent.
- Ohne Testbasis steigt Regressionsrisiko bei iterativen Änderungen.

## 8) Offene Fragen für die gemeinsame Abstimmung
- Soll Portfolio v1 bilingual (DE/EN) starten oder erst in v2?
- Sollen Projekte als reine Cards reichen oder als Case-Studies mit Abschnitten (Problem, Lösung, Impact)?
- Priorität: zuerst Content-/Admin-Modell, oder zuerst öffentliche Seitenstruktur?
