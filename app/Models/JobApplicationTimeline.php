<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplicationTimeline extends Model
{
    protected $fillable = [
        'job_application_id',
        'status',
        'notes',
        'occurred_at',
    ];

    protected $casts = [
        'occurred_at' => 'datetime',
    ];

    public function application()
    {
        return $this->belongsTo(JobApplication::class, 'job_application_id');
    }
}
