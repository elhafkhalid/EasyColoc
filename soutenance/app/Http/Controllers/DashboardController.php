<?php

namespace App\Http\Controllers;

use App\Models\Depense;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $colocation = $user->colocations()->where('colocations.status', 'active')->with('users')->first();
        $totalDepenses = $colocation ? $colocation->depenses()->sum('amount') : 0;
        $recentDepenses = $colocation? $colocation->depenses()->latest()->take(3)->get() : collect();
        return view('dashboard', compact(
            'totalDepenses',
            'colocation',
            'recentDepenses'
        ));
    }
}
