<?php

namespace App\Filament\Widgets;

use App\Models\Location;
use App\Traits\GooglePlaces;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class PlacesData extends Widget{
    use GooglePlaces;
    public array $locations=[];
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';
    public function mount(): void
    {
        $this->locations =  Location::where('users_id', Auth::id())->pluck('PID')->toArray();

    }
    protected static string $view = 'filament.widgets.places-data';
}
