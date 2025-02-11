<?php

namespace App\Models;

use Filament\Forms\Get;
use Filament\Forms\Components\Radio;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
    use HasFactory;
    public $table = 'contact';
    protected $fillable = [       
        'users_id', 
        'company',
        'ctc_phone',
        'ctc_mobile',
        'min_rate',
        'multi_loc',
        'loc_qty',
        'loc_to_add'
    ];
    public function users(){
        return $this->belongsTo(User::class, 'users_id');
    }
    public function subscriptions(){
        return $this->hasMany(Subscription::class, 'user_id', 'users_id');
    }
    public function locations(){
        return $this->hasMany(Location::class, 'users_id', 'users_id');
    }
    // public function customers(){
    //     return $this->hasMany(Customer::class);
    // }

    public static function getForm(): array{
        return[
            Hidden::make('users_id')
                ->default(Auth::id()),    
            Section::make('Your Business Info')                
                ->schema([    
                TextInput::make('company')
                    ->label('Company Name')
                    ->columnSpan(2)
                    ->required()
                    ->markAsRequired(false) 
                    ->maxLength(50),                            
                TextInput::make('ctc_phone')
                    ->label('Your Contact Phone')
                    ->mask('(999) 999-9999')
                    ->tel()
                    ->maxLength(20)
                    ->markAsRequired(false) 
                    ->required(),
                TextInput::make('ctc_mobile')
                    ->label('Your Cell (optional)')
                    ->mask('(999) 999-9999')
                    ->tel()
                    ->maxLength(20)
                    ->default(null),
                ])
                ->columns(2),
                
                Section::make('Google Business Profile locations')
                    ->description('Each location will have its own subscription')                     
                    ->schema([     
                    Radio::make('multi_loc')
                        ->label('Do you have more than one GBP?')
                        //->helperText('Do you have multiple Google Business Profile locations?')
                        //->columnSpan(2)
                        ->inline()
                        ->boolean()  
                        ->live()              
                        ->default(false),
                    // TextInput::make('loc_qty')
                    //     ->label('How many GPB locations do you have?')
                    //     ->hidden(fn (Get $get): bool => ! $get('multi_loc'))
                    //     ->numeric()
                    //     ->default(1),
                    ]),
                //->columns(2),
                
                Section::make('Review Control') 
                ->description('Feedback that is less than the minimum review rating is kept private')  
                ->schema([ 
                    TextInput::make('min_rate')
                    ->label('Minimum review rating for posting')
                  //  ->extraInputAttributes(['class' => 'w-16'])          
                //    ->numeric()
                    ->required()
                    
                    ->default(3), 
                ])
            
        ];
    }
}
