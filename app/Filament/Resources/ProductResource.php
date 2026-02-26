<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationGroup = 'חנות';
    protected static ?string $modelLabel = 'מוצר';
    protected static ?string $pluralModelLabel = 'מוצרים';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('Product')->tabs([
                Forms\Components\Tabs\Tab::make('פרטים')->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('שם')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn($set, $state) => $set('slug', Str::slug($state))),
                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true),
                    Forms\Components\TextInput::make('subtitle')
                        ->label('כותרת משנה'),
                    Forms\Components\Textarea::make('description')
                        ->label('תיאור')
                        ->rows(4),
                    Forms\Components\Select::make('category_id')
                        ->label('קטגוריה')
                        ->relationship('category', 'name')
                        ->required(),
                    Forms\Components\Select::make('collection_id')
                        ->label('קולקציה')
                        ->relationship('collection', 'name'),
                    Forms\Components\TextInput::make('base_price')
                        ->label('מחיר')
                        ->numeric()
                        ->prefix('₪')
                        ->required(),
                    Forms\Components\TextInput::make('sale_price')
                        ->label('מחיר מבצע')
                        ->numeric()
                        ->prefix('₪'),
                    Forms\Components\DateTimePicker::make('sale_start')
                        ->label('תחילת מבצע'),
                    Forms\Components\DateTimePicker::make('sale_end')
                        ->label('סיום מבצע'),
                    Forms\Components\Toggle::make('is_new')
                        ->label('חדש'),
                    Forms\Components\Toggle::make('is_active')
                        ->label('פעיל')
                        ->default(true),
                    Forms\Components\TextInput::make('sort_order')
                        ->label('סדר')
                        ->numeric()
                        ->default(0),
                ]),
                Forms\Components\Tabs\Tab::make('חומר ומשלוח')->schema([
                    Forms\Components\Textarea::make('material')
                        ->label('חומר וטיפול')
                        ->rows(5),
                    Forms\Components\Textarea::make('shipping_info')
                        ->label('מידע משלוח')
                        ->rows(4),
                ]),
                Forms\Components\Tabs\Tab::make('SEO')->schema([
                    Forms\Components\TextInput::make('seo_title')
                        ->label('כותרת SEO'),
                    Forms\Components\Textarea::make('seo_description')
                        ->label('תיאור SEO')
                        ->rows(3),
                ]),
            ])->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('שם')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('קטגוריה'),
                Tables\Columns\TextColumn::make('collection.name')
                    ->label('קולקציה'),
                Tables\Columns\TextColumn::make('base_price')
                    ->label('מחיר')
                    ->prefix('₪')
                    ->sortable(),
                Tables\Columns\TextColumn::make('sale_price')
                    ->label('מבצע')
                    ->prefix('₪'),
                Tables\Columns\TextColumn::make('total_stock')
                    ->label('מלאי')
                    ->getStateUsing(fn($record) => $record->variants->sum('stock')),
                Tables\Columns\IconColumn::make('is_new')
                    ->label('חדש')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('פעיל')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')
                    ->label('קטגוריה')
                    ->relationship('category', 'name'),
                Tables\Filters\SelectFilter::make('collection_id')
                    ->label('קולקציה')
                    ->relationship('collection', 'name'),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('פעיל'),
            ])
            ->defaultSort('sort_order');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\VariantsRelationManager::class,
            RelationManagers\ImagesRelationManager::class,
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
