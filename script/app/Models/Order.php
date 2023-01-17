<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public static function boot()
    {

        parent::boot();
        static::creating(function ($model) {
            $model->id = Order::max('id') + 1;
            $model->invoice_no = str_pad($model->id, 7, '0', STR_PAD_LEFT);
        });

        // static::created(function ($model){
        //     Transaction::create([
        //         'user_id' => $model->user_id,
        //         'order_id' => $model->id,
        //         'type' => 'payment',
        //         'amount' => $model->price,
        //     ]);
        // });
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function gateway(): BelongsTo
    {
        return $this->belongsTo(Gateway::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
