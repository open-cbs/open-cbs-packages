# System Context Diagram - Open Source Core Banking Solution

This diagram depicts the high-level context of the Core Banking System (CBS) and its interactions with external actors and systems.

```mermaid
C4Context
    title System Context Diagram for Open Source Core Banking Solution

    Enterprise_Boundary(b0, "Bank Enterprise") {
        System(cbs, "Core Banking System", "Monolithic Modular Laravel System", "Manages accounts, transactions, loans, and ledgers.")
        
        System_Ext(internet_banking, "Internet Banking", "Retail/Corporate Banking Portal", "Allows customers to manage accounts online.")
        System_Ext(mobile_app, "Mobile App", "iOS/Android App", "Allows customers to manage accounts via mobile.")
        System_Ext(agent_banking, "Agent Banking App", "External Agent Interface", "Allows agents to perform banking on behalf of customers.")
    }

    Person(customer, "Customer", "Bank Account Holder")
    Person(staff, "Bank Staff", "Branch Manager / Teller / Operations")
    Person(auditor, "Auditor", "Internal/External Auditor")

    System_Ext(bb_rtgs, "Bangladesh Bank RTGS", "Real-Time Gross Settlement", "High value inter-bank transfers.")
    System_Ext(bb_npsb, "NPSB Switch", "National Payment Switch Bangladesh", "ATM/POS transactions.")
    System_Ext(bb_beftn, "BEFTN Network", "Electronic Funds Transfer", "Batch electronic fund transfers.")
    System_Ext(bb_reporting, "Regulatory Reporting System", "Central Bank Reporting Portal", "Receives regulatory reports (CRR, SLR, CL).")
    System_Ext(credit_bureau, "CIB (Credit Bureau)", "Credit Information Bureau", "Credit check services.")

    Rel(customer, internet_banking, "Uses")
    Rel(customer, mobile_app, "Uses")
    Rel(staff, cbs, "Operates", "HTTPS/Internal Network")
    Rel(auditor, cbs, "Audits", "Read-only Access")

    Rel(internet_banking, cbs, "API Calls", "REST/JSON")
    Rel(mobile_app, cbs, "API Calls", "REST/JSON")
    Rel(agent_banking, cbs, "API Calls", "REST/JSON")

    Rel(cbs, bb_rtgs, "Sends/Receives Transfers", "ISO 20022 / MT")
    Rel(cbs, bb_npsb, "Authorizes Card Txns", "ISO 8583")
    Rel(cbs, bb_beftn, "Batched Transfers", "XML/CSV")
    Rel(cbs, bb_reporting, "Uploads Reports", "Secure FTP/API")
    Rel(cbs, credit_bureau, "Checks Credit Score", "API")
```

## Actors
1.  **Customer**: Uses digital channels to interact with the bank.
2.  **Bank Staff**: Uses the internal CBS UI to perform operations.
3.  **Auditor**: Inspects logs and reports for compliance.

## External Systems
1.  **National Payment Switches (RTGS, NPSB, BEFTN)**: Required for inter-bank connectivity.
2.  **Regulatory Body (Bangladesh Bank)**: Receives mandatory compliance reports.
3.  **Credit Bureau**: Source of truth for creditworthiness.
