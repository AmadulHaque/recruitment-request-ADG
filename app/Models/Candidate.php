<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;

class Candidate extends Model
{
    use HasApiTokens, HasUuids, SoftDeletes;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'candidate_code',
        'resume_path',
    ];

    public function applications(): HasMany
    {
        return $this->hasMany(CandidateApplication::class);
    }
}
