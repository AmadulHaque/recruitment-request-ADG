<?php

namespace App\Filament\Resources\JobApplications\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class JobApplicationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('job.job_title')
                    ->label('Job'),
                TextEntry::make('candidate.user.name')
                    ->label('Candidate'),
                TextEntry::make('application_status')
                    ->badge(),
                TextEntry::make('interview_date')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('meeting_url')
                    ->url(fn ($state) => $state)
                    ->openUrlInNewTab()
                    ->placeholder('-')
                    ->visible(fn ($state) => !empty($state))
                    ->columnSpanFull(),
                TextEntry::make('interview_note')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('final_status')
                    ->badge()
                    ->placeholder('-'),
                
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
                            ->url(fn ($state) => \Illuminate\Support\Facades\Storage::disk('public')->url($state))
                            ->openUrlInNewTab(),
                        TextEntry::make('uploaded_at')
                            ->dateTime(),
                    ])
                    ->columnSpanFull(),

                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
