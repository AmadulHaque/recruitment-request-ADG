<?php

namespace App\Services;

use App\Models\Candidate;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CandidateProfileService
{
    public function upsert(User $user, array $data): Candidate
    {
        return DB::transaction(function () use ($user, $data) {
            $candidate = Candidate::updateOrCreate(
                ['user_id' => $user->id],
                collect($data)->except(['skills','profile_photo','cv_file'])->toArray()
            );

            if (isset($data['skills'])) {
                $skillIds = $this->resolveSkills($data['skills']);
                $candidate->skills()->sync($skillIds);
            }

            if (isset($data['profile_photo'])) {
                $candidate->profile_photo = $data['profile_photo']->store('profile_photos', 'public');
            }

            // Handle CV file upload
            if (isset($data['cv_file'])) {
                $candidate->cv_file = $data['cv_file']->store('cv_files', 'public');
            }   
            $candidate->save();
            return $candidate;
        });
    }

    public function completeness(Candidate $candidate): int
    {
        $fields = [
            'headline',
            'expected_salary_min',
            'expected_salary_max',
            'preferred_job_type',
            'preferred_location',
            'total_experience_years',
            'availability',
            'availability_weeks',
            'about_me',
            'profile_photo',
            'cv_file',
        ];

        $filled = 0;
        foreach ($fields as $field) {
            if (!empty($candidate->{$field})) {
                $filled++;
            }
        }
        // skills, educations, work experiences add weight
        if ($candidate->skills()->exists()) {
            $filled++;
        }
        if ($candidate->educations()->exists()) {
            $filled++;
        }
        if ($candidate->workExperiences()->exists()) {
            $filled++;
        }
        $total = count($fields) + 3;
        return (int) floor(($filled / $total) * 100);
    }

    protected function resolveSkills(array $skills): array
    {
        $ids = [];
        foreach ($skills as $name) {
            $ids[] = Skill::firstOrCreate(['name' => $name])->id;
        }
        return $ids;
    }
}

