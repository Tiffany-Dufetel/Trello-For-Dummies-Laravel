<?php

namespace App\Http\Controllers;

use App\Models\Guess;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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

    public function index()
    {
        $user_id = Auth::user()->id; //récupération de l'id de l'utilisateur connecté
        $email = Auth::user()->email; //récupération du mail de l'utilisateur connecté

        $user = User::find($user_id);

        $boardsGuess = Guess::with('board') //requete du tableau guess en relation avec board
            ->where('user_id', $user_id)
            ->get();

        return view('profile', compact('user', 'boardsGuess'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $auth = Auth::user()->id; //récupération de l'id de l'utilisateur

        $board = User::find($auth);
        $board->name = $request->name;
        $board->email = $request->email;
        $board->password = Hash::make($request->password);

        $board->save();

        return redirect()->back()
            ->with('success', "Your profile has been updated!");
    }
}
