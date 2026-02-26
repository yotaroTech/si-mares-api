<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $todayOrders = Order::whereDate('created_at', today())->count();
        $monthRevenue = Order::where('payment_status', 'completed')
            ->whereMonth('created_at', now()->month)
            ->sum('total');
        $totalCustomers = User::where('role', 'customer')->count();
        $lowStock = Product::whereHas('variants', fn($q) => $q->where('stock', '<=', 3)->where('is_active', true))->count();

        return [
            Stat::make('הזמנות היום', $todayOrders)
                ->icon('heroicon-o-shopping-cart'),
            Stat::make('הכנסות החודש', '₪' . number_format($monthRevenue, 0))
                ->icon('heroicon-o-currency-dollar'),
            Stat::make('לקוחות', $totalCustomers)
                ->icon('heroicon-o-users'),
            Stat::make('מלאי נמוך', $lowStock)
                ->icon('heroicon-o-exclamation-triangle')
                ->color($lowStock > 0 ? 'danger' : 'success'),
        ];
    }
}
