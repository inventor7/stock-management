<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BonDAchat extends Model
{
    use HasFactory;

    public function achat(): BelongsTo
    {
        return $this->belongsTo(Achat::class, 'bon_d_achats_id');
    }
}
