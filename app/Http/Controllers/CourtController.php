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

    public function availableSlots(Request $request, Court $court)
    {

    }

    function generateAvailableSlots() {
//        // Zakładamy, że kort jest otwarty od 8:00 do 20:00
//        $openingTime = Carbon::parse("$selectedDate 08:00");
//        $closingTime = Carbon::parse("$selectedDate 20:00");
//
//        // Pobierz rezerwacje dla danego kortu i dnia
//        $reservations = Reservation::where('court_id', $courtId)
//            ->whereDate('start_time', $selectedDate)
//            ->get();
//
//        $slots = [];
//        $slotDuration = 60; // Długość slotu w minutach, np. 60 minut
//
//        // Iteruj przez godziny otwarcia i generuj sloty czasowe
//        for ($time = $openingTime; $time->addMinutes($slotDuration)->lessThanOrEqualTo($closingTime); ) {
//            $slotStart = $time->copy();
//            $slotEnd = $time->copy()->addMinutes($slotDuration);
//
//            // Sprawdź, czy slot koliduje z istniejącymi rezerwacjami
//            $isAvailable = true;
//            foreach ($reservations as $reservation) {
//                if ($slotStart->lt(new Carbon($reservation->end_time)) && $slotEnd->gt(new Carbon($reservation->start_time))) {
//                    $isAvailable = false;
//                    break;
//                }
//            }
//
//            if ($isAvailable) {
//                $slots[] = [
//                    'start' => $slotStart->toTimeString(),
//                    'end' => $slotEnd->toTimeString(),
//                ];
//            }
//
//            $time->addMinutes($slotDuration); // Przesuń czas o długość slotu
//        }

        return [1,2,3];
    }
}
