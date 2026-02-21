<?php

namespace App\Filament\Resources\JobApplications\Schemas;

use App\Enums\ApplicationFinalStatus;
use App\Enums\ApplicationStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
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
                Select::make('job_id')
                    ->relationship('job', 'job_title')
                    ->required()
                    ->searchable(),
                Select::make('candidate_id')
                    ->relationship('candidate', 'id')
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->user->name)
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('application_status')
                    ->options(ApplicationStatus::class)
                    ->default('applied')
                    ->required(),
                DateTimePicker::make('interview_date'),
                TextInput::make('meeting_url')
                    ->url()
                    ->columnSpanFull(),
                Textarea::make('interview_note')
                    ->columnSpanFull(),
                Select::make('final_status')
                    ->options(ApplicationFinalStatus::class),
                Repeater::make('documents')
                    ->schema([
                        TextInput::make('name')->required(),
                        FileUpload::make('path')
                            ->disk('public')
                            ->directory('application-documents')
                            ->required(),
                        DateTimePicker::make('uploaded_at')
                            ->default(now()),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
