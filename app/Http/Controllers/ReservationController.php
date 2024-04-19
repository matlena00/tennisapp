<?php

namespace App\Http\Controllers;

use App\Models\Court;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

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
}
