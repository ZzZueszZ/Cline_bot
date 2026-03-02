# Workflow: Generate Prompt

**Trigger**: User says "gen prompt for [task-name]" or "tạo prompt cho [task-name]"

## Steps

1. **Read task description**
   - File: `docs/tasks/{task-name}/task_description.md`
   - Understand: what, why, requirements, constraints

2. **Analyze existing codebase**
   - Read relevant files in `src/`, `config/`, `tests/`
   - Note existing patterns (naming, validation style, test structure)
   - Identify files that will be affected

3. **Create prompt file** at `docs/tasks/{task-name}/task_prompt.md`

   Use this structure:
   ```markdown
   ## STATUS: DRAFT

   # Task Prompt: {task-name}

   ## Task ID
   `TASK-XXX`

   ## Context
   ### Existing Codebase
   [Paste relevant code snippets]

   ### Technology Stack
   - CakePHP 5.x, PHP 8.3+, MySQL 8.0, Docker

   ## Objective
   [One clear paragraph: what to build and why]

   ## Constraints
   - CakePHP 5 conventions
   - PHP 8.3+ strict types
   - PSR-12 code style
   - No raw SQL
   - [task-specific constraints]

   ## Expected Output
   ### Files to Create
   - [list each file]
   ### Files to Modify
   - [list each file + what changes]

   ## Acceptance Criteria
   - [ ] [testable criterion]

   ## Out of Scope
   - [what NOT to build]
   ```

4. **Tell the user**: "Prompt created at `docs/tasks/{task-name}/task_prompt.md`. Please review and add `## STATUS: APPROVED` when ready."
