<?php

namespace App\Filament\Resources\LocationResource\Pages;

use stdClass;
use App\Models\Location;
use Filament\Tables\Table;
use Laravel\Cashier\Cashier;
use Filament\Resources\Pages\Page;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Forms\AddLocationForm;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\LocationResource;
use Filament\Tables\Concerns\InteractsWithTable;

class UpdateLocations extends Page implements HasTable
{
  use InteractsWithTable;
  protected static string $resource = LocationResource::class;
  protected static ?string $title = 'Manage Your Locations';
  public AddLocationForm $form;
  public  $locations;
  public array $stripeAcct;
  public string $loc_qty;



  public function table(Table $table): Table
  {
    return $table
    //->modifyQueryUsing(fn (Builder $query) => $query->where('users_id', Auth::id()) )
    ->query(Location::where('users_id', Auth::id()))
    ->columns([
      TextColumn::make('index')->getStateUsing(
        static function (stdClass $rowLoop): string {
            return (string) ($rowLoop->iteration);
        }
      ),
      TextColumn::make('id')
          ->label('DB ID'),
      TextColumn::make('addr')
          ->label('Address'),
      TextColumn::make('status')
          ->label('Status')
          ->badge()
          ->color(fn (string $state): string => match ($state) {
            'active' => 'teal',
            'inactive' => 'danger',
          }),
      ])
      ->actions([
          Action::make('activate')

            ->requiresConfirmation()
            ->button()
            ->color('teal')
            ->hidden(fn ($record) => $record->status === 'active')
            ->action(function ($record, Location $location) {
              $location->update(['status' => 'active']);
          }),
          Action::make('deactivate')

            ->requiresConfirmation()
            ->button()
            ->color('danger')
            ->hidden(fn () => Auth::user()->loc_qty == 1 )
            ->action(function (Location $location) {
              $this->removeLoc($location);
          }),
        ]);
  }
    public function mount(): void
    {
      $this->loc_qty = Auth::user()->loc_qty;
      // $this->stripeAcct = Cashier::findBillable( auth()->user()->stripe_id);
      $this->stripeAcct =  Auth::user()->subscription('std')->asStripeSubscription()->toArray();
      $this->locations = Location::where('users_id', Auth::id())->get();

  }
    public function addLoc(): void
    {
      $this->form->validate();
      ray($this->form);

      $this->form->reset();
    }
    // public function activate(Location $location){
    //   ray($location->id);
    // }
    public function removeLoc(Location $location): void
    {
      //ray($location->id);
      $location->update(['status' => 'inactive']);
    }


    protected static string $view = 'filament.resources.location-resource.pages.update-locations';
}
