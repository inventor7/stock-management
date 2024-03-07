<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class BonAcompte extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';


    public function acomptes(): HasMany
    {
        return $this->hasMany(Acompte::class);
    }
}
