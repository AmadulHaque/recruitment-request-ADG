# API Examples

## Auth

- Company register

Request:
POST /api/auth/company/register

Body:
{
  "name": "Acme HR",
  "email": "company@example.com",
  "password": "password",
  "company_name": "Acme Inc.",
  "website": "https://acme.test",
  "location": "Remote"
}

Response 201:
{
  "success": true,
  "token": "token...",
  "user": { "id": 2, "name": "Acme HR", "email": "company@example.com", "role": "company" },
  "company": { "id": 1, "company_name": "Acme Inc." }
}

- Login (company / candidate): POST /api/auth/company/login or /api/auth/candidate/login

## Company Jobs

- Create job

POST /api/company/jobs
Authorization: Bearer TOKEN

Body:
{
  "job_title": "Laravel Developer",
  "job_category": "Engineering",
  "job_type": "remote",
  "vacancy_count": 2,
  "salary_min": 4000,
  "salary_max": 6000,
  "skills": ["PHP", "Laravel"],
  "urgency": "medium",
  "status": "active"
}

Response 200:
{
  "data": {
    "id": 1,
    "job_title": "Laravel Developer",
    "job_type": "remote",
    "skills": ["PHP","Laravel"],
    "status": "active"
  }
}

- Applicants with matching score

GET /api/company/jobs/{id}/applicants

Response 200:
{
  "data": [
    {
      "application": { "id": 1, "application_status": "applied" },
      "candidate": { "id": 1, "user_id": 3, "headline": "Full-Stack Developer", "skills": ["PHP","Laravel","Vue.js"] },
      "matching_score": 85
    }
  ],
  "meta": { "current_page": 1, "last_page": 1, "total": 1 }
}

## Candidate Profile

- Get profile
GET /api/candidate/profile

- Update profile
PUT /api/candidate/profile

Body:
{
  "headline": "Full-Stack Developer",
  "preferred_job_type": "remote",
  "preferred_location": "Remote",
  "skills": ["PHP", "Laravel", "Vue.js"]
}

## Applications

- Apply to job
POST /api/candidate/apply/{job}

- Update application status (admin/company)
PATCH /api/admin/applications/{application}/status
Body: { "application_status": "under_review" }
