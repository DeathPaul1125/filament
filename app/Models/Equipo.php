<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipo extends Model
{
    use HasFactory;

    public function UserAd(): HasMany
    {
        return $this->hasMany(UserAd::class);
    }
    public function software():HasMany
    {
        return $this->hasMany(Software::class);
    }
}
