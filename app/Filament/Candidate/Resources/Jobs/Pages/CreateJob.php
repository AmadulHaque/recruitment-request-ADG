<?php

namespace App\Filament\Candidate\Resources\Jobs\Pages;

use App\Filament\Candidate\Resources\Jobs\JobResource;
use Filament\Resources\Pages\CreateRecord;

class CreateJob extends CreateRecord
{
    protected static string $resource = JobResource::class;
}
