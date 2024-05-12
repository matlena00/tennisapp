<?php

namespace App\Enums;

class ReservationStatus
{
    const SCHEDULED = 'scheduled';
    const CANCELED = 'canceled';
    const COMPLETED = 'completed';

    const STATUSES = [
        self::SCHEDULED,
        self::CANCELED,
        self::COMPLETED
    ];
}
