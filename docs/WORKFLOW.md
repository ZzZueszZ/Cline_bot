# AI-Assisted Development Workflow

This project uses a structured, human-in-the-loop AI workflow. All AI workflow rules and steps live in `.clinerules/`.

---

## Overview

```
┌──────────┐    ┌──────────┐    ┌──────────┐    ┌──────────┐    ┌──────────┐    ┌──────────┐
│  STEP 1  │    │  STEP 2  │    │  STEP 3  │    │  STEP 4  │    │  STEP 5  │    │  STEP 6  │
│  Write   │───▶│   Gen    │───▶│  Review  │───▶│   Plan   │───▶│  Review  │───▶│ Implement│
│   Task   │    │  Prompt  │    │  Prompt  │    │  (AI)    │    │   Plan   │    │ Test     │
│  (Human) │    │  (AI)    │    │ (Human)  │    │          │    │ (Human)  │    │ Commit   │
└──────────┘    └──────────┘    └──────────┘    └──────────┘    └──────────┘    └──────────┘
```

---

## Quick Start

### 1. Create a new task
```bash
make new-task TASK=my-feature-name
# Copies template to docs/tasks/my-feature-name/task_description.md
```
Edit `task_description.md` to describe what you need.

### 2. Generate prompt (tell Cline)
```
gen prompt for my-feature-name
```

### 3. Review & approve prompt
Open `docs/tasks/my-feature-name/task_prompt.md`, review, then add:
```
## STATUS: APPROVED
```

### 4. Generate plan (tell Cline)
```
plan my-feature-name
```

### 5. Review & approve plan
Open `docs/tasks/my-feature-name/implement_plan.md`, review, then add:
```
## STATUS: APPROVED
```

### 6. Implement (tell Cline)
```
implement my-feature-name
```
Cline will code, run tests, fix issues, and report back.

### 7. Commit & PR (tell Cline)
```
commit and PR my-feature-name
```

---

## File Structure

```
myapp/
├── .clinerules/
│   ├── rules.md                    ← Coding standards & project rules
│   └── workflows/
│       ├── gen-prompt.md           ← How AI generates prompts
│       ├── plan.md                 ← How AI creates implementation plans
│       ├── implement.md            ← How AI implements code
│       └── commit-pr.md            ← How AI commits and prepares PRs
│
└── docs/
    └── tasks/
        ├── _TEMPLATE/              ← Copy these for each new task
        │   ├── task_description.md
        │   ├── task_prompt.md
        │   └── implement_plan.md
        │
        └── {task-name}/            ← One folder per task
            ├── task_description.md ← Human writes (Step 1)
            ├── task_prompt.md      ← AI generates, Human approves (Steps 2-3)
            └── implement_plan.md   ← AI generates, Human approves (Steps 4-5)
```

---

## Useful Make Commands

| Command | Description |
|---------|-------------|
| `make up` | Start Docker containers |
| `make down` | Stop containers |
| `make shell` | Open bash in app container |
| `make test` | Run all PHPUnit tests |
| `make cs` | Check code style (phpcs) |
| `make cs-fix` | Auto-fix code style |
| `make migrate` | Run database migrations |
| `make bake-all NAME=Xxx` | Generate Model + Controller + Templates |
| `make new-task TASK=name` | Create new task folder from template |

---

## Git Branch Strategy

- `master` — stable, production-ready
- `feature/{task-name}` — new features
- `fix/{task-name}` — bug fixes

All branches originate from `master` and are merged back via PR.

---

## Commit Convention

```
feat(scope): add user authentication
fix(scope): correct email validation rule
refactor(scope): extract service class
test(scope): add ArticlesTable unit tests
docs(scope): update workflow documentation
```

---

## Docker Services

| Service | URL | Description |
|---------|-----|-------------|
| App | http://localhost:8765 | CakePHP 5 application |
| DB  | localhost:3306 | MySQL 8.0 |

Credentials: `config/.env` (see `config/.env.example` for reference).
