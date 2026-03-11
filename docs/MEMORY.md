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

## 2026-03-11: UI Cleanup & Tailwind Migration

### UI Fixes
1. **Backend Admin CSS**: Fixed the Backpack Login page (`/admin/login`) missing styles. Backpack 7+ uses Vite; running `npm install` and `npm run build` inside `laravel-api` successfully deployed `app.css` and `app.js` to public assets, restoring the UI.
2. **Frontend UI Fix (Tailwind Strict Policy)**: Removed all custom/scoped CSS (`<style scoped>`) from Nuxt SFCs in favor of strictly using Tailwind CSS classes, as per rules. installed `@nuxtjs/tailwindcss`.
3. **Z-Index Layering Fix**: The Ambient Background was bleeding into content. Fixed by applying strict Tailwind layers: `-z-10` on the `AmbientBackground.vue` wrapper and increasing `z-10` on main content. Also significantly lowered opacity on drifting quotes/images via `useBackgroundAnimation` to avoid visual clutter.
4. **Bento Grid Refactoring**: The Grid layout uses clean utility mapping `grid gap-6 grid-cols-1 md:grid-cols-3` now instead of complex custom grids.

## 2026-03-11: Custom Backend Login (Admin Portal)

### UI Design
- **Particle System**: The default Backpack login page was structurally overridden (`vendor/backpack/theme-tabler/auth/login.blade.php`) to ditch the white background and present a deep Charcoal theme (`#0a0a0a`).
- **Canvas Animations**: A custom, lightweight vanilla JS particle system (500 drifting zinc-colored dots on an infinite loop) is rendered underneath the login form to parallel the landing page's ambient vibe.
- **Glassmorphism**: The login card container utilizes native CSS backdrop filters (`backdrop-filter: blur(16px)`) with subtle borders and 45% black opacity to float above the particle canvas.

## 2026-03-11: FormRequest Validation Fixes

### Slug Unique Checks
- Fixed a bug in `ProjectRequest.php` where updating an existing project without altering its `slug` threw a "Slug already taken" validation error.
- Integrated `\Illuminate\Validation\Rule::unique('projects', 'slug')->ignore($id)` by accurately extracting the Backpack route `$id` from the injected put parameters (`$this->get('id') ?? $this->route('id')`).
- Wrote two new testing assertions (`test_project_can_be_updated_without_changing_slug` and `test_project_cannot_be_updated_with_existing_foreign_slug`) adhering to TDD parameters.
