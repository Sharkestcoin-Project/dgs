<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        "name",
        "username",
        "phone",
        "email",
        "role",
        "plan_id",
        "plan_meta",
        "will_expire",
        "status",
        "password",
        "token",
        "meta",
        "avatar",
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'meta' => 'json',
        'plan_meta' => 'json'
    ];

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function sales(): HasMany
    {
        return $this->hasMany(ProductOrder::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class, '');
    }

    public function plans()
    {
        return $this->hasMany(UserPlan::class);
    }

    public function customers()
    {
        return $this->orders->groupBy(['email']);
    }

    public function getIsTrialEnrolledAttribute(): bool
    {
        return Auth::user()->subscriptions()->where('is_trial', 1)->exists();
    }

    public function getIsFreeEnrolledAttribute(): bool
    {
        return Auth::user()->subscriptions()->where('amount', '=', -1)->orWhere('amount', "<", 0)->exists();
    }

    /**
     * Get an attribute from the model.
     * Override original function to get meta value dynamically
     * @param string $key
     * @return mixed
     */
    public function getAttribute($key): mixed
    {
        $attribute = parent::getAttribute($key);

        if ($attribute === null && array_key_exists($key, $this->meta ?? [])) {
            return $this->meta[$key];
        }

        if ($attribute === null && array_key_exists($key, $this->plan_meta ?? [])) {
            return $this->plan_meta[$key];
        }

        return $attribute;
    }

}

