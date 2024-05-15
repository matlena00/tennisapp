<?php

namespace App\Models;

use App\Enums\ReservationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = ['court_id', 'start_time', 'end_time', 'user_id', 'status', 'total_price'];
    protected $casts = [
        'start_time' => 'datetime:Y-m-d H:i:s',
        'end_time' => 'datetime:Y-m-d H:i:s',
    ];

    protected $dates = ['start_time', 'end_time'];

    protected $attributes = [
        'status' => ReservationStatus::SCHEDULED
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function court() {
        return $this->belongsTo(Court::class);
    }

    public function equipments()
    {
        return $this->belongsToMany(Equipment::class, 'reservation_equipment')
            ->withPivot('quantity')
            ->withTimestamps();
    }
}
