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
        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        $email = Auth::user()->email;

        $boardsGuess = Guess::with('board')
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


        $auth = Auth::user()->id;

        $board = User::find($auth);
        $board->name = $request->name;
        $board->email = $request->email;
        $board->password = Hash::make($request->password);

        $board->save();

        return redirect()->back()
            ->with('success', "Your profile has been updated!");
    }
}
