<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{

    public $incrementing = false;
    protected $keyType = 'string';

    use HasFactory;

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function leader(): BelongsTo
    {
        return $this->belongsTo(Worker::class);
    }


    public function orderitems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }


    // delete order items when an order is deleted (also because when every order item is deleted, the product stock quantity is restored)
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($order) {
            $order->orderitems->each->delete();
        });
    }
}
