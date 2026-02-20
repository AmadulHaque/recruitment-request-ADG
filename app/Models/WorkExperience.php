<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkExperience extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_id',
        'company_name',
        'title',
        'start_date',
        'end_date',
        'description',
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}

