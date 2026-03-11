# Project Memory

## 2026-03-11: Admin Authentication & Project Fields Migration

### Architectural Decisions
1. **Admin Protection**: We chose to implement a simple boolean `is_admin` column on the `users` table for Admin access testing instead of Spatie Permission for Phase 1. `CheckIfAdmin` middleware was modified to check this column.
2. **Project Validation**: Added required validation rules for `title` and `slug` to the `ProjectRequest` within the Laravel app to prevent incomplete data from reaching the database (satisfying TDD rules).
3. **Project Table Expansion**: We migrated the following V1 Portfolio fields to the `projects` table: `slug`, `excerpt`, `thumbnail`, `repo_url`, `live_url`, `is_featured`, `tech_stack` (JSON type), and `published_at`.

### TDD Outcomes
- Tests were successfully written and validated around Admin Middleware block/allow access methods, as well as Backpack's form validation requests. Make sure `$fillable` fields are updated on Eloquent Models (`Project.php`) when adding new columns to make traits work during Backpack updates.
