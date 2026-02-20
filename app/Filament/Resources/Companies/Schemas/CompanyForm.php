<?php

namespace App\Filament\Resources\Companies\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CompanyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()
                    ->searchable(),
                TextInput::make('company_name')
                    ->required(),
                TextInput::make('website')
                    ->url(),
                TextInput::make('location'),
                TextInput::make('logo'),
                Textarea::make('about')
                    ->columnSpanFull(),
            ]);
    }
}
