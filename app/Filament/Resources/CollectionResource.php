<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CollectionResource\Pages;
use App\Models\Collection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CollectionResource extends Resource
{
    protected static ?string $model = Collection::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'חנות';
    protected static ?string $modelLabel = 'קולקציה';
    protected static ?string $pluralModelLabel = 'קולקציות';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('שם')
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(fn ($set, $state) => $set('slug', Str::slug($state))),
            Forms\Components\TextInput::make('slug')
                ->required()
                ->unique(ignoreRecord: true),
            Forms\Components\Textarea::make('description')
                ->label('תיאור')
                ->rows(3)
                ->columnSpanFull(),
            Forms\Components\FileUpload::make('image_path')
                ->label('תמונה')
                ->image()
                ->directory('collections')
                ->disk('public'),
            Forms\Components\TextInput::make('sort_order')
                ->label('סדר')
                ->numeric()
                ->default(0),
            Forms\Components\Toggle::make('is_active')
                ->label('פעיל')
                ->default(true),
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
                Tables\Columns\TextColumn::make('slug'),
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('תמונה')
                    ->disk('public'),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('סדר')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('פעיל')
                    ->boolean(),
                Tables\Columns\TextColumn::make('products_count')
                    ->label('מוצרים')
                    ->counts('products'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('פעיל'),
            ])
            ->defaultSort('sort_order')
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCollections::route('/'),
            'create' => Pages\CreateCollection::route('/create'),
            'edit' => Pages\EditCollection::route('/{record}/edit'),
        ];
    }
}
