### ROLE & GOAL

You are a **senior software architect and Laravel expert** building a **production-ready recruitment request and candidate tracking system** called **“Recruitment Request ADG”**.

Your task is to design and implement a **Laravel-based API backend**, an **admin & client web panel**, and a **candidate mobile-first experience**, following clean architecture, security best practices, and scalability principles.

---

## TECH STACK (MANDATORY)

* Backend: **Laravel 10+ (API-first)**
* Auth: **Laravel Sanctum**
* Admin & Client UI: **TailwindCSS using TailAdmin template**
* Mobile App Consumption: **REST API (JSON)**
* Notifications: **Laravel Notifications (DB + Push-ready)**
* Database: **MySQL**
* File Storage: **Laravel Storage (local + S3-ready abstraction)**

---

## SYSTEM OVERVIEW

The platform serves a **recruitment agency (ADG)** and consists of **three roles**:

### 1. Admin (ADG Manager)

* Manages clients, recruitment requests, candidates, and statuses
* Receives notifications when new requests are submitted
* Updates candidate application status

### 2. Client (Company)

* Logs in
* Submits recruitment requests
* Tracks their submitted requests

### 3. Candidate

* Logs in using **phone number or recruiter-provided ID**
* Views application status history
* Receives push notifications on status change

---

## MODULE 1: CLIENT RECRUITMENT REQUEST FLOW

### Authentication

* Clients authenticate using email + password
* API authentication via Sanctum

### Client Actions

* Create a **New Recruitment Request**
* View list of submitted requests
* View request details and status

### Recruitment Request Form Fields

* **Position**

  * Select from predefined list
  * Or enter custom position
* **Job Description**

  * Rich text input
  * Optional file attachment (PDF/DOC)
* **Critical Requirements**

  * Number of employees (integer)
  * Salary range (min / max)
  * Urgency level: Low | Medium | High
* **Client Contact Info**

  * Phone number
  * Email address

### On Submission

* Persist request
* Notify ADG Admin immediately

---

## MODULE 2: ADMIN PANEL (TAILADMIN)

### Admin Capabilities

* Dashboard with metrics:

  * Total requests
  * Requests by urgency
  * Active candidates
* Manage:

  * Clients
  * Recruitment requests
  * Candidates
* Assign candidates to requests
* Update candidate application statuses

### Admin UI Requirements

* Built using **TailAdmin + TailwindCSS**
* Clean, responsive layout
* Role-based access control

---

## MODULE 3: CANDIDATE STATUS TRACKING

### Candidate Authentication

* Login via:

  * Phone number (OTP-ready)
  * OR recruiter-assigned candidate ID

### Candidate Dashboard

* List of applications
* Each application shows current status

### Application Statuses (Enum)

* Resume received
* Under review by recruiter
* Sent to client
* Interview invitation (with date & time)
* Interview with client
* Rejection
* Offer

### Notifications

* Push notification triggered on **any status change**
* Notification stored in database
* API prepared for Firebase / OneSignal integration

---

## DATABASE REQUIREMENTS

Design normalized tables including but not limited to:

* users
* roles
* clients
* recruitment_requests
* request_attachments
* candidates
* candidate_applications
* application_status_history
* notifications

Use:

* UUIDs where appropriate
* Foreign keys
* Soft deletes for critical entities

---

## API REQUIREMENTS

* RESTful endpoints
* Versioned API (`/api/v1`)
* Proper validation using Form Requests
* Consistent JSON response structure
* Authorization via Policies

---

## ARCHITECTURE & QUALITY RULES

* Follow **Service / Repository pattern**
* No business logic in controllers
* Use Enums for statuses & urgency
* Use Laravel Events for notifications
* Write clean, extensible code
* Prepare system for mobile apps (iOS & Android)

---

## OUTPUT EXPECTATION

Produce:

1. Database schema & migrations
2. API endpoint list
3. Core models & relationships
4. Admin panel structure (TailAdmin pages)
5. Authentication & authorization flow
6. Notification flow design
7. Scalable, production-ready Laravel structure

Do NOT generate demo or placeholder logic.
Think like this will be deployed for a real recruitment agency.

---
