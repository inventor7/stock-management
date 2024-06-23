<?php

namespace App\Filament\Resources\AchatResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Form;
use App\Models\AchatItem;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class AchatItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'achatitems';

    protected static ?string $title = 'Liste des Achats';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('id')
                    ->label('AchatItem ID')
                    ->disabled()
                    ->default('ACHI-' . random_int(100000, 999999))
                    ->columnSpan(2)
                    ->required()
                    ->dehydrated()
                    ->unique(AchatItem::class, 'id', ignoreRecord: true),

                Forms\Components\Select::make('product_id')
                    ->label('Produit')
                    ->native(false)
                    ->searchable()
                    ->options(Product::all()->pluck('name', 'id')->toArray())
                    ->searchable()
                    ->required(),

                Forms\Components\TextInput::make('quantity')
                    ->label('Quantité')
                    ->numeric()
                    ->required(),

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
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Ajouter un achat')
                    ->mutateFormDataUsing(function (array $data): array {
                        $product = Product::find($data['product_id']);
                        $product->stockQty = $product->stockQty - $data['quantity'];
                        $product->save();
                        return $data;
                    })
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
