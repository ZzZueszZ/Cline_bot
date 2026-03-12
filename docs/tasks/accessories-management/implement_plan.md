# Implementation Plan: Accessories Management System

## Overview
This plan outlines the step-by-step implementation of the accessories management system for SurveillanceHub, following the established MVC patterns and integrating with the existing camera management system.

## Files to Create

### Database Layer
- `config/Migrations/20260312000000_CreateAccessoriesTable.php` — Database migration for accessories table
- `src/Model/Entity/Accessory.php` — Entity class for accessories
- `src/Model/Table/AccessoriesTable.php` — Table class with relationships and validation

### Controller Layer
- `src/Controller/AccessoriesController.php` — Full CRUD operations for accessories

### View Layer
- `templates/Accessories/index.php` — List all accessories with filtering
- `templates/Accessories/view.php` — View individual accessory details
- `templates/Accessories/add.php` — Form to add new accessories
- `templates/Accessories/edit.php` — Form to edit existing accessories

### Test Layer
- `tests/Fixture/AccessoriesFixture.php` — Test data fixture
- `tests/TestCase/Model/Table/AccessoriesTableTest.php` — Model tests
- `tests/TestCase/Controller/AccessoriesControllerTest.php` — Controller tests

## Files to Modify

### Existing Models
- `src/Model/Table/CamerasTable.php` — Add hasMany relationship to accessories
- `src/Model/Entity/Camera.php` — Add accessible accessories property

### Existing Views
- `templates/Cameras/view.php` — Add section showing assigned accessories
- `templates/Cameras/add.php` — Add accessory assignment options
- `templates/Cameras/edit.php` — Add accessory assignment options
- `templates/layout/default.php` — Add accessories to navigation menu

## Implementation Steps

### Step 1: Database Schema
1. Create migration file with accessories table structure
2. Define foreign key relationship to cameras table
3. Add necessary indexes for performance
4. Run migration to create table

### Step 2: Model Layer
1. Create Accessory entity with proper accessible fields
2. Create AccessoriesTable with validation rules and relationships
3. Update CamerasTable to include hasMany relationship to accessories
4. Update Camera entity to include accessories property

### Step 3: Controller Implementation
1. Create AccessoriesController with standard CRUD actions
2. Implement proper authorization checks
3. Add validation and error handling
4. Include camera assignment logic

### Step 4: View Templates
1. Create accessories index page with list and search functionality
2. Create view page showing accessory details and related camera
3. Create add/edit forms with camera selection dropdown
4. Update camera views to show assigned accessories

### Step 5: Navigation Integration
1. Add accessories link to main navigation
2. Ensure consistent styling with existing interface
3. Add breadcrumbs for accessories pages

### Step 6: Testing
1. Create test fixtures with sample data
2. Write model tests for validation and relationships
3. Write controller tests for all CRUD operations
4. Test integration with camera system

## Testing Strategy

### Unit Tests
- Test accessory entity validation rules
- Test accessories table relationships
- Test camera-accessory relationship integrity

### Integration Tests
- Test accessories CRUD operations through controller
- Test camera view shows assigned accessories
- Test accessory assignment during camera creation/editing

### User Interface Tests
- Verify accessories appear in navigation
- Test accessory forms work correctly
- Test camera detail pages show accessories properly

## Validation Rules

### Required Fields
- `name`: String, max 100 characters, not empty
- `type`: String, max 50 characters, not empty
- `status`: Enum values (Available, In Use, Damaged, Retired)

### Optional Fields
- `description`: Text, max 500 characters
- `purchase_date`: Date, must be valid date
- `warranty_expiry`: Date, must be after purchase_date if provided
- `assigned_camera_id`: Foreign key, must reference existing camera

### Business Rules
- Accessories with status "In Use" must have assigned_camera_id
- Cannot delete accessories that are assigned to cameras
- Warranty expiry cannot be before purchase date

## Integration Points

### Camera-Accessory Relationship
- Each accessory belongs to zero or one camera
- Cameras can have multiple accessories
- When camera is deleted, associated accessories become "Available"

### Navigation Integration
- Add "Accessories" link to main navigation
- Maintain consistent styling with existing menu items
- Include proper active state highlighting

### Form Integration
- Camera add/edit forms include accessory assignment options
- Accessory forms include camera selection dropdown
- Proper validation messages for relationship constraints

## Success Criteria

### Functional Requirements
- [ ] Users can create, read, update, and delete accessories
- [ ] Accessories can be assigned to cameras
- [ ] Camera detail pages show assigned accessories
- [ ] Accessories appear in main navigation
- [ ] All validation rules are enforced

### Technical Requirements
- [ ] Database schema maintains referential integrity
- [ ] All tests pass
- [ ] Code follows existing patterns and conventions
- [ ] UI is consistent with existing application design
- [ ] Performance is acceptable for expected data volumes

### User Experience
- [ ] Navigation is intuitive and consistent
- [ ] Forms are easy to use and understand
- [ ] Error messages are clear and helpful
- [ ] Search and filtering work as expected
