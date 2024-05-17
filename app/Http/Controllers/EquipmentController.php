<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class EquipmentController extends Controller
{
    public function index() {
        $equipments = Equipment::all();
        return Inertia::render('Equipments/Index', ['equipments' => $equipments]);
    }

    public function create()
    {
        return Inertia::render('Equipments/Create', [
            'isAdmin' => Gate::allows('isAdmin')
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'hourly_rate' => 'required|integer|min:1',
            'quantity' => 'required|integer|min:1'
        ]);

        Equipment::create($validatedData);

        return redirect()->route('equipments.index');
    }

    public function available(Request $request) {
        $start_date = $request->start_time;
        $end_date = $request->end_time;

        $equipments = Equipment::with(['reservations' => function($query) use ($start_date, $end_date) {
            $query->where(function ($query) use ($start_date, $end_date) {
                $query->whereBetween('start_time', [$start_date, $end_date])
                    ->orWhereBetween('end_time', [$start_date, $end_date])
                    ->orWhere(function ($query) use ($start_date, $end_date) {
                        $query->where('start_time', '<=', $start_date)
                            ->where('end_time', '>=', $end_date);
                    });
            });
        }])->get();

        $availableEquipments = $equipments->map(function ($equipment) {
            $reservedQuantity = $equipment->reservations->sum('pivot.quantity');
            $availableQuantity = $equipment->quantity - $reservedQuantity;

            return [
                'id' => $equipment->id,
                'name' => $equipment->name,
                'description' => $equipment->description,
                'hourly_rate' => $equipment->hourly_rate,
                'available_quantity' => $availableQuantity,
            ];
        });

        $availableEquipments = $availableEquipments->filter(function ($equipment) {
            return $equipment['available_quantity'] > 0;
        });

        return response()->json($availableEquipments->values());
    }
}
