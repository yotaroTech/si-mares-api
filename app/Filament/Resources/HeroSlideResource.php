<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeroSlideResource\Pages;
use App\Models\HeroSlide;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HeroSlideResource extends Resource
{
    protected static ?string $model = HeroSlide::class;
    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'תוכן';
    protected static ?string $modelLabel = 'סליידר';
    protected static ?string $pluralModelLabel = 'סליידרים';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')
                ->label('כותרת')
                ->required(),
            Forms\Components\TextInput::make('subtitle')
                ->label('כותרת משנה'),
            Forms\Components\FileUpload::make('image_path')
                ->label('תמונה')
                ->image()
                ->directory('hero-slides')
                ->disk('public')
                ->required(),
            Forms\Components\TextInput::make('link_url')
                ->label('קישור')
                ->url(),
            Forms\Components\TextInput::make('link_text')
                ->label('טקסט קישור'),
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
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('תמונה')
                    ->disk('public'),
                Tables\Columns\TextColumn::make('title')
                    ->label('כותרת')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subtitle')
                    ->label('כותרת משנה'),
                Tables\Columns\TextColumn::make('link_url')
                    ->label('קישור')
                    ->limit(30),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('סדר')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('פעיל')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('פעיל'),
            ])
            ->reorderable('sort_order')
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
            'index' => Pages\ListHeroSlides::route('/'),
            'create' => Pages\CreateHeroSlide::route('/create'),
            'edit' => Pages\EditHeroSlide::route('/{record}/edit'),
        ];
    }
}
