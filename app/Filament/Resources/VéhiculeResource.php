<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Worker;
use App\Models\Véhicule;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Enums\VéhiculeStatus;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\VéhiculeResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use App\Filament\Resources\VéhiculeResource\RelationManagers;

class VéhiculeResource extends Resource
{
    protected static ?string $model = Véhicule::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informations Générales')
                    ->columns(2)
                    ->columnSpan('full')
                    ->schema([
                        Forms\Components\Hidden::make('id')
                            ->label('Véhicule ID')
                            ->default('VC-' . random_int(100000, 999999))
                            ->disabled()
                            ->required()
                            ->dehydrated()
                            ->unique(Véhicule::class, 'id', ignoreRecord: true),
                        Forms\Components\TextInput::make('nom')
                            ->label('Nom')
                            ->required(),
                        Forms\Components\TextInput::make('année')
                            ->numeric()
                            ->label('Année')
                            ->required(),
                        Forms\Components\Select::make('chauffeur_id')
                            ->label('Chauffeur')
                            ->native(false)
                            ->options(Worker::query()->pluck('name', 'id'))
                            ->required(),
                        Forms\Components\ToggleButtons::make('status')
                            ->inline()
                            ->options(VéhiculeStatus::class)
                            ->required(),
                    ]),

                Forms\Components\Section::make('Périodicité des entretiens')
                    ->columns(2)
                    ->columnSpan('full')
                    ->schema([
                        Forms\Components\TextInput::make('kilometrage')
                            ->columnSpan(2)
                            ->numeric()
                            ->label('Kilométrage')
                            ->required(),
                        Forms\Components\TextInput::make('cp')
                            ->numeric()
                            ->suffix('mois')
                            ->prefix('Chaque')
                            ->label('Contrôle technique Périodique ')
                            ->required(),
                        Forms\Components\TextInput::make('vp')
                            ->numeric()
                            ->prefix('Chaque')
                            ->suffix('Kilomètres')
                            ->label('Vidange Périodique')
                            ->required(),
                    ])

            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                InfoLists\Components\Section::make()
                    ->columns(2)
                    ->schema([
                        Infolists\Components\TextEntry::make('nom')
                            ->label('Nom'),
                        Infolists\Components\TextEntry::make('année')
                            ->label('Année'),
                        Infolists\Components\TextEntry::make('status')
                            ->color(fn (string $state): string => VéhiculeStatus::from($state)->getColor())
                            ->icon(fn (string $state): string => VéhiculeStatus::from($state)->getIcon())
                            ->badge('Status'),
                        Infolists\Components\TextEntry::make('chauffeur.name')
                            ->label('Chauffeur'),
                        Infolists\Components\TextEntry::make('cp')
                            ->suffix(' mois')
                            ->prefix('Chaque ')
                            ->label('Contrôle technique Périodique'),
                        Infolists\Components\TextEntry::make('vp')
                            ->suffix(' KM')
                            ->prefix('Chaque ')
                            ->label('Vidange Périodique'),
                        Infolists\Components\TextEntry::make('kilometrage')
                            ->suffix(' KM')
                            ->label('Kilométrage'),
                        Infolists\Components\TextEntry::make('updated_at')
                            ->label('Modifié le')
                            ->dateTime(),

                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nom')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('année')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->color(fn (string $state): string => VéhiculeStatus::from($state)->getColor())
                    ->icon(fn (string $state): string => VéhiculeStatus::from($state)->getIcon())
                    ->badge(),
                Tables\Columns\TextColumn::make('chauffeur.name')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label(''),
                Tables\Actions\DeleteAction::make()
                    ->label(''),
                Tables\Actions\ViewAction::make()
                    ->label(''),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\VidangesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVéhicules::route('/'),
            'create' => Pages\CreateVéhicule::route('/create'),
            'edit' => Pages\EditVéhicule::route('/{record}/edit'),
            'view' => Pages\ViewVéhicule::route('/{record}'),
        ];
    }
}
