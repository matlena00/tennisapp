<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'hourly_rate', 'quantity', 'available'];

    public function reservations() {
        return $this->hasMany(Reservation::class);
    }

}
