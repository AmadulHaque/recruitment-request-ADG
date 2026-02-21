<?php

namespace App\Filament\Candidate\Resources\Jobs\Tables;

use App\Enums\ApplicationStatus;
use App\Models\Job;
use App\Models\JobApplication;
use App\Services\ApplicationService;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class JobsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('company.name')
                    ->label('Company')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('job_title')
                    ->searchable(),
                TextColumn::make('job_category')
                    ->searchable(),
                TextColumn::make('job_type')
                    ->badge()
                    ->searchable(),
                TextColumn::make('job_location')
                    ->searchable(),
                TextColumn::make('application_deadline')
                    ->date()
                    ->sortable(),
                TextColumn::make('urgency')
                    ->badge()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                Action::make('apply')
                    ->label('Apply Now')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function (Job $record, ApplicationService $applicationService) {
                        $candidate = auth()->user()->candidate;
                        
                        if (!$candidate) {
                            Notification::make()
                                ->title('Profile Incomplete')
                                ->body('Please complete your candidate profile before applying.')
                                ->danger()
                                ->send();
                            return;
                        }

                        if (JobApplication::where('job_id', $record->id)
                            ->where('candidate_id', $candidate->id)
                            ->exists()) {
                            Notification::make()
                                ->title('Already Applied')
                                ->body('You have already applied for this job.')
                                ->warning()
                                ->send();
                            return;
                        }

                        try {
                            $applicationService->apply($candidate, $record);
                            
                            Notification::make()
                                ->title('Application Submitted')
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Application Failed')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    })
                    ->hidden(function (Job $record) {
                        $candidate = auth()->user()->candidate;
                        if (!$candidate) return false;
                        
                        return JobApplication::where('job_id', $record->id)
                            ->where('candidate_id', $candidate->id)
                            ->exists();
                    }),
            ])
            ->toolbarActions([
                //
            ]);
    }
}
