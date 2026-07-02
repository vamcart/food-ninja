<?php

namespace App\Filament\Resources\Links\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class LinkForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('url')
                    ->url()
                    ->required(),
                Textarea::make('short_url')
                    ->columnSpanFull(),
            ]);
    }
}
