<?php

namespace App\Http\Controllers;

use App\Models\Fish;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FishController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        if ($search) {
            $fish = Fish::where('name', 'like', '%' . $search . '%')->get();
        } else {
            $fish = Fish::all();
        }
        
        return view('fish.index', compact('fish', 'search'));
    }

    public function show(Fish $fish)
    {
        $comments = $fish->comments()->with('user')->get();
        return view('fish.show', compact('fish', 'comments'));
    }

    public function storeComment(Request $request, Fish $fish)
    {
        $request->validate([
            'comment' => 'required|string|max:500',
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'fish_id' => $fish->id,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Comment added successfully.');
    }
}
