<?php

namespace App\Filament\Resources\Candidates\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CandidatesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('headline')
                    ->searchable(),
                TextColumn::make('expected_salary_min')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('expected_salary_max')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('preferred_job_type')
                    ->searchable(),
                TextColumn::make('preferred_location')
                    ->searchable(),
                TextColumn::make('total_experience_years')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('availability')
                    ->searchable(),
                TextColumn::make('profile_photo')
                    ->searchable(),
                TextColumn::make('cv_file')
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
