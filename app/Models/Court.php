<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Court extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'surface',
        'available',
        'opening_time',
        'closing_time'
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
