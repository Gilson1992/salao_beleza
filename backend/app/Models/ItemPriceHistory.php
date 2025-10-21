<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemPriceHistory extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'item_price_histories';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'item_id',
        'old_price',
        'new_price',
        'changed_by',
        'changed_at',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'old_price' => 'decimal:2',
        'new_price' => 'decimal:2',
        'changed_at' => 'datetime',
    ];

    public $timestamps = false;

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
