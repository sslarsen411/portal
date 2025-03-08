<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Fieldset;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;
    public $table = 'customers';
    protected $fillable = [
        'users_id',
        'location_id',
        'oauth_provider',
        'oauth_uid',
        'first_name',
        'last_name',
        'email',
        'phone',
        'purchase',
        'state',
    ];
    public function users(): belongsTo    {
        return $this->belongsTo(User::class);
    }
    public function locations(): belongsTo    {
        return $this->belongsTo(Location::class, 'location_id');
    }
    public function reviews(): hasMany    {
        return $this->hasMany(Review::class, 'customer_id');
    }
    public function emails(): hasMany    {
        return $this->hasMany(CustomerEmail::class, 'customer_id');
    }
    public function getFullnameAttribute(): string
    {
        return $this->first_name.' '.$this->last_name;
    }
    public static function getForm(): array{
        return [
            Hidden::make('users_id')
                ->default(Auth::id()),
            TextInput::make('oauth_provider')
                ->hidden()
                ->default('none'),
            TextInput::make('oauth_uid')
                ->hidden()
                ->maxLength(45)
                ->default(null),
            Fieldset::make('Contact Info')
                ->schema([
                    TextInput::make('first_name')
                        ->maxLength(45)
                        ->default(null),
                    TextInput::make('last_name')
                        ->maxLength(45)
                        ->default(null),
                    TextInput::make('email')
                        ->email()
                        ->maxLength(45)
                        ->default(null),
                    TextInput::make('phone')
                        ->tel()
                        ->maxLength(12)
                        ->default(null),
                ]),
                TextInput::make('purchase')
                ->label('Purchase')
                ->default(null),

        ];
    }
}
