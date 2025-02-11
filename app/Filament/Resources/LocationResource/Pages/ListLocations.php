<?php

namespace App\Filament\Resources\LocationResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\LocationResource;

class ListLocations extends ListRecords
{
    protected static string $resource = LocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            
            Action::make('Update')
                ->label('Manage Locations')
                ->url(fn (): string => LocationResource::getUrl('update'))
        ];
    }
}
