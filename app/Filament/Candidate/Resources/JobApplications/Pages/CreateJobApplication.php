<?php

namespace App\Filament\Candidate\Resources\JobApplications\Pages;

use App\Filament\Candidate\Resources\JobApplications\JobApplicationResource;
use Filament\Resources\Pages\CreateRecord;

class CreateJobApplication extends CreateRecord
{
    protected static string $resource = JobApplicationResource::class;
}
