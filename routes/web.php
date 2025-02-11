<?php

use Livewire\Volt\Volt;
// use Illuminate\Http\Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\AutoController;
use App\Http\Middleware\ActiveSubscriber;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\SubscriptionController;


Route::view('/places', 'places')->name('places');
Route::view('/place', 'place')->name('place');

Route::middleware('guest')->group(function () {
    Volt::route('/', 'pages.auth.login')
        ->name('login');
    });
Route::get('/getLO',function () { 
        Auth::guard('web')->logout();
        Session::invalidate();
        Session::regenerateToken();
       return redirect('login');
})->name('getLO');

Route::get('/portal', [SubscriptionController::class, 'portal'])
->middleware([ActiveSubscriber::class])
->name('subscription.portal');
// Route::get('/cancel', [SubscriptionController::class, 'cancel'])
// ->middleware([ActiveSubscriber::class])
// ->name('subscription.cancel');
Route::get('/resume', [SubscriptionController::class, 'resume'])
->middleware([ActiveSubscriber::class])
->name('subscription.resume');

Route::get('/billing-portal', function (Request $request) {
    return $request->user()->redirectToBillingPortal('admin.billing');
})->name('billing-portal');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
