<?php

namespace App\Models;


use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{


    public $table = 'locations';
    protected $fillable = [
        'users_id',
        'addr',
        'city',
        'state',
        'zip',
        'loc_phone',
        'loc_email',
        'CID',
        'PID',
        'status',
        'init_rate',
        'init_rct',
    ];

    public function users(){
        return $this->belongsTo(User::class, 'users_id');
    }
    public function links(){
        return $this->hasOne(LocationLink::class);
    }
    public function customers(){
        return $this->hasMany(Customer::class);
    }
    public function reviews(){
        return $this->hasMany(Review::class);
    }
    public static function getForm(): array{
        return[
            Hidden::make('users_id')
            ->default(Auth::id()),
            Section::make('Location Info. All fields are required.')
                ->schema([
                TextInput::make('addr')
                    ->label('Street address')
                    ->columnSpan(4)
                    ->required()
                    ->markAsRequired(false)
                    ->maxLength(50),
                TextInput::make('city')
                    ->label('City')
                    ->string()
                    ->required()
                    ->markAsRequired(false)
                    ->maxLength(50)
                    ->default(null),
                TextInput::make('state')
                    ->label('State')
                    ->string()
                    ->required()
                    ->markAsRequired(false)
                    ->maxLength(2)
                    ->default(null),
                TextInput::make('zip')
                    ->label('Zip code')
                    ->required()
                    ->markAsRequired(false)
                    ->maxLength(5),

                TextInput::make('loc_phone')
                    ->label('Location phone')
                    ->mask('(999) 999-9999')
                    ->maxLength(45)
                    ->markAsRequired(false)
                    ->required(),
                ])
                ->columns(4),
                Section::make('Google Business Profile Info')
                ->description('You can add these from the dashboard if you don\'t have the info handy')
                ->schema([
                    TextInput::make('CID')
                    ->label('Ludocid (GBP PID)')
                    ->minLength(18)
                    ->required()
                 //   ->markAsRequired(false)
                    ->maxLength(50)
                    ->default(null),
                    TextInput::make('PID')
                    ->label('Places ID')
                    ->minLength(27)
                    ->required()
                //    ->markAsRequired(false)
                    ->maxLength(50)
                    ->default(null),
                TextInput::make('init_rate')
                    ->label('Initial review rating')
                    ->required()
                    ->markAsRequired(false)
                    ->maxLength(4)
                    ->default(null),
                TextInput::make('init_rct ')
                    ->label('Initial review count')
                    ->maxLength(10)
                    ->markAsRequired(false)
                    ->required(),
                ])
                ->columns(2),

        ];
    }
}
