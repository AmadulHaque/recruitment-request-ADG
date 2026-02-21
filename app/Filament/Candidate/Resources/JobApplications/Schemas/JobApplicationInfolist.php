<?php

namespace App\Filament\Candidate\Resources\JobApplications\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;

class JobApplicationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('job.job_title')
                    ->label('Job Title'),
                TextEntry::make('application_status')
                    ->badge(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->label('Applied At'),
                TextEntry::make('meeting_url')
                    ->url(fn ($state) => $state)
                    ->openUrlInNewTab()
                    ->visible(fn ($record) => $record->meeting_url),
                
                RepeatableEntry::make('timeline')
                    ->schema([
                        TextEntry::make('status')
                            ->badge(),
                        TextEntry::make('notes')
                            ->placeholder('-'),
                        TextEntry::make('occurred_at')
                            ->dateTime(),
                    ])
                    ->columnSpanFull(),

                RepeatableEntry::make('documents')
                    ->schema([
                        TextEntry::make('name'),
                        TextEntry::make('path')
                            ->formatStateUsing(fn ($state) => 'Download')
                            ->url(fn ($state) => Storage::disk('public')->url($state))
                            ->openUrlInNewTab(),
                        TextEntry::make('uploaded_at')
                            ->dateTime(),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
