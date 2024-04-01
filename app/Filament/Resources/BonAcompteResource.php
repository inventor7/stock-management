<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Worker;
use App\Models\Acompte;
use Filament\Forms\Form;
use App\Models\BonAcompte;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Repeater;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BonAcompteResource\Pages;
use App\Filament\Resources\BonAcompteResource\RelationManagers;
use Filament\Infolists\Infolist;
use Filament\Infolists;

class BonAcompteResource extends Resource
{
    protected static ?string $model = BonAcompte::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $modelLabel = 'Acomptes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([


                Forms\Components\Hidden::make('id')
                    ->default('BAC-' . random_int(100000, 999999))
                    ->label('Bon Acompte ID')
                    ->disabled()
                    ->columnSpan(2)
                    ->required()
                    ->dehydrated()
                    ->unique(BonAcompte::class, 'id', ignoreRecord: true),

                Forms\Components\Section::make()
                    ->columns(2)
                    ->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Créé le')
                            ->content(fn (BonAcompte $record): ?string => $record->created_at?->diffForHumans()),

                        Forms\Components\Placeholder::make('updated_at')
                            ->label('Dernière modification')
                            ->content(fn (BonAcompte $record): ?string => $record->updated_at?->diffForHumans()),
                    ])
                    ->hidden(fn (?BonAcompte $record) => $record === null),


                Repeater::make('acomptes')
                    ->relationship()
                    ->columns(2)
                    ->columnSpan('full')
                    ->schema([

                        Forms\Components\Hidden::make('id')
                            ->default('AC-' . random_int(100000, 999999))
                            ->label('Acompte ID')
                            ->disabled()
                            ->required()
                            ->dehydrated()
                            ->unique(Acompte::class, 'id', ignoreRecord: true),

                        Forms\Components\Select::make('worker_id')
                            ->label('Employé')
                            ->options(Worker::query()->pluck('name', 'id'))
                            ->required()
                            ->reactive()
                            ->native(false)
                            ->distinct(),

                        Forms\Components\TextInput::make('amount')
                            ->label('Montant')
                            ->suffix('DZD')
                            ->required()
                            ->numeric(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Bon Acompte ID'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Créé le')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label(''),
                Tables\Actions\EditAction::make()
                    ->label(''),
                Tables\Actions\DeleteAction::make()
                    ->label(''),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                InfoLists\Components\Section::make('')
                    ->columns(2)
                    ->schema([
                        Infolists\Components\TextEntry::make('id')
                            ->label('Bon Acompte ID'),

                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Créé le')
                            ->dateTime(),

                    ])
            ]);
    }


    public static function getRelations(): array
    {


        return [
            RelationManagers\AcomptesRelationManager::class,
        ];
    }



    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBonAcomptes::route('/'),
            'create' => Pages\CreateBonAcompte::route('/create'),
            'edit' => Pages\EditBonAcompte::route('/{record}/edit'),
            'view' => Pages\ViewBonAcompte::route('/{record}'),
        ];
    }
}
