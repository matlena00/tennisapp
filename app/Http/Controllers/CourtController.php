<?php

namespace App\Http\Controllers;

use App\Models\Court;
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
}
