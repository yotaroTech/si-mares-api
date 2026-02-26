<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class LatestOrders extends TableWidget
{
    protected static ?string $heading = 'הזמנות אחרונות';
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(Order::query()->latest()->limit(5))
            ->columns([
                Tables\Columns\TextColumn::make('order_number')->label('מספר'),
                Tables\Columns\TextColumn::make('user.name')->label('לקוח'),
                Tables\Columns\TextColumn::make('total')
                    ->label('סכום')
                    ->prefix('₪')
                    ->numeric(decimalPlaces: 0),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('סטטוס')
                    ->formatStateUsing(fn($state) => $state->label())
                    ->color(fn($state) => match ($state->value) {
                        'pending' => 'warning',
                        'confirmed', 'processing' => 'primary',
                        'shipped' => 'info',
                        'delivered' => 'success',
                        'cancelled', 'refunded' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('תאריך')
                    ->dateTime('d/m/Y H:i'),
            ])
            ->paginated(false);
    }
}
