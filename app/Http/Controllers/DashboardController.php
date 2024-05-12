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
            $now = Carbon::now('Europe/Warsaw');

            $allReservations = Reservation::with('court')
                ->where('user_id', auth()->id())
                ->get();

            $upcomingReservation = $allReservations
                ->where('start_time', '>', $now)
                ->sortBy('start_time')
                ->first();

            $completedReservations = $allReservations->filter(function ($reservation) use ($now) {
                return $reservation->end_time <= $now;
            });

            $totalHours = $completedReservations->reduce(function ($carry, $reservation) {
                $start = Carbon::createFromFormat('Y-m-d H:i:s', $reservation->start_time, 'Europe/Warsaw');
                $end = Carbon::createFromFormat('Y-m-d H:i:s', $reservation->end_time, 'Europe/Warsaw');
                $hours = $end->diffInHours($start);
                return $carry + $hours;
            }, 0);

            return Inertia::render('Dashboard', [
                'reservations' => $allReservations,
                'totalHours' => $totalHours,
                'upcomingReservation' => $upcomingReservation ? [
                    'date' => $upcomingReservation->start_time->format('Y-m-d'),
                    'start_time' => $upcomingReservation->start_time->format('H:i:s'),
                    'end_time' => $upcomingReservation->end_time->format('H:i:s'),
                    'court_name' => $upcomingReservation->court->name
                ] : null
            ]);
        }
}
