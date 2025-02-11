<x-filament-widgets::widget>
    @inject('GooglePlaces', 'App\Filament\Widgets\PlacesData')
    <x-filament::section>
       <div class="col col-row grid-cols-3">
        <h2>Current Google Business Profile Review Stats</h2>
        @foreach ($locations as $location)
          @php
              $place = $this->getPlaces($location);
          @endphp
          <div>
            <h3>
                Location: {{ $place->streetNumber() }} {{ $place->route() }}:
                Review average: {{ $place->rating() ?: '0'}} |
                Review count: {{ $place->user_ratings_total() ?: '0'}}
            </h3>
          </div>
        @endforeach
       </div>
    </x-filament::section>
</x-filament-widgets::widget>
