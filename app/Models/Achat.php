<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Achat extends Model
{
    use HasFactory;

    public function chauffeur(): BelongsTo
    {
        return $this->belongsTo(Worker::class, 'chauffeur_id');
    }
}
