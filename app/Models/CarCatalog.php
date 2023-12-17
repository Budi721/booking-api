<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CarCatalog extends Model
{
    protected $fillable = [
        'merk',
        'model',
        'plat_number',
        'price'
    ];

    public function booking(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
