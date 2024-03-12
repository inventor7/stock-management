<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AchatItem extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function achat(): BelongsTo
    {
        return $this->belongsTo(Achat::class);
    }


    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($achatItem) {
            $achatItem->product->increment('stockQty', $achatItem->quantity);
        });
    }
}
