<?php

namespace App\Livewire;

use App\Models\User;
use App\Rules\NamePlus;
use Livewire\Component;
use Filament\Forms\Form; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Auth\Events\Registered;
use Filament\Forms\Components\Fieldset; 
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password; 
use Filament\Forms\Concerns\InteractsWithForms;

class RegisterClient extends Component implements HasForms
{
    use InteractsWithForms;
    
     public ?array $data = [];
  
    
    public function mount(): void
    {
        $this->form->fill();
    }
    public function form(Form $form){
        return $form
        ->schema([ 
            Fieldset::make('Enter your contact info')        
            ->schema(components: User::getForm()) 
        ])
        ->statePath('data');
    }
    
    public function create(){
        $form_data = $this->form->getState();  
     
        $validated_pass = Validator::make(            
            ['password' => $form_data['password']],
          //  ['password' => Password::min(8)->mixedCase()->numbers()->symbols()],
            ['password' => Password::min(8)],
            ['required' => 'The :attribute field is required'],
        )->validate();
       
    // /* Clean up */
        $form_data['name'] = strip_tags($form_data['name']);
        $form_data['company'] = strip_tags($form_data['company']);
        $form_data['role'] = 'client';
        unset($form_data['password_confirmation']);
        $form_data['password'] = Hash::make($validated_pass['password']); 
    ray($form_data);
         event(new Registered($user = User::create($form_data)));
         Auth::login($user);
        $this->redirect(route('subscribe.locations', absolute: false), navigate: true);
    }
    public function render()
    {
        return view('livewire.register-client');
    }
}
