<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserPlanSubscriber extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function orders(): HasMany
    {
        return $this->hasMany(UserPlanOrder::class, 'subscriber_id', 'id');
    }
}
