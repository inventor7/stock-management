<?php

namespace App\Models;

use App\Models\Achat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fournisseur extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    public function achats(): BelongsTo
    {
        return $this->belongsTo(Achat::class);
    }
}
