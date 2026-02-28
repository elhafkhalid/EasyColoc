<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Membership;
use App\Models\Colocation;
use Illuminate\Http\Request;
use App\Models\User;

class InvitationController extends Controller
{

    public function create(Colocation $colocation)
    {
        if (auth()->id() === $colocation->owner_id && $colocation->status === 'active') {
            return view('invitations.create', compact('colocation'));
        }
    }

    public function store(Request $request, Colocation $colocation)
    {

        if (auth()->id() === $colocation->owner_id && $colocation->status === 'active') {

            $validated = $request->validate([
                'email' => [
                    'required',
                    'email',
                    'exists:users,email',
                ],
            ]);

            $user = User::where('email', $validated['email'])->first();

            $isActiveColocation = Membership::where('user_id', $user->id)
                ->whereNull('left_at')
                ->exists();
            if ($isActiveColocation) {
                return back();
            }
            
            $isInvited = Invitation::where([
                // 'colocation_id' => $colocation->id,
                'email' => $validated['email'],
                'status' => 'pending',
            ]) -> exists();

            if($isInvited){
                return back();
            }
            
            Invitation::create([
                'colocation_id' => $colocation->id,
                'email' => $validated['email'],
                'invited_by' => auth()->id(),
                'status' => 'pending',
            ]);

            return back()->with('success', 'Invitation envoyée avec succès.');
        }
    }
}
