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
        $user_id = Auth::user()->id; //récupération de l'id de l'utilisateur connecté

        $cards = Card::with('board')
            ->get();

        $validated = $request->validate([
            'comment' => 'required|string',
        ], [
            'comment.required' => "Oops, you're trying to send an empty comment."
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
