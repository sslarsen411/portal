<?php

namespace App\Livewire;

use App\Models\User;
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

class RegisterUser extends Component implements HasForms
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
            Fieldset::make('Enter your full name, email, and create a password')        
            ->schema(components: User::getForm()) 
        ])
        ->statePath('data');
    }
    
    public function create(){
        $form_data = $this->form->getState();  

        $validated = Validator::make(            
            ['password' => $form_data['password']],
          //  ['password' => Password::min(8)->mixedCase()->numbers()->symbols()],
            ['password' => Password::min(8)],
            ['required' => 'The :attribute field is required'],
        )->validate();
        
    /* Clean up */
        $form_data['name'] = strip_tags($form_data['name']);
        unset($form_data['password_confirmation']);
         $form_data['password'] = Hash::make($validated['password']); 

        event(new Registered($user = User::create($form_data)));
        Auth::login($user);
        $this->redirect(route('subscribe.business', absolute: false), navigate: true);
    }
    public function render(){
        return view('livewire.register-user');
    }
}
