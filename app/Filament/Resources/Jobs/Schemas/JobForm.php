<?php

namespace App\Filament\Resources\Jobs\Schemas;

use App\Enums\JobStatus;
use App\Enums\JobType;
use App\Enums\JobUrgency;
use App\Enums\SalaryType;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class JobForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('company_id')
                    ->required()
                    ->numeric(),
                TextInput::make('job_title')
                    ->required(),
                TextInput::make('job_category'),
                Select::make('job_type')
                    ->options(JobType::class)
                    ->required(),
                TextInput::make('vacancy_count')
                    ->required()
                    ->numeric()
                    ->default(1),
                TextInput::make('salary_min')
                    ->numeric(),
                TextInput::make('salary_max')
                    ->numeric(),
                Select::make('salary_type')
                    ->options(SalaryType::class),
                TextInput::make('experience_min_year')
                    ->numeric(),
                TextInput::make('experience_max_year')
                    ->numeric(),
                TextInput::make('education_requirement'),
                TextInput::make('job_location'),
                DatePicker::make('application_deadline'),
                Textarea::make('description')
                    ->columnSpanFull(),
                Textarea::make('benefits')
                    ->columnSpanFull(),
                Select::make('urgency')
                    ->options(JobUrgency::class)
                    ->default('low')
                    ->required(),
                Select::make('status')
                    ->options(JobStatus::class)
                    ->default('draft')
                    ->required(),
                Textarea::make('attachments')
                    ->columnSpanFull(),
            ]);
    }
}
