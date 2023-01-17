<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    use HasFactory;

    protected $casts = [
        'meta' => 'json'
    ];

    protected $fillable = [
        'name',
        'price',
        'duration',
        'status',
        'description',
        'meta',
    ];

    public static function features(): array
    {
        return [
            'withdraw_charge' => [
                'type' => 'number',
                'value' => 0,
                'required' => true,
                'note' => '%'
            ],
//            'commission' => [
//                'type' => 'number',
//                'value' => 0,
//                'max' => 100,
//                'required' => true,
//                'note' => '%'
//            ],
            'product_limit' => [
                'type' => 'number',
                'value' => 1,
                'required' => true
            ],
            'subscription_plan_limit' => [
                'type' => 'number',
                'value' => 1,
                'required' => true
            ],
            'sell_subscription' => [
                'type' => 'option',
                'value' => ['Yes' => "1", 'No' => "0"],
                'required' => true
            ],
            'max_file_size' => [
                'type' => 'number',
                'value' => 0,
                'required' => true,
                'note' => 'File Limit in MB'
            ],
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function active_orders(): HasMany
    {
        return $this->hasMany(Order::class)->whereStatus(1)->where('will_expire', '>=', today());
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
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
