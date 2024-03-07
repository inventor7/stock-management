<?php

namespace App\Filament\Resources\BonAcompteResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Models\Worker;
use App\Models\Acompte;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class AcomptesRelationManager extends RelationManager
{
    protected static string $relationship = 'acomptes';

    public function form(Form $form): Form
    {
        return $form
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
                    ->required()
                    ->numeric(),
            ]);
    }



    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('worker.name')
                    ->label('Employé'),
                Tables\Columns\TextColumn::make('amount')
                    ->suffix(' DZD')
                    ->label('Amount'),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
