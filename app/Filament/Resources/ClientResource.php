<?php

namespace App\Filament\Resources;


use Filament\Forms;

use Filament\Tables;
use App\Enums\States;
use App\Models\Adress;
use App\Models\Client;

use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ClientResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ClientResource\RelationManagers;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static ?string $navigationIcon = 'heroicon-o-square-3-stack-3d';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Details')
                            ->schema([
                                Forms\Components\TextInput::make('id')
                                    ->default('CL-' . random_int(100000, 999999))
                                    ->disabled()
                                    ->required()
                                    ->dehydrated()
                                    ->maxLength(32)
                                    ->unique(Client::class, 'id', ignoreRecord: true),
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(Client::class, 'id'),
                                Forms\Components\TextInput::make('phone')
                                    ->tel()
                                    ->required()
                                    ->unique(Client::class, 'phone'),
                                Forms\Components\Select::make('type')
                                    ->placeholder('Select type de client')
                                    ->options([
                                        'particulier' => 'Particulier',
                                        'company' => 'Company',
                                    ])
                                    ->default('company')
                                    ->native(false),


                            ])

                    ]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Address')

                            ->schema([
                                Forms\Components\TextInput::make('address')
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
                    ]),




                Forms\Components\Section::make('Note')
                    ->schema([
                        Forms\Components\Textarea::make('note')
                            ->label('')
                            ->maxLength(3000)
                            ->nullable()
                            ->columnSpan(2)
                    ]),





            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('state')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('city')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('note')
                    ->searchable()
                    ->toggleable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
        ];
    }
}
