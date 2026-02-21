<?php

namespace App\Filament\Candidate\Resources\JobApplications\Schemas;

use App\Enums\ApplicationFinalStatus;
use App\Enums\ApplicationStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class JobApplicationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('job_id')
                    ->required()
                    ->numeric(),
                TextInput::make('candidate_id')
                    ->required()
                    ->numeric(),
                Select::make('application_status')
                    ->options(ApplicationStatus::class)
                    ->default('applied')
                    ->required(),
                DateTimePicker::make('interview_date'),
                Textarea::make('interview_note')
                    ->columnSpanFull(),
                Select::make('final_status')
                    ->options(ApplicationFinalStatus::class),
                TextInput::make('meeting_url')
                    ->url(),
                TextInput::make('documents'),
            ]);
    }
}
