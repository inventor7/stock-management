<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class véhicule extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';


    public function controle_techniques(): HasMany
    {
        return $this->hasMany(ControleTechnique::class);
    }

    public function vidange(): HasMany
    {
        return $this->hasMany(Vidange::class);
    }

    public function chauffeur()
    {
        return $this->belongsTo(Worker::class);
    }
}
