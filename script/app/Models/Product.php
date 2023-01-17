<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "description",
        "price",
        "buyer_can_set_price",
        "file",
        "size",
        "cover",
        "return_url",
        "theme_color",
        "meta",
        "currency_id",
        "user_id",
    ];

    protected $casts = [
        'meta' => 'json',
    ];

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(ProductOrder::class);
    }

    public function scopeWithOrdersCount($query)
    {
        return $query->withCount('orders');
    }

    public function getMimeTypeAttribute()
    {
        $mimeType = false;
        if ($this->file) {
            $mimeType = \Storage::disk(config('filesystems.disks.s3.endpoint'))->mimeType($this->file);
        }

        return str($mimeType)->upper()->explode('/')[1] ?? null;
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

        return $attribute;
    }
}
