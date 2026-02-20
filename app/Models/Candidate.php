<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'recruiter_id',
        'headline',
        'expected_salary_min',
        'expected_salary_max',
        'preferred_job_type',
        'preferred_location',
        'total_experience_years',
        'availability',
        'availability_weeks',
        'about_me',
        'cover_letter',
        'profile_photo',
        'cv_file',
        'has_consented',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'candidate_skill');
    }

    public function educations()
    {
        return $this->hasMany(Education::class);
    }

    public function workExperiences()
    {
        return $this->hasMany(WorkExperience::class);
    }

    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }
}

