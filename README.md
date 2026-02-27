## Centralized Logging Service

### Overview
As systems grow, logs become scattered across services, containers, and servers. Important failures get buried, formats differ, and alerting is inconsistent. This project introduces a small centralized logging service that any application can call with a simple HTTP request. The service handles routing, storage, and alerts, keeping client applications clean.

---

### The Problem

In distributed systems, file based logging breaks down:

- Logs spread across containers and machines
- No consistent structure
- Critical errors missed
- No automatic alerts
- Debugging lacks context

The challenge was to keep client logging simple while enabling scalable routing and alerting.

---

### What the Service Does

- Accept logs via HTTP from any application
- Route logs based on severity
- Separate logs by application
- Store logs in scalable storage such as S3
- Send alerts for critical issues
- Preserve structured context for debugging

---

### Severity Model

Higher severity triggers all lower level handlers.

| Level     | Behavior |
|----------|----------|
| debug    | stored for diagnostics |
| info     | stored for visibility |
| warning  | flagged for review |
| error    | may trigger alerts |
| critical | sent to all channels |

---

### Request Payload

~~~json
 {
  "app": "payment-service",
  "env": "production",
  "severity": "critical",
  "message": "Payment failed for order #12345 due to insufficient funds",
  "context": {
    "user_id": 9876,
    "order_id": 12345,
    "payment_method": "credit_card",
    "attempts": 2
  },
  "trace": "PaymentController@process -> PaymentGateway@charge"
}
~~~

**Fields**

- app — required, application name
- env — optional, defaults to production
- severity — required, routing level
- message — required, description
- context — optional, structured data
- trace — optional, error details

---

### Before vs After

**Before**  
Scattered logs, no alerts, inconsistent formats.

**After**  
Centralized ingestion, severity based routing, structured logs, faster debugging.

---

### Why It Matters

Distributed systems require intentional observability. This service shows how a small, focused tool can improve reliability and debugging without increasing application complexity.