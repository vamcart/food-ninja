<?php

namespace App\Filament\Resources\Links;

use App\Filament\Resources\Links\Pages\ManageLinks;
use App\Models\Link;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class LinkResource extends Resource
{
    protected static ?string $model = Link::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('url')
                    ->url()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->live(onBlur: true)->afterStateUpdated(function ($state, callable $set, $get) { $hash = str()->random(5); $set('short_url', URL::to('/go/'.$hash)); $set('short_url_hash', $hash); }),
                TextInput::make('short_url')
                ->disabled()
                ->dehydrated(),
                TextInput::make('short_url_hash')
                ->disabled()
                ->dehydrated(),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', Auth::id());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('url')
                    ->searchable(),
                TextColumn::make('short_url')
                    ->searchable(),
                TextColumn::make('short_url_hash')
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
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

public static function infolist(Schema $schema): Schema
{
    return $schema->components([
        // Basic link info (read‑only)
        TextInput::make('url')
            ->label('URL')
            ->disabled(),
        TextInput::make('short_url')
            ->label('Short URL')
            ->disabled(),
        TextInput::make('short_url_hash')
            ->label('Hash')
            ->disabled(),
        TextInput::make('created_at')
            ->label('Created at')
            ->disabled(),
        TextInput::make('updated_at')
            ->label('Updated at')
            ->disabled(),
        TextInput::make('visit_count')
            ->label('Total Visits')
            ->placeholder(fn ($record) => ($record->visits()->count() ?? 0))
            ->disabled(),
        // Visits list
        Repeater::make('visits')
            ->relationship()
            ->label('Visits')
            ->schema([
                TextInput::make('ip_address')
                    ->label('IP Address')
                    ->disabled(),
                TextInput::make('visited_at')
                    ->label('Visited At')
                    ->disabled(),
            ])
        ->columnSpanFull()
    ]);
}

public static function getPages(): array
    {
        return [
            'index' => ManageLinks::route('/'),
        ];
    }
}
