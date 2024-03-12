<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Achat extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    public function chauffeur(): BelongsTo
    {
        return $this->belongsTo(Worker::class, 'chauffeur_id');
    }

    public function achatitems(): HasMany
    {
        return $this->hasMany(AchatItem::class);
    }


    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($achat) {
            $achat->achatitems->each->delete();
        });
    }
}
