<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Enums\States;
use App\Models\Order;
use App\Models\Adress;
use App\Models\Client;
use App\Models\Worker;
use App\Models\Product;
use Filament\Forms\Get;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Forms\Form;
use App\Models\OrderItem;
use App\Enums\OrderStatus;
use Filament\Tables\Table;

use Filament\Resources\Resource;
use Illuminate\Support\Collection;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Repeater;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Actions\Action;
use App\Filament\Resources\OrderResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\OrderResource\RelationManagers;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $modelLabel = 'Commandes';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->columns(2)
                    ->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->columnSpan(1)
                            ->label('Créé le')
                            ->content(fn (Order $record): ?string => $record->created_at?->diffForHumans()),

                        Forms\Components\Placeholder::make('updated_at')
                            ->columnSpan(1)
                            ->label('Dernière modification')
                            ->content(fn (Order $record): ?string => $record->updated_at?->diffForHumans()),
                    ])
                    ->hidden(fn (?Order $record) => $record === null),



                Forms\Components\Section::make()
                    ->columns(2)
                    ->schema([
                        Forms\Components\Section::make('Informations')
                            ->columns(2)
                            ->schema([
                                Forms\Components\TextInput::make('id')
                                    ->default('OR-' . random_int(100000, 999999))
                                    ->label('Commande ID')
                                    ->disabled()
                                    ->required()
                                    ->dehydrated()
                                    ->maxLength(32)
                                    ->unique(Order::class, 'id', ignoreRecord: true),

                                Forms\Components\ToggleButtons::make('status')
                                    ->inline()
                                    ->options(OrderStatus::class)
                                    ->required(),
                            ]),


                        Forms\Components\Section::make('Client et Chef d\'Atelier')
                            ->columns(2)
                            ->schema([
                                Forms\Components\Select::make('leader_id')
                                    ->label('Chef d\'Atelier')
                                    ->options(Worker::query()->where('role', 'chefatelier')->get()->pluck('name', 'id'))
                                    ->searchable()
                                    ->required(),


                                Forms\Components\Select::make('client_id')
                                    ->label('Client')
                                    ->relationship('client', 'name')
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
                                            ->unique(Client::class, 'id', ignoreRecord: true),
                                        Forms\Components\TextInput::make('name')
                                            ->label('Nom')
                                            ->required()
                                            ->maxLength(255),

                                        Forms\Components\Select::make('type')
                                            ->label('Type')
                                            ->placeholder('Select type')
                                            ->options([
                                                'particulier' => 'Particulier',
                                                'company' => 'Company',
                                            ])
                                            ->required()
                                            ->native(false),
                                        Forms\Components\TextArea::make('note')
                                            ->label('Note')
                                            ->maxLength(255),
                                    ]),
                            ]),


                        Forms\Components\Section::make('Address')
                            ->columns(2)
                            ->schema([
                                Forms\Components\TextInput::make('adress')
                                    ->columnSpan(2)
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\Select::make('wilaya')
                                    ->label('Wilaya')
                                    ->placeholder('Select city')
                                    ->native(false)
                                    ->selectablePlaceholder(false)
                                    ->searchable()
                                    ->options(States::get())
                                    ->required(),

                                Forms\Components\Select::make('commune')
                                    ->placeholder('Select city')
                                    ->native(false)
                                    ->selectablePlaceholder(false)
                                    ->searchable()
                                    ->options(fn (Get $get): Collection => $get('wilaya') ? Adress::query()->where('wilaya_code', $get('wilaya'))->pluck('commune_name_ascii', 'commune_name_ascii') : collect())
                                    ->required(),


                            ]),


                        Forms\Components\Section::make('Note')
                            ->schema([
                                Forms\Components\Textarea::make('note')
                                    ->label('')
                                    ->maxLength(3000)
                                    ->nullable()
                                    ->columnSpan(2)
                            ]),
                    ]),

            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                InfoLists\Components\Section::make()
                    ->columns(3)
                    ->schema([
                        Infolists\Components\TextEntry::make('id')
                            ->label('Commande ID'),
                        Infolists\Components\TextEntry::make('client.name')
                            ->label('Client'),
                        Infolists\Components\TextEntry::make('created_at')
                            ->dateTime()
                            ->label('Créé le'),
                        Infolists\Components\TextEntry::make('status')
                            ->color(fn (string $state): string => OrderStatus::from($state)->getColor())
                            ->icon(fn (string $state): string => OrderStatus::from($state)->getIcon())
                            ->badge('Status'),
                        Infolists\Components\TextEntry::make('leader.name')
                            ->label('Chef d\'Atelier'),
                        Infolists\Components\TextEntry::make('updated_at')
                            ->dateTime()
                            ->label('Dernière modification'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Commande ID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('client.name')
                    ->label('Client')
                    ->searchable(),
                Tables\Columns\TextColumn::make('leader.name')
                    ->label("Chef d'Atelier")
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->color(fn (string $state): string => OrderStatus::from($state)->getColor())
                    ->icon(fn (string $state): string => OrderStatus::from($state)->getIcon())
                    ->badge(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Créé le')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label(''),
                Tables\Actions\ViewAction::make()
                    ->label(''),
                Tables\Actions\Action::make('download')
                    ->label('')
                    ->icon('heroicon-o-document-arrow-down')
                    ->url(fn (Order $record) => route('order.pdf', $record))
                    ->openUrlInNewTab(true),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Supprimer'),
                ])->label('Action groupé'),
            ]);
    }

    public static function getNavigationBadge(): ?string
    {
        /** @var class-string<Model> $modelClass */
        $modelClass = static::$model;

        return (string) $modelClass::where('status', 'processing')->count();
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\OrderitemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
