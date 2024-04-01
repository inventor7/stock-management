<?php

namespace App\Filament\Resources\VéhiculeResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ControleTechnique;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;
use Illuminate\Support\Number;

class ControleTechniquesRelationManager extends RelationManager
{
    protected static string $relationship = 'controle_techniques';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('id')
                    ->label('ControleTechnique ID')
                    ->default('CT -' . random_int(100000, 999999))
                    ->disabled()
                    ->required()
                    ->dehydrated()
                    ->unique(ControleTechnique::class, 'id', ignoreRecord: true),


                Forms\Components\DatePicker::make('ancien_controle')
                    ->label('Ancien Controle')

                    ->live(onBlur: true)
                    ->afterStateUpdated(
                        function (Set $set, Get $get, ?string $state) {
                            $cp = $this->getOwnerRecord()->cp;
                            $ancien_controll = new \DateTime($get('ancien_controle'));
                            $futur_controll = $ancien_controll->add(new \DateInterval('P' . $cp . 'M'))->format('Y-m-d');
                            $set('futur_controle', $futur_controll);
                        }
                    )
                    ->required(),

                Forms\Components\DatePicker::make('ancien_controle')
                    ->label('Futur Controle')

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
                Tables\Columns\TextColumn::make('véhicule_id'),
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
}
