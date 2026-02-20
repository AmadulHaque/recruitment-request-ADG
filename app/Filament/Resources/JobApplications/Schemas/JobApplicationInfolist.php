<?php

namespace App\Filament\Resources\JobApplications\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class JobApplicationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('job_id')
                    ->numeric(),
                TextEntry::make('candidate_id')
                    ->numeric(),
                TextEntry::make('application_status')
                    ->badge(),
                TextEntry::make('interview_date')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('interview_note')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('final_status')
                    ->badge()
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
