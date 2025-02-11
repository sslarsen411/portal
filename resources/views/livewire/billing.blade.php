<?php

use Livewire\Volt\Component;
use Laravel\Cashier\Cashier;
use Stripe\Subscription;
use Filament\Pages\Dashboard;
use Carbon\Carbon;

//use App\Subscription\StripeSubscriptionDecorator;

new class extends Component {
    
    public $usr;
    public $user;
    public $stripe;
   public $nextCharge;
    public $plan;
    public $now;
    public function mount() {
        $this->usr = auth()->user();
        $this->user = Cashier::findBillable($this->usr->stripe_id);
        $this->nextCharge = $this->user->subscription('std')->trial_ends_at;
        $this->stripe =  auth()->user()->subscription('std')->asStripeSubscription()->toArray();
        $this->now = Carbon::now();
      //  ray($this->now);
        //ray(abs(round(Carbon::parse($this->nextCharge)->diffInDays($this->now), 0)));
   //     ray( $this->now->longAbsoluteDiffForHumans($this->nextCharge));
       // $invoices = $this->user->findInvoice($this->stripe['latest_invoice']);
       // ray($this->user);
     //   ray($invoices );
    }
   public function getPortal(){    
    return $this->user->billingPortalUrl(route('billing'));
   }
   
  
}; 
?>
<x-filament::section>    
    <x-slot name="heading">
        <h2 class="text-3xl">Congratulations!</h2>
        <h3 class="text-xl mt-4">You can now refer your customers to the Two Shakes Web App</h3>
    </x-slot>   
    <div>
        <h2 class="text-2xl my-4">Next Steps&hellip;</h2>
        <ul class="space-y-3 list-disc indent-1 ml-8">
            <li>Go to the Assets page for your links, QR codes, templates and more</li>
            <li>Watch the onboarding video to familiarize yourself with the Two Shakes Portal</li>
            <li>Send customers to the application</li>
        </ul>        
    </div>
    <div class="m-12 space-y-4 bg-stone-100 p-8 pb-16 rounded-xl ">
        <h3 class="text-2xl">Subscription Details</h3>
        <div class="space-y-2 w-3/4 mx-auto">
          <dl class="flex items-center justify-between gap-4">
            <dt class="text-gray-500">Plan</dt>
            <dd class="text-base font-medium text-gray-900 dark:text-white">Two Shakes Review Standard</dd>
          </dl>

          <dl class="flex items-center justify-between gap-4">
            <dt class="text-gray-500">Price</dt>
            <dd class="text-base font-medium text-gray-900">$150 per month, per location</dd>
          </dl>

          <dl class="flex items-center justify-between gap-4">
            <dt class="text-gray-500">Subscribed Locations</dt>
            <dd class="text-base font-medium text-gray-900 dark:text-white">{{ $this->usr->loc_qty}} </dd>
          </dl>

          <dl class="flex items-center justify-between gap-4 border-t mt-4">
            <dt class="text-lg text-gray-500">Subscription total</dt>
            <dd class="text-lg font-medium text-gray-900 dark:text-white">${{ $this->usr->loc_qty * 150 }} / month</dd>
          </dl>
          <dl class="flex items-center justify-between gap-4">
            <dt class="text-lg text-gray-500">Your trial ends</dt>
            <dd class="text-lg font-medium text-gray-900 dark:text-white">
                {{ $this->nextCharge->toFormattedDateString() }} 
                {{-- <span class="text-sm">({{ $this->nextCharge->diffForHumans($this->now)}})</span> --}}
            </dd>
          </dl>
          {{-- <x-primary-link-button class="bg-slate-700 float-right my-4" href="{{ $this->getPortal()  }}">
            Manage Subscription
        </x-primary-link-button> --}}
        <x-primary-link-button class="bg-slate-700 float-right my-4" href="{{ route('subscription.portal') }}">
            Manage your subscription
        </x-primary-link-button>
        </div>
    </div>
    <div class="mt-8">
        <h3 class="text-xl">Links to admin portals</h3>
        <div class="flex flex-row w-1/2 mx-auto items-center justify-between">
            <x-primary-link-button class="bg-emerald-700" href="{{ Dashboard::getUrl() }}">
                Dashboard
            </x-primary-link-button>
            {{-- <p class="block mt-4">Link to your payment portal</p> --}}
           
        </div>
    </div>
</x-filament::section>

