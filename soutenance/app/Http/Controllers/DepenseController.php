<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\Colocation;
use App\Models\Depense;

class DepenseController extends Controller
{

    public function create(Colocation $colocation){
        $isMember = $colocation->users()
            ->where('users.id', auth()->id())
            ->whereNull('memberships.left_at')
            ->exists();

        if ($isMember && $colocation->status === 'active') {
            $members = $colocation->users;
            $categories = $colocation->categories;
            return view('depenses.create', compact(
                'colocation',
                'members',
                'categories'
            ));
        }
    }

    public function store(Request $request, Colocation $colocation)
    {
        $isMember = $colocation->users()
            ->where('users.id', Auth::id())
            ->whereNull('memberships.left_at')
            ->exists();

        if ($isMember || $colocation->status === 'active') {
            $validated = $request->validate([
                'titre' => ['required', 'string', 'max:255'],
                'amount' => ['required', 'numeric', 'min:0.01'],
                'date' => ['required', 'date'],
                'category_id' => [
                    'required',
                    Rule::exists('categories', 'id')
                        ->where('colocation_id', $colocation->id),
                ],
                'payeur_id' => [
                    'required',
                    Rule::exists('memberships', 'user_id')
                        ->where('colocation_id', $colocation->id)
                        ->whereNull('left_at'),
                ],
            ]);
            Depense::create([
                'colocation_id' => $colocation->id,
                'titre' => $validated['titre'],
                'amount' => $validated['amount'],
                'date' => $validated['date'],
                'category_id' => $validated['category_id'],
                'payeur_id' => $validated['payeur_id'],
            ]);

            return redirect()
                ->route('colocation.show', $colocation)
                ->with('success', 'Dépense ajoutée avec succès.');
        }
    }
}
