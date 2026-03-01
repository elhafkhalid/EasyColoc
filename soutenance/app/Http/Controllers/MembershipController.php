<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Depense;
use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class MembershipController extends Controller
{
    public function quitter(Colocation $colocation)
    {
        $userId = Auth::user()->id;
        if ($userId !== $colocation->owner_id) {
            DB::transaction(function () use ($userId, $colocation) {
                $memberCount = Membership::where('colocation_id', $colocation->id)
                    ->whereNull('left_at')
                    ->count();

                $total = Depense::where('colocation_id', $colocation->id)->sum('amount');

                $paidUser = Depense::where('colocation_id', $colocation->id)
                    ->where('payeur_id', $userId)
                    ->sum('amount');

                $share = $memberCount ? ($total / $memberCount) : 0;

                $dept = ($paidUser - $share) >= 0;

                Membership::where('colocation_id', $colocation->id)
                    ->where('user_id', $userId)
                    ->update(['left_at' => now()]);

                Auth::user()->increment('reputation_score', $dept ? +1 : -1);
            });

            return redirect()->route('dashboard');
        } else {
            return back();
        }
    }
}
