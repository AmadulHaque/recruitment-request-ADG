<?php

namespace App\Models;

use App\Enums\ApplicationFinalStatus;
use App\Enums\ApplicationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;
    protected $fillable = [
        'job_id',
        'candidate_id',
        'application_status',
        'interview_date',
        'interview_note',
        'final_status',
    ];

    protected function casts(): array
    {
        return [
            'application_status' => ApplicationStatus::class,
            'final_status' => ApplicationFinalStatus::class,
            'interview_date' => 'datetime',
        ];
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}

