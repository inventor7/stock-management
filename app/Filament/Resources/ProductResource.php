<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Enums\Category;
use App\Models\Product;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductResource\RelationManagers;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Info')
                    ->schema([
                        Forms\Components\TextInput::make('id')
                            ->default('PR-' . random_int(100000, 999999))
                            ->label('Product ID')
                            ->disabled()
                            ->required()
                            ->dehydrated()
                            ->maxLength(32)
                            ->unique(Product::class, 'id', ignoreRecord: true),
                        Forms\Components\Group::make()
                            ->columns(2)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(Product::class, 'id'),

                                Forms\Components\TextInput::make('price')
                                    ->type('number')
                                    ->required()
                            ]),
                        Forms\Components\Group::make()
                            ->columns(2)
                            ->schema([
                                Forms\Components\Select::make('category')
                                    ->reactive(function (callable $set) {
                                        $set('model', null); // Clear city selection on state change
                                    })
                                    ->placeholder('Select a category')
                                    ->native(false)
                                    ->selectablePlaceholder(false)
                                    ->searchable()
                                    ->options(array_combine(array_keys(Category::get()), array_map(function ($name) {
                                        return   $name;
                                    }, array_keys(Category::get()), array_values(Category::get()))))
                                    ->required(),

                                Forms\Components\Select::make('model')
                                    ->placeholder('Select a model')
                                    ->native(false)
                                    ->selectablePlaceholder(false)
                                    ->searchable()
                                    ->options(fn (Get $get): array => $get('category') ? Category::get()[$get('category')] : [])
                                    ->required(),

                            ])
                    ]),


                Forms\Components\Section::make('Stock')
                    ->schema([
                        Forms\Components\Group::make()
                            ->columns(2)
                            ->schema([
                                Forms\Components\TextInput::make('minimalStockQty')
                                    ->type('number')
                                    ->required(),
                                Forms\Components\TextInput::make('stockQty')
                                    ->type('number')
                                    ->required(),
                            ]),
                    ]),

                Forms\Components\Section::make('Image and Description')
                    ->schema([
                        Forms\Components\Group::make()
                            ->columns(2)
                            ->schema([
                                Forms\Components\FileUpload::make('image')
                                    ->required()
                                    ->multiple()
                                    ->imageEditor()
                                    ->image(),

                                Forms\Components\Textarea::make('description')
                                    ->required()
                            ]),
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
                Tables\Columns\TextColumn::make('price')
                    ->sortable(),
                Tables\Columns\TextColumn::make('category')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('model')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('minimalStockQty'),
                Tables\Columns\TextColumn::make('stockQty'),
                Tables\Columns\TextColumn::make('description'),
                Tables\Columns\ImageColumn::make('image')


            ])
            ->filters([
                //
            ])
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
