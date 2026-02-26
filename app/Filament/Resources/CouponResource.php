<?php

namespace App\Filament\Resources;

use App\Enums\CouponType;
use App\Filament\Resources\CouponResource\Pages;
use App\Models\Coupon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CouponResource extends Resource
{
    protected static ?string $model = Coupon::class;
    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $navigationGroup = 'שיווק';
    protected static ?string $modelLabel = 'קופון';
    protected static ?string $pluralModelLabel = 'קופונים';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('code')
                ->label('קוד')
                ->required()
                ->unique(ignoreRecord: true),
            Forms\Components\Select::make('type')
                ->label('סוג')
                ->options([
                    CouponType::Percentage->value => 'אחוזים',
                    CouponType::Fixed->value => 'סכום קבוע',
                    CouponType::FreeShipping->value => 'משלוח חינם',
                ])
                ->required(),
            Forms\Components\TextInput::make('value')
                ->label('ערך')
                ->numeric()
                ->required(),
            Forms\Components\TextInput::make('min_order')
                ->label('הזמנה מינימלית')
                ->numeric()
                ->prefix('₪'),
            Forms\Components\TextInput::make('max_uses')
                ->label('שימושים מקסימליים')
                ->numeric(),
            Forms\Components\TextInput::make('uses_count')
                ->label('שימושים')
                ->numeric()
                ->disabled()
                ->default(0),
            Forms\Components\DateTimePicker::make('valid_from')
                ->label('תקף מ'),
            Forms\Components\DateTimePicker::make('valid_to')
                ->label('תקף עד'),
            Forms\Components\Toggle::make('is_active')
                ->label('פעיל')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('קוד')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('סוג')
                    ->formatStateUsing(fn ($state) => match ($state) {
                        CouponType::Percentage => 'אחוזים',
                        CouponType::Fixed => 'סכום קבוע',
                        CouponType::FreeShipping => 'משלוח חינם',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('value')
                    ->label('ערך')
                    ->sortable(),
                Tables\Columns\TextColumn::make('uses_count')
                    ->label('שימושים')
                    ->sortable(),
                Tables\Columns\TextColumn::make('max_uses')
                    ->label('מקסימום'),
                Tables\Columns\TextColumn::make('valid_from')
                    ->label('תקף מ')
                    ->dateTime('d/m/Y'),
                Tables\Columns\TextColumn::make('valid_to')
                    ->label('תקף עד')
                    ->dateTime('d/m/Y'),
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
            'index' => Pages\ListCoupons::route('/'),
            'create' => Pages\CreateCoupon::route('/create'),
            'edit' => Pages\EditCoupon::route('/{record}/edit'),
        ];
    }
}
