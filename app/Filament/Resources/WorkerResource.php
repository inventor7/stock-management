<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Team;
use Filament\Tables;
use App\Enums\States;
use App\Models\Adress;
use App\Models\Worker;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\WorkerResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\WorkerResource\RelationManagers;

class WorkerResource extends Resource
{
    protected static ?string $model = Worker::class;

    protected static ?string $modelLabel = 'employés';


    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Section::make('Details')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('id')
                            ->label('Employé ID')
                            ->default('WR-' . random_int(100000, 999999))
                            ->disabled()
                            ->required()
                            ->dehydrated()
                            ->maxLength(32)
                            ->unique(Worker::class, 'id', ignoreRecord: true),
                        Forms\Components\TextInput::make('name')
                            ->label('Nom')
                            ->required()
                            ->maxLength(255)
                            ->unique(Worker::class, 'id'),
                        Forms\Components\TextInput::make('phone')
                            ->label('Téléphone')
                            ->columnSpan(2)
                            ->tel()
                            ->required()
                            ->unique(Worker::class, 'phone'),
                    ]),



                Forms\Components\Section::make('Role')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('role')
                            ->placeholder('Select role de worker')
                            ->options([
                                'chauffeur' => 'Chauffeur',
                                'employee' => 'Employée',
                                'chefatelier' => "Chef d'Aterlier",
                                'magasinier' => 'Magasinier',
                                'montage' => 'Montage',
                            ])
                            ->columnSpan(1)
                            ->required()
                            ->default('employee')
                            ->native(false),

                    ]),



                Forms\Components\Section::make('Address')
                    ->schema([
                        Forms\Components\TextInput::make('address')
                            ->columnSpan(2)
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Group::make()
                            ->columns(2)
                            ->schema([
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
                            ])
                    ]),
            ]);
    }




    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Employé ID')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nom')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('role')
                    ->label('Role')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Téléphone')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('wilaya')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('commune')
                    ->searchable()
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Modifier'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Supprimer'),
                ])->label('Action groupé'),
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
            'index' => Pages\ListWorkers::route('/'),
            'create' => Pages\CreateWorker::route('/create'),
            'edit' => Pages\EditWorker::route('/{record}/edit'),
        ];
    }
}
