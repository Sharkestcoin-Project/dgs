<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayoutMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'currency_id',
        'name',
        'image',
        'min_limit',
        'max_limit',
        'delay',
        'fixed_charge',
        'percent_charge',
        'data',
        'currency_id',
        'instruction',
        'status',
        'image',
    ];

    public function usermethod()
    {
        return $this->hasOne(UserPayoutMethod::class)->where('user_id', auth()->id());
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
