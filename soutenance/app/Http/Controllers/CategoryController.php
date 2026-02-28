<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Colocation;
use Illuminate\Support\Facades\Auth;


class CategoryController extends Controller
{
    public function create(Colocation $colocation)
    {

        if (Auth::id() === $colocation->owner_id && $colocation->status === 'active') {
            $categories = $colocation->categories()->get();
            return view('categories.create', compact('colocation', 'categories'));
        }

        return back();
    }


    public function store(Request $request, Colocation $colocation)
    {

        if (Auth::id() === $colocation->owner_id && $colocation->status === 'active') {
            $validated = $request->validate([
                'name' => ['required','string','max:100'],
            ]);

            Category::create([
                'name' => $validated['name'],
                'colocation_id' => $colocation->id,
            ]);

            return redirect()->route('categories.create', $colocation)->with('success', 'categorie ajouter');
        }
    }
}
