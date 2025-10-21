<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Item extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
        'unit',
        'stock_quantity',
        'minimum_stock',
        'is_active',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'stock_quantity' => 'integer',
        'minimum_stock' => 'integer',
    ];

    public function prices(): HasMany
    {
        return $this->hasMany(ItemPrice::class);
    }

    public function currentPrice(): HasOne
    {
        return $this->hasOne(ItemPrice::class)->latestOfMany('starts_at');
    }

    public function priceHistories(): HasMany
    {
        return $this->hasMany(ItemPriceHistory::class);
    }
}
