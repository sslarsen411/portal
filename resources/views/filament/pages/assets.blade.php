<x-filament-panels::page>
    <p>
        Make access to the Two Shakes Web App <em>easy</em> for your customers.
    </p>
    <div style="--col-span-default: 1 / -1;" class="col-(--col-span-default)">
        <section  class="fi-section fi-aside grid grid-cols-1 items-start gap-x-6 gap-y-4 md:grid-cols-3 my-4" id="data.profile-information">
            <header class="fi-section-header flex flex-col gap-3">
                <div class="flex items-center gap-3">
                    <div class="grid flex-1 gap-y-1">
                        <h3 class="fi-section-header-heading text-xl font-semibold leading-6 text-gray-950 dark:text-white">
                          Location Links
                        </h3>
                        <p class="fi-section-header-description overflow-hidden break-words text-sm text-gray-500 dark:text-gray-400">
                          Add to your website, signage,<br />>cards, customer email, etc.
                        </p>
                    </div>
                </div>
            </header>
            <div class="fi-section-content-ctn rounded-xl bg-white shadow-xs ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 md:col-span-2">		
                <div class="p-6 ">	  
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th></th>
                                    <th scope="col" class="px-6 py-3">
                                    Location
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Short Link
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                       Link QR Code
                                    </th>                                    
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($this->getLink() as $link)                                
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td>{{ $i + 1}}</td>
                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $this->addrArr[$i] }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="https://twsk.link/{{ $link }}" target="_blank">https://twsk.link/{{ $link }}</a>
                                    <td class="px-6 py-4">
                                        <img class="inline h-16 w-16" src="{{ $this->getQR('https://twsk.link/'. $link) }}" alt="QR Code" />
                                    </td>
                                </tr>
                                @php
                                    $i++;
                                @endphp
                                @endforeach                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>        
        </section>
        <section  class="fi-section fi-aside grid grid-cols-1 items-start gap-x-6 gap-y-4 md:grid-cols-3 my-4" id="data.profile-information">
            <header class="fi-section-header flex flex-col gap-3">
                <div class="flex items-center gap-3">
                    <div class="grid flex-1 gap-y-1">
                        <h3 class="fi-section-header-heading text-xl font-semibold leading-6 text-gray-950 dark:text-white">
                          &ldquo;Rate Us&rdquo; Signage
                        </h3>
                        <p class="fi-section-header-description overflow-hidden break-words text-sm text-gray-500 dark:text-gray-400">
                            8x10
                        </p>
                    </div>
                </div>
            </header>
            <div class="fi-section-content-ctn rounded-xl bg-white shadow-xs ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 md:col-span-2">		
                <div class="p-6 ">	  
                    <div class="relative overflow-x-auto">
                        PDF
                    </div>
                </div>
            </div>        
        </section>     
        <section  class="fi-section fi-aside grid grid-cols-1 items-start gap-x-6 gap-y-4 md:grid-cols-3 my-4" id="data.profile-information">
            <header class="fi-section-header flex flex-col gap-3">
                <div class="flex items-center gap-3">
                    <div class="grid flex-1 gap-y-1">
                        <h3 class="fi-section-header-heading text-xl font-semibold leading-6 text-gray-950 dark:text-white">
                          Order Review Cards, NFC tags
                        </h3>
                        <p class="fi-section-header-description overflow-hidden break-words text-sm text-gray-500 dark:text-gray-400">
                            Make it easy for your customers
                        </p>
                        <img class="h-32 mx-auto" src="{{ asset('https://cdn.mojoimpact.com/twoshakes/card.png')}}" alt="Feedback card" />
                    </div>
                </div>
            </header>
            <div class="fi-section-content-ctn rounded-xl bg-white shadow-xs ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 md:col-span-2">		
                <div class="p-6 ">	  
                    <div class="relative overflow-x-auto">
                        FORM
                    </div>
                </div>
            </div>        
        </section>     
    </div>
</x-filament-panels::page>
{{--  https://www.androidauthority.com/nfc-tags-explained-271872/ --}}
