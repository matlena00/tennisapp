<?php

namespace App\Http\Controllers;

use App\Enums\ReservationStatus;
use App\Mail\ReservationConfirmed;
use App\Models\Court;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Illuminate\Support\Facades\Mail;


class ReservationController extends Controller
{
    public function index()
    {
        $user = Auth::getUser();
        $courts = Court::all();
        $reservations = Reservation::with(['user', 'court'])->get();

        return Inertia::render('Reservations/Index', [
            'user' => $user,
            'courts' => $courts,
            'reservations' => $reservations
        ]);
    }

    public function create(Court $court)
    {
        $court_id = $court;

        return Inertia::render('Reservations/Create', [
            'isUser' => Gate::allows('isUser'),
            'court' => $court_id
        ]);
    }

    public function edit(Reservation $reservation)
    {
        $reservation = Reservation::with('user')->find($reservation->id);
        return Inertia::render('Reservations/Edit', ['reservation' => $reservation]);
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
            'end_time' => 'required|date_format:Y-m-d H:i:s|after:start_time',
            'sometimes|string|in:' . implode(',', ReservationStatus::STATUSES),
            'equipment' => 'sometimes|array'
        ]);

        // Check if the reservation for the given data exists in the system
        $existingReservation = Reservation::where('court_id', $validatedData['court_id'])
            ->where('start_time', $validatedData['start_time'])
            ->where('end_time', $validatedData['end_time'])
            ->exists();

        if ($existingReservation) {
            return redirect()->back()->with('error', 'Rezerwacja na ten czas już istnieje.');
        }

        $reservation = Reservation::create($validatedData);

        if (isset($validatedData['equipment']) && !empty($validatedData['equipment'])) {
            foreach ($validatedData['equipment'] as $equipmentData) {
                $reservation->equipments()->attach($equipmentData['id'], ['quantity' => $equipmentData['quantity']]);
            }
        }

        //Send confirmation email
        try {
            Mail::to($request['user_email'])->send(new ReservationConfirmed($reservation));
        } catch (\Exception $e) {
            Log::error('Wysyłanie maila nie powiodło się: ' . $e->getMessage());
        }

        return redirect()->route('dashboard');
    }

    public function cancel($id)
    {
        $reservation = Reservation::findOrFail($id);
        $startDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $reservation->start_time);
        $today = Carbon::today();

        if ($startDateTime->gt($today)) {
            $reservation->status = ReservationStatus::CANCELED;
            $reservation->save();
            return redirect()->route('dashboard')->with('success', 'Rezerwacja została anulowana.');
        } else {
            return redirect()->route('dashboard')->withErrors('Nie można anulować rezerwacji w dniu jej rozpoczęcia.');
        }
    }

    public function myReservations()
    {
        $user = Auth::user();
        $reservations = $user->reservations()->with(['court', 'user'])->get();

        return Inertia::render('Reservations/MyReservations', [
            'reservations' => $reservations
        ]);
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return redirect()->route('dashboard');
    }
}
