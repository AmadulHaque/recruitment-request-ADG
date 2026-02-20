<?php

namespace App\Providers;

use App\Models\Candidate;
use App\Models\Job;
use App\Models\JobApplication;
use App\Policies\CandidatePolicy;
use App\Policies\JobApplicationPolicy;
use App\Policies\JobPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Job::class => JobPolicy::class,
        Candidate::class => CandidatePolicy::class,
        JobApplication::class => JobApplicationPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}

