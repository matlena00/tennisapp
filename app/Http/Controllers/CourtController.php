<?php

namespace App\Http\Controllers;

use App\Models\Court;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class CourtController extends Controller
{
    public function index() {
        $courts = Court::all();
        return Inertia::render('Courts/Index', ['courts' => $courts]);
    }

    public function create()
    {
        return Inertia::render('Courts/Create', [
            'isAdmin' => Gate::allows('isAdmin')
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'sometimes|max:1000',
            'surface' => 'required',
            'hourly_rate' => 'required|integer|min:1',
            'opening_time' => 'required|date_format:H:i',
            'closing_time' => 'required|date_format:H:i|after:opening_time'
        ]);

        $court = Court::create($validatedData);

        return redirect()->route('courts.index');
    }

    public function show(Court $court)
    {
        return $court;
    }

    public function edit(Court $court)
    {
        return Inertia::render('Courts/Edit', ['court' => $court]);
    }

    public function update(Request $request, Court $court)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'sometimes|max:1000',
            'surface' => 'required',
            'hourly_rate' => 'required',
            'opening_time' => 'required',
            'closing_time' => 'required'
        ]);

        $court->update($validatedData);

        return redirect()->route('courts.index');
    }

    public function destroy(Court $court)
    {
        $court->delete();

        return redirect()->route('courts.index');
    }

    public function slots(Request $request, Court $court)
    {
        $openingHour = Carbon::createFromFormat('H:i:s', $court->opening_time)->hour;
        $closingHour = Carbon::createFromFormat('H:i:s', $court->closing_time)->hour;

        $startPeriod = now();
        $endPeriod = now()->addWeeks(2);
        $events = [];

        $existingReservations = $court->reservations()->whereBetween('start_time', [$startPeriod, $endPeriod])->get();

        foreach ($existingReservations as $reservation) {
            $events[] = [
                'title' => 'Zajęte',
                'start' => $reservation->start_time,
                'end' => $reservation->end_time,
                'backgroundColor' => '#ff0000',
                'borderColor' => '#ff0000',
            ];
        }

        return response()->json($events);
    }
}
