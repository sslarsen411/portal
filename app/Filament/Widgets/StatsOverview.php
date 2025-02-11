<?php
// https://github.com/SachinAgarwal1337/google-places-api?tab=readme-ov-file#laravel-usage
namespace App\Filament\Widgets;

use App\Models\Review; 
use App\Models\Customer; 
use Illuminate\Support\Facades\Auth;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget{
    protected function getStats(): array{       
        return [
            Stat::make('Total Reviews Generated', Review::where('users_id', Auth::id())->pluck('id')->count()),   
            Stat::make('Rating Average', round(Review::where('users_id', Auth::id())->pluck('rate')->avg(),1))
            ->descriptionIcon('heroicon-s-star')
            ->description('Stars')
            ->color('warning'),
            Stat::make('Customers in the Database', Customer::getModel()::where('users_id', Auth::id())->count()),
        ];
    }
}
