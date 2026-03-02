# Workflow: Commit & Create PR

**Trigger**: User says "commit and PR [task-name]" or "tạo PR cho [task-name]"

## Pre-conditions
- All tests pass (`make test`)
- Code style clean (`make cs`)
- Implementation complete per `implement_plan.md` Definition of Done

## Steps

1. **Verify implementation is complete**
   - Read `docs/tasks/{task-name}/implement_plan.md`
   - Check all items in "Definition of Done" are completed
   - If not complete: tell user what remains

2. **Check current git status**
   ```bash
   git status
   git diff --stat
   ```

3. **Create feature branch** (if not already on one):
   ```bash
   git checkout -b feature/{task-name}
   ```
   Or for bug fixes:
   ```bash
   git checkout -b fix/{task-name}
   ```

4. **Stage all changes**:
   ```bash
   git add .
   ```

5. **Review staged changes**:
   ```bash
   git diff --cached --stat
   ```

6. **Commit** using conventional commit format:
   ```bash
   git commit -m "feat({scope}): {short description}

   {body: what was changed and why}

   Task: TASK-XXX"
   ```

   Commit type guide:
   - `feat` — new feature
   - `fix` — bug fix
   - `refactor` — code restructure without behavior change
   - `test` — adding/updating tests
   - `docs` — documentation only
   - `chore` — build/config changes

7. **Push branch**:
   ```bash
   git push origin feature/{task-name}
   ```

8. **Generate PR description** using `implement_plan.md` content:

   Fill in `docs/tasks/{task-name}/pr_description.md`:
   ```markdown
   ## Task ID
   TASK-XXX

   ## Summary
   [from implement_plan.md Summary]

   ## Type of Change
   - [x] ✨ Feature

   ## Changes Made
   ### Files Created
   [from implement_plan.md Files to Create]

   ### Files Modified
   [from implement_plan.md Files to Modify]

   ## Testing
   - [x] All existing tests pass
   - [x] New tests written and passing
   - [x] Code style check passes

   ## Definition of Done
   [copy from implement_plan.md with all boxes checked]
   ```

9. **Report to user**:
   - Branch name and commit hash
   - Link to push (or instruct to open PR on GitHub)
   - Summary of changes committed
