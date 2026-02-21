<?php

namespace App\Filament\Candidate\Resources\JobApplications\Tables;

use App\Models\JobApplication;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class JobApplicationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('job.job_title')
                    ->label('Job Title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('job.company.name')
                    ->label('Company')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('application_status')
                    ->badge()
                    ->searchable(),
                TextColumn::make('interview_date')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('final_status')
                    ->badge()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Applied At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
                //
            ]);
    }
}
