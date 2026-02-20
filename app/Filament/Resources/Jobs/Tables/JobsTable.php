<?php

namespace App\Filament\Resources\Jobs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class JobsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('company_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('job_title')
                    ->searchable(),
                TextColumn::make('job_category')
                    ->searchable(),
                TextColumn::make('job_type')
                    ->badge()
                    ->searchable(),
                TextColumn::make('vacancy_count')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('salary_min')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('salary_max')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('salary_type')
                    ->badge()
                    ->searchable(),
                TextColumn::make('experience_min_year')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('experience_max_year')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('education_requirement')
                    ->searchable(),
                TextColumn::make('job_location')
                    ->searchable(),
                TextColumn::make('application_deadline')
                    ->date()
                    ->sortable(),
                TextColumn::make('urgency')
                    ->badge()
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
