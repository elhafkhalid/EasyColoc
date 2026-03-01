<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Colocation;
use App\Models\Depense;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{
    public function index(){
        if(Auth::user()->role_id===1){
           $totalUsers = User::count();
           $Colocations = Colocation::where('status','active')->count();
           $totalDepenses = Depense::sum('amount');
           $bannedUsers = User::where('is_banned','true')->count();
           $users = User::get();

           return view('admin.dashboard',compact(
              'totalUsers',
              'Colocations',
              'totalDepenses',
              'bannedUsers',
              'users',
             ));
        }    
    }

    public function ban(User $user)
    {
        $user->is_banned = true;
        $user->save();
        
        return back()->with('success', 'user bani.');
    }

    public function unban(User $user)
    {
        $user->update([
            'is_banned' => false,
        ]);

        return back()->with('success', 'user debani.');
    }
}

