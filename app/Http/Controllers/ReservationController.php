<?php

namespace App\Http\Controllers;

use App\Enums\ReservationStatus;
use App\Mail\ReservationCanceled;
use App\Mail\ReservationConfirmed;
use App\Models\Court;
use App\Models\Equipment;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

    public function confirm($court_id, $start, $end, $total_price) {
        $court = Court::findOrFail($court_id);

        return Inertia::render('Reservations/Confirm', [
            'court' => $court,
            'start_time' => $start,
            'end_time' => $end,
            'total_price' => $total_price
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'court_id' => 'required|integer|exists:courts,id',
            'user_id' => 'required|integer|exists:users,id',
            'start_time' => 'required|date_format:Y-m-d H:i:s',
            'end_time' => 'required|date_format:Y-m-d H:i:s|after:start_time',
            'status' => 'sometimes|string|in:' . implode(',', ReservationStatus::STATUSES),
            'equipment' => 'sometimes|array',
            'total_price' => 'required|numeric|min:0'
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

        return $reservation;
    }

    public function cancel($id)
    {
        $reservation = Reservation::findOrFail($id);
        $startDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $reservation->start_time);
        $today = Carbon::today();

        if ($startDateTime->gt($today)) {
            $reservation->equipments()->detach();

            $reservation->status = ReservationStatus::CANCELED;
            $reservation->save();

            // Send cancellation email
            try {
                Mail::to($reservation->user->email)->send(new ReservationCanceled($reservation));
            } catch (\Exception $e) {
                Log::error('Wysyłanie maila nie powiodło się: ' . $e->getMessage());
            }

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

    public function showEquipment()
    {
        $equipment = Equipment::all();
        return Inertia::render('Reservations/ShowEquipment', [
            'equipment' => $equipment,
        ]);
    }

    public function selectReservation()
    {
        $user = auth()->user();
        $futureReservations = Reservation::where('user_id', $user->id)
            ->where('start_time', '>', now())
            ->where('status', '=', ReservationStatus::SCHEDULED)
            ->with('court')
            ->get();

        return Inertia::render('Reservations/AddEquipmentToReservation', [
            'reservations' => $futureReservations
        ]);
    }

    public function showEquipmentForm($id)
    {
        $reservation = Reservation::with('court')->findOrFail($id);
        $start_time = $reservation->start_time;
        $end_time = $reservation->end_time;

        $allEquipment = Equipment::all();

        $overlappingReservations = DB::table('reservation_equipment')
            ->join('reservations', 'reservation_equipment.reservation_id', '=', 'reservations.id')
            ->where(function ($query) use ($start_time, $end_time) {
                $query->where('reservations.start_time', '<', $end_time)
                    ->where('reservations.end_time', '>', $start_time);
            })
            ->select('reservation_equipment.equipment_id', 'reservation_equipment.quantity')
            ->get();

        $equipmentQuantities = $overlappingReservations->groupBy('equipment_id')->map(function ($group) {
            return $group->sum('quantity');
        });

        $availableEquipment = $allEquipment->map(function ($equipment) use ($equipmentQuantities) {
            $reservedQuantity = $equipmentQuantities->get($equipment->id, 0);
            $availableQuantity = $equipment->quantity - $reservedQuantity;

            return [
                'id' => $equipment->id,
                'name' => $equipment->name,
                'description' => $equipment->description,
                'hourly_rate' => $equipment->hourly_rate,
                'total_quantity' => $equipment->quantity,
                'available_quantity' => $availableQuantity,
            ];
        });

        return Inertia::render('Reservations/AddEquipmentForm', [
            'reservation' => $reservation,
            'equipment' => $availableEquipment->values(),
        ]);
    }

    public function storeEquipment(Request $request, $id)
    {
        $validatedData = $request->validate([
            'equipment' => 'required|array',
            'equipment.*.id' => 'required|integer|exists:equipment,id',
            'equipment.*.quantity' => 'required|integer|min:1',
        ]);

        $reservation = Reservation::findOrFail($id);

        foreach ($validatedData['equipment'] as $equipmentData) {
            $reservation->equipments()->attach($equipmentData['id'], ['quantity' => $equipmentData['quantity']]);
        }

        return redirect()->route('dashboard')->with('success', 'Sprzęt został dodany do rezerwacji.');
    }
}
