<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Filament\Pages\Dashboard;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;
    /**
     * Handle an incoming authentication request.
     */
   #[Validate('required|min:3')] 
   public $email = '';
 
 #[Validate('required|min:3')] 
 public $password = '';
    public function login(): void
    {
        $this->validate();
        $this->form->authenticate();
        Session::regenerate();
       // ray(auth()->user()->stripe_id);
        if(auth()->user()->stripe_id !== null){             
            $stripe =  once(function ()  {
                return auth()->user()->subscription('std')->asStripeSubscription();
            });
            session()->put('stripe', $stripe);
        }
        
     //   ray(session()->all());
        $this->redirect(Dashboard::getUrl());
    }
}; ?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <form wire:submit="login">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="form.email" id="email" class="block mt-1 w-full" type="email" name="email" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>
        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input wire:model="form.password" id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>
        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox" class="rounded-sm border-gray-300 text-indigo-600 shadow-xs focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Stay signed in') }}</span>
            </label>
        </div>
        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-hidden focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}" wire:navigate>
                    {{ __('Forgot your password?') }}
                </a>
            @endif
            <x-primary-button class="bg-indigo-900 hover:bg-violet-800 ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
        {{-- <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-hidden focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('subscribe.start') }}">
                {{ __('Not registered?') }}
            </a>    
        </div> --}}
    </form>
</div>
