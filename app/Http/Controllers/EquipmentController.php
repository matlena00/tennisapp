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

        $availableEquipments = Equipment::whereDoesntHave('reservation', function ($query) use ($start_date, $end_date) {
            $query->whereBetween('start_time', [$start_date, $end_date])
                ->orWhereBetween('end_time', [$start_date, $end_date]);
        })->get();

        return response()->json($availableEquipments);
    }
}
