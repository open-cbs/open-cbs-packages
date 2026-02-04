# AGENTS INITIAL STARTUP — CORE BANKING SOLUTION (OPEN SOURCE)

## 1. Project Overview

We are developing a **fully open-source Core Banking Solution (CBS)** designed for:

* Banks
* NBFIs
* MFIs
* FinTech institutions
* Payment service providers

The system must be:

* Modular
* Technology-portable
* API-first
* Event-driven
* Strongly documented
* Test-enforced
* Enterprise-grade scalable

Primary stack for V1:

* **Backend:** Laravel 12
* **Frontend:** Vue 3
* **Database:** PostgreSQL (preferred) / MySQL compatible
* **Queue:** Redis / RabbitMQ (pluggable)
* **Cache:** Redis
* **Search:** Meilisearch / Elasticsearch (optional abstraction)

---

## 2. Architectural Principles

Agents must strictly follow these architectural doctrines:

### 2.1 Modular Monolith (Package-Driven)

All separable banking domains MUST be developed as **independent Laravel Packages**.

Example:

```
/packages
    /Accounts
    /Customers
    /Loans
    /Deposits
    /GeneralLedger
    /Transactions
    /KYC
    /Payments
    /Cards
    /Branches
    /Users
    /Audit
    /Reports
    /Integrations
```

Each package must be:

* PSR-4 compliant
* Auto-discoverable
* Publishable config/migrations
* Independently testable
* Replaceable by microservice later

---

### 2.2 MVC Enforcement

Even inside packages, enforce MVC separation:

```
Domain Logic  → Actions
HTTP Layer    → Controllers
Data Layer    → Models / Repositories
Presentation  → Vue / API რესponses
```

No business logic in controllers.

---

### 2.3 Action-Driven Use Case Layer

Each business operation MUST be an **Action**.

Actions are:

* Invokable
* Single-responsibility
* Transactional boundary units
* Callable via HTTP / CLI / Queue / Events

Example:

```
OpenAccountAction
DisburseLoanAction
PostTransactionAction
AccrueInterestAction
FreezeAccountAction
```

Structure:

```
/Actions
    OpenAccountAction.php
```

Pattern:

```php
class OpenAccountAction
{
    public function __invoke(OpenAccountDTO $dto): Account
}
```

Rules:

* One action = one business outcome
* Actions may call other actions
* Must be unit testable
* Must emit domain events

---

### 2.4 Event-Driven Side Effects

All side effects must be evented.

Example flow:

```
OpenAccountAction
    → emits AccountOpenedEvent
        → KYCVerificationListener
        → WelcomeNotificationListener
        → AuditLogListener
        → LedgerInitializationListener
```

Never place side effects inside actions directly.

Use:

* Laravel Events
* Observers
* Domain Events (preferred abstraction)

---

### 2.5 Observer Usage

Observers handle model lifecycle hooks:

```
AccountObserver
TransactionObserver
LoanObserver
```

Use cases:

* Auto ledger posting
* Audit trails
* Balance recalculation
* Status propagation

---

### 2.6 Replaceability Principle

Architecture must allow migration to:

* Microservices
* Stored procedures
* SQL functions
* Event streaming platforms

Therefore:

* Avoid framework-locked logic
* Abstract repositories
* DTO-based action inputs
* No Eloquent leakage into domain contracts

---

## 3. API Architecture

System is **API-First**.

Consumers:

* First-party apps
* Mobile banking
* Agent banking
* ATM switch
* Payment gateways
* Third-party fintechs

Standards:

* REST (primary)
* GraphQL (optional later)
* Webhooks (event push)

Security layers:

* OAuth2 / Passport
* mTLS (planned)
* API keys (limited use)
* IP whitelisting

---

## 4. Documentation Requirements

All documentation must reside under:

```
/docs
```

Mandatory structure:

```
/docs
    /architecture
    /modules
    /actions
    /events
    /database
    /api
    /security
    /deployment
    /testing
    /diagrams
    /adr (architecture decision records)
```

Each module must include:

* Functional overview
* Data model
* Actions list
* Events emitted
* API endpoints
* Sequence diagrams
* Dependencies
* Extension points

---

## 5. Diagram Standards

Agents must generate diagrams using:

* Mermaid
* PlantUML
* Draw.io XML (optional)

Required diagrams:

* Context diagrams
* Container diagrams
* Component diagrams
* Sequence diagrams
* ERD
* Ledger posting flows
* Transaction lifecycles

Store in:

```
/docs/diagrams
```

---

## 6. Testing Strategy (Mandatory)

No feature is complete without tests.

Test layers:

### 6.1 Unit Tests

* Actions
* Services
* Calculations
* Interest engines

### 6.2 Feature Tests

* API endpoints
* Auth flows
* Posting flows

### 6.3 Integration Tests

* Ledger ↔ Accounts
* Loans ↔ GL
* Payments ↔ Transactions

### 6.4 Contract Tests

* Third-party APIs
* Webhooks

Coverage target:

```
Minimum: 80%
Critical finance modules: 95%+
```

---

## 7. Dependency Governance

Agents must document:

* Package dependencies
* Version constraints
* Upgrade risks
* Security implications

Use:

```
/docs/dependencies.md
```

---

## 8. Module Development Template

Every package must follow:

```
/PackageName
    /Actions
    /DTOs
    /Events
    /Listeners
    /Models
    /Observers
    /Policies
    /Repositories
    /Services
    /Database
        /Migrations
        /Seeders
    /Routes
    /Tests
    /Docs
```

---

## 9. Ledger & Accounting Integrity

All financial postings must:

* Be double-entry
* Be immutable
* Be reversible via contra entries
* Maintain audit trail
* Support back-dated posting

No balance should be stored without ledger backing.

---

## 10. Portability Strategy

To enable future migration:

| Layer        | Portability Rule         |
| ------------ | ------------------------ |
| Actions      | Framework agnostic logic |
| DTOs         | Pure PHP objects         |
| Repositories | Interface driven         |
| Events       | Domain named             |
| APIs         | OpenAPI documented       |

---

## 11. Agent Continuation Protocol

If the primary agent session is interrupted, the next agent MUST:

### Step 1 — Read State Files

```
AGENTS_INITIAL_STARTUP.md
PROJECT_ROADMAP.md
CURRENT_SPRINT.md
ARCHITECTURE_DECISIONS.md
```

### Step 2 — Identify Last Completed Artifact

Check:

* Last module touched
* Last action implemented
* Last diagram generated
* Last test written

### Step 3 — Resume From Nearest Incomplete Unit

Priority order:

1. Broken tests
2. Incomplete actions
3. Missing events
4. Undocumented modules
5. Missing diagrams

---

## 12. Progress Logging

Agents must log work in:

```
/docs/progress_logs/YYYY-MM-DD.md
```

Entry format:

```
Module:
Completed:
Pending:
Risks:
Next Steps:
```

---

## 13. Architecture Decision Records (ADR)

All major decisions must be recorded:

```
/docs/adr/ADR-XXXX-title.md
```

Examples:

* Why modular monolith first
* Why PostgreSQL
* Why action pattern
* Why event sourcing (if adopted)

---

## 14. MCP & Tooling Awareness

Agents must review connected MCP capabilities before starting:

* Diagram MCP
* Code generation MCP
* Test generation MCP
* Documentation MCP

Leverage tools but validate outputs.

---

## 15. Definition of Done (DoD)

A feature/module is ONLY complete when:

* Actions implemented
* Events wired
* Observers attached
* APIs exposed
* Docs written
* Diagrams added
* Tests passing
* Ledger impact validated

---

## 16. Immediate Next Execution Instruction

Agents should now:

1. Read full requirements
2. Generate system context diagram
3. Define bounded contexts
4. Scaffold base package structure
5. Establish shared kernel modules:

   * Users
   * Branches
   * Currencies
   * GL Chart of Accounts

Do NOT implement business logic yet.

Focus on architecture foundation first.

---
put packages in packages folder with under vendor wovosoft .as packages/wovosoft/package_name
