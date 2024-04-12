<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Achat extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    public function chauffeur(): HasOne
    {
        return $this->hasOne(Worker::class, 'id', 'chauffeur_id');
    }

    public function achatitems(): HasMany
    {
        return $this->hasMany(AchatItem::class);
    }

    public function fournisseur(): HasOne
    {
        return $this->hasOne(Fournisseur::class, 'id', 'fournisseur_id');
    }



    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($achat) {
            $achat->achatitems->each->delete();
        });
    }
}
