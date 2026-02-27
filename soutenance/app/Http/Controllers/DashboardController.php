<?php

namespace App\Http\Controllers;
use App\Models\Depense;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $totalDepenses = Depense::sum('amount');
        $colocation = $user->colocations()->where('colocations.status','active')->with('users')->first();
        $recentDepenses = Depense::latest()->take(5)->get();
        return view('dashboard', compact(
            'totalDepenses',
            'colocation',
            'recentDepenses'
        ));
    }
}

