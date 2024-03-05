<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Worker extends Model
{
    use HasFactory;


    public $incrementing = false;
    protected $keyType = 'string';

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'leader_id');
    }
}
