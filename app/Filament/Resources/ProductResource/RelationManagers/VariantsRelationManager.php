<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class VariantsRelationManager extends RelationManager
{
    protected static string $relationship = 'variants';
    protected static ?string $title = 'וריאנטים';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('sku')
                ->required()
                ->unique(ignoreRecord: true),
            Forms\Components\TextInput::make('color_name')
                ->label('צבע')
                ->required(),
            Forms\Components\ColorPicker::make('color_hex')
                ->label('קוד צבע')
                ->required(),
            Forms\Components\Select::make('size')
                ->label('מידה')
                ->options(['XS' => 'XS', 'S' => 'S', 'M' => 'M', 'L' => 'L', 'XL' => 'XL'])
                ->required(),
            Forms\Components\TextInput::make('stock')
                ->label('מלאי')
                ->numeric()
                ->default(0)
                ->required(),
            Forms\Components\TextInput::make('price_override')
                ->label('מחיר חלופי')
                ->numeric()
                ->prefix('₪'),
            Forms\Components\Toggle::make('is_active')
                ->label('פעיל')
                ->default(true),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sku'),
                Tables\Columns\TextColumn::make('color_name')->label('צבע'),
                Tables\Columns\ColorColumn::make('color_hex')->label(''),
                Tables\Columns\TextColumn::make('size')->label('מידה'),
                Tables\Columns\TextColumn::make('stock')->label('מלאי')->sortable(),
                Tables\Columns\TextColumn::make('price_override')->label('מחיר חלופי')->prefix('₪'),
                Tables\Columns\IconColumn::make('is_active')->label('פעיל')->boolean(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('הוסף וריאנט'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}
