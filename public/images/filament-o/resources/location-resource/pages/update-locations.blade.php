<x-filament-panels::page>
    {{ $this->table }}
    <h3 class="text-lg">
        To add a location, type the <strong>name</strong> of your business, then choose the location from the auto-complete
    </h3>
    
    <div class="w-full -mt-2 mb-4">
        <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Enter a Location" id="placeInput"/>
        <h4 class="mt-2">
            Each new location is an additional $150 per month
        </h4>
    </div> 
    <form wire:submit="addLoc"  id="frmLoc" class="bg-gray-100 p-6" onsubmit="javascript:document.getElementById('spinner').classList.remove('hidden')">
        @csrf
        <h2 class="mb-4 p-4 text-2xl font-bold text-indigo-900 dark:text-white">
             {{ $this->form->biz ?? 'Location Data'}}
        </h2>
        <input type="hidden" wire:model="form.biz" id="biz" disabled class="text-2xl w-full ml-8 border-0 border-gray-300 bg-zinc-100 text-red-900 block p-2.5"  >
        <section  class="p-8 fi-section rounded-xl bg-gray-200 shadow-sm ring-1 ring-gray-950/5" style="padding:1rem;" id="data.location-info-all-fields-are-required">  
            <div class="grid gap-4 sm:grid-cols-3 sm:gap-6">
                <div class="sm:col-span-3">
                    <label for="addr" class="block mb-2 text-sm font-medium text-gray-900 ">Street Address</label>
                    <input type="text" wire:model="form.addr" id="addr" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                            focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5" value="{{ old('addr') }}" >
                </div>
                <div class="w-full">
                    <label for="city" class="block mb-2 text-sm font-medium text-gray-900 ">City</label>
                    <input type="text" wire:model="form.city" id="city"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                            focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5" value="{{ old('city') }}" >
                </div>
                <div class="w-full">
                    <label for="state" class="block mb-2 text-sm font-medium text-gray-900 ">State</label>
                    <input type="text" wire:model="form.state" id="state"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                            focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5" value="{{ old('state') }}" />               
                </div>
                <div class="w-full">
                    <label for="zip" class="block mb-2 text-sm font-medium text-gray-900 ">Zip</label>
                    <input type="text" wire:model="form.zip" id="zip" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                            focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5" value="{{ old('zip') }}" >  
                </div>
                <div class="w-full">
                    <label for="loc_phone" class="block mb-2 text-sm font-medium text-gray-900 ">Location phone</label>
                    <input type="tel" wire:model="form.loc_phone" id="loc_phone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 
                        focus:border-blue-600 block w-full p-2.5 @error('form.loc_phone') error @enderror" value="{{ old('loc_phone') }}"/>                   
                    @error('form.loc_phone') <span  class="error text-sm font-semibold">{{ $message }}</span> @enderror                    
                </div>
                <div class="w-full">
                    <label for="cid" class="block mb-2 text-sm font-medium text-gray-900 ">Google Places CID</label>
                    <input type="text" readonly wire:model="form.CID" id="cid"  class="bg-gray-100 border border-gray-300 text-gray-400 text-sm rounded-lg 
                        focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5" value="{{ old('CID') }}" >                   
                    @error('form.CID') <span class="text-red-600 text-sm font-semibold">{{ $message }}</span>@enderror
                </div>
                <div class="w-full">
                    <label for="pid" class="block mb-2 text-sm font-medium text-gray-900 ">Google Places PID</label>
                    <input type="text" readonly wire:model="form.PID" id="pid"  class="bg-gray-100 border border-gray-300 text-gray-400 text-sm rounded-lg 
                        focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5" value="{{ old('PID') }}" >                   
                    @error('form.PID')<span class="text-red-600 text-sm font-semibold">{{ $message }}</span>@enderror
                </div>                    
        
                <div class="w-full">
                    <label for="ttl_reviews" class="block mb-2 text-sm font-medium text-gray-900 ">Current Google review count</label>
                    <input type="text" wire:model="form.ttl"  id="ttl_reviews" readonly class="bg-gray-100 border border-gray-300 text-gray-400 text-sm rounded-lg 
                            focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5" value="{{ old('init_rct') }}" />                   
                </div>
                <div class="w-full">
                    <label for="rating" class="block mb-2 text-sm font-medium text-gray-900 ">Current Review average</label>
                    <input type="text" wire:model="form.rate"  id="rating"  readonly class="bg-gray-100 border border-gray-300 text-gray-400 text-sm rounded-lg 
                            focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5" value="{{ old('init_rate') }}" />                   
                </div>
            <div class="flex items-center">
                <div id='spinner' class="hidden bg-zinc-50/90 p-8 rounded-lg lv-bars lv-mid lg" data-label="Processing..."><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
            </div>
            <div class="flex flex-row items-center justify-end">  
                <x-filament::button class="my-4 float-right" wire:click="addLoc">
                    Add Location
                </x-filament::button>                  
            </div>
        </section>
    </form> 
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('maps.maps_api') }}&libraries=places"></script> 
<script> 
    document.getElementById('placeInput').addEventListener("focus", function(){
        document.getElementById("frmLoc").classList.remove("opacity-10")
    });
    function reloadPage() {
        var currentDocumentTimestamp =
        new Date(performance.timing.domLoading).getTime();
        var now = Date.now();
        var tenSec = 10 * 1000;
        var plusTenSec = currentDocumentTimestamp + tenSec;
        if (now > plusTenSec) {
        location.reload();
        } else {}
    }
    reloadPage()      
    // window.onload = (event) => {
    //     document.getElementById("frmLoc").classList.add("opacity-10")
    // };
    google.maps.event.addDomListener(window, 'load', initialize);
    function initialize() {    
        let places = document.getElementById('placeInput');
        let frm = document.getElementById("frmLoc")
        let addr = document.getElementById('addr')
        let city = document.getElementById('city')
        let state = document.getElementById('state')
        let zip = document.getElementById('zip')
        let loc_phone = document.getElementById('loc_phone')
        let cid = document.getElementById('cid')
        let pid = document.getElementById('pid')
        let ttl = document.getElementById('ttl_reviews')
        let rate = document.getElementById('rating')
        let biz = document.getElementById('biz_name')
        let autocomplete = new google.maps.places.Autocomplete(places);
        autocomplete.addListener('place_changed', function() { 
            let place = autocomplete.getPlace(); 
          //  console.log(place)
        /* fill the form fields */
            let adrArr = place.formatted_address.split(',')
            let cidArr = place.url.split('=')
            let stateZip = adrArr[2].split(' ')
            @this.set('form.biz', place.name )
            @this.set('form.addr', adrArr[0])
            @this.set('form.city', adrArr[1])
            @this.set('form.state', stateZip[1])
            @this.set('form.zip', stateZip[2])
            @this.set('form.loc_phone', place.formatted_phone_number)
            @this.set('form.type', place.types[0])
            @this.set('form.PID', place.place_id)
            @this.set('form.CID', cidArr[1])
            if(place.user_ratings_total){
                @this.set('form.ttl', place.user_ratings_total)
            }else   
            @this.set('form.ttl', 0)
            if(place.rating){
                @this.set('form.rate', place.rating)
            }else   
            @this.set('form.rate', 0)  
            document.getElementById('placeInput').value = ''   
                 
        }); 
    }
 </script>  
</x-filament-panels::page>
