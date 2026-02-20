<?php

namespace App\Services;

use App\Models\Candidate;
use App\Models\Job;

class MatchingService
{
    public function score(Job $job, Candidate $candidate): int
    {
        $score = 0;

        $jobSkillIds = $job->skills()->pluck('skills.id')->all();
        $candSkillIds = $candidate->skills()->pluck('skills.id')->all();
        if ($jobSkillIds) {
            $overlap = count(array_intersect($jobSkillIds, $candSkillIds));
            $score += min(60, $overlap * 10);
        }

        if ($candidate->preferred_job_type && $candidate->preferred_job_type === $job->job_type->value) {
            $score += 15;
        }

        if ($candidate->preferred_location && $job->job_location && strcasecmp($candidate->preferred_location, $job->job_location) === 0) {
            $score += 15;
        }

        if (!is_null($candidate->total_experience_years)) {
            $min = (int) ($job->experience_min_year ?? 0);
            $max = (int) ($job->experience_max_year ?? $min);
            if ($candidate->total_experience_years >= $min) {
                $score += 10;
            }
            if ($candidate->total_experience_years >= $max) {
                $score += 5;
            }
        }

        return max(0, min(100, $score));
    }
}

