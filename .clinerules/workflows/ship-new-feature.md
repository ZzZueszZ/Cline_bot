---
description: "End-to-end workflow for shipping a new feature: from raw task description to a pull request. Includes context window monitoring, authentication bypass strategy, and comprehensive testing with task handoff to ensure seamless multi-session delivery."
author: "Cline Team"
version: "2.1"
category: "Development"
tags: ["feature", "pr", "planning", "implementation", "workflow", "context-management", "new-task", "authentication-bypass", "testing"]
globs: ["*.*"]
---

<task name="Ship New Feature">

<task_objective>
Takes a raw task description as input and guides the developer through normalizing the requirements into a clear prompt, breaking it into a detailed implementation plan, implementing the code changes with continuous context window monitoring, and finally producing a pull request with a complete commit message via the `pr-review-cline` workflow. If the context window exceeds 50% during implementation, the workflow automatically initiates a `new_task` handoff so work continues seamlessly in a fresh session.
</task_objective>

<detailed_sequence_steps>
# Ship New Feature Process - Detailed Sequence of Steps

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
       C --> D[Step 3: Implementation & HITL Loop]
       D --> E{User Satisfied?}
       E -->|No| D
       E -->|Yes| F[Step 4: Autonomous Browser Verification]
       F --> G[Step 5: Create Pull Request]
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

5. Present the Normalized Prompt to the user and use ue`ask_followup_qstion` to confirm it is accurate before proceeding.

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
   - **Test Scenarios**: Define specific test cases for each acceptance criterion
   - **Test Cases**: Create detailed test cases with preconditions, steps, and expected results
   - **Test Environment**: Specify environment setup requirements for testing
   - **Test Data**: Define required test data and fixtures
   - **How to verify each step is correct**: Include validation checkpoints after each implementation step

   ### Authentication Bypass Strategy
   - **Bypass Method**: Define how authentication will be temporarily disabled for testing
   - **Scope**: Specify which authentication mechanisms will be bypassed
   - **Security Considerations**: Ensure bypass is only active in development/testing environments
   - **Rollback Plan**: Document how to restore proper authentication after testing

   ### Database Migration Strategy
   - **Migration Commands**: Specify the exact commands needed to migrate the database
   - **Test Data Setup**: Define any seed data or fixtures required for testing
   - **Rollback Plan**: Document how to revert database changes if needed

   ### Risks & Mitigations
   - <Risk>: <Mitigation approach>
   ```

3. Present the Detailed Implementation Plan to the user and use `ask_followup_question` to confirm or adjust before proceeding.

> **📊 Context Check:** Verify context window usage before proceeding to Step 3. If ≥ 50%, initiate a `new_task` handoff now, carrying forward the Normalized Prompt and Implementation Plan.

---

## Step 3: Implementation & Human-in-the-Loop Loop

### Objective
Implement the task and iterate through revisions until the User is fully satisfied.

### 3.1 Implement
Execute code writing or modifications strictly based on the Implementation Plan.

### 3.2 Review Request
Upon completing a logical unit or the entire task, use `ask_followup_question` to present:

- A summary of modified/created files.
- The core logic implemented.
- A specific inquiry: "Are you satisfied with this implementation? Is there anything that needs adjustment?"

### 3.3 The HITL Loop

**IF User provides feedback or requests changes:**
- Return to step 3.1, apply the requested changes, and repeat the review process.

**BREAK LOOP:**
- Only proceed to Step 4 if the User provides clear approval (e.g., "Approve", "OK", "Looks good", "Duyệt").

### 3.4 Context Window Monitoring
- **📊 Context Check:** Verify context window usage before each iteration.
- If usage is ≥ 50%, initiate a `new_task` handoff immediately to preserve history.
- When initiating handoff, include:
  - Current implementation status
  - Pending HITL feedback
  - Next steps to continue

> **📊 Context Check:** Verify context window usage before proceeding to Step 4. If ≥ 50%, initiate a `new_task` handoff, carrying forward the full Code Changes Summary and the instruction to begin Step 4.

---

## Step 4: Authentication Bypass & Comprehensive Testing

### Objective
Temporarily bypass authentication mechanisms and execute comprehensive browser-based testing according to the planned test cases.

### 4.1 Authentication Bypass Setup
1. **Identify Authentication Mechanisms**:
   - Locate authentication middleware, guards, or interceptors in the application
   - Identify session management, JWT tokens, or other auth patterns

2. **Implement Bypass Strategy**:
   - Create environment variable to enable/disable auth bypass (e.g., `SKIP_AUTH=true`)
   - Modify authentication middleware to skip verification when bypass is enabled
   - Ensure bypass only works in development/testing environments

3. **Verify Bypass Implementation**:
   - Test that authentication is properly bypassed
   - Confirm that normal authentication still works when bypass is disabled
   - Document the bypass mechanism for future reference

### 4.2 Database Migration
Use `execute_command` to run database migrations to ensure the test environment has the latest schema:
```bash
# Examples based on framework:
php bin/cake migrations migrate    # CakePHP
php artisan migrate               # Laravel
python manage.py migrate          # Django
npm run migrate                   # Custom migration script
./gradlew flywayMigrate           # Spring Boot with Flyway
rake db:migrate                   # Rails
```

### 4.3 Start Environment
Use `execute_command` to start the local development server with authentication bypass:
```bash
# Set environment variable for auth bypass
export SKIP_AUTH=true

# Examples based on framework:
npm run dev                    # React/Vue/Next.js
php artisan serve             # Laravel
python manage.py runserver    # Django
mvn spring-boot:run           # Spring Boot
bundle exec rails server      # Rails
```

### 4.4 Execute Planned Test Cases
1. **Test Case Execution**:
   - Launch browser using `browser_action` tool
   - Navigate to the feature's URL
   - Execute each planned test case systematically:
     - **Test Case 1**: [Description from implementation plan]
       - Preconditions: [Setup requirements]
       - Steps: [Detailed actions to perform]
       - Expected Result: [What should happen]
     - **Test Case 2**: [Description from implementation plan]
       - Preconditions: [Setup requirements]
       - Steps: [Detailed actions to perform]
       - Expected Result: [What should happen]
     - **Continue for all planned test cases...**

2. **Test Scenario Validation**:
   - Verify each acceptance criterion through corresponding test scenarios
   - Test edge cases and error conditions as defined in the test plan
   - Validate user workflows and interactions

### 4.5 Test Results Analysis
1. **Monitor Test Execution**:
   - Track success/failure of each test case
   - Capture screenshots for visual verification
   - Monitor browser console logs for errors or warnings

2. **Handle Test Failures**:
   - **IF FAIL**: Perform root cause analysis
     - Review test case steps for accuracy
     - Check application logs and error messages
     - Identify implementation gaps or bugs
     - Implement fixes using `replace_in_file`
     - Re-run failed test cases
   - **IF PASS**: Mark test case as successful and proceed to next case

3. **Test Coverage Verification**:
   - Ensure all planned test cases have been executed
   - Verify all acceptance criteria are validated
   - Confirm test coverage meets the defined requirements

### 4.6 Authentication Restoration
1. **Disable Bypass**:
   - Set environment variable to disable auth bypass: `export SKIP_AUTH=false`
   - Restart the development server if necessary
   - Verify authentication is properly restored

2. **Security Validation**:
   - Confirm authentication mechanisms are working correctly
   - Test that unauthorized access is properly blocked
   - Ensure no security vulnerabilities were introduced

### 4.7 Clean Up
- Terminate the local server.
- Close the browser sessions.

### 4.8 Create Pull Request via PR Review Workflow

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
     - Browser verification results.
     - Commit message and PR description.

---

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
