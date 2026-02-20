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
                TextEntry::make('about_me')
                    ->placeholder('-')
                    ->columnSpanFull(),
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
