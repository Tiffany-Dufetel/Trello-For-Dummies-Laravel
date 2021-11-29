<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Comment;
use App\Models\Title;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;

        $cards = Card::with('board')
            ->get();

        $validated = $request->validate([
            'comment' => 'required|string',
        ]);

        $comment = [
            'content' => $request->comment,
            'id_user' => $user_id,
            'id_card' => $request->id_card,
        ];

        Comment::create($comment);

        return redirect()->back()
            ->with('success', "Your comment has been sent!");

        
    }
}
