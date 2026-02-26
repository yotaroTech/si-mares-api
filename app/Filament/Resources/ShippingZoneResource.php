<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShippingZoneResource\Pages;
use App\Models\ShippingZone;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ShippingZoneResource extends Resource
{
    protected static ?string $model = ShippingZone::class;
    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationGroup = 'הגדרות';
    protected static ?string $modelLabel = 'אזור משלוח';
    protected static ?string $pluralModelLabel = 'אזורי משלוח';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('שם')
                ->required(),
            Forms\Components\Select::make('zone_type')
                ->label('סוג אזור')
                ->options([
                    'domestic' => 'משלוח רגיל',
                    'express' => 'משלוח מהיר',
                    'international' => 'בינלאומי',
                ])
                ->required(),
            Forms\Components\TextInput::make('cost')
                ->label('עלות')
                ->numeric()
                ->prefix('₪')
                ->required(),
            Forms\Components\TextInput::make('min_order_free')
                ->label('הזמנה מינימלית למשלוח חינם')
                ->numeric()
                ->prefix('₪'),
            Forms\Components\TextInput::make('estimated_days_min')
                ->label('ימי משלוח מינימום')
                ->numeric(),
            Forms\Components\TextInput::make('estimated_days_max')
                ->label('ימי משלוח מקסימום')
                ->numeric(),
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
                Tables\Columns\TextColumn::make('zone_type')
                    ->label('סוג')
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'domestic' => 'משלוח רגיל',
                        'express' => 'משלוח מהיר',
                        'international' => 'בינלאומי',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('cost')
                    ->label('עלות')
                    ->prefix('₪')
                    ->sortable(),
                Tables\Columns\TextColumn::make('min_order_free')
                    ->label('מינימום לחינם')
                    ->prefix('₪'),
                Tables\Columns\TextColumn::make('estimated_days_min')
                    ->label('ימים (מינ\')')
                    ->suffix(' ימים'),
                Tables\Columns\TextColumn::make('estimated_days_max')
                    ->label('ימים (מקס\')')
                    ->suffix(' ימים'),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('פעיל')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('פעיל'),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListShippingZones::route('/'),
            'create' => Pages\CreateShippingZone::route('/create'),
            'edit' => Pages\EditShippingZone::route('/{record}/edit'),
        ];
    }
}
