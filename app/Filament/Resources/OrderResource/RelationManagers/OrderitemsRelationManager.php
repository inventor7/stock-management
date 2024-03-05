<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Models\Client;
use App\Models\Worker;
use App\Models\Product;
use Filament\Forms\Get;
use Filament\Forms\Form;
use App\Models\OrderItem;
use Filament\Tables\Table;
use Filament\Actions;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class OrderitemsRelationManager extends RelationManager
{
    protected static string $relationship = 'orderitems';


    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Section::make()
                    ->columns(3)
                    ->schema([
                        Forms\Components\Hidden::make('id')
                            ->default('OI-' . random_int(100000, 999999))
                            ->disabled()
                            ->required()
                            ->dehydrated()
                            ->unique(OrderItem::class, 'id', ignoreRecord: true),

                        Forms\Components\Select::make('product_id')
                            ->label('Product')
                            ->options(Product::query()->pluck('name', 'id'))
                            ->required()
                            ->reactive()
                            ->distinct()
                            ->searchable(),

                        Forms\Components\TextInput::make('quantity')
                            ->label('Quantity')
                            ->numeric()
                            ->default(1)
                            ->required(),

                        Forms\Components\Select::make('worker_id')
                            ->label('Taken by')
                            ->options(Worker::query()->pluck('name', 'id'))
                            ->reactive()
                            ->distinct()
                            ->searchable(),

                    ]),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('quantity'),
                Tables\Columns\TextColumn::make('worker.name')
                    ->searchable()
                    ->label('Taken by'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created at')
                    ->dateTime(),
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
