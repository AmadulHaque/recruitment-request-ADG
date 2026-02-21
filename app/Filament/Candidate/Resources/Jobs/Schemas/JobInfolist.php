<?php

namespace App\Filament\Candidate\Resources\Jobs\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;

class JobInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('company.name')
                    ->label('Company'),
                TextEntry::make('job_title'),
                TextEntry::make('job_category')
                    ->placeholder('-'),
                TextEntry::make('job_type')
                    ->badge(),
                TextEntry::make('vacancy_count')
                    ->numeric(),
                TextEntry::make('salary_min')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('salary_max')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('salary_type')
                    ->badge()
                    ->placeholder('-'),
                TextEntry::make('experience_min_year')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('experience_max_year')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('education_requirement')
                    ->placeholder('-'),
                TextEntry::make('job_location')
                    ->placeholder('-'),
                TextEntry::make('application_deadline')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('benefits')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('urgency')
                    ->badge(),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('attachments')
                    ->placeholder('-')
                    ->formatStateUsing(fn ($state) => $state ? Storage::disk('public')->url($state) : null)
                    ->url(fn ($state) => $state ? Storage::disk('public')->url($state) : null)
                    ->openUrlInNewTab()
                    ->columnSpanFull(),
            ]);
    }
}
