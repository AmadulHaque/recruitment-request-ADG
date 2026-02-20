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
                collect($data)->except(['skills'])->toArray()
            );

            if (isset($data['skills'])) {
                $skillIds = $this->resolveSkills($data['skills']);
                $candidate->skills()->sync($skillIds);
            }

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

