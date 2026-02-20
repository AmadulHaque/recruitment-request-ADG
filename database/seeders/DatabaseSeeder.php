<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Company;
use App\Models\Candidate;
use App\Models\Job;
use App\Models\Skill;
use App\Models\JobApplication;
use App\Enums\UserRole;
use App\Enums\JobType;
use App\Enums\JobStatus;
use App\Enums\JobUrgency;
use App\Enums\ApplicationStatus;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => UserRole::ADMIN,
        ]);

        $companyUser = User::create([
            'name' => 'Acme HR',
            'email' => 'company@example.com',
            'password' => Hash::make('password'),
            'role' => UserRole::COMPANY,
        ]);
        $company = Company::create([
            'user_id' => $companyUser->id,
            'company_name' => 'Acme Inc.',
            'website' => 'https://acme.test',
            'location' => 'Remote',
        ]);

        $candidateUser = User::create([
            'name' => 'Jane Doe',
            'email' => 'candidate@example.com',
            'password' => Hash::make('password'),
            'role' => UserRole::CANDIDATE,
        ]);
        $candidate = Candidate::create([
            'user_id' => $candidateUser->id,
            'headline' => 'Full-Stack Developer',
            'preferred_job_type' => JobType::REMOTE->value,
            'preferred_location' => 'Remote',
            'total_experience_years' => 5,
        ]);

        $php = Skill::firstOrCreate(['name' => 'PHP']);
        $laravel = Skill::firstOrCreate(['name' => 'Laravel']);
        $vue = Skill::firstOrCreate(['name' => 'Vue.js']);
        $candidate->skills()->sync([$php->id, $laravel->id, $vue->id]);

        $job = Job::create([
            'company_id' => $company->id,
            'job_title' => 'Laravel Developer',
            'job_category' => 'Engineering',
            'job_type' => JobType::REMOTE,
            'vacancy_count' => 2,
            'salary_min' => 4000,
            'salary_max' => 6000,
            'experience_min_year' => 3,
            'education_requirement' => 'BSc in Computer Science',
            'job_location' => 'Remote',
            'description' => 'Work on modern Laravel apps.',
            'benefits' => 'Health insurance, Remote stipend',
            'urgency' => JobUrgency::MEDIUM,
            'status' => JobStatus::ACTIVE,
        ]);
        $job->skills()->sync([$php->id, $laravel->id]);

        JobApplication::create([
            'job_id' => $job->id,
            'candidate_id' => $candidate->id,
            'application_status' => ApplicationStatus::APPLIED,
        ]);
    }
}
