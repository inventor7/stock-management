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
}
