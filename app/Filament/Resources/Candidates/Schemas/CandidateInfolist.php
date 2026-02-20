<?php

namespace App\Filament\Resources\Candidates\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CandidateInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user_id')
                    ->numeric(),
                TextEntry::make('recruiter_id')
                    ->placeholder('-'),
                TextEntry::make('headline')
                    ->placeholder('-'),
                TextEntry::make('expected_salary_min')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('expected_salary_max')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('preferred_job_type')
                    ->placeholder('-'),
                TextEntry::make('preferred_location')
                    ->placeholder('-'),
                TextEntry::make('total_experience_years')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('availability')
                    ->placeholder('-'),
                TextEntry::make('availability_weeks')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('about_me')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('cover_letter')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('has_consented')
                    ->badge()
                    ->color(fn (bool $state): string => $state ? 'success' : 'danger')
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Yes' : 'No'),
                TextEntry::make('profile_photo')
                    ->placeholder('-'),
                TextEntry::make('cv_file')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
