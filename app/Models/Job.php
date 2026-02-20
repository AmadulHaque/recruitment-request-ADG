<?php

namespace App\Models;

use App\Enums\JobStatus;
use App\Enums\JobType;
use App\Enums\JobUrgency;
use App\Enums\SalaryType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $table = 'job_posts';

    protected $fillable = [
        'company_id',
        'job_title',
        'job_category',
        'job_type',
        'vacancy_count',
        'salary_min',
        'salary_max',
        'salary_type',
        'experience_min_year',
        'experience_max_year',
        'education_requirement',
        'job_location',
        'application_deadline',
        'description',
        'benefits',
        'urgency',
        'status',
        'attachments',
    ];

    protected function casts(): array
    {
        return [
            'job_type' => JobType::class,
            'urgency' => JobUrgency::class,
            'status' => JobStatus::class,
            'salary_type' => SalaryType::class,
            'application_deadline' => 'date',
            'attachments' => 'array',
        ];
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'job_skill');
    }

    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }
}
