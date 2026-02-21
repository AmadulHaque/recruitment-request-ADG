<?php

namespace App\Filament\Candidate\Resources\Jobs;

use App\Filament\Candidate\Resources\Jobs\Pages\CreateJob;
use App\Filament\Candidate\Resources\Jobs\Pages\EditJob;
use App\Filament\Candidate\Resources\Jobs\Pages\ListJobs;
use App\Filament\Candidate\Resources\Jobs\Pages\ViewJob;
use App\Filament\Candidate\Resources\Jobs\Schemas\JobForm;
use App\Filament\Candidate\Resources\Jobs\Schemas\JobInfolist;
use App\Filament\Candidate\Resources\Jobs\Tables\JobsTable;
use App\Models\Job;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class JobResource extends Resource
{
    protected static ?string $model = Job::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Job';

    public static function form(Schema $schema): Schema
    {
        return JobForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return JobInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JobsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListJobs::route('/'),
            'view' => ViewJob::route('/{record}'),
        ];
    }
}
