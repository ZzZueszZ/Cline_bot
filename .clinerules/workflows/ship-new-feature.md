---
description: "End-to-end workflow for shipping a new feature: from raw task description to a pull request. Includes context window monitoring and task handoff to ensure seamless multi-session delivery."
author: "Cline Team"
version: "2.0"
category: "Development"
tags: ["feature", "pr", "planning", "implementation", "workflow", "context-management", "new-task"]
globs: ["*.*"]
---

<task name="Ship New Feature">

<task_objective>
Takes a raw task description as input and guides the developer through normalizing the requirements into a clear prompt, breaking it into a detailed implementation plan, implementing the code changes with continuous context window monitoring, and finally producing a pull request with a complete commit message via the `pr-review-cline` workflow. If the context window exceeds 50% during implementation, the workflow automatically initiates a `new_task` handoff so work continues seamlessly in a fresh session.
</task_objective>

<detailed_sequence_steps>
# Ship New Feature Process - Detailed Sequence of Steps

---

## ⚠️ MANDATORY: Context Window Monitoring

**You MUST monitor context window usage throughout this entire workflow.**

At the start of every major step, check the `# Context Window Usage` value in environment details.

| Usage | Action Required |
|---|---|
| < 50% | Continue normally |
| ≥ 50% | Complete current logical step, then initiate a `new_task` handoff |

**When context window ≥ 50%, you MUST:**
1. Complete the current atomic step (do not stop mid-file or mid-thought).
2. Use `ask_followup_question` to offer a handoff:
   > "I've completed [specific accomplishment]. The context window is at [X]%. Would you like me to create a new task to continue with [remaining work]?"
   > Options: `["Yes, create a new task", "No, continue in this session"]`
3. If approved, use the `new_task` tool with the **Full Handoff Context Template** defined at the end of this workflow.

---

## Step 0: Plan Mode — Task Decomposition (if in PLAN MODE)

If starting in Plan Mode, you **MUST** perform upfront decomposition before any implementation.

1. Analyze the full scope of the feature request.
2. Identify all major components, dependencies, and risks.
3. Break the work into discrete, ordered subtasks (aim for 15–30 min each).
4. Present the task roadmap to the user using a Mermaid diagram:

   ```mermaid
   graph TD
       A[Ship New Feature] --> B[Step 1: Gather & Normalize]
       B --> C[Step 2: Implementation Plan]
       C --> D[Step 3: Implement Code]
       D --> E[Step 4: Create Pull Request]
       D --> F{Context ≥ 50%?}
       F -->|Yes| G[new_task Handoff]
       G --> D
   ```

5. Use `ask_followup_question` to confirm the plan and which subtask to begin with.
6. Ask the user to switch to Act Mode when ready to implement.

---

## Step 1: Gather & Normalize Task Description

1. Use `ask_followup_question` to collect the raw task description from the user:
   > "Please describe the feature you want to ship. Include any relevant context, acceptance criteria, or links to tickets/designs."

2. Analyze the raw input and identify ambiguities or missing context:
   - What problem does this feature solve?
   - Who is the intended user or system?
   - What are the explicit acceptance criteria?
   - Are there any constraints (performance, security, compatibility)?
   - Are there dependencies on other features or services?

3. Use `ask_followup_question` to resolve any identified ambiguities, one at a time.

4. Produce a **Normalized Prompt** — a structured, unambiguous feature specification:

   ```markdown
   ## Feature: <Feature Name>

   ### Problem Statement
   <Clear description of the problem being solved>

   ### Acceptance Criteria
   - [ ] <Criterion 1>
   - [ ] <Criterion 2>
   - [ ] ...

   ### Constraints & Notes
   - <Any technical constraints, edge cases, or out-of-scope items>

   ### Dependencies
   - <Any related features, services, or external systems>
   ```

5. Present the Normalized Prompt to the user and use `ask_followup_question` to confirm it is accurate before proceeding.

> **📊 Context Check:** Verify context window usage before proceeding to Step 2. If ≥ 50%, initiate a `new_task` handoff now.

---

## Step 2: Create Detailed Implementation Plan

1. Analyze the codebase relevant to the feature:
   - Use `list_files` to explore the project structure.
   - Use `read_file` to understand existing patterns, interfaces, and conventions.
   - Use `search_files` to locate related code (existing similar features, shared utilities).

2. Formulate a **Detailed Implementation Plan** that breaks the feature into atomic, ordered steps:

   ```markdown
   ## Implementation Plan: <Feature Name>

   ### Files to Create
   - `path/to/new-file.ts` — <Purpose>

   ### Files to Modify
   - `path/to/existing-file.ts` — <What changes and why>

   ### Implementation Steps
   1. <Step 1: e.g., Add data model / schema>
   2. <Step 2: e.g., Implement service/business logic>
   3. <Step 3: e.g., Expose API endpoint or UI component>
   4. <Step 4: e.g., Write unit/integration tests>
   5. <Step 5: e.g., Update documentation or configuration>

   ### Testing Strategy
   - <How to verify each step is correct>

   ### Risks & Mitigations
   - <Risk>: <Mitigation approach>
   ```

3. Present the Detailed Implementation Plan to the user and use `ask_followup_question` to confirm or adjust before proceeding.

> **📊 Context Check:** Verify context window usage before proceeding to Step 3. If ≥ 50%, initiate a `new_task` handoff now, carrying forward the Normalized Prompt and Implementation Plan.

---

## Step 3: Implement Code Changes

Execute the implementation plan **one atomic step at a time**, checking context window usage before each step.

### For each implementation step:

1. **Check context window usage first.** If ≥ 50%, stop and initiate handoff before starting this step.

2. Use `read_file` to examine the target file before editing.

3. Use `write_to_file` to create new files, or `replace_in_file` for targeted edits.

4. Verify the change is correct before moving to the next step.

5. Document the completed step in your running **Code Changes Summary** (maintained in memory and passed forward in any handoff).

### After all implementation steps are complete:

1. Perform a self-review:
   - Do the changes satisfy all acceptance criteria from the Normalized Prompt?
   - Are edge cases handled?
   - Is error handling in place?
   - Does the code follow existing conventions and patterns?
   - Are tests written and passing? (Use `execute_command` to run the test suite.)

2. Share a complete summary with the user:

   ```markdown
   ## Code Changes Summary

   ### Files Created
   - `path/to/new-file.ts`

   ### Files Modified
   - `path/to/existing-file.ts` — <Summary of changes>

   ### Tests
   - <Test results or confirmation tests pass>
   ```

3. Use `ask_followup_question` to confirm the implementation is ready to proceed to PR creation.

> **📊 Context Check:** Verify context window usage before proceeding to Step 4. If ≥ 50%, initiate a `new_task` handoff, carrying forward the full Code Changes Summary and the instruction to begin Step 4.

---

## Step 4: Create Pull Request via PR Review Workflow

1. Trigger the `pr-review-cline` workflow, which will produce:
   - A structured commit message following Conventional Commits format.
   - A PR description with context, changes, and testing notes.

2. Confirm the branch is up to date and all changes are staged:
   ```bash
   git status
   git diff --stat
   ```

3. Use `execute_command` to commit all changes:
   ```bash
   git add -A
   git commit -m "<commit message from pr-review>"
   ```

4. Use `execute_command` to push the branch:
   ```bash
   git push origin <branch-name>
   ```

5. Use `execute_command` or provide instructions to open a PR on the remote:
   ```bash
   # GitHub CLI example
   gh pr create --title "<PR title>" --body "<PR description>"
   ```

6. Use `attempt_completion` to present the final result:
   - Link to the created PR (if available).
   - Summary of the full workflow journey:
     - Normalized prompt.
     - Implementation plan.
     - Code changes summary.
     - Commit message and PR description.

---

## 🔄 Full Handoff Context Template

Use this template whenever initiating a `new_task` handoff during this workflow.

```xml
<new_task>
<context>
# Task Continuation: Ship New Feature — <Feature Name>

## Workflow Status
- Current step: <Step X: e.g., "Step 3 — Implementing code, 3 of 5 steps complete">
- Reason for handoff: Context window reached [X]%

## Normalized Prompt
<Paste the full Normalized Prompt produced in Step 1>

## Implementation Plan
<Paste the full Detailed Implementation Plan produced in Step 2>

## Completed Work
- [List every file created or modified so far, with a brief description of each change]
- [Include any important decisions made during implementation]
- [Note any patterns or conventions adopted]

## Current State
- [Describe the current runnable/compilable state of the codebase]
- [Note any tests passing or failing]
- [Note any running processes or environment requirements]

## Remaining Steps
- [ ] <Next atomic implementation step>
- [ ] <Subsequent step>
- [ ] Step 4: Create Pull Request via pr-review-cline workflow

## Reference Information
- Architecture patterns in use: <e.g., "Repository pattern in src/repositories/">
- Test conventions: <e.g., "Tests in __tests__/ using Jest">
- Commit convention: Conventional Commits
- Any user preferences noted: <e.g., "User prefers functional components over class components">

## Next Action
Please continue by [specific next atomic step — e.g., "implementing the login endpoint in src/routes/auth.ts following the pattern established in src/routes/register.ts"].
</context>
</new_task>
```

### Handoff Best Practices

- **Maintain continuity:** Use the same terminology, naming conventions, and architectural approach across sessions.
- **Be specific:** Reference exact file paths and function names, not vague descriptions.
- **Prioritize:** List remaining steps in order of execution, not importance.
- **Document assumptions:** State any assumptions made so the next session does not re-derive them.
- **Optimize for immediate resumption:** The next session must be able to start coding within the first two messages.

</detailed_sequence_steps>

</task>
<task_progress>
- [x] Read new-task-automation.md
- [x] Merge context window monitoring into ship-new-feature.md
- [x] Add Plan Mode decomposition step (Step 0)
- [x] Add context checks between each major step
- [x] Integrate per-step context check into implementation loop
- [x] Add Full Handoff Context Template with all required fields
- [x] Add handoff best practices section
- [x] Update frontmatter version and description
</task_progress>