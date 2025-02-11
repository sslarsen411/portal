<?php
// https://php-qrcode.readthedocs.io/en/main/Usage/Quickstart.html

namespace App\Filament\Pages;

use App\Models\Location;
use Filament\Pages\Page;
use App\Models\LocationLink;
use Illuminate\Support\Collection;
use chillerlan\QRCode\{QRCode, QROptions};

class Assets extends Page
{
    protected static ?string $navigationIcon = 'fluentui-web-asset-20-o';
    protected static string $view = 'filament.pages.assets';
    protected static ?string $navigationGroup = 'Account';
    public Collection $addrArr;
    public string $link;
    public string $qrcode;
    public function getLink(): Collection
    {
        return LocationLink::where('users_id', auth()->user()->id)->pluck('link');
    }
    public function getQR($inLink){
        return (new QRCode)->render($inLink);
    }

   public function mount(): void
   {
        $this->addrArr = Location::where('users_id', auth()->user()->id)->pluck('addr');
    //ray($this->addrArr);
    }
}
