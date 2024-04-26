<?php

namespace App\Http\Controllers;

use App\Mail\ReservationConfirmed;
use App\Models\Court;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Illuminate\Support\Facades\Mail;


class ReservationController extends Controller
{
    public function index()
    {
        $courts = Court::all();
        return Inertia::render('Reservations/Index', ['courts' => $courts]);
    }

    public function create(Court $court)
    {
        $court_id = $court;

        return Inertia::render('Reservations/Create', [
            'isUser' => Gate::allows('isUser'),
            'court' => $court_id
        ]);
    }

    public function confirm($court_id, $start, $end) {
        $court = Court::findOrFail($court_id);

        return Inertia::render('Reservations/Confirm', [
            'court' => $court,
            'start_time' => $start,
            'end_time' => $end
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'court_id' => 'required|integer|exists:courts,id',
            'user_id' => 'required|integer|exists:users,id',
            'start_time' => 'required|date_format:Y-m-d H:i:s',
            'end_time' => 'required|date_format:Y-m-d H:i:s|after:start_time'
        ]);

        $reservation = Reservation::create($validatedData);
        $court = Court::find($validatedData['court_id']);

        //Send confirmation email
        Mail::to($request['user_email'])->send(new ReservationConfirmed($reservation));

        return response()->json(['message' => 'Rezerwacja potwierdzona', 'data' => $reservation], 200);
    }
}
