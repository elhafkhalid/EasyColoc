<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Membership;
use App\Models\Colocation;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class InvitationController extends Controller {

    public function create(Colocation $colocation)
    {
        if (Auth::user()->id === $colocation->owner_id && $colocation->status === 'active') {
            return view('invitations.create', compact('colocation'));
        }
    }

    public function store(Request $request, Colocation $colocation){

        if (Auth::user()->id === $colocation->owner_id && $colocation->status === 'active') {

            $validated = $request->validate([
                'email' => [
                    'required',
                    'email',
                    'exists:users,email',
                ],
            ]);

            $user = User::where('email', $validated['email'])->first();

            $isActive = Membership::where('user_id', $user->id)
                ->whereNull('left_at')
                ->exists();

            if ($isActive) {
                return back();
            }

            $isInvited = Invitation::where([
                'colocation_id' => $colocation->id,
                'email' => $validated['email'],
                'status' => 'pending',
            ])->exists();

            if ($isInvited) {
                return back();
            }

            Invitation::create([
                'colocation_id' => $colocation->id,
                'email' => $validated['email'],
                'invited_by' => Auth::user()->id,
                'status' => 'pending',
            ]);

            return back()->with('success', 'invitation envoyée');
        }
    }

    public function index()
    {
        $invitations = Invitation::with('colocation')
            ->where('email', Auth::user()->email)
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('invitations.index', compact('invitations'));
    }

    public function accept(Invitation $invitation){

        $isActive = Membership::where('user_id', Auth::user()->id)
            ->whereNull('left_at')
            ->exists();
            
        if($isActive) return back();

        $colocation = $invitation->colocation;

        if ($invitation->email === Auth::user()->email){

            Membership::create([
                'user_id' => Auth::user()->id,
                'colocation_id' => $colocation->id,
                'role' => 'member',
                'join_at' => now(),
                'left_at' => null,
            ]);

            $invitation->update([
                'status' => 'accepted',
            ]);

            return redirect()->route('dashboard')->with('success', 'accepter');
        }
    }

    public function refuse(Invitation $invitation)
    {
        if ($invitation->email === Auth::user()->email) {
            $invitation->update([
                'status' => 'refused',
            ]);

            return back()->with('success', 'refusée');
        }
    }
}

