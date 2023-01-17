<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        "invoice_no",
        "user_id",
        "plan_id",
        "amount",
        "will_expire",
        "is_trial",
        "meta",
        "status",
        "payment_status",
    ];

    protected $casts = [
        'meta' => 'json'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Subscription::max('id') + 1;
            $model->invoice_no = str_pad(Subscription::max('id') + 1, 7, '0', STR_PAD_LEFT);
        });

       /* static::created(function ($model){
            $user = User::whereRole('admin')->first();

            $user->notify(new SubscriptionNotification($model));
        });*/
    }

    /**
     * Get an attribute from the model.
     * Override original function to get meta value dynamically
     * @param  string  $key
     * @return mixed
     */
    public function getAttribute($key): mixed
    {
        $attribute = parent::getAttribute($key);

        if ($attribute === null && array_key_exists($key, $this->meta ?? [])) {
            return $this->meta[$key];
        }

        return $attribute;
    }
}
