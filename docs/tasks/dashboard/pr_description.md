# feat: Surveillance Dashboard with Store Map and Camera Search

## Summary

Adds a **Surveillance Dashboard** (`/dashboard`) that gives operators a
single-pane-of-glass view over all stores and cameras in the system.

## What Changed

### New files
| File | Purpose |
|------|---------|
| `config/Migrations/20260201000000_CreateStoresAndLinkCameras.php` | Migration: creates `stores` table; adds nullable `store_id` FK to `cameras` |
| `src/Model/Table/StoresTable.php` | ORM table for stores with `hasMany Cameras` |
| `src/Model/Entity/Store.php` | Store entity with accessible fields |
| `src/Controller/DashboardController.php` | Dashboard index: stat counts, camera search/filter, store list for Leaflet map |
| `templates/Dashboard/index.php` | Dashboard UI: stat cards, camera table with live search, Leaflet map with store markers |
| `tests/Fixture/StoresFixture.php` | Test fixture – 2 stores |
| `tests/TestCase/Controller/DashboardControllerTest.php` | 14 integration tests (happy path, search, filter, edge cases) |

### Modified files
| File | Change |
|------|--------|
| `src/Model/Table/CamerasTable.php` | Added `belongsTo Stores` association |
| `tests/Fixture/CamerasFixture.php` | Added `store_id` column to fixture records |
| `tests/schema.sql` | Added `stores` table; added `store_id` FK column to `cameras` |
| `config/routes.php` | Added `/dashboard` → `Dashboard::index` route |
| `templates/layout/default.php` | Added 📡 Dashboard and 📷 Cameras nav links |

## Features

### Stat cards
- Total Stores / Total Cameras / Active Cameras / Inactive Cameras counts
  rendered as clickable cards at the top of the page.

### Camera table with search + filter
- `?q=` – searches camera name and IP address (LIKE, case-insensitive)
- `?status=active|inactive` – filters by camera status flag
- `?store_id=<n>` – filters cameras belonging to a specific store
- Filters compose (e.g. `?q=lobby&status=inactive` works)
- Non-numeric `store_id` and unknown `status` values are ignored gracefully
- Empty-state message when no cameras match

### Leaflet.js map
- All stores with latitude/longitude are rendered as interactive markers
- Popup shows store name, address and a link to filter the camera table

## Testing

14 integration tests in `DashboardControllerTest`:
- `testIndexReturns200` – 200 response, page title present
- `testIndexSetsStatVariables` – all stat view-variables populated
- `testIndexStatCounts` – exact counts match fixture data (2 stores, 3 cameras, 2 active, 1 inactive)
- `testIndexRendersCameraTable` – all three fixture cameras appear
- `testIndexRendersStoreCards` – both fixture stores appear
- `testIndexSearchByName` – `?q=Front+Door` returns only that camera
- `testIndexSearchByIp` – `?q=192.168.1.11` returns only matching camera
- `testIndexFilterByStatusActive` – inactive camera hidden
- `testIndexFilterByStatusInactive` – active cameras hidden
- `testIndexFilterByStore` – store_id=2 returns only store-2 cameras
- `testIndexSearchNoResults` – empty-state message shown
- `testIndexIgnoresInvalidStoreId` – non-numeric store_id falls back gracefully
- `testIndexUnknownStatusShowsAll` – unknown status shows all cameras
- `testLayoutNavContainsDashboardLink` – nav link present in layout

## How to Review

```bash
# Start the stack
make up

# Run migrations
make migrate

# Run tests
make test

# Open the app
open http://localhost:8765/dashboard
```

## PR URL
https://github.com/ZzZueszZ/Cline_bot/pull/new/feature/dashboard
