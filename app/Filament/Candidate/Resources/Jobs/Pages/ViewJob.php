<?php

namespace App\Filament\Candidate\Resources\Jobs\Pages;

use App\Filament\Candidate\Resources\Jobs\JobResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewJob extends ViewRecord
{
    protected static string $resource = JobResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
