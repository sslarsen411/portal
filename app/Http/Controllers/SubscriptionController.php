<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Filament\Pages\Billing;
use RealRashid\SweetAlert\Facades\Alert;
use Laravel\Cashier\Exceptions\IncompletePayment;

class SubscriptionController extends Controller
{
    public function create(Request $request){       
        try {
            $subscription = auth()->user()->newSubscription('std', $request->plan)           
                ->trialDays(14)
                ->quantity($request->loc_qty)
                ->create($request->paymentMethod);
            //ray($subscription);
        } catch (IncompletePayment $exception) {
            Alert::error('Payment Failed');   
            return redirect()->route(
                'cashier.payment',
                [$exception->payment->id, 'redirect' => route('subscribe.subscribe')]
            );
        }           
        Alert::success('Subscribed Successful', 'Start boosting your reviews');   
        return redirect()->route('subscribe.finish');
    }
    public function portal(Request $request){
        return $request->user()->redirectToBillingPortal(url(Billing::getUrl()));
    }
   
}
