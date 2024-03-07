<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  Illuminate\Database\Eloquent\Relations\BelongsTo;

class Acompte extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    public function bonAcompte(): BelongsTo
    {
        return $this->belongsTo(BonAcompte::class);
    }

    public function worker(): BelongsTo
    {
        return $this->belongsTo(Worker::class);
    }
}
