<?php

namespace App\Filament\Pages;

use App\Models\Location;
use Filament\Pages\Page;
use Laravel\Cashier\Cashier;
use Livewire\Attributes\On;
use App\Subscription\StripeSubscriptionDecorator;

class Billing extends Page
{
    protected static ?string $navigationIcon = 'lineawesome-file-invoice-dollar-solid';

    protected static string $view = 'filament.pages.billing';
    protected static ?string $navigationLabel = 'Subscription';
    protected static ?int $navigationSort = 3;
    protected ?string $heading = 'Manage Your Subscription';
    protected static ?string $navigationGroup = 'Account';

    // public $usr;
    public $user;
   public $nextCharge;
    public $plan;
    public $price;
    public $status;
    public $invoices;
    //public $stripe;
    public function mount() {
        $this->user = Cashier::findBillable( session('stripe.customer'));
      // ray( session()->all());
        $this->price = session('stripe.plan.amount') / 100;
        $this->invoices = $this->user->invoicesIncludingPending()->toArray();
        $this->nextCharge = session('trial_end');
        $this->status = match(session('stripe.status') ){
            'active'   => 'Active',
            'trialing' => 'In 14-day Free Trial',
            'canceled' => 'Canceled',
            default    => 'Past Due',
        };
    }
    public function sendConfirm(){
        $this->dispatch('clientConfirm');
    }
    #[On('clientConfirmAction')]
    public function clientConfirmAction (){
        $this->cancelSub();
    }
    #[On('makeActionCancel')]
    public function clientCancelAction (){
        return back();
    }
    public function cancelSub() {
          ray('canceling')  ;
          auth()->user()->subscription('std')->cancel();
       // $this->user->cancel();
        $this->status = 'Canceled';
        $this->dispatch ('canceled');
    }
    public function resumeSubscription() {
        auth()->user()->subscription('std')->resume();;
        $this->status = 'Active';
        $this->dispatch ('resumed');
    }
}
