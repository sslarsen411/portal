<x-filament-panels::page>
 
  <div  w-full class="col-[--col-span-default]">
    <section  class="fi-section fi-aside grid grid-cols-1 items-start gap-x-6 gap-y-4 md:grid-cols-3 my-4" id="data.profile-information">
          <header class="fi-section-header flex flex-col gap-3">
              <div class="flex items-center gap-3">
                  <div class="grid flex-1 gap-y-1">
                    <h3 class="fi-section-header-heading text-xl font-semibold leading-6 text-gray-950 dark:text-white">
                      Your Subscription
                    </h3>
                    <p class="fi-section-header-description overflow-hidden break-words text-sm text-gray-500 dark:text-gray-400">
                      Details
                    </p>
                  </div>
              </div>
          </header>
          <div class="fi-section-content-ctn rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 md:col-span-2">             
            <div class="p-6 space-y-2 w-3/4 mx-auto ">
              <dl class="flex items-center justify-between gap-4">
                <dt class="text-gray-500">Plan</dt>
                <dd class="text-base font-medium text-gray-900 ">Two Shakes Review Standard</dd>
              </dl>        
              <dl class="flex items-center justify-between gap-4">
                <dt class="text-gray-500">Price</dt>
                <dd class="text-base font-medium text-gray-900">$ {{ $price }} per month, per location</dd>
              </dl>        
              <dl class="flex items-center justify-between gap-4 border-b">
                <dt class="text-gray-500">Subscribed Locations</dt>
                <dd class="text-base font-medium text-gray-900 ">{{ auth()->user()->loc_qty}} </dd>
              </dl>        
              <dl class="flex items-center justify-between gap-4  mt-8">
                <dt class="text-xl text-red-900">Subscription total</dt>
                <dd class="text-xl font-semibold text-gray-900 ">${{ auth()->user()->loc_qty * $price }} per month</dd>
              </dl>
              <dl class="flex items-center justify-between gap-4 mt-4 important">
                <dt class="text-lg  text-gray-500">Next Charge Date</dt>
                <dd class="text-lg text-right font-medium text-gray-900 ">
                    {{ date('M d Y', $nextCharge)}} 
                    <span class="block text-sm">You&apos;ll be charged then  unless you cancel</span>
                </dd>
              </dl>                        
              <dl class="flex items-center justify-between gap-4 !mt-4">
                <dt class="text-lg  text-gray-500">Current Account Status</dt>
                <dd class="text-lg text-right font-medium text-gray-900 ">
                    {{  $status }} 
                    
                </dd>
              </dl>                        
            </div>                          
        </div>
    </section>
    <section  class="fi-section fi-aside grid grid-cols-1 items-start gap-x-6 gap-y-4 md:grid-cols-3 my-4" id="data.profile-information">
      <header class="fi-section-header flex flex-col gap-3">
        <div class="flex items-center gap-3">
          <div class="grid flex-1 gap-y-1">
            <h3 class="fi-section-header-heading text-xl font-semibold leading-6 text-gray-950 dark:text-white">
              Your Invoices
            </h3>
            <p class="fi-section-header-description overflow-hidden break-words text-sm text-gray-500 dark:text-gray-400">
              Charges to your account
            </p>            
          </div>
        </div>
      </header>
      <div class="fi-section-content-ctn rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 md:col-span-2">	
        <div class="p-6 ">	
          <div class="grid grid-cols-1 items-start justify-between gap-x-6 gap-y-2 md:grid-cols-3">
            <div class="font-bold">Date Issued</div>
            <div class="font-bold">Amount</div>
            <div class="font-bold">Download Invoice</div>
          @foreach ($invoices as $invoice)          
              <div>{{ date('M d Y', $invoice['created']) }}</div>
              <div class="text-right">$ {{number_format(($invoice['total']/100), 0, '.', ' ') }}</div>
                <div class="text-right">
                  <x-filament::button
                  href="{{ $invoice['invoice_pdf'] }}"
                  tag="a"
                  color="teal"
                    icon="lineawesome-file-download-solid"
              >
              Download
              </x-filament::button>  </div>             
          @endforeach
          </div>
        </div>   
      </div>  
    </section>
    <section  class="fi-section fi-aside grid grid-cols-1 items-start gap-x-6 gap-y-4 md:grid-cols-3 my-4" id="data.profile-information">
      <header class="fi-section-header flex flex-col gap-3">
        <div class="flex items-center gap-3">
          <div class="grid flex-1 gap-y-1">
            <h3 class="fi-section-header-heading text-xl font-semibold leading-6 text-gray-950 dark:text-white">
              Payment Portal
            </h3>
            <p class="fi-section-header-description overflow-hidden break-words text-sm text-gray-500 dark:text-gray-400">
              Update your payment method, etc.
            </p>
            {{-- <p class="fi-section-header-description overflow-hidden break-words text-xs text-gray-500 dark:text-gray-400">
              (opens in a new tab)
            </p> --}}
          </div>
        </div>
      </header>
      <div class="fi-section-content-ctn rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 md:col-span-2">	
        <div class="p-6 ">	
          <div class="flex items-center gap-x-3 justify-between ">
            <p>
              Manage your subscription:
            </p>
            <x-filament::button
            href="/portal"
            tag="a"
            color="teal"
              icon="lineawesome-money-bill-wave-solid"
        >
           Stripe Payment Portal
        </x-filament::button>  
        </div>   
      </div>  
    </section>
    <section  class="fi-section fi-aside grid grid-cols-1 items-start gap-x-6 gap-y-4 md:grid-cols-3 my-4" id="data.profile-information">
      @if ($status === 'Canceled')
      <header class="fi-section-header flex flex-col gap-3">
        <div class="flex items-center gap-3">
          <div class="grid flex-1 gap-y-1">
            <h3 class="fi-section-header-heading text-xl font-semibold leading-6 text-gray-950 dark:text-white">
              Resume your subscription
            </h3>
            <p class="fi-section-header-description overflow-hidden break-words text-xs text-gray-500 dark:text-gray-400">
              Restore your subscription to active status.
            </p>
             
          </div>
        </div>
      </header>
      <div class="fi-section-content-ctn rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 md:col-span-2">	
        <div class="p-6 ">	
          <div class="flex items-center gap-x-3 justify-between ">
            <p>
              Reactivate your subscription
            </p>
            <div >	
              <x-filament::button
              wire:click="resumeSubscription"
              color="success"
              icon="heroicon-o-x-circle"            
          >
            Resume subscription
          </x-filament::button>  
        </div>   
      </div> 
      @else
      <header class="fi-section-header flex flex-col gap-3">
        <div class="flex items-center gap-3">
          <div class="grid flex-1 gap-y-1">
            <h3 class="fi-section-header-heading text-xl font-semibold leading-6 text-gray-950 dark:text-white">
              Cancel your subscription
            </h3>
            <p class="fi-section-header-description overflow-hidden break-words text-xs text-gray-500 dark:text-gray-400">
              WARNING: Download your data <strong>before</strong> you cancel.
            </p>
             
          </div>
        </div>
      </header>
      <div class="fi-section-content-ctn rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 md:col-span-2">	
        <div class="p-6 ">	
          <div class="flex items-center gap-x-3 justify-between ">
            <p>
              One-click cancel
            </p>
            <div >	
              <x-filament::button
              wire:click="sendConfirm"
              color="danger"
              icon="heroicon-o-x-circle"            
          >
            Cancel subscription
          </x-filament::button>  
        </div>   
      </div>  
      @endif
    </section>

  </div>       
</x-filament-panels::page>
<script src=" /js/filament/sweetalert2.all.min.js"></script>
<script>
  window.addEventListener('clientConfirm', (event) => {
    Swal.fire({
        icon:"warning",
        title: "Cancel Your Subscription",
        html: "Confirm to cancel your subscription. You will not be charged again. Your data will be deleted.",
        showConfirmButton: true,
        showCancelButton: true,
        confirmButtonColor: '#FACA15',
        cancelButtonColor: '#046C4E',
        confirmButtonText: 'Yes, cancel my subscription',
        cancelButtonText: 'No, keep my subscription',
    })
    .then((result) => {
        if (result.isConfirmed) {
            Livewire.dispatch('clientConfirmAction');
        } else {
            Livewire.dispatch('makeActionCancel');
        }
    });
})
  window.addEventListener('canceled', event => {    
      console.log('Canceled subscription')
      Swal.fire({
          title: "Your subscription has been canceled",
          {{-- text: "Just paste and post it", --}}
          icon: "success"
      })
  });
  window.addEventListener('resumed', event => {    
      console.log('restored subscription')
      Swal.fire({
          title: "Your subscription has reactivated", 
          icon: "success"
      })
  });
</script>
 