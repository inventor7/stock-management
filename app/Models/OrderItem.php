<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    public function worker(): BelongsTo
    {
        return $this->belongsTo(Worker::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }


    // restore stock quantity when an order item is deleted
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($order) {
            $order->product->increment('stockQty', $order->quantity);
        });
    }
}
