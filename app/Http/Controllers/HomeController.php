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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $name = Auth::user()->name;
        $email = Auth::user()->email;

        $boards = Title::with('user')
            ->where([['user_id', $user_id]])
            ->orderByDesc('created_at')
            ->get();
        // dd($users);

        $boardsGuess = Guess::with('board')
            ->where('guess', $email)
            ->get();

        // dd($boardsGuess);


        $cards = Card::with('board')
            ->get();

        return view('tasks.overview', compact('boards', 'cards', 'name', 'user_id', 'boardsGuess'));
    }

    
}
