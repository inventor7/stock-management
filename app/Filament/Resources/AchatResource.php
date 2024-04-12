<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Achat;
use App\Models\Worker;
use App\Models\Product;
use Filament\Infolists;
use Filament\Forms\Form;
use App\Models\AchatItem;
use Filament\Tables\Table;
use App\Models\Fournisseur;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Forms\Components\Repeater;
use Illuminate\Database\Eloquent\Builder;

use App\Filament\Resources\AchatResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AchatResource\RelationManagers;


class AchatResource extends Resource
{
    protected static ?string $model = Achat::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $modelLabel = 'Achats';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->columns(2)
                    ->schema([


                        Forms\Components\Section::make()
                            ->columns(4)
                            ->columnSpan(4)
                            ->schema([
                                Forms\Components\TextInput::make('id')
                                    ->label('Achat ID')
                                    ->required()
                                    ->columnSpan(2)
                                    ->maxLength(32)
                                    ->unique(Achat::class, 'id', ignoreRecord: true),
                                Forms\Components\TextInput::make('price')
                                    ->label('Montant')
                                    ->numeric()
                                    ->columnSpan(2)
                                    ->required(),
                                Forms\Components\DatePicker::make('bon_achat_date')
                                    ->label('Date de bon d\'achat')
                                    ->columnSpan(4)
                                    ->native(false),
                            ]),


                    ]),
                Forms\Components\Section::make('Chauffeur & Fournisseur')
                    ->columns(2)
                    ->columnSpan(2)
                    ->schema([
                        Forms\Components\Select::make('chauffeur_id')
                            ->options(Worker::query()->where('role', 'chauffeur')->get()->pluck('name', 'id'))
                            ->label('Chauffeur')
                            ->native(false)
                            ->required(),

                        Forms\Components\Select::make('fournisseur_id')
                            ->label('Fournisseur')
                            ->options(Fournisseur::query()->get()->pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->createOptionForm([

                                Forms\Components\TextInput::make('id')
                                    ->label('Client ID')
                                    ->default('CL-' . random_int(100000, 999999))
                                    ->disabled()
                                    ->required()
                                    ->dehydrated()
                                    ->maxLength(32)
                                    ->unique(Fournisseur::class, 'id', ignoreRecord: true),
                                Forms\Components\TextInput::make('name')
                                    ->label('Nom')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('note')
                                    ->label('Note')
                                    ->maxLength(255),
                            ]),

                    ]),
                Forms\Components\Section::make('Payment')
                    ->columns(2)
                    ->columnSpan(2)
                    ->schema([

                        Forms\Components\Select::make('payment_status')
                            ->label('Statut de paiement')
                            ->native(false)
                            ->options([
                                'paid' => 'Payé',
                                'unpaid' => 'Non payé',
                            ])
                            ->required(), Forms\Components\DatePicker::make('payment_date')
                            ->label('Date de paiement')
                            ->native(false)
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Achat ID')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('chauffeur.name')
                    ->label('Chauffeur')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('price')
                    ->label('Montant')
                    ->suffix(' DZD')
                    ->sortable(),
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
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Supprimer tous'),
                ]),
            ]);
    }


    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make()
                    ->columns(2)
                    ->columnSpan(2)
                    ->schema([
                        Infolists\Components\TextEntry::make('bon_achat_date')
                            ->label('Date de bon d\'achat')
                            ->dateTime('D M Y'),
                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Créé le')
                            ->dateTime(),

                    ]),
                InfoLists\Components\Section::make()
                    ->columns(2)
                    ->schema([
                        Infolists\Components\TextEntry::make('id')
                            ->label('Bon Achat ID'),

                        Infolists\Components\TextEntry::make('chauffeur.name')
                            ->label('Chauffeur'),
                        Infolists\Components\TextEntry::make('price')
                            ->suffix(' DZD')
                            ->label('Montant'),
                        Infolists\Components\TextEntry::make('fournisseur.name')
                            ->label('Fournisseur'),

                    ]),
                Infolists\Components\Section::make('Payment')
                    ->columns(2)
                    ->schema([
                        Infolists\Components\TextEntry::make('payment_status')
                    
                            ->label('Statut de paiement'),
                        Infolists\Components\TextEntry::make('payment_date')
                            ->dateTime('D M Y')
                            ->label('Date de paiement'),
                    ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\AchatItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAchats::route('/'),
            'create' => Pages\CreateAchat::route('/create'),
            'edit' => Pages\EditAchat::route('/{record}/edit'),
            'view' => Pages\ViewAchat::route('/{record}'),
        ];
    }
}
