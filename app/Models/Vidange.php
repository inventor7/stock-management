<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vidange extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    public function véhicule(): BelongsTo
    {
        return $this->belongsTo(Véhicule::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($vidange) {
            $véhicule = $vidange->véhicule;
            $véhicule->update(['kilometrage' => $vidange->ancien_km]);
        });
    }
}
