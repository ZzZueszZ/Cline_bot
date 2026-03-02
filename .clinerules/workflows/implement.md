# Workflow: Implement

**Trigger**: User says "implement [task-name]" or "thực hiện [task-name]"

## Steps

1. **Verify plan is approved**
   - Read `docs/tasks/{task-name}/implement_plan.md`
   - Check for `## STATUS: APPROVED` at the top
   - If not approved: tell user "Please review and approve `implement_plan.md` first."

2. **Follow the plan step by step**
   - Check off each item in "Implementation Steps" as you complete it
   - Do NOT skip steps or reorder them

3. **Code standards to follow**
   - Always add `declare(strict_types=1);` at top of every PHP file
   - Use CakePHP ORM (never raw SQL)
   - Add type hints to all methods
   - Follow CakePHP 5 naming conventions
   - Validate at the Model layer

4. **After writing each file**, verify it by reading it back to confirm correctness

5. **Run migrations** (if any):
   ```bash
   make migrate
   ```

6. **Run tests**:
   ```bash
   make test
   ```
   - If tests fail: read the error, fix the code, run again
   - Do NOT proceed until all tests pass

7. **Run code style check**:
   ```bash
   make cs
   ```
   - If violations found: run `make cs-fix` and verify fixes

8. **Run tests again** to confirm no regressions after cs-fix

9. **Report to user**:
   - List all files created/modified
   - Confirm all tests pass
   - Confirm `phpcs` clean
   - Show any notes or decisions made during implementation

## Error Handling

- **Migration error**: Check SQL syntax, check if table already exists
- **Test failure**: Read the full error, trace back to the source, fix root cause
- **CS violation**: Prefer `make cs-fix` for auto-fixable issues; fix manually if not
- **CakePHP error**: Check that Table/Entity class names match the file names exactly
