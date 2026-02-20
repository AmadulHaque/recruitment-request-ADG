<?php

namespace App\Filament\Resources\Candidates\Schemas;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CandidateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()
                    ->searchable()
                    ->label('Candidate User'),
                TextInput::make('recruiter_id')
                    ->label('Recruiter ID (if provided)'),
                TextInput::make('headline')
                    ->label('Position')
                    ->placeholder('Select or type below'),
                TextInput::make('expected_salary_min')
                    ->numeric(),
                TextInput::make('expected_salary_max')
                    ->numeric(),
                TextInput::make('preferred_job_type'),
                TextInput::make('preferred_location'),
                TextInput::make('total_experience_years')
                    ->numeric(),
                TextInput::make('availability_weeks')
                    ->numeric()
                    ->minValue(0)
                    ->label('Avail (wks)'),
                Select::make('skills')
                    ->relationship('skills', 'name')
                    ->multiple()
                    ->preload()
                    ->createOptionForm([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->columnSpanFull(),
                Textarea::make('cover_letter')
                    ->label('Cover letter / notes')
                    ->placeholder('Skills, experience, short intro...')
                    ->columnSpanFull(),
                FileUpload::make('profile_photo')
                    ->image()
                    ->avatar(),
                FileUpload::make('cv_file')
                    ->label('Attach resume')
                    ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                    ->columnSpanFull(),
                Checkbox::make('has_consented')
                    ->label('I consent to the processing of my application and personal data.')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
