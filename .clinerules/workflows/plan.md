# Workflow: Plan & Break Task

**Trigger**: User says "plan [task-name]" or "lập kế hoạch cho [task-name]"

## Steps

1. **Verify prompt is approved**
   - Read `docs/tasks/{task-name}/task_prompt.md`
   - Check for `## STATUS: APPROVED` at the top
   - If not approved: tell user "Please review and approve `task_prompt.md` first."

2. **Analyze scope**
   - Re-read the approved prompt carefully
   - List all files to create and modify
   - Identify if database migrations are needed
   - Estimate test cases required

3. **Create implementation plan** at `docs/tasks/{task-name}/implement_plan.md`

   Use this structure:
   ```markdown
   ## STATUS: DRAFT

   # Implementation Plan: {task-name}

   ## Task ID
   `TASK-XXX`

   ## Summary
   [2-3 sentences: what will be built]

   ---

   ## Files to Create
   | File | Description |
   |------|-------------|
   | `src/...` | ... |

   ## Files to Modify
   | File | Changes |
   |------|---------|
   | `config/routes.php` | Add routes for ... |

   ---

   ## Database Migrations
   [SQL schema or "No migrations needed"]

   ---

   ## Implementation Steps
   - [ ] Step 1: ...
   - [ ] Step 2: ...

   ---

   ## Tests to Write
   ### XxxTableTest
   - `testXxx()` — description

   ### XxxControllerTest
   - `testXxx()` — description

   ---

   ## Commands to Run
   ```bash
   make migrate
   make test
   make cs
   ```

   ---

   ## Definition of Done
   - [ ] Migration runs without errors
   - [ ] All CRUD operations work
   - [ ] All tests pass
   - [ ] `phpcs` reports no violations
   - [ ] No regressions
   ```

4. **Tell the user**: "Plan created at `docs/tasks/{task-name}/implement_plan.md`. Please review and add `## STATUS: APPROVED` when ready to implement."
