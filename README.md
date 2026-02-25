# Event Management System API (Backend)

## Project Overview

This is the Laravel-based RESTful API backend for an Event Management System. It was developed collaboratively by a team of 13 developers to manage events, participants, and related statistics.

The project focuses on implementing secure authentication (Laravel Sanctum), structured JSON responses, complex Eloquent relationships, and adhering to a strict GitHub feature-branching workflow.

### Key Objectives Achieved

* [x] Developed a RESTful API using Laravel.
* [x] Implemented secure GitHub collaboration workflow with 13 contributors.
* [x] Utilized feature branching and peer-review pull requests.
* [x] Implemented standardized and structured JSON responses.
* [x] Successfully resolved merge conflicts in a high-activity environment.

---

## Getting Started / Installation Proof

To verify the functionality of this backend locally, follow these steps to set up the environment.

### Prerequisites

* PHP >= 8.1
* Composer
* MySQL or compatible database

### Setup Steps

1. **Clone the repository:**
```bash
git clone [YOUR REPOSITORY URL HERE]
cd [YOUR PROJECT FOLDER NAME]

```


2. **Install Dependencies:**
```bash
composer install

```


3. **Environment Setup:**
Copy the example env file and configure your database credentials.
```bash
cp .env.example .env
# Open .env and set DB_DATABASE, DB_USERNAME, DB_PASSWORD

```


4. **Generate Application Key:**
```bash
php artisan key:generate

```


5. **Run Migrations and Seeders (Crucial for Testing):**
We have included seeders to populate the database with dummy users and events for immediate testing.
```bash
php artisan migrate --seed

```


6. **Serve the Application:**
```bash
php artisan serve

```


The API will be available at `http://localhost:8000/api`.

---

## Proof of Functionality: Testing & Validation

We use a combination of automated tests and manual API testing to ensure system stability.

  **CREATE**
  <img src="https://res.cloudinary.com/dxgtvpyc3/image/upload/v1772025238/upload_xjhbmy.png" alt="Login API Proof" width="500">

  **UPDATE**
    <img src="https://res.cloudinary.com/dxgtvpyc3/image/upload/v1772025238/update_adt9cy.png" alt="Login API Proof" width="500">
  
  **DELETE**
  <img src="https://res.cloudinary.com/dxgtvpyc3/image/upload/v1772025238/delete_vukvxs.png" alt="Login API Proof" width="500">

#### Example Standardized Response Structure

All API endpoints return a standardized JSON structure for consistency, as required by the project objectives.

**Success Response Example (e.g., Fetching an Event):**

```json
{
    "message": "Event created successfully",
    "data": {
        "event_name": "Grandest Birthday Bash",
        "category": "ata siguro",
        "event_date": "2026-05-20",
        "location": "Manila Convention Center",
        "updated_at": "2026-02-25T13:22:55.000000Z",
        "created_at": "2026-02-25T13:22:55.000000Z",
        "id": 2
    }
}
```

**Error Response Example (e.g., Validation Error):**

```json
{
    "message": "Internal Server Error",
    "error": "The event date field must be a valid date."
}

```

---

## Feature Implementation Status

Based on the "System API Requirements" listed in the project brief.

**Authentication & User Management**

* [x] User registration (Sanctum)
* [x] User login and token generation
* [x] User logout (token revocation)

**Event Management (CRUD)**

* [x] Create new events
* [x] Read/List all events (Public listing)
* [x] View single event details
* [x] Update event details
* [x] Delete events

**Participant Management**

* [x] Register a participant to an event
* [x] Event capacity tracking (prevent registration if full)

**Advanced Features**

* [x] Search functionality (by title/description)
* [x] Filtering by date and category
* [X] Event statistics endpoint
* [x] API Resource Formatting (Standardized JSON)
* [x] Form Request Validation

---

## Collaboration & Workflow

This project successfully integrated the work of 13 developers using a structured GitHub workflow.

* **Main Branches:** `main` (production ready), `develop` (staging/integration).
* **Feature Branches:** Developers worked on isolated branches (e.g., `feature/dev1`, `feature/dev4`).


