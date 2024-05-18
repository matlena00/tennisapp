<?php

namespace App\Http\Controllers;

use App\Enums\ReservationStatus;
use App\Models\Court;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Reservation;
use Carbon\Carbon;

class DashboardController extends Controller
{
        public function index()
        {
            $now = Carbon::now('Europe/Warsaw');
            $user = Auth::getUser();

            $courts = Court::with(['reservations' => function ($query) use ($now) {
                $query->where('end_time', '>=', $now)
                    ->orderBy('start_time', 'asc');
            }])->get();

            $upcomingUsersReservations = Reservation::with(['user', 'court'])
                ->where('status', '=', ReservationStatus::SCHEDULED)
                ->where('start_time', '>', $now)
                ->orderBy('start_time', 'asc')
                ->limit(10)
                ->get();

            $courtsData = $courts->map(function ($court) use ($now) {
                $currentReservation = $court->reservations->first(function ($reservation) use ($now) {
                    $start = Carbon::createFromFormat('Y-m-d H:i:s', $reservation->start_time, 'Europe/Warsaw');
                    $end = Carbon::createFromFormat('Y-m-d H:i:s', $reservation->end_time, 'Europe/Warsaw');

                    return $start <= $now && $end >= $now;
                });

                $nextReservation = $court->reservations->first(function ($reservation) use ($now) {
                    return $reservation->start_time > $now;
                });

                return [
                    'id' => $court->id,
                    'name' => $court->name,
                    'surface' => $court->surface,
                    'currentReservation' => $currentReservation ? [
                        'user_name' => $currentReservation->user->name,
                        'start_time' => $currentReservation->start_time->toDateTimeString(),
                        'end_time' => $currentReservation->end_time->toDateTimeString(),
                    ] : null,
                    'nextReservation' => $nextReservation ? [
                        'name' => $nextReservation->user->name,
                        'start_time' => $nextReservation->start_time->toDateTimeString(),
                        'end_time' => $nextReservation->end_time->toDateTimeString(),
                    ] : null,
                ];
            });

            $allReservations = Reservation::with('court')
                ->where('user_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->get();

            $upcomingReservation = $allReservations
                ->where('start_time', '>', $now)
                ->where('status', '=', ReservationStatus::SCHEDULED)
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
                'user' => $user,
                'reservations' => $allReservations,
                'totalHours' => $totalHours,
                'upcomingReservation' => $upcomingReservation ? [
                    'date' => $upcomingReservation->start_time->format('Y-m-d'),
                    'start_time' => $upcomingReservation->start_time->format('H:i:s'),
                    'end_time' => $upcomingReservation->end_time->format('H:i:s'),
                    'court_name' => $upcomingReservation->court->name
                ] : null,
                'courtsData' => $courtsData,
                'upcomingUsersReservations' => $upcomingUsersReservations
            ]);
        }
}
