<?php

namespace App\Filament\Resources\VéhiculeResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Models\Vidange;
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\Véhicule;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class VidangesRelationManager extends RelationManager
{
    protected static string $relationship = 'vidange';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('id')
                    ->label('Vidange ID')
                    ->default('VD -' . random_int(100000, 999999))
                    ->disabled()
                    ->required()
                    ->dehydrated()
                    ->unique(Vidange::class, 'id', ignoreRecord: true),

                Forms\Components\TextInput::make('ancien_km')
                    ->label('Ancien Kilométrage')
                    ->numeric()
                    ->live(onBlur: true)
                    ->afterStateUpdated(
                        function (Set $set, Get $get, ?string $state) {
                            $vp = $this->getOwnerRecord()->vp;
                            $futur_km = $get('ancien_km') + $vp;
                            $set('futur_km', $futur_km);
                        }
                    )
                    ->required(),

                Forms\Components\TextInput::make('futur_km')
                    ->label('Futur Kilométrage')
                    ->numeric()
                    ->readonly(),

                Forms\Components\Textarea::make('note')
                    ->label('Note')
                    ->columnSpan(3)
                    ->rows(2),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Date'),
                Tables\Columns\TextColumn::make('ancien_km')
                    ->label('Ancien Kilométrage')
                    ->suffix(' KM'),
                Tables\Columns\TextColumn::make('futur_km')
                    ->label('Futur Kilométrage')
                    ->suffix(' KM'),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()


            ])
            ->actions([
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


    public function isReadOnly(): bool
    {
        return false;
    }
}
