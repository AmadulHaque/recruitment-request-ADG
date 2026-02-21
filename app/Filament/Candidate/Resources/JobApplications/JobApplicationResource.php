<?php

namespace App\Filament\Candidate\Resources\JobApplications;

use App\Filament\Candidate\Resources\JobApplications\Pages\CreateJobApplication;
use App\Filament\Candidate\Resources\JobApplications\Pages\EditJobApplication;
use App\Filament\Candidate\Resources\JobApplications\Pages\ListJobApplications;
use App\Filament\Candidate\Resources\JobApplications\Pages\ViewJobApplication;
use App\Filament\Candidate\Resources\JobApplications\Schemas\JobApplicationForm;
use App\Filament\Candidate\Resources\JobApplications\Schemas\JobApplicationInfolist;
use App\Filament\Candidate\Resources\JobApplications\Tables\JobApplicationsTable;
use App\Models\JobApplication;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

use Illuminate\Database\Eloquent\Builder;

class JobApplicationResource extends Resource
{
    protected static ?string $model = JobApplication::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'JobApplication';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('candidate_id', auth()->user()->candidate?->id);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return JobApplicationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return JobApplicationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JobApplicationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListJobApplications::route('/'),
            'view' => ViewJobApplication::route('/{record}'),
        ];
    }
}
