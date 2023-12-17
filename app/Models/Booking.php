<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    protected $fillable = [
        'start_date',
        'end_date',
        'car_id'
    ];

    public function car(): HasOne
    {
        return $this->hasOne(CarCatalog::class);
    }
}
