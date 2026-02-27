<?php

namespace App\Http\Controllers;

use App\Models\colocation;
use App\Models\Colocation as ModelsColocation;
use Illuminate\Http\Request;
use App\Models\Membership;
use Illuminate\Support\Facades\Auth;

class ColocationController extends Controller
{
    public function index()
    {
        $colocations = Auth::user()->colocations;
        return view('colocation.index', compact('colocations'));
    }

    public function create()
    {
        return view('colocation.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $hasActive = Membership::where('user_id', $request->user()->id)
            ->whereNull('left_at')
            ->exists();

        if ($hasActive){
            return back()->withErrors([
                'name' => 'colocation active',
            ]);
        }

        $colocation = Colocation::create([
            'name' => $request->name,
            'owner_id' => $request->user()->id,
            'status' => 'active',
        ]);

        Membership::create([
            'user_id' => $request->user()->id,
            'colocation_id' => $colocation->id,
            'role' => 'owner',
        ]);

        return redirect()->route('colocation.show', $colocation);
    }

    public function show(Colocation $colocation)
    {
        $colocation->load([
            'depenses.payeur',
            'depenses.category',
            'users'
        ]);
        return view('colocation.show', compact('colocation'));
    }

    public function cancel(Colocation $colocation)
    {
        $colocation->update([
            'status' => 'cancelled',
        ]);

        Membership::where('colocation_id', $colocation->id)->whereNull('left_at')->update(['left_at' => now()]);
        return redirect()->route('colocation.index')->with('success', 'colocation annulee');
    }
}
