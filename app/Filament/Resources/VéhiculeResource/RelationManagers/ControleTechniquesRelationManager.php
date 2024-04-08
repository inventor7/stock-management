<?php

namespace App\Filament\Resources\VéhiculeResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Support\Number;
use App\Models\ControleTechnique;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

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
                    ->columnSpan(['default' => 1, 'sm' => 2, 'xl' => 4])
                    ->native(false)
                    ->live(onBlur: true)
                    ->afterStateUpdated(
                        function (Set $set, Get $get, ?string $state) {
                            $cp = $this->getOwnerRecord()->cp;
                            $ancien_controll = new \DateTime($get('ancien_controle'));
                            $futur_controll = clone $ancien_controll;
                            $futur_controll->add(new \DateInterval('P' . $cp . 'M'));
                            $set('futur_controle', $futur_controll->format('Y-m-d'));
                        }
                    )
                    ->closeOnDateSelection()
                    ->required(),

                Forms\Components\DatePicker::make('futur_controle')
                    ->label('Futur Controle')
                    ->columnSpan(['default' => 1, 'sm' => 2, 'xl' => 4])
                    ->native(false)
                    ->readonly(),

                Forms\Components\Textarea::make('note')
                    ->label('Note')
                    ->default(NULL)
                    ->columnSpan(['default' => 1, 'sm' => 4, 'xl' => 8])
                    ->rows(2),
            ])
            ->columns(['default' => 1, 'sm' => 4, 'xl' => 8]);
    }

    public function table(Table $table): Table
    {
        return $table

            ->columns([
                Tables\Columns\TextColumn::make('ancien_controle')
                    ->dateTime()

                    ->label('Ancien Controle'),

                Tables\Columns\TextColumn::make('futur_controle')
                    ->dateTime()
                    ->label('Futur Controle'),


                Tables\Columns\TextColumn::make('note')
                    ->label('Note'),

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
