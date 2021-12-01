<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Guess;
use App\Models\Title;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user_id = Auth::user()->id; //récupération de l'id de l'utilisateur connecté
        $name = Auth::user()->name; //récupération du nom de l'utilisateur connecté
        $email = Auth::user()->email; //récupération du mail de l'utilisateur connecté

        $boards = Title::with('user.card') // requete de la table title et user en relation
            ->where('user_id', $user_id)
            ->orderByDesc('created_at')
            ->get();

        $boardsGuess = Guess::with('board.user') //requete de la table guess en relation avec la table title et user
            ->where('guess', $email)
            ->get();

        $cards = Card::with('board') //requete de la table card en relation avec la table title
            ->get();

        return view('tasks.overview', compact('boards', 'cards', 'name', 'user_id', 'boardsGuess'));
    }
}
