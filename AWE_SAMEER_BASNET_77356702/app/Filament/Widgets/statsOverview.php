<?php

namespace App\Filament\Widgets;


use App\Models\Orders;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class statsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $unshippedOrders = Orders::where('status', '!=', 'completed')->count();
        $totalSales = Orders::where('status', 'completed')->sum('total');
        $totalSalesLast30Days = Orders::where('status', 'completed')->where('created_at', '>=', now()->subDays(30))->sum('total');
        return [
            Card::make('Last 30 Days', '$'.$totalSalesLast30Days)
            ->description('Total sales for the last 30 days')
            ->color('success')
            ->icon('heroicon-o-currency-dollar'),
            Card::make('Total Sales', '$'.$totalSales)
            ->description('Total income from completed orders')
            ->color('success')
            ->icon('heroicon-o-currency-dollar'),
            Card::make('Unshipped Orders', $unshippedOrders)
              ->description('Orders that have not been shipped yet')
              ->color('danger')
              ->icon('heroicon-o-inbox'),
        ];
    }
}