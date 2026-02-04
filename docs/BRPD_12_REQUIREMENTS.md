# Core Banking System (CBS)
## Bangladesh Bank BRPD Circular No. 12 (13 May 2024) – Version 2.0 Aligned Requirements Document

---

## 1. Document Control

### 1.1 Purpose
This document defines the **complete, mandatory, and regulator-aligned requirements** for designing, developing, implementing, and operating a **Core Banking System (CBS)** fully compliant with **Bangladesh Bank BRPD Circular No. 12 dated 13 May 2024 (Guidelines on Core Banking Solution – Features & Controls, Version 2.0)**.

This document shall be treated as a **binding requisition** from the Bank to internal developers or external vendors.

### 1.2 Regulatory Authority
- Bangladesh Bank (BB)
- Banking Regulation & Policy Department (BRPD)

### 1.3 Applicability
This CBS **must be used by all branches, divisions, delivery channels, and subsidiaries** of the Bank and shall function as the **single system of record**.

---

## 2. Regulatory Principles (As Mandated by BRPD 12/2024)

The CBS **MUST** ensure:

1. Real-time, online transaction processing
2. Centralized database with branch-wise logical segregation
3. Strong internal control and auditability
4. End-to-end traceability of all financial transactions
5. Maker–Checker–Approver enforcement
6. Data integrity, confidentiality, and availability
7. Business continuity and disaster recovery
8. Prevention of unauthorized access and fraud

Non-compliance shall be considered **regulatory violation**.

---

## 3. Mandatory Architectural Requirements

### 3.1 Core Architecture
- Centralized Core Banking Application
- Online real-time processing (no branch-level ledgers)
- Double-entry accounting engine
- Modular, service-oriented architecture

### 3.2 Ledger Principles (Mandatory)
- Every financial transaction must result in **balanced debit and credit entries**
- Ledger entries must be **immutable**
- Corrections must be posted only via **reversal or adjustment entries**
- No direct balance updates allowed

### 3.3 Branch Control
- Unique branch codes defined by Bangladesh Bank
- Branch-wise transaction ownership
- Centralized GL with branch-wise reporting

---

## 4. Core Functional Modules (As Required by BB)

### 4.1 Customer Information File (CIF)

CBS MUST support:
- Unique CIF ID per customer
- Individual, Joint, Corporate, Institutional customers
- National ID / Passport / Trade License capture
- KYC profile and risk grading
- Customer status: Active, Inactive, Dormant, Closed
- Blacklist / Watchlist tagging
- FATCA & CRS indicators
- Customer-to-account relationship mapping

---

### 4.2 Account Management

#### 4.2.1 Deposit Accounts
- Savings
- Current
- Fixed Deposit
- Recurring Deposit

Features:
- Multi-currency
- Interest calculation rules
- Minimum balance enforcement
- Dormancy and reactivation
- Account freezing and lien marking

#### 4.2.2 Loan & Advance Accounts
- Term Loan
- Continuous Loan
- Demand Loan
- Overdraft

Mandatory:
- Sanction tracking
- Disbursement control
- Repayment schedules
- Classification (SMA, Substandard, Doubtful, Bad/Loss)
- Provisioning rules as per BB

---

### 4.3 Transaction Processing (Real-Time)

CBS MUST support:
- Cash deposit & withdrawal
- Account-to-account transfer
- Inter-branch transfer
- Standing instructions
- Bulk transactions
- Transaction reversals with approval

Controls:
- Transaction limits
- Velocity checks
- Exception handling

---

### 4.4 General Ledger (GL)

Mandatory features:
- BB-aligned Chart of Accounts
- Automatic posting from sub-ledgers
- Branch-wise GL
- Currency-wise GL
- Daily GL balancing

---

### 4.5 Interest, Charges & Fees

CBS MUST:
- Calculate interest daily
- Accrue interest automatically
- Post interest periodically
- Support tiered interest rates
- Auto-apply fees and charges

---

### 4.6 End of Day (EOD) & Periodic Processing

Mandatory processes:
- EOD transaction cutoff
- Interest accrual
- GL balancing validation
- Exception reporting
- EOM & EOY rollover

EOD must not complete unless all balances are reconciled.

---

## 5. Internal Control & Audit (Critical)

### 5.1 Maker–Checker–Approver

CBS MUST enforce:
- Role segregation
- Dual control for sensitive operations
- No self-approval

### 5.2 Audit Trail

CBS MUST:
- Log all user activities
- Capture before/after values
- Store timestamp, user ID, IP, branch
- Retain logs for minimum BB-prescribed period

Logs must be **tamper-proof**.

---

## 6. Security Requirements (As per BB ICT Guidelines)

### 6.1 Access Control
- Role-based access control (RBAC)
- Branch-wise access restriction
- Time-based access control

### 6.2 Authentication
- Strong password policy
- Multi-factor authentication
- Session timeout and lockout

### 6.3 Data Security
- Encryption at rest
- Encryption in transit
- Database access restriction

---

## 7. Compliance & Monitoring

### 7.1 AML / CFT
- Transaction monitoring
- Threshold-based alerts
- STR/SAR generation support

### 7.2 Regulatory Reporting

CBS MUST generate:
- Daily position reports
- CRR / SLR reports
- Loan classification reports
- Deposit insurance reports
- Any ad-hoc BB report

---

## 8. Integration Requirements

CBS MUST integrate with:
- Bangladesh Bank reporting systems
- BEFTN
- RTGS
- NPSB
- Internet & Mobile Banking
- ATM & Card systems

Integration must be API-based and secure.

---

## 9. Availability, BCP & DR

### 9.1 Availability
- 24×7 operation
- No single point of failure

### 9.2 Disaster Recovery
- Real-time data replication
- DR site geographically separate
- Defined RPO & RTO as per BB

---

## 10. Performance & Scalability

- Real-time posting (<1 second)
- Support high concurrent users
- Horizontal scalability

---

## 11. Data Retention & Archival

- Online data as per BB requirement
- Historical data archival
- Retrieval without data loss

---

## 12. Testing & Certification

Mandatory testing:
- Functional testing
- Security testing
- UAT with business
- DR drill
- Audit simulation

---

## 13. Deliverables

- CBS application source code
- Database schema & documentation
- Security & control documents
- User manuals
- Regulatory compliance matrix

---

## 14. Acceptance Criteria (Regulator-Focused)

CBS shall be accepted only if:
1. All BB BRPD 12/2024 controls are implemented
2. Ledger balances are 100% accurate
3. Audit trails are complete
4. DR drill passes successfully
5. External audit signs off

---

## 15. Regulatory Declaration

This CBS is a **regulated banking system**. Any deviation from this document without Bangladesh Bank approval is strictly prohibited.


## 16. More Information 

[Open CBS Regulatory Guidelines](https://github.com/open-cbs/bd-cbs-regulatory-guidelines/blob/main/may132024brpd12e.pdf)