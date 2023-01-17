<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class ProductOrder extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function gateway(): BelongsTo
    {
        return $this->belongsTo(Gateway::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = ProductOrder::max('id') + 1;
            $model->uuid = Str::uuid()->toString();
            $model->token = now()->timestamp.Str::random(30);
            $model->invoice_no = str_pad($model->id, 7, '0', STR_PAD_LEFT);
        });

    }
}
