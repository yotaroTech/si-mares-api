<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'images';
    protected static ?string $title = 'תמונות';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\FileUpload::make('image_path')
                ->label('תמונה')
                ->image()
                ->directory('products')
                ->required(),
            Forms\Components\TextInput::make('alt_text')
                ->label('טקסט חלופי'),
            Forms\Components\TextInput::make('sort_order')
                ->label('סדר')
                ->numeric()
                ->default(0),
            Forms\Components\Toggle::make('is_primary')
                ->label('תמונה ראשית')
                ->default(false),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')->label('תמונה'),
                Tables\Columns\TextColumn::make('alt_text')->label('תיאור'),
                Tables\Columns\TextColumn::make('sort_order')->label('סדר')->sortable(),
                Tables\Columns\IconColumn::make('is_primary')->label('ראשית')->boolean(),
            ])
            ->defaultSort('sort_order')
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('הוסף תמונה'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->reorderable('sort_order');
    }
}
