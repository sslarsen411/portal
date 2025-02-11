<x-filament-widgets::widget>
    <x-filament::section>       
       <div class="col col-row grid-cols-3">
        <h2>Current Google Business Profile Review Stats</h2>
        @foreach ($locations as $location)
          @php
              $place = getPlaces($location);               
          @endphp
          <dir>
            <h3>{{ $place->streetNumber() }} {{ $place->route() }}</h3>
            <p>Review average: {{ $place->rating() ?: '0'}} Review count: {{ $place->user_ratings_total() ?: '0'}} </p> 
          </dir>            
        @endforeach       
       </div>
    </x-filament::section>
</x-filament-widgets::widget>
