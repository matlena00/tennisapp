<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Reservation;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with('court')->where('user_id', auth()->id())->get();
        $totalHours = $reservations->reduce(function ($carry, $reservation) {
            $start = Carbon::parse($reservation->start_time);
            $end = Carbon::parse($reservation->end_time);
            $hours = $end->diffInHours($start);
            return $carry + $hours;
        }, 0);

        return Inertia::render('Dashboard', [
            'reservations' => $reservations,
            'totalHours' => $totalHours
        ]);
    }
}
