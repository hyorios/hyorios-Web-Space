# Project Memory

## 2026-03-11: Admin Authentication & Project Fields Migration

### Architectural Decisions
1. **Admin Protection**: We chose to implement a simple boolean `is_admin` column on the `users` table for Admin access testing instead of Spatie Permission for Phase 1. `CheckIfAdmin` middleware was modified to check this column.
2. **Project Validation**: Added required validation rules for `title` and `slug` to the `ProjectRequest` within the Laravel app to prevent incomplete data from reaching the database (satisfying TDD rules).
3. **Project Table Expansion**: We migrated the following V1 Portfolio fields to the `projects` table: `slug`, `excerpt`, `thumbnail`, `repo_url`, `live_url`, `is_featured`, `tech_stack` (JSON type), and `published_at`.

### TDD Outcomes
- Tests were successfully written and validated around Admin Middleware block/allow access methods, as well as Backpack's form validation requests. Make sure `$fillable` fields are updated on Eloquent Models (`Project.php`) when adding new columns to make traits work during Backpack updates.

## 2026-03-11: Nuxt 3 Frontend Modularization & Component Architecture

### Architectural Decisions
1. **SFC Modularization**: The `index.vue` page was split into distinct components (`AppNavbar.vue`, `HeroSection.vue`, `AmbientBackground.vue`, `ProjectCard.vue`) located in `app/components/` in accordance with Vue/Nuxt 3 best practices.
2. **Prop Drilling & Emits**: State like `locale` remains at the top-level (`pages/index.vue`), passing down props to functional UI components and reacting to emits for interactivity (`@toggle-locale`).
3. **CSS Scoping**: Giant monolothic styles in `index.vue` were broken up into isolated, `scoped` blocks across each component.
4. **GSAP Injection**: The ambient GSAP logic is properly contained inside a single dummy `AmbientBackground.vue` container referencing `useBackgroundAnimation` within the Nuxt App Context to avoid blocking main content rendering.

### TDD Outcomes
- Verified `ProjectCard.vue` correctly renders props out of the box using Vitest and `happy-dom` before actual integration.
- Configured Nuxt `@nuxt/test-utils` environment inside the frontend structure to guarantee a green-light approach for component development going forward.

## 2026-03-11: API JSON Formatting & ProjectResource

### Architectural Decisions
1. **API Resource Classes**: Implemented `App\Http\Resources\ProjectResource` to enforce strict formatting and type-safety of Laravel responses to the Nuxt frontend.
2. **Boolean and Array Casting**: Frontend expects strict arrays mapping (`tech_stack`) and booleans (`is_featured`). These are inherently backed by Eloquent `$casts` in the model, but the `ProjectResource` ensures this is consistently serialized to JSON by actively converting/guarding `tech_stack` and `bool` values.
3. **Spatie Translation Outputs**: Explicit `getTranslations()` are used to deliver the JSON structure `{en: '...', de: '...'}` to Vue instead of auto-casting a single string based on the current locale, allowing reactive translations on the client.

### TDD Outcomes
- Validated that existing API `ProjectTest` assertions (e.g., filtering logic by tech stack output shapes) map correctly onto the new `data` wrapper outputs constructed by `ProjectResource`.
