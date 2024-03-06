<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Actions;
use App\Models\Client;
use App\Models\Worker;
use App\Models\Product;
use Filament\Forms\Get;
use Filament\Infolists;
use Filament\Forms\Form;
use App\Models\OrderItem;
use Filament\Tables\Table;
use function Livewire\after;
use function Livewire\before;
use Filament\Infolists\Infolist;
use Infolists\Actions\CreateAction;
use Filament\Forms\Components\Select;

use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\Actions\Action;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class OrderitemsRelationManager extends RelationManager
{
    protected static string $relationship = 'orderitems';

    protected static ?string $label = 'Produits';
    protected static ?string $title = 'Liste des Produits';



    public function form(Form $form): Form
    {

        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->columns(3)
                    ->schema([
                        Forms\Components\Hidden::make('id')
                            ->label('Order Item ID')
                            ->default('OI-' . random_int(100000, 999999))
                            ->disabled()
                            ->required()
                            ->dehydrated()
                            ->unique(OrderItem::class, 'id', ignoreRecord: true),

                        Forms\Components\Select::make('product_id')
                            ->label('Produit')
                            ->options(Product::query()->pluck('name', 'id'))
                            ->required()
                            ->reactive()
                            ->distinct()
                            ->searchable(),

                        Forms\Components\TextInput::make('quantity')
                            ->label('Quantité')
                            ->numeric()
                            ->default(1)
                            ->required(),

                        Forms\Components\Select::make('worker_id')
                            ->label('Pris par')
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
                    ->label('Produit')
                    ->searchable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->label('Quantité'),
                Tables\Columns\TextColumn::make('worker.name')
                    ->searchable()
                    ->label('Pris par'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Créé le')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Ajouter un produit')
                    ->mutateFormDataUsing(function (array $data): array {
                        $product = Product::find($data['product_id']);
                        $product->stockQty = $product->stockQty - $data['quantity'];
                        $product->save();
                        return $data;
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Modifier'),
                Tables\Actions\DeleteAction::make()
                    ->label('Supprimer'),
                Tables\Actions\ViewAction::make()
                    ->label(''),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
