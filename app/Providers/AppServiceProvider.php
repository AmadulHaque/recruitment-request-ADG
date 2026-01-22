<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\Repositories\RecruitmentRequestRepositoryInterface;
use App\Contracts\Repositories\CandidateRepositoryInterface;
use App\Contracts\Repositories\CandidateApplicationRepositoryInterface;
use App\Contracts\Services\RecruitmentRequestServiceInterface;
use App\Contracts\Services\CandidateServiceInterface;
use App\Contracts\Services\ApplicationServiceInterface;
use App\Contracts\Services\AuthServiceInterface;
use App\Repositories\RecruitmentRequestRepository;
use App\Repositories\CandidateRepository;
use App\Repositories\CandidateApplicationRepository;
use App\Services\RecruitmentRequestService;
use App\Services\CandidateService;
use App\Services\ApplicationService;
use App\Services\AuthService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(RecruitmentRequestRepositoryInterface::class, RecruitmentRequestRepository::class);
        $this->app->bind(CandidateRepositoryInterface::class, CandidateRepository::class);
        $this->app->bind(CandidateApplicationRepositoryInterface::class, CandidateApplicationRepository::class);

        $this->app->bind(RecruitmentRequestServiceInterface::class, RecruitmentRequestService::class);
        $this->app->bind(CandidateServiceInterface::class, CandidateService::class);
        $this->app->bind(ApplicationServiceInterface::class, ApplicationService::class);
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
