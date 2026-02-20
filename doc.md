Build a complete API-based Job Management System using:

- Laravel 10
- Filament (Admin Panel)
- MySQL
- Laravel Sanctum (API authentication)

System Overview:
This is a middleman recruitment platform between Companies and Candidates.

Roles:
1. Admin (Filament)
2. Company (API Auth)
3. Candidate (API Auth)

==================================
AUTHENTICATION
==================================
- Use Laravel Sanctum for API auth.
- Implement role-based middleware.
- Only admin can access Filament panel.

==================================
COMPANY MODULE
==================================
Company can:
- Register & Login
- Create job post
- Edit job post
- View own jobs
- Filter jobs
- View applicants
- Update job status

Job table fields:
- company_id
- job_title
- job_category
- job_type (full-time, part-time, contract, remote)
- vacancy_count
- salary_min
- salary_max
- salary_type
- experience_min_year
- experience_max_year
- education_requirement
- skills_required (separate pivot table)
- job_location
- application_deadline
- description
- benefits
- urgency (low, medium, high)
- status (draft, active, closed)
- attachments

==================================
CANDIDATE MODULE
==================================
Candidate can:
- Login
- Create / Update job profile
- Apply to job
- Track application status

Profile structure:
- headline
- expected_salary_min
- expected_salary_max
- preferred_job_type
- preferred_location
- total_experience_years
- availability
- about_me
- profile_photo
- cv_file

Related tables:
- education
- work_experience
- skills
- candidate_skills (pivot)

==================================
JOB APPLICATION MODULE
==================================
job_applications table:
- job_id
- candidate_id
- application_status
- interview_date
- interview_note
- final_status

Application lifecycle:
Applied
Under Review
Sent to Company
Interview Invited
Interview Completed
Hired / Rejected

==================================
ADMIN PANEL (Filament)
==================================
Admin can:
- Manage companies
- Manage candidates
- Manage jobs
- Manage applications
- Change application stage
- Schedule interview
- Add notes

==================================
ADVANCED FEATURE
==================================
- Implement profile completeness %
- Implement job-candidate matching score
- Use Eloquent relationships properly
- Follow SOLID principles
- Use service classes
- Use policies for authorization
- Use FormRequest for validation
- Use API Resources for responses
- Use proper indexing in database
- Follow clean architecture

Generate:
- Migrations
- Models with relationships
- Controllers
- FormRequests
- Policies
- Filament Resources
- API Routes
- Example JSON responses