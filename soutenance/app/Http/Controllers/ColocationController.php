<?php

namespace App\Http\Controllers;

use App\Models\colocation;
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

        $hasActive = Membership::where('user_id', $request->user()->id)->whereNull('left_at')->exists();

        if ($hasActive) return back();

        $colocation = colocation::create([
            'name' => $request->name,
            'owner_id' => Auth::user()->id,
            'status' => 'active'
        ]);

        Membership::create([
            'user_id' => Auth::user()->id,
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

    public function cancel(Colocation $colocation){
        if (Auth::user()->id === $colocation->owner_id) {
            $colocation->update([
                'status' => 'cancelled',
            ]);

            Membership::where('colocation_id', $colocation->id)->whereNull('left_at')->update(['left_at' => now()]);

            return redirect()->route('colocation.index')->with('success','colocation annulle');
        }
    }
}
