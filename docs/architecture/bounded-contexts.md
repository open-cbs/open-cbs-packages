# Bounded Contexts - Modular Monolith

The system is divided into strict Bounded Contexts to ensure modularity and high cohesion.

```mermaid
graph TB
    subgraph "Core Domain"
        CIF[Customer Information (CIF)]
        ACC[Account Management]
        LNS[Loan Management]
        DPS[Deposit Management]
        GL[General Ledger (Accounting)]
    end

    subgraph "Supporting Domain"
        USR[User & Auth]
        BRN[Branch Management]
        PRD[Product Factory]
        COL[Collateral Management]
    end

    subgraph "Generic Domain"
        NOT[Notification Service]
        DOC[Document Management]
        AUD[Audit Trail]
    end

    CIF --> ACC
    ACC --> GL
    LNS --> ACC
    LNS --> GL
    DPS --> ACC
    DPS --> GL
    
    USR --> AUD
    BRN --> GL
```

## 1. CIF (Customer Information File)
**Responsibility**: Managing customer identity, KYC, risk profiling, and documents.
- **Key Models**: `Customer`, `KycProfile`, `Nominee`.
- **Package**: `packages/open-cbs/cbs-cif`

## 2. General Ledger (Accounting)
**Responsibility**: The financial brain. Double-entry bookkeeping, Chart of Accounts, balancing.
- **Key Models**: `LedgerAccount`, `JournalEntry`, `FiscalPeriod`.
- **Package**: `packages/open-cbs/cbs-accounting`

## 3. Account Management
**Responsibility**: Managing CASA (Current/Savings) accounts, balances, and operational states.
- **Key Models**: `Account`, `Transaction`, `Hold`, `Lien`.
- **Package**: `packages/open-cbs/cbs-accounts`

## 4. Loan Management
**Responsibility**: Loan origination, scheduling, repayment, classification, and provisioning.
- **Key Models**: `LoanAccount`, `RepaymentSchedule`, `Arrear`.
- **Package**: `packages/open-cbs/cbs-loans`

## 5. Deposit Management
**Responsibility**: Term deposits (FDR), recurring deposits (DPS), interest capitalization.
- **Key Models**: `TermDeposit`, `InterestSchedule`.
- **Package**: `packages/open-cbs/cbs-deposits`

## 6. Product Factory
**Responsibility**: Defining parameters for liability and asset products (Interest rates, limits).
- **Key Models**: `Product`, `InterestRateChart`.
- **Package**: `packages/open-cbs/cbs-products`

## 7. Organization Kernel
**Responsibility**: Users, Roles, Branches, Currencies.
- **Packages**: 
    - `packages/open-cbs/cbs-users`
    - `packages/open-cbs/cbs-branches`
    - `packages/open-cbs/cbs-currencies`
