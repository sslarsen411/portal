<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerEmail extends Model
{
    use HasFactory;
    protected $fillable = [
        'users_id',
        'customers_id',
        'responded',
        'type',
        'sent',
        'opened',
    ];
    public function users()    {
        return $this->belongsTo(User::class);
    }
    public function customers()    {
        return $this->belongsTo(Customer::class);
    }
}