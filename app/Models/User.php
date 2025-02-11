<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Filament\Forms\Set;
use Laravel\Cashier\Billable;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\HasPermissionsTrait;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, Billable, HasPermissionsTrait;
    public function canAccessPanel(Panel $panel): bool
    {
        return TRUE;
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'company',
        'phone',
        'mobile',
        'min_rate',
        'multi_loc',
        'loc_qty',
        'support_email',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function locations()    {
        return $this->hasMany(Location::class, 'users_id');
    }
    public function links()    {
        return $this->hasMany(LocationLink::class, 'users_id');
    }
    public function customers()    {
        return $this->hasMany(Customer::class, 'users_id');
    }
    public function reviews()    {
        return $this->hasMany(Review::class, 'users_id');
    }
    public function roles()    {
      //  return $this->hasMany(Role::class,  'users_roles');
        return $this->belongsToMany(Role::class, 'users_roles', 'user_id', 'role_id');
    }


    public static function getForm(): array{
        return [
            TextInput::make('name')
                ->label('Full Name')
                ->autocomplete('new-name')
                ->required()
                ->string()
                ->markAsRequired(false)
                ->maxLength(50),
            TextInput::make('email')
                ->email()
                ->autocomplete('new-email')
                ->required()
                ->regex('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/i')
                ->markAsRequired(false)
                ->maxLength(45),
            TextInput::make('phone')
                ->label('Your Contact Phone')
                ->tel()
                ->mask('(999) 999-9999')
                ->maxLength(20)
                ->markAsRequired(false)
                ->required(),
            TextInput::make('mobile')
                ->label('Your Cell (optional)')
                ->mask('(999) 999-9999')
                ->tel()
                ->maxLength(20)
                ->default(null),
            Fieldset::make('Create a password')
                ->schema([
                TextInput::make('password')
                    ->password()
                    ->autocomplete('new-password')
                    ->revealable()
                    ->confirmed()
                    ->required(),
                TextInput::make('password_confirmation')
                    ->password()
                    ->autocomplete('new-password')
                    ->required()
                    ->revealable()
                    ->same('password')
                    ->label('Confirm Password'),
            ]),
            Fieldset::make('Your Business Info')
                ->schema([
                TextInput::make('company')
                    ->label('Company Name')
                    ->required()
                    ->markAsRequired(false)
                    ->maxLength(50),
                TextInput::make('support_email')
                ->label('Customer Support email')
                ->email()
                ->autocomplete('new-email')
                ->required()
                ->regex('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/i')
                ->markAsRequired(false)
                ->maxLength(45),
                TextInput::make('loc_qty')
                    ->label('Number of Google Business Profile locations')
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('price', $state * 150 ))
                 //   ->default('1')
                    ->required()
                    ->markAsRequired(false)
                    ->numeric(),

                TextInput::make('price')
                    ->label('Total subscription price / month')
                    ->disabled()
                    ->prefixIcon('heroicon-o-currency-dollar')
                    //->default('150'),
                ]),
                Fieldset::make('Minimum Review Threshold')
                ->schema([
                    TextInput::make('min_rate')
                    ->label('Minimum rating stars')
                    ->helperText('* Ratings less than the minimum are kept private.')
                    ->required()
                    ->default(3),
                ])
        ];
    }
}
