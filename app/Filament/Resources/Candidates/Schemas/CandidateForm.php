<?php

namespace App\Filament\Resources\Candidates\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CandidateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('headline'),
                TextInput::make('expected_salary_min')
                    ->numeric(),
                TextInput::make('expected_salary_max')
                    ->numeric(),
                TextInput::make('preferred_job_type'),
                TextInput::make('preferred_location'),
                TextInput::make('total_experience_years')
                    ->numeric(),
                TextInput::make('availability'),
                Textarea::make('about_me')
                    ->columnSpanFull(),
                TextInput::make('profile_photo'),
                TextInput::make('cv_file'),
            ]);
    }
}
